<?php

get_header();

// I - LES ARGUMENTS DE LA QUERY, EN FONCTION DE PARAMÈTRES D'URL
// La requête
$args = array(
    'post_type' => 'artwork',
    'post_status' => 'publish',
    'orderby' => 'rand',
    'posts_per_page' => -1,
);
// Si l'url contient un paramètre dynamique
if ($_GET) {

    $query_key = array_keys($_GET)[0];
    $query_slug = $_GET[$query_key];

    if ($query_key) {
        $args = match ((string) $query_key) {
            "categorie" => array(
                'post_type' => 'artwork',
                'post_status' => 'publish',
                'orderby' => 'rand',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'category',
                        'field' => 'slug',
                        'terms' => $query_slug,
                    ),
                ),
            ),
            "tags" => array(
                'post_type' => 'artwork',
                'post_status' => 'publish',
                'orderby' => 'rand',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'post_tag',
                        'field' => 'slug',
                        'terms' => $query_slug,
                    ),
                ),
            ),
            "annee" => $args = array(
                'post_type' => 'artwork',
                'post_status' => 'publish',
                'orderby' => 'rand',
                'posts_per_page' => -1,
                'meta_query' => array(
                    array(
                        'key' => 'artwork_year',
                        'value' => $query_slug,
                        'compare' => '='
                    )
                )
            ),
            "techniques" => $args = array(
                'post_type' => 'artwork',
                'post_status' => 'publish',
                'orderby' => 'rand',
                'posts_per_page' => -1,
                'meta_query' => array(
                    array(
                        'key' => 'artwork_techniques',
                        'value' => $query_slug,
                        'compare' => 'LIKE'
                    )
                )
            ),
            default => $args = array(
                'post_type' => 'artwork',
                'post_status' => 'publish',
                'orderby' => 'rand',
                'posts_per_page' => -1,
            ),
        };
    }
}

// II - LA QUERY
$artworks_query = new WP_Query($args);


// III - LE TEMPLATE
// Parcourir les résultats
if ($artworks_query->have_posts()) {
    // Récupérer les propriétés de chaque artwork
    $artworks = [];
    // Pour l'ordre d'affichage des images
    $indexInLoop = 1;
    while ($artworks_query->have_posts()) {
        $artworks_query->the_post();
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
            "tags" => get_the_tags(),
            "categories" => get_the_terms($post, "category")
        ];
        array_push($artworks, $artwork);
        $indexInLoop++;
    }

    // Affichage en deux parties : les images et les popups. Chaque image est cliquable et déclenche une popup qui affichera des propriétés en plus : le titre, l'année, les techniques, etc.

    // Les images
    echo "<section id='gallery_clickable-artworks'>";
    foreach ($artworks as $artwork) {
        echo "<div class='clickable-artwork'>";

        /* En version desktop : les informations qui apparaissent au survol de la souris*/
        echo "<img id ='" . esc_attr($artwork['slug'] . "-" . $artwork['id']) . "' src='" . esc_url($artwork['image']) . "' alt='" . esc_attr($artwork['title']) . "'/>";

        /* En version desktop : les informations qui apparaissent au survol de la souris. Portent aussi la class 'open-', pour ouvrir la poupu en cas de clic sur le texte*/
        echo "<div class='opens-" . $artwork['indexInLoop'] . " artwork_overlay'>";
        echo "<p class='opens-" . $artwork['indexInLoop'] . " artwork_title'>" . $artwork['title'] . "</p>";
        echo "<p class='opens-" . $artwork['indexInLoop'] . " artwork_year'>" . $artwork['year'] . "</p>";
        echo "</div>";

        echo "</div>";
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
        echo "<div id='goto-" . ($artwork['indexInLoop'] - 1) . "' class='popup_arrow popup_content'>&lt;</div>";


        // popup_content : l'image et les informations
        echo "<div class='popup_content_container'>";

        // popup_image : l'image
        echo "<div class='popup_image_container popup_content'/>";
        echo "<img class='popup_image popup_content' src='" . esc_url($artwork['image']) . "' alt='" . esc_attr($artwork['title']) . "'/>";
        echo "</div>";


        // popup_info : les infos
        echo "<div class='popup_info popup_content'/>";

        // Titre
        echo "<h2 class='popup_title popup_content'>" . $artwork['title'] . "</h2>";

        // Année de réalisation
        echo "<p class='popup_year popup_content'>" . $artwork['year'] . "</p>";

        // Court descriptif
        echo "<p class='popup_excerpt popup_content'>" . $artwork['excerpt'] . "</p>";

        // Techniques
        if ($artwork['techniques']) {
            echo "<div class='popup_bloc popup_content'>";
            echo "<h3 class='popup_bloc_title popup_content'>Techniques</h3>";
            echo "<p class='popup_content'>";
            foreach ($artwork['techniques'] as $technique) {
                echo $technique . " ";
            }
            echo "</p>";
            echo "</div>";
        }

        // Techniques
        if ($artwork['categories']) {
            echo "<div class='popup_bloc popup_content'>";
            echo "<h3 class='popup_bloc_title popup_content'>Catégories</h3>";
            echo "<p class='popup_content'>";
            foreach ($artwork['categories'] as $category) {
                echo $category->name . " ";
            }
            echo "</p>";
            echo "</div>";
        }

        // Tags
        if ($artwork['tags']) {
            echo "<div class='popup_bloc popup_content'>";
            echo "<h3 class='popup_bloc_title popup_content'>Tags</h3>";
            echo "<p class='popup_content'>";
            foreach ($artwork['tags'] as $tag) {
                echo $tag->name . " ";
            }
            echo "</p>";
            echo "</div>";
        }
        // Fermer popup_info
        echo "</div>";


        // Fermer popup_content
        echo "</div>";

        // popup_arrow : pour passer à l'image suivante dans la galerie
        echo "<div id='goto-" . ($artwork['indexInLoop'] + 1) . "' class='popup_arrow popup_content'>&gt;</div>";

        // Fermer popup_overlay
        echo "</div>";
    }
    echo "</section>";
}
