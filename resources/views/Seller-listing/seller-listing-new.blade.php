<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <base href="/public">

    <!-- View Point scale to 1.0 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Listing</title>

    <!-- Animate css -->
    <link rel="stylesheet" href="assets/seller-listing-new/libs/animate/css/animate.css"/>

    <!-- AOS Animation css-->
    <link rel="stylesheet" href="assets/seller-listing-new/libs/aos/css/aos.css"/>

    <!-- Datatable css  -->

    <link rel="stylesheet" href="assets/seller-listing-new/libs/datatable/css/datatable.css"/>
    <!-- datetime picker css -->
    <link rel="stylesheet" href="assets/seller-listing-new/asset/jquery.datetimepicker.min.css">
    <!-- boxicon css link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Select2 css -->

    <link href="assets/seller-listing-new/libs/select2/css/select2.min.css" rel="stylesheet"/>

    <!-- Owl carousel css -->

    <link href="assets/seller-listing-new/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet"/>
    <link href="assets/seller-listing-new/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet"/>

    <!-- Bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- <link href="assets/seller-listing-new/asset/css/fontawesome.min.css" rel="stylesheet" type="text/css" /> --}}
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <!-- js -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- font awesome cdn -->
    <script src="https://kit.fontawesome.com/55bd3bbc70.js" crossorigin="anonymous"></script>
    {{-- Fav Icon --}}
    @php  $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
    @endif
    <!-- fancybox -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
    />
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    {{-- =======Toastr CDN ======== --}}
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- =======Toastr CDN ======== --}}
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/seller-listing-new/asset/css/seller-listing.css"/>
    <link rel="stylesheet" href="assets/seller-listing-new/asset/css/logedin_navbar.css">
    <!-- <link rel="stylesheet" href="assets/css/style.css"> -->
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.2.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>
    <link rel="stylesheet" href="assets/public-site/asset/css/Drop.css"/>
    <link rel="stylesheet" href="assets/public-site/asset/css/navbar.css">
</head>


<style>
    .flatpickr-calendar {
        display: none;
    }

    .page-item.active .page-link {
        border-radius: 4px;
        border: 1.5px solid #0072b1;
        background: #0072b1;
        color: #fff;
    }

    .hidden {
        display: none !important;
    }

</style>


<body>


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

