<?php
/**
 * Title: Brandy On Sale Products Collection With Slider
 * Slug: brandy/on-sale-products-collection-slider
 * Categories: brandy, woocommerce
 * Viewport Width: 1500
 */

?>

<!-- wp:group {"align":"wide","layout":{"type":"constrained"},"metadata":{"categories":["brandy"],"patternName":"brandy/on-sale-products-collection-slider","name":"Brandy On Sale Products Collection With Slider"}} -->
<div class="wp-block-group alignwide">
<?php
echo \brandy_get_product_collection_block_content(
	array(
		'type'   => 'on-sale',
		'slider' => true,
	)
);
?>
</div>
<!-- /wp:group -->
