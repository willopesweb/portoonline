import Splide from "@splidejs/splide";

window.addEventListener("DOMContentLoaded", () => {
  if (document.querySelector(".js-main-carousel")) {
    const mainCarousel = new Splide(".js-main-carousel", {
      arrows: false,
      type: "loop",
      perPage: 1,
      keyboard: true,
      autoplay: true,
      interval: 3000,
      easing: "cubic-bezier(0.25, 1, 0.5, 1)",
    });
    mainCarousel.mount();
  }

  if (document.querySelector(".js-header-carousel")) {
    const headerCarousel = new Splide(".js-header-carousel", {
      arrows: false,
      type: "loop",
      perPage: 1,
      keyboard: true,
      autoplay: true,
      interval: 5000,
      easing: "cubic-bezier(0.25, 1, 0.5, 1)",
    });
    headerCarousel.mount();
  }

  if (document.querySelector(".js-news-carousel")) {
    const newsCarousel = new Splide(".js-news-carousel", {
      arrows: false,
      type: "loop",
      perPage: 1,
      keyboard: true,
      autoplay: true,
      breakpoints: {
        599: {
          destroy: true,
        },
      }
    });

    newsCarousel.mount();
  }
});
