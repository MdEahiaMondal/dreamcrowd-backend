<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <!-- View Point scale to 1.0 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
    <link rel="stylesheet" type="text/css" href="assets/user/asset/css/bootstrap.min.css" />
     <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
     <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
         <!-- jQuery -->
         <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    

         {{-- =======Toastr CDN ======== --}}
         <link rel="stylesheet" type="text/css" 
         href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
         
         <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
         {{-- =======Toastr CDN ======== --}}
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/user/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/user/asset/css/style.css">
    <link rel="stylesheet" href="assets/user/asset/css/purchase-table.css">
    <title>User Dashboard | Wishlist</title>
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
  @if (Session::has('info'))
  <script>

        toastr.options =
          {
              "closeButton" : true,
               "progressBar": true,
          "timeOut": "10000", // 10 seconds
          "extendedTimeOut": "4410000" // 10 seconds
          }
                  toastr.info("{{ session('info') }}");

                  
  </script>
  @endif

  {{-- ===========User Sidebar Start==================== --}}
  <x-user-sidebar/>
  {{-- ===========User Sidebar End==================== --}}
  <section class="home-section">
     {{-- ===========User NavBar Start==================== --}}
     <x-user-nav/>
     {{-- ===========User NavBar End==================== --}}
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
                        <span class="min-title">Wishlist</span>
                        </div>
                    </div>
                </div>
                <!-- Blue MASSEGES section -->
        <div class="user-notification">
            <div class="row">
                <div class="col-md-12">
                    <div class="notify">
                        <i class='bx bx-list-ul icon'title="Wishlist" ></i>
                        <h2>Wishlist</h2>
                    </div>
                </div>
            </div>
        </div>
    <div class="row">
        <div class="col-md-12">  
       <!-- CARD SECTION START HERE -->
       <div class="row">

        @if (count($list) > 0)

              
        @foreach ($list as $item)

        @php
        $gig = \App\Models\TeacherGig::where(['id'=>$item->gig_id, 'status'=>1])->first();
        $user = \App\Models\ExpertProfile::where(['user_id'=>$gig->user_id, 'status'=>1])->first();
        $firstLetter = strtoupper(substr($user->first_name, 0, 1));
        $lastLetter = strtoupper(substr($user->last_name, 0, 1));
    @endphp

    @if ($item->type == 'Gig')

    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
        <div class="main-Dream-card">
            <div class="card dream-Card">
                <div class="dream-card-upper-section">
                  <div style="height: 180px;">
                          
                    @if (Str::endsWith($gig->main_file, ['.mp4', '.avi', '.mov', '.webm'])) 
                    <!-- Video Player -->
                    <video autoplay loop muted  style="height: 100%; width: 100%;">
                        <source src="assets/teacher/listing/data_{{ $gig->user_id }}/media/{{$gig->main_file}}" type="video/mp4" >
                        Your browser does not support the video tag.
                    </video>
                @elseif (Str::endsWith($gig->main_file, ['.jpg', '.jpeg', '.png', '.gif']))
                    <!-- Image Display -->
                    <img src="assets/teacher/listing/data_{{ $gig->user_id }}/media/{{$gig->main_file}}" style="height: 100%;" alt="Uploaded Image">
                @endif
                     
                    </div>
                    <div class="card-img-overlay overlay-inner">
                        <p>
                            Top Seller
                        </p>
                     
                        <a href="/remove-wish-list/{{$item->id}}" id="heart_{{$item->id}}" class="liked" onclick="AddWishList(this.id);" data-gig_id="{{$item->id}}" >
                            <i class="fa fa-heart" aria-hidden="true"></i>
                        </a>
                   
                        
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
                        <p class="servise-bener">{{$gig->service_type}} Services</p>
                        <h5 class="dream-Card-name">
                            {{$user->first_name}} {{$lastLetter}}.
                        </h5>
                        <p class="Dev">{{$user->profession}}</p>
                        @if ($gig->service_role == 'Class')
                        @if ($gig->class_type == 'Recorded')
                        <p class="about-teaching" ><a class="about-teaching" href="/course-service/{{$gig->id}}" style="text-decoration: none;">{{$gig->title}}</a> </p>
                        @else
                        <p class="about-teaching" ><a class="about-teaching" href="/quick-booking/{{$gig->id}}" style="text-decoration: none;">{{$gig->title}}</a> </p>
                        @endif
                        @else
                        <p class="about-teaching" ><a class="about-teaching" href="/quick-booking/{{$gig->id}}" style="text-decoration: none;">{{$gig->title}}</a> </p>
                        @endif
                        
                        {{-- <p class="about-teaching" >{{$item->title}}</p> --}}
                        <span class="card-rat">
                            <i class="fa-solid fa-star"></i> &nbsp; (5.0)
                        </span>
                        <div class="card-last">
                            <span>Starting at @currency($gig->rate)</span>
                            <!-- word img -->
                            @if ($gig->service_type == 'Online')
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
        
    @else

    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
        <div class="main-Dream-card">
            <div class="card dream-Card">
                <div class="dream-card-upper-section">
                  <div style="height: 180px;">
                          
                      <img src="assets/expert/asset/img/{{$user->main_image}}" alt="" style="height: 100%;">
                     
                    </div>
                    <div class="card-img-overlay overlay-inner">
                        <p>
                            Top Seller
                        </p>
                     
                       <a href="/remove-wish-list/{{$item->id}}" id="heart_{{$item->id}}" class="liked" onclick="AddWishList(this.id);" data-gig_id="{{$item->id}}" >
                        <i class="fa fa-heart" aria-hidden="true"></i>
                    </a>
                   
                        
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
                        <p class="servise-bener">{{$user->service_type}} Services</p>
                        <h5 class="dream-Card-name">
                            {{$user->first_name}} {{$lastLetter}}.
                        </h5>
                        <p class="Dev">{{$user->profession}}</p>
                        <p class="about-teaching" ><a class="about-teaching" href="{{ url('professional-profile/'.$user->id.'/'.$user->first_name.$user->last_name) }}" style="text-decoration: none;">I Love This Profile</a> </p>
                        
                        
                        {{-- <p class="about-teaching" >{{$item->title}}</p> --}}
                        <span class="card-rat">
                            <i class="fa-solid fa-star"></i> &nbsp; (5.0)
                        </span>
                        <div class="card-last">
                            <span></span>
                            {{-- <span>Starting at $20</span> --}}
                            <!-- word img -->
                            {{-- @if ($user->service_type == 'Online')
                            <img data-toggle="tooltip" title="In Person-Service" src="assets/seller-listing/asset/img/globe.png" style="height: 25px; width: 25px;" alt="">
                            
                            @else
                            <img data-toggle="tooltip" title="In Person-Service" src="assets/seller-listing/asset/img/handshake.png" style="height: 25px; width: 25px;" alt="">
                                
                            @endif --}}
                            <!-- <i class="fa-solid fa-globe"></i> -->
                        </div>
                    </div>
                </a>
            </div>
        </div>
         </a>
    </div>
        
    @endif

       
            
        @endforeach 
            
        @endif





        {{-- <div class="col-xl-3 col-lg-4 col-md-6 col-12">
            <div class="main-Dream-card">
                <div class="card dream-Card">
                    <div class="dream-card-upper-section">
                        <img src="assets/user/asset/img/card-main-img.png" alt="">
                        <div class="card-img-overlay overlay-inner">
                            <p>
                                Top Seller
                            </p>
                            <span id=heart>
                                <i class="fa fa-heart-o" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                    <a href="#" style="text-decoration: none;">
                        <div class="dream-card-dawon-section" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            <div class="dream-Card-inner-profile">
                                <img src="assets/user/asset/img/inner-profile.png" alt="">
                                <i class="fa-solid fa-check tick"></i>
                            </div>
                            <p class="servise-bener">Online Services</p>
                            <h5 class="dream-Card-name">
                                Usama A.
                            </h5>
                            <p class="Dev">Developer</p>
                            <p class="about-teaching">I will teach you how to build an amazing website</p>
                            <span class="card-rat">
                                <i class="fa-solid fa-star"></i> &nbsp; (5.0)
                            </span>
                            <div class="card-last">
                                <span>Starting at $5</span>
                                <!-- word img -->
                                <img data-toggle="tooltip" title="In Person-Service" src="assets/user/asset/img/globe.png" style="height: 25px; width: 25px;" alt="">
                                <!-- <i class="fa-solid fa-globe"></i> -->
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            </a>
        </div> --}}


 
    </div>
    </div>
    </div>
        </div>
        </div>
          <!-- pagination start from here -->
     <div class="demo">
        <nav class="pagination-outer" aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item">
                    <a href="#" class="page-link" aria-label="Previous">
                        <span aria-hidden="true">«</span>
                    </a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-item"><a class="page-link" href="#">5</a></li>
                <li class="page-item">
                    <a href="#" class="page-link" aria-label="Next">
                        <span aria-hidden="true">»</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
      <!-- pagination ended here -->
                            <!-- copyright section start from here -->
                            <div class="copyright">
                                <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
                              </div>
                              <!-- copyright section ended here -->
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
  <!-- ================ side js start End=============== -->
 <script>
    // 1
    $(document).ready(function() {
        $("#heart").click(function() {
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
    $(document).ready(function() {
        $("#heart1").click(function() {
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
    $(document).ready(function() {
        $("#heart2").click(function() {
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
    $(document).ready(function() {
        $("#heart3").click(function() {
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
    $(document).ready(function() {
        $("#heart4").click(function() {
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
    $(document).ready(function() {
        $("#heart5").click(function() {
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
    $(document).ready(function() {
        $("#heart6").click(function() {
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
    $(document).ready(function() {
        $("#heart7").click(function() {
            if ($("#heart7").hasClass("liked")) {
                $("#heart7").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
                $("#heart7").removeClass("liked");
            } else {
                $("#heart7").html('<i class="fa fa-heart" aria-hidden="true"></i>');
                $("#heart7").addClass("liked");
            }
        });
    });
          </script>
         
<!-- Modal Start Here -->
<div
  class="modal fade delete-modal"
  id="exampleModal3"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <h1>Are you really sure you want to delete this account?</h1>
        <div class="btn-sec">
          <center>
            <button type="button" class="btn btn-no" data-bs-dismiss="modal" id="cancelButton">
              Cancel
            </button>
            <button
              type="button"
              class="btn btn-yes"
              data-bs-toggle="modal"
              data-bs-target="#delete-user-account"
              id="delete-account"
            >
              Yes
            </button>
          </center>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- delete user account modal here -->
<div
  class="modal fade delete-modal confirm-delete"
  id="delete-user-account"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog delete-dialog">
    <div class="modal-content delete-content">
      <div class="modal-body p-0">
        <h1 class="leave-reason">We are sorry that you’re leaving!</h1>
        <p class="sub-heading">Please tell us why you’re choosing to leave</p>
        <form>
          <div>
              <input type="radio" id="option1" name="mainOptions" value="option1" onclick="showAdditionalOptions1()" checked>
              <label for="option1">I find it hard to use Dreamcrowd</label>
          </div>
          <div>
              <input type="radio" id="option2" name="mainOptions" value="option2" onclick="showAdditionalOptions2()">
              <label for="option2">I am not happy with a service provided by a seller</label>
          </div>
          <div>
              <input type="radio" id="option3" name="mainOptions" value="option3" onclick="showAdditionalOptions3()">
              <label for="option3">I completed my goals and don’t need Dreamcrowd any longer</label>
          </div>
          <div>
              <input type="radio" id="option4" name="mainOptions" value="option4" onclick="showAdditionalOptions4()">
              <label for="option4">Other reasons</label>
          </div>
          
          <div class="additional-options" id="additionalOptions1">
              <label for="additionalOption1" class="delete-label">Please tell us why you find it hard to use Dreamcrowd</label>
              <textarea class="form-control" cols="3" rows="3" id="additionalOption1" name="additionalOption1" placeholder="Type your reason..."></textarea>
          </div>
      
          <div class="additional-options" id="additionalOptions2">
              <label for="additionalOption2" class="delete-label">Please tell us the sellers name and what they did wrong</label>
              <textarea class="form-control" cols="3" rows="3" id="additionalOption2" name="additionalOption2" placeholder="Type your reason..."></textarea>
          </div>
      
          <div class="additional-options" id="additionalOptions4">
              <label for="additionalOption4" class="delete-label">Please tell us the reason as to why you’re leaving</label>
              <textarea class="form-control" cols="3" rows="3" id="additionalOption4" name="additionalOption4" placeholder="Type your reason..."></textarea>
          </div>
      </form>
    <div class="float-end btn-sec">
      <button type="button" class="btn btn-no" data-bs-dismiss="modal">
        Cancel
      </button>
      <button type="button" class="btn btn-yes">Delete Account</button>
  </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal End Here -->
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
      var modal = document.getElementById('exampleModal3');
      
      // Use Bootstrap's modal method to hide the modal
      $(modal).modal('hide');
    });
  });
</script>