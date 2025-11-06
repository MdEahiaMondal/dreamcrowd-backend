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
    <title>Super Admin Dashboard | Dynamic Management-About Us</title>
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
                    <span class="min-title">Contact us</span>
                  </div>
                </div>
              </div>
              <!-- Blue MASSEGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <img src="assets/admin/asset/img/dynamic-management.svg" alt="" />
                      <h2>Dynamic Management</h2>
                    </div>
                  </div>
                </div>
              </div>
              <!-- ============ -->
              <div class="send-notify">
                <div class="row">
                  <div class="col-md-12">
                    <h1>Contact Us</h1>
                  </div>
                </div>
              </div>
              <!-- =============== -->
              <!-- ========= PRIVACY POLICY FORM SECTION START FROM HERE ========== -->
              <div class="form-section conditions">
                <div class="row major-section">
                  <div class="col-md-12">
                    <div class="">
                      <form>
                        <div class="col-12">
                          <label for="inputAddress" class="form-label"
                            >Cover Image Heading</label
                          >
                          <input
                            type="text"
                            class="form-control"
                            id="inputAddress"
                            placeholder="Cover Image Heading"
                          />
                        </div>
                        <!--Image-->
                        <div class="col-md-12 form-sec personal-info">
                          <label for="inputAddress" class="form-label"
                            >Cover Image</label
                          >
                          <!-- Upload file start -->
                          <div class="upload__box">
                            <div class="upload__btn-box">
                              <label class="upload__btn">
                                <svg
                                  xmlns="http://www.w3.org/2000/svg"
                                  width="61"
                                  height="60"
                                  viewBox="0 0 61 60"
                                  fill="none"
                                >
                                  <path
                                    d="M32.375 50.625V39.375H39.875L30.5 28.125L21.125 39.375H28.625V50.625H19.25V50.5312C18.935 50.55 18.635 50.625 18.3125 50.625C14.5829 50.625 11.006 49.1434 8.36881 46.5062C5.73158 43.869 4.25 40.2921 4.25 36.5625C4.25 29.3475 9.70625 23.4675 16.7075 22.6613C17.3213 19.4523 19.0342 16.5576 21.5514 14.475C24.0686 12.3924 27.2329 11.252 30.5 11.25C33.7675 11.2518 36.9323 12.3921 39.4502 14.4747C41.9681 16.5573 43.6816 19.452 44.2962 22.6613C51.2975 23.4675 56.7462 29.3475 56.7462 36.5625C56.7462 40.2921 55.2647 43.869 52.6274 46.5062C49.9902 49.1434 46.4134 50.625 42.6837 50.625C42.3687 50.625 42.065 50.55 41.7462 50.5312V50.625H32.375Z"
                                    fill="#ABABAB"
                                  />
                                </svg>
                                <p>Upload Image</p>
                                <p class="gray-text">
                                  Drag and drop files here
                                </p>
                                <input
                                  type="file"
                                  multiple=""
                                  data-max_length="20"
                                  class="upload__inputfile"
                                />
                              </label>
                            </div>
                            <div class="upload__img-wrap"></div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- ========= PRIVACY POLICY FORM SECTION ENDED FROM HERE ========== -->
            <div class="api-buttons">
              <div class="row major-section">
                <div class="col-md-12">
                  <button type="button" class="btn float-start cancel-btn">
                    Cancel
                  </button>
                  <button type="button" class="btn float-end update-btn">
                    Update
                  </button>
                </div>
              </div>
            </div>
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
        document.getElementById("file-image").src = URL.createObjectURL(file);
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
          xhr.upload.addEventListener("loadstart", setProgressMaxValue, false);
          xhr.upload.addEventListener("progress", updateFileProgress, false);

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
          output("Please upload a smaller file (< " + fileSizeLimit + " MB).");
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
        alert("A maximum of " + maxField + " fields are allowed to be added.");
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
<!-- ================ side js start End=============== -->

