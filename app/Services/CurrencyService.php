<?php

namespace App\Services;

use App\Models\Currency;
use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CurrencyService
{
    /**
     * Default currency configurations (fallback if DB not available)
     */
    private static array $defaultConfigs = [
        'USD' => ['symbol' => '$', 'symbol_position' => 'before', 'decimal_places' => 2, 'name' => 'US Dollar'],
        'GBP' => ['symbol' => '£', 'symbol_position' => 'before', 'decimal_places' => 2, 'name' => 'British Pound'],
        'EUR' => ['symbol' => '€', 'symbol_position' => 'before', 'decimal_places' => 2, 'name' => 'Euro'],
    ];

    /**
     * Get user's selected display currency (from session)
     */
    public static function getDisplayCurrency(): string
    {
        return Session::get('display_currency', 'USD');
    }

    /**
     * Set user's display currency preference
     */
    public static function setDisplayCurrency(string $code): void
    {
        $code = strtoupper($code);
        if (in_array($code, ['USD', 'GBP', 'EUR'])) {
            Session::put('display_currency', $code);
        }
    }

    /**
     * Get payment currency (always USD - payments are only in USD)
     */
    public static function getPaymentCurrency(): string
    {
        return 'USD';
    }

    /**
     * Format amount with currency symbol
     * Converts from USD to user's display currency if needed
     *
     * @param float|int|string $amount Amount in USD (base currency)
     * @param string|null $displayCurrency Currency to display in (null = user's preference)
     * @param bool $convert Whether to convert from USD to display currency
     * @return string Formatted amount with symbol
     */
    public static function format($amount, ?string $displayCurrency = null, bool $convert = true): string
    {
        $amount = (float) $amount;
        $displayCurrency = strtoupper($displayCurrency ?? self::getDisplayCurrency());
        $config = self::getCurrencyConfig($displayCurrency);

        // Convert amount if needed (from USD to display currency)
        if ($convert && $displayCurrency !== 'USD') {
            $amount = self::convert($amount, 'USD', $displayCurrency);
        }

        $formatted = number_format($amount, $config['decimal_places']);

        if ($config['symbol_position'] === 'before') {
            return $config['symbol'] . $formatted;
        }

        return $formatted . $config['symbol'];
    }

    /**
     * Format without conversion (amount already in target currency)
     */
    public static function formatRaw($amount, string $currency = 'USD'): string
    {
        return self::format($amount, $currency, false);
    }

    /**
     * Get just the currency symbol
     */
    public static function symbol(?string $code = null): string
    {
        $code = strtoupper($code ?? self::getDisplayCurrency());
        $config = self::getCurrencyConfig($code);
        return $config['symbol'];
    }

    /**
     * Convert amount between currencies
     */
    public static function convert(float $amount, string $from, string $to): float
    {
        $from = strtoupper($from);
        $to = strtoupper($to);

        if ($from === $to) {
            return $amount;
        }

        $rate = self::getRate($from, $to);
        return round($amount * $rate, 2);
    }

    /**
     * Get exchange rate (cached for 1 hour)
     */
    public static function getRate(string $from, string $to): float
    {
        $from = strtoupper($from);
        $to = strtoupper($to);

        if ($from === $to) {
            return 1.0;
        }

        $cacheKey = "exchange_rate_{$from}_{$to}";

        return Cache::remember($cacheKey, 3600, function () use ($from, $to) {
            try {
                return ExchangeRate::getRate($from, $to);
            } catch (\Exception $e) {
                // Fallback rates if database not available
                $fallbackRates = [
                    'USD' => ['GBP' => 0.79, 'EUR' => 0.92],
                    'GBP' => ['USD' => 1.27, 'EUR' => 1.17],
                    'EUR' => ['USD' => 1.09, 'GBP' => 0.86],
                ];

                if (isset($fallbackRates[$from][$to])) {
                    return $fallbackRates[$from][$to];
                }
                return 1.0;
            }
        });
    }

    /**
     * Get currency configuration
     */
    public static function getCurrencyConfig(string $code): array
    {
        $code = strtoupper($code);

        // Check default configs first (faster)
        if (isset(self::$defaultConfigs[$code])) {
            return self::$defaultConfigs[$code];
        }

        // Try to get from database
        try {
            $currency = Currency::where('code', $code)->first();
            if ($currency) {
                return [
                    'symbol' => $currency->symbol,
                    'symbol_position' => $currency->symbol_position,
                    'decimal_places' => $currency->decimal_places,
                    'name' => $currency->name,
                ];
            }
        } catch (\Exception $e) {
            // Database not available
        }

        // Return USD as fallback
        return self::$defaultConfigs['USD'];
    }

    /**
     * Get all active currencies for dropdown
     */
    public static function getActiveCurrencies(): array
    {
        return Cache::remember('active_currencies', 3600, function () {
            try {
                return Currency::where('is_active', true)
                    ->select('code', 'name', 'symbol')
                    ->get()
                    ->toArray();
            } catch (\Exception $e) {
                // Return default currencies if database not available
                return [
                    ['code' => 'USD', 'name' => 'US Dollar', 'symbol' => '$'],
                    ['code' => 'GBP', 'name' => 'British Pound', 'symbol' => '£'],
                    ['code' => 'EUR', 'name' => 'Euro', 'symbol' => '€'],
                ];
            }
        });
    }

    /**
     * Clear rate cache (call after updating rates)
     */
    public static function clearRateCache(): void
    {
        Cache::forget('exchange_rate_USD_GBP');
        Cache::forget('exchange_rate_GBP_USD');
        Cache::forget('exchange_rate_USD_EUR');
        Cache::forget('exchange_rate_EUR_USD');
        Cache::forget('exchange_rate_GBP_EUR');
        Cache::forget('exchange_rate_EUR_GBP');
        Cache::forget('active_currencies');
    }

    /**
     * Get current exchange rates info
     */
    public static function getRatesInfo(): array
    {
        return [
            'USD_TO_GBP' => self::getRate('USD', 'GBP'),
            'GBP_TO_USD' => self::getRate('GBP', 'USD'),
            'USD_TO_EUR' => self::getRate('USD', 'EUR'),
            'EUR_TO_USD' => self::getRate('EUR', 'USD'),
            'GBP_TO_EUR' => self::getRate('GBP', 'EUR'),
            'EUR_TO_GBP' => self::getRate('EUR', 'GBP'),
            'last_updated' => Cache::get('exchange_rates_last_updated'),
        ];
    }

    /**
     * Format for JavaScript (returns data needed for client-side formatting)
     */
    public static function getJsConfig(): array
    {
        $currency = self::getDisplayCurrency();
        $config = self::getCurrencyConfig($currency);

        return [
            'code' => $currency,
            'symbol' => $config['symbol'],
            'position' => $config['symbol_position'],
            'decimals' => $config['decimal_places'],
            'rate' => $currency === 'USD' ? 1 : self::getRate('USD', $currency),
        ];
    }
}
