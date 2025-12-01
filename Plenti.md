# DreamCrowd Currency & Payment System - Complete Implementation Plan

## Client Requirements Summary

### Core Requirements (100% Clear)

1. **All payments are in USD only**
   - Buyers pay in USD
   - Database stores amounts in USD
   - Stripe processes payments in USD

2. **Company is UK-based but takes payments in USD**
   - Stripe auto-converts USD → GBP when paying out to company's UK bank

3. **User Currency Display Toggle**
   - Users can select their preferred display currency from any page (public, admin, seller, user panels)
   - When user selects GBP, all prices convert and display in GBP
   - **Payment always stays in USD** - only display changes
   - Currently support: **USD (default) and GBP only**

4. **Real-time Exchange Rates**
   - Use CurrencyAPI (api.currencyapi.com) to fetch rates
   - Run daily scheduled job to update rates
   - Store rates in database for performance

5. **Seller Withdrawals**
   - Stripe: Auto-converts to seller's local currency
   - Bank Transfer: Manual processing by admin
   - **PayPal: REMOVED** - No longer needed

---

## Complete System Analysis

### Current State Overview

| Component | Status | Issues Found |
|-----------|--------|--------------|
| Database Storage | ✅ USD | No change needed |
| Stripe Payments | ✅ USD | No change needed |
| Hardcoded "$" in PHP | ❌ 67+ instances | CRITICAL - needs fix |
| Hardcoded "$" in Blade | ❌ 50+ instances | CRITICAL - needs fix |
| Hardcoded "$" in JavaScript | ❌ 10+ instances | HIGH - needs fix |
| Exchange Rates | ❌ Hardcoded 0.79/1.27 | Needs API integration |
| Currency Switcher | ❌ Does not exist | Needs implementation |
| PayPal Code | ❌ Still exists | Needs removal |
| Bug: Wrong Symbol | ❌ Uses "£" instead of "$" | BUG in OrderManagement |

---

## Detailed Code Inventory

### 1. Models with Currency Fields

| Model | File | Currency Fields |
|-------|------|-----------------|
| Transaction | `app/Models/Transaction.php` | currency, stripe_currency, total_amount, seller_earnings, etc. |
| BookOrder | `app/Models/BookOrder.php` | price, finel_price, buyer_commission, seller_earnings |
| TopSellerTag | `app/Models/TopSellerTag.php` | currency, stripe_currency, commission rates |
| Withdrawal | `app/Models/Withdrawal.php` | currency, amount, net_amount, processing_fee |
| Coupon | `app/Models/Coupon.php` | discount_value, total_discount_given |
| CustomOffer | `app/Models/CustomOffer.php` | total_amount |
| CustomOfferMilestone | `app/Models/CustomOfferMilestone.php` | price |

### 2. Controllers with Hardcoded Currency (67+ instances)

| Controller | Lines | Issue |
|------------|-------|-------|
| `OrderManagementController.php` | 1440, 1456, 1614, 1712, 1770, 1772, 1820, 1822, 4175, 4198, 4221 | Hardcoded "$" AND **BUG: Line 1440 uses "£"** |
| `StripeWebhookController.php` | 89, 101, 140, 155, 203, 208, 233, 240, 255 | Hardcoded "$" in notifications |
| `MessagesController.php` | 2603 | Hardcoded `'currency' => 'usd'` |
| `BookingController.php` | 481 | Stripe payment intent currency |
| `Admin/CommissionController.php` | 53-54, 88-89, 128-129, 227-228 | Currency validation (USD,GBP,EUR) |

### 3. Blade Views with Hardcoded "$" (50+ instances)

