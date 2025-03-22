<?php
$title = get_the_title();
$excerpt = has_excerpt() ? get_the_excerpt() : '';
$date = get_the_date("j F, Y");
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
        <?php the_post_thumbnail() ?>
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