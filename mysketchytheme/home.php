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
        $thumbnail = get_the_post_thumbnail($post->ID);
        $post_custom_thumbnail_id = get_post_meta($post->ID, 'post_custom_thumbnail_id', true);

        if ($post_custom_thumbnail_id) {
            $thumbnail = wp_get_attachment_image($post_custom_thumbnail_id, 'medium');
        }
        ?>

        <div class='post-card_container'>
            <div class='post-card'>

                <a href=" <?php echo $post_url ?>">

                    <!-- le conteneur de l'image -->
                    <div class='post-card_image_container'>
                        <?php echo $thumbnail ?>
                    </div>

                    <!-- le contenu -->
                    <div class=" content-zone">

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


