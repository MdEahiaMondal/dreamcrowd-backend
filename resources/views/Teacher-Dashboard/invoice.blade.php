<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <!-- View Point scale to 1.0 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Animate css -->
    <link rel="stylesheet" href="assets/teacher/libs/animate/css/animate.css" />
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="assets/teacher/libs/aos/css/aos.css" />
    <!-- Datatable css  -->
    <link rel="stylesheet" href="assets/teacher/libs/datatable/css/datatable.css" />
     {{-- Fav Icon --}}
     @php  $home = \App\Models\HomeDynamic::first(); @endphp
     @if ($home)
         <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
     @endif
     <!-- Select2 css -->
    <link href="assets/teacher/libs/select2/css/select2.min.css" rel="stylesheet" />
    <!-- Owl carousel css -->
    <link href="assets/teacher/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
    <link href="assets/teacher/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
    <!-- Bootstrap css -->
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/teacher/asset/css/bootstrap.min.css"
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
    <link rel="stylesheet" type="text/css" href="assets/teacher/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/teacher/asset/css/style.css" />
    <link rel="stylesheet" href="assets/teacher/asset/css/invoice.css" />
    <title>User Dashboard |</title>
  </head>
  <body>
   {{-- ===========Teacher Sidebar Start==================== --}}
  <x-teacher-sidebar/>
  {{-- ===========Teacher Sidebar End==================== --}}
  <section class="home-section">
     {{-- ===========Teacher NavBar Start==================== --}}
     <x-teacher-nav/>
     {{-- ===========Teacher NavBar End==================== --}}
      <!-- =============================== MAIN CONTENT START HERE =========================== -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 class-management-section">
            <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item">Invoice Statement</li>
              </ol>
            </nav>
            <div class="row">
              <div class="col-md-12 class-management">
                <i class="bx bx-receipt icon" title="Invoice Statement"></i>

                <h5>Invoice Statements</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 Invoices-Tab">
                <h5>Invoices</h5>
              </div>
            </div>
            <!-- search bar end here -->
            <div class="row installment-table">
              <div class="col-md-12 p-0">
                <div class="table-responsive">
                  <div class="hack1">
                    <div class="hack2">
                      <table class="table">
                        <thead>
                          <tr class="text-nowrap">
                            <th>Date</th>
                            <th>Service Title</th>
                            <th>Activity</th>
                            <th>Description</th>
                            <th>Order</th>
                            <th>Amount</th>
                            <th>Invoice</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>21-09-2023</td>
                            <td>Online Class</td>
                            <td>Withdraw</td>
                            <td>Transferred Successfully</td>
                            <td>F041CE78F1206</td>
                            <td>$148</td>
                            <td>
                              <a class="invoice-detail" href="#">Download</a>
                            </td>
                          </tr>
                          <tr>
                            <td>21-09-2023</td>
                            <td>Freelance Service</td>
                            <td>Withdraw</td>
                            <td>Transferred Successfully</td>
                            <td>F041CE78F1206</td>
                            <td>$148</td>
                            <td>
                              <a class="invoice-detail" href="#">Download</a>
                            </td>
                          </tr>
                          <tr>
                            <td>21-09-2023</td>
                            <td>Online Class</td>
                            <td>Withdraw</td>
                            <td>Transferred Successfully</td>
                            <td>F041CE78F1206</td>
                            <td>$148</td>
                            <td>
                              <a class="invoice-detail" href="#">Download</a>
                            </td>
                          </tr>
                          <tr>
                            <td>21-09-2023</td>
                            <td>Freelance Service</td>
                            <td>Withdraw</td>
                            <td>Transferred Successfully</td>
                            <td>F041CE78F1206</td>
                            <td>$148</td>
                            <td>
                              <a class="invoice-detail" href="#">Download</a>
                            </td>
                          </tr>
                          <tr>
                            <td>21-09-2023</td>
                            <td>Online Class</td>
                            <td>Withdraw</td>
                            <td>Transferred Successfully</td>
                            <td>F041CE78F1206</td>
                            <td>$148</td>
                            <td>
                              <a class="invoice-detail" href="#">Download</a>
                            </td>
                          </tr>
                          <tr>
                            <td>21-09-2023</td>
                            <td>Freelance Service</td>
                            <td>Withdraw</td>
                            <td>Transferred Successfully</td>
                            <td>F041CE78F1206</td>
                            <td>$148</td>
                            <td>
                              <a class="invoice-detail" href="#">Download</a>
                            </td>
                          </tr>
                          <tr>
                            <td>21-09-2023</td>
                            <td>Online Class</td>
                            <td>Withdraw</td>
                            <td>Transferred Successfully</td>
                            <td>F041CE78F1206</td>
                            <td>$148</td>
                            <td>
                              <a class="invoice-detail" href="#">Download</a>
                            </td>
                          </tr>
                          <tr>
                            <td>21-09-2023</td>
                            <td>Freelance Service</td>
                            <td>Withdraw</td>
                            <td>Transferred Successfully</td>
                            <td>F041CE78F1206</td>
                            <td>$148</td>
                            <td>
                              <a class="invoice-detail" href="#">Download</a>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- table end here -->

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

            <div class="user-footer text-center">
              <p class="mb-0">
                Copyright Dreamcrowd © 2021. All Rights Reserved.
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- =============================== MAIN CONTENT END HERE =========================== -->
    </section>
   

    <script src="assets/teacher/libs/jquery/jquery.js"></script>
    <script src="assets/teacher/libs/datatable/js/datatable.js"></script>
    <script src="assets/teacher/libs/datatable/js/datatablebootstrap.js"></script>
    <script src="assets/teacher/libs/select2/js/select2.min.js"></script>
    <script src="assets/teacher/libs/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="assets/teacher/libs/aos/js/aos.js"></script>
    <script src="assets/teacher/asset/js/bootstrap.min.js"></script>
    <script src="assets/teacher/asset/js/script.js"></script>
    <!-- jQuery -->
    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"
    ></script>
  </body>
</html>
<!-- modal hide show jquery here -->
<script>
  $(document).ready(function () {
    $(document).on("click", "#delete-account", function (e) {
      e.preventDefault();
      $("#exampleModal7").modal("show");
      $("#delete-teacher-account").modal("hide");
    });

    $(document).on("click", "#delete-account", function (e) {
      e.preventDefault();
      $("#delete-teacher-account").modal("show");
      $("#exampleModal7").modal("hide");
    });
  });
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
<!-- radio js here -->
<script>
  function showAdditionalOptions1() {
    hideAllAdditionalOptions();
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