| Category | Files |
|----------|-------|
| Transaction Views | `shared/transaction-details.blade.php` |
| Withdrawal Views | `Teacher-Dashboard/withdrawal-request.blade.php`, `withdrawal-history.blade.php`, `earnings-payouts.blade.php` |
| Admin Views | `Admin-Dashboard/withdrawals/*.blade.php`, `invoice.blade.php`, `analytics.blade.php`, `CommissionReport.blade.php` |
| Booking Views | `Seller-listing/quick-booking.blade.php`, `freelance-booking.blade.php`, `seller-listing-filter.blade.php` |
| Invoice Views | `invoices/seller-earnings-invoice.blade.php`, `invoices/*.blade.php` |
| User Views | `User-Dashboard/transactions.blade.php` |
| Seller Views | `Teacher-Dashboard/transactions.blade.php` |

### 4. JavaScript Files with Hardcoded "$"

| File | Lines | Code |
|------|-------|------|
| `public/assets/teacher/js/custom-offers.js` | 154 | `'Starting from $${parseFloat(service.price)}'` |
| `public/assets/teacher/js/custom-offers.js` | 273 | `<small class="text-muted">Price ($)</small>` |
| `public/assets/teacher/js/custom-offers.js` | 344 | `$' + total.toFixed(2)` |
| `public/assets/teacher/js/custom-offers.js` | 485, 509-510 | Validation messages with "$" |
| `public/assets/user/js/custom-offers-buyer.js` | Multiple | Similar hardcoding |

### 5. Console Commands with Hardcoded "$"

| Command | File | Issue |
|---------|------|-------|
| AutoProcessPayouts | `app/Console/Commands/AutoProcessPayouts.php` | `"Total: $" . amount` |
| AutoHandleDisputes | `app/Console/Commands/AutoHandleDisputes.php` | Hardcoded "$" in refund messages |
| AutoCancelPendingOrders | `app/Console/Commands/AutoCancelPendingOrders.php` | `"Full refund of $"` |

### 6. Export Classes with Hardcoded "$"

| Export Class | File | Instances |
|--------------|------|-----------|
| UserDashboardExport | `app/Exports/UserDashboardExport.php` | 10+ |
| PayoutsExport | `app/Exports/PayoutsExport.php` | 3+ |
| BuyersExport | `app/Exports/BuyersExport.php` | 1+ |
| RefundsExport | `app/Exports/RefundsExport.php` | 2+ |
| AnalyticsSummaryExport | `app/Exports/AnalyticsSummaryExport.php` | 8+ |
| CommissionReportExport | `app/Exports/CommissionReportExport.php` | 5+ |

### 7. Email Templates

| Template | File |
|----------|------|
| Withdrawal Status | `resources/views/emails/withdrawal-status.blade.php` |
| Payout Completed | `resources/views/emails/payout-completed.blade.php` |
| Refund Approved | `resources/views/emails/refund-approved.blade.php` |

### 8. PayPal Legacy Code (To Remove)

| File | What to Remove |
|------|----------------|
| `app/Models/Withdrawal.php` | Lines 20, 48, 156-157, 222 - METHOD_PAYPAL, paypal_payout_id |
| `database/migrations/*_add_payout_settings_to_users_table.php` | paypal_email column |
| `app/Http/Controllers/AdminWithdrawalController.php` | Line 460 - paypal_payout_id in CSV export |

---

## Implementation Plan

### Phase 1: Currency Infrastructure (Priority: CRITICAL)

#### 1.1 Create Currency & ExchangeRate Models

**File:** `app/Models/Currency.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'code',
        'name',
        'symbol',
        'symbol_position', // 'before' or 'after'
        'decimal_places',
        'is_default',
        'is_active',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
        'decimal_places' => 'integer',
    ];

    // Get default currency (USD)
    public static function getDefault()
    {
        return static::where('is_default', true)->first()
            ?? static::where('code', 'USD')->first();
    }

    // Get all active currencies
    public static function getActive()
    {
        return static::where('is_active', true)->get();
    }
}
```

