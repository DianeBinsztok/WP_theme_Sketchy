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
            displayTargetedPopupAndHideOthers(targetedPopupId, popups);
        })
    }

}

// II - LES FONCTIONS

// Activer la popup ciblée s'il y en a une et cacher les autres
function displayTargetedPopupAndHideOthers(targetPopupId, popupsArray){

    let foundTargetedPopup = false;

    // Chercher la popup cible par son id
    for(let popup of popupsArray){

        // Si on trouve une correspondance
        if(popup.id === targetPopupId){

            // Rendre la popup ciblée visible
            popup.classList.remove("hide");

            // Activer la popup ciblée : 
            // a - les flèches de navigation
            activatePopupNavArrows(popup, popupsArray);
            // b - le bouton de fermeture
            activatePopupCloseButton(popup);
            // c - la fermeture de la popup si on clique hors du contenu
            activatePopupCloseWhenClickOutsideContent(popup)

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
function changeBackGroundScroll(aPopupIsDisplayed){

    let body = document.body;

    // Si une popup est ouverte : bloquer le scroll sur le body, en arrière plan
    if(aPopupIsDisplayed){
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

