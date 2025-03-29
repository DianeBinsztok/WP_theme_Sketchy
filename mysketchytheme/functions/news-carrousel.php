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
            $post_id = get_the_id();
            // Lien vers l'article
            $post_url = get_permalink($post_id);

            //slide
            echo '<div class="slide" style="background-image:url(' . get_the_post_thumbnail_url() . ')">';

            // Sur les versions mobiles, l'image n'est pas en arrière-plan
            echo '<div id="post-image">';
            echo '<a href="' . $post_url . '">';
            echo get_the_post_thumbnail();
            echo '</a>';
            echo '</div>';

            // Titre, extrait et lien
            echo '<div id="post-infos">';
            //Titre
            echo the_title('<h3>', '</h3>');

            // Chapo d'article
            echo the_excerpt();

            // Lien vers l'article
            echo '<div id="post-link_container">';
            echo '<a id="post-link" href="' . $post_url . '">';
            echo 'Lire l\'article  →';
            echo '</a>';
            echo '</div>';

            echo '</div>';
            echo ('</div>');
        endwhile;

        echo ('</div>');

        if ($query->post_count > 1) {
            echo ('<button id="btn-next" class="btn">></button>');
        }

        echo ("</section>");

        wp_reset_postdata();
    }
}