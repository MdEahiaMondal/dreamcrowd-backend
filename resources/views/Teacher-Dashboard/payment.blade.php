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
    <link rel="stylesheet" type="text/css" href="assets/teacher/asset/css/bootstrap.min.css"/>
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"/>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- jQuery Timepicker Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.min.js"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.min.css">

    {{-- =======Toastr CDN ======== --}}
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="assets/teacher/asset/css/class-management.css"/>
    <link rel="stylesheet" href="assets/teacher/asset/css/payment.css"/>
    <link rel="stylesheet" href="assets/teacher/asset/css/Learn-How.css"/>
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

    .trial-alert {
        padding: 15px;
        margin: 20px 0;
        border-radius: 8px;
        font-size: 14px;
    }

    .trial-alert i {
        margin-right: 8px;
    }
</style>

<body>

@if (Session::has('error'))
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "timeOut": "10000",
            "extendedTimeOut": "4410000"
        }
        toastr.error("{{ session('error') }}");
    </script>
@endif

@if (Session::has('success'))
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "timeOut": "10000",
            "extendedTimeOut": "4410000"
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

    <div class="container-fluid">
        <div class="row payment-page">
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
                    <ol class="breadcrumb mt-3">
                        <li class="breadcrumb-item active braedDashboard" aria-current="page">
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

            <form id="myForm" action="/class-gig-payment-upload" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">
                    <div class="row payment-type mx-1 my-3">
                        <div class="col-md-12">
                            <h3 class="online-Class-Select-Heading">Payment Type</h3>
                            <div class="select-box">
                                <input type="hidden" name="gig_id" value="{{$gig_id}}">
                                <select name="payment_type" id="sample" class="fa">
                                    @if ($gigData->payment_type == 'OneOff')
                                        <option value="OneOff" class="fa" selected>One-Of Payment</option>
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
                                    <div class="alert alert-success trial-alert">
                                        <i class="fas fa-gift"></i>
                                        <strong>Free Trial Class:</strong> This is a FREE trial session (30 minutes). No
                                        payment required from students.
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12">
                                    <div class="alert alert-info trial-alert">
                                        <i class="fas fa-dollar-sign"></i>
                                        <strong>Paid Trial Class:</strong> Set your pricing and duration below.
                                    </div>
                                </div>
                            @endif
                        @endif

                        {{-- ✅ Public Group Pricing (Hide for Free Trial) --}}
                        @if (in_array($gigData->group_type, ['Public', 'Both']))
                            @if ($gigData->recurring_type != 'Trial' || $gigData->trial_type != 'Free')
                                <div class="row">
                                    <h3 class="online-Class-Select-Heading" style="margin-top: 24px">
                                        How much would you charge per class and per person for Public Group?
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             viewBox="0 0 16 16" fill="none">
                                            <path
                                                d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 13.5C6.91221 13.5 5.84884 13.1774 4.94437 12.5731C4.0399 11.9687 3.33495 11.1098 2.91867 10.1048C2.50238 9.09977 2.39347 7.9939 2.60568 6.927C2.8179 5.86011 3.34173 4.8801 4.11092 4.11091C4.8801 3.34172 5.86011 2.8179 6.92701 2.60568C7.9939 2.39346 9.09977 2.50238 10.1048 2.91866C11.1098 3.33494 11.9687 4.03989 12.5731 4.94436C13.1774 5.84883 13.5 6.9122 13.5 8C13.4983 9.45818 12.9184 10.8562 11.8873 11.8873C10.8562 12.9184 9.45819 13.4983 8 13.5ZM9 11C9 11.1326 8.94732 11.2598 8.85356 11.3536C8.75979 11.4473 8.63261 11.5 8.5 11.5C8.23479 11.5 7.98043 11.3946 7.7929 11.2071C7.60536 11.0196 7.5 10.7652 7.5 10.5V8C7.36739 8 7.24022 7.94732 7.14645 7.85355C7.05268 7.75979 7 7.63261 7 7.5C7 7.36739 7.05268 7.24021 7.14645 7.14645C7.24022 7.05268 7.36739 7 7.5 7C7.76522 7 8.01957 7.10536 8.20711 7.29289C8.39465 7.48043 8.5 7.73478 8.5 8V10.5C8.63261 10.5 8.75979 10.5527 8.85356 10.6464C8.94732 10.7402 9 10.8674 9 11ZM7 5.25C7 5.10166 7.04399 4.95666 7.1264 4.83332C7.20881 4.70999 7.32595 4.61386 7.46299 4.55709C7.60003 4.50032 7.75083 4.48547 7.89632 4.51441C8.04181 4.54335 8.17544 4.61478 8.28033 4.71967C8.38522 4.82456 8.45665 4.9582 8.48559 5.10368C8.51453 5.24917 8.49968 5.39997 8.44291 5.53701C8.38615 5.67406 8.29002 5.79119 8.16668 5.8736C8.04334 5.95601 7.89834 6 7.75 6C7.55109 6 7.36032 5.92098 7.21967 5.78033C7.07902 5.63968 7 5.44891 7 5.25Z"
                                                fill="#0072B1"/>
                                        </svg>
                                    </h3>
                                    <div class="col-md-3 col-sm-12">
                                        <h3 class="online-Class-Select-Heading" style="margin-top: 16px">
                                            Price per person
                                        </h3>
                                        <input class="payment-input" name="public_rate" id="public_rate"
                                               placeholder="$50" type="number" onfocusout="validateRatePrice(this)"/>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <h3 class="online-Class-Select-Heading" style="margin-top: 16px">
                                            Group size Limit
                                        </h3>
                                        <input class="payment-input" name="public_group_size" id="public_size"
                                               placeholder="max 100" type="number"/>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <h3 class="online-Class-Select-Heading" style="margin-top: 16px">
                                            Discount per person
                                        </h3>
                                        <input class="payment-input" name="public_discount" id="public_discount"
                                               placeholder="50%" type="number"/>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <h3 class="online-Class-Select-Heading" style="margin-top: 16px">
                                            Earnings per person
                                        </h3>
                                        <input class="payment-input" name="public_earning" id="public_estimated_earning"
                                               placeholder="$50" readonly type="text"/>
                                    </div>
                                </div>
                            @else
                                {{-- Free Trial: Hidden inputs with $0 --}}
                                <input type="hidden" name="public_rate" value="0">
                                <input type="hidden" name="public_group_size" value="10">
                                <input type="hidden" name="public_discount" value="0">
                                <input type="hidden" name="public_earning" value="0">
                            @endif
                        @endif

                        {{-- ✅ Private Group Pricing (Hide for Free Trial) --}}
                        @if(in_array($gigData->group_type, ['Private', 'Both']))
                            @if ($gigData->recurring_type != 'Trial' || $gigData->trial_type != 'Free')
                                <div class="row">
                                    <h3 class="online-Class-Select-Heading" style="margin-top: 24px">
                                        How much would you charge per class and per person for Private Group?
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             viewBox="0 0 16 16" fill="none">
                                            <path
                                                d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 13.5C6.91221 13.5 5.84884 13.1774 4.94437 12.5731C4.0399 11.9687 3.33495 11.1098 2.91867 10.1048C2.50238 9.09977 2.39347 7.9939 2.60568 6.927C2.8179 5.86011 3.34173 4.8801 4.11092 4.11091C4.8801 3.34172 5.86011 2.8179 6.92701 2.60568C7.9939 2.39346 9.09977 2.50238 10.1048 2.91866C11.1098 3.33494 11.9687 4.03989 12.5731 4.94436C13.1774 5.84883 13.5 6.9122 13.5 8C13.4983 9.45818 12.9184 10.8562 11.8873 11.8873C10.8562 12.9184 9.45819 13.4983 8 13.5ZM9 11C9 11.1326 8.94732 11.2598 8.85356 11.3536C8.75979 11.4473 8.63261 11.5 8.5 11.5C8.23479 11.5 7.98043 11.3946 7.7929 11.2071C7.60536 11.0196 7.5 10.7652 7.5 10.5V8C7.36739 8 7.24022 7.94732 7.14645 7.85355C7.05268 7.75979 7 7.63261 7 7.5C7 7.36739 7.05268 7.24021 7.14645 7.14645C7.24022 7.05268 7.36739 7 7.5 7C7.76522 7 8.01957 7.10536 8.20711 7.29289C8.39465 7.48043 8.5 7.73478 8.5 8V10.5C8.63261 10.5 8.75979 10.5527 8.85356 10.6464C8.94732 10.7402 9 10.8674 9 11ZM7 5.25C7 5.10166 7.04399 4.95666 7.1264 4.83332C7.20881 4.70999 7.32595 4.61386 7.46299 4.55709C7.60003 4.50032 7.75083 4.48547 7.89632 4.51441C8.04181 4.54335 8.17544 4.61478 8.28033 4.71967C8.38522 4.82456 8.45665 4.9582 8.48559 5.10368C8.51453 5.24917 8.49968 5.39997 8.44291 5.53701C8.38615 5.67406 8.29002 5.79119 8.16668 5.8736C8.04334 5.95601 7.89834 6 7.75 6C7.55109 6 7.36032 5.92098 7.21967 5.78033C7.07902 5.63968 7 5.44891 7 5.25Z"
                                                fill="#0072B1"/>
                                        </svg>
                                    </h3>
                                    <div class="col-md-3 col-sm-12">
                                        <h3 class="online-Class-Select-Heading" style="margin-top: 16px">
                                            Price per person
                                        </h3>
                                        <input class="payment-input" name="private_rate" id="private_rate"
                                               placeholder="$50" type="number" onfocusout="validateRatePrice(this)"/>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <h3 class="online-Class-Select-Heading" style="margin-top: 16px">
                                            Group size Limit
                                        </h3>
                                        <input class="payment-input" name="private_group_size" id="private_size"
                                               placeholder="max 100" type="number"/>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <h3 class="online-Class-Select-Heading" style="margin-top: 16px">
                                            Discount per person
                                        </h3>
                                        <input class="payment-input" name="private_discount" id="private_discount"
                                               placeholder="50%" type="number"/>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <h3 class="online-Class-Select-Heading" style="margin-top: 16px">
                                            Earnings per person
                                        </h3>
                                        <input class="payment-input" name="private_earning"
                                               id="private_estimated_earning" placeholder="$50" readonly type="text"/>
                                    </div>
                                </div>
                            @else
                                {{-- Free Trial: Hidden inputs with $0 --}}
                                <input type="hidden" name="private_rate" value="0">
                                <input type="hidden" name="private_group_size" value="10">
                                <input type="hidden" name="private_discount" value="0">
                                <input type="hidden" name="private_earning" value="0">
                            @endif
                        @endif

                    </div>
                </div>

                {{-- Minor Attend Section --}}
                <div class="col-md-12">
                    <div class="row payment-type mx-1 my-3">
                        <div class="col-md-12">
                            <h3 class="online-Class-Select-Heading">
                                Can minors attend your class?
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                     fill="none">
                                    <path
                                        d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 13.5C6.91221 13.5 5.84884 13.1774 4.94437 12.5731C4.0399 11.9687 3.33495 11.1098 2.91867 10.1048C2.50238 9.09977 2.39347 7.9939 2.60568 6.927C2.8179 5.86011 3.34173 4.8801 4.11092 4.11091C4.8801 3.34172 5.86011 2.8179 6.92701 2.60568C7.9939 2.39346 9.09977 2.50238 10.1048 2.91866C11.1098 3.33494 11.9687 4.03989 12.5731 4.94436C13.1774 5.84883 13.5 6.9122 13.5 8C13.4983 9.45818 12.9184 10.8562 11.8873 11.8873C10.8562 12.9184 9.45819 13.4983 8 13.5ZM9 11C9 11.1326 8.94732 11.2598 8.85356 11.3536C8.75979 11.4473 8.63261 11.5 8.5 11.5C8.23479 11.5 7.98043 11.3946 7.7929 11.2071C7.60536 11.0196 7.5 10.7652 7.5 10.5V8C7.36739 8 7.24022 7.94732 7.14645 7.85355C7.05268 7.75979 7 7.63261 7 7.5C7 7.36739 7.05268 7.24021 7.14645 7.14645C7.24022 7.05268 7.36739 7 7.5 7C7.76522 7 8.01957 7.10536 8.20711 7.29289C8.39465 7.48043 8.5 7.73478 8.5 8V10.5C8.63261 10.5 8.75979 10.5527 8.85356 10.6464C8.94732 10.7402 9 10.8674 9 11ZM7 5.25C7 5.10166 7.04399 4.95666 7.1264 4.83332C7.20881 4.70999 7.32595 4.61386 7.46299 4.55709C7.60003 4.50032 7.75083 4.48547 7.89632 4.51441C8.04181 4.54335 8.17544 4.61478 8.28033 4.71967C8.38522 4.82456 8.45665 4.9582 8.48559 5.10368C8.51453 5.24917 8.49968 5.39997 8.44291 5.53701C8.38615 5.67406 8.29002 5.79119 8.16668 5.8736C8.04334 5.95601 7.89834 6 7.75 6C7.55109 6 7.36032 5.92098 7.21967 5.78033C7.07902 5.63968 7 5.44891 7 5.25Z"
                                        fill="#0072B1"/>
                                </svg>
                            </h3>
                            <div class="rAdio-Section">
                                <input class="radio-btn" name="minor_attend" onclick="MinorAttend(this.id)"
                                       id="minor_attend_1" value="1" type="radio" checked/>
                                <span class="Yes">Yes</span>
                                <input class="radio-btn" name="minor_attend" onclick="MinorAttend(this.id)"
                                       id="minor_attend_0" value="0" type="radio"/>
                                <span class="Yes">No</span>
                            </div>

                            <h3 class="online-Class-Select-Heading limit_show"
                                style="margin-top: 24px; margin-bottom: 16px">
                                Age Limit
                                <svg class="limit_show" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                     viewBox="0 0 16 16" fill="none">
                                    <path
                                        d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 13.5C6.91221 13.5 5.84884 13.1774 4.94437 12.5731C4.0399 11.9687 3.33495 11.1098 2.91867 10.1048C2.50238 9.09977 2.39347 7.9939 2.60568 6.927C2.8179 5.86011 3.34173 4.8801 4.11092 4.11091C4.8801 3.34172 5.86011 2.8179 6.92701 2.60568C7.9939 2.39346 9.09977 2.50238 10.1048 2.91866C11.1098 3.33494 11.9687 4.03989 12.57314.94436C13.1774 5.84883 13.5 6.9122 13.5 8C13.4983 9.45818 12.9184 10.8562 11.8873 11.8873C10.8562 12.9184 9.45819 13.4983 8 13.5ZM9 11C9 11.1326 8.94732 11.2598 8.85356 11.3536C8.75979 11.4473 8.63261 11.5 8.5 11.5C8.23479 11.5 7.98043 11.3946 7.7929 11.2071C7.60536 11.0196 7.5 10.7652 7.5 10.5V8C7.36739 8 7.24022 7.94732 7.14645 7.85355C7.05268 7.75979 7 7.63261 7 7.5C7 7.36739 7.05268 7.24021 7.14645 7.14645C7.24022 7.05268 7.36739 7 7.5 7C7.76522 7 8.01957 7.10536 8.20711 7.29289C8.39465 7.48043 8.5 7.73478 8.5 8V10.5C8.63261 10.5 8.75979 10.5527 8.85356 10.6464C8.94732 10.7402 9 10.8674 9 11ZM7 5.25C7 5.10166 7.04399 4.95666 7.1264 4.83332C7.20881 4.70999 7.32595 4.61386 7.46299 4.55709C7.60003 4.50032 7.75083 4.48547 7.89632 4.51441C8.04181 4.54335 8.17544 4.61478 8.28033 4.71967C8.38522 4.82456 8.45665 4.9582 8.48559 5.10368C8.51453 5.24917 8.49968 5.39997 8.44291 5.53701C8.38615 5.67406 8.29002 5.79119 8.16668 5.8736C8.04334 5.95601 7.89834 6 7.75 6C7.55109 6 7.36032 5.92098 7.21967 5.78033C7.07902 5.63968 7 5.44891 7 5.25Z"
                                        fill="#0072B1"/>
                                </svg>
                            </h3>
                            <select class="radio-input limit_show" name="age_limit" id="age_limit" class="fa">
                                @for ($i = 1; $i < 18; $i++)
                                    <option value="{{$i}}" class="fa">{{$i}}</option>
                                @endfor
                            </select>

                            <h3 class="online-Class-Select-Heading limit_show"
                                style="margin-top: 24px; margin-bottom: 16px">
                                How much childs attend class?
                                <svg class="limit_show" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                     viewBox="0 0 16 16" fill="none">
                                    <path
                                        d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 13.5C6.91221 13.5 5.84884 13.1774 4.94437 12.5731C4.0399 11.9687 3.33495 11.1098 2.91867 10.1048C2.50238 9.09977 2.39347 7.9939 2.60568 6.927C2.8179 5.86011 3.34173 4.8801 4.11092 4.11091C4.8801 3.34172 5.86011 2.8179 6.92701 2.60568C7.9939 2.39346 9.09977 2.50238 10.1048 2.91866C11.1098 3.33494 11.9687 4.03989 12.5731 4.94436C13.1774 5.84883 13.5 6.9122 13.5 8C13.4983 9.45818 12.9184 10.8562 11.8873 11.8873C10.8562 12.9184 9.45819 13.4983 8 13.5ZM9 11C9 11.1326 8.94732 11.2598 8.85356 11.3536C8.75979 11.4473 8.63261 11.5 8.5 11.5C8.23479 11.5 7.98043 11.3946 7.7929 11.2071C7.60536 11.0196 7.5 10.7652 7.5 10.5V8C7.36739 8 7.24022 7.94732 7.14645 7.85355C7.05268 7.75979 7 7.63261 7 7.5C7 7.36739 7.05268 7.24021 7.14645 7.14645C7.24022 7.05268 7.36739 7 7.5 7C7.76522 7 8.01957 7.10536 8.20711 7.29289C8.39465 7.48043 8.5 7.73478 8.5 8V10.5C8.63261 10.5 8.75979 10.5527 8.85356 10.6464C8.94732 10.7402 9 10.8674 9 11ZM7 5.25C7 5.10166 7.04399 4.95666 7.1264 4.83332C7.20881 4.70999 7.32595 4.61386 7.46299 4.55709C7.60003 4.50032 7.75083 4.48547 7.89632 4.51441C8.04181 4.54335 8.17544 4.61478 8.28033 4.71967C8.38522 4.82456 8.45665 4.9582 8.48559 5.10368C8.51453 5.24917 8.49968 5.39997 8.44291 5.53701C8.38615 5.67406 8.29002 5.79119 8.16668 5.8736C8.04334 5.95601 7.89834 6 7.75 6C7.55109 6 7.36032 5.92098 7.21967 5.78033C7.07902 5.63968 7 5.44891 7 5.25Z"
                                        fill="#0072B1"/>
                                </svg>
                            </h3>
                            <input type="number" class="radio-input limit_show" name="childs" id="childs" value="0">
                        </div>
                    </div>
                </div>

                {{-- Positive Search Terms --}}
                <div class="col-md-12">
                    <div class="row payment-type mx-1 my-3">
                        <div class="col-md-12">
                            <h3 class="online-Class-Select-Heading">
                                Positive Search Terms (Optional)
                            </h3>
                            <input type="text" class="form-control payment-input" id="input_positive_term"
                                   placeholder="Type and press Enter or comma......"/>
                            <input type="hidden" name="positive_term" id="positive_term">
                            <div id="positive_term_div" style="display: flex;gap: 10px;"></div>
                        </div>
                    </div>
                </div>

                {{-- FAQs Section --}}
                <div class="col-md-12">
                    <div class="row payment-type mx-1 my-3">
                        <div class="col-md-12">
                            <h3 class="online-Class-Select-Heading">
                                Services FAQ'S (Optional)
                            </h3>
                            <button id="add_new_btn" type="button" class="teacher-next-btn float-end mb-3">Add</button>

                            <div class="row mt-3 mb-3" id="add_faqs_main_div" style="display: none">
                                <div class="col-12 form-sec">
                                    <label for="inputAddress2"
                                           class="form-label online-Class-Select-Heading">Question</label>
                                    <input type="hidden" value="{{$gig->id}}" name="faqs_gig_id" id="faqs_gig_id">
                                    <input type="text" class="form-control payment-input" id="question" name="question"
                                           placeholder="How This Work?" required/>
                                </div>
                                <div class="col-12 mt-0 mb-3">
                                    <label for="inputAddress2"
                                           class="form-label online-Class-Select-Heading">Answer</label>
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

                            <div id="all_faqs" class="mb-3"></div>

                            <div class="row mt-3 mb-3" id="edit_faqs_main_div" style="display: none">
                                <div class="col-12 form-sec">
                                    <label for="inputAddress2"
                                           class="form-label online-Class-Select-Heading">Question</label>
                                    <input type="hidden" name="faqs_id" id="faqs_id">
                                    <input type="text" class="form-control payment-input" id="question_upd"
                                           name="question_upd" placeholder="How This Work?" required/>
                                </div>
                                <div class="col-12 mt-0 mb-3">
                                    <label for="inputAddress2"
                                           class="form-label online-Class-Select-Heading">Answer</label>
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

                {{-- ✅ Duration Section --}}
                <div class="col-md-12">
                    <div class="row payment-type mx-1 my-3">
                        <div class="col-md-12">
                            {{-- ✅ Duration Section --}}
                            <div class="row mt-3">
                                <div class="col-md-12 col-sm-12">
                                    <h3 class="online-Class-Select-Heading" style="margin-top: 16px; display: inline;">
                                        Duration
                                    </h3>

                                    @if ($gigData->class_type == 'Video')
                                        {{-- Video Course Duration --}}
                                        <div class="input-group mb-3" style="display: flex; flex-wrap: nowrap;">
                                            <span class="input-group-text" id="basic-addon1">Hr:Mi</span>
                                            <input type="text" id="duration" name="duration" placeholder="HH:MM"
                                                   class="payment-input fa" maxlength="5"
                                                   aria-describedby="basic-addon1"/>
                                        </div>

                                    @elseif ($gigData->recurring_type == 'Trial')
                                        {{-- ✅ Trial Class Duration Logic --}}
                                        @if ($gigData->trial_type == 'Free')
                                            {{-- Free Trial: 30 minutes FIXED --}}
                                            <input type="hidden" name="durationH" value="00">
                                            <input type="hidden" name="durationM" value="30">
                                            <div class="alert alert-info trial-alert">
                                                <i class="fas fa-info-circle"></i>
                                                <strong>Free Trial:</strong> Duration is fixed at 30 minutes
                                            </div>
                                            <select name="durationH_display" id="durationH" class="fa" disabled
                                                    style="background-color: #f0f0f0;">
                                                <option value="00" selected>00</option>
                                            </select>
                                            <span>Hr</span>
                                            <select name="durationM_display" id="durationM" class="fa" disabled
                                                    style="background-color: #f0f0f0;">
                                                <option value="30" selected>30</option>
                                            </select>
                                            <span>Mi</span>

                                        @else
                                            {{-- Paid Trial: Flexible Duration --}}
                                            <div class="alert alert-success trial-alert">
                                                <i class="fas fa-check-circle"></i>
                                                <strong>Paid Trial:</strong> You can set custom duration
                                            </div>
                                            <select name="durationH" id="durationH" class="fa">
                                                <option value="00" class="fa">00</option>
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}"
                                                            class="fa">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                                @endfor
                                            </select>
                                            <span>Hr</span>
                                            <select name="durationM" id="durationM" class="fa">
                                                <option value="00" class="fa">00</option>
                                                <option value="30" class="fa">30</option>
                                            </select>
                                            <span>Mi</span>
                                        @endif

                                    @else
                                        {{-- Normal Live Class Duration --}}
                                        <select name="durationH" id="durationH" class="fa">
                                            <option value="00" class="fa">00</option>
                                            @for ($i = 1; $i <= 10; $i++)
                                                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}"
                                                        class="fa">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                            @endfor
                                        </select>
                                        <span>Hr</span>

                                        <select name="durationM" id="durationM" class="fa">
                                            <option value="00" class="fa">00</option>
                                            <option value="30" class="fa">30</option>
                                        </select>
                                        <span>Mi</span>
                                    @endif
                                </div>
                            </div>


                            {{-- ✅ Repeat On Section (All Class Types) --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="online-Class-Select-Heading" style="margin-top: 24px">
                                        Repeat on :
                                    </h3>
                                        <div class="repeats-btn-section">
                                            <div>
                                                <button type="button" class="repeat-btn" onclick="RepeatOn(this)"
                                                        data-day='1'>Monday
                                                </button>
                                                <div id="time_div_1" class="time_div"></div>
                                            </div>
                                            <div>
                                                <button type="button" class="repeat-btn" onclick="RepeatOn(this)"
                                                        data-day='2'>Tuesday
                                                </button>
                                                <div id="time_div_2" class="time_div"></div>
                                            </div>
                                            <div>
                                                <button type="button" class="repeat-btn" onclick="RepeatOn(this)"
                                                        data-day='3'>Wednesday
                                                </button>
                                                <div id="time_div_3" class="time_div"></div>
                                            </div>
                                            <div>
                                                <button type="button" class="repeat-btn" onclick="RepeatOn(this)"
                                                        data-day='4'>Thursday
                                                </button>
                                                <div id="time_div_4" class="time_div"></div>
                                            </div>
                                            <div>
                                                <button type="button" class="repeat-btn" onclick="RepeatOn(this)"
                                                        data-day='5'>Friday
                                                </button>
                                                <div id="time_div_5" class="time_div"></div>
                                            </div>
                                            <div>
                                                <button type="button" class="repeat-btn" onclick="RepeatOn(this)"
                                                        data-day='6'>Saturday
                                                </button>
                                                <div id="time_div_6" class="time_div"></div>
                                            </div>
                                            <div>
                                                <button type="button" class="repeat-btn" onclick="RepeatOn(this)"
                                                        data-day='7'>Sunday
                                                </button>
                                                <div id="time_div_7" class="time_div"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="Teacher-next-back-Section" style="margin: 16px 0px">
                        <a href="/teacher-service-edit/{{$gig_id}}/edit" class="teacher-back-btn">Back</a>
                        <button type="button" onclick="SubmitForm()" class="teacher-next-btn">Next</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</section>

{{-- Moment CDN --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

{{-- ✅ Updated Form Validation Script --}}
<script>
    function SubmitForm() {
        let recurringType = '<?php echo $gigData->recurring_type ?>';
        let trialType = '<?php echo $gigData->trial_type ?? '' ?>';
        let serviceType = '<?php echo $gig->service_type ?>';
        let groupType = '<?php echo $gigData->group_type ?>';
        let classType = '<?php echo $gig->class_type ?? '' ?>';
        let duration = '';
        let valid = true;

        const showError = (message) => {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                timeOut: "10000",
                extendedTimeOut: "4410000"
            };
            toastr.error(message);
            valid = false;
        };

        const validateField = (field, message) => {
            if (!field) {
                showError(message);
                return false;
            }
            return true;
        };

        // ✅ Trial Class Special Handling
        if (recurringType === 'Trial') {
            console.log('Trial Class Detected:', trialType);

            if (trialType === 'Free') {
                // Free Trial: Auto values
                console.log('Free Trial: Duration = 30 min, Price = $0');
                duration = '00:30';

                // ✅ Group size validation - Check if elements exist first
                if (groupType === 'Public' || groupType === 'Both') {
                    const publicSizeElement = document.getElementById('public_size');
                    // Skip if element doesn't exist (hidden for free trial)
                    if (publicSizeElement && publicSizeElement.offsetParent !== null) {
                        if (!publicSizeElement.value) {
                            showError("Group Size Required!");
                            return false;
                        }
                    }
                }

                if (groupType === 'Private' || groupType === 'Both') {
                    const privateSizeElement = document.getElementById('private_size');
                    // Skip if element doesn't exist (hidden for free trial)
                    if (privateSizeElement && privateSizeElement.offsetParent !== null) {
                        if (!privateSizeElement.value) {
                            showError("Group Size Required!");
                            return false;
                        }
                    }
                }

            } else if (trialType === 'Paid') {
                // Paid Trial: Normal validation
                const durationH = document.getElementById('durationH');
                const durationM = document.getElementById('durationM');

                if (durationH && durationM) {
                    duration = `${durationH.value}:${durationM.value}`;

                    if (duration === '00:00') {
                        showError("Duration Required for Paid Trial!");
                        return false;
                    }
                }

                // Validate pricing for Paid Trial
                if (groupType === 'Public' || groupType === 'Both') {
                    const publicRateElement = document.getElementById('public_rate');
                    const publicSizeElement = document.getElementById('public_size');

                    if (publicRateElement && !publicRateElement.value) {
                        showError("Price Required for Paid Trial!");
                        return false;
                    }

                    if (publicSizeElement && !publicSizeElement.value) {
                        showError("Group Size Required!");
                        return false;
                    }
                }

                if (groupType === 'Private' || groupType === 'Both') {
                    const privateRateElement = document.getElementById('private_rate');
                    const privateSizeElement = document.getElementById('private_size');

                    if (privateRateElement && !privateRateElement.value) {
                        showError("Price Required for Paid Trial!");
                        return false;
                    }

                    if (privateSizeElement && !privateSizeElement.value) {
                        showError("Group Size Required!");
                        return false;
                    }
                }
            }

            // Trial: Must have at least one day selected in Repeat On section
            const activeDayButtons = document.querySelectorAll('.repeat-btn.active');

            if (activeDayButtons.length === 0) {
                showError("Please select at least one day for your Trial Class!");
                return false;
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

        } else {
            // ✅ Normal Class Validation (Not Trial)

            // Validate Group Type Pricing
            if (groupType === 'Public' || groupType === 'Both') {
                const publicRateElement = document.getElementById('public_rate');
                const publicSizeElement = document.getElementById('public_size');

                if (publicRateElement && !publicRateElement.value) {
                    showError("Individual Rate Required!");
                    return false;
                }

                if (publicSizeElement && !publicSizeElement.value) {
                    showError("Group Size Required!");
                    return false;
                }
            }

            if (groupType === 'Private' || groupType === 'Both') {
                const privateRateElement = document.getElementById('private_rate');
                const privateSizeElement = document.getElementById('private_size');

                if (privateRateElement && !privateRateElement.value) {
                    showError("Individual Rate Required!");
                    return false;
                }

                if (privateSizeElement && !privateSizeElement.value) {
                    showError("Group Size Required!");
                    return false;
                }
            }

            // Validate Duration
            if (serviceType === 'Online') {
                if (classType === 'Video') {
                    const durationInput = document.getElementById('duration');
                    if (durationInput && !durationInput.value) {
                        showError("Duration Required!");
                        return false;
                    }
                    duration = durationInput ? durationInput.value : '';
                } else {
                    const durationH = document.getElementById('durationH');
                    const durationM = document.getElementById('durationM');

                    if (durationH && durationM) {
                        duration = `${durationH.value}:${durationM.value}`;
                        if (duration === '00:00') {
                            showError("Duration Required!");
                            return false;
                        }
                    }
                }

                // OneDay Class Validation - Check Repeat On section
                if (recurringType === 'OneDay') {
                    const activeDayButtons = document.querySelectorAll('.repeat-btn.active');

                    if (activeDayButtons.length === 0) {
                        showError("Please select at least one day for your class!");
                        return false;
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

                        const start_time = startRepeatInputs[i].value;
                        const end_time = endRepeatInputs[i].value;

                        // Validate that end time is after start time
                        let startTimeMoment = moment(start_time, "HH:mm");
                        let endTimeMoment = moment(end_time, "HH:mm");

                        if (endTimeMoment.isSameOrBefore(startTimeMoment)) {
                            showError('End Time must be greater than Start Time for all selected days!');
                            endRepeatInputs[i].focus();
                            return false;
                        }

                        if (end_time === "00:00") {
                            showError('End Time cannot be 00:00!');
                            endRepeatInputs[i].focus();
                            return false;
                        }

                        // Validate duration fits within time slot
                        if (duration != '') {
                            let duration_part = duration.split(':');
                            const totalDurationMinutes = (parseInt(duration_part[0]) * 60) + parseInt(duration_part[1]);

                            const availabilityMinutes = moment.duration(endTimeMoment.diff(startTimeMoment)).asMinutes();

                            if (availabilityMinutes < totalDurationMinutes) {
                                showError(`Availability time must be at least ${duration_part[0]} hours and ${duration_part[1]} minutes for all selected days.`);
                                return false;
                            }
                        }
                    }
                } else {
                    // Recurring: Validate repeat days
                    const activeDays = [];
                    const activeDivs = [];
                    $('.repeat-btn.active').each(function () {
                        activeDays.push($(this).html());
                        activeDivs.push($(this).data('day'));
                    });

                    if (activeDays.length === 0) {
                        showError("Repeat Min 1 Day Required!");
                        return false;
                    }

                    for (let i = 0; i < activeDays.length; i++) {
                        const day = activeDays[i];
                        const data = activeDivs[i];
                        const startTimeInput = document.getElementById('start_repeat_' + data);
                        const endTimeInput = document.getElementById('end_repeat_' + data);

                        if (!startTimeInput || !endTimeInput) continue;

                        const start_repeat = startTimeInput.value;
                        const end_repeat = endTimeInput.value;

                        if (!start_repeat) {
                            showError(`Start Time Required for ${day}!`);
                            startTimeInput.focus();
                            return false;
                        }

                        if (!end_repeat) {
                            showError(`End Time Required for ${day}!`);
                            endTimeInput.focus();
                            return false;
                        }

                        if (start_repeat && end_repeat) {
                            let startTimeMoment = moment(start_repeat, "HH:mm");
                            let endTimeMoment = moment(end_repeat, "HH:mm");

                            if (endTimeMoment.isSameOrBefore(startTimeMoment)) {
                                alert('End Time must be greater than Start Time.');
                                endTimeInput.value = "";
                                endTimeInput.focus();
                                return false;
                            }

                            if (end_repeat === "00:00") {
                                alert('End Time cannot be 00:00.');
                                endTimeInput.value = "";
                                endTimeInput.focus();
                                return false;
                            }

                            if (duration != '') {
                                let duration_part = duration.split(':');
                                const totalDurationMinutes = (parseInt(duration_part[0]) * 60) + parseInt(duration_part[1]);

                                const startTimeMoment = moment(start_repeat, "HH:mm");
                                const endTimeMoment = moment(end_repeat, "HH:mm");
                                const availabilityMinutes = moment.duration(endTimeMoment.diff(startTimeMoment)).asMinutes();

                                if (availabilityMinutes < totalDurationMinutes) {
                                    showError(`Availability time must be at least ${duration_part[0]} hours and ${duration_part[1]} minutes.`);
                                    return false;
                                }
                            }
                        }
                    }
                }
            } else {
                // Inperson Class
                const durationH = document.getElementById('durationH');
                const durationM = document.getElementById('durationM');

                if (durationH && durationM) {
                    duration = `${durationH.value}:${durationM.value}`;
                    if (duration === '00:00') {
                        showError("Duration Required!");
                        return false;
                    }
                }

                // For recurring days
                const activeDays = [];
                const activeDivs = [];
                $('.repeat-btn.active').each(function () {
                    activeDays.push($(this).html());
                    activeDivs.push($(this).data('day'));
                });

                if (activeDays.length === 0) {
                    showError("Repeat Min 1 Day Required!");
                    return false;
                }

                for (let i = 0; i < activeDays.length; i++) {
                    const day = activeDays[i];
                    const data = activeDivs[i];
                    const startTimeInput = document.getElementById('start_repeat_' + data);
                    const endTimeInput = document.getElementById('end_repeat_' + data);

                    if (!startTimeInput || !endTimeInput) continue;

                    const start_repeat = startTimeInput.value;
                    const end_repeat = endTimeInput.value;

                    if (!start_repeat) {
                        showError(`Start Time Required for ${day}!`);
                        startTimeInput.focus();
                        return false;
                    }

                    if (!end_repeat) {
                        showError(`End Time Required for ${day}!`);
                        endTimeInput.focus();
                        return false;
                    }

                    if (start_repeat && end_repeat) {
                        let startTimeMoment = moment(start_repeat, "HH:mm");
                        let endTimeMoment = moment(end_repeat, "HH:mm");

                        if (endTimeMoment.isSameOrBefore(startTimeMoment)) {
                            alert('End Time must be greater than Start Time.');
                            endTimeInput.value = "";
                            endTimeInput.focus();
                            return false;
                        }

                        if (end_repeat === "00:00") {
                            alert('End Time cannot be 00:00.');
                            endTimeInput.value = "";
                            endTimeInput.focus();
                            return false;
                        }

                        if (duration != '') {
                            let duration_part = duration.split(':');
                            const totalDurationMinutes = (parseInt(duration_part[0]) * 60) + parseInt(duration_part[1]);

                            const startTimeMoment = moment(start_repeat, "HH:mm");
                            const endTimeMoment = moment(end_repeat, "HH:mm");
                            const availabilityMinutes = moment.duration(endTimeMoment.diff(startTimeMoment)).asMinutes();

                            if (availabilityMinutes < totalDurationMinutes) {
                                showError(`Availability time must be at least ${duration_part[0]} hours and ${duration_part[1]} minutes.`);
                                return false;
                            }
                        }
                    }
                }
            }
        }

        // Minor Attend Validation
        var minor_attend = $("input[name='minor_attend']:checked").val();
        if (minor_attend == 1) {
            var childsElement = $('#childs');
            var childs = childsElement.length ? parseInt(childsElement.val(), 10) || 0 : 0;

            if (groupType === 'Public' || groupType === 'Both') {
                var publicSizeElement = document.getElementById('public_size');
                var publicSize = publicSizeElement ? parseInt(publicSizeElement.value, 10) || 0 : 0;
            }

            if (groupType === 'Private' || groupType === 'Both') {
                var privateSizeElement = document.getElementById('private_size');
                var privateSize = privateSizeElement ? parseInt(privateSizeElement.value, 10) || 0 : 0;
            }

            var maxAllowed = Math.min(publicSize || Infinity, privateSize || Infinity);

            if (childs < 0 || childs > maxAllowed) {
                showError("Childs value must be between 0 and " + maxAllowed);
                if (childsElement.length) childsElement.val(0);
                return false;
            }
        }

        console.log('Duration:', duration);
        console.log('Validation Passed!');

        // Submit form if valid
        if (valid) {
            $('#myForm').submit();
        }
    }
</script>

{{-- All Other Existing Scripts --}}
<script>
    $(document).ready(function () {
        $('#duration').on('input', function () {
            let value = $(this).val();
            value = value.replace(/[^0-9:]/g, '');
            if (value.length > 2 && value.indexOf(':') === -1) {
                value = value.slice(0, 2) + ':' + value.slice(2);
            }
            if (value.length > 5) {
                value = value.slice(0, 5);
            }
            $(this).val(value);
        });

        $('#duration').on('focusout', function () {
            let value = $(this).val();
            let parts = value.split(':');
            if (parts.length === 2) {
                let hours = Math.min(24, Math.max(0, parseInt(parts[0] || '0')));
                let minutes = Math.min(59, Math.max(0, parseInt(parts[1] || '0')));
                parts[0] = hours.toString().padStart(2, '0');
                parts[1] = minutes.toString().padStart(2, '0');
                $(this).val(parts.join(':'));
            } else {
                $(this).val('00:00');
            }
        });
    });

    flatpickr(".timePickerFlatpickr", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        minuteIncrement: 30,
    });
</script>

{{-- Positive Search Terms Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputField = document.getElementById('input_positive_term');
        const outputDiv = document.getElementById('positive_term_div');
        const commaSeparatedField = document.getElementById('positive_term');
        let slices = [];

        inputField.addEventListener('keypress', function (event) {
            if (event.key === 'Enter' || event.key === ',') {
                event.preventDefault();
                let value = inputField.value.trim();

                if (value) {
                    let newSlices = value.split(',').map(item => item.trim());

                    if (slices.length >= 5) {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "timeOut": "10000",
                            "extendedTimeOut": "4410000"
                        }
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
                span.style.backgroundColor = '#0072b1';
                span.style.color = '#fff';
                span.style.padding = '0px 10px';
                span.style.borderRadius = '4px';
                span.style.display = 'flex';
                span.style.alignItems = 'center';
                span.style.gap = '10px';
                span.style.cursor = 'default';
                span.style.fontSize = '16px';
                span.style.width = 'max-content';

                let removeButton = document.createElement('span');
                removeButton.textContent = 'x';
                removeButton.className = 'remove';
                removeButton.style.color = '#fff';
                removeButton.style.padding = '5px';
                removeButton.style.cursor = 'pointer';

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

{{-- Start Date Selection Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dateInput = document.getElementById('start_date');
        if (dateInput) {
            let today = new Date();
            today.setDate(today.getDate() + 1);
            let year = today.getFullYear();
            let month = (today.getMonth() + 1).toString().padStart(2, '0');
            let day = today.getDate().toString().padStart(2, '0');
            let minDate = `${year}-${month}-${day}`;
            dateInput.setAttribute('min', minDate);
        }
    });

    document.getElementById('start_date')?.addEventListener('change', function () {
        let selectedDate = new Date(this.value);
        let today = new Date();
        today.setHours(0, 0, 0, 0);
        today.setDate(today.getDate() + 1);

        if (selectedDate < today) {
            alert('Please select a future date!');
            this.value = '';
        }
    });
</script>

{{-- Minor Attend Script --}}
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

{{-- Repeat On Script --}}
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

        if (activeDays.length > 0) {
            for (let i = 0; i < activeDays.length; i++) {
                const day = activeDays[i];
                const data = activeDivs[i];
                var html = ' <input type="hidden" name="day_repeat[]" value="' + day + '" class="payment-input mt-1 ">  ' +
                    '<div class="repeat-btn" style="color:#0072b1;font-weight:500;background:none;"> Start Time : <input type="text" style="width:120px;" id="start_repeat_' + data + '" name="start_repeat[]" class="timePickerFlatpickr payment-input mt-1"> </div>' +
                    '<div class="repeat-btn" style="color:#0072b1;font-weight:500;background:none;"> End Time : <input type="text" style="width:120px;" id="end_repeat_' + data + '" name="end_repeat[]" class="timePickerFlatpickr payment-input mt-1"> </div>';

                $('#time_div_' + data).html(html);

                flatpickr(".timePickerFlatpickr", {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    minuteIncrement: 30,
                });
            }
        }
    }
</script>

{{-- Estimated Payment Calculation Scripts --}}
<script>
    function validateRatePrice(input) {
        var value = parseFloat(input.value);
        if (isNaN(value) || value < 10) {
            alert("Minimum rate of $10 is allowed.");
            input.value = 10;
        }
    }

    // Public Group
    $('#public_rate').on('keyup', function () {
        var rate = $('#public_rate').val();
        var commission = parseFloat('<?php echo $commission ?? 12; ?>');
        let netPercent = 100 - commission;
        let estimatedEarnings = (rate * netPercent) / 100;
        $('#public_estimated_earning').val(estimatedEarnings.toFixed(2));
    });

    $('#public_size').on('keyup', function () {
        var size = $('#public_size').val();
        if (size > 100) {
            $('#public_size').val('');
            toastr.error("Maximum 100 Group Size Allowed!");
            return false;
        }
    });

    $('#public_discount').on('keyup', function () {
        var rate = $('#public_rate').val();
        var discount = $('#public_discount').val();
        if (discount > 88) {
            $('#public_discount').val('');
            $('#public_estimated_earning').val('');
            toastr.error("Maximum 88% Discount Allowed!");
            return false;
        }
        var discountVal = parseFloat(discount) || 0;
        var commission = parseFloat('<?php echo $commission ?? 12; ?>');
        let netPercent = 100 - (commission + discountVal);
        let estimatedEarnings = (rate * netPercent) / 100;
        $('#public_estimated_earning').val(estimatedEarnings.toFixed(2));
    });

    // Private Group
    $('#private_rate').on('keyup', function () {
        var rate = $('#private_rate').val();
        var commission = parseFloat('<?php echo $commission ?? 12; ?>');
        let netPercent = 100 - commission;
        let estimatedEarnings = (rate * netPercent) / 100;
        $('#private_estimated_earning').val(estimatedEarnings.toFixed(2));
    });

    $('#private_size').on('keyup', function () {
        var size = $('#private_size').val();
        if (size > 100) {
            $('#private_size').val('');
            toastr.error("Maximum 100 Group Size Allowed!");
            return false;
        }
    });

    $('#private_discount').on('keyup', function () {
        var rate = $('#private_rate').val();
        var discount = $('#private_discount').val();
        if (discount > 88) {
            $('#private_discount').val('');
            $('#private_estimated_earning').val('');
            toastr.error("Maximum 88% Discount Allowed!");
            return false;
        }
        var discountVal = parseFloat(discount) || 0;
        var commission = parseFloat('<?php echo $commission ?? 12; ?>');
        let netPercent = 100 - (commission + discountVal);
        let estimatedEarnings = (rate * netPercent) / 100;
        $('#private_estimated_earning').val(estimatedEarnings.toFixed(2));
    });
</script>

{{-- Load Page Confirmation --}}
<script>
    window.addEventListener('beforeunload', function (e) {
        if ($('#myForm').data('submitted')) {
            return;
        }
        var confirmationMessage = 'Are you sure you want to leave? Your changes might not be saved.';
        e.preventDefault();
        e.returnValue = confirmationMessage;
        return confirmationMessage;
    });

    $('#myForm').on('submit', function () {
        $(this).data('submitted', true);
    });
</script>

{{-- Sidebar Scripts --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let arrow = document.querySelectorAll(".arrow");
        for (let i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", function (e) {
                let arrowParent = e.target.parentElement.parentElement;
                arrowParent.classList.toggle("showMenu");
            });
        }

        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-menu");

        sidebarBtn.addEventListener("click", function () {
            sidebar.classList.toggle("close");
        });

        function toggleSidebar() {
            let screenWidth = window.innerWidth;
            if (screenWidth < 992) {
                sidebar.classList.add("close");
            } else {
                sidebar.classList.remove("close");
            }
        }

        toggleSidebar();
        window.addEventListener("resize", function () {
            toggleSidebar();
        });
    });
</script>

<!-- Tinymce js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.4.1/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: "#answer",
        plugins: "code visualblocks link",
        toolbar: [
            {name: "history", items: ["undo", "redo"]},
            {name: "styles", items: ["styles"]},
            {name: "formatting", items: ["bold", "italic", "underline", "removeformat"]},
            {name: "elements", items: ["link"]},
            {name: "source", items: ["code", "visualblocks"]},
        ],
    });

    tinymce.init({
        selector: "#answer_upd",
        plugins: "code visualblocks link",
        toolbar: [
            {name: "history", items: ["undo", "redo"]},
            {name: "styles", items: ["styles"]},
            {name: "formatting", items: ["bold", "italic", "underline", "removeformat"]},
            {name: "elements", items: ["link"]},
            {name: "source", items: ["code", "visualblocks"]},
        ],
    });
</script>

{{-- FAQs AJAX Scripts --}}
<script>
    $('#add_new_btn').click(function (e) {
        e.preventDefault();
        if ($('#add_faqs_main_div').is(':visible')) {
            $('#add_faqs_main_div').css('display', 'none');
            $('#edit_faqs_main_div').css('display', 'none');
        } else {
            $('#add_faqs_main_div').css('display', 'block');
            $('#edit_faqs_main_div').css('display', 'none');
        }
    });

    // Load FAQs on page load
    $(document).ready(function () {
        var gig_id = '<?php echo $gig->id ?>';

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: '/get-faqs-service',
            data: {gig_id: gig_id, _token: '{{csrf_token()}}'},
            dataType: 'json',
            success: function (response) {
                var faqs = response.faqs;
                var len = faqs.length;
                $('#all_faqs').empty();

                if (len > 0) {
                    for (let i = 0; i < len; i++) {
                        var id = faqs[i].id;
                        var question = faqs[i].question;
                        var answer = faqs[i].answer;

                        var faqs_html = `<div class="input-group mb-3 main_faqs_${id}">
                        <input type="text" value="${question}" class="form-control payment-input" readonly>
                        <button class="btn btn-danger text-white remove-button" type="button" onclick="RemoveFaqs(this.id)" id="remove_faqs_${id}" data-id="${id}">Remove</button>
                        <button class="btn teacher-next-btn" type="button" onclick="ViewFaqs(this.id)" id="faqs_view_${id}" data-id="${id}" data-question="${question}" data-answer="${answer}">View</button>
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

    // Add New FAQ
    $('#add_faqs_btn').click(function () {
        var gig_id = $('#faqs_gig_id').val();
        var question = $('#question').val().trim();
        const answer = tinymce.get('answer').getContent().trim();

        if (!question || !answer) {
            toastr.error('Both question and answer are required.');
            return;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: '/upload-faqs-services',
            data: {gig_id: gig_id, question: question, answer: answer, _token: '{{csrf_token()}}'},
            dataType: 'json',
            success: function (response) {
                $('#question').val('');
                tinymce.get('answer').setContent('');
                $('#add_faqs_main_div').css('display', 'none');

                if (response.success) {
                    var faqs = response.faqs;
                    var faqs_html = `<div class="input-group mb-3 main_faqs_${faqs.id}">
                    <input type="text" value="${faqs.question}" class="form-control payment-input" readonly>
                    <button class="btn btn-danger text-white remove-button" type="button" onclick="RemoveFaqs(this.id)" id="remove_faqs_${faqs.id}" data-id="${faqs.id}">Remove</button>
                    <button class="btn teacher-next-btn" type="button" onclick="ViewFaqs(this.id)" id="faqs_view_${faqs.id}" data-id="${faqs.id}" data-question="${faqs.question}" data-answer="${faqs.answer}">View</button>
                </div>`;

                    $('#all_faqs').append(faqs_html);
                    toastr.success(response.success);
                } else {
                    toastr.error(response.error);
                }
            },
            error: function (xhr, status, error) {
                toastr.error('An error occurred. Please try again.');
            }
        });
    });

    // Remove FAQ
    function RemoveFaqs(Clicked) {
        if (!confirm("Are You Sure, You Want to delete This Faqs ?")) {
            return false;
        }

        var id = $('#' + Clicked).data('id');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: '/delete-faqs-services',
            data: {id: id, _token: '{{csrf_token()}}'},
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('.main_faqs_' + id).remove();
                    toastr.info(response.success);
                } else {
                    toastr.error(response.error);
                }
            },
            error: function (xhr, status, error) {
                toastr.error('An error occurred. Please try again.');
            }
        });
    }

    // View FAQ
    function ViewFaqs(Clicked) {
        var id = $('#' + Clicked).data('id');
        var question = $('#' + Clicked).data('question');
        var answer = $('#' + Clicked).data('answer');

        $('#faqs_id').val(id);
        $('#question_upd').val(question);
        tinymce.get('answer_upd').setContent(answer);
        $('#edit_faqs_main_div').css('display', 'block');
        $('#add_faqs_main_div').css('display', 'none');
    }

    // Update FAQ
    $('#edit_faqs_btn').click(function () {
        var id = $('#faqs_id').val();
        var question = $('#question_upd').val().trim();
        const answer = tinymce.get('answer_upd').getContent().trim();

        if (!question || !answer) {
            toastr.error('Both question and answer are required.');
            return;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: '/updated-faqs-services',
            data: {id: id, question: question, answer: answer, _token: '{{csrf_token()}}'},
            dataType: 'json',
            success: function (response) {
                $('#faqs_id').val('');
                $('#question_upd').val('');
                tinymce.get('answer_upd').setContent('');
                $('#edit_faqs_main_div').css('display', 'none');

                if (response.success) {
                    var faqs = response.faqs;
                    var faqs_html = `
                    <input type="text" value="${faqs.question}" class="form-control payment-input" readonly>
                    <button class="btn btn-danger text-white remove-button" type="button" onclick="RemoveFaqs(this.id)" id="remove_faqs_${faqs.id}" data-id="${faqs.id}">Remove</button>
                    <button class="btn teacher-next-btn" type="button" onclick="ViewFaqs(this.id)" id="faqs_view_${faqs.id}" data-id="${faqs.id}" data-question="${faqs.question}"
data-answer="${faqs.answer}">View</button>
                `;

                    $(`.main_faqs_${faqs.id}`).html(faqs_html);
                    toastr.success(response.success);
                } else {
                    toastr.error(response.error);
                }
            },
            error: function (xhr, status, error) {
                toastr.error('An error occurred. Please try again.');
            }
        });
    });
</script>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

</body>
</html>
