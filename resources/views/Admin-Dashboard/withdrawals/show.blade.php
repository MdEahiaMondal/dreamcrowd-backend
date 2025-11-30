<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/assets/admin/libs/animate/css/animate.css" />
    <link rel="stylesheet" href="/assets/admin/libs/aos/css/aos.css" />
    @php $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="/assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
    @endif
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/bootstrap.min.css" />
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/style.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/sallermangement.css" />
    <title>Super Admin Dashboard | Withdrawal Details</title>
    <style>
        .detail-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-processing { background: #cce5ff; color: #004085; }
        .status-completed { background: #d4edda; color: #155724; }
        .status-failed { background: #f8d7da; color: #721c24; }
        .status-cancelled { background: #e2e3e5; color: #383d41; }
        .method-badge {
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
        }
        .method-stripe { background: #635bff; color: white; }
        .method-bank_transfer { background: #6c757d; color: white; }
        .info-row {
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            color: #6c757d;
            font-size: 13px;
            margin-bottom: 4px;
        }
        .info-value {
            font-weight: 500;
            color: #333;
        }
        .amount-display {
            font-size: 36px;
            font-weight: bold;
            color: #28a745;
        }
        .seller-card {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .seller-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
        }
        .history-item {
            padding: 10px;
            border-left: 3px solid #dee2e6;
            margin-bottom: 10px;
            background: #f8f9fa;
            border-radius: 0 8px 8px 0;
        }
        .history-item.completed { border-left-color: #28a745; }
        .history-item.pending { border-left-color: #ffc107; }
        .history-item.failed { border-left-color: #dc3545; }
        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .payment-details {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            font-family: monospace;
        }
    </style>
</head>
<body>
    @include('components.admin-sidebar')
    <section class="home-section">
        <div class="home-content">
            <i class="bx bx-menu"></i>
            <span class="text">Withdrawal Details</span>
        </div>

        <div class="container-fluid px-4">
            <!-- Back Button -->
            <div class="mb-3">
                <a href="{{ route('admin.withdrawals.index') }}" class="btn btn-outline-secondary">
                    <i class="bx bx-arrow-back"></i> Back to List
                </a>
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

            <div class="row">
                <!-- Main Details Column -->
                <div class="col-lg-8">
                    <!-- Withdrawal Details Card -->
                    <div class="detail-card">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h4 class="mb-1">Withdrawal #{{ $withdrawal->id }}</h4>
                                <small class="text-muted">
                                    Requested on {{ $withdrawal->created_at->format('F d, Y \a\t h:i A') }}
                                </small>
                            </div>
                            <span class="status-badge status-{{ $withdrawal->status }}">
                                {{ ucfirst($withdrawal->status) }}
                            </span>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-row">
                                    <div class="info-label">Amount Requested</div>
                                    <div class="amount-display">${{ number_format($withdrawal->amount, 2) }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-row">
                                    <div class="info-label">Net Amount (After Fees)</div>
                                    <div class="amount-display">${{ number_format($withdrawal->net_amount, 2) }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="info-row">
                                    <div class="info-label">Payment Method</div>
                                    <div class="info-value">
                                        <span class="method-badge method-{{ $withdrawal->method }}">
                                            {{ $withdrawal->method_display_name }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-row">
                                    <div class="info-label">Processing Fee</div>
                                    <div class="info-value">${{ number_format($withdrawal->processing_fee, 2) }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-row">
                                    <div class="info-label">Currency</div>
                                    <div class="info-value">{{ $withdrawal->currency }}</div>
                                </div>
                            </div>
                        </div>

                        @if($withdrawal->seller_notes)
                        <div class="mt-3">
                            <div class="info-label">Seller Notes</div>
                            <div class="info-value">{{ $withdrawal->seller_notes }}</div>
                        </div>
                        @endif

                        @if($withdrawal->admin_notes)
                        <div class="mt-3">
                            <div class="info-label">Admin Notes</div>
                            <div class="info-value">{{ $withdrawal->admin_notes }}</div>
                        </div>
                        @endif

                        @if($withdrawal->failure_reason)
                        <div class="mt-3 alert alert-danger">
                            <strong>Failure Reason:</strong> {{ $withdrawal->failure_reason }}
                        </div>
                        @endif
                    </div>

                    <!-- Payment Details Card -->
                    <div class="detail-card">
                        <h5 class="mb-4"><i class="bx bx-credit-card"></i> Payment Details</h5>

                        @if($withdrawal->payment_details)
                        <div class="payment-details">
                            @foreach($withdrawal->payment_details as $key => $value)
                            @if($value && !str_contains($key, 'encrypted'))
                            <div class="row mb-2">
                                <div class="col-4 text-muted">{{ ucwords(str_replace('_', ' ', $key)) }}:</div>
                                <div class="col-8">{{ $value }}</div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        @else
                        <p class="text-muted">No payment details available.</p>
                        @endif

                        @if($withdrawal->isCompleted())
                        <div class="mt-4">
                            <h6>Transaction References</h6>
                            @if($withdrawal->stripe_transfer_id)
                            <div class="info-row">
                                <div class="info-label">Stripe Transfer ID</div>
                                <div class="info-value"><code>{{ $withdrawal->stripe_transfer_id }}</code></div>
                            </div>
                            @endif
                            @if($withdrawal->bank_reference)
                            <div class="info-row">
                                <div class="info-label">Bank Reference</div>
                                <div class="info-value"><code>{{ $withdrawal->bank_reference }}</code></div>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    @if(in_array($withdrawal->status, ['pending', 'processing']))
                    <div class="detail-card">
                        <h5 class="mb-4"><i class="bx bx-cog"></i> Actions</h5>
                        <div class="action-buttons">
                            @if($withdrawal->isPending())
                            <form action="{{ route('admin.withdrawals.processing', $withdrawal->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-info">
                                    <i class="bx bx-loader-circle"></i> Mark as Processing
                                </button>
                            </form>
                            @endif

                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#completeModal">
                                <i class="bx bx-check"></i> Complete Withdrawal
                            </button>

                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                <i class="bx bx-x"></i> Reject Withdrawal
                            </button>
                        </div>
                    </div>
                    @endif

                    <!-- Processing Info -->
                    @if($withdrawal->processed_at)
                    <div class="detail-card">
                        <h5 class="mb-4"><i class="bx bx-check-shield"></i> Processing Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-row">
                                    <div class="info-label">Processed At</div>
                                    <div class="info-value">{{ $withdrawal->processed_at->format('F d, Y \a\t h:i A') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-row">
                                    <div class="info-label">Processed By</div>
                                    <div class="info-value">
                                        {{ $withdrawal->processor ? $withdrawal->processor->first_name . ' ' . $withdrawal->processor->last_name : 'System' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar Column -->
                <div class="col-lg-4">
                    <!-- Seller Info Card -->
                    <div class="detail-card">
                        <h5 class="mb-4"><i class="bx bx-user"></i> Seller Information</h5>
                        @if($withdrawal->seller)
                        <div class="seller-card">
                            <div class="seller-avatar">
                                {{ strtoupper(substr($withdrawal->seller->first_name, 0, 1)) }}
                            </div>
                            <div>
                                <strong>{{ $withdrawal->seller->first_name }} {{ $withdrawal->seller->last_name }}</strong>
                                <br>
                                <small class="text-muted">{{ $withdrawal->seller->email }}</small>
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="info-row">
                                <div class="info-label">Seller ID</div>
                                <div class="info-value">#{{ $withdrawal->seller->id }}</div>
                            </div>
                            @if($withdrawal->seller->stripe_account_id)
                            <div class="info-row">
                                <div class="info-label">Stripe Account</div>
                                <div class="info-value">
                                    <span class="badge bg-success">Connected</span>
                                </div>
                            </div>
                            @endif
                        </div>
                        @else
                        <p class="text-muted">Seller information not available.</p>
                        @endif
                    </div>

                    <!-- Previous Withdrawals -->
                    <div class="detail-card">
                        <h5 class="mb-4"><i class="bx bx-history"></i> Previous Withdrawals</h5>
                        @forelse($sellerWithdrawals as $prev)
                        <div class="history-item {{ $prev->status }}">
                            <div class="d-flex justify-content-between">
                                <strong>${{ number_format($prev->amount, 2) }}</strong>
                                <span class="status-badge status-{{ $prev->status }}" style="font-size: 10px; padding: 3px 8px;">
                                    {{ ucfirst($prev->status) }}
                                </span>
                            </div>
                            <small class="text-muted">{{ $prev->created_at->format('M d, Y') }}</small>
                        </div>
                        @empty
                        <p class="text-muted">No previous withdrawals.</p>
                        @endforelse
                    </div>

                    <!-- Recent Transactions -->
                    <div class="detail-card">
                        <h5 class="mb-4"><i class="bx bx-receipt"></i> Recent Transactions</h5>
                        @forelse($sellerTransactions as $txn)
                        <div class="history-item completed">
                            <div class="d-flex justify-content-between">
                                <span>{{ \Illuminate\Support\Str::limit($txn->bookOrder->title ?? 'Transaction', 20) }}</span>
                                <strong class="text-success">${{ number_format($txn->seller_earnings, 2) }}</strong>
                            </div>
                            <small class="text-muted">{{ $txn->created_at->format('M d, Y') }}</small>
                        </div>
                        @empty
                        <p class="text-muted">No recent transactions.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Complete Modal -->
    <div class="modal fade" id="completeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.withdrawals.complete', $withdrawal->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bx bx-check-circle"></i> Complete Withdrawal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>You are about to mark this withdrawal of <strong>${{ number_format($withdrawal->amount, 2) }}</strong> as completed.</p>

                        @if($withdrawal->method === 'stripe')
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="process_stripe" id="processStripe" value="1" checked>
                                <label class="form-check-label" for="processStripe">
                                    <i class="bx bxl-stripe"></i> Process Stripe Transfer automatically
                                </label>
                            </div>
                            <small class="text-muted">When enabled, funds will be transferred to seller's Stripe account ({{ $withdrawal->seller->stripe_account_id ?? 'Not Connected' }}) automatically.</small>
                        </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Transaction ID (Optional)</label>
                            <input type="text" name="transaction_id" class="form-control"
                                   placeholder="Enter Stripe Transfer ID or Bank reference">
                            <small class="text-muted">Leave empty if processing Stripe automatically</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Admin Notes (Optional)</label>
                            <textarea name="admin_notes" class="form-control" rows="2"
                                      placeholder="Any notes about this payout..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="bx bx-check"></i> Complete Withdrawal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.withdrawals.reject', $withdrawal->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bx bx-x-circle"></i> Reject Withdrawal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>You are about to reject this withdrawal request of <strong>${{ number_format($withdrawal->amount, 2) }}</strong>.</p>
                        <div class="mb-3">
                            <label class="form-label">Reason for Rejection *</label>
                            <textarea name="failure_reason" class="form-control" rows="3" required
                                      placeholder="Please provide a reason for rejecting this withdrawal..."></textarea>
                        </div>
                        <div class="alert alert-warning">
                            <i class="bx bx-info-circle"></i> The seller will be notified of this rejection via email.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="bx bx-x"></i> Reject Withdrawal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/assets/admin/asset/js/bootstrap.bundle.min.js"></script>
</body>
</html>
