<!DOCTYPE html>
<html lang="en">

<head>

    <base href="/public">
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <!-- View Point scale to 1.0 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Animate css -->
    <link rel="stylesheet" href="assets/public-site/libs/animate/css/animate.css" />
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="assets/public-site/libs/aos/css/aos.css" />
    <!-- Datatable css  -->
    <link rel="stylesheet" href="assets/public-site/libs/datatable/css/datatable.css" />
    <!-- Select2 css -->
    <link href="assets/public-site/libs/select2/css/select2.min.css" rel="stylesheet" />

    {{-- =====Appointment-Calender CDN===== --}}
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="assets/calender/css/mark-your-calendar.css">
    {{--
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"> --}}

    {{-- =====Appointment-Calender CDN===== --}}
    <!-- Owl carousel css -->
    <link href="assets/public-site/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
    <link href="assets/public-site/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
    <!-- Bootstrap css -->
    {{-- Fav Icon --}}
    @php $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
    @endif
    <!-- g js start -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
    <!-- g js end -->
    <link rel="stylesheet" type="text/css" href="assets/public-site/asset/css/bootstrap.min.css" />
    <link href="assets/public-site/asset/css/fontawesome.min.css" rel="stylesheet" type="text/css" />

    <!-- datetime picker css -->
    <link rel="stylesheet" href="assets/seller-listing-new/asset/jquery.datetimepicker.min.css">

    <!-- Include jQuery and DateTimePicker -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/jquery-datetimepicker@2.5.21/jquery.datetimepicker.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-datetimepicker@2.5.21/jquery.datetimepicker.full.min.js"></script>

    <!-- flatpicker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <!-- ====== g js====== -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <!-- =====g js======= -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    {{-- =======Toastr CDN ======== --}}
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- =======Toastr CDN ======== --}}

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


    <!-- slider card css start -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.0.0-beta.3/assets/owl.carousel.min.css" />
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.2.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.0.0-beta.3/assets/owl.theme.default.min.css" />
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
    <!-- slider card css End -->
    <!-- ===================== FAQ CDN start========================= -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- ===================== FAQ CDN end========================= -->
    <!-- Defualt css -->
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/public-site/asset/css/style.css" />
    <link rel="stylesheet" href="assets/public-site/asset/css/navbar.css" />
    <link rel="stylesheet" href="assets/public-site/asset/css/services.css" />
    <link rel="stylesheet" href="assets/public-site/asset/css/Drop.css" />
    <!-- ======================Hero-slider-links-start======================== -->
    <!-- ======================Hero-slider-links-start======================== -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.0.0-beta.3/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.0.0-beta.3/assets/owl.theme.default.min.css" />
    <!-- ======================Hero-slider-links-end======================== -->
    <!-- ======================Hero-slider-links-end======================== -->
    <title>DreamCrowd | Services</title>
</head>
<style>
    /* color-white: #ffffff;
  $color-black: #252a32;
  $color-light: #f1f5f8;
  $color-red: #d32f2f;
  $color-blue: #148cb8;

  $box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 3px rgba(0, 0, 0, 0.24); */

    *,
    *::before,
    *::after {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        list-style: none;
        list-style-type: none;
        text-decoration: none;
        -moz-osx-font-smoothing: grayscale;
        -webkit-font-smoothing: antialiased;
        text-rendering: optimizeLegibility;
    }


    body {
        background: #FFFFFF !important;
    }

    #picker a {
        text-decoration: none;

    }

    #picker a:hover {
        color: white;
    }


    .main {

        .container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 1rem;
            justify-content: center;
            align-items: center;
        }

        .main .card {
            color: color-black;
            border-radius: 2px;
            background: color-white;
            box-shadow: box-shadow;

        }

        .main& -image {
            position: relative;
            display: block;
            width: 100%;

            /* padding-top: 70%; */
            /* background: $color-white; */

            .main img {
                display: block;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

        }
    }

    /* mutiple email css */
    span.email-ids {
        float: left;
        /* padding: 4px; */
        border: none;
        margin-right: 5px;
        padding-left: 10px;
        padding-right: 10px;
        margin-bottom: 5px;
        background: #0072b1;
        color: #fff;
        padding-top: 3px;
        padding-bottom: 3px;
        border-radius: 5px;
        font-size: 12px;
        font-family: Roboto;
        font-weight: 400px;
    }

    span.cancel-email {
        border: none;
        color: #fff;
        width: 18px;
        display: block;
        float: right;
        text-align: center;
        margin-left: 20px;
        border-radius: 49%;
        height: 18px;
        line-height: 15px;
        margin-top: 1px;
        cursor: pointer;
    }

    /* .col-sm-12.email-id-row {
        border: 1px solid #ccc;
    } */
    .col-sm-12.email-id-row input {
        border: 0px;
        outline: 0px;
    }

    span.to-input {
        display: block;
        float: left;
        padding-right: 11px;
    }

    .col-sm-12.email-id-row {
        /* padding-top: 6px; */
        /* padding-bottom: 7px; */
        border-radius: 4px;
        background: #f4fbff;
        border: none;
        /* padding: 12px 20px 12px 30px; */
    }

    @media only screen and (max-width: 600px) {
        .main {

            .container {
                display: grid;
                grid-template-columns: 1fr;
                grid-gap: 1rem;
            }
        }

    }

    #nearme_dropdown li:hover {
        background-color: var(--Colors-Dashboard-Background, #f4fbff);
        color: var(--Colors-Logo-Color, #0072b1);
        border: 1px solid rgb(210 229 240);
        border-radius: 15px;
        font-size: 15px;

    }

    .class_datetime:hover {
        cursor: pointer;
    }
</style>

<style>
    /* Keep these in a global CSS file if you prefer */
    .review-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        border-bottom: 1px solid #eee;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
    }

    .review-summary .avg {
        font-size: 1.5rem;
        font-weight: 700;
    }

    .review-summary .count {
        color: #6c757d;
        font-size: .95rem;
    }

    .review-card {
        border: 1px solid #eef1f5;
        border-radius: .6rem;
        padding: 1rem;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.03);
    }

    .reviewer-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #f1f5f9;
    }

    .reviewer-name {
        font-weight: 600;
        margin-bottom: 0;
    }

    .reviewer-meta {
        color: #6c757d;
        font-size: .9rem;
    }

    .rating-stars i {
        margin-right: 4px;
    }

    .comment-text {
        color: #212529;
        line-height: 1.45;
    }

    .seller-reply {
        background: #fbfcfe;
        border-left: 3px solid #e6f0ff;
        padding: .75rem;
        border-radius: .4rem;
        margin-top: .75rem;
    }

    .empty-state {
        color: #6c757d;
        padding: 2rem 0;
        text-align: center;
    }

    @media (max-width: 576px) {
        .review-summary {
            flex-direction: column;
            align-items: flex-start;
            gap: .5rem;
        }
    }
</style>

