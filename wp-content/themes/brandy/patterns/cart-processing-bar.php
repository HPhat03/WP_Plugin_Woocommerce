<?php
/**
 * Title: Brandy Cart Processing Bar
 * Slug: brandy/cart-processing-bar
 * Categories: brandy, woocommerce
 * Viewport Width: 1500
 */
?>

<!-- wp:group {"metadata":{"categories":["brandy"],"patternName":"brandy/cart-processing-bar","name":"Brandy Cart Processing Bar"},"className":"brandy-processing-bar","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
<div class="wp-block-group brandy-processing-bar"><!-- wp:group {"style":{"spacing":{"blockGap":"8px"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
<div class="wp-block-group"><!-- wp:buttons {"style":{"layout":{"selfStretch":"fixed","flexSize":"30px"}}} -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"brandy-primary","style":{"border":{"radius":"100px"},"spacing":{"padding":{"left":"11px","right":"11px","top":"5px","bottom":"5px"}},"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"large-to-small"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-brandy-primary-background-color has-background has-large-to-small-font-size has-custom-font-size wp-element-button" href="<?php echo brandy_get_cart_page_url(); ?>" style="border-radius:100px;padding-top:5px;padding-right:11px;padding-bottom:5px;padding-left:11px;font-style:normal;font-weight:700"><strong>1</strong></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:paragraph {"style":{"typography":{"fontStyle":"normal","fontWeight":"600"},"elements":{"link":{"color":{"text":"var:preset|color|brandy-primary"}}}},"textColor":"brandy-primary","fontSize":"large-to-small"} -->
<p class="has-brandy-primary-color has-text-color has-link-color has-large-to-small-font-size" style="font-style:normal;font-weight:600">My cart</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:separator {"style":{"layout":{"selfStretch":"fixed","flexSize":"60px"}},"backgroundColor":"brandy-gray-3"} -->
<hr class="wp-block-separator has-text-color has-brandy-gray-3-color has-alpha-channel-opacity has-brandy-gray-3-background-color has-background"/>
<!-- /wp:separator -->

<!-- wp:group {"style":{"spacing":{"blockGap":"8px"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
<div class="wp-block-group"><!-- wp:buttons {"style":{"layout":{"selfStretch":"fixed","flexSize":"30px"}}} -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"brandy-gray-3","textColor":"brandy-secondary-text","style":{"border":{"radius":"100px"},"spacing":{"padding":{"left":"10px","right":"10px","top":"5px","bottom":"5px"}},"typography":{"fontStyle":"normal","fontWeight":"700"},"elements":{"link":{"color":{"text":"var:preset|color|brandy-secondary-text"}}}},"fontSize":"large-to-small"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-brandy-secondary-text-color has-brandy-gray-3-background-color has-text-color has-background has-link-color has-large-to-small-font-size has-custom-font-size wp-element-button" href="<?php echo brandy_get_checkout_page_url(); ?>" style="border-radius:100px;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;font-style:normal;font-weight:700"><strong>2</strong></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|brandy-secondary-text"}}},"typography":{"fontStyle":"normal","fontWeight":"600"}},"textColor":"brandy-secondary-text","fontSize":"large-to-small"} -->
<p class="has-brandy-secondary-text-color has-text-color has-link-color has-large-to-small-font-size" style="font-style:normal;font-weight:600">Shipping detail</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:separator {"style":{"layout":{"selfStretch":"fixed","flexSize":"60px"}},"backgroundColor":"brandy-gray-3"} -->
<hr class="wp-block-separator has-text-color has-brandy-gray-3-color has-alpha-channel-opacity has-brandy-gray-3-background-color has-background"/>
<!-- /wp:separator -->

<!-- wp:group {"style":{"spacing":{"blockGap":"8px"},"layout":{"selfStretch":"fit","flexSize":null}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
<div class="wp-block-group"><!-- wp:buttons {"style":{"layout":{"selfStretch":"fixed","flexSize":"30px"}}} -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"brandy-gray-3","textColor":"brandy-secondary-text","style":{"border":{"radius":"100px"},"spacing":{"padding":{"left":"10px","right":"10px","top":"5px","bottom":"5px"}},"typography":{"fontStyle":"normal","fontWeight":"700"},"elements":{"link":{"color":{"text":"var:preset|color|brandy-secondary-text"}}}},"fontSize":"large-to-small"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-brandy-secondary-text-color has-brandy-gray-3-background-color has-text-color has-background has-link-color has-large-to-small-font-size has-custom-font-size wp-element-button" href="#" style="border-radius:100px;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;font-style:normal;font-weight:700"><strong>3</strong></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|brandy-secondary-text"}}},"typography":{"fontStyle":"normal","fontWeight":"600"},"layout":{"selfStretch":"fit","flexSize":null}},"textColor":"brandy-secondary-text","fontSize":"large-to-small"} -->
<p class="has-brandy-secondary-text-color has-text-color has-link-color has-large-to-small-font-size" style="font-style:normal;font-weight:600">Complete</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->