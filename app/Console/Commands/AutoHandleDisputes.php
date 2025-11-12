<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Models\BookOrder;
use App\Models\DisputeOrder;
use App\Models\Transaction;
use App\Models\User;
use App\Services\NotificationService;
use App\Services\GoogleAnalyticsService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Stripe\PaymentIntent;
use Stripe\Refund;
use Stripe\Stripe;
use Stripe\Exception\ApiErrorException;

class AutoHandleDisputes extends Command
{
    protected $signature = 'disputes:process {--dry-run : Run without making actual changes}';
    protected $description = 'Automatically refund to user if only user disputed after 48 hours of cancellation';

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
        Log::info('Auto-handle disputes command started', [
            'timestamp' => now()->toDateTimeString(),
            'dry_run' => $isDryRun
        ]);

        $now = Carbon::now();
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Get orders with user disputes pending for 48+ hours
        $orders = BookOrder::where('status', 4) // Cancelled
        ->where('user_dispute', 1)
            ->where('teacher_dispute', 0)
            ->where('auto_dispute_processed', 0)
            ->where('refund', 0)
            ->with(['user', 'teacher', 'gig'])
            ->get()
            ->filter(function($order) use ($now) {
                // Parse action_date safely
                try {
                    $actionDate = Carbon::parse($order->action_date);
                    return $actionDate->addHours(48)->lte($now);
                } catch (\Exception $e) {
                    Log::warning("Invalid action_date for order {$order->id}");
                    return false;
                }
            });

        if ($orders->isEmpty()) {
            $this->info('✅ No disputes to process');
            Log::info('No disputes found to process');
            return 0;
        }

        $this->info("📋 Found {$orders->count()} disputes to process");
        Log::info("Processing {$orders->count()} auto-disputes");

        $processedCount = 0;
        $failedCount = 0;

