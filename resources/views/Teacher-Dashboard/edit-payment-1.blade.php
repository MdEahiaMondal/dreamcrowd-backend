<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8"/>
    <!-- View Point scale to 1.0 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!-- Animate css -->
    <link rel="stylesheet" href="assets/teacher/libs/animate/css/animate.css"/>
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="assets/teacher/libs/aos/css/aos.css"/>
    <!-- Datatable css  -->
    <link rel="stylesheet" href="assets/teacher/libs/datatable/css/datatable.css"/>
    {{-- Fav Icon --}}
    @php  $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
    @endif
    <!-- Select2 css -->
    <link href="assets/teacher/libs/select2/css/select2.min.css" rel="stylesheet"/>
    <!-- Owl carousel css -->
    <link href="assets/teacher/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet"/>
    <link href="assets/teacher/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet"/>
    <!-- Bootstrap css -->
    <link
        rel="stylesheet"
        type="text/css"
        href="assets/teacher/asset/css/bootstrap.min.css"
    />
    <link
        href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"
        rel="stylesheet"
    />
    <link
        rel="stylesheet"
        href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
    />
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    {{-- =======Toastr CDN ======== --}}
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- =======Toastr CDN ======== --}}
    <!-- Fontawesome CDN -->
    <script
        src="https://kit.fontawesome.com/be69b59144.js"
        crossorigin="anonymous"
    ></script>

    <link rel="stylesheet" href="assets/teacher/asset/css/payment.css"/>
    <link
        rel=" stylesheet "
        type=" text/css "
        href="assets/teacher/asset/css/class-management.css"
    />
    <link rel=" stylesheet " href=" assets/teacher/asset/css/Learn-How.css "/>
    <link rel="stylesheet" href="assets/teacher/asset/css/sidebar.css"/>
    <link rel="stylesheet" href="assets/teacher/asset/css/style.css"/>

    <!-- Include Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <title>Payment</title>
</head>

