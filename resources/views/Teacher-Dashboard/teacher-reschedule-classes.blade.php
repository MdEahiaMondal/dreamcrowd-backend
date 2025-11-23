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
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.2.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>

 <!-- Include jQuery and DateTimePicker -->
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-datetimepicker@2.5.21/jquery.datetimepicker.min.css">
 <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/jquery.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/jquery-datetimepicker@2.5.21/jquery.datetimepicker.full.min.js"></script>
 
  {{-- =====Appointment-Calender CDN===== --}}
  <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="assets/calender/css/mark-your-calendar.css">
  {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"> --}}
 
  
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

    <title>DreamCrowd | Payment</title>
</head>


<style>
    
#picker a{
text-decoration: none;

}
#picker a:hover{
  color: white;
}

.Resh-date button {
    width: 100% ;
    margin-top: 12px;
    text-align: center;
    font-family: Roboto;
    font-size: 12px !important;
    font-weight: 400;
    background-color: #0072b1 !important;
    border-radius: 5px;
    border: 2px solid #0072b1;
    color: white;
}
.new_main{
    display: none ;
}
.callender_main{
    display: none ;
}

</style>



<body>
    <!-- =========================================== NAVBAR START HERE ================================================= -->
    <x-public-nav/>

    <!-- ============================================= NAVBAR END HERE ============================================ -->
    <!-- page-payment -->
    <div class="container-fluid">
        <div class="container">
            <form id="formsubmit" action="/teacher-update-classes" method="POST"> @csrf
            <div class="row">
                <!-- ======================== PAYMENT SECTION START FROM HERE ====================== -->
                <div class="col-lg-12 col-md-12">
                    <div class="payment-sec">
                        <!-- ======================== PAYMENT DETAILS START FROM HERE ====================== -->
                        <div class="payment-detail-title">
                            <div class="row">
                                <div class="col-md-6 payment-desc">
                                    <div class="row">
                                        <div class="col-md-6">
                                    <h1>Title: </h1>
                                </div>
                                        <div class="col-md-6">
                                        <span class="">{{$gig->title}}</span>
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-6 payment-desc">
                                    <div class="row">
                                        <div class="col-md-6">
                                    @if (Auth::user()->role == 1)
                                    <h1>Buyer </h1>
                                    @else
                                    <h1>Seller </h1>
                                    @endif
                                    
                                    </div>
                                        <div class="col-md-6">
                                            @if (Auth::user()->role == 1)
                                            <span class="">{{$user->first_name}} {{strtoupper(substr($user->last_name, 0, 1))}}.</span>
                                            @else
                                            <span class="">{{$teacher->first_name}} {{strtoupper(substr($teacher->last_name, 0, 1))}}.</span>
                                            @endif
                                       
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="payment-detail">
                            <div class="row">
                                <div class="col-md-6 payment-desc">
                                    <div class="row">
                                        <div class="col-md-6">
                                    <h1>Payment Type </h1>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="">{{$gig->payment_type}}</span>
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-6 payment-desc">
                                    <div class="row">
                                        <div class="col-md-6">
                                    <h1>Booking Type </h1>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="">    
                                            @if ($gig->service_role == 'Freelance')
                                            {{$gigData->freelance_service}}
                                             @else  @if ($gigData->lesson_type == 'One')
                                                 1-to-1
                                             @else
                                                 {{$order->group_type}} Group
                                             @endif
                                        @endif </span>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="payment-detail">
                            <div class="row">
                                <div class="col-md-6 payment-desc">
                                    <div class="row">
                                        <div class="col-md-6">
                                    <h1>Service Type </h1>
                                 </div> 
                                 <div class="col-md-6">
                                 <span class="">{{$gig->service_type}} {{$gig->service_role}} </span>
                                </div>
                                </div>
                                </div>
                                {{-- <div class="col-md-6 payment-desc">
                                    <div class="row">
                                        <div class="col-md-6">
                                    <h1>Additional Guests </h1>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="">2 Guests</span>
                                    </div>
                                </div>
                                </div> --}}
                            </div>
                        </div>
                        <!-- ======================== PAYMENT DETAILS ENDED HERE ====================== -->
                        <!-- ======================== PAYMENT DESCRIPTION START FROM HERE ====================== -->
                        <div class="paragraph">
                            <p class="">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vitae ut tellus quis a euismod ut niSl, quis. Tristique bibendum morbi vel vitæ ultrices donec accumsan. Tincidunt eget habitant pellentesque id purus. Hendrerit varius
                                sapien, nunc, turpis augue arcu venenatis. At sed consectetur in viverra duis tincidunt diam.
                            </p>
                        </div>
                        <!-- ======================== PAYMENT DESCRIPTION ENDED HERE ====================== -->
                        <!-- ======================== PAYMENT TIMEZONE START FROM HERE ====================== -->
                        <div class="timezone">
                            <div class="row ">
                                <h1 id="time_zone_show" >Timezone: @if (Auth::user()->role == 1)
                                    {{$first_class->teacher_time_zone}}  
                                    @else
                                    {{$first_class->user_time_zone}}  
                                    @endif</h1>
                                     
                                    @php use Carbon\Carbon; @endphp
                                    
                                    @if ($class)
                                    @php $i = 1; @endphp
                                    @foreach ($class as $item)
                                    @php
                                                // Determine the start time and time zone based on the user's role
                                                $startTime = $item->teacher_date;
                                                $timeZone = $item->teacher_time_zone;
                                                
                                                // Parse the start time with the appropriate time zone
                                                $start = Carbon::parse($startTime, $timeZone);
                                                
                                                // Split the duration into hours and minutes
                                                list($hours, $minutes) = explode(':', $item->duration);
                                                $totalMinutes = ($hours * 60) + $minutes;
                                                
                                                // Calculate the end time
                                                $end = $start->copy()->addMinutes($totalMinutes);
                                                @endphp
                                    
                                    <div class="col-md-3 rectangle-desc">
                                            <div class="rectangle">
                                                <h3>Old {{$booking_type}} @if ($booking_type == 'Class') {{ $i }}   @endif </h3>
                                                <span class="timezone-desc">
                                                    {{ $start->format('D M d, Y g:i A') }} - {{ $end->format('g:i A') }}

                                                </span>
                                            </div>

                                                <div class="Resh-date">
                                               <button type="button" class="btn  " id="btnreschedule_{{$i}}" onclick="ResheduleBtn(this.id)" >Reschedule This Class</button>
                                                    </div>

                                        </div>
                                    
                                            @php $i++; @endphp
                                        @endforeach
                                    @endif
                                    
                                
                                <hr class="mt-2">

                                       
                                
                                @if ($class)
                                @php $i = 1; @endphp
                                @foreach ($class as $item)
                                @php
                                                // Determine the start time and time zone based on the user's role
                                                  $startTime = $item->teacher_date;
                                                $timeZone = $item->teacher_time_zone;
                                                
                                                // Parse the start time with the appropriate time zone
                                                $start = Carbon::parse($startTime, $timeZone);
                                                
                                                // Split the duration into hours and minutes
                                                list($hours, $minutes) = explode(':', $item->duration);
                                                $totalMinutes = ($hours * 60) + $minutes;
                                                
                                                // Calculate the end time
                                                $end = $start->copy()->addMinutes($totalMinutes);
                                                @endphp
                                    
                                    <div class="col-md-3 rectangle-desc new_main   class_main_{{$i}}"> 
                                            <div class="rectangle">
                                                <h3>New {{$booking_type}} @if ($booking_type == 'Class') {{ $i }}   @endif </h3>
                                                <span class="timezone-desc" id="new_cls{{$i}}">  Not Selected  </span>
                                            </div>
                                        </div>
                                    
                                            @php $i++; @endphp
                                        @endforeach
                                    @endif
                                    
                                


                                <div class="col-md-12 field_wrapper date-time mt-2 callender_main">
                                    <div class="" id="calendar-wrapper">  

                                         <div>
                                        <p>Selected dates / times:</p>
                                        <div id="selected-dates"></div>
                                    </div>

                                    <!-- Available Days Info -->
                                    @if($repeatDays && count($repeatDays) > 0)
                                    <div class="alert alert-info mb-3" style="background-color: #e7f3ff; border-left: 4px solid #2196F3; padding: 12px;">
                                        <i class="fa fa-info-circle"></i>
                                        <strong>Class Available Days:</strong>
                                        @foreach($repeatDays as $index => $day)
                                            <span class="badge badge-primary" style="background-color: #2196F3; margin: 0 4px; padding: 5px 10px;">
                                                {{ $day->day }} ({{ \Carbon\Carbon::parse($day->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($day->end_time)->format('g:i A') }})
                                            </span>
                                        @endforeach
                                        <br>
                                        <small class="text-muted">You can only reschedule to dates on these days.</small>
                                    </div>
                                    @endif

                                      <div id="picker"></div>
                                   
                                      <input type="hidden" name="old_class_time" id="old_class_time" value="{{$class}}">
                                      <input type="hidden" name="old_teacher_class_time" id="old_teacher_class_time" value="{{$class}}">
                                      <input type="hidden" name="class_time" id="class_time" value="{{ implode(',', $class->pluck('user_date')->toArray()) }}">
                                      <input type="hidden" name="teacher_class_time" id="teacher_class_time" value="{{ implode(',', $class->pluck('teacher_date')->toArray()) }}">
                                      <input type="hidden" name="teacher_time_zone" id="teacher_time_zone">
                                      <input type="hidden" name="user_time_zone" id="user_time_zone">
                                      <input type="hidden" name="order_id" id="order_id" value="{{$order->id}}">
                                     
                         
                                    </div>
                                  </div>
                               
   
                            </div>
                        </div>
                        <!-- ======================== PAYMENT TIMEZONE ENDED HERE ====================== -->
                </div>
                <!-- ======================== PAYMENT SECTION ENDED HERE ====================== -->
                    </div>
                    
                </div>
            
            <div class="confirmation-btns">
                <div class="row">
                    <div class="col-md-12 confirmation-buttons">
                               <a href="/client-management" class="btn canelation-btn">Cancel</a> 
                            @if ($class->count() != 0)
                               <button type="button" class="btn submision-btn" onclick="FormSubmit();">Submit</button>
                            @endif
                    </div>
                </div>
            </div>
            </form>
        </div>
        </div>
           <!-- ============================= FOOTER SECTION START HERE ===================================== -->
   <x-public-footer/>
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
                config = {
    enableTime: true,
    dateFormat: "Y-m-d H:i",
}
                flatpickr("input[type=datetime-local]", config);
            </script>
                <!-- flatpicker  js end here-->


{{-- Form Submittion Script Start======== --}}
<script>
 function FormSubmit() { 
    var classes = @json($class->count());
    var selected_slots = $('#class_time').val();
    
       if (classes == 0 ) {
           alert('Not have any session for reshedule!');
        return false;
    }

    // Handle empty or uninitialized input
    if (!selected_slots.trim()) {
        alert('Slots Select Required ' + classes);
        return false;
    }

    // Split and count selected slots
    var selectedSlotsCount = selected_slots.split(',').length;
    
    if (classes !== selectedSlotsCount) {
        alert('Slots Select Required ' + classes);
        return false;
    }
    
    $('#formsubmit').submit();
} 
</script>
{{-- Form Submittion Script END ======== --}}




{{-- Reschedule Btn Script Start ======= --}}
<script>
function ResheduleBtn(Clicked) {
    // Extract the class index from the button ID
    var id = Clicked.split('_')[1];
    var $selectedClass = $('.class_main_' + id);
    var $calendar = $('.callender_main');
    
    // If the selected class is already visible, hide both the calendar and the class
    if ($selectedClass.is(':visible')) {
        $selectedClass.hide();
        $calendar.hide();
    } else {
        // Hide all new_main elements
        $('.new_main').hide();

        // Show the selected class_main
        $selectedClass.show();

        // Show the calendar
        $calendar.show();
          reloadCalendar(id);
    }
}




</script>
{{-- Reschedule Btn Script END ======= --}}



     {{-- Appointment Calender Booking ==== Start --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
  <!-- Load Moment Timezone -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.40/moment-timezone-with-data.min.js"></script>
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> --}}
    <script type="text/javascript" src="assets/calender/js/mark-your-calendar.js"></script>
    <script type="text/javascript">



function reloadCalendar(id) {
  
    var new_class = id ;
   // Remove old calendar container completely (not just empty)
  $('#picker').remove();

  // Add a fresh empty container for the calendar
  $('<div id="picker"></div>').appendTo('#calendar-wrapper'); // or wherever #picker was



   
   (function ($) {


function generateTimeSlots(startTime, endTime, teacherTimeZone, minStartTime = null) {
    let slots = [];
    let start = moment.tz(startTime, "HH:mm", teacherTimeZone);
    let end = moment.tz(endTime, "HH:mm", teacherTimeZone);

    while (start.isBefore(end)) {
        // Only add the slot if it's after the minimum start time
        if (!minStartTime || start.isSameOrAfter(minStartTime)) {
            slots.push(start.format("HH:mm"));
        }
        start.add(30, "minutes");
    }

    return slots;
}




    let profile = @json($profile);
    let gigPayment = @json($gigPayment);
    let gigData = @json($gigData);
    let duration = @json($admin_duration);
    let service_type = @json($gig->service_type);
    let bookedTimes = @json($bookedTimes) || [];
    let repeatDays = @json($repeatDays);
    let group_type = $('#group_type').val();
    let today = moment();
    let selectedDates = {};
    let isSubscription = gigData.payment_type === "Subscription";
      var class_time = @json($class->pluck('user_date')->flatten()->toArray());
    var teacher_class_time = @json($class->pluck('teacher_date')->flatten()->toArray());
    let maxAllowedDate = isSubscription ? moment().add(1, "month") : null;
    let timeZones = moment.tz.zonesForCountry(profile.country_code);
    // let teacherTimeZone = "Europe/London"; // Example: From the database
    let teacherTimeZone = @json($first_class->teacher_time_zone) ?? "UTC";
    let userTimeZone =  @json($first_class->user_time_zone) ?? "UTC";
   $('#time_zone_show').html(`Show Date/Time Based on ${teacherTimeZone}`);
  $('#user_time_zone').val(userTimeZone);
  $('#teacher_time_zone').val(teacherTimeZone);
  
  
  
  
  



    if (typeof bookedTimes === "string") {
        try {
            bookedTimes = JSON.parse(bookedTimes);
        } catch (error) {
            console.error("Error parsing bookedTimes JSON:", error);
            bookedTimes = [];
        }
    }

    if (!Array.isArray(bookedTimes)) {
        bookedTimes = Object.values(bookedTimes);
    }

    function getBlockedSlots() {
        let blockedSlots = {};
        bookedTimes.forEach((booking) => {
            let { teacher_date, duration } = booking;
            if (!teacher_date || !duration) return;
            let date = teacher_date ;
         
         
          
            
            let [formattedDate, bookedStartTime] = date.split(" ");
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
 

  function generateAvailability(startDate, teacherTimeZone) {
    let availability = [];
    let now = moment().tz(teacherTimeZone);
    let minStartTime = now.clone();

    // Create a Set of configured day names for fast lookup
    let configuredDays = new Set(repeatDays.map(rd => rd.day));

    var duration_booking;

    if (gigData.recurring_type === "OneDay") {
        duration_booking = duration.class_oneday || 1;
    } else if (service_type === "Inperson") {
        duration_booking = duration.class_inperson || 4;
    } else if (service_type === "Online") {
        duration_booking = duration.class_online || 3;
    }

    minStartTime.add(duration_booking, "hours");

    // Track how many valid days we've added
    let validDaysCount = 0;
    let daysChecked = 0;
    let maxDaysToCheck = 90; // Check up to 90 days to find 30 valid days

    while (validDaysCount < 30 && daysChecked < maxDaysToCheck) {
        let currentDate = moment(startDate).add(daysChecked, "days");
        let dayName = currentDate.format("dddd");
        let formattedDate = currentDate.format("YYYY-MM-DD");

        // Only process days that are in the configured repeatDays
        if (configuredDays.has(dayName)) {
            let currentDaySlots = [];
            let extendedSlots = [];

            repeatDays.forEach((repeatDay) => {
                if (repeatDay.day === dayName) {
                    let slots = generateTimeSlots(
                        repeatDay.start_time,
                        repeatDay.end_time,
                        teacherTimeZone,
                        currentDate.isSame(now, 'day') ? minStartTime : null
                    );

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
                }
            });

            // Only add this day to availability if it has slots
            if (currentDaySlots.length > 0) {
                availability[validDaysCount] = currentDaySlots;

                // Handle extended slots for next valid day
                if (extendedSlots.length > 0 && validDaysCount + 1 < 30) {
                    if (!availability[validDaysCount + 1]) {
                        availability[validDaysCount + 1] = [];
                    }
                    availability[validDaysCount + 1] = [...extendedSlots, ...availability[validDaysCount + 1]];
                }

                validDaysCount++;
            }
        }

        daysChecked++;
    }

    return availability;
}





    // Check if it's a one-day class
    let isOneDayClass = gigPayment.start_date !== null;
    let startDate = isOneDayClass ? moment(gigPayment.start_date) : today;
    let availability;

    if (isOneDayClass) {
    availability = new Array(2).fill(null).map(() => []);
    let now = moment().tz(teacherTimeZone);
    let minStartTime = now.clone();
        
  var duration_booking;

    if (gigData.recurring_type === "OneDay") {
    duration_booking = duration.class_oneday || 1;
    } else if (service_type === "Inperson") {
    duration_booking = duration.class_inperson || 4;
    } else if (service_type === "Online") {
    duration_booking = duration.class_online || 3;
    }  
    
    minStartTime.add(duration_booking, "hours");

    let slots = generateTimeSlots(
        gigPayment.start_time,
        gigPayment.end_time,
        teacherTimeZone,
        startDate.isSame(now, 'day') ? minStartTime : null
    );  
    

    let formattedDate = startDate.format("YYYY-MM-DD");
    let nextDate = startDate.clone().add(1, "day").format("YYYY-MM-DD");

    if (blockedSlots[formattedDate]) {
        slots = slots.filter((slot) => !blockedSlots[formattedDate].has(slot));
    }
 console.log(slots);
 
    let currentDaySlots = [];
    let extendedSlots = [];

   slots.forEach(slot => {
    // Move early-morning slots to the "next day" (extended)
     if (slot === "00:00" || slot < "04:00") {
            extendedSlots.push(slot);
        } else {
            currentDaySlots.push(slot);
        }
});

    availability[0] = currentDaySlots;

    if (extendedSlots.length > 0) {
        availability[1] = [...extendedSlots];
    }  
} else {
    availability = generateAvailability(today, teacherTimeZone);
}


   
    let currentViewDate = today; // Track the current view date

// Function to update navigation arrows based on the current view
function updateNavigationArrows() {
    let isFirstDateToday = currentViewDate.isSame(today, "day"); // Check if current view is today
    let isAtMaxAllowedDate = isSubscription && currentViewDate.isSame(maxAllowedDate, "day");

 
    $("#myc-prev-week").toggle(!isFirstDateToday);
   
    $("#myc-next-week").toggle(!(isSubscription && isAtMaxAllowedDate));
}



    $("#picker").markyourcalendar({
        availability: availability,
        isMultiple: true,
        startDate: startDate.toDate(),
        onClick: function (ev, data) {
    var frequency =  1; // Maximum allowed selections
    var duration = @json($first_class->duration); // Example: "2:30" or "00:30"
var durationParts = duration.split(":"); // Split into ["HH", "mm"]

var durationMinutes = (parseInt(durationParts[0]) * 60) + parseInt(durationParts[1]); // Convert to total minutes
    var selectedDate = moment(ev.date).format("YYYY-MM-DD");

    // Extract the last clicked slot (latest selection)
    let lastClickedSlot = data[data.length - 1]; 
    
    if (!lastClickedSlot) {
      $("#selected-dates").html("");
      
    $("#selected_slots").val(""); // Set class_time to empty
  
    
      // Get the current input values as arrays
var have_class_time = $('#class_time').val().split(",");
var have_teacher_class_time = $('#teacher_class_time').val().split(",");

// Replace values based on the new_class index (1-based)
for (let i = 0; i < class_time.length; i++) {
    // Only replace if the index is not the new_class
    if ((i + 1) !== new_class) {
        // Use .toString() to ensure the value is a proper string
        have_class_time[i] = class_time[i].toString().trim();
        have_teacher_class_time[i] = teacher_class_time[i].toString().trim();
        
    }
}

// Update the input fields
$('#class_time').val(have_class_time.join(","));
$('#teacher_class_time').val(have_teacher_class_time.join(","));

 


    // Set "Not Selected" for remaining classes (Initial Sync)
  
    $('#new_cls'+new_class).html("Not Selected");

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
        
     
          
        if (diff < durationMinutes) {
            console.log(`Slot ${lastClickedDateTime} is too close to ${slotDateTime}. Removing selection.`);
            isInvalid = true;
            break; // Stop checking once we find an invalid slot
        }
    }

    if (isInvalid) {
        data.pop(); // Remove last clicked slot
        $(`[data-date="${lastClickedParts[0]}"][data-time="${lastClickedParts[1]}"]`).removeClass("selected");

        alert(`You must select slots with at least ${durationMinutes} minutes gap on the same date.`);
        return; // Stop execution
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
            let userTime = moment.tz(`${time}`, "YYYY-MM-DD HH:mm", teacherTimeZone);
            let teacherTime = userTime.clone().tz(teacherTimeZone);
            let userFormattedTime = userTime.clone().tz(userTimeZone).format("YYYY-MM-DD HH:mm");
            let teacherFormattedTime = teacherTime.format("YYYY-MM-DD HH:mm");
            
            let durationMinutes = gigPayment.duration.split(":").reduce((h, m) => parseInt(h) * 60 + parseInt(m), 0);
            let endTime = userTime.clone().add(durationMinutes, "minutes");
            let formattedDisplay = userTime.format("ddd MMM D, YYYY h:mma") + " – " + endTime.format("h:mma");
            
            timePromises.push(GetAvailableTimes(teacherFormattedTime));
            teacher_time_slots.push(teacherFormattedTime);
            selectedValues.push(userFormattedTime);
            selectedSlots.push(formattedDisplay);
            
            $('#new_cls'+new_class).html(formattedDisplay);
            html += `<p><strong style="color:var(--Colors-Logo-Color, #0072b1);">Class ${selectedValues.length}:</strong> ${formattedDisplay}</p>`;
        });
    });

 


    Promise.allSettled(timePromises).then((results) => {
        let hasError = results.some(r => r.status === "rejected");
        if (hasError) {

          
        
           $('#new_cls' + new_class).html("Not Selected");
          data.pop(); // Remove last clicked slot
            return; // Stop execution if any error occurred
        }

        
        var classTimeStr = $('#class_time').val().split(","); // e.g. "1,2,3"
     
        
var classTimeArr = $('#teacher_class_time').val().split(",");

// Replace value at index (new_class - 1)
classTimeArr[new_class - 1] = selectedValues;

// Join back to CSV string
var updatedClassTimeStr = classTimeArr.join(",");

// Update input value
$("#class_time").val(updatedClassTimeStr);




        var teacherclassTimeStr = $('#teacher_class_time').val().split(","); // e.g. "1,2,3"
var teacherclassTimeArr =  $('#teacher_class_time').val().split(",");

// Replace value at index (new_class - 1)
teacherclassTimeArr[new_class - 1] = teacher_time_slots;

// Join back to CSV string
var teacherupdatedClassTimeStr = teacherclassTimeArr.join(",");

// Update input value
$("#teacher_class_time").val(teacherupdatedClassTimeStr);


        $("#selected-dates").html(html);
        $("#selected_slots").val(selectedSlots.join("|*|"));
       
    });
}
,
 
     onClickNavigator: function (ev, instance) {
     

    let direction = ev.target.id === "myc-next-week" ? "forward" : "back";
 

    // Update currentViewDate based on the navigation direction
    if (direction === "back") {
        currentViewDate = moment(currentViewDate).subtract(1, "week");
    } else if (direction === "forward") {
        // currentViewDate = moment(currentViewDate).add(1, "week");
        let nextDate = moment(currentViewDate).add(1, "week");
                if (isSubscription && nextDate.isAfter(maxAllowedDate, "day")) {
                    return; // Prevent moving beyond 1 month
                }
                currentViewDate = nextDate;
    }

    let selectedDate = moment(ev.date).format("YYYY-MM-DD");

    // Check if the selected date is in the past
    if (moment(selectedDate).isBefore(today, "day")) {
        alert("You cannot select past dates.");
        return false;
    }

    // Generate availability for the selected date
    let newAvailability = generateAvailability(selectedDate, teacherTimeZone, userTimeZone);
    instance.setAvailability(newAvailability);

    // ✅ Ensure navigation arrows update correctly
    updateNavigationArrows();

    // Reapply the selected class to slots for the current date
    setTimeout(() => {
      console.log(selectedDates);
      
        $.each(selectedDates, function (date, times) {
            $.each(times, function (index, time) {
              selected_t_d = time.split(' ');
              
                $(`[data-date="${selected_t_d[0]}"][data-time="${selected_t_d[1]}"]`).addClass("selected");
            });
        });
    }, 100);
}

    });

    // Hide previous navigation arrow on page load (since the calendar starts from today)
    $("#myc-prev-week").hide();
    // Hide navigation arrows for one-day class
    if (isOneDayClass) {
        $("#myc-prev-week").hide(); // Hide previous and next buttons
        $("#myc-next-week").hide(); // Hide previous and next buttons
    }

    function updateInputField() {
        
    }

    // Get Available Times ========
    function GetAvailableTimes(selector) {
    var date_time = selector;
    var gig_id = @json($gig->id);
    var group_type = $('#group_type').val() || null;
    var guests = $('#guests').val() || 1;

    return new Promise((resolve, reject) => {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: '/get-available-times',
            data: { gig_id: gig_id, date_time: date_time, group_type: group_type, _token: '{{csrf_token()}}' },
            dataType: 'json',
            success: function (response) {
                

                if (response.success) {
                    if (response.allowed_guests) {
                        let $guestsInput = $('#guests');
                        let enteredGuests = parseInt($guestsInput.val(), 10) || 0;
                        let allowedGuests = response.allowed_guests;

                        if (enteredGuests > allowedGuests) {
                            $guestsInput.val(allowedGuests).focus();
                            alert(`Maximum ${allowedGuests} guests allowed for booking at this time.`);
                        }
                    }
                    resolve(response);
                } else if (response.group_full) {

var duration = gigPayment.duration; // Example: "1:30" or "00:30"
var durationParts = duration.split(":"); // Split into ["HH", "mm"]

var durationMinutes = (parseInt(durationParts[0]) * 60) + parseInt(durationParts[1]); // Convert to total minutes

let date_timeParts = date_time.split(' ');
let selectedDate = date_timeParts[0];
let selectedTime = date_timeParts[1];

let selectedMoment = moment(`${selectedDate} ${selectedTime}`, "YYYY-MM-DD HH:mm");
let slotsToRemove = [];

// Always remove the selected slot
slotsToRemove.push(selectedMoment.format("YYYY-MM-DD HH:mm"));

// Remove previous slot only if duration is 1 hour or more
if (durationMinutes >= 60) { 
    slotsToRemove.push(selectedMoment.clone().subtract(30, "minutes").format("YYYY-MM-DD HH:mm"));
}

// Remove future slots based on duration
for (let i = 30; i < durationMinutes; i += 30) { // Start at 30 minutes, up to total duration
    slotsToRemove.push(selectedMoment.clone().add(i, "minutes").format("YYYY-MM-DD HH:mm"));
}
 

// Remove slots from `selectedDates`
if (selectedDates[selectedDate]) {
    selectedDates[selectedDate] = selectedDates[selectedDate].filter(slot => !slotsToRemove.includes(slot));
}
 




// Remove class from UI (deselect slots)
slotsToRemove.forEach(slot => {
    let TeacherTime = moment.tz(`${slot}`, "YYYY-MM-DD HH:mm", teacherTimeZone);
    
       let UserTime = TeacherTime.clone().tz(userTimeZone);
       slot = TeacherTime.format("YYYY-MM-DD HH:mm");
       let slotParts = slot.split(" ");
       let slotElement = $(`[data-date="${slotParts[0]}"][data-time="${slotParts[1]}"]`);
    
    if (slotElement.length > 0) {
        slotElement.remove();  // Remove the slot from the UI
        console.log("Removed slot:", slot);
    } else {
        console.warn("Slot not found in UI:", slot);
    }
});

alert(response.group_full);
reject("group_full");
}else if(response.booked) {
    let TeacherTime = moment.tz(`${response.bookedTime}`, "YYYY-MM-DD HH:mm", teacherTimeZone);
    let UserTime = TeacherTime.clone().tz(userTimeZone);
    slot = TeacherTime.format("YYYY-MM-DD HH:mm");
    let slotParts = slot.split(" ");
   
  let slotElement = $(`[data-date="${slotParts[0]}"][data-time="${slotParts[1]}"]`);
 

    if (slotElement.length > 0) {
        slotElement.remove();  // Remove the slot from the UI
        console.log("Removed slot:", slot);
    } else {
        console.warn("Slot not found in UI:", slot);
    }

                    alert(response.booked);
                    reject("error");
                }
 else { 
 
                    alert(response.error);
                    reject("error");
                }
            },
            error: function () {
                reject("ajax_error");
            }
        });
    });
}



})(jQuery);


}
  
  
  
  
    </script>
    
  
    {{-- Appointment Calender Booking ==== END --}}
  





</body>

</html>