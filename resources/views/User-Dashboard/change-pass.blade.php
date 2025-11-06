<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8"/>
    <!-- View Point scale to 1.0 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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
    <link
        rel="stylesheet"
        type="text/css"
        href="assets/user/asset/css/bootstrap.min.css"
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
    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/user/asset/css/sidebar.css"/>
    <link rel="stylesheet" href="assets/user/asset/css/style.css"/>
    <title>User Dashboard | Change Password</title>
</head>
<style>
    .button {
        color: #0072b1 !important;
    }

    .toggle-password {
        float: right;
        position: relative;
        bottom: 30px;
        right: 50px;
        color: #ababab;
    }

    .fa-eye-slash:before {
        content: "\f070";
    }

    .fa-eye:before {
        content: "\f06e";
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



{{-- ===========User Sidebar Start==================== --}}
<x-user-sidebar/>
{{-- ===========User Sidebar End==================== --}}
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
                                <nav
                                    style="--bs-breadcrumb-divider: '>'"
                                    aria-label="breadcrumb"
                                >
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item dash-title">
                                            <a href="#">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item dash-title">
                                            <a href="#">Account Setting</a>
                                        </li>
                                        <li
                                            class="breadcrumb-item active min-title"
                                            aria-current="page"
                                        >
                                            Change Password
                                        </li>
                                    </ol>
                                </nav>
                                <!-- <h1 class="dash-title">Dashboard</h1>
                                <i class="fa-solid fa-chevron-right"></i>
                                <h1 class="dash-title">Account Setting</h1>
                                <i class="fa-solid fa-chevron-right"></i>
                                <span class="min-title">Change Password</span> -->
                            </div>
                        </div>
                    </div>
                    <!-- Blue MASSEGES section -->
                    <div class="user-notification">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="notify">
                                    <i class="bx bx-cog icon" title="Account Settings"></i>
                                    <h2>Account Settings</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="/update-password" method="POST">
                        @csrf

                        <div class="drop-mail-sec">
                            <div class="row">
                                <h1>Change Password</h1>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input
                                            type="password" name="password"
                                            class="form-control" required
                                            id="old_password"
                                            placeholder="Current Password"
                                        />
                                        <span toggle="#old_password" onclick="ShowPass(this.id)" id="Old_Eye_Pass"
                                              class="fa fa-fw fa-eye field-icon toggle-password"></span>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input
                                            type="password" name="new_password"
                                            class="form-control" required
                                            id="new_password"
                                            placeholder="New Password"
                                        />
                                        <span toggle="#new_password" onclick="ShowPass(this.id)" id="New_Eye_Pass"
                                              class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        <div id="passwordPopup" class="password-popup">
                                            <ul>
                                                <li id="length">At least 8 characters</li>
                                                <li id="capital">At least one uppercase letter</li>
                                                <li id="number">At least one number</li>
                                                <li id="special">At least one special character</li>
                                            </ul>
                                        </div>
                                        <style>
                                            .password-popup {
                                                display: none;
                                                position: absolute;
                                                top: 310px;
                                                left: 280px;
                                                background-color: #f9f9f9;
                                                border: 1px solid #ccc;
                                                border-radius: 10px;
                                                padding: 10px;
                                                width: max-content;
                                                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                                            }

                                            .password-popup ul {
                                                list-style: none;
                                                padding: 0;
                                                margin: 0;
                                            }

                                            .password-popup ul li {
                                                font-size: 10px;
                                                margin-bottom: 5px;
                                                color: #ff0000 !important; /* Red color for unfulfilled criteria */
                                            }

                                            .password-popup ul li.valid {
                                                color: #00cc00 !important; /* Green color for fulfilled criteria */
                                            }
                                        </style>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input
                                            type="password" name="c_password"
                                            class="form-control" required
                                            id="c_password"
                                            placeholder="Confirm New Password"
                                        />
                                        <span toggle="#c_password" onclick="ShowPass(this.id)" id="C_Eye_Pass"
                                              class="fa fa-fw fa-eye field-icon toggle-password"></span>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="copyright">
                    <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- =============================== MAIN CONTENT END HERE =========================== -->
</section>

<script src="assets/user/libs/jquery/jquery.js"></script>
<script src="assets/user/libs/datatable/js/datatable.js"></script>
<script src="assets/user/libs/datatable/js/datatablebootstrap.js"></script>
<script src="assets/user/libs/select2/js/select2.min.js"></script>
<script src="assets/user/libs/owl-carousel/js/owl.carousel.min.js"></script>
<script src="assets/user/libs/aos/js/aos.js"></script>
<script src="assets/user/asset/js/bootstrap.min.js"></script>
<script src="assets/user/asset/js/script.js"></script>
<!-- jQuery -->
<script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"
></script>
</body>
</html>
{{-- scrript Password Requirements Start --}}
<script>
    // Select elements
    const passwordInput = document.getElementById('new_password');
    const passwordPopup = document.getElementById('passwordPopup');

    const lengthCriteria = document.getElementById('length');
    const capitalCriteria = document.getElementById('capital');
    const numberCriteria = document.getElementById('number');
    const specialCriteria = document.getElementById('special');

    // Show popup on focus
    passwordInput.addEventListener('focus', () => {
        passwordPopup.style.display = 'block';
    });

    // Hide popup on blur
    passwordInput.addEventListener('blur', () => {
        passwordPopup.style.display = 'none';
    });

    // Validate password on input
    passwordInput.addEventListener('input', () => {
        const passwordValue = passwordInput.value;

        // Validate length (at least 8 characters)
        if (passwordValue.length >= 8) {
            lengthCriteria.classList.add('valid');
        } else {
            lengthCriteria.classList.remove('valid');
        }

        // Validate capital letter
        if (/[A-Z]/.test(passwordValue)) {
            capitalCriteria.classList.add('valid');
        } else {
            capitalCriteria.classList.remove('valid');
        }

        // Validate number
        if (/[0-9]/.test(passwordValue)) {
            numberCriteria.classList.add('valid');
        } else {
            numberCriteria.classList.remove('valid');
        }

        // Validate special character
        if (/[\W_]/.test(passwordValue)) { // \W matches any non-word character
            specialCriteria.classList.add('valid');
        } else {
            specialCriteria.classList.remove('valid');
        }
    });


</script>
{{-- scrript Password Requirements END --}}
{{-- PAssword Show Hide Eye Icon Click Script Start --}}
<script>
    function ShowPass(Clicked) {
        var togglePassword = $('#' + Clicked).attr("toggle");


        const password = document.querySelector(togglePassword);

        console.log('yee');

        // Toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        if (type == 'text') {
            $('#' + Clicked).addClass('fa-eye-slash');
            $('#' + Clicked).removeClass('fa-eye');
        } else {
            $('#' + Clicked).removeClass('fa-eye-slash');
            $('#' + Clicked).addClass('fa-eye');
        }


    }

