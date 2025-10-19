<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <!-- View Point scale to 1.0 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Animate css -->
    <link rel="stylesheet" href="assets/teacher/libs/animate/css/animate.css" />
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="assets/teacher/libs/aos/css/aos.css" />
    <!-- Datatable css  -->
    <link rel="stylesheet" href="assets/teacher/libs/datatable/css/datatable.css" />
     {{-- Fav Icon --}}
     @php  $home = \App\Models\HomeDynamic::first(); @endphp
     @if ($home)
         <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
     @endif
     <!-- Select2 css -->
    <link href="assets/teacher/libs/select2/css/select2.min.css" rel="stylesheet" />
    <!-- Owl carousel css -->
    <link href="assets/teacher/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
    <link href="assets/teacher/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
    <!-- Bootstrap css -->
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/teacher/asset/css/bootstrap.min.css"
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
    <link rel="stylesheet" type="text/css" href="assets/teacher/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/teacher/asset/css/style.css" />

    <link rel="stylesheet" href="assets/teacher/asset/css/Dashboard.css" />
    <title>User Dashboard |</title>
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
      <div class="container-fluid control">
        <div class="row">
          <div class="col-md-12">
            <div class="Host_Guidelines">
              <span class="heading">Dashboard</span>
              <i class="fa-solid fa-chevron-right"></i>
              <span class="paragraph">Host Guidelines</span>
            </div>
            <div class="Guidelines">
              <i class="bx bx-list-ul icon" title="Host Guidelines"></i>
              <span class="row__title">Host Guidelines</span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="Page-Account">
              <h2>Host Guidelines</h2>

              <div class="main">
                <div class="row">

                  @if ($host)
                  @foreach ($host as $item)
                      
                  <div class="col-lg-4 col-md-6">
                    <a href="/host-heading/{{$item->id}}">
                      <div class="card">
                        <div class="card-body" >
                          <h5 class="card-title" >
                            {{$item->heading}}
                          </h5>
                          <div class="card-text" style="min-height: 50px;max-height: 50px; overflow: hidden;" >
                             {!! Str::limit($item->detail, 155) !!}
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>

                  @endforeach
                      
                  @endif
                  

                </div>
              </div>
            </div>
            <div class="para">
              <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
            </div>
          </div>
        </div>
      </div>
      <!-- =============================== MAIN CONTENT END HERE =========================== -->
    </section>
   

    <script src="assets/teacher/libs/jquery/jquery.js"></script>
    <script src="assets/teacher/libs/datatable/js/datatable.js"></script>
    <script src="assets/teacher/libs/datatable/js/datatablebootstrap.js"></script>
    <script src="assets/teacher/libs/select2/js/select2.min.js"></script>
    <script src="assets/teacher/libs/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="assets/teacher/libs/aos/js/aos.js"></script>
    <script src="assets/teacher/assets/js/bootstrap.min.js"></script>
    <script src="assets/teacher/assets/js/script.js"></script>
    <!-- jQuery -->
    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"
    ></script>
  </body>
</html>
<!-- modal hide show jquery here -->
<script>
  $(document).ready(function () {
    $(document).on("click", "#delete-account", function (e) {
      e.preventDefault();
      $("#exampleModal7").modal("show");
      $("#delete-teacher-account").modal("hide");
    });

    $(document).on("click", "#delete-account", function (e) {
      e.preventDefault();
      $("#delete-teacher-account").modal("show");
      $("#exampleModal7").modal("hide");
    });
  });
</script>
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