**File:** `app/Models/ExchangeRate.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    protected $fillable = [
        'from_currency_id',
        'to_currency_id',
        'rate',
        'is_active',
    ];

    protected $casts = [
        'rate' => 'decimal:6',
        'is_active' => 'boolean',
    ];

    public function fromCurrency()
    {
        return $this->belongsTo(Currency::class, 'from_currency_id');
    }

    public function toCurrency()
    {
        return $this->belongsTo(Currency::class, 'to_currency_id');
    }

    // Get rate for conversion
    public static function getRate($fromCode, $toCode)
    {
        if ($fromCode === $toCode) return 1;

        $from = Currency::where('code', $fromCode)->first();
        $to = Currency::where('code', $toCode)->first();

        if (!$from || !$to) return 1;

        $rate = static::where('from_currency_id', $from->id)
            ->where('to_currency_id', $to->id)
            ->where('is_active', true)
            ->first();

        return $rate ? $rate->rate : 1;
    }
}
```

#### 1.2 Create Migrations

**File:** `database/migrations/xxxx_create_currencies_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 3)->unique(); // USD, GBP
            $table->string('name', 50); // US Dollar, British Pound
            $table->string('symbol', 5); // $, £
            $table->enum('symbol_position', ['before', 'after'])->default('before');
            $table->tinyInteger('decimal_places')->default(2);
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Seed default currencies
        DB::table('currencies')->insert([
            [
                'code' => 'USD',
                'name' => 'US Dollar',
                'symbol' => '$',
                'symbol_position' => 'before',
                'decimal_places' => 2,
                'is_default' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'GBP',
                'name' => 'British Pound',
                'symbol' => '£',
                'symbol_position' => 'before',
                'decimal_places' => 2,
                'is_default' => false,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
```

**File:** `database/migrations/xxxx_create_exchange_rates_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_currency_id')->constrained('currencies')->onDelete('cascade');
            $table->foreignId('to_currency_id')->constrained('currencies')->onDelete('cascade');
            $table->decimal('rate', 15, 6);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['from_currency_id', 'to_currency_id']);
        });

        // Seed initial exchange rates (USD to GBP)
        $usd = DB::table('currencies')->where('code', 'USD')->first();
        $gbp = DB::table('currencies')->where('code', 'GBP')->first();

        if ($usd && $gbp) {
            DB::table('exchange_rates')->insert([
                [
                    'from_currency_id' => $usd->id,
                    'to_currency_id' => $gbp->id,
                    'rate' => 0.79,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'from_currency_id' => $gbp->id,
                    'to_currency_id' => $usd->id,
                    'rate' => 1.27,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('exchange_rates');
    }
};
```

#### 1.3 Create CurrencyHelper Service

**File:** `app/Services/CurrencyService.php`

