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
    <!-- Owl carousel css -->
    <link href="/assets/admin/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
    <link href="/assets/admin/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/bootstrap.min.css" />
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/style.css" />
    <link rel="stylesheet" href="/assets/user/asset/css/style.css" />
    <title>Super Admin Dashboard | Google Analytics</title>
  </head>
  <style>
    .button {
      color: #0072b1 !important;
    }
    .date-filter-section {
      margin-bottom: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .btn-refresh {
      background: #0072b1;
      color: white;
      padding: 8px 16px;
      border-radius: 6px;
      border: none;
      cursor: pointer;
    }
    .btn-refresh:hover {
      background: #005a8d;
    }
    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.3);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 9999;
    }
    .loading-overlay.active {
      display: flex;
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
      <!-- Loading Overlay -->
      <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border text-light" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>

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
                    <span class="min-title">Analytics & Reports</span>
                  </div>
                </div>
              </div>
              <!-- Blue MESSAGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <i class="bx bx-bar-chart-alt"></i>
                      <h2>Google Analytics 4 - Live Data</h2>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Date Filter Section -->
              <div class="send-notify">
                <div class="row">
                  <div class="col-md-12">
                    <div class="date-filter-section">
                      <div>
                        <h1>Google Analytics</h1>
                      </div>
                      <div>
                        <select class="form-select" id="dateRangeSelect" style="display: inline-block; width: auto;">
                          <option value="7" {{ $days == 7 ? 'selected' : '' }}>Last 7 days</option>
                          <option value="30" {{ $days == 30 ? 'selected' : '' }}>Last 30 days</option>
                          <option value="90" {{ $days == 90 ? 'selected' : '' }}>Last 90 days</option>
                        </select>
                        <button class="btn-refresh" onclick="refreshData()">
                          <i class="bx bx-refresh"></i> Refresh
                        </button>
                        <form action="{{ route('admin.analytics.cache.clear') }}" method="POST" style="display: inline;">
                          @csrf
                          <button type="submit" class="btn-refresh" style="background: #dc3545;">
                            <i class="bx bx-trash"></i> Clear Cache
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Stats Cards -->
              <div class="google-card">
                <div class="col-md-12">
                  <div class="row">
                    <!-- Active Users Card -->
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                      <div class="card super-panel-card analatic">
                        <div class="title">
                          <p class="mb-0">Active Users</p>
                          <h1 class="mb-0" id="activeUsersCount">{{ number_format($activeUsers) }}</h1>
                        </div>
                        <div class="d-flex">
                          <p class="mb-0 last">Last {{ $days }} days</p>
                        </div>
                      </div>
                    </div>

                    <!-- Total Page Views Card -->
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                      <div class="card super-panel-card analatic">
                        <div class="title">
                          <p class="mb-0">Total Page Views</p>
                          <h1 class="mb-0" id="totalPageViewsCount">{{ number_format($totalPageViews) }}</h1>
                        </div>
                        <div class="d-flex">
                          <p class="mb-0 last">Last {{ $days }} days</p>
                        </div>
                      </div>
                    </div>

                    <!-- Avg Session Duration Card -->
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                      <div class="card super-panel-card analatic">
                        <div class="title">
                          <p class="mb-0">Avg Session Duration</p>
                          <h1 class="mb-0" id="sessionDurationFormatted">{{ $avgSessionDuration }}</h1>
                        </div>
                        <div class="d-flex">
                          <p class="mb-0 last">Last {{ $days }} days</p>
                        </div>
                      </div>
                    </div>

                    <!-- Realtime Users Card -->
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                      <div class="card super-panel-card analatic">
                        <div class="title">
                          <p class="mb-0">Realtime Users</p>
                          <h1 class="mb-0" id="realtimeUsersCount">{{ $realtimeUsers }}</h1>
                        </div>
                        <div class="d-flex">
                          <div class="d-flex percentag-green">
                            <p class="mb-0">
                              <i class="bx bx-pulse" style="color: #10b981;"></i> Live
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Charts Section -->
                  <div class="row graph-sec mt-4">
                    <!-- Users by Country Chart -->
                    <div class="col-xl-6 col-lg-12 col-md-12 col-12">
                      <div class="Card" style="background: white; padding: 40px; border-radius: 8px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.04);">
                        <h5 class="mb-3">Users by Country (Top 10)</h5>
                        <canvas id="countriesChart"></canvas>
                      </div>
                    </div>

                    <!-- Most Visited Pages Chart -->
                    <div class="col-xl-6 col-lg-12 col-md-12 col-12">
                      <div class="Card" style="background: white; padding: 40px; border-radius: 8px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.04);">
                        <h5 class="mb-3">Most Visited Pages</h5>
                        <canvas id="pagesChart"></canvas>
                      </div>
                    </div>
                  </div>

                  <div class="row graph-sec mt-4">
                    <!-- Top Referrers Chart -->
                    <div class="col-xl-6 col-lg-12 col-md-12 col-12">
                      <div class="Card" style="background: white; padding: 40px; border-radius: 8px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.04);">
                        <h5 class="mb-3">Top Referrers (Traffic Sources)</h5>
                        <canvas id="referrersChart"></canvas>
                      </div>
                    </div>

                    <!-- Top Browsers Chart -->
                    <div class="col-xl-6 col-lg-12 col-md-12 col-12">
                      <div class="Card" style="background: white; padding: 40px; border-radius: 8px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.04);">
                        <h5 class="mb-3">Top Browsers</h5>
                        <canvas id="browsersChart"></canvas>
                      </div>
                    </div>
                  </div>

                  <!-- New vs Returning Users -->
                  <div class="row graph-sec mt-4">
                    <div class="col-xl-6 col-lg-12 col-md-12 col-12">
                      <div class="Card" style="background: white; padding: 40px; border-radius: 8px; box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.04);">
                        <h5 class="mb-3">New vs Returning Users</h5>
                        <canvas id="newReturningChart"></canvas>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- =============================== MAIN CONTENT END HERE =========================== -->
      <!-- copyright section start from here -->
      <div class="copyright">
        <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
      </div>
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
    // Chart Data from Backend
    const countriesData = @json($countriesChartData);
    const pagesData = @json($pagesChartData);
    const referrersData = @json($referrersChartData);
    const browsersData = @json($browsersChartData);
    const newVsReturning = @json($newVsReturning);

    // Initialize Charts
    let countriesChart, pagesChart, referrersChart, browsersChart, newReturningChart;

    // Countries Chart
    const countriesCtx = document.getElementById('countriesChart').getContext('2d');
    countriesChart = new Chart(countriesCtx, {
      type: 'bar',
      data: {
        labels: countriesData.labels,
        datasets: [{
          label: 'Active Users',
          data: countriesData.users,
          backgroundColor: '#0072b1',
          borderRadius: 6,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: { beginAtZero: true }
        }
      }
    });

    // Pages Chart
    const pagesCtx = document.getElementById('pagesChart').getContext('2d');
    pagesChart = new Chart(pagesCtx, {
      type: 'bar',
      data: {
        labels: pagesData.labels,
        datasets: [{
          label: 'Page Views',
          data: pagesData.pageViews,
          backgroundColor: '#10b981',
          borderRadius: 6,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: { beginAtZero: true }
        }
      }
    });

    // Referrers Chart
    const referrersCtx = document.getElementById('referrersChart').getContext('2d');
    referrersChart = new Chart(referrersCtx, {
      type: 'bar',
      data: {
        labels: referrersData.labels,
        datasets: [{
          label: 'Page Views',
          data: referrersData.pageViews,
          backgroundColor: '#f59e0b',
          borderRadius: 6,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: { beginAtZero: true }
        }
      }
    });

    // Browsers Chart
    const browsersCtx = document.getElementById('browsersChart').getContext('2d');
    browsersChart = new Chart(browsersCtx, {
      type: 'bar',
      data: {
        labels: browsersData.labels,
        datasets: [{
          label: 'Page Views',
          data: browsersData.pageViews,
          backgroundColor: '#8b5cf6',
          borderRadius: 6,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: { beginAtZero: true }
        }
      }
    });

    // New vs Returning Chart
    const newReturningCtx = document.getElementById('newReturningChart').getContext('2d');
    newReturningChart = new Chart(newReturningCtx, {
      type: 'doughnut',
      data: {
        labels: ['New Users', 'Returning Users'],
        datasets: [{
          data: [newVsReturning.new, newVsReturning.returning],
          backgroundColor: ['#0072b1', '#10b981'],
          borderWidth: 0,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    });

    // Date Range Change Handler
    document.getElementById('dateRangeSelect').addEventListener('change', function() {
      const days = this.value;
      window.location.href = `{{ route('admin.analytics.dashboard') }}?days=${days}`;
    });

    // Refresh Data Function
    function refreshData() {
      const days = document.getElementById('dateRangeSelect').value;
      window.location.href = `{{ route('admin.analytics.dashboard') }}?days=${days}`;
    }

    // Auto-refresh every 5 minutes (optional)
    // setInterval(refreshData, 300000);
    </script>

    <script>
      /* === start ASIDE ==== */
      if (document.querySelector(".drop")) {
        const lists = document.querySelectorAll(".drop");
        dropList(lists);

        function dropList(els) {
          els.forEach((el) => {
            el.addEventListener("click", (e) => {
              e.currentTarget.classList.toggle("show");
              let content = e.currentTarget.nextElementSibling;
              if (content.style.maxHeight) {
                content.style.maxHeight = null;
              } else {
                content.style.maxHeight = content.scrollHeight + "px";
              }
            });
          });
        }
      }
      /* === end ASIDE ==== */
    </script>

    @if(session('success'))
    <script>
      alert('{{ session('success') }}');
    </script>
    @endif
  </body>
</html>
