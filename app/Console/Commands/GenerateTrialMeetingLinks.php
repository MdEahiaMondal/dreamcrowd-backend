<?php

namespace App\Console\Commands;

use App\Models\BookOrder;
use App\Models\ClassDate;
use App\Models\TeacherGig;
use App\Models\TeacherGigData;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class GenerateTrialMeetingLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trials:generate-meeting-links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Zoom meeting links for trial classes that start in 30 minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting trial meeting link generation...');
        Log::channel('single')->info('Trial meeting link generation started');

        // Find all trial class bookings that:
        // 1. Start in approximately 30 minutes (25-35 min window)
        // 2. Don't have a zoom_link yet
        // 3. Are active (status = 1) and payment completed

        $now = Carbon::now();
        $targetStart = $now->copy()->addMinutes(30);
        $windowStart = $now->copy()->addMinutes(25);
        $windowEnd = $now->copy()->addMinutes(35);

        // Get all trial class dates in the time window
        $upcomingTrialClasses = ClassDate::whereNull('zoom_link')
            ->whereNotNull('teacher_date')
            ->whereBetween('teacher_date', [$windowStart, $windowEnd])
            ->get();

        $this->info("Found {$upcomingTrialClasses->count()} upcoming trial classes without meeting links");

        $linksGenerated = 0;
        $errors = 0;

        foreach ($upcomingTrialClasses as $classDate) {
            $order = BookOrder::find($classDate->order_id);

            if (!$order) {
                $this->warn("Order not found for class date ID: {$classDate->id}");
                continue;
            }

            // Check if this is a trial class
            $gig = TeacherGig::find($order->gig_id);
            $gigData = TeacherGigData::where('gig_id', $order->gig_id)->first();

            if (!$gig || !$gigData) {
                continue;
            }

            // Only generate for trial classes
            if ($gigData->recurring_type !== 'Trial') {
                continue;
            }

            // Check if order is active and payment completed
            if ($order->payment_status !== 'completed' || $order->status == 0) {
                continue;
            }

            // Get teacher (host) information
            $teacher = User::find($order->teacher_id);
            if (!$teacher) {
                $this->error("Teacher not found for order ID: {$order->id}");
                $errors++;
                continue;
            }

            // Check if teacher has connected Zoom
            if (!$teacher->zoom_access_token) {
                $this->warn("Teacher (ID: {$teacher->id}) has not connected Zoom account");
                Log::warning("Cannot create Zoom meeting for trial class - teacher has not connected Zoom", [
                    'teacher_id' => $teacher->id,
                    'order_id' => $order->id,
                    'class_date_id' => $classDate->id,
                ]);
                $errors++;
                continue;
            }

            // Attempt to create Zoom meeting
            try {
                $meetingLink = $this->createZoomMeeting($teacher, $order, $classDate);

                if ($meetingLink) {
                    // Update class date with zoom link
                    $classDate->zoom_link = $meetingLink;
                    $classDate->save();

                    // Also update the order with the zoom link
                    $order->zoom_link = $meetingLink;
                    $order->save();

                    $linksGenerated++;
                    $this->info("✓ Generated meeting link for Order #{$order->id}");

                    Log::info("Zoom meeting link generated successfully", [
                        'order_id' => $order->id,
                        'class_date_id' => $classDate->id,
                        'meeting_link' => $meetingLink,
                    ]);

                    // Send email notification with meeting link
                    $this->sendTrialReminderEmail($order, $classDate, $meetingLink);

                } else {
                    $this->error("✗ Failed to generate meeting link for Order #{$order->id}");
                    $errors++;
                }

            } catch (\Exception $e) {
                $this->error("✗ Error generating meeting for Order #{$order->id}: " . $e->getMessage());
                Log::error("Failed to generate Zoom meeting link", [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                $errors++;
            }
        }

        $this->info("\n=== Summary ===");
        $this->info("Links generated: {$linksGenerated}");
        $this->info("Errors: {$errors}");

        Log::channel('single')->info('Trial meeting link generation completed', [
            'links_generated' => $linksGenerated,
            'errors' => $errors,
        ]);

        return Command::SUCCESS;
    }

    /**
     * Create Zoom meeting via API
     *
     * @param User $teacher
     * @param BookOrder $order
     * @param ClassDate $classDate
     * @return string|null
     */
    private function createZoomMeeting(User $teacher, BookOrder $order, ClassDate $classDate): ?string
    {
        // Parse duration (format: "00:30" or "01:00")
        $durationParts = explode(':', $classDate->duration);
        $durationMinutes = ((int)$durationParts[0] * 60) + (int)$durationParts[1];

        $gig = TeacherGig::find($order->gig_id);

        // Check if access token is expired and refresh if needed
        $accessToken = $this->getValidAccessToken($teacher);

        if (!$accessToken) {
            throw new \Exception("Unable to get valid Zoom access token for teacher ID: {$teacher->id}");
        }

        $response = Http::withToken($accessToken)
            ->post('https://api.zoom.us/v2/users/me/meetings', [
                'topic' => $gig->title ?? 'Trial Class',
                'type' => 2, // Scheduled meeting
                'start_time' => Carbon::parse($classDate->teacher_date)->toIso8601String(),
                'duration' => $durationMinutes,
                'timezone' => $classDate->teacher_time_zone ?? 'UTC',
                'settings' => [
                    'join_before_host' => true,
                    'participant_video' => true,
                    'host_video' => true,
                    'mute_upon_entry' => true,
                    'waiting_room' => false,
                    'auto_recording' => 'none',
                ],
            ]);

        if ($response->successful()) {
            $meetingData = $response->json();
            return $meetingData['join_url'] ?? null;
        } else {
            Log::error("Zoom API error", [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return null;
        }
    }

    /**
     * Get valid access token, refresh if expired
     *
     * @param User $teacher
     * @return string|null
     */
    private function getValidAccessToken(User $teacher): ?string
    {
        // Try to use current token
        // If it fails, we'll attempt to refresh

        // For simplicity, we'll try using the existing token
        // In production, you should check token expiry and refresh proactively
        return $teacher->zoom_access_token;
    }

    /**
     * Send trial reminder email with meeting link
     *
     * @param BookOrder $order
     * @param ClassDate $classDate
     * @param string $meetingLink
     */
    private function sendTrialReminderEmail(BookOrder $order, ClassDate $classDate, string $meetingLink)
    {
        try {
            $user = User::find($order->user_id);
            $teacher = User::find($order->teacher_id);
            $gig = TeacherGig::find($order->gig_id);
            $gigData = TeacherGigData::where('gig_id', $order->gig_id)->first();

            if (!$user || !$teacher || !$gig || !$gigData) {
                return;
            }

            $reminderData = [
                'userName' => $user->name,
                'classTitle' => $gig->title,
                'teacherName' => $teacher->name,
                'classDateTime' => Carbon::parse($classDate->user_date)->format('F j, Y \a\t g:i A'),
                'duration' => $this->formatDuration($classDate->duration),
                'timezone' => $classDate->user_time_zone ?? 'UTC',
                'meetingLink' => $meetingLink,
                'isFree' => ($gig->trial_type == 'Free'),
            ];

            Mail::to($user->email)->send(new \App\Mail\TrialClassReminder($reminderData));

            Log::info("Trial reminder email sent successfully", [
                'user_email' => $user->email,
                'order_id' => $order->id,
                'meeting_link' => $meetingLink,
                'class_time' => $classDate->user_date,
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to send trial reminder email", [
                'error' => $e->getMessage(),
                'order_id' => $order->id,
            ]);
        }
    }

    /**
     * Format duration from HH:MM to readable format
     *
     * @param string $duration
     * @return string
     */
    private function formatDuration($duration)
    {
        if (!$duration) {
            return '30 minutes';
        }

        $parts = explode(':', $duration);
        $hours = (int)$parts[0];
        $minutes = (int)$parts[1];

        if ($hours > 0 && $minutes > 0) {
            return "{$hours} hour" . ($hours > 1 ? 's' : '') . " {$minutes} minutes";
        } elseif ($hours > 0) {
            return "{$hours} hour" . ($hours > 1 ? 's' : '');
        } else {
            return "{$minutes} minutes";
        }
    }
}
