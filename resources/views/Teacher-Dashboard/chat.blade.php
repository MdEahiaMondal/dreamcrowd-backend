<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <!-- View Point scale to 1.0 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Animate css -->
    <link rel="stylesheet" href="assets/teacher/libs/animate/css/animate.css"/>
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="assets/teacher/libs/aos/css/aos.css"/>
    <!-- Datatable css  -->
    <link rel="stylesheet" href="assets/teacher/libs/datatable/css/datatable.css"/>
    {{-- Fav Icon --}}
    @php  $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="assets/public-site/asset/img/{{ $home->fav_icon }}" type="image/x-icon">
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

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    {{-- =======Toastr CDN ======== --}}
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- =======Toastr CDN ======== --}}
    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/teacher/asset/css/sidebar.css"/>
    <link rel="stylesheet" href="assets/teacher/asset/css/style.css">
    <link rel="stylesheet" href="assets/teacher/asset/css/Dashboard.css">
    <link rel="stylesheet" href="assets/emoji/css/emoji.css"/>
    <title>User Dashboard | </title>
</head>

<style>
    button#send_sms_button {
        background: var(--Colors-Logo-Color, #0072b1) !important;
        color: white;
    }

    .unsatisfied-btn {
        font-size: small;
        margin: 0 auto;
        margin-top: 7px;
        width: 80%;
        display: flex;
        justify-content: center;
        align-items: center;
        display: none;
    }


    .media-section .d-grid .active {
        width: 100%;
        background-color: #0072b1 !important;
        border-radius: 4px;
        border: none !important;
        outline: none !important;
        color: #fff;
        font-family: Roboto;
        font-size: 12px;
        font-style: normal;
        font-weight: 300;
        line-height: normal;
    }

    .media-section .d-grid .select1 {
        width: 100%;
        background-color: #fff;
        border-color: #fff;
        color: #ababab;
        font-family: Roboto;
        font-size: 12px;
        font-style: normal;
        font-weight: 300;
        line-height: normal;
        /* padding-right: 160px; */
    }

    .copyright {
        position: relative;
        margin-top: 80px;
        display: flex;
        justify-content: center;
    }
</style>

<body>

