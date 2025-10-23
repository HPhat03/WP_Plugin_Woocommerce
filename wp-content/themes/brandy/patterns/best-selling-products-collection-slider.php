<?php
/**
 * Title: Brandy Best Selling Products Collection With Slider
 * Slug: brandy/best-selling-products-collection-slider
 * Categories: brandy, woocommerce
 * Viewport Width: 1500
 */

?>

<!-- wp:group {"align":"wide","layout":{"type":"constrained"},"metadata":{"categories":["brandy"],"patternName":"brandy/best-selling-products-collection-slider","name":"Brandy Best Selling Products Collection With Slider"}} -->
<div class="wp-block-group alignwide">
<?php
echo \brandy_get_product_collection_block_content(
	array(
		'type'   => 'best-sellers',
		'slider' => true,
	)
);
?>
</div>
<!-- /wp:group -->
