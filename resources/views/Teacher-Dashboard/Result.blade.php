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
    <link rel="stylesheet" type="text/css" href="assets/teacher/asset/css/bootstrap.min.css" />
     <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
     <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
      <!-- Fontawesome CDN -->
      <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
   <!-- jQuery -->
   <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        

   {{-- =======Toastr CDN ======== --}}
   <link rel="stylesheet" type="text/css" 
   href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

   <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
   {{-- =======Toastr CDN ======== --}}
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/teacher/asset/css/class-management.css" />
    <link rel="stylesheet" href="assets/teacher/asset/css/Result.css">
    <link rel="stylesheet" href="assets/teacher/asset/css/sidebar.css">
    <link rel="stylesheet" href="assets/teacher/asset/css/Dashboard.css">
    <link rel="stylesheet" href="assets/teacher/asset/css/style.css">

</head>

<body>

  
  @if (Session::has('error'))
  <script>

        toastr.options =
          {
              "closeButton" : true,
               "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
          }
                  toastr.error("{{ session('error') }}");

                  
  </script>
  @endif
  @if (Session::has('success'))
  <script>

        toastr.options =
          {
              "closeButton" : true,
               "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
          }
                  toastr.success("{{ session('success') }}");

                  
  </script>
  @endif

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
              <i class='bx bxs-graduation icon'title="Class Management" ></i>
                                        
                                        <h2>Class Management</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <!-- ============== Underline Tabs Start============= -->
                            <div class="No-result-card">
                                <div class="Card-Inner">
                                    <img class="result-img" src="assets/teacher/asset/img/Frame 1707480426.png" alt="">
                                    <h2>No Result</h2>
                                    <p>We couldn't find any available Service. Try to manage new services</p>
                                    
                                   <a href="/class-service-select"   ><button class="No-btn">Add New Service +</button></a> 
                                </div>
                            </div>
                        </div>
                        <!-- ============== Underline Tabs End============= -->
                        <!-- Blue MASSEGES section -->
            
            
                    </div>
                    <div class="text-center copyright-sec">
                      <p class="mb-0">Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
                    </div>
                </div>
        <!-- =============================== MAIN CONTENT END HERE =========================== -->
      </section>
    
    </section>
    </div>
    </div>
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
    <!-- ================ side js start here=============== -->
<!-- ================ side js start End=============== -->
     

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
 <!-- JavaScript to close the modal when Cancel button is clicked -->
<script>
  // Wait for the document to load
  document.addEventListener('DOMContentLoaded', function() {
    // Get the Cancel button by its ID
    var cancelButton = document.getElementById('cancelButton');

    // Add a click event listener to the Cancel button
    cancelButton.addEventListener('click', function() {
      // Find the modal by its ID
      var modal = document.getElementById('exampleModal6');
      
      // Use Bootstrap's modal method to hide the modal
      $(modal).modal('hide');
    });
  });
</script>
    <script>
        $(document).ready(function() {
            $('.owl-carousel').owlCarousel({
                items: 4,
                margin: 30
            });
        })
    </script>

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
<!--========== Underline tabes JS Start========== -->
<script>
    function feature(e, featureClassName) {
        var element = document.getElementsByClassName('tab-item');
        for (var i = 0; i < element.length; i++) {
            var shouldBeActive = element[i].classList.contains(featureClassName);
            element[i].classList.toggle('active', shouldBeActive);
        }
    }
</script>
<!--========== Underline tabes JS END =========== -->
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
</html>