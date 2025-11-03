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
    <title>Super Admin Dashboard | Zoom Security Logs</title>
    <style>
      .alert-danger-custom {
        background: #ffebee;
        border: 1px solid #ef5350;
        border-left: 4px solid #d32f2f;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
      }

      .security-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
        background: #ffebee;
        color: #d32f2f;
      }

      .threat-level-high {
        background: #ffebee;
        color: #d32f2f;
      }

      .threat-level-medium {
        background: #fff3e0;
        color: #f57f17;
      }

      .threat-level-low {
        background: #e3f2fd;
        color: #1976d2;
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

      .stat-card.danger {
        border-color: #ef5350;
        background: #ffebee;
      }

      .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #d32f2f;
      }

      .stat-label {
        font-size: 0.9rem;
        color: #666;
        margin-top: 5px;
      }

      .ip-block-btn {
        padding: 4px 12px;
        font-size: 0.85rem;
        border-radius: 4px;
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
                    <span class="min-title">Zoom Security Logs</span>
                  </div>
                </div>
              </div>

              <!-- Blue MESSAGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <i class="bx bx-shield-alt-2"></i>
                      <h2>Security & Unauthorized Access Logs</h2>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Alert if high security events -->
              @if($criticalCount > 0)
              <div class="alert-danger-custom">
                <i class="bx bx-error-circle" style="font-size: 24px;"></i>
                <strong>Security Alert!</strong>
                <p class="mb-0">There have been <strong>{{ $criticalCount }}</strong> unauthorized access attempts in the last 24 hours. Please review the logs below.</p>
              </div>
              @endif

              <!-- Stats Section -->
              <div class="stats-grid">
                <div class="stat-card danger">
                  <div class="stat-value">{{ $totalSecurityEvents }}</div>
                  <div class="stat-label">Total Security Events</div>
                </div>
                <div class="stat-card danger">
                  <div class="stat-value">{{ $todayEvents }}</div>
                  <div class="stat-label">Today's Attempts</div>
                </div>
                <div class="stat-card danger">
                  <div class="stat-value">{{ $uniqueIPs }}</div>
                  <div class="stat-label">Unique IPs</div>
                </div>
                <div class="stat-card danger">
                  <div class="stat-value">{{ $lastHourEvents }}</div>
                  <div class="stat-label">Last Hour</div>
                </div>
              </div>

              <!-- Security Logs Table -->
              <div class="api-form">
                <div class="table-responsive">
                  <table class="table table-hover" id="securityTable">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Threat Level</th>
                        <th>Action</th>
                        <th>IP Address</th>
                        <th>User Agent</th>
                        <th>Entity</th>
                        <th>Details</th>
                        <th>Timestamp</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($logs as $log)
                        <tr>
                          <td>{{ $log->id }}</td>
                          <td>
                            @php
                              $threatLevel = 'low';
                              if (str_contains($log->action, 'invalid_token') || str_contains($log->action, 'unauthorized')) {
                                $threatLevel = 'high';
                              } elseif (str_contains($log->action, 'expired')) {
                                $threatLevel = 'medium';
                              }
                            @endphp
                            <span class="security-badge threat-level-{{ $threatLevel }}">
                              {{ strtoupper($threatLevel) }}
                            </span>
                          </td>
                          <td>
                            <strong>{{ ucwords(str_replace(['_', '.'], ' ', $log->action)) }}</strong>
                          </td>
                          <td>
                            <code>{{ $log->ip_address ?? 'Unknown' }}</code>
                          </td>
                          <td>
                            <small class="text-muted" style="max-width: 200px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                              {{ $log->user_agent ?? 'Unknown' }}
                            </small>
                          </td>
                          <td>
                            @if($log->entity_type && $log->entity_id)
                              <span class="badge bg-secondary">{{ $log->entity_type }} #{{ $log->entity_id }}</span>
                            @else
                              <span class="text-muted">-</span>
                            @endif
                          </td>
                          <td>
                            @if($log->metadata)
                              <small>{{ json_encode($log->metadata) }}</small>
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
                          <td>
                            <button class="btn btn-sm btn-danger ip-block-btn" onclick="blockIP('{{ $log->ip_address }}')">
                              <i class="bx bx-block"></i> Block IP
                            </button>
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="9" class="text-center py-5">
                            <i class="bx bx-check-shield" style="font-size: 48px; color: #4caf50;"></i>
                            <p class="text-muted mt-3">No security events found. Your system is secure!</p>
                          </td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>

                <!-- Pagination -->
                @if($logs->hasPages())
                <div class="pagination-wrapper">
                  <div>
                    Showing {{ $logs->firstItem() ?? 0 }} to {{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }} events
                  </div>
                  <div>
                    {{ $logs->links() }}
                  </div>
                </div>
                @endif
              </div>

              <!-- Top Threatening IPs -->
              @if(isset($topThreateningIPs) && count($topThreateningIPs) > 0)
              <div class="api-section mt-4">
                <h5 class="mb-3"><i class="bx bx-error"></i> Top Threatening IP Addresses</h5>
                <div class="table-responsive">
                  <table class="table table-sm">
                    <thead>
                      <tr>
                        <th>IP Address</th>
                        <th>Attempts</th>
                        <th>Last Attempt</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($topThreateningIPs as $ipData)
                        <tr>
                          <td><code>{{ $ipData['ip'] }}</code></td>
                          <td><strong>{{ $ipData['count'] }}</strong> attempts</td>
                          <td>{{ $ipData['last_attempt'] }}</td>
                          <td>
                            <button class="btn btn-sm btn-danger" onclick="blockIP('{{ $ipData['ip'] }}')">
                              <i class="bx bx-block"></i> Block
                            </button>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              @endif

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
      function blockIP(ipAddress) {
        if (confirm('Are you sure you want to block IP address: ' + ipAddress + '?\n\nThis will prevent all requests from this IP.')) {
          // Implement IP blocking logic here
          // This would typically involve calling an API endpoint
          alert('IP blocking feature will be implemented by your backend team.\n\nFor now, this is logged and you can manually add the IP to your firewall rules:\n\nIP: ' + ipAddress);

          // Example AJAX call:
          /*
          $.ajax({
            url: '/admin/zoom/block-ip',
            type: 'POST',
            data: {
              ip_address: ipAddress,
              _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
              alert('IP blocked successfully!');
              location.reload();
            }
          });
          */
        }
      }
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
