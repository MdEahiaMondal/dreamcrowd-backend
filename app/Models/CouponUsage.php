<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponUsage extends Model
{
    use HasFactory;

    protected $table = 'coupon_usage';

    protected $fillable = [
        'coupon_id',
        'coupon_code',
        'buyer_id',
        'seller_id',
        'transaction_id',
        'order_id',
        'discount_amount',
        'original_amount',
        'final_amount',
        'used_at',
    ];

    protected $casts = [
        'discount_amount' => 'decimal:2',
        'original_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'used_at' => 'datetime',
    ];

    // ============ RELATIONSHIPS ============

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // ============ SCOPES ============

    public function scopeByBuyer($query, $buyerId)
    {
        return $query->where('buyer_id', $buyerId);
    }

    public function scopeBySeller($query, $sellerId)
    {
        return $query->where('seller_id', $sellerId);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('used_at', today());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('used_at', now()->month)
            ->whereYear('used_at', now()->year);
    }
}
