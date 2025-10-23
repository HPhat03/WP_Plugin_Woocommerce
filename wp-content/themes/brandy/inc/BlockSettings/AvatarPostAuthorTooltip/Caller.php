<?php

namespace Brandy\BlockSettings\AvatarPostAuthorTooltip;

use Brandy\Traits\SingletonTrait;
use Brandy\Interfaces\ExternalBlockSettingsInterface;

class Caller implements ExternalBlockSettingsInterface {
	use SingletonTrait;

	public const SHADOW_PRESETS = array(
		'default' => array(
			'shadow' => array(),
		),
		'none'    => array(
			'shadow' => array(
				'x'      => '0px',
				'y'      => '0px',
				'blur'   => '0px',
				'inset'  => false,
				'spread' => '0px',
			),
		),
		'small'   => array(
			'shadow' => array(
				'x'      => '0px',
				'y'      => '1px',
				'blur'   => '3px',
				'spread' => '0px',
				'inset'  => false,
				'color'  => '#000A391F',
			),
		),
		'regular' => array(
			'shadow' => array(
				'x'      => '0px',
				'y'      => '5px',
				'blur'   => '15px',
				'spread' => '0px',
				'inset'  => false,
				'color'  => '#000A3912',
			),
		),
		'medium'  => array(
			'shadow' => array(
				'x'      => '0px',
				'y'      => '15px',
				'blur'   => '50px',
				'spread' => '0px',
				'inset'  => false,
				'color'  => '#000A391A',
			),
		),
		'large'   => array(
			'shadow' => array(
				'x'      => '0px',
				'y'      => '15px',
				'blur'   => '50px',
				'spread' => '0px',
				'inset'  => false,
				'color'  => '#000A3926',
			),
		),
	);

