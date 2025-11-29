<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'review_id',
        'reporter_id',
        'reason',
        'description',
        'status',
        'admin_notes',
        'handled_by',
        'handled_at',
    ];

    protected $casts = [
        'handled_at' => 'datetime',
    ];

    /**
     * Get the review that was reported
     */
    public function review(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ServiceReviews::class, 'review_id');
    }

    /**
     * Get the user who reported the review (seller)
     */
    public function reporter(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    /**
     * Get the admin who handled the report
     */
    public function handler(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    /**
     * Get human-readable reason
     */
    public function getReasonLabelAttribute(): string
    {
        return match ($this->reason) {
            'abusive_language' => 'Abusive Language',
            'false_claim' => 'False Claim',
            'spam' => 'Spam',
            'inappropriate' => 'Inappropriate Content',
            'other' => 'Other',
            default => ucfirst($this->reason),
        };
    }

    /**
     * Scope for pending reports
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for approved reports
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for rejected reports
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
