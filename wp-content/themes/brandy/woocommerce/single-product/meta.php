<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woo.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php
	if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) :
		$sku = $product->get_sku();
		?>
		<span class="sku_wrapper"><span class="meta_label"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?></span> <span class="sku"><?php echo $sku ? esc_html( $sku ) : esc_html__( 'N/A', 'woocommerce' ); ?></span></span>

	<?php endif; ?>

	<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="category_list"><span class="meta_label">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'woocommerce' ) . '</span> ', '</span>' ); //PHPCS: XSS ok. ?>

	<?php
	$tags = get_the_terms(
		$product->get_id(),
		'product_tag'
	);

	if ( false != $tags && ! is_wp_error( $tags ) ) :
		?>
		<div class="tag_list">
		<?php
		foreach ( $tags as $single_tag ) :
			$search_by_tag_url = add_query_arg( array( 'tag' => $single_tag->term_id ), home_url() );
			printf(
				'<a class="post-tag-item" href="%s"><span>%s</span></a>',
				esc_url( $search_by_tag_url ),
				esc_html( $single_tag->name )
			);
		endforeach;
		?>
		</div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