	protected function __construct() {
		add_filter( 'block_type_metadata_settings', array( $this, 'declare_attribute' ), 10, 2 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ) );
		add_action( 'enqueue_block_assets', array( $this, 'enqueue_frontend_scripts' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_settings_scripts' ) );
		add_filter( 'render_block', array( $this, 'apply_tooltip_settings_to_blocks' ), 9, 3 );
	}

	public function declare_attribute( $settings ) {
		if ( empty( $settings['attributes'] ) ) {
			return $settings;
		}

		if ( empty( $settings['name'] ) ) {
			return $settings;
		}

		if ( 'core/avatar' === $settings['name'] ) {
			$settings['attributes']['hasTooltip']             = array(
				'type'    => 'boolean',
				'default' => false,
			);
			$settings['attributes']['tooltipColor']           = array(
				'type'    => 'string',
				'default' => '#ffffff',
			);
			$settings['attributes']['tooltipBackgroundColor'] = array(
				'type'    => 'string',
				'default' => '#1d1e20',
			);
			$settings['attributes']['tooltipBorder']          = array(
				'type'    => 'object',
				'default' => array(),
			);
			$settings['attributes']['tooltipShadow']          = array(
				'type'    => 'object',
				'default' => array(
					'type'   => 'default',
					'custom' => false,
					'inset'  => false,
					'color'  => '#0000001A',
					'x'      => '0px',
					'y'      => '2px',
					'blur'   => '3px',
					'spread' => '0px',
				),
			);
		}

		return $settings;
	}

	public function enqueue_settings_scripts() {
		wp_enqueue_script( 'brandy/avatar-post-author-tooltip', BRANDY_TEMPLATE_URL . '/inc/BlockSettings/AvatarPostAuthorTooltip/script.js', array( 'wp-edit-post' ), BRANDY_SCRIPT_VERSION, true );
	}

	public function enqueue_frontend_scripts() {
		wp_enqueue_style( 'brandy/avatar-post-author-tooltip', BRANDY_TEMPLATE_URL . '/inc/BlockSettings/AvatarPostAuthorTooltip/style.css', array(), BRANDY_SCRIPT_VERSION );
	}

	public function apply_tooltip_settings_to_blocks( $html, $_, $block ) {
		if ( 'core/avatar' !== $block->name ) {
			return $html;
		}

		$has_tooltip = isset( $block->attributes['hasTooltip'] ) ? $block->attributes['hasTooltip'] : false;

		if ( ! $has_tooltip ) {
			return $html;
		}

		$tooltip_content = '';

		$tag = new \WP_HTML_Tag_Processor( $html );

		if ( $tag->next_tag() ) {

			if ( ! empty( $block->attributes['tooltipColor'] ) ) {
				$tooltip_color = $block->attributes['tooltipColor'];
			}

			if ( ! empty( $block->attributes['tooltipBackgroundColor'] ) ) {
				$tooltip_background_color = $block->attributes['tooltipBackgroundColor'];
			}

			if ( ! empty( $block->attributes['tooltipBorder'] ) ) {
				$tooltip_border = $block->attributes['tooltipBorder'];
			}

			if ( ! empty( $block->attributes['tooltipShadow'] ) ) {
				$tooltip_shadow = $block->attributes['tooltipShadow'];
			}

			$escape_styles = array();

			// Add hover background color
			if ( isset( $tooltip_color ) ) {
				$escape_styles[] = '--b-tooltip-color:' . $tooltip_color;
			}

			if ( isset( $tooltip_background_color ) ) {
				$escape_styles[] = '--b-tooltip-bg:' . $tooltip_background_color;
			}

			if ( isset( $tooltip_border ) ) {
				foreach ( array( 'top', 'bottom', 'left', 'right' ) as $aspect ) {
					if ( isset( $tooltip_border[ $aspect ]['color'] ) ) {
						$escape_styles[] = '--b-tooltip-border-' . $aspect . '-c:' . $tooltip_border[ $aspect ]['color'];
					}
					if ( isset( $tooltip_border[ $aspect ]['width'] ) ) {
						$escape_styles[] = '--b-tooltip-border-' . $aspect . '-w:' . $tooltip_border[ $aspect ]['width'];
					}
					if ( isset( $tooltip_border[ $aspect ]['style'] ) ) {
						$escape_styles[] = '--b-tooltip-border-' . $aspect . '-s:' . $tooltip_border[ $aspect ]['style'];
					}
				}
				if ( isset( $tooltip_border['color'] ) ) {
					$escape_styles[] = '--b-tooltip-border-c:' . $tooltip_border['color'];
				}
				if ( isset( $tooltip_border['width'] ) ) {
					$escape_styles[] = '--b-tooltip-border-w:' . $tooltip_border['width'];
				}
				if ( isset( $tooltip_border['style'] ) ) {
					$escape_styles[] = '--b-tooltip-border-s:' . $tooltip_border['style'];
				}
			}

			if ( isset( $tooltip_shadow ) ) {
				if ( empty( $tooltip_shadow['custom'] ) ) {
					$tooltip_shadow = self::SHADOW_PRESETS[ $tooltip_shadow['type'] ]['shadow'] ?? array();
				}
			}
			if ( ! empty( $tooltip_shadow ) ) {
				$escape_styles[] = '--b-tooltip-shadow:' . ( $tooltip_shadow['inset'] ? 'inset' : '' ) . $tooltip_shadow['x'] . ' ' . $tooltip_shadow['y'] . ' ' . $tooltip_shadow['blur'] . ' ' . $tooltip_shadow['spread'] . ' ' . $tooltip_shadow['color'];
			}

			if ( ! isset( $block->context['commentId'] ) ) {
				if ( isset( $block->attributes['userId'] ) ) {
					$author_id = $block->attributes['userId'];
				} elseif ( isset( $block->context['postId'] ) ) {
					$author_id = get_post_field( 'post_author', $block->context['postId'] );
				} else {
					$author_id = get_query_var( 'author' );
				}

				if ( empty( $author_id ) ) {
					return '';
				}

				$author_name = get_the_author_meta( 'display_name', $author_id );
				// translators: %s is the Author name.
				$tooltip_content = '<span class="wp-block-avatar__tooltip">' . sprintf( __( 'By %s', 'brandy' ), $author_name ) . '</span>';

			}

			if ( ! empty( $tooltip_content ) ) {
				// Update the style attribute
				$existing_style = $tag->get_attribute( 'style' );
				$updated_style  = '';

				if ( empty( $existing_style ) ) {
					$existing_style = '';
				} elseif ( ! str_ends_with( $existing_style, ';' ) ) {
					$existing_style .= ';';
				}

				$updated_style  = $existing_style;
				$updated_style .= implode( ';', $escape_styles );
				$tag->set_attribute( 'style', $updated_style );

				$html = $tag->get_updated_html();
				$html = str_replace( '</div>', $tooltip_content . '</div>', trim( $html ) );
			}
		}

		return $html;
	}
}

Caller::get_instance();
