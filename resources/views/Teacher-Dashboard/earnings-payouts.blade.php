@extends('layout.app')
@section('title', 'Earnings & Payouts')

@push('styles')
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

    .filter-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .transaction-table {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .table th {
        background-color: #f8f9fa;
        border-top: none;
        font-weight: 600;
        color: #495057;
    }

    .badge {
        font-size: 12px;
        padding: 5px 10px;
    }

    .btn-export {
        background: linear-gradient(135deg, #28a745, #20c997);
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        transition: all 0.3s;
    }

    .btn-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        color: white;
    }

    .page-header {
        margin-bottom: 30px;
    }

    .page-header h4 {
        margin: 0;
        font-weight: 600;
        color: #333;
    }

    .page-header p {
        margin: 5px 0 0;
        color: #666;
    }

    .clearance-info {
        background: #fff3cd;
        border-left: 4px solid #ffc107;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .clearance-info i {
        color: #856404;
        margin-right: 10px;
    }

    .earnings-icon {
        font-size: 40px;
        opacity: 0.3;
        position: absolute;
        right: 20px;
        top: 20px;
    }

    .stats-card {
        position: relative;
        overflow: hidden;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/teacher-dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Earnings & Payouts</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="row align-items-center page-header">
        <div class="col-md-8">
            <h4><i class="bx bx-dollar-circle"></i> Earnings & Payouts</h4>
            <p class="text-muted">Track your earnings, clearance period, and payout status</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('seller.earnings.export', request()->all()) }}" class="btn btn-export">
                <i class="bx bx-download"></i> Export Report
            </a>
        </div>
    </div>

    <!-- Clearance Info Banner -->
    <div class="clearance-info">
        <i class="bx bx-info-circle"></i>
        <strong>Holding Period:</strong> Earnings are held for <strong>{{ $settings->holding_period_days ?? 14 }} days</strong> before becoming available for withdrawal.
        This protects both buyers and sellers in case of disputes.
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <!-- Total Earned -->
        <div class="col-lg-3 col-md-6">
            <div class="stats-card" style="border-left: 4px solid #28a745;">
                <i class="bx bx-wallet earnings-icon" style="color: #28a745;"></i>
                <p>Total Earned</p>
                <h3 style="color: #28a745;">${{ number_format($stats['total_earned'], 2) }}</h3>
                <small>Lifetime earnings</small>
            </div>
        </div>

        <!-- Available for Withdrawal -->
        <div class="col-lg-3 col-md-6">
            <div class="stats-card" style="border-left: 4px solid #007bff;">
                <i class="bx bx-check-circle earnings-icon" style="color: #007bff;"></i>
                <p>Available for Withdrawal</p>
                <h3 style="color: #007bff;">${{ number_format($stats['available'], 2) }}</h3>
                <small>Ready to withdraw</small>
            </div>
        </div>

        <!-- Pending Clearance -->
        <div class="col-lg-3 col-md-6">
            <div class="stats-card" style="border-left: 4px solid #ffc107;">
                <i class="bx bx-time earnings-icon" style="color: #ffc107;"></i>
                <p>Pending Clearance</p>
                <h3 style="color: #ffc107;">${{ number_format($stats['pending_clearance'], 2) }}</h3>
                <small>{{ $settings->holding_period_days ?? 14 }}-day holding period</small>
            </div>
        </div>

        <!-- Withdrawn -->
        <div class="col-lg-3 col-md-6">
            <div class="stats-card" style="border-left: 4px solid #6c757d;">
                <i class="bx bx-check-double earnings-icon" style="color: #6c757d;"></i>
                <p>Withdrawn</p>
                <h3 style="color: #6c757d;">${{ number_format($stats['withdrawn'], 2) }}</h3>
                <small>Already paid out</small>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-card">
        <h6><i class="bx bx-filter"></i> Filter Transactions</h6>
        <form method="GET" action="{{ route('seller.earnings') }}">
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">From Date</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">To Date</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Service Type</label>
                    <select name="service_type" class="form-control">
                        <option value="">All Types</option>
                        <option value="service" {{ request('service_type') == 'service' ? 'selected' : '' }}>Freelance</option>
                        <option value="class" {{ request('service_type') == 'class' ? 'selected' : '' }}>Class</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Payout Status</label>
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bx bx-search"></i> Filter
                        </button>
                        <a href="{{ route('seller.earnings') }}" class="btn btn-secondary">
                            <i class="bx bx-refresh"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Transaction History Table -->
    <div class="transaction-table">
        <h5 class="mb-4"><i class="bx bx-history"></i> Transaction History</h5>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Buyer</th>
                        <th>Service</th>
                        <th>Type</th>
                        <th>Order Total</th>
                        <th>Commission</th>
                        <th>Your Earnings</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $txn)
                    <tr>
                        <td>
                            <strong>{{ $txn->created_at->format('M d, Y') }}</strong>
                            <br>
                            <small class="text-muted">{{ $txn->created_at->format('h:i A') }}</small>
                        </td>
                        <td>
                            @if($txn->buyer)
                                {{ $txn->buyer->first_name }} {{ strtoupper(substr($txn->buyer->last_name ?? '', 0, 1)) }}.
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            <span title="{{ $txn->bookOrder->title ?? $txn->service->title ?? 'N/A' }}">
                                {{ \Illuminate\Support\Str::limit($txn->bookOrder->title ?? $txn->service->title ?? 'N/A', 30) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $txn->service_type == 'class' ? 'info' : 'primary' }}">
                                {{ ucfirst($txn->service_type) }}
                            </span>
                        </td>
                        <td>${{ number_format($txn->total_amount, 2) }}</td>
                        <td>
                            <span class="text-danger">
                                -${{ number_format($txn->seller_commission_amount, 2) }}
                            </span>
                            <br>
                            <small class="text-muted">({{ $txn->seller_commission_rate }}%)</small>
                        </td>
                        <td>
                            <strong class="text-success">${{ number_format($txn->seller_earnings, 2) }}</strong>
                        </td>
                        <td>
                            @if(in_array($txn->payout_status, ['completed', 'paid']))
                                <span class="badge bg-success">
                                    <i class="bx bx-check"></i> Paid
                                </span>
                            @elseif($txn->created_at < now()->subDays($settings->holding_period_days ?? 14))
                                <span class="badge bg-primary">
                                    <i class="bx bx-check-circle"></i> Available
                                </span>
                            @else
                                <span class="badge bg-warning text-dark">
                                    <i class="bx bx-time"></i> Clearing
                                </span>
                                <br>
                                <small class="text-muted">
                                    {{ $txn->created_at->addDays($settings->holding_period_days ?? 14)->diffForHumans() }}
                                </small>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('seller.earnings.invoice', $txn->id) }}"
                               class="btn btn-sm btn-outline-primary"
                               title="Download Invoice">
                                <i class="bx bx-download"></i>
                            </a>
                            <a href="{{ route('transaction.details', $txn->id) }}"
                               class="btn btn-sm btn-outline-secondary"
                               title="View Details">
                                <i class="bx bx-show"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <div class="text-muted">
                                <i class="bx bx-receipt" style="font-size: 48px; opacity: 0.5;"></i>
                                <p class="mt-3">No transactions found.</p>
                                <p>Complete orders to see your earnings here.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($transactions->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $transactions->appends(request()->all())->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>

    <!-- Withdrawal Section -->
    @if(config('features.seller_withdrawals_enabled', false))
    <div class="mt-4">
        <div class="row">
            <!-- Quick Withdrawal Card -->
            <div class="col-lg-6">
                <div class="stats-card" style="border-left: 4px solid #17a2b8;">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="mb-3"><i class="bx bx-money-withdraw"></i> Request Withdrawal</h5>
                            <p class="text-muted mb-2">
                                Available balance: <strong class="text-primary">${{ number_format($stats['available'], 2) }}</strong>
                            </p>
                            <p class="text-muted mb-3">
                                <small>
                                    Minimum withdrawal: ${{ number_format($settings->minimum_withdrawal ?? 25, 2) }}
                                </small>
                            </p>
                            <a href="{{ route('seller.withdrawal.create') }}"
                               class="btn btn-primary {{ $stats['available'] < ($settings->minimum_withdrawal ?? 25) ? 'disabled' : '' }}">
                                <i class="bx bx-send"></i> Request Withdrawal
                            </a>
                        </div>
                        <div class="col-4 text-center">
                            <i class="bx bx-wallet" style="font-size: 64px; color: #17a2b8; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Withdrawals Card -->
            <div class="col-lg-6">
                <div class="stats-card" style="border-left: 4px solid #6c757d;">
                    <h5 class="mb-3">
                        <i class="bx bx-history"></i> Recent Withdrawals
                        <a href="{{ route('seller.withdrawal.history') }}" class="btn btn-sm btn-link float-end">View All</a>
                    </h5>
                    @php
                        $recentWithdrawals = \App\Models\Withdrawal::forSeller(Auth::id())
                            ->orderBy('created_at', 'desc')
                            ->limit(3)
                            ->get();
                    @endphp
                    @forelse($recentWithdrawals as $withdrawal)
                    <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div>
                            <strong>${{ number_format($withdrawal->amount, 2) }}</strong>
                            <small class="text-muted ms-2">{{ $withdrawal->method_display_name }}</small>
                        </div>
                        <div>
                            <span class="badge bg-{{ $withdrawal->status_badge_color }}">
                                {{ ucfirst($withdrawal->status) }}
                            </span>
                            <small class="text-muted ms-2">{{ $withdrawal->created_at->format('M d') }}</small>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-3">
                        <i class="bx bx-receipt" style="font-size: 32px; opacity: 0.5;"></i>
                        <p class="mt-2 mb-0 small">No withdrawals yet</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Withdrawal Feature Disabled -->
    <div class="mt-4 p-4 text-center" style="background: #f8f9fa; border-radius: 12px; border: 2px dashed #dee2e6;">
        <i class="bx bx-lock-alt" style="font-size: 48px; color: #adb5bd;"></i>
        <h5 class="mt-3 text-muted">Withdrawal Feature Coming Soon</h5>
        <p class="text-muted mb-0">
            Soon you'll be able to withdraw your available balance via Stripe or Bank Transfer.
        </p>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Auto-refresh page every 5 minutes to update clearance status
    setTimeout(function() {
        location.reload();
    }, 300000);
</script>
@endpush
