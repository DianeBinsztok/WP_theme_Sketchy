<?php
// Les fonctionnalités supportées par le thème
add_theme_support('post-thumbnails');


// Prendre en compte le type de contenu personnalisé: Artisan
require_once(get_stylesheet_directory() . '/functions/register-CPT-artwork.php');
