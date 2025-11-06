<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <!-- View Point scale to 1.0 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Animate css -->
    <link rel="stylesheet" href="assets/teacher/libs/animate/css/animate.css" />
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="assets/teacher/libs/aos/css/aos.css" />
    <!-- Datatable css  -->
    <link rel="stylesheet" href="assets/teacher/libs/datatable/css/datatable.css" />
     {{-- Fav Icon --}}
     @php  $home = \App\Models\HomeDynamic::first(); @endphp
     @if ($home)
         <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
     @endif
     <!-- Select2 css -->
    <link href="assets/teacher/libs/select2/css/select2.min.css" rel="stylesheet" />
    <!-- Owl carousel css -->
    <link href="assets/teacher/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
    <link href="assets/teacher/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
    <!-- Bootstrap css -->
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/teacher/asset/css/bootstrap.min.css"
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

    <link rel="stylesheet" href="assets/teacher/asset/css/payment.css" />
    <link
      rel=" stylesheet "
      type=" text/css "
      href="assets/teacher/asset/css/class-management.css"
    />
     <!-- jQuery -->
     <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        
     <!-- jQuery (required) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery Timepicker Plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.min.css">


     {{-- =======Toastr CDN ======== --}}
     <link rel="stylesheet" type="text/css" 
     href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
 
     <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
     {{-- =======Toastr CDN ======== --}}
    <link rel=" stylesheet " href=" assets/teacher/asset/css/Learn-How.css " />
    <link rel="stylesheet" href="assets/teacher/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/teacher/asset/css/style.css" />
    <!-- Include Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <title>Payment</title>
  </head>

  <style>
    .repeat-btn.active{
      background-color: #0072b1;
      color: white;
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
  
    {{-- ===========Teacher Sidebar Start==================== --}}
  <x-teacher-sidebar/>
  {{-- ===========Teacher Sidebar End==================== --}}
  <section class="home-section">
     {{-- ===========Teacher NavBar Start==================== --}}
     <x-teacher-nav/>
     {{-- ===========Teacher NavBar End==================== --}}
      <!-- =============================== MAIN CONTENT START HERE =========================== -->
      <div class="container-fluid">
        <div class="row payment-page">
          <div class="col-md-12">
            <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
              <ol class="breadcrumb mt-3">
                <li
                  class="breadcrumb-item active braedDashboard"
                  aria-current="page"
                >
                  <a href="#">Dashboard</a>
                </li>
                <li class="breadcrumb-item braedClassManagment">
                  <a href="">Class Managements</a>
                </li>
              </ol>
            </nav>
          </div>
          <div class="col-md-12">
            <div class="onlineClass-banner">
              <img src="assets/teacher/asset/img/banner-icon.png" alt="" />
              <span>Dynamic Management</span>
            </div>
          </div>

          <form id="myForm" action="/class-gig-payment-upload" method="POST" enctype="multipart/form-data"> @csrf
            
          <div class="col-md-12">
            <div class="row payment-type mx-1 my-3">
              <div class="col-md-12">
                <h3 class="online-Class-Select-Heading">Payment Type</h3>
                <div class="select-box">
                  <input type="hidden" name="gig_id" value="{{$gig_id}}">
                  <select name="payment_type" id=" sample " class="fa">
                    @if ($gigData->payment_type == 'OneOff')
                    <option value="OneOff" class="fa" selected>   One-Of Payment </option>
                        
                    @else
                    <option value="Subscription" class="fa" selected>Subscription</option>
                        
                    @endif
                  </select>
                </div>
              </div>



              @if ($gigData->freelance_type == 'Both')



              @if ($gig->service_type == 'Inperson' && $gigData->freelance_service == 'Normal')
                  

              <div class="col-md-6 col-sm-12">
                <h3
                  class="online-Class-Select-Heading"
                  style="margin-top: 24px"
                >
                  Duration (Basic)
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    viewBox="0 0 16 16"
                    fill="none"
                  >
                    <path
                      d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 13.5C6.91221 13.5 5.84884 13.1774 4.94437 12.5731C4.0399 11.9687 3.33495 11.1098 2.91867 10.1048C2.50238 9.09977 2.39347 7.9939 2.60568 6.927C2.8179 5.86011 3.34173 4.8801 4.11092 4.11091C4.8801 3.34172 5.86011 2.8179 6.92701 2.60568C7.9939 2.39346 9.09977 2.50238 10.1048 2.91866C11.1098 3.33494 11.9687 4.03989 12.5731 4.94436C13.1774 5.84883 13.5 6.9122 13.5 8C13.4983 9.45818 12.9184 10.8562 11.8873 11.8873C10.8562 12.9184 9.45819 13.4983 8 13.5ZM9 11C9 11.1326 8.94732 11.2598 8.85356 11.3536C8.75979 11.4473 8.63261 11.5 8.5 11.5C8.23479 11.5 7.98043 11.3946 7.7929 11.2071C7.60536 11.0196 7.5 10.7652 7.5 10.5V8C7.36739 8 7.24022 7.94732 7.14645 7.85355C7.05268 7.75979 7 7.63261 7 7.5C7 7.36739 7.05268 7.24021 7.14645 7.14645C7.24022 7.05268 7.36739 7 7.5 7C7.76522 7 8.01957 7.10536 8.20711 7.29289C8.39465 7.48043 8.5 7.73478 8.5 8V10.5C8.63261 10.5 8.75979 10.5527 8.85356 10.6464C8.94732 10.7402 9 10.8674 9 11ZM7 5.25C7 5.10166 7.04399 4.95666 7.1264 4.83332C7.20881 4.70999 7.32595 4.61386 7.46299 4.55709C7.60003 4.50032 7.75083 4.48547 7.89632 4.51441C8.04181 4.54335 8.17544 4.61478 8.28033 4.71967C8.38522 4.82456 8.45665 4.9582 8.48559 5.10368C8.51453 5.24917 8.49968 5.39997 8.44291 5.53701C8.38615 5.67406 8.29002 5.79119 8.16668 5.8736C8.04334 5.95601 7.89834 6 7.75 6C7.55109 6 7.36032 5.92098 7.21967 5.78033C7.07902 5.63968 7 5.44891 7 5.25Z"
                      fill="#0072B1"
                    />
                  </svg>
                </h3>

                <div class="durationMain-section">
                  
              <select name="durationH" id="durationH" class="fa">
                   <option  value="00" class="fa">00</option>
                    @for ($i = 1; $i <= 10; $i++)
                    <option  value="{{$i}}" class="fa">{{$i}}</option>
                        
                    @endfor 
                  </select>
                  <span>Hr</span>
               
             
                  <select name="durationM" id="durationM" class="fa">
                   
                    <option  value="00" class="fa">00</option>
                    <option  value="30" class="fa">30</option>
                     
                  </select>
                  <span>Mi</span>
                  
                </div>
              </div>

              @else

                 <div class="col-md-6 col-sm-12">
                <h3
                  class="online-Class-Select-Heading"
                  style="margin-top: 24px"
                >
                  Delivery Time (Basic)
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    viewBox="0 0 16 16"
                    fill="none"
                  >
                    <path
                      d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 13.5C6.91221 13.5 5.84884 13.1774 4.94437 12.5731C4.0399 11.9687 3.33495 11.1098 2.91867 10.1048C2.50238 9.09977 2.39347 7.9939 2.60568 6.927C2.8179 5.86011 3.34173 4.8801 4.11092 4.11091C4.8801 3.34172 5.86011 2.8179 6.92701 2.60568C7.9939 2.39346 9.09977 2.50238 10.1048 2.91866C11.1098 3.33494 11.9687 4.03989 12.5731 4.94436C13.1774 5.84883 13.5 6.9122 13.5 8C13.4983 9.45818 12.9184 10.8562 11.8873 11.8873C10.8562 12.9184 9.45819 13.4983 8 13.5ZM9 11C9 11.1326 8.94732 11.2598 8.85356 11.3536C8.75979 11.4473 8.63261 11.5 8.5 11.5C8.23479 11.5 7.98043 11.3946 7.7929 11.2071C7.60536 11.0196 7.5 10.7652 7.5 10.5V8C7.36739 8 7.24022 7.94732 7.14645 7.85355C7.05268 7.75979 7 7.63261 7 7.5C7 7.36739 7.05268 7.24021 7.14645 7.14645C7.24022 7.05268 7.36739 7 7.5 7C7.76522 7 8.01957 7.10536 8.20711 7.29289C8.39465 7.48043 8.5 7.73478 8.5 8V10.5C8.63261 10.5 8.75979 10.5527 8.85356 10.6464C8.94732 10.7402 9 10.8674 9 11ZM7 5.25C7 5.10166 7.04399 4.95666 7.1264 4.83332C7.20881 4.70999 7.32595 4.61386 7.46299 4.55709C7.60003 4.50032 7.75083 4.48547 7.89632 4.51441C8.04181 4.54335 8.17544 4.61478 8.28033 4.71967C8.38522 4.82456 8.45665 4.9582 8.48559 5.10368C8.51453 5.24917 8.49968 5.39997 8.44291 5.53701C8.38615 5.67406 8.29002 5.79119 8.16668 5.8736C8.04334 5.95601 7.89834 6 7.75 6C7.55109 6 7.36032 5.92098 7.21967 5.78033C7.07902 5.63968 7 5.44891 7 5.25Z"
                      fill="#0072B1"
                    />
                  </svg>
                </h3>

                <div class="durationMain-section">
                  <span class="Duration-text">Up to</span>
                  <div class="Duration-time">
                    <input
                      class="Duration-input"
                      placeholder="12" id="delivery_time" name="delivery_time" style="width: 70px;"
                      type="number"
                    />Days
                  </div>
                </div>
              </div>
                  
              @endif

           


              <div class="col-md-6 col-sm-12" style="margin-top: 30px !important">
               
                  <h3 class="online-Class-Select-Heading">Revision (Basic)</h3>
                  <div class="select-box">
                    <select name="revision" id="revision" class="fa"> 
                      <option value="N/A"  class="fa">N/A</option>
                      @for ($i = 1; $i <= 20; $i++)
                      <option value="{{$i}}"  class="fa">{{$i}}</option>
                      @endfor
                      <option value="Unlimited"  class="fa">Unlimited</option>
                      
                    </select>
                  </div>
                 
              </div>


              @if ($gig->service_type == 'Inperson' && $gigData->freelance_service == 'Normal')
                  
               <div class="col-md-6 col-sm-12">
                <h3
                  class="online-Class-Select-Heading"
                  style="margin-top: 24px"
                >
                  Duration (Premium)
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    viewBox="0 0 16 16"
                    fill="none"
                  >
                    <path
                      d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 13.5C6.91221 13.5 5.84884 13.1774 4.94437 12.5731C4.0399 11.9687 3.33495 11.1098 2.91867 10.1048C2.50238 9.09977 2.39347 7.9939 2.60568 6.927C2.8179 5.86011 3.34173 4.8801 4.11092 4.11091C4.8801 3.34172 5.86011 2.8179 6.92701 2.60568C7.9939 2.39346 9.09977 2.50238 10.1048 2.91866C11.1098 3.33494 11.9687 4.03989 12.5731 4.94436C13.1774 5.84883 13.5 6.9122 13.5 8C13.4983 9.45818 12.9184 10.8562 11.8873 11.8873C10.8562 12.9184 9.45819 13.4983 8 13.5ZM9 11C9 11.1326 8.94732 11.2598 8.85356 11.3536C8.75979 11.4473 8.63261 11.5 8.5 11.5C8.23479 11.5 7.98043 11.3946 7.7929 11.2071C7.60536 11.0196 7.5 10.7652 7.5 10.5V8C7.36739 8 7.24022 7.94732 7.14645 7.85355C7.05268 7.75979 7 7.63261 7 7.5C7 7.36739 7.05268 7.24021 7.14645 7.14645C7.24022 7.05268 7.36739 7 7.5 7C7.76522 7 8.01957 7.10536 8.20711 7.29289C8.39465 7.48043 8.5 7.73478 8.5 8V10.5C8.63261 10.5 8.75979 10.5527 8.85356 10.6464C8.94732 10.7402 9 10.8674 9 11ZM7 5.25C7 5.10166 7.04399 4.95666 7.1264 4.83332C7.20881 4.70999 7.32595 4.61386 7.46299 4.55709C7.60003 4.50032 7.75083 4.48547 7.89632 4.51441C8.04181 4.54335 8.17544 4.61478 8.28033 4.71967C8.38522 4.82456 8.45665 4.9582 8.48559 5.10368C8.51453 5.24917 8.49968 5.39997 8.44291 5.53701C8.38615 5.67406 8.29002 5.79119 8.16668 5.8736C8.04334 5.95601 7.89834 6 7.75 6C7.55109 6 7.36032 5.92098 7.21967 5.78033C7.07902 5.63968 7 5.44891 7 5.25Z"
                      fill="#0072B1"
                    />
                  </svg>
                </h3>

                <div class="durationMain-section">
                  
                 
                    <select name="durationH_2" id="durationH_2" class="fa">
                     <option  value="00" class="fa">00</option>
                    @for ($i = 1; $i <= 10; $i++)
                    <option  value="{{$i}}" class="fa">{{$i}}</option>
                        
                    @endfor 
                  </select>
                  <span>Hr</span>
               
             
                  <select name="durationM_2" id="durationM_2" class="fa">
                  
                    <option  value="00" class="fa">00</option>
                    <option  value="30" class="fa">30</option>
                     
                  </select>
                  <span>Mi</span>

                </div>
              </div>

              @else


               <div class="col-md-6 col-sm-12">
                <h3
                  class="online-Class-Select-Heading"
                  style="margin-top: 24px"
                >
                  Delivery Time (Premium)
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    viewBox="0 0 16 16"
                    fill="none"
                  >
                    <path
                      d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 13.5C6.91221 13.5 5.84884 13.1774 4.94437 12.5731C4.0399 11.9687 3.33495 11.1098 2.91867 10.1048C2.50238 9.09977 2.39347 7.9939 2.60568 6.927C2.8179 5.86011 3.34173 4.8801 4.11092 4.11091C4.8801 3.34172 5.86011 2.8179 6.92701 2.60568C7.9939 2.39346 9.09977 2.50238 10.1048 2.91866C11.1098 3.33494 11.9687 4.03989 12.5731 4.94436C13.1774 5.84883 13.5 6.9122 13.5 8C13.4983 9.45818 12.9184 10.8562 11.8873 11.8873C10.8562 12.9184 9.45819 13.4983 8 13.5ZM9 11C9 11.1326 8.94732 11.2598 8.85356 11.3536C8.75979 11.4473 8.63261 11.5 8.5 11.5C8.23479 11.5 7.98043 11.3946 7.7929 11.2071C7.60536 11.0196 7.5 10.7652 7.5 10.5V8C7.36739 8 7.24022 7.94732 7.14645 7.85355C7.05268 7.75979 7 7.63261 7 7.5C7 7.36739 7.05268 7.24021 7.14645 7.14645C7.24022 7.05268 7.36739 7 7.5 7C7.76522 7 8.01957 7.10536 8.20711 7.29289C8.39465 7.48043 8.5 7.73478 8.5 8V10.5C8.63261 10.5 8.75979 10.5527 8.85356 10.6464C8.94732 10.7402 9 10.8674 9 11ZM7 5.25C7 5.10166 7.04399 4.95666 7.1264 4.83332C7.20881 4.70999 7.32595 4.61386 7.46299 4.55709C7.60003 4.50032 7.75083 4.48547 7.89632 4.51441C8.04181 4.54335 8.17544 4.61478 8.28033 4.71967C8.38522 4.82456 8.45665 4.9582 8.48559 5.10368C8.51453 5.24917 8.49968 5.39997 8.44291 5.53701C8.38615 5.67406 8.29002 5.79119 8.16668 5.8736C8.04334 5.95601 7.89834 6 7.75 6C7.55109 6 7.36032 5.92098 7.21967 5.78033C7.07902 5.63968 7 5.44891 7 5.25Z"
                      fill="#0072B1"
                    />
                  </svg>
                </h3>

                <div class="durationMain-section">
                  <span class="Duration-text">Up to</span>
                  <div class="Duration-time">
                    <input
                      class="Duration-input"
                      placeholder="12" id="delivery_time_2" name="delivery_time_2" style="width: 70px;"
                      type="number"
                    />Days
                  </div>
                </div>
              </div>
                  
              @endif


             


              <div class="col-md-6 col-sm-12" style="margin-top: 30px !important">
               
                  <h3 class="online-Class-Select-Heading">Revision (Premium)</h3>
                  <div class="select-box">
                    <select name="revision_2" id="revision_2" class="fa"> 
                      <option value="N/A"  class="fa">N/A</option>
                      @for ($i = 1; $i <= 20; $i++)
                      <option value="{{$i}}"  class="fa">{{$i}}</option>
                      @endfor
                      <option value="Unlimited"  class="fa">Unlimited</option>
                      
                    </select>
                  </div>
                 
              </div>




              <div class="row">
                <h3
                  class="online-Class-Select-Heading"
                  style="margin-top: 24px"
                >
                  How much would you charge for the service?
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    viewBox="0 0 16 16"
                    fill="none"
                  >
                    <path
                      d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 13.5C6.91221 13.5 5.84884 13.1774 4.94437 12.5731C4.0399 11.9687 3.33495 11.1098 2.91867 10.1048C2.50238 9.09977 2.39347 7.9939 2.60568 6.927C2.8179 5.86011 3.34173 4.8801 4.11092 4.11091C4.8801 3.34172 5.86011 2.8179 6.92701 2.60568C7.9939 2.39346 9.09977 2.50238 10.1048 2.91866C11.1098 3.33494 11.9687 4.03989 12.5731 4.94436C13.1774 5.84883 13.5 6.9122 13.5 8C13.4983 9.45818 12.9184 10.8562 11.8873 11.8873C10.8562 12.9184 9.45819 13.4983 8 13.5ZM9 11C9 11.1326 8.94732 11.2598 8.85356 11.3536C8.75979 11.4473 8.63261 11.5 8.5 11.5C8.23479 11.5 7.98043 11.3946 7.7929 11.2071C7.60536 11.0196 7.5 10.7652 7.5 10.5V8C7.36739 8 7.24022 7.94732 7.14645 7.85355C7.05268 7.75979 7 7.63261 7 7.5C7 7.36739 7.05268 7.24021 7.14645 7.14645C7.24022 7.05268 7.36739 7 7.5 7C7.76522 7 8.01957 7.10536 8.20711 7.29289C8.39465 7.48043 8.5 7.73478 8.5 8V10.5C8.63261 10.5 8.75979 10.5527 8.85356 10.6464C8.94732 10.7402 9 10.8674 9 11ZM7 5.25C7 5.10166 7.04399 4.95666 7.1264 4.83332C7.20881 4.70999 7.32595 4.61386 7.46299 4.55709C7.60003 4.50032 7.75083 4.48547 7.89632 4.51441C8.04181 4.54335 8.17544 4.61478 8.28033 4.71967C8.38522 4.82456 8.45665 4.9582 8.48559 5.10368C8.51453 5.24917 8.49968 5.39997 8.44291 5.53701C8.38615 5.67406 8.29002 5.79119 8.16668 5.8736C8.04334 5.95601 7.89834 6 7.75 6C7.55109 6 7.36032 5.92098 7.21967 5.78033C7.07902 5.63968 7 5.44891 7 5.25Z"
                      fill="#0072B1"
                    />
                  </svg>
                </h3>
                <div class="col-md-6 col-sm-12">
                  <h3
                    class="online-Class-Select-Heading"
                    style="margin-top: 16px"
                  >
                    Individual rate (Basic)
                  </h3>
                  <input class="payment-input" name="rate" id="rate" placeholder="$50" type="number"  onfocusout="validateRatePrice(this)" />
                </div>
                <div class="col-md-6 col-sm-12">
                  <h3
                    class="online-Class-Select-Heading"
                    style="margin-top: 16px"
                  >
                    Your estimated Earnings (Basic)
                  </h3>
                  <input class="payment-input" name="earning" id="estimated_earning" placeholder="$50" readonly type="text" />
                </div>
                
              </div>




              <div class="row">
                 
                <div class="col-md-6 col-sm-12">
                  <h3
                    class="online-Class-Select-Heading"
                    style="margin-top: 16px"
                  >
                    Individual rate (Premium)
                  </h3>
                  <input class="payment-input" name="rate_2" id="rate_2" placeholder="$50" type="number"  onfocusout="validateRatePrice(this)" />
                </div>
                <div class="col-md-6 col-sm-12">
                  <h3
                    class="online-Class-Select-Heading"
                    style="margin-top: 16px"
                  >
                    Your estimated Earnings (Premium)
                  </h3>
                  <input class="payment-input" name="earning_2" id="estimated_earning_2" placeholder="$50" readonly type="text" />
                </div>
                <p
                  class="timeDurationdetile"
                  style="margin-top: 10px !important"
                >
                  <span>Remember :</span> we take a 15% cut on each booking made
                  by guests. We have estimated your earnings to 80%. You will
                  likely earn more after our payment processing partner (Stripe)
                  has taken their cut for processing payments. Additional taxes
                  may also apply.
                </p>
              </div>








                  
              @else

              {{-- Not Freelance Type is Both --}}

              @if ($gig->service_type == 'Inperson' && $gigData->freelance_service == 'Normal')
                  

                <div class="col-md-6 col-sm-12">
                <h3
                  class="online-Class-Select-Heading"
                  style="margin-top: 24px"
                >
                  Duration
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    viewBox="0 0 16 16"
                    fill="none"
                  >
                    <path
                      d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 13.5C6.91221 13.5 5.84884 13.1774 4.94437 12.5731C4.0399 11.9687 3.33495 11.1098 2.91867 10.1048C2.50238 9.09977 2.39347 7.9939 2.60568 6.927C2.8179 5.86011 3.34173 4.8801 4.11092 4.11091C4.8801 3.34172 5.86011 2.8179 6.92701 2.60568C7.9939 2.39346 9.09977 2.50238 10.1048 2.91866C11.1098 3.33494 11.9687 4.03989 12.5731 4.94436C13.1774 5.84883 13.5 6.9122 13.5 8C13.4983 9.45818 12.9184 10.8562 11.8873 11.8873C10.8562 12.9184 9.45819 13.4983 8 13.5ZM9 11C9 11.1326 8.94732 11.2598 8.85356 11.3536C8.75979 11.4473 8.63261 11.5 8.5 11.5C8.23479 11.5 7.98043 11.3946 7.7929 11.2071C7.60536 11.0196 7.5 10.7652 7.5 10.5V8C7.36739 8 7.24022 7.94732 7.14645 7.85355C7.05268 7.75979 7 7.63261 7 7.5C7 7.36739 7.05268 7.24021 7.14645 7.14645C7.24022 7.05268 7.36739 7 7.5 7C7.76522 7 8.01957 7.10536 8.20711 7.29289C8.39465 7.48043 8.5 7.73478 8.5 8V10.5C8.63261 10.5 8.75979 10.5527 8.85356 10.6464C8.94732 10.7402 9 10.8674 9 11ZM7 5.25C7 5.10166 7.04399 4.95666 7.1264 4.83332C7.20881 4.70999 7.32595 4.61386 7.46299 4.55709C7.60003 4.50032 7.75083 4.48547 7.89632 4.51441C8.04181 4.54335 8.17544 4.61478 8.28033 4.71967C8.38522 4.82456 8.45665 4.9582 8.48559 5.10368C8.51453 5.24917 8.49968 5.39997 8.44291 5.53701C8.38615 5.67406 8.29002 5.79119 8.16668 5.8736C8.04334 5.95601 7.89834 6 7.75 6C7.55109 6 7.36032 5.92098 7.21967 5.78033C7.07902 5.63968 7 5.44891 7 5.25Z"
                      fill="#0072B1"
                    />
                  </svg>
                </h3>

                <div class="durationMain-section">
                 
                  
                    <select name="durationH" id="durationH" class="fa">
                    <option  value="00" class="fa">00</option>
                    @for ($i = 1; $i <= 10; $i++)
                    <option  value="{{$i}}" class="fa">{{$i}}</option>
                        
                    @endfor 
                  </select>
                  <span>Hr</span>
               
             
                  <select name="durationM" id="durationM" class="fa">
                 
                    <option  value="00" class="fa">00</option>
                    <option  value="30" class="fa">30</option>
                     
                  </select>
                  <span>Mi</span>

                </div>
              </div>

              @else
                  
                <div class="col-md-6 col-sm-12">
                <h3
                  class="online-Class-Select-Heading"
                  style="margin-top: 24px"
                >
                  Delivery Time
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    viewBox="0 0 16 16"
                    fill="none"
                  >
                    <path
                      d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 13.5C6.91221 13.5 5.84884 13.1774 4.94437 12.5731C4.0399 11.9687 3.33495 11.1098 2.91867 10.1048C2.50238 9.09977 2.39347 7.9939 2.60568 6.927C2.8179 5.86011 3.34173 4.8801 4.11092 4.11091C4.8801 3.34172 5.86011 2.8179 6.92701 2.60568C7.9939 2.39346 9.09977 2.50238 10.1048 2.91866C11.1098 3.33494 11.9687 4.03989 12.5731 4.94436C13.1774 5.84883 13.5 6.9122 13.5 8C13.4983 9.45818 12.9184 10.8562 11.8873 11.8873C10.8562 12.9184 9.45819 13.4983 8 13.5ZM9 11C9 11.1326 8.94732 11.2598 8.85356 11.3536C8.75979 11.4473 8.63261 11.5 8.5 11.5C8.23479 11.5 7.98043 11.3946 7.7929 11.2071C7.60536 11.0196 7.5 10.7652 7.5 10.5V8C7.36739 8 7.24022 7.94732 7.14645 7.85355C7.05268 7.75979 7 7.63261 7 7.5C7 7.36739 7.05268 7.24021 7.14645 7.14645C7.24022 7.05268 7.36739 7 7.5 7C7.76522 7 8.01957 7.10536 8.20711 7.29289C8.39465 7.48043 8.5 7.73478 8.5 8V10.5C8.63261 10.5 8.75979 10.5527 8.85356 10.6464C8.94732 10.7402 9 10.8674 9 11ZM7 5.25C7 5.10166 7.04399 4.95666 7.1264 4.83332C7.20881 4.70999 7.32595 4.61386 7.46299 4.55709C7.60003 4.50032 7.75083 4.48547 7.89632 4.51441C8.04181 4.54335 8.17544 4.61478 8.28033 4.71967C8.38522 4.82456 8.45665 4.9582 8.48559 5.10368C8.51453 5.24917 8.49968 5.39997 8.44291 5.53701C8.38615 5.67406 8.29002 5.79119 8.16668 5.8736C8.04334 5.95601 7.89834 6 7.75 6C7.55109 6 7.36032 5.92098 7.21967 5.78033C7.07902 5.63968 7 5.44891 7 5.25Z"
                      fill="#0072B1"
                    />
                  </svg>
                </h3>

                <div class="durationMain-section">
                  <span class="Duration-text">Up to</span>
                  <div class="Duration-time">
                    <input
                      class="Duration-input"
                      placeholder="12" id="delivery_time" name="delivery_time" style="width: 70px;"
                      type="number"
                    />Days
                  </div>
                </div>
              </div>

              @endif

            


              <div class="col-md-6 col-sm-12" style="margin-top: 30px !important">
               
                  <h3 class="online-Class-Select-Heading">Revision</h3>
                  <div class="select-box">
                    <select name="revision" id="revision" class="fa"> 
                      <option value="N/A"  class="fa">N/A</option>
                      @for ($i = 1; $i <= 20; $i++)
                      <option value="{{$i}}"  class="fa">{{$i}}</option>
                      @endfor
                      <option value="Unlimited"  class="fa">Unlimited</option>
                      
                    </select>
                  </div>
                 
              </div>



              <div class="row">
                <h3
                  class="online-Class-Select-Heading"
                  style="margin-top: 24px"
                >
                  How much would you charge for the service?
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    viewBox="0 0 16 16"
                    fill="none"
                  >
                    <path
                      d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 13.5C6.91221 13.5 5.84884 13.1774 4.94437 12.5731C4.0399 11.9687 3.33495 11.1098 2.91867 10.1048C2.50238 9.09977 2.39347 7.9939 2.60568 6.927C2.8179 5.86011 3.34173 4.8801 4.11092 4.11091C4.8801 3.34172 5.86011 2.8179 6.92701 2.60568C7.9939 2.39346 9.09977 2.50238 10.1048 2.91866C11.1098 3.33494 11.9687 4.03989 12.5731 4.94436C13.1774 5.84883 13.5 6.9122 13.5 8C13.4983 9.45818 12.9184 10.8562 11.8873 11.8873C10.8562 12.9184 9.45819 13.4983 8 13.5ZM9 11C9 11.1326 8.94732 11.2598 8.85356 11.3536C8.75979 11.4473 8.63261 11.5 8.5 11.5C8.23479 11.5 7.98043 11.3946 7.7929 11.2071C7.60536 11.0196 7.5 10.7652 7.5 10.5V8C7.36739 8 7.24022 7.94732 7.14645 7.85355C7.05268 7.75979 7 7.63261 7 7.5C7 7.36739 7.05268 7.24021 7.14645 7.14645C7.24022 7.05268 7.36739 7 7.5 7C7.76522 7 8.01957 7.10536 8.20711 7.29289C8.39465 7.48043 8.5 7.73478 8.5 8V10.5C8.63261 10.5 8.75979 10.5527 8.85356 10.6464C8.94732 10.7402 9 10.8674 9 11ZM7 5.25C7 5.10166 7.04399 4.95666 7.1264 4.83332C7.20881 4.70999 7.32595 4.61386 7.46299 4.55709C7.60003 4.50032 7.75083 4.48547 7.89632 4.51441C8.04181 4.54335 8.17544 4.61478 8.28033 4.71967C8.38522 4.82456 8.45665 4.9582 8.48559 5.10368C8.51453 5.24917 8.49968 5.39997 8.44291 5.53701C8.38615 5.67406 8.29002 5.79119 8.16668 5.8736C8.04334 5.95601 7.89834 6 7.75 6C7.55109 6 7.36032 5.92098 7.21967 5.78033C7.07902 5.63968 7 5.44891 7 5.25Z"
                      fill="#0072B1"
                    />
                  </svg>
                </h3>
                <div class="col-md-6 col-sm-12">
                  <h3
                    class="online-Class-Select-Heading"
                    style="margin-top: 16px"
                  >
                    Individual rate
                  </h3>
                  <input class="payment-input" name="rate" id="rate" placeholder="$50" type="number"  onfocusout="validateRatePrice(this)" />
                </div>
                <div class="col-md-6 col-sm-12">
                  <h3
                    class="online-Class-Select-Heading"
                    style="margin-top: 16px"
                  >
                    Your estimated Earnings 
                  </h3>
                  <input class="payment-input" name="earning" id="estimated_earning" placeholder="$50" readonly type="text" />
                </div>
                <p
                  class="timeDurationdetile"
                  style="margin-top: 10px !important"
                >
                  <span>Remember :</span> we take a 15% cut on each booking made
                  by guests. We have estimated your earnings to 80%. You will
                  likely earn more after our payment processing partner (Stripe)
                  has taken their cut for processing payments. Additional taxes
                  may also apply.
                </p>
              </div>




                  
              @endif


              


              
            </div>
          </div>

          {{-- <div class="col-md-12">
            <div class="row payment-type mx-1 my-3">
              <div class="col-md-12">
                <h3 class="online-Class-Select-Heading">
                  Positive Search Terms (Optional)
                </h3>

                <textarea
                  class="form-control form-control-textarea"
                  placeholder="Positive Search Terms"
                  id="floatingTextarea2"
                  style="height: 100px"
                ></textarea>
              </div>
            </div>
          </div> --}}

          <div class="col-md-12">
            <div class="row payment-type mx-1 my-3">
              <div class="col-md-12">
                <h3 class="online-Class-Select-Heading">
                  Positive Search Terms (Optional)
                </h3>

                <input
                type="text"
                class="form-control  payment-input"
                id="input_positive_term"
                placeholder="Type and press Enter or comma......"
              />

              <input type="hidden" name="positive_term" id="positive_term">
              <div id="positive_term_div" style="display: flex;gap: 10px;"></div>
                
              </div>
            </div>
          </div>



           {{-- Faqs Start ==== --}}
           <div class="col-md-12">
            <div class="row payment-type mx-1 my-3">
              <div class="col-md-12">
                <h3 class="online-Class-Select-Heading">
                  Services FAQ'S (Optional)
                </h3>
               
                <button id="add_new_btn"  class="teacher-next-btn float-end mb-3" >Add</button>


                <div class="row mt-3 mb-3" id="add_faqs_main_div" style="display: none">
                 
                    <div class="col-12 form-sec">
                      <label for="inputAddress2" class="form-label online-Class-Select-Heading"
                        >Question</label
                      > 
                      <input type="hidden" value="{{$gig->id}}" name="faqs_gig_id" id="faqs_gig_id">
                      <input
                        type="text"
                        class="form-control payment-input"
                        id="question" name="question"
                        placeholder="How This Work?" required
                      />
                    </div>
                    <div class="col-12 mt-0 mb-3">
                      <label for="inputAddress2" class="form-label online-Class-Select-Heading"
                        >Answer</label
                      >
                      <br />
                      <textarea id="answer" name="answer"></textarea>
                    </div>

                    <div class="api-buttons">
                      <div class="row">
                        <div class="col-md-12">
                        
                          <button type="button" id="add_faqs_btn" class="btn float-end update-btn teacher-next-btn">
                            Add New
                          </button>
                        </div>
                      </div>
                    </div>
                    
                </div>

               


                <div id="all_faqs" class="mb-3">
                  
                </div>

                <div class="row mt-3 mb-3" id="edit_faqs_main_div" style="display: none">
                 
                  <div class="col-12 form-sec">
                    <label for="inputAddress2" class="form-label online-Class-Select-Heading"
                      >Question</label
                    > 
                    <input type="hidden" name="faqs_id" id="faqs_id" >
                    <input
                      type="text"
                      class="form-control payment-input"
                      id="question_upd" name="question_upd"
                      placeholder="How This Work?" required
                    />
                  </div>
                  <div class="col-12 mt-0 mb-3">
                    <label for="inputAddress2" class="form-label online-Class-Select-Heading"
                      >Answer</label
                    >
                    <br />
                    <textarea id="answer_upd" name="answer_upd"></textarea>
                  </div>

                  <div class="api-buttons">
                    <div class="row">
                      <div class="col-md-12">
                      
                        <button type="button" id="edit_faqs_btn" class="btn float-end update-btn teacher-next-btn">
                          Update
                        </button>
                      </div>
                    </div>
                  </div>
                  
              </div>

               
              </div>
                
              </div>
            </div> 

              {{-- Faqs END ==== --}}





          <div class="col-md-12">
            <div class="row payment-type mx-1 my-3">
              <div class="col-md-12">
                {{-- <h3
                  class="online-Class-Select-Heading"
                  style="margin-top: 24px"
                >
                  How much would you charge per class and per person?
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    viewBox="0 0 16 16"
                    fill="none"
                  >
                    <path
                      d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 13.5C6.91221 13.5 5.84884 13.1774 4.94437 12.5731C4.0399 11.9687 3.33495 11.1098 2.91867 10.1048C2.50238 9.09977 2.39347 7.9939 2.60568 6.927C2.8179 5.86011 3.34173 4.8801 4.11092 4.11091C4.8801 3.34172 5.86011 2.8179 6.92701 2.60568C7.9939 2.39346 9.09977 2.50238 10.1048 2.91866C11.1098 3.33494 11.9687 4.03989 12.5731 4.94436C13.1774 5.84883 13.5 6.9122 13.5 8C13.4983 9.45818 12.9184 10.8562 11.8873 11.8873C10.8562 12.9184 9.45819 13.4983 8 13.5ZM9 11C9 11.1326 8.94732 11.2598 8.85356 11.3536C8.75979 11.4473 8.63261 11.5 8.5 11.5C8.23479 11.5 7.98043 11.3946 7.7929 11.2071C7.60536 11.0196 7.5 10.7652 7.5 10.5V8C7.36739 8 7.24022 7.94732 7.14645 7.85355C7.05268 7.75979 7 7.63261 7 7.5C7 7.36739 7.05268 7.24021 7.14645 7.14645C7.24022 7.05268 7.36739 7 7.5 7C7.76522 7 8.01957 7.10536 8.20711 7.29289C8.39465 7.48043 8.5 7.73478 8.5 8V10.5C8.63261 10.5 8.75979 10.5527 8.85356 10.6464C8.94732 10.7402 9 10.8674 9 11ZM7 5.25C7 5.10166 7.04399 4.95666 7.1264 4.83332C7.20881 4.70999 7.32595 4.61386 7.46299 4.55709C7.60003 4.50032 7.75083 4.48547 7.89632 4.51441C8.04181 4.54335 8.17544 4.61478 8.28033 4.71967C8.38522 4.82456 8.45665 4.9582 8.48559 5.10368C8.51453 5.24917 8.49968 5.39997 8.44291 5.53701C8.38615 5.67406 8.29002 5.79119 8.16668 5.8736C8.04334 5.95601 7.89834 6 7.75 6C7.55109 6 7.36032 5.92098 7.21967 5.78033C7.07902 5.63968 7 5.44891 7 5.25Z"
                      fill="#0072B1"
                    />
                  </svg>
                </h3>
                <div class="row">
                  <div class="col-md-3 col-sm-12">
                    <h3
                      class="online-Class-Select-Heading"
                      style="margin-top: 16px"
                    >
                      Start Date
                    </h3>
                    <input
                      class="payment-input"
                      placeholder="50%" 
                      type="date" name="start_date" id="start_date"
                    />
                  </div>
                  <div class="col-md-3 col-sm-12">
                    <h3
                      class="online-Class-Select-Heading"
                      style="margin-top: 16px"
                    >
                      Start Time 
                    </h3>
                    <input
                      class="payment-input"
                      placeholder="50%"
                      type="time"   name="start_time" id="start_time"
                    />
                  </div>
                  <div class="col-md-3 col-sm-12">
                    <h3
                      class="online-Class-Select-Heading"
                      style="margin-top: 16px"
                    >
                      End Time
                    </h3>
                    <input
                      class="payment-input"
                      placeholder="50%"
                      type="time"  name="end_time" id="end_time"
                    />
                  </div>
                  <div class="col-md-3 col-sm-12">
                    <h3
                      class="online-Class-Select-Heading"
                      style="margin-top: 16px"
                    >
                      End Date (Optional)
                    </h3>
                    <input
                      class="payment-input"
                      placeholder="50%"
                      type="date"  name="end_date" id="end_date"
                    />
                  </div>
                  <p class="timeDurationdetile">
                    <span>Note:</span> Expert should always be given an
                    estimated earning when they insert an amount. The system
                    should automatically deduct 15% from the price. See
                    screenshot of a design draft below.
                  </p>
                </div> --}}
                {{-- <div class="row">
                  <div class="col-md-3 col-sm-12">
                    <h3
                      class="online-Class-Select-Heading"
                      style="margin-top: 16px"
                    >
                      Repeat on :
                    </h3>
                    <input
                      class="payment-input"
                      placeholder="Repeat after weeks"
                      type="text"
                    />
                  </div>
                  <div class="col-md-3 col-sm-12"></div>
                  <div class="col-md-3 col-sm-12"></div>
                  <div class="col-md-3 col-sm-12"></div>
                </div> --}}


                @if (!($gig->service_type == 'Online' && $gigData->freelance_service == 'Normal'))
               
                @if ($gig->service_type != 'Inperson' && $gigData->freelance_service != 'Normal')
                    
            
               
               @php
                  if (isset($gigPayment->duration) && !empty($gigPayment->duration)) {
                      $duration = explode(':', $gigPayment->duration);
                      $duration = array_pad($duration, 2, '00');
                  } else {
                      // Set default values if duration is not set or empty
                      $duration = ['00', '00'];
                  }
              @endphp
                <div class="row mt-3">
                  <div class="col-md-12 col-sm-12">
                    <h3
                    class="online-Class-Select-Heading"
                    style="margin-top: 16px; display: inline;"
                    >
                    Duration
                  </h3>

                  <select name="durationH" id="durationH" class="fa">
                    <option  value="{{$duration[0]}}" class="fa">{{$duration[0]}}</option>
                    <option  value="00" class="fa">00</option>
                    @for ($i = 1; $i <= 10; $i++)
                    <option  value="{{$i}}" class="fa">{{$i}}</option>
                        
                    @endfor 
                  </select>
                  <span>Hr</span>
               
             
                  <select name="durationM" id="durationM" class="fa">
                    <option  value="{{$duration[1]}}" class="fa">{{$duration[1]}}</option>
                    <option  value="00" class="fa">00</option>
                    <option  value="30" class="fa">30</option>
                     
                  </select>
                  <span>Mi</span>

                  </div>
                  </div>
               @endif

                @endif

                @if ($gig->service_type == 'Online' && $gigData->freelance_service == 'Normal')
                    
                
                <div class="row"  >
                  <div class="col-md-12">
                    <h3
                      class="online-Class-Select-Heading"
                      style="margin-top: 24px"
                    >  24 Hour Available</h3>
                    <div class="form-check form-switch col-md-12">
                      <input class="form-check-input form-control  " type="checkbox" role="switch" checked disabled name="full_available_check" id="full_available_check" value="1"  > 
                      <input type="hidden"  name="full_available" id="full_available" value="1">
                    </div>
                  </div>
                </div>
                @endif


                  <div class="row" id="main_repeat_on">
                    <div class="col-md-12">
                      <h3
                        class="online-Class-Select-Heading"
                        style="margin-top: 24px"
                      >
                        Repeat on :
                      </h3>
                      <div class="repeats-btn-section">
                        <div >
                          <button type="button" class="repeat-btn" onclick="RepeatOn(this)"  data-day='1'>Monday</button>

                          <div id="time_div_1" class="time_div" ></div> 
                        </div>
                        <div >
                          <button  type="button" class="repeat-btn" onclick="RepeatOn(this)"  data-day='2'>Tuesday</button>
                          <div id="time_div_2" class="time_div" ></div> 
                        </div> 
                        <div >
                          <button  type="button" class="repeat-btn" onclick="RepeatOn(this)"  data-day='3'>Wednesday</button>
                          <div id="time_div_3" class="time_div" ></div> 
                        </div> 
                        <div >
                          <button  type="button" class="repeat-btn" onclick="RepeatOn(this)"  data-day='4'>Thursday</button>
                          <div id="time_div_4" class="time_div" ></div> 
                        </div> 
                        <div >
                          <button  type="button" class="repeat-btn" onclick="RepeatOn(this)"  data-day='5'>Friday</button>
                          <div id="time_div_5" class="time_div" ></div> 
                        </div> 
                        <div >
                          <button  type="button" class="repeat-btn" onclick="RepeatOn(this)"  data-day='6'>Saturday</button>
                          <div id="time_div_6" class="time_div" ></div> 
                        </div> 
                        <div >
                          <button  type="button" class="repeat-btn" onclick="RepeatOn(this)" data-day='7' >Sunday</button>
                          <div id="time_div_7" class="time_div" ></div> 
                        </div>  
                      </div>
                      
                    </div>
                  </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="Teacher-next-back-Section" style="margin: 16px 0px">
              <a href="/teacher-service-edit/{{$gig_id}}/edit" class="teacher-back-btn">Back</a>

              <button type="button" onclick="SubmitForm()" class="teacher-next-btn" >Next</button>
               
            </div>
          </div>
        </div>
      </div>
      <!-- =============================== MAIN CONTENT END HERE =========================== -->
    </section>


    
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script> 

    {{-- Repeat On Show Hide Start --}}
<script>



function validateRatePrice(input) {
  var value = parseFloat(input.value);
  if (isNaN(value) || value < 10) {
    alert("Minimum rate of $10 is allowed.");
    input.value = 10;
     rate = 10 ;
     var commission = parseFloat('<?php echo $commission; ?>');
          let netPercent = 100 - commission; // Net percentage after tax
       let estimatedEarnings = (rate * netPercent) / 100;
       if (input == 'rate') {
           $('#estimated_earning').val(estimatedEarnings);
       } else {
           $('#estimated_earning_2').val(estimatedEarnings);
       }

  }
}

  $('#full_available_check').on('click', function () { 
    if ($('#full_available_check').attr('checked')) { 
      $('#full_available_check').removeAttr('checked');
      $('#full_available').val(0);
      $('#main_repeat_on').show();
    } else { 
      $('#full_available_check').attr('checked', 1);
      $('#full_available').val(1);
      $('#main_repeat_on').hide();
    } 
    
  });
</script>
{{-- Repeat On Show Hide END --}}

    {{-- Positive Search Tearm Script Start --}}
    <script>


$(document).ready(function () {
  $('#duration').on('input', function () {
    let value = $(this).val();

    // Remove invalid characters
    value = value.replace(/[^0-9:]/g, '');

    // Automatically add colon after 2 digits if not already present
    if (value.length > 2 && value.indexOf(':') === -1) {
      value = value.slice(0, 2) + ':' + value.slice(2);
    }

    // Limit to HH:MM format
    if (value.length > 5) {
      value = value.slice(0, 5);
    }

    $(this).val(value);
  });

  $('#duration').on('focusout', function () {
    let value = $(this).val();

    // Validate hours and minutes
    let parts = value.split(':');
    if (parts.length === 2) {
      // Ensure hours are within 00-24
      let hours = Math.min(24, Math.max(0, parseInt(parts[0] || '0')));
      // Ensure minutes are within 00-59
      let minutes = Math.min(59, Math.max(0, parseInt(parts[1] || '0')));

      // Format hours and minutes
      parts[0] = hours.toString().padStart(2, '0');
      parts[1] = minutes.toString().padStart(2, '0');

      $(this).val(parts.join(':'));
    } else {
      // Reset to default if invalid
      $(this).val('00:00');
    }
  });
});

      
      flatpickr(".timePickerFlatpickr", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    minuteIncrement: 30, // Only allow 00 and 30
  });

      document.addEventListener('DOMContentLoaded', function() {
          const inputField = document.getElementById('input_positive_term');
          const outputDiv = document.getElementById('positive_term_div');
          const commaSeparatedField = document.getElementById('positive_term');
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
          {{-- Positive Search Tearm Script END --}}

    
    <!-- Optional JavaScript; choose one of the two! -->
 

    {{-- PAyment Subscription Script Start--}}
    <script>

document.getElementById('payment_type').addEventListener('change', function() {
    const input = document.getElementById('delivery_time');
    const selectedOption = this.value;

    if (selectedOption === 'Subscription') {
        input.value = 28;     // Set value to 28
        input.readOnly = true; // Make input read-only
    } else {
        input.value = '';      // Clear the input value
        input.readOnly = false; // Make input editable
    }
});
 
    </script>
    {{-- PAyment Subscription Script END --}}

    {{-- If Freelance Online and Normal then Repeat On Allways Hide Script Start --}}
    @if ($gig->service_type == 'Online' && $gigData->freelance_service == 'Normal')
                    
                
     
    <script>
      $(document).ready(function () {
        $('#main_repeat_on').hide();
      });
    </script>
    @endif
    {{-- If Freelance Online and Normal then Repeat On Allways Hide Script END --}}
 
        
      {{-- Moment CDN === --}}
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

    {{-- Form Validation Script Start==== --}}
    <script>

      function SubmitForm() {
      
         // Get form values
         const rate = document.getElementById('rate').value ; 
         const freelance_type = '<?php echo $gigData->freelance_type ?>' ;
         const video_call = '<?php echo $gigData->video_call ?>' ; 
         let duration = '' ;

          var service_type = @json($gig->service_type);
          var freelance_service = @json($gigData->freelance_service);

          
          const showError = (message) => {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            timeOut: "10000",
            extendedTimeOut: "4410000"
        };
        toastr.error(message);
        valid = false;
    };

        
         
          let valid = true; // A flag to track if the form is valid
      
            // Rate validation
            if (!rate) {
            toastr.options =
                {
                    "closeButton" : true,
                     "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                }
                        toastr.error("Individual Rate Required!");
              valid = false;
              return false ;
          }

          if (service_type != 'Inperson' && freelance_service != 'Normal') {
            const delivery_time = document.getElementById('delivery_time').value;
              // Delivery Time validation
          if (!delivery_time) {
            toastr.options =
                {
                    "closeButton" : true,
                     "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                }
                        toastr.error("Delivery Time Required!");
              valid = false;
              return false ;
          }
            
          }


          if (freelance_type == 'Both') {
            const rate_2 = document.getElementById('rate_2').value ; 
           

                // Rate validation
                if (!rate_2) {
            toastr.options =
                {
                    "closeButton" : true,
                     "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                }
                        toastr.error("Individual Rate Basic Required!");
              valid = false;
              return false ;
          }

       
          

           if (service_type != 'Inperson' && freelance_service != 'Normal') {
            const delivery_time_2 = document.getElementById('delivery_time_2').value;
              // Delivery Time validation
        // Delivery Time validation
          if (!delivery_time_2) {
            toastr.options =
                {
                    "closeButton" : true,
                     "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                }
                        toastr.error("Delivery Time Premium Required!");
              valid = false;
              return false ;
          }
            
          }else{



               // Final duration validation
     const durationH = document.getElementById('durationH_2').value;
  const durationM = document.getElementById('durationM_2').value;
  duration = `${durationH}:${durationM}`;
  if (durationH === '00' && durationM === '00'){

    toastr.options =
                {
                    "closeButton" : true,
                     "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                }
                        toastr.error("Duration Premium Required!");
              valid = false;
              return false ;


  } 


      

      var activeDays = [];
          var activeDivs = []; 
    $('.repeat-btn.active').each(function() {

        activeDays.push($(this).html());
        activeDivs.push($(this).data('day'));
    });

    // Log the result as an array of active days
    if (activeDays.length > 0) {
      
      for (let i = 0; i < activeDays.length; i++) {
      
        const day = activeDays[i];
        const data = activeDivs[i];
        const start_repeat = document.getElementById('start_repeat_'+data).value;
        const end_repeat = document.getElementById('end_repeat_'+data).value;
          
        // Start Time validation
        if (!start_repeat) {
            toastr.options =
                {
                    "closeButton" : true,
                     "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                }
                        toastr.error("Repeat Start Time Required!");
              valid = false;
              return false ;
          }
        // End Time validation
        if (!end_repeat) {
            toastr.options = 
                {
                    "closeButton" : true,
                     "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                }
                        toastr.error("Repeat End Time Required!");
              valid = false;
              return false ;
          }

          if (end_repeat === "00:00") {
            alert('End Time cannot be 00:00.');
            endTimeInput.value = ""; // Reset invalid end time
            endTimeInput.focus(); // Keep focus on End Time input
            valid = false ;
            return false;
        }


        if (duration != '') {
      duration_part = duration.split(':');
      const totalDurationMinutes = (parseInt(duration_part[0]) * 60) + parseInt(duration_part[1]);

    
            // Retrieve start and end time inputs
      const start_time = start_repeat;
      const end_time = end_repeat;

      // Parse times using moment.js
      const startTimeMoment = moment(start_time, "HH:mm");
      const endTimeMoment = moment(end_time, "HH:mm");

      // Calculate availability time in minutes
      const availabilityMinutes = moment.duration(endTimeMoment.diff(startTimeMoment)).asMinutes();
          
      // Compare availability time with duration
      if (availabilityMinutes < totalDurationMinutes) {
          showError(`Availability time must be at least ${duration_part[0]} hours and ${duration_part[1]} minutes based on premium duration.`);
          return false;
      }
      
    }
                  
      }
      
    }else{

      toastr.options = 
                {
                    "closeButton" : true,
                     "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                }
                        toastr.error("Minimum One Day Active Start,End Time Set!");
              valid = false;
              return false ;

    }



          }
          

          }





           
      
        
          if (service_type == 'Online' && freelance_service == 'Normal') {
            const full_available = document.getElementById('full_available').value ; 
        if (full_available == 0) {


        var activeDays = [];
          var activeDivs = []; 
    $('.repeat-btn.active').each(function() {

        activeDays.push($(this).html());
        activeDivs.push($(this).data('day'));
    });

    // Log the result as an array of active days
    if (activeDays.length > 0) {
      
      for (let i = 0; i < activeDays.length; i++) {
    const day = activeDays[i];
    const data = activeDivs[i];
    const startTimeInput = document.getElementById('start_repeat_' + data);
    const endTimeInput = document.getElementById('end_repeat_' + data);
    const start_repeat = startTimeInput.value;
    const end_repeat = endTimeInput.value;

    if (!start_repeat) {
        showError(`Start Time Required for ${day}!`);
        startTimeInput.focus(); // Keep focus on Start Time input
        return;
    }

    if (!end_repeat) {
        showError(`End Time Required for ${day}!`);
        endTimeInput.focus(); // Keep focus on End Time input
        return;
    }

    if (start_repeat && end_repeat) {
        let startTimeMoment = moment(start_repeat, "HH:mm");
        let endTimeMoment = moment(end_repeat, "HH:mm");

        if (endTimeMoment.isSameOrBefore(startTimeMoment)) {
            alert('End Time must be greater than Start Time.');
            endTimeInput.value = ""; // Reset invalid end time
            endTimeInput.focus(); // Keep focus on End Time input
            return;
        }

        if (end_repeat === "00:00") {
            alert('End Time cannot be 00:00.');
            endTimeInput.value = ""; // Reset invalid end time
            endTimeInput.focus(); // Keep focus on End Time input
            return;
        }
    }
}
      
    }else{

      toastr.options = 
                {
                    "closeButton" : true,
                     "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                }
                        toastr.error("Minimum One Day Active Start,End Time Set!");
              valid = false;
              return false ;

    }

        
      }
    } else{



                 // Final duration validation
  const durationH = document.getElementById('durationH').value;
  const durationM = document.getElementById('durationM').value;
  duration = `${durationH}:${durationM}`;
  if (durationH === '00' && durationM === '00'){

    toastr.options =
                {
                    "closeButton" : true,
                     "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                }
                        toastr.error("Duration Required!");
              valid = false;
              return false ;


  } 


      

      var activeDays = [];
          var activeDivs = []; 
    $('.repeat-btn.active').each(function() {

        activeDays.push($(this).html());
        activeDivs.push($(this).data('day'));
    });

    // Log the result as an array of active days
    if (activeDays.length > 0) {
      
      for (let i = 0; i < activeDays.length; i++) {
      
        const day = activeDays[i];
        const data = activeDivs[i];
        const start_repeat = document.getElementById('start_repeat_'+data).value;
        const end_repeat = document.getElementById('end_repeat_'+data).value;
          
        // Start Time validation
        if (!start_repeat) {
            toastr.options =
                {
                    "closeButton" : true,
                     "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                }
                        toastr.error("Repeat Start Time Required!");
              valid = false;
              return false ;
          }
        // End Time validation
        if (!end_repeat) {
            toastr.options = 
                {
                    "closeButton" : true,
                     "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                }
                        toastr.error("Repeat End Time Required!");
              valid = false;
              return false ;
          }

          if (end_repeat === "00:00") {
            alert('End Time cannot be 00:00.');
            endTimeInput.value = ""; // Reset invalid end time
            endTimeInput.focus(); // Keep focus on End Time input
            valid = false ;
            return false;
        }


        if (duration != '') {
      duration_part = duration.split(':');
      const totalDurationMinutes = (parseInt(duration_part[0]) * 60) + parseInt(duration_part[1]);

    
            // Retrieve start and end time inputs
      const start_time = start_repeat;
      const end_time = end_repeat;

      // Parse times using moment.js
      const startTimeMoment = moment(start_time, "HH:mm");
      const endTimeMoment = moment(end_time, "HH:mm");

      // Calculate availability time in minutes
      const availabilityMinutes = moment.duration(endTimeMoment.diff(startTimeMoment)).asMinutes();
          
      // Compare availability time with duration
      if (availabilityMinutes < totalDurationMinutes) {
          showError(`Availability time must be at least ${duration[0]} hours and ${duration[1]} minutes.`);
          return false;
      }
      
    }
                  
      }
      
    }else{

      toastr.options = 
                {
                    "closeButton" : true,
                     "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
                }
                        toastr.error("Minimum One Day Active Start,End Time Set!");
              valid = false;
              return false ;

    }


    }
      
       
         
      
            
      
      
      
          // If the form is not valid, prevent submission
          if (valid == true) {
            $('#myForm').submit();
          }
      
        }
      
          
      
          </script>
          {{-- Form Validation Script END==== --}}
    
    {{-- Load Page Confirmation --}}
    <script>
      window.addEventListener('beforeunload', function (e) {

        if ($('#myForm').submit()) {
          return; 
        }
    // Display a confirmation dialog
    var confirmationMessage = 'Are you sure you want to leave? Your changes might not be saved.';

    // Standard for most modern browsers
    e.preventDefault();

    // Some browsers require returning a string (though ignored by modern browsers)
    e.returnValue = confirmationMessage;

    // Return the confirmation message (old versions of Chrome, Firefox, etc. still support this)
    return confirmationMessage;
});
    </script>
    {{-- Load Page Confirmation --}}
    

    {{-- Repeat On Script Start ======= --}}
    <script>
   function RepeatOn(Clicked) { 

if ($(Clicked).hasClass('active')) {
  $(Clicked).removeClass('active');
} else {
  $(Clicked).addClass('active');
  }
 

  var activeDays = [];
  var activeDivs = [];
  $('.time_div').empty();
$('.repeat-btn.active').each(function() {

activeDays.push($(this).html());
activeDivs.push($(this).data('day'));
});

// Log the result as an array of active days
if (activeDays.length > 0) {

for (let i = 0; i < activeDays.length; i++) {
const day = activeDays[i];
const data = activeDivs[i];
var html = ' <input type="hidden" name="day_repeat[]" value="'+day+'" class="payment-input mt-1 ">  '+
   '<div class="repeat-btn" style="color:#0072b1;font-weight:500;background:none;"> Start Time : <input type="text" style="width:120px;"   id="start_repeat_'+data+'" name="start_repeat[]" class="timePickerFlatpickr payment-input mt-1"> </div>'+
   '<div class="repeat-btn" style="color:#0072b1;font-weight:500;background:none;"> End Time : <input type="text" style="width:120px;"   id="end_repeat_'+data+'" name="end_repeat[]" class="timePickerFlatpickr payment-input mt-1"> </div>' ;

   $('#time_div_'+data).html(html); 
   
flatpickr(".timePickerFlatpickr", {
enableTime: true,
noCalendar: true,
dateFormat: "H:i",
minuteIncrement: 30, // Only allow 00 and 30
});
          
}

}


}
         //  Estimated Payment Set ========
      $('#rate').on('keyup', function () {
       var rate =  $('#rate').val();
       var commission = parseFloat('<?php echo $commission; ?>');
       let netPercent = 100 - commission; // Net percentage after tax
    let estimatedEarnings = (rate * netPercent) / 100;
    $('#estimated_earning').val(estimatedEarnings);
    
       
      });

         //  Estimated Payment Set ========
      $('#rate_2').on('keyup', function () {
       var rate =  $('#rate_2').val();
       var commission = parseFloat('<?php echo $commission; ?>');
       let netPercent = 100 - commission; // Net percentage after tax
    let estimatedEarnings = (rate * netPercent) / 100;
    $('#estimated_earning_2').val(estimatedEarnings);
    
       
      });
      
    </script>
    {{-- Repeat On Script END ======= --}}
    
    <!-- ================ side js start here=============== -->
    <!-- ================ side js start End=============== -->
    
  </body>
</html>
<!-- modal hide show jquery here -->
<script>
  $(document).ready(function () {
    $(document).on("click", "#delete-account", function (e) {
      e.preventDefault();
      $("#exampleModal7").modal("show");
      $("#delete-teacher-account").modal("hide");
    });

    $(document).on("click", "#delete-account", function (e) {
      e.preventDefault();
      $("#delete-teacher-account").modal("show");
      $("#exampleModal7").modal("hide");
    });
  });
</script>
<!-- radio js here -->
<script>
  function showAdditionalOptions1() {
    hideAllAdditionalOptions();
  }

  function showAdditionalOptions2() {
    hideAllAdditionalOptions();
    document.getElementById("additionalOptions2").style.display = "block";
  }

  function showAdditionalOptions3() {
    hideAllAdditionalOptions();
  }

  function showAdditionalOptions4() {
    hideAllAdditionalOptions();
    document.getElementById("additionalOptions4").style.display = "block";
  }

  function hideAllAdditionalOptions() {
    var elements = document.getElementsByClassName("additional-options");
    for (var i = 0; i < elements.length; i++) {
      elements[i].style.display = "none";
    }
  }

  // Call the function to show the additional options for the default checked radio button on page load
  window.onload = function () {
    showAdditionalOptions1();
  };
</script>






    <!-- Tinymcs js link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.4.1/tinymce.min.js"></script>
  
    <!-- Tinymce js start -->
<script>
  tinymce.init({
    selector: "#answer",
    plugins: "code visualblocks link",
    toolbar: [
      //: https://www.tiny.cloud/docs/tinymce/6/toolbar-configuration-options/#adding-toolbar-group-labels
      { name: "history", items: ["undo", "redo"] },
      { name: "styles", items: ["styles"] },
      {
        name: "formatting",
        items: ["bold", "italic", "underline", "removeformat"],
      },
      { name: "elements", items: ["link"] },
      // { name: 'alignment', items: [ 'alignleft', 'aligncenter', 'alignright', 'alignjustify' ] },
      // { name: 'indentation', items: [ 'outdent', 'indent' ] },
      { name: "source", items: ["code", "visualblocks"] },
    ],
    link_list: [
      { title: "{companyname} Home Page", value: "{companyurl}" },
      { title: "{companyname} Blog", value: "{companyurl}/blog" },
      {
        title: "{productname} Support resources 1",
        menu: [
          {
            title: "{productname} 1 Documentation",
            value: "{companyurl}/docs/",
          },
          {
            title: "{productname} on Stack Overflow",
            value: "{communitysupporturl}",
          },
          {
            title: "{productname} GitHub",
            value: "https://github.com/tinymce/",
          },
        ],
      },
      {
        title: "{productname} Support resources 2",
        menu: [
          {
            title: "{productname} 2 Documentation",
            value: "{companyurl}/docs/",
          },
          {
            title: "{productname} on Stack Overflow",
            value: "{communitysupporturl}",
          },
          {
            title: "{productname} GitHub",
            value: "https://github.com/tinymce/",
          },
        ],
      },
      {
        title: "{productname} Support resources 3",
        menu: [
          {
            title: "{productname} 3 Documentation",
            value: "{companyurl}/docs/",
          },
          {
            title: "{productname} on Stack Overflow",
            value: "{communitysupporturl}",
          },
          {
            title: "{productname} GitHub",
            value: "https://github.com/tinymce/",
          },
        ],
      },
    ],
  });

  tinymce.init({
    selector: "#answer_upd",
    plugins: "code visualblocks link",
    toolbar: [
      //: https://www.tiny.cloud/docs/tinymce/6/toolbar-configuration-options/#adding-toolbar-group-labels
      { name: "history", items: ["undo", "redo"] },
      { name: "styles", items: ["styles"] },
      {
        name: "formatting",
        items: ["bold", "italic", "underline", "removeformat"],
      },
      { name: "elements", items: ["link"] },
      // { name: 'alignment', items: [ 'alignleft', 'aligncenter', 'alignright', 'alignjustify' ] },
      // { name: 'indentation', items: [ 'outdent', 'indent' ] },
      { name: "source", items: ["code", "visualblocks"] },
    ],
    link_list: [
      { title: "{companyname} Home Page", value: "{companyurl}" },
      { title: "{companyname} Blog", value: "{companyurl}/blog" },
      {
        title: "{productname} Support resources 1",
        menu: [
          {
            title: "{productname} 1 Documentation",
            value: "{companyurl}/docs/",
          },
          {
            title: "{productname} on Stack Overflow",
            value: "{communitysupporturl}",
          },
          {
            title: "{productname} GitHub",
            value: "https://github.com/tinymce/",
          },
        ],
      },
      {
        title: "{productname} Support resources 2",
        menu: [
          {
            title: "{productname} 2 Documentation",
            value: "{companyurl}/docs/",
          },
          {
            title: "{productname} on Stack Overflow",
            value: "{communitysupporturl}",
          },
          {
            title: "{productname} GitHub",
            value: "https://github.com/tinymce/",
          },
        ],
      },
      {
        title: "{productname} Support resources 3",
        menu: [
          {
            title: "{productname} 3 Documentation",
            value: "{companyurl}/docs/",
          },
          {
            title: "{productname} on Stack Overflow",
            value: "{communitysupporturl}",
          },
          {
            title: "{productname} GitHub",
            value: "https://github.com/tinymce/",
          },
        ],
      },
    ],
  });

</script>

{{-- Faqs By Ajax Script Start ======== --}}
<script>
$('#add_new_btn').click(function () { 
  if ($('#add_faqs_main_div').is(':visible')) {
    $('#add_faqs_main_div').css('display', 'none'); 
    $('#edit_faqs_main_div').css('display', 'none'); 
  } else {
    $('#add_faqs_main_div').css('display', 'block'); 
    $('#edit_faqs_main_div').css('display', 'none'); 
  }
});

// On Page Load Get All Faqs
$(document).ready(function () {
  
  var gig_id = '<?php echo $gig->id ?>';

   // Set up CSRF token
   $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // AJAX request
    $.ajax({
        type: "POST",
        url: '/get-faqs-service',
        data: {
            gig_id: gig_id,
            _token: '{{csrf_token()}}'
        },
        dataType: 'json',
        success: function (response) {
            
          var faqs = response.faqs ;

          var len = 0 ;
          len = faqs.length ;
          $('#all_faqs').empty();

          if (len > 0 ) {
    
    for (let i = 0; i < len; i++) {

      var id = faqs[i].id ;
      var question = faqs[i].question ;
      var answer = faqs[i].answer ; 

      var faqs_html = ` <div class="input-group  mb-3  main_faqs_${id}">
                    <input type="text" value="${question}" class="form-control payment-input" placeholder="Faqs" aria-label="Recipient's username" aria-describedby="button-addon1" readonly>
                    <button class="btn view-button btn-danger text-white btn btn-outline-secondary remove-button" type="button" onclick="RemoveFaqs(this.id)" id="remove_faqs_${id}" data-id="${id}"   >Remove</button>
                    <button class="btn view-button teacher-next-btn" type="button" onclick="ViewFaqs(this.id)" id="faqs_view_${id}"  data-id="${id}" data-question="${question}" data-answer="${answer}">View</button>
                  </div>`;


                  $('#all_faqs').append(faqs_html);

        }


      }

               

 
        },
        error: function (xhr, status, error) {
            toastr.error('An error occurred. Please try again.');
        }
    });

});


// Add New FAQs Script Start -------
$('#add_faqs_btn').click(function () { 
    var gig_id = $('#faqs_gig_id').val();
    var question = $('#question').val().trim();
    const answer = tinymce.get('answer').getContent().trim();

    // Check if question or answer is empty
    if (!question || !answer) {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "timeOut": "5000", // 5 seconds
            "extendedTimeOut": "1000" // 1 second
        };
        toastr.error('Both question and answer are required.');
        return; // Stop further execution if validation fails
    }
    
    // Set up CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // AJAX request
    $.ajax({
        type: "POST",
        url: '/upload-faqs-services',
        data: {
            gig_id: gig_id,
            question: question,
            answer: answer,
            _token: '{{csrf_token()}}'
        },
        dataType: 'json',
        success: function (response) {
            // Reset the fields
            $('#question').val('');
            tinymce.get('answer').setContent('');
            $('#add_faqs_main_div').css('display', 'none');

            // Display success or error message
            if (response.success) {

              var faqs = response.faqs ;
              var faqs_html = ` <div class="input-group  mb-3  main_faqs_${faqs.id}">
                    <input type="text" value="${faqs.question}" class="form-control payment-input" placeholder="Faqs" aria-label="Recipient's username" aria-describedby="button-addon1" readonly>
                    <button class="btn view-button btn-danger text-white btn btn-outline-secondary remove-button" type="button" onclick="RemoveFaqs(this.id)" id="remove_faqs_${faqs.id}" data-id="${faqs.id}"   >Remove</button>
                    <button class="btn view-button teacher-next-btn" type="button" onclick="ViewFaqs(this.id)" id="faqs_view_${faqs.id}"   data-id="${faqs.id}" data-question="${faqs.question}" data-answer="${faqs.answer}">View</button>
                  </div>`;


                  $('#all_faqs').append(faqs_html);




                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "10000", // 10 seconds
                    "extendedTimeOut": "1000" // 1 second
                };
                toastr.success(response.success);
            } else {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "10000", // 10 seconds
                    "extendedTimeOut": "1000" // 1 second
                };
                toastr.error(response.error);
            }
        },
        error: function (xhr, status, error) {
            toastr.error('An error occurred. Please try again.');
        }
    });
});

  
// Add New Faqs Script END -------

// Delete Faqs Script Start ----------
function RemoveFaqs(Clicked) { 

  if (!confirm("Are You Sure, You Want to delete This Faqs ?")){
      return false;
    }

    var id = $('#'+Clicked).data('id');
    

      // Set up CSRF token
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // AJAX request
    $.ajax({
        type: "POST",
        url: '/delete-faqs-services',
        data: {
            id: id, 
            _token: '{{csrf_token()}}'
        },
        dataType: 'json',
        success: function (response) {
            

            // Display success or error message
            if (response.success) {
              
              
              $('.main_faqs_'+id).remove();

                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "10000", // 10 seconds
                    "extendedTimeOut": "1000" // 1 second
                };
                toastr.info(response.success);
            } else {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "10000", // 10 seconds
                    "extendedTimeOut": "1000" // 1 second
                };
                toastr.error(response.error);
            }
        },
        error: function (xhr, status, error) {
            toastr.error('An error occurred. Please try again.');
        }
    });
    

 }
// Delete Faqs Script END ----------


// EDIT Faqs Script Start ----------
function ViewFaqs(Clicked) { 
  var id = $('#'+Clicked).data('id');
  var question = $('#'+Clicked).data('question');
  var answer = $('#'+Clicked).data('answer');

  $('#faqs_id').val(id);
  $('#question_upd').val(question);
            tinymce.get('answer_upd').setContent(answer);
            $('#edit_faqs_main_div').css('display', 'block');


 }
// EDIT Faqs Script END ----------


// Update Faqs Script Start ----------
$('#edit_faqs_btn').click(function () { 
   
  var id = $('#faqs_id').val();
    var question = $('#question_upd').val().trim();
    const answer = tinymce.get('answer_upd').getContent().trim();

    // Check if question or answer is empty
    if (!question || !answer) {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "timeOut": "5000", // 5 seconds
            "extendedTimeOut": "1000" // 1 second
        };
        toastr.error('Both question and answer are required.');
        return; // Stop further execution if validation fails
    }
    
    // Set up CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // AJAX request
    $.ajax({
        type: "POST",
        url: '/updated-faqs-services',
        data: {
            id: id,
            question: question,
            answer: answer,
            _token: '{{csrf_token()}}'
        },
        dataType: 'json',
        success: function (response) {
            // Reset the fields
            $('#faqs_id').val('');
            $('#question_upd').val('');
            tinymce.get('answer_upd').setContent('');
            $('#edit_faqs_main_div').css('display', 'none');

            // Display success or error message
            if (response.success) {

              var faqs = response.faqs ;
              // Update the existing FAQ element
              var faqs_html = `
                    <input type="text" value="${faqs.question}" class="form-control payment-input" placeholder="Faqs" aria-label="Recipient's username" aria-describedby="button-addon1" readonly>
                    <button class="btn view-button btn-danger text-white btn btn-outline-secondary remove-button" type="button" onclick="RemoveFaqs(this.id)" id="remove_faqs_${faqs.id}" data-id="${faqs.id}">Remove</button>
                    <button class="btn view-button teacher-next-btn" type="button" onclick="ViewFaqs(this.id)" id="faqs_view_${faqs.id}" data-id="${faqs.id}" data-question="${faqs.question}" data-answer="${faqs.answer}">View</button>
                `;

                $(`.main_faqs_${faqs.id}`).html(faqs_html);




                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "10000", // 10 seconds
                    "extendedTimeOut": "1000" // 1 second
                };
                toastr.success(response.success);
            } else {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "10000", // 10 seconds
                    "extendedTimeOut": "1000" // 1 second
                };
                toastr.error(response.error);
            }
        },
        error: function (xhr, status, error) {
            toastr.error('An error occurred. Please try again.');
        }
    });

  
});
// Update Faqs Script END ----------



</script>
{{-- Faqs By Ajax Script END ======== --}}

