<?php
defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', 'montoya_setup' );
function montoya_setup(): void {
    load_theme_textdomain( 'montoya-portfolio', MONTOYA_DIR . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'gallery', 'caption' ] );
    add_theme_support( 'custom-logo', [
        'height'      => 64,
        'width'       => 240,
        'flex-height' => true,
        'flex-width'  => true,
    ] );

    register_nav_menus( [
        'primary' => __( 'Primary Navigation', 'montoya-portfolio' ),
    ] );
}
