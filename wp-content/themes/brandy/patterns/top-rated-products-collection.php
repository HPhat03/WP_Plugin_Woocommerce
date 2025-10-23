<?php
/**
 * Title: Brandy Top-Rated Products Collection
 * Slug: brandy/top-rated-products-collection
 * Categories: brandy, woocommerce
 * Viewport Width: 1500
 */

?>

<!-- wp:group {"align":"wide","layout":{"type":"constrained"},"metadata":{"categories":["brandy"],"patternName":"brandy/top-rated-products-collection","name":"Brandy Top-Rated Products Collection"}} -->
<div class="wp-block-group alignwide">
<?php
	echo \brandy_get_product_collection_block_content(
		array(
			'type' => 'top-rated',
		)
	);
	?>
</div>
<!-- /wp:group -->