{{-- ===========Teacher Sidebar Start==================== --}}
<x-teacher-sidebar/>
{{-- ===========Teacher Sidebar End==================== --}}
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
                                <span class="min-title">Messages</span>
                            </div>
                        </div>
                    </div>
                    <!-- Blue MASSEGES section -->
                    <div class="user-notification">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="notify">
                                    <i class="bx bx-message-square-dots icon" title="Messages"></i>

                                    <!-- <i class="bx bx-message-square-dots icon" title="Messages"></i> -->
                                    <h2>Messages</h2>
                                </div>
                            </div>
                        </div>
                    </div>


                    @if ($chatList->count() > 0)


                        <div class="row">
                            <div class="col-xl-3 col-lg-5 col-md-12 mb-2">
                                <!-- Sidebar -->
                                <div class="card chat-side-bar">
                                    <div class="card-body">
                                        <div class="box-notif box-input">
                                            <input type="text" id="search_name_input" placeholder="Search"
                                                   class="form-control"/>
                                            <i class="fa-solid fa-magnifying-glass icon"
                                               onclick="SearchName();"></i>
                                        </div>
                                        <ul class="list-group" id="userList">
                                            @php $i = 1; @endphp
                                            @foreach ($chatList as $chat)
                                                <li class="list-group-item  @if ($i == 1) active @endif"
                                                    data-teacher-id="{{ $chat['teacher_id'] }}"
                                                    onclick="OpenChat(this.id)"
                                                    id="teacher_list_{{ $chat['teacher_id'] }}"
                                                    style="cursor: pointer;">
                                                    <a class="box-notif">
                                                        <img src="{{ $chat['profile_image'] }}" alt="Avatar"/>
                                                        @if ($chat['unseen_count'] != 0)
                                                            <span class="blue-rate"
                                                                  id="teacher_list_{{ $chat['teacher_id'] }}_unseen">{{ $chat['unseen_count'] }}</span>
                                                        @endif
                                                        <span class="onlion-icon"></span>

                                                        <div>
                                                            <p class="name">{{ $chat['teacher_name'] }}</p>
                                                            <p>{{ $chat['latest_sms'] }}</p>
                                                        </div>
                                                        <div class="time">
                                                            <span>{{ $chat['time'] }}</span>
                                                        </div>
                                                    </a>
                                                </li>
                                                @php $i++; @endphp
                                            @endforeach

                                            <!-- MSG-NOTIF -->
                                            {{-- <li class="list-group-item active" data-user="User 1" data-avatar="https://placekitten.com/40/40">
                                          <a href="#" class="box-notif">
                                            <img src="assets/user/asset/img/Ellipse 348.svg" />
                                            <span class="blue-rate">99+</span>
                                            <span class="onlion-icon"></span>
                                            <div>
                                              <p class="name">Wade Warren</p>
                                              <p>Acme Co.</p>
                                            </div>
                                            <div class="time">
                                              <span>just now</span>
                                            </div>
                                          </a>
                                        </li> --}}


                                            <!-- END MSG-NOTIF -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- CHAT-BOX-SEC -->
                            <div class="col-xl-6 col-lg-7 col-md-12 mb-2">
                                <!-- Chat Box -->

                                <div class="card chat-box-right">
                                    @if ($chatList)
                                        <div style="justify-content: left;padding-right: 10px;" class="card-header"
                                             id="chat-header">
                                            <img id="main_profile" src="{{ $profileImageMain }}" alt=""
                                                 width="50" height="50" style="border-radius: 100%;"/>
                                            <!-- <img src="" alt="User Avatar" id="user-avatar"> -->
                                            <div class="name">
                                                <p id="main_name">{{ $fullName }} </p>
                                                <p>Active Now</p>
                                            </div>
                                            <span id="selectedUserName"></span>
                                            <div id="search_div" style="margin-left: auto; display: none;">
                                                <div class="input-group ">
                                                    <input type="text" id="search_input" class="form-control"
                                                           placeholder="Search Message"
                                                           aria-label="Recipient's username"
                                                           aria-describedby="search_btn">
                                                    <span class="input-group-text" onclick="SearchMessage()"
                                                          id="search_btn"
                                                          style="background: #0072b1; color: white; cursor: pointer;">search</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div id="chat-container"
                                         class="modal-body flex-shrink-1 rounded py-2 px-3 mr-3  "
                                         style="height: 370px;overflow-y: auto; display: flex; flex-direction: column-reverse;">
                                        <div class="msg-body">
                                            <ul id="full_chat">
                                                @if ($completeChat)

                                                    @if ($hasMore)
                                                        <button class="btn btn-primary"
                                                                style="margin:0 auto; background: #0072b1;display: flex; justify-content: center;align-items: center;"
                                                                type="button" onclick="ReadMore();"
                                                                id="ReadMore">Read
                                                            More
                                                        </button>
                                                    @endif

                                                    @foreach ($completeChat as $message)
                                                        <li
                                                            class="{{ $message['sender_id'] == Auth::user()->id ? 'repaly' : 'sender' }}">
                                                            <p>{{ $message['sms'] }}</p>

                                                            @if (!empty($message['files']))
                                                                @php $files = explode(',',$message['files']);   @endphp
                                                                    <!-- Loop through and display files if there are any -->
                                                                <div class="files">
                                                                    @foreach ($files as $file)
                                                                        <a href="{{ asset('chat_media/' . Auth::user()->id . '_chat_files_' . $otheruserId . '/' . $file) }}"
                                                                           class="file-link" download download
                                                                           style="display:block; text-decoration:none; color:black; font-weight:500; margin-bottom:2px;font-size:13px; ">
                                                                            <span>{{ pathinfo($file, PATHINFO_BASENAME) }}</span>
                                                                        </a>
                                                                    @endforeach
                                                                </div>
                                                            @endif

                                                            <span class="time">{{ $message['time_ago'] }}</span>
                                                        </li>
                                                    @endforeach
                                                @endif


                                                {{-- <li class="repaly">
                                              <p> posuere eget augue sodales, aliquet posuere eros.</p>
                                              <span class="time">5 minutes ago</span>
                                            </li>
                                            <li class="sender">
                                              <p> Sit amet risus nullam eget felis eget. Dolor sed viverra ipsum </p>
                                              <span class="time">2 minutes ago</span>
                                            </li> --}}


                                            </ul>

                                        </div>
                                    </div>


                                    <div class="card-footer" id="sms_div"
                                         @if ($block != 0) style="display: none;" @endif>
                                        <div class="input-group emoji-picker-container">
                                            <input type="hidden" id="teacher_reciver_id"
                                                   value="{{ $otheruserId }}">
                                            <input type="hidden" id="search_name" value="">
                                            <input type="hidden" id="sms_limit" value="50">

                                            <textarea type="text" class="form-control" id="message-textarea"
                                                      data-emojiable="true"
                                                      placeholder="Type your message..."></textarea>

                                        </div>
                                        <div id="preview-area" class="mt-1 mb-1 row"
                                             style="border: 1px solid #ccc; position: relative; bottom: 10px;  padding: 10px; height: 80px; overflow-y: scroll; display: none;">
                                        </div>

                                        <div class="send-btns">
                                            <div class="attach">
                                                <div class="button-wrapper">
                                                        <span class="label">


                                                            <div class="input-group-append icon2">
                                                                <a id="emoji-button">
                                                                    <i class="fa-regular fa-face-smile"></i>
                                                                </a>
                                                                <a>
                                                                    <input type="file" id="fileInputAll"
                                                                           accept="*/*" style="display: none;">
                                                                    <i class="fa-solid fa-paperclip"
                                                                       onclick="document.getElementById('fileInputAll').click();"></i>

                                                                </a>

                                                                <a><input type="file" id="fileInputImages"
                                                                          accept="image/*" style="display: none;"><i
                                                                        class="fa-regular fa-images"
                                                                        onclick="document.getElementById('fileInputImages').click();"></i></a>
                                                                <a><input type="file" id="fileInputVideos"
                                                                          accept="video/*" style="display: none;"><i
                                                                        class="fa-solid fa-video"
                                                                        onclick="document.getElementById('fileInputVideos').click();"></i></a>
                                                                <button type="button" class="custom-btn"
                                                                        data-bs-target="#myModal"
                                                                        data-bs-toggle="modal">custom offer</button>
                                                                {{-- <h5 class="Safety-term" data-bs-toggle="modal" data-bs-target="#exampleModal1">Safety rules<br> for messages</h5> --}}
                                                                <!-- <h5 class="Safety-term" data-bs-toggle="modal"
                                                                   data-bs-target="#exampleModal">Safety terms<br> for messages</h5> -->


                                                                {{-- Custom Offers Creation Models Start ============ --}}

                                                                <!-- Modal -->
                                                                <div class="modal" id="myModal">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content date-modal">

                                                                            <div class="modal-body p-0">
                                                                                <div class="head w-100">
                                                                                    <h1 class="text-center">What
                                                                                        service are you interested in?
                                                                                    </h1>
                                                                                </div>
                                                                                <div class="model-heading">
                                                                                    <p class="about">Curious about our
                                                                                        offerings? Let us know your
                                                                                        interests, and we'll tailor our
                                                                                        services to meet your specific
                                                                                        needs.</p>
                                                                                    <div class="d-flex option-btn">
                                                                                        <div
                                                                                            class="d-flex radio-toolbar">
                                                                                            <div class="row">
                                                                                                <div class="col-md-6">
                                                                                                    <input
                                                                                                        type="radio"
                                                                                                        id="offerTypeClass"
                                                                                                        name="offer_type"
                                                                                                        value="Class"
                                                                                                        checked
                                                                                                        data-bs-toggle="modal"
                                                                                                        data-bs-target="#secondModal"
                                                                                                        data-bs-dismiss="modal">
                                                                                                    <label
                                                                                                        for="offerTypeClass">
                                                                                                        <p
                                                                                                            class="label mb-0">
                                                                                                            Class
                                                                                                            Booking</p>
                                                                                                        <p
                                                                                                            class="name-label mb-0">
                                                                                                            Effortless
                                                                                                            class
                                                                                                            booking for
                                                                                                            a seamless
                                                                                                            learning
                                                                                                            experience.
                                                                                                        </p>
                                                                                                    </label>

                                                                                                </div>
                                                                                                <div class="col-md-6">
                                                                                                    <input
                                                                                                        type="radio"
                                                                                                        id="offerTypeFreelance"
                                                                                                        name="offer_type"
                                                                                                        value="Freelance"
                                                                                                        data-bs-toggle="modal"
                                                                                                        data-bs-target="#thirdModal"
                                                                                                        data-bs-dismiss="modal">
                                                                                                    <label
                                                                                                        for="offerTypeFreelance">
                                                                                                        <p
                                                                                                            class="label mb-0">
                                                                                                            Freelance
                                                                                                            Booking</p>
                                                                                                        <p
                                                                                                            class="name-label mb-0">
                                                                                                            Simplify
                                                                                                            your
                                                                                                            freelancing
                                                                                                            journey with
                                                                                                            quick and
                                                                                                            hassle-free
                                                                                                            bookings.
                                                                                                        </p>

                                                                                                    </label>
                                                                                                </div>
                                                                                            </div>


                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="model-footer">
                                                                                        <button class="back-btn"
                                                                                                data-bs-dismiss="modal"
                                                                                                aria-label="Close">Back</button>
                                                                                        <button
                                                                                            class="next-btn">Next</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Modal -->
                                                                <div class="modal custom-modal" id="secondModal">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <i class="fa-solid fa-arrow-left"
                                                                                   data-bs-target="#myModal"
                                                                                   data-bs-toggle="modal"
                                                                                   data-bs-dismiss="modal"
                                                                                   style="cursor: pointer;"></i>
                                                                                <h5 class="modal-title">Select Any
                                                                                    Class Service</h5>
                                                                            </div>
                                                                            <div
                                                                                class="modal-body bg-white service-list">
                                                                                <!-- Services will be loaded dynamically via AJAX -->
                                                                                <div class="text-center p-4">
                                                                                    <p class="text-muted">Loading
                                                                                        services...</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Modal -->
                                                                <div class="modal custom-modal" id="thirdModal">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <i class="fa-solid fa-arrow-left"
                                                                                   data-bs-target="#myModal"
                                                                                   data-bs-toggle="modal"
                                                                                   data-bs-dismiss="modal"
                                                                                   style="cursor: pointer;"></i>
                                                                                <h5 class="modal-title">Select Any
                                                                                    Freelance Service</h5>
                                                                            </div>
                                                                            <div
                                                                                class="modal-body bg-white service-list">
                                                                                <!-- Services will be loaded dynamically via AJAX -->
                                                                                <div class="text-center p-4">
                                                                                    <p class="text-muted">Loading
                                                                                        services...</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Service Mode Selection Modal -->
                                                                <div class="modal custom-modal"
                                                                     id="servicemode-modal">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content date-modal">
                                                                            <div class="modal-body p-0">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">Select
                                                                                        Service Mode</h5>
                                                                                </div>
                                                                                <div class="model-heading">
                                                                                    <p class="about">Choose how
                                                                                        the service will be
                                                                                        delivered.</p>
                                                                                    <div class="d-flex option-btn">
                                                                                        <div
                                                                                            class="d-flex radio-toolbar">
                                                                                            <div class="row">
                                                                                                <div class="col-md-6">
                                                                                                    <input
                                                                                                        type="radio"
                                                                                                        id="serviceModeOnline"
                                                                                                        name="service_mode"
                                                                                                        value="Online"
                                                                                                        checked
                                                                                                        data-bs-toggle="modal"
                                                                                                        data-bs-target="#fourmodal"
                                                                                                        data-bs-dismiss="modal">
                                                                                                    <label
                                                                                                        for="serviceModeOnline">
                                                                                                        <p
                                                                                                            class="label mb-0">
                                                                                                            Online
                                                                                                        </p>
                                                                                                        <p
                                                                                                            class="name-label mb-0">
                                                                                                            Service
                                                                                                            will be
                                                                                                            delivered
                                                                                                            remotely
                                                                                                            via
                                                                                                            video
                                                                                                            call or
                                                                                                            online
                                                                                                            platform.
                                                                                                        </p>
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="col-md-6">
                                                                                                    <input
                                                                                                        type="radio"
                                                                                                        id="serviceModeInPerson"
                                                                                                        name="service_mode"
                                                                                                        value="In-person"
                                                                                                        data-bs-toggle="modal"
                                                                                                        data-bs-target="#fourmodal"
                                                                                                        data-bs-dismiss="modal">
                                                                                                    <label
                                                                                                        for="serviceModeInPerson">
                                                                                                        <p
                                                                                                            class="label mb-0">
                                                                                                            In-person
                                                                                                        </p>
                                                                                                        <p
                                                                                                            class="name-label mb-0">
                                                                                                            Service
                                                                                                            will be
                                                                                                            delivered
                                                                                                            in
                                                                                                            person
                                                                                                            at a
                                                                                                            physical
                                                                                                            location.
                                                                                                        </p>
                                                                                                    </label>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="model-footer">
                                                                                        <button class="back-btn"
                                                                                                data-bs-target="#secondModal"
                                                                                                data-bs-toggle="modal"
                                                                                                data-bs-dismiss="modal">Back</button>
                                                                                        <button
                                                                                            class="next-btn">Next</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Payment Type Selection Modal -->
                                                                <div class="modal custom-modal" id="fourmodal">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content date-modal">

                                                                            <div class="modal-body p-0">
                                                                                <div class="modal-header">

                                                                                    <h5 class="modal-title">Choose
                                                                                        how you want to get paid
                                                                                    </h5>
                                                                                </div>

                                                                                <div class="model-heading">
                                                                                    <p class="about">Get paid in
                                                                                        full once the project is
                                                                                        completed, or break it into
                                                                                        smaller
                                                                                        chunks, called milestones,
                                                                                        to get paid as you go.</p>
                                                                                    <div class="d-flex option-btn">
                                                                                        <div
                                                                                            class="d-flex radio-toolbar">
                                                                                            <div class="row">
                                                                                                <div class="col-md-6">
                                                                                                    <input
                                                                                                        type="radio"
                                                                                                        id="paymentTypeSingle"
                                                                                                        name="payment_type"
                                                                                                        value="Single"
                                                                                                        checked>
                                                                                                    <label
                                                                                                        for="paymentTypeSingle"
                                                                                                        data-bs-target="#sixModal"
                                                                                                        data-bs-toggle="modal"
                                                                                                        data-bs-dismiss="modal">
                                                                                                        <p
                                                                                                            class="label mb-0">
                                                                                                            Single
                                                                                                            Payment
                                                                                                        </p>
                                                                                                        <p
                                                                                                            class="name-label mb-0">
                                                                                                            Get full
                                                                                                            payment
                                                                                                            after
                                                                                                            completed
                                                                                                            each
                                                                                                            order at
                                                                                                            once.
                                                                                                        </p>

                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="col-md-6">
                                                                                                    <input
                                                                                                        type="radio"
                                                                                                        id="paymentTypeMilestone"
                                                                                                        name="payment_type"
                                                                                                        value="Milestone">
                                                                                                    <label
                                                                                                        for="paymentTypeMilestone"
                                                                                                        data-bs-target="#fiveModal"
                                                                                                        data-bs-toggle="modal"
                                                                                                        data-bs-dismiss="modal">
                                                                                                        <p
                                                                                                            class="label mb-0">
                                                                                                            Milestones
                                                                                                        </p>
                                                                                                        <p
                                                                                                            class="name-label mb-0">
                                                                                                            Work in
                                                                                                            gradual
                                                                                                            steps
                                                                                                            and get
                                                                                                            each
                                                                                                            completed
                                                                                                            milestone.
                                                                                                        </p>

                                                                                                    </label>
                                                                                                </div>
                                                                                            </div>


                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="model-footer">
                                                                                        <button class="back-btn"
                                                                                                data-bs-target="#servicemode-modal"
                                                                                                data-bs-toggle="modal"
                                                                                                data-bs-dismiss="modal">Back</button>
                                                                                        <button
                                                                                            class="next-btn">Next</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="modal" id="fiveModal">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content date-modal">
                                                                            <div class="modal-body p-0">
                                                                                <div class="modal-header custom-modal">

                                                                                    <h5 class="modal-title">Create
                                                                                        a milestone offer</h5>
                                                                                </div>

                                                                                <div
                                                                                    class="model-heading bg-white p-3 freelancing">

                                                                                    <p class="offer-title"><span
                                                                                            class="selected-service-title">Loading...</span>
                                                                                    </p>
                                                                                    <textarea
                                                                                        class="form-control offer-area"
                                                                                        id="offer-description"
                                                                                        name="offer"
                                                                                        placeholder="Describe your offer...."></textarea>
                                                                                    <p class="offer-title mt-3">Set
                                                                                        up your milestones or <a
                                                                                            href="#"
                                                                                            data-bs-target="#sixModal"
                                                                                            data-bs-toggle="modal"
                                                                                            data-bs-dismiss="modal">switch
                                                                                            to single payment</a>
                                                                                    </p>
                                                                                    <p class="offer-title">Divide
                                                                                        your work into pre-defined
                                                                                        steps with goals (minimum
                                                                                        $10 for each milestone).</p>

                                                                                    <!-- Milestones Container - will be populated by JavaScript -->
                                                                                    <div id="milestones-container">
                                                                                        <!-- Milestones will be rendered dynamically by custom-offers.js -->
                                                                                    </div>

                                                                                    <button type="button"
                                                                                            id="add-milestone-btn"
                                                                                            class="btn btn-primary mt-3">
                                                                                        <i
                                                                                            class="fa-solid fa-plus"></i>
                                                                                        Add Milestone
                                                                                    </button>

                                                                                    <!-- Total Amount Display -->
                                                                                    <div class="row mt-4">
                                                                                        <div class="col-md-12">
                                                                                            <h4>Total Amount: <span
                                                                                                    class="total-amount-display text-primary">$0.00</span>
                                                                                            </h4>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="rado mt-3">
                                                                                        <div class="row">
                                                                                            <div class="col-md-9">
                                                                                                <div
                                                                                                    class="form-check form-1">
                                                                                                    <input
                                                                                                        class="form-check-input"
                                                                                                        type="checkbox"
                                                                                                        id="offer-expire-checkbox">
                                                                                                    <label
                                                                                                        class="form-check-label"
                                                                                                        for="offer-expire-checkbox">
                                                                                                        Offer Expire
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="form-check">
                                                                                                    <input
                                                                                                        class="form-check-input"
                                                                                                        type="checkbox"
                                                                                                        id="request-requirements-checkbox">
                                                                                                    <label
                                                                                                        class="form-check-label"
                                                                                                        for="request-requirements-checkbox">
                                                                                                        Request for
                                                                                                        Requirements
                                                                                                    </label>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-3">
                                                                                                <div
                                                                                                    class="rectangle-desc desc-1">
                                                                                                    <select
                                                                                                        class="form-select"
                                                                                                        id="expire-days-select"
                                                                                                        disabled>
                                                                                                        <option
                                                                                                            value="1">
                                                                                                            1 day
                                                                                                        </option>
                                                                                                        <option
                                                                                                            value="2">
                                                                                                            2 days
                                                                                                        </option>
                                                                                                        <option
                                                                                                            value="3">
                                                                                                            3 days
                                                                                                        </option>
                                                                                                        <option
                                                                                                            value="5"
                                                                                                            selected>
                                                                                                            5 days
                                                                                                        </option>
                                                                                                        <option
                                                                                                            value="7">
                                                                                                            7 days
                                                                                                        </option>
                                                                                                        <option
                                                                                                            value="14">
                                                                                                            14 days
                                                                                                        </option>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="model-footer mt-4">
                                                                                        <button class="bacck-btn"
                                                                                                data-bs-target="#fourmodal"
                                                                                                data-bs-toggle="modal"
                                                                                                data-bs-dismiss="modal">Back</button>
                                                                                        <button class="neext-btn"
                                                                                                id="submit-milestone-offer-btn">Send
                                                                                            Offer</button>
                                                                                    </div>

                                                                                </div>




                                                                                <div class="model-footer">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- six modal -->
                                                                <div class="modal" id="sixModal">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content date-modal">
                                                                            <div class="modal-body p-0">
                                                                                <div class="modal-header custom-modal">

                                                                                    <h5 class="modal-title">Create
                                                                                        a single payment offer</h5>
                                                                                </div>

                                                                                <div
                                                                                    class="model-heading bg-white p-3 freelancing">

                                                                                    <p class="offer-title"><span
                                                                                            class="selected-service-title">Loading...</span>
                                                                                    </p>
                                                                                    <textarea
                                                                                        class="form-control offer-area"
                                                                                        id="offer-description"
                                                                                        placeholder="Describe your offer...."></textarea>
                                                                                    <p class="offer-title mt-3">
                                                                                        Single payment or <a
                                                                                            href="#"
                                                                                            data-bs-target="#fiveModal"
                                                                                            data-bs-toggle="modal"
                                                                                            data-bs-dismiss="modal">switch
                                                                                            to milestones</a></p>
                                                                                    <p class="offer-title">Set your
                                                                                        pricing and delivery terms
                                                                                        (minimum $10).</p>


                                                                                    <div class="row mt-3">
                                                                                        <div
                                                                                            class="col-md-4 rectangle-desc">
                                                                                            <div class="rectangle">
                                                                                                <h3>Revisions</h3>
                                                                                                <select
                                                                                                    class="form-select"
                                                                                                    id="single-payment-revisions">
                                                                                                    <option
                                                                                                        value="0">
                                                                                                        No revisions
                                                                                                    </option>
                                                                                                    <option
                                                                                                        value="1"
                                                                                                        selected>1
                                                                                                    </option>
                                                                                                    <option
                                                                                                        value="2">
                                                                                                        2</option>
                                                                                                    <option
                                                                                                        value="3">
                                                                                                        3</option>
                                                                                                    <option
                                                                                                        value="4">
                                                                                                        4</option>
                                                                                                    <option
                                                                                                        value="5">
                                                                                                        5</option>
                                                                                                </select>
                                                                                            </div>

                                                                                        </div>
                                                                                        <div
                                                                                            class="col-md-4 rectangle-desc">
                                                                                            <div class="rectangle">
                                                                                                <h3>Delivery</h3>
                                                                                                <select
                                                                                                    class="form-select"
                                                                                                    id="single-payment-delivery">
                                                                                                    <option
                                                                                                        value="1">
                                                                                                        1 day
                                                                                                    </option>
                                                                                                    <option
                                                                                                        value="2">
                                                                                                        2 days
                                                                                                    </option>
                                                                                                    <option
                                                                                                        value="3">
                                                                                                        3 days
                                                                                                    </option>
                                                                                                    <option
                                                                                                        value="5"
                                                                                                        selected>5
                                                                                                        days
                                                                                                    </option>
                                                                                                    <option
                                                                                                        value="7">
                                                                                                        1 week
                                                                                                    </option>
                                                                                                    <option
                                                                                                        value="14">
                                                                                                        2 weeks
                                                                                                    </option>
                                                                                                    <option
                                                                                                        value="30">
                                                                                                        1 month
                                                                                                    </option>
                                                                                                </select>

                                                                                            </div>

                                                                                        </div>
                                                                                        <div
                                                                                            class="col-md-4 rectangle-desc">
                                                                                            <div class="rectangle">
                                                                                                <h3>Price</h3>
                                                                                                <input type="number"
                                                                                                       class="form-control"
                                                                                                       id="single-payment-price"
                                                                                                       placeholder="Enter price"
                                                                                                       min="10"
                                                                                                       step="0.01"
                                                                                                       required>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>

                                                                                    <!-- Total Amount Display -->
                                                                                    <div class="row mt-4">
                                                                                        <div class="col-md-12">
                                                                                            <h4>Total Amount: <span
                                                                                                    class="total-amount-display text-primary">$0.00</span>
                                                                                            </h4>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="rado mt-3">
                                                                                        <div class="row">
                                                                                            <div class="col-md-9">
                                                                                                <div
                                                                                                    class="form-check form-1">
                                                                                                    <input
                                                                                                        class="form-check-input"
                                                                                                        type="checkbox"
                                                                                                        id="offer-expire-checkbox">
                                                                                                    <label
                                                                                                        class="form-check-label"
                                                                                                        for="offer-expire-checkbox">
                                                                                                        Offer Expire
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="form-check">
                                                                                                    <input
                                                                                                        class="form-check-input"
                                                                                                        type="checkbox"
                                                                                                        id="request-requirements-checkbox">
                                                                                                    <label
                                                                                                        class="form-check-label"
                                                                                                        for="request-requirements-checkbox">
                                                                                                        Request for
                                                                                                        Requirements
                                                                                                    </label>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-3">
                                                                                                <div
                                                                                                    class="rectangle-desc desc-1">

                                                                                                    <select
                                                                                                        class="form-select"
                                                                                                        id="expire-days-select"
                                                                                                        disabled>
                                                                                                        <option
                                                                                                            value="1">
                                                                                                            1 day
                                                                                                        </option>
                                                                                                        <option
                                                                                                            value="2">
                                                                                                            2 days
                                                                                                        </option>
                                                                                                        <option
                                                                                                            value="3">
                                                                                                            3 days
                                                                                                        </option>
                                                                                                        <option
                                                                                                            value="5"
                                                                                                            selected>
                                                                                                            5 days
                                                                                                        </option>
                                                                                                        <option
                                                                                                            value="7">
                                                                                                            7 days
                                                                                                        </option>
                                                                                                        <option
                                                                                                            value="14">
                                                                                                            14 days
                                                                                                        </option>
                                                                                                    </select>

                                                                                                </div>
                                                                                            </div>
                                                                                        </div>


                                                                                    </div>
                                                                                    <div class="model-footer mt-4">
                                                                                        <button class="bacck-btn"
                                                                                                data-bs-target="#fourmodal"
                                                                                                data-bs-toggle="modal"
                                                                                                data-bs-dismiss="modal">Back</button>
                                                                                        <button class="neext-btn"
                                                                                                id="submit-single-offer-btn">Send
                                                                                            Offer</button>
                                                                                    </div>

                                                                                </div>




                                                                                <div class="model-footer">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                {{-- Custom Offers Creation Models END ============ --}}


                                                            </div>
                                                        </span>

                                                    <button class="btn btn send-btn-sms float-end"
                                                            id="send_sms_button" onclick="SendSMS();">
                                                        Send
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="card-footer" id="block_div"
                                         @if ($block != 0) style="display: block;" @endif>
                                        <h5 class="Safety-term text-center">You can no longer send a message to
                                            this
                                            user</h5>
                                    </div>


                                </div>
                            </div>

                            <!-- PROFILE-BOX SEC -->
                            <div class="col-xl-3 col-lg-12 col-md-12" id="context">
                                <div class="content" id="profileId">

                                    @if (isset($fullName))

                                        <div class="Profile d-flex">
                                            <div class="card profile-data">

                                                <a href="#">
                                                    <div
                                                        class="image d-flex flex-column justify-content-center align-items-center prof-jhon">
                                                        <img id="main_profile_2" src="{{ $profileImageMain }}"
                                                             height="80" width="80"/>
                                                    </div>
                                                </a>

                                                <span id="main_name_2" class="name">{{ $fullName }}</span>
                                                <span class="text-muted">Active 2m ago</span>

                                                <div class="icons gap-3 d-flex justify-content-center mt-3">

                                                    <div class="link">
                                                        <a href="#" style="text-decoration: none">
                                                            <div class="profile-icon">
                                                                <img
                                                                    src="{{ asset('assets/user/asset/img/profileicon (2).svg') }}"
                                                                    alt=""/>
                                                            </div>
                                                            <p>Profile</p>
                                                        </a>
                                                    </div>

                                                    <div class="link">
                                                        <a onclick="ShowSearchBar();"
                                                           style="text-decoration: none; cursor: pointer;">
                                                            <div class="profile-icon">
                                                                <img
                                                                    src="{{ asset('assets/user/asset/img/Vector.svg') }}"
                                                                    alt=""/>
                                                            </div>
                                                            <p>Search</p>
                                                        </a>
                                                    </div>

                                                    <div class="link">
                                                        <a onclick="BlockUser();"
                                                           style="text-decoration: none; cursor: pointer;">
                                                            <div class="profile-icon">
                                                                <img
                                                                    src="{{ asset('assets/user/asset/img/profileicon (3).svg') }}"
                                                                    alt=""/>
                                                            </div>
                                                            <p id="block_user">
                                                                @if ($block != 0 && Auth::id() == $block_by)
                                                                    Unblock
                                                                @else
                                                                    Block
                                                                @endif
                                                            </p>
                                                        </a>
                                                    </div>

                                                </div>

                                                <div class="prof-info mt-3">
                                                    <div class="accordian-section" id="accordionExample">

                                                        <!-- MEDIA & FILES -->
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingOne">
                                                                <button class="accordion-button collapsed"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#collapseOne"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseOne">
                                                                    Media & Files
                                                                </button>
                                                            </h2>

                                                            <div id="collapseOne"
                                                                 class="accordion-collapse collapse"
                                                                 aria-labelledby="headingOne"
                                                                 data-bs-parent="#accordionExample">
                                                                <div class="accordion-body">
                                                                    <div class="media-section">

                                                                        <div class="d-grid gap-2">
                                                                            <button class="btn btn-primary active"
                                                                                    id="mediaFileBtn" type="button">
                                                                                <img
                                                                                    src="{{ asset('assets/user/asset/img/carbon_media-library-filled.svg') }}">
                                                                                Media
                                                                            </button>
                                                                        </div>

                                                                        <div class="d-grid gap-2 mt-2">
                                                                            <button class="btn btn-primary select1"
                                                                                    id="FileMediaBtn" type="button">
                                                                                <img
                                                                                    src="{{ asset('assets/user/asset/img/ph_files-fill.svg') }}">
                                                                                Files
                                                                            </button>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- PRIVACY & SUPPORT -->
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingTwo">
                                                                <button class="accordion-button collapsed"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#collapseTwo"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseTwo">
                                                                    Privacy & Support
                                                                </button>
                                                            </h2>

                                                            <div id="collapseTwo"
                                                                 class="accordion-collapse collapse"
                                                                 aria-labelledby="headingTwo"
                                                                 data-bs-parent="#accordionExample">
                                                                <div class="accordion-body">
                                                                    <button type="button" class="btn btn-primary"
                                                                            data-bs-target="#exampleModalToggle"
                                                                            data-bs-toggle="modal"
                                                                            id="accordian-select">
                                                                        <img
                                                                            src="{{ asset('assets/user/asset/img/ic_round-report.svg') }}">
                                                                        Report
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- NOTES -->
                                                        <div class="row mt-3">
                                                            <div class="col-md-6 col-sm-3">
                                                                <button class="note-add" data-bs-toggle="modal"
                                                                        data-bs-target="#exampleModal2">
                                                                    Notes
                                                                </button>
                                                            </div>

                                                            <div class="col-md-6 col-sm-3 note-add-plus-button">
                                                                <button class="note-adds" data-bs-toggle="modal"
                                                                        data-bs-target="#exampleModal2">
                                                                    <i class="fa-solid fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <div id="notes" class="row container-fluid mt-2">
                                                        </div>

                                                    </div>
                                                </div>

                                            </div> <!-- card end -->
                                        </div> <!-- Profile end -->
                                    @else
                                        <h2 class="text-center">You have not received any message from anyone yet
                                        </h2>
                                    @endif

                                </div>
                            </div>


                            @endif
                        </div>
                </div>
                <!-- tabs content start here -->

                <div class="content" id="tabsMainDiv">
                    <div class="media">
                        <div class="tabs" id="tabs">
                            <a href="#">
                                <div class="icon1">
                                    <i class="fa-solid fa-arrow-left-long" id="backBtn"></i>
                            </a>
                            <h3>Media & Files</h3>
                        </div>
                        <div class="mainBtn">
                            <button class="tablink active" id="htab1" onclick="openTab(this.id)"
                                    data-tab="tab1">Photos
                            </button>
                            <button class="tablink" id="htab2" onclick="openTab(this.id)" data-tab="tab2">
                                Videos
                            </button>
                            <button class="tablink" id="htab3" onclick="openTab(this.id)" data-tab="tab3">
                                Files
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="tab1" class="tab-content" itemid="tab-content" style="margin-top: 20px;display:none;">
                <div class="gallery">
                    <div class="container-fluid p-0">
                        <div class="grid">
                            <div class="grid-item">
                                <div class="grid-item-content card">
                                    <a href="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1200&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                       data-fancybox="gallery" class="fancybox">
                                        <img
                                            src="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                            class="card-img">
                                        <div class="overlay"></div>
                                    </a>
                                </div>
                            </div>
                            <div class="grid-item">
                                <div class="grid-item-content card">
                                    <a href="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1200&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                       data-fancybox="gallery" class="fancybox">
                                        <img
                                            src="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                            class="card-img">
                                        <div class="overlay"></div>
                                    </a>
                                </div>
                            </div>
                            <div class="grid-item">
                                <div class="grid-item-content card">
                                    <a href="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1200&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                       data-fancybox="gallery" class="fancybox">
                                        <img
                                            src="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                            class="card-img">
                                        <div class="overlay"></div>
                                    </a>
                                </div>
                            </div>
                            <div class="grid-item">
                                <div class="grid-item-content card">
                                    <a href="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1200&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                       data-fancybox="gallery" class="fancybox">
                                        <img
                                            src="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                            class="card-img">
                                        <div class="overlay"></div>
                                    </a>
                                </div>
                            </div>
                            <div class="grid-item">
                                <div class="grid-item-content card">
                                    <a href="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1200&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                       data-fancybox="gallery" class="fancybox">
                                        <img
                                            src="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                            class="card-img">
                                        <div class="overlay"></div>
                                    </a>
                                </div>
                            </div>


                            <div class="grid-item">
                                <div class="grid-item-content card">
                                    <a href="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1200&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                       data-fancybox="gallery" class="fancybox">
                                        <img
                                            src="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                            class="card-img">
                                        <div class="overlay"></div>
                                    </a>
                                </div>
                            </div>

                            <div class="grid-item">
                                <div class="grid-item-content card">
                                    <a href="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1200&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                       data-fancybox="gallery" class="fancybox">
                                        <img
                                            src="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                            class="card-img">
                                        <div class="overlay"></div>
                                    </a>
                                </div>
                            </div>

                            <div class="grid-item">
                                <div class="grid-item-content card">
                                    <a href="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1200&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                       data-fancybox="gallery" class="fancybox">
                                        <img
                                            src="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                            class="card-img">
                                        <div class="overlay"></div>
                                    </a>
                                </div>
                            </div>


                            <div class="grid-item">
                                <div class="grid-item-content card">
                                    <a href="https://images.unsplash.com/photo-1453473552141-5eb1510d09e2?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=800&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                       data-fancybox="gallery" class="fancybox">
                                        <img
                                            src="https://images.unsplash.com/photo-1453473552141-5eb1510d09e2?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                            class="card-img">
                                        <div class="overlay"></div>
                                    </a>
                                </div>
                            </div>

                            <div class="grid-item">
                                <div class="grid-item-content card">
                                    <a href="https://images.unsplash.com/photo-1514328525431-eac296c01d82?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=800&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                       data-fancybox="gallery" class="fancybox">
                                        <img
                                            src="https://images.unsplash.com/photo-1514328525431-eac296c01d82?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                            class="card-img">
                                        <div class="overlay"></div>
                                    </a>
                                </div>
                            </div>


                            <div class="grid-item">
                                <div class="grid-item-content card">
                                    <a href="https://images.unsplash.com/photo-1514328525431-eac296c01d82?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=800&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                       data-fancybox="gallery" class="fancybox">
                                        <img
                                            src="https://images.unsplash.com/photo-1514328525431-eac296c01d82?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                            class="card-img">
                                        <div class="overlay"></div>
                                    </a>
                                </div>
                            </div>
                            <div class="grid-item">
                                <div class="grid-item-content card">
                                    <a href="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1200&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                       data-fancybox="gallery" class="fancybox">
                                        <img
                                            src="https://images.unsplash.com/photo-1505863005508-18f2f0914451?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ"
                                            class="card-img">
                                        <div class="overlay"></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tab2" class="tab-content" style="margin-top: 20px;display:none;">


            </div>
            <div id="tab3" class="tab-content" style="margin-top: 20px; display:none;">


            </div>


        </div>
    </div>
    </div>
    </div>

    <div class="copyright">
        <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
    </div>
    </div>


    <!-- =========== ADD NEW FAQ's MODAL START HERE =============== -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog verification-modal">
            <div class="modal-content content-modal">
                <div class="modal-header modal-heading">
                    <h5 class="modal-title" id="exampleModalLabel">Add Notes</h5>
                </div>

                <div class="container my-3">

                    <div class="card">

                        <div class="card-body">
                            <div class="form-group">
                                <h5 class="card-titl">Add Title</h5>
                                <input type="text" class="form-control" id="addTitle"
                                       aria-describedby="title" placeholder="Enter Title">
                                <small id="emailHelp" class="form-text text-muted"></small>
                            </div>
                            <h5 class="card-titl">Add a Note</h5>
                            <div class="form-group">

                                <textarea class="form-control" id="addTxt" rows="3"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="buttons-sec">
                                        <button type="button" class="btn canceled-btn" data-bs-dismiss="modal"
                                                aria-label="Close">
                                            Cancel
                                        </button>
                                        <button type="button" class="btn added-btn " class="btn btn-primary"
                                                id="addBtn" onclick="AddNotes();">
                                            Add Notes
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- ==================================================== -->

                    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
                            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
                            crossorigin="anonymous">
                    </script>
                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
                            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
                            crossorigin="anonymous">
                    </script>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="add-button">

                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- =========== ADD NEW FAQ's MODAL ENDED HERE =============== -->
    <!-- =========== ADD NEW CATEGORY MODAL START HERE =============== -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog verification-modal">
            <div class="modal-content content-modal">
                <div class="modal-header modal-heading">
                    <h5 class="modal-title" id="exampleModalLabel">Show Notes</h5>
                </div>

                <div class="container my-3">

                    <div class="card">

                        <div class="card-body">
                            <div class="form-group">
                                <h5 class="card-titl"> Title</h5>
                                <input type="hidden" id="note_id">
                                <input type="text" class="form-control" id="showtitle"
                                       aria-describedby="title" placeholder="Enter Title">
                                <small id="emailHelp" class="form-text text-muted"></small>
                            </div>
                            <h5 class="card-titl"> Note</h5>
                            <div class="form-group">

                                <textarea class="form-control" id="showtext" rows="3"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="buttons-sec">
                                        <button type="button" class="btn canceled-btn " data-bs-dismiss="modal"
                                                aria-label="Close">
                                            Cancel
                                        </button>
                                        <button type="button" class="btn added-btn" id="addBtnedit">
                                            Update Note
                                        </button>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <!-- ==================================================== -->


                    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
                            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
                            crossorigin="anonymous">
                    </script>
                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
                            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
                            crossorigin="anonymous">
                    </script>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="add-button">

                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- =========== ADD NEW CATEGORY MODAL ENDED  HERE =============== -->
    <!-- safety terms for messages popup -->
    <!-- Button trigger modal -->


    <!-- =============================== MAIN CONTENT END HERE =========================== -->
