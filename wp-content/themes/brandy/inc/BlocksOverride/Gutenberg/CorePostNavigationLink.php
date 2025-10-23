<?php

namespace Brandy\BlocksOverride\Gutenberg;

use Brandy\Traits\SingletonTrait;

/**
 * Override WP latest posts block
 */
class CorePostNavigationLink {
	use SingletonTrait;

	protected function __construct() {
		add_filter( 'block_type_metadata_settings', array( $this, 'override_callback' ), 10, 2 );
	}

	/**
	 * Override block callback
	 */
	public function override_callback( $settings, $metadata ) {
		if ( 'core/post-navigation-link' === $metadata['name'] ) {
			$settings['render_callback'] = array( $this, 'render_callback' );
		}
		return $settings;
	}

	public function render_callback( $attributes ) {
		if ( ! is_singular() ) {
			return '';
		}

		// Get the navigation type to show the proper link. Available options are `next|previous`.
		$navigation_type = isset( $attributes['type'] ) ? $attributes['type'] : 'next';
		// Allow only `next` and `previous` in `$navigation_type`.
		if ( ! in_array( $navigation_type, array( 'next', 'previous' ), true ) ) {
			return '';
		}
		$classes = "post-navigation-link-$navigation_type";
		if ( isset( $attributes['textAlign'] ) ) {
			$classes .= " has-text-align-{$attributes['textAlign']}";
		}
		$wrapper_attributes = get_block_wrapper_attributes(
			array(
				'class' => $classes,
			)
		);
		// Set default values.
		$format = '%link';
		$link   = 'next' === $navigation_type ? __( 'Next', 'brandy' ) : __( 'Previous', 'brandy' );
		$label  = '';

		// Only use hardcoded values here, otherwise we need to add escaping where these values are used.
		$arrow_map = array(
			'none'    => '',
			'arrow'   => array(
				'next'     => '→',
				'previous' => '←',
			),
			'chevron' => array(
				'next'     => '»',
				'previous' => '«',
			),
		);

		// If a custom label is provided, make this a link.
		// `$label` is used to prepend the provided label, if we want to show the page title as well.
		if ( isset( $attributes['label'] ) && ! empty( $attributes['label'] ) ) {
			$label = "{$attributes['label']}";
			$link  = $label;
		}

		// If we want to also show the page title, make the page title a link and prepend the label.
		if ( isset( $attributes['showTitle'] ) && $attributes['showTitle'] ) {
			/*
			 * If the label link option is not enabled but there is a custom label,
			 * display the custom label as text before the linked title.
			 */
			if ( ! $attributes['linkLabel'] ) {
				if ( $label ) {
					$format = '<span class="post-navigation-link__label">' . wp_kses_post( $label ) . '</span> %link';
				}
				$link = '%title';
			} elseif ( isset( $attributes['linkLabel'] ) && $attributes['linkLabel'] ) {
				// If the label link option is enabled and there is a custom label, display it before the title.
				if ( $label ) {
					$link = '<span class="post-navigation-link__label">' . wp_kses_post( $label ) . '</span> <span class="post-navigation-link__title">%title</span>';
				} else {
					/*
					 * If the label link option is enabled and there is no custom label,
					 * add a colon between the label and the post title.
					 */
					$label = 'next' === $navigation_type ? __( 'Next:', 'brandy' ) : __( 'Previous:', 'brandy' );
					$link  = sprintf(
						'<span class="post-navigation-link__label">%1$s</span> <span class="post-navigation-link__title">%2$s</span>',
						wp_kses_post( $label ),
						'%title'
					);
				}
			}
		}

		if ( 'previous' === $navigation_type && is_attachment() ) {
			$post = get_post( get_post()->post_parent );
		} else {
			if ( ! empty( $attributes['taxonomy'] ) ) {
				$post = get_adjacent_post( true, '', $attributes['taxonomy'] );
			} else {
				$post = get_adjacent_post( false, '', 'previous' === $navigation_type );
			}
		}

		$post_thumbnail = get_the_post_thumbnail( $post->ID ?? 0 );
		if ( empty( $post_thumbnail ) ) {
			$post_thumbnail = brandy_get_post_placeholder_thumbnail();
		}

		// Display arrows.
		if ( isset( $attributes['arrow'] ) && 'none' !== $attributes['arrow'] && isset( $arrow_map[ $attributes['arrow'] ] ) ) {
			$arrow = $arrow_map[ $attributes['arrow'] ][ $navigation_type ];

			$format = '%link';
			$link   = sprintf(
				'
				<div class="post-navigation-link-action post-navigation-link-action--%s">
					<div class="post-navigation-link__post-thumbnail post-navigation-link__previous-post-thumbnail">
					%s<span class="post-navigation-link__arrow">%s</span>
					</div>
					<div class="post-navigation-link__content">
						<p class="post-navigation-link__label">%s post</p>
						<p class="post-navigation-link__title">%s</p>
					</div>
					</div>
			',
				$navigation_type,
				$post_thumbnail,
				$arrow,
				'next' === $navigation_type ? __( 'Next', 'brandy' ) : __( 'Previous', 'brandy' ),
				$post->post_title ?? ''
			);
		}

		/*
		 * The dynamic portion of the function name, `$navigation_type`,
		 * Refers to the type of adjacency, 'next' or 'previous'.
		 *
		 * @see https://developer.wordpress.org/reference/functions/get_previous_post_link/
		 * @see https://developer.wordpress.org/reference/functions/get_next_post_link/
		 */
		$get_link_function = "get_{$navigation_type}_post_link";

		if ( ! empty( $attributes['taxonomy'] ) ) {
			$content = $get_link_function( $format, $link, true, '', $attributes['taxonomy'] );
		} else {
			$content = $get_link_function( $format, $link );
		}

		return sprintf(
			'<div %1$s>%2$s</div>',
			$wrapper_attributes,
			$content
		);
	}
}
