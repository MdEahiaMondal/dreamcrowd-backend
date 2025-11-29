<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AutoProcessPayouts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payouts:auto-process
                            {--dry-run : Run without making changes}
                            {--threshold=0 : Minimum payout amount to process}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically process pending payouts for completed transactions';

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
        $dryRun = $this->option('dry-run');
        $threshold = (float) $this->option('threshold');

        $logPrefix = $dryRun ? '[DRY RUN] ' : '';

        $this->info($logPrefix . 'Starting automated payout processing...');
        Log::info($logPrefix . 'AutoProcessPayouts command started', [
            'dry_run' => $dryRun,
            'threshold' => $threshold,
        ]);

        // Find all eligible transactions
        $transactions = Transaction::with(['seller', 'bookOrder'])
            ->where('status', 'completed')
            ->where('payout_status', 'pending')
            ->where('seller_earnings', '>=', $threshold)
            ->get();

        if ($transactions->isEmpty()) {
            $this->info('No pending payouts found.');
            Log::info('No pending payouts to process');
            return 0;
        }

        $this->info("Found {$transactions->count()} pending payouts to process.");

        $successCount = 0;
        $failCount = 0;
        $totalAmount = 0;

        foreach ($transactions as $transaction) {
            try {
                $seller = $transaction->seller;

                if (!$seller) {
                    $this->warn("Transaction #{$transaction->id} has no associated seller. Skipping.");
                    Log::warning("Transaction #{$transaction->id} has no seller", [
                        'transaction_id' => $transaction->id,
                    ]);
                    $failCount++;
                    continue;
                }

                $this->line("Processing payout for Transaction #{$transaction->id} - Seller: {$seller->name} - Amount: \${$transaction->seller_earnings}");

                if (!$dryRun) {
                    // Update transaction
                    $transaction->payout_status = 'completed';
                    $transaction->payout_at = now();
                    $transaction->notes = ($transaction->notes ?? '')
                        . "\n[" . now()->format('Y-m-d H:i:s') . "] Payout auto-processed by system.";
                    $transaction->save();

                    // Send enhanced email notification
                    $this->sendPayoutEmail($transaction, $seller);

                    // Send in-app notification
                    $this->notificationService->send(
                        userId: $seller->id,
                        type: 'payment',
                        title: 'Payout Completed',
                        message: "Your payout of \${$transaction->seller_earnings} for Transaction #{$transaction->id} has been processed and sent to your account.",
                        data: [
                            'transaction_id' => $transaction->id,
                            'amount' => $transaction->seller_earnings,
                            'order_id' => $transaction->bookOrder->id ?? null,
                        ],
                        sendEmail: false, // Already sent enhanced email above
                        targetUserId: $seller->id
                    );

                    $this->info("✓ Successfully processed payout #{$transaction->id}");
                    Log::info("Payout auto-processed successfully", [
                        'transaction_id' => $transaction->id,
                        'seller_id' => $seller->id,
                        'amount' => $transaction->seller_earnings,
                    ]);
                } else {
                    $this->info("✓ [DRY RUN] Would process payout #{$transaction->id}");
                }

                $successCount++;
                $totalAmount += $transaction->seller_earnings;

            } catch (\Exception $e) {
                $this->error("✗ Failed to process payout #{$transaction->id}: {$e->getMessage()}");
                Log::error("AutoProcessPayouts failed for transaction #{$transaction->id}", [
                    'transaction_id' => $transaction->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                $failCount++;
            }
        }

        $this->newLine();
        $this->info($logPrefix . "=== Payout Processing Summary ===");
        $this->info("Total transactions found: {$transactions->count()}");
        $this->info("Successfully processed: {$successCount}");
        $this->info("Failed: {$failCount}");
        $this->info("Total amount processed: \$" . number_format($totalAmount, 2));

        Log::info($logPrefix . 'AutoProcessPayouts command completed', [
            'total' => $transactions->count(),
            'success' => $successCount,
            'failed' => $failCount,
            'total_amount' => $totalAmount,
        ]);

        return 0;
    }

    /**
     * Send enhanced payout completion email
     */
    protected function sendPayoutEmail(Transaction $transaction, User $seller)
    {
        try {
            Mail::send('emails.payout-completed', [
                'transaction' => $transaction,
                'seller' => $seller,
            ], function ($message) use ($seller, $transaction) {
                $message->to($seller->email, $seller->name)
                    ->subject('Payout Completed - Transaction #' . $transaction->id . ' - ' . config('app.name'));
            });

            Log::info("Payout completion email sent", [
                'transaction_id' => $transaction->id,
                'seller_email' => $seller->email,
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to send payout email", [
                'transaction_id' => $transaction->id,
                'seller_id' => $seller->id,
                'error' => $e->getMessage(),
            ]);
            // Don't throw - email failure shouldn't stop payout processing
        }
    }
}