        foreach ($orders as $order) {
            try {
                $result = $this->processDispute($order, $isDryRun);

                if ($result['success']) {
                    $processedCount++;
                    $this->info("✅ Order #{$order->id}: {$result['message']}");
                } else {
                    $failedCount++;
                    $this->error("❌ Order #{$order->id}: {$result['message']}");
                }

            } catch (\Exception $e) {
                $failedCount++;
                $this->error("❌ Order #{$order->id} failed: " . $e->getMessage());
                Log::error("Auto-dispute error for order {$order->id}", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        // Summary
        $this->newLine();
        $this->info('========================================');
        $this->info('📊 Auto-Dispute Summary:');
        $this->info("   ✅ Processed: {$processedCount}");
        $this->info("   ❌ Failed: {$failedCount}");
        $this->info('========================================');

        Log::info('Auto-dispute command completed', [
            'processed' => $processedCount,
            'failed' => $failedCount,
            'timestamp' => now()->toDateTimeString()
        ]);

        return 0;
    }

    /**
     * Process a single dispute
     */
    private function processDispute(BookOrder $order, bool $isDryRun): array
    {
        $dispute = DisputeOrder::where([
            'order_id' => $order->id,
            'status' => 0
        ])->first();

        if (!$dispute) {
            Log::warning("No pending dispute found for order #{$order->id}");
            return [
                'success' => false,
                'message' => 'No pending dispute found'
            ];
        }

        if (empty($order->payment_id)) {
            Log::warning("Order #{$order->id} has no payment_id");
            return [
                'success' => false,
                'message' => 'No payment ID found'
            ];
        }

        Log::info("Processing auto-dispute for order #{$order->id}", [
            'dispute_type' => $dispute->refund_type == 0 ? 'full' : 'partial',
            'amount' => $dispute->amount,
            'action_date' => $order->action_date
        ]);

        if ($isDryRun) {
            return [
                'success' => true,
                'message' => "[DRY RUN] Would process " . ($dispute->refund_type == 0 ? 'full' : 'partial') . " refund"
            ];
        }

        // Start database transaction
        DB::beginTransaction();

        try {
            // Process Stripe refund
            $refundResult = $this->processStripeRefund($order, $dispute);

            if (!$refundResult['success']) {
                DB::rollBack();
                return $refundResult;
            }

            // Update transaction status
            $this->updateTransactionStatus($order, $dispute);

            // Update dispute status
            $dispute->status = 1;
            $dispute->save();

            // Update order
            $order->auto_dispute_processed = 1;
            $order->refund = 1;
            $order->payment_status = 'refunded';
            $order->save();

            // Send notifications
            $this->sendDisputeResolutionNotifications($order, $dispute);

            DB::commit();

            // Track refund in Google Analytics
            try {
                $refundAmount = $dispute->refund_type == 0 ? $order->finel_price : floatval($dispute->amount);
                $transaction = Transaction::where('buyer_id', $order->user_id)
                    ->where('seller_id', $order->teacher_id)
                    ->first();

                $this->analyticsService->trackRefund(
                    $order->payment_id ?? ('order_' . $order->id),
                    $refundAmount,
                    'USD'
                );

                Log::info("GA4 refund tracked for order #{$order->id}", [
                    'transaction_id' => $order->payment_id,
                    'refund_amount' => $refundAmount,
                    'refund_type' => $dispute->refund_type == 0 ? 'full' : 'partial'
                ]);
            } catch (\Exception $e) {
                Log::warning("GA4 refund tracking failed for order #{$order->id}: " . $e->getMessage());
            }

            Log::info("Auto-dispute processed successfully for order #{$order->id}");

            return [
                'success' => true,
                'message' => $refundResult['message']
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Process Stripe refund
     */
    private function processStripeRefund(BookOrder $order, DisputeOrder $dispute): array
    {
        try {
            $paymentIntent = PaymentIntent::retrieve($order->payment_id);

            if ($dispute->refund_type == 0) {
                // Full refund
                if (in_array($paymentIntent->status, ['requires_capture', 'requires_confirmation', 'requires_payment_method'])) {
                    $paymentIntent->cancel();

                    Log::info("Full refund (cancel) for order #{$order->id}");
                    return [
                        'success' => true,
                        'message' => 'Full refund processed (payment cancelled)'
                    ];

                } elseif ($paymentIntent->status === 'succeeded') {
                    Refund::create([
                        'payment_intent' => $order->payment_id
                    ]);

                    Log::info("Full refund issued for order #{$order->id}");
                    return [
                        'success' => true,
                        'message' => 'Full refund processed ($' . number_format($order->finel_price, 2) . ')'
                    ];

                } else {
                    Log::warning("Cannot refund payment with status {$paymentIntent->status} for order #{$order->id}");
                    return [
                        'success' => false,
                        'message' => "Cannot refund payment with status: {$paymentIntent->status}"
                    ];
                }

            } else {
                // Partial refund
                $refundAmount = floatval($dispute->amount);
                $finalPrice = floatval($order->finel_price);

                if (!$refundAmount || $refundAmount > $finalPrice) {
                    Log::warning("Invalid refund amount for order #{$order->id}: {$refundAmount}");
                    return [
                        'success' => false,
                        'message' => 'Invalid refund amount'
                    ];
                }

                if ($paymentIntent->status === 'requires_capture') {
                    $paymentIntent->capture();
                }

                if ($paymentIntent->status === 'succeeded') {
                    Refund::create([
                        'payment_intent' => $order->payment_id,
                        'amount' => round($refundAmount * 100)
                    ]);

                    Log::info("Partial refund of {$refundAmount} for order #{$order->id}");
                    return [
                        'success' => true,
                        'message' => "Partial refund processed ($" . number_format($refundAmount, 2) . ")"
                    ];

                } else {
                    return [
                        'success' => false,
                        'message' => "Cannot process partial refund - payment status: {$paymentIntent->status}"
                    ];
                }
            }

        } catch (ApiErrorException $e) {
            Log::error("Stripe API error for order #{$order->id}", [
                'error' => $e->getMessage()
            ]);
            return [
                'success' => false,
                'message' => 'Stripe error: ' . $e->getMessage()
            ];

        } catch (\Exception $e) {
            Log::error("Refund failed for order #{$order->id}", [
                'error' => $e->getMessage()
            ]);
            return [
                'success' => false,
                'message' => 'Refund failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Update transaction status
     */
    private function updateTransactionStatus(BookOrder $order, DisputeOrder $dispute): void
    {
        try {
            $transaction = Transaction::where('buyer_id', $order->user_id)
                ->where('seller_id', $order->teacher_id)
                ->first();

            if (!$transaction) {
                Log::warning("No transaction found for order #{$order->id}");
                return;
            }

            if ($dispute->refund_type == 0) {
                // Full refund
                $transaction->markAsRefunded();
                $transaction->payout_status = 'failed';
                $transaction->notes .= "\n[" . now()->format('Y-m-d H:i:s') . "] Auto-dispute resolved - Full refund after 48 hours";

            } else {
                // Partial refund
                $refundAmount = floatval($dispute->amount);
                $remainingAmount = $transaction->total_amount - $refundAmount;

                $newSellerCommission = ($remainingAmount * $transaction->seller_commission_rate) / 100;
                $newBuyerCommission = ($remainingAmount * $transaction->buyer_commission_rate) / 100;

                $transaction->coupon_discount += $refundAmount;
                $transaction->seller_commission_amount = $newSellerCommission;
                $transaction->buyer_commission_amount = $newBuyerCommission;
                $transaction->total_admin_commission = $newSellerCommission + $newBuyerCommission;
                $transaction->seller_earnings = $remainingAmount - $newSellerCommission;
                $transaction->notes .= "\n[" . now()->format('Y-m-d H:i:s') . "] Auto-dispute resolved - Partial refund: $" . $refundAmount;
            }

            $transaction->save();

            Log::info("Transaction #{$transaction->id} updated for auto-dispute order #{$order->id}");

        } catch (\Exception $e) {
            Log::error("Failed to update transaction for order #{$order->id}: " . $e->getMessage());
            // Don't throw - continue with dispute processing
        }
    }

    /**
     * Send dispute resolution notifications
     */
    private function sendDisputeResolutionNotifications(BookOrder $order, DisputeOrder $dispute): void
    {
        try {
            $serviceName = $order->title ?? ($order->gig ? $order->gig->name : 'Service');
            $refundAmount = $dispute->amount;
            $refundType = $dispute->refund_type == 0 ? 'Full' : 'Partial';

            // Notify buyer (who filed the dispute)
            $this->notificationService->send(
                userId: $order->user_id,
                type: 'dispute_resolved',
                title: 'Refund Processed',
                message: "Your dispute was resolved. {$refundType} refund of $" . number_format($refundAmount, 2) . " has been processed.",
                data: [
                    'dispute_id' => $dispute->id,
                    'order_id' => $order->id,
                    'service_name' => $serviceName,
                    'refund_amount' => $refundAmount,
                    'refund_type' => $refundType,
                    'resolved_at' => now()->toDateTimeString()
                ],
                sendEmail: true
            );

            // Notify seller
            $this->notificationService->send(
                userId: $order->teacher_id,
                type: 'dispute_resolved',
                title: 'Dispute Resolved',
                message: "Dispute for order #{$order->id} resolved. {$refundType} refund issued to buyer.",
                data: [
                    'dispute_id' => $dispute->id,
                    'order_id' => $order->id,
                    'service_name' => $serviceName,
                    'refund_amount' => $refundAmount,
                    'refund_type' => $refundType,
                    'resolved_at' => now()->toDateTimeString()
                ],
                sendEmail: true
            );

            // Notify admins
            $adminIds = User::where('role', 'admin')->pluck('id')->toArray();
            if (!empty($adminIds)) {
                $this->notificationService->sendToMultipleUsers(
                    userIds: $adminIds,
                    type: 'dispute_resolved',
                    title: 'Dispute Resolved',
                    message: "Dispute #{$dispute->id} auto-resolved. {$refundType} refund processed.",
                    data: [
                        'dispute_id' => $dispute->id,
                        'order_id' => $order->id,
                        'refund_amount' => $refundAmount,
                        'resolved_at' => now()->toDateTimeString()
                    ],
                    sendEmail: false
                );
            }

            Log::info("Dispute resolution notifications sent for order #{$order->id}");

        } catch (\Exception $e) {
            Log::error("Failed to send dispute resolution notifications for order #{$order->id}: " . $e->getMessage());
            // Don't throw - not critical
        }
    }
}
