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
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/admin/asset/css/style.css" />
    <link rel="stylesheet" href="assets/user/asset/css/style.css" />
    <title>Super Admin Dashboard | Notification</title>
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
                    <span class="min-title">Notifications</span>
                  </div>
                </div>
              </div>
              <!-- Blue MASSEGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <i class="bx bx-bell-minus"></i>
                      <h2>Notifications</h2>
                    </div>
                  </div>
                </div>
              </div>

              <!-- ================================== -->
              <div class="send-notify">
                <div class="row">
                  <div class="col-md-12">
                    <button
                      type="button"
                      class="btn"
                      data-bs-target="#exampleModalToggle"
                      data-bs-toggle="modal"
                    >
                      Send new notification
                    </button>
                  </div>
                </div>
              </div>
              <!-- ================================== -->
              <!-- notification1 -->
              <div class="manu-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify-1 notify-first">
                      <div class="bel-icon">
                        <i class="fa-regular fa-bell"></i>
                      </div>
                      <p>
                        Learn all the Dos and Don’ts of Dream Crowd at our May
                        16th <br />
                        Community Standards webinar.
                        <a href="#">Register Now</a>
                      </p>
                      <div class="last-week">
                        <span>Last Week</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- notification2 -->
              <div class="manu-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify-1">
                      <div class="bel-icon">
                        <i class="fa-regular fa-bell"></i>
                      </div>
                      <p>
                        Learn all the Dos and Don’ts of Dream Crowd at our May
                        16th <br />
                        Community Standards webinar.
                        <a href="#">Register Now</a>
                      </p>
                      <div class="last-week">
                        <span>Last Week</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- notification3 -->
              <div class="manu-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify-1">
                      <div class="bel-icon">
                        <i class="fa-regular fa-bell"></i>
                      </div>
                      <p>
                        Learn all the Dos and Don’ts of Dream Crowd at our May
                        16th <br />
                        Community Standards webinar.
                        <a href="#">Register Now</a>
                      </p>
                      <div class="last-week">
                        <span>Last Week</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- notification4 -->
              <div class="manu-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify-1">
                      <div class="bel-icon">
                        <i class="fa-regular fa-bell"></i>
                      </div>
                      <p>
                        Learn all the Dos and Don’ts of Dream Crowd at our May
                        16th <br />
                        Community Standards webinar.
                        <a href="#">Register Now</a>
                      </p>
                      <div class="last-week">
                        <span>Last Week</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- notification5 -->
              <div class="manu-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify-1">
                      <div class="bel-icon">
                        <i class="fa-regular fa-bell"></i>
                      </div>
                      <p>
                        Learn all the Dos and Don’ts of Dream Crowd at our May
                        16th <br />
                        Community Standards webinar.
                        <a href="#">Register Now</a>
                      </p>
                      <div class="last-week">
                        <span>Last Week</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- notification6 -->
              <div class="manu-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify-1">
                      <div class="bel-icon">
                        <i class="fa-regular fa-bell"></i>
                      </div>
                      <p>
                        Learn all the Dos and Don’ts of Dream Crowd at our May
                        16th <br />
                        Community Standards webinar.
                        <a href="#">Register Now</a>
                      </p>
                      <div class="last-week">
                        <span>Last Week</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- notification7 -->
              <div class="manu-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify-1">
                      <div class="bel-icon">
                        <i class="fa-regular fa-bell"></i>
                      </div>
                      <p>
                        Learn all the Dos and Don’ts of Dream Crowd at our May
                        16th <br />
                        Community Standards webinar.
                        <a href="#">Register Now</a>
                      </p>
                      <div class="last-week">
                        <span>Last Week</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- notification8 -->
              <div class="manu-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify-1">
                      <div class="bel-icon">
                        <i class="fa-regular fa-bell"></i>
                      </div>
                      <p>
                        Learn all the Dos and Don’ts of Dream Crowd at our May
                        16th <br />
                        Community Standards webinar.
                        <a href="#">Register Now</a>
                      </p>
                      <div class="last-week">
                        <span>Last Week</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- notification9 -->
              <div class="manu-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify-1">
                      <div class="bel-icon">
                        <i class="fa-regular fa-bell"></i>
                      </div>
                      <p>
                        Learn all the Dos and Don’ts of Dream Crowd at our May
                        16th <br />
                        Community Standards webinar.
                        <a href="#">Register Now</a>
                      </p>
                      <div class="last-week">
                        <span>Last Week</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- notification10 -->
              <div class="manu-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify-1 notify-last">
                      <div class="bel-icon">
                        <i class="fa-regular fa-bell"></i>
                      </div>
                      <p>
                        Learn all the Dos and Don’ts of Dream Crowd at our May
                        16th <br />
                        Community Standards webinar.
                        <a href="#">Register Now</a>
                      </p>
                      <div class="last-week">
                        <span>Last Week</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- NOTIFICATION END -->
              <!-- pagination start from here -->
              <div class="demo">
                <nav class="pagination-outer" aria-label="Page navigation">
                  <ul class="pagination">
                    <li class="page-item">
                      <a href="#" class="page-link" aria-label="Previous">
                        <span aria-hidden="true">«</span>
                      </a>
                    </li>
                    <li class="page-item active">
                      <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item">
                      <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item">
                      <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                      <a class="page-link" href="#">4</a>
                    </li>
                    <li class="page-item">
                      <a class="page-link" href="#">5</a>
                    </li>
                    <li class="page-item">
                      <a href="#" class="page-link" aria-label="Next">
                        <span aria-hidden="true">»</span>
                      </a>
                    </li>
                  </ul>
                </nav>
              </div>
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

    <script src="assets/admin/libs/jquery/jquery.js"></script>
    <script src="assets/admin/libs/datatable/js/datatable.js"></script>
    <script src="assets/admin/libs/datatable/js/datatablebootstrap.js"></script>
    <script src="assets/admin/libs/select2/js/select2.min.js"></script>
    <script src="assets/admin/libs/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="assets/admin/libs/aos/js/aos.js"></script>
    <script src="assets/admin/asset/js/bootstrap.min.js"></script>
    <script src="assets/admin/asset/js/script.js"></script>
  </body>
