<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <!-- View Point scale to 1.0 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Animate css -->
    <link rel="stylesheet" href="assets/user/libs/animate/css/animate.css" />
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="assets/user/libs/aos/css/aos.css" />
    <!-- Datatable css  -->
    <link rel="stylesheet" href="assets/user/libs/datatable/css/datatable.css" />
     {{-- Fav Icon --}}
     @php  $home = \App\Models\HomeDynamic::first(); @endphp
     @if ($home)
         <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
     @endif
     <!-- Select2 css -->
    <link href="assets/user/libs/select2/css/select2.min.css" rel="stylesheet" />
    <!-- Owl carousel css -->
    <link href="assets/user/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
    <link href="assets/user/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
    <!-- Bootstrap css -->
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/user/asset/css/bootstrap.min.css"
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
    <link rel="stylesheet" href="assets/user/asset/css/new.css" />
    <link rel="stylesheet" type="text/css" href="assets/user/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/user/asset/css/style.css" />
    <title>User Dashboard | Notification</title>
  </head>
  <body>
    {{-- ===========User Sidebar Start==================== --}}
  <x-user-sidebar/>
  {{-- ===========User Sidebar End==================== --}}
  <section class="home-section">
     {{-- ===========User NavBar Start==================== --}}
     <x-user-nav/>
     {{-- ===========User NavBar End==================== --}}
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
                      <i class="bx bx-bell icon" title="Notifications"></i>
                      <h2>Notifications</h2>
                    </div>
                  </div>
                </div>
              </div>
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
              <!-- footer -->
              <div class="copyright">
                <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- =============================== MAIN CONTENT END HERE =========================== -->
    </section>

    <script src="assets/user/libs/jquery/jquery.js"></script>
    <script src="assets/user/libs/datatable/js/datatable.js"></script>
    <script src="assets/user/libs/datatable/js/datatablebootstrap.js"></script>
    <script src="assets/user/libs/select2/js/select2.min.js"></script>
    <script src="assets/user/libs/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="assets/user/libs/aos/js/aos.js"></script>
    <script src="assets/user/asset/js/bootstrap.min.js"></script>
    <script src="assets/user/asset/js/script.js"></script>
    <!-- jQuery -->
    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"
    ></script>
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


<!-- radio js here -->
<script>
  function showAdditionalOptions1() {
    hideAllAdditionalOptions();
    document.getElementById("additionalOptions1").style.display = "block";
  }

  function showAdditionalOptions2() {
    hideAllAdditionalOptions();
    document.getElementById("additionalOptions2").style.display = "block";
  }

  function showAdditionalOptions3() {
    hideAllAdditionalOptions();
  }

  function showAdditionalOptions4() {
    hideAllAdditionalOptions();
    document.getElementById("additionalOptions4").style.display = "block";
  }

  function hideAllAdditionalOptions() {
    var elements = document.getElementsByClassName("additional-options");
    for (var i = 0; i < elements.length; i++) {
      elements[i].style.display = "none";
    }
  }

  // Call the function to show the additional options for the default checked radio button on page load
  window.onload = function () {
    showAdditionalOptions1();
  };
</script>
<!-- modal hide show jquery here -->
<script>
  $(document).ready(function () {
    $(document).on("click", "#delete-account", function (e) {
      e.preventDefault();
      $("#exampleModal3").modal("show");
      $("#delete-user-account").modal("hide");
    });

    $(document).on("click", "#delete-account", function (e) {
      e.preventDefault();
      $("#delete-user-account").modal("show");
      $("#exampleModal3").modal("hide");
    });
  });
</script>
<!-- JavaScript to close the modal when Cancel button is clicked -->
<script>
  // Wait for the document to load
  document.addEventListener("DOMContentLoaded", function () {
    // Get the Cancel button by its ID
    var cancelButton = document.getElementById("cancelButton");

    // Add a click event listener to the Cancel button
    cancelButton.addEventListener("click", function () {
      // Find the modal by its ID
      var modal = document.getElementById("exampleModal3");

      // Use Bootstrap's modal method to hide the modal
      $(modal).modal("hide");
    });
  });
</script>
