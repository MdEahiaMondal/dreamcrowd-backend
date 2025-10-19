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
    <!-- Select2 css -->
    <link href="assets/admin/libs/select2/css/select2.min.css" rel="stylesheet" />
    {{-- Fav Icon --}}
    @php  $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
    @endif
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

      <!-- jQuery -->
   <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    

     {{-- =======Toastr CDN ======== --}}
   <link rel="stylesheet" type="text/css" 
   href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
   
   <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
   {{-- =======Toastr CDN ======== --}}

    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/admin/asset/css/style.css" />
    <!-- <link rel="stylesheet" href="../User-Dashboard/assets/css/style.css" /> -->
    <title>Super Admin Dashboard | Account Setting</title>
  </head>

  <style>
    .toggle-password{
      float: right;
    position: relative;
    bottom: 30px;
    right: 50px;
    color: #ababab;
    }
    .fa-eye-slash:before {
    content: "\f070";
    }
    .fa-eye:before {
    content: "\f06e";
    }
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

  <body>

    @if (Session::has('error'))
    <script>
  
          toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "10000" // 10 seconds
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
          "extendedTimeOut": "10000" // 10 seconds
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
                    <span class="min-title">Account Setting</span>
                  </div>
                </div>
              </div>
              <!-- Blue MASSEGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <img src="assets/admin/asset/img/account-settings.svg" alt="" />
                      <h2>Account Setting</h2>
                    </div>
                  </div>
                </div>
              </div>
              <!-- =============== TABS SECTION START FROM HERE ================ -->
              <div class="row">
                <div class="col-md-12">
                  <div class="page-content">
                    <nav>
                      <ul class="tabs">
                        @if (Auth::user()->admin_role >= 4)
                        <li class="tab-li">
                          <a href="#tab1" class="tab-li__link">Change Email</a>
                        </li>
                        @endif
                      

                        <li class="tab-li">
                          <a href="#tab2" class="tab-li__link"
                            >Change Password</a
                          >
                        </li>
                        @if (Auth::user()->admin_role == 6)
                        <li class="tab-li">
                          <a href="#tab3" class="tab-li__link">Bank Detail</a>
                        </li>
                        <li class="tab-li">
                          <a href="#tab4" class="tab-li__link">Web Setting</a>
                        </li>
                        @endif
                       
                      </ul>
                    </nav>
                  </div>

                  @if (Auth::user()->admin_role >= 4)
                      
                 
                  <div id="tab1" data-tab-content>
                    <section>
                      <div class="details">
                        <h5 class="tab__content">Change Email</h5>
                      </div>
                      <div class="form-section">
                        <form action="/update-email" method="POST">
                          @csrf
                          <div class="col-12 form-sec">
                            <label for="inputAddress" class="form-label"
                              >Current Email</label
                            >
                            <input
                              type="email" name="email"
                              class="form-control" value="{{Auth::user()->email}}"
                              id="email" required
                              placeholder="example@company.com"
                            />
                          </div>
                          <div class="col-12 form-sec">
                            <label for="inputAddress2" class="form-label"
                              >New Email</label
                            >
                            <div class="input-group mb-3">
                              <input
                                type="email" name="new_email"
                                class="form-control"
                                placeholder="example@gmail.com"
                                aria-label="Recipient's username" required
                                aria-describedby="button-addon2"
                              />
                              <button
                                class="btn send-btn"
                                type="button"
                                id="button-addon2" onclick="SendCode(this.id)"
                              >Send</button>
                              <div id="loadingSpinner" class="loading-spinner"></div>
                            </div>
                          </div>
                          <div class="col-12 mt-0">
                            <label for="inputAddress2" class="form-label"
                              >Code</label
                            >
                            <input
                              type="text" name="code"
                              class="form-control"
                              id="inputAddress2" required
                              placeholder="XXXXXX"
                            />
                          </div>

                          <div class="api-buttons">
                            <div class="row">
                              <div class="col-md-12">
                                {{-- <button type="button"  class="btn float-start cancel-btn button-cancel"  > Cancel </button> --}}
                                <button type="submit" class="btn float-end update-btn">
                                  Update
                                </button>
                              </div>
                            </div>
                          </div>

                        </form>
                      </div>
                    </section>
                  </div>
                  @endif

                  <div id="tab2" data-tab-content>
                    <section>
                      <div class="details">
                        <h5 class="tab__content">Change Password</h5>
                      </div>
                      <div class="form-section">
                        <form action="/update-password" method="POST">
                          @csrf
                          <div class="col-12 form-sec">
                            <label for="inputAddress" class="form-label"
                              >Current Password
                            </label>
                            <input
                              type="password" name="password"
                              class="form-control"
                              id="old_password" required
                              placeholder="current password"
                            />
                            <span toggle="#old_password" onclick="ShowPass(this.id)" id="Old_Eye_Pass" class="fa fa-fw fa-eye field-icon toggle-password"  ></span>
                            
                          </div>
                          <div class="col-12 form-sec">
                            <label for="inputAddress2" class="form-label"
                              >New Password</label
                            >
                            <input
                              type="password" name="new_password"
                              class="form-control"
                              id="new_password" required
                              placeholder="new password"
                            />
                            <span toggle="#new_password" onclick="ShowPass(this.id)" id="New_Eye_Pass" class="fa fa-fw fa-eye field-icon toggle-password"  ></span>
                            <div id="passwordPopup" class="password-popup">
                             <ul>
                                 <li id="length">At least 8 characters</li>
                                 <li id="capital">At least one uppercase letter</li>
                                 <li id="number">At least one number</li>
                                 <li id="special">At least one special character</li>
                             </ul>
                         </div>
                         <style>
                               .password-popup {
                                 display: none;
                                 position: absolute;
                                 top: 450px;
                                 left: 280px;
                                 background-color: #f9f9f9;
                                 border: 1px solid #ccc;
                                 border-radius: 10px ;
                                 padding: 10px;
                                 width: max-content;
                                 box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                             }
                             .password-popup ul {
                                 list-style: none;
                                 padding: 0;
                                 margin: 0;
                             }
                             .password-popup ul li {
                                 font-size: 10px ;
                                 margin-bottom: 5px;
                                 color: #ff0000 !important; /* Red color for unfulfilled criteria */
                             }
                             .password-popup ul li.valid {
                                 color: #00cc00 !important; /* Green color for fulfilled criteria */
                             }
                         </style>
                          </div>
                          <div class="col-12 mt-0">
                            <label for="inputAddress2" class="form-label"
                              >Confirm Password</label
                            >
                            <input
                              type="password" name="c_password"
                              class="form-control"
                              id="c_password" required
                              placeholder="confirm password"
                            />
                            <span toggle="#c_password" onclick="ShowPass(this.id)" id="C_Eye_Pass" class="fa fa-fw fa-eye field-icon toggle-password"  ></span>
                            
                          </div>

                          <div class="api-buttons">
                            <div class="row">
                              <div class="col-md-12">
                                {{-- <button type="button"  class="btn float-start cancel-btn button-cancel"  > Cancel </button> --}}
                                <button type="submit" class="btn float-end update-btn">
                                  Update
                                </button>
                              </div>
                            </div>
                          </div>

                        </form>
                      </div>
                    </section>
                  </div>

                  @if (Auth::user()->admin_role == 6)
                      
                 
                  <div id="tab3" data-tab-content>
                    <section>
                      <div class="details">
                        <h5 class="tab__content">Bank Detail</h5>
                      </div>
                      <div class="form-section">
                        <form action="/update-bank-details" method="POST">
                           @csrf
                          <div class="col-12 form-sec">
                            <label for="inputAddress" class="form-label"
                              >Bank Name</label
                            >
                            <input
                              type="text" name="bank_name"
                              class="form-control" value="@if($bank_details){{$bank_details->bank_name}}@endif"
                              id="inputAddress" required
                              placeholder="Bank Name"
                            />
                          </div>
                          <div class="col-12 form-sec">
                            <label for="inputAddress2" class="form-label"
                              >Account Holder Name</label
                            >
                            <input
                              type="text" name="holder_name"
                              class="form-control" value="@if($bank_details){{$bank_details->holder_name}}@endif"
                              id="inputAddress2" required
                              placeholder="Account holder name"
                            />
                          </div>
                          <div class="col-12 mt-0">
                            <label for="inputAddress2" class="form-label"
                              >IBAN</label
                            >
                            <input
                              type="text" name="iban"
                              class="form-control" value="@if($bank_details){{$bank_details->iban}}@endif"
                              id="inputAddress2" required
                              placeholder="Iban"
                            />
                          </div>

                          <div class="api-buttons">
                            <div class="row">
                              <div class="col-md-12">
                               {{-- <button type="button"  class="btn float-start cancel-btn button-cancel"  > Cancel </button> --}}
                                <button type="submit" class="btn float-end update-btn">
                                  Update
                                </button>
                              </div>
                            </div>
                          </div> 
                        </form>
                      </div>
                    </section>
                  </div>

                  <div id="tab4" data-tab-content>
                    <section>
                      <div class="details">
                        <h5 class="tab__content">Web Setting</h5>
                      </div>
                      <div class="form-section">
                        <form action="/update-web-setting" method="POST">
                          @csrf
                          <div class="col-12 form-sec">
                            <label for="inputAddress" class="form-label"
                              >Number of classes experts can provide</label
                            >
                            <input onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                              type="text" name="classes_expert" 
                              class="form-control" value="@if($web_setting){{$web_setting->classes_expert}}@endif"
                              id="inputAddress" required 
                              placeholder="Number of classes experts can provide"
                            />
                          </div>
                          <div class="col-12 form-sec">
                            <label for="inputAddress2" class="form-label"
                              >Number of remote services experts can
                              provide</label
                            >
                            <input onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                              type="text" name="remote_expert"
                              class="form-control" value="@if($web_setting){{$web_setting->remote_expert}}@endif"
                              id="inputAddress2" required
                              placeholder="Number of remote services experts can provide"
                            />
                          </div>
                          <div class="col-12 form-sec mt-0">
                            <label for="inputAddress2" class="form-label"
                              >Commission rate</label
                            >
                            <input onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                              type="text" name="commission_rate"
                              class="form-control" value="@if($web_setting){{$web_setting->commission_rate}}@endif"
                              id="inputAddress2" required
                              placeholder="20 %"
                            />
                          </div>
                          <div class="col-12 form-sec mt-0">
                            <label for="inputAddress2" class="form-label"
                              >Currency update</label
                            >
                            <input
                              type="text" name="currency"
                              class="form-control" value="@if($web_setting){{$web_setting->currency}}@endif"
                              id="inputAddress2" required
                              placeholder="Currency update"
                            />
                          </div>
                          <div class="col-12 mt-0">
                            <label for="inputAddress2" class="form-label"
                              >Meta descriptions</label
                            >
                            <br />
                            <textarea
                              name="meta_description"
                              id=""
                              placeholder="Meta descriptions"
                            >@if($web_setting){{$web_setting->meta_description}}@endif</textarea>
                          </div>

                          <div class="api-buttons">
                            <div class="row">
                              <div class="col-md-12">
                               {{-- <button type="button"  class="btn float-start cancel-btn button-cancel"  > Cancel </button> --}}
                                <button type="submit" class="btn float-end update-btn">
                                  Update
                                </button>
                              </div>
                            </div>
                          </div>

                        </form>
                      </div>
                    </section>
                  </div>
                  @endif

                </div>
              </div>
              <!-- =============== TABS SECTION ENDED FROM HERE ================ -->
              <!-- =============== BUTTONS SECTION START FROM HERE ================ -->
              {{-- <div class="api-buttons">
                <div class="row">
                  <div class="col-md-12">
                    <button
                      type="button"
                      class="btn float-start cancel-btn button-cancel"
                    >
                      Cancel
                    </button>
                    <button type="button" class="btn float-end update-btn">
                      Update
                    </button>
                  </div>
                </div>
              </div> --}}
              <!-- =============== BUTTONS SECTION START FROM HERE ================ -->
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
    <!-- tabs script link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  </body>
