<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ZoomSetting;
use App\Models\ZoomMeeting;
use App\Models\ZoomAuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ZoomSettingsController extends Controller
{
    /**
     * Check admin authentication
     */
    private function AdmincheckAuth()
    {
        if (!Auth::user()) {
            return redirect()->to('/')->with('error', 'Please LoginIn to Your Account!');
        } else {
            if (Auth::user()->role == 0) {
                return redirect()->to('/user-dashboard');
            } elseif (Auth::user()->role == 1) {
                return redirect()->to('/teacher-dashboard');
            }
        }
    }

    /**
     * Display Zoom settings page
     */
    public function index()
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $settings = ZoomSetting::first();
        $auditLogs = ZoomAuditLog::where('entity_type', 'settings')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return view('Admin-Dashboard.zoom-settings', compact('settings', 'auditLogs'));
    }

    /**
     * Update Zoom settings
     */
    public function update(Request $request)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $validator = Validator::make($request->all(), [
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
            'redirect_uri' => 'required|url',
            'account_id' => 'nullable|string',
            'base_url' => 'nullable|url',
            'webhook_secret' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fix the validation errors.');
        }

        try {
            $settings = ZoomSetting::first();

            if ($settings) {
                $settings->update([
                    'client_id' => $request->client_id,
                    'client_secret' => $request->client_secret,
                    'redirect_uri' => $request->redirect_uri,
                    'account_id' => $request->account_id,
                    'base_url' => $request->base_url ?? 'https://api.zoom.us/v2',
                    'webhook_secret' => $request->webhook_secret,
                    'is_active' => true,
                    'updated_by' => Auth::id(),
                ]);
            } else {
                $settings = ZoomSetting::create([
                    'client_id' => $request->client_id,
                    'client_secret' => $request->client_secret,
                    'redirect_uri' => $request->redirect_uri,
                    'account_id' => $request->account_id,
                    'base_url' => $request->base_url ?? 'https://api.zoom.us/v2',
                    'webhook_secret' => $request->webhook_secret,
                    'is_active' => true,
                    'updated_by' => Auth::id(),
                ]);
            }

            // Log the action
            ZoomAuditLog::logAction(
                'settings_updated',
                Auth::id(),
                'settings',
                $settings->id,
                ['action' => 'Updated Zoom credentials']
            );

            return redirect()->back()->with('success', 'Zoom settings updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to update Zoom settings: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update Zoom settings. Please try again.');
        }
    }

    /**
     * Test Zoom API connection
     */
    public function testConnection(Request $request)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        try {
            $settings = ZoomSetting::getActive();

            if (!$settings) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Zoom settings not configured.',
                ], 404);
            }

            $testResult = $settings->testConnection();

            if ($testResult) {
                ZoomAuditLog::logAction(
                    'connection_test_success',
                    Auth::id(),
                    'settings',
                    $settings->id
                );

                return response()->json([
                    'status' => 'success',
                    'message' => 'Connection successful! Zoom API is working correctly.',
                ]);
            } else {
                ZoomAuditLog::logAction(
                    'connection_test_failed',
                    Auth::id(),
                    'settings',
                    $settings->id
                );

                return response()->json([
                    'status' => 'error',
                    'message' => 'Connection failed. Please check your credentials.',
                ], 400);
            }
        } catch (\Exception $e) {
            \Log::error('Zoom connection test failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Connection test failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * View live classes
     */
    public function liveClasses()
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $activeMeetings = ZoomMeeting::getActiveMeetings();
        $scheduledMeetings = ZoomMeeting::where('status', 'scheduled')
            ->where('start_time', '>', now())
            ->with(['teacher', 'classDate'])
            ->orderBy('start_time', 'asc')
            ->limit(20)
            ->get();

        return view('Admin-Dashboard.live-classes', compact('activeMeetings', 'scheduledMeetings'));
    }

    /**
     * Get live classes data (AJAX endpoint for polling)
     */
    public function liveClassesData()
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $activeMeetings = ZoomMeeting::where('status', 'started')
            ->with(['teacher', 'participants', 'classDate.bookOrder'])
            ->get()
            ->map(function ($meeting) {
                return [
                    'id' => $meeting->id,
                    'topic' => $meeting->topic,
                    'teacher_name' => $meeting->teacher->first_name . ' ' . $meeting->teacher->last_name,
                    'start_time' => $meeting->actual_start_time->format('Y-m-d H:i:s'),
                    'duration' => $meeting->duration,
                    'participant_count' => $meeting->participants->count(),
                    'participants' => $meeting->participants->map(function ($p) {
                        return [
                            'name' => $p->user_name,
                            'email' => $p->user_email,
                            'role' => $p->role,
                            'join_time' => $p->join_time->format('H:i:s'),
                            'is_guest' => $p->isGuest(),
                        ];
                    }),
                ];
            });

        return response()->json([
            'status' => 'success',
            'meetings' => $activeMeetings,
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    /**
     * View audit logs
     */
    public function auditLogs(Request $request)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $query = ZoomAuditLog::with('user')->orderBy('created_at', 'desc');

        // Filter by action if provided
        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }

        // Filter by date range if provided
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(50);

        // Calculate statistics
        $totalLogs = ZoomAuditLog::count();
        $todayLogs = ZoomAuditLog::whereDate('created_at', today())->count();
        $uniqueUsers = ZoomAuditLog::whereNotNull('user_id')->distinct('user_id')->count('user_id');
        $recentActions = ZoomAuditLog::where('created_at', '>=', now()->subHour())->count();

        return view('Admin-Dashboard.zoom-audit-logs', compact('logs', 'totalLogs', 'todayLogs', 'uniqueUsers', 'recentActions'));
    }

    /**
     * Get security logs (unauthorized access attempts)
     */
    public function securityLogs()
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        // Get security-related logs (failed attempts, invalid tokens, etc.)
        $logs = ZoomAuditLog::where(function($query) {
                $query->where('action', 'like', '%invalid%')
                      ->orWhere('action', 'like', '%unauthorized%')
                      ->orWhere('action', 'like', '%failed%')
                      ->orWhere('action', 'like', '%expired%');
            })
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        // Calculate statistics
        $totalSecurityEvents = ZoomAuditLog::where(function($query) {
                $query->where('action', 'like', '%invalid%')
                      ->orWhere('action', 'like', '%unauthorized%')
                      ->orWhere('action', 'like', '%failed%');
            })->count();

        $todayEvents = ZoomAuditLog::where(function($query) {
                $query->where('action', 'like', '%invalid%')
                      ->orWhere('action', 'like', '%unauthorized%')
                      ->orWhere('action', 'like', '%failed%');
            })
            ->whereDate('created_at', today())
            ->count();

        $criticalCount = ZoomAuditLog::where(function($query) {
                $query->where('action', 'like', '%invalid%')
                      ->orWhere('action', 'like', '%unauthorized%');
            })
            ->where('created_at', '>=', now()->subDay())
            ->count();

        $uniqueIPs = ZoomAuditLog::where(function($query) {
                $query->where('action', 'like', '%invalid%')
                      ->orWhere('action', 'like', '%unauthorized%');
            })
            ->whereNotNull('ip_address')
            ->distinct('ip_address')
            ->count('ip_address');

        $lastHourEvents = ZoomAuditLog::where(function($query) {
                $query->where('action', 'like', '%invalid%')
                      ->orWhere('action', 'like', '%unauthorized%');
            })
            ->where('created_at', '>=', now()->subHour())
            ->count();

        // Get top threatening IPs
        $topThreateningIPs = ZoomAuditLog::select('ip_address', \DB::raw('count(*) as attempts'), \DB::raw('MAX(created_at) as last_attempt'))
            ->where(function($query) {
                $query->where('action', 'like', '%invalid%')
                      ->orWhere('action', 'like', '%unauthorized%');
            })
            ->whereNotNull('ip_address')
            ->groupBy('ip_address')
            ->orderBy('attempts', 'desc')
            ->limit(10)
            ->get()
            ->map(function($item) {
                return [
                    'ip' => $item->ip_address,
                    'count' => $item->attempts,
                    'last_attempt' => \Carbon\Carbon::parse($item->last_attempt)->diffForHumans()
                ];
            });

        return view('Admin-Dashboard.zoom-security-logs', compact(
            'logs',
            'totalSecurityEvents',
            'todayEvents',
            'criticalCount',
            'uniqueIPs',
            'lastHourEvents',
            'topThreateningIPs'
        ));
    }
}
