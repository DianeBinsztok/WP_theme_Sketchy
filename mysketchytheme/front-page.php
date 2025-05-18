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
    <h2>Quoi de neuf?</h2>
    <?php
    display_latest_news_in_slider();
    ?>

</section>

<section id="artworks" class="with-padding">
    <h2>Travaux</h2>
    <div id="gallery-links">

        <!-- Modèle vivant-->
        <div class="gallery-link_container">
            <a href="<?php echo get_site_url(); ?>/artworks/?categorie=nu">
                <img class="gallery-link_img" src="<?php echo get_site_url(); ?>/wp-content/uploads/2024/10/47.jpg'"
                    alt="">
                <div class="gallery-link_text">
                    <h3 class="gallery-link_title">Modèle vivant</h3>
                    <!--<p class="gallery-link_description">Je paie des sous pour aller dans des ateliers privés voir
                        des
                        gens tous nus.</p>-->
                </div>
            </a>
        </div>

        <!-- Sketchbooks-->
        <div class="gallery-link_container">
            <a href="<?php echo get_site_url(); ?>/artworks/?categorie=croquis">
                <img class="gallery-link_img" src="<?php echo get_site_url(); ?>/wp-content/uploads/2024/10/56.jpg'"
                    alt="">
                <div class="gallery-link_text">
                    <h3 class="gallery-link_title">Sketchbooks</h3>
                    <!--<p class="gallery-link_description">Quand je m'ennuie, je croque.</p>-->
                </div>
            </a>
        </div>

        <!-- Peinture -->
        <div class="gallery-link_container">
            <a href="<?php echo get_site_url(); ?>/artworks/?categorie=croquis">
                <img class="gallery-link_img"
                    src="<?php echo get_site_url(); ?>/wp-content/uploads/2024/10/116-scaled.jpg'" alt="">
                <div class="gallery-link_text">
                    <h3 class="gallery-link_title">Peintures</h3>
                    <!--<p class="gallery-link_description">Mes rares tentatives de tableau à l'huile</p>-->
                </div>
            </a>
        </div>

        <!-- Carnets de voyage -->
        <div class="gallery-link_container">
            <a href="<?php echo get_site_url(); ?>/artworks/?categorie=croquis">
                <img class="gallery-link_img" src="<?php echo get_site_url(); ?>/wp-content/uploads/2024/10/45.jpg'"
                    alt="">
                <div class="gallery-link_text">
                    <h3 class="gallery-link_title">Carnets de voyage</h3>
                    <!--<p class="gallery-link_description">J'aime faire des road trips et croquer de nouveaux paysages.
                    </p>-->
                </div>
            </a>
        </div>

    </div>
</section>
<?php
get_footer();
?>