</section>
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
     tabindex="-1">
    <div class="modal-dialog modal-dialog-centered mt-5">
        <div class="modal-content mt-2">
            <div class="card-header text-center">Report</div>
            <div class="model_popup">
                <label for="car" class="form-label">Rating</label>
                <br>
                <svg xmlns="http://www.w3.org/2000/svg" width="88" height="16" viewBox="0 0 88 16"
                     fill="none">
                    <path
                        d="M7.723 1.96796C7.82548 1.72157 8.17452 1.72157 8.277 1.96796L9.46671 4.82838C9.65392 5.27849 10.0772 5.58603 10.5631 5.62499L13.6512 5.87256C13.9172 5.89388 14.0251 6.22584 13.8224 6.39944L11.4696 8.41485C11.0994 8.73198 10.9377 9.22959 11.0508 9.70378L11.7696 12.7172C11.8316 12.9768 11.5492 13.1819 11.3215 13.0428L8.67763 11.428C8.26161 11.1739 7.73839 11.1739 7.32237 11.428L4.67855 13.0428C4.45082 13.1819 4.16844 12.9768 4.23036 12.7172L4.94917 9.70378C5.06228 9.2296 4.9006 8.73198 4.53038 8.41485L2.17759 6.39944C1.97493 6.22583 2.08279 5.89388 2.34878 5.87256L5.43685 5.62499C5.92278 5.58603 6.34608 5.27849 6.53329 4.82839L7.723 1.96796Z"
                        fill="#FFAF06" stroke="#FFAF06"/>
                    <path
                        d="M25.723 1.96796C25.8255 1.72157 26.1745 1.72157 26.277 1.96796L27.4667 4.82838C27.6539 5.27849 28.0772 5.58603 28.5631 5.62499L31.6512 5.87256C31.9172 5.89388 32.0251 6.22584 31.8224 6.39944L29.4696 8.41485C29.0994 8.73198 28.9377 9.22959 29.0508 9.70378L29.7696 12.7172C29.8316 12.9768 29.5492 13.1819 29.3215 13.0428L26.6776 11.428C26.2616 11.1739 25.7384 11.1739 25.3224 11.428L22.6786 13.0428C22.4508 13.1819 22.1684 12.9768 22.2304 12.7172L22.9492 9.70378C23.0623 9.2296 22.9006 8.73198 22.5304 8.41485L20.1776 6.39944C19.9749 6.22583 20.0828 5.89388 20.3488 5.87256L23.4369 5.62499C23.9228 5.58603 24.3461 5.27849 24.5333 4.82839L25.723 1.96796Z"
                        fill="#FFAF06" stroke="#FFAF06"/>
                    <path
                        d="M43.723 1.96796C43.8255 1.72157 44.1745 1.72157 44.277 1.96796L45.4667 4.82838C45.6539 5.27849 46.0772 5.58603 46.5631 5.62499L49.6512 5.87256C49.9172 5.89388 50.0251 6.22584 49.8224 6.39944L47.4696 8.41485C47.0994 8.73198 46.9377 9.22959 47.0508 9.70378L47.7696 12.7172C47.8316 12.9768 47.5492 13.1819 47.3215 13.0428L44.6776 11.428C44.2616 11.1739 43.7384 11.1739 43.3224 11.428L40.6786 13.0428C40.4508 13.1819 40.1684 12.9768 40.2304 12.7172L40.9492 9.70378C41.0623 9.2296 40.9006 8.73198 40.5304 8.41485L38.1776 6.39944C37.9749 6.22583 38.0828 5.89388 38.3488 5.87256L41.4369 5.62499C41.9228 5.58603 42.3461 5.27849 42.5333 4.82839L43.723 1.96796Z"
                        fill="#FFAF06" stroke="#FFAF06"/>
                    <path
                        d="M61.723 1.96796C61.8255 1.72157 62.1745 1.72157 62.277 1.96796L63.4667 4.82838C63.6539 5.27849 64.0772 5.58603 64.5631 5.62499L67.6512 5.87256C67.9172 5.89388 68.0251 6.22584 67.8224 6.39944L65.4696 8.41485C65.0994 8.73198 64.9377 9.22959 65.0508 9.70378L65.7696 12.7172C65.8316 12.9768 65.5492 13.1819 65.3215 13.0428L62.6776 11.428C62.2616 11.1739 61.7384 11.1739 61.3224 11.428L58.6786 13.0428C58.4508 13.1819 58.1684 12.9768 58.2304 12.7172L58.9492 9.70378C59.0623 9.2296 58.9006 8.73198 58.5304 8.41485L56.1776 6.39944C55.9749 6.22583 56.0828 5.89388 56.3488 5.87256L59.4369 5.62499C59.9228 5.58603 60.3461 5.27849 60.5333 4.82839L61.723 1.96796Z"
                        stroke="#FFAF06"/>
                    <path
                        d="M79.723 1.96796C79.8255 1.72157 80.1745 1.72157 80.277 1.96796L81.4667 4.82838C81.6539 5.27849 82.0772 5.58603 82.5631 5.62499L85.6512 5.87256C85.9172 5.89388 86.0251 6.22584 85.8224 6.39944L83.4696 8.41485C83.0994 8.73198 82.9377 9.22959 83.0508 9.70378L83.7696 12.7172C83.8316 12.9768 83.5492 13.1819 83.3215 13.0428L80.6776 11.428C80.2616 11.1739 79.7384 11.1739 79.3224 11.428L76.6786 13.0428C76.4508 13.1819 76.1684 12.9768 76.2304 12.7172L76.9492 9.70378C77.0623 9.2296 76.9006 8.73198 76.5304 8.41485L74.1776 6.39944C73.9749 6.22583 74.0828 5.89388 74.3488 5.87256L77.4369 5.62499C77.9228 5.58603 78.3461 5.27849 78.5333 4.82839L79.723 1.96796Z"
                        stroke="#FFAF06"/>
                </svg>
                </br>
                <label for="car" class="form-label">Review</label>
                <textarea class="form-control" list="datalistOptions" id="car"
                          placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit.Vitae ut tellus quis a euismod ut nisl, quis.Tristiquebibendum morbi vel vitae ultrices donec accumsan"
                          readonly></textarea>
                <label for="car" class="form-label">Report</label>
                <textarea class="form-control" list="datalistOptions" id="car"
                          placeholder="write something here....."></textarea>
                <button type="button" class="btn1">Cancel</button>
                <button type="button" class="btn2">submit</button>

            </div>
        </div>
    </div>
