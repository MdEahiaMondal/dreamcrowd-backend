// ================ COUNTER JS START HERE
$(".counter-count").each(function () {
  $(this)
    .prop("Counter", 0)
    .animate(
      {
        Counter: $(this).text(),
      },
      {
        //chnage count up speed here
        duration: 4000,
        easing: "swing",
        step: function (now) {
          $(this).text(Math.ceil(now));
        },
      }
    );
});
// ================ COUNTER JS END HERE
// ================ REVIEWS CRADS START HERE
function card_carouselInit() {
  $(".owl-carousel.card_carousel").owlCarousel({
    dots: false,
    loop: true,
    margin: 20,
    stagePadding: 2,
    autoplay: true,
    autoplayTimeout: 1500,
    nav: true,
    navText: [
      "<i class='fa-solid fa-angle-left'></i>",
      "<i class='fa-solid fa-chevron-right'></i> ",
    ],
    autoplayHoverPause: true,
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 1,
      },
      992: {
        items: 2,
      },
    },
  });
}
card_carouselInit();
// ================ REVIEWS CRADS END HERE
// ================ HIDE AND SHOW PASSWORD START HERE
// 1
$(".toggle-password").click(function () {
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
// 2
$(".toggle-password1").click(function () {
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
// 3
$(".toggle-password2").click(function () {
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
// ================ HIDE AND SHOW PASSWORD END HERE
// ================ FOOTER SELECT START HERE
function formatText(icon) {
  return $(
    '<span><i class="fas ' +
      $(icon.element).data("icon") +
      '"></i> ' +
      icon.text +
      "</span>"
  );
}
$(".select2-icon").select2({
  width: "100%",
  templateSelection: formatText,
  templateResult: formatText,
});
// ================ FOOTER SELECT END HERE
// ================ PAYMENT INPUT ICON START HERE
function formatText(icon) {
  return $(
    '<span><i class="fas ' +
      $(icon.element).data("icon") +
      '"></i> ' +
      icon.text +
      "</span>"
  );
}
$(".select2-icon").select2({
  width: "100%",
  templateSelection: formatText,
  templateResult: formatText,
});
// ================ PAYMENT INPUT ICON END HERE
// ================ RECORDED VEDIO START HERE
const main_video = document.querySelector(".main-video video");
const main_video_title = document.querySelector(".main-video .title");
const video_playlist = document.querySelector(".video-playlist .videos");

let data = [
  {
    id: "a1",
    title: "Introduction to Logo Design",
    name: "Introduction to Logo Design.mp4",
    duration: "2:47",
  },
  {
    id: "a2",
    title: "Design Fundamentals for Logos",
    name: "Design Fundamentals for Logos.mp4",
    duration: "2:45",
  },
  {
    id: "a3",
    title: "Understanding Brand Identity",
    name: "Understanding Brand Identity.mp4",
    duration: "24:49",
  },

  {
    id: "a4",
    title: "Logo Design Process",
    name: "Logo Design Process.mp4",
    duration: "3:59",
  },
  {
    id: "a5",
    title: "Logo Types and Styles",
    name: "Logo Types and Styles.mp4",
    duration: "4:25",
  },
  {
    id: "a6",
    title: "Creating Memorable Logos",
    name: "Creating Memorable Logos.mp4",
    duration: "5:33",
  },
  {
    id: "a7",
    title: "Color Psychology in Logo Design",
    name: "Color Psychology in Logo Design.mp4",
    duration: "0:29",
  },

  {
    id: "a8",
    title: "Typography in Logo Design",
    name: "Typography in Logo Design.mp4",
    duration: "1:12",
  },
];

data.forEach((video, i) => {
  let video_element = `
        <div class="video" data-id="${video.id}">
            <img src="images/play.svg" alt="">
            <p>${i + 1 > 9 ? i + 1 : +(i + 1)}. </p>
            <h3 class="title">${video.title}</h3>
            <p class="time">${video.duration}</p>
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
// ================ SERVICES SLIDER START HERE

// ================ SERVICES SLIDER END HERE
// ===========tooltip=======
$(document).ready(function () {
  $('[data-toggle="tooltip"]').tooltip();
});
