<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <!-- View Point scale to 1.0 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Animate css -->
    <link rel="stylesheet" href="assets/admin/libs/animate/css/animate.css" />
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="assets/admin/libs/aos/css/aos.css" />
    <!-- Datatable css  -->
    <link rel="stylesheet" href="assets/admin/libs/datatable/css/datatable.css" />
    {{-- Fav Icon --}}
    @php  $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="assets/public-site/asset/img/{{ $home->fav_icon }}" type="image/x-icon">
    @endif
    <!-- Select2 css -->
    <link href="assets/admin/libs/select2/css/select2.min.css" rel="stylesheet" />
    <!-- Owl carousel css -->
    <link href="assets/admin/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
    <link href="assets/admin/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="assets/admin/asset/css/bootstrap.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/55bd3bbc70.js" crossorigin="anonymous"></script>
    <!-- file upload link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>


    <!-- js -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    {{-- =======Toastr CDN ======== --}}
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- =======Toastr CDN ======== --}}
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/admin/asset/css/style.css">
    <!-- <link rel="stylesheet" href="../User-Dashboard/assets/css/style.css"> -->
    <link rel="stylesheet" href="assets/admin/asset/css/daynamic.css">
    <title>Super Admin Dashboard | Dynamic Management-Home Page</title>
</head>
<style>
    .button {
        color: #0072B1 !important;
    }
</style>