<!-- =========================================== NAVBAR START HERE ================================================= -->
<!-- =========================================== NAVBAR START HERE ================================================= -->
<x-public-nav/>
<!-- ============================================= NAVBAR END HERE ============================================ -->
<!-- ============================================= NAVBAR END HERE ============================================ -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 seller-listing">
            <h5 class="mb-0" id="main_heading">{{$heading}}</h5>
            <hr class="m-0 heading-border">
            <div class="seller-listings">
                <div class="row">
                    <div class="col-md-12">
                        <div class="listing">
                            <div class="marg-sec">
                                <div class="dropdown">
                                    <button class="btn calendar-sec dropdown-toggle w-100" type="button"
                                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        @if ($Data['service_type'] == 'All')
                                            Online/In-person
                                        @else
                                            {{$Data['service_type']}}
                                        @endif
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item">
                                                <p>
                                                    <input type="radio" id="test23" name="radio-group" value="All"
                                                           @if ($Data['service_type'] == 'All') checked
                                                           @endif   onclick="updateButtonText(this.id)">
                                                    <label for="test23">Online/In-person</label>
                                                </p>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item">
                                                <p>
                                                    <input type="radio" id="test21" name="radio-group" value="Online"
                                                           @if ($Data['service_type'] == 'Online') checked
                                                           @endif  onclick="updateButtonText(this.id)">
                                                    <label for="test21">Online</label>
                                                </p>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item">
                                                <p>
                                                    <input type="radio" id="test22" name="radio-group" value="Inperson"
                                                           @if ($Data['service_type']== 'Inperson') checked
                                                           @endif  onclick="updateButtonText(this.id)">
                                                    <label for="test22">Inperson</label>
                                                </p>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>


                            <input type="hidden" name="service_type" value="{{$Data['service_type']}}"
                                   id="service_type">
                            <input type="hidden" name="service_role" value="{{$Data['service_role']}}"
                                   id="service_role">
                            <input type="hidden" name="date_time" id="selectDateTime">
                            <input type="hidden" name="keyword" id="keyword">
                            <input type="hidden" name="location" id="location">
                            <input type="hidden" name="category_type" id="category_type"
                                   value="{{$Data['category_type']}}">
                            <input type="hidden" name="category_service" id="category_service"
                                   value="{{$Data['category']}}">
                            <input type="hidden" name="sub_category_service" id="sub_category_service">
                            <input type="hidden" name="languages" id="languages">
                            <input type="hidden" name="max_price" id="max_price">
                            <input type="hidden" name="min_price" id="min_price">
                            <input type="hidden" name="distance" id="distance">
                            <input type="hidden" name="miles" id="miles">
                            <input type="hidden" name="latitude" id="latitude">
                            <input type="hidden" name="longitude" id="longitude">
                            <!-- <button type="button" onclick="hideShow()" class="btn filter-btn"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                    <path d="M8.35414 11.1235C8.35414 11.4794 8.12081 11.946 7.82331 12.1269L7.00081 12.6577C6.23664 13.1302 5.17497 12.5994 5.17497 11.6544V8.53354C5.17497 8.11937 4.94164 7.58854 4.70247 7.29687L2.46247 4.94021C2.16497 4.64271 1.93164 4.11771 1.93164 3.76187V2.40854C1.93164 1.70271 2.46247 1.17188 3.10997 1.17188H10.8916C11.5391 1.17188 12.07 1.70271 12.07 2.35021V3.64521C12.07 4.11771 11.7725 4.70687 11.4808 4.99854" stroke="#ABABAB" stroke-width="0.8" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M11.5892 9.98568L11.0059 9.40234M9.37253 9.63568C9.8676 9.63568 10.3424 9.43901 10.6925 9.08894C11.0425 8.73888 11.2392 8.26408 11.2392 7.76901C11.2392 7.27394 11.0425 6.79915 10.6925 6.44908C10.3424 6.09901 9.8676 5.90234 9.37253 5.90234C8.87746 5.90234 8.40266 6.09901 8.05259 6.44908C7.70253 6.79915 7.50586 7.27394 7.50586 7.76901C7.50586 8.26408 7.70253 8.73888 8.05259 9.08894C8.40266 9.43901 8.87746 9.63568 9.37253 9.63568Z" stroke="#ABABAB" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                  </svg>&nbsp;&nbsp;Filter&nbsp;&nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                    <path d="M9.95906 7.52344L6.69906 4.26344C6.31406 3.87844 5.68406 3.87844 5.29906 4.26344L2.03906 7.52344" stroke="#ABABAB" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                  </svg></button> -->
                            <!-- Button trigger modal -->
                            <!-- <button type="button" class="btn select-date" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <img src="assets/seller-listing-new/asset/img/calendarsearch.svg" alt="">&nbsp;&nbsp;Select Date
                          </button> -->
                            <button class="btn calendar-sec dropdown-toggle filter-sec" type="button"
                                    id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class='bx bx-sort'></i>&nbsp;Sort By


                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                <li>
                                    <a class="dropdown-item">
                                        <p>
                                            <input type="radio" id="test24" name="seller_type" value="Relevence"
                                                   @if ($Data['sort_by'] == 'Relevence') checked @endif>
                                            <label for="test24">Relevence</label>
                                        </p>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item">
                                        <p>
                                            <input type="radio" id="test25" name="seller_type" value="High to Low"
                                                   @if ($Data['sort_by'] == 'High to Low') checked @endif>
                                            <label for="test25">High to Low</label>
                                        </p>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item">
                                        <p>
                                            <input type="radio" id="test29" name="seller_type" value="Low to High"
                                                   @if ($Data['sort_by'] == 'Low to High') checked @endif>
                                            <label for="test29">Low to High</label>
                                        </p>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item">
                                        <p>
                                            <input type="radio" id="test26" name="seller_type" value="Trending"
                                                   @if ($Data['sort_by'] == 'Trending') checked @endif>
                                            <label for="test26">Trending</label>
                                        </p>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item">
                                        <p>
                                            <input type="radio" id="test27" name="seller_type" value="Top Seller"
                                                   @if ($Data['sort_by'] == 'Top Seller') checked @endif>
                                            <label for="test27">Top Seller</label>
                                        </p>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item">
                                        <p>
                                            <input type="radio" id="test28" name="seller_type" value="Rating"
                                                   @if ($Data['sort_by'] == 'Rating') checked @endif>
                                            <label for="test28">Rating</label>
                                        </p>
                                    </a>
                                </li>
                            </ul>


                            <div name="selectedDateTime" id="timedatePicker" class="calendar-sec">
                                <i class='bx bx-calendar-alt'></i>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="filter-lists dropdown-content" id="main">


                    <h6>Select Category</h6>
                    <div class="row">
                        <div class="col-xl-9 col-lg-8 col-md-12">
                            <dl id="dropdownContainer" class="dropdownContainer">

                                <dt id="side_categories_html_div">
                                    <a href="#" onclick="return false;">
                                        <span class="defaultText">Select Category</span>
                                        <p class="selectedItems" id="side_categories_html"></p>
                                    </a>
                                </dt>

                                <dd>
                                    <div class="multiSelectContainer">
                                        <ul style="max-height: 300px;" id="side_categories">
                                            <li>
                                                <form class="cat-search">
                                                    <input type="text" name="search" placeholder="Search..">
                                                </form>
                                            </li>
                                            @php
                                                $catetype = $Data['category_type'] == null ? 'category' : 'sub_category';
                                $category_type = $Data['category_type'] == null ? 'Category' : 'Sub_Category';
                                            @endphp
                                            @if ($categories_tab)
                                                @php $i = 1; @endphp
                                                @foreach ($categories_tab as $item)
                                                    <li><input type="checkbox" class="side_cates" name="categories_list"
                                                               value="{{$item->$catetype}}"/>{{$item->$catetype}}</li>

                                                    @php $i++; @endphp
                                                @endforeach

                                            @endif

                                            {{-- <li>  <input type="checkbox" value="Style & Beauty" />Style & Beauty</li> --}}

                                        </ul>
                                    </div>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-12">
                            <button onclick="CategoriesApply()" class="btn btn-apply w-100">Apply</button>
                        </div>
                    </div>
                    <hr>
                    <h6>Payment Type</h6>
                    <form action="#" class="filter-radio-items">
                        <p>
                            <input type="radio" id="test14" name="payment_type" value="All" checked>
                            <label for="test14">All Payment</label>
                        </p>
                        <p>
                            <input type="radio" id="test15" name="payment_type" value="OneOff">
                            <label for="test15">One-off Payment</label>
                        </p>
                        <p>
                            <input type="radio" id="test16" name="payment_type" value="Subscription">
                            <label for="test16">Subscription</label>
                        </p>
                    </form>
                    <hr>
                    <h6>Pricing Range</h6>
                    <div class="mb-3 row align-items-center">
                        <div class="col-lg-4 col-md-12">
                            <label for="inputPassword" class="col-sm-12 col-form-label filter-label">Maximum</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control filter-input" name="max_price_app"
                                       id="max_price_app" placeholder="Max.">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <label for="inputPassword" class="col-sm-12 col-form-label filter-label">Minimum</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control filter-input" name="min_price_app"
                                       id="min_price_app" placeholder="Min.">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <label for="inputPassword" class="col-sm-12 col-form-label filter-label"></label>
                            <button onclick="PriceRange();" class="btn btn-apply apply-price mt-2 w-100">Apply</button>
                        </div>
                    </div>
                    <hr>
                    <h6>Select Language</h6>
                    <div class="row">
                        <div class="col-xl-9 col-lg-8 col-md-12">
                            <dl class="dropdown">

                                <dt>
                                    <a href="#" onclick="return false;">
                                        <span class="hida">Select language</span>
                                        <p class="multiSel"></p>
                                    </a>
                                </dt>

                                <dd>
                                    <div class="mutliSelect">
                                        <ul>
                                            <li>
                                                <form class="cat-search">
                                                    <input type="text" id="search" placeholder="Search.."
                                                           onkeyup="filterList()">
                                                </form>
                                            </li>
                                            <li class="option"><input type="checkbox" name="languages_list"
                                                                      value="English"/> English
                                            </li>
                                            @if ($languages)
                                                @foreach ($languages as $item)
                                                    <li class="option"><input type="checkbox" name="languages_list"
                                                                              value="{{$item->language}}"/> {{$item->language}}
                                                    </li>
                                                @endforeach
                                                {{-- <li class="option"><input type="checkbox" value="Japanese" /> Japanese</li> --}}
                                            @endif
                                        </ul>
                                    </div>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-12">
                            <button onclick="LanguagesApply()" class="btn btn-apply w-100">Apply</button>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3 row">
                        <!-- <h6>Distance</h6> -->
                        <div class="mb-3 row align-items-center">
                            <div class="col-xl-5 col-lg-6 col-md-6">
                                <label for="inputPassword"
                                       class="col-sm-12 col-form-label filter-label">Distance</label>
                                <div class="col-sm-12">
                                    <input type="number" name="distance_app" id="distance_app"
                                           class="form-control filter-input" placeholder="Distance"
                                           fdprocessedid="3xjur9">
                                    <input type="hidden" name="latitude_app" id="latitude_app">
                                    <input type="hidden" name="longitude_app" id="longitude_app">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <label for="inputPassword" class="col-sm-12 col-form-label filter-label"></label>
                                <div class="col-sm-12">
                                    <select name="miles_app" id="miles_app" class="form-control distance-select mt-2">
                                        {{-- <option selected value="KM">KM</option> --}}
                                        <option value="M">M</option>
                                    </select>
                                    <!-- <input type="password" class="form-control filter-input" id="inputPassword" placeholder="Min." fdprocessedid="jlz91"> -->
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-12 col-md-12">
                                <label for="inputPassword" class="col-sm-12 col-form-label filter-label"></label>
                                <button onclick="getLiveLocation()" class="btn btn-apply apply-price mt-2 w-100"
                                        fdprocessedid="laa309">Apply
                                </button>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="freelance_div_main"
                         @if (in_array($service_role, ['All', 'Freelance'])) style="display: block;"
                         @else  style="display: none;" @endif>

                        <h6>Freelance Type</h6>
                        <form class="filter-radio-items">
                            <p>
                                <input type="radio" id="test9" name="freelance_service" value="All" checked>
                                <label for="test9">All </label>
                            </p>
                            <p>
                                <input type="radio" id="test10" name="freelance_service" value="Normal">
                                <label for="test10">Normal Freelance</label>
                            </p>
                            <p>
                                <input type="radio" id="test250" name="freelance_service" value="Consultation">
                                <label for="test250">Consultation Freelance</label>
                            </p>
                        </form>
                        <hr>

                        <h6>Freelance Plane</h6>
                        <form action="#" class="filter-radio-items">
                            <p>
                                <input type="radio" id="test6" name="freelance_type" value="All" checked>
                                <label for="test6">All Plans</label>
                            </p>
                            <p>
                                <input type="radio" id="test7" name="freelance_type" value="Premium">
                                <label for="test7">Premium Plan</label>
                            </p>
                            <p>
                                <input type="radio" id="test8" name="freelance_type" value="Basic">
                                <label for="test8">Basic Plan</label>
                            </p>
                        </form>
                        <hr>

                    </div>


                    <h6>Delivery Time</h6>
                    <form action="#" class="filter-radio-items">
                        <p>
                            <input type="radio" id="test280" name="delivery_time" value="All" checked>
                            <label for="test280">All Delivery Times</label>
                        </p>
                        <p>
                            <input type="radio" id="test260" name="delivery_time" value="1">
                            <label for="test260">Within 1 Day</label>
                        </p>
                        <p>
                            <input type="radio" id="test270" name="delivery_time" value="2">
                            <label for="test270">Within 2 Day</label>
                        </p>
                        <p>
                            <input type="radio" id="test300" name="delivery_time" value="3">
                            <label for="test300">Within 3 Day</label>
                        </p>
                        <p>
                            <input type="radio" id="test310" name="delivery_time" value="4">
                            <label for="test310">Within 4+ Day</label>
                        </p>
                    </form>
                    <hr>
                    <h6>Revisions</h6>
                    <form action="#" class="filter-radio-items">
                        <p>
                            <input type="radio" id="test32" name="revision" value="All" checked>
                            <label for="test32">All Revisions</label>
                        </p>
                        <p>
                            <input type="radio" id="test33" name="revision" value="1 to 5">
                            <label for="test33">1 to 5</label>
                        </p>
                        <p>
                            <input type="radio" id="test34" name="revision" value="5 to 10">
                            <label for="test34">5 to 10</label>
                        </p>
                        <p>
                            <input type="radio" id="test35" name="revision" value="10 to 20">
                            <label for="test35">10 to 20</label>
                        </p>
                        <p>
                            <input type="radio" id="test36" name="revision" value="Unlimited">
                            <label for="test36">Unlimited</label>
                        </p>
                    </form>
                    <hr>

                    <div class="class_div_main" @if (in_array($service_role, ['All', 'Class'])) style="display: block;"
                         @else  style="display: none;" @endif>

                        <h6>Class Type</h6>
                        <form action="#" class="filter-radio-items">
                            <p>
                                <input type="radio" id="test37" name="lesson_type" value="All" checked>
                                <label for="test37">All Classes</label>
                            </p>
                            <p>
                                <input type="radio" id="test38" name="lesson_type" value="One">
                                <label for="test38">1 to 1 Class</label>
                            </p>
                            <p>
                                <input type="radio" id="test39" name="lesson_type" value="Group">
                                <label for="test39">Group Class</label>
                            </p>
                        </form>
                        <hr>
                        <h6>Class Format</h6>
                        <form action="#" class="filter-radio-items">
                            <p>
                                <input type="radio" id="test40" name="class_type" value="All" checked>
                                <label for="test40">All Formats</label>
                            </p>
                            <p>
                                <input type="radio" id="test41" name="class_type" value="Live">
                                <label for="test41">Live Classes</label>
                            </p>
                            <p>
                                <input type="radio" id="test42" name="class_type" value="Video">
                                <label for="test42">Video Course</label>
                            </p>
                        </form>

                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-9 tabs-section">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs mb-3" id="myTab0" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button
                                data-mdb-tab-init
                                class="nav-link all-services-tab ms-0 active"
                                id="home-tab0" onclick="ExpertServices(this.id)" data-role="All"
                            >
                                All Experts
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button

                                data-mdb-tab-init
                                class="nav-link"
                                id="profile-tab0" onclick="ExpertServices(this.id)" data-role="Freelance"
                            >
                                Freelance Experts
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button
                                data-mdb-tab-init
                                class="nav-link"
                                id="contact-tab0" onclick="ExpertServices(this.id)" data-role="Class"
                            >
                                Teaching Experts
                            </button>
                        </li>
                        <li class="nav-item searchbar-sec" role="presentation">
                            <div class="searchwrapper">
                                <div class="searchbox">
                                    <div class="row search-sec">
                                        <div class="col-md-8 col-5 search-container search-container-main">
                                            <input type="text" autocomplete="off" id="keyword_search"
                                                   class="form-control search-form" placeholder="Find a service">
                                            <div class="suggestions" id="suggestions_main"
                                                 style="width:24%;top: 22%;"></div>
                                        </div>
                                        <div class="col-md-3 col-5 p-0">
                                            <input type="text" id="location_search" class="form-control search-form"
                                                   placeholder="Location">
                                        </div>
                                        <div class="col-md-1 col-2" onclick="searhBtn()">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                 viewBox="0 0 18 18" fill="none">
                                                <path
                                                    d="M12.8645 11.3208H12.0515L11.7633 11.0429C12.8067 9.83261 13.3802 8.28751 13.3791 6.68954C13.3791 5.36647 12.9867 4.07312 12.2517 2.97303C11.5166 1.87294 10.4719 1.01553 9.24951 0.509214C8.02716 0.00289847 6.68212 -0.129577 5.38447 0.128541C4.08683 0.386658 2.89487 1.02377 1.95932 1.95932C1.02377 2.89487 0.386658 4.08683 0.128541 5.38447C-0.129577 6.68212 0.00289847 8.02716 0.509214 9.24951C1.01553 10.4719 1.87294 11.5166 2.97303 12.2517C4.07312 12.9867 5.36647 13.3791 6.68954 13.3791C8.34649 13.3791 9.86964 12.7719 11.0429 11.7633L11.3208 12.0515V12.8645L16.4666 18L18 16.4666L12.8645 11.3208ZM6.68954 11.3208C4.12693 11.3208 2.05832 9.25214 2.05832 6.68954C2.05832 4.12693 4.12693 2.05832 6.68954 2.05832C9.25214 2.05832 11.3208 4.12693 11.3208 6.68954C11.3208 9.25214 9.25214 11.3208 6.68954 11.3208Z"
                                                    fill="#ABABAB"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- tab slider -->
            <div class="wrapper">
                <div class="icon active"><i id="left" class="fa-solid fa-angle-left"></i></div>
                <ul class="tabs-box" id="top_categories">
                    @php
                        $catetype = $Data['category_type'] == null ? 'category' : 'sub_category';
                  $category_type = $Data['category_type'] == null ? 'Category' : 'Sub_Category';
                    @endphp
                    @if ($categories_tab)
                        @php $i = 1; @endphp
                        @foreach ($categories_tab as $item)
                            <li class="tab" onclick="SelectCategory(this.id)" id="cats_{{$i}}"
                                data-category="{{$item->$catetype}}"
                                data-category_type="{{$category_type}}">{{$item->$catetype}}</li>
                            @php $i++; @endphp
                        @endforeach

                    @endif

                    {{-- <li class="tab active">Graphic Design</li>   --}}
                </ul>
                <div class="icon"><i id="right" class="fa-solid fa-angle-right"></i></div>
            </div>
            <!-- tab slider ended here -->
            <div class="tab-content" id="myTabContent0">
                <div
                    class="tab-pane fade show active"
                    id="home0"
                    role="tabpanel"
                    aria-labelledby="home-tab0"
                >
                    <!-- ========================  OUR EXPERTS SECTION START HERE ======================================== -->
                    <div class="container-fluid p-0 expert-sec">
                        <div class="container p-0">
                            <!-- CARD SECTION START HERE -->
                            <div class="row" id="AllGigs">

                                @if (count($gigs) > 0)

                                    @foreach ($gigs as $item)

                                        @php
                                            $media = \App\Models\TeacherGigData::where(['gig_id'=>$item->id])->first();
            $payment = \App\Models\TeacherGigPayment::where(['gig_id'=>$item->id])->first();
            $user = \App\Models\ExpertProfile::where(['user_id'=>$item->user_id, 'status'=>1])->first();
            $firstLetter = strtoupper(substr($user->first_name, 0, 1));
            $lastLetter = strtoupper(substr($user->last_name, 0, 1));
                                        @endphp

                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="main-Dream-card service-card"
                                                 data-service-id="{{$item->id}}"
                                                 data-service-name="{{$item->title}}"
                                                 data-service-category="{{$item->category ?? 'Uncategorized'}}"
                                                 data-service-price="{{$rate ?? 0}}"
                                                 data-service-type="{{$item->service_role ?? 'unknown'}}"
                                                 data-service-seller="{{$item->user_id}}">
                                                <div class="card dream-Card">
                                                    <div class="dream-card-upper-section">
                                                        <div style="height: 180px;">

                                                            @if (Str::endsWith($media->main_file, ['.mp4', '.avi', '.mov', '.webm']))
                                                                <!-- Video Player -->
                                                                <video autoplay loop muted
                                                                       style="height: 100%; width: 100%;">
                                                                    <source
                                                                        src="assets/teacher/listing/data_{{ $item->user_id }}/media/{{$media->main_file}}"
                                                                        type="video/mp4">
                                                                    Your browser does not support the video tag.
                                                                </video>
                                                            @elseif (Str::endsWith($media->main_file, ['.jpg', '.jpeg', '.png', '.gif']))
                                                                <!-- Image Display -->
                                                                <img
                                                                    src="assets/teacher/listing/data_{{ $item->user_id }}/media/{{$media->main_file}}"
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
                                                                          onclick="AddWishList(this.id);"
                                                                          data-gig_id="{{$item->id}}">
                              <i class="fa fa-heart" aria-hidden="true"></i>
                          </span>
                                                                @else
                                                                    <span id="heart_{{$item->id}}"
                                                                          onclick="AddWishList(this.id);"
                                                                          data-gig_id="{{$item->id}}">
                              <i class="fa fa-heart-o" aria-hidden="true"></i>
                          </span>

                                                                @endif

                                                            @endif

                                                        </div>
                                                    </div>
                                                    <a href="#" style="text-decoration: none;">
                                                        {{-- <div class="dream-card-dawon-section" type="button" data-bs-toggle="offcanvas" data-bs-target="#online-person" aria-controls="offcanvasRight"> --}}
                                                        <div class="dream-card-dawon-section" type="button"
                                                             data-bs-toggle="offcanvas" aria-controls="offcanvasRight">
                                                            <div class="dream-Card-inner-profile">
                                                                @if ($user->profile_image == null)
                                                                    <img
                                                                        src="assets/profile/avatars/({{$firstLetter}}).jpg"
                                                                        alt=""
                                                                        style="width: 60px;height: 60px; border-radius: 100%; border: 5px solid white;">
                                                                @else
                                                                    <img
                                                                        src="assets/profile/img/{{$user->profile_image}}"
                                                                        alt=""
                                                                        style="width: 60px;height: 60px; border-radius: 100%;border: 5px solid white;">

                                                                @endif

                                                                <i class="fa-solid fa-check tick"></i>
                                                            </div>
                                                            <p class="servise-bener">{{$item->service_type}}
                                                                Services</p>
                                                            <h5 class="dream-Card-name">
                                                                {{$user->first_name}} {{$lastLetter}}.
                                                            </h5>
                                                            <p class="Dev">{{$user->profession}}</p>
                                                            @if ($item->service_role == 'Class')
                                                                @if ($item->class_type == 'Video')
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
                                  <i class="fa-solid fa-star"></i> &nbsp; ({{$item->reviews}})
                              </span>
                                                            <div class="card-last">
                                                                @php
                                                                    // Get the rate value from the first non-null value
                                  $rate = $item->rate ?? $item->public_rate ?? $item->private_rate;

                                  // If rate contains "|*|", extract the first value before "|*|"
                                  if (strpos($rate, '|*|') !== false) {
                                      $rate = explode('|*|', $rate)[0]; // Extracts the first part
                                  }
                                                                @endphp
                                                                <span>Starting at ${{$rate}}</span>
                                                                <!-- word img -->
                                                                @if ($item->service_type == 'Online')
                                                                    <img data-toggle="tooltip" title="In Person-Service"
                                                                         src="assets/seller-listing/asset/img/globe.png"
                                                                         style="height: 25px; width: 25px;" alt="">

                                                                @else
                                                                    <img data-toggle="tooltip" title="In Person-Service"
                                                                         src="assets/seller-listing/asset/img/handshake.png"
                                                                         style="height: 25px; width: 25px;" alt="">

                                                                @endif
                                                                <!-- <i class="fa-solid fa-globe"></i> -->
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            </a>
                                        </div>

                                    @endforeach

                                @else

                                    <!-- online service section -->
                                    <div class="online-service">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="content_box">
                                                    <div class="image">
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            width="198"
                                                            height="206"
                                                            viewBox="0 0 198 206"
                                                            fill="#0072B1"
                                                            opacity="0.12"
                                                        >
                                                            <path
                                                                fill-rule="evenodd"
                                                                clip-rule="evenodd"
                                                                d="M147.466 0.583781C145.666 1.12818 144.33 1.92145 142.831 3.33516C141.104 4.96446 141.068 5.35893 142.644 5.35893C146.211 5.35893 152.936 8.5078 158.978 13.0082C176.3 25.9087 191.646 50.4433 191.697 65.3188L191.707 68.03L192.955 67.3866C198.265 64.6499 199.43 56.7415 196.045 46.4174C188.154 22.3467 160.809 -3.45168 147.466 0.583781ZM138.743 9.57154C138.473 10.2248 138.163 12.7195 138.056 15.1153C137.899 18.6345 138.045 20.2011 138.818 23.2753C141.489 33.9031 147.771 44.0721 157.904 54.1724C168.327 64.5605 177.283 69.75 184.753 69.7297C186.074 69.7258 187.403 69.5659 187.706 69.3745C188.531 68.8526 188.853 63.794 188.277 60.4067C185.398 43.4698 170.292 22.4677 153.949 12.6772C149.816 10.2015 144.498 8.38337 141.389 8.38337C139.446 8.38337 139.185 8.50045 138.743 9.57154ZM132.565 12.2862C131.442 13.4821 130.13 15.3478 129.649 16.4318C125.223 26.406 131.274 43.7101 144.283 58.2731C153.401 68.4802 163.593 75.8684 170.839 77.5237C174.171 78.285 178.512 77.871 181.344 76.5217C183.59 75.4519 185.638 73.9855 185.638 73.4476C185.638 73.3072 184.575 73.1927 183.276 73.1927C178.031 73.1927 170.341 69.5858 163.022 63.6934C158.519 60.0679 149.804 51.1359 146.569 46.8317C138.789 36.4799 134.453 25.6615 134.437 16.564C134.433 14.2909 134.562 11.909 134.722 11.2713C134.883 10.6335 134.922 10.1116 134.81 10.1116C134.697 10.1116 133.687 11.0902 132.565 12.2862ZM87.2369 12.6759C85.7184 13.1378 82.5773 14.7714 82.2774 15.2549C82.1399 15.4765 82.6632 15.795 83.44 15.9622C88.6426 17.0812 93.1023 21.8607 94.229 27.525L94.7279 30.0318L96.0071 28.8212C97.6652 27.2515 98.8928 24.841 99.2106 22.5304C100.104 16.0326 93.6533 10.7234 87.2369 12.6759ZM80.2357 18.6103C78.1389 19.165 77.9846 25.6702 79.9994 28.5684C82.0043 31.4516 86.0361 33.0619 89.5885 32.3974C90.9275 32.1472 91.1729 31.8945 91.5951 30.3325C92.456 27.1448 91.1482 23.4455 88.2694 20.9261C85.6819 18.6621 82.9822 17.8836 80.2357 18.6103ZM118.171 24.4842C102.702 37.9641 94.675 45.1181 93.6268 46.3599C90.39 50.194 89.6054 57.934 91.7312 65.0595C95.2676 76.9123 106.577 93.3319 115.63 99.7593C122.863 104.894 131.016 106.788 137.374 104.81C138.806 104.365 142.164 102.553 145.107 100.639C147.968 98.7776 151.967 96.181 153.993 94.8684C156.02 93.5558 161.384 90.0474 165.914 87.0718L174.15 81.6619L172.094 81.3522C166.736 80.5446 160.617 77.547 154.348 72.6586C150.186 69.4126 142.45 61.8165 138.832 57.4224C129.115 45.6206 123.491 31.1431 124.859 21.4532C125.068 19.9682 125.126 18.7559 124.986 18.7593C124.847 18.7628 121.78 21.3388 118.171 24.4842ZM68.6881 28.5892C65.5193 31.6153 62.546 34.6743 62.0805 35.3872C61.0471 36.9686 60.9356 40.6999 61.8676 42.496C63.1447 44.9574 66.6199 46.2329 69.7289 45.3808C71.5066 44.8939 85.0547 36.5421 85.0642 35.9273C85.0673 35.7489 84.7703 35.6033 84.4049 35.6033C83.1465 35.6033 79.5703 33.4957 78.2113 31.9528C76.2636 29.7415 75.4942 28.0569 75.2189 25.401C75.0863 24.1208 74.8591 23.0765 74.7135 23.0804C74.5683 23.0843 71.8564 25.563 68.6881 28.5892ZM154.283 28.4176C154.719 28.9806 156.914 31.557 159.158 34.1425C161.403 36.7284 165.183 41.4197 167.556 44.5686C169.93 47.7174 171.931 50.2934 172.001 50.2934C172.26 50.2934 171.213 46.9829 170.155 44.4605C167.741 38.7016 161.615 31.6352 156.506 28.7145C153.737 27.1318 153.232 27.0644 154.283 28.4176ZM45.2869 47.3394C38.9151 52.1309 33.083 56.5419 32.327 57.1416C29.0225 59.7629 27.9674 64.4866 29.9658 67.7094C31.0725 69.4938 32.4653 70.3704 34.9257 70.8306C38.2449 71.4515 39.8089 70.5657 50.519 62.0018C65.4144 50.0912 65.9337 49.6673 65.9662 49.3895C65.9827 49.2491 65.2037 48.8974 64.2353 48.6083C60.7549 47.5688 57.8987 43.8557 57.6386 40.0328C57.5861 39.2611 57.3923 38.629 57.2077 38.6286C57.023 38.6281 51.6587 42.5478 45.2869 47.3394ZM103.867 45.507C101.355 46.6442 98.7277 49.135 97.6071 51.4427C96.8229 53.0569 96.6998 53.8683 96.9053 56.0631C97.5273 62.7022 101.541 71.6256 106.693 77.8265C108.402 79.884 109.071 79.9903 107.633 77.9765C104.87 74.1095 100.346 61.6488 99.9388 56.7881C99.6284 53.0759 100.268 51.6298 103.933 47.7576C106.948 44.5716 106.935 44.1188 103.867 45.507ZM67.5753 52.2891C65.489 53.8423 64.3983 54.9242 64.619 55.2223C64.811 55.482 66.6979 57.8329 68.8116 60.4468C70.9253 63.0608 72.706 65.2695 72.7689 65.3551C72.8317 65.4406 74.3498 64.3164 76.1427 62.856L79.4021 60.2014L75.4799 55.1394C73.3229 52.3552 71.4056 50.0212 71.2196 49.9529C71.0336 49.8842 69.3938 50.9354 67.5753 52.2891ZM56.0672 61.0336C52.6708 63.635 49.8922 65.8917 49.8918 66.049C49.8918 66.2058 51.9838 68.8366 54.5409 71.8952L59.1904 77.4567L62.9184 74.0732C64.9688 72.2123 67.5606 69.9405 68.6777 69.025C69.7952 68.109 70.7215 67.2008 70.7367 67.0064C70.7593 66.7213 64.7581 59.1057 62.7441 56.8629C62.344 56.4174 60.9868 57.2647 56.0672 61.0336ZM79.7736 63.7953C68.8285 72.5308 62.9097 77.6775 61.1259 80.0102C56.3472 86.2582 56.2445 92.4108 60.7683 101.396C62.9613 105.751 67.9685 113.546 69.399 114.831C70.2855 115.628 70.3158 115.619 71.4923 114.226C73.6267 111.697 75.2723 110.352 77.7002 109.152C79.8607 108.084 80.5322 107.974 84.8527 107.974C88.6439 107.974 89.9171 108.135 91.0663 108.76L92.5111 109.546L100.454 103.592L108.398 97.6383L106.889 95.8928C106.059 94.9332 104.059 92.3978 102.443 90.2591C94.17 79.3051 89.3007 69.6096 88.0301 61.562C87.7271 59.6419 87.3591 58.0705 87.2126 58.0705C87.0661 58.0705 83.7183 60.6465 79.7736 63.7953ZM8.74545 85.0169C4.93513 86.0409 1.90595 88.3723 0.194554 91.5972C-0.223759 92.3849 0.113924 93.0619 2.78028 96.782C4.46654 99.1354 6.01754 101.245 6.22691 101.47C6.45969 101.721 7.15457 101.364 8.01677 100.551C9.82136 98.849 14.0422 96.0259 16.6873 94.7513C17.82 94.206 18.7464 93.6327 18.7464 93.478C18.7464 93.1155 14.1514 86.6734 12.9836 85.3984C11.9805 84.3036 11.5466 84.2643 8.74545 85.0169ZM141.788 89.3492C139.26 90.2492 136.582 91.9709 134.595 93.9736C132.581 96.0038 132.358 96.5262 133.511 96.5197C135.79 96.5072 141.099 92.9232 143.204 89.9766C144.186 88.6022 144.052 88.543 141.788 89.3492ZM46.7061 101.328C42.1762 104.664 34.6652 110.178 30.0148 113.581C25.3648 116.985 21.2268 120.136 20.8197 120.584C18.1321 123.545 17.1243 130.297 18.7048 134.758C20.179 138.921 23.4618 143.98 26.9826 147.516C30.7907 151.339 33.4393 152.764 37.2358 153.032C40.6473 153.272 41.6794 152.736 55.1911 143.707L65.3446 136.922L65.3897 134.113C65.42 132.223 66.0308 129.223 67.2584 124.935L69.0821 118.564L67.1115 116.153C62.6834 110.735 57.3416 101.556 56.0026 97.0641C55.7018 96.0544 55.3398 95.2356 55.1989 95.2451C55.0576 95.2546 51.236 97.9917 46.7061 101.328ZM17.9722 96.4769C15.1185 97.4594 11.3572 100.01 9.39872 102.29C7.9938 103.926 7.90927 104.205 7.90927 107.211V110.398L9.96832 108.633C13.2962 105.781 19.5882 101.447 22.9681 99.6781C24.6942 98.7751 26.1082 97.939 26.1104 97.8202C26.1156 97.5316 21.4712 95.656 20.7954 95.6741C20.5028 95.6819 19.2323 96.0431 17.9722 96.4769ZM24.1207 101.872C21.5224 103.149 18.0584 105.174 16.4229 106.371C13.268 108.68 8.34275 113.227 8.34275 113.831C8.34275 114.029 9.89549 116.558 11.7937 119.451L15.2442 124.71L16.2768 122.391C17.8087 118.95 18.8218 117.988 27.1382 112.078C31.3183 109.108 34.7489 106.557 34.7619 106.409C34.7979 105.994 29.5488 99.5485 29.1751 99.5485C28.9935 99.5485 26.719 100.594 24.1207 101.872ZM102.251 104.998L94.5792 110.448L96.5069 112.502C98.9383 115.092 100.605 118.348 101.187 121.646C101.437 123.059 101.779 124.157 101.947 124.087C102.802 123.731 126.23 108.37 126.24 108.161C126.246 108.026 125.129 107.568 123.758 107.143C120.448 106.118 116.675 104.112 113.331 101.601C111.828 100.472 110.447 99.5485 110.261 99.5485C110.076 99.5485 106.471 102.001 102.251 104.998ZM47.3438 108.73C44.3857 110.248 39.4244 114.639 40.2962 114.967C41.5706 115.445 48.7474 110.922 50.4132 108.59C51.6253 106.894 50.8519 106.929 47.3438 108.73ZM79.9868 111.065C76.6902 112.228 72.9761 116.195 71.8842 119.718C71.6128 120.593 71.8148 120.547 74.7022 119.07C77.6824 117.546 77.9971 117.479 82.1998 117.479C86.0443 117.479 86.8909 117.621 89.0466 118.628C92.0086 120.012 95.1258 122.783 96.6638 125.4C97.7618 127.267 97.8048 127.292 98.1897 126.288C98.8581 124.546 98.2885 120.249 97.0722 117.856C95.6651 115.088 92.1812 111.934 89.5413 111.038C87.0414 110.189 82.4312 110.202 79.9868 111.065ZM118.014 117.115L115.63 118.637L115.782 126.208L115.934 133.777L120.277 140.966C134.331 164.235 148.898 190.628 153.397 200.973L155.511 205.831L165.181 205.834C172.799 205.835 174.784 205.721 174.533 205.296C174.358 204.999 173.392 203.68 172.388 202.366C165.732 193.658 142.846 155.23 125.97 124.426C123.377 119.692 121.062 115.768 120.827 115.706C120.591 115.644 119.326 116.278 118.014 117.115ZM77.4505 121.608C74.2831 122.823 71.8915 125.055 70.2941 128.289C69.0106 130.889 68.9339 131.304 69.1176 134.644C69.3431 138.737 70.1853 140.741 72.781 143.354C79.4077 150.026 90.4741 147.916 94.3828 139.236C95.4375 136.893 95.5541 136.197 95.3803 133.296C95.1445 129.366 94.098 127.072 91.3086 124.37C87.7449 120.917 82.1564 119.804 77.4505 121.608ZM106.527 124.456L100.892 128.114L100.165 131.222C99.5374 133.905 99.4087 138.196 99.2218 162.63C99.0575 184.125 98.8395 192.54 98.315 197.627C97.9357 201.31 97.5178 204.664 97.3869 205.08C97.1654 205.782 97.7532 205.836 105.686 205.836H114.224L113.965 204.215C112.692 196.257 112.596 192.949 112.596 157.337C112.596 137.197 112.498 120.737 112.379 120.759C112.26 120.78 109.626 122.444 106.527 124.456ZM28.8695 123.513C27.6046 124.396 26.5474 126.805 26.5586 128.778C26.5695 130.661 27.8868 133.852 29.2523 135.302C30.6745 136.811 30.8189 136.479 29.9077 133.789C28.7351 130.329 28.5305 127.38 29.293 124.932C29.6446 123.804 29.8969 122.88 29.8544 122.88C29.8115 122.88 29.3685 123.165 28.8695 123.513ZM79.0037 127.025C75.7508 128.431 74.13 130.899 74.1716 134.383C74.2276 139.051 77.5125 142.323 82.143 142.323C84.3949 142.323 87.223 140.978 88.4502 139.323C93.378 132.68 86.5342 123.769 79.0037 127.025ZM79.0418 129.609C78.3127 130.22 77.4982 131.445 77.232 132.33C76.5931 134.455 77.5337 136.786 79.5165 137.991C84.1968 140.835 89.3536 136.268 87.0132 131.351C85.6265 128.439 81.5097 127.539 79.0418 129.609ZM14.2043 134.255C12.1236 137.419 11.6923 141.717 13.1366 144.89C15.4293 149.928 19.3606 152.68 24.2733 152.688C25.7636 152.69 26.9826 152.511 26.9826 152.289C26.9826 152.068 26.4203 151.488 25.7333 151C24.301 149.983 20.3086 144.853 18.488 141.689C17.8087 140.508 16.7393 138.091 16.1108 136.317L14.9686 133.092L14.2043 134.255ZM71.4606 148.514C71.1425 149.03 69.5511 151.882 67.9247 154.852C58.1158 172.765 42.9521 197.032 36.4 205.304C36.0515 205.744 37.9059 205.829 45.82 205.736L55.6744 205.62L57.0828 202.163C60.3712 194.093 72.6631 171.419 82.5301 155.221C83.9268 152.928 85.0694 150.947 85.0694 150.819C85.0694 150.691 84.3871 150.696 83.5531 150.831C81.3623 151.186 76.9754 150.221 74.3281 148.803L72.0393 147.576L71.4606 148.514Z"
                                                                fill="#0072B1"
                                                            />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="content_area">
                                                    <div class="content">
                                                        <h1>No Result</h1>
                                                        <p>
                                                            There are sadly no experts in this area or sector currently.
                                                            Please widen your search to give youa better result. You can
                                                            also contact our help team and we would do our best to find
                                                            you anexpert within 72 hours.
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="buttons_area">
                                                    {{-- <button class="wide-search-btn">Widen Search</button> --}}
                                                    <button class="btn contact-team-btn" data-bs-target="#online-user"
                                                            data-bs-toggle="modal">Contact Team
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- In-person service section -->
                                    {{-- <div class="In-person-service">
          <div class="row">
            <div class="col-md-12">
              <div class="content_box">
                <div class="image">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="198"
                    height="206"
                    viewBox="0 0 198 206"
                    fill="#0072B1"
                    opacity="0.12"
                  >
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M147.466 0.583781C145.666 1.12818 144.33 1.92145 142.831 3.33516C141.104 4.96446 141.068 5.35893 142.644 5.35893C146.211 5.35893 152.936 8.5078 158.978 13.0082C176.3 25.9087 191.646 50.4433 191.697 65.3188L191.707 68.03L192.955 67.3866C198.265 64.6499 199.43 56.7415 196.045 46.4174C188.154 22.3467 160.809 -3.45168 147.466 0.583781ZM138.743 9.57154C138.473 10.2248 138.163 12.7195 138.056 15.1153C137.899 18.6345 138.045 20.2011 138.818 23.2753C141.489 33.9031 147.771 44.0721 157.904 54.1724C168.327 64.5605 177.283 69.75 184.753 69.7297C186.074 69.7258 187.403 69.5659 187.706 69.3745C188.531 68.8526 188.853 63.794 188.277 60.4067C185.398 43.4698 170.292 22.4677 153.949 12.6772C149.816 10.2015 144.498 8.38337 141.389 8.38337C139.446 8.38337 139.185 8.50045 138.743 9.57154ZM132.565 12.2862C131.442 13.4821 130.13 15.3478 129.649 16.4318C125.223 26.406 131.274 43.7101 144.283 58.2731C153.401 68.4802 163.593 75.8684 170.839 77.5237C174.171 78.285 178.512 77.871 181.344 76.5217C183.59 75.4519 185.638 73.9855 185.638 73.4476C185.638 73.3072 184.575 73.1927 183.276 73.1927C178.031 73.1927 170.341 69.5858 163.022 63.6934C158.519 60.0679 149.804 51.1359 146.569 46.8317C138.789 36.4799 134.453 25.6615 134.437 16.564C134.433 14.2909 134.562 11.909 134.722 11.2713C134.883 10.6335 134.922 10.1116 134.81 10.1116C134.697 10.1116 133.687 11.0902 132.565 12.2862ZM87.2369 12.6759C85.7184 13.1378 82.5773 14.7714 82.2774 15.2549C82.1399 15.4765 82.6632 15.795 83.44 15.9622C88.6426 17.0812 93.1023 21.8607 94.229 27.525L94.7279 30.0318L96.0071 28.8212C97.6652 27.2515 98.8928 24.841 99.2106 22.5304C100.104 16.0326 93.6533 10.7234 87.2369 12.6759ZM80.2357 18.6103C78.1389 19.165 77.9846 25.6702 79.9994 28.5684C82.0043 31.4516 86.0361 33.0619 89.5885 32.3974C90.9275 32.1472 91.1729 31.8945 91.5951 30.3325C92.456 27.1448 91.1482 23.4455 88.2694 20.9261C85.6819 18.6621 82.9822 17.8836 80.2357 18.6103ZM118.171 24.4842C102.702 37.9641 94.675 45.1181 93.6268 46.3599C90.39 50.194 89.6054 57.934 91.7312 65.0595C95.2676 76.9123 106.577 93.3319 115.63 99.7593C122.863 104.894 131.016 106.788 137.374 104.81C138.806 104.365 142.164 102.553 145.107 100.639C147.968 98.7776 151.967 96.181 153.993 94.8684C156.02 93.5558 161.384 90.0474 165.914 87.0718L174.15 81.6619L172.094 81.3522C166.736 80.5446 160.617 77.547 154.348 72.6586C150.186 69.4126 142.45 61.8165 138.832 57.4224C129.115 45.6206 123.491 31.1431 124.859 21.4532C125.068 19.9682 125.126 18.7559 124.986 18.7593C124.847 18.7628 121.78 21.3388 118.171 24.4842ZM68.6881 28.5892C65.5193 31.6153 62.546 34.6743 62.0805 35.3872C61.0471 36.9686 60.9356 40.6999 61.8676 42.496C63.1447 44.9574 66.6199 46.2329 69.7289 45.3808C71.5066 44.8939 85.0547 36.5421 85.0642 35.9273C85.0673 35.7489 84.7703 35.6033 84.4049 35.6033C83.1465 35.6033 79.5703 33.4957 78.2113 31.9528C76.2636 29.7415 75.4942 28.0569 75.2189 25.401C75.0863 24.1208 74.8591 23.0765 74.7135 23.0804C74.5683 23.0843 71.8564 25.563 68.6881 28.5892ZM154.283 28.4176C154.719 28.9806 156.914 31.557 159.158 34.1425C161.403 36.7284 165.183 41.4197 167.556 44.5686C169.93 47.7174 171.931 50.2934 172.001 50.2934C172.26 50.2934 171.213 46.9829 170.155 44.4605C167.741 38.7016 161.615 31.6352 156.506 28.7145C153.737 27.1318 153.232 27.0644 154.283 28.4176ZM45.2869 47.3394C38.9151 52.1309 33.083 56.5419 32.327 57.1416C29.0225 59.7629 27.9674 64.4866 29.9658 67.7094C31.0725 69.4938 32.4653 70.3704 34.9257 70.8306C38.2449 71.4515 39.8089 70.5657 50.519 62.0018C65.4144 50.0912 65.9337 49.6673 65.9662 49.3895C65.9827 49.2491 65.2037 48.8974 64.2353 48.6083C60.7549 47.5688 57.8987 43.8557 57.6386 40.0328C57.5861 39.2611 57.3923 38.629 57.2077 38.6286C57.023 38.6281 51.6587 42.5478 45.2869 47.3394ZM103.867 45.507C101.355 46.6442 98.7277 49.135 97.6071 51.4427C96.8229 53.0569 96.6998 53.8683 96.9053 56.0631C97.5273 62.7022 101.541 71.6256 106.693 77.8265C108.402 79.884 109.071 79.9903 107.633 77.9765C104.87 74.1095 100.346 61.6488 99.9388 56.7881C99.6284 53.0759 100.268 51.6298 103.933 47.7576C106.948 44.5716 106.935 44.1188 103.867 45.507ZM67.5753 52.2891C65.489 53.8423 64.3983 54.9242 64.619 55.2223C64.811 55.482 66.6979 57.8329 68.8116 60.4468C70.9253 63.0608 72.706 65.2695 72.7689 65.3551C72.8317 65.4406 74.3498 64.3164 76.1427 62.856L79.4021 60.2014L75.4799 55.1394C73.3229 52.3552 71.4056 50.0212 71.2196 49.9529C71.0336 49.8842 69.3938 50.9354 67.5753 52.2891ZM56.0672 61.0336C52.6708 63.635 49.8922 65.8917 49.8918 66.049C49.8918 66.2058 51.9838 68.8366 54.5409 71.8952L59.1904 77.4567L62.9184 74.0732C64.9688 72.2123 67.5606 69.9405 68.6777 69.025C69.7952 68.109 70.7215 67.2008 70.7367 67.0064C70.7593 66.7213 64.7581 59.1057 62.7441 56.8629C62.344 56.4174 60.9868 57.2647 56.0672 61.0336ZM79.7736 63.7953C68.8285 72.5308 62.9097 77.6775 61.1259 80.0102C56.3472 86.2582 56.2445 92.4108 60.7683 101.396C62.9613 105.751 67.9685 113.546 69.399 114.831C70.2855 115.628 70.3158 115.619 71.4923 114.226C73.6267 111.697 75.2723 110.352 77.7002 109.152C79.8607 108.084 80.5322 107.974 84.8527 107.974C88.6439 107.974 89.9171 108.135 91.0663 108.76L92.5111 109.546L100.454 103.592L108.398 97.6383L106.889 95.8928C106.059 94.9332 104.059 92.3978 102.443 90.2591C94.17 79.3051 89.3007 69.6096 88.0301 61.562C87.7271 59.6419 87.3591 58.0705 87.2126 58.0705C87.0661 58.0705 83.7183 60.6465 79.7736 63.7953ZM8.74545 85.0169C4.93513 86.0409 1.90595 88.3723 0.194554 91.5972C-0.223759 92.3849 0.113924 93.0619 2.78028 96.782C4.46654 99.1354 6.01754 101.245 6.22691 101.47C6.45969 101.721 7.15457 101.364 8.01677 100.551C9.82136 98.849 14.0422 96.0259 16.6873 94.7513C17.82 94.206 18.7464 93.6327 18.7464 93.478C18.7464 93.1155 14.1514 86.6734 12.9836 85.3984C11.9805 84.3036 11.5466 84.2643 8.74545 85.0169ZM141.788 89.3492C139.26 90.2492 136.582 91.9709 134.595 93.9736C132.581 96.0038 132.358 96.5262 133.511 96.5197C135.79 96.5072 141.099 92.9232 143.204 89.9766C144.186 88.6022 144.052 88.543 141.788 89.3492ZM46.7061 101.328C42.1762 104.664 34.6652 110.178 30.0148 113.581C25.3648 116.985 21.2268 120.136 20.8197 120.584C18.1321 123.545 17.1243 130.297 18.7048 134.758C20.179 138.921 23.4618 143.98 26.9826 147.516C30.7907 151.339 33.4393 152.764 37.2358 153.032C40.6473 153.272 41.6794 152.736 55.1911 143.707L65.3446 136.922L65.3897 134.113C65.42 132.223 66.0308 129.223 67.2584 124.935L69.0821 118.564L67.1115 116.153C62.6834 110.735 57.3416 101.556 56.0026 97.0641C55.7018 96.0544 55.3398 95.2356 55.1989 95.2451C55.0576 95.2546 51.236 97.9917 46.7061 101.328ZM17.9722 96.4769C15.1185 97.4594 11.3572 100.01 9.39872 102.29C7.9938 103.926 7.90927 104.205 7.90927 107.211V110.398L9.96832 108.633C13.2962 105.781 19.5882 101.447 22.9681 99.6781C24.6942 98.7751 26.1082 97.939 26.1104 97.8202C26.1156 97.5316 21.4712 95.656 20.7954 95.6741C20.5028 95.6819 19.2323 96.0431 17.9722 96.4769ZM24.1207 101.872C21.5224 103.149 18.0584 105.174 16.4229 106.371C13.268 108.68 8.34275 113.227 8.34275 113.831C8.34275 114.029 9.89549 116.558 11.7937 119.451L15.2442 124.71L16.2768 122.391C17.8087 118.95 18.8218 117.988 27.1382 112.078C31.3183 109.108 34.7489 106.557 34.7619 106.409C34.7979 105.994 29.5488 99.5485 29.1751 99.5485C28.9935 99.5485 26.719 100.594 24.1207 101.872ZM102.251 104.998L94.5792 110.448L96.5069 112.502C98.9383 115.092 100.605 118.348 101.187 121.646C101.437 123.059 101.779 124.157 101.947 124.087C102.802 123.731 126.23 108.37 126.24 108.161C126.246 108.026 125.129 107.568 123.758 107.143C120.448 106.118 116.675 104.112 113.331 101.601C111.828 100.472 110.447 99.5485 110.261 99.5485C110.076 99.5485 106.471 102.001 102.251 104.998ZM47.3438 108.73C44.3857 110.248 39.4244 114.639 40.2962 114.967C41.5706 115.445 48.7474 110.922 50.4132 108.59C51.6253 106.894 50.8519 106.929 47.3438 108.73ZM79.9868 111.065C76.6902 112.228 72.9761 116.195 71.8842 119.718C71.6128 120.593 71.8148 120.547 74.7022 119.07C77.6824 117.546 77.9971 117.479 82.1998 117.479C86.0443 117.479 86.8909 117.621 89.0466 118.628C92.0086 120.012 95.1258 122.783 96.6638 125.4C97.7618 127.267 97.8048 127.292 98.1897 126.288C98.8581 124.546 98.2885 120.249 97.0722 117.856C95.6651 115.088 92.1812 111.934 89.5413 111.038C87.0414 110.189 82.4312 110.202 79.9868 111.065ZM118.014 117.115L115.63 118.637L115.782 126.208L115.934 133.777L120.277 140.966C134.331 164.235 148.898 190.628 153.397 200.973L155.511 205.831L165.181 205.834C172.799 205.835 174.784 205.721 174.533 205.296C174.358 204.999 173.392 203.68 172.388 202.366C165.732 193.658 142.846 155.23 125.97 124.426C123.377 119.692 121.062 115.768 120.827 115.706C120.591 115.644 119.326 116.278 118.014 117.115ZM77.4505 121.608C74.2831 122.823 71.8915 125.055 70.2941 128.289C69.0106 130.889 68.9339 131.304 69.1176 134.644C69.3431 138.737 70.1853 140.741 72.781 143.354C79.4077 150.026 90.4741 147.916 94.3828 139.236C95.4375 136.893 95.5541 136.197 95.3803 133.296C95.1445 129.366 94.098 127.072 91.3086 124.37C87.7449 120.917 82.1564 119.804 77.4505 121.608ZM106.527 124.456L100.892 128.114L100.165 131.222C99.5374 133.905 99.4087 138.196 99.2218 162.63C99.0575 184.125 98.8395 192.54 98.315 197.627C97.9357 201.31 97.5178 204.664 97.3869 205.08C97.1654 205.782 97.7532 205.836 105.686 205.836H114.224L113.965 204.215C112.692 196.257 112.596 192.949 112.596 157.337C112.596 137.197 112.498 120.737 112.379 120.759C112.26 120.78 109.626 122.444 106.527 124.456ZM28.8695 123.513C27.6046 124.396 26.5474 126.805 26.5586 128.778C26.5695 130.661 27.8868 133.852 29.2523 135.302C30.6745 136.811 30.8189 136.479 29.9077 133.789C28.7351 130.329 28.5305 127.38 29.293 124.932C29.6446 123.804 29.8969 122.88 29.8544 122.88C29.8115 122.88 29.3685 123.165 28.8695 123.513ZM79.0037 127.025C75.7508 128.431 74.13 130.899 74.1716 134.383C74.2276 139.051 77.5125 142.323 82.143 142.323C84.3949 142.323 87.223 140.978 88.4502 139.323C93.378 132.68 86.5342 123.769 79.0037 127.025ZM79.0418 129.609C78.3127 130.22 77.4982 131.445 77.232 132.33C76.5931 134.455 77.5337 136.786 79.5165 137.991C84.1968 140.835 89.3536 136.268 87.0132 131.351C85.6265 128.439 81.5097 127.539 79.0418 129.609ZM14.2043 134.255C12.1236 137.419 11.6923 141.717 13.1366 144.89C15.4293 149.928 19.3606 152.68 24.2733 152.688C25.7636 152.69 26.9826 152.511 26.9826 152.289C26.9826 152.068 26.4203 151.488 25.7333 151C24.301 149.983 20.3086 144.853 18.488 141.689C17.8087 140.508 16.7393 138.091 16.1108 136.317L14.9686 133.092L14.2043 134.255ZM71.4606 148.514C71.1425 149.03 69.5511 151.882 67.9247 154.852C58.1158 172.765 42.9521 197.032 36.4 205.304C36.0515 205.744 37.9059 205.829 45.82 205.736L55.6744 205.62L57.0828 202.163C60.3712 194.093 72.6631 171.419 82.5301 155.221C83.9268 152.928 85.0694 150.947 85.0694 150.819C85.0694 150.691 84.3871 150.696 83.5531 150.831C81.3623 151.186 76.9754 150.221 74.3281 148.803L72.0393 147.576L71.4606 148.514Z"
                      fill="#0072B1"
                    />
                  </svg>
                </div>
              </div>
              <div class="content_area">
                <div class="content">
                  <h1>No Result</h1>
                  <p>
                    There are sadly no experts in this sector currently. Please
                    contact our help team and we woulddo our best to find you an
                    expert within 72 hours
                  </p>
                </div>
              </div>
              <div class="buttons_area">

                <button class="btn contact-team-btn" data-bs-target="#in-person-service"
                data-bs-toggle="modal">Contact Team</button>
              </div>
            </div>
          </div>
        </div> --}}

                                @endif



                                {{-- <div class="col-lg-3 col-md-6 col-12">
                  <div class="main-Dream-card">
                      <div class="card dream-Card">
                          <div class="dream-card-upper-section">
                              <img src="assets/seller-listing-new/asset/img/card-main-img.png" alt="">
                              <div class="card-img-overlay overlay-inner">
                                  <p>
                                      Top Seller
                                  </p>
                                  <span id=heart7>
                                      <i class="fa fa-heart-o" aria-hidden="true"></i>
                                  </span>
                              </div>
                          </div>
                          <a href="#" style="text-decoration: none;">
                              <div class="dream-card-dawon-section" type="button" data-bs-toggle="offcanvas" data-bs-target="#online-person" aria-controls="offcanvasRight">
                                  <div class="dream-Card-inner-profile">
                                      <img src="assets/seller-listing-new/asset/img/inner-profile.png" alt="">
                                      <i class="fa-solid fa-check tick"></i>
                                  </div>
                                  <p class="servise-bener">In-Person Services</p>
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
                                      <img data-toggle="tooltip" title="In Person-Service" src="assets/seller-listing-new/asset/img/globe.png" style="height: 25px; width: 25px;" alt="">
                                      <!-- <i class="fa-solid fa-globe"></i> -->
                                  </div>
                              </div>
                      </div>
                  </div>
                  </a>
              </div> --}}
                            </div>

                            <!-- online service section -->
                            <div class="online-service" id="EmptyGigs" style="display: none ;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="content_box">
                                            <div class="image">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="198"
                                                    height="206"
                                                    viewBox="0 0 198 206"
                                                    fill="#0072B1"
                                                    opacity="0.12"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M147.466 0.583781C145.666 1.12818 144.33 1.92145 142.831 3.33516C141.104 4.96446 141.068 5.35893 142.644 5.35893C146.211 5.35893 152.936 8.5078 158.978 13.0082C176.3 25.9087 191.646 50.4433 191.697 65.3188L191.707 68.03L192.955 67.3866C198.265 64.6499 199.43 56.7415 196.045 46.4174C188.154 22.3467 160.809 -3.45168 147.466 0.583781ZM138.743 9.57154C138.473 10.2248 138.163 12.7195 138.056 15.1153C137.899 18.6345 138.045 20.2011 138.818 23.2753C141.489 33.9031 147.771 44.0721 157.904 54.1724C168.327 64.5605 177.283 69.75 184.753 69.7297C186.074 69.7258 187.403 69.5659 187.706 69.3745C188.531 68.8526 188.853 63.794 188.277 60.4067C185.398 43.4698 170.292 22.4677 153.949 12.6772C149.816 10.2015 144.498 8.38337 141.389 8.38337C139.446 8.38337 139.185 8.50045 138.743 9.57154ZM132.565 12.2862C131.442 13.4821 130.13 15.3478 129.649 16.4318C125.223 26.406 131.274 43.7101 144.283 58.2731C153.401 68.4802 163.593 75.8684 170.839 77.5237C174.171 78.285 178.512 77.871 181.344 76.5217C183.59 75.4519 185.638 73.9855 185.638 73.4476C185.638 73.3072 184.575 73.1927 183.276 73.1927C178.031 73.1927 170.341 69.5858 163.022 63.6934C158.519 60.0679 149.804 51.1359 146.569 46.8317C138.789 36.4799 134.453 25.6615 134.437 16.564C134.433 14.2909 134.562 11.909 134.722 11.2713C134.883 10.6335 134.922 10.1116 134.81 10.1116C134.697 10.1116 133.687 11.0902 132.565 12.2862ZM87.2369 12.6759C85.7184 13.1378 82.5773 14.7714 82.2774 15.2549C82.1399 15.4765 82.6632 15.795 83.44 15.9622C88.6426 17.0812 93.1023 21.8607 94.229 27.525L94.7279 30.0318L96.0071 28.8212C97.6652 27.2515 98.8928 24.841 99.2106 22.5304C100.104 16.0326 93.6533 10.7234 87.2369 12.6759ZM80.2357 18.6103C78.1389 19.165 77.9846 25.6702 79.9994 28.5684C82.0043 31.4516 86.0361 33.0619 89.5885 32.3974C90.9275 32.1472 91.1729 31.8945 91.5951 30.3325C92.456 27.1448 91.1482 23.4455 88.2694 20.9261C85.6819 18.6621 82.9822 17.8836 80.2357 18.6103ZM118.171 24.4842C102.702 37.9641 94.675 45.1181 93.6268 46.3599C90.39 50.194 89.6054 57.934 91.7312 65.0595C95.2676 76.9123 106.577 93.3319 115.63 99.7593C122.863 104.894 131.016 106.788 137.374 104.81C138.806 104.365 142.164 102.553 145.107 100.639C147.968 98.7776 151.967 96.181 153.993 94.8684C156.02 93.5558 161.384 90.0474 165.914 87.0718L174.15 81.6619L172.094 81.3522C166.736 80.5446 160.617 77.547 154.348 72.6586C150.186 69.4126 142.45 61.8165 138.832 57.4224C129.115 45.6206 123.491 31.1431 124.859 21.4532C125.068 19.9682 125.126 18.7559 124.986 18.7593C124.847 18.7628 121.78 21.3388 118.171 24.4842ZM68.6881 28.5892C65.5193 31.6153 62.546 34.6743 62.0805 35.3872C61.0471 36.9686 60.9356 40.6999 61.8676 42.496C63.1447 44.9574 66.6199 46.2329 69.7289 45.3808C71.5066 44.8939 85.0547 36.5421 85.0642 35.9273C85.0673 35.7489 84.7703 35.6033 84.4049 35.6033C83.1465 35.6033 79.5703 33.4957 78.2113 31.9528C76.2636 29.7415 75.4942 28.0569 75.2189 25.401C75.0863 24.1208 74.8591 23.0765 74.7135 23.0804C74.5683 23.0843 71.8564 25.563 68.6881 28.5892ZM154.283 28.4176C154.719 28.9806 156.914 31.557 159.158 34.1425C161.403 36.7284 165.183 41.4197 167.556 44.5686C169.93 47.7174 171.931 50.2934 172.001 50.2934C172.26 50.2934 171.213 46.9829 170.155 44.4605C167.741 38.7016 161.615 31.6352 156.506 28.7145C153.737 27.1318 153.232 27.0644 154.283 28.4176ZM45.2869 47.3394C38.9151 52.1309 33.083 56.5419 32.327 57.1416C29.0225 59.7629 27.9674 64.4866 29.9658 67.7094C31.0725 69.4938 32.4653 70.3704 34.9257 70.8306C38.2449 71.4515 39.8089 70.5657 50.519 62.0018C65.4144 50.0912 65.9337 49.6673 65.9662 49.3895C65.9827 49.2491 65.2037 48.8974 64.2353 48.6083C60.7549 47.5688 57.8987 43.8557 57.6386 40.0328C57.5861 39.2611 57.3923 38.629 57.2077 38.6286C57.023 38.6281 51.6587 42.5478 45.2869 47.3394ZM103.867 45.507C101.355 46.6442 98.7277 49.135 97.6071 51.4427C96.8229 53.0569 96.6998 53.8683 96.9053 56.0631C97.5273 62.7022 101.541 71.6256 106.693 77.8265C108.402 79.884 109.071 79.9903 107.633 77.9765C104.87 74.1095 100.346 61.6488 99.9388 56.7881C99.6284 53.0759 100.268 51.6298 103.933 47.7576C106.948 44.5716 106.935 44.1188 103.867 45.507ZM67.5753 52.2891C65.489 53.8423 64.3983 54.9242 64.619 55.2223C64.811 55.482 66.6979 57.8329 68.8116 60.4468C70.9253 63.0608 72.706 65.2695 72.7689 65.3551C72.8317 65.4406 74.3498 64.3164 76.1427 62.856L79.4021 60.2014L75.4799 55.1394C73.3229 52.3552 71.4056 50.0212 71.2196 49.9529C71.0336 49.8842 69.3938 50.9354 67.5753 52.2891ZM56.0672 61.0336C52.6708 63.635 49.8922 65.8917 49.8918 66.049C49.8918 66.2058 51.9838 68.8366 54.5409 71.8952L59.1904 77.4567L62.9184 74.0732C64.9688 72.2123 67.5606 69.9405 68.6777 69.025C69.7952 68.109 70.7215 67.2008 70.7367 67.0064C70.7593 66.7213 64.7581 59.1057 62.7441 56.8629C62.344 56.4174 60.9868 57.2647 56.0672 61.0336ZM79.7736 63.7953C68.8285 72.5308 62.9097 77.6775 61.1259 80.0102C56.3472 86.2582 56.2445 92.4108 60.7683 101.396C62.9613 105.751 67.9685 113.546 69.399 114.831C70.2855 115.628 70.3158 115.619 71.4923 114.226C73.6267 111.697 75.2723 110.352 77.7002 109.152C79.8607 108.084 80.5322 107.974 84.8527 107.974C88.6439 107.974 89.9171 108.135 91.0663 108.76L92.5111 109.546L100.454 103.592L108.398 97.6383L106.889 95.8928C106.059 94.9332 104.059 92.3978 102.443 90.2591C94.17 79.3051 89.3007 69.6096 88.0301 61.562C87.7271 59.6419 87.3591 58.0705 87.2126 58.0705C87.0661 58.0705 83.7183 60.6465 79.7736 63.7953ZM8.74545 85.0169C4.93513 86.0409 1.90595 88.3723 0.194554 91.5972C-0.223759 92.3849 0.113924 93.0619 2.78028 96.782C4.46654 99.1354 6.01754 101.245 6.22691 101.47C6.45969 101.721 7.15457 101.364 8.01677 100.551C9.82136 98.849 14.0422 96.0259 16.6873 94.7513C17.82 94.206 18.7464 93.6327 18.7464 93.478C18.7464 93.1155 14.1514 86.6734 12.9836 85.3984C11.9805 84.3036 11.5466 84.2643 8.74545 85.0169ZM141.788 89.3492C139.26 90.2492 136.582 91.9709 134.595 93.9736C132.581 96.0038 132.358 96.5262 133.511 96.5197C135.79 96.5072 141.099 92.9232 143.204 89.9766C144.186 88.6022 144.052 88.543 141.788 89.3492ZM46.7061 101.328C42.1762 104.664 34.6652 110.178 30.0148 113.581C25.3648 116.985 21.2268 120.136 20.8197 120.584C18.1321 123.545 17.1243 130.297 18.7048 134.758C20.179 138.921 23.4618 143.98 26.9826 147.516C30.7907 151.339 33.4393 152.764 37.2358 153.032C40.6473 153.272 41.6794 152.736 55.1911 143.707L65.3446 136.922L65.3897 134.113C65.42 132.223 66.0308 129.223 67.2584 124.935L69.0821 118.564L67.1115 116.153C62.6834 110.735 57.3416 101.556 56.0026 97.0641C55.7018 96.0544 55.3398 95.2356 55.1989 95.2451C55.0576 95.2546 51.236 97.9917 46.7061 101.328ZM17.9722 96.4769C15.1185 97.4594 11.3572 100.01 9.39872 102.29C7.9938 103.926 7.90927 104.205 7.90927 107.211V110.398L9.96832 108.633C13.2962 105.781 19.5882 101.447 22.9681 99.6781C24.6942 98.7751 26.1082 97.939 26.1104 97.8202C26.1156 97.5316 21.4712 95.656 20.7954 95.6741C20.5028 95.6819 19.2323 96.0431 17.9722 96.4769ZM24.1207 101.872C21.5224 103.149 18.0584 105.174 16.4229 106.371C13.268 108.68 8.34275 113.227 8.34275 113.831C8.34275 114.029 9.89549 116.558 11.7937 119.451L15.2442 124.71L16.2768 122.391C17.8087 118.95 18.8218 117.988 27.1382 112.078C31.3183 109.108 34.7489 106.557 34.7619 106.409C34.7979 105.994 29.5488 99.5485 29.1751 99.5485C28.9935 99.5485 26.719 100.594 24.1207 101.872ZM102.251 104.998L94.5792 110.448L96.5069 112.502C98.9383 115.092 100.605 118.348 101.187 121.646C101.437 123.059 101.779 124.157 101.947 124.087C102.802 123.731 126.23 108.37 126.24 108.161C126.246 108.026 125.129 107.568 123.758 107.143C120.448 106.118 116.675 104.112 113.331 101.601C111.828 100.472 110.447 99.5485 110.261 99.5485C110.076 99.5485 106.471 102.001 102.251 104.998ZM47.3438 108.73C44.3857 110.248 39.4244 114.639 40.2962 114.967C41.5706 115.445 48.7474 110.922 50.4132 108.59C51.6253 106.894 50.8519 106.929 47.3438 108.73ZM79.9868 111.065C76.6902 112.228 72.9761 116.195 71.8842 119.718C71.6128 120.593 71.8148 120.547 74.7022 119.07C77.6824 117.546 77.9971 117.479 82.1998 117.479C86.0443 117.479 86.8909 117.621 89.0466 118.628C92.0086 120.012 95.1258 122.783 96.6638 125.4C97.7618 127.267 97.8048 127.292 98.1897 126.288C98.8581 124.546 98.2885 120.249 97.0722 117.856C95.6651 115.088 92.1812 111.934 89.5413 111.038C87.0414 110.189 82.4312 110.202 79.9868 111.065ZM118.014 117.115L115.63 118.637L115.782 126.208L115.934 133.777L120.277 140.966C134.331 164.235 148.898 190.628 153.397 200.973L155.511 205.831L165.181 205.834C172.799 205.835 174.784 205.721 174.533 205.296C174.358 204.999 173.392 203.68 172.388 202.366C165.732 193.658 142.846 155.23 125.97 124.426C123.377 119.692 121.062 115.768 120.827 115.706C120.591 115.644 119.326 116.278 118.014 117.115ZM77.4505 121.608C74.2831 122.823 71.8915 125.055 70.2941 128.289C69.0106 130.889 68.9339 131.304 69.1176 134.644C69.3431 138.737 70.1853 140.741 72.781 143.354C79.4077 150.026 90.4741 147.916 94.3828 139.236C95.4375 136.893 95.5541 136.197 95.3803 133.296C95.1445 129.366 94.098 127.072 91.3086 124.37C87.7449 120.917 82.1564 119.804 77.4505 121.608ZM106.527 124.456L100.892 128.114L100.165 131.222C99.5374 133.905 99.4087 138.196 99.2218 162.63C99.0575 184.125 98.8395 192.54 98.315 197.627C97.9357 201.31 97.5178 204.664 97.3869 205.08C97.1654 205.782 97.7532 205.836 105.686 205.836H114.224L113.965 204.215C112.692 196.257 112.596 192.949 112.596 157.337C112.596 137.197 112.498 120.737 112.379 120.759C112.26 120.78 109.626 122.444 106.527 124.456ZM28.8695 123.513C27.6046 124.396 26.5474 126.805 26.5586 128.778C26.5695 130.661 27.8868 133.852 29.2523 135.302C30.6745 136.811 30.8189 136.479 29.9077 133.789C28.7351 130.329 28.5305 127.38 29.293 124.932C29.6446 123.804 29.8969 122.88 29.8544 122.88C29.8115 122.88 29.3685 123.165 28.8695 123.513ZM79.0037 127.025C75.7508 128.431 74.13 130.899 74.1716 134.383C74.2276 139.051 77.5125 142.323 82.143 142.323C84.3949 142.323 87.223 140.978 88.4502 139.323C93.378 132.68 86.5342 123.769 79.0037 127.025ZM79.0418 129.609C78.3127 130.22 77.4982 131.445 77.232 132.33C76.5931 134.455 77.5337 136.786 79.5165 137.991C84.1968 140.835 89.3536 136.268 87.0132 131.351C85.6265 128.439 81.5097 127.539 79.0418 129.609ZM14.2043 134.255C12.1236 137.419 11.6923 141.717 13.1366 144.89C15.4293 149.928 19.3606 152.68 24.2733 152.688C25.7636 152.69 26.9826 152.511 26.9826 152.289C26.9826 152.068 26.4203 151.488 25.7333 151C24.301 149.983 20.3086 144.853 18.488 141.689C17.8087 140.508 16.7393 138.091 16.1108 136.317L14.9686 133.092L14.2043 134.255ZM71.4606 148.514C71.1425 149.03 69.5511 151.882 67.9247 154.852C58.1158 172.765 42.9521 197.032 36.4 205.304C36.0515 205.744 37.9059 205.829 45.82 205.736L55.6744 205.62L57.0828 202.163C60.3712 194.093 72.6631 171.419 82.5301 155.221C83.9268 152.928 85.0694 150.947 85.0694 150.819C85.0694 150.691 84.3871 150.696 83.5531 150.831C81.3623 151.186 76.9754 150.221 74.3281 148.803L72.0393 147.576L71.4606 148.514Z"
                                                        fill="#0072B1"
                                                    />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="content_area">
                                            <div class="content">
                                                <h1>No Result</h1>
                                                <p>
                                                    There are sadly no experts in this area or sector currently.
                                                    Please widen your search to give youa better result. You can
                                                    also contact our help team and we would do our best to find
                                                    you anexpert within 72 hours.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="buttons_area">
                                            {{-- <button class="wide-search-btn">Widen Search</button> --}}
                                            <button class="btn contact-team-btn" data-bs-target="#online-user"
                                                    data-bs-toggle="modal">Contact Team
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <!-- CARD SECTION END HERE -->
                    <div class="demo" id="pagination_main">

                        @if ($gigs->hasPages())
                            <nav class="pagination-outer" aria-label="Page navigation">
                                <ul class="pagination">
                                    {{-- Previous Page Link --}}
                                    @if ($gigs->onFirstPage())
                                        <li class="page-item disabled" aria-disabled="true"
                                            aria-label="@lang('pagination.previous')">
                                            <span class="page-link" aria-hidden="true">«</span>

                                        </li>

                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $gigs->previousPageUrl() }}" rel="prev"
                                               aria-label="@lang('pagination.previous')">
                                                <span aria-hidden="true">«</span>
                                            </a>
                                        </li>

                                    @endif

                                    {{-- Pagination Elements --}}
                                    @php
                                        $start = max($gigs->currentPage() - 2, 1);
        $end = min($gigs->currentPage() + 2, $gigs->lastPage());
                                    @endphp

                                    @for ($i = $start; $i <= $end; $i++)
                                        @if ($i == $gigs->currentPage())
                                            <li class="page-item active" aria-current="page"><a
                                                    class="page-link">{{ $i }}</a></li>
                                        @else
                                            <li class="page-item "><a class="page-link"
                                                                      href="{{ $gigs->url($i) }}">{{ $i }}</a></li>
                                        @endif
                                    @endfor

                                    {{-- Next Page Link --}}
                                    @if ($gigs->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $gigs->nextPageUrl() }}" rel="next"
                                               aria-label="@lang('pagination.next')">
                                                »
                                            </a>
                                        </li>

                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link" aria-hidden="true">»</span>

                                        </li>

                                    @endif
                                </ul>
                            </nav>
                        @endif
                    </div>
                </div>
                <div class="tab-pane fade" id="profile0" role="tabpanel" aria-labelledby="profile-tab0">
                    <!-- ========================  OUR EXPERTS SECTION START HERE ======================================== -->
                    <div class="container-fluid expert-sec">
                        <div class="container p-0">
                            <!-- CARD SECTION START HERE -->
                            <div class="row">

                                {{-- <div class="col-lg-3 col-md-6 col-12">
                  <div class="main-Dream-card">
                      <div class="card dream-Card">
                          <div class="dream-card-upper-section">
                              <img src="assets/seller-listing-new/asset/img/card-main-img.png" alt="">
                              <div class="card-img-overlay overlay-inner">
                                  <p>
                                      Top Seller
                                  </p>
                                  <span id=heart15>
                                      <i class="fa fa-heart-o" aria-hidden="true"></i>
                                  </span>
                              </div>
                          </div>
                          <a href="#" style="text-decoration: none;">
                              <div class="dream-card-dawon-section" type="button" data-bs-toggle="offcanvas" data-bs-target="#inline-person" aria-controls="offcanvasRight">
                                  <div class="dream-Card-inner-profile">
                                      <img src="assets/seller-listing-new/asset/img/inner-profile.png" alt="">
                                      <i class="fa-solid fa-check tick"></i>
                                  </div>
                                  <p class="servise-bener">In-Person Services</p>
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
                                      <img data-toggle="tooltip" title="In Person-Service" src="assets/seller-listing-new/asset/img/globe.png" style="height: 25px; width: 25px;" alt="">
                                      <!-- <i class="fa-solid fa-globe"></i> -->
                                  </div>
                              </div>
                      </div>
                  </div>
                  </a>
              </div> --}}
                            </div>
                        </div>
                    </div>
                    <!-- CARD SECTION END HERE -->

                </div>
                <div class="tab-pane fade" id="contact0" role="tabpanel" aria-labelledby="contact-tab0">
                    <!-- ========================  OUR EXPERTS SECTION START HERE ======================================== -->
                    <div class="container-fluid p-0 expert-sec">
                        <div class="container p-0">
                            <!-- CARD SECTION START HERE -->
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="main-Dream-card">
                                        <div class="card dream-Card">
                                            <div class="dream-card-upper-section">
                                                <img src="assets/seller-listing-new/asset/img/card-main-img.png" alt="">
                                                <div class="card-img-overlay overlay-inner">
                                                    <p>
                                                        Top Seller
                                                    </p>
                                                    <span id=heart16>
                                      <i class="fa fa-heart-o" aria-hidden="true"></i>
                                  </span>
                                                </div>
                                            </div>
                                            <a href="#" style="text-decoration: none;">
                                                <div class="dream-card-dawon-section" type="button"
                                                     data-bs-toggle="offcanvas" data-bs-target="#online-person"
                                                     aria-controls="offcanvasRight">
                                                    <div class="dream-Card-inner-profile">
                                                        <img src="assets/seller-listing-new/asset/img/inner-profile.png"
                                                             alt="">
                                                        <i class="fa-solid fa-check tick"></i>
                                                    </div>
                                                    <p class="servise-bener">Online Services</p>
                                                    <h5 class="dream-Card-name">
                                                        Usama A.
                                                    </h5>
                                                    <p class="Dev">Developer</p>
                                                    <p class="about-teaching">I will teach you how to build an amazing
                                                        website</p>
                                                    <span class="card-rat">
                                      <i class="fa-solid fa-star"></i> &nbsp; (5.0)
                                  </span>
                                                    <div class="card-last">
                                                        <span>Starting at $5</span>
                                                        <!-- word img -->
                                                        <img data-toggle="tooltip" title="In Person-Service"
                                                             src="assets/seller-listing-new/asset/img/globe.png"
                                                             style="height: 25px; width: 25px;" alt="">
                                                        <!-- <i class="fa-solid fa-globe"></i> -->
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="main-Dream-card">
                                        <div class="card dream-Card">
                                            <div class="dream-card-upper-section">
                                                <img src="assets/seller-listing-new/asset/img/card-main-img.png" alt="">
                                                <div class="card-img-overlay overlay-inner">
                                                    <p>
                                                        Top Seller
                                                    </p>
                                                    <span id=heart17>
                                      <i class="fa fa-heart-o" aria-hidden="true"></i>
                                  </span>
                                                </div>
                                            </div>
                                            <a href="#" style="text-decoration: none;">
                                                <div class="dream-card-dawon-section" type="button"
                                                     data-bs-toggle="offcanvas" data-bs-target="#inline-person"
                                                     aria-controls="offcanvasRight">
                                                    <div class="dream-Card-inner-profile">
                                                        <img src="assets/seller-listing-new/asset/img/inner-profile.png"
                                                             alt="">
                                                        <i class="fa-solid fa-check tick"></i>
                                                    </div>
                                                    <p class="servise-bener">In-Person Services</p>
                                                    <h5 class="dream-Card-name">
                                                        Usama A.
                                                    </h5>
                                                    <p class="Dev">Developer</p>
                                                    <p class="about-teaching">I will teach you how to build an amazing
                                                        website</p>
                                                    <span class="card-rat">
                                      <i class="fa-solid fa-star"></i> &nbsp; (5.0)
                                  </span>
                                                    <div class="card-last">
                                                        <span>Starting at $5</span>
                                                        <!-- word img -->
                                                        <img data-toggle="tooltip" title="In Person-Service"
                                                             src="assets/seller-listing-new/asset/img/handshake.png"
                                                             style="height: 28px; width: 28px;" alt="">
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="main-Dream-card">
                                        <div class="card dream-Card">
                                            <div class="dream-card-upper-section">
                                                <img src="assets/seller-listing-new/asset/img/card-main-img.png" alt="">
                                                <div class="card-img-overlay overlay-inner">
                                                    <p>
                                                        Top Seller
                                                    </p>
                                                    <span id=heart18>
                                      <i class="fa fa-heart-o" aria-hidden="true"></i>
                                  </span>
                                                </div>
                                            </div>
                                            <a href="#" style="text-decoration: none;">
                                                <div class="dream-card-dawon-section" type="button"
                                                     data-bs-toggle="offcanvas" data-bs-target="#online-person"
                                                     aria-controls="offcanvasRight">
                                                    <div class="dream-Card-inner-profile">
                                                        <img src="assets/seller-listing-new/asset/img/inner-profile.png"
                                                             alt="">
                                                        <i class="fa-solid fa-check tick"></i>
                                                    </div>
                                                    <p class="servise-bener">Online Services</p>
                                                    <h5 class="dream-Card-name">
                                                        Usama A.
                                                    </h5>
                                                    <p class="Dev">Developer</p>
                                                    <p class="about-teaching">I will teach you how to build an amazing
                                                        website</p>
                                                    <span class="card-rat">
                                      <i class="fa-solid fa-star"></i> &nbsp; (5.0)
                                  </span>
                                                    <div class="card-last">
                                                        <span>Starting at $5</span>
                                                        <!-- word img -->
                                                        <img data-toggle="tooltip" title="In Person-Service"
                                                             src="assets/seller-listing-new/asset/img/globe.png"
                                                             style="height: 25px; width: 25px;" alt="">
                                                        <!-- <i class="fa-solid fa-globe"></i> -->
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="main-Dream-card">
                                        <div class="card dream-Card">
                                            <div class="dream-card-upper-section">
                                                <img src="assets/seller-listing-new/asset/img/card-main-img.png" alt="">
                                                <div class="card-img-overlay overlay-inner">
                                                    <p>
                                                        Top Seller
                                                    </p>
                                                    <span id=heart19>
                                      <i class="fa fa-heart-o" aria-hidden="true"></i>
                                  </span>
                                                </div>
                                            </div>
                                            <a href="#" style="text-decoration: none;">
                                                <div class="dream-card-dawon-section" type="button"
                                                     data-bs-toggle="offcanvas" data-bs-target="#inline-person"
                                                     aria-controls="offcanvasRight">
                                                    <div class="dream-Card-inner-profile">
                                                        <img src="assets/seller-listing-new/asset/img/inner-profile.png"
                                                             alt="">
                                                        <i class="fa-solid fa-check tick"></i>
                                                    </div>
                                                    <p class="servise-bener">In-Person Services</p>
                                                    <h5 class="dream-Card-name">
                                                        Usama A.
                                                    </h5>
                                                    <p class="Dev">Developer</p>
                                                    <p class="about-teaching">I will teach you how to build an amazing
                                                        website</p>
                                                    <span class="card-rat">
                                      <i class="fa-solid fa-star"></i> &nbsp; (5.0)
                                  </span>
                                                    <div class="card-last">
                                                        <span>Starting at $5</span>
                                                        <!-- word img -->
                                                        <img data-toggle="tooltip" title="In Person-Service"
                                                             src="assets/seller-listing-new/asset/img/globe.png"
                                                             style="height: 25px; width: 25px;" alt="">
                                                        <!-- <i class="fa-solid fa-globe"></i> -->
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="main-Dream-card">
                                        <div class="card dream-Card">
                                            <div class="dream-card-upper-section">
                                                <img src="assets/seller-listing-new/asset/img/card-main-img.png" alt="">
                                                <div class="card-img-overlay overlay-inner">
                                                    <p>
                                                        Top Seller
                                                    </p>
                                                    <span id=heart20>
                                      <i class="fa fa-heart-o" aria-hidden="true"></i>
                                  </span>
                                                </div>
                                            </div>
                                            <a href="#" style="text-decoration: none;">
                                                <div class="dream-card-dawon-section" type="button"
                                                     data-bs-toggle="offcanvas" data-bs-target="#inline-person"
                                                     aria-controls="offcanvasRight">
                                                    <div class="dream-Card-inner-profile">
                                                        <img src="assets/seller-listing-new/asset/img/inner-profile.png"
                                                             alt="">
                                                        <i class="fa-solid fa-check tick"></i>
                                                    </div>
                                                    <p class="servise-bener">Online Services</p>
                                                    <h5 class="dream-Card-name">
                                                        Usama A.
                                                    </h5>
                                                    <p class="Dev">Developer</p>
                                                    <p class="about-teaching">I will teach you how to build an amazing
                                                        website</p>
                                                    <span class="card-rat">
                                      <i class="fa-solid fa-star"></i> &nbsp; (5.0)
                                  </span>
                                                    <div class="card-last">
                                                        <span>Starting at $5</span>
                                                        <!-- word img -->
                                                        <img data-toggle="tooltip" title="In Person-Service"
                                                             src="assets/seller-listing-new/asset/img/globe.png"
                                                             style="height: 25px; width: 25px;" alt="">
                                                        <!-- <i class="fa-solid fa-globe"></i> -->
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="main-Dream-card">
                                        <div class="card dream-Card">
                                            <div class="dream-card-upper-section">
                                                <img src="assets/seller-listing-new/asset/img/card-main-img.png" alt="">
                                                <div class="card-img-overlay overlay-inner">
                                                    <p>
                                                        Top Seller
                                                    </p>
                                                    <span id=heart21>
                                      <i class="fa fa-heart-o" aria-hidden="true"></i>
                                  </span>
                                                </div>
                                            </div>
                                            <a href="#" style="text-decoration: none;">
                                                <div class="dream-card-dawon-section" type="button"
                                                     data-bs-toggle="offcanvas" data-bs-target="#online-person"
                                                     aria-controls="offcanvasRight">
                                                    <div class="dream-Card-inner-profile">
                                                        <img src="assets/seller-listing-new/asset/img/inner-profile.png"
                                                             alt="">
                                                        <i class="fa-solid fa-check tick"></i>
                                                    </div>
                                                    <p class="servise-bener">In-Person Services</p>
                                                    <h5 class="dream-Card-name">
                                                        Usama A.
                                                    </h5>
                                                    <p class="Dev">Developer</p>
                                                    <p class="about-teaching">I will teach you how to build an amazing
                                                        website</p>
                                                    <span class="card-rat">
                                      <i class="fa-solid fa-star"></i> &nbsp; (5.0)
                                  </span>
                                                    <div class="card-last">
                                                        <span>Starting at $5</span>
                                                        <!-- word img -->
                                                        <img data-toggle="tooltip" title="In Person-Service"
                                                             src="assets/seller-listing-new/asset/img/handshake.png"
                                                             style="height: 28px; width: 28px;" alt="">
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="main-Dream-card">
                                        <div class="card dream-Card">
                                            <div class="dream-card-upper-section">
                                                <img src="assets/seller-listing-new/asset/img/card-main-img.png" alt="">
                                                <div class="card-img-overlay overlay-inner">
                                                    <p>
                                                        Top Seller
                                                    </p>
                                                    <span id=heart22>
                                      <i class="fa fa-heart-o" aria-hidden="true"></i>
                                  </span>
                                                </div>
                                            </div>
                                            <a href="#" style="text-decoration: none;">
                                                <div class="dream-card-dawon-section" type="button"
                                                     data-bs-toggle="offcanvas" data-bs-target="#inline-person"
                                                     aria-controls="offcanvasRight">
                                                    <div class="dream-Card-inner-profile">
                                                        <img src="assets/seller-listing-new/asset/img/inner-profile.png"
                                                             alt="">
                                                        <i class="fa-solid fa-check tick"></i>
                                                    </div>
                                                    <p class="servise-bener">Online Services</p>
                                                    <h5 class="dream-Card-name">
                                                        Usama A.
                                                    </h5>
                                                    <p class="Dev">Developer</p>
                                                    <p class="about-teaching">I will teach you how to build an amazing
                                                        website</p>
                                                    <span class="card-rat">
                                      <i class="fa-solid fa-star"></i> &nbsp; (5.0)
                                  </span>
                                                    <div class="card-last">
                                                        <span>Starting at $5</span>
                                                        <!-- word img -->
                                                        <img data-toggle="tooltip" title="In Person-Service"
                                                             src="assets/seller-listing-new/asset/img/globe.png"
                                                             style="height: 25px; width: 25px;" alt="">
                                                        <!-- <i class="fa-solid fa-globe"></i> -->
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="main-Dream-card">
                                        <div class="card dream-Card">
                                            <div class="dream-card-upper-section">
                                                <img src="assets/seller-listing-new/asset/img/card-main-img.png" alt="">
                                                <div class="card-img-overlay overlay-inner">
                                                    <p>
                                                        Top Seller
                                                    </p>
                                                    <span id=heart23>
                                      <i class="fa fa-heart-o" aria-hidden="true"></i>
                                  </span>
                                                </div>
                                            </div>
                                            <a href="#" style="text-decoration: none;">
                                                <div class="dream-card-dawon-section" type="button"
                                                     data-bs-toggle="offcanvas" data-bs-target="#online-person"
                                                     aria-controls="offcanvasRight">
                                                    <div class="dream-Card-inner-profile">
                                                        <img src="assets/seller-listing-new/asset/img/inner-profile.png"
                                                             alt="">
                                                        <i class="fa-solid fa-check tick"></i>
                                                    </div>
                                                    <p class="servise-bener">In-Person Services</p>
                                                    <h5 class="dream-Card-name">
                                                        Usama A.
                                                    </h5>
                                                    <p class="Dev">Developer</p>
                                                    <p class="about-teaching">I will teach you how to build an amazing
                                                        website</p>
                                                    <span class="card-rat">
                                      <i class="fa-solid fa-star"></i> &nbsp; (5.0)
                                  </span>
                                                    <div class="card-last">
                                                        <span>Starting at $5</span>
                                                        <!-- word img -->
                                                        <img data-toggle="tooltip" title="In Person-Service"
                                                             src="assets/seller-listing-new/asset/img/globe.png"
                                                             style="height: 25px; width: 25px;" alt="">
                                                        <!-- <i class="fa-solid fa-globe"></i> -->
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- CARD SECTION END HERE -->

                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============ Offcanvas Page Start From Here -->
