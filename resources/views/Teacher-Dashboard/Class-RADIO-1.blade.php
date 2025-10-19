<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    
    <!-- View Point scale to 1.0 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Animate css -->
    <link rel="stylesheet" href="assets/teacher/libs/animate/css/animate.css" />
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="assets/teacher/libs/aos/css/aos.css" />
     {{-- Fav Icon --}}
     @php  $home = \App\Models\HomeDynamic::first(); @endphp
     @if ($home)
         <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
     @endif
     <!-- Datatable css  -->
    <link rel="stylesheet" href="assets/teacher/libs/datatable/css/datatable.css" />
    <!-- Select2 css -->
    <link href="assets/teacher/libs/select2/css/select2.min.css" rel="stylesheet" />
    <!-- Owl carousel css -->
    <link href="assets/teacher/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
    <link href="assets/teacher/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="assets/teacher/asset/css/bootstrap.min.css" />
     <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
     <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
   
    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
   
    <!-- Defualt css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="assets/teacher/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/teacher/asset/css/Class-RADIO-1.css">
    <link rel="stylesheet" href="assets/teacher/asset/css/Dashboard.css">
    <link rel="stylesheet" href="assets/teacher/asset/css/style.css">

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
                                  <span class="min-title">Class Management</span>
                                  </div>
                              </div>
                          </div>
                          <!-- Blue MASSEGES section -->
                  <div class="user-notification">
                      <div class="row">
                          <div class="col-md-12">
                              <div class="notify">
                                  <i class='bx bx-bell-minus'></i>
                                  <h2>Class Management</h2>
                              </div>
                          </div>
                      </div>
                  </div>
                   



              <section id="hero_section">
                <div class="container-fluid">
                    <div class="row card-radio">
                      <div class="col-md-12">
                <div class="content">
                <h2>How would you like the service delivered</h2>
                <form action="/select-service-type" method="POST"> @csrf

               
                <div class="content-box">
                  <div class="radio-inputs">
                    <label>
                      <input class="" type="hidden" value="{{$role}}" name="role">
                      <input class="radio-input" type="radio" value="Online" name="engine">
                    {{-- <a href="Learn-How.html"> --}}
                      <span class="radio-tile">
                          <span class="radio-icon">
                            <img src="assets/teacher/asset/img/lcd.png" alt="....">
                          </span>
                          <span class="radio-label">Online</span>
                        </span>
                      {{-- </a> --}}
                    </label>
                    <label>
                      <input checked="" class="radio-input" type="radio" value="Inperson" name="engine">
                      {{-- <a href="Learn-How - 2.html">  --}}
                      <span class="radio-tile">
                        <span class="radio-icon">
                          <img src="assets/teacher/asset/img/Mask group.png" alt="..">                
                        </span>
                        <span class="radio-label">In-Person</span>
                      </span>
                      {{-- </a> --}}
                    </label>
                    </div>
                </div>
                <button type="submit"  name="action" value="Type" class="btn">Next</button>
              </form>
              </div>
                      </div>
                    </div>
                  </div>
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
  <!-- <script src="assets/teacher/libs/owl-carousel/js/jquery.min.js"></script> -->
  <script src="assets/teacher/libs/owl-carousel/js/owl.carousel.min.js"></script>
  <!-- jQuery -->
    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"
    ></script>
  
  <script>
    $(document).ready(function(){
        $('.owl-carousel').owlCarousel({
            items : 4,
            margin : 30
        });
})
</script>
<!-- ================ side js start here=============== -->
<script>
  // Sidebar script
document.addEventListener("DOMContentLoaded", function() {
  let arrow = document.querySelectorAll(".arrow");
  for (let i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", function(e) {
      let arrowParent = e.target.parentElement.parentElement; // Selecting main parent of arrow
      arrowParent.classList.toggle("showMenu");
    });
  }

  let sidebar = document.querySelector(".sidebar");
  let sidebarBtn = document.querySelector(".bx-menu");

  sidebarBtn.addEventListener("click", function() {
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
  window.addEventListener("resize", function() {
    toggleSidebar();
  });
});

</script>
<!-- ================ side js start End=============== -->

<script>

    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
    
    </script>
    <script>
        new DataTable('#example', {
    scrollX: true
});
    </script>
      
      <script src="libs/aos/js/aos.js"></script>
      <script>
          AOS.init();
          </script>
<script src="assets/js/bootstrap.min.js"></script>
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
<!-- radio js here -->
<script>
  function showAdditionalOptions1() {
      hideAllAdditionalOptions();
  }

  function showAdditionalOptions2() {
      hideAllAdditionalOptions();
      document.getElementById('additionalOptions2').style.display = 'block';
  }

  function showAdditionalOptions3() {
      hideAllAdditionalOptions();
  }

  function showAdditionalOptions4() {
      hideAllAdditionalOptions();
      document.getElementById('additionalOptions4').style.display = 'block';
  }

  function hideAllAdditionalOptions() {
      var elements = document.getElementsByClassName('additional-options');
      for (var i = 0; i < elements.length; i++) {
          elements[i].style.display = 'none';
      }
  }

  // Call the function to show the additional options for the default checked radio button on page load
  window.onload = function() {
      showAdditionalOptions1();
  };
</script>