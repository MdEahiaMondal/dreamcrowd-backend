<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;
    use HasRoles {
        HasRoles::hasPermissionTo as protected spatieHasPermissionTo;
    }

    /**
     * Seller status constants
     */
    const STATUS_ACTIVE = 0;
    const STATUS_HIDDEN = 2;
    const STATUS_PAUSED = 3;
    const STATUS_BANNED = 4;

    /**
     * Buyer status mapping (for buyers, status field maps to these values)
     * We use string values in application layer for buyer management
     */
    const BUYER_STATUS_MAP = [
        0 => 'active',      // Active buyer
        1 => 'inactive',    // Inactive buyer
        2 => 'banned',      // Banned buyer
        3 => 'deleted',     // Soft deleted (also uses deleted_at timestamp)
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'profile',
        'ip',
        'country',
        'country_code',
        'city',
        'zip_code',
        'email',
        'email_verify',
        'email_code',
        'password',
        'google_id',
        'facebook_id',
        'role',
        'admin_role',
        'status',
        'auto_approve_enabled',
        'zoom_access_token',
        'zoom_refresh_token',
        'banned_at',
        'banned_reason',
        'last_active_at',
        'is_active',
        'is_admin',
        'last_login_at',
        'login_count',
    ];

    public function sentChats()
    {
        return $this->hasMany(Chat::class, 'sender_id');
    }

    public function receivedChats()
    {
        return $this->hasMany(Chat::class, 'reciver_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'zoom_access_token',
        'zoom_refresh_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'zoom_access_token' => 'encrypted',
            'zoom_refresh_token' => 'encrypted',
            'banned_at' => 'datetime',
            'last_active_at' => 'datetime',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
            'is_admin' => 'boolean',
        ];
    }


    /**
     * Get transactions where user is a seller
     */
    public function sellerTransactions()
    {
        return $this->hasMany(Transaction::class, 'seller_id');
    }

    /**
     * Get transactions where user is a buyer
     */
    public function buyerTransactions()
    {
        return $this->hasMany(Transaction::class, 'buyer_id');
    }

    /**
     * Get custom seller commission
     */
    public function sellerCommission()
    {
        return $this->hasOne(SellerCommission::class, 'seller_id');
    }

    /**
     * Get teacher's gigs/services
     */
    public function teacherGigs()
    {
        return $this->hasMany(TeacherGig::class, 'user_id');
    }

    /**
     * Get book orders as buyer
     */
    public function bookOrders()
    {
        return $this->hasMany(BookOrder::class, 'user_id');
    }

    /**
     * Get expert/teacher profile
     */
    public function expertProfile()
    {
        return $this->hasOne(ExpertProfile::class, 'user_id');
    }

    /**
     * Get reviews received by this seller/teacher
     */
    public function receivedReviews()
    {
        return $this->hasMany(\App\Models\ServiceReviews::class, 'teacher_id');
    }

    /**
     * Get buyer activity logs
     */
    public function buyerActivities()
    {
        return $this->hasMany(BuyerActivity::class, 'user_id');
    }

    /**
     * Scope: Get only active buyers
     */
    public function scopeActive($query)
    {
        return $query->where('status', 0)->where('is_active', true);
    }

    /**
     * Scope: Get only banned buyers
     */
    public function scopeBanned($query)
    {
        return $query->where('status', 2);
    }

    /**
     * Scope: Get only inactive buyers
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Scope: Get only buyers (role = 0)
     */
    public function scopeBuyersOnly($query)
    {
        return $query->where('role', 0);
    }

    /**
     * Scope: Search by name or email
     */
    public function scopeSearch($query, $search)
    {
        if (!empty($search)) {
            return $query->where(function($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('id', 'LIKE', "%{$search}%");
            });
        }
        return $query;
    }

    /**
     * Ban a user
     */
    public function ban($reason = null)
    {
        $this->update([
            'status' => 2, // banned
            'banned_at' => now(),
            'banned_reason' => $reason,
            'is_active' => false,
        ]);
    }

    /**
     * Unban a user
     */
    public function unban()
    {
        $this->update([
            'status' => 0, // active
            'banned_at' => null,
            'banned_reason' => null,
            'is_active' => true,
        ]);
    }

    /**
     * Mark user as inactive
     */
    public function markInactive()
    {
        $this->update([
            'status' => 1, // inactive
            'is_active' => false,
        ]);
    }

    /**
     * Mark user as active
     */
    public function markActive()
    {
        $this->update([
            'status' => 0, // active
            'is_active' => true,
        ]);
    }

    /**
     * Get status as string (for buyer management)
     */
    public function getStatusStringAttribute()
    {
        return self::BUYER_STATUS_MAP[$this->status] ?? 'active';
    }

    /**
     * Update last activity timestamp
     */
    public function updateLastActivity()
    {
        $this->update(['last_active_at' => now()]);
    }

    /**
     * Check if this user is the top super admin (hardcoded in config)
     */
    public function isTopSuperAdmin(): bool
    {
        return $this->email === config('superadmin.email');
    }

    /**
     * Override Spatie's hasPermissionTo to bypass for top super admin
     */
    public function hasPermissionTo($permission, $guardName = null): bool
    {
        // Top super admin bypasses all permission checks
        if ($this->isTopSuperAdmin() && config('superadmin.protection.bypass_permissions', true)) {
            return true;
        }

        return $this->spatieHasPermissionTo($permission, $guardName);
    }

    /**
     * Check if user can manage another admin (based on hierarchy)
     */
    public function canManageAdmin(User $targetAdmin): bool
    {
        // Top super admin can manage anyone
        if ($this->isTopSuperAdmin()) {
            return true;
        }

        // Cannot manage the top super admin
        if ($targetAdmin->isTopSuperAdmin()) {
            return false;
        }

        // Get role hierarchy levels
        $myRole = $this->roles()->first();
        $targetRole = $targetAdmin->roles()->first();

        if (!$myRole || !$targetRole) {
            return false;
        }

        // Lower hierarchy_level number = higher authority
        return $myRole->hierarchy_level < $targetRole->hierarchy_level;
    }

    /**
     * Scope: Get only admin users
     */
    public function scopeAdminsOnly($query)
    {
        $query->where('is_admin', true)->where('role', 2);

        // Optionally hide top super admin from lists
        if (config('superadmin.protection.hide_from_list', false)) {
            $query->where('email', '!=', config('superadmin.email'));
        }

        return $query;
    }

    /**
     * Get admin activities performed by this admin
     */
    public function adminActivities()
    {
        return $this->hasMany(AdminActivity::class, 'admin_id');
    }

    /**
     * Get admin activities targeting this admin
     */
    public function targetedAdminActivities()
    {
        return $this->hasMany(AdminActivity::class, 'target_admin_id');
    }

    /**
     * Get total earnings as seller
     */
    public function getTotalEarningsAttribute()
    {
        return $this->sellerTransactions()
            ->where('status', 'completed')
            ->sum('seller_earnings');
    }

    /**
     * Get pending payout amount
     */
    public function getPendingPayoutAttribute()
    {
        return $this->sellerTransactions()
            ->where('status', 'completed')
            ->where('payout_status', 'pending')
            ->sum('seller_earnings');
    }

    /**
     * Get total spent as buyer
     */
    public function getTotalSpentAttribute()
    {
        return $this->buyerTransactions()
            ->where('status', 'completed')
            ->sum('total_amount');
    }

    /**
     * Get Zoom meetings hosted by this teacher
     */
    public function hostedMeetings()
    {
        return $this->hasMany(ZoomMeeting::class, 'teacher_id');
    }

    /**
     * Get Zoom participant records
     */
    public function zoomParticipations()
    {
        return $this->hasMany(ZoomParticipant::class, 'user_id');
    }

    /**
     * Get Zoom secure tokens
     */
    public function zoomTokens()
    {
        return $this->hasMany(ZoomSecureToken::class, 'user_id');
    }

    /**
     * Get Zoom audit logs
     */
    public function zoomAuditLogs()
    {
        return $this->hasMany(ZoomAuditLog::class, 'user_id');
    }

    /**
     * Check if user has connected Zoom account
     */
    public function hasZoomConnected()
    {
        return !empty($this->zoom_access_token) && !empty($this->zoom_refresh_token);
    }

    /**
     * Get Zoom email (if available from OAuth)
     */
    public function getZoomEmail()
    {
        // This would be fetched from Zoom API if needed
        // For now, return the user's email
        return $this->email;
    }

    /**
     * Refresh Zoom access token using refresh token
     */
    public function refreshZoomToken()
    {
        if (!$this->zoom_refresh_token) {
            return false;
        }

        try {
            $zoomSettings = ZoomSetting::getActive();
            if (!$zoomSettings) {
                throw new \Exception('Zoom settings not configured');
            }

            $response = \Http::withBasicAuth($zoomSettings->client_id, $zoomSettings->client_secret)
                ->asForm()
                ->post('https://zoom.us/oauth/token', [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $this->zoom_refresh_token,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $this->update([
                    'zoom_access_token' => $data['access_token'],
                    'zoom_refresh_token' => $data['refresh_token'] ?? $this->zoom_refresh_token,
                ]);

                ZoomAuditLog::logAction('token_refreshed', $this->id, 'user', $this->id);
                return true;
            }

            // Token refresh API call failed
            \Log::error('Zoom token refresh API call failed for user ' . $this->id, [
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            ZoomAuditLog::logAction('token_refresh_failed', $this->id, 'user', $this->id, [
                'error' => 'API call failed: ' . $response->status(),
            ]);

            // Send notifications about token refresh failure
            $this->sendZoomTokenRefreshFailureNotifications('API call failed: ' . $response->status());

            return false;
        } catch (\Exception $e) {
            \Log::error('Failed to refresh Zoom token for user ' . $this->id . ': ' . $e->getMessage());
            ZoomAuditLog::logAction('token_refresh_failed', $this->id, 'user', $this->id, [
                'error' => $e->getMessage(),
            ]);

            // Send notifications about token refresh failure
            $this->sendZoomTokenRefreshFailureNotifications($e->getMessage());

            return false;
        }
    }

    /**
     * Send notifications when Zoom token refresh fails
     *
     * @param string $errorMessage
     * @return void
     */
    protected function sendZoomTokenRefreshFailureNotifications($errorMessage)
    {
        try {
            $notificationService = app(\App\Services\NotificationService::class);

            // Notify the teacher/seller
            $notificationService->send(
                userId: $this->id,
                type: 'zoom',
                title: 'Zoom Connection Failed',
                message: 'Failed to refresh your Zoom connection. Please reconnect your Zoom account to continue hosting classes.',
                data: [
                    'error' => $errorMessage,
                    'reconnect_url' => route('teacher.zoom.connect'),
                    'failed_at' => now()->toISOString()
                ],
                sendEmail: true
            );

            // Notify admins
            $adminIds = User::where('role', 2)->pluck('id')->toArray();
            if (!empty($adminIds)) {
                $notificationService->sendToMultipleUsers(
                    userIds: $adminIds,
                    type: 'system',
                    title: 'Zoom Token Refresh Failed',
                    message: "Zoom token refresh failed for seller #{$this->id} ({$this->first_name} {$this->last_name}). User may experience meeting creation issues.",
                    data: [
                        'seller_id' => $this->id,
                        'seller_name' => $this->first_name . ' ' . $this->last_name,
                        'seller_email' => $this->email,
                        'error' => $errorMessage,
                        'failed_at' => now()->toISOString()
                    ],
                    sendEmail: true
                );
            }
        } catch (\Exception $e) {
            // Don't let notification failures break the main flow
            \Log::error('Failed to send Zoom token refresh failure notifications: ' . $e->getMessage());
        }
    }

    /**
     * Disconnect Zoom account
     */
    public function disconnectZoom()
    {
        $this->update([
            'zoom_access_token' => null,
            'zoom_refresh_token' => null,
        ]);

        ZoomAuditLog::logAction('oauth_disconnect', $this->id, 'user', $this->id);
    }
}
