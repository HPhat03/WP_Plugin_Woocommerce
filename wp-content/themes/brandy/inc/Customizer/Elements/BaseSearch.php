<?php

namespace Brandy\Customizer\Elements;

use Brandy\Abstracts\AbstractBaseElement;

class BaseSearch extends AbstractBaseElement {

	protected $title = 'Search';

	protected $icon = ' <svg
			width="30"
			height="30"
			viewBox="0 0 30 30"
			fill="none"
			xmlns="http://www.w3.org/2000/svg"
		  >
			<path
			  fillRule="evenodd"
			  clipRule="evenodd"
			  d="M7.70239 14.4921C7.70239 10.7422 10.7422 7.70239 14.4921 7.70239C18.2419 7.70239 21.2818 10.7422 21.2818 14.4921C21.2818 18.2419 18.2419 21.2818 14.4921 21.2818C10.7422 21.2818 7.70239 18.2419 7.70239 14.4921ZM14.4921 6.20239C9.91381 6.20239 6.20239 9.91381 6.20239 14.4921C6.20239 19.0703 9.91381 22.7818 14.4921 22.7818C16.5112 22.7818 18.3616 22.0599 19.7995 20.8602L23.4697 24.5303C23.7626 24.8232 24.2374 24.8232 24.5303 24.5303C24.8232 24.2374 24.8232 23.7626 24.5303 23.4697L20.8602 19.7995C22.0599 18.3616 22.7818 16.5112 22.7818 14.4921C22.7818 9.91381 19.0703 6.20239 14.4921 6.20239Z"
			  fill="' . BRANDY_ICON_COLOR_NORMAL . '"
			/>
		  </svg>';

	protected $element_id = 'search';

	protected $builders = array( 'header', 'footer' );

	public static $path_to_icons = BRANDY_TEMPLATE_DIR . '/template-parts/icons/search/';

	protected function __construct() {
		add_filter( 'brandy_extra_localize', array( $this, 'add_localize_data' ) );

		parent::__construct();
	}

	public function template_path() {
		return 'template-parts/builder/elements/search';
	}