</div>

<script src="assets/teacher/libs/jquery/jquery.js"></script>
<script src="assets/teacher/libs/datatable/js/datatable.js"></script>
<script src="assets/teacher/libs/datatable/js/datatablebootstrap.js"></script>
<script src="assets/teacher/libs/select2/js/select2.min.js"></script>
<script src="assets/teacher/libs/owl-carousel/js/owl.carousel.min.js"></script>
<script src="assets/teacher/libs/aos/js/aos.js"></script>
<script src="assets/teacher/asset/js/bootstrap.min.js"></script>
<script src="assets/teacher/asset/js/script.js"></script>

</body>

</html>
<!-- ================ side js start here=============== -->


<script>
    // CHange Fetch User Types Script Start ========
    $(document).ready(function () {
        GetMessages(); // Run GetMessages when the page loads
    });

    $("#search_name_input").focusout(function () {
        var search_name = $('#search_name_input').val();
        if (search_name == "") {
            $('#search_name').val("");
            GetMessages(); // Call GetMessages after changing user_types
        }
    });

    function SearchName() {
        var search_name = $('#search_name_input').val();
        $('#search_name').val(search_name);
        GetMessages(); // Call GetMessages after changing user_types
    }

    function ReadMore() {
        var sms_limit = parseInt($('#sms_limit').val()) || 0; // Get current value, default to 0 if empty
        sms_limit += 50; // Increase by 50
        $('#sms_limit').val(sms_limit); // Set updated value back to input
        GetMessages(); // Call GetMessages after changing user_types
    }

    // CHange Fetch User Types Script END ========

    var searchCheck = false;

    // Fetch Records ======= Script Start ====

    function GetMessages() {

        var sender_id = {{ Auth::user()->id }};
        var reciver_id = $('#teacher_reciver_id').val();
        var sender_role = 1;
        var reciver_role = 0;
        var type = 1;
        var search_name = $('#search_name').val();
        var sms_limit = $('#sms_limit').val();
        var active_list = $('.list-group-item.active').attr('id');


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: '/teacher-fetch-message',
            data: {
                sender_id: sender_id,
                reciver_id: reciver_id,
                sender_role: sender_role,
                reciver_role: reciver_role,
                type: type,
                search_name: search_name,
                sms_limit: sms_limit,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function (response) {

                ShowDataFetched(response, active_list);


            },

        });


    }


    // OnPage Load Show Data Script Start =====
    function ShowDataFetched(response, active_list) {

        var authUserId = '<?php echo Auth::user()->id; ?>'; // Get authenticated user ID
        if (response.block == 0) {
            $('#sms_div').show();
            $('#block_div').hide();

        } else {
            $('#sms_div').hide();
            $('#block_div').show();

        }

        if (response.block_by != authUserId) {
            $('#block_user').html('Block');
        } else {
            $('#block_user').html('Unblock');
        }


        var img = response.profileImageMain;


        $('#main_profile').attr('src', img);
        $('#main_name').html(response.fullName);

        $('#main_profile_2').attr('src', img);
        $('#main_name_2').html(response.fullName);


        var len = 0;
        $('#userList').empty();

        len = response['chatList'].length;
        var html_div = '';

        //  Chat List Show ------ Start
        if (len > 0) {

            for (let i = 0; i < len; i++) {


                const teacher_id = response['chatList'][i].teacher_id;
                const teacher_name = response['chatList'][i].teacher_name;
                const profile_image = response['chatList'][i].profile_image;
                const latest_sms = response['chatList'][i].latest_sms;
                const time = response['chatList'][i].time;
                const unseen_count = response['chatList'][i].unseen_count;
                const active = 'teacher_list_' + teacher_id;

                if (active == active_list) {
                    var unread = 'active';
                } else {
                    var unread = '';
                }


                html_div += ' <li class="list-group-item ' + unread + '" data-teacher-id="' + teacher_id +
                    '" onclick="OpenChat(this.id)" id="teacher_list_' + teacher_id + '" style="cursor: pointer;"> ' +
                    '<a  class="box-notif"> ' +
                    ' <img src="' + profile_image + '" alt="Avatar" /> ';
                if (unseen_count != 0) {
                    html_div += ' <span class="blue-rate" id="teacher_list_' + teacher_id + '_unseen">' + unseen_count +
                        '</span>';

                }

                html_div += '  <span class="onlion-icon"></span>  <div> ' +
                    '<p class="name">' + teacher_name + '</p> ' +
                    '<p>' + latest_sms + '</p> ' +
                    '</div> ' +
                    ' <div class="time"> ' +
                    '<span>' + time + '</span> ' +
                    '</div> ' +
                    '</a>  </li>';


            }
            $("#userList").append(html_div);


        } else {
            $("#userList").html(
                `<li class="list-group-item text-center mt-2  "    style="cursor: pointer;"> <p class="name"> User's Not Found</p> </li>`
            );
        }


        //  Chat list Show ----------- END


        if (searchCheck == false) {
            // Full Chat Show -------- Start


            $('#full_chat').empty();
            $('#tab1').empty(); // Images
            $('#tab2').empty(); // Videos
            $('#tab3').empty(); // Other Files
            len_chat = response['completeChat'].length;
            var chat_div = '';


            if (len_chat > 0) {

                if (response.hasMore) {
                    $("#full_chat").append(
                        `<button class="btn btn-primary" style="margin:0 auto; background: #0072b1;display: flex; justify-content: center;align-items: center;" type="button" onclick="ReadMore();" id="ReadMore">Read More</button>`
                    );
                }

                for (let i = 0; i < len_chat; i++) {


                    const user_id = {{ Auth::user()->id }};
                    const sender_id = response['completeChat'][i].sender_id;
                    const sms = response['completeChat'][i].sms;
                    const files = response['completeChat'][i].files;
                    const time_ago = response['completeChat'][i].time_ago;


                    if (sender_id == user_id) {
                        chat_type = 'repaly';
                        justify_content = 'end';
                    } else {
                        chat_type = 'sender';
                        justify_content = 'start';
                    }

                    chat_div += ' <li class="' + chat_type + '">' +
                        '<p>' + sms + '</p>';
                    if (files != null) {
                        // Split the comma-separated files into an array
                        const fileArray = files.split(',');
                        chat_div +=
                            `<div class="files" style="display:flex;flex-wrap: wrap;justify-content: ${justify_content};align-items: center;">`;

                        // Loop through each file and generate the appropriate anchor tag
                        fileArray.forEach(file => {

                            let filePath; // Declare filePath outside the if-else block


                            if (response['OtherUserId'] == 'A') {
                                filePath =
                                    `/assets/chat_media/${user_id}_chat_files_${response['OtherUserId']}/${file}`;
                            } else {
                                filePath =
                                    `/assets/chat_media/${response['OtherUserId']}_chat_files_${user_id}/${file}`;
                            }


                            const fileName = file.split('/').pop(); // Extract the base name of the file
                            const fileExtension = file.split('.').pop().toLowerCase();

                            // Define file types for different categories
                            const imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                            const videoTypes = ['mp4', 'webm', 'ogg'];
                            const zipTypes = ['zip', 'rar', 'pdf'];


                            if (imageTypes.includes(fileExtension)) {
                                // Display image
                                chat_div += `
            <a class="p-1" href="${filePath}" target="_blank">
                <img src="${filePath}" alt="Image" style="width: 100px; height: auto; margin-bottom: 5px;">
            </a>
        `;
                            } else if (videoTypes.includes(fileExtension)) {
                                // Display video with a clickable link to open in a new tab
                                chat_div += `
         <a class="p-1" href="${filePath}" target="_blank" style="position: relative; display: inline-block;">
            <video width="200" style="pointer-events: none;">
                <source src="${filePath}" type="video/mp4">
            </video>
            <div style="
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: rgba(0, 0, 0, 0.6);
                color: white;
                font-size: 20px;
                padding: 10px 15px;
                border-radius: 50%;
                cursor: pointer;">
                ▶
            </div>
        </a>
    `;
                            } else if (zipTypes.includes(fileExtension)) {
                                // Display ZIP file link
                                chat_div += `
            <a class="p-1" href="${filePath}" class="file-link" download style="display:block; text-decoration:none; color:black; font-weight:500; margin-bottom:2px; font-size:13px;">
                <i class="fa fa-file" style="margin-right:5px;" aria-hidden="true"></i>

                <span>${fileName}</span>
            </a>
        `;
                            } else {
                                // Default case for other files (PDF, DOCX, etc.)
                                chat_div += `
            <a class="p-1" href="${filePath}" class="file-link" download style="display:block; text-decoration:none; color:black; font-weight:500; margin-bottom:2px; font-size:13px;">
                <span>${fileName}</span>
            </a>
        `;
                            }


                            // Categorize and append file type
                            if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(fileExtension)) {
                                // Image files
                                $('#tab1').append(`
                <div class="col-6">
                    <a href="${filePath}" download="${fileName}">
                        <img src="${filePath}" alt="Image" style="width:100%; height:auto; margin-bottom:10px;">
                    </a>
                </div>
            `);
                            } else if (['mp4', 'mov', 'avi', 'mkv', 'webm', 'flv'].includes(fileExtension)) {
                                // Video files
                                $('#tab2').append(`
                <div class="col-6">
                    <a href="${filePath}" download="${fileName}">
                        <video style="width:100%; height:auto; margin-bottom:10px;">
                            <source src="${filePath}" type="video/${fileExtension}">
                            Your browser does not support the video tag.
                        </video>

                    </a>
                </div>
            `);
                            } else {
                                if (fileName != "") {
                                    // Other file types
                                    $('#tab3').append(`
                <div class="col-6">
                    <a href="${filePath}" download="${fileName}" style="text-decoration:none; color:black; font-weight:500;">
                        <i class="fa fa-file" style="margin-right:5px;"></i> ${fileName}
                    </a>
                </div>
            `);
                                }

                            }
                        });

                        chat_div += '</div>';
                    }

                    chat_div += '<span class="time">' + time_ago + '</span>' +
                        '</li>';


                }
                $("#full_chat").append(chat_div);

            }


            //  Full Chat Show  ------- END
        }


        //  Show All Notes ------- Start

        var lennotes = 0;
        $("#notes").empty();
        if (response['notes'] != null) {
            lennotes = response['notes'].length;
        }

        var notes = response['notes'];

        if (lennotes > 0) {

            for (let i = 0; i < lennotes; i++) {
                var id = notes[i].id;
                var title = notes[i].title;
                var text = notes[i].text;


                var content_div = '<div id="main_div_' + id +
                    '" class="notecard my-2 mx-2 card" style="width: 18rem; height: 20px"> ' +
                    ' <div class="card-body" style="background-color:#ffff"> ' +
                    ' <h5 class="card-title" onclick="EditNotes(this.id);" id="edit_note_' + id + '" data-id="' + id +
                    '" data-title="' + title + '" data-text="' + text + '"   on>' + title + '</h5> ' +
                    ' <button id="delete_note_' + id + '" onclick="DeleteNote(this.id)" data-id="' + id +
                    '" data-main_div="main_div_' + id +
                    '" class="trash-bin"><i class="fa-solid fa-trash" aria-hidden="true"></i></button> ' +
                    '</div> ' +
                    ' </div>';


                $("#notes").append(content_div);
            }

        }

        // Show All Notes ------- END


    }

    // OnPage Load Show Data Script end =====


    GetMessages();
    setInterval(() => {
        GetMessages();
    }, 10000);


    // Fetch Records ======= Script END ====
