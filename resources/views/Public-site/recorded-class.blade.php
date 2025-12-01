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
              @if(!empty($course) && isset($course[0]))
              <video style="height: 500px;"
                src="assets/teacher/listing/data_{{$gig->user_id}}/course/{{$course[0]}}"
                controls
                autoplay
                muted
              ></video>
              <h5 class="title">{{$course[0]}}</h5>
              @else
              <div style="height: 500px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                <div class="text-center">
                  <i class="fas fa-video fa-4x text-muted mb-3"></i>
                  <p class="text-muted">No course video available</p>
                </div>
              </div>
              @endif
              <h3>{{$gig->title}}</h3>
              <div class="design">
                <span id="mydesign">
                  @if($profile)
                    {{$profile->first_name}} {{$profile->last_name}}&nbsp;&nbsp;
                  @elseif($gig->user)
                    {{$gig->user->first_name}} {{$gig->user->last_name}}&nbsp;&nbsp;
                  @else
                    Unknown Instructor&nbsp;&nbsp;
                  @endif
                </span>
                <span>
                  @if($profile && $profile->profession)
                    {{$profile->profession}}
                  @else
                    Instructor
                  @endif
                </span>
                <span id="file">&nbsp;&nbsp;Following</span>
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
              <h4>Student Reviews ({{ $totalReviews }})
                @if($totalReviews > 0 && $averageRating)
                  <span class="text-warning ms-2">
                    ★ {{ number_format((float)$averageRating, 1) }}
                  </span>
                @endif
              </h4>
            </div>
            <div class="row card_wrapper" style="margin-top: 80px">
              <div class="col-12">
                @if($reviews->count() > 0)
                <div class="owl-carousel card_carousel">
                @foreach($reviews as $review)
                  <div class="card card-slider">
                    <div class="card-body">
                      <div class="d-flex">
                        @if($review->user && $review->user->profile && file_exists(public_path($review->user->profile)))
                          <img src="/{{ $review->user->profile }}"
                               class="rounded-circle"
                               style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                          <div class="rounded-circle review-profile"
                               style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background-color: #f0f0f0;">
                            <h3 style="margin: 0;">{{ $review->user ? substr($review->user->first_name, 0, 1) : 'U' }}</h3>
                          </div>
                        @endif
                        <div class="d-flex flex-column ms-3">
                          <div class="name">
                            {{ $review->user ? trim($review->user->first_name . ' ' . $review->user->last_name) : 'Anonymous' }}
                          </div>
                          <p class="text-muted">Student</p>
                          <div class="rating">
                            @for($i = 1; $i <= 5; $i++)
                              @if($i <= $review->rating)
                                <i class="fas fa-star text-warning"></i>
                              @else
                                <i class="far fa-star text-muted"></i>
                              @endif
                            @endfor
                          </div>
                        </div>
                      </div>
                      <p class="card-text mt-3">
                        {{ $review->cmnt ?? 'No comment provided.' }}
                      </p>
                      <small class="text-muted">
                        {{ $review->created_at->diffForHumans() }}
                      </small>
                    </div>
                  </div>
                @endforeach
                </div>
                @else
                <div class="alert alert-info mt-3">
                  <i class="fas fa-info-circle"></i> No reviews yet. Be the first to review this service!
                </div>
                @endif
              </div>
              </div>

            <!-- Service Statistics Section -->
            <div class="row mt-4">
              <div class="col-md-12">
                <div class="service-stats">
                  <span class="badge bg-primary me-2">
                    <i class="fas fa-eye"></i> {{ number_format((int)$gig->impressions) }} Views
                  </span>
                  <span class="badge bg-success me-2">
                    <i class="fas fa-shopping-bag"></i> {{ number_format((int)$gig->orders) }} Orders
                  </span>
                  <span class="badge bg-info me-2">
                    <i class="fas fa-star"></i> {{ number_format((int)$gig->reviews) }} Reviews
                  </span>
                  @if($gig->clicks)
                    <span class="badge bg-warning me-2">
                      <i class="fas fa-mouse-pointer"></i> {{ number_format((int)$gig->clicks) }} Clicks
                    </span>
                  @endif
                </div>
              </div>
            </div>

            <!-- Pricing Section -->
            @if($gigPayment)
            <div class="row mt-4">
              <div class="col-md-12">
                <div class="heading-start">
                  <h4>Pricing</h4>
                </div>
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      @if($gigPayment->payment_type)
                        <div class="col-md-4">
                          <p><strong>Payment Type:</strong> {{ ucfirst($gigPayment->payment_type) }}</p>
                        </div>
                      @endif
                      @if($gigPayment->rate)
                        <div class="col-md-4">
                          <p><strong>Standard Rate:</strong> @currency($gigPayment->rate)</p>
                        </div>
                      @endif
                      @if($gigPayment->public_rate)
                        <div class="col-md-4">
                          <p><strong>Group Rate:</strong> @currency($gigPayment->public_rate)</p>
                        </div>
                      @endif
                      @if($gigPayment->private_rate)
                        <div class="col-md-4">
                          <p><strong>Private Rate:</strong> @currency($gigPayment->private_rate)</p>
                        </div>
                      @endif
                      @if($gigPayment->duration)
                        <div class="col-md-4">
                          <p><strong>Duration:</strong> {{ $gigPayment->duration }} minutes</p>
                        </div>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif

            <!-- Similar Services Section -->
            @if($similarServices->count() > 0)
            <div class="row mt-5">
              <div class="col-md-12">
                <div class="heading-start">
                  <h4>Similar Services</h4>
                </div>
              </div>
            </div>
            <div class="row mt-3">
              @foreach($similarServices as $similar)
                <div class="col-md-3 mb-3">
                  <div class="card h-100">
                    @if($similar->main_file && file_exists(public_path($similar->main_file)))
                      <img src="/{{ $similar->main_file }}"
                           class="card-img-top"
                           alt="{{ $similar->title }}"
                           style="height: 200px; object-fit: cover;">
                    @else
                      <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                           style="height: 200px;">
                        <i class="fas fa-image fa-3x text-muted"></i>
                      </div>
                    @endif
                    <div class="card-body">
                      <h5 class="card-title">{{ Str::limit($similar->title, 40) }}</h5>
                      <p class="card-text text-muted">
                        @if($similar->user)
                          <i class="fas fa-user"></i> {{ trim($similar->user->first_name . ' ' . $similar->user->last_name) }}
                        @endif
                      </p>
                      @if($similar->all_reviews_avg_rating)
                        <p class="card-text">
                          <span class="text-warning">
                            ★ {{ number_format((float)$similar->all_reviews_avg_rating, 1) }}
                          </span>
                          <small class="text-muted">({{ $similar->all_reviews_count }} reviews)</small>
                        </p>
                      @endif
                      <a href="/course-service/{{ $similar->id }}" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-eye"></i> View Details
                      </a>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
            @endif

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
