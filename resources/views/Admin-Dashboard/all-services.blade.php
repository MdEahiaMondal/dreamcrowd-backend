<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Animate css -->
    <link rel="stylesheet" href="/assets/admin/libs/animate/css/animate.css" />
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="/assets/admin/libs/aos/css/aos.css" />
    <!-- Datatable css  -->
    <link rel="stylesheet" href="/assets/admin/libs/datatable/css/datatable.css" />

    {{-- Fav Icon --}}
    @php  $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="/assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
    @endif

    <!-- Select2 css -->
    <link href="/assets/admin/libs/select2/css/select2.min.css" rel="stylesheet" />
    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/bootstrap.min.css" />
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <!-- Default css -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/style.css" />
    <link rel="stylesheet" href="/assets/user/asset/css/style.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/sallermangement.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/seller-table.css" />
    <title>Super Admin Dashboard | All Services</title>
</head>
<style>
    .button { color: #0072b1 !important; }
    .status-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }
    .status-newly-created { background-color: #e3f2fd; color: #1976d2; }
    .status-active { background-color: #e8f5e9; color: #388e3c; }
    .status-delivered { background-color: #fff3e0; color: #f57c00; }
    .status-cancelled { background-color: #ffebee; color: #d32f2f; }
    .status-completed { background-color: #f3e5f5; color: #7b1fa2; }
    .service-thumbnail {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
    }
    .alert-dismissible .btn-close {
        padding: 0.5rem;
    }

    /* Tab Navigation Styling */
    .seller-tab-sec {
        background: #fff;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    }
    .seller-tab-title {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 0;
    }
    .seller-tab {
        padding: 12px 20px;
        text-decoration: none;
        color: #6c757d;
        font-weight: 500;
        font-size: 14px;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
        position: relative;
        margin-bottom: -2px;
        white-space: nowrap;
    }
    .seller-tab:hover {
        color: #0072b1;
        background-color: #f8f9fa;
        border-radius: 4px 4px 0 0;
    }
    .seller-tab.active {
        color: #0072b1;
        border-bottom-color: #0072b1;
        font-weight: 600;
        background-color: #f8f9fa;
        border-radius: 4px 4px 0 0;
    }
</style>
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
                                    <span class="min-title">Service Management</span>
                                    <i class="fa-solid fa-chevron-right"></i>
                                    <span class="min-title">All Services</span>
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

                        <!-- Blue MESSAGES section -->
                        <div class="user-notification">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="notify">
                                        <i class="bx bxs-briefcase"></i>
                                        <h2>Service Management</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Statistics Cards -->
                        <div class="row mb-4">
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="card shadow-sm border-0">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="text-muted mb-1">Total Services</h6>
                                                <h3 class="mb-0">{{ number_format((int)$stats['total_services']) }}</h3>
                                            </div>
                                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                                <i class="bx bx-briefcase fs-3 text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="card shadow-sm border-0">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="text-muted mb-1">Active Services</h6>
                                                <h3 class="mb-0">{{ number_format((int)$stats['active']) }}</h3>
                                            </div>
                                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                                <i class="bx bx-check-circle fs-3 text-success"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="card shadow-sm border-0">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="text-muted mb-1">Completed</h6>
                                                <h3 class="mb-0">{{ number_format((int)$stats['completed']) }}</h3>
                                            </div>
                                            <div class="bg-purple bg-opacity-10 p-3 rounded">
                                                <i class="bx bx-badge-check fs-3 text-purple"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="card shadow-sm border-0">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="text-muted mb-1">Total Revenue</h6>
                                                <h3 class="mb-0">@currency($stats['total_revenue'] ?? 0)</h3>
                                            </div>
                                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                                <i class="bx bx-dollar-circle fs-3 text-info"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Date Section -->
                        <div class="date-section">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="user-all-seller-drop">
                                        <form method="GET" action="{{ route('admin.all-services') }}">
                                            <div class="row align-items-center calendar-sec">
                                                <!-- Search Input -->
                                                <div class="col-md-3 mb-2">
                                                    <input type="text"
                                                           name="search"
                                                           class="form-control"
                                                           placeholder="Search services..."
                                                           value="{{ request('search') }}">
                                                </div>

                                                <!-- Seller Filter -->
                                                <div class="col-md-2 mb-2">
                                                    <select name="seller_id" class="form-select">
                                                        <option value="">All Sellers</option>
                                                        @foreach($sellers as $seller)
                                                            <option value="{{ $seller->id }}"
                                                                {{ request('seller_id') == $seller->id ? 'selected' : '' }}>
                                                                {{ trim($seller->first_name . ' ' . $seller->last_name) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Service Type Filter -->
                                                <div class="col-md-2 mb-2">
                                                    <select name="service_type" class="form-select">
                                                        <option value="">All Types</option>
                                                        <option value="oneOff" {{ request('service_type') == 'oneOff' ? 'selected' : '' }}>One-Off</option>
                                                        <option value="subscription" {{ request('service_type') == 'subscription' ? 'selected' : '' }}>Subscription</option>
                                                    </select>
                                                </div>

                                                <!-- Service Role Filter -->
                                                <div class="col-md-2 mb-2">
                                                    <select name="service_role" class="form-select">
                                                        <option value="">All Roles</option>
                                                        <option value="freelance" {{ request('service_role') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                                                        <option value="class" {{ request('service_role') == 'class' ? 'selected' : '' }}>Class</option>
                                                    </select>
                                                </div>

                                                <!-- Category Filter -->
                                                <div class="col-md-2 mb-2">
                                                    <select name="category" class="form-select">
                                                        <option value="">All Categories</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category }}"
                                                                {{ request('category') == $category ? 'selected' : '' }}>
                                                                {{ $category }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Date From -->
                                                <div class="col-md-2 mb-2">
                                                    <input type="date"
                                                           name="date_from"
                                                           class="form-control"
                                                           placeholder="From Date"
                                                           value="{{ request('date_from') }}">
                                                </div>

                                                <!-- Date To -->
                                                <div class="col-md-2 mb-2">
                                                    <input type="date"
                                                           name="date_to"
                                                           class="form-control"
                                                           placeholder="To Date"
                                                           value="{{ request('date_to') }}">
                                                </div>

                                                <!-- Filter Button -->
                                                <div class="col-md-2 mb-2">
                                                    <button type="submit" class="btn btn-primary w-100">
                                                        <i class="bx bx-filter"></i> Filter
                                                    </button>
                                                </div>

                                                <!-- Reset Button -->
                                                <div class="col-md-2 mb-2">
                                                    <a href="{{ route('admin.all-services') }}" class="btn btn-secondary w-100">
                                                        <i class="bx bx-reset"></i> Reset
                                                    </a>
                                                </div>

                                                <!-- Export Button -->
                                                <div class="col-md-2 mb-2">
                                                    <button type="submit" name="export" value="1" class="btn btn-success w-100">
                                                        <i class="bx bx-download"></i> Export Excel
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Navigation -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="seller-tab-sec">
                                    <div class="seller-tab-title">
                                        @php
                                            $currentStatus = request('status', 'all');
                                            $queryParams = request()->except('status');
                                        @endphp
                                        <a href="{{ route('admin.all-services', array_merge($queryParams, ['status' => 'all'])) }}"
                                           class="seller-tab {{ $currentStatus == 'all' ? 'active' : '' }}">
                                            All Services ({{ $stats['total_services'] }})
                                        </a>
                                        <a href="{{ route('admin.all-services', array_merge($queryParams, ['status' => 'newly_created'])) }}"
                                           class="seller-tab {{ $currentStatus == 'newly_created' ? 'active' : '' }}">
                                            Newly Created ({{ $stats['newly_created'] }})
                                        </a>
                                        <a href="{{ route('admin.all-services', array_merge($queryParams, ['status' => 'active'])) }}"
                                           class="seller-tab {{ $currentStatus == 'active' ? 'active' : '' }}">
                                            Active ({{ $stats['active'] }})
                                        </a>
                                        <a href="{{ route('admin.all-services', array_merge($queryParams, ['status' => 'delivered'])) }}"
                                           class="seller-tab {{ $currentStatus == 'delivered' ? 'active' : '' }}">
                                            Delivered ({{ $stats['delivered'] }})
                                        </a>
                                        <a href="{{ route('admin.all-services', array_merge($queryParams, ['status' => 'cancelled'])) }}"
                                           class="seller-tab {{ $currentStatus == 'cancelled' ? 'active' : '' }}">
                                            Cancelled ({{ $stats['cancelled'] }})
                                        </a>
                                        <a href="{{ route('admin.all-services', array_merge($queryParams, ['status' => 'completed'])) }}"
                                           class="seller-tab {{ $currentStatus == 'completed' ? 'active' : '' }}">
                                            Completed ({{ $stats['completed'] }})
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Services Table -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Service</th>
                                                <th>Seller</th>
                                                <th>Category</th>
                                                <th>Type</th>
                                                <th>Price</th>
                                                <th>Orders</th>
                                                <th>Rating</th>
                                                <th>Status</th>
                                                <th>Created</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($services as $service)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if($service->main_file && file_exists(public_path($service->main_file)))
                                                                <img src="/{{ $service->main_file }}"
                                                                     alt="Service"
                                                                     class="service-thumbnail me-2">
                                                            @else
                                                                <div class="service-thumbnail me-2 bg-light d-flex align-items-center justify-content-center">
                                                                    <i class="bx bx-image text-muted fs-4"></i>
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <strong>{{ Str::limit($service->title, 40) }}</strong>
                                                                <br>
                                                                <small class="text-muted">ID: {{ $service->id }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($service->user)
                                                            <div>
                                                                <strong>{{ trim($service->user->first_name . ' ' . $service->user->last_name) }}</strong>
                                                                <br>
                                                                <small class="text-muted">{{ $service->user->email }}</small>
                                                            </div>
                                                        @else
                                                            <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <strong>{{ $service->category_name ?? 'N/A' }}</strong>
                                                            @if($service->sub_category)
                                                                <br><small class="text-muted">{{ $service->sub_category }}</small>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info">{{ ucfirst($service->service_type ?? 'N/A') }}</span>
                                                        <br>
                                                        <small class="text-muted">{{ ucfirst($service->service_role ?? 'N/A') }}</small>
                                                    </td>
                                                    <td>
                                                        @if($service->rate)
                                                            <strong>@currency($service->rate)</strong>
                                                        @else
                                                            <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <strong>{{ $service->orders ?? 0 }}</strong>
                                                    </td>
                                                    <td>
                                                        @if($service->all_reviews_avg_rating)
                                                            <div>
                                                                <i class="bx bxs-star text-warning"></i>
                                                                <strong>{{ number_format((float)$service->all_reviews_avg_rating, 1) }}</strong>
                                                                <br>
                                                                <small class="text-muted">({{ $service->all_reviews_count }} reviews)</small>
                                                            </div>
                                                        @else
                                                            <span class="text-muted">No reviews</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php
                                                            $statusMap = [
                                                                0 => ['text' => 'Newly Created', 'class' => 'status-newly-created'],
                                                                1 => ['text' => 'Active', 'class' => 'status-active'],
                                                                2 => ['text' => 'Delivered', 'class' => 'status-delivered'],
                                                                3 => ['text' => 'Cancelled', 'class' => 'status-cancelled'],
                                                                4 => ['text' => 'Completed', 'class' => 'status-completed'],
                                                            ];
                                                            $currentStatusInfo = $statusMap[$service->status] ?? ['text' => 'Unknown', 'class' => ''];
                                                        @endphp
                                                        <span class="status-badge {{ $currentStatusInfo['class'] }}">
                                                            {{ $currentStatusInfo['text'] }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <small>{{ $service->created_at->format('M d, Y') }}</small>
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                                    type="button"
                                                                    data-bs-toggle="dropdown">
                                                                <i class="bx bx-dots-vertical-rounded"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a class="dropdown-item" href="/course-service/{{ $service->id }}" target="_blank">
                                                                        <i class="bx bx-show"></i> View Service
                                                                    </a>
                                                                </li>
                                                                <li><hr class="dropdown-divider"></li>
                                                                <li>
                                                                    <h6 class="dropdown-header">Change Status</h6>
                                                                </li>
                                                                @foreach([0 => 'Newly Created', 1 => 'Active', 2 => 'Delivered', 3 => 'Cancelled', 4 => 'Completed'] as $statusValue => $statusLabel)
                                                                    @if($service->status != $statusValue)
                                                                        <li>
                                                                            <form action="{{ route('admin.services.update-status', $service->id) }}"
                                                                                  method="POST"
                                                                                  class="d-inline"
                                                                                  onsubmit="return confirm('Change status to {{ $statusLabel }}?');">
                                                                                @csrf
                                                                                <input type="hidden" name="status" value="{{ $statusValue }}">
                                                                                <button type="submit" class="dropdown-item">
                                                                                    <i class="bx bx-refresh"></i> Set {{ $statusLabel }}
                                                                                </button>
                                                                            </form>
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                                <li><hr class="dropdown-divider"></li>
                                                                <li>
                                                                    <form action="{{ route('admin.services.toggle-visibility', $service->id) }}"
                                                                          method="POST"
                                                                          class="d-inline"
                                                                          onsubmit="return confirm('Toggle service visibility?');">
                                                                        @csrf
                                                                        <button type="submit" class="dropdown-item">
                                                                            <i class="bx bx-toggle-left"></i> Toggle Visibility
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center py-5">
                                                        <i class="bx bx-search fs-1 text-muted"></i>
                                                        <p class="text-muted mt-2">No services found matching your criteria.</p>
                                                        <a href="{{ route('admin.all-services') }}" class="btn btn-sm btn-primary">Reset Filters</a>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                @if($services->hasPages())
                                    <div class="d-flex justify-content-between align-items-center mt-4">
                                        <div class="text-muted">
                                            Showing {{ $services->firstItem() }} to {{ $services->lastItem() }} of {{ $services->total() }} services
                                        </div>
                                        <div>
                                            {{ $services->links('pagination::bootstrap-5') }}
                                        </div>
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

    <!-- jQuery -->
    <script src="/assets/admin/libs/jquery/jquery.js"></script>
    <!-- Bootstrap Bundle js -->
    <script src="/assets/admin/asset/js/bootstrap.min.js"></script>
    <!-- Select2 js -->
    <script src="/assets/admin/libs/select2/js/select2.min.js"></script>
    <!-- Sidebar js -->
    <script src="/assets/admin/asset/js/sidebar.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 for dropdowns
            $('select').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
</body>
</html>
