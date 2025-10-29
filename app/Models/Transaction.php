<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'buyer_id',
        'service_id',
        'service_type',
        'total_amount',
        'currency',
        'seller_commission_rate',
        'seller_commission_amount',
        'buyer_commission_rate',
        'buyer_commission_amount',
        'total_admin_commission',
        'seller_earnings',
        'stripe_amount',
        'stripe_currency',
        'stripe_transaction_id',
        'stripe_payout_id',
        'coupon_discount',
        'admin_absorbed_discount',
        'status',
        'payout_status',
        'paid_at',
        'payout_at',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'seller_commission_rate' => 'decimal:2',
        'seller_commission_amount' => 'decimal:2',
        'buyer_commission_rate' => 'decimal:2',
        'buyer_commission_amount' => 'decimal:2',
        'total_admin_commission' => 'decimal:2',
        'seller_earnings' => 'decimal:2',
        'stripe_amount' => 'decimal:2',
        'coupon_discount' => 'decimal:2',
        'admin_absorbed_discount' => 'boolean',
        'paid_at' => 'datetime',
        'payout_at' => 'datetime',
    ];

    // ============ RELATIONSHIPS ============

    /**
     * Get the seller (user) associated with this transaction
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * Get the buyer (user) associated with this transaction
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    /**
     * Get the service associated with this transaction
     * Adjust this based on your service/class model name
     */
    public function service()
    {
        // If you have a Service model
        return $this->belongsTo(TeacherGig::class, 'service_id', 'id');

        // Or if service can be Service or Class, use polymorphic:
//        return $this->morphTo('service', 'service_type', 'service_id');
    }

    // ============ SCOPES ============

    /**
     * Scope for completed transactions
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for pending transactions
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for refunded transactions
     */
    public function scopeRefunded($query)
    {
        return $query->where('status', 'refunded');
    }

    /**
     * Scope for today's transactions
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope for this month's transactions
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);
    }

    /**
     * Scope for pending payouts
     */
    public function scopePendingPayout($query)
    {
        return $query->where('payout_status', 'pending');
    }

    /**
     * Scope for paid payouts
     */
    public function scopePaidPayout($query)
    {
        return $query->where('payout_status', 'paid');
    }

    // ============ HELPER METHODS ============

    /**
     * Mark transaction as completed
     */
    public function markAsCompleted($stripeTransactionId = null)
    {
        $this->status = 'completed';
        $this->paid_at = now();

        if ($stripeTransactionId) {
            $this->stripe_transaction_id = $stripeTransactionId;
        }

        $this->save();

        return $this;
    }

    /**
     * Mark transaction as refunded
     */
    public function markAsRefunded()
    {
        $this->status = 'refunded';

        // Reverse commission amounts
        $this->total_admin_commission = 0;
        $this->seller_earnings = 0;

        $this->save();

        return $this;
    }

    /**
     * Mark payout as completed
     */
    public function markPayoutCompleted($stripePayoutId = null)
    {
        $this->payout_status = 'paid';
        $this->payout_at = now();

        if ($stripePayoutId) {
            $this->stripe_payout_id = $stripePayoutId;
        }

        $this->save();

        return $this;
    }

    /**
     * Get formatted total amount
     */
    public function getFormattedTotalAmountAttribute()
    {
        return $this->currency . ' ' . number_format($this->total_amount, 2);
    }

    /**
     * Get formatted admin commission
     */
    public function getFormattedAdminCommissionAttribute()
    {
        return $this->currency . ' ' . number_format($this->total_admin_commission, 2);
    }

    /**
     * Get formatted seller earnings
     */
    public function getFormattedSellerEarningsAttribute()
    {
        return $this->currency . ' ' . number_format($this->seller_earnings, 2);
    }

    /**
     * Check if transaction is completed
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if transaction is pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if transaction is refunded
     */
    public function isRefunded()
    {
        return $this->status === 'refunded';
    }

    /**
     * Check if payout is pending
     */
    public function isPayoutPending()
    {
        return $this->payout_status === 'pending';
    }

    /**
     * Check if payout is completed
     */
    public function isPayoutCompleted()
    {
        return $this->payout_status === 'paid';
    }

    /**
     * Get transaction age in days
     */
    public function getAgeInDaysAttribute()
    {
        return $this->created_at->diffInDays(now());
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColorAttribute()
    {
        return match ($this->status) {
            'completed' => 'success',
            'pending' => 'warning',
            'refunded' => 'danger',
            'failed' => 'secondary',
            default => 'info',
        };
    }

    /**
     * Get payout status badge color
     */
    public function getPayoutStatusBadgeColorAttribute()
    {
        return match ($this->payout_status) {
            'paid' => 'success',
            'pending' => 'warning',
            'failed' => 'danger',
            default => 'info',
        };
    }

    // ============ STATIC METHODS ============

    /**
     * Calculate total admin earnings
     */
    public static function getTotalAdminEarnings($startDate = null, $endDate = null)
    {
        $query = self::completed();

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        return $query->sum('total_admin_commission');
    }

    /**
     * Calculate total seller earnings
     */
    public static function getTotalSellerEarnings($sellerId, $startDate = null, $endDate = null)
    {
        $query = self::completed()->where('seller_id', $sellerId);

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        return $query->sum('seller_earnings');
    }

    /**
     * Get pending payout amount for a seller
     */
    public static function getPendingPayoutAmount($sellerId)
    {
        return self::where('seller_id', $sellerId)
            ->where('status', 'completed')
            ->where('payout_status', 'pending')
            ->sum('seller_earnings');
    }

    /**
     * Get top earning sellers
     */
    public static function getTopSellers($limit = 10, $startDate = null, $endDate = null)
    {
        $query = self::select('seller_id', \DB::raw('SUM(seller_earnings) as total_earnings'))
            ->completed()
            ->groupBy('seller_id')
            ->orderBy('total_earnings', 'desc')
            ->limit($limit);

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        return $query->with('seller')->get();
    }

    /**
     * Create a new transaction with commission calculation
     */
    public static function createWithCommission($data)
    {
        $commissionSettings = TopSellerTag::getCommissionSettings();

        // Calculate commissions
        $sellerCommissionAmount = $commissionSettings->calculateCommission(
            $data['total_amount'],
            $data['seller_id'] ?? null,
            $data['service_id'] ?? null,
            $data['service_type'] ?? 'service'
        );

        $buyerCommissionAmount = $commissionSettings->calculateBuyerCommission($data['total_amount']);

        $totalAdminCommission = $sellerCommissionAmount + $buyerCommissionAmount;

        $sellerEarnings = $data['total_amount'] - $sellerCommissionAmount;

        // Handle currency conversion if needed
        $stripeAmount = $data['total_amount'];
        if ($commissionSettings->currency != $commissionSettings->stripe_currency) {
            $stripeAmount = $commissionSettings->convertCurrency(
                $data['total_amount'],
                $commissionSettings->currency,
                $commissionSettings->stripe_currency
            );
        }

        // Get commission rates
        $sellerCommissionRate = $commissionSettings->commission;
        if (isset($data['service_id']) && $commissionSettings->enable_custom_service_commission) {
            $sellerCommissionRate = $commissionSettings->getServiceCommissionRate(
                $data['service_id'],
                $data['service_type'] ?? 'service'
            );
        } elseif (isset($data['seller_id']) && $commissionSettings->enable_custom_seller_commission) {
            $sellerCommissionRate = $commissionSettings->getSellerCommissionRate($data['seller_id']);
        }

        // Create transaction
        return self::create([
            'seller_id' => $data['seller_id'],
            'buyer_id' => $data['buyer_id'],
            'service_id' => $data['service_id'] ?? null,
            'service_type' => $data['service_type'] ?? 'service',
            'total_amount' => $data['total_amount'],
            'currency' => $commissionSettings->currency,
            'seller_commission_rate' => $sellerCommissionRate,
            'seller_commission_amount' => $sellerCommissionAmount,
            'buyer_commission_rate' => $commissionSettings->buyer_commission_rate,
            'buyer_commission_amount' => $buyerCommissionAmount,
            'total_admin_commission' => $totalAdminCommission,
            'seller_earnings' => $sellerEarnings,
            'stripe_amount' => $stripeAmount,
            'stripe_currency' => $commissionSettings->stripe_currency,
            'coupon_discount' => $data['coupon_discount'] ?? 0,
            'admin_absorbed_discount' => $data['admin_absorbed_discount'] ?? 0,
            'status' => 'pending',
            'payout_status' => 'pending',
            'notes' => $data['notes'] ?? null,
        ]);
    }

    /**
     * Apply coupon to transaction
     */
    public function applyCoupon($couponCode, $buyerId, $sellerId = null)
    {
        $validation = Coupon::validateCode($couponCode, $buyerId, $sellerId);

        if (!$validation['valid']) {
            return ['success' => false, 'message' => $validation['message']];
        }

        $coupon = $validation['coupon'];

        // Calculate discount
        $discountAmount = $coupon->calculateDiscount($this->total_amount);

        // Discount comes from admin commission, not seller earnings
        $this->coupon_discount = $discountAmount;
        $this->admin_absorbed_discount = 1;

        // Recalculate admin commission (admin absorbs the discount)
        $this->total_admin_commission = max(0, $this->total_admin_commission - $discountAmount);

        $this->save();

        // Record coupon usage
        $coupon->recordUsage(
            $buyerId,
            $discountAmount,
            $this->total_amount,
            $this->total_amount, // Final amount stays same, admin absorbs discount
            $sellerId,
            $this->id
        );

        return ['success' => true, 'message' => 'Coupon applied successfully!', 'discount' => $discountAmount];
    }

    /**
     * Get the book order associated with this transaction
     */
    public function bookOrder()
    {
        return $this->hasOne(BookOrder::class, 'payment_id', 'stripe_transaction_id');
    }
}
