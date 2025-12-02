<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'seller_id',
        'buyer_id',
        'gig_id',
        'offer_type',
        'payment_type',
        'service_mode',
        'description',
        'total_amount',
        'expire_days',
        'request_requirements',
        'status',
        'accepted_at',
        'rejected_at',
        'rejection_reason',
        'expires_at',
    ];

    protected $casts = [
        'request_requirements' => 'boolean',
        'total_amount' => 'decimal:2',
        'accepted_at' => 'datetime',
        'rejected_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    // Relationships
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function gig()
    {
        return $this->belongsTo(TeacherGig::class, 'gig_id');
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }

    public function milestones()
    {
        return $this->hasMany(CustomOfferMilestone::class)->orderBy('order');
    }

    // Business Logic Methods
    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isPending()
    {
        return $this->status === 'pending' && !$this->isExpired();
    }

    public function canBeAccepted()
    {
        return $this->status === 'pending' && !$this->isExpired();
    }

    public function markAsExpired()
    {
        $this->update(['status' => 'expired']);
    }

    /**
     * Get the book order associated with this offer
     */
    public function bookOrder()
    {
        return $this->hasOne(BookOrder::class, 'custom_offer_id');
    }
}