```php
<?php

namespace App\Services;

use App\Models\Currency;
use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CurrencyService
{
    /**
     * Get user's selected display currency (from session/cookie)
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
        Session::put('display_currency', strtoupper($code));
    }

    /**
     * Get payment currency (always USD)
     */
    public static function getPaymentCurrency(): string
    {
        return 'USD';
    }

    /**
     * Format amount with currency symbol
     *
     * @param float $amount Amount in USD (base currency)
     * @param string|null $displayCurrency Currency to display in (null = user's preference)
     * @param bool $convert Whether to convert from USD to display currency
     */
    public static function format(
        float $amount,
        ?string $displayCurrency = null,
        bool $convert = true
    ): string {
        $displayCurrency = $displayCurrency ?? self::getDisplayCurrency();
        $currency = self::getCurrencyConfig($displayCurrency);

        // Convert amount if needed
        if ($convert && $displayCurrency !== 'USD') {
            $amount = self::convert($amount, 'USD', $displayCurrency);
        }

        $formatted = number_format($amount, $currency['decimal_places']);

        if ($currency['symbol_position'] === 'before') {
            return $currency['symbol'] . $formatted;
        }

        return $formatted . $currency['symbol'];
    }

    /**
     * Format without conversion (amount already in target currency)
     */
    public static function formatRaw(float $amount, string $currency = 'USD'): string
    {
        return self::format($amount, $currency, false);
    }

    /**
     * Get just the currency symbol
     */
    public static function symbol(?string $code = null): string
    {
        $code = $code ?? self::getDisplayCurrency();
        $currency = self::getCurrencyConfig($code);
        return $currency['symbol'];
    }

    /**
     * Convert amount between currencies
     */
    public static function convert(float $amount, string $from, string $to): float
    {
        if ($from === $to) return $amount;

        $rate = self::getRate($from, $to);
        return round($amount * $rate, 2);
    }

    /**
     * Get exchange rate (cached for 1 hour)
     */
    public static function getRate(string $from, string $to): float
    {
        if ($from === $to) return 1.0;

        $cacheKey = "exchange_rate_{$from}_{$to}";

        return Cache::remember($cacheKey, 3600, function () use ($from, $to) {
            return ExchangeRate::getRate($from, $to);
        });
    }

    /**
     * Get currency configuration
     */
    public static function getCurrencyConfig(string $code): array
    {
        $defaults = [
            'USD' => ['symbol' => '$', 'symbol_position' => 'before', 'decimal_places' => 2],
            'GBP' => ['symbol' => '£', 'symbol_position' => 'before', 'decimal_places' => 2],
        ];

        if (isset($defaults[$code])) {
            return $defaults[$code];
        }

        $currency = Currency::where('code', $code)->first();

        if ($currency) {
            return [
                'symbol' => $currency->symbol,
                'symbol_position' => $currency->symbol_position,
                'decimal_places' => $currency->decimal_places,
            ];
        }

        return $defaults['USD'];
    }

    /**
     * Get all active currencies for dropdown
     */
    public static function getActiveCurrencies(): array
    {
        return Cache::remember('active_currencies', 3600, function () {
            return Currency::where('is_active', true)
                ->select('code', 'name', 'symbol')
                ->get()
                ->toArray();
        });
    }

    /**
     * Clear rate cache (call after updating rates)
     */
    public static function clearRateCache(): void
    {
        Cache::forget('exchange_rate_USD_GBP');
        Cache::forget('exchange_rate_GBP_USD');
        Cache::forget('active_currencies');
    }
}
```

#### 1.4 Create Blade Directives

**File:** `app/Providers/AppServiceProvider.php` (add to boot method)

```php
use Illuminate\Support\Facades\Blade;
use App\Services\CurrencyService;

public function boot(): void
{
    // ... existing code ...

    // Currency formatting directive - converts USD to user's display currency
    Blade::directive('currency', function ($expression) {
        return "<?php echo \App\Services\CurrencyService::format($expression); ?>";
    });

    // Currency without conversion (amount already in correct currency)
    Blade::directive('currencyRaw', function ($expression) {
        return "<?php echo \App\Services\CurrencyService::formatRaw($expression); ?>";
    });

    // Just the symbol
    Blade::directive('currencySymbol', function ($expression) {
        $expression = $expression ?: 'null';
        return "<?php echo \App\Services\CurrencyService::symbol($expression); ?>";
    });

    // Convert amount only (no formatting)
    Blade::directive('currencyConvert', function ($expression) {
        return "<?php echo \App\Services\CurrencyService::convert($expression); ?>";
    });
}
```

**Usage Examples:**
```blade
{{-- Convert USD amount to user's display currency and format --}}
@currency($transaction->total_amount)

{{-- Format without conversion --}}
@currencyRaw($amount, 'USD')

{{-- Just get symbol --}}
@currencySymbol()   {{-- User's selected currency symbol --}}
@currencySymbol('GBP')  {{-- Specific currency symbol --}}
```

---

### Phase 2: Exchange Rate API Integration (Priority: HIGH)

#### 2.1 Create Exchange Rate Update Job

**File:** `app/Jobs/UpdateExchangeRates.php`

