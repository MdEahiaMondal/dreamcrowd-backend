
 

<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="/public">
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <!-- View Point scale to 1.0 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Animate css -->
    <link rel="stylesheet" href="assets/public-site/libs/animate/css/animate.css" />
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="assets/public-site/libs/aos/css/aos.css" />
    <!-- Datatable css  -->
    <link rel="stylesheet" href="assets/public-site/libs/datatable/css/datatable.css" />
     {{-- Fav Icon --}}
     @php  $home = \App\Models\HomeDynamic::first(); @endphp
     @if ($home)
         <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
     @endif
     <!-- Select2 css -->
    <link href="assets/public-site/libs/select2/css/select2.min.css" rel="stylesheet" />
    <!-- Owl carousel css -->
    <link href="assets/public-site/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
    <link href="assets/public-site/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
    <!-- Bootstrap css -->

    <!-- g js start -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
    <!-- g js end -->
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/public-site/asset/css/bootstrap.min.css"
    /> 
    <link
      href="assets/public-site/asset/css/fontawesome.min.css"
      rel="stylesheet"
      type="text/css"
    />
     <!-- flatpicker -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script
      src="https://kit.fontawesome.com/be69b59144.js"
      crossorigin="anonymous"
    ></script>
    <!-- ====== g js====== -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <!-- =====g js======= -->
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    

    {{-- =======Toastr CDN ======== --}}
    <link rel="stylesheet" type="text/css" 
    href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- =======Toastr CDN ======== --}}
    <!-- slider card css start -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.0.0-beta.3/assets/owl.carousel.min.css"
    />
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.2.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.0.0-beta.3/assets/owl.theme.default.min.css"
    />
    <link
      href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"
      rel="stylesheet"
    />
    <!-- slider card css End -->
    <!-- ===================== FAQ CDN start========================= -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css"
    />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- ===================== FAQ CDN end========================= -->
    <!-- Defualt css -->
    <link
      href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" type="text/css" href="assets/public-site/asset/css/style.css" />
    <link rel="stylesheet" href="assets/public-site/asset/css/navbar.css" />
    <link rel="stylesheet" href="assets/public-site/asset/css/services.css">
    <link rel="stylesheet" href="assets/public-site/asset/css/Drop.css" />
    <link rel="stylesheet" href="assets/emoji/css/emoji.css" />
    <!-- ======================Hero-slider-links-start======================== -->
    <!-- ======================Hero-slider-links-start======================== -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.0.0-beta.3/assets/owl.carousel.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.0.0-beta.3/assets/owl.theme.default.min.css"
    />
    <!-- ======================Hero-slider-links-end======================== -->
    <!-- ======================Hero-slider-links-end======================== -->
    <title>DreamCrowd | Services</title>
  </head>
<style>

  /* Modal Textarea */
.message-textarea {
  width: 100%;
  height: 100px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 8px;
  resize: none;
  font-size: 14px;
  font-family: Arial, sans-serif;
}

/* Icon Buttons */
.message-icons {
  display: flex;
  align-items: center;
  margin-top: 10px;
}

.icon-btn {
  background-color: transparent;
  border: none;
  font-size: 20px;
  margin-right: 10px;
  cursor: pointer;
  transition: transform 0.2s ease;
}

.icon-btn:hover {
  transform: scale(1.2);
}

/* Safety Rules Text */
.safety-rules {
  margin-left: auto;
  color: #007bff;
  font-size: 14px;
  cursor: pointer;
}

.safety-rules:hover {
  text-decoration: underline;
}

/* Send Button */
.btn-primary {
  background-color: #007bff;
  border: none;
  padding: 8px 20px;
  border-radius: 5px;
  font-size: 14px;
}

.btn-primary:hover {
  background-color: #0056b3;
}
.icon-btn i:hover{
  color: #0072b1;
}
  /* color-white: #ffffff;
$color-black: #252a32;
$color-light: #f1f5f8;
$color-red: #d32f2f;
$color-blue: #148cb8;

$box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 3px rgba(0, 0, 0, 0.24); */

*,
*::before,
*::after {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
  list-style: none;
  list-style-type: none;
  text-decoration: none;
  -moz-osx-font-smoothing: grayscale;
  -webkit-font-smoothing: antialiased;
  text-rendering: optimizeLegibility;
}


.main {
  .container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-gap: 1rem;
    justify-content: center;
    align-items: center;
  }

  .main .card {
    color: color-black;
    border-radius: 2px;
    background: color-white;
    box-shadow: box-shadow;

    .main &-image {
      position: relative;
      display: block;
      width: 100%;
      /* padding-top: 70%; */
      /* background: $color-white; */

      .main img {
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
      }
    }
  }
}
/* mutiple email css */
span.email-ids {
    float: left;
    /* padding: 4px; */
    border: none;
    margin-right: 5px;
    padding-left: 10px;
    padding-right: 10px;
    margin-bottom: 5px;
    background: #0072b1;
    color: #fff;
    padding-top: 3px;
    padding-bottom: 3px;
    border-radius: 5px;
    font-size: 12px;
    font-family: Roboto;
    font-weight: 400px;
}
span.cancel-email {
    border: none;
    color: #fff;
    width: 18px;
    display: block;
    float: right;
    text-align: center;
    margin-left: 20px;
    border-radius: 49%;
    height: 18px;
    line-height: 15px;
    margin-top: 1px;    cursor: pointer;
}
/* .col-sm-12.email-id-row {
    border: 1px solid #ccc;
} */
.col-sm-12.email-id-row input {
    border: 0px; outline:0px;
}
span.to-input {
    display: block;
    float: left;
    padding-right: 11px;
}
.col-sm-12.email-id-row {
    /* padding-top: 6px; */
    /* padding-bottom: 7px; */
    border-radius: 4px;
    background: #f4fbff;
    border: none;
    /* padding: 12px 20px 12px 30px; */
}
@media only screen and (max-width: 600px) {
  .main {
    .container {
      display: grid;
      grid-template-columns: 1fr;
      grid-gap: 1rem;
    }
  }
}

</style>
<style>
  .social-buttons{
  display:flex;
  background: rgba(256,256,256,0.5);
  padding:20px;
  padding-bottom: 5px;
  border-radius:10px;
  text-align:center;
  margin:20px 10px;
  box-shadow: 0px 0px 43px -15px #1a1a1a;
}
  
/* Helper class to divide the icons */
.social-margin {
  margin-right: 15px;
}

a,
a:hover,
a:focus,
a:active {
  text-decoration: none;
}
.social-icon i{
  font-size: 24px;
}
.social-icon {
  margin-bottom: 15px;
   box-sizing: border-box;
  -moz-border-radius: 138px;
  -webkit-border-radius: 138px;
  border-radius: 138px;
  border: 5px solid;
  text-align: center;
  width: 50px;
  height: 50px;
  display: inline-block;
  line-height: 1px;
  padding-top: 11px;
  transition: all 0.5s;
  
}
.social-icon:hover {
    transform: rotate(360deg)scale(1.3);
  }
  /* Facebook Button Styling */
 .facebook {
    font-size: 22px;
    padding-top: 9px;
    border-color: #3b5998;
    background-color: #3b5998;
    color: #ffffff;
   
  }
  .facebook:hover {
    background-color: #ffffff;
    color: #3b5998;
  }
  /* Twitter Button Styling */
.twitter {
    font-size: 22px;
    padding-top: 10px;
    padding-left: 2px;
    border-color: #55acee;
    background-color: #55acee;
    color: #ffffff;
    
  }
  .twitter:hover {
    background-color: #ffffff;
    color: #55acee;
  } 
  /* WhatsApp Button Styling */
.whatsapp {
    font-size: 30px;
    padding-top: 4px;
    padding-left: 0px;
    border-color: none;
    background-color: none;
    color: #ffffff;
    
  }
  .whatsapp:hover {
    background-color: #ffffff;
    color: none;
  } 
  /* Linkedin Button Styling */
  .linkedin {
    font-size: 24px;
    padding-top: 8px;
    padding-left: 1px;
    background-color: #0976b4;
    color: #ffffff;
    border-color: #0976b4;
    
  }
  .linkedin :hover { 
    color: #0976b4;
  }
 

  /* Github Button Styling */
 .github {
    font-size: 22px;
    padding-top: 9px;
    background-color: #4183c4;
    color: #e5efe5e6; 
    border-color: #4183c4;
    
  }
  .github:hover { 
    color: #ffffff;
  }
  

  /* Modal Style */
  .modal-header {
      background-color: #f8f9fa;
  }
  
  .modal-title {
      font-size: 20px;
      font-weight: bold;
  }
  
  .modal-body {
      text-align: center;
  }
  
  
  </style>
  <body>

    
    <!-- =========================================== NAVBAR START HERE ================================================= -->
    <x-public-nav/>

    <!-- ============================================= NAVBAR END HERE ============================================ -->
    <!-- ============================================= SLIDER SECTION START HERE ============================================ -->
    <!-- ============================================= SLIDER SECTION END HERE ============================================ -->

    <div class="container-fluid">
      <div class="container">
        <!-- ===========================Hero-slider-start==================== -->
        <!-- ================================================================ -->
        <div class="row">
          <div class="col-lg-8 col-md-12">
            <h3 class="profile-heading">
              Professional Profile For <span>
                  @if ($profile->show_full_name == 0)
                      {{$profile->first_name}} {{strtoupper(substr($profile->last_name, 0, 1))}}.
                      @else
                       {{$profile->first_name}} {{$profile->last_name}}
                  @endif   
                </span>
            </h3>
            <div class="sliderBlock">
              <div class="Dream-Hero-owl-caroual">
                <div id="sync1" class="owl-carousel owl-theme">
                  @if ($profile->video != null)
                  <div class="item">
                    <!-- <h1>1</h1> -->
                    <video width="100%" height="480px" controls autoplay muted>
                      <source src="assets/expert/asset/img/{{$profile->video}}" type="video/mp4">
                    </video>
                   </div>
                  @endif

                  @if ($profile->main_image != null)
                  <div class="item">
                    <!-- <h1>1</h1> -->
                    <img width="100%" height="480px" src="assets/expert/asset/img/{{$profile->main_image}}" alt="" />
                  </div>
                  @endif

                  @for ($i = 1; $i < 7; $i++)
                  @php $more_image = data_get($profile, 'more_image_' . $i); @endphp
                  @if ($more_image != null)
                  <div class="item">
                    <!-- <h1>1</h1> -->
                    <img width="100%" height="480px" src="assets/expert/asset/img/{{$more_image}}" alt="" />
                  </div>
                  @endif
                      
                  @endfor
                 
                   
                  {{-- <div class="item">
                    <img width="100%" height="480px" src="assets/public-site/asset/img/Rectangle 2322 (1).png" alt="" />
                  </div> --}}

                </div>

                <div id="sync2" class="owl-carousel owl-theme">
                 @if ($profile->video != null)
                  <div class="item">
                    <!-- <h1>1</h1> -->
                    <video width="100%" height="230px" controls autoplay muted>
                      <source src="assets/expert/asset/img/{{$profile->video}}" type="video/mp4">
                    </video>
                   </div>
                  @endif

                  @if ($profile->main_image != null)
                  <div class="item">
                    <!-- <h1>1</h1> -->
                    <img width="100%" height="230px" src="assets/expert/asset/img/{{$profile->main_image}}" alt="" />
                  </div>
                  @endif

                  @for ($i = 1; $i < 7; $i++)
                  @php $more_image = data_get($profile, 'more_image_' . $i); @endphp
                  @if ($more_image != null)
                  <div class="item">
                    <!-- <h1>1</h1> -->
                    <img width="100%" height="230px" src="assets/expert/asset/img/{{$more_image}}" alt="" />
                  </div>
                  @endif
                      
                  @endfor

                 
              
                  {{-- <div class="item">
                    <img src="assets/public-site/asset/img/1122.png" alt="" />
                  </div> --}}

                </div>
              </div>
            </div>
          </div>
          
          <div class="col-lg-4 col-md-12">
            <div class="tab-top-icons">
           <!-- Share Button -->
<span>
  <a href="#" data-bs-toggle="modal" data-bs-target="#shareModal">
      <svg
          xmlns="http://www.w3.org/2000/svg"
          width="32"
          height="32"
          viewBox="0 0 32 32"
          fill="none">
          <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M21.9981 3C21.3642 2.99979 20.7378 3.13869 20.1634 3.40692C19.5889 3.67514 19.0803 4.06616 18.6734 4.55237C18.2666 5.03858 17.9713 5.60815 17.8086 6.2209C17.6458 6.83364 17.6195 7.47464 17.7315 8.09867L11.4248 12.5147C11.3933 12.5365 11.363 12.5601 11.3341 12.5853C10.6943 12.0852 9.92683 11.7749 9.11919 11.6898C8.31154 11.6048 7.49625 11.7484 6.76628 12.1043C6.03631 12.4602 5.42104 13.0141 4.99064 13.7028C4.56024 14.3915 4.33203 15.1872 4.33203 15.9993C4.33203 16.8114 4.56024 17.6072 4.99064 18.2959C5.42104 18.9846 6.03631 19.5385 6.76628 19.8944C7.49625 20.2503 8.31154 20.3939 9.11919 20.3088C9.92683 20.2238 10.6943 19.9135 11.3341 19.4133C11.363 19.4391 11.3932 19.4631 11.4248 19.4853L17.7315 23.9013C17.5443 24.945 17.7462 26.0211 18.299 26.9259C18.8519 27.8307 19.7173 28.5014 20.7314 28.811C21.7456 29.1206 22.838 29.0476 23.802 28.6059C24.7659 28.1642 25.5344 27.3843 25.962 26.414C26.3897 25.4438 26.4467 24.3504 26.1223 23.3409C25.798 22.3314 25.1147 21.4758 24.202 20.9362C23.2892 20.3966 22.2103 20.2104 21.1694 20.4128C20.1286 20.6153 19.1981 21.1923 18.5541 22.0347L12.5821 17.8547C12.8488 17.292 12.9981 16.664 12.9981 16C12.9981 15.336 12.8488 14.7067 12.5821 14.1453L18.5555 9.964C19.0029 10.5497 19.5924 11.0116 20.2681 11.306C20.9438 11.6004 21.6834 11.7176 22.417 11.6465C23.1506 11.5753 23.854 11.3183 24.4605 10.8996C25.0671 10.4809 25.5569 9.91441 25.8835 9.25369C26.2101 8.59296 26.3629 7.85985 26.3272 7.12366C26.2915 6.38747 26.0687 5.67255 25.6797 5.04649C25.2907 4.42043 24.7485 3.90393 24.1043 3.54583C23.4601 3.18773 22.7352 2.99987 21.9981 3ZM19.6648 7.33333C19.6648 6.7145 19.9106 6.121 20.3482 5.68342C20.7858 5.24583 21.3793 5 21.9981 5C22.617 5 23.2105 5.24583 23.6481 5.68342C24.0856 6.121 24.3315 6.7145 24.3315 7.33333C24.3315 7.95217 24.0856 8.54566 23.6481 8.98325C23.2105 9.42083 22.617 9.66667 21.9981 9.66667C21.3793 9.66667 20.7858 9.42083 20.3482 8.98325C19.9106 8.54566 19.6648 7.95217 19.6648 7.33333Z"
              fill="#0072B1"/>
      </svg>
      Share &nbsp;
  </a>
</span>

<!-- Modal for Share -->
<div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header" style="background: none;">
            
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <h2 class="modal-title" id="shareModalLabel">Share This Gig</h2>
              <p style="color: #a19494;">Spread the word about this Gig!</p>
              <div class="d-flex justify-content-around">
                <div class="social-buttons">        
                  <!-- facebook  Button -->
                          <a   target="blank" id="facebookShare" class="social-margin"> 
                            <div class="social-icon facebook">
                              <i class="fa fa-facebook" aria-hidden="true"></i> 
                            </div>
                          </a>
                        
                          <!-- LinkedIn Button -->
                          <a    id="linkedinShare" class="social-margin" target="blank">
                            <div class="social-icon linkedin">
                              <i class="fa fa-linkedin" aria-hidden="true"></i>
                            </div> 
                          </a>
                      
                    <!-- TwitterButton -->
                          <a   id="twitterShare" target="blank" class="social-margin">
                            <div class="social-icon twitter">
                              <i class="fa fa-twitter" aria-hidden="true"></i>
                            </div> 
                          </a>
                      
                    
                          <a    id="whatsappShare" target="blank" class="social-margin">
                            <div class="social-icon whatsapp">
                              <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" width="60" style="position: relative;bottom: 14px;right:7px;">
                            </div> 
                          </a>
                   
                           <!-- TwitterButton -->
                           <a   id="copyLink" target="blank" class="social-margin">
                            <div class="social-icon github">
                              <i class="far fa-copy" aria-hidden="true"></i>
                            </div> 
                          </a>

                  </div>
                 
                  
                
                
              </div>
          </div>
      </div>
  </div>
</div>

             &nbsp; &nbsp; &nbsp;

              @if (Auth::user())
                  
              @if ($profile->user_id != Auth::user()->id)
                  
              
             
              <span>
                <div class="con-like">
                  <input title="like" type="checkbox" class="like" id="profile_wish" onclick="AddWishList(this.id);"  data-gig_id="{{$profile->id}}" data-type="Profile" 
                  @if ($list) checked @endif />
                  <div class="checkmarks">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="32"
                      height="32"
                      viewBox="0 0 32 32"
                      fill="none"
                    >
                      <path
                        d="M16.0059 26.9912L16.0059 26.9912L16 26.9943L15.9941 26.9912C15.7517 26.8629 12.4454 25.061 9.21476 22.2318C5.93158 19.3565 3.00027 15.6574 3 11.7505C3.00217 9.96087 3.71408 8.2451 4.97959 6.97959C6.2451 5.71408 7.96087 5.00217 9.75055 5C12.0393 5.00016 13.9936 5.97945 15.2003 7.58668L16 8.65173L16.7997 7.58668C18.0064 5.97945 19.9607 5.00016 22.2495 5C24.0391 5.00217 25.7549 5.71408 27.0204 6.97959C28.2861 8.24523 28.998 9.96124 29 11.7511C28.9994 15.6578 26.0683 19.3566 22.7852 22.2318C19.5546 25.061 16.2483 26.8629 16.0059 26.9912Z"
                        stroke="#0072B1"
                        stroke-width="2"
                        
                      />
                    </svg>
                   
                    <svg
                      viewBox="0 0 24 24"
                      class="filled"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M17.5,1.917a6.4,6.4,0,0,0-5.5,3.3,6.4,6.4,0,0,0-5.5-3.3A6.8,6.8,0,0,0,0,8.967c0,4.547,4.786,9.513,8.8,12.88a4.974,4.974,0,0,0,6.4,0C19.214,18.48,24,13.514,24,8.967A6.8,6.8,0,0,0,17.5,1.917Z"
                      ></path>
                    </svg>
                    <svg
                      class="celebrate"
                      width="100"
                      height="100"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <polygon points="10,10 20,20" class="poly"></polygon>
                      <polygon points="10,50 20,50" class="poly"></polygon>
                      <polygon points="20,80 30,70" class="poly"></polygon>
                      <polygon points="90,10 80,20" class="poly"></polygon>
                      <polygon points="90,50 80,50" class="poly"></polygon>
                      <polygon points="80,80 70,70" class="poly"></polygon>
                    </svg>
                  </div>
                </div>
                Add to Wishlist
              </span>

              @endif
              @endif
            </div>
   <div class="main-tab">
  <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" id="service_change" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      All Services (Online & Inperson)
      <i class="fas fa-chevron-down"></i>
    </button>
    <input type="hidden" value="{{$profile->user_id}}" id="profile_id">
    <ul class="dropdown-menu nav nav-fill nav-tabs filter-dropdowns" role="tablist">
      <li><a class="dropdown-item" id="fill-tab-2" data-bs-toggle="tab" href="#fill-tabpanel-2" role="tab" aria-controls="fill-tabpanel-2" aria-selected="true" data-service="All,All">All Services (Online & Inperson)</a></li>
      <li><a class="dropdown-item" id="fill-tab-7" data-bs-toggle="tab" href="#fill-tabpanel-7" role="tab" aria-controls="fill-tabpanel-7" aria-selected="false" data-service="Online,Class">Classes (Online & Inperson)</a></li>
      {{-- <li><a class="dropdown-item" id="fill-tab-4" data-bs-toggle="tab" href="#fill-tabpanel-4" role="tab" aria-controls="fill-tabpanel-4" aria-selected="false" data-service="Inperson,Class">In Person Classes</a></li> --}}
      <li><a class="dropdown-item" id="fill-tab-5" data-bs-toggle="tab" href="#fill-tabpanel-5" role="tab" aria-controls="fill-tabpanel-5" aria-selected="false" data-service="Online,Freelance">Freelance (Online & Inperson)</a></li>
      {{-- <li><a class="dropdown-item" id="fill-tab-6" data-bs-toggle="tab" href="#fill-tabpanel-6" role="tab" aria-controls="fill-tabpanel-6" aria-selected="false" data-service="Inperson,Freelance">In Person Freelance</a></li> --}}
    </ul>
  </div>

    
  <!-- TAB CONTENT START -->
  <div class="tab-content" id="tab-content">
    <!-- All Services TAB -->
    <div class="tab-pane active" id="fill-tabpanel-2" role="tabpanel" aria-labelledby="fill-tab-2">
      <div class="tab-content-data tab-2-rad">
        <!-- Default radio -->
    <div class="form-group">
      <input class="form-check-input" type="radio" name="group1" id="flexRadioDefault1" onclick="ServiceType(this.id)" value="Online" data-tab="record-1" data-role="All" checked />
      <label class="form-check-label" for="flexRadioDefault1">Online</label>
    </div>

    <!-- Default checked radio -->
    <div class="form-group">
      <input class="form-check-input" type="radio" onclick="ServiceType(this.id)" value="Inperson" data-tab="record-1" data-role="All" name="group1" id="flexRadioDefault2"  />
      <label class="form-check-label" for="flexRadioDefault2">In-Person</label>
    </div>
