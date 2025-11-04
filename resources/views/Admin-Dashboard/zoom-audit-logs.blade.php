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
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />
    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <!-- Default css -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/style.css" />
    <link rel="stylesheet" href="/assets/user/asset/css/style.css" />
    <title>Super Admin Dashboard | Zoom Audit Logs</title>
    <style>
      .filter-section {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
      }

      .action-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
      }

      .action-settings_updated { background: #e3f2fd; color: #1976d2; }
      .action-oauth_connected { background: #e8f5e9; color: #388e3c; }
      .action-oauth_disconnected { background: #ffebee; color: #d32f2f; }
      .action-meeting_created { background: #f3e5f5; color: #7b1fa2; }
      .action-meeting_started { background: #e8f5e9; color: #388e3c; }
      .action-meeting_ended { background: #f5f5f5; color: #616161; }
      .action-token_generated { background: #fff3e0; color: #f57f17; }
      .action-join_attempt_success { background: #e8f5e9; color: #388e3c; }
      .action-join_attempt_invalid_token { background: #ffebee; color: #d32f2f; }

      .metadata-toggle {
        cursor: pointer;
        color: #1976d2;
        text-decoration: underline;
      }

      .metadata-content {
        display: none;
        background: #f9f9f9;
        padding: 10px;
        border-radius: 4px;
        margin-top: 10px;
        font-family: monospace;
        font-size: 0.85rem;
        white-space: pre-wrap;
        word-break: break-all;
      }

      .metadata-content.show {
        display: block;
      }

      .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 30px;
      }

      .stat-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
      }

      .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #1976d2;
      }

      .stat-label {
        font-size: 0.9rem;
        color: #666;
        margin-top: 5px;
      }

      .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
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
                    <span class="min-title">Zoom Audit Logs</span>
                  </div>
                </div>
              </div>

              <!-- Blue MESSAGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <i class="bx bx-history"></i>
                      <h2>Zoom Activity Audit Logs</h2>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Stats Section -->
              <div class="stats-grid">
                <div class="stat-card">
                  <div class="stat-value">{{ $totalLogs }}</div>
                  <div class="stat-label">Total Logs</div>
                </div>
                <div class="stat-card">
                  <div class="stat-value">{{ $todayLogs }}</div>
                  <div class="stat-label">Today's Activity</div>
                </div>
                <div class="stat-card">
                  <div class="stat-value">{{ $uniqueUsers }}</div>
                  <div class="stat-label">Unique Users</div>
                </div>
                <div class="stat-card">
                  <div class="stat-value">{{ $recentActions }}</div>
                  <div class="stat-label">Last Hour</div>
                </div>
              </div>

              <!-- Filter Section -->
              <div class="filter-section">
                <form method="GET" action="{{ route('admin.zoom.audit') }}">
                  <div class="row g-3">
                    <div class="col-md-3">
                      <label class="form-label">Action Type</label>
                      <select name="action" class="form-select">
                        <option value="">All Actions</option>
                        <option value="settings_updated" {{ request('action') == 'settings_updated' ? 'selected' : '' }}>Settings Updated</option>
                        <option value="oauth_connected" {{ request('action') == 'oauth_connected' ? 'selected' : '' }}>OAuth Connected</option>
                        <option value="oauth_disconnected" {{ request('action') == 'oauth_disconnected' ? 'selected' : '' }}>OAuth Disconnected</option>
                        <option value="meeting_created" {{ request('action') == 'meeting_created' ? 'selected' : '' }}>Meeting Created</option>
                        <option value="meeting_started" {{ request('action') == 'meeting_started' ? 'selected' : '' }}>Meeting Started</option>
                        <option value="meeting_ended" {{ request('action') == 'meeting_ended' ? 'selected' : '' }}>Meeting Ended</option>
                        <option value="token_generated" {{ request('action') == 'token_generated' ? 'selected' : '' }}>Token Generated</option>
                        <option value="join_attempt_success" {{ request('action') == 'join_attempt_success' ? 'selected' : '' }}>Join Success</option>
                        <option value="join_attempt_invalid_token" {{ request('action') == 'join_attempt_invalid_token' ? 'selected' : '' }}>Join Failed</option>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Date From</label>
                      <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Date To</label>
                      <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">&nbsp;</label>
                      <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                          <i class="bx bx-filter"></i> Filter
                        </button>
                        <a href="{{ route('admin.zoom.audit') }}" class="btn btn-secondary">
                          <i class="bx bx-reset"></i> Reset
                        </a>
                      </div>
                    </div>
                  </div>
                </form>
              </div>

              <!-- Audit Logs Table -->
              <div class="api-form">
                <div class="table-responsive">
                  <table class="table table-hover" id="auditTable">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Action</th>
                        <th>User</th>
                        <th>Entity</th>
                        <th>IP Address</th>
                        <th>Metadata</th>
                        <th>Timestamp</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($logs as $log)
                        <tr>
                          <td>{{ $log->id }}</td>
                          <td>
                            <span class="action-badge action-{{ str_replace('.', '_', $log->action) }}">
                              {{ ucwords(str_replace(['_', '.'], ' ', $log->action)) }}
                            </span>
                          </td>
                          <td>
                            @if($log->user)
                              <strong>{{ $log->user->first_name }} {{ $log->user->last_name }}</strong>
                              <br>
                              <small class="text-muted">{{ $log->user->email }}</small>
                            @else
                              <span class="text-muted">System</span>
                            @endif
                          </td>
                          <td>
                            @if($log->entity_type && $log->entity_id)
                              <span class="badge bg-secondary">{{ $log->entity_type }} #{{ $log->entity_id }}</span>
                            @else
                              <span class="text-muted">-</span>
                            @endif
                          </td>
                          <td>
                            <code>{{ $log->ip_address ?? '-' }}</code>
                          </td>
                          <td>
                            @if($log->metadata)
                              <span class="metadata-toggle" data-log-id="{{ $log->id }}">
                                <i class="bx bx-show"></i> View Details
                              </span>
                              <div class="metadata-content" id="metadata-{{ $log->id }}">{{ json_encode($log->metadata, JSON_PRETTY_PRINT) }}</div>
                            @else
                              <span class="text-muted">-</span>
                            @endif
                          </td>
                          <td>
                            <strong>{{ $log->created_at->format('M d, Y') }}</strong>
                            <br>
                            <small class="text-muted">{{ $log->created_at->format('h:i A') }}</small>
                            <br>
                            <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="7" class="text-center py-5">
                            <i class="bx bx-info-circle" style="font-size: 48px; opacity: 0.3;"></i>
                            <p class="text-muted mt-3">No audit logs found for the selected filters.</p>
                          </td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper">
                  <div>
                    Showing {{ $logs->firstItem() ?? 0 }} to {{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }} logs
                  </div>
                  <div>
                    {{ $logs->links() }}
                  </div>
                </div>
              </div>

              <!-- copyright section -->
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
    <script src="/assets/admin/asset/js/bootstrap.min.js"></script>
    <script src="/assets/admin/asset/js/script.js"></script>

    <!-- Custom JavaScript -->
    <script>
      $(document).ready(function() {
        // Toggle metadata visibility
        $('.metadata-toggle').click(function() {
          const logId = $(this).data('log-id');
          const metadataContent = $('#metadata-' + logId);
          const icon = $(this).find('i');

          metadataContent.toggleClass('show');

          if (metadataContent.hasClass('show')) {
            icon.removeClass('bx-show').addClass('bx-hide');
            $(this).html('<i class="bx bx-hide"></i> Hide Details');
          } else {
            icon.removeClass('bx-hide').addClass('bx-show');
            $(this).html('<i class="bx bx-show"></i> View Details');
          }
        });
      });
    </script>
  </body>
</html>

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
</html>
