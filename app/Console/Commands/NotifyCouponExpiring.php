<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Coupon;
use App\Models\User;
use App\Services\NotificationService;
use Carbon\Carbon;

class NotifyCouponExpiring extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coupons:notify-expiring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications for coupons that are expiring soon or have expired';

    protected $notificationService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting coupon expiry notification check...');

        // Send notifications for coupons expiring within 7 days
        $this->notifyExpiringSoon();

        // Send notifications for coupons that expired today
        $this->notifyExpiredToday();

        $this->info('Coupon expiry notification check completed.');
        return 0;
    }

    /**
     * Notify sellers about coupons expiring within 7 days
     */
    private function notifyExpiringSoon()
    {
        $sevenDaysFromNow = Carbon::now()->addDays(7)->endOfDay();
        $today = Carbon::now()->startOfDay();

        // Find active coupons expiring within 7 days that haven't been notified yet
        $expiringCoupons = Coupon::where('is_active', 1)
            ->whereBetween('expiry_date', [$today, $sevenDaysFromNow])
            ->where(function($query) {
                // Only notify coupons that haven't been notified today
                $query->whereNull('expiry_notified_at')
                    ->orWhereDate('expiry_notified_at', '<', Carbon::today());
            })
            ->get();

        $this->info('Found ' . $expiringCoupons->count() . ' coupons expiring soon');

        foreach ($expiringCoupons as $coupon) {
            $daysLeft = Carbon::now()->startOfDay()->diffInDays($coupon->expiry_date);

            // Determine recipient based on coupon type
            if ($coupon->coupon_type === 'custom' && $coupon->seller_id) {
                // Custom coupon - notify seller
                $recipient = User::find($coupon->seller_id);
                if (!$recipient) {
                    $this->warn("Seller not found for coupon ID {$coupon->id}");
                    continue;
                }
            } else {
                // Platform-wide coupon - notify admins
                $adminIds = User::where('role', 2)->pluck('id')->toArray();
                if (empty($adminIds)) {
                    $this->warn("No admins found for platform coupon ID {$coupon->id}");
                    continue;
                }

                // Send to all admins
                try {
                    $this->notificationService->sendToMultipleUsers(
                        userIds: $adminIds,
                        type: 'coupon',
                        title: 'Coupon Expiring Soon',
                        message: "Platform coupon '{$coupon->coupon_name}' (code: {$coupon->coupon_code}) will expire in {$daysLeft} day" . ($daysLeft > 1 ? 's' : '') . '.',
                        data: [
                            'coupon_id' => $coupon->id,
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_name' => $coupon->coupon_name,
                            'expiry_date' => $coupon->expiry_date->toISOString(),
                            'days_left' => $daysLeft,
                            'usage_count' => $coupon->usage_count,
                            'coupon_type' => 'platform'
                        ],
                        sendEmail: true
                    );

                    $this->info("Notified admins about platform coupon: {$coupon->coupon_code}");
                } catch (\Exception $e) {
                    $this->error("Failed to notify admins about coupon {$coupon->id}: " . $e->getMessage());
                }

                // Mark as notified
                $coupon->expiry_notified_at = now();
                $coupon->save();
                continue;
            }

            // Send notification to seller for custom coupon
            try {
                $this->notificationService->send(
                    userId: $recipient->id,
                    type: 'coupon',
                    title: 'Coupon Expiring Soon',
                    message: "Your coupon '{$coupon->coupon_name}' (code: {$coupon->coupon_code}) will expire in {$daysLeft} day" . ($daysLeft > 1 ? 's' : '') . ". Consider extending it or creating a new one.",
                    data: [
                        'coupon_id' => $coupon->id,
                        'coupon_code' => $coupon->coupon_code,
                        'coupon_name' => $coupon->coupon_name,
                        'expiry_date' => $coupon->expiry_date->toISOString(),
                        'days_left' => $daysLeft,
                        'usage_count' => $coupon->usage_count,
                        'manage_url' => route('teacher.coupons')
                    ],
                    sendEmail: true
                );

                $this->info("Notified seller about coupon: {$coupon->coupon_code}");

                // Mark coupon as notified (using a timestamp to track last notification)
                // Note: This requires adding 'expiry_notified_at' column to coupons table
                // If column doesn't exist, this will log but not break
                try {
                    $coupon->expiry_notified_at = now();
                    $coupon->save();
                } catch (\Exception $e) {
                    // Column might not exist yet, just log
                    \Log::info("Could not update expiry_notified_at for coupon {$coupon->id}");
                }
            } catch (\Exception $e) {
                $this->error("Failed to send notification for coupon {$coupon->id}: " . $e->getMessage());
            }
        }
    }

    /**
     * Notify sellers about coupons that expired today
     */
    private function notifyExpiredToday()
    {
        $today = Carbon::today();

        // Find coupons that expired today and haven't been marked as expired notified
        $expiredCoupons = Coupon::whereDate('expiry_date', $today)
            ->where('is_active', 1) // Still marked as active in DB
            ->where(function($query) {
                $query->whereNull('expired_notified_at')
                    ->orWhere('expired_notified_at', '<', Carbon::today());
            })
            ->get();

        $this->info('Found ' . $expiredCoupons->count() . ' coupons that expired today');

        foreach ($expiredCoupons as $coupon) {
            // Determine recipient
            if ($coupon->coupon_type === 'custom' && $coupon->seller_id) {
                $recipient = User::find($coupon->seller_id);
                if (!$recipient) {
                    $this->warn("Seller not found for coupon ID {$coupon->id}");
                    continue;
                }

                // Send notification to seller
                try {
                    $this->notificationService->send(
                        userId: $recipient->id,
                        type: 'coupon',
                        title: 'Coupon Expired',
                        message: "Your coupon '{$coupon->coupon_name}' (code: {$coupon->coupon_code}) has expired. It was used {$coupon->usage_count} time" . ($coupon->usage_count !== 1 ? 's' : '') . '.',
                        data: [
                            'coupon_id' => $coupon->id,
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_name' => $coupon->coupon_name,
                            'expiry_date' => $coupon->expiry_date->toISOString(),
                            'usage_count' => $coupon->usage_count,
                            'total_discount' => $coupon->total_discount_given,
                            'create_new_url' => route('teacher.coupons')
                        ],
                        sendEmail: true
                    );

                    $this->info("Notified seller about expired coupon: {$coupon->coupon_code}");
                } catch (\Exception $e) {
                    $this->error("Failed to notify seller about expired coupon {$coupon->id}: " . $e->getMessage());
                }
            } else {
                // Platform coupon - notify admins
                $adminIds = User::where('role', 2)->pluck('id')->toArray();
                if (!empty($adminIds)) {
                    try {
                        $this->notificationService->sendToMultipleUsers(
                            userIds: $adminIds,
                            type: 'coupon',
                            title: 'Platform Coupon Expired',
                            message: "Platform coupon '{$coupon->coupon_name}' (code: {$coupon->coupon_code}) has expired. Usage: {$coupon->usage_count} times, Total discount: \${$coupon->total_discount_given}",
                            data: [
                                'coupon_id' => $coupon->id,
                                'coupon_code' => $coupon->coupon_code,
                                'coupon_name' => $coupon->coupon_name,
                                'expiry_date' => $coupon->expiry_date->toISOString(),
                                'usage_count' => $coupon->usage_count,
                                'total_discount' => $coupon->total_discount_given
                            ],
                            sendEmail: false // Don't email admins for expired platform coupons
                        );

                        $this->info("Notified admins about expired platform coupon: {$coupon->coupon_code}");
                    } catch (\Exception $e) {
                        $this->error("Failed to notify admins about expired coupon {$coupon->id}: " . $e->getMessage());
                    }
                }
            }

            // Mark as expired-notified
            try {
                $coupon->expired_notified_at = now();
                $coupon->save();
            } catch (\Exception $e) {
                \Log::info("Could not update expired_notified_at for coupon {$coupon->id}");
            }
        }
    }
}
