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
            slider.style.transform = `translateX(${currentSlideIndex})`;
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

});