<div class="offcanvas offcanvas-end services-offcanvas" tabindex="-1" id="offcanvasRight"
     aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header offcanvas-heading">
        <h5 id="offcanvasRightLabel">Quick Booking</h5>
    </div>
    <div class="offcanvas-body services-details">
        <div class="row">
            <div class="col-md-1">
                <div class="profile">
                    <img src="assets/seller-listing-new/asset/img/profile.png" alt=""/>
                </div>
            </div>
            <div class="col-md-11">
                <div class="profile-det">
                    <h5>Usama A.</h5>
                    <p class="graphic">Graphic Designer</p>
                    <p class="location">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path
                                d="M10.0034 6.45817C9.34035 6.45817 8.70447 6.72156 8.23563 7.1904C7.76679 7.65924 7.5034 8.29513 7.5034 8.95817C7.5034 9.62121 7.76679 10.2571 8.23563 10.7259C8.70447 11.1948 9.34035 11.4582 10.0034 11.4582C10.6664 11.4582 11.3023 11.1948 11.7712 10.7259C12.24 10.2571 12.5034 9.62121 12.5034 8.95817C12.5034 8.29513 12.24 7.65924 11.7712 7.1904C11.3023 6.72156 10.6664 6.45817 10.0034 6.45817ZM8.54506 8.95817C8.54506 8.5714 8.69871 8.20046 8.9722 7.92697C9.24569 7.65348 9.61662 7.49984 10.0034 7.49984C10.3902 7.49984 10.7611 7.65348 11.0346 7.92697C11.3081 8.20046 11.4617 8.5714 11.4617 8.95817C11.4617 9.34494 11.3081 9.71588 11.0346 9.98937C10.7611 10.2629 10.3902 10.4165 10.0034 10.4165C9.61662 10.4165 9.24569 10.2629 8.9722 9.98937C8.69871 9.71588 8.54506 9.34494 8.54506 8.95817ZM15.418 13.3332L11.2146 17.7957C11.0588 17.9611 10.8708 18.093 10.6621 18.1831C10.4535 18.2732 10.2286 18.3197 10.0013 18.3197C9.77402 18.3197 9.54914 18.2732 9.34048 18.1831C9.13182 18.093 8.9438 17.9611 8.78798 17.7957L4.58465 13.3332H4.60048L4.5934 13.3248L4.58465 13.3144C3.50577 12.0384 2.91511 10.4208 2.91798 8.74984C2.91798 4.83775 6.08923 1.6665 10.0013 1.6665C13.9134 1.6665 17.0846 4.83775 17.0846 8.74984C17.0875 10.4208 16.4969 12.0384 15.418 13.3144L15.4092 13.3248L15.4021 13.3332H15.418ZM14.6084 12.6586C15.5368 11.5681 16.0455 10.182 16.043 8.74984C16.043 5.41317 13.338 2.70817 10.0013 2.70817C6.66465 2.70817 3.95965 5.41317 3.95965 8.74984C3.95704 10.182 4.46576 11.5681 5.39423 12.6586L5.52256 12.8098L9.54631 17.0811C9.60475 17.1431 9.67525 17.1926 9.7535 17.2264C9.83175 17.2602 9.91608 17.2776 10.0013 17.2776C10.0865 17.2776 10.1709 17.2602 10.2491 17.2264C10.3274 17.1926 10.3979 17.1431 10.4563 17.0811L14.4801 12.8098L14.6084 12.6586Z"
                                fill="#7D7D7D"/>
                        </svg>
                        Huston, London, United Kingdom
                    </p>
                </div>
            </div>
            <div class="col-md-12">
                <button class="btn view-profile">View full profile</button>
            </div>
            <div class="col-md-12">
                <div class="booking-det">
                    <h5>Title : <span>I would help you build an amazing website</span></h5>
                    <h5>Service & Payment Type : <span class="in-person">In-Person</span><span> Freelance | Group Booking | Subscription</span>
                    </h5>
                    <h5>Price : <span>From $10</span></h5>
                    <h5>Delivery & Completion Date : <span>Within 15 days each month</span></h5>
                    <h5>Max. Travel Distance : <span>Able to travel up to 10 miles from London, United Kingdom</span>
                    </h5>
                    <h5>Description :</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vitae ut tellus quis a euismod ut nisl,
                        quis. Tristique bibendum morbi vel vitae ultrices donec accumsan. Tincidunt eget habitant
                        pellentesque id purus. Hendrerit varius sapien, nunc, turpis augue arcu venenatis. At sed
                        consectetur in viverra duis tincidunt diam.
                        Fames diam, interdum fringilla venenatis sed mi quis. Convallis enim, sit pharetra fermentum
                        pellentesque eros. Tortor cras nulla sit dui tincidunt platea mauris. Enim, risus non posuere
                        venenatis non quis id nec. Consectetur vitae gravida ut morbi tellus arcu. In pretium in
                        malesuada neque. At mauris massa magna mauris, </p>
                    <h5>Requirements :</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vitae ut tellus quis a euismod ut nisl,
                        quis. Tristique bibendum morbi vel vitae ultrices donec accumsan. Tincidunt eget habitant
                        pellentesque id purus. Hendrerit varius sapien, nunc, turpis augue arcu venenatis. At sed
                        consectetur in viverra duis tincidunt diam.</p>
                    <h5>Booking & Cancelation Details :</h5>
                    <p>After booking a class or activity, you will be emailed instructions on how to attend the
                        experience on Zoom.
                        You can cancel or reschedule a booking up to 24 hours before the experience starts for free</p>
                    <div class="portfolio-sec">
                        <h5>Portfolio</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <a href="assets/seller-listing-new/asset/img/portfolioimg (1).png"
                                   data-fancybox="gallery" data-caption="">
                                    <img src="assets/seller-listing-new/asset/img/portfolioimg (1).png"/>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="assets/seller-listing-new/asset/img/portfolioimg (2).png"
                                   data-fancybox="gallery" data-caption="">
                                    <img src="assets/seller-listing-new/asset/img/portfolioimg (2).png"/>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="assets/seller-listing-new/asset/img/portfolioimg (3).png"
                                   data-fancybox="gallery" data-caption="">
                                    <img src="assets/seller-listing-new/asset/img/portfolioimg (3).png"/>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="assets/seller-listing-new/asset/img/portfolioimg (4).png"
                                   data-fancybox="gallery" data-caption="">
                                    <img src="assets/seller-listing-new/asset/img/portfolioimg (4).png"/>
                                </a>
                            </div>
                        </div> <!-- row / end -->
                    </div>
                    <div class="portfolio-form">
                        <form class="row g-3">
                            <div class="col-md-4">
                                <label for="select">
                                    Select Group Type
                                </label><br>
                                <select id="select1">
                                    <option value="b">Public Group</option>
                                    <option value="c">Private Group</option>
                                </select>
                            </div>
                            <div class="col-md-4 guest">
                                <label for="inputPassword4" class="form-label">Select Number of Guest</label>
                                <input type="number" class="form-control" id="inputPassword4" placeholder="0">
                            </div>
                            <div class="col-md-4 guest">
                                <input type="number" class="form-control numberof-childs" id="inputPassword5"
                                       placeholder="0">
                            </div>
                            <div class="col-md-6 frequency">
                                <label for="inputEmail4" class="form-label">Select Class Frequency</label>
                                <input type="text" class="form-control" id="inputEmail41"
                                       placeholder="Select Class Frequency">
                            </div>
                            <div class="col-md-6 multiple-val-input multiemail">
                                <label for="inputEmail4" class="form-label">Enter Guests Emails for Class
                                    Invitation</label> <br>
                                <ul>
                                    <input type="text" class="emails" placeholder="Email">
                                    <span class="input_hidden" style="padding-left:20px;padding-right:20px;"></span>
                                </ul>
                            </div>
                            <div class="col-md-12">
                                <label for="inputEmail4" class="form-label">How far away are you from seller
                                    location</label>
                                <input type="email" class="form-control" id="inputEmail42" placeholder="7 mile">
                            </div>
                            <div class="col-md-12 field_wrapper date-time">
                                <div>
                                    <label for="inputEmail4" class="form-label">Select Date & Time</label>
                                    <input class="add-input" type="text" name="field_name[]" value=""
                                           placeholder="Select Date & Time"/>
                                    <a href="javascript:void(0);" class="add_button" title="Add field"><img
                                            src="assets/seller-listing-new/asset/img/add-input.svg"/></a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-md-5 calender">

                        </div>
                        <div class="col-md-7 booking-notes">
                            <h5>Notes</h5>
                            <ul class="p-0">
                                <li>To ensure that your payments are protected under our terms, never transfer money or
                                    send messages outside of the Dreamcrowd platform.
                                </li>
                                <br>
                                <li>Payments made outside of our platform are not eligible for disputes & refunds under
                                    our terms.
                                </li>
                                <br>
                                <li>Please send us a report if you have been asked by a Creator to communicate or pay
                                    outside of our platform.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="amount-sec">
        <div class="row">
            <div class="col-md-12">
                <p class="float-start">Total Amount: <span>$55.0</span></p>
                <div class="float-end">
                    <a href="#" type="button" class="btn contact-btn" data-bs-toggle="modal"
                       data-bs-target="#exampleModal1">Contact Us</a>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel1"
                         aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content contact-modal">
                                <div class="modal-body p-0">
                                    <div class="row">
                                        <div class="col-md-12 name-label">
                                            <label for="inputEmail4" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="inputEmail43"
                                                   placeholder="Usama Aslam">
                                        </div>
                                        <div class="col-md-12 name-label">
                                            <label for="inputEmail4" class="form-label label-sec">Email</label>
                                            <input type="email" class="form-control" id="inputEmail44"
                                                   placeholder="usamaaslam@gmail.com">
                                        </div>
                                        <div class="col-md-12 name-label">
                                            <label for="inputEmail4" class="form-label label-sec">Country</label>
                                            <input type="email" class="form-control" id="inputEmail45"
                                                   placeholder="Your Country">
                                        </div>
                                        <div class="col-md-12 name-label">
                                            <label for="inputEmail4" class="form-label label-sec">City</label>
                                            <input type="email" class="form-control" id="inputEmail46"
                                                   placeholder="Your City">
                                        </div>
                                        <div class="col-md-12 name-label">
                                            <label for="inputEmail4" class="form-label label-sec">Your Area</label>
                                            <input type="email" class="form-control" id="inputEmail47"
                                                   placeholder="Your Area">
                                        </div>
                                        <div class="col-md-12 name-label">
                                            <label for="inputEmail4" class="form-label label-sec">Type of expert
                                                needed</label>
                                            <select name="" id="">
                                                <option value="">Type of expert needed</option>
                                                <option value="">Class</option>
                                                <option value="">Freelance</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 name-label">
                                            <label for="inputEmail4" class="form-label label-sec">Type of
                                                service</label> <br>
                                            <select name="" id="">
                                                <option value="">Type of service</option>
                                                <option value="">Online Service</option>
                                                <option value="">In-person Service</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 check-services">
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea4" class="label-sec">Describe the
                                                    help you require</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea4" rows="3"
                                                          placeholder="Describe the help you require..."></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12 booking-buttons">
                                            <button type="submit" class="btn request-booking">Submit</button>
                                            <button type="button" class="btn booking-cancel" data-bs-dismiss="modal">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="../Public-site/payment.html" class="btn booking-btn">Complete Booking</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============ Offcanvas Page Ended From Here ========== -->
