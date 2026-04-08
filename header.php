<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ( is_front_page() ) : ?>
<div class="page-loader" aria-hidden="true">
    <span class="page-loader__logo"><?php bloginfo( 'name' ); ?></span>
</div>
<?php endif; ?>

<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'montoya-portfolio' ); ?></a>

<header id="masthead" class="site-header" role="banner">
    <div class="site-header__inner container">

        <a class="site-header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <?php bloginfo( 'name' ); ?> ®
        </a>

        <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary', 'montoya-portfolio' ); ?>">
            <ul class="main-navigation__list">
                <li class="main-navigation__item">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
                       class="main-navigation__link is-active"
                       aria-current="page">
                        <?php esc_html_e( 'Home', 'montoya-portfolio' ); ?>
                    </a>
                </li>
                <li class="main-navigation__item">
                    <a href="<?php echo esc_url( home_url( '/work' ) ); ?>"
                       class="main-navigation__link">
                        <?php esc_html_e( 'Work', 'montoya-portfolio' ); ?>
                    </a>
                </li>
                <li class="main-navigation__item">
                    <a href="<?php echo esc_url( home_url( '/about' ) ); ?>"
                       class="main-navigation__link">
                        <?php esc_html_e( 'About', 'montoya-portfolio' ); ?>
                    </a>
                </li>
                <li class="main-navigation__item">
                    <a href="<?php echo esc_url( home_url( '/services' ) ); ?>"
                       class="main-navigation__link">
                        <?php esc_html_e( 'Services', 'montoya-portfolio' ); ?>
                    </a>
                </li>
                <li class="main-navigation__item main-navigation__item--cta">
                    <a href="<?php echo esc_url( home_url( '/inquiries' ) ); ?>"
                       class="main-navigation__link main-navigation__link--cta">
                        <?php esc_html_e( 'Inquiries', 'montoya-portfolio' ); ?>
                    </a>
                </li>
            </ul>
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
