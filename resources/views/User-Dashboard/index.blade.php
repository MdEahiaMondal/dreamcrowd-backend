<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Dashboard | DreamCrowd</title>

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="/assets/user/asset/css/bootstrap.min.css"/>
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/assets/user/asset/css/sidebar.css"/>
    <link rel="stylesheet" href="/assets/user/asset/css/style.css">
    <link rel="stylesheet" href="/assets/user/asset/css/dashboard.css">

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
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body>
<!-- Loading Overlay -->
<div class="dashboard-loading" id="dashboardLoading">
    <div class="spinner"></div>
</div>
<!-- Sidebar -->
<x-user-sidebar/>
<section class="home-section">
    <!-- Navigation -->
    <x-user-nav/>
    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="row dash-notification">

            <!-- Page Header -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <h2><i class='bx bx-grid-alt'></i> My Dashboard</h2>
                    <p class="text-muted">Welcome back, {{ Auth::user()->name }}! Here's your activity overview.</p>
                </div>
                <div class="col-md-4 text-end d-none">
                    <button class="btn btn-danger me-2" onclick="exportPDF()">
                        <i class='bx bxs-file-pdf'></i> Export PDF
                    </button>
                    <button class="btn btn-success" onclick="exportExcel()">
                        <i class='bx bxs-file'></i> Export Excel
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
                                <button type="button" class="btn btn-outline-primary filter-preset active"
                                        data-preset="all_time">All Time
                                </button>
                                <button type="button" class="btn btn-outline-primary filter-preset" data-preset="today">
                                    Today
                                </button>
                                <button type="button" class="btn btn-outline-primary filter-preset"
                                        data-preset="yesterday">Yesterday
                                </button>
                                <button type="button" class="btn btn-outline-primary filter-preset"
                                        data-preset="this_week">This Week
                                </button>
                                <button type="button" class="btn btn-outline-primary filter-preset"
                                        data-preset="last_week">Last Week
                                </button>
                                <button type="button" class="btn btn-outline-primary filter-preset"
                                        data-preset="this_month">This Month
                                </button>
                                <button type="button" class="btn btn-outline-primary filter-preset"
                                        data-preset="last_month">Last Month
                                </button>
                                <button type="button" class="btn btn-outline-primary filter-preset"
                                        data-preset="last_3_months">Last 3 Months
                                </button>
                                <button type="button" class="btn btn-outline-primary filter-preset"
                                        data-preset="last_6_months">Last 6 Months
                                </button>
                                <button type="button" class="btn btn-outline-primary filter-preset"
                                        data-preset="last_year">Last Year
                                </button>
                                <button type="button" class="btn btn-outline-primary filter-preset"
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
                            <button class="btn btn-primary w-100" onclick="applyCustomDateFilter()">Apply Custom
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
                <div class="col-3 col--6 mb-3">
                    <div class="stat-card" style="border-left: 4px solid #007bff;">
                        <div class="stat-icon" style="background: rgba(0, 123, 255, 0.1);">
                            <i class='bx bx-wallet' style="color: #007bff;"></i>
                        </div>
                        <div class="stat-content">
                            <p class="stat-label">Total Spent</p>
                            <h3 class="stat-value" id="stat-total-spent">$0.00</h3>
                            <small class="stat-sublabel">All-time spending</small>
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
                            <h3 class="stat-value" id="stat-month-spent">$0.00</h3>
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
                            <small class="stat-sublabel">Per transaction</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" style="border-left: 4px solid #6c757d;">
                        <div class="stat-icon" style="background: rgba(108, 117, 125, 0.1);">
                            <i class='bx bx-credit-card' style="color: #6c757d;"></i>
                        </div>
                        <div class="stat-content">
                            <p class="stat-label">Service Fees</p>
                            <h3 class="stat-value" id="stat-service-fees">$0.00</h3>
                            <small class="stat-sublabel">Platform fees paid</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" style="border-left: 4px solid #28a745;">
                        <div class="stat-icon" style="background: rgba(40, 167, 69, 0.1);">
                            <i class='bx bx-gift' style="color: #28a745;"></i>
                        </div>
                        <div class="stat-content">
                            <p class="stat-label">Coupon Savings</p>
                            <h3 class="stat-value" id="stat-coupon-savings">$0.00</h3>
                            <small class="stat-sublabel">Discounts applied</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Statistics -->
            <div class="section-header mb-3">
                <h5><i class='bx bx-shopping-bag'></i> Order Statistics</h5>
            </div>
            <div class="row  mb-4">
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-total-orders">0</h3>
                        <p class="stat-label">Total Orders</p>
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
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="stat-card-small status-upcoming">
                        <h3 class="stat-value" id="stat-upcoming-classes">0</h3>
                        <p class="stat-label">Upcoming</p>
                    </div>
                </div>
            </div>

            <!-- Engagement Statistics -->
            <div class="section-header mb-3">
                <h5><i class='bx bx-user-circle'></i> Engagement Metrics</h5>
            </div>
            <div class="row  mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-reviews-given">0</h3>
                        <p class="stat-label">Reviews Given</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-coupons-used">0</h3>
                        <p class="stat-label">Coupons Used</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-unique-sellers">0</h3>
                        <p class="stat-label">Unique Sellers</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card-small">
                        <h3 class="stat-value" id="stat-days-member">0</h3>
                        <p class="stat-label">Days as Member</p>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="row mb-4">
                <div class="col-lg-8 mb-3">
                    <div class="chart-card card">
                        <div class="card-body">
                            <h6 class="card-title"><i class='bx bx-line-chart'></i> Spending Trend (Last 6 Months)</h6>
                            <div class="chart-container" style="height: 300px;">
                                <canvas id="spendingTrendChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="chart-card card">
                        <div class="card-body">
                            <h6 class="card-title"><i class='bx bx-pie-chart-alt'></i> Order Status</h6>
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
                                        <th>Category</th>
                                        <th>Date</th>
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
                                                        <small
                                                            class="text-muted">{{ $booking->teacher->name ?? 'Unknown' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-secondary">{{ $booking->gig->category_name ?? 'N/A' }}</span>
                                            </td>
                                            <td>{{ $booking->created_at->format('M d, Y') }}</td>
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
<script src="/assets/user/asset/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="/assets/user/asset/js/dashboard.js"></script>
<script>
    // Initialize on page load
    $(document).ready(function () {
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
</script>
</body>
</html>
