<!DOCTYPE html>
<html lang="en">
  <head> 
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
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/public-site/asset/css/style.css" />
    <link rel="stylesheet" href="assets/public-site/asset/css/navbar.css" />
    <link rel="stylesheet" href="assets/public-site/asset/css/Drop.css" />
    <link
      href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.2.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>

    <title>DreamCrowd | Expert FAQ's</title>
  </head>

  <body>
    <!-- =========================================== NAVBAR START HERE ================================================= -->
    <x-public-nav/>

    <!-- ============================================= NAVBAR END HERE ============================================ -->
   <!-- =============Experts page section start here============ -->
   <div class="container-fluid expert-page">
    <div class="row">
      <div class="col-md-12">
        <div class="heading">
          <h1>Experts</h1>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="expert-content">
        <div class="col-md-12">
          <h1>Frequently Asked Questions</h1>
          <p>Answers to your most common questions.</p>
          <!-- outer item 1 -->

          @if ($faqs_heading)

          @foreach ($faqs_heading as $item)

          <div class="accordion main-faq" id="accordionExample">
            <div class="accordion-item">
              @php
                    $heading_count = \App\Models\Faqs::where(['heading'=>$item->id])->count();
              @endphp
              @if ($heading_count >= 1)

              <h2 class="accordion-header" id="heading{{$item->id}}">
                <button
                  class="accordion-button top-button"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#collapse{{$item->id}}"
                  aria-expanded="true"
                  aria-controls="collapse{{$item->id}}"
                >
                  {{$item->heading}}  
                </button>
              </h2>
                  
              @endif
             
              <!-- inner faqs -->
              <div
                id="collapse{{$item->id}}"
                class="accordion-collapse collapse accordion-3"
                aria-labelledby="heading{{$item->id}}"
                data-bs-parent="#accordionExample"
              >
                <div class="accordion-body">
                  <!-- inner item -->
                  <div
                    class="accordion accordion-flush accordion-2"
                    id="accordionFlushExample2"
                  >
                    <div class="inner">

                      @if ($faqs)
                      @foreach ($faqs as $faq)

                      @if ($faq->heading == $item->id)

                      <div id="accordionFlushExample" class="accordion">
                        <div class="accordion-item item-1">
                          <h2
                            class="accordion-header"
                            id="flush-heading{{$item->id}}{{$faq->id}}"
                          >
                            <button
                              class="accordion-button collapsed"
                              type="button"
                              data-bs-toggle="collapse"
                              data-bs-target="#flush-collapse{{$item->id}}{{$faq->id}}"
                              aria-expanded="false"
                              aria-controls="flush-collapse{{$item->id}}{{$faq->id}}"
                            >
                            {{$faq->question}}
                            </button>
                          </h2>
                          <div
                            id="flush-collapse{{$item->id}}{{$faq->id}}"
                            class="accordion-collapse collapse"
                            aria-labelledby="flush-heading{{$item->id}}{{$faq->id}}"
                            data-bs-parent="#accordionFlushExample"
                          >
                            <div class="accordion-body-2">
                              <p>
                                {!! Str::limit($faq->answer, 621) !!} <a href="/faq-info/{{$faq->id}}">click here</a>
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>

                          
                      @endif
                          
                      @endforeach
                          
                      @endif




                    </div>

                    <!-- inner end -->
                  </div>
                </div>
              </div>
            </div>
          </div>


              
          @endforeach

              
          @endif



          {{-- <div class="accordion main-faq" id="accordionExample">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingOne">
                <button
                  class="accordion-button top-button"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#collapseOne"
                  aria-expanded="true"
                  aria-controls="collapseOne"
                >
                  What qualifications do your freelancers have?
                </button>
              </h2>
              <!-- inner faqs -->
              <div
                id="collapseOne"
                class="accordion-collapse collapse accordion-3"
                aria-labelledby="headingOne"
                data-bs-parent="#accordionExample"
              >
                <div class="accordion-body">
                  <!-- inner item -->
                  <div
                    class="accordion accordion-flush accordion-2"
                    id="accordionFlushExample2"
                  >
                    <div class="inner">
                      <div id="accordionFlushExample" class="accordion">
                        <div class="accordion-item item-1">
                          <h2
                            class="accordion-header"
                            id="flush-headingOneOne"
                          >
                            <button
                              class="accordion-button collapsed"
                              type="button"
                              data-bs-toggle="collapse"
                              data-bs-target="#flush-collapseOneOne"
                              aria-expanded="false"
                              aria-controls="flush-collapseOneOne"
                            >
                              Diverse Expertise
                            </button>
                          </h2>
                          <div
                            id="flush-collapseOneOne"
                            class="accordion-collapse collapse"
                            aria-labelledby="flush-headingOneOne"
                            data-bs-parent="#accordionFlushExample"
                          >
                            <div class="accordion-body-2">
                              <p>
                                Our freelancers possess a wide range of
                                qualifications and expertise spanning various
                                industries, ensuring a diverse skill set to
                                meet your project needs. Our freelancers
                                possess a wide range of qualifications and
                                expertise spanning various industries,
                                ensuring a diverse skill set to meet your
                                project needs.Our freelancers possess a wide
                                range of qualifications and expertise spanning
                                various industries, ensuring a diverse skill
                                set to meet your project needs.Our freelancers
                                possess a wide range of qualifications and
                                expertise spanning various industries,
                                ensuring a diverse skill set to meet your
                                project needs.
                                <a href="faq-info.html">click here</a>
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!--inner item 2 -->
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOneTwo">
                          <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOneTwo"
                            aria-expanded="false"
                            aria-controls="flush-collapseOneTwo"
                          >
                            Educational Backgrounds
                          </button>
                        </h2>
                        <div
                          id="flush-collapseOneTwo"
                          class="accordion-collapse collapse inner-calps"
                          aria-labelledby="flush-headingOneTwo"
                          data-bs-parent="#accordionFlushExample"
                        >
                          <div class="accordion-body-2">
                            <p>
                              Our freelancers possess a wide range of
                              qualifications and expertise spanning various
                              industries, ensuring a diverse skill set to meet
                              your project needs. Our freelancers possess a
                              wide range of qualifications and expertise
                              spanning various industries, ensuring a diverse
                              skill set to meet your project needs.Our
                              freelancers possess a wide range of
                              qualifications and expertise spanning various
                              industries, ensuring a diverse skill set to meet
                              your project needs.Our freelancers possess a
                              wide range of qualifications and expertise
                              spanning various industries, ensuring a diverse
                              skill set to meet your project needs.
                              <a href="faq-info.html">click here</a>
                            </p>
                          </div>
                        </div>
                      </div>
                      <!--inner item 3 -->
                      <div class="accordion-item">
                        <h2
                          class="accordion-header"
                          id="flush-headingOneThree"
                        >
                          <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOneThree"
                            aria-expanded="false"
                            aria-controls="flush-collapseOneThree"
                          >
                            Professional Experience
                          </button>
                        </h2>
                        <div
                          id="flush-collapseOneThree"
                          class="accordion-collapse collapse"
                          aria-labelledby="flush-headingOneThree"
                          data-bs-parent="#accordionFlushExample"
                        >
                          <div class="accordion-body-2">
                            <p>
                              Our freelancers possess a wide range of
                              qualifications and expertise spanning various
                              industries, ensuring a diverse skill set to meet
                              your project needs. Our freelancers possess a
                              wide range of qualifications and expertise
                              spanning various industries, ensuring a diverse
                              skill set to meet your project needs.Our
                              freelancers possess a wide range of
                              qualifications and expertise spanning various
                              industries, ensuring a diverse skill set to meet
                              your project needs.Our freelancers possess a
                              wide range of qualifications and expertise
                              spanning various industries, ensuring a diverse
                              skill set to meet your project needs.
                              <a href="faq-info.html">click here</a>
                            </p>
                          </div>
                        </div>
                      </div>
                      <!--inner item 4 -->
                      <div class="accordion-item">
                        <h2
                          class="accordion-header"
                          id="flush-headingOnefour"
                        >
                          <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOnefour"
                            aria-expanded="false"
                            aria-controls="flush-collapseOnefour"
                          >
                            Portfolio Showcase
                          </button>
                        </h2>
                        <div
                          id="flush-collapseOnefour"
                          class="accordion-collapse collapse"
                          aria-labelledby="flush-headingOnefour"
                          data-bs-parent="#accordionFlushExample"
                        >
                          <div class="accordion-body-2">
                            <p>
                              Our freelancers possess a wide range of
                              qualifications and expertise spanning various
                              industries, ensuring a diverse skill set to meet
                              your project needs. Our freelancers possess a
                              wide range of qualifications and expertise
                              spanning various industries, ensuring a diverse
                              skill set to meet your project needs.Our
                              freelancers possess a wide range of
                              qualifications and expertise spanning various
                              industries, ensuring a diverse skill set to meet
                              your project needs.Our freelancers possess a
                              wide range of qualifications and expertise
                              spanning various industries, ensuring a diverse
                              skill set to meet your project needs.
                              <a href="faq-info.html">click here</a>
                            </p>
                          </div>
                        </div>
                      </div>
                      <!--inner item 5 -->
                      <div class="accordion-item">
                        <h2
                          class="accordion-header"
                          id="flush-headingOnefive"
                        >
                          <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOnefive"
                            aria-expanded="false"
                            aria-controls="flush-collapseOnefive"
                          >
                            Client Reviews and Ratings
                          </button>
                        </h2>
                        <div
                          id="flush-collapseOnefive"
                          class="accordion-collapse collapse"
                          aria-labelledby="flush-headingOnefive"
                          data-bs-parent="#accordionFlushExample"
                        >
                          <div class="accordion-body-2">
                            <p>
                              Our freelancers possess a wide range of
                              qualifications and expertise spanning various
                              industries, ensuring a diverse skill set to meet
                              your project needs. Our freelancers possess a
                              wide range of qualifications and expertise
                              spanning various industries, ensuring a diverse
                              skill set to meet your project needs.Our
                              freelancers possess a wide range of
                              qualifications and expertise spanning various
                              industries, ensuring a diverse skill set to meet
                              your project needs.Our freelancers possess a
                              wide range of qualifications and expertise
                              spanning various industries, ensuring a diverse
                              skill set to meet your project needs.
                              <a href="faq-info.html">click here</a>
                            </p>
                          </div>
                        </div>
                      </div>
                      <!--inner item 6 -->
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOnesix">
                          <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOnesix"
                            aria-expanded="false"
                            aria-controls="flush-collapseOnesix"
                          >
                            Specialized Skills
                          </button>
                        </h2>
                        <div
                          id="flush-collapseOnesix"
                          class="accordion-collapse collapse"
                          aria-labelledby="flush-headingOnesix"
                          data-bs-parent="#accordionFlushExample"
                        >
                          <div class="accordion-body-2">
                            <p>
                              Our freelancers possess a wide range of
                              qualifications and expertise spanning various
                              industries, ensuring a diverse skill set to meet
                              your project needs. Our freelancers possess a
                              wide range of qualifications and expertise
                              spanning various industries, ensuring a diverse
                              skill set to meet your project needs.Our
                              freelancers possess a wide range of
                              qualifications and expertise spanning various
                              industries, ensuring a diverse skill set to meet
                              your project needs.Our freelancers possess a
                              wide range of qualifications and expertise
                              spanning various industries, ensuring a diverse
                              skill set to meet your project needs.
                              <a href="faq-info.html">click here</a>
                            </p>
                          </div>
                        </div>
                      </div>
                      <!--inner item 7 -->
                      <div class="accordion-item">
                        <h2
                          class="accordion-header"
                          id="flush-headingOneseven"
                        >
                          <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOneseven"
                            aria-expanded="false"
                            aria-controls="flush-collapseOneseven"
                          >
                            Continuous Learning
                          </button>
                        </h2>
                        <div
                          id="flush-collapseOneseven"
                          class="accordion-collapse collapse"
                          aria-labelledby="flush-headingOneseven"
                          data-bs-parent="#accordionFlushExample"
                        >
                          <div class="accordion-body-2">
                            <p>
                              Our freelancers possess a wide range of
                              qualifications and expertise spanning various
                              industries, ensuring a diverse skill set to meet
                              your project needs. Our freelancers possess a
                              wide range of qualifications and expertise
                              spanning various industries, ensuring a diverse
                              skill set to meet your project needs.Our
                              freelancers possess a wide range of
                              qualifications and expertise spanning various
                              industries, ensuring a diverse skill set to meet
                              your project needs.Our freelancers possess a
                              wide range of qualifications and expertise
                              spanning various industries, ensuring a diverse
                              skill set to meet your project needs.
                              <a href="faq-info.html">click here</a>
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- inner end -->
                  </div>
                </div>
              </div>
            </div>
          </div> --}}




        </div>
       
      </div>
    </div>
  </div>

  <!-- =============Experts page section END here============ -->
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
