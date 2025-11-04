<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stripe\Climate\Order;

class ServiceReviews extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'user_id',
        'teacher_id',
        'gig_id',
        'order_id',
        'rating',
        'cmnt',
    ];

    public function replies(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ServiceReviews::class, 'parent_id', 'id');
    }

    public function teacher(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function gig(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TeacherGig::class, 'gig_id', 'id');
    }

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(BookOrder::class, 'order_id', 'id');
    }

    /**
     * Check if reply can be edited or deleted (within 7 days)
     */
    public function canEditOrDelete(): bool
    {
        // Only replies (not parent reviews) can be checked
        if (!$this->parent_id) {
            return false;
        }

        // Calculate the difference in days
        $daysSinceCreation = $this->created_at->diffInDays(now());

        return $daysSinceCreation < 7;
    }
}
