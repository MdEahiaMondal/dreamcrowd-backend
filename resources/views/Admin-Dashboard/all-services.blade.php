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
    <link rel="stylesheet" href="/assets/admin/asset/css/sallermangement.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/seller-table.css" />
    <title>Super Admin Dashboard | All Services</title>
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
                    <span class="min-title">Seller Management</span>
                    <i class="fa-solid fa-chevron-right"></i>
                    <span class="min-title">All Services</span>
                  </div>
                </div>
              </div>
              <!-- Blue MASSEGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <i class="bx bxs-user-detail"></i>
                      <h2>Seller Management</h2>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Filter Date Section -->
              <div class="date-section">
                <div class="row">
                  <div class="col-md-8">
                    <div class="user-all-seller-drop">
                      <!-- first drop dawon  -->
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
                                <option value="custom">Any Date</option>
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
                      <!-- sceond drop -->
                      <form>
                        <div class="row align-items-center calendar-sec">
                          <div class="col-auto date-selection">
                            <div class="date-sec filter-drop">
                              <i
                                class="bx bx-filter icon"
                                title="Analytics &amp; Reports"
                              ></i>
                              <select class="form-select" id="dateFilter">
                                <option value="">Sort by Date</option>
                                <option value="">Top Reviews</option>
                                <option value="">Top Sellers</option>
                                <option value="">Class Online</option>
                                <option value="">Freelance Online</option>
                                <option value="">Class In-Person</option>
                                <option value="">Freelance In-Person</option>
                                <option value="">Trending</option>
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
                  </div>
                  <div class="col-md-4 search-form-sec">
                    <form>
                      <input
                        type="text"
                        class="filter-drop"
                        name="search"
                        placeholder="Search"
                      />
                    </form>
                  </div>
                </div>
              </div>
              <!--Filter Date section ended here -->
              <div class="row">
                <div class="col-md-12">
                  <!-- < class="d-flex justify-content-center align-items-center bg-light"> -->
                  <div class="super-tab-nav">
                    <nav>
                      <div
                        class="nav nav-tabs mb-3"
                        id="nav-tab"
                        role="tablist"
                      >
                        <button
                          class="nav-link active"
                          id="nav-home-tab"
                          data-bs-toggle="tab"
                          data-bs-target="#nav-home"
                          type="button"
                          role="tab"
                          aria-controls="nav-home"
                          aria-selected="true"
                        >
                          Newly Created
                        </button>
                        <button
                          class="nav-link"
                          id="nav-profile-tab"
                          data-bs-toggle="tab"
                          data-bs-target="#nav-profile"
                          type="button"
                          role="tab"
                          aria-controls="nav-profile"
                          aria-selected="false"
                        >
                          Active Services
                        </button>

                        <button
                          class="nav-link"
                          id="nav-account-tab"
                          data-bs-toggle="tab"
                          data-bs-target="#nav-account"
                          type="button"
                          role="tab"
                          aria-controls="nav-account"
                          aria-selected="false"
                        >
                          Delivered Services
                        </button>
                        <button
                          class="nav-link"
                          id="nav-delet-tab"
                          data-bs-toggle="tab"
                          data-bs-target="#nav-delet"
                          type="button"
                          role="tab"
                          aria-controls="nav-delet"
                          aria-selected="false"
                        >
                          Cancelled Services
                        </button>
                        <button
                          class="nav-link"
                          id="nav-complete-tab"
                          data-bs-toggle="tab"
                          data-bs-target="#nav-complete"
                          type="button"
                          role="tab"
                          aria-controls="nav-complete"
                          aria-selected="false"
                        >
                          Completed Services
                        </button>
                      </div>
                    </nav>
                  </div>
                  <div class="tab-content border bg-light" id="nav-tabContent">
                    <div
                      class="tab-pane fade active show"
                      id="nav-home"
                      role="tabpanel"
                      aria-labelledby="nav-home-tab"
                    >
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

                                              <th class="h-3">Reg. Date</th>

                                              <th class="h-4">Service Type</th>
                                              <th class="h-5">Category</th>

                                              <th class="h-11">
                                                Service Title
                                              </th>
                                              <th class="h-8">
                                                Delivery Option
                                              </th>
                                              <th class="h-10">Action</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>

                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Our Experts
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Trending Services
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Set Commission Rate
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>Hide Service</li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Cancel Service
                                                      </li></a
                                                    >
                                                  </ul>
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>
                                              <!-- <td>Usama A.</td> -->
                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Our Experts
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Trending Services
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Set Commission Rate
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>Hide Service</li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Cancel Service
                                                      </li></a
                                                    >
                                                  </ul>
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>
                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Our Experts
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Trending Services
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Set Commission Rate
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>Hide Service</li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Cancel Service
                                                      </li></a
                                                    >
                                                  </ul>
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>
                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Our Experts
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Trending Services
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Set Commission Rate
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>Hide Service</li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Cancel Service
                                                      </li></a
                                                    >
                                                  </ul>
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>
                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Our Experts
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Trending Services
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Set Commission Rate
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>Hide Service</li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Cancel Service
                                                      </li></a
                                                    >
                                                  </ul>
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>
                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Our Experts
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Trending Services
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Set Commission Rate
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>Hide Service</li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Cancel Service
                                                      </li></a
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
                    </div>
                    <div
                      class="tab-pane fade"
                      id="nav-profile"
                      role="tabpanel"
                      aria-labelledby="nav-profile-tab"
                    >
                      <!-- BEGIN: SIDBAR -->
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

                                              <th class="h-3">Reg. Date</th>

                                              <th class="h-4">Service Type</th>
                                              <th class="h-5">Category</th>

                                              <th class="h-11">
                                                Service Title
                                              </th>
                                              <th class="h-8">
                                                Delivery Option
                                              </th>
                                              <th class="h-10">Action</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>

                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Our Experts
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Trending Services
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Set Commission Rate
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>Hide Service</li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Cancel Service
                                                      </li></a
                                                    >
                                                  </ul>
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>
                                              <!-- <td>Usama A.</td> -->
                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Our Experts
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Trending Services
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Set Commission Rate
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>Hide Service</li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Cancel Service
                                                      </li></a
                                                    >
                                                  </ul>
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>
                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Our Experts
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Trending Services
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Set Commission Rate
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>Hide Service</li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Cancel Service
                                                      </li></a
                                                    >
                                                  </ul>
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>
                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Our Experts
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Trending Services
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Set Commission Rate
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>Hide Service</li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Cancel Service
                                                      </li></a
                                                    >
                                                  </ul>
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>
                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Our Experts
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Trending Services
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Set Commission Rate
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>Hide Service</li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Cancel Service
                                                      </li></a
                                                    >
                                                  </ul>
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>
                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Our Experts
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Trending Services
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Set Commission Rate
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>Hide Service</li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Cancel Service
                                                      </li></a
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
                    </div>

                    <!-- acount tab -->
                    <div
                      class="tab-pane fade"
                      id="nav-account"
                      role="tabpanel"
                      aria-labelledby="nav-account-tab"
                    >
                      <!-- BEGIN: SIDBAR -->
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

                                              <th class="h-3">Reg. Date</th>

                                              <th class="h-4">Service Type</th>
                                              <th class="h-5">Category</th>

                                              <th class="h-11">
                                                Service Title
                                              </th>
                                              <th class="h-8">
                                                Delivery Option
                                              </th>
                                              <th class="h-10">Action</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>

                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Our Experts
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Trending Services
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Set Commission Rate
                                                      </li></a
                                                    >
                                                  </ul>
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>
                                              <!-- <td>Usama A.</td> -->
                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Our Experts
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Trending Services
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Set Commission Rate
                                                      </li></a
                                                    >
                                                  </ul>
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>
                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Our Experts
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Trending Services
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Set Commission Rate
                                                      </li></a
                                                    >
                                                  </ul>
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>
                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Our Experts
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Trending Services
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Set Commission Rate
                                                      </li></a
                                                    >
                                                  </ul>
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>
                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Our Experts
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Trending Services
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Set Commission Rate
                                                      </li></a
                                                    >
                                                  </ul>
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>
                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Our Experts
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Trending Services
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Set Commission Rate
                                                      </li></a
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
                    </div>
                    <!-- delet tb -->
                    <div
                      class="tab-pane fade"
                      id="nav-delet"
                      role="tabpanel"
                      aria-labelledby="nav-delet-tab"
                    >
                      <!-- BEGIN: SIDBAR -->
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

                                              <th class="h-3">Reg. Date</th>

                                              <th class="h-4">Service Type</th>
                                              <th class="h-5">Category</th>

                                              <th class="h-11">
                                                Service Title
                                              </th>
                                              <th class="h-8">
                                                Delivery Option
                                              </th>
                                              <th class="h-10">Action</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>

                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>
                                              <!-- <td>Usama A.</td> -->
                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>
                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>
                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>
                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>
                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                    </div>
                    <!-- acount tab -->

                    <div
                      class="tab-pane fade"
                      id="nav-complete"
                      role="tabpanel"
                      aria-labelledby="nav-complete-tab"
                    >
                      <!-- BEGIN: SIDBAR -->
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

                                              <th class="h-3">Reg. Date</th>

                                              <th class="h-4">Service Type</th>
                                              <th class="h-5">Category</th>

                                              <th class="h-11">
                                                Service Title
                                              </th>
                                              <th class="h-8">
                                                Delivery Option
                                              </th>
                                              <th class="h-10">Action</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>

                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Our Experts
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Trending Services
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Set Commission Rate
                                                      </li></a
                                                    >
                                                  </ul>
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>
                                              <!-- <td>Usama A.</td> -->
                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Our Experts
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Trending Services
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Set Commission Rate
                                                      </li></a
                                                    >
                                                  </ul>
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>
                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Our Experts
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Trending Services
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Set Commission Rate
                                                      </li></a
                                                    >
                                                  </ul>
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>
                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Our Experts
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Trending Services
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Set Commission Rate
                                                      </li></a
                                                    >
                                                  </ul>
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>
                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Our Experts
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Trending Services
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Set Commission Rate
                                                      </li></a
                                                    >
                                                  </ul>
                                                </div>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <div class="d-flex gap-2">
                                                  <img
                                                    src="/assets/admin/asset/img/Ellipse 348.svg"
                                                    alt=""
                                                  />
                                                  <span> Usama A.</span>
                                                </div>
                                              </td>
                                              <td>October 23, 2023</td>
                                              <td>Freelance Service</td>
                                              <td>Graphic Design</td>
                                              <td>
                                                I’ll Design most attractive and
                                                minimalists website
                                              </td>
                                              <td>In Person</td>
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
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Our Experts
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      ><li>
                                                        Add to Trending Services
                                                      </li></a
                                                    >
                                                    <a
                                                      class="dropdown-item"
                                                      href="#"
                                                      type="button"
                                                      class="btn btn-primary"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#commission-modal"
                                                      ><li>
                                                        Set Commission Rate
                                                      </li></a
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
<!-- Commission Modal Here -->

<!-- Modal -->
<div
  class="modal fade"
  id="commission-modal"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog">
    <div class="modal-content modal-commisssion">
      <div class="modal-body p-0 commisssion-data">
        <label for="">Commission Rate</label>
        <input type="text" placeholder="20" class="form-control" />
        <label for="" class="com-rate">Commission Type</label>
        <select name="" id="" class="form-control">
          <option value="">-- Select Option --</option>
          <option value="">Percentage</option>
          <option value="">Fixed</option>
        </select>
        <button class="float-start cancel-com">Cancel</button>
        <button class="float-end add-com">Add</button>
      </div>
    </div>
  </div>
</div>

