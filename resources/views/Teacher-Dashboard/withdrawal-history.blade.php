@extends('layout.app')
@section('title', 'Withdrawal History')

@push('styles')
<style>
    .history-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .filter-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .page-header {
        margin-bottom: 30px;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-pending { background: #fff3cd; color: #856404; }
    .status-processing { background: #cce5ff; color: #004085; }
    .status-completed { background: #d4edda; color: #155724; }
    .status-failed { background: #f8d7da; color: #721c24; }
    .status-cancelled { background: #e2e3e5; color: #383d41; }

    .method-badge {
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 500;
    }

    .method-stripe { background: #635bff; color: white; }
    .method-bank_transfer { background: #6c757d; color: white; }

    .table th {
        background-color: #f8f9fa;
        border-top: none;
        font-weight: 600;
        color: #495057;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 64px;
        color: #dee2e6;
        margin-bottom: 20px;
    }

    .withdrawal-details {
        max-width: 300px;
        font-size: 12px;
    }

    .btn-cancel {
        padding: 4px 10px;
        font-size: 12px;
    }

    .stats-mini {
        display: flex;
        gap: 30px;
        margin-bottom: 20px;
    }

    .stats-mini-item {
        text-align: center;
    }

    .stats-mini-item h4 {
        margin: 0;
        font-weight: bold;
    }

    .stats-mini-item small {
        color: #6c757d;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/teacher-dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('seller.earnings') }}">Earnings & Payouts</a></li>
            <li class="breadcrumb-item active">Withdrawal History</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="row align-items-center page-header">
        <div class="col-md-8">
            <h4><i class="bx bx-history"></i> Withdrawal History</h4>
            <p class="text-muted">View all your past and pending withdrawal requests</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('seller.withdrawal.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> New Withdrawal
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bx bx-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bx bx-error"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Filters -->
    <div class="filter-card">
        <form method="GET" action="{{ route('seller.withdrawal.history') }}">
            <div class="row align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Payment Method</label>
                    <select name="method" class="form-control">
                        <option value="">All Methods</option>
                        <option value="stripe" {{ request('method') == 'stripe' ? 'selected' : '' }}>Stripe</option>
                        <option value="bank_transfer" {{ request('method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bx bx-filter"></i> Filter
                        </button>
                        <a href="{{ route('seller.withdrawal.history') }}" class="btn btn-secondary">
                            <i class="bx bx-refresh"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Withdrawals Table -->
    <div class="history-card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Fee</th>
                        <th>Net Amount</th>
                        <th>Reference</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($withdrawals as $withdrawal)
                    <tr>
                        <td>
                            <strong>{{ $withdrawal->created_at->format('M d, Y') }}</strong>
                            <br>
                            <small class="text-muted">{{ $withdrawal->created_at->format('h:i A') }}</small>
                        </td>
                        <td>
                            <strong>${{ number_format($withdrawal->amount, 2) }}</strong>
                            <br>
                            <small class="text-muted">{{ $withdrawal->currency }}</small>
                        </td>
                        <td>
                            <span class="method-badge method-{{ $withdrawal->method }}">
                                {{ $withdrawal->method_display_name }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge status-{{ $withdrawal->status }}">
                                {{ ucfirst($withdrawal->status) }}
                            </span>
                            @if($withdrawal->processed_at)
                            <br>
                            <small class="text-muted">{{ $withdrawal->processed_at->format('M d, Y') }}</small>
                            @endif
                        </td>
                        <td>
                            @if($withdrawal->processing_fee > 0)
                            <span class="text-danger">-${{ number_format($withdrawal->processing_fee, 2) }}</span>
                            @else
                            <span class="text-muted">$0.00</span>
                            @endif
                        </td>
                        <td>
                            <strong class="text-success">${{ number_format($withdrawal->net_amount, 2) }}</strong>
                        </td>
                        <td class="withdrawal-details">
                            @if($withdrawal->isCompleted())
                                @if($withdrawal->stripe_transfer_id)
                                    <small>Stripe: {{ $withdrawal->stripe_transfer_id }}</small>
                                @elseif($withdrawal->bank_reference)
                                    <small>Ref: {{ $withdrawal->bank_reference }}</small>
                                @endif
                            @elseif($withdrawal->status == 'failed')
                                <small class="text-danger">{{ $withdrawal->failure_reason }}</small>
                            @elseif($withdrawal->seller_notes)
                                <small class="text-muted">{{ Str::limit($withdrawal->seller_notes, 50) }}</small>
                            @else
                                <small class="text-muted">-</small>
                            @endif
                        </td>
                        <td>
                            @if($withdrawal->canBeCancelled())
                            <form action="{{ route('seller.withdrawal.cancel', $withdrawal->id) }}"
                                  method="POST"
                                  style="display: inline;"
                                  onsubmit="return confirm('Are you sure you want to cancel this withdrawal request?');">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-cancel">
                                    <i class="bx bx-x"></i> Cancel
                                </button>
                            </form>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="bx bx-wallet"></i>
                                <h5>No withdrawals yet</h5>
                                <p class="text-muted">When you request withdrawals, they will appear here.</p>
                                <a href="{{ route('seller.withdrawal.create') }}" class="btn btn-primary">
                                    <i class="bx bx-plus"></i> Request Withdrawal
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($withdrawals->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $withdrawals->appends(request()->all())->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
@endsection
