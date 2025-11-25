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
  @php $home = \App\Models\HomeDynamic::first(); @endphp
  @if ($home)
    <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
  @endif
  <!-- Select2 css -->
  <link href="assets/expert/libs/select2/css/select2.min.css" rel="stylesheet" />
  <!-- Owl carousel css -->
  <link href="assets/expert/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
  <link href="assets/expert/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.2.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>
  <!-- Bootstrap css -->
  <link rel="stylesheet" type="text/css" href="assets/expert/asset/css/bootstrap.min.css" />
  <link href="assets/expert/asset/css/fontawesome.min.css" rel="stylesheet" type="text/css" />
  <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
  <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
  <!-- Defualt css -->
  <link rel="stylesheet" type="text/css" href="assets/expert/asset/css/style.css" />
  <link rel="stylesheet" href="assets/public-site/asset/css/navbar.css">
  <link rel="stylesheet" href="assets/public-site/asset/css/Drop.css" />

  <title>Become An Expert | Home</title>

  @if ($expert)

    <style>
      .Become-an-expert-img {
        background-image: linear-gradient(rgba(0, 0, 0, 0.52), rgba(0, 0, 0, 0.52)),
          url(assets/expert/asset/img/{{$expert->hero_image}});
      }
    </style>
  @endif

</head>

