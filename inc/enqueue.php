<?php
defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', 'montoya_enqueue_assets' );
function montoya_enqueue_assets(): void {
    wp_enqueue_style( 'montoya-style', get_stylesheet_uri(), [], MONTOYA_VERSION );
    wp_enqueue_script( 'montoya-main', MONTOYA_URI . '/assets/js/main.js', [], MONTOYA_VERSION, true );
}
