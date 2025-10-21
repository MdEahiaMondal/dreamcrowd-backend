<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <!-- View Point scale to 1.0 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Animate css -->
  <link rel="stylesheet" href="assets/user/libs/animate/css/animate.css" />
  <!-- AOS Animation css-->
  <link rel="stylesheet" href="assets/user/libs/aos/css/aos.css" /> 
  <!-- Datatable css  -->
  <link rel="stylesheet" href="assets/user/libs/datatable/css/datatable.css" />
  <!-- dropdawon -->
  <link rel="stylesheet" id="swapcss" type="text/css" href="https://unpkg.com/@leapdev/gui-leap@latest/dist/css/leap.css" />
  <!-- dropdawon -->
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
  <link rel="stylesheet" type="text/css" href="assets/user/asset/css/bootstrap.min.css" />
  <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />
  <!-- Fontawesome CDN -->
  <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
  <!-- Defualt css -->
  <link rel="stylesheet" href="assets/user/asset/css/new.css">
  <link rel="stylesheet" type="text/css" href="assets/user/asset/css/sidebar.css" />
  <link rel="stylesheet" href="assets/user/asset/css/style.css" />
  <title>User Dashboard | My Profile</title>
</head>

<body>
  {{-- ===========User Sidebar Start==================== --}}
  <x-user-sidebar/>
  {{-- ===========User Sidebar End==================== --}}
  <section class="home-section">
     {{-- ===========User NavBar Start==================== --}}
     <x-user-nav/>
     {{-- ===========User NavBar End==================== --}}
    <!-- =============================== MAIN CONTENT START HERE =========================== -->
    <div class="container-fluid">
      <div class="row Dash-notification">
        <div class="col-md-12">
          <div class="dash">
            <div class="row">
              <div class="col-md-12">
                <div class="dash-top">
                  <h1 class="dash-title">Dashboard</h1>
                  <i class="fa-solid fa-chevron-right"></i>
                  <span class="min-title">My Profile</span>
                </div>
              </div>
            </div>
            <!-- Blue MASSEGES section -->
            <div class="user-notification">
              <div class="row">
                <div class="col-md-12">
                  <div class="notify">
                    <i class="bx bx-user icon" title="My Profile"></i>
                    <h2>My Profile</h2>
                  </div>
                </div>
              </div>
            </div>

            {{-- <div class="row">
              <div class="col-xl 3 col-lg-4 col-md-12"> 
                <div class="main-profile-page">
                  <!-- Profile Image -->
                  <div class="col-md-2">
                    <div class="avatar-upload">
                      <div class="avatar-edit">
                          <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                          <label for="imageUpload"></label>
                      </div>
                      <div class="avatar-preview">
                          <div id="imagePreview" style="background-image: url(http://i.pravatar.cc/500?img=7);width: 100%;">
                          </div>
                      </div>
                  </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="name">
                    <p>Petey Cruiser</p>
                    <h5>United Kingdom</h5>
                  </div>
                  <!-- <div class="form-group"> -->
                  <input type="email" class="form-control info" id="exampleInputEmail1" aria-describedby="emailHelp"
                    placeholder="Petey" />
                  <input type="email" class="form-control" id="exampleInputPassword1" placeholder="Cruiser" />
                  
                  <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                    placeholder="United Kingdom" />
                  <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                    placeholder="Product Manager" />
                  <textarea class="form-control goals" id="exampleFormControlTextarea1" rows="3"
                    placeholder="My Goals"></textarea>

                  <button class="btn update-btn">Update</button>
                </div>
              </div>
            </div>  --}}

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="row">
    <div class="col-xl-3 col-lg-4 col-md-12">
           @if (session('success'))
        <div class="alert alert-success my-2">{{ session('success') }}</div>
        @endif
      <div class="main-profile-page">

        <!-- Profile Image -->
        <div class="col-md-2">
          <div class="avatar-upload">
            <div class="avatar-edit">
              <input type='file' id="imageUpload" name="profile" accept=".png, .jpg, .jpeg" />
              <label for="imageUpload"></label>
            </div>
            <div class="avatar-preview">
              <div id="imagePreview"
                style="background-image: url('{{ $user->profile ? asset($user->profile) : 'http://i.pravatar.cc/500?img=7' }}'); width: 100%;">
              </div>
            </div>
          </div>
        </div>

        <!-- Name Section -->
        <div class="name">
          <p>{{ $user->first_name ?? 'Petey Cruiser' }}</p>
          <h5>{{ $user->country ?? 'United Kingdom' }}</h5>
        </div>

        <!-- Form Fields -->
        <input type="text" class="form-control info" name="first_name"
          placeholder="First Name" value="{{ old('first_name', $user->first_name) }}" />
        <input type="text" class="form-control" name="last_name"
          placeholder="Last Name" value="{{ old('last_name', $user->last_name) }}" />
        <input type="text" class="form-control" name="country"
          placeholder="Country" value="{{ old('country', $user->country) }}" />
        {{-- <input type="text" class="form-control" name="designation"
          placeholder="Designation" value="{{ old('designation', $user->designation) }}" />
        <textarea class="form-control goals" name="goals" rows="3"
          placeholder="My Goals">{{ old('goals', $user->goals) }}</textarea> --}}

        <button type="submit" class="btn update-btn">Update</button>

     
      </div>
    </div>
  </div>
