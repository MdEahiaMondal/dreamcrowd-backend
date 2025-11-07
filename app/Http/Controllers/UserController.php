<?php

namespace App\Http\Controllers;

use App\Mail\ChangeEmail;
use App\Mail\ContactMail;
use App\Models\BankDetails;
use App\Models\DeleteAccounts;
use Illuminate\Support\Facades\Auth;
use App\Models\Faqs;
use App\Models\PannelFaqs;
use App\Models\User;
use App\Models\WishList;
use App\Models\BookOrder;
use App\Models\CancelOrder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\NotificationService;
use App\Services\UserDashboardService;

class UserController extends Controller
{
    protected $dashboardService;

    public function __construct(UserDashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function UsercheckAuth()
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
    }

    public function UserDashboard()
    {

        if ($redirect = $this->UsercheckAuth()) {
            return $redirect;
        }

        $userId = Auth::id();

        // Base query for user-specific orders
        $baseQuery = BookOrder::where('user_id', $userId);

        // === COUNT STATISTICS ===
        $stats = [
            'all_orders'        => $baseQuery->clone()->count(),

            // Class orders (based on TeacherGig service_role)
            'class_orders'      => $baseQuery->clone()->whereHas('gig', function ($q) {
                $q->where('service_role', 'Class');
            })->count(),

            // Freelancer orders (based on TeacherGig freelance_service)
            'freelancer_orders' => $baseQuery->clone()->whereHas('gig', function ($q) {
                $q->where('service_role', 'Freelance');
            })->count(),

            // Status-based counts
            'completed_orders'  =>  $baseQuery->clone()->where('status', 3)->count(),

            'cancelled_orders'  =>  $baseQuery->clone()->where('status', 4)->count(),

            'active_orders'     => $baseQuery->clone()->where('status', 1)->count(),

            // Work site-based counts
            'online_orders' => $baseQuery->clone()->whereHas('gig', function ($q) {
                $q->where('service_type', 'Online');
            })->count(),

            'inperson_orders' => $baseQuery->clone()->whereHas('gig', function ($q) {
                $q->where('service_type', 'Inperson');
            })->count(),

        ];

        // === RECENT BOOKINGS ===
        $recentBookings = BookOrder::where('user_id', $userId)
            ->with(['gig', 'teacher'])
            ->latest()
            ->take(9)
            ->get();


        return view("User-Dashboard.index", compact(['stats', 'recentBookings']));
    }


    public function UserFaqs()
    {

        if ($redirect = $this->UsercheckAuth()) {
            return $redirect;
        }



        $faqs = PannelFaqs::where(['type' => 'buyer'])->get();
        return view("User-Dashboard.faq", compact('faqs'));
    }


    public function profile()
    {
        $user = Auth::user();
        return view("common.profile", compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'country'    => 'nullable|string|max:100',
            'profile'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('profile')) {
            $filename = time() . '.' . $request->profile->extension();
            $request->profile->move(public_path('uploads/profiles'), $filename);
            $user->profile = 'uploads/profiles/' . $filename;
        }

        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->country    = $request->country;
        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }



    public function ChangePassword()
    {

        if (Auth::user()->role == 2) {
            return redirect('/admin-dashboard');
        }

        return view("User-Dashboard.change-pass");
    }



    public function ChangeEmail()
    {

        if (Auth::user()->role == 2) {
            return redirect('/admin-dashboard');
        }
        return view("User-Dashboard.change-email");
    }



    public function ChangeCardDetail()
    {

        if (Auth::user()->role == 2) {
            return redirect('/admin-dashboard');
        }

        $bank_details = BankDetails::where(['user_id' => Auth::user()->id])->first();
        return view("User-Dashboard.card-detail", compact('bank_details'));
    }