</div>
    
<div class="col-12 search-form-2">
  <div class="d-flex form-inputs">
    <input class="form-control" type="text" id="search-1" onkeyup="KeywordWrite(this.id)"  data-tab="record-1" data-role="All" placeholder="Search here....."  style="margin-right: -50px;" />
    <i class="fa-solid fa-magnifying-glass" style="right: 15px;"></i>
    <div class="dropdown" style="margin: auto;position: relative;right: 13px;">
      <a class="  dropdown-toggle"   id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
          <path d="M3.33333 16H6.66667C7.125 16 7.5 15.625 7.5 15.1667C7.5 14.7083 7.125 14.3333 6.66667 14.3333H3.33333C2.875 14.3333 2.5 14.7083 2.5 15.1667C2.5 15.625 2.875 16 3.33333 16ZM2.5 4.83333C2.5 5.29167 2.875 5.66667 3.33333 5.66667H16.6667C17.125 5.66667 17.5 5.29167 17.5 4.83333C17.5 4.375 17.125 4 16.6667 4H3.33333C2.875 4 2.5 4.375 2.5 4.83333ZM3.33333 10.8333H11.6667C12.125 10.8333 12.5 10.4583 12.5 10C12.5 9.54167 12.125 9.16667 11.6667 9.16667H3.33333C2.875 9.16667 2.5 9.54167 2.5 10C2.5 10.4583 2.875 10.8333 3.33333 10.8333Z" fill="#ABABAB"/>
        </svg>
      </a>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li ><a id="oneof1" onclick="PaymentType(this.id)" data-tab="record-1" data-role="All"  data-value="OneOff"  style="cursor: pointer;" onmouseover="this.style.color='#0072b1';" onmouseout="this.style.color='black';">One-Off Payment</a></li> <hr>
        <li ><a id="subscription1" onclick="PaymentType(this.id)" data-tab="record-1" data-role="All"  data-value="Subscription"  style="cursor: pointer;"  onmouseover="this.style.color='#0072b1';" onmouseout="this.style.color='black';">Subscription Payment</a></li>
        
        
      </ul>
    </div>
  </div>
