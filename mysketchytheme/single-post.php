<?php
$title = get_the_title();
$excerpt = get_the_excerpt();
$date = get_the_date("j F, Y");


get_header();
?>

<section id="post-head_container" class="with-margins">
    <div id="post-head-content">
        <div id="post-thumbnail_container">
            <?php
            (the_post_thumbnail('medium large'));
            ?>
        </div>

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

    </div>

</section>

<section class="with-margins">
    <div id="content">
        <?php
        the_content();
        ?>
    </div>

</section>

<?php
get_footer();