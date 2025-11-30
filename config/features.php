<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Feature Flags
    |--------------------------------------------------------------------------
    |
    | These feature flags allow you to enable/disable features in the application.
    | Set these in your .env file to control feature availability.
    |
    */

    // Seller Earnings & Payouts Dashboard (Phase 1)
    'seller_earnings_enabled' => env('FEATURE_SELLER_EARNINGS_ENABLED', false),

    // Seller Withdrawals System (Phase 2)
    'seller_withdrawals_enabled' => env('FEATURE_SELLER_WITHDRAWALS_ENABLED', false),
];
