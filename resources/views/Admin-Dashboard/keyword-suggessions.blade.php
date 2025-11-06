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
     <!-- jQuery -->
     <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    

     {{-- =======Toastr CDN ======== --}}
     <link rel="stylesheet" type="text/css" 
     href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
     
     <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
     {{-- =======Toastr CDN ======== --}}
    <!-- boxicons -->
    <link
      href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
    />
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
    <!-- file upload link -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />

    <!-- js -->
    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"
    ></script>
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/admin/asset/css/style.css" />
    <link rel="stylesheet" href="assets/user/asset/css/style.css" />
    <link rel="stylesheet" href="assets/admin/asset/css/about-us.css" />
    <title>Super Admin Dashboard | Dynamic Management-Keyword Suggessions</title>
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
                    <h1 class="dash-title">Dynamic Management</h1>
                    <i class="fa-solid fa-chevron-right"></i>
                    <span class="min-title">Keyword Suggessions</span>
                  </div>
                </div>
              </div>
              <!-- Blue MASSEGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <img src="assets/admin/asset/img/dynamic-management.svg" alt="" />
                      <h2>Add Keyword Suggessions</h2>
                    </div>
                  </div>
                </div>
              </div>
              <!-- ============ -->
              <div class="send-notify">
                <div class="row">
                  <div class="col-md-12">
                    <h1>Add Keyword Suggessions</h1>
                  </div>
                </div>
              </div>
              <!-- =============== -->
              <!-- ========= PRIVACY POLICY FORM SECTION START FROM HERE ========== -->
              <div class="form-section conditions">
                <div class="row major-section">
                  <div class="col-md-12">
                    <form>
                      <div class="col-md-12 add-languages">
                        <label for="inputAddress" class="form-label"
                          >Add Keyword Suggessions</label
                        >
                        <input
                          type="text"
                          id="keyword" name="keyword"
                          placeholder="Add Keyword"
                        />
                        <button type="button" id="addButton">Add</button>
                        <div id="tileContainer"></div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- ========= PRIVACY POLICY FORM SECTION ENDED FROM HERE ========== -->
          </div>
        </div>
      </div>
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
  </body>
</html>

<!-- ================ side js start here=============== -->

{{-- // Dynamic Languages Script Start ============== --}}
<script>

// On Load Page Get RECORDS =======
$(document).ready(function () {

  $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "GET",
                url: '/get-keyword-suggessions-dynamic',
                data:{  _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {
                  Keywords(response);
                },
              
            });
  
});

// Add Record Function ===========
$('#addButton').click(function () { 
 
 var keyword = $('#keyword').val();
 if (keyword == '') {
  toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.error("Please Write a Keyword!");
                    return false;
 }

 $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "POST",
                url: '/add-keyword-suggessions-dynamic',
                data:{ keyword:keyword, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {
                  $('#keyword').val('');
                  Keywords(response);
                },
              
            });
  
});

// Delete Record Function ============
function DeleteKeyword(Clicked) { 

  if (!confirm("Are You Sure, You Want to Remove ?")){
      return false;
    }

  var id = Clicked;

  $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "POST",
                url: '/delete-keyword-suggessions-dynamic',
                data:{ id:id, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {
                  Keywords(response);
                },
              
            });


 }
// Show Records Function =========
function Keywords(response) {  

  $('#tileContainer').empty();
  
  var len = 0;
            $("#fetch_skills").empty();
          if(response['keywords'] != null){
             len = response['keywords'].length;
          }
  if (len > 0 ) {
    
    for (let i = 0; i < len; i++) {
      var id = response['keywords'][i].id;
      var keyword = response['keywords'][i].keyword;
  
     var content_div = '<div class="tile"> <span>'+keyword+'</span> <span class="closeIcon" onClick= DeleteKeyword(this.id)  id="'+id+'">×</span> </div>';




$("#tileContainer").append(content_div);
    }



  }
  
}

</script>
  
  {{-- // Dynamic Languages Script End ============== --}}
<!-- ================ side js start End=============== -->
<!-- Add languages script -->
<script>
  // document.getElementById("addButto").addEventListener("click", function () {
  //   const inputField = document.getElementById("inputField");
  //   const text = inputField.value.trim();

  //   if (text !== "") {
  //     const tileContainer = document.getElementById("tileContainer");

  //     const tile = document.createElement("div");
  //     tile.className = "tile";

  //     const tileText = document.createElement("span");
  //     tileText.textContent = text;

  //     const closeIcon = document.createElement("span");
  //     closeIcon.className = "closeIcon";
  //     closeIcon.textContent = "×";
  //     closeIcon.addEventListener("click", function () {
  //       tileContainer.removeChild(tile);
  //     });

  //     tile.appendChild(tileText);
  //     tile.appendChild(closeIcon);
  //     tileContainer.appendChild(tile);
  //     inputField.value = "";
  //   }
  // });
</script>
<!-- ended -->

