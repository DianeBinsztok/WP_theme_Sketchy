window.addEventListener("DOMContentLoaded", function () {

    let header = document.querySelector("header");
    let menuZone = document.querySelector("#menu-zone");
    let main = document.querySelector("main");
    let title = document.querySelector("#site-title");
    
    let lastScrollPosition = 0; 
    
    window.addEventListener("scroll", ()=>{  
              // Position actuelle du scroll
            let currentScrollPosition = window.scrollY; 
    
            // AU SCROLL VERS LE BAS
            if (currentScrollPosition > lastScrollPosition) {

              // 1 - Réduire la taille du titre
              if(title.getBoundingClientRect().top <= 10){
                title.classList.add("reduced");
              }
              // 2 - Fixer la zone menu en haut de la page
                  if(menuZone.getBoundingClientRect().bottom <= 70){
                    menuZone.classList.add("onscroll");
                    main.style.paddingTop = "50px";
                  }
                // Mettre à jour la dernière position du scroll
                lastScrollPosition = currentScrollPosition;
            } 
            
            // AU SCROLL VERS LE HAUT
            else{
                  // 1 - Rétablir le style du header
                  if(main.getBoundingClientRect().top >= 0){
                    main.style.paddingTop = "0";
                    menuZone.classList.remove("onscroll");
                  }
                  // 2 - Remettre le titre à sa taille de départ 
                  
                  if(header.getBoundingClientRect().bottom >= 150){
                    title.classList.remove("reduced");
                  }
                    
                // Mettre à jour la dernière position du scroll
                lastScrollPosition = currentScrollPosition;
            }
    })
});