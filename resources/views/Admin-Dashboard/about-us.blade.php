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
    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="assets/admin/asset/css/bootstrap.min.css" />
     <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
     <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
       <!-- file upload link -->
       <link 
       rel="stylesheet"
       href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css"
     />
     <link
       rel="stylesheet"
       href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
     />
     <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
  
      <!-- js -->
 <script
 src="https://code.jquery.com/jquery-3.7.1.min.js"
 integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
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
    <link rel="stylesheet" href="assets/admin/asset/css/style.css">
    <link rel="stylesheet" href="assets/user/asset/css/style.css">
    <link rel="stylesheet" href="assets/admin/asset/css/about-us.css">
    <link rel="stylesheet" href="assets/admin/asset/css/daynamic.css">
    <title>Super Admin Dashboard | Dynamic Management-About Us</title>
</head>
<style>
  .button{
    color:#0072B1!important;
  }
</style> 
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
                                  <h1 class="dash-title">Dynamic Management</h1>
                                  <i class="fa-solid fa-chevron-right"></i>
                                  <span class="min-title">About us</span>
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
     <h1>About Us</h1>
    </div>
  </div>
</div>
<!-- =============== -->
     <!-- ========= PRIVACY POLICY FORM SECTION START FROM HERE ========== -->
     <form action="/update-about-us-dynamic" method="POST" enctype="multipart/form-data">
      @csrf
     <div class="form-section conditions">
      <div class="row major-section">
        <div class="col-md-12 ">
          <div class="row">
            <div class="col-12 ">
              <label for="inputAddress" class="form-label"
                >Show/Hide</label
              >
              <input type="hidden"  name="section_1" id="section_1" >
              <input type="checkbox"id="aa1"   class="add-page-check" @if ($about) @if ($about->section_1 == 1) checked  @endif @endif >
              <label for="aa1"><span></span></label>
            </div>
              <div class="col-12">
                <label for="inputAddress" class="form-label"
                  >Cover Image Heading</label
                >
                <input
                  type="text"
                  class="form-control" value="@if ($about) {{$about->image_heading}} @endif"
                  id="inputAddress" name="image_heading" required
                  placeholder="Discover Classes and Freelance Categories"
                />
              </div>
              <!--Image-->
              <div class="col-md-12 personal-info identity" id="upload-image1">
                <label for="">Hero Section Image</label>
                <div class="input-file-wrapper transition-linear-3 position-relative">
                  <span
                    class="remove-img-btn position-absolute"
                    @click="reset('post-thumbnail2')"
                    v-if="preview!==null"
                  >
                    Remove
                  </span>
                  <label
                    class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                    for="post-thumbnail2"
                  >
                    <span v-show="preview===null">
                      <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                      <span class="d-block">Upload Image</span>
                      <p>Drag and drop files here</p>
                    </span>
                    <template v-if="preview">
                      <img :src="preview" class="img-fluid mt-2" />
                    </template>
                  </label>
                  <input
                    type="file"
                    accept="image/*"
                    @change="previewImage('post-thumbnail2')"
                    class="input-file"
                    id="post-thumbnail2"
                  />
                </div>
              </div>
              <div class="col-12 mt-0 form-sec">
                <label for="inputAddress2" class="form-label"
                  >About DreamCrowd</label
                >
                <br />
                <textarea 
                  name="about"
                  id=""
                  cols="3"
                  rows="5" required
                  placeholder="Dreamcrowd is an innovative booking platform which supplies an exciting range of online classes and virtual activities for customers around the world. We provide enjoyable experience for sole-individuals, friends, families, work associates, couples, and other range of customers. Our online classes and activities are personalised and hosted by passionate teachers and creators worldwide. Whether you are looking to learn something new or looking for refreshing form of online experience to enjoy with groups of people,