```php
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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateExchangeRates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $apiKey = config('services.currency.api_key');
        $apiUrl = config('services.currency.api_url', 'https://api.currencyapi.com/v3/latest');

        if (!$apiKey) {
            Log::warning('Currency API key not configured');
            return;
        }

        try {
            // Get USD as base currency
            $response = Http::get($apiUrl, [
                'apikey' => $apiKey,
                'currencies' => 'GBP', // Only GBP for now
                'base_currency' => 'USD',
            ]);

            if (!$response->successful()) {
                Log::error('Currency API request failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return;
            }

            $data = $response->json()['data'] ?? [];

            // Get currency IDs
            $usd = Currency::where('code', 'USD')->first();
            $gbp = Currency::where('code', 'GBP')->first();

            if (!$usd || !$gbp) {
                Log::error('USD or GBP currency not found in database');
                return;
            }

            // Update USD to GBP rate
            if (isset($data['GBP']['value'])) {
                $usdToGbpRate = $data['GBP']['value'];

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

                // Calculate and update GBP to USD rate
                $gbpToUsdRate = 1 / $usdToGbpRate;

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

                // Clear cache
                CurrencyService::clearRateCache();

                Log::info('Exchange rates updated successfully', [
                    'USD_TO_GBP' => $usdToGbpRate,
                    'GBP_TO_USD' => $gbpToUsdRate,
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Failed to update exchange rates', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}
```

#### 2.2 Add to Scheduler

**File:** `app/Console/Kernel.php` (add to schedule method)

```php
protected function schedule(Schedule $schedule): void
{
    // ... existing schedules ...

    // Update exchange rates daily at 1:00 AM
    $schedule->job(new \App\Jobs\UpdateExchangeRates)
        ->dailyAt('01:00')
        ->withoutOverlapping()
        ->appendOutputTo(storage_path('logs/exchange-rates.log'));
}
```

#### 2.3 Add Configuration

**File:** `config/services.php` (add section)

```php
'currency' => [
    'api_key' => env('CURRENCY_API_KEY'),
    'api_url' => env('CURRENCY_API_URL', 'https://api.currencyapi.com/v3/latest'),
],
```

**File:** `.env` (add)

```
CURRENCY_API_KEY=cur_live_huM4IbE5EgMP2i7FvjyjZf3rhjoI1Ay79WD6V2SE
CURRENCY_API_URL=https://api.currencyapi.com/v3/latest
```

---

### Phase 3: Currency Switcher UI (Priority: HIGH)

#### 3.1 Create Currency Controller

**File:** `app/Http/Controllers/CurrencyController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Services\CurrencyService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Set user's display currency preference
     */
    public function setCurrency(Request $request)
    {
        $validated = $request->validate([
            'currency' => 'required|string|in:USD,GBP',
        ]);

        CurrencyService::setDisplayCurrency($validated['currency']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'currency' => $validated['currency'],
                'symbol' => CurrencyService::symbol($validated['currency']),
            ]);
        }

        return back()->with('success', 'Currency updated to ' . $validated['currency']);
    }

    /**
     * Get current currency info
     */
    public function getCurrency()
    {
        $currency = CurrencyService::getDisplayCurrency();

        return response()->json([
            'currency' => $currency,
            'symbol' => CurrencyService::symbol($currency),
            'available' => CurrencyService::getActiveCurrencies(),
        ]);
    }

    /**
     * Get exchange rates
     */
    public function getRates()
    {
        return response()->json([
            'USD_TO_GBP' => CurrencyService::getRate('USD', 'GBP'),
            'GBP_TO_USD' => CurrencyService::getRate('GBP', 'USD'),
        ]);
    }
}
```

#### 3.2 Add Routes

**File:** `routes/web.php` (add)

```php
// Currency Routes
Route::post('/set-currency', [CurrencyController::class, 'setCurrency'])->name('currency.set');
Route::get('/get-currency', [CurrencyController::class, 'getCurrency'])->name('currency.get');
Route::get('/get-rates', [CurrencyController::class, 'getRates'])->name('currency.rates');
```

#### 3.3 Create Currency Switcher Component

**File:** `resources/views/components/currency-switcher.blade.php`

