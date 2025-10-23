<?php
/**
 * Title: Brandy Countdown
 * Slug: brandy/countdown
 * Categories: banner, brandy
 */

$date = new DateTime();
$date->modify('+7 days');
?>
<!-- wp:group {"metadata":{"categories":["banner","brandy"],"patternName":"brandy/countdown","name":"Brandy Countdown"},"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide"><!-- wp:group {"align":"wide","style":{"background":{"backgroundImage":{"url":"https://images.wpbrandy.com/uploads/wc-count-down-bg.webp","id":182,"source":"file","title":"fashion-img-5-min"},"backgroundSize":"auto","backgroundPosition":"50% 50%","backgroundRepeat":"no-repeat"},"border":{"radius":"10px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide" style="border-radius:10px"><!-- wp:group {"style":{"spacing":{"blockGap":"35px","padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|30","right":"var:preset|spacing|30"}}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"center","justifyContent":"center"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--30)"><!-- wp:group {"layout":{"type":"constrained","contentSize":"372px"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","align":"wide","style":{"typography":{"fontStyle":"normal","fontWeight":"700"},"spacing":{"margin":{"bottom":"0","top":"0rem"}}},"fontSize":"fluid-3-xl"} -->
<h2 class="wp-block-heading alignwide has-text-align-center has-fluid-3-xl-font-size" style="margin-top:0rem;margin-bottom:0;font-style:normal;font-weight:700">Deal of the day up to <mark style="background-color:rgba(0, 0, 0, 0);color:#ff6800" class="has-inline-color">-40%</mark> off
			</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:brandy/countdown {"countdownDate":"<?php echo esc_attr( $date->format( 'Y-m-d H:i:s' ) ); ?>","prefix":{"color":"#5A6D80","typography":{"font_size":15,"bold":false,"italic":false,"text_transform":"none","font_weight":500}},"main":{"color":"","backgroundColor":"#ffede4","typography":{"font_size":45,"bold":false,"italic":false,"text_transform":"none","font_weight":500}},"suffix":{"color":"#5A6D80","typography":{"font_size":15,"bold":false,"italic":false,"text_transform":"none","font_weight":500}},"separator":{"text":":","color":"#5A6D80","typography":{"font_size":29,"bold":false,"italic":false,"text_transform":"none","font_weight":500}}} -->
<div class="wp-block-brandy-countdown"><div class="brandy-countdown-wrapper brandy-overall-direction-horizontal brandy-item-direction-vertical brandy-overall-align-center brandy-item-align-center" data-countdown="<?php echo esc_attr( $date->format( 'Y-m-d H:i:s' ) ); ?>" style="--prefix-font-size:15px;--prefix-bold:;--prefix-font-styles:normal;--prefix-text-transform:none;--prefix-font-weight:500;--main-font-size:45px;--main-bold:;--main-font-styles:normal;--main-text-transform:none;--main-font-weight:500;--suffix-font-size:15px;--suffix-bold:;--suffix-font-styles:normal;--suffix-text-transform:none;--suffix-font-weight:500;--separator-font-size:29px;--separator-bold:;--separator-font-styles:normal;--separator-text-transform:none;--separator-font-weight:500;--prefix__color:#5A6D80;--main__color:;--main__bg__color:#ffede4;--suffix__color:#5A6D80;--separator__color:#5A6D80;--overall__spacing:20px;--item__spacing:0px"><div class="brandy-countdown-item"><span class="brandy-countdown-prefix"></span><span class="brandy-countdown-values brandy-countdown-days">00</span><span class="brandy-countdown-suffix">Days</span></div><div class="brandy-countdown-separator">:</div><div class="brandy-countdown-item"><span class="brandy-countdown-prefix"></span><span class="brandy-countdown-values brandy-countdown-hours">00</span><span class="brandy-countdown-suffix">Hours</span></div><div class="brandy-countdown-separator">:</div><div class="brandy-countdown-item"><span class="brandy-countdown-prefix"></span><span class="brandy-countdown-values brandy-countdown-minutes">00</span><span class="brandy-countdown-suffix">Minutes</span></div><div class="brandy-countdown-separator">:</div><div class="brandy-countdown-item"><span class="brandy-countdown-prefix"></span><span class="brandy-countdown-values brandy-countdown-seconds">00</span><span class="brandy-countdown-suffix">Seconds</span></div></div></div>
<!-- /wp:brandy/countdown -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"hoverBackgroundColor":"#272829","className":"is-style-outline","style":{"color":{"background":"#ffffff00"}},"fontSize":"base"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-background has-base-font-size has-custom-font-size wp-element-button" href="<?php echo esc_url( brandy_get_shop_page_url() ); ?>" style="background-color:#ffffff00">Shop Now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->