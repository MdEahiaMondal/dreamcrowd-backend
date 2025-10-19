
 

<!DOCTYPE html>
<html lang="en">
  <head>

    <base href="/public">
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <!-- View Point scale to 1.0 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Animate css -->
    <link rel="stylesheet" href="assets/public-site/libs/animate/css/animate.css" />
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="assets/public-site/libs/aos/css/aos.css" />
    <!-- Datatable css  -->
    <link rel="stylesheet" href="assets/public-site/libs/datatable/css/datatable.css" />
    <!-- Select2 css -->
    <link href="assets/public-site/libs/select2/css/select2.min.css" rel="stylesheet" />
       <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    
  {{-- =======Toastr CDN ======== --}}
 <link rel="stylesheet" type="text/css" 
 href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
 {{-- =======Toastr CDN ======== --}}
 {{-- =====Appointment-Calender CDN===== --}}
 <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
 <link rel="stylesheet" type="text/css" href="assets/calender/css/mark-your-calendar.css">
 {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"> --}}
 
 {{-- =====Appointment-Calender CDN===== --}}
    <!-- Owl carousel css -->
    <link href="assets/public-site/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
    <link href="assets/public-site/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
    <!-- Bootstrap css -->
    {{-- Fav Icon --}}
    @php  $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
    @endif
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

     <!-- datetime picker css --> 
 <link rel="stylesheet" href="assets/seller-listing-new/asset/jquery.datetimepicker.min.css">

 <!-- Include jQuery and DateTimePicker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-datetimepicker@2.5.21/jquery.datetimepicker.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-datetimepicker@2.5.21/jquery.datetimepicker.full.min.js"></script>

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

 <!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


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
    <link rel="stylesheet" href="assets/public-site/asset/css/services.css" />
    <link rel="stylesheet" href="assets/public-site/asset/css/Drop.css" />
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


body{
  background: #FFFFFF !important;
}

#picker a{
text-decoration: none;

}
#picker a:hover{
  color: white;
}
;
 
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

    }

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