<style>
    .repeat-btn.active {
        background-color: #0072b1;
        color: white;
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

{{-- ===========Teacher Sidebar Start==================== --}}
<x-teacher-sidebar/>
{{-- ===========Teacher Sidebar End==================== --}}
<section class="home-section">
    {{-- ===========Teacher NavBar Start==================== --}}
    <x-teacher-nav/>
    {{-- ===========Teacher NavBar End==================== --}}
    <!-- =============================== MAIN CONTENT START HERE =========================== -->
    <div class="container-fluid">
        <div class="row payment-page">
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
                    <ol class="breadcrumb mt-3">
                        <li
                            class="breadcrumb-item active braedDashboard"
                            aria-current="page"
                        >
                            <a href="#">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item braedClassManagment">
                            <a href="">Class Managements</a>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-12">
                <div class="onlineClass-banner">
                    <img src="assets/teacher/asset/img/banner-icon.png" alt=""/>
                    <span>Dynamic Management</span>
                </div>
            </div>

            <form id="myForm" action="/class-gig-payment-update" method="POST" enctype="multipart/form-data"> @csrf

                <div class="col-md-12">
                    <div class="row payment-type mx-1 my-3">
                        <div class="col-md-12">
                            <h3 class="online-Class-Select-Heading">Payment Type</h3>
                            <div class="select-box">
                                <input type="hidden" name="gig_id" value="{{$gig_id}}">
                                <select name="payment_type" id=" sample " class="fa">
                                    @if ($gigData->payment_type == 'OneOff')
                                        <option value="OneOff" class="fa" selected> One-Of Payment</option>

                                    @else
                                        <option value="Subscription" class="fa" selected>Subscription</option>

                                    @endif

                                </select>
                            </div>
                        </div>

                        {{-- ✅ Trial Class Alert Messages --}}
                        @if ($gigData->recurring_type == 'Trial')
                            @if ($gigData->trial_type == 'Free')
                                <div class="col-md-12">
                                    <div class="alert alert-success"
                                         style="background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 8px; padding: 15px; margin-top: 20px;">
                                        <i class="fas fa-gift" style="color: #28a745; margin-right: 8px;"></i>
                                        <strong style="color: #155724;">Free Trial Class:</strong>
                                        <span style="color: #155724;">This is a FREE trial session (30 minutes). No payment required from students.</span>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12">
                                    <div class="alert alert-info"
                                         style="background-color: #d1ecf1; border: 1px solid #bee5eb; border-radius: 8px; padding: 15px; margin-top: 20px;">
                                        <i class="fas fa-dollar-sign" style="color: #0c5460; margin-right: 8px;"></i>
                                        <strong style="color: #0c5460;">Paid Trial Class:</strong>
                                        <span style="color: #0c5460;">Set your pricing and duration below.</span>
                                    </div>
                                </div>
                            @endif
                        @endif

                        {{-- ✅ Pricing Section (Hide for Free Trial) --}}
                        @if ($gigData->recurring_type != 'Trial' || $gigData->trial_type != 'Free')
                            <div class="row">
                                <h3
                                    class="online-Class-Select-Heading"
                                    style="margin-top: 24px"
                                >
                                    How much would you charge per class and per person?
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                    >
                                        <path
                                            d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 13.5C6.91221 13.5 5.84884 13.1774 4.94437 12.5731C4.0399 11.9687 3.33495 11.1098 2.91867 10.1048C2.50238 9.09977 2.39347 7.9939 2.60568 6.927C2.8179 5.86011 3.34173 4.8801 4.11092 4.11091C4.8801 3.34172 5.86011 2.8179 6.92701 2.60568C7.9939 2.39346 9.09977 2.50238 10.1048 2.91866C11.1098 3.33494 11.9687 4.03989 12.5731 4.94436C13.1774 5.84883 13.5 6.9122 13.5 8C13.4983 9.45818 12.9184 10.8562 11.8873 11.8873C10.8562 12.9184 9.45819 13.4983 8 13.5ZM9 11C9 11.1326 8.94732 11.2598 8.85356 11.3536C8.75979 11.4473 8.63261 11.5 8.5 11.5C8.23479 11.5 7.98043 11.3946 7.7929 11.2071C7.60536 11.0196 7.5 10.7652 7.5 10.5V8C7.36739 8 7.24022 7.94732 7.14645 7.85355C7.05268 7.75979 7 7.63261 7 7.5C7 7.36739 7.05268 7.24021 7.14645 7.14645C7.24022 7.05268 7.36739 7 7.5 7C7.76522 7 8.01957 7.10536 8.20711 7.29289C8.39465 7.48043 8.5 7.73478 8.5 8V10.5C8.63261 10.5 8.75979 10.5527 8.85356 10.6464C8.94732 10.7402 9 10.8674 9 11ZM7 5.25C7 5.10166 7.04399 4.95666 7.1264 4.83332C7.20881 4.70999 7.32595 4.61386 7.46299 4.55709C7.60003 4.50032 7.75083 4.48547 7.89632 4.51441C8.04181 4.54335 8.17544 4.61478 8.28033 4.71967C8.38522 4.82456 8.45665 4.9582 8.48559 5.10368C8.51453 5.24917 8.49968 5.39997 8.44291 5.53701C8.38615 5.67406 8.29002 5.79119 8.16668 5.8736C8.04334 5.95601 7.89834 6 7.75 6C7.55109 6 7.36032 5.92098 7.21967 5.78033C7.07902 5.63968 7 5.44891 7 5.25Z"
                                            fill="#0072B1"
                                        />
                                    </svg>
                                </h3>
                                <div class="col-md-6 col-sm-12">
                                    <h3
                                        class="online-Class-Select-Heading"
                                        style="margin-top: 16px"
                                    >
                                        Individual rate
                                    </h3>
                                    <input class="payment-input" value="{{$gigPayment->rate}}" name="rate" id="rate"
                                           placeholder="$50" type="number" onfocusout="validateRatePrice(this)"/>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <h3
                                        class="online-Class-Select-Heading"
                                        style="margin-top: 16px"
                                    >
                                        Your estimated Earnings 
                                    </h3>
                                    <input class="payment-input" value="{{$gigPayment->earning}}" name="earning"
                                           id="estimated_earning" placeholder="$50" readonly type="text"/>
                                </div>
                            </div>
                        @else
                            {{-- Free Trial: Hidden inputs with $0 --}}
                            <input type="hidden" name="rate" value="0">
                            <input type="hidden" name="earning" value="0">
                        @endif
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="row payment-type mx-1 my-3">
                        <div class="col-md-12">
                            <h3 class="online-Class-Select-Heading">
                                Can minors attend your class?
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    viewBox="0 0 16 16"
                                    fill="none"
                                >
                                    <path
                                        d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 13.5C6.91221 13.5 5.84884 13.1774 4.94437 12.5731C4.0399 11.9687 3.33495 11.1098 2.91867 10.1048C2.50238 9.09977 2.39347 7.9939 2.60568 6.927C2.8179 5.86011 3.34173 4.8801 4.11092 4.11091C4.8801 3.34172 5.86011 2.8179 6.92701 2.60568C7.9939 2.39346 9.09977 2.50238 10.1048 2.91866C11.1098 3.33494 11.9687 4.03989 12.5731 4.94436C13.1774 5.84883 13.5 6.9122 13.5 8C13.4983 9.45818 12.9184 10.8562 11.8873 11.8873C10.8562 12.9184 9.45819 13.4983 8 13.5ZM9 11C9 11.1326 8.94732 11.2598 8.85356 11.3536C8.75979 11.4473 8.63261 11.5 8.5 11.5C8.23479 11.5 7.98043 11.3946 7.7929 11.2071C7.60536 11.0196 7.5 10.7652 7.5 10.5V8C7.36739 8 7.24022 7.94732 7.14645 7.85355C7.05268 7.75979 7 7.63261 7 7.5C7 7.36739 7.05268 7.24021 7.14645 7.14645C7.24022 7.05268 7.36739 7 7.5 7C7.76522 7 8.01957 7.10536 8.20711 7.29289C8.39465 7.48043 8.5 7.73478 8.5 8V10.5C8.63261 10.5 8.75979 10.5527 8.85356 10.6464C8.94732 10.7402 9 10.8674 9 11ZM7 5.25C7 5.10166 7.04399 4.95666 7.1264 4.83332C7.20881 4.70999 7.32595 4.61386 7.46299 4.55709C7.60003 4.50032 7.75083 4.48547 7.89632 4.51441C8.04181 4.54335 8.17544 4.61478 8.28033 4.71967C8.38522 4.82456 8.45665 4.9582 8.48559 5.10368C8.51453 5.24917 8.49968 5.39997 8.44291 5.53701C8.38615 5.67406 8.29002 5.79119 8.16668 5.8736C8.04334 5.95601 7.89834 6 7.75 6C7.55109 6 7.36032 5.92098 7.21967 5.78033C7.07902 5.63968 7 5.44891 7 5.25Z"
                                        fill="#0072B1"
                                    />
                                </svg>
                            </h3>
                            <div class="rAdio-Section">
                                @if ($gigPayment->minor_attend == 1)
                                    <input class="radio-btn" name="minor_attend" onclick="MinorAttend(this.id)"
                                           id="minor_attend_1" value="1" type="radio" checked/>
                                    <span class="Yes">Yes</span>
                                    <input class="radio-btn" name="minor_attend" onclick="MinorAttend(this.id)"
                                           id="minor_attend_0" value="0" type="radio"/>
                                    <span class="Yes">No</span>
                                @else
                                    <input class="radio-btn" name="minor_attend" onclick="MinorAttend(this.id)"
                                           id="minor_attend_1" value="1" type="radio"/>
                                    <span class="Yes">Yes</span>
                                    <input class="radio-btn" name="minor_attend" onclick="MinorAttend(this.id)"
                                           id="minor_attend_0" value="0" type="radio" checked/>
                                    <span class="Yes">No</span>

                                @endif
                            </div>


                            <h3
                                class="online-Class-Select-Heading limit_show"
                                style="margin-top: 24px; margin-bottom: 16px"
                            >
                                Can minors attend your class?
                                <svg class="limit_show"
                                     xmlns="http://www.w3.org/2000/svg"
                                     width="16"
                                     height="16"
                                     viewBox="0 0 16 16"
                                     fill="none"
                                >
                                    <path
                                        d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 13.5C6.91221 13.5 5.84884 13.1774 4.94437 12.5731C4.0399 11.9687 3.33495 11.1098 2.91867 10.1048C2.50238 9.09977 2.39347 7.9939 2.60568 6.927C2.8179 5.86011 3.34173 4.8801 4.11092 4.11091C4.8801 3.34172 5.86011 2.8179 6.92701 2.60568C7.9939 2.39346 9.09977 2.50238 10.1048 2.91866C11.1098 3.33494 11.9687 4.03989 12.5731 4.94436C13.1774 5.84883 13.5 6.9122 13.5 8C13.4983 9.45818 12.9184 10.8562 11.8873 11.8873C10.8562 12.9184 9.45819 13.4983 8 13.5ZM9 11C9 11.1326 8.94732 11.2598 8.85356 11.3536C8.75979 11.4473 8.63261 11.5 8.5 11.5C8.23479 11.5 7.98043 11.3946 7.7929 11.2071C7.60536 11.0196 7.5 10.7652 7.5 10.5V8C7.36739 8 7.24022 7.94732 7.14645 7.85355C7.05268 7.75979 7 7.63261 7 7.5C7 7.36739 7.05268 7.24021 7.14645 7.14645C7.24022 7.05268 7.36739 7 7.5 7C7.76522 7 8.01957 7.10536 8.20711 7.29289C8.39465 7.48043 8.5 7.73478 8.5 8V10.5C8.63261 10.5 8.75979 10.5527 8.85356 10.6464C8.94732 10.7402 9 10.8674 9 11ZM7 5.25C7 5.10166 7.04399 4.95666 7.1264 4.83332C7.20881 4.70999 7.32595 4.61386 7.46299 4.55709C7.60003 4.50032 7.75083 4.48547 7.89632 4.51441C8.04181 4.54335 8.17544 4.61478 8.28033 4.71967C8.38522 4.82456 8.45665 4.9582 8.48559 5.10368C8.51453 5.24917 8.49968 5.39997 8.44291 5.53701C8.38615 5.67406 8.29002 5.79119 8.16668 5.8736C8.04334 5.95601 7.89834 6 7.75 6C7.55109 6 7.36032 5.92098 7.21967 5.78033C7.07902 5.63968 7 5.44891 7 5.25Z"
                                        fill="#0072B1"
                                    />
                                </svg>
                            </h3>
                            <select class="radio-input limit_show" name="age_limit" id="age_limit" class=" fa ">
                                @for ($i = 1; $i < 18; $i++)
                                    <option value="{{$i}}" class=" fa ">{{$i}}</option>

                                @endfor

                            </select>


                        </div>
                    </div>
                </div>


                <div class="col-md-12">


                    <div class="col-md-12">
                        <div class="row payment-type mx-1 my-3">
                            <div class="col-md-12">
                                <h3 class="online-Class-Select-Heading">
                                    Positive Search Terms (Optional)
                                </h3>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="input_positive_term"
                                    placeholder="Type and press Enter or comma......"
                                />

                                <input type="hidden" name="positive_term" id="positive_term"
                                       value="{{$gigPayment->positive_term}}">

                                <div id="positive_term_div" style="display: flex;gap: 10px;">
                                    @if ($gigPayment->positive_term)
                                        @php
                                            $positive_term = explode(',',$gigPayment->positive_term);
                                        @endphp

                                        @foreach ($positive_term as $item)
                                            <span class="slice mt-2"
                                                  style="background-color: rgb(0, 114, 177); color: rgb(255, 255, 255); padding: 0px 10px; border-radius: 4px; display: flex; align-items: center; gap: 10px; cursor: default; font-size: 16px; width: max-content;">{{$item}}<span
                                                    class="remove"
                                                    style="color: rgb(255, 255, 255); padding: 5px; cursor: pointer;">x</span></span>
                                        @endforeach
                                    @endif

                                </div>

                            </div>
                        </div>
                    </div>


                    {{-- Faqs Start ==== --}}
                    <div class="col-md-12">
                        <div class="row payment-type mx-1 my-3">
                            <div class="col-md-12">
                                <h3 class="online-Class-Select-Heading">
                                    Services FAQ'S (Optional)
                                </h3>

                                <button id="add_new_btn" class="teacher-next-btn float-end mb-3">Add</button>


                                <div class="row mt-3 mb-3" id="add_faqs_main_div" style="display: none">

                                    <div class="col-12 form-sec">
                                        <label for="inputAddress2" class="form-label online-Class-Select-Heading"
                                        >Question</label
                                        >
                                        <input type="hidden" value="{{$gig->id}}" name="faqs_gig_id" id="faqs_gig_id">
                                        <input
                                            type="text"
                                            class="form-control payment-input"
                                            id="question" name="question"
                                            placeholder="How This Work?" required
                                        />
                                    </div>
                                    <div class="col-12 mt-0 mb-3">
                                        <label for="inputAddress2" class="form-label online-Class-Select-Heading"
                                        >Answer</label
                                        >
                                        <br/>
                                        <textarea id="answer" name="answer"></textarea>
                                    </div>

                                    <div class="api-buttons">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <button type="button" id="add_faqs_btn"
                                                        class="btn float-end update-btn teacher-next-btn">
                                                    Add New
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div id="all_faqs" class="mb-3">

                                </div>

                                <div class="row mt-3 mb-3" id="edit_faqs_main_div" style="display: none">

                                    <div class="col-12 form-sec">
                                        <label for="inputAddress2" class="form-label online-Class-Select-Heading"
                                        >Question</label
                                        >
                                        <input type="hidden" name="faqs_id" id="faqs_id">
                                        <input
                                            type="text"
                                            class="form-control payment-input"
                                            id="question_upd" name="question_upd"
                                            placeholder="How This Work?" required
                                        />
                                    </div>
                                    <div class="col-12 mt-0 mb-3">
                                        <label for="inputAddress2" class="form-label online-Class-Select-Heading"
                                        >Answer</label
                                        >
                                        <br/>
                                        <textarea id="answer_upd" name="answer_upd"></textarea>
                                    </div>

                                    <div class="api-buttons">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <button type="button" id="edit_faqs_btn"
                                                        class="btn float-end update-btn teacher-next-btn">
                                                    Update
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                            </div>

                        </div>
                    </div>

                    {{-- Faqs END ==== --}}


                    <div class="col-md-12">
                        <div class="row payment-type mx-1 my-3">
                            <div class="col-md-12">
                                @if ($gigData->recurring_type == 'OneDay')
                                    <h3
                                        class="online-Class-Select-Heading"
                                        style="margin-top: 24px"
                                    >
                                        How much would you charge per class and per person?
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="16"
                                            height="16"
                                            viewBox="0 0 16 16"
                                            fill="none"
                                        >
                                            <path
                                                d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 13.5C6.91221 13.5 5.84884 13.1774 4.94437 12.5731C4.0399 11.9687 3.33495 11.1098 2.91867 10.1048C2.50238 9.09977 2.39347 7.9939 2.60568 6.927C2.8179 5.86011 3.34173 4.8801 4.11092 4.11091C4.8801 3.34172 5.86011 2.8179 6.92701 2.60568C7.9939 2.39346 9.09977 2.50238 10.1048 2.91866C11.1098 3.33494 11.9687 4.03989 12.5731 4.94436C13.1774 5.84883 13.5 6.9122 13.5 8C13.4983 9.45818 12.9184 10.8562 11.8873 11.8873C10.8562 12.9184 9.45819 13.4983 8 13.5ZM9 11C9 11.1326 8.94732 11.2598 8.85356 11.3536C8.75979 11.4473 8.63261 11.5 8.5 11.5C8.23479 11.5 7.98043 11.3946 7.7929 11.2071C7.60536 11.0196 7.5 10.7652 7.5 10.5V8C7.36739 8 7.24022 7.94732 7.14645 7.85355C7.05268 7.75979 7 7.63261 7 7.5C7 7.36739 7.05268 7.24021 7.14645 7.14645C7.24022 7.05268 7.36739 7 7.5 7C7.76522 7 8.01957 7.10536 8.20711 7.29289C8.39465 7.48043 8.5 7.73478 8.5 8V10.5C8.63261 10.5 8.75979 10.5527 8.85356 10.6464C8.94732 10.7402 9 10.8674 9 11ZM7 5.25C7 5.10166 7.04399 4.95666 7.1264 4.83332C7.20881 4.70999 7.32595 4.61386 7.46299 4.55709C7.60003 4.50032 7.75083 4.48547 7.89632 4.51441C8.04181 4.54335 8.17544 4.61478 8.28033 4.71967C8.38522 4.82456 8.45665 4.9582 8.48559 5.10368C8.51453 5.24917 8.49968 5.39997 8.44291 5.53701C8.38615 5.67406 8.29002 5.79119 8.16668 5.8736C8.04334 5.95601 7.89834 6 7.75 6C7.55109 6 7.36032 5.92098 7.21967 5.78033C7.07902 5.63968 7 5.44891 7 5.25Z"
                                                fill="#0072B1"
                                            />
                                        </svg>
                                    </h3>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12">

                                            <h3
                                                class="online-Class-Select-Heading"
                                                style="margin-top: 16px"
                                            >
                                                Start Date
                                            </h3>
                                            <input
                                                class="payment-input"
                                                placeholder="00:00" value="{{$gigPayment->start_date}}"
                                                type="date" name="start_date" id="start_date"
                                            />
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <h3
                                                class="online-Class-Select-Heading"
                                                style="margin-top: 16px"
                                            >
                                                Start Time 
                                            </h3>
                                            <input
                                                class="payment-input timePickerFlatpickr"
                                                placeholder="00:00" value="{{$gigPayment->start_time}}"
                                                type="text" name="start_time" id="start_time"
                                            />
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <h3
                                                class="online-Class-Select-Heading"
                                                style="margin-top: 16px"
                                            >
                                                End Time
                                            </h3>
                                            <input
                                                class="payment-input timePickerFlatpickr"
                                                placeholder="00:00" value="{{$gigPayment->end_time}}"
                                                type="text" name="end_time" id="end_time"
                                            />
                                        </div>


                                    </div>
                                @endif
                                {{-- <div class="row">
                                  <div class="col-md-3 col-sm-12">
                                    <h3
                                      class="online-Class-Select-Heading"
                                      style="margin-top: 16px"
                                    >
                                      Repeat on :
                                    </h3>
                                    <input
                                      class="payment-input"
                                      placeholder="Repeat after weeks"
                                      type="text"
                                    />
                                  </div>
                                  <div class="col-md-3 col-sm-12"></div>
                                  <div class="col-md-3 col-sm-12"></div>
                                  <div class="col-md-3 col-sm-12"></div>
                                </div> --}}

                                <div class="row mt-3">
                                    <div class="col-md-12 col-sm-12">
                                        <h3
                                            class="online-Class-Select-Heading"
                                            style="margin-top: 16px; display: inline;"
                                        >
                                            Duration
                                        </h3>


                                        @if ($gigData->class_type == 'Video' )
                                            {{-- Video Course Duration --}}
                                            <div class="input-group mb-3" style="display: flex; flex-wrap: nowrap;">
                                                <span class="input-group-text" id="basic-addon1">Hr:Mi</span>
                                                <input
                                                    type="text"
                                                    id="duration"
                                                    name="duration"
                                                    placeholder="HH:MM" value="{{$gigPayment->duration}}"
                                                    class="payment-input fa"
                                                    maxlength="5"
                                                    aria-describedby="basic-addon1"
                                                />
                                            </div>

                                        @elseif ($gigData->recurring_type == 'Trial')
                                            {{-- ✅ Trial Class Duration Logic --}}
                                            @if ($gigData->trial_type == 'Free')
                                                {{-- Free Trial: 30 minutes FIXED --}}
                                                <input type="hidden" name="durationH" value="00">
                                                <input type="hidden" name="durationM" value="30">
                                                <div class="alert alert-info"
                                                     style="background-color: #d1ecf1; border: 1px solid #bee5eb; border-radius: 8px; padding: 12px; margin-bottom: 15px;">
                                                    <i class="fas fa-info-circle"
                                                       style="color: #0c5460; margin-right: 8px;"></i>
                                                    <strong style="color: #0c5460;">Free Trial:</strong>
                                                    <span style="color: #0c5460;">Duration is fixed at 30 minutes</span>
                                                </div>
                                                <select name="durationH_display" id="durationH" class="fa" disabled
                                                        style="background-color: #f0f0f0;">
                                                    <option value="00" class="fa" selected>00</option>
                                                </select>
                                                <span>Hr</span>
                                                <select name="durationM_display" id="durationM" class="fa" disabled
                                                        style="background-color: #f0f0f0;">
                                                    <option value="30" class="fa" selected>30</option>
                                                </select>
                                                <span>Mi</span>

                                            @else
                                                {{-- Paid Trial: Flexible Duration --}}
                                                <div class="alert alert-success"
                                                     style="background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 8px; padding: 12px; margin-bottom: 15px;">
                                                    <i class="fas fa-check-circle"
                                                       style="color: #155724; margin-right: 8px;"></i>
                                                    <strong style="color: #155724;">Paid Trial:</strong>
                                                    <span style="color: #155724;">You can set custom duration</span>
                                                </div>
                                                @php
                                                    $duration = explode(':',$gigPayment->duration);
                                                @endphp
                                                <select name="durationH" id="durationH" class="fa">
                                                    <option value="{{$duration[0]}}" class="fa" selected>{{$duration[0]}}</option>
                                                    <option value="00" class="fa">00</option>
                                                    @for ($i = 1; $i <= 10; $i++)
                                                        <option value="{{$i}}" class="fa">{{$i}}</option>
                                                    @endfor
                                                </select>
                                                <span>Hr</span>
                                                <select name="durationM" id="durationM" class="fa">
                                                    @if (isset($duration[1]))
                                                        <option value="{{$duration[1]}}" class="fa" selected>{{$duration[1]}}</option>
                                                    @endif
                                                    <option value="00" class="fa">00</option>
                                                    <option value="30" class="fa">30</option>
                                                </select>
                                                <span>Mi</span>
                                            @endif

                                        @else
                                            {{-- Normal Live Class Duration --}}
                                            @php
                                                $duration = explode(':',$gigPayment->duration);
                                            @endphp

                                            <select name="durationH" id="durationH" class="fa">
                                                <option value="{{$duration[0]}}" class="fa">{{$duration[0]}}</option>
                                                <option value="00" class="fa">00</option>
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{$i}}" class="fa">{{$i}}</option>

                                                @endfor
                                            </select>
                                            <span>Hr</span>
                                            <select name="durationM" id="durationM" class="fa">
                                                @if ($duration[1])
                                                    <option value="{{$duration[1]}}"
                                                            class="fa">{{$duration[1]}}</option>
                                                @endif
                                                <option value="00" class="fa">00</option>
                                                <option value="30" class="fa">30</option>
                                            </select>
                                            <span>Mi</span>
                                        @endif
                                    </div>
                                </div>
                                @if ($gigData->recurring_type == 'Recurring' || $gigData->recurring_type == 'Trial' || $gig->service_type == 'Inperson')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3
                                                class="online-Class-Select-Heading"
                                                style="margin-top: 24px"
                                            >
                                                Repeat on :
                                            </h3>
                                            @php
                                                $daysOfWeek = [
                                                    1 => 'Monday',
                                                    2 => 'Tuesday',
                                                    3 => 'Wednesday',
                                                    4 => 'Thursday',
                                                    5 => 'Friday',
                                                    6 => 'Saturday',
                                                    7 => 'Sunday'
                                                ];
                                            @endphp

                                            <div class="repeats-btn-section">
                                                @foreach ($daysOfWeek as $dayIndex => $dayName)

                                                    @php
                                                        // Check if the current day is in the database results
                                                        $dayData = $gigDays->firstWhere('day', $dayName);
                                                        $isActive = $dayData ? 'active' : ''; // Add active class if the day is found in the database
                                                    @endphp

                                                    <div>
                                                        <button type="button" class="repeat-btn {{ $isActive }}"
                                                                onclick="RepeatOn(this)"
                                                                data-day='{{ $dayIndex }}'>
                                                            {{ $dayName }}
                                                        </button>

                                                        <!-- Only show the inputs if there is data for this day -->
                                                        <div id="time_div_{{ $dayIndex }}" class="time_div">
                                                            @if ($dayData)
                                                                <input type="hidden" name="day_repeat[]"
                                                                       value="{{ $dayData->day }}"
                                                                       class="payment-input mt-1">

                                                                <div class="repeat-btn"
                                                                     style="color:#0072b1;font-weight:500;background:none;">
                                                                    Start Time:
                                                                    <input type="text"
                                                                           value="{{ $dayData->start_time }}"
                                                                           style="width:120px;"
                                                                           onchange="validateDutyAndLectureTimes(this.id)"
                                                                           id="start_repeat_{{ $dayIndex }}"
                                                                           name="start_repeat[]"
                                                                           class="payment-input mt-1 timePickerFlatpickr">
                                                                </div>

                                                                <div class="repeat-btn"
                                                                     style="color:#0072b1;font-weight:500;background:none;">
                                                                    End Time:
                                                                    <input type="text" value="{{ $dayData->end_time }}"
                                                                           style="width:120px;"
                                                                           onchange="validateDutyAndLectureTimes(this.id)"
                                                                           id="end_repeat_{{ $dayIndex }}"
                                                                           name="end_repeat[]"
                                                                           class="payment-input mt-1 timePickerFlatpickr">
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                @endforeach
                                            </div>

                                            {{-- <div >
                                              <button  type="button" class="repeat-btn" onclick="RepeatOn(this)"  data-day='2'>Tuesday</button>
                                              <div id="time_div_2" class="time_div" ></div>
                                            </div>
                                            <div >
                                              <button  type="button" class="repeat-btn" onclick="RepeatOn(this)"  data-day='3'>Wednesday</button>
                                              <div id="time_div_3" class="time_div" ></div>
                                            </div>
                                            <div >
                                              <button  type="button" class="repeat-btn" onclick="RepeatOn(this)"  data-day='4'>Thursday</button>
                                              <div id="time_div_4" class="time_div" ></div>
                                            </div>
                                            <div >
                                              <button  type="button" class="repeat-btn" onclick="RepeatOn(this)"  data-day='5'>Friday</button>
                                              <div id="time_div_5" class="time_div" ></div>
                                            </div>
                                            <div >
                                              <button  type="button" class="repeat-btn" onclick="RepeatOn(this)"  data-day='6'>Saturday</button>
                                              <div id="time_div_6" class="time_div" ></div>
                                            </div>
                                            <div >
                                              <button  type="button" class="repeat-btn" onclick="RepeatOn(this)" data-day='7' >Sunday</button>
                                              <div id="time_div_7" class="time_div" ></div>
                                            </div>
                                           </div> --}}

                                        </div>
                                        @endif
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="col-md-12">
            <div
                class="Teacher-next-back-Section"
                style="margin: 16px 0px !important"
            >
                <a href="/teacher-service-edit/{{$gig_id}}/edit" class="teacher-back-btn">Back</a>

                <button type="button" onclick="SubmitForm()" class="teacher-next-btn">Update</button>

                {{-- <a href="Learn-How -4.html" class="teacher-next-btn">Next</a> --}}
            </div>
        </div>
        </form>
    </div>
    <!-- =============================== MAIN CONTENT END HERE =========================== -->
