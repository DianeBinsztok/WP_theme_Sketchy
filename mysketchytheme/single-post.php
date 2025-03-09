<?php
$title = get_the_title();
$excerpt = get_the_excerpt();
$date = get_the_date();


get_header();
?>

<section class="with-margins" style="background-color:#ebe4c5;">
    <div style="display:flex;">
        <?php
        (the_post_thumbnail('medium'));
        ?>

        <div style="display:flex;flex-direction:column; justify-content: space-between;">
            <h1>
                <?php
                echo $title;
                ?>
            </h1>
            <div id="excerpt" style="font-weight:bold; font-size: 20px;">
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
    <?php
    the_content();
    ?>
</section>

<?php
get_footer();