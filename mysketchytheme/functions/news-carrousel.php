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


            //slide
            echo ('<div class="slide" style="background-image:url(' . get_the_post_thumbnail_url() . ')">');
            echo '<div id="post-infos">';

            //Titre
            echo the_title('<h3>', '</h3>');

            // Chapo d'article
            echo the_excerpt();

            // Les catégories
            /*
            echo '<div id="post-categories" style="display:flex;">';
            $post_categories = get_the_category($post_id);
            foreach ($post_categories as $category) {
                echo '<p style="border:1px solid black; padding:0.3rem 0.7rem; margin:0.5rem;">' . $category->name . '</p>';
            }
            echo '</div>';

            // La date
            echo '<div id="post-date">';
            $date = get_the_date("j F, Y");
            echo $date;
            echo '</div>';
            */

            // Lien vers l'article
            $post_url = get_permalink($post_id);
            echo '<div id="post-link_container" style="padding:3rem 0 1rem 0;">';
            echo '<a id="post-link" href="' . $post_url . '" style="display:flex; align-items:end;text-decoration:none; justify-content:center; border:1px solid black; width:fit-content; padding:0.3rem 1rem;">';
            //echo '<p> Lire l\'article</p><p style="font-size: 3em; margin:0 0 0 1rem; align-self:center;">→</p>';
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

        wp_reset_postdata();

        echo ("</section>");
    }
}