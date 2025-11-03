<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'meeting_id',
        'user_id',
        'user_email',
        'user_name',
        'role',
        'join_time',
        'leave_time',
        'duration_seconds',
    ];

    protected $casts = [
        'join_time' => 'datetime',
        'leave_time' => 'datetime',
        'duration_seconds' => 'integer',
    ];

    /**
     * Get the meeting this participant belongs to.
     */
    public function meeting()
    {
        return $this->belongsTo(ZoomMeeting::class, 'meeting_id');
    }

    /**
     * Get the user (if registered user).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Check if participant is a guest.
     */
    public function isGuest()
    {
        return $this->role === 'guest' || is_null($this->user_id);
    }

    /**
     * Calculate and update duration when participant leaves.
     */
    public function recordLeave()
    {
        $leaveTime = now();
        $duration = $leaveTime->diffInSeconds($this->join_time);

        $this->update([
            'leave_time' => $leaveTime,
            'duration_seconds' => $duration,
        ]);
    }

    /**
     * Get formatted duration (HH:MM:SS).
     */
    public function getFormattedDuration()
    {
        $hours = floor($this->duration_seconds / 3600);
        $minutes = floor(($this->duration_seconds % 3600) / 60);
        $seconds = $this->duration_seconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }
}