<style>
    .review-header {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        padding: 1rem 0 1.25rem;
        border-bottom: 1px solid #eef1f5;
        margin-bottom: 1rem;
    }

    .review-header .side-badge {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: .5rem;
        min-width: 90px;
    }

    .review-header .side-badge img {
        width: 80px;
        height: 80px;
        object-fit: contain;
        border-radius: .5rem;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.04);
        background: #fff;
        padding: .35rem;
    }

    .review-header .title-wrap {
        text-align: center;
        max-width: 640px;
    }

    .review-header h3 {
        margin: 0;
        font-size: 1.25rem;
        letter-spacing: .2px;
        font-weight: 700;
    }

    .review-header .subtitle {
        margin: .25rem 0 0;
        color: #6c757d;
        font-size: .95rem;
        line-height: 1.35;
    }

    .review-header .ribbon {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        background: linear-gradient(90deg, #f0f7ff, #e9f3ff);
        color: #0b5ed7;
        border-radius: 999px;
        padding: .35rem .6rem;
        font-weight: 600;
        font-size: .85rem;
        box-shadow: 0 4px 14px rgba(11, 93, 215, 0.06);
        margin-top: .5rem;
    }

    @media (max-width: 576px) {
        .review-header {
            flex-direction: column;
            gap: .75rem;
            padding: .75rem 0;
        }

        .review-header .side-badge {
            flex-direction: row;
            gap: .75rem;
            justify-content: center;
            width: 100%;
        }

        .review-header .side-badge img {
            width: 68px;
            height: 68px;
        }
    }
</style>


<body style="background-color: #FFFFFF !important;">
    <!-- =========================================== NAVBAR START HERE ================================================= -->
    <!-- =========================================== NAVBAR START HERE ================================================= -->
    <x-public-nav />

    <!-- ============================================= NAVBAR END HERE ============================================ -->
    <!-- ============================================= NAVBAR END HERE ============================================ -->
    <!-- profile section start from here -->
    <div class="container profile-container">
        <div class="row">
            <div class="profile-content-sec" id="online-person">
                <div class="col-md-3 column-1">
                    <div class="sticky-contents">
                        <div class="card profile-card" style="width: 100%;">
                            @if ($profile->profile_image == null)
                                @php $firstLetter = strtoupper(substr($profile->first_name, 0, 1));  @endphp
                                <img src="assets/profile/avatars/({{$firstLetter}}).jpg" class="card-img-top-profile">
                            @else

                                <img src="assets/profile/img/{{$profile->profile_image}}" class="card-img-top-profile">
                            @endif
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center justify-content-between">
                                    <a style="text-decoration: none;"
                                        href="{{ url('professional-profile/' . $profile->id . '/' . $profile->first_name . $profile->last_name) }}">
                                        <h5 class="profile-title" style="color: var(--Colors-Logo-Color, #0072b1);">
                                            {{$profile->first_name}} {{strtoupper(substr($profile->last_name, 0, 1))}}.
                                        </h5>
                                    </a>
                                    <div class="profile-rating d-flex align-items-center">
                                        <i class="fa-solid fa-star"></i> &nbsp;
                                        <p class="mb-0">
                                            {{ number_format($gig->all_reviews->avg('rating'), 1) }}
                                            ({{ count($gig->all_reviews) }})
                                        </p>
                                    </div>
                                </div>
                                <p class="profile-text">{{$profile->profession}}</p>
                                <p class="location">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                        fill="none">
                                        <path
                                            d="M10.0034 6.45817C9.34035 6.45817 8.70447 6.72156 8.23563 7.1904C7.76679 7.65924 7.5034 8.29513 7.5034 8.95817C7.5034 9.62121 7.76679 10.2571 8.23563 10.7259C8.70447 11.1948 9.34035 11.4582 10.0034 11.4582C10.6664 11.4582 11.3023 11.1948 11.7712 10.7259C12.24 10.2571 12.5034 9.62121 12.5034 8.95817C12.5034 8.29513 12.24 7.65924 11.7712 7.1904C11.3023 6.72156 10.6664 6.45817 10.0034 6.45817ZM8.54506 8.95817C8.54506 8.5714 8.69871 8.20046 8.9722 7.92697C9.24569 7.65348 9.61662 7.49984 10.0034 7.49984C10.3902 7.49984 10.7611 7.65348 11.0346 7.92697C11.3081 8.20046 11.4617 8.5714 11.4617 8.95817C11.4617 9.34494 11.3081 9.71588 11.0346 9.98937C10.7611 10.2629 10.3902 10.4165 10.0034 10.4165C9.61662 10.4165 9.24569 10.2629 8.9722 9.98937C8.69871 9.71588 8.54506 9.34494 8.54506 8.95817ZM15.418 13.3332L11.2146 17.7957C11.0588 17.9611 10.8708 18.093 10.6621 18.1831C10.4535 18.2732 10.2286 18.3197 10.0013 18.3197C9.77402 18.3197 9.54914 18.2732 9.34048 18.1831C9.13182 18.093 8.9438 17.9611 8.78798 17.7957L4.58465 13.3332H4.60048L4.5934 13.3248L4.58465 13.3144C3.50577 12.0384 2.91511 10.4208 2.91798 8.74984C2.91798 4.83775 6.08923 1.6665 10.0013 1.6665C13.9134 1.6665 17.0846 4.83775 17.0846 8.74984C17.0875 10.4208 16.4969 12.0384 15.418 13.3144L15.4092 13.3248L15.4021 13.3332H15.418ZM14.6084 12.6586C15.5368 11.5681 16.0455 10.182 16.043 8.74984C16.043 5.41317 13.338 2.70817 10.0013 2.70817C6.66465 2.70817 3.95965 5.41317 3.95965 8.74984C3.95704 10.182 4.46576 11.5681 5.39423 12.6586L5.52256 12.8098L9.54631 17.0811C9.60475 17.1431 9.67525 17.1926 9.7535 17.2264C9.83175 17.2602 9.91608 17.2776 10.0013 17.2776C10.0865 17.2776 10.1709 17.2602 10.2491 17.2264C10.3274 17.1926 10.3979 17.1431 10.4563 17.0811L14.4801 12.8098L14.6084 12.6586Z"
                                            fill="#7D7D7D"></path>
                                    </svg>
                                    @if ($gigData->work_site == null)
                                        <span>{{$profile->city}}, {{$profile->country}}</span>
                                    @else
                                        @php
                                            $address = $gigData->work_site;
                                            // Convert address to an array (split by comma)
                                            $parts = explode(",", $address);

                                            // Trim spaces
                                            $parts = array_map('trim', $parts);

                                            // Get the last two parts (city and country)
                                            $city = $parts[count($parts) - 2] ?? "Unknown";
                                            $country = $parts[count($parts) - 1] ?? "Unknown";
                                        @endphp
                                        <span>{{$city}}, {{$country}}</span>

                                    @endif

                                </p>
                                <a href="#freelance_type"
                                    class="btn w-100 d-flex justify-content-center view-all-profile scroll-to-booking">Book
                                    This Service</a>

                                <div class="social-section">
                                    <h3>Share on :</h3>
                                    <a href="javascript:void(0);" onclick="getShareURL('whatsapp')">
                                        <img src="assets/public-site/asset/img/whatsapp.svg" alt="">
                                    </a>
                                    <a href="javascript:void(0);" onclick="getShareURL('twitter')">
                                        <img src="assets/public-site/asset/img/twitter.svg" alt="">
                                    </a>
                                    <a href="javascript:void(0);" onclick="getShareURL('facebook')">
                                        <img src="assets/public-site/asset/img/facebook.png" alt=""
                                            style="width: 24px; height: 24px;">
                                    </a>
                                    {{-- <a href="javascript:void(0);" onclick="getShareURL('instagram')">
                                        <img src="assets/public-site/asset/img/insta.svg" alt="">
                                    </a> --}}
                                    <a href="javascript:void(0);" onclick="getShareURL('linkedin')">
                                        <img src="assets/public-site/asset/img/linkedin.svg" alt="">
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="profile-detail col-md-9 column-1">
                    <div class="booking-det pt-0">
                        <h3>{{$gig->title}}</h3>


                        @if ($gig->service_role == 'Class')
                            <div class="service-payment-sec">
                                {{-- Trial Class Badge --}}
                                @if ($gigData->recurring_type == 'Trial')
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            @if ($gig->trial_type == 'Free')
                                                <div class="alert alert-success"
                                                    style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px; padding: 12px 20px; border-radius: 8px; background-color: #d4edda; border: 1px solid #c3e6cb;">
                                                    <i class="fas fa-gift" style="font-size: 24px; color: #28a745;"></i>
                                                    <div>
                                                        <strong style="font-size: 16px; color: #155724;">🎉 FREE TRIAL
                                                            CLASS</strong>
                                                        <p style="margin: 0; font-size: 14px; color: #155724;">No payment
                                                            required • 30 minutes session • Perfect to get started!</p>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="alert alert-info"
                                                    style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px; padding: 12px 20px; border-radius: 8px; background-color: #d1ecf1; border: 1px solid #bee5eb;">
                                                    <i class="fas fa-star" style="font-size: 24px; color: #0c5460;"></i>
                                                    <div>
                                                        <strong style="font-size: 16px; color: #0c5460;">⭐ PAID TRIAL
                                                            CLASS</strong>
                                                        <p style="margin: 0; font-size: 14px; color: #0c5460;">Try before
                                                            committing • {{$totalMinutes}} minutes session</p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="service-pay">
                                            <h4>Price :</h4>
                                            @php
                                                $lesson_type = ($gig->lesson_type == 'One') ? '1-to-1' : 'Group';
                                                $rate = ($gig->lesson_type == 'Group') ? (($gigData->group_type == 'Both' || $gigData->group_type == 'Public') ? $gig->public_rate : $gig->private_rate) : $gig->rate;
                                                $payment_type = ($gig->payment_type == 'OneOff') ? 'One-off' : 'Subscription';
                                                $minors = ($gigPayment->minor_attend == 1) ? 'Suitable for minors & adults  (' . $gigPayment->age_limit . '+)  ' : 'Only suitable for adults (18+)';
                                            @endphp
                                            @if ($gigData->recurring_type == 'Trial' && $gig->trial_type == 'Free')
                                                <p style="font-size: 24px; font-weight: bold; color: #28a745;">FREE <small
                                                        style="font-size: 14px; color: #666;">(No payment required)</small>
                                                </p>
                                            @else
                                                <p>From ${{$rate}} </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="service-pay">
                                            <h4>Order Type:</h4>
                                            @php
                                                $duration = $gigPayment->duration; // e.g. "1:30" or "00:45"
                                                list($hours, $minutes) = explode(':', $duration);
                                                $totalMinutes = ($hours * 60) + $minutes;
                                            @endphp
                                            @if ($gigData->recurring_type == 'Trial')
                                                <p>
                                                    <span
                                                        style="background-color: #ffc107; color: #000; padding: 3px 8px; border-radius: 4px; font-weight: 600; font-size: 12px;">TRIAL
                                                        CLASS</span>
                                                    {{$gig->service_type}} {{$gig->service_role}} | {{$lesson_type}} Booking
                                                    | {{$totalMinutes}} mins
                                                </p>
                                            @else
                                                <p>{{$gig->service_type}} {{$gig->service_role}} | {{$lesson_type}} Booking
                                                    | {{$payment_type}} Payment | {{$totalMinutes }} mins
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="service-payment-sec">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="service-pay">
                                            <h4> Age Limit:</h4>
                                            @php
                                                $duration = $gigPayment->duration; // e.g. "1:30" or "00:45"
                                                list($hours, $minutes) = explode(':', $duration);
                                                $totalMinutes = ($hours * 60) + $minutes;
                                            @endphp
                                            <p> {!!$minors!!}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="service-pay">
                                            <h4> Experience Level :</h4>
                                            @php
                                                $lesson_type = ($gig->lesson_type == 'One') ? '1-to-1' : 'Group';
                                                $rate = ($gig->lesson_type == 'Group') ? (($gigData->group_type == 'Both' || $gigData->group_type == 'Public') ? $gig->public_rate : $gig->private_rate) : $gig->rate;
                                                $payment_type = ($gig->payment_type == 'OneOff') ? 'One-off' : 'Subscription';
                                                $minors = ($gigPayment->minor_attend == 1) ? 'Suitable for minors & adults  (' . $gigPayment->age_limit . '+)  ' : 'Only suitable for adults (18+)';

                                            @endphp
                                            <p> {{$gigData->experience_level}} Level </p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            @if ($gigData->service_delivery != null)

                                <div class="service-payment-sec pay-sec">
                                    <div class="row">
                                        @if ($gigData->max_distance != null)
                                            <div class="col-md-6">
                                                <div class="service-pay">
                                                    <h4>Max. Travel Distance:</h4>
                                                    @php
                                                        if (!empty($gigData->work_site)) {
                                                            $address = $gigData->work_site;

                                                            // Convert address to an array (split by comma)
                                                            $parts = explode(",", $address);

                                                            // Trim spaces
                                                            $parts = array_map('trim', $parts);

                                                            // Get the last two parts (city and country)
                                                            $city = $parts[count($parts) - 2] ?? "Unknown";
                                                            $country = $parts[count($parts) - 1] ?? "Unknown";
                                                        } else {
                                                            $city = $profile->city;
                                                            $country = $profile->country;
                                                        }
                                                    @endphp
                                                    <p>Able to travel up to {{$gigData->max_distance}} miles from {{$city}}
                                                        , {{$country}}</p>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($gigData->work_site != null)
                                            <div class="col-md-6">
                                                <div class="service-pay">
                                                    <h4>Service Delivery Location</h4>

                                                    @php
                                                        if ($gigData->service_delivery == 2) {
                                                            $delivery_location = "Service will be delivered at buyer and/or seller's location";
                                                        } elseif ($gigData->service_delivery == 1) {
                                                            $delivery_location = 'Service will be delivered at sellers location';
                                                        } else {
                                                            $delivery_location = 'Service will be delivered at buyers location';
                                                        }
                                                    @endphp
                                                    <p>{{$delivery_location}}</p>
                                                </div>
                                            </div>
                                        @endif


                                    </div>
                                </div>
                            @endif

                        @endif


                        <div class="row">
                            <div class="col-md-12">

                                @if ($gigData->freelance_type != null)

                                    @php
                                        if ($gigData->freelance_type == 'Both') {
                                            // Split the description by '|*|' separator
                                            $descriptions = explode('|*|', $gigData->description);
                                            $requirements = explode('|*|', $gigData->requirements);

                                            // Assign values for Basic & Premium (if available)
                                            $basic_description = $descriptions[0] ?? '';
                                            $premium_description = $descriptions[1] ?? '';
                                            $basic_requirements = $requirements[0] ?? '';
                                            $premium_requirements = $requirements[1] ?? '';
                                        } else {
                                            // If not 'Both', set the same description for Basic & Premium
                                            $basic_description = $gigData->description;
                                            $premium_description = $gigData->description;
                                            $basic_requirements = $gigData->requirements;
                                            $premium_requirements = $gigData->requirements;
                                        }

                                    @endphp


                                    <div class="services-tabs-section">
                                        <div class="tabs">
                                            <div class="tabs-nav" role="tablist" aria-label="Content sections" @if ($gigData->freelance_type == 'Premium') style="justify-content: flex-start;"
                                            @endif>
                                                <div class="tabs-indicator"></div>
                                                @if (in_array($gigData->freelance_type, ['Both', 'Basic']))
                                                    <button class="tab-button border-end-0" role="tab" aria-selected="true"
                                                        aria-controls="panel-1" id="tab-1">
                                                        Basic
                                                    </button>
                                                @endif
                                                @if (in_array($gigData->freelance_type, ['Both', 'Premium']))
                                                    @php
                                                        $aria_selected = ($gigData->freelance_type == 'Premium') ? 'true' : 'false';
                                                    @endphp
                                                    <button
                                                        class="tab-button border-start-0 @if ($gigData->freelance_type == 'Premium') active @endif"
                                                        role="tab" aria-selected="{{$aria_selected}}" aria-controls="panel-2"
                                                        id="tab-2">
                                                        Premium
                                                    </button>
                                                @endif


                                            </div>

                                            @if (in_array($gigData->freelance_type, ['Both', 'Basic']))
                                                <div class="tab-panel" role="tabpanel" id="panel-1" aria-labelledby="tab-1"
                                                    aria-hidden="false">

                                                    {{-- <div class="service-payment-sec">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="service-pay">
                                                                    <h4>Revisions</h4>
                                                                    <p>15 Revisions</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="service-pay">
                                                                    <h4>Delivery</h4>
                                                                    <p>within 15 Days
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    <h2>Description:</h2>
                                                    <div class="description-sec">
                                                        <p> {!! $basic_description !!} </p>
                                                    </div>
                                                    <h2>Requirements :</h2>
                                                    <div class="description-sec">
                                                        <p> {!! $basic_requirements !!} </p>
                                                    </div>

                                                    <h2>Booking & Cancelation Details :</h2>
                                                    <div class="description-sec">
                                                        <h4>Booking:</h4>
                                                        <ul>
                                                            <li>Secure your design service by providing complete project
                                                                details, including requirements, timeline, and references.
                                                            </li>
                                                            <li>A confirmation message will be sent upon booking approval,
                                                                and work will begin as per the agreed schedule.
                                                            </li>
                                                            <li>Urgent requests can be accommodated based on availability
                                                                with an additional fee.
                                                            </li>
                                                        </ul>
                                                        <h4>Revisions:</h4>
                                                        <ul>
                                                            <li>Revisions are included based on the selected package to
                                                                ensure 100% satisfaction.
                                                            </li>
                                                            <li>Major design changes after approval may incur additional
                                                                costs.
                                                            </li>
                                                        </ul>
                                                        <h4>Cancellation & Refunds:</h4>
                                                        <ul>
                                                            <li>Orders can be canceled before work begins for a full
                                                                refund.
                                                            </li>
                                                            <li>If work has started, a partial refund may be issued based on
                                                                the progress made.
                                                            </li>
                                                            <li>No refunds will be provided once the final files are
                                                                delivered.
                                                            </li>
                                                            <li>In case of unavoidable circumstances, order adjustments can
                                                                be discussed.
                                                            </li>
                                                        </ul>
                                                        <p>For any questions or special requests, feel free to contact
                                                            before placing your order! 🚀</p>
                                                    </div>

                                                    <div class="service-faqs-sec">
                                                        <h2>FAQ’S</h2>
                                                        <div class="faq-sec">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="accordion">
                                                                        @if (count($gigFaqs) > 0)
                                                                            @foreach ($gigFaqs as $item)
                                                                                <div class="accordion-item">
                                                                                    <input type="checkbox" id="accordion{{$item->id}}">
                                                                                    <label for="accordion{{$item->id}}"
                                                                                        class="accordion-item-title"><span
                                                                                            class="icon"></span>{{$item->question}}
                                                                                    </label>
                                                                                    <div class="accordion-item-desc">
                                                                                        {!! $item->answer !!}
                                                                                    </div>
                                                                                </div>

                                                                            @endforeach

                                                                        @else
                                                                            <div class="accordion-item">
                                                                                <input type="checkbox" id="accordion1">
                                                                                <label for="accordion1"
                                                                                    class="accordion-item-title"><span
                                                                                        class="icon"></span>Not Have Any
                                                                                    Faq's</label>
                                                                                <div class="accordion-item-desc">
                                                                                </div>
                                                                            </div>
                                                                        @endif


                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            @endif

                                            @if (in_array($gigData->freelance_type, ['Both', 'Premium']))
                                                @php
                                                    $aria_hidden = ($gigData->freelance_type == 'Premium') ? 'false' : 'true';
                                                @endphp
                                                <div class="tab-panel" role="tabpanel" id="panel-2" aria-labelledby="tab-2"
                                                    aria-hidden="{{$aria_hidden}}">


                                                    <h2>Description:</h2>
                                                    <div class="description-sec">
                                                        <p> {!! $premium_description !!} </p>
                                                    </div>
                                                    <h2>Requirements :</h2>
                                                    <div class="description-sec">
                                                        <p> {!! $premium_requirements !!} </p>
                                                    </div>


                                                    <h2>Booking & Cancelation Details :</h2>
                                                    <div class="description-sec">
                                                        <h4>Booking:</h4>
                                                        <ul>
                                                            <li>Secure your design service by providing complete project
                                                                details, including requirements, timeline, and references.
                                                            </li>
                                                            <li>A confirmation message will be sent upon booking approval,
                                                                and work will begin as per the agreed schedule.
                                                            </li>
                                                            <li>Urgent requests can be accommodated based on availability
                                                                with an additional fee.
                                                            </li>
                                                        </ul>
                                                        <h4>Revisions:</h4>
                                                        <ul>
                                                            <li>Revisions are included based on the selected package to
                                                                ensure 100% satisfaction.
                                                            </li>
                                                            <li>Major design changes after approval may incur additional
                                                                costs.
                                                            </li>
                                                        </ul>
                                                        <h4>Cancellation & Refunds:</h4>
                                                        <ul>
                                                            <li>Orders can be canceled before work begins for a full
                                                                refund.
                                                            </li>
                                                            <li>If work has started, a partial refund may be issued based on
                                                                the progress made.
                                                            </li>
                                                            <li>No refunds will be provided once the final files are
                                                                delivered.
                                                            </li>
                                                            <li>In case of unavoidable circumstances, order adjustments can
                                                                be discussed.
                                                            </li>
                                                        </ul>
                                                        <p>For any questions or special requests, feel free to contact
                                                            before placing your order! 🚀</p>
                                                    </div>

                                                    <div class="service-faqs-sec">
                                                        <h2>FAQ’S</h2>
                                                        <div class="faq-sec">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="accordion">


                                                                        @if (count($gigFaqs) > 0)
                                                                            @foreach ($gigFaqs as $item)
                                                                                <div class="accordion-item">
                                                                                    <input type="checkbox" id="accordion{{$item->id}}">
                                                                                    <label for="accordion{{$item->id}}"
                                                                                        class="accordion-item-title"><span
                                                                                            class="icon"></span>{{$item->question}}
                                                                                    </label>
                                                                                    <div class="accordion-item-desc">
                                                                                        {!! $item->answer !!}
                                                                                    </div>
                                                                                </div>

                                                                            @endforeach

                                                                        @else
                                                                            <div class="accordion-item">
                                                                                <input type="checkbox" id="accordion1">
                                                                                <label for="accordion1"
                                                                                    class="accordion-item-title"><span
                                                                                        class="icon"></span>Not Have Any
                                                                                    Faq's</label>
                                                                                <div class="accordion-item-desc">
                                                                                </div>
                                                                            </div>
                                                                        @endif


                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    </div>

                                @else

                                    <div class="services-tabs-section">
                                        <div class="tabs">
                                            <div class="tab-panel" role="tabpanel" id="panel-1" aria-labelledby="tab-1"
                                                aria-hidden="false">
                                                <h2>Description:</h2>
                                                <div class="description-sec">
                                                    <p> {!! $gigData->description !!} </p>
                                                </div>
                                                <h2>Requirements :</h2>
                                                <div class="description-sec">
                                                    <p> {!! $gigData->requirements !!} </p>
                                                </div>


                                                <h2>Booking & Cancelation Details :</h2>
                                                <div class="description-sec">
                                                    <h4>Booking:</h4>
                                                    <ul>
                                                        <li>Secure your design service by providing complete project
                                                            details, including requirements, timeline, and references.
                                                        </li>
                                                        <li>A confirmation message will be sent upon booking approval, and
                                                            work will begin as per the agreed schedule.
                                                        </li>
                                                        <li>Urgent requests can be accommodated based on availability with
                                                            an additional fee.
                                                        </li>
                                                    </ul>
                                                    <h4>Revisions:</h4>
                                                    <ul>
                                                        <li>Revisions are included based on the selected package to ensure
                                                            100% satisfaction.
                                                        </li>
                                                        <li>Major design changes after approval may incur additional
                                                            costs.
                                                        </li>
                                                    </ul>
                                                    <h4>Cancellation & Refunds:</h4>
                                                    <ul>
                                                        <li>Orders can be canceled before work begins for a full refund.
                                                        </li>
                                                        <li>If work has started, a partial refund may be issued based on the
                                                            progress made.
                                                        </li>
                                                        <li>No refunds will be provided once the final files are
                                                            delivered.
                                                        </li>
                                                        <li>In case of unavoidable circumstances, order adjustments can be
                                                            discussed.
                                                        </li>
                                                    </ul>
                                                    <p>For any questions or special requests, feel free to contact before
                                                        placing your order! 🚀</p>
                                                </div>

                                                <div class="service-faqs-sec">
                                                    <h2>FAQ’S</h2>
                                                    <div class="faq-sec">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="accordion">
                                                                    @if (count($gigFaqs) > 0)
                                                                        @foreach ($gigFaqs as $item)
                                                                            <div class="accordion-item">
                                                                                <input type="checkbox" id="accordion{{$item->id}}">
                                                                                <label for="accordion{{$item->id}}"
                                                                                    class="accordion-item-title"><span
                                                                                        class="icon"></span>{{$item->question}}
                                                                                </label>
                                                                                <div class="accordion-item-desc">
                                                                                    {!! $item->answer !!}
                                                                                </div>
                                                                            </div>

                                                                        @endforeach

                                                                    @else
                                                                        <div class="accordion-item">
                                                                            <input type="checkbox" id="accordion1">
                                                                            <label for="accordion1"
                                                                                class="accordion-item-title"><span
                                                                                    class="icon"></span>Not Have Any
                                                                                Faq's</label>
                                                                            <div class="accordion-item-desc">
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (Auth::user())
                                    <a href="#" type="button" class="btn contact-btn" data-bs-toggle="modal" id="contact-us"
                                        data-bs-target="#contact-me-modal">Contact Me</a>
                                @else
                                    <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn booking-btn">
                                        Contact Me
                                    </button>
                                @endif
                                @if (Auth::user())
                                    @if ($gigData->recurring_type == 'Trial' && $gig->trial_type == 'Free')
                                        <button onclick="ServicePayemnt();" class="btn booking-btn"
                                            style="background-color: #28a745; border-color: #28a745;">
                                            <i class="fas fa-gift"></i> Book Free Trial - No Payment Required
                                        </button>
                                    @elseif ($gigData->recurring_type == 'Trial' && $gig->trial_type == 'Paid')
                                        <button onclick="ServicePayemnt();" class="btn booking-btn"
                                            style="background-color: #17a2b8; border-color: #17a2b8;">
                                            <i class="fas fa-star"></i> Book Paid Trial - ${{$rate}}
                                        </button>
                                    @else
                                        <button onclick="ServicePayemnt();" class="btn booking-btn">Complete Booking
                                        </button>
                                    @endif
                                @else
                                    @if ($gigData->recurring_type == 'Trial' && $gig->trial_type == 'Free')
                                        <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn booking-btn"
                                            style="background-color: #28a745; border-color: #28a745;">
                                            <i class="fas fa-gift"></i> Book Free Trial - No Payment Required
                                        </button>
                                    @elseif ($gigData->recurring_type == 'Trial' && $gig->trial_type == 'Paid')
                                        <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn booking-btn"
                                            style="background-color: #17a2b8; border-color: #17a2b8;">
                                            <i class="fas fa-star"></i> Book Paid Trial - ${{$rate}}
                                        </button>
                                    @else
                                        <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn booking-btn">
                                            Complete Booking
                                        </button>
                                    @endif
                                @endif
                            </div>
                        </div>


                    </div>

                </div>

            </div>
        </div>
    </div>
    <!-- Buyer review section is here -->
    <div class="container-fluid card_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="page-title">Buyer Reviews</h1>
                    <p class="page-title-2">Voice of Our Valued Buyers - LMS Buyer Reviews!</p>
                    @if(count($gig->all_reviews))
                        <div class="owl-carousel card_carousel owl-loaded owl-drag">
                            <div class="owl-stage-outer">
                                <div class="owl-stage"
                                    style="transform: translate3d(-7656px, 0px, 0px); transition: 0.25s; width: 11140px; padding-left: 2px; padding-right: 2px;">
                                    @foreach($gig->all_reviews as $review)
                                        <div class="owl-item cloned" style="width: 676px; margin-right: 20px;">
                                            <div class="card  card-slider">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <img src="assets/public-site/asset/img/slidercommentimg1.png"
                                                            class="rounded-circle">
                                                        <div class="d-flex flex-column">
                                                            <div class="name"> {{@$review->user->first_name}}
                                                                {{strtoupper(substr(@$review->user->last_name, 0, 1))}}
                                                                .
                                                            </div>
                                                            <p class="text-muted">Student</p>
                                                        </div>
                                                    </div>
                                                    <p class="card-text">{{ $review->cmnt }} </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="owl-nav">
                                <button type="button" role="presentation" class="owl-prev"><i class="fa-solid fa-angle-left"
                                        aria-hidden="true"></i>
                                </button>
                                <button type="button" role="presentation" class="owl-next"><i
                                        class="fa-solid fa-chevron-right" aria-hidden="true"></i></button>
                            </div>
                            <div class="owl-dots disabled"></div>
                        </div>
                    @else
                        <p class="text-center">No Review Yet</p>
                    @endif
                </div>
            </div>
            @if(count($gig->all_reviews))
                <div class="row">
                    <div class="col-md-12">
                        <center>
                            <button type="button" class="btn veiwbtn" data-bs-toggle="modal"
                                data-bs-target="#all-review-modal">View All
                            </button>
                        </center>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- portfolio section here -->

    <div class="container">
        <div class="row">
            <div class="portfolio-sec portfolio-img mb-5">
                <h5>Portfolio</h5>
                <div class="row">


                    <div class="col-md-3" style="height: 250px;">
                        <a href="assets/teacher/listing/data_{{$gig->user_id}}/media/{{$gigData->main_file}}"
                            data-fancybox="gallery" data-caption="">
                            @if (Str::endsWith($gigData->main_file, ['.mp4', '.avi', '.mov', '.webm']))
                                <!-- Video Player -->
                                <video autoplay loop muted style="height: 100%; width: 100%;">
                                    <source
                                        src="assets/teacher/listing/data_{{$gig->user_id}}/media/{{$gigData->main_file}}"
                                        type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @elseif (Str::endsWith($gigData->main_file, ['.jpg', '.jpeg', '.png', '.gif']))
                                <!-- Image Display -->
                                <img src="assets/teacher/listing/data_{{$gig->user_id}}/media/{{$gigData->main_file}}"
                                    style="height: 100%;" alt="Uploaded Image">
                            @endif
                        </a>
                    </div>
                    @if ($gigData->other != null)
                        @php $other = explode(',_,', $gigData->other); @endphp
                        @foreach ($other as $item)

                            <div class="col-md-3" style="height: 250px;">
                                <a href="assets/teacher/listing/data_{{$gig->user_id}}/media/{{$item}}" data-fancybox="gallery"
                                    data-caption="">
                                    <img src="assets/teacher/listing/data_{{$gig->user_id}}/media/{{$item}}"
                                        style="height: 100%;" />
                                </a>
                            </div>

                        @endforeach

                    @endif

                    @if ($gigData->video != null)

                        <div class="col-md-3" style="height: 250px;">
                            <a href="assets/teacher/listing/data_{{$gig->user_id}}/media/{{$gigData->video}}"
                                data-fancybox="gallery" data-caption="">
                                <video controls class="Request-img"
                                    src="assets/teacher/listing/data_{{$gig->user_id}}/media/{{$gigData->video}}"
                                    style="height: 100%;">
                            </a>
                        </div>

                    @endif


                </div>
                <!-- row / end -->
            </div>

            <form id="payment_form" action="/service-book" method="POST">
                @csrf

                <div class="portfolio-form">
                    <div class="row g-3">


                        @if ($gigData->lesson_type == 'Group')

                            <div class="col-md-4 select-group">
                                <label for="select"> Select Group Type </label><br />
                                <select id="group_type" name="group_type" type="text">
                                    @if ($gigData->group_type == 'Private')
                                        <option value="Private" selected>Private Group</option>
                                    @elseif($gigData->group_type == 'Public')
                                        <option value="Public" selected>Public Group</option>
                                    @else
                                        <option value="Public" selected>Public Group</option>
                                        <option value="Private">Private Group</option>
                                    @endif

                                </select>
                            </div>


                            <div class="col-md-4 select-group extra_guests_set_div">
                                <label for="select"> Would you like to add extra guests?</label><br />
                                <select id="extra_guests" name="extra_guests" type="text">

                                    <option value="No" selected>No</option>
                                    <option value="Yes">Yes</option>


                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-4 guest select-groups guests_set_div">
                                    <label for="inputPassword41" class="form-label">Select Number of Guest</label>

                                    <input type="number" class="form-control" id="guests" name="guests"
                                        onfocusout="GroupSize(this.id)" placeholder="Number of Adults" value="1" />
                                </div>
                                @if ($gigPayment->minor_attend == 1)
                                    <div class="col-md-4 guest select-groups input-sec  guests_set_div">
                                        <input type="number" class="form-control numberof-childs" id="childs" name="childs"
                                            onfocusout="GroupSize(this.id)" placeholder="Number of Childs" />
                                    </div>
                                @endif
                            </div>

                        @endif

                        <div class="row">
                            <div class="col-md-4 select-group" style="padding-top: 0px;">
                                <label for="frequency">Select Class Frequency</label><br />

                                <input type="hidden" id="total_people" name="total_people" value="1">
                                @php
                                    if ($gig->service_role == 'Freelance') {
                                        $rate = $gig->rate;
                                    }
                                @endphp
                                <input type="hidden" id="price" name="price" value="{{$rate}}">
                                <input type="hidden" id="gig_id" name="gig_id" value="{{$gig->id}}">
                                <input type="hidden" id="my_location" name="my_location" value="No">

                                <select id="frequency" name="frequency" type="text">
                                    <option value="1">1</option>
                                    @if ($gigData->payment_type == 'Subscription')
                                        @for ($i = 2; $i <= 50; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor

                                    @endif

                                </select>
                            </div>
                        </div>

                        @if ($gig->service_type == 'Inperson')

                            <div class="row mt-2">
                                <div class="col-md-4 select-group" style="padding-top: 0px;">
                                    <label for="service_delivery">Where would you like this service offered</label><br />

                                    <select id="service_delivery" name="service_delivery" type="text">
                                        @if ($gigData->service_delivery == 0)
                                            <option value="0" selected>I will visit clients sites to offer this service
                                            </option>
                                        @elseif($gigData->service_delivery == 1)
                                            <option value="1" selected>This service would be offered at my work site
                                            </option>
                                        @else
                                            <option value="1" selected>This service would be offered at my work site
                                            </option>
                                            <option value="0">I will visit clients sites to offer this service</option>
                                        @endif

                                    </select>
                                </div>


                                <div class="col-md-8 select-group" style="padding-top: 0px;" id="work_location_div">
                                </div>


                            </div>

                        @endif

                        @if ($gigData->lesson_type == 'Group')

                            <div class="col-md-12 multiple-val-input multiemail guests_set_div">
                                <label for="inputEmail4" class="form-label">Enter Guests Emails for Class Invitation</label>
                                <br />
                                <div class="col-12 email-id-row mt-2">
                                    <div class="all-mail" id="all-mail-1"></div>
                                    <input type="email" class="enter-mail-id emails" id="email"
                                        placeholder="Enter the email id .." style="width: 100%;" />
                                    <input type="hidden" name="email" id="all_emails">
                                </div>
                                <div id="all_emails_div" style="display: flex; gap: 10px; flex-wrap: wrap; mt-2"></div>
                            </div>

                        @endif


                        <div class="col-md-12 field_wrapper date-time mt-2">
                            <div class="">
                                <label for="inputEmail4" class="form-label">Select Date & Time</label>
                                <p id="time_zone_show">Show Date/Time Based on</p>
                                <div id="picker"></div>
                                <div>
                                    <p>Selected dates / times:</p>
                                    <div id="selected-dates"></div>
                                </div>
                                <input type="hidden" name="class_time" id="class_time">
                                <input type="hidden" name="teacher_class_time" id="teacher_class_time">
                                <input type="hidden" name="selected_slots" id="selected_slots">
                                <input type="hidden" name="teacher_time_zone" id="teacher_time_zone">
                                <input type="hidden" name="user_time_zone" id="user_time_zone">


                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Trial Class Information Box --}}
        @if ($gigData->recurring_type == 'Trial')
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="alert"
                        style="background-color: #e7f3ff; border-left: 4px solid #2196f3; padding: 15px; border-radius: 6px;">
                        <h6 style="margin: 0 0 10px 0; color: #0d47a1; font-weight: 600;">
                            <i class="fas fa-info-circle"></i> Trial Class Information
                        </h6>
                        <ul style="margin: 0; padding-left: 20px; color: #1565c0; font-size: 14px;">
                            @if ($gig->trial_type == 'Free')
                                <li>This is a <strong>FREE trial class</strong> - no payment required!</li>
                                <li>Duration: <strong>30 minutes</strong></li>
                            @else
                                <li>This is a <strong>paid trial class</strong> at a special introductory price</li>
                                <li>Duration: <strong>{{$totalMinutes}} minutes</strong></li>
                            @endif
                            <li>Meeting platform: <strong>Zoom</strong></li>
                            <li>You'll receive a <strong>confirmation email</strong> immediately after booking</li>
                            <li><strong>Zoom meeting link</strong> will be sent <strong>30 minutes before</strong> your
                                class starts
                            </li>
                            <li>Make sure to check your email inbox and spam folder</li>
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12 booking-notes service-notes">
                <h5>Notes</h5>
                <ul class="p-0">
                    <li>
                        To ensure that your payments are protected under our terms, never transfer money or send
                        messages
                        outside of the Dreamcrowd platform.
                    </li>
                    <br />
                    <li>
                        Payments made outside of our platform are not eligible for disputes & refunds under our terms.
                    </li>
                    <br />
                    <li>
                        Please send us a report if you have been asked by a Creator to communicate or pay outside of our
                        platform.
                    </li>
                    <br />
                    <li>
                        To ensure that your payments are protected under our terms, never transfer money or send
                        messages
                        outside of the Dreamcrowd platform.
                    </li>
                    <br />
                    <li>
                        Payments made outside of our platform are not eligible for disputes & refunds under our terms.
                    </li>
                    <br />
                    <li>
                        Please send us a report if you have been asked by a Creator to communicate or pay outside of our
                        platform.
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="amount-sec amount-section container">
        <div class="row">
            <div class="col-md-12">
                @php
                    $rate = ($gig->lesson_type == 'Group') ? (($gigData->group_type == 'Both' || $gigData->group_type == 'Public') ? $gig->public_rate : $gig->private_rate) : $gig->rate;
                @endphp
                @if ($gigData->recurring_type == 'Trial' && $gig->trial_type == 'Free')
                    <p class="float-start">Total Amount <span id="total_price"
                            style="color: #28a745; font-weight: bold; font-size: 20px;">FREE</span>
                    </p>
                @else
                    <p class="float-start">Total Amount <span id="total_price">${{$rate}}</span></p>
                @endif
                <div class="float-end">
                    @if (Auth::user())
                        <a href="#" type="button" class="btn contact-btn" data-bs-toggle="modal" id="contact-us"
                            data-bs-target="#contact-me-modal">Contact Me</a>
                    @else
                        <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn booking-btn">
                            Contact Me
                        </button>
                    @endif

                    @if (Auth::user())
                        @if ($gigData->recurring_type == 'Trial' && $gig->trial_type == 'Free')
                            <button onclick="ServicePayemnt();" class="btn booking-btn"
                                style="background-color: #28a745; border-color: #28a745;">
                                <i class="fas fa-gift"></i> Book Free Trial
                            </button>
                        @elseif ($gigData->recurring_type == 'Trial' && $gig->trial_type == 'Paid')
                            <button onclick="ServicePayemnt();" class="btn booking-btn"
                                style="background-color: #17a2b8; border-color: #17a2b8;">
                                <i class="fas fa-star"></i> Book Paid Trial
                            </button>
                        @else
                            <button onclick="ServicePayemnt();" class="btn booking-btn">Complete Booking</button>
                        @endif
                    @else
                        @if ($gigData->recurring_type == 'Trial' && $gig->trial_type == 'Free')
                            <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn booking-btn"
                                style="background-color: #28a745; border-color: #28a745;">
                                <i class="fas fa-gift"></i> Book Free Trial
                            </button>
                        @elseif ($gigData->recurring_type == 'Trial' && $gig->trial_type == 'Paid')
                            <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn booking-btn"
                                style="background-color: #17a2b8; border-color: #17a2b8;">
                                <i class="fas fa-star"></i> Book Paid Trial
                            </button>
                        @else
                            <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn booking-btn">Complete
                                Booking
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Send Message  Modal Start =========-->
    <div class="modal fade" id="contact-me-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content contact-modal">
                <div class="modal-body p-0">
                    <div class="row">
                        <form id="messageForm">
                            {{-- <div class="col-md-12 name-label">
                                <label for="inputEmail4" class="form-label">Name</label>
                                <input type="text" readonly class="form-control" id="inputEmail4"
                                    value="{{$profile->first_name}} {{$profile->last_name}}"
                                    placeholder="Usama Aslam" />
                            </div> --}}
                            <div class="col-md-12 check-services">
                                <div class="form-group">
                                    <label for="message-textarea">Message Details</label>
                                    <textarea class="form-control" id="message-textarea" cols="11" rows="6"
                                        placeholder="type your message..."></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 booking-buttons">
                                <button type="button" data-bs-dismiss="modal" aria-label="Close"
                                    class="btn booking-cancel">
                                    Cancel
                                </button>
                                <button type="button" class="btn request-booking" onclick="SendSMS()">
                                    Send Request
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- All review modal start from here -->
    <!-- Modal -->
    <div class="modal fade" id="all-review-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content review-all-modal">

                <div class="modal-body">
                    <div class="container-review">
                        <div class="row">
                            <!-- Scoped styles for the review header -->
                            <!-- Professional review header (replace your old two blocks with this) -->
                            <div class="col-12">
                                <div class="review-header">
                                    {{-- Left badge/image --}}
                                    <div class="side-badge d-none d-sm-flex">
                                        <img src="https://a0.muscache.com/im/pictures/airbnb-platform-assets/AirbnbPlatformAssets-GuestFavorite/original/059619e1-1751-42dd-84e4-50881483571a.png"
                                            alt="Guest favorite badge" decoding="async" loading="lazy">
                                        <small class="text-muted">Verified</small>
                                    </div>

                                    {{-- Title and subtitle --}}
                                    <div class="title-wrap">
                                        <h3 class="mb-0">All Reviews</h3>

                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <div class="ribbon">
                                                <i class="fa-solid fa-award"></i>
                                                <span>Top 10%</span>
                                            </div>
                                        </div>

                                        <p class="subtitle mt-2 mb-0">
                                            This expert is in the top 10% of profiles based on ratings, review quality,
                                            and
                                            reliability.
                                        </p>
                                    </div>

                                    {{-- Right badge/image --}}
                                    <div class="side-badge d-none d-sm-flex">
                                        <img src="https://a0.muscache.com/im/pictures/airbnb-platform-assets/AirbnbPlatformAssets-GuestFavorite/original/33b80859-e87e-4c86-841c-645c786ba4c1.png"
                                            alt="Trusted badge" decoding="async" loading="lazy">
                                        <small class="text-muted">Trusted</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Reviews summary + list (replace your current .profile-reviews block with this) -->
                            {{-- Scoped styles for professional review layout --}}

                            {{-- Professional reviews block (drop-in replacement) --}}
                            <div class="profile-reviews">

                                {{-- Summary header --}}
                                @php
                                    $count = $gig->all_reviews->count();
                                    $avg = $count ? round($gig->all_reviews->avg('rating'), 1) : 0.0;
                                    $avgInt = floor($avg);
                                    $avgHasHalf = ($avg - $avgInt) >= 0.5;
                                @endphp

                                <div class="review-summary">
                                    <div>
                                        <h4 class="mb-0">All Reviews</h4>
                                        <div class="d-flex align-items-center mt-1">
                                            <div class="me-3">
                                                <span class="avg">{{ number_format($avg, 1) }}</span>
                                                <div class="d-inline-block ms-2 rating-stars"
                                                    title="{{ number_format($avg, 1) }} out of 5">
                                                    {{-- Average stars (visual) --}}
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $avgInt)
                                                            <i class="fa-solid fa-star"></i>
                                                        @elseif ($i === $avgInt + 1 && $avgHasHalf)
                                                            <i class="fa-solid fa-star-half-stroke"></i>
                                                        @else
                                                            <i class="fa-regular fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>

                                            <div class="count">
                                                <small>{{ $count }} {{ Str::plural('review', $count) }}</small>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Optionally, a CTA or filter can go here --}}
                                    <div class="text-end">
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse"
                                            data-bs-target="#reviewsFilter">Filter
                                        </button>
                                    </div>
                                </div>

                                @if($count === 0)
                                    <div class="empty-state">
                                        <p class="mb-0">No reviews yet. Be the first to leave feedback!</p>
                                    </div>
                                @endif

                                {{-- Reviews list --}}
                                <div class="row g-3">
                                    @foreach($gig->all_reviews as $review)
                                        @php
                                            $user = $review->user;
                                            $avatar = $user->avatar ?? asset('assets/public-site/asset/img/personal-profile.png');
                                            $rating = (float) $review->rating;
                                            $full = (int) floor($rating);
                                            $half = ($rating - $full) >= 0.5;
                                        @endphp

                                        <div class="col-12">
                                            <div class="review-card d-flex gap-3">
                                                {{-- Avatar --}}
                                                <div class="flex-shrink-0">
                                                    <img src="{{ $avatar }}" alt="{{ $user->name ?? 'Guest' }}"
                                                        class="reviewer-avatar">
                                                </div>

                                                {{-- Content --}}
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                                        <div>
                                                            <p class="reviewer-name mb-0">{{ $user->name ?? 'Guest' }}</p>
                                                            <p class="reviewer-meta mb-0">{{ $user->country ?? '' }}</p>
                                                        </div>

                                                        <div class="text-end">
                                                            {{-- Rating stars per review --}}
                                                            <div class="rating-stars mb-1">
                                                                @for($s = 1; $s <= 5; $s++)
                                                                    @if($s <= $full)
                                                                        <i class="fa-solid fa-star"></i>
                                                                    @elseif($s === $full + 1 && $half)
                                                                        <i class="fa-solid fa-star-half-stroke"></i>
                                                                    @else
                                                                        <i class="fa-regular fa-star"></i>
                                                                    @endif
                                                                @endfor
                                                            </div>
                                                            <small
                                                                class="text-muted">{{ optional($review->created_at)->diffForHumans() }}</small>
                                                        </div>
                                                    </div>

                                                    {{-- Comment --}}
                                                    <div class="comment-text">
                                                        <p class="mb-0">{{ $review->cmnt }}</p>
                                                    </div>

                                                    {{-- Seller replies (if any) --}}
                                                    @if($review->replies && $review->replies->count())
                                                        @foreach($review->replies as $reply)
                                                            <div class="seller-reply mt-3">
                                                                <div class="d-flex justify-content-between">
                                                                    <div>
                                                                        <strong>{{ $reply->user->name ?? 'Seller' }}</strong>
                                                                        <div class="small text-muted">
                                                                            {{ optional($reply->created_at)->diffForHumans() }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-2">
                                                                    <p class="mb-0">{{ $reply->cmnt }}</p>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Optional: modal footer with close or load more --}}
                                <div class="mt-3 d-flex justify-content-end">
                                    <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                    {{-- If many reviews, consider toggling to show more via pagination/AJAX --}}
                                </div>
                            </div>

                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>
    <!-- All review modal ended here -->


    <!-- Send Message  Modal END =========-->

    <!-- ============================= FOOTER SECTION START HERE ===================================== -->
    <!-- =========================================== NAVBAR START HERE ================================================= -->
    <x-public-footer />
    <!-- ============================================= NAVBAR END HERE ============================================ -->
    <!-- =============================== FOOTER SECTION END HERE ===================================== -->
    <script src="assets/public-site/libs/jquery/jquery.js"></script>
    <script src="assets/public-site/libs/datatable/js/datatable.js"></script>
    <script src="assets/public-site/libs/datatable/js/datatablebootstrap.js"></script>
    <script src="assets/public-site/libs/select2/js/select2.min.js"></script>
    <script src="assets/public-site/libs/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="assets/public-site/asset/js/bootstrap.min.js"></script>
    <script src="assets/public-site/asset/js/script.js"></script>
    <script src="assets/seller-listing-new/asset/jquery.datetimepicker.full.min.js"></script>


    @if(Auth::user())
        <!-- ======= Script for Send Sms by Ajax Start ====== -->
        <script>
            function SendSMS() {
                var sms = $('#message-textarea').val(); // Get the value of the textarea

                // Check if the textarea is empty or null
                if (!sms || sms.trim() === '') {
                    alert('Please enter a message before sending.'); // Show a warning message
                    return; // Exit the function
                }

                var sender_id = {{Auth::user()->id}};
                var sender_role = {{Auth::user()->role}};
                var reciver_id = {{$profile->user_id}};
                var reciver_role = 1;
                var type = 0;


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: '/send-sms-single',
                    data: {
                        sender_id: sender_id,
                        reciver_id: reciver_id,
                        sms: sms,
                        sender_role: sender_role,
                        reciver_role: reciver_role,
                        type: type,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (response) {


                        if (response.error) {
                            toastr.options =
                            {
                                "closeButton": true,
                                "progressBar": true,
                                "timeOut": "10000", // 10 seconds
                                "extendedTimeOut": "4410000" // 10 seconds
                            }
                            toastr.error(response.error);
                        } else {
                            $('.emoji-wysiwyg-editor').empty();
                            $('#message-textarea').val('');
                            $('#contact-me-modal').modal('hide');
                            toastr.options =
                            {
                                "closeButton": true,
                                "progressBar": true,
                                "timeOut": "10000", // 10 seconds
                                "extendedTimeOut": "4410000" // 10 seconds
                            }
                            toastr.success(response.success);
                        }
                    },

                });


            }


        </script>
        <!-- ======= Script for Send Sms by Ajax END ====== -->
    @endif


    <script>
        document.querySelector('.scroll-to-booking').addEventListener('click', function (e) {
            e.preventDefault(); // Prevent default anchor behavior
            const target = document.querySelector('#freelance_type');
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    </script>


    <script>

        function ServicePayemnt() {
            let isValid = true;
            let gig_id = @json($gigData->gig_id);
            let lesson_type = @json($gigData->lesson_type);
            let service_type = @json($gig->service_type);
            let frequency = parseInt($("#frequency").val()) || 1;
            let duration = parseInt('<?= $gigPayment->duration; ?>') || 120; // Duration in minutes (2 hours)
            let groupType = $("#group_type").val() || null;
            let recurring_type = @json($gigData->recurring_type);
            let is_trial = (recurring_type == 'Trial');

            if (lesson_type == 'Group') {
                let guests = parseInt($("#guests").val()) || 0;
                let extra_guests = $("#extra_guests").val() || 'No';

                let children = parseInt($("#childs").val()) || 0;
                let emails = $("#all_emails").val().split(",");

                let totalPeople = guests;
                let groupSize = (groupType === 'Public') ? parseInt('<?= $gigPayment->public_group_size; ?>') : parseInt('<?= $gigPayment->private_group_size; ?>');
                let minorsAllowed = parseInt('<?= $gigPayment->minor_attend; ?>');
                let minorsLimit = parseInt('<?= $gigPayment->childs; ?>');

                if (groupType === 'Private' || (groupType === 'Public' && extra_guests === 'Yes')) {


                    if (guests <= 0) {
                        alert("Guests count cannot be negative!");
                        $("#guests").val(1);
                        return;
                    }

                    if (children < 0) {
                        alert("Children count cannot be negative!");
                        $("#childs").val(0);
                        return;
                    }

                    if (minorsAllowed === 1 && children > minorsLimit) {
                        alert(`Maximum ${minorsLimit} children allowed!`);
                        $("#childs").val(minorsLimit);
                        return;
                    } else if (minorsAllowed === 0 && children > 0) {
                        alert("Children are not allowed for this class!");
                        $("#childs").val(0);
                        return;
                    }

                    if (totalPeople > groupSize) {
                        alert(`Total participants cannot exceed ${groupSize}!`);
                        return;
                    }

                    if (guests < children) {
                        alert("Guests minimmum equal to childs are allowed!");
                        return;
                    }

                    if (emails.length !== totalPeople) {
                        alert(`You must enter exactly ${totalPeople} email addresses!`);
                        return;
                    }

                    let emailSet = new Set();
                    for (let email of emails) {
                        if (!validateEmail(email)) {
                            alert(`Invalid email: ${email}`);
                            return;
                        }
                        if (emailSet.has(email)) {
                            alert(`Duplicate email detected: ${email}`);
                            return;
                        }
                        emailSet.add(email);
                    }
                }
            }


            var class_time = $('#teacher_class_time').val();

            // For trial classes, check if user has selected a time slot from available repeat days
            if (is_trial) {
                // Check if pre-scheduled date/time exists (legacy support)
                @if($gigPayment->start_date && $gigPayment->start_time)
                    // If teacher has set a specific pre-scheduled time, use it
                    if (!class_time || class_time === '') {
                        let teacher_scheduled_time = '{{ $gigPayment->start_date }} {{ $gigPayment->start_time }}';
                        let teacher_timezone = '{{ $gig->user->timezone ?? "UTC" }}';
                        let user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

                        // Set the hidden fields with the scheduled time
                        $('#teacher_class_time').val(teacher_scheduled_time);
                        $('#class_time').val(teacher_scheduled_time);
                        $('#teacher_time_zone').val(teacher_timezone);
                        $('#user_time_zone').val(user_timezone);

                        class_time = teacher_scheduled_time;
                    }
                @else
                    // No pre-scheduled time, user must select from calendar
                @endif

                // Re-check the value after potential pre-scheduling
                class_time = $('#teacher_class_time').val();

                // If still no time selected, show error
                if (!class_time || class_time === '') {
                    alert('Please select a date & time for your trial class from the calendar below.');
                    return false;
                }
            } else {
                // For regular classes, validate time slot selection
                if (class_time == '') {
                    alert(`Minimum 1 time slot is required.`);
                    return false;
                }
            }


            if (service_type == 'Inperson') {
                var service_delivery = $('#service_delivery').val();
                if (service_delivery == 0) {
                    var work_site = $('#work_site').val();
                    if (work_site != "") {
                        var my_location = $('#my_location').val();

                        if (my_location == 'No') {
                            alert("Service is not available in this area");
                            return false;
                        }

                    } else {
                        alert("Please add your address where you want service!");
                        return false;
                    }


                } else {
                    var work_site = $('#work_location').val();
                }

            }


            $('#payment_form').submit();
        }

        function validateEmail(email) {
            let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }

        function formatTime(date) {
            let hours = date.getHours();
            let minutes = date.getMinutes();
            let ampm = hours >= 12 ? "PM" : "AM";
            hours = hours % 12 || 12;
            return `${hours}:${minutes.toString().padStart(2, "0")} ${ampm}`;
        }


    </script>


    {{-- Class Date - Time Selection Script END ========= --}}



    @if ($gigData->lesson_type == 'Group')
        {{-- ===== Group Size Setup Start ====== --}}
        <script>

            $(document).ready(function () {
                var extra_guests = $('#extra_guests').val();
                var group_type = $('#group_type').val();

                if (group_type == 'Public') {

                    if (extra_guests == 'No') {
                        $('.guests_set_div').hide();
                    } else {
                        $('.guests_set_div').show();

                    }
                } else {
                    $('.extra_guests_set_div').hide();
                }

                $('#group_type').on('change', function () {
                    var group_type = $('#group_type').val();

                    if (group_type == 'Private') {
                        $('.extra_guests_set_div').hide();
                        $('.guests_set_div').show();
                    } else {
                        $('.extra_guests_set_div').show();
                        var extra_guests = $('#extra_guests').val();
                        if (extra_guests == 'No') {
                            $('.guests_set_div').hide();
                        } else {
                            $('.guests_set_div').show();

                        }

                    }


                });


                $('#extra_guests').on('change', function () {
                    var extra_guests = $('#extra_guests').val();

                    if (extra_guests == 'No') {
                        $('.guests_set_div').hide();
                    } else {
                        $('.guests_set_div').show();

                    }

                });
            });


            function GroupSize(Clicked) {
                // Check if this is a free trial class
                var isFreeTrialClass = '<?php    echo ($gigData->recurring_type == "Trial" && $gig->trial_type == "Free") ? "true" : "false"; ?>';

                if (isFreeTrialClass === 'true') {
                    // For free trials, always show FREE and return early
                    $('#total_price').html('<span style="color: #28a745; font-weight: bold; font-size: 20px;">FREE</span>');
                    $('#price').val(0);
                    return;
                }

                var minors = parseInt('<?php    echo $gigPayment->minor_attend; ?>');  // 1 = Allow Children, 0 = No Children
                var minors_limit = parseInt('<?php    echo $gigPayment->childs; ?>');  // Max children allowed
                var group_type = $('#group_type').val();  // Public or Private
                var childs = parseInt($('#childs').val()) || 0;  // Default to 0 if empty
                var guests = parseInt($('#guests').val()) || 0;  // Default to 0 if empty
                var frequency = parseInt($('#frequency').val()) || 1;  // Default to 1 if empty

                // Ensure guests and childs values are not negative
                if (childs < 0) {
                    alert("Children count cannot be negative!");
                    $('#childs').val(0);
                    childs = 0;
                }

                if (guests <= 0) {
                    alert("Guests count cannot be negative!");
                    $('#guests').val(1);
                    guests = 1;
                }

                // Get group size based on type
                var group_size = (group_type === 'Public')
                    ? parseInt('<?php    echo $gigPayment->public_group_size; ?>')
                    : parseInt('<?php    echo $gigPayment->private_group_size; ?>');

                // Get rate based on type
                var rate = (group_type === 'Public')
                    ? parseFloat('<?php    echo $gigPayment->public_rate; ?>')
                    : parseFloat('<?php    echo $gigPayment->private_rate; ?>');

                // Check if minors are allowed
                if (minors === 1) {
                    // Ensure `childs` does not exceed `minors_limit`
                    if (childs > minors_limit) {
                        alert(`Maximum ${minors_limit} children allowed!`);
                        $('#childs').val(minors_limit);
                        childs = minors_limit;
                    }
                } else {
                    // If minors are not allowed, reset `childs` input
                    $('#childs').val(0);
                    childs = 0;
                }

                // Validate total size (childs + guests should not exceed group_size)
                var total_people = guests;
                if (total_people > group_size) {
                    alert(`Maximum group size is ${group_size} !`);
                    $('#guests').val(group_size);
                    guests = group_size;
                }

                // Calculate final price
                var total_price = guests * rate * frequency;
                $('#total_price').text(`$${total_price.toFixed(2)}`);
                $('#total_people').val(total_people);
                $('#price').val(total_price);
            }


            // On Frequency Changes ============
            $('#frequency').on('change', function () {
                // Check if this is a free trial class
                var isFreeTrialClass = '<?php    echo ($gigData->recurring_type == "Trial" && $gig->trial_type == "Free") ? "true" : "false"; ?>';

                if (isFreeTrialClass === 'true') {
                    // For free trials, always show FREE and return early
                    $('#total_price').html('<span style="color: #28a745; font-weight: bold; font-size: 20px;">FREE</span>');
                    $('#price').val(0);
                    return;
                }

                var minors = parseInt('<?php    echo $gigPayment->minor_attend; ?>');  // 1 = Allow Children, 0 = No Children
                var minors_limit = parseInt('<?php    echo $gigPayment->childs; ?>');  // Max children allowed
                var group_type = $('#group_type').val();  // Public or Private
                var childs = parseInt($('#childs').val()) || 0;  // Default to 0 if empty
                var guests = parseInt($('#guests').val()) || 0;  // Default to 0 if empty
                var frequency = parseInt($('#frequency').val()) || 1;  // Default to 1 if empty

                // Get group size based on type
                var group_size = (group_type === 'Public')
                    ? parseInt('<?php    echo $gigPayment->public_group_size; ?>')
                    : parseInt('<?php    echo $gigPayment->private_group_size; ?>');

                // Get rate based on type
                var rate = (group_type === 'Public')
                    ? parseFloat('<?php    echo $gigPayment->public_rate; ?>')
                    : parseFloat('<?php    echo $gigPayment->private_rate; ?>');

                // Check if minors are allowed
                if (minors === 1) {
                    // Ensure `childs` does not exceed `minors_limit`
                    if (childs > minors_limit) {
                        alert(`Maximum ${minors_limit} children allowed!`);
                        $('#childs').val(minors_limit);
                        childs = minors_limit;
                    }


                } else {
                    // If minors are not allowed, reset `childs` input
                    $('#childs').val(0);
                    childs = 0;
                }

                // Validate total size (childs + guests should not exceed group_size)
                var total_people = guests;
                if (total_people > group_size) {
                    alert(`Maximum group size is ${group_size} !`);
                    $('#guests').val(group_size);
                    guests = group_size;
                }

                // Calculate final price
                var total_price = guests * rate * frequency;
                $('#total_price').text(`$${total_price.toFixed(2)}`);
                $('#total_people').val(total_people);
                $('#price').val(total_price);

                $('#date_time_inputs_div').empty();


            });


            // Add Emails For Invitation =========

            document.addEventListener('DOMContentLoaded', function () {
                const emailInput = document.getElementById('email');
                const emailOutputDiv = document.getElementById('all_emails_div');
                const emailHiddenField = document.getElementById('all_emails');
                const totalPeopleField = document.getElementById('total_people');

                let emails = [];

                emailInput.addEventListener('keypress', function (event) {

                    if (event.key === 'Enter') {
                        alert(`Press comma (,) for saperate email.`);
                        return false;
                    }
                    if (event.key === ',') {
                        event.preventDefault();
                        addEmails(emailInput.value.trim());
                    }
                });

                emailInput.addEventListener('blur', function () {
                    if (emailInput.value.trim() !== '') {
                        addEmails(emailInput.value.trim());
                    }
                });

                function addEmails(inputValue) {
                    let emailList = inputValue.split(',').map(email => email.trim()).filter(email => email !== "");

                    emailList.forEach(email => {
                        if (!validateEmail(email)) {
                            alert(`Invalid email: ${email}`);
                            return;
                        }

                        if (emails.includes(email)) {
                            alert(`Email already added: ${email}`);
                            return;
                        }

                        let totalPeople = parseInt(totalPeopleField.value) || 0;
                        if (emails.length >= totalPeople) {
                            alert(`You can only add up to ${totalPeople} emails!`);
                            return;
                        }

                        emails.push(email);
                    });

                    emailInput.value = '';
                    renderEmails();
                }

                function validateEmail(email) {
                    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return regex.test(email);
                }

                function renderEmails() {
                    emailOutputDiv.innerHTML = '';

                    emails.forEach((email, index) => {
                        let emailTag = document.createElement('span');
                        emailTag.textContent = email;
                        emailTag.className = 'email-tag';
                        emailTag.style.cssText = `
                        background-color: #0072b1;
                        color: #fff;
                        padding: 5px 10px;
                        border-radius: 4px;
                        display: inline-flex;
                        align-items: center;
                        margin: 3px;
                        font-size: 14px;
                        cursor: default;
                    `;

                        let removeButton = document.createElement('span');
                        removeButton.textContent = ' x';
                        removeButton.className = 'remove-email';
                        removeButton.style.cssText = `
                        color: #fff;
                        margin-left: 8px;
                        cursor: pointer;
                        font-weight: bold;
                    `;

                        removeButton.addEventListener('click', function () {
                            removeEmail(index);
                        });

                        emailTag.appendChild(removeButton);
                        emailOutputDiv.appendChild(emailTag);
                    });

                    updateEmailField();
                }

                function removeEmail(index) {
                    emails.splice(index, 1);
                    renderEmails();
                }

                function updateEmailField() {
                    emailHiddenField.value = emails.join(',');
                }
            });


        </script>
        {{-- ===== Group Size Setup END ====== --}}
    @endif


    @if ($gig->service_type == 'Inperson')

        {{-- Inperson Script =====Start --}}
        <script>

        </script>
        {{-- Inperson Script =====END --}}



        {{-- Google Script CDN --}}
        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMA8qhhaBOYY1uv0nUfsBGcE74w6JNY7M&libraries=places"></script>

        {{-- Street Address Google Api Script Start --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                function updateWorkLocation() {
                    var service_delivery = $('#service_delivery').val();
                    var content;

                    if (service_delivery == 1) {
                        var work_site = @json($gigData->work_site);
                        content = `
                        <label for="work_location" class="form-label" id="work_lable">At seller's work location</label><br />

                        <div class="input-group mb-3">
                        <input type="text" class="enter-mail-id"  name="work_site" id="work_location" value="${work_site}" readonly style="width: 70%;" />
                        <button class="btn  view-all-profile"   type="button" id="view_map_btn">View Map</button>
                      </div>
                      `;
                    } else {
                        content = `
                        <label for="work_location" class="form-label" id="work_lable">At my location</label><br />
                        <div style="position: relative;">
                            <input class="Class-Title enter-mail-id" id="work_site" name="work_site" value="" placeholder="My Location"
                                type="text" style="padding: 14px 20px; width: 100%;" autocomplete="off" />
                            <ul id="nearme_dropdown" style="border-radius: 15px; display: none; position: absolute; background: white;
                                border: 1px solid #ccc; width: 80%; z-index: 1000; list-style: none; padding: 0; margin: 0; bottom: -38px; left: 7px;">
                                <li style="padding: 8px; cursor: pointer; font-size: 14px;" id="nearme_option">Near Me</li>
                            </ul>
                        </div>`;
                    }

                    $('#work_location_div').html(content);
                    setTimeout(initAutocomplete, 500);
                }

                // View Address in Map ===========
                // ✅ Delegate the click handler for dynamically added #view_map_btn
                $(document).on('click', '#view_map_btn', function () {
                    const location = $('#work_location').val();
                    if (location.trim() !== "") {
                        const mapUrl = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(location)}`;
                        window.open(mapUrl, '_blank');
                    } else {
                        alert("Location is empty!");
                    }
                });

                function initAutocomplete() {
                    var input = document.getElementById('work_site');
                    if (input) {
                        var autocomplete = new google.maps.places.Autocomplete(input, { types: [] });
                        google.maps.event.addListener(autocomplete, 'place_changed', function () {
                            var place = autocomplete.getPlace();
                            if (!place.geometry) {
                                alert("Invalid address, please select a valid location.");
                                return;
                            }

                            var enteredLat = place.geometry.location.lat();
                            var enteredLng = place.geometry.location.lng();
                            checkDistance(enteredLat, enteredLng);
                        });
                    }
                }

                function getUserLocation() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            function (position) {
                                var latitude = position.coords.latitude;
                                var longitude = position.coords.longitude;
                                var geocoder = new google.maps.Geocoder();
                                var latLng = new google.maps.LatLng(latitude, longitude);
                                geocoder.geocode({ location: latLng }, function (results, status) {
                                    if (status === 'OK' && results[0]) {
                                        $('#work_site').val(results[0].formatted_address);
                                        checkDistance(latitude, longitude);
                                    } else {
                                        alert('Unable to retrieve location');
                                    }
                                });
                            },
                            function () {
                                alert('Geolocation access denied');
                            }
                        );
                    } else {
                        alert('Geolocation is not supported by this browser.');
                    }
                }

                function checkDistance(userLat, userLng) {
                    var profileLat, profileLng;
                    if ('{{ $gigData->work_site }}' === "") {
                        profileLat = parseFloat("{{ $profile->latitude }}");
                        profileLng = parseFloat("{{ $profile->longitude }}");
                    } else {
                        var geocoder = new google.maps.Geocoder();
                        geocoder.geocode({ address: "{{ $gigData->work_site }}" }, function (results, status) {
                            if (status === 'OK' && results[0].geometry) {
                                profileLat = results[0].geometry.location.lat();
                                profileLng = results[0].geometry.location.lng();
                                calculateDistance(userLat, userLng, profileLat, profileLng);
                            } else {
                                alert("Unable to retrieve seller's location");
                            }
                        });
                        return;
                    }
                    calculateDistance(userLat, userLng, profileLat, profileLng);
                }

                function calculateDistance(lat1, lng1, lat2, lng2) {
                    function toRad(value) {
                        return value * Math.PI / 180;
                    }

                    var R = 3958.8; // Radius of Earth in miles
                    var dLat = toRad(lat2 - lat1);
                    var dLng = toRad(lng2 - lng1);
                    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                        Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
                        Math.sin(dLng / 2) * Math.sin(dLng / 2);
                    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                    var distance = R * c;

                    var maxDistance = parseInt("{{ $gigData->max_distance }}") || 100;
                    if (maxDistance === 30) maxDistance = 100; // 30+ miles means 100 miles max

                    if (distance <= maxDistance) {
                        $('#my_location').val('Yes');
                    } else {
                        $('#my_location').val('No');
                        alert("Service is not available in this area");
                    }
                }

                $(document).ready(function () {
                    updateWorkLocation();
                    $('#service_delivery').on('change', updateWorkLocation);

                    $(document).on('focus', '#work_site', function () {
                        if ($(this).val().trim() === '') {
                            $('#nearme_dropdown').show();
                        }
                    });

                    $(document).on('input', '#work_site', function () {
                        $('#nearme_dropdown').toggle($(this).val().trim() === '');
                    });

                    $(document).on('click', '#nearme_option', function () {
                        $('#nearme_dropdown').hide();
                        getUserLocation();
                    });

                    $(document).on('click', function (event) {
                        if (!$(event.target).closest('#work_location_div').length) {
                            $('#nearme_dropdown').hide();
                        }
                    });
                });


            });


        </script>
        {{-- Street Address Google Api Script END --}}

    @endif

    <!-- ================= -->
    <!-- =CARD SLIDER JS== -->
    <!-- ================= -->
    <script>
        jQuery("#carousel").owlCarousel({
            autoplay: true,
            rewind: true,
            /* use rewind if you don't want loop */
            margin: 20,
            /*
                animateOut: 'fadeOut',
                animateIn: 'fadeIn',
                */
            responsiveClass: true,
            autoHeight: true,
            autoplayTimeout: 7000,
            smartSpeed: 800,
            nav: true,
            responsive: {
                0: {
                    items: 1,
                },

                600: {
                    items: 2,
                },

                1024: {
                    items: 2.5,
                },

                1366: {
                    items: 2.5,
                },
            },
        });
    </script>
    <script>
        jQuery("#carousel2").owlCarousel({
            autoplay: true,
            rewind: true,
            /* use rewind if you don't want loop */
            margin: 20,
            /*
                animateOut: 'fadeOut',
                animateIn: 'fadeIn',
                */
            responsiveClass: true,
            autoHeight: true,
            autoplayTimeout: 7000,
            smartSpeed: 800,
            nav: true,
            responsive: {
                0: {
                    items: 1,
                },

                600: {
                    items: 2,
                },

                1024: {
                    items: 2.5,
                },

                1366: {
                    items: 2.5,
                },
            },
        });
    </script>
    <!-- ================= -->
    <!-- =CARD SLIDER JS== -->
    <!-- ================= -->
</body>

</html>
<!-- ============ Tabs js here ============= -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tabList = document.querySelector('.tabs-nav');
        const tabs = tabList.querySelectorAll('.tab-button');
        const panels = document.querySelectorAll('.tab-panel');
        const indicator = document.querySelector('.tabs-indicator');

        const setIndicatorPosition = (tab) => {
            indicator.style.transform = `translateX(${tab.offsetLeft}px)`;
            indicator.style.width = `${tab.offsetWidth}px`;
        };

        // Set initial indicator position
        setIndicatorPosition(tabs[0]);

        tabs.forEach((tab) => {
            tab.addEventListener('click', (e) => {
                const targetTab = e.target;
                const targetPanel = document.querySelector(
                    `#${targetTab.getAttribute('aria-controls')}`
                );

                // Update tabs
                tabs.forEach((tab) => {
                    tab.setAttribute('aria-selected', false);
                    tab.classList.remove('active');
                });
                targetTab.setAttribute('aria-selected', true);
                targetTab.classList.add('active');

                // Update panels
                panels.forEach((panel) => {
                    panel.setAttribute('aria-hidden', true);
                });
                targetPanel.setAttribute('aria-hidden', false);

                // Move indicator
                setIndicatorPosition(targetTab);
            });
        });

        // Keyboard navigation
        tabList.addEventListener('keydown', (e) => {
            const targetTab = e.target;
            const previousTab = targetTab.previousElementSibling;
            const nextTab = targetTab.nextElementSibling;

            if (e.key === 'ArrowLeft' && previousTab) {
                previousTab.click();
                previousTab.focus();
            }
            if (e.key === 'ArrowRight' && nextTab) {
                nextTab.click();
                nextTab.focus();
            }
        });
    });
