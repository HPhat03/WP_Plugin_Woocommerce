<?php

namespace Brandy\BlocksOverride\WooCommerce;

use Brandy\Traits\SingletonTrait;

/**
 * Override WP latest posts block
 */
class WooCommerceProductCategories {
	use SingletonTrait;

	protected function __construct() {
		add_filter( 'block_type_metadata_settings', array( $this, 'override_callback' ), 10, 2 );
	}

	/**
	 * Override block callback
	 */
	public function override_callback( $settings, $metadata ) {
		if ( 'woocommerce/product-categories' === $metadata['name'] ) {
			$settings['render_callback'] = array( $this, 'render_callback' );
		}
		return $settings;
	}

	/**
	 * Override Gutenberg code to render post featured image.
	 * Return placeholder when there is no featured image.
	 */
	public function render_callback( $attributes, $content ) {

		$children_only = wc_string_to_bool( $attributes['showChildrenOnly'] ) && is_product_category();
		$has_empty     = $attributes['hasEmpty'];
		$has_count     = $attributes['hasCount'];

		$categories = get_categories(
			array_merge(
				array(
					'taxonomy'     => 'product_cat',
					'hide_empty'   => ! $has_empty,
					'include'      => \brandy_get_demo_cats(),
					'pad_counts'   => $has_count,
					'hierarchical' => true,
				),
				$children_only ? array(
					'child_of' => get_queried_object_id(),
				) : array()
			)
		);

		$item_markup = '
		<li class="wc-block-product-categories-list-item">
			<a href="%1$s" aria-label="%3$s" class="wc-block-product-categories-list-item__container">
				<div class="wc-block-product-categories-list-item__image">%2$s</div>
				<div class="wc-block-product-categories-list-item__content">
				<span class="wc-block-product-categories-list-item__name">%3$s</span>'
				. ( $has_count ? '<span class="wc-block-product-categories-list-item__count">%4$s</span>' : '' ) .
				'</div>
			</a>
		</li>
		';

		$items_html = '';
		foreach ( $categories as $cat ) {
			$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
			$image        = wp_get_attachment_image( $thumbnail_id, 800 );
			$image        = empty( $image ) ? \wc_placeholder_img( 800 ) : $image;
			$item_count   = sprintf( '%s %s', $cat->category_count, _n( 'Item', 'Items', $cat->category_count, 'woocommerce' ) );

			$items_html .= sprintf(
				$item_markup,
				get_category_link( $cat ),
				$image,
				$cat->name,
				$item_count
			);
		}

		$container_class = $attributes['className'] ?? '';

		if ( isset( $attributes['align'] ) && 'wide' === $attributes['align'] ) {
			$container_class .= ' alignwide';
		}

		$content = sprintf(
			'<div data-block-name="woocommerce/product-categories" class="wp-block-woocommerce-product-categories wc-block-product-categories %1$s ">
				<ul class="wc-block-product-categories-list">%2$s</ul>
			</div>
		',
			$container_class,
			$items_html
		);
		return $content;
	}
}
