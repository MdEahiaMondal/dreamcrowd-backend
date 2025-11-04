<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassDate extends Model
{
    use HasFactory;

    protected $fillable = [
      'order_id',
      'teacher_date',
      'user_date',
      'teacher_time_zone',
      'user_time_zone',
      'teacher_attend',
      'user_attend',
      'duration',
      'zoom_link',
    ];

    protected $casts = [
        'teacher_date' => 'datetime',
        'user_date' => 'datetime',
    ];

    /**
     * Get the book order this class date belongs to
     */
    public function bookOrder()
    {
        return $this->belongsTo(BookOrder::class, 'order_id');
    }

    /**
     * Get Zoom meeting for this class date
     */
    public function zoomMeeting()
    {
        return $this->hasOne(ZoomMeeting::class, 'class_date_id');
    }

    /**
     * Get secure tokens for this class date
     */
    public function secureTokens()
    {
        return $this->hasMany(ZoomSecureToken::class, 'class_date_id');
    }

    /**
     * Check if class has a Zoom link
     */
    public function hasZoomLink()
    {
        return !empty($this->zoom_link) || $this->zoomMeeting()->exists();
    }

    /**
     * Check if class is starting soon (within 30 minutes)
     */
    public function isStartingSoon($minutes = 30)
    {
        return $this->teacher_date &&
               $this->teacher_date->isFuture() &&
               $this->teacher_date->diffInMinutes(now(), false) <= $minutes;
    }

    /**
     * Check if class has already started
     */
    public function hasStarted()
    {
        return $this->teacher_date && $this->teacher_date->isPast();
    }

    /**
     * Generate secure token for a user
     */
    public function generateSecureToken($userId, $email)
    {
        return ZoomSecureToken::generateToken($this->id, $email, $userId);
    }
}
