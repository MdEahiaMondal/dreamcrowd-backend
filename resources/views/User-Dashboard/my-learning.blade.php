<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <!-- View Point scale to 1.0 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Animate css -->
    <link rel="stylesheet" href="assets/user/libs/animate/css/animate.css" />
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="assets/user/libs/aos/css/aos.css" />
    <!-- Datatable css  -->
    <link rel="stylesheet" href="assets/user/libs/datatable/css/datatable.css" />
    {{-- Fav Icon --}}
    @php  $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
    @endif
     <!-- Select2 css -->
    <link href="assets/user/libs/select2/css/select2.min.css" rel="stylesheet" />
    <!-- Owl carousel css -->
    <link href="assets/user/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
    <link href="assets/user/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
    <!-- Bootstrap css -->
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/user/asset/css/bootstrap.min.css"
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
    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"
    ></script>
    <!-- Fontawesome CDN -->
    <script
      src="https://kit.fontawesome.com/be69b59144.js"
      crossorigin="anonymous"
    ></script>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0"
    />
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/user/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/user/asset/css/style.css" />
    <link rel="stylesheet" href="assets/user/asset/css/classmanagement.css" />
    <title>User Dashboard | My Learning</title>
  </head>

  <body>
     {{-- ===========User Sidebar Start==================== --}}
  <x-user-sidebar/>
  {{-- ===========User Sidebar End==================== --}}
  <section class="home-section">
     {{-- ===========User NavBar Start==================== --}}
     <x-user-nav/>
     {{-- ===========User NavBar End==================== --}}
      <!-- =============================== MAIN CONTENT START HERE =========================== -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 class-management-section">
            <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Video Orders
                </li>
              </ol>
            </nav>
            <div class="col-md-12 class-management">
              <i class="bx bx-book-reader" title="My Learning"></i>
              <h5>Video Orders</h5>
            </div>
            <div class="row">
              <div class="col-md-11">
                <div class="search">
                  <span class="fa fa-search"></span>
                  <input placeholder="Search service title, experts etc...." />
                </div>
              </div>
              <div class="col-md-1 filter-sec">
                <div class="dropdown">
                  <button
                    class="btn filter-btn"
                    type="button"
                    id="dropdownMenuButton1"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                  >
                    <span class="material-symbols-rounded"> tune </span>
                  </button>
                  <ul
                    class="dropdown-menu"
                    aria-labelledby="dropdownMenuButton1"
                  >
                    <h5 class="mt-0">Sorting</h5>
                    <a class="dropdown-item" href="#">
                      <li>A-Z</li>
                    </a>
                    <a class="dropdown-item" href="#">
                      <li>Z-A</li>
                    </a>
                  </ul>
                </div>
              </div>
            </div>
            <div class="class-management-sec">
              <div class="row">
                <div class="col-sm-12">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <th>Seller</th>
                        <th class="service-title">Service Title</th>
                        <th>Start Date</th>
                        <th>Due Date</th>
                        <th>Price</th>
                        <th>Completion Status</th>
                        <th class="act">Action</th>
                      </thead>
                      <tr>
                        <td>
                          <div class="profile-sec">
                            <img src="assets/user/asset/img/profile.png" alt="" />
                            <p>Usama A.<br /><span>UI Designer</span></p>
                          </div>
                        </td>
                        <td>
                          <div class="service-title">
                            <p
                              type="button"
                              class="btn seller-desc"
                              data-bs-toggle="modal"
                              data-bs-target="#sell-service-modal"
                            >
                              Learn How to design attractive UI for clients....
                            </p>
                          </div>
                        </td>
                        <td>
                          <div class="service-date">
                            <p>June 15, 2023</p>
                          </div>
                        </td>
                        <td>
                          <div class="service-date">
                            <p>June 15, 2023</p>
                          </div>
                        </td>
                        <td>
                          <div class="service-date">
                            <p>$58</p>
                          </div>
                        </td>
                        <td>
                          <div class="service-date">
                            <p>36% completed</p>
                          </div>
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
                              <a class="dropdown-item" href="#">
                                <li>Access Class</li>
                              </a>
                              <a class="dropdown-item" href="#">
                                <li>Mark as Satisfactory</li>
                              </a>
                              <a
                                class="dropdown-item btn"
                                data-bs-toggle="modal"
                                data-bs-target="#delivered-orders-modal"
                                href="#"
                              >
                                <li>Mark as Unsatisfactory</li>
                              </a>
                              <a
                                class="dropdown-item btn"
                                data-bs-toggle="modal"
                                data-bs-target="#add-review-modal"
                                href="#"
                              >
                                <li>Rate & Review</li>
                              </a>
                            </ul>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="profile-sec">
                            <img src="assets/user/asset/img/profile.png" alt="" />
                            <p>Usama A.<br /><span>UI Designer</span></p>
                          </div>
                        </td>
                        <td>
                          <div class="service-title">
                            <p
                              type="button"
                              class="btn seller-desc"
                              data-bs-toggle="modal"
                              data-bs-target="#sell-service-modal"
                            >
                              Learn How to design attractive UI for clients....
                            </p>
                          </div>
                        </td>
                        <td>
                          <div class="service-date">
                            <p>June 15, 2023</p>
                          </div>
                        </td>
                        <td>
                          <div class="service-date">
                            <p>June 15, 2023</p>
                          </div>
                        </td>
                        <td>
                          <div class="service-date">
                            <p>$58</p>
                          </div>
                        </td>
                        <td>
                          <div class="service-date">
                            <p>36% completed</p>
                          </div>
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
                              <a class="dropdown-item" href="#">
                                <li>Access Class</li>
                              </a>
                              <a class="dropdown-item" href="#">
                                <li>Mark as Satisfactory</li>
                              </a>
                              <a
                                class="dropdown-item btn"
                                data-bs-toggle="modal"
                                data-bs-target="#delivered-orders-modal"
                                href="#"
                              >
                                <li>Mark as Unsatisfactory</li>
                              </a>
                              <a
                                class="dropdown-item btn"
                                data-bs-toggle="modal"
                                data-bs-target="#add-review-modal"
                                href="#"
                              >
                                <li>Rate & Review</li>
                              </a>
                            </ul>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="profile-sec">
                            <img src="assets/user/asset/img/profile.png" alt="" />
                            <p>Usama A.<br /><span>UI Designer</span></p>
                          </div>
                        </td>
                        <td>
                          <div class="service-title">
                            <p
                              type="button"
                              class="btn seller-desc"
                              data-bs-toggle="modal"
                              data-bs-target="#sell-service-modal"
                            >
                              Learn How to design attractive UI for clients....
                            </p>
                          </div>
                        </td>
                        <td>
                          <div class="service-date">
                            <p>June 15, 2023</p>
                          </div>
                        </td>
                        <td>
                          <div class="service-date">
                            <p>June 15, 2023</p>
                          </div>
                        </td>
                        <td>
                          <div class="service-date">
                            <p>$58</p>
                          </div>
                        </td>
                        <td>
                          <div class="service-date">
                            <p>36% completed</p>
                          </div>
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
                              <a class="dropdown-item" href="#">
                                <li>Access Class</li>
                              </a>
                              <a class="dropdown-item" href="#">
                                <li>Mark as Satisfactory</li>
                              </a>
                              <a
                                class="dropdown-item btn"
                                data-bs-toggle="modal"
                                data-bs-target="#delivered-orders-modal"
                                href="#"
                              >
                                <li>Mark as Unsatisfactory</li>
                              </a>
                              <a
                                class="dropdown-item btn"
                                data-bs-toggle="modal"
                                data-bs-target="#add-review-modal"
                                href="#"
                              >
                                <li>Rate & Review</li>
                              </a>
                            </ul>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="profile-sec">
                            <img src="assets/user/asset/img/profile.png" alt="" />
                            <p>Usama A.<br /><span>UI Designer</span></p>
                          </div>
                        </td>
                        <td>
                          <div class="service-title">
                            <p
                              type="button"
                              class="btn seller-desc"
                              data-bs-toggle="modal"
                              data-bs-target="#sell-service-modal"
                            >
                              Learn How to design attractive UI for clients....
                            </p>
                          </div>
                        </td>
                        <td>
                          <div class="service-date">
                            <p>June 15, 2023</p>
                          </div>
                        </td>
                        <td>
                          <div class="service-date">
                            <p>June 15, 2023</p>
                          </div>
                        </td>
                        <td>
                          <div class="service-date">
                            <p>$58</p>
                          </div>
                        </td>
                        <td>
                          <div class="service-date">
                            <p>36% completed</p>
                          </div>
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
                              <a class="dropdown-item" href="#">
                                <li>Access Class</li>
                              </a>
                              <a class="dropdown-item" href="#">
                                <li>Mark as Satisfactory</li>
                              </a>
                              <a
                                class="dropdown-item btn"
                                data-bs-toggle="modal"
                                data-bs-target="#delivered-orders-modal"
                                href="#"
                              >
                                <li>Mark as Unsatisfactory</li>
                              </a>
                              <a
                                class="dropdown-item btn"
                                data-bs-toggle="modal"
                                data-bs-target="#add-review-modal"
                                href="#"
                              >
                                <li>Rate & Review</li>
                              </a>
                            </ul>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="profile-sec">
                            <img src="assets/user/asset/img/profile.png" alt="" />
                            <p>Usama A.<br /><span>UI Designer</span></p>
                          </div>
                        </td>
                        <td>
                          <div class="service-title">
                            <p
                              type="button"
                              class="btn seller-desc"
                              data-bs-toggle="modal"
                              data-bs-target="#sell-service-modal"
                            >
                              Learn How to design attractive UI for clients....
                            </p>
                          </div>
                        </td>
                        <td>
                          <div class="service-date">
                            <p>June 15, 2023</p>
                          </div>
                        </td>
                        <td>
                          <div class="service-date">
                            <p>June 15, 2023</p>
                          </div>
                        </td>
                        <td>
                          <div class="service-date">
                            <p>$58</p>
                          </div>
                        </td>
                        <td>
                          <div class="service-date">
                            <p>36% completed</p>
                          </div>
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
                              <a class="dropdown-item" href="#">
                                <li>Access Class</li>
                              </a>
                              <a class="dropdown-item" href="#">
                                <li>Mark as Satisfactory</li>
                              </a>
                              <a
                                class="dropdown-item btn"
                                data-bs-toggle="modal"
                                data-bs-target="#delivered-orders-modal"
                                href="#"
                              >
                                <li>Mark as Unsatisfactory</li>
                              </a>
                              <a
                                class="dropdown-item btn"
                                data-bs-toggle="modal"
                                data-bs-target="#add-review-modal"
                                href="#"
                              >
                                <li>Rate & Review</li>
                              </a>
                            </ul>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="profile-sec">
                            <img src="assets/user/asset/img/profile.png" alt="" />
                            <p>Usama A.<br /><span>UI Designer</span></p>
                          </div>
                        </td>
                        <td>
                          <div class="service-title">
                            <p
                              type="button"
                              class="btn seller-desc"
                              data-bs-toggle="modal"
                              data-bs-target="#sell-service-modal"
                            >
                              Learn How to design attractive UI for clients....
                            </p>
                          </div>
                        </td>
                        <td>
                          <div class="service-date">
                            <p>June 15, 2023</p>
                          </div>
                        </td>
                        <td>
                          <div class="service-date">
                            <p>June 15, 2023</p>
                          </div>
                        </td>
                        <td>
                          <div class="service-date">
                            <p>$58</p>
                          </div>
                        </td>
                        <td>
                          <div class="service-date">
                            <p>36% completed</p>
                          </div>
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
                              <a class="dropdown-item" href="#">
                                <li>Access Class</li>
                              </a>
                              <a class="dropdown-item" href="#">
                                <li>Mark as Satisfactory</li>
                              </a>
                              <a
                                class="dropdown-item btn"
                                data-bs-toggle="modal"
                                data-bs-target="#delivered-orders-modal"
                                href="#"
                              >
                                <li>Mark as Unsatisfactory</li>
                              </a>
                              <a
                                class="dropdown-item btn"
                                data-bs-toggle="modal"
                                data-bs-target="#add-review-modal"
                                href="#"
                              >
                                <li>Rate & Review</li>
                              </a>
                            </ul>
                          </div>
                        </td>
                      </tr>
                    </table>
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
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">4</a></li>
                  <li class="page-item"><a class="page-link" href="#">5</a></li>
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
            <div class="text-center copyright">
              <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
            </div>
            <!-- copyright section ended here -->
          </div>
        </div>
      </div>
      <!-- =============================== MAIN CONTENT END HERE =========================== -->
    </section>

    <script src="assets/user/libs/jquery/jquery.js"></script>
    <script src="assets/user/libs/datatable/js/datatable.js"></script>
    <script src="assets/user/libs/datatable/js/datatablebootstrap.js"></script>
    <script src="assets/user/libs/select2/js/select2.min.js"></script>
    <script src="assets/user/libs/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="assets/user/libs/aos/js/aos.js"></script>
    <script src="assets/user/asset/js/bootstrap.min.js"></script>
    <script src="assets/user/asset/js/script.js"></script>
    <!-- jQuery -->
    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"
    ></script>
  </body>