#nearme_dropdown li:hover {
     background-color: var(--Colors-Dashboard-Background, #f4fbff);
     color: var(--Colors-Logo-Color, #0072b1);
     border: 1px solid rgb(210 229 240);
     border-radius: 15px;
     font-size: 15px;

}

.class_datetime:hover{
  cursor: pointer;
}
</style>
  <body style="background-color: #FFFFFF !important;">
    <!-- =========================================== NAVBAR START HERE ================================================= -->
      <!-- =========================================== NAVBAR START HERE ================================================= -->
      <x-public-nav/>

      <!-- ============================================= NAVBAR END HERE ============================================ -->
    <!-- ============================================= NAVBAR END HERE ============================================ -->
   <!-- profile section start from here -->
   <div class="container profile-container">
    <div class="row">
    <div class="profile-content-sec"
    id="online-person">
      <div class="col-md-3 column-1">
        <div class="sticky-contents">
          <div class="card profile-card" style="width: 100%;">


            @if ($profile->profile_image == null)
            @php  $firstLetter = strtoupper(substr($profile->first_name, 0, 1));  @endphp
           <img src="assets/profile/avatars/({{$firstLetter}}).jpg" class="card-img-top-profile"> 
             @else
             
              <img src="assets/profile/img/{{$profile->profile_image}}" class="card-img-top-profile"> 
              @endif

            <div class="card-body p-0">
             <div class="d-flex align-items-center justify-content-between">
              <a style="text-decoration: none;" href="{{ url('professional-profile/'.$profile->id.'/'.$profile->first_name.$profile->last_name) }}"> 
              <h5 class="profile-title" style="color: var(--Colors-Logo-Color, #0072b1);"> 
                    @if ($profile->show_full_name == 0)
                      {{$profile->first_name}} {{strtoupper(substr($profile->last_name, 0, 1))}}.
                      @else
                       {{$profile->first_name}} {{$profile->last_name}}
                  @endif   
                 </h5>
             </a>
              <div class="profile-rating d-flex align-items-center">
                <i class="fa-solid fa-star"></i> &nbsp;
                <p class="mb-0">4.9 ({{$gig->reviews}})</p>
              </div>
             </div>
              <p class="profile-text">{{$profile->profession}}</p>
              <p class="location">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M10.0034 6.45817C9.34035 6.45817 8.70447 6.72156 8.23563 7.1904C7.76679 7.65924 7.5034 8.29513 7.5034 8.95817C7.5034 9.62121 7.76679 10.2571 8.23563 10.7259C8.70447 11.1948 9.34035 11.4582 10.0034 11.4582C10.6664 11.4582 11.3023 11.1948 11.7712 10.7259C12.24 10.2571 12.5034 9.62121 12.5034 8.95817C12.5034 8.29513 12.24 7.65924 11.7712 7.1904C11.3023 6.72156 10.6664 6.45817 10.0034 6.45817ZM8.54506 8.95817C8.54506 8.5714 8.69871 8.20046 8.9722 7.92697C9.24569 7.65348 9.61662 7.49984 10.0034 7.49984C10.3902 7.49984 10.7611 7.65348 11.0346 7.92697C11.3081 8.20046 11.4617 8.5714 11.4617 8.95817C11.4617 9.34494 11.3081 9.71588 11.0346 9.98937C10.7611 10.2629 10.3902 10.4165 10.0034 10.4165C9.61662 10.4165 9.24569 10.2629 8.9722 9.98937C8.69871 9.71588 8.54506 9.34494 8.54506 8.95817ZM15.418 13.3332L11.2146 17.7957C11.0588 17.9611 10.8708 18.093 10.6621 18.1831C10.4535 18.2732 10.2286 18.3197 10.0013 18.3197C9.77402 18.3197 9.54914 18.2732 9.34048 18.1831C9.13182 18.093 8.9438 17.9611 8.78798 17.7957L4.58465 13.3332H4.60048L4.5934 13.3248L4.58465 13.3144C3.50577 12.0384 2.91511 10.4208 2.91798 8.74984C2.91798 4.83775 6.08923 1.6665 10.0013 1.6665C13.9134 1.6665 17.0846 4.83775 17.0846 8.74984C17.0875 10.4208 16.4969 12.0384 15.418 13.3144L15.4092 13.3248L15.4021 13.3332H15.418ZM14.6084 12.6586C15.5368 11.5681 16.0455 10.182 16.043 8.74984C16.043 5.41317 13.338 2.70817 10.0013 2.70817C6.66465 2.70817 3.95965 5.41317 3.95965 8.74984C3.95704 10.182 4.46576 11.5681 5.39423 12.6586L5.52256 12.8098L9.54631 17.0811C9.60475 17.1431 9.67525 17.1926 9.7535 17.2264C9.83175 17.2602 9.91608 17.2776 10.0013 17.2776C10.0865 17.2776 10.1709 17.2602 10.2491 17.2264C10.3274 17.1926 10.3979 17.1431 10.4563 17.0811L14.4801 12.8098L14.6084 12.6586Z" fill="#7D7D7D"></path></svg>
                  @if ($gigData->work_site == null)
                  <span>{{$profile->city}}, {{$profile->country}}</span>
                  @else
                  @php
                  $address =  $gigData->work_site ;
                      // Convert address to an array (split by comma)
                        $parts = explode(",", $address);

                    // Trim spaces
                    $parts = array_map('trim', $parts);

                    // Get the last two parts (city and country)
                    $city = $parts[count($parts) - 2] ?? "Unknown";
                    $country = $parts[count($parts) - 1] ?? "Unknown";
                  @endphp
                  <span>{{$city}}, {{$country}}</span>
                      
                  @endif
                 
              </p>
              <a href="#freelance_type" class="btn w-100 d-flex justify-content-center view-all-profile scroll-to-booking">Book This Service</a>

              
              <div class="social-section">
                <h3>Share on :</h3>
                <a href="javascript:void(0);" onclick="getShareURL('whatsapp')">
                    <img src="assets/public-site/asset/img/whatsapp.svg" alt="">
                </a>
                <a href="javascript:void(0);" onclick="getShareURL('twitter')">
                    <img src="assets/public-site/asset/img/twitter.svg" alt="">
                </a>
                <a href="javascript:void(0);" onclick="getShareURL('facebook')">
                    <img src="assets/public-site/asset/img/facebook.png" alt="" style="width: 24px; height: 24px;">
                </a>
                {{-- <a href="javascript:void(0);" onclick="getShareURL('instagram')">
                    <img src="assets/public-site/asset/img/insta.svg" alt="">
                </a> --}}
                <a href="javascript:void(0);" onclick="getShareURL('linkedin')">
                    <img src="assets/public-site/asset/img/linkedin.svg" alt="">
                </a>
            </div>
            
            </div>
          </div>
        </div>
      </div>
      <div class="profile-detail col-md-9 column-1">
        <div class="booking-det pt-0">
          <h3>{{$gig->title}}</h3>



          <div class="service-payment-sec">
            <div class="row">
              <div class="col-md-6">
              <div class="service-pay">
                <h4>Price:</h4>
                @php 
                if ($gig->freelance_type == 'Both') {
                  $rate = $gigPayment->rate;
                  $rate = explode('|*|',$rate);
                  $basic_rate = $rate[0];
                  $premium_rate = $rate[1];
                  $rate = 'Basic $'.$basic_rate.' | Premium $'.$premium_rate ;
                  $plan_type = 'Basic & Premium';
               
                }else{
                  $rate = $gig->freelance_type.' $'.$gigPayment->rate  ;
                  $plan_type = $gig->freelance_type;
                } 
                $payment_type = ($gig->payment_type == 'OneOff') ? 'One-off' : 'Subscription' ; 
             
                 @endphp
                <p> {{$rate}}  </p>
              </div>
              </div>
              <div class="col-md-6">
                <div class="service-pay">
                  <h4>Service & Payment Type:</h4>
                  @php 
                  if ($gig->freelance_service == 'Consultation') {
                    $duration = $gigPayment->duration; // e.g. "1:30" or "00:45"
                      list($hours, $minutes) = explode(':', $duration);
                      $totalMinutes = ($hours * 60) + $minutes;
                  }else{

                    $totalMinutes = null;
                  }
                      
                  @endphp

                    @if ($gig->freelance_type == 'Both')
                    <p>{{$gig->service_type}} {{$gig->service_role}} | {{$plan_type}} Plan | {{$payment_type}} Payment     </p>      
                    @else
                    <p>{{$gig->service_type}} {{$gig->service_role}} | @if ($gig->freelance_service == 'Consultation')
                      Consultation   @else   {{$plan_type}} Plan  @endif | {{$payment_type}} Payment  @if ($gig->freelance_service == 'Consultation') |  {{$totalMinutes }} mins @endif  </p>
                    @endif

               
                 
                </div>
              </div>
            </div>
          </div>


          @if ($gigData->service_delivery != null)
              
          
          <div class="service-payment-sec pay-sec">
            <div class="row">

              @if ($gigData->work_site != null)
              <div class="col-md-6">
                <div class="service-pay">
                  <h4>Service Delivery Location</h4>
              
                  @php
                  if ($gigData->service_delivery == 2) {
                      $delivery_location = "Service will be delivered at buyer or seller's location";
                  } elseif($gigData->service_delivery == 1) {
                    $delivery_location = 'Service will be delivered at sellers location';
                  }else{
                    $delivery_location = 'Service will be delivered at buyers location';
                  }
              @endphp
                  <p>{{$delivery_location}}</p>
                </div>
              </div>
              @endif



              @if ($gigData->max_distance != null)
              <div class="col-md-6">
                <div class="service-pay">
                  <h4>Max. Travel Distance:</h4>
                  @php
                    if (!empty($gigData->work_site)) {
                        $address = $gigData->work_site;

                        // Convert address to an array (split by comma)
                        $parts = explode(",", $address);

                        // Trim spaces
                        $parts = array_map('trim', $parts);

                        // Get the last two parts (city and country)
                        $city = $parts[count($parts) - 2] ?? "Unknown";
                        $country = $parts[count($parts) - 1] ?? "Unknown";
                    } else {
                        $city = $profile->city;
                        $country = $profile->country;
                    }
                @endphp
                  <p>Able to travel up to {{$gigData->max_distance}} miles from {{$city}}, {{$country}}</p>
                </div>
                </div>

                @else

                <div class="col-md-6">
                  <div class="service-pay">
                    <h4>Max. Travel Distance:</h4>
                    
                    <p>N/A</p>
                  </div>
                  </div>

              @endif
 
              
              
            </div>
          </div>
          @endif


          @if ($gig->freelance_type != 'Both')

          @php
              if ($gig->service_type == 'Inperson' && $gigData->freelance_service == 'Normal') {
                $duration = $gigPayment->duration; // e.g. "1:30" or "00:45"
                 list($hours, $minutes) = explode(':', $duration);
                 $delivery_time = ($hours * 60) + $minutes .' Mins';
              } else {
               $delivery_time = $gigPayment->delivery_time .' Days';
              }
              
          @endphp
          <div class="service-payment-sec">
            <div class="row">
               <div class="col-md-6">
                <div class="service-pay">
                  <h4>Delivery:</h4> 
                    <p> with in {{$delivery_time}}   </p>  
                </div>
              </div>
              <div class="col-md-6">
              <div class="service-pay">
                <h4>Revisions:</h4>
               
                <p> {{$gigPayment->revision}} Revisions </p>
              </div>
              </div>
             
            </div>
          </div>
              
          @endif

 
        
          

 
          


          <div class="row">
            <div class="col-md-12">

              @if ($gigData->freelance_type != null)

              @php
                if ($gigData->freelance_type == 'Both') {
                    // Split the description by '|*|' separator
                    $descriptions = explode('|*|', $gigData->description);
                    $requirements = explode('|*|', $gigData->requirements);
                    $revision = explode('|*|', $gigPayment->revision);
                    

                    
         
              if ($gig->service_type == 'Inperson' && $gigData->freelance_service == 'Normal') {
               $delivery_time = explode('|*|', $gigPayment->duration); 
                 list($hours, $minutes) = explode(':', $delivery_time[0]);
                 list($hours_premium, $minutes_premium) = explode(':', $delivery_time[1]); 
                  $basic_delivery_time = ($hours * 60) + $minutes .' Mins' ?? '';
                    $premium_delivery_time = ($hours_premium * 60) + $minutes_premium .' Mins' ?? '';
              } else {
                $delivery_time = explode('|*|', $gigPayment->delivery_time); 
               $basic_delivery_time = $delivery_time[0].' Days' ?? '';
                    $premium_delivery_time = $delivery_time[1].' Days' ?? '';
              }
      

                    // Assign values for Basic & Premium (if available)
                    $basic_description = $descriptions[0] ?? '';
                    $premium_description = $descriptions[1] ?? '';
                    $basic_requirements = $requirements[0] ?? '';
                    $premium_requirements = $requirements[1] ?? '';
                    $basic_revision = $revision[0] ?? '';
                    $premium_revision = $revision[1] ?? '';
                    
                } else {
                    // If not 'Both', set the same description for Basic & Premium
                    $basic_description = $gigData->description;
                    $premium_description = $gigData->description;
                    $basic_requirements = $gigData->requirements;
                    $premium_requirements = $gigData->requirements;
                    $basic_revision = $gigData->revision;
                    $premium_revision = $gigData->revision;
                    $basic_delivery_time = $gigData->delivery_time;
                    $premium_delivery_time = $gigData->delivery_time;

                       if ($gig->service_type == 'Inperson' && $gigData->freelance_service == 'Normal') {
               
                 list($hours, $minutes) = explode(':', $gigPayment->duration); 
                  $basic_delivery_time = ($hours * 60) + $minutes .' Mins' ?? '';
                    $premium_delivery_time = ($hours * 60) + $minutes .' Mins' ?? '';
              } else {
                $delivery_time = explode('|*|', $gigPayment->delivery_time); 
               $basic_delivery_time = $gigData->delivery_time.' Days' ?? '';
                    $premium_delivery_time = $gigData->delivery_time.' Days' ?? '';
              }
                }
 
            @endphp
                  
             
              <div class="services-tabs-section"  >
              <div class="tabs">
                <div class="tabs-nav" role="tablist" aria-label="Content sections" @if ($gigData->freelance_type != 'Both') style="display: none;" @endif @if ($gigData->freelance_type == 'Premium') style="justify-content: flex-start;" @endif >
                    <div class="tabs-indicator"></div>
                  @if (in_array($gigData->freelance_type, ['Both', 'Basic']))
                  <button class="tab-button border-end-0" role="tab" aria-selected="true" aria-controls="panel-1" id="tab-1">
                    Basic
                  </button>
                  @endif
                  @if (in_array($gigData->freelance_type, ['Both', 'Premium']))
                  @php
                  $aria_selected =  ($gigData->freelance_type == 'Premium') ? 'true': 'false' ;
                    @endphp
                  <button class="tab-button border-start-0 @if ($gigData->freelance_type == 'Premium') active @endif" role="tab" aria-selected="{{$aria_selected}}" aria-controls="panel-2" id="tab-2" >
                    Premium
                  </button>
                  @endif
                  
                   
                </div>
        
                @if (in_array($gigData->freelance_type, ['Both', 'Basic']))
                <div class="tab-panel" role="tabpanel" id="panel-1" aria-labelledby="tab-1" aria-hidden="false">
                    
                    {{-- <div class="service-payment-sec">
                      <div class="row">
                        <div class="col-md-6">
                        <div class="service-pay">
                          <h4>Revisions</h4>
                          <p>15 Revisions</p>
                        </div>
                        </div>
                        <div class="col-md-6">
                          <div class="service-pay">
                            <h4>Delivery</h4>
                            <p>within 15 Days
                            </p>
                          </div>
                        </div>
                      </div>
                    </div> --}}

                    @if ($gigData->freelance_type == 'Both')

                    <h2>Delivery & Completion Date:</h2>

                    <div class="service-payment-sec">
                      <div class="row">

                        <div class="col-md-6">
                          <div class="service-pay">
                            <h4>Delivery:</h4>
                          <p> with in {{$basic_delivery_time}}   </p>    
                          </div>
                        </div>

                        <div class="col-md-6">
                        <div class="service-pay">
                          <h4>Revisions:</h4>
                         
                          <p> {{$basic_revision}} Revisions </p>
                        </div>
                        </div>
                        
                      </div>
                    </div>
                        
                    @endif
                    

                    <h2>Description:</h2>
                    <div class="description-sec">
                      <p> {!! $basic_description !!} </p>
                    </div>
                    <h2>Requirements :</h2>
                    <div class="description-sec">
                      <p> {!! $basic_requirements !!}  </p>
                    </div>

                    <h2>Booking & Cancelation Details :</h2>
                    <div class="description-sec">
                      <h4>Booking:</h4>
                      <ul>
                        <li>Secure your design service by providing complete project details, including requirements, timeline, and references.</li>
                        <li>A confirmation message will be sent upon booking approval, and work will begin as per the agreed schedule.</li>
                        <li>Urgent requests can be accommodated based on availability with an additional fee.</li>
                      </ul>
                      <h4>Revisions:</h4>
                      <ul>
                        <li>Revisions are included based on the selected package to ensure 100% satisfaction.</li>
                        <li>Major design changes after approval may incur additional costs.</li>
                      </ul>
                      <h4>Cancellation & Refunds:</h4>
                      <ul>
                        <li>Orders can be canceled before work begins for a full refund.</li>
                        <li>If work has started, a partial refund may be issued based on the progress made.</li>
                        <li>No refunds will be provided once the final files are delivered.</li>
                        <li>In case of unavoidable circumstances, order adjustments can be discussed.</li>
                      </ul>
                      <p>For any questions or special requests, feel free to contact before placing your order! 🚀</p>
                    </div>
                      
                    <div class="service-faqs-sec">
                      <h2>FAQ’S</h2>
                      <div class="faq-sec">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="accordion">
                              @if (count($gigFaqs) > 0)
                            @foreach ($gigFaqs as $item)
                            <div class="accordion-item">
                              <input type="checkbox" id="accordion{{$item->id}}">
                              <label for="accordion{{$item->id}}" class="accordion-item-title"><span class="icon"></span>{{$item->question}}</label>
                              <div class="accordion-item-desc">
                                {!! $item->answer !!}
                              </div>
                            </div>
                                
                            @endforeach

                            @else
                            <div class="accordion-item">
                              <input type="checkbox" id="accordion1">
                              <label for="accordion1" class="accordion-item-title"><span class="icon"></span>Not Have Any Faq's</label>
                              <div class="accordion-item-desc">
                               </div>
                            </div>
                            @endif

                            
                            </div>
                          </div>
                        
                        </div>
                      </div>
                    </div>
                    
                </div>

                @endif
                
                @if (in_array($gigData->freelance_type, ['Both', 'Premium']))
                @php
                $aria_hidden =  ($gigData->freelance_type == 'Premium') ? 'false': 'true' ;
                  @endphp
                <div class="tab-panel" role="tabpanel" id="panel-2" aria-labelledby="tab-2" aria-hidden="{{$aria_hidden}}">
                  

                  @if ($gigData->freelance_type == 'Both')

                    <h2>Delivery & Completion Date:</h2>

                    <div class="service-payment-sec">
                      <div class="row">

                         <div class="col-md-6">
                          <div class="service-pay">
                            <h4>Delivery:</h4> 
                              <p> with in {{$premium_delivery_time}}   </p>   
                          </div>
                        </div>

                        <div class="col-md-6">
                        <div class="service-pay">
                          <h4>Revisions:</h4>
                         
                          <p> {{$premium_revision}} Revisions </p>
                        </div>
                        </div>
                       
                      </div>
                    </div>
                        
                    @endif
                
                  <h2>Description:</h2>
                  <div class="description-sec">
                    <p> {!! $premium_description !!} </p>
                  </div>
                  <h2>Requirements :</h2>
                  <div class="description-sec">
                    <p> {!! $premium_requirements !!}  </p>
                  </div>

                  
                  <h2>Booking & Cancelation Details :</h2>
                  <div class="description-sec">
                    <h4>Booking:</h4>
                    <ul>
                      <li>Secure your design service by providing complete project details, including requirements, timeline, and references.</li>
                      <li>A confirmation message will be sent upon booking approval, and work will begin as per the agreed schedule.</li>
                      <li>Urgent requests can be accommodated based on availability with an additional fee.</li>
                    </ul>
                    <h4>Revisions:</h4>
                    <ul>
                      <li>Revisions are included based on the selected package to ensure 100% satisfaction.</li>
                      <li>Major design changes after approval may incur additional costs.</li>
                    </ul>
                    <h4>Cancellation & Refunds:</h4>
                    <ul>
                      <li>Orders can be canceled before work begins for a full refund.</li>
                      <li>If work has started, a partial refund may be issued based on the progress made.</li>
                      <li>No refunds will be provided once the final files are delivered.</li>
                      <li>In case of unavoidable circumstances, order adjustments can be discussed.</li>
                    </ul>
                    <p>For any questions or special requests, feel free to contact before placing your order! 🚀</p>
                  </div>
                   
                  <div class="service-faqs-sec">
                    <h2>FAQ’S</h2>
                    <div class="faq-sec">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="accordion">
 

                            @if (count($gigFaqs) > 0)
                            @foreach ($gigFaqs as $item)
                            <div class="accordion-item">
                              <input type="checkbox" id="accordion{{$item->id}}">
                              <label for="accordion{{$item->id}}" class="accordion-item-title"><span class="icon"></span>{{$item->question}}</label>
                              <div class="accordion-item-desc">
                                {!! $item->answer !!}
                              </div>
                            </div>
                                
                            @endforeach

                            @else
                            <div class="accordion-item">
                              <input type="checkbox" id="accordion1">
                              <label for="accordion1" class="accordion-item-title"><span class="icon"></span>Not Have Any Faq's</label>
                              <div class="accordion-item-desc">
                               </div>
                            </div>
                            @endif
                            
      
                           
                          </div>
                        </div>
                      
                      </div>
                    </div>
                  </div>
                </div>
                @endif
               
            </div>
          </div>




          @else


          <div class="services-tabs-section">
            <div class="tabs">
               
      
              <div class="tab-panel" role="tabpanel" id="panel-1" aria-labelledby="tab-1" aria-hidden="false">
                   
                   
                  <h2>Description:</h2>
                  <div class="description-sec">
                    <p> {!! $gigData->description !!} </p>
                  </div>
                  <h2>Requirements :</h2>
                  <div class="description-sec">
                    <p> {!! $gigData->requirements !!} </p>
                  </div>

                  
                  <h2>Booking & Cancelation Details :</h2>
                  <div class="description-sec">
                    <h4>Booking:</h4>
                    <ul>
                      <li>Secure your design service by providing complete project details, including requirements, timeline, and references.</li>
                      <li>A confirmation message will be sent upon booking approval, and work will begin as per the agreed schedule.</li>
                      <li>Urgent requests can be accommodated based on availability with an additional fee.</li>
                    </ul>
                    <h4>Revisions:</h4>
                    <ul>
                      <li>Revisions are included based on the selected package to ensure 100% satisfaction.</li>
                      <li>Major design changes after approval may incur additional costs.</li>
                    </ul>
                    <h4>Cancellation & Refunds:</h4>
                    <ul>
                      <li>Orders can be canceled before work begins for a full refund.</li>
                      <li>If work has started, a partial refund may be issued based on the progress made.</li>
                      <li>No refunds will be provided once the final files are delivered.</li>
                      <li>In case of unavoidable circumstances, order adjustments can be discussed.</li>
                    </ul>
                    <p>For any questions or special requests, feel free to contact before placing your order! 🚀</p>
                  </div>
                  
                  <div class="service-faqs-sec">
                    <h2>FAQ’S</h2>
                    <div class="faq-sec">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="accordion">
                            @if (count($gigFaqs) > 0)
                          @foreach ($gigFaqs as $item)
                          <div class="accordion-item">
                            <input type="checkbox" id="accordion{{$item->id}}">
                            <label for="accordion{{$item->id}}" class="accordion-item-title"><span class="icon"></span>{{$item->question}}</label>
                            <div class="accordion-item-desc">
                              {!! $item->answer !!}
                            </div>
                          </div>
                              
                          @endforeach

                          @else
                          <div class="accordion-item">
                            <input type="checkbox" id="accordion1">
                            <label for="accordion1" class="accordion-item-title"><span class="icon"></span>Not Have Any Faq's</label>
                            <div class="accordion-item-desc">
                             </div>
                          </div>
                          @endif

                          
                          </div>
                        </div>
                      
                      </div>
                    </div>
                  </div>
                  
              </div>
              
            
              
             
          </div>
        </div>



          @endif





            </div>
          </div>







         
        </div>
        
      </div>
       
    </div>
  </div>
    </div>
    <!-- Buyer review section is here -->
    <div class="container-fluid card_wrapper">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  <h1 class="page-title">Buyer Reviews</h1>
                  <p class="page-title-2">Voice of Our Valued Buyers - LMS Buyer Reviews!</p>
                  <div class="owl-carousel card_carousel owl-loaded owl-drag">
                      
                      
                      
                      
                      
                      
                      
                      
                  <div class="owl-stage-outer"><div class="owl-stage" style="transform: translate3d(-7656px, 0px, 0px); transition: 0.25s; width: 11140px; padding-left: 2px; padding-right: 2px;"><div class="owl-item cloned" style="width: 676px; margin-right: 20px;"><div class="card  card-slider">
                          <div class="card-body">
                              <div class="d-flex"><img src="assets/public-site/asset/img/slidercommentimg1.png" class="rounded-circle">
                                  <div class="d-flex flex-column">
                                      <div class="name">Thomas H.</div>
                                      <p class="text-muted">Student</p>
                                  </div>
                              </div>
                              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent ullamcorper nisl eu accumsan.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent
                                  ullamcorper nisl eu accumsan. </p>
                          </div>
                      </div></div><div class="owl-item cloned" style="width: 676px; margin-right: 20px;"><div class="card  card-slider">
                          <div class="card-body">
                              <div class="d-flex"><img src="assets/public-site/asset/img/IMG1.png" class="rounded-circle">
                                  <div class="d-flex flex-column">
                                      <div class="name">Thomas H.</div>
                                      <p class="text-muted">Student</p>
                                  </div>
                              </div>
                              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent ullamcorper nisl eu accumsan.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent
                                  ullamcorper nisl eu accumsan. </p>
                          </div>
                      </div></div><div class="owl-item cloned" style="width: 676px; margin-right: 20px;"><div class="card  card-slider">
                          <div class="card-body">
                              <div class="d-flex"><img src="assets/public-site/asset/img/slidercommentimg1.png" class="rounded-circle">
                                  <div class="d-flex flex-column">
                                      <div class="name">Thomas H.</div>
                                      <p class="text-muted">Student</p>
                                  </div>
                              </div>
                              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent ullamcorper nisl eu accumsan.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent
                                  ullamcorper nisl eu accumsan. </p>
                          </div>
                      </div></div><div class="owl-item cloned" style="width: 676px; margin-right: 20px;"><div class="card  card-slider">
                          <div class="card-body">
                              <div class="d-flex"><img src="assets/public-site/asset/img/IMG1.png" class="rounded-circle">
                                  <div class="d-flex flex-column">
                                      <div class="name">Thomas H.</div>
                                      <p class="text-muted">Student</p>
                                  </div>
                              </div>
                              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent ullamcorper nisl eu accumsan.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent
                                  ullamcorper nisl eu accumsan. </p>
                          </div>
                      </div></div><div class="owl-item" style="width: 676px; margin-right: 20px;"><div class="card card-slider">
                          <div class="card-body">
                              <div class="d-flex"><img src="assets/public-site/asset/img/slidercommentimg1.png" class="rounded-circle">
                                  <div class="d-flex flex-column">
                                      <div class="name">Thomas H.</div>
                                      <p class="text-muted">Student</p>
                                  </div>
                              </div>
                              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent ullamcorper nisl eu accumsan.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent
                                  ullamcorper nisl eu accumsan. </p>
                          </div>
                      </div></div><div class="owl-item" style="width: 676px; margin-right: 20px;"><div class="card card-slider">
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
                              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent ullamcorper nisl eu accumsan.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent
                                  ullamcorper nisl eu accumsan. </p>
                          </div>
                      </div></div><div class="owl-item" style="width: 676px; margin-right: 20px;"><div class="card  card-slider">
                          <div class="card-body">
                              <div class="d-flex"><img src="assets/public-site/asset/img/slidercommentimg1.png" class="rounded-circle">
                                  <div class="d-flex flex-column">
                                      <div class="name">Thomas H.</div>
                                      <p class="text-muted">Student</p>
                                  </div>
                              </div>
                              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent ullamcorper nisl eu accumsan.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent
                                  ullamcorper nisl eu accumsan. </p>
                          </div>
                      </div></div><div class="owl-item" style="width: 676px; margin-right: 20px;"><div class="card  card-slider">
                          <div class="card-body">
                              <div class="d-flex"><img src="assets/public-site/asset/img/IMG1.png" class="rounded-circle">
                                  <div class="d-flex flex-column">
                                      <div class="name">Thomas H.</div>
                                      <p class="text-muted">Student</p>
                                  </div>
                              </div>
                              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent ullamcorper nisl eu accumsan.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent
                                  ullamcorper nisl eu accumsan. </p>
                          </div>
                      </div></div><div class="owl-item" style="width: 676px; margin-right: 20px;"><div class="card  card-slider">
                          <div class="card-body">
                              <div class="d-flex"><img src="assets/public-site/asset/img/slidercommentimg1.png" class="rounded-circle">
                                  <div class="d-flex flex-column">
                                      <div class="name">Thomas H.</div>
                                      <p class="text-muted">Student</p>
                                  </div>
                              </div>
                              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent ullamcorper nisl eu accumsan.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent
                                  ullamcorper nisl eu accumsan. </p>
                          </div>
                      </div></div><div class="owl-item" style="width: 676px; margin-right: 20px;"><div class="card  card-slider">
                          <div class="card-body">
                              <div class="d-flex"><img src="assets/public-site/asset/img/IMG1.png" class="rounded-circle">
                                  <div class="d-flex flex-column">
                                      <div class="name">Thomas H.</div>
                                      <p class="text-muted">Student</p>
                                  </div>
                              </div>
                              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent ullamcorper nisl eu accumsan.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent
                                  ullamcorper nisl eu accumsan. </p>
                          </div>
                      </div></div><div class="owl-item" style="width: 676px; margin-right: 20px;"><div class="card  card-slider">
                          <div class="card-body">
                              <div class="d-flex"><img src="assets/public-site/asset/img/slidercommentimg1.png" class="rounded-circle">
                                  <div class="d-flex flex-column">
                                      <div class="name">Thomas H.</div>
                                      <p class="text-muted">Student</p>
                                  </div>
                              </div>
                              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent ullamcorper nisl eu accumsan.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent
                                  ullamcorper nisl eu accumsan. </p>
                          </div>
                      </div></div><div class="owl-item active" style="width: 676px; margin-right: 20px;"><div class="card  card-slider">
                          <div class="card-body">
                              <div class="d-flex"><img src="assets/public-site/asset/img/IMG1.png" class="rounded-circle">
                                  <div class="d-flex flex-column">
                                      <div class="name">Thomas H.</div>
                                      <p class="text-muted">Student</p>
                                  </div>
                              </div>
                              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent ullamcorper nisl eu accumsan.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent
                                  ullamcorper nisl eu accumsan. </p>
                          </div>
                      </div></div><div class="owl-item cloned active" style="width: 676px; margin-right: 20px;"><div class="card card-slider">
                          <div class="card-body">
                              <div class="d-flex"><img src="assets/public-site/asset/img/slidercommentimg1.png" class="rounded-circle">
                                  <div class="d-flex flex-column">
                                      <div class="name">Thomas H.</div>
                                      <p class="text-muted">Student</p>
                                  </div>
                              </div>
                              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent ullamcorper nisl eu accumsan.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent
                                  ullamcorper nisl eu accumsan. </p>
                          </div>
                      </div></div><div class="owl-item cloned" style="width: 676px; margin-right: 20px;"><div class="card card-slider">
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
                              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent ullamcorper nisl eu accumsan.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent
                                  ullamcorper nisl eu accumsan. </p>
                          </div>
                      </div></div><div class="owl-item cloned" style="width: 676px; margin-right: 20px;"><div class="card  card-slider">
                          <div class="card-body">
                              <div class="d-flex"><img src="assets/public-site/asset/img/slidercommentimg1.png" class="rounded-circle">
                                  <div class="d-flex flex-column">
                                      <div class="name">Thomas H.</div>
                                      <p class="text-muted">Student</p>
                                  </div>
                              </div>
                              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent ullamcorper nisl eu accumsan.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent
                                  ullamcorper nisl eu accumsan. </p>
                          </div>
                      </div></div><div class="owl-item cloned" style="width: 676px; margin-right: 20px;"><div class="card  card-slider">
                          <div class="card-body">
                              <div class="d-flex"><img src="assets/public-site/asset/img/IMG1.png" class="rounded-circle">
                                  <div class="d-flex flex-column">
                                      <div class="name">Thomas H.</div>
                                      <p class="text-muted">Student</p>
                                  </div>
                              </div>
                              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent ullamcorper nisl eu accumsan.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent
                                  ullamcorper nisl eu accumsan. </p>
                          </div>
                      </div></div></div></div><div class="owl-nav"><button type="button" role="presentation" class="owl-prev"><i class="fa-solid fa-angle-left" aria-hidden="true"></i></button><button type="button" role="presentation" class="owl-next"><i class="fa-solid fa-chevron-right" aria-hidden="true"></i> </button></div><div class="owl-dots disabled"></div></div>
              </div>
          </div>
      </div>
  </div>
    <!-- portfolio section here -->
   
                    <div class="container">
                    <div class="row">
                          <div class="portfolio-sec portfolio-img mb-5">
                            <h5>Portfolio</h5>
                            <div class="row">


                              <div class="col-md-3" style="height: 250px;">
                                <a
                                  href="assets/teacher/listing/data_{{$gig->user_id}}/media/{{$gigData->main_file}}"
                                  data-fancybox="gallery"
                                  data-caption=""
                                >
                                @if (Str::endsWith($gigData->main_file, ['.mp4', '.avi', '.mov', '.webm'])) 
                                <!-- Video Player -->
                                <video autoplay loop muted  style="height: 100%; width: 100%;">
                                    <source src="assets/teacher/listing/data_{{$gig->user_id}}/media/{{$gigData->main_file}}" type="video/mp4" >
                                    Your browser does not support the video tag.
                                </video>
                            @elseif (Str::endsWith($gigData->main_file, ['.jpg', '.jpeg', '.png', '.gif']))
                                <!-- Image Display -->
                                <img src="assets/teacher/listing/data_{{$gig->user_id}}/media/{{$gigData->main_file}}" style="height: 100%;" alt="Uploaded Image">
                            @endif 
                                </a>
                              </div>
                              @if ($gigData->other !=null)
                              @php $other = explode(',_,',$gigData->other); @endphp
                              @foreach ($other as $item)

                              <div class="col-md-3" style="height: 250px;">
                                <a
                                  href="assets/teacher/listing/data_{{$gig->user_id}}/media/{{$item}}"
                                  data-fancybox="gallery"
                                  data-caption=""
                                >
                                  <img src="assets/teacher/listing/data_{{$gig->user_id}}/media/{{$item}}" style="height: 100%;"/>
                                </a>
                              </div>
                                  
                              @endforeach
                                  
                              @endif

                              @if ($gigData->video !=null)
                 
                              <div class="col-md-3" style="height: 250px;">
                                <a
                                  href="assets/teacher/listing/data_{{$gig->user_id}}/media/{{$gigData->video}}"
                                  data-fancybox="gallery"
                                  data-caption=""
                                >
                                <video controls class="Request-img" src="assets/teacher/listing/data_{{$gig->user_id}}/media/{{$gigData->video}}" style="height: 100%;">
                                </a>
                              </div>
                                   
                                  
                              @endif

                            
                            </div>
                            <!-- row / end -->
                          </div>

                          <form id="payment_form"  action="/service-book" method="POST"> 
                            @csrf
                            
                          <div class="portfolio-form">
                            <div class="row g-3">
                            

                             

                              <div class="row">
                                <div class="col-md-4 select-group" style="padding-top: 0px;">
                                  <label for="frequency">Select Freelance Type</label><br />

                                  <input type="hidden" id="total_people" name="total_people" value="1">
                                  @php
                                      if ($gigData->freelance_type == 'Both') {
                                        $rate = explode('|*|',$gig->rate)   ; 
                                        $rate = $rate[0];
                                      }else{
                                        $rate =  $gig->rate ; 
                                      }
                                  @endphp
                                <input type="hidden" id="price" name="price" value="{{$rate}}">
                                <input type="hidden" id="gig_id" name="gig_id" value="{{$gig->id}}">
                                <input type="hidden" id="freelance_service" name="freelance_service" value="{{$gigData->freelance_service}}">
                                <input type="hidden" id="my_location" name="my_location" value="No">

                                  <select id="freelance_type" name="freelance_type" type="text">
                                    
                                    @if ($gigData->freelance_type == 'Both')
                                    @php $rate = explode('|*|',$gig->rate)   ;    @endphp
                                    <option value="Basic" selected>Basic - ${{$rate[0]}}</option>
                                    <option value="Premium">Premium - ${{$rate[1]}}</option>
                                    @else
                                    <option value="{{$gigData->freelance_type}}" selected>{{$gigData->freelance_type}}</option>
                                  @endif
                                    
                                  </select>
                                </div>
                              </div>

                              @if ($gig->service_type == 'Inperson')

                              <div class="row mt-2">
                                <div class="col-md-4 select-group" style="padding-top: 0px;">
                                  <label for="service_delivery">Where would you like this service offered</label><br />
 
                                  <select id="service_delivery" name="service_delivery" type="text">
                                    @if ($gigData->service_delivery == 0) 
                                  <option value="0" selected>I will visit clients sites to offer this service</option>
                                  @elseif($gigData->service_delivery == 1)
                                  <option value="1" selected>This service would be offered at my work site  </option>
                                  @else
                                  <option value="1" selected>This service would be offered at my work site  </option>
                                  <option value="0">I will visit clients sites to offer this service</option>
                                  @endif
                                    
                                  </select>
                                </div>


                                <div class="col-md-8 select-group" style="padding-top: 0px;" id="work_location_div"> 
                                   </div>


                              </div>
                                  
                              @endif
                              
                            
                              <div class="col-md-12 field_wrapper date-time mt-2">
                                <div class="">
                                  <label for="inputEmail4" class="form-label">Select Date & Time</label>
                                  <p id="time_zone_show">Show Date/Time Based on</p>
                                  <div id="picker"></div>
                                <div>
                                    <p>Selected dates / times:</p>
                                    <div id="selected-dates"></div>
                                </div>
                                  <input type="hidden" name="class_time" id="class_time">
                                  <input type="hidden" name="teacher_class_time" id="teacher_class_time">
                                  <input type="hidden" name="selected_slots" id="selected_slots">
                                  <input type="hidden" name="teacher_time_zone" id="teacher_time_zone">
                                  <input type="hidden" name="user_time_zone" id="user_time_zone">
                                 
                     
                                </div>
                              </div>
                            </form>
                          </div>
                          <div class="row">
                            <div class="col-md-12 booking-notes service-notes">
                              <h5>Notes</h5>
                              <ul class="p-0">
                                <li>
                                  To ensure that your payments are protected under our terms, never transfer money or send messages outside of the Dreamcrowd platform.
                                </li>
                                <br />
                                <li>
                                  Payments made outside of our platform are not eligible for disputes & refunds under our terms.
                                </li>
                                <br />
                                <li>
                                  Please send us a report if you have been asked by a Creator to communicate or pay outside of our  platform.
                                </li>
                                <br />
                                <li>
                                  To ensure that your payments are protected under our terms, never transfer money or send messages outside of the Dreamcrowd platform.
                                </li>
                                <br />
                                <li>
                                  Payments made outside of our platform are not eligible for disputes & refunds under our terms.
                                </li>
                                <br />
                                <li>
                                  Please send us a report if you have been asked by a Creator to communicate or pay outside of our  platform.
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                  <div class="amount-sec amount-section">
                    <div class="row">
                      <div class="col-md-12">
                        @php
                        if ($gigData->freelance_type == 'Both') {
                          $rate = explode('|*|',$gigPayment->rate);
                          $rate = $rate[0];
                          # code...
                        } else {
                          $rate = $gigPayment->rate;
                        }
                        
                         @endphp
                        <p class="float-start">Total Amount: <span id="total_price">${{$rate}}</span></p>
                        <div class="float-end">

                          @if (Auth::user() && Auth::user()->role == 0)
                          <a
                            href="#"
                            type="button"
                            class="btn contact-btn"
                            data-bs-toggle="modal"
                            id="contact-us"
                            data-bs-target="#contact-me-modal"
                            >Contact Me</a
                          >
               
                              
                          <button onclick="ServicePayemnt();" class="btn booking-btn">Complete Booking</button>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>

                </form>

                </div>


 
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
                              <label for="inputEmail4" class="form-label">Name</label>
                              <input
                                type="text" readonly
                                class="form-control"
                                id="inputEmail4" value="{{$profile->first_name}} {{$profile->last_name}}"
                                placeholder="Usama Aslam"
                              />
                            </div> --}}
                            <div class="col-md-12 check-services">
                              <div class="form-group">
                                <label for="message-textarea">Message Details</label>
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
             
    <!-- ============================= FOOTER SECTION START HERE ===================================== -->
    <!-- =========================================== NAVBAR START HERE ================================================= -->
    <x-public-footer/>
    <!-- ============================================= NAVBAR END HERE ============================================ -->
    <!-- =============================== FOOTER SECTION END HERE ===================================== -->
    <script src="assets/public-site/libs/jquery/jquery.js"></script>
    <script src="assets/public-site/libs/datatable/js/datatable.js"></script>
    <script src="assets/public-site/libs/datatable/js/datatablebootstrap.js"></script>
    <script src="assets/public-site/libs/select2/js/select2.min.js"></script>
    <script src="assets/public-site/libs/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="assets/public-site/asset/js/bootstrap.min.js"></script>
    <script src="assets/public-site/asset/js/script.js"></script>
    <script src="assets/seller-listing-new/asset/jquery.datetimepicker.full.min.js"></script>
  
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
  

    <script>
      document.querySelector('.scroll-to-booking').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent default anchor behavior
        const target = document.querySelector('#freelance_type');
        if (target) {
          target.scrollIntoView({ behavior: 'smooth' });
        }
      });
    </script>
    
  
  
  
  <script>
 
 function ServicePayemnt() {
    let isValid = true;
    let gig_id = @json($gigData->gig_id);
    let lesson_type = @json($gigData->lesson_type);
    let service_type = @json($gig->service_type);
    let frequency = parseInt($("#frequency").val()) || 1;
    let duration = parseInt('<?= $gigPayment->duration; ?>') || 120; // Duration in minutes (2 hours)
    let groupType =  $("#group_type").val() || null ;

    if (lesson_type == 'Group') {
        let guests = parseInt($("#guests").val()) || 0;
        let extra_guests = $("#extra_guests").val() || 'No' ;
        
        let children = parseInt($("#childs").val()) || 0;
        let emails = $("#all_emails").val().split(",");

        let totalPeople = guests ;
        let groupSize = (groupType === 'Public') ? parseInt('<?= $gigPayment->public_group_size; ?>') : parseInt('<?= $gigPayment->private_group_size; ?>');
        let minorsAllowed = parseInt('<?= $gigPayment->minor_attend; ?>');
        let minorsLimit = parseInt('<?= $gigPayment->childs; ?>');
         
        if (groupType === 'Private' || (groupType === 'Public' && extra_guests === 'Yes')) {
          
          
       
        if (guests <= 0) {  
            alert("Guests count cannot be negative!");
            $("#guests").val(1);
            return;
        }

        if (children < 0) {
            alert("Children count cannot be negative!");
            $("#childs").val(0);
            return;
        }

        if (minorsAllowed === 1 && children > minorsLimit) {
            alert(`Maximum ${minorsLimit} children allowed!`);
            $("#childs").val(minorsLimit);
            return;
        } else if (minorsAllowed === 0 && children > 0) {
            alert("Children are not allowed for this class!");
            $("#childs").val(0);
            return;
        }

        if (totalPeople > groupSize) {
            alert(`Total participants cannot exceed ${groupSize}!`);
            return;
        }

        if (guests < children) {
        alert("Guests minimmum equal to childs are allowed!");
        return;
    }
    console.log(emails.length);
    
        if (emails.length !== totalPeople) {
            alert(`You must enter exactly ${totalPeople} email addresses!`);
            return;
        }

        let emailSet = new Set();
        for (let email of emails) {
            if (!validateEmail(email)) {
                alert(`Invalid email: ${email}`);
                return;
            }
            if (emailSet.has(email)) {
                alert(`Duplicate email detected: ${email}`);
                return;
            }
            emailSet.add(email);
        }
      }
    }


    var class_time = $('#teacher_class_time').val();
     
    
    if (class_time == '') { 
      alert(`1 slot is required.`);
      return false;
    }
 

  

    if (service_type == 'Inperson') {
      var service_delivery = $('#service_delivery').val();
      if (service_delivery == 0) {
        var work_site = $('#work_site').val();
        if (work_site != "") {
          var my_location = $('#my_location').val();
          if (my_location == 'No') {
            alert("Service is not available in this area");
            return false;
          }
          
        }else{
          alert("Please add your address where you want service!");
          return false;
        }

        
      }
      
    }
    

    $('#payment_form').submit();
}

