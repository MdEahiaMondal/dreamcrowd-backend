<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'coupon_name',
        'coupon_code',
        'discount_type',
        'discount_value',
        'start_date',
        'expiry_date',
        'coupon_type',
        'seller_email',
        'seller_id',
        'is_active',
        'one_time_use',
        'usage_limit',
        'usage_count',
        'total_discount_given',
        'description',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'total_discount_given' => 'decimal:2',
        'is_active' => 'boolean',
        'one_time_use' => 'boolean',
        'start_date' => 'date',
        'expiry_date' => 'date',
    ];

    // ============ RELATIONSHIPS ============

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function usages()
    {
        return $this->hasMany(CouponUsage::class);
    }

    // ============ SCOPES ============

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeValid($query)
    {
        $today = Carbon::today();
        return $query->where('is_active', 1)
            ->where('start_date', '<=', $today)
            ->where('expiry_date', '>=', $today);
    }

    public function scopeExpired($query)
    {
        return $query->where('expiry_date', '<', Carbon::today());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', Carbon::today());
    }

    // ============ STATUS METHODS ============

    public function isValid()
    {
        $today = Carbon::today();

        // Check if active
        if (!$this->is_active) {
            return ['valid' => false, 'message' => 'Coupon is inactive'];
        }

        // Check date range
        if ($today->lt($this->start_date)) {
            return ['valid' => false, 'message' => 'Coupon is not yet active'];
        }

        if ($today->gt($this->expiry_date)) {
            return ['valid' => false, 'message' => 'Coupon has expired'];
        }

        // Check usage limit
        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) {
            return ['valid' => false, 'message' => 'Coupon usage limit reached'];
        }

        return ['valid' => true, 'message' => 'Coupon is valid'];
    }

    public function getStatus()
    {
        $today = Carbon::today();

        if (!$this->is_active) {
            return 'inactive';
        }

        if ($today->lt($this->start_date)) {
            return 'upcoming';
        }

        if ($today->gt($this->expiry_date)) {
            return 'expired';
        }

        return 'active';
    }

    public function getStatusBadgeColor()
    {
        return match($this->getStatus()) {
            'active' => 'success',
            'expired' => 'danger',
            'upcoming' => 'info',
            'inactive' => 'secondary',
            default => 'secondary',
        };
    }

    // ============ DISCOUNT CALCULATION ============

    public function calculateDiscount($amount)
    {
        if ($this->discount_type === 'percentage') {
            return ($amount * $this->discount_value) / 100;
        }

        // Fixed amount - cannot exceed the total amount
        return min($this->discount_value, $amount);
    }

    public function applyDiscount($amount)
    {
        $discount = $this->calculateDiscount($amount);
        return max(0, $amount - $discount);
    }

    // ============ VALIDATION METHODS ============

    public function canBeUsedBy($userId, $sellerId = null)
    {
        // Check if coupon is valid
        $validation = $this->isValid();
        if (!$validation['valid']) {
            return $validation;
        }

        // Check seller-specific coupon
        if ($this->coupon_type === 'custom') {
            if (!$sellerId || $this->seller_id != $sellerId) {
                return ['valid' => false, 'message' => 'Coupon is only valid for specific seller'];
            }
        }

        // Check one-time use
        if ($this->one_time_use) {
            $alreadyUsed = CouponUsage::where('coupon_id', $this->id)
                ->where('buyer_id', $userId)
                ->exists();

            if ($alreadyUsed) {
                return ['valid' => false, 'message' => 'Coupon already used'];
            }
        }

        return ['valid' => true, 'message' => 'Coupon is valid'];
    }

    // ============ USAGE TRACKING ============

    public function recordUsage($buyerId, $discountAmount, $originalAmount, $finalAmount, $sellerId = null, $transactionId = null, $orderId = null)
    {
        // Create usage record
        CouponUsage::create([
            'coupon_id' => $this->id,
            'coupon_code' => $this->coupon_code,
            'buyer_id' => $buyerId,
            'seller_id' => $sellerId,
            'transaction_id' => $transactionId,
            'order_id' => $orderId,
            'discount_amount' => $discountAmount,
            'original_amount' => $originalAmount,
            'final_amount' => $finalAmount,
        ]);

        // Update coupon statistics
        $this->increment('usage_count');
        $this->increment('total_discount_given', $discountAmount);
    }

    // ============ STATIC METHODS ============

    public static function findByCode($code)
    {
        return self::where('coupon_code', strtoupper($code))->first();
    }

    public static function validateCode($code, $userId, $sellerId = null)
    {
        $coupon = self::findByCode($code);

        if (!$coupon) {
            return ['valid' => false, 'message' => 'Invalid coupon code', 'coupon' => null];
        }

        $validation = $coupon->canBeUsedBy($userId, $sellerId);

        return [
            'valid' => $validation['valid'],
            'message' => $validation['message'],
            'coupon' => $validation['valid'] ? $coupon : null
        ];
    }
}
