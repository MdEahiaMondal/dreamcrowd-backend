<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="/public">
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <!-- View Point scale to 1.0 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/public-site/asset/css/bootstrap.min.css"
    />
    <link
      href="assets/public-site/asset/css/fontawesome.min.css"
      rel="stylesheet"
      type="text/css"
    />
    <script
      src="https://kit.fontawesome.com/be69b59144.js"
      crossorigin="anonymous"
    ></script>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.2.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>

    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/public-site/asset/css/style.css" />
    <link rel="stylesheet" href="assets/public-site/asset/css/navbar.css" />
    <link rel="stylesheet" href="assets/public-site/asset/css/Drop.css" />
    <link
      href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"
      rel="stylesheet"
    />
    <title>DreamCrowd | FAQ'S</title>
  </head>

  <body>
    <!-- =========================================== NAVBAR START HERE ================================================= -->
    <x-public-nav/>

    <!-- ============================================= NAVBAR END HERE ============================================ -->

    <!-- ==============START section expert faqs heading page============== -->
    <div class="container">
      <!-- heading page -->
      <div class="row">
        <div class="col-md-12">
          <div class="faqs-info">
            <h2 class="heading-top">{{$faq->question}}</h2>

            <p>{!! $faq->answer !!}</p>

          
            {{-- <p>
              I'm thrilled to offer you a range of comprehensive services that
              cater to both your learning journey and professional needs.
              Whether you're looking to expand your knowledge through
              Dreamcrow's online classes or require expert freelance assistance,
              you're in the right place.
            </p>
            <h1>Online Classes:</h1>
            <p>
              Embark on a journey of knowledge and skill enhancement with
              Dreamcrow's carefully crafted online classes. From academic
              subjects to practical skills, our courses are designed to cater
              arners of all levels. her you're a student seeking to excel in
              your studies or an individual king to acquire new talents,
              Dreamcrow's online classes provide a flexible d accessible way to
              achieve your goals. With a commitment to interactive nd engaging
              learning, you'll have the opportunity to connect with fellow
              learners and benefit from our expertise.
            </p> --}}
          </div>
        </div>
      </div>
     
      {{-- <div class="row">
        <div class="col-md-12">
          <div class="faqs-info">
            <h1>Freelance Services:</h1>
            <p>
              Unlock the power of professional excellence with Dreamcrow's
              freelance services. Backed by years of experience and expertise,
              we offer a range of freelance solutions tailored to your specific
              requirements. Whether you need assistance with writing, graphic
              design, web development, or any other specialized task,
              Dreamcrow's freelance services are designed to deliver exceptional
              results. With a keen eye for detail and a dedication to exceeding
              expectations, we take pride in collaborating with you to bring
              your projects to life.
            </p>
            <h1>Why Choose Dreamcrow:</h1>
            <p>
              <span>Expertise:</span> With a strong background in [mention your
              expertise or field], Dreamcrow brings a wealth of knowledge and
              skill to every service we offer.<br />
              <span>Flexibility:</span> Our online classes and freelance
              services are designed to fit seamlessly into your schedule,
              ensuring maximum convenience.<br />
              <span>Quality:</span> We are committed to delivering high-quality
              results, whether it's through our online courses or freelance
              projects.<br />
              <span>Personalized Approach:</span> We understand that each
              learner and project is unique. That's why we tailor our services
              to meet your individual needs and goals.<br />
              <span>Collaboration:</span> Your success is our success. We
              believe in collaborative partnerships that lead to outstanding
              outcomes.
            </p>
            <p>
              Explore the Dreamcrow website to discover the diverse range of
              online classes and freelance services we offer. Whether you're
              looking to expand your knowledge horizons or elevate your projects
              to the next level, we're here to support you every step of the
              way. Let's embark on a journey of growth and achievement together!
            </p>
          </div>
        </div>
      </div> --}}
    </div>

    <!-- ==============END section expert faqs heading page============== -->
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
