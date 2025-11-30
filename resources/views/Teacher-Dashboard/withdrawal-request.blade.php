@extends('layout.app')
@section('title', 'Request Withdrawal')

@push('styles')
<style>
    .withdrawal-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .balance-card {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 20px;
        position: relative;
        overflow: hidden;
    }

    .balance-card::before {
        content: '';
        position: absolute;
        right: -30px;
        top: -30px;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .balance-card h2 {
        font-size: 42px;
        margin: 10px 0;
        font-weight: bold;
    }

    .balance-card p {
        margin: 0;
        opacity: 0.9;
    }

    .method-option {
        border: 2px solid #dee2e6;
        border-radius: 12px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.3s;
        margin-bottom: 15px;
    }

    .method-option:hover {
        border-color: #007bff;
        background: #f8f9fa;
    }

    .method-option.selected {
        border-color: #007bff;
        background: #e7f3ff;
    }

    .method-option input[type="radio"] {
        display: none;
    }

    .method-option .method-icon {
        font-size: 32px;
        margin-bottom: 10px;
    }

    .method-option h6 {
        margin: 0 0 5px;
        font-weight: 600;
    }

    .method-option small {
        color: #6c757d;
    }

    .settings-section {
        display: none;
        padding-top: 20px;
        border-top: 1px solid #dee2e6;
        margin-top: 20px;
    }

    .settings-section.active {
        display: block;
    }

    .history-table {
        max-height: 400px;
        overflow-y: auto;
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-pending { background: #fff3cd; color: #856404; }
    .status-processing { background: #cce5ff; color: #004085; }
    .status-completed { background: #d4edda; color: #155724; }
    .status-failed { background: #f8d7da; color: #721c24; }
    .status-cancelled { background: #e2e3e5; color: #383d41; }

    .page-header {
        margin-bottom: 30px;
    }

    .alert-info-custom {
        background: #e7f3ff;
        border-left: 4px solid #007bff;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .withdrawal-form .form-control {
        padding: 12px 15px;
        border-radius: 8px;
    }

    .btn-withdraw {
        background: linear-gradient(135deg, #28a745, #20c997);
        border: none;
        color: white;
        padding: 15px 40px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-withdraw:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
        color: white;
    }

    .btn-withdraw:disabled {
        background: #6c757d;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
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
            <li class="breadcrumb-item active">Request Withdrawal</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <h4><i class="bx bx-money-withdraw"></i> Request Withdrawal</h4>
        <p class="text-muted">Withdraw your available earnings to your preferred payment method</p>
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

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <!-- Left Column - Withdrawal Form -->
        <div class="col-lg-8">
            <!-- Balance Card -->
            <div class="balance-card">
                <p><i class="bx bx-wallet"></i> Available Balance</p>
                <h2>${{ number_format($availableBalance, 2) }}</h2>
                <p>Ready to withdraw</p>
            </div>

            @if($hasPendingWithdrawal)
            <div class="alert alert-warning">
                <i class="bx bx-info-circle"></i>
                <strong>Pending Withdrawal:</strong> You already have a pending withdrawal request. Please wait for it to be processed before submitting a new one.
            </div>
            @endif

            @if($availableBalance < $minimumWithdrawal)
            <div class="alert alert-info-custom">
                <i class="bx bx-info-circle"></i>
                <strong>Minimum Balance Required:</strong> You need at least ${{ number_format($minimumWithdrawal, 2) }} available to request a withdrawal.
                <br>
                <small class="text-muted">Earnings are available after a {{ $settings->holding_period_days ?? 14 }}-day holding period.</small>
            </div>
            @endif

            <!-- Withdrawal Form -->
            <div class="withdrawal-card">
                <h5 class="mb-4"><i class="bx bx-dollar-circle"></i> Withdrawal Details</h5>

                <form action="{{ route('seller.withdrawal.store') }}" method="POST" class="withdrawal-form" id="withdrawalForm">
                    @csrf

                    <!-- Amount -->
                    <div class="mb-4">
                        <label class="form-label">Withdrawal Amount ($)</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number"
                                   name="amount"
                                   class="form-control form-control-lg"
                                   placeholder="0.00"
                                   step="0.01"
                                   min="{{ $minimumWithdrawal }}"
                                   max="{{ $availableBalance }}"
                                   value="{{ old('amount') }}"
                                   {{ $hasPendingWithdrawal || $availableBalance < $minimumWithdrawal ? 'disabled' : '' }}
                                   required>
                        </div>
                        <small class="text-muted">
                            Minimum: ${{ number_format($minimumWithdrawal, 2) }} |
                            Maximum: ${{ number_format($availableBalance, 2) }}
                        </small>
                    </div>

                    <!-- Payment Method Selection -->
                    <div class="mb-4">
                        <label class="form-label">Select Withdrawal Method</label>
                        <div class="row">
                            <!-- Stripe -->
                            <div class="col-md-6">
                                <label class="method-option w-100 {{ old('method') == 'stripe' ? 'selected' : '' }}" id="method-stripe">
                                    <input type="radio" name="method" value="stripe" {{ old('method') == 'stripe' ? 'checked' : '' }}>
                                    <div class="text-center">
                                        <div class="method-icon"><i class="bx bxl-stripe"></i></div>
                                        <h6>Stripe</h6>
                                        <small>Instant transfer</small>
                                        @if($seller->stripe_payouts_enabled)
                                        <span class="badge bg-success mt-2">Connected</span>
                                        @else
                                        <span class="badge bg-warning text-dark mt-2">Not Connected</span>
                                        @endif
                                    </div>
                                </label>
                            </div>

                            <!-- Bank Transfer -->
                            <div class="col-md-6">
                                <label class="method-option w-100 {{ old('method') == 'bank_transfer' ? 'selected' : '' }}" id="method-bank_transfer">
                                    <input type="radio" name="method" value="bank_transfer" {{ old('method') == 'bank_transfer' ? 'checked' : '' }}>
                                    <div class="text-center">
                                        <div class="method-icon"><i class="bx bx-building"></i></div>
                                        <h6>Bank Transfer</h6>
                                        <small>3-5 business days</small>
                                        @if($seller->bank_details)
                                        <span class="badge bg-success mt-2">Account Added</span>
                                        @else
                                        <span class="badge bg-warning text-dark mt-2">Not Set</span>
                                        @endif
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mb-4">
                        <label class="form-label">Notes (Optional)</label>
                        <textarea name="notes"
                                  class="form-control"
                                  rows="2"
                                  placeholder="Any additional notes for this withdrawal request..."
                                  maxlength="500"
                                  {{ $hasPendingWithdrawal || $availableBalance < $minimumWithdrawal ? 'disabled' : '' }}>{{ old('notes') }}</textarea>
                    </div>

                    <!-- Submit -->
                    <div class="text-end">
                        <a href="{{ route('seller.earnings') }}" class="btn btn-secondary me-2">
                            <i class="bx bx-arrow-back"></i> Back to Earnings
                        </a>
                        <button type="submit"
                                class="btn btn-withdraw"
                                {{ $hasPendingWithdrawal || $availableBalance < $minimumWithdrawal ? 'disabled' : '' }}>
                            <i class="bx bx-send"></i> Submit Request
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Column - Payout Settings & History -->
        <div class="col-lg-4">
            <!-- Payout Settings -->
            <div class="withdrawal-card">
                <h5 class="mb-4"><i class="bx bx-cog"></i> Payout Settings</h5>

                <form action="{{ route('seller.payout.settings.update') }}" method="POST">
                    @csrf

                    <!-- Bank Details -->
                    <div class="mb-3">
                        <label class="form-label">Bank Name</label>
                        <input type="text"
                               name="bank_name"
                               class="form-control"
                               placeholder="Bank of America"
                               value="{{ old('bank_name', json_decode($seller->bank_details ?? '{}', true)['bank_name'] ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Account Holder Name</label>
                        <input type="text"
                               name="account_holder_name"
                               class="form-control"
                               placeholder="John Doe"
                               value="{{ old('account_holder_name', json_decode($seller->bank_details ?? '{}', true)['account_holder_name'] ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Account Number</label>
                        <input type="text"
                               name="account_number"
                               class="form-control"
                               placeholder="****1234">
                        @if(json_decode($seller->bank_details ?? '{}', true)['account_number'] ?? null)
                        <small class="text-muted">Current: {{ json_decode($seller->bank_details ?? '{}', true)['account_number'] }}</small>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Routing Number</label>
                        <input type="text"
                               name="routing_number"
                               class="form-control"
                               placeholder="021000021"
                               value="{{ old('routing_number', json_decode($seller->bank_details ?? '{}', true)['routing_number'] ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">SWIFT Code (International)</label>
                        <input type="text"
                               name="swift_code"
                               class="form-control"
                               placeholder="BOFAUS3N"
                               value="{{ old('swift_code', json_decode($seller->bank_details ?? '{}', true)['swift_code'] ?? '') }}">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bx bx-save"></i> Save Settings
                    </button>
                </form>

                @if($seller->stripe_account_id)
                <hr>
                <div class="text-center">
                    <p class="mb-2"><small class="text-muted">Stripe Connect</small></p>
                    <span class="badge bg-success"><i class="bx bx-check"></i> Connected</span>
                </div>
                @else
                <hr>
                <div class="text-center">
                    <p class="mb-2"><small class="text-muted">Stripe Connect</small></p>
                    <a href="#" class="btn btn-outline-primary btn-sm">
                        <i class="bx bxl-stripe"></i> Connect Stripe
                    </a>
                </div>
                @endif
            </div>

            <!-- Recent Withdrawals -->
            <div class="withdrawal-card">
                <h5 class="mb-4">
                    <i class="bx bx-history"></i> Recent Withdrawals
                    <a href="{{ route('seller.withdrawal.history') }}" class="btn btn-sm btn-link float-end">View All</a>
                </h5>

                <div class="history-table">
                    @forelse($withdrawals as $withdrawal)
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <div>
                            <strong>${{ number_format($withdrawal->amount, 2) }}</strong>
                            <br>
                            <small class="text-muted">{{ $withdrawal->created_at->format('M d, Y') }}</small>
                        </div>
                        <div class="text-end">
                            <span class="status-badge status-{{ $withdrawal->status }}">
                                {{ ucfirst($withdrawal->status) }}
                            </span>
                            <br>
                            <small class="text-muted">{{ $withdrawal->method_display_name }}</small>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="bx bx-receipt" style="font-size: 32px; opacity: 0.5;"></i>
                        <p class="mt-2 mb-0">No withdrawals yet</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Method selection styling
    document.querySelectorAll('.method-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.method-option').forEach(o => o.classList.remove('selected'));
            this.classList.add('selected');
            this.querySelector('input[type="radio"]').checked = true;
        });
    });

    // Form validation
    document.getElementById('withdrawalForm')?.addEventListener('submit', function(e) {
        const amount = parseFloat(this.querySelector('[name="amount"]').value) || 0;
        const method = this.querySelector('[name="method"]:checked');

        if (!method) {
            e.preventDefault();
            alert('Please select a withdrawal method.');
            return;
        }

        if (amount <= 0) {
            e.preventDefault();
            alert('Please enter a valid withdrawal amount.');
            return;
        }
    });
</script>
@endpush
