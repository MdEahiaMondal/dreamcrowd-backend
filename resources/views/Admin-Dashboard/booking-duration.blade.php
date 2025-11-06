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
     <!-- jQuery -->
     <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    

     {{-- =======Toastr CDN ======== --}}
     <link rel="stylesheet" type="text/css" 
     href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
     
     <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
     {{-- =======Toastr CDN ======== --}}
    <!-- boxicons -->
    <link
      href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
    />
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
    <!-- file upload link -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />

    <!-- js -->
    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"
    ></script>
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/admin/asset/css/style.css" />
    <link rel="stylesheet" href="assets/user/asset/css/style.css" />
    <link rel="stylesheet" href="assets/admin/asset/css/about-us.css" />
    <title>Super Admin Dashboard | Dynamic Management-Booking Duration</title>
  </head>
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
                    <h1 class="dash-title">Dynamic Management</h1>
                    <i class="fa-solid fa-chevron-right"></i>
                    <span class="min-title">Booking Duration</span>
                  </div>
                </div>
              </div>
              <!-- Blue MASSEGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <img src="assets/admin/asset/img/dynamic-management.svg" alt="" />
                      <h2>Booking Duration</h2>
                    </div>
                  </div>
                </div>
              </div>
              <!-- ============ -->
              <div class="send-notify">
                <div class="row">
                  <div class="col-md-12">
                    <h1>Edit Booking Duration</h1>
                  </div>
                </div>
              </div>
              <!-- =============== -->
              <!-- ========= PRIVACY POLICY FORM SECTION START FROM HERE ========== -->
              <div class="form-section conditions">
                <div class="row major-section">
                  <div class="col-md-12">
                    <form id="form_submit" method="POST" action="/admin-booking-duration-update">
                      @csrf
                      <div class="row">
                      <div class="col-6 form-sec">
                        <label for="class_online" class="form-label"
                          >Class Online (Hours)
                        </label>
                        <input
                          type="number"
                          class="form-control" @if ($duration) value="{{$duration->class_online}}" @endif
                          id="class_online" name="class_online"
                          placeholder="1 - 10"
                        />
                      </div>
                      <div class="col-6 form-sec">
                        <label for="class_inperson" class="form-label"
                          >Class Inperson (Hours)
                        </label>
                        <input
                          type="number"
                          class="form-control" @if ($duration) value="{{$duration->class_inperson}}" @endif
                          id="class_inperson" name="class_inperson"
                          placeholder="1 - 10"
                        />
                      </div>
                      <div class="col-6 form-sec">
                        <label for="class_inperson" class="form-label"
                          >Class One Day (Hours)
                        </label>
                        
                        <input
                          type="number"
                          class="form-control" @if ($duration) value="{{$duration->class_oneday}}" @endif
                           id="class_oneday" name="class_oneday"
                          placeholder="1 - 10"
                        />
                      </div>
                      <div class="col-6 form-sec">
                        <label for="class_inperson" class="form-label"
                          >Reschedule Timing & Refund Timing (Hours)
                        </label>
                        <select class="form-control form-select" name="reschedule" id="reschedule">
                          @if ($duration) <option value="{{$duration->reschedule}}">{{$duration->reschedule}} Hours Before</option>   @endif
                          <option value="12">12 Hours Before</option>
                          <option value="24">24 Hours Before</option>
                          <option value="48">48 Hours Before</option>
                        </select>
                        
                      </div>
                      <div class="col-6 form-sec">
                        <label for="freelance_online_normal" class="form-label"
                          >Freelance Online Normal (Hours)
                        </label>
                        <input
                          type="number"
                          class="form-control" @if ($duration) value="{{$duration->freelance_online_normal}}" @endif
                          id="freelance_online_normal" name="freelance_online_normal"
                          placeholder="1 - 10"
                        />
                      </div>
                      <div class="col-6 form-sec">
                        <label for="freelance_online_consultation" class="form-label"
                          >Freelance Online Consultation (Hours)
                        </label>
                        <input
                          type="number"
                          class="form-control" @if ($duration) value="{{$duration->freelance_online_consultation}}" @endif
                          id="freelance_online_consultation" name="freelance_online_consultation"
                          placeholder="1 - 10"
                        />
                      </div>
                      <div class="col-12 form-sec">
                        <label for="freelance_inperson" class="form-label"
                          >Freelance Inperson  Normal & Consultation (Hours)
                        </label>
                        <input
                          type="number"
                          class="form-control" @if ($duration) value="{{$duration->freelance_inperson}}" @endif
                          id="freelance_inperson" name="freelance_inperson"
                          placeholder="1 - 10"
                        />
                      </div>
                    </div>

                      <div  class="float-end">

                        <button  class="btn update-btn text-white" type="button" id="updateButton">Update</button>
                      </div>
                    
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- ========= PRIVACY POLICY FORM SECTION ENDED FROM HERE ========== -->
          </div>
        </div>
      </div>
      <!-- copyright section start from here -->
      <div class="copyright">
        <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
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
  // One common function to validate
  function validateInputField(input) {
      let value = parseInt(input.value, 10);
  
      if (isNaN(value) || value < 1 || value > 10) {
          alert("Please enter a number between 1 and 10. Setting value to 3.");
          input.value = 3;
      }
  }
  
  // Attach to all inputs once the page is loaded
  document.addEventListener('DOMContentLoaded', function () {
      const inputIds = [
          "class_online",
          "class_inperson",
          "class_oneday",
          "freelance_online_normal",
          "freelance_online_consultation",
          "freelance_inperson"
      ];
  
      inputIds.forEach(id => {
          const input = document.getElementById(id);
          if (input) {
              // Validate when focus is lost
              input.addEventListener('blur', function () {
                  validateInputField(this);
              });
              // Validate on value change (arrow click or manual change)
              input.addEventListener('change', function () {
                  validateInputField(this);
              });
          }
      });
  });
  </script>

  {{-- Submit Form ===== --}}
  <script>
    $(document).ready(function () {
        $('#updateButton').click(function (e) {
            e.preventDefault(); // Prevent default form submission
    
            // Array of input field IDs to validate
            const inputIds = [
                "class_online",
                "class_inperson",
                "class_oneday",
                "freelance_online_normal",
                "freelance_online_consultation",
                "freelance_inperson"
            ];
    
            let isValid = true; // Flag to track overall form validity
            let alertShown = false; // Flag to ensure only one alert is shown
    
            // Iterate over each input field
            inputIds.forEach(function (id) {
                const input = $('#' + id);
                const value = parseInt(input.val(), 10);
    
                // Check if the input is empty or not a number
                if (isNaN(value)) {
                    if (!alertShown) {
                        alert(`The field "${id.replace(/_/g, ' ')}" is required.`);
                        alertShown = true; // Set flag to true to prevent further alerts
                    }
                  
                    isValid = false;
                }
                // Check if the value is outside the allowed range
                else if (value < 1 || value > 10) {
                    if (!alertShown) {
                        alert(`The value for "${id.replace(/_/g, ' ')}" must be between 1 and 10.`);
                        alertShown = true; // Set flag to true to prevent further alerts
                    }
                  
                    isValid = false;
                }
            });
    
            // If all validations pass, submit the form
            if (isValid) {
                $('#form_submit').submit();
            }
        });
    });
    </script>
    
    
  {{-- Submit Form ===== --}}
<!-- ================ side js start End=============== -->
<!-- Add languages script -->
<script>
  document.getElementById("addButto").addEventListener("click", function () {
    const inputField = document.getElementById("inputField");
    const text = inputField.value.trim();

    if (text !== "") {
      const tileContainer = document.getElementById("tileContainer");

      const tile = document.createElement("div");
      tile.className = "tile";

      const tileText = document.createElement("span");
      tileText.textContent = text;

      const closeIcon = document.createElement("span");
      closeIcon.className = "closeIcon";
      closeIcon.textContent = "×";
      closeIcon.addEventListener("click", function () {
        tileContainer.removeChild(tile);
      });

      tile.appendChild(tileText);
      tile.appendChild(closeIcon);
      tileContainer.appendChild(tile);
      inputField.value = "";
    }
  });
</script>
<!-- ended -->

