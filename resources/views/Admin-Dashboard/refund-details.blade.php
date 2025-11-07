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
    <link rel="stylesheet" href="assets/admin/asset/css/sallermangement.css" />
    <link rel="stylesheet" href="assets/admin/asset/css/seller-table.css" />
    <title>Super Admin Dashboard | Seller Request</title>
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
                    <span class="min-title">Payment Management</span>
                    <i class="fa-solid fa-chevron-right"></i>
                    <span class="min-title">Refund</span>
                  </div>
                </div>
              </div>
              <!-- Blue MASSEGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <i
                        class="bx bx-credit-card-front icon"
                        title="Payment Management"
                      ></i>
                      <h2>Payment Management</h2>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Filter Date Section start from here -->
              <div class="date-section">
                <div class="row">
                  <div class="col-md-8">
                    <form>
                      <div class="row align-items-center calendar-sec">
                        <div class="col-auto date-selection">
                          <div class="date-sec">
                            <i class="fa-solid fa-calendar-days"></i>
                            <select class="form-select" id="dateFilter">
                              <option value="today">Today</option>
                              <option value="yesterday">Yesterday</option>
                              <option value="today">Last Week</option>
                              <option value="today">Last 7 days</option>
                              <option value="today">Lifetime</option>
                              <option value="lastMonth">Last Month</option>
                              <option value="custom">Customise Date</option>
                            </select>
                          </div>
                        </div>
                        <div
                          class="col-auto"
                          id="fromDateFields"
                          style="display: none"
                        >
                          <div class="row">
                            <label
                              for="inputEmail3"
                              class="col-sm-3 col-form-label"
                              >From:</label
                            >
                            <div class="col-sm-9">
                              <input
                                type="date"
                                class="form-control"
                                id="fromDate"
                              />
                            </div>
                          </div>
                        </div>
                        <div
                          class="col-auto"
                          id="toDateFields"
                          style="display: none"
                        >
                          <div class="row">
                            <label
                              for="inputEmail3"
                              class="col-sm-2 col-form-label"
                              >To:</label
                            >
                            <div class="col-sm-10">
                              <input
                                type="date"
                                class="form-control"
                                id="fromDate"
                              />
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="col-md-4 search-form-sec">
                    <form>
                      <input
                        type="text"
                        name="search"
                        class="border-0"
                        placeholder="Search"
                      />
                    </form>
                  </div>
                </div>
              </div>
              <!--Filter Date section ended here -->
              <div class="content w-100 bg-light" id="vt-main-section">
                <div class="container-fluid" id="installment-contant">
                  <div class="row" id="main-contant-AI">
                    <div class="col-md-12 p-0">
                      <!-- BEGIN: INSTALLMENT TABLE SECTION -->
                      <div class="row installment-table">
                        <div class="col-md-12 p-0">
                          <div class="table-responsive">
                            <div class="hack1">
                              <div class="hack2">
                                <table class="table">
                                  <thead>
                                    <tr class="text-nowrap">
                                      <th class="h-1">Seller</th>

                                      <th class="h-4 service-type">Buyer</th>

                                      <th class="h-8 service-types">
                                        Service Type
                                      </th>

                                      <th class="h-12 service-descrip">
                                        Service Description
                                      </th>
                                      <th class="h-12 service-title">
                                        Refund Amount
                                      </th>
                                      <th class="h-12 reason-refund">
                                        Refund Reason
                                      </th>
                                      <th class="h-12">Payment Method</th>
                                      <th class="h-12 stats">Status</th>
                                      <th class="h-12 action">Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="d-flex gap-2">
                                          <span> Usama A.</span>
                                        </div>
                                      </td>
                                      <!-- <td>Usama A.</td> -->

                                      <td class="online-class">Orhan Khan</td>
                                      <td class="online-desc">Online Class</td>
                                      <td class="service-descr">
                                        I’ll Design most attractive and
                                        minimalists website for your future
                                        Brand.
                                      </td>
                                      <td class="service-decs">$1500</td>
                                      <td class="refund-desc">
                                        I didn’t agreed with the teacher
                                        behaviour.He just put old detail in his
                                        course
                                      </td>
                                      <td class="refund-date">
                                        PayPal / Stripe
                                      </td>
                                      <td class="status">
                                        <h5>
                                          <span class="badge active-badge"
                                            >Approved</span
                                          >
                                        </h5>
                                      </td>
                                      <td>
                                        <div class="expert-dropdown">
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
                                            <a class="dropdown-item" href="#"
                                              ><li>Approve</li></a
                                            >
                                            <a class="dropdown-item" href="#"
                                              ><li>Reject</li></a
                                            >
                                          </ul>
                                        </div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="d-flex gap-2">
                                          <span> Usama A.</span>
                                        </div>
                                      </td>
                                      <!-- <td>Usama A.</td> -->

                                      <td class="online-class">Orhan Khan</td>
                                      <td class="online-desc">Online Class</td>
                                      <td class="service-descr">
                                        I’ll Design most attractive and
                                        minimalists website for your future
                                        Brand.
                                      </td>
                                      <td class="service-decs">$1500</td>
                                      <td class="refund-desc">
                                        I didn’t agreed with the teacher
                                        behaviour.He just put old detail in his
                                        course
                                      </td>
                                      <td class="refund-date">
                                        PayPal / Stripe
                                      </td>
                                      <td class="status">
                                        <h5>
                                          <span class="badge active-badge"
                                            >Refunded</span
                                          >
                                        </h5>
                                      </td>
                                      <td>
                                        <div class="expert-dropdown">
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
                                            <a class="dropdown-item" href="#"
                                              ><li>Approve</li></a
                                            >
                                            <a class="dropdown-item" href="#"
                                              ><li>Reject</li></a
                                            >
                                          </ul>
                                        </div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="d-flex gap-2">
                                          <span> Usama A.</span>
                                        </div>
                                      </td>
                                      <!-- <td>Usama A.</td> -->

                                      <td class="online-class">Orhan Khan</td>
                                      <td class="online-desc">Online Class</td>
                                      <td class="service-descr">
                                        I’ll Design most attractive and
                                        minimalists website for your future
                                        Brand.
                                      </td>
                                      <td class="service-decs">$1500</td>
                                      <td class="refund-desc">
                                        I didn’t agreed with the teacher
                                        behaviour.He just put old detail in his
                                        course
                                      </td>
                                      <td class="refund-date">
                                        PayPal / Stripe
                                      </td>
                                      <td class="status">
                                        <h5>
                                          <span class="badge active-badge"
                                            >Approved</span
                                          >
                                        </h5>
                                      </td>
                                      <td>
                                        <div class="expert-dropdown">
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
                                            <a class="dropdown-item" href="#"
                                              ><li>Approve</li></a
                                            >
                                            <a class="dropdown-item" href="#"
                                              ><li>Reject</li></a
                                            >
                                          </ul>
                                        </div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="d-flex gap-2">
                                          <span> Usama A.</span>
                                        </div>
                                      </td>
                                      <!-- <td>Usama A.</td> -->

                                      <td class="online-class">Orhan Khan</td>
                                      <td class="online-desc">Online Class</td>
                                      <td class="service-descr">
                                        I’ll Design most attractive and
                                        minimalists website for your future
                                        Brand.
                                      </td>
                                      <td class="service-decs">$1500</td>
                                      <td class="refund-desc">
                                        I didn’t agreed with the teacher
                                        behaviour.He just put old detail in his
                                        course
                                      </td>
                                      <td class="refund-date">
                                        PayPal / Stripe
                                      </td>
                                      <td class="status">
                                        <h5>
                                          <span class="badge active-badge"
                                            >Rejected</span
                                          >
                                        </h5>
                                      </td>
                                      <td>
                                        <div class="expert-dropdown">
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
                                            <a class="dropdown-item" href="#"
                                              ><li>Approve</li></a
                                            >
                                            <a class="dropdown-item" href="#"
                                              ><li>Reject</li></a
                                            >
                                          </ul>
                                        </div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="d-flex gap-2">
                                          <span> Usama A.</span>
                                        </div>
                                      </td>
                                      <!-- <td>Usama A.</td> -->

                                      <td class="online-class">Orhan Khan</td>
                                      <td class="online-desc">Online Class</td>
                                      <td class="service-descr">
                                        I’ll Design most attractive and
                                        minimalists website for your future
                                        Brand.
                                      </td>
                                      <td class="service-decs">$1500</td>
                                      <td class="refund-desc">
                                        I didn’t agreed with the teacher
                                        behaviour.He just put old detail in his
                                        course
                                      </td>
                                      <td class="refund-date">
                                        PayPal / Stripe
                                      </td>
                                      <td class="status">
                                        <h5>
                                          <span class="badge active-badge"
                                            >Approved</span
                                          >
                                        </h5>
                                      </td>
                                      <td>
                                        <div class="expert-dropdown">
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
                                            <a class="dropdown-item" href="#"
                                              ><li>Approve</li></a
                                            >
                                            <a class="dropdown-item" href="#"
                                              ><li>Reject</li></a
                                            >
                                          </ul>
                                        </div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="d-flex gap-2">
                                          <span> Usama A.</span>
                                        </div>
                                      </td>
                                      <!-- <td>Usama A.</td> -->

                                      <td class="online-class">Orhan Khan</td>
                                      <td class="online-desc">Online Class</td>
                                      <td class="service-descr">
                                        I’ll Design most attractive and
                                        minimalists website for your future
                                        Brand.
                                      </td>
                                      <td class="service-decs">$1500</td>
                                      <td class="refund-desc">
                                        I didn’t agreed with the teacher
                                        behaviour.He just put old detail in his
                                        course
                                      </td>
                                      <td class="refund-date">
                                        PayPal / Stripe
                                      </td>
                                      <td class="status">
                                        <h5>
                                          <span class="badge active-badge"
                                            >Approved</span
                                          >
                                        </h5>
                                      </td>
                                      <td>
                                        <div class="expert-dropdown">
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
                                            <a class="dropdown-item" href="#"
                                              ><li>Approve</li></a
                                            >
                                            <a class="dropdown-item" href="#"
                                              ><li>Reject</li></a
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
                      <!-- END: INSTALLMENT TABLE SECTION -->
                    </div>
                  </div>
                </div>
              </div>
              <!-- end -->
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
    <script src="script.js"></script>
  </body>
</html>
<!-- Date Picker JS -->
<script>
  const dateFilter = document.getElementById("dateFilter");
  const fromDateFields = document.getElementById("fromDateFields");
  const toDateFields = document.getElementById("toDateFields");

  dateFilter.addEventListener("change", function () {
    if (dateFilter.value === "custom") {
      fromDateFields.style.display = "inline";
      toDateFields.style.display = "inline";
    } else {
      fromDateFields.style.display = "none";
      toDateFields.style.display = "none";
    }
  });
</script>
<!-- ================ side js start here=============== -->
<!-- ================ side js start End=============== -->
