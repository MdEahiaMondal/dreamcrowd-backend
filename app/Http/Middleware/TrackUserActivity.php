<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Update last activity timestamp for authenticated users
        if (auth()->check()) {
            $user = auth()->user();

            // Only update if last_active_at is null or more than 5 minutes old
            // This prevents too many database writes
            if (!$user->last_active_at || $user->last_active_at->diffInMinutes(now()) >= 5) {
                $user->updateLastActivity();
            }
        }

        return $next($request);
    }
}
