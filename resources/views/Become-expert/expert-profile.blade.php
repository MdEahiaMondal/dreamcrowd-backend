<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags --> 
    <meta charset="UTF-8" />
    <!-- View Point scale to 1.0 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Animate css --> 
    <link rel="stylesheet" href="assets/expert/libs/animate/css/animate.css" />
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="assets/expert/libs/aos/css/aos.css" />
    <!-- Datatable css  -->
    
    {{-- Fav Icon --}}
     @php  $home = \App\Models\HomeDynamic::first(); @endphp
     @if ($home)
         <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
     @endif
     <!-- Select2 css -->
    <link href="assets/expert/libs/select2/css/select2.min.css" rel="stylesheet" />
      <!-- jQuery -->
      <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>

      {{-- =======Toastr CDN ======== --}}
      <link rel="stylesheet" type="text/css" 
      href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
      
      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
      {{-- =======Toastr CDN ======== --}}
    <!-- Owl carousel css -->
    <link href="assets/expert/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
    <link href="assets/expert/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
    <!-- Bootstrap css -->
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/expert/asset/css/bootstrap.min.css"
    />
    <link
      href="assets/expert/asset/css/fontawesome.min.css"
      rel="stylesheet"
      type="text/css"
    />
    <link
    href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"
    rel="stylesheet"
  />
  <link
    rel="stylesheet"
    href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
  />
    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"
    ></script>
    <script
      src="https://kit.fontawesome.com/be69b59144.js"
      crossorigin="anonymous"
    ></script>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.2.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.1/js/bootstrap.min.js"></script> -->
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/expert/asset/css/expert.css" />
    <link rel="stylesheet" href="assets/public-site/asset/css/Drop.css" />
    <link rel="stylesheet" href="assets/expert/asset/css/style.css" />
