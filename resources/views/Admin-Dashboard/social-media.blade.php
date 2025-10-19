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
    <!-- js -->
    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
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
    <link rel="stylesheet" href="assets/user/asset/css/style.css" />
    <title>Super Admin Dashboard | Dynamic Management-Social Media</title>
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
                    <span class="min-title">Social Media</span>
                  </div>
                </div>
              </div>
              <!-- Blue MASSEGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <img src="assets/admin/asset/img/dynamic-management.svg" alt="" />
                      <h2>Dynamic Management</h2>
                    </div>
                  </div>
                </div>
              </div>
              <!-- ================================== -->
              <div class="send-notify">
                <div class="row">
                  <div class="col-md-12">
                    <h1>Social Media Links</h1>
                  </div>
                </div>
              </div>
              <!-- ================================== -->
              <form
              class="profile-form"
              id="form"
              action="/update-social-media-dynamic"
              method="POST"
            > @csrf
              <div class="api-form">
                <div class="row">
                  <div class="col-md-12">
                    <div class="main">
                     
                        <div class="row input_fields_wrap">
                          <div id="input_fields-wrap-1">
                            <div class="col-md-12">
                              <label for="inputEmail4" class="form-label"
                                >Facebook</label
                              >
                              <div
                                class="input-group hidden-input"
                                id="input-group-1"
                              >
                                <input
                                  type="text"
                                  class="form-control form-control-lg"
                                  name="facebook" id="facebook_link"
                                  value="@if($links){{$links->facebook_link}}@endif"
                                  placeholder="https://www.facebook.com/company_name"
                                  aria-label="category Name"
                                  aria-describedby="button-addon"
                                />
                                <input
                                  type="text"
                                  class="form-control form-control-lg"
                                  name="category_name[]"
                                  style="display: none"
                                  placeholder="https://www.facebook.com/company_name"
                                  aria-label="category Name"
                                  aria-describedby="button-addon"
                                />
                                <button
                                  class="btn btn-outline-secondary hide-button"
                                  type="button" id="facebook"
                                  onclick="ChangeStatus(this.id);"
                                >@if($links)
                                @if ($links->facebook_status == 0)
                                    Hide
                                @else
                                   Show
                                @endif
                                @endif
                                </button>
                              </div>
                            </div>

                            <div class="col-md-12">
                              <label for="inputEmail4" class="form-label"
                                >Instagram</label
                              >
                              <div
                                class="input-group hidden-input"
                                id="input-group-1"
                              >
                                <input
                                  type="text"
                                  class="form-control form-control-lg"
                                  name="insta" id="insta_link"
                                  value="@if($links){{$links->insta_link}}@endif"
                                  placeholder="https://www.instagram.com/company_name"
                                  aria-label="category Name"
                                  aria-describedby="button-addon"
                                />
                                <input
                                  type="text"
                                  class="form-control form-control-lg"
                                  name="category_name[]"
                                  style="display: none"
                                  placeholder="https://www.instagram.com/company_name"
                                  aria-label="category Name"
                                  aria-describedby="button-addon"
                                />
                                <button
                                  class="btn btn-outline-secondary hide-button"
                                  type="button" id="insta"
                                 onclick="ChangeStatus(this.id);"
                                >@if($links)
                                @if ($links->insta_status == 0)
                                    Hide
                                @else
                                   Show
                                @endif
                                @endif
                                </button>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <label for="inputEmail4" class="form-label"
                                >Twitter</label
                              >
                              <div
                                class="input-group hidden-input"
                                id="input-group-1"
                              >
                                <input
                                  type="text"
                                  class="form-control form-control-lg"
                                  name="twitter" id="twitter_link"
                                  value="@if($links){{$links->twitter_link}}@endif"
                                  placeholder="https://www.twitter.com/company_name"
                                  aria-label="category Name"
                                  aria-describedby="button-addon"
                                />
                                <input
                                  type="text"
                                  class="form-control form-control-lg"
                                  name="category_name[]"
                                  style="display: none"
                                  placeholder="https://www.twitter.com/company_name"
                                  aria-label="category Name"
                                  aria-describedby="button-addon"
                                />
                                <button
                                  class="btn btn-outline-secondary hide-button"
                                  type="button" id="twitter"
                                  onclick="ChangeStatus(this.id);"
                                >
                                @if($links)@if ($links->twitter_status == 0)Hide
                                @else
                                   Show
                                @endif
                                @endif
                                </button>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <label for="inputEmail4" class="form-label"
                                >Youtube</label
                              >
                              <div
                                class="input-group hidden-input"
                                id="input-group-1"
                              >
                                <input
                                  type="text"
                                  class="form-control form-control-lg"
                                  name="youtube" id="youtube_link"
                                  value="@if($links){{$links->youtube_link}}@endif"
                                  placeholder="https://www.youtube.com/company_name"
                                  aria-label="category Name"
                                  aria-describedby="button-addon"
                                />
                                <input
                                  type="text"
                                  class="form-control form-control-lg"
                                  name="category_name[]"
                                  style="display: none"
                                  placeholder="https://www.youtube.com/company_name"
                                  aria-label="category Name"
                                  aria-describedby="button-addon"
                                />
                                <button
                                  class="btn btn-outline-secondary hide-button"
                                  type="button" id="youtube"
                                  onclick="ChangeStatus(this.id);"
                                >@if($links) @if ($links->youtube_status == 0)Hide
                                @else
                                   Show
                                @endif
                                @endif
                                </button>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <label for="inputEmail4" class="form-label"
                                >Tiktok</label
                              >
                              <div
                                class="input-group hidden-input"
                                id="input-group-1"
                              >
                                <input
                                  type="text"
                                  class="form-control form-control-lg"
                                  name="tiktok"  id="tiktok_link"
                                  value="@if($links){{$links->tiktok_link}}@endif"
                                  placeholder="https://www.tiktok.com/company_name"
                                  aria-label="category Name"
                                  aria-describedby="button-addon"
                                />
                                <input
                                  type="text"
                                  class="form-control form-control-lg"
                                  name="category_name[]"
                                  style="display: none"
                                  placeholder="https://www.tiktok.com/company_name"
                                  aria-label="category Name"
                                  aria-describedby="button-addon"
                                />
                                <button
                                  class="btn btn-outline-secondary hide-button"
                                  type="button" id="tiktok"
                                  onclick="ChangeStatus(this.id)"
                                > @if($links)
                                @if ($links->tiktok_status == 0)Hide @else  Show
                                @endif
                                @endif
                                </button>
                              </div>
                            </div>
                          </div>
                          <div id="input_fields_write"></div>
                          <div class="col-md-6"></div>
                        </div>
                    
                    </div>
                  </div>
                </div>
              </div>

              <!-- =============== BUTTONS SECTION START FROM HERE ================ -->
              <div class="api-buttons">
                <div class="row">
                  <div class="col-md-12">
                    <button type="button" class="btn float-start cancel-btn">
                      Cancel
                    </button>
                    <button type="submit" class="btn float-end update-btn">
                      Update
                    </button>
                  </div>
                </div>
              </div>
            </form>

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
  </body>
