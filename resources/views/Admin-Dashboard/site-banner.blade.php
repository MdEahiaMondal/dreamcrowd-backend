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
     <!-- jQuery -->
     <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>

     {{-- =======Toastr CDN ======== --}}
     <link rel="stylesheet" type="text/css" 
     href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
     
     <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
     {{-- =======Toastr CDN ======== --}}
    <!-- Fontawesome CDN -->
    <script
      src="https://kit.fontawesome.com/be69b59144.js"
      crossorigin="anonymous"
    ></script>
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/admin/asset/css/style.css" />
    <link rel="stylesheet" href="assets/user/asset/css/style.css" />
    <title>Super Admin Dashboard | Dynamic Management-FAQ's</title>
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
                    <span class="min-title">Sellers Banner</span>
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
              <div class="col-md-12 manage-profile-faq-sec site-banner">
                <h5>Sellers Banner</h5>
                <a href="/add-site-banner"
                  ><button
                    class="btn float-end add-faq-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModal2"
                  >
                    <i class="fa-solid fa-plus"></i>
                    Create New Banner
                  </button>
                </a>
              </div>
              <!-- ================================== -->
              <!-- ========= PRIVACY POLICY FORM SECTION START FROM HERE ========== -->
              <div class="form-section conditions">
                <div class="row">
                  <div class="col-md-12">
                    <div class="">
                      <form class="row">
                        <h5>All Site Banners</h5>

                        @if ($banner)

                        @foreach ($banner as $item)
                        <div class="col-md-6">
                          <a href="/edit-site-banner/{{$item->id}}">
                            <input
                              type="email" style="cursor: pointer;"
                              class="form-control"
                              id="inputEmail4"
                              placeholder="{{$item->heading}}"
                              readonly
                          /></a>
                        </div>
                        @endforeach
                            
                        @else
                        <div class="col-md-6">
                          <a  >
                            <input
                              type="email" style="cursor: pointer;"
                              class="form-control"
                              id="inputEmail4"
                              placeholder="Didn't Added Any Site Banner Yet!"
                              readonly
                          /></a>
                        </div>
                        @endif
 
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- ========= PRIVACY POLICY FORM SECTION ENDED FROM HERE ========== -->
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
<!-- ================ side js start here=============== -->
<!-- ================ side js start End=============== -->

<!-- FAQ MODAL START HERE -->
<div
  class="modal fade"
  id="exampleModal1"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog">
    <div class="modal-content condition-modal">
      <div class="modal-header p-0 modal-heading">
        <h5 class="modal-title" id="exampleModalLabel">
          Add New Privacy policy
        </h5>
      </div>
      <div class="modal-body body-modal">
        <form action="" class="condition-form">
          <div class="col-12">
            <label for="inputAddress" class="form-label">Privacy Heading</label>
            <input
              type="text"
              class="form-control"
              id="inputAddress"
              placeholder="Heading"
            />
          </div>
          <div class="col-12 privacy-details">
            <label for="inputAddress2" class="form-label">Privacy Detail</label>
            <br />
            <textarea name="" id="" placeholder="Privacy Detail"></textarea>
          </div>
        </form>
        <button class="btn float-start cancel-button">Cancel</button>
        <button class="btn float-end add-button">Add</button>
      </div>
    </div>
  </div>
</div>