<link rel="stylesheet" href="assets/public-site/asset/css/navbar.css">

    <title>Become An Expert | Profile</title>
  </head>

  <style>
    .img-fluid{
      height: 150px;
    }
    .tab-pane{
      display: none;
    }
    .tab-pane.show.active{
      display: block;
    }
    .focus-alert {
            position: absolute;
            background-color: #fc5757;
            color: white;
            font-size: 12px;
            padding: 5px 10px;
            border: 1px solid #ca4949;
            border-radius: 5px;
            display: none; /* Initially hidden */
            z-index: 1000;
        }

        .subcategory-list  li {
          font-size: 15px !important;
          margin-bottom: 4px;
        }
    
        .subcategory-list  li input {
          position: relative;
          top: 3px
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
    
     <!-- =========================================== NAVBAR START HERE ================================================= -->
     <x-public-nav/>

  <!-- ============================================= NAVBAR END HERE ============================================ -->
  <div id="focusAlert" class="focus-alert">Click on Next or Back Button!</div>
  <div class="section banner-content">
      <div class="container p-5">
        <div class="row">
          <div class="col-lg-4">
            <ul
              class="nav flex-column nav-pills sticky-lg-top become-an-expert"
              id="side-menu myTab"
              role="tablist"
              aria-orientation="vertical"
            >
              <li class="nav-item" role="presentation">
                <a
                  class="nav-link active" style="cursor: pointer;"
                  id="tab1-tab" data-tab="1"  onclick="GoToTab()" 
                  {{-- data-bs-toggle="pill"
                  href="" --}}
                  role="tab"
                  aria-controls="tab"
                  aria-selected="false"
                  >Manage Profle</a
                >
              </li>
              <li class="nav-item" role="presentation">
                <a
                  class="nav-link" style="cursor: pointer;"
                  id="tab2-tab" data-tab="2"  onclick="GoToTab()" 
                  {{-- data-bs-toggle="pill"
                  href="" --}}
                  role="tab"
                  aria-controls="tab"
                  aria-selected="false"
                  >Select Category</a
                >
              </li>
              <li class="nav-item" role="presentation">
                <a
                  class="nav-link" style="cursor: pointer;"
                  id="tab3-tab" data-tab="3"   onclick="GoToTab()" 
                  {{-- data-bs-toggle="pill"
                  href="" --}}
                  role="tab"
                  aria-controls="tab"
                  aria-selected="false"
                  >Add Experience</a
                >
              </li>
              <li class="nav-item" role="presentation">
                <a
                  class="nav-link" style="cursor: pointer;"
                  id="tab4-tab" data-tab="4"   onclick="GoToTab()" 
                  {{-- data-bs-toggle="pill"
                  href="" --}}
                  role="tab"
                  aria-controls="tab"
                  aria-selected="false"
                  >Languages</a
                >
              </li>
              <li class="nav-item" role="presentation">
                <a
                  class="nav-link" style="cursor: pointer;"
                  id="tab5-tab" data-tab="5"  onclick="GoToTab()" 
                  {{-- data-bs-toggle="pill"
                  href="" --}}
                  role="tab"
                  aria-controls="tab"
                  aria-selected="false"
                  >Service Overview</a
                >
              </li>
              <li class="nav-item" role="presentation">
                <a
                  class="nav-link" style="cursor: pointer;"
                  id="tab6-tab"  data-tab="6"  onclick="GoToTab()" 
                  {{-- data-bs-toggle="pill"
                  href="" --}}
                  role="tab"
                  aria-controls="tab"
                  aria-selected="false"
                  >Add Photos</a
                >
              </li>
              <li class="nav-item" role="presentation">
                <a
                  class="nav-link" style="cursor: pointer;"
                  id="tab7-tab"  data-tab="7"  onclick="GoToTab()" 
                  {{-- data-bs-toggle="pill"
                  href="" --}}
                  role="tab"
                  aria-controls="tab"
                  aria-selected="false"
                  >Verification</a
                >
              </li>
              <li class="nav-item" role="presentation">
                <a
                  class="nav-link" style="cursor: pointer;"
                  id="tab8-tab"  data-tab="8"  onclick="GoToTab()" 
               
                  role="tab"
                  aria-controls="tab"
                  aria-selected="false"
                  >Application Type</a>
              </li>
              <li class="nav-item" role="presentation">
                <a
                  class="nav-link" style="cursor: pointer;"
                  id="tab9-tab"  data-tab="9"  onclick="GoToTab()" 
                  {{-- data-bs-toggle="pill"
                  href="" --}}
                  role="tab"
                  aria-controls="tab"
                  aria-selected="false"
                  >Summary</a
                >
              </li>
            </ul>
          </div>
          <div class="col-lg-8">
            <div class="tab-content" id="side-menu-tabContent">
              <div
                class="tab-pane show active"
                id="tab1"
                role="tabpanel"
                aria-labelledby="tab1-tab"
              >
                <div class="row">
                  <div class="col-lg-12">
                    <div class="top-head">
                      <h1>Manage Profile</h1>
                    </div>
                    <!-- =================================================== -->
                    <div class="row">
                      <div class="col-md-12">
                        <div class="main-tab-sec">
                          <div class="row">
                            <div class="col-md-2">
                              <div class="avatar-upload">
                                {{-- <div class="avatar-edit">
                                  <input
                                    type="file"
                                    id="imageUpload"
                                    accept=".png, .jpg, .jpeg"
                                  />
                                  <label for="imageUpload"></label>
                                </div> --}}
                                <div class="avatar-preview">
                                  <div
                                    id="imagePreview"
                                    style="
                                      background-image: url(http://i.pravatar.cc/500?img=7);
                                      width: 100%;
                                    "
                                  ></div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-10">
                              <div class="">
                                <label
                                  class="form-label" for="imageUpload"
                                  style="margin-top: 0px !important"
                                  >Profile Photo <span>*</span></label
                                >
                                <input
                                  class="form-control d-block"
                                  type="file" accept="image/*"
                                  id="imageUpload"
                                />
                              </div>
                            </div>
                          </div>

                          <!--  -->
                          <div class="row">
                            <div class="col-md-6">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  >First Name <span>*</span></label
                                >
                                <input
                                  type="text"  value="{{Auth::user()->first_name}}"
                                  class="form-control"
                                  id="first_name"
                                  placeholder="eg. Usama"
                                />
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  >Last Name <span>*</span></label
                                >
                                <input
                                  type="text" value="{{Auth::user()->last_name}}"
                                  class="form-control"
                                  id="last_name"
                                  placeholder="eg. Aslam"
                                />
                              </div>
                            </div>

                            <div class="col-md-12">
                              <label class="form-label"
                                >Gender <span>*</span></label
                              >
                              <select
                                class="form-select"
                                aria-label="Default select example" id="gender"
                              >
                                <option selected  disabled>-- select Gender --</option>
                                <option  value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                              </select>
                            </div>

                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  >Your Profession <span>*</span></label
                                >
                                <p>
                                  For Example : “Fitness Trainer” , “Designer” ,
                                  “Videographer” , etc. The profession should be
                                  related to the experience you will be
                                  providing on DreamCrowd
                                </p>
                                <input
                                  type="text"
                                  class="form-control"
                                  id="profession"
                                  placeholder="eg. Graphic Designer"
                                />
                              </div>
                            </div>
                            <div class="col-md-12">
                              <label class="form-label"
                                >What form of service do you wish to provide? <span>*</span></label
                              >
                              <select
                                class="form-select"
                                aria-label="Default select example" id="service_role"
                              >
                                <option  disabled>-- select Service --</option>
                                <option selected value="Class">Class Service</option>
                                <option value="Freelance">Freelance Service</option>
                                <option value="Both">Both</option>
                              </select>
                            </div>

                            <div class="col-md-12">
                              <label class="form-label"
                                >How would it be delivered to buyers<span>*</span></label
                              >
                              <select
                                class="form-select"
                                aria-label="Default select example" id="service_type"
                              >
                                <option  disabled>-- select Service --</option>
                                <option selected value="Online">Online</option>
                                <option value="Inperson">In-person</option>
                                <option value="Both">Both</option>
                              </select>
                            </div>

                            <div class="col-md-12">
                              <label class="form-label"
                                >Country <span>*</span></label
                              >
                              <input type="text" id="country" value="{{Auth::user()->country}}" placeholder="Country" readonly class="form-control">
                            </div>

                            <div class="col-md-12">
                              <label class="form-label"
                                >Street Address <span>*</span></label
                              >
                              <div class="input-group">
                                <span class="input-group-text" id="location-icon">
                                  <i class="fas fa-thumbtack " title="Get Live Location" style="color: var(--Colors-Logo-Color, #0072b1); cursor: pointer;"></i>
                                </span>
                                <input type="text" id="street_address" value="" placeholder="Street Address" autocomplete="off" class="form-control">
                              </div>
                              <input type="hidden" id="ip_address" value="" placeholder="" readonly class="form-control">
                              <input type="hidden" id="country_code" value="{{Auth::user()->country}}" placeholder="" readonly class="form-control">
                              <input type="hidden" id="latitude" value="" placeholder="" readonly class="form-control">
                              <input type="hidden" id="longitude" value="" placeholder="" readonly class="form-control">
                            </div>
                            
                          
                            <div class="col-md-6">
                              {{-- <label class="form-label"
                                >City <span>*</span></label
                              > --}}
                              <input type="hidden" id="city" value="" placeholder="City" readonly class="form-control">
                           
                              {{-- <select class="form-select selectpiker" onchange="SelectCity(this.id)"
                              aria-label="Default select example" id="city"
                            >
                              <option value="" selected disabled>-- select Service --</option> 
                            </select> --}}
                           
                             </div>
                            <div class="col-md-6">
                              <div class="">
                                {{-- <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  >Zip Code/Post Code <span>*</span><i class="bx bx-info-circle icon" title="Messages"></i></box-icon></span></label
                                > --}}
                                <input type="hidden" id="zip_code" value="" placeholder="Zip Code" readonly class="form-control">
                           
                                {{-- <select class="form-select selectpiker"  
                                aria-label="Default select example" id="zip_code"
                              >
                                <option value="" selected disabled>-- select Zip Code --</option> 
                              </select> --}}
                               
                            </div>
                            </div>
                          </div>
                        </div>
                        <!-- =========== BUTTONS SECTION ============  -->
                        <div class="row">
                          <div class="col-md-12">
                            <div class="buttons-sec">
                              <button type="button" class="btn btn-back "  >
                                Back
                              </button>
                              <button type="button" onclick="getServiceDetail(this.id)" data-tab="1" id="tab_btn_1"  class="btn btn-next">
                                Next
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div
                class="tab-pane fade"
                id="tab2"
                role="tabpanel"
                aria-labelledby="tab2-tab"
              >
                <div class="row" id="class_main_div">
                  <div class="col-lg-12">
                    <div class="top-head">
                      <h1>Select Category (Class Service)</h1>
                    </div>
                    <!-- =================================================== -->
                    <div class="row">
                      <div class="col-md-12">
                        <div class="main-tab-sec">
                          <!--  -->
                          <div class="row">
                            <div class="col-md-12">
                              <label
                                for="exampleFormControlInput1"
                                class="form-label"
                                style="margin-top: 0px !important"
                                >Category <span>*</span></label
                              >
                              <p>
                                Select Up to five Categories that mostly sums up
                                the experience you are providing. Please be
                                aware that it is difficult to be approved under
                                the following experience: Politics, Religion and
                                Gambling
                              </p>
                              <p class="text-danger" id="class_error" style="display: none;"></p>
                                <input type="hidden" id="ClassCateIds" >
                              <div class="dropdown">
                                <button
                                  class="btn dropdown-toggle form-select"
                                  type="button" 
                                  id="multiSelectDropdown"
                                  data-bs-toggle="dropdown"
                                  aria-expanded="false" onclick="SelectClassCategory()"
                                  style="text-align: left; overflow: hidden"
                                >--select category--</button>
                                <ul style="max-height: 200px; overflow-y: auto;"
                                  class="dropdown-menu multi-drop-select mt-2"
                                  aria-labelledby="multiSelectDropdown"
                                >
                                  <div class="row" id="ClassCategories">
                                    
                                      <div class="col-md-6" id="class_online_main_col" style="border-right: 3px solid rgb(0, 114, 177, 0.6);">
                                        <h4 class="form-label">Online</h4>
                                        <div class="row OnlineClass" id="classOnlineContainer" >
                                          {{-- <div class="col-md-6">
                                            <li class="multi-text-li">
                                              <label> <input type="checkbox"  value="Website Development (Online)"  class="cat-input" />  Website Development </label>
                                            </li>
                                          </div> --}}
                                        </div>
                                      </div>
                                    
                                    

                                      <div class="col-md-6" id="class_inperson_main_col">
                                        <h4 class="form-label">Inperson</h4>
                                        <div class="row InpersonClass" id="classInpersonContainer" >
                                          {{-- <div class="col-md-6">
                                            <li class="multi-text-li">
                                              <label> <input type="checkbox"  value="Website Development (Online)"  class="cat-input" />  Website Development </label>
                                            </li>
                                          </div> --}}
                                        </div>
                                      </div>
                                    
                                    
                                  </div>
                                </ul>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <label class="form-label"
                                >Sub Category <span>*</span></label
                              >
                              <input type="hidden" id="cls_sub_val" width="100">
                              <p class="text-danger" id="sub_class_error" style="display: none;"></p>
                                <div class="dropdown">
                                <button
                                  class="btn dropdown-toggle form-select"
                                  type="button"
                                  id="multiSelectDropdown1"
                                  data-bs-toggle="dropdown"
                                  aria-expanded="false"  onclick="SelectClassCategorySub()"
                                  style="text-align: left; overflow: hidden"
                                >--select sub-category--</button>
                                <ul  style="max-height: 200px; overflow-y: auto;"
                                  class="dropdown-menu multi-drop-select mt-2"
                                  aria-labelledby="multiSelectDropdown1"
                                >
                                  <div class="row" id="ClassSubCategories">

                                    <div class="col-md-6" id="sub_class_online_main_col"  style="border-right: 3px solid rgb(0, 114, 177, 0.6);">
                                      <h4 class="form-label">Online</h4>
                                      <div class="row SubOnlineClass" id="SubOnlineClass" >
                                        {{-- <div class="col-md-6">
                                          <li class="multi-text-li">
                                            <label> <input type="checkbox"  value="Website Development (Online)"  class="cat-input" />  Website Development </label>
                                          </li>
                                        </div> --}}
                                      </div>
                                    </div>
                                  
                                  

                                    <div class="col-md-6" id="sub_class_inperson_main_col">
                                      <h4 class="form-label">Inperson</h4>
                                      <div class="row " id="SubInpersonClass" >
                                        {{-- <div class="col-md-6">
                                          <li class="multi-text-li">
                                            <label> <input type="checkbox"  value="Website Development (Online)"  class="cat-input" />  Website Development </label>
                                          </li>
                                        </div> --}}
                                      </div>
                                    </div>
                                    
                                    {{-- <div class="col-md-3">
                                      <li class="multi-text-li">
                                        <label>
                                          <input
                                            type="checkbox"
                                            value="Website Development"
                                            class="subcat-input"
                                          />
                                          Website Development
                                        </label>
                                      </li> 
                                    </div> --}}
                                
                                  </div>
                                </ul>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  >Positive Search Terms <span>*</span></label
                                >
                                <p>
                                  Select Up to five Categories that mostly sums
                                  up the experience you are providing. Please be
                                  aware that it is difficult to be approved
                                  under the following experience: Politics,
                                  Religion and Gambling
                                </p>
                                <input
                                type="text"
                                class="form-control"
                                id="input_class_term"
                                placeholder="Type and press Enter or comma......"
                                />
                                <input type="hidden" id="class_term">
                                <div id="class_term_div" style="display: flex;gap: 10px;"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- ========================================== -->
                <div class="row" id="freelance_main_div">
                  <div class="col-lg-12">
                    <div class="top-head">
                      <h1>Select Category (Freelance Service)</h1>
                    </div>
                    <!-- =================================================== -->
                    <div class="row">
                      <div class="col-md-12">
                        <div class="main-tab-sec">
                          <!--  -->
                          <div class="row">
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  style="margin-top: 0px !important"
                                  >Category <span>*</span></label
                                >
                                <p>
                                  Select Up to five Categories that mostly sums
                                  up the experience you are providing. Please be
                                  aware that it is difficult to be approved
                                  under the following experience: Politics,
                                  Religion and Gambling
                                 </p>
                                <p class="text-danger" id="freelance_error" style="display: none;"></p>
                                <input type="hidden" id="FreelanceCateIds" >
                                <div class="dropdown">
                                  <button
                                    class="btn dropdown-toggle form-select"
                                    type="button"
                                    id="multiSelectDropdown2"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"  onclick="SelectFreelanceCategory()"
                                    style="text-align: left; overflow: hidden"
                                  >--select category--</button>
                                  <ul  style="max-height: 200px; overflow-y: auto;"
                                    class="dropdown-menu multi-drop-select mt-2"
                                    aria-labelledby="multiSelectDropdown2"
                                  >
                                    <div class="row" id="FreelanceCategories">
                                      
                                      <div class="col-md-6" id="freelance_online_main_col"  style="border-right: 3px solid rgb(0, 114, 177, 0.6);">
                                        <h4 class="form-label">Online</h4>
                                        <div class="row OnlineFreelance" id="freelanceOnlineContainer" >
                                          {{-- <div class="col-md-6">
                                            <li class="multi-text-li">
                                              <label> <input type="checkbox"  value="Website Development (Online)"  class="cat-input" />  Website Development </label>
                                            </li>
                                          </div> --}}
                                        </div>
                                      </div>
                                    
                                    

                                      <div class="col-md-6" id="freelance_inperson_main_col">
                                        <h4 class="form-label">Inperson</h4>
                                        <div class="row InpersonFreelance" id="freelanceInpersonContainer" >
                                          {{-- <div class="col-md-6">
                                            <li class="multi-text-li">
                                              <label> <input type="checkbox"  value="Website Development (Online)"  class="cat-input" />  Website Development </label>
                                            </li>
                                          </div> --}}
                                        </div>
                                      </div>

                                      {{-- <div class="col-md-3">
                                        <li class="multi-text-li">
                                          <label>
                                            <input
                                              type="checkbox"
                                              value="Website Development"
                                              class="cat1-input"
                                            />
                                            Website Development
                                          </label>
                                        </li>
                                      </div> --}}

                                    </div>
                                  </ul>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <label class="form-label"
                                >Sub Category <span>*</span></label
                              >
                              <input type="hidden" id="fls_sub_val" width="100">
                              
                              <p class="text-danger" id="sub_freelance_error" style="display: none;"></p>
                                
                              <div class="dropdown">
                                <button
                                  class="btn dropdown-toggle form-select"
                                  type="button"
                                  id="multiSelectDropdown3"
                                  data-bs-toggle="dropdown"
                                  aria-expanded="false" onclick="SelectFreelanceCategorySub()"
                                  style="text-align: left; overflow: hidden"
                                >--select sub-category--</button>
                                <ul  style="max-height: 200px; overflow-y: auto;"
                                  class="dropdown-menu multi-drop-select mt-2"
                                  aria-labelledby="multiSelectDropdown3"
                                >
                                  <div class="row" id="FreelanceSubCategories">
                                    
                                    
                                    <div class="col-md-6" id="sub_freelance_online_main_col"  style="border-right: 3px solid rgb(0, 114, 177, 0.6);">
                                      <h4 class="form-label">Online</h4>
                                      <div class="row SubOnlineFreelance" id="SubOnlineFreelance" >
                                        {{-- <div class="col-md-6">
                                          <li class="multi-text-li">
                                            <label> <input type="checkbox"  value="Website Development (Online)"  class="cat-input" />  Website Development </label>
                                          </li>
                                        </div> --}}
                                      </div>
                                    </div>
                                  
                                  

                                    <div class="col-md-6" id="sub_freelance_inperson_main_col">
                                      <h4 class="form-label">Inperson</h4>
                                      <div class="row SubInpersonFreelance" id="SubInpersonFreelance">
                                        {{-- <div class="col-md-6">
                                          <li class="multi-text-li">
                                            <label> <input type="checkbox"  value="Website Development (Online)"  class="cat-input" />  Website Development </label>
                                          </li>
                                        </div> --}}
                                      </div>
                                    </div>

                                    {{-- <div class="col-md-3">
                                      <li class="multi-text-li">
                                        <label>
                                          <input
                                            type="checkbox"
                                            value="Website Development"
                                            class="subcat1-input"
                                          />
                                          Website Development
                                        </label>
                                      </li>
                                    </div> --}}

                                  </div>
                                </ul>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  >Positive Search Terms <span>*</span></label
                                >
                                <p>
                                  Select Up to five Categories that mostly sums
                                  up the experience you are providing. Please be
                                  aware that it is difficult to be approved
                                  under the following experience: Politics,
                                  Religion and Gambling
                                </p>
                                <input
                                  type="text"
                                  class="form-control"
                                  id="input_freelance_term"
                                  placeholder="Type and press Enter or comma......"
                                />

                                <input type="hidden" id="freelance_term">
                                <div id="freelance_term_div" style="display: flex;gap: 10px;"></div>
                              

                              </div>
                            </div>
                          </div>
                        </div>
                        
                      </div>
                    </div>
                  </div>
                </div>
                <!-- =========== BUTTONS SECTION ============  -->
                <div class="row">
                  <div class="col-md-12">
                    <div class="buttons-sec">
                      <button type="button" class="btn btn-back "   onclick="BackTab(this.id)"  data-tab="2" id="tab_back_btn_2" >
                        Back
                      </button>
                      <button type="button" onclick="getServiceDetail(this.id)" data-tab="2" id="tab_btn_2" class="btn btn-next">
                        Next
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <div
                class="tab-pane fade"
                id="tab3"
                role="tabpanel"
                aria-labelledby="tab3-tab"
              >
                <div class="row">
                  <div class="col-lg-12">
                    <div class="top-head">
                      <h1>Add Experience</h1>
                    </div>
                    <!-- =================================================== -->
                    <div class="row">
                      <div class="col-md-12">
                        <div class="main-tab-sec">
                          <!--  -->
                          <div class="row">
                           <div id="Experience_main_div">
                            <div class="col-md-12">
                              <label class="form-label"
                                >How many years of experience do you have in
                                Graphic Design? <span>*</span></label>
                              <select class="form-select" id="graphic_experience"
                                aria-label="Default select example" >
                                <option selected>--select option--</option>
                                 @for ($i = 0; $i <= 30; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                                @endfor
                              </select>
                            </div>

                            <div class="col-md-12">
                              <label class="form-label"
                                >How many years of experience do you have in Web
                                Development? <span>*</span></label>
                              <select
                                class="form-select" id="web_experience"
                                aria-label="Default select example"
                              >
                                <option selected>--select option--</option>
                                @for ($i = 0; $i <= 30; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                                @endfor
                              </select>
                            </div>
                           </div>
                           
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  >Add Portfolio <span>*</span></label
                                >
                                <p>
                                  Please provide a link to a website where we
                                  can find some or all your portfolio samples.Or
                                  you could provide a link to a website (Such as
                                  LinkedIn or a service website) where we can
                                  see some evidence of your work experience
                                </p>
                                <select
                                class="form-select" id="portfolio"
                                aria-label="Default select example"
                              >
                                <option value="web_link" selected>I have a web link</option>
                                {{-- <option value="network_link" >I have a professional network link</option> --}}
                                <option value="not_link" >I don't have any link</option>
                                 
                              </select> 
                              <input type="hidden" id="portfolio_url">
                                {{-- <div class="form-check">
                                  <input
                                    class="form-check-input"
                                    type="radio" value="web_link"
                                    name="toggle"
                                    id="radio1"
                                    checked
                                  />
                                  <label
                                    class="form-check-label"
                                    for="radio1"
                                  >
                                    I have a web link
                                  </label>
                                </div>
                                <div class="form-check">
                                  <input
                                    class="form-check-input"
                                    type="radio" value="network_link"
                                    name="toggle" 
                                    id="radio2"
                                  />
                                  <label
                                    class="form-check-label"
                                    for="radio2"
                                  >
                                    I have a professional network link
                                  </label>
                                </div>
                                <div class="form-check">
                                  <input
                                    class="form-check-input"
                                    type="radio"
                                    name="toggle" value=""
                                    id="radio3"
                                  />
                                  <label
                                    class="form-check-label"
                                    for="radio3"
                                  >
                                  I don't have any link
                                  </label>
                                </div>     --}}
                              </div>
                            </div>
                            <div class="main" id="portfolio_url_div">
                              {{-- <div class="col-md-12 field_wrapper date-time" id="imageDiv">
                                <label class="form-label">URL <span>*</span></label>
                                <div class="d-flex">
                                 
                                  <input class="add-input form-control"
                                    type="text"
                                    name="field_name[]"
                                    value="" id="url"
                                    placeholder="https://bravemindstudio.com/" />
                                  <a  href="javascript:void(0);"
                                    class="ad_button"  onclick="AddPortfolioUrl()"
                                    title="Add field" >
                                    <img src="assets/expert/asset/img/add-input.svg" />
                                  </a>
                                </div>
                                <div id="portfolio_all_links"></div>
                              </div> --}}
                            </div>
                          </div>
                        </div>
                        <!-- =========== BUTTONS SECTION ============  -->
                        <div class="row">
                          <div class="col-md-12">
                            <div class="buttons-sec">
                              <button type="button" class="btn btn-back"  onclick="BackTab(this.id)"  data-tab="3" id="tab_back_btn_3">
                                Back
                              </button>
                              <button type="button" onclick="getServiceDetail(this.id)" data-tab="3" id="tab_btn_3" class="btn btn-next">
                                Next
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div
                class="tab-pane fade"
                id="tab4"
                role="tabpanel"
                aria-labelledby="tab4-tab"
              >
                <div class="row">
                  <div class="col-lg-12">
                    <div class="top-head">
                      <h1>Language & Service Overview</h1>
                    </div>
                    <!-- =================================================== -->
                    <div class="row">
                      <div class="col-md-12">
                        <div class="main-tab-sec">
                          <!--  -->
                          <div class="row">
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  style="margin-top: 0px !important"
                                  >Whats your primary language?
                                  <span>*</span></label
                                >
                                <p>
                                  You should be able read, write and speak this
                                  language fluently.
                                </p>
                                <select
                                  class="form-select" id="primary_language"
                                  aria-label="Default select example"
                                >
                                  <option disabled selected value="">-- select option --</option>
                                  <option value="English">English</option>
                                  @php
                                  $language = \App\Models\Languages::all();
                                  @endphp
                                  @if ($language)
                                  @php $i = 0 @endphp
                                  @foreach ($language as $item)
                                  
                                    <option value="{{$item->language}}">{{$item->language}}</option>
                                
                                  @php $i++ @endphp 
                                  @endforeach
                                      
                                  @endif
                                  
                                </select>
                              </div>
                            </div>
                            <div class="col-md-12" id="fluent_main_div">
                              <label class="form-label"
                                >Are you fluent in English?</label
                              >
                              <p>
                                This should be language you are comfortable at
                                hosting in.
                              </p>
                              <select
                                class="form-select" id="english_language"
                                aria-label="Default select example"
                              >
                                <option disabled selected value="">--select option--</option>
                                <option  value="Yes">Yes</option>
                                <option value="No">No</option>
                              </select>
                            </div>

                            <div class="col-md-12">
                              <label class="form-label"
                                >Do you speak other languages fluently?</label
                              >
                              <div class="form-check form-switch col-md-12">
                                <input class="form-check-input" type="checkbox" role="switch" id="speak_other_language"  > 
                              </div>
                            </div>
                            
                               

                            <div class="col-md-12" id="other_language_main_div" style="display: none;">
                              <label class="form-label"
                                >What other languages do you speak
                                fluently? <span>*</span></label
                              > 
                              <p>
                                This should be language you are comfortable at
                                hosting in.
                              </p>
                              <div class="dropdown">
                                <button
                                  class="btn dropdown-toggle form-select"
                                  type="button"
                                  id="multiSelectDropdown4"
                                  data-bs-toggle="dropdown"
                                  aria-expanded="false" onclick="SelectLanguages()"
                                  style="text-align: left; overflow: hidden"
                                >--select Language--</button>
                                <ul
                                  class="dropdown-menu multi-drop-select mt-2"
                                  aria-labelledby="multiSelectDropdown4"
                                >
                                  <div class="row" id="SelectLanguages">
                                    @php
                                  $language = \App\Models\Languages::all();
                                  @endphp
                                  @if ($language)
                                  @foreach ($language as $item)
                                  <div class="col-md-3">
                                    <li class="multi-text-li">
                                      <label>
                                        <input
                                          type="checkbox"
                                          value="{{$item->language}}"
                                          class="language-input"
                                        />{{$item->language}}</label>
                                    </li>
                                  </div>
                                  @endforeach
                                      
                                  @endif
                                    

                                  </div>
                                </ul>
                              </div>
                            </div>
                            
                            {{-- <div class="col-md-12">
                              <label class="form-label"
                                >What other languages do you speak
                                fluently?</label
                              >
                              <p>
                                This should be language you are comfortable at
                                hosting in.
                              </p>
                              <select
                                class="form-select"
                                aria-label="Default select example"
                              >
                                <option selected>--select option--</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                              </select>
                            </div> --}}
                          </div>
                        </div>
                        <!-- =========== BUTTONS SECTION ============  -->
                        <div class="row">
                          <div class="col-md-12">
                            <div class="buttons-sec">
                              <button type="button" class="btn btn-back"  onclick="BackTab(this.id)"  data-tab="4" id="tab_back_btn_4">
                                Back
                              </button>
                              <button type="button"  onclick="getServiceDetail(this.id)" data-tab="4" id="tab_btn_4" class="btn btn-next">
                                Next
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div
                class="tab-pane fade"
                id="tab5"
                role="tabpanel"
                aria-labelledby="tab5-tab"
              >
                <div class="row">
                  <div class="col-lg-12">
                    <div class="top-head">
                      <h1>Language & Service Overview</h1>
                    </div>
                    <!-- =================================================== -->
                    <div class="row">
                      <div class="col-md-12">
                        <div class="main-tab-sec">
                          <!--  -->
                          <div class="row">
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  style="margin-top: 0px !important"
                                  >Overview <span>*</span></label
                                >
                                <p>
                                  Tell your guest about you and give a summary
                                  of all classes and activities you intend to
                                  provide. Remember that this section is a
                                  chance to convince guests to book your classes
                                  and activities. You should take your time to
                                  make it friendly and interesting. We have
                                  provided some suggestions for you below. You
                                  could use some or all suggestions.
                                  Suggestions: Start with a friendly
                                  introduction Give a brief description of your
                                  classes/activities (the online experience you
                                  are providing) and what differentiates it from
                                  experiences provided by other hosts in
                                  relative fields. Discuss what skill levels are
                                  required to book your experience. Summarise
                                  how you plan to engage with your guest during
                                  each experience Give a nice conclusion.
                                </p>
                                <textarea
                                  class="form-control"
                                  id="overview"
                                  rows="6" 
                                  placeholder="write your experience heading....."
                                ></textarea>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  >About Me <span>*</span></label
                                >
                                <p>
                                  Talk about your credential and other things
                                  that makes you qualified to host the
                                  experience.
                                </p>
                                <textarea
                                  class="form-control"
                                  id="about_me"
                                  rows="6"
                                  placeholder="write your experience heading....."
                                ></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- =========== BUTTONS SECTION ============  -->
                        <div class="row">
                          <div class="col-md-12">
                            <div class="buttons-sec">
                              <button type="button" class="btn btn-back"  onclick="BackTab(this.id)"  data-tab="5" id="tab_back_btn_5">
                                Back
                              </button>
                              <button type="button" onclick="getServiceDetail(this.id)" data-tab="5" id="tab_btn_5" class="btn btn-next">
                                Next
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div
                class="tab-pane fade"
                id="tab6"
                role="tabpanel"
                aria-labelledby="tab6-tab"
              >
                <div class="row">
                  <div class="col-lg-12">
                    <div class="top-head">
                      <h1>Add Photos</h1>
                    </div>
                    <!-- =================================================== -->
                    <div class="row">
                      <div class="col-md-12">
                        <div class="main-tab-sec">
                          <!--  -->
                          <div class="row">
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  style="margin-top: 0px !important"
                                  >Main Image <span>*</span></label
                                >
                                <p>
                                  Upload a photo of you raising your thumb up
                                  while facing the camera.
                                  <a href="#">see example</a>
                                </p>
                                <h6>Our Requirements for all Photo</h6>
                                <ul style="padding-left: 0px">
                                  <li>
                                    1. Photo must be of a great quality and in
                                    colour.
                                  </li>
                                  <li>
                                    2. It must accurately describe your
                                    experience
                                  </li>
                                  <li>
                                    3. It must belong to you, do not infringe
                                    copyright work.
                                  </li>
                                  <li>
                                    4. Business logos are not allowed on photos.
                                  </li>
                                  <li>5. Selfie photos are no allowed</li>
                                </ul>
                              </div>
                            </div>
                            <div class="col-md-4 identity" id="upload-image" style="margin-bottom: 10px;">
                              <div class="input-file-wrapper transition-linear-3 position-relative">
                                <span
                                  class="remove-img-btn position-absolute" style="cursor: pointer;background: #ed5646;color: white !important;border-radius: 5px;z-index: 10;padding: 4px 8px !important;"
                                  @click="reset('post-thumbnail')"
                                  v-if="preview!==null"
                                >
                                  Remove
                                </span>
                                <label
                                  class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                  for="post-thumbnail" style="background: #f4fbff;border-radius: 4px;cursor: pointer;"
                                >
                                  <span v-show="preview===null">
                                    <i class="fa-solid fa-cloud-arrow-up pt-3" style="color: #ababab;"></i>
                                    <span class="d-block" style="color: #0072b1;">Upload Image</span>
                                    <p>Drag and drop files here</p>
                                  </span>
                                  <template v-if="preview">
                                    <img :src="preview" class="img-fluid mt-2" />
                                  </template>
                                </label>
                                <input
                                  type="file"   name="site_logo"
                                  accept="image/*" value=""
                                  @change="previewImage('post-thumbnail')"
                                  class="input-file"
                                  id="post-thumbnail"
                                />
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  style="margin-top: 0px !important"
                                  >More Images</label
                                >
                                <p>
                                  Upload a photo of you raising your thumb up
                                  while facing the camera.
                                  <a href="#">see example</a>
                                </p>
                                <h6>Our Requirements for all Photo</h6>
                                <ul style="padding-left: 0px">
                                  <li>
                                    1. Photo must be of a great quality and in
                                    colour.
                                  </li>
                                  <li>
                                    2. It must accurately describe your
                                    experience
                                  </li>
                                  <li>
                                    3. It must belong to you, do not infringe
                                    copyright work.
                                  </li>
                                  <li>
                                    4. Business logos are not allowed on photos.
                                  </li>
                                  <li>5. Selfie photos are no allowed</li>
                                </ul>
                              </div>
                            </div>
                            
                              <div class="col-md-4 identity" id="upload-image1" style="margin-bottom: 10px;">
                                <div class="input-file-wrapper transition-linear-3 position-relative">
                                  <span
                                    class="remove-img-btn position-absolute" style="cursor: pointer;background: #ed5646;color: white !important;border-radius: 5px;z-index: 10;padding: 4px 8px !important;"
                                    @click="reset('post-thumbnail1')"
                                    v-if="preview!==null"
                                  >
                                    Remove
                                  </span>
                                  <label
                                    class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                    for="post-thumbnail1" style="background: #f4fbff;border-radius: 4px;cursor: pointer;"
                                  >
                                    <span v-show="preview===null">
                                      <i class="fa-solid fa-cloud-arrow-up pt-3" style="color: #ababab;"></i>
                                      <span class="d-block" style="color: #0072b1;">Upload Image</span>
                                      <p>Drag and drop files here</p>
                                    </span>
                                    <template v-if="preview">
                                      <img :src="preview" class="img-fluid mt-2" />
                                    </template>
                                  </label>
                                  <input
                                    type="file"   name="site_logo"
                                    accept="image/*" value=""
                                    @change="previewImage('post-thumbnail1')"
                                    class="input-file"
                                    id="post-thumbnail1"
                                  />
                                </div>
                              </div>
                           
                              <div class="col-md-4 identity" id="upload-image2" style="margin-bottom: 10px;">
                                <div class="input-file-wrapper transition-linear-3 position-relative">
                                  <span
                                    class="remove-img-btn position-absolute" style="cursor: pointer;background: #ed5646;color: white !important;border-radius: 5px;z-index: 10;padding: 4px 8px !important;"
                                    @click="reset('post-thumbnail2')"
                                    v-if="preview!==null"
                                  >
                                    Remove
                                  </span>
                                  <label
                                    class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                    for="post-thumbnail2" style="background: #f4fbff;border-radius: 4px;cursor: pointer;"
                                  >
                                    <span v-show="preview===null">
                                      <i class="fa-solid fa-cloud-arrow-up pt-3" style="color: #ababab;"></i>
                                      <span class="d-block" style="color: #0072b1;">Upload Image</span>
                                      <p>Drag and drop files here</p>
                                    </span>
                                    <template v-if="preview">
                                      <img :src="preview" class="img-fluid mt-2" />
                                    </template>
                                  </label>
                                  <input
                                    type="file"   name="site_logo"
                                    accept="image/*" value=""
                                    @change="previewImage('post-thumbnail2')"
                                    class="input-file"
                                    id="post-thumbnail2"
                                  />
                                </div>
                              </div>
                              <div class="col-md-4 identity" id="upload-image3" style="margin-bottom: 10px;">
                                <div class="input-file-wrapper transition-linear-3 position-relative">
                                  <span
                                    class="remove-img-btn position-absolute" style="cursor: pointer;background: #ed5646;color: white !important;border-radius: 5px;z-index: 10;padding: 4px 8px !important;"
                                    @click="reset('post-thumbnail3')"
                                    v-if="preview!==null"
                                  >
                                    Remove
                                  </span>
                                  <label
                                    class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                    for="post-thumbnail3" style="background: #f4fbff;border-radius: 4px;cursor: pointer;"
                                  >
                                    <span v-show="preview===null">
                                      <i class="fa-solid fa-cloud-arrow-up pt-3" style="color: #ababab;"></i>
                                      <span class="d-block" style="color: #0072b1;">Upload Image</span>
                                      <p>Drag and drop files here</p>
                                    </span>
                                    <template v-if="preview">
                                      <img :src="preview" class="img-fluid mt-2" />
                                    </template>
                                  </label>
                                  <input
                                    type="file"   name="site_logo"
                                    accept="image/*" value=""
                                    @change="previewImage('post-thumbnail3')"
                                    class="input-file"
                                    id="post-thumbnail3"
                                  />
                                </div>
                              </div>
                              <div class="col-md-4 identity" id="upload-image4" style="margin-bottom: 10px;">
                                <div class="input-file-wrapper transition-linear-3 position-relative">
                                  <span
                                    class="remove-img-btn position-absolute" style="cursor: pointer;background: #ed5646;color: white !important;border-radius: 5px;z-index: 10;padding: 4px 8px !important;"
                                    @click="reset('post-thumbnail4')"
                                    v-if="preview!==null"
                                  >
                                    Remove
                                  </span>
                                  <label
                                    class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                    for="post-thumbnail4" style="background: #f4fbff;border-radius: 4px;cursor: pointer;"
                                  >
                                    <span v-show="preview===null">
                                      <i class="fa-solid fa-cloud-arrow-up pt-3" style="color: #ababab;"></i>
                                      <span class="d-block" style="color: #0072b1;">Upload Image</span>
                                      <p>Drag and drop files here</p>
                                    </span>
                                    <template v-if="preview">
                                      <img :src="preview" class="img-fluid mt-2" />
                                    </template>
                                  </label>
                                  <input
                                    type="file"   name="site_logo"
                                    accept="image/*" value=""
                                    @change="previewImage('post-thumbnail4')"
                                    class="input-file"
                                    id="post-thumbnail4"
                                  />
                                </div>
                              </div>
                              <div class="col-md-4 identity" id="upload-image5" style="margin-bottom: 10px;">
                                <div class="input-file-wrapper transition-linear-3 position-relative">
                                  <span
                                    class="remove-img-btn position-absolute" style="cursor: pointer;background: #ed5646;color: white !important;border-radius: 5px;z-index: 10;padding: 4px 8px !important;"
                                    @click="reset('post-thumbnail5')"
                                    v-if="preview!==null"
                                  >
                                    Remove
                                  </span>
                                  <label
                                    class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                    for="post-thumbnail5" style="background: #f4fbff;border-radius: 4px;cursor: pointer;"
                                  >
                                    <span v-show="preview===null">
                                      <i class="fa-solid fa-cloud-arrow-up pt-3" style="color: #ababab;"></i>
                                      <span class="d-block" style="color: #0072b1;">Upload Image</span>
                                      <p>Drag and drop files here</p>
                                    </span>
                                    <template v-if="preview">
                                      <img :src="preview" class="img-fluid mt-2" />
                                    </template>
                                  </label>
                                  <input
                                    type="file"   name="site_logo"
                                    accept="image/*" value=""
                                    @change="previewImage('post-thumbnail5')"
                                    class="input-file"
                                    id="post-thumbnail5"
                                  />
                                </div>
                              </div>
                              <div class="col-md-4 identity" id="upload-image6" style="margin-bottom: 10px;">
                                <div class="input-file-wrapper transition-linear-3 position-relative">
                                  <span
                                    class="remove-img-btn position-absolute" style="cursor: pointer;background: #ed5646;color: white !important;border-radius: 5px;z-index: 10;padding: 4px 8px !important;"
                                    @click="reset('post-thumbnail6')"
                                    v-if="preview!==null"
                                  >
                                    Remove
                                  </span>
                                  <label
                                    class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                    for="post-thumbnail6" style="background: #f4fbff;border-radius: 4px;cursor: pointer;"
                                  >
                                    <span v-show="preview===null">
                                      <i class="fa-solid fa-cloud-arrow-up pt-3" style="color: #ababab;"></i>
                                      <span class="d-block" style="color: #0072b1;">Upload Image</span>
                                      <p>Drag and drop files here</p>
                                    </span>
                                    <template v-if="preview">
                                      <img :src="preview" class="img-fluid mt-2" />
                                    </template>
                                  </label>
                                  <input
                                    type="file"   name="site_logo"
                                    accept="image/*" value=""
                                    @change="previewImage('post-thumbnail6')"
                                    class="input-file"
                                    id="post-thumbnail6"
                                  />
                                </div>
                              </div>
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  style="margin-top: 0px !important"
                                  >Add a Video</label
                                >
                                <p>
                                  Upload a video of you raising your thumb up
                                  while facing the camera.
                                  <a href="#">see example</a>
                                </p>
                                <h6>Our Requirements for all video</h6>
                                <ul style="padding-left: 0px">
                                  <li>
                                    1. video must be of a great quality and in
                                    colour.
                                  </li>
                                  <li>
                                    2. It must accurately describe your
                                    experience
                                  </li>
                                  <li>
                                    3. It must belong to you, do not infringe
                                    copyright work.
                                  </li>
                                  <li>
                                    4. Business logos are not allowed on photos.
                                  </li>
                                  <li>5. Selfie video are no allowed</li>
                                </ul>
                              </div>
                            </div>
                            <div class="col-md-4 identity" id="upload-image7" style="margin-bottom: 10px;">
                              <div class="input-file-wrapper transition-linear-3 position-relative">
                                <span
                                  class="remove-img-btn position-absolute" style="cursor: pointer;background: #ed5646;color: white !important;border-radius: 5px;z-index: 10;padding: 4px 8px !important;"
                                  @click="reset('post-thumbnail7')"
                                  v-if="preview!==null"
                                >
                                  Remove
                                </span>
                                <label
                                  class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                  for="post-thumbnail7" style="background: #f4fbff;border-radius: 4px;cursor: pointer;"
                                >
                                  <span v-show="preview===null">
                                    <i class="fa-solid fa-cloud-arrow-up pt-3" style="color: #ababab;"></i>
                                    <span class="d-block" style="color: #0072b1;">Upload Video</span>
                                    <p>Drag and drop files here</p>
                                  </span>
                                  <video v-if="preview" controls id="video-tag" style="height: 250px;" >
                                    <source :src="preview" class="img-fluid mt-2" id="video-source" >
                                   
                                  </video>
                                </label>
                                <input
                                  type="file"   name="site_logo"
                                  accept="video/*" value=""
                                  @change="previewImage('post-thumbnail7')"
                                  class="input-file"
                                  id="post-thumbnail7"
                                />
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- =========== BUTTONS SECTION ============  -->
                        <div class="row">
                          <div class="col-md-12">
                            <div class="buttons-sec">
                              <button type="button" class="btn btn-back"  onclick="BackTab(this.id)"   data-tab="6" id="tab_back_btn_6">
                                Back
                              </button>
                              <button type="button"  onclick="getServiceDetail(this.id)" data-tab="6" id="tab_btn_6" class="btn btn-next">
                                Next
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div
                class="tab-pane fade "
                id="tab7"
                role="tabpanel"
                aria-labelledby="tab7-tab"
              >
                <div class="row">
                  <div class="col-lg-12">
                    <div class="top-head">
                      <h1>Verification</h1>
                    </div>
                    <!-- =================================================== -->
                    <div class="row">
                      <div class="col-md-12">
                        <div class="main-tab-sec">
                          <!--  -->
                          <div class="row">
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  style="margin-top: 0px !important"
                                  >Option 1</label
                                >
                                <p>
                                  Post a 10 to 30 seconds video explaining the service you will be provide
                                </p>
                                <h6>Our Requirements for a video</h6>
                                <ul style="padding-left: 0px">
                                  <li>
                                    1. Video must be of a great quality and in colour.
                                  </li>
                                  <li>
                                    2. It must accurately describe your experience
                                  </li>
                                  <li>
                                    3. It must belong to you, do not infringe copyright work.
                                  </li>
                                  <li>
                                    4. Business logos are not allowed in video.
                                  </li>
                                  <li>5. Video must be shot horizontally.</li>
                                  <li>6. Your video should be between 1 to 3 minute. Size limit of 100 mb.</li>
                                </ul>
                              </div>
                            </div>
                            <div class="col-md-12 identity" id="upload-image8" style="margin-bottom: 10px;">
                              <div class="input-file-wrapper transition-linear-3 position-relative">
                                <span
                                  class="remove-img-btn position-absolute" style="cursor: pointer;background: #ed5646;color: white !important;border-radius: 5px;z-index: 10;padding: 4px 8px !important;"
                                  @click="reset('post-thumbnail8')"
                                  v-if="preview!==null"
                                >
                                  Remove
                                </span>
                                <label
                                  class="input-style input-label lh-1-7 p-4 text-center cursor-pointer"
                                  for="post-thumbnail8" style="background: #f4fbff;border-radius: 4px;cursor: pointer; width: 100%;"
                                >
                                  <span v-show="preview===null">
                                    <i class="fa-solid fa-cloud-arrow-up pt-3" style="color: #ababab; font-size: 40px; margin-bottom: 10px;"></i>
                                    <span class="d-block" style="color: #0072b1;margin-bottom: 10px;">Upload Video</span>
                                    <p>Drag and drop files here</p>
                                  </span>
                                  <video v-if="preview" controls id="video-tag" style="height: 250px; width:100%" >
                                    <source :src="preview" class="img-fluid mt-2" id="video-source" >
                                   
                                  </video>
                                </label>
                                <input
                                  type="file"   name="site_logo"
                                  accept="video/*" value=""
                                  @change="previewImage('post-thumbnail8')"
                                  class="input-file"
                                  id="post-thumbnail8"
                                />
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  style="margin-top: 0px !important"
                                  >Option 2</label
                                >
                                <p>
                                  Upload a photo of you raising your thumb up while facing the camera.
                                  <a href="#">see example</a>
                                </p>
                                <h6>Our Requirements for all Photo</h6>
                                <ul style="padding-left: 0px">
                                  <li>
                                    1. Photo must be of a great quality and in colour.
                                  </li>
                                  <li>
                                    2. It must accurately describe your experience
                                  </li>
                                  <li>
                                    3. It must belong to you, do not infringe copyright work.
                                  </li>
                                  <li>
                                    4. Business logos are not allowed on photos.
                                  </li>
                                  <li>5. Selfie photos are no allowed</li>
                                </ul>
                              </div>
                            </div>
                            <div class="col-md-12 identity" id="upload-image9" style="margin-bottom: 10px;">
                              <div class="input-file-wrapper transition-linear-3 position-relative">
                                <span
                                  class="remove-img-btn position-absolute" style="cursor: pointer;background: #ed5646;color: white !important;border-radius: 5px;z-index: 10;padding: 4px 8px !important;"
                                  @click="reset('post-thumbnail9')"
                                  v-if="preview!==null"
                                >
                                  Remove
                                </span>
                                <label
                                  class="input-style input-label lh-1-7 p-4 text-center cursor-pointer"
                                  for="post-thumbnail9" style="background: #f4fbff;border-radius: 4px;cursor: pointer; width: 100%;"
                                >
                                  <span v-show="preview===null">
                                    <i class="fa-solid fa-cloud-arrow-up pt-3" style="color: #ababab; font-size: 40px; margin-bottom: 10px;"></i>
                                    <span class="d-block" style="color: #0072b1;margin-bottom: 10px;">Upload Image</span>
                                    <p>Drag and drop files here</p>
                                  </span>
                                  <template v-if="preview" style="height: 250px; width:100%">
                                    <img :src="preview" class="img-fluid mt-2" />
                                  </template>
                                </label>
                                <input
                                  type="file"   name="site_logo"
                                  accept="image/*" value=""
                                  @change="previewImage('post-thumbnail9')"
                                  class="input-file"
                                  id="post-thumbnail9"
                                />
                              </div>
                            </div>
                            @if ($expert)
                              <input type="hidden" id="verification_center" value="{{$expert->verification_center}}">
                            @if ($expert->verification_center  == 1)
                                
                            
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  style="margin-top: 0px !important"
                                  >Option 3</label
                                >
                                <p>
                                  upload front and back image of your Driving license.
                                </p>
                                <h6>Our Requirements for Driving License</h6>
                                <ul style="padding-left: 0px">
                                  <li>
                                    1. Photo must be of a great quality and in colour.
                                  </li>
                                  <li>
                                    2. It must belong to you, do not infringe copyright work.
                                  </li>
                                  <li>
                                    3. Business logos are not allowed on photos.
                                  </li>
                                </ul>
                              </div>
                            </div>

                            <div class="col-md-12 identity" id="upload-image10" style="margin-bottom: 10px;">
                              <div class="input-file-wrapper transition-linear-3 position-relative">
                                <span
                                  class="remove-img-btn position-absolute" style="cursor: pointer;background: #ed5646;color: white !important;border-radius: 5px;z-index: 10;padding: 4px 8px !important;"
                                  @click="reset('post-thumbnail10')"
                                  v-if="preview!==null"
                                >
                                  Remove
                                </span>
                                <label
                                  class="input-style input-label lh-1-7 p-4 text-center cursor-pointer"
                                  for="post-thumbnail10" style="background: #f4fbff;border-radius: 4px;cursor: pointer; width: 100%;"
                                >
                                  <span v-show="preview===null">
                                    <i class="fa-solid fa-cloud-arrow-up pt-3" style="color: #ababab; font-size: 40px; margin-bottom: 10px;"></i>
                                    <span class="d-block" style="color: #0072b1;margin-bottom: 10px;">Front Image</span>
                                    <p>Drag and drop files here</p>
                                  </span>
                                  <template v-if="preview" style="height: 250px; width:100%">
                                    <img :src="preview" class="img-fluid mt-2" />
                                  </template>
                                </label>
                                <input
                                  type="file"   name="site_logo"
                                  accept="image/*" value=""
                                  @change="previewImage('post-thumbnail10')"
                                  class="input-file"
                                  id="post-thumbnail10"
                                />
                              </div>
                            </div>
                            <div class="col-md-12 identity" id="upload-image11" style="margin-bottom: 10px;">
                              <div class="input-file-wrapper transition-linear-3 position-relative">
                                <span
                                  class="remove-img-btn position-absolute" style="cursor: pointer;background: #ed5646;color: white !important;border-radius: 5px;z-index: 10;padding: 4px 8px !important;"
                                  @click="reset('post-thumbnail11')"
                                  v-if="preview!==null"
                                >
                                  Remove
                                </span>
                                <label
                                  class="input-style input-label lh-1-7 p-4 text-center cursor-pointer"
                                  for="post-thumbnail11" style="background: #f4fbff;border-radius: 4px;cursor: pointer; width: 100%;"
                                >
                                  <span v-show="preview===null">
                                    <i class="fa-solid fa-cloud-arrow-up pt-3" style="color: #ababab; font-size: 40px; margin-bottom: 10px;"></i>
                                    <span class="d-block" style="color: #0072b1;margin-bottom: 10px;">Back Image</span>
                                    <p>Drag and drop files here</p>
                                  </span>
                                  <template v-if="preview" style="height: 250px; width:100%">
                                    <img :src="preview" class="img-fluid mt-2" />
                                  </template>
                                </label>
                                <input
                                  type="file"   name="site_logo"
                                  accept="image/*" value=""
                                  @change="previewImage('post-thumbnail11')"
                                  class="input-file"
                                  id="post-thumbnail11"
                                />
                              </div>
                            </div>
                             

                            @endif
                                
                            @endif



                          </div>
                        </div>
                        <!-- =========== BUTTONS SECTION ============  -->
                        <div class="row">
                          <div class="col-md-12">
                            <div class="buttons-sec">
                              <button type="button" class="btn btn-back" onclick="BackTab(this.id)"   data-tab="7" id="tab_back_btn_7">
                                Back
                              </button>
                              <button type="button" onclick="getServiceDetail(this.id)" data-tab="7" id="tab_btn_7" class="btn btn-next">
                                Next
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


              
              <div
              class="tab-pane fade "
              id="tab8"
              role="tabpanel"
              aria-labelledby="tab8-tab"
            >
              <div class="row">
                <div class="col-lg-12">
                  <div class="top-head">
                    <h1>Do you need your application fast tracked?</h1>
                  </div>
                  <!-- =================================================== -->
                  <div class="row">
                   <!-- Application Section -->
<div class="col-md-6">
  <div class="application-section">
    <h3>Fast track my application</h3>
    <p>Get your application approved in 48 hours.</p>
    <button class="btn select-btn" id="fast_track" onclick="AppTrack(this.id)">Select</button>
  </div>
</div>
                    <div class="col-md-6">
                      <div class="application-section">
                        <h3>Do not fast track my application</h3>
                        <p>Get your application approve in 1 to 2 weeks.
                        </p>
                        <button class="btn select-btn active" id="normal_track" onclick="AppTrack(this.id)">Select</button>
                      </div>
                    </div>
                    <input type="hidden" id="app_type" value="0">
                    <!-- Payment Details Section -->
<div class="payment-det" style="display: none;">
  <div class="row">
    <div class="col-md-6">
      <div class="pay-head">
        <h3>Pay With</h3>
      </div>
    </div>
    <div class="col-md-6">
      <div class="payment-method">
        <img src="assets/expert/asset/img/visa.png" alt="Visa">
        <img src="assets/expert/asset/img/mastercard.png" alt="MasterCard">
        <img src="assets/expert/asset/img/american-express.png" alt="American Express">
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="main-tab-sec">
      <div class="row">
        <div class="col-md-6 input-sec">
          <input type="text" id="holder_name" class="form-control" placeholder="Card Holder Name" />
        </div>
        <div class="col-md-6 input-sec">
          <input type="text" id="card_number" class="form-control" placeholder="Card Number" />
        </div>
        <div class="col-md-6">
          <input type="text" id="cvv" class="form-control" placeholder="CVV" />
        </div>
        <div class="col-md-6">
          <input type="text" id="date" class="form-control" placeholder="MM/YY" />
        </div>
        <div class="col-md-12 form-check check-terms">
          <input type="checkbox" class="form-check-input" id="termsCheck">
          <label class="form-check-label" for="termsCheck">
            By checking this box, you’re confirming that you understand and agree with our
            <a href="/term-condition">terms & conditions</a>
          </label>
        </div>
        <div class="col-md-12">
          <button class="btn pay-btn" onclick="PayTrack()">Pay Securely $5</button>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
                      <!-- =========== BUTTONS SECTION ============  -->
                      <div class="row mt-4">
                        <div class="col-md-12">
                          <div class="buttons-sec">
                            <button type="button" class="btn btn-back" onclick="BackTab(this.id)"   data-tab="8" id="tab_back_btn_8">
                              Back
                            </button>
                            <button type="button" onclick="getServiceDetail(this.id)" data-tab="8" id="tab_btn_8" class="btn btn-next">
                              Next
                            </button>
                          </div>
                        </div>
                      </div>
                    
                 
                  </div>
                </div>
              
            </div>

              <form action="/expert-profile-upload" method="post" enctype="multipart/form-data">
                @csrf
              <div
                class="tab-pane fade"
                id="tab9"
                role="tabpanel"
                aria-labelledby="tab9-tab"
              >
                <div class="row">
                  <div class="col-lg-12">
                    <div class="top-head">
                      <h1>Manage Profile</h1>
                    </div>
                    <!-- =================================================== -->
                 
                  
                    <div class="row">
                      <div class="col-md-12">
                        <div class="main-tab-sec">
                          <div class="row">
                            <div class="col-md-2">
                              <div class="avatar-upload">
                                {{-- <div class="avatar-edit">
                                  <input
                                    type="file"
                                    id="imageUpload"
                                    accept=".png, .jpg, .jpeg"
                                  />
                                  <label for="imageUpload"></label>
                                </div> --}}
                                <div class="avatar-preview">
                                  <div
                                    id="imagePreviewFinel"
                                    style="
                                      background-image: url(http://i.pravatar.cc/500?img=7);
                                      width: 100%;
                                    "
                                  ></div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-10">
                              <div class="">
                                <label
                                  class="form-label"
                                  style="margin-top: 0px !important"
                                  >Profile Photo <span>*</span></label
                                >
                                <input
                                  class="form-control d-block image_disable"
                                  type="file" 
                                  id="profile_finel" name="profile_image"
                                />
                              </div>
                            </div>
                          </div>

                          <!--  -->
                          <div class="row">
                            <div class="col-md-6">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  >First Name <span>*</span></label
                                >
                                <input
                                  type="text" readonly
                                  class="form-control"
                                  id="first_name_finel" name="first_name"
                                  placeholder="eg. Usama"
                                />
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  >Last Name <span>*</span></label
                                >
                                <input
                                  type="text" readonly
                                  class="form-control" name="last_name"
                                  id="last_name_finel"
                                  placeholder="eg. Aslam"
                                />
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  >Gender <span>*</span></label
                                >
                                <input
                                  type="text" readonly
                                  class="form-control" name="gender"
                                  id="gender_finel"
                                  placeholder="eg. Male"
                                />
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  >Your Profession <span>*</span></label
                                >
                                <p>
                                  For Example : “Fitness Trainer” , “Designer” ,
                                  “Videographer” , etc. The profession should be
                                  related to the experience you will be
                                  providing on DreamCrowd
                                </p>
                                <input
                                  type="text" readonly
                                  class="form-control" name="profession"
                                  id="profession_finel"
                                  placeholder="eg. Graphic Designer"
                                />
                              </div>
                            </div>
                            <div class="col-md-12">
                              <label class="form-label"
                                >Select Service <span>*</span></label
                              >
                              <input
                              type="text" readonly
                              class="form-control" name="service_role"
                              id="service_role_finel"
                              placeholder="eg. Graphic Designer"
                            />
                            </div>
                            <div class="col-md-12">
                              <label class="form-label"
                                >Delivery Option <span>*</span></label
                              >
                              <input
                                  type="text" readonly
                                  class="form-control" name="service_type"
                                  id="service_type_finel"
                                  placeholder="eg. Graphic Designer"
                                />
                            </div>
                            <div class="col-md-12">
                              <label class="form-label"
                                >Address <span>*</span></label
                              >
                              
                              <input type="text"  name="street_address" id="street_address_finel" placeholder="Street Address" readonly class="form-control">
                              <input type="hidden"  name="ip_address" id="ip_address_finel" placeholder="" readonly class="form-control">
                              <input type="hidden"  name="country_code" id="country_code_finel" placeholder="" readonly class="form-control">
                              <input type="hidden"  name="latitude" id="latitude_finel" placeholder="" readonly class="form-control">
                              <input type="hidden"  name="longitude" id="longitude_finel" placeholder="" readonly class="form-control">
                              <input type="hidden"  name="app_type" id="app_type_finel" placeholder="" readonly class="form-control">
                            </div>

                            <div class="col-md-12">
                              <label class="form-label"
                                >Country <span>*</span></label
                              >
                              <input type="text"  name="country" id="country_finel" placeholder="Country" readonly class="form-control">
                            </div>
                            <div class="col-md-6">
                              {{-- <label class="form-label"
                                >City <span>*</span></label
                              > --}}
                              
                              <input type="hidden" name="city" id="city_finel" placeholder="City" readonly class="form-control">
                            </div>
                            <div class="col-md-6">
                              <div class="">
                                {{-- <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  >Zip Code/Post Code <span>*</span></label
                                > --}}
                                <input
                                  type="hidden" readonly
                                  class="form-control" name="zip_code"
                                  id="zip_code_finel"
                                  placeholder="Zip Code"
                                />
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- ================================================================================================ -->
                <div class="row" id="class_cat_finel_div">
                  <div class="col-lg-12">
                    <div class="top-head">
                      <h1>Class Category</h1>
                    </div>
                    <!-- ============================ -->
                    <div class="row">
                      <div class="col-md-12">
                        <div class="main-tab-sec">
                          <!--  -->
                          <div class="row">
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  style="margin-top: 0px !important"
                                  >Category <span>*</span></label
                                >
                                <p>
                                  Select Up to five Categories that mostly sums
                                  up the experience you are providing. Please be
                                  aware that it is difficult to be approved
                                  under the following experience: Politics,
                                  Religion and Gambling
                                </p>
                                <input type="hidden" id="class_cate_ids_finel" name="class_cate_ids">
                                <input
                                type="text" readonly
                                class="form-control" name="class_category"
                                id="class_category_finel"
                                placeholder="eg. Category"
                              />
                              </div>
                            </div>
                            <div class="col-md-12">
                              <label class="form-label"
                                >Sub Category <span>*</span></label
                              >
                              <input type="hidden" id="cls_sub_val_finel" name="class_sub_category">
                              <input
                              type="text" readonly
                              class="form-control" 
                              id="class_sub_category_finel"
                              placeholder="eg. Sub Category"
                            />
                            </div>
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  >Positive Search Terms <span>*</span></label
                                >
                                <p>
                                  Select Up to five Categories that mostly sums
                                  up the experience you are providing. Please be
                                  aware that it is difficult to be approved
                                  under the following experience: Politics,
                                  Religion and Gambling
                                </p>
                                <input
                                  type="text" readonly
                                  class="form-control" name="class_term"
                                  id="class_term_finel"
                                  placeholder="positive search terms......"
                                />
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- ================================================================================================== -->
                <!-- ================================================================================================ -->
                <div class="row" id="freelance_cat_finel_div">
                  <div class="col-lg-12">
                    <div class="top-head">
                      <h1>Freelance Category</h1>
                    </div>
                    <!-- ============================ -->
                    <div class="row">
                      <div class="col-md-12">
                        <div class="main-tab-sec">
                          <!--  -->
                          <div class="row">
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  style="margin-top: 0px !important"
                                  >Category <span>*</span></label
                                >
                                <p>
                                  Select Up to five Categories that mostly sums
                                  up the experience you are providing. Please be
                                  aware that it is difficult to be approved
                                  under the following experience: Politics,
                                  Religion and Gambling
                                </p>
                                <input type="hidden" id="freelance_cate_ids_finel" name="freelance_cate_ids">
                                <input
                                type="text" readonly
                                class="form-control" name="freelance_category"
                                id="freelance_category_finel"
                                placeholder="eg. Category"
                              />
                              </div>
                            </div>
                            <div class="col-md-12">
                              <label class="form-label"
                                >Sub Category <span>*</span></label
                              >
                              <input type="hidden" id="fls_sub_val_finel" name="freelance_sub_category">
                              
                              <input
                              type="text" readonly
                              class="form-control"  
                              id="freelance_sub_category_finel"
                              placeholder="eg. Sub Category"
                            />
                            </div>
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  >Positive Search Terms <span>*</span></label
                                >
                                <p>
                                  Select Up to five Categories that mostly sums
                                  up the experience you are providing. Please be
                                  aware that it is difficult to be approved
                                  under the following experience: Politics,
                                  Religion and Gambling
                                </p>
                                <input
                                  type="text" readonly
                                  class="form-control" name="freelance_term"
                                  id="freelance_term_finel"
                                  placeholder="positive search terms......"
                                />
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- ================================================================================================== -->
                <div class="row">
                  <div class="col-lg-12">
                    <div class="top-head">
                      <h1>Add Experience</h1>
                    </div>
                    <!-- =================================================== -->
                    <div class="row">
                      <div class="col-md-12">
                        <div class="main-tab-sec">
                          <!--  -->
                          <div class="row">
                            <input type="hidden" id="finel_experience" name="experience">
                            <div id="Experience_main_div_finel">
                              
                             </div>
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  >Add Portfolio <span>*</span></label
                                >
                                <p>
                                  Please provide a link to a website where we
                                  can find some or all your portfolio samples.Or
                                  you could provide a link to a website (Such as
                                  LinkedIn or a service website) where we can
                                  see some evidence of your work experience
                                </p>
                                <input
                                type="text" readonly
                                class="form-control" name="portfolio"
                                id="portfolio_finel"
                                placeholder="3"
                              />
                              </div>
                            </div>


                            <input type="hidden" id="portfolio_url_finel" name="portfolio_url">
                            <div id="imageDiv1">

                          </div>



                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- =========================================================================================== -->
                <div class="row">
                  <div class="col-lg-12">
                    <div class="top-head">
                      <h1>Language & Service Overview</h1>
                    </div>
                    <!-- =================================================== -->
                    <div class="row">
                      <div class="col-md-12">
                        <div class="main-tab-sec">
                          <!--  -->
                          <div class="row">
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  style="margin-top: 0px !important"
                                  >Whats your primary language?
                                  <span>*</span></label
                                >
                                <p>
                                  You should be able read, write and speak this
                                  language fluently.
                                </p>
                                <input
                                type="text" readonly
                                class="form-control" name="primary_language"
                                id="primary_language_finel"
                                placeholder="eg. English"
                              />
                              </div>
                            </div>
                            <div class="col-md-12" id="english_language_finel_main_div">
                              <label class="form-label"
                                >Are you fluent in English?</label
                              >
                              <p>
                                This should be language you are comfortable at
                                hosting in.
                              </p>
                              <input
                              type="text" readonly
                              class="form-control" name="english_language"
                              id="english_language_finel"
                              placeholder="eg. English"
                            />
                            </div>


                            <div class="col-md-12">
                              <label class="form-label"
                                >Do you speak other languages fluently?</label
                              >
                              <div class="form-check form-switch col-md-12">
                                <input class="form-check-input" type="checkbox" role="switch" id="speak_other_language_finel"   disabled> 
                              </div>
                            </div>
                            
                            <div class="col-md-12" id="other_language_main_div_finel">
                              <label class="form-label"
                              >What other languages do you speak
                              fluently? <span>*</span></label
                            > 
                            <p>
                              This should be language you are comfortable at
                              hosting in.
                            </p>
                              <input
                              type="text" readonly
                              class="form-control" name="other_language"
                              id="other_language_finel"
                              placeholder="eg. English"
                            />
                            </div>
                          </div>
                          <div class="row mt-3">
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  style="margin-top: 0px !important"
                                  >Overview <span>*</span></label
                                >
                                <p>
                                  Tell your guest about you and give a summary
                                  of all classes and activities you intend to
                                  provide. Remember that this section is a
                                  chance to convince guests to book your classes
                                  and activities. You should take your time to
                                  make it friendly and interesting. We have
                                  provided some suggestions for you below. You
                                  could use some or all suggestions.
                                  Suggestions: Start with a friendly
                                  introduction Give a brief description of your
                                  classes/activities (the online experience you
                                  are providing) and what differentiates it from
                                  experiences provided by other hosts in
                                  relative fields. Discuss what skill levels are
                                  required to book your experience. Summarise
                                  how you plan to engage with your guest during
                                  each experience Give a nice conclusion.
                                </p>
                                <textarea
                                  class="form-control image_disable"
                                  id="overview_finel" name="overview"
                                  rows="6" 
                                  placeholder="write your experience heading....."
                                ></textarea>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  >About Me <span>*</span></label
                                >
                                <p>
                                  Talk about your credential and other things
                                  that makes you qualified to host the
                                  experience.
                                </p>
                                <textarea
                                  class="form-control image_disable"
                                  id="about_me_finel" name="about_me"
                                  rows="6" 
                                  placeholder="write your experience heading....."
                                ></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- =================================================== -->
                <div class="row">
                  <div class="col-lg-12">
                    <div class="top-head">
                      <h1>Add Photos</h1>
                    </div>
                    <!-- =================================================== -->
                    <div class="row">
                      <div class="col-md-12">
                        <div class="main-tab-sec">
                          <!--  -->
                          <div class="row">
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  style="margin-top: 0px !important"
                                  >Main Image <span>*</span></label
                                >
                                <p>
                                  Upload a photo of you raising your thumb up
                                  while facing the camera.
                                  <a href="#">see example</a>
                                </p>
                                <h6>Our Requirements for all Photo</h6>
                                <ul style="padding-left: 0px">
                                  <li>
                                    1. Photo must be of a great quality and in
                                    colour.
                                  </li>
                                  <li>
                                    2. It must accurately describe your
                                    experience
                                  </li>
                                  <li>
                                    3. It must belong to you, do not infringe
                                    copyright work.
                                  </li>
                                  <li>
                                    4. Business logos are not allowed on photos.
                                  </li>
                                  <li>5. Selfie photos are no allowed</li>
                                </ul>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <fieldset style="height: 200px;background-repeat: no-repeat;background-size:cover;"  id="main_image_show"
                                class="upload_dropZone text-center mb-3 p-4"
                              >
                                <legend class="visually-hidden">
                                  Image uploader
                                </legend>
                                

                                <input
                                  id="main_image_finel"  name="main_image"
                                  data-post-name="image_background"
                                  data-post-url="https://someplace.com/image/uploads/backgrounds/"
                                  class="position-absolute invisible image_disable"
                                  type="file"
                                  
                                  accept="image/jpeg, image/png, image/svg+xml"
                                />

                                <div
                                  class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0"
                                ></div>
                              </fieldset>
                            </div>
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  style="margin-top: 0px !important"
                                  >More Image <span>*</span></label
                                >
                                <p>
                                  Upload a photo of you raising your thumb up
                                  while facing the camera.
                                  <a href="#">see example</a>
                                </p>
                                <h6>Our Requirements for all Photo</h6>
                                <ul style="padding-left: 0px">
                                  <li>
                                    1. Photo must be of a great quality and in
                                    colour.
                                  </li>
                                  <li>
                                    2. It must accurately describe your
                                    experience
                                  </li>
                                  <li>
                                    3. It must belong to you, do not infringe
                                    copyright work.
                                  </li>
                                  <li>
                                    4. Business logos are not allowed on photos.
                                  </li>
                                  <li>5. Selfie photos are no allowed</li>
                                </ul>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <fieldset style="height: 200px;background-repeat: no-repeat;background-size:cover;"  id="image_1_show"
                                class="upload_dropZone text-center mb-3 p-4"
                              >
                                <legend class="visually-hidden">
                                  Image uploader
                                </legend>
                     
                                <input
                                id="image_1_finel"  name="image_1"
                                  data-post-name="image_background"
                                  data-post-url="https://someplace.com/image/uploads/backgrounds/"
                                  class="position-absolute invisible image_disable"
                                  type="file"
                                  
                                  accept="image/jpeg, image/png, image/svg+xml"
                                />

                                <div
                                  class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0"
                                ></div>
                              </fieldset>
                            </div>
                            <div class="col-md-4">
                              <fieldset style="height: 200px;background-repeat: no-repeat;background-size:cover;"  id="image_2_show"
                                class="upload_dropZone text-center mb-3 p-4"
                              >
                                <legend class="visually-hidden">
                                  Image uploader
                                </legend>
                                 

                                <input
                                id="image_2_finel"  name="image_2"
                                  data-post-name="image_background"
                                  data-post-url="https://someplace.com/image/uploads/backgrounds/"
                                  class="position-absolute invisible image_disable"
                                  type="file"
                                  
                                  accept="image/jpeg, image/png, image/svg+xml"
                                />

                                <div
                                  class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0"
                                ></div>
                              </fieldset>
                            </div>
                            <div class="col-md-4">
                              <fieldset style="height: 200px;background-repeat: no-repeat;background-size:cover;"  id="image_3_show"
                                class="upload_dropZone text-center mb-3 p-4"
                              >
                                <legend class="visually-hidden">
                                  Image uploader
                                </legend>
                            

                                <input
                                id="image_3_finel"  name="image_3"
                                  data-post-name="image_background"
                                  data-post-url="https://someplace.com/image/uploads/backgrounds/"
                                  class="position-absolute invisible image_disable"
                                  type="file"
                                  
                                  accept="image/jpeg, image/png, image/svg+xml"
                                />

                                <div
                                  class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0"
                                ></div>
                              </fieldset>
                            </div>
                            <div class="col-md-4">
                              <fieldset style="height: 200px;background-repeat: no-repeat;background-size:cover;"  id="image_4_show"
                                class="upload_dropZone text-center mb-3 p-4"
                              >
                                <legend class="visually-hidden">
                                  Image uploader
                                </legend>
                                

                                <input
                                id="image_4_finel"  name="image_4"
                                  data-post-name="image_background"
                                  data-post-url="https://someplace.com/image/uploads/backgrounds/"
                                  class="position-absolute invisible image_disable"
                                  type="file"
                                  
                                  accept="image/jpeg, image/png, image/svg+xml"
                                />

                                <div
                                  class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0"
                                ></div>
                              </fieldset>
                            </div>
                            <div class="col-md-4">
                              <fieldset style="height: 200px;background-repeat: no-repeat;background-size:cover;"  id="image_5_show"
                                class="upload_dropZone text-center mb-3 p-4"
                              >
                                <legend class="visually-hidden">
                                  Image uploader
                                </legend>
                                

                                <input
                                id="image_5_finel"  name="image_5"
                                  data-post-name="image_background"
                                  data-post-url="https://someplace.com/image/uploads/backgrounds/"
                                  class="position-absolute invisible image_disable"
                                  type="file"
                                  
                                  accept="image/jpeg, image/png, image/svg+xml"
                                />

                                <div
                                  class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0"
                                ></div>
                              </fieldset>
                            </div>
                            <div class="col-md-4">
                              <fieldset style="height: 200px;background-repeat: no-repeat;background-size:cover;"  id="image_6_show"
                                class="upload_dropZone text-center mb-3 p-4"
                              >
                                <legend class="visually-hidden">
                                  Image uploader
                                </legend>
                               

                                <input
                                  id="image_6_finel"  name="image_6"
                                  data-post-name="image_background"
                                  data-post-url="https://someplace.com/image/uploads/backgrounds/"
                                  class="position-absolute invisible image_disable"
                                  type="file"
                                  
                                  accept="image/jpeg, image/png, image/svg+xml"
                                />

                                <div
                                  class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0"
                                ></div>
                              </fieldset>
                            </div>
                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  style="margin-top: 0px !important"
                                  >Add a Video <span>*</span></label
                                >
                                <p>
                                  Upload a photo of you raising your thumb up
                                  while facing the camera.
                                  <a href="#">see example</a>
                                </p>
                                <h6>Our Requirements for all Photo</h6>
                                <ul style="padding-left: 0px">
                                  <li>
                                    1. Photo must be of a great quality and in
                                    colour.
                                  </li>
                                  <li>
                                    2. It must accurately describe your
                                    experience
                                  </li>
                                  <li>
                                    3. It must belong to you, do not infringe
                                    copyright work.
                                  </li>
                                  <li>
                                    4. Business logos are not allowed on photos.
                                  </li>
                                  <li>5. Selfie photos are no allowed</li>
                                </ul>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <video   controls style="height: 200px;width: -webkit-fill-available; background-repeat: no-repeat;background-size:cover;"  id="video_finel_show" >
                                <source  id="video_source_finel" >
                               </video>
                            <input
                              type="file"   name="video"
                              accept="video/*" 
                              class="input-file  image_disable"
                              id="video_finel"
                            />
                              
                              
                            </div>
                          
                          </div>
                        </div>

                        
                        <input  id="option_1_finel" name="option_1" class="form-control  image_disable" type="file"  accept="video/*" />
                        <input  id="option_2_finel" name="option_2" class="form-control  image_disable" type="file"  accept="image/*" />
                        @if ($expert)
                        @if ($expert->verification_center == 1)
                        <input  id="option_3_finel" name="option_3" class="form-control  image_disable" type="file"  accept="image/*" />
                        <input  id="option_4_finel" name="option_4" class="form-control  image_disable" type="file"  accept="image/*" />
                          @endif
                          @endif
                        


                          
                          <div class="top-head">
                            <h1>Verification </h1>
                          </div>
                          
                          <div class="row">
                            
                            <div class="col-md-4" id="option_1_finel_show_main">
                              <video   controls style="height: 200px;width: -webkit-fill-available; background-repeat: no-repeat;background-size:cover;"  id="video_option_1_finel_show" >
                                <source  id="video_option_1_finel" >
                               </video>
                              
                            </div>

                            <div class="col-md-4"  id="option_2_finel_show_main">
                              <fieldset style="height: 200px;background-repeat: no-repeat;background-size:cover;"  id="option_2_finel_show"
                                class="upload_dropZone text-center mb-3 p-4"
                              >
                                <legend class="visually-hidden">
                                  Image uploader
                                </legend>
                                

                                <div
                                  class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0"
                                ></div>
                              </fieldset>
                            </div>


                            @if ($expert)
                            @if ($expert->verification_center == 1)
                           

                            <div class="col-md-4" id="option_3_finel_show_main">
                              <fieldset style="height: 200px;background-repeat: no-repeat;background-size:cover;"  id="option_3_finel_show"
                                class="upload_dropZone text-center mb-3 p-4"
                              >
                                <legend class="visually-hidden">
                                  Image uploader
                                </legend>
                                

                                <div
                                  class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0"
                                ></div>
                              </fieldset>
                            </div>


                            <div class="col-md-4" id="option_4_finel_show_main">
                              <fieldset style="height: 200px;background-repeat: no-repeat;background-size:cover;"  id="option_4_finel_show"
                                class="upload_dropZone text-center mb-3 p-4"
                              >
                                <legend class="visually-hidden">
                                  Image uploader
                                </legend>
                                

                                <div
                                  class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0"
                                ></div>
                              </fieldset>
                            </div>
                            
                            
                            @endif
                              @endif

                          </div>


                          <div class="top-head">
                            <h1>Application Type</h1>
                          </div>

                          <div class="row">
                            <!-- Application Section -->
         <div class="col-md-6 mb-3" id="fast_track_main_finel" style="display: none ">
           <div class="application-section">
             <h3>Fast track my application</h3>
             <p>Get your application approved in 48 hours.</p>
             <button class="btn select-btn active" id=""  >Select</button>
           </div>
         </div>
                             <div class="col-md-6 mb-3" id="normal_track_main_finel" style="display: none">
                               <div class="application-section">
                                 <h3>Do not fast track my application</h3>
                                 <p>Get your application approve in 1 to 2 weeks.
                                 </p>
                                 <button class="btn select-btn active" id="" >Select</button>
                               </div>
                             </div>
                             </div>



                        <!-- =========== BUTTONS SECTION ============  -->
                        <div class="row">
                          <div class="col-md-12">
                            <div class="buttons-sec">
                              <button type="button" class="btn btn-back"  onclick="BackTab(this.id)"   data-tab="9" id="tab_back_btn_9">
                                Back
                              </button>
                              <button type="submit" class="btn btn-next">
                                Next
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    
                    </div>
                  </div>
                </div>
              </div>
            </form>
            </div>
          </div>
        </div>
        <!--/.row-->
      </div>
      <!--/.container-->
    </div>
    <!--/.section-->
    <!-- =FOOTER-TOP RELATED SECTION BECOM ANB EXPERT END= -->
    <!-- ============================= FOOTER SECTION START HERE ===================================== -->
    <x-public-footer/>
    <!-- =============================== FOOTER SECTION END HERE ===================================== -->
    <script src="assets/expert/libs/jquery/jquery.js"></script>
    <script src="assets/expert/libs/datatable/js/datatable.js"></script>
    <script src="assets/expert/libs/datatable/js/datatablebootstrap.js"></script>
    <script src="assets/expert/libs/select2/js/select2.min.js"></script>
    <script src="assets/expert/libs/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="assets/expert/libs/aos/js/aos.js"></script>
    <script src="assets/expert/asset/js/bootstrap.min.js"></script>
    <script src="assets/expert/asset/js/script.js"></script>
  </body>
</html>

{{-- Check Script For Other Languages Fluent Start --}}
<script>
  $('#speak_other_language').on('click', function () { 
    if ($('#speak_other_language').attr('checked')) { 
      $('#speak_other_language').removeAttr('checked');
      $('#other_language_main_div').hide();
    } else { 
      $('#speak_other_language').attr('checked', 1);
      $('#other_language_main_div').show();
    } 
    
  });
</script>
{{-- Check Script For Other Languages Fluent END --}}

@if ($payments >= 1)
    <script>
      $(document).ready(function () {
        $('#fast_track').addClass('active');
      $('#normal_track').removeClass('active');
      $('.select-btn').removeAttr('onClick');
      $('.payment-det').css('display', 'none');
      $('#app_type').val(1);
      });
    </script>
@endif

<script>
  function AppTrack(Clicked) {  
    if (Clicked == 'fast_track') {
      $('#fast_track').addClass('active');
      $('#normal_track').removeClass('active');
      $('.payment-det').css('display', 'block');
      $('#app_type').val(1);
    } else {
      $('.payment-det').css('display', 'none');
      $('#fast_track').removeClass('active');
      $('#normal_track').addClass('active');
      $('#app_type').val(0);
    }
  }
</script>

{{-- Pay Track Payment Send Script Start --}}
<script>
    function PayTrack() { 
      console.log('yes');
      
      var holder_name = $('#holder_name').val();
      var card_number = $('#card_number').val();
      var cvv = $('#cvv').val();
      var date = $('#date').val();

        // Validation flag
    let isValid = true;

// Validate Holder Name
if (!/^[A-Za-z\s]+$/.test(holder_name) || holder_name === "") {
    alert("Please enter a valid holder name.");
    isValid = false;
    return false ;
}

// Validate Card Number
if (!/^\d{16}$/.test(card_number.replace(/\s+/g, ''))) {
    alert("Please enter a valid 16-digit card number.");
    isValid = false;
    return false ;
}

// Validate CVV
if (!/^\d{3}$/.test(cvv)) {
    alert("Please enter a valid 3-digit CVV.");
    isValid = false;
    return false ;
}

// Validate Expiry Date (MM/YY format and future date check)
if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(date)) {
    alert("Please enter a valid date in MM/YY format.");
    isValid = false;
    return false ;
} else {
    // Split the date into month and year
    var [month, year] = date.split('/');
    var expiry = new Date(`20${year}`, month - 1);
    var now = new Date();
    
    // Check if expiry date is in the future
    if (expiry <= now) {
        alert("Please enter a valid future expiry date.");
        isValid = false;
        return false ;
    }
}

// Submit if all validations pass
if (isValid) {
    // Proceed with form submission
   
    
  $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "POST",
                url: '/fast-track-app-payment',
                data:{ holder_name:holder_name, card_number:card_number, cvv:cvv, date:date,  _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {
                 
                  
                   if (response.success) {
                    toastr.options =
                      {
                          "closeButton" : true,
                           "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                      }
                  toastr.success(response.success);
                  $('.select-btn').removeAttr('onClick');
                  $('.payment-det').css('display', 'none');
                  
                   } else {
                    toastr.options =
                      {
                          "closeButton" : true,
                           "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                      }
                  toastr.error(response.error);
                   }
                },
              
            });
    


}

     }

     document.getElementById('date').addEventListener('input', function(e) {
    let input = e.target.value;
    if (input.length === 2 && !input.includes('/')) {
        e.target.value = input + '/';
    }
});
</script>
{{-- Pay Track Payment Send Script END --}}

{{-- Street Address Google Api Script Start --}}
{{-- Google Script CDN --}}
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&libraries=places&loading=async"></script>

{{-- Get Live Location On CLick Icon Script Start --}}
<script>
  var expertGeocodingInProgress = false; // Flag to prevent multiple simultaneous calls
  var locationIcon = document.getElementById('location-icon');

  // Remove any existing listeners first to prevent duplicates
  var newLocationIcon = locationIcon.cloneNode(true);
  locationIcon.parentNode.replaceChild(newLocationIcon, locationIcon);

  newLocationIcon.addEventListener('click', function () {
    // Prevent multiple simultaneous geocoding requests
    if (expertGeocodingInProgress) {
        console.log('Geocoding already in progress, skipping...');
        return;
    }

    // Check if the browser supports Geolocation API
    if (navigator.geolocation) {
        expertGeocodingInProgress = true; // Set flag
        navigator.geolocation.getCurrentPosition(function (position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;

            console.log('Latitude: ' + latitude + ', Longitude: ' + longitude);

            // Initialize Google Geocoder
            var geocoder = new google.maps.Geocoder();
            var latlng = {lat: latitude, lng: longitude};

            // Use Geocoder to get address from lat/lng
            geocoder.geocode({'location': latlng}, function (results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        var liveAddress = results[0].formatted_address;
                        console.log('Detected Address: ' + liveAddress);

                        // Autofill the input field with the detected address
                        document.getElementById('street_address').value = liveAddress;

                        // Extract specific details (country, city, postal code, country code)
                        var components = results[0].address_components;
                        var country = '';
                        var city = '';
                        var postalCode = '';
                        var countryCode = ''; 

                        components.forEach(function (component) {
                            if (component.types.includes('country')) {
                                country = component.long_name;
                                countryCode = component.short_name;
                            }
                            if (component.types.includes('locality')) {
                                city = component.long_name;
                            }
                            if (component.types.includes('postal_code')) {
                                postalCode = component.long_name;
                            }
                        });

                        // Set values for other fields (assuming these fields exist on your page)
                        document.getElementById('city').value = city;
        document.getElementById('country').value = country;
        document.getElementById('zip_code').value = postalCode;
        document.getElementById('country_code').value = countryCode;
        document.getElementById('latitude').value = latitude;
        document.getElementById('longitude').value = longitude;

                        // Get IP address (optional)
                        $.get('https://api.ipify.org?format=json', function(data) {
                          var ipAddress = data.ip;
                          document.getElementById('ip_address').value = ipAddress;
                        });
                    } else {
                        console.log('No results found');
                    }
                } else {
                    console.log('Geocoder failed due to: ' + status);
                }
                expertGeocodingInProgress = false; // Reset flag after geocoding completes
            });
        }, function (error) {
            expertGeocodingInProgress = false; // Reset flag on error
            console.log("Error occurred. Error code: " + error.code);
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    alert("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    alert("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("An unknown error occurred.");
                    break;
            }
        }, { 
            enableHighAccuracy: true
        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }
});
</script>
{{-- Get Live Location On CLick Icon Script END --}}
<script>
  $(document).ready(function () {
    var autocomplete;
    var id = 'street_address';
    var countryCode = '{{Auth::user()->country_code}}'; // Set this to the desired country code, or update dynamically if needed

    // Initialize Google Places Autocomplete with country restriction
    autocomplete = new google.maps.places.Autocomplete((document.getElementById(id)), {
        types: [], // Allow any geographical location (street address, city, etc.)
        componentRestrictions: { country: countryCode } // Restrict to the specified country
    });

    // Event listener for when a place is selected
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var place = autocomplete.getPlace();
        var addressComponents = place.address_components;

        // Retrieve latitude and longitude from the place geometry
        var latitude = place.geometry.location.lat();
        var longitude = place.geometry.location.lng();

        // Initialize variables to store address details
        var country = '';
        var city = '';
        var postalCode = '';
        var streetAddress = '';

        // Iterate through the address components to extract details
        for (var i = 0; i < addressComponents.length; i++) {
            var component = addressComponents[i];

            if (component.types.includes('country')) {
                country = component.long_name;
                countryCode = component.short_name;
            }
            if (component.types.includes('postal_town')) {
              city = component.long_name; 
            } else if (component.types.includes('administrative_area_level_3') && !city) {
                city = component.long_name; // Fallback to administrative area
            }else if (component.types.includes('administrative_area_level_2') && !city) {
                city = component.long_name; // Fallback to administrative area
            }else if (component.types.includes('administrative_area_level_1') && !city) {
                city = component.long_name; // Fallback to administrative area
            }
           
            if (component.types.includes('postal_code')) {
                postalCode = component.long_name;
            }
            if (component.types.includes('street_number')) {
                streetAddress = component.long_name;
            }
            if (component.types.includes('route')) {
                streetAddress += ' ' + component.long_name;
            }
        }

        // Populate these values into form fields
        document.getElementById('city').value = city;
        document.getElementById('country').value = country;
        document.getElementById('zip_code').value = postalCode;
        document.getElementById('country_code').value = countryCode;
        document.getElementById('latitude').value = latitude;
        document.getElementById('longitude').value = longitude;
    });

    // Get IP address using ipify
    $.get('https://api.ipify.org?format=json', function(data) {
        var ipAddress = data.ip;
        document.getElementById('ip_address').value = ipAddress;
    });
});
</script>
{{-- Street Address Google Api Script END --}}

{{-- Finel Summery Files Mouse In Files Input Disbale Script --}}
<script>

// $(document).ready(function() {
//         $('#city').select2({
//             placeholder: "Select an option",
//             allowClear: true
//         });
//     });

  $('.image_disable').mouseenter(function () { 
    $('.image_disable').attr('disabled', 1);
  });
  $('.image_disable').mouseleave(function () { 
    $('.image_disable').removeAttr('disabled');
  });
</script>

{{-- Positive Search Class Tearm Sperate by slices Script Start --}}
<script>

document.addEventListener('DOMContentLoaded', function() {
    const inputField = document.getElementById('input_class_term');
    const outputDiv = document.getElementById('class_term_div');
    const commaSeparatedField = document.getElementById('class_term');
    let slices = [];

    inputField.addEventListener('keypress', function(event) {
        // Check if the pressed key is Enter or comma
        if (event.key === 'Enter' || event.key === ',') {
            event.preventDefault();  // Prevent default action

            // Get the current value and trim spaces
            let value = inputField.value.trim();

            if (value) {
                // Split by comma and trim each item
                let newSlices = value.split(',').map(item => item.trim());


                if (slices.length >= 5) {
                  
                  toastr.options =
                  {
                    "closeButton" : true,
                     "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                  }
                  toastr.error("Maximum 5 Keywords Allowed!");
                  return false;
                  
                }

                // Add to the slices array
                slices = slices.concat(newSlices);

                // Clear the input field
                inputField.value = '';

                // Update the output
                renderSlices();
            }
        }
    });

    function renderSlices() {
        // Clear the previous output
        outputDiv.innerHTML = '';

        // Create a span for each slice and append it to the outputDiv
        slices.forEach((slice, index) => {
          let span = document.createElement('span');
            span.textContent = slice;
            span.className = 'slice mt-2';
            span.style.backgroundColor = '#0072b1';
            span.style.color = '#fff';
            span.style.padding = '0px 10px';
            span.style.borderRadius  = '4px';
            span.style.display = 'flex';
            span.style.alignItems = 'center';
            span.style.gap = '10px';
            span.style.cursor = 'default';
            span.style.fontSize = '16px';
            span.style.width = 'max-content';
            // Create a remove button
            let removeButton = document.createElement('span');
            removeButton.textContent = 'x';
            removeButton.className = 'remove';
            removeButton.style.color = '#fff';
            removeButton.style.padding = '5px';
            removeButton.style.cursor = 'pointer';

            // Add click event to remove the slice
            removeButton.addEventListener('click', function() {
                removeSlice(index);
            });

            span.appendChild(removeButton);
            outputDiv.appendChild(span);
        });

        // Update the comma-separated input field
        updateCommaSeparatedField();
    }

    function removeSlice(index) {
        // Remove the slice from the array
        slices.splice(index, 1);

        // Update the output
        renderSlices();
    }

    function updateCommaSeparatedField() {
        // Join the slices array into a comma-separated string
        commaSeparatedField.value = slices.join(',');
    }
});



document.addEventListener('DOMContentLoaded', function() {
    const inputField = document.getElementById('input_freelance_term');
    const outputDiv = document.getElementById('freelance_term_div');
    const commaSeparatedField = document.getElementById('freelance_term');
    let slices = [];

    inputField.addEventListener('keypress', function(event) {
        // Check if the pressed key is Enter or comma
        if (event.key === 'Enter' || event.key === ',') {
            event.preventDefault();  // Prevent default action

            // Get the current value and trim spaces
            let value = inputField.value.trim();

            if (value) {
                // Split by comma and trim each item
                let newSlices = value.split(',').map(item => item.trim());


                if (slices.length >= 5) {
                  
                  toastr.options =
                  {
                    "closeButton" : true,
                     "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                  }
                  toastr.error("Maximum 5 Keywords Allowed!");
                  return false;
                  
                }

                // Add to the slices array
                slices = slices.concat(newSlices);

                // Clear the input field
                inputField.value = '';

                // Update the output
                renderSlices();
            }
        }
    });

    function renderSlices() {
        // Clear the previous output
        outputDiv.innerHTML = '';

        // Create a span for each slice and append it to the outputDiv
        slices.forEach((slice, index) => {
          let span = document.createElement('span');
            span.textContent = slice;
            span.className = 'slice mt-2';
            span.style.backgroundColor = '#0072b1';
            span.style.color = '#fff';
            span.style.padding = '0px 10px';
            span.style.borderRadius  = '4px';
            span.style.display = 'flex';
            span.style.alignItems = 'center';
            span.style.gap = '10px';
            span.style.cursor = 'default';
            span.style.fontSize = '16px';
            span.style.width = 'max-content';
            // Create a remove button
            let removeButton = document.createElement('span');
            removeButton.textContent = 'x';
            removeButton.className = 'remove';
            removeButton.style.color = '#fff';
            removeButton.style.padding = '5px';
            removeButton.style.cursor = 'pointer';

            // Add click event to remove the slice
            removeButton.addEventListener('click', function() {
                removeSlice(index);
            });

            span.appendChild(removeButton);
            outputDiv.appendChild(span);
        });

        // Update the comma-separated input field
        updateCommaSeparatedField();
    }

    function removeSlice(index) {
        // Remove the slice from the array
        slices.splice(index, 1);

        // Update the output
        renderSlices();
    }

    function updateCommaSeparatedField() {
        // Join the slices array into a comma-separated string
        commaSeparatedField.value = slices.join(',');
    }
});



</script>
{{-- Positive Search Class Tearm Sperate by slices Script END --}}

{{-- On Change Portfolio for Link --}}
<script>
  $('#portfolio').change(function () { 
     
 var portfolio =   $('#portfolio').val();

 if (portfolio == 'not_link') {
    $('#portfolio_url_div').hide();
 }else{
  $('#portfolio_url_div').show();
 }
    
  });


  // Set Portfolio Urls Script Start =======

  function AddPortfolioUrl(Clicked) { 
    id = Clicked.split('_') ;
    var url = $('#url'+id[2]).val();
    if (url == '') {
      toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.error("Please Write a Link!");
                    return false;
    }

    var get_portfolio_value = $('#array_url_'+id[2]).val();
    // var get_portfolio_value = $('#portfolio_url').val();
    var link_arry = get_portfolio_value.split(',_,');
    if (link_arry.length >= 5) {
      toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.error("Maximmum 5 Links Allowed!");
                    return false;
    }

    var url_content = '';
    var get_portfolio_vls = $('#array_url_'+id[2]).val();

    if (get_portfolio_value == '') {
      url_content += '<div class="d-flex mt-2" id="div_url_re_'+id[2]+'_1"><input type="text" name="field_name[]" readonly value="'+url+'" class="form-control url_value" style="width:95%" placeholder="https://bravemindstudio.com/"/><a  onclick="RemovePortfolioUrls(this.id)" id="remove_url_'+id[2]+'_1" class="remove_portfolio_url" ><img src="assets/expert/asset/img/remove-icon.svg"/></a></div>';
    }else{
      var last_val = get_portfolio_vls.split(',_,');
      var array_length = last_val.length;
      var set_array_length = array_length + 1;
      url_content += '<div class="d-flex mt-2" id="div_url_re_'+id[2]+'_'+set_array_length+'" ><input type="text" name="field_name[]" readonly value="'+url+'" class="form-control url_value" style="width:95%" placeholder="https://bravemindstudio.com/"/><a  onclick="RemovePortfolioUrls(this.id)" id="remove_url_'+id[2]+'_'+set_array_length+'" class="remove_portfolio_url" ><img src="assets/expert/asset/img/remove-icon.svg"/></a></div>';
    
     }
     
    
    $('#portfolio_links_'+id[2]+'_all').append(url_content);
    var get_portfolio_value = $('#array_url_'+id[2]).val();
    if (get_portfolio_value == '') {
      $('#array_url_'+id[2]).val(url);
    }else{
    
     var last_val = $('#array_url_'+id[2]).val();
     var finel_val = last_val+',_,'+url;
      $('#array_url_'+id[2]).val(finel_val);
     }
    $('#url'+id[2]).val('');
   }

  //  Once remove button is clicked
  function RemovePortfolioUrls(Clicked) {
    // Get the ID and extract relevant parts
    var id = Clicked.split('_');
    var divId = '#div_url_re_' + id[2] + '_' + id[3]; // Div for the clicked URL
    var inputSelector = divId + ' input';  // Selector to find the input inside the div
    
    // Get the current URL in the clicked div
    var val_input = $(inputSelector).val();
    
    // Get the current array of URLs from the input field
    var get_portfolio_value = $('#array_url_' + id[2]).val();
    
    // Split the URL string into an array using ',_,' as the separator
    var link_arry = get_portfolio_value.split(',_,');
    
    

    // Filter the array to remove the clicked URL
    var newArr = link_arry.filter(function(url) {
        return url !== val_input;
    });
     
    
    // If there are still URLs left, join them into a string with ',_'
    if (newArr.length > 0) {
        var newUrlString = newArr.join(',_,');
        $('#array_url_' + id[2]).val(newUrlString);
    } else {
        // If no URLs left, clear the input field
        $('#array_url_' + id[2]).val('');
    }
    
    // Remove the corresponding div for the URL input field
    $(divId).remove();  // Remove field HTML
}

 
 
 // Set Portfolio Urls Script END =======

</script>
{{-- Go To Tab Script Start --}}
<script>
  function GoToTab() { 

    const focusAlert = document.getElementById('focusAlert');
            // Position the alert near the mouse cursor
            focusAlert.style.left = event.pageX + 'px';
            focusAlert.style.top = event.pageY + 'px';
            focusAlert.style.display = 'block';
            // Show the alert
            setInterval(function() {
              focusAlert.style.display = 'none';
              
            }, 3000); // 1000 milliseconds = 1 second
     
 
   }
   


   function BackTab(Clicked) { 

    var last_tab = $('#'+Clicked).data('tab');
    if (last_tab == 2) {
      // $('#ClassCategories').html('');
      // $('#ClassSubCategories').html('');
      // $('#FreelanceCategories').html('');
      // $('#FreelanceSubCategories').html('');
      // $('#multiSelectDropdown').html('--select category--');
      // $('#multiSelectDropdown1').html('--select sub-category--');
      // $('#multiSelectDropdown2').html('--select category--');
      // $('#multiSelectDropdown3').html('--select sub-category--');
      // $('#SubOnlineClass').html('');
      // $('#SubInpersonClass').html('');
      // $('#SubOnlineFreelance').html('');
      // $('#SubInpersonFreelance').html('');
    }

var activ_tab_ele = document.getElementsByClassName('nav-link active');
var active_tab_id =  $(activ_tab_ele).attr('id');
var active_numb = active_tab_id.match(/\d/g);
var  active_tab = active_numb.join("");
    var go_tab = active_tab - 1;
    
      $('.nav-link').removeClass('active');
      $('.tab-pane').removeClass('show active');
      // $('#tab'+go_tab+'-tab').attr('data-bs-toggle', "pill");
       $('#tab'+go_tab+'-tab').addClass('active');
       $("#tab"+go_tab).addClass('show active');
      //  $('#tab'+go_tab+'-tab').attr('href', "#tab"+go_tab);



}


</script>

{{-- Go To Tab Script End --}}
<!-- add experience radio -->
<script>
$('#primary_language').on('change', function () {
  var primary_lang = $('#primary_language').val();

  if (primary_lang == 'English') {
    
    $('#fluent_main_div').hide();
  } else {
    $('#fluent_main_div').show();
    
  }
});
  </script>

<!-- summary radio-->
<script>
  // document.addEventListener('DOMContentLoaded', () => {
  //     const radio4 = document.getElementById('radio4');
  //     const radio5 = document.getElementById('radio5');
  //     const radio6 = document.getElementById('radio6');
  //     const imageDiv1 = document.getElementById('imageDiv1');
  
  //     function toggleImage() {
  //         if (radio6.checked) {
  //             imageDiv1.style.display = 'none';
  //         } else {
  //             imageDiv1.style.display = 'block';
  //         }
  //     }
  
  //     // Add event listeners to radio buttons
  //     radio4.addEventListener('change', toggleImage);
  //     radio5.addEventListener('change', toggleImage);
  //     radio6.addEventListener('change', toggleImage);
  
  //     // Initial check
  //     toggleImage();
  // });
  
  </script>
<!-- I don -->
<script>
  // $(function () {
  //   AOS.init();
  //   var scrollSpy;
  //   var hash = window.location.hash;
  //   hash && $('#side-menu>li>a[href="' + hash + '"]').tab("show");
  //   console.log(hash);
  //   $("#side-menu>li>a").click(function (e) {
  //     e.preventDefault();
        
  //     $(this).tab("show");
  //     window.location.hash = this.hash;
   
      
  //     if (this.hash == "#tab1") {
  //       if ($("#tab1-tab").hasClass("active")) {
  //         $("#tab1-programs").addClass("show");
  //         scrollSpy = new bootstrap.ScrollSpy(document.body, {
  //           target: "#tab1-programs",
  //         });
  //       }
  //     } else {
  //       $("#tab1-programs").removeClass("show");
  //       scrollSpy.dispose();
  //     }
  //   });
  //   if ($("#tab1-tab").hasClass("active")) {
  //     $("#tab1-programs").addClass("show");
  //     scrollSpy = new bootstrap.ScrollSpy(document.body, {
  //       target: "#tab1-programs",
  //     });
  //   }
  // });
</script>
<script>
  // File Upload
  //
  function readURL(input) {

    if (input.files && input.files[0]) {
      
        if(input.files[0].size > 1048576) {
       alert("Maximmum Image Size 1MB Allowed!");
       input.value = "";
       return false;
    }
      var reader = new FileReader();
      reader.onload = function (e) {

            
         var image = new Image();
          //Set the Base64 string return from FileReader as source.
         image.src = e.target.result;
         let data;
          image.onload = function () {
              //Determine the Height and Width.
             var height = this.height;
             var width = this.width;
               data = "true"; 
                   
                 
               };
              
               
               setTimeout(() => {
                 if (data == "true") {
                   
                  $("#imagePreview").css(
                "background-image",
                "url(" + e.target.result + ")"
              );
              $("#imagePreview").hide();
              $("#imagePreview").fadeIn(650);
                   
                 } }, 10);

 
        
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#imageUpload").change(function () {
    
    
    readURL(this);
  });
</script>
<script>
  $(document).ready(function () {
    var maxField = 10; //Input fields increment limitation
    var addButton = $(".add_button"); //Add button selector
    var wrapper = $(".field_wrapper"); //Input field wrapper
    var fieldHTML =
      '<div class="d-flex mt-2"><input type="text" name="field_name[]" value="" class="form-control" style="width:95%" placeholder="https://bravemindstudio.com/"/><a href="javascript:void(0);" class="remove_button"><img src="assets/expert/asset/img/remove-icon.svg"/></a></div>'; //New input field html
    var x = 1; //Initial field counter is 1
    // Once add button is clicked
    $(addButton).click(function () {
      //Check maximum number of input fields
      if (x < maxField) {
        x++; //Increase field counter
        $(wrapper).append(fieldHTML); //Add field html
      } else {
        alert("A maximum of " + maxField + " fields are allowed to be added. ");
      }
    });
    // Once remove button is clicked
    $(wrapper).on("click", ".remove_button", function (e) {
      e.preventDefault();
      $(this).parent("div").remove(); //Remove field html
      x--; //Decrease field counter
    });
  });
</script>
<script>
  /* Bootstrap 5 JS included */

  // console.clear();
  ("use strict");

  // Drag and drop - single or multiple image files
  // https://www.smashingmagazine.com/2018/01/drag-drop-file-uploader-vanilla-js/
  // https://codepen.io/joezimjs/pen/yPWQbd?editors=1000
  (function () {
    "use strict";

    // Four objects of interest: drop zones, input elements, gallery elements, and the files.
    // dataRefs = {files: [image files], input: element ref, gallery: element ref}

    const preventDefaults = (event) => {
      event.preventDefault();
      event.stopPropagation();
    };

    const highlight = (event) => event.target.classList.add("highlight");

    const unhighlight = (event) => event.target.classList.remove("highlight");

    const getInputAndGalleryRefs = (element) => {
      const zone = element.closest(".upload_dropZone") || false;
      const gallery = zone.querySelector(".upload_gallery") || false;
      const input = zone.querySelector('input[type="file"]') || false;
      return { input: input, gallery: gallery };
    };

    const handleDrop = (event) => {
      const dataRefs = getInputAndGalleryRefs(event.target);
      dataRefs.files = event.dataTransfer.files;
      handleFiles(dataRefs);
    };

    const eventHandlers = (zone) => {
      const dataRefs = getInputAndGalleryRefs(zone);
      if (!dataRefs.input) return;

      // Prevent default drag behaviors
      ["dragenter", "dragover", "dragleave", "drop"].forEach((event) => {
        zone.addEventListener(event, preventDefaults, false);
        document.body.addEventListener(event, preventDefaults, false);
      });

      // Highlighting drop area when item is dragged over it
      ["dragenter", "dragover"].forEach((event) => {
        zone.addEventListener(event, highlight, false);
      });
      ["dragleave", "drop"].forEach((event) => {
        zone.addEventListener(event, unhighlight, false);
      });

      // Handle dropped files
      zone.addEventListener("drop", handleDrop, false);

      // Handle browse selected files
      dataRefs.input.addEventListener(
        "change",
        (event) => {
          dataRefs.files = event.target.files;
          handleFiles(dataRefs);
        },
        false
      );
    };

    // Initialise ALL dropzones
    const dropZones = document.querySelectorAll(".upload_dropZone");
    for (const zone of dropZones) {
      eventHandlers(zone);
    }

    // No 'image/gif' or PDF or webp allowed here, but it's up to your use case.
    // Double checks the input "accept" attribute
    const isImageFile = (file) =>
      ["image/jpeg", "image/png", "image/svg+xml"].includes(file.type);

    function previewFiles(dataRefs) {
      if (!dataRefs.gallery) return;
      for (const file of dataRefs.files) {
        let reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onloadend = function () {
          let img = document.createElement("img");
          img.className = "upload_img mt-2";
          img.setAttribute("alt", file.name);
          img.src = reader.result;
          dataRefs.gallery.appendChild(img);
        };
      }
    }

    // Based on: https://flaviocopes.com/how-to-upload-files-fetch/
    const imageUpload = (dataRefs) => {
      // Multiple source routes, so double check validity
      if (!dataRefs.files || !dataRefs.input) return;

      const url = dataRefs.input.getAttribute("data-post-url");
      if (!url) return;

      const name = dataRefs.input.getAttribute("data-post-name");
      if (!name) return;

      const formData = new FormData();
      formData.append(name, dataRefs.files);

      fetch(url, {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          console.log("posted: ", data);
          if (data.success === true) {
            previewFiles(dataRefs);
          } else {
            console.log("URL: ", url, "  name: ", name);
          }
        })
        .catch((error) => {
          console.error("errored: ", error);
        });
    };

    // Handle both selected and dropped files
    const handleFiles = (dataRefs) => {
      let files = [...dataRefs.files];

      // Remove unaccepted file types
      files = files.filter((item) => {
        if (!isImageFile(item)) {
          console.log("Not an image, ", item.type);
        }
        return isImageFile(item) ? item : null;
      });

      if (!files.length) return;
      dataRefs.files = files;

      previewFiles(dataRefs);
      imageUpload(dataRefs);
    };
  })();
</script>
<!-- ===================== multiselect script  ====================================== -->
<script>


function getServiceDetail(Clicked) {


  var tab = $('#'+Clicked).data('tab');
if (tab == 1) {
  let input = document.getElementById("imageUpload");
  var first_name =   $('#first_name').val();
  var last_name =   $('#last_name').val();
  var gender =   $('#gender').val();
  var profession =   $('#profession').val();
  var service_type =   $('#service_type').val();
  var service_role =   $('#service_role').val();
  var street_address =   $('#street_address').val();
  var ip_address =   $('#ip_address').val();
  var country_code =   $('#country_code').val();
  var country =   $('#country').val();
  var city =   $('#city').val();
  var zip_code =   $('#zip_code').val();
  var latitude =   $('#latitude').val();
  var longitude =   $('#longitude').val();

  if (input == '' || first_name == '' || last_name == '' || gender == ''  || profession == '' || country == '' || city == '' || street_address == ''  ) {
    toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.error("Please Fill All Fields for go Next Tab");
                    return false ;
  }

let profile_finel = document.getElementById("profile_finel");
profile_finel.files = input.files;
 
  if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#imagePreviewFinel").css(
          "background-image",
          "url(" + e.target.result + ")"
        );
        $("#imagePreviewFinel").hide();
        $("#imagePreviewFinel").fadeIn(650);
      };
      reader.readAsDataURL(input.files[0]);
    }

  
    $('#first_name_finel').val(first_name);
    $('#last_name_finel').val(last_name);
    $('#gender_finel').val(gender);
    $('#profession_finel').val(profession);
  
    $('#street_address_finel').val(street_address);
    $('#ip_address_finel').val(ip_address);
    $('#country_code_finel').val(country_code);
    $('#latitude_finel').val(latitude);
    $('#longitude_finel').val(longitude);
    $('#country_finel').val(country);
    $('#city_finel').val(city);
    $('#zip_code_finel').val(zip_code);

 

if (service_role == 'Both') {
  $('#class_main_div').show();
  $('#freelance_main_div').show();
  $('#freelance_cat_finel_div').show();
  $('#class_cat_finel_div').show();
} else if(service_role == 'Class') {
  $('#class_main_div').show();
  $('#freelance_main_div').hide();
  $('#freelance_cat_finel_div').hide();
  $('#class_cat_finel_div').show();
} else if(service_role == 'Freelance') {
  $('#class_main_div').hide();
  $('#freelance_main_div').show();
  $('#freelance_cat_finel_div').show();
  $('#class_cat_finel_div').hide();
}

 
var finel_service_type = $('#service_type_finel').val();
var finel_service_role = $('#service_role_finel').val();

if (service_type !== finel_service_type || service_role !== finel_service_role) {
  

  $('#multiSelectDropdown').html('--select category--');
      $('#multiSelectDropdown1').html('--select sub-category--');
      $('#multiSelectDropdown2').html('--select category--');
      $('#multiSelectDropdown3').html('--select sub-category--');
      $('#SubOnlineClass').html('');
      $('#SubInpersonClass').html('');
      $('#SubOnlineFreelance').html('');
      $('#SubInpersonFreelance').html('');


$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "post",
                url: '/get-services-for-expert',
                data:{ service_role:service_role, service_type:service_type, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {
                 
                  ShowCategories(response);
               

                },
              
            });

          } 

          $('#service_type_finel').val(service_type);
          $('#service_role_finel').val(service_role);
  
} else if(tab == 2) {
  var class_cate =   $('#multiSelectDropdown').html();
  var class_sub_cate =   $('#multiSelectDropdown1').html();
  var freelance_cate =   $('#multiSelectDropdown2').html();
  var freelance_sub_cate =   $('#multiSelectDropdown3').html();
  var cls_sub_val = $('#cls_sub_val').val();
  var fls_sub_val = $('#fls_sub_val').val();
  var class_term = $('#class_term').val();
  var freelance_term = $('#freelance_term').val();
  var class_error =   $('#class_error').html();
  var sub_class_error =   $('#sub_class_error').html();
  var freelance_error =   $('#freelance_error').html();
  var sub_freelance_error =   $('#sub_freelance_error').html();
  var service_role = $('#service_role').val();
  var class_cate_ids = $('#ClassCateIds').val();
  var freelance_cate_ids = $('#FreelanceCateIds').val();
   
  if (class_error  != '' || sub_class_error  != '' || freelance_error  != '' ||  sub_freelance_error  != '') {
    toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.error("You Selected Extra Categories");
                    return false ;
  }

  if (service_role == 'Class') {
    if (class_cate == '--select category--' || class_sub_cate == '--select sub-category--' || class_term == '' ) {
    toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.error("Please Fill All Fields for go Next Tab");
                    return false ;
  }
  }else if (service_role == 'Freelance'){
    if ( freelance_cate == '--select category--'  || freelance_sub_cate == '--select sub-category--' || freelance_term == '' ) {
    toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.error("Please Fill All Fields for go Next Tab");
                    return false ;
  }
  }else{
    if ( class_cate == '--select category--' || class_sub_cate == '--select sub-category--' || class_term == '' || freelance_cate == '--select category--'  || freelance_sub_cate == '--select sub-category--' || freelance_term == '' ) {
    toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.error("Please Fill All Fields for go Next Tab");
                    return false ;
  }
  }
  

  $('#class_term_finel').val(class_term);
  $('#freelance_term_finel').val(freelance_term);

  if (class_cate != '--select category--') {
     
    $('#class_cate_ids_finel').val(class_cate_ids);
    $('#class_category_finel').val(class_cate);
  }
  if (class_sub_cate != '--select sub-category--') {
 
    $('#class_sub_category_finel').val(class_sub_cate);
    $('#cls_sub_val_finel').val(cls_sub_val);
  }
  if (freelance_cate != '--select category--') {
    
    $('#freelance_cate_ids_finel').val(freelance_cate_ids);
    $('#freelance_category_finel').val(freelance_cate);
  }
  if (freelance_sub_cate != '--select sub-category--') {
    $('#freelance_sub_category_finel').val(freelance_sub_cate);
    $('#fls_sub_val_finel').val(fls_sub_val);
  }

  function getUniqueString(all_cates) {
    // Split the string by commas, trim the values, and use Set to filter unique values
    let uniqueValues = [...new Set(all_cates.split(',').map(item => item.trim()))];
    
    // Join the unique values back into a string
    return uniqueValues.join(',');
}

 
  if (freelance_cate != '--select category--' && class_cate == '--select category--') {
   var freelance_cates = freelance_cate;
   var all_cates = freelance_cates.replace(/,\s+/g, ',');

  }  
   if(class_cate != '--select category--' && freelance_cate == '--select category--'){
    class_cates = class_cate;
    var all_cates = class_cates.replace(/,\s+/g, ',');
    
  } 
  if (freelance_cate != '--select category--' && class_cate != '--select category--') {
    var freelance_cates = freelance_cate;
    var class_cates = class_cate;
    let array1 = freelance_cates.split(',');
    let array2 = class_cates.split(',');
    let combinedArray = [...new Set([...array1, ...array2])];
    let CategoriesArray = combinedArray.map(category => category.trim());
    let uniqueCategories = [...new Set(CategoriesArray)];
    var all_cates = uniqueCategories.join(',');
     all_cates = all_cates.replace(/,\s+/g, ',');
  } 
  
  all_cates = getUniqueString(all_cates);
  

  let all_cates_array = all_cates.split(',');
 $('#Experience_main_div').empty();
 $('#portfolio_url_div').empty();
 
 var set_html = '';
 var set_html_url = '';
 all_cates_array.forEach((element, index) => {
    

    set_html += '<div class="col-md-12"> '+
              '<label class="form-label" '+ 
               ' >How many years of experience do you have in '+
               ' '+element+'? <span>*</span></label> '+
              '<select class="form-select" id="experience_'+index+'" '+
              '  aria-label="Default select example" > ';
                 for (let j = 0; j < 30 ; j++) {
                    
         set_html +=   '  <option value="'+j+'">'+j+'</option> ';
                  }
               
      set_html +=  ' </select> '+
           ' </div>';



    set_html_url += '<div class="col-md-12 field_wrapper date-time" id="imageDiv"> '+
                    ' <label class="form-label">'+element+' URL <span>*</span></label> '+
                    ' <input type="hidden" id="array_url_'+index+'" /> '+
                    ' <div class="d-flex"> '+
                    '   <input class="add-input form-control" '+
                    '     type="text" '+
                    '     name="field_nam" '+
                    '     value="" id="url'+index+'" '+
                    '     placeholder="https://bravemindstudio.com/" /> '+
                    '   <a href="javascript:void(0);"  class="ad_button"  onclick="AddPortfolioUrl(this.id)" id="portfolio_links_'+index+'" title="Add field"  >'+
                     '     <img src="assets/expert/asset/img/add-input.svg" />'+
                    '    </a> </div>  <div id="portfolio_links_'+index+'_all"></div> '+
                    '</div>';


          });
          $('#Experience_main_div').append(set_html);
          $('#portfolio_url_div').append(set_html_url);
 


}else if(tab == 3){


  function getUniqueString(all_cates) {
    // Split the string by commas, trim the values, and use Set to filter unique values
    let uniqueValues = [...new Set(all_cates.split(',').map(item => item.trim()))];
    
    // Join the unique values back into a string
    return uniqueValues.join(',');
}

  var class_cate =   $('#multiSelectDropdown').html();
  var freelance_cate =   $('#multiSelectDropdown2').html();
  var service_role = $('#service_role').val();

  if (freelance_cate != '--select category--' && class_cate == '--select category--') {
   var freelance_cates = freelance_cate;
   var all_cates = freelance_cates.replace(/,\s+/g, ',');

  }  
   if(class_cate != '--select category--' && freelance_cate == '--select category--'){
    class_cates = class_cate;
    var all_cates = class_cates.replace(/,\s+/g, ',');
    
  } 
  if (freelance_cate != '--select category--' && class_cate != '--select category--') {
    var freelance_cates = freelance_cate;
    var class_cates = class_cate;
    let array1 = freelance_cates.split(',');
    let array2 = class_cates.split(',');
    let combinedArray = [...new Set([...array1, ...array2])];
    let CategoriesArray = combinedArray.map(category => category.trim());
    let uniqueCategories = [...new Set(CategoriesArray)];
    var all_cates = uniqueCategories.join(',');
     all_cates = all_cates.replace(/,\s+/g, ',');
  } 
  
  all_cates = getUniqueString(all_cates);

  var portfolio = $('#portfolio').val();
  let all_cates_array = all_cates.split(',');
  var url_values = '';
  var  set_html_experience = '' ;
  var FinelExperienceArray = [];

  all_cates_array.forEach((element, index) => {
    var experience = $('#experience_'+index+'').val();
    set_html_experience += '<div class="col-md-12 field_wrapper date-time"> '+
                    ' <label class="form-label">How many years of experience do you have in '+element+'? <span>*</span></label> '+
                    ' <div class="d-flex"> '+
                    '   <input class="add-input form-control" '+
                    '     type="text" '+
                    '     name="field_nam" '+
                    '     value="'+experience+'" id="finel_experience_'+index+'" '+
                    '     placeholder="https://bravemindstudio.com/" /> '+
                    '   </div> '+
                    '</div>';
         FinelExperienceArray.push(experience);

  });

  let joinedExperience = FinelExperienceArray.join(',');
     
  
$('#finel_experience').val(joinedExperience);

  $('#Experience_main_div_finel').append(set_html_experience);

  if (portfolio != 'not_link') {

    // Sett Multiple string into objec multiple array as a string==
    function convertStringToBracketedArray(str) {
    // Split the string by multiple spaces
    var groups = str.split(/\s+/);
    
    // Map over each group, adding brackets
    var bracketedGroups = groups.map(function(group) {
        return '[' + group + ']';
    });
    
    // Join all bracketed groups with commas
    var finalString = bracketedGroups.join('|*|');
    
    return finalString;
}

    var  set_html_url = '' ;
    var url_values = '';
    all_cates_array.forEach((element, index) => {

      var urls = $('#array_url_'+index+'').val();
      if (urls != '') {
        if (index == 0) {
        url_values += urls ;
      } else {
        url_values += ' '+urls ;
      }
      }
      
  }); 
 var result = convertStringToBracketedArray(url_values);

 var urls_result_array = result.split('|*|');
 if (all_cates_array.length != urls_result_array.length) {
  toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.error("Portfolio All Url's Required!");
                    return false ;
 }
 

 all_cates_array.forEach((element, index) => {

var urls = $('#array_url_'+index+'').val();
var urls_array = urls.split(',_,');

set_html_url+= '<div class="col-md-12 field_wrapper date-time"> '+
                ' <label class="form-label">'+element+' Url <span>*</span></label> ';
           for (let j = 0; j < urls_array.length; j++) {
            const url_set = urls_array[j];
   set_html_url += ' <div class="d-flex mb-2"> '+
                '   <input class="add-input form-control" '+
                '     type="text" '+
                '     name="field_nam" '+
                '     value="'+url_set+'" id="finel_url_'+j+'" '+
                '     placeholder="https://bravemindstudio.com/" /> '+
                '   </div> ';
           }   

   set_html_url += '</div>';

}); 

 
 
  $('#imageDiv1').append(set_html_url);
 
 
$('#portfolio_url_finel').val(result);
 $('#imageDiv1').show();
    
  } else {
    $('#imageDiv1').hide();
  }
 
  $('#portfolio_finel').val(portfolio);



}else if(tab == 4){
    var primary_language = $('#primary_language').val();
    var english_language = $('#english_language').val();
    var other_language = $('#multiSelectDropdown4').html();
    
    if ($('#speak_other_language').attr('checked')) { 
    if (other_language == '--select Language--' || primary_language == '') {
      toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.error("Please Fill All Fields for go Next Tab");
                    return false ;
    }
    other_language = other_language.replace(/,\s+/g, ',');
    
    $('#other_language_finel').val(other_language);
    $('#speak_other_language_finel').attr('checked', 1);
    $('#speak_other_language_finel').val(1);
    $('#other_language_main_div_finel').show();
  }else{
    $('#other_language_main_div_finel').hide();
    $('#other_language_finel').val('');
    $('#speak_other_language_finel').removeAttr('checked');
    $('#speak_other_language_finel').val(0);
  }
  if (primary_language == 'English') {
      $('#english_language_finel').val('');
      $('#english_language_finel_main_div').hide();
    }else{
      $('#english_language_finel_main_div').show();
      $('#english_language_finel').val(english_language);

    }
    $('#primary_language_finel').val(primary_language);
    
}else if(tab == 5){
  var overview = $('#overview').val();
  var about_me = $('#about_me').val();
  if (overview == '' || about_me == '') {
      toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.error("Please Fill All Fields for go Next Tab");
                    return false ;
    }
  $('#overview_finel').val(overview);
  $('#about_me_finel').val(about_me);
}else if(tab == 6){

  let main_image = document.getElementById("post-thumbnail");
  let image_1 = document.getElementById("post-thumbnail1");
  let image_2 = document.getElementById("post-thumbnail2");
  let image_3 = document.getElementById("post-thumbnail3");
  let image_4 = document.getElementById("post-thumbnail4");
  let image_5 = document.getElementById("post-thumbnail5");
  let image_6 = document.getElementById("post-thumbnail6");
  let video = document.getElementById("post-thumbnail7");
  
  var fileInputIds = ['post-thumbnail1', 'post-thumbnail2', 'post-thumbnail3', 'post-thumbnail4', 'post-thumbnail5', 'post-thumbnail6'];

  function isAnyImageSelected(fileInputIds) {
    return fileInputIds.some(function(id) {
        var fileInput = document.getElementById(id);
        if (fileInput.files.length > 0) {
            var file = fileInput.files[0];
            return file.type.startsWith('image/');
        }
        return false;
    });
}




  if (!isAnyImageSelected(fileInputIds)) {
         toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.error("At least one Image Required from More Images.");
                    return false ;
    }


  if (main_image.files.length == 0 ) {
      toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.error("Main Image is Required.");
                    return false ;
    }



let main_image_finel = document.getElementById("main_image_finel");
main_image_finel.files = main_image.files;
 
  if (main_image.files && main_image.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#main_image_show").css(
          "background-image",
          "url(" + e.target.result + ")"
        );
        $("#main_image_show").hide();
        $("#main_image_show").fadeIn(650);
      };
      reader.readAsDataURL(main_image.files[0]);
    }


   
let image_1_finel = document.getElementById("image_1_finel");
image_1_finel.files = image_1.files;
 
  if (image_1.files && image_1.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#image_1_show").css(
          "background-image",
          "url(" + e.target.result + ")"
        );
        $("#image_1_show").hide();
        $("#image_1_show").fadeIn(650);
      };
      reader.readAsDataURL(image_1.files[0]);
    }


    
