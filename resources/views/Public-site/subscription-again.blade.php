<!doctype html>
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
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/public-site/asset/css/style.css" />
    <link rel="stylesheet" href="assets/public-site/asset/css/navbar.css">
    <link rel="stylesheet" href="assets/public-site/asset/css/Drop.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.2.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>

    <title>DreamCrowd | Again Payment Subscription</title>
</head>

<body>
    <!-- =========================================== NAVBAR START HERE ================================================= -->
    <x-public-nav/>

    <!-- ============================================= NAVBAR END HERE ============================================ -->
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <!-- ======================== PAYMENT SECTION START FROM HERE ====================== -->
                <div class="col-lg-12 col-md-12">
                    <div class="payment-sec">
                        <!-- ======================== PAYMENT DETAILS START FROM HERE ====================== -->
                        <div class="payment-detail-title">
                            <div class="row">
                                <div class="col-md-6 payment-desc">
                                    <div class="row">
                                        <div class="col-md-6">
                                    <h1>Title: </h1>
                                </div>
                                        <div class="col-md-6">
                                        <span class="">Figma Advance Course</span>
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-6 payment-desc">
                                    <div class="row">
                                        <div class="col-md-6">
                                    
                                    <h1>Seller </h1>
                                    </div>
                                        <div class="col-md-6">
                                        <span class="">Usama A.</span>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="payment-detail">
                            <div class="row">
                                <div class="col-md-6 payment-desc">
                                    <div class="row">
                                        <div class="col-md-6">
                                    <h1>Payment Type </h1>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="">Subscription</span>
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-6 payment-desc">
                                    <div class="row">
                                        <div class="col-md-6">
                                    <h1>Booking Type </h1>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="">Private Group</span>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="payment-detail">
                            <div class="row">
                                <div class="col-md-6 payment-desc">
                                    <div class="row">
                                        <div class="col-md-6">
                                    <h1>Service Type </h1>
                                 </div> 
                                 <div class="col-md-6">
                                 <span class="">3 Classes Every Month</span>
                                </div>
                                </div>
                                </div>
                                <div class="col-md-6 payment-desc">
                                    <div class="row">
                                        <div class="col-md-6">
                                    <h1>Additional Guests </h1>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="">2 Guests</span>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!-- ======================== PAYMENT DETAILS ENDED HERE ====================== -->
                        <!-- ======================== PAYMENT DESCRIPTION START FROM HERE ====================== -->
                        <div class="paragraph">
                            <p class="">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vitae ut tellus quis a euismod ut niSl, quis. Tristique bibendum morbi vel vitæ ultrices donec accumsan. Tincidunt eget habitant pellentesque id purus. Hendrerit varius
                                sapien, nunc, turpis augue arcu venenatis. At sed consectetur in viverra duis tincidunt diam.
                            </p>
                        </div>
                        <!-- ======================== PAYMENT DESCRIPTION ENDED HERE ====================== -->
                        <!-- ======================== PAYMENT TIMEZONE START FROM HERE ====================== -->
                        <div class="timezone-sec">
                            <div class="row ">
                                <h1>Timezone: Europe/London GMT</h1>
                                <div class="col-lg-3 col-md-6 rectangle-desc">
                                    <div class="rectangle">
                                        <h3>Class 1</h3>
                                        <span class="mt-2">Tue,25 May 10:00-11:00(am)</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 rectangle-desc">
                                    <div class="rectangle">
                                        <h3>Class 2</h3>
                                        <span class="mt-2">Tue,25 May 10:00-11:00(am)</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 rectangle-desc">
                                    <div class="rectangle">
                                        <h3>Class 3</h3>
                                        <span class="mt-2">Tue,25 May 10:00-11:00(am)</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 rectangle-desc">
                                    <div class="rectangle">
                                        <h3>Class 4</h3>
                                        <span class="mt-2">Tue,25 May 10:00-11:00(am)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ======================== PAYMENT TIMEZONE ENDED HERE ====================== -->
                    </div>
                    <!-- ======================== PAYMENT SECTION ENDED HERE ====================== -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="subscription-page-sec">
                                <div class="d-grid gap-2 d-md-block float-end">
                                    <button class="btn m-0 cancel-btn" type="button">Cancel</button>
                                    <button class="btn m-0 submit-btn" type="button">Submit</button>
                                </div>
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
    <script src="assets/public-site/libs/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="assets/public-site/libs/aos/js/aos.js"></script>
    <script src="assets/public-site/asset/js/bootstrap.min.js"></script>
    <script src="assets/public-site/asset/js/script.js"></script>
</body>

</html>