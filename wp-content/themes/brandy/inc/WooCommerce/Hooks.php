<?php

namespace Brandy\WooCommerce;

use Brandy\Traits\SingletonTrait;

class Hooks {
	use SingletonTrait;

	protected function __construct() {
		add_filter( 'woocommerce_single_product_image_thumbnail_html', array( $this, 'add_aria_label_to_a_tag' ) );
		add_action( 'wp_get_attachment_image_attributes', array( $this, 'alter_image_alt' ), 10, 3 );
	}

	public function add_aria_label_to_a_tag( $html ) {
		global $product;

		$tag = new \WP_HTML_Tag_Processor( $html );
		if ( $tag->next_tag() && $tag->next_tag() ) {
			if ( 'A' === $tag->get_tag() ) {
				$tag->set_attribute( 'aria-label', $product->get_name() );
			}
		}

		$html = $tag->get_updated_html();

		return $html;
	}

	public function alter_image_alt( $attr, $attachment, $size ) {
		if ( ! empty( $attachment->post_parent ) && empty( $attr['alt'] ) ) {
			$product = \wc_get_product( $attachment->post_parent );
			if ( $product && is_object_in_term( $attachment->post_parent, 'product_tag', 'brandy-demo' ) ) {
				$attr['alt'] = $product->get_name();
			}
		}
		return $attr;
	}

}

Hooks::get_instance();