```blade
@php
    $currentCurrency = \App\Services\CurrencyService::getDisplayCurrency();
    $currencies = [
        'USD' => ['symbol' => '$', 'name' => 'US Dollar'],
        'GBP' => ['symbol' => '£', 'name' => 'British Pound'],
    ];
@endphp

<div class="currency-switcher dropdown">
    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
            id="currencyDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        {{ $currencies[$currentCurrency]['symbol'] }} {{ $currentCurrency }}
    </button>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="currencyDropdown">
        @foreach($currencies as $code => $info)
            <li>
                <a class="dropdown-item {{ $code === $currentCurrency ? 'active' : '' }}"
                   href="#" onclick="switchCurrency('{{ $code }}'); return false;">
                    {{ $info['symbol'] }} {{ $code }} - {{ $info['name'] }}
                </a>
            </li>
        @endforeach
        <li><hr class="dropdown-divider"></li>
        <li class="px-3 py-1">
            <small class="text-muted">
                <i class="bx bx-info-circle"></i> Payments are always in USD
            </small>
        </li>
    </ul>
</div>

<script>
function switchCurrency(currency) {
    fetch('{{ route("currency.set") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ currency: currency })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
```

#### 3.4 Add to Layouts

Add `<x-currency-switcher />` to all main layouts:

| Layout | Location |
|--------|----------|
| Public | `resources/views/layouts/app.blade.php` - in navbar |
| Admin | `resources/views/components/admin-sidebar.blade.php` - in header |
| Teacher | `resources/views/components/teacher-sidebar.blade.php` - in header |
| User | `resources/views/layouts/user.blade.php` - in navbar |

---

### Phase 4: Update All Hardcoded Currency (Priority: CRITICAL)

#### 4.1 Controllers to Update

| Controller | Lines | Before | After |
|------------|-------|--------|-------|
| `OrderManagementController.php` | 1440 | `"£" . number_format($amount, 2)` | `CurrencyService::format($amount)` |
| `OrderManagementController.php` | 1456, 1770, 1772, 1820, 1822 | `"$" . number_format()` | `CurrencyService::format()` |
| `StripeWebhookController.php` | 89, 101, 140, 155, 203, 208, 233, 240, 255 | `"$" . number_format()` | `CurrencyService::format()` |
| `MessagesController.php` | 2603 | `'currency' => 'usd'` | `'currency' => strtolower(CurrencyService::getPaymentCurrency())` |

**Example Fix for OrderManagementController:**
```php
// Before (Line 1440 - BUG: Wrong symbol!)
"Refund processed: £" . number_format($refundAmount, 2)

// After
use App\Services\CurrencyService;
"Refund processed: " . CurrencyService::format($refundAmount)
```

#### 4.2 Blade Views to Update

Replace all instances of:
```blade
${{ number_format($amount, 2) }}
```

With:
```blade
@currency($amount)
```

**Files (50+):**
- `shared/transaction-details.blade.php`
- `Teacher-Dashboard/withdrawal-request.blade.php`
- `Teacher-Dashboard/withdrawal-history.blade.php`
- `Teacher-Dashboard/earnings-payouts.blade.php`
- `Teacher-Dashboard/transactions.blade.php`
- `Admin-Dashboard/withdrawals/index.blade.php`
- `Admin-Dashboard/withdrawals/show.blade.php`
- `Admin-Dashboard/invoice.blade.php`
- `Admin-Dashboard/analytics.blade.php`
- `Admin-Dashboard/CommissionReport.blade.php`
- `Seller-listing/quick-booking.blade.php`
- `Seller-listing/freelance-booking.blade.php`
- `Seller-listing/seller-listing-filter.blade.php`
- `User-Dashboard/transactions.blade.php`
- `invoices/seller-earnings-invoice.blade.php`

#### 4.3 JavaScript Files to Update

**File:** `public/assets/teacher/js/custom-offers.js`

Add global currency formatting function:
```javascript
// Add at top of file
const CurrencyFormatter = {
    symbol: window.currencySymbol || '$',
    format: function(amount) {
        return this.symbol + parseFloat(amount || 0).toFixed(2);
    }
};

// In Blade layout, add:
// <script>window.currencySymbol = '@currencySymbol()';</script>
```