<body>



    @if (Session::has('error'))
        <script>
            toastr.options = {
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
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": "10000", // 10 seconds
                "extendedTimeOut": "4410000" // 10 seconds
            }
            toastr.success("{{ session('success') }}");
        </script>
    @endif



    {{-- ===========Admin Sidebar Start==================== --}}
    <x-admin-sidebar />
    {{-- ===========Admin Sidebar End==================== --}}
    <section class="home-section">
        {{-- ===========Admin NavBar Start==================== --}}
        <x-admin-nav />
        {{-- ===========Admin NavBar End==================== --}}
        <!-- =============================== MAIN CONTENT START HERE =========================== -->
        <div class="container-fluid">
            <div class="row dash-notification">
                <div class="col-md-12">
                    {{-- <form action="/update-home-dynamic" method="POST" enctype="multipart/form-data">
                    @csrf --}}
                    <div class="dash">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="dash-top">
                                    <h1 class="dash-title">Dashboard</h1>
                                    <i class="fa-solid fa-chevron-right"></i>
                                    <h1 class="dash-title">Dynamic Management</h1>
                                    <i class="fa-solid fa-chevron-right"></i>
                                    <span class="min-title">Home Page</span>
                                </div>
                            </div>
                        </div>
                        <!-- Blue MASSEGES section -->
                        <div class="user-notification">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="notify">
                                        <img src="assets/admin/asset/img/dynamic-management.svg" alt="" />
                                        <h2>Dynamic Management</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="api-section" type="button" value="Show/Hide" onClick="showHideDiv('divMsg')">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="mb-0">Site Identity</h5>
                                    <div class="float-end icon-sec">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form action="/update-home-dynamic" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="cate" value="identity">
                            <div class="form-section conditions" id="divMsg">
                                <!-- Upload End -->
                                <div class="row">
                                    <div class="col-md-6 identity" id="upload-image">
                                        <label for="">Site Logo</label>
                                        <div class="input-file-wrapper transition-linear-3 position-relative">
                                            <span class="remove-img-btn position-absolute"
                                                @click="reset('post-thumbnail')" v-if="preview!==null">
                                                Remove
                                            </span>
                                            <label class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                for="post-thumbnail">
                                                <span v-show="preview===null">
                                                    <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                    <span class="d-block">Upload Image</span>
                                                    <p>Drag and drop files here</p>
                                                </span>
                                                <template v-if="preview">
                                                    <img :src="preview" class="img-fluid mt-2" />
                                                </template>
                                            </label>
                                            <input type="file" name="site_logo" accept="image/*"
                                                value="@if ($home) {{ $home->site_logo }} @endif"
                                                @change="previewImage('post-thumbnail')" class="input-file"
                                                id="post-thumbnail" />
                                        </div>
                                    </div>

                                    <div class="col-md-6 identity" id="upload-image1">
                                        <label for="">Fav Icon</label>
                                        <div class="input-file-wrapper transition-linear-3 position-relative">
                                            <span class="remove-img-btn position-absolute"
                                                @click="reset('post-thumbnail1')" v-if="preview!==null">
                                                Remove
                                            </span>
                                            <label
                                                class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                for="post-thumbnail1">
                                                <span v-show="preview===null">
                                                    <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                    <span class="d-block">Upload Image</span>
                                                    <p>Drag and drop files here</p>
                                                </span>
                                                <template v-if="preview">
                                                    <img :src="preview" class="img-fluid mt-2" />
                                                </template>
                                            </label>
                                            <input type="file" name="fav_icon" accept="image/*"
                                                value="@if ($home) {{ $home->fav_icon }} @endif"
                                                @change="previewImage('post-thumbnail1')" class="input-file"
                                                id="post-thumbnail1" />
                                        </div>
                                    </div>

                                </div>
                                <!-- Upload End -->

                                <div class="api-buttons">
                                    <div class="row major-section">
                                        <div class="col-md-12 ">
                                            {{-- <button type="button" class="btn float-start cancel-btn">
                            Cancel
                          </button> --}}
                                            <button type="submit" class="btn float-end update-btn">Update</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                        <div class="api-section" type="button" value="Show/Hide" onClick="showHideDiv('divMsg11')">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="mb-0">Notification Bar</h5>
                                    <div class="float-end icon-sec">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form action="/update-home-dynamic" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="cate" value="notification">
                            <div class="form-section conditions" id="divMsg11">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="">

                                            <div class="col-12 form-sec">
                                                <label for="inputAddress" class="form-label">Show/Hide</label>
                                                <input type="hidden" name="notification_bar"
                                                    id="notification_check">
                                                <input type="checkbox"id="aa1" class="add-page-check"
                                                    @if ($home) @if ($home->notification_bar == 1) checked @endif
                                                    @endif >
                                                <label for="aa1"><span></span></label>
                                            </div>
                                            <div class="col-12 form-sec">
                                                <label for="inputAddress2" class="form-label">Heading</label>
                                                <input type="text" required name="notification_heading"
                                                    class="form-control" id="inputAddress2"
                                                    value="@if ($home) {{ $home->notification_heading }} @endif"
                                                    placeholder="Discover Classes and Freelance Categories" />
                                            </div>
                                            <div class="col-12 form-sec">
                                                <label for="inputAddress2" class="form-label">Notification</label>
                                                <input type="text" required name="notification"
                                                    class="form-control" id="inputAddress2"
                                                    value="@if ($home) {{ $home->notification }} @endif"
                                                    placeholder="Discover Classes and Freelance Categories" />
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="api-buttons">
                                    <div class="row major-section">
                                        <div class="col-md-12 ">
                                            {{-- <button type="button" class="btn float-start cancel-btn">
                            Cancel
                          </button> --}}
                                            <button type="submit" class="btn float-end update-btn">Update</button>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </form>
                        <div class="api-section" type="button" value="Show/Hide" onClick="showHideDiv('divMsg1')">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="mb-0">Hero Section</h5>
                                    <div class="float-end icon-sec">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form action="/update-home-dynamic" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="cate" value="hero">
                            <div class="form-section conditions" id="divMsg1">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="">

                                            <div class="col-12 form-sec">
                                                <label for="inputAddress" class="form-label">Display Text</label>
                                                <input type="text" required name="hero_text" class="form-control"
                                                    id="inputAddress"
                                                    value="@if ($home) {{ $home->hero_text }} @endif"
                                                    placeholder="Discover Classes and Freelance Categories" />
                                            </div>
                                            <div class="col-12 form-sec">
                                                <label for="inputAddress2" class="form-label">Display Text
                                                    Description</label>
                                                <input type="text" required name="hero_description"
                                                    class="form-control" id="inputAddress2"
                                                    value="@if ($home) {{ $home->hero_discription }} @endif"
                                                    placeholder="Discover Classes and Freelance Categories" />
                                            </div>
                                            <!--Image-->
                                            <div class="col-md-12 personal-info identity" id="upload-image2">
                                                <label for="">Hero Section Image</label>
                                                <div class="input-file-wrapper transition-linear-3 position-relative">
                                                    <span class="remove-img-btn position-absolute"
                                                        @click="reset('post-thumbnail2')" v-if="preview!==null">
                                                        Remove
                                                    </span>
                                                    <label
                                                        class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                        for="post-thumbnail2">
                                                        <span class="span" v-show="preview===null">
                                                            <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                            <span class="d-block">Upload Image</span>
                                                            <p>Drag and drop files here</p>
                                                        </span>
                                                        <template v-if="preview">
                                                            <img :src="preview" class="img-fluid mt-2" />
                                                        </template>
                                                    </label>
                                                    <input type="file" name="hero_image" accept="image/*"
                                                        value="@if ($home) {{ $home->hero_image }} @endif"
                                                        @change="previewImage('post-thumbnail2')" class="input-file"
                                                        id="post-thumbnail2" />
                                                </div>
                                            </div>
                                            {{-- <div class="col-12 form-sec">
                              <label for="inputAddress2" class="form-label">Note</label>
                              <input
                                type="text"  required name="hero_note"
                                class="form-control" value="@if ($home){{$home->hero_note}}@endif"
                                id="inputAddress2"
                                placeholder="Discover Classes and Freelance Categories"
                              />
                            </div> --}}

                                        </div>
                                    </div>
                                </div>

                                <div class="api-buttons">
                                    <div class="row major-section">
                                        <div class="col-md-12 ">
                                            {{-- <button type="button" class="btn float-start cancel-btn">
                            Cancel
                          </button> --}}
                                            <button type="submit" class="btn float-end update-btn">Update</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                        <div class="api-section" type="button" value="Show/Hide" onClick="showHideDiv('divMsg2')">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="mb-0">Counter</h5>
                                    <div class="float-end icon-sec">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form action="/update-home-dynamic" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="cate" value="counter">
                            <div class="api-form" id="divMsg2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <label for="inputAddress" class="form-label">Heading </label>
                                                <input type="text" required name="counter_heading1"
                                                    class="form-control" id="inputAddress"
                                                    value="@if ($home) {{ $home->counter_heading_1 }} @endif"
                                                    placeholder="Active Students" />
                                            </div>
                                            <div class="col-6 api-secret">
                                                <label for="inputAddress2" class="form-label">Numbers</label>
                                                <input type="number" required name="counter_number1"
                                                    class="form-control" id="inputAddress2"
                                                    value="@if ($home) {{ $home->counter_number_1 }} @endif"
                                                    placeholder="25900" />
                                            </div>
                                            <div class="col-6">
                                                <label for="inputAddress" class="form-label">Heading </label>
                                                <input type="text" required name="counter_heading2"
                                                    class="form-control" id="inputAddress"
                                                    value="@if ($home) {{ $home->counter_heading_2 }} @endif"
                                                    placeholder="Freelancer's" />
                                            </div>
                                            <div class="col-6 api-secret">
                                                <label for="inputAddress2" class="form-label">Numbers</label>
                                                <input type="number" required name="counter_number2"
                                                    class="form-control" id="inputAddress2"
                                                    value="@if ($home) {{ $home->counter_number_2 }} @endif"
                                                    placeholder="10000" />
                                            </div>
                                            <div class="col-6">
                                                <label for="inputAddress" class="form-label">Heading </label>
                                                <input type="text" required name="counter_heading3"
                                                    class="form-control" id="inputAddress"
                                                    value="@if ($home) {{ $home->counter_heading_3 }} @endif"
                                                    placeholder="Certified Students" />
                                            </div>
                                            <div class="col-6 api-secret">
                                                <label for="inputAddress2" class="form-label">Numbers</label>
                                                <input type="number" required name="counter_number3"
                                                    class="form-control" id="inputAddress2"
                                                    value="@if ($home) {{ $home->counter_number_3 }} @endif"
                                                    placeholder="5000" />
                                            </div>
                                            <div class="col-6">
                                                <label for="inputAddress" class="form-label">Heading </label>
                                                <input type="text" required name="counter_heading4"
                                                    class="form-control" id="inputAddress"
                                                    value="@if ($home) {{ $home->counter_heading_4 }} @endif"
                                                    placeholder="Certified Tutors" />
                                            </div>
                                            <div class="col-6 api-secret">
                                                <label for="inputAddress2" class="form-label">Numbers</label>
                                                <input type="number" required name="counter_number4"
                                                    class="form-control" id="inputAddress2"
                                                    value="@if ($home) {{ $home->counter_number_4 }} @endif"
                                                    placeholder="8000" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="api-buttons">
                                    <div class="row major-section">
                                        <div class="col-md-12 ">
                                            {{-- <button type="button" class="btn float-start cancel-btn">
                            Cancel
                          </button> --}}
                                            <button type="submit" class="btn float-end update-btn">Update</button>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </form>
                        <div class="api-section" type="button" value="Show/Hide" onClick="showHideDiv('divMsg3')">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="mb-0">Rating</h5>
                                    <div class="float-end icon-sec">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form action="/update-home-dynamic" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="cate" value="rating">
                            <div class="form-section" id="divMsg3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="inputEmail4" class="form-label">Heading </label>
                                                    <input type="text" required name="rating_heading"
                                                        class="form-control" id="inputEmail4"
                                                        value="@if ($home) {{ $home->rating_heading }} @endif"
                                                        placeholder="5k + student" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputEmail4" class="form-label">Stars</label>
                                                    <select required name="rating_stars" class="form-select"
                                                        aria-label="Default select example">
                                                        @if ($home)
                                                            @if ($home->rating_stars == 1)
                                                                <option selected value="1">One</option>
                                                            @endif
                                                            @if ($home->rating_stars == 2)
                                                                <option selected value="2">Two</option>
                                                            @endif
                                                            @if ($home->rating_stars == 3)
                                                                <option selected value="3">Three</option>
                                                            @endif
                                                            @if ($home->rating_stars == 4)
                                                                <option selected value="4">Four</option>
                                                            @endif
                                                            @if ($home->rating_stars == 5)
                                                                <option selected value="5">Five</option>
                                                            @endif

                                                        @endif


                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                        <option value="4">Four</option>
                                                        <option value="5">Five</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 mt-0 upload-img-sec">
                                                    <label for="inputAddress2" class="form-label">Images</label>
                                                    <!-- Upload Start -->
                                                    <div class="row">
                                                        <div class="col-md-2 gallery identity" id="upload-image3">
                                                            <div
                                                                class="input-file-wrapper transition-linear-3 position-relative">
                                                                <span class="remove-img-btn position-absolute"
                                                                    @click="reset('post-thumbnail3')"
                                                                    v-if="preview!==null">
                                                                    Remove
                                                                </span>
                                                                <label
                                                                    class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                                    for="post-thumbnail3">
                                                                    <span v-show="preview===null">
                                                                        <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                                        <span class="d-block">Upload Image</span>
                                                                        <p>Drag and drop files here</p>
                                                                    </span>
                                                                    <template v-if="preview">
                                                                        <img :src="preview"
                                                                            class="img-fluid mt-2" />
                                                                    </template>
                                                                </label>
                                                                <input type="file" name="rating_image1"
                                                                    accept="image/*"
                                                                    value="@if ($home) {{ $home->rating_image_1 }} @endif"
                                                                    @change="previewImage('post-thumbnail3')"
                                                                    class="input-file" id="post-thumbnail3" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 gallery identity" id="upload-image4">
                                                            <div
                                                                class="input-file-wrapper transition-linear-3 position-relative">
                                                                <span class="remove-img-btn position-absolute"
                                                                    @click="reset('post-thumbnail4')"
                                                                    v-if="preview!==null">
                                                                    Remove
                                                                </span>
                                                                <label
                                                                    class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                                    for="post-thumbnail4">
                                                                    <span v-show="preview===null">
                                                                        <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                                        <span class="d-block">Upload Image</span>
                                                                        <p>Drag and drop files here</p>
                                                                    </span>
                                                                    <template v-if="preview">
                                                                        <img :src="preview"
                                                                            class="img-fluid mt-2" />
                                                                    </template>
                                                                </label>
                                                                <input type="file" name="rating_image2"
                                                                    accept="image/*"
                                                                    value="@if ($home) {{ $home->rating_image_2 }} @endif"
                                                                    @change="previewImage('post-thumbnail4')"
                                                                    class="input-file" id="post-thumbnail4" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 gallery identity" id="upload-image5">
                                                            <div
                                                                class="input-file-wrapper transition-linear-3 position-relative">
                                                                <span class="remove-img-btn position-absolute"
                                                                    @click="reset('post-thumbnail5')"
                                                                    v-if="preview!==null">
                                                                    Remove
                                                                </span>
                                                                <label
                                                                    class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                                    for="post-thumbnail5">
                                                                    <span v-show="preview===null">
                                                                        <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                                        <span class="d-block">Upload Image</span>
                                                                        <p>Drag and drop files here</p>
                                                                    </span>
                                                                    <template v-if="preview">
                                                                        <img :src="preview"
                                                                            class="img-fluid mt-2" />
                                                                    </template>
                                                                </label>
                                                                <input type="file" name="rating_image3"
                                                                    accept="image/*"
                                                                    value="@if ($home) {{ $home->rating_image_3 }} @endif"
                                                                    @change="previewImage('post-thumbnail5')"
                                                                    class="input-file" id="post-thumbnail5" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 gallery identity" id="upload-image6">
                                                            <div
                                                                class="input-file-wrapper transition-linear-3 position-relative">
                                                                <span class="remove-img-btn position-absolute"
                                                                    @click="reset('post-thumbnail6')"
                                                                    v-if="preview!==null">
                                                                    Remove
                                                                </span>
                                                                <label
                                                                    class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                                    for="post-thumbnail6">
                                                                    <span v-show="preview===null">
                                                                        <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                                        <span class="d-block">Upload Image</span>
                                                                        <p>Drag and drop files here</p>
                                                                    </span>
                                                                    <template v-if="preview">
                                                                        <img :src="preview"
                                                                            class="img-fluid mt-2" />
                                                                    </template>
                                                                </label>
                                                                <input type="file" name="rating_image4"
                                                                    accept="image/*"
                                                                    value="@if ($home) {{ $home->rating_image_4 }} @endif"
                                                                    @change="previewImage('post-thumbnail6')"
                                                                    class="input-file" id="post-thumbnail6" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 gallery identity" id="upload-image7">
                                                            <div
                                                                class="input-file-wrapper transition-linear-3 position-relative">
                                                                <span class="remove-img-btn position-absolute"
                                                                    @click="reset('post-thumbnail7')"
                                                                    v-if="preview!==null">
                                                                    Remove
                                                                </span>
                                                                <label
                                                                    class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                                    for="post-thumbnail7">
                                                                    <span v-show="preview===null">
                                                                        <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                                        <span class="d-block">Upload Image</span>
                                                                        <p>Drag and drop files here</p>
                                                                    </span>
                                                                    <template v-if="preview">
                                                                        <img :src="preview"
                                                                            class="img-fluid mt-2" />
                                                                    </template>
                                                                </label>
                                                                <input type="file" name="rating_image5"
                                                                    accept="image/*"
                                                                    value="@if ($home) {{ $home->rating_image_5 }} @endif"
                                                                    @change="previewImage('post-thumbnail7')"
                                                                    class="input-file" id="post-thumbnail7" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 gallery identity" id="upload-image8">
                                                            <div
                                                                class="input-file-wrapper transition-linear-3 position-relative">
                                                                <span class="remove-img-btn position-absolute"
                                                                    @click="reset('post-thumbnail8')"
                                                                    v-if="preview!==null">
                                                                    Remove
                                                                </span>
                                                                <label
                                                                    class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                                    for="post-thumbnail8">
                                                                    <span v-show="preview===null">
                                                                        <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                                        <span class="d-block">Upload Image</span>
                                                                        <p>Drag and drop files here</p>
                                                                    </span>
                                                                    <template v-if="preview">
                                                                        <img :src="preview"
                                                                            class="img-fluid mt-2" />
                                                                    </template>
                                                                </label>
                                                                <input type="file" name="rating_image6"
                                                                    accept="image/*"
                                                                    value="@if ($home) {{ $home->rating_image_6 }} @endif"
                                                                    @change="previewImage('post-thumbnail8')"
                                                                    class="input-file" id="post-thumbnail8" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Upload End -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="api-buttons">
                                    <div class="row major-section">
                                        <div class="col-md-12 ">
                                            {{-- <button type="button" class="btn float-start cancel-btn">
                          Cancel
                        </button> --}}
                                            <button type="submit" class="btn float-end update-btn">Update</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                        <div class="api-section" type="button" value="Show/Hide" onClick="showHideDiv('divMsg4')">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="mb-0">How It Work</h5>
                                    <div class="float-end icon-sec">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form action="/update-home-dynamic" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="cate" value="work">
                            <div class="form-section" id="divMsg4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="inputEmail4" class="form-label">Heading</label>
                                                    <input type="text" required name="work_heading"
                                                        class="form-control" id="inputEmail4"
                                                        value="@if ($home) {{ $home->work_heading }} @endif"
                                                        placeholder="Discover Classes and Freelance Categories" />
                                                </div>
                                                <div class="col-md-12 work-sec">
                                                    <label for="inputEmail4" class="form-label">Tagline</label>
                                                    <input type="text" required name="work_tagline"
                                                        class="form-control" id="inputEmail4"
                                                        value="@if ($home) {{ $home->work_tagline }} @endif"
                                                        placeholder="Discover Classes and Freelance Categories" />
                                                </div>
                                                <div class="row work-sec">
                                                    <div class="col-md-3 gallery identity" id="upload-image9">
                                                        <div
                                                            class="input-file-wrapper transition-linear-3 position-relative">
                                                            <span class="remove-img-btn position-absolute"
                                                                @click="reset('post-thumbnail9')"
                                                                v-if="preview!==null">
                                                                Remove
                                                            </span>
                                                            <label
                                                                class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                                for="post-thumbnail9">
                                                                <span v-show="preview===null">
                                                                    <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                                    <span class="d-block">Upload Image</span>
                                                                    <p>Drag and drop files here</p>
                                                                </span>
                                                                <template v-if="preview">
                                                                    <img :src="preview"
                                                                        class="img-fluid mt-2" />
                                                                </template>
                                                            </label>
                                                            <input type="file" name="work_image1" accept="image/*"
                                                                value="@if ($home) {{ $home->work_image_1 }} @endif"
                                                                @change="previewImage('post-thumbnail9')"
                                                                class="input-file" id="post-thumbnail9" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="inputEmail4"
                                                                    class="form-label">Heading</label>
                                                                <input type="text" required name="work_heading1"
                                                                    class="form-control" id="inputEmail4"
                                                                    value="@if ($home) {{ $home->work_heading_1 }} @endif"
                                                                    placeholder="Heading" />
                                                            </div>
                                                            <div class="col-md-12 desc">
                                                                <label for="inputEmail4"
                                                                    class="form-label">Description</label>
                                                                <input type="text" required
                                                                    name="work_description1" class="form-control"
                                                                    id="inputEmail4"
                                                                    value="@if ($home) {{ $home->work_description_1 }} @endif"
                                                                    placeholder="Description" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row work-sec">
                                                    <div class="col-md-3 gallery identity" id="upload-image10">
                                                        <div
                                                            class="input-file-wrapper transition-linear-3 position-relative">
                                                            <span class="remove-img-btn position-absolute"
                                                                @click="reset('post-thumbnail10')"
                                                                v-if="preview!==null">
                                                                Remove
                                                            </span>
                                                            <label
                                                                class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                                for="post-thumbnail10">
                                                                <span v-show="preview===null">
                                                                    <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                                    <span class="d-block">Upload Image</span>
                                                                    <p>Drag and drop files here</p>
                                                                </span>
                                                                <template v-if="preview">
                                                                    <img :src="preview"
                                                                        class="img-fluid mt-2" />
                                                                </template>
                                                            </label>
                                                            <input type="file" name="work_image2" accept="image/*"
                                                                value="@if ($home) {{ $home->work_image_2 }} @endif"
                                                                @change="previewImage('post-thumbnail10')"
                                                                class="input-file" id="post-thumbnail10" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="inputEmail4"
                                                                    class="form-label">Heading</label>
                                                                <input type="text" required name="work_heading2"
                                                                    class="form-control" id="inputEmail4"
                                                                    value="@if ($home) {{ $home->work_heading_2 }} @endif"
                                                                    placeholder="Heading" />
                                                            </div>
                                                            <div class="col-md-12 desc">
                                                                <label for="inputEmail4"
                                                                    class="form-label">Description</label>
                                                                <input type="text" required
                                                                    name="work_description2" class="form-control"
                                                                    id="inputEmail4"
                                                                    value="@if ($home) {{ $home->work_description_2 }} @endif"
                                                                    placeholder="Description" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row work-sec">
                                                    <div class="col-md-3 gallery identity" id="upload-image11">
                                                        <div
                                                            class="input-file-wrapper transition-linear-3 position-relative">
                                                            <span class="remove-img-btn position-absolute"
                                                                @click="reset('post-thumbnail11')"
                                                                v-if="preview!==null">
                                                                Remove
                                                            </span>
                                                            <label
                                                                class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                                for="post-thumbnail11">
                                                                <span v-show="preview===null">
                                                                    <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                                    <span class="d-block">Upload Image</span>
                                                                    <p>Drag and drop files here</p>
                                                                </span>
                                                                <template v-if="preview">
                                                                    <img :src="preview"
                                                                        class="img-fluid mt-2" />
                                                                </template>
                                                            </label>
                                                            <input type="file" name="work_image3" accept="image/*"
                                                                value="@if ($home) {{ $home->work_image_3 }} @endif"
                                                                @change="previewImage('post-thumbnail11')"
                                                                class="input-file" id="post-thumbnail11" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="inputEmail4"
                                                                    class="form-label">Heading</label>
                                                                <input type="text" required name="work_heading3"
                                                                    class="form-control" id="inputEmail4"
                                                                    value="@if ($home) {{ $home->work_heading_3 }} @endif"
                                                                    placeholder="Heading" />
                                                            </div>
                                                            <div class="col-md-12 desc">
                                                                <label for="inputEmail4"
                                                                    class="form-label">Description</label>
                                                                <input type="text" required
                                                                    name="work_description3" class="form-control"
                                                                    id="inputEmail4"
                                                                    value="@if ($home) {{ $home->work_description_3 }} @endif"
                                                                    placeholder="Description" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="api-buttons">
                                    <div class="row major-section">
                                        <div class="col-md-12 ">
                                            {{-- <button type="button" class="btn float-start cancel-btn">
                          Cancel
                        </button> --}}
                                            <button type="submit" class="btn float-end update-btn">Update</button>
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </form>

                    </div>
                    <div class="api-section" type="button" value="Show/Hide" onClick="showHideDiv('divMsg5')">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="mb-0">Categories</h5>
                                <div class="float-end icon-sec">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="/update-home-dynamic" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="cate" value="category">
                        <div class="form-section" id="divMsg5">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="inputEmail4" class="form-label">Heading</label>
                                                <input type="text" required name="category_heading"
                                                    class="form-control" id="inputEmail4"
                                                    value="@if ($home) {{ $home->category_heading }} @endif"
                                                    placeholder="Discover Classes and Freelance Categories" />
                                            </div>
                                            <div class="col-md-12 work-sec">
                                                <label for="inputEmail4" class="form-label">Tagline</label>
                                                <input type="text" required name="category_tagline"
                                                    class="form-control" id="inputEmail4"
                                                    value="@if ($home) {{ $home->category_tagline }} @endif"
                                                    placeholder="Discover Classes and Freelance Categories" />
                                            </div>
                                            <div class="row work-sec">
                                                <div class="col-md-3 gallery identity" id="upload-image12">
                                                    <div
                                                        class="input-file-wrapper transition-linear-3 position-relative">
                                                        <span class="remove-img-btn position-absolute"
                                                            @click="reset('post-thumbnail12')" v-if="preview!==null">
                                                            Remove
                                                        </span>
                                                        <label
                                                            class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                            for="post-thumbnail12">
                                                            <span v-show="preview===null">
                                                                <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                                <span class="d-block">Upload Image</span>
                                                                <p>Drag and drop files here</p>
                                                            </span>
                                                            <template v-if="preview">
                                                                <img :src="preview" class="img-fluid mt-2" />
                                                            </template>
                                                        </label>
                                                        <input type="file" name="category_image1" accept="image/*"
                                                            value="@if ($home) {{ $home->category_image_1 }} @endif"
                                                            @change="previewImage('post-thumbnail12')"
                                                            class="input-file" id="post-thumbnail12" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 gallery identity" id="upload-image13">
                                                    <div
                                                        class="input-file-wrapper transition-linear-3 position-relative">
                                                        <span class="remove-img-btn position-absolute"
                                                            @click="reset('post-thumbnail13')" v-if="preview!==null">
                                                            Remove
                                                        </span>
                                                        <label
                                                            class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                            for="post-thumbnail13">
                                                            <span v-show="preview===null">
                                                                <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                                <span class="d-block">Upload Image</span>
                                                                <p>Drag and drop files here</p>
                                                            </span>
                                                            <template v-if="preview">
                                                                <img :src="preview" class="img-fluid mt-2" />
                                                            </template>
                                                        </label>
                                                        <input type="file" name="category_image2" accept="image/*"
                                                            value="@if ($home) {{ $home->category_image_2 }} @endif"
                                                            @change="previewImage('post-thumbnail13')"
                                                            class="input-file" id="post-thumbnail13" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 gallery identity" id="upload-image14">
                                                    <div
                                                        class="input-file-wrapper transition-linear-3 position-relative">
                                                        <span class="remove-img-btn position-absolute"
                                                            @click="reset('post-thumbnail14')" v-if="preview!==null">
                                                            Remove
                                                        </span>
                                                        <label
                                                            class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                            for="post-thumbnail14">
                                                            <span v-show="preview===null">
                                                                <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                                <span class="d-block">Upload Image</span>
                                                                <p>Drag and drop files here</p>
                                                            </span>
                                                            <template v-if="preview">
                                                                <img :src="preview" class="img-fluid mt-2" />
                                                            </template>
                                                        </label>
                                                        <input type="file" name="category_image3" accept="image/*"
                                                            value="@if ($home) {{ $home->category_image_3 }} @endif"
                                                            @change="previewImage('post-thumbnail14')"
                                                            class="input-file" id="post-thumbnail14" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 gallery identity" id="upload-image15">
                                                    <div
                                                        class="input-file-wrapper transition-linear-3 position-relative">
                                                        <span class="remove-img-btn position-absolute"
                                                            @click="reset('post-thumbnail15')" v-if="preview!==null">
                                                            Remove
                                                        </span>
                                                        <label
                                                            class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                            for="post-thumbnail15">
                                                            <span v-show="preview===null">
                                                                <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                                <span class="d-block">Upload Image</span>
                                                                <p>Drag and drop files here</p>
                                                            </span>
                                                            <template v-if="preview">
                                                                <img :src="preview" class="img-fluid mt-2" />
                                                            </template>
                                                        </label>
                                                        <input type="file" name="category_image4" accept="image/*"
                                                            value="@if ($home) {{ $home->category_image_4 }} @endif"
                                                            @change="previewImage('post-thumbnail15')"
                                                            class="input-file" id="post-thumbnail15" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row work-sec">
                                                <div class="col-md-3">
                                                    <label for="inputAddress" class="form-label">Category Name</label>
                                                    <select class="form-control form-select" name="category_name1"
                                                        id="">
                                                        @if ($home)
                                                            <option value="{{ $home->category_name_1 }}" selected>
                                                                {{ $home->category_name_1 }}</option>
                                                        @endif
                                                        @php
                                                            $categories = \App\Models\Category::where([
                                                                'service_type' => 'Online',
                                                                'status' => 1,
                                                                'service_role' => 'Class',
                                                            ])->get();
                                                        @endphp
                                                        @if ($categories)
                                                            @foreach ($categories as $item)
                                                                @php$category = \App\Models\Category::where([
                                                                        'service_type' => 'Inperson',
                                                                        'service_role' => 'Freelance',
                                                                    ])
                                                                        ->where('category', '%like%', $item->category)
                                                                        ->first();
                                                                    //  $result = preg_replace('/\(.*?\)/', '', $item->category);
                                                                @endphp
                                                                <option value="{{ $item->category }}">
                                                                    {{ $item->category }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    {{-- <input type="text"  value="@if ($home){{$home->category_name_1}}@endif" required name="category_name1" class="form-control" id="inputAddress" placeholder="Category Name"> --}}
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="inputAddress" class="form-label">Category Name</label>
                                                    <select class="form-control form-select" name="category_name2"
                                                        id="">
                                                        @if ($home)
                                                            <option value="{{ $home->category_name_2 }}" selected>
                                                                {{ $home->category_name_2 }}</option>
                                                        @endif
                                                        @php
                                                            $categories = \App\Models\Category::where([
                                                                'service_type' => 'Online',
                                                                'status' => 1,
                                                                'service_role' => 'Class',
                                                            ])->get();
                                                        @endphp
                                                        @if ($categories)
                                                            @foreach ($categories as $item)
                                                                @php$category = \App\Models\Category::where([
                                                                        'service_type' => 'Inperson',
                                                                        'service_role' => 'Freelance',
                                                                    ])
                                                                        ->where('category', '%like%', $item->category)
                                                                        ->first();
                                                                    //  $result = preg_replace('/\(.*?\)/', '', $item->category);
                                                                @endphp
                                                                <option value="{{ $item->category }}">
                                                                    {{ $item->category }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    {{-- <input type="text" class="form-control"  value="@if ($home){{$home->category_name_2}}@endif" required name="category_name2" id="inputAddress" placeholder="Category Name"> --}}
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="inputAddress" class="form-label">Category Name</label>
                                                    <select class="form-control form-select" name="category_name3"
                                                        id="">
                                                        @if ($home)
                                                            <option value="{{ $home->category_name_3 }}" selected>
                                                                {{ $home->category_name_3 }}</option>
                                                        @endif
                                                        @php
                                                            $categories = \App\Models\Category::where([
                                                                'service_type' => 'Online',
                                                                'status' => 1,
                                                                'service_role' => 'Class',
                                                            ])->get();
                                                        @endphp
                                                        @if ($categories)
                                                            @foreach ($categories as $item)
                                                                @php$category = \App\Models\Category::where([
                                                                        'service_type' => 'Inperson',
                                                                        'service_role' => 'Freelance',
                                                                    ])
                                                                        ->where('category', '%like%', $item->category)
                                                                        ->first();
                                                                    //  $result = preg_replace('/\(.*?\)/', '', $item->category);
                                                                @endphp
                                                                <option value="{{ $item->category }}">
                                                                    {{ $item->category }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    {{-- <input type="text" class="form-control"  value="@if ($home){{$home->category_name_3}}@endif" required name="category_name3" id="inputAddress" placeholder="Category Name"> --}}
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="inputAddress" class="form-label">Category Name</label>
                                                    <select class="form-control form-select" name="category_name4"
                                                        id="">
                                                        @if ($home)
                                                            <option value="{{ $home->category_name_4 }}" selected>
                                                                {{ $home->category_name_4 }}</option>
                                                        @endif
                                                        @php
                                                            $categories = \App\Models\Category::where([
                                                                'service_type' => 'Online',
                                                                'status' => 1,
                                                                'service_role' => 'Class',
                                                            ])->get();
                                                        @endphp
                                                        @if ($categories)
                                                            @foreach ($categories as $item)
                                                                @php$category = \App\Models\Category::where([
                                                                        'service_type' => 'Inperson',
                                                                        'service_role' => 'Freelance',
                                                                    ])
                                                                        ->where('category', '%like%', $item->category)
                                                                        ->first();
                                                                    //  $result = preg_replace('/\(.*?\)/', '', $item->category);
                                                                @endphp
                                                                <option value="{{ $item->category }}">
                                                                    {{ $item->category }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    {{-- <input type="text" class="form-control"  value="@if ($home){{$home->category_name_4}}@endif" required name="category_name4" id="inputAddress" placeholder="Category Name"> --}}
                                                </div>
                                            </div>
                                            <div class="row work-sec">
                                                <div class="col-md-3 gallery identity" id="upload-image16">
                                                    <div
                                                        class="input-file-wrapper transition-linear-3 position-relative">
                                                        <span class="remove-img-btn position-absolute"
                                                            @click="reset('post-thumbnail16')" v-if="preview!==null">
                                                            Remove
                                                        </span>
                                                        <label
                                                            class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                            for="post-thumbnail16">
                                                            <span v-show="preview===null">
                                                                <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                                <span class="d-block">Upload Image</span>
                                                                <p>Drag and drop files here</p>
                                                            </span>
                                                            <template v-if="preview">
                                                                <img :src="preview" class="img-fluid mt-2" />
                                                            </template>
                                                        </label>
                                                        <input type="file" name="category_image5" accept="image/*"
                                                            value="@if ($home) {{ $home->category_image_5 }} @endif"
                                                            @change="previewImage('post-thumbnail16')"
                                                            class="input-file" id="post-thumbnail16" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 gallery identity" id="upload-image17">
                                                    <div
                                                        class="input-file-wrapper transition-linear-3 position-relative">
                                                        <span class="remove-img-btn position-absolute"
                                                            @click="reset('post-thumbnail17')" v-if="preview!==null">
                                                            Remove
                                                        </span>
                                                        <label
                                                            class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                            for="post-thumbnail17">
                                                            <span v-show="preview===null">
                                                                <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                                <span class="d-block">Upload Image</span>
                                                                <p>Drag and drop files here</p>
                                                            </span>
                                                            <template v-if="preview">
                                                                <img :src="preview" class="img-fluid mt-2" />
                                                            </template>
                                                        </label>
                                                        <input type="file" name="category_image6" accept="image/*"
                                                            value="@if ($home) {{ $home->category_image_6 }} @endif"
                                                            @change="previewImage('post-thumbnail17')"
                                                            class="input-file" id="post-thumbnail17" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 gallery identity" id="upload-image18">
                                                    <div
                                                        class="input-file-wrapper transition-linear-3 position-relative">
                                                        <span class="remove-img-btn position-absolute"
                                                            @click="reset('post-thumbnail18')" v-if="preview!==null">
                                                            Remove
                                                        </span>
                                                        <label
                                                            class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                            for="post-thumbnail18">
                                                            <span v-show="preview===null">
                                                                <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                                <span class="d-block">Upload Image</span>
                                                                <p>Drag and drop files here</p>
                                                            </span>
                                                            <template v-if="preview">
                                                                <img :src="preview" class="img-fluid mt-2" />
                                                            </template>
                                                        </label>
                                                        <input type="file" name="category_image7" accept="image/*"
                                                            value="@if ($home) {{ $home->category_image_7 }} @endif"
                                                            @change="previewImage('post-thumbnail18')"
                                                            class="input-file" id="post-thumbnail18" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 gallery identity" id="upload-image19">
                                                    <div
                                                        class="input-file-wrapper transition-linear-3 position-relative">
                                                        <span class="remove-img-btn position-absolute"
                                                            @click="reset('post-thumbnail19')" v-if="preview!==null">
                                                            Remove
                                                        </span>
                                                        <label
                                                            class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                            for="post-thumbnail19">
                                                            <span v-show="preview===null">
                                                                <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                                <span class="d-block">Upload Image</span>
                                                                <p>Drag and drop files here</p>
                                                            </span>
                                                            <template v-if="preview">
                                                                <img :src="preview" class="img-fluid mt-2" />
                                                            </template>
                                                        </label>
                                                        <input type="file" name="category_image8" accept="image/*"
                                                            value="@if ($home) {{ $home->category_image_8 }} @endif"
                                                            @change="previewImage('post-thumbnail19')"
                                                            class="input-file" id="post-thumbnail19" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row work-sec">
                                                <div class="col-md-3">
                                                    <label for="inputAddress" class="form-label">Category Name</label>
                                                    <select class="form-control form-select" name="category_name5"
                                                        id="">
                                                        @if ($home)
                                                            <option value="{{ $home->category_name_5 }}" selected>
                                                                {{ $home->category_name_5 }}</option>
                                                        @endif
                                                        @php
                                                            $categories = \App\Models\Category::where([
                                                                'service_type' => 'Online',
                                                                'status' => 1,
                                                                'service_role' => 'Class',
                                                            ])->get();
                                                        @endphp
                                                        @if ($categories)
                                                            @foreach ($categories as $item)
                                                                @php$category = \App\Models\Category::where([
                                                                        'service_type' => 'Inperson',
                                                                        'service_role' => 'Freelance',
                                                                    ])
                                                                        ->where('category', '%like%', $item->category)
                                                                        ->first();
                                                                    //  $result = preg_replace('/\(.*?\)/', '', $item->category);
                                                                @endphp
                                                                <option value="{{ $item->category }}">
                                                                    {{ $item->category }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    {{-- <input type="text" class="form-control"  value="@if ($home){{$home->category_name_5}}@endif" required name="category_name5" id="inputAddress" placeholder="Category Name"> --}}
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="inputAddress" class="form-label">Category Name</label>
                                                    <select class="form-control form-select" name="category_name6"
                                                        id="">
                                                        @if ($home)
                                                            <option value="{{ $home->category_name_6 }}" selected>
                                                                {{ $home->category_name_6 }}</option>
                                                        @endif
                                                        @php
                                                            $categories = \App\Models\Category::where([
                                                                'service_type' => 'Online',
                                                                'status' => 1,
                                                                'service_role' => 'Class',
                                                            ])->get();
                                                        @endphp
                                                        @if ($categories)
                                                            @foreach ($categories as $item)
                                                                @php$category = \App\Models\Category::where([
                                                                        'service_type' => 'Inperson',
                                                                        'service_role' => 'Freelance',
                                                                    ])
                                                                        ->where('category', '%like%', $item->category)
                                                                        ->first();
                                                                    //  $result = preg_replace('/\(.*?\)/', '', $item->category);
                                                                @endphp
                                                                <option value="{{ $item->category }}">
                                                                    {{ $item->category }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    {{-- <input type="text" class="form-control"  value="@if ($home){{$home->category_name_6}}@endif" required name="category_name6" id="inputAddress" placeholder="Category Name"> --}}
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="inputAddress" class="form-label">Category Name</label>
                                                    <select class="form-control form-select" name="category_name7"
                                                        id="">
                                                        @if ($home)
                                                            <option value="{{ $home->category_name_7 }}" selected>
                                                                {{ $home->category_name_7 }}</option>
                                                        @endif
                                                        @php
                                                            $categories = \App\Models\Category::where([
                                                                'service_type' => 'Online',
                                                                'status' => 1,
                                                                'service_role' => 'Class',
                                                            ])->get();
                                                        @endphp
                                                        @if ($categories)
                                                            @foreach ($categories as $item)
                                                                @php$category = \App\Models\Category::where([
                                                                        'service_type' => 'Inperson',
                                                                        'service_role' => 'Freelance',
                                                                    ])
                                                                        ->where('category', '%like%', $item->category)
                                                                        ->first();
                                                                    //  $result = preg_replace('/\(.*?\)/', '', $item->category);
                                                                @endphp
                                                                <option value="{{ $item->category }}">
                                                                    {{ $item->category }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    {{-- <input type="text" class="form-control"  value="@if ($home){{$home->category_name_7}}@endif" required name="category_name7" id="inputAddress" placeholder="Category Name"> --}}
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="inputAddress" class="form-label">Category Name</label>
                                                    <select class="form-control form-select" name="category_name8"
                                                        id="">
                                                        @if ($home)
                                                            <option value="{{ $home->category_name_8 }}" selected>
                                                                {{ $home->category_name_8 }}</option>
                                                        @endif
                                                        @php
                                                            $categories = \App\Models\Category::where([
                                                                'service_type' => 'Online',
                                                                'status' => 1,
                                                                'service_role' => 'Class',
                                                            ])->get();
                                                        @endphp
                                                        @if ($categories)
                                                            @foreach ($categories as $item)
                                                                @php$category = \App\Models\Category::where([
                                                                        'service_type' => 'Inperson',
                                                                        'service_role' => 'Freelance',
                                                                    ])
                                                                        ->where('category', '%like%', $item->category)
                                                                        ->first();
                                                                    //  $result = preg_replace('/\(.*?\)/', '', $item->category);
                                                                @endphp
                                                                <option value="{{ $item->category }}">
                                                                    {{ $item->category }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    {{-- <input type="text" class="form-control"  value="@if ($home){{$home->category_name_8}}@endif" required name="category_name8" id="inputAddress" placeholder="Category Name"> --}}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="api-buttons">
                                <div class="row major-section">
                                    <div class="col-md-12 ">
                                        {{-- <button type="button" class="btn float-start cancel-btn">
                          Cancel
                        </button> --}}
                                        <button type="submit" class="btn float-end update-btn">Update</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                    <div class="api-section" type="button" value="Show/Hide" onClick="showHideDiv('divMsg6')">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="mb-0">Our Experts</h5>
                                <div class="float-end icon-sec">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="/update-home-dynamic" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="cate" value="expert">
                        <div class="form-section" id="divMsg6">
                            <div class="row">

                                <div class="row form-det">
                                    <div class="col-md-12">
                                        <label for="inputAddress" class="form-label">Heading</label>
                                        <input type="text"
                                            value="@if ($home) {{ $home->expert_heading }} @endif"
                                            required name="expert_heading" class="form-control" id="inputAddress"
                                            placeholder="Discover Classes and Freelance Categories">
                                    </div>
                                    <div class="col-md-12 work-sec">
                                        <label for="inputAddress" class="form-label">Tagline</label>
                                        <input type="text" required name="expert_tagline"
                                            value="@if ($home) {{ $home->expert_tagline }} @endif"
                                            class="form-control" id="inputAddress"
                                            placeholder="Discover Classes and Freelance Categories">
                                    </div>
                                    <div class="row work-sec"></div>
                                    <div class="col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <label for="inputPassword6" class="col-form-label">ID Link 1</label>
                                            </div>
                                            <div class="col-10">
                                                <input type="text" required name="expert_link1"
                                                    id="inputPassword6" class="form-control"
                                                    value="@if ($home) {{ $home->expert_link_1 }} @endif"
                                                    aria-describedby="passwordHelpInline" placeholder="ID link" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <label for="inputPassword6" class="col-form-label">ID Link 2</label>
                                            </div>
                                            <div class="col-10">
                                                <input type="text" required name="expert_link2"
                                                    id="inputPassword6" class="form-control"
                                                    value="@if ($home) {{ $home->expert_link_2 }} @endif"
                                                    aria-describedby="passwordHelpInline" placeholder="ID link" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-det">
                                    <div class="col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <label for="inputPassword6" class="col-form-label">ID Link 3</label>
                                            </div>
                                            <div class="col-10">
                                                <input type="text" required name="expert_link3"
                                                    id="inputPassword6" class="form-control"
                                                    value="@if ($home) {{ $home->expert_link_3 }} @endif"
                                                    aria-describedby="passwordHelpInline" placeholder="ID link" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <label for="inputPassword6" class="col-form-label">ID Link 4</label>
                                            </div>
                                            <div class="col-10">
                                                <input type="text" required name="expert_link4"
                                                    id="inputPassword6" class="form-control"
                                                    value="@if ($home) {{ $home->expert_link_4 }} @endif"
                                                    aria-describedby="passwordHelpInline" placeholder="ID link" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <label for="inputPassword6" class="col-form-label">ID Link 5</label>
                                            </div>
                                            <div class="col-10">
                                                <input type="text" required name="expert_link5"
                                                    id="inputPassword6" class="form-control"
                                                    value="@if ($home) {{ $home->expert_link_5 }} @endif"
                                                    aria-describedby="passwordHelpInline" placeholder="ID link" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <label for="inputPassword6" class="col-form-label">ID Link 6</label>
                                            </div>
                                            <div class="col-10">
                                                <input type="text" required name="expert_link6"
                                                    id="inputPassword6" class="form-control"
                                                    value="@if ($home) {{ $home->expert_link_6 }} @endif"
                                                    aria-describedby="passwordHelpInline" placeholder="ID link" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <label for="inputPassword6" class="col-form-label">ID Link 7</label>
                                            </div>
                                            <div class="col-10">
                                                <input type="text" required name="expert_link7"
                                                    id="inputPassword6" class="form-control"
                                                    value="@if ($home) {{ $home->expert_link_7 }} @endif"
                                                    aria-describedby="passwordHelpInline" placeholder="ID link" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <label for="inputPassword6" class="col-form-label">ID Link 8</label>
                                            </div>
                                            <div class="col-10">
                                                <input type="text" required name="expert_link8"
                                                    id="inputPassword6" class="form-control"
                                                    value="@if ($home) {{ $home->expert_link_8 }} @endif"
                                                    aria-describedby="passwordHelpInline" placeholder="ID link" />
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="api-buttons">
                                <div class="row major-section">
                                    <div class="col-md-12 ">
                                        {{-- <button type="button" class="btn float-start cancel-btn">
                          Cancel
                        </button> --}}
                                        <button type="submit" class="btn float-end update-btn">Update</button>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </form>
                    <div class="api-section" type="button" value="Show/Hide" onClick="showHideDiv('divMsg7')">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="mb-0">Website Banner</h5>
                                <div class="float-end icon-sec">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="/update-home-dynamic" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="cate" value="banner1">
                        <div class="form-section conditions" id="divMsg7">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="">

                                        <div class="col-12 form-sec">
                                            <label for="inputAddress" class="form-label">Heading</label>
                                            <input type="text" required name="banner1_heading"
                                                class="form-control" id="inputAddress"
                                                value="@if ($home2) {{ $home2->banner_1_heading }} @endif"
                                                placeholder="Discover Classes and Freelance Categories" />
                                        </div>
                                        <div class="col-12 form-sec">
                                            <label for="inputAddress2" class="form-label">Description</label>
                                            <textarea required name="banner1_description" id="" cols="5" rows="3"
                                                placeholder="Discover Classes and Freelance Categories">
                                                @if ($home2){{ $home2->banner_1_description }}@endif
                                            </textarea>
                                        </div>
                                        <!--Image-->
                                        <div class="col-md-12 mb-4 personal-info identity" id="upload-image20">
                                            <label for="">Image</label>
                                            <div class="input-file-wrapper transition-linear-3 position-relative">
                                                <span class="remove-img-btn position-absolute"
                                                    @click="reset('post-thumbnail20')" v-if="preview!==null">
                                                    Remove
                                                </span>
                                                <label
                                                    class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                    for="post-thumbnail20">
                                                    <span v-show="preview===null">
                                                        <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                        <span class="d-block">Upload Image</span>
                                                        <p>Drag and drop files here</p>
                                                    </span>
                                                    <template v-if="preview">
                                                        <img :src="preview" class="img-fluid mt-2" />
                                                    </template>
                                                </label>
                                                <input type="file" name="banner1_image" accept="image/*"
                                                    value="@if ($home2) {{ $home2->banner_1_image }} @endif"
                                                    @change="previewImage('post-thumbnail20')" class="input-file"
                                                    id="post-thumbnail20" />
                                            </div>
                                        </div>
                                        <div class="row form-det">
                                            <div class="col-md-6">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <label for="inputPassword6" class="col-form-label">Button
                                                            Name</label>
                                                    </div>
                                                    <div class="col-9 mt-3">
                                                        <input type="text" required name="banner1_btn1"
                                                            id="inputPassword6"
                                                            value="@if ($home2) {{ $home2->banner_1_btn1_name }} @endif"
                                                            class="form-control mb-0"
                                                            aria-describedby="passwordHelpInline"
                                                            placeholder="Get Started" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <label for="inputPassword6"
                                                            class="col-form-label">Link</label>
                                                    </div>
                                                    <div class="col-10 mt-3">
                                                        <input type="text" required name="banner1_link1"
                                                            id="inputPassword6"
                                                            value="@if ($home2) {{ $home2->banner_1_btn1_link }} @endif"
                                                            class="form-control mb-0"
                                                            aria-describedby="passwordHelpInline"
                                                            placeholder="https://www.example.org" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-det">
                                            <div class="col-md-6">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <label for="inputPassword6" class="col-form-label">Button
                                                            Name</label>
                                                    </div>
                                                    <div class="col-9 mt-3">
                                                        <input type="text" required name="banner1_btn2"
                                                            id="inputPassword6"
                                                            value="@if ($home2) {{ $home2->banner_1_btn2_name }} @endif"
                                                            class="form-control mb-0"
                                                            aria-describedby="passwordHelpInline"
                                                            placeholder="Get Started" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <label for="inputPassword6"
                                                            class="col-form-label">Link</label>
                                                    </div>
                                                    <div class="col-10 mt-3">
                                                        <input type="text" required name="banner1_link2"
                                                            id="inputPassword6"
                                                            value="@if ($home2) {{ $home2->banner_1_btn2_link }} @endif"
                                                            class="form-control mb-0"
                                                            aria-describedby="passwordHelpInline"
                                                            placeholder="https://www.example.org" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="api-buttons">
                                <div class="row major-section">
                                    <div class="col-md-12 ">
                                        {{-- <button type="button" class="btn float-start cancel-btn">
                            Cancel
                          </button> --}}
                                        <button type="submit" class="btn float-end update-btn">Update</button>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </form>
                    <div class="api-section" type="button" value="Show/Hide" onClick="showHideDiv('divMsg9')">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="mb-0">Trending Services</h5>
                                <div class="float-end icon-sec">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="/update-home-dynamic" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="cate" value="services">
                        <div class="form-section" id="divMsg9">
                            <div class="row">

                                <div class="row form-det">
                                    <div class="col-md-12">
                                        <label for="inputAddress" class="form-label">Heading</label>
                                        <input type="text"
                                            value="@if ($home2) {{ $home2->service_heading }} @endif"
                                            required name="service_heading" class="form-control" id="inputAddress"
                                            placeholder="Discover Classes and Freelance Categories">
                                    </div>
                                    <div class="col-md-12 work-sec">
                                        <label for="inputAddress" class="form-label">Tagline</label>
                                        <input type="text"
                                            value="@if ($home2) {{ $home2->service_tagline }} @endif"
                                            required name="service_tagline" class="form-control" id="inputAddress"
                                            placeholder="Discover Classes and Freelance Categories">
                                    </div>
                                    <div class="row work-sec"></div>
                                    <div class="col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <label for="inputPassword6" class="col-form-label">Service ID
                                                    link</label>
                                            </div>
                                            <div class="col-10">
                                                <input type="text" required name="service_link1"
                                                    id="inputPassword6"
                                                    value="@if ($home2) {{ $home2->service_link_1 }} @endif"
                                                    class="form-control" aria-describedby="passwordHelpInline"
                                                    placeholder="ID link" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <label for="inputPassword6" class="col-form-label">Service ID
                                                    link</label>
                                            </div>
                                            <div class="col-10">
                                                <input type="text" required name="service_link2"
                                                    id="inputPassword6" class="form-control"
                                                    value="@if ($home2) {{ $home2->service_link_2 }} @endif"
                                                    aria-describedby="passwordHelpInline" placeholder="ID link" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-det">
                                    <div class="col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <label for="inputPassword6" class="col-form-label">Service ID
                                                    link</label>
                                            </div>
                                            <div class="col-10">
                                                <input type="text" required name="service_link3"
                                                    id="inputPassword6" class="form-control"
                                                    value="@if ($home2) {{ $home2->service_link_3 }} @endif"
                                                    aria-describedby="passwordHelpInline" placeholder="ID link" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <label for="inputPassword6" class="col-form-label">Service ID
                                                    link</label>
                                            </div>
                                            <div class="col-10">
                                                <input type="text" required name="service_link4"
                                                    id="inputPassword6" class="form-control"
                                                    value="@if ($home2) {{ $home2->service_link_4 }} @endif"
                                                    aria-describedby="passwordHelpInline" placeholder="ID link" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="api-buttons">
                                <div class="row major-section">
                                    <div class="col-md-12 ">
                                        {{-- <button type="button" class="btn float-start cancel-btn">
                            Cancel
                          </button> --}}
                                        <button type="submit" class="btn float-end update-btn">Update</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                    <div class="api-section" type="button" value="Show/Hide" onClick="showHideDiv('divMsg10')">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="mb-0">Website Banner</h5>
                                <div class="float-end icon-sec">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="/update-home-dynamic" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="cate" value="banner2">
                        <div class="form-section conditions" id="divMsg10">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="">

                                        <div class="col-12 form-sec">
                                            <label for="inputAddress" class="form-label">Heading</label>
                                            <input type="text" required name="banner2_heading"
                                                class="form-control" id="inputAddress"
                                                value="@if ($home2) {{ $home2->banner_2_heading }} @endif"
                                                placeholder="Discover Classes and Freelance Categories" />
                                        </div>
                                        <div class="col-12 form-sec">
                                            <label for="inputAddress2" class="form-label">Description</label>
                                            <textarea required name="banner2_description" id="" cols="5" rows="3"
                                                placeholder="Discover Classes and Freelance Categories">
                                              @if ($home2){{ $home2->banner_2_description }}@endif
                                            </textarea>
                                        </div>
                                        <!--Image-->
                                        <div class="col-md-12 mb-4 personal-info identity" id="upload-image30">
                                            <label for="">Image</label>
                                            <div class="input-file-wrapper transition-linear-3 position-relative">
                                                <span class="remove-img-btn position-absolute"
                                                    @click="reset('post-thumbnail30')" v-if="preview!==null">
                                                    Remove
                                                </span>
                                                <label
                                                    class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                    for="post-thumbnail30">
                                                    <span v-show="preview===null">
                                                        <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                        <span class="d-block">Upload Image</span>
                                                        <p>Drag and drop files here</p>
                                                    </span>
                                                    <template v-if="preview">
                                                        <img :src="preview" class="img-fluid mt-2" />
                                                    </template>
                                                </label>
                                                <input type="file" name="banner2_image" accept="image/*"
                                                    value="@if ($home2) {{ $home2->banner_2_image }} @endif"
                                                    @change="previewImage('post-thumbnail30')" class="input-file"
                                                    id="post-thumbnail30" />
                                            </div>
                                        </div>
                                        <div class="row form-det">
                                            <div class="col-md-6">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <label for="inputPassword6" class="col-form-label">Button
                                                            Name</label>
                                                    </div>
                                                    <div class="col-9 mt-3">
                                                        <input type="text" required name="banner2_btn1"
                                                            id="inputPassword6"
                                                            value="@if ($home2) {{ $home2->banner_2_btn1_name }} @endif"
                                                            class="form-control mb-0"
                                                            aria-describedby="passwordHelpInline"
                                                            placeholder="Get Started" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <label for="inputPassword6"
                                                            class="col-form-label">Link</label>
                                                    </div>
                                                    <div class="col-10 mt-3">
                                                        <input type="text" required name="banner2_link1"
                                                            id="inputPassword6"
                                                            value="@if ($home2) {{ $home2->banner_2_btn1_link }} @endif"
                                                            class="form-control mb-0"
                                                            aria-describedby="passwordHelpInline"
                                                            placeholder="https://www.example.org" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-det">
                                            <div class="col-md-6">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <label for="inputPassword6" class="col-form-label">Button
                                                            Name</label>
                                                    </div>
                                                    <div class="col-9 mt-3">
                                                        <input type="text" required name="banner2_btn2"
                                                            id="inputPassword6"
                                                            value="@if ($home2) {{ $home2->banner_2_btn2_name }} @endif"
                                                            class="form-control mb-0"
                                                            aria-describedby="passwordHelpInline"
                                                            placeholder="Get Started" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <label for="inputPassword6"
                                                            class="col-form-label">Link</label>
                                                    </div>
                                                    <div class="col-10 mt-3">
                                                        <input type="text" required name="banner2_link2"
                                                            id="inputPassword6"
                                                            value="@if ($home2) {{ $home2->banner_2_btn2_link }} @endif"
                                                            class="form-control mb-0"
                                                            aria-describedby="passwordHelpInline"
                                                            placeholder="https://www.example.org" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="api-buttons">
                                <div class="row major-section">
                                    <div class="col-md-12 ">
                                        {{-- <button type="button" class="btn float-start cancel-btn">
                            Cancel
                          </button> --}}
                                        <button type="submit" class="btn float-end update-btn">Update</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                    <div class="api-section" type="button" value="Show/Hide" onClick="showHideDiv('divMsg8')">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="mb-0">Buyer Reviews</h5>
                                <div class="float-end icon-sec">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="/update-home-dynamic" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="cate" value="reviews">
                        <div class="form-section" id="divMsg8">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <label for="inputEmail4" class="form-label">Heading</label>
                                                <input type="text" required name="review_heading"
                                                    class="form-control" id="inputEmail4"
                                                    value="@if ($home2) {{ $home2->review_heading }} @endif"
                                                    placeholder="Discover Classes and Freelance Categories" />
                                            </div>
                                            <div class="col-md-12 work-sec">
                                                <label for="inputEmail4" class="form-label">Tagline</label>
                                                <input type="text" required name="review_tagline"
                                                    class="form-control" id="inputEmail4"
                                                    value="@if ($home2) {{ $home2->review_tagline }} @endif"
                                                    placeholder="Discover Classes and Freelance Categories" />
                                            </div>
                                            <div class="row work-sec">
                                                <div class="col-md-3 gallery identity" id="upload-image21">
                                                    <div
                                                        class="input-file-wrapper transition-linear-3 position-relative">
                                                        <span class="remove-img-btn position-absolute"
                                                            @click="reset('post-thumbnail21')"
                                                            v-if="preview!==null">
                                                            Remove
                                                        </span>
                                                        <label
                                                            class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                            for="post-thumbnail21">
                                                            <span v-show="preview===null">
                                                                <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                                <span class="d-block">Upload Image</span>
                                                                <p>Drag and drop files here</p>
                                                            </span>
                                                            <template v-if="preview">
                                                                <img :src="preview" class="img-fluid mt-2" />
                                                            </template>
                                                        </label>
                                                        <input type="file" name="review_image1"
                                                            accept="image/*"
                                                            value="@if ($home2) {{ $home2->review_image_1 }} @endif"
                                                            @change="previewImage('post-thumbnail21')"
                                                            class="input-file" id="post-thumbnail21" />
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="inputEmail4" class="form-label">Name</label>
                                                            <input type="text" required name="review_name1"
                                                                class="form-control" id="inputEmail4"
                                                                value="@if ($home2) {{ $home2->review_name_1 }} @endif"
                                                                placeholder="eg. Usama A." />
                                                        </div>
                                                        <div class="col-md-4 desc">
                                                            <label for="inputEmail4"
                                                                class="form-label">Designation</label>
                                                            <input type="text" required
                                                                name="review_designation1" class="form-control"
                                                                id="inputEmail4"
                                                                value="@if ($home2) {{ $home2->review_designation_1 }} @endif"
                                                                placeholder="Designation" />
                                                        </div>
                                                        <div class="col-md-4 desc">
                                                            <label for="inputEmail4"
                                                                class="form-label">Rating</label>
                                                            <input type="text" required name="review_rating1"
                                                                class="form-control" id="inputEmail4"
                                                                value="@if ($home2) {{ $home2->review_rating_1 }} @endif"
                                                                placeholder="4" />
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label for="inputEmail4"
                                                                class="form-label">Review</label>
                                                            <input type="text" required name="review_review1"
                                                                class="form-control" id="inputEmail4"
                                                                value="@if ($home2) {{ $home2->review_review_1 }} @endif"
                                                                placeholder="Its great experience with DreamCrowd" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row work-sec">
                                                <div class="col-md-3 gallery identity" id="upload-image22">
                                                    <div
                                                        class="input-file-wrapper transition-linear-3 position-relative">
                                                        <span class="remove-img-btn position-absolute"
                                                            @click="reset('post-thumbnail22')"
                                                            v-if="preview!==null">
                                                            Remove
                                                        </span>
                                                        <label
                                                            class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                            for="post-thumbnail22">
                                                            <span v-show="preview===null">
                                                                <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                                <span class="d-block">Upload Image</span>
                                                                <p>Drag and drop files here</p>
                                                            </span>
                                                            <template v-if="preview">
                                                                <img :src="preview" class="img-fluid mt-2" />
                                                            </template>
                                                        </label>
                                                        <input type="file" name="review_image2"
                                                            accept="image/*"
                                                            value="@if ($home2) {{ $home2->review_image_2 }} @endif"
                                                            @change="previewImage('post-thumbnail22')"
                                                            class="input-file" id="post-thumbnail22" />
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="inputEmail4" class="form-label">Name</label>
                                                            <input type="text" required name="review_name2"
                                                                class="form-control" id="inputEmail4"
                                                                value="@if ($home2) {{ $home2->review_name_2 }} @endif"
                                                                placeholder="eg. Usama A." />
                                                        </div>
                                                        <div class="col-md-4 desc">
                                                            <label for="inputEmail4"
                                                                class="form-label">Designation</label>
                                                            <input type="text" required
                                                                name="review_designation2" class="form-control"
                                                                id="inputEmail4"
                                                                value="@if ($home2) {{ $home2->review_designation_2 }} @endif"
                                                                placeholder="Designation" />
                                                        </div>
                                                        <div class="col-md-4 desc">
                                                            <label for="inputEmail4"
                                                                class="form-label">Rating</label>
                                                            <input type="text" required name="review_rating2"
                                                                class="form-control" id="inputEmail4"
                                                                value="@if ($home2) {{ $home2->review_rating_2 }} @endif"
                                                                placeholder="4" />
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label for="inputEmail4"
                                                                class="form-label">Review</label>
                                                            <input type="text" required name="review_review2"
                                                                class="form-control"
                                                                id="inputEmail4"value="@if ($home2) {{ $home2->review_review_2 }} @endif"
                                                                placeholder="Its great experience with DreamCrowd" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row work-sec">
                                                <div class="col-md-3 gallery identity" id="upload-image23">
                                                    <div
                                                        class="input-file-wrapper transition-linear-3 position-relative">
                                                        <span class="remove-img-btn position-absolute"
                                                            @click="reset('post-thumbnail23')"
                                                            v-if="preview!==null">
                                                            Remove
                                                        </span>
                                                        <label
                                                            class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                            for="post-thumbnail23">
                                                            <span v-show="preview===null">
                                                                <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                                <span class="d-block">Upload Image</span>
                                                                <p>Drag and drop files here</p>
                                                            </span>
                                                            <template v-if="preview">
                                                                <img :src="preview" class="img-fluid mt-2" />
                                                            </template>
                                                        </label>
                                                        <input type="file" name="review_image3"
                                                            accept="image/*"
                                                            value="@if ($home2) {{ $home2->review_image_3 }} @endif"
                                                            @change="previewImage('post-thumbnail23')"
                                                            class="input-file" id="post-thumbnail23" />
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="inputEmail4" class="form-label">Name</label>
                                                            <input type="text" required name="review_name3"
                                                                class="form-control" id="inputEmail4"
                                                                value="@if ($home2) {{ $home2->review_name_3 }} @endif"
                                                                placeholder="eg. Usama A." />
                                                        </div>
                                                        <div class="col-md-4 desc">
                                                            <label for="inputEmail4"
                                                                class="form-label">Designation</label>
                                                            <input type="text" required
                                                                name="review_designation3" class="form-control"
                                                                id="inputEmail4"
                                                                value="@if ($home2) {{ $home2->review_designation_3 }} @endif"
                                                                placeholder="Designation" />
                                                        </div>
                                                        <div class="col-md-4 desc">
                                                            <label for="inputEmail4"
                                                                class="form-label">Rating</label>
                                                            <input type="text" required name="review_rating3"
                                                                class="form-control" id="inputEmail4"
                                                                value="@if ($home2) {{ $home2->review_rating_3 }} @endif"
                                                                placeholder="4" />
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label for="inputEmail4"
                                                                class="form-label">Review</label>
                                                            <input type="text" required name="review_review3"
                                                                class="form-control"
                                                                id="inputEmail4"value="@if ($home2) {{ $home2->review_review_3 }} @endif"
                                                                placeholder="Its great experience with DreamCrowd" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row work-sec">
                                                <div class="col-md-3 gallery identity" id="upload-image24">
                                                    <div
                                                        class="input-file-wrapper transition-linear-3 position-relative">
                                                        <span class="remove-img-btn position-absolute"
                                                            @click="reset('post-thumbnail24')"
                                                            v-if="preview!==null">
                                                            Remove
                                                        </span>
                                                        <label
                                                            class="input-style input-label lh-1-7 p-3 text-center cursor-pointer"
                                                            for="post-thumbnail24">
                                                            <span v-show="preview===null">
                                                                <i class="fa-solid fa-cloud-arrow-up pt-3"></i>
                                                                <span class="d-block">Upload Image</span>
                                                                <p>Drag and drop files here</p>
                                                            </span>
                                                            <template v-if="preview">
                                                                <img :src="preview" class="img-fluid mt-2" />
                                                            </template>
                                                        </label>
                                                        <input type="file" name="review_image4"
                                                            accept="image/*"
                                                            value="@if ($home2) {{ $home2->review_image_4 }} @endif"
                                                            @change="previewImage('post-thumbnail24')"
                                                            class="input-file" id="post-thumbnail24" />
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="inputEmail4" class="form-label">Name</label>
                                                            <input type="text" required name="review_name4"
                                                                class="form-control" id="inputEmail4"
                                                                value="@if ($home2) {{ $home2->review_name_4 }} @endif"
                                                                placeholder="eg. Usama A." />
                                                        </div>
                                                        <div class="col-md-4 desc">
                                                            <label for="inputEmail4"
                                                                class="form-label">Designation</label>
                                                            <input type="text" required
                                                                name="review_designation4" class="form-control"
                                                                id="inputEmail4"
                                                                value="@if ($home2) {{ $home2->review_designation_4 }} @endif"
                                                                placeholder="Designation" />
                                                        </div>
                                                        <div class="col-md-4 desc">
                                                            <label for="inputEmail4"
                                                                class="form-label">Rating</label>
                                                            <input type="text" required name="review_rating4"
                                                                class="form-control" id="inputEmail4"
                                                                value="@if ($home2) {{ $home2->review_rating_4 }} @endif"
                                                                placeholder="4" />
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label for="inputEmail4"
                                                                class="form-label">Review</label>
                                                            <input type="text" required name="review_review4"
                                                                class="form-control"
                                                                id="inputEmail4"value="@if ($home2) {{ $home2->review_review_4 }} @endif"
                                                                placeholder="Its great experience with DreamCrowd" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="api-buttons">
                                <div class="row major-section">
                                    <div class="col-md-12 ">
                                        {{-- <button type="button" class="btn float-start cancel-btn">
                          Cancel
                        </button> --}}
                                        <button type="submit" class="btn float-end update-btn">Update</button>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </form>
                    {{-- <div class="api-buttons">
      <div class="row major-section">
        <div class="col-md-12 ">
          <button type="button" class="btn float-start cancel-btn">
            Cancel
          </button>
          <button type="submit" class="btn float-end update-btn">Update</button>
        </div>
      </div>
    </div>           --}}
                </div>
                {{-- </form> --}}
            </div>
        </div>
        </div>
        <!-- =============================== MAIN CONTENT END HERE =========================== -->
        <!-- copyright section start from here -->
        <div class="copyright">
            <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
        </div>
    </section>

    <script src="assets/admin/libs/jquery/jquery.js"></script>
    <script src="assets/admin/libs/datatable/js/datatable.js"></script>
    <script src="assets/admin/libs/datatable/js/datatablebootstrap.js"></script>
    <script src="assets/admin/libs/select2/js/select2.min.js"></script>
    <script src="assets/admin/libs/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="assets/admin/libs/aos/js/aos.js"></script>
    <script src="assets/admin/asset/js/bootstrap.min.js"></script>
    <script src="assets/admin/asset/js/script.js"></script>
</body>

</html>

{{-- Notification Bar Show Hide Value Set Script --}}
<script>
    $(document).ready(function() {
        if ($('#aa1').attr('checked')) {
            $('#notification_check').val(1);
        } else {
            $('#notification_check').val(0);
        }
    });


    $('#aa1').click(function() {

        if ($('#aa1').attr('checked')) {
            $('#aa1').removeAttr('checked');
            $('#notification_check').val(0);
        } else {
            $('#aa1').attr('checked', 1);
            $('#notification_check').val(1);
        }

    });
</script>
<!-- Hide Show Content -->
<!-- 1 -->
<script>
    function showHideDiv(ele) {
        var srcElement = document.getElementById(ele);
        if (srcElement != null) {
            if (srcElement.style.display == "block") {
                srcElement.style.display = 'none';
            } else {
                srcElement.style.display = 'block';
            }
            return false;
        }
    }
</script>
<!-- 2 -->
<script>
    function showHideDiv1(ele) {
        var srcElement = document.getElementById(ele);
        if (srcElement != null) {
            if (srcElement.style.display == "block") {
                srcElement.style.display = 'none';
            } else {
                srcElement.style.display = 'block';
            }
            return false;
        }
    }
</script>
<!-- 3 -->
<script>
    function showHideDiv2(ele) {
        var srcElement = document.getElementById(ele);
        if (srcElement != null) {
            if (srcElement.style.display == "block") {
                srcElement.style.display = 'none';
            } else {
                srcElement.style.display = 'block';
            }
            return false;
        }
    }
</script>
<!-- 4 -->
<script>
    function showHideDiv3(ele) {
        var srcElement = document.getElementById(ele);
        if (srcElement != null) {
            if (srcElement.style.display == "block") {
                srcElement.style.display = 'none';
            } else {
                srcElement.style.display = 'block';
            }
            return false;
        }
    }
</script>
<!-- 5 -->
<script>
    function showHideDiv4(ele) {
        var srcElement = document.getElementById(ele);
        if (srcElement != null) {
            if (srcElement.style.display == "block") {
                srcElement.style.display = 'none';
            } else {
                srcElement.style.display = 'block';
            }
            return false;
        }
    }
</script>
<!-- 6 -->
<script>
    function showHideDiv5(ele) {
        var srcElement = document.getElementById(ele);
        if (srcElement != null) {
            if (srcElement.style.display == "block") {
                srcElement.style.display = 'none';
            } else {
                srcElement.style.display = 'block';
            }
            return false;
        }
    }
</script>
<!-- 7 -->
<script>
    function showHideDiv6(ele) {
        var srcElement = document.getElementById(ele);
        if (srcElement != null) {
            if (srcElement.style.display == "block") {
                srcElement.style.display = 'none';
            } else {
                srcElement.style.display = 'block';
            }
            return false;
        }
    }
</script>
<!-- 8 -->
<script>
    function showHideDiv7(ele) {
        var srcElement = document.getElementById(ele);
        if (srcElement != null) {
            if (srcElement.style.display == "block") {
                srcElement.style.display = 'none';
            } else {
                srcElement.style.display = 'block';
            }
            return false;
        }
    }
</script>
<!-- 9 -->
<script>
    function showHideDiv7(ele) {
        var srcElement = document.getElementById(ele);
        if (srcElement != null) {
            if (srcElement.style.display == "block") {
                srcElement.style.display = 'none';
            } else {
                srcElement.style.display = 'block';
            }
            return false;
        }
    }
</script>
<!-- 10 -->
<script>
    function showHideDiv8(ele) {
        var srcElement = document.getElementById(ele);
        if (srcElement != null) {
            if (srcElement.style.display == "block") {
                srcElement.style.display = 'none';
            } else {
                srcElement.style.display = 'block';
            }
            return false;
        }
    }
</script>
<!-- 11 -->
<script>
    function showHideDiv9(ele) {
        var srcElement = document.getElementById(ele);
        if (srcElement != null) {
            if (srcElement.style.display == "block") {
                srcElement.style.display = 'none';
            } else {
                srcElement.style.display = 'block';
            }
            return false;
        }
    }
</script>
<!-- 12 -->
<script>
    function showHideDiv10(ele) {
        var srcElement = document.getElementById(ele);
        if (srcElement != null) {
            if (srcElement.style.display == "block") {
                srcElement.style.display = 'none';
            } else {
                srcElement.style.display = 'block';
            }
            return false;
        }
    }
</script>
<!-- 13 -->
<script>
    function showHideDiv11(ele) {
        var srcElement = document.getElementById(ele);
        if (srcElement != null) {
            if (srcElement.style.display == "block") {
                srcElement.style.display = 'none';
            } else {
                srcElement.style.display = 'block';
            }
            return false;
        }
    }
</script>
<!-- Upload script start -->
<script>
    var site_logo = 'assets/public-site/asset/img/<?php echo $home ? $home->site_logo : ''; ?>';
    var fav_icon = 'assets/public-site/asset/img/<?php echo $home ? $home->fav_icon : ''; ?>';
    var hero_image = 'assets/public-site/asset/img/<?php echo $home ? $home->hero_image : ''; ?>';
    var rating_1 = 'assets/public-site/asset/img/<?php echo $home ? $home->rating_image_1 : ''; ?>';
    var rating_2 = 'assets/public-site/asset/img/<?php echo $home ? $home->rating_image_2 : ''; ?>';
    var rating_3 = 'assets/public-site/asset/img/<?php echo $home ? $home->rating_image_3 : ''; ?>';
    var rating_4 = 'assets/public-site/asset/img/<?php echo $home ? $home->rating_image_4 : ''; ?>';
    var rating_5 = 'assets/public-site/asset/img/<?php echo $home ? $home->rating_image_5 : ''; ?>';
    var rating_6 = 'assets/public-site/asset/img/<?php echo $home ? $home->rating_image_6 : ''; ?>';
    var work_image_1 = 'assets/public-site/asset/img/<?php echo $home ? $home->work_image_1 : ''; ?>';
    var work_image_2 = 'assets/public-site/asset/img/<?php echo $home ? $home->work_image_2 : ''; ?>';
    var work_image_3 = 'assets/public-site/asset/img/<?php echo $home ? $home->work_image_3 : ''; ?>';
    var category_image_1 = 'assets/public-site/asset/img/<?php echo $home ? $home->category_image_1 : ''; ?>';
    var category_image_2 = 'assets/public-site/asset/img/<?php echo $home ? $home->category_image_2 : ''; ?>';
    var category_image_3 = 'assets/public-site/asset/img/<?php echo $home ? $home->category_image_3 : ''; ?>';
    var category_image_4 = 'assets/public-site/asset/img/<?php echo $home ? $home->category_image_4 : ''; ?>';
    var category_image_5 = 'assets/public-site/asset/img/<?php echo $home ? $home->category_image_5 : ''; ?>';
    var category_image_6 = 'assets/public-site/asset/img/<?php echo $home ? $home->category_image_6 : ''; ?>';
    var category_image_7 = 'assets/public-site/asset/img/<?php echo $home ? $home->category_image_7 : ''; ?>';
    var category_image_8 = 'assets/public-site/asset/img/<?php echo $home ? $home->category_image_8 : ''; ?>';
    var banner_1_image = 'assets/public-site/asset/img/<?php echo $home2 ? $home2->banner_1_image : ''; ?>';
    var banner_2_image = 'assets/public-site/asset/img/<?php echo $home2 ? $home2->banner_2_image : ''; ?>';
    var review_image_1 = 'assets/public-site/asset/img/<?php echo $home2 ? $home2->review_image_1 : ''; ?>';
    var review_image_2 = 'assets/public-site/asset/img/<?php echo $home2 ? $home2->review_image_2 : ''; ?>';
    var review_image_3 = 'assets/public-site/asset/img/<?php echo $home2 ? $home2->review_image_3 : ''; ?>';
    var review_image_4 = 'assets/public-site/asset/img/<?php echo $home2 ? $home2->review_image_4 : ''; ?>';
    // 1
    new Vue({
        el: "#upload-image",
        data() {
            return {
                preview: site_logo,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        var image = new Image();
                        //Set the Base64 string return from FileReader as source.
                        image.src = e.target.result;
                        let data;
                        image.onload = function() {


                            //Determine the Height and Width.
                            var height = this.height;
                            var width = this.width;
                            if (height != 40 || width != 265) {
                                document.getElementById(id).value = "";
                                pre = null;

                                toastr.options = {
                                    "closeButton": true,
                                    "progressBar": true,
                                    "timeOut": "10000", // 10 seconds
                                    "extendedTimeOut": "4410000" // 10 seconds 
                                }
                                toastr.error(
                                "Logo Image Height 40px and Width 265px Only Allowed!");
                                data = "false";
                            } else {
                                data = "true";
                            }

                        };

                        setTimeout(() => {
                            if (data == "true") {
                                this.preview = e.target.result;

                            }
                        }, 10);


                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function(id) {
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
                preview: fav_icon,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
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
            reset: function(id) {
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
                preview: hero_image,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {


                let input = document.getElementById(id);


                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        var image = new Image();
                        //Set the Base64 string return from FileReader as source.
                        image.src = e.target.result;
                        let data;
                        image.onload = function() {


                            //Determine the Height and Width.
                            var height = this.height;
                            var width = this.width;
                            if (height != 408 || width != 612) {
                                document.getElementById(id).value = "";
                                pre = null;

                                toastr.options = {
                                    "closeButton": true,
                                    "progressBar": true,
                                    "timeOut": "10000", // 10 seconds
                                    "extendedTimeOut": "4410000" // 10 seconds
                                }
                                toastr.error(
                                    "Hero Image Height 408px and Width 612px Only Allowed!");
                                data = "false";
                            } else {
                                data = "true";
                            }

                        };

                        setTimeout(() => {
                            if (data == "true") {
                                this.preview = e.target.result;

                            }
                        }, 10);


                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }


            },
            reset: function(id) {
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
                preview: rating_1,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
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
            reset: function(id) {
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
                preview: rating_2,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
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
            reset: function(id) {
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
                preview: rating_3,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
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
            reset: function(id) {
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
                preview: rating_4,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
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
            reset: function(id) {
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
                preview: rating_5,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
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
            reset: function(id) {
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
                preview: rating_6,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
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
            reset: function(id) {
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
                preview: work_image_1,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {


                        var image = new Image();
                        //Set the Base64 string return from FileReader as source.
                        image.src = e.target.result;
                        let data;
                        image.onload = function() {
                            //Determine the Height and Width.
                            var height = this.height;
                            var width = this.width;
                            if (height != 280 || width != 400) {
                                document.getElementById(id).value = "";
                                this.preview = null;

                                toastr.options = {
                                    "closeButton": true,
                                    "progressBar": true,
                                    "timeOut": "10000", // 10 seconds
                                    "extendedTimeOut": "4410000" // 10 seconds
                                }
                                toastr.error(
                                    "Work Image Height 280px and Width 400px Only Allowed!");
                                data = "false";
                            } else {
                                data = "true";
                            }

                        };

                        setTimeout(() => {
                            if (data == "true") {
                                this.preview = e.target.result;

                            }
                        }, 10);


                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function(id) {
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
                preview: work_image_2,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {



                        var image = new Image();
                        //Set the Base64 string return from FileReader as source.
                        image.src = e.target.result;
                        let data;
                        image.onload = function() {
                            //Determine the Height and Width.
                            var height = this.height;
                            var width = this.width;
                            if (height != 280 || width != 400) {
                                document.getElementById(id).value = "";
                                this.preview = null;

                                toastr.options = {
                                    "closeButton": true,
                                    "progressBar": true,
                                    "timeOut": "10000", // 10 seconds
                                    "extendedTimeOut": "4410000" // 10 seconds
                                }
                                toastr.error(
                                    "Work Image Height 280px and Width 400px Only Allowed!");
                                data = "false";
                            } else {
                                data = "true";
                            }

                        };

                        setTimeout(() => {
                            if (data == "true") {
                                this.preview = e.target.result;

                            }
                        }, 10);


                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function(id) {
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
                preview: work_image_3,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {



                        var image = new Image();
                        //Set the Base64 string return from FileReader as source.
                        image.src = e.target.result;
                        let data;
                        image.onload = function() {
                            //Determine the Height and Width.
                            var height = this.height;
                            var width = this.width;
                            if (height != 280 || width != 400) {
                                document.getElementById(id).value = "";
                                this.preview = null;

                                toastr.options = {
                                    "closeButton": true,
                                    "progressBar": true,
                                    "timeOut": "10000", // 10 seconds
                                    "extendedTimeOut": "4410000" // 10 seconds
                                }
                                toastr.error(
                                    "Work Image Height 280px and Width 400px Only Allowed!");
                                data = "false";
                            } else {
                                data = "true";
                            }

                        };

                        setTimeout(() => {
                            if (data == "true") {
                                this.preview = e.target.result;

                            }
                        }, 10);


                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function(id) {
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
    // 13
    new Vue({
        el: "#upload-image12",
        data() {
            return {
                preview: category_image_1,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {


                        var image = new Image();
                        //Set the Base64 string return from FileReader as source.
                        image.src = e.target.result;
                        let data;
                        image.onload = function() {
                            //Determine the Height and Width.
                            var height = this.height;
                            var width = this.width;
                            if (height != 160 || width != 295) {
                                document.getElementById(id).value = "";
                                this.preview = null;

                                toastr.options = {
                                    "closeButton": true,
                                    "progressBar": true,
                                    "timeOut": "10000", // 10 seconds
                                    "extendedTimeOut": "4410000" // 10 seconds
                                }
                                toastr.error(
                                    "Category Image Height 160px and Width 295px Only Allowed!");
                                data = "false";
                            } else {
                                data = "true";
                            }

                        };

                        setTimeout(() => {
                            if (data == "true") {
                                this.preview = e.target.result;

                            }
                        }, 10);

                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function(id) {
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
    // 14
    new Vue({
        el: "#upload-image13",
        data() {
            return {
                preview: category_image_2,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {


                        var image = new Image();
                        //Set the Base64 string return from FileReader as source.
                        image.src = e.target.result;
                        let data;
                        image.onload = function() {
                            //Determine the Height and Width.
                            var height = this.height;
                            var width = this.width;
                            if (height != 160 || width != 295) {
                                document.getElementById(id).value = "";
                                this.preview = null;

                                toastr.options = {
                                    "closeButton": true,
                                    "progressBar": true,
                                    "timeOut": "10000", // 10 seconds
                                    "extendedTimeOut": "4410000" // 10 seconds
                                }
                                toastr.error(
                                    "Category Image Height 160px and Width 295px Only Allowed!");
                                data = "false";
                            } else {
                                data = "true";
                            }

                        };

                        setTimeout(() => {
                            if (data == "true") {
                                this.preview = e.target.result;

                            }
                        }, 10);



                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function(id) {
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
    // 15
    new Vue({
        el: "#upload-image14",
        data() {
            return {
                preview: category_image_3,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {


                        var image = new Image();
                        //Set the Base64 string return from FileReader as source.
                        image.src = e.target.result;
                        let data;
                        image.onload = function() {
                            //Determine the Height and Width.
                            var height = this.height;
                            var width = this.width;
                            if (height != 160 || width != 295) {
                                document.getElementById(id).value = "";
                                this.preview = null;

                                toastr.options = {
                                    "closeButton": true,
                                    "progressBar": true,
                                    "timeOut": "10000", // 10 seconds
                                    "extendedTimeOut": "4410000" // 10 seconds
                                }
                                toastr.error(
                                    "Category Image Height 160px and Width 295px Only Allowed!");
                                data = "false";
                            } else {
                                data = "true";
                            }

                        };

                        setTimeout(() => {
                            if (data == "true") {
                                this.preview = e.target.result;

                            }
                        }, 10);



                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function(id) {
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
    // 16
    new Vue({
        el: "#upload-image15",
        data() {
            return {
                preview: category_image_4,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {


                        var image = new Image();
                        //Set the Base64 string return from FileReader as source.
                        image.src = e.target.result;
                        let data;
                        image.onload = function() {
                            //Determine the Height and Width.
                            var height = this.height;
                            var width = this.width;
                            if (height != 160 || width != 295) {
                                document.getElementById(id).value = "";
                                this.preview = null;

                                toastr.options = {
                                    "closeButton": true,
                                    "progressBar": true,
                                    "timeOut": "10000", // 10 seconds
                                    "extendedTimeOut": "4410000" // 10 seconds
                                }
                                toastr.error(
                                    "Category Image Height 160px and Width 295px Only Allowed!");
                                data = "false";
                            } else {
                                data = "true";
                            }

                        };

                        setTimeout(() => {
                            if (data == "true") {
                                this.preview = e.target.result;

                            }
                        }, 10);



                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function(id) {
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
    // 17
    new Vue({
        el: "#upload-image16",
        data() {
            return {
                preview: category_image_5,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {


                        var image = new Image();
                        //Set the Base64 string return from FileReader as source.
                        image.src = e.target.result;
                        let data;
                        image.onload = function() {
                            //Determine the Height and Width.
                            var height = this.height;
                            var width = this.width;
                            if (height != 160 || width != 295) {
                                document.getElementById(id).value = "";
                                this.preview = null;

                                toastr.options = {
                                    "closeButton": true,
                                    "progressBar": true,
                                    "timeOut": "10000", // 10 seconds
                                    "extendedTimeOut": "4410000" // 10 seconds
                                }
                                toastr.error(
                                    "Category Image Height 160px and Width 295px Only Allowed!");
                                data = "false";
                            } else {
                                data = "true";
                            }

                        };

                        setTimeout(() => {
                            if (data == "true") {
                                this.preview = e.target.result;

                            }
                        }, 10);

                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function(id) {
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
    // 18
    new Vue({
        el: "#upload-image17",
        data() {
            return {
                preview: category_image_6,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {


                        var image = new Image();
                        //Set the Base64 string return from FileReader as source.
                        image.src = e.target.result;
                        let data;
                        image.onload = function() {
                            //Determine the Height and Width.
                            var height = this.height;
                            var width = this.width;
                            if (height != 160 || width != 295) {
                                document.getElementById(id).value = "";
                                this.preview = null;

                                toastr.options = {
                                    "closeButton": true,
                                    "progressBar": true,
                                    "timeOut": "10000", // 10 seconds
                                    "extendedTimeOut": "4410000" // 10 seconds
                                }
                                toastr.error(
                                    "Category Image Height 160px and Width 295px Only Allowed!");
                                data = "false";
                            } else {
                                data = "true";
                            }

                        };

                        setTimeout(() => {
                            if (data == "true") {
                                this.preview = e.target.result;

                            }
                        }, 10);

                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function(id) {
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
    // 19
    new Vue({
        el: "#upload-image18",
        data() {
            return {
                preview: category_image_7,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {


                        var image = new Image();
                        //Set the Base64 string return from FileReader as source.
                        image.src = e.target.result;
                        let data;
                        image.onload = function() {
                            //Determine the Height and Width.
                            var height = this.height;
                            var width = this.width;
                            if (height != 160 || width != 295) {
                                document.getElementById(id).value = "";
                                this.preview = null;

                                toastr.options = {
                                    "closeButton": true,
                                    "progressBar": true,
                                    "timeOut": "10000", // 10 seconds
                                    "extendedTimeOut": "4410000" // 10 seconds
                                }
                                toastr.error(
                                    "Category Image Height 160px and Width 295px Only Allowed!");
                                data = "false";
                            } else {
                                data = "true";
                            }

                        };

                        setTimeout(() => {
                            if (data == "true") {
                                this.preview = e.target.result;

                            }
                        }, 10);

                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function(id) {
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
    // 20
    new Vue({
        el: "#upload-image19",
        data() {
            return {
                preview: category_image_8,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {


                        var image = new Image();
                        //Set the Base64 string return from FileReader as source.
                        image.src = e.target.result;
                        let data;
                        image.onload = function() {
                            //Determine the Height and Width.
                            var height = this.height;
                            var width = this.width;
                            if (height != 160 || width != 295) {
                                document.getElementById(id).value = "";
                                this.preview = null;

                                toastr.options = {
                                    "closeButton": true,
                                    "progressBar": true,
                                    "timeOut": "10000", // 10 seconds
                                    "extendedTimeOut": "4410000" // 10 seconds
                                }
                                toastr.error(
                                    "Category Image Height 160px and Width 295px Only Allowed!");
                                data = "false";
                            } else {
                                data = "true";
                            }

                        };

                        setTimeout(() => {
                            if (data == "true") {
                                this.preview = e.target.result;

                            }
                        }, 10);

                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function(id) {
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
    // 21
    new Vue({
        el: "#upload-image20",
        data() {
            return {
                preview: banner_1_image,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {


                        var image = new Image();
                        //Set the Base64 string return from FileReader as source.
                        image.src = e.target.result;
                        let data;
                        image.onload = function() {
                            //Determine the Height and Width.
                            var height = this.height;
                            var width = this.width;
                            if (height != 320 || width != 400) {
                                document.getElementById(id).value = "";
                                this.preview = null;

                                toastr.options = {
                                    "closeButton": true,
                                    "progressBar": true,
                                    "timeOut": "10000", // 10 seconds
                                    "extendedTimeOut": "4410000" // 10 seconds
                                }
                                toastr.error(
                                    "Banner Image Height 320px and Width 400px Only Allowed!");
                                data = "false";
                            } else {
                                data = "true";
                            }

                        };

                        setTimeout(() => {
                            if (data == "true") {
                                this.preview = e.target.result;

                            }
                        }, 10);

                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function(id) {
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
    // 22
    new Vue({
        el: "#upload-image21",
        data() {
            return {
                preview: review_image_1,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
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
            reset: function(id) {
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
    // 23
    new Vue({
        el: "#upload-image22",
        data() {
            return {
                preview: review_image_2,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
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
            reset: function(id) {
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
    // 24
    new Vue({
        el: "#upload-image23",
        data() {
            return {
                preview: review_image_3,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
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
            reset: function(id) {
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
    // 25
    new Vue({
        el: "#upload-image24",
        data() {
            return {
                preview: review_image_4,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
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
            reset: function(id) {
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
    // 26
    new Vue({
        el: "#upload-image25",
        data() {
            return {
                preview: review_image_4,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
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
            reset: function(id) {
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
    // 27
    new Vue({
        el: "#upload-image30",
        data() {
            return {
                preview: banner_2_image,
                image: null,
            };
        },
        methods: {
            previewImage: function(id) {
                let input = document.getElementById(id);
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = (e) => {


                        var image = new Image();
                        //Set the Base64 string return from FileReader as source.
                        image.src = e.target.result;
                        let data;
                        image.onload = function() {
                            //Determine the Height and Width.
                            var height = this.height;
                            var width = this.width;
                            if (height != 320 || width != 400) {
                                document.getElementById(id).value = "";
                                this.preview = null;

                                toastr.options = {
                                    "closeButton": true,
                                    "progressBar": true,
                                    "timeOut": "10000", // 10 seconds
                                    "extendedTimeOut": "4410000" // 10 seconds
                                }
                                toastr.error(
                                    "Banner Image Height 320px and Width 400px Only Allowed!");
                                data = "false";
                            } else {
                                data = "true";
                            }

                        };

                        setTimeout(() => {
                            if (data == "true") {
                                this.preview = e.target.result;

                            }
                        }, 10);

                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                }
            },
            reset: function(id) {
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
</script>

<!-- Upload script End -->



<!-- ================ side js start here=============== -->
<!-- ================ side js start End=============== -->
