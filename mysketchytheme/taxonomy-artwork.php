<?php
get_header();

// La requête
// Si la requête contient une catégorie
$args = array(
    'post_type' => 'artwork',
    'post_status' => 'publish',
    'orderby' => 'rand',
    'posts_per_page' => -1,
);
$category_slug = get_query_var('category'); // récupère le slug de la catégorie
var_dump($category_slug);
if ($category_slug) {
    $args = array(
        'post_type' => 'artwork',
        'post_status' => 'publish',
        'orderby' => 'rand',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => $category_slug,
            ),
        ),
    );
    $artworks_query = new WP_Query($args);
    // Sinon : renvoyer les artworks de toutes catégories
} else {
    $args = array(
        'post_type' => 'artwork',
        'post_status' => 'publish',
        'orderby' => 'rand',
        'posts_per_page' => -1,
    );
}