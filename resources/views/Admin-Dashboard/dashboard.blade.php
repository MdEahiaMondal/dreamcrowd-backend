<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard | DreamCrowd</title>

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="/assets/admin/asset/css/bootstrap.min.css"/>
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/assets/admin/asset/css/sidebar.css"/>
    <link rel="stylesheet" href="/assets/admin/asset/css/style.css">
    <link rel="stylesheet" href="/assets/admin/asset/css/Dashboard.css">

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
            border-top: 5px solid #007bff;
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
            margin-bottom: 15px;
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

        .alert-card {
            background: #fff;
            border-left: 4px solid #dc3545;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .alert-card.critical {
            border-left-color: #dc3545;
            background: #fff5f5;
        }

        .alert-card.warning {
            border-left-color: #ffc107;
            background: #fffbf0;
        }

        .alert-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .alert-header i {
            font-size: 24px;
            margin-right: 10px;
            color: #dc3545;
        }

        .alert-header h6 {
            margin: 0;
            flex: 1;
            font-weight: 600;
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
            background: #007bff;
            border-color: #007bff;
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

        .input-group {
            margin-bottom: 10px;
        }

        .management-panel {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 20px;
            margin-bottom: 20px;
        }

        .management-panel h6 {
            font-weight: 600;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<!-- Loading Overlay -->
<div class="dashboard-loading" id="dashboardLoading">
    <div class="spinner"></div>
</div>

<!-- Sidebar -->
<x-admin-sidebar/>

<section class="home-section">
    <!-- Navigation -->
    <x-admin-nav/>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="row dash-notification">

            <!-- Page Header -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <h2><i class='bx bx-shield-alt'></i> Admin Dashboard</h2>
                    <p class="text-muted">Platform management and analytics center</p>
                </div>
                <div class="col-md-4 text-end d-none">
                    <button class="btn btn-primary" onclick="exportDashboard()">
                        <i class="bx bx-download"></i> Export Report
                    </button>
                </div>
            </div>

            <!-- Date Filter Panel -->
            <div class="filter-panel card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="mb-3">Filter by Date Range</h6>
                            <div class="btn-group flex-wrap" role="group">
                                <button type="button" class="btn btn-outline-primary filter-preset active" data-preset="all_time">All Time</button>
                                <button type="button" class="btn btn-outline-primary filter-preset" data-preset="today">Today</button>
                                <button type="button" class="btn btn-outline-primary filter-preset" data-preset="yesterday">Yesterday</button>
                                <button type="button" class="btn btn-outline-primary filter-preset" data-preset="this_week">This Week</button>
                                <button type="button" class="btn btn-outline-primary filter-preset" data-preset="last_week">Last Week</button>
                                <button type="button" class="btn btn-outline-primary filter-preset" data-preset="last_7_days">Last 7 Days</button>
                                <button type="button" class="btn btn-outline-primary filter-preset" data-preset="this_month">This Month</button>
                                <button type="button" class="btn btn-outline-primary filter-preset" data-preset="last_month">Last Month</button>
                                <button type="button" class="btn btn-outline-primary filter-preset" data-preset="last_3_months">Last 3 Months</button>
                                <button type="button" class="btn btn-outline-primary filter-preset" data-preset="last_6_months">Last 6 Months</button>
                                <button type="button" class="btn btn-outline-primary filter-preset" data-preset="last_year">Last Year</button>
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
                            <button class="btn btn-primary w-100" onclick="applyCustomDateFilter()">Apply Custom</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CRITICAL ALERTS -->
            <div class="row mb-4 d-none">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="alert-card critical">
                        <div class="alert-header">
                            <i class="bx bx-error-circle"></i>
                            <h6>Pending Applications</h6>
                            <span class="badge bg-danger" id="alert-applications">0</span>
                        </div>
                        <div class="alert-body">
                            <p class="mb-2">Seller applications awaiting review</p>
                            <a href="/all-application" class="btn btn-sm btn-danger">Review Now <i class="bx bx-right-arrow-alt"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="alert-card critical">
                        <div class="alert-header">
                            <i class="bx bx-message-square-error"></i>
                            <h6>Active Disputes</h6>
                            <span class="badge bg-danger" id="alert-disputes">0</span>
                        </div>
                        <div class="alert-body">
                            <p class="mb-2">Orders requiring resolution</p>
                            <button class="btn btn-sm btn-danger" onclick="viewDisputes()">Resolve <i class="bx bx-right-arrow-alt"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="alert-card warning">
                        <div class="alert-header">
                            <i class="bx bx-money-withdraw"></i>
                            <h6>Pending Payouts</h6>
                            <span class="badge bg-warning" id="alert-payout-amount">$0</span>
                        </div>
                        <div class="alert-body">
                            <p class="mb-2">Sellers awaiting payment</p>
                            <button class="btn btn-sm btn-warning" onclick="viewPayouts()">Process <i class="bx bx-right-arrow-alt"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="alert-card warning">
                        <div class="alert-header">
                            <i class="bx bx-undo"></i>
                            <h6>Pending Refunds</h6>
                            <span class="badge bg-warning" id="alert-refunds">0</span>
                        </div>
                        <div class="alert-body">
                            <p class="mb-2">Refund requests to approve</p>
                            <button class="btn btn-sm btn-warning" onclick="viewRefunds()">Approve <i class="bx bx-right-arrow-alt"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Financial Overview -->
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
                            <p class="stat-label">Total Admin Commission</p>
                            <h3 class="stat-value" id="stat-total-commission">$0.00</h3>
                            <small class="stat-sublabel">Platform revenue</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" style="border-left: 4px solid #17a2b8;">
                        <div class="stat-icon" style="background: rgba(23, 162, 184, 0.1);">
                            <i class='bx bx-calendar' style="color: #17a2b8;"></i>
                        </div>
                        <div class="stat-content">
                            <p class="stat-label">This Month Revenue</p>
                            <h3 class="stat-value" id="stat-month-revenue">$0.00</h3>
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
                            <p class="stat-label">Total GMV</p>
                            <h3 class="stat-value" id="stat-total-gmv">$0.00</h3>
                            <small class="stat-sublabel">Gross merchandise value</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" style="border-left: 4px solid #ffc107;">
                        <div class="stat-icon" style="background: rgba(255, 193, 7, 0.1);">
                            <i class='bx bx-time-five' style="color: #ffc107;"></i>
                        </div>
                        <div class="stat-content">
                            <p class="stat-label">Pending Payouts</p>
                            <h3 class="stat-value" id="stat-pending-payouts">$0.00</h3>
                            <small class="stat-sublabel">To sellers</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-avg-transaction">$0.00</h3>
                        <p class="stat-label">Avg Transaction</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-total-refunded">$0.00</h3>
                        <p class="stat-label">Total Refunded</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-coupon-discount">$0.00</h3>
                        <p class="stat-label">Coupon Discounts</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-net-revenue">$0.00</h3>
                        <p class="stat-label">Net Revenue</p>
                    </div>
                </div>
            </div>

            <!-- User Management -->
            <div class="section-header mb-3">
                <h5><i class='bx bx-user'></i> User Management</h5>
            </div>
            <div class="row mb-4">
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-total-users">0</h3>
                        <p class="stat-label">Total Users</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-total-sellers">0</h3>
                        <p class="stat-label">Sellers</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-total-buyers">0</h3>
                        <p class="stat-label">Buyers</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-new-signups-today">0</h3>
                        <p class="stat-label">New Today</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-new-signups-week">0</h3>
                        <p class="stat-label">New This Week</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-active-users">0</h3>
                        <p class="stat-label">Active Users</p>
                    </div>
                </div>
            </div>

            <!-- Order Statistics -->
            <div class="section-header mb-3">
                <h5><i class='bx bx-shopping-bag'></i> Order Statistics</h5>
            </div>
            <div class="row mb-4">
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-total-orders">0</h3>
                        <p class="stat-label">Total Orders</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="stat-card-small" style="border-left: 4px solid #007bff;">
                        <h3 class="stat-value" id="stat-active-orders">0</h3>
                        <p class="stat-label">Active</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="stat-card-small" style="border-left: 4px solid #ffc107;">
                        <h3 class="stat-value" id="stat-pending-orders">0</h3>
                        <p class="stat-label">Pending</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="stat-card-small" style="border-left: 4px solid #17a2b8;">
                        <h3 class="stat-value" id="stat-delivered-orders">0</h3>
                        <p class="stat-label">Delivered</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="stat-card-small" style="border-left: 4px solid #28a745;">
                        <h3 class="stat-value" id="stat-completed-orders">0</h3>
                        <p class="stat-label">Completed</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="stat-card-small" style="border-left: 4px solid #dc3545;">
                        <h3 class="stat-value" id="stat-cancelled-orders">0</h3>
                        <p class="stat-label">Cancelled</p>
                    </div>
                </div>
            </div>

            <!-- Service Performance -->
            <div class="section-header mb-3">
                <h5><i class='bx bx-line-chart'></i> Service Performance</h5>
            </div>
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-total-services">0</h3>
                        <p class="stat-label">Total Services</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-active-services">0</h3>
                        <p class="stat-label">Active Services</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-conversion-rate">0%</h3>
                        <p class="stat-label">Conversion Rate</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-avg-rating">0.0</h3>
                        <p class="stat-label">Avg Rating</p>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="row mb-4">
                <div class="col-lg-8 mb-3">
                    <div class="chart-card card">
                        <div class="card-body">
                            <h6 class="card-title"><i class='bx bx-line-chart'></i> Revenue Trend (Last 12 Months)</h6>
                            <div class="chart-container" style="height: 300px;">
                                <canvas id="revenueChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="chart-card card">
                        <div class="card-body">
                            <h6 class="card-title"><i class='bx bx-pie-chart-alt'></i> Order Status</h6>
                            <div class="chart-container" style="height: 300px;">
                                <canvas id="orderStatusChart"></canvas>
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
<script src="/assets/admin/asset/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    // Global variables
    let revenueChart = null;
    let orderStatusChart = null;

    // Initialize on page load
    $(document).ready(function () {
        // Initialize CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Load initial statistics
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
        $('#dashboardLoading').addClass('active');

        let url = '/admin-dashboard/statistics?preset=' + preset;
        if (customFrom && customTo) {
            url += '&date_from=' + customFrom + '&date_to=' + customTo;
        }

        $.ajax({
            url: url,
            method: 'GET',
            success: function (data) {
                updateStatistics(data);
                loadCharts(preset, customFrom, customTo);
            },
            error: function (xhr, status, error) {
                console.error('Error loading statistics:', error);
                alert('Failed to load dashboard statistics.');
            },
            complete: function () {
                $('#dashboardLoading').removeClass('active');
            }
        });
    }

    /**
     * Update all statistics
     */
    function updateStatistics(data) {
        // Financial
        $('#stat-total-commission').text('$' + parseFloat(data.financial.total_admin_commission).toFixed(2));
        $('#stat-month-revenue').text('$' + parseFloat(data.financial.month_revenue).toFixed(2));
        $('#stat-total-gmv').text('$' + parseFloat(data.financial.total_gmv).toFixed(2));
        $('#stat-pending-payouts').text('$' + parseFloat(data.financial.pending_payouts).toFixed(2));
        $('#stat-avg-transaction').text('$' + parseFloat(data.financial.avg_transaction_value).toFixed(2));
        $('#stat-total-refunded').text('$' + parseFloat(data.financial.total_refunded).toFixed(2));
        $('#stat-coupon-discount').text('$' + parseFloat(data.financial.total_coupon_discount).toFixed(2));
        $('#stat-net-revenue').text('$' + parseFloat(data.financial.net_platform_revenue).toFixed(2));

        // Alerts
        $('#alert-applications').text(data.applications.pending_applications);
        $('#alert-disputes').text(data.disputes.active_disputes);
        $('#alert-payout-amount').text('$' + parseFloat(data.financial.pending_payouts).toFixed(0));
        $('#alert-refunds').text(data.disputes.pending_refunds);

        // Users
        $('#stat-total-users').text(data.users.total_users);
        $('#stat-total-sellers').text(data.users.total_sellers);
        $('#stat-total-buyers').text(data.users.total_buyers);
        $('#stat-new-signups-today').text(data.users.new_signups_today);
        $('#stat-new-signups-week').text(data.users.new_signups_this_week);
        $('#stat-active-users').text(data.users.active_users);

        // Orders
        $('#stat-total-orders').text(data.orders.total_orders);
        $('#stat-active-orders').text(data.orders.active_orders);
        $('#stat-pending-orders').text(data.orders.pending_orders);
        $('#stat-delivered-orders').text(data.orders.delivered_orders);
        $('#stat-completed-orders').text(data.orders.completed_orders);
        $('#stat-cancelled-orders').text(data.orders.cancelled_orders);

        // Services
        $('#stat-total-services').text(data.services.total_services);
        $('#stat-active-services').text(data.services.active_services);
        $('#stat-conversion-rate').text(parseFloat(data.services.conversion_rate).toFixed(1) + '%');
        $('#stat-avg-rating').text(parseFloat(data.services.avg_service_rating).toFixed(1));
    }

    /**
     * Load charts
     */
    function loadCharts(preset, customFrom = null, customTo = null) {
        // Revenue chart
        $.ajax({
            url: '/admin-dashboard/revenue-chart',
            method: 'GET',
            success: function (data) {
                renderRevenueChart(data);
            }
        });

        // Order status chart
        let statusUrl = '/admin-dashboard/order-status-chart?preset=' + preset;
        if (customFrom && customTo) {
            statusUrl += '&date_from=' + customFrom + '&date_to=' + customTo;
        }

        $.ajax({
            url: statusUrl,
            method: 'GET',
            success: function (data) {
                renderOrderStatusChart(data);
            }
        });
    }

    /**
     * Render revenue chart
     */
    function renderRevenueChart(data) {
        const ctx = document.getElementById('revenueChart').getContext('2d');

        if (revenueChart) {
            revenueChart.destroy();
        }

        revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Revenue ($)',
                    data: data.revenue,
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
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
     * Render order status chart
     */
    function renderOrderStatusChart(data) {
        const ctx = document.getElementById('orderStatusChart').getContext('2d');

        if (orderStatusChart) {
            orderStatusChart.destroy();
        }

        if (data.data.length === 0) {
            ctx.canvas.parentNode.innerHTML = '<p class="text-center text-muted py-5">No order data</p>';
            return;
        }

        orderStatusChart = new Chart(ctx, {
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

        $('.filter-preset').removeClass('active');
        loadDashboardStatistics('custom', dateFrom, dateTo);
    }

    /**
     * Placeholder functions for action buttons
     */
    function viewDisputes() {
        window.location.href = '/all-orders'; // Adjust URL as needed
    }

    function viewPayouts() {
        window.location.href = '/payout-details'; // Adjust URL as needed
    }

    function viewRefunds() {
        window.location.href = '/refund-details'; // Adjust URL as needed
    }

    function exportDashboard() {
        alert('Export functionality coming soon!');
    }
</script>
</body>
</html>
