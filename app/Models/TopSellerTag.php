<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopSellerTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'earning',
        'booking',
        'review',
        'sorting_impressions',
        'sorting_clicks',
        'sorting_orders',
        'sorting_reviews',
        'commission',
        'buyer_commission',
        'buyer_commission_rate',
        'commission_type',
        'currency',
        'stripe_currency',
        'is_active',
        'enable_custom_seller_commission',
        'enable_custom_service_commission',
    ];

    protected $casts = [
        'commission' => 'decimal:2',
        'buyer_commission_rate' => 'decimal:2',
        'buyer_commission' => 'boolean',
        'is_active' => 'boolean',
        'enable_custom_seller_commission' => 'boolean',
        'enable_custom_service_commission' => 'boolean',
    ];

    public static function getCommissionSettings()
    {
        $settings = self::first();
        if (!$settings) {
            return (object)[
                'commission' => 15.00,
                'buyer_commission' => 0,
                'buyer_commission_rate' => 0,
                'commission_type' => 'seller',
                'currency' => 'USD',
                'stripe_currency' => 'GBP',
                'is_active' => 1,
                'enable_custom_seller_commission' => 0,
                'enable_custom_service_commission' => 0,
            ];
        }
        return $settings;
    }

    // Get commission rate for specific seller
    public function getSellerCommissionRate($sellerId)
    {
        // Check if custom seller commission is enabled
        if (!$this->enable_custom_seller_commission) {
            return $this->commission; // Return default
        }

        // Check for custom seller commission
        $sellerCommission = SellerCommission::where('seller_id', $sellerId)
            ->where('is_active', 1)
            ->first();

        return $sellerCommission ? $sellerCommission->commission_rate : $this->commission;
    }

    // Get commission rate for specific service
    public function getServiceCommissionRate($serviceId, $serviceType = 'service')
    {
        // Check if custom service commission is enabled
        if (!$this->enable_custom_service_commission) {
            return $this->commission; // Return default
        }

        // Check for custom service commission
        $serviceCommission = ServiceCommission::where('service_id', $serviceId)
            ->where('service_type', $serviceType)
            ->where('is_active', 1)
            ->first();

        return $serviceCommission ? $serviceCommission->commission_rate : $this->commission;
    }

    // Calculate seller commission with priority: Service > Seller > Default
    public function calculateCommission($amount, $sellerId = null, $serviceId = null, $serviceType = 'service')
    {
        $commissionRate = $this->commission; // Default

        // Priority 1: Check service-specific commission
        if ($serviceId && $this->enable_custom_service_commission) {
            $serviceRate = $this->getServiceCommissionRate($serviceId, $serviceType);
            if ($serviceRate) {
                $commissionRate = $serviceRate;
            }
        } // Priority 2: Check seller-specific commission (if no service override)
        elseif ($sellerId && $this->enable_custom_seller_commission) {
            $sellerRate = $this->getSellerCommissionRate($sellerId);
            if ($sellerRate) {
                $commissionRate = $sellerRate;
            }
        }

        return ($amount * $commissionRate) / 100;
    }

    // Calculate buyer commission
    public function calculateBuyerCommission($amount)
    {
        if (!$this->is_active || !$this->buyer_commission) {
            return 0;
        }

        return ($amount * $this->buyer_commission_rate) / 100;
    }

    // Get seller earnings after commission
    public function getSellerEarnings($amount, $sellerId = null, $serviceId = null, $serviceType = 'service')
    {
        $commission = $this->calculateCommission($amount, $sellerId, $serviceId, $serviceType);
        return $amount - $commission;
    }

    // Convert currency (USD to GBP for Stripe)
    public function convertCurrency($amount, $fromCurrency = 'USD', $toCurrency = 'GBP')
    {
        // You can use an API for real-time rates or store exchange rates
        // For now, using approximate rate: 1 USD = 0.79 GBP
        $exchangeRates = [
            'USD_TO_GBP' => 0.79,
            'GBP_TO_USD' => 1.27,
        ];

        if ($fromCurrency === 'USD' && $toCurrency === 'GBP') {
            return $amount * $exchangeRates['USD_TO_GBP'];
        } elseif ($fromCurrency === 'GBP' && $toCurrency === 'USD') {
            return $amount * $exchangeRates['GBP_TO_USD'];
        }

        return $amount; // Same currency
    }
}
