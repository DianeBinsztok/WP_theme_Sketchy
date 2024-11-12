<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <?php wp_body_open(); ?>
    <header>
        <div id="header-container">
            <a id="site-title_full" href="<?php echo home_url(); ?>" ?>Sketchy</a>
            <a id="site-title_mini" href="<?php echo home_url(); ?>" ?>S</a>
            <div id="menu">
                <?php wp_nav_menu() ?>
            </div>
            <?= displaySvg('burger') ?>
        </div>
    </header>
    <main>