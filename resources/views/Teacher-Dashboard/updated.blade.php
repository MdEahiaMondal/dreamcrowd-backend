<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <!-- View Point scale to 1.0 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Management</title>
    

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
    
    <!-- Defualt css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
<!-- Bootstrap css -->
<link rel="stylesheet" type="text/css" href="assets/teacher/asset/css/bootstrap.min.css" />
<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
<!-- Fontawesome CDN -->
<script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
<!-- Defualt css -->
<link rel="stylesheet" type="text/css" href="assets/teacher/asset/css/sidebar.css" />
<link rel="stylesheet" href="assets/teacher/asset/css/style.css">
<link rel="stylesheet" href="assets/teacher/asset/css/Dashboard.css">
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
                <!-- Update Modal Start -->
  <section id="hero_section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 class-management-section">
              <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                  <li class="breadcrumb-item">Class Management</li>
                </ol>
              </nav>
              <div class="row">
                <div class="col-md-12 class-management">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <g clip-path="url(#clip0_3103_51574)">
                      <path d="M12.9785 4.87872C13.226 5.1272 13.4121 5.42999 13.522 5.76301L13.8778 6.85586C13.9077 6.93992 13.9628 7.01266 14.0357 7.0641C14.1086 7.11554 14.1957 7.14316 14.2849 7.14316C14.3741 7.14316 14.4611 7.11554 14.534 7.0641C14.6069 7.01266 14.6621 6.93992 14.692 6.85586L15.0478 5.76301C15.1583 5.43069 15.3448 5.12876 15.5926 4.88125C15.8404 4.63374 16.1425 4.44748 16.4749 4.33729L17.5678 3.98229C17.6518 3.95239 17.7246 3.8972 17.776 3.8243C17.8274 3.7514 17.855 3.66437 17.855 3.57515C17.855 3.48593 17.8274 3.3989 17.776 3.326C17.7246 3.2531 17.6518 3.19791 17.5678 3.16801L17.5463 3.16229L16.4528 2.80729C16.1204 2.69691 15.8184 2.51058 15.5707 2.2631C15.323 2.01561 15.1363 1.71379 15.0256 1.38158L14.6706 0.288722C14.641 0.204338 14.586 0.13123 14.513 0.0795063C14.4401 0.0277828 14.3529 0 14.2635 0C14.1741 0 14.0868 0.0277828 14.0139 0.0795063C13.941 0.13123 13.8859 0.204338 13.8563 0.288722L13.5006 1.38158L13.4913 1.40872C13.3803 1.7327 13.1968 2.02707 12.9548 2.26942C12.7128 2.51178 12.4187 2.69574 12.0949 2.80729L11.002 3.16229C10.918 3.1922 10.8452 3.24739 10.7938 3.32029C10.7424 3.39318 10.7147 3.48022 10.7147 3.56944C10.7147 3.65865 10.7424 3.74569 10.7938 3.81859C10.8452 3.89148 10.918 3.94667 11.002 3.97658L12.0949 4.33158C12.4285 4.44301 12.7306 4.63015 12.9785 4.87872ZM19.157 7.39944L19.8128 7.61229L19.8263 7.61515C19.8771 7.63276 19.9211 7.66575 19.9523 7.70953C19.9834 7.75331 20.0001 7.80571 20.0001 7.85944C20.0001 7.91317 19.9834 7.96556 19.9523 8.00934C19.9211 8.05312 19.8771 8.08611 19.8263 8.10372L19.1699 8.31729C18.9706 8.38353 18.7896 8.49529 18.641 8.64371C18.4925 8.79212 18.3806 8.9731 18.3142 9.17229L18.1006 9.82801C18.0827 9.87844 18.0496 9.92209 18.0058 9.95295C17.9621 9.98381 17.9099 10.0004 17.8563 10.0004C17.8028 10.0004 17.7506 9.98381 17.7068 9.95295C17.6631 9.92209 17.63 9.87844 17.612 9.82801L17.3985 9.17229C17.3326 8.97241 17.2209 8.79069 17.0723 8.64162C16.9238 8.49256 16.7424 8.38027 16.5428 8.31372L15.8863 8.10086C15.8356 8.08325 15.7915 8.05026 15.7604 8.00648C15.7292 7.96271 15.7125 7.91031 15.7125 7.85658C15.7125 7.80285 15.7292 7.75045 15.7604 7.70667C15.7915 7.66289 15.8356 7.62991 15.8863 7.61229L16.5428 7.39872C16.7396 7.33079 16.9181 7.21827 17.0643 7.06996C17.2105 6.92164 17.3205 6.74155 17.3856 6.54372L17.5992 5.88801C17.6171 5.83757 17.6502 5.79393 17.694 5.76306C17.7377 5.7322 17.7899 5.71563 17.8435 5.71563C17.897 5.71563 17.9492 5.7322 17.993 5.76306C18.0367 5.79393 18.0698 5.83757 18.0878 5.88801L18.3006 6.54372C18.367 6.74305 18.479 6.92413 18.6277 7.07256C18.7763 7.22099 18.9576 7.33339 19.157 7.39944ZM8.4049 2.49729C8.83387 2.23247 9.32205 2.07864 9.82536 2.04971C10.3287 2.02078 10.8313 2.11765 11.2878 2.33158L10.777 2.50015C10.5486 2.57638 10.3507 2.72415 10.2128 2.92158C10.1678 2.98372 10.1299 3.05015 10.0985 3.11872C9.70088 3.09849 9.30653 3.19963 8.96775 3.40872L2.6049 7.33444L8.92418 11.4666C9.24377 11.6756 9.61734 11.7868 9.99918 11.7868C10.381 11.7868 10.7546 11.6756 11.0742 11.4666L15.3942 8.64158C15.4718 8.69751 15.5576 8.74112 15.6485 8.77086L16.3199 8.99229C16.4116 9.02231 16.4949 9.07373 16.5628 9.14229L16.572 9.15158L15.7135 9.71301V14.4644C15.7135 14.6759 15.5978 14.8073 15.4613 14.9402C15.3935 15.0059 15.2963 15.0973 15.1692 15.2059C14.8252 15.4993 14.4573 15.7633 14.0692 15.9951C13.1178 16.5673 11.7285 17.1437 9.99918 17.1437C8.27061 17.1437 6.88061 16.5673 5.92918 15.9959C5.54108 15.764 5.17312 15.5 4.82918 15.2066C4.72872 15.1212 4.63105 15.0326 4.53633 14.9409C4.40061 14.8073 4.2849 14.6787 4.2849 14.4651V9.71372L2.14204 8.31301V12.6794C2.14204 12.8215 2.0856 12.9578 1.98513 13.0582C1.88467 13.1587 1.74841 13.2151 1.60633 13.2151C1.46425 13.2151 1.32798 13.1587 1.22752 13.0582C1.12705 12.9578 1.07061 12.8215 1.07061 12.6794V7.50086C1.07061 7.47015 1.07347 7.44015 1.07775 7.41158C1.06005 7.30646 1.07411 7.19844 1.11813 7.10135C1.16216 7.00427 1.23415 6.92252 1.3249 6.86658L8.4049 2.49801V2.49729ZM5.35633 10.4144V14.2416C5.70217 14.5568 6.07855 14.8367 6.4799 15.0773C7.31418 15.5773 8.51418 16.0723 9.99918 16.0723C11.4849 16.0723 12.6849 15.5773 13.5185 15.0773C13.9198 14.8367 14.2962 14.5568 14.642 14.2416V10.4144L11.6606 12.3644C11.1667 12.6874 10.5893 12.8594 9.99918 12.8594C9.40903 12.8594 8.83167 12.6874 8.33775 12.3644L5.35633 10.4144Z" fill="white"/>
                    </g>
                    <defs>
                      <clipPath id="clip0_3103_51574">
                        <rect width="20" height="20" fill="white"/>
                      </clipPath>
                    </defs>
                  </svg>
                  <h5>Class Management</h5>
                </div>
              </div>
              
    <div class="content">
    <h2>Link Your Zoom Account with DreamCrowd</h2>
    <a href="thankyou.html"><button class="btn zoom-account-btn">Link Zoom Account</button></a>
    <button class="btn create-account-btn">Create New Account</button>
  </div>
          </div>
        </div>
      </div>
      <div class="useer-foter text-center">
        <p class="mb-0">Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
      </div>
    </div>
  </section>
  
    <!-- =============================== MAIN CONTENT END HERE =========================== -->
  </section>


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