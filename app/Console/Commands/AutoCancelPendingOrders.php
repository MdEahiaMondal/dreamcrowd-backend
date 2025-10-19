<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BookOrder;
use App\Models\CancelOrder;
use App\Models\ClassDate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class AutoCancelPendingOrders extends Command
{

     protected $signature = 'orders:auto-cancel';
    protected $description = 'Cancel pending orders if first class is about to start in 30 mins';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:auto-cancel-pending-orders';

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

         Log::info('Auto-cancel Function is Runned' );
        // Get all pending orders
        $orders = BookOrder::where('status', 0)->get();

        foreach ($orders as $order) {
            $firstClass = ClassDate::where('order_id', $order->id)
                ->orderBy('teacher_date', 'asc')
                ->first();
                // Log::info('Auto-cancel order job started at ....' . $order);

          if (!$firstClass) {
            // Log::info("Skipping order ".$order->order_id." — no class dates found.");
            continue;
        }

            // Parse teacher_date with timezone
            $classDate = Carbon::parse($firstClass->teacher_date, $firstClass->teacher_time_zone);
            $now = Carbon::now($firstClass->teacher_time_zone); 

            // Check if class starts in ≤ 30 minutes
            if ($classDate->diffInMinutes($now, false) >= -30 && $now->lt($classDate) || // starts within 30 mins
                 $now->gt($classDate) // already passed
            ) {
                // Cancel order
                $order->status = 4;
                $order->save();
                // Refund if payment not captured
                if ($order->payment_id) {
                    try {
                        Stripe::setApiKey(env('STRIPE_SECRET'));

                        $paymentIntent = PaymentIntent::retrieve($order->payment_id);

                        if ($paymentIntent->status !== 'succeeded') {
                            $paymentIntent->cancel();
                            $cancelOrder = new CancelOrder();
                            $cancelOrder->user_id = $order->teacher_id ;
                            $cancelOrder->user_role = 1 ;
                            $cancelOrder->order_id =$order->id ;
                            $cancelOrder->reason = 'Not Accepted Order Cancelled Automaticaly' ;
                            $cancelOrder->refund = 1 ;
                           $cancelOrder->amount = $order->finel_price ;
                            $cancelOrder->save();
                            $this->info("Payment cancelled for order: " . $order->order_id);
                            Log::info('Auto-cancel order job started at ' . now());

                        }
                    } catch (\Exception $e) {
                        Log::error("Refund failed for order {$order->order_id}: " . $e->getMessage());

                    }
                }

                $this->info("Order {$order->order_id} cancelled due to imminent start.");
            }
        }
    }



}
