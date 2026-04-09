<?php
defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', 'montoya_enqueue_assets' );
function montoya_enqueue_assets(): void {
    wp_enqueue_style( 'montoya-style', get_stylesheet_uri(), [], MONTOYA_VERSION );

    // GSAP core
    wp_register_script(
        'gsap',
        'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js',
        [],
        '3.12.5',
        true
    );

    // ScrollTrigger plugin (requires GSAP core)
    wp_register_script(
        'gsap-scrolltrigger',
        'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js',
        [ 'gsap' ],
        '3.12.5',
        true
    );

    // Lenis smooth scroll
    wp_register_script(
        'lenis',
        'https://cdn.jsdelivr.net/npm/lenis@1.1.14/dist/lenis.min.js',
        [],
        '1.1.14',
        true
    );

    $js = MONTOYA_DIR . '/assets/js/main.js';
    if ( file_exists( $js ) ) {
        wp_enqueue_script(
            'montoya-main',
            MONTOYA_URI . '/assets/js/main.js',
            [ 'gsap', 'gsap-scrolltrigger', 'lenis' ],
            MONTOYA_VERSION,
            true
        );
    }
}
