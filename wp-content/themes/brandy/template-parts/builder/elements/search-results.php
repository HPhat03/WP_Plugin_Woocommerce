<?php
/**
 * The Template for displaying search element results
 *
 * @package Brandy
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( null == $args['search_query'] ) {
	return;
}

$search_query = $args['search_query'];


/**
 * Display empty list
 */
if ( ! $search_query->have_posts() ) {

	echo "<div class='brandy-live-result-empty-state'>" . esc_html__( 'No result found', 'brandy' ) . '</div>';
	return;
}


?>
<div class="brandy-live-result__content-list">	
	<?php while ( $search_query->have_posts() ) : ?>

		<?php
			$search_query->the_post();
			$_post = $search_query->post;
		?>

		<?php
		$post_image = wp_get_attachment_image_src( get_post_thumbnail_id( $_post->ID ), 'single-post-thumbnail' );
		// $description = $_post->post_excerpt;
		if ( isset( $post_image[0] ) ) {
			$post_image = $post_image[0];
		}
		if ( empty( $post_image ) ) {
			$post_image = brandy_get_post_placeholder_thumbnail_url();
		}
		if ( 'product' === $_post->post_type && \is_wc_installed() ) {
				$product = \wc_get_product( $_post->ID );
				$price   = \wc_price( $product->get_price() );
		}
		?>

		<div class='brandy-result-item'>
			<div class='brandy-result-item__image'>
				<a href="<?php echo esc_url( get_permalink( $_post ) ); ?>">
					<img src="<?php echo esc_url( $post_image ); ?>" alt="Search result image"/>
				</a>
			</div>
			<div class='brandy-result-item__information'>
				<h5 class='brandy-result-item__title'><a href="<?php echo esc_url( get_permalink( $_post ) ); ?>"><?php echo esc_html( $_post->post_title ); ?></a></h5>
				<?php if ( isset( $price ) ) : ?>
					<div class='brandy-result-item__price'><?php echo wp_kses_post( $price ); ?></div>
				<?php endif; ?>
			</div>
		</div>

	<?php endwhile; ?>
</div>

<?php if ( ( $search_query->query_vars['offset'] + $search_query->query_vars['posts_per_page'] ) < $search_query->found_posts ) : ?>
<a href="
	<?php
	echo esc_url(
		add_query_arg(
			array(
				's'         => $search_query->query['s'],
				'post_type' => $search_query->query['post_type'],
			),
			get_home_url()
		)
	);
	?>
	" class="brandy-btn brandy-live-result-more wp-block-button__link" title="View more"><?php esc_html_e( 'View more', 'brandy' ); ?></a>
<?php endif; ?>
