<?php

namespace Brandy\Core\Services;

use Brandy\Traits\SingletonTrait;

/**
 * Layout Service
 */
class LayoutService {
	use SingletonTrait;

	public static function get_layouts() {
		$root = array(
			'loop-product-item'       => array(
				'option_1' => BRANDY_TEMPLATE_DIR . '/template-parts/layouts/loop-product-item/option_1.php',
				'option_2' => BRANDY_TEMPLATE_DIR . '/template-parts/layouts/loop-product-item/option_2.php',
			),
			'block-loop-product-item' => array(
				'option_1' => BRANDY_TEMPLATE_DIR . '/template-parts/layouts/block-loop-product-item/option_1.php',
				'option_2' => BRANDY_TEMPLATE_DIR . '/template-parts/layouts/block-loop-product-item/option_2.php',
			),
			'post-card'               => array(
				'option_1' => BRANDY_TEMPLATE_DIR . '/template-parts/layouts/post-card/option_1.php',
				'option_2' => BRANDY_TEMPLATE_DIR . '/template-parts/layouts/post-card/option_2.php',
			),
		);
		return $root;
	}

	public static function get_layout( $key = '' ) {
		$layouts = self::get_layouts();
		if ( ! isset( $layouts[ $key ] ) ) {
			return null;
		}
		return $layouts[ $key ];
	}

}
