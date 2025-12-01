<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */
    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URL'),
    ],

    'google_maps' => [
        'api_key' => env('GOOGLE_MAPS_API_KEY'),
    ],

   'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT'),
    ],
    
    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],


    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Google Analytics 4 Configuration
    |--------------------------------------------------------------------------
    |
    | This configuration is used for Google Analytics 4 tracking.
    | - enabled: Toggle GA4 tracking on/off
    | - measurement_id: Your GA4 Measurement ID (format: G-XXXXXXXXXX)
    | - api_secret: API secret for Measurement Protocol (server-side tracking)
    | - debug_mode: Enable debug logging (set to APP_DEBUG value)
    |
    */

    'google_analytics' => [
        'enabled' => env('GOOGLE_ANALYTICS_ENABLED', false),
        'measurement_id' => env('GOOGLE_ANALYTICS_MEASUREMENT_ID'),
        'api_secret' => env('GOOGLE_ANALYTICS_API_SECRET'),
        'property_id' => env('GOOGLE_ANALYTICS_PROPERTY_ID'),
        'credentials_path' => storage_path('app/google-analytics-credentials.json'),
        'debug_mode' => env('APP_DEBUG', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Currency API Configuration
    |--------------------------------------------------------------------------
    |
    | This configuration is used for fetching real-time exchange rates.
    | The API is called daily to update USD to GBP conversion rates.
    | API Provider: currencyapi.com
    |
    */

    'currency' => [
        'api_key' => env('CURRENCY_API_KEY'),
        'api_url' => env('CURRENCY_API_URL', 'https://api.currencyapi.com/v3/latest'),
    ],

];