</script>
<!--===== Herro product slider-JS ====== -->
{{-- Service Share script start ========== --}}
<script>
    function getShareURL(platform) {
        let pageUrl = encodeURIComponent(window.location.href);
        let text = encodeURIComponent("Check out this service!");

        let shareUrls = {
            whatsapp: `https://wa.me/?text=${text}%20${pageUrl}`,
            twitter: `https://twitter.com/intent/tweet?text=${text}&url=${pageUrl}`,
            facebook: `https://www.facebook.com/sharer/sharer.php?u=${pageUrl}`,
            instagram: "#", // Instagram does not support direct sharing via URL
            linkedin: `https://www.linkedin.com/sharing/share-offsite/?url=${pageUrl}`
        };

        window.open(shareUrls[platform], "_blank");
    }
</script>

{{-- Service Share script END ========== --}}
<script>
    $(document).ready(function () {
        var sync1 = $("#sync1");
        var sync2 = $("#sync2");
        var slidesPerPage = 4; //globaly define number of elements per page
        var syncedSecondary = true;

        sync1
            .owlCarousel({
                items: 1,
                slideSpeed: 2000,
                nav: true,
                autoplay: false,
                dots: true,
                loop: true,
                responsiveRefreshRate: 200,
                navText: [
                    '<svg width="100%" height="100%" viewBox="0 0 11 20"><path style="fill:none;stroke-width: 1px;stroke: #fff;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>',
                    '<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1"><path style="fill:none;stroke-width: 1px;stroke: #ffff;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>',
                ],
            })
            .on("changed.owl.carousel", syncPosition);

        sync2
            .on("initialized.owl.carousel", function () {
                sync2.find(".owl-item").eq(0).addClass("current");
            })
            .owlCarousel({
                items: slidesPerPage,
                dots: true,
                nav: true,
                smartSpeed: 200,
                slideSpeed: 500,
                slideBy: slidesPerPage, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
                responsiveRefreshRate: 100,
            })
            .on("changed.owl.carousel", syncPosition2);

        function syncPosition(el) {
            //if you set loop to false, you have to restore this next line
            //var current = el.item.index;

            //if you disable loop you have to comment this block
            var count = el.item.count - 1;
            var current = Math.round(el.item.index - el.item.count / 2 - 0.5);

            if (current < 0) {
                current = count;
            }
            if (current > count) {
                current = 0;
            }

            //end block

            sync2
                .find(".owl-item")
                .removeClass("current")
                .eq(current)
                .addClass("current");
            var onscreen = sync2.find(".owl-item.active").length - 1;
            var start = sync2.find(".owl-item.active").first().index();
            var end = sync2.find(".owl-item.active").last().index();

            if (current > end) {
                sync2.data("owl.carousel").to(current, 100, true);
            }
            if (current < start) {
                sync2.data("owl.carousel").to(current - onscreen, 100, true);
            }
        }

        function syncPosition2(el) {
            if (syncedSecondary) {
                var number = el.item.index;
                sync1.data("owl.carousel").to(number, 100, true);
            }
        }

        sync2.on("click", ".owl-item", function (e) {
            e.preventDefault();
            var number = $(this).index();
            sync1.data("owl.carousel").to(number, 300, true);
        });
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

<!-- offcanvas js start  -->

<!-- offcanvas js end  -->

</script>
<!-- radio buttons hide and show js -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var yesRadio = document.getElementById("yes");
        var noRadio = document.getElementById("no");
        var completeBookingBtn = document.getElementById("complete-booking");

        // Initially show the button since "Yes" is selected by default
        completeBookingBtn.style.display = "block";

        // Add event listener to the "Yes" radio button
        yesRadio.addEventListener("change", function () {
            completeBookingBtn.style.display = "block";
        });

        // Add event listener to the "No" radio button
        noRadio.addEventListener("change", function () {
            completeBookingBtn.style.display = "none";
        });
    });
