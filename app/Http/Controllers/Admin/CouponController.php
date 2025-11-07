<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\User;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    public function AdmincheckAuth()
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
     * Display coupon list
     */
    public function index()
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $coupons = Coupon::with('seller')->orderBy('created_at', 'desc')->paginate(20);

        // Statistics
        $stats = [
            'total_coupons' => Coupon::count(),
            'active_coupons' => Coupon::valid()->count(),
            'expired_coupons' => Coupon::expired()->count(),
            'total_discount_given' => Coupon::sum('total_discount_given'),
            'total_usage' => CouponUsage::count(),
        ];

        return view('Admin-Dashboard.Coupons.Index', compact('coupons', 'stats'));
    }

    /**
     * Show create coupon form
     */
    public function create()
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $sellers = User::where('role', 1)->get(); // Adjust based on your user roles

        return view('Admin-Dashboard.Coupons.Create', compact('sellers'));
    }

    /**
     * Store new coupon
     */
    public function store(Request $request)
    {
       $request->validate([
            'coupon_name' => 'required|string|max:255',
            'coupon_code' => 'required|string|max:50|unique:coupons,coupon_code',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'expiry_date' => 'required|date|after_or_equal:start_date',
            'coupon_type' => 'required|in:seller-wide,custom',
            'seller_email' => 'nullable|required_if:coupon_type,custom|email|exists:users,email',
            'one_time_use' => 'boolean',
            'usage_limit' => 'nullable|integer|min:1',
            'description' => 'nullable|string|max:500',
        ]);

        try {
            $data = $request->all();

            // Convert coupon code to uppercase
            $data['coupon_code'] = strtoupper($request->coupon_code);

            // Get seller ID if custom coupon
            if ($request->coupon_type === 'custom') {
                $seller = User::where('email', $request->seller_email)->first();
                $data['seller_id'] = $seller->id;
            }

            // Validate percentage
            if ($request->discount_type === 'percentage' && $request->discount_value > 100) {
                return redirect()->back()->with('error', 'Percentage discount cannot exceed 100%')->withInput();
            }

            $coupon = Coupon::create($data);

            // Send notification for platform-wide coupons
            if ($request->coupon_type === 'seller-wide' && $coupon->is_active) {
                try {
                    // Get all active buyers (role 0)
                    $buyerIds = User::where('role', 0)
                        ->whereNotNull('email_verified_at')
                        ->limit(1000) // Limit to prevent overwhelming system
                        ->pluck('id')
                        ->toArray();

                    if (!empty($buyerIds)) {
                        $discountText = $coupon->discount_type === 'percentage'
                            ? "{$coupon->discount_value}% off"
                            : "\${$coupon->discount_value} off";

                        $this->notificationService->sendToMultipleUsers(
                            userIds: $buyerIds,
                            type: 'coupon',
                            title: 'New Coupon Available!',
                            message: "Use code {$coupon->coupon_code} to get {$discountText} on your next booking! Valid until " . $coupon->expiry_date->format('M d, Y'),
                            data: [
                                'coupon_id' => $coupon->id,
                                'coupon_code' => $coupon->coupon_code,
                                'coupon_name' => $coupon->coupon_name,
                                'discount_type' => $coupon->discount_type,
                                'discount_value' => $coupon->discount_value,
                                'expiry_date' => $coupon->expiry_date->toISOString(),
                                'description' => $coupon->description
                            ],
                            sendEmail: false // Don't spam email for promotional coupons
                        );

                        \Log::info("New coupon notification sent to " . count($buyerIds) . " buyers", [
                            'coupon_id' => $coupon->id,
                            'coupon_code' => $coupon->coupon_code
                        ]);
                    }
                } catch (\Exception $e) {
                    \Log::error('Failed to send new coupon notifications: ' . $e->getMessage());
                    // Don't fail the coupon creation if notification fails
                }
            }

            return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully!');

        } catch (\Exception $e) {
            \Log::error('Coupon creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create coupon.')->withInput();
        }
    }

    /**
     * Show edit coupon form
     */
    public function edit($id)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $coupon = Coupon::findOrFail($id);
        $sellers = User::where('role', 'seller')->get();

        return view('Admin-Dashboard.Coupons.Edit', compact('coupon', 'sellers'));
    }

    /**
     * Update coupon
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'coupon_name' => 'required|string|max:255',
            'coupon_code' => 'required|string|max:50|unique:coupons,coupon_code,' . $id,
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'expiry_date' => 'required|date|after_or_equal:start_date',
            'coupon_type' => 'required|in:seller-wide,custom',
            'seller_email' => 'nullable|required_if:coupon_type,custom|email|exists:users,email',
            'one_time_use' => 'boolean',
            'usage_limit' => 'nullable|integer|min:1',
            'description' => 'nullable|string|max:500',
        ]);

        try {
            $coupon = Coupon::findOrFail($id);

            $data = $request->all();
            $data['coupon_code'] = strtoupper($request->coupon_code);

            if ($request->coupon_type === 'custom') {
                $seller = User::where('email', $request->seller_email)->first();
                $data['seller_id'] = $seller->id;
            } else {
                $data['seller_id'] = null;
                $data['seller_email'] = null;
            }

            if ($request->discount_type === 'percentage' && $request->discount_value > 100) {
                return redirect()->back()->with('error', 'Percentage discount cannot exceed 100%')->withInput();
            }

            $coupon->update($data);

            return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated successfully!');

        } catch (\Exception $e) {
            \Log::error('Coupon update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update coupon.')->withInput();
        }
    }

    /**
     * Delete coupon
     */
    public function destroy($id)
    {
        try {
            $coupon = Coupon::findOrFail($id);
            $coupon->delete();

            return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted successfully!');

        } catch (\Exception $e) {
            \Log::error('Coupon deletion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete coupon.');
        }
    }

    /**
     * Toggle coupon status
     */
    public function toggleStatus($id)
    {
        try {
            $coupon = Coupon::findOrFail($id);
            $coupon->is_active = !$coupon->is_active;
            $coupon->save();

            $status = $coupon->is_active ? 'activated' : 'deactivated';

            return redirect()->back()->with('success', "Coupon {$status} successfully!");

        } catch (\Exception $e) {
            \Log::error('Toggle coupon status failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to toggle coupon status.');
        }
    }

    /**
     * View coupon details and usage history
     */
    public function show($id)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $coupon = Coupon::with('seller')->findOrFail($id);
        $usages = CouponUsage::where('coupon_id', $id)
            ->with(['buyer', 'seller', 'transaction'])
            ->orderBy('used_at', 'desc')
            ->paginate(20);

        return view('Admin-Dashboard.Coupons.Show', compact('coupon', 'usages'));
    }

    /**
     * Coupon analytics dashboard
     */
    public function analytics()
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        // Top used coupons
        $topCoupons = Coupon::orderBy('usage_count', 'desc')->limit(10)->get();

        // Recent usage
        $recentUsage = CouponUsage::with(['coupon', 'buyer', 'seller'])
            ->orderBy('used_at', 'desc')
            ->limit(20)
            ->get();

        // Monthly statistics
        $monthlyStats = CouponUsage::selectRaw('DATE_FORMAT(used_at, "%Y-%m") as month, COUNT(*) as count, SUM(discount_amount) as total_discount')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();

        return view('Admin-Dashboard.Coupons.Analytics', compact('topCoupons', 'recentUsage', 'monthlyStats'));
    }

    /**
     * Validate coupon (AJAX)
     */
    public function validateCoupon(Request $request)
    {
        $validation = Coupon::validateCode(
            $request->coupon_code,
            $request->user_id,
            $request->seller_id
        );
        if ($validation['valid']) {
            $coupon = $validation['coupon'];
            $discount = $coupon->calculateDiscount($request->amount);

            return response()->json([
                'valid' => true,
                'message' => 'Coupon applied successfully!',
                'coupon' => $coupon,
                'discount_amount' => $discount,
                'final_amount' => $request->amount - $discount,
            ]);
        }
        return response()->json([
            'valid' => false,
            'message' => $validation['message'],
        ], 422);
    }
}
