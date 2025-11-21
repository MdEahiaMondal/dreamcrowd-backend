<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * Seller status constants
     */
    const STATUS_ACTIVE = 0;
    const STATUS_HIDDEN = 2;
    const STATUS_PAUSED = 3;
    const STATUS_BANNED = 4;

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
        'zoom_access_token',
        'zoom_refresh_token',
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