<!-- Online User Modal start from here -->
<div
    class="modal fade"
    id="online-user"
    aria-hidden="true"
    aria-labelledby="exampleModalToggleLabel"
    tabindex="-1"
>
    <div class="modal-dialog modal-dialog-centered mt-5">
        <div class="modal-content mt-2">
            <div class="model_popup">
                <div class="row">
                    <div class="col-md-6">
                        <label for="car" class="form-label">Name</label>
                        <input
                            class="form-control"
                            list="datalistOptions"
                            id="car"
                            placeholder="Usama Aslam"
                        />
                    </div>
                    <div class="col-md-6">
                        <label for="car" class="form-label">Email</label>
                        <input
                            class="form-control"
                            list="datalistOptions"
                            id="car1"
                            placeholder="Usama Aslam"
                        />
                    </div>
                </div>
                <label for="car" class="form-label">Country</label>
                <input
                    class="form-control"
                    list="datalistOptions"
                    id="car2"
                    placeholder="Usama Aslam"
                />
                <div class="row">
                    <div class="col-md-6">
                        <label for="car" class="form-label">City</label>
                        <input
                            class="form-control"
                            list="datalistOptions"
                            id="car3"
                            placeholder="Usama Aslam"
                        />
                    </div>
                    <div class="col-md-6">
                        <label for="car" class="form-label">Area</label>
                        <input
                            class="form-control"
                            list="datalistOptions"
                            id="car4"
                            placeholder="Usama Aslam"
                        />
                    </div>
                </div>
                <label for="car" class="form-label">Expert Needed</label>
                <input
                    class="form-control"
                    list="datalistOptions"
                    id="car5"
                    placeholder="Usama Aslam"
                />
                <label for="car" class="form-label">Service Type</label>
                <select name="" id="" class="form-control">
                    <option value="">Online Service</option>
                    <option value="">In-person Service</option>
                </select>
                <label for="car" class="form-label"
                >Describe the help you require</label
                >
                <textarea
                    class="form-control"
                    list="datalistOptions"
                    id="car6"
                    placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged."
                ></textarea>
                <button type="button" class="cancel-button">Cancel</button>
                <button type="button" class="submit-button">Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- in-person service modal start from here -->
