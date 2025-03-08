<?php
// Les fonctionnalités supportées par le thème
add_theme_support('post-thumbnails');

// L'url des pages relatives au blog
function blog_permalinks_structure()
{
    // Vérifie si le type de publication est un post
    if (is_singular('post')) {
        add_rewrite_rule('^blog/([^/]+)/?$', 'index.php?name=$matches[1]', 'top');
    }
}
//add_action('init', 'blog_permalinks_structure');


// Prendre en compte le type de contenu personnalisé: Artisan
require_once(get_stylesheet_directory() . '/functions/register-CPT-artwork.php');
require_once(get_stylesheet_directory() . '/functions/display-svg.php');

// Les styles
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles()
{
    // STYLES APPLIQUÉS PARTOUT
    wp_enqueue_style('global-style', get_template_directory_uri() . '/styles/global.css');
    //wp_enqueue_style('header-style', get_template_directory_uri() . '/styles/header.css');
    wp_enqueue_style('footer-style', get_template_directory_uri() . '/styles/footer.css');

    wp_enqueue_style('menu-style', get_template_directory_uri() . '/styles/menu.css');

    // STYLES DE LA GALERIE
    if (is_archive("artworks")) {
        wp_enqueue_style('archive-artwork-style', get_template_directory_uri() . '/styles/archive-artwork.css');
        wp_enqueue_style('archive-artwork-popup-style', get_template_directory_uri() . '/styles/archive-artwork-popup.css');
    }

    // STYLE DE LA PAGE DE BLOG
    if (is_home()) {
        wp_enqueue_style('home-blog-style', get_template_directory_uri() . '/styles/home-blog.css');
    }
    // STYLE DE LA PAGE D'ACCUEIL
    if (is_front_page()) {
        wp_enqueue_style('frontpage-header-style', get_template_directory_uri() . '/styles/frontpage-header.css');
        wp_enqueue_style('front-page-style', get_template_directory_uri() . '/styles/front-page.css');

    }
    // STYLE DES AUTRES PAGES
    else {
        wp_enqueue_style('header-style', get_template_directory_uri() . '/styles/header.css');
    }
}

// Les scripts
function register_and_enqueue_scripts()
{
    wp_register_script("artwork-popup-script", get_stylesheet_directory_uri() . '/scripts/artwork-popup-script.js');
    wp_register_script("burger-menu-script", get_stylesheet_directory_uri() . '/scripts/burger-menu-script.js');
    wp_register_script("header-onscroll-script", get_stylesheet_directory_uri() . '/scripts/header-onscroll-script.js');
    wp_register_script("frontpage-header-onscroll-script", get_stylesheet_directory_uri() . '/scripts/frontpage-header-onscroll-script.js');
    wp_register_script("submenu-script", get_stylesheet_directory_uri() . '/scripts/submenu-script.js');


    /* LE MENU */
    wp_enqueue_script("burger-menu-script");
    wp_enqueue_script("submenu-script");

    /* FIXER LE HEADER AU SCROLL*/
    // Animations pour la page d'accueil
    if (is_front_page()) {
        wp_enqueue_script("frontpage-header-onscroll-script");
    }
    // Pour les autres pages
    else {
        wp_enqueue_script("header-onscroll-script");
    }


    /* GALERIE DES ARTWORKS*/
    if (is_archive()) {
        wp_enqueue_script("artwork-popup-script");
    }
}
add_action('wp_enqueue_scripts', 'register_and_enqueue_scripts');