let image_2_finel = document.getElementById("image_2_finel");
image_2_finel.files = image_2.files;
 
  if (image_2.files && image_2.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#image_2_show").css(
          "background-image",
          "url(" + e.target.result + ")"
        );
        $("#image_2_show").hide();
        $("#image_2_show").fadeIn(650);
      };
      reader.readAsDataURL(image_2.files[0]);
    }


   
let image_3_finel = document.getElementById("image_3_finel");
image_3_finel.files = image_3.files;
 
  if (image_3.files && image_3.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#image_3_show").css(
          "background-image",
          "url(" + e.target.result + ")"
        );
        $("#image_3_show").hide();
        $("#image_3_show").fadeIn(650);
      };
      reader.readAsDataURL(image_3.files[0]);
    }


     
let image_4_finel = document.getElementById("image_4_finel");
image_4_finel.files = image_4.files;
 
  if (image_4.files && image_4.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#image_4_show").css(
          "background-image",
          "url(" + e.target.result + ")"
        );
        $("#image_4_show").hide();
        $("#image_4_show").fadeIn(650);
      };
      reader.readAsDataURL(image_4.files[0]);
    }


     
let image_5_finel = document.getElementById("image_5_finel");
image_5_finel.files = image_5.files;
 
  if (image_5.files && image_5.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#image_5_show").css(
          "background-image",
          "url(" + e.target.result + ")"
        );
        $("#image_5_show").hide();
        $("#image_5_show").fadeIn(650);
      };
      reader.readAsDataURL(image_5.files[0]);
    }


    
