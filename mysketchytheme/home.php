<?php
get_header();

if (have_posts()):

    echo "<section class='posts_container with-padding'>";

    while (have_posts()):

        the_post();
        ?>

        <div class='post-card_container'>
            <div class='post-card'>
                <a href=" <?php echo get_site_url() ?>/blog/<?php echo get_post_field('post_name') ?> ">

                    <!-- le conteneur de l'image -->
                    <div class='post-card_image_container'>
                        <?php the_post_thumbnail('medium-large') ?>
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


