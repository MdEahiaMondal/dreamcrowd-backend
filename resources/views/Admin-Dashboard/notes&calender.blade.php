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
    <link rel="stylesheet" type="text/css" href="assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/admin/asset/css/style.css" />
    <link
      rel="stylesheet"
      href="assets/teacher/asset/css/calender.css"
    />
    <link rel="stylesheet" href="assets/user/asset/css/style.css" />
    <title>Super Admin Dashboard | Notes & Calender</title>
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
      {{-- ===========Admin Sidebar Start==================== --}}
   <x-admin-sidebar/>
   {{-- ===========Admin Sidebar End==================== --}}
   <section class="home-section">
      {{-- ===========Admin NavBar Start==================== --}}
      <x-admin-nav/>
      {{-- ===========Admin NavBar End==================== --}}
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
                <i class="bx bx-notepad icon" title="Notes & Calendar"></i>

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

    {{-- <script src="assets/admin/libs/jquery/jquery.js"></script> --}}
    <script src="assets/admin/libs/datatable/js/datatable.js"></script>
    <script src="assets/admin/libs/datatable/js/datatablebootstrap.js"></script>
    <script src="assets/admin/libs/select2/js/select2.min.js"></script>
    <script src="assets/admin/libs/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="assets/admin/libs/aos/js/aos.js"></script>
    <script src="assets/admin/asset/js/bootstrap.min.js"></script>
    <script src="assets/admin/asset/js/script.js"></script>
  </body>
</html>
<!-- event calendar js -->



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
          events: '/admin-calendar',  // Get events from server
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
          let url = '/admin-calendar';

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
          let url = '/admin-calendar/' + id ;

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
                  url: '/admin-calendar/' + id,
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
        <form>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Date:</label>
            <input
              type="date"
              class="form-control"
              id="recipient-name"
              placeholder="September 23, 2023"
            />
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Time</label>
            <input type="time" class="form-control" id="recipient-name" />
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label"
              >Label Color</label
            >
            <br />
            <select name="" id="">
              <option value="">Red</option>
              <option value="">Green</option>
              <option value="">Blue</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Reminder</label>
            <input
              type="text"
              class="form-control"
              id="recipient-name"
              placeholder="30 Minute before"
            />
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Title</label>
            <input
              type="text"
              class="form-control"
              id="recipient-name"
              placeholder="New Class Arrival"
            />
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Notes</label>
            <textarea
              class="form-control"
              id="message-text"
              placeholder="Notes"
            ></textarea>
          </div>
        </form>
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
          <button
            type="button"
            class="btns btn-primarya"
            data-bs-toggle="modal"
            data-bs-target="#"
            id=""
          >
            Add
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div
  class="modal fade calendar-add"
  id="exampleModal2"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog">
    <div class="modal-contnt">
      <div class="modal-body">
        <div class="mb-3">
          <label for="recipient-name" class="col-form-label"
            >Date and Time</label
          >
          <div>
            <!-- date and time Picker -->
            <input
              type="text"
              class="form-control"
              placeholder="Monday, September 2, 2023   ---   4:00-5:00 am"
            />
          </div>
        </div>
        <div class="mb-3">
          <label for="recipient-name" class="col-form-label">Title</label>
          <input
            type="text"
            class="form-control"
            id="recipient-name"
            placeholder="New Batch will start"
          />
        </div>
        <div class="mb-3">
          <label for="recipient-name" class="col-form-label">Description</label>
          <textarea
            class="form-control"
            cols="20"
            role="20"
            id="message-text"
            placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vitae ut tellus quis a euismod ut nisl, quis. Tristique bibendum morbi vel vitae ultrices donec accumsan"
          ></textarea>
        </div>
        <div class="mb-3">
          <label for="recipient-name" class="col-form-label">Reminder</label>
          <div>
            <input
              type="text"
              class="form-control"
              placeholder="30 minute Before"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- add calendar jquery -->
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