let image_6_finel = document.getElementById("image_6_finel");
image_6_finel.files = image_6.files;
 
  if (image_6.files && image_6.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#image_6_show").css(
          "background-image",
          "url(" + e.target.result + ")"
        );
        $("#image_6_show").hide();
        $("#image_6_show").fadeIn(650);
      };
      reader.readAsDataURL(image_6.files[0]);
    }



    
let video_finel = document.getElementById("video_finel");
video_finel.files = video.files;
 
  if (video.files && video.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
       var videoFile = e.target.result
        $('#video_finel_show').attr('src', videoFile);
     
      };
      reader.readAsDataURL(video.files[0]);
    }




}else if(tab == 7){

  let option_1 = document.getElementById("post-thumbnail8");
  let option_2 = document.getElementById("post-thumbnail9");
 
  


var verification_center = $('#verification_center').val();
if (verification_center == 1) {
  let option_3 = document.getElementById("post-thumbnail10");
  let option_4 = document.getElementById("post-thumbnail11");
  
  if ( (option_1.files.length == 0 && option_2.files.length == 0) &&  
  (option_3.files.length == 0 || option_4.files.length == 0)) {
      toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.error("Minimmum 1 Verification Required!");
                    return false ;
    }



    let option_1_finel = document.getElementById("option_1_finel");



let option_2_finel = document.getElementById("option_2_finel");


let option_3_finel = document.getElementById("option_3_finel");

let option_4_finel = document.getElementById("option_4_finel");
option_4_finel.files = option_4.files;


if (option_1.files && option_1.files[0]) {
  $("#option_1_finel_show_main").show();
  $("#video_option_1_finel_show").show();
     var reader = new FileReader();
     reader.onload = function (e) {
      var videoFile = e.target.result
       $('#video_option_1_finel_show').attr('src', videoFile);
    
     };
     reader.readAsDataURL(option_1.files[0]);
     option_1_finel.files = option_1.files;
   }else {
    $("#option_1_finel_show_main").hide();
    $("#video_option_1_finel_show").hide(); // Hide the video element if no file
    option_1.value = ''; // Clear the input field
}


 

 if (option_2.files && option_2.files[0]) {
  $("#option_2_finel_show_main").show();
     var reader = new FileReader();
     reader.onload = function (e) {
       $("#option_2_finel_show").css(
         "background-image",
         "url(" + e.target.result + ")"
       );
       $("#option_2_finel_show").hide();
       $("#option_2_finel_show").fadeIn(650);
     };
     reader.readAsDataURL(option_2.files[0]);
     option_2_finel.files = option_2.files;
   }else{
    $("#option_2_finel_show_main").hide();
    $("#option_2_finel_show").hide();
    option_2_finel.value = '';
   }



if (option_3.files && option_3.files[0]) {
  $("#option_3_finel_show_main").show();
     var reader = new FileReader();
     reader.onload = function (e) {
       $("#option_3_finel_show").css(
         "background-image",
         "url(" + e.target.result + ")"
       );
       $("#option_3_finel_show").hide();
       $("#option_3_finel_show").fadeIn(650);
     };
     reader.readAsDataURL(option_3.files[0]);
     option_3_finel.files = option_3.files;

   }else{
    $("#option_3_finel_show_main").hide();
    $("#option_3_finel_show").hide();
    option_3_finel.value = '';
   }

   

if (option_4.files && option_4.files[0]) {
  $("#option_4_finel_show_main").show();
     var reader = new FileReader();
     reader.onload = function (e) {
       $("#option_4_finel_show").css(
         "background-image",
         "url(" + e.target.result + ")"
       );
       $("#option_4_finel_show").hide();
       $("#option_4_finel_show").fadeIn(650);
     };
     reader.readAsDataURL(option_4.files[0]);
     option_4_finel.files = option_4.files;

   }else{
    $("#option_4_finel_show_main").hide();
    $("#option_4_finel_show").hide();
    option_4_finel.value = '';
   }


} else{


  if ( option_1.files.length == 0 && option_2.files.length == 0) {
      toastr.options =
            {
                "closeButton" : true,
                 "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
            }
                    toastr.error("Minimmum 1 Verification Required!");
                    return false ;
    }


    let option_1_finel = document.getElementById("option_1_finel");
 
    let option_2_finel = document.getElementById("option_2_finel");
 

if (option_1.files && option_1.files[0]) {
  $("#option_1_finel_show_main").show();
  $("#video_option_1_finel_show").show();
     var reader = new FileReader();
     reader.onload = function (e) {
      var videoFile = e.target.result
       $('#video_option_1_finel_show').attr('src', videoFile);
    
     };
     reader.readAsDataURL(option_1.files[0]);
     option_1_finel.files = option_1.files;
   }else {
    $("#option_1_finel_show_main").hide();
    $("#video_option_1_finel_show").hide(); // Hide the video element if no file
    option_1.value = ''; // Clear the input field
}


 

 if (option_2.files && option_2.files[0]) {
  $("#option_2_finel_show_main").show();
     var reader = new FileReader();
     reader.onload = function (e) {
       $("#option_2_finel_show").css(
         "background-image",
         "url(" + e.target.result + ")"
       );
       $("#option_2_finel_show").hide();
       $("#option_2_finel_show").fadeIn(650);
     };
     reader.readAsDataURL(option_2.files[0]);
     option_2_finel.files = option_2.files;
   }else{
    $("#option_2_finel_show_main").hide();
    $("#option_2_finel_show").hide();
    option_2_finel.value = '';
   }


}



 
 




}else if(tab == 8){
 
  var type = $('#app_type').val(); 
  if (type == 1) {
    $('#fast_track_main_finel').show();
    $('#normal_track_main_finel').hide();
  } else {
    $('#fast_track_main_finel').hide();
    $('#normal_track_main_finel').show();
  }
  $('#app_type_finel').val(type);
 


}




