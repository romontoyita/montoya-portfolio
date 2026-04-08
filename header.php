<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header id="masthead" class="site-header">
    <div class="container">
        <?php if ( has_custom_logo() ) the_custom_logo(); else bloginfo( 'name' ); ?>
        <nav id="site-navigation" aria-label="<?php esc_attr_e( 'Primary', 'montoya-portfolio' ); ?>">
            <?php wp_nav_menu( [ 'theme_location' => 'primary', 'container' => false ] ); ?>
        </nav>
    </div>
</header>
<main id="main" class="site-main">
