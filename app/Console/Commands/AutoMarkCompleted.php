<?php

namespace App\Console\Commands;

use App\Models\BookOrder;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AutoMarkCompleted extends Command
{
    protected $signature = 'orders:auto-complete {--dry-run : Run without making actual changes}';
    protected $description = 'Mark BookOrders as Completed 48 hours after delivery';

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
            ->with(['user', 'teacher'])
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
}
