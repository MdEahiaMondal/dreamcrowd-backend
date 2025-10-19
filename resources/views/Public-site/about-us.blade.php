<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <!-- View Point scale to 1.0 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Animate css -->
    <link rel="stylesheet" href="assets/public-site/libs/animate/css/animate.css" />
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="assets/public-site/libs/aos/css/aos.css" />
    <!-- Datatable css  -->
    <link rel="stylesheet" href="assets/public-site/libs/datatable/css/datatable.css" />
     {{-- Fav Icon --}}
     @php  $home = \App\Models\HomeDynamic::first(); @endphp
     @if ($home)
         <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
     @endif
     <!-- Select2 css -->
    <link href="assets/public-site/libs/select2/css/select2.min.css" rel="stylesheet" />
    <!-- Owl carousel css -->
    <link href="assets/public-site/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
    <link href="assets/public-site/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="assets/public-site/asset/css/bootstrap.min.css" />
    <link href="assets/public-site/asset/css/fontawesome.min.css" rel="stylesheet" type="text/css" />
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.2.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/public-site/asset/css/style.css" />
    <link rel="stylesheet" href="assets/public-site/asset/css/navbar.css">
    <link rel="stylesheet" href="assets/public-site/asset/css/Drop.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <title>DreamCrowd | About Us</title>
</head>
@if($about)
<style>
    .about-us{
        background: linear-gradient(to right, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
        url("assets/public-site/asset/img/{{$about->cover_image_1}}");
    }

</style>
@endif
<body> 

    <!-- =========================================== NAVBAR START HERE ================================================= -->
    <x-public-nav/>

    <!-- ============================================= NAVBAR END HERE ============================================ -->
    @if ($about)
    @if ($about->section_1 == 1)

    <div class="container-fluid about-us" style="margin: 0;">
        <div class="container">
            <h1>@if ($about) {{$about->image_heading}}  @endif</h1>

        </div>
    </div>
        
    @endif
    @endif
 
    <div class="container">
        <div class="About-dreamcrowd">
            <h1>About dreamcrowd</h1>
            <p class="About-dreamcrowd-paragraph">
                @if ($about) {{$about->about}}  @endif
            </p>
            @if($about)
            @if ($about->section_2 == 1)
            <img src="assets/public-site/asset/img/{{$about->cover_image_2}}  " alt="....">
            @endif
            @endif
            <p class="how-it-work">@if ($about) {{$about->tag_line}}  @endif</p>

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <span class="text-01">01</span>
                    <span class="text-search">@if ($about) {{$about->heading_1}}  @endif</span>
                    <p class="search-paragraph">@if ($about) {{$about->details_1}}  @endif</p>
                </div>


                <div class="col-lg-4 col-md-6">
                    <span class="text-02">02</span>
                    <span class="text-Flexible">@if ($about) {{$about->heading_2}}  @endif</span>
                    <p class="search-paragraph">@if ($about) {{$about->details_2}}  @endif</p>
                </div>
                <div class="col-lg-4 col-md-6">
                    <span class="text-03">03</span>
                    <span class="text-Enjoy">@if ($about) {{$about->heading_3}}  @endif</span>
                    <p class="search-paragraph">@if ($about) {{$about->details_3}}  @endif</p>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- ============================= FOOTER SECTION START HERE ===================================== -->
    <x-public-footer/>
    <!-- =============================== FOOTER SECTION END HERE ===================================== -->
    <script src="assets/public-site/libs/jquery/jquery.js"></script>
    <script src="assets/public-site/libs/datatable/js/datatable.js"></script>
    <script src="assets/public-site/libs/datatable/js/datatablebootstrap.js"></script>
    <script src="assets/public-site/libs/select2/js/select2.min.js"></script>
    <script src="assets/public-site/libs/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="assets/public-site/asset/js/bootstrap.min.js"></script>
    <script src="assets/public-site/asset/js/script.js"></script>
</body>

</html>
<!-- BECOME AN EXPERT POPUP START HERE  -->
<div class="modal fade select-expert-popup" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h1>Chose Service You Provide</h1>
                <div class="radio-inputs">
                    <label>
          <input class="radio-input" type="radio" name="engine">
            <span class="radio-tile">
              <span class="radio-icon">
                <img src="assets/public-site/asset/img/freelance.svg" alt="....">
              </span>
              <span class="radio-label">Freelance Servicer</span>
            </span>
        </label>
                    <label>
          <input checked="" class="radio-input" type="radio" name="engine">
          <span class="radio-tile">
            <span class="radio-icon">
              <img src="assets/public-site/asset/img/online.svg" alt="..">                
            </span>
            <span class="radio-label">Online class</span>
          </span>
        </label>
                    <label>
          <input class="radio-input" type="radio" name="engine">
          <span class="radio-tile">
            <span class="radio-icon">
             <img src="assets/public-site/asset/img/both.svg" alt="....">
            </span>
            <span class="radio-label">Both</span>
          </span>
        </label>
                </div>
                <center>
                    <a href="../Become-expert/index.html">
                        <button type="button" class="btn btn-started">Get Started</button>
                    </a>
                    <!-- <button type="button" class="btn btn-started" onclick="window.location=''">Get Started</button> -->
                </center>
            </div>
        </div>
    </div>
</div>
<!-- BECOME AN EXPERT POPUP END HERE  -->