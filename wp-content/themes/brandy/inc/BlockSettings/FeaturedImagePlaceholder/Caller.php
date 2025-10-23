<?php

namespace Brandy\BlockSettings\FeaturedImagePlaceholder;

use Brandy\Traits\SingletonTrait;
use Brandy\Interfaces\ExternalBlockSettingsInterface;

class Caller implements ExternalBlockSettingsInterface {
	use SingletonTrait;

	protected function __construct() {
		add_filter( 'block_type_metadata_settings', array( $this, 'declare_attribute' ), 10 );
		add_filter( 'block_type_metadata_settings', array( $this, 'override_callback' ), 10, 2 );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_settings_scripts' ) );
	}

	public function declare_attribute( $settings ) {

		if ( empty( $settings['name'] ) ) {
			return $settings;
		}

		if ( 'core/post-featured-image' !== $settings['name'] ) {
			return $settings;
		}

		if ( ! empty( $settings['attributes'] ) ) {
			$settings['attributes']['showPlaceholder'] = array(
				'type'    => 'boolean',
				'default' => true,
			);
		}
		return $settings;
	}

	/**
	 * Override block callback
	 */
	public function override_callback( $settings, $metadata ) {
		if ( 'core/post-featured-image' === $metadata['name'] ) {
			$settings['render_callback'] = array( $this, 'render_callback' );
		}
		return $settings;
	}

	public function enqueue_settings_scripts() {
		wp_enqueue_script( 'brandy/featured-image-placeholder', BRANDY_TEMPLATE_URL . '/inc/BlockSettings/FeaturedImagePlaceholder/script.js', array( 'wp-edit-post' ), BRANDY_SCRIPT_VERSION, true );
	}

	/**
	 * Override Gutenberg code to render post featured image.
	 * Return placeholder when there is no featured image.
	 */
	public function render_callback( $attributes, $content, $block ) {
		if ( ! isset( $block->context['postId'] ) ) {
			return '';
		}
		$post_ID = $block->context['postId'];

		$is_link        = isset( $attributes['isLink'] ) && $attributes['isLink'];
		$size_slug      = isset( $attributes['sizeSlug'] ) ? $attributes['sizeSlug'] : 'post-thumbnail';
		$attr           = get_block_core_post_featured_image_border_attributes( $attributes );
		$overlay_markup = get_block_core_post_featured_image_overlay_element_markup( $attributes );

		if ( $is_link ) {
			if ( get_the_title( $post_ID ) ) {
				$attr['alt'] = trim( strip_tags( get_the_title( $post_ID ) ) );
			} else {
				$attr['alt'] = sprintf(
					// translators: %d is the post ID.
					__( 'Untitled post %d', 'brandy' ),
					$post_ID
				);
			}
		}

		$extra_styles = '';

		// Aspect ratio with a height set needs to override the default width/height.
		if ( ! empty( $attributes['aspectRatio'] ) ) {
			$extra_styles .= 'width:100%;height:100%;';
		} elseif ( ! empty( $attributes['height'] ) ) {
			$extra_styles .= "height:{$attributes['height']};";
		}

		if ( ! empty( $attributes['scale'] ) ) {
			$extra_styles .= "object-fit:{$attributes['scale']};";
		}

		if ( ! empty( $extra_styles ) ) {
			$attr['style'] = empty( $attr['style'] ) ? $extra_styles : $attr['style'] . $extra_styles;
		}

		$featured_image = get_the_post_thumbnail( $post_ID, $size_slug, $attr );

		$has_placeholder = true;

		if ( empty( $attributes['showPlaceholder'] ?? true ) ) {
			$has_placeholder = false;
		}

		if ( ! $featured_image && $has_placeholder ) {
			$featured_image = brandy_get_post_placeholder_thumbnail( $attr );
		}

		// Get the first image from the post.
		if ( $attributes['useFirstImageFromPost'] && ! $featured_image ) {
			$content_post = get_post( $post_ID );
			$content      = $content_post->post_content;
			$processor    = new \WP_HTML_Tag_Processor( $content );

			if ( $processor->next_tag( 'img' ) ) {
				$tag_html = new \WP_HTML_Tag_Processor( '<img>' );
				$tag_html->next_tag();
				foreach ( $processor->get_attribute_names_with_prefix( '' ) as $name ) {
					$tag_html->set_attribute( $name, $processor->get_attribute( $name ) );
				}
				$featured_image = $tag_html->get_updated_html();
			}
		}

		if ( ! $featured_image ) {
			return '';
		}

		if ( $is_link ) {
			$link_target    = $attributes['linkTarget'];
			$rel            = ! empty( $attributes['rel'] ) ? 'rel="' . esc_attr( $attributes['rel'] ) . '"' : '';
			$height         = ! empty( $attributes['height'] ) ? 'style="' . esc_attr( safecss_filter_attr( 'height:' . $attributes['height'] ) ) . '"' : '';
			$featured_image = sprintf(
				'<a href="%1$s" target="%2$s" %3$s %4$s>%5$s%6$s</a>',
				get_the_permalink( $post_ID ),
				esc_attr( $link_target ),
				$rel,
				$height,
				$featured_image,
				$overlay_markup
			);
		} else {
			$featured_image = $featured_image . $overlay_markup;
		}

		$aspect_ratio = ! empty( $attributes['aspectRatio'] )
			? esc_attr( safecss_filter_attr( 'aspect-ratio:' . $attributes['aspectRatio'] ) ) . ';'
			: '';
		$width        = ! empty( $attributes['width'] )
			? esc_attr( safecss_filter_attr( 'width:' . $attributes['width'] ) ) . ';'
			: '';
		$height       = ! empty( $attributes['height'] )
			? esc_attr( safecss_filter_attr( 'height:' . $attributes['height'] ) ) . ';'
			: '';
		if ( ! $height && ! $width && ! $aspect_ratio ) {
			$wrapper_attributes = get_block_wrapper_attributes();
		} else {
			$wrapper_attributes = get_block_wrapper_attributes( array( 'style' => $aspect_ratio . $width . $height ) );
		}
		return "<figure {$wrapper_attributes}>{$featured_image}</figure>";
	}

}

Caller::get_instance();
