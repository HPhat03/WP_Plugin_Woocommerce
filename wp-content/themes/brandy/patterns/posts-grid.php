<?php
/**
 * Title: Brandy Posts (Grid)
 * Slug: brandy/posts-grid
 * Categories: query, brandy, post
 * Block Types: core/query
 * Viewport Width: 1500
 */
?>

<!-- wp:group {"metadata":{"categories":["posts","brandy","post"],"patternName":"brandy/posts-grid","name":"Brandy Posts (Grid)"},"align":"wide","layout":{"type":"constrained","justifyContent":"left"}} -->
<div class="wp-block-group alignwide"><!-- wp:query {"queryId":20,"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true},"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-query alignwide"><!-- wp:post-template {"align":"wide","className":"","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"grid","columnCount":3},"responsiveLayout":{"enabled":true,"tablet":{"columnType":"manual","value":"1"},"mobile":{"columnType":"manual","value":"1"}}} -->
<!-- wp:group {"metadata":{"name":""},"style":{"spacing":{"blockGap":"0"},"dimensions":{"minHeight":"100%"}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="min-height:100%"><!-- wp:group {"style":{"border":{"radius":"9px"},"color":{"background":"var:custom|card|background"},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group has-background" style="border-radius:9px;background-color:var(--wp--custom--card--background);padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:post-featured-image {"isLink":true,"style":{"border":{"radius":"9px"}}} /--></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"0","margin":{"top":"var:preset|spacing|10","bottom":"var:preset|spacing|10"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--10);margin-bottom:var(--wp--preset--spacing--10)"><!-- wp:post-date {"textAlign":"center","displayType":"modified","style":{"elements":{"link":{"color":{"text":"var:preset|color|brandy-secondary-text"}}},"spacing":{"margin":{"top":"0"}}},"textColor":"brandy-secondary-text","fontSize":"small"} /-->

<!-- wp:post-title {"textAlign":"center","level":4,"isLink":true,"style":{"typography":{"fontStyle":"normal","fontWeight":"500"}}} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:spacer {"height":"40px","style":{"spacing":{"margin":{"bottom":"0"}}}} -->
<div style="margin-bottom:0;height:40px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:query-pagination {"paginationArrow":"arrow","showLabel":false,"align":"wide"} -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->