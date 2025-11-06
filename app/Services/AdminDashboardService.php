<?php

namespace App\Services;

use App\Models\BookOrder;
use App\Models\Transaction;
use App\Models\ServiceReviews;
use App\Models\TeacherGig;
use App\Models\User;
use App\Models\ExpertProfile;
use App\Models\DisputeOrder;
use App\Models\Coupon;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardService
{
    /**
     * Get all statistics for admin dashboard
     *
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return array
     */
    public function getAllStatistics($dateFrom = null, $dateTo = null)
    {
        return [
            'financial' => $this->getFinancialStatistics($dateFrom, $dateTo),
            'users' => $this->getUserStatistics($dateFrom, $dateTo),
            'applications' => $this->getApplicationStatistics($dateFrom, $dateTo),
            'orders' => $this->getOrderStatistics($dateFrom, $dateTo),
            'services' => $this->getServiceStatistics($dateFrom, $dateTo),
            'disputes' => $this->getDisputeStatistics($dateFrom, $dateTo),
            'engagement' => $this->getEngagementStatistics($dateFrom, $dateTo),
            'categories' => $this->getCategoryStatistics($dateFrom, $dateTo),
            'date_range' => [
                'from' => $dateFrom,
                'to' => $dateTo,
            ]
        ];
    }

    /**
     * Get financial statistics - admin commission and platform revenue
     *
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return array
     */
    public function getFinancialStatistics($dateFrom = null, $dateTo = null)
    {
        $baseQuery = Transaction::query();

        if ($dateFrom) {
            $baseQuery->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $baseQuery->where('created_at', '<=', $dateTo);
        }

        // Admin commission and platform revenue
        $completedStats = $baseQuery->clone()
            ->where('status', 'completed')
            ->selectRaw('
                SUM(total_admin_commission) as total_admin_commission,
                SUM(buyer_commission_amount) as total_buyer_commission,
                SUM(seller_commission_amount) as total_seller_commission,
                SUM(total_amount) as total_gmv,
                AVG(total_amount) as avg_transaction_value,
                SUM(coupon_discount) as total_coupon_discount,
                COUNT(*) as transaction_count
            ')
            ->first();

        // Pending payouts (completed transactions not yet paid out)
        $pendingPayouts = Transaction::where('status', 'completed')
            ->where(function($q) {
                $q->whereNull('payout_status')
                  ->orWhere('payout_status', 'pending');
            })
            ->sum('seller_earnings');

        // Completed payouts
        $completedPayouts = Transaction::where('payout_status', 'paid')
            ->sum('seller_earnings');

        // Total refunded
        $totalRefunded = $baseQuery->clone()
            ->where('status', 'refunded')
            ->sum('total_amount');

        // Admin absorbed discount (admin pays part of coupon)
        $adminAbsorbedDiscount = $baseQuery->clone()
            ->where('status', 'completed')
            ->where('admin_absorbed_discount', true)
            ->sum('coupon_discount');

        // This month revenue
        $monthRevenue = Transaction::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_admin_commission');

        // Today revenue
        $todayRevenue = Transaction::where('status', 'completed')
            ->whereDate('created_at', today())
            ->sum('total_admin_commission');

        // Commission breakdown by service type
        $classCommission = BookOrder::whereHas('gig', function($q) {
                $q->where('service_role', 'Class');
            })
            ->whereIn('status', [2, 3])
            ->when($dateFrom, fn($q) => $q->where('created_at', '>=', $dateFrom))
            ->when($dateTo, fn($q) => $q->where('created_at', '<=', $dateTo))
            ->sum('total_admin_commission');

        $freelanceCommission = BookOrder::whereHas('gig', function($q) {
                $q->where('service_role', 'Freelance');
            })
            ->whereIn('status', [2, 3])
            ->when($dateFrom, fn($q) => $q->where('created_at', '>=', $dateFrom))
            ->when($dateTo, fn($q) => $q->where('created_at', '<=', $dateTo))
            ->sum('total_admin_commission');

        // Commission by delivery type
        $onlineCommission = BookOrder::whereHas('gig', function($q) {
                $q->where('service_type', 'Online');
            })
            ->whereIn('status', [2, 3])
            ->when($dateFrom, fn($q) => $q->where('created_at', '>=', $dateFrom))
            ->when($dateTo, fn($q) => $q->where('created_at', '<=', $dateTo))
            ->sum('total_admin_commission');

        $inpersonCommission = BookOrder::whereHas('gig', function($q) {
                $q->where('service_type', 'Inperson');
            })
            ->whereIn('status', [2, 3])
            ->when($dateFrom, fn($q) => $q->where('created_at', '>=', $dateFrom))
            ->when($dateTo, fn($q) => $q->where('created_at', '<=', $dateTo))
            ->sum('total_admin_commission');

        $totalAdminCommission = $completedStats->total_admin_commission ?? 0;
        $netPlatformRevenue = $totalAdminCommission - $totalRefunded - $adminAbsorbedDiscount;

        return [
            'total_admin_commission' => round($totalAdminCommission, 2),
            'total_buyer_commission' => round($completedStats->total_buyer_commission ?? 0, 2),
            'total_seller_commission' => round($completedStats->total_seller_commission ?? 0, 2),
            'total_gmv' => round($completedStats->total_gmv ?? 0, 2),
            'avg_transaction_value' => round($completedStats->avg_transaction_value ?? 0, 2),
            'pending_payouts' => round($pendingPayouts, 2),
            'completed_payouts' => round($completedPayouts, 2),
            'total_refunded' => round($totalRefunded, 2),
            'total_coupon_discount' => round($completedStats->total_coupon_discount ?? 0, 2),
            'admin_absorbed_discount' => round($adminAbsorbedDiscount, 2),
            'net_platform_revenue' => round($netPlatformRevenue, 2),
            'month_revenue' => round($monthRevenue, 2),
            'today_revenue' => round($todayRevenue, 2),
            'transaction_count' => $completedStats->transaction_count ?? 0,
            'class_commission' => round($classCommission, 2),
            'freelance_commission' => round($freelanceCommission, 2),
            'online_commission' => round($onlineCommission, 2),
            'inperson_commission' => round($inpersonCommission, 2),
        ];
    }

    /**
     * Get user statistics - sellers, buyers, admins
     *
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return array
     */
    public function getUserStatistics($dateFrom = null, $dateTo = null)
    {
        $baseQuery = User::query();

        if ($dateFrom) {
            $baseQuery->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $baseQuery->where('created_at', '<=', $dateTo);
        }

        // Total users by role (unfiltered)
        $totalUsers = User::count();
        $totalSellers = User::where('role', 1)->count();
        $totalBuyers = User::where('role', 0)->count();
        $totalAdmins = User::where('role', 2)->count();

        // New signups (filtered)
        $newSignupsTotal = $baseQuery->clone()->count();
        $newSignupsToday = User::whereDate('created_at', today())->count();
        $newSignupsThisWeek = User::where('created_at', '>=', now()->startOfWeek())->count();
        $newSignupsThisMonth = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Active users (logged in last 30 days - based on recent activity)
        $activeUsers = User::where('updated_at', '>=', now()->subDays(30))->count();

        // Deleted accounts - not tracked in this system
        // Can be enabled later if soft deletes are implemented
        $deletedAccounts = 0;

        // Sellers by service type
        $onlineClassSellers = TeacherGig::where('service_role', 'Class')
            ->where('service_type', 'Online')
            ->distinct('user_id')
            ->count('user_id');

        $inpersonClassSellers = TeacherGig::where('service_role', 'Class')
            ->where('service_type', 'Inperson')
            ->distinct('user_id')
            ->count('user_id');

        $onlineFreelanceSellers = TeacherGig::where('service_role', 'Freelance')
            ->where('service_type', 'Online')
            ->distinct('user_id')
            ->count('user_id');

        $inpersonFreelanceSellers = TeacherGig::where('service_role', 'Freelance')
            ->where('service_type', 'Inperson')
            ->distinct('user_id')
            ->count('user_id');

        return [
            'total_users' => $totalUsers,
            'total_sellers' => $totalSellers,
            'total_buyers' => $totalBuyers,
            'total_admins' => $totalAdmins,
            'new_signups_total' => $newSignupsTotal,
            'new_signups_today' => $newSignupsToday,
            'new_signups_this_week' => $newSignupsThisWeek,
            'new_signups_this_month' => $newSignupsThisMonth,
            'active_users' => $activeUsers,
            'deleted_accounts' => $deletedAccounts,
            'online_class_sellers' => $onlineClassSellers,
            'inperson_class_sellers' => $inpersonClassSellers,
            'online_freelance_sellers' => $onlineFreelanceSellers,
            'inperson_freelance_sellers' => $inpersonFreelanceSellers,
        ];
    }

    /**
     * Get application statistics - pending, approved, rejected
     *
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return array
     */
    public function getApplicationStatistics($dateFrom = null, $dateTo = null)
    {
        $baseQuery = ExpertProfile::query();

        if ($dateFrom) {
            $baseQuery->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $baseQuery->where('created_at', '<=', $dateTo);
        }

        $pendingApplications = ExpertProfile::where('status', 0)->count();
        $newApplicationsToday = ExpertProfile::where('status', 0)
            ->whereDate('created_at', today())
            ->count();

        $approvedApplications = $baseQuery->clone()->where('status', 1)->count();
        $rejectedApplications = $baseQuery->clone()->where('status', 2)->count();

        $totalProcessed = $approvedApplications + $rejectedApplications;
        $approvalRate = $totalProcessed > 0 ? round(($approvedApplications / $totalProcessed) * 100, 1) : 0;

        // Average approval time (days from submission to approval)
        $avgApprovalTime = ExpertProfile::where('status', 1)
            ->whereNotNull('updated_at')
            ->selectRaw('AVG(DATEDIFF(updated_at, created_at)) as avg_days')
            ->value('avg_days');

        return [
            'pending_applications' => $pendingApplications,
            'new_applications_today' => $newApplicationsToday,
            'approved_applications' => $approvedApplications,
            'rejected_applications' => $rejectedApplications,
            'approval_rate' => $approvalRate,
            'avg_approval_time' => round($avgApprovalTime ?? 0, 1),
        ];
    }

    /**
     * Get order statistics - all order statuses
     *
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return array
     */
    public function getOrderStatistics($dateFrom = null, $dateTo = null)
    {
        $baseQuery = BookOrder::query();

        if ($dateFrom) {
            $baseQuery->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $baseQuery->where('created_at', '<=', $dateTo);
        }

        $totalOrders = $baseQuery->clone()->count();
        $activeOrders = $baseQuery->clone()->where('status', 1)->count();
        $pendingOrders = $baseQuery->clone()->where('status', 0)->count();
        $deliveredOrders = $baseQuery->clone()->where('status', 2)->count();
        $completedOrders = $baseQuery->clone()->where('status', 3)->count();
        $cancelledOrders = $baseQuery->clone()->where('status', 4)->count();

        $completionRate = $totalOrders > 0 ? round(($completedOrders / $totalOrders) * 100, 1) : 0;
        $cancellationRate = $totalOrders > 0 ? round(($cancelledOrders / $totalOrders) * 100, 1) : 0;

        // Orders by service type
        $classBookings = $baseQuery->clone()
            ->whereHas('gig', function($q) {
                $q->where('service_role', 'Class');
            })
            ->count();

        $freelanceBookings = $baseQuery->clone()
            ->whereHas('gig', function($q) {
                $q->where('service_role', 'Freelance');
            })
            ->count();

        $onlineBookings = $baseQuery->clone()
            ->whereHas('gig', function($q) {
                $q->where('service_type', 'Online');
            })
            ->count();

        $inpersonBookings = $baseQuery->clone()
            ->whereHas('gig', function($q) {
                $q->where('service_type', 'Inperson');
            })
            ->count();

        return [
            'total_orders' => $totalOrders,
            'active_orders' => $activeOrders,
            'pending_orders' => $pendingOrders,
            'delivered_orders' => $deliveredOrders,
            'completed_orders' => $completedOrders,
            'cancelled_orders' => $cancelledOrders,
            'completion_rate' => $completionRate,
            'cancellation_rate' => $cancellationRate,
            'class_bookings' => $classBookings,
            'freelance_bookings' => $freelanceBookings,
            'online_bookings' => $onlineBookings,
            'inperson_bookings' => $inpersonBookings,
        ];
    }

    /**
     * Get service/gig statistics
     *
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return array
     */
    public function getServiceStatistics($dateFrom = null, $dateTo = null)
    {
        $baseQuery = TeacherGig::query();

        if ($dateFrom) {
            $baseQuery->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $baseQuery->where('created_at', '<=', $dateTo);
        }

        $totalServices = TeacherGig::count();
        $activeServices = TeacherGig::where('status', 1)->count();
        $inactiveServices = TeacherGig::where('status', 0)->count();

        // Performance metrics (all-time, not date filtered)
        $performanceStats = TeacherGig::selectRaw('
            SUM(impressions) as total_impressions,
            SUM(clicks) as total_clicks,
            SUM(orders) as total_orders
        ')->first();

        $totalImpressions = $performanceStats->total_impressions ?? 0;
        $totalClicks = $performanceStats->total_clicks ?? 0;
        $totalOrders = $performanceStats->total_orders ?? 0;

        $conversionRate = $totalClicks > 0 ? round(($totalOrders / $totalClicks) * 100, 2) : 0;
        $ctr = $totalImpressions > 0 ? round(($totalClicks / $totalImpressions) * 100, 2) : 0;

        // Average rating across all services
        $avgServiceRating = ServiceReviews::whereNull('parent_id')
            ->avg('rating');

        return [
            'total_services' => $totalServices,
            'active_services' => $activeServices,
            'inactive_services' => $inactiveServices,
            'total_impressions' => $totalImpressions,
            'total_clicks' => $totalClicks,
            'total_orders' => $totalOrders,
            'conversion_rate' => $conversionRate,
            'click_through_rate' => $ctr,
            'avg_service_rating' => $avgServiceRating ? round($avgServiceRating, 2) : 0,
        ];
    }

    /**
     * Get dispute and refund statistics
     *
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return array
     */
    public function getDisputeStatistics($dateFrom = null, $dateTo = null)
    {
        $baseQuery = DisputeOrder::query();

        if ($dateFrom) {
            $baseQuery->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $baseQuery->where('created_at', '<=', $dateTo);
        }

        // Active disputes (orders with dispute flags)
        $activeDisputes = BookOrder::where(function($q) {
                $q->where('user_dispute', 1)
                  ->orWhere('teacher_dispute', 1);
            })
            ->count();

        $pendingRefunds = $baseQuery->clone()
            ->whereNull('refund')
            ->count();

        $processedRefunds = $baseQuery->clone()
            ->where('refund', 1)
            ->count();

        $totalRefundedAmount = $baseQuery->clone()
            ->where('refund', 1)
            ->sum('amount');

        $totalOrdersBase = BookOrder::query();
        if ($dateFrom) {
            $totalOrdersBase->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $totalOrdersBase->where('created_at', '<=', $dateTo);
        }
        $totalOrdersCount = $totalOrdersBase->count();

        $disputeRate = $totalOrdersCount > 0 ? round((($activeDisputes + $pendingRefunds) / $totalOrdersCount) * 100, 2) : 0;

        return [
            'active_disputes' => $activeDisputes,
            'pending_refunds' => $pendingRefunds,
            'processed_refunds' => $processedRefunds,
            'total_refunded_amount' => round($totalRefundedAmount, 2),
            'dispute_rate' => $disputeRate,
        ];
    }

    /**
     * Get engagement statistics
     *
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return array
     */
    public function getEngagementStatistics($dateFrom = null, $dateTo = null)
    {
        $baseQuery = ServiceReviews::whereNull('parent_id');

        if ($dateFrom) {
            $baseQuery->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $baseQuery->where('created_at', '<=', $dateTo);
        }

        $totalReviews = $baseQuery->clone()->count();
        $avgRating = $baseQuery->clone()->avg('rating');
        $fiveStarReviews = $baseQuery->clone()->where('rating', 5)->count();
        $oneStarReviews = $baseQuery->clone()->where('rating', 1)->count();

        // Repeat customer rate
        $repeatCustomers = BookOrder::select('user_id', DB::raw('COUNT(*) as order_count'))
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) >= 2')
            ->count();

        $totalCustomers = BookOrder::distinct('user_id')->count('user_id');
        $repeatCustomerRate = $totalCustomers > 0 ? round(($repeatCustomers / $totalCustomers) * 100, 1) : 0;

        return [
            'total_reviews' => $totalReviews,
            'avg_rating' => $avgRating ? round($avgRating, 2) : 0,
            'five_star_reviews' => $fiveStarReviews,
            'one_star_reviews' => $oneStarReviews,
            'repeat_customers' => $repeatCustomers,
            'repeat_customer_rate' => $repeatCustomerRate,
        ];
    }

    /**
     * Get category statistics
     *
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return array
     */
    public function getCategoryStatistics($dateFrom = null, $dateTo = null)
    {
        $totalCategories = Category::where('status', 1)->count();

        return [
            'total_categories' => $totalCategories,
        ];
    }

    /**
     * Get top sellers by revenue
     *
     * @param int $limit
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return \Illuminate\Support\Collection
     */
    public function getTopSellers($limit = 10, $dateFrom = null, $dateTo = null)
    {
        $query = User::select('users.id', 'users.name', 'users.profile')
            ->join('transactions', 'users.id', '=', 'transactions.seller_id')
            ->where('users.role', 1)
            ->where('transactions.status', 'completed')
            ->groupBy('users.id', 'users.name', 'users.profile')
            ->selectRaw('SUM(transactions.total_amount) as total_revenue')
            ->selectRaw('COUNT(DISTINCT transactions.id) as order_count')
            ->orderBy('total_revenue', 'desc')
            ->limit($limit);

        if ($dateFrom) {
            $query->where('transactions.created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->where('transactions.created_at', '<=', $dateTo);
        }

        return $query->get()->map(function($seller, $index) {
            return [
                'rank' => $index + 1,
                'id' => $seller->id,
                'name' => $seller->name,
                'profile' => $seller->profile,
                'total_revenue' => round($seller->total_revenue, 2),
                'order_count' => $seller->order_count,
            ];
        });
    }

    /**
     * Get top buyers by spending
     *
     * @param int $limit
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return \Illuminate\Support\Collection
     */
    public function getTopBuyers($limit = 10, $dateFrom = null, $dateTo = null)
    {
        $query = User::select('users.id', 'users.name', 'users.profile', 'users.created_at')
            ->join('transactions', 'users.id', '=', 'transactions.buyer_id')
            ->where('users.role', 0)
            ->where('transactions.status', 'completed')
            ->groupBy('users.id', 'users.name', 'users.profile', 'users.created_at')
            ->selectRaw('SUM(transactions.total_amount) as total_spent')
            ->selectRaw('COUNT(DISTINCT transactions.id) as order_count')
            ->orderBy('total_spent', 'desc')
            ->limit($limit);

        if ($dateFrom) {
            $query->where('transactions.created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->where('transactions.created_at', '<=', $dateTo);
        }

        return $query->get()->map(function($buyer, $index) {
            return [
                'rank' => $index + 1,
                'id' => $buyer->id,
                'name' => $buyer->name,
                'profile' => $buyer->profile,
                'total_spent' => round($buyer->total_spent, 2),
                'order_count' => $buyer->order_count,
                'member_since' => Carbon::parse($buyer->created_at)->format('M Y'),
            ];
        });
    }

    /**
     * Get top services by orders
     *
     * @param int $limit
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return \Illuminate\Support\Collection
     */
    public function getTopServices($limit = 10, $dateFrom = null, $dateTo = null)
    {
        $query = TeacherGig::select('teacher_gigs.id', 'teacher_gigs.title', 'teacher_gigs.main_file')
            ->join('users', 'teacher_gigs.user_id', '=', 'users.id')
            ->join('book_orders', 'teacher_gigs.id', '=', 'book_orders.gig_id')
            ->groupBy('teacher_gigs.id', 'teacher_gigs.title', 'teacher_gigs.main_file', 'users.name')
            ->selectRaw('users.name as seller_name')
            ->selectRaw('COUNT(book_orders.id) as order_count')
            ->selectRaw('SUM(book_orders.finel_price) as total_revenue')
            ->orderBy('order_count', 'desc')
            ->limit($limit);

        if ($dateFrom) {
            $query->where('book_orders.created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->where('book_orders.created_at', '<=', $dateTo);
        }

        return $query->get()->map(function($service, $index) {
            return [
                'rank' => $index + 1,
                'id' => $service->id,
                'title' => $service->title,
                'thumbnail' => $service->main_file,
                'seller_name' => $service->seller_name,
                'order_count' => $service->order_count,
                'total_revenue' => round($service->total_revenue, 2),
            ];
        });
    }

    /**
     * Get top categories by revenue
     *
     * @param int $limit
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return \Illuminate\Support\Collection
     */
    public function getTopCategories($limit = 10, $dateFrom = null, $dateTo = null)
    {
        $query = DB::table('teacher_gigs')
            ->join('book_orders', 'teacher_gigs.id', '=', 'book_orders.gig_id')
            ->join('transactions', 'book_orders.payment_id', '=', 'transactions.stripe_transaction_id')
            ->where('transactions.status', 'completed')
            ->whereNotNull('teacher_gigs.category_name')
            ->groupBy('teacher_gigs.category_name')
            ->selectRaw('teacher_gigs.category_name')
            ->selectRaw('COUNT(DISTINCT book_orders.id) as order_count')
            ->selectRaw('SUM(transactions.total_amount) as total_revenue')
            ->selectRaw('COUNT(DISTINCT teacher_gigs.id) as service_count')
            ->orderBy('total_revenue', 'desc')
            ->limit($limit);

        if ($dateFrom) {
            $query->where('transactions.created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->where('transactions.created_at', '<=', $dateTo);
        }

        return collect($query->get())->map(function($category, $index) {
            return [
                'rank' => $index + 1,
                'name' => $category->category_name,
                'order_count' => $category->order_count,
                'total_revenue' => round($category->total_revenue, 2),
                'service_count' => $category->service_count,
            ];
        });
    }

    /**
     * Get pending applications with details
     *
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function getPendingApplications($limit = 10)
    {
        return ExpertProfile::where('status', 0)
            ->with('user:id,name,email')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function($application) {
                return [
                    'id' => $application->id,
                    'user_id' => $application->user_id,
                    'name' => $application->user->name ?? 'N/A',
                    'email' => $application->user->email ?? 'N/A',
                    'service_type' => $application->service_role . ' - ' . $application->service_type,
                    'submitted_at' => Carbon::parse($application->created_at)->format('M d, Y'),
                    'days_waiting' => Carbon::parse($application->created_at)->diffInDays(now()),
                ];
            });
    }

    /**
     * Get active disputes with details
     *
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function getActiveDisputes($limit = 10)
    {
        return BookOrder::where(function($q) {
                $q->where('user_dispute', 1)
                  ->orWhere('teacher_dispute', 1);
            })
            ->with(['user:id,name', 'teacher:id,name', 'gig:id,title'])
            ->orderBy('updated_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function($order) {
                return [
                    'order_id' => $order->id,
                    'buyer_name' => $order->user->name ?? 'N/A',
                    'seller_name' => $order->teacher->name ?? 'N/A',
                    'service_title' => $order->gig->title ?? 'N/A',
                    'amount' => round($order->finel_price, 2),
                    'days_open' => Carbon::parse($order->updated_at)->diffInDays(now()),
                    'user_disputed' => $order->user_dispute == 1,
                    'teacher_disputed' => $order->teacher_dispute == 1,
                ];
            });
    }

    /**
     * Get pending refunds with details
     *
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function getPendingRefunds($limit = 10)
    {
        return DisputeOrder::whereNull('refund')
            ->with(['user:id,name', 'order.gig:id,title'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function($dispute) {
                return [
                    'id' => $dispute->id,
                    'order_id' => $dispute->order_id,
                    'customer_name' => $dispute->user->name ?? 'N/A',
                    'service_title' => $dispute->order->gig->title ?? 'N/A',
                    'amount' => round($dispute->amount, 2),
                    'reason' => $dispute->reason,
                    'refund_type' => $dispute->refund_type,
                    'requested_at' => Carbon::parse($dispute->created_at)->format('M d, Y'),
                ];
            });
    }

    /**
     * Get monthly revenue chart data
     *
     * @param int $months
     * @return array
     */
    public function getRevenueChartData($months = 12)
    {
        $data = Transaction::where('status', 'completed')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month,
                         SUM(total_admin_commission) as revenue,
                         COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths($months))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Fill in missing months
        $monthsArray = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $monthsArray[$month] = [
                'month' => $month,
                'revenue' => 0,
                'count' => 0,
            ];
        }

        foreach ($data as $item) {
            $monthsArray[$item->month] = [
                'month' => $item->month,
                'revenue' => round($item->revenue, 2),
                'count' => $item->count,
            ];
        }

        $result = array_values($monthsArray);

        return [
            'labels' => array_map(function ($item) {
                return Carbon::parse($item['month'] . '-01')->format('M Y');
            }, $result),
            'revenue' => array_column($result, 'revenue'),
            'count' => array_column($result, 'count'),
        ];
    }

    /**
     * Get order status breakdown chart
     *
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return array
     */
    public function getOrderStatusChart($dateFrom = null, $dateTo = null)
    {
        $query = BookOrder::selectRaw('status, COUNT(*) as count')
            ->groupBy('status');

        if ($dateFrom) {
            $query->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->where('created_at', '<=', $dateTo);
        }

        $data = $query->get();

        $statusLabels = [
            '0' => 'Pending',
            '1' => 'Active',
            '2' => 'Delivered',
            '3' => 'Completed',
            '4' => 'Cancelled',
        ];

        $statusColors = [
            '0' => '#ffc107',
            '1' => '#007bff',
            '2' => '#17a2b8',
            '3' => '#28a745',
            '4' => '#dc3545',
        ];

        $labels = [];
        $counts = [];
        $colors = [];

        foreach ($data as $item) {
            $labels[] = $statusLabels[$item->status] ?? 'Unknown';
            $counts[] = $item->count;
            $colors[] = $statusColors[$item->status] ?? '#6c757d';
        }

        return [
            'labels' => $labels,
            'data' => $counts,
            'backgroundColor' => $colors,
        ];
    }

    /**
     * Apply date preset filter
     *
     * @param string $preset
     * @return array
     */
    public function applyDatePreset($preset)
    {
        $now = now();

        switch ($preset) {
            case 'today':
                return [
                    'from' => $now->copy()->startOfDay()->toDateTimeString(),
                    'to' => $now->toDateTimeString()
                ];

            case 'yesterday':
                return [
                    'from' => $now->copy()->subDay()->startOfDay()->toDateTimeString(),
                    'to' => $now->copy()->subDay()->endOfDay()->toDateTimeString()
                ];

            case 'this_week':
                return [
                    'from' => $now->copy()->startOfWeek()->toDateTimeString(),
                    'to' => $now->toDateTimeString()
                ];

            case 'last_week':
                return [
                    'from' => $now->copy()->subWeek()->startOfWeek()->toDateTimeString(),
                    'to' => $now->copy()->subWeek()->endOfWeek()->toDateTimeString()
                ];

            case 'last_7_days':
                return [
                    'from' => $now->copy()->subDays(7)->toDateTimeString(),
                    'to' => $now->toDateTimeString()
                ];

            case 'this_month':
                return [
                    'from' => $now->copy()->startOfMonth()->toDateTimeString(),
                    'to' => $now->toDateTimeString()
                ];

            case 'last_month':
                return [
                    'from' => $now->copy()->subMonth()->startOfMonth()->toDateTimeString(),
                    'to' => $now->copy()->subMonth()->endOfMonth()->toDateTimeString()
                ];

            case 'last_3_months':
                return [
                    'from' => $now->copy()->subMonths(3)->toDateTimeString(),
                    'to' => $now->toDateTimeString()
                ];

            case 'last_6_months':
                return [
                    'from' => $now->copy()->subMonths(6)->toDateTimeString(),
                    'to' => $now->toDateTimeString()
                ];

            case 'last_year':
                return [
                    'from' => $now->copy()->subYear()->toDateTimeString(),
                    'to' => $now->toDateTimeString()
                ];

            case 'all_time':
            default:
                return [
                    'from' => null,
                    'to' => null
                ];
        }
    }
}
