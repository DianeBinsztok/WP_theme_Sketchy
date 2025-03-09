<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <?php wp_body_open(); ?>
    <header id="header">
        <div id="menu_toggle-btn">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>

        <div id="above-menu-zone">
        </div>


        <div id="menu-zone">
            <div id="title-menu_container">
                <a id="site-title" href="<?php echo home_url(); ?>">My Site Title</a>
                <?php wp_nav_menu() ?>
            </div>
        </div>

    </header>
    <main>