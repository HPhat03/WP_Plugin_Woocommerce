<?php

namespace Brandy\BlocksOverride\WooCommerce;

use Brandy\Traits\SingletonTrait;

/**
 * Override WP latest posts block
 */
class WooCommerceProductImageGallery {
	use SingletonTrait;

	protected function __construct() {
		add_filter( 'block_type_metadata_settings', array( $this, 'override_callback' ), 10, 2 );
	}

	/**
	 * Override block callback
	 */
	public function override_callback( $settings, $metadata ) {
		if ( 'woocommerce/product-image-gallery' === $metadata['name'] ) {
			$settings['render_callback'] = array( $this, 'render_callback' );
		}
		return $settings;
	}

	/**
	 * Override Gutenberg code to render post featured image.
	 * Return placeholder when there is no featured image.
	 */
	public function render_callback( $attributes, $content, $block ) {

		$post_id = $block->context['postId'];

		if ( ! isset( $post_id ) ) {
			return '';
		}

		global $product;

		$previous_product = $product;
		$product          = wc_get_product( $post_id );
		if ( ! $product instanceof \WC_Product ) {
			$product = $previous_product;

			return '';
		}

		if ( class_exists( 'WC_Frontend_Scripts' ) ) {
			$frontend_scripts = new \WC_Frontend_Scripts();
			$frontend_scripts::load_scripts();
		}

		ob_start();
		woocommerce_show_product_sale_flash();
		$sale_badge_html = ob_get_clean();

		ob_start();
		woocommerce_show_product_images();
		$product_image_gallery_html = ob_get_clean();

		$can_editable = ! empty( $attributes['className'] ) && false !== strpos( $attributes['className'], 'brandy-product-image-gallery' );

		$product   = $previous_product;
		$classname = $attributes['className'] ?? '';
		$content   = sprintf(
			'<div class="wp-block-woocommerce-product-image-gallery %1$s">%2$s %3$s</div>',
			esc_attr( $classname ),
			$sale_badge_html,
			$product_image_gallery_html
		);

		if ( ! $can_editable ) {
			return $content;
		}

		return $content;
	}

}
