<?php
/**
 * Title: Brandy Newest Products Collection
 * Slug: brandy/newest-products-collection
 * Categories: brandy, woocommerce
 * Viewport Width: 1500
 */

?>

<!-- wp:group {"align":"wide","layout":{"type":"constrained"},"metadata":{"categories":["brandy"],"patternName":"brandy/newest-products-collection","name":"Brandy Newest Products Collection"}} -->
<div class="wp-block-group alignwide">
<?php
echo \brandy_get_product_collection_block_content(
	array(
		'type' => 'new-arrivals',
	)
);
?>
</div>
<!-- /wp:group -->