Replace:
```javascript
// Before
'$' + total.toFixed(2)

// After
CurrencyFormatter.format(total)
```

#### 4.4 Console Commands to Update

| Command | Change |
|---------|--------|
| `AutoProcessPayouts.php` | Use `CurrencyService::format()` |
| `AutoHandleDisputes.php` | Use `CurrencyService::format()` |
| `AutoCancelPendingOrders.php` | Use `CurrencyService::format()` |

#### 4.5 Export Classes to Update

| Export | Change |
|--------|--------|
| `UserDashboardExport.php` | Use `CurrencyService::formatRaw()` |
| `PayoutsExport.php` | Use `CurrencyService::formatRaw()` |
| `BuyersExport.php` | Use `CurrencyService::formatRaw()` |
| `RefundsExport.php` | Use `CurrencyService::formatRaw()` |
| `AnalyticsSummaryExport.php` | Use `CurrencyService::formatRaw()` |
| `CommissionReportExport.php` | Use `CurrencyService::formatRaw()` |

---

### Phase 5: Remove PayPal Completely (Priority: MEDIUM)

#### 5.1 Update Withdrawal Model

**File:** `app/Models/Withdrawal.php`

Remove:
- Line 20: `'paypal_payout_id'` from $fillable
- Line 48: `const METHOD_PAYPAL = 'paypal';`
- Lines 156-157: PayPal case in `markAsCompleted()`
- Line 222: PayPal in `getMethodDisplayNameAttribute()`

#### 5.2 Create Migration

**File:** `database/migrations/xxxx_remove_paypal_from_system.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Remove PayPal columns if they exist
        if (Schema::hasColumn('users', 'paypal_email')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('paypal_email');
            });
        }

        if (Schema::hasColumn('withdrawals', 'paypal_payout_id')) {
            Schema::table('withdrawals', function (Blueprint $table) {
                $table->dropColumn('paypal_payout_id');
            });
        }

        // Update preferred_payout_method enum (if it exists)
        if (Schema::hasColumn('users', 'preferred_payout_method')) {
            // Convert any 'paypal' to 'stripe'
            DB::table('users')
                ->where('preferred_payout_method', 'paypal')
                ->update(['preferred_payout_method' => 'stripe']);
        }
    }

    public function down(): void
    {
        // Re-add columns if needed (for rollback)
        Schema::table('users', function (Blueprint $table) {
            $table->string('paypal_email')->nullable();
        });

        Schema::table('withdrawals', function (Blueprint $table) {
            $table->string('paypal_payout_id')->nullable();
        });
    }
};
```

#### 5.3 Update AdminWithdrawalController Export

**File:** `app/Http/Controllers/AdminWithdrawalController.php`

Line 460 - Remove `paypal_payout_id` from CSV export:
```php
// Before
$w->stripe_transfer_id ?? $w->paypal_payout_id ?? $w->bank_reference ?? '-',

// After
$w->stripe_transfer_id ?? $w->bank_reference ?? '-',
```

---

### Phase 6: Admin Currency Management (Priority: LOW)

#### 6.1 Admin Exchange Rate UI

Allow admin to:
- View current exchange rates
- Manually update rates if API fails
- Trigger manual rate update

**Route:** `/admin/exchange-rates`

---

## Implementation Order (Sprint Plan)

### Sprint 1 (Days 1-3) - Infrastructure
- [ ] Create Currency and ExchangeRate models
- [ ] Create database migrations
- [ ] Run migrations and seed data
- [ ] Create CurrencyService class
- [ ] Add Blade directives
- [ ] Add config and .env variables

### Sprint 2 (Days 4-5) - API Integration
- [ ] Create UpdateExchangeRates job
- [ ] Add to scheduler (daily at 1:00 AM)
- [ ] Test API integration
- [ ] Add logging

### Sprint 3 (Days 6-8) - Currency Switcher
- [ ] Create CurrencyController
- [ ] Add routes
- [ ] Create currency-switcher component
- [ ] Add to all layouts (public, admin, seller, user)
- [ ] Test switching works

