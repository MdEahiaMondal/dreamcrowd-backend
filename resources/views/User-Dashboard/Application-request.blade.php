<!doctype html>
<html lang="en">

<head>
  <base href="/public">
    <!-- Required meta tags -->
    <meta charset="UTF-8">

    <!-- View Point scale to 1.0 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Animate css -->
    <link rel="stylesheet" href="assets/user/libs/animate/css/animate.css" />
    <!-- AOS Animation css--> 
    <link rel="stylesheet" href="assets/user/libs/aos/css/aos.css" />
    <!-- Datatable css  -->
    <link rel="stylesheet" href="assets/user/libs/datatable/css/datatable.css" />
     {{-- Fav Icon --}}
     @php  $home = \App\Models\HomeDynamic::first(); @endphp
     @if ($home)
         <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
     @endif

       <!-- jQuery -->
       <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
 
       {{-- =======Toastr CDN ======== --}}
       <link rel="stylesheet" type="text/css" 
       href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
       
       <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
       {{-- =======Toastr CDN ======== --}}

     <!-- Select2 css -->
    <link href="assets/user/libs/select2/css/select2.min.css" rel="stylesheet" />
    <!-- Owl carousel css -->
    <link href="assets/user/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
    <link href="assets/user/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="assets/public-site/asset/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/public-site/asset/css/fontawesome.min.css">
    <link href="assets/css/fontawesome.min.css" rel="stylesheet" type="text/css" />
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/public-site/asset/css/style.css" />
    <link rel="stylesheet" href="assets/public-site/asset/css/navbar.css">
    <link rel="stylesheet" href="assets/public-site/asset/css/Drop.css">
    <link rel="stylesheet" type="text/css" href="assets/user/asset/css/application-request.css" />
    <link rel="stylesheet" type="text/css" href="assets/admin/asset/css/reject-modal.css" />
    <link rel="stylesheet" href="assets/expert/asset/css/style.css" />
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.2.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>
    <!-- flatpicker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


    <title>DreamCrowd | Payment</title>
</head>

<style>
  /* ================================================================= LOGOUT PAGE START HERE ======================================================================= */
