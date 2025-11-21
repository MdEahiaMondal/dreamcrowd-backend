<?php

namespace App\Console\Commands;

use App\Models\ClassDate;
use App\Models\User;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendClassReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send-class-reminders {--dry-run : Run without sending notifications}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send class reminders (24 hours and 1 hour before class starts)';

    /**
     * Notification service instance
     *
     * @var NotificationService
     */
    protected $notificationService;

    /**
     * Create a new command instance.
     *
     * @param NotificationService $notificationService
     * @return void
     */
    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');

        if ($isDryRun) {
            $this->info('🔍 Running in DRY RUN mode - no actual notifications will be sent');
        }

        Log::info('========================================');
        Log::info('Class reminders command started', [
            'timestamp' => now()->toDateTimeString(),
            'dry_run' => $isDryRun
        ]);

        try {
            // Send 24-hour reminders
            $reminders24h = $this->send24HourReminders($isDryRun);

            // Send 1-hour reminders
            $reminders1h = $this->send1HourReminders($isDryRun);

            // Send 3-day reminders for recurring classes
            $reminders3d = $this->send3DayRecurringReminders($isDryRun);

            $totalReminders = $reminders24h + $reminders1h + $reminders3d;

            Log::info('Class reminders command completed', [
                'timestamp' => now()->toDateTimeString(),
                '24h_reminders' => $reminders24h,
                '1h_reminders' => $reminders1h,
                '3d_recurring_reminders' => $reminders3d,
                'total_reminders' => $totalReminders,
                'dry_run' => $isDryRun
            ]);

            $this->info("✓ Successfully sent {$totalReminders} class reminders");
            $this->info("  - 24-hour reminders: {$reminders24h}");
            $this->info("  - 1-hour reminders: {$reminders1h}");
            $this->info("  - 3-day recurring reminders: {$reminders3d}");

        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            Log::error('Class reminders command failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Notify admins of command failure
            $adminIds = User::where('role', 2)->pluck('id')->toArray();
            if (!empty($adminIds) && !$isDryRun) {
                $this->notificationService->sendToMultipleUsers(
                    userIds: $adminIds,
                    type: 'system',
                    title: 'Scheduled Command Failed',
                    message: "Scheduled command 'reminders:send-class-reminders' failed. Error: {$e->getMessage()}",
                    data: [
                        'command' => $this->signature,
                        'error' => $e->getMessage(),
                        'timestamp' => now()->toISOString()
                    ],
                    sendEmail: true
                );
            }

            return 1;
        }

        return 0;
    }

    /**
     * Send 24-hour class reminders
     *
     * @param bool $isDryRun
     * @return int Number of reminders sent
     */
    protected function send24HourReminders($isDryRun = false)
    {
        $this->info('📅 Checking for classes starting in 24 hours...');

        // Find classes starting in 24 hours (23-25 hour window to avoid missing)
        $classesIn24Hours = ClassDate::whereBetween('teacher_date', [
            now()->addHours(23)->toDateTimeString(),
            now()->addHours(25)->toDateTimeString()
        ])
        ->whereHas('bookOrder', function($query) {
            $query->where('status', 1); // Active orders only
        })
        ->with(['bookOrder.user', 'bookOrder.teacherGig.user'])
        ->get();

        $remindersSent = 0;

        foreach ($classesIn24Hours as $classDate) {
            try {
                $order = $classDate->bookOrder;

                // Skip if order doesn't exist or is not active
                if (!$order || $order->status != 1) {
                    continue;
                }

                $buyer = $order->user;
                $seller = $order->teacherGig->user;
                $gig = $order->teacherGig;

                $classDateTime = Carbon::parse($classDate->teacher_date);
                $formattedTime = $classDateTime->format('l, M d \a\t h:i A');

                if (!$isDryRun) {
                    // Notify buyer
                    $this->notificationService->send(
                        userId: $buyer->id,
                        type: 'class',
                        title: 'Class Reminder: Starting Tomorrow',
                        message: "Reminder: Your class '{$gig->title}' with {$seller->first_name} starts tomorrow at " . $classDateTime->format('h:i A'),
                        data: [
                            'order_id' => $order->id,
                            'class_date_id' => $classDate->id,
                            'class_date' => $classDateTime->toISOString(),
                            'zoom_link' => $classDate->zoom_link ?? null,
                            'seller_name' => $seller->first_name . ' ' . $seller->last_name,
                            'gig_title' => $gig->title,
                            'reminder_type' => '24_hour'
                        ],
                        sendEmail: true,
                        actorUserId: $seller->id,
                        targetUserId: $buyer->id,
                        orderId: $order->id,
                        serviceId: $gig->id
                    );

                    // Notify seller
                    $this->notificationService->send(
                        userId: $seller->id,
                        type: 'class',
                        title: 'Class Reminder: Starting Tomorrow',
                        message: "Reminder: You have a class '{$gig->title}' with {$buyer->first_name} tomorrow at " . $classDateTime->format('h:i A'),
                        data: [
                            'order_id' => $order->id,
                            'class_date_id' => $classDate->id,
                            'class_date' => $classDateTime->toISOString(),
                            'zoom_link' => $classDate->zoom_link ?? null,
                            'buyer_name' => $buyer->first_name . ' ' . $buyer->last_name,
                            'gig_title' => $gig->title,
                            'reminder_type' => '24_hour'
                        ],
                        sendEmail: true,
                        actorUserId: $seller->id,
                        targetUserId: $buyer->id,
                        orderId: $order->id,
                        serviceId: $gig->id
                    );

                    $remindersSent += 2; // Buyer + Seller
                }

                $this->line("  → Class #{$classDate->id}: '{$gig->title}' - {$formattedTime}");

            } catch (\Exception $e) {
                Log::error('Failed to send 24h reminder', [
                    'class_date_id' => $classDate->id,
                    'error' => $e->getMessage()
                ]);
                $this->warn("  ⚠ Failed to send reminder for class #{$classDate->id}");
            }
        }

        if ($classesIn24Hours->isEmpty()) {
            $this->line('  No classes found starting in 24 hours');
        }

        return $remindersSent;
    }

    /**
     * Send 1-hour class reminders
     *
     * @param bool $isDryRun
     * @return int Number of reminders sent
     */
    protected function send1HourReminders($isDryRun = false)
    {
        $this->info('⏰ Checking for classes starting in 1 hour...');

        // Find classes starting in 1 hour (50-70 minute window)
        $classesIn1Hour = ClassDate::whereBetween('teacher_date', [
            now()->addMinutes(50)->toDateTimeString(),
            now()->addMinutes(70)->toDateTimeString()
        ])
        ->whereHas('bookOrder', function($query) {
            $query->where('status', 1); // Active orders only
        })
        ->with(['bookOrder.user', 'bookOrder.teacherGig.user'])
        ->get();

        $remindersSent = 0;

        foreach ($classesIn1Hour as $classDate) {
            try {
                $order = $classDate->bookOrder;

                // Skip if order doesn't exist or is not active
                if (!$order || $order->status != 1) {
                    continue;
                }

                $buyer = $order->user;
                $seller = $order->teacherGig->user;
                $gig = $order->teacherGig;

                $classDateTime = Carbon::parse($classDate->teacher_date);
                $zoomLink = $classDate->zoom_link ?? 'Zoom link will be provided';

                if (!$isDryRun) {
                    // Notify buyer
                    $this->notificationService->send(
                        userId: $buyer->id,
                        type: 'class',
                        title: 'Class Starting Soon!',
                        message: "Your class '{$gig->title}' starts in 1 hour! Join here: {$zoomLink}",
                        data: [
                            'order_id' => $order->id,
                            'class_date_id' => $classDate->id,
                            'start_time' => $classDateTime->toISOString(),
                            'zoom_link' => $classDate->zoom_link ?? null,
                            'seller_name' => $seller->first_name . ' ' . $seller->last_name,
                            'gig_title' => $gig->title,
                            'reminder_type' => '1_hour'
                        ],
                        sendEmail: true,
                        actorUserId: $seller->id,
                        targetUserId: $buyer->id,
                        orderId: $order->id,
                        serviceId: $gig->id
                    );

                    // Notify seller
                    $this->notificationService->send(
                        userId: $seller->id,
                        type: 'class',
                        title: 'Class Starting Soon!',
                        message: "Your class '{$gig->title}' with {$buyer->first_name} starts in 1 hour!",
                        data: [
                            'order_id' => $order->id,
                            'class_date_id' => $classDate->id,
                            'start_time' => $classDateTime->toISOString(),
                            'zoom_link' => $classDate->zoom_link ?? null,
                            'buyer_name' => $buyer->first_name . ' ' . $buyer->last_name,
                            'gig_title' => $gig->title,
                            'reminder_type' => '1_hour'
                        ],
                        sendEmail: true,
                        actorUserId: $seller->id,
                        targetUserId: $buyer->id,
                        orderId: $order->id,
                        serviceId: $gig->id
                    );

                    $remindersSent += 2; // Buyer + Seller
                }

                $this->line("  → Class #{$classDate->id}: '{$gig->title}' - Starting at " . $classDateTime->format('h:i A'));

            } catch (\Exception $e) {
                Log::error('Failed to send 1h reminder', [
                    'class_date_id' => $classDate->id,
                    'error' => $e->getMessage()
                ]);
                $this->warn("  ⚠ Failed to send reminder for class #{$classDate->id}");
            }
        }

        if ($classesIn1Hour->isEmpty()) {
            $this->line('  No classes found starting in 1 hour');
        }

        return $remindersSent;
    }

    /**
     * Send 3-day reminders for recurring/subscription classes
     *
     * @param bool $isDryRun
     * @return int Number of reminders sent
     */
    protected function send3DayRecurringReminders($isDryRun = false)
    {
        $this->info('🔄 Checking for recurring classes starting in 3 days...');

        // Find recurring classes starting in 3 days
        $recurringClassesIn3Days = ClassDate::whereBetween('teacher_date', [
            now()->addDays(3)->startOfDay()->toDateTimeString(),
            now()->addDays(3)->endOfDay()->toDateTimeString()
        ])
        ->whereHas('bookOrder', function($query) {
            $query->where('status', 1) // Active orders
                  ->where('payment_type', 'Subscription'); // Subscription orders only
        })
        ->with(['bookOrder.user', 'bookOrder.teacherGig'])
        ->get();

        $remindersSent = 0;

        foreach ($recurringClassesIn3Days as $classDate) {
            try {
                $order = $classDate->bookOrder;

                // Skip if order doesn't exist or is not active
                if (!$order || $order->status != 1) {
                    continue;
                }

                $buyer = $order->user;
                $gig = $order->teacherGig;

                $classDateTime = Carbon::parse($classDate->teacher_date);

                if (!$isDryRun) {
                    // Notify buyer only (recurring class reminder)
                    $this->notificationService->send(
                        userId: $buyer->id,
                        type: 'class',
                        title: 'Next Session Reminder',
                        message: "Your next session of '{$gig->title}' is scheduled for " . $classDateTime->format('l, M d') . " at " . $classDateTime->format('h:i A'),
                        data: [
                            'order_id' => $order->id,
                            'class_date_id' => $classDate->id,
                            'next_class_date' => $classDateTime->toISOString(),
                            'gig_title' => $gig->title,
                            'reminder_type' => '3_day_recurring'
                        ],
                        sendEmail: true,
                        actorUserId: $order->teacher_id,
                        targetUserId: $buyer->id,
                        orderId: $order->id,
                        serviceId: $gig->id
                    );

                    $remindersSent++;
                }

                $this->line("  → Recurring Class #{$classDate->id}: '{$gig->title}' - " . $classDateTime->format('l, M d \a\t h:i A'));

            } catch (\Exception $e) {
                Log::error('Failed to send 3-day recurring reminder', [
                    'class_date_id' => $classDate->id,
                    'error' => $e->getMessage()
                ]);
                $this->warn("  ⚠ Failed to send reminder for class #{$classDate->id}");
            }
        }

        if ($recurringClassesIn3Days->isEmpty()) {
            $this->line('  No recurring classes found starting in 3 days');
        }

        return $remindersSent;
    }
}
