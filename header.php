<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'montoya-portfolio' ); ?></a>

<header id="masthead" class="site-header" role="banner">
    <div class="site-header__inner container">

        <a class="site-header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> &mdash; <?php esc_attr_e( 'Home', 'montoya-portfolio' ); ?>">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <img
                    src="<?php echo esc_url( MONTOYA_URI . '/assets/images/logo.svg' ); ?>"
                    alt="<?php bloginfo( 'name' ); ?>"
                    width="120"
                    height="32"
                    loading="eager"
                >
            <?php endif; ?>
        </a>

        <nav id="site-navigation" class="site-nav" aria-label="<?php esc_attr_e( 'Primary', 'montoya-portfolio' ); ?>">
            <?php
            wp_nav_menu( [
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'site-nav__list',
                'fallback_cb'    => false,
            ] );
            ?>
        </nav>

        <button
            class="site-header__menu-toggle"
            aria-controls="site-navigation"
            aria-expanded="false"
            aria-label="<?php esc_attr_e( 'Toggle navigation menu', 'montoya-portfolio' ); ?>"
        >
            <span class="site-header__menu-toggle-bar"></span>
            <span class="site-header__menu-toggle-bar"></span>
        </button>

    </div><!-- .site-header__inner -->
</header><!-- #masthead -->

<main id="main" class="site-main" tabindex="-1">
