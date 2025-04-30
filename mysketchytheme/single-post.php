<?php
$title = get_the_title();
$excerpt = has_excerpt() ? get_the_excerpt() : '';
$date = get_the_date("j F, Y");

// Pour les versions mobile : aller chercher le thumbnail custom: une image croppée à la main au format carré
// Si la vignette custom n'est pas définie, afficher le thumbnail défini par WP
$thumbnail = get_the_post_thumbnail($post->ID);
$post_custom_thumbnail_id = get_post_meta($post->ID, 'post_custom_thumbnail_id', true);

if ($post_custom_thumbnail_id) {
    $thumbnail = wp_get_attachment_image($post_custom_thumbnail_id, 'medium');
}

/*
$custom_thumbnail_id = get_post_meta($post->ID, "post_custom_thumbnail_id");
if (count($custom_thumbnail_id) > 0) {
    $custom_thumbnail_url = wp_get_attachment_image_url($custom_thumbnail_id[0]);
} else {
    $custom_thumbnail_url = get_the_post_thumbnail_url($post->ID);
}
    */

get_header();
?>
<section id="post-head_large" class="with-padding"
    style="background-image: url(<?php echo get_the_post_thumbnail_url($post->ID) ?>);">
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

<section id="post-head_mobile" class="with-padding">
    <div id="post-head_img">
        <!--<img src="<?php echo $thumbnail ?>" alt="">-->
        <?php echo $thumbnail ?>
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

<section class="with-padding">
    <div id="content">
        <?php
        the_content();
        ?>
    </div>

</section>
<?php
get_footer();