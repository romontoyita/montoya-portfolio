<?php
defined( 'ABSPATH' ) || exit;

/* ==========================================================================
   ACF Local Field Groups
   Registered programmatically so fields are version-controlled and don't
   require manual setup in wp-admin.
   ========================================================================== */

add_action( 'acf/init', 'montoya_register_about_fields' );
function montoya_register_about_fields(): void {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

    acf_add_local_field_group( [
        'key'    => 'group_about_intro',
        'title'  => 'About — Intro Section',
        'fields' => [
            [
                'key'           => 'field_ab_intro_label',
                'label'         => 'Label',
                'name'          => 'ab_intro_label',
                'type'          => 'text',
                'instructions'  => 'Short tag shown in parentheses above the headline. Example: ABOUT',
                'default_value' => 'ABOUT',
            ],
            [
                'key'           => 'field_ab_intro_headline',
                'label'         => 'Headline',
                'name'          => 'ab_intro_headline',
                'type'          => 'text',
                'instructions'  => 'Main statement rendered in large display type.',
                'default_value' => 'Design shaped through clarity, restraint, and long-term thinking.',
            ],
            [
                'key'           => 'field_ab_intro_body',
                'label'         => 'Intro text',
                'name'          => 'ab_intro_body',
                'type'          => 'textarea',
                'instructions'  => 'Separate paragraphs with a blank line.',
                'rows'          => 6,
                'default_value' => "Founded and directed by Rocío Montoya, Montoya Studio is an independent creative practice working across identity, digital design, and development.\n\nWe partner with brands seeking thoughtful execution, aesthetic precision, and systems built to endure.",
            ],
            [
                'key'           => 'field_ab_intro_image',
                'label'         => 'Portrait image',
                'name'          => 'ab_intro_image',
                'type'          => 'image',
                'instructions'  => 'Displayed in the left column. Recommended aspect ratio: 5:6 (e.g. 684 × 808 px).',
                'return_format' => 'array',
                'preview_size'  => 'medium',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'page-about.php',
                ],
            ],
            [
                [
                    'param'    => 'page_slug',
                    'operator' => '==',
                    'value'    => 'about',
                ],
            ],
        ],
        'menu_order'      => 0,
        'position'        => 'normal',
        'style'           => 'default',
        'label_placement' => 'top',
    ] );
}
