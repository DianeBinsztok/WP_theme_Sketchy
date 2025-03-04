<?php
// Les fonctionnalités supportées par le thème
add_theme_support('post-thumbnails');

// Prendre en compte le type de contenu personnalisé: Artisan
require_once(get_stylesheet_directory() . '/functions/register-CPT-artwork.php');
require_once(get_stylesheet_directory() . '/functions/display-svg.php');

// Les styles
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles()
{
    // STYLES APPLIQUÉS PARTOUT
    wp_enqueue_style('global-style', get_template_directory_uri() . '/styles/global.css');
    wp_enqueue_style('header-style', get_template_directory_uri() . '/styles/header.css');
    wp_enqueue_style('menu-style', get_template_directory_uri() . '/styles/menu.css');

    // STYLES DE LA GALERIE
    if (is_archive()) {
        wp_enqueue_style('archive-artwork-style', get_template_directory_uri() . '/styles/archive-artwork.css');
        wp_enqueue_style('archive-artwork-popup-style', get_template_directory_uri() . '/styles/archive-artwork-popup.css');
    }

    // STYLES DE LA PAGE D'ACCUEIL
    if (is_home()) {
        wp_enqueue_style('homepage-style', get_template_directory_uri() . '/styles/homepage.css');
    }
}

// Les scripts
function register_and_enqueue_scripts()
{
    wp_register_script("artwork-popup-script", get_stylesheet_directory_uri() . '/scripts/artwork-popup-script.js');
    wp_register_script("burger-menu-script", get_stylesheet_directory_uri() . '/scripts/burger-menu-script.js');
    wp_register_script("header-onscroll-script", get_stylesheet_directory_uri() . '/scripts/header-onscroll-script.js');
    wp_register_script("home-header-onscroll-script", get_stylesheet_directory_uri() . '/scripts/home-header-onscroll-script.js');
    wp_register_script("submenu-script", get_stylesheet_directory_uri() . '/scripts/submenu-script.js');



    wp_enqueue_script("burger-menu-script");
    if (is_archive()) {
        wp_enqueue_script("artwork-popup-script");
    }
    wp_enqueue_script("header-onscroll-script");
    wp_enqueue_script("submenu-script");

}
add_action('wp_enqueue_scripts', 'register_and_enqueue_scripts');