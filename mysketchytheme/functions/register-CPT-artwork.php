<?php

/*
 * Création du Custom Post Type 'Artworks'
 */

function artwork_custom_post_type()
{

    // Les différents labels d'artisan dans l'espace d'administration:
    $labels = array(
        // Le nom au pluriel
        'name' => _x('Artworks', 'Post Type General Name'),
        // Le nom au singulier
        'singular_name' => _x('Artwork', 'Post Type Singular Name'),
        // Le libellé affiché dans le menu
        'menu_name' => __('Artworks'),
        // Les différents libellés de l'administration
        'all_items' => __('Tous les artworks'),
        'view_item' => __('Voir les artworks'),
        'add_new_item' => __('Ajouter un artwork'),
        'add_new' => __('Ajouter'),
        'edit_item' => __('Editer l\' artworks'),
        'update_item' => __('Modifier l\' artworks'),
        'search_items' => __('Rechercher un artwork'),
        'not_found' => __('Non trouvé'),
        'not_found_in_trash' => __('Non trouvé dans la corbeille'),
    );

    // Autres options
    $args = array(
        'label' => __('Artworks'),
        'description' => __('Tout les travaux'),
        'labels' => $labels,
        // Options disponibles dans l'éditeur d'Artwork'
        'supports' => array('title', 'editor', 'category', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        /* 
         * Différentes options supplémentaires
         */
        'menu_icon' => 'dashicons-art',
        'show_in_rest' => true,
        'hierarchical' => false,
        'public' => true,
        'has_archive' => 'artworks',
        /*Equivalent de :
       'has_archive' => true,
       'rewrite' => array('slug' => 'artworks'),*/
    );

    // Enregistrement du custom post type "artisan" et ses arguments
    register_post_type('artwork', $args);

}

add_action('init', 'artwork_custom_post_type', 0);