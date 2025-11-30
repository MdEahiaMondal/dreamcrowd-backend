<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'amount',
        'currency',
        'method',
        'status',
        'payment_details',
        'stripe_transfer_id',
        'paypal_payout_id',
        'bank_reference',
        'processed_by',
        'processed_at',
        'seller_notes',
        'admin_notes',
        'failure_reason',
        'processing_fee',
        'net_amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'processing_fee' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'payment_details' => 'array',
        'processed_at' => 'datetime',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELLED = 'cancelled';

    // Method constants
    const METHOD_STRIPE = 'stripe';
    const METHOD_PAYPAL = 'paypal';
    const METHOD_BANK_TRANSFER = 'bank_transfer';

    // ============ RELATIONSHIPS ============

    /**
     * Get the seller who requested this withdrawal
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * Get the admin who processed this withdrawal
     */
    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    // ============ SCOPES ============

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', self::STATUS_PROCESSING);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopeFailed($query)
    {
        return $query->where('status', self::STATUS_FAILED);
    }

    public function scopeForSeller($query, $sellerId)
    {
        return $query->where('seller_id', $sellerId);
    }

    // ============ HELPER METHODS ============

    /**
     * Check if withdrawal is pending
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if withdrawal is processing
     */
    public function isProcessing(): bool
    {
        return $this->status === self::STATUS_PROCESSING;
    }

    /**
     * Check if withdrawal is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Check if withdrawal can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, [self::STATUS_PENDING]);
    }

    /**
     * Mark as processing
     */
    public function markAsProcessing($adminId = null)
    {
        $this->status = self::STATUS_PROCESSING;
        $this->processed_by = $adminId;
        $this->save();

        return $this;
    }

    /**
     * Mark as completed
     */
    public function markAsCompleted($transactionId = null, $adminId = null)
    {
        $this->status = self::STATUS_COMPLETED;
        $this->processed_at = now();
        $this->processed_by = $adminId ?? $this->processed_by;

        if ($transactionId) {
            switch ($this->method) {
                case self::METHOD_STRIPE:
                    $this->stripe_transfer_id = $transactionId;
                    break;
                case self::METHOD_PAYPAL:
                    $this->paypal_payout_id = $transactionId;
                    break;
                case self::METHOD_BANK_TRANSFER:
                    $this->bank_reference = $transactionId;
                    break;
            }
        }

        $this->save();

        return $this;
    }

    /**
     * Mark as failed
     */
    public function markAsFailed($reason, $adminId = null)
    {
        $this->status = self::STATUS_FAILED;
        $this->failure_reason = $reason;
        $this->processed_at = now();
        $this->processed_by = $adminId ?? $this->processed_by;
        $this->save();

        return $this;
    }

    /**
     * Cancel withdrawal
     */
    public function cancel($reason = null)
    {
        if (!$this->canBeCancelled()) {
            return false;
        }

        $this->status = self::STATUS_CANCELLED;
        $this->admin_notes = $reason;
        $this->save();

        return $this;
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'warning',
            self::STATUS_PROCESSING => 'info',
            self::STATUS_COMPLETED => 'success',
            self::STATUS_FAILED => 'danger',
            self::STATUS_CANCELLED => 'secondary',
            default => 'secondary',
        };
    }

    /**
     * Get method display name
     */
    public function getMethodDisplayNameAttribute(): string
    {
        return match ($this->method) {
            self::METHOD_STRIPE => 'Stripe',
            self::METHOD_PAYPAL => 'PayPal',
            self::METHOD_BANK_TRANSFER => 'Bank Transfer',
            default => ucfirst($this->method),
        };
    }

    // ============ STATIC METHODS ============

    /**
     * Get total pending withdrawals for a seller
     */
    public static function getPendingAmount($sellerId): float
    {
        return self::where('seller_id', $sellerId)
            ->whereIn('status', [self::STATUS_PENDING, self::STATUS_PROCESSING])
            ->sum('amount');
    }

    /**
     * Get total withdrawn amount for a seller
     */
    public static function getTotalWithdrawn($sellerId): float
    {
        return self::where('seller_id', $sellerId)
            ->where('status', self::STATUS_COMPLETED)
            ->sum('net_amount');
    }

    /**
     * Check if seller has pending withdrawal
     */
    public static function hasPendingWithdrawal($sellerId): bool
    {
        return self::where('seller_id', $sellerId)
            ->whereIn('status', [self::STATUS_PENDING, self::STATUS_PROCESSING])
            ->exists();
    }

    /**
     * Create a new withdrawal request
     */
    public static function createRequest($sellerId, $amount, $method, $paymentDetails = [], $notes = null)
    {
        $settings = TopSellerTag::first();
        $processingFee = 0; // Can add logic for processing fees later

        return self::create([
            'seller_id' => $sellerId,
            'amount' => $amount,
            'currency' => $settings->currency ?? 'USD',
            'method' => $method,
            'status' => self::STATUS_PENDING,
            'payment_details' => $paymentDetails,
            'processing_fee' => $processingFee,
            'net_amount' => $amount - $processingFee,
            'seller_notes' => $notes,
        ]);
    }
}
