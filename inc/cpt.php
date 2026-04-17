<?php
defined( 'ABSPATH' ) || exit;

/* ==========================================================================
   Custom Post Type: Work (Case Studies)
   Template: single-work.php
   ========================================================================== */

/**
 * Split an ACF textarea field into trimmed, non-empty lines.
 */
function montoya_acf_lines( string $field, int $post_id = 0 ): array {
    if ( ! function_exists( 'get_field' ) ) return [];
    $raw = $post_id ? get_field( $field, $post_id ) : get_field( $field );
    if ( ! $raw ) return [];
    return array_filter( array_map( 'trim', explode( "\n", $raw ) ) );
}

add_action( 'init', 'montoya_register_cpt_work' );
function montoya_register_cpt_work(): void {
    register_post_type( 'work', [
        'labels' => [
            'name'               => 'Work',
            'singular_name'      => 'Work',
            'add_new_item'       => 'Add New Case Study',
            'edit_item'          => 'Edit Case Study',
            'view_item'          => 'View Case Study',
            'all_items'          => 'All Case Studies',
            'search_items'       => 'Search Case Studies',
            'not_found'          => 'No case studies found.',
        ],
        'public'            => true,
        'has_archive'       => false,
        'show_in_rest'      => true,
        'menu_icon'         => 'dashicons-portfolio',
        'supports'          => [ 'title', 'thumbnail', 'page-attributes' ],
        'rewrite'           => [ 'slug' => 'work', 'with_front' => false ],
        'menu_position'     => 5,
    ] );
}
