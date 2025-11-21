<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\NotificationService;


class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notification)
    {
        // Laravel automatically inject করবে
        $this->notificationService = $notification;
    }
    public function index(Request $request)
    {
        $user = auth()->user();
        $users = [];
        $statistics = [];

        // Admin can see all notifications, others only see their own
        if ($user->role === 2) {
            $users = User::whereNot('role', 2)
                ->select('id', 'first_name', 'last_name', 'email', 'role')
                ->get();
            $query = Notification::with([
                'user:id,first_name,last_name,email',
                'actor:id,first_name,last_name,email',
                'target:id,first_name,last_name,email',
                'order:id',
                'service:id,title',
                'sentByAdmin:id,first_name,last_name'
            ])->orderBy('created_at', 'desc');

            // Calculate statistics for admin
            $statistics = [
                'total' => Notification::count(),
                'unread' => Notification::where('is_read', false)->count(),
                'emergency' => Notification::where('is_emergency', true)->count(),
                'today' => Notification::whereDate('created_at', today())->count(),
                'this_week' => Notification::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
                'email_sent' => Notification::where('sent_email', true)->count(),
            ];
        } else {
            $query = Notification::where('user_id', $user->id)
                ->with([
                    'actor:id,first_name,last_name',
                    'target:id,first_name,last_name',
                    'order:id',
                    'service:id,title'
                ])
                ->orderBy('created_at', 'desc');

            // Calculate statistics for regular users
            $statistics = [
                'total' => Notification::where('user_id', $user->id)->count(),
                'unread' => Notification::where('user_id', $user->id)->where('is_read', false)->count(),
                'emergency' => Notification::where('user_id', $user->id)->where('is_emergency', true)->count(),
                'today' => Notification::where('user_id', $user->id)->whereDate('created_at', today())->count(),
                'this_week' => Notification::where('user_id', $user->id)->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
                'email_sent' => Notification::where('user_id', $user->id)->where('sent_email', true)->count(),
            ];
        }

        // Apply filters if provided
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('is_read')) {
            $query->where('is_read', $request->is_read);
        }

        if ($request->has('is_emergency')) {
            $query->where('is_emergency', $request->is_emergency);
        }

        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $notifications = $query->paginate(20);

        return response()->json([
            'notifications' => $notifications,
            'users' => $users,
            'statistics' => $statistics
        ]);
    }

    public function notificationSend(Request $request)
    {
        // Validate request (English only)
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'targetUser' => 'required|in:all,seller,buyer,specific',
            'user_ids' => 'required_if:targetUser,specific|array',
            'user_ids.*' => 'exists:users,id',
            'is_emergency' => 'boolean',
            'send_email' => 'boolean',
        ], [
            'title.required' => 'Title is required',
            'message.required' => 'Message is required',
            'targetUser.required' => 'Target audience is required',
        ]);

        // Determine target user IDs
        $targetUser = $request->input('targetUser');
        $userIds = [];

        switch ($targetUser) {
            case 'all':
                $userIds = User::whereNot('role', 2)->pluck('id')->toArray();
                break;
            case 'seller':
                $userIds = User::where('role', 1)->pluck('id')->toArray();
                break;
            case 'buyer':
                $userIds = User::where('role', 0)->pluck('id')->toArray();
                break;
            case 'specific':
                $userIds = $request->input('user_ids', []);
                break;
        }

        // Ensure we have users
        if (empty($userIds)) {
            return response()->json([
                'success' => false,
                'message' => 'No recipients found'
            ], 422);
        }

        // Get values
        $title = $request->input('title');
        $message = $request->input('message');
        $isEmergency = $request->input('is_emergency', false);
        $sendEmail = $request->input('send_email', true);

        // Send notifications
        $this->notificationService->sendToMultipleUsers(
            userIds: $userIds,
            type: 'admin_broadcast',
            title: $title,
            message: $message,
            data: [
                'sent_by' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
                'target_audience' => $targetUser,
                'recipient_count' => count($userIds)
            ],
            sendEmail: $sendEmail,
            actorUserId: auth()->id(),
            targetUserId: null,
            orderId: null,
            serviceId: null,
            isEmergency: $isEmergency,
            sentByAdminId: auth()->id()
        );

        return response()->json([
            'success' => true,
            'message' => 'Notification sent successfully',
            'recipient_count' => count($userIds)
        ]);
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
        // For admin: can only mark as read notifications sent to them
        $notification = Notification::where('user_id', auth()->id())
            ->findOrFail($id);

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read'
        ]);
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
        // For admin: can only delete notifications sent to them
        $notification = Notification::where('user_id', auth()->id())
            ->findOrFail($id);

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted successfully'
        ]);
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

    /**
     * Search users by email or name (AJAX endpoint for Select2)
     * Returns users matching the search query
     */
    public function searchUsers(Request $request)
    {
        if (auth()->user()->role !== 2) {
            abort(403, 'Unauthorized');
        }

        $search = $request->input('q', '');
        $role = $request->input('role', null); // Optional: filter by role

        $query = User::whereNot('role', 2) // Exclude admins
            ->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ["%{$search}%"])
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            });

        // Filter by role if specified
        if ($role !== null && in_array($role, [0, 1])) {
            $query->where('role', $role);
        }

        $users = $query->select('id', 'first_name', 'last_name', 'email', 'role')
            ->limit(20)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'text' => trim($user->first_name . ' ' . $user->last_name) . ' (' . $user->email . ')',
                    'email' => $user->email,
                    'name' => trim($user->first_name . ' ' . $user->last_name),
                    'role' => $user->role == 1 ? 'Seller' : 'Buyer'
                ];
            });

        return response()->json(['results' => $users]);
    }

    /**
     * Count recipients based on target audience selection
     * Used for live preview of how many users will receive notification
     */
    public function countRecipients(Request $request)
    {
        if (auth()->user()->role !== 2) {
            abort(403, 'Unauthorized');
        }

        $targetUser = $request->input('targetUser');
        $userIds = $request->input('user_ids', []);

        $count = 0;

        switch ($targetUser) {
            case 'all':
                $count = User::whereNot('role', 2)->count();
                break;
            case 'seller':
                $count = User::where('role', 1)->count();
                break;
            case 'buyer':
                $count = User::where('role', 0)->count();
                break;
            case 'specific':
                $count = count($userIds);
                break;
        }

        return response()->json([
            'count' => $count,
            'message' => "This notification will be sent to {$count} user(s)"
        ]);
    }
}