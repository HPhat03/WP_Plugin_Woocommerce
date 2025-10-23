<?php
/**
 * Title: Brandy List Products - Grid layout - Has Pagination
 * Slug: brandy/products-grid-has-pagination
 * Categories: brandy, woocommerce
 * Viewport Width: 1500
 */
?>

<!-- wp:group {"align":"wide","layout":{"type":"constrained"},"metadata":{"categories":["brandy"],"patternName":"brandy/products-grid-has-pagination","name":"Brandy List Products - Grid layout - Has Pagination"}} -->
<div class="wp-block-group alignwide">
	<?php
	echo \brandy_get_product_collection_block_content(
		array(
			'type'            => 'default',
			'pagination'      => true,
			'pages'           => '',
			'includeDemoOnly' => false,
			'inheritQuery'    => true,
			'perPage'         => 12,
		)
	);
	?>
</div>
<!-- /wp:group -->
