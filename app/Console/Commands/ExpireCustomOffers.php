<?php

namespace App\Console\Commands;

use App\Models\CustomOffer;
use App\Services\NotificationService;
use App\Mail\CustomOfferExpired;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ExpireCustomOffers extends Command
{
    protected $signature = 'custom-offers:expire {--dry-run : Run without making actual changes}';
    protected $description = 'Mark pending custom offers as expired after their expiration date has passed';

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    public function handle()
    {
        $isDryRun = $this->option('dry-run');

        if ($isDryRun) {
            $this->info('🔍 Running in DRY RUN mode - no actual changes will be made');
        }

        Log::info('========================================');
        Log::info('Custom offers expiry command started', [
            'timestamp' => now()->toDateTimeString(),
            'dry_run' => $isDryRun
        ]);

        $now = Carbon::now();

        // Get pending offers that have expired
        $offers = CustomOffer::where('status', 'pending')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', $now)
            ->with(['seller', 'buyer', 'gig'])
            ->get();

        if ($offers->isEmpty()) {
            $this->info('✅ No offers to expire');
            Log::info('No pending offers to expire');
            return 0;
        }

        $this->info("📋 Found {$offers->count()} expired offers to process");

        $expiredCount = 0;
        $errorCount = 0;

        foreach ($offers as $offer) {
            try {
                $result = $this->processOfferExpiry($offer, $isDryRun);

                if ($result['action'] === 'expired') {
                    $expiredCount++;
                    $this->info("✅ Offer #{$offer->id} marked as expired");
                } else {
                    $this->line("⏭️  Offer #{$offer->id}: {$result['reason']}");
                }

            } catch (\Exception $e) {
                $errorCount++;
                $this->error("❌ Offer #{$offer->id} failed: " . $e->getMessage());
                Log::error("Custom offer expiry error for offer {$offer->id}", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        // Summary
        $this->newLine();
        $this->info('========================================');
        $this->info('📊 Custom Offers Expiry Summary:');
        $this->info("   ✅ Expired: {$expiredCount}");
        $this->info("   ⚠️  Errors: {$errorCount}");
        $this->info('========================================');

        Log::info('Custom offers expiry command completed', [
            'expired' => $expiredCount,
            'errors' => $errorCount,
            'timestamp' => now()->toDateTimeString()
        ]);

        return 0;
    }

    /**
     * Process offer expiry
     */
    private function processOfferExpiry(CustomOffer $offer, bool $isDryRun): array
    {
        Log::info("Marking offer #{$offer->id} as expired", [
            'expires_at' => $offer->expires_at->toDateTimeString(),
            'seller_id' => $offer->seller_id,
            'buyer_id' => $offer->buyer_id
        ]);

        if ($isDryRun) {
            return [
                'action' => 'expired',
                'reason' => '[DRY RUN] Would mark as expired'
            ];
        }

        try {
            // Update offer status to expired
            $offer->markAsExpired();

            // Send notifications to both parties
            $this->sendExpiryNotifications($offer);

            Log::info("Offer #{$offer->id} marked as expired successfully");

            return [
                'action' => 'expired',
                'reason' => 'Expiration date passed'
            ];

        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Send expiry notifications to buyer and seller
     */
    private function sendExpiryNotifications(CustomOffer $offer): void
    {
        try {
            $serviceName = $offer->gig ? $offer->gig->title : 'Service';
            $sellerName = $offer->seller ? ($offer->seller->first_name . ' ' . $offer->seller->last_name) : 'Seller';
            $buyerName = $offer->buyer ? ($offer->buyer->first_name . ' ' . $offer->buyer->last_name) : 'Buyer';

            // Notify buyer
            $this->notificationService->send(
                userId: $offer->buyer_id,
                type: 'custom_offer_expired',
                title: 'Custom Offer Expired',
                message: "The custom offer from {$sellerName} for \"{$serviceName}\" has expired.",
                data: [
                    'offer_id' => $offer->id,
                    'service_name' => $serviceName,
                    'seller_name' => $sellerName,
                    'expired_at' => now()->toDateTimeString()
                ],
                sendEmail: true
            );

            // Notify seller
            $this->notificationService->send(
                userId: $offer->seller_id,
                type: 'custom_offer_expired',
                title: 'Custom Offer Expired',
                message: "Your custom offer to {$buyerName} for \"{$serviceName}\" has expired without acceptance.",
                data: [
                    'offer_id' => $offer->id,
                    'service_name' => $serviceName,
                    'buyer_name' => $buyerName,
                    'expired_at' => now()->toDateTimeString()
                ],
                sendEmail: true
            );

            // Send expiry emails
            if ($offer->buyer && $offer->buyer->email) {
                Mail::to($offer->buyer->email)->send(new CustomOfferExpired($offer, true));
            }

            if ($offer->seller && $offer->seller->email) {
                Mail::to($offer->seller->email)->send(new CustomOfferExpired($offer, false));
            }

            Log::info("Expiry notifications sent for offer #{$offer->id}");

        } catch (\Exception $e) {
            Log::error("Failed to send expiry notifications for offer #{$offer->id}: " . $e->getMessage());
            // Don't throw - not critical
        }
    }
}
