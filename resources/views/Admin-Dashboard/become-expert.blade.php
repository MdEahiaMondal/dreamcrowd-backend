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
    <!-- file upload link -->
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
  <!-- <link rel="stylesheet" href="../User-Dashboard/assets/css/style.css"> -->
  <link rel="stylesheet" href="assets/admin/asset/css/daynamic.css">
    <title>Super Admin Dashboard | Dynamic Management-Become An Expert</title>
  </head>
  <style>
    .button {
      color: #0072b1 !important;
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
            <form action="/update-become-expert-dynamic" method="POST" enctype="multipart/form-data">
              @csrf
            
            <div class="dash">
              <div class="row">
                <div class="col-md-12">
                  <div class="dash-top">
                    <h1 class="dash-title">Dashboard</h1>
                    <i class="fa-solid fa-chevron-right"></i>
                    <h1 class="dash-title">Dynamic Management</h1>
                    <i class="fa-solid fa-chevron-right"></i>
                    <span class="min-title">Become an expert</span>
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
              <!-- ========= PRIVACY POLICY SECTION START FROM HERE ========== -->
              <div
                class="api-section"
                type="button"
                value="Show/Hide"
                onClick="showHideDiv('divMsg')"
              >
                <div class="row major-section">
                  <div class="col-md-12">
                    <h5 class="mb-0">Hero Section</h5>
                    <div class="float-end edit-sec">
                      <i
                        class="fa-solid fa-pencil"
                      ></i>
                    </div>
                  </div>
                </div>
              </div>
              <!-- ========= PRIVACY POLICY SECTION ENDED FROM HERE ========== -->
              <!-- ========= PRIVACY POLICY FORM SECTION START FROM HERE ========== -->
              <div class="form-section conditions" id="divMsg">
                <div class="row major-section">
                  <div class="col-md-12">
                    <div class="">
                      {{-- <form> --}}
                        <div class="col-12 form-sec">
                          <label for="inputAddress" class="form-label"
                            >Hero Section Heading</label
                          >
                          <input
                            type="text" name="hero_heading"
                            class="form-control" value="@if($expert){{$expert->hero_heading}}@endif"
                            id="inputAddress" required
                            placeholder="Discover Classes and Freelance Categories"
                          />
                        </div>
                        <div class="col-12 form-sec">
                          <label for="inputAddress2" class="form-label"
                            >Hero Section description</label
                          >
                          <input
                            type="text" name="hero_description"
                            class="form-control" value="@if($expert){{$expert->hero_description}}@endif"
                            id="inputAddress2" required
                            placeholder="Discover Classes and Freelance Categories"
                          />
                        </div>
                        <div class="col-12 form-sec">
                          <label for="inputAddress2" class="form-label"
                            >Button</label
                          >
                          <input
                            type="text" name="hero_btn_link"
                            class="form-control" value="@if($expert){{$expert->hero_btn_link}}@endif"
                            id="inputAddress2" required
                            placeholder="Button Link"
                          />
                        </div>
                        <!--Image-->
                         
                        <label for="inputAddress" class="form-label">Cover Image</label>
                        <div class="col-md-12 identity" id="upload-image1" style="margin-bottom: 10px;">
                          <div class="input-file-wrapper transition-linear-3 position-relative">
                            <span
                              class="remove-img-btn position-absolute" style="cursor: pointer;background: #ed5646;color: white !important;border-radius: 5px;z-index: 10;padding: 4px 8px !important;"
                              @click="reset('post-thumbnail1')"
                              v-if="preview!==null"
                            >
                              Remove
                            </span>
                            <label
                              class="input-style input-label lh-1-7 p-4 text-center cursor-pointer"
                              for="post-thumbnail1" style="background: #f4fbff;border-radius: 4px;cursor: pointer; width: 100%;"
                            >
                              <span v-show="preview===null">
                                <i class="fa-solid fa-cloud-arrow-up pt-3" style="color: #ababab; font-size: 40px; margin-bottom: 10px;"></i>
                                <span class="d-block" style="color: #0072b1;margin-bottom: 10px;">Upload Image</span>
                                <p>Drag and drop files here</p>
                              </span>
                              <template v-if="preview" style="height: 250px; width:100%">
                                <img :src="preview" class="img-fluid mt-2" style="height: 180px;" />
                              </template>
                            </label>
                            <input
                              type="file"   name="hero_image"
                              accept="image/*" value=""
                              @change="previewImage('post-thumbnail1')"
                              class="input-file"
                              id="post-thumbnail1"
                            />
                          </div>
                        </div>
                      {{-- </form> --}}
                    </div>
                  </div>
                </div>
              </div>
              <!-- ========= PRIVACY POLICY FORM SECTION ENDED FROM HERE ========== -->
              <div
                class="api-section"
                type="button"
                value="Show/Hide"
                onClick="showHideDiv('divMsg1')"
              >
                <div class="row major-section">
                  <div class="col-md-12">
                    <h5 class="mb-0">How it work</h5>
                    <div class="float-end edit-sec">
                      <i
                        class="fa-solid fa-pencil"
                      ></i>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Inline form start from here -->
              <div class="form-section" id="divMsg1">
                <div class="row major-section">
                  {{-- <form action="" class=""> --}}
                    <div class="row form-det">
                      <div class="col-md-4">
                        <div class="row "  style="align-items: baseline;">
                          <div class="col-auto">
                            <label for="inputPassword6" class="col-form-label"
                              >Heading</label
                            >
                          </div>
                          <div class="col-8">
                            <input
                              type="text" name="work_heading_1"
                              id="inputPassword6" value="@if($expert){{$expert->work_heading_1}}@endif"
                              class="form-control" required
                              aria-describedby="passwordHelpInline"
                              placeholder="write here heading"
                            />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="row" style="align-items: baseline;">
                          <div class="col-auto">
                            <label for="detailInput" class="col-form-label"
                              >Detail</label
                            >
                          </div>
                          <div class="col-7">
                            <input
                              type="text" name="work_detail_1"
                              id="detailInput" value="@if($expert){{$expert->work_detail_1}}@endif"
                              class="form-control" required
                              aria-describedby="passwordHelpInline"
                              placeholder="Add detail"
                            />
                          </div>
                          <div class="col-3">
                            <div class="input-group">
                              <div class="custom-file">
                                <input
                                  type="file"  name="work_image_1"
                                  class="custom-file-input"  value="@if($expert){{$expert->work_image_1}}@endif"
                                  id="imageInput" 
                                  aria-describedby="imageInputAddon"
                                  onchange="updateImageFileName(this)"
                                />
                                <label
                                  class="custom-file-label"
                                  for="imageInput"
                                  >@if($expert){{$expert->work_image_1}} @else Upload Image @endif</label
                                >
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row form-det">
                      <div class="col-md-4">
                        <div class="row " style="align-items: baseline;">
                          <div class="col-auto">
                            <label for="inputPassword6" class="col-form-label"
                              >Heading</label
                            >
                          </div>
                          <div class="col-8">
                            <input
                              type="text" name="work_heading_2"
                              id="inputPassword6" value="@if($expert){{$expert->work_heading_2}}@endif"
                              class="form-control" required
                              aria-describedby="passwordHelpInline"
                              placeholder="write here heading"
                            />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="row " style="align-items: baseline;">
                          <div class="col-auto">
                            <label for="detailInput1" class="col-form-label"
                              >Detail</label
                            >
                          </div>
                          <div class="col-7">
                            <input
                              type="text" name="work_detail_2"
                              id="detailInput1" value="@if($expert){{$expert->work_detail_2}}@endif"
                              class="form-control" required
                              aria-describedby="passwordHelpInline"
                              placeholder="Add detail"
                            />
                          </div>
                          <div class="col-3">
                            <div class="input-group">
                              <div class="custom-file">
                                <input
                                  type="file"  name="work_image_2"
                                  class="custom-file-input" value="@if($expert){{$expert->work_image_2}}@endif"
                                  id="imageInput1" 
                                  aria-describedby="imageInputAddon1"
                                  onchange="updateImageFileName(this)"
                                />
                                <label
                                  class="custom-file-label"
                                  for="imageInput1"
                                  >@if($expert){{$expert->work_image_2}} @else Upload Image @endif</label
                                >
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="row " style="align-items: baseline;">
                          <div class="col-auto">
                            <label for="inputPassword6" class="col-form-label"
                              >Heading</label
                            >
                          </div>
                          <div class="col-8">
                            <input
                              type="text"  name="work_heading_3"
                              id="inputPassword6" value="@if($expert){{$expert->work_heading_3}}@endif"
                              class="form-control" required
                              aria-describedby="passwordHelpInline"
                              placeholder="write here heading"
                            />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="row  " style="align-items: baseline;">
                          <div class="col-auto">
                            <label for="detailInput2" class="col-form-label"
                              >Detail</label
                            >
                          </div>
                          <div class="col-7">
                            <input
                              type="text" name="work_detail_3"
                              id="detailInput2" value="@if($expert){{$expert->work_detail_3}}@endif"
                              class="form-control" required
                              aria-describedby="passwordHelpInline"
                              placeholder="Add detail"
                            />
                          </div>
                          <div class="col-3">
                            <div class="input-group">
                              <div class="custom-file">
                                <input
                                  type="file"  name="work_image_3"
                                  class="custom-file-input"
                                  id="imageInput2" value="@if($expert){{$expert->work_image_3}}@endif"
                                  aria-describedby="imageInputAddon2"
                                  onchange="updateImageFileName(this)"
                                />
                                <label
                                  class="custom-file-label"
                                  for="imageInput2"
                                  >@if($expert){{$expert->work_image_3}} @else Upload Image @endif</label
                                >
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  {{-- </form> --}}
                </div>
              </div>
              <div
                class="api-section"
                type="button"
                value="Show/Hide"
                onClick="showHideDiv('divMsg2')"
              >
                <div class="row major-section">
                  <div class="col-md-12">
                    <h5 class="mb-0">Who can host the class</h5>
                    <div class="float-end edit-sec">
                      <i
                        class="fa-solid fa-pencil"
                      ></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-section" id="divMsg2">
                <div class="row major-section">
                  <div class="col-md-12">
                    <div class="">
                      {{-- <form> --}}
                        <div class="col-12 mt-0">
                          <label for="inputAddress2" class="form-label"
                            >Heading</label
                          >
                          <br />
                          <input
                          type="text" name="host_heading"
                          id="host_heading" value="@if($expert){{$expert->host_heading}}@endif"
                          class="form-control" required
                          aria-describedby="passwordHelpInline"
                          placeholder="Host Heading"
                        />
                        </div>

                        <div class="col-12 mt-0">
                          <label for="inputAddress2" class="form-label"
                            >Description</label
                          >
                          <br />
                          <textarea
                            name="host_description"
                            id=""
                            cols="3"
                            rows="5"
                            placeholder="Dreamcrowd is an innovative booking platform which supplies an exciting range of online classes and virtual activities for customers around the world. We provide enjoyable experience for sole-individuals, friends, families, work associates, couples, and other range of customers.Our online classes and activities are personalised and hosted by passionate teachers and creators worldwide. 
Whether you are looking to learn something new or looking for refreshing form of online experience to enjoy with groups of people 
Dreamcrowd has you covered!"
                          >@if($expert){{$expert->host_description}}@endif</textarea>
                        </div>
                        <div class="col-12 mt-0">
                          <label for="inputAddress2" class="form-label"
                            >Images</label
                          >
                          <!-- Upload Start -->
                          <div class="row work-sec">
                            <div
                              class="col-md-3 gallery identity"
                              id="upload-image12"
                            >
                              <div
                                class="input-file-wrapper transition-linear-3 position-relative"
                              >
                                <span
                                  class="remove-img-btn position-absolute"
                                  @click="reset('post-thumbnail12')"
                                  v-if="preview!==null"
                                >
                                  Remove
                                </span>
                                <label
                                  class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                  for="post-thumbnail12"
                                >
                                  <span v-show="preview===null">
                                    <i
                                      class="fa-solid fa-cloud-arrow-up pt-3"
                                    ></i>
                                    <span class="d-block">Upload Image</span>
                                    <p>Drag and drop files here</p>
                                  </span>
                                  <template v-if="preview">
                                    <img
                                      :src="preview"
                                      class="img-fluid mt-2"
                                    />
                                  </template>
                                </label>
                                <input
                                  type="file" name="host_image_1"
                                  accept="image/*" 
                                  @change="previewImage('post-thumbnail12')"
                                  class="input-file"  value="@if($expert){{$expert->host_image_1}}@endif"
                                  id="post-thumbnail12"
                                />
                              </div>
                            </div>
                            <div
                              class="col-md-3 gallery identity"
                              id="upload-image13"
                            >
                              <div
                                class="input-file-wrapper transition-linear-3 position-relative"
                              >
                                <span
                                  class="remove-img-btn position-absolute"
                                  @click="reset('post-thumbnail13')"
                                  v-if="preview!==null"
                                >
                                  Remove
                                </span>
                                <label
                                  class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                  for="post-thumbnail13"
                                >
                                  <span v-show="preview===null">
                                    <i
                                      class="fa-solid fa-cloud-arrow-up pt-3"
                                    ></i>
                                    <span class="d-block">Upload Image</span>
                                    <p>Drag and drop files here</p>
                                  </span>
                                  <template v-if="preview">
                                    <img
                                      :src="preview"
                                      class="img-fluid mt-2"
                                    />
                                  </template>
                                </label>
                                <input
                                  type="file" name="host_image_2"
                                  accept="image/*"  
                                  @change="previewImage('post-thumbnail13')"
                                  class="input-file"  value="@if($expert){{$expert->host_image_2}}@endif"
                                  id="post-thumbnail13"
                                />
                              </div>
                            </div>
                            <div
                              class="col-md-3 gallery identity"
                              id="upload-image14"
                            >
                              <div
                                class="input-file-wrapper transition-linear-3 position-relative"
                              >
                                <span
                                  class="remove-img-btn position-absolute"
                                  @click="reset('post-thumbnail14')"
                                  v-if="preview!==null"
                                >
                                  Remove
                                </span>
                                <label
                                  class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                  for="post-thumbnail14"
                                >
                                  <span v-show="preview===null">
                                    <i
                                      class="fa-solid fa-cloud-arrow-up pt-3"
                                    ></i>
                                    <span class="d-block">Upload Image</span>
                                    <p>Drag and drop files here</p>
                                  </span>
                                  <template v-if="preview">
                                    <img
                                      :src="preview"
                                      class="img-fluid mt-2"
                                    />
                                  </template>
                                </label>
                                <input
                                  type="file" name="host_image_3"
                                  accept="image/*"  
                                  @change="previewImage('post-thumbnail14')"
                                  class="input-file"  value="@if($expert){{$expert->host_image_3}}@endif"
                                  id="post-thumbnail14"
                                />
                              </div>
                            </div>
                            <div
                              class="col-md-3 gallery identity"
                              id="upload-image15"
                            >
                              <div
                                class="input-file-wrapper transition-linear-3 position-relative"
                              >
                                <span
                                  class="remove-img-btn position-absolute"
                                  @click="reset('post-thumbnail15')"
                                  v-if="preview!==null"
                                >
                                  Remove
                                </span>
                                <label
                                  class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                  for="post-thumbnail15"
                                >
                                  <span v-show="preview===null">
                                    <i
                                      class="fa-solid fa-cloud-arrow-up pt-3"
                                    ></i>
                                    <span class="d-block">Upload Image</span>
                                    <p>Drag and drop files here</p>
                                  </span>
                                  <template v-if="preview">
                                    <img
                                      :src="preview"
                                      class="img-fluid mt-2"
                                    />
                                  </template>
                                </label>
                                <input
                                  type="file" name="host_image_4"
                                  accept="image/*"  
                                  @change="previewImage('post-thumbnail15')"
                                  class="input-file"  value="@if($expert){{$expert->host_image_4}}@endif"
                                  id="post-thumbnail15"
                                />
                              </div>
                            </div>
                          </div>
                          <!-- Upload End -->
                        </div>
                      {{-- </form> --}}
                    </div>
                  </div>
                </div>
              </div>
              <div
                class="api-section"
                type="button"
                value="Show/Hide"
                onClick="showHideDiv('divMsg3')"
              >
                <div class="row major-section">
                  <div class="col-md-12">
                    <h5 class="mb-0">Host Features</h5>
                    <div class="float-end edit-sec">
                      <i
                        class="fa-solid fa-pencil"
                      ></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-section" id="divMsg3">
                <div class="col-12 mt-0">
                  <label for="inputAddress2" class="form-label"
                    >Heading</label
                  >
                  <br />
                  <input
                  type="text" name="feature_heading"
                  id="feature_heading" value="@if($expert){{$expert->feature_heading}}@endif"
                  class="form-control" required
                  aria-describedby="passwordHelpInline"
                  placeholder="Feature Heading"
                />
                </div>

                <div class="col-md-12">
                  <div class="main">
                    <div  class="profile-form"  id="form" >
                      <div class="row input_fields_wrap">
                        <div id="input_fields-wrap-1" class="row">
                          <div class="col-md-1">
                            <label for="inputEmail4" class="form-label mt-2"
                              >Feature </label
                            >
                          </div>
                          <div class="col-md-11 remove-input">
                            <div class="input-group mb-3" id="input-group-1">
                              <input
                                type="text" id="feature"
                                class="form-control form-control-lg"
                                name="category_name[]"
                                placeholder="Feature "
                                aria-label="category Name"
                                aria-describedby="button-addon"
                              />
                              <button
                                class="btn add-btn add_button"
                                type="button" 
                                onclick="AddFeautre()"
                              >
                                Add
                              </button>
                            </div>
                          </div>
                        </div>
                        <div id="input_fields_write"></div>
                        <div class="col-md-6"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row major-section">
                <div class="col-md-12 api-section">
                  <h2 class="float-start mb-0">All FAQ’s</h2>

                  <div id="main_faqs_div">

                  
                  @if ($expertfaqs)
                  @foreach ($expertfaqs as $item)
                   <div id="FaqsContainer" class="profile-form">
                    <!-- Initial category structure -->
                    <div class="input-group mb-3 faqs">
                      <input
                        type="text" 
                        type="text" value="{{$item->question}}"
                        class="form-control"
                        placeholder="Become Expert FAQS"
                        aria-label="Recipient's username"
                        aria-describedby="button-faq{{$item->id}}"
                        readonly
                      /> 
                      <button
                        class="btn view-button faqs_view_btn"
                        type="button" data-id="{{$item->id}}" data-status="{{$item->status}}" data-question="{{$item->question}}" data-answer="{{$item->answer}}" 
                        id="button-faq{{$item->id}}"
                        onclick="ViewFAQS(this.id)"
                      >View</button>
                    </div>
  
                    <div id="faqs-div-{{$item->id}}" class="all_faqs_div" style="margin-bottom: 10px;"></div>
  
                  </div>
                      
                  @endforeach
                      
                  @endif
                </div>
                  {{-- <div class="float-end">
                    <div class="tggl-grp">
                      <div class="tggl-wrap">
                        <input type="hidden" name="faqs" value="@if($expert){{$expert->faqs}}@endif" id="faqs">
                        <input class="tggl-input"    value="@if($expert){{$expert->faqs}}@endif" id="btn-5" type="checkbox" />
                        <label class="tggl-btn txtswitch ying" for="btn-5">
                          <span class="on">Hide</span
                          ><span class="off">Show</span>
                        </label>
                        
                      </div>
                    </div>
                  </div> --}}
                </div>
              </div>
              <div
                class="api-section"
                type="button"
                value="Show/Hide"
                onClick="showHideDiv('divMsg4')"
              >
                <div
                  class="row major-section"
                  type="button"
                  value="Show/Hide"
                  onClick="showHideDiv('divMsg5')"
                >
                  <div class="col-md-12">
                    <h5 class="mb-0">Sign Up Banner</h5>
                    <div class="float-end edit-sec">
                      <i
                        class="fa-solid fa-pencil"
                      ></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-section conditions" id="divMsg5">
                <div class="row major-section">
                  <div class="col-md-12">
                    <div class="">
                      {{-- <form> --}}
                        <div class="col-12 form-sec">
                          <label for="inputAddress" class="form-label"
                            >Heading</label
                          >
                          <input
                            type="text"  name="banner_heading"
                            class="form-control"  value="@if($expert){{$expert->banner_heading}}@endif"
                            id="inputAddress" required
                            placeholder="Discover Classes and Freelance Categories"
                          />
                        </div>
                        <div class="col-12">
                          <label for="inputAddress2" class="form-label"
                            >Button</label
                          >
                          <input
                            type="text" name="banner_btn_link"
                            class="form-control"  value="@if($expert){{$expert->banner_btn_link}}@endif"
                            id="inputAddress2" required
                            placeholder="Button Link"
                          />
                        </div>
                      {{-- </form> --}}
                    </div>
                  </div>
                </div>
              </div>
              <div
                class="api-section"
                type="button"
                value="Show/Hide"
                onClick="showHideDiv('divMsg6')"
              >
                <div class="row major-section">
                  <div class="col-md-12">
                    <h5 class="mb-0">Become an Expert - 2</h5>
                    <div class="float-end edit-sec">
                      <i
                        class="fa-solid fa-pencil"
                      ></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-section conditions" id="divMsg6">
                <div class="row major-section">
                  <div class="col-md-12">
                    <div class="">
                      {{-- <form> --}}
                        <div class="col-12 form-sec">
                          <label for="inputAddress" class="form-label"
                            >Heading</label
                          >
                          <input
                            type="text" name="expert_heading"
                            class="form-control"  value="@if($expert){{$expert->expert_heading}}@endif"
                            id="inputAddress" required
                            placeholder="Discover Classes and Freelance Categories"
                          />
                        </div>
                        {{-- <div class="col-12 form-sec">
                          <label for="inputAddress2" class="form-label"
                            >Key Points</label
                          >
                          <input
                            type="text" name="expert_btn_link"
                            class="form-control"
                            id="inputAddress2"  value="@if($expert){{$expert->expert_btn_link}}@endif"
                            placeholder="Button Link"
                          />
                        </div> --}}

                         
                        <div class="row input_fields_wrap profile-form">
                          <div id="input_fields-wrap-1" class="row">
                            <div class="col-md-auto">
                              <label for="inputEmail4" class="form-label mt-2"
                                >Key Points </label
                              >
                            </div>
                            <div class="col-md-11 remove-input">
                              <div class="input-group mb-3" id="input-group-1">
                                <input
                                  type="text" id="points"
                                  class="form-control form-control-lg"
                                  name="category_name[]"
                                  placeholder="Feature "
                                  aria-label="category Name"
                                  aria-describedby="button-addon"
                                />
                                <button
                                  class="btn add-btn add_button"
                                  type="button" 
                                  onclick="AddPoints()"
                                >Add</button>
                              </div>
                            </div>
                          </div>
                          <div id="input_fields_write_points"></div>
                          <div class="col-md-6"></div>
                        </div> 

                        <!--Image-->
                        <div class="col-md-12 identity" id="upload-image2" style="margin-bottom: 10px;">
                          <label for="inputAddress" class="form-label">Cover Image</label>
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
                                <img :src="preview" class="img-fluid mt-2" style="height: 180px;" />
                              </template>
                            </label>
                            <input
                              type="file"   name="expert_image" 
                              accept="image/*" value=""
                              @change="previewImage('post-thumbnail2')"
                              class="input-file"
                              id="post-thumbnail2"
                            />
                          </div>
                        </div>
                      {{-- </form> --}}
                    </div>
                  </div>
                </div>
              </div>
              <div class="api-buttons">
                <div class="row major-section">
                  <div class="col-md-12">
                    <button type="button" class="btn float-start cancel-btn">
                      Cancel
                    </button>
                    <button type="submit" class="btn float-end update-btn">
                      Update
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>

          </div>
        </div>
      </div>
      <!-- =============================== MAIN CONTENT END HERE =========================== -->
      <!-- copyright section start from here -->
      <div class="copyright">
        <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
      </div>
      <!-- Button trigger modal -->

      <!-- Modal -->
      <div
        class="modal fade"
        id="exampleModal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" style="border-bottom: none">
              <h5 class="modal-tittle" id="exampleModalLabel">
                Change Heading
              </h5>
            </div>
            <div class="modal-body">
              <textarea
                class="heading-changing"
                name="comments"
                id="feedback_comments"
                placeholder="20"
              ></textarea>
            </div>
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Update
            </button>
          </div>
        </div>
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
  </body>
</html>

{{-- Faqs Show Hide --}}
<script>
  $('.txtswitch').click(function () { 
     console.log('done');
     var faqs = $('#btn-5').val();
     if (faqs == 1) {
      $('#btn-5').val(0);
      $('#faqs').val(0);
     } else {
      $('#btn-5').val(1);
      $('#faqs').val(1);
     }
    
  });

  $(document).ready(function () {
    var faqs = $('#btn-5').val();
    if (faqs == 1) {
      $('#btn-5').attr('checked', 1);
     } else {
      $('#btn-5').removeAttr('checked');
     }
  });
</script>
<!-- upload image js -->
<script>

function CoverImage1(input) {
if (input.files && input.files[0]) {
var reader = new FileReader();

reader.onload = function (e) {
 $('#hero_image_div')
     .attr('src', e.target.result);
};

reader.readAsDataURL(input.files[0]);
document.getElementById("hero_image_div").style.display = "block";
}
}


function CoverImage2(input) {
if (input.files && input.files[0]) {
var reader = new FileReader();

reader.onload = function (e) {
 $('#expert_image_div')
     .attr('src', e.target.result);
};

reader.readAsDataURL(input.files[0]);
document.getElementById("expert_image_div").style.display = "block";
}
}



  function updateImageFileName(input) {
    var fileName = input.files[0].name;
    var label = input.nextElementSibling;
    label.innerHTML = fileName;
  }
</script>
<!-- Hide Show Content -->
<!-- 1 -->
<script>
  function showHideDiv(ele) {
    var srcElement = document.getElementById(ele);
    if (srcElement != null) {
      if (srcElement.style.display == "block") {
        srcElement.style.display = "none";
      } else {
        srcElement.style.display = "block";
      }
      return false;
    }
  }
</script>
<!-- 2 -->
<script>
  function showHideDiv1(ele) {
    var srcElement = document.getElementById(ele);
    if (srcElement != null) {
      if (srcElement.style.display == "block") {
        srcElement.style.display = "none";
      } else {
        srcElement.style.display = "block";
      }
      return false;
    }
  }
</script>
<!-- 3 -->
<script>
  function showHideDiv2(ele) {
    var srcElement = document.getElementById(ele);
    if (srcElement != null) {
      if (srcElement.style.display == "block") {
        srcElement.style.display = "none";
      } else {
        srcElement.style.display = "block";
      }
      return false;
    }
  }
</script>
<!-- 4 -->
<script>
  function showHideDiv3(ele) {
    var srcElement = document.getElementById(ele);
    if (srcElement != null) {
      if (srcElement.style.display == "block") {
        srcElement.style.display = "none";
      } else {
        srcElement.style.display = "block";
      }
      return false;
    }
  }
</script>
<!-- 5 -->
<script>
  function showHideDiv4(ele) {
    var srcElement = document.getElementById(ele);
    if (srcElement != null) {
      if (srcElement.style.display == "block") {
        srcElement.style.display = "none";
      } else {
        srcElement.style.display = "block";
      }
      return false;
    }
  }
</script>
<!-- 6 -->
<script>
  function showHideDiv5(ele) {
    var srcElement = document.getElementById(ele);
    if (srcElement != null) {
      if (srcElement.style.display == "block") {
        srcElement.style.display = "none";
      } else {
        srcElement.style.display = "block";
      }
      return false;
    }
  }
</script>
<!-- Upload script start -->
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
  // jQuery(document).ready(function () {
  //   ImgUpload();
  // });

  // function ImgUpload() {
  //   var imgWrap = "";
  //   var imgArray = [];

  //   $(".upload__inputfile").each(function () {
  //     $(this).on("change", function (e) {
  //       imgWrap = $(this).closest(".upload__box").find(".upload__img-wrap");
  //       var maxLength = $(this).attr("data-max_length");

  //       var files = e.target.files;
  //       var filesArr = Array.prototype.slice.call(files);
  //       var iterator = 0;
  //       filesArr.forEach(function (f, index) {
  //         if (!f.type.match("image.*")) {
  //           return;
  //         }

  //         if (imgArray.length > maxLength) {
  //           return false;
  //         } else {
  //           var len = 0;
  //           for (var i = 0; i < imgArray.length; i++) {
  //             if (imgArray[i] !== undefined) {
  //               len++;
  //             }
  //           }
  //           if (len > maxLength) {
  //             return false;
  //           } else {
  //             imgArray.push(f);

  //             var reader = new FileReader();
  //             reader.onload = function (e) {
  //               var html =
  //                 "<div class='upload__img-box'><div style='background-image: url(" +
  //                 e.target.result +
  //                 ")' data-number='" +
  //                 $(".upload__img-close").length +
  //                 "' data-file='" +
  //                 f.name +
  //                 "' class='img-bg'><div class='upload__img-close'></div></div></div>";
  //               imgWrap.append(html);
  //               iterator++;
  //             };
  //             reader.readAsDataURL(f);
  //           }
  //         }
  //       });
  //     });
  //   });

  //   $("body").on("click", ".upload__img-close", function (e) {
  //     var file = $(this).parent().data("file");
  //     for (var i = 0; i < imgArray.length; i++) {
  //       if (imgArray[i].name === file) {
  //         imgArray.splice(i, 1);
  //         break;
  //       }
  //     }
  //     $(this).parent().parent().remove();
  //   });
  // }
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

// Host Features Add Load Delete Script Start======================

$(document).ready(function () {
  
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  
  $.ajax({
    type: "GET",
    url: '/get-host-feature',
    data:{ _token: '{{csrf_token()}}'},
    dataType: 'json',
    success: function (response) {
     
      Features(response);
    },
    
  });

});


function AddFeautre() { 
  var feature = $('#feature').val();
  
  if (feature == '') {
    toastr.options =
    {
      "closeButton" : true,
       "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "10000" // 10 seconds
    }
    toastr.error("Please Add Feature!");
    
    return false;
  }
  
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  
  $.ajax({
    type: "POST",
    url: '/host-feature-add',
    data:{ feature:feature, _token: '{{csrf_token()}}'},
    dataType: 'json',
    success: function (response) {
      $('#feature').val('');
      if (response.response == 'success') {
        toastr.options =
        {
          "closeButton" : true,
           "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "10000" // 10 seconds
        }
        toastr.success(response.message);
      } else {
        
        toastr.options =
        {
          "closeButton" : true,
           "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "10000" // 10 seconds
        }
        toastr.error(response.message);
        
      }
      Features(response);
    },
    
  });
  
}

function removeFeature(Clicked) { 

  var new_id = Clicked.split('_');
  var id = new_id[1];
   
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  
  $.ajax({
    type: "POST",
    url: '/host-feature-delete',
    data:{ id:id, _token: '{{csrf_token()}}'},
    dataType: 'json',
    success: function (response) {
     
      if (response.response == 'success') {
        toastr.options =
        {
          "closeButton" : true,
           "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "10000" // 10 seconds
        }
        toastr.success(response.message);
      } else {
        
        toastr.options =
        {
          "closeButton" : true,
           "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "10000" // 10 seconds
        }
        toastr.error(response.message);
        
      }
      Features(response);
    },
    
  });

  
 }


function Features(response) {

  
  $('#input_fields_write').empty();
  
  var len = 0;
  
          if(response['features'] != null){
             len = response['features'].length;
          }
  if (len > 0 ) {
    
    for (let i = 0; i < len; i++) {
      var id = response['features'][i].id;
      var feature = response['features'][i].feature;
  
     var content_div = `<div class="row" style="display: contents;">
      <div class="col-md-11 remove-input">
        <div class="input-group mb-3" id="input-group-">
          <input type="text" class="form-control form-control-lg" id="upd_feature_${id}"  value="${feature}" placeholder="Feature" aria-label="category Name" aria-describedby="button-addon" /><button class="btn btn-outline-secondary remove-button" type="button" id="button-addon_'+id+'" onclick="removeFeature(this.id);">Remove</button><button
                                  class="btn add-btn add_button"
                                  type="button" 
                                  onclick="UpdatePoints(this.id)" id="upd_feature_btn_${id}" data-id="${id}"
                                >Update</button></div></div></div>`;




$("#input_fields_write").append(content_div);
    }



  }



  }


  
//  Update Feature Host Script Start =======
function UpdatePoints(Clicked) { 

if (!confirm("Are You Sure, You Want to Update ?")){
    return false;
  }

var id = $('#'+Clicked).data('id');
var feature = $('#upd_feature_'+id).val();

 
 

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$.ajax({
  type: "POST",
  url: '/host-feature-update',
  data:{ id:id,feature:feature, _token: '{{csrf_token()}}'},
  dataType: 'json',
  success: function (response) {
 
   
    if (response.response == 'success') {
      toastr.options =
      {
        "closeButton" : true,
         "progressBar": true,
        "timeOut": "10000", // 10 seconds
        "extendedTimeOut": "10000" // 10 seconds
      }
      toastr.success(response.message);
    } else {
      
      toastr.options =
      {
        "closeButton" : true,
         "progressBar": true,
        "timeOut": "10000", // 10 seconds
        "extendedTimeOut": "10000" // 10 seconds
      }
      toastr.error(response.message);
      
    } 
  },
  
});

}
//  Update Feature Host Script End =======


// Host Features Add Load Delete Script END======================

// Key Points Add Load Delete Script Start======================

$(document).ready(function () {
  
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  
  $.ajax({
    type: "GET",
    url: '/get-key-points',
    data:{ _token: '{{csrf_token()}}'},
    dataType: 'json',
    success: function (response) {
     
      Points(response);
    },
    
  });

});


function AddPoints() { 
  var points = $('#points').val();
  
  if (points == '') {
    toastr.options =
    {
      "closeButton" : true,
       "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "10000" // 10 seconds
    }
    toastr.error("Please Add Key Point!");
    
    return false;
  }
  
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  
  $.ajax({
    type: "POST",
    url: '/key-points-add',
    data:{ points:points, _token: '{{csrf_token()}}'},
    dataType: 'json',
    success: function (response) {
      $('#points').val('');
      if (response.response == 'success') {
        toastr.options =
        {
          "closeButton" : true,
           "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "10000" // 10 seconds
        }
        toastr.success(response.message);
      } else {
        
        toastr.options =
        {
          "closeButton" : true,
           "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "10000" // 10 seconds
        }
        toastr.error(response.message);
        
      }
      Points(response);
    },
    
  });
  
}

function removePoints(Clicked) { 

  var new_id = Clicked.split('_');
  var id = new_id[1];
   
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  
  $.ajax({
    type: "POST",
    url: '/key-points-delete',
    data:{ id:id, _token: '{{csrf_token()}}'},
    dataType: 'json',
    success: function (response) {
     
      if (response.response == 'success') {
        toastr.options =
        {
          "closeButton" : true,
           "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "10000" // 10 seconds
        }
        toastr.success(response.message);
      } else {
        
        toastr.options =
        {
          "closeButton" : true,
           "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "10000" // 10 seconds
        }
        toastr.error(response.message);
        
      }
      Points(response);
    },
    
  });

  
 }


function Points(response) {

  
  $('#input_fields_write_points').empty();
  
  var len = 0;
  
          if(response['points'] != null){
             len = response['points'].length;
          }
  if (len > 0 ) {
    
    for (let i = 0; i < len; i++) {
      var id = response['points'][i].id;
      var point = response['points'][i].point;
  
     var content_div = '<div class="row" style="display: contents;"><div class="col-md-11 remove-input"><div class="input-group mb-3" id="input-group-"><input type="text" readonly class="form-control form-control-lg" value="'+point+'" placeholder="Point" aria-label="category Name" aria-describedby="button-point" /><button class="btn btn-outline-secondary remove-button" type="button" id="button-point_'+id+'" onclick="removePoints(this.id);">Remove</button></div></div></div>';




$("#input_fields_write_points").append(content_div);
    }



  }



  }


// Host Features Add Load Delete Script END======================

// document.addEventListener("DOMContentLoaded", function () {
//     var maxField = 10; // Maximum number of input fields
//     var addButton = document.querySelector(".add_button");
//     var wrapper = document.querySelector(".input_fields_wrap");
//     var fieldHTML =
//       '<div class="row" style="display: contents;"><div class="col-md-1"><label class="form-label mt-2">Feature</label></div><div class="col-md-11 remove-input"><div class="input-group mb-3" id="input-group-"><input type="text" class="form-control form-control-lg" name="category_name[]" placeholder="Feature" aria-label="category Name" aria-describedby="button-addon" /><button class="btn btn-outline-secondary remove-button" type="button" id="button-addon" onclick="removeField(this);">Remove</button></div></div></div>';
//     var x = 1;

//     addButton.addEventListener("click", function () {
//       if (x < maxField) {
//         x++;
//         var newField = document.createElement("div");
//         newField.classList.add("row");
//         var labelNumber = x; // Auto-incrementing label number
//         newField.innerHTML = fieldHTML
//           .replace(/Feature/g, "Feature " + labelNumber)
//           .replace(/input-group-/g, "input-group-" + x);
//         wrapper.appendChild(newField);
//       } else {
//         alert("A maximum of " + maxField + " fields are allowed to be added.");
//       }
//     });

//     wrapper.addEventListener("click", function (e) {
//       if (e.target.classList.contains("remove-button")) {
//         e.target.closest(".row").remove();
//         x--;
//       }
//     });
//   });

//   function removeField(element) {
//     element.closest(".row").remove();
//   }
</script>

<!-- ended -->

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
<!-- upload image js -->
<script>
  var hero_image = 'assets/expert/asset/img/<?php echo $expert->hero_image ?>';
  var expert_image = 'assets/expert/asset/img/<?php echo $expert->expert_image ?>';
  var previewImage1 = 'assets/expert/asset/img/<?php echo $expert->host_image_1 ?>';
  var previewImage2 = 'assets/expert/asset/img/<?php echo $expert->host_image_2 ?>';
  var previewImage3 = 'assets/expert/asset/img/<?php echo $expert->host_image_3 ?>';
  var previewImage4 = 'assets/expert/asset/img/<?php echo $expert->host_image_4 ?>';
  
  
   // 2
new Vue({
  el: "#upload-image1",
  data() {
    return {
      preview: hero_image,
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
              if (height != 600 || width != 1440) {
                document.getElementById(id).value = "";
                this.preview = null;
                
                   toastr.options =
                      {
                          "closeButton" : true,
                           "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "10000" // 10 seconds
                      }
                       toastr.error("Cover Image Height 600px and Width 1440px Only Allowed!");
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
      preview: expert_image,
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
              if (height != 419 || width != 378) {
                document.getElementById(id).value = "";
                this.preview = null;
                
                   toastr.options =
                      {
                          "closeButton" : true,
                           "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "10000" // 10 seconds
                      }
                       toastr.error("Image Height 419px and Width 378px Only Allowed!");
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
  
  new Vue({
    el: "#upload-image12",
    data() {
      return {
        preview: previewImage1,
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
              if (height != 400 || width != 400) {
                document.getElementById(id).value = "";
                this.preview = null;
                
                   toastr.options =
                      {
                          "closeButton" : true,
                           "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "10000" // 10 seconds
                      }
                       toastr.error("Host Image Height 400px and Width 400px Only Allowed!");
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
  // 14
  new Vue({
    el: "#upload-image13",
    data() {
      return {
        preview: previewImage2,
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
              if (height != 400 || width != 400) {
                document.getElementById(id).value = "";
                this.preview = null;
                
                   toastr.options =
                      {
                          "closeButton" : true,
                           "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "10000" // 10 seconds
                      }
                       toastr.error("Host Image Height 400px and Width 400px Only Allowed!");
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
  // 15
  new Vue({
    el: "#upload-image14",
    data() {
      return {
        preview: previewImage3,
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
              if (height != 400 || width != 400) {
                document.getElementById(id).value = "";
                this.preview = null;
                
                   toastr.options =
                      {
                          "closeButton" : true,
                           "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "10000" // 10 seconds
                      }
                       toastr.error("Host Image Height 400px and Width 400px Only Allowed!");
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
  // 16
  new Vue({
    el: "#upload-image15",
    data() {
      return {
        preview: previewImage4,
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
              if (height != 400 || width != 400) {
                document.getElementById(id).value = "";
                this.preview = null;
                
                   toastr.options =
                      {
                          "closeButton" : true,
                           "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "10000" // 10 seconds
                      }
                       toastr.error("Host Image Height 400px and Width 400px Only Allowed!");
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

{{-- Script For FAQ's Start --}}
<script>


function ViewFAQS(Clicked) {

 
  
   var button_id = Clicked.split('_');

var id = $('#'+Clicked).data('id');
var status = $('#'+Clicked).data('status');
var question = $('#'+Clicked).data('question');
var answer = $('#'+Clicked).data('answer');
 
  
    
   
   
   
   var html_get = $('#faqs-div-'+id).html();
   var button_html = $('#'+Clicked).html();
   console.log(button_html);
   
   if (button_html != 'View') {
  $('#faqs-div-'+id).empty();
  $('#'+Clicked).html('View');
  return false;
}else{
  $('.faqs_view_btn').html('View');
   $('.all_faqs_div').empty();
  $('#'+Clicked).html('Hide');
 
}

$('#faqs-div-'+id).empty();
 var new_div = '';

   new_div +=  '<form action="/admin-become-expert-faqs-update" method="POST">'+
                 ' @csrf '+ 
                 '<label for="inputEmail4" class="form-label">Question</label>'+
                 '<div class="input-group mb-3 faqs">'+
                 '<input type="hidden" value="'+id+'" name="id" class="form-control" id="id_upd"   />'+
                 '<input type="text" value="'+question+'" name="question" class="form-control" id="question_upd" required placeholder="Become Expert FAQS" />'+
                '</div>'+
                 '<label for="inputEmail4" class="form-label">FAQs Status</label>'+
                  '<div class="input-group mb-3 faqs">'+
                  '  <select class="form-control" name="status" id="status_upd">';
                      if (status == 1) {

                    new_div += '<option value="0" >Hide</option>'+
                          '<option value="1" selected>Show</option>';
                        
                      } else {

                        new_div += '<option value="0" selected >Hide</option>'+
                                   '<option value="1" >Show</option>';
                        
                      }  
                          
                new_div += '</select>'+
                            '</div>'+
                 
                 '<label for="inputEmail4" class="form-label mb-2">Answer</label>'+
                 '<div class="input-group mb-3 faqs">'+
                '<textarea name="answer" id="answer_upd" cols="30" rows="3" placeholder="Faqs Answere...">'+answer+'</textarea>'+
                  '</div>'+
                 '<button class="btn view-button " style="float:right;margin-bottom:10px;" type="button" onClick="UpdateFaqs()"  >Update</button></form>';
    
 $('#faqs-div-'+id).html(new_div);



 }

function UpdateFaqs() { 

  var id = $('#id_upd').val();
  var question = $('#question_upd').val();
  var status = $('#status_upd').val();
  var answer = $('#answer_upd').val();


  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  
  $.ajax({
    type: "POST",
    url: '/admin-become-expert-faqs-update',
    data:{ id:id, question:question, status:status, answer:answer, _token: '{{csrf_token()}}'},
    dataType: 'json',
    success: function (response) {
     
      if (response.success == true) {
        $('.faqs_view_btn').html('View');
      $('.all_faqs_div').empty();
        toastr.options =
        {
          "closeButton" : true,
           "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "10000" // 10 seconds
        }
        toastr.success(response.message);
        FaqsUpdatedShow(response);
      } else {
        
        toastr.options =
        {
          "closeButton" : true,
           "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "10000" // 10 seconds
        }
        toastr.error(response.message);
        
      }
      
    },
    
  });



 }

function FaqsUpdatedShow(response) { 

  var faqs = response.faqs;
 
  
            var len = 0;
            $("#main_faqs_div").empty();
          len = response['faqs'].length;
         
  if (len > 0 ) {
    
    for (let i = 0; i < len; i++) {
      var id = response['faqs'][i].id;
      var question = response['faqs'][i].question;
      var answer = response['faqs'][i].answer;
      var status = response['faqs'][i].status;
  
     var content_div = `<div id="FaqsContainer" class="profile-form">`+
                
                    ` <div class="input-group mb-3 faqs">`+
                      ` <input type="text" type="text" value="`+question+`"`+
                       `  class="form-control"`+
                       `  placeholder="Become Expert FAQS"`+
                       `  aria-label="Recipient's username"`+
                       `  aria-describedby="button-faq`+id+`" readonly /> `+
                      ` <button class="btn view-button faqs_view_btn"`+
                     `    type="button" data-id="`+id+`" data-status="`+status+`" data-question="`+question+`" data-answer="`+answer+`" `+
                     `    id="button-faq`+id+`" onclick="ViewFAQS(this.id)" >View</button></div>`+
                    ` <div id="faqs-div-`+id+`" class="all_faqs_div" style="margin-bottom: 10px;"></div>`+
                    ` </div>`;




$("#main_faqs_div").append(content_div);
    }



  }

 }



</script>
{{-- Script For FAQ's END --}}
