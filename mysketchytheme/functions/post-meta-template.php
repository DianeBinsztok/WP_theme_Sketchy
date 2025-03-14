<?php
add_action('add_meta_boxes', 'initialisation_metaboxes');
function initialisation_metaboxes()
{
  add_meta_box(
    // id de la metabox :
    "post-template",
    // Label qui désignera la metabox :
    "Template de l'article",
    // Fonction qui affiche la metabox dans le backoffice :
    "add_template_metabox",
    // Concerne les type de post : 
    "post",
    // Endroit où s'affichera la metabox :
    "side",
    // priorité d'affichage : 
    "high"
  );
}
function add_template_metabox($post)
{
  $value = get_post_meta($post->ID, '_orientation_template', true);

  echo "<fieldset>";

  echo "<legend>Template de l'article :</legend>";

  echo "<div>";
  echo "<input id='horizontal' type='radio' name='post-template' value='horizontal'/>";
  echo "<label for='horizontal'>Horizontal</label>";
  echo "</div>";

  echo "<div>";
  echo "<input id='vertical' type='radio' name='post-template' value='vertical'/>";
  echo "<label for='vertical'>Vertical</label>";

  echo "</div>";

  echo "</fieldset>";
}

add_action('save_post', 'save_orientation_metabox');
function save_orientation_metabox($post_ID)
{
  // Si la metabox est définie, on sauvegarde sa valeur
  if (isset($_POST['post-template'])) {
    update_post_meta(
      // L'id du post-meta
      $post_ID,
      // La meta-key
      '_orientation_template',
      // La valeur du post-meta
      esc_html($_POST['post-template'])
    );
  }
}
