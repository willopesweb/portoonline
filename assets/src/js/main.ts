import "../scss/style.scss";
import "@splidejs/splide/css/core";
import "@splidejs/splide/css";

import "./lazyload";
import "./form";
import "./comments";

const mobileButton: HTMLElement | null =
  document.getElementById("mobileButton");
const mainMenu: HTMLElement | null = document.getElementById("menu");

if (mobileButton && mainMenu) {
  mobileButton.addEventListener("click", () => {
    mainMenu.classList.toggle("is-open");
  });
}

const searchButton: HTMLElement | null =
  document.getElementById("searchButton");
const searchBar: HTMLElement | null = document.getElementById("search");

if (searchButton && searchBar) {
  searchButton.addEventListener("click", () => {
    searchBar.classList.toggle("is-visible");
  });
}

const subMenusMobile: NodeListOf<HTMLElement> | null =
  document.querySelectorAll(".menu-item-has-children");

if (subMenusMobile) {
  subMenusMobile.forEach((menu) => {
    menu.addEventListener("click", () => {
      menu.classList.toggle("is-submenu-open");
    });
  });
}
