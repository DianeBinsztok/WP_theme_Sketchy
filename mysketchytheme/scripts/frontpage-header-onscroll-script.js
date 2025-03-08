window.addEventListener("load", function() {

    let header = document.querySelector("header");
    let menuZone = document.querySelector("#menu-zone");
    let main = document.querySelector("main");
    let title = document.querySelector("#site-title");

    /*CENTRER LE TITRE AU DÉMARRAGE*/

    // Verticalement : la moitié de la hauteur du header, en retranchant la moitié de la hauteur de titre
    let verticalTranslationToCenter = (header.offsetHeight-title.offsetHeight)/2;

    // Horizontalement : la moitié de la largeur du header, en retranchant la moitié de la largeur de titre
    let horizontalTranslationToCenter = (menuZone.offsetWidth-title.offsetWidth)/2;

    title.style.transform = `translate(${horizontalTranslationToCenter}px, -${verticalTranslationToCenter}px)`;




    // Stocker la dernière position du scroll pour détecter un scroll vers le bas ou vers le haut
    let lastScrollPosition = 0; 



    // AU SCROLL : 
    window.addEventListener("scroll", function () {        

        // Position actuelle du scroll
        let currentScrollPosition = window.scrollY; 

        // AU SCROLL VERS LE BAS
        if (currentScrollPosition > lastScrollPosition) {


            // I - Maintenir le titre au centre de la hauteur visible du header
            let halfOfScrolledHeight = window.scrollY/2;
            /* 
               a - Conserver la translation qui positionne le titre au centre du header : horizontalTranslationToCenter, verticalTranslationToCenter

               b - Ajouter la translation qui le maintient au centre pendant le scroll : -halfOfScrolledHeight (négatif car il descend sur l'axe des Y)
            */
            title.style.transform = `translate(${horizontalTranslationToCenter}px, -${verticalTranslationToCenter-halfOfScrolledHeight}px)`;


            // II - Réduire la taille du titre
            if(title.getBoundingClientRect().top <= 10){
            title.classList.add("reduced");
            }
            // III - Fixer la zone menu en haut de la page
                if(menuZone.getBoundingClientRect().bottom <= 70){
                menuZone.classList.add("onscroll");

                title.classList.add("soft-translate");
                title.style.transform = `translate(0)`;
                main.style.paddingTop = "50px";
                }

        // Mettre à jour la dernière position du scroll
        lastScrollPosition = currentScrollPosition;
        } 
        // AU SCROLL VERS LE HAUT
        else{
            // I - "Défixer" la zone fixe du header
            if(main.getBoundingClientRect().top >= 0){
            main.style.paddingTop = "0";
            menuZone.classList.remove("onscroll");
            }

            // II - Remettre le titre à sa taille de départ et le re-centrer horizontalement
            if(header.getBoundingClientRect().bottom >= 70){
                title.classList.remove("reduced");
                title.style.transform = `translate(${horizontalTranslationToCenter}px, -${verticalTranslationToCenter}px)`;
            }

            // III - Remettre le titre au centre de la hauteur visible du header
            if(header.getBoundingClientRect().bottom >= 70 && !title.classList.contains("reduced")){
                title.classList.remove("soft-translate");
                let halfOfScrolledHeight = window.scrollY/2;
                title.style.transform = `translate(${horizontalTranslationToCenter}px, -${verticalTranslationToCenter-halfOfScrolledHeight}px)`;
            }

            



            // Mettre à jour la dernière position du scroll
            lastScrollPosition = currentScrollPosition;
        }

    });
});