</html>
<!-- hide show input field js -->
<script>

  function ChangeStatus(Clicked) {
    
   var facebook_link = $('#facebook_link').val();
   var insta_link = $('#insta_link').val();
   var twitter_link = $('#twitter_link').val();
   var youtube_link = $('#youtube_link').val();
   var tiktok_link = $('#tiktok_link').val();

    if (Clicked == "facebook") {
    if (facebook_link == '') {
      toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.error("Update Facebook Link for Status Change!");
                   return false;
    }
    }

    if (Clicked == "insta") {
    if (insta_link == '') {
      toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.error("Update Instagram Link for Status Change!");
                    return false;
    }
    }

    if (Clicked == "twitter") {
    if (twitter_link == '') {
      toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.error("Update Twitter Link for Status Change!");
                    return false;
    }
    }

    if (Clicked == "youtube") {
    if (youtube_link == '') {
      toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.error("Update Twitter Link for Status Change!");
                    return false;
    }
    }

    if (Clicked == "tiktok") {
    if (tiktok_link == '') {
      toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.error("Update Twitter Link for Status Change!");
                    return false;
    }
    }


    var link_name = Clicked ;

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
          
            $.ajax({
                type: "GET",
                url: '/social-media-status-change',
                data:{link_name:link_name,  _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {
                  if(response.success == true){
                        toastr.success(response.message);

                     var button_html = $('#'+Clicked).html();
                       console.log(button_html);
                        if (button_html == 'Hide') {
                          $('#'+Clicked).html('Show');
                        } else {
                          $('#'+Clicked).html('Hide');
                        }

                    } else if(response.error == true){
                        toastr.error(response.message);
                    }
                },
              
            });



    }




  function toggleField(element) {
    var inputFields = element.querySelectorAll("input[type='text']");
    var hideButton = element.querySelector(".hide-button");

    for (var i = 0; i < inputFields.length; i++) {
      if (inputFields[i].style.display === "none") {
        // Show the input field
        inputFields[i].style.display = "block";
        hideButton.textContent = "Hide";
      } else {
        // Hide the input field
        inputFields[i].style.display = "none";
        hideButton.textContent = "Show";
      }
    }
  }
</script>
<script>
  window.addEventListener("DOMContentLoaded", () => {
    var counter = 0;
    var newFields = document
      .getElementById("input_fields-wrap-1")
      .cloneNode(true);
    newFields.id = "";
    var newField = newFields.childNodes;

    document
      .getElementById("add_field_button")
      .addEventListener("click", () => {
        for (var i = 0; i < newField.length; i++) {
          var theName = newField[i].name;
          if (theName) newField[i].name = theName + counter;
        }

        var insertHere = document.getElementById("input_fields_write");
        insertHere.parentNode.insertBefore(newFields, insertHere);
      });
  });

  function hideField(element) {
    element.style.display = "none"; // Hide the input group
    var label = element.parentNode.querySelector("label[for='inputEmail4']");
    if (label) label.style.display = "none"; // Hide the label
  }
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

