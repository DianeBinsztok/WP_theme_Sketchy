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
        echo ('<section id="slider-section">');

        if ($query->post_count > 1) {
            echo ('<button id="btn-prev" class="btn"><</button>');
        }

        //slider
        //echo ('<div id="slider_container">');
        echo ('<div id="slider">');


        while ($query->have_posts()):
            $query->the_post();

            //slide
            echo ('<div class="slide" style="background-image:url(' . get_the_post_thumbnail_url() . ')">');
            //echo ('<div class="slide">');
            //echo the_post_thumbnail("large");
            echo '<div id="post-infos">';
            echo the_title('<h3>', '</h3>');
            echo the_excerpt();
            echo '</div>';
            echo ('</div>');
        endwhile;

        echo ('</div>');
        //echo ('</div>');

        if ($query->post_count > 1) {
            echo ('<button id="btn-next" class="btn">></button>');
        }

        wp_reset_postdata();

        echo ("</section>");
    }
}