var activ_tab_ele = document.getElementsByClassName('nav-link active');
var active_tab_id =  $(activ_tab_ele).attr('id');
var active_numb = active_tab_id.match(/\d/g);
var  active_tab = active_numb.join("");
    var go_tab = parseInt(active_tab) + 1;
    
      $('.nav-link').removeClass('active');
      $('.tab-pane').removeClass('show active');
      // $('#tab'+go_tab+'-tab').attr('data-bs-toggle', "pill");
       $('#tab'+go_tab+'-tab').addClass('active');
       $("#tab"+go_tab).addClass('show active');
      //  $('#tab'+go_tab+'-tab').attr('href', "#tab"+go_tab);
            
 

  }



  // Fetch Categories Show Script Start =========
  function ShowCategories(response) {
    
  
    $("#ClassCategories .OnlineClass").empty();
    $("#ClassCategories .InpersonClass").empty();
    $("#FreelanceCategories  .OnlineFreelance").empty();
    $("#FreelanceCategories  .InpersonFreelance").empty();
    

            if (response['service_type'] == 'Online') {

              var len = 0;
        if(response['services'] != null){
          len = response['services'].length;
        }
          if (len > 0 ) {

            // Setting for Categories
              $('#class_online_main_col').removeClass('col-md-6');
              $('#class_online_main_col').addClass('col-md-12');
              $('#class_online_main_col').css('border-right', '0');
              $('#class_inperson_main_col').hide();
              $('#class_online_main_col').show();

              $('#freelance_online_main_col').removeClass('col-md-6');
              $('#freelance_online_main_col').addClass('col-md-12');
              $('#freelance_online_main_col').css('border-right', '0');
              $('#freelance_inperson_main_col').hide();
              $('#freelance_online_main_col').show();
            
              // Setting For sub Categories
              $('#sub_class_online_main_col').removeClass('col-md-6');
              $('#sub_class_online_main_col').addClass('col-md-12');
              $('#sub_class_online_main_col').css('border-right', '0');
              $('#sub_class_inperson_main_col').hide();
              $('#sub_class_online_main_col').show();

              $('#sub_freelance_online_main_col').removeClass('col-md-6');
              $('#sub_freelance_online_main_col').addClass('col-md-12');
              $('#sub_freelance_online_main_col').css('border-right', '0');
              $('#sub_freelance_inperson_main_col').hide();
              $('#sub_freelance_online_main_col').show();
              



              for (let i = 0; i < len; i++) {
              var id = response['services'][i].id;
              var category = response['services'][i].category;
              var sub_category = response['services'][i].sub_category;
              var service_role = response['services'][i].service_role;
              var service_type = response['services'][i].service_type;
            //  var show_cate = category.replace(/\s*\(.*?\)/g, '');

            

        if (service_role == 'Class') {
 
            var content_div = '<div class="col-md-3">'+
                              '<li class="multi-text-li">'+
                               '<label onclick="SelectCateClass(this.id)" id="classcate_'+id+'"  data-cate_id="'+id+'" data-sub_category="'+sub_category+'" data-sub_category_type="Online" > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat-input class_'+id+'"  />'+category+'</label>'+
                              '</li> </div>';

        $("#ClassCategories .OnlineClass").append(content_div); 
     
 

         
        } else {
 
            var content_div = '<div class="col-md-3">'+
                              '<li class="multi-text-li">'+
                                '<label onclick="SelectCateFreelance(this.id)" id="freelancecate_'+id+'" data-cate_id="'+id+'"  data-sub_category="'+sub_category+'"  data-sub_category_type="Online"  > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat1-input freelance_'+id+'"  />'+category+'</label>'+
                              '</li> </div>';

        $("#FreelanceCategories .OnlineFreelance").append(content_div); 
            
         
        }

          
            }
          }

            } else if(response['service_type'] == 'Inperson'){

              var len = 0;
        if(response['services'] != null){
          len = response['services'].length;
        }
          if (len > 0 ) {
              
            // Setting For Categories
            $('#class_inperson_main_col').removeClass('col-md-6');
              $('#class_inperson_main_col').addClass('col-md-12');
              $('#class_online_main_col').hide();
              $('#class_inperson_main_col').show();
             
              $('#freelance_inperson_main_col').removeClass('col-md-6');
              $('#freelance_inperson_main_col').addClass('col-md-12');
              $('#freelance_online_main_col').hide();
              $('#freelance_inperson_main_col').show();
            
              // Settign for Sub Categories
            $('#sub_class_inperson_main_col').removeClass('col-md-6');
              $('#sub_class_inperson_main_col').addClass('col-md-12');
              $('#sub_class_online_main_col').hide();
              $('#sub_class_inperson_main_col').show();
             
              $('#sub_freelance_inperson_main_col').removeClass('col-md-6');
              $('#sub_freelance_inperson_main_col').addClass('col-md-12');
              $('#sub_freelance_online_main_col').hide();
              $('#sub_freelance_inperson_main_col').show();

            for (let i = 0; i < len; i++) {
              var id = response['services'][i].id;
              var category = response['services'][i].category;
              var sub_category = response['services'][i].sub_category;
              var service_role = response['services'][i].service_role;
              var service_type = response['services'][i].service_type;
             var show_cate = category.replace(/\s*\(.*?\)/g, '');

            

        if (service_role == 'Class') {

            var content_div = '<div class="col-md-3">'+
                              '<li class="multi-text-li">'+
                               '<label onclick="SelectCateClass(this.id)" id="classcate_'+id+'"  data-cate_id="'+id+'" data-sub_category="'+sub_category+'" data-sub_category_type="Inperson" > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat-input class_'+id+'"  />'+category+'</label>'+
                              '</li> </div>';

        $("#ClassCategories .InpersonClass").append(content_div); 
            
        } else {
 

            var content_div = '<div class="col-md-3">'+
                              '<li class="multi-text-li">'+
                                '<label onclick="SelectCateFreelance(this.id)" id="freelancecate_'+id+'"  data-cate_id="'+id+'" data-sub_category="'+sub_category+'"   data-sub_category_type="Inperson"  > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat1-input freelance_'+id+'"  />'+category+'</label>'+
                              '</li> </div>';

        $("#FreelanceCategories .InpersonFreelance").append(content_div); 
    
        }
          
            }

          }
            
          } else {
 

            // Setting for Categories ------
            $('#class_online_main_col').css('border-right', '3px solid rgb(0, 114, 177, 0.6)');
           $('#class_online_main_col').removeClass('col-md-12');
           $('#class_online_main_col').addClass('col-md-6');
           $('#class_inperson_main_col').removeClass('col-md-12');
           $('#class_inperson_main_col').addClass('col-md-6');
              $('#class_inperson_main_col').show();
              $('#class_online_main_col').show();

              $('#freelance_online_main_col').css('border-right', '3px solid rgb(0, 114, 177, 0.6)');
              $('#freelance_online_main_col').removeClass('col-md-12');
              $('#freelance_online_main_col').addClass('col-md-6');
              $('#freelance_inperson_main_col').removeClass('col-md-12');
              $('#freelance_inperson_main_col').addClass('col-md-6');
              $('#freelance_inperson_main_col').show();
              $('#freelance_online_main_col').show();

 

              // Setting for Sub Categories ------
            $('#sub_class_online_main_col').css('border-right', '3px solid rgb(0, 114, 177, 0.6)');
           $('#sub_class_online_main_col').removeClass('col-md-12');
           $('#sub_class_online_main_col').addClass('col-md-6');
           $('#sub_class_inperson_main_col').removeClass('col-md-12');
           $('#sub_class_inperson_main_col').addClass('col-md-6');
              $('#sub_class_inperson_main_col').show();
              $('#sub_class_online_main_col').show();

              $('#sub_freelance_online_main_col').css('border-right', '3px solid rgb(0, 114, 177, 0.6)');
              $('#sub_freelance_online_main_col').removeClass('col-md-12');
              $('#sub_freelance_online_main_col').addClass('col-md-6');
              $('#sub_freelance_inperson_main_col').removeClass('col-md-12');
              $('#sub_freelance_inperson_main_col').addClass('col-md-6');
              $('#sub_freelance_inperson_main_col').show();
              $('#sub_freelance_online_main_col').show();


              
              const servicesClassOnline = response['services_class_online'];
            const servicesClassInperson = response['services_class_inperson'];
              const servicesFreelanceOnline = response['services_freelance_online'];
            const servicesFreelanceInperson = response['services_freelance_inperson'];


            //  Get Common Categories in Class Start---------
             // Online Common
             const ClasscommonCategoriesOnline = servicesClassOnline.filter(item1 =>
             servicesClassInperson.some(item2 => item1.category === item2.category)
            );

                  // Online Unique
          const ClassuniqueCategoriesOnline = servicesClassOnline.filter(item1 =>
            !ClasscommonCategoriesOnline.some(item3 => item1.category === item3.category)
          );

            // Inperson Common
            const ClasscommonCategoriesInperson = servicesClassInperson.filter(item1 =>
            servicesClassOnline.some(item2 => item1.category === item2.category)
          );

              // Inperson Unique
              const ClassuniqueCategoriesInperson = servicesClassInperson.filter(item1 =>
              !ClasscommonCategoriesInperson.some(item3 => item1.category === item3.category)
            );


         // Online Common Sort
          ClasscommonCategoriesOnline.sort((a, b) => {
            const categoryA = a.category.toLowerCase();
            const categoryB = b.category.toLowerCase();
            return categoryA.localeCompare(categoryB);
          });
          // Unique
          ClassuniqueCategoriesOnline.sort((a, b) => {
            const categoryA = a.category.toLowerCase();
            const categoryB = b.category.toLowerCase();
            return categoryA.localeCompare(categoryB);
          });

    


          // Inperson Common Sort
          ClasscommonCategoriesInperson.sort((a, b) => {
            const categoryA = a.category.toLowerCase();
            const categoryB = b.category.toLowerCase();
            return categoryA.localeCompare(categoryB);
          });
          // Unique
          ClassuniqueCategoriesInperson.sort((a, b) => {
            const categoryA = a.category.toLowerCase();
            const categoryB = b.category.toLowerCase();
            return categoryA.localeCompare(categoryB);
          });

 
          //  Get Common Categories in Class END---------


            //  Get Common Categories in Freelance Start---------
            // Freelance Online Common
            const FreelancecommonCategoriesOnline = servicesFreelanceOnline.filter(item1 =>
            servicesFreelanceInperson.some(item2 => item1.category === item2.category)
          );

                 // Online Unique
          const FreelanceuniqueCategoriesOnline = servicesFreelanceOnline.filter(item1 =>
            !FreelancecommonCategoriesOnline.some(item3 => item1.category === item3.category)
          );

          // Freelance Inperson Common
            const FreelancecommonCategoriesInperson = servicesFreelanceInperson.filter(item1 =>
            servicesFreelanceOnline.some(item2 => item1.category === item2.category)
          );

             // Inperson Unique
                  // Online Unique
          const FreelanceuniqueCategoriesInperson = servicesFreelanceInperson.filter(item1 =>
            !FreelancecommonCategoriesInperson.some(item3 => item1.category === item3.category)
          );

              // Onlince Sort
          FreelancecommonCategoriesOnline.sort((a, b) => {
            const categoryA = a.category.toLowerCase();
            const categoryB = b.category.toLowerCase();
            return categoryA.localeCompare(categoryB);
          });
            // Unique
            FreelanceuniqueCategoriesOnline.sort((a, b) => {
            const categoryA = a.category.toLowerCase();
            const categoryB = b.category.toLowerCase();
            return categoryA.localeCompare(categoryB);
          });

          // Inperson Sort
          FreelancecommonCategoriesInperson.sort((a, b) => {
            const categoryA = a.category.toLowerCase();
            const categoryB = b.category.toLowerCase();
            return categoryA.localeCompare(categoryB);
          });
            // Unique
            FreelanceuniqueCategoriesInperson.sort((a, b) => {
            const categoryA = a.category.toLowerCase();
            const categoryB = b.category.toLowerCase();
            return categoryA.localeCompare(categoryB);
          });

          // Class Caategories
          var ClassCommonOnline = ClasscommonCategoriesOnline;
          var ClassCommonInperson = ClasscommonCategoriesInperson;
          var ClassUniqueOnline = ClassuniqueCategoriesOnline;
          var ClassUniqueInperson = ClassuniqueCategoriesInperson;
          
          // Freelance Caategories
          var FreelanceCommonOnline = FreelancecommonCategoriesOnline;
          var FreelanceCommonInperson = FreelancecommonCategoriesInperson;
          var FreelanceUniqueOnline = FreelanceuniqueCategoriesOnline;
          var FreelanceUniqueInperson = FreelanceuniqueCategoriesInperson;

          //  Get Common Categories in Freelacne END---------
 

           
              if (response['service'] == 'Both') {


          // Class Categories Show START=====

              // Class Online Common Categories Show Start ---

          var len_classonline = 0;
        if(ClassCommonOnline != null){
          len_classonline = ClassCommonOnline.length;
        }
          if (len_classonline > 0 ) {
              

            for (let i = 0; i < len_classonline; i++) {
              var id = ClassCommonOnline[i].id;
              var category = ClassCommonOnline[i].category;
              var sub_category = ClassCommonOnline[i].sub_category;
              var service_role = ClassCommonOnline[i].service_role;
              var service_type = ClassCommonOnline[i].service_type;
            //  var show_cate = category.replace(/\s*\(.*?\)/g, '');

             

            var content_div = '<div class="col-md-12">'+
                              '<li class="multi-text-li">'+
                               '<label onclick="SelectCateClass(this.id)"   id="classcate_'+id+'"  data-cate_id="'+id+'" data-class="cls_common_'+i+'"  data-cate_id="'+id+'" data-sub_category="'+sub_category+'" data-sub_category_type="Online" > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat-input class_'+id+' cls_common_'+i+'"  />'+category+'</label>'+
                              '</li> </div>';

        $("#ClassCategories .OnlineClass").append(content_div); 
       
          
            }

          }

          // Class Online Common Categories Show END ----

 
 
              // Class Online Unique Categories Show Start ---

          var len_classonlineunique = 0;
        if(ClassUniqueOnline != null){
          len_classonlineunique = ClassUniqueOnline.length;
        }
          if (len_classonlineunique > 0 ) {
              

            for (let i = 0; i < len_classonlineunique; i++) {
              var id = ClassUniqueOnline[i].id;
              var category = ClassUniqueOnline[i].category;
              var sub_category = ClassUniqueOnline[i].sub_category;
              var service_role = ClassUniqueOnline[i].service_role;
              var service_type = ClassUniqueOnline[i].service_type;
            //  var show_cate = category.replace(/\s*\(.*?\)/g, '');

             

            var content_div = '<div class="col-md-12">'+
                              '<li class="multi-text-li">'+
                               '<label onclick="SelectCateClass(this.id)" id="classcate_'+id+'" data-class="" data-cate_id="'+id+'" data-sub_category="'+sub_category+'" data-sub_category_type="Online" > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat-input class_'+id+'"  />'+category+'</label>'+
                              '</li> </div>';

        $("#ClassCategories .OnlineClass").append(content_div); 
       
          
            }

          }

          // Class Online Unique Categories Show END ----

 
              // Class Online Common Categories Show Start ---

          var len_classinperson = 0;
        if(ClassCommonInperson != null){
          len_classinperson = ClassCommonInperson.length;
        }
          if (len_classinperson > 0 ) {
              

            for (let i = 0; i < len_classinperson; i++) {
              var id = ClassCommonInperson[i].id;
              var category = ClassCommonInperson[i].category;
              var sub_category = ClassCommonInperson[i].sub_category;
              var service_role = ClassCommonInperson[i].service_role;
              var service_type = ClassCommonInperson[i].service_type;
            //  var show_cate = category.replace(/\s*\(.*?\)/g, '');

             

            var content_div = '<div class="col-md-12">'+
                              '<li class="multi-text-li">'+
                               '<label onclick="SelectCateClass(this.id)"   id="classcate_'+id+'" data-class="cls_common_'+i+'"  data-cate_id="'+id+'" data-sub_category="'+sub_category+'" data-sub_category_type="Inperson" > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat-input class_'+id+' cls_common_'+i+'"  />'+category+'</label>'+
                              '</li> </div>';

        $("#ClassCategories .InpersonClass").append(content_div); 
       
          
            }

          }

          // Class Inperson Common Categories Show END ----


              // Class Inperson Unique Categories Show Start ---

              var len_classinpersonunique = 0;
        if(ClassUniqueInperson != null){
          len_classinpersonunique = ClassUniqueInperson.length;
        }
          if (len_classinpersonunique > 0 ) {
              

            for (let i = 0; i < len_classinpersonunique; i++) {
              var id = ClassUniqueInperson[i].id;
              var category = ClassUniqueInperson[i].category;
              var sub_category = ClassUniqueInperson[i].sub_category;
              var service_role = ClassUniqueInperson[i].service_role;
              var service_type = ClassUniqueInperson[i].service_type;
            //  var show_cate = category.replace(/\s*\(.*?\)/g, '');

             

            var content_div = '<div class="col-md-12">'+
                              '<li class="multi-text-li">'+
                               '<label onclick="SelectCateClass(this.id)"  id="classcate_'+id+'"  data-class="" data-cate_id="'+id+'" data-sub_category="'+sub_category+'" data-sub_category_type="Inperson" > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat-input class_'+id+'"  />'+category+'</label>'+
                              '</li> </div>';

        $("#ClassCategories .InpersonClass").append(content_div); 
       
          
            }

          }

          // Class Inperson Unique Categories Show END ----


      // Class Categories Show END=====



      
          // Freelance Categories Show START=====

              // Freelance Online Common Categories Show Start ---

          var len_freelanceonline = 0;
        if(FreelanceCommonOnline != null){
          len_freelanceonline = FreelanceCommonOnline.length;
        }
          if (len_freelanceonline > 0 ) {
              

            for (let i = 0; i < len_freelanceonline; i++) {
              var id = FreelanceCommonOnline[i].id;
              var category = FreelanceCommonOnline[i].category;
              var sub_category = FreelanceCommonOnline[i].sub_category;
              var service_role = FreelanceCommonOnline[i].service_role;
              var service_type = FreelanceCommonOnline[i].service_type;
            //  var show_cate = category.replace(/\s*\(.*?\)/g, '');

             

             var content_div = '<div class="col-md-12">'+
                              '<li class="multi-text-li">'+
                                '<label onclick="SelectCateFreelance(this.id)"  id="freelancecate_'+id+'" data-class="" data-cate_id="'+id+'" data-sub_category="'+sub_category+'"   data-sub_category_type="Online"  > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat1-input freelance_'+id+' fls_common_'+i+'"  />'+category+'</label>'+
                              '</li> </div>';

        $("#FreelanceCategories .OnlineFreelance").append(content_div); 
    
          
            }

          }

          // Freelance Online Common Categories Show END ----

 
 
              // Freelance Online Unique Categories Show Start ---

          var len_freelanceonlineunique = 0;
        if(FreelanceUniqueOnline != null){
          len_freelanceonlineunique = FreelanceUniqueOnline.length;
        }
          if (len_freelanceonlineunique > 0 ) {
              

            for (let i = 0; i < len_freelanceonlineunique; i++) {
              var id = FreelanceUniqueOnline[i].id;
              var category = FreelanceUniqueOnline[i].category;
              var sub_category = FreelanceUniqueOnline[i].sub_category;
              var service_role = FreelanceUniqueOnline[i].service_role;
              var service_type = FreelanceUniqueOnline[i].service_type;
            //  var show_cate = category.replace(/\s*\(.*?\)/g, '');

             

             var content_div = '<div class="col-md-12">'+
                              '<li class="multi-text-li">'+
                                '<label onclick="SelectCateFreelance(this.id)"  id="freelancecate_'+id+'" data-class="" data-cate_id="'+id+'" data-sub_category="'+sub_category+'"   data-sub_category_type="Online"  > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat1-input freelance_'+id+'"  />'+category+'</label>'+
                              '</li> </div>';

        $("#FreelanceCategories .OnlineFreelance").append(content_div); 
    
          
            }

          }

          // Freelance Online Unique Categories Show END ----

 
              // Freelance Online Common Categories Show Start ---

          var len_freelanceinperson = 0;
        if(FreelanceCommonInperson != null){
          len_freelanceinperson = FreelanceCommonInperson.length;
        }
          if (len_freelanceinperson > 0 ) {
              

            for (let i = 0; i < len_freelanceinperson; i++) {
              var id = FreelanceCommonInperson[i].id;
              var category = FreelanceCommonInperson[i].category;
              var sub_category = FreelanceCommonInperson[i].sub_category;
              var service_role = FreelanceCommonInperson[i].service_role;
              var service_type = FreelanceCommonInperson[i].service_type;
            //  var show_cate = category.replace(/\s*\(.*?\)/g, '');

             

             var content_div = '<div class="col-md-12">'+
                              '<li class="multi-text-li">'+
                                '<label onclick="SelectCateFreelance(this.id)"  id="freelancecate_'+id+'" data-class="fls_common_'+i+'" data-cate_id="'+id+'" data-sub_category="'+sub_category+'"   data-sub_category_type="Inperson"  > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat1-input freelance_'+id+' fls_common_'+i+'"  />'+category+'</label>'+
                              '</li> </div>';

        $("#FreelanceCategories .InpersonFreelance").append(content_div); 
   
          
            }

          }

          // Freelance Inperson Common Categories Show END ----


              // Freelance Inperson Unique Categories Show Start ---

              var len_freelanceinpersonunique = 0;
        if(FreelanceUniqueInperson != null){
          len_freelanceinpersonunique = FreelanceUniqueInperson.length;
        }
          if (len_freelanceinpersonunique > 0 ) {
              

            for (let i = 0; i < len_freelanceinpersonunique; i++) {
              var id = FreelanceUniqueInperson[i].id;
              var category = FreelanceUniqueInperson[i].category;
              var sub_category = FreelanceUniqueInperson[i].sub_category;
              var service_role = FreelanceUniqueInperson[i].service_role;
              var service_type = FreelanceUniqueInperson[i].service_type;
            //  var show_cate = category.replace(/\s*\(.*?\)/g, '');

             

             var content_div = '<div class="col-md-12">'+
                              '<li class="multi-text-li">'+
                                '<label onclick="SelectCateFreelance(this.id)"  id="freelancecate_'+id+'" data-class="" data-cate_id="'+id+'" data-sub_category="'+sub_category+'"   data-sub_category_type="Inperson"  > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat1-input freelance_'+id+'"  />'+category+'</label>'+
                              '</li> </div>';

        $("#FreelanceCategories .InpersonFreelance").append(content_div); 
    
          
            }

          }

          // Freelance Inperson Unique Categories Show END ----


      // Freelance Categories Show END=====



              }else if(response['service'] == 'Class')   {


                  // Class Categories Show START=====

              // Class Online Common Categories Show Start ---

          var len_classonline = 0;
        if(ClassCommonOnline != null){
          len_classonline = ClassCommonOnline.length;
        }
          if (len_classonline > 0 ) {
              

            for (let i = 0; i < len_classonline; i++) {
              var id = ClassCommonOnline[i].id;
              var category = ClassCommonOnline[i].category;
              var sub_category = ClassCommonOnline[i].sub_category;
              var service_role = ClassCommonOnline[i].service_role;
              var service_type = ClassCommonOnline[i].service_type;
            //  var show_cate = category.replace(/\s*\(.*?\)/g, '');

             

            var content_div = '<div class="col-md-12">'+
                              '<li class="multi-text-li">'+
                               '<label onclick="SelectCateClass(this.id)"  id="classcate_'+id+'" data-class="cls_common_'+i+'" data-cate_id="'+id+'" data-sub_category="'+sub_category+'" data-sub_category_type="Online" > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat-input class_'+id+' cls_common_'+i+'"  />'+category+'</label>'+
                              '</li> </div>';

        $("#ClassCategories .OnlineClass").append(content_div); 
       
          
            }

          }

          // Class Online Common Categories Show END ----

 
 
              // Class Online Unique Categories Show Start ---

          var len_classonlineunique = 0;
        if(ClassUniqueOnline != null){
          len_classonlineunique = ClassUniqueOnline.length;
        }
          if (len_classonlineunique > 0 ) {
              

            for (let i = 0; i < len_classonlineunique; i++) {
              var id = ClassUniqueOnline[i].id;
              var category = ClassUniqueOnline[i].category;
              var sub_category = ClassUniqueOnline[i].sub_category;
              var service_role = ClassUniqueOnline[i].service_role;
              var service_type = ClassUniqueOnline[i].service_type;
            //  var show_cate = category.replace(/\s*\(.*?\)/g, '');

             

            var content_div = '<div class="col-md-12">'+
                              '<li class="multi-text-li">'+
                               '<label onclick="SelectCateClass(this.id)" id="classcate_'+id+'" data-class="" data-cate_id="'+id+'" data-sub_category="'+sub_category+'" data-sub_category_type="Online" > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat-input class_'+id+'"  />'+category+'</label>'+
                              '</li> </div>';

        $("#ClassCategories .OnlineClass").append(content_div); 
       
          
            }

          }

          // Class Online Unique Categories Show END ----

 
              // Class Online Common Categories Show Start ---

          var len_classinperson = 0;
        if(ClassCommonInperson != null){
          len_classinperson = ClassCommonInperson.length;
        }
          if (len_classinperson > 0 ) {
              

            for (let i = 0; i < len_classinperson; i++) {
              var id = ClassCommonInperson[i].id;
              var category = ClassCommonInperson[i].category;
              var sub_category = ClassCommonInperson[i].sub_category;
              var service_role = ClassCommonInperson[i].service_role;
              var service_type = ClassCommonInperson[i].service_type;
            //  var show_cate = category.replace(/\s*\(.*?\)/g, '');

             

            var content_div = '<div class="col-md-12">'+
                              '<li class="multi-text-li">'+
                               '<label onclick="SelectCateClass(this.id)"  id="classcate_'+id+'" data-class="cls_common_'+i+'" data-cate_id="'+id+'" data-sub_category="'+sub_category+'" data-sub_category_type="Inperson" > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat-input class_'+id+' cls_common_'+i+'"  />'+category+'</label>'+
                              '</li> </div>';

        $("#ClassCategories .InpersonClass").append(content_div); 
       
          
            }

          }

          // Class Inperson Common Categories Show END ----


              // Class Inperson Unique Categories Show Start ---

              var len_classinpersonunique = 0;
        if(ClassUniqueInperson != null){
          len_classinpersonunique = ClassUniqueInperson.length;
        }
          if (len_classinpersonunique > 0 ) {
              

            for (let i = 0; i < len_classinpersonunique; i++) {
              var id = ClassUniqueInperson[i].id;
              var category = ClassUniqueInperson[i].category;
              var sub_category = ClassUniqueInperson[i].sub_category;
              var service_role = ClassUniqueInperson[i].service_role;
              var service_type = ClassUniqueInperson[i].service_type;
            //  var show_cate = category.replace(/\s*\(.*?\)/g, '');

             

            var content_div = '<div class="col-md-12">'+
                              '<li class="multi-text-li">'+
                               '<label onclick="SelectCateClass(this.id)"  id="classcate_'+id+'" data-class="" data-cate_id="'+id+'" data-sub_category="'+sub_category+'"  data-sub_category_type="Inperson" > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat-input class_'+id+'"  />'+category+'</label>'+
                              '</li> </div>';

        $("#ClassCategories .InpersonClass").append(content_div); 
       
          
            }

          }

          // Class Inperson Unique Categories Show END ----


      // Class Categories Show END=====




              }else if(response['service'] == 'Freelance')   {


                
      
          // Freelance Categories Show START=====

              // Freelance Online Common Categories Show Start ---

          var len_freelanceonline = 0;
        if(FreelanceCommonOnline != null){
          len_freelanceonline = FreelanceCommonOnline.length;
        }
          if (len_freelanceonline > 0 ) {
              

            for (let i = 0; i < len_freelanceonline; i++) {
              var id = FreelanceCommonOnline[i].id;
              var category = FreelanceCommonOnline[i].category;
              var sub_category = FreelanceCommonOnline[i].sub_category;
              var service_role = FreelanceCommonOnline[i].service_role;
              var service_type = FreelanceCommonOnline[i].service_type;
            //  var show_cate = category.replace(/\s*\(.*?\)/g, '');

             

             var content_div = '<div class="col-md-12">'+
                              '<li class="multi-text-li">'+
                                '<label onclick="SelectCateFreelance(this.id)"  id="freelancecate_'+id+'"  data-class="fls_common_'+i+'" data-cate_id="'+id+'" data-sub_category="'+sub_category+'"   data-sub_category_type="Online"  > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat1-input freelance_'+id+' fls_common_'+i+'"  />'+category+'</label>'+
                              '</li> </div>';

        $("#FreelanceCategories .OnlineFreelance").append(content_div); 
    
          
            }

          }

          // Freelance Online Common Categories Show END ----

 
 
              // Freelance Online Unique Categories Show Start ---

          var len_freelanceonlineunique = 0;
        if(FreelanceUniqueOnline != null){
          len_freelanceonlineunique = FreelanceUniqueOnline.length;
        }
          if (len_freelanceonlineunique > 0 ) {
              

            for (let i = 0; i < len_freelanceonlineunique; i++) {
              var id = FreelanceUniqueOnline[i].id;
              var category = FreelanceUniqueOnline[i].category;
              var sub_category = FreelanceUniqueOnline[i].sub_category;
              var service_role = FreelanceUniqueOnline[i].service_role;
              var service_type = FreelanceUniqueOnline[i].service_type;
            //  var show_cate = category.replace(/\s*\(.*?\)/g, '');

             

             var content_div = '<div class="col-md-12">'+
                              '<li class="multi-text-li">'+
                                '<label onclick="SelectCateFreelance(this.id)"  id="freelancecate_'+id+'"  data-class="" data-cate_id="'+id+'" data-sub_category="'+sub_category+'"   data-sub_category_type="Online"  > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat1-input freelance_'+id+'"  />'+category+'</label>'+
                              '</li> </div>';

        $("#FreelanceCategories .OnlineFreelance").append(content_div); 
    
          
            }

          }

          // Freelance Online Unique Categories Show END ----

 
              // Freelance Online Common Categories Show Start ---

          var len_freelanceinperson = 0;
        if(FreelanceCommonInperson != null){
          len_freelanceinperson = FreelanceCommonInperson.length;
        }
          if (len_freelanceinperson > 0 ) {
              

            for (let i = 0; i < len_freelanceinperson; i++) {
              var id = FreelanceCommonInperson[i].id;
              var category = FreelanceCommonInperson[i].category;
              var sub_category = FreelanceCommonInperson[i].sub_category;
              var service_role = FreelanceCommonInperson[i].service_role;
              var service_type = FreelanceCommonInperson[i].service_type;
            //  var show_cate = category.replace(/\s*\(.*?\)/g, '');

             

             var content_div = '<div class="col-md-12">'+
                              '<li class="multi-text-li">'+
                                '<label onclick="SelectCateFreelance(this.id)"  id="freelancecate_'+id+'" data-class="fls_common_'+i+'" data-cate_id="'+id+'" data-sub_category="'+sub_category+'"   data-sub_category_type="Inperson"  > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat1-input freelance_'+id+' fls_common_'+i+'"  />'+category+'</label>'+
                              '</li> </div>';

        $("#FreelanceCategories .InpersonFreelance").append(content_div); 
   
          
            }

          }

          // Freelance Inperson Common Categories Show END ----


              // Freelance Inperson Unique Categories Show Start ---

              var len_freelanceinpersonunique = 0;
        if(FreelanceUniqueInperson != null){
          len_freelanceinpersonunique = FreelanceUniqueInperson.length;
        }
          if (len_freelanceinpersonunique > 0 ) {
              

            for (let i = 0; i < len_freelanceinpersonunique; i++) {
              var id = FreelanceUniqueInperson[i].id;
              var category = FreelanceUniqueInperson[i].category;
              var sub_category = FreelanceUniqueInperson[i].sub_category;
              var service_role = FreelanceUniqueInperson[i].service_role;
              var service_type = FreelanceUniqueInperson[i].service_type;
            //  var show_cate = category.replace(/\s*\(.*?\)/g, '');

             

             var content_div = '<div class="col-md-12">'+
                              '<li class="multi-text-li">'+
                                '<label onclick="SelectCateFreelance(this.id)"  id="freelancecate_'+id+'" data-class="" data-cate_id="'+id+'" data-sub_category="'+sub_category+'"   data-sub_category_type="Inperson"  > <input type="checkbox" value="'+category+'" id="catecheck_'+id+'" class="cat1-input freelance_'+id+'"  />'+category+'</label>'+
                              '</li> </div>';

        $("#FreelanceCategories .InpersonFreelance").append(content_div); 
    
          
            }

          }

          // Freelance Inperson Unique Categories Show END ----


      // Freelance Categories Show END=====






              }

            



            }
            


   }
  // Fetch Categories Show Script END =========

  
 function SelectClassCategory() {
  const chBoxes = document.querySelectorAll(".dropdown-menu .cat-input");
  const dpBtn = document.getElementById("multiSelectDropdown");

 
  
  
  let mySelectedListItems = [];
   

  function handleCB() {
    mySelectedListItems = [];
    let mySelectedListItemsText = "";
    
    chBoxes.forEach((checkbox) => {
      if (checkbox.checked) {
        
        mySelectedListItems.push(checkbox.value);
        mySelectedListItemsText += checkbox.value + ", ";
      }
    });
     
 
     
    dpBtn.innerText =
      mySelectedListItems.length > 0
        ? mySelectedListItemsText.slice(0, -2)
        : "--select category--";
  }

  chBoxes.forEach((checkbox) => {
    checkbox.addEventListener("change", handleCB);
  });
  }

  
