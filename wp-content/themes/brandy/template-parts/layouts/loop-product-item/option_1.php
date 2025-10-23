<?php

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

?>
<li <?php brandy_wc_loop_product_item_attributes( $product ); ?>>
	<?php
		/**
		 * Hook: woocommerce_before_shop_loop_item.
		 *
		 * @removed_hooked woocommerce_template_loop_product_link_open - 10 => removed
		 */
		do_action( 'woocommerce_before_shop_loop_item' );
	?>
	<div class="brandy-loop-product__image">
		<?php
			woocommerce_show_product_loop_sale_flash();
			woocommerce_template_loop_product_link_open();
			woocommerce_template_loop_product_thumbnail();
			woocommerce_template_loop_product_link_close();
		?>
	</div>

	<?php

	/**
	 * Product loop category
	 *
	 * Show product category before title
	 */
	$terms = get_the_terms( $product->get_id(), 'product_cat' );

	$current_term = $terms[0];

	if ( ! empty( $current_term ) ) :
		$term_name = $current_term->name;
		$term_link = get_term_link( $current_term );
		printf(
			'<a class="brandy-loop-product__category" href="%s">%s</a>',
			esc_url( $term_link ),
			esc_html( $term_name )
		);
	endif;


	/**
	 * Product loop rating
	 */
	woocommerce_template_loop_rating();

	?>

	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10 => removed
	 * @hooked woocommerce_template_loop_product_thumbnail - 10 => removed
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );
	?>

	<?php
	/**
	 * Display loop - product title
	 */
	?>
	<h3 class="brandy-loop-product__title">

		<?php woocommerce_template_loop_product_link_open(); ?>

		<?php echo esc_html( $product->get_title() ); ?>

		<?php woocommerce_template_loop_product_link_close(); ?>

	</h3>

	<?php
	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5 => removed
	 * @hooked woocommerce_template_loop_price - 10 => removed
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );
	?>

	<div class="brandy-loop-product__price price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>

	<?php
	echo brandy_get_wc_add_to_cart_button(
		$product,
		array(
			'quantity' => 1,
			'is_ajax'  => true,
		)
	);
	?>

	<?php
	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5 => removed
	 * @hooked woocommerce_template_loop_add_to_cart - 10 => removed
	 */
	do_action( 'woocommerce_after_shop_loop_item' );
	?>
</li>
