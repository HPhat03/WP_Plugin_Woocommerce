<?php
/**
 * Title: Brandy Newest Posts (Grid)
 * Slug: brandy/newest-posts-grid
 * Categories: brandy, post, sidebar
 * Viewport Width: 1500
 */
?>

<!-- wp:group {"metadata":{"categories":["brandy"],"patternName":"brandy/newest-posts-grid","name":"Brandy Newest Posts (Grid)"},"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide"><!-- wp:query {"queryId":33,"query":{"perPage":"3","pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"namespace":"core/posts-list","align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-query alignwide"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"grid","columnCount":null,"minimumColumnWidth":"22rem"},"responsiveLayout":{"enabled":true,"tablet":{"columnType":"manual","value":"1"},"mobile":{"columnType":"manual","value":"1"}}} -->
<!-- wp:post-featured-image {"isLink":true,"style":{"spacing":{"margin":{"bottom":"17px"}}}} /-->

<!-- wp:post-date {"textAlign":"center","displayType":"modified","style":{"elements":{"link":{"color":{"text":"var:preset|color|brandy-secondary-text"}}},"spacing":{"padding":{"bottom":"0"},"margin":{"bottom":"6px"}},"typography":{"textTransform":"none"}},"textColor":"brandy-secondary-text","fontSize":"small"} /-->

<!-- wp:post-title {"textAlign":"center","level":3,"isLink":true,"style":{"spacing":{"margin":{"top":"0","bottom":"10px"}},"typography":{"fontStyle":"normal","fontWeight":"600"}},"fontSize":"large","fontFamily":"outfit"} /-->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->