function validateEmail(email) {
    let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function formatTime(date) {
    let hours = date.getHours();
    let minutes = date.getMinutes();
    let ampm = hours >= 12 ? "PM" : "AM";
    hours = hours % 12 || 12;
    return `${hours}:${minutes.toString().padStart(2, "0")} ${ampm}`;
}



    </script>

 

{{-- Class Date - Time Selection Script END =========  --}}

 
        <script>
           

            // On Freelance Type Changes ============
            $('#freelance_type').on('change', function () {
              var freelance_type = $('#freelance_type').val();
              var gigData = @json($gigData);
              var gigPayment = @json($gigPayment);
              var gig = @json($gig);
              if (gigData.freelance_type == 'Both') {
                var rate = gigPayment.rate.split('|*|');
              } else {
                var rate = gigPayment.rate;
              }
            
              if (freelance_type == 'Basic') {
                $('#total_price').html(rate[0]);
                $('#price').val(rate[0]);
              } else {
                $('#total_price').html(rate[1]);
                $('#price').val(rate[1]);
                
              }
 
            });

  

        </script> 
 
    
    
        @if ($gig->service_type == 'Inperson')
            
       
    


   
{{-- Google Script CDN --}}
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMA8qhhaBOYY1uv0nUfsBGcE74w6JNY7M&libraries=places"></script>

{{-- Street Address Google Api Script Start --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    function updateWorkLocation() {
        var service_delivery = $('#service_delivery').val();
        var content;

        if (service_delivery == 1) {
            var work_site = @json($gigData->work_site);
            content = `
                <label for="work_location" class="form-label" id="work_lable">At seller's work location</label><br />
                
                <div class="input-group mb-3">
                <input type="text" class="enter-mail-id" id="work_location" value="${work_site}" readonly style="width: 70%;" />
                <button class="btn  view-all-profile"   type="button" id="view_map_btn">View Map</button>
              </div>
              `;
        } else {
            content = `
                <label for="work_location" class="form-label" id="work_lable">At my location</label><br />
                <div style="position: relative;">
                    <input class="Class-Title enter-mail-id" id="work_site" name="work_site" value="" placeholder="My Location"
                        type="text" style="padding: 14px 20px; width: 100%;" autocomplete="off" />
                    <ul id="nearme_dropdown" style="border-radius: 15px; display: none; position: absolute; background: white;
                        border: 1px solid #ccc; width: 80%; z-index: 1000; list-style: none; padding: 0; margin: 0; bottom: -38px; left: 7px;">
                        <li style="padding: 8px; cursor: pointer; font-size: 14px;" id="nearme_option">Near Me</li>
                    </ul>
                </div>`;
        }
        
        $('#work_location_div').html(content);
        setTimeout(initAutocomplete, 500);
    }

      // View Address in Map ===========
        // ✅ Delegate the click handler for dynamically added #view_map_btn
    $(document).on('click', '#view_map_btn', function () {
        const location = $('#work_location').val();
        if (location.trim() !== "") {
            const mapUrl = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(location)}`;
            window.open(mapUrl, '_blank');
        } else {
            alert("Location is empty!");
        }
    });

    function initAutocomplete() {
        var input = document.getElementById('work_site');
        if (input) {
            var autocomplete = new google.maps.places.Autocomplete(input, { types: [] });
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    alert("Invalid address, please select a valid location.");
                    return;
                }

                var enteredLat = place.geometry.location.lat();
                var enteredLng = place.geometry.location.lng();
                checkDistance(enteredLat, enteredLng);
            });
        }
    }

    function getUserLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;
                    var geocoder = new google.maps.Geocoder();
                    var latLng = new google.maps.LatLng(latitude, longitude);
                    geocoder.geocode({ location: latLng }, function (results, status) {
                        if (status === 'OK' && results[0]) {
                            $('#work_site').val(results[0].formatted_address);
                            checkDistance(latitude, longitude);
                        } else {
                            alert('Unable to retrieve location');
                        }
                    });
                },
                function () {
                    alert('Geolocation access denied');
                }
            );
        } else {
            alert('Geolocation is not supported by this browser.');
        }
    }

    function checkDistance(userLat, userLng) {
        var profileLat, profileLng;
        if ('{{ $gigData->work_site }}' === "") {
            profileLat = parseFloat("{{ $profile->latitude }}");
            profileLng = parseFloat("{{ $profile->longitude }}");
        } else {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ address: "{{ $gigData->work_site }}" }, function (results, status) {
                if (status === 'OK' && results[0].geometry) {
                    profileLat = results[0].geometry.location.lat();
                    profileLng = results[0].geometry.location.lng();
                    calculateDistance(userLat, userLng, profileLat, profileLng);
                } else {
                    alert("Unable to retrieve seller's location");
                }
            });
            return;
        }
        calculateDistance(userLat, userLng, profileLat, profileLng);
    }

    function calculateDistance(lat1, lng1, lat2, lng2) {
        function toRad(value) {
            return value * Math.PI / 180;
        }
        
        var R = 3958.8; // Radius of Earth in miles
        var dLat = toRad(lat2 - lat1);
        var dLng = toRad(lng2 - lng1);
        var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
                Math.sin(dLng / 2) * Math.sin(dLng / 2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        var distance = R * c;

        var maxDistance = parseInt("{{ $gigData->max_distance }}") || 100;
        if (maxDistance === 30) maxDistance = 100; // 30+ miles means 100 miles max
        console.log('Max Distance in service :' + maxDistance);
        console.log('From My Location Distance in service :' + distance);
        
        if (distance <= maxDistance) {
            $('#my_location').val('Yes');
        } else {
            $('#my_location').val('No');
            alert("Service is not available in this area");
        }
    }

    $(document).ready(function () {
        updateWorkLocation();
        $('#service_delivery').on('change', updateWorkLocation);
        
        $(document).on('focus', '#work_site', function () {
            if ($(this).val().trim() === '') {
                $('#nearme_dropdown').show();
            }
        });
        
        $(document).on('input', '#work_site', function () {
            $('#nearme_dropdown').toggle($(this).val().trim() === '');
        });
        
        $(document).on('click', '#nearme_option', function () {
            $('#nearme_dropdown').hide();
            getUserLocation();
        });
        
        $(document).on('click', function (event) {
            if (!$(event.target).closest('#work_location_div').length) {
                $('#nearme_dropdown').hide();
            }
        });
    });



  

});





    
</script>
{{-- Street Address Google Api Script END --}}
    

    @endif
    
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
<!-- ============ Tabs js here ============= -->
 <script>
   document.addEventListener('DOMContentLoaded', () => {
            const tabList = document.querySelector('.tabs-nav');
            const tabs = tabList.querySelectorAll('.tab-button');
            const panels = document.querySelectorAll('.tab-panel');
            const indicator = document.querySelector('.tabs-indicator');

            const setIndicatorPosition = (tab) => {
                indicator.style.transform = `translateX(${tab.offsetLeft}px)`;
                indicator.style.width = `${tab.offsetWidth}px`;
            };

            // Set initial indicator position
            setIndicatorPosition(tabs[0]);

            tabs.forEach((tab) => {
                tab.addEventListener('click', (e) => {
                    const targetTab = e.target;
                    const targetPanel = document.querySelector(
                        `#${targetTab.getAttribute('aria-controls')}`
                    );

                    // Update tabs
                    tabs.forEach((tab) => {
                        tab.setAttribute('aria-selected', false);
                        tab.classList.remove('active');
                    });
                    targetTab.setAttribute('aria-selected', true);
                    targetTab.classList.add('active');

                    // Update panels
                    panels.forEach((panel) => {
                        panel.setAttribute('aria-hidden', true);
                    });
                    targetPanel.setAttribute('aria-hidden', false);

                    // Move indicator
                    setIndicatorPosition(targetTab);
                });
            });

            // Keyboard navigation
            tabList.addEventListener('keydown', (e) => {
                const targetTab = e.target;
                const previousTab = targetTab.previousElementSibling;
                const nextTab = targetTab.nextElementSibling;

                if (e.key === 'ArrowLeft' && previousTab) {
                    previousTab.click();
                    previousTab.focus();
                }
                if (e.key === 'ArrowRight' && nextTab) {
                    nextTab.click();
                    nextTab.focus();
                }
            });
        });
 </script>
