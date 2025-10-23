<?php
/**
 * The Template for displaying rating
 *
 * @package Brandy
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! \wc_review_ratings_enabled() ) {
	return;
}

// global $product;

// if ( ! empty( $args['product'] ) ) {
// 	$product = $args['product'];
// }

// if ( empty( $product ) ) {
// 	return;
// }


$rating       = $args['rating'];
$rating_count = $args['rating_count'];
$show_overall = $args['show_overall'];
$review_count = $args['review_count'];

if ( empty( $rating ) ) {
	$rating = 0;
}

if ( empty( $rating_count ) && empty( $rating ) ) {
	// echo sprintf( '<div class="brandy-ratings"><a href="%s" class="brandy-ratings__add-text">%s</a></div>', esc_url( $product->get_permalink() ), esc_html__( 'Add review', 'brandy' ) );
	return;
}

?>

<div class="brandy-ratings">
	<div class="brandy-ratings__stars">
		<?php
		if ( ! $args['show_only_stars'] && $show_overall ) :
			?>
			<svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" fill="none" viewBox="0 0 20 18" class="mr-1"><path fill="#FFAC70" d="M8.536.734c.323-.979 1.73-.979 2.053 0l1.517 4.595c.145.437.56.733 1.027.733h4.91c1.046 0 1.48 1.317.635 1.921l-3.973 2.84c-.378.27-.537.75-.392 1.187l1.518 4.595c.323.979-.815 1.792-1.661 1.187l-3.973-2.84c-.378-.27-.89-.27-1.269 0l-3.973 2.84c-.846.605-1.984-.208-1.66-1.187l1.517-4.595a1.052 1.052 0 00-.392-1.187L.447 7.983c-.846-.604-.411-1.92.634-1.92h4.911c.468 0 .882-.297 1.027-.734L8.536.734z"></path></svg>
			<?php
		else :
			for ( $i = 1; $i <= 5; $i++ ) :
				if ( floatval( $rating ) < $i ) :
					?>
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" fill="none" viewBox="0 0 20 18" class="mr-1"><path fill="#D5DDE7" d="M8.536.734c.323-.979 1.73-.979 2.053 0l1.517 4.595c.145.437.56.733 1.027.733h4.91c1.046 0 1.48 1.317.635 1.921l-3.973 2.84c-.378.27-.537.75-.392 1.187l1.518 4.595c.323.979-.815 1.792-1.661 1.187l-3.973-2.84c-.378-.27-.89-.27-1.269 0l-3.973 2.84c-.846.605-1.984-.208-1.66-1.187l1.517-4.595a1.052 1.052 0 00-.392-1.187L.447 7.983c-.846-.604-.411-1.92.634-1.92h4.911c.468 0 .882-.297 1.027-.734L8.536.734z"></path></svg>
					<?php
				elseif ( $rating > $i && $rating < $i + 1 ) :
					?>
					<svg class="half-rating-star" width="20" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 18" style="enable-background:new 0 0 20 18" xml:space="preserve"><g><path class="st0" d="M8.2,1.2c0.4-1.3,2.4-1.3,2.8,0l1.2,3.7c0.2,0.6,0.8,1,1.4,1h4c1.4,0,2,1.8,0.9,2.6l-3.3,2.3 c-0.5,0.4-0.7,1-0.5,1.6L16,16c0.4,1.3-1.1,2.4-2.3,1.6l-3.3-2.3c-0.5-0.4-1.2-0.4-1.7,0l-3.3,2.3c-1.2,0.8-2.7-0.3-2.3-1.6 l1.2-3.7c0.2-0.6,0-1.2-0.5-1.6L0.6,8.4c-1.2-0.8-0.6-2.6,0.9-2.6h4c0.6,0,1.2-0.4,1.4-1L8.2,1.2z"/><defs><filter id="Adobe_OpacityMaskFilter" filterUnits="userSpaceOnUse" x="-1.8" y="-1.6" width="12.4" height="21.2"><feColorMatrix type="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 1 0"/></filter></defs><mask maskUnits="userSpaceOnUse" x="-1.8" y="-1.6" width="12.4" height="21.2" id="mask0_126_1216_00000016763313929093347650000009477849712184371857_"><path class="st1" d="M8.2,1.2c0.4-1.3,2.4-1.3,2.8,0l1.2,3.7c0.2,0.6,0.8,1,1.4,1h4c1.4,0,2,1.8,0.9,2.6l-3.3,2.3 c-0.5,0.4-0.7,1-0.5,1.6L16,16c0.4,1.3-1.1,2.4-2.3,1.6l-3.3-2.3c-0.5-0.4-1.2-0.4-1.7,0l-3.3,2.3c-1.2,0.8-2.7-0.3-2.3-1.6 l1.2-3.7c0.2-0.6,0-1.2-0.5-1.6L0.6,8.4c-1.2-0.8-0.6-2.6,0.9-2.6h4c0.6,0,1.2-0.4,1.4-1L8.2,1.2z"/></mask><g class="st2"><rect x="-1.8" y="-1.6" class="st3" width="12.4" height="21.2"/></g></g></svg>
					<?php
				else :
					?>
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" fill="none" viewBox="0 0 20 18" class="mr-1 active-rating-star"><path fill="#FFAC70" d="M8.536.734c.323-.979 1.73-.979 2.053 0l1.517 4.595c.145.437.56.733 1.027.733h4.91c1.046 0 1.48 1.317.635 1.921l-3.973 2.84c-.378.27-.537.75-.392 1.187l1.518 4.595c.323.979-.815 1.792-1.661 1.187l-3.973-2.84c-.378-.27-.89-.27-1.269 0l-3.973 2.84c-.846.605-1.984-.208-1.66-1.187l1.517-4.595a1.052 1.052 0 00-.392-1.187L.447 7.983c-.846-.604-.411-1.92.634-1.92h4.911c.468 0 .882-.297 1.027-.734L8.536.734z"></path></svg>
					<?php
				endif;
			endfor;
		endif;
		?>
	</div>
	<?php if ( empty( $args['show_only_stars'] ) ) : ?>

	<p class="brandy-ratings__text">
		<?php
		if ( $show_overall ) {
			printf(
				// Translators: %s review number.
				( $review_count < 2 ) ? esc_html__( '%1$s of %2$s review', 'brandy' ) : esc_html__( '%1$s of %2$s reviews', 'brandy' ),
				esc_attr( $rating ),
				esc_attr( $review_count )
			);
		} else {
			// Translators: %s rating to menu.
			printf( esc_html__( '%s out of 5', 'brandy' ), esc_attr( $rating ) );
		}
		?>
	</p>
	<?php else : ?>
		<?php
		if ( $show_overall ) {
			printf( '<span class="brandy-ratings__text-overall">(%s)</span>', esc_html( $rating_count ) );
		}
		?>
	<?php endif; ?>
</div>
