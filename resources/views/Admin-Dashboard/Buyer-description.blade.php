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
    <link rel="stylesheet" href="assets/admin/asset/css/report-seller.css" />
    <title>Super Admin Dashboard | Discount Code</title>
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
                    <span class="min-title">Buyer Description</span>
                  </div>
                </div>
              </div>
              <!-- Blue MASSEGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                        <i class='bx bxs-user-x'></i>
                      <h2>Buyer Description</h2>
                    </div>
                  </div>
                </div>
              </div>

              <!-- ================================== -->
              
              <!-- ================================ TABLE START HERE ============================ -->
           <!-- notification1 -->
           <div class="manu-notification">
            <div class="row">
              <div class="col-md-12">
                <div class="notify-1 notify-first">
                  <p><a data-bs-toggle="modal"
                  data-bs-target="#edit-admin">Learn all the Dos and Don’ts of Dream Crowd at our May 16th  Community Standards webinar.Learn all the Dos and Don’ts
                     of Dream Crowd at our May 16th  Community Standards webinar.
                </a></p>
                  <div class="last-week">
                    <span>Last Week</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- notification2 -->
          <div class="manu-notification">
            <div class="row">
              <div class="col-md-12">
                <div class="notify-1">
                  <p><a data-bs-toggle="modal"
                    data-bs-target="#edit-admin">Learn all the Dos and Don’ts of Dream Crowd at our May 16th  Community Standards webinar.Learn all the Dos and Don’ts
                       of Dream Crowd at our May 16th  Community Standards webinar.
                  </a></p>
                 <div class="last-week">
                   <span>Last Week</span>
                 </div>
                </div>
              </div>
            </div>
          </div>
          <!-- notification3 -->
          <div class="manu-notification">
            <div class="row">
              <div class="col-md-12">
                <div class="notify-1">
                  <p><a data-bs-toggle="modal"
                    data-bs-target="#edit-admin">Learn all the Dos and Don’ts of Dream Crowd at our May 16th  Community Standards webinar.Learn all the Dos and Don’ts
                       of Dream Crowd at our May 16th  Community Standards webinar.
                  </a></p>
                 <div class="last-week">
                   <span>Last Week</span>
                 </div>
                </div>
              </div>
            </div>
          </div>
          <!-- notification4 -->
          <div class="manu-notification">
            <div class="row">
              <div class="col-md-12">
                <div class="notify-1">
                  <p><a data-bs-toggle="modal"
                    data-bs-target="#edit-admin">Learn all the Dos and Don’ts of Dream Crowd at our May 16th  Community Standards webinar.Learn all the Dos and Don’ts
                       of Dream Crowd at our May 16th  Community Standards webinar.
                  </a></p>
                 <div class="last-week">
                   <span>Last Week</span>
                 </div>
                </div>
              </div>
            </div>
          </div>
          <!-- notification5 -->
          <div class="manu-notification">
            <div class="row">
              <div class="col-md-12">
                <div class="notify-1">
                  <p><a data-bs-toggle="modal"
                    data-bs-target="#edit-admin">Learn all the Dos and Don’ts of Dream Crowd at our May 16th  Community Standards webinar.Learn all the Dos and Don’ts
                       of Dream Crowd at our May 16th  Community Standards webinar.
                  </a></p>
                 <div class="last-week">
                   <span>Last Week</span>
                 </div>
                </div>
              </div>
            </div>
          </div>
          <!-- notification6 -->
          <div class="manu-notification">
            <div class="row">
              <div class="col-md-12">
                <div class="notify-1">
                  <p><a data-bs-toggle="modal"
                    data-bs-target="#edit-admin">Learn all the Dos and Don’ts of Dream Crowd at our May 16th  Community Standards webinar.Learn all the Dos and Don’ts
                       of Dream Crowd at our May 16th  Community Standards webinar.
                  </a></p>
                 <div class="last-week">
                   <span>Last Week</span>
                 </div>
                </div>
              </div>
            </div>
          </div>
          <!-- notification7 -->
          <div class="manu-notification">
            <div class="row">
              <div class="col-md-12">
                <div class="notify-1">
                  <p><a data-bs-toggle="modal"
                    data-bs-target="#edit-admin">Learn all the Dos and Don’ts of Dream Crowd at our May 16th  Community Standards webinar.Learn all the Dos and Don’ts
                       of Dream Crowd at our May 16th  Community Standards webinar.
                  </a></p>
                 <div class="last-week">
                   <span>Last Week</span>
                 </div>
                </div>
              </div>
            </div>
          </div>
          <!-- notification8 -->
          <div class="manu-notification">
            <div class="row">
              <div class="col-md-12">
                <div class="notify-1">
                  <p><a data-bs-toggle="modal"
                    data-bs-target="#edit-admin">Learn all the Dos and Don’ts of Dream Crowd at our May 16th  Community Standards webinar.Learn all the Dos and Don’ts
                       of Dream Crowd at our May 16th  Community Standards webinar.
                  </a></p>
                 <div class="last-week">
                   <span>Last Week</span>
                 </div>
                </div>
              </div>
            </div>
          </div>
          <!-- notification9 -->
          <div class="manu-notification">
            <div class="row">
              <div class="col-md-12">
                <div class="notify-1">
                  <p><a data-bs-toggle="modal"
                    data-bs-target="#edit-admin">Learn all the Dos and Don’ts of Dream Crowd at our May 16th  Community Standards webinar.Learn all the Dos and Don’ts
                       of Dream Crowd at our May 16th  Community Standards webinar.
                  </a></p>
                 <div class="last-week">
                   <span>Last Week</span>
                 </div>
                </div>
              </div>
            </div>
          </div>
          <!-- notification10 -->
          <div class="manu-notification">
            <div class="row">
              <div class="col-md-12">
                <div class="notify-1 notify-last">
                  <p><a data-bs-toggle="modal"
                    data-bs-target="#edit-admin">Learn all the Dos and Don’ts of Dream Crowd at our May 16th  Community Standards webinar.Learn all the Dos and Don’ts
                       of Dream Crowd at our May 16th  Community Standards webinar.
                  </a></p>
                 <div class="last-week">
                   <span>Last Week</span>
                 </div>
                </div>
              </div>
            </div>
          </div>
          </div>
          </div>
          <!-- NOTIFICATION END -->
    
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
<!-- ================ side js start End=============== -->

