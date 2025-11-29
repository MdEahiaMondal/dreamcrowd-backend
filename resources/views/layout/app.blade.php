<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard | DreamCrowd') — {{ config('app.name') }}</title>

    {{-- here common css link --}}
    <!-- CSS Libraries -->

    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
    <!-- Flatpickr for Date Picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


    {{-- =======Toastr CDN ======== --}}
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- =======Toastr CDN ======== --}}
    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="/assets/user/asset/css/style.css" />

    {{-- Fav Icon --}}
    @php $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="/assets/public-site/asset/img/{{ $home->fav_icon }}" type="image/x-icon">
    @endif



    @php $role = Auth::user()->role @endphp

    @switch($role)
        @case(0)
            {{-- User --}}
                        {{-- Teacher --}}
            <!-- CSS Libraries -->
            <!-- Animate css -->
            <link rel="stylesheet" href="assets/teacher/libs/animate/css/animate.css" />
            <!-- AOS Animation css-->
            <link rel="stylesheet" href="assets/teacher/libs/aos/css/aos.css" />
            <!-- Datatable css  -->
            <link rel="stylesheet" href="assets/teacher/libs/datatable/css/datatable.css" />

            <!-- Select2 css -->
            <link href="assets/teacher/libs/select2/css/select2.min.css" rel="stylesheet" />
            <!-- Owl carousel css -->
            <link href="assets/teacher/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
            <link href="assets/teacher/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
            <!-- Bootstrap css -->



            <link rel="stylesheet" href="/assets/teacher/asset/css/bootstrap.min.css" />
            <link rel="stylesheet" href="/assets/teacher/asset/css/sidebar.css" />
            <link rel="stylesheet" href="/assets/teacher/asset/css/style.css">
            <link rel="stylesheet" href="/assets/teacher/asset/css/Dashboard.css">
        @break

        @case(1)
            {{-- Teacher --}}
            <!-- CSS Libraries -->
            <!-- Animate css -->
            <link rel="stylesheet" href="assets/teacher/libs/animate/css/animate.css" />
            <!-- AOS Animation css-->
            <link rel="stylesheet" href="assets/teacher/libs/aos/css/aos.css" />
            <!-- Datatable css  -->
            <link rel="stylesheet" href="assets/teacher/libs/datatable/css/datatable.css" />

            <!-- Select2 css -->
            <link href="assets/teacher/libs/select2/css/select2.min.css" rel="stylesheet" />
            <!-- Owl carousel css -->
            <link href="assets/teacher/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
            <link href="assets/teacher/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
            <!-- Bootstrap css -->



            <link rel="stylesheet" href="/assets/teacher/asset/css/bootstrap.min.css" />
            <link rel="stylesheet" href="/assets/teacher/asset/css/sidebar.css" />
            <link rel="stylesheet" href="/assets/teacher/asset/css/style.css">
            <link rel="stylesheet" href="/assets/teacher/asset/css/Dashboard.css">
        @break

        @case(2)
            {{-- Admin --}}
            <link rel="stylesheet" href="/assets/admin/asset/css/bootstrap.min.css" />
            <link rel="stylesheet" href="/assets/admin/asset/css/sidebar.css" />
            <link rel="stylesheet" href="/assets/admin/asset/css/style.css" />
            <link rel="stylesheet" href="/assets/admin/asset/css/Dashboard.css" />
        @break
    @endswitch

    @stack('styles')
</head>

<body>
    <!-- Loading Overlay -->
    <div class="dashboard-loading" id="dashboardLoading">
        <div class="spinner"></div>
    </div>


    @switch($role)
        {{-- User --}}
        @case(0)
            {{-- User layout (if needed you can include something here) --}}
            <x-user-sidebar />
            <section class="home-section">
                <!-- Navigation -->
                <x-user-nav />

                {{-- Page content --}}
                @yield('content')
            </section>
        @break

        {{-- Teacher --}}
        @case(1)
            <x-teacher-sidebar />

            <section class="home-section">
                <!-- Navigation -->
                <x-teacher-nav />

                {{-- Page content --}}
                @yield('content')
            </section>
        @break

        {{-- Admin --}}
        @case(2)
            <!-- Sidebar -->
            <x-admin-sidebar />

            <section class="home-section">
                <!-- Navigation -->
                <x-admin-nav />

                {{-- Page content --}}
                @yield('content')
            </section>
        @break

        @default
            {{-- Unknown role --}}
            <p>User role not recognized.</p>
    @endswitch



    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="/assets/teacher/asset/js/bootstrap.min.js"></script>
    <script src="assets/teacher/libs/jquery/jquery.js"></script>
    <script src="assets/teacher/libs/datatable/js/datatable.js"></script>
    <script src="assets/teacher/libs/datatable/js/datatablebootstrap.js"></script>
    <script src="assets/teacher/libs/select2/js/select2.min.js"></script>
    <script src="assets/teacher/libs/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="assets/teacher/libs/aos/js/aos.js"></script>
    <script src="assets/teacher/asset/js/bootstrap.min.js"></script>
    <script src="assets/teacher/asset/js/script.js"></script>




    @switch($role)
        {{-- User --}}
        @case(0)
            {{-- User Scripts (if needed you can include something here) --}}
        @break

        {{-- Teacher --}}
        @case(1)
        @break

        {{-- Admin --}}
        @case(2)
        @break

        @default
            {{-- Unknown role --}}
    @endswitch

    <!-- JS Libraries -->
    @stack('scripts')
    


</body>

</html>
