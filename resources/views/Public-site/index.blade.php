<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <!-- View Point scale to 1.0 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Animate css -->
    <link rel="stylesheet" href="assets/public-site/libs/animate/css/animate.css"/>
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="assets/public-site/libs/aos/css/aos.css"/>
    {{-- Fav Icon --}}
    @php  $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
    @endif
    <!-- Datatable css  -->
    <link rel="stylesheet" href="assets/public-site/libs/datatable/css/datatable.css"/>
    <!-- Select2 css -->
    <link href="assets/public-site/libs/select2/css/select2.min.css" rel="stylesheet"/>
    <!-- Owl carousel css -->
    <link href="assets/public-site/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet"/>
    <link href="assets/public-site/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet"/>

    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="assets/public-site/asset/css/bootstrap.min.css"/>
    <link href="assets/public-site/asset/css/fontawesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"/>
    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    {{-- =======Toastr CDN ======== --}}
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- =======Toastr CDN ======== --}}

    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/public-site/asset/css/style.css"/>
    <link rel="stylesheet" href="assets/public-site/asset/css/navbar.css">
    <link rel="stylesheet" href="assets/public-site/asset/css/Drop.css">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.2.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>


    <title>DreamCrowd | Home</title>
    <style>
        .slider {
            position: relative;
            width: 100%;
            margin: auto;
            overflow: hidden;
        }

        .slides {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slide {
            min-width: 100%;
            box-sizing: border-box;
        }

        .slide img {
            width: 100%;
            display: block;
        }

        .dots {
            text-align: center;
            padding: 10px 0px;
        }

        .dot {
            cursor: pointer;
            height: 10px;
            width: 10px;
            margin: 0 1px;
            background-color: #fff;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }

        .dot.active {
            background-color: #fff;
        }
    </style>
</head>

<body>


@if (Session::has('newPass'))

    <script>
        $(document).ready(function () {
            $('#exampleModal3').modal('show');
        });
    </script>

@endif

@if (Session::has('error'))
    <script>

        toastr.options =
            {
                "closeButton": true,
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
                "closeButton": true,
                "progressBar": true,
                "timeOut": "10000", // 10 seconds
                "extendedTimeOut": "4410000" // 10 seconds
            }
        toastr.success("{{ session('success') }}");


    </script>
@endif

<!-- ========================= NAVBAR SECTION START HERE ========================================= -->
<x-public-nav/>
<!-- ========================= NAVBAR SECTION END HERE ========================================= -->
<!-- =========================================== HERO SECTION START HERE ================================================= -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="deamHero">
                <div class="main">
                    <form action="/seller-listing-service-search">@csrf
                        <div class="Hero-Main-Scetion">
                            <div class="hero-Main-Content">
                                @if ($home)
                                    @if ($home->notification_bar == 1)
                                        <span class="hero-Text"
                                              style="line-height: 30px;"><strong>{{$home->notification_heading}}</strong>{{$home->notification}}</span>
                                    @endif


                                    <h1>{{$home->hero_text}}</h1>
                                    <p>{{$home->hero_discription}}</p>
                                @endif
                                <!--~~~~~~Hero-Search~~~~~~-->

                                <div class="Hero-Search-Bar">
                                    <div class="Hero-Search-Site">
                                        <div class="Hero-search search-container search-container-main">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                            <input type="text" id="keyword_main" name="keyword" autocomplete="off"
                                                   placeholder="Search here"/>
                                            <input type="hidden" name="category_type" value="Category"/>
                                            <!-- <ul class="results">
                                                <li>Logo Design</li>
                                                <li>Sketch</li>
                                                <li>Perfect Logo</li>
                                                <li>Symbolic Logo</li>
                                                <li>Brand Logo</li>
                                            </ul> -->
                                            <div class="suggestions" id="suggestions_main"
                                                 style="width: max-content;"></div>
                                        </div>
                                    </div>
                                    <div class="vertical-line" style="border-right:1px solid #E5F5FF ; height: 82px;">

                                    </div>
                                    <div class="Hero-Site-Category">
                                        <div class="select">
                                            <select name="category_service" id="format">
                                                <option selected disabled>Categories</option>

                                                @if ($categories)
                                                    @foreach ($categories as $item)
                                                        <option value="{{$item->category}}">{{$item->category}}</option>
                                                    @endforeach

                                                @endif


                                            </select>
                                        </div>

                                    </div>
                                    <div class="vertical-line" style="border-right:1px solid #E5F5FF ; height: 82px;">

                                    </div>
                                    <div class="Hero-Submit">
                                        <button type="submit">Search</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

                <div class="Hero-img">
                    @if ($home)

                        <img class="Hero-img-outer" src="assets/public-site/asset/img/{{$home->hero_image}}" alt="">
                    @endif
                    <div class="Hero-img-inner" style="z-index: 111;">

                        @if ($home)

                            <div class="Hero-main-rateing">
                                <div class="main-profiles">
                                    <div id="porofile0">
                                        <img src="assets/public-site/asset/img/{{$home->rating_image_1}}" alt="">
                                    </div>
                                    <div id="porofile1">
                                        <img src="assets/public-site/asset/img/{{$home->rating_image_2}}" alt="">
                                    </div>
                                    <div id="porofile2">
                                        <img src="assets/public-site/asset/img/{{$home->rating_image_3}}" alt="">
                                    </div>
                                    <div id="porofile3">
                                        <img src="assets/public-site/asset/img/{{$home->rating_image_4}}" alt="">
                                    </div>
                                    <div id="porofile4">
                                        <img src="assets/public-site/asset/img/{{$home->rating_image_5}}" alt="">
                                    </div>
                                    <div id="porofile5">
                                        <img src="assets/public-site/asset/img/{{$home->rating_image_6}}" alt="">
                                        {{-- <i class="fa-solid fa-plus"></i> --}}
                                    </div>

                                </div>
                                <h3>
                                    {{$home->rating_heading}}
                                </h3>
                                <div class="rate">
                                    <span>{{$home->rating_stars}}.0</span>
                                    <img src="assets/public-site/asset/img/main-rating-star.png" alt="">
                                </div>
                                <div class="heart-Hero">
                                    <i class="fa-solid fa-heart"></i>
                                </div>
                            </div>

                        @endif

                        <div class="Hero-image-label2">
                            <p class="label-text2">Find Here</p>
                        </div>
                        <div class="Hero-img-label">
                            <img class="label-img" src="assets/public-site/asset/img/Hero-image-label.png" alt="">
                            <p class="label-text">All Services</p>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- =========================================== HERO SECTION END HERE ================================================= -->

<!-- ========================= COUNTER SECTION START HERE ========================================= -->
<div class="conatiner-fluid counter-sec">
    <div class="container">
        @if ($home)

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="count-up">
                        <center>
                            <p class="counter-count">{{$home->counter_number_1}}</p><span>+</span>
                        </center>
                        <h3>{{$home->counter_heading_1}}</h3>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="count-up">
                        <center>
                            <p class="counter-count">{{$home->counter_number_2}}</p><span>+</span>
                        </center>
                        <h3>{{$home->counter_heading_2}}</h3>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="count-up">
                        <center>
                            <p class="counter-count">{{$home->counter_number_3}}</p><span>+</span>
                        </center>
                        <h3>{{$home->counter_heading_3}}</h3>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="count-up">
                        <center>
                            <p class="counter-count">{{$home->counter_number_4}}</p><span>+</span>
                        </center>
                        <h3>{{$home->counter_heading_4}}</h3>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
<!-- ========================= COUNTER SECTION END HERE ========================================= -->

<!-- ========================  HOW IT WORK SECTION START HERE ======================================== -->
<div class="container-fluid work-sec">
    <div class="container">
        @if ($home)
            <div class="row">

                <h1 class="page-title">{{$home->work_heading}}</h1>
                <p class="page-title-2">{{$home->work_tagline}}</p>
                <div class="col-lg-4 col-md-6">
                    <div class="card card-top">
                        <img src="assets/public-site/asset/img/{{$home->work_image_1}}" alt="Skyscrapers"/>
                        <div class="card-body">
                            <h5 class="card-title">{{$home->work_heading_1}}</h5>
                            <p class="card-text">
                                {{$home->work_description_1}}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card card-top">
                        <img src="assets/public-site/asset/img/{{$home->work_image_2}}" alt="Los Angeles Skyscrapers"/>
                        <div class="card-body">
                            <h5 class="card-title">{{$home->work_heading_2}}</h5>
                            <p class="card-text">{{$home->work_description_2}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card card-top">
                        <img src="assets/public-site/asset/img/{{$home->work_image_3}}" alt="Palm Springs Road"/>
                        <div class="card-body">
                            <h5 class="card-title">{{$home->work_heading_3}}</h5>
                            <p class="card-text">
                                {{$home->work_description_3}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
<!--  ========================  HOW IT WORK SECTION END HERE ======================================== -->

<!-- ========================  CATEGORIES SECTION START HERE ======================================== -->
<div class="container-fluid category-sec">
    <div class="container">
        @if ($home)

            <div class="row">
                <h1 class="page-title">{{$home->category_heading}}</h1>
                <p class="page-title-2">{{$home->category_tagline}}</p>

                <form action="/seller-listing-service-search" method="GET" id="cate_search_form"> @csrf

                    <input type="hidden" name="keyword" value="">
                    <input type="hidden" name="category_type" value="Category">
                    <input type="hidden" name="category_service" id="cate_service_1">
                </form>
                <div class="col-lg-3 col-md-6">
                    <a onclick="SearchCate(this.id)" id="search_cate_1" data-cate="{{$home->category_name_1}}"
                       style="cursor: pointer">
                        <div class="card text-white">
                            <img src="assets/public-site/asset/img/{{$home->category_image_1}}" class="card-img">
                            <div class="card-img-overlay">
                                <h5>{{$home->category_name_1}}</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-6">
                    <a onclick="SearchCate(this.id)" id="search_cate_2" data-cate="{{$home->category_name_2}}"
                       style="cursor: pointer">
                        <div class="card text-white">
                            <img src="assets/public-site/asset/img/{{$home->category_image_2}}" class="card-img">
                            <div class="card-img-overlay">
                                <h5>{{$home->category_name_2}}</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-6">
                    <a onclick="SearchCate(this.id)" id="search_cate_3" data-cate="{{$home->category_name_3}}"
                       style="cursor: pointer">
                        <div class="card text-white">
                            <img src="assets/public-site/asset/img/{{$home->category_image_3}}" class="card-img">
                            <div class="card-img-overlay">
                                <h5>{{$home->category_name_3}}</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-6">
                    <a onclick="SearchCate(this.id)" id="search_cate_4" data-cate="{{$home->category_name_4}}"
                       style="cursor: pointer">
                        <div class="card text-white">
                            <img src="assets/public-site/asset/img/{{$home->category_image_4}}" class="card-img">
                            <div class="card-img-overlay">
                                <h5>{{$home->category_name_4}}</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-6">
                    <a onclick="SearchCate(this.id)" id="search_cate_5" data-cate="{{$home->category_name_5}}"
                       style="cursor: pointer">
                        <div class="card text-white">
                            <img src="assets/public-site/asset/img/{{$home->category_image_5}}" class="card-img">
                            <div class="card-img-overlay">
                                <h5>{{$home->category_name_5}}</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-6">
                    <a onclick="SearchCate(this.id)" id="search_cate_6" data-cate="{{$home->category_name_6}}"
                       style="cursor: pointer">
                        <div class="card text-white">
                            <img src="assets/public-site/asset/img/{{$home->category_image_6}}" class="card-img">
                            <div class="card-img-overlay">
                                <h5>{{$home->category_name_6}}</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-6">
                    <a onclick="SearchCate(this.id)" id="search_cate_7" data-cate="{{$home->category_name_7}}"
                       style="cursor: pointer">
                        <div class="card text-white">
                            <img src="assets/public-site/asset/img/{{$home->category_image_7}}" class="card-img">
                            <div class="card-img-overlay">
                                <h5>{{$home->category_name_7}}</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-6">
                    <a onclick="SearchCate(this.id)" id="search_cate_8" data-cate="{{$home->category_name_8}}"
                       style="cursor: pointer">
                        <div class="card text-white">
                            <img src="assets/public-site/asset/img/{{$home->category_image_8}}" class="card-img">
                            <div class="card-img-overlay">
                                <h5>{{$home->category_name_8}}</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- ======================= VIEW ALL BTN START HERE ================ -->
                <div class="row">
                    <div class="col-md-12">
                        <center>
                            <a href="/seller-listing" class="btn veiwbtn">View All</a>
                        </center>
                    </div>
                </div>
                <!-- ======================= VIEW ALL BTN END HERE ================ -->
            </div>
        @endif
    </div>
</div>
<!--  ========================  CATEGORIES SECTION END HERE ======================================== -->

<!-- ========================  OUR EXPERTS SECTION START HERE ======================================== -->
<div class="container-fluid expert-sec">
    <div class="container">
        @if ($home)

            <div class="row">
                <h1 class="page-title">{{$home->expert_heading}}</h1>
                <p class="page-title-2">{{$home->expert_tagline}}</p>
            </div>
            <!-- CARD SECTION START HERE -->
            <div class="row">

                @for ($i = 1; $i <= 8; $i++)
                    @if (${'gig_' . $i})
                        @php
                            $item = ${'gig_' . $i} ;
                            $user = ${'profile_' . $i} ;
                            if ($user->show_full_name){
                                $full_name = $user->first_name . ' ' . $user->last_name;
                            }else{
                                 $full_name = $user->first_name . '' . strtoupper(substr($user->last_name, 0, 1));
                            }
                            $firstLetter = strtoupper(substr($user->first_name, 0, 1));
                        @endphp
                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                            <div class="main-Dream-card">
                                <div class="card dream-Card">
                                    <div class="dream-card-upper-section">
                                        <div style="height: 180px;">
                                            @if (Str::endsWith($item->main_file, ['.mp4', '.avi', '.mov', '.webm']))
                                                <!-- Video Player -->
                                                <video autoplay loop muted style="height: 100%; width: 100%;">
                                                    <source
                                                        src="assets/teacher/listing/data_{{ $item->user_id }}/media/{{$item->main_file}}"
                                                        type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @elseif (Str::endsWith($item->main_file, ['.jpg', '.jpeg', '.png', '.gif']))
                                                <!-- Image Display -->
                                                <img
                                                    src="assets/teacher/listing/data_{{ $item->user_id }}/media/{{$item->main_file}}"
                                                    style="height: 100%;" alt="Uploaded Image">
                                            @endif
                                        </div>
                                        <div class="card-img-overlay overlay-inner">
                                            <p>
                                                Top Seller
                                            </p>
                                            @if (Auth::user())
                                                @php  $wishList = \App\Models\WishList::where(['user_id'=>Auth::user()->id,'gig_id'=>$item->id])->first(); @endphp
                                                @if ($wishList)
                                                    <span id="heart_{{$item->id}}" class="liked"
                                                          onclick="AddWishList(this.id);" data-gig_id="{{$item->id}}">
                                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                                    </span>
                                                @else
                                                    <span id="heart_{{$item->id}}" onclick="AddWishList(this.id);"
                                                          data-gig_id="{{$item->id}}">
                                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    <a href="#" style="text-decoration: none;">
                                        {{-- <div class="dream-card-dawon-section" type="button" data-bs-toggle="offcanvas" data-bs-target="#online-person" aria-controls="offcanvasRight"> --}}
                                        <div class="dream-card-dawon-section" type="button" data-bs-toggle="offcanvas"
                                             aria-controls="offcanvasRight">
                                            <div class="dream-Card-inner-profile">
                                                @if ($user->profile_image == null)
                                                    <img src="assets/profile/avatars/({{$firstLetter}}).jpg" alt=""
                                                         style="width: 60px;height: 60px; border-radius: 100%; border: 5px solid white;">
                                                @else
                                                    <img src="assets/profile/img/{{$user->profile_image}}" alt=""
                                                         style="width: 60px;height: 60px; border-radius: 100%;border: 5px solid white;">

                                                @endif

                                                <i class="fa-solid fa-check tick"></i>
                                            </div>
                                            <p class="servise-bener">{{$item->service_type}} Services</p>
                                            <h5 class="dream-Card-name">
                                                {{$full_name}}.
                                            </h5>
                                            <p class="Dev">{{$user->profession}}</p>
                                            @if ($item->service_role == 'Class')
                                                @if ($item->class_type == 'Recorded')
                                                    <p class="about-teaching"><a class="about-teaching"
                                                                                 href="/course-service/{{$item->id}}"
                                                                                 style="text-decoration: none;">{{$item->title}}</a>
                                                    </p>
                                                @else
                                                    <p class="about-teaching"><a class="about-teaching"
                                                                                 href="/quick-booking/{{$item->id}}"
                                                                                 style="text-decoration: none;">{{$item->title}}</a>
                                                    </p>
                                                @endif
                                            @else
                                                <p class="about-teaching"><a class="about-teaching"
                                                                             href="/quick-booking/{{$item->id}}"
                                                                             style="text-decoration: none;">{{$item->title}}</a>
                                                </p>
                                            @endif

                                            {{-- <p class="about-teaching" >{{$item->title}}</p> --}}
                                            <span class="card-rat">
                                            <i class="fa-solid fa-star"></i> &nbsp; (5.0)
                                        </span>
                                            <div class="card-last">
                                                @php   $rate = explode('|*|',$item->rate)  @endphp
                                                <span>Starting at ${{$rate[0]}}</span>
                                                <!-- word img -->
                                                @if ($item->service_type == 'Online')
                                                    <img data-toggle="tooltip" title="Online-Service"
                                                         src="assets/seller-listing/asset/img/globe.png"
                                                         style="height: 25px; width: 25px;" alt="">

                                                @else
                                                    <a>
                                                        <svg data-toggle="tooltip" title="In Person-Service"
                                                             xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                             color="#0072b1" fill="currentColor"
                                                             class="bi bi-house  fa-house" viewBox="0 0 16 16">
                                                            <path
                                                                d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
                                                        </svg>
                                                        {{-- <i  data-toggle="tooltip" title="In Person-Service" class="fa-solid fa-house"></i> --}}
                                                    </a>
                                                @endif
                                                <!-- <i class="fa-solid fa-globe"></i> -->
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                    @else

                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                            <div class="main-Dream-card">
                                <div class="card dream-Card"
                                     style="height: 410px;justify-content: center;align-items: center; ">
                                    <h1 style="font-weight: bolder;color: rgb(24 24 24 / 31%);">Not Found</h1>
                                </div>
                            </div>
                        </div>

                    @endif
                @endfor


                {{-- <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                    <div class="main-Dream-card">
                        <div class="card dream-Card">
                            <div class="dream-card-upper-section">
                                <img src="assets/public-site/asset/img/card-main-img.png" alt="">
                                <div class="card-img-overlay overlay-inner">
                                    <p>
                                        Top Seller
                                    </p>
                                    <span id=heart>
                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="dream-card-dawon-section">
                                <div class="dream-Card-inner-profile">
                                    <img src="assets/public-site/asset/img/inner-profile.png" alt="">
                                    <i class="fa-solid fa-check tick"></i>
                                </div>
                                <p class="servise-bener">Online Services</p>
                                <h5 class="dream-Card-name">
                                    Usama A.
                                </h5>
                                <p class="Dev">Developer</p>
                                <a href="{{$home->expert_link_1}}" target="__" style="text-decoration: none;">
                                <p class="about-teaching">I will teach you how to build an amazing website</p></a>
                                <span class="card-rat">
                                    <i class="fa-solid fa-star"></i> &nbsp; (5.0)
                                </span>
                                <div class="card-last">
                                    <span>Starting at $5</span>
                                    <!-- word img -->

                                    <a href="#"><img data-toggle="tooltip" title="In Person-Service" src="assets/public-site/asset/img/globe.png" style="height: 25px; width: 25px;" alt=""></a>
                                    <!-- <i class="fa-solid fa-globe"></i> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}


            </div>
        @endif
        <!-- CARD SECTION END HERE -->

        <!-- ======================= VIEW ALL BTN START HERE ================ -->
        <div class="row">
            <div class="col-md-12">
                <center>
                    <a href="/seller-listing" class="btn veiwbtn">View All</a>
                </center>
            </div>
        </div>
        <!-- ======================= VIEW ALL BTN END HERE ================ -->

    </div>
</div>
<!-- =========================== MBL SCREEN SLIDER START HERE =================================== -->
<div class="container-fluid expert-sec mbl-expert-sec">
    <div class="container">
        <div class="row">
            <h1 class="page-title">Our Experts</h1>
            <p class="page-title-2">Explore Industry Experts Around the World</p>
        </div>
        <!-- ========= SLIDER START HERE =========== -->
        <div class="home-demo">
            <div class="owl-carousel owl-theme">
                <div class="item">
                    <div class="main-Dream-card">
                        <div class="card dream-Card">
                            <div class="dream-card-upper-section">
                                <img src="assets/public-site/asset/img/card-main-img.png" alt="">
                                <div class="card-img-overlay overlay-inner">
                                    <p>
                                        Top Seller
                                    </p>
                                    <span id="heart12">
                                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                                        </span>
                                </div>
                            </div>
                            <div class="dream-card-dawon-section">
                                <div class="dream-Card-inner-profile">
                                    <img src="assets/public-site/asset/img/inner-profile.png" alt="">
                                    <i class="fa-solid fa-check tick"></i>
                                </div>
                                <p class="servise-bener">Online Services</p>
                                <h5 class="dream-Card-name">
                                    Usama A.
                                </h5>
                                <p class="Dev">Developer</p>
                                <p class="about-teaching">I will teach you how to build an amazing website</p>
                                <span class="card-rat">
                                        <i class="fa-solid fa-star"></i> &nbsp; (5.0)
                                    </span>
                                <div class="card-last">
                                    <span>Starting at $5</span>
                                    <!-- word img -->
                                    <a href="#"><img data-toggle="tooltip" title="In Person-Service"
                                                     src="assets/public-site/asset/img/globe.png"
                                                     style="height: 25px; width: 25px;" alt=""></a>
                                    <!-- <i class="fa-solid fa-globe"></i> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ======================= VIEW ALL BTN START HERE ================ -->
        <div class="row">
            <div class="col-md-12">
                <center>
                    <a href="/seller-listing" class="btn veiwbtn">View All</a>
                </center>
            </div>
        </div>
        <!-- ======================= VIEW ALL BTN END HERE ================ -->

    </div>
</div>
<!-- =========================== MBL SCREEN SLIDER START HERE =================================== -->
<!--  ========================  OUR EXPRETS SECTION END HERE ======================================== -->

<!--  ========================  MEET CREATORS SECTION START HERE ======================================== -->
<div class="container-fluid meetcreator-sec">
    <div class="container">
        @if ($home2)

            <div class="row">
                <div class="col-lg-8 col-md-12 meet-textsec">
                    <h1>{{$home2->banner_1_heading}}</h1>
                    <p>{{$home2->banner_1_description}}</p>
                    <div class="meetcreator-btn">
                        <a href="{{$home2->banner_1_btn1_link}}" target="__">

                            <button type="button" class="btn freelance-btn">{{$home2->banner_1_btn1_name}}</button>
                        </a>
                        <a href="{{$home2->banner_1_btn2_link}}" target="__">

                            <button type="button" class="btn online-btn">{{$home2->banner_1_btn2_name}}</button>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <!-- <div class="owl-carousel owl-theme">
                    <div class="meetcreator-imgsec">
                        <img src="assets/public-site/asset/img/meetcreator.png" alt="">
                    </div>
                </div> -->
                    <div class="border-background">
                        <div class="slider">
                            <div class="slides">
                                <div class="slide"><img src="assets/public-site/asset/img/{{$home2->banner_1_image}}"
                                                        alt="Slide 1"></div>
                                <div class="slide"><img src="assets/public-site/asset/img/{{$home2->banner_1_image}}"
                                                        alt="Slide 2"></div>
                                <div class="slide"><img src="assets/public-site/asset/img/{{$home2->banner_1_image}}"
                                                        alt="Slide 3"></div>
                                <!-- Add more slides as needed -->
                            </div>
                        </div>
                    </div>
                    <div class="dots">
                        <span class="dot" onclick="currentSlide(1)"></span>
                        <span class="dot" onclick="currentSlide(2)"></span>
                        <span class="dot" onclick="currentSlide(3)"></span>
                        <!-- Add more dots as needed -->
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
<!--  ========================  MEET CREATORS SECTION END HERE ======================================== -->

<!-- ========================  TRENDY SERVICES SECTION START HERE ======================================== -->
<div class="container-fluid trending-sec">
    <div class="container">
        @if ($home2)

            <div class="row">
                <h1 class="page-title">{{$home2->service_heading}}</h1>
                <p class="page-title-2">{{$home2->service_tagline}}</p>
            </div>
            <!-- CARD SECTION START HERE -->
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                    <div class="main-Dream-card">
                        <div class="card dream-Card">
                            <div class="dream-card-upper-section">
                                <img src="assets/public-site/asset/img/card-main-img.png" alt="">
                                <div class="card-img-overlay overlay-inner">
                                    <p>
                                        Top Seller
                                    </p>
                                    <span id=heart8>
                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="dream-card-dawon-section">
                                <div class="dream-Card-inner-profile">
                                    <img src="assets/public-site/asset/img/inner-profile.png" alt="">
                                    <i class="fa-solid fa-check tick"></i>
                                </div>
                                <p class="servise-bener">Online Services</p>
                                <h5 class="dream-Card-name">
                                    Usama A.
                                </h5>
                                <p class="Dev">Developer</p>
                                <a href="{{$home2->service_link_1}}" target="__" style="text-decoration: none;">
                                    <p class="about-teaching">I will teach you how to build an amazing website</p></a>
                                <span class="card-rat">
                                    <i class="fa-solid fa-star"></i> &nbsp; (5.0)
                                </span>
                                <div class="card-last">
                                    <span>Starting at $5</span>
                                    <!-- word img -->

                                    <a href="#"><img data-toggle="tooltip" title="In Person-Service"
                                                     src="assets/public-site/asset/img/globe.png"
                                                     style="height: 25px; width: 25px;" alt=""></a>
                                    <!-- <i class="fa-solid fa-globe"></i> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                    <div class="main-Dream-card">
                        <div class="card dream-Card">
                            <div class="dream-card-upper-section">
                                <img src="assets/public-site/asset/img/card-main-img.png" alt="">
                                <div class="card-img-overlay overlay-inner">
                                    <p>
                                        Top Seller
                                    </p>
                                    <span id=heart9>
                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="dream-card-dawon-section">
                                <div class="dream-Card-inner-profile">
                                    <img src="assets/public-site/asset/img/inner-profile.png" alt="">
                                    <i class="fa-solid fa-check tick"></i>
                                </div>
                                <p class="servise-bener">In-Person Services</p>
                                <h5 class="dream-Card-name">
                                    Usama A.
                                </h5>
                                <p class="Dev">Developer</p>
                                <a href="{{$home2->service_link_2}}" target="__" style="text-decoration: none;">
                                    <p class="about-teaching">I will teach you how to build an amazing website</p></a>
                                <span class="card-rat">
                                    <i class="fa-solid fa-star"></i> &nbsp; (5.0)
                                </span>
                                <div class="card-last">
                                    <span>Starting at $5</span>
                                    <!-- word img -->
                                    <a>
                                        <svg data-toggle="tooltip" title="In Person-Service"
                                             xmlns="http://www.w3.org/2000/svg" width="24" height="24" color="#0072b1"
                                             fill="currentColor" class="bi bi-house  fa-house" viewBox="0 0 16 16">
                                            <path
                                                d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
                                        </svg>
                                        {{-- <i  data-toggle="tooltip" title="In Person-Service" class="fa-solid fa-house"></i> --}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                    <div class="main-Dream-card">
                        <div class="card dream-Card">
                            <div class="dream-card-upper-section">
                                <img src="assets/public-site/asset/img/card-main-img.png" alt="">
                                <div class="card-img-overlay overlay-inner">
                                    <p>
                                        Top Seller
                                    </p>
                                    <span id=heart10>
                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="dream-card-dawon-section">
                                <div class="dream-Card-inner-profile">
                                    <img src="assets/public-site/asset/img/inner-profile.png" alt="">
                                    <i class="fa-solid fa-check tick"></i>
                                </div>
                                <p class="servise-bener">Online Services</p>
                                <h5 class="dream-Card-name">
                                    Usama A.
                                </h5>
                                <p class="Dev">Developer</p>
                                <a href="{{$home2->service_link_3}}" target="__" style="text-decoration: none;">
                                    <p class="about-teaching">I will teach you how to build an amazing website</p></a>
                                <span class="card-rat">
                                    <i class="fa-solid fa-star"></i> &nbsp; (5.0)
                                </span>
                                <div class="card-last">
                                    <span>Starting at $5</span>
                                    <!-- word img -->
                                    <a href="#"><img data-toggle="tooltip" title="In Person-Service"
                                                     src="assets/public-site/asset/img/globe.png"
                                                     style="height: 25px; width: 25px;" alt=""></a>
                                    <!-- <i class="fa-solid fa-globe"></i> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                    <div class="main-Dream-card">
                        <div class="card dream-Card">
                            <div class="dream-card-upper-section">
                                <img src="assets/public-site/asset/img/card-main-img.png" alt="">
                                <div class="card-img-overlay overlay-inner">
                                    <p>
                                        Top Seller
                                    </p>
                                    <span id=heart11>
                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="dream-card-dawon-section">
                                <div class="dream-Card-inner-profile">
                                    <img src="assets/public-site/asset/img/inner-profile.png" alt="">
                                    <i class="fa-solid fa-check tick"></i>
                                </div>
                                <p class="servise-bener">In-Person Services</p>
                                <h5 class="dream-Card-name">
                                    Usama A.
                                </h5>
                                <p class="Dev">Developer</p>
                                <a href="{{$home2->service_link_4}}" target="__" style="text-decoration: none;">
                                    <p class="about-teaching">I will teach you how to build an amazing website</p></a>
                                <span class="card-rat">
                                    <i class="fa-solid fa-star"></i> &nbsp; (5.0)
                                </span>
                                <div class="card-last">
                                    <span>Starting at $5</span>
                                    <!-- word img -->
                                    <a>
                                        <svg data-toggle="tooltip" title="In Person-Service"
                                             xmlns="http://www.w3.org/2000/svg" width="24" height="24" color="#0072b1"
                                             fill="currentColor" class="bi bi-house  fa-house" viewBox="0 0 16 16">
                                            <path
                                                d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
                                        </svg>
                                        {{-- <i  data-toggle="tooltip" title="In Person-Service" class="fa-solid fa-house"></i> --}}
                                    </a>
                                    <!-- <i class="fa-solid fa-globe"></i> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- CARD SECTION END HERE -->

        <!-- ======================= VIEW ALL BTN START HERE ================ -->
        <div class="row">
            <div class="col-md-12">
                <center>
                    <a href="/seller-listing" class="btn veiwbtn">View All</a>
                </center>
            </div>
        </div>
        <!-- ======================= VIEW ALL BTN END HERE ================ -->
    </div>
</div>

<!-- ============================ MBL TRENDING SECTION START HERE =========================== -->

<div class="container-fluid trending-sec mbl-trending-sec">
    <div class="container">
        @if ($home2)

            <div class="row">
                <h1 class="page-title">{{$home2->service_heading}}</h1>
                <p class="page-title-2">{{$home2->service_tag_line}}</p>
            </div>
            <!-- ========= SLIDER START HERE =========== -->
            <div class="home-demo">
                <div class="owl-carousel owl-theme">
                    <div class="item">
                        <div class="main-Dream-card">
                            <div class="card dream-Card">
                                <div class="dream-card-upper-section">
                                    <img src="assets/public-site/asset/img/card-main-img.png" alt="">
                                    <div class="card-img-overlay overlay-inner">
                                        <p>
                                            Top Seller
                                        </p>
                                        <span id="heart13">
                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                    </span>
                                    </div>
                                </div>
                                <div class="dream-card-dawon-section">
                                    <div class="dream-Card-inner-profile">
                                        <img src="assets/public-site/asset/img/inner-profile.png" alt="">
                                        <i class="fa-solid fa-check tick"></i>
                                    </div>
                                    <p class="servise-bener">Online Services</p>
                                    <h5 class="dream-Card-name">
                                        Usama A.
                                    </h5>
                                    <p class="Dev">Developer</p>
                                    <a href="{{$home2->service_link_1}}" target="__" style="text-decoration: none;">
                                        <p class="about-teaching">I will teach you how to build an amazing website</p>
                                    </a>
                                    <span class="card-rat">
                                    <i class="fa-solid fa-star"></i> &nbsp; (5.0)
                                </span>
                                    <div class="card-last">
                                        <span>Starting at $5</span>
                                        <!-- word img -->
                                        <a href="#"><img data-toggle="tooltip" title="In Person-Service"
                                                         src="assets/public-site/asset/img/globe.png"
                                                         style="height: 25px; width: 25px;" alt=""></a>
                                        <!-- <i class="fa-solid fa-globe"></i> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- ======================= VIEW ALL BTN START HERE ================ -->
        <div class="row">
            <div class="col-md-12">
                <center>
                    <button href="/seller-listing" class="btn veiwbtn">View All</button>
                </center>
            </div>
        </div>
        <!-- ======================= VIEW ALL BTN END HERE ================ -->
    </div>
</div>
<!-- ============================ MBL TRENDING SECTION END  HERE =========================== -->


<!--  ========================  TRENDY SERVICES SECTION END HERE ======================================== -->

<!--  ========================  MEET CREATORS SECTION START HERE ======================================== -->
<div class="container-fluid meetcreator-sec live-sec">
    <div class="container">
        @if ($home2)

            <div class="row">
                <div class="col-lg-8 col-md-12 meet-textsec">
                    <h1>{{$home2->banner_2_heading}}</h1>
                    <p>{{$home2->banner_2_description}}</p>
                    <div class="checkbox-section">
                        <label for="accented-dark">

                            <i class="fa-solid fa-square-check"></i>
                            Laptop / Dasktop
                        </label>
                        <label for="accented-dark">

                            <i class="fa-solid fa-square-check"></i>
                            Table
                        </label>
                        <label for="accented-dark">

                            <i class="fa-solid fa-square-check"></i>
                            Smart TV
                        </label>
                        <label for="accented-dark">

                            <i class="fa-solid fa-square-check"></i>
                            Mobile
                        </label>
                    </div>

                    <div class="meetcreator-btn">

                        <a href="{{$home2->banner_2_btn1_link}}" target="__">
                            <button type="button" class="btn freelance-btn">{{$home2->banner_2_btn1_name}} <i
                                    class="fa-solid fa-arrow-right"></i></button>
                        </a>


                        <a href="{{$home2->banner_2_btn2_link}}" target="__">
                            <button type="button" class="btn freelance-btn">{{$home2->banner_2_btn2_name}} <i
                                    class="fa-solid fa-arrow-right"></i></button>
                        </a>

                    </div>

                </div>
                <div class="col-lg-4 col-md-12">
                    <img src="assets/public-site/asset/img/{{$home2->banner_2_image}}" width="100%">
                </div>
            </div>
        @endif
    </div>
</div>
<!--  ========================  MEET CREATORS SECTION END HERE ======================================== -->

<!-- =========================== BUYER REVIEWS SECTION START HERE ======================================== -->
<div class="container-fluid card_wrapper">
    <div class="container">
        @if ($home2)

            <div class="row">
                <div class="col-12">
                    <h1 class="page-title">{{$home2->review_heading}}</h1>
                    <p class="page-title-2">{{$home2->review_tagline}}</p>
                    <div class="owl-carousel card_carousel">
                        <div class="card card-slider">
                            <div class="card-body">
                                <div class="d-flex"><img src="assets/public-site/asset/img/{{$home2->review_image_1}}"
                                                         class="rounded-circle">
                                    <div class="d-flex flex-column">
                                        <div class="name">{{$home2->review_name_1}}</div>
                                        <p class="text-muted">{{$home2->review_designation_1}}</p>
                                    </div>
                                </div>
                                <p class="card-text">{{$home2->review_review_1}}</p>
                            </div>
                        </div>
                        <div class="card card-slider">
                            <div class="card-body">
                                <div class="d-flex"><img src="assets/public-site/asset/img/{{$home2->review_image_2}}"
                                                         class="rounded-circle">
                                    <div class="d-flex flex-column">
                                        <div class="name">{{$home2->review_name_2}}</div>
                                        <p class="text-muted">{{$home2->review_designation_2}}</p>
                                    </div>
                                </div>
                                <p class="card-text">{{$home2->review_review_2}} </p>
                            </div>
                        </div>
                        <div class="card  card-slider">
                            <div class="card-body">
                                <div class="d-flex"><img src="assets/public-site/asset/img/{{$home2->review_image_3}}"
                                                         class="rounded-circle">
                                    <div class="d-flex flex-column">
                                        <div class="name">{{$home2->review_name_3}}</div>
                                        <p class="text-muted">{{$home2->review_designation_3}}</p>
                                    </div>
                                </div>
                                <p class="card-text">{{$home2->review_review_3}} </p>
                            </div>
                        </div>
                        <div class="card  card-slider">
                            <div class="card-body">
                                <div class="d-flex"><img src="assets/public-site/asset/img/{{$home2->review_image_4}}"
                                                         class="rounded-circle">
                                    <div class="d-flex flex-column">
                                        <div class="name">{{$home2->review_name_4}}</div>
                                        <p class="text-muted">{{$home2->review_designation_4}}</p>
                                    </div>
                                </div>
                                <p class="card-text">{{$home2->review_review_4}} </p>
                            </div>
                        </div>


                        {{-- <div class="card  card-slider">
                            <div class="card-body">
                                <div class="d-flex"><img src="assets/public-site/asset/img/slidercommentimg1.png" class="rounded-circle">
                                    <div class="d-flex flex-column">
                                        <div class="name">Thomas H.</div>
                                        <p class="text-muted">Student</p>
                                    </div>
                                </div>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent ullamcorper nisl eu accumsan.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent
                                    ullamcorper nisl eu accumsan. </p>
                            </div>
                        </div>
                        <div class="card  card-slider">
                            <div class="card-body">
                                <div class="d-flex"><img src="assets/public-site/asset/img/IMG1.png" class="rounded-circle">
                                    <div class="d-flex flex-column">
                                        <div class="name">Thomas H.</div>
                                        <p class="text-muted">Student</p>
                                    </div>
                                </div>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent ullamcorper nisl eu accumsan.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent
                                    ullamcorper nisl eu accumsan. </p>
                            </div>
                        </div>
                        <div class="card  card-slider">
                            <div class="card-body">
                                <div class="d-flex"><img src="assets/public-site/asset/img/slidercommentimg1.png" class="rounded-circle">
                                    <div class="d-flex flex-column">
                                        <div class="name">Thomas H.</div>
                                        <p class="text-muted">Student</p>
                                    </div>
                                </div>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent ullamcorper nisl eu accumsan.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent
                                    ullamcorper nisl eu accumsan. </p>
                            </div>
                        </div>
                        <div class="card  card-slider">
                            <div class="card-body">
                                <div class="d-flex"><img src="assets/public-site/asset/img/IMG1.png" class="rounded-circle">
                                    <div class="d-flex flex-column">
                                        <div class="name">Thomas H.</div>
                                        <p class="text-muted">Student</p>
                                    </div>
                                </div>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent ullamcorper nisl eu accumsan.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet sollicitudin tristique ac praesent
                                    ullamcorper nisl eu accumsan. </p>
                            </div>
                        </div> --}}


                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
<!-- =========================== BUYER REVIEWS SECTION END HERE ========================================== -->

<!-- ============================= FOOTER SECTION START HERE ===================================== -->
<x-public-footer/>
<!-- =============================== FOOTER SECTION END HERE ===================================== -->

<script src="assets/public-site/libs/jquery/jquery.js"></script>
<script src="assets/public-site/libs/datatable/js/datatable.js"></script>
<script src="assets/public-site/libs/datatable/js/datatablebootstrap.js"></script>
<script src="assets/public-site/libs/select2/js/select2.min.js"></script>
<!-- <script src="libs/owl-carousel/js/jquery.min.js"></script> -->
<script src="assets/public-site/libs/owl-carousel/js/owl.carousel.min.js"></script>
<script src="assets/public-site/libs/aos/js/aos.js"></script>
<script src="assets/public-site/asset/js/bootstrap.min.js"></script>
<script src="assets/public-site/asset/js/script.js"></script>
</body>

</html>


{{-- Add to Wish List Set Script Start ==== --}}
<script>
    function AddWishList(Clicked) {
        var gig_id = $('#' + Clicked).data('gig_id');
        var type = $('#' + Clicked).data('type');
        console.log(type);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: '/add-service-to-wishlist',
            data: {gig_id: gig_id, type: type, _token: '{{csrf_token()}}'},
            dataType: 'json',
            success: function (response) {
                if (response.success) {

                    $('#' + Clicked).addClass('liked');
                    $('#' + Clicked).html('<i class="fa fa-heart" aria-hidden="true"></i>');


                    toastr.options =
                        {
                            "closeButton": true,
                            "progressBar": true,
                            "timeOut": "10000", // 10 seconds
                            "extendedTimeOut": "4410000" // 10 seconds
                        }
                    toastr.success(response.success);
                } else if (response.info) {

                    $('#' + Clicked).removeClass('liked');
                    $('#' + Clicked).html('<i class="fa fa-heart-o" aria-hidden="true"></i>');

                    toastr.options =
                        {
                            "closeButton": true,
                            "progressBar": true,
                            "timeOut": "10000", // 10 seconds
                            "extendedTimeOut": "4410000" // 10 seconds
                        }
                    toastr.info(response.info);
                } else {
                    toastr.options =
                        {
                            "closeButton": true,
                            "progressBar": true,
                            "timeOut": "10000", // 10 seconds
                            "extendedTimeOut": "4410000" // 10 seconds
                        }
                    toastr.error(response.error);
                }
            },

        });

    }
</script>
{{-- Add to Wish List Set Script END ==== --}}

{{-- Keyword Suggession --}}

<script>
    const searchInputMain = document.getElementById('keyword_main');
    const suggestionsBoxMain = document.getElementById('suggestions_main');

    searchInputMain.addEventListener('keyup', function () {
        const query = this.value.trim();


        if (query) {

            fetch(`/keywords?keyword=${query}`)
                .then(response => response.json())
                .then(keywords => {
                    suggestionsBoxMain.innerHTML = '';
                    if (keywords.length > 0) {
                        keywords.forEach(keyword => {

                            const div = document.createElement('div');
                            div.textContent = keyword;
                            div.onclick = function () {
                                searchInputMain.value = keyword;
                                suggestionsBoxMain.style.display = 'none';
                            };
                            suggestionsBoxMain.appendChild(div);
                        });
                        suggestionsBoxMain.style.display = 'block';
                    } else {
                        suggestionsBoxMain.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error fetching keywords:', error));
        } else {
            suggestionsBoxMain.style.display = 'none';
        }
    });

    document.addEventListener('click', function (event) {
        if (!event.target.closest('.search-container-main')) {
            suggestionsBoxMain.style.display = 'none';
        }
    });
</script>

{{-- Search Category Form Submit Script Start=== --}}
<script>
    function SearchCate(Clicked) {
        var category = $('#' + Clicked).data("cate");

        $('#cate_service_1').val(category);


        $('#cate_search_form').submit();

    }
</script>
{{-- Search Category Form Submit Script END=== --}}
<!-- login signup script in jquery-->
<script>

</script>
<script>
    // 1
    $(document).ready(function () {
        $("#heart").click(function () {
            if ($("#heart").hasClass("liked")) {
                $("#heart").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
                $("#heart").removeClass("liked");
            } else {
                $("#heart").html('<i class="fa fa-heart" aria-hidden="true"></i>');
                $("#heart").addClass("liked");
            }
        });
    });
    // 2
    $(document).ready(function () {
        $("#heart1").click(function () {
            if ($("#heart1").hasClass("liked")) {
                $("#heart1").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
                $("#heart1").removeClass("liked");
            } else {
                $("#heart1").html('<i class="fa fa-heart" aria-hidden="true"></i>');
                $("#heart1").addClass("liked");
            }
        });
    });
    // 3
    $(document).ready(function () {
        $("#heart2").click(function () {
            if ($("#heart2").hasClass("liked")) {
                $("#heart2").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
                $("#heart2").removeClass("liked");
            } else {
                $("#heart2").html('<i class="fa fa-heart" aria-hidden="true"></i>');
                $("#heart2").addClass("liked");
            }
        });
    });
    // 4
    $(document).ready(function () {
        $("#heart3").click(function () {
            if ($("#heart3").hasClass("liked")) {
                $("#heart3").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
                $("#heart3").removeClass("liked");
            } else {
                $("#heart3").html('<i class="fa fa-heart" aria-hidden="true"></i>');
                $("#heart3").addClass("liked");
            }
        });
    });
    // 5
    $(document).ready(function () {
        $("#heart4").click(function () {
            if ($("#heart4").hasClass("liked")) {
                $("#heart4").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
                $("#heart4").removeClass("liked");
            } else {
                $("#heart4").html('<i class="fa fa-heart" aria-hidden="true"></i>');
                $("#heart4").addClass("liked");
            }
        });
    });
    // 6
    $(document).ready(function () {
        $("#heart5").click(function () {
            if ($("#heart5").hasClass("liked")) {
                $("#heart5").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
                $("#heart5").removeClass("liked");
            } else {
                $("#heart5").html('<i class="fa fa-heart" aria-hidden="true"></i>');
                $("#heart5").addClass("liked");
            }
        });
    });
    // 7
    $(document).ready(function () {
        $("#heart6").click(function () {
            if ($("#heart6").hasClass("liked")) {
                $("#heart6").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
                $("#heart6").removeClass("liked");
            } else {
                $("#heart6").html('<i class="fa fa-heart" aria-hidden="true"></i>');
                $("#heart6").addClass("liked");
            }
        });
    });
    // 8
    $(document).ready(function () {
        $("#heart7").click(function () {
            if ($("#heart7").hasClass("liked")) {
                $("#heart7").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
                $("#heart7").removeClass("liked");
            } else {
                $("#heart7").html('<i class="fa fa-heart" aria-hidden="true"></i>');
                $("#heart7").addClass("liked");
            }
        });
    });
    // 9
    $(document).ready(function () {
        $("#heart8").click(function () {
            if ($("#heart8").hasClass("liked")) {
                $("#heart8").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
                $("#heart8").removeClass("liked");
            } else {
                $("#heart8").html('<i class="fa fa-heart" aria-hidden="true"></i>');
                $("#heart8").addClass("liked");
            }
        });
    });
    // 10
    $(document).ready(function () {
        $("#heart9").click(function () {
            if ($("#heart9").hasClass("liked")) {
                $("#heart9").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
                $("#heart9").removeClass("liked");
            } else {
                $("#heart9").html('<i class="fa fa-heart" aria-hidden="true"></i>');
                $("#heart9").addClass("liked");
            }
        });
    });
    // 11
    $(document).ready(function () {
        $("#heart10").click(function () {
            if ($("#heart10").hasClass("liked")) {
                $("#heart10").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
                $("#heart10").removeClass("liked");
            } else {
                $("#heart10").html('<i class="fa fa-heart" aria-hidden="true"></i>');
                $("#heart10").addClass("liked");
            }
        });
    });
    // 12
    $(document).ready(function () {
        $("#heart11").click(function () {
            if ($("#heart11").hasClass("liked")) {
                $("#heart11").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
                $("#heart11").removeClass("liked");
            } else {
                $("#heart11").html('<i class="fa fa-heart" aria-hidden="true"></i>');
                $("#heart11").addClass("liked");
            }
        });
    });
    // ===========================
    // 13
    // $(document).ready(function() {
    //     $("#heart12").click(function() {
    //         if ($("#heart12").hasClass("liked")) {
    //             $("#heart12").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
    //             $("#heart12").removeClass("liked");
    //         } else {
    //             $("#heart12").html('<i class="fa fa-heart" aria-hidden="true"></i>');
    //             $("#heart12").addClass("liked");
    //         }
    //     });
    //      });
    // 14

</script>
<script>
    $(document).ready(function () {
        $("#heart12, #heart13").click(function () {
            var $icon = $(this).find('i');
            if ($icon.hasClass("fa-heart-o")) {
                $icon.removeClass("fa-heart-o").addClass("fa-heart");
            } else {
                $icon.removeClass("fa-heart").addClass("fa-heart-o");
            }
        });
    });
</script>
<script>

    $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 5
            }
        }
    })

</script>

<script>
    let currentIndex = 0;
    const slides = document.querySelector('.slides');
    const dots = document.querySelectorAll('.dot');

    function showSlide(index) {
        if (index >= dots.length) {
            currentIndex = 0;
        } else if (index < 0) {
            currentIndex = dots.length - 1;
        } else {
            currentIndex = index;
        }

        slides.style.transform = `translateX(${-currentIndex * 100}%)`;

        dots.forEach(dot => dot.classList.remove('active'));
        dots[currentIndex].classList.add('active');
    }

    function currentSlide(index) {
        showSlide(index - 1);
    }

    // Initialize the slider
    showSlide(0);
</script>
