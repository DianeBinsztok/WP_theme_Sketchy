<?php
/**
 * Ajouter un meta au post pour des formats d'image spécifiques : ici, le thumnail carré, centré sur un endroit spécifique de l'image
 * (la méthode add_image_size ne permet pas de décider précisément où cropper l'image : elles seront croppées et enregistrées en amont) 
 */

// I - Enregistrer la meta vignette custom
function add_custom_thumbnail_metabox()
{
    add_meta_box(
        "post_custom_thumbnail_id", // ID de la metabox
        "Vignette carrée, centrée spécifiquement", // Titre de la metabox
        "display_post_custom_thumbnail_metabox", // Fonction callback
        "post", // Post type cible
        "side", // Emplacement de la metabox
        "high" // Priorité
    );
}
add_action('add_meta_boxes', 'add_custom_thumbnail_metabox');

// II - Afficher le champs de vignette custom en back-office :
function display_post_custom_thumbnail_metabox($post)
{
    // Générer un champ nonce pour la sécurité
    wp_nonce_field(basename(__FILE__), 'post_custom_thumbnail_id_nonce');

    // Récupérer l'image déjà enregistrée, s'il y en a une
    $post_custom_thumbnail_id = get_post_meta($post->ID, 'post_custom_thumbnail_id', true);

    // Récupérer l'URL de l'image si un ID est enregistré
    $image_url = $post_custom_thumbnail_id ? wp_get_attachment_url($post_custom_thumbnail_id) : '';

    ?>
    <div>
        <label for="post_custom_thumbnail_id">Vignette carrée, centrée spécifiquement</label>
        <div id="custom-thumbnail-container">
            <img id="custom-thumbnail-preview" src="<?php echo esc_url($image_url); ?>"
                style="max-width:100%; <?php echo $image_url ? '' : 'display:none;'; ?>">
        </div>
        <input type="hidden" id="post-custom-thumbnail-id" name="post_custom_thumbnail_id"
            value="<?php echo esc_attr($post_custom_thumbnail_id); ?>">
        <button type="button" class="button button-secondary"
            id="upload-custom-thumbnail"><?php echo $image_url ? 'Changer l\'image' : 'Choisir une image'; ?></button>
        <button type="button" class="button button-secondary" id="remove-custom-thumbnail"
            style="<?php echo $image_url ? '' : 'display:none;'; ?>">Supprimer</button>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let mediaUploader;

            document.getElementById("upload-custom-thumbnail").addEventListener("click", function (e) {
                e.preventDefault();

                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }

                mediaUploader = wp.media({
                    title: "Choisir une image",
                    button: { text: "Utiliser cette image" },
                    multiple: false
                });

                mediaUploader.on("select", function () {
                    let attachment = mediaUploader.state().get("selection").first().toJSON();
                    document.getElementById("post-custom-thumbnail-id").value = attachment.id;
                    let preview = document.getElementById("custom-thumbnail-preview");
                    preview.src = attachment.url;
                    preview.style.display = "block";
                    document.getElementById("upload-custom-thumbnail").textContent = "Changer l'image";
                    document.getElementById("remove-custom-thumbnail").style.display = "inline-block";
                });

                mediaUploader.open();
            });

            document.getElementById("remove-custom-thumbnail").addEventListener("click", function () {
                document.getElementById("post-custom-thumbnail-id").value = "";
                document.getElementById("custom-thumbnail-preview").style.display = "none";
                document.getElementById("upload-custom-thumbnail").textContent = "Choisir une image";
                this.style.display = "none";
            });
        });
    </script>
    <?php
}

// III - Sauvegarder la vignette
function save_post_custom_thumbnail_meta($post_id)
{
    // Vérifie le nonce pour la sécurité
    if (!isset($_POST['post_custom_thumbnail_id_nonce']) || !wp_verify_nonce($_POST['post_custom_thumbnail_id_nonce'], basename(__FILE__))) {
        error_log('Le nonce ne correspond pas' . $post_id);
        return;
    }

    // Évite la sauvegarde automatique
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        error_log('L autosave est défini' . $post_id);
        return;
    }

    // Vérifie les permissions de l'utilisateur
    if (!current_user_can('edit_post', $post_id)) {
        error_log('Problème de permission' . $post_id);
        return;
    }

    // Vérifie si la valeur de post_custom_thumbnail_id a été envoyée
    if (!empty($_POST['post_custom_thumbnail_id'])) {
        // Assurer que l'id de l'image sélectionnée est bien un entier valide
        $post_custom_thumbnail_id = intval($_POST['post_custom_thumbnail_id']);
        if ($post_custom_thumbnail_id > 0) {

            error_log('Valeur reçue pour post_custom_thumbnail_id : ' . $_POST['post_custom_thumbnail_id']);

            update_post_meta($post_id, 'post_custom_thumbnail_id', $post_custom_thumbnail_id);
        } else {
            delete_post_meta($post_id, 'post_custom_thumbnail_id');
        }
    } else {
        // Si aucun ID n'est soumis, supprimer la meta
        delete_post_meta($post_id, 'post_custom_thumbnail_id');
    }
}
add_action('save_post', 'save_post_custom_thumbnail_meta');
