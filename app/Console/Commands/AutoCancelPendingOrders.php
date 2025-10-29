<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BookOrder;
use App\Models\CancelOrder;
use App\Models\ClassDate;
use App\Models\Transaction;
use App\Models\ClassReschedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;

class AutoCancelPendingOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:auto-cancel {--dry-run : Run without making actual changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto-cancel pending orders if first class is about to start in 30 minutes or has already started';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');

        if ($isDryRun) {
            $this->info('🔍 Running in DRY RUN mode - no actual changes will be made');
        }

        Log::info('========================================');
        Log::info('Auto-cancel pending orders command started', [
            'timestamp' => now()->toDateTimeString(),
            'dry_run' => $isDryRun
        ]);

        // Get all pending orders
        $orders = BookOrder::where('status', 0)
            ->whereNotNull('payment_id')
            ->with(['user', 'teacher'])
            ->get();

        if ($orders->isEmpty()) {
            $this->info('✅ No pending orders found');
            Log::info('No pending orders to process');
            return 0;
        }

        $this->info("📋 Found {$orders->count()} pending orders to check");
        Log::info("Processing {$orders->count()} pending orders");

        $cancelledCount = 0;
        $skippedCount = 0;
        $errorCount = 0;

        foreach ($orders as $order) {
            try {
                $result = $this->processPendingOrder($order, $isDryRun);

                if ($result['action'] === 'cancelled') {
                    $cancelledCount++;
                    $this->warn("❌ Order #{$order->id} cancelled: {$result['reason']}");
                } elseif ($result['action'] === 'skipped') {
                    $skippedCount++;
                    $this->line("⏭️  Order #{$order->id} skipped: {$result['reason']}");
                } else {
                    $skippedCount++;
                }

            } catch (\Exception $e) {
                $errorCount++;
                $this->error("❌ Error processing order #{$order->id}: " . $e->getMessage());
                Log::error("Auto-cancel error for order {$order->id}", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        // Summary
        $this->newLine();
        $this->info('========================================');
        $this->info('📊 Auto-Cancel Summary:');
        $this->info("   ✅ Total Orders Checked: {$orders->count()}");
        $this->info("   ❌ Orders Cancelled: {$cancelledCount}");
        $this->info("   ⏭️  Orders Skipped: {$skippedCount}");
        $this->info("   ⚠️  Errors: {$errorCount}");
        $this->info('========================================');

        Log::info('Auto-cancel command completed', [
            'total' => $orders->count(),
            'cancelled' => $cancelledCount,
            'skipped' => $skippedCount,
            'errors' => $errorCount,
            'timestamp' => now()->toDateTimeString()
        ]);

        return 0;
    }

    /**
     * Process a single pending order
     */
    private function processPendingOrder(BookOrder $order, bool $isDryRun): array
    {
        // Get first class for this order
        $firstClass = ClassDate::where('order_id', $order->id)
            ->whereNotNull('teacher_date')
            ->orderBy('teacher_date', 'asc')
            ->first();

        if (!$firstClass) {
            Log::warning("Order #{$order->id} has no class dates - skipping");
            return [
                'action' => 'skipped',
                'reason' => 'No class dates found'
            ];
        }

        // Validate timezone
        $timezone = $firstClass->teacher_time_zone ?? 'UTC';
        if (!in_array($timezone, timezone_identifiers_list())) {
            $timezone = 'UTC';
            Log::warning("Invalid timezone for order #{$order->id}, using UTC");
        }

        // Parse class date with timezone
        try {
            $classDate = Carbon::parse($firstClass->teacher_date, $timezone);
            $now = Carbon::now($timezone);
        } catch (\Exception $e) {
            Log::error("Date parsing failed for order #{$order->id}: " . $e->getMessage());
            return [
                'action' => 'skipped',
                'reason' => 'Invalid date format'
            ];
        }

        // Calculate time difference (in minutes, negative means future)
        $minutesUntilClass = $now->diffInMinutes($classDate, false);

        // Check if class starts in ≤ 30 minutes or has already passed
        $shouldCancel = false;
        $cancelReason = '';

        if ($minutesUntilClass >= 0) {
            // Class has already started or passed
            $shouldCancel = true;
            $cancelReason = "Class started " . abs($minutesUntilClass) . " minutes ago";
        } elseif (abs($minutesUntilClass) <= 30) {
            // Class starts within next 30 minutes
            $shouldCancel = true;
            $cancelReason = "Class starts in " . abs($minutesUntilClass) . " minutes";
        }

        if (!$shouldCancel) {
            return [
                'action' => 'kept',
                'reason' => "Class starts in " . abs($minutesUntilClass) . " minutes (safe window)"
            ];
        }

        // Log cancellation intent
        Log::info("Attempting to cancel order #{$order->id}", [
            'reason' => $cancelReason,
            'class_date' => $classDate->toDateTimeString(),
            'current_time' => $now->toDateTimeString(),
            'minutes_difference' => $minutesUntilClass
        ]);

        if ($isDryRun) {
            return [
                'action' => 'cancelled',
                'reason' => "[DRY RUN] Would cancel: {$cancelReason}"
            ];
        }

        // Start database transaction for data consistency
        DB::beginTransaction();

        try {
            // ============ CANCEL STRIPE PAYMENT ============
            $refundSuccess = $this->cancelStripePayment($order);

            // ============ UPDATE TRANSACTION STATUS ============
            $this->updateTransactionStatus($order, $refundSuccess);

            // ============ CREATE CANCEL ORDER RECORD ============
            $this->createCancelOrderRecord($order, $cancelReason, $refundSuccess);

            // ============ UPDATE ORDER STATUS ============
            $order->status = 4; // Cancelled
            $order->refund = $refundSuccess ? 1 : 0;
            $order->payment_status = $refundSuccess ? 'refunded' : 'failed';
            $order->action_date = now()->format('Y-m-d H:i:s');
            $order->save();

            // ============ CANCEL PENDING RESCHEDULES ============
            $this->cancelPendingReschedules($order);

            DB::commit();

            Log::info("Order #{$order->id} successfully cancelled", [
                'refund_status' => $refundSuccess ? 'refunded' : 'failed',
                'reason' => $cancelReason
            ]);

            return [
                'action' => 'cancelled',
                'reason' => $cancelReason
            ];

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error("Failed to cancel order #{$order->id}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    /**
     * Cancel Stripe payment
     */
    private function cancelStripePayment(BookOrder $order): bool
    {
        if (empty($order->payment_id)) {
            Log::warning("Order #{$order->id} has no payment_id");
            return false;
        }

        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $paymentIntent = PaymentIntent::retrieve($order->payment_id);

            // Only cancel if payment is not yet captured/succeeded
            if (in_array($paymentIntent->status, ['requires_payment_method', 'requires_capture', 'requires_confirmation', 'requires_action'])) {
                $paymentIntent->cancel();

                Log::info("Stripe payment cancelled for order #{$order->id}", [
                    'payment_intent_id' => $order->payment_id,
                    'status_was' => $paymentIntent->status
                ]);

                return true;

            } elseif ($paymentIntent->status === 'succeeded') {
                // Payment already captured - need to refund
                Log::warning("Payment already captured for order #{$order->id} - refund needed", [
                    'payment_intent_id' => $order->payment_id
                ]);

                // Optionally auto-refund here
                try {
                    \Stripe\Refund::create([
                        'payment_intent' => $order->payment_id,
                    ]);

                    Log::info("Auto-refund issued for order #{$order->id}");
                    return true;

                } catch (\Exception $e) {
                    Log::error("Auto-refund failed for order #{$order->id}: " . $e->getMessage());
                    return false;
                }

            } elseif ($paymentIntent->status === 'canceled') {
                Log::info("Payment already cancelled for order #{$order->id}");
                return true;

            } else {
                Log::warning("Cannot cancel payment with status {$paymentIntent->status} for order #{$order->id}");
                return false;
            }

        } catch (ApiErrorException $e) {
            Log::error("Stripe API error for order #{$order->id}", [
                'error' => $e->getMessage(),
                'error_type' => get_class($e)
            ]);
            return false;

        } catch (\Exception $e) {
            Log::error("Payment cancellation failed for order #{$order->id}", [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Update transaction status
     */
    private function updateTransactionStatus(BookOrder $order, bool $refundSuccess): void
    {
        try {
            // Find transaction by payment_id or order details
            $transaction = Transaction::where('stripe_transaction_id', $order->payment_id)
                ->orWhere(function($query) use ($order) {
                    $query->where('buyer_id', $order->user_id)
                        ->where('seller_id', $order->teacher_id)
                        ->where('service_id', $order->gig_id)
                        ->where('status', 'pending');
                })
                ->first();

            if (!$transaction) {
                Log::warning("No transaction found for order #{$order->id}");
                return;
            }

            // Update transaction status
            if ($refundSuccess) {
                $transaction->markAsRefunded();
                $transaction->notes .= "\n[" . now()->format('Y-m-d H:i:s') . "] Auto-cancelled: Pending order not accepted before class start";
            } else {
                $transaction->status = 'failed';
                $transaction->notes .= "\n[" . now()->format('Y-m-d H:i:s') . "] Auto-cancel attempted but refund failed";
            }

            $transaction->save();

            Log::info("Transaction #{$transaction->id} updated for order #{$order->id}", [
                'new_status' => $transaction->status,
                'refund_success' => $refundSuccess
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to update transaction for order #{$order->id}: " . $e->getMessage());
            // Don't throw - continue with order cancellation
        }
    }

    /**
     * Create cancel order record
     */
    private function createCancelOrderRecord(BookOrder $order, string $reason, bool $refundSuccess): void
    {
        try {
            $cancelOrder = new CancelOrder();
            $cancelOrder->user_id = $order->teacher_id; // System cancellation on behalf of seller
            $cancelOrder->user_role = 1; // Seller role
            $cancelOrder->order_id = $order->id;
            $cancelOrder->reason = "AUTO-CANCEL: {$reason}. Seller did not accept order before class start time.";
            $cancelOrder->refund = $refundSuccess ? 1 : 0;
            $cancelOrder->amount = $refundSuccess ? $order->finel_price : 0;
            $cancelOrder->save();

            Log::info("Cancel order record created for order #{$order->id}");

        } catch (\Exception $e) {
            Log::error("Failed to create cancel record for order #{$order->id}: " . $e->getMessage());
            // Don't throw - continue with order cancellation
        }
    }

    /**
     * Cancel any pending reschedules for this order
     */
    private function cancelPendingReschedules(BookOrder $order): void
    {
        try {
            $reschedules = ClassReschedule::where('order_id', $order->id)
                ->where('status', 0) // Pending
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
            // Don't throw - this is not critical
        }
    }

    /**
     * Helper method for AdmincheckAuth (if needed)
     */
    private function AdmincheckAuth()
    {
        // Commands run in CLI, no auth check needed
        return null;
    }
}
