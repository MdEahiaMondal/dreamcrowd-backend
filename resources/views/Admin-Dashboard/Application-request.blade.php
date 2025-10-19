<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="/public">
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <!-- View Point scale to 1.0 -->
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
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.2.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>
    <!-- Bootstrap css -->
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/admin/asset/css/bootstrap.min.css"
    />
    <link
      href="assets/admin/asset/css/fontawesome.min.css"
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.1/js/bootstrap.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  

    {{-- =======Toastr CDN ======== --}}
    <link rel="stylesheet" type="text/css" 
    href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- =======Toastr CDN ======== --}}
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/user/asset/css/application-request.css" />
    <link rel="stylesheet" href="assets/public-site/asset/css/Drop.css" />
    <link rel="stylesheet" href="assets/expert/asset/css/style.css" />
<link rel="stylesheet" href="assets/public-site/asset/css/navbar.css">

    <title>Become An Expert | Profile</title>
  </head>

  <style>

    .view-button {
       border-radius: 4px;
       background: #0072b1;
       padding: 8px 28px;
       color: #fff;
       font-family: Roboto;
       font-size: 20px;
       font-weight: 500;
       line-height: normal;
   }
    .remove-button {
       border-radius: 4px;
       background: #fc5757;
       padding: 8px 28px;
       color: #fff;
       font-family: Roboto;
       font-size: 20px;
       font-weight: 500;
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


        @if ($request->request_type == 'profile')

        {{-- Old Details Profile --}}

        
        <div
          class="tab-pane show active"
          id="tab1"
          role="tabpanel"
          aria-labelledby="tab1-tab"
        >
          <div class="row">
            <div class="col-lg-12">
              <div class="top-head">
                <h1> Profile Old Details</h1>
              </div>
              <!-- =================================================== -->
              
             

              <div class="row">
                <div class="col-md-12">
                  <div class="main-tab-sec">
                    <div class="row">
                      <div class="col-md-2">
                        <div class="avatar-upload">
                          
                          @if ($expert->profile_image != null)
                          <div class="avatar-preview">
                            <div
                              id="imagePreview"
                              style="
                                background-image: url('assets/profile/img/{{$expert->profile_image}}');
                                width: 100%;
                              "
                            ></div>
                          </div>
                          @endif
                         
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
                            type="text" value="{{$expert->first_name}}" readonly
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
                            type="text" value="{{$expert->last_name}}" readonly
                            class="form-control"
                            id="exampleFormControlInput1"
                            placeholder="eg. Aslam"
                          />
                        </div>
                      </div>

                                            <div class="col-md-6">
                        <label class="form-label"
                          >Full Name Show</label
                        > 
                        <div class="form-check form-switch col-md-12">
                          <input class="form-check-input" type="checkbox" role="switch" id="show_full_name_finel" @if ($expert->show_full_name == 1)  checked  @endif  disabled> 
                          <label class="form-label form-check-label" style="margin-top: 0px;" for="show_full_name_finel"
                          > @if ($expert->show_full_name == 1)  YES @else No  @endif</label
                        >
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="">
                          <label
                            for="exampleFormControlInput1"
                            class="form-label"
                            >Gender <span>*</span></label
                          >
                          <input
                            type="text" value="{{$expert->gender}}" readonly
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
                            type="text"  value="{{$expert->profession}}" readonly
                            class="form-control"
                            id="exampleFormControlInput1"
                            placeholder="eg. Graphic Designer"
                          />
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="">
                          <label
                            for="exampleFormControlInput1"
                            class="form-label"
                            >Primary Language <span>*</span></label
                          >
                           
                          <input
                            type="text"  value="{{$expert->primary_language}}" readonly
                            class="form-control"
                            id="exampleFormControlInput1"
                            placeholder="eg. Graphic Designer"
                          />
                        </div>
                      </div>


                      @if ($expert->primary_language != 'English' )
                      <div class="col-md-6">
                        <div class="">
                          <label
                            for="exampleFormControlInput1"
                            class="form-label"
                            >Fluent English <span>*</span></label
                          >
                           
                          <input
                            type="text"  value="{{$expert->fluent_english}}" readonly
                            class="form-control"
                            id="exampleFormControlInput1"
                            placeholder="eg. Graphic Designer"
                          />
                        </div>
                      </div>
                      @endif
                      

                      <div class="col-md-6">
                        <label class="form-label"
                          >Do you speak other languages fluently?</label
                        > 
                        <div class="form-check form-switch col-md-12">
                          <input class="form-check-input" type="checkbox" role="switch" id="speak_other_language_finel" @if ($expert->speak_other_language == 1)  checked  @endif  disabled> 
                          <label class="form-label form-check-label" style="margin-top: 0px;" for="speak_other_language_finel"
                          > @if ($expert->speak_other_language == 1)  YES @else No  @endif</label
                        >
                        </div>
                      </div>

                      @if ($expert->speak_other_language == 1)

                      <div class="col-md-6">
                        <div class="">
                          <label
                            for="exampleFormControlInput1"
                            class="form-label"
                            >Other Language <span>*</span></label
                          >
                           
                          <input
                            type="text"  value="{{$expert->fluent_other_language}}" readonly
                            class="form-control"
                            id="exampleFormControlInput1"
                            placeholder="eg. Graphic Designer"
                          />
                        </div>
                      </div>

                      @endif

                      <div class="col-md-12">
                        <div class="">
                          <label
                            for="exampleFormControlInput1"
                            class="form-label"
                            >Overview <span>*</span></label
                          >
                           
                          <textarea class="form-control" disabled name="" id="" cols="30" rows="10">{{$expert->overview}}</textarea>
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="">
                          <label
                            for="exampleFormControlInput1"
                            class="form-label"
                            >About Me <span>*</span></label
                          >
                           
                          <textarea class="form-control" disabled name="" id="" cols="30" rows="10">{{$expert->about_me}}</textarea>
                        </div>
                      </div>


                      @if ($expert->main_image != null)
                      <div class="col-md-12">
                        <label class="form-label"
                          >Main Image <span>*</span></label
                        >
                        <div>
                          <img src="assets/expert/asset/img/{{$expert->main_image}}" style="width: 460px;height: 250px;" alt="">
                        </div>
                        </div>
                      @endif
                      
                      <div class="col-md-12 mt-4">
                        <label class="form-label"
                          >More Images <span>*</span></label
                        >

                        <div class="row">

                        @if ($expert->more_image_1 != null)
                          <div class="col-md-4">
                            <img src="assets/expert/asset/img/{{$expert->more_image_1}}" style="width: 100%;height: 250px;" alt="">

                          </div>
                          @endif

                        @if ($expert->more_image_2 != null)
                          <div class="col-md-4">
                            <img src="assets/expert/asset/img/{{$expert->more_image_2}}" style="width: 100%;height: 250px;" alt="">

                          </div>
                          @endif

                        @if ($expert->more_image_3 != null)
                          <div class="col-md-4">
                            <img src="assets/expert/asset/img/{{$expert->more_image_3}}" style="width: 100%;height: 250px;" alt="">

                          </div>
                          @endif

                        @if ($expert->more_image_4 != null)
                          <div class="col-md-4">
                            <img src="assets/expert/asset/img/{{$expert->more_image_4}}" style="width: 100%;height: 250px;" alt="">

                          </div>
                          @endif

                        @if ($expert->more_image_5 != null)
                          <div class="col-md-4">
                            <img src="assets/expert/asset/img/{{$expert->more_image_5}}" style="width: 100%;height: 250px;" alt="">

                          </div>
                          @endif

                        @if ($expert->more_image_6 != null)
                          <div class="col-md-4">
                            <img src="assets/expert/asset/img/{{$expert->more_image_6}}" style="width: 100%;height: 250px;" alt="">

                          </div>
                          @endif


                        </div>
                  
                    
                        </div>
                      
                        @if ($expert->video != null)
                        
                        <div class="col-md-12 mt-4">
                          <label class="form-label"
                            >Video <span>*</span></label
                          >
                          <video controls src="assets/expert/asset/img/{{$expert->video}}" style="width: 460px;height: 250px;"></video>
                        
                      </div>

                        @endif
                    
                      
                    </div>
                  </div>
                  <!-- =========== BUTTONS SECTION ============  -->
                  
                </div>
              </div>
                  
              

            </div>
          </div>
        </div>
  


        {{-- Profile New Details --}}

        <div
          class="tab-pane show active"
          id="tab1"
          role="tabpanel"
          aria-labelledby="tab1-tab"
        >
          <div class="row">
            <div class="col-lg-12">
              <div class="top-head">
                <h1> Profile New Details</h1>
              </div>
              <!-- =================================================== -->
              
             

              <div class="row">
                <div class="col-md-12">
                  <div class="main-tab-sec">
                    <div class="row">
                      <div class="col-md-2">
                        <div class="avatar-upload">
                          
                          @if ($main->profile_image != null)
                          <div class="avatar-preview">
                            <div
                              id="imagePreview"
                              style="
                                background-image: url('assets/profile/img/{{$main->profile_image}}');
                                width: 100%;
                              "
                            ></div>
                          </div>
                          @endif
                         
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
                            type="text" value="{{$main->first_name}}" readonly
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
                            type="text" value="{{$main->last_name}}" readonly
                            class="form-control"
                            id="exampleFormControlInput1"
                            placeholder="eg. Aslam"
                          />
                        </div>
                      </div>

                                         <div class="col-md-6">
                        <label class="form-label"
                          >Full Name Show</label
                        > 
                        <div class="form-check form-switch col-md-12">
                          <input class="form-check-input" type="checkbox" role="switch" id="show_full_name" @if ($main->show_full_name == 1)  checked  @endif  disabled> 
                          <label class="form-label form-check-label" style="margin-top: 0px;" for="show_full_name"
                          > @if ($main->show_full_name == 1)  YES @else No  @endif</label
                        >
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="">
                          <label
                            for="exampleFormControlInput1"
                            class="form-label"
                            >Gender <span>*</span></label
                          >
                          <input
                            type="text" value="{{$main->gender}}" readonly
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
                            type="text"  value="{{$main->profession}}" readonly
                            class="form-control"
                            id="exampleFormControlInput1"
                            placeholder="eg. Graphic Designer"
                          />
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="">
                          <label
                            for="exampleFormControlInput1"
                            class="form-label"
                            >Primary Language <span>*</span></label
                          >
                           
                          <input
                            type="text"  value="{{$main->primary_language}}" readonly
                            class="form-control"
                            id="exampleFormControlInput1"
                            placeholder="eg. Graphic Designer"
                          />
                        </div>
                      </div>


                      @if ($main->primary_language != 'English')
                      <div class="col-md-6">
                        <div class="">
                          <label
                            for="exampleFormControlInput1"
                            class="form-label"
                            >Fluent English <span>*</span></label
                          >
                           
                          <input
                            type="text"  value="{{$main->fluent_english}}" readonly
                            class="form-control"
                            id="exampleFormControlInput1"
                            placeholder="eg. Graphic Designer"
                          />
                        </div>
                      </div>

                      @endif
                      <div class="col-md-6">
                        <label class="form-label"
                          >Do you speak other languages fluently?</label
                        > 
                        <div class="form-check form-switch col-md-12">
                          <input class="form-check-input" type="checkbox" role="switch" id="speak_other_language_finel" @if ($main->speak_other_language == 1)  checked  @endif  disabled> 
                          <label class="form-label form-check-label" style="margin-top: 0px;" for="speak_other_language_finel"
                          > @if ($main->speak_other_language == 1)  YES @else No  @endif</label
                        >
                        </div>
                      </div>

                      @if ($main->speak_other_language == 1)
                      <div class="col-md-6">
                        <div class="">
                          <label
                            for="exampleFormControlInput1"
                            class="form-label"
                            >Other Language <span>*</span></label
                          >
                           
                          <input
                            type="text"  value="{{$main->other_language}}" readonly
                            class="form-control"
                            id="exampleFormControlInput1"
                            placeholder="eg. Graphic Designer"
                          />
                        </div>
                      </div>

                      @endif

                      <div class="col-md-12">
                        <div class="">
                          <label
                            for="exampleFormControlInput1"
                            class="form-label"
                            >Overview <span>*</span></label
                          >
                           
                          <textarea class="form-control" disabled name="" id="" cols="30" rows="10">{{$main->overview}}</textarea>
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="">
                          <label
                            for="exampleFormControlInput1"
                            class="form-label"
                            >About Me <span>*</span></label
                          >
                           
                          <textarea class="form-control" disabled name="" id="" cols="30" rows="10">{{$main->about_me}}</textarea>
                        </div>
                      </div>


                      @if ($main->main_image != null)
                      <div class="col-md-12">
                        <label class="form-label"
                          >Main Image <span>*</span></label
                        >
                        <div>
                          <img src="assets/expert/asset/img/{{$main->main_image}}" style="width: 460px;height: 250px;" alt="">
                        </div>
                        </div>
                      @endif
                      
                      <div class="col-md-12 mt-4">
                        <label class="form-label"
                          >More Images <span>*</span></label
                        >

                        <div class="row">

                        @if ($main->more_image_1 != null)
                          <div class="col-md-4">
                            <img src="assets/expert/asset/img/{{$main->more_image_1}}" style="width: 100%;height: 250px;" alt="">

                          </div>
                          @endif

                        @if ($main->more_image_2 != null)
                          <div class="col-md-4">
                            <img src="assets/expert/asset/img/{{$main->more_image_2}}" style="width: 100%;height: 250px;" alt="">

                          </div>
                          @endif

                        @if ($main->more_image_3 != null)
                          <div class="col-md-4">
                            <img src="assets/expert/asset/img/{{$main->more_image_3}}" style="width: 100%;height: 250px;" alt="">

                          </div>
                          @endif

                        @if ($main->more_image_4 != null)
                          <div class="col-md-4">
                            <img src="assets/expert/asset/img/{{$main->more_image_4}}" style="width: 100%;height: 250px;" alt="">

                          </div>
                          @endif

                        @if ($main->more_image_5 != null)
                          <div class="col-md-4">
                            <img src="assets/expert/asset/img/{{$main->more_image_5}}" style="width: 100%;height: 250px;" alt="">

                          </div>
                          @endif

                        @if ($main->more_image_6 != null)
                          <div class="col-md-4">
                            <img src="assets/expert/asset/img/{{$main->more_image_6}}" style="width: 100%;height: 250px;" alt="">

                          </div>
                          @endif


                        </div>
                  

                        </div>
                        

                        @if ($main->video != null)
                        
                        <div class="col-md-12 mt-4">
                          <label class="form-label"
                            >Video <span>*</span></label
                          >
                          <video controls src="assets/expert/asset/img/{{$main->video}}" style="width: 460px;height: 250px;"></video>
                        
                      </div>

                        @endif
                    
                    
                      
                    </div>
                  </div>
                  <!-- =========== BUTTONS SECTION ============  -->
                  
                </div>
              </div>
                  
              

            </div>
          </div>
        </div>

        <!-- =========== BUTTONS SECTION ============  -->

          
          <div class="row">
            <div class="col-md-12">
              <div class="buttons-sec">
                <a href="/reject-seller-request/{{$request->id}}"  class="btn reject-btn ">
                  Reject
                </a>
                {{-- <button type="button" class="btn custom-btn" data-bs-target="#custom-approve-modal" data-bs-toggle="modal">
                  Custom Approved
                </button> --}}
                <a href="/approve-seller-request/{{$request->id}}"  class="btn approve-btn">
                  Approved
                </a>
              </div>
            </div>
          </div>
   
          
        @endif


        @if ($request->request_type == 'category' )

        <div class="row">
          <div class="col-lg-12">
            <div class="top-head">
              <h1>New Category</h1>
            </div>
            <!-- =================================================== -->
            <div class="row">
              <div class="col-md-12">
                <div class="main-tab-sec">
                  <!--  -->

                     <div class="col-md-12 mt-4">

                      @if ($main->category != null)
              
                     
                      <div class="col-md-12">
                        <div class="">
                          <label
                            for="exampleFormControlInput1"
                            class="form-label"
                            >Category Role <span>*</span></label
                          >
                           
                          <input
                            type="text"  value="{{$main->category_role}}" readonly
                            class="form-control"
                            id="exampleFormControlInput1"
                            placeholder="eg. Graphic Designer"
                          />
                        </div>
                      </div>
                          
                      
                      <div class="col-md-12 faq-sec">
                        <h2 class="category-title form-label">Categories</h2>
                        <div id="categoryContainer" class="profile-form">

                        
                        @php $category = explode(',',$main->category) @endphp
                        @php $cates = \App\Models\Category::find($main->category) ; @endphp
                        @if (count($category) == 1)
                        <div class="input-group mb-3 category main_class_1">
                          <input
                            type="text"  value="{{$cates->category}} ({{$cates->service_type}})"
                            class="form-control"
                            placeholder="Front Developer"
                            aria-label="Recipient's username"
                            aria-describedby="button-addon1"
                            readonly
                          />
                          <button
                          class=" btn btn-outline-secondary remove-button"
                          type="button" style="display: none" 
                          onclick="RejectCategory(this.id)" id="reject_class_category_1" data-category="{{$main->category}}"  data-type="$main->category_role" 
                        >Rejeect</button>
                          <button
                            class="btn view-button"
                            type="button"
                             
                             onclick="ViewClassSub(this.id)" id="class_view_1" data-cate="{{$main->category}}"   data-type="$main->category_role"    data-cates_type="{{$cates->service_type}}"
                          >View</button>
                        </div>
                    <div class="col-md-12 sub_cate mt-2" id="class_sub_cate_1"></div>
                      @else
                      @php  $i =1 ;  @endphp
                      @foreach ($category as $item)
                      @php $cates = \App\Models\Category::find($item) ; @endphp
                      @if ($i == 1)
            
                      <div class="input-group mb-3 category main_class_{{$i}}">
                        <input
                          type="text"  value="{{$cates->category}} ({{$cates->service_type}})"
                          class="form-control"
                          placeholder="Front  Developer"
                          aria-label="Recipient's username"
                          aria-describedby="button-addon{{$i}}"
                          readonly
                        />
                        <button
                        class=" btn btn-outline-secondary remove-button"
                        type="button" style="display: none"
                        onclick="RejectCategory(this.id)" id="reject_class_category_{{$i}}" data-category="{{$item}}"  data-type="{{$main->category_role}}" 
                      >Rejeect</button>
                        <button
                          class="btn view-button"
                          type="button"
                           
                           onclick="ViewClassSub(this.id)" id="class_view_{{$i}}" data-cate="{{$item}}" data-type="{{$main->category_role}}"   data-cates_type="{{$cates->service_type}}"
                        >View</button>
                      </div>
            
                  <div class="col-md-12 sub_cate mt-2 mb-2" id="class_sub_cate_{{$i}}"></div>
            
                      @else
                      <div class="input-group mb-3 category main_class_{{$i}}">
                        <input
                          type="text"  value="{{$cates->category}} ({{$cates->service_type}})"
                          class="form-control"
                          placeholder="Front End Developer"
                          aria-label="Recipient's username"
                          aria-describedby="button-addon{{$i}}"
                          readonly
                        />
                        <button
                        class="btn btn-outline-secondary remove-button"
                        type="button" style="display: none"
                        onclick="RejectCategory(this.id)" id="reject_class_category_{{$i}}" data-category="{{$item}}" data-type="{{$main->category_role}}" 
                      >Rejeect</button>
                        <button
                          class="btn view-button"
                          type="button"
                          onclick="ViewClassSub(this.id)" id="class_view_{{$i}}" data-cate="{{$item}}" data-type="{{$main->category_role}}"   data-cates_type="{{$cates->service_type}}"
                        >View</button>
                      </div>
                      <div class="col-md-12 sub_cate mt-2 mb-2" id="class_sub_cate_{{$i}}"></div>
                      
                        
                      @endif
                      @php  $i++ ;  @endphp
                          @endforeach
                      @endif
                     
                    </div>
                  </div>
            
                  @if ($main->portfolio == 'not_link')
                      
                  <div class="col-md-12">
                    <div class="">
                      <label
                        for="exampleFormControlInput1"
                        class="form-label"
                        > Url <span>*</span></label>
                        <input
                        type="text"  value="I didn't Have Link" readonly
                        class="form-control"
                        id="exampleFormControlInput1"
                        placeholder="eg. Graphic Designer"
                      />
                    </div>
                  </div>

                  @else

                  @php
                  $url = explode('|*|',$main->portfolio_url )  ;
              @endphp
                  
                  @foreach ($url as $item)

                  <div class="col-md-12">
                    <div class="">
                      <label
                        for="exampleFormControlInput1"
                        class="form-label"
                        > Url :- <span>*</span></label
                      >
                      @php  $cleanedUrl = str_replace(['[', ']'], '', $item);
                       $urls_show = explode(',_,',$cleanedUrl )  ; @endphp
                      @foreach ($urls_show as $show_url)
                      <a class="portfolio_url" style="color: #8a8c8e; text-decoration: underline;" href="{{$show_url}}" target="__">{{$show_url}}</a>
                          
                      @endforeach
                      <style>
                        .portfolio_url:hover{
                          color: #0072b1 !important;
                        }
                      </style>
                    </div>
                  </div>
                  @endforeach
              
        
                      
                  @endif
                 
                      
             
             
             
                      @endif

                         
                      </div>
                   

                      @if ($main->certificate != null)

                      <div class="col-md-6 mt-3">
                         <img src="assets/teacher/asset/img/certificate/{{$main->certificate}}" style="height: 300px;width: 100%;" alt="">
                      </div>
                          
                      @endif



                </div>
              </div>
            </div>
          </div>
        </div>


         
        <div class="row">
          <div class="col-md-12">
            <div class="buttons-sec">
              <a href="/reject-seller-request/{{$request->id}}"  class="btn reject-btn ">
                Reject
              </a>
              {{-- <button type="button" class="btn custom-btn" data-bs-target="#custom-approve-modal" data-bs-toggle="modal">
                Custom Approved
              </button> --}}
              <a href="/approve-seller-request/{{$request->id}}"  class="btn approve-btn">
                Approved
              </a>
            </div>
          </div>
        </div>
        
            
        @endif
      
         
          <!-- ========================================== -->
        
        </div>
  
        
        @if ($request->request_type == 'location')

        {{-- Old Location Details --}}

        <div class="row">
          <div class="col-lg-12">
            <div class="tab-content" id="side-menu-tabContent">
            <div class="top-head">
              <h1>Old Location Details</h1>
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
                          >Street Address <span>*</span></label
                        >
                         
                        <input
                          type="text"  value="{{$expert->street_address}}" readonly
                          class="form-control"
                          id="exampleFormControlInput1"
                          placeholder="eg. Graphic Designer"
                        />
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="">
                        <label
                          for="exampleFormControlInput1"
                          class="form-label"
                          >Country <span>*</span></label
                        >
                         
                        <input
                          type="text"  value="{{$expert->country}}" readonly
                          class="form-control"
                          id="exampleFormControlInput1"
                          placeholder="eg. Graphic Designer"
                        />
                      </div>
                    </div>

                     <div class="col-md-6">
                      <div class="">
                        <label
                          for="exampleFormControlInput1"
                          class="form-label"
                          >City <span>*</span></label
                        >
                         
                        <input
                          type="text"  value="{{$expert->city}}" readonly
                          class="form-control"
                          id="exampleFormControlInput1"
                          placeholder="eg. Graphic Designer"
                        />
                      </div>
                    </div>
                   
                    <div class="col-md-6">
                      <div class="">
                        <label
                          for="exampleFormControlInput1"
                          class="form-label"
                          >Zip Code <span>*</span></label
                        >
                         
                        <input
                          type="text"  value="{{$expert->zip_code}}" readonly
                          class="form-control"
                          id="exampleFormControlInput1"
                          placeholder="eg. Graphic Designer"
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


        {{-- New Location Details --}}

        <div class="row">
          <div class="col-lg-12">
            <div class="tab-content" id="side-menu-tabContent">
            <div class="top-head">
              <h1>New Location Details</h1>
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
                          >Country <span>*</span></label
                        >
                         
                        <input
                          type="text"  value="{{$main->street_address}}" readonly
                          class="form-control"
                          id="exampleFormControlInput1"
                          placeholder="eg. Graphic Designer"
                        />
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="">
                        <label
                          for="exampleFormControlInput1"
                          class="form-label"
                          >Country <span>*</span></label
                        >
                         
                        <input
                          type="text"  value="{{$main->country}}" readonly
                          class="form-control"
                          id="exampleFormControlInput1"
                          placeholder="eg. Graphic Designer"
                        />
                      </div>
                    </div>

                     <div class="col-md-6">
                      <div class="">
                        <label
                          for="exampleFormControlInput1"
                          class="form-label"
                          >City <span>*</span></label
                        >
                         
                        <input
                          type="text"  value="{{$main->city}}" readonly
                          class="form-control"
                          id="exampleFormControlInput1"
                          placeholder="eg. Graphic Designer"
                        />
                      </div>
                    </div>
                   
                    <div class="col-md-6">
                      <div class="">
                        <label
                          for="exampleFormControlInput1"
                          class="form-label"
                          >Zip Code <span>*</span></label
                        >
                         
                        <input
                          type="text"  value="{{$main->zip_code}}" readonly
                          class="form-control"
                          id="exampleFormControlInput1"
                          placeholder="eg. Graphic Designer"
                        />
                      </div>
                    </div>
                   
                   
                    <div class="col-md-12">
                      <div class="">
                        <label
                          for="exampleFormControlInput1"
                          class="form-label"
                          >Reason <span>*</span></label
                        >

                         <textarea class="form-control" disabled name="" id="" cols="30" rows="10">{{$main->reason}}</textarea>
                     
                      </div>
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
            <a href="/reject-seller-request/{{$request->id}}"  class="btn reject-btn ">
              Reject
            </a>
            {{-- <button type="button" class="btn custom-btn" data-bs-target="#custom-approve-modal" data-bs-toggle="modal">
              Custom Approved
            </button> --}}
            <a href="/approve-seller-request/{{$request->id}}"  class="btn approve-btn">
              Approved
            </a>
          </div>
        </div>
      </div>
            
        @endif

         
       
         
       
      </div>
  </div>
  </div>
</div>
    <!-- =FOOTER-TOP RELATED SECTION BECOM ANB EXPERT END= -->
   <!-- ============================= FOOTER SECTION START HERE ===================================== -->
   <div class="container-fluid footer-section">
    <div class="container">
      <div class="row">
        <div class="col-md-5">
          <img src="assets/admin/asset/img/Logo.png" alt="" />
          <p>
            Transforming your furry friend's unique personality into a work
            <br />of art that you'll treasure forever. Specializing in
            high-quality, <br />hand-drawn pet portraits.
          </p>
          <div class="social-icons">
            <a href=""><i class="fa-brands fa-facebook-f"></i></a>
            <a href=""><i class="fa-brands fa-instagram"></i></a>
            <a href=""><i class="fa-brands fa-pinterest"></i></a>
            <a href=""><i class="fa-brands fa-twitter"></i></a>
            <a href=""><i class="fa-brands fa-tiktok"></i></a>
            <a href=""><i class="fa-brands fa-youtube"></i></a>
          </div>
          <h3>Subscribe to our newsletter</h3>
          <div class="input-group mb-3 inp">
            <input
              type="text"
              class="form-control fc"
              placeholder="Enter Your Email...."
              aria-label="Recipient's username"
              aria-describedby="button-addon2"
            />
            <button
              class="btn btn-outline-secondary"
              type="button"
              id="button-addon2"
            >
              Subscribe
            </button>
          </div>
        </div>
        <div class="col-md-7">
          <div class="row">
            <div class="col-md-4 footer-links-section">
              <h6 class="text-center">Company</h6>
              <ul class="footer-links">
                <li><a href="#">Home</a></li>
                <li><a href="#">About us</a></li>
                <li><a href="#">Contact us</a></li>
                <li><a href="#">How it works</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms & Conditions</a></li>
              </ul>
            </div>
            <div class="col-md-4 footer-links-section">
              <h6 class="text-center">Seller/Expert</h6>
              <ul class="footer-links">
                <li><a href="#">Become a Seller</a></li>
                <li><a href="#">Login</a></li>
                <li><a href="#">FAQ’s</a></li>
              </ul>
            </div>
            <div class="col-md-4 footer-links-section">
              <h6 class="text-center">Buyer/Client</h6>
              <ul class="footer-links">
                <li><a href="#">Register</a></li>
                <li><a href="#">Login</a></li>
                <li><a href="#">FAQ’s</a></li>
              </ul>
            </div>
          </div>
        </div>
        <hr class="bordr" />
        <!-- ==================== FOOTER COPYRIGHT SECTION START FROM HERE =================== -->
        <div class="row footer-bottom">
          <div class="col-lg-10 col-md-9 col-12">
            <p>&copy; 2023 DREAMCROWD. All Rights Reserved.</p>
          </div>
          <div class="col-lg-2 col-md-3 col-12 footer-selector">
            <select class="select2-icon" name="icon">
              <option value="fa-globe" data-icon="fa-globe">
                Select Currency
              </option>
              <option value="fa-dollar-sign" data-icon="fa-dollar-sign">
                USD
              </option>
              <option value="fa-euro-sign" data-icon="fa-euro-sign">
                EUR
              </option>
              <option value="fa-sterling-sign" data-icon="fa-sterling-sign">
                GBP
              </option>
              <option value="fa-shekel-sign" data-icon="fa-shekel-sign">
                ILS
              </option>
            </select>
          </div>
        </div>
        <!-- ==================== FOOTER COPYRIGHT SECTION ENDED HERE =================== -->
      </div>
    </div>
  </div>
  <!-- =============================== FOOTER SECTION END HERE ===================================== -->
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


{{-- Categories Fewtch And Remove Script Start =========== --}}
<script>

function ViewClassSub(Clicked) { 

const get_num = Clicked.replace(/\D+/g, ''); // \D matches non-digit characters



let cate_id  = $("#"+Clicked).data("cate");

var request_id = '<?php echo $request->id  ?>';
// var all_sub_cate = '<?php echo $main->sub_category  ?>' ;
var service_role  = $("#"+Clicked).data("type");
  
 
  $.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});

