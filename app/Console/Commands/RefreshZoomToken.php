<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\ZoomSetting;
use App\Models\ZoomAuditLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RefreshZoomToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zoom:refresh-tokens {--dry-run : Run without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh Zoom OAuth tokens for all connected teachers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->info('Running in DRY RUN mode - no changes will be made');
        }

        $this->info('Starting Zoom token refresh process...');

        // Get Zoom settings
        $zoomSettings = ZoomSetting::getActive();

        if (!$zoomSettings) {
            $this->error('Zoom settings not configured. Please configure Zoom in admin panel.');
            return 1;
        }

        // Find all users with Zoom tokens (teachers)
        $users = User::whereNotNull('zoom_refresh_token')
            ->where('role', 1) // Teachers only
            ->get();

        if ($users->isEmpty()) {
            $this->info('No users with Zoom tokens found.');
            return 0;
        }

        $this->info("Found {$users->count()} users with Zoom tokens");

        $successCount = 0;
        $failureCount = 0;
        $skippedCount = 0;

        foreach ($users as $user) {
            $this->line("Processing user: {$user->first_name} {$user->last_name} (ID: {$user->id})");

            try {
                if (!$user->zoom_refresh_token) {
                    $this->warn("  Skipped: No refresh token");
                    $skippedCount++;
                    continue;
                }

                if ($dryRun) {
                    $this->info("  [DRY RUN] Would refresh token for user {$user->id}");
                    continue;
                }

                // Attempt to refresh token
                $response = Http::withBasicAuth($zoomSettings->client_id, $zoomSettings->client_secret)
                    ->asForm()
                    ->post('https://zoom.us/oauth/token', [
                        'grant_type' => 'refresh_token',
                        'refresh_token' => $user->zoom_refresh_token,
                    ]);

                if ($response->successful()) {
                    $data = $response->json();

                    // Update user tokens
                    $user->update([
                        'zoom_access_token' => $data['access_token'],
                        'zoom_refresh_token' => $data['refresh_token'] ?? $user->zoom_refresh_token,
                    ]);

                    $this->info("  ✓ Successfully refreshed token");
                    $successCount++;

                    // Log success
                    ZoomAuditLog::logAction(
                        'token_refreshed_scheduled',
                        $user->id,
                        'user',
                        $user->id,
                        ['expires_in' => $data['expires_in'] ?? null]
                    );
                } else {
                    $this->error("  ✗ Failed to refresh: " . $response->body());
                    $failureCount++;

                    // Log failure
                    ZoomAuditLog::logAction(
                        'token_refresh_failed_scheduled',
                        $user->id,
                        'user',
                        $user->id,
                        [
                            'error' => $response->body(),
                            'status_code' => $response->status(),
                        ]
                    );

                    // If refresh token is invalid, clear tokens
                    if ($response->status() === 400) {
                        $this->warn("  Clearing invalid tokens for user {$user->id}");
                        $user->update([
                            'zoom_access_token' => null,
                            'zoom_refresh_token' => null,
                        ]);
                    }
                }
            } catch (\Exception $e) {
                $this->error("  ✗ Exception: " . $e->getMessage());
                $failureCount++;

                Log::error("Failed to refresh Zoom token for user {$user->id}: " . $e->getMessage());
            }
        }

        $this->newLine();
        $this->info('=== Summary ===');
        $this->info("Total users: {$users->count()}");
        $this->info("Successful: {$successCount}");
        $this->info("Failed: {$failureCount}");
        $this->info("Skipped: {$skippedCount}");

        if ($dryRun) {
            $this->warn('DRY RUN completed - no changes were made');
        }

        return 0;
    }
}