</div>

      <!-- second ROW DATA START WITH VIEW BUTTON -->
      <div class="row data-tab" id="record-1">


        @if (count($teacher_services) > 0)

        @foreach ($teacher_services as $item)
        @if ($item->service_role == 'Class')
        @if ($item->class_type == 'Recorded')
         <a href="/course-service/{{$item->id}}" class="col-12 heading view-btn view"  id="views">
        @else
        <a href="/quick-booking/{{$item->id}}" class="col-12 heading view-btn view"  id="views">
        @endif
        @else
        <a href="/quick-booking/{{$item->id}}" class="col-12 heading view-btn view"  id="views">
        @endif
        
        
          <h1>{{$item->title}}</h1>
          <p>Duration: 1 Day</p>
          <h2>Starting at ${{$item->rate}}</h2>
        </a>
        <hr />
            
        @endforeach
      
        @else
        <div class="col-12 heading view-btn view" type="button"
     
        id="views">
          <h1>Not Found Any Service</h1> 
        </div>
        <hr />
            
        @endif

      
        
      </div>
    </div>

    <!-- Class Services TAB -->
    <div class="tab-pane" id="fill-tabpanel-7" role="tabpanel" aria-labelledby="fill-tab-7">
      <div class="tab-content-data tab-7-rad">
                <!-- Default radio -->
                <div class="form-group">
                  <input class="form-check-input" type="radio" name="group11" id="flexRadioDefault10" onclick="LessonType(this.id)" value="One" data-tab="record-2" data-role="Class"  checked />
                  <label class="form-check-label" for="flexRadioDefault10">1 to 1 Lessons</label>
                </div>
      
                <!-- Default checked radio -->
                <div class="form-group">
                  <input class="form-check-input" type="radio" name="group11" id="flexRadioDefault11"  onclick="LessonType(this.id)" value="Group" data-tab="record-2" data-role="Class"    />
                  <label class="form-check-label" for="flexRadioDefault11">Group Lessons</label>
                </div>
        <!-- SEARCH FORM CONTROL -->
        <div class="col-12">
          <div class="d-flex form-inputs">

            <input class="form-control" type="text" id="search-2" onkeyup="KeywordWrite(this.id)"  data-tab="record-2" data-role="Class"  placeholder="Search here....."  style="margin-right: -50px;" />
            <i class="fa-solid fa-magnifying-glass" style="right: 15px;"></i>
            <div class="dropdown" style="margin: auto;position: relative;right: 13px;">
              <a class="  dropdown-toggle"   id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M3.33333 16H6.66667C7.125 16 7.5 15.625 7.5 15.1667C7.5 14.7083 7.125 14.3333 6.66667 14.3333H3.33333C2.875 14.3333 2.5 14.7083 2.5 15.1667C2.5 15.625 2.875 16 3.33333 16ZM2.5 4.83333C2.5 5.29167 2.875 5.66667 3.33333 5.66667H16.6667C17.125 5.66667 17.5 5.29167 17.5 4.83333C17.5 4.375 17.125 4 16.6667 4H3.33333C2.875 4 2.5 4.375 2.5 4.83333ZM3.33333 10.8333H11.6667C12.125 10.8333 12.5 10.4583 12.5 10C12.5 9.54167 12.125 9.16667 11.6667 9.16667H3.33333C2.875 9.16667 2.5 9.54167 2.5 10C2.5 10.4583 2.875 10.8333 3.33333 10.8333Z" fill="#ABABAB"/>
                </svg>
              </a>

           
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li ><a id="Online2" onclick="ServiceType2(this.id)" data-tab="record-2" data-role="Class"  data-value="Online"  style="cursor: pointer;"  onmouseover="this.style.color='#0072b1';" onmouseout="this.style.color='black';">Online</a></li> <hr>
                <li ><a id="Inperson2" onclick="ServiceType2(this.id)" data-tab="record-2" data-role="Class"  data-value="Inperson"  style="cursor: pointer;"  onmouseover="this.style.color='#0072b1';" onmouseout="this.style.color='black';">Inperson</a></li> <hr>
                <li ><a id="oneof2" onclick="PaymentType(this.id)" data-tab="record-2" data-role="Class"  data-value="OneOff"  style="cursor: pointer;" onmouseover="this.style.color='#0072b1';" onmouseout="this.style.color='black';">One-Off Payment</a></li> <hr>
                <li ><a id="subscription2" onclick="PaymentType(this.id)" data-tab="record-2" data-role="Class"  data-value="Subscription"  style="cursor: pointer;"  onmouseover="this.style.color='#0072b1';" onmouseout="this.style.color='black';">Subscription Payment</a></li>
                
                
              </ul>
            </div>
          </div>
        </div>
        <!-- ROW DATA START VIEW BUTTON -->
        <div class="row data-tab" id="record-2">

          @if (count($teacher_services_cls) > 0)

          @foreach ($teacher_services_cls as $item)
  
          @if ($item->service_role == 'Class')
          @if ($item->class_type == 'Recorded')
           <a href="/course-service/{{$item->id}}" class="col-12 heading view-btn view"  id="views">
          @else
          <a href="/quick-booking/{{$item->id}}" class="col-12 heading view-btn view"  id="views">
          @endif
          @else
          <a href="/quick-booking/{{$item->id}}" class="col-12 heading view-btn view"  id="views">
          @endif
            <h1>{{$item->title}}</h1>
            <p>Duration: 1 Day</p>
            <h2>Starting at ${{$item->rate}}</h2>
          </a>
          <hr />
              
          @endforeach
        
          @else
          <div class="col-12 heading view-btn view" type="button"  id="views">
            <h1>Not Found Any Service</h1> 
          </div>
          <hr />
              
          @endif
          
        
        </div>
      </div>
    </div>

    
      <!-- Online Freelance Services TAB -->
    <div class="tab-pane" id="fill-tabpanel-5" role="tabpanel" aria-labelledby="fill-tab-5">
      <div class="tab-content-data tab-5-rad">
            
        <!-- Default radio -->
        <div class="form-group">
          <input class="form-check-input" type="radio" name="group4" id="flexRadioDefault5" onclick="FreelanceType(this.id)" value="Basic" data-tab="record-3" data-role="Freelance"   checked/>
          <label class="form-check-label" for="flexRadioDefault5">Basic Services</label>
        </div>

        <!-- Default checked radio -->
        <div class="form-group">
          <input class="form-check-input" type="radio" name="group4" id="flexRadioDefault6" onclick="FreelanceType(this.id)" value="Premium" data-tab="record-3" data-role="Freelance"  />
          <label class="form-check-label" for="flexRadioDefault6">Premium Services</label>
        </div>
      </div>
      <!-- SEARCH FORM CONTROL -->
      <div class="col-12 search-form-2">
        <div class="d-flex form-inputs">

          <input class="form-control" type="text"id="search-3" onkeyup="KeywordWrite(this.id)"  data-tab="record-3" data-role="Freelance"   placeholder="Search here....."  style="margin-right: -50px;" />
          <i class="fa-solid fa-magnifying-glass" style="right: 15px;"></i>
          <div class="dropdown" style="margin: auto;position: relative;right: 13px;">
            <a class="  dropdown-toggle"   id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M3.33333 16H6.66667C7.125 16 7.5 15.625 7.5 15.1667C7.5 14.7083 7.125 14.3333 6.66667 14.3333H3.33333C2.875 14.3333 2.5 14.7083 2.5 15.1667C2.5 15.625 2.875 16 3.33333 16ZM2.5 4.83333C2.5 5.29167 2.875 5.66667 3.33333 5.66667H16.6667C17.125 5.66667 17.5 5.29167 17.5 4.83333C17.5 4.375 17.125 4 16.6667 4H3.33333C2.875 4 2.5 4.375 2.5 4.83333ZM3.33333 10.8333H11.6667C12.125 10.8333 12.5 10.4583 12.5 10C12.5 9.54167 12.125 9.16667 11.6667 9.16667H3.33333C2.875 9.16667 2.5 9.54167 2.5 10C2.5 10.4583 2.875 10.8333 3.33333 10.8333Z" fill="#ABABAB"/>
              </svg>
            </a> 

            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
              <li ><a id="Online3" onclick="ServiceType2(this.id)" data-tab="record-3" data-role="Freelance"  data-value="Online"  style="cursor: pointer;"  onmouseover="this.style.color='#0072b1';" onmouseout="this.style.color='black';">Online</a></li> <hr>
              <li ><a id="Inperson3" onclick="ServiceType2(this.id)" data-tab="record-3" data-role="Freelance"  data-value="Inperson"  style="cursor: pointer;"  onmouseover="this.style.color='#0072b1';" onmouseout="this.style.color='black';">Inperson</a></li> <hr>
              <li ><a id="oneof3" onclick="PaymentType(this.id)" data-tab="record-3" data-role="Freelance"  data-value="OneOff"  style="cursor: pointer;" onmouseover="this.style.color='#0072b1';" onmouseout="this.style.color='black';">One-Off Payment</a></li> <hr>
              <li ><a id="subscription3" onclick="PaymentType(this.id)" data-tab="record-3" data-role="Freelance"  data-value="Subscription"  style="cursor: pointer;"  onmouseover="this.style.color='#0072b1';" onmouseout="this.style.color='black';">Subscription Payment</a></li>
               
            </ul>
          </div>
        </div>
      </div>
      <!-- second ROW DATA START WITH VIEW BUTTON -->
      <div class="row data-tab" id="record-3">

        @if (count($teacher_services_fls) > 0)

         @foreach ($teacher_services_fls as $item)
 
         @if ($item->service_role == 'Class')
         @if ($item->class_type == 'Recorded')
          <a href="/course-service/{{$item->id}}" class="col-12 heading view-btn view"  id="views">
         @else
         <a href="/quick-booking/{{$item->id}}" class="col-12 heading view-btn view"  id="views">
         @endif
         @else
         <a href="/quick-booking/{{$item->id}}" class="col-12 heading view-btn view"  id="views">
         @endif
           <h1>{{$item->title}}</h1>
           <p>Duration: 1 Day</p>
           <h2>Starting at ${{$item->rate}}</h2>
         </a>
         <hr />
             
         @endforeach

         @else
         <div class="col-12 heading view-btn view" type="button" id="views">
           <h1>Not Found Any Service</h1> 
         </div>
         <hr />
             
         @endif
      
    
     </div> 
    </div>
 
    </div>

    </div>

           
          </div>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.0.0-beta.3/owl.carousel.min.js"></script>
        <!-- multiple email script -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
          
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<!-- jquery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
          $(".dropdown a").click(function() {
            $(this)
              .parents(".dropdown")
              .find(".btn")
              .html($(this).text() + '<i class="fas fa-chevron-down"></i>');
            $(this)
              .parents(".dropdown")
              .find(".btn")
              .val($(this).data("value"));
            //$("#toChange").val($(this).data('value'))
            //$("#toChange").text("asdasd")
            $("#toChange").text($(this).text());
          });</script>
        <!-- ================================================================ -->
        <!-- ===========================Hero-slider-End====================== -->
        <!-- ===========scroll sectio================ -->
        <div class="row">
          <div class="col-lg-8 col-md-12">
            <!-- ~~~Start-personal-profile-imge~~~~ -->
            <div class="personal-profile">
              <div class="profile-img">
               @if ($profile->profile_image == null)
                @php  $firstLetter = strtoupper(substr($profile->first_name, 0, 1));  @endphp
                <img src="assets/profile/avatars/({{$firstLetter}}).jpg"> 
               @else
               <img src="assets/profile/img/{{$profile->profile_image}}" alt=""> 
              @endif 
               </div>
              <div class="personal-profile-detail">
                <h4>  
                   @if ($profile->show_full_name == 0)
                      {{$profile->first_name}} {{strtoupper(substr($profile->last_name, 0, 1))}}.
                      @else
                       {{$profile->first_name}} {{$profile->last_name}}
                  @endif   
                </h4>
                <p>
                  <b>{{$profile->profession}}</b>
                </p>
                <p>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="20"
                    height="20"
                    viewBox="0 0 20 20"
                    fill="none"
                  >
                    <path
                      d="M10.0034 6.45768C9.34035 6.45768 8.70447 6.72107 8.23563 7.18992C7.76679 7.65876 7.5034 8.29464 7.5034 8.95768C7.5034 9.62072 7.76679 10.2566 8.23563 10.7254C8.70447 11.1943 9.34035 11.4577 10.0034 11.4577C10.6664 11.4577 11.3023 11.1943 11.7712 10.7254C12.24 10.2566 12.5034 9.62072 12.5034 8.95768C12.5034 8.29464 12.24 7.65876 11.7712 7.18992C11.3023 6.72107 10.6664 6.45768 10.0034 6.45768ZM8.54506 8.95768C8.54506 8.57091 8.69871 8.19998 8.9722 7.92649C9.24569 7.65299 9.61662 7.49935 10.0034 7.49935C10.3902 7.49935 10.7611 7.65299 11.0346 7.92649C11.3081 8.19998 11.4617 8.57091 11.4617 8.95768C11.4617 9.34446 11.3081 9.71539 11.0346 9.98888C10.7611 10.2624 10.3902 10.416 10.0034 10.416C9.61662 10.416 9.24569 10.2624 8.9722 9.98888C8.69871 9.71539 8.54506 9.34446 8.54506 8.95768ZM15.418 13.3327L11.2146 17.7952C11.0588 17.9606 10.8708 18.0925 10.6621 18.1826C10.4535 18.2727 10.2286 18.3192 10.0013 18.3192C9.77402 18.3192 9.54914 18.2727 9.34048 18.1826C9.13182 18.0925 8.9438 17.9606 8.78798 17.7952L4.58465 13.3327H4.60048L4.5934 13.3243L4.58465 13.3139C3.50577 12.038 2.91511 10.4203 2.91798 8.74935C2.91798 4.83727 6.08923 1.66602 10.0013 1.66602C13.9134 1.66602 17.0846 4.83727 17.0846 8.74935C17.0875 10.4203 16.4969 12.038 15.418 13.3139L15.4092 13.3243L15.4021 13.3327H15.418ZM14.6084 12.6581C15.5368 11.5676 16.0455 10.1815 16.043 8.74935C16.043 5.41268 13.338 2.70768 10.0013 2.70768C6.66465 2.70768 3.95965 5.41268 3.95965 8.74935C3.95704 10.1815 4.46576 11.5676 5.39423 12.6581L5.52256 12.8093L9.54631 17.0806C9.60475 17.1426 9.67525 17.1921 9.7535 17.2259C9.83175 17.2597 9.91608 17.2771 10.0013 17.2771C10.0865 17.2771 10.1709 17.2597 10.2491 17.2259C10.3274 17.1921 10.3979 17.1426 10.4563 17.0806L14.4801 12.8093L14.6084 12.6581Z"
                      fill="#7D7D7D"
                    />
                  </svg>
                  {{$profile->city}}, {{$profile->country}}
                </p>
              </div>
            </div>
            <div class="row profile-dtail-section">
              <!-- <div class="profile-dtail-section"> -->
              <div class="col-md-6">
                <p>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="28"
                    height="20"
                    viewBox="0 0 28 20"
                    fill="none"
                  >
                    <path
                      d="M27.5787 12.1137C27.3435 11.2853 26.9192 10.5227 26.3392 9.88617C25.7592 9.2496 25.0394 8.75636 24.2364 8.44528C24.8472 8.02154 25.3068 7.41377 25.5481 6.71056C25.7894 6.00735 25.7998 5.24545 25.5778 4.5359C25.3558 3.82636 24.913 3.20626 24.314 2.76599C23.7149 2.32571 22.9909 2.08827 22.2474 2.08827C21.5039 2.08827 20.7799 2.32571 20.1808 2.76599C19.5818 3.20626 19.139 3.82636 18.917 4.5359C18.695 5.24545 18.7054 6.00735 18.9467 6.71056C19.188 7.41377 19.6476 8.02154 20.2584 8.44528C19.355 8.79512 18.5586 9.37502 17.9484 10.1275C17.4246 9.82004 16.8667 9.57488 16.286 9.397C17.1329 8.89157 17.7903 8.12205 18.1574 7.20668C18.5244 6.29131 18.5807 5.28075 18.3177 4.33026C18.0546 3.37978 17.4867 2.54197 16.7013 1.94556C15.9159 1.34916 14.9563 1.02717 13.9701 1.02906C12.9839 1.03095 12.0256 1.35663 11.2424 1.95604C10.4593 2.55545 9.8946 3.39544 9.63519 4.34693C9.37578 5.29841 9.43598 6.30876 9.80654 7.22271C10.1771 8.13666 10.8375 8.90366 11.6863 9.40583C11.1154 9.58253 10.5668 9.82469 10.0515 10.1275C9.44127 9.37502 8.64493 8.79512 7.74147 8.44528C8.35235 8.02154 8.81193 7.41377 9.05323 6.71056C9.29454 6.00735 9.30495 5.24545 9.08295 4.5359C8.86095 3.82636 8.41814 3.20626 7.81907 2.76599C7.21999 2.32571 6.49596 2.08827 5.7525 2.08827C5.00904 2.08827 4.28501 2.32571 3.68593 2.76599C3.08686 3.20626 2.64405 3.82636 2.42205 4.5359C2.20005 5.24545 2.21046 6.00735 2.45177 6.71056C2.69307 7.41377 3.15265 8.02154 3.76353 8.44528C2.71861 8.84668 1.82002 9.55559 1.18643 10.4784C0.552848 11.4012 0.214071 12.4945 0.214845 13.6138C0.214845 13.6353 0.214845 13.6574 0.214845 13.6795C0.950607 14.4828 1.90752 15.0506 2.96519 15.3115C3.20591 15.3709 3.45031 15.4142 3.69678 15.4411C4.02661 15.4769 4.35899 15.4828 4.68988 15.4588C4.67136 15.1261 4.67763 14.7925 4.70864 14.4607C4.37703 14.4916 4.04303 14.4854 3.71278 14.4425C2.78019 14.3253 1.90734 13.9203 1.21567 13.2839C1.28143 12.3829 1.6143 11.522 2.17176 10.8112C2.72922 10.1003 3.48595 9.57182 4.34527 9.29318C5.20459 9.01454 6.12747 8.99841 6.99599 9.24687C7.86451 9.49533 8.63924 9.99709 9.22119 10.688C8.48083 11.2594 7.84807 11.9579 7.3525 12.7509C7.10268 13.1515 6.88993 13.574 6.71691 14.0133C6.89058 14.4536 7.10426 14.8771 7.35526 15.2784C8.05722 16.408 9.03563 17.3399 10.198 17.9861C11.3604 18.6323 12.6684 18.9714 13.9983 18.9714C15.3282 18.9714 16.6362 18.6323 17.7986 17.9861C18.961 17.3399 19.9394 16.408 20.6413 15.2784C20.8933 14.8772 21.1079 14.4537 21.2824 14.0133C21.1087 13.5732 20.895 13.1499 20.6441 12.7487C20.1484 11.9558 19.5156 11.2573 18.7754 10.6858C19.3518 10.0013 20.1175 9.50225 20.9765 9.25135C21.8355 9.00045 22.7495 9.00888 23.6037 9.27557C24.458 9.54225 25.2144 10.0553 25.7781 10.7504C26.3417 11.4454 26.6875 12.2915 26.7721 13.1824C26.3008 13.6432 25.7351 13.9962 25.114 14.2169C24.4929 14.4376 23.8312 14.5208 23.1748 14.4607C23.2059 14.7925 23.2121 15.1261 23.1936 15.4588C23.5245 15.4828 23.8569 15.4769 24.1867 15.4411C24.4332 15.4142 24.6776 15.3709 24.9183 15.3115C26.0331 15.037 27.0346 14.4218 27.7834 13.5515C27.7788 13.0653 27.71 12.5818 27.5787 12.1137ZM5.7525 8.07618C5.25873 8.07618 4.77605 7.92976 4.36549 7.65543C3.95493 7.38111 3.63495 6.9912 3.44599 6.53501C3.25703 6.07883 3.20759 5.57686 3.30392 5.09257C3.40025 4.60829 3.63802 4.16344 3.98717 3.8143C4.33632 3.46515 4.78116 3.22737 5.26545 3.13104C5.74973 3.03471 6.2517 3.08415 6.70789 3.27311C7.16407 3.46207 7.55398 3.78206 7.82831 4.19261C8.10263 4.60317 8.24905 5.08585 8.24905 5.57962C8.24905 6.24175 7.98602 6.87676 7.51783 7.34495C7.04963 7.81315 6.41463 8.07618 5.7525 8.07618ZM10.4686 5.53107C10.4687 4.83698 10.6747 4.1585 11.0604 3.58144C11.4461 3.00437 11.9942 2.55464 12.6355 2.28909C13.2768 2.02355 13.9824 1.95413 14.6632 2.08961C15.3439 2.22509 15.9692 2.55938 16.46 3.05022C16.9507 3.54105 17.2849 4.16639 17.4203 4.84715C17.5556 5.52792 17.4861 6.23354 17.2205 6.87479C16.9548 7.51603 16.505 8.06411 15.9279 8.44972C15.3508 8.83533 14.6722 9.04114 13.9782 9.04114C13.0473 9.04099 12.1547 8.67112 11.4965 8.01287C10.8384 7.35462 10.4686 6.46191 10.4686 5.53107ZM20.2016 14.0138C19.6541 15.1976 18.7792 16.1999 17.6803 16.9024C16.5815 17.6049 15.3045 17.9782 14.0002 17.9782C12.696 17.9782 11.419 17.6049 10.3201 16.9024C9.22122 16.1999 8.34635 15.1976 7.79884 14.0138C8.19596 13.1541 8.76757 12.3863 9.47735 11.7593C10.1871 11.1324 11.0196 10.6599 11.9218 10.3719C12.824 10.0839 13.7762 9.98678 14.718 10.0866C15.6597 10.1864 16.5704 10.4811 17.3922 10.9518C18.6212 11.6589 19.6021 12.7281 20.2011 14.0133L20.2016 14.0138ZM22.2474 8.07618C21.7536 8.07618 21.2709 7.92976 20.8604 7.65543C20.4498 7.38111 20.1298 6.9912 19.9409 6.53501C19.7519 6.07883 19.7025 5.57686 19.7988 5.09257C19.8951 4.60829 20.1329 4.16344 20.4821 3.8143C20.8312 3.46515 21.2761 3.22737 21.7603 3.13104C22.2446 3.03471 22.7466 3.08415 23.2028 3.27311C23.659 3.46207 24.0489 3.78206 24.3232 4.19261C24.5975 4.60317 24.7439 5.08585 24.7439 5.57962C24.7439 6.24175 24.4809 6.87676 24.0127 7.34495C23.5445 7.81315 22.9095 8.07618 22.2474 8.07618Z"
                      fill="#0072B1"
                      stroke="#0072B1"
                      stroke-width="0.3"
                    />
                  </svg>
                  &nbsp; 
                  @if ($profile->service_type == 'Both')
                  
                  Online & In-person Services
                  @else
                  {{$profile->service_type}} Services
                      
                  @endif
                </p>
                <p class="pt-2">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="32"
                    height="32"
                    viewBox="0 0 32 32"
                    fill="none"
                  >
                    <path
                      d="M13.3333 13.3327C16.2789 13.3327 18.6667 10.9449 18.6667 7.99935C18.6667 5.05383 16.2789 2.66602 13.3333 2.66602C10.3878 2.66602 8 5.05383 8 7.99935C8 10.9449 10.3878 13.3327 13.3333 13.3327Z"
                      stroke="#0072B1"
                      stroke-width="2"
                    />
                    <path
                      d="M25.3333 2.66602C25.3333 2.66602 28 4.26602 28 7.99935C28 11.7327 25.3333 13.3327 25.3333 13.3327M22.6667 5.33268C22.6667 5.33268 24 6.13268 24 7.99935C24 9.86602 22.6667 10.666 22.6667 10.666M17.3333 27.486C16.12 27.8153 14.7653 27.9993 13.3333 27.9993C8.17867 27.9993 4 25.6127 4 22.666C4 19.7193 8.17867 17.3327 13.3333 17.3327C18.488 17.3327 22.6667 19.7193 22.6667 22.666C22.6667 23.126 22.564 23.5727 22.3733 23.9993"
                      stroke="#0072B1"
                      stroke-width="2"
                      stroke-linecap="round"
                    />
                  </svg>
                  &nbsp; Speaks {{$profile->primary_language}} and {{$profile->fluent_other_language}}
                </p>
              </div>
              <div class="col-md-6">
                <p>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="32"
                    height="32"
                    viewBox="0 0 32 32"
                    fill="none"
                  >
                    <path
                      d="M11.5193 20.0007C11.4237 20.0007 11.3281 20.0152 11.2369 20.0461C10.7185 20.2215 10.1733 20.334 9.59927 20.334C9.02527 20.334 8.48007 20.2215 7.96127 20.0461C7.87007 20.0152 7.77487 20.0007 7.67927 20.0007C5.19688 20.0007 3.18608 22.104 3.19928 24.6932C3.20488 25.7873 4.06848 26.6673 5.11928 26.6673H14.0793C15.1301 26.6673 15.9937 25.7873 15.9993 24.6932C16.0125 22.104 14.0017 20.0007 11.5193 20.0007ZM9.59927 18.6673C11.7201 18.6673 13.4393 16.8765 13.4393 14.6673C13.4393 12.4582 11.7201 10.6673 9.59927 10.6673C7.47847 10.6673 5.75928 12.4582 5.75928 14.6673C5.75928 16.8765 7.47847 18.6673 9.59927 18.6673ZM26.8792 5.33398H11.5193C10.4605 5.33398 9.59927 6.26107 9.59927 7.40023V9.33398C10.5361 9.33398 11.4033 9.61649 12.1593 10.0757V8.00065H26.2392V20.0007H23.6792V17.334H18.5592V20.0007H15.5097C16.2737 20.6961 16.8344 21.6144 17.0972 22.6673H26.8792C27.938 22.6673 28.7992 21.7402 28.7992 20.6011V7.40023C28.7992 6.26107 27.938 5.33398 26.8792 5.33398Z"
                      fill="#0072B1"
                    /></svg>
                  >
                  &nbsp; 
                  @if ($profile->service_role == 'Both')
                  
                  Classes & Freelance Gigs
                  @else
                  {{$profile->service_role}} Gigs
                      
                  @endif
                  
                </p>
                <p>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="32"
                    height="32"
                    viewBox="0 0 32 32"
                    fill="none"
                  >
                    <path
                      d="M15 11H17V20H15V11ZM13 2H19V4H13V2Z"
                      fill="#0072B1"
                    />
                    <path
                      d="M27.9975 9.00109L26.5775 7.59109L24.3275 9.84109C22.4857 7.71412 19.8952 6.37852 17.0943 6.1118C14.2934 5.84507 11.4974 6.66772 9.28729 8.40883C7.07714 10.1499 5.62277 12.6756 5.22636 15.4611C4.82994 18.2467 5.52196 21.0778 7.15863 23.3664C8.7953 25.6549 11.2508 27.2249 14.0149 27.7502C16.779 28.2755 19.6392 27.7156 22.0013 26.1869C24.3633 24.6582 26.0456 22.2782 26.6985 19.5414C27.3515 16.8047 26.9249 13.9215 25.5075 11.4911L27.9975 9.00109ZM15.9975 26.0011C14.2175 26.0011 12.4774 25.4733 10.9974 24.4843C9.51732 23.4954 8.36377 22.0898 7.68258 20.4452C7.00139 18.8007 6.82316 16.9911 7.17043 15.2453C7.5177 13.4994 8.37486 11.8958 9.63354 10.6371C10.8922 9.37846 12.4959 8.52129 14.2417 8.17402C15.9875 7.82676 17.7971 8.00499 19.4416 8.68617C21.0862 9.36736 22.4918 10.5209 23.4807 12.001C24.4697 13.481 24.9975 15.2211 24.9975 17.0011C24.9975 19.388 24.0493 21.6772 22.3615 23.3651C20.6736 25.0529 18.3844 26.0011 15.9975 26.0011Z"
                      fill="#0072B1"
                    /></svg>
                  >&nbsp; Response Time: 3 Hrs
                </p>
                <!-- </div> -->
              </div>
            </div>
            <!-- ~~~End-personal-profile-imge~~~~ -->
          </div>
          <div class="col-lg-4 col-md-12"></div>
        </div>
        <!-- ============nav-scroll-section-start=========== -->
        <div class="row scrol-nav">
          <div class="col-lg-8 col-md-12 servise-scroll-section ">
            <a href="/professional-profile/{{$profile->id}}/{{$profile->first_name}}{{$profile->last_name}}#Service-Overview"><span class="Underline un-active">Service Overview</span></a>
            <a href="/professional-profile/{{$profile->id}}/{{$profile->first_name}}{{$profile->last_name}}#servise-Card-slider"><span class="Underline">Recently Viewed</span></a>
            <a href="/professional-profile/{{$profile->id}}/{{$profile->first_name}}{{$profile->last_name}}#FaQ-Accordion"><span class="Underline">FAQ’s</span></a>
            <a href="/professional-profile/{{$profile->id}}/{{$profile->first_name}}{{$profile->last_name}}#servise-Card-slider2"><span class="Underline">Seller Listing</span></a>
            <a href="/professional-profile/{{$profile->id}}/{{$profile->first_name}}{{$profile->last_name}}#About-Expert"><span class="Underline">About Expert</span></a>
          </div>
        </div>
        <!-- ============nav-scroll-section-End=========== -->
        <div class="row">
          <div class="col-lg-8 col-md-12">
            <!-- ============================= OWERVIEW SECTION START HERE ===================================== -->
            <div class="row">
              <div id="Service-Overview" class="col-md-12 faq-sec">
                <h1 class="services-h1">Service Overview</h1>
                <p class="overview-para"> {{$profile->overview}}</p>
              </div>
            </div>
            <!-- card-slider start -->
            <div class="row">
              <div id="servise-Card-slider" class="servise-Card-slider">
                <!-- =========Dropdaon start========== -->
                <div class="slider-Dropdawon-h">
                  <h2>Recently Viewed</h2>
                  
                  <label class="dropdown">
                    <select class="dd-button" name="" onchange="getServicesListing(this.id)" id="div_carousel">
                      <option value="All">All Services</option>
                      <option value="Class">Class Services</option>
                      <option value="Freelance">Freelance Services</option>
                    </select> 
                  </label>
                </div>
                <!-- =========Dropdaon End========== -->
                <div class="owl-slider owl-cards">
                  <div id="carousel" class="owl-carousel">

                    @if (count($recentlyViewedGigs) > 0 )

                    @foreach ($recentlyViewedGigs as $item)

                    @php
                    $media = \App\Models\TeacherGigData::where(['gig_id'=>$item->id])->first();
                    $payment = \App\Models\TeacherGigPayment::where(['gig_id'=>$item->id])->first();
                    $user = \App\Models\ExpertProfile::where(['user_id'=>$item->user_id, 'status'=>1])->first();
                    $firstLetter = strtoupper(substr($user->first_name, 0, 1));
                    $lastLetter = strtoupper(substr($user->last_name, 0, 1));
                @endphp

                    <div class="item">
                      <div class="main-Dream-card">
                        <div class="card dream-Card">
                            <div class="dream-card-upper-section">
                              <div style="height: 180px;">
                                @if (Str::endsWith($media->main_file, ['.mp4', '.avi', '.mov', '.webm'])) 
                                <!-- Video Player -->
                                <video autoplay loop muted  style="height: 100%; width: 100%;">
                                    <source src="assets/teacher/listing/data_{{ $item->user_id }}/media/{{$media->main_file}}" type="video/mp4" >
                                    Your browser does not support the video tag.
                                </video>
                            @elseif (Str::endsWith($media->main_file, ['.jpg', '.jpeg', '.png', '.gif']))
                                <!-- Image Display -->
                                <img src="assets/teacher/listing/data_{{ $item->user_id }}/media/{{$media->main_file}}" style="height: 100%;" alt="Uploaded Image">
                            @endif
                                </div>
                                <div class="card-img-overlay overlay-inner">
                                    <p>
                                        Top Seller
                                    </p>
                                    @if (Auth::user())
                                    @php  $wishList = \App\Models\WishList::where(['user_id'=>Auth::user()->id,'gig_id'=>$item->id])->first(); @endphp
                                   @if ($wishList)
                                   <span id="heart_{{$item->id}}" class="liked" onclick="AddWishList(this.id);" data-gig_id="{{$item->id}}">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                </span>
                                   @else
                                   <span id="heart_{{$item->id}}" onclick="AddWishList(this.id);" data-gig_id="{{$item->id}}" >
                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                </span>
                                       
                                   @endif
                                   
                                    @endif
                                    
                                </div>
                            </div>
                            <a href="#" style="text-decoration: none;">
                                {{-- <div class="dream-card-dawon-section" type="button" data-bs-toggle="offcanvas" data-bs-target="#online-person" aria-controls="offcanvasRight"> --}}
                                <div class="dream-card-dawon-section" type="button" data-bs-toggle="offcanvas"   aria-controls="offcanvasRight">
                                    <div class="dream-Card-inner-profile">
                                      @if ($user->profile_image == null)
                                      <img src="assets/profile/avatars/({{$firstLetter}}).jpg" alt="" style="width: 60px;height: 60px; border-radius: 100%; border: 5px solid white;">
                                      @else
                                      <img src="assets/profile/img/{{$user->profile_image}}" alt="" style="width: 60px;height: 60px; border-radius: 100%;border: 5px solid white;">
                                          
                                      @endif
                                        
                                        <i class="fa-solid fa-check tick"></i>
                                    </div>
                                    <p class="servise-bener">{{$item->service_type}} Services</p>
                                    <h5 class="dream-Card-name">
                                        {{$user->first_name}} {{$lastLetter}}.
                                    </h5>
                                    <p class="Dev">{{$user->profession}}</p>
                                    @if ($item->service_role == 'Class')
                                    @if ($item->class_type == 'Recorded')
                                    <p class="about-teaching" ><a class="about-teaching" href="/course-service/{{$item->id}}" style="text-decoration: none;">{{$item->title}}</a> </p>
                                    @else
                                    <p class="about-teaching" ><a class="about-teaching" href="/quick-booking/{{$item->id}}" style="text-decoration: none;">{{$item->title}}</a> </p>
                                    @endif
                                    @else
                                    <p class="about-teaching" ><a class="about-teaching" href="/quick-booking/{{$item->id}}" style="text-decoration: none;">{{$item->title}}</a> </p>
                                    @endif
                                    
                                    {{-- <p class="about-teaching" >{{$item->title}}</p> --}}
                                    <span class="card-rat">
                                        <i class="fa-solid fa-star"></i> &nbsp; (5.0)
                                    </span>
                                    <div class="card-last">
                                        <span>Starting at ${{$payment->rate}}</span>
                                        <!-- word img -->
                                        @if ($item->service_type == 'Online')
                                        <img data-toggle="tooltip" title="In Person-Service" src="assets/seller-listing/asset/img/globe.png" style="height: 25px; width: 25px;" alt="">
                                        
                                        @else
                                        <img data-toggle="tooltip" title="In Person-Service" src="assets/seller-listing/asset/img/handshake.png" style="height: 25px; width: 25px;" alt="">
                                            
                                        @endif
                                        <!-- <i class="fa-solid fa-globe"></i> -->
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                     </a>
                    </div>
                        
                    @endforeach
                        
                    @endif

                    {{-- <div class="item">
                      <div class="main-Dream-card">
                        <div class="card dream-Card">
                          <div class="dream-card-upper-section">
                            <img src="assets/public-site/asset/img/card-main-img.png" alt="" />
                            <div class="card-img-overlay overlay-inner">
                              <p>Top Seller</p>
                              <span id="heart9" eart11>
                                <i class="fa fa-heart-o" aria-hidden="true"></i>
                              </span>
                            </div>
                          </div>
                          <div class="dream-card-dawon-section">
                            <div class="dream-Card-inner-profile">
                              <img src="assets/public-site/asset/img/inner-profile.png" alt="" />
                              <i class="fa-solid fa-check tick"></i>
                            </div>
                            <p class="servise-bener">Online Services</p>
                            <h5 class="dream-Card-name">Usama A.</h5>
                            <p class="Dev">Developer</p>
                            <p class="about-teaching">
                              I will teach you how to build an amazing website
                            </p>
                            <span class="card-rat">
                              <i class="fa-solid fa-star"></i> &nbsp; (5.0)
                            </span>
                            <div class="card-last">
                              <span>Starting at $5</span>
                              <!-- word img -->
                              <a href="#"
                                ><img
                                  data-toggle="tooltip"
                                  title="In Person-Service"
                                  src="assets/public-site/asset/img/globe.png"
                                  style="height: 25px; width: 25px"
                                  alt=""
                              /></a>
                              <!-- <i class="fa-solid fa-globe"></i> -->
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> --}}

 
                  </div>
                </div>
              </div>
            </div>
            <!-- card sliedr script cdn -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.0.0-beta.3/owl.carousel.min.js"></script>
            <!-- card sliedr script cdn -->
            <!-- card-slider start -->
            <!-- ============================= OWERVIEW SECTION END HERE ===================================== -->
            <!-- ============================= FAQ'S SECTION START HERE ===================================== -->
            <div class="row">
              <div class="col-md-12 faq-sec">
                <h1 id="FaQ-Accordion" class="services-h1">
                  Frequently Asked Questions
                </h1>
                <div class="accordion">
                  <ul class="accordion-list p-0">
                    @if (count($faqs) > 0)
                    @foreach ($faqs as $item)

                    <li>
                      <h3>{{$item->question}}</h3>
                      <div class="answer">
                        <hr />
                        <p> {{$item->answer}} </p>
 
                      </div>
                    </li>
                        
                    @endforeach
                  
                        
                    @else
                        
                    <li>
                      <h3>Not Added Any Faqs!</h3>
                      
                    </li>

                    @endif


                     
                  </ul>
                </div>
              </div>
              <!-- ==========card-slider-start======== -->
              <div id="servise-Card-slider2" class="servise-Card-slider">
                <!-- =========Dropdaon start========== -->
                <div class="slider-Dropdawon-h">
                  <h2>Seller Listing</h2>
                  <label class="dropdown">
                    <select class="dd-button" name="" onchange="getServicesListing(this.id)" id="div_carousel2">
                      <option value="All">All Services</option>
                      <option value="Class">Class Services</option>
                      <option value="Freelance">Freelance Services</option>
                    </select>
                      
            
                  </label>
                </div>
                <!-- =========Dropdaon End========== -->
                <div class="owl-slider owl-cards">
                  <div id="carousel2" class="owl-carousel">
                  
                    @if (count($teacher_services) > 0 )

                    @foreach ($teacher_services as $item)

                    @php
                    $media = \App\Models\TeacherGigData::where(['gig_id'=>$item->id])->first();
                    $payment = \App\Models\TeacherGigPayment::where(['gig_id'=>$item->id])->first();
                    $user = \App\Models\ExpertProfile::where(['user_id'=>$item->user_id, 'status'=>1])->first();
                    $firstLetter = strtoupper(substr($user->first_name, 0, 1));
                    $lastLetter = strtoupper(substr($user->last_name, 0, 1));
                @endphp

                    <div class="item">
                      <div class="main-Dream-card">
                        <div class="card dream-Card">
                            <div class="dream-card-upper-section">
                              <div style="height: 180px;">
                                @if (Str::endsWith($media->main_file, ['.mp4', '.avi', '.mov', '.webm'])) 
                            <!-- Video Player -->
                            <video autoplay loop muted  style="height: 100%; width: 100%;">
                                <source src="assets/teacher/listing/data_{{ $item->user_id }}/media/{{$media->main_file}}" type="video/mp4" >
                                Your browser does not support the video tag.
                            </video>
                        @elseif (Str::endsWith($media->main_file, ['.jpg', '.jpeg', '.png', '.gif']))
                            <!-- Image Display -->
                            <img src="assets/teacher/listing/data_{{ $item->user_id }}/media/{{$media->main_file}}" style="height: 100%;" alt="Uploaded Image">
                        @endif
                                </div>
                                <div class="card-img-overlay overlay-inner">
                                    <p>
                                        Top Seller
                                    </p>
                                    @if (Auth::user())
                                    @php  $wishList = \App\Models\WishList::where(['user_id'=>Auth::user()->id,'gig_id'=>$item->id])->first(); @endphp
                                   @if ($wishList)
                                   <span id="heart_{{$item->id}}" class="liked" onclick="AddWishList(this.id);" data-gig_id="{{$item->id}}">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                </span>
                                   @else
                                   <span id="heart_{{$item->id}}" onclick="AddWishList(this.id);" data-gig_id="{{$item->id}}" >
                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                </span>
                                       
                                   @endif
                                   
                                    @endif
                                    
                                </div>
                            </div>
                            <a href="#" style="text-decoration: none;">
                                {{-- <div class="dream-card-dawon-section" type="button" data-bs-toggle="offcanvas" data-bs-target="#online-person" aria-controls="offcanvasRight"> --}}
                                <div class="dream-card-dawon-section" type="button" data-bs-toggle="offcanvas"   aria-controls="offcanvasRight">
                                    <div class="dream-Card-inner-profile">
                                      @if ($user->profile_image == null)
                                      <img src="assets/profile/avatars/({{$firstLetter}}).jpg" alt="" style="width: 60px;height: 60px; border-radius: 100%; border: 5px solid white;">
                                      @else
                                      <img src="assets/profile/img/{{$user->profile_image}}" alt="" style="width: 60px;height: 60px; border-radius: 100%;border: 5px solid white;">
                                          
                                      @endif
                                        
                                        <i class="fa-solid fa-check tick"></i>
                                    </div>
                                    <p class="servise-bener">{{$item->service_type}} Services</p>
                                    <h5 class="dream-Card-name">
                                        {{$user->first_name}} {{$lastLetter}}.
                                    </h5>
                                    <p class="Dev">{{$user->profession}}</p>
                                    @if ($item->service_role == 'Class')
                                    @if ($item->class_type == 'Recorded')
                                    <p class="about-teaching" ><a class="about-teaching" href="/course-service/{{$item->id}}" style="text-decoration: none;">{{$item->title}}</a> </p>
                                    @else
                                    <p class="about-teaching" ><a class="about-teaching" href="/quick-booking/{{$item->id}}" style="text-decoration: none;">{{$item->title}}</a> </p>
                                    @endif
                                    @else
                                    <p class="about-teaching" ><a class="about-teaching" href="/quick-booking/{{$item->id}}" style="text-decoration: none;">{{$item->title}}</a> </p>
                                    @endif
                                    
                                    {{-- <p class="about-teaching" >{{$item->title}}</p> --}}
                                    <span class="card-rat">
                                        <i class="fa-solid fa-star"></i> &nbsp; (5.0)
                                    </span>
                                    <div class="card-last">
                                        <span>Starting at ${{$payment->rate}}</span>
                                        <!-- word img -->
                                        @if ($item->service_type == 'Online')
                                        <img data-toggle="tooltip" title="In Person-Service" src="assets/seller-listing/asset/img/globe.png" style="height: 25px; width: 25px;" alt="">
                                        
                                        @else
                                        <img data-toggle="tooltip" title="In Person-Service" src="assets/seller-listing/asset/img/handshake.png" style="height: 25px; width: 25px;" alt="">
                                            
                                        @endif
                                        <!-- <i class="fa-solid fa-globe"></i> -->
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                     </a>
                    </div>
                        
                    @endforeach
                        
                    @endif


                 
                  </div>
                </div>
              </div>
              <!-- card sliedr script cdn -->
              <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
              <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.0.0-beta.3/owl.carousel.min.js"></script>
              <!-- card sliedr script cdn -->
              <!-- ==========card-slider-start======== -->
            </div>
            <!-- ============================= FAQ'S SECTION END HERE ===================================== -->
            <!-- ============================= ABOUT EXPERT SECTION START HERE ===================================== -->
            <div class="row">
              <div class="col-md-12 faq-sec">
                <h1 id="About-Expert" class="services-h1">About Expert</h1>
                <div class="row">
                  <div class="col-md-12">
                    <div class="personal-profile">
                      <div class="profile-img">
                        @if ($profile->profile_image == null)
                        @php  $firstLetter = strtoupper(substr($profile->first_name, 0, 1));  @endphp
                        <img src="assets/profile/avatars/({{$firstLetter}}).jpg"> 
                       @else
                       <img src="assets/profile/img/{{$profile->profile_image}}" alt=""> 
                      @endif 
                      </div>
                      <div class="personal-profile-detail">
                        <h4 class="mb-0">{{$profile->first_name}} {{$profile->last_name}}</h4>
                        <p class="mb-0">
                          <b> {{$profile->profession}}</b>
                        </p>
                        <p class="mb-0">
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="20"
                            height="20"
                            viewBox="0 0 20 20"
                            fill="none"
                          >
                            <path
                              d="M10.0034 6.45768C9.34035 6.45768 8.70447 6.72107 8.23563 7.18992C7.76679 7.65876 7.5034 8.29464 7.5034 8.95768C7.5034 9.62072 7.76679 10.2566 8.23563 10.7254C8.70447 11.1943 9.34035 11.4577 10.0034 11.4577C10.6664 11.4577 11.3023 11.1943 11.7712 10.7254C12.24 10.2566 12.5034 9.62072 12.5034 8.95768C12.5034 8.29464 12.24 7.65876 11.7712 7.18992C11.3023 6.72107 10.6664 6.45768 10.0034 6.45768ZM8.54506 8.95768C8.54506 8.57091 8.69871 8.19998 8.9722 7.92649C9.24569 7.65299 9.61662 7.49935 10.0034 7.49935C10.3902 7.49935 10.7611 7.65299 11.0346 7.92649C11.3081 8.19998 11.4617 8.57091 11.4617 8.95768C11.4617 9.34446 11.3081 9.71539 11.0346 9.98888C10.7611 10.2624 10.3902 10.416 10.0034 10.416C9.61662 10.416 9.24569 10.2624 8.9722 9.98888C8.69871 9.71539 8.54506 9.34446 8.54506 8.95768ZM15.418 13.3327L11.2146 17.7952C11.0588 17.9606 10.8708 18.0925 10.6621 18.1826C10.4535 18.2727 10.2286 18.3192 10.0013 18.3192C9.77402 18.3192 9.54914 18.2727 9.34048 18.1826C9.13182 18.0925 8.9438 17.9606 8.78798 17.7952L4.58465 13.3327H4.60048L4.5934 13.3243L4.58465 13.3139C3.50577 12.038 2.91511 10.4203 2.91798 8.74935C2.91798 4.83727 6.08923 1.66602 10.0013 1.66602C13.9134 1.66602 17.0846 4.83727 17.0846 8.74935C17.0875 10.4203 16.4969 12.038 15.418 13.3139L15.4092 13.3243L15.4021 13.3327H15.418ZM14.6084 12.6581C15.5368 11.5676 16.0455 10.1815 16.043 8.74935C16.043 5.41268 13.338 2.70768 10.0013 2.70768C6.66465 2.70768 3.95965 5.41268 3.95965 8.74935C3.95704 10.1815 4.46576 11.5676 5.39423 12.6581L5.52256 12.8093L9.54631 17.0806C9.60475 17.1426 9.67525 17.1921 9.7535 17.2259C9.83175 17.2597 9.91608 17.2771 10.0013 17.2771C10.0865 17.2771 10.1709 17.2597 10.2491 17.2259C10.3274 17.1921 10.3979 17.1426 10.4563 17.0806L14.4801 12.8093L14.6084 12.6581Z"
                              fill="#7D7D7D"
                            />
                          </svg>
                          {{$profile->city}}, {{$profile->country}}
                        </p>
                      </div>
                    </div>
                    <p class="faq-note">
                      Note : To ensure that your payments are protected under
                      our terms, never transfer money or send messages outside
                      of the DreamCrowd platform.
                    </p>
                    @if (Auth::user() && Auth::user()->role == 0)
                    <button   data-bs-toggle="modal" data-bs-target="#contact-me-modal" class="btn faqs-btn">
                      Contact Me
                    </button>



                    
                  <!-- Send Message  Modal Start =========-->
                  <div
                  class="modal fade"
                  id="contact-me-modal"
                  tabindex="-1"
                  aria-labelledby="exampleModalLabel"
                  aria-hidden="true"
                >
                  <div class="modal-dialog">
                    <div class="modal-content contact-modal">
                      <div class="modal-body p-0">
                        <div class="row">
                          <form id="messageForm">
                          {{-- <div class="col-md-12 name-label">
                            <label for="inputEmail4" class="form-label float-start">Name</label>
                            <input
                              type="text" readonly
                              class="form-control"
                              id="inputEmail4" value="{{$profile->first_name}} {{$profile->last_name}}"
                              placeholder="Usama Aslam"
                            />
                          </div> --}}
                          <div class="col-md-12 check-services">
                            <div class="form-group">
                              <label class="float-start" for="message-textarea">Message Details</label>
                              <textarea
                                class="form-control"
                                id="message-textarea"
                                cols="11"
                                rows="6"
                                placeholder="type your message..."
                              ></textarea>
                            </div>
                          </div>
                          <div class="col-md-12 booking-buttons">
                            <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn booking-cancel">Cancel</button>
                            <button
                              type="button"
                              class="btn request-booking"
                                onclick="SendSMS()"
                            >
                              Send Request
                            </button>
                          </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> 

            <!-- Send Message  Modal END =========-->
            
 
                 <!-- Modal Structure -->
                <div class="modal" id="messageModal" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Send a Message</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form id="messageForm">
                          <div class="form-group emoji-picker-container">
                            <textarea
                              class="message-textarea" id="message-textarea"
                              data-emojiable="true"  placeholder="Type your message..."
                            ></textarea>
                          </div>
                          <div class="message-icons">
                            <button type="button" id="emoji-button" class="icon-btn">
                            <i class="fa-regular fa-face-smile"></i>
                            </button>
                            <button type="button" class="icon-btn">
                            <input type="file" id="imgInput" accept="image/*" style="display: none;">
                            <i class="fa-solid fa-paperclip" onclick="uploadImage()"></i>
                            </button>
                            <button type="button" class="icon-btn">
                            <input type="file" id="imgInput" accept="image/*" style="display: none;">
                            <i class="fa-regular fa-images" onclick="uploadImage()"></i>
                            </button>
                            <button type="button" class="icon-btn">
                            <input type="file" id="imgInput" accept="image/*" style="display: none;"><i class="fa-solid fa-video" onclick="uploadImage()"></i>
                            </button>
                           </div>
                          <div class="form-group text-end mt-3">
                            {{-- <button type="button" onclick="SendSMS()" class="btn btn-primary">Send</button> --}}
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>

                    @endif
                   
                  </div>
                </div>
              </div>
            </div>
            <!-- ============================= ABOUT EXPERT SECTION END HERE ===================================== -->

            <!-- ============================= RATING SECTION START HERE ===================================== -->
            <div class="row rating">
              <div class="col-md-4">
                <h1 class="services-h1">Rating</h1>
                <div class="rating-star">
                  <h2>5.0</h2>
                  <div class="star">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                  </div>
                  <p>Overall Rating</p>
                </div>
              </div>
              <div class="col-md-8 pg">
                <div class="pbar-flex-1">
                  <span class="pbar-mr-2">5.</span>
                  <div class="progress">
                    <div
                      class="progress-bar pg-bar"
                      role="progressbar"
                      style="width: 76.3%"
                      aria-valuenow="76.3"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    ></div>
                  </div>
                  &nbsp;&nbsp;
                  <p class="para">76.3%</p>
                </div>

                <div class="pbar-flex-1">
                  <span class="pbar-mr-2">4.</span>
                  <div class="progress">
                    <div
                      class="progress-bar pg-bar"
                      role="progressbar"
                      style="width: 72%"
                      aria-valuenow="72"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    ></div>
                  </div>
                  &nbsp;&nbsp;
                  <p class="para">72%</p>
                </div>

                <div class="pbar-flex-1">
                  <span class="pbar-mr-2">3.</span>
                  <div class="progress">
                    <div
                      class="progress-bar pg-bar"
                      role="progressbar"
                      style="width: 50.6%"
                      aria-valuenow="50.6"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    ></div>
                  </div>
                  &nbsp;&nbsp;
                  <p class="para">50.6%</p>
                </div>

                <div class="pbar-flex-1">
                  <span class="pbar-mr-2">2.</span>
                  <div class="progress">
                    <div
                      class="progress-bar pg-bar"
                      role="progressbar"
                      style="width: 56%"
                      aria-valuenow="56"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    ></div>
                  </div>
                  &nbsp;&nbsp;
                  <p class="para">56%</p>
                </div>

                <div class="pbar-flex-1">
                  <span class="pbar-mr-2">1.</span>
                  <div class="progress">
                    <div
                      class="progress-bar pg-bar"
                      role="progressbar"
                      style="width: 18.8%"
                      aria-valuenow="18.8"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    ></div>
                  </div>
                  &nbsp;&nbsp;
                  <p class="para">18.8%</p>
                </div>
              </div>
            </div>
            <!-- ============================= RATING SECTION END HERE ===================================== -->
          </div>
          <div class="col-lg-4 col-md-12"></div>
        </div>
        <!-- ===========scroll sectio================ -->
      </div>
      <!--==================================================================================================================== -->

      <!-- =========================== BUYER REVIEWS SECTION START HERE ======================================== -->
      <div class="container-fluid card_wrapper">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <h1 class="page-title mb-0 buyer">Buyer Reviews</h1>
              <p class="page-title-2">
                Voice of Our Valued Buyers - LMS Buyer Reviews!
              </p>
              <div class="owl-carousel card_carousel mb-4">
                <div class="card card-slider">
                  <div class="card-body">
                    <div class="d-flex">
                      <img
                        src="assets/public-site/asset/img/slidercommentimg1.png"
                        class="rounded-circle"
                      />
                      <div class="d-flex flex-column">
                        <div class="name">Thomas H.</div>
                        <p class="text-muted">Student</p>
                      </div>
                    </div>
                    <p class="card-text">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                      Amet sollicitudin tristique ac praesent ullamcorper nisl
                      eu accumsan.Lorem ipsum dolor sit amet, consectetur
                      adipiscing elit. Amet sollicitudin tristique ac praesent
                      ullamcorper nisl eu accumsan.
                    </p>
                  </div>
                </div>
                <div class="card card-slider">
                  <div class="card-body">
                    <div class="d-flex">
                      <div class="rounded-circle review-profile">
                        <h3>T</h3>
                    </div>
                      <div class="d-flex flex-column">
                        <div class="name">Thomas H.</div>
                        <p class="text-muted">Student</p>
                      </div>
                    </div>
                    <p class="card-text">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                      Amet sollicitudin tristique ac praesent ullamcorper nisl
                      eu accumsan.Lorem ipsum dolor sit amet, consectetur
                      adipiscing elit. Amet sollicitudin tristique ac praesent
                      ullamcorper nisl eu accumsan.
                    </p>
                  </div>
                </div>
                <div class="card card-slider">
                  <div class="card-body">
                    <div class="d-flex">
                      <img
                        src="assets/public-site/asset/img/slidercommentimg1.png"
                        class="rounded-circle"
                      />
                      <div class="d-flex flex-column">
                        <div class="name">Thomas H.</div>
                        <p class="text-muted">Student</p>
                      </div>
                    </div>
                    <p class="card-text">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                      Amet sollicitudin tristique ac praesent ullamcorper nisl
                      eu accumsan.Lorem ipsum dolor sit amet, consectetur
                      adipiscing elit. Amet sollicitudin tristique ac praesent
                      ullamcorper nisl eu accumsan.
                    </p>
                  </div>
                </div>
                <div class="card card-slider">
                  <div class="card-body">
                    <div class="d-flex">
                      <img src="assets/public-site/asset/img/IMG1.png" class="rounded-circle" />
                      <div class="d-flex flex-column">
                        <div class="name">Thomas H.</div>
                        <p class="text-muted">Student</p>
                      </div>
                    </div>
                    <p class="card-text">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                      Amet sollicitudin tristique ac praesent ullamcorper nisl
                      eu accumsan.Lorem ipsum dolor sit amet, consectetur
                      adipiscing elit. Amet sollicitudin tristique ac praesent
                      ullamcorper nisl eu accumsan.
                    </p>
                  </div>
                </div>
                <div class="card card-slider">
                  <div class="card-body">
                    <div class="d-flex">
                      <img
                        src="assets/public-site/asset/img/slidercommentimg1.png"
                        class="rounded-circle"
                      />
                      <div class="d-flex flex-column">
                        <div class="name">Thomas H.</div>
                        <p class="text-muted">Student</p>
                      </div>
                    </div>
                    <p class="card-text">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                      Amet sollicitudin tristique ac praesent ullamcorper nisl
                      eu accumsan.Lorem ipsum dolor sit amet, consectetur
                      adipiscing elit. Amet sollicitudin tristique ac praesent
                      ullamcorper nisl eu accumsan.
                    </p>
                  </div>
                </div>
                <div class="card card-slider">
                  <div class="card-body">
                    <div class="d-flex">
                      <img src="assets/public-site/asset/img/IMG1.png" class="rounded-circle" />
                      <div class="d-flex flex-column">
                        <div class="name">Thomas H.</div>
                        <p class="text-muted">Student</p>
                      </div>
                    </div>
                    <p class="card-text">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                      Amet sollicitudin tristique ac praesent ullamcorper nisl
                      eu accumsan.Lorem ipsum dolor sit amet, consectetur
                      adipiscing elit. Amet sollicitudin tristique ac praesent
                      ullamcorper nisl eu accumsan.
                    </p>
                  </div>
                </div>
                <div class="card card-slider">
                  <div class="card-body">
                    <div class="d-flex">
                      <img
                        src="assets/public-site/asset/img/slidercommentimg1.png"
                        class="rounded-circle"
                      />
                      <div class="d-flex flex-column">
                        <div class="name">Thomas H.</div>
                        <p class="text-muted">Student</p>
                      </div>
                    </div>
                    <p class="card-text">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                      Amet sollicitudin tristique ac praesent ullamcorper nisl
                      eu accumsan.Lorem ipsum dolor sit amet, consectetur
                      adipiscing elit. Amet sollicitudin tristique ac praesent
                      ullamcorper nisl eu accumsan.
                    </p>
                  </div>
                </div>
                <div class="card card-slider">
                  <div class="card-body">
                    <div class="d-flex">
                      <img src="assets/public-site/asset/img/IMG1.png" class="rounded-circle" />
                      <div class="d-flex flex-column">
                        <div class="name">Thomas H.</div>
                        <p class="text-muted">Student</p>
                      </div>
                    </div>
                    <p class="card-text">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                      Amet sollicitudin tristique ac praesent ullamcorper nisl
                      eu accumsan.Lorem ipsum dolor sit amet, consectetur
                      adipiscing elit. Amet sollicitudin tristique ac praesent
                      ullamcorper nisl eu accumsan.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- ======================= VIEW ALL BTN START HERE ================ -->
          <div class="row">
            <div class="col-md-12">
              <center>
                <button type="button" class="btn veiwbtn" data-bs-toggle="modal" data-bs-target="#all-review-modal">View All</button>
              </center>
            </div>
          </div>
          <!-- ======================= VIEW ALL BTN END HERE ================ -->
        </div>
      </div>
      <!-- =========================== BUYER REVIEWS SECTION END HERE ========================================== -->
      <!-- ================================ YOU MIGHT ALSO LIKE SECTION START HERE ======================================== -->
      <div class="card_wrapper">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <h1 class="page-title mb-0 buyer">You Might also like</h1>
              <p class="page-title-2">
                Explore Trending Services on our Platform!!
              </p>
            </div>
          </div>
          <div class="row">
            <!-- CARD SECTION START HERE -->
            <div class="row">


              @if (count($sameCategoryGigs) > 0)
                
              @foreach ($sameCategoryGigs as $item)
  
              @php
              $media = \App\Models\TeacherGigData::where(['gig_id'=>$item->id])->first();
              $payment = \App\Models\TeacherGigPayment::where(['gig_id'=>$item->id])->first();
              $user = \App\Models\ExpertProfile::where(['user_id'=>$item->user_id, 'status'=>1])->first();
              $firstLetter = strtoupper(substr($user->first_name, 0, 1));
              $lastLetter = strtoupper(substr($user->last_name, 0, 1));
          @endphp
  
              <div class="col-lg-3 col-md-6 col-12">
                <div class="main-Dream-card">
                    <div class="card dream-Card">
                        <div class="dream-card-upper-section">
                          <div style="height: 180px;">
                          
                            @if (Str::endsWith($media->main_file, ['.mp4', '.avi', '.mov', '.webm'])) 
                            <!-- Video Player -->
                            <video autoplay loop muted  style="height: 100%; width: 100%;">
                                <source src="assets/teacher/listing/data_{{ $item->user_id }}/media/{{$media->main_file}}" type="video/mp4" >
                                Your browser does not support the video tag.
                            </video>
                        @elseif (Str::endsWith($media->main_file, ['.jpg', '.jpeg', '.png', '.gif']))
                            <!-- Image Display -->
                            <img src="assets/teacher/listing/data_{{ $item->user_id }}/media/{{$media->main_file}}" style="height: 100%;" alt="Uploaded Image">
                        @endif
                          
                          </div>
                            <div class="card-img-overlay overlay-inner">
                                <p>
                                    Top Seller
                                </p>
                                @if (Auth::user())
                                @php  $wishList = \App\Models\WishList::where(['user_id'=>Auth::user()->id,'gig_id'=>$item->id])->first(); @endphp
                               @if ($wishList)
                               <span id="heart_{{$item->id}}" class="liked" onclick="AddWishList(this.id);" data-gig_id="{{$item->id}}">
                                <i class="fa fa-heart" aria-hidden="true"></i>
                            </span>
                               @else
                               <span id="heart_{{$item->id}}" onclick="AddWishList(this.id);" data-gig_id="{{$item->id}}" >
                                <i class="fa fa-heart-o" aria-hidden="true"></i>
                            </span>
                                   
                               @endif
                               
                                @endif
                                
                            </div>
                        </div>
                        <a href="#" style="text-decoration: none;">
                            {{-- <div class="dream-card-dawon-section" type="button" data-bs-toggle="offcanvas" data-bs-target="#online-person" aria-controls="offcanvasRight"> --}}
                            <div class="dream-card-dawon-section" type="button" data-bs-toggle="offcanvas"   aria-controls="offcanvasRight">
                                <div class="dream-Card-inner-profile">
                                  @if ($user->profile_image == null)
                                  <img src="assets/profile/avatars/({{$firstLetter}}).jpg" alt="" style="width: 60px;height: 60px; border-radius: 100%; border: 5px solid white;">
                                  @else
                                  <img src="assets/profile/img/{{$user->profile_image}}" alt="" style="width: 60px;height: 60px; border-radius: 100%;border: 5px solid white;">
                                      
                                  @endif
                                    
                                    <i class="fa-solid fa-check tick"></i>
                                </div>
                                <p class="servise-bener">{{$item->service_type}} Services</p>
                                <h5 class="dream-Card-name">
                                    {{$user->first_name}} {{$lastLetter}}.
                                </h5>
                                <p class="Dev">{{$user->profession}}</p>
                                @if ($item->service_role == 'Class')
                                @if ($item->class_type == 'Recorded')
                                <p class="about-teaching" ><a class="about-teaching" href="/course-service/{{$item->id}}" style="text-decoration: none;">{{$item->title}}</a> </p>
                                @else
                                <p class="about-teaching" ><a class="about-teaching" href="/quick-booking/{{$item->id}}" style="text-decoration: none;">{{$item->title}}</a> </p>
                                @endif
                                @else
                                <p class="about-teaching" ><a class="about-teaching" href="/quick-booking/{{$item->id}}" style="text-decoration: none;">{{$item->title}}</a> </p>
                                @endif
                                
                                {{-- <p class="about-teaching" >{{$item->title}}</p> --}}
                                <span class="card-rat">
                                    <i class="fa-solid fa-star"></i> &nbsp; (5.0)
                                </span>
                                <div class="card-last">
                                    <span>Starting at ${{$payment->rate}}</span>
                                    <!-- word img -->
                                    @if ($item->service_type == 'Online')
                                    <img data-toggle="tooltip" title="In Person-Service" src="assets/seller-listing/asset/img/globe.png" style="height: 25px; width: 25px;" alt="">
                                    
                                    @else
                                    <img data-toggle="tooltip" title="In Person-Service" src="assets/seller-listing/asset/img/handshake.png" style="height: 25px; width: 25px;" alt="">
                                        
                                    @endif
                                    <!-- <i class="fa-solid fa-globe"></i> -->
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                 </a>
            </div>
                  
              @endforeach 

              @endif

 
            </div>
            <!-- CARD SECTION END HERE -->
          </div>
        </div>
      </div>
      <!-- ================================ YOU MIGHT ALSO LIKE SECTION END HERE ======================================== -->
    </div>
    <!-- ============================= FOOTER SECTION START HERE ===================================== -->
    <x-public-footer/>
    <!-- =============================== FOOTER SECTION END HERE ===================================== -->
    <script src="assets/public-site/libs/jquery/jquery.js"></script>
    <script src="assets/public-site/libs/datatable/js/datatable.js"></script>
    <script src="assets/public-site/libs/datatable/js/datatablebootstrap.js"></script>
    <script src="assets/public-site/libs/select2/js/select2.min.js"></script>
    <script src="assets/public-site/libs/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="assets/public-site/asset/js/bootstrap.min.js"></script>
    <script src="assets/public-site/asset/js/script.js"></script>
    <!-- ================= -->
    <!-- =CARD SLIDER JS== -->
    <!-- ================= -->
    <script>
      jQuery("#carousel").owlCarousel({
        autoplay: true,
        rewind: true,
        /* use rewind if you don't want loop */
        margin: 20,
        /*
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            */
        responsiveClass: true,
        autoHeight: true,
        autoplayTimeout: 7000,
        smartSpeed: 800,
        nav: true,
        responsive: {
          0: {
            items: 1,
          },

          600: {
            items: 2,
          },

          1024: {
            items: 2.5,
          },

          1366: {
            items: 2.5,
          },
        },
      });
    </script>
    <script>
      jQuery("#carousel2").owlCarousel({
        autoplay: true,
        rewind: true,
        /* use rewind if you don't want loop */
        margin: 20,
        /*
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            */
        responsiveClass: true,
        autoHeight: true,
        autoplayTimeout: 7000,
        smartSpeed: 800,
        nav: true,
        responsive: {
          0: {
            items: 1,
          },

          600: {
            items: 2,
          },

          1024: {
            items: 2.5,
          },

          1366: {
            items: 2.5,
          },
        },
      });
    </script>
    <!-- ================= -->
    <!-- =CARD SLIDER JS== -->
    <!-- ================= -->
  </body>
