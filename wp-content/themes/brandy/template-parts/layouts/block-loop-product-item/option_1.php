<?php

defined( 'ABSPATH' ) || exit;

if ( empty( $product ) ) {
	return;
}

$cats = wp_get_post_terms( $product->get_id(), 'product_cat', array( 'fields' => 'names' ) );

$show_image      = isset( $display_settings['show_image'] ) ? $display_settings['show_image'] : true;
$show_title      = isset( $display_settings['show_title'] ) ? $display_settings['show_title'] : true;
$show_button     = isset( $display_settings['show_button'] ) ? $display_settings['show_button'] : true;
$show_price      = isset( $display_settings['show_price'] ) ? $display_settings['show_price'] : true;
$show_category   = isset( $display_settings['show_category'] ) ? $display_settings['show_category'] : true;
$show_rating     = isset( $display_settings['show_rating'] ) ? $display_settings['show_rating'] : true;

$rating_count = $product->get_rating_count();
$average      = $product->get_average_rating();

ob_start();
brandy_get_rating_html( $product, $average, $rating_count, true, true );
$rating = ob_get_contents();
ob_end_clean();
?>
<li <?php brandy_wc_loop_product_item_attributes( $product ); ?>>
	<?php if ( ! empty( $show_image ) ) : ?>
		<a class="brandy-loop-product__image" href="<?php echo esc_url( $product->get_permalink() ); ?>">
			<?php \woocommerce_show_product_loop_sale_flash(); ?>
			<?php echo $product->get_image( 'woocommerce_thumbnail' ); ?>
		</a>
	<?php endif ?>
	<?php if ( ! empty( $show_category ) ) : ?>
	<div class="brandy-loop-product__category"><?php echo $cats[0]; ?></div>
	<?php endif; ?>
	<?php
	if ( ! empty( $show_rating ) ) {
		echo $rating;
	}
	?>
	<?php if ( ! empty( $show_title ) ) : ?>
		<h3 class="brandy-loop-product__title">
			<a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_title() ); ?></a>
		</h3>
	<?php endif ?>
	<?php if ( ! empty( $show_price ) ) : ?>
	<div class="brandy-loop-product__price price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
	<?php endif ?>
	<?php if ( ! empty( $show_button ) ) : ?>
		<?php
		echo brandy_get_wc_add_to_cart_button(
			$product,
			array(
				'quantity' => 1,
				'is_ajax'  => true,
			)
		);
		?>
	<?php endif ?>
</li>
