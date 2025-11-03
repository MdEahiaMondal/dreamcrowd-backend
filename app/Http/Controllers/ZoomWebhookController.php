<?php

namespace App\Http\Controllers;

use App\Models\ZoomMeeting;
use App\Models\ZoomParticipant;
use App\Models\ZoomSetting;
use App\Models\ZoomAuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ZoomWebhookController extends Controller
{
    /**
     * Handle incoming Zoom webhooks
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request)
    {
        try {
            // Verify webhook signature
            if (!$this->verifySignature($request)) {
                Log::warning('Zoom webhook signature verification failed', [
                    'ip' => $request->ip(),
                    'headers' => $request->headers->all(),
                ]);
                return response()->json(['error' => 'Invalid signature'], 401);
            }

            $payload = $request->all();
            $event = $payload['event'] ?? null;

            Log::info('Zoom webhook received', [
                'event' => $event,
                'payload' => $payload,
            ]);

            // Handle different event types
            switch ($event) {
                case 'meeting.started':
                    $this->handleMeetingStarted($payload);
                    break;

                case 'meeting.ended':
                    $this->handleMeetingEnded($payload);
                    break;

                case 'meeting.participant_joined':
                    $this->handleParticipantJoined($payload);
                    break;

                case 'meeting.participant_left':
                    $this->handleParticipantLeft($payload);
                    break;

                case 'endpoint.url_validation':
                    // Zoom sends this to validate webhook URL
                    return $this->handleUrlValidation($payload);

                default:
                    Log::info('Unhandled Zoom webhook event: ' . $event);
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Zoom webhook processing error: ' . $e->getMessage(), [
                'exception' => $e,
                'payload' => $request->all(),
            ]);
            return response()->json(['error' => 'Internal error'], 500);
        }
    }

    /**
     * Verify Zoom webhook signature
     *
     * @param Request $request
     * @return bool
     */
    protected function verifySignature(Request $request)
    {
        $signature = $request->header('x-zm-signature');
        $timestamp = $request->header('x-zm-request-timestamp');

        if (!$signature || !$timestamp) {
            return false;
        }

        // Get webhook secret from settings
        $zoomSettings = ZoomSetting::getActive();
        if (!$zoomSettings || !$zoomSettings->webhook_secret) {
            Log::warning('Zoom webhook secret not configured');
            return true; // Allow webhooks if secret not set (for development)
        }

        $webhookSecret = $zoomSettings->webhook_secret;
        $payload = $request->getContent();

        // Construct message: v0:{timestamp}:{payload}
        $message = "v0:{$timestamp}:{$payload}";

        // Calculate expected signature
        $expectedSignature = hash_hmac('sha256', $message, $webhookSecret);

        // Zoom sends signature as: v0={hash}
        $expectedHeader = "v0={$expectedSignature}";

        // Compare signatures (timing-safe)
        return hash_equals($expectedHeader, $signature);
    }

    /**
     * Handle URL validation event
     *
     * @param array $payload
     * @return \Illuminate\Http\JsonResponse
     */
    protected function handleUrlValidation(array $payload)
    {
        $plainToken = $payload['payload']['plainToken'] ?? null;

        if (!$plainToken) {
            return response()->json(['error' => 'No plain token provided'], 400);
        }

        // Encrypt the plain token and return
        $encryptedToken = hash_hmac('sha256', $plainToken, ZoomSetting::getActive()->webhook_secret ?? '');

        return response()->json([
            'plainToken' => $plainToken,
            'encryptedToken' => $encryptedToken,
        ]);
    }

    /**
     * Handle meeting started event
     *
     * @param array $payload
     */
    protected function handleMeetingStarted(array $payload)
    {
        try {
            $meetingId = $payload['payload']['object']['id'] ?? null;

            if (!$meetingId) {
                return;
            }

            $meeting = ZoomMeeting::where('meeting_id', $meetingId)->first();

            if ($meeting) {
                $meeting->startMeeting();

                Log::info("Meeting started: {$meetingId}", [
                    'host_id' => $payload['payload']['object']['host_id'] ?? null,
                    'start_time' => $payload['payload']['object']['start_time'] ?? null,
                ]);

                ZoomAuditLog::logAction('meeting_started_webhook', null, 'meeting', $meeting->id, [
                    'meeting_id' => $meetingId,
                    'zoom_host_id' => $payload['payload']['object']['host_id'] ?? null,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error handling meeting.started: ' . $e->getMessage());
        }
    }

    /**
     * Handle meeting ended event
     *
     * @param array $payload
     */
    protected function handleMeetingEnded(array $payload)
    {
        try {
            $meetingId = $payload['payload']['object']['id'] ?? null;

            if (!$meetingId) {
                return;
            }

            $meeting = ZoomMeeting::where('meeting_id', $meetingId)->first();

            if ($meeting) {
                $meeting->endMeeting();

                Log::info("Meeting ended: {$meetingId}", [
                    'duration' => $payload['payload']['object']['duration'] ?? null,
                ]);

                ZoomAuditLog::logAction('meeting_ended_webhook', null, 'meeting', $meeting->id, [
                    'meeting_id' => $meetingId,
                    'duration' => $payload['payload']['object']['duration'] ?? null,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error handling meeting.ended: ' . $e->getMessage());
        }
    }

    /**
     * Handle participant joined event
     *
     * @param array $payload
     */
    protected function handleParticipantJoined(array $payload)
    {
        try {
            $meetingId = $payload['payload']['object']['id'] ?? null;
            $participant = $payload['payload']['object']['participant'] ?? null;

            if (!$meetingId || !$participant) {
                return;
            }

            $meeting = ZoomMeeting::where('meeting_id', $meetingId)->first();

            if (!$meeting) {
                Log::warning("Participant joined unknown meeting: {$meetingId}");
                return;
            }

            $participantId = $participant['id'] ?? $participant['user_id'] ?? null;
            $userEmail = $participant['user_name'] ?? $participant['email'] ?? 'Unknown';
            $userName = $participant['user_name'] ?? 'Unknown';
            $joinTime = $participant['join_time'] ?? now();

            // Determine role
            $role = 'participant';
            if (isset($participant['role']) && $participant['role'] === 'host') {
                $role = 'host';
            }

            // Try to find user by email
            $user = \App\Models\User::where('email', $userEmail)->first();
            $userId = $user ? $user->id : null;

            if (!$userId && !filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
                // If no valid email, treat as guest
                $role = 'guest';
            }

            // Check if participant already exists (for rejoins)
            $existingParticipant = ZoomParticipant::where('meeting_id', $meeting->id)
                ->where('user_email', $userEmail)
                ->whereNull('leave_time')
                ->first();

            if ($existingParticipant) {
                // Update join time for rejoin
                $existingParticipant->update(['join_time' => $joinTime]);
            } else {
                // Create new participant record
                ZoomParticipant::create([
                    'meeting_id' => $meeting->id,
                    'user_id' => $userId,
                    'user_email' => $userEmail,
                    'user_name' => $userName,
                    'role' => $role,
                    'join_time' => $joinTime,
                ]);
            }

            Log::info("Participant joined meeting {$meetingId}: {$userName} ({$userEmail})");

            ZoomAuditLog::logAction('participant_joined_webhook', $userId, 'meeting', $meeting->id, [
                'meeting_id' => $meetingId,
                'participant_name' => $userName,
                'participant_email' => $userEmail,
                'role' => $role,
            ]);
        } catch (\Exception $e) {
            Log::error('Error handling participant.joined: ' . $e->getMessage());
        }
    }

    /**
     * Handle participant left event
     *
     * @param array $payload
     */
    protected function handleParticipantLeft(array $payload)
    {
        try {
            $meetingId = $payload['payload']['object']['id'] ?? null;
            $participant = $payload['payload']['object']['participant'] ?? null;

            if (!$meetingId || !$participant) {
                return;
            }

            $meeting = ZoomMeeting::where('meeting_id', $meetingId)->first();

            if (!$meeting) {
                return;
            }

            $userEmail = $participant['user_name'] ?? $participant['email'] ?? 'Unknown';
            $leaveTime = $participant['leave_time'] ?? now();

            // Find participant record
            $participantRecord = ZoomParticipant::where('meeting_id', $meeting->id)
                ->where('user_email', $userEmail)
                ->whereNull('leave_time')
                ->orderBy('join_time', 'desc')
                ->first();

            if ($participantRecord) {
                $participantRecord->update([
                    'leave_time' => $leaveTime,
                    'duration_seconds' => now()->diffInSeconds($participantRecord->join_time),
                ]);

                Log::info("Participant left meeting {$meetingId}: {$userEmail}");

                ZoomAuditLog::logAction('participant_left_webhook', $participantRecord->user_id, 'meeting', $meeting->id, [
                    'meeting_id' => $meetingId,
                    'participant_email' => $userEmail,
                    'duration_seconds' => $participantRecord->duration_seconds,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error handling participant.left: ' . $e->getMessage());
        }
    }

    /**
     * Manual test endpoint (for development only - remove in production)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function test(Request $request)
    {
        if (app()->environment('production')) {
            return response()->json(['error' => 'Not available in production'], 403);
        }

        $event = $request->input('event', 'meeting.participant_joined');

        $testPayload = [
            'event' => $event,
            'payload' => [
                'object' => [
                    'id' => $request->input('meeting_id', '123456789'),
                    'participant' => [
                        'user_name' => $request->input('user_name', 'Test User'),
                        'email' => $request->input('email', 'test@example.com'),
                        'join_time' => now()->toIso8601String(),
                        'role' => 'participant',
                    ],
                ],
            ],
        ];

        // Process the test payload
        switch ($event) {
            case 'meeting.participant_joined':
                $this->handleParticipantJoined($testPayload);
                break;
            case 'meeting.participant_left':
                $this->handleParticipantLeft($testPayload);
                break;
            case 'meeting.started':
                $this->handleMeetingStarted($testPayload);
                break;
            case 'meeting.ended':
                $this->handleMeetingEnded($testPayload);
                break;
        }

        return response()->json([
            'status' => 'test_processed',
            'event' => $event,
            'payload' => $testPayload,
        ]);
    }
}
