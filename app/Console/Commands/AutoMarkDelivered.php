<?php

namespace App\Console\Commands;

use App\Models\BookOrder;
use App\Models\ClassDate;
use App\Models\ClassReschedule;
use App\Models\Transaction;
use App\Services\NotificationService;
use App\Services\GoogleAnalyticsService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AutoMarkDelivered extends Command
{
    protected $signature = 'orders:auto-deliver {--dry-run : Run without making actual changes}';
    protected $description = 'Mark BookOrders as delivered after last class date has passed';

    protected $notificationService;
    protected $analyticsService;

    public function __construct(NotificationService $notificationService, GoogleAnalyticsService $analyticsService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
        $this->analyticsService = $analyticsService;
    }

    public function handle()
    {
        $isDryRun = $this->option('dry-run');

        if ($isDryRun) {
            $this->info('🔍 Running in DRY RUN mode - no actual changes will be made');
        }

        Log::info('========================================');
        Log::info('Auto-mark delivered command started', [
            'timestamp' => now()->toDateTimeString(),
            'dry_run' => $isDryRun
        ]);

        $now = Carbon::now();

        // Get active orders (not Normal freelance)
        $orders = BookOrder::where('status', 1)
            ->where('freelance_service', '!=', 'Normal')
            ->whereNotNull('payment_type')
            ->with(['user', 'teacher', 'gig'])
            ->get();

        if ($orders->isEmpty()) {
            $this->info('✅ No orders to deliver');
            Log::info('No active orders to deliver');
            return 0;
        }

        $this->info("📋 Found {$orders->count()} active orders to check");

        $deliveredCount = 0;
        $skippedCount = 0;
        $errorCount = 0;

        foreach ($orders as $order) {
            try {
                $result = $this->processOrderDelivery($order, $now, $isDryRun);

                if ($result['action'] === 'delivered') {
                    $deliveredCount++;
                    $this->info("✅ Order #{$order->id} marked as delivered");
                } else {
                    $skippedCount++;
                    $this->line("⏭️  Order #{$order->id}: {$result['reason']}");
                }

            } catch (\Exception $e) {
                $errorCount++;
                $this->error("❌ Order #{$order->id} failed: " . $e->getMessage());
                Log::error("Auto-deliver error for order {$order->id}", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        // Summary
        $this->newLine();
        $this->info('========================================');
        $this->info('📊 Auto-Deliver Summary:');
        $this->info("   ✅ Delivered: {$deliveredCount}");
        $this->info("   ⏭️  Skipped: {$skippedCount}");
        $this->info("   ⚠️  Errors: {$errorCount}");
        $this->info('========================================');

        Log::info('Auto-deliver command completed', [
            'delivered' => $deliveredCount,
            'skipped' => $skippedCount,
            'errors' => $errorCount,
            'timestamp' => now()->toDateTimeString()
        ]);

        return 0;
    }

    /**
     * Process order delivery
     */
    private function processOrderDelivery(BookOrder $order, Carbon $now, bool $isDryRun): array
    {
        // Determine due date based on payment type
        $dueDate = $this->calculateDueDate($order);

        if (!$dueDate) {
            return [
                'action' => 'skipped',
                'reason' => 'Could not determine due date'
            ];
        }

        // Check if due date has passed
        if ($dueDate->gt($now)) {
            $hoursRemaining = $now->diffInHours($dueDate, false);
            return [
                'action' => 'skipped',
                'reason' => "Due in " . abs($hoursRemaining) . " hours"
            ];
        }

        Log::info("Marking order #{$order->id} as delivered", [
            'due_date' => $dueDate->toDateTimeString(),
            'payment_type' => $order->payment_type
        ]);

        if ($isDryRun) {
            return [
                'action' => 'delivered',
                'reason' => '[DRY RUN] Would mark as delivered'
            ];
        }

        // Start database transaction
        DB::beginTransaction();

        try {
            // Cancel pending reschedules
            $this->cancelPendingReschedules($order);

            // Update order status
            $order->status = 2; // Delivered
            $order->action_date = $now->format('Y-m-d H:i:s');
            $order->save();

            // Update transaction notes (no status change)
            $this->updateTransactionNotes($order);

            // Send notifications
            $this->sendDeliveryNotifications($order);

            DB::commit();

            // Track order status change in Google Analytics
            try {
                $this->analyticsService->trackEvent('order_status_change', [
                    'order_id' => $order->id,
                    'from_status' => 'Active',
                    'to_status' => 'Delivered',
                    'order_value' => $order->finel_price ?? 0,
                    'service_id' => $order->gig_id,
                    'payment_type' => $order->payment_type,
                    'trigger' => 'automated'
                ]);
            } catch (\Exception $e) {
                Log::warning("GA4 order status tracking failed for order #{$order->id}: " . $e->getMessage());
            }

            Log::info("Order #{$order->id} marked as delivered successfully");

            return [
                'action' => 'delivered',
                'reason' => 'Due date passed'
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Calculate due date based on payment type
     */
    private function calculateDueDate(BookOrder $order): ?Carbon
    {
        try {
            if ($order->payment_type == 'Subscription') {
                // Subscription ends 1 month after creation
                return Carbon::parse($order->created_at)->addMonth();

            } elseif ($order->payment_type == 'OneOff') {
                // One-off ends after last class
                $lastClass = ClassDate::where('order_id', $order->id)
                    ->whereNotNull('teacher_date')
                    ->orderByDesc('teacher_date')
                    ->first();

                if (!$lastClass) {
                    Log::warning("Order #{$order->id} has no class dates");
                    return null;
                }

                return Carbon::parse($lastClass->teacher_date);
            }

            return null;

        } catch (\Exception $e) {
            Log::error("Failed to calculate due date for order #{$order->id}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Cancel pending reschedules
     */
    private function cancelPendingReschedules(BookOrder $order): void
    {
        try {
            $reschedules = ClassReschedule::where('order_id', $order->id)
                ->where('status', 0)
                ->get();

            if ($reschedules->isEmpty()) {
                return;
            }

            foreach ($reschedules as $reschedule) {
                $reschedule->status = 2; // Cancelled
                $reschedule->save();
            }

            Log::info("Cancelled {$reschedules->count()} pending reschedules for order #{$order->id}");

        } catch (\Exception $e) {
            Log::error("Failed to cancel reschedules for order #{$order->id}: " . $e->getMessage());
            // Don't throw - not critical
        }
    }

    /**
     * Update transaction notes
     */
    private function updateTransactionNotes(BookOrder $order): void
    {
        try {
            $transaction = Transaction::where('buyer_id', $order->user_id)
                ->where('seller_id', $order->teacher_id)
                ->first();

            if (!$transaction) {
                return;
            }

            // Transaction stays 'completed', payout stays 'pending'
            $transaction->notes .= "\n[" . now()->format('Y-m-d H:i:s') . "] Auto-delivered - All classes completed";
            $transaction->save();

            Log::info("Transaction notes updated for order #{$order->id}");

        } catch (\Exception $e) {
            Log::error("Failed to update transaction for order #{$order->id}: " . $e->getMessage());
            // Don't throw - not critical
        }
    }

    /**
     * Send delivery notifications to buyer and seller
     */
    private function sendDeliveryNotifications(BookOrder $order): void
    {
        try {
            $serviceName = $order->title ?? ($order->gig ? $order->gig->name : 'Service');
            $buyerName = $order->user ? ($order->user->first_name . ' ' .  strtoupper(substr($order->user->last_name, 0, 1))) : 'Customer';
            $disputeDeadline = now()->addHours(48)->format('F j, Y g:i A');

            // Notify buyer
            $this->notificationService->send(
                userId: $order->user_id,
                type: 'order_delivered',
                title: 'Order Delivered',
                message: "Your service \"{$serviceName}\" has been delivered. You have 48 hours to report any issues.",
                data: [
                    'order_id' => $order->id,
                    'service_name' => $serviceName,
                    'delivered_at' => now()->toDateTimeString(),
                    'dispute_deadline' => $disputeDeadline
                ],
                sendEmail: true
            );

            // Notify seller
            $this->notificationService->send(
                userId: $order->teacher_id,
                type: 'order_delivered',
                title: 'Order Delivered',
                message: "Your service \"{$serviceName}\" for {$buyerName} has been marked as delivered.",
                data: [
                    'order_id' => $order->id,
                    'service_name' => $serviceName,
                    'buyer_name' => $buyerName,
                    'delivered_at' => now()->toDateTimeString()
                ],
                sendEmail: false
            );

            Log::info("Delivery notifications sent for order #{$order->id}");

        } catch (\Exception $e) {
            Log::error("Failed to send delivery notifications for order #{$order->id}: " . $e->getMessage());
            // Don't throw - not critical
        }
    }
}