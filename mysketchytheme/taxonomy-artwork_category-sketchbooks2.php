<?php
// TEMPLATE ARTWORK CATEGORY - SKETCHBOOKS
get_header();

// I - LES ARGUMENTS DE LA QUERY, EN FONCTION DE PARAMÈTRES D'URL
// La requête
$args = array(
    'post_type' => 'artwork',
    'post_taxonomy' => 'artwork_category',
    'artwork_category' => 'sketchbooks',
    'post_status' => 'publish',
    'orderby' => 'rand',
    'posts_per_page' => -1,
);

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
            "categories" => get_the_terms($post, "category"),
            "related_post_id" => get_post_meta($post->ID, "artwork_related_post_id", true)
        ];
        array_push($artworks, $artwork);
        $indexInLoop++;
    }
    // Affichage en deux parties : les images et les popups. Chaque image est cliquable et déclenche une popup qui affichera des propriétés en plus : le titre, l'année, les techniques, etc.

    // Ranger les sketchbooks par date, du plus récent au plus ancien
    usort($artworks, function ($a, $b) {
        return $b['year'] <=> $a['year'];
    });
    // Pour chaque date, n'afficher qu'une image (la première rencontrée)
    $seen_years = [];
    $artworks_filtered = [];
    foreach ($artworks as $artwork) {
        if (!in_array($artwork['year'], $seen_years)) {
            $seen_years[] = $artwork['year'];
            $artworks_filtered[] = $artwork;
        }
    }
    $artworks = $artworks_filtered;

    
    // Les images

    echo "<section class='with-padding' id='gallery_clickable-artworks'>";
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

        // Afficher, en colone, le contenu de chaque artwork de la même année
       

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
?>