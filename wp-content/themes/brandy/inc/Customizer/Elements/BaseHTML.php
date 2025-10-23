<?php

namespace Brandy\Customizer\Elements;

use Brandy\Abstracts\AbstractBaseElement;
use Brandy\Core\Services\StringVariablesService;

class BaseHTML extends AbstractBaseElement {

	/**
	 * Builders that element belong to
	 *
	 * @var string
	 */
	protected $builders = array( 'header', 'footer' );

	public function template_path() {
		return 'template-parts/builder/elements/html';
	}

	/**
	 * Element icon
	 *
	 * @var string
	 */
	protected $icon = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
	<path d="M21 19L25 15L21 11M9 11L5 15L9 19M17.5 7L12.5 23" stroke="' . BRANDY_ICON_COLOR_NORMAL . '" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
	</svg>
	';

	/**
	 * Register Element settings components
	 *
	 * @return array
	 */
	protected function register_components() {
		return array(
			'content'           => array(
				'type'           => 'HTML',
				'description'    => sprintf( __( 'Arbitrary HTML code or shortcode. Available tags: %s', 'brandy' ), StringVariablesService::get_string_list_variables() ),
				'value_path'     => array( 'content' ),
				'default_value'  => 'Insert HTML text here',
				'render_options' => array(
					'type' => 'content',
					'data' => array(
						array(
							'selector'   => '.brandy-element-wrapper',
							'value_path' => array( 'content' ),
						),
					),
				),
			),
			'content_alignment' => array(
				'title'          => array(
					'text'         => __( 'Content Alignment', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'           => 'Alignment',
				'value_path'     => array( 'content_alignment' ),
				'default_value'  => array(
					'desktop' => 'left',
					'tablet'  => null,
					'mobile'  => null,
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'name'       => '--b-content-alignment',
							'value_path' => array( 'content_alignment' ),
						),
					),
				),
			),
			'text_reset'        => array(
				'title'       => array(
					'text'         => __( 'Text', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'text_color' ),
					array( 'link_color' ),
				),
			),
			'text_color'        => array(
				'title'          => array(
					'text' => __( 'Text color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
				'value_path'     => array( 'text_color' ),
				'default_value'  => array(
					'normal' => array(
						'desktop' => 'var(--wp--preset--color--brandy-primary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-text-color',
							'value_path' => array( 'text_color' ),
						),
					),
				),
			),
			'link_color'        => array(
				'title'          => array(
					'text' => __( 'Link color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
				'value_path'     => array( 'link_color' ),
				'default_value'  => array(
					'normal' => array(
						'desktop' => 'var(--wp--preset--color--brandy-primary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-link-color',
							'value_path' => array( 'link_color' ),
						),
					),
				),
			),
			'padding'           => array(
				'title'          => array(
					'text'         => __( 'Padding', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'value_path'     => array( 'padding' ),
				'type'           => 'Spacing',
				'units'          => array( 'px', '%' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'           => 'px',
						'top'            => 0,
						'right'          => 0,
						'bottom'         => 0,
						'left'           => 0,
						'is_constraints' => false,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'spacing',
							'name'       => '--b-padding',
							'value_path' => array( 'padding' ),
						),
					),
				),
			),
			'margin'            => array(
				'title'          => array(
					'text'         => __( 'Margin', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'value_path'     => array( 'margin' ),
				'type'           => 'Spacing',
				'units'          => array( 'px', '%' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'           => 'px',
						'top'            => 0,
						'right'          => 0,
						'bottom'         => 0,
						'left'           => 0,
						'is_constraints' => false,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'spacing',
							'name'       => '--b-margin',
							'value_path' => array( 'margin' ),
						),
					),
				),
			),
		);
	}

	/**
	 * Register element settings layout
	 *
	 * @param array General layouts
	 *
	 * @return array
	 */
	public function add_layout( $layouts = array() ) {
		$layout                       = array(
			'general' => array(
				'sections' => array(
					array(
						'components' => array( 'content' ),
					),
					array(
						'components' => array( 'content_alignment' ),
					),
				),
			),
			'designs' => array(
				'sections' => array(
					array(
						'components' => array( 'text_reset', 'text_color', 'link_color' ),
					),
					array(
						'components' => array( 'padding' ),
					),
					array(
						'components' => array( 'margin' ),
					),
				),
			),
		);
		$mapped_layout                = $this->map_layout( $layout );
		$layouts[ $this->element_id ] = $mapped_layout;
		return $layouts;
	}

}
