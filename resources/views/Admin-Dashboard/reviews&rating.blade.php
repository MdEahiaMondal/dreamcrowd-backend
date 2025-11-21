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
     @php  $home = \App\Models\HomeDynamic::first(); @endphp
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
    <title>Super Admin Dashboard | Reviews & Rating</title>
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
            align-items-center;
            justify-content-center;
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
        .review-text {
            font-size: 14px;
            line-height: 1.5;
        }
        .table-img {
            border-radius: 8px;
            object-fit: cover;
        }
        .star-rating i {
            font-size: 18px;
        }
        .rating-bars {
            padding: 10px 0;
        }
        .modal-content{
            width: 100% !important;
        }
        div[role="progressbar"] {
	/* --size: 12rem; */
	/* --fg: #0072b1; */
	/* --bg: #eeeeee; */
	/* --pgPercentage: var(--value); */
	/* animation: growProgressBar 3s 1 forwards; */
	/* width: var(--size); */
	/* height: var(--size); */
	/* border-radius: 50%; */
	/* display: grid; */
	/* place-items: center; */
	/* background: radial-gradient( closest-side, white 80%, transparent 0 99.9%, white 0 ), conic-gradient(var(--fg) calc(var(--pgPercentage) * 1%), var(--bg) 0); */
	font-family: Helvetica, Arial, sans-serif;
	font-size: calc(var(--size) / 5);
	color: var(--fg);
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
                          <span class="min-title">Reviews & Rating</span>
                          </div>
                      </div>
                  </div>

                  <!-- Blue MESSAGES section -->
                  <div class="user-notification">
                      <div class="row">
                          <div class="col-md-12">
                              <div class="notify">
                                <i class='bx bx-star icon' title="Reviews & Ratings"></i>
                                  <h2>Reviews & Rating</h2>
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
                      <!-- Total Reviews -->
                      <div class="col-md-3">
                          <div class="card stat-card">
                              <div class="card-body">
                                  <div class="d-flex align-items-center">
                                      <div class="flex-grow-1">
                                          <h6 class="text-muted mb-1">Total Reviews</h6>
                                          <h3 class="mb-0">{{ number_format($stats['total_reviews']) }}</h3>
                                          <small class="text-muted">{{ $stats['reviews_this_month'] }} this month</small>
                                      </div>
                                      <div class="stat-icon bg-primary">
                                          <i class="bx bx-comment-detail"></i>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <!-- Average Rating -->
                      <div class="col-md-3">
                          <div class="card stat-card">
                              <div class="card-body">
                                  <div class="d-flex align-items-center">
                                      <div class="flex-grow-1">
                                          <h6 class="text-muted mb-1">Average Rating</h6>
                                          <h3 class="mb-0">
                                              {{ $stats['average_rating'] ?? 0 }} <i class="bx bxs-star text-warning"></i>
                                          </h3>
                                          <small class="text-muted">Out of 5.0</small>
                                      </div>
                                      <div class="stat-icon bg-warning">
                                          <i class="bx bx-star"></i>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <!-- 5-Star Reviews -->
                      <div class="col-md-3">
                          <div class="card stat-card">
                              <div class="card-body">
                                  <div class="d-flex align-items-center">
                                      <div class="flex-grow-1">
                                          <h6 class="text-muted mb-1">5-Star Reviews</h6>
                                          <h3 class="mb-0">{{ number_format($stats['five_star']) }}</h3>
                                          <small class="text-success">
                                              {{ $stats['total_reviews'] > 0 ? round(($stats['five_star'] / $stats['total_reviews']) * 100, 1) : 0 }}% of total
                                          </small>
                                      </div>
                                      <div class="stat-icon bg-success">
                                          <i class="bx bx-happy"></i>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <!-- Unanswered Reviews -->
                      <div class="col-md-3">
                          <div class="card stat-card">
                              <div class="card-body">
                                  <div class="d-flex align-items-center">
                                      <div class="flex-grow-1">
                                          <h6 class="text-muted mb-1">Unanswered</h6>
                                          <h3 class="mb-0">{{ number_format($stats['unanswered_reviews']) }}</h3>
                                          <small class="text-warning">Need seller response</small>
                                      </div>
                                      <div class="stat-icon bg-info">
                                          <i class="bx bx-message-alt-x"></i>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Rating Distribution Chart -->
                  <div class="row mb-4">
                      <div class="col-md-12">
                          <div class="card border-0 shadow-sm">
                              <div class="card-body p-4">
                                  <div class="d-flex justify-content-between align-items-center mb-4">
                                      <h5 class="mb-0">
                                          <i class="bx bx-bar-chart text-primary me-2"></i>Rating Distribution
                                      </h5>
                                      <span class="badge bg-light text-dark">{{ $stats['total_reviews'] }} Total Reviews</span>
                                  </div>
                                  <div class="rating-bars">
                                      @foreach([5, 4, 3, 2, 1] as $star)
                                          @php
                                              $count = $stats[$star === 5 ? 'five_star' : ($star === 4 ? 'four_star' : ($star === 3 ? 'three_star' : ($star === 2 ? 'two_star' : 'one_star')))];
                                              $percentage = $stats['total_reviews'] > 0 ? ($count / $stats['total_reviews']) * 100 : 0;

                                              // Color coding for different ratings
                                              if ($star >= 4) {
                                                  $barColor = 'bg-succesgs';
                                                  $starColor = 'text-success';
                                              } elseif ($star == 3) {
                                                  $barColor = 'bg-warning';
                                                  $starColor = 'text-warning';
                                              } else {
                                                  $barColor = 'bg-danger';
                                                  $starColor = 'text-danger';
                                              }
                                          @endphp
                                          <div class="d-flex align-items-center mb-3">
                                              <div style="width: 80px; font-weight: 600;">
                                                  <span class="{{ $starColor }}">{{ $star }}</span>
                                                  <i class="bx bxs-star {{ $starColor }}"></i>
                                              </div>
                                              <div class="progress flex-grow-1 mx-3" style="height: 24px; background-color: #e9ecef;">
                                                  <div class="progress-bar {{ $barColor }}"
                                                       role="progressbar"
                                                       style="width: {{ $percentage }}%;"
                                                       aria-valuenow="{{ $percentage }}"
                                                       aria-valuemin="0"
                                                       aria-valuemax="100">
                                                      @if($percentage > 5)
                                                          <span class="px-2">{{ round($percentage, 1) }}%</span>
                                                      @endif
                                                  </div>
                                              </div>
                                              <div style="width: 140px; text-align: right;">
                                                  <strong>{{ number_format($count) }}</strong>
                                                  <small class="text-muted ms-1">({{ round($percentage, 1) }}%)</small>
                                              </div>
                                          </div>
                                      @endforeach
                                  </div>

                                  @if($stats['total_reviews'] == 0)
                                      <div class="text-center py-3 mt-3 bg-light rounded">
                                          <i class="bx bx-info-circle text-muted" style="font-size: 32px;"></i>
                                          <p class="text-muted mb-0 mt-2">No reviews available yet</p>
                                      </div>
                                  @endif
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Filter Section -->
                  <div class="filter-section">
                      <form method="GET" action="{{ route('admin.reviews.ratings') }}" id="filterForm">
                          <div class="row align-items-end">
                              <!-- Rating Filter -->
                              <div class="col-md-2 mb-2">
                                  <label class="form-label small"><strong>Rating</strong></label>
                                  <select class="form-select" name="rating">
                                      <option value="">All Ratings</option>
                                      <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                                      <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Stars</option>
                                      <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Stars</option>
                                      <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Stars</option>
                                      <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Star</option>
                                  </select>
                              </div>

                              <!-- Date Filter -->
                              <div class="col-md-2 mb-2">
                                  <label class="form-label small"><strong>Date Filter</strong></label>
                                  <select class="form-select" name="date_filter" id="dateFilter">
                                      <option value="">All Time</option>
                                      <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                                      <option value="yesterday" {{ request('date_filter') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                                      <option value="last_7_days" {{ request('date_filter') == 'last_7_days' ? 'selected' : '' }}>Last 7 Days</option>
                                      <option value="current_month" {{ request('date_filter') == 'current_month' ? 'selected' : '' }}>This Month</option>
                                      <option value="last_month" {{ request('date_filter') == 'last_month' ? 'selected' : '' }}>Last Month</option>
                                      <option value="custom" {{ request('date_filter') == 'custom' ? 'selected' : '' }}>Custom Range</option>
                                  </select>
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

                              <!-- Has Replies Filter -->
                              <div class="col-md-2 mb-2">
                                  <label class="form-label small"><strong>Replies</strong></label>
                                  <select class="form-select" name="has_replies">
                                      <option value="">All</option>
                                      <option value="yes" {{ request('has_replies') == 'yes' ? 'selected' : '' }}>With Replies</option>
                                      <option value="no" {{ request('has_replies') == 'no' ? 'selected' : '' }}>No Replies</option>
                                  </select>
                              </div>
                          </div>

                          <!-- Search & Actions Row -->
                          <div class="row mt-2">
                              <div class="col-md-6">
                                  <div class="input-group">
                                      <span class="input-group-text"><i class="bx bx-search"></i></span>
                                      <input type="text" name="search" class="form-control"
                                             placeholder="Search by buyer, seller, service, or review text..."
                                             value="{{ request('search') }}" />
                                  </div>
                              </div>
                              <div class="col-md-6 text-end">
                                  <button type="submit" class="btn btn-primary">
                                      <i class="bx bx-filter"></i> Filter
                                  </button>
                                  @if(request()->hasAny(['rating', 'date_filter', 'search', 'service_type', 'has_replies']))
                                      <a href="{{ route('admin.reviews.ratings') }}" class="btn btn-secondary">
                                          <i class="bx bx-reset"></i> Clear
                                      </a>
                                  @endif
                                  <button type="button" class="btn btn-success" id="exportExcel">
                                      <i class="bx bx-download"></i> Export Excel
                                  </button>
                              </div>
                          </div>
                      </form>
                  </div>

                  <!-- Reviews Table -->
                  <div class="rewiew-sec" id="installment-contant">
                    <div class="row" id="main-contant-AI">
                        <div class="col-md-12 installment-table">
                            <div class="table-responsive">
                                <div class="hack1">
                                    <div class="hack2">
                                        <table class="table">
                                            <thead>
                                                <tr class="text-nowrap">
                                                    <th>Review ID</th>
                                                    <th>Seller</th>
                                                    <th>Buyer</th>
                                                    <th>Service</th>
                                                    <th>Review</th>
                                                    <th>Rating</th>
                                                    <th>Date</th>
                                                    <th>Replies</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($reviews as $review)
                                                    <tr>
                                                        <!-- Review ID -->
                                                        <td><small class="text-muted">#{{ $review->id }}</small></td>

                                                        <!-- Seller -->
                                                        <td>
                                                            @if($review->teacher)
                                                                <div class="d-flex align-items-center">
                                                                    @if($review->teacher->profile)
                                                                        <img src="/storage/{{ $review->teacher->profile }}"
                                                                             class="rounded-circle me-2"
                                                                             width="40" height="40" alt="Seller">
                                                                    @else
                                                                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2"
                                                                             style="width: 40px; height: 40px;">
                                                                            {{ strtoupper(substr($review->teacher->first_name, 0, 1)) }}
                                                                        </div>
                                                                    @endif
                                                                    <div>
                                                                        <strong>{{ $review->teacher->first_name }} {{ $review->teacher->last_name }}</strong><br>
                                                                        <small class="text-muted">{{ Str::limit($review->teacher->email, 20) }}</small>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <span class="text-muted">N/A</span>
                                                            @endif
                                                        </td>

                                                        <!-- Buyer -->
                                                        <td>
                                                            @if($review->user)
                                                                <div class="d-flex align-items-center">
                                                                    @if($review->user->profile)
                                                                        <img src="/storage/{{ $review->user->profile }}"
                                                                             class="rounded-circle me-2"
                                                                             width="40" height="40" alt="Buyer">
                                                                    @else
                                                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                                                             style="width: 40px; height: 40px;">
                                                                            {{ strtoupper(substr($review->user->first_name, 0, 1)) }}
                                                                        </div>
                                                                    @endif
                                                                    <div>
                                                                        <strong>{{ $review->user->first_name }} {{ $review->user->last_name }}</strong><br>
                                                                        <small class="text-muted">{{ Str::limit($review->user->email, 20) }}</small>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <span class="text-muted">N/A</span>
                                                            @endif
                                                        </td>

                                                        <!-- Service -->
                                                        <td>
                                                            @if($review->gig)
                                                                <div class="d-flex align-items-center">
                                                                    @if($review->gig->main_file)
                                                                        <img src="/storage/{{ $review->gig->main_file }}"
                                                                             class="table-img me-2" width="50" height="50" alt="Service">
                                                                    @endif
                                                                    <div>
                                                                        <strong>{{ Str::limit($review->gig->title, 30) }}</strong><br>
                                                                        <small class="badge bg-info">{{ $review->gig->service_type }}</small>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <span class="text-muted">N/A</span>
                                                            @endif
                                                        </td>

                                                        <!-- Review Text -->
                                                        <td style="max-width: 250px;">
                                                            <p class="review-text mb-0">{{ Str::limit($review->cmnt, 80) }}</p>
                                                            @if(strlen($review->cmnt) > 80)
                                                                <a href="#" class="text-primary small" data-bs-toggle="modal"
                                                                   data-bs-target="#reviewModal{{ $review->id }}">Read more...</a>
                                                            @endif
                                                        </td>

                                                        <!-- Rating (Dynamic Stars) -->
                                                        <td>
                                                            <div class="star-rating">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    @if($i <= $review->rating)
                                                                        <i class="bx bxs-star text-warning"></i>
                                                                    @else
                                                                        <i class="bx bx-star text-muted"></i>
                                                                    @endif
                                                                @endfor
                                                                <br>
                                                                <small class="text-muted">({{ $review->rating }}/5)</small>
                                                            </div>
                                                        </td>

                                                        <!-- Date -->
                                                        <td class="text-nowrap">
                                                            {{ $review->created_at->format('M d, Y') }}<br>
                                                            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                                        </td>

                                                        <!-- Replies Count -->
                                                        <td class="text-center">
                                                            @if($review->replies->count() > 0)
                                                                <span class="badge bg-success">
                                                                    {{ $review->replies->count() }} {{ Str::plural('reply', $review->replies->count()) }}
                                                                </span>
                                                            @else
                                                                <span class="badge bg-secondary">No replies</span>
                                                            @endif
                                                        </td>

                                                        <!-- Actions -->
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-sm btn-info"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#reviewModal{{ $review->id }}"
                                                                        title="View Details">
                                                                    <i class="bx bx-show"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                        onclick="confirmDelete({{ $review->id }})"
                                                                        title="Delete Review">
                                                                    <i class="bx bx-trash"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Review Details Modal -->
                                                    <div class="modal fade" id="reviewModal{{ $review->id }}" tabindex="-1">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-light">
                                                                    <div class="d-flex align-items-center">
                                                                        <i class='bx bx-star text-warning me-2' style="font-size: 24px;"></i>
                                                                        <h5 class="modal-title mb-0">Review Details</h5>
                                                                    </div>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body p-4">
                                                                    <!-- Service Information Card -->
                                                                    <div class="card mb-4 border-0 shadow-sm">
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-md-2 text-center">
                                                                                    @if($review->gig->main_file)
                                                                                        <img src="/storage/{{ $review->gig->main_file }}"
                                                                                             class="img-fluid rounded"
                                                                                             style="max-height: 100px; object-fit: cover;"
                                                                                             alt="Service">
                                                                                    @else
                                                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                                                             style="height: 100px;">
                                                                                            <i class="bx bx-image text-muted" style="font-size: 48px;"></i>
                                                                                        </div>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="col-md-10">
                                                                                    <h6 class="text-muted mb-1">Service</h6>
                                                                                    <h5 class="mb-2">{{ $review->gig->title }}</h5>
                                                                                    <span class="badge bg-info">{{ $review->gig->service_type }}</span>
                                                                                    <span class="badge bg-secondary ms-1">{{ $review->gig->service_role }}</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Buyer and Seller Information -->
                                                                    <div class="row mb-4">
                                                                        <div class="col-md-6">
                                                                            <div class="card border-0 shadow-sm h-100">
                                                                                <div class="card-body">
                                                                                    <h6 class="text-muted mb-3">
                                                                                        <i class="bx bx-user-circle me-2"></i>Buyer Information
                                                                                    </h6>
                                                                                    <div class="d-flex align-items-center">
                                                                                        @if($review->user->profile)
                                                                                            <img src="/storage/{{ $review->user->profile }}"
                                                                                                 class="rounded-circle me-3"
                                                                                                 width="60" height="60" alt="Buyer">
                                                                                        @else
                                                                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                                                                                 style="width: 60px; height: 60px; font-size: 24px;">
                                                                                                {{ strtoupper(substr($review->user->first_name, 0, 1)) }}
                                                                                            </div>
                                                                                        @endif
                                                                                        <div>
                                                                                            <h6 class="mb-1">{{ $review->user->first_name }} {{ $review->user->last_name }}</h6>
                                                                                            <p class="text-muted mb-0">
                                                                                                <i class="bx bx-envelope me-1"></i>{{ $review->user->email }}
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="card border-0 shadow-sm h-100">
                                                                                <div class="card-body">
                                                                                    <h6 class="text-muted mb-3">
                                                                                        <i class="bx bx-briefcase me-2"></i>Seller Information
                                                                                    </h6>
                                                                                    <div class="d-flex align-items-center">
                                                                                        @if($review->teacher->profile)
                                                                                            <img src="/storage/{{ $review->teacher->profile }}"
                                                                                                 class="rounded-circle me-3"
                                                                                                 width="60" height="60" alt="Seller">
                                                                                        @else
                                                                                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-3"
                                                                                                 style="width: 60px; height: 60px; font-size: 24px;">
                                                                                                {{ strtoupper(substr($review->teacher->first_name, 0, 1)) }}
                                                                                            </div>
                                                                                        @endif
                                                                                        <div>
                                                                                            <h6 class="mb-1">{{ $review->teacher->first_name }} {{ $review->teacher->last_name }}</h6>
                                                                                            <p class="text-muted mb-0">
                                                                                                <i class="bx bx-envelope me-1"></i>{{ $review->teacher->email }}
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Main Review Card -->
                                                                    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                                        <div class="card-body text-white">
                                                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                                                <div>
                                                                                    <h6 class="text-white-50 mb-2">
                                                                                        <i class="bx bx-message-square-detail me-2"></i>Customer Review
                                                                                    </h6>
                                                                                    <div class="star-rating mb-2">
                                                                                        @for($i = 1; $i <= 5; $i++)
                                                                                            @if($i <= $review->rating)
                                                                                                <i class="bx bxs-star" style="font-size: 28px; color: #FFD700;"></i>
                                                                                            @else
                                                                                                <i class="bx bx-star" style="font-size: 28px; color: rgba(255,255,255,0.3);"></i>
                                                                                            @endif
                                                                                        @endfor
                                                                                        <span class="ms-2 fs-5 fw-bold">{{ $review->rating }}.0</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="text-end">
                                                                                    <small class="text-white-50">Review #{{ $review->id }}</small><br>
                                                                                    <small class="text-white-50">
                                                                                        <i class="bx bx-calendar me-1"></i>{{ $review->created_at->format('M d, Y') }}
                                                                                    </small>
                                                                                </div>
                                                                            </div>
                                                                            <div class="bg-white bg-opacity-10 p-3 rounded">
                                                                                <p class="mb-0 text-white" style="line-height: 1.8; font-size: 15px;">
                                                                                    "{{ $review->cmnt }}"
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Seller Replies Section -->
                                                                    @if($review->replies->count() > 0)
                                                                        <div class="mb-3">
                                                                            <h6 class="text-muted mb-3">
                                                                                <i class="bx bx-reply me-2"></i>Seller Replies
                                                                                <span class="badge bg-success ms-2">{{ $review->replies->count() }}</span>
                                                                            </h6>
                                                                            @foreach($review->replies as $index => $reply)
                                                                                <div class="card border-0 shadow-sm mb-3">
                                                                                    <div class="card-body">
                                                                                        <div class="d-flex align-items-start">
                                                                                            <div class="flex-shrink-0">
                                                                                                @if($reply->user->profile)
                                                                                                    <img src="/storage/{{ $reply->user->profile }}"
                                                                                                         class="rounded-circle"
                                                                                                         width="50" height="50" alt="User">
                                                                                                @else
                                                                                                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center"
                                                                                                         style="width: 50px; height: 50px; font-size: 20px;">
                                                                                                        {{ strtoupper(substr($reply->user->first_name, 0, 1)) }}
                                                                                                    </div>
                                                                                                @endif
                                                                                            </div>
                                                                                            <div class="flex-grow-1 ms-3">
                                                                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                                                                    <div>
                                                                                                        <h6 class="mb-0">{{ $reply->user->first_name }} {{ $reply->user->last_name }}</h6>
                                                                                                        <small class="text-muted">
                                                                                                            <i class="bx bx-time-five me-1"></i>{{ $reply->created_at->diffForHumans() }}
                                                                                                        </small>
                                                                                                    </div>
                                                                                                    <span class="badge bg-light text-dark">Reply #{{ $index + 1 }}</span>
                                                                                                </div>
                                                                                                <div class="bg-light p-3 rounded">
                                                                                                    <p class="mb-0" style="line-height: 1.8;">{{ $reply->cmnt }}</p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    @else
                                                                        <div class="text-center py-4">
                                                                            <i class="bx bx-message-x text-muted" style="font-size: 48px;"></i>
                                                                            <p class="text-muted mt-2">No seller replies yet</p>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="modal-footer bg-light">
                                                                    <small class="text-muted me-auto">
                                                                        <i class="bx bx-info-circle me-1"></i>
                                                                        Review ID: #{{ $review->id }} | Posted {{ $review->created_at->diffForHumans() }}
                                                                    </small>
                                                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                                                                        <i class="bx bx-x me-1"></i>Close
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <tr>
                                                        <td colspan="9" class="text-center py-4">
                                                            <i class="bx bx-info-circle" style="font-size: 48px; color: #ccc;"></i>
                                                            <p class="text-muted mt-2">No reviews found</p>
                                                            @if(request()->hasAny(['rating', 'date_filter', 'search', 'service_type']))
                                                                <a href="{{ route('admin.reviews.ratings') }}" class="btn btn-sm btn-primary">Clear Filters</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>

                  <!-- Pagination -->
                  <div class="d-flex justify-content-between align-items-center mt-3">
                      <div class="text-muted">
                          Showing {{ $reviews->firstItem() ?? 0 }} to {{ $reviews->lastItem() ?? 0 }}
                          of {{ $reviews->total() }} reviews
                      </div>
                      <div>
                          {{ $reviews->appends(request()->query())->links('pagination::bootstrap-5') }}
                      </div>
                  </div>

                  <!-- copyright section -->
                  <div class="copyright mt-4">
                    <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
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
  <script src="/assets/admin/libs/aos/js/aos.js"></script>
  <script src="/assets/admin/asset/js/bootstrap.min.js"></script>
  <script src="/assets/admin/asset/js/script.js"></script>

  <!-- Export and Filter JavaScript -->
  <script>
    // Export to Excel
    document.getElementById('exportExcel')?.addEventListener('click', function() {
        const params = new URLSearchParams(window.location.search);
        params.set('export', 'excel');
        window.location.href = '{{ route("admin.reviews.ratings") }}?' + params.toString();
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

    // Delete confirmation
    function confirmDelete(reviewId) {
        if (confirm('Are you sure you want to delete this review? This action cannot be undone and will also delete all replies.')) {
            // Create and submit delete form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/reviews/' + reviewId + '/delete';

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

    // Auto-dismiss alerts
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
  </script>

  <!-- Sidebar JS -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
        let arrow = document.querySelectorAll(".arrow");
        for (let i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", function (e) {
                let arrowParent = e.target.parentElement.parentElement;
                arrowParent.classList.toggle("showMenu");
            });
        }

        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-menu");

        sidebarBtn.addEventListener("click", function () {
            sidebar.classList.toggle("close");
        });

        function toggleSidebar() {
            let screenWidth = window.innerWidth;
            if (screenWidth < 992) {
                sidebar.classList.add("close");
            } else {
                sidebar.classList.remove("close");
            }
        }

        toggleSidebar();
        window.addEventListener("resize", function () {
            toggleSidebar();
        });
    });
  </script>
</body>
</html>