    public function DeleteAccount(Request $request)
    {

        if (!Auth::user()) {
            return redirect('/');
        }

        if (Auth::user()->role == 2) {
            return redirect('/admin-dashboard');
        }

        $user = User::find(Auth::user()->id);

        if ($request->mainOptions == 'option1') {

            $delete_account = DeleteAccounts::create([
                'user_id' => $user->id,
                'user_email' => $user->email,
                'reason' => "I completed a job and don't need Dreamcrowd anymore",
            ]);

            if ($delete_account) {
                $user->delete();
                Auth::logout();
                return redirect()->to('/')->with('success', 'Account Deleted!');
            } else {
                return redirect()->back()->with('error', 'Something Went Rong,Tryagain Later!');
            }
        } elseif ($request->mainOptions == 'option2') {

            $delete_account = DeleteAccounts::create([
                'user_id' => $user->id,
                'user_email' => $user->email,
                'reason' => "I find it hard to use Dreamcrowd",
                'additional_reason' => $request->additionalOption2,
            ]);

            if ($delete_account) {
                $user->delete();
                Auth::logout();
                return redirect()->to('/')->with('success', 'Account Deleted!');
            } else {
                return redirect()->back()->with('error', 'Something Went Rong,Tryagain Later!');
            }
        } elseif ($request->mainOptions == 'option3') {

            $delete_account = DeleteAccounts::create([
                'user_id' => $user->id,
                'user_email' => $user->email,
                'reason' => "I am struggling to find jobs",
            ]);

            if ($delete_account) {
                $user->delete();
                Auth::logout();
                return redirect()->to('/')->with('success', 'Account Deleted!');
            } else {
                return redirect()->back()->with('error', 'Something Went Rong,Tryagain Later!');
            }
        } else {

            $delete_account = DeleteAccounts::create([
                'user_id' => $user->id,
                'user_email' => $user->email,
                'reason' => "Other reasons",
                'additional_reason' => $request->additionalOption4,
            ]);

            if ($delete_account) {
                $user->delete();
                Auth::logout();
                return redirect()->to('/')->with('success', 'Account Deleted!');
            } else {
                return redirect()->back()->with('error', 'Something Went Rong,Tryagain Later!');
            }
        }
    }


    // Contact Us Functions Start================
    public function UserContactUs()
    {


        if (!Auth::user()) {
            return redirect('/');
        }

        if (Auth::user()->role == 2) {
            return redirect('/admin-dashboard');
        }

        return view("User-Dashboard.contact");
    }

    public function ContactMail(Request $request)
    {


        if ($request->msg == null) {
            return redirect()->back()->with('error', 'Please Write a Text Message!');
        }

        $mailData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'subject' => $request->subject,
            'msg' => $request->msg,
        ];
        $name = $request->first_name . ' ' . $request->last_name;
        $subject = $request->subject;
        $mail = $request->email;
        $mail_send =  Mail::to('ma2550645@gmail.com')->send(new ContactMail($mailData, $subject, $name, $mail));
        //    $mail_send =  Mail::to('dreamcrowd@bravemindstudio.com')->send(new ContactMail($mailData, $subject,$name, $mail));