$.ajax({
type: "POST",
url: '/get-requested-sub-category',
data:{ request_id:request_id, service_role:service_role, cate_id:cate_id, _token: '{{csrf_token()}}'},
dataType: 'json',
success: function (response) {
 

ClassSubCate(response,Clicked,service_role);


},

});
   
  

}






 
function ClassSubCate(response,Clicked,service_role) { 

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

const get_num = Clicked.replace(/\D+/g, ''); // \D matches non-digit characters

var view_btn =  $('#'+Clicked).html();

if (view_btn == 'Hide') {
var view_btn =  $('#'+Clicked).html('View');
$('#class_sub_cate_'+get_num).empty();
$('#reject_class_category_'+get_num).css('display','none');

return false ;

}else{
var view_btn =  $('#'+Clicked).html('Hide');
$('#reject_class_category_'+get_num).css('display','block');
}

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
         var cate_have = '<?php echo $main->sub_category  ?>' ;
         cate_have =  cate_have.split('|*|');
           var cates_type = $('#'+Clicked).data('cates_type');
         if (cates_type == 'Online') {
          var array2 = cate_have[0].split(',');
          } else {
          var array2 = cate_have[1].split(',');
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




$('#class_sub_cate_'+get_num).empty();

var sub_cate_html = '';

for (let i = 0; i < commonElements.length; i++) {
const element = commonElements[i];
if (i == 0) {
sub_cate_html += '<label for="car" class="form-label">Class Sub Category</label>';
}
sub_cate_html +=  '<div class="row mb-2" id="class_sub_cate_div_'+i+'">'+
           '<div class="col-md-10 input_group2">'+
             '<input class="form-control" list="datalistOptions" value="'+element+'" id="car" readonly placeholder="Graphic Designer">'+
           '</div>'+
           '<div class="col-md-2 button_group2">'+
             '<button class="btn_reject btn btn-outline-secondary remove-button" onclick="RejectSubCateClass(this.id)" id="sub_cate_'+i+'" data-cate="'+element+'" data-service_type="class_sub" data-cates_type="'+cates_type+'" >Remove</button>'+
           '</div> '+
         '</div>';

         
       }
       $('#class_sub_cate_'+get_num).append(sub_cate_html);



}






  //  Main Category Reject Function Start =======
  function RejectCategory(Clicked) {

if (!confirm("Are You Sure, You Want to Remove ?")){
        return false;
    }

var cate_id =   $('#'+Clicked).data('category'); 
var type =   $('#'+Clicked).data('type');
var request_id =  '<?php echo $request->id  ?>';


   
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});

