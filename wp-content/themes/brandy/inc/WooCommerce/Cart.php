<?php

namespace Brandy\WooCommerce;

use Brandy\Traits\SingletonTrait;

class Cart {
	use SingletonTrait;

	protected function __construct() {
		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'add_count_items_fragment' ) );
		add_filter( 'woocommerce_is_attribute_in_product_name', '__return_false', PHP_INT_MAX );
		remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
		remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );
		add_action( 'wp_ajax_brandy_update_my_cart', array( $this, 'update_my_cart' ) );
		add_action( 'wp_ajax_nopriv_brandy_update_my_cart', array( $this, 'update_my_cart' ) );
	}

	public function update_my_cart() {
		try {
			$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : '';

			if ( ! wp_verify_nonce( $nonce, 'brandy_update_cart' ) ) {
				throw new Error( __( 'Invalid nonce', 'brandy' ) );
			}

			$quantity = isset( $_POST['quantity'] ) ? sanitize_text_field( $_POST['quantity'] ) : 0;

			$cart_item_key = isset( $_POST['product_key'] ) ? sanitize_text_field( $_POST['product_key'] ) : '';

			$cart_item = WC()->cart->get_cart_item( $cart_item_key );

			$stock_amount_cart_item = apply_filters(
				'woocommerce_stock_amount_cart_item',
				apply_filters(
					'woocommerce_stock_amount',
					preg_replace(
						'/[^0-9\.]/',
						'',
						filter_var( $quantity, FILTER_SANITIZE_NUMBER_INT )
					)
				),
				$cart_item_key
			);

			$cart_validation = apply_filters(
				'woocommerce_update_cart_validation',
				true,
				$cart_item_key,
				$cart_item,
				$stock_amount_cart_item
			);

			if ( $cart_validation ) {
				WC()->cart->set_quantity(
					$cart_item_key,
					$stock_amount_cart_item,
					true
				);

				WC()->cart->calculate_totals();
			}

			wp_send_json_success(
				array(
					'success' => true,
				)
			);
		} catch ( \Error $err ) {
			wp_send_json_success(
				array(
					'success' => false,
					'message' => $err->getMessage(),
				)
			);
		}
		die();
	}

	public function add_count_items_fragment( $fragments ) {
		$fragments['count'] = \WC()->cart->get_cart_contents_count();
		return $fragments;
	}

}

Cart::get_instance();
