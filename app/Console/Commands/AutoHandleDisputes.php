<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Models\BookOrder;
use App\Models\DisputeOrder;
use Illuminate\Support\Facades\Log;
use Stripe\PaymentIntent;
use Stripe\Refund;
use Stripe\Stripe;

class AutoHandleDisputes extends Command
{
         protected $signature = 'disputes:process';
    protected $description = 'Automatically refund to user if only user disputed after 48 hours of cancellation';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:auto-handle-disputes';

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
{
    $now = Carbon::now();
    Stripe::setApiKey(env('STRIPE_SECRET'));

    $orders = BookOrder::where('status', 4)
        ->where('action_date', '<=', $now->subHours(48))
        ->where('user_dispute', 1)
        ->where('teacher_dispute', 0)
        ->where('auto_dispute_processed', 0)
        ->where('refund', 0)
        ->get();

        Log::info("Skipping order ".$orders." — no class dates found.");

    foreach ($orders as $order) {
        $dispute = DisputeOrder::where([
            'order_id' => $order->id,
            'status' => 0
        ])->first();

        if (!$dispute) {
            $this->info("No pending dispute found for Order ID: {$order->id}");
            continue;
        }

        try {
            $paymentIntent = PaymentIntent::retrieve($order->payment_id);

            if ($dispute->refund_type == 0) {
                // Full refund (cancel if still cancellable)
                if (in_array($paymentIntent->status, ['requires_capture', 'requires_confirmation', 'requires_payment_method'])) {
                    $paymentIntent->cancel();
                    $this->info("Full refund (cancel) processed for Order ID: {$order->id}");
                } elseif ($paymentIntent->status === 'succeeded') {
                    Refund::create([
                        'payment_intent' => $order->payment_id
                    ]);
                    $this->info("Full refund issued via refund() for Order ID: {$order->id}");
                }
            } else {
                // Partial refund
                $refundAmount = floatval($dispute->amount);
                $finalPrice = floatval($order->finel_price);

                if (!$refundAmount || $refundAmount > $finalPrice) {
                    $this->info("Invalid refund amount for Order ID: {$order->id}");
                    continue;
                }

                if ($paymentIntent->status === 'requires_capture') {
                    $paymentIntent->capture(); // Required before refund
                }

                if ($paymentIntent->status === 'succeeded') {
                    Refund::create([
                        'payment_intent' => $order->payment_id,
                        'amount' => round($refundAmount * 100) // Stripe uses cents
                    ]);
                    $this->info("Partial refund of {$refundAmount} issued for Order ID: {$order->id}");
                }
            }

            // Finalize and prevent re-processing
            $dispute->status = 1;
            $dispute->save();

            $order->auto_dispute_processed = 1;
            $order->refund = 1;
            $order->save();
        } catch (\Exception $e) {
            Log::error("Refund failed for Order ID {$order->id}: " . $e->getMessage());
            $this->info("Refund failed for Order ID {$order->id}: " . $e->getMessage());
        }
    }
}




}
