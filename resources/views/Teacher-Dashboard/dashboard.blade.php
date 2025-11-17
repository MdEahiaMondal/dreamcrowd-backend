<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Teacher Dashboard | DreamCrowd</title>

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="/assets/teacher/asset/css/bootstrap.min.css"/>
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/assets/teacher/asset/css/sidebar.css"/>
    <link rel="stylesheet" href="/assets/teacher/asset/css/style.css">
    <link rel="stylesheet" href="/assets/teacher/asset/css/Dashboard.css">

    {{-- Fav Icon --}}
    @php $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="/assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
    @endif

    <!-- Flatpickr for Date Picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        .dashboard-loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .dashboard-loading.active {
            display: flex;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #28a745;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .stat-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 28px;
        }

        .stat-content {
            flex: 1;
        }

        .stat-label {
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 26px;
            font-weight: 700;
            margin: 0;
            color: #212529;
        }

        .stat-sublabel {
            font-size: 11px;
            color: #6c757d;
        }

        .stat-card-small {
            background: #fff;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stat-card-small:hover {
            transform: translateY(-3px);
        }

        .stat-card-small .stat-value {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-card-small .stat-label {
            font-size: 12px;
            color: #6c757d;
        }

        .status-active {
            border-left: 4px solid #007bff;
        }

        .status-pending {
            border-left: 4px solid #ffc107;
        }

        .status-completed {
            border-left: 4px solid #28a745;
        }

        .status-cancelled {
            border-left: 4px solid #dc3545;
        }

        .status-delivered {
            border-left: 4px solid #17a2b8;
        }

        .filter-panel {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .filter-preset {
            margin: 3px;
            font-size: 13px;
        }

        .filter-preset.active {
            background: #28a745;
            border-color: #28a745;
            color: #fff;
        }

        .section-header {
            margin-top: 30px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
        }

        .section-header h5 {
            font-weight: 600;
            color: #495057;
        }

        .chart-card {
            background: #fff;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-radius: 10px;
        }

        .chart-card .card-title {
            font-weight: 600;
            color: #495057;
            margin-bottom: 20px;
        }

        .chart-container {
            position: relative;
        }

        .input-group {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<!-- Loading Overlay -->
<div class="dashboard-loading" id="dashboardLoading">
    <div class="spinner"></div>
</div>

<!-- Sidebar -->
<x-teacher-sidebar/>

<section class="home-section">
    <!-- Navigation -->
    <x-teacher-nav/>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="row dash-notification">

            <!-- Page Header -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <h2><i class='bx bx-grid-alt'></i> Teacher Dashboard</h2>
                    <p class="text-muted">Welcome back, {{ Auth::user()->name }}! Here's your performance overview.</p>
                </div>
            </div>

            <!-- Date Filter Panel -->
            <div class="filter-panel card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="mb-3">Filter by Date Range</h6>
                            <div class="btn-group flex-wrap" role="group">
                                <button type="button" class="btn btn-outline-success filter-preset active"
                                        data-preset="all_time">All Time
                                </button>
                                <button type="button" class="btn btn-outline-success filter-preset" data-preset="today">
                                    Today
                                </button>
                                <button type="button" class="btn btn-outline-success filter-preset"
                                        data-preset="yesterday">Yesterday
                                </button>
                                <button type="button" class="btn btn-outline-success filter-preset"
                                        data-preset="this_week">This Week
                                </button>
                                <button type="button" class="btn btn-outline-success filter-preset"
                                        data-preset="last_week">Last Week
                                </button>
                                <button type="button" class="btn btn-outline-success filter-preset"
                                        data-preset="this_month">This Month
                                </button>
                                <button type="button" class="btn btn-outline-success filter-preset"
                                        data-preset="last_month">Last Month
                                </button>
                                <button type="button" class="btn btn-outline-success filter-preset"
                                        data-preset="last_3_months">Last 3 Months
                                </button>
                                <button type="button" class="btn btn-outline-success filter-preset"
                                        data-preset="last_6_months">Last 6 Months
                                </button>
                                <button type="button" class="btn btn-outline-success filter-preset"
                                        data-preset="last_year">Last Year
                                </button>
                                <button type="button" class="btn btn-outline-success filter-preset"
                                        data-preset="year_to_date">Year to Date
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6 class="mb-3">Custom Date Range</h6>
                            <div class="input-group">
                                <input type="text" class="form-control" id="dateFrom" placeholder="From Date">
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control" id="dateTo" placeholder="To Date">
                            </div>
                            <button class="btn btn-success w-100" onclick="applyCustomDateFilter()">Apply Custom
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Financial Statistics -->
            <div class="section-header mb-3">
                <h5><i class='bx bx-dollar-circle'></i> Financial Overview</h5>
            </div>
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" style="border-left: 4px solid #28a745;">
                        <div class="stat-icon" style="background: rgba(40, 167, 69, 0.1);">
                            <i class='bx bx-wallet' style="color: #28a745;"></i>
                        </div>
                        <div class="stat-content">
                            <p class="stat-label">Total Earnings</p>
                            <h3 class="stat-value" id="stat-total-earnings">$0.00</h3>
                            <small class="stat-sublabel">All-time revenue</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" style="border-left: 4px solid #17a2b8;">
                        <div class="stat-icon" style="background: rgba(23, 162, 184, 0.1);">
                            <i class='bx bx-calendar' style="color: #17a2b8;"></i>
                        </div>
                        <div class="stat-content">
                            <p class="stat-label">This Month</p>
                            <h3 class="stat-value" id="stat-month-earnings">$0.00</h3>
                            <small class="stat-sublabel" id="current-month">{{ now()->format('F Y') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" style="border-left: 4px solid #6f42c1;">
                        <div class="stat-icon" style="background: rgba(111, 66, 193, 0.1);">
                            <i class='bx bx-trending-up' style="color: #6f42c1;"></i>
                        </div>
                        <div class="stat-content">
                            <p class="stat-label">Avg Order Value</p>
                            <h3 class="stat-value" id="stat-avg-order">$0.00</h3>
                            <small class="stat-sublabel">Per booking</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" style="border-left: 4px solid #ffc107;">
                        <div class="stat-icon" style="background: rgba(255, 193, 7, 0.1);">
                            <i class='bx bx-time-five' style="color: #ffc107;"></i>
                        </div>
                        <div class="stat-content">
                            <p class="stat-label">Pending Earnings</p>
                            <h3 class="stat-value" id="stat-pending-earnings">$0.00</h3>
                            <small class="stat-sublabel">In 48hr window</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" style="border-left: 4px solid #20c997;">
                        <div class="stat-icon" style="background: rgba(32, 201, 151, 0.1);">
                            <i class='bx bx-check-circle' style="color: #20c997;"></i>
                        </div>
                        <div class="stat-content">
                            <p class="stat-label">Completed Payouts</p>
                            <h3 class="stat-value" id="stat-completed-payouts">$0.00</h3>
                            <small class="stat-sublabel">Already paid out</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" style="border-left: 4px solid #6c757d;">
                        <div class="stat-icon" style="background: rgba(108, 117, 125, 0.1);">
                            <i class='bx bx-credit-card' style="color: #6c757d;"></i>
                        </div>
                        <div class="stat-content">
                            <p class="stat-label">Commission Paid</p>
                            <h3 class="stat-value" id="stat-commission-paid">$0.00</h3>
                            <small class="stat-sublabel">Platform fees</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" style="border-left: 4px solid #fd7e14;">
                        <div class="stat-icon" style="background: rgba(253, 126, 20, 0.1);">
                            <i class='bx bx-hourglass' style="color: #fd7e14;"></i>
                        </div>
                        <div class="stat-content">
                            <p class="stat-label">Pending Payouts</p>
                            <h3 class="stat-value" id="stat-pending-payouts">$0.00</h3>
                            <small class="stat-sublabel">Ready for payout</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" style="border-left: 4px solid #198754;">
                        <div class="stat-icon" style="background: rgba(25, 135, 84, 0.1);">
                            <i class='bx bx-dollar' style="color: #198754;"></i>
                        </div>
                        <div class="stat-content">
                            <p class="stat-label">Net Earnings</p>
                            <h3 class="stat-value" id="stat-net-earnings">$0.00</h3>
                            <small class="stat-sublabel">After refunds</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Statistics -->
            <div class="section-header mb-3">
                <h5><i class='bx bx-shopping-bag'></i> Booking Statistics</h5>
            </div>
            <div class="row mb-4">
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-total-orders">0</h3>
                        <p class="stat-label">Total Bookings</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="stat-card-small status-active">
                        <h3 class="stat-value" id="stat-active-orders">0</h3>
                        <p class="stat-label">Active</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="stat-card-small status-pending">
                        <h3 class="stat-value" id="stat-pending-orders">0</h3>
                        <p class="stat-label">Pending</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="stat-card-small status-delivered">
                        <h3 class="stat-value" id="stat-delivered-orders">0</h3>
                        <p class="stat-label">Delivered</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="stat-card-small status-completed">
                        <h3 class="stat-value" id="stat-completed-orders">0</h3>
                        <p class="stat-label">Completed</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="stat-card-small status-cancelled">
                        <h3 class="stat-value" id="stat-cancelled-orders">0</h3>
                        <p class="stat-label">Cancelled</p>
                    </div>
                </div>
            </div>

            <!-- Service Type Breakdown -->
            <div class="section-header mb-3">
                <h5><i class='bx bx-category'></i> Service Performance</h5>
            </div>
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-class-bookings">0</h3>
                        <p class="stat-label">Class Bookings</p>
                        <small class="text-success fw-bold" id="stat-class-earnings">$0.00</small>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-freelance-bookings">0</h3>
                        <p class="stat-label">Freelance Bookings</p>
                        <small class="text-success fw-bold" id="stat-freelance-earnings">$0.00</small>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-online-bookings">0</h3>
                        <p class="stat-label">Online Bookings</p>
                        <small class="text-success fw-bold" id="stat-online-earnings">$0.00</small>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-inperson-bookings">0</h3>
                        <p class="stat-label">In-Person Bookings</p>
                        <small class="text-success fw-bold" id="stat-inperson-earnings">$0.00</small>
                    </div>
                </div>
            </div>

            <!-- Service Performance Metrics -->
            <div class="section-header mb-3">
                <h5><i class='bx bx-line-chart'></i> Gig Performance</h5>
            </div>
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-active-gigs">0</h3>
                        <p class="stat-label">Active Gigs</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-total-impressions">0</h3>
                        <p class="stat-label">Total Impressions</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-total-clicks">0</h3>
                        <p class="stat-label">Total Clicks</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-conversion-rate">0%</h3>
                        <p class="stat-label">Conversion Rate</p>
                    </div>
                </div>
            </div>

            <!-- Engagement Metrics -->
            <div class="section-header mb-3">
                <h5><i class='bx bx-user-circle'></i> Engagement & Quality</h5>
            </div>
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-total-reviews">0</h3>
                        <p class="stat-label">Reviews Received</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-avg-rating">0.0</h3>
                        <p class="stat-label">Average Rating</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-total-clients">0</h3>
                        <p class="stat-label">Total Clients</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-repeat-customers">0</h3>
                        <p class="stat-label">Repeat Customers</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-completion-rate">0%</h3>
                        <p class="stat-label">Completion Rate</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-cancellation-rate">0%</h3>
                        <p class="stat-label">Cancellation Rate</p>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="row mb-4">
                <div class="col-lg-8 mb-3">
                    <div class="chart-card card">
                        <div class="card-body">
                            <h6 class="card-title"><i class='bx bx-line-chart'></i> Earnings Trend (Last 6 Months)</h6>
                            <div class="chart-container" style="height: 300px;">
                                <canvas id="earningsTrendChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="chart-card card">
                        <div class="card-body">
                            <h6 class="card-title"><i class='bx bx-pie-chart-alt'></i> Booking Status</h6>
                            <div class="chart-container" style="height: 300px;">
                                <canvas id="statusBreakdownChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class='bx bx-history'></i> Recent Bookings</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th>Service</th>
                                        <th>Customer</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($recentBookings as $booking)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($booking->gig && $booking->gig->images)
                                                        <img
                                                            src="/{{ json_decode($booking->gig->images)[0] ?? 'assets/default-service.jpg' }}"
                                                            alt="Service" class="rounded me-2"
                                                            style="width: 40px; height: 40px; object-fit: cover;">
                                                    @endif
                                                    <div>
                                                        <div class="fw-bold">{{ $booking->gig->title ?? 'N/A' }}</div>
                                                        <small class="text-muted">{{ $booking->gig->service_role ?? 'N/A' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold">{{ $booking->user->first_name ?? 'Unknown' }} {{ $booking->user->last_name ?? '' }}</div>
                                                <small class="text-muted">{{ $booking->user->country ?? '' }}</small>
                                            </td>
                                            <td>{{ $booking->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <span class="fw-bold text-success">${{ number_format($booking->seller_earnings ?? 0, 2) }}</span>
                                            </td>
                                            <td>
                                                @php
                                                    $statusLabels = ['0' => 'Pending', '1' => 'Active', '2' => 'Delivered', '3' => 'Completed', '4' => 'Cancelled'];
                                                    $statusColors = ['0' => 'warning', '1' => 'primary', '2' => 'info', '3' => 'success', '4' => 'danger'];
                                                @endphp
                                                <span
                                                    class="badge bg-{{ $statusColors[$booking->status] ?? 'secondary' }}">
                                                    {{ $statusLabels[$booking->status] ?? 'Unknown' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($recentBookings->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">
                                                No bookings found. Start creating your services to get bookings!
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="/assets/teacher/asset/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="/assets/teacher/asset/js/dashboard.js"></script>

<script>
    // Global variables
    let earningsTrendChart = null;
    let statusBreakdownChart = null;

    // Initialize on page load
    $(document).ready(function () {
        // Initialize CSRF token for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Load initial statistics (all time)
        loadDashboardStatistics('all_time');

        // Initialize date pickers
        flatpickr("#dateFrom", {
            dateFormat: "Y-m-d",
        });
        flatpickr("#dateTo", {
            dateFormat: "Y-m-d",
        });

        // Filter preset buttons
        $('.filter-preset').click(function () {
            $('.filter-preset').removeClass('active');
            $(this).addClass('active');
            const preset = $(this).data('preset');
            loadDashboardStatistics(preset);
        });
    });

    /**
     * Load dashboard statistics from API
     */
    function loadDashboardStatistics(preset, customFrom = null, customTo = null) {
        // Show loading
        $('#dashboardLoading').addClass('active');

        // Build URL with parameters
        let url = '/teacher-dashboard/statistics?preset=' + preset;
        if (customFrom && customTo) {
            url += '&date_from=' + customFrom + '&date_to=' + customTo;
        }

        // Fetch statistics
        $.ajax({
            url: url,
            method: 'GET',
            success: function (data) {
                updateStatistics(data);
                loadCharts(preset, customFrom, customTo);
            },
            error: function (xhr, status, error) {
                console.error('Error loading statistics:', error);
                alert('Failed to load dashboard statistics. Please refresh the page.');
            },
            complete: function () {
                $('#dashboardLoading').removeClass('active');
            }
        });
    }

    /**
     * Update all statistic cards with data
     */
    function updateStatistics(data) {
        // Financial statistics
        $('#stat-total-earnings').text('$' + parseFloat(data.financial.total_earnings).toFixed(2));
        $('#stat-month-earnings').text('$' + parseFloat(data.financial.month_earnings).toFixed(2));
        $('#stat-avg-order').text('$' + parseFloat(data.financial.avg_order_value).toFixed(2));
        $('#stat-pending-earnings').text('$' + parseFloat(data.financial.pending_earnings).toFixed(2));
        $('#stat-completed-payouts').text('$' + parseFloat(data.financial.completed_payouts).toFixed(2));
        $('#stat-commission-paid').text('$' + parseFloat(data.financial.total_commission_paid).toFixed(2));
        $('#stat-pending-payouts').text('$' + parseFloat(data.financial.pending_payouts).toFixed(2));
        $('#stat-net-earnings').text('$' + parseFloat(data.financial.net_earnings).toFixed(2));

        // Order statistics
        $('#stat-total-orders').text(data.orders.total_orders);
        $('#stat-active-orders').text(data.orders.active_orders);
        $('#stat-pending-orders').text(data.orders.pending_orders);
        $('#stat-delivered-orders').text(data.orders.delivered_orders);
        $('#stat-completed-orders').text(data.orders.completed_orders);
        $('#stat-cancelled-orders').text(data.orders.cancelled_orders);

        // Service type breakdown
        $('#stat-class-bookings').text(data.orders.class_bookings);
        $('#stat-class-earnings').text('$' + parseFloat(data.financial.class_earnings).toFixed(2));
        $('#stat-freelance-bookings').text(data.orders.freelance_bookings);
        $('#stat-freelance-earnings').text('$' + parseFloat(data.financial.freelance_earnings).toFixed(2));
        $('#stat-online-bookings').text(data.orders.online_bookings);
        $('#stat-online-earnings').text('$' + parseFloat(data.financial.online_earnings).toFixed(2));
        $('#stat-inperson-bookings').text(data.orders.inperson_bookings);
        $('#stat-inperson-earnings').text('$' + parseFloat(data.financial.inperson_earnings).toFixed(2));

        // Service performance
        $('#stat-active-gigs').text(data.service_performance.active_gigs);
        $('#stat-total-impressions').text(data.service_performance.total_impressions);
        $('#stat-total-clicks').text(data.service_performance.total_clicks);
        $('#stat-conversion-rate').text(parseFloat(data.service_performance.conversion_rate).toFixed(1) + '%');

        // Engagement metrics
        $('#stat-total-reviews').text(data.engagement.total_reviews);
        $('#stat-avg-rating').text(parseFloat(data.engagement.avg_rating).toFixed(1));
        $('#stat-total-clients').text(data.engagement.total_clients);
        $('#stat-repeat-customers').text(data.engagement.repeat_customers);
        $('#stat-completion-rate').text(parseFloat(data.orders.completion_rate).toFixed(1) + '%');
        $('#stat-cancellation-rate').text(parseFloat(data.orders.cancellation_rate).toFixed(1) + '%');
    }

    /**
     * Load and render charts
     */
    function loadCharts(preset, customFrom = null, customTo = null) {
        // Load earnings trend chart
        $.ajax({
            url: '/teacher-dashboard/earnings-trend',
            method: 'GET',
            success: function (data) {
                renderEarningsTrendChart(data);
            }
        });

        // Load order status chart
        let statusUrl = '/teacher-dashboard/order-status-chart?preset=' + preset;
        if (customFrom && customTo) {
            statusUrl += '&date_from=' + customFrom + '&date_to=' + customTo;
        }

        $.ajax({
            url: statusUrl,
            method: 'GET',
            success: function (data) {
                renderStatusBreakdownChart(data);
            }
        });
    }

    /**
     * Render earnings trend line chart
     */
    function renderEarningsTrendChart(data) {
        const ctx = document.getElementById('earningsTrendChart').getContext('2d');

        // Destroy existing chart if exists
        if (earningsTrendChart) {
            earningsTrendChart.destroy();
        }

        earningsTrendChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Earnings ($)',
                    data: data.earnings,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }

    /**
     * Render status breakdown pie chart
     */
    function renderStatusBreakdownChart(data) {
        const ctx = document.getElementById('statusBreakdownChart').getContext('2d');

        // Destroy existing chart if exists
        if (statusBreakdownChart) {
            statusBreakdownChart.destroy();
        }

        // Only create chart if there's data
        if (data.data.length === 0) {
            ctx.canvas.parentNode.innerHTML = '<p class="text-center text-muted py-5">No booking data available</p>';
            return;
        }

        statusBreakdownChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: data.labels,
                datasets: [{
                    data: data.data,
                    backgroundColor: data.backgroundColor,
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    /**
     * Apply custom date filter
     */
    function applyCustomDateFilter() {
        const dateFrom = $('#dateFrom').val();
        const dateTo = $('#dateTo').val();

        if (!dateFrom || !dateTo) {
            alert('Please select both from and to dates');
            return;
        }

        // Deactivate all preset buttons
        $('.filter-preset').removeClass('active');

        // Load statistics with custom dates
        loadDashboardStatistics('custom', dateFrom, dateTo);
    }
</script>
</body>
</html>
