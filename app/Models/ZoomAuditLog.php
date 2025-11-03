<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomAuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'entity_type',
        'entity_id',
        'ip_address',
        'user_agent',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    /**
     * Get the user who performed the action.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Log an action.
     */
    public static function logAction($action, $userId = null, $entityType = null, $entityId = null, array $metadata = [])
    {
        return self::create([
            'user_id' => $userId ?? auth()->id(),
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'metadata' => $metadata,
        ]);
    }

    /**
     * Get logs for a specific action.
     */
    public static function getByAction($action, $limit = 50)
    {
        return self::where('action', $action)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get logs for a specific user.
     */
    public static function getByUser($userId, $limit = 50)
    {
        return self::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get recent security-related logs (unauthorized access, failed attempts).
     */
    public static function getSecurityLogs($days = 7, $limit = 100)
    {
        return self::whereIn('action', [
                'unauthorized_access',
                'join_attempt_failed',
                'oauth_disconnect',
                'token_validation_failed',
            ])
            ->where('created_at', '>=', now()->subDays($days))
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
