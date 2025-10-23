<?php
/**
 * Title: Brandy Featured Products Collection With Slider
 * Slug: brandy/featured-products-collection-slider
 * Categories: brandy, woocommerce
 * Viewport Width: 1500
 */


?>

<!-- wp:group {"align":"wide","layout":{"type":"constrained"},"metadata":{"categories":["brandy"],"patternName":"brandy/featured-products-collection-slider","name":"Brandy Featured Products Collection With Slider"}} -->
<div class="wp-block-group alignwide">
<?php
echo \brandy_get_product_collection_block_content(
	array(
		'type'   => 'featured',
		'slider' => true,
	)
);
?>
</div>
<!-- /wp:group -->
