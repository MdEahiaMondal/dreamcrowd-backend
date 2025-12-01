<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
    <!-- Owl carousel css -->
    <link href="/assets/admin/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
    <link href="/assets/admin/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/bootstrap.min.css" />
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />
    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <!-- Default css -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/style.css" />
    <link rel="stylesheet" href="/assets/user/asset/css/style.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/sallermangement.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/seller-table.css" />
    <title>Super Admin Dashboard | Payout Management</title>
  </head>
  <style>
    .button {
      color: #0072b1 !important;
    }
    .stats-card {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 20px;
    }
    .stats-card h4 {
      color: white;
      font-size: 14px;
      margin-bottom: 10px;
    }
    .stats-card h2 {
      color: white;
      font-size: 28px;
      font-weight: bold;
    }
    .view-tabs {
      margin-bottom: 20px;
    }
    .view-tabs .btn {
      margin-right: 10px;
      border-radius: 20px;
    }
    .payout-status-badge {
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 12px;
      font-weight: bold;
    }
    .payout-pending { background-color: #ffc107; color: black; }
    .payout-approved { background-color: #17a2b8; color: white; }
    .payout-completed { background-color: #28a745; color: white; }
    .payout-failed { background-color: #dc3545; color: white; }
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
                    <span class="min-title">Payment Management</span>
                    <i class="fa-solid fa-chevron-right"></i>
                    <span class="min-title">Payout</span>
                  </div>
                </div>
              </div>

              <!-- SUCCESS/ERROR MESSAGES -->
              @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ session('success') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              @endif

              @if(session('error'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  {{ session('error') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              @endif

              <!-- Blue MASSEGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <i class="bx bx-credit-card-front icon" title="Payment Management"></i>
                      <h2>Payout Management</h2>
                    </div>
                  </div>
                </div>
              </div>

              <!-- STATISTICS CARDS -->
              <div class="row mb-4">
                  <div class="col-md-3">
                      <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                          <h4>Pending Payouts</h4>
                          <h2>{{ $stats['pending_count'] ?? 0 }}</h2>
                          <small>@currency($stats['pending_amount'] ?? 0)</small>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                          <h4>Approved Payouts</h4>
                          <h2>{{ $stats['approved_count'] ?? 0 }}</h2>
                          <small>@currency($stats['approved_amount'] ?? 0)</small>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="stats-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                          <h4>Completed Payouts</h4>
                          <h2>{{ $stats['completed_count'] ?? 0 }}</h2>
                          <small>@currency($stats['completed_amount'] ?? 0)</small>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="stats-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                          <h4>Failed Payouts</h4>
                          <h2>{{ $stats['failed_count'] ?? 0 }}</h2>
                          <small>@currency($stats['failed_amount'] ?? 0)</small>
                      </div>
                  </div>
              </div>

              <!-- VIEW TABS -->
              <div class="view-tabs">
                  <a href="{{ route('admin.payout-details', ['view' => 'pending']) }}"
                     class="btn {{ $view == 'pending' ? 'btn-warning' : 'btn-outline-warning' }}">
                      Pending ({{ $stats['pending_count'] ?? 0 }})
                  </a>
                  <a href="{{ route('admin.payout-details', ['view' => 'approved']) }}"
                     class="btn {{ $view == 'approved' ? 'btn-info' : 'btn-outline-info' }}">
                      Approved ({{ $stats['approved_count'] ?? 0 }})
                  </a>
                  <a href="{{ route('admin.payout-details', ['view' => 'completed']) }}"
                     class="btn {{ $view == 'completed' ? 'btn-success' : 'btn-outline-success' }}">
                      Completed ({{ $stats['completed_count'] ?? 0 }})
                  </a>
                  <a href="{{ route('admin.payout-details', ['view' => 'failed']) }}"
                     class="btn {{ $view == 'failed' ? 'btn-danger' : 'btn-outline-danger' }}">
                      Failed ({{ $stats['failed_count'] ?? 0 }})
                  </a>
                  <a href="{{ route('admin.payout-details', ['view' => 'all']) }}"
                     class="btn {{ $view == 'all' ? 'btn-secondary' : 'btn-outline-secondary' }}">
                      All Payouts
                  </a>
              </div>

              <!-- Filter Date Section start from here -->
              <div class="date-section">
                <div class="row">
                  <div class="col-md-8">
                    <form method="GET" action="{{ route('admin.payout-details') }}">
                      <input type="hidden" name="view" value="{{ $view }}">
                      <div class="row align-items-center calendar-sec">
                        <div class="col-auto date-selection">
                          <div class="date-sec">
                            <i class="fa-solid fa-calendar-days"></i>
                            <select class="form-select" name="date_filter" id="dateFilter" onchange="toggleCustomDate()">
                              <option value="lifetime" {{ request('date_filter', 'lifetime') == 'lifetime' ? 'selected' : '' }}>Lifetime</option>
                              <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                              <option value="yesterday" {{ request('date_filter') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                              <option value="last_week" {{ request('date_filter') == 'last_week' ? 'selected' : '' }}>Last Week</option>
                              <option value="last_7_days" {{ request('date_filter') == 'last_7_days' ? 'selected' : '' }}>Last 7 days</option>
                              <option value="last_month" {{ request('date_filter') == 'last_month' ? 'selected' : '' }}>Last Month</option>
                              <option value="custom" {{ request('date_filter') == 'custom' ? 'selected' : '' }}>Custom Date</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-auto" id="fromDateField" style="display: {{ request('date_filter') == 'custom' ? 'inline' : 'none' }};">
                          <div class="row">
                            <label for="fromDate" class="col-sm-3 col-form-label">From:</label>
                            <div class="col-sm-9">
                              <input type="date" class="form-control" id="fromDate" name="from_date" value="{{ request('from_date') }}">
                            </div>
                          </div>
                        </div>
                        <div class="col-auto" id="toDateField" style="display: {{ request('date_filter') == 'custom' ? 'inline' : 'none' }};">
                          <div class="row">
                            <label for="toDate" class="col-sm-2 col-form-label">To:</label>
                            <div class="col-sm-10">
                              <input type="date" class="form-control" id="toDate" name="to_date" value="{{ request('to_date') }}">
                            </div>
                          </div>
                        </div>
                        <div class="col-auto">
                          <button type="submit" class="btn btn-primary">Apply Filter</button>
                        </div>
                        <div class="col-auto">
                          <a href="{{ route('admin.export.payouts', array_merge(request()->all(), ['view' => $view])) }}" class="btn btn-success">
                            <i class="fa fa-download"></i> Export Excel
                          </a>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="col-md-4 search-form-sec">
                    <form method="GET" action="{{ route('admin.payout-details') }}">
                      <input type="hidden" name="view" value="{{ $view }}">
                      <input type="text" name="search" class="border-0" placeholder="Search by transaction ID, seller..." value="{{ request('search') }}">
                      <button type="submit" style="display: none;"></button>
                    </form>
                  </div>
                </div>
              </div>
              <!--Filter Date section ended here -->

              <div class="content w-100 bg-light" id="vt-main-section">
                <div class="container-fluid" id="installment-contant">
                  <div class="row" id="main-contant-AI">
                    <div class="col-md-12 p-0">
                      <!-- BEGIN: PAYOUT TABLE SECTION -->
                      <div class="row installment-table">
                        <div class="col-md-12 p-0">
                          <div class="table-responsive">
                            <div class="hack1">
                              <div class="hack2">
                                <table class="table">
                                  <thead>
                                    <tr class="text-nowrap">
                                      <th>Transaction ID</th>
                                      <th>Seller</th>
                                      <th>Buyer</th>
                                      <th>Order Amount</th>
                                      <th>Commission</th>
                                      <th>Seller Earnings</th>
                                      <th>Date</th>
                                      <th>Status</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @forelse($payouts as $payout)
                                    <tr>
                                      <td><strong>#{{ $payout->id }}</strong></td>
                                      <td>
                                        {{ ($payout->seller->first_name ?? '') . ' ' . ($payout->seller->last_name ?? '') ?: 'N/A' }}<br>
                                        <small class="text-muted">{{ $payout->seller->email ?? '' }}</small>
                                      </td>
                                      <td>
                                        {{ ($payout->buyer->first_name ?? '') . ' ' . ($payout->buyer->last_name ?? '') ?: 'N/A' }}<br>
                                        <small class="text-muted">{{ $payout->buyer->email ?? '' }}</small>
                                      </td>
                                      <td><strong>@currency($payout->total_amount ?? 0)</strong></td>
                                      <td>
                                        Seller: @currency($payout->seller_commission_amount ?? 0)<br>
                                        <small>Buyer: @currency($payout->buyer_commission_amount ?? 0)</small>
                                      </td>
                                      <td>
                                        <strong class="text-success">@currency($payout->seller_earnings ?? 0)</strong>
                                      </td>
                                      <td>
                                        {{ $payout->created_at->format('M d, Y') }}<br>
                                        <small>{{ $payout->created_at->format('h:i A') }}</small>
                                      </td>
                                      <td>
                                        @if($payout->payout_status == 'pending')
                                          <span class="payout-status-badge payout-pending">Pending</span>
                                        @elseif($payout->payout_status == 'approved')
                                          <span class="payout-status-badge payout-approved">Approved</span>
                                        @elseif($payout->payout_status == 'completed')
                                          <span class="payout-status-badge payout-completed">Completed</span>
                                          @if($payout->payout_at)
                                            <br><small class="text-muted">{{ \Carbon\Carbon::parse($payout->payout_at)->format('M d, Y') }}</small>
                                          @endif
                                        @elseif($payout->payout_status == 'failed')
                                          <span class="payout-status-badge payout-failed">Failed</span>
                                        @endif
                                      </td>
                                      <td>
                                        @if($payout->payout_status == 'pending' || $payout->payout_status == 'approved')
                                          <form method="POST" action="{{ route('admin.payout.process', $payout->id) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to mark this payout as completed?')">
                                              <i class="fa fa-check"></i> Mark Paid
                                            </button>
                                          </form>
                                        @elseif($payout->payout_status == 'completed')
                                          <span class="badge bg-success"><i class="fa fa-check"></i> Paid</span>
                                        @elseif($payout->payout_status == 'failed')
                                          <span class="badge bg-danger"><i class="fa fa-times"></i> Failed</span>
                                        @endif
                                        <a href="{{ route('admin.transaction.details', $payout->id) }}"
                                           class="btn btn-sm btn-primary mt-1" target="_blank">
                                          <i class="fa fa-eye"></i> View
                                        </a>
                                        <a href="{{ route('admin.invoice.download', $payout->id) }}"
                                           class="btn btn-sm btn-info mt-1">
                                          <i class="fa fa-download"></i> Invoice
                                        </a>
                                      </td>
                                    </tr>
                                    @empty
                                    <tr>
                                      <td colspan="9" class="text-center py-4">
                                        <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No payouts found for this view.</p>
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
                      <!-- END: PAYOUT TABLE SECTION -->
                    </div>
                  </div>
                </div>
              </div>
              <!-- end -->

              <!-- pagination start from here -->
              @if($payouts->hasPages())
              <div class="demo">
                <nav class="pagination-outer" aria-label="Page navigation">
                  {{ $payouts->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
                </nav>
              </div>
              @endif
              <!-- pagination ended here -->

              <!-- copyright section start from here -->
              <div class="copyright">
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
    <script src="/assets/admin/libs/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="/assets/admin/libs/aos/js/aos.js"></script>
    <script src="/assets/admin/asset/js/bootstrap.min.js"></script>
    <script src="/assets/admin/asset/js/script.js"></script>

    <script>
      function toggleCustomDate() {
        const dateFilter = document.getElementById('dateFilter').value;
        const fromDateField = document.getElementById('fromDateField');
        const toDateField = document.getElementById('toDateField');

        if (dateFilter === 'custom') {
          fromDateField.style.display = 'inline';
          toDateField.style.display = 'inline';
        } else {
          fromDateField.style.display = 'none';
          toDateField.style.display = 'none';
        }
      }

      // Auto-dismiss alerts after 5 seconds
      setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
          var bsAlert = new bootstrap.Alert(alert);
          bsAlert.close();
        });
      }, 5000);
    </script>
  </body>
</html>
