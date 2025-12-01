<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/assets/admin/libs/animate/css/animate.css" />
    <link rel="stylesheet" href="/assets/admin/libs/aos/css/aos.css" />
    <link rel="stylesheet" href="/assets/admin/libs/datatable/css/datatable.css" />
    @php  $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="/assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
    @endif
    <link href="/assets/admin/libs/select2/css/select2.min.css" rel="stylesheet" />
    <link href="/assets/admin/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
    <link href="/assets/admin/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/bootstrap.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/style.css">
    <link rel="stylesheet" href="/assets/admin/asset/css/buyer.css">
    <title>Super Admin Dashboard | Buyer Management</title>
</head>
<body>

    <x-admin-sidebar/>

    <section class="home-section">
       <x-admin-nav/>

       <div class="container-fluid">
        <div class="row dash-notification">
          <div class="col-md-12">
              <div class="dash">
                  <div class="row">
                      <div class="col-md-12">
                          <div class="dash-top">
                              <h1 class="dash-title">Dashboard</h1>
                              <i class="fa-solid fa-chevron-right"></i>
                              <span class="min-title">Buyer Management</span>
                          </div>
                      </div>
                  </div>

                  <!-- Success/Error Messages -->
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

                  <!-- Blue MESSAGES section -->
                  <div class="user-notification">
                      <div class="row">
                          <div class="col-md-12">
                              <div class="notify">
                                <i class='bx bx-user icon' title="Buyer Management"></i>
                                  <h2>Buyer Management</h2>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Statistics Cards -->
                  <div class="row mb-4">
                      <div class="col-md-2 col-sm-6 mb-3">
                          <div class="card text-center">
                              <div class="card-body">
                                  <h5 class="card-title">{{ $stats['total'] ?? 0 }}</h5>
                                  <p class="card-text text-muted">Total Buyers</p>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-2 col-sm-6 mb-3">
                          <div class="card text-center">
                              <div class="card-body">
                                  <h5 class="card-title text-success">{{ $stats['active'] ?? 0 }}</h5>
                                  <p class="card-text text-muted">Active</p>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-2 col-sm-6 mb-3">
                          <div class="card text-center">
                              <div class="card-body">
                                  <h5 class="card-title text-warning">{{ $stats['inactive'] ?? 0 }}</h5>
                                  <p class="card-text text-muted">Inactive</p>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-2 col-sm-6 mb-3">
                          <div class="card text-center">
                              <div class="card-body">
                                  <h5 class="card-title text-danger">{{ $stats['banned'] ?? 0 }}</h5>
                                  <p class="card-text text-muted">Banned</p>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-2 col-sm-6 mb-3">
                          <div class="card text-center">
                              <div class="card-body">
                                  <h5 class="card-title text-secondary">{{ $stats['deleted'] ?? 0 }}</h5>
                                  <p class="card-text text-muted">Deleted</p>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Filter and Search Section -->
                  <div class="row mb-4">
                      <div class="col-md-12">
                          <form method="GET" action="{{ route('admin.buyer-management') }}" id="filterForm">
                              <div class="row g-3">
                                  <!-- Status Filter -->
                                  <div class="col-md-2">
                                      <select name="status" class="form-select" onchange="this.form.submit()">
                                          <option value="all" {{ ($status ?? 'all') == 'all' ? 'selected' : '' }}>All Status</option>
                                          <option value="active" {{ ($status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                                          <option value="inactive" {{ ($status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                          <option value="banned" {{ ($status ?? '') == 'banned' ? 'selected' : '' }}>Banned</option>
                                          <option value="deleted" {{ ($status ?? '') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                                      </select>
                                  </div>

                                  <!-- Date Filter -->
                                  <div class="col-md-2">
                                      <select name="date_filter" class="form-select" id="dateFilter" onchange="toggleCustomDates()">
                                          <option value="">All Time</option>
                                          <option value="today" {{ ($dateFilter ?? '') == 'today' ? 'selected' : '' }}>Today</option>
                                          <option value="yesterday" {{ ($dateFilter ?? '') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                                          <option value="last_week" {{ ($dateFilter ?? '') == 'last_week' ? 'selected' : '' }}>Last Week</option>
                                          <option value="last_month" {{ ($dateFilter ?? '') == 'last_month' ? 'selected' : '' }}>Last Month</option>
                                          <option value="custom" {{ ($dateFilter ?? '') == 'custom' ? 'selected' : '' }}>Custom Range</option>
                                      </select>
                                  </div>

                                  <!-- Custom Date Inputs -->
                                  <div class="col-md-2" id="dateFromCol" style="{{ ($dateFilter ?? '') == 'custom' ? '' : 'display:none;' }}">
                                      <input type="date" name="date_from" class="form-control" placeholder="From" value="{{ request('date_from') }}">
                                  </div>
                                  <div class="col-md-2" id="dateToCol" style="{{ ($dateFilter ?? '') == 'custom' ? '' : 'display:none;' }}">
                                      <input type="date" name="date_to" class="form-control" placeholder="To" value="{{ request('date_to') }}">
                                  </div>

                                  <!-- Sort Filter -->
                                  <div class="col-md-2">
                                      <select name="sort" class="form-select" onchange="this.form.submit()">
                                          <option value="date_desc" {{ ($sort ?? 'date_desc') == 'date_desc' ? 'selected' : '' }}>Newest First</option>
                                          <option value="date_asc" {{ ($sort ?? '') == 'date_asc' ? 'selected' : '' }}>Oldest First</option>
                                          <option value="name_asc" {{ ($sort ?? '') == 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
                                          <option value="name_desc" {{ ($sort ?? '') == 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
                                          <option value="spending" {{ ($sort ?? '') == 'spending' ? 'selected' : '' }}>Top Spenders</option>
                                          <option value="orders" {{ ($sort ?? '') == 'orders' ? 'selected' : '' }}>Most Orders</option>
                                      </select>
                                  </div>

                                  <!-- Search Box -->
                                  <div class="col-md-3">
                                      <div class="input-group">
                                          <input type="text" name="search" class="form-control" placeholder="Search by name, email, or ID..." value="{{ $search ?? '' }}">
                                          <button class="btn btn-primary" type="submit">
                                              <i class="fas fa-search"></i>
                                          </button>
                                      </div>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div>

                  <!-- Bulk Actions and Export -->
                  <div class="row mb-3">
                      <div class="col-md-6">
                          <div class="btn-group">
                              <button type="button" class="btn btn-sm btn-danger" onclick="bulkAction('delete')" id="bulkDeleteBtn" disabled>
                                  <i class="fas fa-trash"></i> Delete Selected
                              </button>
                              <button type="button" class="btn btn-sm btn-success" onclick="bulkAction('activate')" id="bulkActivateBtn" disabled>
                                  <i class="fas fa-check"></i> Activate Selected
                              </button>
                              <button type="button" class="btn btn-sm btn-warning" onclick="bulkAction('deactivate')" id="bulkDeactivateBtn" disabled>
                                  <i class="fas fa-ban"></i> Deactivate Selected
                              </button>
                          </div>
                          <span class="ms-2 text-muted" id="selectedCount">0 selected</span>
                      </div>
                      <div class="col-md-6 text-end">
                          <a href="{{ route('admin.buyers.export', request()->all()) }}" class="btn btn-sm btn-info">
                              <i class="fas fa-download"></i> Export to Excel
                          </a>
                      </div>
                  </div>

                  <!-- Buyers Table -->
                  <div class="row">
                      <div class="col-md-12">
                          <div class="table-responsive">
                              <table class="table table-hover">
                                  <thead>
                                      <tr>
                                          <th width="30">
                                              <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                          </th>
                                          <th>ID</th>
                                          <th>Name</th>
                                          <th>Email</th>
                                          <th>Country</th>
                                          <th>Registration Date</th>
                                          <th>Total Orders</th>
                                          <th>Total Spent</th>
                                          <th>Status</th>
                                          <th>Last Active</th>
                                          <th>Actions</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @forelse($buyers as $buyer)
                                      <tr>
                                          <td>
                                              <input type="checkbox" class="buyer-checkbox" value="{{ $buyer->id }}" onchange="updateBulkActions()">
                                          </td>
                                          <td>{{ $buyer->id }}</td>
                                          <td>
                                              <div class="d-flex align-items-center">
                                                  @if($buyer->profile)
                                                      <img src="/assets/public-site/asset/img/{{ $buyer->profile }}" alt="{{ $buyer->first_name }}" class="rounded-circle me-2" width="32" height="32">
                                                  @else
                                                      <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2" style="width:32px;height:32px;">
                                                          {{ substr($buyer->first_name, 0, 1) }}
                                                      </div>
                                                  @endif
                                                  <span>{{ $buyer->first_name }} {{ $buyer->last_name }}</span>
                                              </div>
                                          </td>
                                          <td>{{ $buyer->email }}</td>
                                          <td>{{ $buyer->country ?? 'N/A' }}</td>
                                          <td>{{ $buyer->created_at->format('M d, Y') }}</td>
                                          <td>{{ $buyer->book_orders_count ?? 0 }}</td>
                                          <td>@currency($buyer->total_spent ?? 0)</td>
                                          <td>
                                              @php
                                                  $statusBadge = [
                                                      'active' => 'success',
                                                      'inactive' => 'warning',
                                                      'banned' => 'danger',
                                                      'deleted' => 'secondary'
                                                  ];
                                                  $statusStr = $buyer->status_string ?? 'active';
                                              @endphp
                                              <span class="badge bg-{{ $statusBadge[$statusStr] ?? 'secondary' }}">
                                                  {{ ucfirst($statusStr) }}
                                              </span>
                                          </td>
                                          <td>
                                              @if($buyer->last_active_at)
                                                  {{ $buyer->last_active_at->diffForHumans() }}
                                              @else
                                                  Never
                                              @endif
                                          </td>
                                          <td>
                                              <div class="btn-group btn-group-sm">
                                                  <a href="{{ route('admin.buyers.details', $buyer->id) }}" class="btn btn-info btn-sm" title="View Details">
                                                      <i class="fas fa-eye"></i>
                                                  </a>

                                                  @if($buyer->status == 2)
                                                      <form action="{{ route('admin.buyers.unban', $buyer->id) }}" method="POST" style="display:inline;">
                                                          @csrf
                                                          <button type="submit" class="btn btn-success btn-sm" title="Unban" onclick="return confirm('Are you sure you want to unban this buyer?')">
                                                              <i class="fas fa-check"></i>
                                                          </button>
                                                      </form>
                                                  @else
                                                      <button type="button" class="btn btn-warning btn-sm" onclick="showBanModal({{ $buyer->id }})" title="Ban">
                                                          <i class="fas fa-ban"></i>
                                                      </button>
                                                  @endif

                                                  @if($buyer->deleted_at)
                                                      <form action="{{ route('admin.buyers.restore', $buyer->id) }}" method="POST" style="display:inline;">
                                                          @csrf
                                                          <button type="submit" class="btn btn-primary btn-sm" title="Restore" onclick="return confirm('Are you sure you want to restore this buyer?')">
                                                              <i class="fas fa-undo"></i>
                                                          </button>
                                                      </form>
                                                  @else
                                                      <form action="{{ route('admin.buyers.delete', $buyer->id) }}" method="POST" style="display:inline;">
                                                          @csrf
                                                          <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this buyer?')">
                                                              <i class="fas fa-trash"></i>
                                                          </button>
                                                      </form>
                                                  @endif
                                              </div>
                                          </td>
                                      </tr>
                                      @empty
                                      <tr>
                                          <td colspan="11" class="text-center py-4">
                                              <div class="text-muted">
                                                  <i class="fas fa-inbox fa-3x mb-3"></i>
                                                  <p>No buyers found matching your criteria.</p>
                                              </div>
                                          </td>
                                      </tr>
                                      @endforelse
                                  </tbody>
                              </table>
                          </div>

                          <!-- Pagination -->
                          <div class="d-flex justify-content-between align-items-center mt-3">
                              <div>
                                  Showing {{ $buyers->firstItem() ?? 0 }} to {{ $buyers->lastItem() ?? 0 }} of {{ $buyers->total() }} buyers
                              </div>
                              <div>
                                  {{ $buyers->links() }}
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>
       </div>
    </section>

    <!-- Ban Modal -->
    <div class="modal fade" id="banModal" tabindex="-1" aria-labelledby="banModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="banForm" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="banModalLabel">Ban Buyer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="banReason" class="form-label">Ban Reason <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="banReason" name="reason" rows="3" required placeholder="Please provide a reason for banning this buyer..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Ban Buyer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="/assets/admin/asset/js/bootstrap.min.js"></script>
    <script>
        // Toggle custom date inputs
        function toggleCustomDates() {
            const dateFilter = document.getElementById('dateFilter').value;
            const dateFromCol = document.getElementById('dateFromCol');
            const dateToCol = document.getElementById('dateToCol');

            if (dateFilter === 'custom') {
                dateFromCol.style.display = 'block';
                dateToCol.style.display = 'block';
            } else {
                dateFromCol.style.display = 'none';
                dateToCol.style.display = 'none';
                document.getElementById('filterForm').submit();
            }
        }

        // Ban modal
        function showBanModal(buyerId) {
            const form = document.getElementById('banForm');
            form.action = `/admin/buyers/${buyerId}/ban`;
            const modal = new bootstrap.Modal(document.getElementById('banModal'));
            modal.show();
        }

        // Select all checkboxes
        function toggleSelectAll() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.buyer-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
            updateBulkActions();
        }

        // Update bulk action buttons
        function updateBulkActions() {
            const checkboxes = document.querySelectorAll('.buyer-checkbox:checked');
            const count = checkboxes.length;

            document.getElementById('selectedCount').textContent = `${count} selected`;
            document.getElementById('bulkDeleteBtn').disabled = count === 0;
            document.getElementById('bulkActivateBtn').disabled = count === 0;
            document.getElementById('bulkDeactivateBtn').disabled = count === 0;
        }

        // Bulk actions
        function bulkAction(action) {
            const checkboxes = document.querySelectorAll('.buyer-checkbox:checked');
            const buyerIds = Array.from(checkboxes).map(cb => cb.value);

            if (buyerIds.length === 0) {
                alert('Please select at least one buyer.');
                return;
            }

            if (!confirm(`Are you sure you want to ${action} ${buyerIds.length} buyer(s)?`)) {
                return;
            }

            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.buyers.bulk-action") }}';

            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);

            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = action;
            form.appendChild(actionInput);

            buyerIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'buyer_ids[]';
                input.value = id;
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>