</html>

<!--===== Herro product slider-JS ====== -->
<script>
  $(document).ready(function () {
    var sync1 = $("#sync1");
    var sync2 = $("#sync2");
    var slidesPerPage = 4; //globaly define number of elements per page
    var syncedSecondary = true;

    sync1
      .owlCarousel({
        items: 1,
        slideSpeed: 2000,
        nav: true,
        autoplay: false,
        dots: true,
        loop: true,
        responsiveRefreshRate: 200,
        navText: [
          '<svg width="100%" height="100%" viewBox="0 0 11 20"><path style="fill:none;stroke-width: 1px;stroke: #fff;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>',
          '<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1"><path style="fill:none;stroke-width: 1px;stroke: #ffff;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>',
        ],
      })
      .on("changed.owl.carousel", syncPosition);

    sync2
      .on("initialized.owl.carousel", function () {
        sync2.find(".owl-item").eq(0).addClass("current");
      })
      .owlCarousel({
        items: slidesPerPage,
        dots: true,
        nav: true,
        smartSpeed: 200,
        slideSpeed: 500,
        slideBy: slidesPerPage, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
        responsiveRefreshRate: 100,
      })
      .on("changed.owl.carousel", syncPosition2);

    function syncPosition(el) {
      //if you set loop to false, you have to restore this next line
      //var current = el.item.index;

      //if you disable loop you have to comment this block
      var count = el.item.count - 1;
      var current = Math.round(el.item.index - el.item.count / 2 - 0.5);

      if (current < 0) {
        current = count;
      }
      if (current > count) {
        current = 0;
      }

      //end block

      sync2
        .find(".owl-item")
        .removeClass("current")
        .eq(current)
        .addClass("current");
      var onscreen = sync2.find(".owl-item.active").length - 1;
      var start = sync2.find(".owl-item.active").first().index();
      var end = sync2.find(".owl-item.active").last().index();

      if (current > end) {
        sync2.data("owl.carousel").to(current, 100, true);
      }
      if (current < start) {
        sync2.data("owl.carousel").to(current - onscreen, 100, true);
      }
    }

    function syncPosition2(el) {
      if (syncedSecondary) {
        var number = el.item.index;
        sync1.data("owl.carousel").to(number, 100, true);
      }
    }

    sync2.on("click", ".owl-item", function (e) {
      e.preventDefault();
      var number = $(this).index();
      sync1.data("owl.carousel").to(number, 300, true);
    });
  });
