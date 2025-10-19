<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <!-- View Point scale to 1.0 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
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
     <!-- jQuery -->
     <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    

    {{-- =======Toastr CDN ======== --}}
    <link rel="stylesheet" type="text/css" 
    href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- =======Toastr CDN ======== --}}
    <!-- Bootstrap css -->
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/admin/asset/css/bootstrap.min.css"
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
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/admin/asset/css/style.css" />
    <link rel="stylesheet" href="assets/user/asset/css/style.css" />
    <link rel="stylesheet" href="assets/admin/asset/css/admin-management.css" />
    <title>Super Admin Dashboard | Admin Management</title>
  </head>
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


      {{-- ===========Admin Sidebar Start==================== --}}
   <x-admin-sidebar/>
   {{-- ===========Admin Sidebar End==================== --}}
   <section class="home-section">
      {{-- ===========Admin NavBar Start==================== --}}
      <x-admin-nav/>
      {{-- ===========Admin NavBar End==================== --}}
      <!-- =============================== MAIN CONTENT START HERE =========================== -->
      <div class="container-fluid">
        <div class="row dash-notification">
          <div class="col-md-12">
            <div class="dash">
              <div class="row">
                <div class="col-md-12">
                  <div class="dash-top">
                    <h1 class="dash-title">Dashboard</h1>
                    <i class="fa-solid fa-chevron-right"></i>
                    <span class="min-title">Admin Management</span>
                  </div>
                </div>
              </div>
              <!-- Blue MASSEGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <i class="bx bx-user icon" title="Buyer Management"></i>
                      <h2>Admin Management</h2>
                    </div>
                  </div>
                </div>
              </div>

              <!-- ================================== -->
              <div class="send-notify">
                <div class="row">
                  <div class="col-md-12">
                    <button
                      type="button"
                      class="btn"
                      data-bs-target="#exampleModalToggle"
                      data-bs-toggle="modal"
                    >
                      + Create New Admin
                    </button>
                  </div>
                </div>
              </div>
              <!-- ================================== -->
              <!-- ============= TABLE START HERE ================ -->
              <div class="installment-table">
                <div class="row">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <div class="hack1">
                        <div class="hack2">
                          <table class="table">
                            <thead>
                              <tr class="text-nowrap">
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Password</th>
                                <th>Joining Date</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>

                              @if (!empty($admins))
                              @foreach ($admins as $item)
                              <tr>
                                <td>{{$item->first_name}}</td>
                                <td>{{$item->last_name}}</td>
                                <td>{{$item->email}}</td>
                                <td>
                                  @if ($item->admin_role == 1)
                                    Dashboard Viewer
                                    @elseif($item->admin_role == 2)
                                    Contributer
                                    @elseif($item->admin_role == 3)
                                    Editor Admin
                                    @elseif($item->admin_role == 4)
                                    Top Admin
                                    @elseif($item->admin_role == 5)
                                    Super Admin
                                 
                                @endif
                              </td>
                                <td>{{$item->password}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>
                                  <div class="expert-dropdown">
                                    <button
                                      class="btn action-btn"
                                      type="button"
                                      id="dropdownMenuButton1"
                                      data-bs-toggle="dropdown"
                                      aria-expanded="false"
                                    >
                                      ...
                                    </button>
                                    <ul
                                      class="dropdown-menu"
                                      aria-labelledby="dropdownMenuButton1"
                                    >
                                      <a class="dropdown-item" type="button" onclick="UpdateAdmin(this.id)" id="admin_{{$item->id}}" data-first_name="{{$item->first_name}}" data-last_name="{{$item->last_name}}" data-email="{{$item->email}}"  data-role="{{$item->admin_role}}"
                                        ><li>Edit Details</li></a
                                      >
                                      <a
                                      class="dropdown-item"
                                      onclick="DeleteConfirmation(this.id)" id="delete-btn{{$item->id}}" data-act="Block" data-id="{{$item->id}}"
                                      {{-- href="/delete-admin/{{$item->id}}" --}}
                                      type="button"
                                      ><li>
                                        @if ($item->status == 2)
                                        Allow Admin
                                        @else
                                        Block Admin
                                        @endif
                                       
                                      </li></a >

                                      @if (Auth::user()->admin_role == 6)
                                      <a
                                      class="dropdown-item"
                                      onclick="DeleteConfirmation(this.id)" id="delete-btn{{$item->id}}" data-id="{{$item->id}}"  data-act="Delete"
                                      {{-- href="/delete-admin/{{$item->id}}" --}}
                                      type="button"
                                      ><li>Delete Admin</li></a >
                                      @endif
                                 
                                    </ul>
                                  </div>
                                </td>
                              </tr>
                              @endforeach
                                  
                              @endif
                          
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- ============= TABLE END HERE ================ -->
            </div>
          </div>
        </div>
      </div>
      <!-- pagination start from here -->
      <div class="demo">
        {{-- <nav class="pagination-outer" aria-label="Page navigation"> --}}
          {!! $admins->withQueryString()->links('pagination::bootstrap-5') !!}
          {{-- <ul class="pagination">
            <li class="page-item">
              <a href="#" class="page-link" aria-label="Previous">
                <span aria-hidden="true">«</span>
              </a>
            </li>
            <li class="page-item active">
              <a class="page-link" href="#">1</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">4</a></li>
            <li class="page-item"><a class="page-link" href="#">5</a></li>
            <li class="page-item">
              <a href="#" class="page-link" aria-label="Next">
                <span aria-hidden="true">»</span>
              </a>
            </li>
          </ul> --}}
        {{-- </nav> --}}
       
      </div>
      <!-- pagination ended here -->
      <!-- copyright section start from here -->
      <div class="copyright">
        <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
      </div>
      <!-- =============================== MAIN CONTENT END HERE =========================== -->
    </section>

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
{{-- Model Show Hide Script Start====== --}}
<script>
  $(document).ready(function () {
    //  // Event delegation for Create Edit Model links within modals
    //  $(document).on('click', 'body', function(e) {
    //         e.preventDefault();
    //         if (!$(this.target).is('.show_model')) {
    //         $('#exampleModalToggle').modal('hide'); // Hide the signup modal if shown
    //         $('#editadmin').modal('hide'); // Hide the signup modal if shown
    //         }
    //       });
     // Event delegation for Create Edit Model links within modals
     $(document).on('click', '.cancel_model', function(e) {
            e.preventDefault();
             
            $('#exampleModalToggle').modal('hide'); // Hide the signup modal if shown
            $('#editadmin').modal('hide'); // Hide the signup modal if shown
            
          });
        });
      </script>
{{-- Model Show Hide Script End====== --}}
{{-- Delete Confirmation PopUp Show For Confirmation Script Start --}}
<script>
  function DeleteConfirmation(Clicked) {
    var id = $('#'+Clicked).data('id');
    var act = $('#'+Clicked).data('act');
    
    if (act == 'Delete') {
      $("#delete-submit").attr("href", "/delete-admin/"+id);
      
    } else {
      
      $("#delete-submit").attr("href", "/block-admin/"+id);
    }
    $('#deleteConfirmationModel').modal('show'); // Hide the signup modal if shown

    }
</script>
{{-- Delete Confirmation PopUp Show For Confirmation Script End --}}
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
{{-- Update Admin Details Script Start ================ --}}
<script>
  function UpdateAdmin(Clicked) {
   var $get_id = Clicked.split('_');
   var id = $get_id[1];
   var first_name = $('#'+Clicked).data("first_name");
   var last_name = $('#'+Clicked).data("last_name");
   var email = $('#'+Clicked).data("email");
   var role = $('#'+Clicked).data("role");

   $('#first_name_upd').val(first_name);
   $('#last_name_upd').val(last_name);
   $('#email_upd').val(email);
   $('#role_upd').val(role);
   $('#admin_id').val(id);
   $('#new_password').val('');
   $('#new_c_password').val('');

   $('#editadmin').modal('show');
  }
</script>
{{-- Update Admin Details Script END ================ --}}
<!-- =========== ADD NEW ADMIN POPUP ============= -->
<div
  class="modal fade"
  id="exampleModalToggle"
  aria-hidden="true"
  aria-labelledby="exampleModalToggleLabel"
  tabindex="-1"
>
<form action="/create-admin" method="POST">
  @csrf

  <div class="modal-dialog modal-dialog-centered mt-5">
    <div class="modal-content mt-2">
      <div class="card-header text-center">Create New Admin</div>
      <div class="model_popup">
        <label for="car" class="form-label">Name</label>
        <input
          class="form-control"
          list="datalistOptions"
          id="car" name="first_name"
          placeholder="Usama Aslam" required
        />
        <label for="car" class="form-label">Last Name</label>
        <input
          class="form-control"
          list="datalistOptions"
          id="car" name="last_name" 
          placeholder="usama_aslam098" required
        />
        <label for="car" class="form-label">Email</label>
        <input
          class="form-control"
          list="datalistOptions"
          id="car" name="email"
          placeholder="example@gmail.com" required
        />
        <label for="car" class="form-label">Role</label>
        <select name="role" id="">
          {{-- <option value="">--Select Role--</option> --}}
          @for ($i = 1; $i < Auth::user()->admin_role ; $i++)

          @if ($i == 1)
          <option value="1" selected>Dashboard Viewer</option>
          @elseif($i == 2)   
          <option value="2">Contributer</option>
          @elseif($i == 3)   
          <option value="3">Editor Admin</option>
          @elseif($i == 4)   
          <option value="4">Top Admin</option>
            
          @else
          <option value="5">Super Admin</option>
              
          @endif
              
          @endfor 
        </select>

        <label for="car" class="form-label">Password</label>
        <input
          class="form-control"
          list="datalistOptions"
          id="add_password" name="password"
          placeholder="password" required
        />
        <div id="passwordPopup" class="password-popup">
          <ul>
              <li id="length">At least 8 characters</li>
              <li id="capital">At least one uppercase letter</li>
              <li id="number">At least one number</li>
              <li id="special">At least one special character</li>
          </ul>
      </div>
      <style>
            .password-popup {
              display: none;
              position: absolute;
              top: 310px;
              left: 280px;
              background-color: #f9f9f9;
              border: 1px solid #ccc;
              border-radius: 10px ;
              padding: 10px;
              width: max-content;
              box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
          }
          .password-popup ul {
              list-style: none;
              padding: 0;
              margin: 0;
          }
          .password-popup ul li {
              font-size: 10px ;
              margin-bottom: 5px;
              color: #ff0000 !important; /* Red color for unfulfilled criteria */
          }
          .password-popup ul li.valid {
              color: #00cc00 !important; /* Green color for fulfilled criteria */
          }
      </style>
        <label for="car" class="form-label">Confirm Password</label>
        <input
          class="form-control"
          list="datalistOptions"
          id="car" name="c_password"
          placeholder="confirm password" required
        />
        <button type="button" class="btn1 cancel_model">Cancel</button>
        <button type="submit" class="btn2 show_model">Create Admin</button>
      </div>
    </div>
  </div>
</form>
</div>
<!-- Edit Admin Popup -->
<div
  class="modal fade"
  id="editadmin"
  aria-hidden="true"
  aria-labelledby="exampleModalToggleLabel"
  tabindex="-1"
>
<form action="/update-admin" method="POST">
  @csrf

  <div class="modal-dialog modal-dialog-centered mt-5">
    <div class="modal-content mt-2">
      <div class="card-header text-center">Edit Detail</div>
      <div class="model_popup">
        <label for="car" class="form-label">First Name</label>
        <input type="hidden" name="id" id="admin_id">
        <input
          class="form-control"
          list="datalistOptions"
          id="first_name_upd" name="first_name"
          placeholder="Usama Aslam" required
        />
        <label for="car" class="form-label">Last Name</label>
        <input
          class="form-control"
          list="datalistOptions"
          id="last_name_upd" name="last_name"
          placeholder="usama_aslam098" required
        />
        <label for="car" class="form-label">Email</label>
        <input
          class="form-control"
          list="datalistOptions"
          id="email_upd" name="email"
          placeholder="example@gmail.com" required
        />
        <label for="car" class="form-label">Role</label>
        <select name="role" id="role_upd">
          @for ($i = 1; $i < Auth::user()->admin_role ; $i++)

          @if ($i == 1)
          <option value="1">Dashboard Viewer</option>
          @elseif($i == 2)   
          <option value="2">Contributer</option>
          @elseif($i == 3)   
          <option value="3">Editor Admin</option>
          @elseif($i == 4)   
          <option value="4">Top Admin</option>
            
          @else
          <option value="5">Super Admin</option>
              
          @endif
          @endfor
       
        </select>

        <label for="car" class="form-label">Password</label>
        <input
          class="form-control"
          list="datalistOptions"
          id="new_password" name="password"
          placeholder="password"
        />
        <div id="new_passwordPopup" class="password-popup">
          <ul>
              <li id="new_length">At least 8 characters</li>
              <li id="new_capital">At least one uppercase letter</li>
              <li id="new_number">At least one number</li>
              <li id="new_special">At least one special character</li>
          </ul>
      </div>
      <style>
            .password-popup {
              display: none;
              position: absolute;
              top: 310px;
              left: 280px;
              background-color: #f9f9f9;
              border: 1px solid #ccc;
              border-radius: 10px ;
              padding: 10px;
              width: max-content;
              box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
          }
          .password-popup ul {
              list-style: none;
              padding: 0;
              margin: 0;
          }
          .password-popup ul li {
              font-size: 10px ;
              margin-bottom: 5px;
              color: #ff0000 !important; /* Red color for unfulfilled criteria */
          }
          .password-popup ul li.valid {
              color: #00cc00 !important; /* Green color for fulfilled criteria */
          }
      </style>
        <label for="car" class="form-label">Confirm Password</label>
        <input
          class="form-control"
          list="datalistOptions"
          id="new_c_password" name="c_password"
          placeholder="confirm password"
        />
        <button type="button" class="btn1 cancel_model">Cancel</button>
        <button type="submit" class="btn2 show_model">Update Admin</button>
      </div>
    </div>
  </div>
</form>
</div>



{{-- Delete Confirmation Pop Model --}}
<div
class="modal fade delete-modal"
id="deleteConfirmationModel"
tabindex="-1"
aria-labelledby="exampleModalLabel"
aria-hidden="true"
>
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-body">
      <h1>Are you really sure you want to delete this?</h1>
      <div class="btn-sec">
        <center>
          <button
            type="button"
            class="btn btn-no cancel_model"
            id="cancelButton"
            data-bs-dismiss="modal"
          >
            Cancel
          </button>
          <a
            
            class="btn btn-yes"
            id="delete-submit"
          >  Yes  </a>
        </center>
      </div>
    </div>
  </div>
</div>
</div>



   {{-- On Focus Password Requirement Script Start --}}
   <script>
    // Select elements
    const passwordInput = document.getElementById('add_password');
    const passwordPopup = document.getElementById('passwordPopup');

    const lengthCriteria = document.getElementById('length');
    const capitalCriteria = document.getElementById('capital');
    const numberCriteria = document.getElementById('number');
    const specialCriteria = document.getElementById('special');

    // Show popup on focus
    passwordInput.addEventListener('focus', () => {
        passwordPopup.style.display = 'block';
    });

    // Hide popup on blur
    passwordInput.addEventListener('blur', () => {
        passwordPopup.style.display = 'none';
    });

    // Validate password on input
    passwordInput.addEventListener('input', () => {
        const passwordValue = passwordInput.value;

        // Validate length (at least 8 characters)
        if (passwordValue.length >= 8) {
            lengthCriteria.classList.add('valid');
        } else {
            lengthCriteria.classList.remove('valid');
        }

        // Validate capital letter
        if (/[A-Z]/.test(passwordValue)) {
            capitalCriteria.classList.add('valid');
        } else {
            capitalCriteria.classList.remove('valid');
        }

        // Validate number
        if (/[0-9]/.test(passwordValue)) {
            numberCriteria.classList.add('valid');
        } else {
            numberCriteria.classList.remove('valid');
        }

        // Validate special character
        if (/[\W_]/.test(passwordValue)) { // \W matches any non-word character
            specialCriteria.classList.add('valid');
        } else {
            specialCriteria.classList.remove('valid');
        }
    });


    // Select elements
    const new_passwordInput = document.getElementById('new_password');
    const new_passwordPopup = document.getElementById('new_passwordPopup');

    const new_lengthCriteria = document.getElementById('new_length');
    const new_capitalCriteria = document.getElementById('new_capital');
    const new_numberCriteria = document.getElementById('new_number');
    const new_specialCriteria = document.getElementById('new_special');

    // Show popup on focus
    new_passwordInput.addEventListener('focus', () => {
        new_passwordPopup.style.display = 'block';
    });

    // Hide popup on blur
    new_passwordInput.addEventListener('blur', () => {
        new_passwordPopup.style.display = 'none';
    });

    // Validate password on input
    new_passwordInput.addEventListener('input', () => {
        const new_passwordValue = new_passwordInput.value;

        // Validate length (at least 8 characters)
        if (new_passwordValue.length >= 8) {
            new_lengthCriteria.classList.add('valid');
        } else {
            new_lengthCriteria.classList.remove('valid');
        }

        // Validate capital letter
        if (/[A-Z]/.test(new_passwordValue)) {
            new_capitalCriteria.classList.add('valid');
        } else {
            new_capitalCriteria.classList.remove('valid');
        }

        // Validate number
        if (/[0-9]/.test(new_passwordValue)) {
            new_numberCriteria.classList.add('valid');
        } else {
            new_numberCriteria.classList.remove('valid');
        }

        // Validate special character
        if (/[\W_]/.test(new_passwordValue)) { // \W matches any non-word character
            new_specialCriteria.classList.add('valid');
        } else {
            new_specialCriteria.classList.remove('valid');
        }
    });
</script>
{{-- On Focus Password Requirement Script END --}}