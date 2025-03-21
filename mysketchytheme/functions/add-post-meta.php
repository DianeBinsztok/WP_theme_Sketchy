<?php
/**
 * Ajouter un meta au post pour des formats d'image spécifiques : ici, le thumnail carré, centré sur un endroit spécifique de l'image
 * (la méthode add_image_size ne permet pas de décider précisément où cropper l'image : elles seront croppées et enregistrées en amont) 
 */

// I - Enregistrer la metabox
function add_custom_thumbnail_metabox()
{
    add_meta_box(
        "post_custom_thumbnail_meta", // ID de la metabox
        "Vignette carrée, centrée spécifiquement", // Titre de la metabox
        "display_post_custom_thumbnail_metabox", // Fonction callback
        "post", // Post type cible
        "side", // Emplacement de la metabox
        "high" // Priorité
    );
}
add_action('add_meta_boxes', 'add_custom_thumbnail_metabox');

// II - Afficher le champs en back-office :
function display_post_custom_thumbnail_metabox($post)
{
    // Générer un champ nonce (Number Used Once) dans un formulaire HTML
    wp_nonce_field(basename(__FILE__), 'post_custom_thumbnail_nonce');

    // Récupérer l'image déjà enregistrée, s'il y en a une
    $post_custom_thumbnail = get_post_meta($post->ID, 'post_custom_thumbnail', true);

    // Juste une url pour tester
    echo '<label for="post_custom_thumbnail">Vignette carrée, centrée spécifiquement</label>';
    echo '<input id="post_custom_thumbnail_meta" name="post_custom_thumbnail" type="text" class="is-next-40px-default-size" value="' . $post_custom_thumbnail . '">';
}

// I.3 - Sauvegarder l'image d'en-tête'
function save_post_custom_thumbnail_meta($post_id)
{
    // Vérifie le nonce pour la sécurité
    if (!isset($_POST['post_custom_thumbnail_nonce']) || !wp_verify_nonce($_POST['post_custom_thumbnail_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // Évite la sauvegarde automatique
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // Vérifie les permissions de l'utilisateur
    if ('post' === $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
    }

    // Vérifie si la valeur de post_custom_thumbnail a été envoyée et sauvegarde la post-meta
    if (isset($_POST['post_custom_thumbnail'])) {
        $post_custom_thumbnail = sanitize_text_field($_POST['post_custom_thumbnail']);
        update_post_meta($post_id, 'post_custom_thumbnail', $post_custom_thumbnail);
    } else {
        // Si aucune image n'est soumise, supprime la meta
        delete_post_meta($post_id, 'post_custom_thumbnail');
    }
}
add_action('save_post', 'save_post_custom_thumbnail_meta');