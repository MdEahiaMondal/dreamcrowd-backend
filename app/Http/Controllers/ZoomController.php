<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class ZoomController extends Controller
{
    // Step 1: Redirect user to Zoom OAuth
    public function redirectToZoom()
    {
        $zoomAuthUrl = 'https://zoom.us/oauth/authorize?' . http_build_query([
                'response_type' => 'code',
                'client_id' => env('ZOOM_CLIENT_ID'),
                'redirect_uri' => env('ZOOM_REDIRECT_URI'),
            ]);
        return redirect($zoomAuthUrl);
    }

    // Step 2: Handle OAuth callback and save token
    public function handleCallback(Request $request)
    {
        $response = Http::withBasicAuth(env('ZOOM_CLIENT_ID'), env('ZOOM_CLIENT_SECRET'))
            ->asForm()
            ->post('https://zoom.us/oauth/token', [
                'grant_type' => 'authorization_code',
                'code' => $request->code,
                'redirect_uri' => env('ZOOM_REDIRECT_URI'),
            ])
            ->json();

        // Save access & refresh tokens
        $user = Auth::user();
        $user->zoom_access_token = $response['access_token'];
        $user->zoom_refresh_token = $response['refresh_token'];
        $user->save();
        return redirect('/dashboard')->with('success', 'Zoom connected successfully!');
    }

    // Step 3: Create meeting via API
    public function createMeeting(Request $request)
    {
        $user = Auth::user();

//        $response = Http::withToken($user->zoom_access_token)
//            ->post('https://api.zoom.us/v2/users/me/meetings', [
//                'topic' => $request->topic ?? 'Live Class',
//                'type' => 2,
//                'start_time' => $request->start_time, // ISO 8601 format
//                'duration' => $request->duration ?? 60,
//                'timezone' => 'Asia/Dhaka',
//                'settings' => [
//                    'join_before_host' => true,
//                    'participant_video' => true,
//                    'host_video' => true,
//                    'mute_upon_entry' => true,
//                ],
//            ])->json();

        // ধরি, আপনার ডাটাবেস থেকে এই ইউজারদের লিস্ট পেয়েছেন
// প্রতিটি ইউজারের email এবং name লাগবে
        $allowedUsers = [
            ['email' => 'student1@gmail.com', 'name' => 'Student One'],
            ['email' => 'student2@gmail.com', 'name' => 'Student Two'],
        ];

        $response = Http::withToken($user->zoom_access_token)
            ->post('https://api.zoom.us/v2/users/me/meetings', [
                'topic' => 'Live Class',
                'type' => 1,
                'start_time' => now()->addMinutes(10)->toIso8601String(),
                'duration' => 60,
                'settings' => [
                    'join_before_host' => false,

                    'meeting_authentication' => true,
                    'authentication_domains' => "mdeahiamondal@gmail.com",

//                    'authentication_option' => [
//                        'type' => 2
//                    ],

                    'waiting_room' => false
                ],
            ]);
        dd($response->json());
        return response()->json($response);
    }
}
