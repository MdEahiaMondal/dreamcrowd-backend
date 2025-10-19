<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="/public">
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <!-- View Point scale to 1.0 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Animate css -->
    <link rel="stylesheet" href="assets/public-site/libs/animate/css/animate.css" />
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="assets/public-site/libs/aos/css/aos.css" />
    <!-- Datatable css  -->
    <link rel="stylesheet" href="assets/public-site/libs/datatable/css/datatable.css" />
     {{-- Fav Icon --}}
     @php  $home = \App\Models\HomeDynamic::first(); @endphp
     @if ($home)
         <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
     @endif
     <!-- Select2 css -->
    <link href="assets/public-site/libs/select2/css/select2.min.css" rel="stylesheet" />
    <!-- Owl carousel css -->
    <link href="assets/public-site/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
    <link href="assets/public-site/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
    <!-- Bootstrap css -->
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/public-site/asset/css/bootstrap.min.css"
    />
    <link
      href="assets/public-site/asset/css/fontawesome.min.css"
      rel="stylesheet"
      type="text/css"
    />
    <script
      src="https://kit.fontawesome.com/be69b59144.js"
      crossorigin="anonymous"
    ></script>
    <link
      href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.2.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>

    <!-- Defualt css -->
    <link rel="stylesheet" type="text/css" href="assets/public-site/asset/css/style.css" />
    <link rel="stylesheet" href="assets/public-site/asset/css/navbar.css" />
    <link rel="stylesheet" href="assets/public-site/asset/css/Drop.css" />
    <title>DreamCrowd | Recorded Class</title>
  </head>

  <body>
    <!-- =========================================== NAVBAR START HERE ================================================= -->
    <x-public-nav/>

    <!-- ============================================= NAVBAR END HERE ============================================ -->
    <div class="container-fluid">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-12">
            <section class="main-video">
              <video style="height: 500px;"
                src="assets/teacher/listing/data_{{$gig->user_id}}/course/{{$course[0]}}"
                controls
                autoplay
                muted
              ></video>
              <h5 class="title">{{$course[0]}}</h5>
              <h3>{{$gig->title}}</h3>
              <div class="design">
                <span id="mydesign">{{$profile->first_name}} {{$profile->last_name}}&nbsp;&nbsp;</span
                ><span>{{$profile->profession}}</span
                ><span id="file">&nbsp;&nbsp;Following</span>
              </div>
            </section>
          </div>
          <div class="col-lg-4 col-md-12">
            <div class="video-playlist-sec">
              <div class="title">
                {{-- <p>12 Lessons <span>(1h 20m)</span></p> --}}
              </div>
            </div>
            <div class="video-playlist">
              <div class="videos">
                {{-- @if ($course)
                @php $i = 0 ; @endphp

                @foreach ($course as $item)

                <div class="video active" data-id="a{{$i}}">
                  <img src="assets/teacher/listing/data_{{$gig->user_id}}/course/{{$item}}" alt="">
                  <p>{{$i}}. </p>
                  <h3 class="title">{{$item}}</h3> 
              </div>
                    
                @endforeach
                    
                @endif --}}
              </div>
            </div>
          </div>
        </div>

        <div class="row description">
          <div class="col-md-12">
            <div class="heading-start">
              <h4>About This Class</h4>
            </div>
            <!-- text -->
            <div class="start-paragraph">
              <p>{{$gigData->description}}</p>
               
            </div>
            <div class="Requirements-heading">
              <h4>Requirements</h4>
            </div>
            <div class="Requirements-paragraph">
              <div class="courses">
                <p>{{$gigData->requirements}}</p>
              </div>
            </div>
            <div class="Resources-heading">
              <h4>Resources</h4>
            </div>
            <div class="Resources-paragraph">
              <div class="courses">
                <ol>
                @if ($resource)
                @foreach ($resource as $item)
                <a href="assets/teacher/listing/data_{{$gig->user_id}}/course/{{$item}}">
                  <li>{{$item}}</li>
                </a>
                    
                @endforeach
                @endif
              </ol>
            
              </div>
            </div>
            <div class="Student-Reviews-heading">
              <h4>Student Reviews</h4>
            </div>
            <div class="row card_wrapper" style="margin-top: 80px">
              <div class="col-12">
                <div class="owl-carousel card_carousel">
                  <div class="card card-slider">
                    <div class="card-body">
                      <div class="d-flex">
                        <img
                          src="assets/public-site/asset/img/slidercommentimg1.png"
                          class="rounded-circle"
                        />
                        <div class="d-flex flex-column">
                          <div class="name">Thomas H.</div>
                          <p class="text-muted">Student</p>
                        </div>
                      </div>
                      <p class="card-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Amet sollicitudin tristique ac praesent ullamcorper nisl
                        eu accumsan.Lorem ipsum dolor sit amet, consectetur
                        adipiscing elit. Amet sollicitudin tristique ac praesent
                        ullamcorper nisl eu accumsan.
                      </p>
                    </div>
                  </div>
                  <div class="card card-slider">
                    <div class="card-body">
                      <div class="d-flex">
                        <div class="rounded-circle review-profile">
                          <h3>T</h3>
                      </div>
                        <div class="d-flex flex-column">
                          <div class="name">Thomas H.</div>
                          <p class="text-muted">Student</p>
                        </div>
                      </div>
                      <p class="card-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Amet sollicitudin tristique ac praesent ullamcorper nisl
                        eu accumsan.Lorem ipsum dolor sit amet, consectetur
                        adipiscing elit. Amet sollicitudin tristique ac praesent
                        ullamcorper nisl eu accumsan.
                      </p>
                    </div>
                  </div>
                  <div class="card card-slider">
                    <div class="card-body">
                      <div class="d-flex">
                        <img
                          src="assets/public-site/asset/img/slidercommentimg1.png"
                          class="rounded-circle"
                        />
                        <div class="d-flex flex-column">
                          <div class="name">Thomas H.</div>
                          <p class="text-muted">Student</p>
                        </div>
                      </div>
                      <p class="card-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Amet sollicitudin tristique ac praesent ullamcorper nisl
                        eu accumsan.Lorem ipsum dolor sit amet, consectetur
                        adipiscing elit. Amet sollicitudin tristique ac praesent
                        ullamcorper nisl eu accumsan.
                      </p>
                    </div>
                  </div>
                  <div class="card card-slider">
                    <div class="card-body">
                      <div class="d-flex">
                        <img src="assets/public-site/asset/img/IMG1.png" class="rounded-circle" />
                        <div class="d-flex flex-column">
                          <div class="name">Thomas H.</div>
                          <p class="text-muted">Student</p>
                        </div>
                      </div>
                      <p class="card-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Amet sollicitudin tristique ac praesent ullamcorper nisl
                        eu accumsan.Lorem ipsum dolor sit amet, consectetur
                        adipiscing elit. Amet sollicitudin tristique ac praesent
                        ullamcorper nisl eu accumsan.
                      </p>
                    </div>
                  </div>
                  <div class="card card-slider">
                    <div class="card-body">
                      <div class="d-flex">
                        <img
                          src="assets/public-site/asset/img/slidercommentimg1.png"
                          class="rounded-circle"
                        />
                        <div class="d-flex flex-column">
                          <div class="name">Thomas H.</div>
                          <p class="text-muted">Student</p>
                        </div>
                      </div>
                      <p class="card-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Amet sollicitudin tristique ac praesent ullamcorper nisl
                        eu accumsan.Lorem ipsum dolor sit amet, consectetur
                        adipiscing elit. Amet sollicitudin tristique ac praesent
                        ullamcorper nisl eu accumsan.
                      </p>
                    </div>
                  </div>
                  <div class="card card-slider">
                    <div class="card-body">
                      <div class="d-flex">
                        <img src="assets/public-site/asset/img/IMG1.png" class="rounded-circle" />
                        <div class="d-flex flex-column">
                          <div class="name">Thomas H.</div>
                          <p class="text-muted">Student</p>
                        </div>
                      </div>
                      <p class="card-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Amet sollicitudin tristique ac praesent ullamcorper nisl
                        eu accumsan.Lorem ipsum dolor sit amet, consectetur
                        adipiscing elit. Amet sollicitudin tristique ac praesent
                        ullamcorper nisl eu accumsan.
                      </p>
                    </div>
                  </div>
                  <div class="card card-slider">
                    <div class="card-body">
                      <div class="d-flex">
                        <img
                          src="assets/public-site/asset/img/slidercommentimg1.png"
                          class="rounded-circle"
                        />
                        <div class="d-flex flex-column">
                          <div class="name">Thomas H.</div>
                          <p class="text-muted">Student</p>
                        </div>
                      </div>
                      <p class="card-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Amet sollicitudin tristique ac praesent ullamcorper nisl
                        eu accumsan.Lorem ipsum dolor sit amet, consectetur
                        adipiscing elit. Amet sollicitudin tristique ac praesent
                        ullamcorper nisl eu accumsan.
                      </p>
                    </div>
                  </div>
                  <div class="card card-slider">
                    <div class="card-body">
                      <div class="d-flex">
                        <img src="assets/public-site/asset/img/IMG1.png" class="rounded-circle" />
                        <div class="d-flex flex-column">
                          <div class="name">Thomas H.</div>
                          <p class="text-muted">Student</p>
                        </div>
                      </div>
                      <p class="card-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Amet sollicitudin tristique ac praesent ullamcorper nisl
                        eu accumsan.Lorem ipsum dolor sit amet, consectetur
                        adipiscing elit. Amet sollicitudin tristique ac praesent
                        ullamcorper nisl eu accumsan.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ============================= FOOTER SECTION START HERE ===================================== -->
    <x-public-footer/>
    <!-- =============================== FOOTER SECTION END HERE ===================================== -->

    <script src="assets/public-site/libs/jquery/jquery.js"></script>
    <script src="assets/public-site/libs/datatable/js/datatable.js"></script>
    <script src="assets/public-site/libs/datatable/js/datatablebootstrap.js"></script>
    <script src="assets/public-site/libs/select2/js/select2.min.js"></script>
    <!-- <script src="assets/public-site/libs/owl-carousel/js/jquery.min.js"></script> -->
    <script src="assets/public-site/libs/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="assets/public-site/libs/aos/js/aos.js"></script>
    <script src="assets/public-site/asset/js/bootstrap.min.js"></script>
    <script src="assets/public-site/asset/js/script.js"></script>
  
  <script>

    // ================ RECORDED VEDIO START HERE
