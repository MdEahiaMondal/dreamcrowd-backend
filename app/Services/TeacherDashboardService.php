<?php

namespace App\Services;

use App\Models\BookOrder;
use App\Models\Transaction;
use App\Models\ServiceReviews;
use App\Models\TeacherGig;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TeacherDashboardService
{
    /**
     * Get all statistics for teacher dashboard
     *
     * @param int $teacherId
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return array
     */
    public function getAllStatistics($teacherId, $dateFrom = null, $dateTo = null)
    {
        return [
            'financial' => $this->getFinancialStatistics($teacherId, $dateFrom, $dateTo),
            'orders' => $this->getOrderStatistics($teacherId, $dateFrom, $dateTo),
            'service_performance' => $this->getServicePerformance($teacherId, $dateFrom, $dateTo),
            'engagement' => $this->getEngagementMetrics($teacherId, $dateFrom, $dateTo),
            'date_range' => [
                'from' => $dateFrom,
                'to' => $dateTo,
            ]
        ];
    }

    /**
     * Get financial statistics from transactions and book_orders table
     *
     * @param int $teacherId
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return array
     */
    public function getFinancialStatistics($teacherId, $dateFrom = null, $dateTo = null)
    {
        // Base transaction query
        $transactionQuery = Transaction::where('seller_id', $teacherId);

        if ($dateFrom) {
            $transactionQuery->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $transactionQuery->where('created_at', '<=', $dateTo);
        }

        // Total earnings from completed transactions
        $completedStats = $transactionQuery->clone()
            ->where('status', 'completed')
            ->selectRaw('
                SUM(seller_earnings) as total_earnings,
                AVG(seller_earnings) as avg_order_value,
                SUM(seller_commission_amount) as total_commission_paid,
                COUNT(*) as transaction_count
            ')
            ->first();

        // Pending payouts (completed but not paid out)
        $pendingPayouts = $transactionQuery->clone()
            ->where('status', 'completed')
            ->where(function($q) {
                $q->whereNull('payout_status')
                  ->orWhere('payout_status', 'pending');
            })
            ->sum('seller_earnings');

        // Completed payouts
        $completedPayouts = $transactionQuery->clone()
            ->where('payout_status', 'paid')
            ->sum('seller_earnings');

        // Pending earnings from delivered orders (not yet completed)
        $orderQuery = BookOrder::where('teacher_id', $teacherId);
        if ($dateFrom) {
            $orderQuery->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $orderQuery->where('created_at', '<=', $dateTo);
        }

        $pendingEarnings = $orderQuery->clone()
            ->where('status', 2) // Delivered status
            ->sum('seller_earnings');

        // This month's earnings
        $monthEarnings = Transaction::where('seller_id', $teacherId)
            ->where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('seller_earnings');

        // Today's earnings
        $todayEarnings = Transaction::where('seller_id', $teacherId)
            ->where('status', 'completed')
            ->whereDate('created_at', today())
            ->sum('seller_earnings');

        // Total refunded amount
        $totalRefunded = $transactionQuery->clone()
            ->where('status', 'refunded')
            ->sum('seller_earnings');

        // Calculate net earnings
        $totalEarnings = $completedStats->total_earnings ?? 0;
        $totalCommission = $completedStats->total_commission_paid ?? 0;
        $netEarnings = $totalEarnings - $totalRefunded;

        // Service type breakdown earnings
        $classEarnings = BookOrder::where('teacher_id', $teacherId)
            ->whereHas('gig', function($q) {
                $q->where('service_role', 'Class');
            })
            ->whereIn('status', [2, 3]) // Delivered or Completed
            ->when($dateFrom, fn($q) => $q->where('created_at', '>=', $dateFrom))
            ->when($dateTo, fn($q) => $q->where('created_at', '<=', $dateTo))
            ->sum('seller_earnings');

        $freelanceEarnings = BookOrder::where('teacher_id', $teacherId)
            ->whereHas('gig', function($q) {
                $q->where('service_role', 'Freelance');
            })
            ->whereIn('status', [2, 3])
            ->when($dateFrom, fn($q) => $q->where('created_at', '>=', $dateFrom))
            ->when($dateTo, fn($q) => $q->where('created_at', '<=', $dateTo))
            ->sum('seller_earnings');

        $onlineEarnings = BookOrder::where('teacher_id', $teacherId)
            ->whereHas('gig', function($q) {
                $q->where('service_type', 'Online');
            })
            ->whereIn('status', [2, 3])
            ->when($dateFrom, fn($q) => $q->where('created_at', '>=', $dateFrom))
            ->when($dateTo, fn($q) => $q->where('created_at', '<=', $dateTo))
            ->sum('seller_earnings');

        $inpersonEarnings = BookOrder::where('teacher_id', $teacherId)
            ->whereHas('gig', function($q) {
                $q->where('service_type', 'Inperson');
            })
            ->whereIn('status', [2, 3])
            ->when($dateFrom, fn($q) => $q->where('created_at', '>=', $dateFrom))
            ->when($dateTo, fn($q) => $q->where('created_at', '<=', $dateTo))
            ->sum('seller_earnings');

        return [
            'total_earnings' => round($totalEarnings, 2),
            'pending_earnings' => round($pendingEarnings, 2),
            'pending_payouts' => round($pendingPayouts, 2),
            'completed_payouts' => round($completedPayouts, 2),
            'month_earnings' => round($monthEarnings, 2),
            'today_earnings' => round($todayEarnings, 2),
            'avg_order_value' => round($completedStats->avg_order_value ?? 0, 2),
            'total_commission_paid' => round($totalCommission, 2),
            'total_refunded' => round($totalRefunded, 2),
            'net_earnings' => round($netEarnings, 2),
            'transaction_count' => $completedStats->transaction_count ?? 0,
            'class_earnings' => round($classEarnings, 2),
            'freelance_earnings' => round($freelanceEarnings, 2),
            'online_earnings' => round($onlineEarnings, 2),
            'inperson_earnings' => round($inpersonEarnings, 2),
        ];
    }

    /**
     * Get order statistics from book_orders table
     *
     * @param int $teacherId
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return array
     */
    public function getOrderStatistics($teacherId, $dateFrom = null, $dateTo = null)
    {
        $baseQuery = BookOrder::where('teacher_id', $teacherId);

        // Apply date filters
        if ($dateFrom) {
            $baseQuery->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $baseQuery->where('created_at', '<=', $dateTo);
        }

        // Status counts
        $totalOrders = $baseQuery->clone()->count();
        $activeOrders = $baseQuery->clone()->where('status', 1)->count();
        $pendingOrders = $baseQuery->clone()->where('status', 0)->count();
        $deliveredOrders = $baseQuery->clone()->where('status', 2)->count();
        $completedOrders = $baseQuery->clone()->where('status', 3)->count();
        $cancelledOrders = $baseQuery->clone()->where('status', 4)->count();

        // Disputed orders
        $disputedOrders = $baseQuery->clone()
            ->where(function($q) {
                $q->where('user_dispute', 1)
                  ->orWhere('teacher_dispute', 1);
            })
            ->count();

        // Service type breakdowns
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

        // Calculate rates
        $completionRate = $totalOrders > 0 ? round(($completedOrders / $totalOrders) * 100, 1) : 0;
        $cancellationRate = $totalOrders > 0 ? round(($cancelledOrders / $totalOrders) * 100, 1) : 0;

        return [
            'total_orders' => $totalOrders,
            'active_orders' => $activeOrders,
            'pending_orders' => $pendingOrders,
            'delivered_orders' => $deliveredOrders,
            'completed_orders' => $completedOrders,
            'cancelled_orders' => $cancelledOrders,
            'disputed_orders' => $disputedOrders,
            'class_bookings' => $classBookings,
            'freelance_bookings' => $freelanceBookings,
            'online_bookings' => $onlineBookings,
            'inperson_bookings' => $inpersonBookings,
            'completion_rate' => $completionRate,
            'cancellation_rate' => $cancellationRate,
        ];
    }

    /**
     * Get service performance metrics
     *
     * @param int $teacherId
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return array
     */
    public function getServicePerformance($teacherId, $dateFrom = null, $dateTo = null)
    {
        $gigQuery = TeacherGig::where('user_id', $teacherId);

        if ($dateFrom) {
            $gigQuery->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $gigQuery->where('created_at', '<=', $dateTo);
        }

        // Gig counts
        $totalGigs = $gigQuery->clone()->count();
        $activeGigs = $gigQuery->clone()->where('status', 1)->count();
        $inactiveGigs = $gigQuery->clone()->where('status', 0)->count();

        // Performance metrics (from all gigs, not filtered by date typically)
        $allGigsQuery = TeacherGig::where('user_id', $teacherId);

        $performanceStats = $allGigsQuery->selectRaw('
            SUM(impressions) as total_impressions,
            SUM(clicks) as total_clicks,
            SUM(orders) as total_orders
        ')->first();

        $totalImpressions = $performanceStats->total_impressions ?? 0;
        $totalClicks = $performanceStats->total_clicks ?? 0;
        $totalOrders = $performanceStats->total_orders ?? 0;

        // Calculate rates
        $ctr = $totalImpressions > 0 ? round(($totalClicks / $totalImpressions) * 100, 2) : 0;
        $conversionRate = $totalClicks > 0 ? round(($totalOrders / $totalClicks) * 100, 2) : 0;

        return [
            'total_gigs' => $totalGigs,
            'active_gigs' => $activeGigs,
            'inactive_gigs' => $inactiveGigs,
            'total_impressions' => $totalImpressions,
            'total_clicks' => $totalClicks,
            'total_gig_orders' => $totalOrders,
            'click_through_rate' => $ctr,
            'conversion_rate' => $conversionRate,
        ];
    }

    /**
     * Get engagement and quality metrics
     *
     * @param int $teacherId
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return array
     */
    public function getEngagementMetrics($teacherId, $dateFrom = null, $dateTo = null)
    {
        // Reviews query
        $reviewsQuery = ServiceReviews::where('teacher_id', $teacherId)
            ->whereNull('parent_id'); // Only parent reviews, not replies

        if ($dateFrom) {
            $reviewsQuery->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $reviewsQuery->where('created_at', '<=', $dateTo);
        }

        $totalReviews = $reviewsQuery->clone()->count();
        $avgRating = $reviewsQuery->clone()->avg('rating');
        $fiveStarReviews = $reviewsQuery->clone()->where('rating', 5)->count();

        // Unique clients
        $clientsQuery = BookOrder::where('teacher_id', $teacherId)
            ->distinct('user_id');

        if ($dateFrom) {
            $clientsQuery->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $clientsQuery->where('created_at', '<=', $dateTo);
        }

        $totalClients = $clientsQuery->count('user_id');

        // Repeat customers (clients with 2+ orders)
        $repeatCustomersQuery = BookOrder::where('teacher_id', $teacherId)
            ->select('user_id', DB::raw('COUNT(*) as order_count'))
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) >= 2');

        if ($dateFrom) {
            $repeatCustomersQuery->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $repeatCustomersQuery->where('created_at', '<=', $dateTo);
        }

        $repeatCustomers = $repeatCustomersQuery->count();
        $repeatCustomerRate = $totalClients > 0 ? round(($repeatCustomers / $totalClients) * 100, 1) : 0;

        return [
            'total_reviews' => $totalReviews,
            'avg_rating' => $avgRating ? round($avgRating, 2) : 0,
            'five_star_reviews' => $fiveStarReviews,
            'total_clients' => $totalClients,
            'repeat_customers' => $repeatCustomers,
            'repeat_customer_rate' => $repeatCustomerRate,
        ];
    }

    /**
     * Get monthly earnings trend for chart (last N months)
     *
     * @param int $teacherId
     * @param int $months
     * @return array
     */
    public function getMonthlyEarningsTrend($teacherId, $months = 6)
    {
        $data = Transaction::where('seller_id', $teacherId)
            ->where('status', 'completed')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month,
                         SUM(seller_earnings) as earnings,
                         COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths($months))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Fill in missing months with zero values
        $monthsArray = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $monthsArray[$month] = [
                'month' => $month,
                'earnings' => 0,
                'count' => 0,
            ];
        }

        // Merge with actual data
        foreach ($data as $item) {
            $monthsArray[$item->month] = [
                'month' => $item->month,
                'earnings' => round($item->earnings, 2),
                'count' => $item->count,
            ];
        }

        $result = array_values($monthsArray);

        return [
            'labels' => array_map(function ($item) {
                return Carbon::parse($item['month'] . '-01')->format('M Y');
            }, $result),
            'earnings' => array_column($result, 'earnings'),
            'count' => array_column($result, 'count'),
        ];
    }

    /**
     * Get order status breakdown for pie chart
     *
     * @param int $teacherId
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return array
     */
    public function getOrderStatusBreakdown($teacherId, $dateFrom = null, $dateTo = null)
    {
        $query = BookOrder::where('teacher_id', $teacherId)
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
     * Get recent bookings
     *
     * @param int $teacherId
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecentBookings($teacherId, $limit = 10)
    {
        return BookOrder::where('teacher_id', $teacherId)
            ->with(['gig', 'user', 'transaction'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Apply date preset filter
     *
     * @param string $preset
     * @return array [from, to]
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