</html>
<!-- ================================================================================================================================================================ -->
<!-- Action Delivered Order Modal Start From Here -->
<div
  class="modal fade"
  id="delivered-orders-modal"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog">
    <div class="modal-content like-to-do-modal">
      <div class="modal-body p-0">
        <h5 class="text-center mb-0">What would you like to do?</h5>
        <div class="row">
          <div class="col-md-12 mb-0 services-buttons">
            <button
              type="button"
              class="btn mark-completed-btn"
              data-bs-toggle="modal"
              data-bs-target="#mark-as-completed-modal"
              id="marked-completely"
            >
              Discuss your concerns with this seller
            </button>
          </div>
          <div class="col-md-12 services-buttons">
            <button
              type="button"
              class="btn refund-btn"
              data-bs-toggle="modal"
              data-bs-target="#add-review-modal"
              id="rating-review"
            >
              Rate and review product
            </button>
          </div>
          <div class="col-md-12 services-buttons">
            <button
              type="button"
              class="btn mb-0 refund-btn"
              data-bs-toggle="modal"
              data-bs-target="#request-refund-modal"
              id="refund-request"
            >
              Cancel Product & Request Refund
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Action Delivered Order Modal Ended here -->
<!-- Add Review Rating modal start from here -->
<!-- Modal -->
<div
  class="modal fade"
  id="add-review-modal"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog">
    <div class="modal-content add-review-rating-modal">
      <div class="modal-body p-0">
        <h5 class="mb-0">Rating</h5>
        <div class="row">
          <div class="col-md-12 review-rating">
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
          </div>
        </div>
        <h5>Reviews <span>(optional)</span></h5>
        <textarea
          class="form-control add-review"
          name="comments"
          id="feedback_comments"
          placeholder="give your feedback"
        ></textarea>
        <button
          type="button"
          class="btn float-end submit-review-btn"
          data-bs-dismiss="modal"
        >
          Submit
        </button>
      </div>
    </div>
  </div>
