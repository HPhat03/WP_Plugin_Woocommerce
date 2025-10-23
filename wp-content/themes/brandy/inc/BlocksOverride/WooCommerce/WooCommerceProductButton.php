<?php

namespace Brandy\BlocksOverride\WooCommerce;

use Brandy\Traits\SingletonTrait;

/**
 * Override WP latest posts block
 */
class WooCommerceProductButton {
	use SingletonTrait;

	protected function __construct() {
		add_filter( 'block_type_metadata_settings', array( $this, 'override_meta_data' ), 10, 2 );
	}

	/**
	 * Override block callback
	 */
	public function override_meta_data( $settings, $metadata ) {
		if ( 'woocommerce/product-button' === $metadata['name'] && isset( $metadata['supports'] ) ) {
			$settings['supports']['__experimentalSelector'] = '.wp-block-woocommerce-product-button .wp-block-button__link';
		}
		return $settings;
	}

}