</section>


<!-- Option 1: Bootstrap Bundle with Popper -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"
></script>
{{-- Positive Search Tearm Script Start --}}
<script>

    function validateRatePrice(input) {
        var value = parseFloat(input.value);
        if (isNaN(value) || value < 10) {
            alert("Minimum rate of $10 is allowed.");
            input.value = 10;
        }
    }

    $(document).ready(function () {

        var minor_attend = @json($gigPayment->minor_attend);

        if (minor_attend == 1) {
            $('.limit_show').show();
        } else {
            $('.limit_show').hide();

        }


        $('#duration').on('input', function () {
            let value = $(this).val();

            // Remove invalid characters
            value = value.replace(/[^0-9:]/g, '');

            // Automatically add colon after 2 digits if not already present
            if (value.length > 2 && value.indexOf(':') === -1) {
                value = value.slice(0, 2) + ':' + value.slice(2);
            }

            // Limit to HH:MM format
            if (value.length > 5) {
                value = value.slice(0, 5);
            }

            $(this).val(value);
        });

        $('#duration').on('focusout', function () {
            let value = $(this).val();

            // Validate hours and minutes
            let parts = value.split(':');
            if (parts.length === 2) {
                // Ensure hours are within 00-24
                let hours = Math.min(24, Math.max(0, parseInt(parts[0] || '0')));
                // Ensure minutes are within 00-59
                let minutes = Math.min(59, Math.max(0, parseInt(parts[1] || '0')));

                // Format hours and minutes
                parts[0] = hours.toString().padStart(2, '0');
                parts[1] = minutes.toString().padStart(2, '0');

                $(this).val(parts.join(':'));
            } else {
                // Reset to default if invalid
                $(this).val('00:00');
            }
        });
    });

    flatpickr(".timePickerFlatpickr", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        minuteIncrement: 30, // Only allow 00 and 30
    });

    document.addEventListener('DOMContentLoaded', function () {
        const inputField = document.getElementById('input_positive_term');
        const outputDiv = document.getElementById('positive_term_div');
        const commaSeparatedField = document.getElementById('positive_term');
        let slices = [];

        // Initialize slices with existing values
        const initialValues = commaSeparatedField.value.split(',').map(item => item.trim()).filter(item => item);
        slices = initialValues;
        renderSlices();

        inputField.addEventListener('keypress', function (event) {
            if (event.key === 'Enter' || event.key === ',') {
                event.preventDefault();

                let value = inputField.value.trim();

                if (value) {
                    let newSlices = value.split(',').map(item => item.trim()).filter(item => item);

                    if (slices.length + newSlices.length > 5) {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            timeOut: "10000",
                            extendedTimeOut: "10000",
                        };
                        toastr.error("Maximum 5 Keywords Allowed!");
                        return false;
                    }

                    slices = slices.concat(newSlices);
                    inputField.value = '';
                    renderSlices();
                }
            }
        });

        function renderSlices() {
            outputDiv.innerHTML = '';

            slices.forEach((slice, index) => {
                let span = document.createElement('span');
                span.textContent = slice;
                span.className = 'slice mt-2';
                span.style.cssText = `
        background-color: #0072b1;
        color: #fff;
        padding: 0px 10px;
        border-radius: 4px;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: default;
        font-size: 16px;
        width: max-content;
      `;

                let removeButton = document.createElement('span');
                removeButton.textContent = 'x';
                removeButton.className = 'remove';
                removeButton.style.cssText = `
        color: #fff;
        padding: 5px;
        cursor: pointer;
      `;

                removeButton.addEventListener('click', function () {
                    removeSlice(index);
                });

                span.appendChild(removeButton);
                outputDiv.appendChild(span);
            });

            updateCommaSeparatedField();
        }

        function removeSlice(index) {
            slices.splice(index, 1);
            renderSlices();
        }

        function updateCommaSeparatedField() {
            commaSeparatedField.value = slices.join(',');
        }
    });