### Sprint 4 (Days 9-12) - Update All Hardcoded Currency
- [ ] Fix OrderManagementController BUG (£ symbol)
- [ ] Update all controllers (5+ files)
- [ ] Update all Blade views (15+ files)
- [ ] Update JavaScript files (2+ files)
- [ ] Update Console Commands (3 files)
- [ ] Update Export classes (6 files)

### Sprint 5 (Days 13-14) - PayPal Cleanup
- [ ] Update Withdrawal model
- [ ] Run migration to remove PayPal columns
- [ ] Update AdminWithdrawalController export
- [ ] Final testing

---

## Files Summary

### Files to CREATE (11 files)

| File | Purpose |
|------|---------|
| `app/Models/Currency.php` | Currency model |
| `app/Models/ExchangeRate.php` | Exchange rate model |
| `app/Services/CurrencyService.php` | Centralized currency logic |
| `app/Http/Controllers/CurrencyController.php` | Currency API endpoints |
| `app/Jobs/UpdateExchangeRates.php` | Daily rate update job |
| `database/migrations/xxxx_create_currencies_table.php` | Currency table |
| `database/migrations/xxxx_create_exchange_rates_table.php` | Rates table |
| `database/migrations/xxxx_remove_paypal_from_system.php` | Remove PayPal |
| `resources/views/components/currency-switcher.blade.php` | Switcher UI |
| `config/services.php` (update) | Add currency API config |

### Files to MODIFY (80+ files)

| Category | Count | Files |
|----------|-------|-------|
| Controllers | 5+ | OrderManagement, StripeWebhook, Messages, Booking, Admin/Commission |
| Blade Views | 15+ | Transaction, Withdrawal, Booking, Invoice, Admin views |
| JavaScript | 2+ | custom-offers.js, custom-offers-buyer.js |
| Commands | 3 | AutoProcessPayouts, AutoHandleDisputes, AutoCancelPending |
| Exports | 6 | UserDashboard, Payouts, Buyers, Refunds, Analytics, Commission |
| Models | 2 | Withdrawal, TopSellerTag |
| Providers | 1 | AppServiceProvider |
| Config | 2 | services.php, Kernel.php |
| Routes | 1 | web.php |

---

## Testing Checklist

### Currency Display
- [ ] Prices show in USD by default
- [ ] Switching to GBP converts all displayed prices
- [ ] Currency symbol updates correctly ($ or £)
- [ ] Switching back to USD shows original USD amounts
- [ ] Currency preference persists across pages

### Payment Flow
- [ ] Payments still process in USD regardless of display currency
- [ ] Stripe receives correct USD amount
- [ ] Transaction records store USD amounts
- [ ] Invoice shows correct currency

### Exchange Rates
- [ ] Daily job runs and updates rates
- [ ] Rates are cached properly
- [ ] Manual rate update works (admin)
- [ ] API failure doesn't break the site

### All Panels
- [ ] Public site shows currency switcher
- [ ] Admin panel shows currency switcher
- [ ] Seller panel shows currency switcher
- [ ] User panel shows currency switcher

### No PayPal
- [ ] No PayPal options in withdrawal form
- [ ] No PayPal in admin views
- [ ] No PayPal in exports
- [ ] Migration removed PayPal columns

---

## API Reference

### CurrencyAPI.com

**Endpoint:** `https://api.currencyapi.com/v3/latest`

**API Key:** `cur_live_huM4IbE5EgMP2i7FvjyjZf3rhjoI1Ay79WD6V2SE`

**Example Request:**
```
GET https://api.currencyapi.com/v3/latest?apikey=YOUR_KEY&currencies=GBP&base_currency=USD
```

**Example Response:**
```json
{
    "meta": {
        "last_updated_at": "2025-11-30T00:00:00Z"
    },
    "data": {
        "GBP": {
            "code": "GBP",
            "value": 0.79123
        }
    }
}
```