</div>
<!-- Add Review Rating modal ended here -->
<!-- Cancel and Refund Modal ended here -->
<!-- Modal -->
<div
  class="modal fade"
  id="request-refund-modal"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog">
    <div class="modal-content cancel-refund-modal">
      <div class="modal-body p-0">
        <h5 class="mb-0">Cancel Services</h5>
        <p class="mb-0">
          once you cancel the services, you <br />
          couldn’t retrive the action
        </p>
        <h5>
          Refund Type &nbsp;<svg
            xmlns="http://www.w3.org/2000/svg"
            width="16"
            height="17"
            viewBox="0 0 16 17"
            fill="none"
          >
            <path
              d="M8 2C6.71442 2 5.45772 2.38122 4.3888 3.09545C3.31988 3.80968 2.48676 4.82484 1.99479 6.01256C1.50282 7.20028 1.37409 8.50721 1.6249 9.76809C1.8757 11.029 2.49477 12.1872 3.40381 13.0962C4.31285 14.0052 5.47104 14.6243 6.73192 14.8751C7.99279 15.1259 9.29973 14.9972 10.4874 14.5052C11.6752 14.0132 12.6903 13.1801 13.4046 12.1112C14.1188 11.0423 14.5 9.78558 14.5 8.5C14.4982 6.77665 13.8128 5.12441 12.5942 3.90582C11.3756 2.68722 9.72335 2.00182 8 2ZM8 14C6.91221 14 5.84884 13.6774 4.94437 13.0731C4.0399 12.4687 3.33495 11.6098 2.91867 10.6048C2.50238 9.59977 2.39347 8.4939 2.60568 7.427C2.8179 6.36011 3.34173 5.3801 4.11092 4.61091C4.8801 3.84172 5.86011 3.3179 6.92701 3.10568C7.9939 2.89346 9.09977 3.00238 10.1048 3.41866C11.1098 3.83494 11.9687 4.53989 12.5731 5.44436C13.1774 6.34883 13.5 7.4122 13.5 8.5C13.4983 9.95818 12.9184 11.3562 11.8873 12.3873C10.8562 13.4184 9.45819 13.9983 8 14ZM9 11.5C9 11.6326 8.94732 11.7598 8.85356 11.8536C8.75979 11.9473 8.63261 12 8.5 12C8.23479 12 7.98043 11.8946 7.7929 11.7071C7.60536 11.5196 7.5 11.2652 7.5 11V8.5C7.36739 8.5 7.24022 8.44732 7.14645 8.35355C7.05268 8.25979 7 8.13261 7 8C7 7.86739 7.05268 7.74021 7.14645 7.64645C7.24022 7.55268 7.36739 7.5 7.5 7.5C7.76522 7.5 8.01957 7.60536 8.20711 7.79289C8.39465 7.98043 8.5 8.23478 8.5 8.5V11C8.63261 11 8.75979 11.0527 8.85356 11.1464C8.94732 11.2402 9 11.3674 9 11.5ZM7 5.75C7 5.60166 7.04399 5.45666 7.1264 5.33332C7.20881 5.20999 7.32595 5.11386 7.46299 5.05709C7.60003 5.00032 7.75083 4.98547 7.89632 5.01441C8.04181 5.04335 8.17544 5.11478 8.28033 5.21967C8.38522 5.32456 8.45665 5.4582 8.48559 5.60368C8.51453 5.74917 8.49968 5.89997 8.44291 6.03701C8.38615 6.17406 8.29002 6.29119 8.16668 6.3736C8.04334 6.45601 7.89834 6.5 7.75 6.5C7.55109 6.5 7.36032 6.42098 7.21967 6.28033C7.07902 6.13968 7 5.94891 7 5.75Z"
              fill="#0072B1"
            />
          </svg>
        </h5>
        <div class="row">
          <div class="col-md-12 radio-tabs-sec">
            <div class="col-md-12 radio-tab-section active">
              <input
                type="radio"
                id="tab1"
                name="tab"
                class="radio-but"
                checked
              />
              <label for="tab1">Partial Refund</label>
            </div>
            <div class="col-md-12 radio-tab-section">
              <input type="radio" id="tab2" name="tab" class="radio-but" />
              <label for="tab2">Full Refund</label>
            </div>
            <article>
              <h5 class="mb-0 refund">Refund Amount</h5>
              <input
                type="text"
                class="form-control"
                id="exampleFormControlInput1"
                placeholder="$1500"
              />
              <h5 class="mb-0 refund">Refund Reason</h5>
              <textarea
                class="form-control"
                id="exampleFormControlTextarea1"
                placeholder="write here reason of refund"
              ></textarea>
              <button type="button" class="btn float-start cancel-button">
                Cancel
              </button>
              <button
                type="button"
                class="btn float-end submit-button"
                data-bs-toggle="modal"
                data-bs-target="#cancel-services-modal"
                id="submit-cancel-services"
              >
                Submit
              </button>
            </article>
            <article>
              <h5 class="mb-0 refund">Refund Reason</h5>
              <textarea
                class="form-control"
                id="exampleFormControlTextarea1"
                placeholder="write here reason of refund"
              ></textarea>
              <button type="button" class="btn float-start cancel-button">
                Cancel
              </button>
              <button
                type="button"
                class="btn float-end submit-button"
                data-bs-toggle="modal"
                data-bs-target="#cancel-services-modal"
                id="submit-cancel-services"
              >
                Submit
              </button>
            </article>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Cancel and Refund Modal ended here -->
