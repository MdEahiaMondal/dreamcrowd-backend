<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/assets/admin/libs/animate/css/animate.css" />
    <link rel="stylesheet" href="/assets/admin/libs/aos/css/aos.css" />
    <link rel="stylesheet" href="/assets/admin/libs/datatable/css/datatable.css" />
    @php $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="/assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
    @endif
    <link href="/assets/admin/libs/select2/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/bootstrap.min.css" />
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/style.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/sallermangement.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/seller-table.css" />
    <title>Super Admin Dashboard | Withdrawal Management</title>
    <style>
        .stats-row {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
        }
        .stat-card {
            flex: 1;
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-left: 4px solid #007bff;
        }
        .stat-card.pending { border-left-color: #ffc107; }
        .stat-card.processing { border-left-color: #17a2b8; }
        .stat-card.amount { border-left-color: #dc3545; }
        .stat-card.paid { border-left-color: #28a745; }
        .stat-card h6 { color: #6c757d; margin-bottom: 10px; font-size: 13px; }
        .stat-card h3 { margin: 0; font-weight: bold; }
        .filter-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .table-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-processing { background: #cce5ff; color: #004085; }
        .status-completed { background: #d4edda; color: #155724; }
        .status-failed { background: #f8d7da; color: #721c24; }
        .status-cancelled { background: #e2e3e5; color: #383d41; }
        .method-badge {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 500;
        }
        .method-stripe { background: #635bff; color: white; }
        .method-bank_transfer { background: #6c757d; color: white; }
        .action-btns .btn {
            padding: 4px 8px;
            font-size: 12px;
            margin: 2px;
        }
        .bulk-actions {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            display: none;
        }
        .bulk-actions.show { display: block; }
        .select-all-checkbox { cursor: pointer; }
    </style>
</head>
<body>
    @include('components.admin-sidebar')
    <section class="home-section">
        <div class="home-content">
            <i class="bx bx-menu"></i>
            <span class="text">Withdrawal Management</span>
        </div>

        <div class="container-fluid px-4">
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

            <!-- Statistics Cards -->
            <div class="stats-row">
                <div class="stat-card pending">
                    <h6><i class="bx bx-time-five"></i> Pending Requests</h6>
                    <h3>{{ $stats['pending'] }}</h3>
                </div>
                <div class="stat-card processing">
                    <h6><i class="bx bx-loader-circle"></i> Processing</h6>
                    <h3>{{ $stats['processing'] }}</h3>
                </div>
                <div class="stat-card amount">
                    <h6><i class="bx bx-dollar"></i> Total Pending Amount</h6>
                    <h3>${{ number_format($stats['total_pending_amount'], 2) }}</h3>
                </div>
                <div class="stat-card paid">
                    <h6><i class="bx bx-check-double"></i> Paid This Month</h6>
                    <h3>${{ number_format($stats['total_paid_this_month'], 2) }}</h3>
                </div>
            </div>

            <!-- Filters -->
            <div class="filter-card">
                <form method="GET" action="{{ route('admin.withdrawals.index') }}">
                    <div class="row align-items-end">
                        <div class="col-md-2">
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
                        <div class="col-md-2">
                            <label class="form-label">Method</label>
                            <select name="method" class="form-control">
                                <option value="">All Methods</option>
                                <option value="stripe" {{ request('method') == 'stripe' ? 'selected' : '' }}>Stripe</option>
                                <option value="bank_transfer" {{ request('method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">From Date</label>
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">To Date</label>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bx bx-filter"></i> Filter
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.withdrawals.export', request()->all()) }}" class="btn btn-success w-100">
                                <i class="bx bx-download"></i> Export CSV
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Bulk Actions -->
            <div class="bulk-actions" id="bulkActions">
                <form method="POST" action="{{ route('admin.withdrawals.bulk') }}" id="bulkForm">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <span id="selectedCount">0</span> withdrawal(s) selected
                        </div>
                        <div class="col-md-3">
                            <select name="action" class="form-control" id="bulkAction" required>
                                <option value="">Select Action</option>
                                <option value="processing">Mark as Processing</option>
                                <option value="complete">Mark as Completed</option>
                                <option value="reject">Reject</option>
                            </select>
                        </div>
                        <div class="col-md-4" id="rejectReasonCol" style="display: none;">
                            <input type="text" name="failure_reason" class="form-control" placeholder="Rejection reason">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="bx bx-check"></i> Apply
                            </button>
                        </div>
                    </div>
                    <div id="selectedIds"></div>
                </form>
            </div>

            <!-- Withdrawals Table -->
            <div class="table-card">
                <h5 class="mb-4"><i class="bx bx-list-ul"></i> Withdrawal Requests</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" class="select-all-checkbox" id="selectAll">
                                </th>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Seller</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th>Processed</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($withdrawals as $withdrawal)
                            <tr>
                                <td>
                                    @if(in_array($withdrawal->status, ['pending', 'processing']))
                                    <input type="checkbox" class="withdrawal-checkbox" value="{{ $withdrawal->id }}">
                                    @endif
                                </td>
                                <td>#{{ $withdrawal->id }}</td>
                                <td>
                                    {{ $withdrawal->created_at->format('M d, Y') }}
                                    <br>
                                    <small class="text-muted">{{ $withdrawal->created_at->format('h:i A') }}</small>
                                </td>
                                <td>
                                    @if($withdrawal->seller)
                                    <strong>{{ $withdrawal->seller->first_name }} {{ $withdrawal->seller->last_name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $withdrawal->seller->email }}</small>
                                    @else
                                    <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>${{ number_format($withdrawal->amount, 2) }}</strong>
                                    @if($withdrawal->processing_fee > 0)
                                    <br>
                                    <small class="text-danger">Fee: -${{ number_format($withdrawal->processing_fee, 2) }}</small>
                                    @endif
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
                                </td>
                                <td>
                                    @if($withdrawal->processed_at)
                                    {{ $withdrawal->processed_at->format('M d, Y') }}
                                    <br>
                                    <small class="text-muted">
                                        by {{ $withdrawal->processor->first_name ?? 'System' }}
                                    </small>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="action-btns">
                                    <a href="{{ route('admin.withdrawals.show', $withdrawal->id) }}"
                                       class="btn btn-outline-primary btn-sm" title="View Details">
                                        <i class="bx bx-show"></i>
                                    </a>
                                    @if($withdrawal->isPending())
                                    <form action="{{ route('admin.withdrawals.processing', $withdrawal->id) }}"
                                          method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-info btn-sm" title="Mark Processing">
                                            <i class="bx bx-loader-circle"></i>
                                        </button>
                                    </form>
                                    @endif
                                    @if(in_array($withdrawal->status, ['pending', 'processing']))
                                    <button type="button" class="btn btn-outline-success btn-sm"
                                            onclick="showCompleteModal({{ $withdrawal->id }}, '{{ $withdrawal->method }}')" title="Complete">
                                        <i class="bx bx-check"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                            onclick="showRejectModal({{ $withdrawal->id }})" title="Reject">
                                        <i class="bx bx-x"></i>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <i class="bx bx-wallet" style="font-size: 48px; color: #dee2e6;"></i>
                                    <p class="mt-3 text-muted">No withdrawal requests found.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($withdrawals->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $withdrawals->appends(request()->all())->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Complete Modal -->
    <div class="modal fade" id="completeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="completeForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bx bx-check-circle"></i> Complete Withdrawal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 stripe-option" id="stripeProcessOption" style="display: none;">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="process_stripe" id="processStripe" value="1" checked>
                                <label class="form-check-label" for="processStripe">
                                    <i class="bx bxl-stripe"></i> Process Stripe Transfer automatically
                                </label>
                            </div>
                            <small class="text-muted">When enabled, funds will be transferred to seller's Stripe account automatically.</small>
                        </div>
                        <div class="mb-3" id="transactionIdField">
                            <label class="form-label">Transaction ID (Optional)</label>
                            <input type="text" name="transaction_id" class="form-control"
                                   placeholder="Stripe Transfer ID or Bank reference">
                            <small class="text-muted">Leave empty if processing Stripe automatically</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Admin Notes (Optional)</label>
                            <textarea name="admin_notes" class="form-control" rows="2"></textarea>
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
                <form method="POST" id="rejectForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bx bx-x-circle"></i> Reject Withdrawal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Reason for Rejection *</label>
                            <textarea name="failure_reason" class="form-control" rows="3" required
                                      placeholder="Please provide a reason for rejecting this withdrawal..."></textarea>
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
    <script>
        // Select all functionality
        document.getElementById('selectAll').addEventListener('change', function() {
            document.querySelectorAll('.withdrawal-checkbox').forEach(cb => {
                cb.checked = this.checked;
            });
            updateBulkActions();
        });

        document.querySelectorAll('.withdrawal-checkbox').forEach(cb => {
            cb.addEventListener('change', updateBulkActions);
        });

        function updateBulkActions() {
            const checked = document.querySelectorAll('.withdrawal-checkbox:checked');
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');
            const selectedIds = document.getElementById('selectedIds');

            if (checked.length > 0) {
                bulkActions.classList.add('show');
                selectedCount.textContent = checked.length;
                selectedIds.innerHTML = '';
                checked.forEach(cb => {
                    selectedIds.innerHTML += `<input type="hidden" name="withdrawal_ids[]" value="${cb.value}">`;
                });
            } else {
                bulkActions.classList.remove('show');
            }
        }

        // Show/hide reject reason for bulk actions
        document.getElementById('bulkAction').addEventListener('change', function() {
            document.getElementById('rejectReasonCol').style.display =
                this.value === 'reject' ? 'block' : 'none';
        });

        // Modal functions
        function showCompleteModal(id, method = null) {
            document.getElementById('completeForm').action = `/admin/withdrawals/${id}/complete`;

            // Show Stripe processing option if method is stripe
            const stripeOption = document.getElementById('stripeProcessOption');
            if (method === 'stripe') {
                stripeOption.style.display = 'block';
                document.getElementById('processStripe').checked = true;
            } else {
                stripeOption.style.display = 'none';
            }

            new bootstrap.Modal(document.getElementById('completeModal')).show();
        }

        function showRejectModal(id) {
            document.getElementById('rejectForm').action = `/admin/withdrawals/${id}/reject`;
            new bootstrap.Modal(document.getElementById('rejectModal')).show();
        }
    </script>
</body>
</html>
