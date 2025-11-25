<?php

namespace App\Http\Controllers;

use App\Models\BookingDuration;
use App\Models\Transaction;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\TopSellerTag;
use Carbon\Carbon;
use App\Models\BookOrder;
use App\Models\CancelOrder;
use App\Models\Chat;
use App\Models\ChatList;
use App\Models\ClassDate;
use App\Models\ClassReschedule;
use App\Models\DisputeOrder;
use App\Models\ExpertProfile;
use App\Models\ServiceReviews;
use App\Models\TeacherGig;
use App\Models\TeacherGigData;
use App\Models\TeacherGigPayment;
use App\Models\TeacherReapetDays;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Stripe\Refund;
use Stripe\Exception\InvalidRequestException;
use App\Services\NotificationService;


class OrderManagementController extends Controller
{
    public $reschedule_hours;
    public $sorting = "book_orders.updated_at";

    protected $notificationService;

    public function __construct(NotificationService $notification)
    {
        // Laravel automatically inject করবে
        $this->notificationService = $notification;
    }
    // User Pannel Order Management ===================

    public function OrderManagement()
    {
        if (!Auth::user()) {
            return redirect()->to('/')->with('error', 'Please LoginIn to Your Account!');
        } else {
            if (Auth::user()->role == 1) {
                return redirect()->to('/teacher-dashboard');
            } elseif (Auth::user()->role == 2) {
                return redirect()->to('/admin-dashboard');
            }
        }

        $admin_duration = BookingDuration::first();
        $reschedule_hours = (int)($admin_duration?->reschedule ?? 12);

        $perPage = 20;

        $pendingOrders = DB::table('book_orders')
            ->join('expert_profiles', 'book_orders.teacher_id', '=', 'expert_profiles.user_id')
            ->join('teacher_gigs', 'book_orders.gig_id', '=', 'teacher_gigs.id')
            ->join('teacher_gig_data', 'book_orders.gig_id', '=', 'teacher_gig_data.gig_id')
            ->join('class_dates', 'book_orders.id', '=', 'class_dates.order_id')
            ->leftJoin('class_reschedules', function ($join) {
                $join->on('book_orders.id', '=', 'class_reschedules.order_id')
                    ->where('book_orders.teacher_reschedule', 1);
            })
            ->select(
                'book_orders.id as order_id',
                'expert_profiles.user_id',
                'expert_profiles.first_name',
                'expert_profiles.last_name',
                'expert_profiles.profession',
                'expert_profiles.profile_image',
                'book_orders.title',
                'teacher_gig_data.description',
                'teacher_gig_data.freelance_service',
                'teacher_gig_data.lesson_type',
                'teacher_gig_data.payment_type',
                'teacher_gigs.service_type',
                'teacher_gigs.service_role',
                'book_orders.finel_price',
                'book_orders.teacher_reschedule',
                'book_orders.user_reschedule',
                'book_orders.created_at',
                'book_orders.status',
                DB::raw('MIN(class_dates.user_date) as start_date'),
                DB::raw('MAX(class_dates.user_date) as end_date'),
                DB::raw("
            CASE
                WHEN book_orders.teacher_reschedule = 1 THEN
                    MIN(class_reschedules.user_date)
                ELSE
                    NULL
            END as new_start_date
        "),
                DB::raw("
            CASE
                WHEN book_orders.teacher_reschedule = 1 THEN
                    MAX(class_reschedules.user_date)
                ELSE
                    NULL
            END as new_end_date
        ")
            )
            ->where('book_orders.status', 0)
            ->where('book_orders.user_id', Auth::user()->id)
            ->groupBy(
                'book_orders.id',
                'expert_profiles.user_id',
                'expert_profiles.first_name',
                'expert_profiles.last_name',
                'expert_profiles.profession',
                'expert_profiles.profile_image',
                'book_orders.title',
                'teacher_gig_data.description',
                'teacher_gig_data.freelance_service',
                'teacher_gig_data.lesson_type',
                'teacher_gig_data.payment_type',
                'teacher_gigs.service_type',
                'teacher_gigs.service_role',
                'book_orders.finel_price',
                'book_orders.teacher_reschedule',
                'book_orders.user_reschedule',
                'book_orders.created_at',
                'book_orders.status',

            )->orderBy($this->sorting, 'desc')
            ->paginate($perPage);

        // Attach all_classes and new_all_classes
        foreach ($pendingOrders as $order) {
            // Get all class_dates for this order
            $order->all_classes = DB::table('class_dates')
                ->where('order_id', $order->order_id)
                ->select('user_date', 'user_attend', 'user_time_zone', 'duration')
                ->get();

            // Get all class_reschedules if teacher_reschedule is 1
            if ($order->teacher_reschedule == 1) {
                $order->new_all_classes = DB::table('class_reschedules')
                    ->where('order_id', $order->order_id)->where('status', '=', 0)
                    ->select('user_date')
                    ->get();
            } else {
                $order->new_all_classes = [];
            }
        }


        $activeOrders = DB::table('book_orders')
            ->join('expert_profiles', 'book_orders.teacher_id', '=', 'expert_profiles.user_id')
            ->join('teacher_gigs', 'book_orders.gig_id', '=', 'teacher_gigs.id')
            ->join('teacher_gig_data', 'book_orders.gig_id', '=', 'teacher_gig_data.gig_id')
            ->join('class_dates', 'book_orders.id', '=', 'class_dates.order_id')
            ->leftJoin('class_reschedules', function ($join) {
                $join->on('book_orders.id', '=', 'class_reschedules.order_id')
                    ->where('book_orders.teacher_reschedule', 1);
            })
            ->select(
                'book_orders.id as order_id',
                'expert_profiles.user_id',
                'expert_profiles.first_name',
                'expert_profiles.last_name',
                'expert_profiles.profession',
                'expert_profiles.profile_image',
                'book_orders.title',
                'teacher_gig_data.description',
                'teacher_gig_data.freelance_service',
                'teacher_gig_data.lesson_type',
                'teacher_gig_data.payment_type',
                'teacher_gigs.service_type',
                'teacher_gigs.service_role',
                'book_orders.finel_price',
                'book_orders.teacher_reschedule',
                'book_orders.user_reschedule',
                'book_orders.created_at',
                'book_orders.status',
                DB::raw('MIN(class_dates.user_date) as start_date'),
                DB::raw('MAX(class_dates.user_date) as end_date'),
                DB::raw("
            CASE
                WHEN book_orders.teacher_reschedule = 1 THEN
                    MIN(class_reschedules.user_date)
                ELSE
                    NULL
            END as new_start_date
        "),
                DB::raw("
            CASE
                WHEN book_orders.teacher_reschedule = 1 THEN
                    MAX(class_reschedules.user_date)
                ELSE
                    NULL
            END as new_end_date
        ")
            )
            ->where('book_orders.status', 1)
            ->where('book_orders.user_id', Auth::user()->id)
            ->groupBy(
                'book_orders.id',
                'expert_profiles.user_id',
                'expert_profiles.first_name',
                'expert_profiles.last_name',
                'expert_profiles.profession',
                'expert_profiles.profile_image',
                'book_orders.title',
                'teacher_gig_data.description',
                'teacher_gig_data.freelance_service',
                'teacher_gig_data.lesson_type',
                'teacher_gig_data.payment_type',
                'teacher_gigs.service_type',
                'teacher_gigs.service_role',
                'book_orders.finel_price',
                'book_orders.teacher_reschedule',
                'book_orders.user_reschedule',
                'book_orders.created_at',
                'book_orders.status'
            )->orderBy($this->sorting, 'desc')
            ->paginate($perPage);


        // Attach all_classes and new_all_classes
        foreach ($activeOrders as $order) {
            // Get all class_dates for this order
            $order->all_classes = DB::table('class_dates')
                ->where('order_id', $order->order_id)
                ->select('user_date', 'user_attend', 'user_time_zone', 'duration')
                ->get();

            $order->current_class = DB::table('class_dates')
                ->where('order_id', $order->order_id)
                ->where('user_date', '>', now()) // current date-time check
                ->orderBy('user_date', 'asc')    // nearest upcoming class first
                ->select('user_date', 'user_attend', 'duration', 'user_time_zone')
                ->first(); // only the first upcoming class


            $order->past_classes = DB::table('class_dates')
                ->where('order_id', $order->order_id)
                ->where(function ($query) use ($reschedule_hours) {
                    $query->where('user_date', '<', now())
                        ->orWhereBetween('user_date', [now(), now()->addHours($reschedule_hours)]);
                })
                ->select('user_date', 'user_attend', 'user_time_zone')
                ->get();

            // Get all class_reschedules if teacher_reschedule is 1
            if ($order->teacher_reschedule == 1) {
                $order->new_all_classes = DB::table('class_reschedules')
                    ->where('order_id', $order->order_id)->where('status', '=', 0)
                    ->select('user_date')
                    ->get();
            } else {
                $order->new_all_classes = [];
            }
        }


        $deliveredOrders = DB::table('book_orders')
            ->join('expert_profiles', 'book_orders.teacher_id', '=', 'expert_profiles.user_id')
            ->join('teacher_gigs', 'book_orders.gig_id', '=', 'teacher_gigs.id')
            ->join('teacher_gig_data', 'book_orders.gig_id', '=', 'teacher_gig_data.gig_id')
            ->join('class_dates', 'book_orders.id', '=', 'class_dates.order_id')
            ->select(
                'book_orders.id as order_id',
                'expert_profiles.user_id',
                'expert_profiles.first_name',
                'expert_profiles.last_name',
                'expert_profiles.profession',
                'expert_profiles.profile_image',
                'book_orders.title',
                'teacher_gig_data.description',
                'teacher_gig_data.freelance_service',
                'teacher_gig_data.lesson_type',
                'teacher_gig_data.payment_type',
                'teacher_gigs.service_type',
                'teacher_gigs.service_role',
                'book_orders.finel_price',
                'book_orders.action_date',
                'book_orders.teacher_reschedule',
                'book_orders.user_reschedule',
                'book_orders.created_at',
                'book_orders.status',
                DB::raw('MIN(class_dates.user_date) as start_date'),
                DB::raw('MAX(class_dates.user_date) as end_date')
            )
            ->where('book_orders.status', 2)
            ->where('book_orders.user_id', Auth::user()->id)
            ->groupBy(
                'book_orders.id',
                'expert_profiles.user_id',
                'expert_profiles.first_name',
                'expert_profiles.last_name',
                'expert_profiles.profession',
                'expert_profiles.profile_image',
                'book_orders.title',
                'teacher_gig_data.description',
                'teacher_gig_data.freelance_service',
                'teacher_gig_data.lesson_type',
                'teacher_gig_data.payment_type',
                'teacher_gigs.service_type',
                'teacher_gigs.service_role',
                'book_orders.finel_price',
                'book_orders.action_date',
                'book_orders.teacher_reschedule',
                'book_orders.user_reschedule',
                'book_orders.created_at',
                'book_orders.status'
            )->orderBy($this->sorting, 'desc')
            ->paginate($perPage);


        // Attach all_classes and new_all_classes
        foreach ($deliveredOrders as $order) {
            // Get all class_dates for this order
            $order->all_classes = DB::table('class_dates')
                ->where('order_id', $order->order_id)
                ->select('user_date', 'user_attend', 'user_time_zone', 'duration')
                ->get();

            // Get all class_reschedules if teacher_reschedule is 1
            if ($order->teacher_reschedule == 1) {
                $order->new_all_classes = DB::table('class_reschedules')
                    ->where('order_id', $order->order_id)->where('status', '=', 0)
                    ->select('user_date')
                    ->get();
            } else {
                $order->new_all_classes = [];
            }
        }

        $completedOrders = DB::table('book_orders')
            ->join('expert_profiles', 'book_orders.teacher_id', '=', 'expert_profiles.user_id')
            ->join('teacher_gigs', 'book_orders.gig_id', '=', 'teacher_gigs.id')
            ->join('teacher_gig_data', 'book_orders.gig_id', '=', 'teacher_gig_data.gig_id')
            ->join('class_dates', 'book_orders.id', '=', 'class_dates.order_id')
            ->select(
                'book_orders.id as order_id',
                'expert_profiles.user_id',
                'expert_profiles.first_name',
                'expert_profiles.last_name',
                'expert_profiles.profession',
                'expert_profiles.profile_image',
                'book_orders.title',
                'teacher_gig_data.description',
                'teacher_gig_data.freelance_service',
                'teacher_gig_data.lesson_type',
                'teacher_gig_data.payment_type',
                'teacher_gigs.service_type',
                'teacher_gigs.service_role',
                'book_orders.finel_price',
                'book_orders.action_date',
                'book_orders.teacher_reschedule',
                'book_orders.user_reschedule',
                'book_orders.created_at',
                'book_orders.status',
                DB::raw('MIN(class_dates.user_date) as start_date'),
                DB::raw('MAX(class_dates.user_date) as end_date')
            )
            ->where('book_orders.status', 3)
            ->where('book_orders.user_id', Auth::user()->id)
            ->groupBy(
                'book_orders.id',
                'expert_profiles.user_id',
                'expert_profiles.first_name',
                'expert_profiles.last_name',
                'expert_profiles.profession',
                'expert_profiles.profile_image',
                'book_orders.title',
                'teacher_gig_data.description',
                'teacher_gig_data.freelance_service',
                'teacher_gig_data.lesson_type',
                'teacher_gig_data.payment_type',
                'teacher_gigs.service_type',
                'teacher_gigs.service_role',
                'book_orders.finel_price',
                'book_orders.action_date',
                'book_orders.teacher_reschedule',
                'book_orders.user_reschedule',
                'book_orders.created_at',
                'book_orders.status'
            )->orderBy($this->sorting, 'desc')
            ->paginate($perPage);


        // Attach all_classes and new_all_classes
        foreach ($completedOrders as $order) {

            $order->review = DB::table('service_reviews')
                ->whereNull('parent_id')
                ->where('order_id', $order->order_id)
                ->where('user_id', Auth::user()->id)
                ->select('*')
                ->first();
            // Get all class_dates for this order
            $order->all_classes = DB::table('class_dates')
                ->where('order_id', $order->order_id)
                ->select('user_date', 'user_attend', 'user_time_zone', 'duration')
                ->get();

            // Get all class_reschedules if teacher_reschedule is 1
            if ($order->teacher_reschedule == 1) {
                $order->new_all_classes = DB::table('class_reschedules')
                    ->where('order_id', $order->order_id)
                    ->select('user_date')
                    ->get();
            } else {
                $order->new_all_classes = [];
            }
        }


        $cancelledOrders = DB::table('book_orders')
            ->join('expert_profiles', 'book_orders.teacher_id', '=', 'expert_profiles.user_id')
            ->join('teacher_gigs', 'book_orders.gig_id', '=', 'teacher_gigs.id')
            ->join('teacher_gig_data', 'book_orders.gig_id', '=', 'teacher_gig_data.gig_id')
            ->join('class_dates', 'book_orders.id', '=', 'class_dates.order_id')
            ->leftJoin('dispute_orders', 'book_orders.id', '=', 'dispute_orders.order_id')
            ->select(
                'book_orders.id as order_id',
                'expert_profiles.user_id',
                'expert_profiles.first_name',
                'expert_profiles.last_name',
                'expert_profiles.profession',
                'expert_profiles.profile_image',
                'book_orders.title',
                'teacher_gig_data.description',
                'teacher_gig_data.freelance_service',
                'teacher_gig_data.lesson_type',
                'teacher_gig_data.payment_type',
                'teacher_gigs.service_type',
                'teacher_gigs.service_role',
                'book_orders.finel_price',
                'book_orders.action_date',
                'book_orders.teacher_reschedule',
                'book_orders.user_reschedule',
                'book_orders.created_at',
                'book_orders.refund',
                'book_orders.user_dispute',
                'book_orders.teacher_dispute',
                'book_orders.status',
                'dispute_orders.user_reason',
                'dispute_orders.teacher_reason',
                'dispute_orders.refund_type',
                'dispute_orders.amount as dispute_amount',
                'dispute_orders.status as dispute_status',
                DB::raw('MIN(class_dates.user_date) as start_date'),
                DB::raw('MAX(class_dates.user_date) as end_date')
            )
            ->where('book_orders.status', 4)
            ->where('book_orders.user_id', Auth::user()->id)
            ->groupBy(
                'book_orders.id',
                'expert_profiles.user_id',
                'expert_profiles.first_name',
                'expert_profiles.last_name',
                'expert_profiles.profession',
                'expert_profiles.profile_image',
                'book_orders.title',
                'teacher_gig_data.description',
                'teacher_gig_data.freelance_service',
                'teacher_gig_data.lesson_type',
                'teacher_gig_data.payment_type',
                'teacher_gigs.service_type',
                'teacher_gigs.service_role',
                'book_orders.finel_price',
                'book_orders.action_date',
                'book_orders.teacher_reschedule',
                'book_orders.user_reschedule',
                'book_orders.created_at',
                'book_orders.refund',
                'book_orders.user_dispute',
                'book_orders.teacher_dispute',
                'book_orders.status',
                'dispute_orders.user_reason',
                'dispute_orders.teacher_reason',
                'dispute_orders.refund_type',
                'dispute_orders.amount',
                'dispute_orders.status'
            )->orderBy($this->sorting, 'desc')
            ->paginate($perPage);


        // Attach all_classes and new_all_classes
        foreach ($cancelledOrders as $order) {

            $order->review = DB::table('service_reviews')
                ->whereNull('parent_id')
                ->where('order_id', $order->order_id)
                ->where('user_id', Auth::user()->id)
                ->select('*')
                ->first();

            // Get all class_dates for this order
            $order->all_classes = DB::table('class_dates')
                ->where('order_id', $order->order_id)
                ->select('user_date', 'user_attend', 'user_time_zone', 'duration')
                ->get();

            // Get all class_reschedules if teacher_reschedule is 1
            if ($order->teacher_reschedule == 1) {
                $order->new_all_classes = DB::table('class_reschedules')
                    ->where('order_id', $order->order_id)->where('status', '=', 0)
                    ->select('user_date')
                    ->get();
            } else {
                $order->new_all_classes = [];
            }
        }

        return view('User-Dashboard.class-management', compact(
            'pendingOrders',
            'activeOrders',
            'deliveredOrders',
            'completedOrders',
            'cancelledOrders',
            'reschedule_hours'
        ));
    }


    // Teacher Pannel Client Management ================
    public function ClientManagement()
    {

        if (!Auth::user()) {
            return redirect()->to('/')->with('error', 'Please LoginIn to Your Account!');
        } else {
            if (Auth::user()->role == 2) {
                return redirect()->to('/admin-dashboard');
            } elseif (Auth::user()->role == 0) {
                return redirect()->to('/user-dashboard');
            }
        }

        $admin_duration = BookingDuration::first();
        $reschedule_hours = (int)($admin_duration?->reschedule ?? 12);


        $perPage = 20;

        $pendingOrders = DB::table('book_orders')
            ->join('users', 'book_orders.user_id', '=', 'users.id')
            ->join('teacher_gigs', 'book_orders.gig_id', '=', 'teacher_gigs.id')
            ->join('teacher_gig_data', 'book_orders.gig_id', '=', 'teacher_gig_data.gig_id')
            ->join('class_dates', 'book_orders.id', '=', 'class_dates.order_id')
            ->leftJoin('class_reschedules', function ($join) {
                $join->on('book_orders.id', '=', 'class_reschedules.order_id')
                    ->where('book_orders.user_reschedule', 1);
            })
            ->select(
                'book_orders.id as order_id',
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.country',
                'users.profile',
                'book_orders.title',
                'teacher_gigs.service_type',
                'teacher_gig_data.description',
                'teacher_gig_data.freelance_service',
                'teacher_gig_data.lesson_type',
                'teacher_gig_data.payment_type',
                'teacher_gigs.service_role',
                'book_orders.finel_price',
                'book_orders.teacher_reschedule',
                'book_orders.user_reschedule',
                'book_orders.created_at',
                'book_orders.status',
                DB::raw('MIN(class_dates.teacher_date) as start_date'),
                DB::raw('MAX(class_dates.teacher_date) as end_date'),

                // Corrected Reschedule Logic
                DB::raw("
            CASE
                WHEN book_orders.user_reschedule = 1 THEN
                    MIN(class_reschedules.teacher_date)
                ELSE
                    NULL
            END as new_start_date
        "),
                DB::raw("
            CASE
                WHEN book_orders.user_reschedule = 1 THEN
                    MAX(class_reschedules.teacher_date)
                ELSE
                    NULL
            END as new_end_date
        ")
            )
            ->where('book_orders.status', 0)
            ->where('book_orders.teacher_id', Auth::id())
            ->groupBy(
                'book_orders.id',
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.profile',
                'book_orders.title',
                'teacher_gig_data.description',
                'teacher_gig_data.freelance_service',
                'teacher_gig_data.lesson_type',
                'teacher_gig_data.payment_type',
                'teacher_gigs.service_type',
                'teacher_gigs.service_role',
                'book_orders.finel_price',
                'book_orders.teacher_reschedule',
                'book_orders.user_reschedule',
                'book_orders.created_at',
                'book_orders.status'
            )->orderBy($this->sorting, 'desc')
            ->paginate($perPage);


        // Attach all_classes and new_all_classes
        foreach ($pendingOrders as $order) {
            // Get all class_dates for this order
            $order->all_classes = DB::table('class_dates')
                ->where('order_id', $order->order_id)
                ->select('teacher_date', 'teacher_attend', 'teacher_time_zone', 'duration')
                ->get();

            // Get all class_reschedules if teacher_reschedule is 1
            if ($order->user_reschedule == 1) {

                $order->new_all_classes = DB::table('class_reschedules')
                    ->where('order_id', $order->order_id)->where('status', '=', 0)
                    ->select('teacher_date')
                    ->get();
            } else {
                $order->new_all_classes = [];
            }
        }


        $priorityOrders = DB::table('book_orders')
            ->join('users', 'book_orders.user_id', '=', 'users.id')
            ->join('teacher_gigs', 'book_orders.gig_id', '=', 'teacher_gigs.id')
            ->join('teacher_gig_data', 'book_orders.gig_id', '=', 'teacher_gig_data.gig_id')
            ->join('class_dates', 'book_orders.id', '=', 'class_dates.order_id')
            ->leftJoin('class_reschedules', function ($join) {
                $join->on('book_orders.id', '=', 'class_reschedules.order_id')
                    ->where('book_orders.user_reschedule', 1);
            })
            ->select(
                'book_orders.id as order_id',
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.country',
                'users.profile',
                'book_orders.title',
                'teacher_gig_data.description',
                'teacher_gig_data.freelance_service',
                'teacher_gig_data.lesson_type',
                'teacher_gig_data.payment_type',
                'teacher_gigs.service_type',
                'teacher_gigs.service_role',
                'book_orders.finel_price',
                'book_orders.teacher_reschedule',
                'book_orders.user_reschedule',
                'book_orders.start_job',
                'book_orders.created_at',
                'book_orders.status',
                DB::raw('MIN(class_dates.teacher_date) as start_date'),
                DB::raw('MAX(class_dates.teacher_date) as end_date'),
                // Corrected Reschedule Logic
                DB::raw("
            CASE
                WHEN book_orders.user_reschedule = 1 THEN
                    MIN(class_reschedules.teacher_date)
                ELSE
                    NULL
            END as new_start_date
        "),
                DB::raw("
            CASE
                WHEN book_orders.user_reschedule = 1 THEN
                    MAX(class_reschedules.teacher_date)
                ELSE
                    NULL
            END as new_end_date
        ")
            )
            ->where('book_orders.status', 1)
            ->where('book_orders.teacher_id', Auth::id())
            ->groupBy(
                'book_orders.id',
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.country',
                'users.profile',
                'book_orders.title',
                'teacher_gig_data.description',
                'teacher_gig_data.freelance_service',
                'teacher_gig_data.lesson_type',
                'teacher_gig_data.payment_type',
                'teacher_gigs.service_type',
                'teacher_gigs.service_role',
                'book_orders.finel_price',
                'book_orders.start_job',
                'book_orders.teacher_reschedule',
                'book_orders.user_reschedule',
                'book_orders.created_at',
                'book_orders.status'
            )
            ->havingRaw('MAX(class_dates.teacher_date) BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 72 HOUR)')
            ->orderBy($this->sorting, 'desc') // Order by nearest end_date
            ->paginate($perPage);

        // Attach all_classes and new_all_classes
        foreach ($priorityOrders as $order) {
            // Get all class_dates for this order
            $order->all_classes = DB::table('class_dates')
                ->where('order_id', $order->order_id)
                ->select('teacher_date', 'teacher_attend', 'teacher_time_zone', 'duration')
                ->get();
            $order->current_class = DB::table('class_dates')
                ->where('order_id', $order->order_id)
                ->where('teacher_date', '>', now()) // current date-time check
                ->orderBy('teacher_date', 'asc')    // nearest upcoming class first
                ->select('teacher_date', 'teacher_attend', 'duration', 'teacher_time_zone')
                ->first(); // only the first upcoming class

            $order->past_classes = DB::table('class_dates')
                ->where('order_id', $order->order_id)
                ->where(function ($query) use ($reschedule_hours) {
                    $query->where('teacher_date', '<', now()) // Past classes
                    ->orWhereBetween('teacher_date', [now(), now()->addHours($reschedule_hours)]); // Next 12 hours
                })
                ->select('teacher_date', 'teacher_attend', 'teacher_time_zone')
                ->get();

            // Get all class_reschedules if teacher_reschedule is 1
            if ($order->user_reschedule == 1) {
                $order->new_all_classes = DB::table('class_reschedules')
                    ->where('order_id', $order->order_id)->where('status', '=', 0)
                    ->select('teacher_date')
                    ->get();
            } else {
                $order->new_all_classes = [];
            }
        }

        $activeOrders = DB::table('book_orders')
            ->join('users', 'book_orders.user_id', '=', 'users.id')
            ->join('teacher_gigs', 'book_orders.gig_id', '=', 'teacher_gigs.id')
            ->join('teacher_gig_data', 'book_orders.gig_id', '=', 'teacher_gig_data.gig_id')
            ->join('class_dates', 'book_orders.id', '=', 'class_dates.order_id')
            ->leftJoin('class_reschedules', function ($join) {
                $join->on('book_orders.id', '=', 'class_reschedules.order_id')
                    ->where('book_orders.user_reschedule', 1);
            })
            ->select(
                'book_orders.id as order_id',
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.country',
                'users.profile',
                'book_orders.title',
                'teacher_gig_data.description',
                'teacher_gig_data.freelance_service',
                'teacher_gig_data.lesson_type',
                'teacher_gig_data.payment_type',
                'teacher_gigs.service_type',
                'teacher_gigs.service_role',
                'book_orders.start_job',
                'book_orders.finel_price',
                'book_orders.teacher_reschedule',
                'book_orders.user_reschedule',
                'book_orders.created_at',
                'book_orders.status',
                DB::raw('MIN(class_dates.teacher_date) as start_date'),
                DB::raw('MAX(class_dates.teacher_date) as end_date'),
                // Corrected Reschedule Logic
                DB::raw("
            CASE
                WHEN book_orders.user_reschedule = 1 THEN
                    MIN(class_reschedules.teacher_date)
                ELSE
                    NULL
            END as new_start_date
        "),
                DB::raw("
            CASE
                WHEN book_orders.user_reschedule = 1 THEN
                    MAX(class_reschedules.teacher_date)
                ELSE
                    NULL
            END as new_end_date
        ")
            )
            ->where('book_orders.status', 1)
            ->where('book_orders.teacher_id', Auth::id())
            ->groupBy(
                'book_orders.id',
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.country',
                'users.profile',
                'book_orders.title',
                'teacher_gig_data.description',
                'teacher_gig_data.freelance_service',
                'teacher_gig_data.lesson_type',
                'teacher_gig_data.payment_type',
                'teacher_gigs.service_type',
                'teacher_gigs.service_role',
                'book_orders.start_job',
                'book_orders.finel_price',
                'book_orders.teacher_reschedule',
                'book_orders.user_reschedule',
                'book_orders.created_at',
                'book_orders.status'
            )->orderBy($this->sorting, 'desc')
            ->paginate($perPage);

        // Attach all_classes and new_all_classes
        foreach ($activeOrders as $order) {
            // Get all class_dates for this order
            $order->all_classes = DB::table('class_dates')
                ->where('order_id', $order->order_id)
                ->select('teacher_date', 'teacher_attend', 'teacher_time_zone', 'duration')
                ->get();
            $order->current_class = DB::table('class_dates')
                ->where('order_id', $order->order_id)
                ->where('teacher_date', '>', now()) // current date-time check
                ->orderBy('teacher_date', 'asc')    // nearest upcoming class first
                ->select('teacher_date', 'teacher_attend', 'duration', 'teacher_time_zone')
                ->first(); // only the first upcoming class

            $order->past_classes = DB::table('class_dates')
                ->where('order_id', $order->order_id)
                ->where(function ($query) use ($reschedule_hours) {
                    $query->where('teacher_date', '<', now()) // Past classes
                    ->orWhereBetween('teacher_date', [now(), now()->addHours($reschedule_hours)]); // Next 12 hours
                })
                ->select('teacher_date', 'teacher_attend', 'teacher_time_zone')
                ->get();


            // Get all class_reschedules if teacher_reschedule is 1
            if ($order->user_reschedule == 1) {
                $order->new_all_classes = DB::table('class_reschedules')
                    ->where('order_id', $order->order_id)->where('status', '=', 0)
                    ->select('teacher_date')
                    ->get();
            } else {
                $order->new_all_classes = [];
            }
        }


        $deliveredOrders = DB::table('book_orders')
            ->join('users', 'book_orders.user_id', '=', 'users.id')
            ->join('teacher_gigs', 'book_orders.gig_id', '=', 'teacher_gigs.id')
            ->join('teacher_gig_data', 'book_orders.gig_id', '=', 'teacher_gig_data.gig_id')
            ->join('class_dates', 'book_orders.id', '=', 'class_dates.order_id')
            ->select(
                'book_orders.id as order_id',
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.country',
                'users.profile',
                'book_orders.title',
                'teacher_gig_data.description',
                'teacher_gig_data.freelance_service',
                'teacher_gig_data.lesson_type',
                'teacher_gig_data.payment_type',
                'teacher_gigs.service_type',
                'teacher_gigs.service_role',
                'book_orders.finel_price',
                'book_orders.action_date',
                'book_orders.teacher_reschedule',
                'book_orders.user_reschedule',
                'book_orders.created_at',
                'book_orders.status',
                DB::raw('MIN(class_dates.teacher_date) as start_date'),
                DB::raw('MAX(class_dates.teacher_date) as end_date')
            )
            ->where('book_orders.status', 2)
            ->where('book_orders.teacher_id', Auth::id())
            ->groupBy(
                'book_orders.id',
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.country',
                'users.profile',
                'book_orders.title',
                'teacher_gig_data.description',
                'teacher_gig_data.freelance_service',
                'teacher_gig_data.lesson_type',
                'teacher_gig_data.payment_type',
                'teacher_gigs.service_type',
                'teacher_gigs.service_role',
                'book_orders.finel_price',
                'book_orders.action_date',
                'book_orders.teacher_reschedule',
                'book_orders.user_reschedule',
                'book_orders.created_at',
                'book_orders.status'
            )->orderBy($this->sorting, 'desc')
            ->paginate($perPage);

        // Attach all_classes and new_all_classes
        foreach ($deliveredOrders as $order) {
            // Get all class_dates for this order
            $order->all_classes = DB::table('class_dates')
                ->where('order_id', $order->order_id)
                ->select('teacher_date', 'teacher_attend', 'teacher_time_zone', 'duration')
                ->get();

            // Get all class_reschedules if teacher_reschedule is 1
            if ($order->user_reschedule == 1) {
                $order->new_all_classes = DB::table('class_reschedules')
                    ->where('order_id', $order->order_id)->where('status', '=', 0)
                    ->select('teacher_date')
                    ->get();
            } else {
                $order->new_all_classes = [];
            }
        }

        $completedOrders = DB::table('book_orders')
            ->join('users', 'book_orders.user_id', '=', 'users.id')
            ->join('teacher_gigs', 'book_orders.gig_id', '=', 'teacher_gigs.id')
            ->join('teacher_gig_data', 'book_orders.gig_id', '=', 'teacher_gig_data.gig_id')
            ->join('class_dates', 'book_orders.id', '=', 'class_dates.order_id')
            ->select(
                'book_orders.id as order_id',
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.country',
                'users.profile',
                'book_orders.title',
                'teacher_gig_data.description',
                'teacher_gig_data.freelance_service',
                'teacher_gig_data.lesson_type',
                'teacher_gig_data.payment_type',
                'teacher_gigs.service_type',
                'teacher_gigs.service_role',
                'book_orders.finel_price',
                'book_orders.action_date',
                'book_orders.teacher_reschedule',
                'book_orders.user_reschedule',
                'book_orders.created_at',
                'book_orders.status',
                DB::raw('MIN(class_dates.teacher_date) as start_date'),
                DB::raw('MAX(class_dates.teacher_date) as end_date')
            )
            ->where('book_orders.status', 3)
            ->where('book_orders.teacher_id', Auth::id())
            ->groupBy(
                'book_orders.id',
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.country',
                'users.profile',
                'book_orders.title',
                'teacher_gig_data.description',
                'teacher_gig_data.freelance_service',
                'teacher_gig_data.lesson_type',
                'teacher_gig_data.payment_type',
                'teacher_gigs.service_type',
                'teacher_gigs.service_role',
                'book_orders.finel_price',
                'book_orders.action_date',
                'book_orders.teacher_reschedule',
                'book_orders.user_reschedule',
                'book_orders.created_at',
                'book_orders.status'
            )->orderBy($this->sorting, 'desc')
            ->paginate($perPage);

        // Attach all_classes and new_all_classes
        foreach ($completedOrders as $order) {

            $order->review = DB::table('service_reviews')
                ->whereNull('parent_id')
                ->where('order_id', $order->order_id)
                ->where('teacher_id', Auth::user()->id)
                ->select('*')
                ->first();


            // Get all class_dates for this order
            $order->all_classes = DB::table('class_dates')
                ->where('order_id', $order->order_id)
                ->select('teacher_date', 'teacher_attend', 'teacher_time_zone', 'duration')
                ->get();

            // Get all class_reschedules if teacher_reschedule is 1
            if ($order->user_reschedule == 1) {
                $order->new_all_classes = DB::table('class_reschedules')
                    ->where('order_id', $order->order_id)->where('status', '=', 0)
                    ->select('teacher_date')
                    ->get();
            } else {
                $order->new_all_classes = [];
            }
        }

        $cancelledOrders = DB::table('book_orders')
            ->join('users', 'book_orders.user_id', '=', 'users.id')
            ->join('teacher_gigs', 'book_orders.gig_id', '=', 'teacher_gigs.id')
            ->join('teacher_gig_data', 'book_orders.gig_id', '=', 'teacher_gig_data.gig_id')
            ->join('class_dates', 'book_orders.id', '=', 'class_dates.order_id')
            ->select(
                'book_orders.id as order_id',
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.country',
                'users.profile',
                'book_orders.title',
                'teacher_gig_data.description',
                'teacher_gig_data.freelance_service',
                'teacher_gig_data.lesson_type',
                'teacher_gig_data.payment_type',
                'teacher_gigs.service_type',
                'teacher_gigs.service_role',
                'book_orders.finel_price',
                'book_orders.action_date',
                'book_orders.teacher_reschedule',
                'book_orders.user_reschedule',
                'book_orders.created_at',
                'book_orders.refund',
                'book_orders.teacher_dispute',
                'book_orders.user_dispute',
                'book_orders.updated_at',
                'book_orders.status',
                DB::raw('MIN(class_dates.teacher_date) as start_date'),
                DB::raw('MAX(class_dates.teacher_date) as end_date')
            )
            ->where('book_orders.status', 4)
            ->where('book_orders.teacher_id', Auth::id())
            ->groupBy(
                'book_orders.id',
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.country',
                'users.profile',
                'book_orders.title',

                'teacher_gig_data.description',
                'teacher_gig_data.freelance_service',
                'teacher_gig_data.lesson_type',
                'teacher_gig_data.payment_type',
                'teacher_gigs.service_type',
                'teacher_gigs.service_role',
                'book_orders.finel_price',
                'book_orders.action_date',
                'book_orders.teacher_reschedule',
                'book_orders.user_reschedule',
                'book_orders.created_at',
                'book_orders.refund',
                'book_orders.teacher_dispute',
                'book_orders.user_dispute',
                'book_orders.updated_at',
                'book_orders.status'
            )->orderBy($this->sorting, 'desc')
            ->paginate($perPage);

        // Attach all_classes and new_all_classes
        foreach ($cancelledOrders as $order) {

            $order->review = DB::table('service_reviews')
                ->whereNull('parent_id')
                ->where('order_id', $order->order_id)
                ->where('teacher_id', Auth::user()->id)
                ->select('*')
                ->first();

            // Get all class_dates for this order
            $order->all_classes = DB::table('class_dates')
                ->where('order_id', $order->order_id)
                ->select('teacher_date', 'teacher_attend', 'teacher_time_zone', 'duration')
                ->get();

            // Get all class_reschedules if teacher_reschedule is 1
            if ($order->user_reschedule == 1) {
                $order->new_all_classes = DB::table('class_reschedules')
                    ->where('order_id', $order->order_id)->where('status', '=', 0)
                    ->select('teacher_date')
                    ->get();
            } else {
                $order->new_all_classes = [];
            }
        }

        // ✅ NEW: Get Pending Refund Requests for 48-Hour Countdown
        $pendingRefunds = BookOrder::where('teacher_id', Auth::id())
            ->where('user_dispute', 1)
            ->where('teacher_dispute', 0)
            ->with(['user', 'gig', 'disputeOrder'])
            ->orderBy('action_date', 'asc')
            ->get()
            ->map(function ($order) {
                // Calculate countdown
                $actionDate = \Carbon\Carbon::parse($order->action_date);
                $now = \Carbon\Carbon::now();
                $hoursRemaining = 48 - $actionDate->diffInHours($now);

                // Ensure hours remaining is non-negative
                $order->hours_remaining = max(0, $hoursRemaining);
                $order->minutes_remaining = max(0, ($hoursRemaining * 60) - (int)($hoursRemaining * 60));

                // Calculate urgency level for color coding
                if ($hoursRemaining > 24) {
                    $order->urgency = 'low';
                    $order->urgency_color = 'success'; // green
                } elseif ($hoursRemaining > 6) {
                    $order->urgency = 'medium';
                    $order->urgency_color = 'warning'; // yellow
                } else {
                    $order->urgency = 'high';
                    $order->urgency_color = 'danger'; // red
                }

                // Add flash class for very urgent (< 2 hours)
                $order->is_flashing = $hoursRemaining < 2;

                // Get buyer's dispute reason
                if ($order->disputeOrder) {
                    $order->buyer_reason = $order->disputeOrder->user_reason ?? $order->disputeOrder->reason ?? 'No reason provided';
                } else {
                    $order->buyer_reason = 'No reason provided';
                }

                return $order;
            });

        return view('Teacher-Dashboard.client-managment', compact(
            'pendingOrders',
            'priorityOrders',
            'activeOrders',
            'deliveredOrders',
            'completedOrders',
            'cancelledOrders',
            'reschedule_hours',
            'pendingRefunds'
        ));
    }



    // Order Action FUnctions Start =======================
    // Active Order----------------
    public function ActiveOrder($id)
    {
        if (!Auth::user()) {
            return redirect('/')->with('error', 'Login First!');
        }

        $order = BookOrder::find($id);
//        $classes = ClassDate::where(['order_id' => $id])->get();
//        $classes_ids = ClassDate::where(['order_id' => $id])->pluck('id');
//        $reschedule = ClassReschedule::whereIn('class_id', $classes_ids)->where('order_id', '=', $id)->get();

        if ($order && $order->status == 0) {

            if ($order->teacher_reschedule == 1 && Auth::user()->role != 0) {
                return redirect('/')->with('error', 'Only User can accept this rescheduled order!');
            }

            if ($order->teacher_reschedule == 0 && Auth::user()->role != 1) {
                return redirect('/')->with('error', 'Only Teacher can accept this order!');
            }

            $classes = ClassDate::where('order_id', $id)->get();
            $classIds = $classes->pluck('id');

            // Get all rescheduled classes for this order
            $reschedules = ClassReschedule::whereIn('class_id', $classIds)
                ->where('order_id', $id)
                ->where('status', 0)
                ->get();

            if ($reschedules) {
                foreach ($reschedules as $reschedule) {
                    $class = $classes->where('id', $reschedule->class_id)->first();
                    if ($class) {
                        $class->user_date = $reschedule->user_date;
                        $class->teacher_date = $reschedule->teacher_date;
                        $class->save();

                        $reschedule->status = 1;
                        $reschedule->save();
                    }
                }
            }

            // ============ UPDATE TRANSACTION STATUS ============
            try {
                // Find transaction
                $transaction = Transaction::where('buyer_id', $order->user_id)
                    ->where('seller_id', $order->teacher_id)
                    ->where('status', 'pending')
                    ->whereHas('bookOrder', function ($q) use ($order) {
                        $q->where('id', $order->id);
                    })
                    ->orWhere(function ($query) use ($order) {
                        $query->where('service_id', $order->gig_id)
                            ->where('buyer_id', $order->user_id)
                            ->where('seller_id', $order->teacher_id)
                            ->where('status', 'pending');
                    })
                    ->first();

                // Capture Stripe payment
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $paymentIntent = \Stripe\PaymentIntent::retrieve($order->payment_id);

                if ($paymentIntent->status === 'requires_capture') {
                    $paymentIntent->capture();
                    \Log::info('Payment captured for order: ' . $order->id);
                }

                // Update transaction status
                if ($transaction) {
                    $transaction->markAsCompleted($order->payment_id);

                    \Log::info('Transaction marked as completed', [
                        'transaction_id' => $transaction->id,
                        'order_id' => $order->id,
                        'amount' => $transaction->total_amount
                    ]);
                }

                // Update BookOrder payment status
                $order->payment_status = 'completed';

            } catch (\Exception $e) {
                \Log::error('Payment capture failed for order ' . $order->id . ': ' . $e->getMessage());
                return redirect()->back()->with('error', 'Payment capture failed. Please contact support.');
            }

            $order->status = 1;
            $order->teacher_reschedule = 0;
            $order->teacher_reschedule_time = 0;
            $order->user_reschedule = 0;
            $order->update();

            $buyerId = $order->user_id;
            $seller = Auth::user();
            $buyer = \App\Models\User::find($buyerId);
            $serviceName = $order->title;
            $orderId = $order->id;
            $startDate = ClassDate::where('order_id', $orderId)->min('user_date');

            // Privacy-protected names
            $sellerMaskedName = \App\Helpers\NameHelper::getMaskedName($seller);
            $sellerFullName = \App\Helpers\NameHelper::getFullName($seller);
            $buyerFullName = \App\Helpers\NameHelper::getFullName($buyer);

            // To Buyer (masked seller name for privacy)
            $this->notificationService->send(
                userId: $buyerId,
                type: 'order',
                title: 'Order Accepted',
                message: $sellerMaskedName . ' has accepted your order for ' . $serviceName,
                data: ['order_id' => $orderId, 'start_date' => $startDate],
                sendEmail: true, // Email + notification
                actorUserId: Auth::user()->id,
                targetUserId: $buyerId,
                orderId: $orderId,
                serviceId: $order->gig_id,
                emailTemplate: 'order-approved'
            );

            // To Admin (full names for tracking)
            $this->notificationService->sendToMultipleUsers(
                userIds: $this->getAdminUserIds(),
                type: 'order',
                title: 'Order Approved by Seller',
                message: $sellerFullName . ' approved order #' . $orderId . ' for "' . $serviceName . '" from buyer "' . $buyerFullName . '"',
                data: [
                    'order_id' => $orderId,
                    'seller_name' => $sellerFullName,
                    'buyer_name' => $buyerFullName,
                    'service_name' => $serviceName,
                    'amount' => $order->buyer_total,
                ],
                sendEmail: false,
                actorUserId: Auth::user()->id,
                targetUserId: $buyerId,
                orderId: $orderId,
                serviceId: $order->gig_id
            );

        } 

        if ($order) {
            return redirect()->back()->with('success', 'Order Activated Successfully!');
        } else {
            return redirect()->back()->with('error', 'Something went wrong, try again later!');
        }
    }

    // Reject Pending Order ---------------
    public function RejectOrder($id)
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Login First!');
        }

        $order = BookOrder::find($id);

        if (!$order || $order->status != 0) {
            return redirect()->back()->with('error', 'Only pending orders can be rejected!');
        }

        // Only seller can reject their own orders
        if (Auth::user()->role != 1 || $order->teacher_id != Auth::id()) {
            return redirect()->back()->with('error', 'Only the seller can reject this order!');
        }

        try {
            // Start database transaction
            \DB::beginTransaction();

            // Process refund via Stripe
            $refundSuccess = false;
            if (!empty($order->payment_id)) {
                try {
                    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                    $paymentIntent = \Stripe\PaymentIntent::retrieve($order->payment_id);

                    // Cancel or refund depending on payment status
                    if (in_array($paymentIntent->status, ['requires_payment_method', 'requires_capture', 'requires_confirmation', 'requires_action'])) {
                        $paymentIntent->cancel();
                        $refundSuccess = true;
                    } elseif ($paymentIntent->status === 'succeeded') {
                        \Stripe\Refund::create(['payment_intent' => $order->payment_id]);
                        $refundSuccess = true;
                    }
                } catch (\Exception $e) {
                    \Log::error("Stripe refund failed for rejected order #{$order->id}: " . $e->getMessage());
                }
            }

            // Update order status
            $order->status = 4; // Cancelled
            $order->refund = $refundSuccess ? 1 : 0;
            $order->payment_status = $refundSuccess ? 'refunded' : 'failed';
            $order->action_date = now();
            $order->save();

            // Create cancel order record
            $cancelOrder = new \App\Models\CancelOrder();
            $cancelOrder->user_id = Auth::id();
            $cancelOrder->user_role = 1; // Seller
            $cancelOrder->order_id = $order->id;
            $cancelOrder->reason = "Seller rejected the order request";
            $cancelOrder->refund = $refundSuccess ? 1 : 0;
            $cancelOrder->amount = $refundSuccess ? $order->finel_price : 0;
            $cancelOrder->save();

            // Update transaction status
            $transaction = \App\Models\Transaction::where('stripe_transaction_id', $order->payment_id)->first();
            if ($transaction) {
                $transaction->status = $refundSuccess ? 'refunded' : 'failed';
                $transaction->notes .= "\n[" . now()->format('Y-m-d H:i:s') . "] Order rejected by seller";
                $transaction->save();
            }

            \DB::commit();

            // Send notifications
            $buyer = \App\Models\User::find($order->user_id);
            $seller = Auth::user();
            $serviceName = $order->title;

            // Privacy-protected names
            $sellerMaskedName = \App\Helpers\NameHelper::getMaskedName($seller);
            $sellerFullName = \App\Helpers\NameHelper::getFullName($seller);
            $buyerFullName = \App\Helpers\NameHelper::getFullName($buyer);

            // Notify buyer (masked seller name for privacy)
            $this->notificationService->send(
                userId: $order->user_id,
                type: 'cancellation',
                title: 'Order Request Rejected',
                message: "Your order request for {$serviceName} has been declined by {$sellerMaskedName}. " . ($refundSuccess ? "Full refund of $" . number_format($order->finel_price, 2) . " has been processed." : "Please contact support regarding refund."),
                data: ['order_id' => $order->id, 'refund_amount' => $refundSuccess ? $order->finel_price : 0],
                sendEmail: true,
                actorUserId: Auth::id(),
                targetUserId: $order->user_id,
                orderId: $order->id,
                serviceId: $order->gig_id,
                emailTemplate: 'order-rejected'
            );

            // Notify Admin (full names for tracking)
            $refundAmount = $order->buyer_total ?? 0;
            $this->notificationService->sendToMultipleUsers(
                userIds: $this->getAdminUserIds(),
                type: 'order',
                title: 'Order Rejected by Seller',
                message: "Seller \"{$sellerFullName}\" rejected order #{$order->id} for \"{$serviceName}\" from buyer \"{$buyerFullName}\". Refund processed: £" . number_format($refundAmount, 2),
                data: [
                    'order_id' => $order->id,
                    'seller_name' => $sellerFullName,
                    'buyer_name' => $buyerFullName,
                    'service_name' => $serviceName,
                    'refund_amount' => $refundAmount,
                    'refund_success' => $refundSuccess,
                ],
                sendEmail: false,
                actorUserId: Auth::id(),
                targetUserId: $order->user_id,
                orderId: $order->id,
                serviceId: $order->gig_id
            );

            return redirect()->back()->with('success', 'Order rejected and buyer has been refunded!');

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error("Failed to reject order #{$id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to reject order. Please try again.');
        }
    }

    // Cancel Order----------------
    public function CancelOrder(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Login First!');
        }

        $order = BookOrder::find($request->order_id);
        if (!$order) {
            return redirect()->back()->with('error', 'Order Not Found!');
        }

        $admin_duration = BookingDuration::first();
        $reschedule_hours = (int)($admin_duration?->reschedule ?? 12);
        $order->frequency = $order->frequency ?? 1;

        $now = now();
        $cancelOrder = new CancelOrder();
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $classes = ClassDate::where('order_id', $order->id)->get();
        $refundableClasses = [];
        $nonRefundableClasses = [];
        $refundAmount = 0;
        $date = Auth::user()->role == 1 ? 'teacher_date' : 'user_date';
        $time_zone = Auth::user()->role == 1 ? 'teacher_time_zone' : 'user_time_zone';

        // ============ SCENARIO A: PENDING ORDER - FULL REFUND ============
        if ($order->status == 0) {
            try {
                $paymentIntent = PaymentIntent::retrieve($order->payment_id);
                $paymentIntent->cancel();

                $cancelOrder->refund = 1;
                $cancelOrder->amount = $order->finel_price;
                $order->refund = 1;

                // ============ UPDATE TRANSACTION STATUS ============
                $transaction = Transaction::where('buyer_id', $order->user_id)
                    ->where('seller_id', $order->teacher_id)
                    ->where('status', 'pending')
                    ->first();

                if ($transaction) {
                    $transaction->markAsRefunded();
                    \Log::info('Transaction refunded (pending order)', [
                        'transaction_id' => $transaction->id,
                        'order_id' => $order->id
                    ]);
                }

            } catch (\Exception $e) {
                \Log::error('Pending order cancellation failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Cancellation failed: ' . $e->getMessage());
            }

            // ============ SCENARIO B: TEACHER-INITIATED REFUND ============
        } else if (Auth::user()->role == 1 && $request->order_refund == 1) {

            $cancelOrder->refund = 1;
            $cancelOrder->refund_type = $request->refund;

            try {
                $paymentIntent = PaymentIntent::retrieve($order->payment_id);

                if ($request->refund == 0) {
                    // Full Refund
                    if (in_array($paymentIntent->status, ['requires_capture', 'requires_confirmation'])) {
                        $paymentIntent->cancel();
                    } else if ($paymentIntent->status === 'succeeded') {
                        Refund::create(['payment_intent' => $order->payment_id]);
                    }

                    $cancelOrder->amount = $order->finel_price;
                    $order->refund = 1;

                    // ============ UPDATE TRANSACTION - FULL REFUND ============
                    $transaction = Transaction::where('buyer_id', $order->user_id)
                        ->where('seller_id', $order->teacher_id)
                        ->first();

                    if ($transaction) {
                        $transaction->markAsRefunded();
                        $transaction->payout_status = 'failed'; // Seller won't get paid
                        $transaction->save();

                        \Log::info('Transaction fully refunded by teacher', [
                            'transaction_id' => $transaction->id,
                            'order_id' => $order->id
                        ]);
                    }

                } else {
                    // Partial Refund
                    $refundAmount = floatval($request->refund_amount);
                    $finalPrice = floatval($order->finel_price);

                    if ($refundAmount == null) {
                        return redirect()->back()->with('error', 'Add Refund Amount!');
                    }

                    if ($refundAmount > $finalPrice) {
                        return redirect()->back()->with('error', 'Refund amount cannot exceed the final price!');
                    }

                    if ($paymentIntent->status === 'requires_capture') {
                        $paymentIntent->capture();
                    }

                    if ($paymentIntent->status === 'succeeded') {
                        Refund::create([
                            'payment_intent' => $order->payment_id,
                            'amount' => round($refundAmount * 100)
                        ]);
                    }

                    $cancelOrder->amount = $request->refund_amount;
                    $order->refund = 1;

                    // ============ UPDATE TRANSACTION - PARTIAL REFUND ============
                    $transaction = Transaction::where('buyer_id', $order->user_id)
                        ->where('seller_id', $order->teacher_id)
                        ->first();

                    if ($transaction) {
                        $remainingAmount = $transaction->total_amount - $refundAmount;

                        // Recalculate commissions on remaining amount
                        $newSellerCommission = ($remainingAmount * $transaction->seller_commission_rate) / 100;
                        $newBuyerCommission = ($remainingAmount * $transaction->buyer_commission_rate) / 100;

                        $transaction->coupon_discount += $refundAmount;
                        $transaction->seller_commission_amount = $newSellerCommission;
                        $transaction->buyer_commission_amount = $newBuyerCommission;
                        $transaction->total_admin_commission = $newSellerCommission + $newBuyerCommission;
                        $transaction->seller_earnings = $remainingAmount - $newSellerCommission;
                        $transaction->notes .= "\n[" . now()->format('Y-m-d H:i:s') . "] Partial refund by teacher: $" . $refundAmount;
                        $transaction->save();

                        \Log::info('Transaction partially refunded', [
                            'transaction_id' => $transaction->id,
                            'refund_amount' => $refundAmount,
                            'new_seller_earnings' => $transaction->seller_earnings
                        ]);
                    }
                }

            } catch (\Exception $e) {
                \Log::error('Teacher refund failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Refund failed: ' . $e->getMessage());
            }

            // ============ SCENARIO C: ACTIVE ORDER - AUTO REFUND BASED ON CLASSES ============
        } else if ($order->status == 1) {

            foreach ($classes as $class) {
                $classTime = \Carbon\Carbon::parse($class->$date)->timezone($class->$time_zone);
                $diffInHours = $now->diffInHours($classTime, false);

                if ($diffInHours > $reschedule_hours) {
                    $refundableClasses[] = $class;
                } else {
                    $nonRefundableClasses[] = $class;
                }
            }

            $refundableCount = count($refundableClasses);
            $totalClasses = count($classes);

            if ($totalClasses > 0 && $refundableCount > 0) {
                $pricePerClass = $order->finel_price / $order->frequency;
                $refundAmount = round($pricePerClass * $refundableCount, 2);
            }

            // Full class-based refund
            if ($totalClasses == $refundableCount && $order->freelance_service != 'Normal') {
                try {
                    $paymentIntent = PaymentIntent::retrieve($order->payment_id);
                    $canceledIntent = $paymentIntent->cancel();

                    $cancelOrder->refund = 1;
                    $cancelOrder->amount = $order->finel_price;
                    $order->refund = 1;

                    // ============ UPDATE TRANSACTION - FULL REFUND ============
                    $transaction = Transaction::where('buyer_id', $order->user_id)
                        ->where('seller_id', $order->teacher_id)
                        ->first();

                    if ($transaction) {
                        $transaction->markAsRefunded();
                        \Log::info('Transaction fully refunded (all classes refundable)', [
                            'transaction_id' => $transaction->id
                        ]);
                    }

                } catch (\Exception $e) {
                    \Log::error('Full refund failed: ' . $e->getMessage());
                    return redirect()->back()->with('error', 'Refund failed: ' . $e->getMessage());
                }
                // Partial class-based refund
            } else if ($refundAmount > 0 && $order->freelance_service != 'Normal') {
                try {
                    $paymentIntent = PaymentIntent::retrieve($order->payment_id);

                    if ($paymentIntent->status === 'requires_capture') {
                        $paymentIntent->capture();
                    }

                    if ($paymentIntent->status === 'succeeded') {
                        Refund::create([
                            'payment_intent' => $order->payment_id,
                            'amount' => round($refundAmount * 100)
                        ]);
                    }

                    $cancelOrder->refund = 1;
                    $cancelOrder->refund_type = 1;
                    $cancelOrder->amount = $refundAmount;
                    $order->refund = 1;

                    // ============ UPDATE TRANSACTION - PARTIAL REFUND ============
                    $transaction = Transaction::where('buyer_id', $order->user_id)
                        ->where('seller_id', $order->teacher_id)
                        ->first();

                    if ($transaction) {
                        $remainingAmount = $transaction->total_amount - $refundAmount;
                        $newSellerCommission = ($remainingAmount * $transaction->seller_commission_rate) / 100;
                        $newBuyerCommission = ($remainingAmount * $transaction->buyer_commission_rate) / 100;

                        $transaction->coupon_discount += $refundAmount;
                        $transaction->seller_commission_amount = $newSellerCommission;
                        $transaction->buyer_commission_amount = $newBuyerCommission;
                        $transaction->total_admin_commission = $newSellerCommission + $newBuyerCommission;
                        $transaction->seller_earnings = $remainingAmount - $newSellerCommission;
                        $transaction->notes .= "\n[" . now()->format('Y-m-d H:i:s') . "] Partial refund ({$refundableCount}/{$totalClasses} classes): $" . $refundAmount;
                        $transaction->save();

                        \Log::info('Transaction partially refunded (class-based)', [
                            'transaction_id' => $transaction->id,
                            'refundable_classes' => $refundableCount,
                            'total_classes' => $totalClasses,
                            'refund_amount' => $refundAmount
                        ]);
                    }

                } catch (\Exception $e) {
                    \Log::error('Partial refund failed: ' . $e->getMessage());
                    return redirect()->back()->with('error', 'Refund Failed: ' . $e->getMessage());
                }
            } else {
                // No refund
                $cancelOrder->refund = 0;
                $cancelOrder->amount = 0;
            }
        }

        // Cancel rescheduled classes
        $reschedules = ClassReschedule::where('order_id', $order->id)->where('status', 0)->get();
        if ($reschedules) {
            foreach ($reschedules as $reschedule) {
                $reschedule->status = 2;
                $reschedule->save();
            }
        }

        $cancelOrder->user_id = Auth::user()->id;
        $cancelOrder->user_role = Auth::user()->role;
        $cancelOrder->order_id = $order->id;
        $cancelOrder->reason = $request->reason;
        $cancelOrder->save();

        $order->status = 4;
        $order->payment_status = 'refunded';
        $order->action_date = Carbon::now()->format('Y-m-d H:i');
        $order->update();

        $buyerId = $order->user_id;
        $sellerId = $order->teacher_id;
        $buyerName = DB::table('users')->where('id', $buyerId)->value(DB::raw("CONCAT(first_name, ' ', last_name)"));
        $sellerName = DB::table('users')->where('id', $sellerId)->value(DB::raw("CONCAT(first_name, ' ', last_name)"));
        $serviceName = $order->title;
        $orderId = $order->id;
        $reason = $request->reason;

        $authId = Auth::user()->id;
        $adminIds = \App\Models\User::where('role', 2)->pluck('id')->toArray();


        if($authId == $buyerId){
            // Buyer cancelled - determine refund message
            $refundMessage = '';
            if ($cancelOrder->refund == 1) {
                if ($cancelOrder->amount == $order->finel_price) {
                    $refundMessage = 'Full refund of $' . number_format($cancelOrder->amount, 2) . ' has been processed.';
                } else {
                    $refundMessage = 'Partial refund of $' . number_format($cancelOrder->amount, 2) . ' has been processed.';
                }
            } else {
                $refundMessage = 'No refund is applicable for this cancellation.';
            }

            // To Buyer (Confirmation)
            $this->notificationService->send(
                userId: $buyerId,
                type: 'cancellation',
                title: 'Order Cancelled Successfully',
                message: 'You have successfully cancelled your order for ' . $serviceName . '. ' . $refundMessage,
                data: ['order_id' => $orderId, 'refund_amount' => $cancelOrder->amount, 'cancellation_reason' => $reason],
                sendEmail: true,
                actorUserId: $buyerId,
                targetUserId: $sellerId,
                orderId: $orderId,
                serviceId: $order->gig_id
            );

            // To Seller
            $this->notificationService->send(
                userId: $sellerId,
                type: 'cancellation',
                title: 'Order Cancelled by Buyer',
                message: $buyerName . ' has cancelled the order for ' . $serviceName . '. ' . $refundMessage,
                data: ['order_id' => $orderId, 'cancellation_reason' => $reason, 'refund_amount' => $cancelOrder->amount],
                sendEmail: true,
                actorUserId: $buyerId,
                targetUserId: $sellerId,
                orderId: $orderId,
                serviceId: $order->gig_id
            );

            // To admin
            $this->notificationService->sendToMultipleUsers(
                userIds: $adminIds,
                type: 'order',
                title: 'Order Cancelled by Buyer',
                message: $buyerName . ' cancelled order for ' . $serviceName . '. ' . $refundMessage,
                data: ['order_id' => $orderId, 'seller_id' => $sellerId, 'buyer_id' => $buyerId, 'refund_amount' => $cancelOrder->amount],
                sendEmail: false
            );

        }else{
            // Seller cancelled - determine refund message
            $refundMessage = '';
            if ($cancelOrder->refund == 1) {
                if ($cancelOrder->amount == $order->finel_price) {
                    $refundMessage = 'Full refund of $' . number_format($cancelOrder->amount, 2) . ' has been issued.';
                } else if ($cancelOrder->amount > 0) {
                    $refundMessage = 'Partial refund of $' . number_format($cancelOrder->amount, 2) . ' has been issued.';
                } else {
                    $refundMessage = 'No refund was processed.';
                }
            } else {
                $refundMessage = 'No refund is applicable.';
            }

            // To Buyer
            $this->notificationService->send(
                userId: $buyerId,
                type: 'cancellation',
                title: 'Order Cancelled by Seller',
                message: $sellerName . ' has cancelled your order for ' . $serviceName . '. ' . $refundMessage,
                data: ['order_id' => $orderId, 'refund_amount' => $cancelOrder->amount, 'cancellation_reason' => $reason],
                sendEmail: true,
                actorUserId: $sellerId,
                targetUserId: $buyerId,
                orderId: $orderId,
                serviceId: $order->gig_id
            );

            // To Seller (Confirmation)
            $this->notificationService->send(
                userId: $sellerId,
                type: 'cancellation',
                title: 'Order Cancelled Successfully',
                message: 'You have successfully cancelled the order for ' . $serviceName . '. ' . $refundMessage,
                data: ['order_id' => $orderId, 'refund_amount' => $cancelOrder->amount, 'cancellation_reason' => $reason],
                sendEmail: true,
                actorUserId: $sellerId,
                targetUserId: $buyerId,
                orderId: $orderId,
                serviceId: $order->gig_id
            );

            // To admin
            $this->notificationService->sendToMultipleUsers(
                userIds: $adminIds,
                type: 'order',
                title: 'Order Cancelled by Seller',
                message: $sellerName . ' cancelled order for ' . $serviceName . '. ' . $refundMessage,
                data: ['order_id' => $orderId, 'seller_id' => $sellerId, 'buyer_id' => $buyerId, 'refund_amount' => $cancelOrder->amount],
                sendEmail: false
            );
        }
        

        if ($order) {
            return redirect()->back()->with('success', 'Order canceled successfully' . ($refundAmount > 0 ? ' and refund initiated.' : '.'));
        } else {
            return redirect()->back()->with('error', 'Something went wrong, try again later!');
        }
    }

    // Deliver Order==========
    public function DeliverOrder($id)
    {
        if (!Auth::user()) {
            return redirect()->to('/')->with('error', 'Please LoginIn to Your Account!');
        } else {
            if (Auth::user()->role != 1) {
                return redirect()->to('/');
            }
        }

        $order = BookOrder::find($id);
        if ($order && $order->status == 1) {

            $classes = ClassReschedule::where(['order_id' => $order->id, 'status' => 0])->get();
            foreach ($classes as $key => $value) {
                $value->status = 2;
                $value->update();
            }
            $order->status = 2;
            $order->action_date = Date('M d, Y');
            $order->update();

            \Log::info('Order delivered', [
                'order_id' => $order->id,
                'seller_id' => $order->teacher_id
            ]);
        }

        // To Buyer
        $this->notificationService->send(
            userId: $order->user_id,
            type: 'delivery',
            title: 'Order Delivered',
            message: 'Your order has been marked as delivered. You have 48 hours to raise any concerns or request a refund.',
            data: ['order_id' => $order->id],
            sendEmail: true, // Email + notification
            actorUserId: $order->teacher_id,
            targetUserId: $order->user_id,
            orderId: $order->id,
            serviceId: $order->gig_id,
            emailTemplate: 'order-delivered'
        );

        // To Seller (confirmation)
        $seller = \App\Models\User::find($order->teacher_id);
        $buyer = \App\Models\User::find($order->user_id);
        $this->notificationService->send(
            userId: $order->teacher_id,
            type: 'delivery',
            title: 'Order Marked as Delivered',
            message: 'You have successfully marked order #' . $order->id . ' for "' . $order->title . '" as delivered. Buyer has 48 hours to review. Payment will be released after 48 hours if no disputes are raised.',
            data: ['order_id' => $order->id],
            sendEmail: true,
            actorUserId: $order->teacher_id,
            targetUserId: $order->user_id,
            orderId: $order->id,
            serviceId: $order->gig_id,
            emailTemplate: 'order-delivered'
        );

        // To Admin
        $this->notificationService->sendToMultipleUsers(
            userIds: $this->getAdminUserIds(),
            type: 'delivery',
            title: 'Order Delivered (Manual)',
            message: "Seller \"{$seller->first_name} {$seller->last_name}\" marked order #{$order->id} for \"{$order->title}\" as delivered. Buyer: \"{$buyer->first_name} {$buyer->last_name}\". 48-hour dispute window active.",
            data: [
                'order_id' => $order->id,
                'seller_name' => $seller->first_name . ' ' . $seller->last_name,
                'buyer_name' => $buyer->first_name . ' ' . $buyer->last_name,
                'service_name' => $order->title,
                'delivery_method' => 'manual',
            ],
            sendEmail: false,
            actorUserId: $order->teacher_id,
            targetUserId: $order->user_id,
            orderId: $order->id,
            serviceId: $order->gig_id
        );


        if ($order) {
            return redirect()->back()->with('success', 'Order Delivered Successfully!');
        } else {
            return redirect()->back()->with('error', 'Something went wrong, try again later!');
        }
    }

    // Dispute Order Function  ======Start
    public function DisputeOrder(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Login First!');
        }

        $order = BookOrder::find($request->order_id);
        if (!$order) {
            return redirect()->back()->with('error', 'Order Not Found!');
        }

        // Check if there's an existing dispute for this order
        $existingDispute = DisputeOrder::where('order_id', $order->id)->first();

        if ($existingDispute) {
            // UPDATE existing dispute record
            $dispute = $existingDispute;

            // Add reason based on who is disputing
            if (Auth::user()->role == 1) {
                // Teacher/Seller is counter-disputing
                $dispute->teacher_reason = $request->reason;
            } else {
                // User/Buyer is disputing
                $dispute->user_reason = $request->reason;
            }

            $dispute->save();
        } else {
            // CREATE new dispute record (first time)
            $dispute = new DisputeOrder();

            // Set initial values
            $dispute->user_id = Auth::user()->id;
            $dispute->user_role = Auth::user()->role;
            $dispute->order_id = $order->id;
            $dispute->refund = 1;
            $dispute->status = 0;

            // Default to full refund if buyer initiates dispute without specifying
            $dispute->refund_type = $request->refund ?? 0;
            $dispute->amount = $request->refund_amount ?? $order->finel_price;

            // Add reason based on who is disputing
            if (Auth::user()->role == 1) {
                $dispute->teacher_reason = $request->reason;
            } else {
                $dispute->user_reason = $request->reason;
            }

            $dispute->save();
        }

        // Update order dispute flags
        if (Auth::user()->role == 1) {
            $order->teacher_dispute = 1;
        } else {
            $order->user_dispute = 1;
        }

        $order->status = 4;
        $order->update();

        // ============ UPDATE TRANSACTION STATUS ============
        $transaction = Transaction::where('buyer_id', $order->user_id)
            ->where('seller_id', $order->teacher_id)
            ->first();

        if ($transaction) {
            $transaction->status = 'refunded'; // Pending admin decision
            $transaction->notes .= "\n[" . now()->format('Y-m-d H:i:s') . "] Dispute filed by " . (Auth::user()->role == 1 ? 'Seller' : 'Buyer');
            $transaction->save();

            \Log::info('Dispute filed', [
                'transaction_id' => $transaction->id,
                'order_id' => $order->id,
                'filed_by' => Auth::user()->role == 1 ? 'seller' : 'buyer'
            ]);
        }


        // If buyer filed dispute
        if (Auth::user()->role == 0) {
            // To Seller
            $this->notificationService->send(
                userId: $order->teacher_id,
                type: 'dispute',
                title: 'Refund Request Received',
                message: Auth::user()->first_name . ' has requested a refund. You have 48 hours to respond.',
                data: ['order_id' => $order->id, 'refund_amount' => $dispute->amount, 'dispute_id' => $dispute->id],
                sendEmail: true,
                actorUserId: Auth::id(),
                targetUserId: $order->teacher_id,
                orderId: $order->id,
                serviceId: $order->gig_id
            );

            // To Buyer (Confirmation)
            $this->notificationService->send(
                userId: Auth::id(),
                type: 'dispute',
                title: 'Refund Request Submitted',
                message: 'Your refund request has been submitted. The seller has 48 hours to respond.',
                data: ['order_id' => $order->id, 'refund_amount' => $dispute->amount],
                sendEmail: true,
                actorUserId: Auth::id(),
                targetUserId: $order->teacher_id,
                orderId: $order->id,
                serviceId: $order->gig_id
            );
        }

        // If seller filed dispute (rejecting buyer's refund)
        if (Auth::user()->role == 1) {
            // To Buyer
            $this->notificationService->send(
                userId: $order->user_id,
                type: 'dispute',
                title: 'Refund Disputed by Seller',
                message: 'The seller has disputed your refund request. An admin will review your case.',
                data: ['dispute_id' => $dispute->id, 'order_id' => $order->id],
                sendEmail: true,
                actorUserId: Auth::id(),
                targetUserId: $order->user_id,
                orderId: $order->id,
                serviceId: $order->gig_id
            );
        }

        // To Admin (for all disputes)
        $adminIds = User::where('role', 2)->pluck('id')->toArray();
        $this->notificationService->sendToMultipleUsers(
            userIds: $adminIds,
            type: 'dispute',
            title: 'Dispute Requires Review',
            message: 'Order #' . $order->id . ' has a dispute that requires admin review.',
            data: ['dispute_id' => $dispute->id, 'order_id' => $order->id],
            sendEmail: true
        );

        if ($order) {
            return redirect()->back()->with('success', 'Dispute Order Request Refund Submitted Successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong, try again later!');
        }
    }
    // Dispute Order Function  ======END

    // Accept Disputed Order and Give Refund =====
    public function AcceptDisputedOrder(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Login First!');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $id = $request->input('order_id');
        $order = BookOrder::where(['id' => $id, 'user_dispute' => 1, 'teacher_dispute' => 0])->first();

        if (!$order) {
            return back()->with('error', 'Order not found or not in delivered status.');
        }

        $dispute = DisputeOrder::where(['order_id' => $order->id, 'status' => 0])->first();

        if (!$dispute) {
            return redirect()->back()->with('error', 'No pending dispute found for this Order');
        }

        try {
            $paymentIntent = PaymentIntent::retrieve($order->payment_id);

            if ($dispute->refund_type == 0) {
                // Full refund
                if (in_array($paymentIntent->status, ['requires_capture', 'requires_confirmation', 'requires_payment_method'])) {
                    $paymentIntent->cancel();
                } elseif ($paymentIntent->status === 'succeeded') {
                    Refund::create(['payment_intent' => $order->payment_id]);
                }

                // ============ UPDATE TRANSACTION - FULL REFUND ============
                $transaction = Transaction::where('buyer_id', $order->user_id)
                    ->where('seller_id', $order->teacher_id)
                    ->first();

                if ($transaction) {
                    $transaction->markAsRefunded();
                    $transaction->payout_status = 'failed';
                    $transaction->notes .= "\n[" . now()->format('Y-m-d H:i:s') . "] Dispute resolved - Full refund approved";
                    $transaction->save();
                }

            } else {
                // Partial refund
                $refundAmount = floatval($dispute->amount);
                $finalPrice = floatval($order->finel_price);

                if (!$refundAmount || $refundAmount > $finalPrice) {
                    return redirect()->back()->with('error', 'Invalid refund amount for this Order');
                }

                if ($paymentIntent->status === 'requires_capture') {
                    $paymentIntent->capture();
                }

                if ($paymentIntent->status === 'succeeded') {
                    Refund::create([
                        'payment_intent' => $order->payment_id,
                        'amount' => round($refundAmount * 100)
                    ]);
                }

                // ============ UPDATE TRANSACTION - PARTIAL REFUND ============
                $transaction = Transaction::where('buyer_id', $order->user_id)
                    ->where('seller_id', $order->teacher_id)
                    ->first();

                if ($transaction) {
                    $remainingAmount = $transaction->total_amount - $refundAmount;
                    $newSellerCommission = ($remainingAmount * $transaction->seller_commission_rate) / 100;
                    $newBuyerCommission = ($remainingAmount * $transaction->buyer_commission_rate) / 100;

                    $transaction->coupon_discount += $refundAmount;
                    $transaction->seller_commission_amount = $newSellerCommission;
                    $transaction->buyer_commission_amount = $newBuyerCommission;
                    $transaction->total_admin_commission = $newSellerCommission + $newBuyerCommission;
                    $transaction->seller_earnings = $remainingAmount - $newSellerCommission;
                    $transaction->notes .= "\n[" . now()->format('Y-m-d H:i:s') . "] Dispute resolved - Partial refund: $" . $refundAmount;
                    $transaction->save();
                }
            }

            $dispute->status = 1;
            $dispute->save();

            $order->auto_dispute_processed = 0;
            $order->refund = 1;
            $order->payment_status = 'refunded';
            $order->save();

            // Notify buyer about dispute resolution
            $refundType = $dispute->refund_type == 0 ? 'Full' : 'Partial';
            $this->notificationService->send(
                userId: $order->user_id,
                type: 'dispute',
                title: 'Dispute Resolved',
                message: "Your dispute for order #{$order->id} has been resolved by admin. Decision: {$refundType} refund of \${$dispute->amount} approved.",
                data: [
                    'order_id' => $order->id,
                    'dispute_id' => $dispute->id,
                    'decision' => "{$refundType} refund approved",
                    'refund_amount' => $dispute->amount,
                    'resolved_at' => now()->toISOString(),
                    'resolved_by' => 'admin'
                ],
                sendEmail: true,
                actorUserId: $order->user_id,
                targetUserId: $order->teacher_id,
                orderId: $order->id,
                serviceId: $order->gig_id
            );

            // Notify seller about dispute resolution
            $this->notificationService->send(
                userId: $order->teacher_id,
                type: 'dispute',
                title: 'Dispute Resolved by Admin',
                message: "Dispute for order #{$order->id} has been resolved by admin. Decision: {$refundType} refund of \${$dispute->amount} to buyer.",
                data: [
                    'order_id' => $order->id,
                    'dispute_id' => $dispute->id,
                    'decision' => "{$refundType} refund to buyer",
                    'refund_amount' => $dispute->amount,
                    'resolved_at' => now()->toISOString(),
                    'resolved_by' => 'admin'
                ],
                sendEmail: true,
                actorUserId: $order->user_id,
                targetUserId: $order->teacher_id,
                orderId: $order->id,
                serviceId: $order->gig_id
            );

            \Log::info('Dispute resolved', [
                'order_id' => $order->id,
                'refund_type' => $dispute->refund_type == 0 ? 'full' : 'partial',
                'amount' => $dispute->amount
            ]);

        } catch (\Exception $e) {
            \Log::error('Dispute refund failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Refund failed for Order: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Refund request accepted for this Order');
    }
    //  Accept Disputed Order and Give Refund =====

    // Freelance Online Order Deliver ===================
    public function FreelanceOrderDeliver(Request $request)
    {
        if (!Auth::user()) {
            return redirect()->to('/')->with('error', 'Please login to your account!');
        }

        if (Auth::user()->role != 1) {
            return redirect()->to('/');
        }

        $request->validate([
            'order_id' => 'required|exists:book_orders,id',
            'file' => 'required|file|mimes:jpg,jpeg,png,mp4,avi,pdf,doc,docx,zip,rar|max:51200',
            'message' => 'required|string'
        ]);

        $order = BookOrder::find($request->order_id);

        if (!$order || $order->status != 1) {
            return redirect()->back()->with('error', 'Invalid order or already delivered.');
        }

        // Update class reschedules
        ClassReschedule::where(['order_id' => $order->id, 'status' => 0])
            ->update(['status' => 2]);

        // Handle file upload
        $fileName = null;
        if ($request->hasFile('file')) {
            $userFolder = "chat_media/" . $order->user_id . "_chat_files_" . Auth::id();
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path("assets/{$userFolder}"), $fileName);
        }

        // Create chat/message first (no button yet)
        $chat = Chat::create([
            'sender_id' => Auth::id(),
            'sender_role' => 1,
            'receiver_role' => 0,
            'receiver_id' => $order->user_id,
            'sms' => $request->message, // message only (we update after)
            'files' => $fileName,
            'order_id' => $order->id
        ]);

        // Now update ChatList
        $smsWithButton = $request->message . '<br>
    <button class="btn btn-danger unsatisfied-btn"
        data-order-id="' . $order->id . '"
        data-status="unsatisfied"
        data-message-id="' . $chat->id . '">
        Unsatisfied
    </button>';

        $havelist = ChatList::where(['user' => $order->user_id, 'teacher' => Auth::id(), 'type' => 0])->first();

        if ($havelist) {
            $havelist->update(['sms' => $smsWithButton]);
        } else {
            ChatList::create([
                'user' => $order->user_id,
                'teacher' => Auth::id(),
                'type' => 0,
                'sms' => $smsWithButton
            ]);
        }

        // Update chat with button
        $chat->sms = $smsWithButton;
        $chat->save();

        // Update order status
        $order->status = 2;
        $order->action_date = date('M d, Y');
        $order->save();

        return redirect()->back()->with('success', 'Order delivered and message sent successfully!');
    }
    // Freelance Online Order Deliver ===================

    // Back to Active Start =====
    public function BackToActive($id)
    {

        if (!Auth::check()) {
            return redirect('/')->with('error', 'Login First!');
        }


        // Get the order with status 2 (delivered)
        $order = BookOrder::where(['id' => $id, 'status' => 2])->first();

        if (!$order) {
            return back()->with('error', 'Order not found or not in delivered status.');
        }

        // Get the first class related to the order
        $class = ClassDate::where(['order_id' => $order->id])->first();

        if ($class) {
            // Extend both user_date and teacher_date by 7 days
            $class->user_date = Carbon::parse($class->user_date)->addDays(7);
            $class->teacher_date = Carbon::parse($class->teacher_date)->addDays(7);
            $class->save();
        }

        // Optionally update the order status back to active (1)
        $order->status = 1;
        $order->update();


        if ($order) {
            return back()->with('success', 'Order reactivated and class date extended by 7 days.');
        } else {
            return redirect()->back()->with('error', 'Something went rong,tryagain later!');
        }

    }
    // Back to Active END =====

    // Back to Active UnSetisfied Start =====
    public function UnSetisfiedDelivery(Request $request)
    {

        if (!Auth::check() || Auth::user()->role != 0) {
            return redirect('/')->with('error', 'Login First!');
        }


        // Get the order with status 2 (delivered)
        $order = BookOrder::where(['id' => $request->id, 'status' => 2])->first();

        if (!$order) {
            return response()->json(['error' => 'Order not found or not in delivered status.']);
        }

        // Get the first class related to the order
        $class = ClassDate::where(['order_id' => $order->id])->first();

        if ($class) {
            // Extend both user_date and teacher_date by 7 days
            $class->user_date = Carbon::parse($class->user_date)->addDays(7);
            $class->teacher_date = Carbon::parse($class->teacher_date)->addDays(7);
            $class->save();
        }

        // Optionally update the order status back to active (1)

        // Find chat message
        $chat = Chat::find($request->message);

        // If chat message exists
        if ($chat) {
            // Update SMS with disabled button
            $oldSms = $chat->sms;

            // Use regex or simple str_replace to update button
            // Example simple way: replace status="0" with status="1" and add disabled

            $newSms = str_replace(
                'data-status="0"',
                'data-status="1" disabled',
                $oldSms
            );

            // Save updated sms
            $chat->sms = $newSms;
            $chat->save();
        }

        $order->status = 1;
        $order->update();


        if ($order) {
            return response()->json(['success' => 'Order reactivated and class date extended by 7 days.']);
        } else {
            return response()->json(['error' => 'Something went rong,tryagain later!']);
        }

    }
    // Back to Active UnSetisfied Start =====

    //  Inperson Normal Freelance First Start Jon in Active Tab =====
    public function StartJobActive($id)
    {
        if (!Auth::check() || Auth::user()->role != 1) {
            return redirect('/')->with('error', 'Login First!');
        }

        $order = BookOrder::where(['id' => $id, 'status' => 1, 'start_job' => 0])->first();

        if (!$order) {
            return back()->with('error', 'Order not found!');
        }

        // ============ CAPTURE PAYMENT ON JOB START ============
        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $paymentIntent = \Stripe\PaymentIntent::retrieve($order->payment_id);

            if ($paymentIntent->status === 'requires_capture') {
                $paymentIntent->capture();

                \Log::info('Payment captured on job start', [
                    'order_id' => $order->id,
                    'payment_intent' => $order->payment_id
                ]);
            }

            // Update transaction if still pending
            $transaction = Transaction::where('buyer_id', $order->user_id)
                ->where('seller_id', $order->teacher_id)
                ->where('status', 'pending')
                ->first();

            if ($transaction) {
                $transaction->markAsCompleted($order->payment_id);
                \Log::info('Transaction completed on job start', [
                    'transaction_id' => $transaction->id
                ]);
            }

            $order->start_job = 1;
            $order->payment_status = 'completed';
            $order->save();

            return redirect()->back()->with('success', 'Job started successfully and payment captured.');

        } catch (\Exception $e) {
            \Log::error('Payment capture on job start failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to start job: ' . $e->getMessage());
        }
    }
    //  Inperson Normal Freelance First Start Jon in Active Tab =====

    // Reshedule Class Function start=====
    public function UserResheduleClass($id)
    {

        if (!Auth::user()) {
            return redirect()->to('/')->with('error', 'Please LoginIn to Your Account!');
        } else {
            if (Auth::user()->role != 0) {
                return redirect()->to('/');
            }
        }


        $admin_duration = BookingDuration::first();
        $reschedule_hours = (int)($admin_duration?->reschedule ?? 12);


        $user = Auth::user();

        $order = BookOrder::find($id);

        $teacher = User::find($order->teacher_id);
        $gig = TeacherGig::find($order->gig_id);
        $gigData = TeacherGigData::where(['gig_id' => $gig->id])->first();
        $gigPayment = TeacherGigPayment::where(['gig_id' => $gig->id])->first();
        $first_class = ClassDate::where(['order_id' => $id])->first();
        $TimeZone = $first_class->teacher_time_zone ?? 'UTC';

        $profile = ExpertProfile::where(['user_id' => $order->teacher_id, 'status' => 1])->first();

        $admin_duration = BookingDuration::first();
        $repeatDays = TeacherReapetDays::where(['gig_id' => $gig->id])->get();

        $allOrders = BookOrder::where('gig_id', $gig->id)->get();

        if ($gig->service_type == 'Online' && $gigData->freelance_service == 'Normal') {
            $class = ClassDate::where('order_id', $id)->get();
        } else {
            $cutoff = Carbon::now($TimeZone)->addHours($reschedule_hours);

            $class = ClassDate::where('order_id', $id)
                ->where(function ($query) use ($cutoff) {
                    $query->whereNull('user_date')
                        ->orWhere('user_date', '>', $cutoff);
                })
                ->get();
        }


        if ($gig->service_role == 'Class') {


            // Get booked orders & class dates in one step
            $OrderIds = BookOrder::where('teacher_id', $gig->user_id)->pluck('id')->toArray();
            $bookedTime = ClassDate::whereIn('order_id', $OrderIds)->pluck('user_date')->map(fn($date) => \Carbon\Carbon::parse($date)->format('Y-m-d H:i'))->toArray();


            $OrderIds = BookOrder::where('teacher_id', $gig->user_id)->pluck('id')->toArray();
            // Fetch booked slots with total people count
            // Fetch booked slots with total people count
            $bookedSlots = ClassDate::join('book_orders', 'class_dates.order_id', '=', 'book_orders.id')
                ->where('book_orders.gig_id', $gig->id)
                ->where('class_dates.order_id', '!=', $id)
                ->select('class_dates.user_date', 'class_dates.duration', 'book_orders.group_type', 'book_orders.total_people')
                ->get()
                ->groupBy('user_date')
                ->map(function ($slots) use ($gigData, $gigPayment) {
                    $firstSlot = $slots->first();
                    $totalPeople = $slots->sum('total_people');

                    // Check if the slot is fully booked based on group type
                    $isFullyBooked = false;

                    if ($gigData->lesson_type === 'One' || $gigData->group_type === 'Private') {
                        // Private or One-on-One lessons: Fully booked if any booking exists
                        $isFullyBooked = $totalPeople >= 1;
                    }

                    if ($gigData->group_type === 'Both' || $gigData->group_type === 'Public') {
                        // Public group: Remove slot if total booked people reached the max group size
                        if ($firstSlot->group_type === 'Public' && $totalPeople >= $gigPayment->public_group_size) {
                            $isFullyBooked = true;
                        }
                    }

                    // Include only non-fully booked slots
                    return $isFullyBooked ? null : [
                        'user_date' => $firstSlot->user_date,
                        'duration' => $firstSlot->duration ?? '00:30',
                        'group_type' => $firstSlot->group_type,
                        'total_people' => $totalPeople,
                    ];
                })
                ->filter()
                ->values();


            // Filter out fully reserved slots
            $availableSlots = [];
            foreach ($bookedSlots as $slot) {
                if ($gigData->lesson_type === 'One' || $gigData->group_type === 'Private') {
                    // Private or One-on-One lessons: Fully booked if any booking exists
                    continue;
                }
                if ($gigData->group_type === 'Both' || $gigData->group_type === 'Public') {
                    // Public group: Remove slot if total booked people reached the max group size
                    if ($slot['group_type'] === 'Public' && $slot['total_people'] >= $gigPayment->public_group_size) {
                        continue;
                    }
                }
                $availableSlots[] = $slot;
            }

            // Convert available slots to JSON for frontend
            $bookedTimes = json_encode($availableSlots, JSON_UNESCAPED_SLASHES);

            $booking_type = 'Class';

            // Pass gig availability details to the view
        } else {


            // FREELANCE SERVICE
            $bookedTime = [];

            if ($gigData->freelance_service === 'Consultation') {
                // Get actual booked slots for Consultation to block on frontend
                $OrderIds = BookOrder::where('teacher_id', $gig->user_id)->pluck('id')->toArray();

                $bookedSlots = ClassDate::join('book_orders', 'class_dates.order_id', '=', 'book_orders.id')
                    ->where('book_orders.gig_id', $gig->id)
                    ->where('class_dates.order_id', '!=', $id)
                    ->get(['class_dates.user_date', 'class_dates.duration', 'book_orders.group_type', 'book_orders.total_people'])
                    ->groupBy('teacher_date')
                    ->map(function ($slots) {
                        return [
                            'user_date' => $slots->first()->user_date,
                            'duration' => $slots->first()->duration ?? '00:30',
                            'group_type' => $slots->first()->group_type,
                            'total_people' => $slots->sum('total_people'),
                        ];
                    });

                $bookedTimes = json_encode($bookedSlots, JSON_UNESCAPED_SLASHES);
                $booking_type = 'Session';
            } else {

                $booking_type = 'Date';
                // NORMAL FREELANCE SERVICE → show all slots, no blocking
                $bookedTimes = json_encode([], JSON_UNESCAPED_SLASHES);
            }


            // Pass gig availability details to the view
        }


        if ($gig->service_role == 'Class') {
            return view('User-Dashboard.reschedule-classes', compact('order', 'gig', 'class', 'user', 'gigData', 'gigPayment', 'first_class', 'profile', 'repeatDays', 'bookedTime', 'allOrders', 'bookedTimes', 'admin_duration', 'booking_type', 'teacher'));
        } else {
            return view('User-Dashboard.reschedule-freelance', compact('order', 'gig', 'class', 'user', 'gigData', 'gigPayment', 'first_class', 'profile', 'repeatDays', 'bookedTime', 'allOrders', 'bookedTimes', 'admin_duration', 'booking_type', 'teacher'));
        }


    }
    // Reshedule Class Function END=====


    // User Reshedule Update ======Start
    function UpdateUserResheduleClass(Request $request)
    {

        if (!Auth::user()) {
            return redirect()->to('/')->with('error', 'Please LoginIn to Your Account!');
        } else {
            if (Auth::user()->role != 0) {
                return redirect()->to('/');
            }
        }

        // Get the old class times as an array
        $oldClassTimes = json_decode($request->input('old_class_time'), true);
        $admin_duration = BookingDuration::first();
        $reschedule_hours = (int)($admin_duration?->reschedule ?? 12);

        $order = BookOrder::find($request->order_id);
        $gig = TeacherGig::find($order->gig_id);
        $gigData = TeacherGigData::where(['gig_id' => $gig->id])->first();

        $first_class = ClassDate::where(['order_id' => $order->id])->first();
        $TimeZone = $first_class->teacher_time_zone ?? 'UTC';

        $cutoff = Carbon::now($TimeZone)->addHours($reschedule_hours);

        $classes = ClassDate::where('order_id', $request->order_id)
            ->where(function ($query) use ($cutoff) {
                $query->whereNull('user_date')
                    ->orWhere('user_date', '>', $cutoff);
            })
            ->get();
        $newUserDates = explode(',', $request->input('class_time'));
        $newTeacherDates = explode(',', $request->input('teacher_class_time'));


        // Check if the counts match to avoid mismatched updates
        if (count($classes) !== count($newUserDates)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mismatched number of class slots and new dates.'
            ], 400);
        }

        $reschedule = ClassReschedule::where('user_id', $order->user_id)
            ->where('teacher_id', $order->teacher_id)
            ->whereIn('class_id', $classes->pluck('id')->toArray())
            ->where('status', 0)
            ->get();


        // Pair new dates with their original index
        $datePairs = [];
        foreach ($newUserDates as $i => $userDate) {
            if (!empty($userDate) && isset($newTeacherDates[$i])) {
                $datePairs[] = [
                    'index' => $i,
                    'user_date' => $userDate,
                    'teacher_date' => $newTeacherDates[$i],
                ];
            }
        }

        // Sort the date pairs by teacher_date (ascending)
        usort($datePairs, function ($a, $b) {
            return strtotime($a['teacher_date']) <=> strtotime($b['teacher_date']);
        });

        // Re-order newUserDates and newTeacherDates by sorted teacher_date
        $newUserDates = array_column($datePairs, 'user_date');
        $newTeacherDates = array_column($datePairs, 'teacher_date');

        // Also sort $classes and $reschedule by teacher_date to match new order
        $classes = $classes->sortBy(function ($class) {
            return strtotime($class->teacher_date);
        })->values(); // reset keys

        $reschedule = $reschedule->sortBy(function ($class) {
            return strtotime($class->teacher_date);
        })->values(); // reset keys


        if (!$reschedule->isEmpty()) {
            // ✅ Update existing reschedule records
            foreach ($reschedule as $index => $class) {
                if ($class->user_date != $newUserDates[$index]) {

                    $class->user_date = $newUserDates[$index];
                    $class->teacher_date = $newTeacherDates[$index];
                    $class->update();
                }

            }
        } else {
            // ✅ Create new reschedule records
            foreach ($classes as $index => $class) {
                if ($class->user_date != $newUserDates[$index]) {
                    // Create new ClassReschedule record
                    ClassReschedule::create([
                        'order_id' => $order->id,
                        'class_id' => $class->id,
                        'user_id' => $order->user_id,
                        'teacher_id' => $order->teacher_id,
                        'user_date' => $newUserDates[$index],
                        'teacher_date' => $newTeacherDates[$index],
                        'status' => 0
                    ]);
                }

            }
        }

        $order->teacher_reschedule = 0;
        $order->user_reschedule = 1;
        $order->update();

        // Send notifications
        $buyer = Auth::user();
        $seller = User::find($order->teacher_id);
        $serviceName = $order->title;

        // Privacy-protected names
        $buyerMaskedName = \App\Helpers\NameHelper::getMaskedName($buyer);
        $sellerMaskedName = \App\Helpers\NameHelper::getMaskedName($seller);
        $buyerFullName = \App\Helpers\NameHelper::getFullName($buyer);
        $sellerFullName = \App\Helpers\NameHelper::getFullName($seller);

        // Notify Buyer (confirmation)
        $this->notificationService->send(
            userId: $order->user_id,
            type: 'reschedule',
            title: 'Reschedule Request Submitted',
            message: 'Your reschedule request for ' . $serviceName . ' has been submitted and is awaiting approval from ' . $sellerMaskedName . '.',
            data: ['order_id' => $order->id, 'reschedule_count' => count($classes)],
            sendEmail: false,
            actorUserId: $order->user_id,
            targetUserId: $order->teacher_id,
            orderId: $order->id,
            serviceId: $order->gig_id
        );

        // Notify Teacher (action required - masked buyer name for privacy)
        $this->notificationService->send(
            userId: $order->teacher_id,
            type: 'reschedule',
            title: 'Reschedule Request Received',
            message: $buyerMaskedName . ' has requested to reschedule ' . count($classes) . ' class(es) for ' . $serviceName . '. Please review and respond.',
            data: ['order_id' => $order->id, 'buyer_id' => $order->user_id, 'reschedule_count' => count($classes)],
            sendEmail: true,
            actorUserId: $order->user_id,
            targetUserId: $order->teacher_id,
            orderId: $order->id,
            serviceId: $order->gig_id,
            emailTemplate: 'reschedule-request-seller'
        );

        // Notify Admin (full names for tracking)
        $this->notificationService->sendToMultipleUsers(
            userIds: $this->getAdminUserIds(),
            type: 'reschedule',
            title: 'Reschedule Request - Buyer',
            message: "Buyer \"{$buyerFullName}\" requested reschedule for order #{$order->id} (\"{$serviceName}\"). Seller: \"{$sellerFullName}\". Awaiting seller approval.",
            data: [
                'order_id' => $order->id,
                'requester' => 'buyer',
                'buyer_name' => $buyerFullName,
                'seller_name' => $sellerFullName,
                'service_name' => $serviceName,
                'reschedule_count' => count($classes),
            ],
            sendEmail: false,
            actorUserId: $order->user_id,
            targetUserId: $order->teacher_id,
            orderId: $order->id,
            serviceId: $order->gig_id
        );

        if ($gig->service_role == 'Class') {
            return redirect()->to('/order-management')->with('success', 'Resheduled Classes Successfully!');
        } else if ($gigData->freelance_service == 'Consultation') {
            return redirect()->to('/order-management')->with('success', 'Resheduled Session Successfully!');
        } else {
            return redirect()->to('/order-management')->with('success', 'Extended Date Successfully!');
        }


    }
    // User Reshedule Update ======END


    // Teacher Reshedule Class Function start=====
    public function TeacherResheduleClass($id)
    {

        if (!Auth::user()) {
            return redirect()->to('/')->with('error', 'Please LoginIn to Your Account!');
        } else {
            if (Auth::user()->role != 1) {
                return redirect()->to('/');
            }
        }


        $admin_duration = BookingDuration::first();
        $reschedule_hours = (int)($admin_duration?->reschedule ?? 12);

        $user = Auth::user();

        $order = BookOrder::find($id);

        if ($order->teacher_reschedule_time == 1) {
            return redirect()->back()->with('error', 'Seller Allowed only 1 time reschedule in pending!');
        }

        $teacher = User::find($order->teacher_id);
        $gig = TeacherGig::find($order->gig_id);
        $gigData = TeacherGigData::where(['gig_id' => $gig->id])->first();
        $gigPayment = TeacherGigPayment::where(['gig_id' => $gig->id])->first();
        $first_class = ClassDate::where(['order_id' => $id])->first();
        $TimeZone = $first_class->teacher_time_zone ?? 'UTC';

        $profile = ExpertProfile::where(['user_id' => $order->teacher_id, 'status' => 1])->first();

        $admin_duration = BookingDuration::first();
        $repeatDays = TeacherReapetDays::where(['gig_id' => $gig->id])->get();

        $allOrders = BookOrder::where('gig_id', $gig->id)->get();
        if ($gig->service_type == 'Online' && $gigData->freelance_service == 'Normal') {
            $class = ClassDate::where('order_id', $id)->get();
        } else {
            $cutoff = Carbon::now($TimeZone)->addHours($reschedule_hours);

            $class = ClassDate::where('order_id', $id)
                ->where(function ($query) use ($cutoff) {
                    $query->whereNull('teacher_date')
                        ->orWhere('teacher_date', '>', $cutoff);
                })
                ->get();

        }


        if ($gig->service_role == 'Class') {


            // Get booked orders & class dates in one step
            $OrderIds = BookOrder::where('teacher_id', $gig->user_id)->pluck('id')->toArray();
            $bookedTime = ClassDate::whereIn('order_id', $OrderIds)->pluck('teacher_date')->map(fn($date) => \Carbon\Carbon::parse($date)->format('Y-m-d H:i'))->toArray();


            $OrderIds = BookOrder::where('teacher_id', $gig->user_id)->pluck('id')->toArray();
            // Fetch booked slots with total people count
            // Fetch booked slots with total people count
            $bookedSlots = ClassDate::join('book_orders', 'class_dates.order_id', '=', 'book_orders.id')
                ->where('book_orders.gig_id', $gig->id)
                ->where('class_dates.order_id', '!=', $id)
                ->select('class_dates.teacher_date', 'class_dates.duration', 'book_orders.group_type', 'book_orders.total_people')
                ->get()
                ->groupBy('teacher_date')
                ->map(function ($slots) use ($gigData, $gigPayment) {
                    $firstSlot = $slots->first();
                    $totalPeople = $slots->sum('total_people');

                    // Check if the slot is fully booked based on group type
                    $isFullyBooked = false;

                    if ($gigData->lesson_type === 'One' || $gigData->group_type === 'Private') {
                        // Private or One-on-One lessons: Fully booked if any booking exists
                        $isFullyBooked = $totalPeople >= 1;
                    }

                    if ($gigData->group_type === 'Both' || $gigData->group_type === 'Public') {
                        // Public group: Remove slot if total booked people reached the max group size
                        if ($firstSlot->group_type === 'Public' && $totalPeople >= $gigPayment->public_group_size) {
                            $isFullyBooked = true;
                        }
                    }

                    // Include only non-fully booked slots
                    return $isFullyBooked ? null : [
                        'teacher_date' => $firstSlot->teacher_date,
                        'duration' => $firstSlot->duration ?? '00:30',
                        'group_type' => $firstSlot->group_type,
                        'total_people' => $totalPeople,
                    ];
                })
                ->filter()
                ->values();


            // Filter out fully reserved slots
            $availableSlots = [];
            foreach ($bookedSlots as $slot) {
                if ($gigData->lesson_type === 'One' || $gigData->group_type === 'Private') {
                    // Private or One-on-One lessons: Fully booked if any booking exists
                    continue;
                }
                if ($gigData->group_type === 'Both' || $gigData->group_type === 'Public') {
                    // Public group: Remove slot if total booked people reached the max group size
                    if ($slot['group_type'] === 'Public' && $slot['total_people'] >= $gigPayment->public_group_size) {
                        continue;
                    }
                }
                $availableSlots[] = $slot;
            }

            // Convert available slots to JSON for frontend
            $bookedTimes = json_encode($availableSlots, JSON_UNESCAPED_SLASHES);

            $booking_type = 'Class';

            // Pass gig availability details to the view
        } else {


            // FREELANCE SERVICE
            $bookedTime = [];

            if ($gigData->freelance_service === 'Consultation') {
                // Get actual booked slots for Consultation to block on frontend
                $OrderIds = BookOrder::where('teacher_id', $gig->user_id)->pluck('id')->toArray();

                $bookedSlots = ClassDate::join('book_orders', 'class_dates.order_id', '=', 'book_orders.id')
                    ->where('book_orders.gig_id', $gig->id)
                    ->where('class_dates.order_id', '!=', $id)
                    ->get(['class_dates.teacher_date', 'class_dates.duration', 'book_orders.group_type', 'book_orders.total_people'])
                    ->groupBy('teacher_date')
                    ->map(function ($slots) {
                        return [
                            'teacher_date' => $slots->first()->teacher_date,
                            'duration' => $slots->first()->duration ?? '00:30',
                            'group_type' => $slots->first()->group_type,
                            'total_people' => $slots->sum('total_people'),
                        ];
                    });

                $bookedTimes = json_encode($bookedSlots, JSON_UNESCAPED_SLASHES);
                $booking_type = 'Session';
            } else {

                $booking_type = 'Date';
                // NORMAL FREELANCE SERVICE → show all slots, no blocking
                $bookedTimes = json_encode([], JSON_UNESCAPED_SLASHES);
            }


            // Pass gig availability details to the view
        }


        if ($gig->service_role == 'Class') {
            return view('Teacher-Dashboard.teacher-reschedule-classes', compact('order', 'gig', 'class', 'user', 'gigData', 'gigPayment', 'first_class', 'profile', 'repeatDays', 'bookedTime', 'allOrders', 'bookedTimes', 'admin_duration', 'booking_type', 'teacher'));
        } else {
            return view('Teacher-Dashboard.teacher-reschedule-freelance', compact('order', 'gig', 'class', 'user', 'gigData', 'gigPayment', 'first_class', 'profile', 'repeatDays', 'bookedTime', 'allOrders', 'bookedTimes', 'admin_duration', 'booking_type', 'teacher'));
        }


    }

    // Teacher Reshedule Class Function END=====


    // Teacher Reshedule Update ======Start
    function UpdateTeacherResheduleClass(Request $request)
    {

        if (!Auth::user()) {
            return redirect()->to('/')->with('error', 'Please LoginIn to Your Account!');
        } else {
            if (Auth::user()->role != 1) {
                return redirect()->to('/');
            }
        }

        // Get the old class times as an array
        $oldClassTimes = json_decode($request->input('old_class_time'), true);
        $admin_duration = BookingDuration::first();
        $reschedule_hours = (int)($admin_duration?->reschedule ?? 12);

        $order = BookOrder::find($request->order_id);
        $gig = TeacherGig::find($order->gig_id);
        $gigData = TeacherGigData::where(['gig_id' => $gig->id])->first();

        $first_class = ClassDate::where(['order_id' => $order->id])->first();
        $TimeZone = $first_class->teacher_time_zone ?? 'UTC';

        $cutoff = Carbon::now($TimeZone)->addHours($reschedule_hours);

        $classes = ClassDate::where('order_id', $request->order_id)
            ->where(function ($query) use ($cutoff) {
                $query->whereNull('teacher_date')
                    ->orWhere('teacher_date', '>', $cutoff);
            })
            ->get();
        $newUserDates = explode(',', $request->input('class_time'));
        $newTeacherDates = explode(',', $request->input('teacher_class_time'));


        // Check if the counts match to avoid mismatched updates
        if (count($classes) !== count($newUserDates)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mismatched number of class slots and new dates.'
            ], 400);
        }


        $reschedule = ClassReschedule::where('user_id', $order->user_id)
            ->where('teacher_id', $order->teacher_id)
            ->whereIn('class_id', $classes->pluck('id')->toArray())
            ->where('status', 0)
            ->get();


        // Pair new dates with their original index
        $datePairs = [];
        foreach ($newUserDates as $i => $userDate) {
            if (!empty($userDate) && isset($newTeacherDates[$i])) {
                $datePairs[] = [
                    'index' => $i,
                    'user_date' => $userDate,
                    'teacher_date' => $newTeacherDates[$i],
                ];
            }
        }

        // Sort the date pairs by teacher_date (ascending)
        usort($datePairs, function ($a, $b) {
            return strtotime($a['teacher_date']) <=> strtotime($b['teacher_date']);
        });

        // Re-order newUserDates and newTeacherDates by sorted teacher_date
        $newUserDates = array_column($datePairs, 'user_date');
        $newTeacherDates = array_column($datePairs, 'teacher_date');

        // Also sort $classes and $reschedule by teacher_date to match new order
        $classes = $classes->sortBy(function ($class) {
            return strtotime($class->teacher_date);
        })->values(); // reset keys

        $reschedule = $reschedule->sortBy(function ($class) {
            return strtotime($class->teacher_date);
        })->values(); // reset keys


        if (!$reschedule->isEmpty()) {
            // ✅ Update existing reschedule records
            foreach ($reschedule as $index => $class) {
                $class->user_date = $newUserDates[$index];
                $class->teacher_date = $newTeacherDates[$index];
                $class->update();
            }
        } else {
            // ✅ Create new reschedule records
            foreach ($classes as $index => $class) {
                // Create new ClassReschedule record
                ClassReschedule::create([
                    'order_id' => $order->id,
                    'class_id' => $class->id,
                    'user_id' => $order->user_id,
                    'teacher_id' => $order->teacher_id,
                    'user_date' => $newUserDates[$index],
                    'teacher_date' => $newTeacherDates[$index],
                    'status' => 0
                ]);
            }
        }


        $order->teacher_reschedule = 1;
        if ($order->status == 0) {
            $order->teacher_reschedule_time = 1;
        }
        $order->user_reschedule = 0;
        $order->update();

        // Send notifications - Privacy protected
        $seller = Auth::user();
        $buyer = User::find($order->user_id);
        $sellerMaskedName = \App\Helpers\NameHelper::getMaskedName($seller);
        $buyerMaskedName = \App\Helpers\NameHelper::getMaskedName($buyer);
        $sellerFullName = \App\Helpers\NameHelper::getFullName($seller);
        $buyerFullName = \App\Helpers\NameHelper::getFullName($buyer);
        $serviceName = $order->title;

        // Notify Teacher (confirmation - masked buyer name for privacy)
        $this->notificationService->send(
            userId: $order->teacher_id,
            type: 'reschedule',
            title: 'Reschedule Request Submitted',
            message: 'Your reschedule request for ' . $serviceName . ' has been submitted and is awaiting approval from ' . $buyerMaskedName . '.',
            data: ['order_id' => $order->id, 'reschedule_count' => count($classes)],
            sendEmail: false,
            actorUserId: $order->teacher_id,
            targetUserId: $order->user_id,
            orderId: $order->id,
            serviceId: $order->gig_id
        );

        // Notify Buyer (action required - masked seller name for privacy)
        $this->notificationService->send(
            userId: $order->user_id,
            type: 'reschedule',
            title: 'Seller Requested Reschedule',
            message: $sellerMaskedName . ' has requested to reschedule ' . count($classes) . ' class(es) for ' . $serviceName . '. Please review and respond.',
            data: ['order_id' => $order->id, 'seller_id' => $order->teacher_id, 'reschedule_count' => count($classes)],
            sendEmail: true,
            actorUserId: $order->teacher_id,
            targetUserId: $order->user_id,
            orderId: $order->id,
            serviceId: $order->gig_id,
            emailTemplate: 'reschedule-request-buyer'
        );

        // Notify Admin (full names for tracking)
        $this->notificationService->sendToMultipleUsers(
            userIds: $this->getAdminUserIds(),
            type: 'reschedule',
            title: 'Reschedule Request - Seller',
            message: "Seller \"{$sellerFullName}\" requested reschedule for order #{$order->id} (\"{$serviceName}\"). Buyer: \"{$buyerFullName}\". Awaiting buyer approval.",
            data: [
                'order_id' => $order->id,
                'requester' => 'seller',
                'buyer_name' => $buyerFullName,
                'seller_name' => $sellerFullName,
                'service_name' => $serviceName,
                'reschedule_count' => count($classes),
            ],
            sendEmail: false,
            actorUserId: $order->teacher_id,
            targetUserId: $order->user_id,
            orderId: $order->id,
            serviceId: $order->gig_id
        );

        if ($gig->service_role == 'Class') {
            return redirect()->to('/client-management')->with('success', 'Resheduled Classes Successfully!');
        } else if ($gigData->freelance_service == 'Consultation') {
            return redirect()->to('/client-management')->with('success', 'Resheduled Session Successfully!');
        } else {
            return redirect()->to('/client-management')->with('success', 'Extended Date Successfully!');
        }


    }
    // Teacher Reshedule Update ======END


    // Reshedule Accept Function Update Main Class ======Start

    function AcceptResheduleClass($id)
    {

        $order = BookOrder::find($id);

        $reschedule = ClassReschedule::where(['order_id' => $order->id, 'status' => 0])->get();

        if ($reschedule->isEmpty()) {
            return redirect()->back()->with('error', 'No reschedule records found.');
        }

        $classIds = $reschedule->pluck('class_id')->toArray();
        $classes = ClassDate::whereIn('id', $classIds)->get();

        if ($classes->isEmpty()) {
            return redirect()->back()->with('error', 'No matching class records found.');
        }

        // ✅ Update ClassDate records based on Reschedule data
        foreach ($classes as $class) {
            // Find the matching reschedule record for this class
            $matchingReschedule = $reschedule->firstWhere('class_id', $class->id);

            // Update user_date and teacher_date
            if ($matchingReschedule) {
                $class->user_date = $matchingReschedule->user_date;
                $class->teacher_date = $matchingReschedule->teacher_date;
                $matchingReschedule->status = 1;
                $class->update();
                $matchingReschedule->update();
            }
        }

        $order->teacher_reschedule = 0;
        $order->user_reschedule = 0;
        $order->update();

        // Privacy protection - masked names for buyer/seller, full names for admin
        $buyer = User::find($order->user_id);
        $seller = User::find($order->teacher_id);
        $buyerMaskedName = \App\Helpers\NameHelper::getMaskedName($buyer);
        $sellerMaskedName = \App\Helpers\NameHelper::getMaskedName($seller);
        $buyerFullName = \App\Helpers\NameHelper::getFullName($buyer);
        $sellerFullName = \App\Helpers\NameHelper::getFullName($seller);

        // If buyer accepted seller's reschedule
        if (Auth::user()->role == 0) {
            // To Seller (requester - masked buyer name for privacy)
            $this->notificationService->send(
                userId: $order->teacher_id,
                type: 'reschedule',
                title: 'Reschedule Accepted',
                message: $buyerMaskedName . ' has accepted your reschedule request for "' . $order->title . '".',
                data: ['order_id' => $order->id],
                sendEmail: true,
                actorUserId: $order->user_id,
                targetUserId: $order->teacher_id,
                orderId: $order->id,
                serviceId: $order->gig_id,
                emailTemplate: 'reschedule-approved'
            );

            // To Buyer (approver confirmation)
            $this->notificationService->send(
                userId: $order->user_id,
                type: 'reschedule',
                title: 'Reschedule Request Approved',
                message: 'You have approved the reschedule request for "' . $order->title . '".',
                data: ['order_id' => $order->id],
                sendEmail: true,
                actorUserId: $order->user_id,
                targetUserId: $order->teacher_id,
                orderId: $order->id,
                serviceId: $order->gig_id,
                emailTemplate: 'reschedule-approved'
            );
        }

        // If seller accepted buyer's reschedule
        if (Auth::user()->role == 1) {
            // To Buyer (requester - masked seller name for privacy)
            $this->notificationService->send(
                userId: $order->user_id,
                type: 'reschedule',
                title: 'Reschedule Accepted',
                message: $sellerMaskedName . ' has accepted your reschedule request for "' . $order->title . '".',
                data: ['order_id' => $order->id],
                sendEmail: true,
                actorUserId: $order->teacher_id,
                targetUserId: $order->user_id,
                orderId: $order->id,
                serviceId: $order->gig_id,
                emailTemplate: 'reschedule-approved'
            );

            // To Seller (approver confirmation)
            $this->notificationService->send(
                userId: $order->teacher_id,
                type: 'reschedule',
                title: 'Reschedule Request Approved',
                message: 'You have approved the reschedule request for "' . $order->title . '".',
                data: ['order_id' => $order->id],
                sendEmail: true,
                actorUserId: $order->teacher_id,
                targetUserId: $order->user_id,
                orderId: $order->id,
                serviceId: $order->gig_id,
                emailTemplate: 'reschedule-approved'
            );
        }

        // Notify Admin (full names for tracking)
        $requesterName = ($order->teacher_reschedule == 1) ? 'seller' : 'buyer';
        $approverName = (Auth::user()->role == 0) ? 'buyer' : 'seller';
        $this->notificationService->sendToMultipleUsers(
            userIds: $this->getAdminUserIds(),
            type: 'reschedule',
            title: 'Reschedule Request Accepted',
            message: "Reschedule accepted for order #{$order->id} (\"{$order->title}\"). Requested by {$requesterName}, approved by {$approverName}. Seller: \"{$sellerFullName}\", Buyer: \"{$buyerFullName}\".",
            data: [
                'order_id' => $order->id,
                'buyer_name' => $buyerFullName,
                'seller_name' => $sellerFullName,
                'service_name' => $order->title,
                'requester' => $requesterName,
                'approver' => $approverName,
            ],
            sendEmail: false,
            actorUserId: Auth::user()->id,
            targetUserId: (Auth::user()->role == 0) ? $order->teacher_id : $order->user_id,
            orderId: $order->id,
            serviceId: $order->gig_id
        );

        if ($classes) {
            return redirect()->back()->with('success', 'Reschedule Accepted Successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong,try again later!');
        }


    }
    // Reshedule Accept Function Update Main Class ======END


    // Reshedule Reject Function Update Main Class ======Start
    function RejectResheduleClass($id)
    {

        $order = BookOrder::find($id);

        $reschedule = ClassReschedule::where(['order_id' => $order->id, 'status' => 0])->get();

        if ($reschedule->isEmpty()) {
            return redirect()->back()->with('error', 'No reschedule records found.');
        }


        // ✅ Update ClassDate records based on Reschedule data
        foreach ($reschedule as $class) {
            $class->status = 2;
            $class->update();
        }

        // Determine who requested and who rejected
        $buyerRequested = ($order->user_reschedule == 1);
        $sellerRequested = ($order->teacher_reschedule == 1);

        // Privacy protection - masked names for buyer/seller, full names for admin
        $buyer = User::find($order->user_id);
        $seller = User::find($order->teacher_id);
        $buyerMaskedName = \App\Helpers\NameHelper::getMaskedName($buyer);
        $sellerMaskedName = \App\Helpers\NameHelper::getMaskedName($seller);
        $buyerFullName = \App\Helpers\NameHelper::getFullName($buyer);
        $sellerFullName = \App\Helpers\NameHelper::getFullName($seller);
        $serviceName = $order->title;

        $order->teacher_reschedule = 0;
        $order->user_reschedule = 0;
        $order->update();

        // Send notifications based on who requested
        if ($buyerRequested) {
            // Buyer requested, seller rejected
            // Notify Buyer (requester - masked seller name for privacy)
            $this->notificationService->send(
                userId: $order->user_id,
                type: 'reschedule',
                title: 'Reschedule Request Rejected',
                message: $sellerMaskedName . ' has rejected your reschedule request for ' . $serviceName . '.',
                data: ['order_id' => $order->id, 'rejected_by' => $order->teacher_id],
                sendEmail: true,
                actorUserId: $order->teacher_id,
                targetUserId: $order->user_id,
                orderId: $order->id,
                serviceId: $order->gig_id,
                emailTemplate: 'reschedule-rejected'
            );
        } elseif ($sellerRequested) {
            // Seller requested, buyer rejected
            // Notify Seller (requester - masked buyer name for privacy)
            $this->notificationService->send(
                userId: $order->teacher_id,
                type: 'reschedule',
                title: 'Reschedule Request Rejected',
                message: $buyerMaskedName . ' has rejected your reschedule request for ' . $serviceName . '.',
                data: ['order_id' => $order->user_id, 'rejected_by' => $order->user_id],
                sendEmail: true,
                actorUserId: $order->user_id,
                targetUserId: $order->teacher_id,
                orderId: $order->id,
                serviceId: $order->gig_id,
                emailTemplate: 'reschedule-rejected'
            );
        }

        // Notify Admin (full names for tracking)
        $requesterName = $buyerRequested ? 'buyer' : 'seller';
        $rejectorName = $buyerRequested ? 'seller' : 'buyer';
        $this->notificationService->sendToMultipleUsers(
            userIds: $this->getAdminUserIds(),
            type: 'reschedule',
            title: 'Reschedule Request Rejected',
            message: "Reschedule rejected for order #{$order->id} (\"{$serviceName}\"). Requested by {$requesterName}, rejected by {$rejectorName}. Seller: \"{$sellerFullName}\", Buyer: \"{$buyerFullName}\".",
            data: [
                'order_id' => $order->id,
                'buyer_name' => $buyerFullName,
                'seller_name' => $sellerFullName,
                'service_name' => $serviceName,
                'requester' => $requesterName,
                'rejector' => $rejectorName,
            ],
            sendEmail: false,
            actorUserId: Auth::user()->id,
            targetUserId: $buyerRequested ? $order->user_id : $order->teacher_id,
            orderId: $order->id,
            serviceId: $order->gig_id
        );

        if ($reschedule) {
            return redirect()->back()->with('success', 'Reschedule Rejected Successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong, try again later!');
        }


    }
    // Reshedule Reject Function Update Main Class ======END

    // Submit Review of Order ===========
    public function submitReview(Request $request)
    {
        if (!Auth::check() || Auth::user()->role != 0) {
            return redirect('/')->with('error', 'Login First!');
        }

        if ($request->order_id == null || $request->rating == 0) {
            return back()->with('error', 'Please Select Rating First!');
        }

        $request->validate([
            'order_id' => 'required|exists:book_orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'cmnt' => 'nullable|string|max:1000'
        ]);

        $order = BookOrder::find($request->order_id);

        if (!$order) {
            return back()->with('error', 'Order not found!');
        }

        // Check if review already exists
        $existingReview = ServiceReviews::where('order_id', $request->order_id)
            ->with(['replies'])
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReview && $existingReview->replies->count() > 0) {
            return redirect()->back()->with('error', 'You have already submitted a review for this order. You cannot edit it.');
        }

        if ($existingReview) {
            $existingReview->update([
                'rating' => $request->rating,
                'cmnt' => $request->cmnt
            ]);
        } else {
            $review = ServiceReviews::create([
                'user_id' => Auth::id(),
                'teacher_id' => $order->teacher_id,
                'gig_id' => $order->gig_id,
                'order_id' => $request->order_id,
                'rating' => $request->rating,
                'cmnt' => $request->cmnt
            ]);

            // Check for rating milestones
            if ($request->rating >= 4) { // Only count high ratings (4 or 5 stars)
                $highRatingCount = ServiceReviews::where('teacher_id', $order->teacher_id)
                    ->where('rating', '>=', 4)
                    ->count();

                $milestones = [10, 25, 50, 100, 250, 500, 1000];

                if (in_array($highRatingCount, $milestones)) {
                    try {
                        $this->notificationService->send(
                            userId: $order->teacher_id,
                            type: 'account',
                            title: 'Rating Milestone Achieved!',
                            message: "Congratulations! You've received {$highRatingCount} high ratings (4+ stars). Keep up the excellent work!",
                            data: [
                                'milestone' => $highRatingCount,
                                'total_reviews' => ServiceReviews::where('teacher_id', $order->teacher_id)->count(),
                                'average_rating' => ServiceReviews::where('teacher_id', $order->teacher_id)->avg('rating'),
                                'achieved_at' => now()->toISOString()
                            ],
                            sendEmail: true,
                            actorUserId: $order->teacher_id,
                            targetUserId: $order->teacher_id,
                            serviceId: $order->gig_id
                        );
                    } catch (\Exception $e) {
                        \Log::error('Failed to send milestone notification: ' . $e->getMessage());
                    }
                }
            }
        }

        // ============ AUTO-COMPLETE ORDER AFTER REVIEW ============
        if ($order->status == 2) { // Delivered
            $order->status = 3; // Completed
            $order->action_date = now()->format('Y-m-d H:i:s');
            $order->save();

            // Update transaction notes (payout remains pending for admin)
            $transaction = Transaction::where('buyer_id', $order->user_id)
                ->where('seller_id', $order->teacher_id)
                ->first();

            if ($transaction && $transaction->payout_status == 'pending') {
                $transaction->notes .= "\n[" . now()->format('Y-m-d H:i:s') . "] Buyer submitted review (Rating: {$request->rating}/5) - Ready for payout";
                $transaction->save();

                \Log::info('Order completed with review', [
                    'order_id' => $order->id,
                    'transaction_id' => $transaction->id,
                    'rating' => $request->rating
                ]);
            }
        }


        // To Seller (optional)
        $this->notificationService->send(
            userId: $order->teacher_id,
            type: 'review',
            title: 'New Review Received',
            message: 'You received a ' . $request->rating . '-star review from ' . Auth::user()->first_name,
            data: ['order_id' => $order->id, 'rating' => $request->rating],
            sendEmail: false,
            actorUserId: Auth::id(),
            targetUserId: $order->teacher_id,
            orderId: $order->id,
            serviceId: $order->gig_id
        );

        return redirect()->back()->with('success', 'Thank you for your review!');
    }
    public function deleteReview($review_id)
    {
        ServiceReviews::where('id', $review_id)
            ->where('user_id', Auth::id())
            ->delete();
        return redirect()->back()->with('success', 'Your review has been deleted.');
    }


    /**
     * Display all reviews with search and filter
     */
    public function getAllReviews(Request $request)
    {
        $query = ServiceReviews::with(['teacher', 'gig', 'order'])
            ->where('user_id', Auth::id())
            ->whereNull('parent_id'); // Only get main reviews, not replies

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('cmnt', 'like', "%{$search}%")
                    ->orWhere('rating', 'like', "%{$search}%")
                    ->orWhereHas('gig', function ($gigQuery) use ($search) {
                        $gigQuery->where('title', 'like', "%{$search}%");
                    })
                    ->orWhereHas('order', function ($orderQuery) use ($search) {
                        $orderQuery->where('order_number', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by service type
        if ($request->filled('service_type')) {
            if ($request->service_type == 'gig') {
                $query->whereNotNull('gig_id');
            } elseif ($request->service_type == 'order') {
                $query->whereNotNull('order_id');
            }
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $reviews = $query->latest()->paginate(10);

        return view('User-Dashboard.reviews', compact('reviews'));
    }

    public function getSingleReview($id)
    {
        $review = ServiceReviews::with(['teacher', 'gig', 'order', 'replies.teacher'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'review' => $review,
            'can_edit' => $review->replies->isEmpty(),
            'service_title' => $this->getServiceTitle($review),
            'service_type' => $this->getServiceType($review),
            'service_image' => $this->getServiceImage($review)
        ]);
    }

    private function getServiceTitle($review)
    {
        if ($review->gig) {
            return $review->gig->title ?? 'N/A';
        } elseif ($review->order) {
            return $review->order->service_title ?? 'Order #' . $review->order->order_number;
        }
        return 'N/A';
    }

    /**
     * Get service type
     */
    private function getServiceType($review)
    {
        if ($review->gig_id) {
            return 'Freelance Service';
        } elseif ($review->order_id) {
            return 'Order Service';
        }
        return 'N/A';
    }

    /**
     * Get service image
     */
    private function getServiceImage($review)
    {
        if ($review->gig && $review->gig->image) {
            return asset('storage/' . $review->gig->image);
        } elseif ($review->order && $review->order->image) {
            return asset('storage/' . $review->order->image);
        }
        return asset('assets/user/asset/img/table img.jpeg');
    }

    public function updateReview(Request $request, $id)
    {
        $review = ServiceReviews::where('user_id', Auth::id())
            ->whereNull('parent_id')
            ->findOrFail($id);

        // Check if seller has replied
        if ($review->replies->isNotEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot edit review after seller has replied.'
            ], 403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'cmnt' => 'nullable|string|max:1000'
        ]);

        $review->update([
            'rating' => $request->rating,
            'cmnt' => $request->cmnt,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review updated successfully!',
            'review' => $review
        ]);
    }

    /**
     * Get transaction for an order
     */
    private function getTransactionForOrder($order)
    {
        return Transaction::where('buyer_id', $order->user_id)
            ->where('seller_id', $order->teacher_id)
            ->where(function($query) use ($order) {
                $query->where('service_id', $order->gig_id)
                    ->orWhereHas('bookOrder', function($q) use ($order) {
                        $q->where('id', $order->id);
                    });
            })
            ->first();
    }

    /**
     * Log transaction status change
     */
    private function logTransactionChange($transaction, $event, $additionalData = [])
    {
        \Log::info('Transaction status changed', array_merge([
            'transaction_id' => $transaction->id,
            'event' => $event,
            'status' => $transaction->status,
            'payout_status' => $transaction->payout_status,
            'timestamp' => now()->format('Y-m-d H:i:s')
        ], $additionalData));
    }

    /**
     * Capture Stripe payment safely
     */
    private function captureStripePayment($paymentIntentId)
    {
        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

            if ($paymentIntent->status === 'requires_capture') {
                $paymentIntent->capture();
                return ['success' => true, 'message' => 'Payment captured'];
            }

            return ['success' => true, 'message' => 'Payment already captured'];

        } catch (\Exception $e) {
            \Log::error('Payment capture failed: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Admin Order Details Page
     * Shows complete order information for admins
     */
    public function adminOrderDetails($id)
    {
        // Debug logging
        \Log::info('Admin Order Details accessed', [
            'user_id' => auth()->id(),
            'user_role' => auth()->user()->role,
            'order_id' => $id
        ]);

        // Check admin authorization
        if (auth()->user()->role != 2) {
            \Log::error('Admin access denied - wrong role', ['role' => auth()->user()->role]);
            abort(403, 'Unauthorized access - Admin role required');
        }

        // Load order with existing relationships
        $order = BookOrder::with([
            'transaction',
            'user:id,first_name,last_name,email,profile',
            'teacher:id,first_name,last_name,email,profile',
            'gig.teacherGigData',
            'gig.category',
            'classDates'
        ])->findOrFail($id);

        // Manually load related data that doesn't have relationships
        $order->classReschedules = ClassReschedule::where('order_id', $id)->get();

        $order->reviews = ServiceReviews::with(['user:id,first_name,last_name'])
            ->where('order_id', $id)
            ->whereNull('parent_id')
            ->get();

        $order->cancelOrder = CancelOrder::where('order_id', $id)->first();
        $order->disputeOrder = DisputeOrder::where('order_id', $id)->first();

        return view('Admin-Dashboard.order-details', compact('order'));
    }

    /**
     * Teacher Order Details Page
     * Shows order information for the teacher/seller
     */
    public function teacherOrderDetails($id)
    {
        // Debug logging
        \Log::info('Teacher Order Details accessed', [
            'user_id' => auth()->id(),
            'user_role' => auth()->user()->role,
            'order_id' => $id
        ]);

        // Check teacher authorization
        if (auth()->user()->role != 1) {
            \Log::error('Teacher access denied - wrong role', ['role' => auth()->user()->role]);
            abort(403, 'Unauthorized access - Teacher role required');
        }

        // Load order with existing relationships
        $order = BookOrder::with([
            'transaction',
            'user:id,first_name,last_name,email,profile',
            'teacher:id,first_name,last_name,email,profile',
            'gig.teacherGigData',
            'gig.category',
            'classDates'
        ])->findOrFail($id);

        // Verify this order belongs to the logged-in teacher
        if ($order->teacher_id != auth()->id()) {
            \Log::error('Teacher access denied - not their order', [
                'teacher_id' => auth()->id(),
                'order_teacher_id' => $order->teacher_id
            ]);
            abort(403, 'TEACHER: You do not have permission to view this order');
        }

        // Manually load related data that doesn't have relationships
        $order->classReschedules = ClassReschedule::where('order_id', $id)->get();

        $order->reviews = ServiceReviews::with(['user:id,first_name,last_name'])
            ->where('order_id', $id)
            ->whereNull('parent_id')
            ->get();

        $order->cancelOrder = CancelOrder::where('order_id', $id)->first();
        $order->disputeOrder = DisputeOrder::where('order_id', $id)->first();

        return view('Teacher-Dashboard.order-details', compact('order'));
    }

    /**
     * User/Buyer Order Details Page
     * Shows order information for the buyer
     */
    public function userOrderDetails($id)
    {
        // Debug logging
        \Log::info('User Order Details accessed', [
            'user_id' => auth()->id(),
            'user_role' => auth()->user()->role,
            'order_id' => $id
        ]);

        // Check user authorization (buyer)
        if (auth()->user()->role != 0) {
            \Log::error('User access denied - wrong role', ['role' => auth()->user()->role]);
            abort(403, 'Unauthorized access - User role required');
        }

        // Load order with existing relationships
        $order = BookOrder::with([
            'transaction',
            'user:id,first_name,last_name,email,profile',
            'teacher:id,first_name,last_name,email,profile',
            'gig.teacherGigData',
            'gig.category',
            'classDates'
        ])->findOrFail($id);

        // Verify this order belongs to the logged-in user
        if ($order->user_id != auth()->id()) {
            \Log::error('User access denied - not their order', [
                'user_id' => auth()->id(),
                'order_user_id' => $order->user_id
            ]);
            abort(403, 'USER: You do not have permission to view this order');
        }

        // Manually load related data that doesn't have relationships
        $order->classReschedules = ClassReschedule::where('order_id', $id)->get();

        $order->reviews = ServiceReviews::with(['user:id,first_name,last_name'])
            ->where('order_id', $id)
            ->whereNull('parent_id')
            ->get();

        $order->cancelOrder = CancelOrder::where('order_id', $id)->first();
        $order->disputeOrder = DisputeOrder::where('order_id', $id)->first();

        return view('User-Dashboard.order-details', compact('order'));
    }

    /**
     * Get all admin user IDs
     * @return array
     */
    private function getAdminUserIds(): array
    {
        return \App\Models\User::where('role', 2)->pluck('id')->toArray();
    }

}