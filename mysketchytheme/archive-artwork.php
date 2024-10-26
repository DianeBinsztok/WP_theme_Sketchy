<?php

get_header();

// La requête
$args = array(
    'post_type' => 'artwork',
    'post_status' => 'publish',
    'orderby' => 'rand',
);
$artworks_query = new WP_Query($args);

// Parcourir les résultats
if ($artworks_query->have_posts()) {

    // Récupérer les propriétés de chaque artwork
    $artworks = [];
    // Pour l'ordre d'affichage des images
    $indexInLoop = 1;
    while (have_posts()) {
        the_post();
        $post = get_post();
        $artwork = [
            "id" => $post->ID,
            "indexInLoop" => $indexInLoop,
            "title" => $post->post_title,
            "image" => get_the_post_thumbnail_url($post->ID),
            "year" => get_post_meta($post->ID, "artwork_year", true),
            "slug" => $post->post_name,
            "excerpt" => $post->post_excerpt,
            "techniques" => get_post_meta($post->ID, "artwork_techniques", true),
            "tags" => get_the_tags()
        ];
        array_push($artworks, $artwork);
        $indexInLoop++;
    }

    // Affichage en deux parties : les images et les popups. Chaque image est cliquable et déclenche une popup qui affichera des propriétés en plus : le titre, l'année, les techniques, etc.

    // Les images
    echo "<section id='gallery_clickable-artworks'>";
    foreach ($artworks as $artwork) {
        echo "<img class='opens-" . $artwork['indexInLoop'] . " clickable-artwork' id ='" . esc_attr($artwork['slug'] . "-" . $artwork['id']) . "' src='" . esc_url($artwork['image']) . "' alt='" . esc_attr($artwork['title']) . "'/>";
    }
    echo "</section>";


    // Les popups

    echo "<section id='gallery_artworks-popups'>";
    foreach ($artworks as $artwork) {

        // popup_overlay : pour le fond noir
        echo "<div id='" . $artwork['indexInLoop'] . "' class='popup-artwork popup_overlay hide " . esc_attr($artwork['slug'] . "-" . $artwork['id']) . "'>";

        // popup_close : pour fermer la popup
        echo "<div class='popup_close'>&times;</div>";

        // popup_arrow : pour passer à l'image précédente dans la galerie
        echo "<div id='goto-" . ($artwork['indexInLoop'] - 1) . "' class='popup_arrow'>&lt;</div>";


        // popup_content : l'image et les informations
        echo "<div class='popup_content'>";

        // popup_image : l'image
        echo "<div class='popup_image'/>";
        echo "<img src='" . esc_url($artwork['image']) . "' alt='" . esc_attr($artwork['title']) . "'/>";
        echo "</div>";


        // popup_info : les infos
        echo "<div class='popup_info'/>";

        // Titre
        echo "<h2>" . $artwork['title'] . "</h2>";

        // Année de réalisation
        echo "<p>" . $artwork['year'] . "</p>";

        // Court descriptif
        echo "<p>" . $artwork['excerpt'] . "</p>";

        // Techniques
        if ($artwork['techniques']) {
            echo "<h3>Techniques</h3>";
            echo "<p>";
            foreach ($artwork['techniques'] as $technique) {
                echo $technique . " ";
            }
            echo "</p>";
        }

        // Tags
        if ($artwork['tags']) {
            echo "<h3>Tags</h3>";
            echo "<p>";
            foreach ($artwork['tags'] as $tag) {
                echo $tag->name . " ";
            }
            echo "</p>";
        }
        // Fermer popup_info
        echo "</div>";


        // Fermer popup_content
        echo "</div>";

        // popup_arrow : pour passer à l'image suivante dans la galerie
        echo "<div id='goto-" . ($artwork['indexInLoop'] + 1) . "' class='popup_arrow'>&gt;</div>";

        // Fermer popup_overlay
        echo "</div>";
    }
    echo "</section>";
    // FIN DU TEST


}
