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
     <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
     <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <!-- Default css -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/style.css">
    <link rel="stylesheet" href="/assets/admin/asset/css/invoice.css">
    <title>Super Admin Dashboard | Invoice & Statement</title>
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
        .table td {
            vertical-align: middle;
        }
        .badge {
            font-weight: 500;
            padding: 5px 10px;
        }
        .filter-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
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
                          <span class="min-title">Invoice & Statement</span>
                          </div>
                      </div>
                  </div>

                  <!-- Blue MESSAGES section -->
                  <div class="user-notification">
                      <div class="row">
                          <div class="col-md-12">
                              <div class="notify">
                                <i class='bx bx-file' title="Invoice & Statement"></i>
                                  <h2>Invoice & Statement</h2>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Statistics Cards Section -->
                  <div class="row mb-4">
                      <div class="col-md-4">
                          <div class="card stat-card">
                              <div class="card-body">
                                  <div class="d-flex align-items-center">
                                      <div class="flex-grow-1">
                                          <h6 class="text-muted mb-1">Monthly Revenue</h6>
                                          <h3 class="mb-0">${{ number_format($stats['monthly_revenue'], 2) }}</h3>
                                          <small class="text-success">{{ $stats['transactions_this_month'] }} transactions</small>
                                      </div>
                                      <div class="stat-icon bg-success">
                                          <i class="bx bx-dollar-circle"></i>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="card stat-card">
                              <div class="card-body">
                                  <div class="d-flex align-items-center">
                                      <div class="flex-grow-1">
                                          <h6 class="text-muted mb-1">Total Revenue</h6>
                                          <h3 class="mb-0">${{ number_format($stats['total_revenue'], 2) }}</h3>
                                          <small class="text-muted">{{ $stats['total_transactions'] }} total transactions</small>
                                      </div>
                                      <div class="stat-icon bg-primary">
                                          <i class="bx bx-wallet"></i>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="card stat-card">
                              <div class="card-body">
                                  <div class="d-flex align-items-center">
                                      <div class="flex-grow-1">
                                          <h6 class="text-muted mb-1">Pending Payouts</h6>
                                          <h3 class="mb-0">${{ number_format($stats['pending_payouts'], 2) }}</h3>
                                          <small class="text-warning">Awaiting payout</small>
                                      </div>
                                      <div class="stat-icon bg-warning">
                                          <i class="bx bx-time-five"></i>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Filter Section -->
                  <div class="filter-section">
                      <form method="GET" action="{{ route('admin.invoice') }}" id="filterForm">
                          <div class="row align-items-end">
                              <!-- Date Filter Dropdown -->
                              <div class="col-md-2 mb-2">
                                  <label class="form-label small"><strong>Date Filter</strong></label>
                                  <select class="form-select" name="date_filter" id="dateFilter">
                                      <option value="">All Time</option>
                                      <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                                      <option value="yesterday" {{ request('date_filter') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                                      <option value="last_week" {{ request('date_filter') == 'last_week' ? 'selected' : '' }}>Last Week</option>
                                      <option value="last_7_days" {{ request('date_filter') == 'last_7_days' ? 'selected' : '' }}>Last 7 Days</option>
                                      <option value="current_month" {{ request('date_filter') == 'current_month' ? 'selected' : '' }}>Current Month</option>
                                      <option value="last_month" {{ request('date_filter') == 'last_month' ? 'selected' : '' }}>Last Month</option>
                                      <option value="custom" {{ request('date_filter') == 'custom' ? 'selected' : '' }}>Custom Range</option>
                                  </select>
                              </div>

                              <!-- Custom Date Range (Hidden by default) -->
                              <div class="col-md-2 mb-2" id="fromDateFields" style="display: {{ request('date_filter') == 'custom' ? 'block' : 'none' }}">
                                  <label class="form-label small"><strong>From Date</strong></label>
                                  <input type="date" class="form-control" name="from_date" value="{{ request('from_date') }}" />
                              </div>
                              <div class="col-md-2 mb-2" id="toDateFields" style="display: {{ request('date_filter') == 'custom' ? 'block' : 'none' }}">
                                  <label class="form-label small"><strong>To Date</strong></label>
                                  <input type="date" class="form-control" name="to_date" value="{{ request('to_date') }}" />
                              </div>

                              <!-- Service Type Filter -->
                              <div class="col-md-2 mb-2">
                                  <label class="form-label small"><strong>Service Type</strong></label>
                                  <select class="form-select" name="service_type">
                                      <option value="">All Types</option>
                                      <option value="service" {{ request('service_type') == 'service' ? 'selected' : '' }}>Service</option>
                                      <option value="class" {{ request('service_type') == 'class' ? 'selected' : '' }}>Class</option>
                                  </select>
                              </div>

                              <!-- Status Filter -->
                              <div class="col-md-2 mb-2">
                                  <label class="form-label small"><strong>Status</strong></label>
                                  <select class="form-select" name="status">
                                      <option value="">All Status</option>
                                      <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                      <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                      <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                      <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                  </select>
                              </div>

                              <!-- Filter Button -->
                              <div class="col-md-2 mb-2">
                                  <button type="submit" class="btn btn-primary w-100">
                                      <i class="bx bx-filter"></i> Filter
                                  </button>
                              </div>
                          </div>

                          <!-- Search Box (Second Row) -->
                          <div class="row mt-2">
                              <div class="col-md-6">
                                  <div class="input-group">
                                      <span class="input-group-text"><i class="bx bx-search"></i></span>
                                      <input type="text" name="search" class="form-control"
                                             placeholder="Search by seller, buyer, email, or transaction ID..."
                                             value="{{ request('search') }}" />
                                  </div>
                              </div>
                              <div class="col-md-6 text-end">
                                  @if(request()->hasAny(['date_filter', 'search', 'service_type', 'status', 'payout_status']))
                                      <a href="{{ route('admin.invoice') }}" class="btn btn-secondary">
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

                  <!-- Transactions Table -->
                  <div class="row installment-table">
                    <div class="col-md-12">
                        <div class="table-responsive table-desc">
                            <div class="hack1">
                                <div class="hack2">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr class="text-nowrap">
                                                <th>Date</th>
                                                <th>Transaction ID</th>
                                                <th>Seller</th>
                                                <th>Buyer</th>
                                                <th>Service</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Commission</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($transactions as $transaction)
                                                <tr>
                                                    <!-- Date -->
                                                    <td class="text-nowrap">{{ $transaction->created_at->format('d-m-Y') }}</td>

                                                    <!-- Transaction ID -->
                                                    <td>
                                                        <small class="text-muted">#{{ $transaction->id }}</small><br>
                                                        @if($transaction->stripe_transaction_id)
                                                            <small class="text-muted" title="{{ $transaction->stripe_transaction_id }}">
                                                                {{ Str::limit($transaction->stripe_transaction_id, 12) }}
                                                            </small>
                                                        @endif
                                                    </td>

                                                    <!-- Seller -->
                                                    <td>
                                                        @if($transaction->seller)
                                                            <strong>{{ $transaction->seller->first_name }} {{ $transaction->seller->last_name }}</strong><br>
                                                            <small class="text-muted">{{ $transaction->seller->email }}</small>
                                                        @else
                                                            <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>

                                                    <!-- Buyer -->
                                                    <td>
                                                        @if($transaction->buyer)
                                                            <strong>{{ $transaction->buyer->first_name }} {{ $transaction->buyer->last_name }}</strong><br>
                                                            <small class="text-muted">{{ $transaction->buyer->email }}</small>
                                                        @else
                                                            <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>

                                                    <!-- Service -->
                                                    <td>
                                                        @if($transaction->bookOrder && $transaction->bookOrder->gig)
                                                            {{ Str::limit($transaction->bookOrder->gig->title, 30) }}
                                                        @else
                                                            <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>

                                                    <!-- Service Type -->
                                                    <td>
                                                        @if($transaction->service_type == 'service')
                                                            <span class="badge bg-info">Service</span>
                                                        @elseif($transaction->service_type == 'class')
                                                            <span class="badge bg-primary">Class</span>
                                                        @else
                                                            <span class="badge bg-secondary">{{ ucfirst($transaction->service_type) }}</span>
                                                        @endif
                                                    </td>

                                                    <!-- Total Amount -->
                                                    <td class="text-nowrap">
                                                        <strong>${{ number_format($transaction->total_amount, 2) }}</strong><br>
                                                        <small class="text-muted">{{ $transaction->currency }}</small>
                                                    </td>

                                                    <!-- Admin Commission -->
                                                    <td class="text-nowrap">
                                                        <strong class="text-success">${{ number_format($transaction->total_admin_commission, 2) }}</strong>
                                                    </td>

                                                    <!-- Status -->
                                                    <td>
                                                        @if($transaction->status == 'completed')
                                                            <span class="badge bg-success">Completed</span>
                                                        @elseif($transaction->status == 'pending')
                                                            <span class="badge bg-warning">Pending</span>
                                                        @elseif($transaction->status == 'refunded')
                                                            <span class="badge bg-danger">Refunded</span>
                                                        @elseif($transaction->status == 'failed')
                                                            <span class="badge bg-dark">Failed</span>
                                                        @else
                                                            <span class="badge bg-secondary">{{ ucfirst($transaction->status) }}</span>
                                                        @endif
                                                        <br>
                                                        @if($transaction->payout_status == 'paid')
                                                            <small class="badge bg-success mt-1">Payout: Paid</small>
                                                        @elseif($transaction->payout_status == 'pending')
                                                            <small class="badge bg-warning mt-1">Payout: Pending</small>
                                                        @else
                                                            <small class="badge bg-secondary mt-1">Payout: {{ ucfirst($transaction->payout_status) }}</small>
                                                        @endif
                                                    </td>

                                                    <!-- Actions -->
                                                    <td class="text-nowrap">
                                                        <a href="{{ route('admin.transaction.invoice', $transaction->id) }}"
                                                           class="btn btn-sm btn-primary"
                                                           title="Download Invoice">
                                                            <i class="bx bx-receipt"></i>
                                                        </a>
                                                        <a href="{{ route('admin.transaction.details', $transaction->id) }}"
                                                           class="btn btn-sm btn-info"
                                                           title="View Details">
                                                            <i class="bx bx-show"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center py-4">
                                                        <i class="bx bx-info-circle" style="font-size: 48px; color: #ccc;"></i>
                                                        <p class="text-muted mt-2">No transactions found</p>
                                                        @if(request()->hasAny(['date_filter', 'search', 'service_type', 'status']))
                                                            <a href="{{ route('admin.invoice') }}" class="btn btn-sm btn-primary">Clear Filters</a>
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

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Showing {{ $transactions->firstItem() ?? 0 }} to {{ $transactions->lastItem() ?? 0 }}
                        of {{ $transactions->total() }} transactions
                    </div>
                    <div>
                        {{ $transactions->appends(request()->query())->links('pagination::bootstrap-5') }}
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
  <script src="/assets/admin/asset/js/bootstrap.min.js"></script>
  <script src="/assets/admin/asset/js/script.js"></script>

  <!-- Export and Filter JavaScript -->
  <script>
    // Export to Excel
    document.getElementById('exportExcel')?.addEventListener('click', function() {
        const params = new URLSearchParams(window.location.search);
        params.set('export', 'excel');
        window.location.href = '{{ route("admin.invoice") }}?' + params.toString();
    });

    // Date filter toggle for custom range
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
  </script>

  <!-- ================ Sidebar JS =============== -->
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
