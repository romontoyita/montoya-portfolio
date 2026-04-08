<?php
defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', 'montoya_setup' );
function montoya_setup(): void {
    load_theme_textdomain( 'montoya-portfolio', MONTOYA_DIR . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'gallery', 'caption' ] );

    register_nav_menus( [
        'primary' => __( 'Primary Navigation', 'montoya-portfolio' ),
    ] );
}
