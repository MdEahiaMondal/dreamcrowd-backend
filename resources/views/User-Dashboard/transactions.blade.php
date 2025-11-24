<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Transactions - User Dashboard</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/assets/user/asset/css/bootstrap.min.css"/>
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">

    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- Animate CSS -->
    <link rel="stylesheet" href="/assets/user/libs/animate/css/animate.css"/>
    <!-- AOS Animation CSS -->
    <link rel="stylesheet" href="/assets/user/libs/aos/css/aos.css"/>
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="/assets/user/libs/datatable/css/datatable.css"/>

    {{-- Fav Icon --}}
    @php  $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="/assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
    @endif

    <!-- Select2 CSS -->
    <link href="/assets/user/libs/select2/css/select2.min.css" rel="stylesheet"/>
    <!-- Owl carousel CSS -->
    <link href="/assets/user/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet"/>
    <link href="/assets/user/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet"/>

    <!-- Default CSS -->
    <link rel="stylesheet" type="text/css" href="/assets/user/asset/css/sidebar.css"/>
    <link rel="stylesheet" href="/assets/user/asset/css/style.css">
    <link rel="stylesheet" href="/assets/user/asset/css/purchase-table.css">
    <style>
        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .stats-card h3 {
            margin: 10px 0;
            font-size: 32px;
            font-weight: bold;
        }

        .stats-card p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        .stats-card small {
            color: #999;
            font-size: 12px;
        }

        .transaction-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 4px solid;
            transition: all 0.2s;
        }

        .transaction-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateX(5px);
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .filter-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .chart-container {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .coupon-item {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

@if (Session::has('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
@endif

@if (Session::has('error'))
    <script>
        toastr.error("{{ session('error') }}");
    </script>
@endif

<x-user-sidebar/>
<section class="home-section">
    <x-user-nav/>
    <div class="container-fluid">
        <div class="row dash-notification">
            <!-- Page Header -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <h2><i class="fa-solid fa-wallet"></i> My Transactions & Payments</h2>
                    <p class="text-muted">Track your purchases, payments, and savings</p>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row">
                <!-- Total Spent -->
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card" style="border-left: 4px solid #007bff;">
                        <p>Total Spent</p>
                        <h3 style="color: #007bff;">${{ number_format($stats['total_spent'], 2) }}</h3>
                        <small>All time</small>
                    </div>
                </div>

                <!-- This Month -->
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card" style="border-left: 4px solid #17a2b8;">
                        <p>This Month</p>
                        <h3 style="color: #17a2b8;">${{ number_format($stats['month_spent'], 2) }}</h3>
                        <small>{{ now()->format('F Y') }}</small>
                    </div>
                </div>

                <!-- Total Saved -->
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card" style="border-left: 4px solid #28a745;">
                        <p>Total Saved (Coupons)</p>
                        <h3 style="color: #28a745;">${{ number_format($stats['total_coupon_savings'], 2) }}</h3>
                        <small>{{ $stats['coupons_used_count'] }} coupons used</small>
                    </div>
                </div>

                <!-- Service Fees -->
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card" style="border-left: 4px solid #6c757d;">
                        <p>Service Fees Paid</p>
                        <h3 style="color: #6c757d;">${{ number_format($stats['total_service_fees'], 2) }}</h3>
                        <small>Platform fees</small>
                    </div>
                </div>
            </div>

            <!-- Secondary Stats -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card" style="border-left: 4px solid #20c997;">
                        <p>Today's Spending</p>
                        <h3 style="color: #20c997;">${{ number_format($stats['today_spent'], 2) }}</h3>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="stats-card" style="border-left: 4px solid #6610f2;">
                        <p>Completed Orders</p>
                        <h3 style="color: #6610f2;">{{ $stats['completed_transactions'] }}</h3>
                        <small>Total: {{ $stats['total_transactions'] }}</small>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="stats-card" style="border-left: 4px solid #fd7e14;">
                        <p>Average Order Value</p>
                        <h3 style="color: #fd7e14;">${{ number_format($stats['avg_order_value'], 2) }}</h3>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="stats-card" style="border-left: 4px solid #dc3545;">
                        <p>Total Refunded</p>
                        <h3 style="color: #dc3545;">${{ number_format($stats['total_refunded'], 2) }}</h3>
                        <small>{{ $stats['refunded_transactions'] }} orders</small>
                    </div>
                </div>
            </div>

            <!-- Spending Chart -->
            <div class="row">
                <div class="col-md-8">
                    <div class="chart-container">
                        <h5><i class="fa-solid fa-chart-line"></i> Spending Overview (Last 6 Months)</h5>
                        <canvas id="spendingChart" height="100"></canvas>
                    </div>
                </div>

                <!-- Recent Coupons Used -->
                <div class="col-md-4">
                    <div class="chart-container">
                        <h5><i class="fa-solid fa-ticket"></i> Recent Coupons Used</h5>
                        <div style="max-height: 300px; overflow-y: auto;">
                            @forelse($couponUsage as $usage)
                                <div class="coupon-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong style="font-family: 'Courier New', monospace;">
                                                {{ $usage->coupon_code }}
                                            </strong>
                                            <br>
                                            <small style="color: #856404;">
                                                Saved: <strong>${{ number_format($usage->discount_amount, 2) }}</strong>
                                            </small>
                                        </div>
                                        <small style="color: #999;">
                                            {{ $usage->used_at->format('d M Y') }}
                                        </small>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-muted py-3">No coupons used yet</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="row">
                <div class="col-md-12">
                    <div class="filter-card">
                        <h6><i class="fa-solid fa-filter"></i> Filter Transactions</h6>
                        <form id="filterForm">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-control" name="status" id="filter_status">
                                        <option value="">All Statuses</option>
                                        <option value="completed">Completed</option>
                                        <option value="pending">Pending</option>
                                        <option value="refunded">Refunded</option>
                                        <option value="failed">Failed</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">From Date</label>
                                    <input type="date" class="form-control" name="date_from" id="filter_from">
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">To Date</label>
                                    <input type="date" class="form-control" name="date_to" id="filter_to">
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Min Amount</label>
                                    <input type="number" class="form-control" name="min_amount" id="filter_min"
                                           placeholder="$0">
                                </div>

                                <div class="col-md-1">
                                    <label class="form-label">Max</label>
                                    <input type="number" class="form-control" name="max_amount" id="filter_max"
                                           placeholder="$999">
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="button" class="btn btn-primary w-100" onclick="applyFilters()">
                                        <i class="fa-solid fa-search"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Transactions List -->
            <div class="row">
                <div class="col-md-12">
                    <h5 class="mb-3"><i class="fa-solid fa-list"></i> Recent Transactions</h5>

                    <div id="transactions-container">
                        @forelse($transactions as $transaction)
                            <div class="transaction-card"
                                 style="border-left-color: {{ $transaction->status == 'completed' ? '#28a745' : ($transaction->status == 'pending' ? '#ffc107' : '#dc3545') }};">
                                <div class="row align-items-center">
                                    <!-- Transaction Info -->
                                    <div class="col-md-4">
                                        <h6 style="margin: 0; color: #333;">
                                            <i class="fa-solid fa-receipt"></i>
                                            #{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}
                                        </h6>
                                        <small
                                            style="color: #999;">{{ $transaction->created_at->format('d M Y, h:i A') }}</small>
                                        <br>
                                        <small style="color: #666;">
                                            <i class="fa-solid fa-user"></i> {{ ($transaction->seller->first_name ?? '') . ' ' . ($transaction->seller->last_name ?? '') ?: 'N/A' }}
                                        </small>
                                        @if($transaction->coupon_discount > 0)
                                            <br>
                                            <small style="color: #28a745;">
                                                <i class="fa-solid fa-ticket"></i> Saved:
                                                ${{ number_format($transaction->coupon_discount, 2) }}
                                            </small>
                                        @endif
                                    </div>

                                    <!-- Amount Details -->
                                    <div class="col-md-3">
                                        <p style="margin: 0; color: #666; font-size: 13px;">Total Paid</p>
                                        <h5 style="margin: 5px 0; color: #007bff; font-weight: bold;">
                                            ${{ number_format($transaction->total_amount + $transaction->buyer_commission_amount, 2) }}
                                        </h5>
                                        <small style="color: #999;">
                                            Service: ${{ number_format($transaction->total_amount, 2) }} +
                                            Fee: ${{ number_format($transaction->buyer_commission_amount, 2) }}
                                        </small>
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-2 text-center">
                                    <span
                                        class="status-badge bg-{{ $transaction->status == 'completed' ? 'success' : ($transaction->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                        @if($transaction->status == 'refunded')
                                            <br>
                                            <small class="text-danger mt-1 d-block">
                                                <i class="fa-solid fa-rotate-left"></i> Refunded
                                            </small>
                                        @endif
                                    </div>

                                    <!-- Actions -->
                                    <div class="col-md-3 text-end">
                                        <a href="/transaction/{{ $transaction->id }}" class="btn btn-sm btn-primary">
                                            <i class="fa-solid fa-eye"></i> View Details
                                        </a>
                                        @if($transaction->status == 'completed')
                                            <a href="/transaction/{{ $transaction->id }}/invoice"
                                               class="btn btn-sm btn-secondary mt-1">
                                                <i class="fa-solid fa-download"></i> Invoice
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="fa-solid fa-inbox" style="font-size: 48px; color: #ccc;"></i>
                                <p class="text-muted mt-3">No transactions found</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script src="assets/user/libs/jquery/jquery.js"></script>
<script src="assets/user/libs/datatable/js/datatable.js"></script>
<script src="assets/user/libs/datatable/js/datatablebootstrap.js"></script>
<script src="assets/user/libs/select2/js/select2.min.js"></script>
<script src="assets/user/libs/owl-carousel/js/owl.carousel.min.js"></script>
<script src="assets/user/libs/aos/js/aos.js"></script>
<script src="assets/user/asset/js/bootstrap.min.js"></script>
<script src="assets/user/asset/js/script.js"></script>
<!-- jQuery -->
<script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"
></script>

<script>
    // Spending Chart
    const ctx = document.getElementById('spendingChart').getContext('2d');
    const spendingChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($monthlyData['labels']),
            datasets: [{
                label: 'Spending ($)',
                data: @json($monthlyData['spent']),
                backgroundColor: 'rgba(0, 123, 255, 0.6)',
                borderColor: '#007bff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function (value) {
                            return '$' + value.toFixed(2);
                        }
                    }
                }
            }
        }
    });

    // Filter function
    function applyFilters() {
        const formData = {
            status: $('#filter_status').val(),
            date_from: $('#filter_from').val(),
            date_to: $('#filter_to').val(),
            min_amount: $('#filter_min').val(),
            max_amount: $('#filter_max').val(),
        };

        // Build query string
        const queryString = new URLSearchParams(formData).toString();
        window.location.href = '/user/transactions?' + queryString;
    }
</script>
</body>
</html>
