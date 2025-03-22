<?php
get_header();

if (have_posts()):

    echo "<section class='posts_container with-padding'>";

    while (have_posts()):

        the_post();

        // La vignette custom : une image croppée à la main au format carré
        // Si la vignette custom n'est pas définie, afficher le thumbnail défini par WP
        /*
        $thumbnail = get_the_post_thumbnail_url($post);
        $custom_thumbnail_ID = get_post_meta($post->ID, "post_custom_thumbnail");
        // Si la vignette custom est définie, afficher la vignette custom
        if ($custom_thumbnail_ID) {
            $thumbnail = $custom_thumbnail_ID;
        }
        */

        $thumbnail = get_the_post_thumbnail($post->ID);
        $post_custom_thumbnail_id = get_post_meta($post->ID, 'post_custom_thumbnail_id', true);

        if ($post_custom_thumbnail_id) {
            $thumbnail = wp_get_attachment_image($post_custom_thumbnail_id, 'medium');
        }

        ?>

        <div class='post-card_container'>
            <div class='post-card'>


                <a href=" <?php echo get_site_url() ?>/blog/<?php echo get_post_field('post_name') ?> ">

                    <!-- le conteneur de l'image -->
                    <div class='post-card_image_container'>
                        <!--<img src="<?php echo $thumbnail ?>" />-->
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