</script>
{{-- PAssword Show Hide Eye Icon Click Script END --}}
<!--  -->
<script>
    const select = document.querySelector(".select");
    const options_list = document.querySelector(".options-list");
    const options = document.querySelectorAll(".option");

    //show & hide options list
    select.addEventListener("click", () => {
        options_list.classList.toggle("active");
        select.querySelector(".fa-angle-down").classList.toggle("fa-angle-up");
    });
    //select option
    options.forEach((option) => {
        option.addEventListener("click", () => {
            options.forEach((option) => {
                option.classList.remove("selected");
            });
            // select.querySelector("span").innerHTML = option.innerHTML;
            option.classList.add("selected");
            options_list.classList.toggle("active");
            select.querySelector(".fa-angle-down").classList.toggle("fa-angle-up");
        });
    });
</script>
<!--  -->

<!-- =================== -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
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

        // Check if "Account Settings" dropdown should be open
        let accountSettingsItem = document.querySelector(
            ".nav-links li:last-child"
        );
        let accountSettingsDropdown =
            accountSettingsItem.querySelector(".sub-menu");

        // Check if the dropdown was previously open
        let isAccountSettingsOpen =
            localStorage.getItem("accountSettingsOpen") === "true";
        if (isAccountSettingsOpen) {
            accountSettingsItem.classList.add("active");
            accountSettingsDropdown.style.display = "block";
        }

        // Ensure dropdown stays open when clicked
        accountSettingsItem.addEventListener("click", function (event) {
            let isActive = accountSettingsItem.classList.contains("active");
            if (!isActive) {
                accountSettingsItem.classList.add("active");
                accountSettingsDropdown.style.display = "block";
                localStorage.setItem("accountSettingsOpen", true);
            }
        });
    });
</script>

<!-- =================== -->

<!-- ================ side js start here=============== -->
<!-- ================ side js start End=============== -->


<!-- radio js here -->
<script>
    function showAdditionalOptions1() {
        hideAllAdditionalOptions();
        document.getElementById("additionalOptions1").style.display = "block";
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
    document.addEventListener("DOMContentLoaded", function () {
        // Get the Cancel button by its ID
        var cancelButton = document.getElementById("cancelButton");

        // Add a click event listener to the Cancel button
        cancelButton.addEventListener("click", function () {
            // Find the modal by its ID
            var modal = document.getElementById("exampleModal3");

            // Use Bootstrap's modal method to hide the modal
            $(modal).modal("hide");
        });
    });
</script>
