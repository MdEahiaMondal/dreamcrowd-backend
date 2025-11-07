<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <!-- View Point scale to 1.0 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Animate css -->
    <link rel="stylesheet" href="assets/teacher/libs/animate/css/animate.css" />
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="assets/teacher/libs/aos/css/aos.css" />
    <!-- Datatable css  -->
    <link rel="stylesheet" href="assets/teacher/libs/datatable/css/datatable.css" />
     {{-- Fav Icon --}}
     @php  $home = \App\Models\HomeDynamic::first(); @endphp
     @if ($home)
         <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
     @endif
     <!-- Select2 css -->
    <link href="assets/teacher/libs/select2/css/select2.min.css" rel="stylesheet" />
    <!-- Owl carousel css -->
    <link href="assets/teacher/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
    <link href="assets/teacher/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="assets/teacher/asset/css/bootstrap.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


{{-- =======Toastr CDN ======== --}}
<link rel="stylesheet" type="text/css"
href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
{{-- =======Toastr CDN ======== --}}
    <!-- Defualt css -->
    <link rel=" stylesheet " type=" text/css " href="assets/teacher/asset/css/class-management.css" />
    <link rel=" stylesheet " href=" assets/teacher/asset/css/Learn-How.css">
    <link rel="stylesheet" href="assets/teacher/asset/css/sidebar.css">
    <link rel="stylesheet" href="assets/teacher/asset/css/style.css">

