<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/review.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

	<div id="comment-<?php comment_ID(); ?>" class="comment_container">
		<div class="comment-header">
			<div class="comment-header__start">
				<div class="comment-author__avatar"><?php \woocommerce_review_display_gravatar( $comment ); ?></div>
				<div>
					<?php
					if ( '0' === $comment->comment_approved ) :
						?>
						<em class="woocommerce-review__awaiting-approval">
						<?php esc_html_e( 'Your review is awaiting approval', 'woocommerce' ); ?>
						</em>
						<?php
					else :
						$verified = wc_review_is_from_verified_owner( $comment->comment_ID );
						?>
						<div>
							<strong class="woocommerce-review__author"><?php comment_author(); ?> </strong>
							<?php \woocommerce_review_display_rating( $comment ); ?>
							<?php
							if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) && $verified ) {
								echo '<em class="woocommerce-review__verified verified">(' . esc_attr__( 'verified owner', 'woocommerce' ) . ')</em> ';
							}
							?>
							<?php
								remove_action( 'woocommerce_review_meta', 'woocommerce_review_display_meta', 10 );
								do_action( 'woocommerce_review_meta', $comment );
							?>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="comment-header__end">
				<div class="comment-time text-secondary text-description text-secondary">
					<time class="woocommerce-review__published-date" datetime="<?php echo esc_attr( get_comment_date( 'c' ) ); ?>"><?php echo esc_html( get_comment_date( wc_date_format() ) ); ?></time>
				</div>
			</div>
		</div>

		<div class="comment-body">
			<?php
				do_action( 'woocommerce_review_before_comment_text', $comment );

				/**
				 * The woocommerce_review_comment_text hook
				 *
				 * @hooked woocommerce_review_display_comment_text - 10
				 */
				do_action( 'woocommerce_review_comment_text', $comment );

				do_action( 'woocommerce_review_after_comment_text', $comment );
			?>

		</div>

		<div class="comment-footer">
			<?php
				edit_comment_link( __( 'Edit', 'brandy' ) );
			?>
			<?php
			comment_reply_link(
				array_merge(
					$args,
					array(
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
						'before'    => '<div class="reply">',
						'after'     => '</div>',
					)
				)
			);
			?>
		</div>
	</div>
