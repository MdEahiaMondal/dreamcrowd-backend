<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Animate css -->
    <link rel="stylesheet" href="/assets/admin/libs/animate/css/animate.css" />
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="/assets/admin/libs/aos/css/aos.css" />
    {{-- Fav Icon --}}
    @php $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="/assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
    @endif
    <!-- Datatable css  -->
    <link rel="stylesheet" href="/assets/admin/libs/datatable/css/datatable.css" />
    <!-- Select2 css -->
    <link href="/assets/admin/libs/select2/css/select2.min.css" rel="stylesheet" />
    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/bootstrap.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <!-- Default css -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/style.css">
    <link rel="stylesheet" href="/assets/admin/asset/css/reviews-table.css">
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
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 16px;
        }
        .modal-content {
            width: 100% !important;
        }
    </style>
</head>
<body>
    {{-- ===========Admin Sidebar Start==================== --}}
    <x-admin-sidebar/>
    {{-- ===========Admin Sidebar End==================== --}}

    <section class="home-section">
        {{-- ===========Admin NavBar Start==================== --}}
        <x-admin-nav/>
        {{-- ===========Admin NavBar End==================== --}}

        <!-- =============================== MAIN CONTENT START HERE =========================== -->
        <div class="container-fluid">
            <div class="row dash-notification">
                <div class="col-md-12">
                    <div class="dash">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="dash-top">
                                    <h1 class="dash-title">Dashboard</h1>
                                    <i class="fa-solid fa-chevron-right"></i>
                                    <span class="min-title">Review Reports</span>
                                </div>
                            </div>
                        </div>

                        <!-- Blue MESSAGES section -->
                        <div class="user-notification">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="notify">
                                        <i class='bx bx-flag icon' title="Review Reports"></i>
                                        <h2>Review Reports</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Success/Error Messages -->
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

                        <!-- Statistics Cards Section -->
                        <div class="row mb-4">
                            <!-- Total Reports -->
                            <div class="col-md-3">
                                <div class="card stat-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h6 class="text-muted mb-1">Total Reports</h6>
                                                <h3 class="mb-0">{{ number_format($stats['total_reports']) }}</h3>
                                                <small class="text-muted">All time reports</small>
                                            </div>
                                            <div class="stat-icon bg-primary">
                                                <i class="bx bx-flag"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pending Reports -->
                            <div class="col-md-3">
                                <div class="card stat-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h6 class="text-muted mb-1">Pending</h6>
                                                <h3 class="mb-0">{{ number_format($stats['pending_reports']) }}</h3>
                                                <small class="text-warning">Needs attention</small>
                                            </div>
                                            <div class="stat-icon bg-warning">
                                                <i class="bx bx-time-five"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Approved Reports -->
                            <div class="col-md-3">
                                <div class="card stat-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h6 class="text-muted mb-1">Approved</h6>
                                                <h3 class="mb-0">{{ number_format($stats['approved_reports']) }}</h3>
                                                <small class="text-success">Reviews deleted</small>
                                            </div>
                                            <div class="stat-icon bg-success">
                                                <i class="bx bx-check"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Rejected Reports -->
                            <div class="col-md-3">
                                <div class="card stat-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h6 class="text-muted mb-1">Rejected</h6>
                                                <h3 class="mb-0">{{ number_format($stats['rejected_reports']) }}</h3>
                                                <small class="text-danger">Invalid reports</small>
                                            </div>
                                            <div class="stat-icon bg-danger">
                                                <i class="bx bx-x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Section -->
                        <div class="filter-section">
                            <form method="GET" action="{{ route('admin.review.reports') }}" id="filterForm">
                                <div class="row align-items-end">
                                    <!-- Status Filter -->
                                    <div class="col-md-2 mb-2">
                                        <label class="form-label small"><strong>Status</strong></label>
                                        <select class="form-select" name="status">
                                            <option value="">All Status</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </div>

                                    <!-- Reason Filter -->
                                    <div class="col-md-2 mb-2">
                                        <label class="form-label small"><strong>Reason</strong></label>
                                        <select class="form-select" name="reason">
                                            <option value="">All Reasons</option>
                                            <option value="abusive_language" {{ request('reason') == 'abusive_language' ? 'selected' : '' }}>Abusive Language</option>
                                            <option value="false_claim" {{ request('reason') == 'false_claim' ? 'selected' : '' }}>False Claim</option>
                                            <option value="spam" {{ request('reason') == 'spam' ? 'selected' : '' }}>Spam</option>
                                            <option value="inappropriate" {{ request('reason') == 'inappropriate' ? 'selected' : '' }}>Inappropriate</option>
                                            <option value="other" {{ request('reason') == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>

                                    <!-- Date Filter -->
                                    <div class="col-md-2 mb-2">
                                        <label class="form-label small"><strong>Date</strong></label>
                                        <select class="form-select" name="date_filter">
                                            <option value="">All Time</option>
                                            <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                                            <option value="last_7_days" {{ request('date_filter') == 'last_7_days' ? 'selected' : '' }}>Last 7 Days</option>
                                            <option value="last_month" {{ request('date_filter') == 'last_month' ? 'selected' : '' }}>Last Month</option>
                                        </select>
                                    </div>

                                    <!-- Search -->
                                    <div class="col-md-3 mb-2">
                                        <label class="form-label small"><strong>Search</strong></label>
                                        <input type="text" class="form-control" name="search" placeholder="Search reporter, buyer..." value="{{ request('search') }}">
                                    </div>

                                    <!-- Filter Buttons -->
                                    <div class="col-md-3 mb-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bx bx-filter-alt"></i> Filter
                                        </button>
                                        <a href="{{ route('admin.review.reports') }}" class="btn btn-secondary">
                                            <i class="bx bx-refresh"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Reports Table -->
                        <div class="card border-0 shadow-sm">
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
                                                                <div class="user-avatar bg-primary text-white">
                                                                    {{ strtoupper(substr($report->reporter->first_name ?? 'U', 0, 1)) }}
                                                                </div>
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
                                                                <div class="user-avatar bg-success text-white">
                                                                    {{ strtoupper(substr($report->review->user->first_name ?? 'U', 0, 1)) }}
                                                                </div>
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
                                                                <strong>{{ $report->review->rating }}/5 <i class="bx bxs-star text-warning"></i></strong><br>
                                                                {{ Str::limit($report->review->cmnt, 40) }}
                                                            </div>
                                                        @else
                                                            <span class="text-muted">Review Deleted</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($report->status == 'pending')
                                                            <span class="badge badge-pending"><i class="bx bx-time-five"></i> Pending</span>
                                                        @elseif($report->status == 'approved')
                                                            <span class="badge badge-approved"><i class="bx bx-check"></i> Approved</span>
                                                        @else
                                                            <span class="badge badge-rejected"><i class="bx bx-x"></i> Rejected</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $report->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        @if($report->status == 'pending')
                                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#handleModal{{ $report->id }}">
                                                                <i class="bx bx-gavel"></i> Handle
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#viewModal{{ $report->id }}">
                                                                <i class="bx bx-show"></i> View
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>

                                                <!-- Handle Modal for Pending Reports -->
                                                @if($report->status == 'pending')
                                                <div class="modal fade" id="handleModal{{ $report->id }}" tabindex="-1">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-primary text-white">
                                                                <h5 class="modal-title"><i class="bx bx-gavel me-2"></i>Handle Report #{{ $report->id }}</h5>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-6">
                                                                        <h6><i class="bx bx-flag text-danger"></i> Report Details</h6>
                                                                        <hr>
                                                                        <p><strong>Reason:</strong> <span class="badge bg-secondary">{{ $report->reason_label }}</span></p>
                                                                        <p><strong>Description:</strong> {{ $report->description ?: 'No additional details provided' }}</p>
                                                                        <p><strong>Reported By:</strong> {{ $report->reporter?->first_name }} {{ $report->reporter?->last_name }}</p>
                                                                        <p><strong>Date:</strong> {{ $report->created_at->format('M d, Y H:i') }}</p>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <h6><i class="bx bx-comment-detail text-primary"></i> Review Content</h6>
                                                                        <hr>
                                                                        @if($report->review)
                                                                            <p><strong>Rating:</strong> {{ $report->review->rating }}/5 <i class="bx bxs-star text-warning"></i></p>
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
                                                                        <label class="form-label"><strong>Admin Notes (Optional)</strong></label>
                                                                        <textarea name="admin_notes" class="form-control" rows="3" placeholder="Add any notes about your decision..."></textarea>
                                                                    </div>
                                                                    <div class="alert alert-warning">
                                                                        <i class="bx bx-info-circle me-2"></i>
                                                                        <strong>Note:</strong> Approving this report will <strong>permanently delete</strong> the review.
                                                                    </div>
                                                                    <div class="d-flex justify-content-end gap-2">
                                                                        <button type="submit" name="action" value="reject" class="btn btn-secondary">
                                                                            <i class="bx bx-x"></i> Reject Report
                                                                        </button>
                                                                        <button type="submit" name="action" value="approve" class="btn btn-danger">
                                                                            <i class="bx bx-check"></i> Approve & Delete Review
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
                                                                <h5 class="modal-title"><i class="bx bx-show me-2"></i>Report #{{ $report->id }} Details</h5>
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
                                                    <td colspan="8" class="text-center py-5">
                                                        <i class="bx bx-inbox" style="font-size: 48px; color: #ccc;"></i>
                                                        <p class="text-muted mt-2">No reports found</p>
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
                </div>
            </div>
        </div>
        <!-- =============================== MAIN CONTENT END HERE =========================== -->
    </section>

    <!-- Scripts -->
    <script src="/assets/admin/libs/jquery/jquery.js"></script>
    <script src="/assets/admin/libs/datatable/js/datatable.js"></script>
    <script src="/assets/admin/libs/datatable/js/datatablebootstrap.js"></script>
    <script src="/assets/admin/libs/select2/js/select2.min.js"></script>
    <script src="/assets/admin/libs/aos/js/aos.js"></script>
    <script src="/assets/admin/asset/js/bootstrap.min.js"></script>
    <script src="/assets/admin/asset/js/script.js"></script>
</body>
</html>
