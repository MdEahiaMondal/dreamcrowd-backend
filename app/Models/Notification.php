<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'actor_user_id',
        'target_user_id',
        'order_id',
        'service_id',
        'type',
        'is_emergency',
        'sent_email',
        'title',
        'message',
        'data',
        'is_read',
        'read_at',
        'sent_by_admin_id',
        'scheduled_at'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_emergency' => 'boolean',
        'sent_email' => 'boolean',
        'read_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the user who receives this notification
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the actor (who performed the action)
     */
    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_user_id');
    }

    /**
     * Get the target (who is affected by the action)
     */
    public function target()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    /**
     * Get the related order
     */
    public function order()
    {
        return $this->belongsTo(\App\Models\BookOrder::class, 'order_id');
    }

    /**
     * Get the related service
     */
    public function service()
    {
        return $this->belongsTo(\App\Models\TeacherGig::class, 'service_id');
    }

    /**
     * Get the admin who sent this notification
     */
    public function sentByAdmin()
    {
        return $this->belongsTo(User::class, 'sent_by_admin_id');
    }

    /**
     * Mark notification as read
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    /**
     * Check if notification is scheduled for future
     */
    public function isScheduled()
    {
        return $this->scheduled_at && $this->scheduled_at->isFuture();
    }
}