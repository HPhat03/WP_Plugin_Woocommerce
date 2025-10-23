<?php
/**
 * Title: Brandy Best Selling Products Collection
 * Slug: brandy/best-selling-products-collection
 * Categories: brandy, woocommerce
 * Viewport Width: 1500
 */

?>

<!-- wp:group {"align":"wide","layout":{"type":"constrained"},"metadata":{"categories":["brandy"],"patternName":"brandy/best-selling-products-collection","name":"Brandy Best Selling Products Collection"}} -->
<div class="wp-block-group alignwide">
<?php
echo \brandy_get_product_collection_block_content(
	array(
		'type' => 'best-sellers',
	)
);
?>
</div>
<!-- /wp:group -->