</form>

            {{-- <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                <div class="main-profile-page bg-white  rounded shadow">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Profile Image -->
                    <div class="avatar-upload text-center mb-3">
                        <div class="avatar-edit">
                        <input type='file' id="imageUpload" name="profile" accept=".png, .jpg, .jpeg" />
                        <label for="imageUpload"></label>
                        </div>
                        <div class="avatar-preview mx-auto" style="width: 120px; height: 120px; border-radius: 50%; overflow: hidden;">
                        <div id="imagePreview" style="background-image: url('{{ $user->profile ? asset($user->profile) : 'http://i.pravatar.cc/150?img=7' }}'); width: 100%; height: 100%; background-size: cover; background-position: center;">
                        </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <input type="text" name="first_name" value="{{ $user->first_name }}" class="form-control" placeholder="First Name" />
                    </div>

                    <div class="mb-3">
                        <input type="text" name="last_name" value="{{ $user->last_name }}" class="form-control" placeholder="Last Name" />
                    </div>

                    <div class="mb-3">
                        <input type="text" name="country" value="{{ $user->country }}" class="form-control" placeholder="Country" />
                    </div>

                    <div class="mb-3">
                        <textarea name="goals" class="form-control" placeholder="My Goals">{{ $user->goals ?? '' }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Update</button>

                    @if (session('success'))
                    <div class="alert alert-success mt-3">{{ session('success') }}</div>
                    @endif
                    </form>
                </div>
                </div>
            </div> --}}


            <div class="row">
              <div class="col-md-12 p-0">
                <div class="copyright">
                  <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- =============================== MAIN CONTENT END HERE =========================== -->
  </section>

  <script src="assets/user/libs/jquery/jquery.js"></script>
  <script src="assets/user/libs/datatable/js/datatable.js"></script>
  <script src="assets/user/libs/datatable/js/datatablebootstrap.js"></script>
  <script src="assets/user/libs/select2/js/select2.min.js"></script>
  <script src="assets/user/libs/owl-carousel/js/owl.carousel.min.js"></script>
  <script src="assets/user/libs/aos/js/aos.js"></script>
  <script src="assets/user/asset/js/bootstrap.min.js"></script>
  <script src="assets/user/asset/js/script.js"></script>
  <!-- jQuery -->
  <script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"
></script>
</body>

</html>

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
<!-- profile-upload -->

<script>
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#imagePreview').css('background-image', 'url(' + e.target.result + ')').hide().fadeIn(650);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#imageUpload").change(function() {
    readURL(this);
  });
</script>
<!-- ============ -->
<!-- =====================NEW JS END HERE====================== -->


 <!-- radio js here -->
 <script>
  function showAdditionalOptions1() {
      hideAllAdditionalOptions();
      document.getElementById('additionalOptions1').style.display = 'block';
  }

  function showAdditionalOptions2() {
      hideAllAdditionalOptions();
      document.getElementById('additionalOptions2').style.display = 'block';
  }

  function showAdditionalOptions3() {
      hideAllAdditionalOptions();
  }

  function showAdditionalOptions4() {
      hideAllAdditionalOptions();
      document.getElementById('additionalOptions4').style.display = 'block';
  }

  function hideAllAdditionalOptions() {
      var elements = document.getElementsByClassName('additional-options');
      for (var i = 0; i < elements.length; i++) {
          elements[i].style.display = 'none';
      }
  }

  // Call the function to show the additional options for the default checked radio button on page load
  window.onload = function() {
      showAdditionalOptions1();
  }; 
</script>
  <!-- modal hide show jquery here -->
<script>
  $(document).ready(function () {
    $(document).on("click", "#delete-account", function (e) {
      e.preventDefault();
      $("#exampleModal3").modal("show");
      $("#delete-user-account").modal("hide");
    });

    $(document).on("click", "#delete-account", function (e) {
      e.preventDefault();
      $("#delete-user-account").modal("show");
      $("#exampleModal3").modal("hide");
    });
  });
</script>
  <!-- JavaScript to close the modal when Cancel button is clicked -->
<script>
  // Wait for the document to load
  document.addEventListener('DOMContentLoaded', function() {
    // Get the Cancel button by its ID
    var cancelButton = document.getElementById('cancelButton');

    // Add a click event listener to the Cancel button
    cancelButton.addEventListener('click', function() {
      // Find the modal by its ID
      var modal = document.getElementById('exampleModal2');
      
      // Use Bootstrap's modal method to hide the modal
      $(modal).modal('hide');
    });
  });
</script>
<script>
  ( function( $ ) {
  
	$( '.dropdown-toggle' ).click( function( e ) {
		var _this = $( this );
		e.preventDefault();
		_this.toggleClass( 'toggle-on' );
		_this.parent().next( '.sub-menu' ).toggleClass( 'toggled-on' );
		_this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
	} );

})( jQuery );
 