</html>

{{-- scrript Password Requirements Start --}}
<script>
  // Select elements
  const passwordInput = document.getElementById('new_password');
      const passwordPopup = document.getElementById('passwordPopup');
  
      const lengthCriteria = document.getElementById('length');
      const capitalCriteria = document.getElementById('capital');
      const numberCriteria = document.getElementById('number');
      const specialCriteria = document.getElementById('special');
  
      // Show popup on focus
      passwordInput.addEventListener('focus', () => {
          passwordPopup.style.display = 'block';
      });
  
      // Hide popup on blur
      passwordInput.addEventListener('blur', () => {
          passwordPopup.style.display = 'none';
      });
  
      // Validate password on input
      passwordInput.addEventListener('input', () => {
          const passwordValue = passwordInput.value;
  
          // Validate length (at least 8 characters)
          if (passwordValue.length >= 8) {
              lengthCriteria.classList.add('valid');
          } else {
              lengthCriteria.classList.remove('valid');
          }
  
          // Validate capital letter
          if (/[A-Z]/.test(passwordValue)) {
              capitalCriteria.classList.add('valid');
          } else {
              capitalCriteria.classList.remove('valid');
          }
  
          // Validate number
          if (/[0-9]/.test(passwordValue)) {
              numberCriteria.classList.add('valid');
          } else {
              numberCriteria.classList.remove('valid');
          }
  
          // Validate special character
          if (/[\W_]/.test(passwordValue)) { // \W matches any non-word character
              specialCriteria.classList.add('valid');
          } else {
              specialCriteria.classList.remove('valid');
          }
      });


