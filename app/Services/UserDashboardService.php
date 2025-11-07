<?php

namespace App\Services;

use App\Models\BookOrder;
use App\Models\Transaction;
use App\Models\ServiceReviews;
use App\Models\CouponUsage;
use App\Models\DisputeOrder;
use App\Models\ClassDate;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserDashboardService
{
    /**
     * Get all statistics for user dashboard
     *
     * @param int $userId
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return array
     */
    public function getAllStatistics($userId, $dateFrom = null, $dateTo = null)
    {
        return [
            'financial' => $this->getFinancialStatistics($userId, $dateFrom, $dateTo),
            'orders' => $this->getOrderStatistics($userId, $dateFrom, $dateTo),
            'engagement' => $this->getEngagementStatistics($userId, $dateFrom, $dateTo),
            'upcoming' => $this->getUpcomingClasses($userId),
            'date_range' => [
                'from' => $dateFrom,
                'to' => $dateTo,
            ]
        ];
    }

    /**
     * Get financial statistics from transactions table
     *
     * @param int $userId
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return array
     */
    public function getFinancialStatistics($userId, $dateFrom = null, $dateTo = null)
    {
        $baseQuery = Transaction::where('buyer_id', $userId);

        // Apply date filters if provided
        if ($dateFrom) {
            $baseQuery->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $baseQuery->where('created_at', '<=', $dateTo);
        }

        // Get aggregated financial data
        $completedStats = $baseQuery->clone()
            ->where('status', 'completed')
            ->selectRaw('
                SUM(total_amount) as total_spent,
                AVG(total_amount) as avg_order_value,
                SUM(buyer_commission_amount) as total_service_fees,
                COUNT(*) as transaction_count
            ')
            ->first();

        // Get refunded amount
        $totalRefunded = $baseQuery->clone()
            ->where('status', 'refunded')
            ->sum('total_amount');

        // Get this month's spending
        $monthSpent = Transaction::where('buyer_id', $userId)
            ->where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');

        // Get today's spending
        $todaySpent = Transaction::where('buyer_id', $userId)
            ->where('status', 'completed')
            ->whereDate('created_at', today())
            ->sum('total_amount');

        // Get coupon savings
        $couponQuery = CouponUsage::where('buyer_id', $userId);
        if ($dateFrom) {
            $couponQuery->where('used_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $couponQuery->where('used_at', '<=', $dateTo);
        }
        $totalCouponSavings = $couponQuery->sum('discount_amount');

        return [
            'total_spent' => round($completedStats->total_spent ?? 0, 2),
            'month_spent' => round($monthSpent ?? 0, 2),
            'today_spent' => round($todaySpent ?? 0, 2),
            'avg_order_value' => round($completedStats->avg_order_value ?? 0, 2),
            'total_service_fees' => round($completedStats->total_service_fees ?? 0, 2),
            'total_coupon_savings' => round($totalCouponSavings ?? 0, 2),
            'total_refunded' => round($totalRefunded ?? 0, 2),
            'transaction_count' => $completedStats->transaction_count ?? 0,
        ];
    }

    /**
     * Get order statistics from book_orders table
     *
     * @param int $userId
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return array
     */
    public function getOrderStatistics($userId, $dateFrom = null, $dateTo = null)
    {
        $baseQuery = BookOrder::where('user_id', $userId);

        // Apply date filters if provided
        if ($dateFrom) {
            $baseQuery->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $baseQuery->where('created_at', '<=', $dateTo);
        }

        return [
            'total_orders' => $baseQuery->clone()->count(),
            'active_orders' => $baseQuery->clone()->where('status', 1)->count(),
            'pending_orders' => $baseQuery->clone()->where('status', 0)->count(),
            'delivered_orders' => $baseQuery->clone()->where('status', 2)->count(),
            'completed_orders' => $baseQuery->clone()->where('status', 3)->count(),
            'cancelled_orders' => $baseQuery->clone()->where('status', 4)->count(),

            'class_orders' => $baseQuery->clone()->whereHas('gig', function ($q) {
                $q->where('service_role', 'Class');
            })->count(),

            'freelance_orders' => $baseQuery->clone()->whereHas('gig', function ($q) {
                $q->where('service_role', 'Freelance');
            })->count(),

            'online_orders' => $baseQuery->clone()->whereHas('gig', function ($q) {
                $q->where('service_type', 'Online');
            })->count(),

            'inperson_orders' => $baseQuery->clone()->whereHas('gig', function ($q) {
                $q->where('service_type', 'Inperson');
            })->count(),

            'upcoming_classes' => $this->getUpcomingClassesCount($userId),
        ];
    }

    /**
     * Get engagement statistics
     *
     * @param int $userId
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return array
     */
    public function getEngagementStatistics($userId, $dateFrom = null, $dateTo = null)
    {
        // Reviews given (only parent reviews, not replies)
        $reviewsQuery = ServiceReviews::where('user_id', $userId)
            ->whereNull('parent_id');
        if ($dateFrom) {
            $reviewsQuery->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $reviewsQuery->where('created_at', '<=', $dateTo);
        }
        $reviewsGiven = $reviewsQuery->count();

        // Disputes filed
        $disputesQuery = DisputeOrder::where('user_id', $userId);
        if ($dateFrom) {
            $disputesQuery->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $disputesQuery->where('created_at', '<=', $dateTo);
        }
        $disputesFiled = $disputesQuery->count();

        // Coupons used
        $couponsQuery = CouponUsage::where('buyer_id', $userId);
        if ($dateFrom) {
            $couponsQuery->where('used_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $couponsQuery->where('used_at', '<=', $dateTo);
        }
        $couponsUsed = $couponsQuery->count();

        // Unique sellers ordered from
        $sellersQuery = BookOrder::where('user_id', $userId)
            ->distinct('teacher_id');
        if ($dateFrom) {
            $sellersQuery->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $sellersQuery->where('created_at', '<=', $dateTo);
        }
        $uniqueSellers = $sellersQuery->count('teacher_id');

        // Days as member
        $user = \Auth::user();
        $daysAsMember = $user ? Carbon::parse($user->created_at)->diffInDays(now()) : 0;

        return [
            'reviews_given' => $reviewsGiven,
            'disputes_filed' => $disputesFiled,
            'coupons_used' => $couponsUsed,
            'unique_sellers' => $uniqueSellers,
            'days_as_member' => $daysAsMember,
        ];
    }

    /**
     * Get upcoming classes with details
     *
     * @param int $userId
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUpcomingClasses($userId, $limit = 5)
    {
        return ClassDate::whereHas('bookOrder', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->where('user_date', '>', now())
            ->with(['bookOrder.gig', 'bookOrder.teacher'])
            ->orderBy('user_date', 'asc')
            ->limit($limit)
            ->get()
            ->map(function ($classDate) {
                return [
                    'id' => $classDate->id,
                    'order_id' => $classDate->order_id,
                    'date_time' => $classDate->user_date,
                    'formatted_date' => Carbon::parse($classDate->user_date)->format('M d, Y'),
                    'formatted_time' => Carbon::parse($classDate->user_date)->format('h:i A'),
                    'duration' => $classDate->duration,
                    'service_name' => $classDate->bookOrder->gig->title ?? 'N/A',
                    'teacher_name' => $classDate->bookOrder->teacher->name ?? 'N/A',
                    'teacher_avatar' => $classDate->bookOrder->teacher->avatar ?? null,
                    'zoom_link' => $classDate->zoom_link,
                    'starts_in_minutes' => Carbon::parse($classDate->user_date)->diffInMinutes(now(), false),
                    'is_starting_soon' => Carbon::parse($classDate->user_date)->isBefore(now()->addMinutes(30)),
                ];
            });
    }

    /**
     * Get count of upcoming classes
     *
     * @param int $userId
     * @return int
     */
    private function getUpcomingClassesCount($userId)
    {
        return ClassDate::whereHas('bookOrder', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->where('user_date', '>', now())
            ->count();
    }

    /**
     * Get monthly trend data for charts (last N months)
     *
     * @param int $userId
     * @param int $months
     * @return array
     */
    public function getMonthlyTrendData($userId, $months = 6)
    {
        $data = Transaction::where('buyer_id', $userId)
            ->where('status', 'completed')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month,
                         SUM(total_amount) as spent,
                         COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths($months))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Fill in missing months with zero values
        $months_array = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $months_array[$month] = [
                'month' => $month,
                'spent' => 0,
                'count' => 0,
            ];
        }

        // Merge with actual data
        foreach ($data as $item) {
            $months_array[$item->month] = [
                'month' => $item->month,
                'spent' => round($item->spent, 2),
                'count' => $item->count,
            ];
        }

        $result = array_values($months_array);

        return [
            'labels' => array_map(function ($item) {
                return Carbon::parse($item['month'] . '-01')->format('M Y');
            }, $result),
            'spent' => array_column($result, 'spent'),
            'count' => array_column($result, 'count'),
        ];
    }

    /**
     * Get order status breakdown for pie chart
     *
     * @param int $userId
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return array
     */
    public function getOrderStatusBreakdown($userId, $dateFrom = null, $dateTo = null)
    {
        $query = BookOrder::where('user_id', $userId)
            ->selectRaw('status, COUNT(*) as count')
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
     * Get category distribution for bar chart
     *
     * @param int $userId
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @param int $limit
     * @return array
     */
    public function getCategoryDistribution($userId, $dateFrom = null, $dateTo = null, $limit = 5)
    {
        $query = BookOrder::where('book_orders.user_id', $userId)
            ->join('teacher_gigs', 'book_orders.gig_id', '=', 'teacher_gigs.id')
            ->selectRaw('teacher_gigs.category_name, COUNT(*) as count')
            ->whereNotNull('teacher_gigs.category_name')
            ->groupBy('teacher_gigs.category_name')
            ->orderBy('count', 'desc')
            ->limit($limit);

        if ($dateFrom) {
            $query->where('book_orders.created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->where('book_orders.created_at', '<=', $dateTo);
        }

        $data = $query->get();

        return [
            'labels' => $data->pluck('category_name')->toArray(),
            'data' => $data->pluck('count')->toArray(),
        ];
    }

    /**
     * Get recent activity/transactions
     *
     * @param int $userId
     * @param int $limit
     * @param int $page
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getRecentTransactions($userId, $limit = 15, $page = 1)
    {
        return BookOrder::where('user_id', $userId)
            ->with(['gig', 'teacher', 'transaction'])
            ->latest()
            ->paginate($limit, ['*'], 'page', $page);
    }

    /**
     * Apply date preset filter
     *
     * @param string $preset
     * @return array [dateFrom, dateTo]
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

            case 'year_to_date':
                return [
                    'from' => $now->copy()->startOfYear()->toDateTimeString(),
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
