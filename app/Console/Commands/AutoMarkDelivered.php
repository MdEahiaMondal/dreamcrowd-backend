<?php

namespace App\Console\Commands;

use App\Models\BookOrder;
use App\Models\ClassDate;
use App\Models\ClassReschedule;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoMarkDelivered extends Command
{

    protected $signature = 'orders:auto-deliver';
    protected $description = 'Mark BookOrders as delivered after 12 hours past due date';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:auto-mark-delivered';

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

        $orders = BookOrder::where('status', 1)->where('freelance_service','!=','Normal')->get();

        foreach ($orders as $order) {
            if ($order->payment_type == 'Subscription') {
                $dueDate = Carbon::parse($order->created_at)->addMonth();
            } elseif ($order->payment_type == 'OneOff') {
                $lastClass = ClassDate::where('order_id', $order->id)->orderByDesc('teacher_date')->first();
                if (!$lastClass) continue;
                $dueDate = Carbon::parse($lastClass->teacher_date);
            } else {
                continue;
            }

            // Check if 12 hours have passed
            // if ($dueDate->copy()->addHours(12)->lt($now)) {
            if ($dueDate->copy()->lt($now)) {
            
                    $classes = ClassReschedule::where(['order_id'=>$order->id,'status'=>0])->get();
                foreach ($classes as $key => $value) {
                    $value->status = 2;
                    $value->update();
                }

                $order->status = 2; // Delivered
                $order->save();
                $this->info("Order ID {$order->id} marked as delivered.");
            }
        }

        return 0;
    }
}
