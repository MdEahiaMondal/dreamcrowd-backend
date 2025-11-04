<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <!-- View Point scale to 1.0 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>


    <!-- file upload link -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css"
    />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
    />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    {{-- =======Toastr CDN ======== --}}
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- =======Toastr CDN ======== --}}
    <!-- Defualt css -->
    <link rel=" stylesheet " type=" text/css " href="assets/teacher/asset/css/class-management.css"/>
    <link rel=" stylesheet " href=" assets/teacher/asset/css/Learn-How.css">
    <link rel="stylesheet" href="assets/teacher/asset/css/sidebar.css">
    <link rel="stylesheet" href="assets/teacher/asset/css/style.css">

</head>


{{-- On Click Back Arrow Button then redirect to edit service Script start --}}

<script>
    // Function to get a cookie value by name
    function getCookie(name) {
        const cookies = document.cookie.split(';');
        for (let i = 0; i < cookies.length; i++) {
            const cookie = cookies[i].trim();
            if (cookie.startsWith(name + '=')) {
                return cookie.substring(name.length + 1);
            }
        }
        return null; // Return null if the cookie doesn't exist
    }

    // Function to clear a cookie
    function clearCookie(name) {
        document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/`;
    }

    // Get the gig_id cookie
    const gigId = getCookie('gig_id');

    // Check if gig_id has a value
    if (gigId && gigId !== '') {
        // Clear the gig_id cookie
        clearCookie('gig_id');

        // Redirect to the desired page with gigId
        window.location.href = `/teacher-service-edit/${gigId}/edit`; // Replace with your desired redirect URL
    }
</script>
{{-- On Click Back Arrow Button then redirect to edit service Script END --}}


<style>
    .d-block {
        padding-top: 20px;
    }

    .selected-image {
        position: relative;
        display: inline-block;
        margin: 10px;
    }

    .remove-img-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: red;
        color: white;
        padding: 5px;
        cursor: pointer;
    }

    button#multiSelectDropdown3:hover {
        color: black;
    }
</style>

<body>

{{-- ===========Teacher Sidebar Start==================== --}}
<x-teacher-sidebar/>
{{-- ===========Teacher Sidebar End==================== --}}
<section class="home-section">
    {{-- ===========Teacher NavBar Start==================== --}}
    <x-teacher-nav/>
    {{-- ===========Teacher NavBar End==================== --}}
    <!-- =============================== MAIN CONTENT START HERE =========================== -->
    <div class=" container-fluid ">
        <div class=" row dash-notification ">
            <div class=" col-md-12 ">
                <nav style=" --bs-breadcrumb-divider: '>' ; " aria-label=" breadcrumb ">
                    <ol class=" breadcrumb mt-3 ">
                        <li class=" breadcrumb-item active " aria-current=" page ">Dashboard</li>
                        <li class=" breadcrumb-item ">Order Managements</li>
                    </ol>
                </nav>
                <div class=" class-Menagent-Heading ">
                    <i class="bx bxs-graduation icon" title="Class Management"></i>
                    <span>Order Management</span>

                </div>

                <!-- Blue MASSEGES section -->


            </div>
        </div>
        <div class=" row ">

        </div>
        <!-- Select Section Start Here  -->
        <form id="myForm" action="/class-gig-data-upload" method="POST" enctype="multipart/form-data"> @csrf

            <div class=" row mx-1 ">
                <div class=" col-md-12 ">
                    <div class=" row mainSelect ">
                        <div class=" col-md-6 col-sm-12 ">
                            <h3 class=" Select-Heading ">Freelance Category </h3>
                            <div class=" select-box ">
                                <input type="hidden" name="role" id="role" value="{{$role}}">
                                <input type="hidden" name="type" id="type" value="{{$type}}">
                                <select name="category" id="category" class="fa">
                                    <option value="" class="fa">--Select Category--</option>
                                    @if ($categories)
                                        @php $i = 0; @endphp
                                        @foreach ($categories as $item)
                                            <option value="{{$categoryIds[$i]}}" class="fa">{{$item}}</option>
                                            @php $i++; @endphp
                                        @endforeach

                                    @endif

                                </select>
                            </div>


                        </div>


                        <div class=" col-md-6 col-sm-12 ">

                            <h3 class=" Select-Heading ">Freelance sub-category </h3>
                            <input type="hidden" name="sub_category" id="sub_category">
                            <p class="text-danger" id="sub_freelance_error" style="display: none;"></p>
                            <div class="dropdown">
                                <button
                                    class="btn dropdown-toggle form-select"
                                    type="button"
                                    id="multiSelectDropdown3"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false" onclick="SelectFreelanceCategorySub()"
                                    style="text-align: left; overflow: hidden; background: #f4fbff;   height: 48px;"
                                >--select sub-category--
                                </button>
                                <ul style="max-height: 200px; overflow-y: auto;"
                                    class="dropdown-menu multi-drop-select mt-2"
                                    aria-labelledby="multiSelectDropdown3"
                                >
                                    <div class="row" id="SubCategories">

                                        {{-- <div class="col-md-6">
                                          <li class="multi-text-li">
                                            <label> <input type="checkbox"  value="Website Development (Online)"  class="cat-input" />  Website Development </label>
                                          </li>
                                        </div> --}}



                                        {{-- <div class="col-md-3">
                                          <li class="multi-text-li">
                                            <label>
                                              <input
                                                type="checkbox"
                                                value="Website Development"
                                                class="subcat1-input"
                                              />
                                              Website Development
                                            </label>
                                          </li>
                                        </div> --}}

                                    </div>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 mt-3">
                            <h3 class=" Select-Heading ">Select freelance type
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                     fill="none">
                                    <path
                                        d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 13.5C6.91221 13.5 5.84884 13.1774 4.94437 12.5731C4.0399 11.9687 3.33495 11.1098 2.91867 10.1048C2.50238 9.09977 2.39347 7.9939 2.60568 6.927C2.8179 5.86011 3.34173 4.8801 4.11092 4.11091C4.8801 3.34172 5.86011 2.8179 6.92701 2.60568C7.9939 2.39346 9.09977 2.50238 10.1048 2.91866C11.1098 3.33494 11.9687 4.03989 12.5731 4.94436C13.1774 5.84883 13.5 6.9122 13.5 8C13.4983 9.45818 12.9184 10.8562 11.8873 11.8873C10.8562 12.9184 9.45819 13.4983 8 13.5ZM9 11C9 11.1326 8.94732 11.2598 8.85356 11.3536C8.75979 11.4473 8.63261 11.5 8.5 11.5C8.23479 11.5 7.98043 11.3946 7.7929 11.2071C7.60536 11.0196 7.5 10.7652 7.5 10.5V8C7.36739 8 7.24022 7.94732 7.14645 7.85355C7.05268 7.75979 7 7.63261 7 7.5C7 7.36739 7.05268 7.24021 7.14645 7.14645C7.24022 7.05268 7.36739 7 7.5 7C7.76522 7 8.01957 7.10536 8.20711 7.29289C8.39465 7.48043 8.5 7.73478 8.5 8V10.5C8.63261 10.5 8.75979 10.5527 8.85356 10.6464C8.94732 10.7402 9 10.8674 9 11ZM7 5.25C7 5.10166 7.04399 4.95666 7.1264 4.83332C7.20881 4.70999 7.32595 4.61386 7.46299 4.55709C7.60003 4.50032 7.75083 4.48547 7.89632 4.51441C8.04181 4.54335 8.17544 4.61478 8.28033 4.71967C8.38522 4.82456 8.45665 4.9582 8.48559 5.10368C8.51453 5.24917 8.49968 5.39997 8.44291 5.53701C8.38615 5.67406 8.29002 5.79119 8.16668 5.8736C8.04334 5.95601 7.89834 6 7.75 6C7.55109 6 7.36032 5.92098 7.21967 5.78033C7.07902 5.63968 7 5.44891 7 5.25Z"
                                        fill="#0072B1"/>
                                </svg>
                            </h3>
                            <div class=" select-box ">
                                <select name="freelance_type" id="freelance_type" class=" fa ">

                                    <option value="Basic" class=" fa ">Basic Services</option>
                                    <option value="Premium" class=" fa ">Premium Services</option>
                                    <option value="Both" class=" fa ">Both Services</option>
                                </select>
                            </div>

                        </div>


                        <div class="col-md-6 col-sm-12  mt-3">
                            <h3 class=" Select-Heading ">Payment Type</h3>
                            <div class=" select-box ">
                                <select name="payment_type" id="payment_type" class="fa">
                                    <option value="OneOff" class="fa"> One-Of Payment</option>
                                    <option value="Subscription" class="fa">Subscription</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6 col-sm-12  mt-3">
                            <h3 class=" Select-Heading ">Normal Freelance Service or Consultation Service</h3>
                            <div class=" select-box ">
                                <select name="freelance_service" id="freelance_service" class="fa">
                                    <option value="Normal" class="fa">Normal Freelance</option>
                                    <option value="Consultation" class="fa">Consultation Service</option>
                                </select>
                            </div>
                        </div>

                        @if ($type == 'Online')
                            <div class="col-md-6 col-sm-12" id="meeting_platform_main" style="display: none;">
                                <h3 class="Select-Heading mt-2">
                                    Meeting Platform
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                         fill="none">
                                        <path
                                            d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 13.5C6.91221 13.5 5.84884 13.1774 4.94437 12.5731C4.0399 11.9687 3.33495 11.1098 2.91867 10.1048C2.50238 9.09977 2.39347 7.9939 2.60568 6.927C2.8179 5.86011 3.34173 4.8801 4.11092 4.11091C4.8801 3.34172 5.86011 2.8179 6.92701 2.60568C7.9939 2.39346 9.09977 2.50238 10.1048 2.91866C11.1098 3.33494 11.9687 4.03989 12.5731 4.94436C13.1774 5.84883 13.5 6.9122 13.5 8C13.4983 9.45818 12.9184 10.8562 11.8873 11.8873C10.8562 12.9184 9.45819 13.4983 8 13.5ZM9 11C9 11.1326 8.94732 11.2598 8.85356 11.3536C8.75979 11.4473 8.63261 11.5 8.5 11.5C8.23479 11.5 7.98043 11.3946 7.7929 11.2071C7.60536 11.0196 7.5 10.7652 7.5 10.5V8C7.36739 8 7.24022 7.94732 7.14645 7.85355C7.05268 7.75979 7 7.63261 7 7.5C7 7.36739 7.05268 7.24021 7.14645 7.14645C7.24022 7.05268 7.36739 7 7.5 7C7.76522 7 8.01957 7.10536 8.20711 7.29289C8.39465 7.48043 8.5 7.73478 8.5 8V10.5C8.63261 10.5 8.75979 10.5527 8.85356 10.6464C8.94732 10.7402 9 10.8674 9 11ZM7 5.25C7 5.10166 7.04399 4.95666 7.1264 4.83332C7.20881 4.70999 7.32595 4.61386 7.46299 4.55709C7.60003 4.50032 7.75083 4.48547 7.89632 4.51441C8.04181 4.54335 8.17544 4.61478 8.28033 4.71967C8.38522 4.82456 8.45665 4.9582 8.48559 5.10368C8.51453 5.24917 8.49968 5.39997 8.44291 5.53701C8.38615 5.67406 8.29002 5.79119 8.16668 5.8736C8.04334 5.95601 7.89834 6 7.75 6C7.55109 6 7.36032 5.92098 7.21967 5.78033C7.07902 5.63968 7 5.44891 7 5.25Z"
                                            fill="#0072B1"/>
                                    </svg>
                                </h3>
                                <div class="select-box">
                                    <select name="meeting_platform" id="meeting_platform" class="fa">
                                        <option value="" class="fa">--Select Platform--</option>
                                        <option value="Zoom" class="fa">
                                            Zoom
                                        </option>
                                        <option value="Google" class="fa">
                                            Google Meet
                                        </option>
                                    </select>
                                </div>
                            </div>
                        @endif

                        @if ($type == 'Online')

                            <div class="col-md-6 col-sm-12  mt-3" id="video_call_main_div" style="display: none;">
                                <h3 class=" Select-Heading ">Would you require a scheduled video call
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                         fill="none">
                                        <path
                                            d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 13.5C6.91221 13.5 5.84884 13.1774 4.94437 12.5731C4.0399 11.9687 3.33495 11.1098 2.91867 10.1048C2.50238 9.09977 2.39347 7.9939 2.60568 6.927C2.8179 5.86011 3.34173 4.8801 4.11092 4.11091C4.8801 3.34172 5.86011 2.8179 6.92701 2.60568C7.9939 2.39346 9.09977 2.50238 10.1048 2.91866C11.1098 3.33494 11.9687 4.03989 12.5731 4.94436C13.1774 5.84883 13.5 6.9122 13.5 8C13.4983 9.45818 12.9184 10.8562 11.8873 11.8873C10.8562 12.9184 9.45819 13.4983 8 13.5ZM9 11C9 11.1326 8.94732 11.2598 8.85356 11.3536C8.75979 11.4473 8.63261 11.5 8.5 11.5C8.23479 11.5 7.98043 11.3946 7.7929 11.2071C7.60536 11.0196 7.5 10.7652 7.5 10.5V8C7.36739 8 7.24022 7.94732 7.14645 7.85355C7.05268 7.75979 7 7.63261 7 7.5C7 7.36739 7.05268 7.24021 7.14645 7.14645C7.24022 7.05268 7.36739 7 7.5 7C7.76522 7 8.01957 7.10536 8.20711 7.29289C8.39465 7.48043 8.5 7.73478 8.5 8V10.5C8.63261 10.5 8.75979 10.5527 8.85356 10.6464C8.94732 10.7402 9 10.8674 9 11ZM7 5.25C7 5.10166 7.04399 4.95666 7.1264 4.83332C7.20881 4.70999 7.32595 4.61386 7.46299 4.55709C7.60003 4.50032 7.75083 4.48547 7.89632 4.51441C8.04181 4.54335 8.17544 4.61478 8.28033 4.71967C8.38522 4.82456 8.45665 4.9582 8.48559 5.10368C8.51453 5.24917 8.49968 5.39997 8.44291 5.53701C8.38615 5.67406 8.29002 5.79119 8.16668 5.8736C8.04334 5.95601 7.89834 6 7.75 6C7.55109 6 7.36032 5.92098 7.21967 5.78033C7.07902 5.63968 7 5.44891 7 5.25Z"
                                            fill="#0072B1"/>
                                    </svg>
                                </h3>
                                <div class=" select-box ">
                                    <select name="video_call" id="video_call" class="fa">
                                        <option value="Yes" class="fa">Yes</option>
                                    </select>
                                </div>
                            </div>
                        @endif
                        @if ($type == 'Inperson')

                            <div class="col-md-6 col-sm-12 " id="service_delivery_main">
                                <h3 class=" Select-Heading mt-2 ">Service Delivery Options</h3>
                                <div class=" select-box ">
                                    <select name="service_delivery" id="service_delivery" class="fa">
                                        <option value="0" class="fa">I will visit clients sites to offer this service
                                        </option>
                                        <option value="1" class="fa">This service would be offered at my work site
                                        </option>
                                        <option value="2" class="fa">Both Delivery Options</option>
                                    </select>
                                </div>
                            </div>
                            <div class=" col-md-6 col-sm-12 " id="max_distance_main">
                                <h3 class=" Select-Heading mt-2 ">Max. Travel Distance
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                         fill="none">
                                        <path
                                            d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 13.5C6.91221 13.5 5.84884 13.1774 4.94437 12.5731C4.0399 11.9687 3.33495 11.1098 2.91867 10.1048C2.50238 9.09977 2.39347 7.9939 2.60568 6.927C2.8179 5.86011 3.34173 4.8801 4.11092 4.11091C4.8801 3.34172 5.86011 2.8179 6.92701 2.60568C7.9939 2.39346 9.09977 2.50238 10.1048 2.91866C11.1098 3.33494 11.9687 4.03989 12.5731 4.94436C13.1774 5.84883 13.5 6.9122 13.5 8C13.4983 9.45818 12.9184 10.8562 11.8873 11.8873C10.8562 12.9184 9.45819 13.4983 8 13.5ZM9 11C9 11.1326 8.94732 11.2598 8.85356 11.3536C8.75979 11.4473 8.63261 11.5 8.5 11.5C8.23479 11.5 7.98043 11.3946 7.7929 11.2071C7.60536 11.0196 7.5 10.7652 7.5 10.5V8C7.36739 8 7.24022 7.94732 7.14645 7.85355C7.05268 7.75979 7 7.63261 7 7.5C7 7.36739 7.05268 7.24021 7.14645 7.14645C7.24022 7.05268 7.36739 7 7.5 7C7.76522 7 8.01957 7.10536 8.20711 7.29289C8.39465 7.48043 8.5 7.73478 8.5 8V10.5C8.63261 10.5 8.75979 10.5527 8.85356 10.6464C8.94732 10.7402 9 10.8674 9 11ZM7 5.25C7 5.10166 7.04399 4.95666 7.1264 4.83332C7.20881 4.70999 7.32595 4.61386 7.46299 4.55709C7.60003 4.50032 7.75083 4.48547 7.89632 4.51441C8.04181 4.54335 8.17544 4.61478 8.28033 4.71967C8.38522 4.82456 8.45665 4.9582 8.48559 5.10368C8.51453 5.24917 8.49968 5.39997 8.44291 5.53701C8.38615 5.67406 8.29002 5.79119 8.16668 5.8736C8.04334 5.95601 7.89834 6 7.75 6C7.55109 6 7.36032 5.92098 7.21967 5.78033C7.07902 5.63968 7 5.44891 7 5.25Z"
                                            fill="#0072B1"/>
                                    </svg>
                                </h3>
                                {{-- <input class=" Class-Title " id="max_distance" name="max_distance" placeholder="10 Miles" type="number"   style="padding: 14px 20px;">  --}}
                                <div class=" select-box ">
                                    <select name="max_distance" id="max_distance" class="fa   ">
                                        <option value="1" class="fa">1 Mile</option>
                                        <option value="3" class="fa">3 Miles</option>
                                        <option value="5" class="fa">5 Miles</option>
                                        <option value="10" class="fa">10 Miles</option>
                                        <option value="20" class="fa">20 Miles</option>
                                        <option value="30" class="fa">30+ Miles</option>
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-6 col-sm-12" id="work_site_main" style="display: none;">
                                <h3 class="Select-Heading mt-2">
                                    Work Site Location
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                         fill="none">
                                        <path d="..." fill="#0072B1"/>
                                    </svg>
                                </h3>
                                <div style="position: relative;">
                                    <input
                                        class="Class-Title"
                                        id="work_site"
                                        name="work_site"
                                        placeholder="Work Site Location"
                                        type="text" style="padding: 14px 20px;"
                                        autocomplete="off"
                                    />
                                    <style>
                                        #nearme_dropdown li:hover {
                                            background-color: var(--Colors-Dashboard-Background, #f4fbff);
                                            color: var(--Colors-Logo-Color, #0072b1);
                                            border: 1px solid rgb(210 229 240);
                                            border-radius: 15px;
                                            font-size: 15px;

                                        }
                                    </style>
                                    <!-- Dropdown for Near Me -->
                                    <ul id="nearme_dropdown"
                                        style="border-radius: 15px;display: none; position: absolute; background: white; border: 1px solid #ccc; width: 80%; z-index: 1000; list-style: none; padding: 0; margin: 0;bottom: -14px;left: 7px;">
                                        <li
                                            style="padding: 8px; cursor: pointer; font-size: 14px;"
                                            id="nearme_option"
                                        >Near Me
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class=" row ">
                <div class=" col-md-12 ">
                    <div class=" mainSelect ">
                        <div>
                            <h3 class=" Select-Heading ">Title</h3>
                            <input class=" Class-Title " id="title" name="title" placeholder="Class Title "
                                   type=" text ">
                        </div>
                        <div>
                            <h3 class=" Select-Heading " id="heading_d_1">Description</h3>
                            <textarea id="description" name="description" rows=" 4 " cols=" 20 "></textarea>
                        </div>
                        <div>
                            <h3 class=" Select-Heading mt-2" id="heading_r_1">Requirements</h3>
                            <textarea id="requirements" name="requirements" rows=" 4 " cols=" 20 "></textarea>
                        </div>

                        <div id="d_main_2" style="display: none">
                            <h3 class=" Select-Heading " id="heading_d_2">Description (Premium)</h3>
                            <textarea id="description_2" name="description_2" rows=" 4 " cols=" 20 "></textarea>
                        </div>
                        <div id="r_main_2" style="display: none">
                            <h3 class=" Select-Heading mt-2" id="heading_r_2">Requirements (Premium)</h3>
                            <textarea id="requirements_2" name="requirements_2" rows=" 4 " cols=" 20 "></textarea>
                        </div>

                        <h3 class=" Select-Heading mt-2">Upload a video or image to support the title/description</h3>
                        <!-- upload Section start -->
                        <div class="row">
                            <div class="col-md-12 identity" id="upload-image1" style="margin-bottom: 10px;">
                                <div class="input-file-wrapper transition-linear-3 position-relative">
                                  <span
                                      class="remove-img-btn position-absolute"
                                      style="cursor: pointer;background: #ed5646;color: white !important;border-radius: 5px;z-index: 10;padding: 4px 8px !important;"
                                      @click="reset('post-thumbnail1')"
                                      v-if="preview!==null"
                                  >
                                    Remove
                                  </span>
                                    <label
                                        class="input-style input-label lh-1-7 p-4 text-center cursor-pointer"
                                        for="post-thumbnail1"
                                        style="background: #f4fbff;border-radius: 4px;cursor: pointer; width: 100%;"
                                    >
                                    <span v-show="preview===null">
                                      <i class="fa-solid fa-cloud-arrow-up pt-3"
                                         style="color: #ababab; font-size: 40px; margin-bottom: 10px;"></i>
                                      <span class="d-block" style="color: #0072b1;margin-bottom: 10px;">Upload Main Image or Video</span>
                                      <p>Drag and drop files here</p>
                                    </span>
                                        <template v-if="preview" style="height: 250px; width:100%">
                                            <template v-if="isImage">
                                                <img :src="preview" class="img-fluid mt-2" style="height: 180px;"/>
                                            </template>
                                            <template v-if="!isImage">
                                                <video :src="preview" class="img-fluid mt-2"
                                                       style="height: 240px; width: 100%;" controls></video>
                                            </template>
                                        </template>
                                    </label>
                                    <input
                                        type="file" name="main_file"
                                        accept="image/*,video/*" value=""
                                        @change="previewImage('post-thumbnail1')"
                                        class="input-file"
                                        id="post-thumbnail1"
                                    />
                                </div>
                            </div>

                        </div>
                        <!-- Upload Section End -->
                        <h3 class=" Select-Heading ">Add other photos (optional)</h3>
                        <!-- upload Section start -->
                        <div class="row">
                            <div class="col-md-12 identity" id="upload-image3" style="margin-bottom: 10px;">
                                <div class="input-file-wrapper transition-linear-3 position-relative">
                                    <label
                                        class="input-style input-label lh-1-7 p-4 text-center cursor-pointer"
                                        for="post-thumbnail3"
                                        style="background: #f4fbff;border-radius: 4px;cursor: pointer; width: 100%;"
                                    >
                                    <span>
                                      <i class="fa-solid fa-cloud-arrow-up pt-3"
                                         style="color: #ababab; font-size: 40px; margin-bottom: 10px;"></i>
                                      <span class="d-block"
                                            style="color: #0072b1;margin-bottom: 10px;">Upload Image</span>
                                      <p>Drag and drop files here</p>
                                    </span>
                                    </label>
                                    <input
                                        type="file" name="other[]"
                                        accept="image/*" value=""
                                        @change="previewImages('post-thumbnail3')"
                                        class="input-file"
                                        id="post-thumbnail3" multiple
                                    />
                                </div>

                                <!-- Display the selected images or videos here -->
                                <div id="selected_more_image_show_div" v-if="images.length > 0">
                                    <div v-for="(image, index) in images" :key="index" class="selected-image">
                                        <template v-if="image.type === 'image'">
                                            <img :src="image.src" class="img-fluid" style="height: 180px;"/>
                                        </template>
                                        <template v-if="image.type === 'video'">
                                            <video :src="image.src" class="img-fluid" style="height: 180px;"
                                                   controls></video>
                                        </template>
                                        <span
                                            class="remove-img-btn position-absolute"
                                            style="cursor: pointer;background: #ed5646;color: white !important;border-radius: 5px;z-index: 10;padding: 4px 8px !important;"
                                            @click="removeImage(index)"
                                        >
                                      Remove
                                    </span>
                                    </div>
                                </div>

                                <!-- Hidden input to store the selected images or videos -->
                                <input type="hidden" name="other_input" id="selected_more_images"
                                       v-model="imageInputValue"/>
                            </div>

                        </div>
                        <!-- Upload Section End -->
                        <h3 class=" Select-Heading mt-2">Add a video (optional)</h3>
                        <!-- upload Section start -->
                        <div class="row">
                            <div class="col-md-12 identity" id="upload-image2" style="margin-bottom: 10px;">
                                <div class="input-file-wrapper transition-linear-3 position-relative">
                                  <span
                                      class="remove-img-btn position-absolute"
                                      style="cursor: pointer;background: #ed5646;color: white !important;border-radius: 5px;z-index: 10;padding: 4px 8px !important;"
                                      @click="reset('post-thumbnail2')"
                                      v-if="preview!==null"
                                  >
                                    Remove
                                  </span>
                                    <label
                                        class="input-style input-label lh-1-7 p-4 text-center cursor-pointer"
                                        for="post-thumbnail2"
                                        style="background: #f4fbff;border-radius: 4px;cursor: pointer; width: 100%;"
                                    >
                                    <span v-show="preview===null">
                                      <i class="fa-solid fa-cloud-arrow-up pt-3"
                                         style="color: #ababab; font-size: 40px; margin-bottom: 10px;"></i>
                                      <span class="d-block"
                                            style="color: #0072b1;margin-bottom: 10px;">Upload Video</span>
                                      <p>Drag and drop files here</p>
                                    </span>
                                        <template v-if="preview" style="height: 250px; width:100%">
                                            <template v-if="isImage">
                                                <img :src="preview" class="img-fluid mt-2" style="height: 180px;"/>
                                            </template>
                                            <template v-if="!isImage">
                                                <video :src="preview" class="img-fluid mt-2"
                                                       style="height: 240px; width: 100%;" controls></video>
                                            </template>
                                        </template>
                                    </label>
                                    <input
                                        type="file" name="video"
                                        accept="video/*" value=""
                                        @change="previewImage('post-thumbnail2')"
                                        class="input-file"
                                        id="post-thumbnail2"
                                    />
                                </div>
                            </div>
                        </div>
                        <!-- Upload Section End -->
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="Teacher-next-back-Section">
                        <a href="/class-management" class="teacher-back-btn">Back</a>
                        <button type="button" onclick="SubmitForm()" class="teacher-next-btn">Next</button>
                        {{-- <a class="teacher-next-btn" href="/class-payment-set">Next</a> --}}
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- =============================== MAIN CONTENT END HERE =========================== -->
</section>


{{-- <script src=" assets/teacher/libs/jquery/jquery.js "></script> --}}
<script src=" assets/teacher/libs/datatable/js/datatable.js "></script>
<script src=" assets/teacher/libs/datatable/js/datatablebootstrap.js "></script>
<script src=" assets/teacher/libs/select2/js/select2.min.js "></script>
<!-- <script src=" assets/teacher/libs/owl-carousel/js/jquery.min.js "></script> -->
<script src=" assets/teacher/libs/owl-carousel/js/owl.carousel.min.js "></script>
<script src="assets/admin/libs/aos/js/aos.js"></script>

<script>

    $('#freelance_type').on('change', function () {

        var freelance_type = $('#freelance_type').val();

        if (freelance_type == 'Both') {
            $('#heading_d_1').html('Description (Basic)');
            $('#heading_r_1').html('Requirements (Basic)');
            $('#d_main_2').show();
            $('#r_main_2').show();
        } else {
            $('#heading_d_1').html('Description');
            $('#heading_r_1').html('Requirements');
            $('#d_main_2').hide();
            $('#r_main_2').hide();
        }

    });


    $('#category').on('change', function () {
        var category = $('#category').val();
        var role = $('#role').val();
        var type = $('#type').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: '/get-class-manage-sub-cates',
            data: {type: type, role: role, category: category, _token: '{{csrf_token()}}'},
            dataType: 'json',
            success: function (response) {

                var sub_cates = response['sub_cates'];
                var len = sub_cates.length;
                $('#SubCategories').empty();


                // Loop through response values and generate HTML
                sub_cates.forEach(function (subcat) {
                    const div_main = document.createElement('div');
                    div_main.className = 'col-md-6 freelance_sub'; // Fixed class

                    const li = document.createElement('li');
                    li.className = 'multi-text-li';

                    const label = document.createElement('label');
                    const checkbox = document.createElement('input');

                    checkbox.type = 'checkbox';
                    checkbox.name = 'subcategories[]';
                    checkbox.className = 'subcat1-input freelancesub';
                    checkbox.value = subcat;

                    label.appendChild(checkbox); // Append checkbox to label
                    label.append(subcat); // Append text value to label
                    li.appendChild(label); // Append label to li
                    div_main.appendChild(li); // Append li to main div

                    // Append final HTML to the container
                    $('#SubCategories').append(div_main);
                });


            },

        });

    });


    // Select Multiple SubCategories =========


    function SelectFreelanceCategorySub() {
        const chBoxes3 = document.querySelectorAll(".dropdown-menu .subcat1-input");
        const dpBtn3 = document.getElementById("multiSelectDropdown3");
        let mySelectedListItems3 = [];


        function handleCB() {

            let checkedCount = document.querySelectorAll(".dropdown-menu .subcat1-input:checked").length;

            // Prevent checking more than 3 checkboxes
            if (checkedCount > 3) {
                event.target.checked = false; // Uncheck the last checkbox
                alert("You can select up to 3 sub-categories only.");
                return;
            }

            mySelectedListItems3 = [];
            let mySelectedListItemsText3 = "";

            chBoxes3.forEach((checkbox) => {
                if (checkbox.checked) {

                    mySelectedListItems3.push(checkbox.value);
                    mySelectedListItemsText3 += checkbox.value + ", ";
                }
            });

            $('#sub_category').val(mySelectedListItems3);


            dpBtn3.innerText =
                mySelectedListItems3.length > 0
                    ? mySelectedListItemsText3.slice(0, -2)
                    : "--select sub-category--";
        }

        chBoxes3.forEach((checkbox) => {
            checkbox.addEventListener("change", handleCB);
        });
    }


</script>

<script>
    $(document).ready(function () {
        $('.owl-carousel').owlCarousel({
            items: 1,
            margin: 30
        });
    })
</script>
<!-- ================ side js start here=============== -->

<!-- Tinymcs js link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.4.1/tinymce.min.js"></script>

<!-- Tinymce js start -->
<script>
    tinymce.init({
        selector: '#description', // Replace with your textarea selector
        menubar: false, // Hide the menu bar
        toolbar: 'bold italic strikethrough backcolor numlist bullist', // Include only the allowed options
        plugins: 'lists', // Ensure the 'lists' plugin is enabled for numbering and bullets
        branding: false, // Remove "Powered by TinyMCE" branding
        content_style: "body { font-family: Arial, sans-serif; font-size: 14px; }" // Optional styling
    });
    tinymce.init({
        selector: '#requirements', // Replace with your textarea selector
        menubar: false, // Hide the menu bar
        toolbar: 'bold italic strikethrough backcolor numlist bullist', // Include only the allowed options
        plugins: 'lists', // Ensure the 'lists' plugin is enabled for numbering and bullets
        branding: false, // Remove "Powered by TinyMCE" branding
        content_style: "body { font-family: Arial, sans-serif; font-size: 14px; }" // Optional styling
    });

    tinymce.init({
        selector: '#description_2', // Replace with your textarea selector
        menubar: false, // Hide the menu bar
        toolbar: 'bold italic strikethrough backcolor numlist bullist', // Include only the allowed options
        plugins: 'lists', // Ensure the 'lists' plugin is enabled for numbering and bullets
        branding: false, // Remove "Powered by TinyMCE" branding
        content_style: "body { font-family: Arial, sans-serif; font-size: 14px; }" // Optional styling
    });
    tinymce.init({
        selector: '#requirements_2', // Replace with your textarea selector
        menubar: false, // Hide the menu bar
        toolbar: 'bold italic strikethrough backcolor numlist bullist', // Include only the allowed options
        plugins: 'lists', // Ensure the 'lists' plugin is enabled for numbering and bullets
        branding: false, // Remove "Powered by TinyMCE" branding
        content_style: "body { font-family: Arial, sans-serif; font-size: 14px; }" // Optional styling
    });

</script>

{{-- Form Validation Script Start==== --}}
<script>

    function SubmitForm() {

// Get form values
        const category = document.getElementById('category').value;
        const sub_category = document.getElementById('sub_category').value;
        const title = document.getElementById('title').value;
        const freelance_type = document.getElementById('freelance_type').value;
        const description = tinymce.get('description').getContent();
        const requirements = tinymce.get('requirements').getContent();
        const main_file = document.getElementById('post-thumbnail1').value;
        const type = document.getElementById('type').value;


        let valid = true; // A flag to track if the form is valid

        // Category validation
        if (!category) {
            toastr.options =
                {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "10000", // 10 seconds
                    "extendedTimeOut": "4410000" // 10 seconds
                }
            toastr.error("Select Category!");
            valid = false;
            return false;
        }

        // Sub Category validation
        if (!sub_category) {
            toastr.options =
                {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "10000", // 10 seconds
                    "extendedTimeOut": "4410000" // 10 seconds
                }
            toastr.error("Select Sub Category!");
            valid = false;
            return false;
        }

        // Title validation
        if (!title) {
            toastr.options =
                {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "10000", // 10 seconds
                    "extendedTimeOut": "4410000" // 10 seconds
                }
            toastr.error("Write Title!");
            valid = false;
            return false;
        }

        // Main File validation
        if (!main_file) {
            toastr.options =
                {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "10000", // 10 seconds
                    "extendedTimeOut": "4410000" // 10 seconds
                }
            toastr.error("Main Image Or Video Required!");
            valid = false;
            return false;
        }


        // Description validation
        if (!description || description.length < 10) {
            toastr.options =
                {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "10000", // 10 seconds
                    "extendedTimeOut": "4410000" // 10 seconds
                }
            toastr.error("Write Description!");
            valid = false;
            return false;
        }

        // Description validation
        if (!requirements || requirements.length < 10) {
            toastr.options =
                {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "10000", // 10 seconds
                    "extendedTimeOut": "4410000" // 10 seconds
                }
            toastr.error("Write Requirements!");
            valid = false;
            return false;
        }


        if (freelance_type == 'Both') {

            const description_2 = tinymce.get('description_2').getContent();
            const requirements_2 = tinymce.get('requirements_2').getContent();

            // Description validation
            if (!description_2 || description_2.length < 10) {
                toastr.options =
                    {
                        "closeButton": true,
                        "progressBar": true,
                        "timeOut": "10000", // 10 seconds
                        "extendedTimeOut": "4410000" // 10 seconds
                    }
                toastr.error("Write Description Basic!");
                valid = false;
                return false;
            }

            // Description validation
            if (!requirements_2 || requirements_2.length < 10) {
                toastr.options =
                    {
                        "closeButton": true,
                        "progressBar": true,
                        "timeOut": "10000", // 10 seconds
                        "extendedTimeOut": "4410000" // 10 seconds
                    }
                toastr.error("Write Requirements Basic!");
                valid = false;
                return false;
            }


        }


        if (type == 'Online') {
            const freelance_service = document.getElementById('freelance_service').value;
            if (freelance_service == 'Consultation') {
                const meeting_platform = document.getElementById('meeting_platform').value;
                if (!meeting_platform) {
                    toastr.options =
                        {
                            "closeButton": true,
                            "progressBar": true,
                            "timeOut": "10000", // 10 seconds
                            "extendedTimeOut": "4410000" // 10 seconds
                        }
                    toastr.error("Select Meeting Platform!");
                    valid = false;
                    return false;
                }
            }
        }

        if (type == 'Inperson') {

            const service_delivery = document.getElementById('service_delivery').value;
            if (service_delivery == 0) {
                const max_distance = document.getElementById('max_distance').value;
                if (!max_distance) {
                    toastr.options =
                        {
                            "closeButton": true,
                            "progressBar": true,
                            "timeOut": "10000", // 10 seconds
                            "extendedTimeOut": "4410000" // 10 seconds
                        }
                    toastr.error("Add Max Distance!");
                    valid = false;
                    return false;
                }
            } else if (service_delivery == 1) {
                const work_site = document.getElementById('work_site').value;
                if (!work_site) {
                    toastr.options =
                        {
                            "closeButton": true,
                            "progressBar": true,
                            "timeOut": "10000", // 10 seconds
                            "extendedTimeOut": "4410000" // 10 seconds
                        }
                    toastr.error("Add Work Site Location!");
                    valid = false;
                    return false;
                }
            } else {

                const max_distance = document.getElementById('max_distance').value;
                if (!max_distance) {
                    toastr.options =
                        {
                            "closeButton": true,
                            "progressBar": true,
                            "timeOut": "10000", // 10 seconds
                            "extendedTimeOut": "4410000" // 10 seconds
                        }
                    toastr.error("Add Max Distance!");
                    valid = false;
                    return false;
                }

                const work_site = document.getElementById('work_site').value;
                if (!work_site) {
                    toastr.options =
                        {
                            "closeButton": true,
                            "progressBar": true,
                            "timeOut": "10000", // 10 seconds
                            "extendedTimeOut": "4410000" // 10 seconds
                        }
                    toastr.error("Add Work Site Location!");
                    valid = false;
                    return false;
                }

            }

        }


        // If the form is not valid, prevent submission
        if (valid == true) {
            $('#myForm').submit();
        }

    }


</script>
{{-- Form Validation Script END==== --}}


@if ($type == 'Online')

    <script>

        $('#freelance_service').on('change', function () {

            var freelance_service = $('#freelance_service').val();

            if (freelance_service == 'Normal') {
                $('#video_call_main_div').css('display', 'none');
                $('#meeting_platform_main').css('display', 'none');
            } else {
                $('#video_call_main_div').css('display', 'block');
                $('#meeting_platform_main').css('display', 'block');
            }

        });


    </script>

@endif



@if ($type == 'Inperson')

    <script>


        $('#service_delivery').on('change', function () {
            var service_delivery = $('#service_delivery').val();

            if (service_delivery == 0) {
                $('#work_site_main').hide();
                $('#max_distance_main').show();

            } else if (service_delivery == 1) {

                $('#work_site_main').show();
                $('#max_distance_main').hide();

            } else {
                $('#work_site_main').show();
                $('#max_distance_main').show();

            }


        });


    </script>




    {{-- Google Script CDN --}}
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMA8qhhaBOYY1uv0nUfsBGcE74w6JNY7M&libraries=places"></script>

    {{-- Street Address Google Api Script Start --}}
    <script>
        $(document).ready(function () {
            var autocomplete;
            var id = 'work_site';
            var countryCode = '{{ Auth::user()->country_code }}';

            // Initialize Google Places Autocomplete with country restriction
            autocomplete = new google.maps.places.Autocomplete((document.getElementById(id)), {
                types: [],
                componentRestrictions: {country: countryCode},
            });

            // Event listener for when a place is selected
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
                var latitude = place.geometry.location.lat();
                var longitude = place.geometry.location.lng();
                // Handle selected place details
            });

            // Show "Near Me" button when input is focused
            $('#work_site').on('focus', function () {
                if ($(this).val().trim() === '') {
                    $('#nearme_dropdown').show();
                }
            });

            // Hide "Near Me" button when typing and input has value
            $('#work_site').on('input', function () {
                if ($(this).val().trim() === '') {
                    $('#nearme_dropdown').show(); // Show if input is cleared
                } else {
                    $('#nearme_dropdown').hide(); // Hide if typing something
                }
            });

            // Handle "Near Me" option click
            $('#nearme_option').on('click', function () {
                // Hide dropdown
                $('#nearme_dropdown').hide();

                // Get user’s live location
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function (position) {
                            var latitude = position.coords.latitude;
                            var longitude = position.coords.longitude;

                            // Optionally, populate input with live location or process it
                            console.log('Live Location:', latitude, longitude);

                            // Example: Reverse geocode to get address
                            var geocoder = new google.maps.Geocoder();
                            var latLng = new google.maps.LatLng(latitude, longitude);
                            geocoder.geocode({location: latLng}, function (results, status) {
                                console.log(status);

                                if (status === 'OK' && results[0]) {
                                    $('#work_site').val(results[0].formatted_address);
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
            });

            // Hide dropdown if clicked outside
            $(document).on('click', function (event) {
                if (!$(event.target).closest('#work_site_main').length) {
                    $('#nearme_dropdown').hide();
                }
            });
        });


    </script>
    {{-- Street Address Google Api Script END --}}

@endif







{{-- Images Upload Script== Start --}}
<script>


    // 1 ===
    new Vue({
        el: "#upload-image1",
        data() {
            return {
                preview: null,
                media: null,
                isImage: true,
                maxFileSize: 10 * 1024 * 1024, // 50 MB in bytes
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files && input.files[0]) {
                    let file = input.files[0];
                    let reader = new FileReader();

                    // Check the file size
                    if (file.size > this.maxFileSize) {
                        // If file exceeds 50 MB, show error and reset the input
                        document.getElementById(id).value = "";
                        this.preview = null;

                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true
                        };
                        toastr.error("File size exceeds the 50 MB limit!");
                        return; // Exit function if file size exceeds the limit
                    }

                    // Check if the file is an image or video
                    this.isImage = file.type.startsWith('image/');

                    reader.onload = (e) => {
                        // Display image or video preview
                        this.preview = e.target.result;
                    };

                    this.media = file;
                    reader.readAsDataURL(file);
                }
            },
            reset: function (id) {
                if (!confirm("Are You Sure, You Want to Remove?")) {
                    return false;
                }
                this.media = null;
                this.preview = null;
                this.isImage = true; // Reset type
                document.getElementById(id).value = "";
            },
        },
    });


    // 2 ===
    new Vue({
        el: "#upload-image2",
        data() {
            return {
                preview: null,
                media: null,
                isImage: true,
                maxFileSize: 10 * 1024 * 1024, // 50 MB in bytes
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files && input.files[0]) {
                    let file = input.files[0];
                    let reader = new FileReader();

                    // Check the file size
                    if (file.size > this.maxFileSize) {
                        // If file exceeds 50 MB, show error and reset the input
                        document.getElementById(id).value = "";
                        this.preview = null;

                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true
                        };
                        toastr.error("File size exceeds the 50 MB limit!");
                        return; // Exit function if file size exceeds the limit
                    }

                    // Check if the file is an image or video
                    this.isImage = file.type.startsWith('image/');

                    reader.onload = (e) => {
                        // Display image or video preview
                        this.preview = e.target.result;
                    };

                    this.media = file;
                    reader.readAsDataURL(file);
                }
            },
            reset: function (id) {
                if (!confirm("Are You Sure, You Want to Remove?")) {
                    return false;
                }
                this.media = null;
                this.preview = null;
                this.isImage = true; // Reset type
                document.getElementById(id).value = "";
            },
        },
    });


    // 3 =====
    new Vue({
        el: "#upload-image3",
        data() {
            return {
                images: [], // Array to hold selected images
                imageInputValue: "", // To store concatenated file names
                maxFileSize: 3 * 1024 * 1024, // 3 MB in bytes
                maxFiles: 5, // Maximum number of allowed files
            };
        },
        methods: {
            previewImages: function (id) {
                let input = document.getElementById(id);
                let selectedFiles = input.files;

                // Check if the total number of files exceeds the maximum allowed
                if (
                    selectedFiles.length > this.maxFiles ||
                    this.images.length + selectedFiles.length > this.maxFiles
                ) {
                    toastr.error(`You can only select up to ${this.maxFiles} images.`);
                    return;
                }

                for (let i = 0; i < selectedFiles.length; i++) {
                    let file = selectedFiles[i];

                    // Check if the file is an image
                    if (!file.type.startsWith("image")) {
                        toastr.error(`${file.name} is not an image!`);
                        continue;
                    }

                    // Check file size
                    if (file.size > this.maxFileSize) {
                        toastr.error(`${file.name} exceeds the 3 MB size limit!`);
                        continue;
                    }

                    let reader = new FileReader();
                    reader.onload = (e) => {
                        // Add the image to the images array
                        this.images.push({
                            src: e.target.result,
                            name: file.name,
                            type: "image",
                        });

                        // Update the hidden input value
                        this.updateImageInputValue();
                    };
                    reader.readAsDataURL(file);
                }
            },
            removeImage: function (index) {
                // Remove the image from the array
                this.images.splice(index, 1);

                // Update the hidden input value
                this.updateImageInputValue();
            },
            updateImageInputValue: function () {
                // Concatenate the file names with a `,_,` separator
                this.imageInputValue = this.images.map((image) => image.name).join(",_,");
            },
            reset: function (id) {
                // Reset the images and clear the file input
                this.images = [];
                this.imageInputValue = "";
                document.getElementById(id).value = "";
            },
        },
    });


</script>
{{-- Images Upload Script== END --}}

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

<script>
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
    });
</script>
<script>
    new DataTable('#example', {
        scrollX: true
    });
</script>

<script src="assets/teacher/libs/aos/js/aos.js "></script>
<script>
    AOS.init();
</script>
<script src=" assets/teacher/asset/js/bootstrap.min.js "></script>

</body>
<!--========== Underline tabes JS Start========== -->
<script>
    function feature(e, featureClassName) {
        var element = document.getElementsByClassName('tab-item');
        for (var i = 0; i < element.length; i++) {
            var shouldBeActive = element[i].classList.contains(featureClassName);
            element[i].classList.toggle('active', shouldBeActive);
        }
    }
</script>
<!--========== Underline tabes JS END =========== -->

<!--========== Slider-JS Start =========== -->
<script>
    jQuery(" #carousel ").owlCarousel({
        autoplay: true,
        rewind: true,
        /* use rewind if you don't want loop */
        margin: 20,
        /* animateOut: 'fadeOut' , animateIn: 'fadeIn' , */
        responsiveClass: true,
        autoHeight: true,
        autoplayTimeout: 7000,
        smartSpeed: 800,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1024: {
                items: 1
            },
            1366: {
                items: 1
            }
        }
    });
</script>
<!--========== Slider-JS End =========== -->

<!--  -->
<script src=" https://kit.fontawesome.com/6dba2ff605.js " crossorigin=" anonymous ">
</script>
<!-- upload file start js -->
<script>
    // Design By
    // - https://dribbble.com/shots/13992184-File-Uploader-Drag-Drop

    // Select Upload-Area
    const uploadArea = document.querySelector('#uploadArea')

    // Select Drop-Zoon Area
    const dropZoon = document.querySelector('#dropZoon');

    // Loading Text
    const loadingText = document.querySelector('#loadingText');

    // Slect File Input
    const fileInput = document.querySelector('#fileInput');

    // Select Preview Image
    const previewImage = document.querySelector('#previewImage');

    // File-Details Area
    const fileDetails = document.querySelector('#fileDetails');

    // Uploaded File
    const uploadedFile = document.querySelector('#uploadedFile');

    // Uploaded File Info
    const uploadedFileInfo = document.querySelector('#uploadedFileInfo');

    // Uploaded File  Name
    const uploadedFileName = document.querySelector('.uploaded-file__name');

    // Uploaded File Icon
    const uploadedFileIconText = document.querySelector('.uploaded-file__icon-text');

    // Uploaded File Counter
    const uploadedFileCounter = document.querySelector('.uploaded-file__counter');

    // ToolTip Data
    const toolTipData = document.querySelector('.upload-area__tooltip-data');

    // Images Types
    const imagesTypes = [
        "jpeg",
        "png",
        "svg",
        "gif"
    ];

    // Append Images Types Array Inisde Tooltip Data
    toolTipData.innerHTML = [...imagesTypes].join(', .');

    // When (drop-zoon) has (dragover) Event
    dropZoon.addEventListener('dragover', function (event) {
        // Prevent Default Behavior
        event.preventDefault();

        // Add Class (drop-zoon--over) On (drop-zoon)
        dropZoon.classList.add('drop-zoon--over');
    });

    // When (drop-zoon) has (dragleave) Event
    dropZoon.addEventListener('dragleave', function (event) {
        // Remove Class (drop-zoon--over) from (drop-zoon)
        dropZoon.classList.remove('drop-zoon--over');
    });

    // When (drop-zoon) has (drop) Event
    dropZoon.addEventListener('drop', function (event) {
        // Prevent Default Behavior
        event.preventDefault();

        // Remove Class (drop-zoon--over) from (drop-zoon)
        dropZoon.classList.remove('drop-zoon--over');

        // Select The Dropped File
        const file = event.dataTransfer.files[0];

        // Call Function uploadFile(), And Send To Her The Dropped File :)
        uploadFile(file);
    });

    // When (drop-zoon) has (click) Event
    dropZoon.addEventListener('click', function (event) {
        // Click The (fileInput)
        fileInput.click();
    });

    // When (fileInput) has (change) Event
    fileInput.addEventListener('change', function (event) {
        // Select The Chosen File
        const file = event.target.files[0];

        // Call Function uploadFile(), And Send To Her The Chosen File :)
        uploadFile(file);
    });

    // Upload File Function
    function uploadFile(file) {
        // FileReader()
        const fileReader = new FileReader();
        // File Type
        const fileType = file.type;
        // File Size
        const fileSize = file.size;

        // If File Is Passed from the (File Validation) Function
        if (fileValidate(fileType, fileSize)) {
            // Add Class (drop-zoon--Uploaded) on (drop-zoon)
            dropZoon.classList.add('drop-zoon--Uploaded');

            // Show Loading-text
            loadingText.style.display = "block";
            // Hide Preview Image
            previewImage.style.display = 'none';

            // Remove Class (uploaded-file--open) From (uploadedFile)
            uploadedFile.classList.remove('uploaded-file--open');
            // Remove Class (uploaded-file__info--active) from (uploadedFileInfo)
            uploadedFileInfo.classList.remove('uploaded-file__info--active');

            // After File Reader Loaded
            fileReader.addEventListener('load', function () {
                // After Half Second
                setTimeout(function () {
                    // Add Class (upload-area--open) On (uploadArea)
                    uploadArea.classList.add('upload-area--open');

                    // Hide Loading-text (please-wait) Element
                    loadingText.style.display = "none";
                    // Show Preview Image
                    previewImage.style.display = 'block';

                    // Add Class (file-details--open) On (fileDetails)
                    fileDetails.classList.add('file-details--open');
                    // Add Class (uploaded-file--open) On (uploadedFile)
                    uploadedFile.classList.add('uploaded-file--open');
                    // Add Class (uploaded-file__info--active) On (uploadedFileInfo)
                    uploadedFileInfo.classList.add('uploaded-file__info--active');
                }, 500); // 0.5s

                // Add The (fileReader) Result Inside (previewImage) Source
                previewImage.setAttribute('src', fileReader.result);

                // Add File Name Inside Uploaded File Name
                uploadedFileName.innerHTML = file.name;

                // Call Function progressMove();
                progressMove();
            });

            // Read (file) As Data Url
            fileReader.readAsDataURL(file);
        } else { // Else

            this; // (this) Represent The fileValidate(fileType, fileSize) Function

        }
        ;
    };

    // Progress Counter Increase Function
    function progressMove() {
        // Counter Start
        let counter = 0;

        // After 600ms
        setTimeout(() => {
            // Every 100ms
            let counterIncrease = setInterval(() => {
                // If (counter) is equle 100
                if (counter === 100) {
                    // Stop (Counter Increase)
                    clearInterval(counterIncrease);
                } else { // Else
                    // plus 10 on counter
                    counter = counter + 10;
                    // add (counter) vlaue inisde (uploadedFileCounter)
                    uploadedFileCounter.innerHTML = `${counter}%`
                }
            }, 100);
        }, 600);
    };


    // Simple File Validate Function
    function fileValidate(fileType, fileSize) {
        // File Type Validation
        let isImage = imagesTypes.filter((type) => fileType.indexOf(`image/${type}`) !== -1);

        // If The Uploaded File Type Is 'jpeg'
        if (isImage[0] === 'jpeg') {
            // Add Inisde (uploadedFileIconText) The (jpg) Value
            uploadedFileIconText.innerHTML = 'jpg';
        } else { // else
            // Add Inisde (uploadedFileIconText) The Uploaded File Type
            uploadedFileIconText.innerHTML = isImage[0];
        }
        ;

        // If The Uploaded File Is An Image
        if (isImage.length !== 0) {
            // Check, If File Size Is 2MB or Less
            if (fileSize <= 2000000) { // 2MB :)
                return true;
            } else { // Else File Size
                return alert('Please Your File Should be 2 Megabytes or Less');
            }
            ;
        } else { // Else File Type
            return alert('Please make sure to upload An Image File Type');
        }
        ;
    };

    // :)
</script>
<!-- upload file end js -->

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
        document.getElementById('additionalOptions2').style.display = 'block';
    }

    function showAdditionalOptions3() {
        hideAllAdditionalOptions();
    }

    function showAdditionalOptions4() {
        hideAllAdditionalOptions();
        document.getElementById('additionalOptions4').style.display = 'block';
    }

    function hideAllAdditionalOptions() {
        var elements = document.getElementsByClassName('additional-options');
        for (var i = 0; i < elements.length; i++) {
            elements[i].style.display = 'none';
        }
    }

    // Call the function to show the additional options for the default checked radio button on page load
    window.onload = function () {
        showAdditionalOptions1();
    };


</script>
