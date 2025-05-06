<?php
get_header();

if (have_posts()):

    echo "<section class='posts_container with-padding'>";

    while (have_posts()):

        the_post();

        // L'url du post
        $post_url = get_site_url() . "/" . get_post_field('post_name');

        // La vignette custom : une image croppée à la main au format carré
        // Si la vignette custom n'est pas définie, afficher le thumbnail défini par WP

        // Récupérer le post-meta "post_img_custom_square_id" s'il existe
        $post_custom_img_square_id = get_post_meta($post->ID, "post_img_custom_square_id", true);

        // Voir si un custom_img_square est enregistré
        if ($post_custom_img_square_id) {
            $post_custom_img_square = wp_get_attachment_image($post_custom_img_square_id, "medium");
            // Si custom_img_square n'a pas été renseigné, utiliser le thumbnail par défaut     
        } else {
            $post_custom_img_square = get_the_post_thumbnail($post_id, "medium");
        }
        ?>

        <div class='post-card_container'>
            <div class='post-card'>

                <a href=" <?php echo $post_url ?>">

                    <!-- le conteneur de l'image -->
                    <div class='post-card_image_container'>
                        <?php echo $post_custom_img_square ?>
                    </div>

                    <!-- le contenu -->
                    <div class="content-zone">

                        <div class="title-zone">
                            <?php the_title('<h2>', '</h2>') ?>
                        </div>

                        <div class='excerpt'>
                            <?php the_excerpt() ?>
                        </div>

                        <div class='date'>
                            <?php echo get_the_date("j F, Y") ?>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <?php

    endwhile;

    echo "</section>";

endif;

get_footer();


