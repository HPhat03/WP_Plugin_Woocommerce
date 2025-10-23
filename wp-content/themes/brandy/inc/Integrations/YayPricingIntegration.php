<?php

namespace Brandy\Integrations;

use Brandy\Traits\SingletonTrait;

class YayPricingIntegration {
	use SingletonTrait;

	protected function __construct() {
		if ( ! defined( 'YAYDP_VERSION' ) ) {
			return;
		}
		add_action( 'wp_head', array( $this, 'enqueue_scripts' ) );
	}

	public function enqueue_scripts() { ?>
		<style>
			.yaydp-discounted-price{margin-top:10px;margin-bottom:10px}.yaydp-discounted-price *{line-height:normal}
			.yaydp-cart-item-price{justify-content:flex-start;gap:20px}
			.yaydp-cart-item-price>div>.price{display:flex;flex-wrap:wrap;justify-content:flex-start}
			.yaydp-cart-item-price>div>.price>span:last-child{text-align:initial}
			.yaydp-cart-item-price>div>.price>del{margin-right:10px}
			.yaydp-notice *{line-height:normal}
			.wc-block-product-template .wc-block-product{position:relative;}
			.yaydp-sale-tag {width:fit-content;top: var(--wc-sale-badge-distance, 0.875rem)!important;right: var(--wc-sale-badge-distance, 0.875rem)!important;left: auto!important;}
			.wp-block-query .yaydp-sale-tag,.brandy-loop-product .yaydp-sale-tag {top: var(--wc-sale-badge-distance, 0.875rem) !important;right: var(--wc-sale-badge-distance, 0.875rem) !important;}
		</style>
		<?php
	}
}
