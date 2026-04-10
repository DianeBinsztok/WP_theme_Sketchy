document.addEventListener('DOMContentLoaded', function () {

    console.log("Nude popup script chargé.");

    // On vérifie si les éléments nécessaires existent avant de continuer
    const sliderContainer = document.getElementById('slider-container');
    const galleryItems = document.querySelectorAll('#gallery_clickable-artworks .clickable-artwork');

    if (!sliderContainer || galleryItems.length === 0) {
        // Si le slider ou la galerie n'est pas sur la page, on ne fait rien.
        return;
    }

    // Éléments du slider : les images uniquement
    const slidesContainer = sliderContainer.querySelector('.slider__slides');
    const slides = sliderContainer.querySelectorAll('.slider__slide');

    // Boutons de navigation et fermeture
    const closeButton = document.querySelector('.slider__close-button');
    const prevButton = sliderContainer.querySelector('.slider__nav-button--prev');
    const nextButton = sliderContainer.querySelector('.slider__nav-button--next');
    const dots = sliderContainer.querySelectorAll('.slider__dot');

    // Éléments d'information du slider
    const sliderTitle = sliderContainer.querySelector('.slider__title');
    const sliderExcerpt = sliderContainer.querySelector('.slider__excerpt');
    const sliderYear = sliderContainer.querySelector('.slider__year');
    const sliderTechniques = sliderContainer.querySelector('.slider__techniques');
    const sliderTags = sliderContainer.querySelector('.slider__tags'); // Ajout pour les tags

    let currentIndex = 0;

    // Fonction pour mettre à jour le contenu du slider
    function updateSlider(index) {

        // Déplacement des slides
        slidesContainer.style.transform = `translateX(-${index * 100}%)`;

        // Récupération des données depuis les attributs data-* de la slide
        const currentSlide = slides[index];
        if (currentSlide) {
            const artworkCategory = currentSlide.dataset.category || '';
            const artworkTitle = currentSlide.dataset.title || '';
            const artworkExcerpt = currentSlide.dataset.excerpt || '';
            const artworkYear = currentSlide.dataset.year || '';
            const artworkTechniques = currentSlide.dataset.techniques ? JSON.parse(currentSlide.dataset.techniques) : [];
            const artworkTags = currentSlide.dataset.tags ? JSON.parse(currentSlide.dataset.tags) : [];
            const artworkNbOfArtworksOfTheSameYear = currentSlide.dataset.nbOfArtworksOfTheSameYear || '';

            // Uniquement pour les artworks de catégorie "sketchbooks"
            if(artworkCategory.includes('Sketchbook')) {
                // Reset des dots à chaque mise à jour
                sliderContainer.querySelector('.slider__dots').innerHTML=''; 
            }

            // Mise à jour des informations
            sliderTitle.textContent = artworkTitle;
            sliderExcerpt.textContent = artworkExcerpt;
            sliderYear.textContent = artworkYear;

            // Mise à jour des techniques
            sliderTechniques.innerHTML = '';
            if (Array.isArray(artworkTechniques)) {
                artworkTechniques.forEach(technique => {
                    const li = document.createElement('li');
                    li.textContent = technique;
                    sliderTechniques.appendChild(li);
                });
            }

            // Mise à jour des tags
            if (sliderTags) {
                sliderTags.innerHTML = '';
                if (Array.isArray(artworkTags)) {
                    artworkTags.forEach(tag => {
                        const li = document.createElement('li');
                        li.textContent = tag;
                        sliderTags.appendChild(li);
                    });
                }
            }
            // Ajouter la classe 'active' au dot correspondant à l'index actuel
            if (dots) {
                dots.forEach(dot => {
                    dot.classList.remove('active');
                });
                const activeDot = sliderContainer.querySelector(`.slider__dot[data-index="${index}"]`);
                if (activeDot) {
                    activeDot.classList.add('active');
                }
            }
            
            

        }
        currentIndex = index;
    }

    // Fonction pour ouvrir le slider
    function openSlider(index) {
        sliderContainer.classList.remove('hide');
        sliderContainer.style.display = 'flex'; // Assure que le conteneur est visible
        document.body.classList.add('no-scroll'); // Empêche le scroll de l'arrière-plan
        updateSlider(index);
    }

    // Fonction pour fermer le slider
    function closeSlider() {
        sliderContainer.classList.add('hide');
        document.body.classList.remove('no-scroll'); // Réactive le scroll
        sliderContainer.style.display = 'none';
    }

    // Ajout des écouteurs d'événements

    // Clic sur une vignette de la galerie
    galleryItems.forEach((item, index) => {
        item.addEventListener('click', function () {
            // L'index de la vignette correspond à l'index de la slide
            openSlider(index);
        });
    });

    // Clic sur les flèches de navigation
    prevButton.addEventListener('click', () => {
        const newIndex = (currentIndex - 1 + slides.length) % slides.length;
        updateSlider(newIndex);
    });

    nextButton.addEventListener('click', () => {
        const newIndex = (currentIndex + 1) % slides.length;
        updateSlider(newIndex);
    });

    // Clic sur les points de navigation
    if(dots){
        dots.forEach(dot => {
            dot.addEventListener('click', function () {
                const index = parseInt(this.dataset.index, 10);
                updateSlider(index);
            });
        });
    }

    

    // Fermeture du slider en cliquant sur le fond (en dehors du contenu)
    sliderContainer.addEventListener('click', function (e) {
        // On vérifie que le clic est bien sur le conteneur principal et non sur un de ses enfants
        if (e.target === sliderContainer) {
            closeSlider();
        }
    });
    
    // Clic sur le bouton de fermeture
    if (closeButton) {
        closeButton.addEventListener('click', closeSlider);
    }

    // --- Navigation au clavier et au swipe ---

    let touchStartX = 0;
    let touchEndX = 0;

    function handleSwipe() {
        const swipeThreshold = 50; // 50px de swipe minimum pour déclencher l'action
        if (touchEndX < touchStartX - swipeThreshold) {
            // Swipe vers la gauche -> slide suivante
            const newIndex = (currentIndex + 1) % slides.length;
            updateSlider(newIndex);
        }
        if (touchEndX > touchStartX + swipeThreshold) {
            // Swipe vers la droite -> slide précédente
            const newIndex = (currentIndex - 1 + slides.length) % slides.length;
            updateSlider(newIndex);
        }
    }

    // Écouteurs d'événements pour le swipe
    slidesContainer.addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    slidesContainer.addEventListener('touchend', e => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, { passive: true });


    // Écouteur d'événement pour la navigation au clavier
    document.addEventListener('keydown', function (e) {
        // On ne fait rien si le slider n'est pas visible
        if (sliderContainer.style.display !== 'flex') {
            return;
        }

        if (e.key === 'ArrowLeft') {
            const newIndex = (currentIndex - 1 + slides.length) % slides.length;
            updateSlider(newIndex);
        } else if (e.key === 'ArrowRight' || e.key === ' ') {
            e.preventDefault(); // Empêche la barre d'espace de faire défiler la page
            const newIndex = (currentIndex + 1) % slides.length;
            updateSlider(newIndex);
        } else if (e.key === 'Escape') {
            // Bonus : fermer la popup avec la touche "Echap"
            closeSlider();
        }
    });

});