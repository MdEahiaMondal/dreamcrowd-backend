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

.rectangle h3{
    width: 102px;
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
                                                $startTime = Auth::user()->role == 1 ? $item->teacher_date : $item->user_date;
                                                $timeZone = Auth::user()->role == 1 ? $item->teacher_time_zone : $item->user_time_zone;
                                                
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
                                                $startTime = Auth::user()->role == 1 ? $item->teacher_date : $item->user_date;
                                                $timeZone = Auth::user()->role == 1 ? $item->teacher_time_zone : $item->user_time_zone;
                                                
                                                // Parse the start time with the appropriate time zone
                                                $start = Carbon::parse($startTime, $timeZone);
                                                
                                                // Split the duration into hours and minutes
                                                list($hours, $minutes) = explode(':', $item->duration);
                                                $totalMinutes = ($hours * 60) + $minutes;
                                                
                                                // Calculate the end time
                                                $end = $start->copy()->addMinutes($totalMinutes);
                                                @endphp
                                    
                                    <div class="col-md-3 rectangle-desc  new_main   class_main_{{$i}}"> 
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
                                        <strong>Service Available Days:</strong>
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
                                      <input type="hidden" name="teacher_class_time" id="teacher_class_time"  value="{{ implode(',', $class->pluck('teacher_date')->toArray()) }}">
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
        //   reloadCalendar(id);
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
 

(function ($) {
  
 
// Function to generate time slots between start and end times (Teacher Time Zone)
function generateTimeSlots(startTime, endTime, teacherTimeZone) {
    let slots = [];
    let start = moment.tz(startTime, "HH:mm", teacherTimeZone);
    let end = moment.tz(endTime, "HH:mm", teacherTimeZone);

    while (start.isBefore(end)) {
        slots.push(start.format("HH:mm"));
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
let teacherTimeZone = @json($first_class->teacher_time_zone) ?? "UTC";
let userTimeZone =  @json($first_class->user_time_zone) ?? "UTC";
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

 
// Function to get blocked slots based on booked times (Teacher Time Zone)
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
// Generate availability slots
function generateAvailability(startDate, teacherTimeZone) {
    let availability = [];

    // Create a Set of configured day names for fast lookup
    let configuredDays = new Set(repeatDays.map(rd => rd.day));

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
                    let slots = generateTimeSlots(repeatDay.start_time, repeatDay.end_time, teacherTimeZone);

                    // Filter blocked slots (still in teacher time zone)
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
    var duration = gigPayment.duration || '00:00'; // Example: "2:30" or "00:30"
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
     $('#new_cls1').html("Not Selected");
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
            // Convert to user time for display
            let userTime = moment.tz(time, "YYYY-MM-DD HH:mm", teacherTimeZone).tz(userTimeZone);
            let teacherTime = moment.tz(time, "YYYY-MM-DD HH:mm", teacherTimeZone);

            // Format display for user time zone
            let formattedDisplay = teacherTime.format("ddd MMM D, YYYY h:mma");
            selectedSlots.push(formattedDisplay);

            // Store raw teacher time (no conversion)
            teacher_time_slots.push(teacherTime.format("YYYY-MM-DD HH:mm"));
            selectedValues.push(userTime.format("YYYY-MM-DD HH:mm"));

            // Update HTML for selected slot
            $('#new_cls' + selectedValues.length).html(formattedDisplay);
            html += `<p><strong style="color:var(--Colors-Logo-Color, #0072b1);">Start Date & Time:</strong>  ${formattedDisplay}</p>`;
        });
    });


    // Set "Not Selected" for remaining classes (Initial Sync)
let totalClasses = {{ count($class) }};
for (let i = selectedValues.length + 1; i <= totalClasses; i++) {
    $('#new_cls' + i).html("Not Selected");
}


    Promise.allSettled(timePromises).then((results) => {
        let hasError = results.some(r => r.status === "rejected");
        if (hasError) {

              $('#new_cls' + selectedValues.length).html("Not Selected");
              
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
  





</body>

</html>