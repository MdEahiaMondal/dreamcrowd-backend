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

            </div>
            <!-- Select Section Start Here  -->
            
            <div class=" row ">
                <div class=" col-md-12 ">
                    <div class=" mainSelect ">
                        <h3 class=" Select-Heading ">Title</h3>
                        <input class=" Class-Title " placeholder=" Class Title " type=" text ">
                        <h3 class=" Select-Heading ">Description</h3>
                        <textarea id=" textArea-class " name=" w3review " rows=" 4 " cols=" 50 " placeholder="Discription"></textarea>
                        <h3 class=" Select-Heading ">Requirements</h3>
                        <textarea id=" textArea-class " name=" w3review " rows=" 4 " cols=" 50 " placeholder="What should guest bring"></textarea>
                        <h3 class=" Select-Heading ">Upload a video or image to support the title/description</h3>
                        <!-- upload Section start -->
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
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
                            <div class="col-md-6 col-sm-12">
                                <div class="uPloaded-img">
                                    <h3>Uploaded Images</h3>
                                    <div class="images">
                                        <img src="assets/teacher/asset/img/Rectangle 2438.png" alt="">
                                        <img src="assets/teacher/asset/img/Rectangle 2438.png" alt="">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Upload Section End -->
                        <h3 class=" Select-Heading ">Add other photos (optional)</h3>
                        <!-- upload Section start -->
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
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
                            <div class="col-md-6 col-sm-12">
                                <div class="uPloaded-img">
                                    <h3>Uploaded Images</h3>
                                    <div class="images">
                                        <img src="assets/teacher/asset/img/Rectangle 2438.png" alt="">
                                        <img src="assets/teacher/asset/img/Rectangle 2438.png" alt="">
                                        <img src="assets/teacher/asset/img/Rectangle 2438.png" alt="">
                                        <img src="assets/teacher/asset/img/Rectangle 2438.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Upload Section End -->
                        <h3 class=" Select-Heading ">Add a video (optional)</h3>
                        <!-- upload Section start -->
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
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

                            <div class="col-md-6 col-sm-12">
                                <div class="uPloaded-img">
                                    <h3>Uploaded Images</h3>
                                    <div class="images">
                                        <img src="assets/teacher/asset/img/Rectangle 2438.png" alt="">

                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- Upload Section End -->
                    </div>

                </div>
                <div class="col-md-12">
                    <div class="Teacher-next-back-Section">

                        <a href="payment-1.html" class="teacher-back-btn">Back</a>


                        <a href="payment.html" class="teacher-next-btn">Update</a>

                    </div>
                </div>
            </div>

        </div>
        <!-- =============================== MAIN CONTENT END HERE =========================== -->
    </section>

    </section>
    </div>
    </div>

 
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

    <script>
        $(document).ready(function() {
            $('.owl-carousel').owlCarousel({
                items: 1,
                margin: 30
            });
        })
    </script>
    <!-- ================ side js start here=============== -->
  <!-- ================ side js start End=============== -->
    
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
    window.onload = function() {
        showAdditionalOptions1();
    };
</script>