$.ajax({
type: "POST",
url: '/reject-requested-application-category',
data:{ request_id:request_id, cate_id:cate_id, type:type, _token: '{{csrf_token()}}'},
dataType: 'json',
success: function (response) {

  console.log(response['cate']);
  
const get_num = Clicked.replace(/\D+/g, '');
if (response.success) {
 
  $('.main_class_'+get_num).remove();
  $('#class_sub_cate_'+get_num).remove();
  
 


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





function RejectSubCateClass(Clicked) { 

if (!confirm("Are You Sure, You Want to Remove ?")){
        return false;
    }

var sub_cate = $('#'+Clicked).data('cate');
var cates_type = $('#'+Clicked).data('cates_type');
var service_role = $('#'+Clicked).data('service_role');
const get_num = Clicked.replace(/\D+/g, ''); // \D matches non-digit characters
  
   var array = '<?php echo $main->sub_category  ?>' ;
   array =  array.split('|*|');
    
 
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
      var request_id = '<?php echo $request->id  ?>';
      var sub_category = updatedArray ;

      sub_category = sub_category.join(',');
       
        
      $.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});

$.ajax({
type: "POST",
url: '/reject-requested-sub-category',
data:{ request_id:request_id, service_role:service_role, sub_category:sub_category,cates_type:cates_type, _token: '{{csrf_token()}}'},
dataType: 'json',
success: function (response) {

if (response.success) {
$('#class_sub_cate_div_'+get_num).remove();
  $('#class_sub_category').val(response.sub_category);
 
 


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


</script>
{{-- Categories Fewtch And Remove Script END =========== --}}













<!-- custom approve modal -->
<div class="modal fade" id="custom-approve-modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered mt-5">
    <div class="modal-content application-content">
      <div class="row">
        <div class="col-md-6 input_group1">
      <label for="car" class="form-label">Category</label>
      <input class="form-control" list="datalistOptions" id="car" placeholder="Graphic Designer">
      </div>
      <div class="col-md-6 button_group1">
        <button class="btn_reject">Reject</button>
        <button class="btn_approve">Aprrove</button>
        <button class="btn_view">View</button>
      </div>
      </div>
      <div class="row">
        <div class="col-md-6 input_group2">
      
      <input class="form-control" list="datalistOptions" id="car" placeholder="Graphic Designer">
      </div>
      <div class="col-md-6 button_group2">
        <button class="btn_reject">Reject</button>
        <button class="btn_approve">Aprrove</button>
        <button class="btn_view">View</button>
      </div>
      </div>
      <div class="row">
        <div class="col-md-6 input_group3">
      
      <input class="form-control" list="datalistOptions" id="car" placeholder="Graphic Designer">
      </div>
      <div class="col-md-6 button_group3">
        <button class="btn_reject">Reject</button>
        <button class="btn_approve">Aprrove</button>
        <button class="btn_view">View</button>
      </div>
      </div>
      <div class="row">
        <div class="col-md-6 input_group4">
      
      <input class="form-control" list="datalistOptions" id="car" placeholder="Web Development">
      </div>
      <div class="col-md-6 button_group4">
        <button class="btn_reject">Reject</button>
        <button class="btn_approve">Aprrove</button>
        <button class="btn_view">View</button>
      </div>
      </div>
      <div class="content">
        <div class="content_box1">
        <h5>Experience :</h5>
        <p>3 year</p>
        </div>
        <div class="content_box2">
          <h5>Portfolio Link : <a href="#">https://www.bravemindstudio.com</a></h5>
          <p class="p1"><a href="#">https://www.bravemindstudio.com</a><br>
          <a href="#">https://www.bravemindstudio.com</a></p>
          </div>
          </div>
          <div class="footer">
            <button class="btn_reject_all">Reject All</button>
            <button class="btn_approve_all">Approve All</button>
            <button class="btn_confirm">Confirm</button>
          </div>
      </div>
      
      </div>
    </div>
<script>
  $(function () {
    AOS.init();
    var scrollSpy;
    var hash = window.location.hash;
    hash && $('#side-menu>li>a[href="' + hash + '"]').tab("show");

    $("#side-menu>li>a").click(function (e) {
      e.preventDefault();
      $(this).tab("show");
      window.location.hash = this.hash;

      if (this.hash == "#tab1") {
        if ($("#tab1-tab").hasClass("active")) {
          $("#tab1-programs").addClass("show");
          scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: "#tab1-programs",
          });
        }
      } else {
        $("#tab1-programs").removeClass("show");
        scrollSpy.dispose();
      }
    });
    if ($("#tab1-tab").hasClass("active")) {
      $("#tab1-programs").addClass("show");
      scrollSpy = new bootstrap.ScrollSpy(document.body, {
        target: "#tab1-programs",
      });
    }
  });
</script>
<script>
  // File Upload
  //
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#imagePreview").css(
          "background-image",
          "url(" + e.target.result + ")"
        );
        $("#imagePreview").hide();
        $("#imagePreview").fadeIn(650);
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
      '<div class="d-flex mt-2"><input type="text" name="field_name[]" value="" class="form-control" style="width:95%" placeholder="https://bravemindstudio.com/"/><a href="javascript:void(0);" class="remove_button"><img src="assets/admin/asset/img/remove-icon.svg"/></a></div>'; //New input field html
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

  console.clear();
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
        : "Select";
  }

  chBoxes.forEach((checkbox) => {
    checkbox.addEventListener("change", handleCB);
  });
</script>

<script>
  const chBoxes1 = document.querySelectorAll(".dropdown-menu .subcat-input");
  const dpBtn1 = document.getElementById("multiSelectDropdown1");
  let mySelectedListItems1 = [];

  function handleCB() {
    mySelectedListItems1 = [];
    let mySelectedListItemsText1 = "";

    chBoxes1.forEach((checkbox) => {
      if (checkbox.checked) {
        mySelectedListItems1.push(checkbox.value);
        mySelectedListItemsText1 += checkbox.value + ", ";
      }
    });

    dpBtn1.innerText =
      mySelectedListItems1.length > 0
        ? mySelectedListItemsText1.slice(0, -2)
        : "Select";
  }

  chBoxes1.forEach((checkbox) => {
    checkbox.addEventListener("change", handleCB);
  });
</script>

<script>
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
        : "Select";
  }

  chBoxes2.forEach((checkbox) => {
    checkbox.addEventListener("change", handleCB);
  });
</script>

<script>
  const chBoxes3 = document.querySelectorAll(".dropdown-menu .subcat1-input");
  const dpBtn3 = document.getElementById("multiSelectDropdown3");
  let mySelectedListItems3 = [];

  function handleCB() {
    mySelectedListItems3 = [];
    let mySelectedListItemsText3 = "";

    chBoxes3.forEach((checkbox) => {
      if (checkbox.checked) {
        mySelectedListItems3.push(checkbox.value);
        mySelectedListItemsText3 += checkbox.value + ", ";
      }
    });

    dpBtn3.innerText =
      mySelectedListItems3.length > 0
        ? mySelectedListItemsText3.slice(0, -2)
        : "Select";
  }

  chBoxes3.forEach((checkbox) => {
    checkbox.addEventListener("change", handleCB);
  });
</script>
