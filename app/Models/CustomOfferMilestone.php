<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomOfferMilestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'custom_offer_id',
        'title',
        'description',
        'date',
        'start_time',
        'end_time',
        'price',
        'revisions',
        'delivery_days',
        'order',
        'status',
        'started_at',
        'delivered_at',
        'completed_at',
        'released_at',
        'delivery_note',
        'revision_note',
        'revisions_used',
    ];

    protected $casts = [
        'date' => 'date',
        'price' => 'decimal:2',
        'started_at' => 'datetime',
        'delivered_at' => 'datetime',
        'completed_at' => 'datetime',
        'released_at' => 'datetime',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_COMPLETED = 'completed';
    const STATUS_RELEASED = 'released';

    // Relationships
    public function customOffer()
    {
        return $this->belongsTo(CustomOffer::class);
    }

    // Status helpers
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isInProgress(): bool
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    public function isDelivered(): bool
    {
        return $this->status === self::STATUS_DELIVERED;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isReleased(): bool
    {
        return $this->status === self::STATUS_RELEASED;
    }

    // Action methods
    public function markAsStarted(): void
    {
        $this->update([
            'status' => self::STATUS_IN_PROGRESS,
            'started_at' => now(),
        ]);
    }

    public function markAsDelivered(string $note = null): void
    {
        $this->update([
            'status' => self::STATUS_DELIVERED,
            'delivered_at' => now(),
            'delivery_note' => $note,
        ]);
    }

    public function markAsCompleted(): void
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
            'completed_at' => now(),
        ]);
    }

    public function markAsReleased(): void
    {
        $this->update([
            'status' => self::STATUS_RELEASED,
            'released_at' => now(),
        ]);
    }

    public function requestRevision(string $note): bool
    {
        // Check if revisions are available
        if ($this->revisions_used >= $this->revisions) {
            return false;
        }

        $this->update([
            'status' => self::STATUS_IN_PROGRESS,
            'revision_note' => $note,
            'revisions_used' => $this->revisions_used + 1,
        ]);

        return true;
    }

    public function canRequestRevision(): bool
    {
        return $this->status === self::STATUS_DELIVERED
            && $this->revisions_used < $this->revisions;
    }
}
