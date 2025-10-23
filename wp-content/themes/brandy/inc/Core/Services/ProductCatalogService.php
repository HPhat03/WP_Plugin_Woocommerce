<?php

namespace Brandy\Core\Services;

use Brandy\Customizer\Panels\WooCommerce\ProductCatalogSection;
use Brandy\Traits\SingletonTrait;
use Brandy\Utils\Helpers;

/**
 * ProductCatalog Service
 */
class ProductCatalogService {
	use SingletonTrait;

	/**
	 * Returns theme mode option key
	 *
	 * @return string
	 */
	public static function get_option_key() {
		return ProductCatalogSection::SECTION_ID;
	}

	public static function get_default_settings() {
		return array(
			'product_layout'     => 'option_1',
			'product_thumb_size' => 'size_1',
		);
	}

	public static function get_settings() {
		$default_settings = self::get_default_settings();
		$settings         = get_theme_mod( self::get_option_key(), $default_settings );
		$settings         = Helpers::recursive_wp_parse_args( $settings, $default_settings );
		foreach ( array_keys( $settings ) as $key ) {
			if ( ! key_exists( $key, $default_settings ) ) {
				unset( $settings[ $key ] );
			}
		}
		return $settings;
	}

	public static function save_settings( $data ) {

		$default_settings = self::get_default_settings();
		$settings         = Helpers::recursive_wp_parse_args( $data, $default_settings );

		foreach ( array_keys( $settings ) as $key ) {
			if ( ! key_exists( $key, $default_settings ) ) {
				unset( $settings[ $key ] );
			}
		}

		set_theme_mod( self::get_option_key(), $settings );
	}

	public static function get_product_layout() {
		return self::get_property( 'product_layout' );
	}
	public static function get_product_thumb_size() {
		return self::get_property( 'product_thumb_size' );
	}

	public static function get_property( $name ) {
		$settings         = self::get_settings();
		$default_settings = self::get_default_settings();
		return isset( $settings[ $name ] ) ? $settings[ $name ] : ( isset( $default_settings[ $name ] ) ? $default_settings[ $name ] : null );
	}

}
