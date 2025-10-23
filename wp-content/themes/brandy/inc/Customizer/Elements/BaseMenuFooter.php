<?php

namespace Brandy\Customizer\Elements;

use Brandy\Core\Services\TypographyService;

class BaseMenuFooter extends BaseMenu {

	protected $builders = array( 'footer' );

	public function template_path() {
		return 'template-parts/builder/elements/menu_footer';
	}

	protected function register_components() {
		$parent_components                   = parent::register_components();
		$components                          = array();
		$components['menu_name']             = $parent_components['menu_name'];
		$components['css_classes']           = $parent_components['css_classes'];
		$components['menu_item_reset']       = $parent_components['menu_item_reset'];
		$components['menu_text_typography']  = $parent_components['menu_text_typography'];
		$components['menu_text_color']       = $parent_components['menu_text_color'];
		$components['item_spacing']          = $parent_components['item_spacing'];
		$components['items_direction']       = array(
			'title'          => array(
				'text'         => __( 'Item Direction', 'brandy' ),
				'type'         => 'bold',
				'show_devices' => true,
			),
			'type'           => 'ButtonGroup',
			'default_value'  => array(
				'desktop' => 'horizontal',
				'tablet'  => null,
				'mobile'  => null,
			),
			'is_responsive'  => true,
			'value_path'     => array( 'items_direction' ),
			'options'        => array(
				array(
					'label' => __( 'Horizontal', 'brandy' ),
					'value' => 'horizontal',
				),
				array(
					'label' => __( 'Vertical', 'brandy' ),
					'value' => 'vertical',
				),
			),
			'render_options' => array(
				'type' => 'data_attribute',
				'data' => array(
					array(
						'selector'   => '.brandy-element-wrapper',
						'name'       => 'layout-desktop',
						'value_path' => array( 'items_direction', 'desktop' ),
					),
					array(
						'selector'   => '.brandy-element-wrapper',
						'name'       => 'layout-tablet',
						'value_path' => array( 'items_direction', 'tablet' ),
					),
					array(
						'selector'   => '.brandy-element-wrapper',
						'name'       => 'layout-mobile',
						'value_path' => array( 'items_direction', 'mobile' ),
					),
				),
			),
		);
		$components['menu_title_text']       = array(
			'title'          => array(
				'text' => __( 'Menu title', 'brandy' ),
				'type' => 'bold',
			),
			'type'           => 'TextInput',
			'default_value'  => 'Menu',
			'value_path'     => array( 'menu_title_text' ),
			'render_options' => array(
				'type' => 'content',
				'data' => array(
					array(
						'selector'   => '.brandy-menu-title',
						'value_path' => array( 'menu_title_text' ),
					),
				),
			),
		);
		$components['horizontal_alignment']  = array(
			'title'          => array(
				'text'         => __( 'Horizontal Alignment', 'brandy' ),
				'type'         => 'bold',
				'show_devices' => true,
			),
			'type'           => 'Alignment',
			'default_value'  => array(
				'desktop' => 'left',
				'tablet'  => null,
				'mobile'  => null,
			),
			'is_responsive'  => true,
			'value_path'     => array( 'horizontal_alignment' ),
			'render_options' => array(
				'type' => 'data_attribute',
				'data' => array(
					array(
						'selector'   => '.brandy-element-wrapper',
						'name'       => 'alignment-desktop',
						'value_path' => array( 'horizontal_alignment', 'desktop' ),
					),
					array(
						'selector'   => '.brandy-element-wrapper',
						'name'       => 'alignment-tablet',
						'value_path' => array( 'horizontal_alignment', 'tablet' ),
					),
					array(
						'selector'   => '.brandy-element-wrapper',
						'name'       => 'alignment-mobile',
						'value_path' => array( 'horizontal_alignment', 'mobile' ),
					),
				),
			),
		);
		$components['menu_title_reset']      = array(
			'title'       => array(
				'text'         => __( 'Title', 'brandy' ),
				'type'         => 'bold',
				'show_devices' => true,
			),
			'type'        => 'Reset',
			'reset_paths' => array(
				array( 'menu_title' ),
			),
		);
		$components['title_spacing']         = array(
			'value_path'     => array( 'menu_title', 'spacing' ),
			'title'          => array(
				'text' => __( 'Title spacing', 'brandy' ),
				'type' => 'normal',
			),
			'default_value'  => array(
				'desktop' => array(
					'unit'  => 'px',
					'value' => 10,
					'min'   => 0,
					'max'   => 100,
				),
				'tablet'  => null,
				'mobile'  => null,
			),
			'is_responsive'  => true,
			'type'           => 'Dimension',
			'render_options' => array(
				'type' => 'variable',
				'data' => array(
					array(
						'type'       => 'dimension',
						'name'       => '--b-title-spacing',
						'value_path' => array( 'menu_title', 'spacing' ),
					),
				),
			),
		);
		$components['menu_title_typography'] = array(
			'title'          => array(
				'text' => __( 'Typography', 'brandy' ),
				'type' => 'normal',
			),
			'value_path'     => array( 'menu_title', 'typography' ),
			'default_value'  => null,
			'type'           => 'Typography',
			'is_responsive'  => true,
			'render_options' => array(
				'type' => 'variable',
				'data' => array(
					array(
						'type'       => 'typography',
						'selector'   => '.brandy-menu-title:not(:empty)',
						'value_path' => array( 'menu_title', 'typography' ),
					),
				),
			),
		);
		$components['menu_title_color']      = array(
			'value_path'     => array( 'menu_title', 'color' ),
			'title'          => array(
				'text' => __( 'Title color', 'brandy' ),
				'type' => 'normal',
			),
			'default_value'  => array(
				'normal' => array(
					'desktop' => '#000000',
					'tablet'  => null,
					'mobile'  => null,
				),
			),
			'is_responsive'  => true,
			'type'           => 'ColorGroup',
			'render_options' => array(
				'type' => 'variable',
				'data' => array(
					array(
						'type'       => 'color',
						'name'       => '--b-title-color',
						'value_path' => array( 'menu_title', 'color' ),
					),
				),
			),
		);
		$components['item_spacing']          = array(
			'value_path'     => array( 'item_spacing' ),
			'title'          => array(
				'text'         => __( 'Item main spacing', 'brandy' ),
				'type'         => 'bold',
				'show_devices' => true,
			),
			'default_value'  => array(
				'desktop' => array(
					'unit'  => 'px',
					'value' => 10,
					'min'   => 0,
					'max'   => 100,
				),
				'tablet'  => null,
				'mobile'  => null,
			),
			'is_responsive'  => true,
			'type'           => 'Dimension',
			'render_options' => array(
				'type' => 'variable',
				'data' => array(
					array(
						'type'       => 'dimension',
						'name'       => '--b-item-spacing',
						'value_path' => array( 'item_spacing' ),
					),
				),
			),
		);
		$components['item_extra_spacing']    = array(
			'value_path'     => array( 'item_extra_spacing' ),
			'title'          => array(
				'text'         => __( 'Rows spacing', 'brandy' ),
				'type'         => 'bold',
				'show_devices' => true,
			),
			'default_value'  => array(
				'desktop' => array(
					'unit'  => 'px',
					'value' => 10,
					'min'   => 0,
					'max'   => 100,
				),
				'tablet'  => null,
				'mobile'  => null,
			),
			'is_responsive'  => true,
			'type'           => 'Dimension',
			'render_options' => array(
				'type' => 'variable',
				'data' => array(
					array(
						'type'       => 'dimension',
						'name'       => '--b-item-extra-spacing',
						'value_path' => array( 'item_extra_spacing' ),
					),
				),
			),
		);
		$components['padding']               = array(
			'title'          => array(
				'text'         => __( 'Padding', 'brandy' ),
				'type'         => 'bold',
				'show_devices' => true,
			),
			'value_path'     => array( 'padding' ),
			'type'           => 'Spacing',
			'units'          => array( 'px', '%' ),
			'is_responsive'  => true,
			'default_value'  => array(
				'desktop' => array(
					'unit'           => 'px',
					'top'            => 10,
					'right'          => 10,
					'bottom'         => 10,
					'left'           => 10,
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
		);
		return $components;
	}

	public function add_layout( $layouts = array() ) {
		$layout                       = array(
			'general' => array(
				'sections' => array(
					array(
						'components' => array(
							'menu_name',
						),
					),
					array(
						'components' => array(
							'items_direction',
						),
					),
					array(
						'components' => array(
							'menu_title_text',
						),
					),
					array(
						'visible_conditions' => array(
							array(
								'value_path' => array( 'items_direction' ),
								'value'      => 'vertical',
							),
						),
						'components'         => array(
							'horizontal_alignment',
						),
					),
					array(
						'components' => array(
							'css_classes',
						),
					),
				),
			),
			'designs' => array(
				'sections' => array(
					array(
						'components' => array(
							'menu_item_reset',
							'menu_text_typography',
							'menu_text_color',
						),
					),
					array(
						'components' => array(
							'menu_title_reset',
							'title_spacing',
							'menu_title_typography',
							'menu_title_color',
						),
					),
					array(
						'components' => array( 'item_spacing' ),
					),
					array(
						'components'         => array( 'item_extra_spacing' ),
						'visible_conditions' => array(
							array(
								'value_path' => array( 'items_direction' ),
								'value'      => 'horizontal',
							),
						),
					),
					array(
						'components' => array( 'padding' ),
					),
				),
			),
		);
		$mapped_layout                = $this->map_layout( $layout );
		$layouts[ $this->element_id ] = $mapped_layout;
		return $layouts;
	}
}