Dreamcrowd has you covered!"
                > @if ($about) {{$about->about}} @endif</textarea>
              </div>
              <div class="col-12 ">
                <label for="inputAddress" class="form-label"
                  >Show/Hide</label
                >
                <input type="hidden"  name="section_2" id="section_2" >
                <input type="checkbox"id="aa2"   class="add-page-check" @if ($about) @if ($about->section_2 == 1) checked  @endif @endif >
                <label for="aa2"><span></span></label>
              </div>
              <!--Image-->
              <div class="col-md-12 identity" id="upload-image2" style="margin-bottom: 10px;">
                <div class="input-file-wrapper transition-linear-3 position-relative">
                  <span
                    class="remove-img-btn position-absolute" style="cursor: pointer;background: #ed5646;color: white !important;border-radius: 5px;z-index: 10;padding: 4px 8px !important;"
                    @click="reset('post-thumbnail2')"
                    v-if="preview!==null"
                  >
                    Remove
                  </span>
                  <label
                    class="input-style input-label lh-1-7 p-4 text-center cursor-pointer"
                    for="post-thumbnail2" style="background: #f4fbff;border-radius: 4px;cursor: pointer; width: 100%;"
                  >
                    <span v-show="preview===null">
                      <i class="fa-solid fa-cloud-arrow-up pt-3" style="color: #ababab; font-size: 40px; margin-bottom: 10px;"></i>
                      <span class="d-block" style="color: #0072b1;margin-bottom: 10px;">Upload Image</span>
                      <p>Drag and drop files here</p>
                    </span>
                    <template v-if="preview" style="height: 250px; width:100%">
                      <img :src="preview" class="img-fluid mt-2"  style="height: 180px;" />
                    </template>
                  </label>
                  <input
                    type="file"   name="cover_image_2"
                    accept="image/*" value=""
                    @change="previewImage('post-thumbnail2')"
                    class="input-file"
                    id="post-thumbnail2"
                  />
                </div>
              </div>
              <!-- Inline form start from here -->
              <div class="row major-section">
              
                  <div class="row form-det">
                    <div class="col-12 form-sec">
                      <label for="inputAddress" class="form-label"
                        >Tagline (How it works)</label
                      >
                      <input
                        type="text" name="tag_line"
                        class="form-control mb-0" value="@if ($about) {{$about->tag_line}} @endif"
                        id="inputAddress" required 
                        placeholder="Discover Classes and Freelance Categories"
                      />
                    </div>
                    <div class="row form-det">
                      <div class="col-md-4">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <label for="inputPassword6" class="col-form-label"
                              >Heading</label
                            >
                          </div>
                          <div class="col-8">
                            <input
                              type="text" name="heading_1"
                              id="inputPassword6" required
                              class="form-control mt-3" value="@if ($about) {{$about->heading_1}} @endif"
                              aria-describedby="passwordHelpInline"
                              placeholder="write here heading"
                            />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <label for="inputPassword6" class="col-form-label"
                              >Detail</label
                            >
                          </div>
                          <div class="col-10">
                            <input
                              type="text" name="detail_1"
                              id="inputPassword6" required
                              class="form-control mt-3" value="@if ($about) {{$about->details_1}} @endif"
                              aria-describedby="passwordHelpInline"
                              placeholder="add detail"
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row form-det">
                      <div class="col-md-4">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <label for="inputPassword6" class="col-form-label"
                              >Heading</label
                            >
                          </div>
                          <div class="col-8">
                            <input
                              type="text" name="heading_2"
                              id="inputPassword6" required
                              class="form-control mt-3" value="@if ($about) {{$about->heading_2}} @endif"
                              aria-describedby="passwordHelpInline"
                              placeholder="write here heading"
                            />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <label for="inputPassword6" class="col-form-label"
                              >Detail</label
                            >
                          </div>
                          <div class="col-10">
                            <input
                              type="text" name="detail_2"
                              id="inputPassword6" required
                              class="form-control mt-3" value="@if ($about) {{$about->details_2}} @endif"
                              aria-describedby="passwordHelpInline"
                              placeholder="add detail"
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <label for="inputPassword6" class="col-form-label"
                              >Heading</label
                            >
                          </div>
                          <div class="col-8">
                            <input
                              type="text" name="heading_3"
                              id="inputPassword6" required
                              class="form-control mt-3" value="@if ($about) {{$about->heading_3}} @endif"
                              aria-describedby="passwordHelpInline"
                              placeholder="write here heading"
                            />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <label for="inputPassword6" class="col-form-label"
                              >Detail</label
                            >
                          </div>
                          <div class="col-10">
                            <input
                              type="text" name="detail_3"
                              id="inputPassword6" required
                              class="form-control mt-3" value="@if ($about) {{$about->details_3}} @endif"
                              aria-describedby="passwordHelpInline"
                              placeholder="add detail"
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                
              </div>
           
          </div>
        </div>
      </div>
     </div>
    </div>
    <!-- ========= PRIVACY POLICY FORM SECTION ENDED FROM HERE ========== -->               
                     <div class="api-buttons">
      <div class="row major-section">
        <div class="col-md-12 ">
          <button type="button" class="btn float-start cancel-btn">
            Cancel
          </button>
          <button type="submit" class="btn float-end update-btn">Update</button>
        </div>
      </div>
    </div>

  </form>
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