</script>
<!-- ======= Script for Send Sms by Ajax END ====== -->

<!-- ======= Script for Send Sms Files Upload Start ====== -->
<script>
    // Upload Files ======================

    let uploadedFiles = []; // Store uploaded files

    function handleFileUpload(input) {
        const files = input.files;
        const previewArea = document.getElementById("preview-area");

        Array.from(files).forEach((file, index) => {
            uploadedFiles.push(file);

            const fileId = `file-${uploadedFiles.length - 1}`;

            // Create a file preview element
            const filePreview = document.createElement("div");
            filePreview.classList.add("col-6", "file-preview", "position-relative", "p-1");
            filePreview.id = fileId;

            if (file.type.startsWith("image/")) {
                const img = document.createElement("img");
                img.src = URL.createObjectURL(file);
                img.style.width = "100%";
                img.style.borderRadius = "5px";
                img.alt = file.name;
                filePreview.appendChild(img);
            } else if (file.type.startsWith("video/")) {
                const video = document.createElement("video");
                video.src = URL.createObjectURL(file);
                video.controls = true;
                video.style.width = "100%";
                video.style.borderRadius = "5px";
                filePreview.appendChild(video);
            } else {
                const fileIcon = document.createElement("div");
                fileIcon.textContent = file.name;
                fileIcon.style.fontSize = "14px";
                fileIcon.style.padding = "5px";
                fileIcon.style.background = "#f5f5f5";
                fileIcon.style.borderRadius = "5px";
                fileIcon.style.textAlign = "center";
                filePreview.appendChild(fileIcon);
            }

            // Add a remove button
            const removeButton = document.createElement("button");
            removeButton.textContent = "×";
            removeButton.classList.add("btn", "btn-danger", "btn-sm", "position-absolute");
            removeButton.style.top = "5px";
            removeButton.style.right = "5px";
            removeButton.style.padding = "2px 6px";
            removeButton.style.borderRadius = "50%";
            removeButton.onclick = () => removeFile(fileId, index);

            filePreview.appendChild(removeButton);
            previewArea.appendChild(filePreview);
        });

        previewArea.style.display = "flex"; // Show preview area if hidden
    }

    function removeFile(fileId, index) {
        const previewArea = document.getElementById("preview-area");
        const fileElement = document.getElementById(fileId);

        // Remove the file from uploadedFiles array
        uploadedFiles.splice(index, 1);

        // Remove the file preview element
        fileElement.remove();

        // Hide the preview area if no files remain
        if (uploadedFiles.length === 0) {
            previewArea.style.display = "none";
        } else {
            previewArea.style.display = "block";
        }
    }

    // Attach file handling to inputs
    document.getElementById("fileInputAll").addEventListener("change", function () {
        handleFileUpload(this);
    });
    document.getElementById("fileInputImages").addEventListener("change", function () {
        handleFileUpload(this);
    });
    document.getElementById("fileInputVideos").addEventListener("change", function () {
        handleFileUpload(this);
    });
