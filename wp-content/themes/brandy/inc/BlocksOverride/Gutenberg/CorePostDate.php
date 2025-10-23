<?php

namespace Brandy\BlocksOverride\Gutenberg;

use Brandy\Traits\SingletonTrait;

/**
 * Override WP latest posts block
 */
class CorePostDate {
	use SingletonTrait;

	protected function __construct() {
		add_filter( 'block_type_metadata_settings', array( $this, 'override_callback' ), 10, 2 );
	}

	/**
	 * Override block callback
	 */
	public function override_callback( $settings, $metadata ) {
		if ( 'core/post-date' === $metadata['name'] ) {
			$settings['render_callback'] = array( $this, 'render_callback' );
		}

		return $settings;
	}

	public function render_callback( $attributes, $content, $block ) {
		if ( ! isset( $block->context['postId'] ) ) {
			return '';
		}

		$post_ID = $block->context['postId'];

		if ( isset( $attributes['format'] ) && 'human-diff' === $attributes['format'] ) {
			$post_timestamp = get_post_timestamp( $post_ID );
			if ( $post_timestamp > time() ) {
				// translators: %s: human-readable time difference.
				$formatted_date = sprintf( __( '%s from now', 'brandy' ), human_time_diff( $post_timestamp ) );
			} else {
				// translators: %s: human-readable time difference.
				$formatted_date = sprintf( __( '%s ago', 'brandy' ), human_time_diff( $post_timestamp ) );
			}
		} else {
			$formatted_date = get_the_date( empty( $attributes['format'] ) ? '' : $attributes['format'], $post_ID );
		}
		$unformatted_date = esc_attr( get_the_date( 'c', $post_ID ) );
		$classes          = array();

		if ( isset( $attributes['textAlign'] ) ) {
			$classes[] = 'has-text-align-' . $attributes['textAlign'];
		}
		if ( isset( $attributes['style']['elements']['link']['color']['text'] ) ) {
			$classes[] = 'has-link-color';
		}

		if ( isset( $attributes['displayType'] ) && 'modified' === $attributes['displayType'] ) {
			if ( get_the_modified_date( 'Ymdhi', $post_ID ) > get_the_date( 'Ymdhi', $post_ID ) ) {
				if ( isset( $attributes['format'] ) && 'human-diff' === $attributes['format'] ) {
					// translators: %s: human-readable time difference.
					$formatted_date = sprintf( __( '%s ago', 'brandy' ), human_time_diff( get_post_timestamp( $post_ID, 'modified' ) ) );
				} else {
					$formatted_date = get_the_modified_date( empty( $attributes['format'] ) ? '' : $attributes['format'], $post_ID );
				}
				$unformatted_date = esc_attr( get_the_modified_date( 'c', $post_ID ) );
				$classes[]        = 'wp-block-post-date__modified-date';
			}
		}

		$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => implode( ' ', $classes ) ) );

		if ( isset( $attributes['isLink'] ) && $attributes['isLink'] ) {
			$formatted_date = sprintf( '<a href="%1s">%2s</a>', get_the_permalink( $post_ID ), $formatted_date );
		}

		return sprintf(
			'<div %1$s><time datetime="%2$s">%3$s</time></div>',
			$wrapper_attributes,
			$unformatted_date,
			$formatted_date
		);
	}

}
