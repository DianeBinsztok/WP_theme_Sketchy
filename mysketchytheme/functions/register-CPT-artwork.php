<?php

/*
 * CUSTOM POST TYPE ARTWORK
 */

// I - CRÉATION DU CUSTOM POST TYPE 'ARTWORK'
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


// II - AJOUT DES CHAMPS DU CPT

// 1 - Le champs Image
// 1.1 - Enregistrer le champs "Image"
function add_artwork_image_metabox()
{
    add_meta_box(
        "artwork_image_metabox", // ID de la metabow
        "Image", // Titre de la metabox
        "display_artwork_image_metabox", // Fonction callback
        "artwork", // Post type cible
        "normal", // Emplacement de la metabox
        "high" // Priorité
    );
}
add_action('add_meta_boxes', 'add_artwork_image_metabox');

// 2.1 - Afficher le champs en back-office : enregistrement d'un artwork
function display_artwork_image_metabox($post)
{
    // Récupère la valeur actuelle du champ personnalisé
    $artwork_image_url = get_post_meta($post->ID, '_artwork_image_url', true);
    ?>
    <label for="artwork_image_url">URL de l'image :</label>
    <input type="text" name="artwork_image_url" id="artwork_image_url" value="<?php echo esc_attr($artwork_image_url); ?>"
        size="50" />
    <?php
}
