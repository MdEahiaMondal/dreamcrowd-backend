<?php

namespace App\Http\Controllers;

use App\Models\ZoomSetting;
use App\Models\ZoomAuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZoomOAuthController extends Controller
{
    /**
     * Check teacher authentication
     */
    private function checkTeacherAuth()
    {
        if (!Auth::user()) {
            return redirect()->to('/')->with('error', 'Please login to your account!');
        }

        if (Auth::user()->role != 1) {
            return redirect()->to('/')->with('error', 'Unauthorized access!');
        }

        return null;
    }

    /**
     * Show Zoom connection status page
     */
    public function index()
    {
        if ($redirect = $this->checkTeacherAuth()) {
            return $redirect;
        }

        $user = Auth::user();
        $isConnected = $user->hasZoomConnected();

        // Get recent meetings hosted by this teacher
        $recentMeetings = $user->hostedMeetings()
            ->with('participants')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('Teacher-Dashboard.zoom-connect', compact('user', 'isConnected', 'recentMeetings'));
    }

    /**
     * Initiate OAuth connection
     */
    public function connect()
    {
        if ($redirect = $this->checkTeacherAuth()) {
            return $redirect;
        }

        try {
            $zoomSettings = ZoomSetting::getActive();

            if (!$zoomSettings) {
                return redirect()->back()->with('error', 'Zoom is not configured yet. Please contact administrator.');
            }

            // Generate state parameter for CSRF protection
            $state = base64_encode(json_encode([
                'user_id' => Auth::id(),
                'timestamp' => time(),
                'token' => csrf_token(),
            ]));

            session(['zoom_oauth_state' => $state]);

            // Build OAuth authorization URL
            $authUrl = 'https://zoom.us/oauth/authorize?' . http_build_query([
                    'response_type' => 'code',
                    'client_id' => $zoomSettings->client_id,
                    'redirect_uri' => $zoomSettings->redirect_uri,
                    'state' => $state,
                ]);

            ZoomAuditLog::logAction('oauth_connect_initiated', Auth::id(), 'user', Auth::id());

            return redirect($authUrl);
        } catch (\Exception $e) {
            Log::error('Zoom OAuth connect failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to connect to Zoom. Please try again.');
        }
    }

    /**
     * Handle OAuth callback from Zoom
     */
    public function callback(Request $request)
    {
        if ($redirect = $this->checkTeacherAuth()) {
            return $redirect;
        }

        try {
            // Validate state parameter (CSRF protection)
            $state = $request->input('state');
            $sessionState = session('zoom_oauth_state');

            if (!$state || $state !== $sessionState) {
                ZoomAuditLog::logAction('oauth_callback_invalid_state', Auth::id(), 'user', Auth::id(), [
                    'error' => 'Invalid state parameter',
                ]);
                return redirect('/teacher/zoom')->with('error', 'Invalid OAuth state. Please try again.');
            }

            // Clear state from session
            session()->forget('zoom_oauth_state');

            // Check for errors
            if ($request->has('error')) {
                ZoomAuditLog::logAction('oauth_callback_error', Auth::id(), 'user', Auth::id(), [
                    'error' => $request->input('error'),
                    'error_description' => $request->input('error_description'),
                ]);
                return redirect('/teacher/zoom')->with('error', 'OAuth authorization failed: ' . $request->input('error_description'));
            }

            $code = $request->input('code');
            if (!$code) {
                return redirect('/teacher/zoom')->with('error', 'No authorization code received.');
            }

            // Exchange code for tokens
            $zoomSettings = ZoomSetting::getActive();
            if (!$zoomSettings) {
                return redirect('/teacher/zoom')->with('error', 'Zoom settings not found.');
            }

            $response = Http::withBasicAuth($zoomSettings->client_id, $zoomSettings->client_secret)
                ->asForm()
                ->post('https://zoom.us/oauth/token', [
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'redirect_uri' => $zoomSettings->redirect_uri,
                ]);

            if (!$response->successful()) {
                Log::error('Zoom token exchange failed: ' . $response->body());
                ZoomAuditLog::logAction('oauth_token_exchange_failed', Auth::id(), 'user', Auth::id(), [
                    'error' => $response->json(),
                ]);
                return redirect('/teacher/zoom')->with('error', 'Failed to obtain access token from Zoom.');
            }

            $tokenData = $response->json();

            // Save tokens to user
            $user = Auth::user();
            $user->update([
                'zoom_access_token' => $tokenData['access_token'],
                'zoom_refresh_token' => $tokenData['refresh_token'],
            ]);

            ZoomAuditLog::logAction('oauth_connect_success', $user->id, 'user', $user->id, [
                'expires_in' => $tokenData['expires_in'] ?? null,
            ]);

            return redirect('/teacher/zoom')->with('success', 'Zoom account connected successfully!');
        } catch (\Exception $e) {
            Log::error('Zoom OAuth callback error: ' . $e->getMessage());
            ZoomAuditLog::logAction('oauth_callback_exception', Auth::id(), 'user', Auth::id(), [
                'error' => $e->getMessage(),
            ]);
            return redirect('/teacher/zoom')->with('error', 'An error occurred during OAuth. Please try again.');
        }
    }

    /**
     * Disconnect Zoom account
     */
    public function disconnect()
    {
        if ($redirect = $this->checkTeacherAuth()) {
            return $redirect;
        }

        try {
            $user = Auth::user();

            if (!$user->hasZoomConnected()) {
                return redirect()->back()->with('error', 'No Zoom account connected.');
            }

            $user->disconnectZoom();

            return redirect()->back()->with('success', 'Zoom account disconnected successfully!');
        } catch (\Exception $e) {
            Log::error('Zoom disconnect failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to disconnect Zoom account.');
        }
    }

    /**
     * Manually refresh access token
     */
    public function refreshToken()
    {
        if ($redirect = $this->checkTeacherAuth()) {
            return $redirect;
        }

        try {
            $user = Auth::user();

            if (!$user->zoom_refresh_token) {
                return redirect()->back()->with('error', 'No refresh token available. Please reconnect your Zoom account.');
            }

            $success = $user->refreshZoomToken();

            if ($success) {
                return redirect()->back()->with('success', 'Zoom token refreshed successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to refresh token. Please reconnect your Zoom account.');
            }
        } catch (\Exception $e) {
            Log::error('Manual token refresh failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while refreshing the token.');
        }
    }

    /**
     * Get connection status (AJAX endpoint)
     */
    public function status()
    {
        if ($redirect = $this->checkTeacherAuth()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $hasConnection = $user->hasZoomConnected();

        return response()->json([
            'connected' => $hasConnection,
            'email' => $hasConnection ? $user->getZoomEmail() : null,
            'meetings_count' => $user->hostedMeetings()->count(),
        ]);
    }
}
