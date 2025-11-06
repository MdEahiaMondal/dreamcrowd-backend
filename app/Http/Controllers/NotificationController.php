<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Admin can see all notifications, others only see their own
        if ($user->role === 2) {
            $query = Notification::with('user')->orderBy('created_at', 'desc');
        } else {
            $query = Notification::where('user_id', $user->id)
                ->orderBy('created_at', 'desc');
        }

        // Apply filters if provided
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('is_read')) {
            $query->where('is_read', $request->is_read);
        }

        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $notifications = $query->paginate(20);

        return response()->json($notifications);
    }

    public function unreadCount()
    {
        $count = Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', auth()->id())
            ->findOrFail($id);

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        $notification = Notification::where('user_id', auth()->id())
            ->findOrFail($id);

        $notification->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Admin notification page
     * Shows ALL notifications in the system
     */
    public function adminIndex()
    {
        if (auth()->user()->role !== 2) {
            abort(403, 'Unauthorized');
        }

        return view('Admin-Dashboard.notification');
    }

    /**
     * Teacher notification page
     * Shows only teacher's own notifications
     */
    public function teacherIndex()
    {
        if (auth()->user()->role !== 1) {
            abort(403, 'Unauthorized');
        }

        return view('Teacher-Dashboard.notification');
    }

    /**
     * User notification page
     * Shows only user's own notifications
     */
    public function userIndex()
    {
        if (auth()->user()->role !== 0) {
            abort(403, 'Unauthorized');
        }

        return view('User-Dashboard.notification');
    }
}
