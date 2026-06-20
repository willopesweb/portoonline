export function createNotification(
  message: string,
  type: "success" | "warning" | "error"
) {
  const notificationElement = document.createElement("div");
  notificationElement.className = `c-notification c-notification--float ${type}`;
  notificationElement.innerHTML = `<p>${message}</p>`;

  setTimeout(() => {
    notificationElement.classList.add("is-visible");
  }, 300);

  setTimeout(() => {
    removeNotification(notificationElement);
  }, 5000); // Remover após 5 segundos

  notificationElement.onclick = function () {
    removeNotification(notificationElement);
  };

  document.body.appendChild(notificationElement);
}

function removeNotification(element: HTMLElement) {
  element.classList.remove("is-visible");

  setTimeout(() => {
    document.body.removeChild(element);
  }, 300);
}
