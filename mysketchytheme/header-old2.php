<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <?php wp_body_open(); ?>

    <header id="home-header">
        <div id="home-onscroll-header" class="onstart">
            <div id="site-title-onscroll_container">
                <a id="site-title-onscroll" href="<?php echo home_url(); ?>" ?>Sketchy</a>
            </div>
            <?php wp_nav_menu() ?>

            <div id="menu_toggle-btn">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
        <div id="site-title_container">
            <a id="site-title" class="onstart" href="<?php echo home_url(); ?>" ?>Sketchy</a>
        </div>
    </header>
    <main>