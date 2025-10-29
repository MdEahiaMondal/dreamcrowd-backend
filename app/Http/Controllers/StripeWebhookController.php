<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\BookOrder;

class StripeWebhookController extends Controller
{
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
        }
    }

    private function handlePaymentFailed($paymentIntent)
    {
        $transaction = Transaction::where('stripe_transaction_id', $paymentIntent->id)->first();

        if ($transaction) {
            $transaction->status = 'failed';
            $transaction->notes .= "\n[" . now()->format('Y-m-d H:i:s') . "] Payment failed: " . ($paymentIntent->last_payment_error->message ?? 'Unknown error');
            $transaction->save();

            // Update order status
            $order = BookOrder::where('payment_id', $paymentIntent->id)->first();
            if ($order) {
                $order->payment_status = 'failed';
                $order->save();
            }

            \Log::warning('Webhook: Payment failed', [
                'transaction_id' => $transaction->id,
                'reason' => $paymentIntent->last_payment_error->message ?? 'Unknown'
            ]);
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
        }
    }

    private function handlePayoutFailed($payout)
    {
        $transactions = Transaction::where('stripe_payout_id', $payout->id)->get();

        foreach ($transactions as $transaction) {
            $transaction->payout_status = 'failed';
            $transaction->notes .= "\n[" . now()->format('Y-m-d H:i:s') . "] Payout failed: " . ($payout->failure_message ?? 'Unknown error');
            $transaction->save();

            \Log::error('Webhook: Payout failed', [
                'transaction_id' => $transaction->id,
                'reason' => $payout->failure_message ?? 'Unknown'
            ]);
        }
    }
}
