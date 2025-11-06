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
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/user/asset/css/bootstrap.min.css"
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
    <link rel="stylesheet" type="text/css" href="assets/user/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/user/asset/css/style.css" />
    <title>User Dashboard | FAQ’s</title>
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
        <div class="row dash-notification">
          <div class="col-md-12">
            <div class="dash">
              <div class="row">
                <div class="col-md-12">
                  <div class="dash-top">
                    <h1 class="dash-title">Dashboard</h1>
                    <i class="fa-solid fa-chevron-right"></i>
                    <span class="min-title">FAQ's</span>
                  </div>
                </div>
              </div>
              <!-- Blue MASSEGES section -->
              <div class="user-notification">
                <div class="row">
                  <div class="col-md-12">
                    <div class="notify">
                      <i class="bx bx-chat icon" title="FAQ's"></i>
                      <h2>FAQ</h2>
                    </div>
                  </div>
                </div>
              </div>
              <!--  -->
              <div class="faq-sec">
                <div class="row">
                  <h1>Frequently Asked Questions</h1>
                  @if ($faqs)
                  @foreach ($faqs as $item)

                  <div class="col-md-6 mb-3">
                    <div class="accordion">
                      <div class="accordion-item">
                        <input type="checkbox" id="accordion{{$item->id}}" />
                        <label for="accordion{{$item->id}}" class="accordion-item-title"
                          ><span class="icon"></span>{{$item->question}}</label
                        >
                        <div class="accordion-item-desc">
                          {!! $item->answer !!}
                        </div>
                      </div>

                      {{-- <div class="accordion-item">
                        <input type="checkbox" id="accordion2" />
                        <label for="accordion2" class="accordion-item-title"
                          ><span class="icon"></span>Have DreamCrowd refund
                          policy?</label
                        >
                        <div class="accordion-item-desc">
                          The timeline for seeing results from SEO can vary
                          based on several factors, such as the competitiveness
                          of keywords, the current state of the website, and the
                          effectiveness of the SEO strategy. Generally, it may
                          take several weeks to months before noticeable
                          improvements occur. However, long-term commitment to
                          SEO is essential for sustained success.
                        </div>
                      </div>

                      <div class="accordion-item">
                        <input type="checkbox" id="accordion3" />
                        <label for="accordion3" class="accordion-item-title"
                          ><span class="icon"></span>Have DreamCrowd refund
                          policy?</label
                        >
                        <div class="accordion-item-desc">
                          A successful SEO strategy involves various components,
                          including keyword research, on-page optimization,
                          quality content creation, link building, technical
                          SEO, and user experience optimization. These elements
                          work together to improve a website's relevance and
                          authority in the eyes of search engines.
                        </div>
                      </div> --}}
                    </div>
                  </div>
                      
                  @endforeach
                      
                  @endif
                  {{-- <div class="col-md-6 mb-3">
                    <div class="accordion">
                      <div class="accordion-item">
                        <input type="checkbox" id="accordion1" />
                        <label for="accordion1" class="accordion-item-title"
                          ><span class="icon"></span>Why DreamCrowd?</label
                        >
                        <div class="accordion-item-desc">
                          SEO, or Search Engine Optimization, is the practice of
                          optimizing a website to improve its visibility on
                          search engines like Google. It involves various
                          techniques to enhance a site's ranking in search
                          results. SEO is crucial for online businesses as it
                          helps drive organic traffic, increases visibility, and
                          ultimately leads to higher conversions.
                        </div>
                      </div>

                      <div class="accordion-item">
                        <input type="checkbox" id="accordion2" />
                        <label for="accordion2" class="accordion-item-title"
                          ><span class="icon"></span>Have DreamCrowd refund
                          policy?</label
                        >
                        <div class="accordion-item-desc">
                          The timeline for seeing results from SEO can vary
                          based on several factors, such as the competitiveness
                          of keywords, the current state of the website, and the
                          effectiveness of the SEO strategy. Generally, it may
                          take several weeks to months before noticeable
                          improvements occur. However, long-term commitment to
                          SEO is essential for sustained success.
                        </div>
                      </div>

                      <div class="accordion-item">
                        <input type="checkbox" id="accordion3" />
                        <label for="accordion3" class="accordion-item-title"
                          ><span class="icon"></span>Have DreamCrowd refund
                          policy?</label
                        >
                        <div class="accordion-item-desc">
                          A successful SEO strategy involves various components,
                          including keyword research, on-page optimization,
                          quality content creation, link building, technical
                          SEO, and user experience optimization. These elements
                          work together to improve a website's relevance and
                          authority in the eyes of search engines.
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="accordion">
                      <div class="accordion-item">
                        <input type="checkbox" id="accordion4" />
                        <label for="accordion4" class="accordion-item-title"
                          ><span class="icon"></span>How This Work?</label
                        >
                        <div class="accordion-item-desc">
                          Mobile optimization is crucial for SEO because search
                          engines prioritize mobile-friendly websites. With the
                          increasing use of smartphones, search engines like
                          Google consider mobile responsiveness as a ranking
                          factor. Websites that provide a seamless experience on
                          mobile devices are more likely to rank higher in
                          search results.
                        </div>
                      </div>

                      <div class="accordion-item">
                        <input type="checkbox" id="accordion5" />
                        <label for="accordion5" class="accordion-item-title"
                          ><span class="icon"></span>How can I reset my
                          password?</label
                        >
                        <div class="accordion-item-desc">
                          Backlinks, or inbound links from other websites to
                          yours, play a significant role in SEO. They are
                          considered a vote of confidence and can improve a
                          site's authority. Quality over quantity is crucial
                          when acquiring backlinks. Strategies for obtaining
                          backlinks include creating high-quality content, guest
                          posting, reaching out to industry influencers, and
                          participating in community activities. It's important
                          to focus on natural and ethical link-building
                          practices.
                        </div>
                      </div>

                      <div class="accordion-item">
                        <input type="checkbox" id="accordion6" />
                        <label for="accordion6" class="accordion-item-title"
                          ><span class="icon"></span>How can I reset my
                          password?</label
                        >
                        <div class="accordion-item-desc">
                          Backlinks, or inbound links from other websites to
                          yours, play a significant role in SEO. They are
                          considered a vote of confidence and can improve a
                          site's authority. Quality over quantity is crucial
                          when acquiring backlinks. Strategies for obtaining
                          backlinks include creating high-quality content, guest
                          posting, reaching out to industry influencers, and
                          participating in community activities. It's important
                          to focus on natural and ethical link-building
                          practices.
                        </div>
                      </div>
                    </div>
                  </div> --}}
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 text-center copyright">
            <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
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
<!-- ================ side js start End=============== -->


<!-- radio js here -->
<script>
  function showAdditionalOptions1() {
    hideAllAdditionalOptions();
    document.getElementById("additionalOptions1").style.display = "block";
  }

  function showAdditionalOptions2() {
    hideAllAdditionalOptions();
    document.getElementById("additionalOptions2").style.display = "block";
  }

  function showAdditionalOptions3() {
    hideAllAdditionalOptions();
  }

  function showAdditionalOptions4() {
    hideAllAdditionalOptions();
    document.getElementById("additionalOptions4").style.display = "block";
  }

  function hideAllAdditionalOptions() {
    var elements = document.getElementsByClassName("additional-options");
    for (var i = 0; i < elements.length; i++) {
      elements[i].style.display = "none";
    }
  }

  // Call the function to show the additional options for the default checked radio button on page load
  window.onload = function () {
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
  document.addEventListener("DOMContentLoaded", function () {
    // Get the Cancel button by its ID
    var cancelButton = document.getElementById("cancelButton");

    // Add a click event listener to the Cancel button
    cancelButton.addEventListener("click", function () {
      // Find the modal by its ID
      var modal = document.getElementById("exampleModal3");

      // Use Bootstrap's modal method to hide the modal
      $(modal).modal("hide");
    });
  });
</script>
