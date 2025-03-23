<?php
//SLIDER D'UNE SÉLECTION DES DERNIERS POSTS
function display_latest_news_in_slider()
{
    $args = array(
        //'numberposts' => -1,
        'post_type' => 'post',
        'posts_per_page' => 3
    );

    $query = new WP_Query($args);
    if ($query->have_posts()) {
        echo ('<section style="display:flex;">');

        if ($query->post_count > 1) {
            echo ("<button class='btn btn-prev'>précédent</button>");
        }

        //slider
        echo ('<div class="slider" style="display:flex;width:100%; overflow:hidden;">');

        while ($query->have_posts()):
            $query->the_post();

            //slide
            echo ('<div class="slide" style="min-width:100%; height:auto">');
            echo the_post_thumbnail("large");
            echo the_title();
            echo ('</div>');
        endwhile;

        echo ('</div>');

        if ($query->post_count > 1) {
            echo ("<button class='btn btn-next'>suivant</button>");
        }

        wp_reset_postdata();

        echo ("</section>");
    }
}
