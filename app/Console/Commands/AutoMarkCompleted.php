<?php

namespace App\Console\Commands;

use App\Models\BookOrder;
use App\Models\ClassDate;
use App\Models\ClassReschedule;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoMarkCompleted extends Command
{
     protected $signature = 'orders:auto-complete';
    protected $description = 'Mark BookOrders as Completed after 24 hours past due date';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:auto-mark-completed';

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

        $orders = BookOrder::where('status', 1)->get();

        foreach ($orders as $order) {
            $dueDate = Carbon::parse($order->action_date);
           

            // Check if 24 hours have passed
            if ($dueDate->copy()->addHours(48)->lt($now)) {

                   

                $order->status = 3; // Delivered
                $order->save();
                $this->info("Order ID {$order->id} marked as Completed.");
            }
        }

        return 0;
    }
}
