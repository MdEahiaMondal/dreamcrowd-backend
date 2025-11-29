@extends('layout.app')
@section('title', 'Teacher Dashboard | Transactions')

@push('styles')

    <style>
        .star-rating i {
            font-size: 18px;
            margin-right: 2px;
        }

        .review-text {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .table-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 10px;
        }

        .para-1 {
            font-weight: 600;
            color: #333;
        }

        .para-2 {
            font-size: 12px;
            color: #666;
            margin: 0;
        }

        #service-image {
            border-radius: 8px;
            object-fit: cover;
        }

        #replies-container {
            max-height: 400px;
            overflow-y: auto;
        }

        .reply-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            border-left: 3px solid #007bff;
        }

        .reply-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .reply-actions {
            display: flex;
            gap: 10px;
        }

        .customer-review {
            background: #fff3cd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            border-left: 3px solid #ffc107;
        }

        .reply-form {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .mb-2 {
            margin-bottom: 0.5rem !important;
            height: 25px !important;
        }
    </style>

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
    </style>
@endpush

@section('content')

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

   
        <div class="container-fluid py-4">

            <!-- Page Header -->
            <div class="" style="margin-top: 90px">
                <div class="col-md-12">
                    <h2><i class="fa-solid fa-chart-line"></i> My Transactions & Earnings</h2>
                    <p class="text-muted">Track your earnings, commissions, and payout status</p>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row">
                <!-- Total Earnings -->
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card" style="border-left: 4px solid #28a745;">
                        <p>Total Earnings</p>
                        <h3 style="color: #28a745;">${{ number_format($stats['total_earnings'], 2) }}</h3>
                        <small>All time</small>
                    </div>
                </div>

                <!-- Pending Earnings -->
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card" style="border-left: 4px solid #ffc107;">
                        <p>Pending Payout</p>
                        <h3 style="color: #ffc107;">${{ number_format($stats['pending_earnings'], 2) }}</h3>
                        <small>Awaiting transfer</small>
                    </div>
                </div>

                <!-- Paid Earnings -->
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card" style="border-left: 4px solid #007bff;">
                        <p>Paid Out</p>
                        <h3 style="color: #007bff;">${{ number_format($stats['paid_earnings'], 2) }}</h3>
                        <small>Already received</small>
                    </div>
                </div>

                <!-- This Month -->
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card" style="border-left: 4px solid #17a2b8;">
                        <p>This Month</p>
                        <h3 style="color: #17a2b8;">${{ number_format($stats['month_earnings'], 2) }}</h3>
                        <small>{{ now()->format('F Y') }}</small>
                    </div>
                </div>
            </div>

            <!-- Secondary Stats -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card" style="border-left: 4px solid #6c757d;">
                        <p>Today's Earnings</p>
                        <h3 style="color: #6c757d;">${{ number_format($stats['today_earnings'], 2) }}</h3>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="stats-card" style="border-left: 4px solid #dc3545;">
                        <p>Platform Commission</p>
                        <h3 style="color: #dc3545;">{{ number_format($stats['avg_commission_rate'], 1) }}%</h3>
                        <small>Average rate</small>
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
                        <h3 style="color: #fd7e14;">${{ number_format($stats['avg_transaction'], 2) }}</h3>
                    </div>
                </div>
            </div>

            <!-- Earnings Chart -->
            <div class="row">
                <div class="col-md-12">
                    <div class="chart-container">
                        <h5><i class="fa-solid fa-chart-area"></i> Earnings Overview (Last 6 Months)</h5>
                        <canvas id="earningsChart" height="80"></canvas>
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

                                <div class="col-md-3">
                                    <label class="form-label">Payout Status</label>
                                    <select class="form-control" name="payout_status" id="filter_payout">
                                        <option value="">All</option>
                                        <option value="pending">Pending</option>
                                        <option value="paid">Paid</option>
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
                                            <i class="fa-solid fa-user"></i>
                                            {{ ($transaction->buyer->first_name ?? '') . ' ' . ($transaction->buyer->last_name ?? '') ?: 'N/A' }}
                                        </small>
                                    </div>

                                    <!-- Amount Details -->
                                    <div class="col-md-3">
                                        <p style="margin: 0; color: #666; font-size: 13px;">Your Earnings</p>
                                        <h5 style="margin: 5px 0; color: #28a745; font-weight: bold;">
                                            ${{ number_format($transaction->seller_earnings, 2) }}
                                        </h5>
                                        <small style="color: #999;">
                                            Commission: ${{ number_format($transaction->seller_commission_amount, 2) }}
                                            ({{ $transaction->seller_commission_rate }}%)
                                        </small>
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-2 text-center">
                                        <span
                                            class="status-badge bg-{{ $transaction->status == 'completed' ? 'success' : ($transaction->status == 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                        <br>
                                        <small class="text-muted mt-1 d-block">
                                            Payout:
                                            <span
                                                class="badge bg-{{ $transaction->payout_status == 'paid' ? 'success' : ($transaction->payout_status == 'pending' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst($transaction->payout_status) }}
                                            </span>
                                        </small>
                                    </div>

                                    <!-- Actions -->
                                    <div class="col-md-3 text-end">
                                        <a href="/transaction/{{ $transaction->id }}" class="btn btn-sm btn-primary">
                                            <i class="fa-solid fa-eye"></i> View Details
                                        </a>
                                        @if ($transaction->payout_status == 'paid' && $transaction->payout_at)
                                            <br>
                                            <small class="text-success mt-1 d-block">
                                                <i class="fa-solid fa-check-circle"></i> Paid
                                                on {{ $transaction->payout_at->format('d M Y') }}
                                            </small>
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
    @endsection

@push('scripts')

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Earnings Chart
        const ctx = document.getElementById('earningsChart').getContext('2d');
        const earningsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($monthlyData['labels']),
                datasets: [{
                    label: 'Earnings ($)',
                    data: @json($monthlyData['earnings']),
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    tension: 0.4,
                    fill: true
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
                            callback: function(value) {
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
                payout_status: $('#filter_payout').val(),
                date_from: $('#filter_from').val(),
                date_to: $('#filter_to').val(),
            };

            // Build query string
            const queryString = new URLSearchParams(formData).toString();
            window.location.href = '/seller/transactions?' + queryString;
        }
    </script>
    
@endpush
