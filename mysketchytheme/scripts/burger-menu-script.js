// https://codepen.io/osysolyatin/pen/BaOZqog
// https://codepen.io/chriiss/pen/qBJjLEx

window.addEventListener("load", function() {

    let menu = document.querySelector(".menu-menu-principal-container");
    let menuToggleBtn = document.querySelector("#menu_toggle-btn");
    let body = document.querySelector("body");
    let title = document.querySelector("#site-title");

    menuToggleBtn.addEventListener("click", ()=>{

        menu.classList.toggle("active");
        menuToggleBtn.classList.toggle("active");

        /* empêcher le scroll de l'arrière-plan*/
        //body.classList.toggle("no-scroll");
        title.classList.toggle("on-top-of-drawer-menu");
    })
});



