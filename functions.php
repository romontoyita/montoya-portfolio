<?php
defined( 'ABSPATH' ) || exit;

define( 'MONTOYA_VERSION', '1.0.0' );
define( 'MONTOYA_DIR',     get_template_directory() );
define( 'MONTOYA_URI',     get_template_directory_uri() );

$includes = [
    'inc/theme-setup.php',
    'inc/enqueue.php',
    'inc/cpt.php',
    'inc/acf-fields.php',
];

foreach ( $includes as $file ) {
    $path = MONTOYA_DIR . '/' . $file;
    if ( file_exists( $path ) ) {
        require_once $path;
    }
}
