<?php
/**
 * Title: Brandy Posts (List)
 * Slug: brandy/posts-list
 * Categories: query, brandy, post
 * Block Types: core/query
 * Viewport Width: 1500
 */
?>

<!-- wp:group {"metadata":{"categories":["posts","brandy","post"],"patternName":"brandy/posts-list","name":"Brandy Posts - List Layout"},"align":"wide","layout":{"type":"constrained","justifyContent":"left"}} -->
<div class="wp-block-group alignwide"><!-- wp:query {"queryId":20,"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true},"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-query alignwide"><!-- wp:post-template {"align":"wide","className":"","style":{"spacing":{"blockGap":"var:preset|spacing|50"}}} -->
<!-- wp:group {"shadow":{"type":"default","custom":false,"inset":false,"color":"#0000001A","x":"0px","y":"1px","blur":"3px","spread":"0px"},"metadata":{"name":""},"style":{"border":{"radius":"10px"},"spacing":{"blockGap":"0"},"dimensions":{"minHeight":"100%"},"shadow":"var:preset|shadow|sm"},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="border-radius:10px;min-height:100%;box-shadow:var(--wp--preset--shadow--sm)"><!-- wp:group {"className":"relative","style":{"color":{"background":"var:custom|card|background"},"border":{"radius":{"topLeft":"9px","topRight":"9px"}},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}},"dimensions":{"minHeight":"72px"}},"layout":{"type":"default"}} -->
<div class="wp-block-group relative has-background" style="border-top-left-radius:9px;border-top-right-radius:9px;background-color:var(--wp--custom--card--background);min-height:72px;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:post-featured-image {"aspectRatio":"5/3","width":"100%","height":"500px","style":{"border":{"radius":{"topLeft":"9px","topRight":"9px","bottomLeft":"0px","bottomRight":"0px"}}}} /-->

<!-- wp:avatar {"size":40,"isLink":true,"hasTooltip":true,"align":"left","className":"absolute bottom-0 left-0","style":{"border":{"radius":"100px","color":"#ffffff","style":"solid","width":"1px"},"spacing":{"margin":{"left":"16px","bottom":"16px","top":"16px","right":"0px"}}}} /--></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"30px","bottom":"30px","left":"30px","right":"30px"},"blockGap":"10px"}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="padding-top:30px;padding-right:30px;padding-bottom:30px;padding-left:30px"><!-- wp:post-terms {"term":"category","style":{"spacing":{"margin":{"top":"0","bottom":"15px"}}}} /-->

<!-- wp:post-title {"isLink":true,"fontSize":"2-xl"} /-->

<!-- wp:post-date {"displayType":"modified","style":{"elements":{"link":{"color":{"text":"var:preset|color|brandy-secondary-text"}}}},"textColor":"brandy-secondary-text","fontSize":"small"} /-->

<!-- wp:post-excerpt {"moreText":"Continue reading","excerptLength":56} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:spacer {"height":"40px"} -->
<div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:query-pagination {"paginationArrow":"arrow","showLabel":false,"align":"wide"} -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->