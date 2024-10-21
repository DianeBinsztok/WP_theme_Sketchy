<?php
// Les fonctionnalités supportées par le thème
add_theme_support('post-thumbnails');


// Prendre en compte le type de contenu personnalisé: Artisan
require_once(get_stylesheet_directory() . '/functions/register-CPT-artwork.php');

// Les styles
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles()
{
    if (is_archive()) {
        wp_enqueue_style('archive-artworks-style', get_template_directory_uri() . '/styles/archive-artworks.css');
    }
}
