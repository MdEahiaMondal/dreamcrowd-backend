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
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/admin/asset/css/style.css" />
    <link rel="stylesheet" href="assets/user/asset/css/style.css" />
    <title>Super Admin Dashboard | Zoom Setting</title>
  </head>
  <body>
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
                    <span class="min-title">Zoom Setting</span>
                  </div>
                </div>
              </div>
              <!-- Blue MASSEGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <i class="bx bx-tv"></i>
                      <h2>Zoom Setting</h2>
                    </div>
                  </div>
                </div>
              </div>

              <!-- ================================== -->
              <!-- =============== API SETTINGS SECTION START FROM HERE ================ -->
              <div class="api-section">
                <div class="row">
                  <div class="col-md-12">
                    <h5 class="mb-0">API Settings</h5>
                  </div>
                </div>
              </div>

              <!-- =============== API SETTINGS SECTION ENDED FROM HERE ================ -->
              <!-- =============== API FORM SECTION START FROM HERE ================ -->
              <div class="api-form">
                <div class="row">
                  <div class="col-md-12">
                    <form class="row g-3">
                      <div class="col-12">
                        <label for="inputAddress" class="form-label"
                          >API Key</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          id="inputAddress"
                          placeholder="YourAPIKey12345"
                        />
                      </div>
                      <div class="col-12 api-secret">
                        <label for="inputAddress2" class="form-label"
                          >API Secret</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          id="inputAddress2"
                          placeholder="YourAPISecret12345"
                        />
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <!-- =============== API FORM SECTION ENDED FROM HERE ================ -->
              <!-- =============== BUTTONS SECTION START FROM HERE ================ -->
              <div class="api-buttons">
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
              </div>
              <!-- =============== BUTTONS SECTION ENDED FROM HERE ================ -->
              <!-- copyright section start from here -->
              <div class="copyright">
                <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
              </div>
            </div>
          </div>
        </div>
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
<!-- ================ side js start End=============== -->


<!-- NOTIFICATION POPUP START HERE-->
<div
  class="modal fade notification-modal"
  id="exampleModalToggle"
  aria-hidden="true"
  aria-labelledby="exampleModalToggleLabel"
  tabindex="-1"
>
  <div class="modal-dialog modal-dialog-centered mt-5">
    <div class="modal-content mt-2">
      <div class="card-header text-center">Send New Notification</div>
      <div class="model_popup">
        <label for="car" class="form-label">Send to</label>
        <input
          class="form-control"
          list="datalistOptions"
          placeholder="All Users, Seller Only, Buyer Only,Specific Users . (Drop Down"
        />
        <label for="car" class="form-label">Heading</label>
        <input
          class="form-control"
          list="datalistOptions"
          placeholder="write Heading"
        />
        <label for="car" class="form-label">Notification</label>
        <textarea
          class="form-control"
          list="datalistOptions"
          rows="9"
          placeholder="write message for users....."
        ></textarea>
        <button type="button" class="btn1">Cancel</button>
        <button type="button" class="btn2">Send</button>
      </div>
    </div>
  </div>
</div>
