<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

?>
<div class="woocommerce-loop-product__actions">
	<?php
	echo apply_filters( //PHPCS:ignore
		'woocommerce_loop_add_to_cart_link',
		brandy_get_wc_add_to_cart_button(
			$product,
			array(
				'quantity'   => isset( $args['quantity'] ) ? $args['quantity'] : 1,
				'class'      => isset( $args['class'] ) ? $args['class'] : '',
				'attributes' => isset( $args['attributes'] ) ? $args['attributes'] : array(),
				'is_ajax'    => true,
			)
		),
		$product,
		$args
	);
	?>
</div>
