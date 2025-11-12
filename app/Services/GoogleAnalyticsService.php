<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GoogleAnalyticsService
{
    protected $measurementId;
    protected $apiSecret;
    protected $enabled;
    protected $debugMode;

    public function __construct()
    {
        $this->measurementId = config('services.google_analytics.measurement_id');
        $this->apiSecret = config('services.google_analytics.api_secret');
        $this->enabled = config('services.google_analytics.enabled', false);
        $this->debugMode = config('services.google_analytics.debug_mode', false);
    }

    /**
     * Track an event via Measurement Protocol
     *
     * @param string $eventName
     * @param array $params
     * @param string|null $clientId
     * @return bool
     */
    public function trackEvent(string $eventName, array $params = [], ?string $clientId = null): bool
    {
        if (!$this->enabled || !$this->measurementId || !$this->apiSecret) {
            if ($this->debugMode) {
                Log::debug('GA4: Tracking disabled or not configured', [
                    'event' => $eventName,
                    'params' => $params
                ]);
            }
            return false;
        }

        $clientId = $clientId ?? $this->generateClientId();

        // Build API endpoint
        $endpoint = $this->debugMode
            ? 'https://www.google-analytics.com/debug/mp/collect'
            : 'https://www.google-analytics.com/mp/collect';

        $url = $endpoint . '?' . http_build_query([
            'measurement_id' => $this->measurementId,
            'api_secret' => $this->apiSecret,
        ]);

        // Build payload
        $payload = [
            'client_id' => $clientId,
            'events' => [
                [
                    'name' => $eventName,
                    'params' => $this->sanitizeParams($params)
                ]
            ]
        ];

        // Add user_id if authenticated
        if (auth()->check()) {
            $payload['user_id'] = (string) auth()->id();
        }

        try {
            $response = Http::timeout(5)->post($url, $payload);

            if ($this->debugMode) {
                Log::debug('GA4: Event sent', [
                    'event' => $eventName,
                    'params' => $params,
                    'response' => $response->json()
                ]);
            }

            return $response->successful();

        } catch (\Exception $e) {
            Log::error('GA4: Event tracking failed', [
                'event' => $eventName,
                'error' => $e->getMessage(),
                'params' => $params
            ]);
            return false;
        }
    }

    /**
     * Track e-commerce purchase
     *
     * @param array $transactionData
     * @return bool
     */
    public function trackPurchase(array $transactionData): bool
    {
        return $this->trackEvent('purchase', [
            'transaction_id' => $transactionData['transaction_id'],
            'value' => (float) $transactionData['value'],
            'currency' => $transactionData['currency'] ?? 'USD',
            'tax' => (float) ($transactionData['tax'] ?? 0),
            'shipping' => (float) ($transactionData['shipping'] ?? 0),
            'coupon' => $transactionData['coupon'] ?? '',
            'items' => $transactionData['items'] ?? [],
            // Custom parameters
            'commission_amount' => (float) ($transactionData['admin_commission'] ?? 0),
            'seller_earnings' => (float) ($transactionData['seller_earnings'] ?? 0),
            'buyer_commission' => (float) ($transactionData['buyer_commission'] ?? 0),
            'service_type' => $transactionData['service_type'] ?? '',
            'service_delivery' => $transactionData['delivery_type'] ?? '',
            'order_frequency' => $transactionData['frequency'] ?? ''
        ]);
    }

    /**
     * Track e-commerce refund
     *
     * @param string $transactionId
     * @param float $value
     * @param string $currency
     * @return bool
     */
    public function trackRefund(string $transactionId, float $value, string $currency = 'USD'): bool
    {
        return $this->trackEvent('refund', [
            'transaction_id' => $transactionId,
            'value' => $value,
            'currency' => $currency
        ]);
    }

    /**
     * Generate client ID for the current user/session
     *
     * @return string
     */
    protected function generateClientId(): string
    {
        if (auth()->check()) {
            // User-based client ID (consistent across sessions)
            return 'user_' . auth()->id();
        }

        // Session-based client ID (for guests)
        $sessionId = session()->getId();
        return 'session_' . ($sessionId ?: Str::random(32));
    }

    /**
     * Sanitize parameters to comply with GA4 requirements
     *
     * @param array $params
     * @return array
     */
    protected function sanitizeParams(array $params): array
    {
        $sanitized = [];

        foreach ($params as $key => $value) {
            // Skip null values
            if ($value === null) {
                continue;
            }

            // Convert booleans to strings
            if (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            }

            // Ensure parameter names are valid (lowercase, alphanumeric, underscores)
            $key = strtolower(preg_replace('/[^a-zA-Z0-9_]/', '_', $key));

            // Truncate strings longer than 100 characters (GA4 limit)
            if (is_string($value) && strlen($value) > 100) {
                $value = substr($value, 0, 100);
            }

            $sanitized[$key] = $value;
        }

        return $sanitized;
    }

    /**
     * Check if tracking is enabled
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled && $this->measurementId && $this->apiSecret;
    }
}
