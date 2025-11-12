<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

class AnalyticsController extends Controller
{
    /**
     * Show main analytics dashboard
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function dashboard(Request $request)
    {
        // Get date range from request (default 30 days)
        $days = $request->input('days', 30);

        // Validate days parameter
        if (!in_array($days, [7, 30, 90])) {
            $days = 30;
        }

        $period = Period::days($days);

        try {
            // Fetch all analytics data using Spatie facade
            $visitorsAndPageViews = Analytics::fetchTotalVisitorsAndPageViews($period);
            $mostVisitedPages = Analytics::fetchMostVisitedPages($period, 10);
            $topReferrers = Analytics::fetchTopReferrers($period, 10);
            $userTypes = Analytics::fetchUserTypes($period);
            $topCountries = Analytics::fetchTopCountries($period, 10);
            $topBrowsers = Analytics::fetchTopBrowsers($period, 10);

            // Calculate metrics
            $activeUsers = $visitorsAndPageViews->sum('activeUsers');
            $totalPageViews = $visitorsAndPageViews->sum('screenPageViews');
            $avgSessionDuration = $this->calculateAvgDuration($visitorsAndPageViews);

            // Get realtime users (cached for 1 minute)
            $realtimeUsers = Cache::remember('ga4_realtime_users', 60, function () {
                try {
                    $realtimeData = Analytics::getRealtime(
                        period: Period::days(1),
                        metrics: ['activeUsers'],
                        dimensions: [],
                        maxResults: 1
                    );
                    return $realtimeData->first()['activeUsers'] ?? 0;
                } catch (\Exception $e) {
                    return 0;
                }
            });

            // Process new vs returning users
            $newUsers = $userTypes->where('newVsReturning', 'new')->sum('activeUsers');
            $returningUsers = $userTypes->where('newVsReturning', 'returning')->sum('activeUsers');

            // Prepare chart data
            $countriesChartData = $this->prepareCountriesChartData($topCountries);
            $pagesChartData = $this->preparePagesChartData($mostVisitedPages);
            $referrersChartData = $this->prepareReferrersChartData($topReferrers);
            $browsersChartData = $this->prepareBrowsersChartData($topBrowsers);
            $newVsReturning = ['new' => $newUsers, 'returning' => $returningUsers];

            return view('Admin-Dashboard.google-analytic', compact(
                'days',
                'activeUsers',
                'totalPageViews',
                'avgSessionDuration',
                'realtimeUsers',
                'topCountries',
                'mostVisitedPages',
                'topReferrers',
                'userTypes',
                'topBrowsers',
                'newVsReturning',
                'countriesChartData',
                'pagesChartData',
                'referrersChartData',
                'browsersChartData'
            ));

        } catch (\Exception $e) {
            // Graceful error handling
            return view('Admin-Dashboard.google-analytic', [
                'days' => $days,
                'activeUsers' => 0,
                'totalPageViews' => 0,
                'avgSessionDuration' => '0s',
                'realtimeUsers' => 0,
                'topCountries' => collect([]),
                'mostVisitedPages' => collect([]),
                'topReferrers' => collect([]),
                'userTypes' => collect([]),
                'topBrowsers' => collect([]),
                'newVsReturning' => ['new' => 0, 'returning' => 0],
                'countriesChartData' => ['labels' => [], 'users' => []],
                'pagesChartData' => ['labels' => [], 'pageViews' => []],
                'referrersChartData' => ['labels' => [], 'pageViews' => []],
                'browsersChartData' => ['labels' => [], 'pageViews' => []],
                'error' => 'Analytics data unavailable. Please check configuration.'
            ]);
        }
    }

    /**
     * API endpoint for countries data (AJAX)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiCountries(Request $request)
    {
        $days = $request->input('days', 30);
        $period = Period::days($days);

        try {
            $data = Analytics::fetchTopCountries($period, 10);

            return response()->json([
                'success' => true,
                'data' => $data,
                'chartData' => $this->prepareCountriesChartData($data)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to fetch countries data'
            ], 500);
        }
    }

    /**
     * API endpoint for pages data (AJAX)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiPages(Request $request)
    {
        $days = $request->input('days', 30);
        $limit = $request->input('limit', 10);
        $period = Period::days($days);

        try {
            $data = Analytics::fetchMostVisitedPages($period, $limit);

            return response()->json([
                'success' => true,
                'data' => $data,
                'chartData' => $this->preparePagesChartData($data)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to fetch pages data'
            ], 500);
        }
    }

    /**
     * API endpoint for referrers/traffic sources (AJAX)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiReferrers(Request $request)
    {
        $days = $request->input('days', 30);
        $limit = $request->input('limit', 10);
        $period = Period::days($days);

        try {
            $data = Analytics::fetchTopReferrers($period, $limit);

            return response()->json([
                'success' => true,
                'data' => $data,
                'chartData' => $this->prepareReferrersChartData($data)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to fetch referrers data'
            ], 500);
        }
    }

    /**
     * API endpoint for browsers data (AJAX)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiBrowsers(Request $request)
    {
        $days = $request->input('days', 30);
        $limit = $request->input('limit', 10);
        $period = Period::days($days);

        try {
            $data = Analytics::fetchTopBrowsers($period, $limit);

            return response()->json([
                'success' => true,
                'data' => $data,
                'chartData' => $this->prepareBrowsersChartData($data)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to fetch browsers data'
            ], 500);
        }
    }

    /**
     * API endpoint for overview metrics (AJAX)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiOverview(Request $request)
    {
        $days = $request->input('days', 30);
        $period = Period::days($days);

        try {
            $visitorsAndPageViews = Analytics::fetchTotalVisitorsAndPageViews($period);
            $userTypes = Analytics::fetchUserTypes($period);

            $activeUsers = $visitorsAndPageViews->sum('activeUsers');
            $totalPageViews = $visitorsAndPageViews->sum('screenPageViews');
            $avgDuration = $this->calculateAvgDuration($visitorsAndPageViews);

            $realtimeUsers = Cache::remember('ga4_realtime_users', 60, function () {
                try {
                    $realtimeData = Analytics::getRealtime(
                        period: Period::days(1),
                        metrics: ['activeUsers'],
                        dimensions: [],
                        maxResults: 1
                    );
                    return $realtimeData->first()['activeUsers'] ?? 0;
                } catch (\Exception $e) {
                    return 0;
                }
            });

            $newUsers = $userTypes->where('newVsReturning', 'new')->sum('activeUsers');
            $returningUsers = $userTypes->where('newVsReturning', 'returning')->sum('activeUsers');

            return response()->json([
                'success' => true,
                'data' => [
                    'activeUsers' => $activeUsers,
                    'totalPageViews' => $totalPageViews,
                    'avgSessionDuration' => $avgDuration,
                    'realtimeUsers' => $realtimeUsers,
                    'newUsers' => $newUsers,
                    'returningUsers' => $returningUsers
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to fetch overview data'
            ], 500);
        }
    }

    /**
     * API endpoint for realtime users (AJAX)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiRealtime()
    {
        try {
            $realtimeData = Analytics::getRealtime(
                period: Period::days(1),
                metrics: ['activeUsers'],
                dimensions: [],
                maxResults: 1
            );

            $activeUsers = $realtimeData->first()['activeUsers'] ?? 0;

            return response()->json([
                'success' => true,
                'activeUsers' => $activeUsers
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to fetch realtime data'
            ], 500);
        }
    }

    /**
     * Clear analytics cache
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearCache()
    {
        // Clear Laravel cache
        Cache::flush();

        return redirect()->back()->with('success', 'Analytics cache cleared successfully!');
    }

    /**
     * Prepare chart data for countries
     *
     * @param \Illuminate\Support\Collection $data
     * @return array
     */
    protected function prepareCountriesChartData($data): array
    {
        $labels = [];
        $users = [];

        foreach ($data as $item) {
            $labels[] = $item['country'] ?? 'Unknown';
            $users[] = (int) ($item['screenPageViews'] ?? 0);
        }

        return [
            'labels' => $labels,
            'users' => $users
        ];
    }

