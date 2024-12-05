function getYouTubeVideoId(url: string): string | null {
  try {
    const parsedUrl = new URL(url);
    // Verifica se o hostname corresponde ao YouTube
    if (parsedUrl.hostname === 'www.youtube.com' || parsedUrl.hostname === 'youtube.com') {
      return parsedUrl.searchParams.get('v'); // Retorna o parâmetro 'v' (ID do vídeo)
    }
    // Suporte para URLs encurtadas do YouTube (youtu.be)
    if (parsedUrl.hostname === 'youtu.be') {
      return parsedUrl.pathname.slice(1); // Retorna o caminho sem a barra inicial
    }
  } catch (error) {
    console.error("Invalid URL", error);
  }
  return null; // Retorna null se não for uma URL válida ou não conter um ID
}

document.addEventListener("DOMContentLoaded", function () {
  let lazyloadImages: NodeListOf<HTMLImageElement>;

  if ("IntersectionObserver" in window && typeof document !== "undefined") {
    lazyloadImages = document.querySelectorAll(".lazy");
    const imageObserver = new IntersectionObserver(function (
      entries,
      observer
    ) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          const image = entry.target as HTMLImageElement;
          image.src = image.dataset.src!;
          imageObserver.unobserve(image);
        }
      });
    });

    lazyloadImages.forEach(function (image) {
      imageObserver.observe(image);
    });
  } else {
    let lazyloadThrottleTimeout: NodeJS.Timeout;
    lazyloadImages = document?.querySelectorAll(".lazy") || [];

    function lazyload() {
      if (lazyloadThrottleTimeout) {
        clearTimeout(lazyloadThrottleTimeout);
      }

      lazyloadThrottleTimeout = setTimeout(function () {
        const scrollTop = window.scrollY;
        lazyloadImages.forEach(function (img) {
          if (img.offsetTop < window.innerHeight + scrollTop) {
            img.src = img.dataset.src!;
            //img.classList.remove("lazy");
          }
        });
        if (lazyloadImages.length == 0) {
          document?.removeEventListener("scroll", lazyload);
          window.removeEventListener("resize", lazyload);
          window.removeEventListener("orientationchange", lazyload);
        }
      }, 20);
    }

    document?.addEventListener("scroll", lazyload);
    window.addEventListener("resize", lazyload);
    window.addEventListener("orientationchange", lazyload);
  }
});

document.addEventListener("DOMContentLoaded", () => {
  const videoContainers = document.querySelectorAll(
    ".js-lazy-iframe-video"
  );
  if (!videoContainers || videoContainers.length === 0) return;
  videoContainers.forEach((container: Element) => {
    const videoId = container.getAttribute("data-video-id");
    const youtubeId = videoId ? getYouTubeVideoId(videoId) : null;
    console.log(videoId);
    console.log(youtubeId);
    if (youtubeId) {
      const iframe = document.createElement("iframe");
      iframe.setAttribute("src", `https://www.youtube.com/embed/${youtubeId}`);
      iframe.setAttribute("frameborder", "0");
      iframe.setAttribute("allowfullscreen", "");
      container.appendChild(iframe);
    }
  });
});