        if ($mail_send) {
            return redirect()->back()->with('success', 'Hi there, We will back to you soon!');
        } else {
            return redirect()->back()->with('error', 'Something Went Rong, Tryagain Later!');
        }
    }
    // Contact Us Functions End================


    // Wish List Functions Start================

    public function WishList()
    {

        if ($redirect = $this->UsercheckAuth()) {
            return $redirect;
        }

        $list = WishList::where(['user_id' => Auth::user()->id])->get();

        return view("User-Dashboard.wishlist", compact('list'));
    }


    public function RemoveWishList($id)
    {

        if ($redirect = $this->UsercheckAuth()) {
            return $redirect;
        }

        $list = WishList::where(['id' => $id])->first();

        $list->delete();
        if ($list) {


            return redirect()->back()->with('info', 'Service Removed From List!');
        } else {
            return redirect()->back()->with('error', 'Something Went Rong,Tryagain Later!');
        }
    }


    // Wish List Functions END================


    // ============================================================
    // AJAX DASHBOARD ENDPOINTS
    // ============================================================

    /**
     * Get dashboard statistics with date filters (AJAX)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDashboardStatistics(Request $request)
    {
        try {
            $userId = Auth::id();

            // Get date range from preset or custom dates
            $datePreset = $request->input('date_preset', 'all_time');

            if ($datePreset === 'custom') {
                $dateFrom = $request->input('date_from');
                $dateTo = $request->input('date_to');
            } else {
                $dates = $this->dashboardService->applyDatePreset($datePreset);
                $dateFrom = $dates['from'];
                $dateTo = $dates['to'];
            }

            // Get all statistics
            $statistics = $this->dashboardService->getAllStatistics($userId, $dateFrom, $dateTo);

            return response()->json([
                'success' => true,
                'data' => $statistics
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching statistics: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get chart data (AJAX)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChartData(Request $request)
    {
        try {
            $userId = Auth::id();
            $chartType = $request->input('chart_type', 'spending_trend');
            $months = $request->input('months', 6);
            $dateFrom = $request->input('date_from');
            $dateTo = $request->input('date_to');

            $data = [];

            switch ($chartType) {
                case 'spending_trend':
                    $data = $this->dashboardService->getMonthlyTrendData($userId, $months);
                    break;

                case 'status_breakdown':
                    $data = $this->dashboardService->getOrderStatusBreakdown($userId, $dateFrom, $dateTo);
                    break;

                case 'category_distribution':
                    $data = $this->dashboardService->getCategoryDistribution($userId, $dateFrom, $dateTo, 5);
                    break;

                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid chart type'
                    ], 400);
            }

            return response()->json([
                'success' => true,
                'chart_type' => $chartType,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching chart data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get paginated transactions for table (AJAX)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDashboardTransactions(Request $request)
    {
        try {
            $userId = Auth::id();
            $perPage = $request->input('per_page', 15);
            $page = $request->input('page', 1);

            $transactions = $this->dashboardService->getRecentTransactions($userId, $perPage, $page);

            // Format data for frontend
            $formattedData = $transactions->map(function ($order) {
                return [
                    'id' => $order->id,
                    'date' => $order->created_at->format('M d, Y H:i'),
                    'service_name' => $order->gig->title ?? 'N/A',
                    'service_category' => $order->gig->category_name ?? 'N/A',
                    'seller_name' => $order->teacher->name ?? 'N/A',
                    'seller_avatar' => $order->teacher->avatar ?? null,
                    'amount' => $order->price ?? 0,
                    'service_fee' => $order->buyer_commission ?? 0,
                    'discount' => $order->discount ?? 0,
                    'final_price' => $order->finel_price ?? 0,
                    'status' => $order->status,
                    'status_label' => $this->getStatusLabel($order->status),
                    'status_color' => $this->getStatusColor($order->status),
                    'payment_method' => 'Stripe',
                    'coupon_code' => $order->coupen ?? null,
                    'view_url' => route('order.details', $order->id),
                ];
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'current_page' => $transactions->currentPage(),
                    'data' => $formattedData,
                    'per_page' => $transactions->perPage(),
                    'total' => $transactions->total(),
                    'last_page' => $transactions->lastPage(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching transactions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export dashboard to PDF
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportDashboardPDF(Request $request)
    {
        try {
            $userId = Auth::id();
            $user = Auth::user();

            // Get date range
            $datePreset = $request->input('date_preset', 'all_time');
            if ($datePreset === 'custom') {
                $dateFrom = $request->input('date_from');
                $dateTo = $request->input('date_to');
            } else {
                $dates = $this->dashboardService->applyDatePreset($datePreset);
                $dateFrom = $dates['from'];
                $dateTo = $dates['to'];
            }

            // Get statistics
            $statistics = $this->dashboardService->getAllStatistics($userId, $dateFrom, $dateTo);
            $transactions = $this->dashboardService->getRecentTransactions($userId, 50, 1);

            // Generate PDF
            $pdf = \PDF::loadView('exports.dashboard-pdf', [
                'user' => $user,
                'stats' => $statistics,
                'transactions' => $transactions,
                'dateRange' => [
                    'from' => $dateFrom ? \Carbon\Carbon::parse($dateFrom)->format('M d, Y') : 'All Time',
                    'to' => $dateTo ? \Carbon\Carbon::parse($dateTo)->format('M d, Y') : 'Present',
                ],
                'generatedAt' => now()->format('M d, Y H:i:s')
            ]);

            return $pdf->download('dashboard-report-' . now()->format('Y-m-d') . '.pdf');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error generating PDF: ' . $e->getMessage());
        }
    }

    /**
     * Export dashboard to Excel
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportDashboardExcel(Request $request)
    {
        try {
            $userId = Auth::id();

            // Get date range
            $datePreset = $request->input('date_preset', 'all_time');
            if ($datePreset === 'custom') {
                $dateFrom = $request->input('date_from');
                $dateTo = $request->input('date_to');
            } else {
                $dates = $this->dashboardService->applyDatePreset($datePreset);
                $dateFrom = $dates['from'];
                $dateTo = $dates['to'];
            }

            return \Excel::download(
                new \App\Exports\UserDashboardExport($userId, $dateFrom, $dateTo),
                'dashboard-data-' . now()->format('Y-m-d') . '.xlsx'
            );

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error generating Excel: ' . $e->getMessage());
        }
    }

    /**
     * Helper: Get status label
     */
    private function getStatusLabel($status)
    {
        $labels = [
            '0' => 'Pending',
            '1' => 'Active',
            '2' => 'Delivered',
            '3' => 'Completed',
            '4' => 'Cancelled',
        ];
        return $labels[$status] ?? 'Unknown';
    }

    /**
     * Helper: Get status color
     */
    private function getStatusColor($status)
    {
        $colors = [
            '0' => 'warning',
            '1' => 'primary',
            '2' => 'info',
            '3' => 'success',
            '4' => 'danger',
        ];
        return $colors[$status] ?? 'secondary';
    }


}