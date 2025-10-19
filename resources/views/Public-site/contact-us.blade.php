<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <!-- View Point scale to 1.0 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Management</title>
    

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
     <!-- jQuery -->
     <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    
    
     {{-- =======Toastr CDN ======== --}}
   <link rel="stylesheet" type="text/css" 
   href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
   
   <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
   {{-- =======Toastr CDN ======== --}}
<!-- Defualt css -->
<link rel="stylesheet" type="text/css" href="assets/public-site/asset/css/style.css" />
<link rel="stylesheet" href="assets/public-site/asset/css/navbar.css">
<link rel="stylesheet" href="assets/public-site/asset/css/Drop.css">
<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.2.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>

<title>DreamCrowd | Payment</title>
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


  <!-- =========================================== NAVBAR START HERE ================================================= -->
  <x-public-nav/>

<!-- ============================================= NAVBAR END HERE ============================================ -->
  <!--Responsive Image with Text Start-->
  <!-- <section id="hero">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
          <div class="content_box">
  <h1>Feel free to reach us</h1>
</div>
          </div>
        </div>
      </div>
    </div>
  </section> -->
  <!--Responsive Image with Text End-->

  <!--Responsive Contact Form Start-->
  <section id="client">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
              <h1>Contact Us</h1>
              <div class="underline">
                <div class="line"></div>
              </div>
              <p>Please view our FAQ pages for most enquiries or reach us directly by filling up the contact form below.</p>
              <form action="/contact-mail" method="POST">
                @csrf
              <div class="content_box">
        <div class="content">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <input
                  type="text" name="first_name"   
                  class="form-control"
                  id="exampleFormControlInput1"
                  placeholder="First Name" required
                />
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <input
                  type="text" name="last_name"   
                  class="form-control"
                  id="exampleFormControlInput1"
                  placeholder="Last Name" required
                />
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <input
                  type="email" name="email" 
                  class="form-control"
                  id="exampleFormControlInput1"
                  placeholder="example@gmail.com" required
                />
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <input
                  type="text" name="subject"
                  class="form-control"
                  id="exampleFormControlInput1"
                  placeholder="Your Subject" required
                />
              </div>
            </div>

            <div class="col-md-12">
              <div class="mb-3">
                <textarea
                  class="form-control text-area-sec"
                  id="exampleFormControlTextarea1"
                  rows="3" name="msg"
                  placeholder="Type your message........"
                ></textarea>
              </div>
              <button type="submit" class="btn">SEND</button>
            </div>

    </div>
    </div>
                   </div>  
                  </form> 
        </div>
        </div>
        </section>
    <!--Responsive Contact Form End-->
        
  <script src="script.js"></script>        
   <script src="libs/jquery/jquery.js"></script>
  <script src="libs/datatable/js/datatable.js"></script>
  <script src="libs/datatable/js/datatablebootstrap.js"></script>
  <script src="libs/select2/js/select2.min.js"></script>
  <!-- <script src="libs/owl-carousel/js/jquery.min.js"></script> -->
  <script src="libs/owl-carousel/js/owl.carousel.min.js"></script>
  <!-- ============================= FOOTER SECTION START HERE ===================================== -->
  <x-public-footer/>
<!-- =============================== FOOTER SECTION END HERE ===================================== -->
<script src="assets/public-site/libs/jquery/jquery.js"></script>
<script src="assets/public-site/libs/datatable/js/datatable.js"></script>
<script src="assets/public-site/libs/datatable/js/datatablebootstrap.js"></script>
<script src="assets/public-site/libs/select2/js/select2.min.js"></script>
<script src="assets/public-site/libs/owl-carousel/js/owl.carousel.min.js"></script>
<script src="assets/public-site/libs/aos/js/aos.js"></script>
<script src="assets/public-site/asset/js/bootstrap.min.js"></script>
<script src="assets/public-site/asset/js/script.js"></script>
  <script>
    $(document).ready(function(){
        $('.owl-carousel').owlCarousel({
            items : 4,
            margin : 30
        });
})
</script>

<script>

    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
    
    </script>
    <script>
        new DataTable('#example', {
    scrollX: true
});
    </script>
      
      <script src="libs/aos/js/aos.js"></script>
      <script>
          AOS.init();
          </script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>