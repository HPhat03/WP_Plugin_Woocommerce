<?php

namespace Brandy\Customizer\Elements;

use Brandy\Abstracts\AbstractBaseElement;
use Brandy\Core\Services\TypographyService;

class BaseMenu extends AbstractBaseElement {

	protected $title = 'Menu';

	protected $icon = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path fill-rule="evenodd" clip-rule="evenodd" d="M6.5 15.0003C6.5 10.3057 10.3057 6.5 15.0003 6.5C19.6949 6.5 23.5006 10.3057 23.5006 15.0003C23.5006 19.6949 19.6949 23.5006 15.0003 23.5006C10.3057 23.5006 6.5 19.6949 6.5 15.0003ZM15.0003 5C9.47728 5 5 9.47728 5 15.0003C5 20.5233 9.47728 25.0006 15.0003 25.0006C20.5233 25.0006 25.0006 20.5233 25.0006 15.0003C25.0006 9.47728 20.5233 5 15.0003 5ZM20.1558 9.84496C20.39 10.0792 20.4428 10.4393 20.2858 10.7309L17.0482 16.7436C16.9786 16.8728 16.8727 16.9788 16.7434 17.0483L10.7307 20.2859C10.4391 20.443 10.079 20.3901 9.84484 20.1559C9.61064 19.9217 9.55779 19.5616 9.71482 19.27L12.9402 13.28C12.9756 13.2085 13.023 13.1415 13.0825 13.082C13.1435 13.0209 13.2125 12.9726 13.2861 12.937L19.2699 9.71494C19.5615 9.55792 19.9216 9.61077 20.1558 9.84496ZM12.2208 17.78L13.7954 14.8556L15.1451 16.2053L12.2208 17.78ZM17.7799 12.2209L16.2056 15.1445L14.8563 13.7951L17.7799 12.2209Z" fill="' . BRANDY_ICON_COLOR_NORMAL . '"/>
			</svg>
			';

	protected function __construct() {
		add_filter( 'brandy_extra_localize', array( $this, 'add_localize_data' ) );

		parent::__construct();
	}

	public function template_path() {
		return 'template-parts/builder/elements/menu';
	}

