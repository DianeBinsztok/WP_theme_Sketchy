window.addEventListener("load", function() {
    let subMenuParent = document.querySelector(".menu-item-164");
    let subMenuParentLink = document.querySelector(".menu-item-164 a");
    let subMenu = document.querySelector(".sub-menu");
    /* Cacher le sous-menu */
    subMenu.classList.add("closed");

    let svgColor;
    /* Pour les versions mobile : menu en blanc sur fond noir */
    if(window.innerWidth<=660){
        svgColor = "white";

    /* Pour les versions desktop : menu en noir sur fond beige */
    }else{
        svgColor = "black";
    }
    let arrowSVG = document.createElement("span");
    arrowSVG.id="sub-menu-indicator";

    /* Le contenu du svg */
    arrowSVG.innerHTML = `<svg width="14" height="7" viewBox="0 0 14 7" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.37 0.390029L7.00003 4.71003L1.64003 0.230028C1.53891 0.145982 1.42223 0.0826764 1.29665 0.0437242C1.17106 0.0047719 1.03904 -0.00906363 0.908105 0.00300799C0.777174 0.0150796 0.649903 0.0528219 0.533559 0.11408C0.417214 0.175337 0.314075 0.258911 0.230029 0.360028C0.145983 0.461146 0.0826764 0.577828 0.0437242 0.703412C0.0047719 0.828996 -0.00906363 0.961022 0.00300799 1.09195C0.0150796 1.22288 0.0528219 1.35015 0.11408 1.4665C0.175337 1.58284 0.258911 1.68598 0.360029 1.77003L6.36003 6.77003C6.53896 6.91711 6.7634 6.99752 6.99503 6.99752C7.22665 6.99752 7.4511 6.91711 7.63003 6.77003L13.63 1.94003C13.7328 1.85751 13.8182 1.75549 13.8813 1.63986C13.9445 1.52422 13.9842 1.39724 13.9981 1.26621C14.0121 1.13518 14 1.00269 13.9626 0.876351C13.9251 0.750012 13.8631 0.632316 13.78 0.530028C13.6968 0.428038 13.5942 0.343487 13.4782 0.281226C13.3622 0.218965 13.2351 0.18022 13.1041 0.167213C12.9731 0.154205 12.8408 0.167193 12.7148 0.205429C12.5889 0.243665 12.4717 0.306399 12.37 0.390029Z" fill="${svgColor}"/></svg>`;

    /* Insérer après le lien de l'onglet, juste avant le sous-menu */
    subMenuParent.insertBefore(arrowSVG, subMenu);

    /* Encapsuler le lien et le svg dans une div pour les placer en ligne */
    let menuItemAndArrowContainer = document.createElement("div"); 
    menuItemAndArrowContainer.id = ("item-arrow_container");  
    menuItemAndArrowContainer.appendChild(subMenuParentLink);
    menuItemAndArrowContainer.appendChild(arrowSVG); 
    subMenuParent.insertAdjacentElement("afterbegin", menuItemAndArrowContainer);

    console.log(subMenuParent);
    arrowSVG.addEventListener("click", ()=>{
        subMenu.classList.toggle("closed");

        /* Pour tourner le svg quand le sous-menu est ouvert */
        arrowSVG.classList.toggle("opened");
        console.log(subMenuParent);
    })

    
});