<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <!-- View Point scale to 1.0 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link rel="stylesheet" type="text/css" href="assets/admin/asset/css/bootstrap.min.css" />
     <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
     <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
     <!-- jquery script -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/admin/asset/css/style.css">
    <link rel="stylesheet" href="assets/admin/asset/css/buyer.css">
    <!-- <link rel="stylesheet" href="../User-Dashboard/assets/css/style.css"> -->
    <title>Super Admin Dashboard | Buyer Management</title>
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
                                  <span class="min-title">Buyer Management</span>
                                  </div>
                              </div>
                          </div>
                          <!-- Blue MASSEGES section -->
                  <div class="user-notification">
                      <div class="row">
                          <div class="col-md-12">
                              <div class="notify">
                                <i class='bx bx-user icon' title="Buyer Management"></i>
                                  <h2>Buyer Management</h2>
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
                      <input type="text" class="filter-drop border-0" name="search" placeholder="Search" />
                    </form>
                  </div>
                </div>
              </div>
              <!--Filter Date section ended here -->
              <div class="row">
                <div class="col-md-12">
                  <div class="page-content">
                    <div class="nav-tabs">
                    <nav>
                      <ul class="tabs">
                        <li class="tab-li">
                          <a href="#tab1" class="tab-li__link">Active Accounts</a>
                        </li>
                        <li class="tab-li">
                          <a href="#tab2" class="tab-li__link">Inactive Accounts</a>
                        </li>
                        <li class="tab-li">
                          <a href="#tab3" class="tab-li__link">Banned Accounts</a>
                        </li>
                        <li class="tab-li">
                          <a href="#tab4" class="tab-li__link">Deleted Accounts</a>
                        </li>
                        
                      </ul>
                    </nav>
                  </div>
                </div>
                </div>
              </div> 
                  <div>
                    <section id="tab1" data-tab-content>
                      <p class="tab__content">
                        <div >
                          <!-- BEGIN: MAIN SECTION -->
                          <div>
                              <div id="installment-contant">
                                  <div class="row" id="main-contant-AI">
                                      <div class="col-md-12">
                                          <!-- BEGIN: INSTALLMENT TABLE SECTION -->
                                          <div class="row installment-table">
                                              <div class="col-md-12">
                                                  <div class="table-responsive table-desc">
                                                      <div class="hack1">
                                                          <div class="hack2">
                                                              <table class="table">
                                                                  <thead>
                                                                      <tr class="text-nowrap">
                                                                          
                                                                          <th>Applicant</th>
                                                                          <th>Email</th>
                                                                          <th>Registration Date</th>
                                                                          <th>Total Order</th>
                                                                          <th>Total Amount</th>
                                                                          <th>Status</th>
                                                                          <th>Last Active</th>
                                                                          <th>Action</th>
                                                                          
                                                                      </tr>
                                                                  </thead>
                                                                  <tbody>
                                                                      <tr>
                                                                          
                                                                        <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                          <td>example@company.com</td>
                                                                          <td>October 23, 2023</td>
                                                                          <td>400</td>
                                                                          <td>$ 14,840</td>
                                                                          <td><span class="badge servce-class-badge">Active</span></td>
                                                                          <td>Last month ago</td>
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
                                                                                    View dashboard
                                                                                  </li></a
                                                                                >
                                                                                <a
                                                                                  class="dropdown-item"
                                                                                  href="#"
                                                                                  ><li> delete account</li></a
                                                                                >
                                                                                <a
                                                                                  class="dropdown-item"
                                                                                  href="#"
                                                                                  ><li>ban account</li></a
                                                                                >
                                                                              </ul>
                                                                            </div>
                                                                          </td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                          <td>example@company.com</td>
                                                                          <td>October 23, 2023</td>
                                                                          <td>400</td>
                                                                          <td>$ 14,840</td>
                                                                          <td><span class="badge servce-class-badge">Active</span></td>
                                                                          <td>Last month ago</td>
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
                                                                                    View dashboard
                                                                                  </li></a
                                                                                >
                                                                                <a
                                                                                  class="dropdown-item"
                                                                                  href="#"
                                                                                  ><li> delete account</li></a
                                                                                >
                                                                                <a
                                                                                  class="dropdown-item"
                                                                                  href="#"
                                                                                  ><li>ban account</li></a
                                                                                >
                                                                              </ul>
                                                                            </div>
                                                                          </td>
                                                                        </tr>
                                                                      <tr>
                                                                        <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                        <td>example@company.com</td>
                                                                        <td>October 23, 2023</td>
                                                                        <td>400</td>
                                                                        <td>$ 14,840</td>
                                                                        <td><span class="badge servce-class-badge">Active</span></td>
                                                                        <td>Last month ago</td>
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
                                                                                  View dashboard
                                                                                </li></a
                                                                              >
                                                                              <a
                                                                                class="dropdown-item"
                                                                                href="#"
                                                                                ><li> delete account</li></a
                                                                              >
                                                                              <a
                                                                                class="dropdown-item"
                                                                                href="#"
                                                                                ><li>ban account</li></a
                                                                              >
                                                                            </ul>
                                                                          </div>
                                                                        </td>
                                                                      </tr>
                                                                      <tr>
                                                                         
                                                                        <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                          <td>example@company.com</td>
                                                                          <td>October 23, 2023</td>
                                                                          <td>400</td>
                                                                          <td>$ 14,840</td>
                                                                          <td><span class="badge servce-class-badge">Active</span></td>
                                                                          <td>Last month ago</td>
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
                                                                                    View dashboard
                                                                                  </li></a
                                                                                >
                                                                                <a
                                                                                  class="dropdown-item"
                                                                                  href="#"
                                                                                  ><li> delete account</li></a
                                                                                >
                                                                                <a
                                                                                  class="dropdown-item"
                                                                                  href="#"
                                                                                  ><li>ban account</li></a
                                                                                >
                                                                              </ul>
                                                                            </div>
                                                                          </td>
                                                                         </tr>
                                                                      <tr>
                                                                        <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                        <td>example@company.com</td>
                                                                        <td>October 23, 2023</td>
                                                                        <td>400</td>
                                                                        <td>$ 14,840</td>
                                                                        <td><span class="badge servce-class-badge">Active</span></td>
                                                                        <td>Last month ago</td>
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
                                                                                  View dashboard
                                                                                </li></a
                                                                              >
                                                                              <a
                                                                                class="dropdown-item"
                                                                                href="#"
                                                                                ><li> delete account</li></a
                                                                              >
                                                                              <a
                                                                                class="dropdown-item"
                                                                                href="#"
                                                                                ><li>ban account</li></a
                                                                              >
                                                                            </ul>
                                                                          </div>
                                                                        </td>   
                                                                        
                                                                      </tr>
                                                                      <tr>
                                                                          
                                                                        <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                        <td>example@company.com</td>
                                                                        <td>October 23, 2023</td>
                                                                        <td>400</td>
                                                                        <td>$ 14,840</td>
                                                                        <td><span class="badge servce-class-badge">Active</span></td>
                                                                        <td>Last month ago</td>
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
                                                                                  View dashboard
                                                                                </li></a
                                                                              >
                                                                              <a
                                                                                class="dropdown-item"
                                                                                href="#"
                                                                                ><li> delete account</li></a
                                                                              >
                                                                              <a
                                                                                class="dropdown-item"
                                                                                href="#"
                                                                                ><li>ban account</li></a
                                                                              >
                                                                            </ul>
                                                                          </div>
                                                                        </td>
                                                                      </tr>
                                                                      <tr>
                                                                       
                                                                        <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                          <td>example@company.com</td>
                                                                          <td>October 23, 2023</td>
                                                                          <td>400</td>
                                                                          <td>$ 14,840</td>
                                                                          <td><span class="badge servce-class-badge">Active</span></td>
                                                                          <td>Last month ago</td>
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
                                                                                    View dashboard
                                                                                  </li></a
                                                                                >
                                                                                <a
                                                                                  class="dropdown-item"
                                                                                  href="#"
                                                                                  ><li> delete account</li></a
                                                                                >
                                                                                <a
                                                                                  class="dropdown-item"
                                                                                  href="#"
                                                                                  ><li>ban account</li></a
                                                                                >
                                                                              </ul>
                                                                            </div>
                                                                          </td>
                                                                          </tr>
                                                                      <tr>
                                                                        <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                          <td>example@company.com</td>
                                                                          <td>October 23, 2023</td>
                                                                          <td>400</td>
                                                                          <td>$ 14,840</td>
                                                                          <td><span class="badge servce-class-badge">Active</span></td>
                                                                          <td>Last month ago</td>
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
                                                                                    View dashboard
                                                                                  </li></a
                                                                                >
                                                                                <a
                                                                                  class="dropdown-item"
                                                                                  href="#"
                                                                                  ><li> delete account</li></a
                                                                                >
                                                                                <a
                                                                                  class="dropdown-item"
                                                                                  href="#"
                                                                                  ><li>ban account</li></a
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
                        </div>
                      </p>
                  
                    </section>
                  </div>
                    <section id="tab2" data-tab-content class="">
                      <p class="tab__content">
                        <div>
                          <!-- BEGIN: MAIN SECTION -->
                          <div>
                              <div>
                                  <div class="row" id="main-contant-AI">
                                      <div class="col-md-12">
                                          <!-- BEGIN: INSTALLMENT TABLE SECTION -->
                                          <div class="row installment-table">
                                            <div class="col-md-12">
                                                <div class="table-responsive table-desc">
                                                    <div class="hack1">
                                                        <div class="hack2">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr class="text-nowrap">
                                                                       
                                                                      <th>Applicant</th>
                                                                      <th>Email</th>
                                                                      <th>Registration Date</th>
                                                                      <th>Total Order</th>
                                                                      <th>Total Amount</th>
                                                                      <th>Status</th>
                                                                      <th>Last Active</th>
                                                                      <th>Action</th>
                                                                        
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        
                                                                      <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                      <td>example@company.com</td>
                                                                      <td>October 23, 2023</td>
                                                                      <td>400</td>
                                                                      <td>$ 14,840</td>
                                                                      <td><span class="badge servce-clas-badge">Inactive</span></td>
                                                                      <td>Last month ago</td>
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
                                                                                View dashboard
                                                                              </li></a
                                                                            >
                                                                            <a
                                                                              class="dropdown-item"
                                                                              href="#"
                                                                              ><li> delete account</li></a
                                                                            >
                                                                            <a
                                                                              class="dropdown-item"
                                                                              href="#"
                                                                              ><li>ban account</li></a
                                                                            >
                                                                          </ul>
                                                                        </div>
                                                                      </td>
                                                                     
                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                      <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                      <td>example@company.com</td>
                                                                      <td>October 23, 2023</td>
                                                                      <td>400</td>
                                                                      <td>$ 14,840</td>
                                                                      <td><span class="badge servce-clas-badge">Inactive</span></td>
                                                                      <td>Last month ago</td>
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
                                                                                View dashboard
                                                                              </li></a
                                                                            >
                                                                            <a
                                                                              class="dropdown-item"
                                                                              href="#"
                                                                              ><li> delete account</li></a
                                                                            >
                                                                            <a
                                                                              class="dropdown-item"
                                                                              href="#"
                                                                              ><li>ban account</li></a
                                                                            >
                                                                          </ul>
                                                                        </div>
                                                                      </td>  
                                                                     
                                                                    </tr>
                                                                    <tr>
                                                                      <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                      <td>example@company.com</td>
                                                                      <td>October 23, 2023</td>
                                                                      <td>400</td>
                                                                      <td>$ 14,840</td>
                                                                      <td><span class="badge servce-clas-badge">Inactive</span></td>
                                                                      <td>Last month ago</td>
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
                                                                                View dashboard
                                                                              </li></a
                                                                            >
                                                                            <a
                                                                              class="dropdown-item"
                                                                              href="#"
                                                                              ><li> delete account</li></a
                                                                            >
                                                                            <a
                                                                              class="dropdown-item"
                                                                              href="#"
                                                                              ><li>ban account</li></a
                                                                            >
                                                                          </ul>
                                                                        </div>
                                                                      </td>
                                                                     
                                                                    </tr>
                                                                    <tr>
                                                                      <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                      <td>example@company.com</td>
                                                                      <td>October 23, 2023</td>
                                                                      <td>400</td>
                                                                      <td>$ 14,840</td>
                                                                      <td><span class="badge servce-clas-badge">Inactive</span></td>
                                                                      <td>Last month ago</td>
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
                                                                                View dashboard
                                                                              </li></a
                                                                            >
                                                                            <a
                                                                              class="dropdown-item"
                                                                              href="#"
                                                                              ><li> delete account</li></a
                                                                            >
                                                                            <a
                                                                              class="dropdown-item"
                                                                              href="#"
                                                                              ><li>ban account</li></a
                                                                            >
                                                                          </ul>
                                                                        </div>
                                                                      </td> 
                                                                     
                                                                    </tr>
                                                                    <tr>
                                                                      <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                      <td>example@company.com</td>
                                                                      <td>October 23, 2023</td>
                                                                      <td>400</td>
                                                                      <td>$ 14,840</td>
                                                                      <td><span class="badge servce-clas-badge">Inactive</span></td>
                                                                      <td>Last month ago</td>
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
                                                                                View dashboard
                                                                              </li></a
                                                                            >
                                                                            <a
                                                                              class="dropdown-item"
                                                                              href="#"
                                                                              ><li> delete account</li></a
                                                                            >
                                                                            <a
                                                                              class="dropdown-item"
                                                                              href="#"
                                                                              ><li>ban account</li></a
                                                                            >
                                                                          </ul>
                                                                        </div>
                                                                      </td>  
                                                                     
                                                                    </tr>
                                                                    <tr>
                                                                      <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                      <td>example@company.com</td>
                                                                      <td>October 23, 2023</td>
                                                                      <td>400</td>
                                                                      <td>$ 14,840</td>
                                                                      <td><span class="badge servce-clas-badge">Inactive</span></td>
                                                                      <td>Last month ago</td>
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
                                                                                View dashboard
                                                                              </li></a
                                                                            >
                                                                            <a
                                                                              class="dropdown-item"
                                                                              href="#"
                                                                              ><li> delete account</li></a
                                                                            >
                                                                            <a
                                                                              class="dropdown-item"
                                                                              href="#"
                                                                              ><li>ban account</li></a
                                                                            >
                                                                          </ul>
                                                                        </div>
                                                                      </td>  
                                                                     
                                                                    </tr>
                                                                    <tr>
                                                                      <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                          <td>example@company.com</td>
                                                                          <td>October 23, 2023</td>
                                                                          <td>400</td>
                                                                          <td>$ 14,840</td>
                                                                          <td><span class="badge servce-clas-badge">Inactive</span></td>
                                                                          <td>Last month ago</td>
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
                                                                                    View dashboard
                                                                                  </li></a
                                                                                >
                                                                                <a
                                                                                  class="dropdown-item"
                                                                                  href="#"
                                                                                  ><li> delete account</li></a
                                                                                >
                                                                                <a
                                                                                  class="dropdown-item"
                                                                                  href="#"
                                                                                  ><li>ban account</li></a
                                                                                >
                                                                              </ul>
                                                                            </div>
                                                                          </td>  
                                                                         
                                                                    </tr>
                                                                    <tr>
                                                                      <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                      <td>example@company.com</td>
                                                                      <td>October 23, 2023</td>
                                                                      <td>400</td>
                                                                      <td>$ 14,840</td>
                                                                      <td><span class="badge servce-clas-badge">Inactive</span></td>
                                                                      <td>Last month ago</td>
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
                                                                                View dashboard
                                                                              </li></a
                                                                            >
                                                                            <a
                                                                              class="dropdown-item"
                                                                              href="#"
                                                                              ><li> delete account</li></a
                                                                            >
                                                                            <a
                                                                              class="dropdown-item"
                                                                              href="#"
                                                                              ><li>ban account</li></a
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
                        </div>
                      </p>
                    </section>
                   
                   
                    <section id="tab3" data-tab-content class="">
                      <p class="tab__content">
                        <div class="main-container d-flex">
                          <!-- BEGIN: MAIN SECTION -->
                          <div>
                              <div>
                                  <div class="row" id="main-contant-AI">
                                      <div class="col-md-12">
                                          <!-- BEGIN: INSTALLMENT TABLE SECTION -->
                                          <div class="row installment-table">
                                            <div class="col-md-12">
                                                <div class="table-responsive table-desc">
                                                    <div class="hack1">
                                                        <div class="hack2">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr class="text-nowrap">
                                                                       
                                                                      <th>Applicant</th>
                                                                      <th>Email</th>
                                                                      <th>Registration Date</th>
                                                                      <th>Total Order</th>
                                                                      <th>Total Amount</th>
                                                                      <th>Status</th>
                                                                      <th>Last Active</th>
                                                                      <th>Action</th>
                                                                      
                                                                        
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        
                                                                      <td><img class="Buyer-img" src="assetsassets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                      <td>example@company.com</td>
                                                                      <td>October 23, 2023</td>
                                                                      <td>400</td>
                                                                      <td>$ 14,840</td>
                                                                      <td><span class="badge servce-clas-badg">Banned</span></td>
                                                                      <td>Last month ago</td>
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
                                                                                View dashboard
                                                                              </li></a
                                                                            >
                                                                            <a
                                                                              class="dropdown-item"
                                                                              href="#"
                                                                              ><li> unban</li></a
                                                                            >
                                                                            
                                                                          </ul>
                                                                        </div>
                                                                      </td>  
                                                                     
                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                         
                                                                      <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                      <td>example@company.com</td>
                                                                      <td>October 23, 2023</td>
                                                                      <td>400</td>
                                                                      <td>$ 14,840</td>
                                                                      <td><span class="badge servce-clas-badg">Banned</span></td>
                                                                      <td>Last month ago</td>
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
                                                                                View dashboard
                                                                              </li></a
                                                                            >
                                                                            <a
                                                                              class="dropdown-item"
                                                                              href="#"
                                                                              ><li> unban</li></a
                                                                            >
                                                                            
                                                                          </ul>
                                                                        </div>
                                                                      </td>    
                                                                    
                                                                    </tr>
                                                                    <tr>
                                                                           
                                                                      <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                      <td>example@company.com</td>
                                                                      <td>October 23, 2023</td>
                                                                      <td>400</td>
                                                                      <td>$ 14,840</td>
                                                                      <td><span class="badge servce-clas-badg">Banned</span></td>
                                                                      <td>Last month ago</td>
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
                                                                                View dashboard
                                                                              </li></a
                                                                            >
                                                                            <a
                                                                              class="dropdown-item"
                                                                              href="#"
                                                                              ><li> unban</li></a
                                                                            >
                                                                            
                                                                          </ul>
                                                                        </div>
                                                                      </td>   
                                                                    
                                                                    </tr>
                                                                    <tr>
                                                                         
                                                                      <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                      <td>example@company.com</td>
                                                                      <td>October 23, 2023</td>
                                                                      <td>400</td>
                                                                      <td>$ 14,840</td>
                                                                      <td><span class="badge servce-clas-badg">Banned</span></td>
                                                                      <td>Last month ago</td>
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
                                                                                View dashboard
                                                                              </li></a
                                                                            >
                                                                            <a
                                                                              class="dropdown-item"
                                                                              href="#"
                                                                              ><li> unban</li></a
                                                                            >
                                                                            
                                                                          </ul>
                                                                        </div>
                                                                      </td>    
                                                                    
                                                                    </tr>
                                                                    <tr>
                                                                           
                                                                      <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                      <td>example@company.com</td>
                                                                      <td>October 23, 2023</td>
                                                                      <td>400</td>
                                                                      <td>$ 14,840</td>
                                                                      <td><span class="badge servce-clas-badg">Banned</span></td>
                                                                      <td>Last month ago</td>
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
                                                                                View dashboard
                                                                              </li></a
                                                                            >
                                                                            <a
                                                                              class="dropdown-item"
                                                                              href="#"
                                                                              ><li> unban</li></a
                                                                            >
                                                                            
                                                                          </ul>
                                                                        </div>
                                                                      </td>   
                                                                    
                                                                    </tr>
                                                                    <tr>
                                                                          
                                                                      <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                      <td>example@company.com</td>
                                                                      <td>October 23, 2023</td>
                                                                      <td>400</td>
                                                                      <td>$ 14,840</td>
                                                                      <td><span class="badge servce-clas-badg">Banned</span></td>
                                                                      <td>Last month ago</td>
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
                                                                                View dashboard
                                                                              </li></a
                                                                            >
                                                                            <a
                                                                              class="dropdown-item"
                                                                              href="#"
                                                                              ><li> unban</li></a
                                                                            >
                                                                            
                                                                          </ul>
                                                                        </div>
                                                                      </td>    
                                                                    
                                                                    </tr>
                                                                    <tr>
                                                                         
                                                                      <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                      <td>example@company.com</td>
                                                                      <td>October 23, 2023</td>
                                                                      <td>400</td>
                                                                      <td>$ 14,840</td>
                                                                      <td><span class="badge servce-clas-badg">Banned</span></td>
                                                                      <td>Last month ago</td>
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
                                                                                View dashboard
                                                                              </li></a
                                                                            >
                                                                            <a
                                                                              class="dropdown-item"
                                                                              href="#"
                                                                              ><li> unban</li></a
                                                                            >
                                                                            
                                                                          </ul>
                                                                        </div>
                                                                      </td>    
                                                                    
                                                                    </tr>
                                                                    <tr>
                                                                      
                                                                      <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                      <td>example@company.com</td>
                                                                      <td>October 23, 2023</td>
                                                                      <td>400</td>
                                                                      <td>$ 14,840</td>
                                                                      <td><span class="badge servce-clas-badg">Banned</span></td>
                                                                      <td>Last month ago</td>
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
                                                                                View dashboard
                                                                              </li></a
                                                                            >
                                                                            <a
                                                                              class="dropdown-item"
                                                                              href="#"
                                                                              ><li> unban</li></a
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
                        </div>
                      </p>
                  </section>
                
                  <section id="tab4" data-tab-content class="">
                    <p class="tab__content">
                      <div class="main-container d-flex">
                        <!-- BEGIN: MAIN SECTION -->
                        <div>
                            <div>
                                <div class="row" id="main-contant-AI">
                                    <div class="col-md-12">
                                        <!-- BEGIN: INSTALLMENT TABLE SECTION -->
                                        <div class="row installment-table">
                                          <div class="col-md-12">
                                              <div class="table-responsive table-desc">
                                                  <div class="hack1">
                                                      <div class="hack2">
                                                          <table class="table">
                                                              <thead>
                                                                  <tr class="text-nowrap">
                                                                     
                                                                    <th>Applicant</th>
                                                                    <th>Email</th>
                                                                    <th>Registration Date</th>
                                                                    <th>Total Order</th>
                                                                    <th>Total Amount</th>
                                                                    <th>Status</th>
                                                                    <th>Last Active</th>
                                                                    <th>Action</th>
                                                                    
                                                                      
                                                                  </tr>
                                                              </thead>
                                                              <tbody>
                                                                  <tr>
                                                                      
                                                                    <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                    <td>example@company.com</td>
                                                                    <td>October 23, 2023</td>
                                                                    <td>400</td>
                                                                    <td>$ 14,840</td>
                                                                    <td><span class="badge servce-clas-badg">Deleted</span></td>
                                                                    <td>Last month ago</td>
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
                                                                              View dashboard
                                                                            </li></a
                                                                          >
                                                                          
                                                                        </ul>
                                                                      </div>
                                                                    </td>   
                                                                   
                                                                      
                                                                  </tr>
                                                                  <tr>
                                                                       
                                                                    <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                    <td>example@company.com</td>
                                                                    <td>October 23, 2023</td>
                                                                    <td>400</td>
                                                                    <td>$ 14,840</td>
                                                                    <td><span class="badge servce-clas-badg">Deleted</span></td>
                                                                    <td>Last month ago</td>
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
                                                                              View dashboard
                                                                            </li></a
                                                                          >
                                                                          
                                                                        </ul>
                                                                      </div>
                                                                    </td>   
                                                                  
                                                                  </tr>
                                                                  <tr>
                                                                         
                                                                    <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                    <td>example@company.com</td>
                                                                    <td>October 23, 2023</td>
                                                                    <td>400</td>
                                                                    <td>$ 14,840</td>
                                                                    <td><span class="badge servce-clas-badg">Deleted</span></td>
                                                                    <td>Last month ago</td>
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
                                                                              View dashboard
                                                                            </li></a
                                                                          >
                                                                          
                                                                        </ul>
                                                                      </div>
                                                                    </td>   
                                                                  
                                                                  </tr>
                                                                  <tr>
                                                                       
                                                                    <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                    <td>example@company.com</td>
                                                                    <td>October 23, 2023</td>
                                                                    <td>400</td>
                                                                    <td>$ 14,840</td>
                                                                    <td><span class="badge servce-clas-badg">Deleted</span></td>
                                                                    <td>Last month ago</td>
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
                                                                              View dashboard
                                                                            </li></a
                                                                          >
                                                                          
                                                                        </ul>
                                                                      </div>
                                                                    </td>  
                                                                  
                                                                  </tr>
                                                                  <tr>
                                                                         
                                                                    <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                    <td>example@company.com</td>
                                                                    <td>October 23, 2023</td>
                                                                    <td>400</td>
                                                                    <td>$ 14,840</td>
                                                                    <td><span class="badge servce-clas-badg">Deleted</span></td>
                                                                    <td>Last month ago</td>
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
                                                                              View dashboard
                                                                            </li></a
                                                                          >
                                                                          
                                                                        </ul>
                                                                      </div>
                                                                    </td>   
                                                                  
                                                                  </tr>
                                                                  <tr>
                                                                        
                                                                    <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                    <td>example@company.com</td>
                                                                    <td>October 23, 2023</td>
                                                                    <td>400</td>
                                                                    <td>$ 14,840</td>
                                                                    <td><span class="badge servce-clas-badg">Deleted</span></td>
                                                                    <td>Last month ago</td>
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
                                                                              View dashboard
                                                                            </li></a
                                                                          >
                                                                          
                                                                        </ul>
                                                                      </div>
                                                                    </td> 
                                                                  
                                                                  </tr>
                                                                  <tr>
                                                                       
                                                                    <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                    <td>example@company.com</td>
                                                                    <td>October 23, 2023</td>
                                                                    <td>400</td>
                                                                    <td>$ 14,840</td>
                                                                    <td><span class="badge servce-clas-badg">Deleted</span></td>
                                                                    <td>Last month ago</td>
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
                                                                              View dashboard
                                                                            </li></a
                                                                          >
                                                                          
                                                                        </ul>
                                                                      </div>
                                                                    </td>  
                                                                  
                                                                  </tr>
                                                                  <tr>
                                                                    
                                                                    <td><img class="Buyer-img" src="assets/admin/asset/img/profile.png" ><span class="para-1">Usama A.</span></td>
                                                                    <td>example@company.com</td>
                                                                    <td>October 23, 2023</td>
                                                                    <td>400</td>
                                                                    <td>$ 14,840</td>
                                                                    <td><span class="badge servce-clas-badg">Deleted</span></td>
                                                                    <td>Last month ago</td>
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
                                                                              View dashboard
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
                      </div>
                    </p>
                </section>
                  
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
 <!-- tabs js start here -->
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
<!-- tabs js ended here -->
<!-- ================ side js start here=============== -->
<script>
  // Sidebar script
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
});

</script>
<!-- ================ side js start End=============== -->

