<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'service_type',
        'commission_rate',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Add relationship with your service/class model
    public function service(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TeacherGig::class, 'service_id', 'id');
    }
}
