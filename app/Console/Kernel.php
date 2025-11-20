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
        $schedule->command('orders:auto-deliver')
            ->hourly()
            ->withoutOverlapping()
            ->runInBackground()
            ->appendOutputTo(storage_path('logs/auto-deliver.log'));
        $schedule->command('orders:auto-complete')
            ->everySixHours()
            ->withoutOverlapping()
            ->runInBackground()
            ->appendOutputTo(storage_path('logs/auto-complete.log'));
        $schedule->command('disputes:process')
            ->dailyAt('03:00')
            ->withoutOverlapping()
            ->runInBackground()
            ->appendOutputTo(storage_path('logs/disputes.log'));
        $schedule->command('trials:generate-meeting-links')
            ->everyFiveMinutes()
            ->withoutOverlapping()
            ->runInBackground()
            ->appendOutputTo(storage_path('logs/trial-meetings.log'));
        $schedule->command('custom-offers:expire')
            ->hourly()
            ->withoutOverlapping()
            ->runInBackground()
            ->appendOutputTo(storage_path('logs/custom-offers-expiry.log'));

        // =====================================================
        // ZOOM INTEGRATION SCHEDULED COMMANDS
        // =====================================================

        // Generate Zoom meetings and secure tokens for classes starting in 30 minutes
        $schedule->command('zoom:generate-meetings')
            ->everyFiveMinutes()
            ->withoutOverlapping()
            ->runInBackground()
            ->appendOutputTo(storage_path('logs/zoom-meetings.log'));

        // Refresh Zoom OAuth tokens for all connected teachers (prevents token expiry)
        $schedule->command('zoom:refresh-tokens')
            ->hourly()
            ->withoutOverlapping()
            ->runInBackground()
            ->appendOutputTo(storage_path('logs/zoom-token-refresh.log'));

        // Optional: Clean up expired secure tokens (older than 7 days)
        $schedule->call(function () {
            \App\Models\ZoomSecureToken::cleanupExpired();
        })
            ->daily()
            ->runInBackground();

        // =====================================================
        // END ZOOM INTEGRATION SCHEDULED COMMANDS
        // =====================================================

        // =====================================================
        // CLASS REMINDERS SCHEDULED COMMANDS
        // =====================================================

        // Send class reminders (24 hours, 1 hour, and 3-day recurring reminders)
        $schedule->command('reminders:send-class-reminders')
            ->hourly()
            ->withoutOverlapping()
            ->runInBackground()
            ->appendOutputTo(storage_path('logs/class-reminders.log'));

        // =====================================================
        // END CLASS REMINDERS SCHEDULED COMMANDS
        // =====================================================

        // =====================================================
        // COUPON NOTIFICATIONS SCHEDULED COMMANDS
        // =====================================================

        // Notify about expiring and expired coupons (runs daily at 9 AM)
        $schedule->command('coupons:notify-expiring')
            ->dailyAt('09:00')
            ->withoutOverlapping()
            ->runInBackground()
            ->appendOutputTo(storage_path('logs/coupon-notifications.log'));

        // =====================================================
        // END COUPON NOTIFICATIONS SCHEDULED COMMANDS
        // =====================================================

        // =====================================================
        // DAILY SYSTEM REPORT SCHEDULED COMMAND
        // =====================================================

        // Send daily system information report via email (runs daily at 8:00 AM)
        $schedule->command('reports:send-daily-system-report')
            ->dailyAt('08:00')
            ->withoutOverlapping()
            ->runInBackground()
            ->appendOutputTo(storage_path('logs/daily-system-report.log'));

        // =====================================================
        // END DAILY SYSTEM REPORT SCHEDULED COMMAND
        // =====================================================
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
