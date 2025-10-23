<?php
/**
 * Title: Brandy Featured Products Collection
 * Slug: brandy/featured-products-collection
 * Categories: brandy, woocommerce
 * Viewport Width: 1500
 */

?>

<!-- wp:group {"align":"wide","layout":{"type":"constrained"},"metadata":{"categories":["brandy"],"patternName":"brandy/featured-products-collection","name":"Brandy Featured Products Collection"}} -->
<div class="wp-block-group alignwide">
<?php
echo \brandy_get_product_collection_block_content(
	array(
		'type' => 'featured',
	)
);
?>
</div>
<!-- /wp:group -->
