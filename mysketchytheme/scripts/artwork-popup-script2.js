// I - ACTIONS AU CHARGEMENT DE LA PAGE
window.addEventListener("load", function() {

    // Les images visibles : 
    let clickableArtworks = Array.from(document.getElementsByClassName("artwork_overlay"));
    // Le slider popup : 
    let popup = document.querySelector("#popup_overlay");
    console.log(popup)
    // Au clic sur un artwork, afficher la popup correspondante

    // Pour toutes les images cliquables :
    for(let artwork of clickableArtworks){
        // Au clic sur chaque image,
        artwork.addEventListener("click", (event)=>{
            console.log(artwork);
            console.log(popup);
            popup.classList.remove("hide"); 
        });
    }
}) 

// II - LES FONCTIONS

// OUVRIR LA POPUP
function displayAndActivatePopup(){
    // Afficher la popup
    popup.classList.remove("hide"); 
}
