<?php
/**
 * The template for displaying complex post card layout in post loop
 *
 * Probably use in post loop LIST layout
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="post-card<?php echo is_sticky() ? ' sticky-post' : ''; ?>">
	<div class="post-thumbnail">
		<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php brandy_the_post_thumbnail(); ?></a>
		<div class="post-author">
			<a class="post-author__avatar-link" href="<?php echo esc_url( get_the_author_meta( 'url' ) ); ?>">
				<?php
				echo get_avatar(
					get_the_author_meta( 'ID' ),
					40,
					'',
					'author-avatar',
					array(
						'class' => 'post-author__avatar',
					)
				);
				?>
			</a>
			<?php // Translators: %s Author name. ?>
			<div class="post-author__name"><?php echo esc_html( sprintf( __( 'By %s', 'brandy' ), get_the_author_meta( 'display_name' ) ) ); ?></div>
		</div>
	</div>
	<div class="post-card__content">
		<?php
		$post_tags = get_the_tags();
		if ( false !== $post_tags && ! is_wp_error( $post_tags ) ) :
			?>
		<div class="post__tags">
			<?php
			foreach ( $post_tags as $post_tag ) :
				?>
				<a href="<?php echo esc_url( home_url() . "/?tag={$post_tag->slug}" ); ?>" class="post__tags__item"><span><?php echo esc_html( $post_tag->name ); ?></span></a>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
		<h2 class="post__title">
			<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
		</h2>
		<div class="post__metae__content__detail">
			<?php // Translators: %s Post date. ?>
			<span class="post__date"><?php echo esc_html( sprintf( __( 'Posted on %s ', 'brandy' ), get_the_date() ) ); ?></span>
			<span class="post__metae__content__detail-separator"></span>
			<?php
			$article           = get_the_content();
			$reading_time_text = brandy_get_reading_time( $article );
			?>
			<?php // Translators: %s Time to read post. ?>
			<span><?php echo esc_html( sprintf( __( '%s read ', 'brandy' ), $reading_time_text ) ); ?></span>
		</div>
		<div class="post-excerpt"><?php the_excerpt(); ?></div>
		<div class="post-link">
			<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php esc_html_e( 'Continue reading', 'brandy' ); ?></a>
		</div>
	</div>
</div>