</head>

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
                <!--===================== Slider Section Start================== -->
                <div class=" col-md-12 ">
                    <div class=" class-Manegment-slider ">
                        <div class=" owl-slider">
                            <div id=" carousel " class=" owl-carousel ">
                                @if ($banner)
                                @foreach ($banner as $item)
                                <div class=" item " style=" background-color:#0072B1; border-radius: 8px !important; ">
                                    <img src=" assets/teacher/asset/img/Cloud.png " alt=" ">
                                    <div class=" card-img-overlay slider-Img-Overlaye ">
                                        <h3>{{$item->heading}}</h3>
                                        <p>{{$item->description}}</p>
                                    </div>
                                </div>

                                @endforeach

                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <script src=" https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js ">
                </script>
                <script src=" https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js "></script>
                <!--===================== Slider Section End================== -->
            </div>
            <!-- Select Section Start Here  -->
            <div class=" row mx-1 ">
                <div class=" col-md-12 ">
                    <div class=" row mainSelect ">
                        <div class=" col-md-6 col-sm-12 ">
                            <h3 class=" Select-Heading ">Class category </h3>
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
                            {{-- <h3 class=" Select-Heading mt-2 ">Class type <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 13.5C6.91221 13.5 5.84884 13.1774 4.94437 12.5731C4.0399 11.9687 3.33495 11.1098 2.91867 10.1048C2.50238 9.09977 2.39347 7.9939 2.60568 6.927C2.8179 5.86011 3.34173 4.8801 4.11092 4.11091C4.8801 3.34172 5.86011 2.8179 6.92701 2.60568C7.9939 2.39346 9.09977 2.50238 10.1048 2.91866C11.1098 3.33494 11.9687 4.03989 12.5731 4.94436C13.1774 5.84883 13.5 6.9122 13.5 8C13.4983 9.45818 12.9184 10.8562 11.8873 11.8873C10.8562 12.9184 9.45819 13.4983 8 13.5ZM9 11C9 11.1326 8.94732 11.2598 8.85356 11.3536C8.75979 11.4473 8.63261 11.5 8.5 11.5C8.23479 11.5 7.98043 11.3946 7.7929 11.2071C7.60536 11.0196 7.5 10.7652 7.5 10.5V8C7.36739 8 7.24022 7.94732 7.14645 7.85355C7.05268 7.75979 7 7.63261 7 7.5C7 7.36739 7.05268 7.24021 7.14645 7.14645C7.24022 7.05268 7.36739 7 7.5 7C7.76522 7 8.01957 7.10536 8.20711 7.29289C8.39465 7.48043 8.5 7.73478 8.5 8V10.5C8.63261 10.5 8.75979 10.5527 8.85356 10.6464C8.94732 10.7402 9 10.8674 9 11ZM7 5.25C7 5.10166 7.04399 4.95666 7.1264 4.83332C7.20881 4.70999 7.32595 4.61386 7.46299 4.55709C7.60003 4.50032 7.75083 4.48547 7.89632 4.51441C8.04181 4.54335 8.17544 4.61478 8.28033 4.71967C8.38522 4.82456 8.45665 4.9582 8.48559 5.10368C8.51453 5.24917 8.49968 5.39997 8.44291 5.53701C8.38615 5.67406 8.29002 5.79119 8.16668 5.8736C8.04334 5.95601 7.89834 6 7.75 6C7.55109 6 7.36032 5.92098 7.21967 5.78033C7.07902 5.63968 7 5.44891 7 5.25Z" fill="#0072B1"/>
                              </svg> </h3>
                              <div class=" select-box ">
                                <select name="class_type" id="class_type" class=" fa ">


                                            <option value="Live" class=" fa ">Live</option>
                                            <option value="Recorded" class=" fa ">Recorded</option>
                                         </select>
                            </div> --}}
                            <h3 class=" Select-Heading mt-2 ">Class type lesson </h3>
                            <div class=" select-box ">
                                <select name="lesson_type" id="lesson_type" class=" fa ">
                                            <option value="One" class=" fa ">1-to-1 Lesson</option>
                                            <option value="Group" class=" fa ">Group Lesson</option>
                                        </select>
                            </div>
                        </div>
                        <div class=" col-md-6 col-sm-12 ">
                            <h3 class=" Select-Heading ">Class sub-category </h3>
                            <div class=" select-box ">
                                <select name="sub_category" id="sub_category" class="fa">
                                    <option value="" class="fa">--Select Sub-Category--</option>


                                 </select>
                            </div>


                            <div class=" col-md-6 col-sm-12 mt-2">
                                <h3 class=" Select-Heading ">Max. Travel Distance</h3>
                                <input class=" Class-Title " placeholder="10 Miles " type=" text ">

                            </div>
                        </div>
                        {{-- <div class=" col-md-6 col-sm-12 mt-2">
                            <h3 class=" Select-Heading ">Max. Travel Distance</h3>
                            <input class=" Class-Title " placeholder="10 Miles " type=" text ">

                        </div> --}}
                        {{-- <div class=" col-md-6 col-sm-12 mt-3">
                            <h3 class=" Select-Heading ">Per Mile Charge (optional)</h3>
                            <input class=" Class-Title " placeholder=" $24 " type=" text ">
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class=" row mx-1 ">

            <div class=" col-md-12 ">
                <div class=" mainSelect ">
                    <h3 class=" Select-Heading ">Title</h3>
                    <input class=" Class-Title " placeholder=" Class Title " type=" text ">
                    <h3 class=" Select-Heading ">Description</h3>
                    <textarea id="textArea-class" name=" w3review " rows=" 4 " cols=" 50 " placeholder="Description"></textarea>
                    <h3 class=" Select-Heading ">Requirements</h3>
                    <textarea id=" textArea-class " name=" w3review " rows=" 4 " cols=" 50 " placeholder="What should guest bring"></textarea>
                    <h3 class=" Select-Heading ">Upload a video or image to support the title/description</h3>
                    <!-- upload Section start -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Upload Area -->
                            <div id="uploadArea" class="upload-area">
                                <!-- Header -->
                                <div class="upload-area__header">
                                    <h1 class="upload-area__title"></h1>
                                    <p class="upload-area__paragraph">

                                        <strong class="upload-area__tooltip">

                                                    <span class="upload-area__tooltip-data"></span> </strong>
                                    </p>
                                </div>
                                <!-- End Header -->

                                <!-- Drop Zoon -->
                                <div id="dropZoon" class="upload-area__drop-zoon drop-zoon">
                                    <span class="drop-zoon__icon">
                                                <!-- <i class='bx bxs-file-image'></i> -->
                                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                            </span>
                                    <h4 class="add-img">Add Main Photo</h4>
                                    <p class="drop-zoon__paragraph">Drop your file here or Click to browse</p>
                                    <span id="loadingText" class="drop-zoon__loading-text">Please Wait</span>
                                    <img src="" alt="Preview Image" id="previewImage" class="drop-zoon__preview-image" draggable="false">
                                    <input type="file" id="fileInput" class="drop-zoon__file-input" accept="image/*">
                                </div>
                                <!-- End Drop Zoon -->

                                <!-- File Details -->
                                <div id="fileDetails" class="upload-area__file-details file-details">
                                    <h3 class="file-details__title">Uploaded File</h3>

                                    <div id="uploadedFile" class="uploaded-file">
                                        <div class="uploaded-file__icon-container">
                                            <i class='bx bxs-file-blank uploaded-file__icon'></i>

                                            <span class="uploaded-file__icon-text"></span>

                                        </div>

                                        <div id="uploadedFileInfo" class="uploaded-file__info">
                                            <span class="uploaded-file__name">Proejct 1</span>
                                            <span class="uploaded-file__counter">0%</span>
                                        </div>
                                    </div>
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/brands.min.css"></script>
                                </div>
                                <!-- End File Details
                                                    </div>
                                                    <!-- End Upload Area -->
                            </div>
                        </div>
                    </div>
                    <!-- Upload Section End -->
                    <h3 class=" Select-Heading ">Add other photos (optional)</h3>
                    <!-- upload Section start -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Upload Area -->
                            <div id="uploadArea" class="upload-area">
                                <!-- Header -->
                                <div class="upload-area__header">
                                    <h1 class="upload-area__title"></h1>
                                    <p class="upload-area__paragraph">

                                        <strong class="upload-area__tooltip">

                                                    <span class="upload-area__tooltip-data"></span> </strong>
                                    </p>
                                </div>
                                <!-- End Header -->

                                <!-- Drop Zoon -->
                                <div id="dropZoon" class="upload-area__drop-zoon drop-zoon">
                                    <span class="drop-zoon__icon">
                                                <!-- <i class='bx bxs-file-image'></i> -->
                                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                            </span>
                                    <h4 class="add-img">Add Main Photo</h4>
                                    <p class="drop-zoon__paragraph">Drop your file here or Click to browse</p>
                                    <span id="loadingText" class="drop-zoon__loading-text">Please Wait</span>
                                    <img src="" alt="Preview Image" id="previewImage" class="drop-zoon__preview-image" draggable="false">
                                    <input type="file" id="fileInput" class="drop-zoon__file-input" accept="image/*">
                                </div>
                                <!-- End Drop Zoon -->

                                <!-- File Details -->
                                <div id="fileDetails" class="upload-area__file-details file-details">
                                    <h3 class="file-details__title">Uploaded File</h3>

                                    <div id="uploadedFile" class="uploaded-file">
                                        <div class="uploaded-file__icon-container">
                                            <i class='bx bxs-file-blank uploaded-file__icon'></i>

                                            <span class="uploaded-file__icon-text"></span>

                                        </div>

                                        <div id="uploadedFileInfo" class="uploaded-file__info">
                                            <span class="uploaded-file__name">Proejct 1</span>
                                            <span class="uploaded-file__counter">0%</span>
                                        </div>
                                    </div>
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/brands.min.css"></script>
                                </div>
                                <!-- End File Details
                                                    </div>
                                                    <!-- End Upload Area -->
                            </div>
                        </div>
                    </div>
                    <!-- Upload Section End -->
                    <h3 class=" Select-Heading ">Add a video (optional)</h3>
                    <!-- upload Section start -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Upload Area -->
                            <div id="uploadArea" class="upload-area">
                                <!-- Header -->
                                <div class="upload-area__header">
                                    <h1 class="upload-area__title"></h1>
                                    <p class="upload-area__paragraph">

                                        <strong class="upload-area__tooltip">

                                                    <span class="upload-area__tooltip-data"></span> </strong>
                                    </p>
                                </div>
                                <!-- End Header -->

                                <!-- Drop Zoon -->
                                <div id="dropZoon" class="upload-area__drop-zoon drop-zoon">
                                    <span class="drop-zoon__icon">
                                                <!-- <i class='bx bxs-file-image'></i> -->
                                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                            </span>
                                    <h4 class="add-img">Add Main Photo</h4>
                                    <p class="drop-zoon__paragraph">Drop your file here or Click to browse</p>
                                    <span id="loadingText" class="drop-zoon__loading-text">Please Wait</span>
                                    <img src="" alt="Preview Image" id="previewImage" class="drop-zoon__preview-image" draggable="false">
                                    <input type="file" id="fileInput" class="drop-zoon__file-input" accept="image/*">
                                </div>
                                <!-- End Drop Zoon -->

                                <!-- File Details -->
                                <div id="fileDetails" class="upload-area__file-details file-details">
                                    <h3 class="file-details__title">Uploaded File</h3>

                                    <div id="uploadedFile" class="uploaded-file">
                                        <div class="uploaded-file__icon-container">
                                            <i class='bx bxs-file-blank uploaded-file__icon'></i>

                                            <span class="uploaded-file__icon-text"></span>

                                        </div>

                                        <div id="uploadedFileInfo" class="uploaded-file__info">
                                            <span class="uploaded-file__name">Proejct 1</span>
                                            <span class="uploaded-file__counter">0%</span>
                                        </div>
                                    </div>
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/brands.min.css"></script>
                                </div>
                                <!-- End File Details
                                                    </div>
                                                      End Upload Area -->
                            </div>
                        </div>
                    </div>
                    <!-- Upload Section End -->


                </div>

            </div>
            <div class="col-md-12">
                <div class="Teacher-next-back-Section">

                    <button class="teacher-back-btn">Back</button>


                    <a  href="/class-payment-set" class="teacher-next-btn">Next</a>
                    {{-- <a  href="Learn-How -3.html" class="teacher-next-btn">Next</a> --}}

                </div>
            </div>
        </div>
        </div>
        <!-- =============================== MAIN CONTENT END HERE =========================== -->
    </section>

    </section>
    </div>
    </div>

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
 <!-- JavaScript to close the modal when Cancel button is clicked -->
<script>
    // Wait for the document to load
    document.addEventListener('DOMContentLoaded', function() {
      // Get the Cancel button by its ID
      var cancelButton = document.getElementById('cancelButton');

      // Add a click event listener to the Cancel button
      cancelButton.addEventListener('click', function() {
        // Find the modal by its ID
        var modal = document.getElementById('exampleModal6');

        // Use Bootstrap's modal method to hide the modal
        $(modal).modal('hide');
      });
    });
  </script>
    <script src=" assets/teacher/libs/jquery/jquery.js "></script>
    <script src=" assets/teacher/libs/datatable/js/datatable.js "></script>
    <script src=" assets/teacher/libs/datatable/js/datatablebootstrap.js "></script>
    <script src=" assets/teacher/libs/select2/js/select2.min.js "></script>
    <!-- <script src=" assets/teacher/libs/owl-carousel/js/jquery.min.js "></script> -->
    <script src=" assets/teacher/libs/owl-carousel/js/owl.carousel.min.js "></script>
    <!-- jQuery -->
    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"
    ></script>
<!-- baner slider speed -->



<script>


    $('#category').on('change', function () {
      var category =  $('#category').val();
      var role =  $('#role').val();
      var type =  $('#type').val();

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.ajax({
            type: "POST",
            url: '/get-class-manage-sub-cates',
            data:{ type:type, role:role, category:category, _token: '{{csrf_token()}}'},
            dataType: 'json',
            success: function (response) {

                var sub_cates = response['sub_cates'] ;
                var len = sub_cates.length ;
                $('#sub_category').empty();

                var html = '' ;

                  if (len > 0  ) {

                    $('#sub_category').append('<option value="" class="fa" aria-hidden="true">--Select Sub-Category--</option>');

                    for (let i = 0; i < len; i++) {
                        const element = sub_cates[i];
                        $('#sub_category').append('<option value="'+element+'" class="fa" aria-hidden="true">'+element+'</option>');

                    }

                  }

            },

        });

    });


</script>


<script>
    $(document).ready(function(){
    $("#carousel").owlCarousel({
        loop:true,
        margin:10,
        autoplay:true,
        autoplayTimeout:2000,
        autoplaySpeed: 500,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    });
});

</script>
    <script>
        $(document).ready(function() {
            $('.owl-carousel').owlCarousel({
                items: 1,
                margin: 30
            });
        })
    </script>

    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
    <script>
        new DataTable('#example', {
            scrollX: true
        });
    </script>

    <script src=" libs/aos/js/aos.js "></script>
    <script>
        AOS.init();
    </script>
    <script src=" assets/js/bootstrap.min.js "></script>

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
    window.onload = function() {
        showAdditionalOptions1();
    };
</script>
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
        autoplayTimeout: 2000,
        smartSpeed: 300,
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
    dropZoon.addEventListener('dragover', function(event) {
        // Prevent Default Behavior
        event.preventDefault();

        // Add Class (drop-zoon--over) On (drop-zoon)
        dropZoon.classList.add('drop-zoon--over');
    });

    // When (drop-zoon) has (dragleave) Event
    dropZoon.addEventListener('dragleave', function(event) {
        // Remove Class (drop-zoon--over) from (drop-zoon)
        dropZoon.classList.remove('drop-zoon--over');
    });

    // When (drop-zoon) has (drop) Event
    dropZoon.addEventListener('drop', function(event) {
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
    dropZoon.addEventListener('click', function(event) {
        // Click The (fileInput)
        fileInput.click();
    });

    // When (fileInput) has (change) Event
    fileInput.addEventListener('change', function(event) {
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
            fileReader.addEventListener('load', function() {
                // After Half Second
                setTimeout(function() {
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

        };
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
        };

        // If The Uploaded File Is An Image
        if (isImage.length !== 0) {
            // Check, If File Size Is 2MB or Less
            if (fileSize <= 2000000) { // 2MB :)
                return true;
            } else { // Else File Size
                return alert('Please Your File Should be 2 Megabytes or Less');
            };
        } else { // Else File Type
            return alert('Please make sure to upload An Image File Type');
        };
    };

    // :)
</script>
<!-- upload file end js -->
<!-- ================ side js start here=============== -->
  <!-- ================ side js start End=============== -->


</html>
