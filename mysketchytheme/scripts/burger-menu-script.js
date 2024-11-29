// https://codepen.io/osysolyatin/pen/BaOZqog
// https://codepen.io/chriiss/pen/qBJjLEx

window.addEventListener("load", function() {

    let menu = document.querySelector(".menu-menu-principal-container");
    let menuToggleBtn = document.querySelector("#menu_toggle-btn");
    let header = document.querySelector("header");
    let title = document.querySelector("#site-title");

    menuToggleBtn.addEventListener("click", ()=>{

        menu.classList.toggle("active");
        menuToggleBtn.classList.toggle("active");
        title.classList.toggle("on-top-of-drawer-menu");
        header.classList.toggle("on-top-of-drawer-menu");
    })
});