	protected function register_components() {
		return array(
			'search_type'                        => array(
				'title'          => array(
					'text' => __( 'Search Type', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'ButtonGroup',
				'value_path'     => array( 'type' ),
				'default_value'  => 'box',
				'options'        => array(
					array(
						'label' => __( 'Box', 'brandy' ),
						'value' => 'box',
					),
					array(
						'label' => __( 'Line', 'brandy' ),
						'value' => 'line',
					),
					array(
						'label' => __( 'Icon', 'brandy' ),
						'value' => 'icon',
					),
				),
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'placeholder'                        => array(
				'title'          => array(
					'text' => __( 'Placeholder text', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'TextInput',
				'value_path'     => array( 'placeholder' ),
				'default_value'  => 'Search',
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'selector'   => '.brandy-search-box__input',
							'name'       => 'placeholder',
							'value_path' => array( 'placeholder' ),
						),
					),
				),
			),
			'select_icon'                        => array(
				'title'          => array(
					'text' => __( 'Select icon', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'SearchIconSelection',
				'value_path'     => array( 'icon' ),
				'default_value'  => 'icon_1',
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'icon_position'                      => array(
				'title'               => array(
					'text' => __( 'Icon Position', 'brandy' ),
					'type' => 'bold',
				),
				'type'                => 'Position',
				'value_path'          => array( 'icon_position' ),
				'default_value'       => 'left',
				'available_positions' => array( 'left', 'right' ),
				'render_options'      => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'selector'   => '.brandy-search-box',
							'name'       => 'icon-position',
							'value_path' => array( 'icon_position' ),
						),
					),
				),
			),
			'search_criteria'                    => array(
				'title'          => array(
					'text' => __( 'Search Through Criteria', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'ButtonGroup',
				'value_path'     => array( 'search_criteria' ),
				'default_value'  => 'product',
				'options'        => array(
					array(
						'label' => __( 'Products', 'brandy' ),
						'value' => 'product',
					),
					array(
						'label' => __( 'Pages', 'brandy' ),
						'value' => 'page',
					),
					array(
						'label' => __( 'Posts', 'brandy' ),
						'value' => 'post',
					),
				),
				'render_options' => array(
					'type' => 'data_attribute',
					'data' => array(
						array(
							'selector'   => '.brandy-search-box',
							'name'       => 'search-criteria',
							'value_path' => array( 'search_criteria' ),
						),
					),
				),
			),
			'live_results_enabled'               => array(
				'title'          => array(
					'text' => __( 'Live Results', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'Switcher',
				'default_value'  => true,
				'value_path'     => array( 'live_results', 'enabled' ),
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'live_results_type'                  => array(
				'type'               => 'LiveResultsType',
				'default_value'      => 'type_1',
				'value_path'         => array( 'live_results', 'type' ),
				'render_options'     => array(
					'type' => 'force_refresh',
				),
				'options'            => array(
					array(
						'label' => __( 'Panel sidebar - list product view', 'brandy' ),
						'value' => 'type_1',
					),
					array(
						'label' => __( 'Panel sidebar - grid product view', 'brandy' ),
						'value' => 'type_2',
					),
					array(
						'label' => __( 'Panel Full-screen - grid product view', 'brandy' ),
						'value' => 'type_3',
					),
					// array(
					// 	'label' => __( 'Panel dropdown - list product view', 'brandy' ),
					// 	'value' => 'type_4',
					// ),
					// array(
					// 	'label' => __( 'Panel dropdown - grid product view', 'brandy' ),
					// 	'value' => 'type_5',
					// ),
					array(
						'label' => __( 'Panel dropdown - grid product view', 'brandy' ),
						'value' => 'type_6',
					),
				),
				'visible_conditions' => array(
					array(
						'value_path' => array( 'live_results', 'enabled' ),
						'value'      => true,
					),
				),
			),
			'live_results_image'                 => array(
				'title'          => array(
					'text' => __( 'Live Results image', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'Switcher',
				'default_value'  => true,
				'value_path'     => array( 'live_results', 'show_image' ),
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'live_results_product_price'         => array(
				'title'          => array(
					'text' => __( 'Show product price in result', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'Switcher',
				'default_value'  => true,
				'value_path'     => array( 'live_results', 'show_product_price' ),
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'live_results_view_more'             => array(
				'title'          => array(
					'text' => __( 'Show view more button', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'Switcher',
				'default_value'  => true,
				'value_path'     => array( 'live_results', 'can_view_more' ),
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'show_keyword_suggestions'           => array(
				'title'          => array(
					'text' => __( 'Show keyword suggestions', 'brandy' ),
					'type' => 'bold',
				),
				'type'           => 'Switcher',
				'default_value'  => true,
				'value_path'     => array( 'live_results', 'show_suggestions' ),
				'render_options' => array(
					'type' => 'force_refresh',
				),
			),
			'suggestions'                        => array(
				'type'               => 'SearchSuggestions',
				'default_value'      => array( 'Polo', 'T-shirt', 'Cap' ),
				'value_path'         => array( 'live_results', 'suggestions' ),
				'render_options'     => array(
					'type' => 'force_refresh',
				),
				'visible_conditions' => array(
					array(
						'value_path' => array( 'live_results', 'show_suggestions' ),
						'value'      => true,
					),
				),
			),
			'search_icon_reset'                  => array(
				'title'       => array(
					'text'         => __( 'Search Icon', 'brandy' ),
					'show_devices' => true,
					'type'         => 'bold',
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'search_icon' ),
				),
			),
			'search_icon_color'                  => array(
				'title'          => array(
					'text' => __( 'Icon color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
				'default_value'  => array(
					'normal' => array(
						'desktop' => 'var(--wp--preset--color--brandy-secondary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
					'hover'  => array(
						'desktop' => 'var(--wp--preset--color--brandy-secondary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
					'active' => array(
						'desktop' => 'var(--wp--preset--color--brandy-secondary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
				),
				'value_path'     => array( 'search_icon', 'icon_color' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-icon-color',
							'value_path' => array( 'search_icon', 'icon_color' ),
						),
					),
				),
			),
			'search_icon_background_color'       => array(
				'title'          => array(
					'text' => __( 'Background color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
				'default_value'  => array(
					'normal' => array(
						'desktop' => '#ffffff00',
						'tablet'  => null,
						'mobile'  => null,
					),
					'hover'  => array(
						'desktop' => '#ffffff00',
						'tablet'  => null,
						'mobile'  => null,
					),
					'active' => array(
						'desktop' => '#ffffff00',
						'tablet'  => null,
						'mobile'  => null,
					),
				),
				'value_path'     => array( 'search_icon', 'background_color' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-icon-background-color',
							'value_path' => array( 'search_icon', 'background_color' ),
						),
					),
				),
			),
			'search_icon_stroke_color'           => array(
				'title'          => array(
					'text' => __( 'Stroke color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
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
				'value_path'     => array( 'search_icon', 'stroke', 'color' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-icon-stroke-color',
							'value_path' => array( 'search_icon', 'stroke', 'color' ),
						),
					),
				),
			),
			'search_icon_stroke_width'           => array(
				'title'          => array(
					'text' => __( 'Stroke width', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 0,
						'min'   => 0,
						'max'   => 20,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'     => array( 'search_icon', 'stroke', 'width' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-icon-stroke-width',
							'value_path' => array( 'search_icon', 'stroke', 'width' ),
						),
					),
				),
			),
			'search_icon_border_radius'          => array(
				'title'          => array(
					'text' => __( 'Border radius', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'units'          => array( 'px', '%' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 0,
						'min'   => 0,
						'max'   => 50,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'     => array( 'search_icon', 'border_radius' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-icon-border-radius',
							'value_path' => array( 'search_icon', 'border_radius' ),
						),
					),
				),
			),
			'search_icon_size'                   => array(
				'title'          => array(
					'text' => __( 'Icon size', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => ElementsLoader::get_default_icon_size(),
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'     => array( 'search_icon', 'size' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-icon-size',
							'value_path' => array( 'search_icon', 'size' ),
						),
					),
				),
			),
			'search_icon_padding'                => array(
				'title'          => array(
					'text' => __( 'Icon padding', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Spacing',
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'           => 'px',
						'top'            => 5,
						'right'          => 5,
						'bottom'         => 5,
						'left'           => 5,
						'is_constraints' => false,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'is_responsive'  => true,
				'value_path'     => array( 'search_icon', 'padding' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'spacing',
							'selector'   => '.brandy-search-box__icon .brandy-theme-icon',
							'name'       => 'padding',
							'value_path' => array( 'search_icon', 'padding' ),
						),
					),
				),
			),
			'search_text_reset'                  => array(
				'title'       => array(
					'text'         => __( 'Search text', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'search_text' ),
				),
			),
			'search_text_color'                  => array(
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
				),
				'value_path'     => array( 'search_text', 'color' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-search-text-color',
							'value_path' => array( 'search_text', 'color' ),
						),
					),
				),
			),
			'search_text_typography'             => array(
				'title'          => array(
					'text' => __( 'Typography', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Typography',
				'default_value'  => null,
				'is_responsive'  => true,
				'value_path'     => array( 'search_text', 'typography' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'typography',
							'selector'   => '.brandy-search-box .brandy-search-box__input',
							'value_path' => array( 'search_text', 'typography' ),
						),
					),
				),
			),
			'search_box_reset'                   => array(
				'title'       => array(
					'text'         => __( 'Search box', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'search_box' ),
				),
			),
			'search_box_background_color'        => array(
				'title'          => array(
					'text' => __( 'Background color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
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
				'value_path'     => array( 'search_box', 'background_color' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-search-box-background-color',
							'value_path' => array( 'search_box', 'background_color' ),
						),
					),
				),
			),
			'search_box_stroke_color'            => array(
				'title'          => array(
					'text' => __( 'Stroke color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
				'default_value'  => array(
					'normal' => array(
						'desktop' => '#E3E8EE',
						'tablet'  => null,
						'mobile'  => null,
					),
					'hover'  => array(
						'desktop' => '#135e96',
						'tablet'  => null,
						'mobile'  => null,
					),
					'active' => array(
						'desktop' => '#135e96',
						'tablet'  => null,
						'mobile'  => null,
					),
				),
				'is_responsive'  => true,
				'value_path'     => array( 'search_box', 'stroke_color' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-search-box-stroke-color',
							'value_path' => array( 'search_box', 'stroke_color' ),
						),
					),
				),
			),
			'search_box_stroke_width'            => array(
				'title'          => array(
					'text' => __( 'Stroke width', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 1,
						'min'   => 0,
						'max'   => 30,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'     => array( 'search_box', 'stroke', 'width' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-search-box-stroke-width',
							'value_path' => array( 'search_box', 'stroke', 'width' ),
						),
					),
				),
			),
			'search_box_border_radius'           => array(
				'title'          => array(
					'text' => __( 'Border radius', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'units'          => array( 'px', '%' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 7,
						'min'   => 0,
						'max'   => 50,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'     => array( 'search_box', 'border_radius' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-search-box-border-radius',
							'value_path' => array( 'search_box', 'border_radius' ),
						),
					),
				),
			),
			'search_box_input_height'            => array(
				'title'          => array(
					'text' => __( 'Input height', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 10,
						'min'   => 10,
						'max'   => 200,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'     => array( 'search_box', 'input_height' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-search-box-input-height',
							'value_path' => array( 'search_box', 'input_height' ),
						),
					),
				),
			),
			'search_box_input_width'             => array(
				'title'          => array(
					'text' => __( 'Input width', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 300,
						'min'   => 20,
						'max'   => 500,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'     => array( 'search_box', 'input_width' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-search-box-input-width',
							'value_path' => array( 'search_box', 'input_width' ),
						),
					),
				),
			),
			'searchbox_padding'                  => array(
				'value_path'     => array( 'search_box', 'padding' ),
				'type'           => 'Spacing',
				'title'          => array(
					'text'         => __( 'Input padding', 'brandy' ),
					'show_devices' => true,
				),
				'default_value'  => array(
					'desktop' => array(
						'unit'           => 'rem',
						'top'            => 0.75,
						'right'          => 1.25,
						'bottom'         => 0.75,
						'left'           => 1.25,
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
							'name'       => '--b-searchbox-padding',
							'value_path' => array( 'search_box', 'padding' ),
						),
					),
				),
			),
			'search_box_clear_icon_color'        => array(
				'title'          => array(
					'text' => __( 'Clear icon color', 'brandy' ),
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
				),
				'value_path'     => array( 'search_box', 'clear_icon', 'color' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-search-box-clear-icon-color',
							'value_path' => array( 'search_box', 'clear_icon', 'color' ),
						),
					),
				),
			),
			'search_box_clear_icon_size'         => array(
				'title'          => array(
					'text' => __( 'Clear icon size', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'default_value'  => array(
					'desktop' => ElementsLoader::get_default_icon_size(),
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'     => array( 'search_box', 'clear-icon', 'size' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-icon-clear-icon-size',
							'value_path' => array( 'search_box', 'clear-icon', 'size' ),
						),
					),
				),
			),
			'panel_reset'                        => array(
				'title'       => array(
					'text' => __( 'Panel', 'brandy' ),
					'type' => 'bold',
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array(
						'panel',
					),
				),
			),
			'panel_background'                   => array(
				'title'          => array(
					'text' => __( 'Background', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
				'default_value'  => array(
					'normal' => '#ffffff',
				),
				'value_path'     => array( 'panel', 'background' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-panel-background',
							'selector'   => '.brandy-live-result',
							'value_path' => array( 'panel', 'background' ),
						),
					),
				),
			),
			'panel_backdrop'                     => array(
				'title'          => array(
					'text' => __( 'Backdrop', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
				'default_value'  => array(
					'normal' => '#c3c2c2c9',
				),
				'value_path'     => array( 'panel', 'backdrop' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-backdrop-color',
							'value_path' => array( 'panel', 'backdrop' ),
						),
					),
				),
			),
			'icon_close_panel_reset'             => array(
				'title'       => array(
					'text'         => __( 'Panel close', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'icon_close_panel' ),
				),
			),
			'icon_close_panel_color'             => array(
				'title'          => array(
					'text' => __( 'Icon color', 'brandy' ),
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
				),
				'value_path'     => array( 'icon_close_panel', 'color' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-icon-close-panel-color',
							'value_path' => array( 'icon_close_panel', 'color' ),
						),
					),
				),
			),
			// 'icon_close_panel_background'        => array(
			// 	'title'          => array(
			// 		'text' => __( 'Background', 'brandy' ),
			// 		'type' => 'normal',
			// 	),
			// 	'type'           => 'ColorGroup',
			// 	'default_value'  => array(
			// 		'normal' => array(
			// 			'desktop' => '#ffffff00',
			// 			'tablet'  => null,
			// 			'mobile'  => null,
			// 		),
			// 		'hover'  => array(
			// 			'desktop' => '#ffffff00',
			// 			'tablet'  => null,
			// 			'mobile'  => null,
			// 		),
			// 	),
			// 	'value_path'     => array( 'icon_close_panel', 'background' ),
			// 	'render_options' => array(
			// 		'type' => 'variable',
			// 		'data' => array(
			// 			array(
			// 				'type'       => 'color',
			// 				'name'       => '--b-icon-close-panel-background',
			// 				'value_path' => array( 'icon_close_panel', 'background' ),
			// 			),
			// 		),
			// 	),
			// ),
			// 'icon_close_panel_stroke_color'      => array(
			// 	'title'          => array(
			// 		'text' => __( 'Stroke color', 'brandy' ),
			// 		'type' => 'normal',
			// 	),
			// 	'type'           => 'ColorGroup',
			// 	'default_value'  => array(
			// 		'normal' => array(
			// 			'desktop' => '#ffffff',
			// 			'tablet'  => null,
			// 			'mobile'  => null,
			// 		),
			// 		'hover'  => array(
			// 			'desktop' => '#ffffff',
			// 			'tablet'  => null,
			// 			'mobile'  => null,
			// 		),
			// 	),
			// 	'value_path'     => array( 'icon_close_panel', 'stroke', 'color' ),
			// 	'render_options' => array(
			// 		'type' => 'variable',
			// 		'data' => array(
			// 			array(
			// 				'type'       => 'color',
			// 				'name'       => '--b-icon-close-panel-stroke-color',
			// 				'value_path' => array( 'icon_close_panel', 'stroke', 'color' ),
			// 			),
			// 		),
			// 	),
			// ),
			// 'icon_close_panel_stroke_width'      => array(
			// 	'title'          => array(
			// 		'text' => __( 'Stroke width', 'brandy' ),
			// 		'type' => 'normal',
			// 	),
			// 	'type'           => 'Dimension',
			// 	'units'          => array( 'px' ),
			// 	'default_value'  => array(
			// 		'desktop' => array(
			// 			'unit'  => 'px',
			// 			'value' => 0,
			// 			'min'   => 0,
			// 			'max'   => 20,
			// 		),
			// 		'tablet'  => null,
			// 		'mobile'  => null,
			// 	),
			// 	'value_path'     => array( 'icon_close_panel', 'stroke', 'width' ),
			// 	'render_options' => array(
			// 		'type' => 'variable',
			// 		'data' => array(
			// 			array(
			// 				'type'       => 'dimension',
			// 				'name'       => '--b-icon-close-panel-stroke-width',
			// 				'value_path' => array( 'icon_close_panel', 'stroke', 'width' ),
			// 			),
			// 		),
			// 	),
			// ),
			// 'icon_close_panel_border_radius'     => array(
			// 	'title'          => array(
			// 		'text' => __( 'Border radius', 'brandy' ),
			// 		'type' => 'normal',
			// 	),
			// 	'type'           => 'Dimension',
			// 	'units'          => array( 'px', '%' ),
			// 	'default_value'  => array(
			// 		'desktop' => array(
			// 			'unit'  => 'px',
			// 			'value' => 0,
			// 			'min'   => 0,
			// 			'max'   => 50,
			// 		),
			// 		'tablet'  => null,
			// 		'mobile'  => null,
			// 	),
			// 	'value_path'     => array( 'icon_close_panel', 'border_radius' ),
			// 	'render_options' => array(
			// 		'type' => 'variable',
			// 		'data' => array(
			// 			array(
			// 				'type'       => 'dimension',
			// 				'name'       => '--b-icon-close-panel-border-radius',
			// 				'value_path' => array( 'icon_close_panel', 'border_radius' ),
			// 			),
			// 		),
			// 	),
			// ),
			'icon_close_panel_size'              => array(
				'title'          => array(
					'text' => __( 'Icon size', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'default_value'  => array(
					'desktop' => ElementsLoader::get_default_icon_size(
						array(
							'value' => 23,
							'min'   => 20,
						)
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'     => array( 'icon_close_panel', 'size' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-icon-close-panel-size',
							'value_path' => array( 'icon_close_panel', 'size' ),
						),
					),
				),
			),
			'margin'                             => array(
				'value_path'     => array( 'margin' ),
				'type'           => 'Spacing',
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
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'spacing',
							'name'       => 'margin',
							'selector'   => '.brandy-search-element',
							'value_path' => array( 'margin' ),
						),
					),
				),
			),

			/**
			 * Panel search box
			 *
			 * @since 1.3
			 */
			'panel_search_box_reset'             => array(
				'title'       => array(
					'text'         => __( 'Panel search box', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'panel_search_box' ),
				),
			),
			'panel_search_box_background_color'  => array(
				'title'          => array(
					'text' => __( 'Background color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
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
				'is_responsive'  => true,
				'value_path'     => array( 'panel_search_box', 'background_color' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-panel-search-box-background-color',
							'value_path' => array( 'panel_search_box', 'background_color' ),
						),
					),
				),
			),
			'panel_search_box_stroke_color'      => array(
				'title'          => array(
					'text' => __( 'Stroke color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
				'default_value'  => array(
					'normal' => array(
						'desktop' => '#E3E8EE',
						'tablet'  => null,
						'mobile'  => null,
					),
					'hover'  => array(
						'desktop' => '#135e96',
						'tablet'  => null,
						'mobile'  => null,
					),
					'active' => array(
						'desktop' => '#135e96',
						'tablet'  => null,
						'mobile'  => null,
					),
				),
				'is_responsive'  => true,
				'value_path'     => array( 'panel_search_box', 'stroke_color' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-panel-search-box-stroke-color',
							'value_path' => array( 'panel_search_box', 'stroke_color' ),
						),
					),
				),
			),
			'panel_search_box_stroke_width'      => array(
				'title'          => array(
					'text' => __( 'Stroke width', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 1,
						'min'   => 0,
						'max'   => 30,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'is_responsive'  => true,
				'value_path'     => array( 'panel_search_box', 'stroke', 'width' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-panel-search-box-stroke-width',
							'value_path' => array( 'panel_search_box', 'stroke', 'width' ),
						),
					),
				),
			),
			'panel_search_box_border_radius'     => array(
				'title'          => array(
					'text' => __( 'Border radius', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'units'          => array( 'px', '%' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 7,
						'min'   => 0,
						'max'   => 50,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'is_responsive'  => true,
				'value_path'     => array( 'panel_search_box', 'border_radius' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-panel-search-box-border-radius',
							'value_path' => array( 'panel_search_box', 'border_radius' ),
						),
					),
				),
			),
			'panel_search_box_input_height'      => array(
				'title'          => array(
					'text' => __( 'Input height', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 10,
						'min'   => 10,
						'max'   => 200,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'is_responsive'  => true,
				'value_path'     => array( 'panel_search_box', 'input_height' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-panel-search-box-input-height',
							'value_path' => array( 'panel_search_box', 'input_height' ),
						),
					),
				),
			),
			'panel_search_box_input_width'       => array(
				'title'          => array(
					'text' => __( 'Input width', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 300,
						'min'   => 20,
						'max'   => 500,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'is_responsive'  => true,
				'value_path'     => array( 'panel_search_box', 'input_width' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'selector'   => '.brandy-live-result .brandy-search-box',
							'name'       => 'width',
							'value_path' => array( 'panel_search_box', 'input_width' ),
						),
					),
				),
			),
			'panel_searchbox_padding'            => array(
				'is_responsive'  => true,
				'value_path'     => array( 'panel_search_box', 'padding' ),
				'type'           => 'Spacing',
				'title'          => array(
					'text'         => __( 'Input padding', 'brandy' ),
					'show_devices' => true,
				),
				'default_value'  => array(
					'desktop' => array(
						'unit'           => 'rem',
						'top'            => 0.75,
						'right'          => 1.25,
						'bottom'         => 0.75,
						'left'           => 1.25,
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
							'selector'   => '.brandy-live-result .brandy-search-box',
							'name'       => 'padding',
							'value_path' => array( 'panel_search_box', 'padding' ),
						),
					),
				),
			),
			'panel_search_box_clear_icon_color'  => array(
				'title'          => array(
					'text' => __( 'Clear icon color', 'brandy' ),
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
				),
				'is_responsive'  => true,
				'value_path'     => array( 'panel_search_box', 'clear_icon', 'color' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-panel-search-box-clear-icon-color',
							'value_path' => array( 'panel_search_box', 'clear_icon', 'color' ),
						),
					),
				),
			),
			'panel_search_box_clear_icon_size'   => array(
				'title'          => array(
					'text' => __( 'Clear icon size', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'default_value'  => array(
					'desktop' => ElementsLoader::get_default_icon_size(),
					'tablet'  => null,
					'mobile'  => null,
				),
				'is_responsive'  => true,
				'value_path'     => array( 'panel_search_box', 'clear-icon', 'size' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-panel-icon-clear-icon-size',
							'value_path' => array( 'panel_search_box', 'clear-icon', 'size' ),
						),
					),
				),
			),
			'panel_search_icon_reset'            => array(
				'title'       => array(
					'text'         => __( 'Panel search icon', 'brandy' ),
					'show_devices' => true,
					'type'         => 'bold',
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'panel_search_icon' ),
				),
			),
			'panel_search_icon_color'            => array(
				'title'          => array(
					'text' => __( 'Icon color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
				'default_value'  => array(
					'normal' => array(
						'desktop' => 'var(--wp--preset--color--brandy-secondary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
					'hover'  => array(
						'desktop' => 'var(--wp--preset--color--brandy-secondary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
					'active' => array(
						'desktop' => 'var(--wp--preset--color--brandy-secondary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
				),
				'is_responsive'  => true,
				'value_path'     => array( 'panel_search_icon', 'icon_color' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-panel-icon-color',
							'value_path' => array( 'panel_search_icon', 'icon_color' ),
						),
					),
				),
			),
			'panel_search_icon_background_color' => array(
				'title'          => array(
					'text' => __( 'Background color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
				'default_value'  => array(
					'normal' => array(
						'desktop' => '#ffffff00',
						'tablet'  => null,
						'mobile'  => null,
					),
					'hover'  => array(
						'desktop' => '#ffffff00',
						'tablet'  => null,
						'mobile'  => null,
					),
					'active' => array(
						'desktop' => '#ffffff00',
						'tablet'  => null,
						'mobile'  => null,
					),
				),
				'is_responsive'  => true,
				'value_path'     => array( 'panel_search_icon', 'background_color' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-panel-icon-background-color',
							'value_path' => array( 'panel_search_icon', 'background_color' ),
						),
					),
				),
			),
			'panel_search_icon_stroke_color'     => array(
				'title'          => array(
					'text' => __( 'Stroke color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
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
				'is_responsive'  => true,
				'value_path'     => array( 'panel_search_icon', 'stroke', 'color' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-panel-icon-stroke-color',
							'value_path' => array( 'panel_search_icon', 'stroke', 'color' ),
						),
					),
				),
			),
			'panel_search_icon_stroke_width'     => array(
				'title'          => array(
					'text' => __( 'Stroke width', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 0,
						'min'   => 0,
						'max'   => 20,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'is_responsive'  => true,
				'value_path'     => array( 'panel_search_icon', 'stroke', 'width' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-panel-icon-stroke-width',
							'value_path' => array( 'panel_search_icon', 'stroke', 'width' ),
						),
					),
				),
			),
			'panel_search_icon_border_radius'    => array(
				'title'          => array(
					'text' => __( 'Border radius', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'units'          => array( 'px', '%' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 0,
						'min'   => 0,
						'max'   => 50,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'is_responsive'  => true,
				'value_path'     => array( 'panel_search_icon', 'border_radius' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-panel-icon-border-radius',
							'value_path' => array( 'panel_search_icon', 'border_radius' ),
						),
					),
				),
			),
			'panel_search_icon_size'             => array(
				'title'          => array(
					'text' => __( 'Icon size', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => ElementsLoader::get_default_icon_size(),
					'tablet'  => null,
					'mobile'  => null,
				),
				'is_responsive'  => true,
				'value_path'     => array( 'panel_search_icon', 'size' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-panel-icon-size',
							'value_path' => array( 'panel_search_icon', 'size' ),
						),
					),
				),
			),
			'panel_search_icon_padding'          => array(
				'title'          => array(
					'text' => __( 'Icon padding', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Spacing',
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'           => 'px',
						'top'            => 5,
						'right'          => 5,
						'bottom'         => 5,
						'left'           => 5,
						'is_constraints' => false,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'is_responsive'  => true,
				'value_path'     => array( 'panel_search_icon', 'padding' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'spacing',
							'selector'   => '.brandy-live-result .brandy-search-box__icon .brandy-theme-icon',
							'name'       => 'padding',
							'value_path' => array( 'panel_search_icon', 'padding' ),
						),
					),
				),
			),
			'panel_search_text_reset'            => array(
				'title'       => array(
					'text'         => __( 'Panel search text', 'brandy' ),
					'type'         => 'bold',
					'show_devices' => true,
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'panel_search_text' ),
				),
			),
			'panel_search_text_color'            => array(
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
				),
				'is_responsive'  => true,
				'value_path'     => array( 'panel_search_text', 'color' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-panel-search-text-color',
							'value_path' => array( 'panel_search_text', 'color' ),
						),
					),
				),
			),
			'panel_search_text_typography'       => array(
				'title'          => array(
					'text' => __( 'Typography', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Typography',
				'default_value'  => null,
				'is_responsive'  => true,
				'value_path'     => array( 'panel_search_text', 'typography' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'typography',
							'selector'   => '.brandy-live-result .brandy-search-box__input',
							'value_path' => array( 'panel_search_text', 'typography' ),
						),
					),
				),
			),
			'suggestion_reset'                   => array(
				'title'       => array(
					'text'         => __( 'Suggestion style', 'brandy' ),
					'show_devices' => true,
					'type'         => 'bold',
				),
				'type'        => 'Reset',
				'reset_paths' => array(
					array( 'suggestion' ),
				),
			),
			'suggestion_background_color'        => array(
				'title'          => array(
					'text' => __( 'Background color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
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
				),
				'is_responsive'  => true,
				'value_path'     => array( 'suggestion', 'background_color' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-suggestion-background-color',
							'value_path' => array( 'suggestion', 'background_color' ),
						),
					),
				),
			),
			'suggestion_text_color'              => array(
				'title'          => array(
					'text' => __( 'Text color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
				'default_value'  => array(
					'normal' => array(
						'desktop' => 'var(--wp--preset--color--brandy-secondary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
					'hover'  => array(
						'desktop' => 'var(--wp--preset--color--brandy-primary-text)',
						'tablet'  => null,
						'mobile'  => null,
					),
				),
				'is_responsive'  => true,
				'value_path'     => array( 'suggestion', 'text_color' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-suggestion-text-color',
							'value_path' => array( 'suggestion', 'text_color' ),
						),
					),
				),
			),
			'suggestion_stroke_color'            => array(
				'title'          => array(
					'text' => __( 'Stroke color', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'ColorGroup',
				'default_value'  => array(
					'normal' => array(
						'desktop' => '#000000',
						'tablet'  => null,
						'mobile'  => null,
					),
					'hover'  => array(
						'desktop' => '#000000',
						'tablet'  => null,
						'mobile'  => null,
					),
				),
				'is_responsive'  => true,
				'value_path'     => array( 'suggestion', 'stroke', 'color' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'color',
							'name'       => '--b-suggestion-stroke-color',
							'value_path' => array( 'suggestion', 'stroke', 'color' ),
						),
					),
				),
			),
			'suggestion_stroke_width'            => array(
				'title'          => array(
					'text' => __( 'Stroke width', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'units'          => array( 'px' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 0,
						'min'   => 0,
						'max'   => 20,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'is_responsive'  => true,
				'value_path'     => array( 'suggestion', 'stroke', 'width' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-suggestion-stroke-width',
							'value_path' => array( 'suggestion', 'stroke', 'width' ),
						),
					),
				),
			),
			'suggestion_border_radius'           => array(
				'title'          => array(
					'text' => __( 'Border radius', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'Dimension',
				'units'          => array( 'px', '%' ),
				'default_value'  => array(
					'desktop' => array(
						'unit'  => 'px',
						'value' => 0,
						'min'   => 0,
						'max'   => 50,
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'is_responsive'  => true,
				'value_path'     => array( 'suggestion', 'border_radius' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'dimension',
							'name'       => '--b-suggestion-border-radius',
							'value_path' => array( 'suggestion', 'border_radius' ),
						),
					),
				),
			),
			'suggestion_box_shadow'              => array(
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
							'color'  => 'rgba(0, 0, 0, 0.07)',
							'x'      => 0,
							'y'      => 5,
							'blur'   => 15,
							'spread' => 0,
						),
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'     => array( 'suggestion', 'box_shadow' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'box_shadow',
							'name'       => '--b-suggestion-box-shadow',
							'value_path' => array( 'suggestion', 'box_shadow' ),
						),
					),
				),
			),
			'suggestion_box_shadow_hover'        => array(
				'title'          => array(
					'text' => __( 'Shadow hover', 'brandy' ),
					'type' => 'normal',
				),
				'type'           => 'BoxShadow',
				'default_value'  => array(
					'desktop' => array(
						'enabled'      => true,
						'type'         => 'custom',
						'custom_value' => array(
							'color'  => '#0000001f',
							'x'      => 0,
							'y'      => 7,
							'blur'   => 25,
							'spread' => 0,
						),
					),
					'tablet'  => null,
					'mobile'  => null,
				),
				'value_path'     => array( 'suggestion', 'box_shadow_hover' ),
				'render_options' => array(
					'type' => 'variable',
					'data' => array(
						array(
							'type'       => 'box_shadow',
							'name'       => '--b-suggestion-box-shadow-hover',
							'value_path' => array( 'suggestion', 'box_shadow_hover' ),
						),
					),
				),
			),
		);
	}

	public function add_layout( $layouts = array() ) {
		$layout = array(
			'general' => array(
				'sections' => array(
					array( 'components' => array( 'search_type' ) ),
					array(
						'visible_conditions' => array(
							array(
								'value_path' => array( 'type' ),
								'operator'   => 'NOT',
								'value'      => 'icon',
							),
						),
						'components'         => array( 'placeholder' ),
					),
					array( 'components' => array( 'select_icon' ) ),
					array(
						'components' => array( 'icon_position' ),
						// 'visible_conditions' => array(
						// 	array(
						// 		'value_path' => array( 'type' ),
						// 		'value'      => 'icon',
						// 		'operator'   => 'NOT',
						// 	),
						// ),
					),
					array( 'components' => array( 'search_criteria' ) ),
					array( 'components' => array( 'live_results_enabled', 'live_results_type' ) ),
					array(
						'components'         => array( 'live_results_image' ),
						'visible_conditions' => array(
							array(
								'value_path' => array( 'live_results', 'enabled' ),
								'value'      => true,
							),
						),
					),
					array(
						'components'         => array( 'live_results_product_price' ),
						'visible_conditions' => array(
							array(
								'value_path' => array( 'live_results', 'enabled' ),
								'value'      => true,
							),
						),
					),
					array(
						'components'         => array( 'live_results_view_more' ),
						'visible_conditions' => array(
							array(
								'value_path' => array( 'live_results', 'enabled' ),
								'value'      => true,
							),
						),
					),
					array( 'components' => array( 'show_keyword_suggestions', 'suggestions' ) ),
				),
			),
			'designs' => array(
				'sections' => array(
					array(
						'components' => array(
							'search_icon_reset',
							'search_icon_color',
							'search_icon_background_color',
							'search_icon_stroke_color',
							'search_icon_stroke_width',
							'search_icon_border_radius',
							'search_icon_size',
							'search_icon_padding',
						),
					),
					array(
						'components'         => array(
							'search_text_reset',
							'search_text_color',
							'search_text_typography',
						),
						'visible_conditions' => array(
							array(
								'value_path' => array( 'type' ),
								'value'      => 'icon',
								'operator'   => 'NOT',
							),
						),
					),
					array(
						'components'         => array(
							'search_box_reset',
							'search_box_background_color',
							'search_box_stroke_color',
							'search_box_stroke_width',
							'search_box_border_radius',
							'search_box_input_height',
							'search_box_input_width',
							'searchbox_padding',
							// 'search_box_clear_icon_color',
							// 'search_box_clear_icon_size',
						),
						'visible_conditions' => array(
							array(
								'value_path' => array( 'type' ),
								'value'      => 'icon',
								'operator'   => 'NOT',
							),
						),
					),
					array(
						'components' => array(
							'panel_reset',
							'panel_background',
							'panel_backdrop',
						),
					),
					array(
						'components' => array(
							'panel_search_box_reset',
							'panel_search_box_background_color',
							'panel_search_box_stroke_color',
							'panel_search_box_stroke_width',
							'panel_search_box_border_radius',
							'panel_search_box_input_height',
							'panel_search_box_input_width',
							'panel_searchbox_padding',
							// 'panel_search_box_clear_icon_color',
							// 'panel_search_box_clear_icon_size',
						),
					),
					array(
						'components' => array(
							'panel_search_icon_reset',
							'panel_search_icon_color',
							'panel_search_icon_background_color',
							'panel_search_icon_stroke_color',
							'panel_search_icon_stroke_width',
							'panel_search_icon_border_radius',
							'panel_search_icon_size',
							'panel_search_icon_padding',
							'panel_search_text_reset',
							'panel_search_text_color',
							'panel_search_text_typography',
						),
					),
					array(
						'components' => array(
							'icon_close_panel_reset',
							'icon_close_panel_color',
							// 'icon_close_panel_background',
							// 'icon_close_panel_stroke_color',
							// 'icon_close_panel_stroke_width',
							// 'icon_close_panel_border_radius',
							'icon_close_panel_size',
						),
					),
					array(
						'components' => array(
							'suggestion_reset',
							'suggestion_background_color',
							'suggestion_text_color',
							'suggestion_stroke_color',
							'suggestion_stroke_width',
							'suggestion_border_radius',
							'suggestion_box_shadow',
							'suggestion_box_shadow_hover',
						),
					),
					array(
						'components' => array(
							'margin',
						),
					),
				),
			),
		);
		$mapped_layout                = $this->map_layout( $layout );
		$layouts[ $this->element_id ] = $mapped_layout;
		return $layouts;
	}

	public function add_localize_data( $localize_data ) {
		$icons = array();
		$dir   = new \DirectoryIterator( self::$path_to_icons );
		$dirs  = array();
		foreach ( $dir as $fileinfo ) {
			if ( ! $fileinfo->isDot() ) {
				$dirs[] = $fileinfo->getFilename();
			}
		}
		usort(
			$dirs,
			function( $a, $b ) {
				return strcmp( $a, $b );
			}
		);
		foreach ( $dirs as $file_name ) {
			$file_path = self::$path_to_icons . $file_name;
			$icon_name = basename( $file_name, '.php' );
			ob_start();
			require $file_path;
			$icon_data = ob_get_contents();
			ob_end_clean();
			$icons[ $icon_name ] = $icon_data;
		}
		$localize_data['icons']['search'] = $icons;
		return $localize_data;
	}

	public static function get_icon( $icon_type ) {
		$file_path = self::$path_to_icons . "$icon_type.php";
		if ( file_exists( $file_path ) ) {
			ob_start();
			require $file_path;
			$icon_data = ob_get_contents();
			ob_end_clean();
			return $icon_data;
		}
		return '';
	}

}
