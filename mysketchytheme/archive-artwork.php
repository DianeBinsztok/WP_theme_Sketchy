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
    while (have_posts()) {
        the_post();
        $post = get_post();
        $artwork = [
            "id" => $post->ID,
            "title" => $post->post_title,
            "image" => get_the_post_thumbnail_url($post->ID),
            "year" => get_post_meta($post->ID, "artwork_year", true),
            "slug" => $post->post_name,
            "excerpt" => $post->post_excerpt,
            "techniques" => get_post_meta($post->ID, "artwork_techniques", true),
            "tags" => get_the_tags()
        ];

        array_push($artworks, $artwork);
    }

    // Affichage en deux parties : les images et les popups. Chaque image est cliquable et déclenche une popup qui affichera des propriétés en plus : le titre, l'année, les techniques, etc.

    // Les images
    echo "<section id='gallery_clickable-artworks'>";
    foreach ($artworks as $artwork) {
        echo "<a class='clickable-artwork' href='#" . esc_attr($artwork['slug'] . "-" . $artwork['id']) . "'>
        <img class='' src='" . esc_url($artwork['image']) . "' alt='" . esc_attr($artwork['title']) . "' style='max-width:450px'/>
        </a>";
    }
    echo "</section>";

    // Les popups
    echo "<section id='gallery_artworks-popups'>";
    foreach ($artworks as $artwork) {

        // popup_overlay : pour le fond noir
        echo "<div id='" . esc_attr($artwork['slug'] . "-" . $artwork['id']) . "' src='" . esc_url($artwork['image']) . "' class='popup_overlay'>";

        // popup_close : pour fermer la popup
        echo "<a class='popup_close' href='#'>&times;</a>";

        // popup_arrow : pour passer à l'image précédente dans la galerie
        echo "<a href='#' class='popup_arrow'>&lt;</a>";


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

        echo "</div>";


        // Fermer popup_content
        echo "</div>";

        // popup_arrow : pour passer à l'image suivante dans la galerie
        echo "<a href='#' class='popup_arrow'>&gt;</a>";

        // Fermer popup_overlay
        echo "</div>";


    }
    echo "</section>";
}