<!-- request refund jquery -->
<script>
  $(document).ready(function () {
    $(document).on("click", "#refund-request", function (e) {
      e.preventDefault();
      $("#request-refund-modal").modal("show");
      $("#delivered-orders-modal").modal("hide");
    });

    $(document).on("click", "#refund-request", function (e) {
      e.preventDefault();
      $("#delivered-orders-modal").modal("show");
      $("#request-refund-modal").modal("hide");
    });
  });
</script>
<!-- add review jquery -->
<script>
  $(document).ready(function () {
    $(document).on("click", "#rating-review", function (e) {
      e.preventDefault();
      $("#add-review-modal").modal("show");
      $("#delivered-orders-modal").modal("hide");
    });

    $(document).on("click", "#rating-review", function (e) {
      e.preventDefault();
      $("#delivered-orders-modal").modal("show");
      $("#add-review-modal").modal("hide");
    });
  });
</script>
<!-- radio tabs js -->
<script>
  $("[name=tab]").each(function (i, d) {
    var p = $(this).prop("checked");
    //   console.log(p);
    if (p) {
      $("article").eq(i).addClass("on");
    }
  });

  $("[name=tab]").on("change", function () {
    var p = $(this).prop("checked");

    // $(type).index(this) == nth-of-type
    var i = $("[name=tab]").index(this);

    $("article").removeClass("on");
    $("article").eq(i).addClass("on");
  });
