<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/assets/admin/libs/animate/css/animate.css" />
    <link rel="stylesheet" href="/assets/admin/libs/aos/css/aos.css" />
    @php  $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="/assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
    @endif
    <link href="/assets/admin/libs/select2/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/bootstrap.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/style.css">
    <title>Buyer Details - {{ $buyer->first_name }} {{ $buyer->last_name }}</title>
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
                              <a href="{{ route('admin.buyer-management') }}" class="text-decoration-none">
                                  <span class="min-title">Buyer Management</span>
                              </a>
                              <i class="fa-solid fa-chevron-right"></i>
                              <span class="min-title">Buyer Details</span>
                          </div>
                      </div>
                  </div>

                  <!-- Back Button -->
                  <div class="row mb-3">
                      <div class="col-md-12">
                          <a href="{{ route('admin.buyer-management') }}" class="btn btn-secondary">
                              <i class="fas fa-arrow-left"></i> Back to Buyer Management
                          </a>
                      </div>
                  </div>

                  <!-- Buyer Profile Card -->
                  <div class="row mb-4">
                      <div class="col-md-4">
                          <div class="card">
                              <div class="card-body text-center">
                                  @if($buyer->profile)
                                      <img src="/assets/public-site/asset/img/{{ $buyer->profile }}" alt="{{ $buyer->first_name }}" class="rounded-circle mb-3" width="150" height="150">
                                  @else
                                      <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width:150px;height:150px;font-size:48px;">
                                          {{ substr($buyer->first_name, 0, 1) }}
                                      </div>
                                  @endif
                                  <h4>{{ $buyer->first_name }} {{ $buyer->last_name }}</h4>
                                  <p class="text-muted">{{ $buyer->email }}</p>

                                  @php
                                      $statusBadge = [
                                          'active' => 'success',
                                          'inactive' => 'warning',
                                          'banned' => 'danger',
                                          'deleted' => 'secondary'
                                      ];
                                      $statusStr = $buyer->status_string ?? 'active';
                                  @endphp
                                  <span class="badge bg-{{ $statusBadge[$statusStr] ?? 'secondary' }} mb-3">
                                      {{ ucfirst($statusStr) }}
                                  </span>

                                  <hr>

                                  <div class="text-start">
                                      <p><strong>ID:</strong> {{ $buyer->id }}</p>
                                      <p><strong>Role:</strong>
                                          @if($buyer->role == 0)
                                              Buyer
                                          @elseif($buyer->role == 1)
                                              Seller
                                          @else
                                              Admin
                                          @endif
                                      </p>
                                      <p><strong>Country:</strong> {{ $buyer->country ?? 'N/A' }}</p>
                                      <p><strong>City:</strong> {{ $buyer->city ?? 'N/A' }}</p>
                                      <p><strong>Joined:</strong> {{ $buyer->created_at->format('M d, Y') }}</p>
                                      <p><strong>Last Active:</strong>
                                          @if($buyer->last_active_at)
                                              {{ $buyer->last_active_at->diffForHumans() }}
                                          @else
                                              Never
                                          @endif
                                      </p>

                                      @if($buyer->banned_at)
                                          <hr>
                                          <p class="text-danger"><strong>Banned:</strong> {{ $buyer->banned_at->format('M d, Y H:i') }}</p>
                                          <p><strong>Ban Reason:</strong> {{ $buyer->banned_reason ?? 'N/A' }}</p>
                                      @endif

                                      @if($buyer->deleted_at)
                                          <hr>
                                          <p class="text-secondary"><strong>Deleted:</strong> {{ $buyer->deleted_at->format('M d, Y H:i') }}</p>
                                      @endif
                                  </div>
                              </div>
                          </div>
                      </div>

                      <div class="col-md-8">
                          <!-- Statistics Cards -->
                          <div class="row mb-3">
                              <div class="col-md-4">
                                  <div class="card text-center">
                                      <div class="card-body">
                                          <h3 class="text-primary">{{ $buyer->book_orders_count ?? 0 }}</h3>
                                          <p class="text-muted mb-0">Total Orders</p>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="card text-center">
                                      <div class="card-body">
                                          <h3 class="text-success">@currency($buyer->total_spent ?? 0)</h3>
                                          <p class="text-muted mb-0">Total Spent</p>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="card text-center">
                                      <div class="card-body">
                                          <h3 class="text-info">
                                              @if($buyer->book_orders_count > 0)
                                                  @currency(($buyer->total_spent ?? 0) / $buyer->book_orders_count)
                                              @else
                                                  @currency(0)
                                              @endif
                                          </h3>
                                          <p class="text-muted mb-0">Avg Order Value</p>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <!-- Account Actions -->
                          <div class="card mb-3">
                              <div class="card-header">
                                  <h5>Account Actions</h5>
                              </div>
                              <div class="card-body">
                                  <div class="btn-group">
                                      @if($buyer->status == 2)
                                          <form action="{{ route('admin.buyers.unban', $buyer->id) }}" method="POST" style="display:inline;">
                                              @csrf
                                              <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to unban this buyer?')">
                                                  <i class="fas fa-check"></i> Unban Buyer
                                              </button>
                                          </form>
                                      @else
                                          <button type="button" class="btn btn-warning" onclick="showBanModal({{ $buyer->id }})">
                                              <i class="fas fa-ban"></i> Ban Buyer
                                          </button>
                                      @endif

                                      @if($buyer->deleted_at)
                                          <form action="{{ route('admin.buyers.restore', $buyer->id) }}" method="POST" style="display:inline;">
                                              @csrf
                                              <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to restore this buyer?')">
                                                  <i class="fas fa-undo"></i> Restore Account
                                              </button>
                                          </form>
                                      @else
                                          <form action="{{ route('admin.buyers.delete', $buyer->id) }}" method="POST" style="display:inline;">
                                              @csrf
                                              <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this buyer?')">
                                                  <i class="fas fa-trash"></i> Delete Account
                                              </button>
                                          </form>
                                      @endif
                                  </div>
                              </div>
                          </div>

                          <!-- Recent Orders -->
                          <div class="card">
                              <div class="card-header">
                                  <h5>Recent Orders</h5>
                              </div>
                              <div class="card-body">
                                  @if($buyer->bookOrders && $buyer->bookOrders->count() > 0)
                                      <div class="table-responsive">
                                          <table class="table table-sm">
                                              <thead>
                                                  <tr>
                                                      <th>Order ID</th>
                                                      <th>Service</th>
                                                      <th>Amount</th>
                                                      <th>Status</th>
                                                      <th>Date</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                  @foreach($buyer->bookOrders as $order)
                                                  <tr>
                                                      <td>#{{ $order->id }}</td>
                                                      <td>{{ $order->gig->title ?? 'N/A' }}</td>
                                                      <td>@currency($order->price ?? 0)</td>
                                                      <td>
                                                          @php
                                                              $orderStatusBadge = [
                                                                  0 => 'secondary',
                                                                  1 => 'primary',
                                                                  2 => 'info',
                                                                  3 => 'success',
                                                                  4 => 'danger',
                                                              ];
                                                              $orderStatusText = [
                                                                  0 => 'Pending',
                                                                  1 => 'Active',
                                                                  2 => 'Delivered',
                                                                  3 => 'Completed',
                                                                  4 => 'Cancelled',
                                                              ];
                                                          @endphp
                                                          <span class="badge bg-{{ $orderStatusBadge[$order->status] ?? 'secondary' }}">
                                                              {{ $orderStatusText[$order->status] ?? 'Unknown' }}
                                                          </span>
                                                      </td>
                                                      <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                  </tr>
                                                  @endforeach
                                              </tbody>
                                          </table>
                                      </div>
                                  @else
                                      <p class="text-muted text-center py-3">No orders yet</p>
                                  @endif
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Recent Activities -->
                  <div class="row">
                      <div class="col-md-12">
                          <div class="card">
                              <div class="card-header">
                                  <h5>Recent Activities</h5>
                              </div>
                              <div class="card-body">
                                  @if($recentActivities && $recentActivities->count() > 0)
                                      <div class="table-responsive">
                                          <table class="table table-sm">
                                              <thead>
                                                  <tr>
                                                      <th>Activity</th>
                                                      <th>Description</th>
                                                      <th>IP Address</th>
                                                      <th>Date</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                  @foreach($recentActivities as $activity)
                                                  <tr>
                                                      <td>
                                                          <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $activity->activity_type)) }}</span>
                                                      </td>
                                                      <td>{{ $activity->activity_description ?? 'N/A' }}</td>
                                                      <td>{{ $activity->ip_address ?? 'N/A' }}</td>
                                                      <td>{{ $activity->created_at->format('M d, Y H:i') }}</td>
                                                  </tr>
                                                  @endforeach
                                              </tbody>
                                          </table>
                                      </div>
                                  @else
                                      <p class="text-muted text-center py-3">No activities recorded yet</p>
                                  @endif
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
        // Ban modal
        function showBanModal(buyerId) {
            const form = document.getElementById('banForm');
            form.action = `/admin/buyers/${buyerId}/ban`;
            const modal = new bootstrap.Modal(document.getElementById('banModal'));
            modal.show();
        }
    </script>
</body>
</html>