</script>
{{-- Positive Search Tearm Script END --}}


{{-- Time And Date Selection Script  Start ========--}}
<script>
    // Start Date Selection Start====
    // Set the minimum date to tomorrow
    document.addEventListener('DOMContentLoaded', function () {
        const dateInput = document.getElementById('start_date');

        let today = new Date();
        today.setDate(today.getDate() + 1);  // Set to tomorrow

        // Format date as 'YYYY-MM-DD'
        let year = today.getFullYear();
        let month = (today.getMonth() + 1).toString().padStart(2, '0');  // Months are zero-indexed
        let day = today.getDate().toString().padStart(2, '0');

        let minDate = `${year}-${month}-${day}`;

        // Set the min attribute to tomorrow's date
        dateInput.setAttribute('min', minDate);
    });

    // Optional: Ensure a future date is selected when the input value changes
    document.getElementById('start_date').addEventListener('change', function () {
        let selectedDate = new Date(this.value);
        let today = new Date();

        today.setHours(0, 0, 0, 0); // Set time to 00:00:00 to only compare dates
        today.setDate(today.getDate() + 1);  // Move to tomorrow

        if (selectedDate < today) {
            alert('Please select a future date!');
            this.value = '';  // Reset the input value
        }


    });


    function validateDutyAndLectureTimes(Clicked) {


        // Get duty time values
        const startDutydate = document.getElementById('start_date').value;
        const startDutyTime = document.getElementById('start_time').value;
        const endDutyTime = document.getElementById('end_time').value;


        // Check if duty times are filled
        if (!startDutydate) {
            alert('Please Enter Start Date!');
            $('#' + Clicked).val('');
            return false;
        }
        // Check if duty times are filled
        if (!startDutyTime || !endDutyTime) {
            alert('Please Enter Start and End times!');
            $('#' + Clicked).val('');
            return false;
        }

        // Convert duty times to Date objects for comparison

        const startdate = document.getElementById(`start_date`).value;
        const startDuty = new Date(`${startdate}T${startDutyTime}:00`);
        const endDuty = new Date(`${startdate}T${endDutyTime}:00`);

        // Loop through each day's lecture times
        var id = Clicked.split('_');
        const startLectureTime = document.getElementById(`start_repeat_` + id[2]).value;
        const endLectureTime = document.getElementById(`end_repeat_` + id[2]).value;

        if (id[0] == 'start') {

            // If both start and end lecture times are filled, validate them
            if (startLectureTime) {
                const startLecture = new Date(`${startdate}T${startLectureTime}:00`);

                // Check if lecture times are within duty times
                if (startLecture < startDuty || startLecture > endDuty) {
                    alert('Lecture times for day must be within the Time range.');
                    $('#' + Clicked).val('');
                    return false;  // Invalid case
                }

                // Ensure that lecture end time is greater than start time
                if (endLectureTime) {
                    const endLecture = new Date(`${startdate}T${endLectureTime}:00`);
                    if (endLecture <= startLecture) {
                        alert('Lecture end time for day must be greater than start time.');
                        $('#' + Clicked).val('');
                        return false;  // Invalid case
                    }
                }

            }

        } else {

            // If both start and end lecture times are filled, validate them
            if (endLectureTime) {
                const endLecture = new Date(`${startdate}T${endLectureTime}:00`);

                // Check if lecture times are within duty times
                if (endLecture < startDuty || endLecture > endDuty) {
                    alert('Lecture times for day must be within the Time range.');
                    $('#' + Clicked).val('');
                    return false;  // Invalid case
                }

                // Ensure that lecture end time is greater than start time
                if (startLectureTime) {
                    const startLecture = new Date(`${startdate}T${startLectureTime}:00`);
                    if (endLecture <= startLecture) {
                        alert('Lecture end time for day must be greater than start time.');
                        $('#' + Clicked).val('');
                        return false;  // Invalid case
                    }
                }

            }

        }


        let input = document.getElementById(Clicked);
        let value = input.value;

        // Parse hours and minutes
        let [hours, minutes] = value.split(':').map(Number);

        // Round minutes to nearest 15-minute increment
        let roundedMinutes = Math.round(minutes / 15) * 15;
        if (roundedMinutes === 60) {
            roundedMinutes = 0;
            hours += 1;
        }

        // Format time with padded zeros
        let formattedTime = `${String(hours).padStart(2, '0')}:${String(roundedMinutes).padStart(2, '0')}`;

        // Update input value
        input.value = formattedTime;


    }

    // Start END Selection END====
