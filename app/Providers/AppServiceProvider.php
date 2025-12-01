<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Services\CurrencyService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // NotificationService-কে singleton হিসেবে bind করছি
        $this->app->singleton(\App\Services\NotificationService::class, function ($app) {
            return new \App\Services\NotificationService();
        });

        // MessageService-কে singleton হিসেবে bind করছি
        $this->app->singleton(\App\Services\MessageService::class, function ($app) {
            return new \App\Services\MessageService();
        });

        // Register GoogleAnalyticsService as singleton
        $this->app->singleton(\App\Services\GoogleAnalyticsService::class, function ($app) {
            return new \App\Services\GoogleAnalyticsService();
        });

        // Note: Spatie Laravel Analytics auto-registers via its service provider
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Currency formatting Blade directives
        $this->registerCurrencyDirectives();
    }

    /**
     * Register currency-related Blade directives
     */
    private function registerCurrencyDirectives(): void
    {
        // Format amount with currency symbol (converts USD to user's display currency)
        // Usage: @currency($amount) or @currency($amount, 'GBP')
        Blade::directive('currency', function ($expression) {
            return "<?php echo \App\Services\CurrencyService::format($expression); ?>";
        });

        // Format without conversion (amount already in correct currency)
        // Usage: @currencyRaw($amount) or @currencyRaw($amount, 'USD')
        Blade::directive('currencyRaw', function ($expression) {
            return "<?php echo \App\Services\CurrencyService::formatRaw($expression); ?>";
        });

        // Get just the currency symbol
        // Usage: @currencySymbol() or @currencySymbol('GBP')
        Blade::directive('currencySymbol', function ($expression) {
            $expression = $expression ?: 'null';
            return "<?php echo \App\Services\CurrencyService::symbol($expression); ?>";
        });

        // Convert amount only (no formatting, returns number)
        // Usage: @currencyConvert($amount, 'USD', 'GBP')
        Blade::directive('currencyConvert', function ($expression) {
            return "<?php echo \App\Services\CurrencyService::convert($expression); ?>";
        });

        // Get current display currency code
        // Usage: @displayCurrency
        Blade::directive('displayCurrency', function () {
            return "<?php echo \App\Services\CurrencyService::getDisplayCurrency(); ?>";
        });
    }
}