</script>
<!-- radio buttons js start here -->
<script>
  $("input:radio:checked").parent().addClass("active");
  $("input:radio").click(function () {
    $("input:not(:checked)").parent().removeClass("active");
    $("input:checked").parent().addClass("active");
  });
</script>
<!-- radio buttons js ended here -->
<!-- ================ side js start here=============== -->
<!-- ================ side js start End=============== -->
<!-- radio buttons js start here -->
<script>
  $("input:radio:checked").parent().addClass("active");
  $("input:radio").click(function () {
    $("input:not(:checked)").parent().removeClass("active");
    $("input:checked").parent().addClass("active");
  });
</script>
<!-- radio buttons js ended here -->
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

<!-- radio js here -->
<script>
  function showAdditionalOptions1() {
    hideAllAdditionalOptions();
    document.getElementById("additionalOptions1").style.display = "block";
  }

  function showAdditionalOptions2() {
    hideAllAdditionalOptions();
    document.getElementById("additionalOptions2").style.display = "block";
  }

  function showAdditionalOptions3() {
    hideAllAdditionalOptions();
  }

  function showAdditionalOptions4() {
    hideAllAdditionalOptions();
    document.getElementById("additionalOptions4").style.display = "block";
  }

  function hideAllAdditionalOptions() {
    var elements = document.getElementsByClassName("additional-options");
    for (var i = 0; i < elements.length; i++) {
      elements[i].style.display = "none";
    }
  }

  // Call the function to show the additional options for the default checked radio button on page load
  window.onload = function () {
    showAdditionalOptions1();
  };
</script>
<!-- modal hide show jquery here -->
<script>
  $(document).ready(function () {
    $(document).on("click", "#delete-account", function (e) {
      e.preventDefault();
      $("#exampleModal3").modal("show");
      $("#delete-user-account").modal("hide");
    });

    $(document).on("click", "#delete-account", function (e) {
      e.preventDefault();
      $("#delete-user-account").modal("show");
      $("#exampleModal3").modal("hide");
    });
  });
</script>
