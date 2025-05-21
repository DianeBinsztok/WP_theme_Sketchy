<?php
/*
 * Template Name: Sketchy
 */
get_header();
?>
<!--
<section id="introduction" class="with-padding">
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore enim, quaerat illo repellat dignissimos
        laudantium corporis nisi quos iure maiores rem ratione labore ad voluptatem? Eos cupiditate voluptatum sint
        qui.</p>
</section>
-->

<!--
<section id="latest-news" class="with-padding">
    <h2>Quoi de neuf?</h2>
    
    <?php
    display_latest_news_in_slider();
    ?>

</section>
-->


<section id="artworks" class="with-padding">
    <!--<h2>Travaux</h2>-->
    <div id="gallery-links">

        <!-- Modèle vivant-->
        <div class="gallery-link_container">
            <a href="<?php echo get_site_url(); ?>/artworks/?categorie=nu">
                <!-- Images, selon device-->
                <!-- mobile vertical : image horizontale-->
                <img class="gallery-link_img horizontal"
                    src="<?php echo get_site_url(); ?>/wp-content/uploads/2025/05/nude-watercolor-brushpen-women-lying-amicaldar-2019-02-20-horizontal.jpg'"
                    alt="">
                <!-- mobile horizontal et tablettes : image carrée-->
                <img class="gallery-link_img square"
                    src="<?php echo get_site_url(); ?>/wp-content/uploads/2025/05/nude-watercolor-brushpen-women-back-square.jpg'"
                    alt="">
                <!-- grandes tablettes et desktop : image verticale-->
                <img class="gallery-link_img vertical"
                    src="<?php echo get_site_url(); ?>/wp-content/uploads/2025/05/nude-watercolor-brushpen-women-back-vertical.jpg'"
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
                <!-- Images, selon device-->
                <!-- mobile vertical : image horizontale-->
                <img class="gallery-link_img horizontal"
                    src="<?php echo get_site_url(); ?>/wp-content/uploads/2025/05/sketchbook-felt-ti-pen-lying-sofa-2017-01-14-horizontal-scaled.jpg'"
                    alt="">
                <!-- mobile horizontal et tablettes : image carrée-->
                <img class="gallery-link_img square"
                    src="<?php echo get_site_url(); ?>/wp-content/uploads/2025/05/sketchbook-felt-ti-pen-lying-sofa-2017-01-14-square.jpg'"
                    alt="">
                <!-- grandes tablettes et desktop : image verticale-->
                <img class="gallery-link_img vertical"
                    src="<?php echo get_site_url(); ?>/wp-content/uploads/2025/05/sketchbook-felt-tip-pen-cigarette-break-2012-11-27-vertical-scaled.jpg'"
                    alt="">

                <div class="gallery-link_text">
                    <h3 class="gallery-link_title">Sketchbooks</h3>
                    <!--<p class="gallery-link_description">Quand je m'ennuie, je croque.</p>-->
                </div>
            </a>
        </div>

        <!-- Peinture -->
        <div class="gallery-link_container">
            <a href="<?php echo get_site_url(); ?>/artworks/?techniques=Huile">
                <!-- Images, selon device-->
                <!-- mobile vertical : image horizontale-->
                <img class="gallery-link_img horizontal"
                    src="<?php echo get_site_url(); ?>/wp-content/uploads/2025/05/oil-painting-osakakou-horizontal-scaled.jpg'"
                    alt="">
                <!-- mobile horizontal et tablettes : image carrée-->
                <img class="gallery-link_img square"
                    src="<?php echo get_site_url(); ?>/wp-content/uploads/2025/05/oil-painting-osakakou-square.jpg'"
                    alt="">
                <!-- grandes tablettes et desktop : image verticale-->
                <img class="gallery-link_img vertical"
                    src="<?php echo get_site_url(); ?>/wp-content/uploads/2025/05/oil-painting-osakakou-vertical.jpg'"
                    alt="">

                <div class="gallery-link_text">
                    <h3 class="gallery-link_title">Peintures</h3>
                    <!--<p class="gallery-link_description">Mes rares tentatives de tableau à l'huile</p>-->
                </div>
            </a>
        </div>

        <!-- Carnets de voyage -->
        <div class="gallery-link_container">
            <a href="<?php echo get_site_url(); ?>/artworks/?categorie=carnet-de-voyage">
                <!-- Images, selon device-->
                <!-- mobile vertical : image horizontale-->
                <img class="gallery-link_img horizontal"
                    src="<?php echo get_site_url(); ?>/wp-content/uploads/2025/05/travel-journal-watercolor-south-africa-hermanus-whale-13-10-2018-horizontal.jpg'"
                    alt="">
                <!-- mobile horizontal et tablettes : image carrée-->
                <img class="gallery-link_img square"
                    src="<?php echo get_site_url(); ?>/wp-content/uploads/2025/05/travel-journal-watercolor-osaka-castle-park2-2019-03-08-square-rotated.jpg'"
                    alt="">
                <!-- grandes tablettes et desktop : image verticale-->
                <img class="gallery-link_img vertical"
                    src="<?php echo get_site_url(); ?>/wp-content/uploads/2025/05/travel-journal-watercolor-osaka-castle-park2-2019-03-08-vertical-rotated.jpg'"
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