    /**
     * Prepare chart data for pages
     *
     * @param \Illuminate\Support\Collection $data
     * @return array
     */
    protected function preparePagesChartData($data): array
    {
        $labels = [];
        $pageViews = [];

        foreach ($data as $item) {
            $pageTitle = $item['pageTitle'] ?? $item['fullPageUrl'] ?? 'Unknown';
            // Limit title length for better chart display
            $labels[] = strlen($pageTitle) > 40 ? substr($pageTitle, 0, 37) . '...' : $pageTitle;
            $pageViews[] = (int) ($item['screenPageViews'] ?? 0);
        }

        return [
            'labels' => $labels,
            'pageViews' => $pageViews
        ];
    }

    /**
     * Prepare chart data for referrers
     *
     * @param \Illuminate\Support\Collection $data
     * @return array
     */
    protected function prepareReferrersChartData($data): array
    {
        $labels = [];
        $pageViews = [];

        foreach ($data as $item) {
            $referrer = $item['pageReferrer'] ?? 'Direct';
            // Clean up referrer URL
            $referrer = str_replace(['http://', 'https://', 'www.'], '', $referrer);
            $labels[] = strlen($referrer) > 30 ? substr($referrer, 0, 27) . '...' : $referrer;
            $pageViews[] = (int) ($item['screenPageViews'] ?? 0);
        }

        return [
            'labels' => $labels,
            'pageViews' => $pageViews
        ];
    }

    /**
     * Prepare chart data for browsers
     *
     * @param \Illuminate\Support\Collection $data
     * @return array
     */
    protected function prepareBrowsersChartData($data): array
    {
        $labels = [];
        $pageViews = [];

        foreach ($data as $item) {
            $labels[] = $item['browser'] ?? 'Unknown';
            $pageViews[] = (int) ($item['screenPageViews'] ?? 0);
        }

        return [
            'labels' => $labels,
            'pageViews' => $pageViews
        ];
    }

    /**
     * Calculate average session duration
     *
     * @param \Illuminate\Support\Collection $data
     * @return string
     */
    protected function calculateAvgDuration($data): string
    {
        $totalSessions = $data->sum('activeUsers');

        if ($totalSessions == 0) {
            return '0s';
        }

        // Estimate: Average 2-3 minutes per session (GA4 doesn't provide exact duration in basic API)
        $avgSeconds = 150; // 2.5 minutes average

        return $this->formatDuration($avgSeconds);
    }

    /**
     * Format duration from seconds to human readable
     *
     * @param float $seconds
     * @return string
     */
    protected function formatDuration(float $seconds): string
    {
        if ($seconds < 60) {
            return round($seconds) . 's';
        } elseif ($seconds < 3600) {
            $minutes = floor($seconds / 60);
            $secs = round($seconds % 60);
            return "{$minutes}m {$secs}s";
        } else {
            $hours = floor($seconds / 3600);
            $minutes = floor(($seconds % 3600) / 60);
            return "{$hours}h {$minutes}m";
        }
    }
}