</script>
<!--===== Herro product slider-JS ====== -->
<!-- online-person canvas -->
<div id="quick-booking">
  <div
    class="offcanvas offcanvas-end services-offcanvas"
    tabindex="-1"
    id="online-person"
    aria-labelledby="offcanvasRightLabel"
  >
    <div class="offcanvas-header offcanvas-heading">
      <h5 id="offcanvasRightLabel">Quick Booking</h5>
    </div>
    <div class="offcanvas-body services-details">
      <div class="row">
        <div class="col-md-1">
          <div class="profile">
            <img src="assets/public-site/asset/img/personal-profile.png" alt="" />
          </div>
        </div>
        <div class="col-md-11">
          <div class="profile-det">
            <h5>Usama A.</h5>
            <p class="graphic">Graphic Designer</p>
            <p class="location">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
              >
                <path
                  d="M10.0034 6.45817C9.34035 6.45817 8.70447 6.72156 8.23563 7.1904C7.76679 7.65924 7.5034 8.29513 7.5034 8.95817C7.5034 9.62121 7.76679 10.2571 8.23563 10.7259C8.70447 11.1948 9.34035 11.4582 10.0034 11.4582C10.6664 11.4582 11.3023 11.1948 11.7712 10.7259C12.24 10.2571 12.5034 9.62121 12.5034 8.95817C12.5034 8.29513 12.24 7.65924 11.7712 7.1904C11.3023 6.72156 10.6664 6.45817 10.0034 6.45817ZM8.54506 8.95817C8.54506 8.5714 8.69871 8.20046 8.9722 7.92697C9.24569 7.65348 9.61662 7.49984 10.0034 7.49984C10.3902 7.49984 10.7611 7.65348 11.0346 7.92697C11.3081 8.20046 11.4617 8.5714 11.4617 8.95817C11.4617 9.34494 11.3081 9.71588 11.0346 9.98937C10.7611 10.2629 10.3902 10.4165 10.0034 10.4165C9.61662 10.4165 9.24569 10.2629 8.9722 9.98937C8.69871 9.71588 8.54506 9.34494 8.54506 8.95817ZM15.418 13.3332L11.2146 17.7957C11.0588 17.9611 10.8708 18.093 10.6621 18.1831C10.4535 18.2732 10.2286 18.3197 10.0013 18.3197C9.77402 18.3197 9.54914 18.2732 9.34048 18.1831C9.13182 18.093 8.9438 17.9611 8.78798 17.7957L4.58465 13.3332H4.60048L4.5934 13.3248L4.58465 13.3144C3.50577 12.0384 2.91511 10.4208 2.91798 8.74984C2.91798 4.83775 6.08923 1.6665 10.0013 1.6665C13.9134 1.6665 17.0846 4.83775 17.0846 8.74984C17.0875 10.4208 16.4969 12.0384 15.418 13.3144L15.4092 13.3248L15.4021 13.3332H15.418ZM14.6084 12.6586C15.5368 11.5681 16.0455 10.182 16.043 8.74984C16.043 5.41317 13.338 2.70817 10.0013 2.70817C6.66465 2.70817 3.95965 5.41317 3.95965 8.74984C3.95704 10.182 4.46576 11.5681 5.39423 12.6586L5.52256 12.8098L9.54631 17.0811C9.60475 17.1431 9.67525 17.1926 9.7535 17.2264C9.83175 17.2602 9.91608 17.2776 10.0013 17.2776C10.0865 17.2776 10.1709 17.2602 10.2491 17.2264C10.3274 17.1926 10.3979 17.1431 10.4563 17.0811L14.4801 12.8098L14.6084 12.6586Z"
                  fill="#7D7D7D"
                /></svg>
              >Huston, London, United Kingdom
            </p>
          </div>
        </div>
        <div class="col-md-12">
          <button class="btn view-all-profile">View Full Profile</button>
        </div>
        <div class="col-md-12">
          <div class="booking-det">
            <h5>
              Title : <span>I would help you build an amazing website</span>
            </h5>
            <h5>
              Service & Payment Type : <span class="in-person">In-Person</span
              ><span> Freelance | Group Booking | Subscription</span>
            </h5>
            <h5>Price : <span>From $10</span></h5>
            <h5>
              Delivery & Completion Date :
              <span>Within 15 days each month</span>
            </h5>
            <h5>Description :</h5>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vitae ut
              tellus quis a euismod ut nisl, quis. Tristique bibendum morbi vel
              vitae ultrices donec accumsan. Tincidunt eget habitant
              pellentesque id purus. Hendrerit varius sapien, nunc, turpis augue
              arcu venenatis. At sed consectetur in viverra duis tincidunt diam.
              Fames diam, interdum fringilla venenatis sed mi quis. Convallis
              enim, sit pharetra fermentum pellentesque eros. Tortor cras nulla
              sit dui tincidunt platea mauris. Enim, risus non posuere venenatis
              non quis id nec. Consectetur vitae gravida ut morbi tellus arcu.
              In pretium in malesuada neque. At mauris massa magna mauris,
            </p>
            <h5>Requirements :</h5>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vitae ut
              tellus quis a euismod ut nisl, quis. Tristique bibendum morbi vel
              vitae ultrices donec accumsan. Tincidunt eget habitant
              pellentesque id purus. Hendrerit varius sapien, nunc, turpis augue
              arcu venenatis. At sed consectetur in viverra duis tincidunt diam.
            </p>
            <h5>Booking & Cancelation Details :</h5>
            <p>
              After booking a class or activity, you will be emailed
              instructions on how to attend the experience on Zoom. You can
              cancel or reschedule a booking up to 24 hours before the
              experience starts for free
            </p>
            <div class="portfolio-sec">
              <h5>Portfolio</h5>
              <div class="row">
                <div class="col-md-3">
                  <a
                    href="assets/img/portfolioimg (1).png"
                    data-fancybox="gallery"
                    data-caption=""
                  >
                    <img src="assets/public-site/asset/img/portfolioimg (1).png" />
                  </a>
                </div>
                <div class="col-md-3">
                  <a
                    href="assets/public-site/asset/img/portfolioimg (2).png"
                    data-fancybox="gallery"
                    data-caption=""
                  >
                    <img src="assets/public-site/asset/img/portfolioimg (2).png" />
                  </a>
                </div>
                <div class="col-md-3">
                  <a
                    href="assets/public-site/asset/img/portfolioimg (3).png"
                    data-fancybox="gallery"
                    data-caption=""
                  >
                    <img src="assets/public-site/asset/img/portfolioimg (3).png" />
                  </a>
                </div>
                <div class="col-md-3">
                  <a
                    href="assets/public-site/asset/img/portfolioimg (4).png"
                    data-fancybox="gallery"
                    data-caption=""
                  >
                    <img src="assets/public-site/asset/img/portfolioimg (4).png" />
                  </a>
                </div>
              </div>
              <!-- row / end -->
            </div>
            <div class="portfolio-form">
              <form class="row g-3">
                <div class="col-md-4 select-group">
                  <label for="select"> Select Group Type </label><br />
                  <select id="select" type="text">
                    <option value="b">Public Group</option>
                    <option value="c">Private Group</option>
                  </select>
                </div>
                <div class="col-md-4 guest select-groups">
                  <label for="inputPassword4" class="form-label"
                    >Select Number of Guest</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    id="inputPassword4"
                    placeholder="Number of Adults"
                  />
                </div>
                <div class="col-md-4 guest select-groups input-sec">
                  <input
                    type="text"
                    class="form-control numberof-childs"
                    id="inputPassword4"
                    placeholder="Number of Childs"
                  />
                </div>
                <div class="col-md-6 frequency">
                  <label for="inputEmail4" class="form-label"
                    >Select Class Frequency</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    id="inputEmail4"
                    placeholder="Select Class Frequency"
                  />
                </div>
                <div class="col-md-6 multiple-val-input multiemail">
                  <label for="inputEmail4" class="form-label"
                    >Enter Guests Emails for Class Invitation</label
                  >
                  <br />
                  <div class="col-sm-12 email-id-row">
                    <div class="all-mail" id="all-mail-1"></div>
                    <input type="text" name="email" class="enter-mail-id emails" id="enter-mail-id-1" placeholder="Enter the email id .." />
                </div>
                </div>
                <div class="col-md-12 field_wrapper date-time">
                  <div class="">
                    <label for="inputEmail4" class="form-label">Select Date & Time</label>
                    <input class="add-input" type="datetime-local" name="field_name[]" value="" placeholder="Select Date & Time"/>
                    <a href="javascript:void(0);" class="add_button" title="Add field"><img src="assets/public-site/asset/img/add-input.svg"/></a>
                  </div>
                </div>
              </form>
            </div>
            <div class="row">
              <div class="col-md-12 booking-notes">
                <h5>Safety Notes</h5>
                <ul class="p-0">
                  <li>
                    To ensure that your payments are protected under our terms,
                    never transfer money or send messages outside of the
                    Dreamcrowd platform.
                  </li>
                  <br />
                  <li>
                    Payments made outside of our platform are not eligible for
                    disputes & refunds under our terms.
                  </li>
                  <br />
                  <li>
                    Do not provide your email address, telephone number or
                    physical address to any seller. Only provide this
                    information (if absolutely necessary) after you have made a
                    payment to the seller.
                  </li>
                  <br />
                  <li>
                    Nearby areas or landmarks nearby can be shared to give the
                    seller an idea of how far they need to travel (This applies
                    to in-person services only).
                  </li>
                  <br />
                  <li>
                    Please send us a report if a seller has broken any of these
                    safety terms or if you suspect that the seller is trying to
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="amount-sec">
      <div class="row">
        <div class="col-md-12">
          <p class="float-start">Total Amount: <span>$55.0</span></p>
          <div class="float-end">
            <a
              href="#"
              type="button"
              class="btn contact-btn"
              data-bs-toggle="modal"
              id="contact-us"
              data-bs-target="#contact-me-modal"
              >Contact Me</a
            >

            <a href="payment.html" class="btn booking-btn">Complete Booking</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- inline-person canvas -->