<!--===== Herro product slider-JS ====== -->
{{-- Service Share script start ========== --}}
<script>
    function getShareURL(platform) {
        let pageUrl = encodeURIComponent(window.location.href);
        let text = encodeURIComponent("Check out this service!"); 

        let shareUrls = {
            whatsapp: `https://wa.me/?text=${text}%20${pageUrl}`,
            twitter: `https://twitter.com/intent/tweet?text=${text}&url=${pageUrl}`,
            facebook: `https://www.facebook.com/sharer/sharer.php?u=${pageUrl}`,
            instagram: "#", // Instagram does not support direct sharing via URL
            linkedin: `https://www.linkedin.com/sharing/share-offsite/?url=${pageUrl}`
        };

        window.open(shareUrls[platform], "_blank");
    }
</script>

{{-- Service Share script END ========== --}}
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

</script>  
<!-- radio buttons hide and show js -->
<script>
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
</script>

<!-- see more less review detail js here -->
<script>
  // requires jquery
  $(document).ready(function() {
    (function() {
      var showChar = 400; // Number of characters to show by default
      var ellipsestext = "..."; // Ellipses after the truncated text
  
      $(".truncate").each(function() {
        var content = $(this).find("p").html(); // Targeting the content inside <p>
        if (content.length > showChar) {
          var visibleText = content.substr(0, showChar); // Show the initial part
          var hiddenText = content.substr(showChar); // The remaining hidden part
          var html = visibleText + 
            '<span class="moreellipses">' + ellipsestext + 
            '</span><span class="morecontent" style="display:none;">' + hiddenText + 
            '</span>&nbsp;&nbsp;<a href="#" class="moreless more">See more</a>';
  
          $(this).find("p").html(html);
        }
      });
  
      $(".moreless").click(function(e) {
        e.preventDefault();
        var $this = $(this);
        if ($this.hasClass("more")) {
          $this.prev(".morecontent").slideDown(); // Show hidden content
          $this.prev(".moreellipses").hide(); // Hide ellipses
          $this.removeClass("more").addClass("less").text("See less");
        } else {
          $this.prev(".morecontent").slideUp(); // Hide content again
          $this.prev(".moreellipses").show(); // Show ellipses again
          $this.removeClass("less").addClass("more").text("more");
        }
      });
  
    })();
  });
  </script>
  <!-- ===================== UPDATED CODE END ==================== -->
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



  {{-- Appointment Calender Booking ==== Start --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<!-- Load Moment Timezone -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.40/moment-timezone-with-data.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> --}}
  <script type="text/javascript" src="assets/calender/js/mark-your-calendar.js"></script>
  <script type="text/javascript">
 
 










