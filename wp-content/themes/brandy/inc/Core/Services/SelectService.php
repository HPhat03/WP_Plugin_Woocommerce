<?php

namespace Brandy\Core\Services;

use Brandy\Customizer\Panels\General\SelectSettingsSection;
use Brandy\Traits\SingletonTrait;
use Brandy\Utils\Helpers;

/**
 * Select Service
 */
class SelectService {
	use SingletonTrait;

	/**
	 * Returns theme mode option key
	 *
	 * @return string
	 */
	public static function get_option_key() {
		return SelectSettingsSection::SECTION_ID;
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
		$css = '
		select:not(.components-select-control__input, .attachment-filters), .select2 .select2-selection{
			display: inline-flex;
			width: fit-content;
			font-size: 0.875rem;
			background-color: var(--input-background-color);
			color: var(--input-text-color);
			padding: var(--input-padding);
			border-width: var(--input-border-width);
			border-color: var(--input-border-color);
			border-style: solid;
			border-radius: var(--input-border-radius);
			outline-width: var(--input-border-width);
			outline-color: transparent;
			outline-style: solid;
			box-shadow: none;
			appearance: none;
			-webkit-appearance: none;
			background-image: url("data:image/svg+xml,%3Csvg width=\'21\' height=\'13\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M18.5.379L20.621 2.5 10.5 12.621.379 2.5 2.5.379l8 8z\' fill=\'%234F5D6D\' fill-rule=\'nonzero\'/%3E%3C/svg%3E");
			background-repeat: no-repeat, repeat;
			background-size: 8px auto, 100%;
			background-position: right 10px top 50%, 0 0;
			min-height: 44px;
			cursor: pointer;
			transition-property: outline, border;
			transition-duration: var(--theme-input-transition-duration);
			transition-timing-function: ease-in-out;
			transition-delay: 0s;
		}
		select:not(.components-select-control__input, .attachment-filters):hover, .select2-selection:hover{
			border-color: var(--input-hover-border-color);
		}
		select:not(.components-select-control__input, .attachment-filters):focus, .select2-selection:focus{
			outline-color: var(--input-focus-border-color);
			border-color: transparent;
			outline-width: calc(var(--select-border-width) + 1px);
		}
		select:not(.components-select-control__input, .attachment-filters)::placeholder, .select2-selection::placeholder{
			color: var(--input-text-color);
			opacity: 0.5;
		}
		select:not(.components-select-control__input, .attachment-filters):-ms-input-placeholder, .select2-selection:-ms-input-placeholder{
			color: var(--input-text-color);
		}
		';
		echo wp_kses_post( $css );
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
		$select_settings  = get_theme_mod( self::get_option_key(), $default_settings );
		$select_settings  = Helpers::recursive_wp_parse_args( $select_settings, $default_settings );
		foreach ( array_keys( $select_settings ) as $key ) {
			if ( ! key_exists( $key, $default_settings ) ) {
				unset( $select_settings[ $key ] );
			}
		}
		return $select_settings;
	}

	public static function save_settings( $data ) {

		$default_settings = self::get_default_settings();
		$select_settings  = Helpers::recursive_wp_parse_args( $data, $default_settings );

		foreach ( array_keys( $select_settings ) as $key ) {
			if ( ! key_exists( $key, $default_settings ) ) {
				unset( $select_settings[ $key ] );
			}
		}

		set_theme_mod( self::get_option_key(), $select_settings );
	}
}