{{-- Section Show Hide Value Set Script --}}
<script>

  $(document).ready(function () {
    if($('#aa1').attr('checked')) {
                $('#section_1').val(1);
              }else{
                  $('#section_1').val(0);
              }
    if($('#aa2').attr('checked')) {
                $('#section_2').val(1);
              }else{
                  $('#section_2').val(0);
              }
  });
  
  
    $('#aa1').click(function () { 
       
      if($('#aa1').attr('checked')) {
                  $('#aa1').removeAttr('checked');
                $('#section_1').val(0);
              }else{
                  $('#aa1').attr('checked', 1);
                  $('#section_1').val(1);
              }
      
    });
  
    $('#aa2').click(function () { 
       
      if($('#aa2').attr('checked')) {
                  $('#aa2').removeAttr('checked');
                $('#section_2').val(0);
              }else{
                  $('#aa2').attr('checked', 1);
                  $('#section_2').val(1);
              }
      
    });
  </script>
   <!-- Hide Show Content -->
 
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

{{-- Image Upload Script Start ========= --}}
<script>
 var cover_image_1 = 'assets/public-site/asset/img/<?php echo $about->cover_image_1 ?>';
    var cover_image_2 = 'assets/public-site/asset/img/<?php echo $about->cover_image_2 ?>';
    
    
  // 2
new Vue({
  el: "#upload-image1",
  data() {
    return {
      preview: cover_image_1,
      image: null,
    };
  },
  methods: {
    previewImage: function (id) {
      console.log('yesss');
      
      let input = document.getElementById(id);
      if (input.files) {
        let reader = new FileReader();
        reader.onload = (e) => {
        
              
          var image = new Image();
           //Set the Base64 string return from FileReader as source.
          image.src = e.target.result;
          let data;
           image.onload = function () {
               //Determine the Height and Width.
              var height = this.height;
              var width = this.width;
              if (height != 472 || width != 1440) {
                document.getElementById(id).value = "";
                this.preview = null;
                
                   toastr.options =
                      {
                          "closeButton" : true,
                           "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "10000" // 10 seconds
                      }
                       toastr.error("Cover Image Height 472px and Width 1440px Only Allowed!");
                       data = "false"; 
                      }else{
                        data = "true"; 
                    }
                  
                };
                
                setTimeout(() => {
                  if (data == "true") {
                    this.preview = e.target.result;
                    
                  } }, 10);

        };
        this.image = input.files[0];
        reader.readAsDataURL(input.files[0]);
      }
    },
    reset: function (id) {
      if (!confirm("Are You Sure, You Want to Remove ?")){
      return false;
    }
      this.image = null;
      this.preview = null;
      // Clear the input element
      document.getElementById(id).value = "";
    },
  },
});
    // 3
    new Vue({
  el: "#upload-image2",
  data() {
    return {
      preview: cover_image_2,
      image: null,
    };
  },
  methods: {
    previewImage: function (id) {
      let input = document.getElementById(id);
      if (input.files) {
        let reader = new FileReader();
        reader.onload = (e) => {
                
          var image = new Image();
           //Set the Base64 string return from FileReader as source.
          image.src = e.target.result;
          let data;
           image.onload = function () {
               //Determine the Height and Width.
              var height = this.height;
              var width = this.width;
              if (height != 472 || width != 1440) {
                document.getElementById(id).value = "";
                this.preview = null;
                
                   toastr.options =
                      {
                          "closeButton" : true,
                           "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "10000" // 10 seconds
                      }
                       toastr.error("Cover Image Height 472px and Width 1440px Only Allowed!");
                       data = "false"; 
                      }else{
                        data = "true"; 
                    }
                  
                };
                
                setTimeout(() => {
                  if (data == "true") {
                    this.preview = e.target.result;
                    
                  } }, 10);
        };
        this.image = input.files[0];
        reader.readAsDataURL(input.files[0]);
      }
    },
    reset: function (id) {
      if (!confirm("Are You Sure, You Want to Remove ?")){
      return false;
    }
      this.image = null;
      this.preview = null;
      // Clear the input element
      document.getElementById(id).value = "";
    },
  },
});

</script>
  {{-- Image Upload Script End ========= --}}
<!-- ================ side js start End=============== -->



