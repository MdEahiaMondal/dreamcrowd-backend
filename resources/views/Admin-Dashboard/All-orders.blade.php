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
    <title>Super Admin Dashboard | All Orders</title>
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
    .status-tabs {
      margin-bottom: 20px;
    }
    .status-tabs .btn {
      margin-right: 10px;
      border-radius: 20px;
      margin-bottom: 10px;
    }
    .status-badge {
      padding: 5px 12px;
      border-radius: 5px;
      font-size: 12px;
      font-weight: bold;
    }
    .status-pending { background-color: #ffc107; color: black; }
    .status-active { background-color: #17a2b8; color: white; }
    .status-delivered { background-color: #28a745; color: white; }
    .status-completed { background-color: #007bff; color: white; }
    .status-cancelled { background-color: #dc3545; color: white; }
    .service-type-badge {
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 11px;
      font-weight: 500;
    }
    .filter-section {
      background-color: #f8f9fa;
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 20px;
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
                    <span class="min-title">Payment Management</span>
                    <i class="fa-solid fa-chevron-right"></i>
                    <span class="min-title">All Orders</span>
                  </div>
                </div>
              </div>

              <!-- Blue MASSEGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <i class="bx bx-credit-card-front icon" title="Payment Management"></i>
                      <h2>All Orders Management</h2>
                    </div>
                  </div>
                </div>
              </div>

              <!-- STATISTICS CARDS -->
              <div class="row mb-4">
                  <div class="col-md-3">
                      <div class="stats-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                          <h4>Total Orders</h4>
                          <h2>{{ $stats['total_orders'] ?? 0 }}</h2>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                          <h4>Total Revenue</h4>
                          <h2>${{ number_format($stats['total_revenue'] ?? 0, 2) }}</h2>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                          <h4>Total Commission</h4>
                          <h2>${{ number_format($stats['total_commission'] ?? 0, 2) }}</h2>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="stats-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                          <h4>Completed Orders</h4>
                          <h2>{{ $stats['completed_orders'] ?? 0 }}</h2>
                      </div>
                  </div>
              </div>

              <!-- STATUS FILTER TABS -->
              <div class="status-tabs">
                  <a href="{{ route('admin.all-orders', array_merge(request()->except('status_filter'), ['status_filter' => 'all'])) }}"
                     class="btn {{ ($statusFilter ?? 'all') == 'all' ? 'btn-secondary' : 'btn-outline-secondary' }}">
                      All ({{ $statusCounts['all'] ?? 0 }})
                  </a>
                  <a href="{{ route('admin.all-orders', array_merge(request()->except('status_filter'), ['status_filter' => 'pending'])) }}"
                     class="btn {{ ($statusFilter ?? '') == 'pending' ? 'btn-warning' : 'btn-outline-warning' }}">
                      Pending ({{ $statusCounts['pending'] ?? 0 }})
                  </a>
                  <a href="{{ route('admin.all-orders', array_merge(request()->except('status_filter'), ['status_filter' => 'active'])) }}"
                     class="btn {{ ($statusFilter ?? '') == 'active' ? 'btn-info' : 'btn-outline-info' }}">
                      Active ({{ $statusCounts['active'] ?? 0 }})
                  </a>
                  <a href="{{ route('admin.all-orders', array_merge(request()->except('status_filter'), ['status_filter' => 'delivered'])) }}"
                     class="btn {{ ($statusFilter ?? '') == 'delivered' ? 'btn-success' : 'btn-outline-success' }}">
                      Delivered ({{ $statusCounts['delivered'] ?? 0 }})
                  </a>
                  <a href="{{ route('admin.all-orders', array_merge(request()->except('status_filter'), ['status_filter' => 'completed'])) }}"
                     class="btn {{ ($statusFilter ?? '') == 'completed' ? 'btn-primary' : 'btn-outline-primary' }}">
                      Completed ({{ $statusCounts['completed'] ?? 0 }})
                  </a>
                  <a href="{{ route('admin.all-orders', array_merge(request()->except('status_filter'), ['status_filter' => 'cancelled'])) }}"
                     class="btn {{ ($statusFilter ?? '') == 'cancelled' ? 'btn-danger' : 'btn-outline-danger' }}">
                      Cancelled ({{ $statusCounts['cancelled'] ?? 0 }})
                  </a>
              </div>

              <!-- FILTER SECTION -->
              <div class="filter-section">
                <form method="GET" action="{{ route('admin.all-orders') }}">
                  <input type="hidden" name="status_filter" value="{{ $statusFilter ?? 'all' }}">
                  <div class="row align-items-center">
                    <!-- Date Filter -->
                    <div class="col-md-3">
                      <label class="form-label"><i class="fa-solid fa-calendar-days"></i> Date Range</label>
                      <select class="form-select" name="date_filter" id="dateFilter" onchange="toggleCustomDate()">
                        <option value="lifetime" {{ request('date_filter', 'lifetime') == 'lifetime' ? 'selected' : '' }}>Lifetime</option>
                        <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="yesterday" {{ request('date_filter') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                        <option value="last_week" {{ request('date_filter') == 'last_week' ? 'selected' : '' }}>Last Week</option>
                        <option value="last_7_days" {{ request('date_filter') == 'last_7_days' ? 'selected' : '' }}>Last 7 Days</option>
                        <option value="last_month" {{ request('date_filter') == 'last_month' ? 'selected' : '' }}>Last Month</option>
                        <option value="custom" {{ request('date_filter') == 'custom' ? 'selected' : '' }}>Custom Date</option>
                      </select>
                    </div>

                    <!-- Custom Date Fields -->
                    <div class="col-md-2" id="fromDateField" style="display: {{ request('date_filter') == 'custom' ? 'block' : 'none' }};">
                      <label class="form-label">From</label>
                      <input type="date" class="form-control" name="from_date" value="{{ request('from_date') }}">
                    </div>
                    <div class="col-md-2" id="toDateField" style="display: {{ request('date_filter') == 'custom' ? 'block' : 'none' }};">
                      <label class="form-label">To</label>
                      <input type="date" class="form-control" name="to_date" value="{{ request('to_date') }}">
                    </div>

                    <!-- Service Type Filter -->
                    <div class="col-md-2">
                      <label class="form-label"><i class="fa-solid fa-list"></i> Service Type</label>
                      <select class="form-select" name="service_type_filter">
                        <option value="all" {{ request('service_type_filter', 'all') == 'all' ? 'selected' : '' }}>All Types</option>
                        <option value="0" {{ request('service_type_filter') == '0' ? 'selected' : '' }}>Online Class</option>
                        <option value="1" {{ request('service_type_filter') == '1' ? 'selected' : '' }}>In-Person</option>
                        <option value="2" {{ request('service_type_filter') == '2' ? 'selected' : '' }}>Freelancing</option>
                        <option value="3" {{ request('service_type_filter') == '3' ? 'selected' : '' }}>Tutoring</option>
                      </select>
                    </div>

                    <!-- Search -->
                    <div class="col-md-2">
                      <label class="form-label"><i class="fa-solid fa-magnifying-glass"></i> Search</label>
                      <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Order ID, buyer, seller...">
                    </div>

                    <!-- Submit Button -->
                    <div class="col-md-1">
                      <label class="form-label">&nbsp;</label>
                      <button type="submit" class="btn btn-primary w-100"><i class="fa fa-filter"></i> Filter</button>
                    </div>
                  </div>
                </form>
              </div>

              <!-- ORDERS TABLE -->
              <div class="content w-100 bg-light" id="vt-main-section">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-12 p-0">
                      <div class="row installment-table">
                        <div class="col-md-12 p-0">
                          <div class="table-responsive">
                            <div class="hack1">
                              <div class="hack2">
                                <table class="table">
                                  <thead>
                                    <tr class="text-nowrap">
                                      <th>Order ID</th>
                                      <th>Buyer</th>
                                      <th>Seller</th>
                                      <th>Service Type</th>
                                      <th>Service Title</th>
                                      <th>Amount</th>
                                      <th>Commission</th>
                                      <th>Date</th>
                                      <th>Status</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @forelse($orders as $order)
                                    <tr>
                                      <td><strong>#{{ $order->id }}</strong></td>
                                      <td>
                                        {{ $order->user->name ?? 'N/A' }}<br>
                                        <small class="text-muted">{{ $order->user->email ?? '' }}</small>
                                      </td>
                                      <td>
                                        {{ $order->teacher->name ?? 'N/A' }}<br>
                                        <small class="text-muted">{{ $order->teacher->email ?? '' }}</small>
                                      </td>
                                      <td>
                                        @if($order->gig)
                                          @if($order->gig->service_type == 0)
                                            <span class="service-type-badge bg-primary text-white">Online Class</span>
                                          @elseif($order->gig->service_type == 1)
                                            <span class="service-type-badge bg-success text-white">In-Person</span>
                                          @elseif($order->gig->service_type == 2)
                                            <span class="service-type-badge bg-info text-white">Freelancing</span>
                                          @elseif($order->gig->service_type == 3)
                                            <span class="service-type-badge bg-warning text-dark">Tutoring</span>
                                          @else
                                            <span class="service-type-badge bg-secondary text-white">Other</span>
                                          @endif
                                        @else
                                          N/A
                                        @endif
                                      </td>
                                      <td>{{ Str::limit($order->gig->title ?? 'N/A', 40) }}</td>
                                      <td><strong>${{ number_format($order->finel_price ?? 0, 2) }}</strong></td>
                                      <td>${{ number_format($order->buyer_commission_amount ?? 0, 2) }}</td>
                                      <td>{{ $order->created_at->format('M d, Y') }}<br><small>{{ $order->created_at->format('h:i A') }}</small></td>
                                      <td>
                                        @if($order->status == 0)
                                          <span class="status-badge status-pending">Pending</span>
                                        @elseif($order->status == 1)
                                          <span class="status-badge status-active">Active</span>
                                        @elseif($order->status == 2)
                                          <span class="status-badge status-delivered">Delivered</span>
                                        @elseif($order->status == 3)
                                          <span class="status-badge status-completed">Completed</span>
                                        @elseif($order->status == 4)
                                          <span class="status-badge status-cancelled">Cancelled</span>
                                        @endif
                                        @if($order->refund == 1)
                                          <br><small class="text-danger"><i class="fa fa-undo"></i> Refunded</small>
                                        @endif
                                      </td>
                                      <td>
                                        <a href="{{ route('shared.transaction-details', $order->id) }}"
                                           class="btn btn-sm btn-primary" target="_blank">
                                          <i class="fa fa-eye"></i> View
                                        </a>
                                        @php
                                          $transaction = \App\Models\Transaction::where('order_id', $order->id)->first();
                                        @endphp
                                        @if($transaction)
                                          <a href="{{ route('admin.invoice.download', $transaction->id) }}"
                                             class="btn btn-sm btn-success mt-1">
                                            <i class="fa fa-download"></i> Invoice
                                          </a>
                                        @endif
                                      </td>
                                    </tr>
                                    @empty
                                    <tr>
                                      <td colspan="10" class="text-center py-5">
                                        <i class="fa fa-inbox fa-4x text-muted mb-3"></i>
                                        <p class="text-muted">No orders found matching your criteria.</p>
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
                  </div>
                </div>
              </div>

              <!-- PAGINATION -->
              @if($orders->hasPages())
              <div class="demo">
                <nav class="pagination-outer" aria-label="Page navigation">
                  {{ $orders->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
                </nav>
              </div>
              @endif

              <!-- COPYRIGHT -->
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
          fromDateField.style.display = 'block';
          toDateField.style.display = 'block';
        } else {
          fromDateField.style.display = 'none';
          toDateField.style.display = 'none';
        }
      }
    </script>
  </body>
</html>
