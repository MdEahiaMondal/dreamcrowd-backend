@extends('layout.app')
@section('title', 'Dashboard | Profile')


    @section('content')
        <div class="container-fluid">
            <div class="row Dash-notification">
                <div class="col-md-12">
                    <div class="dash">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="dash-top">
                                    <h1 class="dash-title">Dashboard</h1>
                                    <i class="fa-solid fa-chevron-right"></i>
                                    <span class="min-title">My Profile</span>
                                </div>
                            </div>
                        </div>
                        <!-- Blue MASSEGES section -->
                        <div class="user-notification mt-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="notify">
                                        <i class="bx bx-user icon" title="My Profile"></i>
                                        <h2>My Profile</h2>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-xl-3 col-lg-4 col-md-12">
                                    @if (session('success'))
                                        <div class="alert alert-success my-2">{{ session('success') }}</div>
                                    @endif
                                    <div class="main-profile-page">

                                        <!-- Profile Image -->
                                        <div class="col-md-2">
                                            <div class="avatar-upload">
                                                <div class="avatar-edit">
                                                    <input type='file' id="imageUpload" name="profile"
                                                        accept=".png, .jpg, .jpeg" />
                                                    <label for="imageUpload"></label>
                                                </div>
                                                <div class="avatar-preview">
                                                    <div id="imagePreview"
                                                        style="background-image: url('{{ $user->profile ? asset('assets/profile/img/' . $user->profile) : 'http://i.pravatar.cc/500?img=7' }}'); width: 100%;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Name Section -->
                                        <div class="name">
                                            <p>{{ $user->first_name ?? 'Petey Cruiser' }}</p>
                                            <h5>{{ $user->country ?? 'United Kingdom' }}</h5>
                                        </div>

                                        <!-- Form Fields -->
                                        <input type="text" class="form-control info" name="first_name"
                                            placeholder="First Name" value="{{ old('first_name', $user->first_name) }}" />
                                        <input type="text" class="form-control" name="last_name" placeholder="Last Name"
                                            value="{{ old('last_name', $user->last_name) }}" />
                                        <input type="text" class="form-control" name="country" placeholder="Country"
                                            value="{{ old('country', $user->country) }}" />
                                        {{-- <input type="text" class="form-control" name="designation"
          placeholder="Designation" value="{{ old('designation', $user->designation) }}" />
        <textarea class="form-control goals" name="goals" rows="3"
          placeholder="My Goals">{{ old('goals', $user->goals) }}</textarea> --}}

                                        <button type="submit" class="btn update-btn">Update</button>


                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-md-12 p-0">
                            <div class="copyright">
                                <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')

        <!-- ================ side js start here=============== -->
        <script>
            // Sidebar script
            document.addEventListener("DOMContentLoaded", function() {
                let arrow = document.querySelectorAll(".arrow");
                for (let i = 0; i < arrow.length; i++) {
                    arrow[i].addEventListener("click", function(e) {
                        let arrowParent = e.target.parentElement
                            .parentElement; // Selecting main parent of arrow
                        arrowParent.classList.toggle("showMenu");
                    });
                }

                let sidebar = document.querySelector(".sidebar");
                let sidebarBtn = document.querySelector(".bx-menu");

                sidebarBtn.addEventListener("click", function() {
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
                window.addEventListener("resize", function() {
                    toggleSidebar();
                });
            });
        </script>
        <!-- ================ side js start End=============== -->
        <!-- profile-upload -->

        <script>
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').css('background-image', 'url(' + e.target.result + ')').hide().fadeIn(650);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#imageUpload").change(function() {
                readURL(this);
            });
        </script>
        <!-- ============ -->
        <!-- =====================NEW JS END HERE====================== -->




    @endpush