<div
    class="modal fade"
    id="in-person-service"
    aria-hidden="true"
    aria-labelledby="exampleModalToggleLabel"
    tabindex="-1"
>
    <div class="modal-dialog modal-dialog-centered mt-5">
        <div class="modal-content mt-2">
            <div class="model_popup">
                <div class="row">
                    <div class="col-md-6">
                        <label for="car" class="form-label">Name</label>
                        <input
                            class="form-control"
                            list="datalistOptions"
                            id="car7"
                            placeholder="Usama Aslam"
                        />
                    </div>
                    <div class="col-md-6">
                        <label for="car" class="form-label">Email</label>
                        <input
                            class="form-control"
                            list="datalistOptions"
                            id="car8"
                            placeholder="Usama Aslam"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="car" class="form-label">Country</label>
                        <input
                            class="form-control"
                            list="datalistOptions"
                            id="car9"
                            placeholder="Usama Aslam"
                        />
                    </div>
                    <div class="col-md-6">
                        <label for="car" class="form-label">City</label>
                        <input
                            class="form-control"
                            list="datalistOptions"
                            id="car10"
                            placeholder="Usama Aslam"
                        />
                    </div>
                </div>
                <label for="car" class="form-label">Expert Needed</label>
                <input
                    class="form-control"
                    list="datalistOptions"
                    id="car11"
                    placeholder="Usama Aslam"
                />
                <label for="car" class="form-label">Service Type</label>
                <select name="" id="" class="form-control">
                    <option value="">Online Service</option>
                    <option value="">In-person Service</option>
                </select>
                <label for="car" class="form-label"
                >Describe the help you require</label
                >
                <textarea
                    class="form-control"
                    list="datalistOptions"
                    id="car12"
                    placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged."
                ></textarea>
                <button type="button" class="cancel-button">Cancel</button>
                <button type="button" class="submit-button">Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- ============================= FOOTER SECTION START HERE ===================================== -->
