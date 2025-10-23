<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.3.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $wp_query;

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews" class="woocommerce-Reviews">
	<div id="comments">
		<h3 class="woocommerce-Reviews-title"><?php esc_html_e( 'Customer reviews', 'woocommerce' ); ?></h3>
		<?php if ( have_comments() ) : ?>
			<ol class="commentlist">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ol>
			<?php
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links(
					apply_filters(
						'woocommerce_comment_pagination_args',
						array(
							'prev_text' => is_rtl() ? '&rarr;' : '&larr;',
							'next_text' => is_rtl() ? '&larr;' : '&rarr;',
							'type'      => 'list',
						)
					)
				);
				echo '</nav>';
			endif;
			?>
		<?php else : ?>
			<p class="woocommerce-noreviews"><?php esc_html_e( 'There is no review yet.', 'woocommerce' ); ?></p>
		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
		<div id="review_form_wrapper">
			<?php
			$rating_count = $product->get_rating_count();
			if ( ! empty( $rating_count ) ) :
				?>
			<div class="review_overall">
				<?php
					$average_rating = $product->get_average_rating();
				?>
				<h3 class="review_overall__title"><?php esc_html_e( 'Average score', 'woocommerce' ); ?></h3>
				<div class="review_overall__content">
					<?php if ( empty( $rating_count ) ) : ?>
						<span><?php esc_html_e( 'No rating for this moment', 'woocommerce' ); ?></span>
					<?php else : ?>
						<?php brandy_get_rating_html( $product, $average_rating, $rating_count ); ?>
					<?php endif; ?>
				</div>
			</div>
			<?php endif; ?>
			<div id="review_form">
				<?php
				$commenter    = wp_get_current_commenter();
				$comment_form = array(
					/* translators: %s is product title */
					'title_reply'         => have_comments() ? '' : sprintf( esc_html__( '%1$sBe the first to review &ldquo;%2$s&rdquo;%3$s', 'woocommerce' ), '<strong>', get_the_title(), '</strong>' ),
					/* translators: %s is product title */
					'title_reply_to'      => esc_html__( 'Leave a Reply to %s', 'woocommerce' ),
					'title_reply_before'  => '<span id="reply-title" class="comment-reply-title">',
					'title_reply_after'   => '</span>',
					'comment_notes_after' => '',
					'logged_in_as'        => '',
					'comment_field'       => '',
					'submit_button'       => '<button name="%1$s" type="submit" id="%2$s" class="wp-element-button %3$s" value="%4$s" title="Submit review">' . __( 'Submit review', 'woocommerce' ) . '</button>',
				);

				$name_email_required = (bool) get_option( 'require_name_email', 1 );
				$fields              = array(
					'author' => array(
						'label'       => __( 'Name', 'woocommerce' ),
						'type'        => 'text',
						'value'       => $commenter['comment_author'],
						'required'    => $name_email_required,
						'placeholder' => __( 'Enter your name', 'woocommerce' ),
					),
					'email'  => array(
						'label'       => __( 'Email', 'woocommerce' ),
						'type'        => 'email',
						'value'       => $commenter['comment_author_email'],
						'required'    => $name_email_required,
						'placeholder' => __( 'Enter your email', 'woocommerce' ),
					),
				);

				$comment_form['fields'] = array();

				foreach ( $fields as $key => $field ) {
					$field_html  = '<p class="comment-form-' . esc_attr( $key ) . '">';
					$field_html .= '<label for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] );

					if ( $field['required'] ) {
						$field_html .= '&nbsp;<span class="required">*</span>';
					}

					$field_html .= '</label><input id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" type="' . esc_attr( $field['type'] ) . '" value="' . esc_attr( $field['value'] ) . '" size="30" ' . ( $field['required'] ? 'required' : '' ) . ' /></p>';

					$comment_form['fields'][ $key ] = $field_html;
				}

				$account_page_url = wc_get_page_permalink( 'myaccount' );
				if ( $account_page_url ) {
					/* translators: %s opening and closing link tags respectively */
					$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'woocommerce' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
				}

				$replyto = isset( $_GET['replytocom'] ) ? absint( $_GET['replytocom'] ) : false;

				if ( wc_review_ratings_enabled() && ! $replyto ) {
					$comment_form['comment_field'] = '<div id="brandy-rating">
					<label for="rating">' . esc_html__( 'Your rating', 'woocommerce' ) . '</label>
					<div class="brandy-ratings__stars"></div>
					</div>';
				}

				$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'woocommerce' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" placeholder="' . esc_html__( 'Write your review...', 'woocommerce' ) . '" required></textarea></p>';

				comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>
	<?php else : ?>
		<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?></p>
	<?php endif; ?>

	<div class="clear"></div>
</div>
