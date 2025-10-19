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
    <title>User Dashboard | Update Card Detail</title>
  </head>
  <style>
    .button{
      color:#0072B1!important;
    }
    .extra-options {
          display: none;
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
                "progressBar" : true
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
                          Update Card Detail
                        </li>
                      </ol>
                    </nav>
                    <!-- <h1 class="dash-title">Dashboard</h1>
                    <i class="fa-solid fa-chevron-right"></i>
                    <h1 class="dash-title">Account Setting</h1>
                    <i class="fa-solid fa-chevron-right"></i>
                    <span class="min-title">Update Card Detail</span> -->
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

              <div class="card-detail-sec">
                <div class="row">
                  
               
                  <div class="col-xl-6 col-lg-12 col-md-12 mb-5">
                    <form action="/update-bank-details" method="POST">
                      @csrf
                    <div class="left-card">
                      <h1>Update Card Detail</h1>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="mb-3">
                            <input
                              type="text" name="holder_name"
                              class="form-control" value="@if($bank_details){{$bank_details->holder_name}}@endif"
                              id="exampleFormControlInput1"
                              placeholder="Card Holder Name" required
                            />
                          </div>
                        </div>

                        <div class="col-md-12">
                          <div class="mb-3">
                            <input onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                              type="text" name="card_number"
                              class="form-control" value="@if($bank_details){{$bank_details->card_number}}@endif"
                              id="exampleFormControlInput1"
                              placeholder="Card Number" required
                            />
                          </div>
                        </div>

                        <div class="col-md-12">
                          <div class="mb-3">
                            <input
                              type="text" name="cvv"
                              class="form-control" value="@if($bank_details){{$bank_details->cvv}}@endif"
                              id="exampleFormControlInput1"
                              placeholder="CVV" required
                            />
                          </div>
                        </div>

                        <div class="col-md-12">
                          <div class="mb-3">
                            <input
                              type="text" name="expiry_date"
                              class="form-control" value="@if($bank_details){{$bank_details->expiry_date}}@endif"
                              id="exampleFormControlInput1"
                              placeholder="Expiry Date" required
                            />
                          </div>
                        </div>

                        <div class="col-md-12">
                          <button type="submit" class="btn">Update</button>
                        </div>
                      </div>
                    </div>
                  </form>
                  </div>
                  <div class="col-xl-6 col-lg-12 col-md-12 mb-5">
                    <div class="right-card">
                      <h1>Current Card Detail</h1>
                      <div class="wrapper acount-card">
                        <div class="debit-card">
                          <div class="d-flex flex-column">
                            <label class="d-block">
                              <div class="d-flex dm-logo">
                                <!-- <h2 class="mb-0">Card Details</h2> -->
                                <img src="assets/user/asset/img/MasterCard.svg" alt="" />
                              </div>
                            </label>
                            <div
                              class="fw-bold d-flex align-items-center justify-content-between"
                            >
                              <p class="card-number mb-0">
                                @if($bank_details){{$bank_details->card_number}} @else Add Card Detail @endif
                              </p>
                            </div>
                            <div class="d-flex card-botm">
                              <div>
                                @if($bank_details)
                                <p class="mb-0 info">Name</p>
                                <p class="mb-0 read">{{$bank_details->holder_name}}  </p>
                                @endif
                              </div>
                              <div>
                                @if($bank_details)
                                <p class="mb-0 info">Valid Till</p>
                                <p class="mb-0 read">{{$bank_details->expiry_date}}</p>
                                @endif
                              </div>
                              <div>
                                <!-- <img src="assets/user/asset/img/MasterCard.svg" alt="" /> -->
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      @if($bank_details)
                      <div class="credit-btn">
                        <a href="/delete-bank-details/{{$bank_details->id}}">
                        <button type="button" class="btn">Delete</button>
                      </a>
                      </div>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="copyright">
              <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
            </div>
          </div>
        </div>
      </div>
     
 <!-- radio js here -->
 <script>
  function showAdditionalOptions1() {
      hideAllAdditionalOptions();
      document.getElementById('additionalOptions1').style.display = 'block';
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
 <!-- JavaScript to close the modal when Cancel button is clicked -->
<script>
  // Wait for the document to load
  document.addEventListener('DOMContentLoaded', function() {
    // Get the Cancel button by its ID
    var cancelButton = document.getElementById('cancelButton');

    // Add a click event listener to the Cancel button
    cancelButton.addEventListener('click', function() {
      // Find the modal by its ID
      var modal = document.getElementById('exampleModal3');
      
      // Use Bootstrap's modal method to hide the modal
      $(modal).modal('hide');
    });
  });
</script>
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
     <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  </body>
</html>
<!-- modal hide show jquery here -->
<script>
  $(document).ready(function() {
      $(document).on('click', '#delete-account', function(e) {
          e.preventDefault();
          $('#exampleModal3').modal('show');
          $('#delete-user-account').modal('hide'); 
      });

      $(document).on('click', '#delete-account', function(e) {
          e.preventDefault();
          $('#delete-user-account').modal('show');
          $('#exampleModal3').modal('hide'); 
      });
  });
</script>
<!-- ================ side js start here=============== -->
<script>
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

  // Check if "Account Settings" dropdown should be open
  let accountSettingsItem = document.querySelector(".nav-links li:last-child");
  let accountSettingsDropdown = accountSettingsItem.querySelector(".sub-menu");
  
  if (localStorage.getItem("accountSettingsOpen") === "true") {
    accountSettingsItem.classList.add("active");
    accountSettingsDropdown.style.display = "block";
  }

  // Toggle "Account Settings" dropdown on click
  accountSettingsItem.addEventListener("click", function() {
    accountSettingsItem.classList.toggle("active");
    accountSettingsDropdown.style.display = accountSettingsItem.classList.contains("active") ? "block" : "none";
    localStorage.setItem("accountSettingsOpen", accountSettingsItem.classList.contains("active"));
  });
});

</script>
<!-- ================ side js start End=============== -->

<!-- ======================================= -->
<!-- start -->
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
      options.forEach((option) => { option.classList.remove('selected') });
      // select.querySelector("span").innerHTML = option.innerHTML;
      option.classList.add("selected");
      options_list.classList.toggle("active");
      select.querySelector(".fa-angle-down").classList.toggle("fa-angle-up");
    });
  });
</script>


<!--  end -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
  var dropdownBtns = document.getElementsByClassName("dropdown-btn");
  
  for (var i = 0; i < dropdownBtns.length; i++) {
    dropdownBtns[i].addEventListener("click", function() {
      var dropdownContent = this.nextElementSibling;
      if (dropdownContent.style.display === "block") {
        dropdownContent.style.display = "none";
      } else {
        dropdownContent.style.display = "block";
      }
    });
  }
});

</script>


<script>
  jQuery(document).ready(function () {
  buttonFunction();
});

function buttonFunction() {
  jQuery(".button").on("click", function () {
    jQuery(this).siblings().removeClass("active");
    jQuery(this).siblings().html("Button");
    jQuery(this).toggleClass("active");
    jQuery(this).html("Active");
  });
}

</script>


