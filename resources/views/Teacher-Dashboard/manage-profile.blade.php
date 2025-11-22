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
    <!-- Fontawesome CDN -->
    <script
        src="https://kit.fontawesome.com/be69b59144.js"
        crossorigin="anonymous"
    ></script>
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

    <!-- mutilple images upload -->
    <!-- file upload link -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
        crossorigin="anonymous"
    />
    <!-- jquery -->
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"
    ></script>

    <!-- ====================== -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    {{-- =======Toastr CDN ======== --}}
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- =======Toastr CDN ======== --}}


    <!-- Defualt css -->

    <link rel="stylesheet" href="assets/teacher/asset/css/sidebar.css"/>
    <link rel="stylesheet" type="text/css" href="assets/teacher/asset/css/Dashboard.css"/>
    <link rel="stylesheet" href="assets/teacher/asset/css/manage-profile.css"/>
    <link rel="stylesheet" href="assets/teacher/asset/css/style.css"/>
    <style>
        .custom-switch-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            /*border: 1px solid #e0e0e0;*/
            border-radius: 10px;
            padding: 12px 0px 18px;
            /*box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);*/
            transition: all 0.3s ease;
        }

        /*.custom-switch-wrapper:hover {*/
        /*    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);*/
        /*}*/

        .switch-label {
            font-weight: 600;
            font-size: 15px;
            color: #333;
        }

        .toggle-switch {
            position: relative;
            width: 52px;
            height: 28px;
        }

        .toggle-input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #d6d6d6;
            border-radius: 34px;
            transition: 0.3s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 3px;
            bottom: 3px;
            background-color: #fff;
            border-radius: 50%;
            transition: 0.3s;
        }

        .toggle-input:checked + .slider {
            background-color: #0d6efd;
        }

        .toggle-input:checked + .slider:before {
            transform: translateX(24px);
        }

    </style>
