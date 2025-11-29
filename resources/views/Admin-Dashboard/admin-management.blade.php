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
    <title>Admin Management - DreamCrowd</title>
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
                              <span class="min-title">Admin Management</span>
                          </div>
                      </div>
                  </div>

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

                  <!-- Statistics Cards -->
                  <div class="row mb-4">
                      <div class="col-md-3">
                          <div class="card text-center">
                              <div class="card-body">
                                  <h3 class="text-primary">{{ $stats['total_admins'] ?? 0 }}</h3>
                                  <p class="text-muted mb-0">Total Admins</p>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-2">
                          <div class="card text-center">
                              <div class="card-body">
                                  <h5 class="text-danger">{{ $stats['super_admins'] ?? 0 }}</h5>
                                  <p class="text-muted mb-0 small">Super Admins</p>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-2">
                          <div class="card text-center">
                              <div class="card-body">
                                  <h5 class="text-info">{{ $stats['moderators'] ?? 0 }}</h5>
                                  <p class="text-muted mb-0 small">Moderators</p>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-2">
                          <div class="card text-center">
                              <div class="card-body">
                                  <h5 class="text-warning">{{ $stats['support'] ?? 0 }}</h5>
                                  <p class="text-muted mb-0 small">Support</p>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="card text-center">
                              <div class="card-body">
                                  <h5 class="text-secondary">{{ $stats['finance'] ?? 0 }}</h5>
                                  <p class="text-muted mb-0 small">Finance</p>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Filters & Actions -->
                  <div class="card mb-3">
                      <div class="card-body">
                          <form method="GET" action="{{ route('admin.admin-management') }}" class="row g-3">
                              <div class="col-md-3">
                                  <input type="text" class="form-control" name="search" placeholder="Search by name, email, ID..." value="{{ $filters['search'] ?? '' }}">
                              </div>
                              <div class="col-md-2">
                                  <select class="form-select" name="role">
                                      <option value="">All Roles</option>
                                      @foreach($roles as $role)
                                          <option value="{{ $role->name }}" {{ ($filters['role'] ?? '') == $role->name ? 'selected' : '' }}>
                                              {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                          </option>
                                      @endforeach
                                  </select>
                              </div>
                              <div class="col-md-2">
                                  <input type="date" class="form-control" name="date_from" placeholder="From Date" value="{{ $filters['date_from'] ?? '' }}">
                              </div>
                              <div class="col-md-2">
                                  <input type="date" class="form-control" name="date_to" placeholder="To Date" value="{{ $filters['date_to'] ?? '' }}">
                              </div>
                              <div class="col-md-2">
                                  <select class="form-select" name="sort">
                                      <option value="date_desc" {{ ($filters['sort'] ?? 'date_desc') == 'date_desc' ? 'selected' : '' }}>Newest First</option>
                                      <option value="date_asc" {{ ($filters['sort'] ?? '') == 'date_asc' ? 'selected' : '' }}>Oldest First</option>
                                      <option value="name_asc" {{ ($filters['sort'] ?? '') == 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
                                      <option value="name_desc" {{ ($filters['sort'] ?? '') == 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
                                  </select>
                              </div>
                              <div class="col-md-1">
                                  <button type="submit" class="btn btn-primary w-100">Filter</button>
                              </div>
                          </form>
                          <div class="mt-3">
                              <a href="{{ route('admin.admins.create') }}" class="btn btn-success">
                                  <i class="fas fa-plus"></i> Add New Admin
                              </a>
                              <a href="{{ route('admin.admin-management') }}" class="btn btn-secondary">
                                  <i class="fas fa-sync"></i> Reset Filters
                              </a>
                          </div>
                      </div>
                  </div>

                  <!-- Admins Table -->
                  <div class="card">
                      <div class="card-header">
                          <h5>Admin List ({{ $admins->total() }} total)</h5>
                      </div>
                      <div class="card-body">
                          @if($admins->count() > 0)
                              <div class="table-responsive">
                                  <table class="table table-hover">
                                      <thead>
                                          <tr>
                                              <th>ID</th>
                                              <th>Name</th>
                                              <th>Email</th>
                                              <th>Role</th>
                                              <th>Last Login</th>
                                              <th>Joined Date</th>
                                              <th>Actions</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach($admins as $admin)
                                          <tr>
                                              <td>{{ $admin->id }}</td>
                                              <td>
                                                  <div class="d-flex align-items-center">
                                                      @if($admin->profile)
                                                          <img src="/assets/public-site/asset/img/{{ $admin->profile }}" alt="{{ $admin->first_name }}" class="rounded-circle me-2" width="32" height="32">
                                                      @else
                                                          <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2" style="width:32px;height:32px;font-size:14px;">
                                                              {{ substr($admin->first_name, 0, 1) }}
                                                          </div>
                                                      @endif
                                                      <span>{{ $admin->first_name }} {{ $admin->last_name }}</span>
                                                      @if($admin->isTopSuperAdmin())
                                                          <span class="badge bg-danger ms-2">TOP ADMIN</span>
                                                      @endif
                                                  </div>
                                              </td>
                                              <td>{{ $admin->email }}</td>
                                              <td>
                                                  @php
                                                      $role = $admin->roles()->first();
                                                      $roleBadges = [
                                                          'super_admin' => 'danger',
                                                          'moderator' => 'info',
                                                          'support' => 'warning',
                                                          'finance' => 'secondary',
                                                      ];
                                                  @endphp
                                                  @if($role)
                                                      <span class="badge bg-{{ $roleBadges[$role->name] ?? 'secondary' }}">
                                                          {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                                      </span>
                                                  @else
                                                      <span class="badge bg-secondary">No Role</span>
                                                  @endif
                                              </td>
                                              <td>
                                                  @if($admin->last_login_at)
                                                      {{ $admin->last_login_at->diffForHumans() }}
                                                  @else
                                                      Never
                                                  @endif
                                              </td>
                                              <td>{{ $admin->created_at->format('M d, Y') }}</td>
                                              <td>
                                                  <div class="btn-group">
                                                      @if(auth()->user()->canManageAdmin($admin))
                                                          <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                                              <i class="fas fa-edit"></i>
                                                          </a>
                                                          <form action="{{ route('admin.admins.delete', $admin->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this admin?')">
                                                              @csrf
                                                              <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                                  <i class="fas fa-trash"></i>
                                                              </button>
                                                          </form>
                                                      @else
                                                          <span class="badge bg-secondary">No Permission</span>
                                                      @endif
                                                  </div>
                                              </td>
                                          </tr>
                                          @endforeach
                                      </tbody>
                                  </table>
                              </div>

                              <!-- Pagination -->
                              <div class="mt-3">
                                  {{ $admins->appends($filters)->links() }}
                              </div>
                          @else
                              <p class="text-center text-muted py-4">No admins found</p>
                          @endif
                      </div>
                  </div>
              </div>
          </div>
        </div>
       </div>
    </section>

    <script src="/assets/admin/asset/js/bootstrap.min.js"></script>
    <script>
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
</body>
</html>
