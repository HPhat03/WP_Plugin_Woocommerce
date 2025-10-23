<?php
/**
 * Title: Brandy Related Products
 * Slug: brandy/related-products
 * Categories: brandy, woocommerce
 * Viewport Width: 1500
 */

?>

<!-- wp:group {"metadata":{"categories":["brandy","woocommerce"],"patternName":"brandy/related-products","name":"Brandy Related Products"},"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide">
<?php
	echo \brandy_get_product_collection_block_content(
		array(
			'type'                => 'related',
			'perPage'             => 4,
			'relatedByTags'       => true,
			'relatedByCategories' => true,
			'heading'             => '
			<!-- wp:heading {"textAlign":"center","style":{"spacing":{"margin":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|30"}}}} -->
		<h2 class="wp-block-heading has-text-align-center"
			style="margin-top:var(--wp--preset--spacing--60);margin-bottom:var(--wp--preset--spacing--30)">Related
			products</h2>
		<!-- /wp:heading -->
			',
		)
	);
	?>
</div>
<!-- /wp:group -->
