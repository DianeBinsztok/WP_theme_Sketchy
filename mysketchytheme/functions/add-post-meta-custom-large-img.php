<?php
/**
 * Ajouter un meta au post pour des formats d'image spécifiques : ici, une forme en bannière large, pour les en-tête d'articles et peut-être le carrousel des dernier articles, sur écran large
 * L'image sera recadrée sur un endroit spécifique de l'image
 * (la méthode add_image_size ne permet pas de décider précisément où cropper l'image : elles seront croppées et enregistrées en amont) 
 */

// I - Enregistrer la meta custom_img_large

// post_custom_thumbnail_id
function add_custom_img_large_metabox()
{
    add_meta_box(
        "post_img_custom_large_id", // ID de la metabox
        "Image large, en forme de bandeau horizontal", // Titre de la metabox
        "display_post_img_custom_large_metabox", // Fonction callback
        "post", // Post type cible
        "side", // Emplacement de la metabox
        "high" // Priorité
    );
}
add_action('add_meta_boxes', 'add_custom_img_large_metabox');

// II - Afficher le champs de vignette custom en back-office :
function display_post_img_custom_large_metabox($post)
{
    // Générer un champ nonce pour la sécurité
    wp_nonce_field(basename(__FILE__), 'post_img_custom_large_id_nonce');

    // Récupérer l'image déjà enregistrée, s'il y en a une
    $post_img_custom_large_id = get_post_meta($post->ID, 'post_img_custom_large_id', true);

    // Récupérer l'URL de l'image si un ID est enregistré
    $image_url = $post_img_custom_large_id ? wp_get_attachment_url($post_img_custom_large_id) : '';

    ?>
    <div>
        <label for="post_img_custom_large_id">Image horizontale, en forme de bannière</label>

        <!-- Afficher l'image sélectionnée s'il y en a une-->
        <div id="img-custom-large-container">
            <img id="img-custom-large-preview" src="<?php echo esc_url($image_url); ?>"
                style="max-width:100%; <?php echo $image_url ? '' : 'display:none;'; ?>">
        </div>

        <!-- On envoie l'id de l'image sélectionnée-->
        <input type="hidden" id="post-img-custom-large-id" name="post_img_custom_large_id"
            value="<?php echo esc_attr($post_img_custom_large_id); ?>">

        <!-- Le bouton qui déclenche l'ouverture de la bibliothèque de média-->
        <button type="button" class="button button-secondary"
            id="upload-img-custom-large"><?php echo $image_url ? 'Changer l\'image' : 'Choisir une image'; ?></button>

        <!-- Si une image n'est pas déjà sélectionnée-->
        <button type="button" class="button button-secondary" id="remove-img-custom-large"
            style="<?php echo $image_url ? '' : 'display:none;'; ?>">Supprimer</button>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            let mediaUploader;

            // Aller chercher le bouton pour ouvrir la bibliothèque de media
            document.getElementById("upload-img-custom-large").addEventListener("click", function (event) {
                event.preventDefault();

                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }

                // Utiliser l'API wp.media
                mediaUploader = wp.media({
                    title: "Choisir une image",
                    button: { text: "Utiliser cette image" },
                    multiple: false
                });

                mediaUploader.on("select", function () {

                    // Récupérer l'image unique ('first') dans la bilibothèque de media (le param de state() est 'livrary' par défaut)
                    let attachment = mediaUploader.state().get("selection").first().toJSON();
                    document.getElementById("post-img-custom-large-id").value = attachment.id;
                    let preview = document.getElementById("img-custom-large-preview");
                    preview.src = attachment.url;
                    preview.style.display = "block";
                    document.getElementById("upload-img-custom-large").textContent = "Changer l'image";
                    document.getElementById("remove-img-custom-large").style.display = "inline-block";
                });

                mediaUploader.open();
            });

            document.getElementById("remove-img-custom-large").addEventListener("click", function () {
                document.getElementById("post-img-custom-large-id").value = "";
                document.getElementById("img-custom-large-preview").style.display = "none";
                document.getElementById("upload-img-custom-large").textContent = "Choisir une image";
                this.style.display = "none";
            });
        });
    </script>
    <?php
}

// III - Sauvegarder la vignette
function save_post_img_custom_large_meta($post_id)
{
    // Vérifie le nonce pour la sécurité
    if (!isset($_POST['post_img_custom_large_id_nonce']) || !wp_verify_nonce($_POST['post_img_custom_large_id_nonce'], basename(__FILE__))) {
        error_log('Le nonce ne correspond pas' . $post_id);
        return;
    }

    // Évite la sauvegarde automatique
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        error_log('L\'autosave est défini' . $post_id);
        return;
    }

    // Vérifie les permissions de l'utilisateur
    if (!current_user_can('edit_post', $post_id)) {
        error_log('Problème de permission' . $post_id);
        return;
    }

    // Vérifie si la valeur de post_img_custom_large_id a été envoyée
    if (!empty($_POST['post_img_custom_large_id'])) {
        // Assurer que l'id de l'image sélectionnée est bien un entier valide
        $post_img_custom_large_id = intval($_POST['post_img_custom_large_id']);
        if ($post_img_custom_large_id > 0) {

            error_log('Valeur reçue pour post_img_custom_large_id : ' . $_POST['post_img_custom_large_id']);

            update_post_meta($post_id, 'post_img_custom_large_id', $post_img_custom_large_id);
        } else {
            delete_post_meta($post_id, 'post_img_custom_large_id');
        }
    } else {
        // Si aucun ID n'est soumis, supprimer la meta
        delete_post_meta($post_id, 'post_img_custom_large_id');
    }
}
add_action('save_post', 'save_post_img_custom_large_meta');