<?php

namespace Brandy\WooCommerce;

use Brandy\Traits\SingletonTrait;

class SingleProduct {
	use SingletonTrait;

	protected function __construct() {
		add_filter( 'woocommerce_product_reviews_tab_title', array( $this, 'single_product_reviews_tab_title' ), 100 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
		add_filter( 'woocommerce_gallery_thumbnail_size', array( $this, 'gallery_thumbnail_size' ), 100 );
		add_filter( 'woocommerce_product_get_rating_html', array( $this, 'product_rating_html' ), 100, 3 );
	}

	public function single_product_reviews_tab_title( $title ) {
		global $product;

		if ( empty( $product ) || ! $product->is_visible() ) {
			return $title;
		}

		$reviews_count = $product->get_review_count();

		return sprintf(
			'%1$s %2$s',
			__( 'Reviews', 'brandy' ),
			sprintf(
				'<span class="reviews_tab__reviews-count brandy-count-badge">%s</span>',
				$reviews_count
			)
		);
	}

	public function gallery_thumbnail_size() {
		return array( 300, 300 );
	}

	public function product_rating_html( $html, $rating, $count ) {
		global $product;
		if ( empty( $product ) ) {
			return $html;
		}
		ob_start();
		if ( is_product() ) {
			brandy_get_rating_html( $product, $rating, $count, false, false, false );
		} else {
			brandy_get_rating_html( $product, $rating, $count, true, false, false );
		}
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}

}

SingleProduct::get_instance();