<x-public-footer/>
<!-- =============================== FOOTER SECTION END HERE ===================================== -->
<script src="assets/seller-listing-new/libs/jquery/jquery.js"></script>
<script src="assets/seller-listing-new/libs/datatable/js/datatable.js"></script>
<script src="assets/seller-listing-new/libs/datatable/js/datatablebootstrap.js"></script>
<script src="assets/seller-listing-new/libs/select2/js/select2.min.js"></script>
<script src="assets/seller-listing-new/libs/owl-carousel/js/owl.carousel.min.js"></script>
<script src="assets/seller-listing-new/libs/aos/js/aos.js"></script>
<script src="assets/seller-listing-new/asset/js/bootstrap.min.js"></script>
<script src="assets/seller-listing-new/asset/js/script.js"></script>
<script src="assets/seller-listing-new/asset/jquery.js"></script>
<script src="assets/seller-listing-new/asset/jquery.datetimepicker.full.min.js"></script>
<script>
    var timeSelected = false;

    function SetDate() {
        var selectedDateTime = $("#timedatePicker").val(); // Get selected DateTime

        // Remove time part if no time is selected
        if (!timeSelected) {
            selectedDateTime = selectedDateTime.split(" ")[0]; // ✅ Keep only the date part
        }
        $("#selectDateTime").val(selectedDateTime); // Store in hidden input
        $("#timedatePicker").datetimepicker('hide'); // Close picker on Apply button click


        SearchSellerListingSearch();

    }

    $(document).ready(function () {
        $("#timedatePicker").datetimepicker({
            step: 30,
            format: 'Y-m-d H:i',
            closeOnDateSelect: false, // ✅ Keep open when selecting a date
            closeOnTimeSelect: false, // ✅ Keep open when selecting a time
            minDate: 0, // ✅ Prevent past date selection
            validateOnBlur: false, // ✅ Prevent auto-filling time
            onShow: function () {
                // Ensure the button is not appended multiple times
                if ($(".xdsoft_datetimepicker").find("#applyDateTime").length === 0) {
                    $(".xdsoft_datetimepicker").append('<button id="applyDateTime" onclick="SetDate()" class="xdsoft_save_selected">Apply</button>');
                }
            },
            onSelectTime: function () {
                timeSelected = true; // ✅ Mark that the user selected a time
            }
        });


    });


</script>
<!-- offcanvas modals here -->
<!-- online-person canvas -->
<div id="quick-booking">
    <div
        class="offcanvas offcanvas-end services-offcanvas"
        tabindex="-1"
        id="online-person"
        aria-labelledby="offcanvasRightLabel"
    >
        <div class="offcanvas-header offcanvas-heading">
            <h5 id="offcanvasRightLabel">Quick Booking</h5>
        </div>
        <div class="offcanvas-body services-details">
            <div class="row">
                <div class="col-md-1">
                    <div class="profile">
                        <img src="assets/seller-listing-new/asset/img/personal-profile.png" alt=""/>
                    </div>
                </div>
                <div class="col-md-11">
                    <div class="profile-det">
                        <h5>Usama A.</h5>
                        <p class="graphic">Graphic Designer</p>
                        <p class="location">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="20"
                                height="20"
                                viewBox="0 0 20 20"
                                fill="none"
                            >
                                <path
                                    d="M10.0034 6.45817C9.34035 6.45817 8.70447 6.72156 8.23563 7.1904C7.76679 7.65924 7.5034 8.29513 7.5034 8.95817C7.5034 9.62121 7.76679 10.2571 8.23563 10.7259C8.70447 11.1948 9.34035 11.4582 10.0034 11.4582C10.6664 11.4582 11.3023 11.1948 11.7712 10.7259C12.24 10.2571 12.5034 9.62121 12.5034 8.95817C12.5034 8.29513 12.24 7.65924 11.7712 7.1904C11.3023 6.72156 10.6664 6.45817 10.0034 6.45817ZM8.54506 8.95817C8.54506 8.5714 8.69871 8.20046 8.9722 7.92697C9.24569 7.65348 9.61662 7.49984 10.0034 7.49984C10.3902 7.49984 10.7611 7.65348 11.0346 7.92697C11.3081 8.20046 11.4617 8.5714 11.4617 8.95817C11.4617 9.34494 11.3081 9.71588 11.0346 9.98937C10.7611 10.2629 10.3902 10.4165 10.0034 10.4165C9.61662 10.4165 9.24569 10.2629 8.9722 9.98937C8.69871 9.71588 8.54506 9.34494 8.54506 8.95817ZM15.418 13.3332L11.2146 17.7957C11.0588 17.9611 10.8708 18.093 10.6621 18.1831C10.4535 18.2732 10.2286 18.3197 10.0013 18.3197C9.77402 18.3197 9.54914 18.2732 9.34048 18.1831C9.13182 18.093 8.9438 17.9611 8.78798 17.7957L4.58465 13.3332H4.60048L4.5934 13.3248L4.58465 13.3144C3.50577 12.0384 2.91511 10.4208 2.91798 8.74984C2.91798 4.83775 6.08923 1.6665 10.0013 1.6665C13.9134 1.6665 17.0846 4.83775 17.0846 8.74984C17.0875 10.4208 16.4969 12.0384 15.418 13.3144L15.4092 13.3248L15.4021 13.3332H15.418ZM14.6084 12.6586C15.5368 11.5681 16.0455 10.182 16.043 8.74984C16.043 5.41317 13.338 2.70817 10.0013 2.70817C6.66465 2.70817 3.95965 5.41317 3.95965 8.74984C3.95704 10.182 4.46576 11.5681 5.39423 12.6586L5.52256 12.8098L9.54631 17.0811C9.60475 17.1431 9.67525 17.1926 9.7535 17.2264C9.83175 17.2602 9.91608 17.2776 10.0013 17.2776C10.0865 17.2776 10.1709 17.2602 10.2491 17.2264C10.3274 17.1926 10.3979 17.1431 10.4563 17.0811L14.4801 12.8098L14.6084 12.6586Z"
                                    fill="#7D7D7D"
                                />
                            </svg>
                            Huston, London, United Kingdom
                        </p>
                    </div>
                </div>
                <div class="col-md-12">
                    <button class="btn view-all-profile">View Full Profile</button>
                </div>
                <div class="col-md-12">
                    <div class="booking-det">
                        <h5>
                            Title : <span>I would help you build an amazing website</span>
                        </h5>
                        <h5>
                            Service & Payment Type : <span class="in-person">In-Person</span
                            ><span> Freelance | Group Booking | Subscription</span>
                        </h5>
                        <h5>Price : <span>From $10</span></h5>
                        <h5>
                            Delivery & Completion Date :
                            <span>Within 15 days each month</span>
                        </h5>
                        <h5>Description :</h5>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vitae ut
                            tellus quis a euismod ut nisl, quis. Tristique bibendum morbi vel
                            vitae ultrices donec accumsan. Tincidunt eget habitant
                            pellentesque id purus. Hendrerit varius sapien, nunc, turpis augue
                            arcu venenatis. At sed consectetur in viverra duis tincidunt diam.
                            Fames diam, interdum fringilla venenatis sed mi quis. Convallis
                            enim, sit pharetra fermentum pellentesque eros. Tortor cras nulla
                            sit dui tincidunt platea mauris. Enim, risus non posuere venenatis
                            non quis id nec. Consectetur vitae gravida ut morbi tellus arcu.
                            In pretium in malesuada neque. At mauris massa magna mauris,
                        </p>
                        <h5>Requirements :</h5>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vitae ut
                            tellus quis a euismod ut nisl, quis. Tristique bibendum morbi vel
                            vitae ultrices donec accumsan. Tincidunt eget habitant
                            pellentesque id purus. Hendrerit varius sapien, nunc, turpis augue
                            arcu venenatis. At sed consectetur in viverra duis tincidunt diam.
                        </p>
                        <h5>Booking & Cancelation Details :</h5>
                        <p>
                            After booking a class or activity, you will be emailed
                            instructions on how to attend the experience on Zoom. You can
                            cancel or reschedule a booking up to 24 hours before the
                            experience starts for free
                        </p>
                        <div class="portfolio-sec">
                            <h5>Portfolio</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <a
                                        href="assets/seller-listing-new/asset/img/portfolioimg (1).png"
                                        data-fancybox="gallery"
                                        data-caption=""
                                    >
                                        <img src="assets/seller-listing-new/asset/img/portfolioimg (1).png"/>
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a
                                        href="assets/seller-listing-new/asset/img/portfolioimg (2).png"
                                        data-fancybox="gallery"
                                        data-caption=""
                                    >
                                        <img src="assets/seller-listing-new/asset/img/portfolioimg (2).png"/>
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a
                                        href="assets/seller-listing-new/asset/img/portfolioimg (3).png"
                                        data-fancybox="gallery"
                                        data-caption=""
                                    >
                                        <img src="assets/seller-listing-new/asset/img/portfolioimg (3).png"/>
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a
                                        href="assets/seller-listing-new/asset/img/portfolioimg (4).png"
                                        data-fancybox="gallery"
                                        data-caption=""
                                    >
                                        <img src="assets/seller-listing-new/asset/img/portfolioimg (4).png"/>
                                    </a>
                                </div>
                            </div>
                            <!-- row / end -->
                        </div>
                        <div class="portfolio-form">
                            <form class="row g-3">
                                <div class="col-md-4 select-group">
                                    <label for="select"> Select Group Type </label><br/>
                                    <select id="select2" type="text">
                                        <option value="b">Public Group</option>
                                        <option value="c">Private Group</option>
                                    </select>
                                </div>
                                <div class="col-md-4 guest select-groups">
                                    <label for="inputPassword4" class="form-label"
                                    >Select Number of Guest</label
                                    >
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="inputPassword6"
                                        placeholder="0"
                                    />
                                </div>
                                <div class="col-md-4 guest select-groups input-sec">
                                    <input
                                        type="number"
                                        class="form-control numberof-childs"
                                        id="inputPassword7"
                                        placeholder="0"
                                    />
                                </div>
                                <div class="col-md-6 frequency">
                                    <label for="inputEmail4" class="form-label"
                                    >Select Class Frequency</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="inputEmail48"
                                        placeholder="Select Class Frequency"
                                    />
                                </div>
                                <div class="col-md-6 multiple-val-input multiemail">
                                    <label for="inputEmail4" class="form-label"
                                    >Enter Guests Emails for Class Invitation</label
                                    >
                                    <br/>
                                    <div class="col-sm-12 email-id-row">
                                        <div class="all-mail" id="all-mail-1"></div>
                                        <input type="text" name="email" class="enter-mail-id emails"
                                               id="enter-mail-id-1" placeholder="Enter the email id .."/>
                                    </div>
                                </div>
                                <div class="col-md-12 field_wrapper date-time">
                                    <div class="">
                                        <label for="inputEmail4" class="form-label">Select Date & Time</label>
                                        <input class="add-input" type="datetime-local" name="field_name[]" value=""
                                               placeholder="Select Date & Time"/>
                                        <a href="javascript:void(0);" class="add_button" title="Add field"><img
                                                src="assets/seller-listing-new/asset/img/add-input.svg"/></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-md-12 booking-notes">
                                <h5>Safety Notes</h5>
                                <ul class="p-0">
                                    <li>
                                        To ensure that your payments are protected under our terms,
                                        never transfer money or send messages outside of the
                                        Dreamcrowd platform.
                                    </li>
                                    <br/>
                                    <li>
                                        Payments made outside of our platform are not eligible for
                                        disputes & refunds under our terms.
                                    </li>
                                    <br/>
                                    <li>
                                        Do not provide your email address, telephone number or
                                        physical address to any seller. Only provide this
                                        information (if absolutely necessary) after you have made a
                                        payment to the seller.
                                    </li>
                                    <br/>
                                    <li>
                                        Nearby areas or landmarks nearby can be shared to give the
                                        seller an idea of how far they need to travel (This applies
                                        to in-person services only).
                                    </li>
                                    <br/>
                                    <li>
                                        Please send us a report if a seller has broken any of these
                                        safety terms or if you suspect that the seller is trying to
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="amount-sec">
            <div class="row">
                <div class="col-md-12">
                    <p class="float-start">Total Amount: <span>$55.0</span></p>
                    <div class="float-end">
                        <a
                            href="#"
                            type="button"
                            class="btn contact-btn"
                            data-bs-toggle="modal"
                            id="contact-us"
                            data-bs-target="#contact-me-modal"
                        >Contact Me</a
                        >

                        <a href="../Public-site/payment.html" class="btn booking-btn">Complete Booking</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- inline-person canvas -->
<div id="quick-booking">
    <div
        class="offcanvas offcanvas-end services-offcanvas"
        tabindex="-1"
        id="inline-person"
        aria-labelledby="offcanvasRightLabel"
    >
        <div class="offcanvas-header offcanvas-heading">
            <h5 id="offcanvasRightLabel">Quick Booking</h5>
        </div>
        <div class="offcanvas-body services-details">
            <div class="row">
                <div class="col-md-1">
                    <div class="profile">
                        <img src="assets/seller-listing-new/asset/img/personal-profile.png" alt=""/>
                    </div>
                </div>
                <div class="col-md-11">
                    <div class="profile-det">
                        <h5>Usama A.</h5>
                        <p class="graphic">Graphic Designer</p>
                        <p class="location">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="20"
                                height="20"
                                viewBox="0 0 20 20"
                                fill="none"
                            >
                                <path
                                    d="M10.0034 6.45817C9.34035 6.45817 8.70447 6.72156 8.23563 7.1904C7.76679 7.65924 7.5034 8.29513 7.5034 8.95817C7.5034 9.62121 7.76679 10.2571 8.23563 10.7259C8.70447 11.1948 9.34035 11.4582 10.0034 11.4582C10.6664 11.4582 11.3023 11.1948 11.7712 10.7259C12.24 10.2571 12.5034 9.62121 12.5034 8.95817C12.5034 8.29513 12.24 7.65924 11.7712 7.1904C11.3023 6.72156 10.6664 6.45817 10.0034 6.45817ZM8.54506 8.95817C8.54506 8.5714 8.69871 8.20046 8.9722 7.92697C9.24569 7.65348 9.61662 7.49984 10.0034 7.49984C10.3902 7.49984 10.7611 7.65348 11.0346 7.92697C11.3081 8.20046 11.4617 8.5714 11.4617 8.95817C11.4617 9.34494 11.3081 9.71588 11.0346 9.98937C10.7611 10.2629 10.3902 10.4165 10.0034 10.4165C9.61662 10.4165 9.24569 10.2629 8.9722 9.98937C8.69871 9.71588 8.54506 9.34494 8.54506 8.95817ZM15.418 13.3332L11.2146 17.7957C11.0588 17.9611 10.8708 18.093 10.6621 18.1831C10.4535 18.2732 10.2286 18.3197 10.0013 18.3197C9.77402 18.3197 9.54914 18.2732 9.34048 18.1831C9.13182 18.093 8.9438 17.9611 8.78798 17.7957L4.58465 13.3332H4.60048L4.5934 13.3248L4.58465 13.3144C3.50577 12.0384 2.91511 10.4208 2.91798 8.74984C2.91798 4.83775 6.08923 1.6665 10.0013 1.6665C13.9134 1.6665 17.0846 4.83775 17.0846 8.74984C17.0875 10.4208 16.4969 12.0384 15.418 13.3144L15.4092 13.3248L15.4021 13.3332H15.418ZM14.6084 12.6586C15.5368 11.5681 16.0455 10.182 16.043 8.74984C16.043 5.41317 13.338 2.70817 10.0013 2.70817C6.66465 2.70817 3.95965 5.41317 3.95965 8.74984C3.95704 10.182 4.46576 11.5681 5.39423 12.6586L5.52256 12.8098L9.54631 17.0811C9.60475 17.1431 9.67525 17.1926 9.7535 17.2264C9.83175 17.2602 9.91608 17.2776 10.0013 17.2776C10.0865 17.2776 10.1709 17.2602 10.2491 17.2264C10.3274 17.1926 10.3979 17.1431 10.4563 17.0811L14.4801 12.8098L14.6084 12.6586Z"
                                    fill="#7D7D7D"
                                />
                            </svg>
                            Huston, London, United Kingdom
                        </p>
                    </div>
                </div>
                <div class="col-md-12">
                    <button class="btn view-all-profile">View Full Profile</button>
                </div>
                <div class="col-md-12">
                    <div class="booking-det">
                        <h5>
                            Title : <span>I would help you build an amazing website</span>
                        </h5>
                        <h5>
                            Service & Payment Type : <span class="in-person">In-Person</span
                            ><span> Freelance | Group Booking | Subscription</span>
                        </h5>
                        <h5>Price : <span>From $10</span></h5>
                        <h5>
                            Delivery & Completion Date :
                            <span>Within 15 days each month</span>
                        </h5>
                        <h5>
                            Max. Travel Distance :
                            <span
                            >Able to travel up to 10 miles from London, United Kingdom</span
                            >
                        </h5>
                        <h5>Description :</h5>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vitae ut
                            tellus quis a euismod ut nisl, quis. Tristique bibendum morbi vel
                            vitae ultrices donec accumsan. Tincidunt eget habitant
                            pellentesque id purus. Hendrerit varius sapien, nunc, turpis augue
                            arcu venenatis. At sed consectetur in viverra duis tincidunt diam.
                            Fames diam, interdum fringilla venenatis sed mi quis. Convallis
                            enim, sit pharetra fermentum pellentesque eros. Tortor cras nulla
                            sit dui tincidunt platea mauris. Enim, risus non posuere venenatis
                            non quis id nec. Consectetur vitae gravida ut morbi tellus arcu.
                            In pretium in malesuada neque. At mauris massa magna mauris,
                        </p>
                        <h5>Requirements :</h5>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vitae ut
                            tellus quis a euismod ut nisl, quis. Tristique bibendum morbi vel
                            vitae ultrices donec accumsan. Tincidunt eget habitant
                            pellentesque id purus. Hendrerit varius sapien, nunc, turpis augue
                            arcu venenatis. At sed consectetur in viverra duis tincidunt diam.
                        </p>
                        <h5>Booking & Cancelation Details :</h5>
                        <p>
                            After booking a class or activity, you will be emailed
                            instructions on how to attend the experience on Zoom. You can
                            cancel or reschedule a booking up to 24 hours before the
                            experience starts for free
                        </p>
                        <div class="portfolio-sec">
                            <h5>Portfolio</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <a
                                        href="assets/seller-listing-new/asset/img/portfolioimg (1).png"
                                        data-fancybox="gallery"
                                        data-caption=""
                                    >
                                        <img src="assets/seller-listing-new/asset/img/portfolioimg (1).png"/>
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a
                                        href="assets/seller-listing-new/asset/img/portfolioimg (2).png"
                                        data-fancybox="gallery"
                                        data-caption=""
                                    >
                                        <img src="assets/seller-listing-new/asset/img/portfolioimg (2).png"/>
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a
                                        href="assets/seller-listing-new/asset/img/portfolioimg (3).png"
                                        data-fancybox="gallery"
                                        data-caption=""
                                    >
                                        <img src="assets/seller-listing-new/asset/img/portfolioimg (3).png"/>
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a
                                        href="assets/seller-listing-new/asset/img/portfolioimg (4).png"
                                        data-fancybox="gallery"
                                        data-caption=""
                                    >
                                        <img src="assets/seller-listing-new/asset/img/portfolioimg (4).png"/>
                                    </a>
                                </div>
                            </div>
                            <!-- row / end -->
                        </div>
                        <div class="portfolio-form">
                            <form class="row g-3">
                                <div class="col-md-4 select-group">
                                    <label for="select"> Select Group Type </label><br/>
                                    <select id="select3" type="text">
                                        <option value="b">Public Group</option>
                                        <option value="c">Private Group</option>
                                    </select>
                                </div>
                                <div class="col-md-4 guest select-groups">
                                    <label for="inputPassword4" class="form-label"
                                    >Number of Adults</label
                                    >
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="inputEmail4"
                                        placeholder="0"
                                    />
                                </div>
                                <div class="col-md-4 guest select-groups">
                                    <label for="inputPassword4" class="form-label"
                                    >Number of Childs</label
                                    >
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="inputEmail49"
                                        placeholder="0"
                                    />
                                </div>
                                <div class="col-md-6 frequency">
                                    <label for="inputEmail4" class="form-label"
                                    >Select Class Frequency</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="inputEmail410"
                                        placeholder="Select Class Frequency"
                                    />
                                </div>
                                <div class="col-md-6 select-group">
                                    <label for="select"> Are you based in sellers city </label><br/>
                                    <select id="select4" type="text">
                                        <option value="">Select Seller City</option>
                                        <option value="b">Yes</option>
                                        <option value="c">No</option>
                                    </select>
                                </div>
                                <div class="col-md-12 multiple-val-input multiemail">
                                    <label for="inputEmail4" class="form-label"
                                    >Enter Guests Emails for Class Invitation</label
                                    >
                                    <br/>
                                    <div class="col-sm-12 email-id-row">
                                        <div class="all-mail" id="all-mail-2"></div>
                                        <input type="text" name="email" class="enter-mail-id emails"
                                               id="enter-mail-id-2" placeholder="Enter the email id .."/>
                                    </div>
                                </div>

                                <div class="col-md-12 frequency">
                                    <label for="inputEmail4" class="form-label"
                                    >Additional information</label
                                    >
                                    <br/>
                                    <textarea
                                        name=""
                                        id=""
                                        cols="10"
                                        rows="5"
                                        class="form-control"
                                        placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book."
                                    ></textarea>
                                </div>
                                <div class="col-md-12 field_wrapper date-time">
                                    <div>
                                        <label for="inputEmail4" class="form-label">Select Date & Time</label>
                                        <input class="add-input" type="datetime-local" name="field_name[]" value=""
                                               placeholder="Select Date & Time"/>
                                        <a href="javascript:void(0);" class="add_button" title="Add field"><img
                                                src="assets/seller-listing-new/asset/img/add-input.svg"/></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-md-12 booking-notes">
                                <h5>Safety Notes</h5>
                                <ul class="p-0">
                                    <li>
                                        To ensure that your payments are protected under our terms,
                                        never transfer money or send messages outside of the
                                        Dreamcrowd platform.
                                    </li>
                                    <br/>
                                    <li>
                                        Payments made outside of our platform are not eligible for
                                        disputes & refunds under our terms.
                                    </li>
                                    <br/>
                                    <li>
                                        Do not provide your email address, telephone number or
                                        physical address to any seller. Only provide this
                                        information (if absolutely necessary) after you have made a
                                        payment to the seller.
                                    </li>
                                    <br/>
                                    <li>
                                        Nearby areas or landmarks nearby can be shared to give the
                                        seller an idea of how far they need to travel (This applies
                                        to in-person services only).
                                    </li>
                                    <br/>
                                    <li>
                                        Please send us a report if a seller has broken any of these
                                        safety terms or if you suspect that the seller is trying to
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="amount-sec">
            <div class="row">
                <div class="col-md-12">
                    <p class="float-start">Total Amount: <span>$55.0</span></p>
                    <div class="float-end booking-btns">
                        <a href="#" type="button" class="btn contact-btn" data-bs-toggle="modal" id="contact-us"
                           data-bs-target="#send-bookig">Send Booking Request</a>
                        <a href="payment.html" class="btn booking-btn" id="complete-booking">Complete Booking</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- online-person contact -->