<body>
  <!-- =========================================== NAVBAR START HERE ================================================= -->
  <!-- ========================= NAVBAR SECTION START HERE ========================================= -->
  <x-public-nav />
  <!-- ========================= NAVBAR SECTION END HERE ========================================= -->
  <!-- ============================================= NAVBAR END HERE ============================================ -->
  <!-- ========================================= HER0 SECTION START HERE ========================================= -->
  <div class="container-fluid Become-an-expert-img">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="bot">
            <h1>@if ($expert) {{$expert->hero_heading}} @endif</h1>

            <div class="paragraph">
              <p>
                @if ($expert) {{$expert->hero_description}} @endif
              </p>
            </div>
          </div>
          <div class="buttons">
            <a href="/get-started" target="__" style="text-decoration: none;">

              <button>@if ($expert) {{$expert->hero_btn_link}} @endif</button>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- =========================================== HOW IT WORKS START HERE ================================== -->
  <div class="container-fluid how-it-work-sec">
    <div class="container">
      @if ($expert)

        <div class="row">
          <h2>How It Works</h2>
          <div class="col-lg-4 col-md-6">
            <div class="work-card">
              <img src="assets/expert/asset/img/{{$expert->work_image_1}}" />
              <h1>{{$expert->work_heading_1}}</h1>
              <p>
                {{$expert->work_detail_1}}
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="work-card1">
              <img src="assets/expert/asset/img/{{$expert->work_image_2}}" />
              <h1>{{$expert->work_heading_2}}</h1>
              <p>
                {{$expert->work_detail_2}}
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="work-card2">
              <img src="assets/expert/asset/img/{{$expert->work_image_3}}" />
              <h1>{{$expert->work_heading_3}}</h1>
              <p>
                {{$expert->work_detail_3}}
              </p>
            </div>
          </div>
        </div>
      @endif

    </div>
  </div>
  <!-- ========BECOME AN EXPERT PAGE SECTION START HERE=========== -->
  <!-- ANYONE BECOME HOST SECTION START HERE  -->
  <div class="container">
    @if ($expert)

      <div class="row">
        <div class="col-md-12 become-an-expert">
          <h1 class="title">{{$expert->host_heading}}</h1>
          <div class="img-folder">
            <div class="row">
              <div class="col-md-3 mb-2">
                <img src="assets/expert/asset/img/{{$expert->host_image_1}}" alt="" width="100%" />
              </div>
              <div class="col-md-3 mb-2">
                <img src="assets/expert/asset/img/{{$expert->host_image_2}}" alt="" width="100%" />
              </div>
              <div class="col-md-3 mb-2">
                <img src="assets/expert/asset/img/{{$expert->host_image_3}}" alt="" width="100%" />
              </div>
              <div class="col-md-3 mb-2">
                <img src="assets/expert/asset/img/{{$expert->host_image_4}}" alt="" width="100%" />
              </div>
            </div>
          </div>
          <div class="paragraph-bottom">
            <div class="row">
              <div class="col-md-12">
                <p class="para">
                  {{$expert->host_description}}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif

  </div>
  <!-- ANYONE BECOME HOST SECTION END HERE  -->

  <!-- HOST FEAUTURE SECTION START HERE== -->
  <div class="container-fluid FEAUTURE">
    <div class="row">
      <div class="col-md-12">
        <h1 class="heading text-center">@if ($expert){{$expert->feature_heading}}@endif</h1>
        <div class="feauture-item">
          <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">

              <div class="row">

                @if ($feature)
                  @foreach ($feature as $item)
                    <div class="col-md-6">
                      <div class="item">
                        <i class="fa-solid fa-plus"></i>
                        <p>{{$item->feature}}</p>
                      </div>
                    </div>
                  @endforeach
                @endif
              </div>
            </div>
            <div class="col-md-3"></div>


            {{-- <div class="item item1">
              <ul>
                <li>
                  <i class="fa-solid fa-plus"></i>
                  <p>Customisable user project</p>
                </li>
                <li>
                  <i class="fa-solid fa-plus"></i>
                  <p>Smart client management</p>
                </li>
                <li>
                  <i class="fa-solid fa-plus"></i>
                  <p>Smart booking management</p>
                </li>
                <li>
                  <i class="fa-solid fa-plus"></i>
                  <p>One-off pricing creations</p>
                </li>
                <li>
                  <i class="fa-solid fa-plus"></i>
                  <p>subscription pricing creations</p>
                </li>
              </ul>
            </div> --}}
            {{-- <div class="col-md-6 justify-content-start">
              <div class="item">
                <ul>
                  <li>
                    <i class="fa-solid fa-plus"></i>
                    <p>Virtual activity setup</p>
                  </li>
                  <li>
                    <i class="fa-solid fa-plus"></i>
                    <p>one-to-one class setup</p>
                  </li>
                  <li>
                    <i class="fa-solid fa-plus"></i>
                    <p>Group classes setup</p>
                  </li>
                  <li>
                    <i class="fa-solid fa-plus"></i>
                    <p>Live Zoom hosting</p>
                  </li>
                  <li>
                    <i class="fa-solid fa-plus"></i>
                    <p>24/7 customer support</p>
                  </li>
                </ul>
              </div>
            </div> --}}
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- HOST FEAUTURE SECTION END HERE== -->
  <!-- BECOME AN EXPERT FAQS SECTION START -->
  @if ($faqs)
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="becom-faqs-section">
            <h1 class="faqs-title-top text-center">
              Frequently Asked Questions
            </h1>
            <div class="become-faqs">
              <div class="row">
                <!-- one -->
                @foreach ($faqs as $item)
                  @if ($item->status == 1)
                    <div class="col-md-6">
                      <div class="bacome-experties">
                        <div class="accordion becom-faq" id="accordionExample">
                          <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{$item->id}}">
                              <button class="accordion-button collapsed terms" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{$item->id}}" aria-expanded="false"
                                aria-controls="collapse{{$item->id}}">{{$item->question}}</button>
                            </h2>
                            <div id="collapse{{$item->id}}" class="accordion-collapse collapse"
                              aria-labelledby="heading{{$item->id}}" data-bs-parent="#accordionExample">
                              <div class="accordion-body">{{$item->answer}}</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endif
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif
  <!-- BECOME AN EXPERT FAQS SECTION END -->
  <!-- =FOOTER-TOP RELATED SECTION BECOM ANB EXPERT START= -->
  <div class="container-fluid earning-section">
    <div class="row">
      <div class="col-md-12 text-center">
        @if ($expert)

          <div class="earning-section-heading">
            <h1 class="heading-end">
              {{$expert->banner_heading}}
            </h1>
            <a href="/get-started">
              <button class="get-start-btn">{{$expert->banner_btn_link}}</button>
            </a>
          </div>
        @endif
      </div>
    </div>
  </div>

  <!-- =FOOTER-TOP RELATED SECTION BECOM ANB EXPERT END= -->
  <!-- ============================= FOOTER SECTION START HERE ===================================== -->
  <!-- ============================= FOOTER SECTION START HERE ===================================== -->
  <x-public-footer />
  <!-- =============================== FOOTER SECTION END HERE ===================================== -->
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