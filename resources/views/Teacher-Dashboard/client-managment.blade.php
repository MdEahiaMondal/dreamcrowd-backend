<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <!-- View Point scale to 1.0 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Animate css -->
    <link rel="stylesheet" href="assets/user/libs/animate/css/animate.css"/>
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="assets/user/libs/aos/css/aos.css"/>
    <!-- Datatable css  -->
    <link rel="stylesheet" href="assets/user/libs/datatable/css/datatable.css"/>
    {{-- Fav Icon --}}
    @php  $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
    @endif
    <!-- Select2 css -->
    <link href="assets/user/libs/select2/css/select2.min.css" rel="stylesheet"/>
    <!-- Owl carousel css -->
    <link href="assets/user/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet"/>
    <link href="assets/user/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet"/>
    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="assets/user/asset/css/bootstrap.min.css"/>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0"/>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>

    {{-- =======Toastr CDN ======== --}}
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- =======Toastr CDN ======== --}}
    <!-- Popper.js (required for Bootstrap 4 and above) -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.2/js/bootstrap.min.js"></script>

    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/user/asset/css/sidebar.css"/>
    <link rel="stylesheet" href="assets/user/asset/css/style.css">
    <link rel="stylesheet" href="assets/user/asset/css/classmanagement.css">
    <title>User Dashboard | Class Management</title>
</head>
<body>


<style>
    .active_btn_css {
        border-radius: 4px;
        background: #0072b1;
        padding: 8px 43px;
        color: #fff;
        font-family: Roboto;
        font-size: 16px;
        font-weight: 400;
        line-height: normal;
    }

    .active_btn_css:hover {
        border-radius: 4px;
        background: #0072b1;
        padding: 8px 43px;
        color: #fff;
        font-family: Roboto;
        font-size: 16px;
        font-weight: 400;
        line-height: normal;
    }

    .class-management-section li {
        padding: 0px;
    }
</style>


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


