<?php
/**
 * Title: Brandy Scrolling Banner
 * Slug: brandy/scrolling-banner
 * Categories: brandy
 * Viewport Width: 1500
 */
$site_title = get_bloginfo( 'title' );
?>

<!-- wp:group {"metadata":{"categories":["brandy"],"patternName":"brandy/scrolling-banner","name":"Brandy Scrolling Banner"},"align":"full","className":"brandy-scrolling-banner scroll-to-left","style":{"spacing":{"padding":{"top":"30px","bottom":"30px"}},"color":{"background":"#27282908"}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull brandy-scrolling-banner scroll-to-left has-background"
	style="background-color:#27282908;padding-top:30px;padding-bottom:30px">
	<!-- wp:group {"className":"brandy-scrolling-banner__content","style":{"spacing":{"blockGap":"80px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
	<div class="wp-block-group brandy-scrolling-banner__content">
		<?php
		for ( $i = 0; $i < 6; $i++ ) {
			?>
			<!-- wp:group {"style":{"spacing":{"blockGap":"10px","padding":{"top":"5px","bottom":"5px","left":"20px","right":"20px"}},"border":{"radius":"50px"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
			<div class="wp-block-group" style="border-radius:50px;padding-top:5px;padding-right:20px;padding-bottom:5px;padding-left:20px"><!-- wp:paragraph {"align":"center","style":{"typography":{"fontStyle":"normal","fontWeight":"500"}},"fontSize":"extra-large"} -->
			<p class="has-text-align-center has-extra-large-font-size" style="font-style:normal;font-weight:500"><?php echo empty( $site_title ) ? 'Sample text' : esc_html( $site_title ); ?></p>
			<!-- /wp:paragraph --></div>
			<!-- /wp:group -->
			<?php
		}
		?>
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