</script>


{{-- // Class Categories Selection with Rules and limits  and get Sub categories Script Start ========= --}}
{{-- // Class Categories Selection with Rules and limits  and get Sub categories Script Start ========= --}}
<script>
let selectedCategoriesClass = new Set(); // Global set to track selected categories
const maxCategoriesClass = 5; // Maximum allowed categories
 
function SelectCateClass(Clicked) {
    var click_cated = Clicked.split('_');
    var id = click_cated[1];
    const clickedCheckbox = document.getElementById("catecheck_" + id);
    const isChecked = clickedCheckbox.checked;
    
    const clickedCategoryLabel = clickedCheckbox.value; // Category without the (Online/Inperson)
    const ClasscorrespondingCheckbox = ClassgetCorrespondingCheckbox(clickedCategoryLabel, id); // Get corresponding checkbox from the other section
    var total_cates = $('#multiSelectDropdown').html();
    // var replace_cates_total = total_cates.replace(/\s*\(.*?\)/g, '');
    //  replace_cates_total = replace_cates_total.replace(/,\s+/g, ',');
     let uniqueString = [...new Set(total_cates.split(','))];
        
        
     let this_val = $(clickedCheckbox).val(); 
        //  this_val = this_val.replace(/\s*\(.*?\)/g, '');
        //  this_val = this_val.replace(/,\s+/g, ','); 
            
         if (uniqueString.includes(this_val.trim())) {
   
      } else {
        if (uniqueString.length > maxCategoriesClass && isChecked) {
            clickedCheckbox.checked = false;
              alert(`You can select a maximum of ${maxCategoriesClass} categories.`);
              return;
          }
      }


    
 
  

    // Add or remove category from selectedCategories set
     
    if (isChecked) {
      selectedCategoriesClass.add(clickedCategoryLabel);
        // If corresponding checkbox exists, select it too
        if (ClasscorrespondingCheckbox) ClasscorrespondingCheckbox.checked = true;
    } else { 
      selectedCategoriesClass.delete(clickedCategoryLabel);
       
    
        // Only deselect the clicked checkbox, don't uncheck the corresponding one
    }

    const checkboxesChecked = document.querySelectorAll('.cat-input'); // Select all category checkboxes
    let ClassAllSelectedCates = [];

    checkboxesChecked.forEach((checkbox) => {
        const categoryLabel = checkbox.id;
          ClasscorrespondingCheckboxID = checkbox; // Get the checkbox from the other section
         if (checkbox.checked) {
          var cate_id =checkbox.id;
          cate_id = cate_id.split('_');
          ClassAllSelectedCates.push(cate_id[1]);
          }
    });
    const ClsAllCates = ClassAllSelectedCates.join(",");
    $("#ClassCateIds").val(ClsAllCates);
 
    
    var service_type = $('#service_type').val();
    var service_role = $('#service_role').val();
    
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "post",
                url: '/get-class-sub-cates',
                data:{  ClsAllCates:ClsAllCates, service_role:service_role, service_type:service_type, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {
                 
                  ShowSubCatesCls(response);
               

                },
              
            });



    // Update the count or handle other UI changes if needed
}



// Function to get corresponding checkbox from the other section
function ClassgetCorrespondingCheckbox(category, currentId) {
    const checkboxes = document.querySelectorAll('.cat-input'); // Select all category checkboxes
    let ClasscorrespondingCheckbox = null;

    checkboxes.forEach((checkbox) => {
      const categoryLabel = checkbox.value;
      if (categoryLabel === category && checkbox.id !== `catecheck_${currentId}`) {
         if (categoryLabel.checked) {
           checkbox.checked = true;
         }
          ClasscorrespondingCheckbox = checkbox; // Get the checkbox from the other section
        }
    });

    return ClasscorrespondingCheckbox;
}


// Show Sub Categories and Selection Script Start  ========
function ShowSubCatesCls(response) {
    var subcatesonline = response['subcatesonline'];
    var subcatesinperson = response['subcatesinperson'];
    var service_type_val = $('#service_type').val();  // Fetch service type value
 

    // Helper function to group subcategories by category
    function findCommonAndUnique(subcatesonline, subcatesinperson) {
        const groupedCommon = {};
        const groupedUnique = { online: {}, inperson: {} };

        function groupByCategory(arr) {
            const grouped = {};
            arr.forEach(item => {
                if (!grouped[item.category]) {
                    grouped[item.category] = new Set();
                }
                grouped[item.category].add(item.sub_category);
            });
            return grouped;
        }

        const onlineGrouped = groupByCategory(subcatesonline);
        const inpersonGrouped = groupByCategory(subcatesinperson);

        // Find common and unique subcategories in each category
        Object.keys(onlineGrouped).forEach(category => {
            if (inpersonGrouped[category]) {
                const commonSubcategories = [...onlineGrouped[category]].filter(subcat => inpersonGrouped[category].has(subcat));
                if (commonSubcategories.length > 0) {
                    groupedCommon[category] = commonSubcategories;
                }

                const uniqueOnline = [...onlineGrouped[category]].filter(subcat => !inpersonGrouped[category].has(subcat));
                if (uniqueOnline.length > 0) {
                    groupedUnique.online[category] = uniqueOnline;
                }

                const uniqueInperson = [...inpersonGrouped[category]].filter(subcat => !onlineGrouped[category].has(subcat));
                if (uniqueInperson.length > 0) {
                    groupedUnique.inperson[category] = uniqueInperson;
                }
            } else {
                groupedUnique.online[category] = [...onlineGrouped[category]];
            }
        });

        Object.keys(inpersonGrouped).forEach(category => {
            if (!onlineGrouped[category]) {
                groupedUnique.inperson[category] = [...inpersonGrouped[category]];
            }
        });

        return { common: groupedCommon, unique: groupedUnique };
    }

    const { common, unique } = findCommonAndUnique(subcatesonline, subcatesinperson);
    var uniqueOnline = unique.online;
    var uniqueInperson = unique.inperson;

    $('#SubOnlineClass').empty();
    $('#SubInpersonClass').empty();

    const onlineSection = document.getElementById('SubOnlineClass');
    const inpersonSection = document.getElementById('SubInpersonClass');

    const allCategories = new Set([...Object.keys(common), ...Object.keys(uniqueOnline), ...Object.keys(uniqueInperson)]);

  // Update checkbox state with auto-selection for common subcategories
function updateCheckboxState(category, subcat, type, isCommon, isChecked) {
    const checkboxes = document.querySelectorAll(`input[data-category="${category}"][data-subcategory="${subcat}"]`);
    
    checkboxes.forEach(checkbox => {
        // Check the other side automatically if it's a common subcategory and checkbox is being selected
        if (isChecked && isCommon && checkbox.getAttribute('data-type') !== type) {
            checkbox.checked = true;
        }
        
        // HandleLimitSelection will ensure limits are enforced for each category
        handleLimitSelection(category);
    });
}

   // Function to limit subcategory selection to a max of 10 per category
function handleLimitSelection(category) {
    const checkboxes = document.querySelectorAll(`input[data-category="${category}"]`);
    const selectedSubcategories = new Set(); // To track unique selected subcategories
    const commonSelected = new Set();  // To track common subcategories selected in both sections
    const commonStatus = {}; // To track whether common subcategories are selected in any section

    // Count selected subcategories and track common subcategories
    checkboxes.forEach(cb => {
        const subcat = cb.getAttribute('data-subcategory');
        const isCommon = cb.getAttribute('data-common') === 'true';

        if (cb.checked) {
            if (isCommon) {
                commonSelected.add(subcat);  // Common subcategories count as one
                commonStatus[subcat] = true;  // Mark common subcategory as selected
            } else {
                selectedSubcategories.add(subcat);  // Unique subcategories count as one each
            }
        } else if (isCommon) {
            commonStatus[subcat] = commonStatus[subcat] || false;  // Mark common subcategory as unselected if not checked
        }
    });

    const totalSelected = selectedSubcategories.size + commonSelected.size;

    // Disable only unchecked checkboxes when the max limit is reached
    checkboxes.forEach(cb => {
        const subcat = cb.getAttribute('data-subcategory');
        const isCommon = cb.getAttribute('data-common') === 'true';

        // Disable checkboxes if limit reached, but keep enabled those that are already selected
        if (!cb.checked && totalSelected >= 10) {
            // Disable only if completely unselected in both sections (common or unique)
            if (!(isCommon && commonStatus[subcat])) {
                cb.disabled = true; // Disable completely unselected subcategories
            }
        } else {
            cb.disabled = false; // Ensure checked checkboxes and common ones selected on one side stay enabled
        }
    });
}

    // Iterate through all categories and render subcategories
    allCategories.forEach(category => {
        const hasCommon = common[category] && common[category].length > 0;
        const hasUniqueOnline = uniqueOnline[category] && uniqueOnline[category].length > 0;
        const hasUniqueInperson = uniqueInperson[category] && uniqueInperson[category].length > 0;

        if (hasCommon || hasUniqueOnline || hasUniqueInperson) {
            // ONLINE Section
            if (hasCommon || hasUniqueOnline) {
                const onlineCategoryContainer = document.createElement('div');
                const categoryHeadingOnline = document.createElement('div');
                categoryHeadingOnline.className = 'category-heading';
                categoryHeadingOnline.innerText = category;
                $(categoryHeadingOnline).css('color', '#096090d1');
                onlineCategoryContainer.appendChild(categoryHeadingOnline);

                const subcategoryListOnline = document.createElement('div');
                subcategoryListOnline.className = 'row';

                if (hasCommon) {
                    common[category].forEach(subcat => {
                        const checkbox = createCheckbox(category, subcat, 'Online', true);
                        subcategoryListOnline.appendChild(checkbox);
                    });
                }

                if (hasUniqueOnline) {
                    uniqueOnline[category].forEach(subcat => {
                        const checkbox = createCheckbox(category, subcat, 'Online', false);
                        subcategoryListOnline.appendChild(checkbox);
                    });
                }

                onlineCategoryContainer.appendChild(subcategoryListOnline);
                onlineSection.appendChild(onlineCategoryContainer);
            }

            // INPERSON Section
            if (hasCommon || hasUniqueInperson) {
                const inpersonCategoryContainer = document.createElement('div');
                const categoryHeadingInperson = document.createElement('div');
                categoryHeadingInperson.className = 'category-heading';
                categoryHeadingInperson.innerText = category;
                $(categoryHeadingInperson).css('color', '#096090d1');
                inpersonCategoryContainer.appendChild(categoryHeadingInperson);

                const subcategoryListInperson = document.createElement('div');
                subcategoryListInperson.className = 'row';

                if (hasCommon) {
                    common[category].forEach(subcat => {
                        const checkbox = createCheckbox(category, subcat, 'Inperson', true);
                        subcategoryListInperson.appendChild(checkbox);
                    });
                }

                if (hasUniqueInperson) {
                    uniqueInperson[category].forEach(subcat => {
                        const checkbox = createCheckbox(category, subcat, 'Inperson', false);
                        subcategoryListInperson.appendChild(checkbox);
                    });
                }

                inpersonCategoryContainer.appendChild(subcategoryListInperson);
                inpersonSection.appendChild(inpersonCategoryContainer);
            }
        }
    });

    // Helper function to create checkboxes
    function createCheckbox(category, subcat, type, isCommon) {
        const div_main = document.createElement('div');
        div_main.className = (service_type_val == 'Both') ? 'col-md-12 class_sub' : 'col-md-3 class_sub';
        const li = document.createElement('li');
        li.className = 'multi-text-li';
        const label = document.createElement('label');
        label.sub_category = subcat;
        label.sub_category_type = type;
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.name = 'subcategories[]';
        if (type == 'Inperson') {
          checkbox.className = 'subcat-input classsub clsin';
          
        } else {
          checkbox.className = 'subcat-input classsub clson';
          
        }
        checkbox.value = subcat;
        checkbox.setAttribute('data-category', category);
        checkbox.setAttribute('data-subcategory', subcat);
        checkbox.setAttribute('data-type', type);
        checkbox.setAttribute('data-common', isCommon);  // Flag for common subcategories

        checkbox.addEventListener('change', function() {
            updateCheckboxState(category, subcat, type, isCommon, checkbox.checked);
        });

        label.appendChild(checkbox);
        label.append(subcat);
        li.appendChild(label);
        div_main.appendChild(li);

        return div_main;
    }
}

 // Show Sub Categories and Selection Script END  ========




   function SelectClassCategorySub() {
    const chBoxes1 = document.querySelectorAll(".dropdown-menu .subcat-input");
    const chBoxes1in = document.querySelectorAll(".dropdown-menu .subcat-input.clsin");
    const chBoxes1on = document.querySelectorAll(".dropdown-menu .subcat-input.clson");
  const dpBtn1 = document.getElementById("multiSelectDropdown1");
  let mySelectedListItems1 = [];
     
    
  function handleCB() {
    mySelectedListItems1 = [];
    let mySelectedListItemsText1 = "";
    let ClsIn = [];
    let ClsOn = [];
    
    chBoxes1.forEach((checkbox) => {
      if (checkbox.checked) {
           
        mySelectedListItems1.push(checkbox.value);
        mySelectedListItemsText1 += checkbox.value + ", ";
        
      }
    });

      // Sub Category Online Get Selected
    chBoxes1on.forEach((checkbox) => {
      if (checkbox.checked) {
         ClsOn.push(checkbox.value);
        
      }
    });
    // SubCategory Inperson Get Selected
    chBoxes1in.forEach((checkbox) => {
      if (checkbox.checked) {
         ClsIn.push(checkbox.value);
        
      }
    });

    let resultSubOn = ClsOn.join(',');
    let resultSubIn = ClsIn.join(',');
    let sub_vals = resultSubOn + '|*|' + resultSubIn ;
    $('#cls_sub_val').val(sub_vals);

    dpBtn1.innerText =
      mySelectedListItems1.length > 0
        ? mySelectedListItemsText1.slice(0, -2)
        : "--select sub-category--";
  }
 

  chBoxes1.forEach((checkbox) => {
    checkbox.addEventListener("change", handleCB);
  });
     }
  

     
     
    </script>

{{-- // Class Categories Selection with Rules and limits  and get Sub categories Script END ========= --}}
{{-- // Class Categories Selection with Rules and limits  and get Sub categories Script END ========= --}}

<script>
  function SelectFreelanceCategory() { 
   
    const chBoxes2 = document.querySelectorAll(".dropdown-menu .cat1-input");
  const dpBtn2 = document.getElementById("multiSelectDropdown2");
  let mySelectedListItems2 = [];
  
   

  function handleCB() {
    mySelectedListItems2 = [];
    let mySelectedListItemsText2 = "";

    chBoxes2.forEach((checkbox) => {
      if (checkbox.checked) {

        mySelectedListItems2.push(checkbox.value);
        mySelectedListItemsText2 += checkbox.value + ", ";
      }
    }); 

    dpBtn2.innerText =
      mySelectedListItems2.length > 0
        ? mySelectedListItemsText2.slice(0, -2)
        : "--select category--";
  }

  chBoxes2.forEach((checkbox) => {
    checkbox.addEventListener("change", handleCB);
  });
   }
  
</script>




{{-- // Freelance Categories Selection with Rules and limits  and get Sub categories Script Start ========= --}}
{{-- // Freelance Categories Selection with Rules and limits  and get Sub categories Script Start ========= --}}
<script>
  let selectedCategoriesFreelance = new Set(); // Global set to track selected categories
  const maxCategoriesFreelance = 5; // Maximum allowed categories
   
  function SelectCateFreelance(Clicked) {
      var click_cated = Clicked.split('_');
      var id = click_cated[1];
      const clickedCheckbox = document.getElementById("catecheck_" + id);
      const isChecked = clickedCheckbox.checked;
      
      const clickedCategoryLabel = clickedCheckbox.value; // Category without the (Online/Inperson)
      const FreelancecorrespondingCheckbox = FreelancegetCorrespondingCheckbox(clickedCategoryLabel, id); // Get corresponding checkbox from the other section
      var total_cates = $('#multiSelectDropdown2').html();
      // var replace_cates_total = total_cates.replace(/\s*\(.*?\)/g, '');
      //  replace_cates_total = replace_cates_total.replace(/,\s+/g, ',');
       let uniqueString = [...new Set(total_cates.split(','))];
          
          
       let this_val = $(clickedCheckbox).val(); 
          //  this_val = this_val.replace(/\s*\(.*?\)/g, '');
          //  this_val = this_val.replace(/,\s+/g, ','); 
              
           if (uniqueString.includes(this_val.trim())) {
     
        } else {
          if (uniqueString.length > maxCategoriesFreelance && isChecked) {
              clickedCheckbox.checked = false;
                alert(`You can select a maximum of ${maxCategoriesFreelance} categories.`);
                return;
            }
        }
  
  
      
   
    
  
      // Add or remove category from selectedCategories set
       
      if (isChecked) {
        selectedCategoriesFreelance.add(clickedCategoryLabel);
          // If corresponding checkbox exists, select it too
          if (FreelancecorrespondingCheckbox) FreelancecorrespondingCheckbox.checked = true;
      } else { 
        selectedCategoriesFreelance.delete(clickedCategoryLabel);
         
      
          // Only deselect the clicked checkbox, don't uncheck the corresponding one
      }
  
      const checkboxesChecked = document.querySelectorAll('.cat1-input'); // Select all category checkboxes
      let FreelanceAllSelectedCates = [];
  
      checkboxesChecked.forEach((checkbox) => {
          const categoryLabel = checkbox.id;
          FreelancecorrespondingCheckboxID = checkbox; // Get the checkbox from the other section
           if (checkbox.checked) {
            var cate_id =checkbox.id;
            cate_id = cate_id.split('_');
            FreelanceAllSelectedCates.push(cate_id[1]);
            }
      });
      const FlsAllCates = FreelanceAllSelectedCates.join(",");
      $("#FreelanceCateIds").val(FlsAllCates);
   
      
      var service_type = $('#service_type').val();
      var service_role = 'Freelance';
      
      $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
              });
  
              $.ajax({
                  type: "post",
                  url: '/get-freelance-sub-cates',
                  data:{  FlsAllCates:FlsAllCates, service_role:service_role, service_type:service_type, _token: '{{csrf_token()}}'},
                  dataType: 'json',
                  success: function (response) {
                   
                    ShowSubCatesFls(response);
                 
  
                  },
                
              });
  
  
  
      // Update the count or handle other UI changes if needed
  }
  
  
  
  // Function to get corresponding checkbox from the other section
  function FreelancegetCorrespondingCheckbox(category, currentId) {
      const checkboxes = document.querySelectorAll('.cat1-input'); // Select all category checkboxes
      let FreelancecorrespondingCheckbox = null;
  
      checkboxes.forEach((checkbox) => {
        const categoryLabel = checkbox.value;
        if (categoryLabel === category && checkbox.id !== `catecheck_${currentId}`) {
           if (categoryLabel.checked) {
             checkbox.checked = true;
           }
           FreelancecorrespondingCheckbox = checkbox; // Get the checkbox from the other section
          }
      });
  
      return FreelancecorrespondingCheckbox;
  }
  
  
  // Show Sub Categories and Selection Script Start  ========
  function ShowSubCatesFls(response) {
      var subcatesonline = response['subcatesonline'];
      var subcatesinperson = response['subcatesinperson'];
      var service_type_val = $('#service_type').val();  // Fetch service type value
   
  
      // Helper function to group subcategories by category
      function findCommonAndUnique(subcatesonline, subcatesinperson) {
          const groupedCommon = {};
          const groupedUnique = { online: {}, inperson: {} };
  
          function groupByCategory(arr) {
              const grouped = {};
              arr.forEach(item => {
                  if (!grouped[item.category]) {
                      grouped[item.category] = new Set();
                  }
                  grouped[item.category].add(item.sub_category);
              });
              return grouped;
          }
  
          const onlineGrouped = groupByCategory(subcatesonline);
          const inpersonGrouped = groupByCategory(subcatesinperson);
  
          // Find common and unique subcategories in each category
          Object.keys(onlineGrouped).forEach(category => {
              if (inpersonGrouped[category]) {
                  const commonSubcategories = [...onlineGrouped[category]].filter(subcat => inpersonGrouped[category].has(subcat));
                  if (commonSubcategories.length > 0) {
                      groupedCommon[category] = commonSubcategories;
                  }
  
                  const uniqueOnline = [...onlineGrouped[category]].filter(subcat => !inpersonGrouped[category].has(subcat));
                  if (uniqueOnline.length > 0) {
                      groupedUnique.online[category] = uniqueOnline;
                  }
  
                  const uniqueInperson = [...inpersonGrouped[category]].filter(subcat => !onlineGrouped[category].has(subcat));
                  if (uniqueInperson.length > 0) {
                      groupedUnique.inperson[category] = uniqueInperson;
                  }
              } else {
                  groupedUnique.online[category] = [...onlineGrouped[category]];
              }
          });
  
          Object.keys(inpersonGrouped).forEach(category => {
              if (!onlineGrouped[category]) {
                  groupedUnique.inperson[category] = [...inpersonGrouped[category]];
              }
          });
  
          return { common: groupedCommon, unique: groupedUnique };
      }
  
      const { common, unique } = findCommonAndUnique(subcatesonline, subcatesinperson);
      var uniqueOnline = unique.online;
      var uniqueInperson = unique.inperson;
  
      $('#SubOnlineFreelance').empty();
      $('#SubInpersonFreelance').empty();
  
      const onlineSection = document.getElementById('SubOnlineFreelance');
      const inpersonSection = document.getElementById('SubInpersonFreelance');
  
      const allCategories = new Set([...Object.keys(common), ...Object.keys(uniqueOnline), ...Object.keys(uniqueInperson)]);
  
    // Update checkbox state with auto-selection for common subcategories
  function updateCheckboxState(category, subcat, type, isCommon, isChecked) {
      const checkboxes = document.querySelectorAll(`input[data-categoryfls="${category}"][data-subcategoryfls="${subcat}"]`);
      
      checkboxes.forEach(checkbox => {
          // Check the other side automatically if it's a common subcategory and checkbox is being selected
          if (isChecked && isCommon && checkbox.getAttribute('data-typefls') !== type) {
              checkbox.checked = true;
          }
          
          // HandleLimitSelection will ensure limits are enforced for each category
          handleLimitSelection(category);
      });
  }
  
     // Function to limit subcategory selection to a max of 10 per category
  function handleLimitSelection(category) {
      const checkboxes = document.querySelectorAll(`input[data-categoryfls="${category}"]`);
      const selectedSubcategories = new Set(); // To track unique selected subcategories
      const commonSelected = new Set();  // To track common subcategories selected in both sections
      const commonStatus = {}; // To track whether common subcategories are selected in any section
  
      // Count selected subcategories and track common subcategories
      checkboxes.forEach(cb => {
          const subcat = cb.getAttribute('data-subcategoryfls');
          const isCommon = cb.getAttribute('data-commonfls') === 'true';
  
          if (cb.checked) {
              if (isCommon) {
                  commonSelected.add(subcat);  // Common subcategories count as one
                  commonStatus[subcat] = true;  // Mark common subcategory as selected
              } else {
                  selectedSubcategories.add(subcat);  // Unique subcategories count as one each
              }
          } else if (isCommon) {
              commonStatus[subcat] = commonStatus[subcat] || false;  // Mark common subcategory as unselected if not checked
          }
      });
  
      const totalSelected = selectedSubcategories.size + commonSelected.size;
  
      // Disable only unchecked checkboxes when the max limit is reached
      checkboxes.forEach(cb => {
          const subcat = cb.getAttribute('data-subcategoryfls');
          const isCommon = cb.getAttribute('data-commonfls') === 'true';
  
          // Disable checkboxes if limit reached, but keep enabled those that are already selected
          if (!cb.checked && totalSelected >= 10) {
              // Disable only if completely unselected in both sections (common or unique)
              if (!(isCommon && commonStatus[subcat])) {
                  cb.disabled = true; // Disable completely unselected subcategories
              }
          } else {
              cb.disabled = false; // Ensure checked checkboxes and common ones selected on one side stay enabled
          }
      });
  }
  
      // Iterate through all categories and render subcategories
      allCategories.forEach(category => {
          const hasCommon = common[category] && common[category].length > 0;
          const hasUniqueOnline = uniqueOnline[category] && uniqueOnline[category].length > 0;
          const hasUniqueInperson = uniqueInperson[category] && uniqueInperson[category].length > 0;
  
          if (hasCommon || hasUniqueOnline || hasUniqueInperson) {
              // ONLINE Section
              if (hasCommon || hasUniqueOnline) {
                  const onlineCategoryContainer = document.createElement('div');
                  const categoryHeadingOnline = document.createElement('div');
                  categoryHeadingOnline.className = 'category-heading';
                  categoryHeadingOnline.innerText = category;
                  $(categoryHeadingOnline).css('color', '#096090d1');
                  onlineCategoryContainer.appendChild(categoryHeadingOnline);
  
                  const subcategoryListOnline = document.createElement('div');
                  subcategoryListOnline.className = 'row';
  
                  if (hasCommon) {
                      common[category].forEach(subcat => {
                          const checkbox = createCheckbox(category, subcat, 'Online', true);
                          subcategoryListOnline.appendChild(checkbox);
                      });
                  }
  
                  if (hasUniqueOnline) {
                      uniqueOnline[category].forEach(subcat => {
                          const checkbox = createCheckbox(category, subcat, 'Online', false);
                          subcategoryListOnline.appendChild(checkbox);
                      });
                  }
  
                  onlineCategoryContainer.appendChild(subcategoryListOnline);
                  onlineSection.appendChild(onlineCategoryContainer);
              }
  
              // INPERSON Section
              if (hasCommon || hasUniqueInperson) {
                  const inpersonCategoryContainer = document.createElement('div');
                  const categoryHeadingInperson = document.createElement('div');
                  categoryHeadingInperson.className = 'category-heading';
                  categoryHeadingInperson.innerText = category;
                  $(categoryHeadingInperson).css('color', '#096090d1');
                  inpersonCategoryContainer.appendChild(categoryHeadingInperson);
  
                  const subcategoryListInperson = document.createElement('div');
                  subcategoryListInperson.className = 'row';
  
                  if (hasCommon) {
                      common[category].forEach(subcat => {
                          const checkbox = createCheckbox(category, subcat, 'Inperson', true);
                          subcategoryListInperson.appendChild(checkbox);
                      });
                  }
  
                  if (hasUniqueInperson) {
                      uniqueInperson[category].forEach(subcat => {
                          const checkbox = createCheckbox(category, subcat, 'Inperson', false);
                          subcategoryListInperson.appendChild(checkbox);
                      });
                  }
  
                  inpersonCategoryContainer.appendChild(subcategoryListInperson);
                  inpersonSection.appendChild(inpersonCategoryContainer);
              }
          }
      });
  
      // Helper function to create checkboxes
      function createCheckbox(category, subcat, type, isCommon) {
          const div_main = document.createElement('div');
          div_main.className = (service_type_val == 'Both') ? 'col-md-12 freelance_sub' : 'col-md-3 freelance_sub';
          const li = document.createElement('li');
          li.className = 'multi-text-li';
          const label = document.createElement('label');
          label.sub_category = subcat;
          label.sub_category_type = type;
          const checkbox = document.createElement('input');
          checkbox.type = 'checkbox';
          checkbox.name = 'subcategories[]';
          if (type == 'Inperson') {
          checkbox.className = 'subcat1-input freelancesub flsin';
          } else {
          checkbox.className = 'subcat1-input freelancesub flson';
          }
          
          checkbox.value = subcat;
          checkbox.setAttribute('data-categoryfls', category);
          checkbox.setAttribute('data-subcategoryfls', subcat);
          checkbox.setAttribute('data-typefls', type);
          checkbox.setAttribute('data-commonfls', isCommon);  // Flag for common subcategories
  
          checkbox.addEventListener('change', function() {
              updateCheckboxState(category, subcat, type, isCommon, checkbox.checked);
          });
  
          label.appendChild(checkbox);
          label.append(subcat);
          li.appendChild(label);
          div_main.appendChild(li);
  
          return div_main;
      }
  }
  
   // Show Sub Categories and Selection Script END  ========
  
  
  
  
     function SelectFreelanceCategorySub() {
      const chBoxes3 = document.querySelectorAll(".dropdown-menu .subcat1-input");
      const chBoxes3on = document.querySelectorAll(".dropdown-menu .subcat1-input.flson");
      const chBoxes3in = document.querySelectorAll(".dropdown-menu .subcat1-input.flsin");
    const dpBtn3 = document.getElementById("multiSelectDropdown3");
    let mySelectedListItems3 = [];
       
      
    function handleCB() {
      mySelectedListItems3 = [];
      let mySelectedListItemsText3 = "";
      let FlsIn = [];
      let FlsOn = [];
      
      chBoxes3.forEach((checkbox) => {
        if (checkbox.checked) {
             
          mySelectedListItems3.push(checkbox.value);
          mySelectedListItemsText3 += checkbox.value + ", ";
        }
      });


        // Sub Category Online Get Selected
    chBoxes3on.forEach((checkbox) => {
      if (checkbox.checked) {
         FlsOn.push(checkbox.value);
        
      }
    });
    // SubCategory Inperson Get Selected
    chBoxes3in.forEach((checkbox) => {
      if (checkbox.checked) {
         FlsIn.push(checkbox.value);
        
      }
    });

    let resultSubOn = FlsOn.join(',');
    let resultSubIn = FlsIn.join(',');
    let sub_vals = resultSubOn + '|*|' + resultSubIn ;
    $('#fls_sub_val').val(sub_vals);

  
      dpBtn3.innerText =
        mySelectedListItems3.length > 0
          ? mySelectedListItemsText3.slice(0, -2)
          : "--select sub-category--";
    }
  
    chBoxes3.forEach((checkbox) => {
      checkbox.addEventListener("change", handleCB);
    });
       }
    
  
       
       
      </script>
  
  {{-- // Freelance Categories Selection with Rules and limits  and get Sub categories Script END ========= --}}
  {{-- // Freelance Categories Selection with Rules and limits  and get Sub categories Script END ========= --}}
  






<script>

 

  
</script>

<script>
  
  function SelectLanguages() { 
    const chBoxes4 = document.querySelectorAll(".dropdown-menu .language-input");
  const dpBtn4 = document.getElementById("multiSelectDropdown4");
  let mySelectedListItems4 = [];

  function handleCB() {
    mySelectedListItems4 = [];
    let mySelectedListItemsText4 = "";

    chBoxes4.forEach((checkbox) => {
      if (checkbox.checked) {
        mySelectedListItems4.push(checkbox.value);
        mySelectedListItemsText4 += checkbox.value + ", ";
      }
    });

    dpBtn4.innerText =
      mySelectedListItems4.length > 0
        ? mySelectedListItemsText4.slice(0, -2)
        : "--select Language--";
  }

  chBoxes4.forEach((checkbox) => {
    checkbox.addEventListener("change", handleCB);
  });

    }
</script>

<script>



  // 1
  new Vue({
  el: "#upload-image",
  data() {
    return {
      preview: null,
      image: null,
    };
  },
  methods: {
    previewImage: function (id) {
      let input = document.getElementById(id);
      if (input.files) {
        if(input.files[0].size > 1048576) {
       alert("Maximmum Image Size 1MB Allowed!");
       input.value = "";
       return false;
    }
        let reader = new FileReader();
        reader.onload = (e) => {
          this.preview = e.target.result;
        };
        this.image = input.files[0];
        reader.readAsDataURL(input.files[0]);
      }
    },
    reset: function (id) {
      this.image = null;
      this.preview = null;
      // Clear the input element
      document.getElementById(id).value = "";
    },
  },
});




  // 1
  new Vue({
  el: "#upload-image1",
  data() {
    return {
      preview: null,
      image: null,
    };
  },
  methods: {
    previewImage: function (id) {
      let input = document.getElementById(id);
      if (input.files) {
        if(input.files[0].size > 1048576) {
       alert("Maximmum Image Size 1MB Allowed!");
       input.value = "";
       return false;
    }
        let reader = new FileReader();
        reader.onload = (e) => {
          this.preview = e.target.result;
        };
        this.image = input.files[0];
        reader.readAsDataURL(input.files[0]);
      }
    },
    reset: function (id) {
      this.image = null;
      this.preview = null;
      // Clear the input element
      document.getElementById(id).value = "";
    },
  },
});


  // 1
  new Vue({
  el: "#upload-image2",
  data() {
    return {
      preview: null,
      image: null,
    };
  },
  methods: {
    previewImage: function (id) {
      let input = document.getElementById(id);
      if (input.files) {
        if(input.files[0].size > 1048576) {
       alert("Maximmum Image Size 1MB Allowed!");
       input.value = "";
       return false;
    }
        let reader = new FileReader();
        reader.onload = (e) => {
          this.preview = e.target.result;
        };
        this.image = input.files[0];
        reader.readAsDataURL(input.files[0]);
      }
    },
    reset: function (id) {
      this.image = null;
      this.preview = null;
      // Clear the input element
      document.getElementById(id).value = "";
    },
  },
});




  // 1
  new Vue({
  el: "#upload-image3",
  data() {
    return {
      preview: null,
      image: null,
    };
  },
  methods: {
    previewImage: function (id) {
      let input = document.getElementById(id);
      if (input.files) {
        if(input.files[0].size > 1048576) {
       alert("Maximmum Image Size 1MB Allowed!");
       input.value = "";
       return false;
    }
        let reader = new FileReader();
        reader.onload = (e) => {
          this.preview = e.target.result;
        };
        this.image = input.files[0];
        reader.readAsDataURL(input.files[0]);
      }
    },
    reset: function (id) {
      this.image = null;
      this.preview = null;
      // Clear the input element
      document.getElementById(id).value = "";
    },
  },
});



  // 1
  new Vue({
  el: "#upload-image4",
  data() {
    return {
      preview: null,
      image: null,
    };
  },
  methods: {
    previewImage: function (id) {
      let input = document.getElementById(id);
      if (input.files) {
        if(input.files[0].size > 1048576) {
       alert("Maximmum Image Size 1MB Allowed!");
       input.value = "";
       return false;
    }
        let reader = new FileReader();
        reader.onload = (e) => {
          this.preview = e.target.result;
        };
        this.image = input.files[0];
        reader.readAsDataURL(input.files[0]);
      }
    },
    reset: function (id) {
      this.image = null;
      this.preview = null;
      // Clear the input element
      document.getElementById(id).value = "";
    },
  },
});



  // 1
  new Vue({
  el: "#upload-image5",
  data() {
    return {
      preview: null,
      image: null,
    };
  },
  methods: {
    previewImage: function (id) {
      let input = document.getElementById(id);
      if (input.files) {
        if(input.files[0].size > 1048576) {
       alert("Maximmum Image Size 1MB Allowed!");
       input.value = "";
       return false;
    }
        let reader = new FileReader();
        reader.onload = (e) => {
          this.preview = e.target.result;
        };
        this.image = input.files[0];
        reader.readAsDataURL(input.files[0]);
      }
    },
    reset: function (id) {
      this.image = null;
      this.preview = null;
      // Clear the input element
      document.getElementById(id).value = "";
    },
  },
});


  // 1
  new Vue({
  el: "#upload-image6",
  data() {
    return {
      preview: null,
      image: null,
    };
  },
  methods: {
    previewImage: function (id) {
      let input = document.getElementById(id);
      if (input.files) {
        if(input.files[0].size > 1048576) {
       alert("Maximmum Image Size 1MB Allowed!");
       input.value = "";
       return false;
    }
        let reader = new FileReader();
        reader.onload = (e) => {
          this.preview = e.target.result;
        };
        this.image = input.files[0];
        reader.readAsDataURL(input.files[0]);
      }
    },
    reset: function (id) {
      this.image = null;
      this.preview = null;
      // Clear the input element
      document.getElementById(id).value = "";
    },
  },
});




  // 1
  new Vue({
  el: "#upload-image7",
  data() {
    return {
      preview: null,
      image: null,
    };
  },
  methods: {
    previewImage: function (id) {
      let input = document.getElementById(id);
      if (input.files) {
        if(input.files[0].size > 10485760) {
       alert("Maximmum Video Size 10MB Allowed!");
       input.value = "";
       return false;
    }
        let reader = new FileReader();
        reader.onload = (e) => {
          this.preview = e.target.result;
        };
        this.image = input.files[0];
        reader.readAsDataURL(input.files[0]);
      }
    },
    reset: function (id) {
      this.image = null;
      this.preview = null;
      // Clear the input element
      document.getElementById(id).value = "";
    },
  },
});




  // 1
  new Vue({
  el: "#upload-image8",
  data() {
    return {
      preview: null,
      image: null,
    };
  },
  methods: {
    previewImage: function (id) {
      let input = document.getElementById(id);
      if (input.files) {
        if(input.files[0].size > 10485760) {
       alert("Maximmum Video Size 10MB Allowed!");
       input.value = "";
       return false;
    }
        let reader = new FileReader();
        reader.onload = (e) => {
          this.preview = e.target.result;
        };
        this.image = input.files[0];
        reader.readAsDataURL(input.files[0]);
      }
    },
    reset: function (id) {
      this.image = null;
      this.preview = null;
      // Clear the input element
      document.getElementById(id).value = "";
    },
  },
});



  // 1
  new Vue({
  el: "#upload-image9",
  data() {
    return {
      preview: null,
      image: null,
    };
  },
  methods: {
    previewImage: function (id) {
      let input = document.getElementById(id);
      if (input.files) {
        if(input.files[0].size > 1048576) {
       alert("Maximmum Image Size 1MB Allowed!");
       input.value = "";
       return false;
    }
        let reader = new FileReader();
        reader.onload = (e) => {
          this.preview = e.target.result;
        };
        this.image = input.files[0];
        reader.readAsDataURL(input.files[0]);
      }
    },
    reset: function (id) {
      this.image = null;
      this.preview = null;
      // Clear the input element
      document.getElementById(id).value = "";
    },
  },
});



  // 1
  new Vue({
  el: "#upload-image10",
  data() {
    return {
      preview: null,
      image: null,
    };
  },
  methods: {
    previewImage: function (id) {
      let input = document.getElementById(id);
      if (input.files) {
        if(input.files[0].size > 1048576) {
       alert("Maximmum Image Size 1MB Allowed!");
       input.value = "";
       return false;
    }
        let reader = new FileReader();
        reader.onload = (e) => {
          this.preview = e.target.result;
        };
        this.image = input.files[0];
        reader.readAsDataURL(input.files[0]);
      }
    },
    reset: function (id) {
      this.image = null;
      this.preview = null;
      // Clear the input element
      document.getElementById(id).value = "";
    },
  },
});


  // 1
  new Vue({
  el: "#upload-image11",
  data() {
    return {
      preview: null,
      image: null,
    };
  },
  methods: {
    previewImage: function (id) {
      let input = document.getElementById(id);
      if (input.files) {
        if(input.files[0].size > 1048576) {
       alert("Maximmum Image Size 1MB Allowed!");
       input.value = "";
       return false;
    }
        let reader = new FileReader();
        reader.onload = (e) => {
          this.preview = e.target.result;
        };
        this.image = input.files[0];
        reader.readAsDataURL(input.files[0]);
      }
    },
    reset: function (id) {
      this.image = null;
      this.preview = null;
      // Clear the input element
      document.getElementById(id).value = "";
    },
  },
});





</script>

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