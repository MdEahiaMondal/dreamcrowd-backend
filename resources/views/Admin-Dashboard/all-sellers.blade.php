<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Animate css -->
    <link rel="stylesheet" href="/assets/admin/libs/animate/css/animate.css"/>
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="/assets/admin/libs/aos/css/aos.css"/>
    <!-- Datatable css  -->
    <link rel="stylesheet" href="/assets/admin/libs/datatable/css/datatable.css"/>
    {{-- Fav Icon --}}
    @php  $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="/assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
    @endif
    <!-- Select2 css -->
    <link href="/assets/admin/libs/select2/css/select2.min.css" rel="stylesheet"/>
    <!-- Owl carousel css -->
    <link href="/assets/admin/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet"/>
    <link href="/assets/admin/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet"/>
    <!-- fontawsome -->
    <link rel="stylesheet" href="/assets/public-site/asset/css/fontawesome.min.css"/>
    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/bootstrap.min.css"/>
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"/>
    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <!-- Default css -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/sidebar.css"/>
    <link rel="stylesheet" href="/assets/admin/asset/css/style.css"/>
    <link rel="stylesheet" href="/assets/admin/asset/css/sallermangement.css"/>
    <link rel="stylesheet" href="/assets/admin/asset/css/seller-table.css"/>
    <title>Super Admin Dashboard | All Sellers</title>
    <style>
        .button {
            color: #0072b1 !important;
        }
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
        .table td {
            vertical-align: middle;
        }
        .badge {
            font-weight: 500;
            padding: 5px 10px;
        }
        .nav-link .badge {
            font-size: 11px;
            padding: 3px 7px;
        }
        .action-btn {
            background: transparent;
            border: none;
            font-size: 20px;
            font-weight: bold;
            color: #0072b1;
            cursor: pointer;
        }
        .dropdown-item i {
            width: 20px;
            margin-right: 5px;
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
                    <!-- Breadcrumb -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="dash-top">
                                <h1 class="dash-title">Dashboard</h1>
                                <i class="fa-solid fa-chevron-right"></i>
                                <span class="min-title">Seller Management</span>
                                <i class="fa-solid fa-chevron-right"></i>
                                <span class="min-title">All Sellers</span>
                            </div>
                        </div>
                    </div>

                    <!-- Page Header -->
                    <div class="user-notification">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="notify">
                                    <i class="bx bxs-user-detail"></i>
                                    <h2>Seller Management</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Success/Error Messages -->
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

                    <!-- Statistics Cards Section -->
                    <div class="row mb-4">
                        <!-- Total Sellers -->
                        <div class="col-md-3">
                            <div class="card stat-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="text-muted mb-1">Total Sellers</h6>
                                            <h3 class="mb-0">{{ number_format($stats['total_sellers']) }}</h3>
                                            <small class="text-muted">{{ $stats['sellers_this_month'] }} this month</small>
                                        </div>
                                        <div class="stat-icon bg-primary">
                                            <i class="bx bx-user-circle"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Active Sellers -->
                        <div class="col-md-3">
                            <div class="card stat-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="text-muted mb-1">Active Sellers</h6>
                                            <h3 class="mb-0">{{ number_format($stats['active_sellers']) }}</h3>
                                            <small class="text-success">Currently active</small>
                                        </div>
                                        <div class="stat-icon bg-success">
                                            <i class="bx bx-user-check"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Services -->
                        <div class="col-md-3">
                            <div class="card stat-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="text-muted mb-1">Total Services</h6>
                                            <h3 class="mb-0">{{ number_format($stats['total_services']) }}</h3>
                                            <small class="text-muted">Services listed</small>
                                        </div>
                                        <div class="stat-icon bg-info">
                                            <i class="bx bx-briefcase"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Revenue -->
                        <div class="col-md-3">
                            <div class="card stat-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="text-muted mb-1">Total Revenue</h6>
                                            <h3 class="mb-0">${{ number_format($stats['total_revenue'], 2) }}</h3>
                                            <small class="text-muted">All transactions</small>
                                        </div>
                                        <div class="stat-icon bg-warning">
                                            <i class="bx bx-dollar-circle"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <div class="date-section">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="GET" action="{{ route('admin.all-sellers') }}" id="filterForm">
                                    <!-- Preserve current tab status -->
                                    <input type="hidden" name="status" value="{{ $status }}">

                                    <div class="row align-items-end">
                                        <!-- Date Filter -->
                                        <div class="col-md-2 mb-2">
                                            <label class="form-label small"><strong>Registration Date</strong></label>
                                            <div class="date-sec">
                                                <i class="fa-solid fa-calendar-days"></i>
                                                <select class="form-select" name="date_filter" id="dateFilter">
                                                    <option value="">All Time</option>
                                                    <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                                                    <option value="yesterday" {{ request('date_filter') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                                                    <option value="last_week" {{ request('date_filter') == 'last_week' ? 'selected' : '' }}>Last Week</option>
                                                    <option value="last_7_days" {{ request('date_filter') == 'last_7_days' ? 'selected' : '' }}>Last 7 Days</option>
                                                    <option value="current_month" {{ request('date_filter') == 'current_month' ? 'selected' : '' }}>This Month</option>
                                                    <option value="last_month" {{ request('date_filter') == 'last_month' ? 'selected' : '' }}>Last Month</option>
                                                    <option value="custom" {{ request('date_filter') == 'custom' ? 'selected' : '' }}>Custom Range</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Custom Date Range -->
                                        <div class="col-md-2 mb-2" id="fromDateFields" style="display: {{ request('date_filter') == 'custom' ? 'block' : 'none' }}">
                                            <label class="form-label small"><strong>From</strong></label>
                                            <input type="date" class="form-control" name="from_date" value="{{ request('from_date') }}" />
                                        </div>
                                        <div class="col-md-2 mb-2" id="toDateFields" style="display: {{ request('date_filter') == 'custom' ? 'block' : 'none' }}">
                                            <label class="form-label small"><strong>To</strong></label>
                                            <input type="date" class="form-control" name="to_date" value="{{ request('to_date') }}" />
                                        </div>

                                        <!-- Service Type Filter -->
                                        <div class="col-md-2 mb-2">
                                            <label class="form-label small"><strong>Service Type</strong></label>
                                            <select class="form-select" name="service_type">
                                                <option value="">All Types</option>
                                                <option value="OneOff" {{ request('service_type') == 'OneOff' ? 'selected' : '' }}>One-Off Class</option>
                                                <option value="Subscription" {{ request('service_type') == 'Subscription' ? 'selected' : '' }}>Subscription</option>
                                                <option value="Freelance" {{ request('service_type') == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                                            </select>
                                        </div>

                                        <!-- Category Filter -->
                                        <div class="col-md-2 mb-2">
                                            <label class="form-label small"><strong>Category</strong></label>
                                            <select class="form-select" name="category_id">
                                                <option value="">All Categories</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->category }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Filter Button -->
                                        <div class="col-md-2 mb-2">
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="bx bx-filter"></i> Filter
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Search & Export Row -->
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bx bx-search"></i></span>
                                                <input type="text" name="search" class="form-control"
                                                       placeholder="Search by name, email, or ID..."
                                                       value="{{ request('search') }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            @if(request()->hasAny(['date_filter', 'search', 'service_type', 'category_id', 'location']))
                                                <a href="{{ route('admin.all-sellers', ['status' => $status]) }}" class="btn btn-secondary">
                                                    <i class="bx bx-reset"></i> Clear Filters
                                                </a>
                                            @endif
                                            <button type="button" class="btn btn-success" id="exportExcel">
                                                <i class="bx bx-download"></i> Export Excel
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Navigation -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="super-tab-nav">
                                <nav>
                                    <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                        <!-- Active Accounts Tab -->
                                        <a class="nav-link {{ $status == 'active' ? 'active' : '' }}"
                                           href="{{ route('admin.all-sellers', array_merge(request()->except('status'), ['status' => 'active'])) }}">
                                            Active Accounts
                                            <span class="badge bg-success ms-1">{{ $stats['active_sellers'] }}</span>
                                        </a>

                                        <!-- Hidden Sellers Tab -->
                                        <a class="nav-link {{ $status == 'hidden' ? 'active' : '' }}"
                                           href="{{ route('admin.all-sellers', array_merge(request()->except('status'), ['status' => 'hidden'])) }}">
                                            Hidden Seller
                                            <span class="badge bg-secondary ms-1">{{ $stats['hidden_sellers'] }}</span>
                                        </a>

                                        <!-- Paused Accounts Tab -->
                                        <a class="nav-link {{ $status == 'paused' ? 'active' : '' }}"
                                           href="{{ route('admin.all-sellers', array_merge(request()->except('status'), ['status' => 'paused'])) }}">
                                            Paused Accounts
                                            <span class="badge bg-warning ms-1">{{ $stats['paused_sellers'] }}</span>
                                        </a>

                                        <!-- Banned Accounts Tab -->
                                        <a class="nav-link {{ $status == 'banned' ? 'active' : '' }}"
                                           href="{{ route('admin.all-sellers', array_merge(request()->except('status'), ['status' => 'banned'])) }}">
                                            Banned Accounts
                                            <span class="badge bg-danger ms-1">{{ $stats['banned_sellers'] }}</span>
                                        </a>

                                        <!-- Deleted Accounts Tab -->
                                        <a class="nav-link {{ $status == 'deleted' ? 'active' : '' }}"
                                           href="{{ route('admin.all-sellers', array_merge(request()->except('status'), ['status' => 'deleted'])) }}">
                                            Deleted Accounts
                                            <span class="badge bg-dark ms-1">{{ $stats['deleted_sellers'] }}</span>
                                        </a>
                                    </div>
                                </nav>
                            </div>

                            <!-- Sellers Table (Single Dynamic Table) -->
                            <div class="tab-content border bg-light" id="nav-tabContent">
                                <div class="main-container d-flex">
                                    <div class="content w-100" id="vt-main-section">
                                        <div class="container-fluid" id="installment-contant">
                                            <div class="row" id="main-contant-AI">
                                                <div class="col-md-12 p-0">
                                                    <div class="row installment-table">
                                                        <div class="col-md-12 p-0">
                                                            <div class="table-responsive">
                                                                <div class="hack1">
                                                                    <div class="hack2">
                                                                        <table class="table">
                                                                            <thead>
                                                                                <tr class="text-nowrap">
                                                                                    <th>Seller</th>
                                                                                    <th>Seller ID</th>
                                                                                    <th>Reg. Date</th>
                                                                                    <th>Service Type</th>
                                                                                    <th>Category</th>
                                                                                    <th>Location</th>
                                                                                    <th>Rating</th>
                                                                                    <th>Total Orders</th>
                                                                                    <th>Total Earnings</th>
                                                                                    <th>Gigs</th>
                                                                                    <th>Status</th>
                                                                                    <th>Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @forelse($sellers as $seller)
                                                                                    <tr>
                                                                                        <!-- Seller (Name + Profile Pic) -->
                                                                                        <td>
                                                                                            <div class="d-flex align-items-center gap-2">
                                                                                                @if($seller->profile_pic)
                                                                                                    <img src="/storage/{{ $seller->profile_pic }}"
                                                                                                         class="rounded-circle"
                                                                                                         width="40" height="40"
                                                                                                         alt="Seller">
                                                                                                @else
                                                                                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                                                                                         style="width: 40px; height: 40px;">
                                                                                                        {{ strtoupper(substr($seller->first_name, 0, 1)) }}
                                                                                                    </div>
                                                                                                @endif
                                                                                                <div>
                                                                                                    <strong>{{ $seller->first_name }} {{ $seller->last_name }}</strong><br>
                                                                                                    <small class="text-muted">{{ $seller->email }}</small>
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>

                                                                                        <!-- Seller ID -->
                                                                                        <td>#{{ str_pad($seller->id, 7, '0', STR_PAD_LEFT) }}</td>

                                                                                        <!-- Registration Date -->
                                                                                        <td class="text-nowrap">
                                                                                            {{ $seller->created_at->format('M d, Y') }}<br>
                                                                                            <small class="text-muted">{{ $seller->created_at->diffForHumans() }}</small>
                                                                                        </td>

                                                                                        <!-- Service Type (from gigs) -->
                                                                                        <td>
                                                                                            @if($seller->teacherGigs->isNotEmpty())
                                                                                                @php
                                                                                                    $serviceTypes = $seller->teacherGigs->pluck('service_type')->unique();
                                                                                                @endphp
                                                                                                @foreach($serviceTypes as $type)
                                                                                                    <span class="badge bg-info mb-1">{{ $type }}</span><br>
                                                                                                @endforeach
                                                                                            @else
                                                                                                <span class="text-muted">No Services</span>
                                                                                            @endif
                                                                                        </td>

                                                                                        <!-- Category (from expert profile or gigs) -->
                                                                                        <td>
                                                                                            @if($seller->expertProfile && ($seller->expertProfile->category_class || $seller->expertProfile->category_freelance))
                                                                                                {{ $seller->expertProfile->category_class ?? $seller->expertProfile->category_freelance }}
                                                                                            @elseif($seller->teacherGigs->isNotEmpty())
                                                                                                @php
                                                                                                    $categories = $seller->teacherGigs->whereNotNull('category_name')->pluck('category_name')->unique()->take(2);
                                                                                                @endphp
                                                                                                {{ $categories->implode(', ') }}
                                                                                            @else
                                                                                                <span class="text-muted">N/A</span>
                                                                                            @endif
                                                                                        </td>

                                                                                        <!-- Location -->
                                                                                        <td class="text-nowrap">
                                                                                            @if($seller->city && $seller->country)
                                                                                                {{ $seller->city }}, {{ $seller->country }}
                                                                                            @elseif($seller->country)
                                                                                                {{ $seller->country }}
                                                                                            @else
                                                                                                <span class="text-muted">Not set</span>
                                                                                            @endif
                                                                                        </td>

                                                                                        <!-- Rating -->
                                                                                        <td>
                                                                                            @if($seller->average_rating)
                                                                                                <div class="d-flex align-items-center">
                                                                                                    <i class="bx bxs-star text-warning"></i>
                                                                                                    <span class="ms-1">{{ number_format($seller->average_rating, 1) }}</span>
                                                                                                </div>
                                                                                                <small class="text-muted">({{ $seller->received_reviews_count ?? 0 }} reviews)</small>
                                                                                            @else
                                                                                                <span class="text-muted">No reviews</span>
                                                                                            @endif
                                                                                        </td>

                                                                                        <!-- Total Orders -->
                                                                                        <td>
                                                                                            <strong>{{ number_format($seller->book_orders_count) }}</strong>
                                                                                        </td>

                                                                                        <!-- Total Earnings -->
                                                                                        <td class="text-nowrap">
                                                                                            <strong class="text-success">
                                                                                                ${{ number_format($seller->total_earnings ?? 0, 2) }}
                                                                                            </strong>
                                                                                        </td>

                                                                                        <!-- Total Gigs -->
                                                                                        <td>
                                                                                            <strong>{{ $seller->teacher_gigs_count }}</strong>
                                                                                        </td>

                                                                                        <!-- Status Badge -->
                                                                                        <td>
                                                                                            @if($seller->status == 0)
                                                                                                <span class="badge bg-success">Active</span>
                                                                                            @elseif($seller->status == 2)
                                                                                                <span class="badge bg-secondary">Hidden</span>
                                                                                            @elseif($seller->status == 3)
                                                                                                <span class="badge bg-warning">Paused</span>
                                                                                            @elseif($seller->status == 4)
                                                                                                <span class="badge bg-danger">Banned</span>
                                                                                            @elseif($seller->trashed())
                                                                                                <span class="badge bg-dark">Deleted</span>
                                                                                            @else
                                                                                                <span class="badge bg-secondary">Unknown</span>
                                                                                            @endif
                                                                                        </td>

                                                                                        <!-- Actions -->
                                                                                        <td>
                                                                                            <div class="expert-dropdown">
                                                                                                <button class="btn action-btn" type="button"
                                                                                                        id="dropdownMenuButton{{ $seller->id }}"
                                                                                                        data-bs-toggle="dropdown"
                                                                                                        aria-expanded="false">
                                                                                                    ...
                                                                                                </button>
                                                                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $seller->id }}">
                                                                                                    <!-- View Services -->
                                                                                                    <li>
                                                                                                        <a class="dropdown-item" href="{{ route('admin.all-services', ['seller_id' => $seller->id]) }}">
                                                                                                            <i class="bx bx-briefcase"></i> View Services
                                                                                                        </a>
                                                                                                    </li>

                                                                                                    <li><hr class="dropdown-divider"></li>

                                                                                                    <!-- Status Actions (conditional based on current status) -->
                                                                                                    @if($status == 'active')
                                                                                                        <li>
                                                                                                            <a class="dropdown-item" href="#"
                                                                                                               onclick="updateSellerStatus({{ $seller->id }}, 2); return false;">
                                                                                                                <i class="bx bx-hide"></i> Hide Seller
                                                                                                            </a>
                                                                                                        </li>
                                                                                                        <li>
                                                                                                            <a class="dropdown-item" href="#"
                                                                                                               onclick="updateSellerStatus({{ $seller->id }}, 3); return false;">
                                                                                                                <i class="bx bx-pause-circle"></i> Pause Account
                                                                                                            </a>
                                                                                                        </li>
                                                                                                        <li>
                                                                                                            <a class="dropdown-item text-danger" href="#"
                                                                                                               onclick="updateSellerStatus({{ $seller->id }}, 4); return false;">
                                                                                                                <i class="bx bx-block"></i> Ban Account
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    @elseif($status == 'hidden' || $status == 'paused' || $status == 'banned')
                                                                                                        <li>
                                                                                                            <a class="dropdown-item text-success" href="#"
                                                                                                               onclick="updateSellerStatus({{ $seller->id }}, 0); return false;">
                                                                                                                <i class="bx bx-check-circle"></i> Activate Account
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    @endif

                                                                                                    @if($status != 'deleted')
                                                                                                        <li><hr class="dropdown-divider"></li>
                                                                                                        <li>
                                                                                                            <a class="dropdown-item text-danger" href="#"
                                                                                                               onclick="confirmDelete({{ $seller->id }}); return false;">
                                                                                                                <i class="bx bx-trash"></i> Delete Account
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    @else
                                                                                                        <li>
                                                                                                            <a class="dropdown-item text-success" href="#"
                                                                                                               onclick="restoreSeller({{ $seller->id }}); return false;">
                                                                                                                <i class="bx bx-undo"></i> Restore Account
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    @endif
                                                                                                </ul>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                @empty
                                                                                    <tr>
                                                                                        <td colspan="12" class="text-center py-4">
                                                                                            <i class="bx bx-info-circle" style="font-size: 48px; color: #ccc;"></i>
                                                                                            <p class="text-muted mt-2">No sellers found</p>
                                                                                            @if(request()->hasAny(['date_filter', 'search', 'service_type', 'category_id']))
                                                                                                <a href="{{ route('admin.all-sellers', ['status' => $status]) }}"
                                                                                                   class="btn btn-sm btn-primary">Clear Filters</a>
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforelse
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Pagination -->
                                                            <div class="d-flex justify-content-between align-items-center mt-3 px-3 pb-3">
                                                                <div class="text-muted">
                                                                    Showing {{ $sellers->firstItem() ?? 0 }} to {{ $sellers->lastItem() ?? 0 }}
                                                                    of {{ $sellers->total() }} sellers
                                                                </div>
                                                                <div>
                                                                    {{ $sellers->appends(request()->query())->links('pagination::bootstrap-5') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- =============================== MAIN CONTENT END HERE =========================== -->
</section>

<script src="/assets/admin/libs/jquery/jquery.js"></script>
<script src="/assets/admin/libs/datatable/js/datatable.js"></script>
<script src="/assets/admin/libs/datatable/js/datatablebootstrap.js"></script>
<script src="/assets/admin/libs/select2/js/select2.min.js"></script>
<script src="/assets/admin/libs/owl-carousel/js/owl.carousel.min.js"></script>
<script src="/assets/admin/libs/aos/js/aos.js"></script>
<script src="/assets/admin/asset/js/bootstrap.min.js"></script>
<script src="/assets/admin/asset/js/script.js"></script>

<script>
// Export to Excel
document.getElementById('exportExcel')?.addEventListener('click', function() {
    const params = new URLSearchParams(window.location.search);
    params.set('export', 'excel');
    window.location.href = '{{ route("admin.all-sellers") }}?' + params.toString();
});

// Date filter toggle
const dateFilter = document.getElementById('dateFilter');
const fromDateFields = document.getElementById('fromDateFields');
const toDateFields = document.getElementById('toDateFields');

dateFilter?.addEventListener('change', function() {
    if (this.value === 'custom') {
        fromDateFields.style.display = 'block';
        toDateFields.style.display = 'block';
    } else {
        fromDateFields.style.display = 'none';
        toDateFields.style.display = 'none';
    }
});

// Update seller status
function updateSellerStatus(sellerId, status) {
    const statusText = {
        0: 'activate',
        2: 'hide',
        3: 'pause',
        4: 'ban'
    };

    if (confirm(`Are you sure you want to ${statusText[status]} this seller?`)) {
        // Create and submit form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/sellers/' + sellerId + '/status';

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;

        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status';
        statusInput.value = status;

        form.appendChild(csrfInput);
        form.appendChild(statusInput);
        document.body.appendChild(form);
        form.submit();
    }
}

// Delete seller confirmation
function confirmDelete(sellerId) {
    if (confirm('Are you sure you want to delete this seller? This will soft delete their account.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/sellers/' + sellerId + '/delete';

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;

        form.appendChild(csrfInput);
        document.body.appendChild(form);
        form.submit();
    }
}

// Restore seller
function restoreSeller(sellerId) {
    if (confirm('Are you sure you want to restore this seller?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/sellers/' + sellerId + '/restore';

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;

        form.appendChild(csrfInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
</body>
</html>
