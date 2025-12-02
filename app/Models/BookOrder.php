<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookOrder extends Model
{
    use HasFactory;

    
// Status Code	Status      Name		                    Description

        // 0	Pending		Order placed,                   awaiting seller acceptance
        // 1	Active	    Order accepted by seller,       service in progress
        // 2	Delivered	Service completed,              48-hour dispute window active
        // 3	Completed	Order finalized,                ready for seller payout
        // 4	Cancelled   Order cancelled (with or without refund)

    protected $fillable = [
        'user_id',
        'gig_id',
        'teacher_id',
        'custom_offer_id',
        'zoom_link',
        'title',
        'frequency',
        'group_type',
        'emails',
        'extra_guests',
        'guests',
        'childs',
        'total_people',
        'service_delivery',
        'work_site',
        'freelance_service',
        'price',
        'buyer_commission',
        'coupen',
        'discount',
        'finel_price',
        'payment_type',
        'payment_id',
        'holder_name',
        'card_number',
        'cvv',
        'date',
        'action_date',
        'teacher_reschedule',
        'user_reschedule',
        'teacher_reschedule_time',
        'user_dispute',
        'teacher_dispute',
        'auto_dispute_processed',
        'refund',
        'start_job',
        'status',
        'buyer_commission_rate',
        'buyer_commission_amount',
        'seller_commission_rate',
        'seller_commission_amount',
        'total_admin_commission',
        'seller_earnings',
        'admin_absorbed_discount',
        'payment_status',
    ];

    public function gig(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TeacherGig::class, 'gig_id');
    }

    public function booker(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function teacher(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    protected $casts = [
        'buyer_commission_rate' => 'decimal:2',
        'buyer_commission_amount' => 'decimal:2',
        'seller_commission_rate' => 'decimal:2',
        'seller_commission_amount' => 'decimal:2',
        'total_admin_commission' => 'decimal:2',
        'seller_earnings' => 'decimal:2',
        'admin_absorbed_discount' => 'boolean',
    ];

    /**
     * Appends - attributes to append to model
     */
    protected $appends = ['order_number'];

    /**
     * Get the order number attribute
     * Generates a formatted order number based on the ID
     */
    public function getOrderNumberAttribute(): string
    {
        return 'ORD-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Get the transaction associated with this order
     */
    public function transaction(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Transaction::class, 'stripe_transaction_id', 'payment_id');
    }

    /**
     * Get Zoom meetings for this order
     */
    public function zoomMeetings()
    {
        return $this->hasMany(ZoomMeeting::class, 'order_id');
    }

    /**
     * Get the latest Zoom meeting for this order
     */
    public function latestZoomMeeting()
    {
        return $this->hasOne(ZoomMeeting::class, 'order_id')->latestOfMany();
    }

    /**
     * Get class dates for this order
     */
    public function classDates()
    {
        return $this->hasMany(ClassDate::class, 'order_id');
    }

    /**
     * Get the dispute order associated with this booking
     */
    public function disputeOrder()
    {
        return $this->hasOne(DisputeOrder::class, 'order_id');
    }

    /**
     * Get the custom offer associated with this order
     */
    public function customOffer()
    {
        return $this->belongsTo(CustomOffer::class, 'custom_offer_id');
    }

    /**
     * Check if order has an active Zoom meeting
     */
    public function hasActiveZoomMeeting()
    {
        return $this->zoomMeetings()->where('status', 'started')->exists();
    }

    /**
     * Get active Zoom meeting
     */
    public function getActiveZoomMeeting()
    {
        return $this->zoomMeetings()->where('status', 'started')->first();
    }
}