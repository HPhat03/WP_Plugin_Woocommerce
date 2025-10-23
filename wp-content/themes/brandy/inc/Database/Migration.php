<?php

namespace Brandy\Database;

use Brandy\Traits\SingletonTrait;

class Migration {
	use SingletonTrait;

	protected function __construct() {
		add_action( 'after_setup_theme', array( $this, 'do_theme_option_migration' ), 1 );
	}

	/**
	 * Migrate settings from the old version
	 * In the old version, we use theme_mod to store settings
	 * In the new version, we use option to store settings
	 */
	public function do_theme_option_migration() {
		$new_header_data = get_option( 'brandy_header_settings', null );
		if ( empty( $new_header_data ) ) {
			$legacy_header_data = get_theme_mod( 'header_settings' );
			if ( ! empty( $legacy_header_data['current_template_id'] ) ) {
				brandy_save_header_settings( $legacy_header_data );
			}
			set_theme_mod( 'header_settings', time() );
		}
		$new_footer_data = get_option( 'brandy_footer_settings', null );
		if ( empty( $new_footer_data ) ) {
			$legacy_footer_data = get_theme_mod( 'footer_settings' );
			if ( ! empty( $legacy_footer_data['current_template_id'] ) ) {
				brandy_save_footer_settings( $legacy_footer_data );
			}
			set_theme_mod( 'footer_settings', time() );
		}
	}

}

Migration::get_instance();
