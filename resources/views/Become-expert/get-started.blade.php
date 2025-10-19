<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <!-- View Point scale to 1.0 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Animate css -->
    <link rel="stylesheet" href="assets/expert/libs/animate/css/animate.css" />
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="assets/expert/libs/aos/css/aos.css" />
    <!-- Datatable css  -->
    <link rel="stylesheet" href="assets/expert/libs/datatable/css/datatable.css" />
     {{-- Fav Icon --}}
     @php  $home = \App\Models\HomeDynamic::first(); @endphp
     @if ($home)
         <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
     @endif
     <!-- Select2 css --> 
    <link href="assets/expert/libs/select2/css/select2.min.css" rel="stylesheet" />
    <!-- Owl carousel css -->
    <link href="assets/expert/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
    <link href="assets/expert/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
    <!-- Bootstrap css -->
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/expert/asset/css/bootstrap.min.css"
    />
    <link
      href="assets/expert/asset/css/fontawesome.min.css"
      rel="stylesheet"
      type="text/css"
    />
    <link
      href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"
      rel="stylesheet"
    />
    <script
      src="https://kit.fontawesome.com/be69b59144.js"
      crossorigin="anonymous"
    ></script>
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/expert/asset/css/style.css" />
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.2.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>
    <link rel="stylesheet" href="assets/public-site/asset/css/Drop.css" />
    <link rel="stylesheet" href="assets/public-site/asset/css/navbar.css">
    <title>Become An Expert | Get Started</title>
  </head>
  <body>
       <!-- =========================================== NAVBAR START HERE ================================================= -->
       <x-public-nav/>
    <!-- ============================================= NAVBAR END HERE ============================================ -->
    <!--Responsive CARD-->
    <section id="hero_expert_section">
      <div class="container">
        <div class="row">
          <div id="hero">
            <div class="row">
              <div class="col-lg-8 col-md-12">
                <div class="content">
                  <div class="content-text">
                    @if ($expert)
                    <h1>
                      {{$expert->expert_heading}}
                    </h1>
                    @endif
                    
                    <div class="dashes"></div>
                    <ul>
                      @if ($points)

                      @foreach ($points as $item)
                      <li>
                        <p>{{$item->point}}</p>
                      </li>
                      @endforeach
                          
                      @endif
                      
                      {{-- <li>
                        <p>
                          Describe your skills or talent accurately, to give you
                          a high chance of being booked.
                        </p>
                      </li>
                      <li>
                        <p>
                          Add nice cover photos that describes your talent and
                          your previous experience.
                        </p>
                      </li>
                      <li>
                        <p>
                          Add an intro video (optional) to boost your chances of
                          being booked. Video should be of great quality
                        </p>
                      </li>
                      <li>
                        <p>
                          Take a reasonable amount of time in creating your
                          profile. Rushing things will likely lead to errors.
                        </p>
                      </li> --}}
                    </ul>
                    @if (Auth::user())
                    <a href="/expert-profile">
                      <button class="btn">Continue</button>
                    </a>
                          
                      @else

                      <button type="button" class="btn login-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">Continue</button>
                          
                      @endif
                  </div>
                </div>
              </div>
              @if ($expert)
              <div class="col-lg-4 col-md-12">
                <img src="assets/expert/asset/img/{{$expert->expert_image}}" alt="" />
              </div>
              @endif
              
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ============================= FOOTER SECTION START HERE ===================================== -->
    <div class="container-fluid footer-section" style="margin-top: 96px">
      <div class="container">
        <div class="row">
          <div class="col-md-5">
            <img src="assets/expert/asset/img/Logo.png" alt="" />
            <p>
              Transforming your furry friend's unique personality into a work
              <br />of art that you'll treasure forever. Specializing in
              high-quality, <br />hand-drawn pet portraits.
            </p>
            <div class="social-icons">
              <a href=""><i class="fa-brands fa-facebook-f"></i></a>
              <a href=""><i class="fa-brands fa-instagram"></i></a>
              <a href=""><i class="fa-brands fa-pinterest"></i></a>
              <a href=""><i class="fa-brands fa-twitter"></i></a>
              <a href=""><i class="fa-brands fa-tiktok"></i></a>
              <a href=""><i class="fa-brands fa-youtube"></i></a>
            </div>
            <h3>Subscribe to our newsletter</h3>
            <div class="input-group mb-3 inp">
              <input
                type="text"
                class="form-control fc"
                placeholder="Enter Your Email...."
                aria-label="Recipient's username"
                aria-describedby="button-addon2"
              />
              <button
                class="btn btn-outline-secondary"
                type="button"
                id="button-addon2"
              >
                Subscribe
              </button>
            </div>
          </div>
          <div class="col-md-7">
            <div class="row">
              <div class="col-md-4 footer-links-section">
                <h6 class="text-center">Company</h6>
                <ul class="footer-links">
                  <li><a href="#">Home</a></li>
                  <li><a href="#">About us</a></li>
                  <li><a href="#">Contact us</a></li>
                  <li><a href="#">How it works</a></li>
                  <li><a href="#">Privacy Policy</a></li>
                  <li><a href="#">Terms & Conditions</a></li>
                </ul>
              </div>
              <div class="col-md-4 footer-links-section">
                <h6 class="text-center">Seller/Expert</h6>
                <ul class="footer-links">
                  <li><a href="#">Become a Seller</a></li>
                  <li><a href="#">Login</a></li>
                  <li><a href="#">FAQ’s</a></li>
                </ul>
              </div>
              <div class="col-md-4 footer-links-section">
                <h6 class="text-center">Buyer/Client</h6>
                <ul class="footer-links">
                  <li><a href="#">Register</a></li>
                  <li><a href="#">Login</a></li>
                  <li><a href="#">FAQ’s</a></li>
                </ul>
              </div>
            </div>
          </div>
          <hr class="bordr" />
          <!-- ==================== FOOTER COPYRIGHT SECTION START FROM HERE =================== -->
          <div class="row footer-bottom">
            <div class="col-lg-10 col-md-9 col-12">
              <p>&copy; 2023 DREAMCROWD. All Rights Reserved.</p>
            </div>
            <div class="col-lg-2 col-md-3 col-12 footer-selector">
              <select class="select2-icon" name="icon">
                <option value="fa-globe" data-icon="fa-globe">
                  Select Currency
                </option>
                <option value="fa-dollar-sign" data-icon="fa-dollar-sign">
                  USD
                </option>
                <option value="fa-euro-sign" data-icon="fa-euro-sign">
                  EUR
                </option>
                <option value="fa-sterling-sign" data-icon="fa-sterling-sign">
                  GBP
                </option>
                <option value="fa-shekel-sign" data-icon="fa-shekel-sign">
                  ILS
                </option>
              </select>
            </div>
          </div>
          <!-- ==================== FOOTER COPYRIGHT SECTION ENDED HERE =================== -->
        </div>
      </div>
    </div>
    <!-- =============================== FOOTER SECTION END HERE ===================================== -->
    <script src="assets/expert/libs/jquery/jquery.js"></script>
    <script src="assets/expert/libs/datatable/js/datatable.js"></script>
    <script src="assets/expert/libs/datatable/js/datatablebootstrap.js"></script>
    <script src="assets/expert/libs/select2/js/select2.min.js"></script>
    <script src="assets/expert/libs/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="assets/expert/libs/aos/js/aos.js"></script>
    <script src="assets/expert/asset/js/bootstrap.min.js"></script>
    <script src="assets/expert/asset/js/script.js"></script>
  </body>
</html>