{{-- ===========User Sidebar Start==================== --}}
<x-teacher-sidebar/>
{{-- ===========User Sidebar End==================== --}}
<section class="home-section">
    {{-- ===========User NavBar Start==================== --}}
    <x-teacher-nav/>
    {{-- ===========User NavBar End==================== --}}
    <!-- =============================== MAIN CONTENT START HERE =========================== -->
    <div class="container-fluid">s
        <div class="row">
            <div class="col-md-12 class-management-section">
                <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#"> Client Management</a></li>
                        {{-- <li class="breadcrumb-item active" aria-current="page">
                          Pending Orders
                        </li> --}}
                    </ol>
                </nav>
                <div class="col-md-12 class-management">
                    <i class='bx bxs-graduation icon' title="Class Management"></i>
                    <h5>Client Management</h5>
                </div>

                <nav>
                    <ul class="tabs">

                        <li class="tab-li icon-badges">
                            <a href="#tab1" class="tab-li__link">Buyer Request<span
                                    class="icon-button__badge">{{$pendingOrders->count()}}</span></a>
                        </li>

                        <li class="tab-li icon-badges">
                            <a href="#tab7" class="tab-li__link">Priority Orders<span
                                    class="icon-button__badge">{{$priorityOrders->count()}}</span></a>
                        </li>
                        <li class="tab-li icon-badges">
                            <a href="#tab2" class="tab-li__link">Active Orders<span
                                    class="icon-button__badge">{{$activeOrders->count()}}</span></a>
                        </li>

                        <li class="tab-li badges-sec">
                            <a href="#tab3" class="tab-li__link">Delivered Orders<span
                                    class="icon-button__badge">{{$deliveredOrders->count()}}</span></a>
                        </li>

                        <li class="tab-li badges-sec">
                            <a href="#tab4" class="tab-li__link">Completed Orders<span
                                    class="icon-button__badge">{{$completedOrders->count()}}</span></a>
                        </li>
                        <li class="tab-li badges-sec">
                            <a href="#tab5" class="tab-li__link">Cancelled Orders<span
                                    class="icon-button__badge">{{$cancelledOrders->count()}}</span></a>
                        </li>

                        <li class="tab-li">
                            <a href="#tab6" class="tab-li__link">Experts</a>
                        </li>
                    </ul>
                </nav>
                <div id="tab1" data-tab-content>
                    <section>
                        <div class="tab__content">
                            <div class="row">
                                <div class="col-md-11">
                                    <div class="search">
                                        <span class="fa fa-search"></span>
                                        <input placeholder="Search service title, experts etc....">
                                    </div>
                                </div>
                                <div class="col-md-1 filter-sec">
                                    <div class="dropdown">
                                        <button class="btn filter-btn" type="button" id="dropdownMenuButton1"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                  <span class="material-symbols-rounded">
                                    tune
                                    </span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <h5 class="mt-0">Servise Type</h5></li>
                                            <a class="dropdown-item" href="#">
                                                <li>Class</li>
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <li>Freelance</li>
                                            </a>
                                            <h5>Sorting</h5>
                                            <a class="dropdown-item" href="#">
                                                <li>A-Z</li>
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <li>Z-A</li>
                                            </a>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="">
                        <div class="class-management-sec">
                            <div class="row">
                                <div class="col-sm-12 ">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <th>Buyer</th>
                                            <th class="service-title">Service Title</th>
                                            <th>Service Type</th>
                                            <th>Start Date</th>
                                            <th>Due Date</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th class="act">Action</th>
                                            </thead>


                                            <tbody>

                                            @if ($pendingOrders)

                                                @foreach ($pendingOrders as $order)

                                                    <tr>
                                                        <td>
                                                            <div class="profile-sec">
                                                                @if ($order->profile == null)
                                                                    @php  $firstLetter = strtoupper(substr($order->first_name, 0, 1));  @endphp
                                                                    <img
                                                                        src="assets/profile/avatars/({{$firstLetter}}).jpg"
                                                                        class="card-img-top-profile">
                                                                @else

                                                                    <img src="assets/profile/img/{{$order->profile}}"
                                                                         class="card-img-top-profile">
                                                                @endif

                                                                <p>{{ $order->first_name }}  {{strtoupper(substr($order->last_name, 0, 1))}}
                                                                    . </p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-title">
                                                                <p type="button"
                                                                   id="show_detail_model_{{$order->order_id}}"
                                                                   onclick="ShowDetailsModel(this.id)"
                                                                   data-values="{{ json_encode($order) }}"
                                                                   class="btn seller-desc" data-bs-toggle="modal"
                                                                   data-bs-target="#sell-service-modal"
                                                                   data-name="{{ $order->first_name }} {{$order->last_name}}"
                                                                   data-title="{{$order->title}}"
                                                                   data-user_id="{{$order->id}}"
                                                                   data-order_id="{{$order->order_id}}"
                                                                   data-teacher_reschedule="{{$order->teacher_reschedule}}"
                                                                   data-status="{{$order->status}}"
                                                                   data-service_role="{{$order->service_role}}"
                                                                   data-start_date="{{$order->start_date}}"
                                                                   data-end_date="{{$order->end_date}}"
                                                                   data-price="{{$order->finel_price}}"
                                                                   data-new_all_classes="{{ json_encode($order->new_all_classes) }}"
                                                                   data-all_classes="{{$order->all_classes}}"
                                                                   data-payment_type="{{$order->payment_type}}"
                                                                   data-freelance_service="{{$order->freelance_service}}"
                                                                   data-lesson_type="{{$order->lesson_type}}"
                                                                   data-service_type="{{$order->service_type}}"
                                                                   data-description="{{$order->description}}">{{$order->title}}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-badges">
                                                                <h3 class="mb-0"><span
                                                                        class="badge service-class-badge">{{ $order->service_type }} {{ $order->service_role }}</span>
                                                                </h3>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-date">
                                                                @if ($order->new_start_date != null)
                                                                    <p style="text-decoration: line-through;">{{ \Carbon\Carbon::parse($order->start_date)->format('F d, Y') }}</p>
                                                                    <p style="color: #0072b1;">{{ \Carbon\Carbon::parse($order->new_start_date)->format('F d, Y') }}</p>
                                                                @elseif($order->payment_type == 'Subscription')
                                                                    <p>{{ \Carbon\Carbon::parse($order->created_at)->format('F d, Y') }}</p>
                                                                @else
                                                                    <p>{{ \Carbon\Carbon::parse($order->start_date)->format('F d, Y') }}</p>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-date">
                                                                @if ($order->new_end_date != null)
                                                                    <p style="text-decoration: line-through;">{{ \Carbon\Carbon::parse($order->end_date)->format('F d, Y') }}</p>
                                                                    <p style="color: #0072b1;">{{ \Carbon\Carbon::parse($order->new_end_date)->format('F d, Y') }}</p>
                                                                @elseif($order->payment_type == 'Subscription')
                                                                    <p>{{ \Carbon\Carbon::parse($order->created_at)->addMonth()->format('F d, Y') }}</p>
                                                                @else
                                                                    <p>{{ \Carbon\Carbon::parse($order->end_date)->format('F d, Y') }}</p>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-date">
                                                                <p>${{ $order->finel_price }}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-badges">
                                                                <h3 class="mb-0"><span class="badge service-badge">
                                                  @if ($order->user_reschedule == 1)
                                                                            Resheduled
                                                                        @else
                                                                            Pending
                                                                        @endif
                                                  </span></h3>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="action-sec">
                                                                <button class="btn action-btn"
                                                                        onclick="ActionModelShow(this.id)"
                                                                        data-values="{{ json_encode($order) }}"
                                                                        data-name="{{ $order->first_name }} {{$order->last_name}}"
                                                                        data-title="{{$order->title}}"
                                                                        data-user_id="{{$order->id}}"
                                                                        data-order_id="{{$order->order_id}}"
                                                                        data-reschedule="{{$order->user_reschedule}}"
                                                                        data-freelance_service="{{$order->freelance_service}}"
                                                                        data-status="{{$order->status}}"
                                                                        data-service_role="{{$order->service_role}}"
                                                                        data-start_date="{{$order->start_date}}"
                                                                        data-end_date="{{$order->end_date}}"
                                                                        data-price="{{$order->finel_price}}"
                                                                        data-new_all_classes="{{ json_encode($order->new_all_classes) }}"
                                                                        data-all_classes="{{$order->all_classes}}"
                                                                        data-payment_type="{{$order->payment_type}}"
                                                                        data-freelance_service="{{$order->freelance_service}}"
                                                                        data-lesson_type="{{$order->lesson_type}}"
                                                                        data-service_type="{{$order->service_type}}"
                                                                        data-teacher_reschedule="{{$order->teacher_reschedule}}"
                                                                        data-description="{{$order->description}}"
                                                                        id="class-reshedule_{{$order->order_id}}">...
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                @endforeach

                                            @endif


                                            </tbody>

                                            {{-- <tr>
                                          <td>
                                            <div class="profile-sec">
                                                <img src="assets/user/asset/img/profile.png" alt="">
                                                <p>Usama A.<br><span>UI Designer</span></p>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="service-title">
                                                <p type="button" class="btn seller-desc" data-bs-toggle="modal" data-bs-target="#sell-service-modal">Learn How to design attractive UI for clients....</p>
                                            </div>
                                          </td>
                                          <td>
                                              <div class="service-badges">
                                                  <h3 class="mb-0"><span class="badge service-badge">Online Freelance</h3>
                                              </div>
                                          </td>
                                          <td>
                                            <div class="service-date">
                                                <p>June 15, 2023</p>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="service-date">
                                                <p>June 15, 2023</p>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="service-date">
                                                <p>$58</p>
                                            </div>
                                          </td>
                                           <td>
                                            <div class="service-badges">
                                                <h3 class="mb-0"><span class="badge service-badge">Priority</span></h3>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="action-sec">
                                              <button class="btn action-btn" data-bs-toggle="modal" data-bs-target="#freelance-extend-modal" href="#">...</button>
                                            </div>
                                          </td>
                                        </tr> --}}

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </p>

                        <!-- CARD SECTION END HERE -->
                        <div class="demo">

                            @if ($pendingOrders->hasPages())
                                <nav class="pagination-outer" aria-label="Page navigation">
                                    <ul class="pagination">
                                        {{-- Previous Page Link --}}
                                        @if ($pendingOrders->onFirstPage())
                                            <li class="page-item disabled" aria-disabled="true"
                                                aria-label="@lang('pagination.previous')">
                                                <span class="page-link" aria-hidden="true">«</span>

                                            </li>

                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $pendingOrders->previousPageUrl() }}"
                                                   rel="prev" aria-label="@lang('pagination.previous')">
                                                    <span aria-hidden="true">«</span>
                                                </a>
                                            </li>

                                        @endif

                                        {{-- Pagination Elements --}}
                                        @php
                                            $start = max($pendingOrders->currentPage() - 2, 1);
                                $end = min($pendingOrders->currentPage() + 2, $pendingOrders->lastPage());
                                        @endphp

                                        @for ($i = $start; $i <= $end; $i++)
                                            @if ($i == $pendingOrders->currentPage())
                                                <li class="page-item active" aria-current="page"><a
                                                        class="page-link">{{ $i }}</a></li>
                                            @else
                                                <li class="page-item "><a class="page-link"
                                                                          href="{{ $pendingOrders->url($i) }}">{{ $i }}</a>
                                                </li>
                                            @endif
                                        @endfor

                                        {{-- Next Page Link --}}
                                        @if ($pendingOrders->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $pendingOrders->nextPageUrl() }}"
                                                   rel="next" aria-label="@lang('pagination.next')">
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

                    </section>
                </div>
                <div id="tab7" data-tab-content>
                    <section>
                        <div class="tab__content">
                            <div class="row">
                                <div class="col-md-11">
                                    <div class="search">
                                        <span class="fa fa-search"></span>
                                        <input placeholder="Search service title, experts etc....">
                                    </div>
                                </div>
                                <div class="col-md-1 filter-sec">
                                    <div class="dropdown">
                                        <button class="btn filter-btn" type="button" id="dropdownMenuButton1"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-rounded">
                                      tune
                                      </span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <h5>Servise Type</h5></li>
                                            <a class="dropdown-item" href="#">
                                                <li>Class</li>
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <li>Freelance</li>
                                            </a>
                                            <h5>Sorting</h5>
                                            <a class="dropdown-item" href="#">
                                                <li>A-Z</li>
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <li>Z-A</li>
                                            </a>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="">
                        <div class="class-management-sec">
                            <div class="row">
                                <div class="col-sm-12 ">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <th>Buyer</th>
                                            <th class="service-title">Service Title</th>
                                            <th>Service Type</th>
                                            <th>Start Date</th>
                                            <th>Due Date</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th class="act">Action</th>
                                            </thead>

                                            <tbody>

                                            @if ($priorityOrders)
                                                @foreach ($priorityOrders as $order)

                                                    <tr>
                                                        <td>
                                                            <div class="profile-sec">
                                                                @if ($order->profile == null)
                                                                    @php  $firstLetter = strtoupper(substr($order->first_name, 0, 1));  @endphp
                                                                    <img
                                                                        src="assets/profile/avatars/({{$firstLetter}}).jpg"
                                                                        class="card-img-top-profile">
                                                                @else

                                                                    <img src="assets/profile/img/{{$order->profile}}"
                                                                         class="card-img-top-profile">
                                                                @endif

                                                                <p>{{ $order->first_name }}  {{strtoupper(substr($order->last_name, 0, 1))}}
                                                                    . </p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-title">
                                                                <p type="button"
                                                                   id="show_detail_model_{{$order->order_id}}"
                                                                   onclick="ShowDetailsModel(this.id)"
                                                                   data-values="{{ json_encode($order) }}"
                                                                   class="btn seller-desc" data-bs-toggle="modal"
                                                                   data-bs-target="#sell-service-modal"
                                                                   data-name="{{ $order->first_name }} {{$order->last_name}}"
                                                                   data-title="{{$order->title}}"
                                                                   data-order_id="{{$order->order_id}}"
                                                                   data-teacher_reschedule="{{$order->teacher_reschedule}}"
                                                                   data-status="{{$order->status}}"
                                                                   data-service_role="{{$order->service_role}}"
                                                                   data-start_date="{{$order->start_date}}"
                                                                   data-end_date="{{$order->end_date}}"
                                                                   data-price="{{$order->finel_price}}"
                                                                   data-new_all_classes="{{ json_encode($order->new_all_classes) }}"
                                                                   data-all_classes="{{$order->all_classes}}"
                                                                   data-payment_type="{{$order->payment_type}}"
                                                                   data-freelance_service="{{$order->freelance_service}}"
                                                                   data-lesson_type="{{$order->lesson_type}}"
                                                                   data-service_type="{{$order->service_type}}"
                                                                   data-description="{{$order->description}}">{{$order->title}}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-badges">
                                                                <h3 class="mb-0"><span
                                                                        class="badge service-class-badge">{{ $order->service_type }} {{ $order->service_role }}</span>
                                                                </h3>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-date">
                                                                @if ($order->new_start_date != null)
                                                                    <p style="text-decoration: line-through;">{{ \Carbon\Carbon::parse($order->start_date)->format('F d, Y') }}</p>
                                                                    <p style="color: #0072b1;">{{ \Carbon\Carbon::parse($order->new_start_date)->format('F d, Y') }}</p>
                                                                @elseif($order->payment_type == 'Subscription')
                                                                    <p>{{ \Carbon\Carbon::parse($order->created_at)->format('F d, Y') }}</p>
                                                                @else
                                                                    <p>{{ \Carbon\Carbon::parse($order->start_date)->format('F d, Y') }}</p>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-date">
                                                                @if ($order->new_end_date != null)
                                                                    <p style="text-decoration: line-through;">{{ \Carbon\Carbon::parse($order->end_date)->format('F d, Y') }}</p>
                                                                    <p style="color: #0072b1;">{{ \Carbon\Carbon::parse($order->new_end_date)->format('F d, Y') }}</p>
                                                                @elseif($order->payment_type == 'Subscription')
                                                                    <p>{{ \Carbon\Carbon::parse($order->created_at)->addMonth()->format('F d, Y') }}</p>
                                                                @else
                                                                    <p>{{ \Carbon\Carbon::parse($order->end_date)->format('F d, Y') }}</p>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-date">
                                                                <p>${{ $order->finel_price }}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-badges">
                                                                <h3 class="mb-0"><span class="badge service-badge">
                                                      @if ($order->user_reschedule == 1)
                                                                            Resheduled
                                                                        @else
                                                                            Active
                                                                        @endif
                                                </span></h3>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="action-sec">
                                                                <button class="btn action-btn"
                                                                        onclick="ActionModelShow(this.id)"
                                                                        data-values="{{ json_encode($order) }}"
                                                                        data-name="{{ $order->first_name }} {{$order->last_name}}"
                                                                        data-title="{{$order->title}}"
                                                                        data-user_id="{{$order->id}}"
                                                                        data-order_id="{{$order->order_id}}"
                                                                        data-current_class="{{ json_encode($order->current_class) }}"
                                                                        data-reschedule="{{$order->user_reschedule}}"
                                                                        data-freelance_service="{{$order->freelance_service}}"
                                                                        data-status="{{$order->status}}"
                                                                        data-service_role="{{$order->service_role}}"
                                                                        data-start_date="{{$order->start_date}}"
                                                                        data-end_date="{{$order->end_date}}"
                                                                        data-price="{{$order->finel_price}}"
                                                                        data-past_classes="{{ json_encode($order->past_classes) }}"
                                                                        data-new_all_classes="{{ json_encode($order->new_all_classes) }}"
                                                                        data-all_classes="{{$order->all_classes}}"
                                                                        data-payment_type="{{$order->payment_type}}"
                                                                        data-freelance_service="{{$order->freelance_service}}"
                                                                        data-lesson_type="{{$order->lesson_type}}"
                                                                        data-service_type="{{$order->service_type}}"
                                                                        data-teacher_reschedule="{{$order->teacher_reschedule}}"
                                                                        data-description="{{$order->description}}"
                                                                        id="class-reshedule_{{$order->order_id}}">...
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                @endforeach

                                            @endif


                                            </tbody>

                                            {{-- <tr>
                                          <td>
                                            <div class="profile-sec">
                                                <img src="assets/user/asset/img/profile.png" alt="">
                                                <p>Usama A.<br><span>UI Designer</span></p>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="service-title">
                                                <p type="button" class="btn seller-desc" data-bs-toggle="modal" data-bs-target="#sell-service-modal">Learn How to design attractive UI for clients....</p>
                                            </div>
                                          </td>
                                          <td>
                                              <div class="service-badges">
                                                  <h3 class="mb-0"><span class="badge service-badge">Online Freelance</h3>
                                              </div>
                                          </td>
                                          <td>
                                            <div class="service-date">
                                                <p>June 15, 2023</p>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="service-date">
                                                <p>June 15, 2023</p>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="service-date">
                                                <p>$58</p>
                                            </div>
                                          </td>
                                           <td>
                                            <div class="service-badges">
                                                <h3 class="mb-0"><span class="badge service-badge">Priority</span></h3>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="action-sec">
                                              <button class="btn action-btn" data-bs-toggle="modal" data-bs-target="#freelance-extend-modal" href="#">...</button>
                                            </div>
                                          </td>
                                        </tr> --}}

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </p>

                        <!-- CARD SECTION END HERE -->
                        <div class="demo">

                            @if ($activeOrders->hasPages())
                                <nav class="pagination-outer" aria-label="Page navigation">
                                    <ul class="pagination">
                                        {{-- Previous Page Link --}}
                                        @if ($activeOrders->onFirstPage())
                                            <li class="page-item disabled" aria-disabled="true"
                                                aria-label="@lang('pagination.previous')">
                                                <span class="page-link" aria-hidden="true">«</span>

                                            </li>

                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $activeOrders->previousPageUrl() }}"
                                                   rel="prev" aria-label="@lang('pagination.previous')">
                                                    <span aria-hidden="true">«</span>
                                                </a>
                                            </li>

                                        @endif

                                        {{-- Pagination Elements --}}
                                        @php
                                            $start = max($activeOrders->currentPage() - 2, 1);
                $end = min($activeOrders->currentPage() + 2, $activeOrders->lastPage());
                                        @endphp

                                        @for ($i = $start; $i <= $end; $i++)
                                            @if ($i == $activeOrders->currentPage())
                                                <li class="page-item active" aria-current="page"><a
                                                        class="page-link">{{ $i }}</a></li>
                                            @else
                                                <li class="page-item "><a class="page-link"
                                                                          href="{{ $activeOrders->url($i) }}">{{ $i }}</a>
                                                </li>
                                            @endif
                                        @endfor

                                        {{-- Next Page Link --}}
                                        @if ($activeOrders->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $activeOrders->nextPageUrl() }}"
                                                   rel="next" aria-label="@lang('pagination.next')">
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
                    </section>
                </div>
                <div id="tab2" data-tab-content>
                    <section>
                        <div class="tab__content">
                            <div class="row">
                                <div class="col-md-11">
                                    <div class="search">
                                        <span class="fa fa-search"></span>
                                        <input placeholder="Search service title, experts etc....">
                                    </div>
                                </div>
                                <div class="col-md-1 filter-sec">
                                    <div class="dropdown">
                                        <button class="btn filter-btn" type="button" id="dropdownMenuButton1"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-rounded">
                                      tune
                                      </span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <h5>Servise Type</h5></li>
                                            <a class="dropdown-item" href="#">
                                                <li>Class</li>
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <li>Freelance</li>
                                            </a>
                                            <h5>Sorting</h5>
                                            <a class="dropdown-item" href="#">
                                                <li>A-Z</li>
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <li>Z-A</li>
                                            </a>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="">
                        <div class="class-management-sec">
                            <div class="row">
                                <div class="col-sm-12 ">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <th>Buyer</th>
                                            <th class="service-title">Service Title</th>
                                            <th>Service Type</th>
                                            <th>Start Date</th>
                                            <th>Due Date</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th class="act">Action</th>
                                            </thead>

                                            <tbody>

                                            @if ($activeOrders)
                                                @foreach ($activeOrders as $order)

                                                    <tr>
                                                        <td>
                                                            <div class="profile-sec">
                                                                @if ($order->profile == null)
                                                                    @php  $firstLetter = strtoupper(substr($order->first_name, 0, 1));  @endphp
                                                                    <img
                                                                        src="assets/profile/avatars/({{$firstLetter}}).jpg"
                                                                        class="card-img-top-profile">
                                                                @else

                                                                    <img src="assets/profile/img/{{$order->profile}}"
                                                                         class="card-img-top-profile">
                                                                @endif

                                                                <p>{{ $order->first_name }}  {{strtoupper(substr($order->last_name, 0, 1))}}
                                                                    . </p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-title">
                                                                <p type="button"
                                                                   id="show_detail_model_{{$order->order_id}}"
                                                                   onclick="ShowDetailsModel(this.id)"
                                                                   data-values="{{ json_encode($order) }}"
                                                                   class="btn seller-desc" data-bs-toggle="modal"
                                                                   data-bs-target="#sell-service-modal"
                                                                   data-name="{{ $order->first_name }} {{$order->last_name}}"
                                                                   data-title="{{$order->title}}"
                                                                   data-order_id="{{$order->order_id}}"
                                                                   data-teacher_reschedule="{{$order->teacher_reschedule}}"
                                                                   data-status="{{$order->status}}"
                                                                   data-service_role="{{$order->service_role}}"
                                                                   data-start_date="{{$order->start_date}}"
                                                                   data-end_date="{{$order->end_date}}"
                                                                   data-price="{{$order->finel_price}}"
                                                                   data-new_all_classes="{{ json_encode($order->new_all_classes) }}"
                                                                   data-all_classes="{{$order->all_classes}}"
                                                                   data-payment_type="{{$order->payment_type}}"
                                                                   data-freelance_service="{{$order->freelance_service}}"
                                                                   data-lesson_type="{{$order->lesson_type}}"
                                                                   data-service_type="{{$order->service_type}}"
                                                                   data-description="{{$order->description}}">{{$order->title}}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-badges">
                                                                <h3 class="mb-0"><span
                                                                        class="badge service-class-badge">{{ $order->service_type }} {{ $order->service_role }}</span>
                                                                </h3>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-date">
                                                                @if ($order->new_start_date != null)
                                                                    <p style="text-decoration: line-through;">{{ \Carbon\Carbon::parse($order->start_date)->format('F d, Y') }}</p>
                                                                    <p style="color: #0072b1;">{{ \Carbon\Carbon::parse($order->new_start_date)->format('F d, Y') }}</p>
                                                                @elseif($order->payment_type == 'Subscription')
                                                                    <p>{{ \Carbon\Carbon::parse($order->created_at)->format('F d, Y') }}</p>
                                                                @else
                                                                    <p>{{ \Carbon\Carbon::parse($order->start_date)->format('F d, Y') }}</p>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-date">
                                                                @if ($order->new_end_date != null)
                                                                    <p style="text-decoration: line-through;">{{ \Carbon\Carbon::parse($order->end_date)->format('F d, Y') }}</p>
                                                                    <p style="color: #0072b1;">{{ \Carbon\Carbon::parse($order->new_end_date)->format('F d, Y') }}</p>
                                                                @elseif($order->payment_type == 'Subscription')
                                                                    <p>{{ \Carbon\Carbon::parse($order->created_at)->addMonth()->format('F d, Y') }}</p>
                                                                @else
                                                                    <p>{{ \Carbon\Carbon::parse($order->end_date)->format('F d, Y') }}</p>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-date">
                                                                <p>${{ $order->finel_price }}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-badges">
                                                                <h3 class="mb-0"><span class="badge service-badge">
                                                        @if ($order->user_reschedule == 1)
                                                                            Resheduled
                                                                        @else
                                                                            Active
                                                                        @endif
                                                </span></h3>

                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="action-sec">
                                                                <button class="btn action-btn"
                                                                        onclick="ActionModelShow(this.id)"
                                                                        data-values="{{ json_encode($order) }}"
                                                                        data-name="{{ $order->first_name }} {{$order->last_name}}"
                                                                        data-title="{{$order->title}}"
                                                                        data-user_id="{{$order->id}}"
                                                                        data-order_id="{{$order->order_id}}"
                                                                        data-current_class="{{ json_encode($order->current_class) }}"
                                                                        data-reschedule="{{$order->user_reschedule}}"
                                                                        data-freelance_service="{{$order->freelance_service}}"
                                                                        data-status="{{$order->status}}"
                                                                        data-service_role="{{$order->service_role}}"
                                                                        data-start_date="{{$order->start_date}}"
                                                                        data-end_date="{{$order->end_date}}"
                                                                        data-price="{{$order->finel_price}}"
                                                                        data-past_classes="{{ json_encode($order->past_classes) }}"
                                                                        data-new_all_classes="{{ json_encode($order->new_all_classes) }}"
                                                                        data-all_classes="{{$order->all_classes}}"
                                                                        data-payment_type="{{$order->payment_type}}"
                                                                        data-freelance_service="{{$order->freelance_service}}"
                                                                        data-lesson_type="{{$order->lesson_type}}"
                                                                        data-service_type="{{$order->service_type}}"
                                                                        data-teacher_reschedule="{{$order->teacher_reschedule}}"
                                                                        data-description="{{$order->description}}"
                                                                        id="class-reshedule_{{$order->order_id}}">...
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                @endforeach

                                            @endif


                                            </tbody>

                                            {{-- <tr>
                                          <td>
                                            <div class="profile-sec">
                                                <img src="assets/user/asset/img/profile.png" alt="">
                                                <p>Usama A.<br><span>UI Designer</span></p>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="service-title">
                                                <p type="button" class="btn seller-desc" data-bs-toggle="modal" data-bs-target="#sell-service-modal">Learn How to design attractive UI for clients....</p>
                                            </div>
                                          </td>
                                          <td>
                                              <div class="service-badges">
                                                  <h3 class="mb-0"><span class="badge service-badge">Online Freelance</h3>
                                              </div>
                                          </td>
                                          <td>
                                            <div class="service-date">
                                                <p>June 15, 2023</p>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="service-date">
                                                <p>June 15, 2023</p>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="service-date">
                                                <p>$58</p>
                                            </div>
                                          </td>
                                           <td>
                                            <div class="service-badges">
                                                <h3 class="mb-0"><span class="badge service-badge">Priority</span></h3>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="action-sec">
                                              <button class="btn action-btn" data-bs-toggle="modal" data-bs-target="#freelance-extend-modal" href="#">...</button>
                                            </div>
                                          </td>
                                        </tr> --}}

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </p>

                        <!-- CARD SECTION END HERE -->
                        <div class="demo">

                            @if ($activeOrders->hasPages())
                                <nav class="pagination-outer" aria-label="Page navigation">
                                    <ul class="pagination">
                                        {{-- Previous Page Link --}}
                                        @if ($activeOrders->onFirstPage())
                                            <li class="page-item disabled" aria-disabled="true"
                                                aria-label="@lang('pagination.previous')">
                                                <span class="page-link" aria-hidden="true">«</span>

                                            </li>

                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $activeOrders->previousPageUrl() }}"
                                                   rel="prev" aria-label="@lang('pagination.previous')">
                                                    <span aria-hidden="true">«</span>
                                                </a>
                                            </li>

                                        @endif

                                        {{-- Pagination Elements --}}
                                        @php
                                            $start = max($activeOrders->currentPage() - 2, 1);
                $end = min($activeOrders->currentPage() + 2, $activeOrders->lastPage());
                                        @endphp

                                        @for ($i = $start; $i <= $end; $i++)
                                            @if ($i == $activeOrders->currentPage())
                                                <li class="page-item active" aria-current="page"><a
                                                        class="page-link">{{ $i }}</a></li>
                                            @else
                                                <li class="page-item "><a class="page-link"
                                                                          href="{{ $activeOrders->url($i) }}">{{ $i }}</a>
                                                </li>
                                            @endif
                                        @endfor

                                        {{-- Next Page Link --}}
                                        @if ($activeOrders->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $activeOrders->nextPageUrl() }}"
                                                   rel="next" aria-label="@lang('pagination.next')">
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
                    </section>
                </div>
                <div id="tab3" data-tab-content>
                    <section>
                        <div class="tab__content">
                            <div class="row">
                                <div class="col-md-11">
                                    <div class="search">
                                        <span class="fa fa-search"></span>
                                        <input placeholder="Search service title, experts etc....">
                                    </div>
                                </div>
                                <div class="col-md-1 filter-sec">
                                    <div class="dropdown">
                                        <button class="btn filter-btn" type="button" id="dropdownMenuButton1"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-rounded">
                                      tune
                                      </span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <h5>Servise Type</h5></li>
                                            <a class="dropdown-item" href="#">
                                                <li>Class</li>
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <li>Freelance</li>
                                            </a>
                                            <h5>Sorting</h5>
                                            <a class="dropdown-item" href="#">
                                                <li>A-Z</li>
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <li>Z-A</li>
                                            </a>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="">
                        <div class="class-management-sec">
                            <div class="row">
                                <div class="col-sm-12 ">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <th>Buyer</th>
                                            <th class="service-title">Service Title</th>
                                            <th>Service Type</th>
                                            <th>Start Date</th>
                                            <th>Delivered Date</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th class="act">Action</th>
                                            </thead>
                                            <tbody>

                                            @if ($deliveredOrders)
                                                @foreach ($deliveredOrders as $order)

                                                    <tr>
                                                        <td>
                                                            <div class="profile-sec">
                                                                @if ($order->profile == null)
                                                                    @php  $firstLetter = strtoupper(substr($order->first_name, 0, 1));  @endphp
                                                                    <img
                                                                        src="assets/profile/avatars/({{$firstLetter}}).jpg"
                                                                        class="card-img-top-profile">
                                                                @else

                                                                    <img src="assets/profile/img/{{$order->profile}}"
                                                                         class="card-img-top-profile">
                                                                @endif

                                                                <p>{{ $order->first_name }}  {{strtoupper(substr($order->last_name, 0, 1))}}
                                                                    . </p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-title">
                                                                <p type="button"
                                                                   id="show_detail_model_{{$order->order_id}}"
                                                                   onclick="ShowDetailsModel(this.id)"
                                                                   data-values="{{ json_encode($order) }}"
                                                                   class="btn seller-desc" data-bs-toggle="modal"
                                                                   data-bs-target="#sell-service-modal"
                                                                   data-name="{{ $order->first_name }} {{$order->last_name}}"
                                                                   data-title="{{$order->title}}"
                                                                   data-order_id="{{$order->order_id}}"
                                                                   data-teacher_reschedule="{{$order->teacher_reschedule}}"
                                                                   data-status="{{$order->status}}"
                                                                   data-service_role="{{$order->service_role}}"
                                                                   data-start_date="{{$order->start_date}}"
                                                                   data-end_date="{{$order->end_date}}"
                                                                   data-price="{{$order->finel_price}}"
                                                                   data-new_all_classes="{{ json_encode($order->new_all_classes) }}"
                                                                   data-all_classes="{{$order->all_classes}}"
                                                                   data-payment_type="{{$order->payment_type}}"
                                                                   data-freelance_service="{{$order->freelance_service}}"
                                                                   data-lesson_type="{{$order->lesson_type}}"
                                                                   data-service_type="{{$order->service_type}}"
                                                                   data-description="{{$order->description}}">{{$order->title}}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-badges">
                                                                <h3 class="mb-0"><span
                                                                        class="badge service-class-badge">{{ $order->service_type }} {{ $order->service_role }}</span>
                                                                </h3>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-date">
                                                                @if($order->payment_type == 'Subscription')
                                                                    <p>{{ \Carbon\Carbon::parse($order->created_at)->format('F d, Y') }}</p>
                                                                @else
                                                                    <p>{{ \Carbon\Carbon::parse($order->start_date)->format('F d, Y') }}</p>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-date">
                                                                <p>{{ $order->action_date }}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-date">
                                                                <p>${{ $order->finel_price }}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-badges">
                                                                <h3 class="mb-0"><span class="badge service-badge">Delivered</span>
                                                                </h3>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="action-sec">
                                                                <button class="btn action-btn"
                                                                        onclick="ActionModelShow(this.id)"
                                                                        data-values="{{ json_encode($order) }}"
                                                                        data-name="{{ $order->first_name }} {{$order->last_name}}"
                                                                        data-title="{{$order->title}}"
                                                                        data-user_id="{{$order->id}}"
                                                                        data-order_id="{{$order->order_id}}"
                                                                        data-reschedule="{{$order->user_reschedule}}"
                                                                        data-freelance_service="{{$order->freelance_service}}"
                                                                        data-status="{{$order->status}}"
                                                                        data-service_role="{{$order->service_role}}"
                                                                        data-start_date="{{$order->start_date}}"
                                                                        data-end_date="{{$order->end_date}}"
                                                                        data-price="{{$order->finel_price}}"
                                                                        data-new_all_classes="{{ json_encode($order->new_all_classes) }}"
                                                                        data-all_classes="{{$order->all_classes}}"
                                                                        data-payment_type="{{$order->payment_type}}"
                                                                        data-freelance_service="{{$order->freelance_service}}"
                                                                        data-lesson_type="{{$order->lesson_type}}"
                                                                        data-service_type="{{$order->service_type}}"
                                                                        data-teacher_reschedule="{{$order->teacher_reschedule}}"
                                                                        data-description="{{$order->description}}"
                                                                        id="class-reshedule_{{$order->order_id}}">...
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                @endforeach

                                            @endif


                                            </tbody>

                                            {{-- <tr>
                                          <td>
                                            <div class="profile-sec">
                                                <img src="assets/user/asset/img/profile.png" alt="">
                                                <p>Usama A.<br><span>UI Designer</span></p>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="service-title">
                                                <p type="button" class="btn seller-desc" data-bs-toggle="modal" data-bs-target="#sell-service-modal">Learn How to design attractive UI for clients....</p>
                                            </div>
                                          </td>
                                          <td>
                                              <div class="service-badges">
                                                  <h3 class="mb-0"><span class="badge service-badge">Online Freelance</h3>
                                              </div>
                                          </td>
                                          <td>
                                            <div class="service-date">
                                                <p>June 15, 2023</p>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="service-date">
                                                <p>June 15, 2023</p>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="service-date">
                                                <p>$58</p>
                                            </div>
                                          </td>
                                           <td>
                                            <div class="service-badges">
                                                <h3 class="mb-0"><span class="badge service-badge">Priority</span></h3>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="action-sec">
                                              <button class="btn action-btn" data-bs-toggle="modal" data-bs-target="#freelance-extend-modal" href="#">...</button>
                                            </div>
                                          </td>
                                        </tr> --}}

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </p>

                        <!-- CARD SECTION END HERE -->
                        <div class="demo">

                            @if ($deliveredOrders->hasPages())
                                <nav class="pagination-outer" aria-label="Page navigation">
                                    <ul class="pagination">
                                        {{-- Previous Page Link --}}
                                        @if ($deliveredOrders->onFirstPage())
                                            <li class="page-item disabled" aria-disabled="true"
                                                aria-label="@lang('pagination.previous')">
                                                <span class="page-link" aria-hidden="true">«</span>

                                            </li>

                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $deliveredOrders->previousPageUrl() }}"
                                                   rel="prev" aria-label="@lang('pagination.previous')">
                                                    <span aria-hidden="true">«</span>
                                                </a>
                                            </li>

                                        @endif

                                        {{-- Pagination Elements --}}
                                        @php
                                            $start = max($deliveredOrders->currentPage() - 2, 1);
                $end = min($deliveredOrders->currentPage() + 2, $deliveredOrders->lastPage());
                                        @endphp

                                        @for ($i = $start; $i <= $end; $i++)
                                            @if ($i == $deliveredOrders->currentPage())
                                                <li class="page-item active" aria-current="page"><a
                                                        class="page-link">{{ $i }}</a></li>
                                            @else
                                                <li class="page-item "><a class="page-link"
                                                                          href="{{ $deliveredOrders->url($i) }}">{{ $i }}</a>
                                                </li>
                                            @endif
                                        @endfor

                                        {{-- Next Page Link --}}
                                        @if ($deliveredOrders->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $deliveredOrders->nextPageUrl() }}"
                                                   rel="next" aria-label="@lang('pagination.next')">
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


                    </section>
                </div>
                <div id="tab4" data-tab-content>
                    <section>
                        <div class="tab__content">
                            <div class="row">
                                <div class="col-md-11">
                                    <div class="search">
                                        <span class="fa fa-search"></span>
                                        <input placeholder="Search service title, experts etc....">
                                    </div>
                                </div>
                                <div class="col-md-1 filter-sec">
                                    <div class="dropdown">
                                        <button class="btn filter-btn" type="button" id="dropdownMenuButton1"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-rounded">
                                      tune
                                      </span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <h5>Servise Type</h5></li>
                                            <a class="dropdown-item" href="#">
                                                <li>Class</li>
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <li>Freelance</li>
                                            </a>
                                            <h5>Sorting</h5>
                                            <a class="dropdown-item" href="#">
                                                <li>A-Z</li>
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <li>Z-A</li>
                                            </a>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="">
                        <div class="class-management-sec">
                            <div class="row">
                                <div class="col-sm-12 ">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <th>Buyer</th>
                                            <th class="service-title">Service Title</th>
                                            <th>Service Type</th>
                                            <th>Start Date</th>
                                            <th>Completion Date</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th class="act">Action</th>
                                            </thead>
                                            <tbody>

                                            @if ($completedOrders)
                                                @foreach ($completedOrders as $order)

                                                    <tr>
                                                        <td>
                                                            <div class="profile-sec">
                                                                @if ($order->profile == null)
                                                                    @php  $firstLetter = strtoupper(substr($order->first_name, 0, 1));  @endphp
                                                                    <img
                                                                        src="assets/profile/avatars/({{$firstLetter}}).jpg"
                                                                        class="card-img-top-profile">
                                                                @else

                                                                    <img src="assets/profile/img/{{$order->profile}}"
                                                                         class="card-img-top-profile">
                                                                @endif

                                                                <p>{{ $order->first_name }}  {{strtoupper(substr($order->last_name, 0, 1))}}
                                                                    . </p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-title">
                                                                <p type="button"
                                                                   id="show_detail_model_{{$order->order_id}}"
                                                                   onclick="ShowDetailsModel(this.id)"
                                                                   data-values="{{ json_encode($order) }}"
                                                                   class="btn seller-desc" data-bs-toggle="modal"
                                                                   data-bs-target="#sell-service-modal"
                                                                   data-name="{{ $order->first_name }} {{$order->last_name}}"
                                                                   data-title="{{$order->title}}"
                                                                   data-order_id="{{$order->order_id}}"
                                                                   data-teacher_reschedule="{{$order->teacher_reschedule}}"
                                                                   data-status="{{$order->status}}"
                                                                   data-service_role="{{$order->service_role}}"
                                                                   data-start_date="{{$order->start_date}}"
                                                                   data-end_date="{{$order->end_date}}"
                                                                   data-price="{{$order->finel_price}}"
                                                                   data-new_all_classes="{{ json_encode($order->new_all_classes) }}"
                                                                   data-all_classes="{{$order->all_classes}}"
                                                                   data-payment_type="{{$order->payment_type}}"
                                                                   data-freelance_service="{{$order->freelance_service}}"
                                                                   data-lesson_type="{{$order->lesson_type}}"
                                                                   data-service_type="{{$order->service_type}}"
                                                                   data-description="{{$order->description}}">{{$order->title}}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-badges">
                                                                <h3 class="mb-0"><span
                                                                        class="badge service-class-badge">{{ $order->service_type }} {{ $order->service_role }}</span>
                                                                </h3>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-date">
                                                                @if($order->payment_type == 'Subscription')
                                                                    <p>{{ \Carbon\Carbon::parse($order->created_at)->format('F d, Y') }}</p>
                                                                @else
                                                                    <p>{{ \Carbon\Carbon::parse($order->start_date)->format('F d, Y') }}</p>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-date">
                                                                <p>{{ $order->action_date }}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-date">
                                                                <p>${{ $order->finel_price }}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-badges">
                                                                <h3 class="mb-0"><span class="badge service-badge">Completed</span>
                                                                </h3>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="action-sec">
                                                                <button class="btn action-btn"
                                                                        onclick="ActionModelShow(this.id)"
                                                                        data-values="{{ json_encode($order) }}"
                                                                        data-name="{{ $order->first_name }} {{$order->last_name}}"
                                                                        data-title="{{$order->title}}"
                                                                        data-user_id="{{$order->id}}"
                                                                        data-order_id="{{$order->order_id}}"
                                                                        data-reschedule="{{$order->user_reschedule}}"
                                                                        data-freelance_service="{{$order->freelance_service}}"
                                                                        data-status="{{$order->status}}"
                                                                        data-service_role="{{$order->service_role}}"
                                                                        data-start_date="{{$order->start_date}}"
                                                                        data-end_date="{{$order->end_date}}"
                                                                        data-price="{{$order->finel_price}}"
                                                                        data-new_all_classes="{{ json_encode($order->new_all_classes) }}"
                                                                        data-all_classes="{{$order->all_classes}}"
                                                                        data-payment_type="{{$order->payment_type}}"
                                                                        data-freelance_service="{{$order->freelance_service}}"
                                                                        data-lesson_type="{{$order->lesson_type}}"
                                                                        data-service_type="{{$order->service_type}}"
                                                                        data-teacher_reschedule="{{$order->teacher_reschedule}}"
                                                                        data-description="{{$order->description}}"
                                                                        id="class-reshedule_{{$order->order_id}}">...
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                @endforeach

                                            @endif


                                            </tbody>

                                            {{-- <tr>
                                          <td>
                                            <div class="profile-sec">
                                                <img src="assets/user/asset/img/profile.png" alt="">
                                                <p>Usama A.<br><span>UI Designer</span></p>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="service-title">
                                                <p type="button" class="btn seller-desc" data-bs-toggle="modal" data-bs-target="#sell-service-modal">Learn How to design attractive UI for clients....</p>
                                            </div>
                                          </td>
                                          <td>
                                              <div class="service-badges">
                                                  <h3 class="mb-0"><span class="badge service-badge">Online Freelance</h3>
                                              </div>
                                          </td>
                                          <td>
                                            <div class="service-date">
                                                <p>June 15, 2023</p>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="service-date">
                                                <p>June 15, 2023</p>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="service-date">
                                                <p>$58</p>
                                            </div>
                                          </td>
                                           <td>
                                            <div class="service-badges">
                                                <h3 class="mb-0"><span class="badge service-badge">Priority</span></h3>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="action-sec">
                                              <button class="btn action-btn" data-bs-toggle="modal" data-bs-target="#freelance-extend-modal" href="#">...</button>
                                            </div>
                                          </td>
                                        </tr> --}}

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </p>

                        <!-- CARD SECTION END HERE -->
                        <div class="demo">

                            @if ($completedOrders->hasPages())
                                <nav class="pagination-outer" aria-label="Page navigation">
                                    <ul class="pagination">
                                        {{-- Previous Page Link --}}
                                        @if ($completedOrders->onFirstPage())
                                            <li class="page-item disabled" aria-disabled="true"
                                                aria-label="@lang('pagination.previous')">
                                                <span class="page-link" aria-hidden="true">«</span>

                                            </li>

                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $completedOrders->previousPageUrl() }}"
                                                   rel="prev" aria-label="@lang('pagination.previous')">
                                                    <span aria-hidden="true">«</span>
                                                </a>
                                            </li>

                                        @endif

                                        {{-- Pagination Elements --}}
                                        @php
                                            $start = max($completedOrders->currentPage() - 2, 1);
                                $end = min($completedOrders->currentPage() + 2, $completedOrders->lastPage());
                                        @endphp

                                        @for ($i = $start; $i <= $end; $i++)
                                            @if ($i == $completedOrders->currentPage())
                                                <li class="page-item active" aria-current="page"><a
                                                        class="page-link">{{ $i }}</a></li>
                                            @else
                                                <li class="page-item "><a class="page-link"
                                                                          href="{{ $completedOrders->url($i) }}">{{ $i }}</a>
                                                </li>
                                            @endif
                                        @endfor

                                        {{-- Next Page Link --}}
                                        @if ($completedOrders->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $completedOrders->nextPageUrl() }}"
                                                   rel="next" aria-label="@lang('pagination.next')">
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


                    </section>
                </div>
                <div id="tab5" data-tab-content>
                    <section>
                        <div class="tab__content">
                            <div class="row">
                                <div class="col-md-11">
                                    <div class="search">
                                        <span class="fa fa-search"></span>
                                        <input placeholder="Search service title, experts etc....">
                                    </div>
                                </div>
                                <div class="col-md-1 filter-sec">
                                    <div class="dropdown">
                                        <button class="btn filter-btn" type="button" id="dropdownMenuButton1"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-rounded">
                                      tune
                                      </span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <h5>Servise Type</h5></li>
                                            <a class="dropdown-item" href="#">
                                                <li>Class</li>
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <li>Freelance</li>
                                            </a>
                                            <h5>Sorting</h5>
                                            <a class="dropdown-item" href="#">
                                                <li>A-Z</li>
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <li>Z-A</li>
                                            </a>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="">
                        <div class="class-management-sec">
                            <div class="row">
                                <div class="col-sm-12 ">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <th>Buyer</th>
                                            <th class="service-title">Service Title</th>
                                            <th>Service Type</th>
                                            <th>Start Date</th>
                                            <th>Cancellation Date</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th class="act">Action</th>
                                            </thead>
                                            <tbody>

                                            @if ($cancelledOrders)
                                                @foreach ($cancelledOrders as $order)

                                                    <tr>
                                                        <td>
                                                            <div class="profile-sec">
                                                                @if ($order->profile == null)
                                                                    @php  $firstLetter = strtoupper(substr($order->first_name, 0, 1));  @endphp
                                                                    <img
                                                                        src="assets/profile/avatars/({{$firstLetter}}).jpg"
                                                                        class="card-img-top-profile">
                                                                @else

                                                                    <img src="assets/profile/img/{{$order->profile}}"
                                                                         class="card-img-top-profile">
                                                                @endif

                                                                <p>{{ $order->first_name }}  {{strtoupper(substr($order->last_name, 0, 1))}}
                                                                    . </p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-title">
                                                                <p type="button"
                                                                   id="show_detail_model_{{$order->order_id}}"
                                                                   onclick="ShowDetailsModel(this.id)"
                                                                   data-values="{{ json_encode($order) }}"
                                                                   class="btn seller-desc" data-bs-toggle="modal"
                                                                   data-bs-target="#sell-service-modal"
                                                                   data-name="{{ $order->first_name }} {{$order->last_name}}"
                                                                   data-title="{{$order->title}}"
                                                                   data-order_id="{{$order->order_id}}"
                                                                   data-teacher_reschedule="{{$order->teacher_reschedule}}"
                                                                   data-status="{{$order->status}}"
                                                                   data-service_role="{{$order->service_role}}"
                                                                   data-start_date="{{$order->start_date}}"
                                                                   data-end_date="{{$order->end_date}}"
                                                                   data-price="{{$order->finel_price}}"
                                                                   data-new_all_classes="{{ json_encode($order->new_all_classes) }}"
                                                                   data-all_classes="{{$order->all_classes}}"
                                                                   data-payment_type="{{$order->payment_type}}"
                                                                   data-freelance_service="{{$order->freelance_service}}"
                                                                   data-lesson_type="{{$order->lesson_type}}"
                                                                   data-service_type="{{$order->service_type}}"
                                                                   data-description="{{$order->description}}">{{$order->title}}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-badges">
                                                                <h3 class="mb-0"><span
                                                                        class="badge service-class-badge">{{ $order->service_type }} {{ $order->service_role }}</span>
                                                                </h3>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-date">
                                                                @if($order->payment_type == 'Subscription')
                                                                    <p>{{ \Carbon\Carbon::parse($order->created_at)->format('F d, Y') }}</p>
                                                                @else
                                                                    <p>{{ \Carbon\Carbon::parse($order->start_date)->format('F d, Y') }}</p>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-date">
                                                                <p>{{ \Carbon\Carbon::parse($order->action_date)->format('F d, Y') }}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-date">
                                                                <p>${{ $order->finel_price }}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="service-badges">
                                                                <h3 class="mb-0">
                                                                    <span class="badge service-badge">
                                                                        @if($order->refund == 1)
                                                                            Refunded
                                                                        @elseif ( $order->user_dispute == 1 ||$order->teacher_dispute == 1)
                                                                            Disputed
                                                                        @else
                                                                            Cancelled
                                                                        @endif
                                                                    </span>
                                                                </h3>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="action-sec">
                                                                <button class="btn action-btn"
                                                                        onclick="ActionModelShow(this.id)"
                                                                        data-values="{{ json_encode($order) }}"
                                                                        data-name="{{ $order->first_name }} {{$order->last_name}}"
                                                                        data-title="{{$order->title}}"
                                                                        data-user_id="{{$order->id}}"
                                                                        data-order_id="{{$order->order_id}}"
                                                                        data-dispute="{{$order->teacher_dispute}}"
                                                                        data-reschedule="{{$order->user_reschedule}}"
                                                                        data-freelance_service="{{$order->freelance_service}}"
                                                                        data-status="{{$order->status}}"
                                                                        data-service_role="{{$order->service_role}}"
                                                                        data-start_date="{{$order->start_date}}"
                                                                        data-end_date="{{$order->end_date}}"
                                                                        data-price="{{$order->finel_price}}"
                                                                        data-new_all_classes="{{ json_encode($order->new_all_classes) }}"
                                                                        data-all_classes="{{$order->all_classes}}"
                                                                        data-payment_type="{{$order->payment_type}}"
                                                                        data-freelance_service="{{$order->freelance_service}}"
                                                                        data-lesson_type="{{$order->lesson_type}}"
                                                                        data-service_type="{{$order->service_type}}"
                                                                        data-updated_at="{{$order->updated_at}}"
                                                                        data-teacher_reschedule="{{$order->teacher_reschedule}}"
                                                                        data-description="{{$order->description}}"
                                                                        id="class-reshedule_{{$order->order_id}}">...
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                @endforeach

                                            @endif


                                            </tbody>

                                            {{-- <tr>
                                          <td>
                                            <div class="profile-sec">
                                                <img src="assets/user/asset/img/profile.png" alt="">
                                                <p>Usama A.<br><span>UI Designer</span></p>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="service-title">
                                                <p type="button" class="btn seller-desc" data-bs-toggle="modal" data-bs-target="#sell-service-modal">Learn How to design attractive UI for clients....</p>
                                            </div>
                                          </td>
                                          <td>
                                              <div class="service-badges">
                                                  <h3 class="mb-0"><span class="badge service-badge">Online Freelance</h3>
                                              </div>
                                          </td>
                                          <td>
                                            <div class="service-date">
                                                <p>June 15, 2023</p>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="service-date">
                                                <p>June 15, 2023</p>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="service-date">
                                                <p>$58</p>
                                            </div>
                                          </td>
                                           <td>
                                            <div class="service-badges">
                                                <h3 class="mb-0"><span class="badge service-badge">Priority</span></h3>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="action-sec">
                                              <button class="btn action-btn" data-bs-toggle="modal" data-bs-target="#freelance-extend-modal" href="#">...</button>
                                            </div>
                                          </td>
                                        </tr> --}}

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </p>

                        <!-- CARD SECTION END HERE -->
                        <div class="demo">

                            @if ($cancelledOrders->hasPages())
                                <nav class="pagination-outer" aria-label="Page navigation">
                                    <ul class="pagination">
                                        {{-- Previous Page Link --}}
                                        @if ($cancelledOrders->onFirstPage())
                                            <li class="page-item disabled" aria-disabled="true"
                                                aria-label="@lang('pagination.previous')">
                                                <span class="page-link" aria-hidden="true">«</span>

                                            </li>

                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $cancelledOrders->previousPageUrl() }}"
                                                   rel="prev" aria-label="@lang('pagination.previous')">
                                                    <span aria-hidden="true">«</span>
                                                </a>
                                            </li>

                                        @endif

                                        {{-- Pagination Elements --}}
                                        @php
                                            $start = max($cancelledOrders->currentPage() - 2, 1);
                            $end = min($cancelledOrders->currentPage() + 2, $cancelledOrders->lastPage());
                                        @endphp

                                        @for ($i = $start; $i <= $end; $i++)
                                            @if ($i == $cancelledOrders->currentPage())
                                                <li class="page-item active" aria-current="page"><a
                                                        class="page-link">{{ $i }}</a></li>
                                            @else
                                                <li class="page-item "><a class="page-link"
                                                                          href="{{ $cancelledOrders->url($i) }}">{{ $i }}</a>
                                                </li>
                                            @endif
                                        @endfor

                                        {{-- Next Page Link --}}
                                        @if ($cancelledOrders->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $cancelledOrders->nextPageUrl() }}"
                                                   rel="next" aria-label="@lang('pagination.next')">
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

                    </section>
                </div>
                <div id="tab6" data-tab-content>
                    <section>
                        <div class="tab__content">
                            <div class="row">
                                <div class="col-md-11">
                                    <div class="search">
                                        <span class="fa fa-search"></span>
                                        <input placeholder="Search service title, experts etc....">
                                    </div>
                                </div>
                                <div class="col-md-1 filter-sec">
                                    <div class="dropdown">
                                        <button class="btn filter-btn" type="button" id="dropdownMenuButton1"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-rounded">
                                      tune
                                      </span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <h5>Servise Type</h5></li>
                                            <a class="dropdown-item" href="#">
                                                <li>Class</li>
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <li>Freelance</li>
                                            </a>
                                            <h5>Sorting</h5>
                                            <a class="dropdown-item" href="#">
                                                <li>A-Z</li>
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <li>Z-A</li>
                                            </a>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="">
                        <div class="class-management-sec">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="float-start profile-section">
                                                                <img src="assets/user/asset/img/expert-img.png" alt="">
                                                                <p>Cameron W. <br><span>Graphic Designer</span></p>
                                                            </div>
                                                            <div class="float-end expert-dropdown">
                                                                <button class="btn action-btn" type="button"
                                                                        id="dropdownMenuButton1"
                                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                                    ...
                                                                </button>
                                                                <ul class="dropdown-menu"
                                                                    aria-labelledby="dropdownMenuButton1">
                                                                    <a class="dropdown-item" href="#">
                                                                        <li>Send Message</li>
                                                                    </a>
                                                                    <a class="dropdown-item" href="#">
                                                                        <li>View Profile</li>
                                                                    </a>
                                                                    <a class="dropdown-item" href="#" type="button"
                                                                       class="btn btn-primary" data-bs-toggle="modal"
                                                                       data-bs-target="#cancel-service-modal">
                                                                        <li>Cancel Subscription</li>
                                                                    </a>
                                                                    <a class="dropdown-item" href="#">
                                                                        <li>Report Seller</li>
                                                                    </a>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="float-start profile-section">
                                                                <img src="assets/user/asset/img/expert-img1.png" alt="">
                                                                <p>Guy H. <br><span>Graphic Designer</span></p>
                                                            </div>
                                                            <div class="float-end expert-dropdown">
                                                                <button class="btn action-btn" type="button"
                                                                        id="dropdownMenuButton1"
                                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                                    ...
                                                                </button>
                                                                <ul class="dropdown-menu"
                                                                    aria-labelledby="dropdownMenuButton1">
                                                                    <a class="dropdown-item" href="#">
                                                                        <li>Send Message</li>
                                                                    </a>
                                                                    <a class="dropdown-item" href="#">
                                                                        <li>View Profile</li>
                                                                    </a>
                                                                    <a class="dropdown-item" href="#" type="button"
                                                                       class="btn btn-primary" data-bs-toggle="modal"
                                                                       data-bs-target="#cancel-service-modal">
                                                                        <li>Cancel Subscription</li>
                                                                    </a>
                                                                    <a class="dropdown-item" href="#">
                                                                        <li>Report Seller</li>
                                                                    </a>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="float-start profile-section">
                                                                <img src="assets/user/asset/img/expert-img3.png" alt="">
                                                                <p>Floyd M. <br><span>Graphic Designer</span></p>
                                                            </div>
                                                            <div class="float-end expert-dropdown">
                                                                <button class="btn action-btn" type="button"
                                                                        id="dropdownMenuButton1"
                                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                                    ...
                                                                </button>
                                                                <ul class="dropdown-menu"
                                                                    aria-labelledby="dropdownMenuButton1">
                                                                    <a class="dropdown-item" href="#">
                                                                        <li>Send Message</li>
                                                                    </a>
                                                                    <a class="dropdown-item" href="#">
                                                                        <li>View Profile</li>
                                                                    </a>
                                                                    <a class="dropdown-item" href="#" type="button"
                                                                       class="btn btn-primary" data-bs-toggle="modal"
                                                                       data-bs-target="#cancel-service-modal">
                                                                        <li>Cancel Subscription</li>
                                                                    </a>
                                                                    <a class="dropdown-item" href="#">
                                                                        <li>Report Seller</li>
                                                                    </a>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="float-start profile-section">
                                                                <img src="assets/user/asset/img/expert-img4.png" alt="">
                                                                <p>Floyd M. <br><span>Graphic Designer</span></p>
                                                            </div>
                                                            <div class="float-end expert-dropdown">
                                                                <button class="btn action-btn" type="button"
                                                                        id="dropdownMenuButton1"
                                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                                    ...
                                                                </button>
                                                                <ul class="dropdown-menu"
                                                                    aria-labelledby="dropdownMenuButton1">
                                                                    <a class="dropdown-item" href="#">
                                                                        <li>Send Message</li>
                                                                    </a>
                                                                    <a class="dropdown-item" href="#">
                                                                        <li>View Profile</li>
                                                                    </a>
                                                                    <a class="dropdown-item" href="#" type="button"
                                                                       class="btn btn-primary" data-bs-toggle="modal"
                                                                       data-bs-target="#cancel-service-modal">
                                                                        <li>Cancel Subscription</li>
                                                                    </a>
                                                                    <a class="dropdown-item" href="#">
                                                                        <li>Report Seller</li>
                                                                    </a>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="float-start profile-section">
                                                                <img src="assets/user/asset/img/expert-img-5.png"
                                                                     alt="">
                                                                <p>Cameron W. <br><span>Graphic Designer</span></p>
                                                            </div>
                                                            <div class="float-end expert-dropdown">
                                                                <button class="btn action-btn" type="button"
                                                                        id="dropdownMenuButton1"
                                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                                    ...
                                                                </button>
                                                                <ul class="dropdown-menu"
                                                                    aria-labelledby="dropdownMenuButton1">
                                                                    <a class="dropdown-item" href="#">
                                                                        <li>Send Message</li>
                                                                    </a>
                                                                    <a class="dropdown-item" href="#">
                                                                        <li>View Profile</li>
                                                                    </a>
                                                                    <a class="dropdown-item" href="#" type="button"
                                                                       class="btn btn-primary" data-bs-toggle="modal"
                                                                       data-bs-target="#cancel-service-modal">
                                                                        <li>Cancel Subscription</li>
                                                                    </a>
                                                                    <a class="dropdown-item" href="#">
                                                                        <li>Report Seller</li>
                                                                    </a>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="float-start profile-section">
                                                                <img src="assets/user/asset/img/expert-img2.png" alt="">
                                                                <p>Cameron W. <br><span>Graphic Designer</span></p>
                                                            </div>
                                                            <div class="float-end expert-dropdown">
                                                                <button class="btn action-btn" type="button"
                                                                        id="dropdownMenuButton1"
                                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                                    ...
                                                                </button>
                                                                <ul class="dropdown-menu"
                                                                    aria-labelledby="dropdownMenuButton1">
                                                                    <a class="dropdown-item" href="#">
                                                                        <li>Send Message</li>
                                                                    </a>
                                                                    <a class="dropdown-item" href="#">
                                                                        <li>View Profile</li>
                                                                    </a>
                                                                    <a class="dropdown-item" href="#" type="button"
                                                                       class="btn btn-primary" data-bs-toggle="modal"
                                                                       data-bs-target="#cancel-service-modal">
                                                                        <li>Cancel Subscription</li>
                                                                    </a>
                                                                    <a class="dropdown-item" href="#">
                                                                        <li>Report Seller</li>
                                                                    </a>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                </p>
                <!-- pagination start from here -->
                {{-- <div class="demo">
                          <nav class="pagination-outer" aria-label="Page navigation">
                              <ul class="pagination">
                                  <li class="page-item">
                                      <a href="#" class="page-link" aria-label="Previous">
                                          <span aria-hidden="true">«</span>
                                      </a>
                                  </li>
                                  <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                                  <li class="page-item"><a class="page-link" href="#">4</a></li>
                                  <li class="page-item"><a class="page-link" href="#">5</a></li>
                                  <li class="page-item">
                                      <a href="#" class="page-link" aria-label="Next">
                                          <span aria-hidden="true">»</span>
                                      </a>
                                  </li>
                              </ul>
                          </nav>
                      </div> --}}
                <!-- pagination ended here -->
                <!-- copyright section start from here -->
                <div class="copyright">
                    <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
                </div>

            </div>
        </div>
    </div>

    <!-- radio js here -->
    <script>
        function showAdditionalOptions1() {
            hideAllAdditionalOptions();
            document.getElementById('additionalOptions1').style.display = 'block';
        }

        function showAdditionalOptions2() {
            hideAllAdditionalOptions();
            document.getElementById('additionalOptions2').style.display = 'block';
        }

        function showAdditionalOptions3() {
            hideAllAdditionalOptions();
            document.getElementById('additionalOptions3').style.display = 'block';
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
        document.addEventListener('DOMContentLoaded', function () {
            // Get the Cancel button by its ID
            var cancelButton = document.getElementById('cancelButton');

            // Add a click event listener to the Cancel button
            cancelButton.addEventListener('click', function () {
                // Find the modal by its ID
                var modal = document.getElementById('exampleModal3');

                // Use Bootstrap's modal method to hide the modal
                $(modal).modal('hide');
            });
        });
    </script>
    <!-- copyright section ended here -->
</section>

<!-- =============================== MAIN CONTENT END HERE =========================== -->


<script src="assets/user/libs/jquery/jquery.js"></script>
<script src="assets/user/libs/datatable/js/datatable.js"></script>
<script src="assets/user/libs/datatable/js/datatablebootstrap.js"></script>
<script src="assets/user/libs/select2/js/select2.min.js"></script>
<script src="assets/user/libs/owl-carousel/js/owl.carousel.min.js"></script>
<script src="assets/user/libs/aos/js/aos.js"></script>
<script src="assets/user/asset/js/bootstrap.min.js"></script>
<script src="assets/user/asset/js/script.js"></script>
<!-- calendar js links -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.2/angular.min.js"></script>
</body>
</html>
<!-- =============================================================================================================================================================== -->
<!-- Service Modal Start from here -->
<div class="modal fade" id="sell-service-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content service-modal">
            <div class="modal-body p-0">
                <form class="row">
                    <div class="col-12 services-form">
                        <label for="inputAddress" class="form-label">Seller Name</label>
                        <input type="text" class="form-control" id="detail_name" placeholder="Usama Aslam" readonly>
                    </div>
                    <div class="col-12 services-form">
                        <label for="inputAddress2" class="form-label">Service Type</label>
                        <input type="text" class="form-control" id="detail_service" placeholder="Freelance Service"
                               readonly>
                    </div>
                    <div class="col-12 services-form">
                        <label for="inputAddress2" class="form-label">Payment Type</label>
                        <input type="text" class="form-control" id="detail_payment" placeholder="Freelance Service"
                               readonly>
                    </div>
                    <div class="col-12 services-form">
                        <label for="inputAddress" class="form-label">Service Title</label>
                        <input type="text" class="form-control" id="detail_title"
                               placeholder="I wil Design best UI design for you" readonly>
                    </div>
                    <div class="col-12 service-desc">
                        <label for="inputAddress" class="form-label">Description</label><br>
                        <textarea name="" id="detail_description" cols="30" rows="10"
                                  placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged."
                                  readonly></textarea>
                    </div>


                    <div class="col-12 services-form pb-0 mb-1">
                        <label for="inputAddress" class="form-label">Price</label>
                        <input type="text" class="form-control" id="detail_price" placeholder="$ 1400" readonly>
                    </div>
                    <div class="col-12 services-form pb-0 mb-1 all_classes_main classes_model_main">
                        <label for="inputAddress" class="form-label">All Classes Scheduled</label>
                        <ul class="all_classes_ul">
                            {{-- <li style=" display: flex ;  align-items: center; justify-content: space-around; font-size: medium;" > <b>Class 1 :-</b>  May 26, 2025  <strong>Attended</strong> </li> --}}
                        </ul>
                    </div>
                    <div class="col-12 services-form pb-0 mb-1 new_all_classes_main classes_model_main">
                        <label for="inputAddress" class="form-label">Rescheduled Classes</label>
                        <ul class="new_all_classes_ul">
                            {{-- <li style=" display: flex ;  align-items: center; justify-content: space-around; font-size: medium;" > <b>Class 1 :-</b>  May 26, 2025  <strong>Attended</strong> </li> --}}
                        </ul>
                    </div>

                    <div class="col-12 services-form date_main">
                        <label for="inputAddress" class="form-label">Current date</label>
                        <input type="text" class="form-control" id="detail_current_date" placeholder="November 23,2023"
                               readonly>
                    </div>
                    <div class="col-12 services-form date_main extended_date_main">
                        <label for="inputAddress" class="form-label">Extended date</label>
                        <input type="text" class="form-control" id="detail_extended_date" placeholder="November 23,2023"
                               readonly>
                    </div>

                    <div class="col-12 services-form view_date_model">
                        <label for="inputAddress" class="form-label">Subscription Start Date & Time</label>
                        <input type="text" class="form-control" id="detail_start_date" placeholder="November 23,2023"
                               readonly>
                    </div>
                    <div class="col-12 services-form view_date_model">
                        <label for="inputAddress" class="form-label">Subscription End Date & Time</label>
                        <input type="text" class="form-control" id="detail_end_date" placeholder="November 23,2023"
                               readonly>
                    </div>


                </form>
                <div style="display: flex;  justify-content: space-between;" class="">

                    <button type="button" id="detail_service_reject" data-bs-dismiss="modal" aria-label="Close" id=""
                            class="btn booking-cancel reject_view view_model_btns mt-1 btn-outline-danger">Reject
                    </button>
                    <button type="button" class="btn reschedule-btn  active_btn_css reschedule_view view_model_btns"
                            style=" margin: 0 auto;" id="reschedule-btn-model"> Reschedule
                    </button>

                    <button type="button" id="detail_service_accept"
                            class="btn float-end accept_view active_btn_css view_model_btns  mt-1"> Accept
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Service Modal Ended here -->
<!-- Action Modals Start From Here -->
<!-- Action Freelace Modal Start From Here -->
<div class="modal fade" id="freelance-extend-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content like-to-do-modal">
            <div class="modal-body p-0">
                <h5 class="text-center mb-0 all_classes_past_heading">The following classes can no longer be rescheduled
                    as they are under 12 hours</h5>
                <div class="row">
                    <div class="col-md-12 ">
                        <ul class="all_classes_past">
                            {{-- <li style=" display: flex ;  align-items: center; justify-content: space-around; font-size: medium;" > <b>Class 1 :-</b>  May 26, 2025  <strong>Attended</strong> </li> --}}
                        </ul>
                        {{-- <button type="button" class="btn extend-deadline-btn" data-bs-toggle="modal" data-bs-target="#freelance-extended-deadline-modal" id="extend-deadline"> Extend Deadline</button> --}}
                    </div>
                    <h5 class="text-center mb-0">Would you still like to go Reschedule page</h5>
                    <div class="col-md-6 services-buttons">
                        <button type="button" class="btn cancel-service-btn" data-bs-dismiss="modal" aria-label="Close">
                            No
                        </button>
                    </div>
                    <div class="col-md-6 mb-0 services-buttons">
                        <button type="button" class="btn mb-0 mark-completed-btn  reschedule-btn">Yes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Action Freelance Modal Ended here -->
<!-- Action Class Modal Start From Here -->
<div class="modal fade" id="OrdersActionModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content like-to-do-modal">
            <div class="modal-body p-0">
                <h5 class="text-center mb-0">What would you like to do?</h5>
                <div class="row">


                    {{-- Pending Orders ===== --}}
                    <div id="Pending_main" class="actions_main">

                        <div class="col-md-12 services-buttons all_actions_buttons" id="view">
                            <button class="btn view-btn" id="view-btn">View</button>
                        </div>
                        <div class="col-md-12 services-buttons all_actions_buttons" id="accept">
                            <button class="btn accept-service-btn" id="accept-btn">Accept Order</button>
                        </div>

                        <div class="col-md-12 services-buttons all_actions_buttons" id="cancel">
                            <button type="button" class="btn cancel-btn" id="cancel-btn" data-refund="0"
                                    onclick="CancelModelShow(this.id);"> Cancel Order
                            </button>
                        </div>

                        <div class="col-md-12 services-buttons all_actions_buttons" id="reschedule">
                            <button type="button" class="btn reschedule-btn" id="reschedule-btn"> Reschedule</button>
                        </div>


                        <div class="col-md-12     services-buttons all_actions_buttons" id="send_message">
                            <button type="button" class="btn   send-message-btn" data-bs-toggle="modal"
                                    data-bs-target="#contact-me-modal" id="send-message-btn">Send Message
                            </button>
                        </div>
                    </div>
                    {{-- Pending Orders ===== --}}

                    {{-- Active Orders ===== --}}
                    {{-- Class ==== --}}
                    <div id="active_class_main" class="actions_main">

                        <div class="col-md-12 services-buttons all_actions_buttons reschedule_main"
                             id="accept_reschedule">
                            <button class="btn   accept-reschedule" id="accept-reschedule-class">Accept Reschedule
                            </button>
                        </div>

                        <div class="col-md-12 services-buttons all_actions_buttons reschedule_main"
                             id="reject_reshedule_class">
                            <button type="button" class="btn reject-reschedule" id="reject-reschedule-class-btn"> Reject
                                Reschedule
                            </button>
                        </div>

                        <div class="col-md-12 services-buttons all_actions_buttons" id="attend_class">
                            <button type="button" class="btn attend-class-btn"> Attend Class</button>
                        </div>
                        <div class="col-md-12 services-buttons all_actions_buttons" id="reschedule_class">
                            <button type="button" class="btn reschedule-class-btn " data-bs-toggle="modal"
                                    data-bs-target="#freelance-extend-modal"
                                    onclick="$('#OrdersActionModel').modal('hide')" id="reschedule-class-btn">
                                Reschedule Class
                            </button>
                        </div>

                        <div class="col-md-12 services-buttons all_actions_buttons" id="cancel_class">
                            <button type="button" class="btn cancel-class-btn" id="cancel-class-btn" data-refund="0"
                                    onclick="CancelModelShow(this.id);"> Cancel Order
                            </button>
                        </div>

                        <div class="col-md-12 services-buttons all_actions_buttons" id="cancel_refund_class">
                            <button type="button" class="btn cancel-refund-class-btn" id="cancel-refund-class-btn"
                                    data-refund="1" onclick="CancelModelShow(this.id);"> Cancel and Refund Order
                            </button>
                        </div>

                        {{-- <div class="col-md-12   services-buttons all_actions_buttons"  id="delivered">
                  <button type="button" class="btn  mark-delivered-btn" data-bs-toggle="modal" data-bs-target="#mark-as-deliverd-modal" id="mark-delivered-btn">Mark as Delivered</button>
                </div> --}}
                    </div>
                    {{-- Freelance Consultation ==== --}}
                    <div id="active_consultation_main" class="actions_main">

                        <div class="col-md-12 services-buttons all_actions_buttons reschedule_main"
                             id="accept_reschedule_session">
                            <button class="btn   accept-reschedule" id="accept-reschedule-session">Accept Reschedule
                            </button>
                        </div>

                        <div class="col-md-12 services-buttons all_actions_buttons reschedule_main"
                             id="reject_reshedule_class">
                            <button type="button" class="btn reject-reschedule" id="reject-reschedule-class-btn"> Reject
                                Reschedule
                            </button>
                        </div>

                        <div class="col-md-12 services-buttons all_actions_buttons" id="attend_session">
                            <button type="button" class="btn attend-session-btn"> Attend Session</button>
                        </div>
                        <div class="col-md-12 services-buttons all_actions_buttons" id="reschedule_session">
                            <button type="button" class="btn reschedule-session-btn " data-bs-toggle="modal"
                                    data-bs-target="#freelance-extend-modal"
                                    onclick="$('#OrdersActionModel').modal('hide')" id="reschedule-session-btn">
                                Reschedule Session
                            </button>
                        </div>

                        <div class="col-md-12 services-buttons all_actions_buttons" id="cancel_session">
                            <button type="button" class="btn cancel-session-btn" id="cancel-session-btn" data-refund="0"
                                    onclick="CancelModelShow(this.id);"> Cancel Order
                            </button>
                        </div>
                        <div class="col-md-12 services-buttons all_actions_buttons" id="cancel_refund_session">
                            <button type="button" class="btn cancel-refund-session-btn" id="cancel-refund-session-btn"
                                    data-refund="1" onclick="CancelModelShow(this.id);"> Cancel & Refund Order
                            </button>
                        </div>

                        {{-- <div class="col-md-12   services-buttons all_actions_buttons"  id="delivered">
                  <button type="button" class="btn  mark-delivered-btn" data-bs-toggle="modal" data-bs-target="#mark-as-deliverd-modal" id="mark-delivered-btn">Mark as Delivered</button>
                </div> --}}

                    </div>
                    {{-- Normal Freelance ==== --}}

                    <div id="active_normal_main" class="actions_main">

                        <div class="col-md-12 services-buttons all_actions_buttons  " id="start_job">
                            <button class="btn   start-job-btn" id="start-job-btn">Start Job</button>
                        </div>
                        <div class="col-md-12 services-buttons all_actions_buttons reschedule_main"
                             id="accept_reschedule_date">
                            <button class="btn   accept-reschedule" id="accept-reschedule-date">Accept Exted Date
                            </button>
                        </div>

                        <div class="col-md-12 services-buttons all_actions_buttons reschedule_main"
                             id="reject_reshedule_class">
                            <button type="button" class="btn reject-reschedule" id="reject-reschedule-date-btn"> Reject
                                Extend Date
                            </button>
                        </div>

                        <div class="col-md-12 services-buttons all_actions_buttons" id="extend">
                            <button type="button" class="btn extend-btn reschedule-btn" id="extend-btn"> Extend
                                Deadline
                            </button>
                        </div>

                        <div class="col-md-12 services-buttons all_actions_buttons" id="cancel_order">
                            <button type="button" class="btn cancel-order-btn" id="cancel-order-btn" data-refund="0"
                                    onclick="CancelModelShow(this.id);"> Cancel Order
                            </button>
                        </div>

                        <div class="col-md-12 services-buttons all_actions_buttons" id="cancel_refund_order">
                            <button type="button" class="btn cancel-refund-order-btn" id="cancel-refund-order-btn"
                                    data-refund="1" onclick="CancelModelShow(this.id);"> Cancel & Refund Order
                            </button>
                        </div>


                        <div class="col-md-12   services-buttons all_actions_buttons" id="delivered">
                            <button type="button" class="btn  mark-delivered-btn" data-bs-toggle="modal"
                                    data-bs-target="#mark-as-deliverd-modal" id="mark-delivered-btn">Mark as Delivered
                            </button>
                        </div>

                    </div>

                    {{-- Active Orders ===== --}}


                    {{-- Delivered Orders ===== --}}

                    <div id="delivered_main" class="actions_main">

                        <div class="col-md-12 services-buttons all_actions_buttons" id="move_order">
                            <button type="button" class="btn move-order-btn" id="move-order-btn"> Move back to active
                            </button>
                        </div>

                        <div class="col-md-12 services-buttons all_actions_buttons" id="cancel_refund_order">
                            <button type="button" class="btn cancel-refund-order-btn" id="cancel-refund-order-btn"
                                    data-refund="1" onclick="CancelModelShow(this.id);"> Cancel & Refund Order
                            </button>
                        </div>


                    </div>

                    {{-- Delivered Orders ===== --}}

                    {{-- Completed Orders ===== --}}
                    <div id="completed_main" class="actions_main">

                        <div class="col-md-12   services-buttons all_actions_buttons" id="review">
                            <button type="button" class="btn   review-btn" id="review-btn">View Buyers Review</button>
                        </div>
                    </div>
                    {{-- Completed Orders ===== --}}

                    {{-- Canceled Orders ===== --}}
                    <div id="canceled_main" class="actions_main">

                        <div class="col-md-12   services-buttons all_actions_buttons" id="review">
                            <button type="button" class="btn  review-btn" id="review-btn">View Buyers Review
                            </button>
                        </div>

                        <div class="col-md-12   services-buttons all_actions_buttons dispute-main" id="dispute-main1">
                            <button type="button" class="btn  accept-dispute-btn" id="accept-dispute-btn">Accept
                                Refund
                            </button>
                        </div>
                        <div class="col-md-12   services-buttons all_actions_buttons dispute-main" id="dispute-main">
                            <button type="button" class="btn mb-0 dispute-btn" id="dispute-btn">Reject Refund</button>
                        </div>
                    </div>
                    {{-- Completed Orders ===== --}}


                </div>
            </div>
        </div>
    </div>
</div>
<!-- Action Class Modal Ended Here -->


<!-- View  Review Modal -->
<div class="modal fade" id="view-review-modal" tabindex="-1" aria-labelledby="addReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content add-review-rating-modal">

            <div class="modal-body p-4">
                <h5 class=" ">Rating</h5>
                <div class="row">
                    <div class="col-md-12 review-rating  ">
                        <i class="fa-regular fa-star star-rating-view" data-value="1" style="padding-left: 6px; "></i>
                        <i class="fa-regular fa-star star-rating-view" data-value="2" style="padding-left: 6px; "></i>
                        <i class="fa-regular fa-star star-rating-view" data-value="3" style="padding-left: 6px; "></i>
                        <i class="fa-regular fa-star star-rating-view" data-value="4" style="padding-left: 6px; "></i>
                        <i class="fa-regular fa-star star-rating-view" data-value="5" style="padding-left: 6px; "></i>
                    </div>
                </div>
                <h5 class="">Review <span>(optional)</span></h5>
                <textarea class="form-control add-review mb-3" name="cmnt_view" id="feedback_comments_view" disabled
                          placeholder="Give your feedback" rows="4"></textarea>
            </div>

        </div>
    </div>
</div>

<!-- View Review Rating modal ended here -->

<!-- Order Cancel  Modal Start =========-->

<div class="modal fade" id="order-cance-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content add-review-rating-modal">
            <div class="modal-body p-0">
                <form action="/cancel-order" method="POST"> @csrf
                    <h5>Are You Sure, You Want to do this? </h5>
                    <p><b>Note:</b> <small class="text-danger cancellation_text_note">Refunds are free within 24 hours,
                            and will only be provided if the seller reschedules and the buyer requests one.</small></p>
                    <ul id="partial-class-list"></ul>
                    <input type="hidden" name="order_id" id="cancel_order_id">
                    <input type="hidden" name="order_refund" id="cancel_order_refund" value="0">
                    <textarea class="form-control add-review" name="reason" id="cancel_reason"
                              placeholder="write rejection reason..." required></textarea>
                    <button type="button" data-bs-dismiss="modal" aria-label="Close"
                            class="btn booking-cancel btn-outline-danger ">Close
                    </button>
                    <button type="submit" class="btn float-end submit-review-btn"> Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Order Cancel  Modal Start =========-->


<!-- Order Cancel  Modal END =========-->


<!-- Cancel and Refund Modal ended here -->
<!-- Modal -->
<div class="modal fade" id="request-refund-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content cancel-refund-modal">
            <div class="modal-body p-0">
                <h5 class="mb-0">Cancel Services</h5>
                <p class="mb-0">once you cancel the services, you <br> couldn’t retrive the action</p>
                <h5>Refund Type &nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17"
                                           fill="none">
                        <path
                            d="M8 2C6.71442 2 5.45772 2.38122 4.3888 3.09545C3.31988 3.80968 2.48676 4.82484 1.99479 6.01256C1.50282 7.20028 1.37409 8.50721 1.6249 9.76809C1.8757 11.029 2.49477 12.1872 3.40381 13.0962C4.31285 14.0052 5.47104 14.6243 6.73192 14.8751C7.99279 15.1259 9.29973 14.9972 10.4874 14.5052C11.6752 14.0132 12.6903 13.1801 13.4046 12.1112C14.1188 11.0423 14.5 9.78558 14.5 8.5C14.4982 6.77665 13.8128 5.12441 12.5942 3.90582C11.3756 2.68722 9.72335 2.00182 8 2ZM8 14C6.91221 14 5.84884 13.6774 4.94437 13.0731C4.0399 12.4687 3.33495 11.6098 2.91867 10.6048C2.50238 9.59977 2.39347 8.4939 2.60568 7.427C2.8179 6.36011 3.34173 5.3801 4.11092 4.61091C4.8801 3.84172 5.86011 3.3179 6.92701 3.10568C7.9939 2.89346 9.09977 3.00238 10.1048 3.41866C11.1098 3.83494 11.9687 4.53989 12.5731 5.44436C13.1774 6.34883 13.5 7.4122 13.5 8.5C13.4983 9.95818 12.9184 11.3562 11.8873 12.3873C10.8562 13.4184 9.45819 13.9983 8 14ZM9 11.5C9 11.6326 8.94732 11.7598 8.85356 11.8536C8.75979 11.9473 8.63261 12 8.5 12C8.23479 12 7.98043 11.8946 7.7929 11.7071C7.60536 11.5196 7.5 11.2652 7.5 11V8.5C7.36739 8.5 7.24022 8.44732 7.14645 8.35355C7.05268 8.25979 7 8.13261 7 8C7 7.86739 7.05268 7.74021 7.14645 7.64645C7.24022 7.55268 7.36739 7.5 7.5 7.5C7.76522 7.5 8.01957 7.60536 8.20711 7.79289C8.39465 7.98043 8.5 8.23478 8.5 8.5V11C8.63261 11 8.75979 11.0527 8.85356 11.1464C8.94732 11.2402 9 11.3674 9 11.5ZM7 5.75C7 5.60166 7.04399 5.45666 7.1264 5.33332C7.20881 5.20999 7.32595 5.11386 7.46299 5.05709C7.60003 5.00032 7.75083 4.98547 7.89632 5.01441C8.04181 5.04335 8.17544 5.11478 8.28033 5.21967C8.38522 5.32456 8.45665 5.4582 8.48559 5.60368C8.51453 5.74917 8.49968 5.89997 8.44291 6.03701C8.38615 6.17406 8.29002 6.29119 8.16668 6.3736C8.04334 6.45601 7.89834 6.5 7.75 6.5C7.55109 6.5 7.36032 6.42098 7.21967 6.28033C7.07902 6.13968 7 5.94891 7 5.75Z"
                            fill="#0072B1"/>
                    </svg>
                </h5>
                <div class="row">
                    <form action="/cancel-order" method="POST"> @csrf
                        <div class="col-md-12 radio-tabs-sec">
                            <div class="col-md-12 radio-tab-section active partial_am_main">
                                <input type="hidden" name="order_id" id="refund_order_id">
                                <input type="hidden" name="order_refund" id="order_refund" value="1">
                                <input type="radio" id="partial_refund" name="refund" class="radio-but" value="1"
                                       checked>
                                <label for="partial_refund">Partial Refund</label>
                            </div>
                            <div class="col-md-12 radio-tab-section full_am_main">
                                <input type="radio" id="full_refund" name="refund" class="radio-but" value="0">
                                <label for="full_refund">Full Refund</label>
                            </div>
                            <article style="display: block;">
                                <h5 class="mb-0 refund partial_am">Refund Amount</h5>
                                <input type="number" class="form-control partial_am" name="refund_amount"
                                       id="refund_amount" placeholder="$1500">
                                <h5 class="mb-0 refund">Refund Reason</h5>
                                <textarea class="form-control" name="reason" id="refund_reason"
                                          placeholder="write here reason of refund" required></textarea>
                                <button type="button" class="btn float-start cancel-button btn-outline-danger">Cancel
                                </button>
                                <button type="submit" class="btn float-end submit-button" id="submit-cancel-service">
                                    Submit
                                </button>
                            </article>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cancel and Refund Modal ended here -->

<!-- Dispute Order and Request Refund Modal ended here -->
<!-- Modal -->
<div class="modal fade" id="dispute-request-refund-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content cancel-refund-modal">
            <div class="modal-body p-0">
                <h5 class="mb-0">Cancel Services</h5>
                <p class="mb-0">once you cancel the services, you <br> couldn’t retrive the action</p>
                <h5>Refund Type &nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17"
                                           fill="none">
                        <path
                            d="M8 2C6.71442 2 5.45772 2.38122 4.3888 3.09545C3.31988 3.80968 2.48676 4.82484 1.99479 6.01256C1.50282 7.20028 1.37409 8.50721 1.6249 9.76809C1.8757 11.029 2.49477 12.1872 3.40381 13.0962C4.31285 14.0052 5.47104 14.6243 6.73192 14.8751C7.99279 15.1259 9.29973 14.9972 10.4874 14.5052C11.6752 14.0132 12.6903 13.1801 13.4046 12.1112C14.1188 11.0423 14.5 9.78558 14.5 8.5C14.4982 6.77665 13.8128 5.12441 12.5942 3.90582C11.3756 2.68722 9.72335 2.00182 8 2ZM8 14C6.91221 14 5.84884 13.6774 4.94437 13.0731C4.0399 12.4687 3.33495 11.6098 2.91867 10.6048C2.50238 9.59977 2.39347 8.4939 2.60568 7.427C2.8179 6.36011 3.34173 5.3801 4.11092 4.61091C4.8801 3.84172 5.86011 3.3179 6.92701 3.10568C7.9939 2.89346 9.09977 3.00238 10.1048 3.41866C11.1098 3.83494 11.9687 4.53989 12.5731 5.44436C13.1774 6.34883 13.5 7.4122 13.5 8.5C13.4983 9.95818 12.9184 11.3562 11.8873 12.3873C10.8562 13.4184 9.45819 13.9983 8 14ZM9 11.5C9 11.6326 8.94732 11.7598 8.85356 11.8536C8.75979 11.9473 8.63261 12 8.5 12C8.23479 12 7.98043 11.8946 7.7929 11.7071C7.60536 11.5196 7.5 11.2652 7.5 11V8.5C7.36739 8.5 7.24022 8.44732 7.14645 8.35355C7.05268 8.25979 7 8.13261 7 8C7 7.86739 7.05268 7.74021 7.14645 7.64645C7.24022 7.55268 7.36739 7.5 7.5 7.5C7.76522 7.5 8.01957 7.60536 8.20711 7.79289C8.39465 7.98043 8.5 8.23478 8.5 8.5V11C8.63261 11 8.75979 11.0527 8.85356 11.1464C8.94732 11.2402 9 11.3674 9 11.5ZM7 5.75C7 5.60166 7.04399 5.45666 7.1264 5.33332C7.20881 5.20999 7.32595 5.11386 7.46299 5.05709C7.60003 5.00032 7.75083 4.98547 7.89632 5.01441C8.04181 5.04335 8.17544 5.11478 8.28033 5.21967C8.38522 5.32456 8.45665 5.4582 8.48559 5.60368C8.51453 5.74917 8.49968 5.89997 8.44291 6.03701C8.38615 6.17406 8.29002 6.29119 8.16668 6.3736C8.04334 6.45601 7.89834 6.5 7.75 6.5C7.55109 6.5 7.36032 6.42098 7.21967 6.28033C7.07902 6.13968 7 5.94891 7 5.75Z"
                            fill="#0072B1"/>
                    </svg>
                </h5>
                <div class="row">
                    <form action="/dispute-order" method="POST"> @csrf
                        <div class="col-md-12 radio-tabs-sec active">
                            <div class="col-md-12 radio-tab-section full_am_main">
                                <input type="radio" id="dispute_no_refund" name="refund" class="radio-but" value="2"
                                       checked>
                                <label for="no_refund">No Refund</label>
                            </div>

                            <div class="col-md-12 radio-tab-section full_am_main">
                                <input type="radio" id="dispute_full_refund" name="refund" class="radio-but" value="0">
                                <label for="full_refund">Full Refund</label>
                            </div>

                            <div class="col-md-12 radio-tab-section  partial_am_main">
                                <input type="hidden" name="order_id" id="dispute_order_id">
                                <input type="hidden" name="order_refund" id="dispute_refund" value="1">
                                <input type="radio" id="dispute_partial_refund" name="refund" class="radio-but"
                                       value="1">
                                <label for="partial_refund">Partial Refund</label>
                            </div>


                            <article style="display: block;">
                                <h5 class="mb-0 refund dispute_partial_am">Refund Amount</h5>
                                <input type="number" class="form-control dispute_partial_am" name="refund_amount"
                                       id="dispute_refund_amount" placeholder="$1500">
                                <h5 class="mb-0 refund">Refund Reason</h5>
                                <textarea class="form-control" name="reason" id="dispute_refund_reason"
                                          placeholder="explain why dispute order..." required></textarea>
                                <button type="button" class="btn float-start cancel-button btn-outline-danger">Cancel
                                </button>
                                <button type="submit" class="btn float-end submit-button" id="submit-cancel-service">
                                    Submit
                                </button>
                            </article>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  Dispute Order and Request Refund  Modal ended here -->


<!-- Send Message  Modal Start =========-->

<div class="modal fade" id="contact-me-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content add-review-rating-modal">
            <div class="modal-body p-0">

                <h5>Message Details </h5>
                <input type="hidden" name="reciver_id" id="reciver_id">
                <textarea class="form-control add-review" name="message-textarea" id="message-textarea"
                          placeholder="type your message..."></textarea>
                <button type="button" data-bs-dismiss="modal" aria-label="Close"
                        class="btn booking-cancel  btn-outline-danger">Cancel
                </button>
                <button type="button" class="btn float-end submit-review-btn" data-bs-dismiss="modal"
                        onclick="SendSMS()"> Send Message
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="online-normal-deliver-model" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content add-review-rating-modal">
            <div class="modal-body p-0">

                <form method="POST" action="/freelance-order-deliver" enctype="multipart/form-data"> @csrf

                    <h5>Delivery Order Details </h5>
                    <input type="hidden" name="order_id" id="deliver_order_id">

                    <div class=" select-groups  ">
                        <label for="file" class="form-label"
                               style="  color: #0072b1;font-family: Outfit;   font-weight: 500; line-height: normal;">Upload
                            File</label>

                        <input type="file" class="form-control " id="file" name="file" placeholder="Upload File"
                               accept=".pdf,.doc,.docx,.zip" required/>
                    </div>

                    <div class=" select-groups mt-2  ">
                        <label for="message-deliver" class="form-label"
                               style="  color: #0072b1;font-family: Outfit;   font-weight: 500; line-height: normal;">Message</label>

                        <textarea class="form-control add-review " name="message" id="message-deliver"
                                  placeholder="type your message..." required></textarea>
                    </div>


                    <button type="button" data-bs-dismiss="modal" aria-label="Close"
                            class="btn booking-cancel  btn-outline-danger">Cancel
                    </button>
                    <button type="submit" class="btn float-end submit-review-btn" data-bs-dismiss="modal"> Deliver
                        Order
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Send Message  Modal END =========-->

<!-- extend deadline modal start from here -->
<!-- Modal -->
<div class="modal fade" id="extend-deadline-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content extended-deadline-modal">
            <div class="modal-body">
                <h5 class="mb-0">Extend Deadline</h5>
                <div class="app-container" ng-app="dateTimeApp" ng-controller="dateTimeCtrl as ctrl" ng-cloak>

                    <div date-picker
                         datepicker-title="Select Date"
                         picktime="true"
                         pickdate="true"
                         pickpast="false"
                         mondayfirst="false"
                         custom-message="You have selected"
                         selecteddate="ctrl.selected_date"
                         updatefn="ctrl.updateDate(newdate)">

                        <div class="datepicker"
                             ng-class="{
                    'am': timeframe == 'am',
                    'pm': timeframe == 'pm',
                    'compact': compact
                  }">
                            {{-- <div class="datepicker-header">
                    <div class="datepicker-title" ng-if="datepicker_title">{{ datepickerTitle }}</div>
                    <div class="datepicker-subheader">{{ customMessage }} {{ selectedDay }} {{ monthNames[localdate.getMonth()] }} {{ localdate.getDate() }}, {{ localdate.getFullYear() }}</div>
                  </div> --}}
                            <div class="datepicker-calendar">
                                <div class="calendar-header">
                                    <div class="goback" ng-click="moveBack()" ng-if="pickdate">
                                        <svg width="30" height="30">
                                            <path fill="none" stroke="#0072b1" stroke-width="3" d="M19,6 l-9,9 l9,9"/>
                                        </svg>
                                    </div>
                                    {{-- <div class="current-month-container">{{ currentViewDate.getFullYear() }} {{ currentMonthName() }}</div> --}}
                                    <div class="goforward" ng-click="moveForward()" ng-if="pickdate">
                                        <svg width="30" height="30">
                                            <path fill="none" stroke="#0072b1" stroke-width="3" d="M11,6 l9,9 l-9,9"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="calendar-day-header">
                                    {{-- <span ng-repeat="day in days" class="day-label">{{ day.short }}</span> --}}
                                </div>
                                <div class="calendar-grid" ng-class="{false: 'no-hover'}[pickdate]">
                                    <div
                                        ng-class="{'no-hover': !day.showday}"
                                        ng-repeat="day in month"
                                        class="datecontainer"
                                        ng-style="{'margin-left': calcOffset(day, $index)}"
                                        track by $index>
                                        <div class="datenumber" ng-class="{'day-selected': day.selected }"
                                             ng-click="selectDate(day)">
                                            {{-- {{ day.daydate }} --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="timepicker" ng-if="picktime == 'true'">
                                <div ng-class="{'am': timeframe == 'am', 'pm': timeframe == 'pm' }">
                                    <div class="timepicker-container-outer" selectedtime="time" timetravel>
                                        <div class="timepicker-container-inner">
                                            <div class="timeline-container" ng-mousedown="timeSelectStart($event)"
                                                 sm-touchstart="timeSelectStart($event)">
                                                <div class="current-time">
                                                    {{-- <div class="actual-time">{{ time }}</div> --}}
                                                </div>
                                                <div class="timeline">
                                                </div>
                                                <div class="hours-container">
                                                    <div class="hour-mark"
                                                         ng-repeat="hour in getHours() track by $index"></div>
                                                </div>
                                            </div>
                                            <div class="display-time">
                                                <div class="decrement-time" ng-click="adjustTime('decrease')">
                                                    <svg width="24" height="24">
                                                        <path stroke="white" stroke-width="2" d="M8,12 h8"/>
                                                    </svg>
                                                </div>
                                                <div class="time" ng-class="{'time-active': edittime.active}">
                                                    <input type="text" class="time-input" ng-model="edittime.input"
                                                           ng-keydown="changeInputTime($event)"
                                                           ng-focus="edittime.active = true; edittime.digits = [];"
                                                           ng-blur="edittime.active = false"/>
                                                    {{-- <div class="formatted-time">{{ edittime.formatted }}</div> --}}
                                                </div>
                                                <div class="increment-time" ng-click="adjustTime('increase')">
                                                    <svg width="24" height="24">
                                                        <path stroke="white" stroke-width="2" d="M12,7 v10 M7,12 h10"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="am-pm-container">
                                                <div class="am-pm-button" ng-click="changetime('am');">am</div>
                                                <div class="am-pm-button" ng-click="changetime('pm');">pm</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="buttons-container">
                                <div class="cancel-button">CANCEL</div>
                                <div class="save-button">SAVE</div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- extend dead line modal ended here -->
<!-- Reshedule deadline modal start from here -->
<!-- Modal -->
<div class="modal fade" id="reshedule-service-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content extended-deadline-modal">
            <div class="modal-body">
                <h5 class="mb-0">Reschedule Service</h5>
                <div class="app-container" ng-app="dateTimeApp" ng-controller="dateTimeCtrl as ctrl" ng-cloak>

                    <div date-picker
                         datepicker-title="Select Date"
                         picktime="true"
                         pickdate="true"
                         pickpast="false"
                         mondayfirst="false"
                         custom-message="You have selected"
                         selecteddate="ctrl.selected_date"
                         updatefn="ctrl.updateDate(newdate)">

                        <div class="datepicker"
                             ng-class="{
                    'am': timeframe == 'am',
                    'pm': timeframe == 'pm',
                    'compact': compact
                  }">
                            {{-- <div class="datepicker-header">
                    <div class="datepicker-title" ng-if="datepicker_title">{{ datepickerTitle }}</div>
                    <div class="datepicker-subheader">{{ customMessage }} {{ selectedDay }} {{ monthNames[localdate.getMonth()] }} {{ localdate.getDate() }}, {{ localdate.getFullYear() }}</div>
                  </div> --}}
                            <div class="datepicker-calendar">
                                <div class="calendar-header">
                                    <div class="goback" ng-click="moveBack()" ng-if="pickdate">
                                        <svg width="30" height="30">
                                            <path fill="none" stroke="#0072b1" stroke-width="3" d="M19,6 l-9,9 l9,9"/>
                                        </svg>
                                    </div>
                                    {{-- <div class="current-month-container">{{ currentViewDate.getFullYear() }} {{ currentMonthName() }}</div> --}}
                                    <div class="goforward" ng-click="moveForward()" ng-if="pickdate">
                                        <svg width="30" height="30">
                                            <path fill="none" stroke="#0072b1" stroke-width="3" d="M11,6 l9,9 l-9,9"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="calendar-day-header">
                                    {{-- <span ng-repeat="day in days" class="day-label">{{ day.short }}</span> --}}
                                </div>
                                <div class="calendar-grid" ng-class="{false: 'no-hover'}[pickdate]">
                                    <div
                                        ng-class="{'no-hover': !day.showday}"
                                        ng-repeat="day in month"
                                        class="datecontainer"
                                        ng-style="{'margin-left': calcOffset(day, $index)}"
                                        track by $index>
                                        <div class="datenumber" ng-class="{'day-selected': day.selected }"
                                             ng-click="selectDate(day)">
                                            {{-- {{ day.daydate }} --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="timepicker" ng-if="picktime == 'true'">
                                <div ng-class="{'am': timeframe == 'am', 'pm': timeframe == 'pm' }">
                                    <div class="timepicker-container-outer" selectedtime="time" timetravel>
                                        <div class="timepicker-container-inner">
                                            <div class="timeline-container" ng-mousedown="timeSelectStart($event)"
                                                 sm-touchstart="timeSelectStart($event)">
                                                <div class="current-time">
                                                    {{-- <div class="actual-time">{{ time }}</div> --}}
                                                </div>
                                                <div class="timeline">
                                                </div>
                                                <div class="hours-container">
                                                    <div class="hour-mark"
                                                         ng-repeat="hour in getHours() track by $index"></div>
                                                </div>
                                            </div>
                                            <div class="display-time">
                                                <div class="decrement-time" ng-click="adjustTime('decrease')">
                                                    <svg width="24" height="24">
                                                        <path stroke="white" stroke-width="2" d="M8,12 h8"/>
                                                    </svg>
                                                </div>
                                                <div class="time" ng-class="{'time-active': edittime.active}">
                                                    <input type="text" class="time-input" ng-model="edittime.input"
                                                           ng-keydown="changeInputTime($event)"
                                                           ng-focus="edittime.active = true; edittime.digits = [];"
                                                           ng-blur="edittime.active = false"/>
                                                    {{-- <div class="formatted-time">{{ edittime.formatted }}</div> --}}
                                                </div>
                                                <div class="increment-time" ng-click="adjustTime('increase')">
                                                    <svg width="24" height="24">
                                                        <path stroke="white" stroke-width="2" d="M12,7 v10 M7,12 h10"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="am-pm-container">
                                                <div class="am-pm-button" ng-click="changetime('am');">am</div>
                                                <div class="am-pm-button" ng-click="changetime('pm');">pm</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="buttons-container">
                                <div class="cancel-button">CANCEL</div>
                                <div class="save-button">SAVE</div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Reshedule dead line modal ended here -->
<!-- Cancel Service Only Modal Start from here -->
<!-- Modal -->
<div class="modal fade" id="cancel-services-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content cancel-service-only-modal">
            <div class="modal-body">
                <h5>Cancel Services?</h5>
                <p>This action cannot be undone once <br> the service is cancelled</p>
                <div class="text-center cancel-service-only-buttons">
                    <button type="button" class="btn yes-btn" data-bs-toggle="modal"
                            data-bs-target="#successfully-cancelled-modal" id="successfully-cancelled">Yes
                    </button>
                    <button type="button" class="btn no-btn" data-bs-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cancel Service Only Modal Ended here -->
<!-- Yes Button Cancel modal start from here -->
<!-- Modal -->
<div class="modal fade" id="successfully-cancelled-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content yes-successfully-cancelled-modal">
            <div class="modal-body p-0">
                <h5 class="mb-0">Successfully Cancelled</h5>
                <p class="mb-0">You have successfully cancelled this <br> services.</p>
                <div class="text-center">
                    <button type="button" class="btn add-review-btn" data-bs-toggle="modal"
                            data-bs-target="#add-review-modal" id="rating-review">Add Review
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Yes Button Cancel modal ended here -->
<!-- Add Review Rating modal start from here -->
<!-- Modal -->
<div class="modal fade" id="add-review-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content add-review-rating-modal">
            <div class="modal-body p-0">
                <h5 class="mb-0">Rating</h5>
                <div class="row">
                    <div class="col-md-12 review-rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                </div>
                <h5>Reviews <span>(optional)</span></h5>
                <textarea class="form-control add-review" name="comments" id="feedback_comments"
                          placeholder="give your feedback"></textarea>
                <button type="button" class="btn float-end submit-review-btn" data-bs-dismiss="modal">Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- Add Review Rating modal ended here -->

<!-- freelance extend deadline modal start from here -->
<div class="modal fade" id="reshedule-service-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content extended-deadline-modal">
            <div class="modal-body">
                <h5 class="mb-0">Extend Service</h5>
                <input type="date">
            </div>
        </div>
    </div>
</div>
<!-- freelance extend deadline modal ended here -->
<!-- freelance priority extend deadline modal start from here -->
<div class="modal fade" id="dddddd" tabindex="-1" aria-labelledby="dddddd" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content extended-deadline-modal">
            <div class="modal-body">
                <h5 class="mb-0">Extend Service</h5>
                <input type="date">
            </div>
        </div>
    </div>
</div>
<!-- freelance priority extend deadline modal ended here -->
<!-- Mark as completed Yes Button Cancel modal start from here -->
<!-- Modal -->
<div class="modal fade" id="mark-as-completed-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content yes-successfully-cancelled-modal">
            <div class="modal-body p-0">
                <h5 class="mb-0">Congratulation!</h5>
                <p class="mb-0">Congratulation, We successfully <br> complete this service</p>
                <div class="text-center">
                    <button type="button" class="btn add-review-btn" data-bs-toggle="modal"
                            data-bs-target="#rating-modal" id="add-reviews">Add Review
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Mark as completed Yes Button Cancel modal ended here -->
<!-- Mark as completed Add Review Rating modal start from here -->
<!-- Modal -->
<div class="modal fade" id="rating-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content add-review-rating-modal">
            <div class="modal-body p-0">
                <h5 class="mb-0">Rating</h5>
                <div class="row">
                    <div class="col-md-12 review-rating">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                </div>
                <h5>Reviews <span>(optional)</span></h5>
                <textarea class="form-control add-review" name="comments" id="feedback_comments"
                          placeholder="give your feedback"></textarea>
                <button type="button" class="btn float-end submit-review-btn" data-bs-dismiss="modal">Submit</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="cancel-service-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content cancelation-modal">
            <div class="modal-body p-0">
                <div class="cancel-model-sec">
                    <div class="row cancel-service-modal">
                        <div class="col-md-12">
                            <h5 class="mb-0">Service Title</h5>
                        </div>
                    </div>
                </div>
                <div class="cancel-section">
                    <div class="row cancel-service-modal-sec">
                        <div class="col-md-12">
                            <p>Elevate Your Designs: Mastering the Art of Creating Striking UI for Client
                                Satisfaction</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row cancel-service-modal-sec">
                        <div class="col-md-12">
                            <p>Elevate Your Designs: Mastering the Art of Creating Striking UI for Client
                                Satisfaction</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row cancel-service-modal-sec">
                        <div class="col-md-12">
                            <p>Elevate Your Designs: Mastering the Art of Creating Striking UI for Client
                                Satisfaction</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row cancel-service-modal-sec">
                        <div class="col-md-12">
                            <p>Elevate Your Designs: Mastering the Art of Creating Striking UI for Client
                                Satisfaction</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row cancel-service-modal-sec">
                        <div class="col-md-12">
                            <p>Elevate Your Designs: Mastering the Art of Creating Striking UI for Client
                                Satisfaction</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row cancel-service-modal-sec">
                        <div class="col-md-12">
                            <p>Elevate Your Designs: Mastering the Art of Creating Striking UI for Client
                                Satisfaction</p>
                        </div>
                    </div>
                    <hr>
                </div>

                <!-- <p class="mb-0">Congratulation, We successfully <br> complete this service</p>
            <div class="text-center">
            <button type="button" class="btn add-review-btn" data-bs-toggle="modal" data-bs-target="#rating-modal">Add Review</button> -->
            </div>
        </div>
    </div>
</div>
<!-- Mark as completed Add Review Rating modal ended here -->
<!-- Action Priority Class Modal Start From Here -->
<div class="modal fade" id="class-priority-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content like-to-do-modal">
            <div class="modal-body p-0">
                <h5 class="text-center mb-0">What would you like to do?</h5>
                <div class="row">
                    <div class="col-md-12 services-buttons">
                        <button type="submit" class="btn extend-deadline-btn"> Attend Class</button>
                    </div>
                    <div class="col-md-12 services-buttons">
                        <a href="reschedule-classes.html">
                            <button type="button" class="btn extend-deadline-btn"> Reschedule Class</button>
                        </a>
                    </div>
                    <div class="col-md-12 services-buttons">
                        <button type="button" class="btn cancel-service-btn" data-bs-toggle="modal"
                                data-bs-target="#cancel-services-modal" id="cancel-only">Cancel Class
                        </button>
                    </div>
                    <!-- Ali -->
                    <div class="col-md-12 mb-0 services-buttons">
                        <button type="button" class="btn mb-0 mark-completed-btn" data-bs-toggle="modal"
                                data-bs-target="#mark-as-completed-modal" id="mark-as-completed">Mark as Completed
                        </button>
                    </div>
                    -
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Action Priority Class Modal Ended Here -->
<!-- Action Priority Freelace Modal Start From Here -->
<div class="modal fade" id="freelance-priority-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content like-to-do-modal">
            <div class="modal-body p-0">
                <h5 class="text-center mb-0">What would you like to do?</h5>
                <div class="row">
                    <div class="col-md-12 services-buttons">
                        <button type="button" class="btn extend-deadline-btn" data-bs-toggle="modal"
                                data-bs-target="#freelance-priority-extended-deadline-modal" id="extend-deadlines">
                            Extended Deadline
                        </button>
                    </div>
                    <div class="col-md-12 services-buttons">
                        <button type="button" class="btn cancel-service-btn" data-bs-toggle="modal"
                                data-bs-target="#cancel-services-modal" id="cancel-service">Cancel Order
                        </button>
                    </div>
                    <div class="col-md-12 mb-0 services-buttons">
                        <button type="button" class="btn mb-0 mark-completed-btn" data-bs-toggle="modal"
                                data-bs-target="#mark-as-completed-modal" id="completed-mark">Mark as Completed
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Action Priority Freelance Modal Ended here -->
<!-- Delivered orders freelance modal start from here -->
<div class="modal fade" id="freelance-priority-modal-delivered" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content like-to-do-modal">
            <div class="modal-body p-0">
                <h5 class="text-center mb-0">What would you like to do?</h5>
                <div class="row">
                    <div class="col-md-12 mb-0 services-buttons">
                        <button type="button" class="btn mb-0 mark-completed-btn" data-bs-toggle="modal"
                                data-bs-target="#mark-as-completed-modal" id="completed-mark">Mark as Completed
                        </button>
                    </div>
                    <div class="col-md-12 services-buttons" style="margin-top: 12px;">
                        <button type="button" class="btn extend-deadline-btn" data-bs-toggle="modal"
                                data-bs-target="#freelance-priority-extended-deadline-modal">Unsatisfactory - Needs
                            Improvement
                        </button>
                    </div>
                    <div class="col-md-12 services-buttons">
                        <button type="button" class="btn cancel-service-btn" data-bs-toggle="modal"
                                data-bs-target="#cancel-services-modal" id="cancel-service">Cancel Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Delivered orders freelance modal ended here -->
<!-- Action Delivered Order Modal Start From Here -->
<div class="modal fade" id="delivered-orders-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content like-to-do-modal">
            <div class="modal-body p-0">
                <h5 class="text-center mb-0">What would you like to do?</h5>
                <div class="row">
                    <div class="col-md-12 mb-0 services-buttons">
                        <button type="button" class="btn mark-completed-btn" data-bs-toggle="modal"
                                data-bs-target="#mark-as-completed-modal" id="marked-completely">Mark as Completed
                        </button>
                    </div>
                    <div class="col-md-12 services-buttons">
                        <button type="button" class="btn refund-btn" data-bs-toggle="modal"
                                data-bs-target="#cancel-services-modal" id="cancelled-only">Cancel Service only
                        </button>
                    </div>
                    <div class="col-md-12 services-buttons">
                        <button type="button" class="btn mb-0 refund-btn" data-bs-toggle="modal"
                                data-bs-target="#request-refund-modal" id="cancel-refund">Cancel Service & Request
                            refund
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Action Delivered Order Modal Ended here -->
<!-- Action Completed Order Modal Start From Here -->
<div class="modal fade" id="completed-orders-modal-rating1" tabindex="-1" aria-labelledby="exampleModalLabel1"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content like-to-do-modal">
            <div class="modal-body p-0">
                <h5 class="text-center mb-0">What would you like to do?</h5>
                <div class="row">
                    <div class="col-md-12 mb-0 services-buttons">
                        <button type="button" class="btn mark-completed-btn" data-bs-toggle="modal"
                                data-bs-target="#mark-as-completed-modal" id="give-reviews">Rate Service
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Action cancel Order Modal Start From Here -->
<div class="modal fade" id="completed-orders-modal1" tabindex="-1" aria-labelledby="exampleModalLabel1"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content like-to-do-modal">
            <div class="modal-body p-0">
                <h5 class="text-center mb-0">What would you like to do?</h5>
                <div class="row">
                    <div class="col-md-12 mb-0 services-buttons">
                        <button type="button" class="btn mark-completed-btn" data-bs-toggle="modal"
                                data-bs-target="#mark-as-completed-modal" id="give-reviews">Rate Service
                        </button>
                    </div>
                    <div class="col-md-12 services-buttons">
                        <button type="button" class="btn refund-btn" data-bs-toggle="modal"
                                data-bs-target="#request-refund-modal2" id="refund-request2">Request Refund
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- logout -->




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
            var reciver_id = $('#reciver_id').val();
            ;
            var reciver_role = 0;
            var type = 1;


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

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.43/moment-timezone-with-data.min.js"></script>


{{-- Model Show with Action Button Script Start============ --}}
<script>


    function ActionModelShow(Clicked) {

        var values = $('#' + Clicked).data('values');
        console.log(values)
        var reschedule_hours = parseInt(@json($reschedule_hours));
        var order_id = values.order_id;
        var status = values.status;
        var name = values.name;
        var title = values.title;
        var service_type = values.service_type;
        var service_role = values.service_role;
        var freelance_service = values.freelance_service;
        var lesson_type = values.lesson_type;
        var payment_type = values.payment_type;
        var all_classes = values.all_classes;
        var new_all_classes = values.new_all_classes;
        var description = values.description;
        var teacher_reschedule = values.teacher_reschedule;
        var reschedule = values.reschedule;
        var start_date = values.start_date;
        var end_date = values.end_date;
        var user_id = values.user_id;
        var price = values.finel_price;


        $('.view_date_model').hide();

        // if (freelance_service == 'Normal' || payment_type == 'Subscription') {
        //     $('.view_date_model').show();
        // }


        $('#reciver_id').val(user_id);
        $('#cancel_order_id').val(order_id);
        $('#refund_order_id').val(order_id);
        $('#dispute_order_id').val(order_id);


        // In Model Service Details Show -----

        $('#detail_name').val(name);
        $('#detail_title').val(title);

        if (payment_type == 'Subscription') {
            const startDate = moment(values.created_at);
            const endDate = moment(values.created_at).add(1, 'months');

            $('#detail_start_date').val(startDate.format('ddd MMM DD, YYYY h:mmA'));
            $('#detail_end_date').val(endDate.format('ddd MMM DD, YYYY h:mmA'));
            ;
        } else {
            $('#detail_start_date').val(moment(start_date).format('ddd MMM DD, YYYY h:mmA'));
            $('#detail_end_date').val(moment(end_date).format('ddd MMM DD, YYYY h:mmA'));
        }


        var more_text = '';
        if (service_role == 'Class') {
            if (lesson_type == 'One') {
                more_text = '( 1-to-1 )';
            } else {
                more_text = '( Group )';

            }

        } else {
            more_text = '( ' + freelance_service + ' )';
        }

        $('#detail_service').val(service_role + ' ' + service_type + ' ' + more_text);
        $('#detail_payment').val(payment_type + ' Payment');


        $('#detail_price').val(price + '$');
        document.getElementById('refund_amount').placeholder = 'max amount : $' + price;
        document.getElementById('dispute_refund_amount').placeholder = 'max amount : $' + price;


        // Cancelations Model Set Event ========
        var now = moment();
        var allAttended = true;
        var allWithinReschedule = true;
        var refundable = [];
        var nonRefundable = [];
        var cancelation_text = "";
        var listHtml = '';

        all_classes.forEach(cls => {
            const classTime = moment.tz(cls.teacher_date, cls.teacher_time_zone);
            const diffInHours = classTime.diff(now, 'hours');

            const isWithinReschedule = diffInHours <= reschedule_hours;
            const isAttended = cls.user_attend == 1;

            // Track for global decision
            if (!isAttended) allAttended = false;
            if (!isWithinReschedule) allWithinReschedule = false;

            // Sort class
            if (isAttended || isWithinReschedule) {
                nonRefundable.push(cls);
            } else {
                refundable.push(cls);
            }
        });

        // Decision logic
        if (allAttended || allWithinReschedule || freelance_service == 'Normal') {
            cancelation_text = "The buyer hasn't received any refund. If they raise an issue, they can go to the Cancellation tab, cancel the order, and dispute it to request a refund from the admin.";
            // All classes either attended or within reschedule window
            // $('#modal-dispute').modal('show');
        } else if (nonRefundable.length === 0) {
            cancelation_text = "The buyer will be refunded immediately after the cancellation.";
            // All classes outside reschedule and not attended
            // $('#modal-full-refund').modal('show');
        } else {
            cancelation_text = "Only classes starting more than " + reschedule_hours + " hours from now will be refunded to the buyer.";
            // Some refundable, some not


            nonRefundable.forEach(cls => {
                listHtml += `<li><strong>${moment(cls.teacher_date).format('ddd MMM DD, YYYY h:mmA')}</strong> - No refund</li>`;
            });
            refundable.forEach(cls => {
                listHtml += `<li><strong>${moment(cls.teacher_date).format('ddd MMM DD, YYYY h:mmA')}</strong> - Will be refunded</li>`;
            });

            // $('#modal-partial-refund').modal('show');
        }
        if (status != 0) {
            $('#partial-class-list').html(listHtml);
            $('.cancellation_text_note').html(cancelation_text);
        }

        // Cancelations Model Set Event ========


        // Events Urls On Clicks Set =============

        // Assign the onclick event to redirect to the desired URL
        $('#detail_service_accept').off('click').on('click', function () {
            window.location.href = '/active-order/' + order_id;
        });
        $('#accept-btn').off('click').on('click', function () {
            window.location.href = '/active-order/' + order_id;
        });
        $('.reschedule-btn').off('click').on('click', function () {
            window.location.href = '/teacher-reschedule/' + order_id;
        });
        $('.mark-delivered-btn').off('click').on('click', function () {
            window.location.href = '/deliver-order/' + order_id;
        });


        if (status == 0) {
            $('#detail_service_accept').show();
            $('#detail_service_reject').show();
        } else {
            $('#detail_service_accept').hide();
            $('#detail_service_reject').hide();
        }


        $('.all_classes_ul').empty();
        $('.new_all_classes_ul').empty();

        if (service_role == 'Class') {

            $('.classes_model_main').show();
            $('.date_main').hide();
            var b = 1;
            for (let i = 0; i < all_classes.length; i++) {
                var user_date = all_classes[i].teacher_date;
                var duration = all_classes[i].duration;
                duration = duration.split(':').reduce((h, m) => (+h * 60) + +m);
                user_date = user_date ? moment(user_date).format('ddd MMM DD, YYYY h:mmA') : 'Not Selected';
                if (all_classes[i].teacher_attend == 0) {
                    var user_attend = 'Not Attend';
                } else {
                    var user_attend = 'Attended';
                }


                var html = ` <li style=" display: flex ;  align-items: center; justify-content: space-around; font-size: medium;" > <b>Class ${b} :-</b>  ${user_date}  <strong >(${duration} Mins)</strong>  <strong style="color:#0072b1;">${user_attend}</strong> </li>`;

                $('.all_classes_ul').append(html);
                b = b + 1;
            }


            if (new_all_classes.length > 0) {
                $('.new_all_classes_main').show();
                var c = 1;
                for (let i = 0; i < new_all_classes.length; i++) {
                    var user_date = new_all_classes[i].teacher_date;
                    user_date = moment(user_date).format('ddd MMM DD, YYYY h:mmA');


                    var html = ` <li style=" display: flex ;  align-items: center; justify-content: space-around; font-size: medium;" > <b>Class ${c} :-</b>  ${user_date}  </li>`;

                    $('.new_all_classes_ul').append(html);
                    c = c + 1;
                }
            } else {
                $('.new_all_classes_main').hide();
            }

        } else {

            $('.classes_model_main').hide();

            if (new_all_classes.length > 0) {
                $('.date_main').show();
                $('#detail_current_date').val(all_classes[0].teacher_date);
                $('#detail_extended_date').val(new_all_classes[0].teacher_date);
            } else {
                $('.date_main').hide();
            }


        }


        // Create a temporary DOM element to parse the HTML
        var tempDiv = document.createElement("div");
        tempDiv.innerHTML = description;

// Extract the text content
        var plainText = tempDiv.textContent || tempDiv.innerText || "";

// Set the extracted text as the value of the textarea
        $('#detail_description').val(plainText);
        // In Model Service Details Show -----


        $('.actions_main').hide();


        $('#view_service').show();

        $('.view_model_btns').hide();

        if (status == 0) {
            $('.reschedule_view').show();
            if (teacher_reschedule == 1) {
                $('.view_model_btns').show();
                $('#accept').hide();

            } else {
                $('#accept').show();

            }

            $('#Pending_main').show();

        } else if (status == 1) {

            $('.all_classes_past').empty();
            var all_classes_past = values.past_classes;


            if (all_classes_past.length > 0) {
                $('.all_classes_past_heading').show();
            } else {
                $('.all_classes_past_heading').hide();
            }

            var b = 1;
            for (let i = 0; i < all_classes_past.length; i++) {
                var user_date = all_classes_past[i].teacher_date;
                user_date = moment(user_date).format('ddd MMM DD, YYYY h:mmA');
                if (all_classes_past[i].teacher_attend == 0) {
                    var user_attend = 'Not Attend';
                } else {
                    var user_attend = 'Attended';
                }


                var html = ` <li style=" display: flex ;  align-items: center; justify-content: space-around; font-size: medium;" > <b>Class ${b} :-</b>  ${user_date}  <strong style="color:#0072b1;">${user_attend}</strong> </li>`;

                $('.all_classes_past').append(html);
                b = b + 1;
            }


            if (reschedule == 1) {
                $('.reschedule_main').show();
                $('.accept-reschedule').off('click').on('click', function () {
                    window.location.href = '/accept-reschedule/' + order_id;
                });
                $('.reject-reschedule').off('click').on('click', function () {
                    window.location.href = '/reject-reschedule/' + order_id;
                });

            } else {
                $('.reschedule_main').hide();
                $('.accept-reschedule').off('click').on('click', function () {
                    window.location.href = '#';
                });
                $('.reject-reschedule').off('click').on('click', function () {
                    window.location.href = '#';
                });

            }

            var current_class = values.current_class;

            if (current_class) {
                var teacherDateTime = new Date(current_class.teacher_date.replace(' ', 'T')); // Converts to Date object
                var now = new Date();

                // Parse duration (format: "H:mm" or "HH:mm")
                var [hours, minutes] = current_class.duration.split(':').map(Number);
                var durationMs = (hours * 60 + minutes) * 60 * 1000;

                // Compute show/hide times
                var showTime = new Date(teacherDateTime.getTime() - 10 * 60 * 1000); // 10 minutes before
                var hideTime = new Date(teacherDateTime.getTime() + durationMs); // End of class
            } else {
                var showTime = null;
                var hideTime = null;
            }


            if (service_role == 'Class') {


                // Check if now is between show and hide window
                if (now >= showTime && now <= hideTime) {
                    $('#attend_class').off('click').on('click', function () {
                        window.location.href = '#';
                    });
                } else {
                    $('#attend_class').off('click').on('click', function () {
                        alert('This class can only be attended on ' + showTime);
                    });
                }


                $('#active_class_main').show();
            } else {
                if (freelance_service == 'Consultation') {

                    // Check if now is between show and hide window
                    if (now >= showTime && now <= hideTime) {
                        $('#attend_session').off('click').on('click', function () {
                            window.location.href = '#';
                        });
                    } else {
                        $('#attend_session').off('click').on('click', function () {
                            alert('Attend Session  on ' + showTime);
                        });
                    }


                    $('#active_consultation_main').show();
                } else {

                    $('#start_job').hide();
                    $('#delivered').hide();
                    if (service_type == 'Inperson') {
                        if (values.start_job == 1) {
                            $('#delivered').show();

                            $('#mark-delivered-btn').off('click').on('click', function () {
                                window.location.href = '/deliver-order/' + order_id;
                            });

                        } else {
                            $('#start_job').show();

                            $('#start-job-btn').off('click').on('click', function () {
                                window.location.href = '/start-job-active/' + order_id;
                            });

                        }
                    } else {
                        $('#delivered').show();
                        $('#deliver_order_id').val(order_id);
                        $('#mark-delivered-btn').off('click').on('click', function () {
                            $('#online-normal-deliver-model').modal('show');
                            $('#OrdersActionModel').modal('hide');
                        });


                    }
                    $('#active_normal_main').show();
                }
            }

        } else if (status == 2) {
            $('#move_order').hide();

            if (freelance_service == 'Normal') {

                $('#move-order-btn').off('click').on('click', function () {
                    window.location.href = '/back-to-active/' + order_id;
                });

                $('#move_order').show();
            }

            $('#delivered_main').show();

        } else if (status == 3) {


            // Review =====
            if (values.review == null) {

                $('.review-btn').off('click').on('click', function () {
                    toastr.options =
                        {
                            "closeButton": true,
                            "progressBar": true,
                            "timeOut": "10000", // 10 seconds
                            "extendedTimeOut": "10000" // 10 seconds
                        }
                    toastr.error("Buyer Not Give Any Review!");
                });


            } else {
                var review = values.review;

                // Set stars
                $('.star-rating-view').each(function () {
                    let starValue = $(this).data('value');
                    if (starValue <= review.rating) {
                        $(this).removeClass('fa-regular').addClass('fa-solid ');
                    } else {
                        $(this).removeClass('fa-solid ').addClass('fa-regular');
                    }
                });

                $('#feedback_comments_view').val(review.cmnt);

                $('.review-btn').off('click').on('click', function () {
                    $('#view-review-modal').modal('show');
                });
            }
            // Review =====

            $('#completed_main').show();


        } else if (status == 4) {

            // Review =====
            if (values.review == null) {
                $('.review-btn').off('click').on('click', function () {
                    toastr.options =
                        {
                            "closeButton": true,
                            "progressBar": true,
                            "timeOut": "10000", // 10 seconds
                            "extendedTimeOut": "10000" // 10 seconds
                        }
                    toastr.error("Buyer Not Give Any Review!");
                });
            } else {
                var review = values.review;

                // Set stars
                $('.star-rating-view').each(function () {
                    let starValue = $(this).data('value');
                    if (starValue <= review.rating) {
                        $(this).removeClass('fa-regular').addClass('fa-solid ');
                    } else {
                        $(this).removeClass('fa-solid ').addClass('fa-regular');
                    }
                });

                $('#feedback_comments_view').val(review.cmnt);

                $('.review-btn').off('click').on('click', function () {
                    $('#view-review-modal').modal('show');
                });
            }
            // Review =====


            var dispute = values.user_dispute;
            var action_date = values.action_date; // Format: '2025-05-15 21:31:37'
            var now = moment();
            var actionMoment = moment(action_date);

            // Check if within 72 hours from now (past or future)
            var hoursDiff = now.diff(actionMoment, 'hours');
            $('.dispute-main').hide();

            if (dispute == 1 && hoursDiff <= 48 && values.refund == 0) {
                $('.dispute-main').show();

                $('#accept-dispute-btn').off('click').on('click', function () {
                    window.location.href = '/accept-disputed-order/' + order_id;
                });

            } else {
                $('.dispute-main').hide();
            }

            $('#canceled_main').show();

        }
        $('#OrdersActionModel').modal('show');
    }


    $('#view-btn').click(function () {
        $('#OrdersActionModel').modal('hide');
        $('#sell-service-modal').modal('show');
    });

    //  Dispute Order ==========
    $('.dispute-btn').click(function () {
        var refund = 1;
        $('#disputr_order_refund').val(refund);
        document.getElementById('dispute_refund_reason').value = '';


        $('#OrdersActionModel').modal('hide');
        $('#dispute-request-refund-modal').modal('show');
    });

    $('#dispute_partial_refund').click(function () {

        $('.dispute_partial_am').show();
    });
    $('#dispute_full_refund').click(function () {

        $('.dispute_partial_am').hide();
    });
    $('#dispute_no_refund').click(function () {

        $('.dispute_partial_am').hide();
    });
    $(document).ready(function () {
        $('.dispute_partial_am').hide();
    });


    $('#dispute_refund_amount').on('focusout', function () {
        // Extract the maximum amount from the placeholder
        const maxAmount = parseFloat($(this).attr('placeholder').replace(/[^0-9.]/g, ''));
        const enteredAmount = parseFloat($(this).val());

        // Check if the entered amount is greater than the maximum
        if (enteredAmount > maxAmount) {
            alert(`Refund amount cannot be greater than $${maxAmount}.`);
            $(this).val(maxAmount); // Clear the invalid amount
        }

    });

    //  Cancel Order =========
    function CancelModelShow(Clicked) {
        var refund = $('#' + Clicked).data('refund');
        $('#cancel_order_refund').val(refund);
        $('#order_refund').val(refund);
        $('#OrdersActionModel').modal('hide');

        document.getElementById('cancel_reason').value = '';
        document.getElementById('refund_reason').value = '';


        if (refund == 1) {
            $('#request-refund-modal').modal('show');
        } else {

            $('#order-cance-modal').modal('show');

        }
    }

    $('#partial_refund').click(function () {

        $('.partial_am').show();
    });
    $('#full_refund').click(function () {

        $('.partial_am').hide();
    });


    $('#refund_amount').on('focusout', function () {
        // Extract the maximum amount from the placeholder
        const maxAmount = parseFloat($(this).attr('placeholder').replace(/[^0-9.]/g, ''));
        const enteredAmount = parseFloat($(this).val());

        // Check if the entered amount is greater than the maximum
        if (enteredAmount > maxAmount) {
            alert(`Refund amount cannot be greater than $${maxAmount}.`);
            $(this).val(maxAmount); // Clear the invalid amount
        }

    });


</script>
{{-- Model Show with Action Button Script END============ --}}
{{-- Model Show with Service Details  Script Start============ --}}
<script>
    function ShowDetailsModel(Clicked) {
        var values = $('#' + Clicked).data('values');
        var order_id = values.order_id;
        var status = values.status;
        var name = values.name;
        var title = values.title;
        var service_type = values.service_type;
        var service_role = values.service_role;
        var freelance_service = values.freelance_service;
        var lesson_type = values.lesson_type;
        var payment_type = values.payment_type;
        var all_classes = values.all_classes;
        var new_all_classes = values.new_all_classes;
        var description = values.description;
        var start_date = values.start_date;
        var end_date = values.end_date;
        var price = values.finel_price;
        var teacher_reschedule = values.teacher_reschedule;


        $('.view_date_model').hide();

        if (freelance_service == 'Normal' || payment_type == 'Subscription') {
            $('.view_date_model').show();
        }


        $('.reschedule-btn').off('click').on('click', function () {
            window.location.href = '/teacher-reschedule/' + order_id;
        });


        $('.view_model_btns').hide();
        if (status == 0) {
            $('.reschedule_view').show();
            if (teacher_reschedule != 1) {
                $('.view_model_btns').show();
            }

        }


        var more_text = '';
        if (service_role == 'Class') {
            if (lesson_type == 'One') {
                more_text = '( 1-to-1 )';
            } else {
                more_text = '( Group )';

            }

        } else {
            more_text = '( ' + freelance_service + ' )';
        }

        $('#detail_service').val(service_role + ' ' + service_type + ' ' + more_text);
        $('#detail_payment').val(payment_type + ' Payment');
        $('#detail_name').val(name);
        $('#detail_title').val(title);


        if (payment_type == 'Subscription') {
            const startDate = moment(values.created_at);
            const endDate = moment(values.created_at).add(1, 'months');

            $('#detail_start_date').val(startDate.format('ddd MMM DD, YYYY h:mmA'));
            $('#detail_end_date').val(endDate.format('ddd MMM DD, YYYY h:mmA'));
            ;
        } else {
            $('#detail_start_date').val(moment(start_date).format('ddd MMM DD, YYYY h:mmA'));
            $('#detail_end_date').val(moment(end_date).format('ddd MMM DD, YYYY h:mmA'));
        }

        $('#detail_price').val(price + '$');

        // Assign the onclick event to redirect to the desired URL
        $('#detail_service_accept').off('click').on('click', function () {
            window.location.href = '/active-order/' + order_id;
        });


        $('.all_classes_ul').empty();
        $('.new_all_classes_ul').empty();

        if (service_role == 'Class') {

            $('.classes_model_main').show();
            $('.date_main').hide();
            var b = 1;
            for (let i = 0; i < all_classes.length; i++) {
                var user_date = all_classes[i].teacher_date;
                var duration = all_classes[i].duration;
                duration = duration.split(':').reduce((h, m) => (+h * 60) + +m);
                user_date = user_date ? moment(user_date).format('ddd MMM DD, YYYY h:mmA') : 'Not Selected';
                if (all_classes[i].teacher_attend == 0) {
                    var user_attend = 'Not Attend';
                } else {
                    var user_attend = 'Attended';
                }


                var html = ` <li style=" display: flex ;  align-items: center; justify-content: space-around; font-size: medium;" > <b>Class ${b} :-</b>  ${user_date}  <strong  >(${duration} Mins)</strong>   <strong style="color:#0072b1;">${user_attend}</strong> </li>`;

                $('.all_classes_ul').append(html);
                b = b + 1;
            }


            if (new_all_classes.length > 0) {
                $('.new_all_classes_main').show();
                var c = 1;
                for (let i = 0; i < new_all_classes.length; i++) {
                    var user_date = new_all_classes[i].teacher_date;
                    user_date = moment(user_date).format('ddd MMM DD, YYYY h:mmA');


                    var html = ` <li style=" display: flex ;  align-items: center; justify-content: space-around; font-size: medium;" > <b>Class ${c} :-</b>  ${user_date}  </li>`;

                    $('.new_all_classes_ul').append(html);
                    c = c + 1;
                }
            } else {
                $('.new_all_classes_main').hide();
            }

        } else {

            $('.classes_model_main').hide();

            if (new_all_classes.length > 0) {
                $('.date_main').show();
                $('#detail_current_date').val(moment(all_classes[0].teacher_date).format('ddd MMM DD, YYYY h:mmA'));
                $('#detail_extended_date').val(moment(new_all_classes[0].teacher_date).format('ddd MMM DD, YYYY h:mmA'));
            } else {
                $('.date_main').hide();
            }


        }


        // Create a temporary DOM element to parse the HTML
        var tempDiv = document.createElement("div");
        tempDiv.innerHTML = description;

// Extract the text content
        var plainText = tempDiv.textContent || tempDiv.innerText || "";
        console.log(values);

// Set the extracted text as the value of the textarea
        $('#detail_description').val(plainText);

    }
</script>
{{-- Model Show with Service Details  Script END============ --}}
<!-- Action Completed Order Modal Ended here -->
<!-- calendar date and time picker js -->
<script>
    var app = angular.module('dateTimeApp', []);

    app.controller('dateTimeCtrl', function ($scope) {
        var ctrl = this;

        ctrl.selected_date = new Date();
        ctrl.selected_date.setHours(10);
        ctrl.selected_date.setMinutes(0);

        ctrl.updateDate = function (newdate) {

            // Do something with the returned date here.

            console.log(newdate);
        };
    });

    // Date Picker
    app.directive('datePicker', function ($timeout, $window) {
        return {
            restrict: 'AE',
            scope: {
                selecteddate: "=",
                updatefn: "&",
                open: "=",
                datepickerTitle: "@",
                customMessage: "@",
                picktime: "@",
                pickdate: "@",
                pickpast: '=',
                mondayfirst: '@'
            },
            transclude: true,
            link: function (scope, element, attrs, ctrl, transclude) {
                transclude(scope, function (clone, scope) {
                    element.append(clone);
                });

                if (!scope.selecteddate) {
                    scope.selecteddate = new Date();
                }

                if (attrs.datepickerTitle) {
                    scope.datepicker_title = attrs.datepickerTitle;
                }

                scope.days = [
                    {"long": "Sunday", "short": "Sun"},
                    {"long": "Monday", "short": "Mon"},
                    {"long": "Tuesday", "short": "Tue"},
                    {"long": "Wednesday", "short": "Wed"},
                    {"long": "Thursday", "short": "Thu"},
                    {"long": "Friday", "short": "Fri"},
                    {"long": "Saturday", "short": "Sat"},
                ];
                if (scope.mondayfirst == 'true') {
                    var sunday = scope.days[0];
                    scope.days.shift();
                    scope.days.push(sunday);
                }

                scope.monthNames = [
                    "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
                ];

                function getSelected() {
                    if (scope.currentViewDate.getMonth() == scope.localdate.getMonth()) {
                        if (scope.currentViewDate.getFullYear() == scope.localdate.getFullYear()) {
                            for (var number in scope.month) {
                                if (scope.month[number].daydate == scope.localdate.getDate()) {
                                    scope.month[number].selected = true;
                                    if (scope.mondayfirst == 'true') {
                                        if (parseInt(number) === 0) {
                                            number = 6;
                                        } else {
                                            number = number - 1;
                                        }
                                    }
                                    scope.selectedDay = scope.days[scope.month[number].dayname].long;
                                }
                            }
                        }
                    }
                }

                function getDaysInMonth() {
                    var month = scope.currentViewDate.getMonth();
                    var date = new Date(scope.currentViewDate.getFullYear(), month, 1);
                    var days = [];
                    var today = new Date();
                    while (date.getMonth() === month) {
                        var showday = true;
                        if (!scope.pickpast && date < today) {
                            showday = false;
                        }
                        if (today.getDate() == date.getDate() &&
                            today.getYear() == date.getYear() &&
                            today.getMonth() == date.getMonth()) {
                            showday = true;
                        }
                        var day = new Date(date);
                        var dayname = day.getDay();
                        var daydate = day.getDate();
                        days.push({'dayname': dayname, 'daydate': daydate, 'showday': showday});
                        date.setDate(date.getDate() + 1);
                    }
                    scope.month = days;
                }

                function initializeDate() {
                    scope.currentViewDate = new Date(scope.localdate);
                    scope.currentMonthName = function () {
                        return scope.monthNames[scope.currentViewDate.getMonth()];
                    };
                    getDaysInMonth();
                    getSelected();
                }

                // Takes selected time and date and combines them into a date object
                function getDateAndTime(localdate) {
                    var time = scope.time.split(':');
                    if (scope.timeframe == 'am' && time[0] == '12') {
                        time[0] = 0;
                    } else if (scope.timeframe == 'pm' && time[0] !== '12') {
                        time[0] = parseInt(time[0]) + 12;
                    }
                    return new Date(localdate.getFullYear(), localdate.getMonth(), localdate.getDate(), time[0], time[1]);
                }

                // Convert to UTC to account for different time zones
                function convertToUTC(localdate) {
                    var date_obj = getDateAndTime(localdate);
                    var utcdate = new Date(date_obj.getUTCFullYear(), date_obj.getUTCMonth(), date_obj.getUTCDate(), date_obj.getUTCHours(), date_obj.getUTCMinutes());
                    return utcdate;
                }

                // Convert from UTC to account for different time zones
                function convertFromUTC(utcdate) {
                    localdate = new Date(utcdate);
                    return localdate;
                }

                // Returns the format of time desired for the scheduler, Also I set the am/pm
                function formatAMPM(date) {
                    var hours = date.getHours();
                    var minutes = date.getMinutes();
                    hours >= 12 ? scope.changetime('pm') : scope.changetime('am');
                    hours = hours % 12;
                    hours = hours ? hours : 12; // the hour '0' should be '12'
                    minutes = minutes < 10 ? '0' + minutes : minutes;
                    var strTime = hours + ':' + minutes;
                    return strTime;
                }

                scope.$watch('open', function () {
                    if (scope.selecteddate !== undefined && scope.selecteddate !== null) {
                        scope.localdate = convertFromUTC(scope.selecteddate);
                    } else {
                        scope.localdate = new Date();
                        scope.localdate.setMinutes(Math.round(scope.localdate.getMinutes() / 60) * 30);
                    }
                    scope.time = formatAMPM(scope.localdate);
                    scope.setTimeBar(scope.localdate);
                    initializeDate();
                    scope.updateInputTime();
                });

                scope.selectDate = function (day) {

                    if (scope.pickdate == "true" && day.showday) {
                        for (var number in scope.month) {
                            var item = scope.month[number];
                            if (item.selected === true) {
                                item.selected = false;
                            }
                        }
                        day.selected = true;
                        scope.selectedDay = scope.days[day.dayname].long;
                        scope.localdate = new Date(scope.currentViewDate.getFullYear(), scope.currentViewDate.getMonth(), day.daydate);
                        initializeDate(scope.localdate);
                        scope.updateDate();
                    }
                };

                scope.updateDate = function () {
                    if (scope.localdate) {
                        var newdate = getDateAndTime(scope.localdate);
                        scope.updatefn({newdate: newdate});
                    }
                };

                scope.moveForward = function () {
                    scope.currentViewDate.setMonth(scope.currentViewDate.getMonth() + 1);
                    if (scope.currentViewDate.getMonth() == 12) {
                        scope.currentViewDate.setDate(scope.currentViewDate.getFullYear() + 1, 0, 1);
                    }
                    getDaysInMonth();
                    getSelected();
                };

                scope.moveBack = function () {
                    scope.currentViewDate.setMonth(scope.currentViewDate.getMonth() - 1);
                    if (scope.currentViewDate.getMonth() == -1) {
                        scope.currentViewDate.setDate(scope.currentViewDate.getFullYear() - 1, 0, 1);
                    }
                    getDaysInMonth();
                    getSelected();
                };

                scope.calcOffset = function (day, index) {
                    if (index === 0) {
                        var offset = (day.dayname * 14.2857142) + '%';
                        if (scope.mondayfirst == 'true') {
                            offset = ((day.dayname - 1) * 14.2857142) + '%';
                        }
                        return offset;
                    }
                };

                ///////////////////////////////////////////////
                // Check size of parent element, apply class //
                ///////////////////////////////////////////////
                scope.checkWidth = function (apply) {
                    var parent_width = element.parent().width();
                    if (parent_width < 620) {
                        scope.compact = true;
                    } else {
                        scope.compact = false;
                    }
                    if (apply) {
                        scope.$apply();
                    }
                };
                scope.checkWidth(false);

                //////////////////////
                // Time Picker Code //
                //////////////////////
                if (scope.picktime) {
                    var currenttime;
                    var timeline;
                    var timeline_width;
                    var timeline_container;
                    var sectionlength;

                    scope.getHours = function () {
                        var hours = new Array(11);
                        return hours;
                    };

                    scope.time = "12:00";
                    scope.hour = 12;
                    scope.minutes = 0;
                    scope.currentoffset = 0;

                    scope.timeframe = 'am';

                    scope.changetime = function (time) {
                        scope.timeframe = time;
                        scope.updateDate();
                        scope.updateInputTime();
                    };

                    scope.edittime = {
                        digits: []
                    };

                    scope.updateInputTime = function () {
                        scope.edittime.input = scope.time + ' ' + scope.timeframe;
                        scope.edittime.formatted = scope.edittime.input;
                    };

                    scope.updateInputTime();

                    function checkValidTime(number) {
                        validity = true;
                        switch (scope.edittime.digits.length) {
                            case 0:
                                if (number === 0) {
                                    validity = false;
                                }
                                break;
                            case 1:
                                if (number > 5) {
                                    validity = false;
                                } else {
                                    validity = true;
                                }
                                break;
                            case 2:
                                validity = true;
                                break;
                            case 3:
                                if (scope.edittime.digits[0] > 1) {
                                    validity = false;
                                } else if (scope.edittime.digits[1] > 2) {
                                    validity = false;
                                } else if (scope.edittime.digits[2] > 5) {
                                    validity = false;
                                } else {
                                    validity = true;
                                }
                                break;
                            case 4:
                                validity = false;
                                break;
                        }
                        return validity;
                    }

                    function formatTime() {
                        var time = "";
                        if (scope.edittime.digits.length == 1) {
                            time = "--:-" + scope.edittime.digits[0];
                        } else if (scope.edittime.digits.length == 2) {
                            time = "--:" + scope.edittime.digits[0] + scope.edittime.digits[1];
                        } else if (scope.edittime.digits.length == 3) {
                            time = "-" + scope.edittime.digits[0] + ':' + scope.edittime.digits[1] + scope.edittime.digits[2];
                        } else if (scope.edittime.digits.length == 4) {
                            time = scope.edittime.digits[0] + scope.edittime.digits[1].toString() + ':' + scope.edittime.digits[2] + scope.edittime.digits[3];
                            console.log(time);
                        }
                        return time + ' ' + scope.timeframe;
                    };

                    scope.changeInputTime = function (event) {
                        var numbers = {48: 0, 49: 1, 50: 2, 51: 3, 52: 4, 53: 5, 54: 6, 55: 7, 56: 8, 57: 9};
                        if (numbers[event.which] !== undefined) {
                            if (checkValidTime(numbers[event.which])) {
                                scope.edittime.digits.push(numbers[event.which]);
                                console.log(scope.edittime.digits);
                                scope.time_input = formatTime();
                                scope.time = numbers[event.which] + ':00';
                                scope.updateDate();
                                scope.setTimeBar();
                            }
                        } else if (event.which == 65) {
                            scope.timeframe = 'am';
                            scope.time_input = scope.time + ' ' + scope.timeframe;
                        } else if (event.which == 80) {
                            scope.timeframe = 'pm';
                            scope.time_input = scope.time + ' ' + scope.timeframe;
                        } else if (event.which == 8) {
                            scope.edittime.digits.pop();
                            scope.time_input = formatTime();
                            console.log(scope.edittime.digits);
                        }
                        scope.edittime.formatted = scope.time_input;
                        // scope.edittime.input = formatted;
                    };

                    var pad2 = function (number) {
                        return (number < 10 ? '0' : '') + number;
                    };

                    scope.moving = false;
                    scope.offsetx = 0;
                    scope.totaloffset = 0;
                    scope.initializeTimepicker = function () {
                        currenttime = $('.current-time');
                        timeline = $('.timeline');
                        if (timeline.length > 0) {
                            timeline_width = timeline[0].offsetWidth;
                        }
                        timeline_container = $('.timeline-container');
                        sectionlength = timeline_width / 24 / 6;
                    };

                    angular.element($window).on('resize', function () {
                        scope.initializeTimepicker();
                        if (timeline.length > 0) {
                            timeline_width = timeline[0].offsetWidth;
                        }
                        sectionlength = timeline_width / 24;
                        scope.checkWidth(true);
                    });

                    scope.setTimeBar = function (date) {
                        currenttime = $('.current-time');
                        var timeline_width = $('.timeline')[0].offsetWidth;
                        var hours = scope.time.split(':')[0];
                        if (hours == 12) {
                            hours = 0;
                        }
                        var minutes = scope.time.split(':')[1];
                        var minutes_offset = (minutes / 60) * (timeline_width / 12);
                        var hours_offset = (hours / 12) * timeline_width;
                        scope.currentoffset = parseInt(hours_offset + minutes_offset - 1);
                        currenttime.css({
                            transition: 'transform 0.4s ease',
                            transform: 'translateX(' + scope.currentoffset + 'px)',
                        });
                    };

                    scope.getTime = function () {
                        // get hours
                        var percenttime = (scope.currentoffset + 1) / timeline_width;
                        var hour = Math.floor(percenttime * 12);
                        var percentminutes = (percenttime * 12) - hour;
                        var minutes = Math.round((percentminutes * 60) / 5) * 5;
                        if (hour === 0) {
                            hour = 12;
                        }
                        if (minutes == 60) {
                            hour += 1;
                            minutes = 0;
                        }

                        scope.time = hour + ":" + pad2(minutes);
                        scope.updateInputTime();
                        scope.updateDate();
                    };

                    var initialized = false;

                    element.on('touchstart', function () {
                        if (!initialized) {
                            element.find('.timeline-container').on('touchstart', function (event) {
                                scope.timeSelectStart(event);
                            });
                            initialized = true;
                        }
                    });

                    scope.timeSelectStart = function (event) {
                        scope.initializeTimepicker();
                        var timepicker_container = element.find('.timepicker-container-inner');
                        var timepicker_offset = timepicker_container.offset().left;
                        if (event.type == 'mousedown') {
                            scope.xinitial = event.clientX;
                        } else if (event.type == 'touchstart') {
                            scope.xinitial = event.originalEvent.touches[0].clientX;
                        }
                        scope.moving = true;
                        scope.currentoffset = scope.xinitial - timepicker_container.offset().left;
                        scope.totaloffset = scope.xinitial - timepicker_container.offset().left;
                        console.log(timepicker_container.width());
                        if (scope.currentoffset < 0) {
                            scope.currentoffset = 0;
                        } else if (scope.currentoffset > timepicker_container.width()) {
                            scope.currentoffset = timepicker_container.width();
                        }
                        currenttime.css({
                            transform: 'translateX(' + scope.currentoffset + 'px)',
                            transition: 'none',
                            cursor: 'ew-resize',
                        });
                        scope.getTime();
                    };

                    angular.element($window).on('mousemove touchmove', function (event) {
                        if (scope.moving === true) {
                            event.preventDefault();
                            if (event.type == 'mousemove') {
                                scope.offsetx = event.clientX - scope.xinitial;
                            } else if (event.type == 'touchmove') {
                                scope.offsetx = event.originalEvent.touches[0].clientX - scope.xinitial;
                            }
                            var movex = scope.offsetx + scope.totaloffset;
                            if (movex >= 0 && movex <= timeline_width) {
                                currenttime.css({
                                    transform: 'translateX(' + movex + 'px)',
                                });
                                scope.currentoffset = movex;
                            } else if (movex < 0) {
                                currenttime.css({
                                    transform: 'translateX(0)',
                                });
                                scope.currentoffset = 0;
                            } else {
                                currenttime.css({
                                    transform: 'translateX(' + timeline_width + 'px)',
                                });
                                scope.currentoffset = timeline_width;
                            }
                            scope.getTime();
                            scope.$apply();
                        }
                    });

                    angular.element($window).on('mouseup touchend', function (event) {
                        if (scope.moving) {
                            // var roundsection = Math.round(scope.currentoffset / sectionlength);
                            // var newoffset = roundsection * sectionlength;
                            // currenttime.css({
                            //     transition: 'transform 0.25s ease',
                            //     transform: 'translateX(' + (newoffset - 1) + 'px)',
                            //     cursor: 'pointer',
                            // });
                            // scope.currentoffset = newoffset;
                            // scope.totaloffset = scope.currentoffset;
                            // $timeout(function () {
                            //     scope.getTime();
                            // }, 250);
                        }
                        scope.moving = false;
                    });

                    scope.adjustTime = function (direction) {
                        event.preventDefault();
                        scope.initializeTimepicker();
                        var newoffset;
                        if (direction == 'decrease') {
                            newoffset = scope.currentoffset - sectionlength;
                        } else if (direction == 'increase') {
                            newoffset = scope.currentoffset + sectionlength;
                        }
                        if (newoffset < 0 || newoffset > timeline_width) {
                            if (newoffset < 0) {
                                newoffset = timeline_width - sectionlength;
                            } else if (newoffset > timeline_width) {
                                newoffset = 0 + sectionlength;
                            }
                            if (scope.timeframe == 'am') {
                                scope.timeframe = 'pm';
                            } else if (scope.timeframe == 'pm') {
                                scope.timeframe = 'am';
                            }
                        }
                        currenttime.css({
                            transition: 'transform 0.4s ease',
                            transform: 'translateX(' + (newoffset - 1) + 'px)',
                        });
                        scope.currentoffset = newoffset;
                        scope.totaloffset = scope.currentoffset;
                        scope.getTime();
                    };
                }

                // End Timepicker Code //

            }
        };
    });
</script>
<!-- ================================================================================================================================================================ -->
<!-- modals show and hide in jquery -->
<script>
    $(document).ready(function () {
        $(document).on('click', '#class-reshedule', function (e) {
            e.preventDefault();
            $('#class-reshedule-modal').modal('show');
            $('#reshedule-service-modal').modal('hide');
        });

        $(document).on('click', '#reshedule-service', function (e) {
            e.preventDefault();
            $('#reshedule-service-modal').modal('show');
            $('#class-reshedule-modal').modal('hide');
        });
    });
</script>
<!-- cancel services show and hide in jquery -->
<script>
    $(document).ready(function () {
        $(document).on('click', '#cancel-service-only', function (e) {
            e.preventDefault();
            $('#class-reshedule-modal').modal('show');
            $('#cancel-services-modal').modal('hide');
        });

        $(document).on('click', '#cancel-service-only', function (e) {
            e.preventDefault();
            $('#cancel-services-modal').modal('show');
            $('#class-reshedule-modal').modal('hide');
        });
    });
</script>
<!-- successfully cancelled jquery -->
<script>
    $(document).ready(function () {
        $(document).on('click', '#successfully-cancelled', function (e) {
            e.preventDefault();
            $('#cancel-services-modal').modal('show');
            $('#successfully-cancelled-modal').modal('hide');
        });

        $(document).on('click', '#successfully-cancelled', function (e) {
            e.preventDefault();
            $('#successfully-cancelled-modal').modal('show');
            $('#cancel-services-modal').modal('hide');
        });
    });
</script>
<!-- add review jquery -->
<script>
    $(document).ready(function () {
        $(document).on('click', '#rating-review', function (e) {
            e.preventDefault();
            $('#successfully-cancelled-modal').modal('show');
            $('#add-review-modal').modal('hide');
        });

        $(document).on('click', '#rating-review', function (e) {
            e.preventDefault();
            $('#add-review-modal').modal('show');
            $('#successfully-cancelled-modal').modal('hide');
        });
    });
</script>
<!-- cancel service and request refund jquery -->
<script>
    $(document).ready(function () {
        $(document).on('click', '#cancel-service-request-refund', function (e) {
            e.preventDefault();
            $('#class-reshedule-modal').modal('show');
            // $('#request-refund-modal').modal('hide');
        });

        $(document).on('click', '#cancel-service-request-refund', function (e) {
            e.preventDefault();
            // $('#request-refund-modal').modal('show');
            $('#class-reshedule-modal').modal('hide');
        });
    });
</script>
<!-- cancel service and request refund add review jquery -->
<script>
    $(document).ready(function () {
        $(document).on('click', '#submit-cancel-services', function (e) {
            e.preventDefault();
            // $('#request-refund-modal').modal('show');
            $('#cancel-services-modal').modal('hide');
        });

        $(document).on('click', '#submit-cancel-services', function (e) {
            e.preventDefault();
            $('#cancel-services-modal').modal('show');
            // $('#request-refund-modal').modal('hide');
        });
    });
</script>
<!-- mark as completed start jquery -->
<script>
    $(document).ready(function () {
        $(document).on('click', '#mark-completed', function (e) {
            e.preventDefault();
            $('#class-reshedule-modal').modal('show');
            $('#mark-as-completed-modal').modal('hide');
        });

        $(document).on('click', '#mark-completed', function (e) {
            e.preventDefault();
            $('#mark-as-completed-modal').modal('show');
            $('#class-reshedule-modal').modal('hide');
        });
    });
</script>
<!-- mark as completed add review jquery -->
<script>
    $(document).ready(function () {
        $(document).on('click', '#add-reviews', function (e) {
            e.preventDefault();
            $('#mark-as-completed-modal').modal('show');
            $('#rating-modal').modal('hide');
        });

        $(document).on('click', '#add-reviews', function (e) {
            e.preventDefault();
            $('#rating-modal').modal('show');
            $('#mark-as-completed-modal').modal('hide');
        });
    });
</script>
<!-- freelance extend jquery -->
<script>
    $(document).ready(function () {
        $(document).on('click', '#extend-deadline', function (e) {
            e.preventDefault();
            $('#freelance-extend-modal').modal('show');
            $('#extend-deadline-modal').modal('hide');
        });

        $(document).on('click', '#extend-deadline', function (e) {
            e.preventDefault();
            $('#extend-deadline-modal').modal('show');
            $('#freelance-extend-modal').modal('hide');
        });
    });
</script>
<!-- freelance cancel service only jquery -->
<script>
    $(document).ready(function () {
        $(document).on('click', '#service-only', function (e) {
            e.preventDefault();
            $('#freelance-extend-modal').modal('show');
            $('#cancel-services-modal').modal('hide');
        });

        $(document).on('click', '#service-only', function (e) {
            e.preventDefault();
            $('#cancel-services-modal').modal('show');
            $('#freelance-extend-modal').modal('hide');
        });
    });
</script>
<!-- freelance cancel and request refund jquery -->
<script>
    $(document).ready(function () {
        $(document).on('click', '#refund-request', function (e) {
            e.preventDefault();
            $('#freelance-extend-modal').modal('show');
            // $('#request-refund-modal').modal('hide');
        });

        $(document).on('click', '#refund-request', function (e) {
            e.preventDefault();
            // $('#request-refund-modal').modal('show');
            $('#freelance-extend-modal').modal('hide');
        });
    });
</script>
<!-- freelance mark as completed jquery -->
<script>
    $(document).ready(function () {
        $(document).on('click', '#marked-completed', function (e) {
            e.preventDefault();
            $('#freelance-extend-modal').modal('show');
            $('#mark-as-completed-modal').modal('hide');
        });

        $(document).on('click', '#marked-completed', function (e) {
            e.preventDefault();
            $('#mark-as-completed-modal').modal('show');
            $('#freelance-extend-modal').modal('hide');
        });
    });
</script>
<!-- class priority jquery -->
<script>
    $(document).ready(function () {
        $(document).on('click', '#priority-reshedule', function (e) {
            e.preventDefault();
            $('#class-priority-modal').modal('show');
            $('#reshedule-service-modal').modal('hide');
        });

        $(document).on('click', '#priority-reshedule', function (e) {
            e.preventDefault();
            $('#reshedule-service-modal').modal('show');
            $('#class-priority-modal').modal('hide');
        });
    });
</script>
<!-- class priority cancel service only jquery -->
<script>
    $(document).ready(function () {
        $(document).on('click', '#cancel-only', function (e) {
            e.preventDefault();
            $('#class-priority-modal').modal('show');
            $('#cancel-services-modal').modal('hide');
        });

        $(document).on('click', '#cancel-only', function (e) {
            e.preventDefault();
            $('#cancel-services-modal').modal('show');
            $('#class-priority-modal').modal('hide');
        });
    });
</script>
<!-- class priority cancel and refund service jquery -->
<script>
    $(document).ready(function () {
        $(document).on('click', '#request-refund', function (e) {
            e.preventDefault();
            $('#class-priority-modal').modal('show');
            // $('#request-refund-modal').modal('hide');
        });

        $(document).on('click', '#request-refund', function (e) {
            e.preventDefault();
            // $('#request-refund-modal').modal('show');
            $('#class-priority-modal').modal('hide');
        });
    });
</script>
<!-- class priority mark as completed jquery -->
<script>
    $(document).ready(function () {
        $(document).on('click', '#mark-as-completed', function (e) {
            e.preventDefault();
            $('#class-priority-modal').modal('show');
            $('#mark-as-completed-modal').modal('hide');
        });

        $(document).on('click', '#mark-as-completed', function (e) {
            e.preventDefault();
            $('#mark-as-completed-modal').modal('show');
            $('#class-priority-modal').modal('hide');
        });
    });
</script>
<!-- freelance priority jquery -->
<script>
    $(document).ready(function () {
        $(document).on('click', '#cancel-service', function (e) {
            e.preventDefault();
            $('#freelance-priority-modal').modal('show');
            $('#cancel-services-modal').modal('hide');
        });

        $(document).on('click', '#cancel-service', function (e) {
            e.preventDefault();
            $('#cancel-services-modal').modal('show');
            $('#freelance-priority-modal').modal('hide');
        });
    });
</script>
<!-- freelance priority extended deadline jquery -->
<script>
    $(document).ready(function () {
        $(document).on('click', '#extend-deadlines', function (e) {
            e.preventDefault();
            $('#freelance-priority-modal').modal('show');
            $('#freelance-priority-extended-deadline-modal').modal('hide');
        });

        $(document).on('click', '#extend-deadlines', function (e) {
            e.preventDefault();
            $('#freelance-priority-extended-deadline-modal').modal('show');
            $('#freelance-priority-modal').modal('hide');
        });
    });
</script>
<!-- freelance priority cancel and refund jquery -->
<script>
    $(document).ready(function () {
        $(document).on('click', '#request-cancel', function (e) {
            e.preventDefault();
            $('#freelance-priority-modal').modal('show');
            // $('#request-refund-modal').modal('hide');
        });

        $(document).on('click', '#request-cancel', function (e) {
            e.preventDefault();
            // $('#request-refund-modal').modal('show');
            $('#freelance-priority-modal').modal('hide'); // Hide the login modal if shown
        });
    });
</script>
<!-- freelance priority mark as completed jquery -->
<script>
    $(document).ready(function () {
        $(document).on('click', '#completed-mark', function (e) {
            e.preventDefault();
            $('#freelance-priority-modal').modal('show');
            $('#mark-as-completed-modal').modal('hide');
        });

        $(document).on('click', '#completed-mark', function (e) {
            e.preventDefault();
            $('#mark-as-completed-modal').modal('show');
            $('#freelance-priority-modal').modal('hide'); // Hide the login modal if shown
        });
    });
</script>
<!-- delivered orders jquery -->
<script>
    $(document).ready(function () {
        $(document).on('click', '#marked-completely', function (e) {
            e.preventDefault();
            $('#delivered-orders-modal').modal('show');
            $('#mark-as-completed-modal').modal('hide');
        });

        $(document).on('click', '#marked-completely', function (e) {
            e.preventDefault();
            $('#mark-as-completed-modal').modal('show');
            $('#delivered-orders-modal').modal('hide'); // Hide the login modal if shown
        });
    });
</script>
<!-- delivered orders cancel service only jquery -->
/
<!-- delivered orders cancel and request refund jquery -->
<!-- <script>
  $(document).ready(function() {
      $(document).on('click', '#cancel-refund', function(e) {
          e.preventDefault();
          $('#delivered-orders-modal').modal('show');
          $('#request-refund-modal').modal('hide');
      });

      $(document).on('click', '#cancel-refund', function(e) {
          e.preventDefault();
          $('#request-refund-modal').modal('show');
          $('#delivered-orders-modal').modal('hide'); // Hide the login modal if shown
      });
  });
</script> -->
<!-- completed and cancel orders jquery -->
<script>
    $(document).ready(function () {
        $(document).on('click', '#give-reviews', function (e) {
            e.preventDefault();
            $('#completed-orders-modal').modal('show');
            $('#mark-as-completed-modal').modal('hide');
        });

        $(document).on('click', '#give-reviews', function (e) {
            e.preventDefault();
            $('#mark-as-completed-modal').modal('show');
            $('#completed-orders-modal').modal('hide');
        });
    });
</script>
<!-- delivered freelace jquery -->
<script>
    $(document).ready(function () {
        $(document).on('click', '#completed-mark', function (e) {
            e.preventDefault();
            $('#mark-as-completed-modal').modal('show');
            $('#freelance-priority-modal-delivered').modal('hide');
        });

        $(document).on('click', '#completed-mark', function (e) {
            e.preventDefault();
            $('#mark-as-completed-modal').modal('show');
            $('#freelance-priority-modal-delivered').modal('hide');
        });
    });
</script>
<!-- request refund jquery -->
<script>
    $(document).ready(function () {
        // $(document).on('click', '#request-refund-modal', function(e) {
        //     e.preventDefault();
        //     $('#request-refund-modal').modal('show');
        //     $('#completed-orders-modal').modal('hide');
        // });

        // $(document).on('click', '#request-refund-modal', function(e) {
        //     e.preventDefault();
        //     $('#completed-orders-modal').modal('show');
        //     $('#request-refund-modal').modal('hide');
        // });
    });
</script>
<!-- complete order rating modal jquery -->
<script>
    $(document).ready(function () {
        $(document).on('click', '#mark-as-completed-modal', function (e) {
            e.preventDefault();
            $('#mark-as-completed-modal').modal('show');
            $('#completed-orders-modal-rating').modal('hide');
        });

        $(document).on('click', '#mark-as-completed-modal', function (e) {
            e.preventDefault();
            $('#completed-orders-modal-rating').modal('show');
            $('#mark-as-completed-modal').modal('hide');
        });
    });
</script>
<!-- ================ side js start here=============== -->
<!-- ================ side js start End=============== -->
<!-- radio tabs js -->
<script>
    $('[name=tab]').each(function (i, d) {
        var p = $(this).prop('checked');
//   console.log(p);
        if (p) {
            $('article').eq(i)
                .addClass('on');
        }
    });

    $('[name=tab]').on('change', function () {
        var p = $(this).prop('checked');

// $(type).index(this) == nth-of-type
        var i = $('[name=tab]').index(this);

        $('article').removeClass('on');
        $('article').eq(i).addClass('on');
    });
</script>
<!-- radio buttons js start here -->
<script>
    $('input:radio:checked').parent().addClass("active");
    $('input:radio').click(function () {
        $('input:not(:checked)').parent().removeClass("active");
        $('input:checked').parent().addClass("active");
    });
</script>
<!-- radio buttons js ended here -->
<!-- tabs js start here -->
<script>
    var nestedTabSelect = (tabsElement, currentElement) => {
        const tabs = tabsElement ?? "ul.tabs";
        const currentClass = currentElement ?? "active";

        $(tabs).each(function () {
            let $active,
                $content,
                $links = $(this).find("a");

            $active = $(
                $links.filter('[href="' + location.hash + '"]')[0] || $links[0]
            );
            $active.addClass(currentClass);

            $content = $($active[0].hash);
            $content.addClass(currentClass);

            $links.not($active).each(function () {
                $(this.hash).removeClass(currentClass);
            });

            $(this).on("click", "a", function (e) {
                // Make the old tab inactive.
                $active.removeClass(currentClass);
                $content.removeClass(currentClass);

                // Update the variables with the new link and content
                $active = $(this);
                $content = $(this.hash);

                // Make the tab active.
                $active.addClass(currentClass);
                $content.addClass(currentClass);

                e.preventDefault();
            });
        });
    };

    nestedTabSelect("ul.tabs", "active");
</script>
<!-- tabs js ended here -->
<script>
    $('#mark-as-completed-modal').on('show.bs.modal', function (e) {
        $('#delivered-orders-modal').modal('hide');
    });
    $('#cancel-services-modal').on('show.bs.modal', function (e) {
        $('#delivered-orders-modal').modal('hide');
    });
    // $('#request-refund-modal').on('show.bs.modal', function (e) {
    //     $('#delivered-orders-modal').modal('hide');
    // });
    $('#completed-orders-modal-rating1').on('show.bs.modal', function (e) {
        $('#delivered-orders-modal').modal('hide');
    });


    $(document).on('click', '#give-reviews', function () {
        $('#completed-orders-modal-rating1').modal('hide');
        // Show the new modal here
        $('#new-modal-id').modal('show');
    });

    $(document).ready(function () {
        // When "Rate Service" button is clicked
        $(document).on('click', '#give-reviews', function () {
            // Close the current modal
            $('#completed-orders-modal1').modal('hide');
            // Show the new modal
            $('#new-modal-id').modal('show');
        });

    });
    $(document).ready(function () {
        // When "Request Refund" button is clicked
        $(document).on('click', '#refund-request2', function () {
            // Close the current modal
            $('#completed-orders-modal1').modal('hide');
            // Show the "Request Refund" modal
            // $('#request-refund-modal').modal('show');
        });
    });


</script>
