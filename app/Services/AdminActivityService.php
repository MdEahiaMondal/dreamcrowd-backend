<?php

namespace App\Services;

use App\Models\User;
use App\Models\AdminActivity;
use Illuminate\Support\Facades\Request;

class AdminActivityService
{
    /**
     * Log an admin activity
     */
    public function log(
        User $admin,
        string $activityType,
        string $description,
        ?User $targetAdmin = null,
        array $metadata = []
    ): AdminActivity {
        return AdminActivity::create([
            'admin_id' => $admin->id,
            'target_admin_id' => $targetAdmin?->id,
            'activity_type' => $activityType,
            'activity_description' => $description,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'metadata' => $metadata,
        ]);
    }

    /**
     * Get recent activities with pagination
     */
    public function getRecentActivities($limit = 50, $filters = [])
    {
        $query = AdminActivity::with(['admin', 'targetAdmin'])
            ->orderBy('created_at', 'desc');

        // Filter by admin
        if (!empty($filters['admin_id'])) {
            $query->where('admin_id', $filters['admin_id']);
        }

        // Filter by target admin
        if (!empty($filters['target_admin_id'])) {
            $query->where('target_admin_id', $filters['target_admin_id']);
        }

        // Filter by activity type
        if (!empty($filters['activity_type'])) {
            $query->where('activity_type', $filters['activity_type']);
        }

        // Filter by date range
        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        return $query->paginate($limit);
    }

    /**
     * Get activity statistics
     */
    public function getActivityStats($days = 30)
    {
        $since = now()->subDays($days);

        return [
            'total_activities' => AdminActivity::where('created_at', '>=', $since)->count(),
            'by_type' => AdminActivity::where('created_at', '>=', $since)
                ->select('activity_type', \DB::raw('count(*) as count'))
                ->groupBy('activity_type')
                ->pluck('count', 'activity_type')
                ->toArray(),
            'most_active_admins' => AdminActivity::where('created_at', '>=', $since)
                ->select('admin_id', \DB::raw('count(*) as count'))
                ->groupBy('admin_id')
                ->orderByDesc('count')
                ->limit(5)
                ->with('admin')
                ->get()
                ->map(function($activity) {
                    return [
                        'admin_id' => $activity->admin_id,
                        'admin_name' => $activity->admin?->first_name . ' ' . $activity->admin?->last_name,
                        'activity_count' => $activity->count,
                    ];
                })
                ->toArray(),
        ];
    }

    /**
     * Get activities for a specific admin
     */
    public function getAdminActivities(User $admin, $limit = 20)
    {
        return AdminActivity::with(['admin', 'targetAdmin'])
            ->where(function($query) use ($admin) {
                $query->where('admin_id', $admin->id)
                      ->orWhere('target_admin_id', $admin->id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($limit);
    }

    /**
     * Delete old activity logs
     */
    public function cleanupOldActivities($daysToKeep = 90)
    {
        $cutoffDate = now()->subDays($daysToKeep);
        return AdminActivity::where('created_at', '<', $cutoffDate)->delete();
    }
}