(function ($) {
  
 // Function to generate time slots between start and end times
function generateTimeSlots(startTime, endTime, teacherTimeZone, userTimeZone) {
    let slots = [];
    let start = moment.tz(startTime, "HH:mm", teacherTimeZone);
    let end = moment.tz(endTime, "HH:mm", teacherTimeZone);

    while (start.isBefore(end)) {
        let convertedTime = start.clone().tz(userTimeZone).format("HH:mm");
        slots.push(convertedTime);
        start.add(30, "minutes");
    }

    return slots;
}

// Parsing JSON data from backend
let profile = @json($profile);
let gig = @json($gig);
let gigPayment = @json($gigPayment);
let gigData = @json($gigData);
let duration = @json($admin_duration);
let bookedTimes = @json($bookedTimes) || [];
let repeatDays = @json($repeatDays);
let group_type = $('#group_type').val();
let today = moment();
let selectedDates = {};
let isSubscription = gigData.payment_type === "Subscription";
let maxAllowedDate = isSubscription ? moment().add(1, "month") : null;
let timeZones = moment.tz.zonesForCountry(profile.country_code);
let teacherTimeZone = (timeZones && timeZones.length > 0) ? timeZones[0] : "UTC";
let userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
let startDate = moment(); // Default to current date/time

$(time_zone_show).html(`Show Date/Time Based on ${userTimeZone}`);
$('#user_time_zone').val(userTimeZone);
$('#teacher_time_zone').val(teacherTimeZone);

// Parsing bookedTimes if it's a string
if (typeof bookedTimes === "string") {
    try {
        bookedTimes = JSON.parse(bookedTimes);
    } catch (error) {
        console.error("Error parsing bookedTimes JSON:", error);
        bookedTimes = [];
    }
}

// Ensuring bookedTimes is an array
if (!Array.isArray(bookedTimes)) {
    bookedTimes = Object.values(bookedTimes);
}

// Function to get blocked slots based on booked times
function getBlockedSlots() {
    let blockedSlots = {};
    bookedTimes.forEach((booking) => {
        let { teacher_date, duration } = booking;
        if (!teacher_date || !duration) return;

        teacher_date = moment.tz(teacher_date, teacherTimeZone).tz(userTimeZone).format("YYYY-MM-DD HH:mm");
        let [formattedDate, bookedStartTime] = teacher_date.split(" ");
        bookedStartTime = moment(bookedStartTime, "HH:mm");

        let bookedDurationMinutes = duration.split(":").reduce((h, m) => parseInt(h) * 60 + parseInt(m), 0);
        let serviceDurationMinutes = gigPayment.duration.split(":").reduce((h, m) => parseInt(h) * 60 + parseInt(m), 0);
        let blockStartTime = moment(bookedStartTime).subtract(serviceDurationMinutes, "minutes");

        if (!blockedSlots[formattedDate]) blockedSlots[formattedDate] = new Set();

        let tempBeforeTime = moment(blockStartTime);
        for (let beforeMinutes = serviceDurationMinutes; beforeMinutes > 0; beforeMinutes -= 30) {
            blockedSlots[formattedDate].add(tempBeforeTime.format("HH:mm"));
            tempBeforeTime.add(30, "minutes");
        }

        let tempAfterTime = moment(bookedStartTime);
        for (let afterMinutes = bookedDurationMinutes; afterMinutes > 0; afterMinutes -= 30) {
            blockedSlots[formattedDate].add(tempAfterTime.format("HH:mm"));
            tempAfterTime.add(30, "minutes");
        }
    });
    return blockedSlots;
}

let blockedSlots = getBlockedSlots();

// Function to generate availability slots
function generateAvailability(startDate, teacherTimeZone, userTimeZone) {
    let availability = new Array(30).fill(null).map(() => []);

    for (let i = 0; i < 30; i++) {
        let currentDate = moment(startDate).add(i, "days");
        let dayName = currentDate.format("dddd");
        let formattedDate = currentDate.format("YYYY-MM-DD");
        let nextDayIndex = i + 1;

        let currentDaySlots = [];
        let extendedSlots = [];

        repeatDays.forEach((repeatDay) => {
            if (repeatDay.day === dayName) {
                let slots = generateTimeSlots(repeatDay.start_time, repeatDay.end_time, teacherTimeZone, userTimeZone);

                // Filter blocked slots
                if (blockedSlots[formattedDate]) {
                    slots = slots.filter((slot) => !blockedSlots[formattedDate].has(slot));
                }

                slots.forEach(slot => {
                      if (slot === "00:00" || slot < "04:00") {
                        extendedSlots.push(slot);
                    } else {
                        currentDaySlots.push(slot);
                    }
                });

                if (availability[i].length > 0) {
                    currentDaySlots = [...availability[i], ...currentDaySlots];
                }

                availability[i] = currentDaySlots;

                if (extendedSlots.length > 0 && nextDayIndex < 30) {
                    availability[nextDayIndex] = [...extendedSlots, ...availability[nextDayIndex]];
                }
            }
        });
    }

    return availability;
}

// Determine minimum booking hours based on service type and freelance service
let minBookingHours = 0;

if (gig.service_type === "Online" && gigData.freelance_service === "Normal") {
    minBookingHours = duration.freelance_online_normal || 5;
} else if (gig.service_type === "Online" && gigData.freelance_service === "Consultation") {
    minBookingHours = duration.freelance_online_consultation || 3;
} else if (gig.service_type === "Inperson") {
    minBookingHours = duration.freelance_inperson || 4;
}

// Generate availability slots
let availability;
let currentViewDate = today;

if (gig.service_type === "Online" && gigData.freelance_service === "Normal") {
    // Special handling for Online + Normal: 24/7 availability
    availability = new Array(30).fill(null).map((_, i) => {
        let date = moment().add(i, "days");
        let slots = [];

        let startHour = 0;
        if (i === 0) {
            // For today: start from current time + minimum booking hours
            startHour = moment().tz(userTimeZone).add(minBookingHours, "hours").hour();
        }

        for (let hour = startHour; hour < 24; hour++) {
            slots.push(moment().startOf('day').add(hour, 'hours').format("HH:mm"));
        }

        return slots;
    });
} else {
    // Generate availability for other service types
    availability = generateAvailability(today, teacherTimeZone, userTimeZone);

    // Filter today's slots based on minimum booking hours
    if (availability.length > 0 && availability[0].length > 0) {
        let currentTimePlusMinHours = moment().tz(userTimeZone).add(minBookingHours, "hours").format("HH:mm");
        availability[0] = availability[0].filter(slotTime => slotTime >= currentTimePlusMinHours);
    }
}

// Function to update navigation arrows
function updateNavigationArrows() {
    let isFirstDateToday = currentViewDate.isSame(today, "day");
    let isAtMaxAllowedDate = isSubscription && currentViewDate.isSame(maxAllowedDate, "day");

    $("#myc-prev-week").toggle(!isFirstDateToday);
    $("#myc-next-week").toggle(!(isSubscription && isAtMaxAllowedDate));
}




$("#picker").markyourcalendar({
        availability: availability,
        isMultiple: true,
        startDate: startDate.toDate(),
        onClick: function (ev, data) {
    var frequency = $('#frequency').val() || 1; // Maximum allowed selections
    
    if (gig.service_type == 'Inperson' && gig.freelance_service == 'Normal') {
        if (gigData.freelance_type == 'Both') {
          var duration = gigPayment.duration ;
          duration = duration.split('|*|');
          var freelance_type = $('#freelance_type').val();
          if (freelance_type == 'Basic') {
            duration = duration[0];
          } else {
            duration = duration[1];
            
          }
          
        } else {
          var duration = gigPayment.duration || '00:00'; // Example: "2:30" or "00:30"
        }
          
    } else {
      var duration = gigPayment.duration || '00:00'; // Example: "2:30" or "00:30"
    }
   
    
var durationParts = duration.split(":"); // Split into ["HH", "mm"]

var durationMinutes = (parseInt(durationParts[0]) * 60) + parseInt(durationParts[1])  |'00:00'; // Convert to total minutes
    var selectedDate = moment(ev.date).format("YYYY-MM-DD");

    // Extract the last clicked slot (latest selection)
    let lastClickedSlot = data[data.length - 1]; 
    
    if (!lastClickedSlot) {
      $("#selected-dates").html("");
      
    $("#selected_slots").val(""); // Set class_time to empty
    $("#class_time").val(""); // Set class_time to empty
    $("#teacher_class_time").val("");
    return;
}

    let lastClickedParts = lastClickedSlot.split(" ");
    let lastClickedDateTime = `${lastClickedParts[0]} ${lastClickedParts[1]}`; // Full date and time
    let lastClickedMoment = moment(lastClickedDateTime, "YYYY-MM-DD HH:mm");

    console.log("Last Clicked Date:", lastClickedMoment);
    console.log("Last Clicked Time:", lastClickedDateTime);

    if (!selectedDates[selectedDate]) {
        selectedDates[selectedDate] = [];
    }

  
    let existingSlots = selectedDates[selectedDate];
    
    // ✅ Exclude the last clicked slot from the comparison
    let isInvalid = false;
    for (let slot of existingSlots) {
        if (slot === lastClickedSlot) continue; // Skip comparing with itself

        let slotParts = slot.split(" ");
        let slotDateTime = `${slotParts[0]} ${slotParts[1]}`; // Full date and time
        let slotMoment = moment(slotDateTime, "YYYY-MM-DD HH:mm");
        let diff = Math.abs(lastClickedMoment.diff(slotMoment, "minutes"));
        
     
          
       
    }

   

    if (data.length > frequency) {
        let removedSlot = data.pop(); // Remove last clicked slot
        let removedSlotParts = removedSlot.split(' ');

        // Remove class from the last clicked slot in the UI
        $(`[data-date="${removedSlotParts[0]}"][data-time="${removedSlotParts[1]}"]`).removeClass("selected");

        alert(`You can select maximum ${frequency} slots.`);
    }

    // ✅ Store selected slots in the global object
    selectedDates[selectedDate] = data;

    let selectedValues = [];
    let selectedSlots = [];
    let teacher_time_slots = []; // Store converted times in teacher's time zone
    var html = ``;
    let timePromises = [];
    $.each(selectedDates, function (date, times) {
        $.each(times, function (index, time) {
          
          let userTime = moment.tz(`${time}`, "YYYY-MM-DD HH:mm", userTimeZone);
          let teacherTime = userTime.clone().tz(teacherTimeZone);
          let teacherFormattedTime = teacherTime.format("YYYY-MM-DD HH:mm");
          let duration = '00:00' ;
          // Get duration from gigPayment
          let durationMinutes = duration.split(":").reduce((h, m) => parseInt(h) * 60 + parseInt(m), 0);
          
          // Calculate end time based on USER timezone
          let endTime = userTime.clone().add(durationMinutes, "minutes");
          
          // ✅ Format for display in USER TIMEZONE: "Fri Nov 8, 2024 11am – 11:30am"
          let formattedDisplay = userTime.format("ddd MMM D, YYYY h:mma");
        

          
          let selector = teacherFormattedTime;
          timePromises.push(selector);
          
          teacher_time_slots.push(teacherFormattedTime); // Store converted teacher times
            selectedValues.push(`${time}`);
            selectedSlots.push(`${formattedDisplay}`);
            html += `<p><strong style="color:var(--Colors-Logo-Color, #0072b1);">Start Date & Time:</strong>  ${formattedDisplay}</p>`;
        });
    });


    Promise.allSettled(timePromises).then((results) => {
        let hasError = results.some(r => r.status === "rejected");
        if (hasError) {
          data.pop(); // Remove last clicked slot
            return; // Stop execution if any error occurred
        }
        $("#selected-dates").html(html);
        $("#selected_slots").val(selectedSlots.join("|*|"));
        $("#class_time").val(selectedValues.join(","));
        $("#teacher_class_time").val(teacher_time_slots.join(","));
    });
}
,
onClickNavigator: function (ev, instance) {
    let direction = ev.target.id === "myc-next-week" ? "forward" : "back";

    // Update currentViewDate based on the navigation direction
    if (direction === "back") {
        currentViewDate = moment(currentViewDate).subtract(1, "week");
    } else if (direction === "forward") {
        let nextDate = moment(currentViewDate).add(1, "week");
        if (isSubscription && nextDate.isAfter(maxAllowedDate, "day")) {
            return; // Prevent moving beyond 1 month for subscription
        }
        currentViewDate = nextDate;
    }

    // Generate a 7-day availability range for the current view date
    let newAvailability = [];
    for (let i = 0; i < 7; i++) {
        let currentDate = moment(currentViewDate).add(i, "days");
        let formattedDate = currentDate.format("YYYY-MM-DD");
        let dayName = currentDate.format("dddd");
        let slots = [];

        // Handle 24-hour availability for Online + Normal services
        if (gig.service_type === "Online" && gigData.freelance_service === "Normal") {
            let startHour = 0;
            if (currentDate.isSame(today, "day")) {
                startHour = moment().tz(userTimeZone).add(minBookingHours, "hours").hour();
            }
            for (let hour = startHour; hour < 24; hour++) {
                slots.push(moment().startOf('day').add(hour, 'hours').format("HH:mm"));
            }
        } else {
            // Regular availability based on repeatDays
            repeatDays.forEach((repeatDay) => {
                if (repeatDay.day === dayName) {
                    let daySlots = generateTimeSlots(repeatDay.start_time, repeatDay.end_time, teacherTimeZone, userTimeZone);
                    
                    // Filter out blocked slots
                    if (blockedSlots[formattedDate]) {
                        daySlots = daySlots.filter((slot) => !blockedSlots[formattedDate].has(slot));
                    }

                    slots.push(...daySlots);
                }
            });
        }

        newAvailability.push(slots);
    }

    instance.setAvailability(newAvailability);

    // ✅ Update navigation arrows
    updateNavigationArrows();

    // Reapply the selected class to slots for the current date
    setTimeout(() => {
        $.each(selectedDates, function (date, times) {
            $.each(times, function (index, time) {
                let [selectedDate, selectedTime] = time.split(' ');
                $(`[data-date="${selectedDate}"][data-time="${selectedTime}"]`).addClass("selected");
            });
        });
    }, 100);
}


    });

    // Hide previous navigation arrow on page load (since the calendar starts from today)
    $("#myc-prev-week").hide();
    
 

 


})(jQuery);


  </script>
  

  {{-- Appointment Calender Booking ==== END --}}

