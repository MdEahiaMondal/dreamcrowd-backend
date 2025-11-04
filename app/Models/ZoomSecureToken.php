<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ZoomSecureToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_date_id',
        'user_id',
        'token',
        'email',
        'expires_at',
        'used_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        // Don't encrypt token - it's already hashed with SHA256 which is secure
        // Encryption prevents WHERE queries from working
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    /**
     * Get the class date this token is for.
     */
    public function classDate()
    {
        return $this->belongsTo(ClassDate::class, 'class_date_id');
    }

    /**
     * Get the user this token belongs to.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Generate a secure token for a user/guest.
     * Returns an object with both the plain token and the database record.
     */
    public static function generateToken($classDateId, $email, $userId = null, $expiryMinutes = 45)
    {
        $plainToken = Str::random(64);
        $hashedToken = hash('sha256', $plainToken);

        $tokenRecord = self::create([
            'class_date_id' => $classDateId,
            'user_id' => $userId,
            'email' => $email,
            'token' => $hashedToken, // Store hashed version
            'expires_at' => now()->addMinutes($expiryMinutes),
        ]);

        // Return object with both plain token and record
        // Add a property to the model instance
        $tokenRecord->plain_token = $plainToken;

        return $tokenRecord;
    }

    /**
     * Validate and retrieve token.
     */
    public static function validateToken($token)
    {
        $hashedToken = hash('sha256', $token);

        return self::where('token', $hashedToken)
            ->where('expires_at', '>', now())
            ->whereNull('used_at')
            ->first();
    }

    /**
     * Mark token as used.
     */
    public function markAsUsed($ipAddress = null, $userAgent = null)
    {
        $this->update([
            'used_at' => now(),
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ]);
    }

    /**
     * Check if token is expired.
     */
    public function isExpired()
    {
        return $this->expires_at->isPast();
    }

    /**
     * Check if token has been used.
     */
    public function isUsed()
    {
        return !is_null($this->used_at);
    }

    /**
     * Check if token is valid (not expired and not used).
     */
    public function isValid()
    {
        return !$this->isExpired() && !$this->isUsed();
    }

    /**
     * Clean up expired tokens (can be called in a scheduled command).
     */
    public static function cleanupExpired()
    {
        return self::where('expires_at', '<', now()->subDays(7))->delete();
    }
}