<div id="quick-booking">
  <div
    class="offcanvas offcanvas-end services-offcanvas"
    tabindex="-1"
    id="inline-person"
    aria-labelledby="offcanvasRightLabel"
  >
    <div class="offcanvas-header offcanvas-heading">
      <h5 id="offcanvasRightLabel">Quick Booking</h5>
    </div>
    <div class="offcanvas-body services-details">
      <div class="row">
        <div class="col-md-1">
          <div class="profile">
            <img src="assets/public-site/asset/img/personal-profile.png" alt="" />
          </div>
        </div>
        <div class="col-md-11">
          <div class="profile-det">
            <h5>Usama A.</h5>
            <p class="graphic">Graphic Designer</p>
            <p class="location">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
              >
                <path
                  d="M10.0034 6.45817C9.34035 6.45817 8.70447 6.72156 8.23563 7.1904C7.76679 7.65924 7.5034 8.29513 7.5034 8.95817C7.5034 9.62121 7.76679 10.2571 8.23563 10.7259C8.70447 11.1948 9.34035 11.4582 10.0034 11.4582C10.6664 11.4582 11.3023 11.1948 11.7712 10.7259C12.24 10.2571 12.5034 9.62121 12.5034 8.95817C12.5034 8.29513 12.24 7.65924 11.7712 7.1904C11.3023 6.72156 10.6664 6.45817 10.0034 6.45817ZM8.54506 8.95817C8.54506 8.5714 8.69871 8.20046 8.9722 7.92697C9.24569 7.65348 9.61662 7.49984 10.0034 7.49984C10.3902 7.49984 10.7611 7.65348 11.0346 7.92697C11.3081 8.20046 11.4617 8.5714 11.4617 8.95817C11.4617 9.34494 11.3081 9.71588 11.0346 9.98937C10.7611 10.2629 10.3902 10.4165 10.0034 10.4165C9.61662 10.4165 9.24569 10.2629 8.9722 9.98937C8.69871 9.71588 8.54506 9.34494 8.54506 8.95817ZM15.418 13.3332L11.2146 17.7957C11.0588 17.9611 10.8708 18.093 10.6621 18.1831C10.4535 18.2732 10.2286 18.3197 10.0013 18.3197C9.77402 18.3197 9.54914 18.2732 9.34048 18.1831C9.13182 18.093 8.9438 17.9611 8.78798 17.7957L4.58465 13.3332H4.60048L4.5934 13.3248L4.58465 13.3144C3.50577 12.0384 2.91511 10.4208 2.91798 8.74984C2.91798 4.83775 6.08923 1.6665 10.0013 1.6665C13.9134 1.6665 17.0846 4.83775 17.0846 8.74984C17.0875 10.4208 16.4969 12.0384 15.418 13.3144L15.4092 13.3248L15.4021 13.3332H15.418ZM14.6084 12.6586C15.5368 11.5681 16.0455 10.182 16.043 8.74984C16.043 5.41317 13.338 2.70817 10.0013 2.70817C6.66465 2.70817 3.95965 5.41317 3.95965 8.74984C3.95704 10.182 4.46576 11.5681 5.39423 12.6586L5.52256 12.8098L9.54631 17.0811C9.60475 17.1431 9.67525 17.1926 9.7535 17.2264C9.83175 17.2602 9.91608 17.2776 10.0013 17.2776C10.0865 17.2776 10.1709 17.2602 10.2491 17.2264C10.3274 17.1926 10.3979 17.1431 10.4563 17.0811L14.4801 12.8098L14.6084 12.6586Z"
                  fill="#7D7D7D"
                /></svg>
              >Huston, London, United Kingdom
            </p>
          </div>
        </div>
        <div class="col-md-12">
          <button class="btn view-all-profile">View Full Profile</button>
        </div>
        <div class="col-md-12">
          <div class="booking-det">
            <h5>
              Title : <span>I would help you build an amazing website</span>
            </h5>
            <h5>
              Service & Payment Type : <span class="in-person">In-Person</span
              ><span> Freelance | Group Booking | Subscription</span>
            </h5>
            <h5>Price : <span>From $10</span></h5>
            <h5>
              Delivery & Completion Date :
              <span>Within 15 days each month</span>
            </h5>
            <h5>
              Max. Travel Distance :
              <span
                >Able to travel up to 10 miles from London, United Kingdom</span
              >
            </h5>
            <h5>Description :</h5>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vitae ut
              tellus quis a euismod ut nisl, quis. Tristique bibendum morbi vel
              vitae ultrices donec accumsan. Tincidunt eget habitant
              pellentesque id purus. Hendrerit varius sapien, nunc, turpis augue
              arcu venenatis. At sed consectetur in viverra duis tincidunt diam.
              Fames diam, interdum fringilla venenatis sed mi quis. Convallis
              enim, sit pharetra fermentum pellentesque eros. Tortor cras nulla
              sit dui tincidunt platea mauris. Enim, risus non posuere venenatis
              non quis id nec. Consectetur vitae gravida ut morbi tellus arcu.
              In pretium in malesuada neque. At mauris massa magna mauris,
            </p>
            <h5>Requirements :</h5>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vitae ut
              tellus quis a euismod ut nisl, quis. Tristique bibendum morbi vel
              vitae ultrices donec accumsan. Tincidunt eget habitant
              pellentesque id purus. Hendrerit varius sapien, nunc, turpis augue
              arcu venenatis. At sed consectetur in viverra duis tincidunt diam.
            </p>
            <h5>Booking & Cancelation Details :</h5>
            <p>
              After booking a class or activity, you will be emailed
              instructions on how to attend the experience on Zoom. You can
              cancel or reschedule a booking up to 24 hours before the
              experience starts for free
            </p>
            <div class="portfolio-sec">
              <h5>Portfolio</h5>
              <div class="row">
                <div class="col-md-3">
                  <a
                    href="assets/public-site/asset/img/portfolioimg (1).png"
                    data-fancybox="gallery"
                    data-caption=""
                  >
                    <img src="assets/public-site/asset/img/portfolioimg (1).png" />
                  </a>
                </div>
                <div class="col-md-3">
                  <a
                    href="assets/public-site/asset/img/portfolioimg (2).png"
                    data-fancybox="gallery"
                    data-caption=""
                  >
                    <img src="assets/public-site/asset/img/portfolioimg (2).png" />
                  </a>
                </div>
                <div class="col-md-3">
                  <a
                    href="assets/public-site/asset/img/portfolioimg (3).png"
                    data-fancybox="gallery"
                    data-caption=""
                  >
                    <img src="assets/public-site/asset/img/portfolioimg (3).png" />
                  </a>
                </div>
                <div class="col-md-3">
                  <a
                    href="assets/public-site/asset/img/portfolioimg (4).png"
                    data-fancybox="gallery"
                    data-caption=""
                  >
                    <img src="assets/public-site/asset/img/portfolioimg (4).png" />
                  </a>
                </div>
              </div>
              <!-- row / end -->
            </div>
            <div class="portfolio-form">
              <form class="row g-3">
                <div class="col-md-4 select-group">
                  <label for="select"> Select Group Type </label><br />
                  <select id="select" type="text">
                    <option value="b">Public Group</option>
                    <option value="c">Private Group</option>
                  </select>
                </div>
                <div class="col-md-4 guest select-groups">
                  <label for="inputPassword4" class="form-label"
                    >Number of Adults</label
                  >
                  <input
                  type="number"
                  class="form-control"
                  id="inputEmail4"
                  placeholder="0"
                />
                </div>
                <div class="col-md-4 guest select-groups">
                  <label for="inputPassword4" class="form-label"
                    >Number of Children</label
                  >
                  <input
                    type="number"
                    class="form-control"
                    id="inputEmail4"
                    placeholder="0"
                  />
                </div>
                <div class="col-md-6 frequency">
                  <label for="inputEmail4" class="form-label"
                    >Select Class Frequency</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    id="inputEmail4"
                    placeholder="Select Class Frequency"
                  />
                </div>
                <div class="col-md-6 select-group pt-0">
                  <label for="select"> Are you based in sellers city </label><br />
                  <select id="select" type="text">
                    <option value="">Select Seller City</option>
                    <option value="b">Yes</option>
                    <option value="c">No</option>
                  </select>
                </div>
                <div class="col-md-12 multiple-val-input multiemail">
                  <label for="inputEmail4" class="form-label"
                    >Enter Guests Emails for Class Invitation</label
                  >
                  <br />
                  <div class="col-sm-12 email-id-row">
                    <div class="all-mail" id="all-mail-2"></div>
                    <input type="text" name="email" class="enter-mail-id emails" id="enter-mail-id-2" placeholder="Enter the email id .." />
                </div>
                </div>
                <!-- <div class="col-md-12">
                  <label for="inputEmail4" class="form-label"
                    >Are you based in sellers city</label
                  >
                  <div class="row">
                    <div class="col-md-12 check-servicess">
                      <div class="radio">
                          <label for="yes" class="service-radio-sec">
                              <input id="yes" type="radio" name="radio-input2" checked />
                              Yes
                              <span class="checkmark"></span>
                          </label>
                      </div>
                      <div class="form-group">
                          <div class="radio">
                              <label for="no" class="service-radio-sec">
                                  <input id="no" type="radio" name="radio-input2" />
                                  No
                                  <span class="checkmark"></span>
                              </label>
                          </div>
                      </div>
                  </div>
                </div>
                </div> -->
                <div class="col-md-12 frequency">
                  <label for="inputEmail4" class="form-label"
                    >Additional information</label
                  >
                  <br />
                  <textarea
                    name=""
                    id=""
                    cols="10"
                    rows="5"
                    placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book."
                  ></textarea>
                </div>
                <div class="col-md-12 field_wrapper date-time">
                  <div>
                    <label for="inputEmail4" class="form-label">Select Date & Time</label>
                    <input class="add-input" type="datetime-local" name="field_name[]" value="" placeholder="Select Date & Time"/>
                    <a href="javascript:void(0);" class="add_button" title="Add field"><img src="assets/public-site/asset/img/add-input.svg"/></a>
                  </div>
                </div>
              </form>
            </div>
            <div class="row">
              <div class="col-md-12 booking-notes">
                <h5>Safety Notes</h5>
                <ul class="p-0">
                  <li>
                    To ensure that your payments are protected under our terms,
                    never transfer money or send messages outside of the
                    Dreamcrowd platform.
                  </li>
                  <br />
                  <li>
                    Payments made outside of our platform are not eligible for
                    disputes & refunds under our terms.
                  </li>
                  <br />
                  <li>
                    Do not provide your email address, telephone number or
                    physical address to any seller. Only provide this
                    information (if absolutely necessary) after you have made a
                    payment to the seller.
                  </li>
                  <br />
                  <li>
                    Nearby areas or landmarks nearby can be shared to give the
                    seller an idea of how far they need to travel (This applies
                    to in-person services only).
                  </li>
                  <br />
                  <li>
                    Please send us a report if a seller has broken any of these
                    safety terms or if you suspect that the seller is trying to
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="amount-sec">
      <div class="row">
          <div class="col-md-12">
              <p class="float-start">Total Amount: <span>$55.0</span></p>
              <div class="float-end booking-btns">
                  <a href="#" type="button" class="btn contact-btn" data-bs-toggle="modal" id="contact-us" data-bs-target="#send-bookig">Send Booking Request</a>
                  <a href="payment.html" class="btn booking-btn" id="complete-booking">Complete Booking</a>
              </div>
          </div>
      </div>
  </div>
  </div>
</div>
<!-- online-person contact -->
<div id="contact">
  <!-- Modal -->
  <div
    class="modal fade"
    id="contact-me-modal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content contact-modal">
        <div class="modal-body p-0">
          <div class="row">
            <div class="col-md-12 name-label">
              <label for="inputEmail4" class="form-label">Name</label>
              <input
                type="email"
                class="form-control"
                id="inputEmail4"
                placeholder="Usama Aslam"
              />
            </div>
            <div class="col-md-12 check-services">
              <div class="form-group">
                <label for="exampleFormControlTextarea4">Message Details</label>
                <textarea
                  class="form-control"
                  id="exampleFormControlTextarea4"
                  cols="11"
                  rows="6"
                  placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged."
                ></textarea>
              </div>
            </div>
            <div class="col-md-12 booking-buttons">
              <button type="button" class="btn booking-cancel">Cancel</button>
              <button
                type="button"
                class="btn request-booking"
                data-bs-dismiss="modal"
              >
                Send Request
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="contact">
  <!-- Modal -->
  <div
    class="modal fade"
    id="contact-me-modal1"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content contact-modal">
        <div class="modal-body p-0">
          <div class="row">
            <div class="col-md-12 name-label">
              <label for="inputEmail4" class="form-label">Name</label>
              <input
                type="email"
                class="form-control"
                id="inputEmail4"
                placeholder="Usama Aslam"
              />
            </div>
            <div class="row">
              <div class="col-md-12 check-services">
                <h5>Service Type</h5>
                <div class="form-group">
                  <div class="radio">
                    <label for="1" class="service-radio-sec">
                      <input
                        id="1"
                        type="radio"
                        name="radio-input1"
                        checked="checked"
                      />
                      Freelance Service
                      <span class="checkmark"></span>
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <div class="radio">
                    <label for="2" class="service-radio">
                      <input id="2" type="radio" name="radio-input1" />
                      Class service
                      <span class="checkmark"></span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 check-services">
                <h5>Delivery Option</h5>
                <div class="radio">
                  <label for="3" class="service-radio-sec">
                    <input
                      id="3"
                      type="radio"
                      name="radio-input2"
                      checked="checked"
                    />
                    Online
                    <span class="checkmark"></span>
                  </label>
                </div>
                <div class="form-group">
                  <div class="radio">
                    <label for="4" class="service-radio">
                      <input id="4" type="radio" name="radio-input2" />
                      In-person
                      <span class="checkmark"></span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12 check-services">
              <div class="form-group">
                <label for="exampleFormControlTextarea4">Message Details</label>
                <textarea
                  class="form-control"
                  id="exampleFormControlTextarea4"
                  cols="11"
                  rows="6"
                  placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged."
                ></textarea>
              </div>
            </div>
            <div class="col-md-12 booking-buttons">
              <button type="button" class="btn booking-cancel">Cancel</button>
              <button
                type="button"
                class="btn request-booking"
                data-bs-dismiss="modal"
              >
                Send Request
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- in-person send booking request button modal -->
<div
  class="modal fade"
  id="send-bookig"
  tabindex="-1"
  aria-labelledby="exampleModalLabel1"
  aria-hidden="true"
