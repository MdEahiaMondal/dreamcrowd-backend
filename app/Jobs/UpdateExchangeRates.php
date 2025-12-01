<?php

namespace App\Jobs;

use App\Models\Currency;
use App\Models\ExchangeRate;
use App\Services\CurrencyService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateExchangeRates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public int $backoff = 60;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $apiKey = config('services.currency.api_key');
        $apiUrl = config('services.currency.api_url', 'https://api.currencyapi.com/v3/latest');

        if (!$apiKey) {
            Log::warning('Currency API key not configured. Skipping exchange rate update.');
            return;
        }

        try {
            Log::info('Starting exchange rate update from CurrencyAPI...');

            // Fetch rates from API with USD as base currency
            $response = Http::timeout(30)->get($apiUrl, [
                'apikey' => $apiKey,
                'currencies' => 'GBP',
                'base_currency' => 'USD',
            ]);

            if (!$response->successful()) {
                Log::error('Currency API request failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return;
            }

            $data = $response->json();

            if (!isset($data['data']['GBP']['value'])) {
                Log::error('Invalid response from Currency API', ['response' => $data]);
                return;
            }

            // Get currency records
            $usd = Currency::where('code', 'USD')->first();
            $gbp = Currency::where('code', 'GBP')->first();

            if (!$usd || !$gbp) {
                Log::error('USD or GBP currency not found in database. Run migrations first.');
                return;
            }

            // Extract rate
            $usdToGbpRate = (float) $data['data']['GBP']['value'];
            $gbpToUsdRate = 1 / $usdToGbpRate;

            // Update USD to GBP rate
            ExchangeRate::updateOrCreate(
                [
                    'from_currency_id' => $usd->id,
                    'to_currency_id' => $gbp->id,
                ],
                [
                    'rate' => $usdToGbpRate,
                    'is_active' => true,
                ]
            );

            // Update GBP to USD rate
            ExchangeRate::updateOrCreate(
                [
                    'from_currency_id' => $gbp->id,
                    'to_currency_id' => $usd->id,
                ],
                [
                    'rate' => $gbpToUsdRate,
                    'is_active' => true,
                ]
            );

            // Clear cached rates so they're refreshed
            CurrencyService::clearRateCache();

            // Store last update timestamp
            Cache::put('exchange_rates_last_updated', now()->toISOString(), 86400);

            Log::info('Exchange rates updated successfully', [
                'USD_TO_GBP' => round($usdToGbpRate, 6),
                'GBP_TO_USD' => round($gbpToUsdRate, 6),
                'source' => 'currencyapi.com',
                'updated_at' => now()->toISOString(),
            ]);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Currency API connection failed', [
                'error' => $e->getMessage(),
            ]);
            throw $e; // Will trigger retry

        } catch (\Exception $e) {
            Log::error('Failed to update exchange rates', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('UpdateExchangeRates job failed after all retries', [
            'error' => $exception->getMessage(),
        ]);
    }
}
