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
    
   <!-- jQuery -->
   <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    

   {{-- =======Toastr CDN ======== --}}
   <link rel="stylesheet" type="text/css" 
   href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
   
   <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
   {{-- =======Toastr CDN ======== --}}
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/admin/asset/css/style.css" />
    <link rel="stylesheet" href="assets/user/asset/css/style.css" />
    <title>Super Admin Dashboard | Add Host Guideline</title>
  </head>
  <body>

        
  @if (Session::has('error'))
  <script>

        toastr.options =
          {
              "closeButton" : true,
               "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "10000" // 10 seconds
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
          "extendedTimeOut": "10000" // 10 seconds
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
                    <span class="min-title">Host Guideline</span>
                  </div>
                </div>
              </div>
              <!-- Blue MASSEGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <i
                        class="bx bx-list-ul icon"
                        title="Notes & Calendar"
                      ></i>
                      <h2>Host Guideline</h2>
                    </div>
                  </div>
                </div>
              </div>
              <!-- ================================== -->
              <div class="send-notify">
                <div class="row">
                  <div class="col-md-12">
                    <h1>Host Guideline</h1>
                  </div>
                </div>
              </div>
              <!-- ================================== -->
              <!-- ========= PRIVACY POLICY FORM SECTION START FROM HERE ========== -->
              <form class="row" action="/upload-host-guidline" method="POST">
              <div class="form-section conditions">
                <div class="row">
                  <div class="col-md-12">
                    <div class="">
                        @csrf
                        <h5>Guideline Heading</h5>
                        <div class="col-md-12">
                          <input
                            type="text" name="heading"
                            class="form-control"
                            id="inputPassword4" required
                            placeholder="Guideline Heading"
                          />
                        </div>
                        <h5>Guideline Detail</h5>
                        <div class="col-md-12">
                          <div class="mb-3">
                            <textarea
                              class="form-control"
                              placeholder="Guideline detail should be here ..."
                              rows="10" name="detail" id="test"
                            ></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- ========= PRIVACY POLICY FORM SECTION ENDED FROM HERE ========== -->
                <!-- =============== BUTTONS SECTION START FROM HERE ================ -->
                <div class="api-buttons">
                  <div class="row">
                    <div class="col-md-12">
                      <a href="/admin-host-guidline">
                        <button type="button" class="btn float-start cancel-btn">
                          Back
                        </button>
                      </a>
                      <button type="submit" class="btn float-end update-btn">
                        Add
                      </button>
                    </div>
                  </div>
                </div>
              </form>
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
      <!-- Tinymcs js link -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.4.1/tinymce.min.js"></script>
  
  </body>
</html>

<!-- Tinymce js start -->
<script>
  tinymce.init({
    selector: "#test",
    plugins: "code visualblocks link",
    toolbar: [
      //: https://www.tiny.cloud/docs/tinymce/6/toolbar-configuration-options/#adding-toolbar-group-labels
      { name: "history", items: ["undo", "redo"] },
      { name: "styles", items: ["styles"] },
      {
        name: "formatting",
        items: ["bold", "italic", "underline", "removeformat"],
      },
      { name: "elements", items: ["link"] },
      // { name: 'alignment', items: [ 'alignleft', 'aligncenter', 'alignright', 'alignjustify' ] },
      // { name: 'indentation', items: [ 'outdent', 'indent' ] },
      { name: "source", items: ["code", "visualblocks"] },
    ],
    link_list: [
      { title: "{companyname} Home Page", value: "{companyurl}" },
      { title: "{companyname} Blog", value: "{companyurl}/blog" },
      {
        title: "{productname} Support resources 1",
        menu: [
          {
            title: "{productname} 1 Documentation",
            value: "{companyurl}/docs/",
          },
          {
            title: "{productname} on Stack Overflow",
            value: "{communitysupporturl}",
          },
          {
            title: "{productname} GitHub",
            value: "https://github.com/tinymce/",
          },
        ],
      },
      {
        title: "{productname} Support resources 2",
        menu: [
          {
            title: "{productname} 2 Documentation",
            value: "{companyurl}/docs/",
          },
          {
            title: "{productname} on Stack Overflow",
            value: "{communitysupporturl}",
          },
          {
            title: "{productname} GitHub",
            value: "https://github.com/tinymce/",
          },
        ],
      },
      {
        title: "{productname} Support resources 3",
        menu: [
          {
            title: "{productname} 3 Documentation",
            value: "{companyurl}/docs/",
          },
          {
            title: "{productname} on Stack Overflow",
            value: "{communitysupporturl}",
          },
          {
            title: "{productname} GitHub",
            value: "https://github.com/tinymce/",
          },
        ],
      },
    ],
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