>
  <div class="modal-dialog">
    <div class="modal-content contact-modal">
      <div class="modal-body p-0">
        <div class="row">
          <div class="col-md-12 name-label">
            <label for="inputEmail4" class="form-label">Name</label>
            <input
              type="text"
              class="form-control"
              id="inputEmail4"
              placeholder="Usama Aslam"
            />
          </div>
          <div class="col-md-12 name-label">
            <label for="inputEmail4" class="form-label label-sec">Email</label>
            <input
              type="email"
              class="form-control"
              id="inputEmail4"
              placeholder="usamaaslam@gmail.com"
            />
          </div>
          <div class="col-md-12 name-label">
            <label for="inputEmail4" class="form-label label-sec"
              >Country</label
            >
            <input
              type="email"
              class="form-control"
              id="inputEmail4"
              placeholder="Your Country"
            />
          </div>
          <div class="col-md-12 name-label">
            <label for="inputEmail4" class="form-label label-sec">City</label>
            <input
              type="email"
              class="form-control"
              id="inputEmail4"
              placeholder="Your City"
            />
          </div>
          <div class="col-md-12 name-label">
            <label for="inputEmail4" class="form-label label-sec"
              >Your Area</label
            >
            <input
              type="email"
              class="form-control"
              id="inputEmail4"
              placeholder="Your Area"
            />
          </div>
          <div class="col-md-12 name-label">
            <label for="inputEmail4" class="form-label label-sec"
              >Type of expert needed</label
            >
            <select name="" id="">
              <option value="">Type of expert needed</option>
              <option value="">Class</option>
              <option value="">Freelance</option>
            </select>
          </div>
          <div class="col-md-12 name-label">
            <label for="inputEmail4" class="form-label label-sec"
              >Type of service</label
            >
            <br />
            <select name="" id="">
              <option value="">Type of service</option>
              <option value="">Online Service</option>
              <option value="">In-person Service</option>
            </select>
          </div>
          <div class="col-md-12 check-services">
            <div class="form-group">
              <label for="exampleFormControlTextarea4" class="label-sec"
                >Describe the help you require</label
              >
              <textarea
                class="form-control"
                id="exampleFormControlTextarea4"
                rows="3"
                placeholder="Describe the help you require..."
              ></textarea>
            </div>
          </div>
          <div class="col-md-12 booking-buttons">
            <button
              type="button"
              class="btn booking-cancel"
              data-bs-dismiss="modal"
            >
              Cancel
            </button>
            <button type="submit" class="btn request-booking">Submit</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- All review modal start from here -->
 <!-- Modal -->
 <div class="modal fade" id="all-review-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content review-all-modal">
      
      <div class="modal-body">
        <div class="container-review">
          <div class="row">
            <div class="col-md-12">
              <div class="images">
                <img class="image" src="https://a0.muscache.com/im/pictures/airbnb-platform-assets/AirbnbPlatformAssets-GuestFavorite/original/059619e1-1751-42dd-84e4-50881483571a.png" alt="Review Image 1" decoding="async" />
                <h5 class="text-center">All Reviews</h5>
                <img class="image" src="https://a0.muscache.com/im/pictures/airbnb-platform-assets/AirbnbPlatformAssets-GuestFavorite/original/33b80859-e87e-4c86-841c-645c786ba4c1.png" alt="Review Image 2" decoding="async" />
            </div>
            </div>
            <div class="col-md-12">
              <h6 class="text-center mb-0">Guest favorite</h6>
              <p class="text-center mt-2">This home is in the top 10%  of eligible listings based on ratings, reviews, and reliability</p>
            </div>
            <div class="profile-reviews">
              <div class="profile-review-sec">
                <div class="row align-items-center pt-2">
                  <div class="col-md-1 profile-review">
                    <img src="assets/public-site/asset/img/personal-profile.png" alt="">
                  </div>
                  <div class="col-md-11 review-desc">
                    <h5>Kyne</h5>
                    <p>United States</p>
                  </div>
                </div>
                <hr class="mt-0">
                <div class="row pb-3">
                  <div class="col-md-12 profile-rating-sec d-flex align-items-center">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <p>2 months ago</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                   
    <div class="truncate">
      <p class="mb-0">Consciousness, explorations from which we spring star stuff harvesting star light shores of the cosmic ocean Apollonius of Perga permanence of the stars, Tunguska event paroxysm of global death white dwarf the carbon in our apple pies tendrils of gossamer clouds white dwarf not a sunrise but a galaxyrise. Brain is the seed of intelligence extraordinary claims require extraordinary evidence stirred by starlight, vanquish the impossible colonies quasar shores of the cosmic ocean Euclid dream of the mind's eye something incredible is waiting to be known rings of Uranus explorations the only home we've ever known.</p>
    </div>
                   
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12">
                    <div class="accordion" id="accordionExample">
                     
                      <div class="accordion-item border-0" style="box-shadow: none; color: black;" >
                        <h2 class="accordion-header" id="headingTwo">
                          <button class="accordion-button collapsed border-0" style="box-shadow: none; background: none; color: black;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Seller's Response
                          </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                          <div class="accordion-body pt-0 pb-0">
                            <p>Many many thanks  for the tip and your kind words.</p> 
                          </div>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>
              <div class="profile-review-sec mt-3">
                <div class="row align-items-center pt-2">
                  <div class="col-md-1 profile-review">
                    <img src="assets/public-site/asset/img/personal-profile.png" alt="">
                  </div>
                  <div class="col-md-11 review-desc">
                    <h5>Kyne</h5>
                    <p>United States</p>
                  </div>
                </div>
                <hr class="mt-0">
                <div class="row pb-3">
                  <div class="col-md-12 profile-rating-sec d-flex align-items-center">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <p>2 months ago</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                   
    <div class="truncate">
      <p class="mb-0">Consciousness, explorations from which we spring star stuff harvesting star light shores of the cosmic ocean Apollonius of Perga permanence of the stars, Tunguska event paroxysm of global death white dwarf the carbon in our apple pies tendrils of gossamer clouds white dwarf not a sunrise but a galaxyrise. Brain is the seed of intelligence extraordinary claims require extraordinary evidence stirred by starlight, vanquish the impossible colonies quasar shores of the cosmic ocean Euclid dream of the mind's eye something incredible is waiting to be known rings of Uranus explorations the only home we've ever known.</p>
    </div>
                   
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12">
                    <div class="accordion" id="accordionExample">
                     
                      <div class="accordion-item border-0" style="box-shadow: none; color: black;" >
                        <h2 class="accordion-header" id="headingTwo">
                          <button class="accordion-button collapsed border-0" style="box-shadow: none; background: none; color: black;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Seller's Response
                          </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                          <div class="accordion-body pt-0 pb-0">
                            <p>Many many thanks  for the tip and your kind words.</p> 
                          </div>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>
              <div class="profile-review-sec mt-3">
                <div class="row align-items-center pt-2">
                  <div class="col-md-1 profile-review">
                    <img src="assets/public-site/asset/img/personal-profile.png" alt="">
                  </div>
                  <div class="col-md-11 review-desc">
                    <h5>Kyne</h5>
                    <p>United States</p>
                  </div>
                </div>
                <hr class="mt-0">
                <div class="row pb-3">
                  <div class="col-md-12 profile-rating-sec d-flex align-items-center">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <p>2 months ago</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                   
    <div class="truncate">
      <p class="mb-0">Consciousness, explorations from which we spring star stuff harvesting star light shores of the cosmic ocean Apollonius of Perga permanence of the stars, Tunguska event paroxysm of global death white dwarf the carbon in our apple pies tendrils of gossamer clouds white dwarf not a sunrise but a galaxyrise. Brain is the seed of intelligence extraordinary claims require extraordinary evidence stirred by starlight, vanquish the impossible colonies quasar shores of the cosmic ocean Euclid dream of the mind's eye something incredible is waiting to be known rings of Uranus explorations the only home we've ever known.</p>
    </div>
                   
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12">
                    <div class="accordion" id="accordionExample">
                     
                      <div class="accordion-item border-0" style="box-shadow: none; color: black;" >
                        <h2 class="accordion-header" id="headingTwo">
                          <button class="accordion-button collapsed border-0" style="box-shadow: none; background: none; color: black;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Seller's Response
                          </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                          <div class="accordion-body pt-0 pb-0">
                            <p>Many many thanks  for the tip and your kind words.</p> 
                          </div>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>
              <div class="profile-review-sec mt-3">
                <div class="row align-items-center pt-2">
                  <div class="col-md-1 profile-review">
                    <img src="assets/public-site/asset/img/personal-profile.png" alt="">
                  </div>
                  <div class="col-md-11 review-desc">
                    <h5>Kyne</h5>
                    <p>United States</p>
                  </div>
                </div>
                <hr class="mt-0">
                <div class="row pb-3">
                  <div class="col-md-12 profile-rating-sec d-flex align-items-center">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <p>2 months ago</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                   
    <div class="truncate">
      <p class="mb-0">Consciousness, explorations from which we spring star stuff harvesting star light shores of the cosmic ocean Apollonius of Perga permanence of the stars, Tunguska event paroxysm of global death white dwarf the carbon in our apple pies tendrils of gossamer clouds white dwarf not a sunrise but a galaxyrise. Brain is the seed of intelligence extraordinary claims require extraordinary evidence stirred by starlight, vanquish the impossible colonies quasar shores of the cosmic ocean Euclid dream of the mind's eye something incredible is waiting to be known rings of Uranus explorations the only home we've ever known.</p>
    </div>
                   
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12">
                    <div class="accordion" id="accordionExample">
                     
                      <div class="accordion-item border-0" style="box-shadow: none; color: black;" >
                        <h2 class="accordion-header" id="headingTwo">
                          <button class="accordion-button collapsed border-0" style="box-shadow: none; background: none; color: black;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Seller's Response
                          </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                          <div class="accordion-body pt-0 pb-0">
                            <p>Many many thanks  for the tip and your kind words.</p> 
                          </div>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>
              <div class="profile-review-sec mt-3">
                <div class="row align-items-center pt-2">
                  <div class="col-md-1 profile-review">
                    <img src="assets/public-site/asset/img/personal-profile.png" alt="">
                  </div>
                  <div class="col-md-11 review-desc">
                    <h5>Kyne</h5>
                    <p>United States</p>
                  </div>
                </div>
                <hr class="mt-0">
                <div class="row pb-3">
                  <div class="col-md-12 profile-rating-sec d-flex align-items-center">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <p>2 months ago</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                   
    <div class="truncate">
      <p class="mb-0">Consciousness, explorations from which we spring star stuff harvesting star light shores of the cosmic ocean Apollonius of Perga permanence of the stars, Tunguska event paroxysm of global death white dwarf the carbon in our apple pies tendrils of gossamer clouds white dwarf not a sunrise but a galaxyrise. Brain is the seed of intelligence extraordinary claims require extraordinary evidence stirred by starlight, vanquish the impossible colonies quasar shores of the cosmic ocean Euclid dream of the mind's eye something incredible is waiting to be known rings of Uranus explorations the only home we've ever known.</p>
    </div>
                   
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12">
                    <div class="accordion" id="accordionExample">
                     
                      <div class="accordion-item border-0" style="box-shadow: none; color: black;" >
                        <h2 class="accordion-header" id="headingTwo">
                          <button class="accordion-button collapsed border-0" style="box-shadow: none; background: none; color: black;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Seller's Response
                          </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                          <div class="accordion-body pt-0 pb-0">
                            <p>Many many thanks  for the tip and your kind words.</p> 
                          </div>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>
              <div class="profile-review-sec mt-3">
                <div class="row align-items-center pt-2">
                  <div class="col-md-1 profile-review">
                    <img src="assets/public-site/asset/img/personal-profile.png" alt="">
                  </div>
                  <div class="col-md-11 review-desc">
                    <h5>Kyne</h5>
                    <p>United States</p>
                  </div>
                </div>
                <hr class="mt-0">
                <div class="row pb-3">
                  <div class="col-md-12 profile-rating-sec d-flex align-items-center">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <p>2 months ago</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                   
    <div class="truncate">
      <p class="mb-0">Consciousness, explorations from which we spring star stuff harvesting star light shores of the cosmic ocean Apollonius of Perga permanence of the stars, Tunguska event paroxysm of global death white dwarf the carbon in our apple pies tendrils of gossamer clouds white dwarf not a sunrise but a galaxyrise. Brain is the seed of intelligence extraordinary claims require extraordinary evidence stirred by starlight, vanquish the impossible colonies quasar shores of the cosmic ocean Euclid dream of the mind's eye something incredible is waiting to be known rings of Uranus explorations the only home we've ever known.</p>
    </div>
                   
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12">
                    <div class="accordion" id="accordionExample">
                     
                      <div class="accordion-item border-0" style="box-shadow: none; color: black;" >
                        <h2 class="accordion-header" id="headingTwo">
                          <button class="accordion-button collapsed border-0" style="box-shadow: none; background: none; color: black;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Seller's Response
                          </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                          <div class="accordion-body pt-0 pb-0">
                            <p>Many many thanks  for the tip and your kind words.</p> 
                          </div>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>
              <div class="profile-review-sec mt-3">
                <div class="row align-items-center pt-2">
                  <div class="col-md-1 profile-review">
                    <img src="assets/public-site/asset/img/personal-profile.png" alt="">
                  </div>
                  <div class="col-md-11 review-desc">
                    <h5>Kyne</h5>
                    <p>United States</p>
                  </div>
                </div>
                <hr class="mt-0">
                <div class="row pb-3">
                  <div class="col-md-12 profile-rating-sec d-flex align-items-center">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <p>2 months ago</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                   
    <div class="truncate">
      <p class="mb-0">Consciousness, explorations from which we spring star stuff harvesting star light shores of the cosmic ocean Apollonius of Perga permanence of the stars, Tunguska event paroxysm of global death white dwarf the carbon in our apple pies tendrils of gossamer clouds white dwarf not a sunrise but a galaxyrise. Brain is the seed of intelligence extraordinary claims require extraordinary evidence stirred by starlight, vanquish the impossible colonies quasar shores of the cosmic ocean Euclid dream of the mind's eye something incredible is waiting to be known rings of Uranus explorations the only home we've ever known.</p>
    </div>
                   
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12">
                    <div class="accordion" id="accordionExample">
                     
                      <div class="accordion-item border-0" style="box-shadow: none; color: black;" >
                        <h2 class="accordion-header" id="headingTwo">
                          <button class="accordion-button collapsed border-0" style="box-shadow: none; background: none; color: black;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Seller's Response
                          </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                          <div class="accordion-body pt-0 pb-0">
                            <p>Many many thanks  for the tip and your kind words.</p> 
                          </div>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>
              <div class="profile-review-sec mt-3">
                <div class="row align-items-center pt-2">
                  <div class="col-md-1 profile-review">
                    <img src="assets/public-site/asset/img/personal-profile.png" alt="">
                  </div>
                  <div class="col-md-11 review-desc">
                    <h5>Kyne heloo</h5>
                    <p>United States</p>
                  </div>
                </div>
                <hr class="mt-0">
                <div class="row pb-3">
                  <div class="col-md-12 profile-rating-sec d-flex align-items-center">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <p>2 months ago</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                   
    <div class="truncate">
      <p class="mb-0">Consciousness, explorations from which we spring star stuff harvesting star light shores of the cosmic ocean Apollonius of Perga permanence of the stars, Tunguska event paroxysm of global death white dwarf the carbon in our apple pies tendrils of gossamer clouds white dwarf not a sunrise but a galaxyrise. Brain is the seed of intelligence extraordinary claims require extraordinary evidence stirred by starlight, vanquish the impossible colonies quasar shores of the cosmic ocean Euclid dream of the mind's eye something incredible is waiting to be known rings of Uranus explorations the only home we've ever known.</p>
    </div>
                   
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12">
                    <div class="accordion" id="accordionExample">
                     
                      <div class="accordion-item border-0" style="box-shadow: none; color: black;" >
                        <h2 class="accordion-header" id="headingTwo">
                          <button class="accordion-button collapsed border-0" style="box-shadow: none; background: none; color: black;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Seller's Response
                          </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                          <div class="accordion-body pt-0 pb-0">
                            <p>Many many thanks  for the tip and your kind words.</p> 
                          </div>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>
              <div class="profile-review-sec mt-3">
                <div class="row align-items-center pt-2">
                  <div class="col-md-1 profile-review">
                    <img src="assets/public-site/asset/img/personal-profile.png" alt="">
                  </div>
                  <div class="col-md-11 review-desc">
                    <h5>Kyne</h5>
                    <p>United States</p>
                  </div>
                </div>
                <hr class="mt-0">
                <div class="row pb-3">
                  <div class="col-md-12 profile-rating-sec d-flex align-items-center">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <p>2 months ago</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                   
    <div class="truncate">
      <p class="mb-0">Consciousness, explorations from which we spring star stuff harvesting star light shores of the cosmic ocean Apollonius of Perga permanence of the stars, Tunguska event paroxysm of global death white dwarf the carbon in our apple pies tendrils of gossamer clouds white dwarf not a sunrise but a galaxyrise. Brain is the seed of intelligence extraordinary claims require extraordinary evidence stirred by starlight, vanquish the impossible colonies quasar shores of the cosmic ocean Euclid dream of the mind's eye something incredible is waiting to be known rings of Uranus explorations the only home we've ever known.</p>
    </div>
                   
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12">
                    <div class="accordion" id="accordionExample">
                     
                      <div class="accordion-item border-0" style="box-shadow: none; color: black;" >
                        <h2 class="accordion-header" id="headingTwo">
                          <button class="accordion-button collapsed border-0" style="box-shadow: none; background: none; color: black;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Seller's Response
                          </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                          <div class="accordion-body pt-0 pb-0">
                            <p>Many many thanks  for the tip and your kind words.</p> 
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
     
    </div>
  </div>
</div>
<!-- All review modal ended here -->

<!-- Emoji SelectorCDNS -->
 <script src="assets/emoji/js/config.min.js"></script>
 <script src="assets/emoji/js/emoji-picker.min.js"></script>
 <script src="assets/emoji/js/jquery.emojiarea.min.js"></script>
 <script src="assets/emoji/js/util.min.js"></script>
 <script>
  $(function() {
  // Initializes and creates emoji set from sprite sheet
  window.emojiPicker = new EmojiPicker({
    emojiable_selector: '[data-emojiable=true]',
    assetsPath: 'assets/emoji/img', 
  }); 
  window.emojiPicker.discover();
});

$('#emoji-button').on('click', function () { 
  
  $('.emoji-menu').css('display', 'block');
});

 </script>

<!-- Message File Upload Script === -->
<script>
    function uploadImage() {
  document.getElementById('imgInput').click();
}
document.getElementById('imgInput').addEventListener('change', function() {
  var file = this.files[0];
  if (file) {
    console.log('Selected image:', file);
    // Yahan par image upload ka logic implement karein
  } else {
    console.log('No image selected.');
  }
});
  </script>

