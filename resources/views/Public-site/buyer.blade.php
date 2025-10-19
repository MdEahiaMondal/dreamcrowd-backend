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

    <title>DreamCrowd | Buyer FAQ's</title>
  </head>

  <body>
    <!-- =========================================== NAVBAR START HERE ================================================= -->
    <x-public-nav/>

    <!-- ============================================= NAVBAR END HERE ============================================ -->
    <!-- =============Buyers page section start here============ -->
    <div class="container-fluid expert-page">
      <div class="row">
        <div class="col-md-12">
          <div class="heading">
            <h1>Buyers</h1>
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
  
  



            
          </div>
          
        </div>
      </div>
    </div>

    <!-- =============Buyers page section END here============ -->
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
    <!-- FAQ's Script here -->
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        // Get the hash value from the URL
        var hash = window.location.hash;
        if (hash) {
          // Remove the '#' character
          var target = document.querySelector(hash);
          if (target) {
            // Check if the target is inside an accordion item
            var accordionItem = target.closest(".accordion-item");
            if (accordionItem) {
              // Get the collapse element associated with the accordion item
              var collapse = accordionItem.querySelector(".accordion-collapse");
              if (collapse) {
                // Add 'show' class to open the accordion
                collapse.classList.add("show");
                // Update the button aria-expanded attribute
                var button = accordionItem.querySelector(".accordion-button");
                if (button) {
                  button.setAttribute("aria-expanded", "true");
                }
              }
            }
          }
        }
      });
    </script>
  </body>
</html>
