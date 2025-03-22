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

        // Taxonomies liée à un artworks
        'taxonomies' => array('category', 'post_tag'),

        // Fonctionnalités disponibles dans l'éditeur d'Artwork'
        'supports' => array('title', 'thumbnail', 'excerpt', 'comments', 'custom-fields'),

        // Options supplémentaires
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
// 1 - Année de réalisation
// 2 - Techniques
// 3 - Post (si l'image est associée à un article)

// 1 - Le champs "Année de réalisation"
// 1.1 - Enregistrer le champs "year"
function add_artwork_year_metabox()
{
    add_meta_box(
        "artwork_year_metabox", // ID de la metabow
        "Année de réalisation", // Titre de la metabox
        "display_artwork_year_metabox", // Fonction callback
        "artwork", // Post type cible
        "normal", // Emplacement de la metabox
        "high" // Priorité
    );
}
add_action('add_meta_boxes', 'add_artwork_year_metabox');

// 1.2 - Afficher le champs en back-office :
function display_artwork_year_metabox($post)
{
    // Générer un champ nonce (Number Used Once) dans un formulaire HTML
    wp_nonce_field(basename(__FILE__), 'artwork_year_nonce');

    // Récupérer l'année déjà enregistrée, s'il y en a une
    $artwork_year = get_post_meta($post->ID, 'artwork_year', true);

    echo '<label for="year">Année de réalisation : </label>';
    echo '<input id="artwork_year_metabox" type="number" min="1900" max="2099" step="1" name="artwork_year" value="' . esc_attr($artwork_year) . '"/>';
}

// 1.3 - Sauvegarder la date
function save_artwork_year_meta($post_id)
{
    // Vérifie le nonce pour la sécurité
    if (!isset($_POST['artwork_year_nonce']) || !wp_verify_nonce($_POST['artwork_year_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // Évite la sauvegarde automatique
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // Vérifie les permissions de l'utilisateur
    if ('artwork' === $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
    }

    // Vérifie si l'année a été envoyée et sauvegarde la post-meta
    if (isset($_POST['artwork_year'])) {
        $artwork_year = sanitize_text_field($_POST['artwork_year']);
        update_post_meta($post_id, 'artwork_year', $artwork_year);
    } else {
        // Si aucune année n'est soumise, supprime la meta
        delete_post_meta($post_id, 'artwork_year');
    }
}
add_action('save_post', 'save_artwork_year_meta');

// 2 - Le champs "Techniques"
// 2.1 - Enregistrer le champs "techniques"
function add_artwork_techniques_metabox()
{
    add_meta_box(
        "artwork_techniques_metabox", // ID de la metabow
        "Techniques", // Titre de la metabox
        "display_artwork_techniques_metabox", // Fonction callback
        "artwork", // Post type cible
        "normal", // Emplacement de la metabox
        "high" // Priorité
    );
}
add_action('add_meta_boxes', 'add_artwork_techniques_metabox');

// 2.2 - Afficher le champs en back-office :
function display_artwork_techniques_metabox($post)
{
    // Générer un champ nonce (Number Used Once) dans un formulaire HTML
    wp_nonce_field(basename(__FILE__), 'artwork_techniques_nonce');

    // Récupérer les techniques existantes
    $existing_techniques = get_post_meta($post->ID, 'artwork_techniques', true) ?: [];
    $techniques_list = ['Feutre', 'Encre', 'Crayola', 'Pastel', 'Aquarelle', 'Huile', 'Acrylique'];

    echo '<fieldset id="artwork_techniques_metabox">';
    echo '<legend>Techniques:</legend>';

    foreach ($techniques_list as $technique) {
        $checked = in_array($technique, (array) $existing_techniques) ? 'checked' : '';
        echo '
        <div>
            <input type="checkbox" id="' . esc_attr($technique) . '" name="artwork_techniques[]" value="' . esc_attr($technique) . '" ' . $checked . ' />
            <label for="' . esc_attr($technique) . '">' . esc_html(ucfirst($technique)) . '</label>
        </div>';
    }

    echo '</fieldset>';
}

// 2.3 - Sauvegarder les techniques
function save_artwork_techniques_meta($post_id)
{
    // Vérifie le nonce pour la sécurité
    if (!isset($_POST['artwork_techniques_nonce']) || !wp_verify_nonce($_POST['artwork_techniques_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // Évite la sauvegarde automatique
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // Vérifie les permissions de l'utilisateur
    if ('artwork' === $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
    }

    // Sauvegarde les techniques
    if (isset($_POST['artwork_techniques'])) {
        $artwork_techniques = array_map('sanitize_text_field', $_POST['artwork_techniques']);
        update_post_meta($post_id, 'artwork_techniques', $artwork_techniques);
    } else {
        // Si aucune technique n'est soumise, supprime la meta
        delete_post_meta($post_id, 'artwork_techniques');
    }
}
add_action('save_post', 'save_artwork_techniques_meta');


// 3 - Post associé
// 3.1 - Enregistrer le champs "related_post_id"
function add_artwork_related_post_id_metabox()
{
    add_meta_box(
        "artwork_related_post_metabox", // ID de la metabow
        "Article associé", // Titre de la metabox
        "display_artwork_related_post_id_metabox", // Fonction callback
        "artwork", // Post type cible
        "side", // Emplacement de la metabox
        "high" // Priorité
    );
}
add_action('add_meta_boxes', 'add_artwork_related_post_id_metabox');

// 3.2 - Afficher le champs en back-office :
function display_artwork_related_post_id_metabox($post)
{
    // Générer un champ nonce (Number Used Once) dans un formulaire HTML
    wp_nonce_field(basename(__FILE__), 'artwork_related_post_id_nonce');

    // Récupérer le post associé, s'il y en a un
    $artwork_related_post_id = get_post_meta($post->ID, '_artwork_related_post_id', true);
    $posts = get_posts(array('post_type' => 'post', 'numberposts' => -1));

    echo '<select name="artwork_related_post_id">';
    echo '<option value="">-- Sélectionner un post --</option>';
    foreach ($posts as $p) {
        $selected = ($p->ID == $artwork_related_post_id) ? 'selected' : '';
        echo '<option value="' . esc_attr($p->ID) . '" ' . $selected . '>' . esc_html($p->post_title) . '</option>';
    }
    echo '</select>';
}

// 3.3 - Sauvegarder le post
function save_artwork_related_post_id_meta($post_id)
{
    // Vérifie le nonce pour la sécurité
    if (!isset($_POST['artwork_related_post_id_nonce']) || !wp_verify_nonce($_POST['artwork_related_post_id_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // Évite la sauvegarde automatique
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // Vérifie les permissions de l'utilisateur
    if ('artwork' === $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
    }

    // Vérifie si le post a été envoyée et sauvegarde la post-meta
    if (isset($_POST['artwork_related_post_id'])) {
        $artwork_related_post_id = sanitize_text_field($_POST['artwork_related_post_id']);
        update_post_meta($post_id, 'artwork_related_post_id', $artwork_related_post_id);
    } else {
        // Si aucun post associé n'est soumis, supprime la meta
        delete_post_meta($post_id, 'artwork_related_post_id');
    }
}
add_action('save_post', 'save_artwork_related_post_id_meta');