<div id="contact">
    <!-- Modal -->
    <div
        class="modal fade"
        id="contact-me-modal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content contact-modal">
                <div class="modal-body p-0">
                    <div class="row">
                        <div class="col-md-12 name-label">
                            <label for="inputEmail4" class="form-label">Name</label>
                            <input
                                type="email"
                                class="form-control"
                                id="inputEmail411"
                                placeholder="Usama Aslam"
                            />
                        </div>
                        <div class="col-md-12 check-services">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea4">Message Details</label>
                                <textarea
                                    class="form-control"
                                    id="exampleFormControlTextarea4"
                                    cols="11"
                                    rows="6"
                                    placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged."
                                ></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 booking-buttons">
                            <button type="button" class="btn booking-cancel">Cancel</button>
                            <button
                                type="button"
                                class="btn request-booking"
                                data-bs-dismiss="modal"
                            >
                                Send Request
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="contact">
    <!-- Modal -->
    <div
        class="modal fade"
        id="contact-me-modal1"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content contact-modal">
                <div class="modal-body p-0">
                    <div class="row">
                        <div class="col-md-12 name-label">
                            <label for="inputEmail4" class="form-label">Name</label>
                            <input
                                type="email"
                                class="form-control"
                                id="inputEmail412"
                                placeholder="Usama Aslam"
                            />
                        </div>
                        <div class="row">
                            <div class="col-md-12 check-services">
                                <h5>Service Type</h5>
                                <div class="form-group">
                                    <div class="radio">
                                        <label for="1" class="service-radio-sec">
                                            <input
                                                id="1"
                                                type="radio"
                                                name="radio-input1"
                                                checked="checked"
                                            />
                                            Freelance Service
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="radio">
                                        <label for="2" class="service-radio">
                                            <input id="2" type="radio" name="radio-input1"/>
                                            Class service
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 check-services">
                                <h5>Delivery Option</h5>
                                <div class="radio">
                                    <label for="3" class="service-radio-sec">
                                        <input
                                            id="3"
                                            type="radio"
                                            name="radio-input2"
                                            checked="checked"
                                        />
                                        Online
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <div class="radio">
                                        <label for="4" class="service-radio">
                                            <input id="4" type="radio" name="radio-input2"/>
                                            In-person
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 check-services">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea4">Message Details</label>
                                <textarea
                                    class="form-control"
                                    id="exampleFormControlTextarea4"
                                    cols="11"
                                    rows="6"
                                    placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged."
                                ></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 booking-buttons">
                            <button type="button" class="btn booking-cancel">Cancel</button>
                            <button
                                type="button"
                                class="btn request-booking"
                                data-bs-dismiss="modal"
                            >
                                Send Request
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- in-person send booking request button modal -->
<div
    class="modal fade"
    id="send-bookig"
    tabindex="-1"
    aria-labelledby="exampleModalLabel1"
    aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content contact-modal">
            <div class="modal-body p-0">
                <div class="row">
                    <div class="col-md-12 name-label">
                        <label for="inputEmail4" class="form-label">Name</label>
                        <input
                            type="text"
                            class="form-control"
                            id="inputEmail413"
                            placeholder="Usama Aslam"
                        />
                    </div>
                    <div class="col-md-12 name-label">
                        <label for="inputEmail4" class="form-label label-sec">Email</label>
                        <input
                            type="email"
                            class="form-control"
                            id="inputEmail414"
                            placeholder="usamaaslam@gmail.com"
                        />
                    </div>
                    <div class="col-md-12 name-label">
                        <label for="inputEmail4" class="form-label label-sec"
                        >Country</label
                        >
                        <input
                            type="email"
                            class="form-control"
                            id="inputEmail415"
                            placeholder="Your Country"
                        />
                    </div>
                    <div class="col-md-12 name-label">
                        <label for="inputEmail4" class="form-label label-sec">City</label>
                        <input
                            type="email"
                            class="form-control"
                            id="inputEmail416"
                            placeholder="Your City"
                        />
                    </div>
                    <div class="col-md-12 name-label">
                        <label for="inputEmail4" class="form-label label-sec"
                        >Your Area</label
                        >
                        <input
                            type="email"
                            class="form-control"
                            id="inputEmail417"
                            placeholder="Your Area"
                        />
                    </div>
                    <div class="col-md-12 name-label">
                        <label for="inputEmail4" class="form-label label-sec"
                        >Type of expert needed</label
                        >
                        <select name="" id="">
                            <option value="">Type of expert needed</option>
                            <option value="">Class</option>
                            <option value="">Freelance</option>
                        </select>
                    </div>
                    <div class="col-md-12 name-label">
                        <label for="inputEmail4" class="form-label label-sec"
                        >Type of service</label
                        >
                        <br/>
                        <select name="" id="">
                            <option value="">Type of service</option>
                            <option value="">Online Service</option>
                            <option value="">In-person Service</option>
                        </select>
                    </div>
                    <div class="col-md-12 check-services">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea4" class="label-sec"
                            >Describe the help you require</label
                            >
                            <textarea
                                class="form-control"
                                id="exampleFormControlTextarea4"
                                rows="3"
                                placeholder="Describe the help you require..."
                            ></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 booking-buttons">
                        <button
                            type="button"
                            class="btn booking-cancel"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>
                        <button type="submit" class="btn request-booking">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- both selected text change js here -->
<script>
    function updateButtonText(Clicked) {
        var selectedOption = $('#' + Clicked).val();
        var dropdownButton = document.getElementById("dropdownMenuButton1");

        // Set button text based on selection
        dropdownButton.textContent = (selectedOption === "All") ? "Online/In-person" : selectedOption;
        $('#service_type').val(selectedOption);
    }
</script>
<!-- seach js heare -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.querySelector(".cat-search input");
        const checkboxes = document.querySelectorAll(".multiSelectContainer ul li input[type='checkbox']");

        searchInput.addEventListener("input", function () {
            const searchTerm = searchInput.value.toLowerCase();

            checkboxes.forEach(checkbox => {
                const label = checkbox.parentElement.textContent.toLowerCase();
                if (label.includes(searchTerm)) {
                    checkbox.parentElement.style.display = "block";
                } else {
                    checkbox.parentElement.style.display = "none";
                }
            });
        });
    });

</script>
<!-- 2nd search js -->
<script>
    function filterList() {
        let input = document.getElementById("search").value.toLowerCase();
        let options = document.querySelectorAll(".option");

        options.forEach(option => {
            let text = option.textContent.toLowerCase();
            if (text.includes(input)) {
                option.style.display = "block";
            } else {
                option.style.display = "none";
            }
        });
    }
</script>
<!-- filter button js -->
<script>
    document.getElementById("dropdownMenuButton1").addEventListener("click", function () {
        this.classList.toggle("active");
    });

</script>
<!-- radio buttons hide and show js -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var yesRadio = document.getElementById("yes");
        var noRadio = document.getElementById("no");
        var completeBookingBtn = document.getElementById("complete-booking");

        // Initially show the button since "Yes" is selected by default
        completeBookingBtn.style.display = "block";

        // // Add event listener to the "Yes" radio button
        // yesRadio.addEventListener("change", function() {
        //     completeBookingBtn.style.display = "block";
        // });

        // Add event listener to the "No" radio button
        // noRadio.addEventListener("change", function() {
        //     completeBookingBtn.style.display = "none";
        // });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    config = {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    }
    flatpickr("input[type=datetime-local]", config);
</script>
<!-- Hidden Input Field -->

<script>
    $(document).ready(function () {
        var maxField = 10; //Input fields increment limitation
        var fieldHTML = '<div><input class="add-input" type="datetime-local" name="field_name[]" value="" placeholder="Select Date & Time"/><a href="javascript:void(0);" class="remove_button" title="Remove field"><img src="assets/seller-listing-new/asset/img/remove-icon.svg"/></a></div>'; //New input field html

        // Once add button is clicked
        $(".add_button").click(function () {
            var wrapper = $(this).closest(".field_wrapper");
            var x = wrapper.find(".add-input").length; // Get the count of input fields in this wrapper

            //Check maximum number of input fields
            if (x < maxField) {
                wrapper.append(fieldHTML); //Add field html
            } else {
                alert("A maximum of " + maxField + " fields are allowed to be added. ");
            }
        });

        // Once remove button is clicked
        $(document).on("click", ".remove_button", function (e) {
            e.preventDefault();
            $(this).parent("div").remove(); //Remove field html
        });
    });
</script>

<!-- dropdown select active js here -->
<script>
    const dropdownButton = document.getElementById('dropdownMenuButton1');
    const radios = document.querySelectorAll('input[name="radio-group"]');

    radios.forEach(radio => {
        radio.addEventListener('change', () => {
            if (radio.checked) {
                // Add the selected class
                dropdownButton.classList.add('btn-selected');
            }
        });
    });
</script>
<!-- multiselect languages js -->
<script>
    /*
	Dropdown with Multiple checkbox select with jQuery - May 27, 2013
	(c) 2013 @ElmahdiMahmoud
	license: https://www.opensource.org/licenses/mit-license.php
*/

    $(".dropdown dt a").on('click', function () {
        $(".dropdown dd ul").slideToggle('fast');
    });

    $(".dropdown dd ul li a").on('click', function () {
        $(".dropdown dd ul").hide();
    });

    function getSelectedValue(id) {
        return $("#" + id).find("dt a span.value").html();
    }

    $(document).bind('click', function (e) {
        var $clicked = $(e.target);
        if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
    });

    $('.mutliSelect input[type="checkbox"]').on('click', function () {

        var title = $(this).closest('.mutliSelect').find('input[type="checkbox"]').val(),
            title = $(this).val() + ",";

        if ($(this).is(':checked')) {
            var html = '<span title="' + title + '">' + title + '</span>';
            $('.multiSel').append(html);
            $(".hida").hide();
        } else {
            $('span[title="' + title + '"]').remove();
            var ret = $(".hida");
            $('.dropdown dt a').append(ret);

        }
    });
</script>
<!-- mutiselect category js -->
<script>
    /*
      Dropdown with Multiple checkbox select with jQuery
      Updated to ensure unique IDs and classes
      */

    // Toggle dropdown on click
    // $("#dropdownContainer dt a").on("click", function () {
    //     $("#dropdownContainer dd ul").slideToggle("fast");
    // });

    // // Close dropdown on item click
    // $("#dropdownContainer dd ul li a").on("click", function () {
    //     $("#dropdownContainer dd ul").hide();
    // });

    // Get selected value (function available for use elsewhere if needed)
    function getSelectedValue(id) {
        return $("#" + id).find("dt a span.value").html();
    }

    // Close dropdown if clicking outside
    $(document).on("click", function (e) {
        const $clicked = $(e.target);
        if (!$clicked.parents().hasClass("dropdownContainer")) {
            $("#dropdownContainer dd ul").hide();
        }


    });

    // Handle checkbox click events
    // $("input[name='categories_list']").on("click", function () {
    //   console.log('nooooo');

    //     const title = $(this).val() + ",";
    //     if ($(this).is(":checked")) {
    //         const html = `<span title="${title}">${title}</span>`;
    //         $(".selectedItems").append(html);
    //         $(".defaultText").hide();
    //     } else {
    //         $(`span[title="${title}"]`).remove();
    //         if ($(".selectedItems").children().length === 0) {
    //             $(".defaultText").show();
    //         }
    //     }
    //     console.log(title);
    // });
</script>
<!-- filter button active and non-active js start here -->
<script>
    // ADD / REMOVE CLASS ON CLICK
    // navigation element variables
    // var $button = document.querySelector(".filter-btn");
    // // on click event
    // $button.addEventListener('click', function () {
    //     if($button.classList.contains("selected")){
    // 	    // if has 'selected' class remove class
    // 	    $button.classList.remove("selected");
    // 	} else {
    // 		// otherwise add 'selected' class
    // 		$button.classList.add("selected");
    // 	}
    // });
</script>
<!-- offcanvas js start -->
<!-- gallery -->
<script>
    Fancybox.bind("[data-fancybox]", {
        // Your custom options
    });
</script>
<!-- multiple select emails -->
<script>
    $('#generateList').on('click', function () {
        var list = $('.multiple-val-input li div').map(function () {
            return $.trim($(this).text());
        }).get();
        console.log(list.toString())
    })

    $('.multiple-val-input').on('click', function () {
        $(this).find('input:text').focus();
    });
    $('.multiple-val-input ul input:text').on('input propertychange', function () {
        $(this).siblings('span.input_hidden').text($(this).val());
        var inputWidth = $(this).siblings('span.input_hidden').width();
        $(this).width(inputWidth);
    });
    $('.multiple-val-input ul input:text').on('keypress', function (event) {
        if (event.which == 13 || event.which == 44) {
            var toAppend = $(this).val();
            if (toAppend != '') {
                $('<li><a href="#">×</a><div>' + toAppend + '</div></li>').insertBefore($(this));
                $(this).val('');
            } else {
                return false;
            }
            return false;
        }
        ;
    });
    $(document).on('click', '.multiple-val-input ul li a', function (e) {
        e.preventDefault();
        $(this).parents('li').remove();
    });
</script>
<script>
    $(".enter-mail-id").keydown(function (e) {
        if (e.keyCode == 13 || e.keyCode == 32) {
            //alert('You Press enter');
            var getValue = $(this).val();
            $('.all-mail').append('<span class="email-ids">' + getValue + ' <span class="cancel-email">x</span></span>');
            $(this).val('');
        }
    });


    /// Cancel

    $(document).on('click', '.cancel-email', function () {

        $(this).parent().remove();

    });

    // $('.enter-mail-id').click()
</script>

<!-- offcanvas js ended -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="libs/jquery/jquery.js"></script>
  <script src="libs/datatable/js/datatable.js"></script>
  <script src="libs/datatable/js/datatablebootstrap.js"></script>
  <script src="libs/select2/js/select2.min.js"></script>
  <script src="libs/owl-carousel/js/jquery.min.js"></script>
  <script src="libs/owl-carousel/js/owl.carousel.min.js"></script> -->
<!-- filter div js start here -->
<script>
    var div = document.getElementById('main');
    var display = 0;

    function hideShow() {
        if (display == 1) {
            div.style.display = 'block';
            display = 0;
        } else {
            div.style.display = 'none';
            display = 1;
        }
    }
</script>
<!-- filter div js ended here -->
<!-- MDB -->
<script
    type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.umd.min.js"
></script>


<!-- tab slider js start here -->
<script>
    const tabsBox = document.querySelector(".tabs-box"),
        allTabs = tabsBox.querySelectorAll(".tab"),
        arrowIcons = document.querySelectorAll(".icon i");

    let isDragging = false;

    const handleIcons = (scrollVal) => {
        let maxScrollableWidth = tabsBox.scrollWidth - tabsBox.clientWidth;
        arrowIcons[0].parentElement.style.display = scrollVal <= 0 ? "none" : "flex";
        arrowIcons[1].parentElement.style.display =
            maxScrollableWidth - scrollVal <= 1 ? "none" : "flex";
    };

    arrowIcons.forEach((icon) => {
        icon.addEventListener("click", () => {
            // if clicked icon is left, reduce 350 from tabsBox scrollLeft else add
            let scrollWidth = (tabsBox.scrollLeft += icon.id === "left" ? -340 : 340);
            handleIcons(scrollWidth);
        });
    });


    const dragging = (e) => {
        if (!isDragging) return;
        tabsBox.classList.add("dragging");
        tabsBox.scrollLeft -= e.movementX;
        handleIcons(tabsBox.scrollLeft);
    };

    const dragStop = () => {
        isDragging = false;
        tabsBox.classList.remove("dragging");
    };

    tabsBox.addEventListener("mousedown", () => (isDragging = true));
    tabsBox.addEventListener("mousemove", dragging);
    document.addEventListener("mouseup", dragStop);

    /* ------------------------ Watermark (Please Ignore) ----------------------- */
    const createSVG = (width, height, className, childType, childAttributes) => {
        const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");

        const child = document.createElementNS(
            "http://www.w3.org/2000/svg",
            childType
        );

        for (const attr in childAttributes) {
            child.setAttribute(attr, childAttributes[attr]);
        }

        svg.appendChild(child);

        return {svg, child};
    };

    document.querySelectorAll(".generate-button").forEach((button) => {
        const width = button.offsetWidth;
        const height = button.offsetHeight;

        const style = getComputedStyle(button);

        const strokeGroup = document.createElement("div");
        strokeGroup.classList.add("stroke");

        const {svg: stroke} = createSVG(width, height, "stroke-line", "rect", {
            x: "0",
            y: "0",
            width: "100%",
            height: "100%",
            rx: parseInt(style.borderRadius, 10),
            ry: parseInt(style.borderRadius, 10),
            pathLength: "30"
        });

        strokeGroup.appendChild(stroke);
        button.appendChild(strokeGroup);

        const stars = gsap.to(button, {
            repeat: -1,
            repeatDelay: 0.5,
            paused: true,
            keyframes: [
                {
                    "--generate-button-star-2-scale": ".5",
                    "--generate-button-star-2-opacity": ".25",
                    "--generate-button-star-3-scale": "1.25",
                    "--generate-button-star-3-opacity": "1",
                    duration: 0.3
                },
                {
                    "--generate-button-star-1-scale": "1.5",
                    "--generate-button-star-1-opacity": ".5",
                    "--generate-button-star-2-scale": ".5",
                    "--generate-button-star-3-scale": "1",
                    "--generate-button-star-3-opacity": ".5",
                    duration: 0.3
                },
                {
                    "--generate-button-star-1-scale": "1",
                    "--generate-button-star-1-opacity": ".25",
                    "--generate-button-star-2-scale": "1.15",
                    "--generate-button-star-2-opacity": "1",
                    duration: 0.3
                },
                {
                    "--generate-button-star-2-scale": "1",
                    duration: 0.35
                }
            ]
        });

        button.addEventListener("pointerenter", () => {
            gsap.to(button, {
                "--generate-button-dots-opacity": "1",
                duration: 0.5,
                onStart: () => {
                    setTimeout(() => stars.restart().play(), 500);
                }
            });
        });

        button.addEventListener("pointerleave", () => {
            gsap.to(button, {
                "--generate-button-dots-opacity": "0",
                "--generate-button-star-1-opacity": ".25",
                "--generate-button-star-1-scale": "1",
                "--generate-button-star-2-opacity": "1",
                "--generate-button-star-2-scale": "1",
                "--generate-button-star-3-opacity": ".5",
                "--generate-button-star-3-scale": "1",
                duration: 0.15,
                onComplete: () => {
                    stars.pause();
                }
            });
        });
    });

