<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" /> 
    {{-- Ajax Token Meta --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
           <!-- jQuery -->
   <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    

   {{-- =======Toastr CDN ======== --}}
   <link rel="stylesheet" type="text/css" 
   href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
   
   <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
   {{-- =======Toastr CDN ======== --}}
     {{-- Calender CDN ======= --}}
  
<!-- Include FullCalendar v3 (or earlier) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
     {{-- Calender CDN ======= --}}
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/teacher/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/teacher/asset/css/calender.css" />
    <link rel="stylesheet" href="assets/user/asset/css/style.css" />

    <title>Teacher Dashboard | Notes & Calender</title>
  </head>

  <style>
    
    .fc-toolbar.fc-header-toolbar{
      color: var(--Colors-Logo-Color, #0072b1);
    font-family: Roboto;
    font-size: 16px;
    font-style: normal;
    font-weight: 600;
    line-height: normal;
    }
    button.fc-today-button.fc-button.fc-state-default.fc-corner-left.fc-corner-right.fc-state-disabled,
    span.fc-icon.fc-icon-right-single-arrow,
    span.fc-icon.fc-icon-left-single-arrow{
      color: var(--Colors-Logo-Color, #0072b1);
    font-family: Roboto;
    font-size: 16px;
    font-style: normal;
    font-weight: 600;
    } 
    th.fc-day-header.fc-widget-header{
      color: var(--Colors-Logo-Color, #0072b1);
    text-align: center;
    font-family: Roboto;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: 50px;
    background-color: white; 
    border: none;

    }
   div#dates {
    display: none;
}
tbody.fc-body{
  background-color: white;
}

  </style>
  <body>
   {{-- ===========Teacher Sidebar Start==================== --}}
  <x-teacher-sidebar/>
  {{-- ===========Teacher Sidebar End==================== --}}
  <section class="home-section">
     {{-- ===========Teacher NavBar Start==================== --}}
     <x-teacher-nav/>
     {{-- ===========Teacher NavBar End==================== --}}

      <!-- =============================== MAIN CONTENT START HERE =========================== -->
      <div class="container-fluid">
        <div class="row calander-page">
          <div class="col-md-12">
            <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li
                  class="breadcrumb-item active"
                  style="color: var(--Colors-Text-Color, #181818) !important"
                  aria-current="page"
                >
                  Dashboard
                </li> 
                <li class="breadcrumb-item">
                  <a
                    href="#"
                    style="
                      color: var(--Colors-Light-Text, #7d7d7d);
                      text-decoration: none;
                    "
                    >Notes & Calendar</a
                  >
                </li>
              </ol>
            </nav>
            <div class="Notes-Calendar">
              <p>
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="20"
                  height="20"
                  viewBox="0 0 20 20"
                  fill="none"
                >
                  <path
                    d="M9.53333 7V11.0161H9.57586L11.3338 13L12.3333 11.8675L10.951 10.3012V7H9.53333Z"
                    fill="white"
                  />
                  <path
                    d="M10.1892 3C9.00655 3.0039 7.84528 3.32424 6.81967 3.92949C5.79407 4.53474 4.93948 5.40403 4.34002 6.45181C3.74057 7.49959 3.4169 8.68974 3.40088 9.90513C3.38485 11.1205 3.67703 12.3192 4.24865 13.3833L3 14.6667H7.16216V10.3889L5.36108 12.24C4.89059 11.1688 4.77002 9.96981 5.01738 8.82232C5.26474 7.67483 5.86675 6.64041 6.73345 5.87367C7.60014 5.10692 8.68498 4.64902 9.82584 4.56838C10.9667 4.48775 12.1023 4.78872 13.063 5.42632C14.0236 6.06391 14.7577 7.00389 15.1556 8.10578C15.5535 9.20767 15.5937 10.4123 15.2703 11.5396C14.9469 12.667 14.2773 13.6565 13.3614 14.3603C12.4456 15.0641 11.3327 15.4445 10.1892 15.4444V17C11.9955 17 13.7279 16.2625 15.0052 14.9497C16.2824 13.637 17 11.8565 17 10C17 8.14348 16.2824 6.36301 15.0052 5.05025C13.7279 3.7375 11.9955 3 10.1892 3Z"
                    fill="white"
                  />
                </svg>
                &nbsp; Notes & Calendar
              </p>
            </div>

            <div class="calendar float-end">
              <div class="header event-header">
              
                <div class="event-calender">
                  <div class="calendar-buttons">
                    <button id="AddNotesBtn"
                      class="btn btn-primarys"
                    >
                      + &nbsp; Add to Calendar
                    </button>
                  </div>
                </div>
              </div>
             


              <div id="calendar"></div>


            </div>

            {{-- <div class="card-body">
              <div id='calendar'></div>
          </div> --}}

            <!-- Event Popup -->
            <div
              id="eventPopupContainer"
              class="popup-container"
              style="display: none"
            >
              <div id="eventPopup" class="popup">
                <div class="modal-content event-content">
                  <span class="close" onclick="closeEventPopup()">&times;</span>
                  <h2>Add Event</h2>
                  <p id="eventDate"></p>
                  <textarea
                    class="event-desc"
                    id="eventDescription"
                    placeholder="Enter event description"
                  ></textarea>
                  <button
                    id="saveEventBtn"
                    class="save-event-btn"
                    onclick="saveEvent()"
                  >
                    Save Event
                  </button>
                  <button
                    class="deleteEventBtn delete-event-btn"
                    onclick="deleteEvent()"
                  >
                    Delete Event
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- =============================== MAIN CONTENT END HERE =========================== -->
      <div class="copyright">
        <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
      </div>
    </section>
   

    {{-- <script src="assets/teacher/libs/jquery/jquery.js"></script> --}}
    <script src="assets/teacher/libs/datatable/js/datatable.js"></script>
    <script src="assets/teacher/libs/datatable/js/datatablebootstrap.js"></script>
    <script src="assets/teacher/libs/select2/js/select2.min.js"></script>
    <script src="assets/teacher/libs/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="assets/teacher/libs/aos/js/aos.js"></script>
    <script src="assets/teacher/asset/js/bootstrap.min.js"></script>
    <script src="assets/teacher/asset/js/script.js"></script>
    
  </body>

 
   



<script>
  $(document).ready(function () {

    $('#AddNotesBtn').click(function (e) { 
      e.preventDefault();
      $('#calendar-add-modal').modal('show');
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

      var calendar = $('#calendar').fullCalendar({
          events: '/teacher-calendar',  // Get events from server
          selectable: true,
          selectHelper: true,

          // On date click, open modal to add event
          dayClick: function (date, jsEvent, view ) {
              $('#calendar-add-modal').modal('show');
              $('#date').val(date.format()); // Pre-fill date
             
          },

          // On event click, open modal to update event
          eventClick: function (event) {
            $('#calendar-add-modal').modal('hide');
              $('#calendar-upd-modal').modal('show');
              $('#title_upd').val(event.title);
              $('#date_upd').val(event.start.format());
              $('#time_upd').val(event.time);
              $('#reminder_upd').val(event.reminder);
              $('#color_upd').val(event.color);
              $('#notes_upd').val(event.notes);
              $('#event_id').val(event.id); // Set event ID for update
          }
      });

      // Submit event form via AJAX
      $('#eventFormAdd').on('submit', function (e) {
          e.preventDefault();

        var title =  $('#title').val();
        var date =     $('#date').val();
        var time =    $('#time').val();
        var reminder =   $('#reminder').val();
        var color =   $('#color').val(); 
        var notes =   $('#notes').val(); 
       
        
          let method = 'POST';
          let url = '/teacher-calendar';

          $.ajax({
              url: url,
              type: method,
              data: { title:title, date:date, time:time, reminder:reminder, color:color, notes:notes, _token: '{{csrf_token()}}'},
              success: function (response) {  
                  $('#calendar-add-modal').modal('hide');
                  calendar.fullCalendar('refetchEvents');
              },
              error: function (xhr) {
                  alert('An error occurred.');
              }
          });
      });
      // Update Submit event form via AJAX
      $('#eventFormUpd').on('submit', function (e) {
          e.preventDefault();

          let id = $('#event_id').val();
          let method ='PUT';
          let url = '/teacher-calendar/' + id ;

          $.ajax({
              url: url,
              type: method,
              data: $(this).serialize(),
              success: function (response) {
                  $('#calendar-upd-modal').modal('hide');
                  calendar.fullCalendar('refetchEvents');
              },
              error: function (xhr) {
                  alert('An error occurred.');
              }
          });
      });

      // Delete event
      $('#deleteEvent').click(function () {
          let id = $('#event_id').val();

          if (confirm('Are you sure you want to delete this event?')) {
              $.ajax({
                  url: '/teacher-calendar/' + id,
                  type: 'DELETE',
                  success: function (response) {
                    $('#calendar-upd-modal').modal('hide');
                      calendar.fullCalendar('refetchEvents');
                  },
                  error: function (xhr) {
                      alert('An error occurred....');
                  }
              });
          }
      });
  });
</script>



 <!-- Add Event Modal -->
 {{-- <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <form id="eventForm">
              <div class="modal-header">
                  <h5 class="modal-title" id="eventModalLabel">Add Event</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <input type="hidden" name="id" id="event_id">
                  <div class="form-group">
                      <label for="title">Event Title</label>
                      <input type="text" class="form-control" id="title" name="title">
                  </div>
                  <div class="form-group">
                      <label for="date">Date</label>
                      <input type="date" class="form-control" id="date" name="date">
                  </div>
                  <div class="form-group">
                      <label for="time">Time</label>
                      <input type="time" class="form-control" id="time" name="time">
                  </div>
                  <div class="form-group">
                      <label for="color">Color</label>
                      <input type="color" class="form-control" id="color" name="color">
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save Event</button>
              </div>
          </form>
      </div>
  </div>
</div> --}}


{{-- Event Add Model ========= --}}

  <div
    class="modal fade calendar-add"
    id="calendar-add-modal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content calendar-content">
        <h5 class="calender-heading" id="exampleModalLabel">Add to Calendar</h5>
        <div class="modal-body pb-0">
          <form id="eventFormAdd">
            <div class="mb-3">
              <label for="recipient-name" class="col-form-label">Date:</label>
              <input
                type="date"
                class="form-control"
                id="date" name="date"
                placeholder="September 23, 2023"
              />
            </div>
            <div class="mb-3">
              <label for="recipient-name" class="col-form-label">Time</label>
              <input type="time" class="form-control" id="time" name="time" />
            </div>
            <div class="mb-3">
              <label for="recipient-name" class="col-form-label"
                >Label Color</label
              > 
              <input type="color" class="form-control" id="color" name="color">
            </div>
            <div class="mb-3">
              <label for="recipient-name" class="col-form-label"
                >Reminder</label
              >
              <input
                type="text"
                class="form-control"
                id="reminder" name="reminder"
                placeholder="30 Minute before"
              />
            </div>
            <div class="mb-3">
              <label for="recipient-name" class="col-form-label">Title</label>
              <input
                type="text"
                class="form-control"
                id="title" name="title"
                placeholder="New Class Arrival"
              />
            </div>
            <div class="mb-3">
              <label for="message-text" class="col-form-label">Notes</label>
              <textarea
                class="form-control"
                id="notes" name="notes"
                placeholder="Notes"
              ></textarea>
            </div>
          
          <div class="button-sec">
            <button
              type="button"
              class="btn btn-secondarys"
              data-bs-dismiss="modal"
              data-bs-target="#exampleModal1"
            >
              Cancel
            </button>
            <!-- <button type="button" class="btns btn-primarya">Add</button> -->
            <button  type="submit"  class="btns btn-primarya"  >  Add  </button>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>


  {{-- Event Update Model --}}

  <div
  class="modal fade calendar-add"
  id="calendar-upd-modal"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog">
    <div class="modal-content calendar-content">
      <h5 class="calender-heading" id="exampleModalLabel">Update to Calendar</h5>
      <div class="modal-body pb-0">
        <form id="eventFormUpd" >
          <input type="hidden" name="id" id="event_id">
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Date:</label>
            <input
              type="date"
              class="form-control"
              id="date_upd" name="date_upd"
              placeholder="September 23, 2023"
            />
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Time</label>
            <input type="time" class="form-control" id="time_upd" name="time_upd" />
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label"
              >Label Color</label
            > 
            <input type="color" class="form-control" id="color_upd" name="color_upd">
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label"
              >Reminder</label
            >
            <input
              type="text"
              class="form-control"
              id="reminder_upd" name="reminder_upd"
              placeholder="30 Minute before"
            />
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Title</label>
            <input
              type="text"
              class="form-control"
              id="title_upd" name="title_upd"
              placeholder="New Class Arrival"
            />
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Notes</label>
            <textarea
              class="form-control"
              id="notes_upd" name="notes_upd"
              placeholder="Notes"
            ></textarea>
          </div> 

        <div class="button-sec">
          <button
            type="button" id="deleteEvent" 
            class="btn btn-secondarys" 
          >
            Delete
          </button>
          <!-- <button type="button" class="btns btn-primarya">Add</button> -->
          {{-- <button  type="button" id="deleteEvent"  class="btns btn-danger"  >  Delete  </button> --}}
          <button  type="submit"  class="btns btn-primarya"  >  Update  </button>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>

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
<!-- event calendar js -->
 

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




<script>
  $(document).ready(function () {
    $(document).on("click", "#add-calendar", function (e) {
      e.preventDefault();
      $("#exampleModal-1").modal("show");
      $("#exampleModal2").modal("hide");
    });

    $(document).on("click", "#add-calendar", function (e) {
      e.preventDefault();
      $("#exampleModal2").modal("show");
      $("#exampleModal-1").modal("hide");
    });
  });
</script>
<!-- radio js here -->
 
