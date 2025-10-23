<?php
/**
 * The template for displaying simple post card layout in post loop
 *
 * Probably use in post loop GRID layout
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="post-card<?php echo is_sticky() ? ' sticky-post' : ''; ?>">
	<div class="post-thumbnail">
		<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php brandy_the_post_thumbnail(); ?></a>
	</div>
	<div class="post-card__content">
		<div class="post__metae__content__detail">
			<div class="post__date"><?php echo esc_html( sprintf( __( 'Posted on %s ', 'brandy' ), get_the_date() ) ); ?></div>
		</div>
		<h2 class="post__title">
			<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
		</h2>
	</div>
</div>
