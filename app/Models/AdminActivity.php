<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'target_admin_id',
        'activity_type',
        'activity_description',
        'ip_address',
        'user_agent',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    /**
     * Get the admin who performed the activity
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Get the admin who was targeted by the activity (if applicable)
     */
    public function targetAdmin()
    {
        return $this->belongsTo(User::class, 'target_admin_id');
    }

    /**
     * Scope: Recent activities
     */
    public function scopeRecent($query, $limit = 50)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    /**
     * Scope: By admin
     */
    public function scopeByAdmin($query, $adminId)
    {
        return $query->where('admin_id', $adminId);
    }

    /**
     * Scope: By activity type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('activity_type', $type);
    }
}