</script>
{{-- Time And Date Selection Script  END ========--}}


{{-- Repeat On Script Start ======= --}}
<script>
    function RepeatOn(Clicked) {

        if ($(Clicked).hasClass('active')) {
            $(Clicked).removeClass('active');
        } else {
            $(Clicked).addClass('active');
        }


        var activeDays = [];
        var activeDivs = [];
        $('.time_div').empty();
        $('.repeat-btn.active').each(function () {

            activeDays.push($(this).html());
            activeDivs.push($(this).data('day'));
        });

// Log the result as an array of active days
        if (activeDays.length > 0) {

            for (let i = 0; i < activeDays.length; i++) {
                const day = activeDays[i];
                const data = activeDivs[i];
                var html = ' <input type="hidden" name="day_repeat[]" value="' + day + '" class="payment-input mt-1 ">  ' +
                    '<div class="repeat-btn" style="color:#0072b1;font-weight:500;background:none;"> Start Time : <input type="text" style="width:120px;"   id="start_repeat_' + data + '" name="start_repeat[]" class="timePickerFlatpickr payment-input mt-1"> </div>' +
                    '<div class="repeat-btn" style="color:#0072b1;font-weight:500;background:none;"> End Time : <input type="text" style="width:120px;"   id="end_repeat_' + data + '" name="end_repeat[]" class="timePickerFlatpickr payment-input mt-1"> </div>';

                $('#time_div_' + data).html(html);

                flatpickr(".timePickerFlatpickr", {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    minuteIncrement: 30, // Only allow 00 and 30
                });

            }

        }


    }

    //  Estimated Payment Set ========
    $('#rate').on('keyup', function () {
        var rate = $('#rate').val();
        var commission = parseFloat('<?php echo $commission; ?>');
        let netPercent = 100 - commission; // Net percentage after tax
        let estimatedEarnings = (rate * netPercent) / 100;
        $('#estimated_earning').val(estimatedEarnings);


    });

</script>
{{-- Repeat On Script END ======= --}}

{{-- On Check Show Hide Script Miner --}}
<script>
    function MinorAttend(Clicked) {
        var values = $('#' + Clicked).val();
        if (values == 1) {
            $('.limit_show').show();
        } else {
            $('.limit_show').hide();
        }

    }
</script>
{{-- On Check Show Hide Script Miner --}}


