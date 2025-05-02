<?php
/*
 * Template Name: Sketchy-About
 */
get_header();
?>

<section class="with-padding">
    <section id="about-head">
        <?php
        the_post_thumbnail();
        ?>
        <h1>C'est parti, je raconte ma vie !</h1>
    </section>

    <section id="about-content">
        <?php
        the_content();
        ?>
    </section>


</section>
<?php
get_footer();
?>