<?php
/**
 * Title: Brandy On Sale Products Collection
 * Slug: brandy/on-sale-products-collection
 * Categories: brandy, woocommerce
 * Viewport Width: 1500
 */

?>

<!-- wp:group {"align":"wide","layout":{"type":"constrained"},"metadata":{"categories":["brandy"],"patternName":"brandy/on-sale-products-collection","name":"Brandy On Sale Products Collection"}} -->
<div class="wp-block-group alignwide">
<?php
echo \brandy_get_product_collection_block_content(
	array(
		'type' => 'on-sale',
	)
);
?>
</div>
<!-- /wp:group -->