</head>
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
    <div class="container-fluid main-section">
        <div class="row">
            <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item">Manage Profile</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12 class-management">
                    <i class="bx bx-user" title="Manage Profile"></i>

                    <h5>Manage Profile</h5>
                </div>
            </div>
            <div class="col-md-12 manage-profile-sec">
                <h5>Manage Profile</h5>
            </div>
            <form action="/teacher-profile-update" method="POST" enctype="multipart/form-data"> @csrf
                <input type="hidden" name="request_type" value="profile">
                <div class="col-md-12 profile-section">
                    <!-- Profile Image -->
                    <div class="col-md-2">
                        <div class="avatar-upload">
                            {{-- <div class="avatar-edit">
                  <input
                    type="file"
                    id="imageUpload"
                    accept=".png, .jpg, .jpeg"
                  />
                  <label for="imageUpload"></label>
                </div> --}}
                            <div class="avatar-preview">
                                <div
                                    id="imagePreview"
                                    style="
                      background-image: url('assets/profile/img/{{$profile->profile_image}}');
                      width: 100%;
                    "
                                ></div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <label
                            class="form-label btn file-btn" for="imageUpload"
                            style="margin-top: 0px !important"
                        > Upload Image </label
                        >
                        <input
                            class="form-control d-none"
                            type="file" name="profile_image"
                            id="imageUpload"
                        />
                    </div>

                    <div class="row profile-form">
                        <div class="col-md-6">
                            <label for="inputPassword4" class="form-label"
                            >First Name</label
                            >
                            <input
                                type="text" value="{{$profile->first_name}}"
                                class="form-control" name="first_name"
                                id="inputPassword4" required
                                placeholder="Usama"
                            />
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword4" class="form-label">Last Name</label>
                            <input
                                type="text" value="{{$profile->last_name}}"
                                class="form-control" name="last_name"
                                id="inputPassword4" required
                                placeholder="Aslam"
                            />
                        </div>


                        <div class="col-6">
                            <div class="custom-switch-wrapper">
                                <label for="show_full_name" class="switch-label">Show Full Name</label>
                                <div class="toggle-switch">
                                    <input
                                        type="checkbox"
                                        id="show_full_name"
                                        class="toggle-input"
                                        @if ($profile->show_full_name == 1) checked @endif
                                    >
                                    <span class="slider"></span>
                                </div>
                                <input type="hidden" name="show_full_name" id="show_full_name_val" value="{{$profile->show_full_name}}">
                            </div>
                        </div>


                        <div class="col-6">
                            <label for="inputAddress" class="form-label prof-lang"
                            >Gender</label
                            >
                            <select
                                class="js-example-basic-multipl form-control"
                                name="gender" id="gender"
                            >

                                @if ($profile->gender == "Male")
                                    <option selected value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                @elseif ($profile->gender == "Female")
                                    <option value="Male">Male</option>
                                    <option selected value="Female">Female</option>
                                    <option value="Other">Other</option>
                                @else
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option selected value="Other">Other</option>
                                @endif

                            </select>
                        </div>
                        <div class="col-6">
                            <label for="inputAddress" class="form-label prof-lang"
                            >Profession</label
                            >
                            <input
                                type="text" value="{{$profile->profession}}"
                                class="form-control" name="profession"
                                id="inputAddress" required
                                placeholder="eg. Front End Developer"
                            />
                        </div>
                        <div class="col-6">
                            <label for="inputAddress2" class="form-label prof-lang"
                            >Primary Language</label
                            >
                            <select
                                class="js-example-basic-multipl form-control"
                                name="primary_language" id="primary_language"
                            >
                                <option selected
                                        value="{{$profile->primary_language}}">{{$profile->primary_language}}</option>
                                <option value="English">English</option>
                                @if ($languages)
                                    @foreach ($languages as $item)

                                        <option value="{{$item->language}}">{{$item->language}}</option>
                                    @endforeach

                                @endif

                            </select>
                        </div>


                        <div class="col-6" id="fluent_main_div">
                            <label for="inputAddress2" class="form-label prof-lang"
                            >English Fluent</label
                            >
                            <select
                                class="js-example-basic-multipl form-control"
                                name="fluent_english"
                            >
                                @if ($profile->fluent_english == 'Yes')
                                    <option selected value="Yes">Yes</option>
                                    <option value="No">No</option>

                                @else
                                    <option value="Yes">Yes</option>
                                    <option selected value="No">No</option>
                                @endif

                            </select>
                        </div>


                        <div class="col-6">
                            <div class="custom-switch-wrapper">
                                <label for="speak_other_language" class="switch-label">
                                    Do you speak other languages fluently?
                                </label>
                                <div class="toggle-switch">
                                    <input
                                        type="checkbox"
                                        id="speak_other_language"
                                        class="toggle-input"
                                        @if ($profile->speak_other_language == 1) checked @endif
                                    >
                                    <span class="slider"></span>
                                </div>
                                <input
                                    type="hidden"
                                    name="speak_other_language"
                                    id="speak_other_lang"
                                    value="{{$profile->speak_other_language}}"
                                >
                            </div>
                        </div>




                        <div class="col-6" id="other_language_main_div"
                             @if ($profile->speak_other_language == 0)  style="display:none;" @endif >
                            <label class="form-label prof-lang">
                                Other languages </label>

                            <div class="dropdown">
                                <button
                                    class="btn dropdown-toggle  form-select form-control"
                                    type="button"
                                    id="multiSelectDropdown4"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false" onclick="SelectLanguages()"
                                    style="text-align: left; overflow: hidden"
                                >{{$profile->fluent_other_language}}</button>

                                <input type="hidden" name="other_language" id="other_lang" required
                                       value="{{$profile->fluent_other_language}}">


                                <ul
                                    class="dropdown-menu multi-drop-select mt-2"
                                    aria-labelledby="multiSelectDropdown4"
                                >
                                    <div class="row" id="SelectLanguages">

                                        @if ($languages)
                                            @php
                                                $all_lang  = $languages->pluck('language')->toArray();
                    $selected_lang = explode(',',$profile->fluent_other_language);
                    $selected_lang = array_map(function($value) {
                        return preg_replace('/\s+/', '', $value);
                    }, $selected_lang);

                                            @endphp

                                            @foreach ($all_lang as $item)

                                                @if (in_array($item, $selected_lang))
                                                    <div class="col-md-3">
                                                        <li class="multi-text-li">
                                                            <label>
                                                                <input
                                                                    type="checkbox" checked='checked'
                                                                    value="{{$item}}"
                                                                    class="language-input"
                                                                />{{$item}}</label>
                                                        </li>
                                                    </div>
                                                @else
                                                    <div class="col-md-3">
                                                        <li class="multi-text-li">
                                                            <label>
                                                                <input
                                                                    type="checkbox"
                                                                    value="{{$item}}"
                                                                    class="language-input"
                                                                />{{$item}}</label>
                                                        </li>
                                                    </div>
                                                @endif

                                            @endforeach

                                        @endif


                                    </div>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="inputAddress2" class="form-label prof-lang"
                            >Overview</label
                            >
                            <br/>
                            <textarea
                                name="overview"
                                id=""
                                cols="30"
                                rows="10"
                                placeholder="Overview your profession......"
                            >{{$profile->overview}}</textarea>
                        </div>
                        <div class="col-12 profile-form">
                            <label for="inputAddress2" class="form-label prof-lang"
                            >Cover Image</label
                            >
                            <!-- Upload start -->
                            <div class="col-md-12 identity" id="upload-image" style="margin-bottom: 10px;">
                                <div class="input-file-wrapper transition-linear-3 position-relative">
                    <span
                        class="remove-img-btn position-absolute"
                        style="cursor: pointer;background: #ed5646;color: white !important;border-radius: 5px;z-index: 10;padding: 4px 8px !important;"
                        @click="reset('post-thumbnail')"
                        v-if="preview!==null"
                    >
                      Remove
                    </span>
                                    <label
                                        class="input-style input-label lh-1-7 p-4 text-center cursor-pointer"
                                        for="post-thumbnail"
                                        style="background: #f4fbff;border-radius: 4px;cursor: pointer; width: 100%;"
                                    >
                      <span v-show="preview===null">
                        <svg style="position: relative; top: 15px" xmlns="http://www.w3.org/2000/svg" width="61"
                             height="60" viewBox="0 0 61 60" fill="none">
                        <path
                            d="M32.375 50.625V39.375H39.875L30.5 28.125L21.125 39.375H28.625V50.625H19.25V50.5312C18.935 50.55 18.635 50.625 18.3125 50.625C14.5829 50.625 11.006 49.1434 8.36881 46.5062C5.73158 43.869 4.25 40.2921 4.25 36.5625C4.25 29.3475 9.70625 23.4675 16.7075 22.6613C17.3213 19.4523 19.0342 16.5576 21.5514 14.475C24.0686 12.3924 27.2329 11.252 30.5 11.25C33.7675 11.2518 36.9323 12.3921 39.4502 14.4747C41.9681 16.5573 43.6816 19.452 44.2962 22.6613C51.2975 23.4675 56.7462 29.3475 56.7462 36.5625C56.7462 40.2921 55.2647 43.869 52.6274 46.5062C49.9902 49.1434 46.4134 50.625 42.6837 50.625C42.3687 50.625 42.065 50.55 41.7462 50.5312V50.625H32.375Z"
                            fill="#ABABAB"/>
                      </svg>
                      <p style="position: relative; top: 15px">Upload Image</p>
                      <p class="gray-text">Drag and drop files here</p>
                      </span>
                                        <template v-if="preview" style="height: 250px; width:100%">
                                            <img :src="preview" class="img-fluid mt-2" style="height: 220px;"/>
                                        </template>
                                    </label>
                                    <input
                                        type="file" name="main_image"
                                        accept="image/*" value=""
                                        @change="previewImage('post-thumbnail')"
                                        class="input-file"
                                        id="post-thumbnail"
                                    />
                                </div>
                            </div>
                            <!-- Upload End -->
                        </div>
                        <div class="col-md-12 form-sec personal-info">
                            <label for="inputAddress" class="form-label">More Images</label>
                            <!-- Upload file start -->

                            <div class="row">


                                <!-- Upload start -->
                                <div class="col-md-4 identity" id="upload-image1" style="margin-bottom: 10px;">
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
                        <svg style="position: relative; top: 15px" xmlns="http://www.w3.org/2000/svg" width="61"
                             height="60" viewBox="0 0 61 60" fill="none">
                        <path
                            d="M32.375 50.625V39.375H39.875L30.5 28.125L21.125 39.375H28.625V50.625H19.25V50.5312C18.935 50.55 18.635 50.625 18.3125 50.625C14.5829 50.625 11.006 49.1434 8.36881 46.5062C5.73158 43.869 4.25 40.2921 4.25 36.5625C4.25 29.3475 9.70625 23.4675 16.7075 22.6613C17.3213 19.4523 19.0342 16.5576 21.5514 14.475C24.0686 12.3924 27.2329 11.252 30.5 11.25C33.7675 11.2518 36.9323 12.3921 39.4502 14.4747C41.9681 16.5573 43.6816 19.452 44.2962 22.6613C51.2975 23.4675 56.7462 29.3475 56.7462 36.5625C56.7462 40.2921 55.2647 43.869 52.6274 46.5062C49.9902 49.1434 46.4134 50.625 42.6837 50.625C42.3687 50.625 42.065 50.55 41.7462 50.5312V50.625H32.375Z"
                            fill="#ABABAB"/>
                      </svg>
                      <p style="position: relative; top: 15px">Upload Image</p>
                      <p class="gray-text">Drag and drop files here</p>
                      </span>
                                            <template v-if="preview" style="height: 250px; width:100%">
                                                <img :src="preview" class="img-fluid mt-2" style="height: 220px;"/>
                                            </template>
                                        </label>
                                        <input
                                            type="file" name="image_1"
                                            accept="image/*" value=""
                                            @change="previewImage('post-thumbnail1')"
                                            class="input-file"
                                            id="post-thumbnail1"
                                        />
                                    </div>
                                </div>
                                <!-- Upload End -->


                                <!-- Upload start -->
                                <div class="col-md-4 identity" id="upload-image2" style="margin-bottom: 10px;">
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
                        <svg style="position: relative; top: 15px" xmlns="http://www.w3.org/2000/svg" width="61"
                             height="60" viewBox="0 0 61 60" fill="none">
                        <path
                            d="M32.375 50.625V39.375H39.875L30.5 28.125L21.125 39.375H28.625V50.625H19.25V50.5312C18.935 50.55 18.635 50.625 18.3125 50.625C14.5829 50.625 11.006 49.1434 8.36881 46.5062C5.73158 43.869 4.25 40.2921 4.25 36.5625C4.25 29.3475 9.70625 23.4675 16.7075 22.6613C17.3213 19.4523 19.0342 16.5576 21.5514 14.475C24.0686 12.3924 27.2329 11.252 30.5 11.25C33.7675 11.2518 36.9323 12.3921 39.4502 14.4747C41.9681 16.5573 43.6816 19.452 44.2962 22.6613C51.2975 23.4675 56.7462 29.3475 56.7462 36.5625C56.7462 40.2921 55.2647 43.869 52.6274 46.5062C49.9902 49.1434 46.4134 50.625 42.6837 50.625C42.3687 50.625 42.065 50.55 41.7462 50.5312V50.625H32.375Z"
                            fill="#ABABAB"/>
                      </svg>
                      <p style="position: relative; top: 15px">Upload Image</p>
                      <p class="gray-text">Drag and drop files here</p>
                      </span>
                                            <template v-if="preview" style="height: 250px; width:100%">
                                                <img :src="preview" class="img-fluid mt-2" style="height: 220px;"/>
                                            </template>
                                        </label>
                                        <input
                                            type="file" name="image_2"
                                            accept="image/*" value=""
                                            @change="previewImage('post-thumbnail2')"
                                            class="input-file"
                                            id="post-thumbnail2"
                                        />
                                    </div>
                                </div>
                                <!-- Upload End -->


                                <!-- Upload start -->
                                <div class="col-md-4 identity" id="upload-image3" style="margin-bottom: 10px;">
                                    <div class="input-file-wrapper transition-linear-3 position-relative">
                    <span
                        class="remove-img-btn position-absolute"
                        style="cursor: pointer;background: #ed5646;color: white !important;border-radius: 5px;z-index: 10;padding: 4px 8px !important;"
                        @click="reset('post-thumbnail3')"
                        v-if="preview!==null"
                    >
                      Remove
                    </span>
                                        <label
                                            class="input-style input-label lh-1-7 p-4 text-center cursor-pointer"
                                            for="post-thumbnail3"
                                            style="background: #f4fbff;border-radius: 4px;cursor: pointer; width: 100%;"
                                        >
                      <span v-show="preview===null">
                        <svg style="position: relative; top: 15px" xmlns="http://www.w3.org/2000/svg" width="61"
                             height="60" viewBox="0 0 61 60" fill="none">
                        <path
                            d="M32.375 50.625V39.375H39.875L30.5 28.125L21.125 39.375H28.625V50.625H19.25V50.5312C18.935 50.55 18.635 50.625 18.3125 50.625C14.5829 50.625 11.006 49.1434 8.36881 46.5062C5.73158 43.869 4.25 40.2921 4.25 36.5625C4.25 29.3475 9.70625 23.4675 16.7075 22.6613C17.3213 19.4523 19.0342 16.5576 21.5514 14.475C24.0686 12.3924 27.2329 11.252 30.5 11.25C33.7675 11.2518 36.9323 12.3921 39.4502 14.4747C41.9681 16.5573 43.6816 19.452 44.2962 22.6613C51.2975 23.4675 56.7462 29.3475 56.7462 36.5625C56.7462 40.2921 55.2647 43.869 52.6274 46.5062C49.9902 49.1434 46.4134 50.625 42.6837 50.625C42.3687 50.625 42.065 50.55 41.7462 50.5312V50.625H32.375Z"
                            fill="#ABABAB"/>
                      </svg>
                      <p style="position: relative; top: 15px">Upload Image</p>
                      <p class="gray-text">Drag and drop files here</p>
                      </span>
                                            <template v-if="preview" style="height: 250px; width:100%">
                                                <img :src="preview" class="img-fluid mt-2" style="height: 220px;"/>
                                            </template>
                                        </label>
                                        <input
                                            type="file" name="image_3"
                                            accept="image/*" value=""
                                            @change="previewImage('post-thumbnail3')"
                                            class="input-file"
                                            id="post-thumbnail3"
                                        />
                                    </div>
                                </div>
                                <!-- Upload End -->


                                <!-- Upload start -->
                                <div class="col-md-4 identity" id="upload-image4" style="margin-bottom: 10px;">
                                    <div class="input-file-wrapper transition-linear-3 position-relative">
                    <span
                        class="remove-img-btn position-absolute"
                        style="cursor: pointer;background: #ed5646;color: white !important;border-radius: 5px;z-index: 10;padding: 4px 8px !important;"
                        @click="reset('post-thumbnail4')"
                        v-if="preview!==null"
                    >
                      Remove
                    </span>
                                        <label
                                            class="input-style input-label lh-1-7 p-4 text-center cursor-pointer"
                                            for="post-thumbnail4"
                                            style="background: #f4fbff;border-radius: 4px;cursor: pointer; width: 100%;"
                                        >
                      <span v-show="preview===null">
                        <svg style="position: relative; top: 15px" xmlns="http://www.w3.org/2000/svg" width="61"
                             height="60" viewBox="0 0 61 60" fill="none">
                        <path
                            d="M32.375 50.625V39.375H39.875L30.5 28.125L21.125 39.375H28.625V50.625H19.25V50.5312C18.935 50.55 18.635 50.625 18.3125 50.625C14.5829 50.625 11.006 49.1434 8.36881 46.5062C5.73158 43.869 4.25 40.2921 4.25 36.5625C4.25 29.3475 9.70625 23.4675 16.7075 22.6613C17.3213 19.4523 19.0342 16.5576 21.5514 14.475C24.0686 12.3924 27.2329 11.252 30.5 11.25C33.7675 11.2518 36.9323 12.3921 39.4502 14.4747C41.9681 16.5573 43.6816 19.452 44.2962 22.6613C51.2975 23.4675 56.7462 29.3475 56.7462 36.5625C56.7462 40.2921 55.2647 43.869 52.6274 46.5062C49.9902 49.1434 46.4134 50.625 42.6837 50.625C42.3687 50.625 42.065 50.55 41.7462 50.5312V50.625H32.375Z"
                            fill="#ABABAB"/>
                      </svg>
                      <p style="position: relative; top: 15px">Upload Image</p>
                      <p class="gray-text">Drag and drop files here</p>
                      </span>
                                            <template v-if="preview" style="height: 250px; width:100%">
                                                <img :src="preview" class="img-fluid mt-2" style="height: 220px;"/>
                                            </template>
                                        </label>
                                        <input
                                            type="file" name="image_4"
                                            accept="image/*" value=""
                                            @change="previewImage('post-thumbnail4')"
                                            class="input-file"
                                            id="post-thumbnail4"
                                        />
                                    </div>
                                </div>
                                <!-- Upload End -->


                                <!-- Upload start -->
                                <div class="col-md-4 identity" id="upload-image5" style="margin-bottom: 10px;">
                                    <div class="input-file-wrapper transition-linear-3 position-relative">
                    <span
                        class="remove-img-btn position-absolute"
                        style="cursor: pointer;background: #ed5646;color: white !important;border-radius: 5px;z-index: 10;padding: 4px 8px !important;"
                        @click="reset('post-thumbnail5')"
                        v-if="preview!==null"
                    >
                      Remove
                    </span>
                                        <label
                                            class="input-style input-label lh-1-7 p-4 text-center cursor-pointer"
                                            for="post-thumbnail5"
                                            style="background: #f4fbff;border-radius: 4px;cursor: pointer; width: 100%;"
                                        >
                      <span v-show="preview===null">
                        <svg style="position: relative; top: 15px" xmlns="http://www.w3.org/2000/svg" width="61"
                             height="60" viewBox="0 0 61 60" fill="none">
                        <path
                            d="M32.375 50.625V39.375H39.875L30.5 28.125L21.125 39.375H28.625V50.625H19.25V50.5312C18.935 50.55 18.635 50.625 18.3125 50.625C14.5829 50.625 11.006 49.1434 8.36881 46.5062C5.73158 43.869 4.25 40.2921 4.25 36.5625C4.25 29.3475 9.70625 23.4675 16.7075 22.6613C17.3213 19.4523 19.0342 16.5576 21.5514 14.475C24.0686 12.3924 27.2329 11.252 30.5 11.25C33.7675 11.2518 36.9323 12.3921 39.4502 14.4747C41.9681 16.5573 43.6816 19.452 44.2962 22.6613C51.2975 23.4675 56.7462 29.3475 56.7462 36.5625C56.7462 40.2921 55.2647 43.869 52.6274 46.5062C49.9902 49.1434 46.4134 50.625 42.6837 50.625C42.3687 50.625 42.065 50.55 41.7462 50.5312V50.625H32.375Z"
                            fill="#ABABAB"/>
                      </svg>
                      <p style="position: relative; top: 15px">Upload Image</p>
                      <p class="gray-text">Drag and drop files here</p>
                      </span>
                                            <template v-if="preview" style="height: 250px; width:100%">
                                                <img :src="preview" class="img-fluid mt-2" style="height: 220px;"/>
                                            </template>
                                        </label>
                                        <input
                                            type="file" name="image_5"
                                            accept="image/*" value=""
                                            @change="previewImage('post-thumbnail5')"
                                            class="input-file"
                                            id="post-thumbnail5"
                                        />
                                    </div>
                                </div>
                                <!-- Upload End -->


                                <!-- Upload start -->
                                <div class="col-md-4 identity" id="upload-image6" style="margin-bottom: 10px;">
                                    <div class="input-file-wrapper transition-linear-3 position-relative">
                    <span
                        class="remove-img-btn position-absolute"
                        style="cursor: pointer;background: #ed5646;color: white !important;border-radius: 5px;z-index: 10;padding: 4px 8px !important;"
                        @click="reset('post-thumbnail6')"
                        v-if="preview!==null"
                    >
                      Remove
                    </span>
                                        <label
                                            class="input-style input-label lh-1-7 p-4 text-center cursor-pointer"
                                            for="post-thumbnail6"
                                            style="background: #f4fbff;border-radius: 4px;cursor: pointer; width: 100%;"
                                        >
                      <span v-show="preview===null">
                        <svg style="position: relative; top: 15px" xmlns="http://www.w3.org/2000/svg" width="61"
                             height="60" viewBox="0 0 61 60" fill="none">
                        <path
                            d="M32.375 50.625V39.375H39.875L30.5 28.125L21.125 39.375H28.625V50.625H19.25V50.5312C18.935 50.55 18.635 50.625 18.3125 50.625C14.5829 50.625 11.006 49.1434 8.36881 46.5062C5.73158 43.869 4.25 40.2921 4.25 36.5625C4.25 29.3475 9.70625 23.4675 16.7075 22.6613C17.3213 19.4523 19.0342 16.5576 21.5514 14.475C24.0686 12.3924 27.2329 11.252 30.5 11.25C33.7675 11.2518 36.9323 12.3921 39.4502 14.4747C41.9681 16.5573 43.6816 19.452 44.2962 22.6613C51.2975 23.4675 56.7462 29.3475 56.7462 36.5625C56.7462 40.2921 55.2647 43.869 52.6274 46.5062C49.9902 49.1434 46.4134 50.625 42.6837 50.625C42.3687 50.625 42.065 50.55 41.7462 50.5312V50.625H32.375Z"
                            fill="#ABABAB"/>
                      </svg>
                      <p style="position: relative; top: 15px">Upload Image</p>
                      <p class="gray-text">Drag and drop files here</p>
                      </span>
                                            <template v-if="preview" style="height: 250px; width:100%">
                                                <img :src="preview" class="img-fluid mt-2" style="height: 220px;"/>
                                            </template>
                                        </label>
                                        <input
                                            type="file" name="image_6"
                                            accept="image/*" value=""
                                            @change="previewImage('post-thumbnail6')"
                                            class="input-file"
                                            id="post-thumbnail6"
                                        />
                                    </div>
                                </div>
                                <!-- Upload End -->


                            </div>

                        </div>

                        <div class="col-12 profile-form">
                            <label for="inputAddress2" class="form-label prof-lang"
                            >Add Cover Video</label
                            >
                            <!-- Upload start -->
                            <div class="col-md-12 identity" id="upload-image7" style="margin-bottom: 10px;">
                                <div class="input-file-wrapper transition-linear-3 position-relative">
                      <span
                          class="remove-img-btn position-absolute"
                          style="cursor: pointer;background: #ed5646;color: white !important;border-radius: 5px;z-index: 10;padding: 4px 8px !important;"
                          @click="reset('post-thumbnail7')"
                          v-if="preview!==null"
                      >
                        Remove
                      </span>
                                    <label
                                        class="input-style input-label lh-1-7 p-4 text-center cursor-pointer"
                                        for="post-thumbnail7"
                                        style="background: #f4fbff;border-radius: 4px;cursor: pointer; width: 100%;"
                                    >
                        <span v-show="preview===null">
                          <svg style="position: relative; top: 15px" xmlns="http://www.w3.org/2000/svg" width="61"
                               height="60" viewBox="0 0 61 60" fill="none">
                          <path
                              d="M32.375 50.625V39.375H39.875L30.5 28.125L21.125 39.375H28.625V50.625H19.25V50.5312C18.935 50.55 18.635 50.625 18.3125 50.625C14.5829 50.625 11.006 49.1434 8.36881 46.5062C5.73158 43.869 4.25 40.2921 4.25 36.5625C4.25 29.3475 9.70625 23.4675 16.7075 22.6613C17.3213 19.4523 19.0342 16.5576 21.5514 14.475C24.0686 12.3924 27.2329 11.252 30.5 11.25C33.7675 11.2518 36.9323 12.3921 39.4502 14.4747C41.9681 16.5573 43.6816 19.452 44.2962 22.6613C51.2975 23.4675 56.7462 29.3475 56.7462 36.5625C56.7462 40.2921 55.2647 43.869 52.6274 46.5062C49.9902 49.1434 46.4134 50.625 42.6837 50.625C42.3687 50.625 42.065 50.55 41.7462 50.5312V50.625H32.375Z"
                              fill="#ABABAB"/>
                        </svg>
                        <p style="position: relative; top: 15px">Upload Image</p>
                        <p class="gray-text">Drag and drop files here</p>
                        </span>
                                        <video v-if="preview" controls id="video-tag" style="height: 220px; width:100%">
                                            <source :src="preview" class="img-fluid mt-2" id="video-source">

                                        </video>

                                    </label>
                                    <input
                                        type="file" name="video"
                                        accept="video/*" value=""
                                        @change="previewImage('post-thumbnail7')"
                                        class="input-file"
                                        id="post-thumbnail7"
                                    />
                                </div>
                            </div>
                            <!-- Upload End -->
                        </div>
                        <div class="col-12 profile-form">
                            <label for="inputAddress" class="form-label">About</label>
                            <br/>
                            <textarea
                                name="about_me"
                                id=""
                                cols="30"
                                rows="10"
                                placeholder="write something about yourself........"
                            >{{$profile->about_me}}</textarea>
                        </div>
                        @if ($profile->service_type == 'Both' && $profile->service_role == 'Both')
                            <div class="col-12 profile-form">
                                <label for="inputAddress" class="form-label"
                                >Which Service type you want to keep First?</label
                                >
                                <br/>
                                <select class="form-select" name="first_service" aria-label="Default select example">
                                    <option selected
                                            value="{{$profile->first_service}}">{{$profile->first_service}}</option>
                                    <option value="All Services">All Services</option>
                                    <option value="Online Class">Online Class</option>
                                    <option value="Inperson Class">Inperson Class</option>
                                    <option value="Online Freelance">Online Freelance</option>
                                    <option value="Inperson Freelance">Inperson Freelance</option>

                                </select>
                            </div>
                        @endif

                        <!-- Order Management Preferences -->
                        <div class="col-12 profile-form" style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                            <h6 style="margin-bottom: 15px; color: #333;">Order Management Preferences</h6>
                            <div class="custom-switch-wrapper" style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <label for="auto_approve_enabled" class="switch-label" style="font-weight: 500; margin-bottom: 5px;">Enable Auto-Approve for All Services</label>
                                    <p style="font-size: 13px; color: #666; margin: 0;">When enabled, all incoming orders will be automatically approved. You can still set individual services to require manual approval.</p>
                                </div>
                                <div class="toggle-switch">
                                    <input
                                        type="checkbox"
                                        id="auto_approve_enabled"
                                        class="toggle-input"
                                        @if (Auth::user()->auto_approve_enabled == 1) checked @endif
                                    >
                                    <span class="slider"></span>
                                </div>
                                <input type="hidden" name="auto_approve_enabled" id="auto_approve_enabled_val" value="{{ Auth::user()->auto_approve_enabled ?? 0 }}">
                            </div>
                        </div>

                        <button type="submit" class="btn rqst-send" style="width: max-content;">Send Request</button>
                    </div>
                </div>
            </form>

        </div>
        <div class="row">
            <div class="col-md-12 manage-profile-sec">
                <h5>Update Location</h5>
            </div>

            <form action="/teacher-location-update" method="POST"> @csrf
                <input type="hidden" name="request_type" value="location">
                <div class="col-md-12 profile-section">
                    <div class="row profile-form">
                        <div class="col-md-12">
                            <label for="inputAddress" class="form-label">Street Address</label>
                            <input
                                type="text" value="{{$profile->street_address}}" readonly
                                class="form-control" style="cursor: pointer;"
                                id="street_address" name="street_address"
                                placeholder="Street Address"
                            />
                            <input type="hidden" name="ip_address" id="ip_address" readonly
                                   value="{{$profile->ip_address}}">
                            <input type="hidden" name="country_code" id="country_code" readonly
                                   value="{{$profile->country_code}}">
                            <input type="hidden" name="latitude" id="latitude" readonly value="{{$profile->latitude}}">
                            <input type="hidden" name="longitude" id="longitude" readonly
                                   value="{{$profile->longitude}}">
                        </div>
                        <div class="col-md-12">
                            <label for="inputAddress" class="form-label">Country</label>
                            <input
                                type="text" value="{{$profile->country}}" readonly
                                class="form-control" style="cursor: pointer;"
                                id="country" name="country"
                                placeholder="Country"
                            />
                        </div>
                        <div class="col-md-6 profile-form">
                            <label for="inputAddress" class="form-label">City</label>
                            <input
                                type="text" value="{{$profile->city}}" readonly
                                class="form-control" style="cursor: pointer;"
                                id="city" name="city"
                                placeholder="City"
                            />
                        </div>
                        <div class="col-md-6 profile-form">
                            <label for="inputAddress" class="form-label">Zip Code</label>

                            <input
                                type="text" value="{{$profile->zip_code}}" readonly
                                class="form-control" style="cursor: pointer;"
                                id="zip_code" name="zip_code"
                                placeholder="Zip Code"
                            />
                        </div>
                        <div class="col-md-12 profile-form">
                            <label for="inputAddress" class="form-label">Reason</label>

                            <textarea
                                name="reason"
                                id=""
                                cols="30"
                                rows="10"
                                class="form-control"
                                placeholder="write something why you want to update the location"
                            ></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn rqst-send">Send Request</button>
                </div>
            </form>


        </div>
        <div class="row">
            <div class="col-md-12 manage-profile-faq-sec">
                <h5>Frequently Asked Questions</h5>
                <a href="/teacher-add-faq"
                >
                    <button class="btn float-end add-faq-btn">Add New FAQ</button>
                </a
                >
            </div>
        </div>
        <!-- ============================= FAQ'S SECTION START HERE ===================================== -->
        <div class="row">
            <div class="col-md-12 faq-sec">
                <div class="accordion">
                    <div class="row">
                        @if ($faqs)

                            @foreach ($faqs as $item)
                                <div class="col-md-6">
                                    <div class="accordion-item">
                                        <a href="/teacher-edit-faq/{{$item->id}}">
                                            <div class="accordion-item-head">{{$item->question}}</div>
                                        </a
                                        >
                                        <div class="accordion-item-body">
                                            <div class="accordion-item-body-content"></div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach

                        @else
                            <div class="col-md-6">
                                <div class="accordion-item">
                                    <a>
                                        <div class="accordion-item-head">Not Added Any Faqs Yet!</div>
                                    </a
                                    >
                                    <div class="accordion-item-body">
                                        <div class="accordion-item-body-content"></div>
                                    </div>
                                </div>
                            </div>

                        @endif

                        {{-- <div class="col-md-6">
                  <div class="accordion-item">
                    <a href="edit-faq.html">
                      <div class="accordion-item-head">Why DreamCrowd?</div></a
                    >
                    <div class="accordion-item-body">
                      <div class="accordion-item-body-content"></div>
                    </div>
                  </div>
                </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================= FAQ'S SECTION END HERE ===================================== -->
        <div class="row">
            <div class="col-md-12 manage-profile-faq-sec">
                <h5>Categories & Sub Categories</h5>
                <a href="/teacher-add-new-category/{{$profile->id}}"
                >
                    <button
                        class="btn float-end add-faq-btn"
                        data-bs-toggle="modal fade"
                        data-bs-target="#exampleModal4"
                    >
                        Add New Category
                    </button>
                </a
                >
            </div>
        </div>
        <!-- ================= ALL CATEGORIES SECTION START HERE =================== -->
        <div class="row">
            @if (in_array($profile->service_type, ['Class', 'Both']))

                @if ($profile->category_class != null)

                    <div class="col-md-12 faq-sec">
                        <h2 class="category-title">Class Categories</h2>
                        <div id="categoryContainer" class="profile-form">

                            @php $class_cate = explode(',',$profile->category_class) @endphp
                            @if (count($class_cate) == 1)
                                @php $cates = \App\Models\Category::find($profile->category_class) ; @endphp
                                <div class="input-group mb-3 category main_class_1">
                                    <input
                                        type="text" value="{{$cates->category}} ({{$cates->service_type}})"
                                        class="form-control"
                                        placeholder="Front End Developer"
                                        aria-label="Recipient's username"
                                        aria-describedby="button-addon1"
                                        readonly
                                    />
                                    <button
                                        class="btn view-button btn btn-outline-secondary remove-button"
                                        type="button" style="display: none"
                                        onclick="RejectCategory(this.id)" id="reject_class_category_1"
                                        data-category="{{$profile->category_class}}" data-type="Class"
                                    >Remove
                                    </button>
                                    <button
                                        class="btn view-button"
                                        type="button"

                                        onclick="ViewClassSub(this.id)" id="class_view_1"
                                        data-cate="{{$profile->category_class}}"
                                        data-cates_type="{{$cates->service_type}}"
                                    >View
                                    </button>
                                </div>
                                <div class="col-md-12 sub_cate mt-2" id="class_sub_cate_1"></div>
                            @else
                                @php  $i =1 ;  @endphp
                                @foreach ($class_cate as $item)
                                    @php $cates = \App\Models\Category::find($item) ; @endphp
                                    @if ($i == 1)

                                        <div class="input-group mb-3 category main_class_{{$i}}">
                                            <input
                                                type="text" value="{{$cates->category}} ({{$cates->service_type}})"
                                                class="form-control"
                                                placeholder="Front End Developer"
                                                aria-label="Recipient's username"
                                                aria-describedby="button-addon{{$i}}"
                                                readonly
                                            />
                                            <button
                                                class="btn view-button btn btn-outline-secondary remove-button"
                                                type="button" style="display: none"
                                                onclick="RejectCategory(this.id)" id="reject_class_category_{{$i}}"
                                                data-category="{{$item}}" data-type="Class"
                                            >Remove
                                            </button>
                                            <button
                                                class="btn view-button"
                                                type="button"

                                                onclick="ViewClassSub(this.id)" id="class_view_{{$i}}"
                                                data-cate="{{$item}}" data-cates_type="{{$cates->service_type}}"
                                            >View
                                            </button>
                                        </div>

                                        <div class="col-md-12 sub_cate mt-2 mb-2" id="class_sub_cate_{{$i}}"></div>

                                    @else
                                        <div class="input-group mb-3 category main_class_{{$i}}">
                                            <input
                                                type="text" value="{{$cates->category}} ({{$cates->service_type}})"
                                                class="form-control"
                                                placeholder="Front End Developer"
                                                aria-label="Recipient's username"
                                                aria-describedby="button-addon{{$i}}"
                                                readonly
                                            />
                                            <button
                                                class="btn view-button btn btn-outline-secondary remove-button"
                                                type="button" style="display: none"
                                                onclick="RejectCategory(this.id)" id="reject_class_category_{{$i}}"
                                                data-category="{{$item}}" data-type="Class"
                                            >Remove
                                            </button>
                                            <button
                                                class="btn view-button"
                                                type="button"
                                                onclick="ViewClassSub(this.id)" id="class_view_{{$i}}"
                                                data-cate="{{$item}}" data-cates_type="{{$cates->service_type}}"
                                            >View
                                            </button>
                                        </div>
                                        <div class="col-md-12 sub_cate mt-2 mb-2" id="class_sub_cate_{{$i}}"></div>

                                    @endif
                                    @php  $i++ ;  @endphp
                                @endforeach
                            @endif

                        </div>
                    </div>

                @endif

            @endif

            @if(in_array($profile->service_type, ['Freelance', 'Both']))

                @if ($profile->category_freelance != null)

                    <div class="col-md-12 faq-sec">
                        <h2 class="category-title">Freelance Categories</h2>
                        <div id="categoryContainer" class="profile-form">

                            @php $freelance_cate = explode(',',$profile->category_freelance) @endphp
                            @if (count($freelance_cate) == 1)
                                @php $cates = \App\Models\Category::find($profile->category_freelance) ; @endphp
                                <div class="input-group mb-3 category main_freelance_1">
                                    <input
                                        type="text" value="{{$cates->category}} ({{$cates->service_type}})"
                                        class="form-control"
                                        placeholder="Front End Developer"
                                        aria-label="Recipient's username"
                                        aria-describedby="button-addon1"
                                        readonly
                                    />
                                    <button
                                        class="btn view-button btn btn-outline-secondary remove-button"
                                        type="button" style="display: none"
                                        onclick="RejectCategory(this.id)" id="reject_freelance_category_1"
                                        data-category="{{$profile->category_freelance}}" data-type="Freelance"
                                    >Remove
                                    </button>
                                    <button
                                        class="btn view-button"
                                        type="button"

                                        onclick="ViewFreelanceSub(this.id)" id="freelance_view_1"
                                        data-cate="{{$profile->category_class}}"
                                        data-cates_type="{{$cates->service_type}}"
                                    >View
                                    </button>
                                </div>
                                <div class="col-md-12 sub_cate mt-2" id="freelance_sub_cate_1"></div>
                            @else
                                @php  $i =1 ;  @endphp
                                @foreach ($freelance_cate as $item)
                                    @php $cates = \App\Models\Category::find($item) ; @endphp
                                    @if ($i == 1)

                                        <div class="input-group mb-3 category main_freelance_{{$i}}">
                                            <input
                                                type="text" value="{{$cates->category}} ({{$cates->service_type}})"
                                                class="form-control"
                                                placeholder="Front End Developer"
                                                aria-label="Recipient's username"
                                                aria-describedby="button-addon{{$i}}"
                                                readonly
                                            />
                                            <button
                                                class="btn view-button btn btn-outline-secondary remove-button"
                                                type="button" style="display: none"
                                                onclick="RejectCategory(this.id)" id="reject_freelance_category_{{$i}}"
                                                data-category="{{$item}}" data-type="Freelance"
                                            >Remove
                                            </button>
                                            <button
                                                class="btn view-button"
                                                type="button"

                                                onclick="ViewFreelanceSub(this.id)" id="freelance_view_{{$i}}"
                                                data-cate="{{$item}}" data-cates_type="{{$cates->service_type}}"
                                            >View
                                            </button>
                                        </div>

                                        <div class="col-md-12 sub_cate mt-2 mb-2" id="freelance_sub_cate_{{$i}}"></div>

                                    @else
                                        <div class="input-group mb-3 category main_freelance_{{$i}}">
                                            <input
                                                type="text" value="{{$cates->category}} ({{$cates->service_type}})"
                                                class="form-control"
                                                placeholder="Front End Developer"
                                                aria-label="Recipient's username"
                                                aria-describedby="button-addon{{$i}}"
                                                readonly
                                            />
                                            <button
                                                class="btn view-button btn btn-outline-secondary remove-button"
                                                type="button" style="display: none"
                                                onclick="RejectCategory(this.id)" id="reject_freelance_category_{{$i}}"
                                                data-category="{{$item}}" data-type="Freelance"
                                            >Remove
                                            </button>
                                            <button
                                                class="btn view-button"
                                                type="button"
                                                onclick="ViewFreelanceSub(this.id)" id="freelance_view_{{$i}}"
                                                data-cate="{{$item}}" data-cates_type="{{$cates->service_type}}"
                                            >View
                                            </button>
                                        </div>
                                        <div class="col-md-12 sub_cate mt-2 mb-2" id="freelance_sub_cate_{{$i}}"></div>

                                    @endif
                                    @php  $i++ ;  @endphp
                                @endforeach
                            @endif

                        </div>
                    </div>

                @endif

            @endif


        </div>
        <div class="text-center copyright-sec">
            <p class="mb-0">Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
        </div>

        <!-- ================= ALL CATEGORIES SECTION ENDED HERE =================== -->
    </div>
    <!-- =============================== MAIN CONTENT END HERE =========================== -->
</section>

<!-- =========== NAME VERIFICATION MODAL START HERE =============== -->
<!-- Modal -->
<div
    class="modal fade"
    id="exampleModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog verification-modal">
        <div class="modal-content content-modal">
            <div class="modal-header modal-heading">
                <h5 class="modal-title" id="exampleModalLabel">
                    Need Verification!
                </h5>
            </div>
            <div class="modal-body body-modal">
                <h5 class="mb-0">Upload Documents</h5>
                <p class="mb-0">
                    Your identity will need to be verified in order to change your
                    legal name. Please upload very clear photos of one or more of the
                    following:
                </p>
                <!-- Radio Buttons -->
                <div class="wrapper">
                    <div class="wrapper-inner">
                        <div class="form-group">
                            <div class="radio">
                                <label>
                                    <input
                                        type="radio"
                                        name="radio-input"
                                        checked="checked"
                                    />
                                    National Identity Card
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="radio-input"/> Driving License
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="radio-input"/> Passport
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Upload start -->
                <div class="row">
                    <div class="col-md-6 mt-1 file-upload">
                        <div class="become-upload-Card">
                            <form id="file-upload-form" class="uploader">
                                <input
                                    id="file-upload"
                                    type="file"
                                    name="fileUpload"
                                    accept="image/*"
                                />

                                <label for="file-upload" id="file-drag">
                                    <div id="start">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="60"
                                            height="60"
                                            viewBox="0 0 60 60"
                                            fill="none"
                                        >
                                            <path
                                                d="M31.875 50.625V39.375H39.375L30 28.125L20.625 39.375H28.125V50.625H18.75V50.5312C18.435 50.55 18.135 50.625 17.8125 50.625C14.0829 50.625 10.506 49.1434 7.86881 46.5062C5.23158 43.869 3.75 40.2921 3.75 36.5625C3.75 29.3475 9.20625 23.4675 16.2075 22.6613C16.8213 19.4523 18.5342 16.5576 21.0514 14.475C23.5686 12.3924 26.7329 11.252 30 11.25C33.2675 11.2518 36.4323 12.3921 38.9502 14.4747C41.4681 16.5573 43.1816 19.452 43.7962 22.6613C50.7975 23.4675 56.2462 29.3475 56.2462 36.5625C56.2462 40.2921 54.7647 43.869 52.1274 46.5062C49.4902 49.1434 45.9134 50.625 42.1837 50.625C41.8687 50.625 41.565 50.55 41.2462 50.5312V50.625H31.875Z"
                                                fill="#47477D"
                                                fill-opacity="0.24"
                                            />
                                        </svg>

                                        <span
                                            id="file-upload-btn"
                                            class="btn uPload-pic-btn document pt-1"
                                        >Upload Document</span
                                        >
                                        <div id="notimage" class="hidden">
                                            Please select an image
                                        </div>
                                        <div class="upload-gray-text">
                                            Drag and drop files here
                                        </div>
                                    </div>
                                    <div id="response" class="hidden">
                                        <div id="messages"></div>
                                        <progress class="progress" id="file-progress" value="0">
                                            <span>0</span>%
                                        </progress>
                                    </div>
                                </label>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Upload End -->

                <button type="button" class="btn float-start cancel-btn">
                    Cancel
                </button>
                <button
                    type="submit"
                    class="btn float-end submit-btn"
                    data-bs-dismiss="modal"
                >
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>
<!-- =========== NAME VERIFICATION MODAL ENDED HERE =============== -->
<!-- =========== NAME PROFESSION MODAL START HERE =============== -->
<!-- Modal -->
<div
    class="modal fade"
    id="exampleModal12"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog verification-modal">
        <div class="modal-content content-modal">
            <div class="modal-header modal-heading">
                <h5 class="modal-title" id="exampleModalLabel">
                    Need Verification!
                </h5>
            </div>
            <div class="modal-body body-modal">
                <h5 class="mb-0">Portfolio Links</h5>
                <p class="mb-0">
                    Your expertise in your newly selected categories will need to be
                    reviewed before you can start providing services in this area.
                </p>
                <!-- Radio Buttons -->
                <div class="radio">
                    <input type="radio" id="tab1" name="tab" checked/>
                    <label for="tab1">Have a Portfolio</label>
                </div>
                <div class="radio">
                    <input type="radio" id="tab2" name="tab"/>
                    <label for="tab2">Don’t Have</label>
                </div>
                <article>
                    <h5 class="pb-0 url-sec">URL <span>*</span></h5>
                    <form action="" class="row profile-form url">
                        <div class="col-12">
                            <input
                                type="text"
                                class="form-control"
                                id="inputAddress"
                                placeholder="https://bravemindstudio.com/"
                            />
                        </div>
                        <div class="col-md-12 field_wrapper">
                            <div>
                                <input
                                    class="add-input inp"
                                    type="text"
                                    name="field_name[]"
                                    value=""
                                    placeholder="https://bravemindstudio.com/"
                                />
                                <a
                                    href="javascript:void(0);"
                                    class="add_button"
                                    title="Add field"
                                ><img src="assets/teacher/asset/img/add-input.svg"
                                    /></a>
                            </div>
                        </div>
                    </form>

                    <!-- Upload start -->
                    <div class="row">
                        <h5 class="url-sec">Certification</h5>
                        <div class="col-md-6 mt-1 file-upload">
                            <div class="become-upload-Card">
                                <form id="file-upload-form" class="uploader">
                                    <input
                                        id="file-upload"
                                        type="file"
                                        name="fileUpload"
                                        accept="image/*"
                                    />

                                    <label for="file-upload" id="file-drag">
                                        <div id="start">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="60"
                                                height="60"
                                                viewBox="0 0 60 60"
                                                fill="none"
                                            >
                                                <path
                                                    d="M31.875 50.625V39.375H39.375L30 28.125L20.625 39.375H28.125V50.625H18.75V50.5312C18.435 50.55 18.135 50.625 17.8125 50.625C14.0829 50.625 10.506 49.1434 7.86881 46.5062C5.23158 43.869 3.75 40.2921 3.75 36.5625C3.75 29.3475 9.20625 23.4675 16.2075 22.6613C16.8213 19.4523 18.5342 16.5576 21.0514 14.475C23.5686 12.3924 26.7329 11.252 30 11.25C33.2675 11.2518 36.4323 12.3921 38.9502 14.4747C41.4681 16.5573 43.1816 19.452 43.7962 22.6613C50.7975 23.4675 56.2462 29.3475 56.2462 36.5625C56.2462 40.2921 54.7647 43.869 52.1274 46.5062C49.4902 49.1434 45.9134 50.625 42.1837 50.625C41.8687 50.625 41.565 50.55 41.2462 50.5312V50.625H31.875Z"
                                                    fill="#47477D"
                                                    fill-opacity="0.24"
                                                />
                                            </svg>

                                            <span
                                                id="file-upload-btn"
                                                class="btn uPload-pic-btn document pt-1"
                                            >Upload Document</span
                                            >
                                            <div id="notimage" class="hidden">
                                                Please select an image
                                            </div>
                                            <div class="upload-gray-text">
                                                Drag and drop files here
                                            </div>
                                        </div>
                                        <div id="response" class="hidden">
                                            <div id="messages"></div>
                                            <progress
                                                class="progress"
                                                id="file-progress"
                                                value="0"
                                            >
                                                <span>0</span>%
                                            </progress>
                                        </div>
                                    </label>
                                </form>
                            </div>
                        </div>
                    </div>
                    <button class="btn add-categories">
                        +&nbsp;Add More Certificates
                    </button>
                    <!-- hide upload certificate section start here -->
                    <!-- <div class="row">
              <h5>Certification</h5>
              <div class="col-md-6 mt-1 file-upload">
                <div class="become-upload-Card">
                  <form id="file-upload-form" class="uploader">
                    <input
                      id="file-upload"
                      type="file"
                      name="fileUpload"
                      accept="image/*"
                    />

                    <label for="file-upload" id="file-drag">
                      <div id="start">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="60"
                          height="60"
                          viewBox="0 0 60 60"
                          fill="none"
                        >
                          <path
                            d="M31.875 50.625V39.375H39.375L30 28.125L20.625 39.375H28.125V50.625H18.75V50.5312C18.435 50.55 18.135 50.625 17.8125 50.625C14.0829 50.625 10.506 49.1434 7.86881 46.5062C5.23158 43.869 3.75 40.2921 3.75 36.5625C3.75 29.3475 9.20625 23.4675 16.2075 22.6613C16.8213 19.4523 18.5342 16.5576 21.0514 14.475C23.5686 12.3924 26.7329 11.252 30 11.25C33.2675 11.2518 36.4323 12.3921 38.9502 14.4747C41.4681 16.5573 43.1816 19.452 43.7962 22.6613C50.7975 23.4675 56.2462 29.3475 56.2462 36.5625C56.2462 40.2921 54.7647 43.869 52.1274 46.5062C49.4902 49.1434 45.9134 50.625 42.1837 50.625C41.8687 50.625 41.565 50.55 41.2462 50.5312V50.625H31.875Z"
                            fill="#47477D"
                            fill-opacity="0.24"
                          />
                        </svg>

                        <span
                          id="file-upload-btn"
                          class="btn uPload-pic-btn document pt-1"
                          >Upload Document</span
                        >
                        <div id="notimage" class="hidden">
                          Please select an image
                        </div>
                        <div class="upload-gray-text">
                          Drag and drop files here
                        </div>
                      </div>
                      <div id="response" class="hidden">
                        <div id="messages"></div>
                        <progress class="progress" id="file-progress" value="0">
                          <span>0</span>%
                        </progress>
                      </div>
                    </label>
                  </form>
                </div>
              </div>
            </div> -->
                    <!-- ended -->
                    <!-- Upload End -->
                    <button type="button" class="btn float-start cancel-btn">
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="btn float-end submit-btn"
                        data-bs-dismiss="modal"
                    >
                        Submit
                    </button>
                </article>
                <article>
                    <!-- Upload start -->
                    <div class="row">
                        <h5 class="url-sec">Certification</h5>
                        <div class="col-md-6 mt-1 file-upload">
                            <div class="become-upload-Card">
                                <form id="file-upload-form" class="uploader">
                                    <input
                                        id="file-upload"
                                        type="file"
                                        name="fileUpload"
                                        accept="image/*"
                                    />

                                    <label for="file-upload" id="file-drag">
                                        <div id="start">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="60"
                                                height="60"
                                                viewBox="0 0 60 60"
                                                fill="none"
                                            >
                                                <path
                                                    d="M31.875 50.625V39.375H39.375L30 28.125L20.625 39.375H28.125V50.625H18.75V50.5312C18.435 50.55 18.135 50.625 17.8125 50.625C14.0829 50.625 10.506 49.1434 7.86881 46.5062C5.23158 43.869 3.75 40.2921 3.75 36.5625C3.75 29.3475 9.20625 23.4675 16.2075 22.6613C16.8213 19.4523 18.5342 16.5576 21.0514 14.475C23.5686 12.3924 26.7329 11.252 30 11.25C33.2675 11.2518 36.4323 12.3921 38.9502 14.4747C41.4681 16.5573 43.1816 19.452 43.7962 22.6613C50.7975 23.4675 56.2462 29.3475 56.2462 36.5625C56.2462 40.2921 54.7647 43.869 52.1274 46.5062C49.4902 49.1434 45.9134 50.625 42.1837 50.625C41.8687 50.625 41.565 50.55 41.2462 50.5312V50.625H31.875Z"
                                                    fill="#47477D"
                                                    fill-opacity="0.24"
                                                />
                                            </svg>

                                            <span
                                                id="file-upload-btn"
                                                class="btn uPload-pic-btn document pt-1"
                                            >Upload Document</span
                                            >
                                            <div id="notimage" class="hidden">
                                                Please select an image
                                            </div>
                                            <div class="upload-gray-text">
                                                Drag and drop files here
                                            </div>
                                        </div>
                                        <div id="response" class="hidden">
                                            <div id="messages"></div>
                                            <progress
                                                class="progress"
                                                id="file-progress"
                                                value="0"
                                            >
                                                <span>0</span>%
                                            </progress>
                                        </div>
                                    </label>
                                </form>
                            </div>
                        </div>
                    </div>
                    <button class="btn add-categories">
                        +&nbsp;Add More Certificates
                    </button>
                    <button type="button" class="btn float-start cancel-btn">
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="btn float-end submit-btn"
                        data-bs-dismiss="modal"
                    >
                        Submit
                    </button>
                </article>
            </div>
        </div>
    </div>
</div>
<!-- =========== NAME PROFESSION MODAL ENDED HERE =============== -->
<!-- =========== ADD NEW FAQ's MODAL START HERE =============== -->
<!-- Modal -->
<div
    class="modal fade"
    id="exampleModal2"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog verification-modal">
        <div class="modal-content content-modal">
            <div class="modal-header modal-heading">
                <h5 class="modal-title" id="exampleModalLabel">Add New FAQ</h5>
            </div>
            <div class="modal-body body-modal">
                <form action="" class="row p-0 profile-form">
                    <div class="col-12">
                        <label for="inputAddress" class="form-label">Question</label>
                        <input
                            type="text"
                            class="form-control"
                            id="inputAddress"
                            placeholder="How can you deliver my project to me?"
                        />
                    </div>
                    <div class="col-12">
                        <label for="inputAddress2" class="form-label mt-3"
                        >Answer</label
                        >
                        <textarea
                            name=""
                            id=""
                            cols="30"
                            rows="10"
                            placeholder="write the answer here...."
                        ></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="add-button">
                                <button class="btn add-btn">Add</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- =========== ADD NEW FAQ's MODAL ENDED HERE =============== -->
<!-- =========== FAQ's MODAL START HERE =============== -->
<!-- Modal -->
<!-- <div
      class="modal fade"
      id="exampleModal3"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog verification-modal">
        <div class="modal-content content-modal">
          <div class="modal-header modal-heading">
            <h5 class="modal-title" id="exampleModalLabel">Edit FAQ’s</h5>
          </div>
          <div class="modal-body body-modal">
            <form action="" class="row p-0 profile-form">
              <div class="col-12">
                <label for="inputAddress" class="form-label">Question</label>
                <input
                  type="text"
                  class="form-control"
                  id="inputAddress"
                  placeholder="How can you deliver my project to me?"
                />
              </div>
              <div class="col-12">
                <label for="inputAddress2" class="form-label mt-3"
                  >Answer</label
                >
                <textarea
                  name=""
                  id=""
                  cols="30"
                  rows="10"
                  placeholder="write the answer here...."
                ></textarea>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="add-button">
                    <button class="btn add-btn remove-btn">Remove</button>
                    <button class="btn add-btn">Add</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div> -->
<!-- =========== FAQ's MODAL ENDED HERE =============== -->
<!-- =========== ADD NEW CATEGORY MODAL START HERE =============== -->
<!-- Modal -->
<div
    class="modal fade"
    id="exampleModal4"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog verification-modal">
        <div class="modal-content content-modal">
            <div class="modal-header modal-heading">
                <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
            </div>
            <div class="modal-body body-modal">
                <form action="" class="row p-0 profile-form">
                    <div class="col-12">
                        <label for="inputAddress" class="form-label">Category</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>--Select Category--</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="inputAddress2" class="form-label mt-3"
                        >Sub Categories</label
                        >
                        <textarea
                            name=""
                            id=""
                            cols="30"
                            rows="10"
                            placeholder="write the answer here...."
                        ></textarea>
                    </div>
                    <div class="add-button">
                        <button type="button" class="btn float-start cancel-btn">
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="btn float-end submit-btn"
                            data-bs-dismiss="modal"
                        >
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- =========== ADD NEW CATEGORY MODAL ENDED HERE =============== -->


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

<script src="assets/teacher/libs/jquery/jquery.js"></script>
<script src="assets/teacher/libs/aos/js/aos.js"></script>
<script src="assets/teacher/libs/datatable/js/datatable.js"></script>
<script src="assets/teacher/libs/datatable/js/datatablebootstrap.js"></script>
<script src="assets/teacher/libs/select2/js/select2.min.js"></script>
<script src="assets/expert/asset/js/bootstrap.min.js"></script>
<!-- <script src="assets/teacher/libs/owl-carousel/js/jquery.min.js"></script> -->
<script src="assets/teacher/libs/owl-carousel/js/owl.carousel.min.js"></script>
<!--  -->

{{-- Fetch Country City Zipcode Script Start ======= --}}
{{-- CDN For Script --}}
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMA8qhhaBOYY1uv0nUfsBGcE74w6JNY7M&libraries=places"></script>

<script>

    // Lguage Condition Set Hide Show Script Start =======
    $(document).ready(function () {
        var primary_lang = '<?php echo $profile->primary_language ?>'
        if (primary_lang == 'English') {
            $('#fluent_main_div').hide();
        } else {
            $('#fluent_main_div').show();

        }
    });

    $('#primary_language').on('change', function () {
        var primary_lang = $('#primary_language').val();

        if (primary_lang == 'English') {
            $('#other_language_main_div').removeClass('col-12');
            $('#other_language_main_div').addClass('col-6');
            $('#fluent_main_div').hide();
        } else {
            $('#other_language_main_div').removeClass('col-6');
            $('#other_language_main_div').addClass('col-12');
            $('#fluent_main_div').show();

        }
    });


    $('#show_full_name').on('click', function () {
        if ($('#show_full_name').attr('checked')) {
            $('#show_full_name').removeAttr('checked');
            $('#show_full_name_val').val(0);
        } else {
            $('#show_full_name_val').val(1);
            $('#show_full_name').attr('checked', 1);
        }

    });

    $('#speak_other_language').on('click', function () {
        var other_lang = '<?php echo $profile->fluent_other_language ?>'
        if ($('#speak_other_language').attr('checked')) {
            $('#speak_other_language').removeAttr('checked');
            $('#other_language_main_div').hide();
            $('#other_lang').val('');
            $('#speak_other_lang').val(0);
        } else {
            $('#speak_other_lang').val(1);
            $('#speak_other_language').attr('checked', 1);
            $('#other_language_main_div').show();
            $('#other_lang').val(other_lang);
        }

    });
    // Lguage Condition Set Hide Show Script END =======


    //  Onclick Live Location Dedect ==== Start Script

    var locationInput = document.getElementById('street_address');

    // When the input is clicked, detect and autofill the live location
    locationInput.addEventListener('click', function () {
        // Check if the browser supports Geolocation API
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;

                console.log('Latitude: ' + latitude + ', Longitude: ' + longitude);

                // Initialize Google Geocoder
                var geocoder = new google.maps.Geocoder();
                var latlng = {lat: latitude, lng: longitude};

                // Use Geocoder to get address from lat/lng
                geocoder.geocode({'location': latlng}, function (results, status) {
                    if (status === 'OK') {
                        if (results[0]) {
                            var liveAddress = results[0].formatted_address;
                            console.log('Detected Address: ' + liveAddress);

                            // Autofill the input field with the detected address
                            locationInput.value = liveAddress;

                            // Optional: Extract specific details such as country, city, postal code, country code
                            var components = results[0].address_components;
                            var country = '';
                            var city = '';
                            var postalCode = '';
                            var countryCode = ''; // For storing country code

                            components.forEach(function (component) {
                                if (component.types.includes('country')) {
                                    country = component.long_name;     // Full country name
                                    countryCode = component.short_name; // Country code
                                }
                                if (component.types.includes('postal_town')) {
                                    city = component.long_name;
                                } else if (component.types.includes('administrative_area_level_3') && !city) {
                                    city = component.long_name; // Fallback to administrative area
                                } else if (component.types.includes('administrative_area_level_2') && !city) {
                                    city = component.long_name; // Fallback to administrative area
                                } else if (component.types.includes('administrative_area_level_1') && !city) {
                                    city = component.long_name; // Fallback to administrative area
                                }
                                if (component.types.includes('postal_code')) {
                                    postalCode = component.long_name;
                                }
                            });

                            $('#country').val(country);
                            $('#city').val(city);
                            $('#zip_code').val(postalCode);
                            $('#country_code').val(countryCode);
                            $('#latitude').val(latitude);
                            $('#longitude').val(longitude);

                            // IpAddress Detect Script Function Start ===
                            $.get('https://api.ipify.org?format=json', function (data) {
                                var ipAddress = data.ip;
                                // console.log('IP Address: ' + ipAddress);
                                document.getElementById('ip_address').value = ipAddress;
                                // You can now use the IP address along with location info
                            });
                            // IpAddress Detect Script Function END =====


                        } else {
                            console.log('No results found');
                        }
                    } else {
                        console.log('Geocoder failed due to: ' + status);
                    }
                });
            }, function (error) {
                console.log("Error occurred. Error code: " + error.code);
                // Handle different error cases
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        alert("User denied the request for Geolocation.");
                        break;
                    case error.POSITION_UNAVAILABLE:
                        alert("Location information is unavailable.");
                        break;
                    case error.TIMEOUT:
                        alert("The request to get user location timed out.");
                        break;
                    case error.UNKNOWN_ERROR:
                        alert("An unknown error occurred.");
                        break;
                }
            }, {
                enableHighAccuracy: true  // Enables high-accuracy mode for better location results
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    });


</script>
{{-- Fetch Country City Zipcode Script END ======= --}}

{{-- Category Fetch Script Start ========== --}}
<script>
    function ViewClassSub(Clicked) {

        const get_num = Clicked.replace(/\D+/g, ''); // \D matches non-digit characters


        let cate_id = $("#" + Clicked).data("cate");

        var app_id = '<?php echo $profile->id ?>';
        var service_type = '<?php echo $profile->service_type ?>';
        // var all_sub_cate = '<?php echo $profile->sub_category_class ?>' ;


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: '/get-class-sub-category',
            data: {app_id: app_id, service_type: service_type, cate_id: cate_id, _token: '{{csrf_token()}}'},
            dataType: 'json',
            success: function (response) {

                ClassSubCate(response, Clicked);


            },

        });


    }


    function ViewFreelanceSub(Clicked) {

        const get_num = Clicked.replace(/\D+/g, ''); // \D matches non-digit characters


        let cate_id = $("#" + Clicked).data("cate");

        var app_id = '<?php echo $profile->id ?>';
        var service_type = '<?php echo $profile->service_type ?>';
        // var all_sub_cate = '<?php echo $profile->sub_category_freelance ?>' ;


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: '/get-class-sub-category',
            data: {app_id: app_id, service_type: service_type, cate_id: cate_id, _token: '{{csrf_token()}}'},
            dataType: 'json',
            success: function (response) {

                FreelanceSubCate(response, Clicked);


            },

        });


    }


    function ClassSubCate(response, Clicked) {

        var cate_get = response['sub_cate'];


        if (cate_get == null) {
            toastr.options =
                {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "10000", // 10 seconds
                    "extendedTimeOut": "4410000" // 10 seconds
                }
            toastr.error("Not Have Sub Categories in This!");
            return false;
        }

        const get_num = Clicked.replace(/\D+/g, ''); // \D matches non-digit characters

        var view_btn = $('#' + Clicked).html();

        if (view_btn == 'Hide') {
            var view_btn = $('#' + Clicked).html('View');
            $('#class_sub_cate_' + get_num).empty();
            $('#reject_class_category_' + get_num).css('display', 'none');

            return false;

        } else {
            var view_btn = $('#' + Clicked).html('Hide');
            $('#reject_class_category_' + get_num).css('display', 'block');
        }

        if (cate_get == null) {
            toastr.options =
                {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "10000", // 10 seconds
                    "extendedTimeOut": "4410000" // 10 seconds
                }
            toastr.error("Not Have Sub Categories in This!");
            return false;
        }
        var array1 = cate_get;
        let cleanedArray1 = array1.map(item => item.trim());
        var cate_have = '<?php echo $profile->sub_category_class ?>';
        cate_have = cate_have.split('|*|');
        var cates_type = $('#' + Clicked).data('cates_type');
        if (cates_type == 'Online') {
            var array2 = cate_have[0].split(',');
        } else {
            var array2 = cate_have[1].split(',');
        }
        let cleanedArray2 = array2.map(item => item.trim());

        const commonElements = cleanedArray1.filter(item => cleanedArray2.includes(item));

        if (commonElements.length == 0) {
            toastr.options =
                {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "10000", // 10 seconds
                    "extendedTimeOut": "4410000" // 10 seconds
                }
            toastr.error("Not Have Sub Categories in This!");
            return false;
        }


        $('#class_sub_cate_' + get_num).empty();

        var sub_cate_html = '';

        for (let i = 0; i < commonElements.length; i++) {
            const element = commonElements[i];
            if (i == 0) {
                sub_cate_html += '<label for="car" class="form-label">Class Sub Category</label>';
            }
            sub_cate_html += '<div class="row mb-2" id="class_sub_cate_div_' + i + '">' +
                '<div class="col-md-10 input_group2">' +
                '<input class="form-control" list="datalistOptions" value="' + element + '" id="car" readonly placeholder="Graphic Designer">' +
                '</div>' +
                '<div class="col-md-2 button_group2">' +
                '<button class="btn_reject btn btn-outline-secondary remove-button" onclick="RejectSubCateClass(this.id)" id="sub_cate_' + i + '" data-cate="' + element + '" data-service_type="class_sub"  data-cates_type="' + cates_type + '" >Remove</button>' +
                '</div> ' +
                '</div>';


        }
        $('#class_sub_cate_' + get_num).append(sub_cate_html);


    }


    function FreelanceSubCate(response, Clicked) {

        var cate_get = response['sub_cate'];


        if (cate_get == null) {
            toastr.options =
                {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "10000", // 10 seconds
                    "extendedTimeOut": "4410000" // 10 seconds
                }
            toastr.error("Not Have Sub Categories in This!");
            return false;
        }
        const get_num = Clicked.replace(/\D+/g, ''); // \D matches non-digit characters

        var view_btn = $('#' + Clicked).html();

        if (view_btn == 'Hide') {
            var view_btn = $('#' + Clicked).html('View');
            $('#freelance_sub_cate_' + get_num).empty();
            $('#reject_freelance_category_' + get_num).css('display', 'none');

            return false;

        } else {
            var view_btn = $('#' + Clicked).html('Hide');
            $('#reject_freelance_category_' + get_num).css('display', 'block');
        }

        if (cate_get == null) {
            toastr.options =
                {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "10000", // 10 seconds
                    "extendedTimeOut": "4410000" // 10 seconds
                }
            toastr.error("Not Have Sub Categories in This!");
            return false;
        }

        var array1 = cate_get;
        let cleanedArray1 = array1.map(item => item.trim());
        var cate_have = '<?php echo $profile->sub_category_freelance ?>';
        cate_have = cate_have.split('|*|');
        var cates_type = $('#' + Clicked).data('cates_type');
        if (cates_type == 'Online') {
            var array2 = cate_have[0].split(',');
        } else {
            var array2 = cate_have[1].split(',');
        }
        let cleanedArray2 = array2.map(item => item.trim());

        const commonElements = cleanedArray1.filter(item => cleanedArray2.includes(item));

        if (commonElements.length == 0) {
            toastr.options =
                {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "10000", // 10 seconds
                    "extendedTimeOut": "4410000" // 10 seconds
                }
            toastr.error("Not Have Sub Categories in This!");
            return false;
        }


        $('#freelance_sub_cate_' + get_num).empty();

        var sub_cate_html = '';

        for (let i = 0; i < commonElements.length; i++) {
            const element = commonElements[i];
            if (i == 0) {
                sub_cate_html += '<label for="car" class="form-label">Freelance Sub Category</label>';
            }
            sub_cate_html += '<div class="row mb-2" id="freelance_sub_cate_div_' + i + '">' +
                '<div class="col-md-10 input_group2">' +
                '<input class="form-control" list="datalistOptions" value="' + element + '" id="car" readonly placeholder="Graphic Designer">' +
                '</div>' +
                '<div class="col-md-2 button_group2">' +
                '<button class="btn_reject btn btn-outline-secondary remove-button" onclick="RejectSubCateClass(this.id)" id="sub_cate_' + i + '" data-cate="' + element + '" data-service_type="freelance_sub"  data-cates_type="' + cates_type + '" >Remove</button>' +
                '</div> ' +
                '</div>';


        }
        $('#freelance_sub_cate_' + get_num).append(sub_cate_html);


    }


    //  Main Category Reject Function Start =======
    function RejectCategory(Clicked) {

        if (!confirm("Are You Sure, You Want to Remove ?")) {
            return false;
        }

        var cate_id = $('#' + Clicked).data('category');
        var type = $('#' + Clicked).data('type');
        var app_id = '<?php echo $profile->id ?>';


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: '/reject-application-category',
            data: {app_id: app_id, cate_id: cate_id, type: type, _token: '{{csrf_token()}}'},
            dataType: 'json',
            success: function (response) {

                const get_num = Clicked.replace(/\D+/g, '');
                if (response.success) {
                    if (response.type == 'Class') {
                        $('.main_class_' + get_num).remove();
                        $('#class_sub_cate_' + get_num).remove();
                    } else {
                        $('.main_freelance_' + get_num).remove();
                        $('#freelance_sub_cate_' + get_num).remove();
                    }


                    toastr.options =
                        {
                            "closeButton": true,
                            "progressBar": true,
                            "timeOut": "10000", // 10 seconds
                            "extendedTimeOut": "4410000" // 10 seconds
                        }
                    toastr.success(response.message);

                } else {

                    toastr.options =
                        {
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

    //  Main Category Reject Function END =======


    // Reject Sub Category Start =======


    function RejectSubCateClass(Clicked) {

        if (!confirm("Are You Sure, You Want to Remove ?")) {
            return false;
        }

        var sub_cate = $('#' + Clicked).data('cate');
        var cates_type = $('#' + Clicked).data('cates_type');
        var service_type = $('#' + Clicked).data('service_type');
        const get_num = Clicked.replace(/\D+/g, ''); // \D matches non-digit characters
        if (service_type == 'class_sub') {
            var array = '<?php echo $profile->sub_category_class ?>';
            array = array.split('|*|');

        } else {
            var array = '<?php echo $profile->sub_category_freelance ?>';
            array = array.split('|*|');
        }

        if (cates_type == 'Online') {
            array = array[0].split(',');
        } else {
            array = array[1].split(',');
        }

        // Remove the string from the array
        const updatedArray = array.reduce((acc, item) => {
            if (item !== sub_cate) {
                acc.push(item);
            }
            return acc;
        }, []);
        var app_id = '<?php echo $profile->id ?>';
        var sub_category = updatedArray;

        sub_category = sub_category.join(',');


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: '/reject-class-sub-category',
            data: {
                app_id: app_id,
                service_type: service_type,
                sub_category: sub_category,
                cates_type: cates_type,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (response) {

                if (response.success) {

                    if (response.service_type == 'class_sub') {
                        $('#class_sub_cate_div_' + get_num).remove();
                    } else {
                        $('#freelance_sub_cate_div_' + get_num).remove();
                    }

                    toastr.options =
                        {
                            "closeButton": true,
                            "progressBar": true,
                            "timeOut": "10000", // 10 seconds
                            "extendedTimeOut": "4410000" // 10 seconds
                        }
                    toastr.success(response.message);

                } else {

                    toastr.options =
                        {
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


    // Reject Sub Category END =======


</script>
{{-- Category Fetch Script END =========== --}}

{{-- Other Languages Selection --}}
<script>

    function SelectLanguages() {
        const chBoxes4 = document.querySelectorAll(".dropdown-menu .language-input");
        const dpBtn4 = document.getElementById("multiSelectDropdown4");
        let mySelectedListItems4 = [];

        function handleCB() {
            mySelectedListItems4 = [];
            let mySelectedListItemsText4 = "";

            chBoxes4.forEach((checkbox) => {
                if (checkbox.checked) {
                    mySelectedListItems4.push(checkbox.value);
                    mySelectedListItemsText4 += checkbox.value + ", ";
                }
            });

            dpBtn4.innerText =
                mySelectedListItems4.length > 0
                    ? mySelectedListItemsText4.slice(0, -2)
                    : "--select Language--";

            var other_lang = $('#multiSelectDropdown4').html();
            if (other_lang == '--select Language--') {
                $('#other_lang').val(null);
            } else {
                other_lang = other_lang.replace(/,\s+/g, ',');
                $('#other_lang').val(other_lang);

            }

        }

        chBoxes4.forEach((checkbox) => {
            checkbox.addEventListener("change", handleCB);
        });

    }
</script>
{{-- Other Languages Selection --}}
<!-- ================ side js start here=============== -->
<!-- ================ side js start End=============== -->
<!--  -->
<!-- profile-upload -->
<script>
    // Profile Upload
    //
    function readURL(input) {
        if (input.files && input.files[0]) {

            if (input.files[0].size > 1048576) {
                alert("Maximmum Image Size 1MB Allowed!");
                input.value = "";
                return false;
            }
            var reader = new FileReader();
            reader.onload = function (e) {


                var image = new Image();
                //Set the Base64 string return from FileReader as source.
                image.src = e.target.result;
                let data;
                image.onload = function () {
                    //Determine the Height and Width.
                    var height = this.height;
                    var width = this.width;
                    data = "true";


                };

                setTimeout(() => {
                    if (data == "true") {

                        $("#imagePreview").css(
                            "background-image",
                            "url(" + e.target.result + ")"
                        );
                        $("#imagePreview").hide();
                        $("#imagePreview").fadeIn(650);

                    }
                }, 10);


            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imageUpload").change(function () {
        readURL(this);
    });
</script>
<!-- ============ -->
<!-- upload image js -->
<script>
    jQuery(document).ready(function () {
        ImgUpload();
    });

    function ImgUpload() {
        var imgWrap = "";
        var imgArray = [];

        $(".upload__inputfile").each(function () {
            $(this).on("change", function (e) {
                imgWrap = $(this).closest(".upload__box").find(".upload__img-wrap");
                var maxLength = $(this).attr("data-max_length");

                var files = e.target.files;
                var filesArr = Array.prototype.slice.call(files);
                var iterator = 0;
                filesArr.forEach(function (f, index) {
                    if (!f.type.match("image.*")) {
                        return;
                    }

                    if (imgArray.length > maxLength) {
                        return false;
                    } else {
                        var len = 0;
                        for (var i = 0; i < imgArray.length; i++) {
                            if (imgArray[i] !== undefined) {
                                len++;
                            }
                        }
                        if (len > maxLength) {
                            return false;
                        } else {
                            imgArray.push(f);

                            var reader = new FileReader();
                            reader.onload = function (e) {
                                var html =
                                    "<div class='upload__img-box'><div style='background-image: url(" +
                                    e.target.result +
                                    ")' data-number='" +
                                    $(".upload__img-close").length +
                                    "' data-file='" +
                                    f.name +
                                    "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                                imgWrap.append(html);
                                iterator++;
                            };
                            reader.readAsDataURL(f);
                        }
                    }
                });
            });
        });

        $("body").on("click", ".upload__img-close", function (e) {
            var file = $(this).parent().data("file");
            for (var i = 0; i < imgArray.length; i++) {
                if (imgArray[i].name === file) {
                    imgArray.splice(i, 1);
                    break;
                }
            }
            $(this).parent().parent().remove();
        });
    }
</script>
<!-- upload image js ended here -->
<!-- Hidden form on view button js -->
<script>
    var div = document.getElementById("main");
    var display = 0;

    function hideShow() {
        if (display == 1) {
            div.style.display = "block";
            display = 0;
        } else {
            div.style.display = "none";
            display = 1;
        }
    }
</script>
<!-- Hidden Input Field -->
<script>
    function removeAllDivs() {
        var divs = document.querySelectorAll(".row.input_fields_wrap > div");
        divs.forEach(function (div) {
            div.parentNode.removeChild(div);
        });
    }

    function hideAllDivs() {
        var divs = document.querySelectorAll(".row.input_fields_wrap > div");
        divs.forEach(function (div) {
            div.style.display = "none";
        });
    }
</script>
<!-- Radio tab menu js start from here -->
<script>
    $("[name=tab]").each(function (i, d) {
        var p = $(this).prop("checked");
        //   console.log(p);
        if (p) {
            $("article").eq(i).addClass("on");
        }
    });

    $("[name=tab]").on("change", function () {
        var p = $(this).prop("checked");

        // $(type).index(this) == nth-of-type
        var i = $("[name=tab]").index(this);

        $("article").removeClass("on");
        $("article").eq(i).addClass("on");
    });
</script>
<!-- hide remove input field js -->
<script>
    window.addEventListener("DOMContentLoaded", () => {
        var counter = 0;
        var newFields = document
            .getElementById("input_fields-wrap-1")
            .cloneNode(true);
        newFields.id = "";
        var newField = newFields.childNodes;

        document
            .getElementById("add_field_button")
            .addEventListener("click", () => {
                for (var i = 0; i < newField.length; i++) {
                    var theName = newField[i].name;
                    if (theName) newField[i].name = theName + counter;
                }

                var insertHere = document.getElementById("input_fields_write");
                insertHere.parentNode.insertBefore(newFields, insertHere);
            });
    });

    function hideField(element) {
        element.style.display = "none";
    }
</script>
<!-- Upload script start -->
<script>
    var main_img = '<?php echo $profile->main_image ?>';
    var more_img_1 = '<?php echo $profile->more_image_1 ?>';
    var more_img_2 = '<?php echo $profile->more_image_2 ?>';
    var more_img_3 = '<?php echo $profile->more_image_3 ?>';
    var more_img_4 = '<?php echo $profile->more_image_4 ?>';
    var more_img_5 = '<?php echo $profile->more_image_5 ?>';
    var more_img_6 = '<?php echo $profile->more_image_6 ?>';
    var video_1 = '<?php echo $profile->video ?>';
    if (main_img == '') {
        var main_image = null;
    } else {
        var main_image = 'assets/expert/asset/img/<?php echo $profile->main_image ?>';
    }

    if (more_img_1 == '') {
        var more_image_1 = null;
    } else {
        var more_image_1 = 'assets/expert/asset/img/<?php echo $profile->more_image_1 ?>';
    }
    if (more_img_2 == '') {
        var more_image_2 = null;
    } else {
        var more_image_2 = 'assets/expert/asset/img/<?php echo $profile->more_image_1 ?>';
    }
    if (more_img_3 == '') {
        var more_image_3 = null;
    } else {
        var more_image_3 = 'assets/expert/asset/img/<?php echo $profile->more_image_1 ?>';
    }
    if (more_img_4 == '') {
        var more_image_4 = null;
    } else {
        var more_image_4 = 'assets/expert/asset/img/<?php echo $profile->more_image_1 ?>';
    }
    if (more_img_5 == '') {
        var more_image_5 = null;
    } else {
        var more_image_5 = 'assets/expert/asset/img/<?php echo $profile->more_image_1 ?>';
    }
    if (more_img_6 == '') {
        var more_image_6 = null;
    } else {
        var more_image_6 = 'assets/expert/asset/img/<?php echo $profile->more_image_1 ?>';
    }
    if (video_1 == '') {
        var video = null;
    } else {
        var video = 'assets/expert/asset/img/<?php echo $profile->video ?>';
    }


    // 1
    new Vue({
        el: "#upload-image",
        data() {
            return {
                preview: main_image,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                if (!confirm("Are You Sure, You Want to Remove ?")) {
                    return false;
                }
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
    // 2
    new Vue({
        el: "#upload-image1",
        data() {
            return {
                preview: more_image_1,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                if (!confirm("Are You Sure, You Want to Remove ?")) {
                    return false;
                }
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
    // 3
    new Vue({
        el: "#upload-image2",
        data() {
            return {
                preview: more_image_2,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                if (!confirm("Are You Sure, You Want to Remove ?")) {
                    return false;
                }
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
    // 4
    new Vue({
        el: "#upload-image3",
        data() {
            return {
                preview: more_image_3,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                if (!confirm("Are You Sure, You Want to Remove ?")) {
                    return false;
                }
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
    // 5
    new Vue({
        el: "#upload-image4",
        data() {
            return {
                preview: more_image_4,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                if (!confirm("Are You Sure, You Want to Remove ?")) {
                    return false;
                }
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
    // 6
    new Vue({
        el: "#upload-image5",
        data() {
            return {
                preview: more_image_5,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                if (!confirm("Are You Sure, You Want to Remove ?")) {
                    return false;
                }
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
    // 7
    new Vue({
        el: "#upload-image6",
        data() {
            return {
                preview: more_image_6,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                if (!confirm("Are You Sure, You Want to Remove ?")) {
                    return false;
                }
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
    // 8
    new Vue({
        el: "#upload-image7",
        data() {
            return {
                preview: video,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                if (!confirm("Are You Sure, You Want to Remove ?")) {
                    return false;
                }
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
    // 9
    new Vue({
        el: "#upload-image8",
        data() {
            return {
                preview: null,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                if (!confirm("Are You Sure, You Want to Remove ?")) {
                    return false;
                }
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
    // 10
    new Vue({
        el: "#upload-image9",
        data() {
            return {
                preview: null,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                if (!confirm("Are You Sure, You Want to Remove ?")) {
                    return false;
                }
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
    // 11
    new Vue({
        el: "#upload-image10",
        data() {
            return {
                preview: null,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                if (!confirm("Are You Sure, You Want to Remove ?")) {
                    return false;
                }
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
    // 12
    new Vue({
        el: "#upload-image11",
        data() {
            return {
                preview: null,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
    // 13
    new Vue({
        el: "#upload-image12",
        data() {
            return {
                preview: null,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
    // 14
    new Vue({
        el: "#upload-image13",
        data() {
            return {
                preview: null,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
    // 15
    new Vue({
        el: "#upload-image14",
        data() {
            return {
                preview: null,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
    // 16
    new Vue({
        el: "#upload-image15",
        data() {
            return {
                preview: null,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
    // 17
    new Vue({
        el: "#upload-image16",
        data() {
            return {
                preview: null,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
    // 18
    new Vue({
        el: "#upload-image17",
        data() {
            return {
                preview: null,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
    // 19
    new Vue({
        el: "#upload-image18",
        data() {
            return {
                preview: null,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
    // 20
    new Vue({
        el: "#upload-image19",
        data() {
            return {
                preview: null,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
    // 21
    new Vue({
        el: "#upload-image20",
        data() {
            return {
                preview: null,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
    // 22
    new Vue({
        el: "#upload-image21",
        data() {
            return {
                preview: null,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
    // 23
    new Vue({
        el: "#upload-image22",
        data() {
            return {
                preview: null,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
    // 24
    new Vue({
        el: "#upload-image23",
        data() {
            return {
                preview: null,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
    // 25
    new Vue({
        el: "#upload-image24",
        data() {
            return {
                preview: null,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
    // 26
    new Vue({
        el: "#upload-image25",
        data() {
            return {
                preview: null,
                image: null,
            };
        },
        methods: {
            previewImage: function (id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function (id) {
                this.image = null;
                this.preview = null;
                // Clear the input element
                document.getElementById(id).value = "";
            },
        },
    });
</script>
<!-- Upload script End -->
<!-- FAQs js start -->
<!-- <script>
      const accordionItemHeaders = document.querySelectorAll(
        ".accordion-item-header"
      );

      accordionItemHeaders.forEach((accordionItemHeader) => {
        accordionItemHeader.addEventListener("click", (event) => {
          // Uncomment in case you only want to allow for the display of only one collapsed item at a time!

          const currentlyActiveAccordionItemHeader = document.querySelector(
            ".accordion-item-header.active"
          );
          if (
            currentlyActiveAccordionItemHeader &&
            currentlyActiveAccordionItemHeader !== accordionItemHeader
          ) {
            currentlyActiveAccordionItemHeader.classList.toggle("active");
            currentlyActiveAccordionItemHeader.nextElementSibling.style.maxHeight = 0;
          }
          accordionItemHeader.classList.toggle("active");
          const accordionItemBody = accordionItemHeader.nextElementSibling;
          if (accordionItemHeader.classList.contains("active")) {
            accordionItemBody.style.maxHeight =
              accordionItemBody.scrollHeight + "px";
          } else {
            accordionItemBody.style.maxHeight = 0;
          }
        });
      });
    </script> -->

<!-- FAQs js end -->
<script>
    $(document).ready(function () {
        $(".owl-carousel").owlCarousel({
            items: 4,
            margin: 30,
        });
    });
</script>

<script>
    $(document).ready(function () {
        $(".js-example-basic-multiple").select2();
    });
</script>
<script>
    new DataTable("#example", {
        scrollX: true,
    });
</script>
<!-- category -->
<script>
    function changeStructure(response, Clicked) {
        var button = document.getElementById(Clicked);
        var categoryDiv = button.parentElement;


        var categoryContainer = categoryDiv.parentElement;

        const get_num = Clicked.replace(/\D+/g, '');
        // Create the main div
        var mainDiv = document.getElementById("class_sub_cate_" + get_num);
        mainDiv.classList.add("main");


        // Create the form inside the main div
        var form = document.createElement("div");
        form.classList.add("profile-form");
        form.id = "class_sub_div_" + get_num;


        // Create the input fields inside the form
        var rowDiv = document.createElement("div");
        rowDiv.classList.add("row", "input_fields_wrap");

        var colDiv = document.createElement("div");
        colDiv.classList.add("col-md-12");

        var categoryLabel = document.createElement("label");
        categoryLabel.htmlFor = "inputEmail4";
        categoryLabel.classList.add("form-label");
        categoryLabel.textContent = "Category";

        var inputGroupDiv = document.createElement("div");
        inputGroupDiv.classList.add(
            "input-group",
            "mb-3",
            "category-input-group"
        );
        inputGroupDiv.id = "input-group-" + get_num;


        var inputField = document.createElement("input");
        inputField.type = "text";
        inputField.value = response['sub_cate'].category;
        inputField.classList.add("form-control", "form-control-lg");
        inputField.name = "category_name[]";
        inputField.placeholder = "Graphic Design";
        inputField.ariaLabel = "category Name";

        inputField.ariaDescribedBy = "button-addon";
        $(inputField).attr('readonly', 1);

        var removeButton = document.createElement("button");
        removeButton.type = "button";
        removeButton.classList.add(
            "btn",
            "btn-outline-secondary",
            "remove-button"
        );
        removeButton.id = "button-addon";
        removeButton.textContent = "Remove";
        removeButton.onclick = function () {
            mainDiv.remove();
            categoryDiv.remove();
        };

        var hideButton = document.createElement("button");
        hideButton.type = "button";
        hideButton.classList.add("btn", "btn-outline-secondary", "hide-button");
        hideButton.id = "hide-button";
        hideButton.textContent = "Hide";
        hideButton.onclick = function () {
            mainDiv.style.display = "none";
            categoryDiv.style.display = "flex";
            // Reset the width of the input group
            inputGroupDiv.classList.remove("wide-input-group");
        };

        // Append elements to their respective parents
        inputGroupDiv.appendChild(inputField);
        inputGroupDiv.appendChild(removeButton);
        inputGroupDiv.appendChild(hideButton);

        colDiv.appendChild(categoryLabel);
        colDiv.appendChild(inputGroupDiv);

        rowDiv.appendChild(colDiv);


        var cate_get = response['sub_cate'].sub_category;
        if (cate_get == null) {
            toastr.options =
                {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "10000", // 10 seconds
                    "extendedTimeOut": "4410000" // 10 seconds
                }
            toastr.error("Not Have Sub Categories in This!");
            return false;
        }
        var array1 = cate_get.split(',');

        var cate_have = '<?php echo $profile->sub_category_class ?>';
        cate_have = cate_have.split('|*|');
        var cates_type = $('#' + Clicked).data('cates_type');
        if (cates_type == 'Online') {
            var array2 = cate_have[0].split(',');
        } else {
            var array2 = cate_have[1].split(',');
        }

        const commonElements = array1.filter(item => array2.includes(item));

        if (commonElements.length == 0) {
            toastr.options =
                {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "10000", // 10 seconds
                    "extendedTimeOut": "4410000" // 10 seconds
                }
            toastr.error("Not Have Sub Categories in This!");
            return false;
        }

        var subCateGroupDiv = document.createElement("div");
        subCateGroupDiv.classList.add(
            "sub-class-group",
            "mb-3",
            "category-input-group"
        );
        subCateGroupDiv.id = "sub-group-" + get_num;

        var sub_cate_html = '';

        for (let i = 0; i < commonElements.length; i++) {
            const element = commonElements[i];
            if (i == 0) {
                sub_cate_html += '<label for="car" class="form-label">Class Sub Category</label>';
            }
            sub_cate_html += '<div class="row mb-2" id="class_sub_cate_div_' + i + '">' +
                '<div class="col-md-10 input_group2">' +
                '<input class="form-control" list="datalistOptions" value="' + element + '" id="car" readonly placeholder="Graphic Designer">' +
                '</div>' +
                '<div class="col-md-2 button_group2">' +
                '<button class="btn_reject btn btn-outline-secondary remove-button" onclick="RejectSubCateClass(this.id)" id="sub_cate_' + i + '" data-cate="' + element + '" data-service_type="class_sub"  data-cates_type="' + cates_type + '" >Reject</button>' +
                '</div> ' +
                '</div>';


        }
        $(subCateGroupDiv).append(sub_cate_html);


        // Add textarea for subcategories


        // Append subcategory elements to the form
        form.appendChild(rowDiv);
        form.appendChild(subCateGroupDiv);

        // Append form to the main div
        mainDiv.appendChild(form);

        // Append main div after the category container
        categoryContainer.parentNode.insertBefore(
            mainDiv,
            categoryContainer.nextSibling
        );

        // Show the main div and hide the category div
        mainDiv.style.display = "block";
        categoryDiv.style.display = "none";

        // Set the width of the input group
        inputGroupDiv.classList.add("wide-input-group");
    }
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
<!-- ---------- -->


<script>
    AOS.init();
</script>
<script>
    $(document).ready(function () {
        $(".js-example-basic-multiple").select2();
    });
</script>
<script>
    document.getElementById('show_full_name').addEventListener('change', function() {
        document.getElementById('show_full_name_val').value = this.checked ? 1 : 0;
    });
</script>
<script>
    document.getElementById('auto_approve_enabled').addEventListener('change', function() {
        document.getElementById('auto_approve_enabled_val').value = this.checked ? 1 : 0;
    });
</script>

</body>
</html>