</script>
<!-- cards js start here -->
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
    // 13
    $(document).ready(function () {
        $("#heart12").click(function () {
            if ($("#heart12").hasClass("liked")) {
                $("#heart12").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
                $("#heart12").removeClass("liked");
            } else {
                $("#heart12").html('<i class="fa fa-heart" aria-hidden="true"></i>');
                $("#heart12").addClass("liked");
            }
        });
    });
    // 14
    $(document).ready(function () {
        $("#heart13").click(function () {
            if ($("#heart13").hasClass("liked")) {
                $("#heart13").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
                $("#heart13").removeClass("liked");
            } else {
                $("#heart13").html('<i class="fa fa-heart" aria-hidden="true"></i>');
                $("#heart13").addClass("liked");
            }
        });
    });
    // 15
    $(document).ready(function () {
        $("#heart14").click(function () {
            if ($("#heart14").hasClass("liked")) {
                $("#heart14").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
                $("#heart14").removeClass("liked");
            } else {
                $("#heart14").html('<i class="fa fa-heart" aria-hidden="true"></i>');
                $("#heart14").addClass("liked");
            }
        });
    });
    // 16
    $(document).ready(function () {
        $("#heart15").click(function () {
            if ($("#heart15").hasClass("liked")) {
                $("#heart15").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
                $("#heart15").removeClass("liked");
            } else {
                $("#heart15").html('<i class="fa fa-heart" aria-hidden="true"></i>');
                $("#heart15").addClass("liked");
            }
        });
    });
    // 17
    $(document).ready(function () {
        $("#heart16").click(function () {
            if ($("#heart16").hasClass("liked")) {
                $("#heart16").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
                $("#heart16").removeClass("liked");
            } else {
                $("#heart16").html('<i class="fa fa-heart" aria-hidden="true"></i>');
                $("#heart16").addClass("liked");
            }
        });
    });
    // 18
    $(document).ready(function () {
        $("#heart17").click(function () {
            if ($("#heart17").hasClass("liked")) {
                $("#heart17").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
                $("#heart17").removeClass("liked");
            } else {
                $("#heart17").html('<i class="fa fa-heart" aria-hidden="true"></i>');
                $("#heart17").addClass("liked");
            }
        });
    });
    // 19
    $(document).ready(function () {
        $("#heart18").click(function () {
            if ($("#heart18").hasClass("liked")) {
                $("#heart18").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
                $("#heart18").removeClass("liked");
            } else {
                $("#heart18").html('<i class="fa fa-heart" aria-hidden="true"></i>');
                $("#heart18").addClass("liked");
            }
        });
    });
    // 20
    $(document).ready(function () {
        $("#heart19").click(function () {
            if ($("#heart19").hasClass("liked")) {
                $("#heart19").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
                $("#heart19").removeClass("liked");
            } else {
                $("#heart19").html('<i class="fa fa-heart" aria-hidden="true"></i>');
                $("#heart19").addClass("liked");
            }
        });
    });
    // 21
    $(document).ready(function () {
        $("#heart20").click(function () {
            if ($("#heart20").hasClass("liked")) {
                $("#heart20").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
                $("#heart20").removeClass("liked");
            } else {
                $("#heart20").html('<i class="fa fa-heart" aria-hidden="true"></i>');
                $("#heart20").addClass("liked");
            }
        });
    });
    // 22
    $(document).ready(function () {
        $("#heart21").click(function () {
            if ($("#heart21").hasClass("liked")) {
                $("#heart21").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
                $("#heart21").removeClass("liked");
            } else {
                $("#heart21").html('<i class="fa fa-heart" aria-hidden="true"></i>');
                $("#heart21").addClass("liked");
            }
        });
    });
    // 23
    $(document).ready(function () {
        $("#heart22").click(function () {
            if ($("#heart22").hasClass("liked")) {
                $("#heart22").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
                $("#heart22").removeClass("liked");
            } else {
                $("#heart22").html('<i class="fa fa-heart" aria-hidden="true"></i>');
                $("#heart22").addClass("liked");
            }
        });
    });
    // 24
    $(document).ready(function () {
        $("#heart23").click(function () {
            if ($("#heart23").hasClass("liked")) {
                $("#heart23").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
                $("#heart23").removeClass("liked");
            } else {
                $("#heart23").html('<i class="fa fa-heart" aria-hidden="true"></i>');
                $("#heart23").addClass("liked");
            }
        });
    });
</script>
<!-- cards js ended here -->


{{-- Live Location Google Api Get Script Start --}}
{{-- CDN For Script --}}
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMA8qhhaBOYY1uv0nUfsBGcE74w6JNY7M&libraries=places"></script>

<script>
    function getLiveLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var distance = $('#distance_app').val();
                var miles = $('#miles_app').val();
                $('#distance').val(distance);
                $('#miles').val(miles);
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;
                console.log("Latitude: " + position.coords.latitude + ", Longitude: " + position.coords.longitude);

                SearchSellerListingSearch();
            }, function (error) {
                alert("Error getting location: " + error.message);
            }, {enableHighAccuracy: true});
        } else {
            alert("Geolocation is not supported by this browser.");
        }


    }

</script>
{{-- Live Location Google Api Get Script END --}}


{{-- Keyword Suggession --}}

<script>
    const searchInputMain = document.getElementById('keyword_search');
    const suggestionsBoxMain = document.getElementById('suggestions_main');

    searchInputMain.addEventListener('keyup', function () {
        const query = this.value.trim();
        console.log('yes');


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


    //  KeyWork Search ==
    function searhBtn() {
        var keyword = $('#keyword_search').val();
        $('#keyword').val(keyword);
        var location = $('#location_search').val();
        $('#location').val(location);

        SearchSellerListingSearch();

    }

    document.getElementById('keyword_search').addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevents the default form submission (if within a form)
            searhBtn(); // Calls the search function
        }
    });

    document.getElementById('location_search').addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevents the default form submission (if within a form)
            searhBtn(); // Calls the search function
        }
    });

</script>
{{-- OnSelect Form Submit Script END=== --}}

{{-- Location write and search services Start Script --}}
{{-- CDN Google Api --}}
{{-- <script src="https://maps.goo:gleapis.com/maps/api/js?key=AIzaSyBMA8qhhaBOYY1uv0nUfsBGcE74w6JNY7M&libraries=places"></script> --}}
<script>
    $(document).ready(function () {

        var autocomplete;
        var id = 'location_search';
        autocomplete = new google.maps.places.Autocomplete((document.getElementById(id)), {
            types: [],
        })


        // Event listener for place selection
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            var addressComponents = place.address_components;

            // Initialize variables to store details
            var country = '';
            var countryCode = '';
            var city = '';
            var postalCode = '';

            // Iterate through the address components and extract details
            for (var i = 0; i < addressComponents.length; i++) {
                var component = addressComponents[i];

                // Get Country Name and Country Code
                if (component.types.includes('country')) {
                    country = component.long_name;  // Full country name (e.g., 'United States')
                    countryCode = component.short_name;  // ISO Country code (e.g., 'US')
                }

                // Get City Name (Note: it can be 'locality' or 'administrative_area_level_1' depending on the location)
                if (component.types.includes('locality')) {
                    city = component.long_name;  // City name (e.g., 'New York')
                } else if (component.types.includes('administrative_area_level_1') && !city) {
                    city = component.long_name;  // Fallback if 'locality' isn't available
                }

                // Get Postal Code (Zip Code)
                if (component.types.includes('postal_code')) {
                    postalCode = component.long_name;  // Postal code (e.g., '10001')
                }
            }


        });


    });
</script>
{{-- Location write and search services END Script --}}

{{-- Set Values Script Start ========== --}}
<script>
    // Service Type Experts Script -----
    function ExpertServices(Clicked) {
        var service_role = $('#' + Clicked).data('role');
        $('#service_role').val(service_role);


        if (service_role === 'All') {
            $('.freelance_div_main, .class_div_main').css('display', 'block'); // Ensure they are visible
        } else if (service_role === 'Freelance') {
            $('.freelance_div_main').css('display', 'block'); // Show
            $('.class_div_main').css('display', 'none'); // Hide
        } else if (service_role === 'Class') {
            $('.class_div_main').css('display', 'block'); // Show
            $('.freelance_div_main').css('display', 'none'); // Hide
        }


        SearchSellerListingSearch();
    }


    // Categories Apply Script -----
    function CategoriesApply() {
        const cates = document.querySelectorAll('input[name="categories_list"]');
        let selected_cates = [];

        cates.forEach(cate => {
            if (cate.checked) {
                if (!selected_cates.includes(cate.value)) {
                    selected_cates.push(cate.value);
                }
            }
        });

        var category_service = $('#category_type').val();

        // ✅ If no categories are selected, clear all fields
        if (selected_cates.length === 0) {
            $('#category_service').val('');
            $('#sub_category_service').val('');
            $('#category_type').val('');
        } else {
            var targetField = (category_service === 'Category' || category_service === 'Sub_Category')
                ? '#sub_category_service'
                : '#category_service';

            // ✅ Set the selected categories
            $(targetField).val(selected_cates.join(','));

            // ✅ Set #category_type value based on selection
            $('#category_type').val((category_service === 'Category' || category_service === 'Sub_Category')
                ? 'Sub_Category'
                : 'Category');
        }

        SearchSellerListingSearch();
    }

    // Top Category Single ---
    // Select Category ===
    function SelectCategory(Clicked) {
        var category = $('#' + Clicked).data("category");
        var category_type = $('#' + Clicked).data("category_type");
        $('#category_type').val(category_type);

        if (category_type == 'Category') {

            $('#category_service').val(category);
        } else {
            $('#sub_category_service').val(category);

        }


        SearchSellerListingSearch();

    }

    // Languages Apply Script -----
    function LanguagesApply() {
        const cates = document.querySelectorAll('input[name="languages_list"]');
        let selected_cates = [];

        cates.forEach(cate => {
            if (cate.checked) {
                // Add checked value if not already in the array
                if (!selected_cates.includes(cate.value)) {
                    selected_cates.push(cate.value);
                }
            } else {
                // Remove unchecked value from the array
                selected_cates = selected_cates.filter(item => item !== cate.value);
            }
        });

        // ✅ Update the hidden input with selected categories
        $('#languages').val(selected_cates.join(','));

        SearchSellerListingSearch();

    }


    // Languages Apply Script -----
    function PriceRange() {
        var max_price = $('#max_price_app').val();
        var min_price = $('#min_price_app').val();

        // ✅ Update the hidden input with selected categories
        $('#max_price').val(max_price);
        $('#min_price').val(min_price);

        SearchSellerListingSearch();

    }


    $(document).ready(function () {
        $('input[type="radio"]').change(function () {
            SearchSellerListingSearch(); // Call your function when any radio button is changed
        });
    });


    $('#side_categories_html_div').click(function () {

        $('#side_categories').fadeToggle();


    });


    $(document).on('click', '#side_categories input[type="checkbox"]', function () {
        let selectedCategories = [];

        // ✅ Collect checked categories
        $('#side_categories input[type="checkbox"]:checked').each(function () {
            selectedCategories.push($(this).val());
        });

        // ✅ Update UI
        if (selectedCategories.length > 0) {
            let selectedHtml = selectedCategories.map(cat => `<span class="selectedItem">${cat}</span>`).join(', ');
            $('#side_categories_html').html(selectedHtml); // Update selected items
            $('.defaultText').hide(); // Hide default text
        } else {
            $('#side_categories_html').html(""); // Clear if empty
            $('.defaultText').show(); // Show default text
        }
    });


    $(document).on('click', '.ajax-page-link', function (e) {
        e.preventDefault(); // Prevent default page reload

        let page = $(this).data('page'); // Get page number
        SearchSellerListingSearch(page); // Fetch new data via AJAX
    });


</script>
{{-- Set Values Script END ========== --}}

{{-- Search By Filters Ajax FUnction Script Start ========= --}}
<script>

    function SearchSellerListingSearch(page = 1) {

        var formData = {
            languages: $('input[name="languages"]').val(),
            location: $('input[name="location"]').val(),
            distance: $('input[name="distance"]').val(),
            latitude: $('input[name="latitude"]').val(),
            longitude: $('input[name="longitude"]').val(),
            miles: $('input[name="miles"]').val(),
            service_role: $('input[name="service_role"]').val(),
            service_type: $('input[name="service_type"]').val(),
            payment_type: $('input[name="payment_type"]:checked').val() || '',
            date_time: $('input[name="date_time"]').val(),
            max_price: $('input[name="max_price"]').val(),
            min_price: $('input[name="min_price"]').val(),
            keyword: $('input[id="keyword"]').val(),
            freelance_type: $('input[name="freelance_type"]:checked').val() || '',
            freelance_service: $('input[name="freelance_service"]:checked').val() || '',
            delivery_time: $('input[name="delivery_time"]:checked').val() || '',
            revision: $('input[name="revision"]:checked').val() || '',
            lesson_type: $('input[name="lesson_type"]:checked').val() || '',
            class_type: $('input[name="class_type"]:checked').val() || '',
            category_type: $('input[id="category_type"]').val(),
            category_service: $('input[id="category_service"]').val(),
            sub_category_service: $('input[name="sub_category_service"]').val(),
            seller_type: $('input[name="seller_type"]:checked').val() || '',
            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
        };


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "GET",
            url: "/seller-listing-search?page=" + page,
            data: formData,
            dataType: 'json',
            success: function (response) {
                ShowDataFetched(response); // Update data
            },

        });


    }


    //  Show Data Fetched Start ============


    function ShowDataFetched(response) {


        var heading = response.heading;
        var gigs = Array.isArray(response.gigs) ? response.gigs : response.gigs.data || [];
        var users = response.users;
        var category_type = response.category_type;
        var categories = response.categories;


        var service_role = $('input[name="service_role"]').val();
        console.log(service_role);

        if (service_role === 'All') {
            $('#freelance_div_main, #class_div_main').show();
        } else if (service_role === 'Freelance') {
            $('#freelance_div_main').show();
            $('#class_div_main').hide();
        } else if (service_role === 'Class') {
            $('#class_div_main').show();
            $('#freelance_div_main').hide();
        }

        // Set Main Heading ----
        $('#main_heading').html(heading);


        // Set Side Categories -----
        $('#side_categories_html_div').html(`<dt><a href="#" onclick="return false;">
                        <span class="defaultText">Select Category</span>
                        <p class="selectedItems"  id="side_categories_html"></p>
                      </a></dt>`);
        // $('.defaultText').show();

        $('#side_categories').empty();
        $('#top_categories').empty();


        var len_categories = categories.length;

        $('#side_categories').html(` <li>
                                  <form class="cat-search">
                                    <input type="text" name="search" placeholder="Search..">
                                  </form>
                                </li>`);

        if (len_categories > 0) {

            for (let i = 0; i < len_categories; i++) {
                let category, cate_type;

                if (category_type == null) {
                    category = response.categories[i].category;
                    cate_type = 'Category';
                } else {
                    category = response.categories[i].sub_category;
                    cate_type = 'Sub_Category';
                }


                // Create checkbox list items
                let categories_html = `<li>
        <input type="checkbox" name="categories_list" value="${category}" id="cat_checkbox_${i}" />
        ${category}
    </li>`;

                // Append categories to UI
                $('#top_categories').append(`
        <li class="tab" onclick="SelectCategory(this.id)" id="cats_${i}"
            data-category="${category}" data-category_type="${cate_type}">
            ${category}
        </li>`);

                $('#side_categories').append(categories_html);

                // ✅ Check if category exists in sub_category_service and set it as active
                let selected_categories = $('#sub_category_service').val().split(',');

                if (selected_categories.includes(category)) {
                    $('#side_categories_html').append(`<span class="selectedItem">${category}</span>, `);
                    $('.defaultText').hide();
                    $(`#cat_checkbox_${i}`).prop('checked', true); // Check checkbox
                    $(`#cats_${i}`).addClass('active'); // Add active class to tab
                }
            }
        }

        // Categories Show END ==========


        //   SHow Gigs Script Start ============

        // **SHOW GIGS**
        $('#AllGigs').empty();
        let gigsHtml = "";

        if (!gigs || gigs.length === 0) {
            $('#EmptyGigs').css('display', 'block');
        } else {
            $('#EmptyGigs').hide();

            gigs.forEach(gig => {
                let user = users.find(user => user.user_id === gig.user_id) || {};
                let firstLetter = (user.first_name || "").charAt(0).toUpperCase();
                let lastLetter = (user.last_name || "").charAt(0).toUpperCase();
                let profileImage = user.profile_image
                    ? `assets/profile/img/${user.profile_image}`
                    : `assets/profile/avatars/(${firstLetter}).jpg`;

                let mediaPath = `assets/teacher/listing/data_${gig.user_id}/media/${gig.main_file}`;
                let mediaHTML = gig.main_file.endsWith('.mp4') || gig.main_file.endsWith('.avi') || gig.main_file.endsWith('.mov') || gig.main_file.endsWith('.webm')
                    ? `<video autoplay loop muted style="height: 100%; width: 100%;">
                    <source src="${mediaPath}" type="video/mp4">
                   </video>`
                    : `<img src="${mediaPath}" style="height: 100%;" alt="Uploaded Image">`;

                let isFavorited = gig.isFavorited ? 'liked' : '';
                let heartIcon = gig.isFavorited ? 'fa-heart' : 'fa-heart-o';

                let service_url = gig.class_type === 'Video' ? `/course-service/${gig.id}` : `/quick-booking/${gig.id}`;
                let service_type_img = gig.service_type === 'Online'
                    ? `assets/seller-listing/asset/img/globe.png`
                    : `assets/seller-listing/asset/img/handshake.png`;

                // Determine correct rate
                let finalRate = gig.final_rate !== null ? gig.final_rate : (gig.public_rate !== null ? gig.public_rate : gig.private_rate);

                gigsHtml += `
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="main-Dream-card">
                        <div class="card dream-Card">
                            <div class="dream-card-upper-section">
                                <div style="height: 180px;">${mediaHTML}</div>
                                <div class="card-img-overlay overlay-inner">
                                    <p>Top Seller</p>
                                    <span id="heart_${gig.id}" class="${isFavorited}" onclick="AddWishList(this.id);" data-gig_id="${gig.id}">
                                        <i class="fa ${heartIcon}" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                            <a href="${service_url}" style="text-decoration: none;">
                                <div class="dream-card-dawon-section">
                                    <div class="dream-Card-inner-profile">
                                        <img src="${profileImage}" alt="" style="width: 60px; height: 60px; border-radius: 100%; border: 5px solid white;">
                                        <i class="fa-solid fa-check tick"></i>
                                    </div>
                                    <p class="servise-bener">${gig.service_type} Services</p>
                                    <h5 class="dream-Card-name">${user.first_name || ''} ${lastLetter}.</h5>
                                    <p class="Dev">${user.profession || ''}</p>
                                    <p class="about-teaching"><a class="about-teaching" href="${service_url}" style="text-decoration: none;">${gig.title}</a></p>
                                    <span class="card-rat">
                                        <i class="fa-solid fa-star"></i> &nbsp; (${gig.reviews})
                                    </span>
                                    <div class="card-last">
                                        <span>Starting at $${finalRate}</span>
                                        <img data-toggle="tooltip" title="In Person-Service" src="${service_type_img}" style="height: 25px; width: 25px;" alt="">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>`;
            });

            $('#AllGigs').append(gigsHtml);
        }


        //   SHow Gigs Script END ============


        //   SHow Gigs Pagination Script Start ============

        // **SHOW PAGINATION**
        let paginationHTML = "";
        if (response.pagination.total > response.pagination.per_page) {
            paginationHTML += `<nav class="pagination-outer" aria-label="Page navigation">
                            <ul class="pagination">`;

            if (response.pagination.current_page > 1) {
                paginationHTML += `<li class="page-item">
                                  <a class="page-link ajax-page-link" href="${response.pagination.prev_page_url}" data-page="${response.pagination.current_page - 1}">«</a>
                               </li>`;
            }

            let start = Math.max(response.pagination.current_page - 2, 1);
            let end = Math.min(response.pagination.current_page + 2, response.pagination.last_page);

            for (let i = start; i <= end; i++) {
                paginationHTML += i === response.pagination.current_page
                    ? `<li class="page-item active"><span class="page-link">${i}</span></li>`
                    : `<li class="page-item"><a class="page-link ajax-page-link" href="#" data-page="${i}">${i}</a></li>`;
            }

            if (response.pagination.current_page < response.pagination.last_page) {
                paginationHTML += `<li class="page-item">
                                  <a class="page-link ajax-page-link" href="${response.pagination.next_page_url}" data-page="${response.pagination.current_page + 1}">»</a>
                               </li>`;
            }

            paginationHTML += `</ul></nav>`;
        }

        $('#pagination_main').html(paginationHTML);


        //   SHow Gigs Pagination Script END ============


    }

    //  Show Data Fetched EMD ============


</script>
{{-- Search By Filters Ajax FUnction Script END ========= --}}



{{-- Add to Wish List Set Script Start ==== --}}
<script>
    function AddWishList(Clicked) {
        var gig_id = $('#' + Clicked).data('gig_id');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: '/add-service-to-wishlist',
            data: {gig_id: gig_id, _token: '{{csrf_token()}}'},
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

{{-- Google Analytics 4 - Track Search --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof DreamCrowdAnalytics === 'undefined') {
            return; // GA4 not loaded
        }

        const searchInput = document.getElementById('search');
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', function(e) {
                clearTimeout(searchTimeout);
                // Debounce search tracking - wait 1 second after user stops typing
                searchTimeout = setTimeout(function() {
                    if (e.target.value.trim().length > 0) {
                        DreamCrowdAnalytics.trackSearch(e.target.value.trim(), {
                            search_location: 'listing_page_sidebar'
                        });
                    }
                }, 1000);
            });
        }
    });
</script>

{{-- Google Analytics 4 - Track Service Impressions --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof DreamCrowdAnalytics === 'undefined') {
            return; // GA4 not loaded
        }

        const trackedItems = new Set();
        const serviceCards = document.querySelectorAll('.service-card');

        // Create Intersection Observer
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting && !trackedItems.has(entry.target.dataset.serviceId)) {
                    trackedItems.add(entry.target.dataset.serviceId);

                    // Track impression
                    DreamCrowdAnalytics.trackServiceImpression({
                        item_id: entry.target.dataset.serviceId,
                        item_name: entry.target.dataset.serviceName,
                        item_category: entry.target.dataset.serviceCategory,
                        price: parseFloat(entry.target.dataset.servicePrice) || 0,
                        service_type: entry.target.dataset.serviceType,
                        seller_id: entry.target.dataset.serviceSeller,
                        index: Array.from(serviceCards).indexOf(entry.target)
                    });
                }
            });
        }, {
            threshold: 0.5 // Trigger when 50% of the card is visible
        });

        // Observe all service cards
        serviceCards.forEach(card => observer.observe(card));
    });
</script>


</body>
</html>
