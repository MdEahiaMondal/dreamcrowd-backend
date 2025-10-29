<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Schedule your custom command
        $schedule->command('update:teacher-gig-status')->everyFiveMinutes();
        $schedule->command('orders:auto-cancel')
            ->everyTenMinutes()
            ->withoutOverlapping()
            ->runInBackground()
            ->appendOutputTo(storage_path('logs/auto-cancel.log'));
        $schedule->command('orders:auto-deliver')->hourly();
        $schedule->command('orders:auto-complete')->hourly();
        $schedule->command('disputes:process')->hourly(); // Or every 30 minutes
    }


    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {

        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

}
