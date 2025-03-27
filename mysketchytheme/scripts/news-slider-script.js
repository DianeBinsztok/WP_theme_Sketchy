window.addEventListener("DOMContentLoaded", function () {

    // Le contenant à déplacer
    const slider = document.querySelector("#slider");

    // Les slides
    const slides = document.querySelectorAll(".slide");
    const slidesMaxIndex = slides.length-1;

    //L'index de la slide courante
    let currentSlideIndex = 0;

    // Les boutons
    const nextSlideBtn = document.querySelector("#btn-next");
    const previousSlideBtn = document.querySelector("#btn-prev");


    nextSlideBtn.addEventListener('click', () => {
        if (currentSlideIndex === slidesMaxIndex) {
            currentSlideIndex = 0;
            slider.style.transform = `translateX(-${currentSlideIndex*100}%)`;
        }else{
            currentSlideIndex ++;
            slider.style.transform = `translateX(-${currentSlideIndex*100}%)`;
        }
  
    });

    previousSlideBtn.addEventListener('click', () => {
        if (currentSlideIndex === 0) {
            currentSlideIndex = slidesMaxIndex;
            slider.style.transform = `translateX(-${currentSlideIndex*100}%)`;
        }else{
            currentSlideIndex --;
            slider.style.transform = `translateX(-${currentSlideIndex*100}%)`;
        }
    });


    // Pour les versions mobiles, navigation au swipe
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
                console.log("Swipe à droite");
                if (currentSlideIndex === 0) {
                    currentSlideIndex = slidesMaxIndex;
                    slider.style.transform = `translateX(-${currentSlideIndex*100}%)`;
                }else{
                    currentSlideIndex --;
                    slider.style.transform = `translateX(-${currentSlideIndex*100}%)`;
                }
            
            // Si on swipe à gauche (suivant)
            } else {
                console.log("Swipe à gauche");
                if (currentSlideIndex === slidesMaxIndex) {
                    currentSlideIndex = 0;
                    slider.style.transform = `translateX(-${currentSlideIndex*100}%)`;
                }else{
                    currentSlideIndex ++;
                    slider.style.transform = `translateX(-${currentSlideIndex*100}%)`;
                }
            }

            // Appliquer la transformation
            slider.style.transform = `translateX(-${currentSlideIndex * 100}%)`;
            console.log(`Slide actif : ${currentSlideIndex}`);
        }
    });
});