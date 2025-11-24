<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class CheckAdminHierarchy
{
    /**
     * Handle an incoming request.
     *
     * Validates that the authenticated admin has sufficient hierarchy level
     * to perform actions on target admins based on role hierarchy.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Must be authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to continue');
        }

        // Must be an admin
        if (!$user->is_admin) {
            abort(403, 'Access denied. Admin privileges required.');
        }

        // Top super admin bypasses all checks
        if ($user->isTopSuperAdmin()) {
            return $next($request);
        }

        // If the request has a target admin ID (e.g., for edit/delete actions)
        $targetAdminId = $request->route('id') ?? $request->input('admin_id');

        if ($targetAdminId) {
            $targetAdmin = User::find($targetAdminId);

            if ($targetAdmin) {
                // Prevent actions on top super admin
                if ($targetAdmin->isTopSuperAdmin()) {
                    return redirect()->back()->with('error', 'Cannot modify the top super admin');
                }

                // Check hierarchy
                if (!$user->canManageAdmin($targetAdmin)) {
                    return redirect()->back()->with('error', 'You do not have permission to manage this admin');
                }
            }
        }

        return $next($request);
    }
}
