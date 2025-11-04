<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomMeeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'class_date_id',
        'teacher_id',
        'meeting_id',
        'meeting_password',
        'join_url',
        'start_url',
        'host_email',
        'topic',
        'start_time',
        'duration',
        'timezone',
        'status',
        'actual_start_time',
        'actual_end_time',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'actual_start_time' => 'datetime',
        'actual_end_time' => 'datetime',
        'duration' => 'integer',
    ];

    /**
     * Get the book order associated with this meeting.
     */
    public function bookOrder()
    {
        return $this->belongsTo(BookOrder::class, 'order_id');
    }

    /**
     * Get the class date associated with this meeting.
     */
    public function classDate()
    {
        return $this->belongsTo(ClassDate::class, 'class_date_id');
    }

    /**
     * Get the teacher (host) of the meeting.
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get all participants of the meeting.
     */
    public function participants()
    {
        return $this->hasMany(ZoomParticipant::class, 'meeting_id');
    }

    /**
     * Check if the meeting is active/live.
     */
    public function isLive()
    {
        return $this->status === 'started';
    }

    /**
     * Check if the meeting has ended.
     */
    public function hasEnded()
    {
        return $this->status === 'ended';
    }

    /**
     * Get all active meetings.
     */
    public static function getActiveMeetings()
    {
        return self::where('status', 'started')
            ->with(['teacher', 'participants'])
            ->orderBy('actual_start_time', 'desc')
            ->get();
    }

    /**
     * Start the meeting (update status).
     */
    public function startMeeting()
    {
        $this->update([
            'status' => 'started',
            'actual_start_time' => now(),
        ]);
    }

    /**
     * End the meeting (update status).
     */
    public function endMeeting()
    {
        $this->update([
            'status' => 'ended',
            'actual_end_time' => now(),
        ]);
    }

    /**
     * Get total participant count.
     */
    public function getParticipantCountAttribute()
    {
        return $this->participants()->count();
    }
}
