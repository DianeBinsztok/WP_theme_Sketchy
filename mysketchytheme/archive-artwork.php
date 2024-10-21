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
        $image = get_the_post_thumbnail_url($post->ID);
        $artwork = [
            "id" => $post->ID,
            "title" => $post->post_title,
            "image" => $image,
            "year" => get_post_meta($post->ID, "artwork_year", true),
            "slug" => $post->post_name,
            "excerpt" => $post->post_excerpt,
        ];
        array_push($artworks, $artwork);
    }

    // Affichage en deux parties : les images et les popups. Chaque image est cliquable et déclenche une popup qui affichera des propriétés en plus : le titre, l'année, les techniques, etc.

    // Les images
    echo "<section id='gallery_clickable-artworks'>";
    foreach ($artworks as $artwork) {
        echo "<a class='clickable-artwork' href='#" . esc_attr($artwork['slug'] . "-" . $artwork['id']) . "'><img class='' src='" . esc_url($artwork['image']) . "' alt='" . esc_attr($artwork['title']) . "' style='max-width:450px'/></a>";
    }
    echo "</section>";

    // Les popups
    echo "<section id='gallery_artworks-popups'>";
    foreach ($artworks as $artwork) {
        echo "<img class='artwork-popup' id='" . esc_attr($artwork['slug'] . "-" . $artwork['id']) . "' src='" . esc_url($artwork['image']) . "' alt='" . esc_attr($artwork['title']) . "' style='max-width:500px'/>";
    }
    echo "</section>";
}