</script>
<!-- ======= Script for Send Sms Files Upload END ====== -->


{{-- Open Chat Script by Ajax Start ============ --}}
<script>
    function OpenChat(Clicked) {


        $('#search_div').hide(); // Hide if already visible
        $('#search_input').val('');
        $('#sms_limit').val(50);
        searchCheck = false;


        var id = $('#' + Clicked).data('teacher-id');
        var role = {{ Auth::user()->role }};

        if ($('#' + Clicked).hasClass('active')) {
            // return false ;
        }


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: '/teacher-open-chat',
            data: {
                id: id,
                role: role,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function (response) {


                ShowChat(response, Clicked);

            },

        });

    }


    function ShowChat(response, Clicked) {

        var authUserId = '<?php echo Auth::user()->id; ?>'; // Get authenticated user ID
        if (response.block == 0) {
            $('#sms_div').show();
            $('#block_div').hide();

        } else {
            $('#sms_div').hide();
            $('#block_div').show();

        }

        if (response.block_by != authUserId) {
            $('#block_user').html('Block');
        } else {
            $('#block_user').html('Unblock');
        }


        $('.list-group-item').removeClass('active');
        $('#' + Clicked).addClass('active');
        $('#' + Clicked + '_unseen').empty();
        $('#tab1').empty(); // Images
        $('#tab2').empty(); // Videos
        $('#tab3').empty(); // Other Files
        $('#' + Clicked + '_unseen').hide();

        var img = response.profileImageMain;


        $('#main_profile').attr('src', img);
        $('#main_name').html(response.fullName);
        $('#main_profile_2').attr('src', img);
        $('#main_name_2').html(response.fullName);
        $('#teacher_reciver_id').val(response.OtherUserId);
        $('.emoji-wysiwyg-editor').empty();
        $('#message-textarea').val('');
        document.getElementById("preview-area").innerHTML = '';
        $('#preview-area').css('display', 'none');
        uploadedFiles = [];


        var len = 0;
        $("#full_chat").empty();
        if (response['completeChat']) {
            len = response['completeChat'].length;
        }
        if (len > 0) {

            if (response.hasMore) {
                $("#full_chat").append(
                    `<button class="btn btn-primary" style="margin:0 auto; background: #0072b1;display: flex; justify-content: center;align-items: center;" type="button" onclick="ReadMore();" id="ReadMore">Read More</button>`
                );

            }

            for (let i = 0; i < len; i++) {
                const user_id = {{ Auth::user()->id }};
                const sender_id = response['completeChat'][i].sender_id;
                const receiver_id = response['completeChat'][i].receiver_id;
                const sms = response['completeChat'][i].sms;
                const files = response['completeChat'][i].files;
                const time_ago = response['completeChat'][i].time_ago;

                if (sender_id == user_id) {
                    chat_type = 'repaly';
                    justify_content = 'end';
                } else {
                    chat_type = 'sender';
                    justify_content = 'start';
                }

                var chat_div = ' <li class="' + chat_type + '">' +
                    '<p>' + sms + '</p>';
                if (files != null) {
                    // Split the comma-separated files into an array
                    const fileArray = files.split(',');
                    chat_div +=
                        `<div class="files" style="display:flex;flex-wrap: wrap;justify-content: ${justify_content};align-items: center;">`;

                    // Loop through each file and generate the appropriate anchor tag
                    fileArray.forEach(file => {

                        let filePath; // Declare filePath outside the if-else block

                        if (response['OtherUserId'] == 'A') {
                            filePath =
                                `/assets/chat_media/${user_id}_chat_files_${response['OtherUserId']}/${file}`;
                        } else {
                            filePath =
                                `/assets/chat_media/${response['OtherUserId']}_chat_files_${user_id}/${file}`;
                        }
                        const fileName = file.split('/').pop(); // Extract the base name of the file
                        const fileExtension = file.split('.').pop().toLowerCase();

                        // Define file types for different categories
                        const imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                        const videoTypes = ['mp4', 'webm', 'ogg'];
                        const zipTypes = ['zip', 'rar', 'pdf'];


                        if (imageTypes.includes(fileExtension)) {
                            // Display image
                            chat_div += `
            <a class="p-1" href="${filePath}" target="_blank">
                <img src="${filePath}" alt="Image" style="width: 100px; height: auto; margin-bottom: 5px;">
            </a>
        `;
                        } else if (videoTypes.includes(fileExtension)) {
                            // Display video with a clickable link to open in a new tab
                            chat_div += `
         <a class="p-1" href="${filePath}" target="_blank" style="position: relative; display: inline-block;">
            <video width="200" style="pointer-events: none;">
                <source src="${filePath}" type="video/mp4">
            </video>
            <div style="
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: rgba(0, 0, 0, 0.6);
                color: white;
                font-size: 20px;
                padding: 10px 15px;
                border-radius: 50%;
                cursor: pointer;">
                ▶
            </div>
        </a>
    `;
                        } else if (zipTypes.includes(fileExtension)) {
                            // Display ZIP file link
                            chat_div += `
            <a class="p-1" href="${filePath}" class="file-link" download style="display:block; text-decoration:none; color:black; font-weight:500; margin-bottom:2px; font-size:13px;">
                <i class="fa fa-file" style="margin-right:5px;" aria-hidden="true"></i>

                <span>${fileName}</span>
            </a>
        `;
                        } else {
                            // Default case for other files (PDF, DOCX, etc.)
                            chat_div += `
            <a class="p-1" href="${filePath}" class="file-link" download style="display:block; text-decoration:none; color:black; font-weight:500; margin-bottom:2px; font-size:13px;">
                <span>${fileName}</span>
            </a>
        `;
                        }

                        // Categorize and append file type
                        if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(fileExtension)) {
                            // Image files
                            $('#tab1').append(`
        <div class="col-6">
            <a href="${filePath}" download="${fileName}">
                <img src="${filePath}" alt="Image" style="width:100%; height:auto; margin-bottom:10px;">
            </a>
        </div>
    `);
                        } else if (['mp4', 'mov', 'avi', 'mkv', 'webm', 'flv'].includes(fileExtension)) {
                            // Video files
                            $('#tab2').append(`
        <div class="col-6">
            <a href="${filePath}" download="${fileName}">
                <video style="width:100%; height:auto; margin-bottom:10px;">
                    <source src="${filePath}" type="video/${fileExtension}">
                    Your browser does not support the video tag.
                </video>
            </a>
        </div>
    `);
                        } else {
                            if (fileName != "") {
                                // Other file types
                                $('#tab3').append(`
        <div class="col-6">
            <a href="${filePath}" download="${fileName}" style="text-decoration:none; color:black; font-weight:500;">
                <i class="fa fa-file" style="margin-right:5px;"></i> ${fileName}
            </a>
        </div>
    `);
                            }

                        }


                    });

                    chat_div += '</div>';
                }

                chat_div += '<span class="time">' + time_ago + '</span>' +
                    '</li>';

                $("#full_chat").append(chat_div);


            }


        }


        var lennotes = 0;
        $("#notes").empty();
        if (response['notes'] != null) {
            lennotes = response['notes'].length;
        }

        var notes = response['notes'];

        if (lennotes > 0) {

            for (let i = 0; i < lennotes; i++) {
                var id = notes[i].id;
                var title = notes[i].title;
                var text = notes[i].text;


                var content_div = '<div id="main_div_' + id +
                    '" class="notecard my-2 mx-2 card" style="width: 18rem; height: 20px"> ' +
                    ' <div class="card-body" style="background-color:#ffff"> ' +
                    ' <h5 class="card-title" onclick="EditNotes(this.id);" id="edit_note_' + id + '" data-id="' + id +
                    '" data-title="' + title + '" data-text="' + text + '"   on>' + title + '</h5> ' +
                    ' <button id="delete_note_' + id + '" onclick="DeleteNote(this.id)" data-id="' + id +
                    '" data-main_div="main_div_' + id +
                    '" class="trash-bin"><i class="fa-solid fa-trash" aria-hidden="true"></i></button> ' +
                    '</div> ' +
                    ' </div>';


                $("#notes").append(content_div);
            }

        }


    }
