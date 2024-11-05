const links = document.querySelectorAll(".my-link");
const contents = document.querySelectorAll(".catalog-menu-right");

const buttonAccount = document.querySelectorAll(".js-account");
const modal = document.querySelector(".js-modal");
const modalClose = document.querySelector(".js-close");

var dangKy = document.getElementById("login");
var dangNhap = document.getElementById("register");
var button = document.getElementById("btn");
var loginButton = document.getElementById("loginButton");
var registerButton = document.getElementById("registerButton");

const dangNhapMobile = document.querySelectorAll(".login-mobile");
const dangKyMobile = document.querySelectorAll(".register-mobile");

const menu = document.querySelector(".menu-options-m");
const menuOpen = document.querySelector(".menu-overlay");
const backHome = document.querySelector(".arrow-js");

const linktb = document.querySelectorAll(".list-choice-category");
const contentstb = document.querySelectorAll(".row-container-content-items");

const mediaQuery = window.matchMedia("(max-width: 1150px)");

const faqs = document.querySelectorAll(".col-faq-content");

var counter = 1;

// PC
links.forEach((link) => {
  link.addEventListener("mouseover", () => {
    const target = link.dataset.target;
    contents.forEach((content) => {
      if (content.classList.contains(target)) {
        content.classList.add("active");
      } else {
        content.classList.remove("active");
      }
    });
  });
});

//Mobile
linktb.forEach((link) => {
  link.addEventListener("click", () => {
    const target = link.dataset.target;
    contentstb.forEach((content) => {
      if (content.classList.contains(target)) {
        content.classList.add("active-tb");
      } else {
        content.classList.remove("active-tb");
      }
    });
  });
});

linktb.forEach((homeProduct) => {
  homeProduct.addEventListener("click", function () {
    linktb.forEach((otherHomeProduct) => {
      if (otherHomeProduct !== homeProduct) {
        otherHomeProduct.classList.remove("active-menu");
      }
    });

    homeProduct.classList.add("active-menu");
  });
});

// Animation form login & register
var screenWidth = window.innerWidth;
function register() {
  if (screenWidth < 399) {
    dangKy.style.left = "-400px";
    dangNhap.style.left = "26px";
    button.style.left = "130px";
    loginButton.classList.remove("active-form");
    registerButton.classList.add("active-form");
  } else {
    dangKy.style.left = "-400px";
    dangNhap.style.left = "50px";
    button.style.left = "130px";
    loginButton.classList.remove("active-form");
    registerButton.classList.add("active-form");
  }
}

function login() {
  if (screenWidth < 399) {
    dangKy.style.left = "26px";
    dangNhap.style.left = "450px";
    button.style.left = "0";
    loginButton.classList.add("active-form");
    registerButton.classList.remove("active-form");
  } else {
    dangKy.style.left = "50px";
    dangNhap.style.left = "450px";
    button.style.left = "0";
    loginButton.classList.add("active-form");
    registerButton.classList.remove("active-form");
  }
}

// Button open form login & register
function showFormLogin() {
  modal.classList.add("open");
}

function hiddenFormLogin() {
  modal.classList.remove("open");
}

for (const btnAccounts of buttonAccount) {
  btnAccounts.addEventListener("click", showFormLogin);
}

modalClose.addEventListener("click", hiddenFormLogin);

// automaic slider
setInterval(function () {
  document.getElementById("radio" + counter).checked = true;
  counter++;
  if (counter > 3) {
    counter = 1;
  }
}, 5600);

// loading web
var loader = document.getElementById("loading");
window.addEventListener("load", function () {
  loader.classList.add("loading-hidden");

  loader.addEventListener("transitionend", () => {
    if (document.body.contains(loader)) {
      document.body.removeChild(loader);
    }
  });
});

function showMenu() {
  menuOpen.classList.add("openmenu-t-b");
}

function hiddenMenu() {
  menuOpen.classList.remove("openmenu-t-b");
}

menu.addEventListener("click", showMenu);

backHome.addEventListener("click", hiddenMenu);

//faq
faqs.forEach((faq) => {
  faq.addEventListener("click", () => {
    faq.classList.toggle("active-faq");
  });
});
