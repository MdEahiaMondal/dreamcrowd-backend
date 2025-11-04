<?php

namespace App\Console\Commands;

use App\Models\ClassDate;
use App\Models\BookOrder;
use App\Models\User;
use App\Models\ZoomMeeting;
use App\Models\ZoomSecureToken;
use App\Services\ZoomMeetingService;
use App\Mail\ClassStartReminder;
use App\Mail\GuestClassInvitation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class GenerateZoomMeetings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zoom:generate-meetings {--dry-run : Run without creating meetings}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Zoom meetings and secure tokens for classes starting in 30 minutes';

    protected $zoomMeetingService;

    public function __construct(ZoomMeetingService $zoomMeetingService)
    {
        parent::__construct();
        $this->zoomMeetingService = $zoomMeetingService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->info('Running in DRY RUN mode - no meetings will be created');
        }

        $this->info('Starting Zoom meeting generation...');
        Log::info('Zoom meeting generation started');

        $now = Carbon::now();
        $windowStart = $now->copy()->addMinutes(25);
        $windowEnd = $now->copy()->addMinutes(35);

        // Find all class dates that:
        // 1. Start in 25-35 minutes
        // 2. Don't have a Zoom meeting created yet
        // 3. Have an active order

        $upcomingClasses = ClassDate::whereNotNull('teacher_date')
            ->whereBetween('teacher_date', [$windowStart, $windowEnd])
            ->whereDoesntHave('zoomMeeting')
            ->with(['bookOrder.teacher', 'bookOrder'])
            ->get();

        $this->info("Found {$upcomingClasses->count()} upcoming classes without Zoom meetings");

        $successCount = 0;
        $errorCount = 0;
        $skippedCount = 0;

        foreach ($upcomingClasses as $classDate) {
            $order = $classDate->bookOrder;

            if (!$order) {
                $this->warn("Order not found for class date ID: {$classDate->id}");
                $skippedCount++;
                continue;
            }

            // Check if order is active
            if ($order->status == 0) {
                $this->warn("Order {$order->id} is not active (status=0)");
                $skippedCount++;
                continue;
            }

            $teacher = $order->teacher;

            if (!$teacher) {
                $this->error("Teacher not found for order ID: {$order->id}");
                $errorCount++;
                continue;
            }

            // Check if teacher has connected Zoom
            if (!$teacher->hasZoomConnected()) {
                $this->warn("Teacher {$teacher->first_name} {$teacher->last_name} (ID: {$teacher->id}) has not connected Zoom");
                $skippedCount++;
                continue;
            }

            $this->line("Processing class for order #{$order->id} - Teacher: {$teacher->first_name} {$teacher->last_name}");

            if ($dryRun) {
                $this->info("  [DRY RUN] Would create meeting for class date {$classDate->id}");
                continue;
            }

            try {
                // Parse duration from class date
                $duration = 60; // Default
                if ($classDate->duration) {
                    // Duration format is "HH:MM"
                    $parts = explode(':', $classDate->duration);
                    if (count($parts) == 2) {
                        $duration = (int)$parts[0] * 60 + (int)$parts[1];
                    }
                }

                // Prepare meeting data
                $meetingData = [
                    'topic' => $order->title ?? 'Live Class',
                    'type' => 2, // Scheduled meeting
                    'start_time' => $classDate->teacher_date->toIso8601String(),
                    'duration' => $duration,
                    'timezone' => $classDate->teacher_time_zone ?? 'Asia/Dhaka',
                    'host_video' => true,
                    'participant_video' => true,
                    'join_before_host' => false,
                    'mute_upon_entry' => true,
                    'waiting_room' => false,
                ];

                // Create Zoom meeting via API
                $zoomResponse = $this->zoomMeetingService->createMeeting($teacher, $meetingData);

                if (!$zoomResponse) {
                    $this->error("  Failed to create Zoom meeting via API");
                    $errorCount++;
                    continue;
                }

                // Store meeting in database
                $meeting = $this->zoomMeetingService->storeMeeting(
                    $zoomResponse,
                    $teacher->id,
                    $order->id,
                    $classDate->id
                );

                if (!$meeting) {
                    $this->error("  Failed to store meeting in database");
                    $errorCount++;
                    continue;
                }

                // Generate secure token for the buyer and send email reminder
                $buyer = User::find($order->user_id);
                if ($buyer) {
                    $this->info("  Sending email reminder to buyer: {$buyer->email}");
                    try {
                        Mail::to($buyer->email)->send(new ClassStartReminder($order, $classDate, $buyer));
                        $this->info("  ✓ Email sent to buyer: {$buyer->email}");
                    } catch (\Exception $e) {
                        $this->error("  Failed to send email to buyer: " . $e->getMessage());
                        Log::error("Failed to send class reminder email to buyer {$buyer->email}: " . $e->getMessage());
                    }
                }

                // Generate tokens for guests and send invitation emails
                if ($order->guests && $order->guests > 0 && $order->emails) {
                    $guestEmails = explode(',', $order->emails);
                    foreach ($guestEmails as $guestEmail) {
                        $guestEmail = trim($guestEmail);
                        if (filter_var($guestEmail, FILTER_VALIDATE_EMAIL)) {
                            $this->info("  Sending invitation to guest: {$guestEmail}");
                            try {
                                Mail::to($guestEmail)->send(new GuestClassInvitation($order, $classDate, $guestEmail));
                                $this->info("  ✓ Invitation sent to guest: {$guestEmail}");
                            } catch (\Exception $e) {
                                $this->error("  Failed to send invitation to guest: " . $e->getMessage());
                                Log::error("Failed to send guest invitation to {$guestEmail}: " . $e->getMessage());
                            }
                        }
                    }
                }

                $this->info("  ✓ Successfully created meeting: {$meeting->meeting_id}");
                $successCount++;

            } catch (\Exception $e) {
                $this->error("  ✗ Exception: " . $e->getMessage());
                Log::error("Failed to create Zoom meeting for class date {$classDate->id}: " . $e->getMessage());
                $errorCount++;
            }
        }

        $this->newLine();
        $this->info('=== Summary ===');
        $this->info("Total classes: {$upcomingClasses->count()}");
        $this->info("Successful: {$successCount}");
        $this->info("Errors: {$errorCount}");
        $this->info("Skipped: {$skippedCount}");

        if ($dryRun) {
            $this->warn('DRY RUN completed - no meetings were created');
        }

        Log::info('Zoom meeting generation completed', [
            'success' => $successCount,
            'errors' => $errorCount,
            'skipped' => $skippedCount,
        ]);

        return 0;
    }
}
