<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <!-- View Point scale to 1.0 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Animate css -->
    <link rel="stylesheet" href="assets/admin/libs/animate/css/animate.css" />
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="assets/admin/libs/aos/css/aos.css" />
    <!-- Datatable css  -->
    <link rel="stylesheet" href="assets/admin/libs/datatable/css/datatable.css" />
     {{-- Fav Icon --}}
     @php  $home = \App\Models\HomeDynamic::first(); @endphp
     @if ($home)
         <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
     @endif
     <!-- Select2 css -->
    <link href="assets/admin/libs/select2/css/select2.min.css" rel="stylesheet" />
    <!-- Owl carousel css -->
    <link href="assets/admin/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
    <link href="assets/admin/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
    <!-- Bootstrap css -->
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/admin/asset/css/bootstrap.min.css"
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
    <!-- GRAPH LINKS -->
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.css"></script>
    <script src="ttps://cdn.jsdhelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Teko"
    />
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/admin/asset/css/style.css" />
    <link rel="stylesheet" href="assets/user/asset/css/style.css" />
    <title>Super Admin Dashboard | Google Analytics</title>
  </head>
  <style>
    .button {
      color: #0072b1 !important;
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
                    <span class="min-title">Analytics & Reports</span>
                  </div>
                </div>
              </div>
              <!-- Blue MASSEGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <i class="bx bx-bar-chart-alt"></i>
                      <h2>Analytics & Reports</h2>
                    </div>
                  </div>
                </div>
              </div>

              <!-- ================================== -->
              <div class="send-notify">
                <div class="row">
                  <div class="col-md-12">
                    <h1>Google Analytics</h1>
                  </div>
                </div>
              </div>
              <!-- ================================== -->
              <div class="google-card">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                      <div class="card super-panel-card analatic">
                        <div class="title">
                          <p class="mb-0">Total Seller</p>
                          <h1 class="mb-0">19,500</h1>
                        </div>
                        <div class="d-flex">
                          <div class="d-flex percentag">
                            <p class="mb-0">
                              - 22 %
                              <span
                                ><img
                                  src="assets/admin/asset/img/streamline_money-graph-arrow-increase-ascend-growth-up-arrow-stats-graph-right-grow.svg"
                                  alt=""
                              /></span>
                            </p>
                          </div>
                          <p class="mb-0 last">then last month</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                      <div class="card super-panel-card analatic">
                        <div class="title">
                          <p class="mb-0">Total Seller</p>
                          <h1 class="mb-0">19,500</h1>
                        </div>
                        <div class="d-flex">
                          <div class="d-flex percentag-green">
                            <p class="mb-0">
                              - 22 %
                              <span
                                ><img
                                  src="assets/admin/asset/img/streamline_money-graph-arrow-increase-ascend-growth-up-arrow-stats-graph-right-grow (1).svg"
                                  alt=""
                              /></span>
                            </p>
                          </div>
                          <p class="mb-0 last">then last month</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                      <div class="card super-panel-card analatic">
                        <div class="title">
                          <p class="mb-0">Total Seller</p>
                          <h1 class="mb-0">19,500</h1>
                        </div>
                        <div class="d-flex">
                          <div class="d-flex percentag">
                            <p class="mb-0">
                              - 22 %
                              <span
                                ><img
                                  src="assets/admin/asset/img/streamline_money-graph-arrow-increase-ascend-growth-up-arrow-stats-graph-right-grow.svg"
                                  alt=""
                              /></span>
                            </p>
                          </div>
                          <p class="mb-0 last">then last month</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                      <div class="card super-panel-card analatic">
                        <div class="title">
                          <p class="mb-0">Total Seller</p>
                          <h1 class="mb-0">19,500</h1>
                        </div>
                        <div class="d-flex">
                          <div class="d-flex percentag-green">
                            <p class="mb-0">
                              - 22 %
                              <span
                                ><img
                                  src="assets/admin/asset/img/streamline_money-graph-arrow-increase-ascend-growth-up-arrow-stats-graph-right-grow (1).svg"
                                  alt=""
                              /></span>
                            </p>
                          </div>
                          <p class="mb-0 last">then last month</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row graph-sec">
                    <div class="col-xl-8 col-lg-12 col-md-12 col-12">
                      <div
                        class="Card"
                        style="
                          background: white;
                          padding: 40px;
                          border-radius: 8px;
                          box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.04);
                        "
                      >
                        <div>
                          <canvas id="myChart"></canvas>
                        </div>

                        <!-- <div class="select mt-4 ml-4 mb-4" style="width: 20%;"> -->
                        <select
                          class="form-select"
                          aria-label="Default select example"
                        >
                          <option value="today">Today</option>
                          <option value="yesterday">Yesterday</option>
                          <option value="today">Last Week</option>
                          <option value="today">Last 7 days</option>
                          <option value="today">Lifetime</option>
                          <option value="lastMonth">Last Month</option>
                        </select>
                        <!-- </div> -->
                      </div>
                    </div>
                    <div class="col-xl-4 col-lg-12 col-md-12 col-12 pie-graph">
                      <div
                        class="Card"
                        style="
                          background: white;
                          border-radius: 8px;
                          box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.04);
                        "
                      >
                        <div class="card-body">
                          <h5 class="pie-heading">Session by Device</h5>
                        </div>

                        <div class="dougnut">
                          <canvas id="graph"></canvas>
                        </div>

                        <div class="d-flex pie">
                          <div class="doughnut-icon">
                            <i class="bx bx-desktop icon"></i>
                            <p class="mb-0">Desktop</p>
                            <p class="mb-0 pie-desc">79.10%</p>
                          </div>
                          <div class="doughnut-icon">
                            <i class="bx bx-tab icon"></i>
                            <p class="mb-0">Tablet</p>
                            <p class="mb-0 pie-desc">15.90%</p>
                          </div>
                          <div class="doughnut-icon">
                            <i class="bx bx-mobile-alt icon"></i>
                            <p class="mb-0">Mobile</p>
                            <p class="mb-0 pie-desc">5%</p>
                          </div>
                        </div>
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

    <script src="assets/admin/libs/jquery/jquery.js"></script>
    <script src="assets/admin/libs/datatable/js/datatable.js"></script>
    <script src="assets/admin/libs/datatable/js/datatablebootstrap.js"></script>
    <script src="assets/admin/libs/select2/js/select2.min.js"></script>
    <script src="assets/admin/libs/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="assets/admin/libs/aos/js/aos.js"></script>
    <script src="assets/admin/asset/js/bootstrap.min.js"></script>
    <script src="assets/admin/asset/js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
  </body>
