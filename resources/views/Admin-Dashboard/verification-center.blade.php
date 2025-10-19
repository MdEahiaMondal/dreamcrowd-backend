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
    <!-- boxicons -->
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
    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="assets/admin/asset/css/bootstrap.min.css" />
     <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
     <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
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
    <link rel="stylesheet" href="assets/admin/asset/css/style.css">
    <link rel="stylesheet" href="assets/user/asset/css/style.css">
    <link rel="stylesheet" href="assets/admin/asset/css/about-us.css">
    <title>Super Admin Dashboard | Dynamic Management-About Us</title>
</head>
<style>
  .button{
    color:#0072B1!important;
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
                                  <span class="min-title">Verification Center</span>
                                  </div>
                              </div>
                          </div>
                          <!-- Blue MASSEGES section -->
                  <div class="user-notification">
                      <div class="row">
                          <div class="col-md-12">
                              <div class="notify">
                                <img src="assets/img/dynamic-management.svg" alt="" />
                                  <h2>Verification Center</h2>
                              </div>
                          </div>
                      </div>
                  </div>
<!-- ============ -->
<div class="send-notify">
  <div class="row">
    <div class="col-md-12">
     <h1>Government Document Verification</h1>
    </div>
  </div>
</div>
<!-- =============== -->
     <!-- ========= PRIVACY POLICY FORM SECTION START FROM HERE ========== -->
     <div class="form-section conditions">
      <div class="row major-section">
        <div class="col-md-12 ">
          <div class="">
            <form>
              <div class="col-12">
                <label for="inputAddress" class="form-label"
                  >Show/Hide</label
                >
                <input type="hidden" name="verification" id="verification" value="@if($expert){{$expert->verification_center}}@endif">
                <input type="checkbox" name="" id="aa1" onclick="UpdateVerification()" class="add-page-check" >
                <label for="aa1"><span></span></label>
            </form>
          </div>
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

  <script src="libs/jquery/jquery.js"></script>
  <script src="libs/datatable/js/datatable.js"></script>
  <script src="libs/datatable/js/datatablebootstrap.js"></script>
  <script src="libs/select2/js/select2.min.js"></script>
  <script src="libs/owl-carousel/js/owl.carousel.min.js"></script>  
  <script src="libs/aos/js/aos.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/script.js"></script>
</body>
</html>
{{-- Check Verification Update Script Using Ajax Start --}}
<script>
 
 $(document).ready(function () {
    var verification = $('#verification').val();
    if (verification == 1) {
      $('#aa1').attr('checked', 1);
     } else {
      $('#aa1').removeAttr('checked');
     }
  });

  function UpdateVerification() {

    if ($('#aa1').attr('checked')) {
      $('#aa1').removeAttr('checked');
      $('#verification').val(0);
    } else {
      $('#verification').val(1);
       $('#aa1').attr('checked', 1);
     }

var verification = $('#verification').val();
     $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "POST",
                url: '/update-verification-center',
                data:{ verification:verification, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {
                    if (response.success == true) {
                      toastr.options =
                    {
                        "closeButton" : true,
                         "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                    }
                  toastr.success(response.message);
                    } else {
                      toastr.options =
                    {
                        "closeButton" : true,
                         "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                    }
                  toastr.error(response.message);
                    }
                },
              
            });


   }


</script>
{{-- Check Verification Update Script Using Ajax END --}}
<script>
  // File Upload
  //
  function ekUpload() {
    function Init() {
      console.log("Upload Initialised");

      var fileSelect = document.getElementById("file-upload"),
        fileDrag = document.getElementById("file-drag"),
        submitButton = document.getElementById("submit-button");

      fileSelect.addEventListener("change", fileSelectHandler, false);

      // Is XHR2 available?
      var xhr = new XMLHttpRequest();
      if (xhr.upload) {
        // File Drop
        fileDrag.addEventListener("dragover", fileDragHover, false);
        fileDrag.addEventListener("dragleave", fileDragHover, false);
        fileDrag.addEventListener("drop", fileSelectHandler, false);
      }
    }

    function fileDragHover(e) {
      var fileDrag = document.getElementById("file-drag");

      e.stopPropagation();
      e.preventDefault();

      fileDrag.className =
        e.type === "dragover" ? "hover" : "modal-body file-upload";
    }

    function fileSelectHandler(e) {
      // Fetch FileList object
      var files = e.target.files || e.dataTransfer.files;

      // Cancel event and hover styling
      fileDragHover(e);

      // Process all File objects
      for (var i = 0, f; (f = files[i]); i++) {
        parseFile(f);
        uploadFile(f);
      }
    }

    // Output
    function output(msg) {
      // Response
      var m = document.getElementById("messages");
      m.innerHTML = msg;
    }

    function parseFile(file) {
      console.log(file.name);
      output("<strong>" + encodeURI(file.name) + "</strong>");

      // var fileType = file.type;
      // console.log(fileType);
      var imageName = file.name;

      var isGood = /\.(?=gif|jpg|png|jpeg)/gi.test(imageName);
      if (isGood) {
        document.getElementById("start").classList.add("hidden");
        document.getElementById("response").classList.remove("hidden");
        document.getElementById("notimage").classList.add("hidden");
        // Thumbnail Preview
        document.getElementById("file-image").classList.remove("hidden");
        document.getElementById("file-image").src =
          URL.createObjectURL(file);
      } else {
        document.getElementById("file-image").classList.add("hidden");
        document.getElementById("notimage").classList.remove("hidden");
        document.getElementById("start").classList.remove("hidden");
        document.getElementById("response").classList.add("hidden");
        document.getElementById("file-upload-form").reset();
      }
    }

    function setProgressMaxValue(e) {
      var pBar = document.getElementById("file-progress");

      if (e.lengthComputable) {
        pBar.max = e.total;
      }
    }

    function updateFileProgress(e) {
      var pBar = document.getElementById("file-progress");

      if (e.lengthComputable) {
        pBar.value = e.loaded;
      }
    }

    function uploadFile(file) {
      var xhr = new XMLHttpRequest(),
        fileInput = document.getElementById("class-roster-file"),
        pBar = document.getElementById("file-progress"),
        fileSizeLimit = 1024; // In MB
      if (xhr.upload) {
        // Check if file is less than x MB
        if (file.size <= fileSizeLimit * 1024 * 1024) {
          // Progress bar
          pBar.style.display = "inline";
          xhr.upload.addEventListener(
            "loadstart",
            setProgressMaxValue,
            false
          );
          xhr.upload.addEventListener(
            "progress",
            updateFileProgress,
            false
          );

          // File received / failed
          xhr.onreadystatechange = function (e) {
            if (xhr.readyState == 4) {
              // Everything is good!
              // progress.className = (xhr.status == 200 ? "success" : "failure");
              // document.location.reload(true);
            }
          };

          // Start upload
          xhr.open(
            "POST",
            document.getElementById("file-upload-form").action,
            true
          );
          xhr.setRequestHeader("X-File-Name", file.name);
          xhr.setRequestHeader("X-File-Size", file.size);
          xhr.setRequestHeader("Content-Type", "multipart/form-data");
          xhr.send(file);
        } else {
          output(
            "Please upload a smaller file (< " + fileSizeLimit + " MB)."
          );
        }
      }
    }

    // Check for the various File API support.
    if (window.File && window.FileList && window.FileReader) {
      Init();
    } else {
      document.getElementById("file-drag").style.display = "none";
    }
  }
  ekUpload();
</script>
<!-- Upload script End -->
<!-- upload image js -->
<script>
  jQuery(document).ready(function () {
    ImgUpload();
  });

  function ImgUpload() {
    var imgWrap = "";
    var imgArray = [];

    $(".upload__inputfile").each(function () {
      $(this).on("change", function (e) {
        imgWrap = $(this).closest(".upload__box").find(".upload__img-wrap");
        var maxLength = $(this).attr("data-max_length");

        var files = e.target.files;
        var filesArr = Array.prototype.slice.call(files);
        var iterator = 0;
        filesArr.forEach(function (f, index) {
          if (!f.type.match("image.*")) {
            return;
          }

          if (imgArray.length > maxLength) {
            return false;
          } else {
            var len = 0;
            for (var i = 0; i < imgArray.length; i++) {
              if (imgArray[i] !== undefined) {
                len++;
              }
            }
            if (len > maxLength) {
              return false;
            } else {
              imgArray.push(f);

              var reader = new FileReader();
              reader.onload = function (e) {
                var html =
                  "<div class='upload__img-box'><div style='background-image: url(" +
                  e.target.result +
                  ")' data-number='" +
                  $(".upload__img-close").length +
                  "' data-file='" +
                  f.name +
                  "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                imgWrap.append(html);
                iterator++;
              };
              reader.readAsDataURL(f);
            }
          }
        });
      });
    });

    $("body").on("click", ".upload__img-close", function (e) {
      var file = $(this).parent().data("file");
      for (var i = 0; i < imgArray.length; i++) {
        if (imgArray[i].name === file) {
          imgArray.splice(i, 1);
          break;
        }
      }
      $(this).parent().parent().remove();
    });
  }
</script>
<!-- upload image js ended here -->
<script>
  $(document).ready(function () {
    $(".owl-carousel").owlCarousel({
      items: 4,
      margin: 30,
    });
  });
</script>
<!-- Add remove input field js start -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    var maxField = 10; // Maximum number of input fields
    var addButton = document.querySelector(".add_button");
    var wrapper = document.querySelector(".input_fields_wrap");
    var fieldHTML =
      '<div class="col-md-1"><label class="form-label">Feature</label></div><div class="col-md-11 remove-input"><div class="input-group mb-3" id="input-group-"><input type="text" class="form-control form-control-lg" name="category_name[]" placeholder="Feature" aria-label="category Name" aria-describedby="button-addon" /><button class="btn btn-outline-secondary remove-button" type="button" id="button-addon" onclick="removeField(this);">Remove</button></div></div>';
    var x = 1;

    addButton.addEventListener("click", function () {
      if (x < maxField) {
        x++;
        var newField = document.createElement("div");
        newField.classList.add("row");
        newField.innerHTML = fieldHTML.replace(
          /input-group-/g,
          "input-group-" + x
        );
        wrapper.appendChild(newField);
      } else {
        alert(
          "A maximum of " + maxField + " fields are allowed to be added."
        );
      }
    });

    wrapper.addEventListener("click", function (e) {
      if (e.target.classList.contains("remove-button")) {
        e.target.parentNode.parentNode.remove();
        x--;
      }
    });
  });

  function removeField(element) {
    element.parentNode.parentNode.remove();
  }
</script>

<!-- ended -->





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

