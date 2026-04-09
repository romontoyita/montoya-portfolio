<?php
defined( 'ABSPATH' ) || exit;

/* ==========================================================================
   Custom Post Type: Work (Case Studies)
   Template: single-work.php
   ========================================================================== */

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
