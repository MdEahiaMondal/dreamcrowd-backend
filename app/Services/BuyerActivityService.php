<?php

namespace App\Services;

use App\Models\BuyerActivity;
use Illuminate\Support\Facades\Auth;

class BuyerActivityService
{
    /**
     * Log a buyer activity
     *
     * @param int $userId
     * @param string $activityType
     * @param string|null $description
     * @param string|null $ipAddress
     * @param string|null $userAgent
     * @return BuyerActivity
     */
    public function log(
        int $userId,
        string $activityType,
        ?string $description = null,
        ?string $ipAddress = null,
        ?string $userAgent = null
    ): BuyerActivity {
        return BuyerActivity::create([
            'user_id' => $userId,
            'activity_type' => $activityType,
            'activity_description' => $description,
            'ip_address' => $ipAddress ?? request()->ip(),
            'user_agent' => $userAgent ?? request()->userAgent(),
        ]);
    }

    /**
     * Log activity for currently authenticated user
     *
     * @param string $activityType
     * @param string|null $description
     * @return BuyerActivity|null
     */
    public function logForAuthUser(string $activityType, ?string $description = null): ?BuyerActivity
    {
        if (!Auth::check()) {
            return null;
        }

        return $this->log(
            Auth::id(),
            $activityType,
            $description
        );
    }

    /**
     * Log login activity
     *
     * @param int $userId
     * @return BuyerActivity
     */
    public function logLogin(int $userId): BuyerActivity
    {
        return $this->log($userId, 'login', 'User logged in');
    }

    /**
     * Log logout activity
     *
     * @param int $userId
     * @return BuyerActivity
     */
    public function logLogout(int $userId): BuyerActivity
    {
        return $this->log($userId, 'logout', 'User logged out');
    }

    /**
     * Log order placed activity
     *
     * @param int $userId
     * @param int $orderId
     * @param float $amount
     * @return BuyerActivity
     */
    public function logOrderPlaced(int $userId, int $orderId, float $amount): BuyerActivity
    {
        return $this->log(
            $userId,
            'order_placed',
            "Order #{$orderId} placed for $" . number_format($amount, 2)
        );
    }

    /**
     * Log profile update activity
     *
     * @param int $userId
     * @return BuyerActivity
     */
    public function logProfileUpdate(int $userId): BuyerActivity
    {
        return $this->log($userId, 'profile_updated', 'User profile updated');
    }

    /**
     * Log password change activity
     *
     * @param int $userId
     * @return BuyerActivity
     */
    public function logPasswordChange(int $userId): BuyerActivity
    {
        return $this->log($userId, 'password_changed', 'User password changed');
    }

    /**
     * Log account banned activity
     *
     * @param int $userId
     * @param string $reason
     * @return BuyerActivity
     */
    public function logAccountBanned(int $userId, string $reason): BuyerActivity
    {
        return $this->log($userId, 'account_banned', "Account banned: {$reason}");
    }

    /**
     * Log account unbanned activity
     *
     * @param int $userId
     * @return BuyerActivity
     */
    public function logAccountUnbanned(int $userId): BuyerActivity
    {
        return $this->log($userId, 'account_unbanned', 'Account unbanned');
    }

    /**
     * Log account deleted activity
     *
     * @param int $userId
     * @return BuyerActivity
     */
    public function logAccountDeleted(int $userId): BuyerActivity
    {
        return $this->log($userId, 'account_deleted', 'Account deleted by admin');
    }

    /**
     * Log account restored activity
     *
     * @param int $userId
     * @return BuyerActivity
     */
    public function logAccountRestored(int $userId): BuyerActivity
    {
        return $this->log($userId, 'account_restored', 'Account restored by admin');
    }

    /**
     * Get recent activities for a user
     *
     * @param int $userId
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecentActivities(int $userId, int $limit = 10)
    {
        return BuyerActivity::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get activities by type
     *
     * @param int $userId
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActivitiesByType(int $userId, string $type)
    {
        return BuyerActivity::where('user_id', $userId)
            ->where('activity_type', $type)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
