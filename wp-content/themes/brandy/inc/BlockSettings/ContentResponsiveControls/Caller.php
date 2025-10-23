<?php

namespace Brandy\BlockSettings\ContentResponsiveControls;

use Brandy\Traits\SingletonTrait;
use Brandy\Interfaces\ExternalBlockSettingsInterface;

class Caller implements ExternalBlockSettingsInterface {
	use SingletonTrait;

	protected function __construct() {
		add_filter( 'block_type_metadata_settings', array( $this, 'declare_attribute' ), 100 );
		add_filter( 'render_block', array( $this, 'apply_responsive_controls' ), 100, 3 );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_settings_scripts' ) );
	}

	public function declare_attribute( $settings ) {

		if ( empty( $settings['name'] ) ) {
			return $settings;
		}

		if ( ! $this->is_supported_block( $settings ) ) {
			return $settings;
		}

		if ( ! empty( $settings['attributes'] ) ) {
			$settings['attributes']['responsiveControls'] = array(
				'type'    => 'object',
				'default' => [],
			);
		}
		return $settings;
	}

	public function is_supported_block( $block ) {
		if ( empty( $block['name'] ) ) {
			return false;
		}
		return in_array( $block['name'], array( 'core/group', 'core/column', 'core/buttons', 'core/paragraph', 'core/heading' ) );
	}

	public function enqueue_settings_scripts() {
		wp_enqueue_script( 'brandy/content-responsive-controls', BRANDY_TEMPLATE_URL . '/inc/BlockSettings/ContentResponsiveControls/script.js', array( 'wp-edit-post' ), BRANDY_SCRIPT_VERSION, true );
	}

	/**
	 * Override Gutenberg code to render post featured image.
	 * Return placeholder when there is no featured image.
	 */
	public function apply_responsive_controls( $html, $_, $block ) {
		
		if ( ! $this->is_supported_block( (array)$block ) ) {
			return $html;
		}

		$tag = new \WP_HTML_Tag_Processor( $html );

		if ( $tag->next_tag() ) {
			$responsive_controls = $block->attributes['responsiveControls'] ?? array();
			$class = $tag->get_attribute( 'class' );

			$group_type = 'group';

			if ( isset( $block->attributes['layout']['type'] ) && $block->attributes['layout']['type'] === 'flex' ) {

				if ( isset( $block->attributes['layout']['orientation'] ) && $block->attributes['layout']['orientation'] === 'vertical' ) {
					$group_type = 'stack';
				} else {
					$group_type = 'row';
				}

			}

			if ( ! empty( $responsive_controls['textAlign']['tablet']['enabled'] ) ) {
				$value = $responsive_controls['textAlign']['tablet']['value'] ?? 'center';
				$class = $class . ' md-text-' . $value;
			}

			if ( ! empty( $responsive_controls['textAlign']['mobile']['enabled'] ) ) {
				$value = $responsive_controls['textAlign']['mobile']['value'] ?? 'center';
				$class = $class . ' sm-text-' . $value;
			}

			$justify_type = 'justify';

			if ( $group_type === 'stack' ) {
				$justify_type = 'items';
			}

			if ( ! empty( $responsive_controls['justifyContent']['tablet']['enabled'] ) ) {
				$value = $responsive_controls['justifyContent']['tablet']['value'] ?? 'center';
				$class = $class . ' md-' . $justify_type . '-' . $value;
			}

			if ( ! empty( $responsive_controls['justifyContent']['mobile']['enabled'] ) ) {
				$value = $responsive_controls['justifyContent']['mobile']['value'] ?? 'center';
				$class = $class . ' sm-' . $justify_type . '-' . $value;
			}

			$tag->set_attribute( 'class', $class );

			$html = $tag->get_updated_html();
		}

		return $html;
		
	}

}

Caller::get_instance();
