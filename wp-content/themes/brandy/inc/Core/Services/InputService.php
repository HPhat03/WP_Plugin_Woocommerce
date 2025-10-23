<?php

namespace Brandy\Core\Services;

use Brandy\Customizer\Panels\General\InputSettingsSection;
use Brandy\DynamicCss;
use Brandy\Traits\SingletonTrait;
use Brandy\Utils\Helpers;
use Brandy\Utils\StylesDataHelpers;

/**
 * Input Service
 */
class InputService {
	use SingletonTrait;

	/**
	 * Returns theme mode option key
	 *
	 * @return string
	 */
	public static function get_option_key() {
		return InputSettingsSection::SECTION_ID;
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
		return array(
			'background_color' => array(
				'normal' => 'var(--wp--custom--input--background)',
			),
			'text_color'       => array(
				'normal' => 'var(--wp--custom--input--foreground)',
			),
			'typography'       => TypographyService::get_default_typography_value(),
			'border'           => array(
				'width'  => array(
					'unit'  => 'px',
					'value' => 1,
					'min'   => 0,
					'max'   => 5,
				),
				'color'  => array(
					'normal' => 'var(--wp--custom--input--border)',
					'hover'  => 'var(--wp--custom--input--hover-border)',
					'focus'  => 'var(--wp--custom--input--focus-border)',
				),
			),
			'padding'          => array(
				'unit'           => 'px',
				'top'            => 14,
				'right'          => 14,
				'bottom'         => 14,
				'left'           => 14,
				'is_constraints' => true,
			),
		);
	}

	/**
	 * Print out global css
	 */
	public static function print_css() {
		$settings = self::get_settings();
		$css      = '
		:root {
		    --input-padding: ' . StylesDataHelpers::get_spacing_css( $settings['padding'] ) . ';
			--input-border-width: ' . StylesDataHelpers::get_dimension_css( $settings['border']['width'] ) . ';
		    --input-border-color: ' . $settings['border']['color']['normal'] . ';
		    --input-hover-border-color: ' . $settings['border']['color']['hover'] . ';
		    --input-focus-border-color: ' . $settings['border']['color']['focus'] . ';
			--input-border-radius: var(--wp--custom--input--border-radius);
			--input-background-color: ' . $settings['background_color']['normal'] . ';
			--input-text-color: ' . $settings['text_color']['normal'] . ';
		}
		input[type="text"], input[type="tel"], input[type="url"], input[type="email"], input[type="number"], input[type="password"], input[type="search"], textarea {
			background-color: var(--input-background-color);
			color: var(--input-text-color);
			width: 100%;
			border-width: var(--input-border-width);
			border-color: var(--input-border-color);
			border-style: solid;
			border-radius: var(--input-border-radius);
			outline-width: var(--input-border-width);
			outline-color: transparent;
			outline-style: solid;
			padding: 13px;
			box-shadow: none;
			transition-property: outline, border;
			transition-duration: var(--theme-input-transition-duration);
			transition-timing-function: ease-in-out;
			transition-delay: 0s;
		}
		input[type="text"]:hover, input[type="tel"]:hover, input[type="url"]:hover, input[type="email"]:hover, input[type="number"]:hover, input[type="password"]:hover, input[type="search"]:hover, textarea:hover {
			border-color: var(--input-hover-border-color);
		}
		input[type="text"]:focus, input[type="tel"]:focus, input[type="url"]:focus, input[type="email"]:focus, input[type="number"]:focus, input[type="password"]:focus, input[type="search"]:focus, textarea:focus {
			outline-color: var(--input-focus-border-color);
			border-color: transparent;
			outline-width: calc(var(--input-border-width) + 1px);
			outline-style: solid;
		}
		input[type="text"]::placeholder, input[type="tel"]::placeholder, input[type="url"]::placeholder, input[type="email"]::placeholder, input[type="number"]::placeholder, input[type="password"]::placeholder, input[type="search"]::placeholder, textarea::placeholder {
			color: var(--input-text-color);
			opacity: 0.5;
		}
		input[type="text"]::-ms-input-placeholder, input[type="tel"]::-ms-input-placeholder, input[type="url"]::-ms-input-placeholder, input[type="email"]::-ms-input-placeholder, input[type="number"]::-ms-input-placeholder, input[type="password"]::-ms-input-placeholder, input[type="search"]::-ms-input-placeholder, textarea::-ms-input-placeholder {
			color: var(--input-text-color);
		}
		.wc-block-components-text-input input[type="text"],.wc-block-components-text-input input[type="tel"],.wc-block-components-text-input input[type="url"],.wc-block-components-text-input input[type="email"],.wc-block-components-text-input input[type="number"],.wc-block-components-text-input input[type="password"],.wc-block-components-text-input input[type="search"], textarea {
			padding: var(--input-padding);
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
		$input_settings   = get_theme_mod( self::get_option_key(), $default_settings );
		$input_settings   = Helpers::recursive_wp_parse_args( $input_settings, $default_settings );
		foreach ( array_keys( $input_settings ) as $key ) {
			if ( ! key_exists( $key, $default_settings ) ) {
				unset( $input_settings[ $key ] );
			}
		}
		return $input_settings;
	}

	public static function save_settings( $data ) {

		$default_settings = self::get_default_settings();
		$input_settings   = Helpers::recursive_wp_parse_args( $data, $default_settings );

		foreach ( array_keys( $input_settings ) as $key ) {
			if ( ! key_exists( $key, $default_settings ) ) {
				unset( $input_settings[ $key ] );
			}
		}

		set_theme_mod( self::get_option_key(), $input_settings );
	}
}