const main_video = document.querySelector(".main-video video");
const main_video_title = document.querySelector(".main-video .title");
const video_playlist = document.querySelector(".video-playlist .videos");
    var course = '<?php echo $gigData->course ?>' ;
    console.log(course);
    course = course.split(',_,');
    
      let data = [];
      for (let i = 0; i < course.length; i++) {
  const element = course[i];
  data.push({
    id: "a" + (i + 2), // Start from "a2" to match your example
    title: element,
    name: `${element}`,
    // duration: "0:00" // Default duration, you can update this later
  });
}

data.forEach((video, i) => {
  let video_element = `
        <div class="video" data-id="${video.id}">
            <img src="images/play.svg" alt="">
            <p>${i + 1 > 9 ? i + 1 : +(i + 1)}. </p>
            <h3 class="title">${video.title}</h3> 
        </div>
`;
  video_playlist.innerHTML += video_element;
});

let videos = document.querySelectorAll(".video");
videos[0].classList.add("active");
videos[0].querySelector("img").src = "images/pause.svg";

videos.forEach((selected_video) => {
  selected_video.onclick = () => {
    for (all_videos of videos) {
      all_videos.classList.remove("active");
      all_videos.querySelector("img").src = "images/play.svg";
    }

    selected_video.classList.add("active");
    selected_video.querySelector("img").src = "images/pause.svg";

    let match_video = data.find(
      (video) => video.id == selected_video.dataset.id
    );
    main_video.src = "videos/" + match_video.name;
    main_video_title.innerHTML = match_video.title;
  };
});
// ================ RECORDED VEDIO END HERE

  </script>
  
  </body>
</html>
