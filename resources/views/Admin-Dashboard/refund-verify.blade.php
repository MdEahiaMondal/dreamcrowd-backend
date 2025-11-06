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
     {{-- Fav Icon --}}
     @php  $home = \App\Models\HomeDynamic::first(); @endphp
     @if ($home)
         <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
     @endif
     <!-- Datatable css  -->
    <link rel="stylesheet" href="assets/admin/libs/datatable/css/datatable.css" />
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
              <!-- request headind start -->
              <div class="send-notify">
                <div class="row">
                  <div class="col-md-12">
                    <h1>Request Detail</h1>
                  </div>
                </div>
              </div>
              <!--request heading ended -->
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
                                  <tbody>
                                    <tr>
                                      <th class="refund-heading">
                                        Seller Name
                                      </th>
                                      <td>Usama A.</td>
                                    </tr>
                                    <tr>
                                      <th class="refund-heading">Buyer Name</th>
                                      <td>Orhan Khan</td>
                                    </tr>
                                    <tr>
                                      <th class="refund-heading">
                                        Service Description
                                      </th>
                                      <td>
                                        I’ll Design most attractive and
                                        minimalists website for your future
                                        Brand.
                                      </td>
                                    </tr>
                                    <tr>
                                      <th class="refund-heading">
                                        Amount Request
                                      </th>
                                      <td>Usama A.</td>
                                    </tr>
                                    <tr>
                                      <th class="refund-heading">Admin Fee</th>
                                      <td>$14</td>
                                    </tr>
                                    <tr>
                                      <th class="refund-heading">Seller Fee</th>
                                      <td>$56</td>
                                    </tr>
                                    <tr>
                                      <th class="refund-heading">Admin Note</th>
                                      <td>“ ”</td>
                                    </tr>
                                    <tr>
                                      <th class="refund-heading">
                                        Student Reason
                                      </th>
                                      <td>
                                        I didn’t agreed with the teacher
                                        behaviour.He just put old detail in his
                                        course
                                      </td>
                                    </tr>
                                    <tr>
                                      <th class="refund-heading">
                                        Reject Reason
                                      </th>
                                      <td>“ ”</td>
                                    </tr>
                                    <tr>
                                      <th class="refund-heading status-border">
                                        Status
                                      </th>
                                      <td class="status-border">
                                        <h5 class="mb-0">
                                          <span class="badge pending-badge"
                                            >Pending</span
                                          >
                                        </h5>
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
              <div class="send-notify">
                <div class="row">
                  <div class="col-md-12">
                    <h1>Approve Request</h1>
                  </div>
                </div>
              </div>
              <!-- =============== API FORM SECTION START FROM HERE ================ -->
              <div class="api-form">
                <div class="row">
                  <div class="col-md-12">
                    <form class="row g-3">
                      <div class="col-12">
                        <label for="inputAddress" class="form-label"
                          >Admin Notes</label
                        >
                        <br />
                        <textarea
                          name=""
                          id=""
                          cols="3"
                          rows="3"
                          placeholder="Write note either you approve or reject"
                        ></textarea>
                      </div>
                      <div class="col-12 api-secret">
                        <label for="inputAddress2" class="form-label"
                          >Reject Reason</label
                        >
                        <textarea
                          name=""
                          id=""
                          cols="3"
                          rows="3"
                          placeholder="write the reason why you reject the request"
                        ></textarea>
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
                    <button type="button" class="btn float-start cancel-btn">
                      Reject
                    </button>
                    <button type="button" class="btn float-end update-btn">
                      Approve
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
