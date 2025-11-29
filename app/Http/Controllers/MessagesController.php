<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatList;
use App\Models\ChatNotes;
use App\Models\Message;
use App\Models\TeacherGig;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Services\MessageService;
use App\Mail\CustomOfferSent;
use App\Mail\CustomOfferAccepted;
use App\Mail\CustomOfferRejected;


class MessagesController extends Controller
{
    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        // Laravel automatically inject করবে
        $this->messageService = $messageService;
    }

    public function getUnreadMessageCount($userId)
    {
        info($userId);
        // Count unread messages for the given user ID
        $unreadCount = Chat::where('receiver_id', $userId)
            ->where('status', 0)
            ->count();

        return response()->json(['count' => $unreadCount]);
    }

    public function UserMessagesHome()
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->to('/')->with('error', 'Please login to your account!');
        }

        // Ensure the user is a role 0 user
        if (Auth::user()->role != 0) {
            return redirect()->to('/');
        }


        // Get authenticated user's ID
        $userId = Auth::id();


        // Fetch Chat List --------Start

        $chatList = ChatList::where('user', $userId) // Fetch only where user is the authenticated user
            ->orderBy('updated_at', 'desc') // Sort by last message update time
            ->get()
            ->map(function ($chat) use ($userId) {
                // Check if this chat is with an Admin
                if ($chat->admin == 1) {
                    $teacherName = 'Admin';
                    $profileImage = asset('assets/profile/avatars/(A).jpg'); // Set an admin avatar

                    // Count unseen messages from Admin (sender_role = 2)
                    $unseenCount = Chat::where('sender_role', 2)
                        ->where('receiver_id', $userId)
                        ->where('status', 0)
                        ->count();
                    $teacher_id = 'A';
                } else {
                    $teacher_id = $chat->teacher;
                    // Otherwise, fetch teacher details
                    $teacher = User::find($chat->teacher);
                    $teacherName = $teacher
                        ? $teacher->first_name . ' ' . ucfirst(substr($teacher->last_name, 0, 1)) . ''
                        : 'Unknown';
                    $profileImage = $teacher && $teacher->profile
                        ? asset('assets/profile/img/' . $teacher->profile)
                        : ($teacher
                            ? asset('assets/profile/avatars/(' . ucfirst(substr($teacher->first_name, 0, 1)) . ').jpg')
                            : asset('assets/profile/avatars/(U).jpg'));

                    // Count unseen messages from the Teacher
                    $unseenCount = Chat::where('sender_id', $chat->teacher)
                        ->where('receiver_id', $userId)
                        ->where('status', 0)
                        ->count();
                }

                return [
                    'teacher_id' => $teacher_id, // Teacher ID (or null if admin)
                    'teacher_name' => $teacherName,
                    'profile_image' => $profileImage,
                    'latest_sms' => $chat->sms
                        ? Str::limit($chat->sms, 15, '...')
                        : 'No messages yet',
                    'time' => Carbon::parse($chat->updated_at)->diffForHumans(), // Time from last update
                    'unseen_count' => $unseenCount,
                ];
            })
            ->values();


        // Fetch Chat List --------------END


        // Get the first chat record for the user
        $firstChat = ChatList::where('user', $userId)
            ->orderBy('updated_at', 'desc')
            ->first();


        if ($firstChat) {
            $block = $firstChat->block;
            $block_by = $firstChat->block_by;
            if ($firstChat->admin == 1) {
                // Chat with Admin
                $otheruserId = 'A'; // Admin Identifier
                $userRole = 0; // Authenticated user role
                $otheruserRole = 2; // Admin role

                $fullName = 'Admin';
                $profileImageMain = asset('assets/profile/avatars/(A).jpg'); // Set an admin avatar

                // Fetch chat where receiver_role is Admin (2) and Auth user is involved
                $completeChat = Chat::where(function ($query) use ($userId) {
                    $query->where(function ($subQuery) use ($userId) {
                        $subQuery->where('receiver_role', 2) // Admin role
                            ->where('sender_id', $userId); // Auth user as sender
                    })->orWhere(function ($subQuery) use ($userId) {
                        $subQuery->where('sender_role', 2) // Admin as sender
                            ->where('receiver_id', $userId); // Auth user as receiver
                    });
                })
                    ->latest()
                    ->limit(50 + 1) // Limit to 50 messages
                    ->get();
            } else {
                // Chat with Teacher
                $otheruserId = $firstChat->teacher;
                $userRole = 0; // Authenticated user role
                $otheruserRole = 1; // Teacher role

                $user = User::find($otheruserId);


                $fullName = $user
                    ? $user->first_name . ' ' . ucfirst(substr($user->last_name, 0, 1))
                    : 'Unknown User';

                $profileImageMain = $user && $user->profile
                    ? asset('assets/profile/img/' . $user->profile)
                    : ($user
                        ? asset('assets/profile/avatars/(' . ucfirst(substr($user->first_name, 0, 1)) . ').jpg')
                        : asset('assets/profile/avatars/(U).jpg'));


                $completeChat = Chat::where(function ($query) use ($userId, $otheruserId, $userRole, $otheruserRole) {
                    $query->where(function ($subQuery) use ($userId, $otheruserId, $userRole, $otheruserRole) {
                        $subQuery->where('sender_id', $userId)
                            ->where('receiver_id', $otheruserId)
                            ->where('sender_role', $userRole)
                            ->where('receiver_role', $otheruserRole);
                    })->orWhere(function ($subQuery) use ($userId, $otheruserId, $userRole, $otheruserRole) {
                        $subQuery->where('sender_id', $otheruserId)
                            ->where('receiver_id', $userId)
                            ->where('sender_role', $otheruserRole)
                            ->where('receiver_role', $userRole);
                    });
                })
                    ->latest()
                    ->limit(50 + 1) // Limit to 50 messages
                    ->get();
            }


            // Check if there are more messages beyond the limit
            $hasMore = $completeChat->count() > 50;

            // Remove the extra message (keep only $sms_limit messages)
            $completeChat = $completeChat->take(50)->sortBy('created_at')->values();

            // Format the chat messages
            $completeChat = $completeChat->map(function ($chat) {
                return [
                    'chat_id' => $chat->id,
                    'sender_id' => $chat->sender_id,
                    'receiver_id' => $chat->receiver_id,
                    'sms' => $chat->sms,
                    'files' => $chat->files,
                    'created_at' => $chat->created_at->toDateTimeString(),
                    'time_ago' => $chat->created_at->diffForHumans(), // Relative time like '5 minutes ago'
                ];
            });


            // Full Chat Status change --------- Start
            foreach ($completeChat as $key => $value) {
                $up_chat = Chat::where(['id' => $value['chat_id'], 'receiver_id' => Auth::user()->id, 'status' => 0])->first();
                if ($up_chat) {
                    $up_chat->status = 1;
                    $up_chat->update();
                }
            }
            // Full Chat Status change --------- END

        } else {
            $completeChat = []; // No chat records found
            $profileImageMain = '';
            $fullName = '';
            $block = '';
            $block_by = '';
            $otheruserId = '';
            $hasMore = 0;
        };


        // Fetch First Complete Chat ------------------- END


        // Return the view with the chat list
        return view("User-Dashboard.messages", compact(
            'chatList',
            'completeChat',
            'profileImageMain',
            'fullName',
            'otheruserId',
            'block',
            'block_by',
            'hasMore'
        ));
    }


    // Fetch Messages By Ajax Function Start ========
    public function FetchMessages(Request $request)
    {

        // Get authenticated user's ID
        $userId = $request->sender_id;
        $userRole = $request->sender_role;
        $otheruserId = $request->reciver_id;
        // If the ID is "A", it's an Admin (role = 2), otherwise it's a regular user (role = 1)
        $otheruserRole = ($otheruserId === 'A') ? 2 : 1;
        $searchName = $request->search_name; // Get the search name from request


        // Fetch Chat List --------Start

        $Chatlist = ChatList::where('user', $userId) // Fetch only where user is the authenticated user
            ->orderBy('updated_at', 'desc') // Sort by last message update time
            ->get()
            ->map(function ($chat) use ($userId) {
                // Check if this chat is with an Admin
                if ($chat->admin == 1) {
                    $teacherName = 'Admin';
                    $profileImage = asset('assets/profile/avatars/(A).jpg'); // Set an admin avatar

                    // Count unseen messages from Admin (sender_role = 2)
                    $unseenCount = Chat::where('sender_role', 2)
                        ->where('receiver_id', $userId)
                        ->where('status', 0)
                        ->count();
                    $teacher_id = 'A';
                } else {
                    $teacher_id = $chat->teacher;
                    // Otherwise, fetch teacher details
                    $teacher = User::find($chat->teacher);
                    $teacherName = $teacher
                        ? $teacher->first_name . ' ' . ucfirst(substr($teacher->last_name, 0, 1)) . ''
                        : 'Unknown';
                    $profileImage = $teacher && $teacher->profile
                        ? asset('assets/profile/img/' . $teacher->profile)
                        : ($teacher
                            ? asset('assets/profile/avatars/(' . ucfirst(substr($teacher->first_name, 0, 1)) . ').jpg')
                            : asset('assets/profile/avatars/(U).jpg'));

                    // Count unseen messages from the Teacher
                    $unseenCount = Chat::where('sender_id', $chat->teacher)
                        ->where('receiver_id', $userId)
                        ->where('status', 0)
                        ->count();
                }

                return [
                    'teacher_id' => $teacher_id, // Teacher ID (or null if admin)
                    'teacher_name' => $teacherName,
                    'profile_image' => $profileImage,
                    'latest_sms' => $chat->sms
                        ? Str::limit($chat->sms, 15, '...')
                        : 'No messages yet',
                    'time' => Carbon::parse($chat->updated_at)->diffForHumans(), // Time from last update
                    'unseen_count' => $unseenCount,
                ];
            })
            ->filter(function ($chat) use ($searchName) {
                // If search_name is provided, filter records that contain the search term in teacher_name
                return empty($searchName) || stripos($chat['teacher_name'], $searchName) !== false;
            })
            ->values();

        $response['chatList'] = $Chatlist;

        // Fetch Chat List --------------END

        // Fetch Chat Status Block List --------------Start
        $usertype = ($otheruserRole === 2) ? 'admin' : (($otheruserRole === 1) ? 'teacher' : 'user');
        $usertypevalue = ($otheruserRole == 2) ? 1 : $otheruserId;
        $authusertypevalue = (Auth::user()->role === 2) ? 'admin' : ((Auth::user()->role === 1) ? 'teacher' : 'user');

        $firstChat = ChatList::where([$usertype => $usertypevalue, $authusertypevalue => Auth::user()->id])->first();

        // FIX LOG-2: Add null check and create ChatList if doesn't exist
        if ($firstChat) {
            $block = $firstChat->block;
            $block_by = $firstChat->block_by;
        } else {
            // Create new chat list for first-time conversation
            $firstChat = ChatList::create([
                $usertype => $usertypevalue,
                $authusertypevalue => Auth::user()->id,
                'block' => 0,
                'block_by' => null
            ]);
            $block = 0;
            $block_by = null;
        }
        $response['block'] = $block;
        $response['block_by'] = $block_by;
        // Fetch Chat Status Block List --------------END


        // Fetch First Person Complete Chat ------------ Start

        if ($otheruserRole == 2) {
            // Chat with Admin

            $fullName = 'Admin';
            $profileName = null;
            $profileImageMain = asset('assets/profile/avatars/(A).jpg'); // Set an admin avatar

            // Fetch chat where receiver_role is Admin (2) and Auth user is involved
            $completeChat = Chat::where(function ($query) use ($userId) {
                $query->where(function ($subQuery) use ($userId) {
                    $subQuery->where('receiver_role', 2) // Admin role
                        ->where('sender_id', $userId); // Auth user as sender
                })->orWhere(function ($subQuery) use ($userId) {
                    $subQuery->where('sender_role', 2) // Admin as sender
                        ->where('receiver_id', $userId); // Auth user as receiver
                });
            })
                ->latest()
                ->limit($request->sms_limit + 1) // Limit to 50 messages
                ->get();
        } else {


            $user = User::find($otheruserId);

            $fullName = $user
                ? $user->first_name . ' ' . ucfirst(substr($user->last_name, 0, 1))
                : 'Unknown User';
            $profileName = $user ? $user->first_name . $user->last_name : 'Unknown';
            $profileImageMain = $user && $user->profile
                ? asset('assets/profile/img/' . $user->profile)
                : ($user
                    ? asset('assets/profile/avatars/(' . ucfirst(substr($user->first_name, 0, 1)) . ').jpg')
                    : asset('assets/profile/avatars/(U).jpg'));


            $completeChat = Chat::where(function ($query) use ($userId, $otheruserId, $userRole, $otheruserRole) {
                $query->where(function ($subQuery) use ($userId, $otheruserId, $userRole, $otheruserRole) {
                    $subQuery->where('sender_id', $userId)
                        ->where('receiver_id', $otheruserId)
                        ->where('sender_role', $userRole)
                        ->where('receiver_role', $otheruserRole);
                })->orWhere(function ($subQuery) use ($userId, $otheruserId, $userRole, $otheruserRole) {
                    $subQuery->where('sender_id', $otheruserId)
                        ->where('receiver_id', $userId)
                        ->where('sender_role', $otheruserRole)
                        ->where('receiver_role', $userRole);
                });
            })
                ->latest()
                ->limit($request->sms_limit + 1) // Limit to 50 messages
                ->get();
        }


        // Check if there are more messages beyond the limit
        $hasMore = $completeChat->count() > $request->sms_limit;

        // Remove the extra message (keep only $sms_limit messages)
        $completeChat = $completeChat->take($request->sms_limit)->sortBy('created_at')->values();


        // Format the chat messages
        $completeChat = $completeChat->map(function ($chat) {
            return [
                'chat_id' => $chat->id,
                'sender_id' => $chat->sender_id,
                'receiver_id' => $chat->receiver_id,
                'sms' => $chat->sms,
                'files' => $chat->files,
                'created_at' => $chat->created_at->toDateTimeString(),
                'time_ago' => $chat->created_at->diffForHumans(), // Relative time like '5 minutes ago'
            ];
        });


        // Full Chat Status change --------- Start
        foreach ($completeChat as $key => $value) {
            $up_chat = Chat::where(['id' => $value['chat_id'], 'receiver_id' => Auth::user()->id, 'status' => 0])->first();
            if ($up_chat) {
                $up_chat->status = 1;
                $up_chat->update();
            }
        }
        // Full Chat Status change --------- END

        $response['completeChat'] = $completeChat;
        $response['hasMore'] = $hasMore;
        $response['profileImageMain'] = $profileImageMain;
        $response['fullName'] = $fullName;
        $response['profileName'] = $profileName;
        $response['OtherUserId'] = $otheruserId;


        // Fetch First Complete Chat ------------------- END

        $notes = ChatNotes::where(['user_id' => Auth::user()->id, 'other_id' => $otheruserId])->get();
        $response['notes'] = $notes;

        return response()->json($response);
    }
    // Fetch Messages By Ajax Function END ========

    // Send Single Message Function Ajax Start ====

    public function SendSMSSingle(Request $request)
    {

        if (!Auth::user()) {
            return response()->json(['error' => 'Please LoginIn to Your Account!']);
        }

        $fileNames = [];
        $senderId = $request->sender_id; // The ID of the sender
        $senderRole = $request->sender_role; // The ID of the sender
        $receiverId = $request->reciver_id; // The ID of the receiver
        $receiverRole = $request->reciver_role;
        $uploadedFiles = $request->file('files');

        if ($uploadedFiles) {
            foreach ($request->file('files') as $file) {

                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path() . '/assets/chat_media/' . $senderId . '_chat_files_' . $receiverId . '', $fileName);
                $fileNames[] = $fileName;
            }
        }

        // Determine column and values
        $column_reciver = ($receiverRole == 0) ? 'user' : (($receiverRole == 1) ? 'teacher' : 'admin');
        $column_sender = ($senderRole == 0) ? 'user' : (($senderRole == 1) ? 'teacher' : 'admin');

        $receiverValue = ($receiverRole == 0) ? 0 : (($senderRole == 1) ? 0 : 1);
        $type = ($receiverRole == 2) ? 1 : 0; // 0 for teacher, 1 for admin
        $sms = $request->sms ?? 'Files'; // Use null coalescing operator for cleaner code

        $havelist = ChatList::where([$column_reciver => $receiverId, $column_sender => $senderId, 'admin' => 0, 'type' => $type])->first();


        $havelist ? $havelist->update(['sms' => $sms]) : ChatList::create([$column_reciver => $receiverId, $column_sender => $senderId, 'admin' => 0, 'type' => $type, 'sms' => $sms]);


        $chat = new Chat();
        $chat->sender_id = $request->sender_id;
        $chat->receiver_id = $request->reciver_id;
        $chat->type = $request->type;
        $chat->sender_role = $senderRole;
        $chat->receiver_role = $receiverRole;
        if ($request->sms == null) {
            $chat->sms = 'Files';
        } else {
            $chat->sms = $request->sms;
        }
        $chat->files = implode(',', $fileNames);
        $chat->save();

        // Send notification to receiver
        $sender = User::find($chat->sender_id);
        $senderName = $sender ? $sender->first_name . ' ' . $sender->last_name : 'Someone';
        $messagePreview = Str::limit($chat->sms, 50);

        app(\App\Services\NotificationService::class)->send(
            userId: $chat->receiver_id,
            type: 'message',
            title: 'New Message from ' . $senderName,
            message: $messagePreview,
            data: ['chat_id' => $chat->id, 'sender_id' => $chat->sender_id],
            sendEmail: false
        );

        $response['chat'] = [
            'id' => $chat->id,
            'sender_id' => $chat->sender_id,
            'receiver_id' => $chat->receiver_id,
            'type' => $chat->type,
            'sender_role' => $chat->sender_role,
            'receiver_role' => $chat->receiver_role,
            'sms' => $chat->sms,
            'files' => $chat->files,
            'created_at' => $chat->created_at->toDateTimeString(),
            'time_ago' => $chat->created_at->diffForHumans(), // Add the time ago field
        ];


        return response()->json(['success' => 'Your Message Delivered Successfully!']);
    }

    // Send Single Message Function Ajax END ====
    // Send Message from Dashboard Function ====
    public function SendSMS(Request $request)
    {

        if (!Auth::user()) {
            return response()->json(['error' => 'Please LoginIn to Your Account!']);
        }

        $fileNames = [];
        $senderId = $request->sender_id; // The ID of the sender
        $senderRole = $request->sender_role; // The ID of the sender
        $receiverId = $request->reciver_id; // The ID of the receiver
        $receiverRole = ($receiverId === 'A') ? 2 : 1;
        $uploadedFiles = $request->file('files');

        if ($uploadedFiles) {
            foreach ($request->file('files') as $file) {

                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path() . '/assets/chat_media/' . $senderId . '_chat_files_' . $receiverId . '', $fileName);
                $fileNames[] = $fileName;
            }
        }

        // Determine column and values
        $column = ($receiverRole == 1) ? 'teacher' : 'admin';
        $receiverValue = ($receiverRole == 1) ? $receiverId : 1; // Admin is always 1
        $type = ($receiverRole == 1) ? 0 : 1; // 0 for teacher, 1 for admin
        $sms = $request->sms ?? 'Files'; // Use null coalescing operator for cleaner code

        $havelist = ChatList::where([$column => $receiverValue, 'user' => $senderId, 'type' => $type])->first();


        $havelist ? $havelist->update(['sms' => $sms]) : ChatList::create([$column => $receiverValue, 'user' => $senderId, 'type' => $type, 'sms' => $sms]);


        $chat = new Chat();
        $chat->sender_id = $request->sender_id;
        $chat->receiver_id = $request->reciver_id;
        $chat->type = 0;
        $chat->sender_role = 0;
        $chat->receiver_role = $receiverRole;
        if ($request->sms == null) {
            $chat->sms = 'Files';
        } else {
            $chat->sms = $request->sms;
        }
        $chat->files = implode(',', $fileNames);
        $chat->save();

        // Send notification to receiver
        $sender = User::find($chat->sender_id);
        $senderName = $sender ? $sender->first_name . ' ' . $sender->last_name : 'Someone';
        $messagePreview = Str::limit($chat->sms, 50);

        // Only send if receiver is not Admin (receiver_role != 2)
        if ($chat->receiver_role != 2) {
            app(\App\Services\NotificationService::class)->send(
                userId: $chat->receiver_id,
                type: 'message',
                title: 'New Message from ' . $senderName,
                message: $messagePreview,
                data: ['chat_id' => $chat->id, 'sender_id' => $chat->sender_id],
                sendEmail: false
            );
        }

        $response['chat'] = [
            'id' => $chat->id,
            'sender_id' => $chat->sender_id,
            'receiver_id' => $chat->receiver_id,
            'type' => $chat->type,
            'sender_role' => $chat->sender_role,
            'receiver_role' => $chat->receiver_role,
            'sms' => $chat->sms,
            'files' => $chat->files,
            'created_at' => $chat->created_at->toDateTimeString(),
            'time_ago' => $chat->created_at->diffForHumans(), // Add the time ago field
        ];


        return response()->json(['success' => 'Your Message Delivered Successfuly!']);
    }


    // Send Message from Dashboard Function ====
    public function SendMessage(Request $request)
    {

        if (!Auth::user()) {
            return response()->json(['error' => 'Please LoginIn to Your Account!']);
        }

        $fileNames = [];
        $senderId = $request->sender_id; // The ID of the sender
        $senderRole = $request->sender_role; // The ID of the sender
        $receiverId = $request->reciver_id; // The ID of the receiver
        $receiverRole = ($receiverId === 'A') ? 2 : 1;
        $uploadedFiles = $request->file('files');

        if ($uploadedFiles) {
            foreach ($request->file('files') as $file) {

                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path() . '/assets/chat_media/' . $senderId . '_chat_files_' . $receiverId . '', $fileName);
                $fileNames[] = $fileName;
            }
        }

        // Determine column and values
        $column = ($receiverRole == 1) ? 'teacher' : 'admin';
        $receiverValue = ($receiverRole == 1) ? $receiverId : 1; // Admin is always 1
        $type = ($receiverRole == 1) ? 0 : 1; // 0 for teacher, 1 for admin
        $sms = $request->sms ?? 'Files'; // Use null coalescing operator for cleaner code

        $havelist = ChatList::where([$column => $receiverValue, 'user' => $senderId, 'type' => $type])->first();


        $havelist ? $havelist->update(['sms' => $sms]) : ChatList::create([$column => $receiverValue, 'user' => $senderId, 'type' => $type, 'sms' => $sms]);


        $chat = new Chat();
        $chat->sender_id = $request->sender_id;
        $chat->receiver_id = $request->reciver_id;
        $chat->type = 0;
        $chat->sender_role = 0;
        $chat->receiver_role = $receiverRole;
        if ($request->sms == null) {
            $chat->sms = 'Files';
        } else {
            $chat->sms = $request->sms;
        }
        $chat->files = implode(',', $fileNames);
        $chat->save();


        $response['chat'] = [
            'id' => $chat->id,
            'sender_id' => $chat->sender_id,
            'receiver_id' => $chat->receiver_id,
            'type' => $chat->type,
            'sender_role' => $chat->sender_role,
            'receiver_role' => $chat->receiver_role,
            'sms' => $chat->sms,
            'files' => $chat->files,
            'created_at' => $chat->created_at->toDateTimeString(),
            'time_ago' => $chat->created_at->diffForHumans(), // Add the time ago field
        ];


        $this->messageService->send(
            userId: $request->reciver_id,
            count: 1,
            message: ''
        );
        
        return response()->json($response);
    }


    // Open Chat Function =====
    public function OpenChat(Request $request)
    {

        $userId = Auth::user()->id; // Authenticated user ID
        $userRole = Auth::user()->role; // Authenticated user's role
        $otheruserId = $request->id; // The other user's ID
        // If the ID is "A", it's an Admin (role = 2), otherwise it's a regular user (role = 1)
        $otheruserRole = ($otheruserId === 'A') ? 2 : 1;


        // Fetch Chat Status Block List --------------Start
        $usertype = ($otheruserRole === 2) ? 'admin' : (($otheruserRole === 1) ? 'teacher' : 'user');
        $usertypevalue = ($otheruserRole == 2) ? 1 : $otheruserId;
        $authusertypevalue = (Auth::user()->role === 2) ? 'admin' : ((Auth::user()->role === 1) ? 'teacher' : 'user');

        $firstChat = ChatList::where([$usertype => $usertypevalue, $authusertypevalue => Auth::user()->id])->first();

        // FIX LOG-2: Add null check and create ChatList if doesn't exist
        if ($firstChat) {
            $block = $firstChat->block;
            $block_by = $firstChat->block_by;
        } else {
            // Create new chat list for first-time conversation
            $firstChat = ChatList::create([
                $usertype => $usertypevalue,
                $authusertypevalue => Auth::user()->id,
                'block' => 0,
                'block_by' => null
            ]);
            $block = 0;
            $block_by = null;
        }
        $response['block'] = $block;
        $response['block_by'] = $block_by;
        // Fetch Chat Status Block List --------------END


        // Fetch First Person Complete Chat ------------ Start


        if ($otheruserRole == 2) {
            // Chat with Admin

            $fullName = 'Admin';
            $profileName = null;
            $profileImageMain = asset('assets/profile/avatars/(A).jpg'); // Set an admin avatar

            // Fetch chat where receiver_role is Admin (2) and Auth user is involved
            $completeChat = Chat::where(function ($query) use ($userId) {
                $query->where(function ($subQuery) use ($userId) {
                    $subQuery->where('receiver_role', 2) // Admin role
                        ->where('sender_id', $userId); // Auth user as sender
                })->orWhere(function ($subQuery) use ($userId) {
                    $subQuery->where('sender_role', 2) // Admin as sender
                        ->where('receiver_id', $userId); // Auth user as receiver
                });
            })
                ->latest()
                ->limit(50 + 1) // Limit to 50 messages
                ->get();
        } else {


            $user = User::find($otheruserId);

            $fullName = $user
                ? $user->first_name . ' ' . ucfirst(substr($user->last_name, 0, 1))
                : 'Unknown User';
            $profileName = $user ? $user->first_name . $user->last_name : 'Unknown';
            $profileImageMain = $user && $user->profile
                ? asset('assets/profile/img/' . $user->profile)
                : ($user
                    ? asset('assets/profile/avatars/(' . ucfirst(substr($user->first_name, 0, 1)) . ').jpg')
                    : asset('assets/profile/avatars/(U).jpg'));


            $completeChat = Chat::where(function ($query) use ($userId, $otheruserId, $userRole, $otheruserRole) {
                $query->where(function ($subQuery) use ($userId, $otheruserId, $userRole, $otheruserRole) {
                    $subQuery->where('sender_id', $userId)
                        ->where('receiver_id', $otheruserId)
                        ->where('sender_role', $userRole)
                        ->where('receiver_role', $otheruserRole);
                })->orWhere(function ($subQuery) use ($userId, $otheruserId, $userRole, $otheruserRole) {
                    $subQuery->where('sender_id', $otheruserId)
                        ->where('receiver_id', $userId)
                        ->where('sender_role', $otheruserRole)
                        ->where('receiver_role', $userRole);
                });
            })
                ->latest()
                ->limit(50 + 1) // Limit to 50 messages
                ->get();
        }

        // Check if there are more messages beyond the limit
        $hasMore = $completeChat->count() > 50;

        // Remove the extra message (keep only $sms_limit messages)
        $completeChat = $completeChat->take(50)->sortBy('created_at')->values();


        // Format the chat messages
        $completeChat = $completeChat->map(function ($chat) {
            return [
                'chat_id' => $chat->id,
                'sender_id' => $chat->sender_id,
                'receiver_id' => $chat->receiver_id,
                'sms' => $chat->sms,
                'files' => $chat->files,
                'created_at' => $chat->created_at->toDateTimeString(),
                'time_ago' => $chat->created_at->diffForHumans(), // Relative time like '5 minutes ago'
            ];
        });


        // Full Chat Status change --------- Start
        foreach ($completeChat as $key => $value) {
            $up_chat = Chat::where(['id' => $value['chat_id'], 'receiver_id' => Auth::user()->id, 'status' => 0])->first();
            if ($up_chat) {
                $up_chat->status = 1;
                $up_chat->update();
            }
        }
        // Full Chat Status change --------- END


        $response['hasMore'] = $hasMore;
        $response['completeChat'] = $completeChat;
        $response['profileImageMain'] = $profileImageMain;
        $response['fullName'] = $fullName;
        $response['profileName'] = $profileName;
        $response['OtherUserId'] = $otheruserId;


        // Fetch First Complete Chat ------------------- END

        $notes = ChatNotes::where(['user_id' => Auth::user()->id, 'other_id' => $otheruserId])->get();
        $response['notes'] = $notes;

        return response()->json($response);
    }


    // User Chat All Functions END =======================


    // Teacher Chat All Functions Start =======================


    public function TeacherMessagesHome()
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->to('/')->with('error', 'Please login to your account!');
        }

        // Ensure the user is a role 0 user
        if (Auth::user()->role != 1) {
            return redirect()->to('/');
        }


        // Get authenticated user's ID
        $userId = Auth::id();


        // Fetch Chat List --------Start

        $chatList = ChatList::where('teacher', $userId) // Fetch only where user is the authenticated user
            ->orderBy('updated_at', 'desc') // Sort by last message update time
            ->get()
            ->map(function ($chat) use ($userId) {
                // Check if this chat is with an Admin
                if ($chat->admin == 1) {
                    $teacherName = 'Admin';
                    $profileImage = asset('assets/profile/avatars/(A).jpg'); // Set an admin avatar

                    // Count unseen messages from Admin (sender_role = 2)
                    $unseenCount = Chat::where('sender_role', 2)
                        ->where('receiver_id', $userId)
                        ->where('status', 0)
                        ->count();
                    $teacher_id = 'A';
                } else {
                    $teacher_id = $chat->user;
                    // Otherwise, fetch teacher details
                    $teacher = User::find($chat->user);
                    $teacherName = $teacher
                        ? $teacher->first_name . ' ' . ucfirst(substr($teacher->last_name, 0, 1)) . ''
                        : 'Unknown';
                    $profileImage = $teacher && $teacher->profile
                        ? asset('assets/profile/img/' . $teacher->profile)
                        : ($teacher
                            ? asset('assets/profile/avatars/(' . ucfirst(substr($teacher->first_name, 0, 1)) . ').jpg')
                            : asset('assets/profile/avatars/(U).jpg'));

                    // Count unseen messages from the Teacher
                    $unseenCount = Chat::where('sender_id', $chat->user)
                        ->where('receiver_id', $userId)
                        ->where('status', 0)
                        ->count();
                }

                return [
                    'teacher_id' => $teacher_id, // Teacher ID (or null if admin)
                    'teacher_name' => $teacherName,
                    'profile_image' => $profileImage,
                    'latest_sms' => $chat->sms
                        ? Str::limit($chat->sms, 15, '...')
                        : 'No messages yet',
                    'time' => Carbon::parse($chat->updated_at)->diffForHumans(), // Time from last update
                    'unseen_count' => $unseenCount,
                ];
            })
            ->values();


        // Fetch Chat List --------------END


        // Get the first chat record for the user
        $firstChat = ChatList::where('teacher', $userId)
            ->orderBy('updated_at', 'desc')
            ->first();


        if ($firstChat) {
            $block = $firstChat->block;
            $block_by = $firstChat->block_by;
            if ($firstChat->admin == 1) {
                // Chat with Admin
                $otheruserId = 'A'; // Admin Identifier
                $userRole = 1; // Authenticated user role
                $otheruserRole = 2; // Admin role

                $fullName = 'Admin';
                $profileImageMain = asset('assets/profile/avatars/(A).jpg'); // Set an admin avatar

                // Fetch chat where receiver_role is Admin (2) and Auth user is involved
                $completeChat = Chat::where(function ($query) use ($userId) {
                    $query->where(function ($subQuery) use ($userId) {
                        $subQuery->where('receiver_role', 2) // Admin role
                            ->where('sender_id', $userId); // Auth user as sender
                    })->orWhere(function ($subQuery) use ($userId) {
                        $subQuery->where('sender_role', 2) // Admin as sender
                            ->where('receiver_id', $userId); // Auth user as receiver
                    });
                })
                    ->latest()
                    ->limit(50 + 1) // Limit to 50 messages
                    ->get();
            } else {
                // Chat with Teacher
                $otheruserId = $firstChat->user;
                $userRole = 1; // Authenticated user role
                $otheruserRole = 0; // Teacher role

                $user = User::find($otheruserId);


                $fullName = $user
                ? $user->first_name . ' ' . ucfirst(substr($user->last_name, 0, 1))
                : 'Unknown User';

                $profileImageMain = $user && $user->profile
                    ? asset('assets/profile/img/' . $user->profile)
                    : ($user
                        ? asset('assets/profile/avatars/(' . ucfirst(substr($user->first_name, 0, 1)) . ').jpg')
                        : asset('assets/profile/avatars/(U).jpg'));


                $completeChat = Chat::where(function ($query) use ($userId, $otheruserId, $userRole, $otheruserRole) {
                    $query->where(function ($subQuery) use ($userId, $otheruserId, $userRole, $otheruserRole) {
                        $subQuery->where('sender_id', $userId)
                            ->where('receiver_id', $otheruserId)
                            ->where('sender_role', $userRole)
                            ->where('receiver_role', $otheruserRole);
                    })->orWhere(function ($subQuery) use ($userId, $otheruserId, $userRole, $otheruserRole) {
                        $subQuery->where('sender_id', $otheruserId)
                            ->where('receiver_id', $userId)
                            ->where('sender_role', $otheruserRole)
                            ->where('receiver_role', $userRole);
                    });
                })
                    ->latest()
                    ->limit(50 + 1) // Limit to 50 messages
                    ->get();
            }

            // Check if there are more messages beyond the limit
            $hasMore = $completeChat->count() > 50;

            // Remove the extra message (keep only $sms_limit messages)
            $completeChat = $completeChat->take(50)->sortBy('created_at')->values();

            // Format the chat messages
            $completeChat = $completeChat->map(function ($chat) {
                return [
                    'chat_id' => $chat->id,
                    'sender_id' => $chat->sender_id,
                    'receiver_id' => $chat->receiver_id,
                    'sms' => $chat->sms,
                    'files' => $chat->files,
                    'created_at' => $chat->created_at->toDateTimeString(),
                    'time_ago' => $chat->created_at->diffForHumans(), // Relative time like '5 minutes ago'
                ];
            });


            // Full Chat Status change --------- Start
            foreach ($completeChat as $key => $value) {
                $up_chat = Chat::where(['id' => $value['chat_id'], 'receiver_id' => Auth::user()->id, 'status' => 0])->first();
                if ($up_chat) {
                    $up_chat->status = 1;
                    $up_chat->update();
                }
            }
            // Full Chat Status change --------- END

        } else {
            $completeChat = []; // No chat records found
            $profileImageMain = '';
            $fullName = '';
            $block = '';
            $block_by = '';
            $otheruserId = '';
        }


        // Fetch First Complete Chat ------------------- END


        // Return the view with the chat list
        return view("Teacher-Dashboard.chat", compact('chatList', 'completeChat', 'profileImageMain', 'fullName', 'otheruserId', 'block', 'block_by', 'hasMore'));
    }


    // Fetch Messages By Ajax Function Start ========
    public function TeacherFetchMessages(Request $request)
    {


        // Get authenticated user's ID
        $userId = $request->sender_id;
        $userRole = $request->sender_role;
        $otheruserId = $request->reciver_id;
        // If the ID is "A", it's an Admin (role = 2), otherwise it's a regular user (role = 1)
        $otheruserRole = ($otheruserId === 'A') ? 2 : 0;
        $searchName = $request->search_name; // Get the search name from request


        // Fetch Chat List --------Start

        $Chatlist = ChatList::where('teacher', $userId) // Fetch only where user is the authenticated user
            ->orderBy('updated_at', 'desc') // Sort by last message update time
            ->get()
            ->map(function ($chat) use ($userId) {
                // Check if this chat is with an Admin
                if ($chat->admin == 1) {
                    $teacherName = 'Admin';
                    $profileImage = asset('assets/profile/avatars/(A).jpg'); // Set an admin avatar

                    // Count unseen messages from Admin (sender_role = 2)
                    $unseenCount = Chat::where('sender_role', 2)
                        ->where('receiver_id', $userId)
                        ->where('status', 0)
                        ->count();
                    $teacher_id = 'A';
                } else {
                    $teacher_id = $chat->user;
                    // Otherwise, fetch teacher details
                    $teacher = User::find($chat->user);
                    $teacherName = $teacher
                        ? $teacher->first_name . ' ' . ucfirst(substr($teacher->last_name, 0, 1)) . ''
                        : 'Unknown';
                    $profileImage = $teacher && $teacher->profile
                        ? asset('assets/profile/img/' . $teacher->profile)
                        : ($teacher
                            ? asset('assets/profile/avatars/(' . ucfirst(substr($teacher->first_name, 0, 1)) . ').jpg')
                            : asset('assets/profile/avatars/(U).jpg'));

                    // Count unseen messages from the Teacher
                    $unseenCount = Chat::where('sender_id', $chat->user)
                        ->where('receiver_id', $userId)
                        ->where('status', 0)
                        ->count();
                }

                return [
                    'teacher_id' => $teacher_id, // Teacher ID (or null if admin)
                    'teacher_name' => $teacherName,
                    'profile_image' => $profileImage,
                    'latest_sms' => $chat->sms
                        ? Str::limit($chat->sms, 15, '...')
                        : 'No messages yet',
                    'time' => Carbon::parse($chat->updated_at)->diffForHumans(), // Time from last update
                    'unseen_count' => $unseenCount,
                ];
            })
            ->filter(function ($chat) use ($searchName) {
                // If search_name is provided, filter records that contain the search term in teacher_name
                return empty($searchName) || stripos($chat['teacher_name'], $searchName) !== false;
            })
            ->values();

        $response['chatList'] = $Chatlist;

        // Fetch Chat List --------------END

        // Fetch Chat Status Block List --------------Start
        $usertype = ($otheruserRole === 2) ? 'admin' : (($otheruserRole === 1) ? 'teacher' : 'user');
        $usertypevalue = ($otheruserRole == 2) ? 1 : $otheruserId;
        $authusertypevalue = (Auth::user()->role === 2) ? 'admin' : ((Auth::user()->role === 1) ? 'teacher' : 'user');

        $firstChat = ChatList::where([$usertype => $usertypevalue, $authusertypevalue => Auth::user()->id])->first();

        // FIX LOG-2: Add null check and create ChatList if doesn't exist
        if ($firstChat) {
            $block = $firstChat->block;
            $block_by = $firstChat->block_by;
        } else {
            // Create new chat list for first-time conversation
            $firstChat = ChatList::create([
                $usertype => $usertypevalue,
                $authusertypevalue => Auth::user()->id,
                'block' => 0,
                'block_by' => null
            ]);
            $block = 0;
            $block_by = null;
        }
        $response['block'] = $block;
        $response['block_by'] = $block_by;
        // Fetch Chat Status Block List --------------END


        // Fetch First Person Complete Chat ------------ Start


        if ($otheruserRole == 2) {
            // Chat with Admin

            $fullName = 'Admin';
            $profileImageMain = asset('assets/profile/avatars/(A).jpg'); // Set an admin avatar

            // Fetch chat where receiver_role is Admin (2) and Auth user is involved
            $completeChat = Chat::where(function ($query) use ($userId) {
                $query->where(function ($subQuery) use ($userId) {
                    $subQuery->where('receiver_role', 2) // Admin role
                        ->where('sender_id', $userId); // Auth user as sender
                })->orWhere(function ($subQuery) use ($userId) {
                    $subQuery->where('sender_role', 2) // Admin as sender
                        ->where('receiver_id', $userId); // Auth user as receiver
                });
            })
                ->latest()
                ->limit($request->sms_limit + 1) // Limit to 50 messages
                ->get();
        } else {


            $user = User::find($otheruserId);

            $fullName = $user
                ? $user->first_name . ' ' . ucfirst(substr($user->last_name, 0, 1))
                : 'Unknown User';

            $profileImageMain = $user && $user->profile
                ? asset('assets/profile/img/' . $user->profile)
                : ($user
                    ? asset('assets/profile/avatars/(' . ucfirst(substr($user->first_name, 0, 1)) . ').jpg')
                    : asset('assets/profile/avatars/(U).jpg'));


            $completeChat = Chat::where(function ($query) use ($userId, $otheruserId, $userRole, $otheruserRole) {
                $query->where(function ($subQuery) use ($userId, $otheruserId, $userRole, $otheruserRole) {
                    $subQuery->where('sender_id', $userId)
                        ->where('receiver_id', $otheruserId)
                        ->where('sender_role', $userRole)
                        ->where('receiver_role', $otheruserRole);
                })->orWhere(function ($subQuery) use ($userId, $otheruserId, $userRole, $otheruserRole) {
                    $subQuery->where('sender_id', $otheruserId)
                        ->where('receiver_id', $userId)
                        ->where('sender_role', $otheruserRole)
                        ->where('receiver_role', $userRole);
                });
            })
                ->latest()
                ->limit($request->sms_limit + 1) // Limit to 50 messages
                ->get();
        }


        // Check if there are more messages beyond the limit
        $hasMore = $completeChat->count() > $request->sms_limit;

        // Remove the extra message (keep only $sms_limit messages)
        $completeChat = $completeChat->take($request->sms_limit)->sortBy('created_at')->values();


        // Format the chat messages
        $completeChat = $completeChat->map(function ($chat) {
            return [
                'chat_id' => $chat->id,
                'sender_id' => $chat->sender_id,
                'receiver_id' => $chat->receiver_id,
                'sms' => $chat->sms,
                'files' => $chat->files,
                'created_at' => $chat->created_at->toDateTimeString(),
                'time_ago' => $chat->created_at->diffForHumans(), // Relative time like '5 minutes ago'
            ];
        });


        // Full Chat Status change --------- Start
        foreach ($completeChat as $key => $value) {
            $up_chat = Chat::where(['id' => $value['chat_id'], 'receiver_id' => Auth::user()->id, 'status' => 0])->first();
            if ($up_chat) {
                $up_chat->status = 1;
                $up_chat->update();
            }
        }
        // Full Chat Status change --------- END

        $response['hasMore'] = $hasMore;
        $response['completeChat'] = $completeChat;
        $response['profileImageMain'] = $profileImageMain;
        $response['fullName'] = $fullName;
        $response['OtherUserId'] = $otheruserId;


        // Fetch First Complete Chat ------------------- END

        $notes = ChatNotes::where(['user_id' => Auth::user()->id, 'other_id' => $otheruserId])->get();
        $response['notes'] = $notes;

        return response()->json($response);
    }
    // Fetch Messages By Ajax Function END ========


    // Send Message from Dashboard Function ====
    public function TeacherSendMessage(Request $request)
    {
        info('TeacherSendMessage called with request:');

        if (!Auth::user()) {
            return response()->json(['error' => 'Please LoginIn to Your Account!']);
        }


        $fileNames = [];
        $senderId = $request->sender_id; // The ID of the sender
        $senderRole = $request->sender_role; // The ID of the sender
        $receiverId = $request->reciver_id; // The ID of the receiver
        $receiverRole = ($receiverId === 'A') ? 2 : 0;
        $uploadedFiles = $request->file('files');

        if ($uploadedFiles) {
            foreach ($request->file('files') as $file) {

                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path() . '/assets/chat_media/' . $receiverId . '_chat_files_' . $senderId . '', $fileName);
                $fileNames[] = $fileName;
            }
        }

        // Determine column and values
        $column = ($receiverRole == 0) ? 'user' : 'admin';
        $receiverValue = ($receiverRole == 0) ? $receiverId : 1; // Admin is always 1
        $type = ($receiverRole == 0) ? 0 : 1; // 0 for teacher, 1 for admin
        $sms = $request->sms ?? 'Files'; // Use null coalescing operator for cleaner code

        $havelist = ChatList::where([$column => $receiverValue, 'teacher' => $senderId, 'type' => $type])->first();


        $havelist ? $havelist->update(['sms' => $sms]) : ChatList::create([$column => $receiverValue, 'teacher' => $senderId, 'type' => $type, 'sms' => $sms]);


        $chat = new Chat();
        $chat->sender_id = $request->sender_id;
        $chat->receiver_id = $request->reciver_id;
        $chat->type = 1;
        $chat->sender_role = 1;
        $chat->receiver_role = $receiverRole;
        if ($request->sms == null) {
            $chat->sms = 'Files';
        } else {
            $chat->sms = $request->sms;
        }
        $chat->files = implode(',', $fileNames);
        $chat->save();

        $response['chat'] = [
            'id' => $chat->id,
            'sender_id' => $chat->sender_id,
            'receiver_id' => $chat->receiver_id,
            'type' => $chat->type,
            'sender_role' => $chat->sender_role,
            'receiver_role' => $chat->receiver_role,
            'sms' => $chat->sms,
            'files' => $chat->files,
            'created_at' => $chat->created_at->toDateTimeString(),
            'time_ago' => $chat->created_at->diffForHumans(), // Add the time ago field
        ];

        $this->messageService->send(
            userId: $request->reciver_id,
            count: 1,
            message: ''
        );


        return response()->json($response);


        $fileNames = [];
        $senderId = $request->sender_id; // The ID of the sender
        $senderRole = $request->sender_role; // The ID of the sender
        $receiverId = $request->reciver_id; // The ID of the receiver
        $receiverRole = User::where('id', $receiverId)->value('role'); // The Role of the receiver
        $uploadedFiles = $request->file('files');

        if ($uploadedFiles) {
            foreach ($request->file('files') as $file) {

                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path() . '/assets/chat_media/' . $receiverId . '_chat_files_' . $senderId . '', $fileName);
                $fileNames[] = $fileName;
            }
        }


        // Determine column and values
        $column = ($receiverRole == 0) ? 'user' : 'admin';
        $receiverValue = ($receiverRole == 0) ? $receiverId : 1; // Admin is always 1
        $type = ($receiverRole == 0) ? 0 : 1; // 0 for teacher, 1 for admin
        $sms = $request->sms ?? 'Files'; // Use null coalescing operator for cleaner code

        $havelist = ChatList::where([$column => $receiverValue, 'teacher' => $senderId, 'type' => $type])->first();


        $havelist ? $havelist->update(['sms' => $sms]) : ChatList::create([$column => $receiverValue, 'teacher' => $senderId, 'type' => $type, 'sms' => $sms]);

        $chat = new Chat();
        $chat->sender_id = $request->sender_id;
        $chat->receiver_id = $request->reciver_id;
        $chat->type = 1;
        $chat->sender_role = 1;
        $chat->receiver_role = 0;
        if ($request->sms == null) {
            $chat->sms = 'Files';
        } else {
            $chat->sms = $request->sms;
        }
        $chat->files = implode(',', $fileNames);
        $chat->save();

        $user = User::find($request->reciver_id);
        $response['user'] = $user;
        $response['chat'] = [
            'id' => $chat->id,
            'sender_id' => $chat->sender_id,
            'receiver_id' => $chat->receiver_id,
            'type' => $chat->type,
            'sender_role' => $chat->sender_role,
            'receiver_role' => $chat->receiver_role,
            'sms' => $chat->sms,
            'files' => $chat->files,
            'created_at' => $chat->created_at->toDateTimeString(),
            'time_ago' => $chat->created_at->diffForHumans(), // Add the time ago field
        ];


        return response()->json($response);
    }


    // Open Chat Function =====
    public function TeacherOpenChat(Request $request)
    {


        $userId = Auth::user()->id; // Authenticated user ID
        $userRole = Auth::user()->role; // Authenticated user's role
        $otheruserId = $request->id; // The other user's ID
        // If the ID is "A", it's an Admin (role = 2), otherwise it's a regular user (role = 1)
        $otheruserRole = ($otheruserId === 'A') ? 2 : 0;


        // Fetch Chat Status Block List --------------Start
        $usertype = ($otheruserRole === 2) ? 'admin' : (($otheruserRole === 1) ? 'teacher' : 'user');
        $usertypevalue = ($otheruserRole == 2) ? 1 : $otheruserId;
        $authusertypevalue = (Auth::user()->role === 2) ? 'admin' : ((Auth::user()->role === 1) ? 'teacher' : 'user');

        $firstChat = ChatList::where([$usertype => $usertypevalue, $authusertypevalue => Auth::user()->id])->first();

        // FIX LOG-2: Add null check and create ChatList if doesn't exist
        if ($firstChat) {
            $block = $firstChat->block;
            $block_by = $firstChat->block_by;
        } else {
            // Create new chat list for first-time conversation
            $firstChat = ChatList::create([
                $usertype => $usertypevalue,
                $authusertypevalue => Auth::user()->id,
                'block' => 0,
                'block_by' => null
            ]);
            $block = 0;
            $block_by = null;
        }
        $response['block'] = $block;
        $response['block_by'] = $block_by;
        // Fetch Chat Status Block List --------------END


        // Fetch First Person Complete Chat ------------ Start


        if ($otheruserRole == 2) {
            // Chat with Admin

            $fullName = 'Admin';
            $profileImageMain = asset('assets/profile/avatars/(A).jpg'); // Set an admin avatar

            // Fetch chat where receiver_role is Admin (2) and Auth user is involved
            $completeChat = Chat::where(function ($query) use ($userId) {
                $query->where(function ($subQuery) use ($userId) {
                    $subQuery->where('receiver_role', 2) // Admin role
                        ->where('sender_id', $userId); // Auth user as sender
                })->orWhere(function ($subQuery) use ($userId) {
                    $subQuery->where('sender_role', 2) // Admin as sender
                        ->where('receiver_id', $userId); // Auth user as receiver
                });
            })
                ->latest()
                ->limit(50 + 1) // Limit to 50 messages
                ->get();
        } else {


            $user = User::find($otheruserId);

            $fullName = $user
                ? $user->first_name . ' ' . ucfirst(substr($user->last_name, 0, 1))
                : 'Unknown User';

            $profileImageMain = $user && $user->profile
                ? asset('assets/profile/img/' . $user->profile)
                : ($user
                    ? asset('assets/profile/avatars/(' . ucfirst(substr($user->first_name, 0, 1)) . ').jpg')
                    : asset('assets/profile/avatars/(U).jpg'));


            $completeChat = Chat::where(function ($query) use ($userId, $otheruserId, $userRole, $otheruserRole) {
                $query->where(function ($subQuery) use ($userId, $otheruserId, $userRole, $otheruserRole) {
                    $subQuery->where('sender_id', $userId)
                        ->where('receiver_id', $otheruserId)
                        ->where('sender_role', $userRole)
                        ->where('receiver_role', $otheruserRole);
                })->orWhere(function ($subQuery) use ($userId, $otheruserId, $userRole, $otheruserRole) {
                    $subQuery->where('sender_id', $otheruserId)
                        ->where('receiver_id', $userId)
                        ->where('sender_role', $otheruserRole)
                        ->where('receiver_role', $userRole);
                });
            })
                ->latest()
                ->limit(50 + 1) // Limit to 50 messages
                ->get();
        }

        // Check if there are more messages beyond the limit
        $hasMore = $completeChat->count() > 50;

        // Remove the extra message (keep only $sms_limit messages)
        $completeChat = $completeChat->take(50)->sortBy('created_at')->values();


        // Format the chat messages
        $completeChat = $completeChat->map(function ($chat) {
            return [
                'chat_id' => $chat->id,
                'sender_id' => $chat->sender_id,
                'receiver_id' => $chat->receiver_id,
                'sms' => $chat->sms,
                'files' => $chat->files,
                'created_at' => $chat->created_at->toDateTimeString(),
                'time_ago' => $chat->created_at->diffForHumans(), // Relative time like '5 minutes ago'
            ];
        });


        // Full Chat Status change --------- Start
        foreach ($completeChat as $key => $value) {
            $up_chat = Chat::where(['id' => $value['chat_id'], 'receiver_id' => Auth::user()->id, 'status' => 0])->first();
            if ($up_chat) {
                $up_chat->status = 1;
                $up_chat->update();
            }
        }
        // Full Chat Status change --------- END


        $response['hasMore'] = $hasMore;
        $response['completeChat'] = $completeChat;
        $response['profileImageMain'] = $profileImageMain;
        $response['fullName'] = $fullName;
        $response['OtherUserId'] = $otheruserId;


        // Fetch First Complete Chat ------------------- END

        $notes = ChatNotes::where(['user_id' => Auth::user()->id, 'other_id' => $otheruserId])->get();
        $response['notes'] = $notes;

        return response()->json($response);


        $userId = Auth::user()->id; // Authenticated user ID
        $userRole = Auth::user()->role; // Authenticated user's role
        $otherUserId = $request->id; // The other user's ID
        $otherUserRole = $request->role; // The other user's role

        // Fetch chats between the authenticated user and the specified other user
        $chats = Chat::where(function ($query) use ($userId, $userRole, $otherUserId, $otherUserRole) {
            $query->where(function ($innerQuery) use ($userId, $userRole, $otherUserId, $otherUserRole) {
                $innerQuery->where('sender_id', $userId)
                    ->where('sender_role', $userRole)
                    ->where('receiver_id', $otherUserId);
            })->orWhere(function ($innerQuery) use ($userId, $userRole, $otherUserId, $otherUserRole) {
                $innerQuery->where('receiver_id', $userId)
                    ->where('receiver_role', $userRole)
                    ->where('sender_id', $otherUserId);
            });
        })->get();

        foreach ($chats as $key => $value) {
            if ($value->status == 0) {
                $value->status = 1;
                $value->update();
            }
        }

        // Format and sort chat messages
        $completeChat = $chats->sortBy('created_at') // Sort by creation time (oldest to latest)
            ->map(function ($chat) {
                return [
                    'sender_id' => $chat->sender_id,
                    'receiver_id' => $chat->receiver_id,
                    'sms' => $chat->sms,
                    'files' => $chat->files,
                    'created_at' => $chat->created_at->toDateTimeString(),
                    'time_ago' => $chat->created_at->diffForHumans(), // Relative time like '5 minutes ago'
                ];
            });

        $user = User::find($otherUserId);

        $response['chats'] = $chats;
        $response['completeChat'] = $completeChat;
        $response['user'] = $user;
        $notes = ChatNotes::where(['user_id' => Auth::user()->id, 'other_id' => $otherUserId])->get();
        $response['notes'] = $notes;


        return response()->json($response);
    }


    // Teacher Chat All Functions END =======================


    // Admin Chat All Functions Start =======================

    public function AdminMessagesHome()
    {
        // Check if the user is authenticated and is an admin
        if (!Auth::check() || Auth::user()->role != 2) {
            return redirect()->to('/')->with('error', 'Access denied. Admin only.');
        }


        $adminId = Auth::id(); // Admin ID
        $userRole = 2;
        $allUsers = User::whereIn('role', [0, 1])->get()->keyBy('id'); // Get all users & teachers

        // Fetch chat list where admin is involved
        $chatLists = ChatList::where('admin', 1)->orderBy('updated_at', 'desc')->get();

        // Users With Chats
        $usersWithChats = $chatLists->map(function ($chat) use ($allUsers) {
            $participantId = $chat->teacher ?? $chat->user;

            if (!$participantId || !isset($allUsers[$participantId])) {
                return null; // Skip invalid entries
            }

            $participant = $allUsers[$participantId];
            $participantType = $participant->role == 1 ? 'teacher' : 'user';

            // Fetch latest chat message for this user
            $latestChat = ChatList::where($participantType, $participant->id)
                ->where('admin', 1)
                ->orderBy('updated_at', 'desc')
                ->first();

            return [
                'teacher_id' => $participant->id,
                'teacher_role' => $participant->role,
                'teacher_name' => $participant->first_name . ' ' . ucfirst(substr($participant->last_name, 0, 1)) . '',
                'profile_image' => $participant->profile
                    ? asset('assets/profile/img/' . $participant->profile)
                    : asset('assets/profile/avatars/(' . strtoupper(substr($participant->first_name, 0, 1)) . ').jpg'),
                'latest_sms' => $latestChat ? Str::limit($latestChat->sms, 15, '...') : 'No messages yet',
                'block' => $latestChat->block ?? 0,
                'block_by' => $latestChat->block_by ?? null,
                'time' => $latestChat ? $latestChat->updated_at->diffForHumans() : now()->diffForHumans(),
                'unseen_count' => Chat::where('receiver_role', 2)
                    ->where('sender_id', $participant->id)
                    ->where('status', 0)
                    ->count(),
            ];
        })->filter();

        // Remove Duplicates from Users Without Chats
        $usersWithChatIDs = $usersWithChats->pluck('teacher_id')->unique(); // Ensure unique IDs

        $usersWithoutChats = $allUsers->reject(function ($user) use ($usersWithChatIDs) {
            return $usersWithChatIDs->contains($user->id); // Ensures users in withChats are not repeated
        })->map(function ($user) {
            return [
                'teacher_id' => $user->id,
                'teacher_role' => $user->role,
                'teacher_name' => $user->first_name . ' ' . ucfirst(substr($user->last_name, 0, 1)) . '',
                'profile_image' => $user->profile
                    ? asset('assets/profile/img/' . $user->profile)
                    : asset('assets/profile/avatars/(' . strtoupper(substr($user->first_name, 0, 1)) . ').jpg'),
                'latest_sms' => 'No messages yet',
                'block' => 0,
                'block_by' => null,
                'time' => $user->created_at->diffForHumans(),
                'unseen_count' => 0,
            ];
        });

        // Merge users with chats first, then users without chats
        $chatList = $usersWithChats->concat($usersWithoutChats)->values();


        // Get the first chat from the already fetched chat list
        $firstChat = $chatList->first();

        // Determine participant details
        $otheruserId = $firstChat['teacher_id']; // Fetch the first chat user/teacher ID
        $otheruserRole = $firstChat['teacher_role']; // Fetch the first chat user/teacher ID
        $block = $firstChat['block']; // Fetch the first chat user/teacher ID
        $block_by = $firstChat['block_by']; // Fetch the first chat user/teacher ID
        $otherUser = $otheruserId !== 'A' ? User::find($otheruserId) : null;

        $otherUserRole = $otherUser ? $otherUser->role : $otheruserRole; // 0 = User, 1 = Teacher, 2 = Admin
        // Set Full Name and Profile Image
        $fullName = $otherUserRole == 2 ? 'Admin' : ($otherUser ? $otherUser->first_name . ' ' . ucfirst(substr($otherUser->last_name, 0, 1)) . '' : 'Unknown User');
        $profileImageMain = $otherUserRole == 2
            ? asset('assets/profile/avatars/(A).jpg')
            : ($otherUser && $otherUser->profile
                ? asset('assets/profile/img/' . $otherUser->profile)
                : ($otherUser
                    ? asset('assets/profile/avatars/(' . strtoupper(substr($otherUser->first_name, 0, 1)) . ').jpg')
                    : asset('assets/profile/avatars/(U).jpg')));

        // Fetch complete chat history based on the first chat record
        $completeChat = Chat::where(function ($query) use ($userRole, $otheruserId, $otherUserRole) {
            $query->where(function ($subQuery) use ($userRole, $otheruserId, $otherUserRole) {
                $subQuery->where('receiver_role', $otherUserRole)
                    ->where('sender_role', $userRole)
                    ->where('receiver_id', $otheruserId);
            })
                ->orWhere(function ($subQuery) use ($userRole, $otheruserId, $otherUserRole) {
                    $subQuery->where('sender_role', $otherUserRole)
                        ->where('sender_id', $otheruserId)
                        ->where('receiver_role', $userRole);
                });
        })
            ->latest()
            ->limit(50 + 1) // Limit to 50 messages
            ->get()
            ->map(function ($chat) {
                return [
                    'chat_id' => $chat->id,
                    'sender_id' => $chat->sender_id,
                    'receiver_id' => $chat->receiver_id,
                    'sms' => $chat->sms,
                    'files' => $chat->files,
                    'created_at' => $chat->created_at->toDateTimeString(),
                    'time_ago' => $chat->created_at->diffForHumans(),
                ];
            });


        // Check if there are more messages beyond the limit
        $hasMore = $completeChat->count() > 50;

        // Remove the extra message (keep only $sms_limit messages)
        $completeChat = $completeChat->take(50)->sortBy('created_at')->values();


        // Full Chat Status change --------- Start
        foreach ($completeChat as $key => $value) {
            $up_chat = Chat::where(['id' => $value['chat_id'], 'receiver_id' => 'A', 'status' => 0])->first();
            if ($up_chat) {
                $up_chat->status = 1;
                $up_chat->update();
            }
        }
        // Full Chat Status change --------- END


        return view('Admin-Dashboard.messages', compact('chatList', 'completeChat', 'profileImageMain', 'fullName', 'otheruserId', 'block', 'block_by', 'otheruserRole', 'hasMore'));
    }


    // Fetch Messages By Ajax Function Start ========
    public function AdminFetchMessages(Request $request)
    {
        // Check if the user is authenticated and is an admin
        if (!Auth::check() || Auth::user()->role != 2) {
            return response()->json(['error' => 'Access denied. Admin only.'], 403);
        }


        $adminId = Auth::id(); // Admin ID
        $userRole = 2;
        $searchName = $request->search_name;
        $user_types = explode(',', $request->user_types);

        $allUsers = User::whereIn('role', $user_types)
            ->when($searchName, function ($query) use ($searchName) {
                $query->where(function ($q) use ($searchName) {
                    $q->where('first_name', 'LIKE', "%{$searchName}%")
                        ->orWhere('last_name', 'LIKE', "%{$searchName}%");
                });
            })
            ->get()
            ->keyBy('id');
        $response['allUsers'] = $allUsers;

        // $allUsers = User::whereIn('role', $user_types)->get()->keyBy('id'); // Get all users & teachers

        // Fetch chat list where admin is involved
        $chatLists = ChatList::where('admin', 1)->orderBy('updated_at', 'desc')->get();

        // Users With Chats
        $usersWithChats = $chatLists->map(function ($chat) use ($allUsers) {
            $participantId = $chat->teacher ?? $chat->user;

            if (!$participantId || !isset($allUsers[$participantId])) {
                return null; // Skip invalid entries
            }

            $participant = $allUsers[$participantId];
            $participantType = $participant->role == 1 ? 'teacher' : 'user';

            // Fetch latest chat message for this user
            $latestChat = ChatList::where($participantType, $participant->id)
                ->where('admin', 1)
                ->orderBy('updated_at', 'desc')
                ->first();

            return [
                'teacher_id' => $participant->id,
                'teacher_role' => $participant->role,
                'teacher_name' => $participant->first_name . ' ' . ucfirst(substr($participant->last_name, 0, 1)) . '',
                'profile_image' => $participant->profile
                    ? asset('assets/profile/img/' . $participant->profile)
                    : asset('assets/profile/avatars/(' . strtoupper(substr($participant->first_name, 0, 1)) . ').jpg'),
                'latest_sms' => $latestChat ? Str::limit($latestChat->sms, 15, '...') : 'No messages yet',
                'block' => $latestChat->block ?? 0,
                'block_by' => $latestChat->block_by ?? null,
                'time' => $latestChat ? $latestChat->updated_at->diffForHumans() : now()->diffForHumans(),
                'unseen_count' => Chat::where('receiver_role', 2)
                    ->where('sender_id', $participant->id)
                    ->where('status', 0)
                    ->count(),
            ];
        })->filter();

        // Remove Duplicates from Users Without Chats
        $usersWithChatIDs = $usersWithChats->pluck('teacher_id')->unique(); // Ensure unique IDs

        $usersWithoutChats = $allUsers->reject(function ($user) use ($usersWithChatIDs) {
            return $usersWithChatIDs->contains($user->id); // Ensures users in withChats are not repeated
        })->map(function ($user) {
            return [
                'teacher_id' => $user->id,
                'teacher_role' => $user->role,
                'teacher_name' => $user->first_name . ' ' . ucfirst(substr($user->last_name, 0, 1)) . '',
                'profile_image' => $user->profile
                    ? asset('assets/profile/img/' . $user->profile)
                    : asset('assets/profile/avatars/(' . strtoupper(substr($user->first_name, 0, 1)) . ').jpg'),
                'latest_sms' => 'No messages yet',
                'block' => 0,
                'block_by' => null,
                'time' => $user->created_at->diffForHumans(),
                'unseen_count' => 0,
            ];
        });

        // Merge users with chats first, then users without chats
        $chatList = $usersWithChats->concat($usersWithoutChats)->values();


        // Determine participant details
        $otheruserId = $request->reciver_id; // Fetch the first chat user/teacher ID
        $otherUserRole = $request->reciver_role; // Fetch the first chat user/teacher ID
        $usertype = $otherUserRole == 1 ? 'teacher' : 'user';
        $otherUser = User::find($otheruserId);
        // Get the first chat from the already fetched chat list
        $firstChat = ChatList::where([$usertype => $otheruserId, 'admin' => 1])->first();

        if ($firstChat && $otherUser) {
            $firstChat = [
                'teacher_id' => $otherUser->id,
                'teacher_role' => $otherUser->role,
                'teacher_name' => $otherUser->first_name . ' ' . ucfirst(substr($otherUser->last_name, 0, 1)) . '',
                'profile_image' => $otherUser->profile
                    ? asset('assets/profile/img/' . $otherUser->profile)
                    : asset('assets/profile/avatars/(' . strtoupper(substr($otherUser->first_name, 0, 1)) . ').jpg'),
                'latest_sms' => $firstChat->sms ? Str::limit($firstChat->sms, 15, '...') : 'No messages yet',
                'block' => $firstChat->block ?? 0,
                'block_by' => $firstChat->block_by ?? null,
                'time' => $firstChat ? $firstChat->created_at->diffForHumans() : now()->diffForHumans(),
                'unseen_count' => Chat::where('receiver_role', 2)
                    ->where('sender_id', $otherUser->id)
                    ->where('status', 0)
                    ->count(),
            ];
        } else {
            $firstChat = [
                'teacher_id' => $otherUser->id,
                'teacher_role' => $otherUser->role,
                'teacher_name' => $otherUser->first_name . ' ' . ucfirst(substr($otherUser->last_name, 0, 1)) . '',
                'profile_image' => $otherUser->profile
                    ? asset('assets/profile/img/' . $otherUser->profile)
                    : asset('assets/profile/avatars/(' . strtoupper(substr($otherUser->first_name, 0, 1)) . ').jpg'),
                'latest_sms' => 'No messages yet',
                'block' => 0,
                'block_by' => null,
                'time' => $otherUser->created_at->diffForHumans(),
                'unseen_count' => 0,
            ];
        }


        $block = $firstChat['block']; // Fetch the first chat user/teacher ID
        $block_by = $firstChat['block_by']; // Fetch the first chat user/teacher ID


        //   $otherUserRole = $otherUser->role; // 0 = User, 1 = Teacher, 2 = Admin
        // Set Full Name and Profile Image
        $fullName = $otherUserRole == 2 ? 'Admin' : $otherUser->first_name . ' ' . ucfirst(substr($otherUser->last_name, 0, 1)) . '';
        $profileName = $otherUser->first_name . $otherUser->last_name;
        $profileImageMain = $otherUserRole == 2
            ? asset('assets/profile/avatars/(A).jpg')
            : ($otherUser->profile
                ? asset('assets/profile/img/' . $otherUser->profile)
                : asset('assets/profile/avatars/(' . strtoupper(substr($otherUser->first_name, 0, 1)) . ').jpg'));

        // Fetch complete chat history based on the first chat record
        $completeChat = Chat::where(function ($query) use ($userRole, $otheruserId, $otherUserRole) {
            $query->where(function ($subQuery) use ($userRole, $otheruserId, $otherUserRole) {
                $subQuery->where('receiver_role', $otherUserRole)
                    ->where('sender_role', $userRole)
                    ->where('receiver_id', $otheruserId);
            })
                ->orWhere(function ($subQuery) use ($userRole, $otheruserId, $otherUserRole) {
                    $subQuery->where('sender_role', $otherUserRole)
                        ->where('sender_id', $otheruserId)
                        ->where('receiver_role', $userRole);
                });
        })
            ->latest()
            ->limit($request->sms_limit + 1) // Limit to 50 messages
            ->get()
            ->map(function ($chat) {
                return [
                    'chat_id' => $chat->id,
                    'sender_id' => $chat->sender_id,
                    'receiver_id' => $chat->receiver_id,
                    'sms' => $chat->sms,
                    'files' => $chat->files,
                    'created_at' => $chat->created_at->toDateTimeString(),
                    'time_ago' => $chat->created_at->diffForHumans(),
                ];
            });

        // Check if there are more messages beyond the limit
        $hasMore = $completeChat->count() > $request->sms_limit;

        // Remove the extra message (keep only $sms_limit messages)
        $completeChat = $completeChat->take($request->sms_limit)->sortBy('created_at')->values();


        // Full Chat Status change --------- Start
        foreach ($completeChat as $key => $value) {
            $up_chat = Chat::where(['id' => $value['chat_id'], 'receiver_id' => 'A', 'status' => 0])->first();
            if ($up_chat) {
                $up_chat->status = 1;
                $up_chat->update();
            }
        }
        // Full Chat Status change --------- END

        $response['chatList'] = $chatList;
        $response['hasMore'] = $hasMore;
        $response['completeChat'] = $completeChat;
        $response['profileImageMain'] = $profileImageMain;
        $response['fullName'] = $fullName;
        $response['profileName'] = $profileName;
        $response['otheruserId'] = $otheruserId;
        $response['block'] = $block;
        $response['block_by'] = $block_by;
        $response['otheruserRole'] = $otherUserRole;

        $notes = ChatNotes::where(['user_id' => 'A', 'other_id' => $otheruserId])->get();
        $response['notes'] = $notes;

        return response()->json($response);
    }

    // Fetch Messages By Ajax Function END ========


    // Send Message from Dashboard Function ====
    public function AdminSendMessage(Request $request)
    {

        if (!Auth::user()) {
            return response()->json(['error' => 'Please LoginIn to Your Account!']);
        }


        $fileNames = [];
        $senderId = $request->sender_id; // The ID of the sender
        $receiverId = $request->reciver_id; // The ID of the receiver
        $receiverRole = $request->reciver_role; // The Role of the receiver
        $uploadedFiles = $request->file('files');

        if ($uploadedFiles) {
            foreach ($request->file('files') as $file) {


                $fileName = time() . '_' . $file->getClientOriginalName();
                if ($receiverRole == 0) {
                    $file->move(public_path() . '/assets/chat_media/A_chat_files_' . $receiverId . '', $fileName);
                } else {
                    $file->move(public_path() . '/assets/chat_media/' . $receiverId . '_chat_files_A', $fileName);
                }

                // $file->move(public_path().'/assets/chat_media/'.$senderId.'_chat_files_'.$receiverId.'', $fileName);
                $fileNames[] = $fileName;
            }
        }


        $column = ($receiverRole == 0) ? 'user' : 'teacher';
        $sms = $request->sms ?? 'Files'; // Use null coalescing operator for cleaner code

        $havelist = ChatList::where([$column => $receiverId, 'admin' => 1])->first();

        $havelist ? $havelist->update(['sms' => $sms]) : ChatList::create([$column => $receiverId, 'admin' => 1, 'type' => 1, 'sms' => $sms]);


        $chat = new Chat();
        $chat->sender_id = $request->sender_id;
        $chat->receiver_id = $request->reciver_id;
        $chat->type = 2;
        $chat->sender_role = 2;
        $chat->receiver_role = $request->reciver_role;
        if ($request->sms == null) {
            $chat->sms = 'Files';
        } else {
            $chat->sms = $request->sms;
        }
        $chat->files = implode(',', $fileNames);
        $chat->save();

        $user = User::find($request->reciver_id);
        $response['otheruserRole'] = $receiverRole;
        $response['otheruserId'] = $receiverId;


        $response['chat'] = [
            'id' => $chat->id,
            'sender_id' => $chat->sender_id,
            'receiver_id' => $chat->receiver_id,
            'type' => $chat->type,
            'sender_role' => $chat->sender_role,
            'receiver_role' => $chat->receiver_role,
            'sms' => $chat->sms,
            'files' => $chat->files,
            'created_at' => $chat->created_at->toDateTimeString(),
            'time_ago' => $chat->created_at->diffForHumans(), // Add the time ago field
        ];

        $this->messageService->send(
            userId: $request->reciver_id,
            count: 1,
            message: ''
        );


        return response()->json($response);
    }


    // Open Chat Function =====
    public function AdminOpenChat(Request $request)
    {


        $userId = 'A'; // Authenticated user ID
        $userRole = 2; // Authenticated user's role
        $otheruserId = $request->id; // The other user's ID
        // If the ID is "A", it's an Admin (role = 2), otherwise it's a regular user (role = 1)
        $otherUserModel = User::find($otheruserId);
        $otheruserRole = $otherUserModel ? $otherUserModel->role : 0;


        // Fetch Chat Status Block List --------------Start
        $usertype = ($otheruserRole === 1) ? 'teacher' : 'user';
        $usertypevalue = $otheruserId;
        $authusertypevalue = (Auth::user()->role === 2) ? 'admin' : ((Auth::user()->role === 1) ? 'teacher' : 'user');

        $firstChat = ChatList::where([$usertype => $usertypevalue, $authusertypevalue => Auth::user()->id])->first();

        // FIX LOG-2: Add null check and create ChatList if doesn't exist
        if ($firstChat) {
            $block = $firstChat->block;
            $block_by = $firstChat->block_by;
        } else {
            // Create new chat list for first-time conversation
            $firstChat = ChatList::create([
                $usertype => $usertypevalue,
                $authusertypevalue => Auth::user()->id,
                'block' => 0,
                'block_by' => null
            ]);
            $block = 0;
            $block_by = null;
        }

        $response['block'] = $block;
        $response['block_by'] = $block_by;
        // Fetch Chat Status Block List --------------END


        // Fetch First Person Complete Chat ------------ Start


        $user = User::find($otheruserId);

        $fullName = $user
            ? $user->first_name . ' ' . ucfirst(substr($user->last_name, 0, 1))
            : 'Unknown User';
        $profileName = $user ? $user->first_name . $user->last_name : 'Unknown';

        $profileImageMain = $user && $user->profile
            ? asset('assets/profile/img/' . $user->profile)
            : ($user
                ? asset('assets/profile/avatars/(' . ucfirst(substr($user->first_name, 0, 1)) . ').jpg')
                : asset('assets/profile/avatars/(U).jpg'));


        // Fetch chat where receiver_role is Admin (2) and Auth user is involved
        $completeChat = Chat::where(function ($query) use ($otheruserId) {
            $query->where(function ($subQuery) use ($otheruserId) {
                $subQuery->where('sender_role', 2) // Admin role
                    ->where('receiver_id', $otheruserId); // Auth user as sender
            })->orWhere(function ($subQuery) use ($otheruserId) {
                $subQuery->where('sender_role', 2) // Admin as sender
                    ->where('receiver_id', $otheruserId); // Auth user as receiver
            });
        })
            ->latest()
            ->limit(50 + 1) // Limit to 50 messages
            ->get();


        // Check if there are more messages beyond the limit
        $hasMore = $completeChat->count() > 50;

        // Remove the extra message (keep only $sms_limit messages)
        $completeChat = $completeChat->take(50)->sortBy('created_at')->values();


        // Format the chat messages
        $completeChat = $completeChat->map(function ($chat) {
            return [
                'chat_id' => $chat->id,
                'sender_id' => $chat->sender_id,
                'receiver_id' => $chat->receiver_id,
                'sms' => $chat->sms,
                'files' => $chat->files,
                'created_at' => $chat->created_at->toDateTimeString(),
                'time_ago' => $chat->created_at->diffForHumans(), // Relative time like '5 minutes ago'
            ];
        });


        // Full Chat Status change --------- Start
        foreach ($completeChat as $key => $value) {
            $up_chat = Chat::where(['id' => $value['chat_id'], 'receiver_id' => 'A', 'status' => 0])->first();
            if ($up_chat) {
                $up_chat->status = 1;
                $up_chat->update();
            }
        }
        // Full Chat Status change --------- END


        $response['hasMore'] = $hasMore;
        $response['completeChat'] = $completeChat;
        $response['profileImageMain'] = $profileImageMain;
        $response['profileName'] = $profileName;
        $response['fullName'] = $fullName;
        $response['OtherUserId'] = $otheruserId;
        $response['OtherUserRole'] = $otheruserRole;


        // Fetch First Complete Chat ------------------- END

        $notes = ChatNotes::where(['user_id' => 'A', 'other_id' => $otheruserId])->get();
        $response['notes'] = $notes;

        return response()->json($response);


        $userId = Auth::user()->id; // Authenticated user ID
        $userRole = Auth::user()->role; // Authenticated user's role
        $otherUserId = $request->id; // The other user's ID
        $otherUserRole = $request->role; // The other user's role

        // Fetch chats between the authenticated user and the specified other user
        $chats = Chat::where(function ($query) use ($userId, $userRole, $otherUserId, $otherUserRole) {
            $query->where(function ($innerQuery) use ($userId, $userRole, $otherUserId, $otherUserRole) {
                $innerQuery->where('sender_id', $userId)
                    ->where('sender_role', $userRole)
                    ->where('receiver_id', $otherUserId);
            })->orWhere(function ($innerQuery) use ($userId, $userRole, $otherUserId, $otherUserRole) {
                $innerQuery->where('receiver_id', $userId)
                    ->where('receiver_role', $userRole)
                    ->where('sender_id', $otherUserId);
            });
        })->get();

        foreach ($chats as $key => $value) {
            if ($value->status == 0) {
                $value->status = 1;
                $value->update();
            }
        }

        // Format and sort chat messages
        $completeChat = $chats->sortBy('created_at') // Sort by creation time (oldest to latest)
            ->map(function ($chat) {
                return [
                    'sender_id' => $chat->sender_id,
                    'receiver_id' => $chat->receiver_id,
                    'sms' => $chat->sms,
                    'files' => $chat->files,
                    'created_at' => $chat->created_at->toDateTimeString(),
                    'time_ago' => $chat->created_at->diffForHumans(), // Relative time like '5 minutes ago'
                ];
            });

        $user = User::find($otherUserId);

        $response['chats'] = $chats;
        $response['completeChat'] = $completeChat;
        $response['user'] = $user;

        return response()->json($response);
    }



    // Admin Chat All Functions END =======================


    // Notes All Functions Start =======================
    public function AddNotes(Request $request)
    {

        $user_id = (Auth::user()->role === 2) ? 'A' : Auth::user()->id;

        $notes = new ChatNotes();
        $notes->user_id = $user_id;
        $notes->other_id = $request->other;
        $notes->title = $request->title;
        $notes->text = $request->text;
        $notes->save();

        $notes = ChatNotes::where(['user_id' => $user_id, 'other_id' => $request->other])->get();
        $response['notes'] = $notes;

        return response()->json($response);
    }

    // Delete Notes Function =====
    public function DeleteNotes(Request $request)
    {

        $notes = ChatNotes::find($request->id);
        $notes->delete();
        if ($notes) {
            $response['success'] = true;
            return response()->json($response);
        } else {
            $response['success'] = false;
            $response['message'] = 'Something Went Rong, Tryagain Later!';
            return response()->json($response);
        }
    }

    // Update Notes Function =====
    public function UpdateNotes(Request $request)
    {

        $notes = ChatNotes::find($request->id);
        $notes->title = $request->title;
        $notes->text = $request->text;
        $notes->update();
        if ($notes) {
            $response['success'] = true;
            $response['notes'] = $notes;
            return response()->json($response);
        } else {
            $response['success'] = false;
            $response['message'] = 'Something Went Rong, Tryagain Later!';
            return response()->json($response);
        }
    }
    // Notes All Functions END =======================


    // Block User Functions Start =======================
    public function BlockUser(Request $request)
    {
        $blockId = $request->block_id;
        $authUserId = Auth::id(); // Get authenticated user ID

        // Fetch authenticated and blocked user details
        $authUser = User::find($authUserId);
        $blockUser = User::find($blockId);

        // Validate users
        if (!$authUser) {
            return response()->json(['error' => 'Authenticated user not found'], 404);
        }
        if (!$blockUser) {
            return response()->json(['error' => 'Blocked user not found'], 404);
        }

        // Determine user roles (Admin = 2, Teacher = 1, User = 0)
        $authUserRole = ($authUser->role === 0) ? 'user' : (($authUser->role === 1) ? 'teacher' : 'admin');
        $authUserValue = ($authUser->role === 2) ? 1 : $authUserId;

        $blockUserRole = ($blockUser->role === 0) ? 'user' : (($blockUser->role === 1) ? 'teacher' : 'admin');
        $blockUserValue = ($blockUser->role === 2) ? 1 : $blockId;

        // Determine block status based on auth user role
        $blockStatus = ($authUser->role === 0) ? 1 : (($authUser->role === 1) ? 2 : 3); // User → 1, Teacher → 2, Admin → 3

        // Determine who is blocking (Admin = "A", others = user ID)
        $blockByValue = ($authUser->role === 2) ? 'A' : $authUserId;

        // Fetch the first chat record where the two users are involved
        $chatRecord = ChatList::where([$authUserRole => $authUserValue, $blockUserRole => $blockUserValue])->first();

        if (!$chatRecord) {
            return response()->json(['error' => 'Chat not found!']);
        }

        // Check if already blocked
        if ($chatRecord->block != 0) {
            // Only the original blocker can unblock
            if ($chatRecord->block_by != $blockByValue) {
                return response()->json(['error' => 'This user has already blocked you!']);
            }

            // Unblock user
            $chatRecord->update(['block' => 0, 'block_by' => null]);

            return response()->json(['success' => 'You unblocked this user!', 'block' => 0]);
        }

        // Block user and store blocker ID
        $chatRecord->update(['block' => $blockStatus, 'block_by' => $blockByValue]);

        return response()->json(['success' => 'You blocked this user!', 'block' => $blockStatus, 'block_by' => $blockByValue]);
    }
    // Block User Functions END =======================


    // Search Messsage Functions Start =======================
    public function SearchMessage(Request $request)
    {


        $userId = (Auth::user()->role === 2) ? 'A' : Auth::id();
        $userRole = Auth::user()->role; // Authenticated user's role
        $otheruserId = $request->id; // The other user's ID
        $searchKey = $request->key; // Search keyword

        // If ID is "A", it's an Admin (role = 2), otherwise fetch role from the User table
        $otheruserRole = ($otheruserId === 'A') ? 2 : User::where('id', $otheruserId)->value('role');


        // Fetch messages containing the search key
        $query = Chat::where(function ($query) use ($userId, $otheruserId, $userRole, $otheruserRole) {
            $query->where(function ($subQuery) use ($userId, $otheruserId, $userRole, $otheruserRole) {
                $subQuery->where('sender_id', $userId)
                    ->where('receiver_id', $otheruserId)
                    ->where('sender_role', $userRole)
                    ->where('receiver_role', $otheruserRole);
            })->orWhere(function ($subQuery) use ($userId, $otheruserId, $userRole, $otheruserRole) {
                $subQuery->where('sender_id', $otheruserId)
                    ->where('receiver_id', $userId)
                    ->where('sender_role', $otheruserRole)
                    ->where('receiver_role', $userRole);
            });
        });


        // Filter by search keyword if provided
        if (!empty($searchKey)) {
            $query->where('sms', 'LIKE', "%{$searchKey}%");
        }

        $completeChat = $query->orderBy('created_at', 'asc')->get();

        // Format the chat messages
        $completeChat = $completeChat->map(function ($chat) {
            return [
                'chat_id' => $chat->id,
                'sender_id' => $chat->sender_id,
                'receiver_id' => $chat->receiver_id,
                'sms' => $chat->sms,
                'files' => $chat->files,
                'created_at' => $chat->created_at->toDateTimeString(),
                'time_ago' => $chat->created_at->diffForHumans(), // Relative time like '5 minutes ago'
            ];
        });

        return response()->json([
            'completeChat' => $completeChat,
            'OtherUserId' => $otheruserId,
            'OtherUserRole' => $otheruserRole
        ]);
    }

    // Search Messsage Functions END =======================


    // Custom Offer in Messsage Functions Start  =======================
    public function GetServicesForCustom(Request $request)
    {

        if (!Auth::user()) {
            return response()->json(['error' => 'Please LoginIn to Your Account!']);
        }


        $services = DB::table('teacher_gigs')
            ->join('teacher_gig_data', 'teacher_gigs.id', '=', 'teacher_gig_data.gig_id')
            ->join('teacher_gig_payments', 'teacher_gigs.id', '=', 'teacher_gig_payments.gig_id')
            ->where('teacher_gigs.user_id', Auth::id())
            ->where('teacher_gigs.service_role', $request->offer_type)
            ->where('teacher_gigs.status', 1)
            ->select('teacher_gigs.*', 'teacher_gig_data.*', 'teacher_gig_payments.*')
            ->get();

        return response()->json(['services' => $services]);
    }



    

    public function sendCustomOffer(Request $request)
    {
        // Validation
        $request->validate([
            'buyer_id' => 'required|exists:users,id',
            'gig_id' => 'required|exists:teacher_gigs,id',
            'offer_type' => 'required|in:Class,Freelance',
            'payment_type' => 'required|in:Single,Milestone',
            'service_mode' => 'required|in:Online,In-person',
            'description' => 'nullable|string|max:1000',
            'expire_days' => 'nullable|integer|min:1|max:30',
            'request_requirements' => 'nullable|boolean',
            'milestones' => 'required|array|min:1',
            'milestones.*.title' => 'required|string|max:255',
            'milestones.*.description' => 'nullable|string',
            'milestones.*.price' => 'required|numeric|min:10',
            'milestones.*.revisions' => 'nullable|integer|min:0',
            'milestones.*.delivery_days' => 'nullable|integer|min:1',
            'milestones.*.date' => 'nullable|date|after:today',
            'milestones.*.start_time' => 'nullable|date_format:H:i',
            'milestones.*.end_time' => 'nullable|date_format:H:i|after:milestones.*.start_time',
        ]);

        // Conditional validation for in-person
        if ($request->service_mode === 'In-person') {
            $request->validate([
                'milestones.*.date' => 'required|date|after:today',
                'milestones.*.start_time' => 'required|date_format:H:i',
                'milestones.*.end_time' => 'required|date_format:H:i',
            ]);
        }

        // Conditional validation for freelance
        if ($request->offer_type === 'Freelance') {
            $request->validate([
                'milestones.*.revisions' => 'required|integer|min:0',
            ]);

            if ($request->payment_type === 'Single') {
                $request->validate([
                    'milestones.*.delivery_days' => 'required|integer|min:1',
                ]);
            }
        }

        // Check for duplicate pending offers
        $existingOffer = \App\Models\CustomOffer::where('seller_id', auth()->id())
            ->where('buyer_id', $request->buyer_id)
            ->where('gig_id', $request->gig_id)
            ->where('status', 'pending')
            ->first();

        if ($existingOffer) {
            return response()->json([
                'error' => 'You already have a pending offer for this service to this buyer.'
            ], 400);
        }

        // Calculate total amount
        $totalAmount = collect($request->milestones)->sum('price');

        // Get chat_id
        $chat = \App\Models\Chat::where(function($q) use ($request) {
            $q->where('sender_id', auth()->id())
              ->where('receiver_id', $request->buyer_id);
        })->orWhere(function($q) use ($request) {
            $q->where('sender_id', $request->buyer_id)
              ->where('receiver_id', auth()->id());
        })->first();

        if (!$chat) {
            return response()->json(['error' => 'No chat found with this buyer.'], 400);
        }

        // Create custom offer
        $offer = \App\Models\CustomOffer::create([
            'chat_id' => $chat->id,
            'seller_id' => auth()->id(),
            'buyer_id' => $request->buyer_id,
            'gig_id' => $request->gig_id,
            'offer_type' => $request->offer_type,
            'payment_type' => $request->payment_type,
            'service_mode' => $request->service_mode,
            'description' => $request->description,
            'total_amount' => $totalAmount,
            'expire_days' => $request->expire_days,
            'request_requirements' => $request->request_requirements ?? false,
            'status' => 'pending',
            'expires_at' => $request->expire_days ? now()->addDays($request->expire_days) : null,
        ]);

        // Create milestones
        foreach ($request->milestones as $index => $milestone) {
            \App\Models\CustomOfferMilestone::create([
                'custom_offer_id' => $offer->id,
                'title' => $milestone['title'],
                'description' => $milestone['description'] ?? null,
                'date' => $milestone['date'] ?? null,
                'start_time' => $milestone['start_time'] ?? null,
                'end_time' => $milestone['end_time'] ?? null,
                'price' => $milestone['price'],
                'revisions' => $milestone['revisions'] ?? 0,
                'delivery_days' => $milestone['delivery_days'] ?? null,
                'order' => $index,
            ]);
        }

        // Send message in chat with offer card
        
        // \App\Models\Message::create([
        //     'chat_id' => $chat->id,
        //     'sender_id' => auth()->id(),
        //     'reciver_id' => $request->buyer_id,
        //     'message' => 'Custom Offer: ' . $offer->gig->title,
        // ]);

        // Send notification to buyer
        if (class_exists('\App\Services\NotificationService')) {
            try {
                app(\App\Services\NotificationService::class)->send(
                    userId: $request->buyer_id,
                    type: 'custom_offer',
                    title: 'New Custom Offer',
                    message: auth()->user()->first_name . ' sent you a custom offer for ' . $offer->gig->title,
                    data: [
                        'offer_id' => $offer->id,
                        'seller_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
                        'service_name' => $offer->gig->title,
                        'total_amount' => $totalAmount,
                    ],
                    sendEmail: true
                );
            } catch (\Exception $e) {
                \Log::error('Custom offer notification failed: ' . $e->getMessage());
            }
        }

        // Send email to buyer
        try {
            $buyer = \App\Models\User::find($request->buyer_id);
            if ($buyer && $buyer->email) {
                Mail::to($buyer->email)->send(new CustomOfferSent($offer));
            }
        } catch (\Exception $e) {
            \Log::error('Custom offer email failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'offer' => $offer->load('milestones'),
            'message' => 'Custom offer sent successfully!'
        ]);
    }


    

    public function viewCustomOffer($id)
    {
        $offer = \App\Models\CustomOffer::with(['milestones', 'seller', 'buyer', 'gig'])
            ->findOrFail($id);

        // Authorization check
        if ($offer->buyer_id !== auth()->id() && $offer->seller_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this offer.');
        }

        return response()->json([
            'offer' => $offer,
            'can_accept' => $offer->canBeAccepted() && $offer->buyer_id === auth()->id(),
        ]);
    }

    public function acceptCustomOffer($id)
    {
        $offer = \App\Models\CustomOffer::with('milestones')->findOrFail($id);

        // Authorization check
        if ($offer->buyer_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Check if offer can be accepted
        if (!$offer->canBeAccepted()) {
            $reason = $offer->isExpired() ? 'This offer has expired.' : 'This offer is no longer available.';
            return response()->json(['error' => $reason], 400);
        }

        // Calculate commission
        $commission = \App\Models\TopSellerTag::calculateCommission($offer->gig_id, $offer->seller_id);
        $totalAmount = $offer->total_amount + $commission['buyer_commission'];

        // Create Stripe checkout session
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

        try {
            $session = $stripe->checkout->sessions->create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Custom Offer: ' . $offer->gig->title,
                            'description' => $offer->description ?? 'Custom service offer',
                        ],
                        'unit_amount' => $totalAmount * 100, // cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => url('/custom-offer-success?session_id={CHECKOUT_SESSION_ID}'),
                'cancel_url' => url('/messages'),
                'metadata' => [
                    'custom_offer_id' => $offer->id,
                    'buyer_id' => auth()->id(),
                    'seller_id' => $offer->seller_id,
                    'gig_id' => $offer->gig_id,
                ],
            ]);

            // Update offer status
            $offer->update([
                'status' => 'accepted',
                'accepted_at' => now(),
            ]);

            // Send notification to seller
            if (class_exists('\App\Services\NotificationService')) {
                try {
                    app(\App\Services\NotificationService::class)->send(
                        userId: $offer->seller_id,
                        type: 'custom_offer',
                        title: 'Offer Accepted!',
                        message: $offer->buyer->first_name . ' accepted your custom offer for ' . $offer->gig->title,
                        data: ['offer_id' => $offer->id],
                        sendEmail: true
                    );
                } catch (\Exception $e) {
                    \Log::error('Custom offer acceptance notification failed: ' . $e->getMessage());
                }
            }

            // Send email to seller
            try {
                if ($offer->seller && $offer->seller->email) {
                    Mail::to($offer->seller->email)->send(new CustomOfferAccepted($offer));
                }
            } catch (\Exception $e) {
                \Log::error('Custom offer acceptance email failed: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'checkout_url' => $session->url
            ]);

        } catch (\Exception $e) {
            \Log::error('Stripe checkout creation failed: ' . $e->getMessage());
            return response()->json(['error' => 'Payment processing failed. Please try again.'], 500);
        }
    }

    public function rejectCustomOffer(Request $request, $id)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $offer = \App\Models\CustomOffer::findOrFail($id);

        // Authorization check
        if ($offer->buyer_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Check if offer is still pending
        if ($offer->status !== 'pending') {
            return response()->json(['error' => 'This offer has already been processed.'], 400);
        }

        // Update offer status
        $offer->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'rejection_reason' => $request->reason,
        ]);

        // Send notification to seller
        if (class_exists('\App\Services\NotificationService')) {
            try {
                app(\App\Services\NotificationService::class)->send(
                    userId: $offer->seller_id,
                    type: 'custom_offer',
                    title: 'Offer Rejected',
                    message: $offer->buyer->first_name . ' declined your custom offer for ' . $offer->gig->title,
                    data: [
                        'offer_id' => $offer->id,
                        'reason' => $request->reason,
                    ],
                    sendEmail: true
                );
            } catch (\Exception $e) {
                \Log::error('Custom offer rejection notification failed: ' . $e->getMessage());
            }
        }

        // Send email to seller
        try {
            if ($offer->seller && $offer->seller->email) {
                Mail::to($offer->seller->email)->send(new CustomOfferRejected($offer));
            }
        } catch (\Exception $e) {
            \Log::error('Custom offer rejection email failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Offer rejected successfully.'
        ]);
    }
    // Custom Offer in Messsage Functions END =======================


}