</html>
<!-- =========================================== CHART & GRAPH SCRIPT ========================================================= -->
<script>
  var ctx = document.getElementById("graph").getContext("2d");
  var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: "doughnut",
    // The data for our dataset
    data: {
      // labels: ["Iværksætter", "Forandringsagent", "Beslutningstager",],
      datasets: [
        {
          label: "Din ledelsesstil",
          backgroundColor: ["#0A77B4", "#5080F9", "#00000033"],
          data: [60, 15, 25],
          borderRadius: 20,
          spacing: 5,
        },
      ],
    },

    // Configuration options go here
    options: {
      legend: {
        display: false,
      },

      tooltips: {
        enabled: true,
        mode: "index",
        callbacks: {
          label: function (tooltipItems, data) {
            var i,
              label = [],
              l = data.datasets.length;
            for (i = 0; i < l; i += 1) {
              label[i] =
                data.datasets[i].label +
                ": " +
                data.datasets[i].data[tooltipItems.index] +
                "%";
            }
            return label;
          },
        },
      },
    },
  });
</script>
<script>
  // setup
  const data = {
    labels: ["04Nov", "05", "06", "06", "07", "08", "09", "10"],
    datasets: [
      {
        // label: 'Weekly Sales',
        data: [0, 1000, 200, 300, 400, 500, 600],
        backgroundColor: [
          // 'rgba(255, 26, 104, 0.2)',
          // 'rgba(54, 162, 235, 0.2)',
          // 'rgba(255, 206, 86, 0.2)',
          // 'rgba(75, 192, 192, 0.2)',
          // 'rgba(153, 102, 255, 0.2)',
          // 'rgba(255, 159, 64, 0.2)',
          // 'rgba(0, 0, 0, 0.2)'
        ],
        borderColor: ["#0173B2", "#0173B200"],
        borderWidth: 5,
        tension: 0.4,
        pointRadius: [0],
      },
    ],
  };

  // config
  const config = {
    type: "line",
    data,
    options: {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  };

  // render init block
  const mydoughnut = new Chart(document.getElementById("myChart"), config);

  // Instantly assign Chart.js version
  const chartVersion = document.getElementById("chartVersion");
  chartVersion.innerText = Chart.version;
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
<!-- ================ side js start here=============== -->
<!-- ================ side js start End=============== -->