{{-- Moment CDN === --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

{{-- Form Validation Script Start==== --}}
<script>
    function SubmitForm() {
        let recurring_type = '<?php echo $gigData->recurring_type ?>';
        let trial_type = '<?php echo $gigData->trial_type ?? '' ?>';
        let service_type = '<?php echo $gig->service_type ?>';
        let class_type = '<?php echo $gig->class_type ?>';
        let rate = document.getElementById('rate') ? document.getElementById('rate').value : '0';
        let duration = '';
        let valid = true;

        // Helper function for displaying toastr errors
        const showError = (message) => {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                timeOut: "10000",
                extendedTimeOut: "4410000",
            };
            toastr.error(message);
            valid = false;
            return false;
        };

        // Validate rate (skip for free trial)
        if (recurring_type !== 'Trial' || trial_type !== 'Free') {
            if (!rate) return showError("Individual Rate Required!");
        }

        // Validate duration based on service and class type
        if (service_type === 'Online') {
            if (class_type === 'Video') {
                duration = document.getElementById('duration').value;
                if (!duration) return showError("Duration Required!");
            } else {
                const durationH = document.getElementById('durationH').value;
                const durationM = document.getElementById('durationM').value;
                duration = `${durationH}:${durationM}`;
                if (durationH === '00' && durationM === '00') return showError("Duration Required!");
            }


            // Validate recurring conditions
            if (recurring_type === 'OneDay') {
                const startTimeInput = document.getElementById('start_time');
                const endTimeInput = document.getElementById('end_time');
                const start_date = document.getElementById('start_date').value;
                const start_time = document.getElementById('start_time').value;
                const end_time = document.getElementById('end_time').value;

                if (!start_date) return showError("Start Date Required!");
                if (!start_time) {
                    showError("Start Time Required!");
                    startTimeInput.focus();
                    return false;

                }
                ;
                if (!end_time) {
                    showError("End Time Required!");
                    endTimeInput.focus();
                    return false;

                }
                ;


                if (start_time && end_time) {
                    let startTimeMoment = moment(start_time, "HH:mm");
                    let endTimeMoment = moment(end_time, "HH:mm");

                    if (endTimeMoment.isSameOrBefore(startTimeMoment)) {
                        alert('End Time must be greater than Start Time.');
                        endTimeInput.value = ""; // Reset invalid end time
                        endTimeInput.focus(); // Keep focus on End Time input
                        return false;
                    }

                    if (end_time === "00:00") {
                        alert('End Time cannot be 00:00.');
                        endTimeInput.value = ""; // Reset invalid end time
                        endTimeInput.focus(); // Keep focus on End Time input
                        return false;
                    }
                }


                if (duration != '') {
                    duration_part = duration.split(':');
                    const totalDurationMinutes = (parseInt(duration_part[0]) * 60) + parseInt(duration_part[1]);

                    // Retrieve start and end time inputs
                    const start_time = document.getElementById('start_time').value;
                    const end_time = document.getElementById('end_time').value;

                    // Parse times using moment.js
                    const startTimeMoment = moment(start_time, "HH:mm");
                    const endTimeMoment = moment(end_time, "HH:mm");

                    // Calculate availability time in minutes
                    const availabilityMinutes = moment.duration(endTimeMoment.diff(startTimeMoment)).asMinutes();

                    // Compare availability time with duration
                    if (availabilityMinutes < totalDurationMinutes) {
                        showError(`Availability time must be at least ${duration[0]} hours and ${duration[1]} minutes.`);
                        return false;
                    }

                }

            } else if (recurring_type === 'Trial') {
                // ✅ Trial Class Validation

                // For Paid Trial, validate duration
                if (trial_type !== 'Free') {
                    const durationH = document.getElementById('durationH').value;
                    const durationM = document.getElementById('durationM').value;

                    if (durationH === '00' && durationM === '00') {
                        return showError("Duration must be greater than 0!");
                    }
                }

                // Trial: Must have at least one day selected in Repeat On section
                const activeDayButtons = document.querySelectorAll('.repeat-btn.active');

                if (activeDayButtons.length === 0) {
                    return showError("Please select at least one day for your Trial Class!");
                }

                // Validate that all selected days have start and end times
                const startRepeatInputs = document.querySelectorAll('input[name="start_repeat[]"]');
                const endRepeatInputs = document.querySelectorAll('input[name="end_repeat[]"]');

                for (let i = 0; i < startRepeatInputs.length; i++) {
                    if (!startRepeatInputs[i].value) {
                        showError("Start Time Required for all selected days!");
                        startRepeatInputs[i].focus();
                        return false;
                    }

                    if (!endRepeatInputs[i].value) {
                        showError("End Time Required for all selected days!");
                        endRepeatInputs[i].focus();
                        return false;
                    }

                    // Validate that end time is after start time
                    let startTimeMoment = moment(startRepeatInputs[i].value, "HH:mm");
                    let endTimeMoment = moment(endRepeatInputs[i].value, "HH:mm");

                    if (endTimeMoment.isSameOrBefore(startTimeMoment)) {
                        showError('End Time must be greater than Start Time for all selected days!');
                        endRepeatInputs[i].focus();
                        return false;
                    }

                    if (endRepeatInputs[i].value === "00:00") {
                        showError('End Time cannot be 00:00!');
                        endRepeatInputs[i].focus();
                        return false;
                    }
                }

                // Trial validation passed - submit form
                if (valid) $('#myForm').submit();
                return;
            } else {


                // For recurring days
                if (class_type !== 'Video') {
                    const activeDays = [];
                    const activeDivs = [];
                    $('.repeat-btn.active').each(function () {
                        activeDays.push($(this).html());
                        activeDivs.push($(this).data('day'));
                    });

                    if (activeDays.length === 0) return showError("Repeat Min 1 Day Required!");

                    for (let i = 0; i < activeDays.length; i++) {
                        const day = activeDays[i];
                        const data = activeDivs[i];
                        const startTimeInput = document.getElementById('start_repeat_' + data);
                        const endTimeInput = document.getElementById('end_repeat_' + data);
                        const start_repeat = startTimeInput.value;
                        const end_repeat = endTimeInput.value;

                        if (!start_repeat) {
                            showError(`Start Time Required for ${day}!`);
                            startTimeInput.focus(); // Keep focus on Start Time input
                            return;
                        }

                        if (!end_repeat) {
                            showError(`End Time Required for ${day}!`);
                            endTimeInput.focus(); // Keep focus on End Time input
                            return;
                        }

                        if (start_repeat && end_repeat) {
                            let startTimeMoment = moment(start_repeat, "HH:mm");
                            let endTimeMoment = moment(end_repeat, "HH:mm");

                            if (endTimeMoment.isSameOrBefore(startTimeMoment)) {
                                alert('End Time must be greater than Start Time.');
                                endTimeInput.value = ""; // Reset invalid end time
                                endTimeInput.focus(); // Keep focus on End Time input
                                return;
                            }

                            if (end_repeat === "00:00") {
                                alert('End Time cannot be 00:00.');
                                endTimeInput.value = ""; // Reset invalid end time
                                endTimeInput.focus(); // Keep focus on End Time input
                                return;
                            }


                            if (duration != '') {
                                duration_part = duration.split(':');
                                const totalDurationMinutes = (parseInt(duration_part[0]) * 60) + parseInt(duration_part[1]);


                                // Retrieve start and end time inputs
                                const start_time = start_repeat;
                                const end_time = end_repeat;

                                // Parse times using moment.js
                                const startTimeMoment = moment(start_time, "HH:mm");
                                const endTimeMoment = moment(end_time, "HH:mm");

                                // Calculate availability time in minutes
                                const availabilityMinutes = moment.duration(endTimeMoment.diff(startTimeMoment)).asMinutes();

                                // Compare availability time with duration
                                if (availabilityMinutes < totalDurationMinutes) {
                                    showError(`Availability time must be at least ${duration[0]} hours and ${duration[1]} minutes.`);
                                    return false;
                                }

                            }


                        }
                    }
                }
            }


        } else {


            // if (class_type !== 'Video' && class_type !== '') {
            const durationH = document.getElementById('durationH').value;
            const durationM = document.getElementById('durationM').value;
            duration = `${durationH}:${durationM}`;
            if (duration === '00:00') {
                showError("Duration Required!");
                return false;
            }
            // }


            // For recurring days
            const activeDays = [];
            const activeDivs = [];
            $('.repeat-btn.active').each(function () {
                activeDays.push($(this).html());
                activeDivs.push($(this).data('day'));
            });

            if (activeDays.length === 0) return showError("Repeat Min 1 Day Required..!");

            for (let i = 0; i < activeDays.length; i++) {
                const day = activeDays[i];
                const data = activeDivs[i];
                const startTimeInput = document.getElementById('start_repeat_' + data);
                const endTimeInput = document.getElementById('end_repeat_' + data);
                const start_repeat = startTimeInput.value;
                const end_repeat = endTimeInput.value;

                if (!start_repeat) {
                    showError(`Start Time Required for ${day}!`);
                    startTimeInput.focus(); // Keep focus on Start Time input
                    return;
                }

                if (!end_repeat) {
                    showError(`End Time Required for ${day}!`);
                    endTimeInput.focus(); // Keep focus on End Time input
                    return;
                }

                if (start_repeat && end_repeat) {
                    let startTimeMoment = moment(start_repeat, "HH:mm");
                    let endTimeMoment = moment(end_repeat, "HH:mm");

                    if (endTimeMoment.isSameOrBefore(startTimeMoment)) {
                        alert('End Time must be greater than Start Time.');
                        endTimeInput.value = ""; // Reset invalid end time
                        endTimeInput.focus(); // Keep focus on End Time input
                        return;
                    }

                    if (end_repeat === "00:00") {
                        alert('End Time cannot be 00:00.');
                        endTimeInput.value = ""; // Reset invalid end time
                        endTimeInput.focus(); // Keep focus on End Time input
                        return;
                    }


                    if (duration != '') {
                        duration_part = duration.split(':');
                        const totalDurationMinutes = (parseInt(duration_part[0]) * 60) + parseInt(duration_part[1]);


                        // Retrieve start and end time inputs
                        const start_time = start_repeat;
                        const end_time = end_repeat;

                        // Parse times using moment.js
                        const startTimeMoment = moment(start_time, "HH:mm");
                        const endTimeMoment = moment(end_time, "HH:mm");

                        // Calculate availability time in minutes
                        const availabilityMinutes = moment.duration(endTimeMoment.diff(startTimeMoment)).asMinutes();

                        // Compare availability time with duration
                        if (availabilityMinutes < totalDurationMinutes) {
                            showError(`Availability time must be at least ${duration[0]} hours and ${duration[1]} minutes.`);
                            return false;
                        }

                    }


                }
            }


        }


        console.log(duration);

        // Submit form if all validations pass
        if (valid) $('#myForm').submit();
    }


</script>
{{-- Form Validation Script END==== --}}

{{-- Load Page Confirmation --}}
<script>
    window.addEventListener('beforeunload', function (e) {

        if ($('#myForm').submit()) {
            return;
        }
        // Display a confirmation dialog
        var confirmationMessage = 'Are you sure you want to leave? Your changes might not be saved.';

        // Standard for most modern browsers
        e.preventDefault();

        // Some browsers require returning a string (though ignored by modern browsers)
        e.returnValue = confirmationMessage;

        // Return the confirmation message (old versions of Chrome, Firefox, etc. still support this)
        return confirmationMessage;
    });
</script>
{{-- Load Page Confirmation --}}



<!-- Optional JavaScript; choose one of the two! -->
<script>
    function show1() {
        document.getElementById("div1").style.display = "none";
    }

    function show2() {
        document.getElementById("div1").style.display = "block";
    }
</script>
<!-- Option 1: Bootstrap Bundle with Popper -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"
></script>
<!-- ================ side js start here=============== -->
<script>
    // Sidebar script
    document.addEventListener("DOMContentLoaded", function () {
        let arrow = document.querySelectorAll(".arrow");
        for (let i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", function (e) {
                let arrowParent = e.target.parentElement.parentElement; // Selecting main parent of arrow
                arrowParent.classList.toggle("showMenu");
            });
        }

        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-menu");

        sidebarBtn.addEventListener("click", function () {
            sidebar.classList.toggle("close");
        });

        // Function to toggle sidebar based on screen size
        function toggleSidebar() {
            let screenWidth = window.innerWidth;
            if (screenWidth < 992) {
                sidebar.classList.add("close");
            } else {
                sidebar.classList.remove("close");
            }
        }

        // Call the function initially
        toggleSidebar();

        // Listen for resize events to adjust sidebar
        window.addEventListener("resize", function () {
            toggleSidebar();
        });
    });
