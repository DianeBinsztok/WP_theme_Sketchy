// I - AU CHARGEMENT DE LA PAGE

window.onload = function() {

    // Les images visibles : 
    let clickableArtworks = Array.from(document.getElementsByClassName("artwork_overlay"));

    // Les popups (cachées par défaut): 
    let popups = Array.from(document.getElementsByClassName("popup-artwork"));


    // Au clic sur un artwork, afficher la popup correspondante

    // Pour toutes les images cliquables :
    for(let artwork of clickableArtworks){

        // Au clic sur chaque image,
        artwork.addEventListener("click", (event)=>{
            // Repérer la popup avec l'id correspondant (mentionné dans la classe 'opens-')
            let targetedPopupId = event.target.classList[0].split("opens-").pop();
            let targetedPopup = findPopupById(targetedPopupId);

            // Si une popup existe avec cet id : 
            if(targetedPopup){
                // Afficher la popup et cacher les autres
                displayTargetedPopupAndHideOthers(targetedPopupId, popups);
            }
        })
    }
}

// II - LES FONCTIONS

// Vérifier si l'id de popup ciblée existe
function findPopupById(targetedPopupId){
    let targetedPopup = document.getElementById(targetedPopupId);
    return targetedPopup;
}

// Activer la popup ciblée s'il y en a une et cacher les autres
function displayTargetedPopupAndHideOthers(targetPopupId, popupsArray){

    let foundTargetedPopup = false;

    // Chercher la popup cible par son id
    for(let popup of popupsArray){

        // Si on trouve une correspondance
        if(popup.id == targetPopupId){

            // Rendre la popup ciblée visible
            popup.classList.remove("hide");
            // Activer la popup ciblée : 
            // a - les flèches de navigation
            activatePopupNavArrows(popup, popupsArray);
            // b - le bouton de fermeture
            activatePopupCloseButton(popup);
            // c - la fermeture de la popup si on clique hors du contenu
            activatePopupCloseWhenClickOutsideContent(popup);
            // d - activer touchmove pour les versions tactiles
            activatePopupNavigationWithTouchmoveEvents(popup, popupsArray);

            foundTargetedPopup = true;

        }else{
            // Cacher les popups non-ciblées
            popup.classList.add("hide");
        }
    }
    // Si l'id donné en param mène bien à une popup : bloquer le body en arrière plan 
    changeBackGroundScroll(foundTargetedPopup);
}

// Empêcher ou rétablir le scroll de l'arrière-plan
function changeBackGroundScroll(boolAPopupIsOpened){

    let body = document.body;

    // Si une popup est ouverte : bloquer le scroll sur le body, en arrière plan
    if(boolAPopupIsOpened){
        body.classList.add("no-scroll");
    }
    // Sinon, rétablir le scroll sur le body
    else{
        body.classList.remove("no-scroll");
    }
}

// Activer les flèches de navigation sur la popup active
function activatePopupNavArrows(activePopup, popupsArray){

    let navArrows = activePopup.getElementsByClassName("popup_arrow");
    //let popupNavArrows = Array.from(document.getElementsByClassName("popup_arrow"));
    for(let navArrow of navArrows){

        // Repérer la popup suivante ou précédente avec l'id "goto-" sur la flèche
        let targetedPopupId = navArrow.id.split("goto-").pop();

        navArrow.addEventListener(("click"), ()=>{

            //Afficher la popup ciblée et masquer les autres
            displayTargetedPopupAndHideOthers(targetedPopupId, popupsArray);
        });
    }
};

// Activer le bouton de fermeture sur la popup active
function activatePopupCloseButton(activePopup){
    let closePopupBtn = activePopup.getElementsByClassName("popup_close")[0];
    closePopupBtn.addEventListener("click", ()=>{
        activePopup.classList.add("hide");
        changeBackGroundScroll(false);
    });
};

// Activer la fermeture de la popup au clique en dehors du contenu
function activatePopupCloseWhenClickOutsideContent(activePopup){

    let popupContent = activePopup.getElementsByClassName("popup_content")[0];
    
    activePopup.addEventListener("click", (event)=>{
        if(!popupContent.contains(event.target)){
            activePopup.classList.add("hide");
            changeBackGroundScroll(false);
        }
    })
};

// Activer la navigation au touchmove pour les versions tactiles
function activatePopupNavigationWithTouchmoveEvents(activePopup, popupsArray){

    let startX = 0;
    let startY = 0;
    const swipeThreshold = 30; // Seuil en pixels pour détecter un mouvement significatif
    
    activePopup.addEventListener("touchstart", (event) => {
        // Enregistrer les coordonnées de départ
        startX = event.touches[0].clientX;
        startY = event.touches[0].clientY;
    });
    
    activePopup.addEventListener("touchend", (event) => {
        // Calculer les coordonnées de fin
        const endX = event.changedTouches[0].clientX;
        const endY = event.changedTouches[0].clientY;
    
        // Déterminer le déplacement
        const deltaX = endX - startX;
        const deltaY = endY - startY;
    
        // Si le swipe est principalement horizontal
        if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > swipeThreshold) {
            // Si on swipe à droite
            if (deltaX > 0) {
                swipe(activePopup, "previous", popupsArray);
            // Si on swipe à gauche
            } else {
                swipe(activePopup, "next", popupsArray);
            }
        }
        
        // On fait quelque chose pour un swipe vertical ?
        /*
        else if (Math.abs(deltaY) > swipeThreshold) {
            if (deltaY > 0) {
                console.log("Swipe bas détecté");
            } else {
                console.log("Swipe haut détecté");
            }
        }     
        */
    });
}

// Décider de la prochaine popup au swipe
function swipe(activePopup, direction, popupsArray){
    
    let activePopupIdNumber = parseInt(activePopup.id);
    let nextPopupIdNumber = activePopupIdNumber;

    
    if(direction == "previous"){
        nextPopupIdNumber = activePopupIdNumber -=1;
    }else if(direction == "next"){
        nextPopupIdNumber = activePopupIdNumber +=1;
    }
    
    displayTargetedPopupAndHideOthers(nextPopupIdNumber, popupsArray);
}