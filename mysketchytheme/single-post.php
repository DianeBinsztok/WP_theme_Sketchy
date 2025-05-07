<?php
$title = get_the_title();
$excerpt = has_excerpt() ? get_the_excerpt() : '';
$date = get_the_date("j F, Y");


// VERSION MOBILE : IMAGE CARRÉE
// Récupérer le post-meta "post_img_custom_square_id" s'il existe
$post_custom_img_square_id = get_post_meta($post->ID, "post_img_custom_square_id", true);

// Voir si un custom_img_square est enregistré
if ($post_custom_img_square_id) {
    $post_custom_img_square = wp_get_attachment_image($post_custom_img_square_id, "medium");
    // Si custom_img_square n'a pas été renseigné, utiliser le thumbnail par défaut     
} else {
    $post_custom_img_square = get_the_post_thumbnail($post->ID, "medium");
}

// VERSIONS LARGES : IMAGE LARGE
$post_custom_img_large_id = get_post_meta($post->ID, "post_img_custom_large_id", true);

// Voir si un custom_img_large est enregistré
if ($post_custom_img_large_id) {
    $post_custom_img_large_url = wp_get_attachment_image_url($post_custom_img_large_id, 'large');
    // Si custom_img_large n'a pas été renseigné, utiliser la featured image par défaut  
} else {
    $post_custom_img_large_url = get_the_post_thumbnail_url($post_id, 'large');
}

get_header();
?>
<!-- EN-TÊTE MOBILE -->
<section id="post-head_mobile" class="with-padding">
    <div id="post-head_img">
        <?php echo $post_custom_img_square ?>
    </div>

    <section id="post-head_info_container" class="with-padding">
        <div id="title-excerpt-date_container">
            <h1 id="title">
                <?php
                echo $title;
                ?>
            </h1>
            <div id="excerpt">
                <?php
                echo $excerpt;
                ?>
            </div>
            <div id="date" style="font-style:italic">
                <?php
                echo $date;
                ?>
            </div>
        </div>
    </section>
</section>

<!-- EN-TÊTE TABLETTES ET DESKTOP -->
<section id="post-head_large" class="with-padding"
    style="background-image: url(<?php echo $post_custom_img_large_url ?>);">
    <div id="title-excerpt-date_container">
        <h1 id="title">
            <?php
            echo $title;
            ?>
        </h1>
        <div id="excerpt">
            <?php
            echo $excerpt;
            ?>
        </div>

        <div id="date" style="font-style:italic">
            <?php
            echo $date;
            ?>
        </div>
    </div>
</section>

<section class="with-padding">
    <div id="content">
        <?php
        the_content();
        ?>
    </div>

</section>
<?php
get_footer();