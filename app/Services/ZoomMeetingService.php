<?php

namespace App\Services;

use App\Models\ZoomMeeting;
use App\Models\ZoomAuditLog;
use App\Models\User;
use App\Models\ClassDate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZoomMeetingService
{
    /**
     * Create a Zoom meeting
     *
     * @param User $teacher The teacher hosting the meeting
     * @param array $meetingData Meeting configuration
     * @return array|null Meeting data or null on failure
     */
    public function createMeeting(User $teacher, array $meetingData)
    {
        try {
            if (!$teacher->hasZoomConnected()) {
                throw new \Exception('Teacher does not have Zoom connected');
            }

            // Prepare meeting payload
            $payload = [
                'topic' => $meetingData['topic'] ?? 'Live Class',
                'type' => $meetingData['type'] ?? 2, // 1 = instant, 2 = scheduled
                'start_time' => $meetingData['start_time'] ?? now()->addMinutes(10)->toIso8601String(),
                'duration' => $meetingData['duration'] ?? 60,
                'timezone' => $meetingData['timezone'] ?? 'Asia/Dhaka',
                'settings' => [
                    'host_video' => $meetingData['host_video'] ?? true,
                    'participant_video' => $meetingData['participant_video'] ?? true,
                    'join_before_host' => $meetingData['join_before_host'] ?? false,
                    'mute_upon_entry' => $meetingData['mute_upon_entry'] ?? true,
                    'waiting_room' => $meetingData['waiting_room'] ?? false,
                    'approval_type' => $meetingData['approval_type'] ?? 2, // 0=auto, 1=manual, 2=no registration
                    'audio' => 'both',
                    'auto_recording' => $meetingData['auto_recording'] ?? 'none',
                ],
            ];

            // Add password if provided
            if (isset($meetingData['password'])) {
                $payload['password'] = $meetingData['password'];
            }

            // Call Zoom API
            $response = Http::withToken($teacher->zoom_access_token)
                ->post('https://api.zoom.us/v2/users/me/meetings', $payload);

            if (!$response->successful()) {
                // Try to refresh token if unauthorized
                if ($response->status() === 401) {
                    Log::info('Access token expired, attempting refresh for user ' . $teacher->id);
                    if ($teacher->refreshZoomToken()) {
                        // Retry with new token
                        $response = Http::withToken($teacher->zoom_access_token)
                            ->post('https://api.zoom.us/v2/users/me/meetings', $payload);
                    }
                }

                if (!$response->successful()) {
                    Log::error('Zoom meeting creation failed: ' . $response->body());
                    throw new \Exception('Zoom API error: ' . $response->body());
                }
            }

            $meetingResponse = $response->json();

            // Log success
            ZoomAuditLog::logAction(
                'meeting_created',
                $teacher->id,
                'meeting',
                null,
                [
                    'meeting_id' => $meetingResponse['id'],
                    'topic' => $meetingResponse['topic'],
                ]
            );

            return $meetingResponse;
        } catch (\Exception $e) {
            Log::error('Failed to create Zoom meeting: ' . $e->getMessage());
            ZoomAuditLog::logAction(
                'meeting_creation_failed',
                $teacher->id,
                'meeting',
                null,
                ['error' => $e->getMessage()]
            );
            return null;
        }
    }

    /**
     * Store meeting data in database
     *
     * @param array $zoomResponse Zoom API response
     * @param int $teacherId Teacher user ID
     * @param int|null $orderId Book order ID
     * @param int|null $classDateId Class date ID
     * @return ZoomMeeting|null
     */
    public function storeMeeting(array $zoomResponse, int $teacherId, ?int $orderId = null, ?int $classDateId = null)
    {
        try {
            $meeting = ZoomMeeting::create([
                'order_id' => $orderId,
                'class_date_id' => $classDateId,
                'teacher_id' => $teacherId,
                'meeting_id' => $zoomResponse['id'],
                'meeting_password' => $zoomResponse['password'] ?? null,
                'join_url' => $zoomResponse['join_url'],
                'start_url' => $zoomResponse['start_url'],
                'host_email' => $zoomResponse['host_email'] ?? auth()->user()->email,
                'topic' => $zoomResponse['topic'],
                'start_time' => $zoomResponse['start_time'],
                'duration' => $zoomResponse['duration'],
                'timezone' => $zoomResponse['timezone'],
                'status' => 'scheduled',
            ]);

            // Update class_date zoom_link if provided
            if ($classDateId) {
                ClassDate::where('id', $classDateId)->update([
                    'zoom_link' => $zoomResponse['join_url'],
                ]);
            }

            return $meeting;
        } catch (\Exception $e) {
            Log::error('Failed to store meeting in database: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Update a Zoom meeting
     *
     * @param User $teacher
     * @param string $meetingId
     * @param array $updateData
     * @return bool
     */
    public function updateMeeting(User $teacher, string $meetingId, array $updateData)
    {
        try {
            if (!$teacher->hasZoomConnected()) {
                throw new \Exception('Teacher does not have Zoom connected');
            }

            $response = Http::withToken($teacher->zoom_access_token)
                ->patch("https://api.zoom.us/v2/meetings/{$meetingId}", $updateData);

            if ($response->status() === 401 && $teacher->refreshZoomToken()) {
                $response = Http::withToken($teacher->zoom_access_token)
                    ->patch("https://api.zoom.us/v2/meetings/{$meetingId}", $updateData);
            }

            if (!$response->successful()) {
                Log::error("Failed to update Zoom meeting {$meetingId}: " . $response->body());
                return false;
            }

            ZoomAuditLog::logAction('meeting_updated', $teacher->id, 'meeting', null, [
                'meeting_id' => $meetingId,
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to update meeting: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a Zoom meeting
     *
     * @param User $teacher
     * @param string $meetingId
     * @return bool
     */
    public function deleteMeeting(User $teacher, string $meetingId)
    {
        try {
            if (!$teacher->hasZoomConnected()) {
                throw new \Exception('Teacher does not have Zoom connected');
            }

            $response = Http::withToken($teacher->zoom_access_token)
                ->delete("https://api.zoom.us/v2/meetings/{$meetingId}");

            if ($response->status() === 401 && $teacher->refreshZoomToken()) {
                $response = Http::withToken($teacher->zoom_access_token)
                    ->delete("https://api.zoom.us/v2/meetings/{$meetingId}");
            }

            if (!$response->successful() && $response->status() !== 404) {
                Log::error("Failed to delete Zoom meeting {$meetingId}: " . $response->body());
                return false;
            }

            // Update database record
            ZoomMeeting::where('meeting_id', $meetingId)->update(['status' => 'cancelled']);

            ZoomAuditLog::logAction('meeting_deleted', $teacher->id, 'meeting', null, [
                'meeting_id' => $meetingId,
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to delete meeting: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get meeting details from Zoom API
     *
     * @param User $teacher
     * @param string $meetingId
     * @return array|null
     */
    public function getMeetingDetails(User $teacher, string $meetingId)
    {
        try {
            if (!$teacher->hasZoomConnected()) {
                throw new \Exception('Teacher does not have Zoom connected');
            }

            $response = Http::withToken($teacher->zoom_access_token)
                ->get("https://api.zoom.us/v2/meetings/{$meetingId}");

            if ($response->status() === 401 && $teacher->refreshZoomToken()) {
                $response = Http::withToken($teacher->zoom_access_token)
                    ->get("https://api.zoom.us/v2/meetings/{$meetingId}");
            }

            if (!$response->successful()) {
                Log::error("Failed to get Zoom meeting {$meetingId}: " . $response->body());
                return null;
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Failed to get meeting details: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Add registrant to a meeting (for secure join flow)
     *
     * @param User $teacher
     * @param string $meetingId
     * @param array $registrantData ['email', 'first_name', 'last_name']
     * @return array|null Returns join_url or null
     */
    public function addRegistrant(User $teacher, string $meetingId, array $registrantData)
    {
        try {
            if (!$teacher->hasZoomConnected()) {
                throw new \Exception('Teacher does not have Zoom connected');
            }

            $response = Http::withToken($teacher->zoom_access_token)
                ->post("https://api.zoom.us/v2/meetings/{$meetingId}/registrants", $registrantData);

            if ($response->status() === 401 && $teacher->refreshZoomToken()) {
                $response = Http::withToken($teacher->zoom_access_token)
                    ->post("https://api.zoom.us/v2/meetings/{$meetingId}/registrants", $registrantData);
            }

            if (!$response->successful()) {
                Log::error("Failed to add registrant to meeting {$meetingId}: " . $response->body());
                return null;
            }

            $registrantResponse = $response->json();

            ZoomAuditLog::logAction('registrant_added', $teacher->id, 'meeting', null, [
                'meeting_id' => $meetingId,
                'registrant_email' => $registrantData['email'],
            ]);

            return $registrantResponse;
        } catch (\Exception $e) {
            Log::error('Failed to add registrant: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get list of meeting participants
     *
     * @param User $teacher
     * @param string $meetingId
     * @return array|null
     */
    public function getParticipants(User $teacher, string $meetingId)
    {
        try {
            if (!$teacher->hasZoomConnected()) {
                throw new \Exception('Teacher does not have Zoom connected');
            }

            $response = Http::withToken($teacher->zoom_access_token)
                ->get("https://api.zoom.us/v2/report/meetings/{$meetingId}/participants");

            if ($response->status() === 401 && $teacher->refreshZoomToken()) {
                $response = Http::withToken($teacher->zoom_access_token)
                    ->get("https://api.zoom.us/v2/report/meetings/{$meetingId}/participants");
            }

            if (!$response->successful()) {
                Log::error("Failed to get participants for meeting {$meetingId}: " . $response->body());
                return null;
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Failed to get participants: ' . $e->getMessage());
            return null;
        }
    }
}
