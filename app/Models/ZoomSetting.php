<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ZoomSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'client_secret',
        'redirect_uri',
        'account_id',
        'base_url',
        'webhook_secret',
        'is_active',
        'updated_by',
    ];

    protected $casts = [
        'client_id' => 'encrypted',
        'client_secret' => 'encrypted',
        'webhook_secret' => 'encrypted',
        'is_active' => 'boolean',
    ];

    /**
     * Get the admin user who updated the settings.
     */
    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the active Zoom settings.
     */
    public static function getActive()
    {
        return self::where('is_active', true)->first();
    }

    /**
     * Test Zoom API connection.
     */
    public function testConnection()
    {
        try {
            $response = \Http::withToken($this->generateServerToServerToken())
                ->get($this->base_url . '/users/me');

            return $response->successful();
        } catch (\Exception $e) {
            \Log::error('Zoom connection test failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Generate Server-to-Server OAuth token (for admin operations).
     */
    public function generateServerToServerToken()
    {
        $response = \Http::withBasicAuth($this->client_id, $this->client_secret)
            ->asForm()
            ->post('https://zoom.us/oauth/token', [
                'grant_type' => 'account_credentials',
                'account_id' => $this->account_id,
            ]);

        return $response->json()['access_token'] ?? null;
    }
}
