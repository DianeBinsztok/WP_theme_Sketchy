<?php

get_header();
$args = array(
    'post_type' => 'artwork',
    'post_status' => 'publish',
    'orderby' => 'rand',
);
$artworks_query = new WP_Query($args);

if ($artworks_query->have_posts()) {

    while (have_posts()) {
        the_post();
        $post_id = get_the_ID();
        $title = get_the_title();
        $image = get_the_post_thumbnail($post_id, 'medium', ['artwork_thumbnail']);
        $artwork_year = get_post_meta($post_id, 'artwork_year', true);
        echo "
        <div>
            <h2>" . get_the_title() . "</h2>
            <p>" . get_the_excerpt() . "</p>
            <p>" . $artwork_year . "</p>
            <a href=''>$image</a>
            
        </div>
    ";
    }
}

