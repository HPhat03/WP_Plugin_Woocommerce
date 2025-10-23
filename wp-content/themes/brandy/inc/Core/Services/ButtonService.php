<?php

namespace Brandy\Core\Services;

use Brandy\Customizer\Panels\General\ButtonSettingsSection;
use Brandy\Traits\SingletonTrait;
use Brandy\Utils\Helpers;
use Brandy\Utils\StylesDataHelpers;

/**
 * Button Service
 */
class ButtonService {
	use SingletonTrait;

	/**
	 * Returns theme mode option key
	 *
	 * @return string
	 */
	public static function get_option_key() {
		return ButtonSettingsSection::SECTION_ID;
	}

	/**
	 * Returns default settings
	 *
	 * @return array
	 * @example Returns object with these value
	 * array(
	 * 'color' => array( 'normal', 'hover' ),
	 * 'background' => array( 'normal', 'hover' ),
	 * 'border_radius',
	 * 'padding'
	 *)
	 */
	public static function get_default_settings() {
		return array();
	}

	/**
	 * Print out global css
	 */
	public static function print_css() {
		return;
	}

	/**
	 * Returns settings
	 *
	 * @return array
	 * @example Returns object with these value
	 * array(
	 * 'color' => array( 'normal', 'hover' ),
	 * 'background_color' => array( 'normal', 'hover' ),
	 * 'border_radius',
	 * 'padding'
	 *)
	 */
	public static function get_settings() {
		$default_settings = self::get_default_settings();
		$button_settings  = get_theme_mod( self::get_option_key(), $default_settings );
		$button_settings  = Helpers::recursive_wp_parse_args( $button_settings, $default_settings );
		return $button_settings;
	}

	public static function save_settings( $data ) {

		$default_settings = self::get_default_settings();
		$button_settings  = Helpers::recursive_wp_parse_args( $data, $default_settings );

		foreach ( array_keys( $button_settings ) as $key ) {
			if ( ! key_exists( $key, $default_settings ) ) {
				unset( $button_settings[ $key ] );
			}
		}

		set_theme_mod( self::get_option_key(), $button_settings );
	}

}
