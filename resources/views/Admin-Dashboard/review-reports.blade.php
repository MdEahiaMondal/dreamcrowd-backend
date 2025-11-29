<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/assets/admin/libs/animate/css/animate.css" />
    <link rel="stylesheet" href="/assets/admin/libs/aos/css/aos.css" />
    @php $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="/assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
    @endif
    <link rel="stylesheet" href="/assets/admin/libs/datatable/css/datatable.css" />
    <link href="/assets/admin/libs/select2/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/bootstrap.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/style.css">
    <title>Super Admin Dashboard | Review Reports</title>
    <style>
        .stat-card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            transition: transform 0.2s;
            margin-bottom: 20px;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }
        .filter-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .table td {
            vertical-align: middle;
        }
        .badge-pending { background-color: #ffc107; color: #000; }
        .badge-approved { background-color: #28a745; }
        .badge-rejected { background-color: #dc3545; }
        .review-text {
            max-width: 250px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .report-reason {
            font-weight: 600;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <x-admin-sidebar/>

    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Review Reports</span>
            </div>
        </nav>

        <div class="home-content m-3 p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center">
                            <div class="stat-icon bg-primary me-3">
                                <i class="fa fa-flag"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Total Reports</h6>
                                <h3 class="mb-0">{{ $stats['total_reports'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center">
                            <div class="stat-icon bg-warning me-3">
                                <i class="fa fa-clock"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Pending</h6>
                                <h3 class="mb-0">{{ $stats['pending_reports'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center">
                            <div class="stat-icon bg-success me-3">
                                <i class="fa fa-check"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Approved</h6>
                                <h3 class="mb-0">{{ $stats['approved_reports'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center">
                            <div class="stat-icon bg-danger me-3">
                                <i class="fa fa-times"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Rejected</h6>
                                <h3 class="mb-0">{{ $stats['rejected_reports'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <form method="GET" action="{{ route('admin.review.reports') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Reason</label>
                            <select name="reason" class="form-control">
                                <option value="">All Reasons</option>
                                <option value="abusive_language" {{ request('reason') == 'abusive_language' ? 'selected' : '' }}>Abusive Language</option>
                                <option value="false_claim" {{ request('reason') == 'false_claim' ? 'selected' : '' }}>False Claim</option>
                                <option value="spam" {{ request('reason') == 'spam' ? 'selected' : '' }}>Spam</option>
                                <option value="inappropriate" {{ request('reason') == 'inappropriate' ? 'selected' : '' }}>Inappropriate</option>
                                <option value="other" {{ request('reason') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Date Filter</label>
                            <select name="date_filter" class="form-control">
                                <option value="">All Time</option>
                                <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="last_7_days" {{ request('date_filter') == 'last_7_days' ? 'selected' : '' }}>Last 7 Days</option>
                                <option value="last_month" {{ request('date_filter') == 'last_month' ? 'selected' : '' }}>Last Month</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Search</label>
                            <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-12 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i> Filter
                            </button>
                            <a href="{{ route('admin.review.reports') }}" class="btn btn-secondary">
                                <i class="fa fa-refresh"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Reports Table -->
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fa fa-flag me-2"></i>Review Reports</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Reported By (Seller)</th>
                                    <th>Review By (Buyer)</th>
                                    <th>Reason</th>
                                    <th>Review Content</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reports as $report)
                                    <tr>
                                        <td>{{ $report->id }}</td>
                                        <td>
                                            <div class="user-info">
                                                @if($report->reporter)
                                                    <img src="{{ $report->reporter->profile ? asset('assets/users/' . $report->reporter->profile) : asset('assets/user/asset/img/user-avatar.jpg') }}"
                                                        alt="Avatar" class="user-avatar">
                                                    <div>
                                                        <strong>{{ $report->reporter->first_name }} {{ $report->reporter->last_name }}</strong>
                                                        <br><small class="text-muted">{{ $report->reporter->email }}</small>
                                                    </div>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if($report->review && $report->review->user)
                                                <div class="user-info">
                                                    <img src="{{ $report->review->user->profile ? asset('assets/users/' . $report->review->user->profile) : asset('assets/user/asset/img/user-avatar.jpg') }}"
                                                        alt="Avatar" class="user-avatar">
                                                    <div>
                                                        <strong>{{ $report->review->user->first_name }} {{ $report->review->user->last_name }}</strong>
                                                        <br><small class="text-muted">{{ $report->review->user->email }}</small>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">Review Deleted</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary report-reason">{{ $report->reason_label }}</span>
                                            @if($report->description)
                                                <br><small class="text-muted mt-1" style="display: block;">{{ Str::limit($report->description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($report->review)
                                                <div class="review-text" title="{{ $report->review->cmnt }}">
                                                    <strong>{{ $report->review->rating }}/5 Stars</strong><br>
                                                    {{ Str::limit($report->review->cmnt, 60) }}
                                                </div>
                                            @else
                                                <span class="text-muted">Review Deleted</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($report->status == 'pending')
                                                <span class="badge badge-pending">Pending</span>
                                            @elseif($report->status == 'approved')
                                                <span class="badge badge-approved">Approved</span>
                                            @else
                                                <span class="badge badge-rejected">Rejected</span>
                                            @endif
                                        </td>
                                        <td>{{ $report->created_at->format('M d, Y') }}</td>
                                        <td>
                                            @if($report->status == 'pending')
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#handleModal{{ $report->id }}">
                                                    <i class="fa fa-gavel"></i> Handle
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#viewModal{{ $report->id }}">
                                                    <i class="fa fa-eye"></i> View
                                                </button>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Handle Modal for Pending Reports -->
                                    @if($report->status == 'pending')
                                    <div class="modal fade" id="handleModal{{ $report->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Handle Report #{{ $report->id }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <h6>Report Details</h6>
                                                            <p><strong>Reason:</strong> {{ $report->reason_label }}</p>
                                                            <p><strong>Description:</strong> {{ $report->description ?: 'No additional details provided' }}</p>
                                                            <p><strong>Reported By:</strong> {{ $report->reporter?->first_name }} {{ $report->reporter?->last_name }}</p>
                                                            <p><strong>Date:</strong> {{ $report->created_at->format('M d, Y H:i') }}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>Review Content</h6>
                                                            @if($report->review)
                                                                <p><strong>Rating:</strong> {{ $report->review->rating }}/5 Stars</p>
                                                                <p><strong>Comment:</strong></p>
                                                                <div class="p-3 bg-light rounded">{{ $report->review->cmnt ?: 'No comment' }}</div>
                                                                <p class="mt-2"><strong>By:</strong> {{ $report->review->user?->first_name }} {{ $report->review->user?->last_name }}</p>
                                                            @else
                                                                <p class="text-muted">Review has been deleted</p>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <form action="{{ route('admin.review.reports.handle', $report->id) }}" method="POST">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label class="form-label">Admin Notes (Optional)</label>
                                                            <textarea name="admin_notes" class="form-control" rows="3" placeholder="Add any notes about your decision..."></textarea>
                                                        </div>
                                                        <div class="alert alert-warning">
                                                            <i class="fa fa-exclamation-triangle me-2"></i>
                                                            <strong>Note:</strong> Approving this report will <strong>permanently delete</strong> the review.
                                                        </div>
                                                        <div class="d-flex justify-content-end gap-2">
                                                            <button type="submit" name="action" value="reject" class="btn btn-secondary">
                                                                <i class="fa fa-times"></i> Reject Report
                                                            </button>
                                                            <button type="submit" name="action" value="approve" class="btn btn-danger">
                                                                <i class="fa fa-check"></i> Approve & Delete Review
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- View Modal for Handled Reports -->
                                    @if($report->status != 'pending')
                                    <div class="modal fade" id="viewModal{{ $report->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Report #{{ $report->id }} Details</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Status:</strong>
                                                        @if($report->status == 'approved')
                                                            <span class="badge badge-approved">Approved</span>
                                                        @else
                                                            <span class="badge badge-rejected">Rejected</span>
                                                        @endif
                                                    </p>
                                                    <p><strong>Reason:</strong> {{ $report->reason_label }}</p>
                                                    <p><strong>Description:</strong> {{ $report->description ?: 'No details provided' }}</p>
                                                    <p><strong>Handled By:</strong> {{ $report->handler?->first_name }} {{ $report->handler?->last_name }}</p>
                                                    <p><strong>Handled At:</strong> {{ $report->handled_at?->format('M d, Y H:i') }}</p>
                                                    @if($report->admin_notes)
                                                        <p><strong>Admin Notes:</strong></p>
                                                        <div class="p-3 bg-light rounded">{{ $report->admin_notes }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                                            <p>No reports found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($reports->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $reports->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <script src="/assets/admin/libs/jquery/js/jquery.min.js"></script>
    <script src="/assets/admin/asset/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/admin/asset/js/sidebar.js"></script>
</body>
</html>
