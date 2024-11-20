
// I - ACTIONS AU CHARGEMENT DE LA PAGE
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
            let targetedPopupId = event.target.classList[0].split("opens-").pop();
            findDisplayActivatePopup(targetedPopupId)
        });
    }
}

// II - LES FONCTIONS

// 1 - FONCTIONS GLOBALES

// A - Trouver, afficher et activer une popup
function findDisplayActivatePopup(targetId){
    // Trouver
    let target = findTargetPopupById(targetId);
    if(target){
        // Afficher
        target.classList.remove("hide");
        // Activer
        activatePopup(target);
    }else{
        // Si aucune popup ne correspond à l'id recherché, il ne se passe rien ou la popup affichée se ferme
        return;
    }
}
// A.1 - Chercher une popup par son id
function findTargetPopupById(targetPopupId){
    return document.getElementById(targetPopupId);
}
// A.2 - Activer les fonctionnalités d'une popup à son affichage
function activatePopup(popup){

    // 1) Les propriétés de la popup
    // Éléments d'interfaces qui contiendront des eventListeners : 
    popup.closeBtn = popup.getElementsByClassName("popup_close")[0];
    popup.navArrows = popup.getElementsByClassName("popup_arrow");

    // 2) Les méthodes
    // Les onglets de fermeture étant situés dans la zone hors du contenu, event.stopPropagation(); évite de déclencher deux fois la fermeture de la popup
    popup.handleClickOnCloseButton = (event)=> {event.stopPropagation();closeAndDeactivateCurrentPopup(popup)};
    popup.handleClickOutsideContent = (event)=>  closePopupOnClickOutsideContentZone(event, popup);
    popup.handleClickInNavigationArrows = (event)=> {event.stopPropagation(); navigateOnClickOnPopupNavArrows(event, popup);}
    popup.handleKeyboardArrowEvents = (event) => navigateOnKeyboardArrows(event, popup);
    popup.handleSwipeEvent = (event)=> swipe(event, popup);

    // 3) Les event listeners
    // - Fermer la popup au clic sur l'onglet de fermeture
    popup.closeBtn.addEventListener("click", popup.handleClickOnCloseButton);

    // - Fermer la popup au clic en dehors de la zone de contenu
    popup.addEventListener("click", popup.handleClickOutsideContent);

    // - Changer de popup active au clic sur les onglets-flèches de navigation
    for(let navArrow of popup.navArrows){
        navArrow.addEventListener("click", popup.handleClickInNavigationArrows);
    }  

    // - Navigation au clavier
    addEventListener("keyup", popup.handleKeyboardArrowEvents);

    // - Écrans tactiles : navigation au swipe
    popup.addEventListener("touchstart", popup.handleSwipeEvent);

    // - Empêcher le scroll à l'arrière plan
    changeBackGroundScroll(true);
}

// B - Fermer et désactiver la popup active
function closeAndDeactivateCurrentPopup(popup){
    // Cacher
    popup.classList.add("hide");
    // Désactiver
    deactivatePopup(popup);

}
// B.1 - Désactiver les fonctionnalités de la popup à sa fermeture
function deactivatePopup(popup){

    // - Désactiver le bouton de fermeture
    popup.closeBtn.removeEventListener("click", popup.handleClickOnCloseButton);
    // - Désactiver la fermeture au clic en dehors de la zone de contenu
    popup.removeEventListener("click",popup.handleClickOutsideContent);
    // - Désactiver les onglets-flèches de navigation
    for(let navArrow of popup.navArrows){
        navArrow.removeEventListener("click", popup.handleClickInNavigationArrows);
    }
    // - Désactiver la navigation au clavier, avec les flèches directionnelles
    removeEventListener("keyup", popup.handleKeyboardArrowEvents)
    // - Écrans tactiles : désactiver la navigation au swipe
    popup.removeEventListener("touchstart", popup.handleSwipeEvent);

    // - Rétablir le scroll à l'arrière plan
    changeBackGroundScroll(false);
}

// C - Changer de popup active
function changeActivePopup(currentPopup, newPopupId){
    // Cacher - désactiver la popup courante
    closeAndDeactivateCurrentPopup(currentPopup)

    // Trouver - afficher - activer la nouvelle popup
    findDisplayActivatePopup(newPopupId)
}

// D - Empêcher ou rétablir le scroll de l'arrière-plan
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

// 2 - LES FONCTIONNALITÉS DE LA POPUP

// Fermer la popup au clic sur l'onglet X => on fait directement appel à closeAndDeactivateCurrentPopup 

// Fermer la popup au clic en dehors de la zone de contenu
function closePopupOnClickOutsideContentZone(clickEvent, popup){
    let popupContent = popup.getElementsByClassName("popup_content")[0];
    // Si la cible du clic ne se trouve pas dans la zone de contenu
    if(!popupContent.contains(clickEvent.target)){
        // Fermer la popup
        closeAndDeactivateCurrentPopup(popup);
    }
}

// Naviguer d'une popup à l'autre au clic sur les onglets-flèches
function navigateOnClickOnPopupNavArrows(clickEvent, currentPopup){
    // Repérer la popup suivante ou précédente avec l'id "goto-" sur la flèche
    let newPopupId = clickEvent.target.id.split("goto-").pop();
    // Relancer la recherche avec le nouvel id
    changeActivePopup(currentPopup, newPopupId);
}

// Naviguer d'une popup à l'autre au clavier, avec les flèches directionnelles
function navigateOnKeyboardArrows(keyboardEvent, activePopup){

    let activePopupIdNumber = parseInt(activePopup.id);
    let nextPopupIdNumber = activePopupIdNumber;

    if(keyboardEvent.key == "ArrowRight"){        
        nextPopupIdNumber = activePopupIdNumber +=1;

    }else if(keyboardEvent.key == "ArrowLeft"){
        nextPopupIdNumber = activePopupIdNumber -=1;
    }
    changeActivePopup(activePopup, nextPopupIdNumber.toString());
}

// Sur écrans tactiles : naviguer d'une popup à l'autre au swipe
function swipe(swipeEvent, currentPopup){

    // Seuil en pixels pour détecter un mouvement significatif
    const swipeThreshold = 30; 

    // Enregistrer les coordonnées de départ
    startX = swipeEvent.touches[0].clientX;
    startY = swipeEvent.touches[0].clientY;

    currentPopup.addEventListener("touchend", (event) => {
        // Calculer les coordonnées de fin
        const endX = event.changedTouches[0].clientX;
        const endY = event.changedTouches[0].clientY;

        // Déterminer le déplacement
        const deltaX = endX - startX;
        const deltaY = endY - startY;

        let activePopupIdNumber = parseInt(currentPopup.id);
        let nextPopupIdNumber = activePopupIdNumber;

        // Si le swipe est principalement horizontal
        if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > swipeThreshold) {
            // Si on swipe à droite
            if (deltaX > 0) {
                nextPopupIdNumber = activePopupIdNumber -=1;
            // Si on swipe à gauche
            } else {
                nextPopupIdNumber = activePopupIdNumber +=1;
            }
        }
        changeActivePopup(currentPopup, nextPopupIdNumber.toString());
    });
}
