window.addEventListener("DOMContentLoaded", function () {

    // I - ELEMENTS DU DOM ET COMPTEURS
    // Le contenant à déplacer
    const slider = document.querySelector("#slider");

    // Les slides
    const slides = document.querySelectorAll(".slide");
    const slidesMaxIndex = slides.length-1;

    // L'index de la slide courante
    let currentSlideIndex = 0;
    // Le statut du timer (actif ou en pause)
    let sliderTimerOn = true;

    // I - ACTIVATION DU CARROUSEL AU TIMER
    if(slider && slides){
        setInterval(()=>{
                if(sliderTimerOn){
                    currentSlideIndex = resetCurrentSlide(currentSlideIndex, slidesMaxIndex, "next");
                    slide(slider, currentSlideIndex)
                }
            }, 3000);
    }

    // II - ACTIVATION SUR LE CARROUSEL AVEC LES BOUTON
    const nextSlideBtn = document.querySelector("#btn-next");
    const previousSlideBtn = document.querySelector("#btn-prev");


    nextSlideBtn.addEventListener('click', () => {
        // Mettre le slide automatique en pause
        sliderTimerOn = false;
        currentSlideIndex = resetCurrentSlide(currentSlideIndex, slidesMaxIndex, "next");
        slide(slider, currentSlideIndex);
        // Attendre 3s avant de remettre le slider en route
        setTimeout(()=>{sliderTimerOn = true}, 3000);
    });

    previousSlideBtn.addEventListener('click', () => {
        // Mettre le slide automatique en pause
        sliderTimerOn = false;
        currentSlideIndex = resetCurrentSlide(currentSlideIndex, slidesMaxIndex, "previous");
        slide(slider, currentSlideIndex);
        // Attendre 3s avant de remettre le slider en route
        setTimeout(()=>{sliderTimerOn = true}, 3000);
    });


    // III - ACTIVATION DU CARROUSEL AU SWIPE, SUR ÉCRANS TACTILES
    // Récupération des éléments
    let startX = 0;
    let startY = 0;
    const swipeThreshold = 30; // Seuil pour détecter un swipe


    // Event touchstart
    slider.addEventListener("touchstart", (swipeEvent) => {
        startX = swipeEvent.touches[0].clientX;
        startY = swipeEvent.touches[0].clientY;
    });

    // Event touchend (attaché une seule fois)
    slider.addEventListener("touchend", (event) => {
        // Calculer les coordonnées de fin
        const endX = event.changedTouches[0].clientX;
        const endY = event.changedTouches[0].clientY;

        // Déterminer le déplacement
        const deltaX = endX - startX;
        const deltaY = endY - startY;

        // Vérifier si le mouvement est principalement horizontal et dépasse le seuil
        if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > swipeThreshold) {
            
            // Si on swipe à droite (retour arrière)
            if (deltaX > 0) {
                currentSlideIndex = resetCurrentSlide(currentSlideIndex, slidesMaxIndex, "previous");
                slide(slider, currentSlideIndex);
            
            // Si on swipe à gauche (suivant)
            } else {
                currentSlideIndex = resetCurrentSlide(currentSlideIndex, slidesMaxIndex, "next");
                slide(slider, currentSlideIndex);
            }

            // Appliquer la transformation
            slider.style.transform = `translateX(-${currentSlideIndex * 100}%)`;
        }
    });
});


// 1 - Réaffecter la slide courante
function resetCurrentSlide(currentSlide, lastSlide, direction){
    if(direction === "next"){
        return (currentSlide === lastSlide) ? 0 : currentSlide + 1;        
    }else if(direction === "previous"){
        return (currentSlide === 0) ? lastSlide : currentSlide - 1;        
    }else{
        return currentSlide;
    }
}
// 2 - Déplacer le slider
function slide(slider, currentSlide){      
    slider.style.transform = `translateX(-${currentSlide*100}%)`;
}

// 3 - Mettre en pause et redémarrer le slide automatique
function manageCarouselTimer(playOrPause){
    if(playOrPause === "pause"){
       
    }else if(playOrPause === "play"){
        
    }
}