</script>

<!-- see more less review detail js here -->
<script>
    // requires jquery
    $(document).ready(function () {
        (function () {
            var showChar = 400; // Number of characters to show by default
            var ellipsestext = "..."; // Ellipses after the truncated text

            $(".truncate").each(function () {
                var content = $(this).find("p").html(); // Targeting the content inside <p>
                if (content.length > showChar) {
                    var visibleText = content.substr(0, showChar); // Show the initial part
                    var hiddenText = content.substr(showChar); // The remaining hidden part
                    var html = visibleText +
                        '<span class="moreellipses">' + ellipsestext +
                        '</span><span class="morecontent" style="display:none;">' + hiddenText +
                        '</span>&nbsp;&nbsp;<a href="#" class="moreless more">See more</a>';

                    $(this).find("p").html(html);
                }
            });

            $(".moreless").click(function (e) {
                e.preventDefault();
                var $this = $(this);
                if ($this.hasClass("more")) {
                    $this.prev(".morecontent").slideDown(); // Show hidden content
                    $this.prev(".moreellipses").hide(); // Hide ellipses
                    $this.removeClass("more").addClass("less").text("See less");
                } else {
                    $this.prev(".morecontent").slideUp(); // Hide content again
                    $this.prev(".moreellipses").show(); // Show ellipses again
                    $this.removeClass("less").addClass("more").text("more");
                }
            });

        })();
    });
