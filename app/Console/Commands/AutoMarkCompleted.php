<?php

namespace App\Console\Commands;

use App\Models\BookOrder;
use App\Models\Transaction;
use App\Models\User;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AutoMarkCompleted extends Command
{
    protected $signature = 'orders:auto-complete {--dry-run : Run without making actual changes}';
    protected $description = 'Mark BookOrders as Completed 48 hours after delivery';

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    public function handle()
    {
        $isDryRun = $this->option('dry-run');

        if ($isDryRun) {
            $this->info('🔍 Running in DRY RUN mode - no actual changes will be made');
        }

        Log::info('========================================');
        Log::info('Auto-complete command started', [
            'timestamp' => now()->toDateTimeString(),
            'dry_run' => $isDryRun
        ]);

        $now = Carbon::now();

        // Get delivered orders waiting for completion
        $orders = BookOrder::where('status', 2) // Delivered
        ->whereNotNull('action_date')
            ->with(['user', 'teacher', 'gig'])
            ->get()
            ->filter(function($order) use ($now) {
                try {
                    $actionDate = Carbon::parse($order->action_date);
                    // Check if 48 hours have passed since delivery
                    return $actionDate->addHours(48)->lte($now);
                } catch (\Exception $e) {
                    Log::warning("Invalid action_date for order {$order->id}");
                    return false;
                }
            });

        if ($orders->isEmpty()) {
            $this->info('✅ No orders to complete');
            Log::info('No delivered orders ready for completion');
            return 0;
        }

        $this->info("📋 Found {$orders->count()} orders ready for completion");

        $completedCount = 0;
        $errorCount = 0;

        foreach ($orders as $order) {
            try {
                if ($isDryRun) {
                    $this->info("✅ [DRY RUN] Would complete order #{$order->id}");
                    continue;
                }

                $this->completeOrder($order);
                $completedCount++;
                $this->info("✅ Order #{$order->id} marked as completed");

            } catch (\Exception $e) {
                $errorCount++;
                $this->error("❌ Order #{$order->id} failed: " . $e->getMessage());
                Log::error("Auto-complete error for order {$order->id}", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        // Summary
        $this->newLine();
        $this->info('========================================');
        $this->info('📊 Auto-Complete Summary:');
        $this->info("   ✅ Completed: {$completedCount}");
        $this->info("   ⚠️  Errors: {$errorCount}");
        $this->info('========================================');

        Log::info('Auto-complete command completed', [
            'completed' => $completedCount,
            'errors' => $errorCount,
            'timestamp' => now()->toDateTimeString()
        ]);

        return 0;
    }

    /**
     * Complete an order
     */
    private function completeOrder(BookOrder $order): void
    {
        DB::beginTransaction();

        try {
            // Update order status
            $order->status = 3; // Completed
            $order->save();

            // Update transaction - mark as ready for payout
            $this->updateTransactionForPayout($order);

            // Send notifications
            $this->sendCompletionNotifications($order);

            DB::commit();

            Log::info("Order #{$order->id} auto-completed successfully", [
                'delivered_at' => $order->action_date,
                'completed_at' => now()->toDateTimeString()
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update transaction for payout
     */
    private function updateTransactionForPayout(BookOrder $order): void
    {
        try {
            $transaction = Transaction::where('buyer_id', $order->user_id)
                ->where('seller_id', $order->teacher_id)
                ->first();

            if (!$transaction) {
                Log::warning("No transaction found for order #{$order->id}");
                return;
            }

            // Transaction stays 'completed'
            // Payout stays 'pending' (admin will process manually or via batch)
            $transaction->notes .= "\n[" . now()->format('Y-m-d H:i:s') . "] Auto-completed after 48 hours - Ready for payout";
            $transaction->save();

            Log::info("Transaction #{$transaction->id} marked ready for payout", [
                'seller_earnings' => $transaction->seller_earnings,
                'payout_status' => $transaction->payout_status
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to update transaction for order #{$order->id}: " . $e->getMessage());
            // Don't throw - not critical for order completion
        }
    }

    /**
     * Send completion notifications to buyer, seller, and admin
     */
    private function sendCompletionNotifications(BookOrder $order): void
    {
        try {
            $serviceName = $order->title ?? ($order->gig ? $order->gig->name : 'Service');
            $buyerName = $order->user ? ($order->user->first_name . ' ' . $order->user->last_name) : 'Customer';

            // Get transaction for seller payout info
            $transaction = Transaction::where('buyer_id', $order->user_id)
                ->where('seller_id', $order->teacher_id)
                ->first();

            // Notify buyer
            $this->notificationService->send(
                userId: $order->user_id,
                type: 'order_completed',
                title: 'Order Completed',
                message: "Your order for \"{$serviceName}\" is now complete. Thank you for choosing DreamCrowd!",
                data: [
                    'order_id' => $order->id,
                    'service_name' => $serviceName,
                    'completed_at' => now()->toDateTimeString()
                ],
                sendEmail: true
            );

            // Send review request notification to buyer
            $sellerName = $order->teacher ? ($order->teacher->first_name . ' ' . $order->teacher->last_name) : 'the seller';
            $this->notificationService->send(
                userId: $order->user_id,
                type: 'review',
                title: 'Leave a Review',
                message: "How was your experience with {$sellerName}? Share your feedback to help others!",
                data: [
                    'order_id' => $order->id,
                    'service_name' => $serviceName,
                    'seller_id' => $order->teacher_id,
                    'seller_name' => $sellerName,
                    'review_url' => route('user.orders.review', $order->id),
                    'completed_at' => now()->toDateTimeString()
                ],
                sendEmail: false // In-app notification only for review requests
            );

            // Notify seller
            $this->notificationService->send(
                userId: $order->teacher_id,
                type: 'order_completed',
                title: 'Order Completed - Payment Released',
                message: "Your order for \"{$serviceName}\" is complete. Payment will be released soon.",
                data: [
                    'order_id' => $order->id,
                    'service_name' => $serviceName,
                    'buyer_name' => $buyerName,
                    'seller_payout' => $transaction ? $transaction->seller_earnings : null,
                    'completed_at' => now()->toDateTimeString()
                ],
                sendEmail: true
            );

            // Notify admins
            $adminIds = User::where('role', 'admin')->pluck('id')->toArray();
            if (!empty($adminIds)) {
                $this->notificationService->sendToMultipleUsers(
                    userIds: $adminIds,
                    type: 'order_completed',
                    title: 'Order Completed',
                    message: "Order #{$order->id} completed. Ready for payout.",
                    data: [
                        'order_id' => $order->id,
                        'seller_id' => $order->teacher_id,
                        'buyer_id' => $order->user_id,
                        'completed_at' => now()->toDateTimeString()
                    ],
                    sendEmail: false
                );
            }

            Log::info("Completion notifications sent for order #{$order->id}");

        } catch (\Exception $e) {
            Log::error("Failed to send completion notifications for order #{$order->id}: " . $e->getMessage());
            // Don't throw - not critical
        }
    }
}
