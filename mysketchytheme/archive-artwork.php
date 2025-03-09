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
    echo "<section class='with-margins' id='gallery_clickable-artworks'>";
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


        // POPUP_OVERLAY : pour le fond noir
        echo "<div id='" . $artwork['indexInLoop'] . "' class='popup-artwork popup_overlay hide " . esc_attr($artwork['slug'] . "-" . $artwork['id']) . "'>";


        // I - POPUP_HEAD : l'en-tête qui contient l'onglet de fermeture

        // popup_close : pour fermer la popup
        echo "<div class='popup_close'>&times;</div>";

        // POPUP_CONTENT_CONTAINER
        echo "<div class='popup_content_container'>";

        // II.1 - popup_nav - pour l'image précédente
        echo "<section class='popup_nav'>";
        // goto
        echo "<div id='goto-" . ($artwork['indexInLoop'] - 1) . "' class='popup_arrow'>&lt;</div>";
        // Fermer popup_nav
        echo "</section>";

        // II.2 - popup_content
        echo "<section class='popup_content'>";

        // 1 - popup_image : l'image
        echo "<div class='popup_image_container'/>";
        echo "<img class='popup_image' src='" . esc_url($artwork['image']) . "' alt='" . esc_attr($artwork['title']) . "'/>";
        echo "</div>";

        // 2 - popup_info : les infos
        echo "<div class='popup_info'/>";
        // bloc 1 : titre, année de réalisation et excerpt
        echo "<div class='popup_head_bloc'>";

        // Titre
        echo "<h2 class='popup_title'>" . $artwork['title'] . "</h2>";

        // Année de réalisation
        echo "<a class='popup_filter_link popup_year' href='" . site_url('/artworks/?annee=' . $artwork['year']) . "'>" . displaySvg("year") . " " . $artwork['year'] . "</a>";

        // Court descriptif
        echo "<p class='popup_excerpt'>" . $artwork['excerpt'] . "</p>";

        // Fermer bloc 1
        echo "</div>";

        // Techniques
        if ($artwork['techniques']) {

            echo "<div class='popup_bloc'>";

            echo "<h3 class='popup_bloc_title'>Techniques</h3>";
            echo "<p>";
            foreach ($artwork['techniques'] as $technique) {
                echo "<a class='popup_filter_link' href=" . site_url('/artworks/?techniques=' . $technique) . ">" . displaySvg("techniques") . " " . $technique . "</a> ";
            }
            echo "</p>";

            echo "</div>";
        }

        // Catégories
        if ($artwork['categories']) {
            echo "<div class='popup_bloc'>";
            echo "<h3 class='popup_bloc_title'>Catégories</h3>";
            echo "<p>";
            foreach ($artwork['categories'] as $category) {
                echo "<a class='popup_filter_link' href=" . site_url('/artworks/?categorie=' . $category->slug) . ">" . displaySvg("categories") . " " . $category->name . "</a> ";

            }
            echo "</p>";
            echo "</div>";
        }

        // Tags
        if ($artwork['tags']) {
            echo "<div class='popup_bloc'>";
            echo "<h3 class='popup_bloc_title'>Tags</h3>";
            echo "<p>";
            foreach ($artwork['tags'] as $tag) {
                echo "<a class='popup_filter_link' href=" . site_url('/artworks/?tags=' . $tag->slug) . ">" . displaySvg("tags") . " " . $tag->name . "</a> ";
            }
            echo "</p>";
            echo "</div>";
        }
        // fermer popup_info
        echo "</div>";

        // Fermer popup_content
        echo "</section>";


        // II.3 popup_nav - pour l'image suivante
        echo "<section class='popup_nav'>";
        // goto
        echo "<div id='goto-" . ($artwork['indexInLoop'] + 1) . "' class='popup_arrow'>&gt;</div>";
        // Fermer popup_nav
        echo "</section>";

        // Fermer popup_container 
        echo "</div>";

        // Fermer popup_overlay 
        echo "</div>";
    }
    echo "</section>";
}

get_footer();
