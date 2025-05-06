<?php
/*
 * Template Name: Sketchy
 */
get_header();
?>

<section id="introduction" class="with-padding">
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore enim, quaerat illo repellat dignissimos
        laudantium corporis nisi quos iure maiores rem ratione labore ad voluptatem? Eos cupiditate voluptatum sint
        qui.</p>
</section>

<section id="latest-news" class="with-padding">

    <?php
    display_latest_news_in_slider();
    ?>

</section>

<section id="galleries-introduction" class="with-padding">
    <div class="gallery-link_container">
        <a href="<?php echo get_site_url(); ?>/artworks/?categorie=nu">
            <div class="gallery-link"
                style="background-image: url('<?php echo get_site_url(); ?>/wp-content/uploads/2024/10/47.jpg');">
                <div class="gallery-link_text">
                    <h2>Des gens tous nus</h2>
                    <p>Je paie des sous pour aller dans des ateliers privés voir des gens tous nus.</p>
                </div>
            </div>
        </a>
    </div>

    <div class="gallery-link_container">
        <a href="<?php echo get_site_url(); ?>/artworks/?categorie=croquis">
            <div class="gallery-link"
                style="background-image: url('<?php echo get_site_url(); ?>/wp-content/uploads/2024/10/56.jpg');">

                <div class="gallery-link_text">
                    <h2>Des croquis</h2>
                    <p>Quand je m'ennuie, je croque des trucs... Je m'ennuie souvent et partout.</p>
                </div>
            </div>
        </a>
    </div>
    <div class="gallery-link_container">
        <a href="<?php echo get_site_url(); ?>/artworks/?categorie=peinture">
            <div class="gallery-link" style="
                background-image: url('<?php echo get_site_url(); ?>/wp-content/uploads/2024/10/116-scaled.jpg');">
                <div class="gallery-link_text">
                    <h2>De l'huile</h2>
                    <p>Mes rares tentatives.</p>
                </div>
            </div>
        </a>
    </div>
</section>
<?php
get_footer();
?>