</script>
{{-- Open Chat Script by Ajax END ============ --}}

<!-- ======= Script for Send Sms by Ajax Start ====== -->
<script>
    function SendSMS() {


        var sms = $('#message-textarea').val(); // Get the value of the textarea

        // Check if the textarea is empty or null
        if ((sms === null || sms.trim() === '') && uploadedFiles.length === 0) {
            alert("Please add a message or upload files before sending."); // Show a warning message
            return; // Exit the function
        }

        var sender_id = {{ Auth::user()->id }};
        var reciver_id = $('#teacher_reciver_id').val();
        var sender_role = {{ Auth::user()->role }};
        var type = 1;
        var sms = $('#message-textarea').val(); // assuming you get the message from textarea


        // Prepare FormData for file upload
        var formData = new FormData();
        formData.append('sms', sms);
        formData.append('sender_id', sender_id);
        formData.append('reciver_id', reciver_id);
        formData.append('sender_role', sender_role);
        formData.append('type', type);
        formData.append('_token', '{{ csrf_token() }}'); // CSRF token for Laravel security

        // Add the uploaded files to the FormData object
        uploadedFiles.forEach((file, index) => {
            formData.append(`files[${index}]`, file); // Append each file to the FormData object
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Send the AJAX request to the server
        $.ajax({
            type: "POST",
            url: '/teacher-send-message', // Your route for handling the message
            data: formData, // Pass FormData (including files and other fields)
            processData: false, // Do not process data (important for files)
            contentType: false, // Do not set content type (important for files)
            dataType: 'json',
            success: function (response) {


                // Clear the input fields and update the chat
                $('.emoji-wysiwyg-editor').empty();
                $('#message-textarea').val('');
                document.getElementById("preview-area").innerHTML = '';
                $('#preview-area').css('display', 'none');
                uploadedFiles = [];
                var files = response['chat'].files;
                var user_id = {{ Auth::user()->id }};

                var chat_div = '<li class="repaly">' +
                    '<p>' + response['chat'].sms + '</p>';
                if (files != null) {
                    // Split the comma-separated files into an array
                    const fileArray = files.split(',');
                    chat_div +=
                        '<div class="files" style="display:flex;flex-wrap: wrap;justify-content: end;align-items: center;">';

                    // Loop through each file and generate the appropriate anchor tag
                    fileArray.forEach(file => {
                        const filePath =
                            `/assets/chat_media/$${response['chat'].receiver_id}_chat_files_${user_id}/${file}`;
                        const fileName = file.split('/').pop(); // Extract the base name of the file

                        const fileExtension = file.split('.').pop().toLowerCase();

                        // Define file types for different categories
                        const imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                        const videoTypes = ['mp4', 'webm', 'ogg'];
                        const zipTypes = ['zip', 'rar', 'pdf'];


                        if (imageTypes.includes(fileExtension)) {


                            // Display image
                            chat_div += `
<a class="p-1" href="${filePath}" target="_blank">
   <img src="${filePath}" alt="Image" style="width: 100px; height: auto; margin-bottom: 5px;">
</a>
`;
                        } else if (videoTypes.includes(fileExtension)) {

                            // Display video with a clickable link to open in a new tab
                            chat_div += `
<a class="p-1" href="${filePath}" target="_blank" style="position: relative; display: inline-block;">
<video width="200" style="pointer-events: none;">
   <source src="${filePath}" type="video/mp4">
</video>
<div style="
   position: absolute;
   top: 50%;
   left: 50%;
   transform: translate(-50%, -50%);
   background: rgba(0, 0, 0, 0.6);
   color: white;
   font-size: 20px;
   padding: 10px 15px;
   border-radius: 50%;
   cursor: pointer;">
   ▶
</div>
</a>
`;
                        } else if (zipTypes.includes(fileExtension)) {

                            // Display ZIP file link
                            chat_div += `
<a class="p-1" href="${filePath}" class="file-link" download style="display:block; text-decoration:none; color:black; font-weight:500; margin-bottom:2px; font-size:13px;">
   <i class="fa fa-file" style="margin-right:5px;" aria-hidden="true"></i>

   <span>${fileName}</span>
</a>
`;
                        } else {
                            // Default case for other files (PDF, DOCX, etc.)
                            chat_div += `
<a class="p-1" href="${filePath}" class="file-link" download style="display:block; text-decoration:none; color:black; font-weight:500; margin-bottom:2px; font-size:13px;">
   <span>${fileName}</span>
</a>
`;
                        }
                    });

                    chat_div += '</div>';
                }

                chat_div += '<span class="time">' + response['chat'].time_ago + '</span>' +
                    '</li>';

                $("#full_chat").append(chat_div);

                const chatContainer = document.getElementById('chat-container');
                // chatContainer.insertAdjacentHTML('beforeend', chat_div);
                chatContainer.scrollTop = chatContainer
                    .scrollHeight; // Scroll to the bottom of the chat container
            },
            error: function (xhr, status, error) {
                console.log(error); // Log errors if any
            }
        });


    }
</script>


{{-- Add Notes Script Start ====== --}}
<script>
    function AddNotes() {
        var title = $('#addTitle').val();
        var text = $('#addTxt').val();
        var other = $('#teacher_reciver_id').val();

        if (title === null && (text === null || text.trim() === '')) {
            alert("Please write something for add note."); // Show a warning message
            return; // Exit the function
        }


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: '/add-notes',
            data: {
                title: title,
                text: text,
                other: other,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function (response) {
                $('#exampleModal2').modal('hide');
                ShowNotes(response);

            },

        });


    }

    // Show Notes Function ===

    function ShowNotes(response) {


        var len = 0;
        $("#notes").empty();
        if (response['notes'] != null) {
            len = response['notes'].length;
        }

        var notes = response['notes'];
        if (len > 0) {

            for (let i = 0; i < len; i++) {
                var id = notes[i].id;
                var title = notes[i].title;
                var text = notes[i].text;

                var content_div = '<div id="main_div_' + id +
                    '" class="notecard my-2 mx-2 card" style="width: 18rem; height: 20px"> ' +
                    ' <div class="card-body" style="background-color:#ffff"> ' +
                    ' <h5 class="card-title" onclick="EditNotes(this.id);" id="edit_note_' + id + '" data-id="' + id +
                    '" data-title="' + title + '" data-text="' + text + '"   on>' + title + '</h5> ' +
                    ' <button id="delete_note_' + id + '" onclick="DeleteNote(this.id)" data-id="' + id +
                    '" data-main_div="main_div_' + id +
                    '" class="trash-bin"><i class="fa-solid fa-trash" aria-hidden="true"></i></button> ' +
                    '</div> ' +
                    ' </div>';


                $("#notes").append(content_div);
            }

        }


    }


    function DeleteNote(Clicked) {
        var id = $('#' + Clicked).data('id');
        var main_div = $('#' + Clicked).data('main_div');


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: '/delete-notes',
            data: {
                id: id,
                main_div: main_div,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function (response) {

                if (response.success) {
                    $('#' + main_div).remove();
                } else {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "timeOut": "10000", // 10 seconds
                        "extendedTimeOut": "4410000" // 10 seconds
                    }
                    toastr.error(response.message);
                }


            },

        });


    }

    function EditNotes(Clicked) {
        var id = $('#' + Clicked).data('id');
        var title = $('#' + Clicked).data('title');
        var text = $('#' + Clicked).data('text');
        $('#showtitle').val(title);
        $('#showtext').val(text);
        $('#note_id').val(id);

        $('#exampleModal3').modal('show');
    }


    $('#addBtnedit').click(function () {
        var id = $('#note_id').val();
        var title = $('#showtitle').val();
        var text = $('#showtext').val();

        if (title === null && (text === null || text.trim() === '')) {
            alert("Please write something for add note."); // Show a warning message
            return; // Exit the function
        }


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: '/update-notes',
            data: {
                title: title,
                text: text,
                id: id,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function (response) {
                $('#exampleModal3').modal('hide');


                if (response.success) {
                    $("#main_div_" + response.notes.id).empty();

                    var content_div = ` <div class="card-body" style="background-color:#ffff">
                      <h5 class="card-title" onclick="EditNotes(this.id);" id="edit_note_${response.notes.id}" data-id="${response.notes.id}" data-title="${response.notes.title}" data-text="${response.notes.text}"   on>${response.notes.title}</h5>
                      <button id="delete_note_${response.notes.id}" onclick="DeleteNote(this.id)" data-id="${response.notes.id}" data-main_div="main_div_${response.notes.id}" class="trash-bin"><i class="fa-solid fa-trash" aria-hidden="true"></i></button>
                      </div>`;
                    $("#main_div_" + response.notes.id).html(content_div);
                } else {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "timeOut": "10000", // 10 seconds
                        "extendedTimeOut": "4410000" // 10 seconds
                    }
                    toastr.error(response.message);
                }


            },

        });


    });
