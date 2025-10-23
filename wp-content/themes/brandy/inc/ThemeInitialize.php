<?php

namespace Brandy;

use Brandy\Admin\AdminSetup;
use Brandy\Core\Ajax;
use Brandy\Core\ThemeEnqueue;
use Brandy\Traits\SingletonTrait;

class ThemeInitialize {
	use SingletonTrait;

	protected function __construct() {

		/**
		 * Define constants
		 */
		require_once get_template_directory() . '/inc/ConstantsLoader.php';

		/**
		 * Load Core files
		 */
		require_once get_template_directory() . '/inc/Functions/FunctionsLoader.php';
		require_once get_template_directory() . '/inc/FSE/FSEHandler.php';
		require_once get_template_directory() . '/inc/Core/ThemeSetup.php';
		require_once get_template_directory() . '/inc/WooCommerce/WooCommerceLoader.php';
		require_once get_template_directory() . '/inc/Database/Migration.php';

		/**
		 * Legacy header/footer builder
		 */
		require_once get_template_directory() . '/inc/Builder/BuilderLoader.php';

		require_once get_template_directory() . '/inc/Integrations/IntegrationSetup.php';

		require_once get_template_directory() . '/inc/BlocksOverride/BlocksOverrideLoader.php';
		require_once get_template_directory() . '/inc/BlockSettings/BlockExternalsLoader.php';

		add_action( 'after_setup_theme', array( $this, 'load_externals' ), 9 );
		add_action( 'init', array( $this, 'load_classes' ) );

	}

	public function load_externals() {
		require_once get_template_directory() . '/inc/Customizer/CustomizerLoader.php';
		require_once get_template_directory() . '/inc/Niches/NicheLoader.php';

		add_filter(
			'doing_it_wrong_trigger_error',
			function( $result, $function_name, $message ) {
				if ( 'wp_enqueue_script()' !== $function_name ) {
					return $result;
				}
				if ( false === strpos( $message, 'wp-editor' ) ) {
					return $result;
				}
				if ( false === strpos( $message, 'wp-edit-widgets' ) ) {
					return $result;
				}
				if ( false === strpos( $message, 'wp-customize-widgets' ) ) {
					return $result;
				}
				return false;
			},
			100,
			3
		);

	}

	public function load_classes() {

		require_once ABSPATH . WPINC . '/class-wp-customize-widgets.php';

		I18n::load_plugin_text_domain();

		/**
		 * Core modules
		 */
		ThemeEnqueue::get_instance();

		DynamicCss::get_instance();
		Ajax::get_instance();

		/**
		 * Admin
		 */
		AdminSetup::get_instance();

		do_action( 'brandy_initialized' );
	}

}