@if(Auth::user())
  <!-- ======= Script for Send Sms by Ajax Start ====== -->
   <script>
    function SendSMS() {  
       var sms = $('#message-textarea').val(); // Get the value of the textarea

      // Check if the textarea is empty or null
      if (!sms || sms.trim() === '') {
          alert('Please enter a message before sending.'); // Show a warning message
          return; // Exit the function
      }

      var sender_id = {{Auth::user()->id}} ;
      var reciver_id = {{$profile->user_id}} ;
      var sender_role = {{Auth::user()->role}} ;
      var reciver_role = 1 ;
      var type = 0 ;
 

      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "POST",
                url: '/send-sms-single',
                data:{ sender_id:sender_id,reciver_id:reciver_id,sms:sms,sender_role:sender_role,reciver_role:reciver_role,type:type, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {
                   
                  
                  if (response.error) {
                    toastr.options =
                  {
                      "closeButton" : true,
                       "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                  }
                    toastr.error(response.error);
                  } else {
                    $('.emoji-wysiwyg-editor').empty(); 
                    $('#message-textarea').val('');
                    $('#contact-me-modal').modal('hide');
                    toastr.options =
                  {
                      "closeButton" : true,
                       "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                  }
                    toastr.success(response.success);
                  }
                },
              
            });

      
      


    }


   </script>
  <!-- ======= Script for Send Sms by Ajax END ====== -->
@endif

<!-- {{-- Records Chnage By Ajax Script Start ==== --}} -->
<script>

  function FreelanceType(Clicked) { 
    var freelance_type = $("#"+Clicked).val();
    var role = $('#'+Clicked).data('role');
    var record_show = $('#'+Clicked).data('tab');
    var id = $('#profile_id').val();
    
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "GET",
                url: '/get-profile-services',
                data:{ id:id, freelance_type:freelance_type,role:role, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {
                  ShowServicesRecord(response,record_show);
                  
                },
              
            });

   }

  function LessonType(Clicked) { 
    var lesson_type = $("#"+Clicked).val();
    var role = $('#'+Clicked).data('role');
    var record_show = $('#'+Clicked).data('tab');
    var id = $('#profile_id').val();
    
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "GET",
                url: '/get-profile-services',
                data:{ id:id, lesson_type:lesson_type,role:role, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {
                  ShowServicesRecord(response,record_show);
                  
                },
              
            });

   }

  function PaymentType(Clicked) {  
    var payment_type = $('#'+Clicked).data('value');
    var role = $('#'+Clicked).data('role');
    var record_show = $('#'+Clicked).data('tab');
    var id = $('#profile_id').val();
    
    
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "GET",
                url: '/get-profile-services',
                data:{ id:id, payment_type:payment_type,role:role, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {
                  
                  ShowServicesRecord(response,record_show);
                },
              
            });

   }

  function KeywordWrite(Clicked) { 
    var keyword = $("#"+Clicked).val();
    var role = $('#'+Clicked).data('role');
    var record_show = $('#'+Clicked).data('tab');
    var id = $('#profile_id').val();
    
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "GET",
                url: '/get-profile-services',
                data:{ id:id, keyword:keyword,role:role, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {
                  ShowServicesRecord(response,record_show);
                  
                },
              
            });

   }


  function ServiceType(Clicked) { 
    var type = $("#"+Clicked).val();
    var role = $('#'+Clicked).data('role');
    var record_show = $('#'+Clicked).data('tab');
    var id = $('#profile_id').val();
    
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "GET",
                url: '/get-profile-services',
                data:{ id:id, type:type,role:role, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {
                  ShowServicesRecord(response,record_show);
                  
                },
              
            });
     
   }


  function ServiceType2(Clicked) {  
    var type = $('#'+Clicked).data('value');
    var role = $('#'+Clicked).data('role');
    var record_show = $('#'+Clicked).data('tab');
    var id = $('#profile_id').val();
    
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "GET",
                url: '/get-profile-services',
                data:{ id:id, type:type,role:role, _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {
                  ShowServicesRecord(response,record_show);
                  
                },
              
            });
     
   }

   function ShowServicesRecord(response,record_show) { 

     
     var len = 0;
     $('#'+record_show).empty(); 
          if(response['gigs'] != null){
             len = response['gigs'].length;
          }
  if (len > 0 ) {
    for (let i = 0; i < len; i++) {
      var content_div = '';
      var id = response['gigs'][i].id;
      var role = response['gigs'][i].service_role;
      var type = response['gigs'][i].service_type;
      var class_type = response['gigs'][i].class_type;
      var title = response['gigs'][i].title;
      var rate = response['gigs'][i].rate;

        if (role == 'Class') {
          if (class_type == 'Recorded') {
            content_div += '<a href="/course-service/'+id+'" class="col-12 heading view-btn view"  id="views">';
          } else {
            content_div += '<a href="/quick-booking/'+id+'" class="col-12 heading view-btn view"  id="views">' ;
           }
          } else {
          content_div += '<a href="/quick-booking/'+id+'" class="col-12 heading view-btn view"  id="views">' ;
        }
       content_div += '   <h1>'+title+'</h1>  <p>Duration: 1 Day</p> <h2>Starting at $'+rate+'</h2> </a> <hr />';




$("#"+record_show).append(content_div);
    }



  }else{
    var content_div = '<div class="col-12 heading view-btn view" type="button" id="views"> <h1>Not Found Any Service</h1>  </div>  <hr />';
    $("#"+record_show).append(content_div);
  }

    }
</script>
{{-- Records Chnage By Ajax Script END ==== --}}

<script>
  // Base URL to share (you can dynamically generate this in Laravel if needed)
  const baseUrl = window.location.href;
  
  // Share on Facebook
  document.getElementById('facebookShare').href = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(baseUrl)}`;
  
  // Share on LinkedIn
  document.getElementById('linkedinShare').href = `https://www.linkedin.com/shareArticle?mini=true&url=${encodeURIComponent(baseUrl)}`;
  
  // Share on Twitter
  document.getElementById('twitterShare').href = `https://twitter.com/intent/tweet?url=${encodeURIComponent(baseUrl)}&text=Check%20this%20out!`;
  
  // Share on WhatsApp
  document.getElementById('whatsappShare').href = `https://api.whatsapp.com/send?text=${encodeURIComponent(baseUrl)}`;
  
  // Copy Link functionality
  document.getElementById('copyLink').addEventListener('click', function() {
      navigator.clipboard.writeText(baseUrl).then(() => {
          alert("Profile link copied to clipboard!");
      }).catch(err => {
          console.log('Something went wrong', err);
      });
  });
  </script>
 
{{-- Bottom Listing Set On Change Service Type Script Start ====== --}}
<script>
function getServicesListing(Clicked) {  
   var service_role = $('#' + Clicked).val(); // Get the selected service role
    var teacher_id = '<?php echo $profile->id ?>' ;
   // Set type based on clicked element
 
    
   if (Clicked == 'div_carousel') {
    var type = 'recent' ;
  } else {
     var type = 'list' ; 
   } 
   

   $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });

   $.ajax({
      type: "GET",
      url: '/portfolio-gigs-get',
      data: { 
          service_role: service_role,
          type: type, 
          teacher_id: teacher_id, 
          _token: '{{csrf_token()}}' 
      },
      dataType: 'json',
      success: function(response) {
          ShowGigs(response, Clicked); // Call the function to display gigs
      },
      error: function(error) {
          console.log("Error fetching services:", error);
      }
   });
}



function ShowGigs(response, Clicked) { 
  
    var divId = Clicked.split('_')[1];  // Parse the clicked element to get the target div
    $('#' + divId).empty();  // Clear the div

    var len = response['services'].length;
    var content_div = ``;
    var isLoggedIn = response['logged_in']; // Check if the user is logged in
  
  
    if (len > 0) {
        content_div += `<div class="owl-stage-outer owl-height" style="height: 429px;">
                            <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all; width: 712px;">`;

        for (let i = 0; i < len; i++) {
         
          
            var service = response['services'][i];
            var wishlistIcon = ''; // Default to no icon

            // Show the wishlist icon only if the user is logged in
            if (isLoggedIn) {
                wishlistIcon = wishListButton(service.id, service.is_wishlisted); // Check wishlist status
            }

            // Dynamically create the HTML for each service
            content_div += `
              <div class="owl-item active" style="width: 335.73px; margin-right: 20px;" >
                <div class="item">
                    <div class="main-Dream-card">
                        <div class="card dream-Card">
                            <div class="dream-card-upper-section">
                                <div style="height: 180px;">
                                    <img src="assets/teacher/listing/data_${service.user_id}/media/${service.main_file}" alt="" style="height: 100%;">
                                </div>
                                <div class="card-img-overlay overlay-inner">
                                    <p>Top Seller</p>
                                    ${wishlistIcon} <!-- Wishlist button HTML -->
                                </div>
                            </div>
                            <a href="#" style="text-decoration: none;">
                                <div class="dream-card-dawon-section" type="button" data-bs-toggle="offcanvas" aria-controls="offcanvasRight">
                                    <div class="dream-Card-inner-profile">
                                        ${getUserProfileImage(service)}
                                        <i class="fa-solid fa-check tick"></i>
                                    </div>
                                    <p class="servise-bener">${service.service_type} Services</p>
                                    <h5 class="dream-Card-name">${service.first_name} ${service.last_name.charAt(0)}.</h5>
                                    <p class="Dev">${service.profession}</p>
                                    <p class="about-teaching">
                                        <a class="about-teaching" href="${getServiceUrl(service)}" style="text-decoration: none;">${service.title}</a>
                                    </p>
                                    <span class="card-rat">
                                        <i class="fa-solid fa-star"></i> &nbsp; (5.0)
                                    </span>
                                    <div class="card-last">
                                        <span>Starting at $${service.rate}</span>
                                        <img data-toggle="tooltip" title="${getServiceTypeTooltip(service.service_type)}" src="${getServiceTypeIcon(service.service_type)}" style="height: 25px; width: 25px;" alt="">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
              </div>`;
               
        }

        content_div += `</div></div>`;
        $('#' + divId).append(content_div);
    } else {
        $('#' + divId).append('<p>No services found.</p>');
    }
}

// Modify wishListButton function to accept if the gig is already wishlisted
function wishListButton(gigId, isWishlisted) {
    if (isWishlisted) {
        return `<span id="heart_${gigId}" class="liked" onclick="AddWishList(this.id);" data-gig_id="${gigId}">
                    <i class="fa fa-heart" aria-hidden="true"></i>
                </span>`;
    } else {
        return `<span id="heart_${gigId}" onclick="AddWishList(this.id);" data-gig_id="${gigId}">
                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                </span>`;
    }
}


function getUserProfileImage(service) {
    if (service.profile_image === null) {
        var firstLetter = service.first_name.charAt(0).toUpperCase();
        return `<img src="assets/profile/avatars/(${firstLetter}).jpg" alt="" style="width: 60px;height: 60px; border-radius: 100%; border: 5px solid white;">`;
    } else {
        return `<img src="assets/profile/img/${service.profile_image}" alt="" style="width: 60px;height: 60px; border-radius: 100%;border: 5px solid white;">`;
    }
}

function getServiceUrl(service) {
    if (service.service_role === 'Class' && service.class_type === 'Recorded') {
        return `/course-service/${service.id}`;
    } else {
        return `/quick-booking/${service.id}`;
    }
}

function getServiceTypeIcon(serviceType) {
    if (serviceType === 'Online') {
        return 'assets/seller-listing/asset/img/globe.png';
    } else {
        return 'assets/seller-listing/asset/img/handshake.png';
    }
}

function getServiceTypeTooltip(serviceType) {
    if (serviceType === 'Online') {
        return 'Online Service';
    } else {
        return 'In Person-Service';
    }
}


</script>
{{-- Bottom Listing Set On Change Service Type Script END ====== --}}


    {{-- Add to Wish List Set Script Start ==== --}}
    <script>
      function AddWishList(Clicked) { 
        var gig_id = $('#'+Clicked).data('gig_id');
        var type = $('#'+Clicked).data('type');
         console.log(type);
         
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: "POST",
                url: '/add-service-to-wishlist',
                data:{ gig_id:gig_id,  type:type,_token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {
                    if (response.success) {

                      $('#'+Clicked).addClass('liked');
                      $('#'+Clicked).html('<i class="fa fa-heart" aria-hidden="true"></i>');


                      toastr.options =
                        {
                            "closeButton" : true,
                             "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                        }
                  toastr.success(response.success);
                    } else if(response.info){

                      $('#'+Clicked).removeClass('liked');
                      $('#'+Clicked).html('<i class="fa fa-heart-o" aria-hidden="true"></i>');

                      toastr.options =
                        {
                            "closeButton" : true,
                             "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                        }
                  toastr.info(response.info);
                    }  else {
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
    </script>
    {{-- Add to Wish List Set Script END ==== --}}












<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <script>
              config = {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
            }
                            flatpickr("input[type=datetime-local]", config);
            </script>
         
<!-- offcanvas js start  -->

<!-- offcanvas js end  -->
<!-- increase and decrease quantity js start from here -->

<!-- <script>
  var buttonPlus = $(".qty-btn-plus");
  var buttonMinus = $(".qty-btn-minus");

  var incrementPlus = buttonPlus.click(function () {
    var $n = $(this).parent(".qty-container").find(".input-qty");
    $n.val(Number($n.val()) + 1);
  });

  var incrementMinus = buttonMinus.click(function () {
    var $n = $(this).parent(".qty-container").find(".input-qty");
    var amount = Number($n.val());
    if (amount > 0) {
      $n.val(amount - 1);
    }
  });
</script> -->
<!-- radio buttons hide and show js -->
<!-- <script>
  document.addEventListener("DOMContentLoaded", function() {
      var yesRadio = document.getElementById("yes");
      var noRadio = document.getElementById("no");
      var completeBookingBtn = document.getElementById("complete-booking");

      // Initially show the button since "Yes" is selected by default
      completeBookingBtn.style.display = "block";

      // Add event listener to the "Yes" radio button
      yesRadio.addEventListener("change", function() {
          completeBookingBtn.style.display = "block";
      });

      // Add event listener to the "No" radio button
      noRadio.addEventListener("change", function() {
          completeBookingBtn.style.display = "none";
      });
  });
</script> -->
<!-- modal hide and show jquery -->
<!-- <script>
  $(document).ready(function () {
    $(document).on("click", "#views", function (e) {
      e.preventDefault();
      $("#quick-booking").modal("show");
      $("#contact").modal("hide");
    });

    $(document).on("click", "#contact-us", function (e) {
      e.preventDefault();
      $("#contact").modal("show");
      $("#quick-booking").modal("hide");
    });
  });
</script> -->
<!-- Hidden Input Field -->

<script>
  $(document).ready(function () {
    var maxField = 10; //Input fields increment limitation
    var fieldHTML = '<div><input class="add-input" type="datetime-local" name="field_name[]" value="" placeholder="Select Date & Time"/><a href="javascript:void(0);" class="remove_button" title="Remove field"><img src="assets/public-site/asset/img/remove-icon.svg"/></a></div>'; //New input field html

    // Once add button is clicked
    $(".add_button").click(function () {
      var wrapper = $(this).closest(".field_wrapper");
      var x = wrapper.find(".add-input").length; // Get the count of input fields in this wrapper

      //Check maximum number of input fields
      if (x < maxField) {
        wrapper.append(fieldHTML); //Add field html
      } else {
        alert("A maximum of " + maxField + " fields are allowed to be added. ");
      }
    });

    // Once remove button is clicked
    $(document).on("click", ".remove_button", function (e) {
      e.preventDefault();
      $(this).parent("div").remove(); //Remove field html
    });
  });
</script>

<!-- multiple select emails -->
<script>
  $(".enter-mail-id").keydown(function (e) {
      if ( e.keyCode == 32 || e.keyCode == 13) {
          var inputText = $(this).val().trim(); // Get the input text
          var emails = inputText.split(/\s+/); // Split input text by whitespace
          var containerId = $(this).attr('id').replace('enter-mail-id-', 'all-mail-');

          // Iterate over each email
          emails.forEach(function(email) {
              // Trim whitespace from each email
              var trimmedEmail = email.trim();
              if (trimmedEmail !== '') { // Check if email is not empty
                  $('#' + containerId).append('<span class="email-ids">' + trimmedEmail + ' <span class="cancel-email">x</span></span>');
              }
          });

          $(this).val(''); // Clear the input field
      }
  });

  $(document).on('click', '.cancel-email', function () {
      $(this).parent().remove();
  });
</script>
<!-- ended -->
<script>
  // 1
  $(document).ready(function () {
    $("#heart").click(function () {
      if ($("#heart").hasClass("liked")) {
        $("#heart").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
        $("#heart").removeClass("liked");
      } else {
        $("#heart").html('<i class="fa fa-heart" aria-hidden="true"></i>');
        $("#heart").addClass("liked");
      }
    });
  });
  // 2
  $(document).ready(function () {
    $("#heart1").click(function () {
      if ($("#heart1").hasClass("liked")) {
        $("#heart1").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
        $("#heart1").removeClass("liked");
      } else {
        $("#heart1").html('<i class="fa fa-heart" aria-hidden="true"></i>');
        $("#heart1").addClass("liked");
      }
    });
  });
  // 3
  $(document).ready(function () {
    $("#heart2").click(function () {
      if ($("#heart2").hasClass("liked")) {
        $("#heart2").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
        $("#heart2").removeClass("liked");
      } else {
        $("#heart2").html('<i class="fa fa-heart" aria-hidden="true"></i>');
        $("#heart2").addClass("liked");
      }
    });
  });
  // 4
  $(document).ready(function () {
    $("#heart3").click(function () {
      if ($("#heart3").hasClass("liked")) {
        $("#heart3").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
        $("#heart3").removeClass("liked");
      } else {
        $("#heart3").html('<i class="fa fa-heart" aria-hidden="true"></i>');
        $("#heart3").addClass("liked");
      }
    });
  });
  // 5
  $(document).ready(function () {
    $("#heart4").click(function () {
      if ($("#heart4").hasClass("liked")) {
        $("#heart4").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
        $("#heart4").removeClass("liked");
      } else {
        $("#heart4").html('<i class="fa fa-heart" aria-hidden="true"></i>');
        $("#heart4").addClass("liked");
      }
    });
  });
  // 6
  $(document).ready(function () {
    $("#heart5").click(function () {
      if ($("#heart5").hasClass("liked")) {
        $("#heart5").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
        $("#heart5").removeClass("liked");
      } else {
        $("#heart5").html('<i class="fa fa-heart" aria-hidden="true"></i>');
        $("#heart5").addClass("liked");
      }
    });
  });
  // 7
  $(document).ready(function () {
    $("#heart6").click(function () {
      if ($("#heart6").hasClass("liked")) {
        $("#heart6").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
        $("#heart6").removeClass("liked");
      } else {
        $("#heart6").html('<i class="fa fa-heart" aria-hidden="true"></i>');
        $("#heart6").addClass("liked");
      }
    });
  });
  // 8
  $(document).ready(function () {
    $("#heart7").click(function () {
      if ($("#heart7").hasClass("liked")) {
        $("#heart7").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
        $("#heart7").removeClass("liked");
      } else {
        $("#heart7").html('<i class="fa fa-heart" aria-hidden="true"></i>');
        $("#heart7").addClass("liked");
      }
    });
  });
  // 9
  $(document).ready(function () {
    $("#heart8").click(function () {
      if ($("#heart8").hasClass("liked")) {
        $("#heart8").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
        $("#heart8").removeClass("liked");
      } else {
        $("#heart8").html('<i class="fa fa-heart" aria-hidden="true"></i>');
        $("#heart8").addClass("liked");
      }
    });
  });
  // 10
  $(document).ready(function () {
    $("#heart9").click(function () {
      if ($("#heart9").hasClass("liked")) {
        $("#heart9").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
        $("#heart9").removeClass("liked");
      } else {
        $("#heart9").html('<i class="fa fa-heart" aria-hidden="true"></i>');
        $("#heart9").addClass("liked");
      }
    });
  });
  // 11
  $(document).ready(function () {
    $("#heart10").click(function () {
      if ($("#heart10").hasClass("liked")) {
        $("#heart10").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
        $("#heart10").removeClass("liked");
      } else {
        $("#heart10").html('<i class="fa fa-heart" aria-hidden="true"></i>');
        $("#heart10").addClass("liked");
      }
    });
  });
  // 12
  $(document).ready(function () {
    $("#heart11").click(function () {
      if ($("#heart11").hasClass("liked")) {
        $("#heart11").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
        $("#heart11").removeClass("liked");
      } else {
        $("#heart11").html('<i class="fa fa-heart" aria-hidden="true"></i>');
        $("#heart11").addClass("liked");
      }
    });
  });
</script>
<!--=========== FAQ CSS ==============-->
<script>
  $(document).ready(function () {
    $(".accordion-list > li > .answer").hide();

    $(".accordion-list > li").click(function () {
      if ($(this).hasClass("active")) {
        $(this).removeClass("active").find(".answer").slideUp();
      } else {
        $(".accordion-list > li.active .answer").slideUp();
        $(".accordion-list > li.active").removeClass("active");
        $(this).addClass("active").find(".answer").slideDown();
      }
      return false;
    });
  });
</script>
<!--=========== FAQ CSS ==============-->

