window.addEventListener("load", function() {

    let header = document.querySelector("header");
    let menuZone = document.querySelector("#menu-zone");
    let title = document.querySelector("#site-title");

    /* I - AU CHARGEMENT DE LA PAGE : CENTRER LE TITRE */

    // Verticalement : la moitié de la hauteur du header, en retranchant la moitié de la hauteur de titre
    let verticalTranslationToCenter = (header.offsetHeight-title.offsetHeight)/2;

    // Horizontalement : la moitié de la largeur du header, en retranchant la moitié de la largeur de titre
    let horizontalTranslationToCenter = (menuZone.offsetWidth-title.offsetWidth)/2;

    /* 1 - Sur desktop : translation verticale et horizontale (car la zone est en justify-content:space-between et le titre est à gauche)*/
    if(getComputedStyle(document.querySelector("#title-menu_container")).justifyContent == "space-between"){
        title.style.transform = `translate(${horizontalTranslationToCenter}px, -${verticalTranslationToCenter}px)`;
    }
    /* 2 - Sur mobile : translation verticale uniquement (car la zone est en justify-content:center et le titre est déjà centré)*/
    else{
        title.style.transform = `translateY( -${verticalTranslationToCenter}px)`;
    }

    // Stocker la dernière position du scroll pour détecter un scroll vers le bas ou vers le haut
    let lastScrollPosition = 0; 



    // II - AU SCROLL
    window.addEventListener("scroll", function () {        

        // Position actuelle du scroll
        let currentScrollPosition = window.scrollY; 

        // II.1 - AU SCROLL VERS LE BAS
        if (currentScrollPosition > lastScrollPosition) {

            // 1 - MAINTENIR LE TITRE AU CENTRE DE LA HAUTEUR VISIBLE DU HEADER 
            // La distance en px à parcourir pour se maintenir au centre = la moitié de la distance scrollée
            let halfOfScrolledHeight = window.scrollY/2;
            /* 
               - Conserver la translation qui positionne le titre au centre du header : horizontalTranslationToCenter, verticalTranslationToCenter

               - Ajouter la translation qui le maintient au centre pendant le scroll : -halfOfScrolledHeight (négatif car il descend sur l'axe des Y)
            */

            // a - Sur desktop, avec titre à gauche, maintenir la translation horizontale pour le maintenir au centre
                if(getComputedStyle(document.querySelector("#title-menu_container")).justifyContent == "space-between"){
                title.style.transform = `translate(${horizontalTranslationToCenter}px, -${verticalTranslationToCenter-halfOfScrolledHeight}px)`;
            }
            // b - Sur mobile, avec titre déjà centré : le maintenir au centre avec juste la translation verticale
            else{
                title.style.transform = `translateY(-${verticalTranslationToCenter-halfOfScrolledHeight}px)`;
            }

            // 2 - AU MOMENT DE FIXER LA ZONE MENU EN HAUT DE L'ÉCRAN, REMETTRE LE TITRE À SA PLACE D'ORIGINE

                if(menuZone.getBoundingClientRect().bottom <= 70){

                // N'appliquer de transition que sur les versions desktop 
                if(getComputedStyle(document.querySelector("#title-menu_container")).justifyContent == "space-between"){
                    title.classList.add("soft-translate");
                }
                title.style.transform = `translate(0)`;
                }

            // Mettre à jour la dernière position du scroll
            lastScrollPosition = currentScrollPosition;
        } 
        // II.2 - AU SCROLL VERS LE HAUT
        else{
            // 1 - SUR VERSIONS DESKTOP (QUAND LE TITRE EST À GAUCHE) -> RECENTRER LE TITRE HORIZONTALEMENT

            if(header.getBoundingClientRect().bottom >= 70){

                // Sur les versions desktop : recentrer le titre
                if(getComputedStyle(document.querySelector("#title-menu_container")).justifyContent == "space-between"){
                    title.style.transform = `translate(${horizontalTranslationToCenter}px, -${verticalTranslationToCenter}px)`;
                }
            }

            // 2 - QUAND LE MENU N'EST PLUS FIXÉ, REMETTRE LE TITRE AU CENTRE DE LA HAUTEUR VISIBLE DU HEADER
            if(header.getBoundingClientRect().bottom >= 70 && !title.classList.contains("reduced")){
                let halfOfScrolledHeight = window.scrollY/2;
                title.classList.remove("soft-translate");

                // a - Sur les versions desktop, quand le titre est à gauche
                if(getComputedStyle(document.querySelector("#title-menu_container")).justifyContent == "space-between"){
                    title.style.transform = `translate(${horizontalTranslationToCenter}px, -${verticalTranslationToCenter-halfOfScrolledHeight}px)`;
                }
                // b - Sur les versions mobiles, quand le titre est déjà centré
                else{
                    title.style.transform = `translateY(-${verticalTranslationToCenter-halfOfScrolledHeight}px)`;
                }
                
            }

            // Mettre à jour la dernière position du scroll
            lastScrollPosition = currentScrollPosition;
        }

    });
});