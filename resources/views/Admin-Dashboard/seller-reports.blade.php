<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <!-- View Point scale to 1.0 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Animate css -->
    <link rel="stylesheet" href="/assets/admin/libs/animate/css/animate.css" />
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="/assets/admin/libs/aos/css/aos.css" />
    <!-- Datatable css  -->
    <link rel="stylesheet" href="/assets/admin/libs/datatable/css/datatable.css" />
     {{-- Fav Icon --}}
     @php  $home = \App\Models\HomeDynamic::first(); @endphp
     @if ($home)
         <link rel="shortcut icon" href="/assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
     @endif
     <!-- Select2 css -->
    <link href="/assets/admin/libs/select2/css/select2.min.css" rel="stylesheet" />
    <!-- Owl carousel css -->
    <link href="/assets/admin/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
    <link href="/assets/admin/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
    <!-- Bootstrap css -->
    <link
      rel="stylesheet"
      type="text/css"
      href="/assets/admin/asset/css/bootstrap.min.css"
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
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/style.css" />
    <link rel="stylesheet" href="/assets/user/asset/css/style.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/report-seller.css" />
    <title>Super Admin Dashboard | Discount Code</title>
  </head>
  <style>
    .button {
      color: #0072b1 !important;
    }
  </style>
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
                    <span class="min-title">Seller Report</span>
                  </div>
                </div>
              </div>
              <!-- Blue MASSEGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <i class="bx bxs-user-x"></i>
                      <h2>Seller Report</h2>
                    </div>
                  </div>
                </div>
              </div>

              <!-- ================================== -->

              <!-- ================================ TABLE START HERE ============================ -->
              <div class="installment-table">
                <div class="row">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <div class="hack1">
                        <div class="hack2">
                          <table class="table">
                            <thead>
                              <tr class="text-nowrap">
                                <th>Seller Name</th>
                                <th>Email</th>
                                <th>Last Report</th>
                                <th>No. of Reports</th>
                                <th>Status</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>Usama A.</td>
                                <td>example@gmail.com</td>
                                <td>June 15,2024</td>
                                <td>100</td>
                                <td>
                                  <span class="badge service-class-badge"
                                    >Active</span
                                  >
                                </td>
                                <td>
                                  <div class="float-end expert-dropdown">
                                    <button
                                      class="btn action-btn"
                                      type="button"
                                      id="dropdownMenuButton1"
                                      data-bs-toggle="dropdown"
                                      aria-expanded="false"
                                    >
                                      ...
                                    </button>
                                    <ul
                                      class="dropdown-menu"
                                      aria-labelledby="dropdownMenuButton1"
                                    >
                                      <a class="dropdown-item btn" href="#"
                                        ><li>View Profile</li></a
                                      >
                                      <a
                                        class="dropdown-item"
                                        href="seller-description.html"
                                        ><li>View Report</li></a
                                      >
                                      <a
                                        class="dropdown-item btn"
                                        href="#"
                                        data-bs-target="#exampleModalToggle"
                                        data-bs-toggle="modal"
                                        ><li>Change Status</li></a
                                      >
                                    </ul>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Usama A.</td>
                                <td>example@gmail.com</td>
                                <td>June 15,2024</td>
                                <td>100</td>
                                <td>
                                  <span class="baddge">Banned</span>
                                </td>
                                <td>
                                  <div class="float-end expert-dropdown">
                                    <button
                                      class="btn action-btn"
                                      type="button"
                                      id="dropdownMenuButton1"
                                      data-bs-toggle="dropdown"
                                      aria-expanded="false"
                                    >
                                      ...
                                    </button>
                                    <ul
                                      class="dropdown-menu"
                                      aria-labelledby="dropdownMenuButton1"
                                    >
                                      <a
                                        class="dropdown-item btn"
                                        href="#"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"
                                        ><li>View Profile</li></a
                                      >
                                      <a
                                        class="dropdown-item"
                                        href="seller-description.html"
                                        ><li>View Report</li></a
                                      >
                                      <a
                                        class="dropdown-item btn"
                                        href="#"
                                        data-bs-target="#exampleModalToggle"
                                        data-bs-toggle="modal"
                                        ><li>Change Status</li></a
                                      >
                                    </ul>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Usama A.</td>
                                <td>example@gmail.com</td>
                                <td>June 15,2024</td>
                                <td>100</td>
                                <td>
                                  <span class="badge service-class-badge"
                                    >Active</span
                                  >
                                </td>
                                <td>
                                  <div class="float-end expert-dropdown">
                                    <button
                                      class="btn action-btn"
                                      type="button"
                                      id="dropdownMenuButton1"
                                      data-bs-toggle="dropdown"
                                      aria-expanded="false"
                                    >
                                      ...
                                    </button>
                                    <ul
                                      class="dropdown-menu"
                                      aria-labelledby="dropdownMenuButton1"
                                    >
                                      <a
                                        class="dropdown-item btn"
                                        href="#"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"
                                        ><li>View Profile</li></a
                                      >
                                      <a
                                        class="dropdown-item"
                                        href="seller-description.html"
                                        ><li>View Report</li></a
                                      >
                                      <a
                                        class="dropdown-item btn"
                                        href="#"
                                        data-bs-target="#exampleModalToggle"
                                        data-bs-toggle="modal"
                                        ><li>Change Status</li></a
                                      >
                                    </ul>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Usama A.</td>
                                <td>example@gmail.com</td>
                                <td>June 15,2024</td>
                                <td>100</td>
                                <td>
                                  <span class="baddge">Banned</span>
                                </td>
                                <td>
                                  <div class="float-end expert-dropdown">
                                    <button
                                      class="btn action-btn"
                                      type="button"
                                      id="dropdownMenuButton1"
                                      data-bs-toggle="dropdown"
                                      aria-expanded="false"
                                    >
                                      ...
                                    </button>
                                    <ul
                                      class="dropdown-menu"
                                      aria-labelledby="dropdownMenuButton1"
                                    >
                                      <a
                                        class="dropdown-item btn"
                                        href="#"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"
                                        ><li>View Profile</li></a
                                      >
                                      <a
                                        class="dropdown-item"
                                        href="seller-description.html"
                                        ><li>View Report</li></a
                                      >
                                      <a
                                        class="dropdown-item btn"
                                        href="#"
                                        data-bs-target="#exampleModalToggle"
                                        data-bs-toggle="modal"
                                        ><li>Change Status</li></a
                                      >
                                    </ul>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Usama A.</td>
                                <td>example@gmail.com</td>
                                <td>June 15,2024</td>
                                <td>100</td>
                                <td>
                                  <span class="badge service-class-badge"
                                    >Active</span
                                  >
                                </td>
                                <td>
                                  <div class="float-end expert-dropdown">
                                    <button
                                      class="btn action-btn"
                                      type="button"
                                      id="dropdownMenuButton1"
                                      data-bs-toggle="dropdown"
                                      aria-expanded="false"
                                    >
                                      ...
                                    </button>
                                    <ul
                                      class="dropdown-menu"
                                      aria-labelledby="dropdownMenuButton1"
                                    >
                                      <a
                                        class="dropdown-item btn"
                                        href="#"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"
                                        ><li>View Profile</li></a
                                      >
                                      <a
                                        class="dropdown-item"
                                        href="seller-description.html"
                                        ><li>View Report</li></a
                                      >
                                      <a
                                        class="dropdown-item btn"
                                        href="#"
                                        data-bs-target="#exampleModalToggle"
                                        data-bs-toggle="modal"
                                        ><li>Change Status</li></a
                                      >
                                    </ul>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Usama A.</td>
                                <td>example@gmail.com</td>
                                <td>June 15,2024</td>
                                <td>100</td>
                                <td>
                                  <span class="baddge">Banned</span>
                                </td>
                                <td>
                                  <div class="float-end expert-dropdown">
                                    <button
                                      class="btn action-btn"
                                      type="button"
                                      id="dropdownMenuButton1"
                                      data-bs-toggle="dropdown"
                                      aria-expanded="false"
                                    >
                                      ...
                                    </button>
                                    <ul
                                      class="dropdown-menu"
                                      aria-labelledby="dropdownMenuButton1"
                                    >
                                      <a
                                        class="dropdown-item btn"
                                        href="#"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"
                                        ><li>View Profile</li></a
                                      >
                                      <a
                                        class="dropdown-item"
                                        href="seller-description.html"
                                        ><li>View Report</li></a
                                      >
                                      <a
                                        class="dropdown-item btn"
                                        href="#"
                                        data-bs-target="#exampleModalToggle"
                                        data-bs-toggle="modal"
                                        ><li>Change Status</li></a
                                      >
                                    </ul>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Usama A.</td>
                                <td>example@gmail.com</td>
                                <td>June 15,2024</td>
                                <td>100</td>
                                <td>
                                  <span class="badge service-class-badge"
                                    >Active</span
                                  >
                                </td>
                                <td>
                                  <div class="float-end expert-dropdown">
                                    <button
                                      class="btn action-btn"
                                      type="button"
                                      id="dropdownMenuButton1"
                                      data-bs-toggle="dropdown"
                                      aria-expanded="false"
                                    >
                                      ...
                                    </button>
                                    <ul
                                      class="dropdown-menu"
                                      aria-labelledby="dropdownMenuButton1"
                                    >
                                      <a
                                        class="dropdown-item btn"
                                        href="#"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"
                                        ><li>View Profile</li></a
                                      >
                                      <a
                                        class="dropdown-item"
                                        href="seller-description.html"
                                        ><li>View Report</li></a
                                      >
                                      <a
                                        class="dropdown-item btn"
                                        href="#"
                                        data-bs-target="#exampleModalToggle"
                                        data-bs-toggle="modal"
                                        ><li>Change Status</li></a
                                      >
                                    </ul>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Usama A.</td>
                                <td>example@gmail.com</td>
                                <td>June 15,2024</td>
                                <td>100</td>
                                <td>
                                  <span class="baddge">Banned</span>
                                </td>
                                <td>
                                  <div class="float-end expert-dropdown">
                                    <button
                                      class="btn action-btn"
                                      type="button"
                                      id="dropdownMenuButton1"
                                      data-bs-toggle="dropdown"
                                      aria-expanded="false"
                                    >
                                      ...
                                    </button>
                                    <ul
                                      class="dropdown-menu"
                                      aria-labelledby="dropdownMenuButton1"
                                    >
                                      <a
                                        class="dropdown-item btn"
                                        href="#"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"
                                        ><li>View Profile</li></a
                                      >
                                      <a
                                        class="dropdown-item"
                                        href="seller-description.html"
                                        ><li>View Report</li></a
                                      >
                                      <a
                                        class="dropdown-item btn"
                                        href="#"
                                        ddata-bs-target="#exampleModalToggle"
                                        data-bs-toggle="modal"
                                        ><li>Change Status</li></a
                                      >
                                    </ul>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Usama A.</td>
                                <td>example@gmail.com</td>
                                <td>June 15,2024</td>
                                <td>100</td>
                                <td>
                                  <span class="badge service-class-badge"
                                    >Active</span
                                  >
                                </td>
                                <td>
                                  <div class="float-end expert-dropdown">
                                    <button
                                      class="btn action-btn"
                                      type="button"
                                      id="dropdownMenuButton1"
                                      data-bs-toggle="dropdown"
                                      aria-expanded="false"
                                    >
                                      ...
                                    </button>
                                    <ul
                                      class="dropdown-menu"
                                      aria-labelledby="dropdownMenuButton1"
                                    >
                                      <a
                                        class="dropdown-item btn"
                                        href="#"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"
                                        ><li>View Profile</li></a
                                      >
                                      <a
                                        class="dropdown-item"
                                        href="seller-description.html"
                                        ><li>View Report</li></a
                                      >
                                      <a
                                        class="dropdown-item btn"
                                        href="#"
                                        data-bs-target="#exampleModalToggle"
                                        data-bs-toggle="modal"
                                        ><li>Change Status</li></a
                                      >
                                    </ul>
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- pagination start from here -->
              <div class="demo">
                <nav class="pagination-outer" aria-label="Page navigation">
                  <ul class="pagination">
                    <li class="page-item">
                      <a href="#" class="page-link" aria-label="Previous">
                        <span aria-hidden="true">«</span>
                      </a>
                    </li>
                    <li class="page-item active">
                      <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item">
                      <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item">
                      <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                      <a class="page-link" href="#">4</a>
                    </li>
                    <li class="page-item">
                      <a class="page-link" href="#">5</a>
                    </li>
                    <li class="page-item">
                      <a href="#" class="page-link" aria-label="Next">
                        <span aria-hidden="true">»</span>
                      </a>
                    </li>
                  </ul>
                </nav>
              </div>
              <!-- pagination ended here -->
              <!-- footer -->
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

    <script src="/assets/admin/libs/jquery/jquery.js"></script>
    <script src="/assets/admin/libs/datatable/js/datatable.js"></script>
    <script src="/assets/admin/libs/datatable/js/datatablebootstrap.js"></script>
    <script src="/assets/admin/libs/select2/js/select2.min.js"></script>
    <script src="/assets/admin/libs/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="/assets/admin/libs/aos/js/aos.js"></script>
    <script src="/assets/admin/asset/js/bootstrap.min.js"></script>
    <script src="/assets/admin/asset/js/script.js"></script>
  </body>
</html>
<!-- ================ side js start here=============== -->
<!-- ================ side js start End=============== -->

<!--POPUP CARD-->
<div
  class="modal fade"
  id="exampleModalToggle"
  aria-hidden="true"
  aria-labelledby="exampleModalToggleLabel"
  tabindex="-1"
>
  <div class="modal-dialog modal-dialog-centered mt-5">
    <div class="modal-content mt-2">
      <div class="card-header text-center">Change Status</div>
      <div class="model_popup">
        <h1>Change Status</h1>
        <form action="">
          <p>
            <input type="radio" name="radio_group" id="radio11" checked />
            <label for="radio11"> &nbsp;&nbsp;Active Account</label>
          </p>
          <p>
            <input type="radio" name="radio_group" id="radio12" />
            <label for="radio12">&nbsp;&nbsp;Ban Account</label>
          </p>
        </form>
      </div>
    </div>
  </div>
</div>
