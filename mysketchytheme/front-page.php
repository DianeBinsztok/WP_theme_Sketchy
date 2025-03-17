<?php
/*
 * Template Name: Sketchy
 */
get_header();
?>

<section id="introduction" class="with-padding">
    <h1>Bienvenue sur mon sketchbook</h1>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore enim, quaerat illo repellat dignissimos
        laudantium corporis nisi quos iure maiores rem ratione labore ad voluptatem? Eos cupiditate voluptatum sint
        qui.</p>
</section>
<section id="galleries-introduction" class="with-padding">
    <div class="gallery-link_container">
        <a href="<?php echo get_site_url(); ?>/artworks/?categorie=nu">
            <div class="gallery-link"
                style="background-image: url('<?php echo get_site_url(); ?>/wp-content/uploads/2024/10/47.jpg');">
                <h2>Des gens tous nus</h2>
                <p>Je paie des sous pour aller dans des ateliers privés voir des gens tous nus.</p>
            </div>
        </a>
    </div>

    <div class="gallery-link_container">
        <a href="<?php echo get_site_url(); ?>/artworks/?categorie=croquis">
            <div class="gallery-link"
                style="background-image: url('<?php echo get_site_url(); ?>/wp-content/uploads/2024/10/56.jpg');">
                <h2>Des croquis</h2>
                <p>Quand je m'ennuie, je croque des trucs... Je m'ennuie souvent et partout.</p>
            </div>
        </a>
    </div>
    <div class="gallery-link_container">
        <a href="<?php echo get_site_url(); ?>/artworks/?categorie=peinture">
            <div class="gallery-link" style="
                background-image: url('<?php echo get_site_url(); ?>/wp-content/uploads/2024/10/116-scaled.jpg');">
                <h2>De l'huile</h2>
                <p>Mes rares tentatives.</p>
            </div>
        </a>
    </div>
</section>
<section id="about" class="with-padding">
    <h2>À propos</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magni adipisci soluta, explicabo dolorem voluptates
        earum alias in dicta ea ullam est, consectetur repellat nobis eos mollitia expedita praesentium! Quibusdam,
        necessitatibus.</p>
</section>
<?php
get_footer();
?>