<!-- DISCOUNT CODE POPUP -->
<div
  class="modal fade notification-modal"
  id="exampleModalToggle"
  aria-hidden="true"
  aria-labelledby="exampleModalToggleLabel"
  tabindex="-1"
>
  <div class="modal-dialog modal-dialog-centered mt-5">
    <div class="modal-content mt-2">
      <div class="card-header text-center">Create New Coupon</div>
      <div class="model_popup">
        <label for="car" class="form-label">Coupon Name</label>
        <input
          class="form-control"
          list="datalistOptions"
          id="car"
          placeholder="Welcome"
        />
        <label for="car" class="form-label">Coupon Code</label>
        <input
          class="form-control"
          list="datalistOptions"
          id="car"
          placeholder="welcome2023"
        />
        <label for="car" class="form-label">Coupon For</label>
        <select class="form-select" aria-label="Default select example">
          <option selected>--select option--</option>
        </select>
        <label for="car" class="form-label">Deduction Type</label>
        <select class="form-select" aria-label="Default select example">
          <option selected>--select option--</option>
        </select>
        <label for="car" class="form-label"
          >How much do you take off the original price for the discount?</label
        >
        <input
          class="form-control"
          list="datalistOptions"
          id="car"
          placeholder="welcome2023"
        />
        <label for="car" class="form-label">Start Date</label>
        <input type="date" class="form-control" />
        <label for="car" class="form-label">Expire Date</label>
        <input type="date" class="form-control" />
        <button type="button" class="btn1">Cancel</button>
        <button type="button" class="btn2">Update</button>
      </div>
    </div>
  </div>
</div>
<!-- Edit Admin Popup -->
<div
  class="modal fade"
  id="edit-admin"
  aria-hidden="true"
  aria-labelledby="exampleModalToggleLabel"
  tabindex="-1"
>
  <div class="modal-dialog modal-dialog-centered mt-5">
    <div class="modal-content mt-2">
      <div class="card-header text-center">Report Detail</div>
      <div class="model_popup">
        <label for="car" class="form-label">Buyer Name</label>
        <input
          class="form-control"
          list="datalistOptions"
          id="car"
          placeholder="Usama Aslam"
          
        />
        <label for="car" class="form-label">Reort Date</label>
        <input
          class="form-control"
          list="datalistOptions"
          id="car"
          placeholder="June 15, 2024"
          
        />
        <div class="mb-3">
          <label for="message-text" class="col-form-label">Report</label>
          <textarea class="form-control" id="message-text" placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged." readonly></textarea>
        </div>
      </div>
    </div>
  </div>
</div>
