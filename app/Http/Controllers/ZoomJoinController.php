<?php

namespace App\Http\Controllers;

use App\Models\ZoomSecureToken;
use App\Models\ZoomMeeting;
use App\Models\ZoomAuditLog;
use App\Models\ClassDate;
use App\Services\ZoomMeetingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ZoomJoinController extends Controller
{
    protected $zoomMeetingService;

    public function __construct(ZoomMeetingService $zoomMeetingService)
    {
        $this->zoomMeetingService = $zoomMeetingService;
    }

    /**
     * Secure join endpoint - validates token and redirects to Zoom
     *
     * @param int $classDateId
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function joinClass($classDateId, Request $request)
    {
        try {
            $token = $request->query('token');

            if (!$token) {
                ZoomAuditLog::logAction('join_attempt_no_token', auth()->id(), 'class_date', $classDateId);
                return redirect('/')->with('error', 'Invalid join link. No token provided.');
            }

            // Validate token
            $tokenRecord = ZoomSecureToken::validateToken($token);
            if (!$tokenRecord) {
                ZoomAuditLog::logAction('join_attempt_invalid_token', auth()->id(), 'class_date', $classDateId, [
                    'token_provided' => substr($token, 0, 10) . '...',
                ]);
                return redirect('/')->with('error', 'Invalid or expired join link.');
            }

            // Verify class date matches
            if ($tokenRecord->class_date_id != $classDateId) {
                ZoomAuditLog::logAction('join_attempt_mismatched_class', auth()->id(), 'class_date', $classDateId);
                return redirect('/')->with('error', 'Invalid join link for this class.');
            }

            // Get class date and zoom meeting
            $classDate = ClassDate::with(['bookOrder.teacher', 'zoomMeeting'])->find($classDateId);

            if (!$classDate) {
                ZoomAuditLog::logAction('join_attempt_class_not_found', auth()->id(), 'class_date', $classDateId);
                return redirect('/')->with('error', 'Class not found.');
            }

            $zoomMeeting = $classDate->zoomMeeting;

            if (!$zoomMeeting) {
                ZoomAuditLog::logAction('join_attempt_no_meeting', auth()->id(), 'class_date', $classDateId);
                return redirect('/')->with('error', 'Zoom meeting not created yet. Please contact your teacher.');
            }

            // Check if meeting is scheduled or started
            if (!in_array($zoomMeeting->status, ['scheduled', 'started'])) {
                return redirect('/')->with('error', 'This meeting is no longer available.');
            }

            // Mark token as used
            $tokenRecord->markAsUsed($request->ip(), $request->userAgent());

            // Get teacher
            $teacher = $classDate->bookOrder->teacher;

            // For registered users, we can use their details
            // For guests, use the email from token
            $userEmail = $tokenRecord->email;
            $userName = 'Guest';

            if ($tokenRecord->user_id) {
                $user = \App\Models\User::find($tokenRecord->user_id);
                if ($user) {
                    $userName = $user->first_name . ' ' . $user->last_name;
                    $userEmail = $user->email;
                }
            }

            // For simple join (without registration requirement), just redirect
            // If you want to use registrant API for extra security, uncomment below:

            /*
            $registrantData = $this->zoomMeetingService->addRegistrant(
                $teacher,
                $zoomMeeting->meeting_id,
                [
                    'email' => $userEmail,
                    'first_name' => explode(' ', $userName)[0],
                    'last_name' => explode(' ', $userName)[1] ?? '',
                ]
            );

            if ($registrantData && isset($registrantData['join_url'])) {
                $joinUrl = $registrantData['join_url'];
            } else {
                $joinUrl = $zoomMeeting->join_url;
            }
            */

            // Direct join URL (simpler approach)
            $joinUrl = $zoomMeeting->join_url;

            // Log successful join attempt
            ZoomAuditLog::logAction('join_success', $tokenRecord->user_id, 'meeting', $zoomMeeting->id, [
                'class_date_id' => $classDateId,
                'user_email' => $userEmail,
                'is_guest' => is_null($tokenRecord->user_id),
            ]);

            // Redirect to Zoom meeting
            return redirect($joinUrl);
        } catch (\Exception $e) {
            Log::error('Join class error: ' . $e->getMessage());
            ZoomAuditLog::logAction('join_attempt_exception', auth()->id(), 'class_date', $classDateId, [
                'error' => $e->getMessage(),
            ]);
            return redirect('/')->with('error', 'An error occurred while joining the class. Please try again.');
        }
    }

    /**
     * Guest join endpoint - for users without accounts
     *
     * @param int $classDateId
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function guestJoin($classDateId, Request $request)
    {
        // This uses the same logic as joinClass since tokens work for both
        return $this->joinClass($classDateId, $request);
    }

    /**
     * Direct join for teachers (start URL)
     *
     * @param int $meetingId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function teacherStart($meetingId)
    {
        try {
            if (!Auth::check() || Auth::user()->role != 1) {
                return redirect('/')->with('error', 'Only teachers can start meetings.');
            }

            $zoomMeeting = ZoomMeeting::where('id', $meetingId)
                ->where('teacher_id', Auth::id())
                ->first();

            if (!$zoomMeeting) {
                return redirect('/teacher-dashboard')->with('error', 'Meeting not found or unauthorized.');
            }

            // Log teacher starting meeting
            ZoomAuditLog::logAction('teacher_start_meeting', Auth::id(), 'meeting', $zoomMeeting->id, [
                'meeting_id' => $zoomMeeting->meeting_id,
            ]);

            // Redirect to Zoom start URL
            return redirect($zoomMeeting->start_url);
        } catch (\Exception $e) {
            Log::error('Teacher start meeting error: ' . $e->getMessage());
            return redirect('/teacher-dashboard')->with('error', 'Failed to start meeting.');
        }
    }

    /**
     * Show join page with instructions (optional landing page)
     *
     * @param int $classDateId
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function joinPage($classDateId, Request $request)
    {
        try {
            $token = $request->query('token');

            if (!$token) {
                return redirect('/')->with('error', 'Invalid join link.');
            }

            // Validate token without marking as used
            $tokenRecord = ZoomSecureToken::where('token', hash('sha256', $token))
                ->where('expires_at', '>', now())
                ->first();

            if (!$tokenRecord || $tokenRecord->class_date_id != $classDateId) {
                return redirect('/')->with('error', 'Invalid or expired join link.');
            }

            // Get class information
            $classDate = ClassDate::with(['bookOrder.teacher', 'bookOrder.gig', 'zoomMeeting'])
                ->find($classDateId);

            if (!$classDate) {
                return redirect('/')->with('error', 'Class not found.');
            }

            $data = [
                'classDate' => $classDate,
                'teacher' => $classDate->bookOrder->teacher,
                'gig' => $classDate->bookOrder->gig,
                'meeting' => $classDate->zoomMeeting,
                'token' => $token,
            ];

            // Return a join page view (you can create this view)
            return view('zoom.join-page', $data);
        } catch (\Exception $e) {
            Log::error('Join page error: ' . $e->getMessage());
            return redirect('/')->with('error', 'An error occurred.');
        }
    }
}
