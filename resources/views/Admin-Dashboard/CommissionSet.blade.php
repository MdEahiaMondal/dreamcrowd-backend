<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="/">
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
    <title>Super Admin Dashboard | Dynamic Management-Top Seller</title>
  </head>
  <body>

    
      
  @if (Session::has('error'))
  <script>

        toastr.options =
          {
              "closeButton" : true,
               "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
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
          "extendedTimeOut": "4410000" // 10 seconds
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
                    <h1 class="dash-title">Seller Setting</h1>
                    <i class="fa-solid fa-chevron-right"></i>
                    <span class="min-title">Commission</span>
                  </div>
                </div>
              </div>
              <!-- Blue MASSEGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <img src="assets/admin/asset/img/dynamic-management.svg" alt="" />
                      <h2>Seller Setting</h2>
                    </div>
                  </div>
                </div>
              </div>
              <!-- ================================== -->
             

              <div class="col-md-12 manage-profile-faq-sec edit-faqs">
                <h5>Edit Commission Rate</h5>
                 
              </div>

               <!-- form add faq's -->
               <div class="form-section">
                <div class="row">
                  <form action="/update-commission-re" method="POST">
                    @csrf
                    
               
                    <div class="col-12 mt-0">
                      <label for="commission" class="form-label">Commission 5-30 (%)</label> 
                      <input
                          type="text"
                          class="form-control @error('commission') is-invalid @enderror"
                          value="{{ old('commission', $tag->commission ?? '') }}"
                          id="commission"
                          name="commission"
                          placeholder="Min: 5, Max: 30"
                          required
                      />
                  
                      @error('commission')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                      @enderror
                  </div>
                  
                
  

                    <div class="api-buttons">
                      <div class="row">
                        <div class="col-md-12">
                         
                          <button type="submit" class="btn float-end update-btn">
                            Update
                          </button>
                        </div>
                      </div>
                    </div>

                     
                  </form>
                </div>
              </div>



               {{-- Buyer Commission Set --}}

              <div class="col-md-12 manage-profile-faq-sec edit-faqs">
                <h5>Edit Buyer Commission Rate</h5>
                 
              </div>

               <!-- form add faq's -->
               <div class="form-section">
                <div class="row">
                  <form id="buyer_commission_form" action="/update-buyer-commission-re" method="POST">
                    @csrf


                    
                          <div class="col-12" style="display: flex; align-items: center;"> 
                            <label for="inputAddress" class="form-label mx-2"
                              >Show/Hide</label
                            >
                            <input type="hidden" name="buyer_commission" id="buyer_commission" value="@if($tag){{$tag->buyer_commission}}@endif">
                            <input type="checkbox" name="" id="aa1" onclick="UpdateBuyerCommissionToggle()" class="add-page-check" >
                            <label for="aa1"><span></span></label>
                      
                      </div> 
                    
               
                    <div class="col-12 mt-0" id="buyer_main_div">
                      <label for="buyer_commission_rate" class="form-label">Commission 1-15 (%)</label> 
                      <input
                          type="text"
                          class="form-control @error('commission') is-invalid @enderror"
                          value="{{ old('commission', $tag->buyer_commission_rate ?? '') }}"
                          id="buyer_commission_rate"
                          name="buyer_commission_rate"
                          placeholder="Min: 1, Max:15"
                          required
                      />
                  
                      @error('commission')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                      @enderror
                  </div>
                  
                
  

                    <div class="api-buttons">
                      <div class="row">
                        <div class="col-md-12">
                         
                          <button id="buyer_commission_submit" type="button" class="btn float-end update-btn">
                            Update
                          </button>
                        </div>
                      </div>
                    </div>

                     
                  </form>
                </div>
              </div>

 
            </div>
          </div>
        </div>
      </div>
      <!-- =============================== MAIN CONTENT END HERE =========================== -->
      <!-- copyright section start from here -->
      <div class="copyright">
        <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
      </div>
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

<script>

  $(document).ready(function () {
    var buyer_commission = @json($tag->buyer_commission);
    if (buyer_commission == 1) {
      $('#buyer_main_div').show();
      $('#aa1').attr('checked', 1);
        $('#buyer_commission').val(1);
      } else {
        $('#buyer_main_div').hide();
        $('#aa1').removeAttr('checked');
        $('#buyer_commission').val(0);
    }
    
  });


  function UpdateBuyerCommissionToggle() { 
    if (!$('#aa1').attr('checked')) {
      $('#aa1').attr('checked', 1);
      $('#buyer_commission').val(1);
      $('#buyer_main_div').show();
      console.log('checked');
      
    } else {
      $('#aa1').removeAttr('checked');
      $('#buyer_commission').val(0);
      $('#buyer_main_div').hide();
      console.log(' Not checked');
    }
   }


   $('#buyer_commission_submit').click(function () { 
    if ($('#aa1').attr('checked')) {
      $('#buyer_commission').val(1);
     var buyer_commission_rate = $('#buyer_commission_rate').val();
 
     if (
    buyer_commission_rate === '' || 
    isNaN(buyer_commission_rate) || 
    buyer_commission_rate < 1 || 
    buyer_commission_rate > 15
) {
    alert("Please enter a valid commission rate between 1 and 15.");
    return false; // Stop form submission or further logic
}

      
    } else {
      $('#buyer_commission').val(0);
      $('#buyer_commission_rate').val('');
    }
    
    $('#buyer_commission_form').submit();

   });



  const numberInputs = ['commission','buyer_commission_rate'];
  
  numberInputs.forEach(input => {
    document.getElementById(input).addEventListener('input', function(e) {
      // Allow only numeric values
      this.value = this.value.replace(/[^0-9]/g, '');

   

    });
  });
</script>

<!-- Tinymce js start -->
<script>
  tinymce.init({
    selector: "#test",
    plugins: "image imagetools code visualblocks link",
    images_upload_url: '/upload-image',  // The URL to which the image upload request should be sent
    automatic_uploads: true,
    file_picker_types: 'image',
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


{{-- Delete Confirmation PopUp Show For Confirmation Script Start --}}
<script>
  function DeleteConfirmation(Clicked) {
    var id = $('#'+Clicked).data('id');
    var type = $('#'+Clicked).data('type');

    if (type == 'heading') {
      
      $("#delete-submit").attr("href", "/delete-faqs-heading-dynamic/"+id);
    } else if(type == 'general'){
      $("#delete-submit").attr("href", "/delete-faqs-general-dynamic/"+id);
      
    }else  {
      $("#delete-submit").attr("href", "/delete-faqs-dynamic/"+id);
      
    }
    
     $('#deleteConfirmationModel').modal('show'); // Hide the signup modal if shown

    }
</script>
{{-- Delete Confirmation PopUp Show For Confirmation Script End --}}



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