</html>
<!-- ================ side js start here=============== -->
<script>
  // Sidebar script
  document.addEventListener("DOMContentLoaded", function () {
    let arrow = document.querySelectorAll(".arrow");
    for (let i = 0; i < arrow.length; i++) {
      arrow[i].addEventListener("click", function (e) {
        let arrowParent = e.target.parentElement.parentElement; // Selecting main parent of arrow
        arrowParent.classList.toggle("showMenu");
      });
    }

    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".bx-menu");

    sidebarBtn.addEventListener("click", function () {
      sidebar.classList.toggle("close");
    });

    // Function to toggle sidebar based on screen size
    function toggleSidebar() {
      let screenWidth = window.innerWidth;
      if (screenWidth < 992) {
        sidebar.classList.add("close");
      } else {
        sidebar.classList.remove("close");
      }
    }

    // Call the function initially
    toggleSidebar();

    // Listen for resize events to adjust sidebar
    window.addEventListener("resize", function () {
      toggleSidebar();
    });
  });
</script>
<!-- ================ side js start End=============== -->

<!-- NOTIFICATION POPUP START HERE-->
<div
  class="modal fade notification-modal"
  id="exampleModalToggle"
  aria-hidden="true"
  aria-labelledby="exampleModalToggleLabel"
  tabindex="-1"
>
  <div class="modal-dialog modal-dialog-centered mt-5">
    <div class="modal-content mt-2">
      <div class="card-header text-center">Send New Notification</div>
      <div class="model_popup">
        <label for="car" class="form-label">Send to</label> <br />
        <select name="" id="">
          <option value="">All Users</option>
          <option value="">Seller Only</option>
          <option value="">Buyer Only</option>
        </select>
        <br />
        <label for="car" class="form-label">Heading</label>
        <input
          class="form-control"
          list="datalistOptions"
          placeholder="write Heading"
        />
        <label for="car" class="form-label">Notification</label>
        <textarea
          class="form-control"
          list="datalistOptions"
          rows="9"
          placeholder="write message for users....."
        ></textarea>
        <button type="button" class="btn1">Cancel</button>
        <button type="button" class="btn2">Send</button>
      </div>
    </div>
  </div>
</div>
