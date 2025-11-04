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
    {{-- Fav Icon --}}
    @php  $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="/assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
    @endif
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
    <title>Teacher Dashboard | Zoom Integration</title>
    <style>
      .connection-status-card {
        background: #fff;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 30px;
        text-align: center;
      }

      .connection-status-card.connected {
        border-color: #4caf50;
        background: linear-gradient(135deg, #f1f8f4 0%, #ffffff 100%);
      }

      .connection-status-card.disconnected {
        border-color: #ff9800;
        background: linear-gradient(135deg, #fff8e1 0%, #ffffff 100%);
      }

      .status-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        background: #f5f5f5;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
      }

      .status-icon.connected {
        background: #e8f5e9;
        color: #4caf50;
      }

      .status-icon.disconnected {
        background: #fff3e0;
        color: #ff9800;
      }

      .status-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 10px;
      }

      .status-description {
        color: #666;
        margin-bottom: 20px;
      }

      .connect-btn {
        padding: 12px 40px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
      }

      .connect-btn-primary {
        background: #1976d2;
        color: #fff;
      }

      .connect-btn-primary:hover {
        background: #1565c0;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(25, 118, 210, 0.3);
      }

      .connect-btn-danger {
        background: #d32f2f;
        color: #fff;
      }

      .connect-btn-danger:hover {
        background: #c62828;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(211, 47, 47, 0.3);
      }

      .connect-btn-secondary {
        background: #757575;
        color: #fff;
        padding: 8px 20px;
        font-size: 0.9rem;
      }

      .connect-btn-secondary:hover {
        background: #616161;
      }

      .info-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
      }

      .info-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
      }

      .info-row:last-child {
        border-bottom: none;
      }

      .info-label {
        color: #666;
        font-weight: 600;
      }

      .info-value {
        color: #333;
      }

      .feature-list {
        list-style: none;
        padding: 0;
        margin: 20px 0;
      }

      .feature-list li {
        padding: 10px 0;
        display: flex;
        align-items: flex-start;
        gap: 10px;
      }

      .feature-list li i {
        color: #4caf50;
        font-size: 20px;
        margin-top: 2px;
      }

      .warning-box {
        background: #fff3cd;
        border: 1px solid #ffc107;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
      }

      .warning-box i {
        color: #ffc107;
        font-size: 24px;
      }

      .error-box {
        background: #ffebee;
        border: 1px solid #ef5350;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
      }

      .error-box i {
        color: #ef5350;
        font-size: 24px;
      }

      .success-box {
        background: #e8f5e9;
        border: 1px solid #4caf50;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
      }

      .success-box i {
        color: #4caf50;
        font-size: 24px;
      }

      .benefits-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 30px;
      }

      .benefit-card {
        background: #f9f9f9;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
      }

      .benefit-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      }

      .benefit-card i {
        font-size: 40px;
        color: #1976d2;
        margin-bottom: 15px;
      }

      .benefit-card h5 {
        font-weight: 700;
        margin-bottom: 10px;
      }

      .refresh-spinner {
        animation: spin 1s linear infinite;
      }

      @keyframes spin {
        to { transform: rotate(360deg); }
      }
    </style>
  </head>
  <body>
     {{-- ===========Teacher Sidebar Start==================== --}}
     <x-teacher-sidebar/>
     {{-- ===========Teacher Sidebar End==================== --}}
     <section class="home-section">
        {{-- ===========Teacher NavBar Start==================== --}}
        <x-teacher-nav/>
        {{-- ===========Teacher NavBar End==================== --}}
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
                    <span class="min-title">Zoom Integration</span>
                  </div>
                </div>
              </div>

              <!-- Flash Messages -->
              @if(session('success'))
                <div class="success-box">
                  <i class="bx bx-check-circle"></i>
                  <div>
                    <strong>Success!</strong><br>
                    {{ session('success') }}
                  </div>
                </div>
              @endif

              @if(session('error'))
                <div class="error-box">
                  <i class="bx bx-error"></i>
                  <div>
                    <strong>Error!</strong><br>
                    {{ session('error') }}
                  </div>
                </div>
              @endif

              <!-- Connection Status Card -->
              @if($isConnected)
                <div class="connection-status-card connected">
                  <div class="status-icon connected">
                    <i class="bx bx-check-circle"></i>
                  </div>
                  <h2 class="status-title">Zoom Connected</h2>
                  <p class="status-description">Your Zoom account is successfully connected and ready to host live classes!</p>
                  <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="connect-btn connect-btn-secondary" id="refreshTokenBtn">
                      <i class="bx bx-refresh"></i> Refresh Connection
                    </button>
                    <button type="button" class="connect-btn connect-btn-danger" id="disconnectBtn">
                      <i class="bx bx-unlink"></i> Disconnect Zoom
                    </button>
                  </div>
                </div>

                <!-- Account Details -->
                <div class="info-card">
                  <h5 class="mb-3"><i class="bx bx-info-circle"></i> Connected Account Details</h5>
                  <div class="info-row">
                    <span class="info-label">Zoom Email:</span>
                    <span class="info-value">{{ $user->zoom_email ?? 'N/A' }}</span>
                  </div>
                  <div class="info-row">
                    <span class="info-label">Zoom User ID:</span>
                    <span class="info-value">{{ $user->zoom_user_id ?? 'N/A' }}</span>
                  </div>
                  <div class="info-row">
                    <span class="info-label">Connected Since:</span>
                    <span class="info-value">{{ $user->zoom_connected_at ? $user->zoom_connected_at->format('M d, Y H:i') : 'N/A' }}</span>
                  </div>
                  <div class="info-row">
                    <span class="info-label">Token Expires:</span>
                    <span class="info-value" id="token-expiry">
                      {{ $user->zoom_token_expires_at ? $user->zoom_token_expires_at->diffForHumans() : 'Unknown' }}
                    </span>
                  </div>
                  <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                      <span class="badge bg-success">Active</span>
                    </span>
                  </div>
                </div>

                <!-- What's Next Section -->
                <div class="info-card">
                  <h5 class="mb-3"><i class="bx bx-rocket"></i> What's Next?</h5>
                  <ul class="feature-list">
                    <li>
                      <i class="bx bx-check"></i>
                      <span><strong>Automatic Meeting Creation:</strong> Zoom meetings will be automatically created 30 minutes before your scheduled classes.</span>
                    </li>
                    <li>
                      <i class="bx bx-check"></i>
                      <span><strong>Secure Join Links:</strong> Your students will receive secure, one-time join links via email.</span>
                    </li>
                    <li>
                      <i class="bx bx-check"></i>
                      <span><strong>Attendance Tracking:</strong> We'll track who joins your classes and for how long.</span>
                    </li>
                    <li>
                      <i class="bx bx-check"></i>
                      <span><strong>Token Auto-Refresh:</strong> Your connection will be automatically maintained without requiring re-login.</span>
                    </li>
                  </ul>
                </div>

              @else
                <div class="connection-status-card disconnected">
                  <div class="status-icon disconnected">
                    <i class="bx bx-unlink"></i>
                  </div>
                  <h2 class="status-title">Connect Your Zoom Account</h2>
                  <p class="status-description">Connect your Zoom account to automatically host live classes for your students</p>
                  <a href="{{ route('teacher.zoom.connect') }}" class="connect-btn connect-btn-primary">
                    <i class="bx bx-link"></i> Connect with Zoom
                  </a>
                </div>

                <!-- Why Connect Section -->
                <div class="warning-box">
                  <i class="bx bx-info-circle"></i>
                  <div>
                    <strong>Important:</strong> You need to connect your Zoom account to host live classes. Without this connection, your students won't be able to join your scheduled sessions.
                  </div>
                </div>

                <!-- Benefits Grid -->
                <h4 class="mb-3">Why Connect Your Zoom Account?</h4>
                <div class="benefits-grid">
                  <div class="benefit-card">
                    <i class="bx bx-video"></i>
                    <h5>Automated Meetings</h5>
                    <p>Meetings are created automatically 30 minutes before class starts</p>
                  </div>
                  <div class="benefit-card">
                    <i class="bx bx-lock-alt"></i>
                    <h5>Secure Access</h5>
                    <p>Students get secure, one-time join links that expire after use</p>
                  </div>
                  <div class="benefit-card">
                    <i class="bx bx-user-check"></i>
                    <h5>Attendance Tracking</h5>
                    <p>Automatically track who attends and how long they stay</p>
                  </div>
                  <div class="benefit-card">
                    <i class="bx bx-refresh"></i>
                    <h5>Auto-Maintenance</h5>
                    <p>Connection stays active with automatic token refresh</p>
                  </div>
                  <div class="benefit-card">
                    <i class="bx bx-envelope"></i>
                    <h5>Email Notifications</h5>
                    <p>Students receive reminders with join links before class</p>
                  </div>
                  <div class="benefit-card">
                    <i class="bx bx-shield-alt-2"></i>
                    <h5>Privacy Protected</h5>
                    <p>Your Zoom credentials are encrypted and secure</p>
                  </div>
                </div>

                <!-- How it Works Section -->
                <div class="info-card mt-4">
                  <h5 class="mb-3"><i class="bx bx-help-circle"></i> How Does It Work?</h5>
                  <ul class="feature-list">
                    <li>
                      <i class="bx bx-right-arrow-alt"></i>
                      <span><strong>Step 1:</strong> Click "Connect with Zoom" to authorize DreamCrowd to create meetings on your behalf</span>
                    </li>
                    <li>
                      <i class="bx bx-right-arrow-alt"></i>
                      <span><strong>Step 2:</strong> Sign in to your Zoom account (if not already signed in)</span>
                    </li>
                    <li>
                      <i class="bx bx-right-arrow-alt"></i>
                      <span><strong>Step 3:</strong> Approve the connection and you'll be redirected back</span>
                    </li>
                    <li>
                      <i class="bx bx-right-arrow-alt"></i>
                      <span><strong>Step 4:</strong> That's it! Your live classes will now use Zoom automatically</span>
                    </li>
                  </ul>
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
    <script src="/assets/admin/asset/js/bootstrap.min.js"></script>
    <script src="/assets/admin/asset/js/script.js"></script>

    <!-- Custom JavaScript -->
    <script>
      $(document).ready(function() {
        // Refresh Token Button
        $('#refreshTokenBtn').click(function() {
          const btn = $(this);
          const originalHtml = btn.html();

          btn.prop('disabled', true).html('<i class="bx bx-refresh refresh-spinner"></i> Refreshing...');

          $.ajax({
            url: '{{ route("teacher.zoom.refresh") }}',
            type: 'POST',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
              alert('✅ Token refreshed successfully!');
              btn.prop('disabled', false).html(originalHtml);
              location.reload();
            },
            error: function(xhr) {
              const message = xhr.responseJSON?.message || 'Failed to refresh token';
              alert('❌ ' + message);
              btn.prop('disabled', false).html(originalHtml);
            }
          });
        });

        // Disconnect Button
        $('#disconnectBtn').click(function() {
          if (!confirm('Are you sure you want to disconnect your Zoom account? Your future classes will not be able to use Zoom until you reconnect.')) {
            return;
          }

          const btn = $(this);
          const originalHtml = btn.html();

          btn.prop('disabled', true).html('<i class="bx bx-loader-alt refresh-spinner"></i> Disconnecting...');

          $.ajax({
            url: '{{ route("teacher.zoom.disconnect") }}',
            type: 'POST',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
              alert('✅ Zoom account disconnected successfully!');
              location.reload();
            },
            error: function(xhr) {
              const message = xhr.responseJSON?.message || 'Failed to disconnect';
              alert('❌ ' + message);
              btn.prop('disabled', false).html(originalHtml);
            }
          });
        });

        // Auto-dismiss flash messages after 5 seconds
        setTimeout(function() {
          $('.success-box, .error-box').fadeOut('slow');
        }, 5000);
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
