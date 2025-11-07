<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="/" />
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
              <form class="row" action="/update-host-guidline" method="POST">
              <div class="form-section conditions">
                <div class="row">
                  <div class="col-md-12">
                    <div class="">
                        @csrf
                        <h5>Guideline Heading
                          {{-- <a href="/delete-host-guidline/{{$host->id}}"></a> --}}
                            <button type="button" class="btn float-end remove-btn"  onclick="DeleteConfirmation(this.id)" id="delete-btn{{$host->id}}" data-id="{{$host->id}}">Remove</button>
                        </h5>
                        
                        <div class="col-md-12">
                          <input type="hidden" name="id" value="{{$host->id}}">
                          <input
                            type="text" name="heading" value="{{$host->heading}}"
                            class="form-control"
                            id="inputPassword4" required
                            placeholder="Discover Classes and Freelance Categories"
                          />
                        </div>
                        <h5>Guideline Detail</h5>
                        <div class="col-md-12">
                          <div class="mb-3">
                            <textarea
                              class="form-control" name="detail"
                              placeholder="Dreamcrowd is an innovative booking platform which supplies an exciting range of online classes and virtual activities for customers around the world. We provide enjoyable experience for sole-individuals, friends, families, work associates, couples, and other range of customers.Our online classes and activities are personalised and hosted by passionate teachers and creators worldwide.Whether you are looking to learn something new or looking for refreshing form of online experience to enjoy with groups of people,Dreamcrowd has you covered!

Dreamcrowd is an innovative booking platform which supplies an exciting range of online classes and virtual activities for customers around the world. We provide enjoyable experience for sole-individuals, friends, families, work associates, couples, and other range of customers.Our online classes and activities are personalised and hosted by passionate teachers and creators worldwide.Whether you are looking to learn something new or looking for refreshing form of online experience to enjoy with groups of people,Dreamcrowd has you covered!

Dreamcrowd is an innovative booking platform which supplies an exciting range of online classes and virtual activities for customers around the world. We provide enjoyable experience for sole-individuals, friends, families, work associates, couples, and other range of customers.Our online classes and activities are personalised and hosted by passionate teachers and creators worldwide.Whether you are looking to learn something new or looking for refreshing form of online experience to enjoy with groups of people,Dreamcrowd has you covered!
                    "
                              id="test"
                              rows="12"
                            >{!!$host->detail!!}</textarea>
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
                        Update
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

{{-- Delete Confirmation PopUp Show For Confirmation Script Start --}}
<script>
  function DeleteConfirmation(Clicked) {
    var id = $('#'+Clicked).data('id');
    
    $("#delete-submit").attr("href", "/delete-host-guidline/"+id);
    $('#deleteConfirmationModel').modal('show'); // Hide the signup modal if shown

    }
</script>
{{-- Delete Confirmation PopUp Show For Confirmation Script End --}}

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
        <button class="btn float-start cancel-button">Back</button>
        <button class="btn float-end add-button">Add</button>
      </div>
    </div>
  </div>
</div>






{{-- Delete Confirmation Pop Model --}}
<div
class="modal fade delete-modal"
id="deleteConfirmationModel"
tabindex="-1"
aria-labelledby="exampleModalLabel"
aria-hidden="true"
>
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-body">
      <h1>Are you really sure you want to delete this?</h1>
      <div class="btn-sec">
        <center>
          <button
            type="button"
            class="btn btn-no cancel_model"
            id="cancelButton"
            data-bs-dismiss="modal"
          >
            Cancel
          </button>
          <a
            
            class="btn btn-yes"
            id="delete-submit"
          >  Yes  </a>
        </center>
      </div>
    </div>
  </div>
</div>
</div>