</script>
<!-- ===================== UPDATED CODE END ==================== -->
<!-- Hidden Input Field -->

<script>
    $(document).ready(function () {
        var maxField = 10; //Input fields increment limitation
        var fieldHTML = '<div><input class="add-input" type="datetime-local" name="field_name[]" value="" placeholder="Select Date & Time"/><a href="javascript:void(0);" class="remove_button" title="Remove field"><img src="assets/public-site/asset/img/remove-icon.svg"/></a></div>'; //New input field html

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

<!-- multiple select emails -->
<script>
    $(".enter-mail-id").keydown(function (e) {
        if (e.keyCode == 32 || e.keyCode == 13) {
            var inputText = $(this).val().trim(); // Get the input text
            var emails = inputText.split(/\s+/); // Split input text by whitespace
            var containerId = $(this).attr('id').replace('enter-mail-id-', 'all-mail-');

            // Iterate over each email
            emails.forEach(function (email) {
                // Trim whitespace from each email
                var trimmedEmail = email.trim();
                if (trimmedEmail !== '') { // Check if email is not empty
                    $('#' + containerId).append('<span class="email-ids">' + trimmedEmail + ' <span class="cancel-email">x</span></span>');
                }
            });

            $(this).val(''); // Clear the input field
        }
    });

    $(document).on('click', '.cancel-email', function () {
        $(this).parent().remove();
    });
</script>
<!-- ended -->
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
</script>
<!--=========== FAQ CSS ==============-->
<script>
    $(document).ready(function () {
        $(".accordion-list > li > .answer").hide();

        $(".accordion-list > li").click(function () {
            if ($(this).hasClass("active")) {
                $(this).removeClass("active").find(".answer").slideUp();
            } else {
                $(".accordion-list > li.active .answer").slideUp();
                $(".accordion-list > li.active").removeClass("active");
                $(this).addClass("active").find(".answer").slideDown();
            }
            return false;
        });
    });
</script>
<!--=========== FAQ CSS ==============-->


{{-- Appointment Calender Booking ==== Start --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<!-- Load Moment Timezone -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.40/moment-timezone-with-data.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
{{--
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> --}}
<script type="text/javascript" src="assets/calender/js/mark-your-calendar.js"></script>
<script type="text/javascript">


    (function ($) {

        function generateTimeSlots(startTime, endTime, teacherTimeZone, userTimeZone, currentDate, minStartTime = null) {
            let slots = [];
            // Create a full datetime by combining the date with the time in teacher's timezone
            let dateStr = moment(currentDate).format("YYYY-MM-DD");
            let start = moment.tz(`${dateStr} ${startTime}`, "YYYY-MM-DD HH:mm", teacherTimeZone);
            let end = moment.tz(`${dateStr} ${endTime}`, "YYYY-MM-DD HH:mm", teacherTimeZone);

            while (start.isBefore(end)) {
                let convertedTime = start.clone().tz(userTimeZone);
                if (!minStartTime || convertedTime.isSameOrAfter(minStartTime)) {
                    slots.push(convertedTime.format("HH:mm"));
                }
                start.add(30, "minutes");
            }

            return slots;
        }


        let profile = @json($profile);
        let gigPayment = @json($gigPayment);
        let gigData = @json($gigData);
        let duration = @json($admin_duration);
        let service_type = @json($gig->service_type);
        let bookedTimes = @json($bookedTimes) ||
            [];
        let repeatDays = @json($repeatDays);

        let group_type = $('#group_type').val();
        let today = moment();
        let selectedDates = {};
        let isSubscription = gigData.payment_type === "Subscription";
        let maxAllowedDate = isSubscription ? moment().add(1, "month") : null;
        let timeZones = moment.tz.zonesForCountry(profile.country_code);
        // let teacherTimeZone = "Europe/London"; // Example: From the database
        let teacherTimeZone = (timeZones && timeZones.length > 0) ? timeZones[0] : "UTC";
        let userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        $('#time_zone_show').html(`Show Date/Time Based on ${userTimeZone}`);
        $('#user_time_zone').val(userTimeZone);
        $('#teacher_time_zone').val(teacherTimeZone);


        if (typeof bookedTimes === "string") {
            try {
                bookedTimes = JSON.parse(bookedTimes);
            } catch (error) {
                console.error("Error parsing bookedTimes JSON:", error);
                bookedTimes = [];
            }
        }

        if (!Array.isArray(bookedTimes)) {
            bookedTimes = Object.values(bookedTimes);
        }

        function getBlockedSlots() {
            let blockedSlots = {};
            bookedTimes.forEach((booking) => {
                let { date, duration } = booking;
                if (!date || !duration) return;

                let [formattedDate, bookedStartTime] = date.split(" ");
                bookedStartTime = moment(bookedStartTime, "HH:mm");

                let bookedDurationMinutes = duration.split(":").reduce((h, m) => parseInt(h) * 60 + parseInt(m), 0);
                let serviceDurationMinutes = gigPayment.duration.split(":").reduce((h, m) => parseInt(h) * 60 + parseInt(m), 0);
                let blockStartTime = moment(bookedStartTime).subtract(serviceDurationMinutes, "minutes");

                if (!blockedSlots[formattedDate]) blockedSlots[formattedDate] = new Set();

                let tempBeforeTime = moment(blockStartTime);
                for (let beforeMinutes = serviceDurationMinutes; beforeMinutes > 0; beforeMinutes -= 30) {
                    blockedSlots[formattedDate].add(tempBeforeTime.format("HH:mm"));
                    tempBeforeTime.add(30, "minutes");
                }

                let tempAfterTime = moment(bookedStartTime);
                for (let afterMinutes = bookedDurationMinutes; afterMinutes > 0; afterMinutes -= 30) {
                    blockedSlots[formattedDate].add(tempAfterTime.format("HH:mm"));
                    tempAfterTime.add(30, "minutes");
                }
            });
            return blockedSlots;
        }

        let blockedSlots = getBlockedSlots();


        function generateAvailability(startDate, teacherTimeZone, userTimeZone) {
            let availability = new Array(30).fill(null).map(() => []);
            let now = moment().tz(userTimeZone);
            let minStartTime = now.clone();

            if (gigData.recurring_type === "OneDay") {
                var duration_booking = duration.class_oneday || 1;
            } else if (service_type === "Inperson") {
                var duration_booking = duration.class_inperson || 4;
            } else if (service_type === "Online") {
                var duration_booking = duration.class_online || 3;
            }


            minStartTime.add(duration_booking, "hours");


            for (let i = 0; i < 30; i++) {
                let currentDate = moment(startDate).add(i, "days");
                let dayName = currentDate.format("dddd");
                let formattedDate = currentDate.format("YYYY-MM-DD");
                let nextDayIndex = i + 1;

                let currentDaySlots = [];
                let extendedSlots = [];

                repeatDays.forEach((repeatDay) => {
                    if (repeatDay.day === dayName) {
                        let slots = generateTimeSlots(
                            repeatDay.start_time,
                            repeatDay.end_time,
                            teacherTimeZone,
                            userTimeZone,
                            currentDate,
                            currentDate.isSame(now, 'day') ? minStartTime : null
                        );

                        if (blockedSlots[formattedDate]) {
                            slots = slots.filter((slot) => !blockedSlots[formattedDate].has(slot));
                        }

                        slots.forEach(slot => {
                            if (slot === "00:00" || slot < "04:00") {
                                extendedSlots.push(slot);
                            } else {
                                currentDaySlots.push(slot);
                            }
                        });

                        if (availability[i].length > 0) {
                            currentDaySlots = [...availability[i], ...currentDaySlots];
                        }

                        availability[i] = currentDaySlots;

                        if (extendedSlots.length > 0 && nextDayIndex < 30) {
                            availability[nextDayIndex] = [...extendedSlots, ...availability[nextDayIndex]];
                        }
                    }
                });
            }

            return availability;
        }


        // Check if it's a one-day class
        let isOneDayClass = gigPayment.start_date !== null;
        let startDate = isOneDayClass ? moment(gigPayment.start_date) : today;
        let availability;

        if (isOneDayClass) {
            availability = new Array(2).fill(null).map(() => []);
            let now = moment().tz(userTimeZone);
            let minStartTime = now.clone();


            if (gigData.recurring_type === "OneDay") {
                var duration_booking = duration.class_oneday || 1;
            } else if (service_type === "Inperson") {
                var duration_booking = duration.class_inperson || 4;
            } else if (service_type === "Online") {
                var duration_booking = duration.class_online || 3;
            }
            minStartTime.add(duration_booking, "hours");


            let slots = generateTimeSlots(
                gigPayment.start_time,
                gigPayment.end_time,
                teacherTimeZone,
                userTimeZone,
                startDate,
                startDate.isSame(now, 'day') ? minStartTime : null
            );


            let formattedDate = startDate.format("YYYY-MM-DD");
            let nextDate = startDate.clone().add(1, "day").format("YYYY-MM-DD");

            if (blockedSlots[formattedDate]) {
                slots = slots.filter((slot) => !blockedSlots[formattedDate].has(slot));
            }

            let currentDaySlots = [];
            let extendedSlots = [];

            slots.forEach(slot => {
                if (slot === "00:00" || slot < "04:00") {
                    extendedSlots.push(slot);
                } else {
                    currentDaySlots.push(slot);
                }


            });

            availability[0] = currentDaySlots;

            if (extendedSlots.length > 0) {
                availability[1] = [...extendedSlots];
            }
        } else {
            // Generate availability for recurring class
            availability = generateAvailability(today, teacherTimeZone, userTimeZone);
        }


        let currentViewDate = today; // Track the current view date

        // Function to update navigation arrows based on the current view
        function updateNavigationArrows() {
            let isFirstDateToday = currentViewDate.isSame(today, "day"); // Check if current view is today
            let isAtMaxAllowedDate = isSubscription && currentViewDate.isSame(maxAllowedDate, "day");


            $("#myc-prev-week").toggle(!isFirstDateToday);

            $("#myc-next-week").toggle(!(isSubscription && isAtMaxAllowedDate));
        }

        $("#picker").markyourcalendar({
            availability: availability,
            isMultiple: true,
            startDate: startDate.toDate(),
            onClick: function (ev, data) {
                var frequency = $('#frequency').val() || 1; // Maximum allowed selections

                var duration = gigPayment.duration; // Example: "2:30" or "00:30"
                var durationParts = duration.split(":"); // Split into ["HH", "mm"]

                var durationMinutes = (parseInt(durationParts[0]) * 60) + parseInt(durationParts[1]); // Convert to total minutes
                var selectedDate = moment(ev.date).format("YYYY-MM-DD");

                // Extract the last clicked slot (latest selection)
                let lastClickedSlot = data[data.length - 1];

                if (!lastClickedSlot) {
                    $("#selected-dates").html("");

                    $("#selected_slots").val(""); // Set class_time to empty
                    $("#class_time").val(""); // Set class_time to empty
                    $("#teacher_class_time").val("");
                    return;
                }

                let lastClickedParts = lastClickedSlot.split(" ");
                let lastClickedDateTime = `${lastClickedParts[0]} ${lastClickedParts[1]}`; // Full date and time
                let lastClickedMoment = moment(lastClickedDateTime, "YYYY-MM-DD HH:mm");

                if (!selectedDates[selectedDate]) {
                    selectedDates[selectedDate] = [];
                }


                let existingSlots = selectedDates[selectedDate];

                // ✅ Exclude the last clicked slot from the comparison
                let isInvalid = false;
                for (let slot of existingSlots) {
                    if (slot === lastClickedSlot) continue; // Skip comparing with itself

                    let slotParts = slot.split(" ");
                    let slotDateTime = `${slotParts[0]} ${slotParts[1]}`; // Full date and time
                    let slotMoment = moment(slotDateTime, "YYYY-MM-DD HH:mm");
                    let diff = Math.abs(lastClickedMoment.diff(slotMoment, "minutes"));


                    if (diff < durationMinutes) {
                        isInvalid = true;
                        break; // Stop checking once we find an invalid slot
                    }
                }

                if (isInvalid) {
                    data.pop(); // Remove last clicked slot
                    $(`[data-date="${lastClickedParts[0]}"][data-time="${lastClickedParts[1]}"]`).removeClass("selected");

                    alert(`You must select slots with at least ${durationMinutes} minutes gap on the same date.`);
                    return; // Stop execution
                }

                if (data.length > frequency) {
                    let removedSlot = data.pop(); // Remove last clicked slot
                    let removedSlotParts = removedSlot.split(' ');

                    // Remove class from the last clicked slot in the UI
                    $(`[data-date="${removedSlotParts[0]}"][data-time="${removedSlotParts[1]}"]`).removeClass("selected");

                    alert(`You can select maximum ${frequency} slots.`);
                }

                // ✅ Store selected slots in the global object
                selectedDates[selectedDate] = data;

                let selectedValues = [];
                let selectedSlots = [];
                let teacher_time_slots = []; // Store converted times in teacher's time zone
                var html = ``;
                let timePromises = [];
                $.each(selectedDates, function (date, times) {
                    $.each(times, function (index, time) {

                        let userTime = moment.tz(`${time}`, "YYYY-MM-DD HH:mm", userTimeZone);
                        let teacherTime = userTime.clone().tz(teacherTimeZone);
                        let teacherFormattedTime = teacherTime.format("YYYY-MM-DD HH:mm");

                        // Get duration from gigPayment
                        let durationMinutes = gigPayment.duration.split(":").reduce((h, m) => parseInt(h) * 60 + parseInt(m), 0);

                        // Calculate end time based on USER timezone
                        let endTime = userTime.clone().add(durationMinutes, "minutes");

                        // ✅ Format for display in USER TIMEZONE: "Fri Nov 8, 2024 11am – 11:30am"
                        let formattedDisplay = userTime.format("ddd MMM D, YYYY h:mma") + " – " + endTime.format("h:mma");


                        let selector = teacherFormattedTime;
                        timePromises.push(GetAvailableTimes(selector));

                        teacher_time_slots.push(teacherFormattedTime); // Store converted teacher times
                        selectedValues.push(`${time}`);
                        selectedSlots.push(`${formattedDisplay}`);
                        html += `<p><strong style="color:var(--Colors-Logo-Color, #0072b1);">Class ${selectedValues.length}:</strong>  ${formattedDisplay}</p>`;
                    });
                });


                Promise.allSettled(timePromises).then((results) => {
                    let hasError = results.some(r => r.status === "rejected");
                    if (hasError) {
                        data.pop(); // Remove last clicked slot
                        return; // Stop execution if any error occurred
                    }

                    $("#selected-dates").html(html);
                    $("#selected_slots").val(selectedSlots.join("|*|"));
                    $("#class_time").val(selectedValues.join(","));
                    $("#teacher_class_time").val(teacher_time_slots.join(","));
                });
            }
            ,

            onClickNavigator: function (ev, instance) {


                let direction = ev.target.id === "myc-next-week" ? "forward" : "back";


                // Update currentViewDate based on the navigation direction
                if (direction === "back") {
                    currentViewDate = moment(currentViewDate).subtract(1, "week");
                } else if (direction === "forward") {
                    // currentViewDate = moment(currentViewDate).add(1, "week");
                    let nextDate = moment(currentViewDate).add(1, "week");
                    if (isSubscription && nextDate.isAfter(maxAllowedDate, "day")) {

                        return; // Prevent moving beyond 1 month
                    }
                    currentViewDate = nextDate;
                }

                let selectedDate = moment(ev.date).format("YYYY-MM-DD");

                // Check if the selected date is in the past
                if (moment(selectedDate).isBefore(today, "day")) {
                    alert("You cannot select past dates.");
                    return false;
                }

                // Generate availability for the selected date
                let newAvailability = generateAvailability(selectedDate, teacherTimeZone, userTimeZone);
                instance.setAvailability(newAvailability);

                // ✅ Ensure navigation arrows update correctly
                updateNavigationArrows();

                // Reapply the selected class to slots for the current date
                setTimeout(() => {
                    $.each(selectedDates, function (date, times) {
                        $.each(times, function (index, time) {
                            selected_t_d = time.split(' ');

                            $(`[data-date="${selected_t_d[0]}"][data-time="${selected_t_d[1]}"]`).addClass("selected");
                        });
                    });
                }, 100);
            }

        });

        // Hide previous navigation arrow on page load (since the calendar starts from today)
        $("#myc-prev-week").hide();
        // Hide navigation arrows for one-day class
        if (isOneDayClass) {
            $("#myc-prev-week").hide(); // Hide previous and next buttons
            $("#myc-next-week").hide(); // Hide previous and next buttons
        }

        function updateInputField() {

        }

        // Get Available Times ========
        function GetAvailableTimes(selector) {
            var date_time = selector;
            var gig_id = @json($gig->id);
            var group_type = $('#group_type').val() || null;
            var guests = $('#guests').val() || 1;

            return new Promise((resolve, reject) => {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: '/get-available-times',
                    data: { gig_id: gig_id, date_time: date_time, group_type: group_type, _token: '{{csrf_token()}}' },
                    dataType: 'json',
                    success: function (response) {


                        if (response.success) {
                            if (response.allowed_guests) {
                                let $guestsInput = $('#guests');
                                let enteredGuests = parseInt($guestsInput.val(), 10) || 0;
                                let allowedGuests = response.allowed_guests;

                                if (enteredGuests > allowedGuests) {
                                    $guestsInput.val(allowedGuests).focus();
                                    alert(`Maximum ${allowedGuests} guests allowed for booking at this time.`);
                                }
                            }
                            resolve(response);
                        } else if (response.group_full) {

                            var duration = gigPayment.duration; // Example: "1:30" or "00:30"
                            var durationParts = duration.split(":"); // Split into ["HH", "mm"]

                            var durationMinutes = (parseInt(durationParts[0]) * 60) + parseInt(durationParts[1]); // Convert to total minutes

                            let date_timeParts = date_time.split(' ');
                            let selectedDate = date_timeParts[0];
                            let selectedTime = date_timeParts[1];

                            let selectedMoment = moment(`${selectedDate} ${selectedTime}`, "YYYY-MM-DD HH:mm");
                            let slotsToRemove = [];

                            // Always remove the selected slot
                            slotsToRemove.push(selectedMoment.format("YYYY-MM-DD HH:mm"));

                            // Remove previous slot only if duration is 1 hour or more
                            if (durationMinutes >= 60) {
                                slotsToRemove.push(selectedMoment.clone().subtract(30, "minutes").format("YYYY-MM-DD HH:mm"));
                            }

                            // Remove future slots based on duration
                            for (let i = 30; i < durationMinutes; i += 30) { // Start at 30 minutes, up to total duration
                                slotsToRemove.push(selectedMoment.clone().add(i, "minutes").format("YYYY-MM-DD HH:mm"));
                            }


                            // Remove slots from `selectedDates`
                            if (selectedDates[selectedDate]) {
                                selectedDates[selectedDate] = selectedDates[selectedDate].filter(slot => !slotsToRemove.includes(slot));
                            }

                            // Remove class from UI (deselect slots)
                            slotsToRemove.forEach(slot => {
                                let TeacherTime = moment.tz(`${slot}`, "YYYY-MM-DD HH:mm", teacherTimeZone);
                                let UserTime = TeacherTime.clone().tz(userTimeZone);
                                slot = UserTime.format("YYYY-MM-DD HH:mm");
                                let slotParts = slot.split(" ");
                                let slotElement = $(`[data-date="${slotParts[0]}"][data-time="${slotParts[1]}"]`);

                                if (slotElement.length > 0) {
                                    slotElement.remove();  // Remove the slot from the UI
                                }
                            });

                            alert(response.group_full);
                            reject("group_full");
                        } else if (response.booked) {

                            let TeacherTime = moment.tz(`${response.bookedTime}`, "YYYY-MM-DD HH:mm", teacherTimeZone);
                            let UserTime = TeacherTime.clone().tz(userTimeZone);
                            slot = UserTime.format("YYYY-MM-DD HH:mm");
                            let slotParts = slot.split(" ");
                            let slotElement = $(`[data-date="${slotParts[0]}"][data-time="${slotParts[1]}"]`);

                            if (slotElement.length > 0) {
                                slotElement.remove();  // Remove the slot from the UI
                            }

                            alert(response.booked);
                            reject("error");
                        } else {
                            alert(response.error);
                            reject("error");
                        }
                    },
                    error: function () {
                        reject("ajax_error");
                    }
                });
            });
        }


    })(jQuery);


</script>


{{-- Appointment Calender Booking ==== END --}}

{{-- Google Analytics 4 - Track View Item --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof DreamCrowdAnalytics !== 'undefined') {
            DreamCrowdAnalytics.trackViewItem({
                item_id: '{{ $gig->id }}',
                item_name: '{{ addslashes($gig->title) }}',
                item_category: '{{ $gig->category ?? "Uncategorized" }}',
                price: {{ $gigPayment->price ?? 0 }},
                currency: 'USD',
                service_type: '{{ $gig->service_role ?? "unknown" }}',
                delivery_type: '{{ $gig->service_type ?? "unknown" }}',
                seller_id: '{{ $gig->user_id }}',
                rating: {{ $gig->all_reviews->avg('stars') ?? 0 }},
                review_count: {{ $gig->all_reviews->count() ?? 0 }}
            });
        }
    });
</script>