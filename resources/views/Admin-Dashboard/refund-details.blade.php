<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <!-- View Point scale to 1.0 -->
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
    <link
      rel="stylesheet"
      type="text/css"
      href="/assets/admin/asset/css/bootstrap.min.css"
    />
    <link
      href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
    />
    <!-- Fontawesome CDN -->
    <script
      src="https://kit.fontawesome.com/be69b59144.js"
      crossorigin="anonymous"
    ></script>
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/style.css" />
    <link rel="stylesheet" href="/assets/user/asset/css/style.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/sallermangement.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/seller-table.css" />
    <title>Super Admin Dashboard | Refund Management</title>
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
    .refund-type-badge {
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 12px;
      font-weight: bold;
    }
    .refund-type-full {
      background-color: #dc3545;
      color: white;
    }
    .refund-type-partial {
      background-color: #ffc107;
      color: black;
    }
    .modal-body .info-row {
      margin-bottom: 15px;
      padding: 10px;
      background-color: #f8f9fa;
      border-radius: 5px;
    }
    .modal-body .info-row strong {
      display: inline-block;
      width: 150px;
    }
    .modal-footer form {
      display: inline-block;
      margin: 0 5px;
    }
    .modal-content{
      width: 100% !important;
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
                    <span class="min-title">Refund</span>
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
                      <i
                        class="bx bx-credit-card-front icon"
                        title="Payment Management"
                      ></i>
                      <h2>Refund Management</h2>
                    </div>
                  </div>
                </div>
              </div>

              <!-- STATISTICS CARDS -->
              <div class="row mb-4">
                  <div class="col-md-3">
                      <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                          <h4>Pending Disputes</h4>
                          <h2>{{ $stats['pending_disputes'] ?? 0 }}</h2>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                          <h4>Total Refunded</h4>
                          <h2>{{ $stats['refunded'] ?? 0 }}</h2>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="stats-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                          <h4>Total Refunded Amount</h4>
                          <h2>@currency($stats['total_refunded_amount'] ?? 0)</h2>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="stats-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                          <h4>Pending Refund Amount</h4>
                          <h2>@currency($stats['pending_refund_amount'] ?? 0)</h2>
                      </div>
                  </div>
              </div>

              <!-- VIEW TABS -->
              <div class="view-tabs d-flex justify-content-between align-items-center">
                  <div>
                      <a href="{{ route('admin.refund-details', ['view' => 'pending_disputes']) }}"
                         class="btn {{ $view == 'pending_disputes' ? 'btn-primary' : 'btn-outline-primary' }}">
                          Pending Disputes ({{ $stats['pending_disputes'] ?? 0 }})
                      </a>
                      <a href="{{ route('admin.refund-details', ['view' => 'refunded']) }}"
                         class="btn {{ $view == 'refunded' ? 'btn-success' : 'btn-outline-success' }}">
                          Refunded ({{ $stats['refunded'] ?? 0 }})
                      </a>
                      <a href="{{ route('admin.refund-details', ['view' => 'rejected']) }}"
                         class="btn {{ $view == 'rejected' ? 'btn-danger' : 'btn-outline-danger' }}">
                          Rejected
                      </a>
                      <a href="{{ route('admin.refund-details', ['view' => 'all']) }}"
                         class="btn {{ $view == 'all' ? 'btn-secondary' : 'btn-outline-secondary' }}">
                          All Disputes
                      </a>
                  </div>
                  <div>
                      <a href="{{ route('admin.export.refunds', ['view' => $view]) }}" class="btn btn-success">
                          <i class="fa fa-download"></i> Export Excel
                      </a>
                  </div>
              </div>

              <!-- Filter Date Section start from here -->
              <div class="date-section">
                <div class="row">
                  <div class="col-md-8">
                    <form method="GET" action="{{ route('admin.refund-details') }}">
                      <input type="hidden" name="view" value="{{ $view }}">
                      <div class="row align-items-center calendar-sec">
                        <div class="col-auto date-selection">
                          <div class="date-sec">
                            <i class="fa-solid fa-calendar-days"></i>
                            <select class="form-select" name="date_filter" id="dateFilter" onchange="this.form.submit()">
                              <option value="today">Today</option>
                              <option value="yesterday">Yesterday</option>
                              <option value="last_week">Last Week</option>
                              <option value="last_7_days">Last 7 days</option>
                              <option value="lifetime" selected>Lifetime</option>
                              <option value="last_month">Last Month</option>
                              <option value="custom">Customise Date</option>
                            </select>
                          </div>
                        </div>
                        <div
                          class="col-auto"
                          id="fromDateFields"
                          style="display: none"
                        >
                          <div class="row">
                            <label
                              for="fromDate"
                              class="col-sm-3 col-form-label"
                              >From:</label
                            >
                            <div class="col-sm-9">
                              <input
                                type="date"
                                class="form-control"
                                id="fromDate"
                                name="from_date"
                              />
                            </div>
                          </div>
                        </div>
                        <div
                          class="col-auto"
                          id="toDateFields"
                          style="display: none"
                        >
                          <div class="row">
                            <label
                              for="toDate"
                              class="col-sm-2 col-form-label"
                              >To:</label
                            >
                            <div class="col-sm-10">
                              <input
                                type="date"
                                class="form-control"
                                id="toDate"
                                name="to_date"
                              />
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="col-md-4 search-form-sec">
                    <form method="GET" action="{{ route('admin.refund-details') }}">
                      <input type="hidden" name="view" value="{{ $view }}">
                      <input
                        type="text"
                        name="search"
                        class="border-0"
                        placeholder="Search by order ID, buyer, seller..."
                        value="{{ request('search') }}"
                      />
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
                      <!-- BEGIN: REFUND TABLE SECTION -->
                      <div class="row installment-table">
                        <div class="col-md-12 p-0">
                          <div class="table-responsive">
                            <div class="hack1">
                              <div class="hack2">
                                <table class="table">
                                  <thead>
                                    <tr class="text-nowrap">
                                      <th class="h-1">Order ID</th>
                                      <th class="h-1">Seller</th>
                                      <th class="h-4 service-type">Buyer</th>
                                      <th class="h-8 service-types">Service Type</th>
                                      <th class="h-12 service-descrip">Service Description</th>
                                      <th class="h-12 service-title">Refund Amount</th>
                                      <th class="h-12">Refund Type</th>
                                      <th class="h-12">48h Timer</th>
                                      <th class="h-12">Payment Method</th>
                                      <th class="h-12 stats">Status</th>
                                      <th class="h-12 action">Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @forelse($disputes as $dispute)
                                    <tr>
                                      <td>
                                        <strong>#{{ $dispute->order->id ?? 'N/A' }}</strong>
                                      </td>
                                      <td>
                                        <div class="d-flex gap-2">
                                          <span>{{ ($dispute->order->teacher->first_name ?? '') . ' ' . ($dispute->order->teacher->last_name ?? '') ?: 'N/A' }}</span>
                                        </div>
                                      </td>
                                      <td class="online-class">
                                        {{ ($dispute->order->user->first_name ?? '') . ' ' . ($dispute->order->user->last_name ?? '') ?: 'N/A' }}
                                      </td>
                                      <td class="online-desc">
                                        @if($dispute->order->gig)
                                          @if($dispute->order->gig->service_type == 0)
                                            Online Class
                                          @elseif($dispute->order->gig->service_type == 1)
                                            In-Person
                                          @elseif($dispute->order->gig->service_type == 2)
                                            Freelancing
                                          @elseif($dispute->order->gig->service_type == 3)
                                            Tutoring
                                          @else
                                            Other
                                          @endif
                                        @else
                                          N/A
                                        @endif
                                      </td>
                                      <td class="service-descr">
                                        {{ Str::limit($dispute->order->gig->title ?? 'N/A', 50) }}
                                      </td>
                                      <td class="service-decs">
                                        <strong>@currency($dispute->amount ?? 0)</strong>
                                      </td>
                                      <td>
                                        @if($dispute->refund_type == 0)
                                          <span class="refund-type-badge refund-type-full">Full Refund</span>
                                        @else
                                          <span class="refund-type-badge refund-type-partial">Partial Refund</span>
                                        @endif
                                      </td>
                                      <td>
                                        @if($dispute->status == 0)
                                          <span class="{{ $dispute->countdown_color }}" style="font-weight: bold;">
                                            <i class="fa fa-clock"></i> {{ $dispute->countdown_text }}
                                          </span>
                                        @else
                                          <span class="text-muted">-</span>
                                        @endif
                                      </td>
                                      <td class="refund-date">
                                        Stripe
                                      </td>
                                      <td class="status">
                                        <h5>
                                          @if($dispute->status == 0)
                                            <span class="badge bg-warning text-dark">Pending</span>
                                          @elseif($dispute->status == 1)
                                            <span class="badge bg-success">Refunded</span>
                                          @elseif($dispute->status == 2)
                                            <span class="badge bg-danger">Rejected</span>
                                          @endif
                                        </h5>
                                      </td>
                                      <td>
                                        <div class="expert-dropdown">
                                          <button
                                            class="btn btn-sm btn-primary"
                                            type="button"
                                            data-bs-toggle="modal"
                                            data-bs-target="#reviewModal{{ $dispute->id }}"
                                          >
                                            Review
                                          </button>
                                        </div>
                                      </td>
                                    </tr>

                                    <!-- REVIEW MODAL FOR EACH DISPUTE -->
                                    <div class="modal fade" id="reviewModal{{ $dispute->id }}" tabindex="-1" aria-labelledby="reviewModalLabel{{ $dispute->id }}" aria-hidden="true">
                                      <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="reviewModalLabel{{ $dispute->id }}">
                                              Dispute Review - Order #{{ $dispute->order->id }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body">
                                            <div class="info-row">
                                              <strong>Order ID:</strong> #{{ $dispute->order->id }}
                                            </div>
                                            <div class="info-row">
                                              <strong>Buyer:</strong> {{ ($dispute->order->user->first_name ?? '') . ' ' . ($dispute->order->user->last_name ?? '') ?: 'N/A' }} ({{ $dispute->order->user->email ?? 'N/A' }})
                                            </div>
                                            <div class="info-row">
                                              <strong>Seller:</strong> {{ ($dispute->order->teacher->first_name ?? '') . ' ' . ($dispute->order->teacher->last_name ?? '') ?: 'N/A' }} ({{ $dispute->order->teacher->email ?? 'N/A' }})
                                            </div>
                                            <div class="info-row">
                                              <strong>Service:</strong> {{ $dispute->order->gig->title ?? 'N/A' }}
                                            </div>
                                            <div class="info-row">
                                              <strong>Order Amount:</strong> @currency($dispute->order->finel_price ?? 0)
                                            </div>
                                            <div class="info-row">
                                              <strong>Refund Amount:</strong> @currency($dispute->amount ?? 0)
                                            </div>
                                            <div class="info-row">
                                              <strong>Refund Type:</strong>
                                              @if($dispute->refund_type == 0)
                                                <span class="refund-type-badge refund-type-full">Full Refund</span>
                                              @else
                                                <span class="refund-type-badge refund-type-partial">Partial Refund</span>
                                              @endif
                                            </div>
                                            <div class="info-row">
                                              <strong>Payment Method:</strong> Stripe (Payment ID: {{ $dispute->order->payment_id ?? 'N/A' }})
                                            </div>
                                            <hr>
                                            <div class="info-row">
                                              <strong>Buyer Dispute:</strong>
                                              @if($dispute->order->user_dispute == 1)
                                                <span class="badge bg-danger">Yes</span>
                                              @else
                                                <span class="badge bg-secondary">No</span>
                                              @endif
                                            </div>
                                            @if($dispute->order->user_dispute == 1 && $dispute->user_reason)
                                            <div class="info-row">
                                              <strong>Buyer Reason:</strong><br>
                                              <p class="mt-2">{{ $dispute->user_reason }}</p>
                                            </div>
                                            @endif
                                            <div class="info-row">
                                              <strong>Seller Dispute:</strong>
                                              @if($dispute->order->teacher_dispute == 1)
                                                <span class="badge bg-danger">Yes</span>
                                              @else
                                                <span class="badge bg-secondary">No</span>
                                              @endif
                                            </div>
                                            @if($dispute->order->teacher_dispute == 1 && $dispute->teacher_reason)
                                            <div class="info-row">
                                              <strong>Seller Reason:</strong><br>
                                              <p class="mt-2">{{ $dispute->teacher_reason }}</p>
                                            </div>
                                            @endif
                                            @if($dispute->admin_notes)
                                            <div class="info-row">
                                              <strong>Admin Notes:</strong><br>
                                              <p class="mt-2">{{ $dispute->admin_notes }}</p>
                                            </div>
                                            @endif
                                            <div class="info-row">
                                              <strong>Created At:</strong> {{ $dispute->created_at->format('F d, Y h:i A') }}
                                            </div>
                                          </div>
                                          <div class="modal-footer">
                                            @if($dispute->status == 0)
                                              <!-- APPROVE REFUND FORM -->
                                              <form method="POST" action="{{ route('admin.refund.approve', $dispute->id) }}" style="display: inline;">
                                                @csrf
                                                @if($dispute->refund_type == 1)
                                                  <input type="hidden" name="refund_amount" value="{{ $dispute->amount }}">
                                                @endif
                                                <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to approve this refund? This will process a Stripe refund.')">
                                                  <i class="fa fa-check"></i> Approve Refund
                                                </button>
                                              </form>

                                              <!-- REJECT REFUND FORM -->
                                              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $dispute->id }}">
                                                <i class="fa fa-times"></i> Reject Refund
                                              </button>
                                            @else
                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            @endif
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    <!-- REJECT MODAL -->
                                    <div class="modal fade" id="rejectModal{{ $dispute->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $dispute->id }}" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="rejectModalLabel{{ $dispute->id }}">Reject Refund Request</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <form method="POST" action="{{ route('admin.refund.reject', $dispute->id) }}">
                                            @csrf
                                            <div class="modal-body">
                                              <div class="mb-3">
                                                <label for="reject_reason{{ $dispute->id }}" class="form-label">Rejection Reason *</label>
                                                <textarea class="form-control" id="reject_reason{{ $dispute->id }}" name="reject_reason" rows="4" required placeholder="Please provide a reason for rejecting this refund request..."></textarea>
                                              </div>
                                              <p class="text-danger"><strong>Note:</strong> Rejecting this refund will release the payment to the seller.</p>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                              <button type="submit" class="btn btn-danger">Reject Refund</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>

                                    @empty
                                    <tr>
                                      <td colspan="10" class="text-center py-4">
                                        <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No disputes found for this view.</p>
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
                      <!-- END: REFUND TABLE SECTION -->
                    </div>
                  </div>
                </div>
              </div>
              <!-- end -->

              <!-- pagination start from here -->
              @if($disputes->hasPages())
              <div class="demo">
                <nav class="pagination-outer" aria-label="Page navigation">
                  {{ $disputes->links('pagination::bootstrap-4') }}
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
  </body>
</html>
<!-- Date Picker JS -->
<script>
  const dateFilter = document.getElementById("dateFilter");
  const fromDateFields = document.getElementById("fromDateFields");
  const toDateFields = document.getElementById("toDateFields");

  dateFilter.addEventListener("change", function () {
    if (dateFilter.value === "custom") {
      fromDateFields.style.display = "inline";
      toDateFields.style.display = "inline";
    } else {
      fromDateFields.style.display = "none";
      toDateFields.style.display = "none";
    }
  });

  // Auto-dismiss alerts after 5 seconds
  setTimeout(function() {
    var alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
      var bsAlert = new bootstrap.Alert(alert);
      bsAlert.close();
    });
  }, 5000);
</script>
