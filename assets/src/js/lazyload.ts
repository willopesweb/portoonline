// O lazy-load das imagens é feito pelo navegador (atributo loading="lazy"
// gerado por theme_image() no PHP). Aqui fica só o carregamento dos vídeos.

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

document.addEventListener("DOMContentLoaded", () => {
  const videoContainers = document.querySelectorAll(
    ".js-lazy-iframe-video"
  );
  if (!videoContainers || videoContainers.length === 0) return;
  videoContainers.forEach((container: Element) => {
    const videoId = container.getAttribute("data-video-id");
    const youtubeId = videoId ? getYouTubeVideoId(videoId) : null;
    if (youtubeId) {
      const iframe = document.createElement("iframe");
      iframe.setAttribute("src", `https://www.youtube.com/embed/${youtubeId}`);
      iframe.setAttribute("loading", "lazy");
      iframe.setAttribute("frameborder", "0");
      iframe.setAttribute("allowfullscreen", "");
      container.appendChild(iframe);
    }
  });
});
