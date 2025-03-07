<?php
get_header();

if (have_posts()):

    echo "<section class='posts_container'>";

    while (have_posts()):

        the_post();
        echo "<div class='post-card_container'>";

        echo "<div class='post-card'>";

        echo "<a href=" . get_site_url() . "/blog/" . get_post_field("post_name") . ">";

        // le conteneur de l'image
        echo "<div class='post-card_image_container'>";
        the_post_thumbnail('medium-large');
        echo "</div>";
        the_title('<h2>', '</h2>');
        the_excerpt();
        echo "</a>";
        echo "</div>";

        echo "</div>";

    endwhile;

    echo "</section>";

endif;

get_footer();
