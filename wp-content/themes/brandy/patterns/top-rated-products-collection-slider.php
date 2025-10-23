<?php
/**
 * Title: Brandy Top-Rated Products Collection With Slider
 * Slug: brandy/top-rated-products-collection-slider
 * Categories: brandy, woocommerce
 * Viewport Width: 1500
 */
?>

<!-- wp:group {"align":"wide","layout":{"type":"constrained"},"metadata":{"categories":["brandy"],"patternName":"brandy/top-rated-products-collection-slider","name":"Brandy Top-Rated Products Collection With Slider"}} -->
<div class="wp-block-group alignwide">
<?php
	echo \brandy_get_product_collection_block_content(
		array(
			'type'   => 'top-rated',
			'slider' => true,
		)
	);
	?>
</div>
<!-- /wp:group -->
