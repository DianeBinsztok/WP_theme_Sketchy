<?php
// I - FONCTIONNALITÉS SUPPORTÉES PAR LE THÈME
add_theme_support('post-thumbnails');

// II - STYLES
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles()
{
    // STYLES APPLIQUÉS PARTOUT
    wp_enqueue_style('global-style', get_template_directory_uri() . '/styles/global.css');
    wp_enqueue_style('header-style', get_template_directory_uri() . '/styles/header.css');
    wp_enqueue_style('footer-style', get_template_directory_uri() . '/styles/footer.css');
    wp_enqueue_style('menu-style', get_template_directory_uri() . '/styles/menu.css');

    // STYLE DE LA PAGE D'ACCUEIL
    if (is_front_page()) {
        wp_enqueue_style('front-page-style', get_template_directory_uri() . '/styles/front-page.css');
    }

    // STYLES DE LA GALERIE
    if (is_archive("artworks")) {
        wp_enqueue_style('archive-artwork-style', get_template_directory_uri() . '/styles/archive-artwork.css');
        wp_enqueue_style('archive-artwork-popup-style', get_template_directory_uri() . '/styles/archive-artwork-popup.css');
    }

    // STYLE DE LA PAGE DE BLOG
    if (is_home()) {
        wp_enqueue_style('home-blog-style', get_template_directory_uri() . '/styles/home-blog.css');
    }

    // STYLE DE L'ARTICLE DE BLOG
    if (is_single()) {
        wp_enqueue_style('single-post-style', get_template_directory_uri() . '/styles/single-post.css');
    }
}

// III - SCRIPTS FRONT
function register_and_enqueue_scripts()
{
    wp_register_script("artwork-popup-script", get_stylesheet_directory_uri() . '/scripts/artwork-popup-script.js');
    wp_register_script("burger-menu-script", get_stylesheet_directory_uri() . '/scripts/burger-menu-script.js');
    wp_register_script("header-onscroll-script", get_stylesheet_directory_uri() . '/scripts/header-onscroll-script.js');
    wp_register_script("frontpage-title-translations-script", get_stylesheet_directory_uri() . '/scripts/frontpage-title-translations-script.js');
    wp_register_script("submenu-script", get_stylesheet_directory_uri() . '/scripts/submenu-script.js');


    /* HEADER ET MENU */
    wp_enqueue_script("burger-menu-script");
    wp_enqueue_script("submenu-script");
    wp_enqueue_script("header-onscroll-script");


    /* TRANSLATIONS DU TITRE SUR LA PAGE D'ACCUEIL */
    if (is_front_page()) {
        wp_enqueue_script("frontpage-title-translations-script");
    }


    /* GALERIE DES ARTWORKS*/
    if (is_archive()) {
        wp_enqueue_script("artwork-popup-script");
    }
}
add_action('wp_enqueue_scripts', 'register_and_enqueue_scripts');

// IV - FONCTIONS CUSTOM
// Prendre en compte le type de contenu personnalisé: Artisan
require_once(get_stylesheet_directory() . '/functions/register-CPT-artwork.php');
// Ajout des post-meta post_head_img et post_custom_thumbnail
require_once(get_stylesheet_directory() . '/functions/add-post-meta.php');
// Afficher les SVG
require_once(get_stylesheet_directory() . '/functions/display-svg.php');