<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/">
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Commission Report & Dashboard</title>

    <link rel="stylesheet" href="assets/admin/asset/css/bootstrap.min.css"/>
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/admin/asset/css/sidebar.css"/>
    <link rel="stylesheet" href="assets/admin/asset/css/style.css"/>

    <style>
        .earnings-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .earnings-card h3 {
            font-size: 36px;
            margin: 10px 0;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid;
            margin-bottom: 15px;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .export-btn {
            background: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
        }

        .export-btn:hover {
            background: #218838;
            color: white;
        }
    </style>
</head>
<body>

@if (Session::has('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
@endif

{{-- Admin Sidebar --}}
<x-admin-sidebar/>

<section class="home-section">
    {{-- Admin NavBar --}}
    <x-admin-nav/>

    <div class="container-fluid">
        <div class="row dash-notification">
            <div class="col-md-12">
                <div class="dash">

                    <!-- Breadcrumb -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="dash-top">
                                <h1 class="dash-title">Dashboard</h1>
                                <i class="fa-solid fa-chevron-right"></i>
                                <h1 class="dash-title">Commission Management</h1>
                                <i class="fa-solid fa-chevron-right"></i>
                                <span class="min-title">Earnings Report</span>
                            </div>
                        </div>
                    </div>

                    <!-- Header Section -->
                    <div class="user-notification">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="notify">
                                    <i class="fa-solid fa-chart-line" style="font-size: 40px; color: #667eea;"></i>
                                    <h2>Commission Earnings Dashboard</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Earnings Banner -->
                    <div class="earnings-card">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <p style="margin: 0; opacity: 0.9;">Total Admin Earnings (All Time)</p>
                                <h3>${{ number_format($totalEarnings ?? 0, 2) }}</h3>
                                <small>Last updated: {{ now()->format('d M Y, h:i A') }}</small>
                            </div>
                            <div class="col-md-4 text-end">
                                <i class="fa-solid fa-sack-dollar" style="font-size: 60px; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row">
                        <!-- Today's Earnings -->
                        <div class="col-md-3">
                            <div class="stat-card" style="border-left-color: #28a745;">
                                <p style="margin: 0; color: #666;">Today's Earnings</p>
                                <h4 style="margin: 10px 0; color: #28a745;">
                                    ${{ number_format($todayEarnings ?? 0, 2) }}</h4>
                                <small style="color: #999;">{{ $todayTransactions ?? 0 }} transactions</small>
                            </div>
                        </div>

                        <!-- This Month -->
                        <div class="col-md-3">
                            <div class="stat-card" style="border-left-color: #007bff;">
                                <p style="margin: 0; color: #666;">This Month</p>
                                <h4 style="margin: 10px 0; color: #007bff;">
                                    ${{ number_format($monthlyEarnings ?? 0, 2) }}</h4>
                                <small style="color: #999;">{{ $monthlyTransactions ?? 0 }} transactions</small>
                            </div>
                        </div>

                        <!-- Pending Payouts -->
                        <div class="col-md-3">
                            <div class="stat-card" style="border-left-color: #ffc107;">
                                <p style="margin: 0; color: #666;">Pending Payouts</p>
                                <h4 style="margin: 10px 0; color: #ffc107;">
                                    ${{ number_format($pendingPayouts ?? 0, 2) }}</h4>
                                <small style="color: #999;">{{ $pendingCount ?? 0 }} pending</small>
                            </div>
                        </div>

                        <!-- Top Seller -->
                        <div class="col-md-3">
                            <div class="stat-card" style="border-left-color: #dc3545;">
                                <p style="margin: 0; color: #666;">Top Earning Seller</p>
                                <h4 style="margin: 10px 0; color: #dc3545; font-size: 16px;">
                                    {{ ($topSeller->first_name ?? '') . ' ' . ($topSeller->last_name ?? '') ?: 'N/A' }}
                                </h4>
                                <small style="color: #999;">${{ number_format($topSellerEarnings ?? 0, 2) }}
                                    earned</small>
                            </div>
                        </div>
                    </div>

                    <!-- Export Options -->
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                                <h6 style="margin-bottom: 10px;">
                                    <i class="fa-solid fa-download"></i> Export Reports
                                </h6>
                                <a href="/admin/commission-report/export/csv" class="export-btn">
                                    <i class="fa-solid fa-file-csv"></i> Export CSV
                                </a>
                                <a href="/admin/commission-report/export/pdf" class="export-btn"
                                   style="background: #dc3545;">
                                    <i class="fa-solid fa-file-pdf"></i> Export PDF
                                </a>
                                <a href="/admin/commission-report/export/excel" class="export-btn"
                                   style="background: #17a2b8;">
                                    <i class="fa-solid fa-file-excel"></i> Export Excel
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction History Table -->
                    <div class="col-md-12 manage-profile-faq-sec edit-faqs mt-4">
                        <h5><i class="fa-solid fa-history"></i> Commission Transaction History</h5>
                    </div>

                    <div class="form-section">
                        <!-- Filter Section -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <form method="GET" action="/admin/commission-report" class="row g-3">
                                    <div class="col-md-3">
                                        <label for="date_from" class="form-label">From Date</label>
                                        <input type="date" class="form-control" id="date_from" name="date_from"
                                               value="{{ request('date_from') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="date_to" class="form-label">To Date</label>
                                        <input type="date" class="form-control" id="date_to" name="date_to"
                                               value="{{ request('date_to') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="">All</option>
                                            <option
                                                value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                                Completed
                                            </option>
                                            <option
                                                value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                                Pending
                                            </option>
                                            <option
                                                value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>
                                                Refunded
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fa-solid fa-filter"></i> Filter
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead style="background: #f8f9fa;">
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Buyer</th>
                                    <th>Seller</th>
                                    <th>Service/Class</th>
                                    <th>Total Amount</th>
                                    <th>Commission Rate</th>
                                    <th>Admin Earned</th>
                                    <th>Seller Earned</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($transactions ?? [] as $transaction)
                                    <tr>
                                        <td><strong>#{{ $transaction->id }}</strong></td>
                                        <td>
                                            <small>{{ $transaction->created_at->format('d M Y') }}</small><br>
                                            <small
                                                style="color: #999;">{{ $transaction->created_at->format('h:i A') }}</small>
                                        </td>
                                        <td>{{ ($transaction->buyer->first_name ?? '') . ' ' . ($transaction->buyer->last_name ?? '') ?: 'N/A' }}</td>
                                        <td>{{ ($transaction->seller->first_name ?? '') . ' ' . ($transaction->seller->last_name ?? '') ?: 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ ucfirst($transaction->service_type) }}</span>
                                            #{{ $transaction->service_id }}
                                        </td>
                                        <td><strong>${{ number_format($transaction->total_amount, 2) }}</strong></td>
                                        <td>{{ $transaction->seller_commission_rate }}%</td>
                                        <td style="color: #28a745; font-weight: bold;">
                                            ${{ number_format($transaction->total_admin_commission, 2) }}
                                        </td>
                                        <td style="color: #007bff; font-weight: bold;">
                                            ${{ number_format($transaction->seller_earnings, 2) }}
                                        </td>
                                        <td>
                                            @if($transaction->status == 'completed')
                                                <span class="badge bg-success">Completed</span>
                                            @elseif($transaction->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($transaction->status == 'refunded')
                                                <span class="badge bg-danger">Refunded</span>
                                            @else
                                                <span
                                                    class="badge bg-secondary">{{ ucfirst($transaction->status) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="/admin/transaction/details/{{ $transaction->id }}"
                                               class="btn btn-sm btn-info">
                                                <i class="fa-solid fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center">
                                            <i class="fa-solid fa-inbox"></i> No transactions found.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if(isset($transactions))
                            <div class="d-flex justify-content-center mt-3">
                                {{ $transactions->appends(request()->query())->links() }}
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="copyright">
        <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
    </div>
</section>

<!-- Scripts -->
<script src="assets/admin/asset/js/bootstrap.min.js"></script>
</body>
</html>
