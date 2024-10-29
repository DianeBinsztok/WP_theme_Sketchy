// I - AU CHARGEMENT DE LA PAGE

window.onload = function() {

    // 1 - Au clic sur une vignette, afficher la popup ciblée

    // Les images visibles : 
    //let clickableArtworks = Array.from(document.getElementsByClassName("clickable-artwork"));
    let clickableArtworks = Array.from(document.getElementsByClassName("artwork_overlay"));
    
    // Pour toutes les images cliquables :
    for(let artwork of clickableArtworks){
        // Au clic sur chaque image,
        artwork.addEventListener("click", (event)=>{
            console.log(event.target);
            // Repérer la popup avec l'id correspondant (mentionné dans la classe 'opens-')
            targetedPopupId = event.target.classList[0].split("opens-").pop();
            // Afficher la popup ciblée et fermer toutes les autres
            displayTargetedPopupAndHideOthers(targetedPopupId, popups);
            changeBackGroundScroll("no-scroll");
        })
    }

    // 2 - Au clic sur la popup, hors de l'image ou sur l'onglet de fermeture : fermer la popup

        // Les popups (cachées par défaut): 
        let popups = Array.from(document.getElementsByClassName("popup-artwork"));

        // Pour toutes les popups :
        for(let popup of popups){

            // Au clic sur chaque image,
            popup.addEventListener("click", (event)=>{     
                // Si le clic est en dehors de la zone d'infos ou de l'image,  
                if(!event.target.classList.contains("popup_content")){
                    // Fermer la popup
                    closePopup(popup);
                    changeBackGroundScroll("scroll");
                }

                // Au clic sur les flèches,
                if(event.target.classList.contains("popup_arrow")){

                    // Repérer la popup suivante ou précédente avec l'id "goto-" sur la flèche
                    targetedPopupId = event.target.id.split("goto-").pop();
                    
                    // Afficher la popup ciblée et fermer toutes les autres
                    displayTargetedPopupAndHideOthers(targetedPopupId, popups);
                }
            });
        }

        /* TEST */
        // Pour toutes les popups :
        for(let popup of popups){

            // Au swipe,
            
            let next = popup.addEventListener("touchmove", (event)=>{     

                    // Repérer la popup suivante ou précédente avec l'id "goto-" sur la flèche

                    //event.preventDefault();
                    //event.stopImmediatePropagation();
                    //event.stopPropagation();
                   
                    let popupId = parseInt(popup.id);
                    let targetedPopupId = popupId +=1;
                    //console.log(targetedPopupId);

                    console.log(event);
                    // Afficher la popup ciblée et fermer toutes les autres
                    //displayTargetedPopupAndHideOthers(targetedPopupId, popups);
                
            });
            /*
            popup.ontouchmove = (event)=>{
                console.log(event);
            }
            */
        }
        /* TEST - FIN */
}

// II - LES FONCTIONS

// 1 - Afficher la popup ciblée et fermer toutes les autres
function displayTargetedPopupAndHideOthers(targetPopupId, allPopups){
    for(let popup of allPopups){
        if(popup.id === targetPopupId){
            popup.classList.remove("hide");
        }else{
            popup.classList.add("hide");
        }
    }
}

// 2 - Fermer la popup au clic hors de l'image et des infos
function closePopup(popup){
    popup.classList.add("hide");
}

// 3 - Empêcher ou rétablir le scroll de l'arrière-plan
function changeBackGroundScroll(directive){
    if(directive === "scroll"){
        document.styleSheets[0].deleteRule("body:not(.popup_overlay) { overflow: hidden }");
    }else if(directive === "no-scroll"){
        document.styleSheets[0].insertRule("body:not(.popup_overlay) { overflow: hidden }", 0)
    }
}
