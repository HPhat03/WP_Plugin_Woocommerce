<?php
/**
 * Single Product Sale Flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

?>
<?php if ( $product->is_on_sale() ) : ?>

	<?php
	$show_sale_amount = apply_filters( 'brandy_sale_flash_show_amount', false );
	$sale_text        = esc_html__( 'Sale!', 'woocommerce' );
	if ( $show_sale_amount && 'simple' != $product->get_type() ) {
		$sale_amount = $product->get_regular_price() - $product->get_sale_price();
		$sale_text   = '-' . ( $sale_amount / $product->get_regular_price() * 100 ) . '%';
	}
	?>
	<?php 
	   if ( function_exists( 'wp_is_block_theme' ) && ! wp_is_block_theme() ) {
			echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale brandy-sale-tag">' . esc_html( $sale_text ) . '</span>', $post, $product ); //PHPCS: XSS ok.
	   }
	?>

	<?php
endif;


/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