</script>
<!-- ================ side js start End=============== -->

</body>
</html>
<!-- modal hide show jquery here -->
<script>
    $(document).ready(function () {
        $(document).on("click", "#delete-account", function (e) {
            e.preventDefault();
            $("#exampleModal7").modal("show");
            $("#delete-teacher-account").modal("hide");
        });

        $(document).on("click", "#delete-account", function (e) {
            e.preventDefault();
            $("#delete-teacher-account").modal("show");
            $("#exampleModal7").modal("hide");
        });
    });
</script>
<!-- radio js here -->
<script>
    function showAdditionalOptions1() {
        hideAllAdditionalOptions();
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


<!-- Tinymcs js link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.4.1/tinymce.min.js"></script>

<!-- Tinymce js start -->
<script>
    tinymce.init({
        selector: "#answer",
        plugins: "code visualblocks link",
        toolbar: [
            //: https://www.tiny.cloud/docs/tinymce/6/toolbar-configuration-options/#adding-toolbar-group-labels
            {name: "history", items: ["undo", "redo"]},
            {name: "styles", items: ["styles"]},
            {
                name: "formatting",
                items: ["bold", "italic", "underline", "removeformat"],
            },
            {name: "elements", items: ["link"]},
            // { name: 'alignment', items: [ 'alignleft', 'aligncenter', 'alignright', 'alignjustify' ] },
            // { name: 'indentation', items: [ 'outdent', 'indent' ] },
            {name: "source", items: ["code", "visualblocks"]},
        ],
        link_list: [
            {title: "{companyname} Home Page", value: "{companyurl}"},
            {title: "{companyname} Blog", value: "{companyurl}/blog"},
            {
                title: "{productname} Support resources 1",
                menu: [
                    {
                        title: "{productname} 1 Documentation",
                        value: "{companyurl}/docs/",
                    },
                    {
                        title: "{productname} on Stack Overflow",
                        value: "{communitysupporturl}",
                    },
                    {
                        title: "{productname} GitHub",
                        value: "https://github.com/tinymce/",
                    },
                ],
            },
            {
                title: "{productname} Support resources 2",
                menu: [
                    {
                        title: "{productname} 2 Documentation",
                        value: "{companyurl}/docs/",
                    },
                    {
                        title: "{productname} on Stack Overflow",
                        value: "{communitysupporturl}",
                    },
                    {
                        title: "{productname} GitHub",
                        value: "https://github.com/tinymce/",
                    },
                ],
            },
            {
                title: "{productname} Support resources 3",
                menu: [
                    {
                        title: "{productname} 3 Documentation",
                        value: "{companyurl}/docs/",
                    },
                    {
                        title: "{productname} on Stack Overflow",
                        value: "{communitysupporturl}",
                    },
                    {
                        title: "{productname} GitHub",
                        value: "https://github.com/tinymce/",
                    },
                ],
            },
        ],
    });

    tinymce.init({
        selector: "#answer_upd",
        plugins: "code visualblocks link",
        toolbar: [
            //: https://www.tiny.cloud/docs/tinymce/6/toolbar-configuration-options/#adding-toolbar-group-labels
            {name: "history", items: ["undo", "redo"]},
            {name: "styles", items: ["styles"]},
            {
                name: "formatting",
                items: ["bold", "italic", "underline", "removeformat"],
            },
            {name: "elements", items: ["link"]},
            // { name: 'alignment', items: [ 'alignleft', 'aligncenter', 'alignright', 'alignjustify' ] },
            // { name: 'indentation', items: [ 'outdent', 'indent' ] },
            {name: "source", items: ["code", "visualblocks"]},
        ],
        link_list: [
            {title: "{companyname} Home Page", value: "{companyurl}"},
            {title: "{companyname} Blog", value: "{companyurl}/blog"},
            {
                title: "{productname} Support resources 1",
                menu: [
                    {
                        title: "{productname} 1 Documentation",
                        value: "{companyurl}/docs/",
                    },
                    {
                        title: "{productname} on Stack Overflow",
                        value: "{communitysupporturl}",
                    },
                    {
                        title: "{productname} GitHub",
                        value: "https://github.com/tinymce/",
                    },
                ],
            },
            {
                title: "{productname} Support resources 2",
                menu: [
                    {
                        title: "{productname} 2 Documentation",
                        value: "{companyurl}/docs/",
                    },
                    {
                        title: "{productname} on Stack Overflow",
                        value: "{communitysupporturl}",
                    },
                    {
                        title: "{productname} GitHub",
                        value: "https://github.com/tinymce/",
                    },
                ],
            },
            {
                title: "{productname} Support resources 3",
                menu: [
                    {
                        title: "{productname} 3 Documentation",
                        value: "{companyurl}/docs/",
                    },
                    {
                        title: "{productname} on Stack Overflow",
                        value: "{communitysupporturl}",
                    },
                    {
                        title: "{productname} GitHub",
                        value: "https://github.com/tinymce/",
                    },
                ],
            },
        ],
    });

</script>

{{-- Faqs By Ajax Script Start ======== --}}
<script>
    $('#add_new_btn').click(function () {
        if ($('#add_faqs_main_div').is(':visible')) {
            $('#add_faqs_main_div').css('display', 'none');
            $('#edit_faqs_main_div').css('display', 'none');
        } else {
            $('#add_faqs_main_div').css('display', 'block');
            $('#edit_faqs_main_div').css('display', 'none');
        }
    });

    // On Page Load Get All Faqs
    $(document).ready(function () {

        var gig_id = '<?php echo $gig->id ?>';

        // Set up CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // AJAX request
        $.ajax({
            type: "POST",
            url: '/get-faqs-service',
            data: {
                gig_id: gig_id,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (response) {

                var faqs = response.faqs;

                var len = 0;
                len = faqs.length;
                $('#all_faqs').empty();

                if (len > 0) {

                    for (let i = 0; i < len; i++) {

                        var id = faqs[i].id;
                        var question = faqs[i].question;
                        var answer = faqs[i].answer;

                        var faqs_html = ` <div class="input-group  mb-3  main_faqs_${id}">
                    <input type="text" value="${question}" class="form-control payment-input" placeholder="Faqs" aria-label="Recipient's username" aria-describedby="button-addon1" readonly>
                    <button class="btn view-button btn-danger text-white btn btn-outline-secondary remove-button" type="button" onclick="RemoveFaqs(this.id)" id="remove_faqs_${id}" data-id="${id}"   >Remove</button>
                    <button class="btn view-button teacher-next-btn" type="button" onclick="ViewFaqs(this.id)" id="faqs_view_${id}"  data-id="${id}" data-question="${question}" data-answer="${answer}">View</button>
                  </div>`;


                        $('#all_faqs').append(faqs_html);

                    }


                }


            },
            error: function (xhr, status, error) {
                toastr.error('An error occurred. Please try again.');
            }
        });

    });


    // Add New FAQs Script Start -------
    $('#add_faqs_btn').click(function () {
        var gig_id = $('#faqs_gig_id').val();
        var question = $('#question').val().trim();
        const answer = tinymce.get('answer').getContent().trim();

        // Check if question or answer is empty
        if (!question || !answer) {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": "5000", // 5 seconds
                "extendedTimeOut": "1000" // 1 second
            };
            toastr.error('Both question and answer are required.');
            return; // Stop further execution if validation fails
        }

        // Set up CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // AJAX request
        $.ajax({
            type: "POST",
            url: '/upload-faqs-services',
            data: {
                gig_id: gig_id,
                question: question,
                answer: answer,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (response) {
                // Reset the fields
                $('#question').val('');
                tinymce.get('answer').setContent('');
                $('#add_faqs_main_div').css('display', 'none');

                // Display success or error message
                if (response.success) {

                    var faqs = response.faqs;
                    var faqs_html = ` <div class="input-group  mb-3  main_faqs_${faqs.id}">
                    <input type="text" value="${faqs.question}" class="form-control payment-input" placeholder="Faqs" aria-label="Recipient's username" aria-describedby="button-addon1" readonly>
                    <button class="btn view-button btn-danger text-white btn btn-outline-secondary remove-button" type="button" onclick="RemoveFaqs(this.id)" id="remove_faqs_${faqs.id}" data-id="${faqs.id}"   >Remove</button>
                    <button class="btn view-button teacher-next-btn" type="button" onclick="ViewFaqs(this.id)" id="faqs_view_${faqs.id}"   data-id="${faqs.id}" data-question="${faqs.question}" data-answer="${faqs.answer}">View</button>
                  </div>`;


                    $('#all_faqs').append(faqs_html);


                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "timeOut": "10000", // 10 seconds
                        "extendedTimeOut": "1000" // 1 second
                    };
                    toastr.success(response.success);
                } else {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "timeOut": "10000", // 10 seconds
                        "extendedTimeOut": "1000" // 1 second
                    };
                    toastr.error(response.error);
                }
            },
            error: function (xhr, status, error) {
                toastr.error('An error occurred. Please try again.');
            }
        });
    });


    // Add New Faqs Script END -------

    // Delete Faqs Script Start ----------
    function RemoveFaqs(Clicked) {

        if (!confirm("Are You Sure, You Want to delete This Faqs ?")) {
            return false;
        }

        var id = $('#' + Clicked).data('id');


        // Set up CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // AJAX request
        $.ajax({
            type: "POST",
            url: '/delete-faqs-services',
            data: {
                id: id,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (response) {


                // Display success or error message
                if (response.success) {


                    $('.main_faqs_' + id).remove();

                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "timeOut": "10000", // 10 seconds
                        "extendedTimeOut": "1000" // 1 second
                    };
                    toastr.info(response.success);
                } else {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "timeOut": "10000", // 10 seconds
                        "extendedTimeOut": "1000" // 1 second
                    };
                    toastr.error(response.error);
                }
            },
            error: function (xhr, status, error) {
                toastr.error('An error occurred. Please try again.');
            }
        });


    }

    // Delete Faqs Script END ----------


    // EDIT Faqs Script Start ----------
    function ViewFaqs(Clicked) {
        var id = $('#' + Clicked).data('id');
        var question = $('#' + Clicked).data('question');
        var answer = $('#' + Clicked).data('answer');

        $('#faqs_id').val(id);
        $('#question_upd').val(question);
        tinymce.get('answer_upd').setContent(answer);
        $('#edit_faqs_main_div').css('display', 'block');


    }

    // EDIT Faqs Script END ----------


    // Update Faqs Script Start ----------
    $('#edit_faqs_btn').click(function () {

        var id = $('#faqs_id').val();
        var question = $('#question_upd').val().trim();
        const answer = tinymce.get('answer_upd').getContent().trim();

        // Check if question or answer is empty
        if (!question || !answer) {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": "5000", // 5 seconds
                "extendedTimeOut": "1000" // 1 second
            };
            toastr.error('Both question and answer are required.');
            return; // Stop further execution if validation fails
        }

        // Set up CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // AJAX request
        $.ajax({
            type: "POST",
            url: '/updated-faqs-services',
            data: {
                id: id,
                question: question,
                answer: answer,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (response) {
                // Reset the fields
                $('#faqs_id').val('');
                $('#question_upd').val('');
                tinymce.get('answer_upd').setContent('');
                $('#edit_faqs_main_div').css('display', 'none');

                // Display success or error message
                if (response.success) {

                    var faqs = response.faqs;
                    // Update the existing FAQ element
                    var faqs_html = `
                    <input type="text" value="${faqs.question}" class="form-control payment-input" placeholder="Faqs" aria-label="Recipient's username" aria-describedby="button-addon1" readonly>
                    <button class="btn view-button btn-danger text-white btn btn-outline-secondary remove-button" type="button" onclick="RemoveFaqs(this.id)" id="remove_faqs_${faqs.id}" data-id="${faqs.id}">Remove</button>
                    <button class="btn view-button teacher-next-btn" type="button" onclick="ViewFaqs(this.id)" id="faqs_view_${faqs.id}" data-id="${faqs.id}" data-question="${faqs.question}" data-answer="${faqs.answer}">View</button>
                `;

                    $(`.main_faqs_${faqs.id}`).html(faqs_html);


                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "timeOut": "10000", // 10 seconds
                        "extendedTimeOut": "1000" // 1 second
                    };
                    toastr.success(response.success);
                } else {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "timeOut": "10000", // 10 seconds
                        "extendedTimeOut": "1000" // 1 second
                    };
                    toastr.error(response.error);
                }
            },
            error: function (xhr, status, error) {
                toastr.error('An error occurred. Please try again.');
            }
        });


    });
    // Update Faqs Script END ----------


</script>
{{-- Faqs By Ajax Script END ======== --}}
