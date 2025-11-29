<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DisputeOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_role',
        'order_id',
        'reason',
        'refund',
        'refund_type',
        'amount',
        'status',
        'user_reason',
        'teacher_reason',
        'admin_notes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order()
    {
        return $this->belongsTo(BookOrder::class, 'order_id');
    }

    /**
     * 48-Hour Countdown Timer
     * Returns the remaining time in seconds for seller to respond
     * If negative, the auto-refund should be triggered
     */
    public function getTimeRemainingAttribute()
    {
        if ($this->status != 0) {
            // Dispute already resolved
            return null;
        }

        // Check if order is cancelled
        if ($this->order && $this->order->status == 4) {
            // 48 hours from cancellation time
            $deadline = Carbon::parse($this->order->action_date)->addHours(48);
            $now = Carbon::now();

            return $deadline->diffInSeconds($now, false);
        }

        // 48 hours from dispute creation
        $deadline = $this->created_at->addHours(48);
        $now = Carbon::now();

        // Return negative if deadline passed, positive if time remaining
        return $deadline->diffInSeconds($now, false);
    }

    /**
     * Check if auto-refund deadline has passed
     */
    public function isAutoRefundEligible()
    {
        $timeRemaining = $this->time_remaining;

        if ($timeRemaining === null) {
            return false;
        }

        // If time remaining is negative (deadline passed) and teacher hasn't disputed
        return $timeRemaining < 0 &&
               $this->order &&
               $this->order->user_dispute == 1 &&
               $this->order->teacher_dispute == 0 &&
               $this->order->auto_dispute_processed == 0;
    }

    /**
     * Get human-readable countdown
     */
    public function getCountdownTextAttribute()
    {
        $timeRemaining = $this->time_remaining;

        if ($timeRemaining === null) {
            return 'Resolved';
        }

        if ($timeRemaining < 0) {
            return 'Expired (Auto-refund pending)';
        }

        $timeRemaining = (int) $timeRemaining;
        $hours = (int) floor($timeRemaining / 3600);
        $minutes = (int) floor(($timeRemaining % 3600) / 60);

        if ($hours >= 24) {
            $days = (int) floor($hours / 24);
            $remainingHours = (int) ($hours % 24);
            return "{$days}d {$remainingHours}h remaining";
        } elseif ($hours > 0) {
            return "{$hours}h {$minutes}m remaining";
        } else {
            return "{$minutes} minutes remaining";
        }
    }

    /**
     * Get countdown color class based on time remaining
     */
    public function getCountdownColorAttribute()
    {
        $timeRemaining = $this->time_remaining;

        if ($timeRemaining === null) {
            return 'text-secondary';
        }

        if ($timeRemaining < 0) {
            return 'text-danger';
        }

        $hoursRemaining = $timeRemaining / 3600;

        if ($hoursRemaining > 24) {
            return 'text-success';
        } elseif ($hoursRemaining > 6) {
            return 'text-warning';
        } else {
            return 'text-danger';
        }
    }
}
