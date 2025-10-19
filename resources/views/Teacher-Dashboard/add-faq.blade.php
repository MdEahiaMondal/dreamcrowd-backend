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
   <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    

   {{-- =======Toastr CDN ======== --}}
   <link rel="stylesheet" type="text/css" 
   href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
   
   <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
   {{-- =======Toastr CDN ======== --}}
    <!-- Defualt css -->
    <link rel=" stylesheet " type=" text/css " href="assets/teacher/asset/css/class-management.css" />
    <link rel=" stylesheet " href="assets/teacher/asset/css/Learn-How.css">
    <link rel="stylesheet" href="assets/teacher/asset/css/sidebar.css">
    <link rel="stylesheet" href="assets/teacher/asset/css/style.css">
</head>


<style>

    .btn-next {
       border-radius: 4px;
       background: #0072b1;
       padding: 8px 28px;
       color: #fff;
       font-family: Roboto;
       font-size: 20px;
       font-weight: 500;
       line-height: normal;
   }
    .btn-back {
       border-radius: 4px;
       background: #fc5757;
       padding: 8px 28px;
       color: #fff;
       font-family: Roboto;
       font-size: 20px;
       font-weight: 500;
       line-height: normal;
   }
   
   .row .buttons-sec {
       --bs-gutter-x: 1.5rem;
       --bs-gutter-y: 0;
       flex-wrap: wrap;
       margin-top: calc(var(--bs-gutter-y)* -1);
       margin-right: calc(var(--bs-gutter-x)* -.5);
       margin-left: calc(var(--bs-gutter-x)* -.5);
   }
   </style>

<body>

      
  @if (Session::has('error'))
  <script>

        toastr.options =
          {
              "closeButton" : true,
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
              "closeButton" : true,
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
        <div class=" container-fluid ">
            <div class=" row dash-notification ">
                <div class=" col-md-12 ">
                    <nav style=" --bs-breadcrumb-divider: '>' ; " aria-label=" breadcrumb ">
                        <ol class=" breadcrumb mt-3 ">
                            <li class=" breadcrumb-item active " aria-current=" page ">Dashboard</li>
                            <li class=" breadcrumb-item ">Add New FAQ</li>
                        </ol>
                    </nav>
                    <div class=" class-Menagent-Heading ">
                        <i class="bx bxs-graduation icon" title="Class Management"></i>
                        <span>Add New FAQ</span>
                    </div>
                    <!-- Blue MASSEGES section -->
                    <form action="/teacher-upload-faq" method="POST"> @csrf
                    <div class="col-md-12 mb-3 add-category">
                        <label for="" class="label-sec pt-0">Question</label>
                        <input type="text" class="form-control" name="question" placeholder="How can you deliver my project to me?" required>
                          <label for="" class="label-sec">Answer</label>
                          <textarea  name="answer" id="" class="form-control" rows="5" cols="5" placeholder="write the answer here...."></textarea>
                          
                          <div class="row mt-2">
                            <div class="col-md-12">
                              <div class="buttons-sec">
                                <a href="/teacher-profile" class="btn btn-back float-start" onclick="BackTab(this.id)"   data-tab="7" id="tab_back_btn_7">
                                  Back
                                </a>
                                <button type="submit"     class="btn btn-next float-end">
                                  Add
                                </button>
                              </div>
                            </div>
                          </div>
                                              
                    </div>
                </form>
                </div>
            </div>
        </div>
        <!-- =============================== MAIN CONTENT END HERE =========================== -->
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
<script>
    // Sidebar script
  document.addEventListener("DOMContentLoaded", function() {
    let arrow = document.querySelectorAll(".arrow");
    for (let i = 0; i < arrow.length; i++) {
      arrow[i].addEventListener("click", function(e) {
        let arrowParent = e.target.parentElement.parentElement; // Selecting main parent of arrow
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
<!-- add experience radio -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const radio1 = document.getElementById('radio1');
        const radio3 = document.getElementById('radio3');
        const imageDiv = document.getElementById('imageDiv');
    
        function toggleImage() {
            if (radio3.checked) {
                imageDiv.style.display = 'none';
            } else {
                imageDiv.style.display = 'block';
            }
        }
    
        // Add event listeners to radio buttons
        radio1.addEventListener('change', toggleImage);
        radio3.addEventListener('change', toggleImage);
    
        // Initial check
        toggleImage();
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
<!-- ===================== multiselect script  ====================================== -->
<script>
    const chBoxes = document.querySelectorAll(".dropdown-menu .cat-input");
    const dpBtn = document.getElementById("multiSelectDropdown");
    let mySelectedListItems = [];
  
    function handleCB() {
      mySelectedListItems = [];
      let mySelectedListItemsText = "";
  
      chBoxes.forEach((checkbox) => {
        if (checkbox.checked) {
          mySelectedListItems.push(checkbox.value);
          mySelectedListItemsText += checkbox.value + ", ";
        }
      });
  
      dpBtn.innerText =
        mySelectedListItems.length > 0
          ? mySelectedListItemsText.slice(0, -2)
          : "Select";
    }
  
    chBoxes.forEach((checkbox) => {
      checkbox.addEventListener("change", handleCB);
    });
  </script>
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