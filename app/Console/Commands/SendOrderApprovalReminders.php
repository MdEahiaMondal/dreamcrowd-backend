<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BookOrder;
use App\Models\User;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendOrderApprovalReminders extends Command
{
    protected $notificationService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:send-approval-reminders {--dry-run : Run without sending actual notifications}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily reminders to sellers for pending order approvals and notify buyers after 48 hours';

    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');

        if ($isDryRun) {
            $this->info('🔍 Running in DRY RUN mode - no actual notifications will be sent');
        }

        Log::info('========================================');
        Log::info('Order approval reminders command started', [
            'timestamp' => now()->toDateTimeString(),
            'dry_run' => $isDryRun
        ]);

        // Get all pending orders (status = 0) older than 24 hours
        $pendingOrders = BookOrder::where('status', 0)
            ->where('created_at', '<=', Carbon::now()->subHours(24))
            ->with(['user', 'teacher', 'gig'])
            ->get();

        if ($pendingOrders->isEmpty()) {
            $this->info('✅ No pending orders requiring reminders');
            Log::info('No pending orders to process');
            return 0;
        }

        $this->info("📋 Found {$pendingOrders->count()} pending orders to process");
        Log::info("Processing {$pendingOrders->count()} pending orders");

        $sellerReminders = 0;
        $buyerNotifications = 0;
        $errors = 0;

        foreach ($pendingOrders as $order) {
            try {
                $hoursSincecreated = Carbon::parse($order->created_at)->diffInHours(now());

                // Send reminder to seller (every 24 hours)
                if (!$isDryRun) {
                    $this->sendSellerReminder($order, $hoursSincecreated);
                }
                $sellerReminders++;
                $this->line("✉️  Seller reminder sent for order #{$order->id} ({$hoursSincecreated}h old)");

                // After 48 hours, also notify buyer
                if ($hoursSincecreated >= 48) {
                    // Check if buyer has already been notified
                    $alreadyNotified = $order->pending_notification_sent ?? 0;

                    if (!$alreadyNotified) {
                        if (!$isDryRun) {
                            $this->sendBuyerNotification($order, $hoursSincecreated);

                            // Mark as notified
                            $order->pending_notification_sent = 1;
                            $order->save();
                        }
                        $buyerNotifications++;
                        $this->warn("📢 Buyer notified for order #{$order->id} (still pending after {$hoursSincecreated}h)");
                    }
                }

            } catch (\Exception $e) {
                $errors++;
                $this->error("❌ Error processing order #{$order->id}: " . $e->getMessage());
                Log::error("Approval reminder error for order {$order->id}", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        // Summary
        $this->newLine();
        $this->info('========================================');
        $this->info('📊 Approval Reminders Summary:');
        $this->info("   📋 Total Orders Processed: {$pendingOrders->count()}");
        $this->info("   ✉️  Seller Reminders Sent: {$sellerReminders}");
        $this->info("   📢 Buyer Notifications Sent: {$buyerNotifications}");
        $this->info("   ⚠️  Errors: {$errors}");
        $this->info('========================================');

        Log::info('Order approval reminders completed', [
            'total' => $pendingOrders->count(),
            'seller_reminders' => $sellerReminders,
            'buyer_notifications' => $buyerNotifications,
            'errors' => $errors,
            'timestamp' => now()->toDateTimeString()
        ]);

        return 0;
    }

    /**
     * Send reminder to seller about pending order
     */
    private function sendSellerReminder(BookOrder $order, int $hoursPending): void
    {
        $buyer = $order->user;
        $seller = $order->teacher;
        $gig = $order->gig;

        if (!$seller || !$buyer || !$gig) {
            Log::warning("Missing data for order #{$order->id} - skipping seller reminder");
            return;
        }

        $buyerName = $buyer->first_name . ' ' . strtoupper(substr($buyer->last_name, 0, 1));
        $serviceName = $gig->title;

        // Determine urgency based on time
        if ($hoursPending >= 72) {
            $urgency = '🔴 URGENT';
            $message = "URGENT: You have a pending order from {$buyerName} for {$serviceName} waiting for {$hoursPending} hours. Please approve or reject immediately.";
        } elseif ($hoursPending >= 48) {
            $urgency = '🟠 Important';
            $message = "Important: You have a pending order from {$buyerName} for {$serviceName} waiting for {$hoursPending} hours. Please review and respond.";
        } else {
            $urgency = '';
            $message = "You have a pending order from {$buyerName} for {$serviceName}. Please approve or reject soon to provide a good customer experience.";
        }

        // Send in-app notification
        $this->notificationService->send(
            userId: $seller->id,
            type: 'order',
            title: "{$urgency} Pending Order Approval",
            message: $message,
            data: [
                'order_id' => $order->id,
                'buyer_id' => $buyer->id,
                'service_id' => $gig->id,
                'hours_pending' => $hoursPending
            ],
            sendEmail: true, // Send email reminder
            actorUserId: $buyer->id,
            targetUserId: $seller->id,
            orderId: $order->id,
            serviceId: $gig->id,
            isEmergency: $hoursPending >= 72 // Mark as emergency after 72 hours
        );

        Log::info("Seller reminder sent", [
            'order_id' => $order->id,
            'seller_id' => $seller->id,
            'hours_pending' => $hoursPending
        ]);
    }

    /**
     * Send notification to buyer about order still pending
     */
    private function sendBuyerNotification(BookOrder $order, int $hoursPending): void
    {
        $buyer = $order->user;
        $seller = $order->teacher;
        $gig = $order->gig;

        if (!$buyer || !$seller || !$gig) {
            Log::warning("Missing data for order #{$order->id} - skipping buyer notification");
            return;
        }

        $sellerName = $seller->first_name . ' ' . strtoupper(substr($seller->last_name, 0, 1));
        $serviceName = $gig->title;
        $orderUrl = url('/user/class-management');

        $message = "Your order for {$serviceName} from {$sellerName} is still awaiting approval (pending for " . round($hoursPending / 24, 1) . " days). You can:\n" .
                   "• Wait for seller approval\n" .
                   "• Contact the seller directly\n" .
                   "• Cancel the order if needed";

        // Send in-app notification
        $this->notificationService->send(
            userId: $buyer->id,
            type: 'order',
            title: 'Order Still Pending Approval',
            message: $message,
            data: [
                'order_id' => $order->id,
                'seller_id' => $seller->id,
                'service_id' => $gig->id,
                'hours_pending' => $hoursPending,
                'url' => $orderUrl
            ],
            sendEmail: true, // Send email notification
            actorUserId: $seller->id,
            targetUserId: $buyer->id,
            orderId: $order->id,
            serviceId: $gig->id
        );

        Log::info("Buyer notification sent (48h pending)", [
            'order_id' => $order->id,
            'buyer_id' => $buyer->id,
            'hours_pending' => $hoursPending
        ]);
    }
}
