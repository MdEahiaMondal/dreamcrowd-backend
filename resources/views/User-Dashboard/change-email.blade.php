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
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    
    
   {{-- =======Toastr CDN ======== --}}
 <link rel="stylesheet" type="text/css" 
 href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
 {{-- =======Toastr CDN ======== --}}

    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/user/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/user/asset/css/style.css" />
    <title>User Dashboard | Change Email</title>
  </head>
  <style>
    .loading-spinner {
       position: relative;
       right: 23px;
       bottom: -3px;
           display: none; /* Initially hidden */
           width: 20px;
           height: 20px;
           border: 3px solid #f3f3f3;
           border-radius: 50%;
           border-top: 3px solid #3498db;
           animation: spin 1s linear infinite;
           margin-left: 10px;
       }

       @keyframes spin {
           0% { transform: rotate(0deg); }
           100% { transform: rotate(360deg); }
       }
</style>
  <style>
    .button {
      color: #0072b1 !important;
    }
  </style>
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
                    <nav
                      style="--bs-breadcrumb-divider: '>'"
                      aria-label="breadcrumb"
                    >
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item dash-title">
                          <a href="#">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item dash-title">
                          <a href="#">Account Setting</a>
                        </li>
                        <li
                          class="breadcrumb-item active min-title"
                          aria-current="page"
                        >
                          Change Email
                        </li>
                      </ol>
                    </nav>
                    <!-- <h1 class="dash-title">Dashboard</h1>
                    <i class="fa-solid fa-chevron-right"></i>
                    <h1 class="dash-title">Account Setting</h1>
                    <i class="fa-solid fa-chevron-right"></i>
                    <span class="min-title">Change Email</span> -->
                  </div>
                </div>
              </div>
              <!-- Blue MASSEGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <i class="bx bx-cog icon" title="Account Settings"></i>
                      <h2>Account Settings</h2>
                    </div>
                  </div>
                </div>
              </div>

              <form action="/update-email" method="POST"> 
                @csrf
             
                <div class="drop-mail-sec">
                  <div class="row">
                    <h1>Change Email</h1>
                    <div class="col-md-12">
                      <div class="mb-3">
                        <input
                          type="email" name="email" value="{{Auth::user()->email}}"
                          class="form-control" required
                          id="email"
                          placeholder="Current Email"
                        />
                      </div>
                    </div>
  
                    <div class="col-md-12">
                      <div class="input-group mb-3">
                        <input
                          type="email" name="new_email"
                          class="form-control"
                          placeholder="New Email" required
                          aria-label="Recipient's username"
                          aria-describedby="basic-addon2"
                        />
                        <span onclick="SendCode(this.id)" id="Send_Code_Mail" class="input-group-text" id="basic-addon2" style="cursor: pointer;"
                          >Send</span>
                          <div id="loadingSpinner" class="loading-spinner"></div>
                      </div>
                    </div>
  
                    <div class="col-md-12">
                      <div class="mb-3">
                        <input
                          type="text" name="code"
                          class="form-control"
                          id="exampleFormControlInput1"
                          placeholder="Security Code"
                        />
                        <p>
                          <i class="bx bx-info-circle"></i> Check you inbox for
                          Security code
                        </p>
                      </div>
                    </div>
  
                    <div class="col-md-12">
                      <button type="submit" class="btn">Update</button>
                    </div>
                  </div>
  
                </form>
            </div>
            <div class="copyright">
              <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
            </div>
          </div>
        </div>
      </div>
      <!-- =============================== MAIN CONTENT END HERE =========================== -->
    </section>

    <script src="assets/user/libs/jquery/jquery.js"></script>
    <script src="assets/user/libs/datatable/js/datatable.js"></script>
    <script src="libs/datatable/js/datatablebootstrap.js"></script>
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



{{-- Send Email COde Script Ajax Start ======== --}}
<script>

  function SendCode(Clicked) { 
  
   var email =  $('#email').val();
   if (email == '') {
    toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.error("Please Add Current Email!");
  
                    return false;
   }
  
   const button = document.getElementById(Clicked);
            const spinner = document.getElementById('loadingSpinner');
            $(button).html('Waiting');
            button.disabled = true;
  
       // Ajax Token
       $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
              });
              // Ajax Call
              $.ajax({
                  type: "POST",
                  url: "/change-email-send-code",
                  data:{email:email,  _token: '{{csrf_token()}}'},
                  dataType : 'json',
                  success: function (response) {

                    $(button).html('Send');
                button.disabled = false;
                spinner.style.display = 'none';

                if (response.success) {
                  toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.success(response.message);
  
                } else if(response.error) {
                          toastr.options =
                    {
                        "closeButton" : true,
                         "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                    }
                            toastr.error(response.message);
  
                }
                  }
              });
  
  
  
  
  
   }
  
  </script>
  {{-- Send Email COde Script Ajax END ======== --}}

  


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
<!--  -->
<script>
  const select = document.querySelector(".select");
  const options_list = document.querySelector(".options-list");
  const options = document.querySelectorAll(".option");

  //show & hide options list
  select.addEventListener("click", () => {
    options_list.classList.toggle("active");
    select.querySelector(".fa-angle-down").classList.toggle("fa-angle-up");
  });
  //select option
  options.forEach((option) => {
    option.addEventListener("click", () => {
      options.forEach((option) => {
        option.classList.remove("selected");
      });
      // select.querySelector("span").innerHTML = option.innerHTML;
      option.classList.add("selected");
      options_list.classList.toggle("active");
      select.querySelector(".fa-angle-down").classList.toggle("fa-angle-up");
    });
  });
</script>
<!--  -->

<!-- ================ side js start here=============== -->

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