</script>
{{-- scrript Password Requirements END --}}

{{-- PAssword Show Hide Eye Icon Click Script Start --}}
<script>
  function ShowPass(Clicked) { 
   var togglePassword = $('#'+Clicked).attr("toggle");
   
   
   const password = document.querySelector(togglePassword);
 
  console.log('yee');
  
    // Toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);

    if (type == 'text') {
      $('#'+Clicked).addClass('fa-eye-slash');
      $('#'+Clicked).removeClass('fa-eye');
    }else{
      $('#'+Clicked).removeClass('fa-eye-slash');
      $('#'+Clicked).addClass('fa-eye');
    }
 

   
   }
 
</script>
{{-- PAssword Show Hide Eye Icon Click Script END --}}

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
          "extendedTimeOut": "10000" // 10 seconds
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
          "extendedTimeOut": "10000" // 10 seconds
          }
                  toastr.success(response.message);

              } else if(response.error) {
                        toastr.options =
                  {
                      "closeButton" : true,
                       "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "10000" // 10 seconds
                  }
                          toastr.error(response.message);

              }
                }
            });





 }

</script>
{{-- Send Email COde Script Ajax END ======== --}}

<!-- ============== Tabs js start from here =============== -->
<script>
  var nestedTabSelect = (tabsElement, currentElement) => {
    const tabs = tabsElement ?? "ul.tabs";
    const currentClass = currentElement ?? "active";

    $(tabs).each(function () {
      let $active,
        $content,
        $links = $(this).find("a");

      $active = $(
        $links.filter('[href="' + location.hash + '"]')[0] || $links[0]
      );
      $active.addClass(currentClass);

      $content = $($active[0].hash);
      $content.addClass(currentClass);

      $links.not($active).each(function () {
        $(this.hash).removeClass(currentClass);
      });

      $(this).on("click", "a", function (e) {
        // Make the old tab inactive.
        $active.removeClass(currentClass);
        $content.removeClass(currentClass);

        // Update the variables with the new link and content
        $active = $(this);
        $content = $(this.hash);

        // Make the tab active.
        $active.addClass(currentClass);
        $content.addClass(currentClass);

        e.preventDefault();
      });
    });
  };

  nestedTabSelect("ul.tabs", "active");
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
