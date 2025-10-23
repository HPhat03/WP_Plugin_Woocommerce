<?php
/**
 * Theme functions
 * Handle theme functionality
 *
 * @package Brandy/Functions
 */

namespace Brandy;

if ( ! defined( 'BRANDY_TEMPLATE_DIR' ) ) {
	define( 'BRANDY_TEMPLATE_DIR', get_template_directory() );
}
if ( ! defined( 'BRANDY_TEMPLATE_URL' ) ) {
	define( 'BRANDY_TEMPLATE_URL', get_template_directory_uri() );
}
if ( ! defined( 'BRANDY_PATTERN_BASE_SLUG' ) ) {
	define( 'BRANDY_PATTERN_BASE_SLUG', 'brandy' );
}
if ( ! defined( 'BRANDY_IS_DEVELOPMENT' ) ) {
	define( 'BRANDY_IS_DEVELOPMENT', false );
}
if ( ! defined( 'BRANDY_VERSION' ) ) {
	define( 'BRANDY_VERSION', wp_get_theme()->get( 'Version' ) );
}

if ( ! defined( 'BRANDY_SCRIPT_VERSION' ) ) {
	define( 'BRANDY_SCRIPT_VERSION', BRANDY_IS_DEVELOPMENT ? time() : BRANDY_VERSION );
}

require_once get_template_directory() . '/vendor/autoload.php';

ThemeInitialize::get_instance();