</script>
{{-- Add Notes Script END ====== --}}


{{-- Block User Script Start ====== --}}
<script>
    function BlockUser() {

        var block_id = $('#teacher_reciver_id').val();
        if (block_id == 'A') {
            alert('You are not able to block admin!');
            return false;
        }


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: '/block-user',
            data: {
                block_id: block_id,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function (response) {
                console.log(response.value);

                if (response.error) {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "timeOut": "10000", // 10 seconds
                        "extendedTimeOut": "4410000" // 10 seconds
                    }
                    toastr.error(response.error);
                } else {

                    if (response.block == 0) {
                        $('#sms_div').css('display', 'block');
                        $('#block_div').css('display', 'none');
                        $('#block_user').html('Block');
                    } else {
                        $('#sms_div').css('display', 'none');
                        $('#block_div').css('display', 'block');
                        $('#block_user').html('UnBlock');
                    }


                    toastr.options = {
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
{{-- Block User Script END ====== --}}


{{-- Search Message Script END ====== --}}
<script>
    // Show Search Bar Function -------
    function ShowSearchBar() {
        // $('#search_div').toggle(); // Toggle display between block and none

        if ($('#search_div').is(':visible')) {
            $('#search_div').hide(); // Hide if already visible
            $('#search_input').val('');
            searchCheck = false;
            // SearchMessage();
        } else {
            $('#search_div').show(); // Show if hidden
        }

    }


    // Search Message Script Start -----------
    function SearchMessage() {
        var id = $('#teacher_reciver_id').val();
        var key = $('#search_input').val();
        searchCheck = true;


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: '/search-message',
            data: {
                id: id,
                key: key,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function (response) {

                // Show Fetched Messages By sms Start ----

                var len = 0;
                $("#full_chat").empty();
                if (response['completeChat']) {
                    len = response['completeChat'].length;
                }
                if (len > 0) {

                    for (let i = 0; i < len; i++) {
                        const user_id = {{ Auth::user()->id }};
                        const sender_id = response['completeChat'][i].sender_id;
                        const receiver_id = response['completeChat'][i].receiver_id;
                        const sms = response['completeChat'][i].sms;
                        const files = response['completeChat'][i].files;
                        const time_ago = response['completeChat'][i].time_ago;

                        if (sender_id == user_id) {
                            chat_type = 'repaly';
                            justify_content = 'end';
                        } else {
                            chat_type = 'sender';
                            justify_content = 'start';
                        }

                        var chat_div = ' <li class="' + chat_type + '">' +
                            '<p>' + sms + '</p>';
                        if (files != null) {
                            // Split the comma-separated files into an array
                            const fileArray = files.split(',');
                            chat_div +=
                                `<div class="files" style="display:flex;flex-wrap: wrap;justify-content: ${justify_content};align-items: center;">`;

                            // Loop through each file and generate the appropriate anchor tag
                            fileArray.forEach(file => {
                                let filePath; // Declare filePath outside the if-else block

                                if (response['OtherUserId'] == 'A') {
                                    filePath =
                                        `/assets/chat_media/${user_id}_chat_files_${response['OtherUserId']}/${file}`;
                                } else {
                                    filePath =
                                        `/assets/chat_media/${response['OtherUserId']}_chat_files_${user_id}/${file}`;
                                }
                                const fileName = file.split('/')
                                    .pop(); // Extract the base name of the file
                                const fileExtension = file.split('.').pop().toLowerCase();

                                // Define file types for different categories
                                const imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                                const videoTypes = ['mp4', 'webm', 'ogg'];
                                const zipTypes = ['zip', 'rar', 'pdf'];


                                if (imageTypes.includes(fileExtension)) {
                                    // Display image
                                    chat_div += `
            <a class="p-1" href="${filePath}" target="_blank">
                <img src="${filePath}" alt="Image" style="width: 100px; height: auto; margin-bottom: 5px;">
            </a>
        `;
                                } else if (videoTypes.includes(fileExtension)) {
                                    // Display video with a clickable link to open in a new tab
                                    chat_div += `
         <a class="p-1" href="${filePath}" target="_blank" style="position: relative; display: inline-block;">
            <video width="200" style="pointer-events: none;">
                <source src="${filePath}" type="video/mp4">
            </video>
            <div style="
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: rgba(0, 0, 0, 0.6);
                color: white;
                font-size: 20px;
                padding: 10px 15px;
                border-radius: 50%;
                cursor: pointer;">
                ▶
            </div>
        </a>
    `;
                                } else if (zipTypes.includes(fileExtension)) {
                                    // Display ZIP file link
                                    chat_div += `
            <a class="p-1" href="${filePath}" class="file-link" download style="display:block; text-decoration:none; color:black; font-weight:500; margin-bottom:2px; font-size:13px;">
                <i class="fa fa-file" style="margin-right:5px;" aria-hidden="true"></i>

                <span>${fileName}</span>
            </a>
        `;
                                } else {
                                    // Default case for other files (PDF, DOCX, etc.)
                                    chat_div += `
            <a class="p-1" href="${filePath}" class="file-link" download style="display:block; text-decoration:none; color:black; font-weight:500; margin-bottom:2px; font-size:13px;">
                <span>${fileName}</span>
            </a>
        `;
                                }


                            });

                            chat_div += '</div>';
                        }

                        chat_div += '<span class="time">' + time_ago + '</span>' +
                            '</li>';

                        $("#full_chat").append(chat_div);


                    }


                } else {
                    $("#full_chat").append(`<h5  class="Safety-term text-center" >No Record Found</h5>`);
                }

                // Show Fetched Messages By sms END ----


            },

        });


    }

    // Search Message Script END -----------
</script>
{{-- Search Message Script Start ====== --}}





<!-- Emoji SelectorCDNS -->
<script src="assets/emoji/js/config.min.js"></script>
<script src="assets/emoji/js/emoji-picker.min.js"></script>
<script src="assets/emoji/js/jquery.emojiarea.min.js"></script>
<script src="assets/emoji/js/util.min.js"></script>


<!-- js for tabs  -->
<script>
    function toggleTabs() {
        var content = document.querySelector('.content');
        var tabs = document.querySelector('.tabs');
        var tabContents = document.querySelectorAll('.tab-content');

        if (tabs.style.display === 'none') {
            tabs.style.display = 'block';
            content.style.display = 'none';
            for (var i = 0; i < tabContents.length; i++) {
                tabContents[i].style.display = 'none';
            }
        } else {
            tabs.style.display = 'none';
            content.style.display = 'block';
            for (var i = 0; i < tabContents.length; i++) {
                tabContents[i].style.display = 'none';
            }
        }
    }

    function openTab(clicked) {
        // Remove active class from all tab links
        $('.tablink').removeClass('active');

        // Add active class to the clicked tab link
        $('#' + clicked).addClass('active');

        // Get the target tab's ID from the data attribute
        var targetTab = $('#' + clicked).data('tab');

        // Hide all tab contents
        $('.tab-content').hide();

        // Show the target tab content
        $('#' + targetTab).show();
    }
</script>


<!-- /////////////////////////2nd js ///////////////////// -->
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


    document.addEventListener('DOMContentLoaded', function () {
        const button = document.getElementById('mediaFileBtn');


        // Add a click event listener to the button
        button.addEventListener('click', function () {
            // Get the divs by their IDs
            const tabsDiv = document.getElementById('tabs');

            const tabContentDiv = document.getElementById('tab1');
            const profilDiv = document.getElementById('profileId');
            const tabsMainDiv = document.getElementById('tabsMainDiv');


            // Hide the profileId div
            profilDiv.style.display = 'none';
            // Show the tabs and tabContent divs
            tabsMainDiv.style.display = 'block';
            tabsDiv.style.display = 'block';
            tabContentDiv.style.display = 'block';
            $('.tablink').removeClass('active');
            const htab = document.getElementById('htab1');
            $(htab).addClass('active');
            $('.tab-content').css('display', 'none');
            $('#tab1').css('display', 'block');
        });
    });

    ///////// FUNCTION FOR FILE BUTTON //////

    document.addEventListener('DOMContentLoaded', function () {
        const button = document.getElementById('FileMediaBtn');


        // Add a click event listener to the button
        button.addEventListener('click', function () {
            // Get the divs by their IDs
            const tabsDiv = document.getElementById('tabs');

            const tabContentDiv = document.getElementById('tab3');
            const profilDiv = document.getElementById('profileId');
            const tabsMainDiv = document.getElementById('tabsMainDiv');


            // Hide the profileId div
            $(profilDiv).css('display', 'none');
            // profilDiv.style.display = 'none';
            // Show the tabs and tabContent divs
            tabsMainDiv.style.display = 'block';
            tabsDiv.style.display = 'block';
            tabContentDiv.style.display = 'block';
            $('.tablink').removeClass('active');
            const htab = document.getElementById('htab3');
            $(htab).addClass('active');
            $('.tab-content').css('display', 'none');
            $('#tab3').css('display', 'block');
        });
    });

    ////// BACK BUTTON FUNCTION ///////

    document.addEventListener('DOMContentLoaded', function () {
        const button = document.getElementById('backBtn');

        // Add a click event listener to the button
        button.addEventListener('click', function () {
            // Get the divs by their IDs
            const tabsDiv = document.getElementById('tabs');
            const tabContentDiv = document.getElementById('tab1');
            const profilDiv = document.getElementById('profileId');
            const tabsMainDiv = document.getElementById('tabsMainDiv');


            // Hide the profileId div
            profilDiv.style.display = 'block';
            // Show the tabs and tabContent divs
            tabsMainDiv.style.display = 'none';
            tabsDiv.style.display = 'none';
            tabContentDiv.style.display = 'none';
            $('.tab-content').css('display', 'none');
        });
    });
</script>
<!-- close js for tabs -->


<script>
    $(function () {
        // Initializes and creates emoji set from sprite sheet
        window.emojiPicker = new EmojiPicker({
            emojiable_selector: '[data-emojiable=true]',
            assetsPath: 'assets/emoji/img',
        });
        window.emojiPicker.discover();
    });

    $('#emoji-button').on('click', function () {

        $('.emoji-menu').css('display', 'block');
    });
</script>
<!-- ================ side js start End=============== -->
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
<!-- JavaScript to close the modal when Cancel button is clicked -->
<script>
    // Wait for the document to load
    document.addEventListener('DOMContentLoaded', function () {
        // Get the Cancel button by its ID
        var cancelButton = document.getElementById('cancelButton');

        // Add a click event listener to the Cancel button
        cancelButton.addEventListener('click', function () {
            // Find the modal by its ID
            var modal = document.getElementById('exampleModal6');

            // Use Bootstrap's modal method to hide the modal
            $(modal).modal('hide');
        });
    });
</script>


{{-- Script for Custom Offer - Now using external JS file --}}
<script src="{{ asset('assets/teacher/js/custom-offers.js') }}"></script>
{{-- Script for Custom Offer END =========== --}}
