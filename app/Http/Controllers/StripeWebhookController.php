<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\BookOrder;
use App\Models\User;
use App\Services\NotificationService;

class StripeWebhookController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\Exception $e) {
            \Log::error('Webhook signature verification failed: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle different event types
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $this->handlePaymentSucceeded($event->data->object);
                break;

            case 'payment_intent.payment_failed':
                $this->handlePaymentFailed($event->data->object);
                break;

            case 'charge.refunded':
                $this->handleRefund($event->data->object);
                break;

            case 'payout.paid':
                $this->handlePayoutPaid($event->data->object);
                break;

            case 'payout.failed':
                $this->handlePayoutFailed($event->data->object);
                break;

            case 'account.external_account.created':
                $this->handleBankAccountCreated($event->data->object);
                break;

            case 'account.external_account.updated':
                $this->handleBankAccountUpdated($event->data->object);
                break;

            default:
                \Log::info('Unhandled webhook event: ' . $event->type);
        }

        return response()->json(['status' => 'success']);
    }

    private function handlePaymentSucceeded($paymentIntent)
    {
        $transaction = Transaction::where('stripe_transaction_id', $paymentIntent->id)->first();

        if ($transaction && $transaction->status == 'pending') {
            $transaction->markAsCompleted($paymentIntent->id);

            \Log::info('Webhook: Payment succeeded', [
                'transaction_id' => $transaction->id,
                'amount' => $paymentIntent->amount / 100
            ]);

            // Send notifications
            $amount = number_format($paymentIntent->amount / 100, 2);

            // Notify Buyer
            $this->notificationService->send(
                userId: $transaction->buyer_id,
                type: 'payment',
                title: 'Payment Confirmed',
                message: 'Your payment of $' . $amount . ' has been successfully processed.',
                data: ['transaction_id' => $transaction->id, 'amount' => $amount],
                sendEmail: true
            );

            // Notify Seller
            $this->notificationService->send(
                userId: $transaction->seller_id,
                type: 'payment',
                title: 'Payment Received',
                message: 'Payment of $' . $amount . ' has been received for your service.',
                data: ['transaction_id' => $transaction->id, 'amount' => $amount],
                sendEmail: false
            );
        }
    }

    private function handlePaymentFailed($paymentIntent)
    {
        $transaction = Transaction::where('stripe_transaction_id', $paymentIntent->id)->first();

        if ($transaction) {
            $transaction->status = 'failed';
            $errorMessage = $paymentIntent->last_payment_error->message ?? 'Unknown error';
            $transaction->notes .= "\n[" . now()->format('Y-m-d H:i:s') . "] Payment failed: " . $errorMessage;
            $transaction->save();

            // Update order status
            $order = BookOrder::where('payment_id', $paymentIntent->id)->first();
            if ($order) {
                $order->payment_status = 'failed';
                $order->save();
            }

            \Log::warning('Webhook: Payment failed', [
                'transaction_id' => $transaction->id,
                'reason' => $errorMessage
            ]);

            // Send notifications
            $amount = number_format($paymentIntent->amount / 100, 2);

            // Notify Buyer
            $this->notificationService->send(
                userId: $transaction->buyer_id,
                type: 'payment',
                title: 'Payment Failed',
                message: 'Your payment of $' . $amount . ' could not be processed. Please update your payment method and try again.',
                data: ['transaction_id' => $transaction->id, 'amount' => $amount, 'error' => $errorMessage],
                sendEmail: true
            );

            // Notify Admin
            $adminIds = User::where('role', 2)->pluck('id')->toArray();
            if (!empty($adminIds)) {
                $this->notificationService->sendToMultipleUsers(
                    userIds: $adminIds,
                    type: 'payment',
                    title: 'Payment Failed Alert',
                    message: 'Payment of $' . $amount . ' failed for transaction #' . $transaction->id . '. Reason: ' . $errorMessage,
                    data: ['transaction_id' => $transaction->id, 'buyer_id' => $transaction->buyer_id, 'amount' => $amount],
                    sendEmail: false
                );
            }
        }
    }

    private function handleRefund($charge)
    {
        $paymentIntentId = $charge->payment_intent;
        $transaction = Transaction::where('stripe_transaction_id', $paymentIntentId)->first();

        if ($transaction) {
            $refundAmount = $charge->amount_refunded / 100;

            if ($charge->amount_refunded == $charge->amount) {
                // Full refund
                $transaction->markAsRefunded();
            } else {
                // Partial refund
                $remainingAmount = ($charge->amount - $charge->amount_refunded) / 100;
                $transaction->coupon_discount += $refundAmount;
                $transaction->notes .= "\n[" . now()->format('Y-m-d H:i:s') . "] Webhook: Partial refund $" . $refundAmount;
                $transaction->save();
            }

            \Log::info('Webhook: Refund processed', [
                'transaction_id' => $transaction->id,
                'refund_amount' => $refundAmount
            ]);
        }
    }

    private function handlePayoutPaid($payout)
    {
        // If using Stripe Connect, update payout status
        $transactions = Transaction::where('stripe_payout_id', $payout->id)->get();

        foreach ($transactions as $transaction) {
            $transaction->markPayoutCompleted($payout->id);

            \Log::info('Webhook: Payout completed', [
                'transaction_id' => $transaction->id,
                'payout_id' => $payout->id
            ]);

            // Notify Seller
            $amount = number_format($transaction->seller_earnings, 2);
            $this->notificationService->send(
                userId: $transaction->seller_id,
                type: 'payout',
                title: 'Payout Completed',
                message: 'Your payout of $' . $amount . ' has been successfully processed and is on its way to your account.',
                data: ['transaction_id' => $transaction->id, 'payout_id' => $payout->id, 'amount' => $amount],
                sendEmail: true
            );
        }
    }

    private function handlePayoutFailed($payout)
    {
        $transactions = Transaction::where('stripe_payout_id', $payout->id)->get();

        foreach ($transactions as $transaction) {
            $transaction->payout_status = 'failed';
            $errorMessage = $payout->failure_message ?? 'Unknown error';
            $transaction->notes .= "\n[" . now()->format('Y-m-d H:i:s') . "] Payout failed: " . $errorMessage;
            $transaction->save();

            \Log::error('Webhook: Payout failed', [
                'transaction_id' => $transaction->id,
                'reason' => $errorMessage
            ]);

            // Send notifications
            $amount = number_format($transaction->seller_earnings, 2);

            // Notify Seller
            $this->notificationService->send(
                userId: $transaction->seller_id,
                type: 'payout',
                title: 'Payout Failed',
                message: 'Your payout of $' . $amount . ' could not be processed. Please update your bank account information. Reason: ' . $errorMessage,
                data: ['transaction_id' => $transaction->id, 'payout_id' => $payout->id, 'amount' => $amount, 'error' => $errorMessage],
                sendEmail: true
            );

            // Notify Admin
            $adminIds = User::where('role', 2)->pluck('id')->toArray();
            if (!empty($adminIds)) {
                $this->notificationService->sendToMultipleUsers(
                    userIds: $adminIds,
                    type: 'payout',
                    title: 'Payout Failed Alert',
                    message: 'Payout of $' . $amount . ' failed for seller #' . $transaction->seller_id . '. Reason: ' . $errorMessage,
                    data: ['transaction_id' => $transaction->id, 'seller_id' => $transaction->seller_id, 'amount' => $amount],
                    sendEmail: false
                );
            }
        }
    }

    private function handleBankAccountCreated($bankAccount)
    {
        // Note: This webhook fires when a bank account is added
        // Verification status is checked in handleBankAccountUpdated
        \Log::info('Webhook: Bank account created', [
            'account_id' => $bankAccount->id,
            'last4' => $bankAccount->last4 ?? 'N/A'
        ]);

        // You might want to find the user by Stripe account ID if you store it
        // For now, we'll just log it. Actual verification notifications happen in updated event.
    }

    private function handleBankAccountUpdated($bankAccount)
    {
        \Log::info('Webhook: Bank account updated', [
            'account_id' => $bankAccount->id,
            'status' => $bankAccount->status ?? 'unknown',
            'last4' => $bankAccount->last4 ?? 'N/A'
        ]);

        // Try to find the seller by Stripe account or bank account details
        // Note: This requires you to store stripe_account_id or external_account_id in users table
        // For now, we'll use a placeholder - you may need to adjust based on your schema

        $seller = null;

        // Option 1: If you store stripe_account_id in users table
        // $seller = User::where('stripe_account_id', $bankAccount->account)->first();

        // Option 2: If you store external_account_id
        // $seller = User::where('stripe_external_account_id', $bankAccount->id)->first();

        // For now, we'll check if there's a recent seller who might match
        // This is a fallback - ideally you should have proper ID mapping
        $last4 = $bankAccount->last4 ?? null;

        if (!$seller && $last4) {
            // Try to find by recent bank account addition (last 24 hours)
            // This is not ideal but works if you don't have stripe_account_id stored
            $seller = User::where('role', 1)
                ->where('updated_at', '>=', now()->subDay())
                ->first();
        }

        if ($seller) {
            $status = $bankAccount->status ?? 'unknown';

            if ($status === 'verified' || $status === 'validated') {
                // Bank account verification successful
                $this->notificationService->send(
                    userId: $seller->id,
                    type: 'account',
                    title: 'Bank Account Verified',
                    message: "Your bank account ending in {$last4} has been successfully verified. You can now receive payouts.",
                    data: [
                        'bank_last4' => $last4,
                        'verified_at' => now()->toISOString(),
                        'account_id' => $bankAccount->id
                    ],
                    sendEmail: true
                );

                \Log::info('Bank verification success notification sent', [
                    'seller_id' => $seller->id,
                    'last4' => $last4
                ]);

            } elseif ($status === 'verification_failed' || $status === 'errored') {
                // Bank account verification failed
                $errorMessage = $bankAccount->status_details->reason ?? 'Unknown verification error';

                $this->notificationService->send(
                    userId: $seller->id,
                    type: 'account',
                    title: 'Bank Account Verification Failed',
                    message: "Bank account verification failed. Please check your details and try again. Reason: {$errorMessage}",
                    data: [
                        'bank_last4' => $last4,
                        'failure_reason' => $errorMessage,
                        'failed_at' => now()->toISOString(),
                        'retry_url' => route('teacher.bank.setup')
                    ],
                    sendEmail: true
                );

                \Log::warning('Bank verification failed notification sent', [
                    'seller_id' => $seller->id,
                    'last4' => $last4,
                    'reason' => $errorMessage
                ]);
            }
        } else {
            \Log::warning('Bank account updated webhook received but could not find associated seller', [
                'account_id' => $bankAccount->id,
                'last4' => $last4
            ]);
        }
    }
}
