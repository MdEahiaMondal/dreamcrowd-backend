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
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.2.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>

    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/public-site/asset/css/style.css" />
    <link rel="stylesheet" href="assets/public-site/asset/css/navbar.css" />
    <link rel="stylesheet" href="assets/public-site/asset/css/Drop.css" />
    <title>DreamCrowd | Privacy & Policy</title>
  </head>

  <body>
    <!-- =========================================== NAVBAR START HERE ================================================= -->
    <x-public-nav/>
    <!-- ============================================= NAVBAR END HERE ============================================ -->
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="privacy-policy">
            <h1 class="top-text">Privacy & Policy</h1>
            <div class="row d-flex align-items-start">
              <div class="col-md-4">
                <div
                  class="nav flex-column nav-pills"
                  id="v-pills-tab"
                  role="tablist"
                  aria-orientation="vertical"
                >

                @if ($privacy)
                @php  $i = 1; @endphp
                @foreach ($privacy as $item)

                <button
                class="nav-link @if($i ==1) active @endif"
                id="v-pills-{{$item->id}}-tab"
                data-bs-toggle="pill"
                data-bs-target="#v-pills-{{$item->id}}"
                type="button"
                role="tab"
                aria-controls="v-pills-{{$item->id}}"
                aria-selected="true"
              >
                <li>{{$item->heading}}</li>
              </button>
                  
              @php  $i++ @endphp
                @endforeach
                    
                @endif

                  {{-- <button
                    class="nav-link active"
                    id="v-pills-home-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#v-pills-home"
                    type="button"
                    role="tab"
                    aria-controls="v-pills-home"
                    aria-selected="true"
                  >
                    <li>Introduction</li>
                  </button>
                  <button
                    class="nav-link"
                    id="v-pills-profile-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#v-pills-profile"
                    type="button"
                    role="tab"
                    aria-controls="v-pills-profile"
                    aria-selected="false"
                  >
                    <li>Consent</li>
                  </button>
                  <button
                    class="nav-link"
                    id="v-pills-messages-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#v-pills-messages"
                    type="button"
                    role="tab"
                    aria-controls="v-pills-messages"
                    aria-selected="false"
                  >
                    <li>Information we collect</li>
                  </button>
                  <button
                    class="nav-link"
                    id="v-pills-settings-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#v-pills-settings"
                    type="button"
                    role="tab"
                    aria-controls="v-pills-settings"
                    aria-selected="false"
                  >
                    <li>How we use your information</li>
                  </button>
                  <button
                    class="nav-link"
                    id="v-pills-log-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#v-pills-log"
                    type="button"
                    role="tab"
                    aria-controls="v-pills-log"
                    aria-selected="false"
                  >
                    <li>Log Files</li>
                  </button>
                  <button
                    class="nav-link"
                    id="v-pills-file-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#v-pills-file"
                    type="button"
                    role="tab"
                    aria-controls="v-pills-file"
                    aria-selected="false"
                  >
                    <li>Advertising Partners</li>
                  </button>
                  <button
                    class="nav-link"
                    id="v-pills-log2-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#v-pills-log2"
                    type="button"
                    role="tab"
                    aria-controls="v-pills-log2"
                    aria-selected="false"
                  >
                    <li>Third Party Privacy Policies</li>
                  </button>
                  <button
                    class="nav-link"
                    id="v-pills-file2-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#v-pills-file2"
                    type="button"
                    role="tab"
                    aria-controls="v-pills-file2"
                    aria-selected="false"
                  >
                    <li>CCPA Privacy Rights</li>
                  </button>
                  <button
                    class="nav-link"
                    id="v-pills-log3-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#v-pills-log3"
                    type="button"
                    role="tab"
                    aria-controls="v-pills-log3"
                    aria-selected="false"
                  >
                    <li>GDPR Data Protection Rights</li>
                  </button>
                  <button
                    class="nav-link"
                    id="v-pills-file3-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#v-pills-file3"
                    type="button"
                    role="tab"
                    aria-controls="v-pills-file3"
                    aria-selected="false"
                  >
                    <li>Children's Information</li>
                  </button> --}}
                </div>
              </div>
              <div class="col-md-8">
                <div class="tab-content" id="v-pills-tabContent">

                  @if ($privacy)
                  @php $i = 1; @endphp
                  @foreach ($privacy as $item)
                  <div
                  class="tab-pane fade show @if($i ==1) active @endif "
                  id="v-pills-{{$item->id}}"
                  role="tabpanel"
                  aria-labelledby="v-pills-{{$item->id}}-tab"
                >
                  <h2 class="tabs-heading">{{$item->heading}}</h2>
                  <p>{!! $item->detail !!}
                  </p>
                </div>

                @php $i++ @endphp
                  @endforeach
                      
                  @endif

                  {{-- <div
                    class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    <h2 class="tabs-heading">Introduction</h2>
             <p>These terms and conditions outline the rules and regulations for the use of dreamcrowd's Website, located ata <a href="#"> http://www.dreamcrowd.in/.</a>
               <br><br>
              By accessing this website we assume you accept these terms and conditions. Do not continue to use dreamcrowd.in if you do not agree to take all of the terms and conditions stated on this page.
               <br><br>
              The following terminology applies to these <a href="#">Terms and Conditions</a> , Privacy Statement and Disclaimer Notice and all Agreements: "Client", "You" and "Your" refers to you, the person log on this website and compliant to the Company’s terms and conditions. "The Company", "Ourselves", "We", "Our" and "Us", refers to our Company. "Party", "Parties", or "Us", refers to both the Client and ourselves. All terms refer to the offer, acceptance and consideration of payment necessary to undertake the process of our assistance to the Client in the most appropriate manner for the express purpose of meeting the Client’s needs in respect of provision of the Company’s stated services, in accordance with and subject to, prevailing law of Netherlands. Any use of the above terminology or other words in the singular, plural, capitalization and/or he/she or they, are taken as interchangeable and therefore as referring to same.
             </p>
                  </div>

                  <div
                    class="tab-pane fade"
                    id="v-pills-profile"
                    role="tabpanel"
                    aria-labelledby="v-pills-profile-tab">
                      <h2 class="tabs-heading">Consent</h2>
                      <p>These terms and conditions outline the rules and regulations for the use of dreamcrowd's Website, located ata <a href="#"> http://www.dreamcrowd.in/.</a>
                        <br><br>
                       By accessing this website we assume you accept these terms and conditions. Do not continue to use dreamcrowd.in if you do not agree to take all of the terms and conditions stated on this page.
                        <br><br>
                       The following terminology applies to these <a href="#">Terms and Conditions</a> , Privacy Statement and Disclaimer Notice and all Agreements: "Client", "You" and "Your" refers to you, the person log on this website and compliant to the Company’s terms and conditions. "The Company", "Ourselves", "We", "Our" and "Us", refers to our Company. "Party", "Parties", or "Us", refers to both the Client and ourselves. All terms refer to the offer, acceptance and consideration of payment necessary to undertake the process of our assistance to the Client in the most appropriate manner for the express purpose of meeting the Client’s needs in respect of provision of the Company’s stated services, in accordance with and subject to, prevailing law of Netherlands. Any use of the above terminology or other words in the singular, plural, capitalization and/or he/she or they, are taken as interchangeable and therefore as referring to same.
                      </p>
                  </div>
                  <div
                    class="tab-pane fade"
                    id="v-pills-messages"
                    role="tabpanel"
                    aria-labelledby="v-pills-messages-tab">
                      <h2 class="tabs-heading">Information we collect</h2>
                      <p>These terms and conditions outline the rules and regulations for the use of dreamcrowd's Website, located ata <a href="#"> http://www.dreamcrowd.in/.</a>
                        <br><br>
                       By accessing this website we assume you accept these terms and conditions. Do not continue to use dreamcrowd.in if you do not agree to take all of the terms and conditions stated on this page.
                        <br><br>
                       The following terminology applies to these <a href="#">Terms and Conditions</a> , Privacy Statement and Disclaimer Notice and all Agreements: "Client", "You" and "Your" refers to you, the person log on this website and compliant to the Company’s terms and conditions. "The Company", "Ourselves", "We", "Our" and "Us", refers to our Company. "Party", "Parties", or "Us", refers to both the Client and ourselves. All terms refer to the offer, acceptance and consideration of payment necessary to undertake the process of our assistance to the Client in the most appropriate manner for the express purpose of meeting the Client’s needs in respect of provision of the Company’s stated services, in accordance with and subject to, prevailing law of Netherlands. Any use of the above terminology or other words in the singular, plural, capitalization and/or he/she or they, are taken as interchangeable and therefore as referring to same.
                      </p>
                  </div>
                  <div
                    class="tab-pane fade"
                    id="v-pills-settings"
                    role="tabpanel"
                    aria-labelledby="v-pills-settings-tab">
                    <h2 class="tabs-heading">How we use your information</h2>
                    <p>These terms and conditions outline the rules and regulations for the use of dreamcrowd's Website, located ata <a href="#"> http://www.dreamcrowd.in/.</a>
                      <br><br>
                     By accessing this website we assume you accept these terms and conditions. Do not continue to use dreamcrowd.in if you do not agree to take all of the terms and conditions stated on this page.
                      <br><br>
                     The following terminology applies to these <a href="#">Terms and Conditions</a> , Privacy Statement and Disclaimer Notice and all Agreements: "Client", "You" and "Your" refers to you, the person log on this website and compliant to the Company’s terms and conditions. "The Company", "Ourselves", "We", "Our" and "Us", refers to our Company. "Party", "Parties", or "Us", refers to both the Client and ourselves. All terms refer to the offer, acceptance and consideration of payment necessary to undertake the process of our assistance to the Client in the most appropriate manner for the express purpose of meeting the Client’s needs in respect of provision of the Company’s stated services, in accordance with and subject to, prevailing law of Netherlands. Any use of the above terminology or other words in the singular, plural, capitalization and/or he/she or they, are taken as interchangeable and therefore as referring to same.
                    </p>
                  </div>
                  <div
                    class="tab-pane fade"
                    id="v-pills-log"
                    role="tabpanel"
                    aria-labelledby="v-pills-log-tab">
                    <h2 class="tabs-heading">Log files</h2>
                    <p>These terms and conditions outline the rules and regulations for the use of dreamcrowd's Website, located ata <a href="#"> http://www.dreamcrowd.in/.</a>
                      <br><br>
                     By accessing this website we assume you accept these terms and conditions. Do not continue to use dreamcrowd.in if you do not agree to take all of the terms and conditions stated on this page.
                      <br><br>
                     The following terminology applies to these <a href="#">Terms and Conditions</a> , Privacy Statement and Disclaimer Notice and all Agreements: "Client", "You" and "Your" refers to you, the person log on this website and compliant to the Company’s terms and conditions. "The Company", "Ourselves", "We", "Our" and "Us", refers to our Company. "Party", "Parties", or "Us", refers to both the Client and ourselves. All terms refer to the offer, acceptance and consideration of payment necessary to undertake the process of our assistance to the Client in the most appropriate manner for the express purpose of meeting the Client’s needs in respect of provision of the Company’s stated services, in accordance with and subject to, prevailing law of Netherlands. Any use of the above terminology or other words in the singular, plural, capitalization and/or he/she or they, are taken as interchangeable and therefore as referring to same.
                    </p>
                  </div>
                  <div
                    class="tab-pane fade"
                    id="v-pills-file"
                    role="tabpanel"
                    aria-labelledby="v-pills-file-tab">
                    <h2 class="tabs-heading">Advertising Partners</h2>
                    <p>These terms and conditions outline the rules and regulations for the use of dreamcrowd's Website, located ata <a href="#"> http://www.dreamcrowd.in/.</a>
                      <br><br>
                     By accessing this website we assume you accept these terms and conditions. Do not continue to use dreamcrowd.in if you do not agree to take all of the terms and conditions stated on this page.
                      <br><br>
                     The following terminology applies to these <a href="#">Terms and Conditions</a> , Privacy Statement and Disclaimer Notice and all Agreements: "Client", "You" and "Your" refers to you, the person log on this website and compliant to the Company’s terms and conditions. "The Company", "Ourselves", "We", "Our" and "Us", refers to our Company. "Party", "Parties", or "Us", refers to both the Client and ourselves. All terms refer to the offer, acceptance and consideration of payment necessary to undertake the process of our assistance to the Client in the most appropriate manner for the express purpose of meeting the Client’s needs in respect of provision of the Company’s stated services, in accordance with and subject to, prevailing law of Netherlands. Any use of the above terminology or other words in the singular, plural, capitalization and/or he/she or they, are taken as interchangeable and therefore as referring to same.
                    </p>
                  </div>
                  <div
                    class="tab-pane fade"
                    id="v-pills-log2"
                    role="tabpanel"
                    aria-labelledby="v-pills-log2-tab">
                    <h2 class="tabs-heading">Third Party Privacy Policies</h2>
                    <p>These terms and conditions outline the rules and regulations for the use of dreamcrowd's Website, located ata <a href="#"> http://www.dreamcrowd.in/.</a>
                      <br><br>
                     By accessing this website we assume you accept these terms and conditions. Do not continue to use dreamcrowd.in if you do not agree to take all of the terms and conditions stated on this page.
                      <br><br>
                     The following terminology applies to these <a href="#">Terms and Conditions</a> , Privacy Statement and Disclaimer Notice and all Agreements: "Client", "You" and "Your" refers to you, the person log on this website and compliant to the Company’s terms and conditions. "The Company", "Ourselves", "We", "Our" and "Us", refers to our Company. "Party", "Parties", or "Us", refers to both the Client and ourselves. All terms refer to the offer, acceptance and consideration of payment necessary to undertake the process of our assistance to the Client in the most appropriate manner for the express purpose of meeting the Client’s needs in respect of provision of the Company’s stated services, in accordance with and subject to, prevailing law of Netherlands. Any use of the above terminology or other words in the singular, plural, capitalization and/or he/she or they, are taken as interchangeable and therefore as referring to same.
                    </p>
                  </div>
                  <div
                    class="tab-pane fade"
                    id="v-pills-file2"
                    role="tabpanel"
                    aria-labelledby="v-pills-file2-tab">
                    <h2 class="tabs-heading">CCPA Privacy Rights</h2>
                    <p>These terms and conditions outline the rules and regulations for the use of dreamcrowd's Website, located ata <a href="#"> http://www.dreamcrowd.in/.</a>
                      <br><br>
                     By accessing this website we assume you accept these terms and conditions. Do not continue to use dreamcrowd.in if you do not agree to take all of the terms and conditions stated on this page.
                      <br><br>
                     The following terminology applies to these <a href="#">Terms and Conditions</a> , Privacy Statement and Disclaimer Notice and all Agreements: "Client", "You" and "Your" refers to you, the person log on this website and compliant to the Company’s terms and conditions. "The Company", "Ourselves", "We", "Our" and "Us", refers to our Company. "Party", "Parties", or "Us", refers to both the Client and ourselves. All terms refer to the offer, acceptance and consideration of payment necessary to undertake the process of our assistance to the Client in the most appropriate manner for the express purpose of meeting the Client’s needs in respect of provision of the Company’s stated services, in accordance with and subject to, prevailing law of Netherlands. Any use of the above terminology or other words in the singular, plural, capitalization and/or he/she or they, are taken as interchangeable and therefore as referring to same.
                    </p>
                  </div>
                  <div
                    class="tab-pane fade"
                    id="v-pills-log3"
                    role="tabpanel"
                    aria-labelledby="v-pills-log3-tab">
                    <h2 class="tabs-heading">GDPR Data Protection Rights</h2>
                    <p>These terms and conditions outline the rules and regulations for the use of dreamcrowd's Website, located ata <a href="#"> http://www.dreamcrowd.in/.</a>
                      <br><br>
                     By accessing this website we assume you accept these terms and conditions. Do not continue to use dreamcrowd.in if you do not agree to take all of the terms and conditions stated on this page.
                      <br><br>
                     The following terminology applies to these <a href="#">Terms and Conditions</a> , Privacy Statement and Disclaimer Notice and all Agreements: "Client", "You" and "Your" refers to you, the person log on this website and compliant to the Company’s terms and conditions. "The Company", "Ourselves", "We", "Our" and "Us", refers to our Company. "Party", "Parties", or "Us", refers to both the Client and ourselves. All terms refer to the offer, acceptance and consideration of payment necessary to undertake the process of our assistance to the Client in the most appropriate manner for the express purpose of meeting the Client’s needs in respect of provision of the Company’s stated services, in accordance with and subject to, prevailing law of Netherlands. Any use of the above terminology or other words in the singular, plural, capitalization and/or he/she or they, are taken as interchangeable and therefore as referring to same.
                    </p>
                  </div>
                  <div
                    class="tab-pane fade"
                    id="v-pills-file3"
                    role="tabpanel"
                    aria-labelledby="v-pills-file3-tab">
                    <h2 class="tabs-heading">Children's Information</h2>
                    <p>These terms and conditions outline the rules and regulations for the use of dreamcrowd's Website, located ata <a href="#"> http://www.dreamcrowd.in/.</a>
                      <br><br>
                     By accessing this website we assume you accept these terms and conditions. Do not continue to use dreamcrowd.in if you do not agree to take all of the terms and conditions stated on this page.
                      <br><br>
                     The following terminology applies to these <a href="#">Terms and Conditions</a> , Privacy Statement and Disclaimer Notice and all Agreements: "Client", "You" and "Your" refers to you, the person log on this website and compliant to the Company’s terms and conditions. "The Company", "Ourselves", "We", "Our" and "Us", refers to our Company. "Party", "Parties", or "Us", refers to both the Client and ourselves. All terms refer to the offer, acceptance and consideration of payment necessary to undertake the process of our assistance to the Client in the most appropriate manner for the express purpose of meeting the Client’s needs in respect of provision of the Company’s stated services, in accordance with and subject to, prevailing law of Netherlands. Any use of the above terminology or other words in the singular, plural, capitalization and/or he/she or they, are taken as interchangeable and therefore as referring to same.
                    </p>
                  </div> --}}
                </div>
              </div>
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
    <!-- <script src="assets/public-site/libs/owl-carousel/js/jquery.min.js"></script> -->
    <script src="assets/public-site/libs/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="assets/public-site/libs/aos/js/aos.js"></script>
    <script src="assets/public-site/asset/js/bootstrap.min.js"></script>
    <script src="assets/public-site/asset/js/script.js"></script>
  </body>
</html>
