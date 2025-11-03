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
    <title>Super Admin Dashboard | Live Zoom Classes</title>
    <style>
      .status-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
      }
      .status-scheduled { background: #e3f2fd; color: #1976d2; }
      .status-started { background: #e8f5e9; color: #388e3c; animation: pulse 2s infinite; }
      .status-ended { background: #f5f5f5; color: #616161; }
      .status-cancelled { background: #ffebee; color: #d32f2f; }

      @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
      }

      .participant-count {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 2px 8px;
        background: #f0f0f0;
        border-radius: 8px;
        font-size: 0.9rem;
      }

      .meeting-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
      }

      .meeting-card:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      }

      .meeting-card.live {
        border-left: 4px solid #4caf50;
      }

      .live-indicator {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #4caf50;
        font-weight: 600;
      }

      .live-dot {
        width: 8px;
        height: 8px;
        background: #4caf50;
        border-radius: 50%;
        animation: blink 1.5s infinite;
      }

      @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
      }

      .auto-refresh-indicator {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #fff;
        padding: 10px 15px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        font-size: 0.85rem;
        color: #666;
        display: flex;
        align-items: center;
        gap: 8px;
      }

      .refresh-spinner {
        width: 16px;
        height: 16px;
        border: 2px solid #e0e0e0;
        border-top-color: #4caf50;
        border-radius: 50%;
        animation: spin 1s linear infinite;
      }

      @keyframes spin {
        to { transform: rotate(360deg); }
      }

      .participant-list {
        margin-top: 10px;
        padding: 10px;
        background: #f9f9f9;
        border-radius: 6px;
        max-height: 200px;
        overflow-y: auto;
      }

      .participant-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 6px 0;
        border-bottom: 1px solid #e0e0e0;
      }

      .participant-item:last-child {
        border-bottom: none;
      }

      .role-badge {
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
      }

      .role-host { background: #ffd54f; color: #f57f17; }
      .role-participant { background: #e3f2fd; color: #1976d2; }
      .role-guest { background: #f5f5f5; color: #616161; }

      .no-meetings {
        text-align: center;
        padding: 60px 20px;
        color: #999;
      }

      .no-meetings i {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.3;
      }

      .filter-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        border-bottom: 2px solid #e0e0e0;
        padding-bottom: 10px;
      }

      .filter-tab {
        padding: 8px 20px;
        background: transparent;
        border: none;
        border-bottom: 2px solid transparent;
        cursor: pointer;
        font-weight: 600;
        color: #666;
        transition: all 0.3s ease;
      }

      .filter-tab.active {
        color: #1976d2;
        border-bottom-color: #1976d2;
      }

      .meeting-stats {
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
                    <span class="min-title">Live Zoom Classes</span>
                  </div>
                </div>
              </div>

              <!-- Blue MESSAGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <i class="bx bx-video"></i>
                      <h2>Live & Upcoming Zoom Classes</h2>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Stats Section -->
              <div class="meeting-stats">
                <div class="stat-card">
                  <div class="stat-value" id="stat-live">0</div>
                  <div class="stat-label">Live Now</div>
                </div>
                <div class="stat-card">
                  <div class="stat-value" id="stat-scheduled">0</div>
                  <div class="stat-label">Scheduled Today</div>
                </div>
                <div class="stat-card">
                  <div class="stat-value" id="stat-participants">0</div>
                  <div class="stat-label">Active Participants</div>
                </div>
                <div class="stat-card">
                  <div class="stat-value" id="stat-ended">0</div>
                  <div class="stat-label">Ended Today</div>
                </div>
              </div>

              <!-- Filter Tabs -->
              <div class="filter-tabs">
                <button class="filter-tab active" data-filter="all">All Meetings</button>
                <button class="filter-tab" data-filter="started">Live Now</button>
                <button class="filter-tab" data-filter="scheduled">Scheduled</button>
                <button class="filter-tab" data-filter="ended">Ended</button>
              </div>

              <!-- Meetings List -->
              <div id="meetings-container">
                <div class="no-meetings">
                  <i class="bx bx-video-off"></i>
                  <h4>Loading meetings...</h4>
                </div>
              </div>

              <!-- Auto-refresh Indicator -->
              <div class="auto-refresh-indicator">
                <div class="refresh-spinner"></div>
                <span>Auto-refreshing every 10s</span>
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
      let currentFilter = 'all';
      let refreshInterval;

      $(document).ready(function() {
        // Initial load
        loadMeetings();

        // Auto-refresh every 10 seconds
        refreshInterval = setInterval(loadMeetings, 10000);

        // Filter tabs
        $('.filter-tab').click(function() {
          $('.filter-tab').removeClass('active');
          $(this).addClass('active');
          currentFilter = $(this).data('filter');
          renderMeetings(window.meetingsData);
        });
      });

      function loadMeetings() {
        $.ajax({
          url: '{{ route("admin.zoom.live.data") }}',
          type: 'GET',
          success: function(data) {
            window.meetingsData = data;
            updateStats(data);
            renderMeetings(data);
          },
          error: function(xhr) {
            console.error('Failed to load meetings:', xhr);
          }
        });
      }

      function updateStats(data) {
        const live = data.live.length;
        const scheduled = data.scheduled.length;
        const ended = data.ended.length;
        const participants = data.live.reduce((sum, meeting) => sum + meeting.participant_count, 0);

        $('#stat-live').text(live);
        $('#stat-scheduled').text(scheduled);
        $('#stat-participants').text(participants);
        $('#stat-ended').text(ended);
      }

      function renderMeetings(data) {
        let meetings = [];

        if (currentFilter === 'all') {
          meetings = [...data.live, ...data.scheduled, ...data.ended];
        } else if (currentFilter === 'started') {
          meetings = data.live;
        } else if (currentFilter === 'scheduled') {
          meetings = data.scheduled;
        } else if (currentFilter === 'ended') {
          meetings = data.ended;
        }

        if (meetings.length === 0) {
          $('#meetings-container').html(`
            <div class="no-meetings">
              <i class="bx bx-video-off"></i>
              <h4>No meetings found</h4>
              <p>There are no ${currentFilter === 'all' ? '' : currentFilter} meetings at the moment.</p>
            </div>
          `);
          return;
        }

        let html = '';
        meetings.forEach(meeting => {
          html += renderMeetingCard(meeting);
        });

        $('#meetings-container').html(html);
      }

      function renderMeetingCard(meeting) {
        const isLive = meeting.status === 'started';
        const statusClass = `status-${meeting.status}`;
        const cardClass = isLive ? 'meeting-card live' : 'meeting-card';

        let participantsList = '';
        if (meeting.participants && meeting.participants.length > 0) {
          participantsList = '<div class="participant-list">';
          meeting.participants.forEach(participant => {
            const roleClass = `role-${participant.role}`;
            const duration = participant.duration ? ` (${participant.duration})` : ' (Joined)';
            participantsList += `
              <div class="participant-item">
                <div>
                  <i class="bx bx-user"></i> ${participant.email}
                  ${participant.user_id ? '' : '<span class="badge bg-secondary">Guest</span>'}
                </div>
                <div>
                  <span class="role-badge ${roleClass}">${participant.role}</span>
                  <small class="text-muted">${duration}</small>
                </div>
              </div>
            `;
          });
          participantsList += '</div>';
        }

        return `
          <div class="${cardClass}">
            <div class="row">
              <div class="col-md-8">
                <div class="d-flex align-items-center gap-3 mb-2">
                  ${isLive ? '<div class="live-indicator"><div class="live-dot"></div>LIVE</div>' : ''}
                  <span class="status-badge ${statusClass}">${meeting.status.toUpperCase()}</span>
                  <span class="participant-count">
                    <i class="bx bx-user"></i> ${meeting.participant_count}
                  </span>
                </div>
                <h5 class="mb-2">
                  <i class="bx bx-book-open"></i> ${meeting.topic}
                </h5>
                <div class="text-muted small">
                  <i class="bx bx-user-circle"></i> Teacher: <strong>${meeting.teacher_name}</strong>
                  <br>
                  <i class="bx bx-time"></i> Start Time: ${meeting.start_time_formatted}
                  ${meeting.actual_start_time ? `<br><i class="bx bx-check"></i> Started: ${meeting.actual_start_time}` : ''}
                  ${meeting.actual_end_time ? `<br><i class="bx bx-stop"></i> Ended: ${meeting.actual_end_time}` : ''}
                  <br>
                  <i class="bx bx-globe"></i> Timezone: ${meeting.timezone}
                </div>
              </div>
              <div class="col-md-4 text-end">
                <div class="mb-2">
                  <strong>Meeting ID:</strong> ${meeting.meeting_id}
                </div>
                <div class="mb-2">
                  <strong>Duration:</strong> ${meeting.duration} min
                </div>
                ${isLive ? `
                  <a href="${meeting.start_url}" target="_blank" class="btn btn-sm btn-success">
                    <i class="bx bx-log-in"></i> Join as Host
                  </a>
                ` : ''}
              </div>
            </div>
            ${participantsList}
          </div>
        `;
      }

      // Clear interval when leaving page
      $(window).on('beforeunload', function() {
        if (refreshInterval) {
          clearInterval(refreshInterval);
        }
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