	protected function register_components() {
		return array(
			'menu_name'                  => array(
				'value_path'     => array( 'menu_name' ),
				'default_value'  => 'default',
				'type'           => 'MenuSelection',
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'active_type'                => array(
				'value_path'     => array( 'active_type' ),
				'default_value'  => 'underline',
				'type'           => 'MenuActiveType',
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'menu_overlapped'            => array(
				'title'          => array(
					'text' => __( 'Menu Overlapped Display', 'brandy' ),
					'type' => 'bold',
				),
				'value_path'     => array( 'menu_overlapped' ),
				'default_value'  => 'more-options',
				'type'           => 'ButtonGroup',
				'options'        => array(
					array(
						'label' => 'Flex Wrap',
						'value' => 'flex-wrap',
					),
					array(
						'label' => 'Add more options',
						'value' => 'more-options',
					),
				),
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'css_classes'                => array(
				'title'          => array(
					'text' => __( 'Add CSS Class', 'brandy' ),
					'type' => 'bold',
				),
				'value_path'     => array( 'css_classes' ),
				'default_value'  => '',
				'type'           => 'TextInput',
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'selector'      => '.brandy-element-wrapper',
							'name'          => 'class',
							'value_path'    => array( 'css_classes' ),
							'default_class' => 'brandy-element-wrapper',
						),
					),
				),
			),
			'menu_item_reset'            => array(
				'title'       => array(
					'text'         => __( 'Menu Item', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'menu_text' ),
					array( 'menu_item_padding' ),
					array( 'max_character_per_item' ),
					array( 'menu_item_background' ),
					array( 'menu_item_border_radius' ),
				),
			),
			'menu_text_typography'       => array(
				'title'          => array(
					'text' => __( 'Typography', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'menu_text', 'typography' ),
				'default_value'  => null,
				'type'           => 'Typography',
				'is_responsive'  => true,
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'typography',
							'selector'   => '.vertical-item',
							'value_path' => array( 'menu_text', 'typography' ),
						),
						array(
							'type'       => 'typography',
							'selector'   => '.horizontal-item.root-item',
							'value_path' => array( 'menu_text', 'typography' ),
						),

					),
				),
			),
			'menu_text_color'            => array(
				'value_path'     => array( 'menu_text', 'color' ),
				'title'          => array(
					'text' => __( 'Text color', 'brandy' ),
					'type' => 'normal',
				),
				'default_value'  => array(
					'enabled_gradient' => true,
					'normal'           => array(
						'desktop' => 'var(--wp--preset--color--brandy-primary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
					'hover'            => array(
						'desktop' => 'var(--wp--preset--color--brandy-primary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
				),
				'type'           => 'ColorGroup',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'selector'   => '.brandy-menu__item',
							'name'       => '--b-text-color',
							'value_path' => array( 'menu_text', 'color' ),
						),
					),
				),
			),
			'menu_item_background_color' => array(
				'value_path'         => array( 'menu_item_background' ),
				'title'              => array(
					'text' => __( 'Background color', 'brandy' ),
					'type' => 'normal',
				),
				'default_value'      => array(
					'normal' => array(
						'desktop' => 'transparent',
						'tablet'  => null,
						'mobile'  => null,
					),
					'hover'  => array(
						'desktop' => 'var(--wp--preset--color--brandy-primary)',
						'tablet'  => null,
						'mobile'  => null,
					),
				),
				'type'               => 'ColorGroup',
				'render_options'     => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-item-background',
							'value_path' => array( 'menu_item_background' ),
						),
					),
				),
				'visible_conditions' => array(
					array(
						'value_path' => array(
							'active_type',
						),
						'value'      => 'button',
					),
				),
			),
			'menu_item_padding'          => array(
				'title'          => array(
					'text' => __( 'Padding', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'menu_item_padding' ),
				'type'           => 'Spacing',
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'           => 'px',
						'top'            => 4,
						'right'          => 10,
						'bottom'         => 4,
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
							'name'       => '--b-item-padding',
							'value_path' => array( 'menu_item_padding' ),
						),
					),
				),
			),
			'menu_item_border_radius'    => array(
				'value_path'         => array( 'menu_item_border_radius' ),
				'title'              => array(
					'text' => __( 'Border radius', 'brandy' ),
					'type' => 'normal',
				),
				'default_value'      => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 4,
						'min'   => 0,
						'max'   => 50,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'type'               => 'Dimension',
				'render_options'     => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'selector'   => '.brandy-menu__item',
							'name'       => '--b-item-border-radius',
							'value_path' => array( 'menu_item_border_radius' ),
						),
					),
				),
				'visible_conditions' => array(
					array(
						'value_path' => array(
							'active_type',
						),
						'value'      => 'button',
					),
				),
			),
			'max_character_per_item'     => array(
				'title'              => array(
					'text' => __( 'Max characters per item', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'         => array( 'max_character_per_item' ),
				'type'               => 'NumberInput',
				'default_value'      => 30,
				'min'                => 5,
				'render_options'     => array(
					'type' => 'variable',
					'data' => array(
						array(
							'name'       => '--b-item-max-characters',
							'value_path' => array( 'max_character_per_item' ),
						),
					),
				),
				'visible_conditions' => array(
					array(
						'in_toggle' => false,
					),
				),
			),
			'item_active_reset'          => array(
				'title'       => array(
					'text'         => __( 'Active Menu Item', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'active_item' ),
				),
			),
			'active_item_typography'     => array(
				'title'          => array(
					'text' => __( 'Typography', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'active_item', 'typography' ),
				'default_value'  => null,
				'is_responsive'  => true,
				'type'           => 'Typography',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'typography',
							'selector'   => '.vertical-item[class*="current-"]',
							'value_path' => array( 'active_item', 'typography' ),
						),
						array(
							'type'       => 'typography',
							'selector'   => '.horizontal-item.root-item[class*="current-"]',
							'value_path' => array( 'active_item', 'typography' ),
						),
					),
				),
			),
			'active_item_text_color'     => array(
				'value_path'     => array( 'active_item', 'color' ),
				'title'          => array(
					'text' => __( 'Text color', 'brandy' ),
					'type' => 'normal',
				),
				'default_value'  => array(
					'enabled_gradient' => true,
					'normal'           => array(
						'desktop' => 'var(--wp--preset--color--brandy-primary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
				),
				'type'           => 'ColorGroup',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-active-item-text-color',
							'value_path' => array( 'active_item', 'color' ),
						),
					),
				),
			),
			'active_item_background'     => array(
				'value_path'         => array( 'active_item', 'background' ),
				'title'              => array(
					'text' => __( 'Background color', 'brandy' ),
					'type' => 'normal',
				),
				'default_value'      => array(
					'normal' => array(
						'desktop' => 'var(--wp--preset--color--brandy-primary)',
						'tablet'  => null,
						'mobile'  => null,
					),
				),
				'type'               => 'ColorGroup',
				'render_options'     => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-active-item-background',
							'value_path' => array( 'active_item', 'background' ),
						),
					),
				),
				'visible_conditions' => array(
					array(
						'value_path' => array(
							'active_type',
						),
						'value'      => 'button',
					),
				),
			),
			'active_item_border_color'   => array(
				'value_path'         => array( 'active_item', 'border', 'color' ),
				'title'              => array(
					'text' => __( 'Border color', 'brandy' ),
					'type' => 'normal',
				),
				'default_value'      => array(
					'enabled_gradient' => true,
					'hover'            => array(
						'desktop' => 'var(--wp--preset--color--brandy-primary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
					'active'           => array(
						'desktop' => 'var(--wp--preset--color--brandy-primary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
				),
				'is_responsive'      => true,
				'type'               => 'ColorGroup',
				'render_options'     => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-active-item-border-color',
							'value_path' => array( 'active_item', 'border', 'color' ),
						),
					),
				),
				'visible_conditions' => array(
					array(
						'value_path' => array(
							'active_type',
						),
						'value'      => 'underline',
					),
				),
			),
			'active_item_border_width'   => array(
				'value_path'         => array( 'active_item', 'border', 'width' ),
				'title'              => array(
					'text' => __( 'Border width', 'brandy' ),
					'type' => 'normal',
				),
				'units'              => array( 'px' ),
				'default_value'      => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 1,
						'min'   => 0,
						'max'   => 20,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'type'               => 'Dimension',
				'render_options'     => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-active-item-border-width',
							'value_path' => array( 'active_item', 'border', 'width' ),
						),
					),
				),
				'visible_conditions' => array(
					'relation' => 'AND',
					array(
						'value_path' => array(
							'active_type',
						),
						'operator'   => 'NOT',
						'value'      => 'text',
					),
					array(
						'value_path' => array(
							'active_type',
						),
						'operator'   => 'NOT',
						'value'      => 'button',
					),
				),
			),
			'item_spacing'               => array(
				'value_path'     => array( 'item_spacing' ),
				'title'          => array(
					'text'         => __( 'Menu Item spacing', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 40,
						'min'   => 0,
						'max'   => 100,
					),
					'tablet'  => array(
						'unit'  => 'px',
						'value' => 10,
						'min'   => 0,
						'max'   => 100,
					),
					'mobile'  => array(
						'unit'  => 'px',
						'value' => 10,
						'min'   => 0,
						'max'   => 100,
					),
				),
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
			),
			'item_extra_spacing'         => array(
				'value_path'     => array( 'item_extra_spacing' ),
				'title'          => array(
					'text'         => __( 'Item 2nd-axes spacing', 'brandy' ),
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
			),
			'canvas_title'               => array(
				'title'         => array(
					'text'         => __( 'Canvas Submenu', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'reset_paths'   => array(
					array( 'canvas' ),
				),
				'type'          => 'CanvasTitle',
				'default_value' => array(),
			),
			'canvas_typography'          => array(
				'title'          => array(
					'text' => __( 'Typography', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'canvas', 'typography' ),
				'default_value'  => null,
				'is_responsive'  => true,
				'type'           => 'Typography',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'typography',
							'selector'   => '.horizontal-item.brandy-sub-menu__item',
							'value_path' => array( 'canvas', 'typography' ),
						),
					),
				),
			),
			'canvas_text_color'          => array(
				'value_path'     => array( 'canvas', 'text_color' ),
				'title'          => array(
					'text' => __( 'Text color', 'brandy' ),
					'type' => 'normal',
				),
				'default_value'  => array(
					'enabled_gradient' => true,
					'normal'           => array(
						'desktop' => 'var(--wp--preset--color--brandy-primary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
					'hover'            => array(
						'desktop' => 'var(--wp--preset--color--brandy-primary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
					'active'           => array(
						'desktop' => 'var(--wp--preset--color--brandy-primary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
				),
				'type'           => 'ColorGroup',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-canvas-text-color',
							'selector'   => '.brandy-sub-menu',
							'value_path' => array( 'canvas', 'text_color' ),
						),
					),
				),
			),
			'canvas_item_background'     => array(
				'value_path'     => array( 'canvas', 'item_background' ),
				'title'          => array(
					'text' => __( 'Item background', 'brandy' ),
					'type' => 'normal',
				),
				'default_value'  => array(
					'normal' => array(
						'desktop' => '#ffffff',
						'tablet'  => null,
						'mobile'  => null,
					),
					'hover'  => array(
						'desktop' => '#ffffff',
						'tablet'  => null,
						'mobile'  => null,
					),
					'active' => array(
						'desktop' => '#ffffff',
						'tablet'  => null,
						'mobile'  => null,
					),
				),
				'type'           => 'ColorGroup',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'selector'   => '.brandy-sub-menu',
							'name'       => '--b-canvas-item-background',
							'value_path' => array( 'canvas', 'item_background' ),
						),
					),
				),
			),
			'canvas_item_border_color'   => array(
				'value_path'     => array( 'canvas', 'item_border_color' ),
				'title'          => array(
					'text' => __( 'Border color', 'brandy' ),
					'type' => 'normal',
				),
				'default_value'  => array(
					'enabled_gradient' => true,
					'hover'            => array(
						'desktop' => 'var(--wp--preset--color--brandy-primary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
					'active'           => array(
						'desktop' => 'var(--wp--preset--color--brandy-primary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
				),
				'type'           => 'ColorGroup',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'selector'   => '.brandy-sub-menu',
							'name'       => '--b-canvas-item-border-color',
							'value_path' => array( 'canvas', 'item_border_color' ),
						),
					),
				),
			),
			'canvas_background'          => array(
				'value_path'     => array( 'canvas', 'background' ),
				'title'          => array(
					'text' => __( 'Canvas background', 'brandy' ),
					'type' => 'normal',
				),
				'default_value'  => array(
					'normal' => array(
						'desktop' => '#ffffff',
						'tablet'  => null,
						'mobile'  => null,
					),
				),
				'type'           => 'ColorGroup',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'selector'   => '.brandy-sub-menu',
							'name'       => '--b-canvas-background',
							'value_path' => array( 'canvas', 'background' ),
						),
					),
				),
			),
			'canvas_width'               => array(
				'value_path'     => array( 'canvas', 'width' ),
				'title'          => array(
					'text' => __( 'Canvas min width', 'brandy' ),
					'type' => 'normal',
				),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'min'   => 50,
						'max'   => 300,
						'value' => 200,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'type'           => 'Dimension',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'selector'   => '.brandy-sub-menu',
							'name'       => '--b-canvas-width',
							'value_path' => array( 'canvas', 'width' ),
						),
					),
				),
			),
			'canvas_box_shadow'          => array(
				'title'          => array(
					'text' => __( 'Shadow', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'BoxShadow',
				'default_value'  => array(
					'desktop' => array(
						'enabled'      => true,
						'type'         => 'custom',
						'custom_value' => array(
							'color'  => 'rgba(215, 216, 222, 0.50)',
							'x'      => 0,
							'y'      => 7,
							'blur'   => 35,
							'spread' => 0,
						),
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'     => array( 'canvas', 'box_shadow' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'box_shadow',
							'selector'   => '.brandy-sub-menu',
							'name'       => '--b-canvas-box-shadow',
							'value_path' => array( 'canvas', 'box_shadow' ),
						),
					),
				),
			),
			'canvas_item_spacing'        => array(
				'value_path'     => array( 'canvas', 'item_spacing' ),
				'title'          => array(
					'text' => __( 'Item Spacing', 'brandy' ),
					'type' => 'normal',
				),
				'units'          => array( 'px' ),
				'default_value'  => array(
					'unit'  => 'px',
					'min'   => 0,
					'max'   => 100,
					'value' => 16,
				),
				'type'           => 'Dimension',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'selector'   => '[layout="horizontal"] .brandy-sub-menu',
							'name'       => 'gap',
							'value_path' => array( 'canvas', 'item_spacing' ),
						),
					),
				),
			),
			'canvas_item_padding'        => array(
				'title'          => array(
					'text' => __( 'Item padding', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'canvas', 'item_padding' ),
				'type'           => 'Spacing',
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'           => 'px',
						'top'            => 0,
						'right'          => 0,
						'bottom'         => 4,
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
							'selector'   => '[layout="horizontal"] .brandy-sub-menu',
							'name'       => '--b-canvas-item-padding',
							'value_path' => array( 'canvas', 'item_padding' ),
						),
					),
				),
			),
			'canvas_padding'             => array(
				'title'          => array(
					'text' => __( 'Canvas padding', 'brandy' ),
					'type' => 'normal',
				),
				'value_path'     => array( 'padding' ),
				'type'           => 'Spacing',
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'           => 'px',
						'top'            => 16,
						'right'          => 16,
						'bottom'         => 16,
						'left'           => 16,
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
							'selector'   => '[layout="horizontal"] .brandy-sub-menu',
							'name'       => 'padding',
							'value_path' => array( 'padding' ),
						),
					),
				),
			),
			'canvas_offset_top'          => array(
				'value_path'     => array( 'canvas', 'offset_top' ),
				'title'          => array(
					'text' => __( 'Offset top', 'brandy' ),
					'type' => 'normal',
				),
				'units'          => array( 'px' ),
				'default_value'  => array(
					'unit'  => 'px',
					'min'   => -200,
					'max'   => 200,
					'value' => 8,
				),
				'type'           => 'Dimension',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'selector'   => '.brandy-sub-menu',
							'name'       => '--b-canvas-offset-top',
							'value_path' => array( 'canvas', 'offset_top' ),
						),
					),
				),
			),
			'margin'                     => array(
				'value_path'     => array( 'margin' ),
				'title'          => array(
					'text'         => __( 'Margin', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
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
				'type'           => 'Spacing',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'spacing',
							'selector'   => '',
							'name'       => 'margin',
							'value_path' => array( 'margin' ),
						),
					),
				),
			),
			'navigation_reset'           => array(
				'reset_paths' => array(
					array( 'navigation' ),
				),
				'title'       => array(
					'text'         => __( 'Navigation reset', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'        => 'Reset',
			),
			'navigation_text_typography' => array(
				'value_path'     => array( 'navigation', 'text_typography' ),
				'title'          => array(
					'text' => __( 'Text typography', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Typography',
				'default_value'  => null,
				'is_responsive'  => true,
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'typography',
							'selector'   => '.brandy-menu-navigation',
							'value_path' => array( 'navigation', 'text_typography' ),
						),
					),
				),
			),
			'navigation_text_color'      => array(
				'value_path'     => array( 'navigation', 'text_color' ),
				'title'          => array(
					'text' => __( 'Text color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
				'default_value'  => array(
					'normal' => array(
						'desktop' => 'var(--wp--preset--color--brandy-primary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
					'hover'  => array(
						'desktop' => 'var(--wp--preset--color--brandy-primary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
					'active' => array(
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
							'selector'   => '.brandy-menu-navigation',
							'name'       => '--b-navigation-text-color',
							'value_path' => array( 'navigation', 'text_color' ),
						),
					),
				),
			),
			'navigation_border_color'    => array(
				'value_path'     => array( 'navigation', 'border', 'color' ),
				'title'          => array(
					'text' => __( 'Border color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
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
							'selector'   => '.brandy-menu-navigation',
							'name'       => '--b-navigation-border-color',
							'value_path' => array( 'navigation', 'border', 'color' ),
						),
					),
				),
			),
			'navigation_border_width'    => array(
				'value_path'     => array( 'navigation', 'border', 'width' ),
				'title'          => array(
					'text' => __( 'Border width', 'brandy' ),
					'type' => 'normal',
				),
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 1,
						'min'   => 0,
						'max'   => 10,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'type'           => 'Dimension',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'selector'   => '.brandy-menu-navigation',
							'name'       => '--b-navigation-border-width',
							'value_path' => array( 'navigation', 'border', 'width' ),
						),
					),
				),
			),
			'navigation_padding'         => array(
				'value_path'     => array( 'navigation', 'padding' ),
				'title'          => array(
					'text' => __( 'Padding', 'brandy' ),
					'type' => 'normal',
				),
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => array(
						'top'            => 10,
						'right'          => 10,
						'bottom'         => 10,
						'left'           => 0,
						'is_constraints' => true,
						'unit'           => 'px',
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'type'           => 'Spacing',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'spacing',
							'selector'   => '.brandy-menu-navigation',
							'name'       => 'padding',
							'value_path' => array( 'navigation', 'padding' ),
						),
					),
				),
			),
			'navigation_margin_bottom'   => array(
				'value_path'     => array( 'navigation', 'margin_bottom' ),
				'title'          => array(
					'text' => __( 'Margin bottom', 'brandy' ),
					'type' => 'normal',
				),
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 20,
						'min'   => 0,
						'max'   => 100,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'type'           => 'Dimension',
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'selector'   => '.brandy-menu-navigation',
							'name'       => 'margin-bottom',
							'value_path' => array( 'navigation', 'margin_bottom' ),
						),
					),
				),
			),
		);
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
						'components'         => array(
							'active_type',
						),
						'visible_conditions' => array(
							array(
								'in_toggle' => false,
							),
						),
					),
					array(
						'components'         => array(
							'menu_overlapped',
						),
						'visible_conditions' => array(
							array(
								'in_toggle' => false,
							),
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
							'menu_item_background_color',
							'menu_item_padding',
							'menu_item_border_radius',
							'max_character_per_item',
						),
					),
					array(
						'components' => array(
							'item_active_reset',
							'active_item_typography',
							'active_item_text_color',
							'active_item_background',
							'active_item_border_color',
							'active_item_border_width',
						),
					),
					array(
						'components' => array( 'item_spacing', 'item_extra_spacing' ),
					),
					array(
						'components'         => array(
							'canvas_title',
							'canvas_typography',
							'canvas_text_color',
							'canvas_item_background',
							'canvas_background',
							'canvas_item_border_color',
							'canvas_item_spacing',
							'canvas_item_padding',
							'canvas_width',
							'canvas_padding',
							'canvas_offset_top',
							'canvas_box_shadow',
						),
						'visible_conditions' => array(
							array(
								'in_toggle' => false,
							),
						),
					),
					array(
						'visible_conditions' => array(
							array(
								'in_toggle' => true,
							),
						),
						'components'         => array(
							'navigation_reset',
							'navigation_text_typography',
							'navigation_text_color',
							'navigation_border_color',
							'navigation_border_width',
							'navigation_padding',
							'navigation_margin_bottom',
						),
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

	public function add_localize_data( $localize_data ) {
		if ( ! isset( $localize_data['wp_nav_menus'] ) ) {
			$localize_data['wp_nav_menus'] = array_merge(
				array(
					array(
						'name' => __( 'Default', 'brandy' ),
						'slug' => 'default',
					),
				),
				get_terms( 'nav_menu', array( 'hide_empty' => true ) )
			);
		}
		return $localize_data;
	}
}
