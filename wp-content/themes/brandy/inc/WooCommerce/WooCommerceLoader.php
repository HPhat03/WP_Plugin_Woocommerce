<?php

namespace Brandy\WooCommerce;

use Brandy\Traits\SingletonTrait;

class WooCommerceLoader {
	use SingletonTrait;

	protected function __construct() {

		if ( ! is_wc_installed() ) {
			return;
		}

		require_once BRANDY_TEMPLATE_DIR . '/inc/WooCommerce/ProductLoop.php';
		require_once BRANDY_TEMPLATE_DIR . '/inc/WooCommerce/SingleProduct.php';
		require_once BRANDY_TEMPLATE_DIR . '/inc/WooCommerce/Cart.php';
		require_once BRANDY_TEMPLATE_DIR . '/inc/WooCommerce/Checkout.php';
		require_once BRANDY_TEMPLATE_DIR . '/inc/WooCommerce/Hooks.php';

		add_action( 'admin_print_styles', array( $this, 'remove_template_check_when_printing_styles' ), 1000 );
		add_filter( 'woocommerce_enqueue_styles', array( $this, 'remove_woocommerce_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'reenqueue_scripts' ), PHP_INT_MAX );
		add_action( 'enqueue_block_assets', array( $this, 'reenqueue_scripts' ), PHP_INT_MAX );

	}

	public function remove_template_check_when_printing_styles() {
		remove_action( 'admin_notices', array( 'WC_Admin_Notices', 'template_file_check_notice' ) );
	}

	public function remove_woocommerce_styles( $styles ) {
		unset( $styles['woocommerce-layout'] );
		unset( $styles['woocommerce-smallscreen'] );
		unset( $styles['woocommerce-general'] );
		unset( $styles['woocommerce-blocktheme'] );
		return $styles;
	}

	public function reenqueue_scripts() {

		/**
		 * Hjack to use add to cart function in FSE mode
		 */
		wp_enqueue_script( 'wc-add-to-cart' );
		if ( is_customize_preview() ) {
			wp_dequeue_script( 'wc-cart-fragments' );
		} else {
			wp_enqueue_script( 'wc-cart-fragments' );
		}

		/**
		 * Trick override woocommerce block styling
		 */
		$override_styles = array(
			'all-products',
			'cart',
			'product-button',
			'checkout',
			'product-details',
			'product-image-gallery',
			'order-confirmation-summary',
			'order-confirmation-additional-information',
			'order-confirmation-totals',
			'order-confirmation-downloads',
		);
		foreach ( $override_styles as $handle ) {
			wp_dequeue_style( 'wc-blocks-style-' . $handle );
			if ( is_rtl() ) {
				wp_dequeue_style( 'wc-blocks-style-' . $handle . '-rtl' );
			}
		}
		wp_dequeue_style( 'wc-blocks-packages-style' );
	}
}

WooCommerceLoader::get_instance();