.logout-modal h1 {
  color: var(--Colors-Logo-Color, #0072b1);
  text-align: center;
  font-family: Outfit;
  font-size: 24px;
  font-style: normal;
  font-weight: 500;
  line-height: normal;
  margin-bottom: 0px;
}

.logout-modal .modal-content {
  padding: 40px 60px;
  border-radius: 8px;
  border: none;
  border-color: #fff;
}

.logout-modal .btn-sec {
  margin-top: 28px;
}

.logout-modal .btn-no {
  border-radius: 4px;
  border: 2px solid var(--Colors-Logo-Color, #0072b1);
  color: #0072b1;
  text-align: center;
  font-family: Roboto;
  font-size: 16px;
  font-style: normal;
  font-weight: 400;
  line-height: normal;
  padding: 8px 20px;
  margin-right: 16px;
  background: none !important;
}
.logout-modal .btn-no:hover {
  background: #0072b1 !important;
  color: #fff !important;
}
.logout-modal .btn-yes {
  border-radius: 4px;
  background: var(--Colors-Logo-Color, #0072b1);
  padding: 8px 20px;
  color: var(--Colors-White, #fff);
  text-align: center;
  font-family: Roboto;
  font-size: 16px;
  font-style: normal;
  font-weight: 400;
  line-height: normal;
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
    <div class="container application-request">
        <div class="row">
          <div class="col-md-12">
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
                                    id="imageUploadd"
                                    accept=".png, .jpg, .jpeg"
                                  />
                                  <label for="imageUpload"></label>
                                </div> --}}
                                <div class="avatar-preview">
                                  <div
                                    id="imagePrevieww"
                                    style="
                                      background-image: url('assets/profile/img/{{$app->profile_image}}');
                                      width: 100%;
                                    "
                                  ></div>
                                </div>
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
                                  type="text" value="{{$app->first_name}}" readonly
                                  class="form-control"
                                  id="exampleFormControlInput1"
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
                                  type="text"  value="{{$app->last_name}}" readonly
                                  class="form-control"
                                  id="exampleFormControlInput1"
                                  placeholder="eg. Aslam"
                                />
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  >Gender<span>*</span></label
                                >
                                <input
                                  type="text"  value="{{$app->gender}}" readonly
                                  class="form-control"
                                  id="exampleFormControlInput1"
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
                                  type="text" value="{{$app->profession}}" readonly
                                  class="form-control"
                                  id="exampleFormControlInput1"
                                  placeholder="eg. Graphic Designer"
                                />
                              </div>
                            </div>
                            <div class="col-md-12">
                              <label class="form-label"
                                >Select Service <span>*</span></label
                              >
                              <input
                              type="text" value="{{$app->service_role}}" readonly
                              class="form-control"
                              id="exampleFormControlInput1"
                              placeholder="eg. Service"
                            />
                            </div>
                            <div class="col-md-12">
                              <label class="form-label"
                                >Delivery Option <span>*</span><i class="bx bx-info-circle icon" title="Messages"></i></box-icon></label
                              >
                              <input
                              type="text" value="{{$app->service_type}}" readonly
                              class="form-control"
                              id="exampleFormControlInput1"
                              placeholder="eg. Service"
                            />
                            </div>
                          
                            
                          </div>
                        </div>
                        <!-- =========== BUTTONS SECTION ============  -->
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-12">
                  <div class="top-head">
                  <h1> Location</h1>
                </div>
                </div>
                <div class="col-md-12 profile-section">
                
                  <form class="row profile-form">
                   
                    <div class="col-md-12">
                      <label for="inputPassword4">Street Address</label>
                      <input
                        type="text"  value="{{$app->street_address}}" readonly
                        class="form-control"
                        id="inputPassword4"
                        placeholder="Street Address"
                      />
                    </div>
                   
                    <div class="col-md-12 profile-form">
                      <label for="inputPassword4">Country</label>
                      <input
                        type="text"  value="{{$app->country}}" readonly
                        class="form-control"
                        id="inputPassword4"
                        placeholder="Country"
                      />
                    </div>
                    <div class="col-md-6 profile-form">
                      <label for="inputAddress">City</label>
                      <input
                        type="text" value="{{$app->city}}" readonly
                        class="form-control"
                        id="inputAddress"
                        placeholder="City"
                      />
                    </div>
                    <div class="col-md-6 profile-form">
                      <label for="inputAddress">Zip Code</label>
                      <input
                        type="text" value="{{$app->zip_code}}" readonly
                        class="form-control"
                        id="inputAddress"
                        placeholder="Postel Code"
                      />
                    </div>
                    {{-- <div class="col-md-12 profile-form">
                      <textarea
                        name=""
                        id="" 
                        cols="30"
                        rows="10"
                        class="form-control"
                        placeholder="write something why you want to update the location"
                      ></textarea>
                    </div>                           --}}
                  </form>
                  {{-- <button class="btn rqst-send">Send Request</button>  --}}
                </div>
              </div>
            
                <div class="row">
                  <div class="col-lg-12">
                    <div class="top-head">
                      <h1> Category</h1>
                    </div>
                    <!-- =================================================== -->
                    <div class="row">
                      <div class="col-md-12">
                        <div class="main-tab-sec">
                          <!--  -->
                          @if (in_array($app->service_role, ['Class', 'Both']))

                          <div class="row">
                            
                            <div class="col-md-12">
                              <label
                                for="exampleFormControlInput1"
                                class="form-label"
                                style="margin-top: 0px !important"
                                >Category Class <span>*</span></label
                              >
                              <p>
                                Select Up to five Categories that mostly sums up
                                the experience you are providing. Please be
                                aware that it is difficult to be approved under
                                the following experience: Politics, Religion and
                                Gambling
                              </p>
                              @php $categoryIdsArray = explode(',', $app->category_class);
                               $categoryIds = array_map('intval', $categoryIdsArray);
                                $categories  = \App\Models\Category::whereIn('id', $categoryIds)->pluck('category', 'id')->toArray(); 
                                $categoryNames = array_map(function($id) use ($categories) {
                                    return $categories[$id] ?? "Unknown Category";
                                }, $categoryIds);
                                $categoryNames = implode(', ', $categoryNames);
                                @endphp
                              <input
                                  type="text" value="{{$categoryNames}}" readonly
                                  class="form-control"
                                  id="class_category"
                                  placeholder="eg. Graphic Designer"
                                />
                            
                            </div>
                            <div class="col-md-12">
                              <label class="form-label"
                                >Sub Category Class <span>*</span></label
                              >
                              @php $sub_cls = explode('|*|',$app->sub_category_class)  @endphp
                              <input
                              type="text" value="@if (isset($sub_cls[0])) {{$sub_cls[0]}}  @endif ,@if (isset($sub_cls[1])) {{$sub_cls[1]}}  @endif" readonly
                              class="form-control"
                              id="class_sub_category"
                              placeholder="eg. Designer"
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
                                type="text" value="{{$app->positive_search_class}}" readonly
                                class="form-control"
                                id="exampleFormControlInput1"
                                placeholder="eg. Positive Search"
                              />
                              </div>
                            </div>
                          </div>
                          <hr>

                          @endif
                            
                          @if(in_array($app->service_role, ['Freelance', 'Both']))

                          <div class="row">
                            
                            <div class="col-md-12">
                              <label
                                for="exampleFormControlInput1"
                                class="form-label"
                                style="margin-top: 0px !important"
                                >Category Freelance <span>*</span></label
                              >
                              <p>
                                Select Up to five Categories that mostly sums up
                                the experience you are providing. Please be
                                aware that it is difficult to be approved under
                                the following experience: Politics, Religion and
                                Gambling
                              </p>
                              @php $categoryIdsArray = explode(',', $app->category_freelance);
                               $categoryIds = array_map('intval', $categoryIdsArray);
                                $categories  = \App\Models\Category::whereIn('id', $categoryIds)->pluck('category', 'id')->toArray(); 
                                $categoryNames = array_map(function($id) use ($categories) {
                                    return $categories[$id] ?? "Unknown Category";
                                }, $categoryIds);
                                $categoryNames = implode(', ', $categoryNames);
                                @endphp
                              <input
                                  type="text" value="{{$categoryNames}}" readonly
                                  class="form-control"
                                  id="freelance_category"
                                  placeholder="eg. Graphic Designer"
                                />
                            
                            </div>
                            <div class="col-md-12">
                              <label class="form-label"
                                >Sub Category Freelance <span>*</span></label
                              >
                              @php $sub_fls = explode('|*|',$app->sub_category_freelance)  @endphp
                              <input
                             
                              type="text" value="@if (isset($sub_fls[0])) {{$sub_fls[0]}}  @endif ,@if (isset($sub_fls[1])) {{$sub_fls[1]}}  @endif " readonly
                              class="form-control"
                              id="freelance_sub_category"
                              placeholder="eg. Designer"
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
                                type="text" value="{{$app->positive_search_freelance}}" readonly
                                class="form-control"
                                id="exampleFormControlInput1"
                                placeholder="eg. Positive Search"
                              />
                              </div>
                            </div>
                          </div>


                          @endif

                           
                         
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- ========================================== -->
              
              </div>
        
              
                <div class="row">
                  <div class="col-lg-12">
                    <div class="tab-content" id="side-menu-tabContent">
                    <div class="top-head">
                      <h1> Experience</h1>
                    </div>
                    <!-- =================================================== -->
                    <div class="row">
                      <div class="col-md-12">
                        <div class="main-tab-sec">
                          <!--  -->
                          <div class="row">
                             

                          @if ($app->service_role == 'Class')
                              @php
                              
                              $categoryIdsArray = explode(',', $app->category_class); 
                              $categoryIds = array_map('intval', $categoryIdsArray);
                               $categories  = \App\Models\Category::whereIn('id', $categoryIds)->pluck('category', 'id')->toArray(); 
                               $categoryNamesCls = array_map(function($id) use ($categories) {
                                   return $categories[$id] ?? "Unknown Category";
                               }, $categoryIds);
                               
                              //  $categoryNames = implode(', ', $categoryNames);
                               if ($app->service_type == 'Both') {
                                 $all_cates = array_unique($categoryNamesCls); 
                               }
                              // $all_cates = explode(',',$app->all_cates);
                              $experience = explode(',',$app->experience) ;
                              $i = 0 ;
                              $j = 0 ;
                              $url = explode('|*|',$app->portfolio_url) ;
                              
                              @endphp
                              @elseif($app->service_role == 'Freelance')
                              @php
                                $categoryIdsArray = explode(',', $app->category_freelance);
                              $categoryIds = array_map('intval', $categoryIdsArray);
                               $categories  = \App\Models\Category::whereIn('id', $categoryIds)->pluck('category', 'id')->toArray(); 
                               $categoryNames = array_map(function($id) use ($categories) {
                                   return $categories[$id] ?? "Unknown Category";
                               }, $categoryIds);
                              //  $categoryNames = implode(', ', $categoryNames);
                               if ($app->service_type == 'Both') {
                                 $all_cates = array_unique($categoryNames); 
                               }
                              // $all_cates = explode(',',$app->all_cates);
                              $experience = explode(',',$app->experience) ;
                              $i = 0 ;
                              $j = 0 ;
                              $url = explode('|*|',$app->portfolio_url) ;
                              @endphp
                          @else
                            @php

                              $categoryIdsArray = explode(',', $app->category_class); 
                              $categoryIds = array_map('intval', $categoryIdsArray);
                               $categories  = \App\Models\Category::whereIn('id', $categoryIds)->pluck('category', 'id')->toArray(); 
                               $categoryNamesCls = array_map(function($id) use ($categories) {
                                   return $categories[$id] ?? "Unknown Category";
                               }, $categoryIds);
                              //  $categoryNamesCls = implode(', ', $categoryNames);
                            

                              $categoryIdsArray = explode(',', $app->category_freelance); 
                              $categoryIds = array_map('intval', $categoryIdsArray);
                               $categories  = \App\Models\Category::whereIn('id', $categoryIds)->pluck('category', 'id')->toArray(); 
                               $categoryNamesFls = array_map(function($id) use ($categories) {
                                   return $categories[$id] ?? "Unknown Category";
                               }, $categoryIds);
                              //  $categoryNamesFls = implode(', ', $categoryNames);
                            
                            



                          $mergedArray = array_merge($categoryNamesCls, $categoryNamesFls);
 
                        
                                $all_cates = array_unique($mergedArray); 
                                  $experience = explode(',',$app->experience) ;
                                  $i = 0 ;
                                  $j = 0 ;
                                  $url = explode('|*|',$app->portfolio_url) ;
                            @endphp
                          @endif


                              @foreach ($all_cates as $item)
                              <div class="col-md-12">
                                
                                <label class="form-label"
                                  >How many years of experience do you have in {{$item}}? <span>*</span></label>
                               
                               
                                <input
                                    type="text" value="@if (isset($experience[$i])) {{$experience[$i]}} @else 0  @endif" readonly
                                    class="form-control"
                                    id="exampleFormControlInput1"
                                    placeholder="eg. 6"
                                  />
                              </div>
                              @php $i++; @endphp
                              @endforeach
                             
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
                                @if ($app->portfolio == 'web_link')
                                <input
                                type="text" value="I have a web link" readonly
                                class="form-control"
                                id="exampleFormControlInput1"
                                placeholder="eg. 6"
                              />
                            @else
                            
                            <input
                            type="text" value="I don't have any link" readonly
                            class="form-control"
                            id="exampleFormControlInput1"
                            placeholder="eg. 6"
                          />

                                @endif
                               
                                
                              </div>
                            </div>

                            @if ($app->portfolio != 'not_link')
                                
                            @foreach ($all_cates as $item)
                            <div class="col-md-12">
                              <label class="form-label"
                                >{{$item}} Url <span>*</span></label>
                               @php
                              if (isset($url[$j])) {
                                  $folio =  $url[$j] ;
                                } else {  
                                  $folio =  'Not Have Portfolio' ;  
                                 }
                               $cleanedUrl = str_replace(['[', ']'], '', $folio);
                              $arrayUrl = explode(',_,', $cleanedUrl);  @endphp
                                @foreach ($arrayUrl as $urls_set)
                                    
                                <input
                                type="text" value="{{$urls_set}}" readonly
                                class="form-control mb-2"
                                id="exampleFormControlInput1"
                                placeholder="eg. 6"
                              />

                                @endforeach
                             
                                
                            </div>
                            @php $j++; @endphp
                            @endforeach

                            @endif
                           
                          </div>
                        </div>
                        <!-- =========== BUTTONS SECTION ============  -->
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
               
              
                <div class="row">
                  <div class="col-lg-12">
                    <div class="tab-content" id="side-menu-tabContent">
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
                                type="text" value="{{$app->primary_language}}" readonly
                                class="form-control"
                                id="exampleFormControlInput1"
                                placeholder="eg. English"
                              />
        
                              </div>
                            </div>


                            <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  style="margin-top: 0px !important"
                                  >Are you fluent in English?
                                  <span>*</span></label
                                >
                                <p>
                                  This should be language you are comfortable at
                                  hosting in.
                                </p>
                                <input
                                type="text" value="{{$app->fluent_english}}" readonly
                                class="form-control"
                                id="exampleFormControlInput1"
                                placeholder="eg. English"
                              />
        
                              </div>
                            </div>

                            <div class="col-md-12">
                              <label class="form-label"
                                >Do you speak other languages fluently?</label
                              >
                              <div class="form-check form-switch col-md-12">
                                <input class="form-check-input" type="checkbox" role="switch" id="speak_other_language_finel" @if ($app->speak_other_language == 1)  checked  @endif  disabled> 
                                <label class="form-label form-check-label" style="margin-top: 0px;" for="speak_other_language_finel"
                                > @if ($app->speak_other_language == 1)  YES @else No  @endif</label
                              >
                              </div>
                            </div>

                              @if ($app->speak_other_language == 1)
                              <div class="col-md-12">
                                <div class="">
                                  <label
                                    for="exampleFormControlInput1"
                                    class="form-label"
                                    style="margin-top: 0px !important"
                                    >What other languages do you speak
                                    fluently?
                                    <span>*</span></label
                                  >
                                  <p>
                                    This should be language you are comfortable at
                                  hosting in.
                                  </p>
                                  <input
                                  type="text" value="{{$app->fluent_other_language}}" readonly
                                  class="form-control"
                                  id="exampleFormControlInput1"
                                  placeholder="eg. English"
                                />
          
                                </div>
                              </div>
                              @endif
                           
                            
                          
                            <div class="row">
                              <div class="col-md-12">
                                <div class="">
                                  <label
                                    for="exampleFormControlInput1"
                                    class="form-label"
                                    style="margin-top: 20px !important"
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
                                    id="exampleFormControlTextarea1"
                                    rows="6"
                                    placeholder="write your experience heading....."
                                    style="resize: none;"
                                  >{{$app->overview}}</textarea>
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
                                    id="exampleFormControlTextarea1"
                                    rows="6"
                                    style="resize: none;"
                                    placeholder="write your experience heading....."
                                  >{{$app->about_me}}</textarea>
                                </div>


                                {{-- Textarea Disable Script Start --}}
                                <script>
                                  $('.image_disable').mouseenter(function () { 
                                    $('.image_disable').attr('disabled', 1);
                                  });
                                  $('.image_disable').mouseleave(function () { 
                                    $('.image_disable').removeAttr('disabled');
                                  });
                                  </script>
                              {{-- Textarea Disable Script END --}}


                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- =========== BUTTONS SECTION ============  -->
                       
                      </div>
                    </div>
                  </div>
                </div>
              </div>
        
             
        
              
                <div class="row">
                  <div class="col-lg-12">
                    <div class="tab-content" id="side-menu-tabContent">
                    <div class="top-head">
                      <h1>Photos</h1>
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
                                  
                                </p>
                                
                              </div>
                            </div>
                            <div class="col-md-4">
                             <img class="Request-img" src="assets/expert/asset/img/{{$app->main_image}}">
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
                                </p>
                               
                              </div>
                            </div>
                            <div class="col-md-4">
                              @if ($app->more_image_1 != null)
                              <img class="Request-img" src="assets/expert/asset/img/{{$app->more_image_1}}">
                              @endif
                            </div>
                            <div class="col-md-4">
                              @if ($app->more_image_2 != null)
                              <img class="Request-img" src="assets/expert/asset/img/{{$app->more_image_2}}">
                              @endif
                            </div>
                            <div class="col-md-4">
                              @if ($app->more_image_3 != null)
                              <img class="Request-img" src="assets/expert/asset/img/{{$app->more_image_3}}">
                              @endif
                            </div>
                            <div class="col-md-4">
                              @if ($app->more_image_4 != null)
                              <img class="Request-img" src="assets/expert/asset/img/{{$app->more_image_4}}">
                              @endif
                            </div>
                            <div class="col-md-4">
                              @if ($app->more_image_5 != null)
                              <img class="Request-img" src="assets/expert/asset/img/{{$app->more_image_5}}">
                              @endif
                            </div>
                            <div class="col-md-4">
                              @if ($app->more_image_6 != null)
                              <img class="Request-img" src="assets/expert/asset/img/{{$app->more_image_6}}">
                              @endif
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
                                  Upload a photo of you raising your thumb up
                                  while facing the camera.
                                </p>
                             
                              </div>
                            </div>
                            <div class="col-md-4">
                              @if ($app->video != null)
                             <video controls class="Request-img" src="assets/expert/asset/img/{{$app->video}}">  </video>
                              @endif
                            </div>



                            {{-- <div class="col-md-12">
                              <div class="">
                                <label
                                  for="exampleFormControlInput1"
                                  class="form-label"
                                  style="margin-top: 0px !important"
                                  >Verification</label
                                >
                                <p>
                                  Upload a photo of you raising your thumb up
                                  while facing the camera.
                                </p>
                               
                              </div>
                            </div>
                            <div class="col-md-4">
                              @if ($app->more_image_1 != null)
                              <img class="Request-img" src="assets/expert/asset/img/{{$app->more_image_1}}">
                              @endif
                            </div> --}}
                                   
                             </div>


                             <div class="top-head">
                              <h1>Verification</h1>
                            </div>

                            <div class="row mt-3">
                            

                             
                              <div class="col-md-4">
                                @if ($app->option_1 != null)
                               <video controls class="Request-img" src="assets/expert/asset/img/{{$app->option_1}}">  </video>
                                @endif
                              </div>

                              <div class="col-md-4">
                                @if ($app->option_2 != null)
                                <img class="Request-img" src="assets/expert/asset/img/{{$app->option_2}}">
                                @endif
                              </div>
                              <div class="col-md-4">
                                @if ($app->option_3 != null)
                                <img class="Request-img" src="assets/expert/asset/img/{{$app->option_3}}">
                                @endif
                              </div>


                              <div class="col-md-4">
                                @if ($app->option_4 != null)
                                <img class="Request-img" src="assets/expert/asset/img/{{$app->option_4}}">
                                @endif
                              </div>
                               
                              </div>



                              <div class="top-head">
                                <h1>Application Type</h1>
                              </div>

                              <style>
                                .application-section{
                                  color: var(--Colors-Logo-Color, #0072b1);
                            font-family: Outfit;
                            font-size: 16px;
                            font-style: normal;
                            font-weight: 500;
                            line-height: normal; 
                                }
                              </style>

                              <div class="row mt-3">
                                <!-- Application Section -->
            


             @if ($app->app_type != 1)
             <div class="col-md-6 mb-3"   >
              <div class="application-section">
                <h3>Fast track my application</h3>
            
                </div>
            </div>
            @else
            <div class="col-md-6 mb-3"   >
              <div class="application-section">
                <h3>Do not fast track my application</h3>
            
                </div>
            </div>
             @endif


          
             
               </div>



                          </div>
                        </div>
                        <!-- =========== BUTTONS SECTION ============  -->
                        <div class="row">
                          <div class="col-md-12">
                            <div class="buttons-sec">
                              <button type="button" onclick="DoAction(this.id)" id="reject" class="btn reject-btn ">
                                Reject
                              </button>
                              <button type="button" class="btn custom-btn" data-bs-target="#custom-approve-modal" data-bs-toggle="modal">
                                Custom Approved
                              </button>
                              <button type="button" onclick="DoAction(this.id)" id="approved"  class="btn approve-btn">
                                Approved
                              </button>
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
        </div>
           <!-- ============================= FOOTER SECTION START HERE ===================================== -->
           <x-public-footer/>
           <!-- ============================= FOOTER SECTION END HERE ===================================== -->
    <!-- custom approve modal -->
    <div class="modal fade" id="custom-approve-modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered mt-5">
        <div class="modal-content application-content">
          
          @if (in_array($app->service_type, ['Class', 'Both']))

          @if ($app->category_class != null)
              
          

          <div class="row">
            
            @php $class_cate = explode(',',$app->category_class) @endphp
            @if (count($class_cate) == 1) 
            @php $cates = \App\Models\Category::find($app->category_class) ; @endphp
            <div class="col-md-6 input_group1 main_class_1">
              <label for="car" class="form-label">Class Category</label>
          <input class="form-control" list="datalistOptions" value="{{$cates->category}} ({{$cates->service_type}})" id="car" readonly placeholder="Graphic Designer">
        </div>
        <div class="col-md-6 button_group1 main_class_1">
          <button class="btn_reject" onclick="RejectCategory(this.id)" id="reject_class_category_1" data-category="{{$app->category_class}}"  data-type="Class"  >Reject</button>
          {{-- <button class="btn_approve">Aprrove</button> --}}
          <button class="btn_view" onclick="ViewClassSub(this.id)" id="class_view_1" data-cate="{{$app->category_class}}"   data-cates_type="{{$cates->service_type}}">View</button>
        </div>
        <div class="col-md-12 sub_cate mt-2" id="class_sub_cate_1"></div>
          @else
          @php  $i =1 ;  @endphp
          @foreach ($class_cate as $item)
          @php $cates = \App\Models\Category::find($item) ; @endphp
          @if ($i == 1)
          <div class="col-md-6 input_group1 main_class_{{$i}}">
            <label for="car" class="form-label">Class Category</label>
        <input class="form-control" list="datalistOptions" value="{{$cates->category}} ({{$cates->service_type}})" id="car" readonly placeholder="Graphic Designer">
      </div>
      <div class="col-md-6 button_group1 main_class_{{$i}}">
        <button class="btn_reject" onclick="RejectCategory(this.id)" id="reject_class_category_{{$i}}" data-category="{{$item}}"  data-type="Class">Reject</button>
        {{-- <button class="btn_approve">Aprrove</button> --}}
        <button class="btn_view" onclick="ViewClassSub(this.id)" id="class_view_{{$i}}" data-cate="{{$item}}"  data-cates_type="{{$cates->service_type}}">View</button>
      </div>

      <div class="col-md-12 sub_cate mt-2 mb-2" id="class_sub_cate_{{$i}}"></div>

          @else
          <div class="col-md-6 input_group2 main_class_{{$i}}">
            <input class="form-control" list="datalistOptions" value="{{$cates->category}} ({{$cates->service_type}})" id="car" readonly placeholder="Graphic Designer">
          </div>
          <div class="col-md-6 button_group2 main_class_{{$i}}">
            <button class="btn_reject" onclick="RejectCategory(this.id)" id="reject_class_category_{{$i}}" data-category="{{$item}}"  data-type="Class">Reject</button>
            {{-- <button class="btn_approve">Aprrove</button> --}}
            <button class="btn_view" onclick="ViewClassSub(this.id)" id="class_view_{{$i}}" data-cate="{{$item}}"   data-cates_type="{{$cates->service_type}}">View</button>
          </div> 
          <div class="col-md-12 sub_cate mt-2 mb-2" id="class_sub_cate_{{$i}}"></div>
          
            
          @endif
          @php  $i++ ;  @endphp
              @endforeach
          @endif
         
          </div>

          @endif
          
          @endif

          @if(in_array($app->service_type, ['Freelance', 'Both']))

          @if ($app->category_freelance != null)
              
          
          
          <div class="row">
            
            @php $freelance_cate = explode(',',$app->category_freelance) @endphp
            @if (count($freelance_cate) == 1)
            @php $cates = \App\Models\Category::find($app->category_freelance) ; @endphp
            <div class="col-md-6 input_group1 main_freelance_1">
              <label for="car" class="form-label">Freelance Category</label>
          <input class="form-control" list="datalistOptions" value="{{$cates->category}} ({{$cates->service_type}})" id="car" readonly placeholder="Graphic Designer">
        </div>
        <div class="col-md-6 button_group1 main_freelance_1">
          <button class="btn_reject" onclick="RejectCategory(this.id)" id="reject_freelance_category_1" data-category="{{$app->category_freelance}}"  data-type="Freelance">Reject</button>
          {{-- <button class="btn_approve">Aprrove</button> --}}
          <button class="btn_view" onclick="ViewFreelanceSub(this.id)" id="freelance_view_1" data-cate="{{$app->category_freelance}}"   data-cates_type="{{$cates->service_type}}">View</button>
        </div>
        <div class="col-md-12 sub_cate mt-2" id="freelance_sub_cate_1"></div>
          @else
          @php  $i =1 ;  @endphp
          @foreach ($freelance_cate as $item)
          @php $cates = \App\Models\Category::find($item) ; @endphp
          @if ($i == 1)

          <div class="col-md-6 input_group1 main_freelance_{{$i}}">
            <label for="car" class="form-label">Freelance Category</label>
        <input class="form-control" list="datalistOptions" value="{{$cates->category}} ({{$cates->service_type}})" id="car" readonly placeholder="Graphic Designer">
      </div>
      <div class="col-md-6 button_group1 main_freelance_{{$i}}">
        <button class="btn_reject"  onclick="RejectCategory(this.id)" id="reject_freelance_category_{{$i}}" data-category="{{$item}}"  data-type="Freelance">Reject</button>
        {{-- <button class="btn_approve">Aprrove</button> --}}
        <button class="btn_view" onclick="ViewFreelanceSub(this.id)" id="freelance_view_{{$i}}" data-cate="{{$item}}"   data-cates_type="{{$cates->service_type}}">View</button>
      </div>

      <div class="col-md-12 sub_cate mt-2 mb-2" id="freelance_sub_cate_{{$i}}"></div>

          @else
          <div class="col-md-6 input_group2 main_freelance_{{$i}}">
            <input class="form-control" list="datalistOptions" value="{{$cates->category}} ({{$cates->service_type}})" id="car" readonly placeholder="Graphic Designer">
          </div>
          <div class="col-md-6 button_group2 main_freelance_{{$i}}">
            <button class="btn_reject"  onclick="RejectCategory(this.id)" id="reject_freelance_category_{{$i}}" data-category="{{$item}}"  data-type="Freelance">Reject</button>
            {{-- <button class="btn_approve">Aprrove</button> --}}
            <button class="btn_view" onclick="ViewFreelanceSub(this.id)" id="freelance_view_{{$i}}" data-cate="{{$item}}"   data-cates_type="{{$cates->service_type}}">View</button>
          </div> 
          <div class="col-md-12 sub_cate mt-2 mb-2" id="freelance_sub_cate_{{$i}}"></div>
          
            
          @endif
          @php  $i++ ;  @endphp
              @endforeach
          @endif
         
          </div>

          @endif
          @endif


          
           
          <div class="content">
            @php $experience_1 = explode(',',$app->experience) ;
             $k = 0; @endphp
            @foreach ($all_cates as $item)

            <div class="content_box1">
              <h5>Experience {{$item}} :</h5>
              <p> @if (isset($experience_1[$k])) {{$experience_1[$k]}} @else 0  @endif year</p>
              </div>

            
            @php $k++; @endphp
            @endforeach
         
            <div class="content_box2">
              @if ($app->portfolio == 'not_link')
                <h5>I don't have any link  </h5>
              @else 
              @php $portfolio_url = explode('|*|',$app->portfolio_url) ;
             $l = 0; @endphp
            @foreach ($all_cates as $item)

            <div class="content_box1">
              <h5>{{$item}} Link :</h5>
              @php
               if (isset($portfolio_url[$l])) {
                  $folio_1 =  $portfolio_url[$l] ;
                } else {  
                  $folio_1 =  ' ' ;  
                 }
                                  $cleanedUrl = str_replace(['[', ']'], '', $folio_1);
                 $urls_array = explode(',_,', $cleanedUrl);  @endphp
              
              @foreach ($urls_array as $urls_show)
              <a href="{{$urls_show}}" target="__">{{$urls_show}}</a> <br/>
                  
              @endforeach
              </div>

            
            @php $l++; @endphp
            @endforeach
               
              @endif
               
              </div>
              </div>
              <div class="footer">
                <button  class="btn_reject_all" data-bs-target="#ApplicationCategoryReject" data-bs-toggle="modal">Reject All</button>
                {{-- <button class="btn_approve_all">Approve All</button> --}}
                <button class="btn_confirm" data-bs-dismiss="modal">Close</button>
              </div>
          </div>
          </div>
        </div>

          
  <!-- Modal -->
<div class="modal fade logout-modal" id="ApplicationAction" tabindex="-1" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-body p-0">
      <h1>Are you really sure?</h1>
      <div class="btn-sec">
        <form action="/application-action" method="POST"> @csrf
          <center>
            <input type="hidden" name="app_id" value="{{$app->id}}" id="app_id">
            <input type="hidden" name="action" id="action_app">
            <button type="button" class="btn btn-no" data-bs-dismiss="modal">No</button>
            <button type="submit" class="btn btn-yes"><a style="color: white;text-decoration: none;"  >Yes</a></button>
          </center>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
<!--  -->
  <!-- Modal -->
<div class="modal fade logout-modal" id="ApplicationCategoryReject" tabindex="-1" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-body p-0">
      <h1>Are you really sure?</h1>
      <div class="btn-sec">
         
          <center>
          
            <button type="button" class="btn btn-no" data-bs-dismiss="modal">No</button>
            <button type="button" class="btn btn-yes"><a href="/reject-all-categories/{{$app->id}}" style="color: white;text-decoration: none;"  >Yes</a></button>
          </center>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
<!--  -->

{{-- Models For Rejection ==== --}}
<!-- Reject Modal -->
<div
class="modal fade"
id="refund-modal"
tabindex="-1"
aria-labelledby="exampleModalLabel"
aria-hidden="true"
>
<div class="modal-dialog">
  <div class="modal-content reject-modal">
    <div class="modal-body">
      <h3>Make Refund</h3>
      <p>Do you want to refund “Fast Track Application” Fee</p>
      <div class="buttuns-sec" role="" aria-label="Basic example">
        <button
          type="button" id="Yes"  onclick="RefundAmount(this.id)"
          class="btn yes-btns"
          data-bs-toggle="modal"
          data-bs-target="#yes-reject"
        >
          Yes
        </button>
        <button type="button" class="btn no-btns" id="No" onclick="RefundAmount(this.id)">No</button>
      </div>
    </div>
  </div>
</div>
</div>

<!-- Yes Reject Modal -->
<div
class="modal fade"
id="yes-reject"
tabindex="-1"
aria-labelledby="exampleModalLabel"
aria-hidden="true"
>
<div class="modal-dialog">
  <div class="modal-content reject-modal">
    <form action="/application-action" method="POST"> @csrf
    <div class="modal-body">
      <h3 class="reject-head">Reject Reason</h3>
      <textarea
        class="type-reason"
        name="reason"
        id=""
        rows="5"
        cols="5"
        placeholder="write here reason of Rejection "
      ></textarea>
      <input type="hidden" id="payment_refund" value="No" name="payment_refund">
      <input type="hidden" name="action" id="action">
      <input type="hidden" value="{{$app->id}}" id="app_id"  name="app_id" >
      <input type="hidden" value="{{$app->user_id}}" id="user_id" name="user_id" >
      <div
        class="buttuns-sec submit-sec"
        role=""
        aria-label="Basic example"
      >
        <button
          type="submit"
          class="btn no-btns submit"   >
          Submit
        </button>
      </div>
    </div>
  </form>
  </div>
</div>
</div>

<!-- Success Reject Modal -->
<div
class="modal fade"
id="reject-success"
tabindex="-1"
aria-labelledby="exampleModalLabel"
aria-hidden="true"
>
<div class="modal-dialog">
  <div class="modal-content reject-modal">
    <div class="modal-body">
      <h3>Successfully Refunded</h3>
      <p>“Fast Track Application” Fee is successfully Refunded.</p>
      <div
        class="buttuns-sec success-btn"
        role=""
        aria-label="Basic example"
      >
        <button type="button" class="btn no-btns success">Go Back</button>
      </div>
    </div>
  </div>
</div>
</div>
{{-- Models For Rejection ==== --}}

    <!-- =============================== FOOTER SECTION END HERE ===================================== -->
            <script src="assets/user/libs/jquery/jquery.js"></script>
            <script src="assets/user/libs/datatable/js/datatable.js"></script>
            <script src="assets/user/libs/datatable/js/datatablebootstrap.js"></script>
            <script src="assets/user/libs/select2/js/select2.min.js"></script>
            <script src="assets/user/libs/owl-carousel/js/owl.carousel.min.js"></script>
            <script src="assets/user/libs/aos/js/aos.js"></script>
            <script src="assets/public-site/asset/js/bootstrap.min.js"></script>
            <script src="assets/public-site/asset/js/script.js"></script>
            <!-- flatpicker  js start here-->
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <script>

function RefundAmount(Clicked) { 
  $('#payment_refund').val(Clicked);
  $("#yes-reject").modal('show');

 }
              function DoAction(Clicked) { 
 
              

                if (Clicked == 'approved') {
                  $('#action_app').val(Clicked);
                  $("#ApplicationAction").modal('show');
                  return false ;
                }
                $('#action').val(Clicked);
                var type = {{$app->app_type}} ;
                 
                if (type == 1) {
                  $("#refund-modal").modal('show');
                } else {
                  $("#yes-reject").modal('show');
                }
                
                // $("#ApplicationAction").modal('show');
               }


                                config = {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
}
                flatpickr("input[type=datetime-local]", config);
            </script>
                <!-- flatpicker  js end here-->
                {{-- SubCategory Fetch in Model Custom Start --}}
                <script>
                  function ViewClassSub(Clicked) { 

                    const get_num = Clicked.replace(/\D+/g, ''); // \D matches non-digit characters
 
                 var get_html =   $('#class_sub_cate_'+get_num).html();

                 if (get_html != '') {
                  $('#class_sub_cate_'+get_num).empty();
                  return false;
                 }

                 let cate_id  = $("#"+Clicked).data("cate");
                      // category = category.replace(/&amp;/g, "&");
 
                     var app_id = '<?php echo $app->id  ?>';
                     var service_type = '<?php echo $app->service_type  ?>';
                      // var all_sub_cate = '<?php echo $app->sub_category_class  ?>' ;
                      
                     
                      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "POST",
                url: '/get-class-sub-category',
                data:{ app_id:app_id, service_type:service_type, cate_id:cate_id, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {

                  ClassSubCate(response,Clicked);

                  
                },
              
            });
                       
                      
                    
                   }

                  //  Main Category Reject Function Start =======
                  function RejectCategory(Clicked) {

                    if (!confirm("Are You Sure, You Want to Remove ?")){
                            return false;
                        }
                    
                  var cate_id =   $('#'+Clicked).data('category'); 
                  var type =   $('#'+Clicked).data('type');
                  var app_id =  '<?php echo $app->id  ?>';
                 
                    
                       
                  $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "POST",
                url: '/reject-application-category',
                data:{ app_id:app_id, cate_id:cate_id, type:type, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {

                  const get_num = Clicked.replace(/\D+/g, '');
                  if (response.success) {
                    if (response.type == 'Class') {
                      $('#class_category').val(response['cate'].category_class);
                      $('#class_sub_category').val(response['cate'].sub_category_class);
                      $('.main_class_'+get_num).remove();
                      $('#class_sub_cate_'+get_num).remove();
                      }else{
                        $('#freelance_category').val(response['cate'].category_freelance);
                        $('#freelance_sub_category').val(response['cate'].sub_category_freelance);
                        $('.main_freelance_'+get_num).remove();
                        $('#freelance_sub_cate_'+get_num).remove();
                   } 
                  

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
                  
                  //  Main Category Reject Function END =======




                  function ViewFreelanceSub(Clicked) { 

                    const get_num = Clicked.replace(/\D+/g, ''); // \D matches non-digit characters
 
                 var get_html =   $('#freelance_sub_cate_'+get_num).html();

                 if (get_html != '') {
                  $('#freelance_sub_cate_'+get_num).empty();
                  return false;
                 }

                     var cate_id = $("#"+Clicked).data("cate"); 
 
                     var app_id = '<?php echo $app->id  ?>';
                     var service_type = '<?php echo $app->service_type  ?>';
                      // var all_sub_cate = '<?php echo $app->sub_category_class  ?>' ;
                      
                     
                      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "POST",
                url: '/get-class-sub-category',
                data:{ app_id:app_id, service_type:service_type, cate_id:cate_id, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {

                  FreelanceSubCate(response,Clicked);

                  
                },
              
            });
                       
                      
                    
                   }






                   function RejectSubCateClass(Clicked) { 

                    if (!confirm("Are You Sure, You Want to Remove ?")){
                            return false;
                        }
 
                    var sub_cate = $('#'+Clicked).data('cate');
                    var cates_type = $('#'+Clicked).data('cates_type');
                    var service_type = $('#'+Clicked).data('service_type');
                    const get_num = Clicked.replace(/\D+/g, ''); // \D matches non-digit characters
                     if (service_type == 'class_sub') {
                       var array = '<?php echo $app->sub_category_class  ?>' ;
                       array =  array.split('|*|');
                      
                       } else {
                       var array = '<?php echo $app->sub_category_freelance  ?>' ;
                       array =  array.split('|*|');
                      }
                     
                        if (cates_type == 'Online') {
                         array = array[0].split(',');
                         } else {
                         array = array[1].split(',');
                        }
                         
                                                
                          // Remove the string from the array
                          const updatedArray = array.reduce((acc, item) => {
                              if (item !== sub_cate) {
                                  acc.push(item);
                              }
                              return acc;
                          }, []);
                          var app_id = '<?php echo $app->id  ?>';
                          var sub_category = updatedArray ;

                          sub_category = sub_category.join(',');
                           
                            
                          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "POST",
                url: '/reject-class-sub-category',
                data:{ app_id:app_id, service_type:service_type, sub_category:sub_category, cates_type:cates_type, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {

                  if (response.success) {

                    if (response.service_type == 'class_sub') {
                      console.log('class_sub_delete');
                      
                      $('#class_sub_cate_div_'+get_num).remove();
                      $('#class_sub_category').val(response.sub_category);
                    } else {
                      console.log('freelance_sub_delete');
                        $('#freelance_sub_cate_div_'+get_num).remove();
                      $('#freelance_sub_category').val(response.sub_category);
                      
                    }

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


                    function ClassSubCate(response,Clicked) { 

                      var cate_get = response['sub_cate'];
                       
                      
                      if (cate_get == null) {
                        toastr.options =
                        {
                            "closeButton" : true,
                             "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                        }
                    toastr.error("Not Have Sub Categories in This!");
                    return false;
                      }
                   
                      var array1 = cate_get;
                      let cleanedArray1 = array1.map(item => item.trim());
                      var cate_have = '<?php echo $app->sub_category_class  ?>' ;
                      cate_have =  cate_have.split('|*|');
                      var cates_type = $('#'+Clicked).data('cates_type');
                      let array2;
                    if (cates_type === 'Online' && cate_have[0]) {
                     array2 = cate_have[0].split(',');
                     } else if (cate_have[1]) {
                     array2 = cate_have[1].split(',');
                     } else {
                     array2 = []; // Default to an empty array if no valid data is found
                        }
                    let cleanedArray2 = array2.map(item => item.trim());
                   
                    const commonElements = cleanedArray1.filter(item => cleanedArray2.includes(item));
                  
                       
                    if (commonElements.length == 0) {
                      toastr.options =
                        {
                            "closeButton" : true,
                             "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                        }
                    toastr.error("Not Have Sub Categories in This!");
                    return false;
                    }
                    const get_num = Clicked.replace(/\D+/g, ''); // \D matches non-digit characters
 
                    $('#class_sub_cate_'+get_num).empty();

                    var sub_cate_html = '';
                   
                      for (let i = 0; i < commonElements.length; i++) {
                        const element = commonElements[i];
                          if (i == 0) {
                            sub_cate_html += '<label for="car" class="form-label">Class Sub Category</label>';
                            }
                        sub_cate_html +=  '<div class="row" id="class_sub_cate_div_'+i+'">'+
                                            '<div class="col-md-6 input_group2">'+
                                              '<input class="form-control" list="datalistOptions" value="'+element+'" id="car" readonly placeholder="Graphic Designer">'+
                                            '</div>'+
                                            '<div class="col-md-6 button_group2">'+
                                              '<button class="btn_reject" onclick="RejectSubCateClass(this.id)" id="sub_cate_'+i+'" data-cate="'+element+'" data-service_type="class_sub"  data-cates_type="'+cates_type+'">Reject</button>'+
                                            '</div> '+
                                          '</div>';

                                          
                                        }
                                        $('#class_sub_cate_'+get_num).append(sub_cate_html);
                    
                    

                     }



                    function FreelanceSubCate(response,Clicked) { 

                      var cate_get = response['sub_cate'];
                      if (cate_get == null) {
                        toastr.options =
                        {
                            "closeButton" : true,
                             "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                        }
                    toastr.error("Not Have Sub Categories in This!");
                    return false;
                      }

                      
                      var array1 = cate_get;
                      let cleanedArray1 = array1.map(item => item.trim());
                    var cate_have = '<?php echo $app->sub_category_freelance  ?>' ;
                    cate_have =  cate_have.split('|*|');
                    var cates_type = $('#'+Clicked).data('cates_type');
                    let array2;
                    if (cates_type === 'Online' && cate_have[0]) {
                     array2 = cate_have[0].split(',');
                     } else if (cate_have[1]) {
                     array2 = cate_have[1].split(',');
                     } else {
                     array2 = []; // Default to an empty array if no valid data is found
                        }
                    let cleanedArray2 = array2.map(item => item.trim());
                   
                    const commonElements = cleanedArray1.filter(item => cleanedArray2.includes(item));
           
                   
                  
                    if (commonElements.length == 0) {
                      toastr.options =
                        {
                            "closeButton" : true,
                             "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                        }
                    toastr.error("Not Have Sub Categories in This!");
                    return false;
                    }
                    const get_num = Clicked.replace(/\D+/g, ''); // \D matches non-digit characters
 
                    $('#freelance_sub_cate_'+get_num).empty();

                    var sub_cate_html = '';
                   
                      for (let i = 0; i < commonElements.length; i++) {
                        const element = commonElements[i];
                          if (i == 0) {
                            sub_cate_html += '<label for="car" class="form-label">Freelance Sub Category</label>';
                            }
                        sub_cate_html +=  '<div class="row" id="freelance_sub_cate_div_'+i+'">'+
                                            '<div class="col-md-6 input_group2">'+
                                              '<input class="form-control" list="datalistOptions" value="'+element+'" id="car" readonly placeholder="Graphic Designer">'+
                                            '</div>'+
                                            '<div class="col-md-6 button_group2">'+
                                              '<button class="btn_reject" onclick="RejectSubCateClass(this.id)" id="sub_cate_'+i+'" data-cate="'+element+'" data-service_type="freelance_sub"  data-cates_type="'+cates_type+'">Reject</button>'+
                                            '</div> '+
                                          '</div>';

                                          
                                        }
                                        $('#freelance_sub_cate_'+get_num).append(sub_cate_html);
                    
                    

                     }



                </script>
                {{-- SubCategory Fetch in Model Custom END --}}
                <!-- add input js -->
                <script>
                  $(document).ready(function () {
                    var maxField = 10; //Input fields increment limitation
                    var addButton = $(".add_button"); //Add button selector
                    var wrapper = $(".field_wrapper"); //Input field wrapper
                    var fieldHTML =
                      '<div class="d-flex mt-2"><input type="text" name="field_name[]" value="" class="form-control" style="width:95%" placeholder="https://bravemindstudio.com/"/><a href="javascript:void(0);" class="remove_button"><img src="../Become-expert/assets/img/remove-icon.svg"/></a></div>'; //New input field html
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
</body>

</html>